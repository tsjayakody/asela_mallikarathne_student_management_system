$(document).ready(function() {
	loadMainTable();
	get_paper();
	get_exam_type();

	$('.selectpicker').selectpicker();
	get_year();

	$('#datepicker').datetimepicker({
		defaultDate: new Date(),
		format: 'L'
	}).parent().addClass('is-filled');

	$('#timepicker').datetimepicker({
		defaultDate: new Date(),
		format: 'LT'
  	}).parent().addClass('is-filled');
});

function loadMainTable() {
	$("#examstable").DataTable({
		"destroy": true,
		"ajax": window.location.origin + "/system_operations/get_exams_table",
		"columns": [
			{ "data": "class" },
			{ "data": "paper" },
			{ "data": "examType" },
            { "data": "date" },
            { "data": "time" },
            { "data": "notes" },
            { "data": "actions" }
		]
	});
}

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_create_exams',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="'+row.yearid+'">'+row.year+'</option>';
                });
                $("#yearSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$('#yearSelect').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_for_exam_create',
        dataType: 'json',
        type: 'post',
        data: {year_id: $yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#classSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});

function get_paper() {
	$.ajax({
        url: window.location.origin+'/system_operations/get_paper_for_exam_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Paper</option>';
                Array.from(params.papers).map(row => {
                    html = html + '<option value="'+row.paperid+'">'+row.paperType+' ( '+row.paperCode+' ) '+'</option>';
                });
                $("#paperSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

function get_exam_type() {
	$.ajax({
        url: window.location.origin+'/system_operations/get_exam_type_for_exam_create',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Exam Type</option>';
                Array.from(params.examType).map(row => {
                    html = html + '<option value="'+row.examTypeid+'">'+row.type+' ( '+row.typeCode+' ) '+'</option>';
                });
                $("#examTypeSelect").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$(document).on('submit','#createExam',function (e) {
	e.preventDefault();
    const $funSel = $('#functionSelector').val();
    if ($funSel === 'create') {
        const $class = $('#classSelect').val();
        const $paper = $('#paperSelect').val();
        const $examType = $('#examTypeSelect').val();
        const $date = $('#datepicker').val();
        const $time = $('#timepicker').val();
        const $note = $('#note').val();

        if ($class === null || $paper === null || $examType === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave class, paper or exam type empty!'
            });
            return false;
        } else {
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                dataType: 'json',
                data: {
                    class : $class,
                    paper : $paper,
                    examType : $examType,
                    date : $date,
                    time : $time,
                    note : $note
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
                            text: 'Exam created.'
                        });
                        $('#resetForm').click();
                    }
                    if (response.form_err) {
                        $('#datepicker-error').text(response.form_err.date);
                        $('#timepicker-error').text(response.form_err.time);
                        $('#note-error').text(response.form_err.note);
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
        const $class = $('#classSelect').val();
        const $paper = $('#paperSelect').val();
        const $examType = $('#examTypeSelect').val();
        const $date = $('#datepicker').val();
        const $time = $('#timepicker').val();
        const $note = $('#note').val();

        if ($class === null || $paper === null || $examType === null) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You cannot leave class, paper or exam type empty!'
            });
            return false;
        } else {
            $.ajax({
                url: window.location.origin+'/system_operations/update_exam',
                type: 'post',
                dataType: 'json',
                data: {
                    class : $class,
                    paper : $paper,
                    examType : $examType,
                    date : $date,
                    time : $time,
                    note : $note,
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
                            text: 'Exam updated.'
                        });
                        $('#resetForm').click();
                        location.reload();
                    }
                    if (response.form_err) {
                        $('#datepicker-error').text(response.form_err.date);
                        $('#timepicker-error').text(response.form_err.time);
                        $('#note-error').text(response.form_err.note);
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



$(document).on('click','.edit',function(){
    const $examid = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/get_exam',
        type: 'post',
        dataType: 'json',
        data: {exam_id:$examid},
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response.success === true) {
                const $exam = response.exam;
                $('#datepicker').val($exam.date).parent().addClass('is-filled');
                $('#timepicker').val($exam.time).parent().addClass('is-filled');
                $('#note').val($exam.note).parent().addClass('is-filled');
                $('#classSelect').val($exam.class);
                $('#paperSelect').val($exam.paper);
                $('#examTypeSelect').val($exam.examType);
                $('.selectpicker').selectpicker('refresh');
                $('#functionSelector').val('update');
                $('#createExam').attr('data-id',$examid);
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
    const $examid = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/delete_exam',
        dataType: 'json',
        type: 'post',
        data: {
            examid:$examid
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
                    text: 'Exam deleted.'
                });
            }
        },
        error: function(error) {
            PNotify.error({
                title: 'Oh No!',
                text: 'You can not delete this because of dependancies.'
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