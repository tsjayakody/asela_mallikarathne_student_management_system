$(document).ready(function() {
	$('.selectpicker').selectpicker();
    get_year();
    $("#atttable").DataTable();

	$('.datepicker').datetimepicker({
        defaultDate: new Date(),
		viewMode: "days",
		format: "YYYY-MM-DD",
		toolbarPlacement: "top",
		allowInputToggle: true,
		icons: {
			time: "fa fa-time",
			date: "fa fa-calendar",
			up: "fa fa-chevron-up",
			down: "fa fa-chevron-down",
			previous: "fa fa-chevron-left",
			next: "fa fa-chevron-right",
			today: "fa fa-screenshot",
			clear: "fa fa-trash",
			close: "fa fa-remove"
		}
	}).parent().addClass('is-filled');
});

$(".datepicker").on("dp.show", function(e) {
	$(e.target).data("DateTimePicker").viewMode("days"); 
});

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_student_attendances_report',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="'+row.yearid+'">'+row.year+'</option>';
                });
                $("#select_year").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$('#select_year').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_for_student_attendance',
        dataType: 'json',
		type: 'post',
		data: {year_id: $yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#select_class").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
					text: params.err,
					delay: 2500
                });
            }
        }
    });
});

$(document).on('click','#btnSearch',function () {
    let select_class = $('#select_class').val();
    let to_date = $('#todt').val();
	let from_date = $('#fromdt').val();
	
	if (select_class === null || select_class === undefined || select_class === "") {
		PNotify.error({
			title: 'Oh No!',
			text: 'Please select a class.',
			delay: 2500
		});
		return false;
	} else if (to_date === null || to_date === undefined || to_date === "") {
		PNotify.error({
			title: 'Oh No!',
			text: 'Please select start date.',
			delay: 2500
		});
		return false;
	} else if (from_date === null || from_date === undefined || from_date === "") {
		PNotify.error({
			title: 'Oh No!',
			text: 'Please select end date.',
			delay: 2500
		});
		return false;
	} else {
		$("#atttable").DataTable({
			destroy: true,
			"dom": 'Bfrtip',
			"buttons": [
				'excelHtml5',
				'pdfHtml5'
			],
			ajax: {
				url: window.location.origin +"/system_operations/get_att_report",
				type: "post",
				data: { class_id: select_class, from_date: from_date, to_date: to_date }
			},
			columns: [
				{ data: "name" },
				{ data: "id" },
				{ data: "contact" },
				{ data: "attCount" }
			]
		});
	}
});