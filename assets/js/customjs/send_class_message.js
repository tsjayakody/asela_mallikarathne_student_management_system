function textCounter(field, cnt, maxlimit) {         
    var cntfield = document.getElementById(cnt)   
    if (field.value.length > maxlimit)
        field.value = field.value.substring(0, maxlimit);
    else
        cntfield.innerText = maxlimit - field.value.length;
}

$(document).ready(function(){
    $('#textmsg').focus();
    $('.selectpicker').selectpicker();
    get_year();

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

$(document).on('click','#sendsms', function () {
    if ($('#select_class').val() == null) {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please select a class.',
            delay:2500
        });
    } else if ($('#textmsg').val() == null || $('#textmsg').val() == "") {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please type a message.',
            delay:2500
        });
    } else {
        var element = $(this);
        $(element).attr('disabled','true').text('Sending SMS...');
        $.ajax({
            url: window.location.origin+'/system_operations/send_class_sms',
            type: 'POST',
            dataType: 'JSON',
            data: { class_id : $('#select_class').val(), message : $('#textmsg').val() },
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

$('#select_year').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/load_class_for_send_sms',
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

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_student_send_sms',
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