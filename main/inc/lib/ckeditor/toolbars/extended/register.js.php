<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Register form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
	array('Toolbarswitch','-','PasteFromWord','-','Undo','Redo'),
	array('Font','FontSize'),
	array('Bold','Italic','Underline'),
	array('JustifyLeft','JustifyCenter','-','NumberedList','BulletedList','-','TextColor','BGColor')
);

// This is the visible toolbar set when the editor is maximized.
// If it has not been defined, then the toolbar set for the "normal" size is used.

$toolbarFull = array(
	array('Toolbarswitch','-','PasteFromWord','-','Undo','Redo'),
	array('Font','FontSize'),
	array('Bold','Italic','Underline'),
	array('JustifyLeft','JustifyCenter','-','NumberedList','BulletedList','-','TextColor','BGColor')
);

$config['ToolbarStartExpanded'] = false;
?>

CKEDITOR.editorConfig = function(config) {
config.extraPlugins = '<?php echo implode(',', $extraPlugins) ?>';
config.toolbar_Basic = <?php echo json_encode($toolbarBasic) ?>;
config.toolbar_Full = <?php echo json_encode($toolbarFull) ?>;
config.toolbar = 'Basic';
config.smallToolbar = 'Basic';
config.maximizedToolbar = 'Full';
config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

}
