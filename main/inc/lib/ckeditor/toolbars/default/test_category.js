CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Style', 'FontFormat', 'FontName', 'FontSize'],
            '/',
            ['Bold', 'Italic', 'Underline'],
            ['SpecialChar', 'mimetex'],
            ['OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', '-', 'TextColor', 'BGColor'],
            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'Source']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
