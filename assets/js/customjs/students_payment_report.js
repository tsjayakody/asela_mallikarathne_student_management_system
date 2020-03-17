$(document).ready(function() {
	$('.selectpicker').selectpicker();
    get_year();
    $("#pymttable").DataTable();

	$('.datepicker').datetimepicker({
        defaultDate: new Date(),
		viewMode: "months",
		format: "YYYY-MM",
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
	$(e.target).data("DateTimePicker").viewMode("months"); 
});

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_student_payments_report',
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
        url: window.location.origin+'/system_operations/get_class_for_student_payments',
        dataType: 'json',
		type: 'post',
		data: {year_id: $yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.year+' - '+row.type+' - '+row.location+'</option>';
                });
                $("#select_class").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: params.err
                });
            }
        }
    });
});

$(document).on('click','#btnSearch',function () {
    let select_class = $('#select_class').val();
    let inputMonth = $('#inputMonth').val();
	
	if (select_class === null || select_class === undefined || select_class === "") {
		PNotify.error({
			title: 'Oh No!',
			text: 'Please select a class.',
			delay: 2500
		});
		return false;
	} else if (inputMonth === null || inputMonth === undefined || inputMonth === "") {
		PNotify.error({
			title: 'Oh No!',
			text: 'Please select month',
			delay: 2500
		});
		return false;
	} else {
		$("#pymttable").DataTable({
			destroy: true,
			"dom": 'Bfrtip',
			"buttons": [
				'excelHtml5',
				'pdfHtml5'
			],
			ajax: {
				url: window.location.origin +"/system_operations/get_pymt_report",
				type: "post",
				data: { class_id: select_class, month: inputMonth }
			},
			columns: [
				{ data: "name" },
				{ data: "id" },
				{ data: "contact" },
                { data: "pymtstatus" },
                { data: "date" },
                { data: "amount" }
			]
		});
	}
});