<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Survey form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
	array('Toolbarswitch'),
	array('Link','Unlink'),
	array('Image'),
	array('Table'),
	array('FontSize'),
	array('Bold','Italic'),
	array('NumberedList','BulletedList','-','TextColor'),
	array('Source')
);
?>

CKEDITOR.editorConfig = function(config) {
config.extraPlugins = '<?php echo implode(',', $extraPlugins) ?>';
config.toolbar_Basic = <?php echo json_encode($toolbarBasic) ?>;
config.toolbar = 'Basic';
config.smallToolbar = 'Basic';
config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

}
