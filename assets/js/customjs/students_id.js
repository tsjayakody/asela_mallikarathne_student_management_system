$(document).ready(function() {
    $('.selectpicker').selectpicker();
    get_year();
});

$(document).on('submit','#form_issueid',function (event) {
    event.preventDefault();

    $.ajax({
        url: window.location.origin+'/system_operations/issue_id',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function (data) {
            if (data.success === true) {
                $("#imgProfile").attr("src", data.profileImage);
				$("#tbl_sts")
					.removeClass("fail success")
					.addClass(data.stClass)
					.text(data.stText);
				$("#tbl_stname").text(data.studentName);
				$("#tbl_stid").text(data.studentId);
				$("#tbl_class").text(data.studentClass);
				$("#tbl_sttype").text(data.studentType);
                $("#tbl_stpaytype").text(data.classPaymentType);
                
                if (data.stClass === 'success') {
                    $('#form_issueid').trigger('reset');
                }
            } else {
                PNotify.error({
                    title: "Oh No!",
                    text: data.err,
                    delay: 2500
                });
            }
        },
        error: function () {
            PNotify.error({
				title: "Oh No!",
				text: "Something went wrong.",
				delay: 2500
			});
        }
    });
});

$(document).on('click','#print_single',function () {
    let url =  window.location.origin+'/system_operations/generate_single_id/'+$('#student_id').val();
    window.open(url, '_blank'); 
});


$(document).on('submit','#bulk_print_form',function (e) {
    e.preventDefault();
    var type = $("input[name='is_issued']:checked").val();
    var classid = $('#selectClass').val();
    let url =  window.location.origin+'/system_operations/print_bulk_id/'+classid+'/'+type;
    window.open(url, '_blank');
});


function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_student_id',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="'+row.yearid+'">'+row.year+'</option>';
                });
                $("#selectYear").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$('#selectYear').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_for_student_id',
        dataType: 'json',
        type: 'post',
        data: {year_id:$yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.class).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#selectClass").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});

// function get_class() {
//     $.ajax({
//         url: window.location.origin+'/system_operations/load_class_for_id_print',
//         dataType: 'json',
//         type: 'post',
//         success: function(params) {
//             if(params !== false) {
//                 let html = '<option disabled selected >Select Class</option>';
//                 Array.from(params.class).map(row => {
//                     html = html + '<option value="'+row.classid+'">'+row.year+' - '+row.type+' - '+row.location+'</option>';
//                 });
//                 $("#selectClass").html(html).selectpicker('refresh');
//             } else if (params.err) {
//                 PNotify.error({
//                     title: 'Oh No!',
//                     text: response.err
//                 });
//             }
//         }
//     });
// }