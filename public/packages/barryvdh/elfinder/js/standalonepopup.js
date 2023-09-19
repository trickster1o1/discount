$(document).on('click','.popup_selector',function (event) {
    event.preventDefault();
    var updateID = $(this).attr('data-inputid'); // Btn id clicked
    var elfinderUrl = '/elfinder/popup/';

    // trigger the reveal modal with elfinder inside
    var triggerUrl = elfinderUrl + updateID;
    $.colorbox({
        href: triggerUrl,
        fastIframe: true,
        iframe: true,
        width: '70%',
        height: '62%'
    });

});
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) { 
    var actualPath = filePath.replace(/\\/g,"/");   
    $('#' + requestingField).val(actualPath);
    var public_url = document.getElementById('base_url').value;
    var image_url  = public_url+'/'+filePath;
    // console.log(image_url);
    // if($.trim(requestingField).length){
    //     $('#' + requestingField).parent().find('.image-preview').html('<img src="'+image_url+'">');
    // }else{
    //     $('#' + requestingField).parent().find('.image-preview').html('');
    // }
}
