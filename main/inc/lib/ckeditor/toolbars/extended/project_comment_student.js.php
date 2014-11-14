<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Project Comment Student form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../../global.inc.php';

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
	array('Save','NewPage','Templates','-','PasteFromWord'),
	array('Undo','Redo'),
	array('Link','Image','flvPlayer','Flash','MP3','TableOC','mimetex','asciimath'),
	array('BulletedList','NumberedList','HorizontalRule'),
	array('JustifyLeft','JustifyCenter','JustifyBlock'),
	array('Format','Font','FontSize','Bold','Italic','TextColor'),
	array('Toolbarswitch')
);

// This is the visible toolbar set when the editor is maximized.
// If it has not been defined, then the toolbar set for the "normal" size is used.

$toolbarFull = array(
	array('Save','NewPage','Templates','-','Preview','Print'),
	array('Cut','Copy','Paste','PasteText','PasteFromWord'),
	array('Undo','Redo','-','SelectAll','Find','-','RemoveFormat'),
	array('Link','Unlink','Anchor','Glossary'),
	array('Image','imgmapPopup','flvPlayer','EmbedMovies','YouTube','Flash','MP3','googlemaps','Smiley','SpecialChar','mimetex','asciimath','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'),
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
?>

CKEDITOR.editorConfig = function(config) {
    config.templates_files = [
        '<?php echo api_get_path(WEB_LIBRARY_PATH); ?>ckeditor/plugins/templates/templates/chamilo.js.php'
    ];

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
