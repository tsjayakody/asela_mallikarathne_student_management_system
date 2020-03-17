$('#year').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin + '/system_operations/load_class_for_student_details',
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

$(document).ready(function() {
    get_year();
});

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_student_details_report',
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

$('#class').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $class = $(this).find('option').eq(clickedIndex).val();


    $("#student_table").DataTable({
        "destroy": true,
        "dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'pdfHtml5'
        ],
        "ajax": {
            "url": window.location.origin + "/system_operations/get_student_details_table",
            "type": "post",
            "data": { class_id: $class }
        },
        "columns": [
            { "data": "no" },
            { "data": "name" },
            { "data": "address" },
            { "data": "contact" },
            { "data": "studentid" },
            { "data": "nic" }
        ]
    });

});