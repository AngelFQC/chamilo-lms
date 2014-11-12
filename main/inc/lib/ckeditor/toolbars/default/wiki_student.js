CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Maximize','Save','NewPage','PageBreak','Preview','-','PasteText','-','Undo','Redo','-','SelectAll','-','Find'],
            ['Wikilink','Link','Unlink','Anchor'],
            ['Image','flvPlayer','Flash','EmbedMovies','YouTube','MP3','mimetex','asciimath','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'],
            ['Table','Rule','Smiley','SpecialChar','googlemaps'],
            ['FontFormat','FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['Subscript','Superscript','-','JustifyLeft','JustifyCenter','JustifyRight','-','OrderedList','UnorderedList','-','Outdent','Indent','-','TextColor','BGColor'],
            ['ShowBlocks']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
