<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../../../main/inc/global.inc.php';

require_once __DIR__.'/config.php';

$migrate = new BgoMigration($adminId, $oldPortalPath);
$migrate->connectDB($dbHost, $dbName, $dbUser, $dbPass);

echo 'Migrating course categories:'.PHP_EOL;
$migrate->migrateCoursesCategories();
echo '----'.PHP_EOL;

echo 'Migrating courses:'.PHP_EOL;
$migrate->migrateCourses();
echo '----'.PHP_EOL;
