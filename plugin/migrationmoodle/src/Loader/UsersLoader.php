<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Loader;

use Chamilo\CoreBundle\Framework\Container;
use Chamilo\PluginBundle\MigrationMoodle\Interfaces\LoaderInterface;
use Chamilo\UserBundle\Entity\User;

/**
 * Class UsersLoader.
 */
class UsersLoader implements LoaderInterface
{
    /**
     * @param array $incomingData
     */
    public function load(array $incomingData): void
    {
        $manager = Container::getUserManager();

        /** @var User $user */
        $user = $manager->createUser();
        $user
            ->setLastname($incomingData['lastname'])
            ->setFirstname($incomingData['firstname'])
            ->setUsername($incomingData['username'])
            ->setStatus($incomingData['status'])
            ->setPlainPassword(md5(time()))
            ->setEmail($incomingData['email'])
            ->setOfficialCode('')
            ->setPictureUri('')
            ->setCreatorId(1)
            ->setAuthSource($incomingData['auth_source'])
            ->setPhone($incomingData['phone'])
            ->setAddress($incomingData['address'])
            ->setLanguage($incomingData['language'])
            ->setRegistrationDate($incomingData['registration_date'])
            ->setHrDeptId(0)
            ->setActive($incomingData['active'])
            ->setEnabled($incomingData['enabled'])
        ;

        $manager->updateUser($user);

        \UserManager::update_extra_field_value($user->getId(), 'moodle_password', $incomingData['plain_password']);
    }
}
