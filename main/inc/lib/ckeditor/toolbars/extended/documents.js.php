<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Documents form
 * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../../global.inc.php';

if ((api_get_setting('allow_spellcheck') == 'true')) {
    $SpellChecker = 'Scayt';
} else {
    $SpellChecker = '';
}

$extraPlugins = array(
    'toolbarswitch',
);

$toolbarBasic = array(
    array('Save', 'NewPage', 'Templates', '-', 'PasteFromWord'),
    array('Undo', 'Redo'),
    array('Link', 'Image', 'flvPlayer', 'Flash', 'YouTube', 'MP3', 'TableOC', 'mimetex', 'asciimath', 'asciisvg'),
    array('BulletedList', 'NumberedList', 'HorizontalRule'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyBlock'),
    array('Abbr'),
    array('Format', 'Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'TextColor', 'BGColor', 'Source'),
    array('Toolbarswitch')
);

$toolbarFull = array(
    array('Save', 'NewPage', 'Templates', '-', 'Preview', 'Print'),
    array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
    array('Undo', 'Redo', '-', 'SelectAll', 'Find', '-', 'RemoveFormat'),
    array('Link', 'Unlink', 'Anchor', 'Glossary'),
    array('Image', 'imgmapPopup', 'flvPlayer', 'Flash', 'YouTube', 'EmbedMovies', 'MP3', 'googlemaps', 'Smiley', 'SpecialChar', 'insertHtml', 'mimetex', 'asciimath', 'asciisvg', 'fckeditor_wiris_openFormulaEditor', 'fckeditor_wiris_openCAS'),
    '/',
    array('TableOC', 'Table', 'TableInsertRowAfter', 'TableDeleteRows', 'TableInsertColumnAfter', 'TableDeleteColumns', 'TableInsertCellAfter', 'TableDeleteCells', 'TableMergeCells', 'TableHorizontalSplitCell', 'TableVerticalSplitCell', 'TableCellProp', '-', 'CreateDiv'),
    array('BulletedList', 'NumberedList', 'HorizontalRule', '-', 'Outdent', 'Indent', 'Blockquote'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'TextColor', 'BGColor'),
    array('Abbr'),
    array($SpellChecker),
    array('Styles', 'Format', 'Font', 'FontSize'),
    array('PageBreak', 'ShowBlocks', 'Source'),
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

    // Sets whether the toolbar can be collapsed/expanded or not.
    // Possible values: true , false
    config.toolbarCanCollapse = true;

    // This option sets the location of the toolbar.
    // Possible values: 'top' , 'bottom'
    // config.toolbarLocation = 'top';

    // Here new width and height of the editor may be set.
    // Possible values, examples: 300 , '250' , '100%' , ...
    // config.width = '100%';
    // config.height = 600;
};

function CKeditor_OnComplete(ckEditorInstance) {

}