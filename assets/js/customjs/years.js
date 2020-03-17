function loadMainTable() {
	$("#year_table").DataTable({
		destroy: true,
		ajax: window.location.origin + "/system_operations/get_years_table",
		columns: [{ data: "no" }, { data: "year" }, { data: "actions" }]
	});
}

$(document).on("submit", "#yearform", function(e) {
	e.preventDefault();
	$.ajax({
		url: $(this).attr("action"),
		type: "post",
		dataType: "json",
		data: { year: document.getElementById("year").value },
		success: function(response) {
			if (response.err) {
				PNotify.error({
					title: "Oh No!",
					text: response.err
				});
			} else if (response === true) {
				PNotify.success({
					title: "Success!",
					text: "Year created."
				});
			}
			if (response.form_error) {
				document.getElementById("year-error").innerHTML = "";
				document.getElementById("year-error").innerHTML =
					response.form_error.year;
			}
		},
		error: function(err) {
			PNotify.error({
				title: "Oh No!",
				text: "Something went wrong."
			});
			console.log(err);
		},
		complete: function() {
			loadMainTable();
		}
	});
});

$(document).ready(function() {
	loadMainTable();
});

$(document).on("click", ".remove", function() {
	$.ajax({
		url: document.location.origin + "/system_operations/delete_year",
		dataType: "json",
		type: "post",
		data: { id: $(this).attr("data-id") },
		success: function(response) {
			if (response.err) {
				PNotify.error({
					title: "Oh No!",
					text: response.err
				});
			} else if (response === true) {
				PNotify.success({
					title: "Success!",
					text: "Year deleted."
				});
				loadMainTable();
			}
		},
		error: function(err) {
			PNotify.error({
				title: "Oh No!",
				text: "Something went wrong."
			});
			console.log(err);
		},
		complete: function() {
			loadMainTable();
		}
	});
});

var notice;
$(document).on("click", ".edit", function() {
	let id = $(this).attr("data-id");
	notice = PNotify.notice({
		title: "Input Needed",
		text: "Enter the year.",
		icon: "fas fa-question-circle",
		hide: false,
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
	notice.on("pnotify.confirm", function(e) {
		notice.cancelClose();
		$.ajax({
			url: window.location.origin + "/system_operations/update_year",
			type: "post",
			dataType: "json",
			data: { year: e.value, id: id },
			success: function(response) {
				if (response.err) {
					notice.cancelClose().update({
						title: "Oh No!",
						text: response.err,
						icon: true,
						type: "error",
						hide: true,
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
				} else if (response === true) {
					notice.cancelClose().update({
						title: "Success!",
						text: "Year updated.",
						icon: true,
						type: "success",
						hide: true,
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
					loadMainTable();
				}
			},
			error: function(error) {
				notice.cancelClose().update({
					title: "Oh No!",
					text: "Something went wrong!",
					icon: true,
					type: "error",
					hide: true,
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
				console.log(error);
			}
		});
	});
	notice.on("pnotify.cancel", function(e) {
		notice.cancelClose().update({
			title: "Bye.",
			text: "You canceled operation.",
			icon: true,
			type: "error",
			hide: true,
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

$(document).on("click", ".form-control", function(event) {
	var element = $(this);
	var errorElem = "#" + $(element).attr("id") + "-error";
	if ($(errorElem).text() !== "") {
		$(errorElem).text('');
	}
});
