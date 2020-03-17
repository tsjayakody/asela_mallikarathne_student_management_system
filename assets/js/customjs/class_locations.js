$(document).ready(function() {
    loadMainTable();
    $('.selectpicker').selectpicker();
});

$(document).on('submit','#createClassLocation',function (e) {
	e.preventDefault();
    const $funSel = $('#functionSelector').val();
    if ($funSel === 'create') {
        const $location = $('#location').val();
        const $locationCode = $('#locationCode').val();

        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: {
                location : $location,
                locationCode : $locationCode
            },
            success: function (response) {
                if (response.err) {
                    PNotify.error({
                        title: 'Oh No!',
                        text: response.err
                    });
                } else if (response === true) {
                    PNotify.success({
                        title: 'Success!',
                        text: 'Class location created.'
                    });
                    $('#resetForm').click();
                }
                if (response.form_err) {
                    $('#location-error').text(response.form_err.location);
                    $('#locationCode-error').text(response.form_err.locationCode);
                }
            },
            error: function(error) {
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                console.log(error);
            },
            complete: function () {
                loadMainTable();
            }
        });
    } else if ($funSel === 'update'){
        e.preventDefault();
        const $location = $('#location').val();
        const $locationCode = $('#locationCode').val();


        $.ajax({
            url: window.location.origin+'/system_operations/update_class_location',
            type: 'post',
            dataType: 'json',
            data: {
                location : $location,
                locationCode : $locationCode,
                id : $(this).attr('data-id')
            },
            success: function (response) {
                if (response.err) {
                    PNotify.error({
                        title: 'Oh No!',
                        text: response.err
                    });
                } else if (response === true) {
                    PNotify.success({
                        title: 'Success!',
                        text: 'Class location updated.'
                    });
                    $('#resetForm').click();
                    location.reload();
                }
                if (response.form_err) {
                    $('#location-error').text(response.form_err.location);
                    $('#locationCode-error').text(response.form_err.locationCode);
                }
            },
            error: function(error) {
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong!'
                });
                console.log(error);
            },
            complete: function () {
                loadMainTable();
            }
        });
    }
});


function loadMainTable() {
	$("#classLocationTable").DataTable({
		"destroy": true,
		"ajax": window.location.origin + "/system_operations/get_class_location_table",
		"columns": [
			{ "data": "no" },
			{ "data": "location" },
			{ "data": "locationCode" },
            { "data": "action" }
		]
	});
}


$(document).on('click','.edit',function(){
    const $location_id = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_location',
        type: 'post',
        dataType: 'json',
        data: {location_id:$location_id},
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response.success === true) {
                const $location = response.class_location;
                $('#location').val($location.location).parent().addClass('is-filled');
                $('#locationCode').val($location.locationCode).parent().addClass('is-filled');
                $('#functionSelector').val('update');
                $('#createClassLocation').attr('data-id',$location_id);
                if (!$('#formButtons button[type="button"]')[0]) {
					$("#formButtons").append('<button type="button" class="btn btn-primary" onclick="location.reload();">Cancel</button>');
				}
                $('button[type="submit"]').text('Update');
            }
        },
        error: function(error) {
            PNotify.error({
                title: 'Oh No!',
                text: 'Something went wrong!'
            });
            console.log(error);
        }
    })
});


$(document).on('click','.remove',function(){
    const $location_id = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/delete_class_location',
        dataType: 'json',
        type: 'post',
        data: {
            location_id:$location_id
        },
        success: function(response){
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response === true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'Class location deleted.'
                });
            }
        },
        error: function(error) {
            PNotify.error({
                title: 'Oh No!',
                text: 'This class location cannot delete.'
            });
            console.log(error);
        },
        complete: function() {
            loadMainTable();
        }
    })
});



$(document).on("click", ".form-control", function(event) {
	var element = $(this);
	var errorElem = "#" + $(element).attr("id") + "-error";
	if ($(errorElem).text() !== "") {
		$(errorElem).text('');
	}
});



