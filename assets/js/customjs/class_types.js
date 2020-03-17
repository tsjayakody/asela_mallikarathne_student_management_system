$(document).ready(function() {
	loadMainTable();
});

function loadMainTable() {
	$("#classTypeTable").DataTable({
		destroy: true,
		ajax: window.location.origin + "/system_operations/get_class_types_table",
		columns: [
			{ data: "no" },
			{ data: "classType" },
			{ data: "classTypeCode" },
			{ data: "studentCharge" },
			{ data: "action" }
		]
	});
}

$(document).on("submit", "#classTypeForm", function(e) {
	e.preventDefault();
	const $funSel = $("#functionSelector").val();
	if ($funSel === "create") {
		const $url = $(this).attr("action");
		$.ajax({
			url: $url,
			type: "post",
			dataType: "json",
			data: {
				classType: $("#classType").val(),
				classTypeCode: $("#classTypeCode").val(),
				studentCharge: $("#studentCharge").val()
			},
			success: function(response) {
				if (response.err) {
					PNotify.error({
						title: "Oh No!",
						text: response.err
					});
				} else if (response === true) {
					PNotify.success({
						title: "Success!",
						text: "Class Type Created."
					});
					$("#resetForm").click();
				}
				if (response.form_error) {
					document.getElementById("classType-error").innerHTML =
						response.form_error.classType;
					document.getElementById("classTypeCode-error").innerHTML =
						response.form_error.classTypeCode;
					document.getElementById("studentCharge-error").innerHTML =
						response.form_error.studentCharge;
				}
			},
			error: function(error) {
				PNotify.error({
					title: "Oh No!",
					text: "Something went wrong!"
				});
				console.log(error);
			},
			complete: function() {
				loadMainTable();
			}
		});
	} else if($funSel === "update") {
        $.ajax({
			url: window.location.origin+'/system_operations/update_class_type',
			type: "post",
			dataType: "json",
			data: {
				classType: $("#classType").val(),
				classTypeCode: $("#classTypeCode").val(),
                studentCharge: $("#studentCharge").val().replace(",", ""),
                id: $(this).attr('data-id')
			},
			success: function(response) {
				if (response.err) {
					PNotify.error({
						title: "Oh No!",
						text: response.err
					});
				} else if (response === true) {
					PNotify.success({
						title: "Success!",
						text: "Class Type Updated."
					});
                    $("#resetForm").click();
                    location.reload();
				}
				if (response.form_error) {
					$('#classType-error').text(response.form_error.classType);
					$('#classTypeCode-error').text(response.form_error.classTypeCode);
					$('#studentCharge-error').text(response.form_error.studentCharge);					
				}
			},
			error: function(error) {
				PNotify.error({
					title: "Oh No!",
					text: "Something went wrong!"
				});
				console.log(error);
			},
			complete: function() {
				loadMainTable();
			}
		});
    }
});

$(document).on("click", ".edit", function() {
	const $classTypeId = $(this).attr("data-id");
	$.ajax({
		url:
			window.location.origin + "/system_operations/get_class_type_for_update",
		type: "post",
		dataType: "json",
		data: { id: $classTypeId },
		success: function(response) {
			if (response.err) {
				PNotify.error({
					title: "Oh No!",
					text: response.err
				});
			} else if (response.success === true) {
				const $classType = response.classType;
				$("#classType")
					.val($classType.classType)
					.parent()
					.addClass("is-filled");
				$("#classTypeCode")
					.val($classType.classTypeCode)
					.parent()
					.addClass("is-filled");
				$("#studentCharge")
					.val($classType.studentCharges)
					.parent()
					.addClass("is-filled");

				$("#functionSelector").val("update");
				$("#classTypeForm").attr("data-id", $classTypeId);
				if (!$('#formButtons button[type="button"]')[0]) {
					$("#formButtons").append('<button type="button" class="btn btn-primary" onclick="location.reload();">Cancel</button>');
				}
				$('button[type="submit"]').text("Update");
			}
		},
		error: function(error) {
			PNotify.error({
				title: "Oh No!",
				text: "Something went wrong!"
			});
			console.log(error);
		}
	});
});

$(document).on('click','.remove',function(){
    const $classTypeId = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin+'/system_operations/delete_class_type',
        dataType: 'json',
        type: 'post',
        data: {
            class_type_id:$classTypeId
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
                    text: 'Class type deleted.'
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