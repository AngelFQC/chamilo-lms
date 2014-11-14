<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Wiki form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

// Hide/show SpellCheck button
if ((api_get_setting('allow_spellcheck') == 'true')) {
	$VSpellCheck='Scayt';
}
else{
	$VSpellCheck='';	
}

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
	array('Toolbarswitch','Save','NewPage','Templates','PageBreak','Preview','-','PasteText','-','Undo','Redo','-','SelectAll','-','Find'),
	array('Wikilink','Link','Unlink','Anchor'),
	array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'),
	array('Table','HorizontalRule','Smiley','SpecialChar','googlemaps'),
	array('Format','Font','FontSize'),
	array('Bold','Italic','Underline'),
	array('Subscript','Superscript','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','-','TextColor','BGColor', $VSpellCheck),
	array('Source')
);

// A setting for force paste as plain text.
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