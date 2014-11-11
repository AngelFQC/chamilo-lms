<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Documents Student form
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
    array('Save','Toolbarswitch','PasteFromWord','-','Undo','Redo'),
    array('Link','Unlink','Anchor'),
    array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','asciisvg','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'),
    array('Table','SpecialChar'),
    array('Outdent','Indent','-','TextColor','BGColor','-','NumberedList','BulletedList','-',$VSpellCheck,'Source'),
    '/',
    array('Styles','Format','Font','FontSize'),
    array('Bold','Italic','Underline'),
    array('JustifyLeft','JustifyCenter','JustifyRight'),
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
    // config.height = 600;
};

function CKeditor_OnComplete(ckEditorInstance) {

}