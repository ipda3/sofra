// var sound = new Audio("http://localhost/too/deskbell.wav"); // buffers automatically when created
// var sound = new Audio("http://www.tooready.com/deskbell.wav"); // buffers automatically when created
// //console.log(sound);
// toastr.options = {
//     "closeButton": true,
//     "debug": false,
//     "newestOnTop": false,
//     "progressBar": false,
//     "positionClass": "toast-bottom-left",
//     "preventDuplicates": false,
//     "onclick": null,
//     "showDuration": "300",
//     "hideDuration": "10000",
//     "timeOut": "5000",
//     "extendedTimeOut": "1000",
//     "showEasing": "swing",
//     "hideEasing": "linear",
//     "showMethod": "fadeIn",
//     "hideMethod": "fadeOut",
//     "rtl": true
// };

// Enable pusher logging - don't include this in production
//Pusher.logToConsole = true;

// var pusher = new Pusher('d1ede80e4ffc8c93c90c', {
//     cluster: 'ap1',
//     encrypted: true
// });
//
// var channel = pusher.subscribe('dashboard_channel');
// channel.bind('new_order', function(data) {
//
// });

$(document).on('click','.destroy',function(){
    var route   = $(this).data('route');
    var token   = $(this).data('token');
    $.confirm({
        icon                : 'glyphicon glyphicon-floppy-remove',
        animation           : 'rotateX',
        closeAnimation      : 'rotateXR',
        title               : 'تأكد عملية الحذف',
        autoClose           : 'cancel|6000',
        text             : 'هل أنت متأكد من الحذف ؟',
        confirmButtonClass  : 'btn-outline',
        cancelButtonClass   : 'btn-outline',
        confirmButton       : 'نعم',
        cancelButton        : 'لا',
        dialogClass			: "modal-danger modal-dialog",
        confirm: function () {
            $.ajax({
                url     : route,
                type    : 'post',
                data    : {_method: 'delete', _token :token},
                dataType:'json',
                success : function(data){
                    if(data.status == 0)
                    {
                        //toastr.error(data.msg)
                        swal("خطأ!", data.msg, "error")
                    }else{
                        $("#removable"+data.id).remove();
                        swal("أحسنت!", data.msg, "success")
                        //toastr.success(data.msg)
                    }
                }
            });
        },
    });
});

$('.select2').select2({
    dir: "rtl"
});

$('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd'
});
// initialize with defaults
$(".file_upload_preview").fileinput({
    showUpload: false,
    showRemove: false,
    showCaption: false
});

var defaultGalleryField =  $("#idol-field").html();

$("#new-gallery-photo").click(function (e) {
    e.preventDefault();
    $("#gallery-fields").append(defaultGalleryField);
});



/***
 * ajax request
 * ****/
$("#city_id").change(function () {
    var city_id   = $("#city_id").val();
    var url   = $(this).data('url')+"?city_id="+city_id;
    $.ajax({
        url     : url,
        type    : 'get',
        dataType:'json',
        success : function(data){
            $('#region_id').empty();
            var option = '<option value="">اختر المنطقة</option>';
            $("#region_id").append(option);
            $.each(data, function( index, region ) {
                var option = '<option value="'+region.id+'">'+region.name+'</option>';
                console.log(option);
                $("#region_id").append(option);
            });
        }
    });
});

/*
    cancel note
 */
$('#cancel_note').hide();
$('#state').change(function () {
    var state=  $('#state').val();
    if(state==='canceled'){
        $('#cancel_note').show();
    }else{
        $('#cancel_note').hide();
    }
});


$("#new_time").click(function () {
    var tempField = $("#main_time").clone();
    tempField.find(".from").val("").end();
    tempField.find(".to").val("").end();
    $("#work_times").append(tempField);
    // re init timepicker
    $('.timepicker').wickedpicker({
        now: "12:00",
        twentyFour: true
    });
    return false;
});
function deleteDynamicPhone(anchor) {
    anchor.closest('.row').remove();
}

$('.timepicker').wickedpicker({
    now: "12:00",
    twentyFour: true
});
var latitude = $('#latitude').val();
var longitude = $('#longitude').val();
var mapFiled = $('#mapField').locationpicker({
    location: {latitude: latitude, longitude: longitude},
    radius: 0,
    inputBinding: {
        latitudeInput: $('#latitude'),
        longitudeInput: $('#longitude'),
        locationNameInput: $('#address_en')
    },
    enableAutocomplete: true,
    onchanged: function (currentLocation, radius, isMarkerDropped) {
        //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
        return false;
    }
});
