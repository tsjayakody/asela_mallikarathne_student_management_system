$(document).ready(function() {
    loadMainTable();
});

function loadMainTable() {
    $("#modelPaperTable").DataTable({
        destroy: true,
        ajax: window.location.origin + "/system_operations/get_model_paper_table",
        columns: [
            { data: "no" },
            { data: "paperType" },
            { data: "paperTypeCode" },
            { data: "action" }
        ]
    });
}

$(document).on("submit", "#modelPaperForm", function(e) {
    e.preventDefault();
    const $funSel = $("#functionSelector").val();
    if ($funSel === "create") {
        const $url = $(this).attr("action");
        $.ajax({
            url: $url,
            type: "post",
            dataType: "json",
            data: {
                paperType: $("#paperType").val(),
                paperTypeCode: $("#paperTypeCode").val()
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
                        text: "Model Paper Created."
                    });
                    $("#resetForm").click();
                }
                if (response.form_error) {
                    $('#paperType-error').text(response.form_error.paperType);
                    $('#paperTypeCode-error').text(response.form_error.paperTypeCode);
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
    } else if ($funSel === "update") {
        $.ajax({
            url: window.location.origin + '/system_operations/update_model_paper',
            type: "post",
            dataType: "json",
            data: {
                paperType: $("#paperType").val(),
                paperTypeCode: $("#paperTypeCode").val(),
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
                        text: "Model Paper Updated."
                    });
                    $("#resetForm").click();
                    location.reload();
                }
                if (response.form_error) {
                    $('#paperType-error').text(response.form_error.paperType);
                    $('#paperTypeCode-error').text(response.form_error.paperTypeCode);
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
    const $modelPaperID = $(this).attr("data-id");
    $.ajax({
        url: window.location.origin + "/system_operations/get_model_paper_for_update",
        type: "post",
        dataType: "json",
        data: { id: $modelPaperID },
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: "Oh No!",
                    text: response.err
                });
            } else if (response.success === true) {
                const $modelPaper = response.modelPapers;
                $("#paperType")
                    .val($modelPaper.paperType)
                    .parent()
                    .addClass("is-filled");
                $("#paperTypeCode")
                    .val($modelPaper.paperTypeCode)
                    .parent()
                    .addClass("is-filled");

                $("#functionSelector").val("update");
                $("#modelPaperForm").attr("data-id", $modelPaperID);
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

$(document).on('click', '.remove', function() {
    const $modelPaperID = $(this).attr('data-id');
    $.ajax({
        url: window.location.origin + '/system_operations/delete_model_paper',
        dataType: 'json',
        type: 'post',
        data: {
            model_paper_id: $modelPaperID
        },
        success: function(response) {
            if (response.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            } else if (response === true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'Model Paper deleted.'
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