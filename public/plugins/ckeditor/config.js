/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'image2';
	config.filebrowserBrowseUrl = "/editor-upload-images";
    config.filebrowserImageBrowseUrl = "/editor-upload-images?type=Images";
    config.filebrowserFlashBrowseUrl = "/editor-upload-images?type=Flash";
};
