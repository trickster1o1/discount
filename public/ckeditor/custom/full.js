CKEDITOR.editorConfig = function( config ) {
    var public_url = document.getElementById('base_url').value;
    //alert(base_url);
    config.allowedContent = true;
//    config.extraAllowedContent = '*(*)';
    config.extraAllowedContent = 'span(*)';
    config.filebrowserImageBrowseUrl = '/elfinder/ckeditor';
    config.filebrowserBrowseUrl = '/elfinder/ckeditor';
    config.uiColor = '#f1f1f1';
};
