CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['PasteWord','-','Undo','Redo'],
            ['Link','Unlink','Anchor','Glossary'],
            ['Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','asciisvg','Table','SpecialChar'],
            ['Outdent','Indent','TextColor','BGColor','-','OrderedList','UnorderedList','JustifyLeft','JustifyCenter','JustifyRight'],
            '/',
            ['Style','FontFormat','FontName','FontSize'],
            ['Bold','Italic','Underline','-','Source']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
