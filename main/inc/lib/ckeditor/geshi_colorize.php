<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../../global.inc.php';

$userId = api_get_user_id();

if (empty($userId)) {
    api_not_allowed(false);
}

$jsonString = file_get_contents('php://input');
$jsonObject = json_decode($jsonString);

$geshi = new GeSHi($jsonObject->html, $jsonObject->lang);

echo $geshi->parse_code();
