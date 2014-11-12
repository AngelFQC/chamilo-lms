<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Agenda Student form
 * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

if ((api_get_setting('allow_spellcheck') != 'true')) {
    $SpellChecker = 'Scayt';
} else {
    $SpellChecker = '';
}

$extraPlugins = array(
    'toolbarswitch',
);

$toolbarBasic = array(
    array('Save', 'Toolbarswitch', 'PasteFromWord', '-', 'Undo', 'Redo'),
    array('Link', 'Unlink', 'Anchor'),
    array('Image', 'flvPlayer', 'Flash', 'EmbedMovies', 'YouTube', 'MP3', 'mimetex'),
    array('Table', 'SpecialChar'),
    '/',
    array('Format', 'Font', 'FontSize'),
    array('Bold', 'Italic', 'Underline'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'TextColor', 'BGColor'),
    array('ShowBlocks')
);
?>
CKEDITOR.editorConfig = function(config) {
    config.extraPlugins = '<?php echo implode(',', $extraPlugins) ?>';
    config.toolbar_Basic = <?php echo json_encode($toolbarBasic) ?>;
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;

    // Sets whether the toolbar can be collapsed/expanded or not.
    // Possible values: true , false
    // config.toolbarCanCollapse = true;

    // This option sets the location of the toolbar.
    // Possible values: 'top' , 'bottom'
    // config.toolbarLocation = 'top';

    // Here new width and height of the editor may be set.
    // Possible values, examples: 300 , '250' , '100%' , ...
    // config.width = '100%';
    // config.height = 300;
};

function CKeditor_OnComplete(ckEditorInstance) {

}