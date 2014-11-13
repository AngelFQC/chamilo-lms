<?php
/* For licensing terms, see /license.txt */
/**
 * CKEditor toolbar for Learning Path Documents form
 * @author Imanol Losada Oriol <imanol.losada@beeznest.com>
 */
header('Content-Type: application/x-javascript');

require_once '../../../main_api.lib.php';

$extraPlugins = array(
    'toolbarswitch',
);

// This is the visible toolbar set when the editor has "normal" size.
$toolbarBasic = array(
    array('PasteFromWord','-','Undo','Redo'),
    array('Link','Unlink','Anchor','Glossary'),
    array('Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','asciisvg','Table','SpecialChar'),
    array('Outdent','Indent','TextColor','BGColor','-','NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight'),
    '/',
    array('Styles','Format','Font','FontSize'),
    array('Bold','Italic','Underline','-','Source'),
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