<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Portal Home Page form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
	array('NewPage','Templates','Save','Print','PageBreak','Toolbarswitch','-','PasteFromWord','-','Undo','Redo','-','SelectAll','-','Find'),
	array('Link','Unlink','Anchor'),
	array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex'),
	array('Table','Smiley','SpecialChar','googlemaps'),
	'/',
	array('Format','Font','FontSize'),
	array('Bold','Italic','Underline'),
	array('JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','-','Outdent','Indent','-','TextColor','BGColor'),
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
