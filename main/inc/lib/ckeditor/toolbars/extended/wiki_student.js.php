<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Wiki Student form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

// Hide/show SpellCheck buttom
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
	array('Save','NewPage','Templates','-','PasteText'),
	array('Undo','Redo'),
	array('Wikilink','Link','Image','flvPlayer','Flash','MP3','TableOC','mimetex','asciimath','asciisvg'),
	array('BulletedList','NumberedList','HorizontalRule'),
	array('JustifyLeft','JustifyCenter','JustifyBlock'),
	array('Format','Font','FontSize','Bold','Italic','Underline','TextColor','BGColor'),
	array('Toolbarswitch')
);

// This is the visible toolbar set when the editor is maximized.
// If it has not been defined, then the toolbar set for the "normal" size is used.
$toolbarFull = array(
	array('Save','NewPage','Templates','-','Preview','Print'),
	array('Cut','Copy','Paste','PasteText','PasteFromWord'),
	array('Undo','Redo','-','SelectAll','Find','-','RemoveFormat'),
	array('Wikilink','Link','Unlink','Anchor','Glossary'),
	array('Image','imgmapPopup','flvPlayer','EmbedMovies','YouTube','Flash','MP3','googlemaps','Smiley','SpecialChar','mimetex','asciimath','asciisvg','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'),
'/',
	array('TableOC','Table','TableInsertRowAfter','TableDeleteRows','TableInsertColumnAfter','TableDeleteColumns','TableInsertCellAfter','TableDeleteCells','TableMergeCells','TableHorizontalSplitCell','TableVerticalSplitCell','TableCellProp','-','CreateDiv'),
	array('BulletedList','NumberedList','HorizontalRule','-','Outdent','Indent','Blockquote'),
	array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
	array('Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','TextColor','BGColor'),
	array($VSpellCheck),	
	array('Styles','Format','Font','FontSize'),
	array('PageBreak','ShowBlocks'),
	array('Toolbarswitch')
	
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
config.toolbar_Full = <?php echo json_encode($toolbarFull) ?>;
config.toolbar = 'Basic';
config.smallToolbar = 'Basic';
config.maximizedToolbar = 'Full';
config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

}
