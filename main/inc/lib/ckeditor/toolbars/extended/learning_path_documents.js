CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['NewPage','Templates','-','PasteWord'],
            ['Undo','Redo'],
            ['Link','Image','flvPlayer','YouTube','Flash','MP3','TableOC','mimetex','asciimath','asciisvg'],
            ['UnorderedList','OrderedList','Rule'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
            ['FontFormat','FontName','FontSize','Bold','Italic','Underline','TextColor','BGColor','Source'],
            ['Toolbarswitch']
        ];
    config.toolbar_Full =
        [
            ['NewPage','Templates','-','Preview','Print'],
            ['Cut','Copy','Paste','PasteText','PasteWord'],
            ['Undo','Redo','-','SelectAll','Find','-','RemoveFormat'],
            ['Link','Unlink','Anchor','Glossary'],
            ['Image','imgmapPopup','flvPlayer','EmbedMovies','YouTube','Flash','MP3','googlemaps','Smiley','SpecialChar','insertHtml','mimetex','asciimath','asciisvg'],
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