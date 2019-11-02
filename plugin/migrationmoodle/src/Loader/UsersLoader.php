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
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return int
     */
    public function load(array $incomingData): int
    {
        $userId = \UserManager::create_user(
            $incomingData['firstname'],
            $incomingData['lastname'],
            $incomingData['status'],
            $incomingData['email'],
            $incomingData['username'],
            md5(time()),
            '',
            $incomingData['language'],
            $incomingData['phone'],
            null,
            $incomingData['auth_source'],
            null,
            $incomingData['active'],
            0,
            [],
            null,
            false,
            false,
            $incomingData['address'],
            false,
            null,
            0,
            []
        );

        /** @var User $user */
        $user = Container::getUserManager()->find($userId);
        $user->setRegistrationDate($incomingData['registration_date']);

        Container::getEntityManager()->persist($user);
        Container::getEntityManager()->flush();

        \UserManager::update_extra_field_value($user->getId(), 'moodle_password', $incomingData['plain_password']);

        return $user->getId();
    }
}
