<?php
/* For licensing terms, see /license.txt */

use Chamilo\CoreBundle\Entity\ExtraField;
use Chamilo\CoreBundle\Entity\ExtraFieldValues;
use Chamilo\CoreBundle\Hook\HookObserver;
use Chamilo\CoreBundle\Hook\Interfaces\CheckLoginCredentialsHookEventInterface;
use Chamilo\CoreBundle\Hook\Interfaces\CheckLoginCredentialsHookObserverInterface;
use Chamilo\UserBundle\Entity\User;

/**
 * Class MigrationMoodleCheckLoginCredentialsHook.
 */
class MigrationMoodleCheckLoginCredentialsHook extends HookObserver implements CheckLoginCredentialsHookObserverInterface
{
    private $entityManager;

    /**
     * MigrationMoodleCheckLoginCredentialsHook constructor.
     */
    protected function __construct()
    {
        parent::__construct(
            'plugin/migrationmoodle/src/MigrationMoodlePlugin.php',
            'MigrationMoodleCheckLoginCredentialsHook'
        );
    }

    /**
     * @param CheckLoginCredentialsHookEventInterface $event
     *
     * @return bool
     */
    public function checkLoginCredentials(CheckLoginCredentialsHookEventInterface $event): bool
    {
        $this->entityManager = $event->getEntityManager();

        $user = $event->getEventData()['user'];
        $credentials = $event->getEventData()['credentials'];

        $extraField = $this->getExtraField();

        if (empty($extraField)) {
            return false;
        }

        $fieldValue = $this->getExtraFieldValue($extraField, $user);

        if (empty($fieldValue)) {
            return false;
        }

        $isPasswordVerified = password_verify(
            $credentials['_password'],
            $fieldValue->getValue()
        );

        if (!$isPasswordVerified) {
            return false;
        }

        return true;
    }

    /**
     * @return ExtraField|null
     */
    private function getExtraField(): ? ExtraField
    {
        return $this
            ->entityManager
            ->getRepository('ChamiloCoreBundle:ExtraField')
            ->findOneBy(
                [
                    'variable' => 'moodle_password',
                    'extraFieldType' => ExtraField::USER_FIELD_TYPE,
                ]
            );
    }

    /**
     * @param ExtraField $extraField
     * @param User       $user
     *
     * @return ExtraFieldValues|null
     */
    private function getExtraFieldValue(ExtraField $extraField, User $user): ? ExtraFieldValues
    {
        return $this
            ->entityManager
            ->getRepository('ChamiloCoreBundle:ExtraFieldValues')
            ->findOneBy(['field' => $extraField, 'itemId' => $user->getId()]);
    }
}
