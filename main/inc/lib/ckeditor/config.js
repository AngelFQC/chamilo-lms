/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.toolbar_Basic =
        [
            ['Toolbarswitch']
        ];
    config.toolbar_Full =
        [
            ['Toolbarswitch', 'Save']
        ];
    config.toolbar = 'Basic';
    config.smallToolbar = 'Basic';
    config.maximizedToolbar = 'Full';
    config.allowedContent = true;
};

function CKeditor_OnComplete(ckEditorInstance) {

};
