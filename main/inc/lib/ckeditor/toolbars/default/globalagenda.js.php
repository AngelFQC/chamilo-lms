<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Global Agenda form
 * @author Angel Fernando Quiroz Campos <angel.quiroz@beeznest.com>
 */
header('Content-Type: application/x-javascript');

$extraPlugins = array(
    'toolbarswitch',
);

$toolbarBasic = array(
    array('Toolbarswitch', '-', 'PasteFromWord', '-', 'Undo', 'Redo'),
    array('Link', 'Unlink'),
    array('Image', 'flvPlayer', 'Flash', 'EmbedMovies', 'YouTube', 'MP3', 'mimetex'),
    array('Table', 'SpecialChar', 'googlemaps'),
    array('Font', 'FontSize'),
    array('Bold', 'Italic', 'Underline'),
    array('NumberedList', 'BulletedList', '-', 'TextColor', 'BGColor'),
	array('Source')
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