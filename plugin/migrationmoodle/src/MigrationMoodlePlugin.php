<?php
/* For licensing terms, see /license.txt */

use Chamilo\CoreBundle\Framework\Container;
use Chamilo\CoreBundle\Hook\CheckLoginCredentialsHook;
use Chamilo\CoreBundle\Hook\Interfaces\HookPluginInterface;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class MigrationMoodlePlugin.
 */
class MigrationMoodlePlugin extends Plugin implements HookPluginInterface
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
     * @throws Exception
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

        if ('true' === $this->get('active')) {
            $this->installHook();
        } else {
            $this->uninstallHook();
        }

        return $this;
    }

    /**
     * This method will call the Hook management insertHook to add Hook observer from this plugin.
     *
     * @throws Exception
     *
     * @return void
     */
    public function installHook()
    {
        $hookObserver = MigrationMoodleCheckLoginCredentialsHook::create();

        Container::$container
            ->get('chamilo_core.hook_factory')
            ->build(CheckLoginCredentialsHook::class)
            ->attach($hookObserver);
    }

    /**
     * This method will call the Hook management deleteHook to disable Hook observer from this plugin.
     *
     * @throws Exception
     *
     * @return void
     */
    public function uninstallHook()
    {
        $hookObserver = MigrationMoodleCheckLoginCredentialsHook::create();

        Container::$container
            ->get('chamilo_core.hook_factory')
            ->build(CheckLoginCredentialsHook::class)
            ->attach($hookObserver);
    }
}
