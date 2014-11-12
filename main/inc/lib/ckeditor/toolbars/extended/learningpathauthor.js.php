<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Course (learning path) - Author form
 * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

if ((api_get_setting('allow_spellcheck') == 'true')) {
    $SpellChecker = 'Scayt';
} else {
    $SpellChecker = '';
}

$extraPlugins = array(
    'toolbarswitch',
);

$toolbarBasic = array(
    // array('PasteFromWord'),
    // array('Link', 'Image', 'EmbedMovies', 'Flash', 'MP3', 'mimetex'),
    // array('TableOC'),
    // array('NumberedList', 'HorizontalRule'),
    // array('JustifyFull'),
    // array('Bold', 'Italic', 'Underline', 'TextColor', 'BGColor'),
    array('Link', 'Unlink', 'Bold', 'Italic', 'TextColor', 'BGColor', 'Source'),
    array('Toolbarswitch')
);

$toolbarFull = array(
    // array('Save', 'NewPage', 'Templates', '-', 'Preview', 'Print'),
    // array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),
    // array('Undo', 'Redo', '-', 'SelectAll', 'Find', '-', 'RemoveFormat'),
    // array('Link', 'Unlink', 'Anchor', 'Glossary'),
    // array('Image', 'imgmapPopup', 'flvPlayer', 'EmbedMovies', 'YouTube', 'Flash', 'MP3', 'googlemaps', 'Smiley', 'SpecialChar', 'insertHtml', 'mimetex', 'asciimath', 'asciisvg'),
    // '/',
    // array('TableOC', 'Table', 'TableInsertRowAfter', 'TableDeleteRows', 'TableInsertColumnAfter', 'TableDeleteColumns', 'TableInsertCellAfter', 'TableDeleteCells', 'TableMergeCells', 'TableHorizontalSplitCell', 'TableVerticalSplitCell', 'TableCellProp', '-', 'CreateDiv'),
    // array('BulletedList', 'NumberedList', 'HorizontalRule', '-', 'Outdent', 'Indent', 'Blockquote'),
    // array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    // array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'TextColor', 'BGColor'),
    // array($VSpellCheck),
    // array('Styles', 'FontFormat', 'FontName', 'FontSize'),
    array('PageBreak', 'ShowBlocks', 'Source'),
    array('Toolbarswitch')
);
?>
CKEDITOR.editorConfig = function(config) {
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
    
    // Sets how the editor's toolbar should start - expanded or collapsed.
    // Possible values: true , false
    config.toolbarStartupExpanded = false;

    // This option sets the location of the toolbar.
    // Possible values: 'top' , 'bottom'
    // config.toolbarLocation = 'top';

    // Here new width and height of the editor may be set.
    // Possible values, examples: 300 , '250' , '100%' , ...
    // config.width = '100%';
    // config.height = 150;
};

function CKeditor_OnComplete(ckEditorInstance) {

}