<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../../main/inc/global.inc.php';

$userEtl = new UserETL();

try {
    $userEtl->execute();
} catch (Exception $exception) {
    echo '<pre>'.$exception->getMessage().'</pre>';
}
