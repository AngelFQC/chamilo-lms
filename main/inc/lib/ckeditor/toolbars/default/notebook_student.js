CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Save','Maximize','PasteWord','-','Undo','Redo'],
            ['Link','Unlink','Anchor'],
            ['Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex'],
            ['Table','SpecialChar'],
            ['OrderedList','UnorderedList','-','Outdent','Indent','-','TextColor','BGColor'],
            '/',
            ['Style','FontFormat','FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['JustifyLeft','JustifyCenter','JustifyRight'],
            ['ShowBlocks']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
