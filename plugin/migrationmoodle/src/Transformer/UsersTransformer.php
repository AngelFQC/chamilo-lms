<?php
/* For licensing terms, see /license.txt */

use Chamilo\UserBundle\Entity\User;
use Doctrine\DBAL\FetchMode;

/**
 * Class UsersTransformer.
 */
class UsersTransformer extends BaseTransformer implements TransformerInterface
{
    /**
     * @return array
     */
    public function mapProperties(): array
    {
        return [
            'lastname' => 'lastname',
            'firstname' => 'firstname',
            'email' => 'email',
            'username' => 'username',
            'plain_password' => 'password',
            'language' => 'lang',
            'phone' => 'phone1',
            'address' => 'address',
            'auth_source' => 'auth',
            'registration_date' => 'timecreated',
            'status' => ['id', 'generateStatus'],
        ];
    }

    /**
     * @param string $auth
     *
     * @return string
     */
    protected function transformAuth(string $auth)
    {
        return $auth === 'manual' ? 'platform' : $auth;
    }

    /**
     * @param int $timeCreated
     *
     * @throws Exception
     *
     * @return DateTime
     */
    protected function transformTimecreated(int $timeCreated)
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));
        $date->setTimestamp($timeCreated);

        return $date;
    }

    /**
     * @todo Add more detail in roles conversion.
     *
     * @param int $id
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return int
     */
    protected function generateStatus(int $id)
    {
        $plugin = MigrationMoodlePlugin::create();

        $connection = $plugin->getConnection();

        $statement = $connection->executeQuery(
            "SELECT count(ra.id) c
                FROM mdl_role_assignments ra
                INNER JOIN mdl_role r ON ra.roleid = r.id
                WHERE ra.userid = ? AND r.archetype IN ('teacher', 'editingteacher', 'coursecreator')",
            [$id]
        );
        $result = $statement->fetch(FetchMode::ASSOCIATIVE);

        $connection->close();

        return (int) $result['c'] !== 0 ? User::TEACHER : User::STUDENT;
    }
}
