<?php
/* For licensing terms, see /license.txt */

use Chamilo\PluginBundle\MigrationMoodle\Task\UsersTask;

require_once __DIR__.'/../../main/inc/global.inc.php';

$usersMigration = new UsersTask();
$usersMigration->execute();
