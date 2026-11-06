<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\Tests\CoreBundle\Helpers;

use Chamilo\CoreBundle\Entity\ExtraField;
use Chamilo\CoreBundle\Entity\ExtraFieldValues;
use Chamilo\CoreBundle\Entity\User;
use Chamilo\CoreBundle\Helpers\AzureAuthenticatorHelper;
use Chamilo\CoreBundle\Repository\ExtraFieldRepository;
use Chamilo\CoreBundle\Repository\ExtraFieldValuesRepository;
use Chamilo\CoreBundle\Repository\Node\UserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

/**
 * The Azure login resolves which local account it maps to. Email and mailNickname are
 * token-asserted, mutable and unverified in a multi-tenant app, so they may only decide
 * identity when the app is pinned to one tenant. In multi-tenant mode only the immutable
 * object id (azure_uid) may match, otherwise a foreign tenant could assert a victim's
 * address and take over the account (nOAuth).
 */
final class AzureAuthenticatorHelperTest extends TestCase
{
    /**
     * @dataProvider tenantProvider
     */
    public function testIsSingleTenant(?string $tenant, bool $expected): void
    {
        $helper = $this->makeHelper(['tenant' => $tenant], static function (): void {});

        self::assertSame($expected, $helper->isSingleTenant());
    }

    /**
     * @return iterable<string, array{?string, bool}>
     */
    public static function tenantProvider(): iterable
    {
        yield 'specific guid' => ['11111111-1111-1111-1111-111111111111', true];

        yield 'verified domain' => ['contoso.com', true];

        yield 'common' => ['common', false];

        yield 'organizations' => ['organizations', false];

        yield 'consumers' => ['consumers', false];

        yield 'empty' => ['', false];

        yield 'null' => [null, false];
    }

    public function testMultiTenantIgnoresEmailAndDoesNotFallBack(): void
    {
        $victim = $this->activeUser(42);

        $emailMatch = $this->extraFieldValue(42);

        $helper = $this->makeHelper(
            ['tenant' => 'common', 'existing_user_verification_order' => '1,2,3'],
            function (
                ExtraFieldRepository $extraFieldRepo,
                ExtraFieldValuesRepository $valuesRepo,
                UserRepository $userRepo
            ) use ($victim, $emailMatch): void {
                [$emailField, $idField, $uidField] = $this->fieldMocks($extraFieldRepo);

                // The victim would match by email, but the azure_uid holds nobody.
                $valuesRepo->method('findByVariableAndValue')->willReturnCallback(
                    static fn (ExtraField $field, int|string|null $value): array => $field === $emailField
                        ? [$emailMatch]
                        : []
                );
                $userRepo->method('find')->willReturn($victim);

                // The email / userPrincipalName fallback must never run in multi-tenant mode.
                $userRepo->expects(self::never())->method('findByEmailCaseInsensitive');
                $userRepo->expects(self::never())->method('findByUsernameCaseInsensitive');
            }
        );

        $result = $helper->getUserByVerificationOrder([
            'mail' => 'victim@contoso.com',
            'mailNickname' => 'victim',
            'id' => 'attacker-object-id',
            'userPrincipalName' => 'victim@contoso.com',
        ]);

        self::assertNull($result, 'A multi-tenant login must not match a victim by a token-asserted claim.');
    }

    public function testSingleTenantHonoursConfiguredEmailOrder(): void
    {
        $victim = $this->activeUser(42);

        $emailMatch = $this->extraFieldValue(42);

        $helper = $this->makeHelper(
            ['tenant' => 'contoso.com', 'existing_user_verification_order' => '1'],
            function (
                ExtraFieldRepository $extraFieldRepo,
                ExtraFieldValuesRepository $valuesRepo,
                UserRepository $userRepo
            ) use ($victim, $emailMatch): void {
                [$emailField] = $this->fieldMocks($extraFieldRepo);

                $valuesRepo->method('findByVariableAndValue')->willReturnCallback(
                    static fn (ExtraField $field, int|string|null $value): array => $field === $emailField
                        ? [$emailMatch]
                        : []
                );
                $userRepo->method('find')->with(42)->willReturn($victim);
            }
        );

        $result = $helper->getUserByVerificationOrder([
            'mail' => 'user@contoso.com',
            'mailNickname' => 'user',
            'id' => 'object-id',
            'userPrincipalName' => 'user@contoso.com',
        ]);

        self::assertSame($victim, $result, 'A single-tenant login keeps the configurable email match.');
    }

    /**
     * The backfill reads the claims from the directory listing, which the administrator
     * queries, and not from a token an attacker can forge. It therefore keeps the old
     * matching even on a multi-tenant portal, which is what lets it store the azure_uid
     * that older accounts never got. The login path above must stay the strict one.
     */
    public function testBackfillKeepsMutableClaimMatchingWhenMultiTenant(): void
    {
        $user = $this->activeUser(42);

        $emailMatch = $this->extraFieldValue(42);

        $helper = $this->makeHelper(
            ['tenant' => 'common', 'existing_user_verification_order' => '1,2,3'],
            function (
                ExtraFieldRepository $extraFieldRepo,
                ExtraFieldValuesRepository $valuesRepo,
                UserRepository $userRepo
            ) use ($user, $emailMatch): void {
                [$emailField] = $this->fieldMocks($extraFieldRepo);

                $valuesRepo->method('findByVariableAndValue')->willReturnCallback(
                    static fn (ExtraField $field, int|string|null $value): array => $field === $emailField
                        ? [$emailMatch]
                        : []
                );
                $userRepo->method('find')->with(42)->willReturn($user);
            }
        );

        $result = $helper->findUserByMutableClaimsForBackfill([
            'mail' => 'user@contoso.com',
            'mailNickname' => 'user',
            'id' => 'object-id',
            'userPrincipalName' => 'user@contoso.com',
        ]);

        self::assertSame($user, $result, 'The backfill must still reach the account the email used to match.');
    }

    /**
     * The collaborator helpers are `readonly` and cannot be doubled, and the tested methods
     * only read the two extra-field repositories, the user repository and providerParams,
     * so the helper is built without its constructor and only those are injected.
     *
     * @param array<string, mixed> $providerParams
     */
    private function makeHelper(array $providerParams, callable $configure): AzureAuthenticatorHelper
    {
        $extraFieldRepo = $this->createMock(ExtraFieldRepository::class);
        $valuesRepo = $this->createMock(ExtraFieldValuesRepository::class);
        $userRepo = $this->createMock(UserRepository::class);

        $configure($extraFieldRepo, $valuesRepo, $userRepo);

        $helper = (new ReflectionClass(AzureAuthenticatorHelper::class))->newInstanceWithoutConstructor();
        $this->setProperty($helper, 'extraFieldRepo', $extraFieldRepo);
        $this->setProperty($helper, 'extraFieldValuesRepo', $valuesRepo);
        $this->setProperty($helper, 'userRepository', $userRepo);
        $this->setProperty($helper, 'providerParams', $providerParams);

        return $helper;
    }

    private function setProperty(object $object, string $name, mixed $value): void
    {
        $property = new ReflectionProperty($object, $name);
        $property->setValue($object, $value);
    }

    /**
     * @return array{ExtraField, ExtraField, ExtraField}
     */
    private function fieldMocks(ExtraFieldRepository $extraFieldRepo): array
    {
        $emailField = $this->createMock(ExtraField::class);
        $idField = $this->createMock(ExtraField::class);
        $uidField = $this->createMock(ExtraField::class);

        $extraFieldRepo->method('findByVariable')->willReturnCallback(
            static fn (int $type, string $variable): ExtraField => match ($variable) {
                AzureAuthenticatorHelper::EXTRA_FIELD_ORGANISATION_EMAIL => $emailField,
                AzureAuthenticatorHelper::EXTRA_FIELD_AZURE_ID => $idField,
                AzureAuthenticatorHelper::EXTRA_FIELD_AZURE_UID => $uidField,
                default => $emailField,
            }
        );

        return [$emailField, $idField, $uidField];
    }

    private function activeUser(int $id): User
    {
        $user = $this->createMock(User::class);
        $user->method('getActive')->willReturn(User::ACTIVE);
        $user->method('getId')->willReturn($id);

        return $user;
    }

    private function extraFieldValue(int $itemId): ExtraFieldValues
    {
        $efv = $this->createStub(ExtraFieldValues::class);
        $efv->method('getItemId')->willReturn($itemId);

        return $efv;
    }
}
