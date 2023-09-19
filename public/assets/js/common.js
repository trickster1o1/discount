$('body').find('.nav-item.sub-active').closest('ul').parent().parent().addClass('active');
$('body').find('.nav-item.sub-active').closest('ul').parent().addClass('show');

if($('.pop').length > 0){
    $(".pop").popover();
}

if ($(".select2").length) {
    $(".select2").select2({
        theme: "classic",
    });
}

if($('.datepicker').length > 0){ //not necessary
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    });
}

// $(".datepicker").inputmask("y-m-d",{placeholder:"yyyy-mm-dd"});
//         //Inputmask("time", { jitMasking: true }).mask('.timepicker');
//         window.onload = function() {
//             load_ckeditor('popup_description', false);
//         }

if($('.timepicker').length > 0){ //not necessary
    $('.timepicker').timepicker({
    });
}


$("#list-data").on("click", ".record-status", function () {
    var selector = $(this);
    var id = $(this).attr("data-id");
    var table = $(this).attr("data-table");
    var status = $(this).attr("data-status");
    $.ajax({
        url: "dashboard/change_status",
        data: {
            id: id,
            table: table,
            status: status,
        },
        type: "get",
        success: function (result) {
            var data = JSON.parse(result);
            selector.closest("td").html(data["msg"]);
        },
    });
});

$("#list-data").on("click", ".featured-record", function () {
    var selector = $(this);
    var id = $(this).attr("data-id");
    var table = $(this).attr("data-table");
    var status = $(this).attr("data-status");
    $.ajax({
        url: "dashboard/change_is_featured",
        data: {
            id: id,
            table: table,
            status: status,
        },
        type: "get",
        success: function (result) {
            var data = JSON.parse(result);
            selector.closest("td").html(data["msg"]);
        },
    });
});

function generateSlug() {
    if($('#name').val()) {
        txtValue = $('#name').val();
    } else {
        txtValue = $('#title').val();
    }
    var newValue = txtValue
        .toLowerCase()
        .replace(/[~!@#$%\^\&\*\(\)\+=|'"|\?\/;:.,<>\-\\\s]+/gi, "-");
    $("#slug").val(newValue);
}

$('#generate-slug').on('click',function(){
    generateSlug();
});
$('#slug').on('focus',function(){
    generateSlug();
});

function getUrlParam(paramName) {
    var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
    var match = window.location.search.match(reParam) ;

    return (match && match.length > 1) ? match[1] : '' ;
}

function load_ckeditor(textarea, customConfig) {
    if (customConfig) {
		configFile =  'custom/minimal.js';
	} else {
		configFile = 'custom/full.js';
	}


    CKEDITOR.replace(textarea, {
		customConfig: configFile,
	});
}


//for post type ajax
$.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

//Get Category
if($('#category_type').length){
    getCategoryByCategoryType();
    $('#category_type').on('change',function(){
        getCategoryByCategoryType();
    });
}
function getCategoryByCategoryType(){
    var categoryType = $('#category_type').val();
    var selected_category = $('#old_category').val();
    $.ajax({
        url: '/admin/dashboard/getcategory',
        type: 'post',
        data: 'ctslug=' + categoryType +"&selected_category="+selected_category,
        success: function(result) {
            $('#category').html(result.html)
        }
    });
}
if($('#sub_category').length){
    getSubCategoryByCategory();
    $('#category').on('change',function(){
        getSubCategoryByCategory();
    });
}

function getSubCategoryByCategory(){
    var category = $('#category option:selected').val();
    var selected = $('#old_subcategory').val();
    console.log(category);
    $.ajax({
        url: '/admin/dashboard/getsubcategory',
        type: 'post',
        data: 'cid=' + category +"&selected="+selected,
        success: function(result) {
            $('#sub_category').html(result.html)
        }
    });
}