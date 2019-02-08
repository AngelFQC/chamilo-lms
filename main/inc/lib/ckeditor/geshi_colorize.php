<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../../global.inc.php';

$jsonString = file_get_contents('php://input');
$jsonObject = json_decode($jsonString);

$geshi = new GeSHi($jsonObject->html, $jsonObject->lang);

echo $geshi->parse_code();
