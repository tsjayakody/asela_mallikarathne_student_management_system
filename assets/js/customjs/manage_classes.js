$(document).ready(function() {
    loadMainTable();
    $('.selectpicker').selectpicker();
    get_year();
    get_location();
    get_class_type();
});

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_class_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="'+row.yearid+'">'+row.year+'</option>';
                });
                $("#year").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

function get_location() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_class_location_for_class_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Location</option>';
                Array.from(params.locations).map(row => {
                    html = html + '<option value="'+row.locationid+'">'+row.location+' ('+row.locationCode+') '+'</option>';
                });
                $("#classLocation").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

function get_class_type() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_class_type_for_class_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Class Type</option>';
                Array.from(params.types).map(row => {
                    html = html + '<option value="'+row.typeid+'">'+row.type+' ('+row.typeCode+') - '+row.studentCharge+'</option>';
                });
                $("#classType").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}


$(document).on('submit','#createClass',function (e) {
	e.preventDefault();
    const $funSel = $('#functionSelector').val();
    if ($funSel === 'create') {
        const $year = $('#year').val();
        const $classLocation = $('#classLocation').val();
        const $classType = $('#classType').val();
        const $note = $('#note').val();
        const $fromNumber = $('#fromNumber').val();
        const $toNumber = $('#toNumber').val();

        if ($classType === null || $classLocation === null || $year === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave student type, payment type, class or year type empty!'
            });
            return false;
        } else {
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                dataType: 'json',
                data: {
                    year : $year,
                    classLocation : $classLocation,
                    classType : $classType,
                    note : $note,
                    fromNumber : $fromNumber,
                    toNumber : $toNumber
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
                            text: 'Class created.'
                        });
                        $('#resetForm').click();
                    }
                    if (response.form_err) {
                        $('#note-error').text(response.form_err.note);
                        $('#fromNumber-error').text(response.form_err.fromNumber);
                        $('#toNumber-error').text(response.form_err.toNumber);
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
    } else if ($funSel === 'update'){
        const $year = $('#year').val();
        const $classLocation = $('#classLocation').val();
        const $classType = $('#classType').val();
        const $note = $('#note').val();
        const $fromNumber = $('#fromNumber').val();
        const $toNumber = $('#toNumber').val();

        if ($classType === null || $classLocation === null || $year === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave student type, payment type, class or year type empty!'
            });
            return false;
        } else {
            $.ajax({
                url: window.location.origin+'/system_operations/update_class',
                type: 'post',
                dataType: 'json',
                data: {
                    year : $year,
                    classLocation : $classLocation,
                    classType : $classType,
                    note : $note,
                    fromNumber : $fromNumber,
                    toNumber : $toNumber,
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
                            text: 'Class updated.'
                        });
                        $('#resetForm').click();
                        location.reload();
                    }
                    if (response.form_err) {
                        $('#note-error').text(response.form_err.note);
                        $('#fromNumber-error').text(response.form_err.fromNumber);
                        $('#toNumber-error').text(response.form_err.toNumber);
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
    }
});


function loadMainTable() {
	$("#classTable").DataTable({
		"destroy": true,
		"ajax": window.location.origin + "/system_operations/get_class_table",
		"columns": [
			{ "data": "no" },
			{ "data": "year" },
			{ "data": "classLocation" },
            { "data": "classType" },
            { "data": "note" },
            { "data": "fromTo" },
            { "data": "action" }
		]
	});
}


$(document).on('click','.edit',function(){
    const $classid = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/get_class',
        type: 'post',
        dataType: 'json',
        data: {class_id:$classid},
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response.success === true) {
                const $class = response.class;
                $('#note').val($class.note).parent().addClass('is-filled');
                $('#year').val($class.year);
                $('#classLocation').val($class.classLocation);
                $('#classType').val($class.classType);
                $('#fromNumber').val($class.fromNumber).parent().addClass('is-filled');
                $('#toNumber').val($class.toNumber).parent().addClass('is-filled');
                $('.selectpicker').selectpicker('refresh');
                $('#functionSelector').val('update');
                $('#createClass').attr('data-id',$classid);
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
    const $classid = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/delete_class',
        dataType: 'json',
        type: 'post',
        data: {
            class_id:$classid
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
                    text: 'Class deleted.'
                });
            }
        },
        error: function(error) {
            PNotify.error({
                title: 'Oh No!',
                text: 'This class cannot delete.'
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