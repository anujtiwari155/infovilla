/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        
        var basepath = 'http://www.deepkesh.com/ecommerce/';
        config.filebrowserBrowseUrl = basepath+'kcfinder/browse.php?opener=ckeditor&type=files';
        config.filebrowserImageBrowseUrl = basepath+'kcfinder/browse.php?opener=ckeditor&type=images';
        config.filebrowserFlashBrowseUrl = basepath+'kcfinder/browse.php?opener=ckeditor&type=flash';
        config.filebrowserUploadUrl = basepath+'kcfinder/upload.php?opener=ckeditor&type=files';
        config.filebrowserImageUploadUrl = basepath+'kcfinder/upload.php?opener=ckeditor&type=images';
        config.filebrowserFlashUploadUrl = basepath+'kcfinder/upload.php?opener=ckeditor&type=flash';
        config.scayt_autoStartup = true;
};
