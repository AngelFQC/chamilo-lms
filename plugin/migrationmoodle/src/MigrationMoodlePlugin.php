<?php
/* For licensing terms, see /license.txt */

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class MigrationMoodlePlugin.
 */
class MigrationMoodlePlugin extends Plugin
{
    public $isAdminPlugin = true;

    /**
     * MigrationMoodlePlugin constructor.
     */
    protected function __construct()
    {
        $version = '0.0.1';
        $author = 'Angel Fernando Quiroz Campos';
        $settings = [];

        parent::__construct($version, $author, $settings);
    }

    /**
     * @return MigrationMoodlePlugin|null
     */
    public static function create()
    {
        static $result = null;

        return $result ? $result : $result = new self();
    }

    /**
     * @return Connection
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getConnection(): Connection
    {
        $params = [
            'host' => 'localhost', //$this->get('db_host'),
            'user' => 'moodle', // $this->get('db_user'),
            'password' => 'moodle', // $this->get('db_password'),
            'dbname' => 'moodle', // $this->get('db_name'),
            'driver' => 'pdo_mysql',
        ];

        $connection = DriverManager::getConnection($params, new Configuration());

        return $connection;
    }
}
