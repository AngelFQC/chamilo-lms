CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Toolbarswitch','-','PasteWord','-','Undo','Redo'],
            ['FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['JustifyLeft','JustifyCenter','-','OrderedList','UnorderedList','-','TextColor','BGColor']
        ];
    config.toolbar_Full =
        [
            ['Toolbarswitch','-','PasteWord','-','Undo','Redo'],
            ['FontName','FontSize'],
            ['Bold','Italic','Underline'],
            ['JustifyLeft','JustifyCenter','-','OrderedList','UnorderedList','-','TextColor','BGColor']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.maximizedToolbar = 'Full';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};