$(document).on('submit', '#createCollectionForm', function (event) {
    event.preventDefault();

    $.ajax({
        type: 'POST',
        url: window.location.origin+'/system_operations/create_collection',
        dataType: 'JSON',
        data: $('#createCollectionForm').serialize(),
        success: function (params) {
            if (params.form_err) {
                $('#errCollectionName').html(params.form_err.collectionName);
            } else {
                loadMainTable();
                $('#createCollectionForm')[0].reset();
                PNotify.success({
                    title: 'Success!',
                    text: 'Collection created.',
                    delay:2500
                });
            }
        },
        error: function (err) {
            console.log(err);
            PNotify.error({
                title: 'Oh No!',
                text: err.statusText,
                delay:2500
            });
        }
    });
});

$(document).on('click', '#collectionName', function () {
    $('#errCollectionName').html("");
});

function loadMainTable() {
	$("#collectionTable").DataTable({
		destroy: true,
		ajax: {
			url: window.location.origin +"/system_operations/get_collection_table",
			type: "post"
		},
		columns: [
			{ data: "no" },
			{ data: "name" },
			{ data: "qty" },
			{ data: "actions" }
		]
	});
}

$(document).ready(function () {
    loadMainTable();
});

$(document).on('click', '.delete', function (event) {
    $id = $(this).attr('data-id');

    var notice = PNotify.error({
        title: 'Confirmation Needed',
        text: 'Are you sure?',
        icon: 'fas fa-question-circle',
        hide: false,
        stack: {
            'dir1': 'down',
            'modal': true,
            'firstpos1': 25
        },
        modules: {
            Confirm: {
            confirm: true
        },
        Buttons: {
            closer: false,
            sticker: false
        },
        History: {
            history: false
        },
        }
    });
    notice.on('pnotify.confirm', function() {
        $.ajax({
            url: window.location.origin+'/system_operations/delete_collection',
            type: 'POST',
            dataType: 'JSON',
            data: {id: $id},
            success: function (params) {
                loadMainTable();
                PNotify.success({
                    title: 'Success!',
                    text: 'Collection deleted.',
                    delay:2500
                });
            },
            error: function (err) {
                console.log(err);
                PNotify.error({
                    title: 'Oh No!',
                    text: err.statusText,
                    delay:2500
                });
            }
        });
    });
});

function getExistingNumbersTable(collectionID) {
    $("#existingNumbersTable").DataTable({
		destroy: true,
		ajax: {
			url: window.location.origin +"/system_operations/get_numbers_table",
            type: "post",
            data: {id: collectionID}
		},
		columns: [
			{ data: "no" },
			{ data: "number" },
			{ data: "actions" }
		]
	});
}

$('#editCollectionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var collectionID = button.data('id') // Extract info from data-* attributes
    
    getExistingNumbersTable(collectionID);
    var modal = $(this);
    modal.find('#collectionID').val(collectionID);
});


$(document).on('submit', '#addNewNumberForm', function (event) {
    event.preventDefault();

    $.ajax({
        type: 'POST',
        url: window.location.origin+'/system_operations/enter_collection_number',
        dataType: 'JSON',
        data: $('#addNewNumberForm').serialize(),
        success: function (params) {
            if (params.form_err) {
                $('#errNewNumber').html(params.form_err.newNumber);
            } else {
                getExistingNumbersTable($('#collectionID').val());
                $('#addNewNumberForm')[0].reset();
                PNotify.success({
                    title: 'Success!',
                    text: 'Number added.',
                    delay:2500
                });
            }
        },
        error: function (err) {
            console.log(err);
            PNotify.error({
                title: 'Oh No!',
                text: err.statusText,
                delay:2500
            });
        }
    });
});

$(document).on('click', '#newNumber', function () {
    $('#errNewNumber').html("");
});

$(document).on('click', '.deletenumber', function (event) {
    $id = $(this).attr('data-id');

    var notice = PNotify.error({
        title: 'Confirmation Needed',
        text: 'Are you sure?',
        icon: 'fas fa-question-circle',
        hide: false,
        stack: {
            'dir1': 'down',
            'modal': true,
            'firstpos1': 25
        },
        modules: {
            Confirm: {
            confirm: true
        },
        Buttons: {
            closer: false,
            sticker: false
        },
        History: {
            history: false
        },
        }
    });
    notice.on('pnotify.confirm', function() {
        $.ajax({
            url: window.location.origin+'/system_operations/delete_collection_number',
            type: 'POST',
            dataType: 'JSON',
            data: {id: $id},
            success: function (params) {
                getExistingNumbersTable($('#collectionID').val());
                PNotify.success({
                    title: 'Success!',
                    text: 'Number deleted.',
                    delay:2500
                });
            },
            error: function (err) {
                console.log(err);
                PNotify.error({
                    title: 'Oh No!',
                    text: err.statusText,
                    delay:2500
                });
            }
        });
    });
});

function textCounter(field, cnt, maxlimit) {         
    var cntfield = document.getElementById(cnt)   
    if (field.value.length > maxlimit)
        field.value = field.value.substring(0, maxlimit);
    else
        cntfield.innerText = maxlimit - field.value.length;
}

$(document).on('click','#sendsms', function () {
    if ($('#textmsg').val() == null || $('#textmsg').val() == "") {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please type a message.',
            delay:2500
        });
    } else {
        var element = $(this);
        $(element).attr('disabled','true').text('Sending SMS...');
        $.ajax({
            url: window.location.origin+'/system_operations/send_collection_sms',
            type: 'POST',
            dataType: 'JSON',
            data: { collection_id : $('#collectionID').val(), message : $('#textmsg').val() },
            success: function (params) {
                $(element).removeAttr('disabled').text('SEND SMS');
                if (params.status === 'success') {
                    PNotify.success({
                        title: 'Success!',
                        text: 'SMS Sent.',
                        delay: 2500
                    });
					$.ajax({
						url: window.location.origin+'/system_operations/get_sms_credit',
						type: 'POST',
						dataType: 'JSON',
						success: function (params) {
							let creditPrice = Intl.NumberFormat('en-US', { style: 'currency', currency: 'LKR' }).format(params.credit);
							$('#creditlbl').html('Available balance: '+creditPrice);
						}
					});
                } else {
                    $(element).removeAttr('disabled').text('SEND SMS');
                    PNotify.error({
                        title: 'Oh No!',
                        text: 'SMS not sent.',
                        delay:2500
                    });
                }
            },
            error: function () {
                $(element).removeAttr('disabled').text('SEND SMS');
                PNotify.error({
                    title: 'Oh No!',
                    text: 'SMS not sent.',
                    delay:2500
                });
            }
        });
    }
});

$('#sendSmsModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var collectionID = button.data('id');
    $('#collection_name').text(button.data('name'));
    $('#collectionID').val(button.data('id'));
    
    $('#textmsg').focus();

    $.ajax({
		url: window.location.origin+'/system_operations/get_sms_credit',
		type: 'POST',
		dataType: 'JSON',
		success: function (params) {
			let creditPrice = Intl.NumberFormat('en-US', { style: 'currency', currency: 'LKR' }).format(params.credit);
			$('#creditlbl').html('Available balance: '+creditPrice);
		}
	});
    var modal = $(this);
});

function saveExcel(obj,id) {
    PNotify.info({
        title: 'Wait..',
        text: 'Saving numbers.....',
        delay:2500
    });
    $.ajax({
        url: window.location.origin + '/system_operations/saveExcelSheet',
        type: 'POST',
        dataType: 'JSON',
        data: {numberObj: obj, collectionID: id},
        success: function (params) {
            loadMainTable();
            if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: params.err,
                    delay:2500
                });
            }
            if (params === true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'All numbers are saved.',
                    delay: 2500
                });
            }
        },
        error: function (err) {
            console.log(err);
            PNotify.error({
                title: 'Oh No!',
                text: 'Cannot read file. Make sure excel template is correct.',
                delay:2500
            });
        }
    });
}

$(document).on('change', '#excelImport', function (evt) {
    let collectionID = $(this).attr('data-id');
    var selectedFile = evt.target.files[0];
    var reader = new FileReader();
    reader.onload = function (event) {
        var data = event.target.result;
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
        workbook.SheetNames.forEach(function(sheetName) {
            var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            var json_object = JSON.stringify(XL_row_object);
            saveExcel(json_object, collectionID);
        });
    };
    var $el = $(this);
    $el.wrap('<form>').closest('form').get(0).reset();
    $el.unwrap();

    reader.onerror = function(event) {
        console.error("File could not be read! Code " + event.target.error.code);
    };
    reader.readAsBinaryString(selectedFile);

});


$('#editCollectionModal').on('hide.bs.modal	', function () {
    loadMainTable();
})