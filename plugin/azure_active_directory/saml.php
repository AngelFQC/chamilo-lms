<?php
/* For licensing terms, see /license.txt */

require_once '../../main/inc/global.inc.php';
require_once __DIR__.'/../../main/auth/external_login/functions.inc.php';
require_once __DIR__.'/vendor/simplesaml/lib/_autoload.php';

define('SCHEMA_EMAIL', 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name');
define('SCHEMA_FIRSTNAME', 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname');
define('SCHEMA_LASTNAME', 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname');
define('SCHEMA_COMPLETE_NAME', 'http://schemas.microsoft.com/identity/claims/displayname');

$as = new SimpleSAML_Auth_Simple('default-sp');

$as->requireAuth();
$attributes = $as->getAttributes();

if (!$attributes) {
    header('Location: '.api_get_path(WEB_PATH).'index.php?logout=logout');
    exit;
}

$userInfo = api_get_user_info_from_email($attributes[SCHEMA_EMAIL][0]);
$_user = [];

if ($userInfo === false) {
    $uniqId = uniqid();
    $platformLanguage = api_get_setting('platformLanguage');

    $u = [
        'firstname' => $attributes[SCHEMA_FIRSTNAME][0],
        'lastname' => $attributes[SCHEMA_LASTNAME][0],
        'username' => $attributes[SCHEMA_EMAIL][0],
        'email' => $attributes[SCHEMA_EMAIL][0],
        'password' => sha1('azure_active_directory_'.$uniqId),
        'status' => STUDENT,
        'auth_source' => 'azure_active_directory saml',
        'extra' => array(),
        'language' => $platformLanguage,
    ];
    // we have to create the user
    $userId = external_add_user($u);
    $_user['status'] = STUDENT;
} else {
    // User already exists, login
    $userId = $userInfo['user_id'];
    $_user['status'] = (int) $userInfo['status'];
}

if ($userId != false) {
    $_user['user_id'] = $userId;
    $_user['uidReset'] = true;

    ChamiloSession::start(true);

    ChamiloSession::write('_user', $_user);
}

header('Location: '.api_get_path(WEB_PATH));
