$(document).ready(function() {
    $('.selectpicker').selectpicker();
    get_student_type();
    get_class_years();
    get_payment_type();
});

function get_student_type() {
    $.ajax({
        url: window.location.origin + '/system_operations/load_student_types_for_student_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Type</option>';
                Array.from(params.studentType).map(row => {
                    html = html + '<option value="' + row.studentTypeId + '">' + row.type + '</option>';
                });
                $("#studentType").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

function get_class_years() {
    $.ajax({
        url: window.location.origin + '/system_operations/load_year_for_student_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="' + row.yearid + '">' + row.year + '</option>';
                });
                $("#years").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$('#years').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin + '/system_operations/load_class_for_student_create',
        dataType: 'json',
        type: 'post',
        data: {year_id: $yearid},
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="' + row.classid + '">' + row.type + ' - ' + row.location + '</option>';
                });
                $("#class").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});

function get_payment_type() {
    $.ajax({
        url: window.location.origin + '/system_operations/load_payment_types_for_student_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Payment Type</option>';
                Array.from(params.payment).map(row => {
                    html = html + '<option value="' + row.paymentid + '">' + row.payment + '</option>';
                });
                $("#paymentType").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}


$('#createStudent').on('submit', function(e) {
    e.preventDefault();
    PNotify.closeAll();
    const $funSel = $('#functionSelector').val();

    // create form data for send image and student id
    var formData = new FormData();
    formData.append('profileImage', $('#profileImage')[0].files[0]);
    formData.append('firstName', $('#firstName').val());
    formData.append('lastName', $('#lastName').val());
    formData.append('contactNumber', $('#contactNumber').val());
    formData.append('school', $('#school').val());
    formData.append('address', $('#address').val());
    formData.append('studentType', $('#studentType').val());
    formData.append('class', $('#class').val());
    formData.append('paymentType', $('#paymentType').val());
    formData.append('note', $('#note').val());
    formData.append('nic', $('#nic').val());
    formData.append('manualid', $('#manualid').val());

    var alertNote = PNotify.notice({
        icon: 'fas fa-spinner fa-pulse',
        title: 'Please wait...',
        hide: false
    });

    if ($funSel === 'create') {

        if ($('#studentType').val() === null || $('#class').val() === null || $('#paymentType').val() === null) {
            alertNote.update({
                type: 'error',
                icon: 'fas fa-times-circle',
                title: 'Oh No!',
                text: 'You cannot leave student type, payment type, class  empty!',
                delay: 2500,
                hide: true
            });
            return false;
        } else {

            alertNote.update({
                type: 'notice',
                icon: 'fas fa-spinner fa-pulse',
                title: 'Please wait',
                text: 'Student creating.',
                hide: false
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.err) {
                        PNotify.error({
                            title: 'Oh No!',
                            text: response.err,
                            delay: 3500
                        });
                    }
                    if (response.success === true) {
                        alertNote.update({
                            type: 'success',
                            icon: 'fas fa-check-circle',
                            title: 'Success!',
                            text: 'Student created.',
                            delay: 2500,
                            hide: true
                        });
                        loadMainTable('lastSt', '0');
                        $('#filein').fileinput('clear');
                        $("#createStudent")[0].reset();
                        $('.selectpicker').selectpicker('refresh');
                    }
                    if (response.form_err) {
                        PNotify.closeAll();
                        $('#firstName-error').text(response.form_err.firstName);
                        $('#lastName-error').text(response.form_err.lastName);
                        $('#contactNumber-error').text(response.form_err.contactNumber);
                        $('#address-error').text(response.form_err.address);
                        $('#note-error').text(response.form_err.note);
                        $('#school-error').text(response.form_err.school);
                        $('#nic-error').text(response.form_err.nic);
                    }
                },
                error: function() {
                    alertNote.update({
                        type: 'error',
                        icon: 'fas fa-times-circle',
                        title: 'Oh No!',
                        text: 'Something went wrong.',
                        delay: 2500,
                        hide: true
                    });
                    return false;
                }
            });
        }
    } else if ($funSel === 'update') {

        if ($('#studentType').val() === null || $('#paymentType').val() === null) {
            alertNote.update({
                type: 'error',
                icon: 'fas fa-times-circle',
                title: 'Oh No!',
                text: 'You cannot leave student type, payment type empty!',
                delay: 2500,
                hide: true
            });
            return false;
        } else {

            formData.append('id', $(this).attr('data-id'));

            alertNote.update({
                type: 'notice',
                icon: 'fas fa-spinner fa-pulse',
                title: 'Please wait',
                text: 'Student updating.',
                hide: false
            });

            $.ajax({
                url: window.location.origin + '/system_operations/update_student',
                type: 'post',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.err) {
                        alertNote.update({
                            type: 'error',
                            icon: 'fas fa-times-circle',
                            title: 'Oh No!',
                            text: response.err,
                            delay: 2500,
                            hide: true
                        });
                    } else if (response === true) {
                        alertNote.update({
                            type: 'success',
                            icon: 'fas fa-check-circle',
                            title: 'Success!',
                            text: 'Student updated.',
                            delay: 2500,
                            hide: true
                        });
                        location.reload();
                    }
                    if (response.form_err) {
                        PNotify.closeAll();
                        $('#firstName-error').text(response.form_err.firstName);
                        $('#lastName-error').text(response.form_err.lastName);
                        $('#contactNumber-error').text(response.form_err.contactNumber);
                        $('#address-error').text(response.form_err.address);
                        $('#note-error').text(response.form_err.note);
                        $('#school-error').text(response.form_err.school);
                        $('#nic-error').text(response.form_err.nic);
                    }
                },
                error: function() {
                    alertNote.update({
                        type: 'error',
                        icon: 'fas fa-times-circle',
                        title: 'Oh No!',
                        text: 'Something went wrong.',
                        delay: 2500,
                        hide: true
                    });
                    return false;
                }
            });
        }
    }
});


$('#byid').on('click', function() {
    var promtByName = PNotify.info({
        title: 'Search student',
        text: 'Please enter student ID',
        icon: 'fas fa-question-circle',
        hide: false,
        stack: {
            'dir1': 'down',
            'firstpos1': 25
        },
        modules: {
            Confirm: {
                prompt: true
            },
            Buttons: {
                closer: false,
                sticker: false
            },
            History: {
                history: false
            }
        }
    });
    promtByName.on('pnotify.confirm', function(e) {
        loadMainTable('byId', e.value);
    });
    promtByName.on('pnotify.cancel', function(e) {
        promtByName.cancelClose().update({
            title: 'Bye!',
            text: 'Search canceled.',
            icon: true,
            type: 'error',
            hide: true,
            delay: 2500,
            modules: {
                Confirm: {
                    prompt: false
                },
                Buttons: {
                    closer: true,
                    sticker: true
                }
            }
        });
    });
});

$('#bycontact').on('click', function() {
    var promtByName = PNotify.info({
        title: 'Search student',
        text: 'Please enter contact number',
        icon: 'fas fa-question-circle',
        hide: false,
        stack: {
            'dir1': 'down',
            'firstpos1': 25
        },
        modules: {
            Confirm: {
                prompt: true
            },
            Buttons: {
                closer: false,
                sticker: false
            },
            History: {
                history: false
            }
        }
    });
    promtByName.on('pnotify.confirm', function(e) {
        loadMainTable('byContact', e.value);
    });
    promtByName.on('pnotify.cancel', function(e) {
        promtByName.cancelClose().update({
            title: 'Bye!',
            text: 'Search canceled.',
            icon: true,
            type: 'error',
            hide: true,
            delay: 2500,
            modules: {
                Confirm: {
                    prompt: false
                },
                Buttons: {
                    closer: true,
                    sticker: true
                }
            }
        });
    });
});

function loadMainTable($method, $value) {
    $("#student_table").DataTable({
        "destroy": true,
        "ajax": {
            "url": window.location.origin + "/system_operations/get_student_table",
            "type": "post",
            "data": { method: $method, value: $value }
        },
        "columns": [
            { "data": "name" },
            { "data": "nic" },
            { "data": "contact" },
            { "data": "address" },
            { "data": "school" },
            { "data": "type" },
            { "data": "class" },
            { "data": "year" },
            { "data": "paymentType" },
            { "data": "note" },
            { "data": "id_issue" },
            { "data": "id_number" },
            { "data": "actions" }
        ]
    });
}


$(document).on('click', '.edit', function() {
    const $studentid = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin + '/system_operations/get_student',
        type: 'post',
        dataType: 'json',
        data: { student_id: $studentid },
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err,
                    delay: 2500
                });
            } else if (response.success === true) {
                const $student = response.student;
                $('#firstName').val($student.firstName).parent().addClass('is-filled');
                $('#lastName').val($student.lastName).parent().addClass('is-filled');
                $('#address').val($student.address).parent().addClass('is-filled');
                $('#school').val($student.school).parent().addClass('is-filled');
                $('#note').val($student.note).parent().addClass('is-filled');
                $('#nic').val($student.nic).parent().addClass('is-filled');
                $('#contactNumber').val($student.contactNumber).parent().addClass('is-filled');
                $('#studentType').val($student.studentType);
                $('#class').val($student.class);
                $('#paymentType').val($student.paymentType);
                $('.selectpicker').selectpicker('refresh');
                $('#functionSelector').val('update');
                $('#createStudent').attr('data-id', $studentid);
                if (!$('#formButtons button[type="button"]')[0]) {
                    $("#formButtons").append('<button type="button" class="btn btn-primary" onclick="location.reload();">Cancel</button>');
                }
                $('button[type="submit"]').text('Update');
                $('.fileinput-new img').attr('src', $student.profileImage);
            }
        },
        error: function() {
            PNotify.error({
                title: 'Oh No!',
                text: 'Something went wrong!',
                delay: 2500
            });
        }
    })
});


$(document).on('click', '.remove', function() {
    var table = $("#student_table").DataTable();
    const $stid = $(this).attr('data-id');
    var elem = $(this).parents('tr');
    $.ajax({
        url: window.location.origin + '/system_operations/delete_student',
        dataType: 'json',
        type: 'post',
        data: {
            student_id: $stid
        },
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err,
                    delay: 2500
                });
            } else if (response === true) {
                table.row(elem).remove().draw();
                PNotify.success({
                    title: 'Success!',
                    text: 'Student deleted.',
                    delay: 2500
                });
            }
        },
        error: function() {
            PNotify.error({
                title: 'Oh No!',
                text: 'Something went wrong!',
                delay: 2500
            });
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

$(document).on('keyup', '#searchbyname', function() {
    let element = $(this);
    loadMainTable('byname', $(element).val());
});

$(document).on('click', '.viewstudent', function() {
    $.ajax({
        url: window.location.origin + '/system_operations/view_student_st_management',
        type: 'POST',
        dataType: 'JSON',
        data: { student_id: $(this).attr('data-id') },
        success: function(params) {
            Array.from(params.student).map(row => {
                for(const name in row) {
                    document.getElementById(name).innerHTML = row[name];
                }
            });
            $('#viewstudentmodal').modal('show');
        }
    });
});