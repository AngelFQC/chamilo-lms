<?php
/* For licensing terms, see /license.txt */

require_once '../../main/inc/global.inc.php';

require_once __DIR__.'/vendor/simplesaml/lib/_autoload.php';

$as = new SimpleSAML_Auth_Simple('default-sp');

$isAuthenticated = $as->isAuthenticated();

if (!$isAuthenticated) {
    $as->login([
        'saml:idp' => 'http://chamilo111x.dev'
    ]);
} else {
    $attributes = $as->getAttributes();
}
