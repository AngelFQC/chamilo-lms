CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Link','Unlink'],
            ['Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex'],
            ['Table','Smiley'],
            ['TextColor','BGColor'],
            ['Source'],
            '/',
            ['FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['JustifyLeft','JustifyCenter','-','OrderedList','UnorderedList']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
