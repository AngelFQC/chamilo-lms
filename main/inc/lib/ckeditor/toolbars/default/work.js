CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['FitWindow','-','PasteWord','-','Undo','Redo'],
            ['Link','Unlink','Anchor'],
            ['Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex'],
            ['Table','Smiley'],
            ['FontFormat','FontName','Bold','Italic','TextColor','BGColor'],
            '/',
            ['FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['JustifyLeft','JustifyCenter','-','OrderedList','UnorderedList','-','TextColor','BGColor'],
            ['Source']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};