CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Templates'],
            ['PasteWord'],
            ['Link'],
            ['Image','flvPlayer','Flash','MP3','mimetex','asciimath','asciisvg'],
            ['TableOC'],
            ['Bold'],
            ['Source', 'Toolbarswitch']
        ];
    config.toolbar_Full =
        [
            ['NewPage','Templates','-','Preview','Print'],
            ['Cut','Copy','Paste','PasteText','PasteWord'],
            ['Undo','Redo','-','SelectAll','Find','-','RemoveFormat'],
            ['Link','Unlink','Anchor','Glossary'],
            ['Image','imgmapPopup','flvPlayer','EmbedMovies','YouTube','Flash','MP3','googlemaps','Smiley','SpecialChar','insertHtml','mimetex','asciimath','asciisvg','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'],
            '/',
            ['TableOC','Table','TableInsertRowAfter','TableDeleteRows','TableInsertColumnAfter','TableDeleteColumns','TableInsertCellAfter','TableDeleteCells','TableMergeCells','TableHorizontalSplitCell','TableVerticalSplitCell','TableCellProp','-','CreateDiv'],
            ['UnorderedList','OrderedList','Rule','-','Outdent','Indent','Blockquote'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
            ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript','-','TextColor','BGColor'],
            ['SpellCheck'],
            ['Style','FontFormat','FontName','FontSize'],
            ['PageBreak','ShowBlocks','Source'],
            ['Toolbarswitch']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.maximizedToolbar = 'Full';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};