$(document).ready(function () {
    get_year();
    get_class_type();
    get_paper();
});


$('#selectYearC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin + '/system_operations/load_class_for_result_report',
        dataType: 'json',
        type: 'post',
        data: {year_id: $yearid},
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#selectClassC").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});

$('#selectYearSMS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin + '/system_operations/load_class_for_result_report',
        dataType: 'json',
        type: 'post',
        data: {year_id: $yearid},
        success: function(params) {
            if (params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#selectClassSMS").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
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
                $("#selectYearI").html(html).selectpicker('refresh');
                $("#selectYearC").html(html).selectpicker('refresh');
                $("#selectYearSMS").html(html).selectpicker('refresh');
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
                $("#selectClassTypeI").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

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
                $("#selectModelPaperI").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$(document).on('click','#getClassReportBtn',function () {
    let selectedClass = $('#selectClassC').val(); // get class id
    let selectedExam = $('#selectExamC').val(); // get exam id
    
    $("#result_table").DataTable({
        "destroy": true,
        "dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'pdfHtml5'
        ],
        "ajax": {
            "url": window.location.origin + "/system_operations/get_class_result_report",
            "type": "post",
            "data": {class_id : selectedClass, exam_id : selectedExam}
        },
        "columns": [
            { "data": "class" },
            { "data": "student" },
            { "data": "idNo" },
            { "data": "result" },
            { "data": "cRank" },
            { "data": "iRank" }
        ]
    });
});

$('#selectClassC').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $class = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/load_exam_for_result_report',
        dataType: 'json',
        type: 'post',
        data: {class_id:$class},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Exam</option>';
                Array.from(params.exams).map(row => {
                    html = html + '<option value="'+row.examid+'">'+row.exam+'</option>';
                });
                $("#selectExamC").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else {
                PNotify.error({
                    title: 'Oh No!',
                    text: 'No exams for this class'
                });
                let html = '<option disabled selected >Select Exam</option>';
                $("#selectExamC").html(html).selectpicker('refresh');
            }
        }
    });
});

$('#selectClassSMS').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $class = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/load_exam_for_result_report',
        dataType: 'json',
        type: 'post',
        data: {class_id:$class},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Exam</option>';
                Array.from(params.exams).map(row => {
                    html = html + '<option value="'+row.examid+'">'+row.exam+'</option>';
                });
                $("#selectExamSMS").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else {
                PNotify.error({
                    title: 'Oh No!',
                    text: 'No exams for this class'
                });
                let html = '<option disabled selected >Select Exam</option>';
                $("#selectExamSMS").html(html).selectpicker('refresh');
            }
        }
    });
});


$(document).on('click','#getIslandReport',function () {
    let year = $('#selectYearI').val();
    let classType = $('#selectClassTypeI').val();
    let paper = $('#selectModelPaperI').val();

    if (year === null || classType === null || paper === null) {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please select all the options.',
            delay:2500
        });
    } else {
        $("#result_table").DataTable({
            "destroy": true,
            "dom": 'Bfrtip',
            "buttons": [
                'excelHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                "url": window.location.origin + "/system_operations/get_island_result_report",
                "type": "post",
                "data": {year_id : year, class_type_id : classType, paper_id : paper}
            },
            "columns": [
                { "data": "class" },
                { "data": "student" },
                { "data": "idNo" },
                { "data": "result" },
                { "data": "cRank" },
                { "data": "iRank" }
            ]
        });
    }
});


$('#sendsmsmodal').on('shown.bs.modal', function (e) {
	$.ajax({
		url: window.location.origin+'/system_operations/get_sms_credit',
		type: 'POST',
		dataType: 'JSON',
		success: function (params) {
			let creditPrice = Intl.NumberFormat('en-US', { style: 'currency', currency: 'LKR' }).format(params.credit);
			$('#creditlbl').html('Available balance: '+creditPrice);
		}
	});
});

$(document).on('click','#sendSmsBtn', function () {
    if ($('#selectClassSMS').val() == null || $('#selectExamSMS').val() == null) {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please select all the options.',
            delay:2500
        });
    } else {
        var element = $(this);
        $(element).attr('disabled','true').text('Sending SMS...');
        $.ajax({
            url: window.location.origin+'/system_operations/send_results_sms',
            type: 'POST',
            dataType: 'JSON',
            data: { class_id : $('#selectClassSMS').val(), exam_id : $('#selectExamSMS').val() },
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

