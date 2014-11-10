/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.extraPlugins = 'button,maximize,toolbar,toolbarswitch';
    config.allowedContent = true;
    config.templates_files = [
        '/main/inc/lib/ckeditor/plugins/templates/templates/chamilo.js.php'
    ];
};
