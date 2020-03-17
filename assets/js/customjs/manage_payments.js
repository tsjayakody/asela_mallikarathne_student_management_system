$("#btnEDP").on("click", function() {
	var defaultPaymentsPrompt = PNotify.notice({
		title: "Default payments",
		text: "Enter student ID",
		icon: "fas fa-question-circle",
		hide: false,
		stack: {
			dir1: "down",
			firstpos1: 25
		},
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

	defaultPaymentsPrompt.on("pnotify.confirm", function(e) {
		$.ajax({
			url: window.location.origin + "/system_operations/enter_default_payment",
			type: "post",
			dataType: "json",
			data: { student_id: e.value },
			success: function(data) {
				if (data.err) {
					defaultPaymentsPrompt.update({
						title: "Default payments",
						text: data.err,
						icon: true,
						type: "error",
						hide: true,
						delay: 2500,
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
				}

				if (data.success === true) {
					$("#imgProfile").attr("src", data.profileImage);
					$("#tblPS")
						.removeClass("fail success")
						.addClass(data.stClass)
						.text(data.stText);
					$("#tblA").text(data.currentAmount);
					$("#tblN").text(data.studentName);
					$("#tblI").text(data.studentId);
					$("#tblC").text(data.studentClass);
					$("#tblLPD").text(data.lastPaymentDate);
					$("#tblLPA").text(data.lastPaymentAmount);
					$("#btnEP").attr("data-id", data.stkey);
					$("#btnPH").attr("data-id", data.stkey);

					defaultPaymentsPrompt.cancelClose().update({
						title: "Default payments",
						text: "Enter student ID",
						icon: "fas fa-question-circle",
						hide: false,
						stack: {
							dir1: "down",
							firstpos1: 25
						},
						modules: {
							Confirm: {
								prompt: true,
								promptValue: ""
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
				}
			},
			error: function(error) {
				defaultPaymentsPrompt.update({
					title: "Default payments",
					text: "Operation failed",
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
			}
		});
	});

	defaultPaymentsPrompt.on("pnotify.cancel", function(e) {
		defaultPaymentsPrompt.cancelClose().update({
			title: "Default payments",
			text: "Operation terminated.",
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

$("#customPaymentForm").on("submit", function(e) {
	PNotify.closeAll();
	e.preventDefault();

	$.ajax({
		url: window.location.origin + "/system_operations/enter_custom_payment",
		type: "post",
		dataType: "json",
		data: $(this).serialize(),
		success: function(data) {
			if (data.err) {
				PNotify.error({
					title: "Oh No!",
					text: data.err,
					delay: 2500
				});
			}

			if (data.success === true) {
				$("#imgProfile").attr("src", data.profileImage);
				$("#tblPS")
					.removeClass("fail success")
					.addClass(data.stClass)
					.text(data.stText);
				$("#tblA").text(data.currentAmount);
				$("#tblN").text(data.studentName);
				$("#tblI").text(data.studentId);
				$("#tblC").text(data.studentClass);
				$("#tblLPD").text(data.lastPaymentDate);
				$("#tblLPA").text(data.lastPaymentAmount);
				$("#btnPH").attr("data-id", data.stkey);

				$("#resetBtn").click();
				$("#closeBtn").click();
			}
		},
		error: function() {
			PNotify.error({
				title: "Oh No!",
				text: "Something went wrong!",
				delay: 2500
			});
		}
	});
});

$("#btnPH").on("click", function() {
	let $stid = $(this).attr("data-id");

	if ($stid === "" || $stid === null) {
		PNotify.closeAll();
		var report = PNotify.notice({
			title: "Payment history",
			text: "Enter student ID",
			icon: "fas fa-question-circle",
			hide: false,
			stack: {
				dir1: "down",
				firstpos1: 25
			},
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

		report.on("pnotify.confirm", function(e) {
			$stid = e.value;
			$("#stidspan").text($stid);
			loadMainTable($stid);
			$("#paymentHistoryModel").modal("show");
		});

		report.on("pnotify.cancel", function(e) {
			report.cancelClose().update({
				title: "Payment history",
				text: "Operation terminated.",
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
			return false;
		});
	} else {
		$("#stidspan").text($stid);
		loadMainTable($stid);
		$("#paymentHistoryModel").modal("show");
	}
});

function loadMainTable($stid) {
	$("#payHistTbl").DataTable({
		destroy: true,
		ajax: {
			url:
				window.location.origin +
				"/system_operations/get_student_payment_history_table",
			type: "post",
			data: { student_id: $stid }
		},
		columns: [
			{ data: "no" },
			{ data: "date" },
			{ data: "payfor" },
			{ data: "amount" },
			{ data: "actions" }
		]
	});
}

$(document).on("click", ".edit", function() {
	let payid = $(this).attr("data-id");
	PNotify.closeAll();
	$("#paymentHistoryModel").modal("hide");
	var editpayment = PNotify.notice({
		title: "Edit payment",
		text: "Enter new payment",
		icon: "fas fa-question-circle",
		hide: false,
		stack: {
			dir1: "down",
			firstpos1: 25
		},
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

	editpayment.on("pnotify.confirm", function(e) {
		PNotify.closeAll();
		if (e.value === "" || e.value === null) {
			PNotify.error({
				title: "Oh No!",
				text: "Please fill the field",
				delay: 2500
			});
		} else {
			$.ajax({
				url: window.location.origin + "/system_operations/edit_payment",
				type: "post",
				dataType: "json",
				data: { payment_id: payid, value: e.value },
				success: function(params) {
					if (params.err) {
						PNotify.error({
							title: "Oh No!",
							text: params.err,
							delay: 2500
						});
					} else if (params.success === true) {
						PNotify.success({
							title: "Success",
							text: "Amount changed successfully.",
							delay: 2500
						});
					}
				},
				error: function() {
					PNotify.error({
						title: "Oh No!",
						text: "Something went wrong.",
						delay: 2500
					});
				}
			});
		}
	});

	editpayment.on("pnotify.cancel", function(e) {
		editpayment.cancelClose().update({
			title: "Edit payment",
			text: "Operation terminated.",
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
		return false;
	});
});

$(document).on("click", ".remove", function() {
	PNotify.closeAll();
	$("#paymentHistoryModel").modal("hide");
	$.ajax({
		url: window.location.origin + "/system_operations/delete_payment",
		type: "post",
		dataType: "json",
		data: { payment_id: $(this).attr("data-id") },
		success: function(params) {
			if (params.err) {
				PNotify.error({
					title: "Oh No!",
					text: params.err,
					delay: 2500
				});
			} else if (params.success === true) {
				PNotify.success({
					title: "Success",
					text: "Amount deleted successfully.",
					delay: 2500
				});
			}
		},
		error: function() {
			PNotify.error({
				title: "Oh No!",
				text: "Something went wrong.",
				delay: 2500
			});
		}
	});
});

$(document).ready(function() {
	$("#monthYear").datetimepicker({
		viewMode: "months",
		format: "MM/YYYY",
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
	});
});

$("#monthYear").on("dp.show", function(e) {
	$(e.target).data("DateTimePicker").viewMode("months"); 
});