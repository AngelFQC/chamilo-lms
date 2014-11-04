<?php
/* For licensing terms, see /license.txt */
/**
 * Add templates to CKEditor
 */
// Setting the encoding to UTF-8.
header('Content-Type: application/x-javascript');

// Name of the language file that needs to be included.
$language_file = 'document';

require_once '../../../../../global.inc.php';
require_once './ParserTemplates.class.php';

$parseTemplates = new ParserTemplates();

// Setting templates for teachers or for students
$is_allowed_to_edit = api_is_allowed_to_edit(false, true);

$parseTemplates->loadEmptyTemplate();

if ($is_allowed_to_edit) {
    $parseTemplates->loadPlatformTemplates();
} else {
    $parseTemplates->loadStudentTemplates();
}

$parseTemplates->loadPersonalTemplates(api_get_user_id());
?>

CKEDITOR.addTemplates('default', {
    imagesPath: '<?php echo api_get_path(WEB_PATH) ?>',
    templates: <?php echo json_encode($parseTemplates->getTemplates()); ?>
});