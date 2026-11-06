<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\Command;

use Chamilo\CoreBundle\Entity\User;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Identity now resolves by the immutable Azure object id, which older accounts never
 * stored: they were linked by email or by mailNickname while update_users was off, and
 * that path returned before writing the extra fields. Matching them again by those
 * mutable claims is only safe away from a login, where the claims come from the
 * directory listing instead of a token, so an administrator runs it here once.
 */
#[AsCommand(
    name: 'app:azure-backfill-user-uid',
    description: 'Store the Azure object id of accounts that were linked before it became the decisive match',
)]
class AzureBackfillUserUidCommand extends AzureSyncAbstractCommand
{
    protected function configure(): void
    {
        $this->addOption(
            'dry-run',
            null,
            InputOption::VALUE_NONE,
            'Report what would change and write nothing'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dryRun = (bool) $input->getOption('dry-run');

        $io->title('Backfilling the Azure object id of existing accounts.');

        if ($dryRun) {
            $io->note('Dry run. Nothing is written.');
        }

        $this->warnWhenLoginIgnoresTheObjectId($io);

        $stored = 0;
        $alreadyStored = 0;
        $withoutAccount = 0;
        $conflicts = [];

        /** @var array<int, string> $uidByUserId */
        $uidByUserId = [];

        try {
            // The whole directory, and never the delta link: a partial read would leave
            // accounts unbound, and consuming the link would break the incremental sync.
            foreach ($this->getAzureUsers(false) as $azureUserInfo) {
                $azureUid = (string) ($azureUserInfo['id'] ?? '');

                if ('' === $azureUid) {
                    $conflicts[] = \sprintf(
                        'The directory reports no object id for "%s".',
                        (string) ($azureUserInfo['userPrincipalName'] ?? 'an unnamed account')
                    );

                    continue;
                }

                $user = $this->azureHelper->findUserByMutableClaimsForBackfill($azureUserInfo);

                if (!$user instanceof User) {
                    ++$withoutAccount;

                    continue;
                }

                $userId = (int) $user->getId();
                $storedUid = (string) $this->azureHelper->getStoredAzureUid($user);

                if ('' !== $storedUid) {
                    if ($storedUid === $azureUid) {
                        ++$alreadyStored;
                    } else {
                        $conflicts[] = \sprintf(
                            'User %d ("%s") holds the object id %s, but the directory reports %s. Left untouched.',
                            $userId,
                            $user->getUsername(),
                            $storedUid,
                            $azureUid
                        );
                    }

                    continue;
                }

                if (isset($uidByUserId[$userId])) {
                    $conflicts[] = \sprintf(
                        'The object ids %s and %s both resolve to user %d ("%s"). Left untouched.',
                        $uidByUserId[$userId],
                        $azureUid,
                        $userId,
                        $user->getUsername()
                    );

                    continue;
                }

                $uidByUserId[$userId] = $azureUid;
                ++$stored;

                if (!$dryRun) {
                    $this->azureHelper->bindAzureUid($user, $azureUid);
                }

                $io->text(
                    \sprintf('User %d ("%s") takes the object id %s.', $userId, $user->getUsername(), $azureUid)
                );
            }
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::INVALID;
        }

        $io->section('Summary');
        $io->table(
            ['Result', 'Accounts'],
            [
                [$dryRun ? 'Object id to store' : 'Object id stored', $stored],
                ['Object id already stored', $alreadyStored],
                ['No matching Chamilo account', $withoutAccount],
                ['Needs a manual decision', \count($conflicts)],
            ]
        );

        if ([] !== $conflicts) {
            $io->warning('Some accounts need a manual decision. This command changed none of them.');
            $io->listing($conflicts);

            return Command::FAILURE;
        }

        $io->success('Every account the directory reports is bound to its Azure object id.');

        return Command::SUCCESS;
    }

    /**
     * On a multi-tenant portal only the object id may resolve identity, so a verification
     * order that leaves out position 3 denies every login whatever this command stores.
     */
    private function warnWhenLoginIgnoresTheObjectId(SymfonyStyle $io): void
    {
        if ($this->azureHelper->isSingleTenant()) {
            return;
        }

        if (!\in_array(3, $this->azureHelper->getExistingUserVerificationOrder(), true)) {
            $io->warning(
                'This portal accepts any tenant, and the setting existing_user_verification_order '
                .'leaves out the object id (position 3). Add it, or no account matches on login.'
            );
        }
    }
}
