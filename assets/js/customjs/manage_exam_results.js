$(document).ready(function(){
    get_year();
    get_year_search();
});

function get_year() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_exam_results',
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




$('#select_class').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $class = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/load_exam_for_exam_results',
        dataType: 'json',
        type: 'post',
        data: {class_id:$class},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Exam</option>';
                Array.from(params.exams).map(row => {
                    html = html + '<option value="'+row.examid+'">'+row.exam+'</option>';
                });
                $("#select_exam").html(html).selectpicker('refresh');
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
                $("#select_exam").html(html).selectpicker('refresh');
            }
        }
    });
});

$('#select_year').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_for_exam_results',
        dataType: 'json',
        type: 'post',
        data: {year_id:$yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.classes).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#select_class").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});

$(document).on ('submit','#startEnterResultsForm',function (event) {
    event.preventDefault();

    $examID = $('#select_exam').val();

    if ($examID == null) {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please select an exam.'
        });
        return false;
    }

    $.ajax({
        url: window.location.origin+'/system_operations/set_exam_result_session',
        type: 'post',
        dataType: 'json',
        data: {exam_id: $examID},
        success: function (params) {
            if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: params.err
                });
            } else if (params.success === true) {
                enterResults(params.location_code);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

function enterResults ($id) {
    $location_code = $id;

    var notice = PNotify.notice({
        title: 'Enter student id number',
        text: '<span style="color:red"></span>',
        icon: 'fas fa-question-circle',
        hide: false,
        textTrusted: true,
        stack: {
            'dir1': 'down',
            'firstpos1': 25
        },
        modules: {
          Confirm: {
            prompt: true,
            promptValue: $location_code+'-'
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

    notice.on('pnotify.confirm', function(e) {
        notice.cancelClose();
        $.ajax({
            url: window.location.origin+'/system_operations/validate_student_for_result',
            type: 'post',
            dataType: 'json',
            data: {
                student_id: e.value
            },
            success: function (params) {
                if (params.err) {
                    notice.close();
                    PNotify.error({
                        title: 'Oh No!',
                        text: params.err
                    });
                } else if (params.success === true) {
                    notice.close();
                    var resultNotice = PNotify.notice({
                        title: 'Enter result',
                        text: '<span style="color:red"></span>',
                        icon: 'fas fa-question-circle',
                        hide: false,
                        textTrusted: true,
                        stack: {
                            'dir1': 'down',
                            'firstpos1': 25
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

                    resultNotice.on('pnotify.confirm', function(e) {
                        resultNotice.cancelClose();
                        $.ajax({
                            url: window.location.origin+'/system_operations/enter_results',
                            type: 'post',
                            dataType: 'json',
                            data: {result: e.value},
                            success: function (res) {
                                if (res.err) {
                                    resultNotice.close();
                                    PNotify.error({
                                        title: 'Oh No!',
                                        text: params.err
                                    });
                                    return false;
                                }
                                if (res.stat === false) {
                                    resultNotice.update({
                                        text: '<span style="color:red">'+res.form_error+'</span>'
                                    })
                                } else if (res.stat === true) {
                                    resultNotice.close();
                                    PNotify.success({
                                        title: 'Success',
                                        text: 'Result added.',
                                        delay: 1000
                                    });
                                    
                                    enterResults($location_code);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                                PNotify.error({
                                    title: 'Oh No!',
                                    text: 'Something went wrong.'
                                });
                            }
                        });
                    });
                } else if (params.success === false) {
                    notice.update({
                        text: '<span style="color:red">'+params.form_error+'</span>',
                        modules: {
                            Confirm: {
                                promptValue: e.value
                            }
                        },
                    });
                }
            },
            error: function (error) {
                console.log(error);
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong.'
                });
            }
        });
        
    });
}


function get_year_search() {
    $.ajax({
        url: window.location.origin+'/system_operations/load_year_for_exam_results',
        dataType: 'json',
        type: 'post',
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Year</option>';
                Array.from(params.years).map(row => {
                    html = html + '<option value="'+row.yearid+'">'+row.year+'</option>';
                });
                $("#select_year_search").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
}

$('#select_year_search').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $yearid = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/get_class_for_exam_results',
        dataType: 'json',
        type: 'post',
        data: {year_id:$yearid},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Class</option>';
                Array.from(params.classes).map(row => {
                    html = html + '<option value="'+row.classid+'">'+row.type+' - '+row.location+'</option>';
                });
                $("#select_class_search").html(html).selectpicker('refresh');
            } else if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: response.err
                });
            }
        }
    });
});


// function get_class_for_search() {
//     $.ajax({
//         url: window.location.origin+'/system_operations/get_class_for_exam_results',
//         dataType: 'json',
//         type: 'post',
//         success: function(params) {
//             if(params !== false) {
//                 let html = '<option disabled selected >Select Class</option>';
//                 Array.from(params.classes).map(row => {
//                     html = html + '<option value="'+row.classid+'">'+row.year+' - '+row.type+' - '+row.location+'</option>';
//                 });
//                 $("#select_class_search").html(html).selectpicker('refresh');
//             } else if (params.err) {
//                 PNotify.error({
//                     title: 'Oh No!',
//                     text: response.err
//                 });
//             }
//         }
//     });
// }


$('#select_class_search').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    const $class = $(this).find('option').eq(clickedIndex).val();
    $.ajax({
        url: window.location.origin+'/system_operations/load_exam_for_exam_results',
        dataType: 'json',
        type: 'post',
        data: {class_id:$class},
        success: function(params) {
            if(params !== false) {
                let html = '<option disabled selected >Select Exam</option>';
                Array.from(params.exams).map(row => {
                    html = html + '<option value="'+row.examid+'">'+row.exam+'</option>';
                });
                $("#select_exam_search").html(html).selectpicker('refresh');
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
                $("#select_exam_search").html(html).selectpicker('refresh');
            }
        }
    });
});

$(document).on('click','#search-btn',function () {

    $class_id = $('#select_class_search').val();
    $exam_id = $('#select_exam_search').val();

    if ($class_id == null || $exam_id == null) {
        PNotify.error({
            title: 'Oh No!',
            text: 'Please select Class and Exam.',
            delay: 1500
        });
        return false;
    } else {
        loadMainTable($exam_id);
    }
});


function loadMainTable($exam_id) {
    $('#results_table').DataTable({
        "destroy": true,
        "ajax": {
            "url" : window.location.origin+"/system_operations/get_results_table",
            "data" : {
                exam_id: $exam_id
            },
            "type" : "post"
        },
        "columns": [
            {"data": "no"},
            {"data": "name"},
            {"data": "id"},
            {"data": "paper"},
            {"data": "results"},
            {"data": "action"}
        ]
    });
}

$(document).on('click','.edit',function(){
    $result_id = $(this).attr('data-id');
    $exam_id = $(this).attr('data-exam');

    var resultEdit = PNotify.notice({
        title: 'Enter new result',
        text: '<span style="color:red"></span>',
        icon: 'fas fa-question-circle',
        hide: false,
        textTrusted: true,
        stack: {
            'dir1': 'down',
            'firstpos1': 25
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

    resultEdit.on('pnotify.confirm', function(e) {
        resultEdit.cancelClose();
        $new_result = e.value;

        $.ajax({
            url: window.location.origin+'/system_operations/update_results',
            type: 'post',
            dataType: 'json',
            data: {result_id:$result_id, new_result:$new_result},
            success: function (params) {
                if (params.success === false) {
                    resultEdit.close();
                    PNotify.error({
                        title: 'Oh No!',
                        text: params.err,
                        delay: 1500
                    });
                } else if (params.success === true) {
                    resultEdit.close();
                    PNotify.success({
                        title: 'Success!',
                        text: 'Result updated.',
                        delay: 1500
                    });
                    loadMainTable($exam_id);
                }
            },
            error: function (error) {
                resultEdit.close();
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Something went wrong.',
                    delay: 1500
                });
                console.log(error);
            }
        });
    });
});

$(document).on('click','.remove',function(){
    $result_id = $(this).attr('data-id');
    $exam_id = $(this).attr('data-exam');

    $.ajax({
        url: window.location.origin+'/system_operations/delete_result',
        type: 'post',
        dataType: 'json',
        data: {result_id:$result_id},
        success: function (params) {
            if (params.err) {
                PNotify.error({
                    title: 'Oh No!',
                    text: params.err,
                    delay: 1500
                });
            } else if (params === true) {
                PNotify.success({
                    title: 'Success!',
                    text: 'Result deleted.',
                    delay: 1500
                });
                loadMainTable($exam_id);
            } else if (params === false) {
                PNotify.error({
                    title: 'Oh No!',
                    text: 'Result not deleted.',
                    delay: 1500
                });
            }
        },
        error: function (error) {
            resultEdit.close();
            PNotify.error({
                title: 'Oh No!',
                text: 'Something went wrong.',
                delay: 1500
            });
            console.log(error);
        }
    });
});