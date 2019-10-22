<?php
/* For licensing terms, see /license.txt */

use Chamilo\CoreBundle\Framework\Container;
use Chamilo\CoreBundle\Hook\CheckLoginCredentialsHook;
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
        $settings = [
            'active' => 'boolean',
            'host' => 'text',
            'user' => 'text',
            'password' => 'text',
            'dbname' => 'moodle',
        ];

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
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return Connection
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

    /**
     * Perform actions after configure the plugin.
     *
     * Add user extra field.
     *
     * @return MigrationMoodlePlugin
     */
    public function performActionsAfterConfigure()
    {
        UserManager::create_extra_field(
            'moodle_password',
            ExtraField::FIELD_TYPE_TEXT,
            $this->get_lang('MoodlePassword'),
            ''
        );

        $hook = Container::$container->get('chamilo_core.hook_factory')->build(CheckLoginCredentialsHook::class);
        $hookObserver = MigrationMoodleCheckLoginCredentialsHook::create();

        if ('true' === $this->get('active')) {
            $hook->attach($hookObserver);
        } else {
            $hook->detach($hookObserver);
        }

        return $this;
    }
}
