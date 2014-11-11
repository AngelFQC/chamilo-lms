CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Maximize'],
            ['Link','Unlink'],
            ['Image'],
            ['Table'],
            ['FontSize'],
            ['Bold','Italic'],
            ['OrderedList','UnorderedList','-','TextColor'],
            ['Source']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
