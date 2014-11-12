<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Test Category form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
    array('Styles', 'Format', 'Font', 'FontSize'),
    '/',
    array('Bold', 'Italic', 'Underline'),
    array('SpecialChar', 'mimetex'),
    array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'TextColor', 'BGColor'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Source')
);
?>
