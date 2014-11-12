CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Save','NewPage','Templates','-','PasteWord'],
            ['Undo','Redo'],
            ['Link','Image','flvPlayer','Flash','MP3','TableOC','mimetex','asciimath'],
            ['UnorderedList','OrderedList','Rule'],
            ['JustifyLeft','JustifyCenter','JustifyFull'],
            ['Abbr'],
            ['FontFormat','FontName','FontSize','Bold','Italic','TextColor'],
            ['Toolbarswitch']
        ];
    config.toolbar_Full =
        [
            ['Save','NewPage','Templates','-','Preview','Print'],
            ['Cut','Copy','Paste','PasteText','PasteWord'],
            ['Undo','Redo','-','SelectAll','Find','-','RemoveFormat'],
            ['Link','Unlink','Anchor','Glossary'],
            ['Image','imgmapPopup','flvPlayer','EmbedMovies','YouTube','Flash','MP3','googlemaps','Smiley','SpecialChar','insertHtml','mimetex','asciimath','fckeditor_wiris_openFormulaEditor','fckeditor_wiris_openCAS'],
            '/',
            ['TableOC','Table','TableInsertRowAfter','TableDeleteRows','TableInsertColumnAfter','TableDeleteColumns','TableInsertCellAfter','TableDeleteCells','TableMergeCells','TableHorizontalSplitCell','TableVerticalSplitCell','TableCellProp','-','CreateDiv'],
            ['UnorderedList','OrderedList','Rule','-','Outdent','Indent','Blockquote'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
            ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript','-','TextColor','BGColor'],
            ['Abbr'],
            ['SpellCheck'],
            ['Style','FontFormat','FontName','FontSize'],
            ['PageBreak','ShowBlocks'],
            ['Toolbarswitch']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.maximizedToolbar = 'Full';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};