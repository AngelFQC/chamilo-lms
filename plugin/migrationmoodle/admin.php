<?php
/* For licensing terms, see /license.txt */

use Chamilo\PluginBundle\MigrationMoodle\Task\CourseCategoriesTask;
use Chamilo\PluginBundle\MigrationMoodle\Task\UsersTask;

require_once __DIR__.'/../../main/inc/global.inc.php';

$action = $_GET['action'] ?? '';

$selfUrl = api_get_self();

$actionNames = [
    'users' => 'Users',
    'course_categories' => 'Course categories',
];

foreach ($actionNames as $actionName => $actionTitle) {
    echo '<p>';
    echo '<a href="'.$selfUrl.'?action='.$actionName.'">'.$actionTitle.'</a>';
    echo '</p>';
}

if (!empty($action)) {
    echo '<h3>'.$actionNames[$action].'</h3>';

    switch ($action) {
        case 'users':
            $usersMigration = new UsersTask();
            $usersMigration->execute();
            break;
        case 'course_categories':
            $courseCategoriesMigration = new CourseCategoriesTask();
            $courseCategoriesMigration->execute();
            break;
    }
}



