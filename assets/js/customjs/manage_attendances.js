$(document).ready(function () {
    $('#inputStudentID').focus();
});

$(document).on('submit','#markAttendance',function (event) {
    event.preventDefault();

    $.ajax({
        url: window.location.origin+'/system_operations/insert_attendance',
        type: 'post',
        dataType: 'json',
        data: $('#markAttendance').serialize(),
        success: function (params) {
            if (params.success === false) {
                let htmlString = '<h3 class="failed">'+params.err+'</h3>';
                $('.statusDiv').html(htmlString);
            }
            if (params.success === true) {
                let htmlString = '<img src="'+params.imgUrl+'" alt="Profile Photo">'+'<h4>'+params.name+'</h4>'+'<h4>'+params.stid+'</h4>'+'<h4 class="success">Success</h4>'+'<h4 class="success">'+params.datetime+'</h4>';
                $('.statusDiv').html(htmlString);
            }
            getLastAttendances($('#markAttendance').serialize());
        },
        error: function () {
            let htmlString = '<h3 class="failed">Something went wrong.</h3>';
            $('.statusDiv').html(htmlString);
        },
        complete: function () {
            getAttendCount($('#markAttendance').serialize());
            $('#markAttendance').trigger('reset');
            $('#inputStudentID').focus();
        }
    });
});

function getLastAttendances (formData) {
    $.ajax({
        url: window.location.origin + '/system_operations/get_last_attendances',
        dataType: 'JSON',
        data: formData,
        type: 'POST',
        success: function (params) {
            $('#attBlock').html(params.data);
        },
        error: function () {
            let htmlString =    '<div class="btn btn-block btn-danger btn-lg">'+
                                '<p>Error occurred.</p>'+
                                '</div>';
            $('#attBlock').html(htmlString)
        }
    })

}

function getAttendCount (formData) {
    $.ajax({
        url: window.location.origin + '/system_operations/get_attend_count',
        dataType: 'JSON',
        data: formData,
        type: 'POST',
        success: function (params) {
            let allCount = params.all;
            let attCount = params.att;
            let className = params.class;
            let locationName = params.location;
            let htmlString = '<strong>'+ attCount + ' of ' + allCount + ' students attended for ' + className + ' ' + locationName + '.';
            $('#attCount').html(htmlString);
        },
        error: function () {
            let htmlString =    '<strong class="text-danger">Error occurred</strong>';
            $('#attCount').html(htmlString)
        }
    })

}