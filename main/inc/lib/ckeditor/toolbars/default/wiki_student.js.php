<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Wiki Student form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';


$extraPlugins = array(
    'toolbarswitch',
);

$toolbarBasic = array(
	array('Toolbarswitch','Save','NewPage','PageBreak','Preview','-','PasteText','-','Undo','Redo','-','SelectAll','-','Find'),
	array('Wikilink','Link','Unlink','Anchor'),
	array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'),
	array('Table','HorizontalRule','Smiley','SpecialChar','googlemaps'),
	array('Format','Font','FontSize'),
	array('Bold','Italic','Underline'),
	array('Subscript','Superscript','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','-','Outdent','Indent','-','TextColor','BGColor'),
	array('ShowBlocks')
);

if ((api_get_setting('force_wiki_paste_as_plain_text') == 'true')) {
	$config['ForcePasteAsPlainText'] = true;
}
else{
	$config['ForcePasteAsPlainText'] = false;
}
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