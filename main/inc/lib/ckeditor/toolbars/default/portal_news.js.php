<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Portal News form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
	array('Save','Toolbarswitch','PasteFromWord','-','Undo','Redo'),
    array('Link','Unlink','Anchor'),
    array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex'),
    array('Table','SpecialChar'),
    array('NumberedList','BulletedList','-','Outdent','Indent','-','TextColor','BGColor','-','Source'),
    '/',
    array('Styles','Format','Font','FontSize'),
    array('Bold','Italic','Underline'),
    array('JustifyLeft','JustifyCenter','JustifyRight')
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