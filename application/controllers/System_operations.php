<?php
class System_operations extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Colombo');
    }

    // function for create year
    public function create_year() {
        
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cy');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('year', 'Year', 'required|greater_than[1990]|less_than[2100]|is_unique[years.year]',array(
            'is_unique'     => 'This %s already exists.'
        ));
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_error'=>array('year'=>form_error('year')))));
        } else {
            $this->load->model('system_model');
            $stat = $this->system_model->insert_year($_POST['year']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Year is not created.'));
            }
        }
    }

    // get data for year page table
    public function get_years_table() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vcy');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $years = $this->db->get('years');
        $data['data'] = array();
        if($years->num_rows() > 0) {
            foreach ($years->result_array() as $key => $value) {
                $data['data'][] =array(
                    'no'=>$key,
                    'year'=>$value['year'],
                    'actions'=>'<a data-value="'.$value['year'].'" data-id="'.$value['idyears'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                <a data-id="'.$value['idyears'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }

    // function for delete year
    public function delete_year() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duy');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        if ($this->system_model->delete_year($_POST['id'])) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Year not deleted.'));
        }
    }

    // function for edit year
    public function update_year() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duy');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('year', 'Year', 'required|greater_than[1990]|less_than[2100]');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('err'=>form_error('year'))));
        } else {
            $this->load->model('system_model');
            $stat = $this->system_model->update_year($_POST['year'],$_POST['id']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Year is not updated.'));
            }
        }
    }

    // function for get class locations
    public function get_class_locations() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmsu');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        $this->load->model('system_model');
        $class_locations = $this->system_model->get_class_locations();
        if ($class_locations->num_rows() > 0) {
            foreach ($class_locations->result_array() as $key => $value) {
                $locations['locdata'][] = array(
                    'locid' => $value['idclass_locations'],
                    'locname' => $value['locations'].' - '.$value['locations_code']
                );
            }
            echo json_encode($locations);
        } else {
            echo json_encode(false);
        }
    }

    // function for get data for class types view table
    public function get_class_types_table(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vcct');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $classTypes = $this->db->get('class_types');
        $data['data'] = array();
        if($classTypes->num_rows() > 0) {
            foreach ($classTypes->result_array() as $key => $value) {
                $data['data'][] =array(
                    'no'=>$key,
                    'classType'=>$value['types'],
                    'classTypeCode'=>$value['class_type_code'],
                    'studentCharge'=>number_format($value['student_charges'],2),
                    'action'=>' <a data-id="'.$value['idclass_types'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['idclass_types'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }

    // function for create class type
    public function create_class_type() {
        
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cct');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('classType', 'Class Type', 'required|is_unique[class_types.types]',array(
                'is_unique'     => 'This %s already exists.'
        ));
        $this->form_validation->set_rules('classTypeCode', 'Class Type Code', 'required|is_unique[class_types.class_type_code]',array(
            'is_unique'     => 'This %s already exists.'
        ));
        $this->form_validation->set_rules('studentCharge', 'Student Charge', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_error'=>array(
                'classType'=>form_error('classType'),
                'classTypeCode'=>form_error('classTypeCode'),
                'studentCharge'=>form_error('studentCharge')
            ))));
        } else {
            $data = array(
                'types'=>$_POST['classType'],
                'class_type_code'=>strtoupper($_POST['classTypeCode']),
                'student_charges'=>$_POST['studentCharge']
            );
            $this->load->model('system_model');
            $stat = $this->system_model->insert_class_type($data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class Type is not created!'));
            }
        }
    }

    // function for get class type data to class types update fields
    public function get_class_type_for_update() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duct');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $classTypeId = $_POST['id'];
        $this->load->model('system_model');
        $class_type = $this->system_model->get_class_type($classTypeId);
        if ($class_type->num_rows() > 0) {
            $value = $class_type->row();
            $data = array(
                'classType' => $value->types,
                'classTypeCode' => $value->class_type_code,
                'studentCharges' => number_format($value->student_charges,2)
            );
            echo json_encode(array('success' => true, 'classType' => $data));
        } else {
            echo json_encode(array('err'=>'Class type not found!'));
        }
    }


    //function for update class types
    public function update_class_type() {
        $classTypeId = $_POST['id'];

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duct');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('classType', 'Class Type', 'required');
        $this->form_validation->set_rules('classTypeCode', 'Class Type Code', 'required');
        $this->form_validation->set_rules('studentCharge', 'Student Charge', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            echo ( json_encode( array ('form_error' => array (
                'classType'=>form_error('classType'),
                'classTypeCode'=>form_error('classTypeCode'),
                'studentCharge'=>form_error('studentCharge')
            ))));
        } else {
            $data = array(
                'types'=>$_POST['classType'],
                'class_type_code'=>strtoupper($_POST['classTypeCode']),
                'student_charges'=>$_POST['studentCharge']
            );
            $this->load->model('system_model');
            $stat = $this->system_model->update_class_type($data,$classTypeId);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class Type is not created!'));
            }
        }

    }


    //function for delete class type
    public function delete_class_type(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duct');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $class_type_id = $_POST['class_type_id'];
        $this->load->model('system_model');
        $stat = $this->system_model->delete_class_type($class_type_id);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Class type not deleted due to server error!'));
        }
    }

    //function for view exams view table data
    public function get_exams_table() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vce');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exam_data = $this->system_model->get_exams();

        $data['data'] = array();

        if ($exam_data->num_rows() > 0) {
            foreach ($exam_data->result_array() as $key => $value) {
                $data['data'][] = array(
                    'class'=>$value['year'].' - '.$value['locations'].' ('.$value['locations_code'].')'.$value['types'].' ('.$value['class_type_code'].')',
                    'paper'=>$value['paper_type'].' ('.$value['paper_code'].')',
                    'examType'=>$value['exams'].' ('.$value['exam_type_code'].')',
                    'date'=>$value['date'],
                    'time'=>date('h:i A',strtotime($value['time'])),
                    'notes'=>$value['note'],
                    'actions'=>'    <a data-id="'.$value['idexams'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                    <a data-id="'.$value['idexams'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }


    // function for get class for create exam dropdown
    public function get_class_for_exam_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vce');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // get classes for student payment reports
    public function get_class_for_student_payments() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get paper for create exam dropdown
    public function get_paper_for_exam_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vce');
        $res1 = $this->user_model->validate_user_access('verr');
        if ($res === false && $res1 === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $paper = $this->system_model->get_papers();

        if ($paper->num_rows() > 0) {
            foreach ($paper->result_array() as $key => $value) {
                $data['papers'][] = array(
                    'paperid'=>$value['idmodel_papers'],
                    'paperType'=>$value['paper_type'],
                    'paperCode'=>$value['paper_code']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }


    // function for get exam type for create exam dropdown
    public function get_exam_type_for_exam_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vce');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exam_type = $this->system_model->get_exam_types();

        if ($exam_type->num_rows() > 0) {
            foreach ($exam_type->result_array() as $key => $value) {
                $data['examType'][] = array(
                    'examTypeid'=>$value['idexam_types'],
                    'type'=>$value['exams'],
                    'typeCode'=>$value['exam_type_code']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for create exam
    public function create_exam() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ce');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'date'=>form_error('date'),
                'time'=>form_error('time')
            ))));
        } else {
            $exam_data = array(
                'class_idclass' => $_POST['class'],
                'model_papers_idmodel_papers' => $_POST['paper'],
                'exam_types_idexam_types' => $_POST['examType'],
                'date' => $_POST['date'],
                'time' => date('H:i:s', strtotime($_POST['time'])),
                'note' => $_POST['note']
            );
            $this->load->model('system_model');
            $stat = $this->system_model->create_exam($exam_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Exam not created due to server error!'));
            }
        }

    }

    //function for get exam data to update exam
    public function get_exam() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('due');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exam = $this->system_model->get_exam($_POST['exam_id']);

        if ($exam->num_rows() > 0) {
            $value = $exam->row();
            $data['success'] = true;
            $data['exam'] = array(
                'date'=>$value->date,
                'time'=>date('h:i A',strtotime($value->time)),
                'note'=>$value->note,
                'class'=>$value->class_idclass,
                'paper'=>$value->model_papers_idmodel_papers,
                'examType'=>$value->exam_types_idexam_types,
            );
            echo json_encode($data);
        } else {
            echo json_encode(array('err'=>'Not found such exam in system.'));
        }
        
    }



    // function for update exam
    public function update_exam() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('due');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        
        $this->load->model('system_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'date'=>form_error('date'),
                'time'=>form_error('time')
            ))));
        } else {
            $exam_data = array(
                'class_idclass' => $_POST['class'],
                'model_papers_idmodel_papers' => $_POST['paper'],
                'exam_types_idexam_types' => $_POST['examType'],
                'date' => $_POST['date'],
                'time' => date('H:i:s', strtotime($_POST['time'])),
                'note' => $_POST['note']
            );
            $stat = $this->system_model->update_exam($exam_data,$_POST['id']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Exam not updated due to server error!'));
            }
        }

    }


    //function for delete user
    public function delete_exam(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('due');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $examid = $_POST['examid'];
        $stat = $this->system_model->delete_exam($examid);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Exam not deleted due to server error!'));
        }
    }


    // function for get data for model papers view table
    public function get_model_paper_table(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vcmp');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $modelPapers = $this->system_model->get_model_papers();
        $data['data'] = array();
        if($modelPapers->num_rows() > 0) {
            foreach ($modelPapers->result_array() as $key => $value) {
                $data['data'][] =array(
                    'no'=>$key,
                    'paperType'=>$value['paper_type'],
                    'paperTypeCode'=>$value['paper_code'],
                    'action'=>' <a data-id="'.$value['idmodel_papers'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['idmodel_papers'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }


    // function for create model paper
    public function create_model_paper() {
        
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cmp');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('paperType', 'Paper', 'required|is_unique[model_papers.paper_type]',array(
            'is_unique'     => 'This %s already exists.'
        ));
        $this->form_validation->set_rules('paperTypeCode', 'Paper Code', 'required|is_unique[model_papers.paper_code]',array(
            'is_unique'     => 'This %s already exists.'
        ));
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_error'=>array(
                'paperType'=>form_error('paperType'),
                'paperTypeCode'=>form_error('paperTypeCode')
            ))));
        } else {
            $data = array(
                'paper_type'=>$_POST['paperType'],
                'paper_code'=>strtoupper($_POST['paperTypeCode'])
            );
            $this->load->model('system_model');
            $stat = $this->system_model->insert_model_paper($data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Model paper is not created!'));
            }
        }
    }

    // function for model paper data to model paper update fields
    public function get_model_paper_for_update() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dump');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $modelPaperID = $_POST['id'];
        $this->load->model('system_model');
        $modelPapers = $this->system_model->get_model_papers($modelPaperID);
        if ($modelPapers->num_rows() > 0) {
            $value = $modelPapers->row();
            $data = array(
                'paperType' => $value->paper_type,
                'paperTypeCode' => $value->paper_code
            );
            echo json_encode(array('success' => true, 'modelPapers' => $data));
        } else {
            echo json_encode(array('err'=>'Model paper not found!'));
        }
    }


    //function for update model paper
    public function update_model_paper() {
        $modelPaperID = $_POST['id'];

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dump');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('paperType', 'Paper', 'required');
        $this->form_validation->set_rules('paperTypeCode', 'Paper code', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo ( json_encode( array ('form_error' => array (
                'paperType'=>form_error('paperType'),
                'paperTypeCode'=>form_error('paperTypeCode')
            ))));
        } else {
            $data = array(
                'paper_type'=>$_POST['paperType'],
                'paper_code'=>strtoupper($_POST['paperTypeCode'])
            );
            $this->load->model('system_model');
            $stat = $this->system_model->update_model_paper($data,$modelPaperID);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Model paper is not updated!'));
            }
        }

    }


    //function for delete model paper
    public function delete_model_paper(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dump');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $model_paper_id = $_POST['model_paper_id'];
        $this->load->model('system_model');
        $stat = $this->system_model->delete_model_paper($model_paper_id);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Model paper is not deleted due to server error!'));
        }
    }


    // function for get student types for student create
    public function load_student_types_for_student_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $student_type = $this->system_model->get_student_type();

        if ($student_type->num_rows() > 0) {
            foreach ($student_type->result_array() as $key => $value) {
                $data['studentType'][] = array(
                    'studentTypeId'=>$value['idstudent_types'],
                    'type'=>$value['stypes']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get class for student create dropdown
    public function load_class_for_student_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $year_id = $_POST['year_id'];
        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($year_id);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get class for id generate dropdown
    public function load_class_for_id_print() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpisi');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes();

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get year for student create dropdown
    public function load_year_for_student_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        $res1 = $this->user_model->validate_user_access('verr');
        if ($res === false && $res1 === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function load_year_for_student_id() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpisi');
        
        if ($res === false && $res1 === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function load_year_for_student_send_sms() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function load_year_for_create_exams() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vce');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function load_year_for_exam_results () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ver');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get year for student create dropdown
    public function load_year_for_student_payments_report() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get year for student stt report
    public function load_year_for_student_attendances_report() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('var');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get year for student stt report
    public function load_year_for_student_details_report() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsdr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get year for student create dropdown
    public function load_payment_types_for_student_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $payment = $this->system_model->get_payment_types();

        if ($payment->num_rows() > 0) {
            foreach ($payment->result_array() as $key => $value) {
                $data['payment'][] = array(
                    'paymentid'=>$value['idclass_payment_types'],
                    'payment'=>$value['payment_types']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }



    // function for create student
    public function create_student() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cs');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('school', 'School', '');
        $this->form_validation->set_rules('address', 'Address', '');
        $this->form_validation->set_rules('nic', 'NIC Number', '');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'firstName'=>form_error('firstName'),
                'lastName'=>form_error('lastName'),
                'contactNumber'=>form_error('contactNumber'),
                'school'=>form_error('school'),
                'address'=>form_error('address'),
                'nic'=>form_error('nic')
            ))));
        } else {
            $student_data = array(
                'first_name' => $_POST['firstName'],
                'last_name' => $_POST['lastName'],
                'address' => $_POST['address'],
                'contact_no' => $_POST['contactNumber'],
                'school' => $_POST['school'],
                'notes' => $_POST['note'],
                'student_types_idstudent_types' => $_POST['studentType'],
                'class_idclass' => $_POST['class'],
                'is_card_issue' => 0,
                'class_payment_types_idclass_payment_types' => $_POST['paymentType'],
                'nic' => $_POST['nic'],
                'student_id'=> $_POST['manualid']
            );

            $config['upload_path'] = './assets/profile_pictures';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $config['max_width'] = '600';
            $config['max_height'] = '600';
 
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profileImage')) {
                $data = $this->upload->data();
                $student_data['student_image'] = 'assets/profile_pictures/'.$data['file_name'];
            } else {
                $student_data['student_image'] = 'assets/profile_pictures/default_profile.png';
            }

            $this->load->model('system_model');
            $stat = $this->system_model->create_student($student_data);
            if($stat['success']) {
                echo json_encode(array('success'=>true, 'stid'=>$stat['stid'], 'err'=>$this->upload->display_errors('', '')));
            } else {
                echo json_encode(array('err'=>$stat['err']));
            }
        }
    }


    // function for update student
    public function update_student() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dus');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('school', 'School', '');
        $this->form_validation->set_rules('address', 'Address', '');
        $this->form_validation->set_rules('nic', 'NIC Number', '');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'firstName'=>form_error('firstName'),
                'lastName'=>form_error('lastName'),
                'contactNumber'=>form_error('contactNumber'),
                'school'=>form_error('school'),
                'address'=>form_error('address'),
                'nic'=>form_error('nic')
            ))));
        } else {
            $student_data = array(
                'first_name' => $_POST['firstName'],
                'last_name' => $_POST['lastName'],
                'address' => $_POST['address'],
                'contact_no' => $_POST['contactNumber'],
                'school' => $_POST['school'],
                'notes' => $_POST['note'],
                'student_types_idstudent_types' => $_POST['studentType'],
                'is_card_issue' => 0,
                'class_payment_types_idclass_payment_types' => $_POST['paymentType'],
                'nic' => $_POST['nic']
            );

            $config['upload_path'] = './assets/profile_pictures';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $config['max_width'] = '500';
            $config['max_height'] = '500';
 
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profileImage')) {
                $data = $this->upload->data();
                $student_data['student_image'] = 'assets/profile_pictures/'.$data['file_name'];
            }

            $this->load->model('system_model');
            $stat = $this->system_model->update_student($student_data,$_POST['id']);
            if($stat) {
                echo json_encode(array('success'=>true, 'stid'=>$stat['stid'], 'err'=>$this->upload->display_errors('', '')));
            } else {
                echo json_encode(array('err'=>'Student is not updated due to server error!'));
            }
        }
    }


    //function for view student view table data
    public function get_student_table() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        function idstatus($val){
            if ($val['is_card_issue'] == 1) {
                return 'Issued';
            } else {
                return 'Not Issued';
            }
        };
        $students_data = null;
        $this->load->model('system_model');
        if ($_POST['method'] == 'byContact') {
            $students_data = $this->system_model->get_student_by_contact($_POST['value']);
        } elseif ($_POST['method'] == 'byId') {
            $students_data = $this->system_model->get_student_by_id($_POST['value']);
        } elseif ($_POST['method'] == 'lastSt') {
            $student = $this->db->select('*')->order_by('idstudent',"desc")->limit(1)->get('student');
            if ($student->num_rows() > 0) {
                $students_data = $this->system_model->get_student_by_id($student->row()->student_id);
            }
        } elseif ($_POST['method'] == 'byname') {
            $students_data = $this->system_model->get_student_by_name($_POST['value']);
        }
        

        $data['data'] = array();

        if ($students_data->num_rows() > 0) {
            foreach ($students_data->result_array() as $key => $value) {
                $data['data'][] = array(
                    'name'=>$value['first_name'].' '.$value['last_name'],
                    'contact'=>$value['contact_no'],
                    'address'=>$value['address'],
                    'nic'=>$value['nic'],
                    'school'=>$value['school'],
                    'type'=>$value['stypes'],
                    'class'=>$value['year'].' - '.$value['locations'].' ('.$value['locations_code'].')'.$value['types'].' ('.$value['class_type_code'].')',
                    'year'=>$value['year'],
                    'paymentType'=>$value['payment_types'],
                    'note'=>$value['notes'],
                    'id_issue'=>idstatus($value),
                    'id_number'=>$value['student_id'],
                    'actions'=>'    <a data-id="'.$value['idstudent'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                    <a data-id="'.$value['idstudent'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                    <a data-id="'.$value['idstudent'].'" class="btn pull-right btn-link btn-success btn-just-icon viewstudent"><i class="material-icons">credit_card</i></a>'
                );
            }
        }
        echo json_encode($data);
    }

    // finction for view student in student management
    public function view_student_st_management() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        function checkfield ($stringdata) {
            if ($stringdata == "" || $stringdata == null) {
                return "No Data";
            } else {
                return $stringdata;
            }
        }
        
        $student_id = $_POST['student_id'];
        $this->load->model('system_model');
        $studentobj = $this->system_model->get_student($student_id);
        
        if ($studentobj->num_rows() > 0) {
            $student = $studentobj->row();
            if ($student->student_image == "" || $student->student_image == null) {
                $data['student'][]['stprof'] = 'No Data'; 
            } else {
                $data['student'][]['stprof'] = '<img src="'.$student->student_image.'" alt="profile picture" style="width: 120px; height: 120px">'; 
            }
            $data['student'][]['stname'] = checkfield($student->first_name).' '.checkfield($student->last_name);
            $data['student'][]['stcid'] = checkfield($student->student_id);
            $data['student'][]['stnic'] = checkfield($student->nic);
            $data['student'][]['staddress'] = checkfield($student->address);
            $data['student'][]['stcontact'] = checkfield($student->contact_no);
            $data['student'][]['stcloc'] = checkfield($student->locations);
            $data['student'][]['stctype'] = checkfield($student->types);
            $data['student'][]['stptype'] = checkfield($student->payment_types);
            if ($student->is_card_issue == 0) {
                $data['student'][]['stidissue'] = "No";
            } else {
                $data['student'][]['stidissue'] = "Yes";
            }
        } else {
            $data['student'][]['stprof'] = 'No Data'; 
            $data['student'][]['stname'] = 'No Data'; 
            $data['student'][]['stcid'] = 'No Data'; 
            $data['student'][]['stnic'] = 'No Data'; 
            $data['student'][]['staddress'] = 'No Data'; 
            $data['student'][]['stcontact'] = 'No Data'; 
            $data['student'][]['stcloc'] = 'No Data'; 
            $data['student'][]['stctype'] = 'No Data'; 
            $data['student'][]['stptype'] = 'No Data'; 
            $data['student'][]['stidissue'] = 'No Data'; 
        }
        echo json_encode($data);
    }



    //function for get student data to update student
    public function get_student() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dus');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exam = $this->system_model->get_student($_POST['student_id']);

        if ($exam->num_rows() > 0) {
            $value = $exam->row();
            $data['success'] = true;
            $data['student'] = array(
                'firstName'=>$value->first_name,
                'lastName'=>$value->last_name,
                'address'=>$value->address,
                'school'=>$value->school,
                'contactNumber'=>$value->contact_no,
                'studentType'=>$value->student_types_idstudent_types,
                'class'=>$value->class_idclass,
                'paymentType'=>$value->class_payment_types_idclass_payment_types,
                'note'=>$value->notes,
                'nic'=>$value->nic,
                'profileImage'=>base_url().$value->student_image
            );
            echo json_encode($data);
        } else {
            echo json_encode(array('err'=>'Not found such exam in system.'));
        }
    }


    //function for delete student
    public function delete_student(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dus');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $stid = $_POST['student_id'];
        $stat = $this->system_model->delete_student($stid);
        if($stat['success'] == true) {
            
            if ($stat['img_path'] != null && $stat['img_path'] != '' && $stat['img_path'] != 'assets/profile_pictures/default_profile.png') {
                unlink('./'.$stat['img_path']);
            }
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Student id not deleted due to server error!'));
        }
    }



    // function for get data for classes view table
    public function get_class_table(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmc');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $classes = $this->system_model->get_classes();
        $data['data'] = array();
        if($classes->num_rows() > 0) {
            foreach ($classes->result_array() as $key => $value) {
                $data['data'][] =array(
                    'no'=>$key,
                    'year'=>$value['year'],
                    'classLocation'=>$value['locations'].' ('.$value['locations_code'].') ',
                    'classType'=>$value['types'].' ('.$value['class_type_code'].') - LKR.'.number_format($value['student_charges'],2),
                    'note'=>$value['note'],
                    'fromTo'=>$value['from_id'].' - '.$value['to_id'],
                    'action'=>' <a data-id="'.$value['idclass'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['idclass'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }



    // function for get year for class create dropdown
    public function load_year_for_class_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmc');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_year();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['years'][] = array(
                    'yearid'=>$value['idyears'],
                    'year'=>$value['year']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get location for class create dropdown
    public function load_class_location_for_class_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmc');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_class_locations();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['locations'][] = array(
                    'locationid'=>$value['idclass_locations'],
                    'location'=>$value['locations'],
                    'locationCode'=>$value['locations_code'],
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get class type for class create dropdown
    public function load_class_type_for_class_create() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vmc');
        $res1 = $this->user_model->validate_user_access('verr');
        if ($res === false && $res1 === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year = $this->system_model->get_class_type();

        if ($year->num_rows() > 0) {
            foreach ($year->result_array() as $key => $value) {
                $data['types'][] = array(
                    'typeid'=>$value['idclass_types'],
                    'type'=>$value['types'],
                    'typeCode'=>$value['class_type_code'],
                    'studentCharge'=>'LKR.'.number_format($value['student_charges'],2)
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for create class
    public function create_class() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cc');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('fromNumber', 'From Number', 'required|integer');
        $this->form_validation->set_rules('toNumber', 'To Number', 'required|integer');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'fromNumber'=>form_error('fromNumber'),
                'toNumber'=>form_error('toNumber')
            ))));
        } else {
            $class_data = array(
                'years_idyears' => $_POST['year'],
                'class_locations_idclass_locations' => $_POST['classLocation'],
                'class_types_idclass_types' => $_POST['classType'],
                'note' => $_POST['note'],
                'user_iduser' => $_SESSION['user_data']['id'],
                'from_id' => $_POST['fromNumber'],
                'to_id' => $_POST['toNumber']
            );
            $this->load->model('system_model');
            $stat = $this->system_model->create_class($class_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class is not created due to server error!'));
            }
        }
    }


    // function for update class
    public function update_class() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('duc');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('fromNumber', 'From Number', 'required|integer');
        $this->form_validation->set_rules('toNumber', 'To Number', 'required|integer');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'fromNumber'=>form_error('fromNumber'),
                'toNumber'=>form_error('toNumber')
            ))));
        } else {
            $class_data = array(
                'years_idyears' => $_POST['year'],
                'class_locations_idclass_locations' => $_POST['classLocation'],
                'class_types_idclass_types' => $_POST['classType'],
                'note' => $_POST['note'],
                'user_iduser' => $_SESSION['user_data']['id'],
                'from_id' => $_POST['fromNumber'],
                'to_id' => $_POST['toNumber']
            );
            $this->load->model('system_model');
            $stat = $this->system_model->update_class($class_data,$_POST['id']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class is not created due to server error!'));
            }
        }
    }


    //function for delete class
    public function delete_class(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dus');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class_id = $_POST['class_id'];
        $stat = $this->system_model->delete_class($class_id);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Class id not deleted due to server error!'));
        }
    }



    //function for get class data to update class
    public function get_class() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('dus');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_class($_POST['class_id']);

        if ($class->num_rows() > 0) {
            $value = $class->row();
            $data['success'] = true;
            $data['class'] = array(
                'year'=>$value->years_idyears,
                'classLocation'=>$value->class_locations_idclass_locations,
                'classType'=>$value->class_types_idclass_types,
                'note'=>$value->note,
                'fromNumber'=> $value->from_id,
                'toNumber'=> $value->to_id
            );
            echo json_encode($data);
        } else {
            echo json_encode(array('err'=>'Not found such class in system.'));
        }
    }


    // function for get data for class location view table
    public function get_class_location_table(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vccl');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $classLoc = $this->system_model->get_class_locations();
        $data['data'] = array();
        if($classLoc->num_rows() > 0) {
            foreach ($classLoc->result_array() as $key => $value) {
                $data['data'][] =array(
                    'no'=>$key,
                    'location'=>$value['locations'],
                    'locationCode'=>$value['locations_code'],
                    'action'=>' <a data-id="'.$value['idclass_locations'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['idclass_locations'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode($data);
    }



    // function for create class location
    public function create_class_location() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ccl');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('location', 'Location', 'required|is_unique[class_locations.locations]', array(
            'is_unique' => 'This %s already exists.'
        ));
        $this->form_validation->set_rules('locationCode', 'Location Code', 'required|is_unique[class_locations.locations_code]', array(
            'is_unique' => 'This %s already exists.'
        ));
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'location'=>form_error('location'),
                'locationCode'=>form_error('locationCode')
            ))));
        } else {
            $location_data = array(
                'locations' => $_POST['location'],
                'locations_code' => strtoupper($_POST['locationCode'])
            );
            $this->load->model('system_model');
            $stat = $this->system_model->create_class_location($location_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class location is not created due to server error!'));
            }
        }
    }


    // function for update class location
    public function update_class_location() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ducl');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('locationCode', 'Location Code', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'location'=>form_error('location'),
                'locationCode'=>form_error('locationCode')
            ))));
        } else {
            $location_data = array(
                'locations' => $_POST['location'],
                'locations_code' => strtoupper($_POST['locationCode'])
            );
            $this->load->model('system_model');
            $stat = $this->system_model->update_class_location($location_data,$_POST['id']);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Class location is not updated due to server error!'));
            }
        }
    }


    //function for get class location data to update class
    public function get_class_location() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ducl');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class_location = $this->system_model->get_class_location($_POST['location_id']);

        if ($class_location->num_rows() > 0) {
            $value = $class_location->row();
            $data['success'] = true;
            $data['class_location'] = array(
                'location'=>$value->locations,
                'locationCode'=>$value->locations_code
            );
            echo json_encode($data);
        } else {
            echo json_encode(array('err'=>'Not found such class location in system.'));
        }
    }


    //function for delete class location
    public function delete_class_location(){

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ducl');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $location_id = $_POST['location_id'];
        $stat = $this->system_model->delete_class_location($location_id);
        if($stat) {
            echo json_encode(true);
        } else {
            echo json_encode(array('err'=>'Class id not deleted due to server error!'));
        }
    }


    // function for get class for exam results dropdown
    public function get_class_for_exam_results() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('ver');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $year_id = $_POST['year_id'];
        $classes = $this->system_model->get_classes_filter_by_year($year_id);
        $user_type = $this->user_model->get_user_data($_SESSION['user_data']['id'])->row()->l_types;
        $user_location = $this->user_model->get_user_data($_SESSION['user_data']['id'])->row()->class_locations_idclass_locations;

        if ($classes->num_rows() > 0) {
            foreach ($classes->result_array() as $key => $value) {
                if ($user_type == 'user' && $user_location == $value['class_locations_idclass_locations']) {
                    $data['classes'][] = array(
                        'classid'=>$value['idclass'],
                        'year'=>$value['year'],
                        'type'=>$value['types'].' - '.$value['class_type_code'],
                        'location'=>$value['locations'].' - '.$value['locations_code'],
                    );
                } elseif ($user_type == 'admin') {
                    $data['classes'][] = array(
                        'classid'=>$value['idclass'],
                        'year'=>$value['year'],
                        'type'=>$value['types'].' - '.$value['class_type_code'],
                        'location'=>$value['locations'].' - '.$value['locations_code'],
                    );
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get exam for exam results dropdown
    public function load_exam_for_exam_results() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('cer');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exams = $this->system_model->get_exam_by_class($_POST['class_id']);

        if ($exams->num_rows() > 0) {
            foreach ($exams->result_array() as $key => $value) {
                $data['exams'][] = array(
                    'examid'=>$value['idexams'],
                    'exam'=>$value['exam_type_code'].' - '.$value['paper_code'].' - '.$value['date'].' '.$value['time']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }

    // function for set session for create exam results
    public function set_exam_result_session () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cer');
        if ($res === false) {
            exit (json_encode (array ('err'=>'You have no permission to perform this action')));
        }

        if (isset($_SESSION['res'])) {
            unset($_SESSION['res']);
        }

        $exam_id = $_POST['exam_id'];
        $user_id = $_SESSION['user_data']['id'];

        // load system model
        $this->load->model('system_model');
        // validate if user has access to the location and check already enterd result
        $user_type = $this->user_model->get_user_data($user_id)->row()->l_types;
        $user_location = $this->user_model->get_user_data($user_id)->row()->class_locations_idclass_locations;
        $exam_location = $this->system_model->get_exam($exam_id)->row()->idclass_locations;
        $location_code = $this->system_model->get_exam($exam_id)->row()->locations_code;
        $class_type = $this->system_model->get_exam($exam_id)->row()->class_type_code;
        $year = $this->system_model->get_exam($exam_id)->row()->year;
        
            if ($user_type == 'admin') {
                $stat =  true;
            } elseif ($user_type == 'user' && $user_location == $exam_location) {
                $stat = true;
            } elseif ($user_type == 'user' && $user_location != $exam_location) {
                $stat = false;
            }
        

        if ($stat == true) {
            
            $resdt = $this->system_model->check_date_for_result_enter($exam_id);
            if ($resdt == true) {
                $_SESSION['res']['exam_id'] = $exam_id;
                $_SESSION['res']['location_code'] = $location_code;
                $_SESSION['res']['user_type'] = $user_type;
                echo json_encode ( array ('location_code' => $location_code.'-'.$class_type.'-'.$year, 'success' => true));
            } else {
                exit (json_encode (array ('err'=>'You cant enter results to future exams.')));
            }
        } else {
            exit (json_encode (array ('err'=>'You cant enter results to other than your location.')));
        }
    }

    // check if student id is correct and results entered
    public function validate_student_for_result () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cer');
        if ($res === false) {
            exit (json_encode (array ('err'=>'You have no permission to perform this action')));
        }

        $student_id = $_POST['student_id'];
        if (!isset($_SESSION['res'])) {
            exit (json_encode (array ('err'=>'Cannot find valid session. Please start over again.')));
        }

        $this->load->model('system_model');
        $student = $this->system_model->search_student_by_id($student_id);
        
        if ($student->num_rows () > 0) {

            $result = $this->system_model->get_result_data($student_id,$_SESSION['res']['exam_id']);
            if ($result->num_rows() > 0) {
                exit(json_encode(array('success' => false, 'form_error'=>'Results already entered for this student.')));
            } else {
                $_SESSION['res']['temp_userid'] = null;
                $_SESSION['res']['temp_userid'] = $student->row()->idstudent;
                echo json_encode( array ('success'=> true));
            }
        } else {
            echo json_encode( array('success' => false, 'form_error'=>'Student id is wrong.'));
        }
    }


    // function for enter results
    public function enter_results () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cer');
        if ($res === false) {
            exit (json_encode (array ('err'=>'You have no permission to perform this action')));
        }

        $result = $_POST['result'];
        if (!isset($_SESSION['res'])) {
            exit (json_encode (array ('err'=>'Cannot find valid session. Please start over again.')));
        }

        $this->load->model('system_model');
        $student = $this->system_model->get_student($_SESSION['res']['temp_userid']);
        
        if ($student->num_rows () > 0) {

            $result_data = $this->system_model->get_result_data_enter_res($_SESSION['res']['temp_userid'],$_SESSION['res']['exam_id']);
            if ($result_data->num_rows() > 0) {
                exit(json_encode(array('stat' => false, 'form_error'=>'Results already entered for this student.')));
            } else {
                $response = $this->system_model->enter_result($result,$_SESSION['res']['temp_userid'],$_SESSION['res']['exam_id']);
                if ($response == true) {
                    unset($_SESSION['res']['temp_userid']);
                    echo json_encode( array ('stat'=> true));
                } else {
                    echo json_encode( array ('err'=>'Result not entered.'));
                }
            }
        } else {
            echo json_encode( array('stat' => false, 'form_error'=>'Student id is wrong.'));
        }
    }


    // function for view exam results for exam_results table
    public function get_results_table () {

        date_default_timezone_set('Asia/Colombo');
        $this->load->model('system_model');
        $exam = $this->system_model->get_result_data_by_id($_POST['exam_id']);
        $data['data'] = array();

        if ($exam->num_rows() > 0) {
            
            foreach ($exam->result_array() as $key => $value) {
                
                $num = $value['idstudent'];
                $str_length = 5;
                $str = substr("00000{$num}", -$str_length);

                $data['data'][] = array(
                    'no' => $key,
                    'name' => $value['first_name'].' '.$value['last_name'],
                    'id' => $value['student_id'],
                    'paper' => $value['paper_type'].' - '.$value['paper_code'],
                    'results' => $value['marks'],
                    'action' => '
                                <a data-id="'.$value['idexam_results'].'" data-exam="'.$value['idexams'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                <a data-id="'.$value['idexam_results'].'" data-exam="'.$value['idexams'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>'
                );
            }
        }
        echo json_encode ($data);
    }


    // update result
    public function update_results () {
        $result = $_POST['new_result'];
        $id = $_POST['result_id'];

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('uder');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        if (!is_numeric($result)) {
            exit (json_encode (array ('success'=>false,'err'=>'Result should be a number.')));
        }
        if ($this->system_model->update_result($result,$id)) {
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('success'=>false,'err'=>'Result not updated.'));
        }
    }


    // delete result
    public function delete_result () {
        $id = $_POST['result_id'];

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('uder');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        
        if ($this->system_model->delete_result($id)) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // function for enter default class fee payments
    public function enter_default_payment() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cp');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        date_default_timezone_set('Asia/Colombo');
        $time = time();

        $current_month = date('m', $time);
        $current_year = date('Y', $time);

        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        $student_row = $this->system_model->get_student_by_id($_POST['student_id']);
        if ($student_row->num_rows() <= 0) {
            exit(json_encode(array('success'=>false, 'err'=>'No student belongs to the ID.')));
        }
        $student_data = $student_row->row();
        $last_payment = $this->system_model->get_last_payment_by_key($student_data->idstudent);


        if ($last_payment->num_rows() > 0) {
            $last_payment_data = $last_payment->last_row();

            $last_payment_date_string = $last_payment_data->date.' '.$last_payment_data->time;
 
            $matchPayment = $this->db->select('*')->from('class_payment')->where('student_idstudent',$student_data->idstudent)->where('year',$current_year)->where('month',$current_month)->get();
            if (isset($matchPayment) && $matchPayment->num_rows() > 0) {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'fail',
                    'stText'=>'ALREADY PAID FOR CURRENT MONTH',
                    'currentAmount'=>'LKR 0.00 ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                    'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                    'stKey'=>$student_data->idstudent
                );
                echo json_encode($return_data);
            } else {
                $insert_data = array (
                    'student_idstudent'=>$student_data->idstudent,
                    'student_number'=>$student_data->student_id,
                    'month'=>$current_month,
                    'year'=>$current_year,
                    'date'=>$current_date,
                    'time'=>$current_time,
                    'amount'=>$student_data->condition * $student_data->student_charges
                );
                $response = $this->system_model->enter_default_payment($insert_data);

                if ($response === false) {
                    $return_data = array (
                        'success'=>true,
                        'profileImage'=>$student_data->student_image,
                        'stClass'=>'fail',
                        'stText'=>'PAYMENT UNSUCCESSFUL',
                        'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                        'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                        'studentId'=>$student_data->student_id,
                        'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                        'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                        'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                        'stKey'=>$student_data->idstudent
                    );
                    exit(json_encode($return_data));
                } else {
                    $return_data = array (
                        'success'=>true,
                        'profileImage'=>$student_data->student_image,
                        'stClass'=>'success',
                        'stText'=>'PAYMENT SUCCESSFUL',
                        'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                        'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                        'studentId'=>$student_data->student_id,
                        'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                        'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                        'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                        'stKey'=>$student_data->idstudent
                    );
                    echo json_encode($return_data);
                }
            }
        } else {
            $insert_data = array (
                'student_idstudent'=>$student_data->idstudent,
                'student_number'=>$student_data->student_id,
                'month'=>$current_month,
                'year'=>$current_year,
                'date'=>$current_date,
                'time'=>$current_time,
                'amount'=>$student_data->condition * $student_data->student_charges
            );
            $response = $this->system_model->enter_default_payment($insert_data);

            if ($response === false) {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'fail',
                    'stText'=>'PAYMENT UNSUCCESSFUL',
                    'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>'No previous payments',
                    'lastPaymentAmount'=>'No previous payments',
                    'stKey'=>$student_data->idstudent
                );
                exit(json_encode($return_data));
            } else {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'success',
                    'stText'=>'PAYMENT SUCCESSFUL',
                    'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>'No previous payments',
                    'lastPaymentAmount'=>'No previous payments',
                    'stKey'=>$student_data->idstudent
                );
                echo json_encode($return_data);
            }
        }
    }


    // function for enter custom payments
    public function enter_custom_payment () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cp');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }
        
        $this->load->model('system_model');
        date_default_timezone_set('Asia/Colombo');
        $time = time();

        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        $student_id = $_POST['studentId'];
        $month = explode('/',$_POST['monthYear'])[0];
        $year = explode('/',$_POST['monthYear'])[1];
        $classFee = $_POST['classFee'];

        if ($month > 12 || $month < 1 || !is_int(intval($month))) {
            exit(json_encode(array('success'=>false, 'err'=>'Invalid month. Check again.')));
        }

        if (!is_int(intval($year)) || $year > date('Y',$time) || $year < (date('Y',$time) - 3)) {
            exit(json_encode(array('success'=>false, 'err'=>'Invalid year. Check again.')));
        }

        if (!is_int(intval($classFee)) || $classFee > 10000) {
            exit(json_encode(array('success'=>false, 'err'=>'Invalid amount. Check again.')));
        }

        $student_row = $this->system_model->get_student_by_id($student_id);
        if ($student_row->num_rows() <= 0) {
            exit(json_encode(array('success'=>false, 'err'=>'No student belongs to the ID.')));
        }
        $student_data = $student_row->row();
        $last_payment = $this->system_model->get_last_payment_by_key($student_data->idstudent);



        if ($last_payment->num_rows() > 0) {
            $last_payment_data = $last_payment->last_row();

            $last_payment_date_string = $last_payment_data->date.' '.$last_payment_data->time;

            $matchPayment = $this->db->select('*')->from('class_payment')->where('student_idstudent',$student_data->idstudent)->where('year',$year)->where('month',$month)->get();
            if (isset($matchPayment) && $matchPayment->num_rows() > 0) {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'fail',
                    'stText'=>'ALREADY PAID FOR CURRENT MONTH',
                    'currentAmount'=>'LKR 0.00 ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                    'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                    'stKey'=>$student_data->idstudent
                );
                echo json_encode($return_data);
            } else {
                $insert_data = array (
                    'student_idstudent'=>$student_data->idstudent,
                    'student_number'=>$student_data->student_id,
                    'month'=>$month,
                    'year'=>$year,
                    'date'=>$current_date,
                    'time'=>$current_time,
                    'amount'=>$classFee
                );
                $response = $this->system_model->enter_default_payment($insert_data);

                if ($response === false) {
                    $return_data = array (
                        'success'=>true,
                        'profileImage'=>$student_data->student_image,
                        'stClass'=>'fail',
                        'stText'=>'PAYMENT UNSUCCESSFUL',
                        'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                        'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                        'studentId'=>$student_data->student_id,
                        'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                        'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                        'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                        'stKey'=>$student_data->idstudent
                    );
                    exit(json_encode($return_data));
                } else {
                    $return_data = array (
                        'success'=>true,
                        'profileImage'=>$student_data->student_image,
                        'stClass'=>'success',
                        'stText'=>'PAYMENT SUCCESSFUL',
                        'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                        'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                        'studentId'=>$student_data->student_id,
                        'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                        'lastPaymentDate'=>date('d, F Y h:i A',strtotime($last_payment_date_string)).' / For : '.$last_payment_data->month.'-'.$last_payment_data->year,
                        'lastPaymentAmount'=>'LKR '. number_format($last_payment_data->amount,2),
                        'stKey'=>$student_data->idstudent
                    );
                    echo json_encode($return_data);
                }
            }
        } else {
            $insert_data = array (
                'student_idstudent'=>$student_data->idstudent,
                'student_number'=>$student_data->student_id,
                'month'=>$month,
                'year'=>$year,
                'date'=>$current_date,
                'time'=>$current_time,
                'amount'=>$classFee
            );
            $response = $this->system_model->enter_default_payment($insert_data);

            if ($response === false) {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'fail',
                    'stText'=>'PAYMENT UNSUCCESSFUL',
                    'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>'No previous payments',
                    'lastPaymentAmount'=>'No previous payments',
                    'stKey'=>$student_data->idstudent
                );
                exit(json_encode($return_data));
            } else {
                $return_data = array (
                    'success'=>true,
                    'profileImage'=>$student_data->student_image,
                    'stClass'=>'success',
                    'stText'=>'PAYMENT SUCCESSFUL',
                    'currentAmount'=>'LKR '.number_format($insert_data['amount'],2).' ('.$student_data->payment_types.')',
                    'studentName'=>$student_data->first_name.' '.$student_data->last_name,
                    'studentId'=>$student_data->student_id,
                    'studentClass'=>$student_data->year.' - '.$student_data->locations.' - '.$student_data->types,
                    'lastPaymentDate'=>'No previous payments',
                    'lastPaymentAmount'=>'No previous payments',
                    'stKey'=>$student_data->idstudent
                );
                echo json_encode($return_data);
            }
        }
    }



     // function for payment history table enter payment view
    public function get_student_payment_history_table () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('cp');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        date_default_timezone_set('Asia/Colombo');
        $std_id = $_POST['student_id'];

        $student_row = $this->system_model->get_student_by_id($_POST['student_id']);
        if ($student_row->num_rows() <= 0) {
            
            $data['data'][] =array(
                'no'=>'Wrong ID!',
                'date'=>'Wrong ID!',
                'payfor'=>'Wrong ID!',
                'amount'=>'Wrong ID!',
                'actions'=>'Wrong ID!',
            );
            exit(json_encode($data));
        } else {
            $payments = $this->system_model->get_payment_history_by_id($student_row->row()->idstudent);
            
            if ($payments->num_rows() > 0) {
                foreach ($payments->result_array() as $key => $value) {
                    $dateString = $value['date'].' '.$value['time'];
                    $data['data'][] =array(
                        'no'=>$key,
                        'date'=>date('Y-m-d h:i A',strtotime($dateString)),
                        'payfor'=>$value['year'].'-'.$value['month'],
                        'amount'=>'LKR '. number_format($value['amount'],2),
                        'actions'=>'<a data-id="'.$value['idclass_payment'].'" class="btn pull-right btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                                    <a data-id="'.$value['idclass_payment'].'" class="btn pull-right btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>',
                    );
                }
                echo json_encode($data);
            } else {
                $data['data'] = array();
                echo json_encode($data);
            }
        }
    }


    // function for edit payment
    public function edit_payment () {


        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('udp');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $payid = $_POST['payment_id'];
        $value = $_POST['value'];

        if (!is_int(intval($value)) || $value == '') {
            exit(json_encode(array('success'=>false, 'err'=>'Invalid amount.')));
        } else {
            if ($this->db->where('idclass_payment',$payid)->update('class_payment', array('amount'=>$value))) {
                echo json_encode(array('success'=>true));
            } else {
                echo json_encode(array('success'=>false, 'err'=>'Payment not updated.'));
            }
        }

    }

    // function for delete payment
    public function delete_payment () {


        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('udp');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $payid = $_POST['payment_id'];

            if ($this->db->where('idclass_payment',$payid)->delete('class_payment')) {
                echo json_encode(array('success'=>true));
            } else {
                echo json_encode(array('success'=>false, 'err'=>'Payment not deleted.'));
            }
        

    }


    // function for issue student id
    public function issue_id() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('vpisi');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        // init system model
        $this->load->model('system_model');
        // get student related to the id
        $student = $this->system_model->get_student_by_id($_POST['studentId']);
        // data array
        $data = null;

        if ($student->num_rows() > 0) {
            // update student for id issue
            if ($this->system_model->update_student(array('is_card_issue'=>1),$student->row()->idstudent)) {
                $student_data = $student->row();
                $data = array (
                    'success' =>  true,
                    'profileImage' => $student_data->student_image,
                    'stClass' => 'success',
                    'stText' => 'ID Validated',
                    'studentName' => $student_data->first_name.' '.$student_data->last_name,
                    'studentId' => $student_data->student_id,
                    'studentClass' => $student_data->year.'-'.$student_data->locations.'-'.$student_data->types,
                    'studentType' => $student_data->stypes,
                    'classPaymentType' => $student_data->payment_types
                );
            } else {
                $student_data = $student->row();
                $data = array (
                    'success' =>  true,
                    'profileImage' => $student_data->student_image,
                    'stClass' => 'fail',
                    'stText' => 'ID Validation Failed.',
                    'studentName' => $student_data->first_name.' '.$student_data->last_name,
                    'studentId' => $student_data->student_id,
                    'studentClass' => $student_data->year.'-'.$student_data->locations.'-'.$student_data->types,
                    'studentType' => $student_data->stypes,
                    'classPaymentType' => $student_data->payment_types
                );
            }
        } else {
            $data = array (
                'success' =>  true,
                'profileImage' => '--',
                'stClass' => 'fail',
                'stText' => 'Invalid Student ID',
                'studentName' => '--',
                'studentId' => 'Invalid ID',
                'studentClass' => '--',
                'studentType' => '--',
                'classPaymentType' => '--'
            );
        }
        echo json_encode($data);
    }

    // function for single id card generate
    public function generate_single_id ($id) {

        date_default_timezone_set('Asia/Colombo');
        $this->load->model('system_model');

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('vpisi');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $student_id = $id;

        $data = $this->system_model->get_student_by_id($student_id);
        if ($data->num_rows() == 0) {
            exit(json_encode(array('success'=>false, 'err'=>'Student ID is wrong.')));
        }

        $file_name = date('Y_m_d_H_i',time()).'student_id.pdf';

        $print_data = array('student'=>$data);

        $this->load->library('pdf');
        $card_html = $this->load->view('/contents/id_templates/template',$print_data,true);
        echo $card_html;
        // $this->pdf->set_option('isHtml5ParserEnabled', true);
        // $this->pdf->set_option('isRemoteEnabled', true);   
        // $this->pdf->loadHtml($card_html);
        // $this->pdf->render();
        // $this->pdf->stream($file_name, array("Attachment"=>0));
    }



    // function for bulk id cards generate
    public function print_bulk_id ($cid,$type) {

        date_default_timezone_set('Asia/Colombo');
        $this->load->model('system_model');

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('vpisi');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $classID = $cid;
        $selectType = $type;

        $data = $this->system_model->get_data_for_bulk_id($classID,$selectType);

        $file_name = date('Y_m_d_H_i',time()).'student_bulk_id.pdf';

        $print_data = array('student'=>$data);

        $this->load->library('pdf');
        $card_html = $this->load->view('/contents/id_templates/template',$print_data,true);
        echo $card_html;
        // $this->pdf->set_option('isHtml5ParserEnabled', true);
        // $this->pdf->set_option('isRemoteEnabled', true);   
        
        // $this->pdf->set_paper('a4', 'landscape');   
        // $this->pdf->loadHtml($card_html);
        // $this->pdf->render();
        // $this->pdf->stream($file_name, array("Attachment"=>1));
    }

    // function for insert attendance
    public function insert_attendance () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('ca');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }
        $this->load->model('system_model');
        $stid = $_POST['inputStudentID'];

        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-m-d',time());
        $time = date('H:i:s',time());

        $student_data = $this->system_model->get_student_by_id($stid);
        if ($student_data->num_rows() > 0) {
            $row = $student_data->row();
            $data = array(
                'class_idclass'=>$row->idclass,
                'student_idstudent'=>$row->idstudent,
                'student_number'=>$row->student_id,
                'date'=>$date,
                'time'=>$time
            );
            $stt = $this->system_model->insert_attendance($data);
            if ($stt === 'am') {
                exit(json_encode(array('success'=>false, 'err'=>'Attendance already marked.')));
            }
            if ($stt === true) {
                $retdata = array(
                    'success'=>true,
                    'imgUrl'=>base_url().$row->student_image,
                    'name'=>$row->first_name.' '.$row->last_name,
                    'stid'=>$row->student_id,
                    'datetime'=>date('Y-m-d h:i A',time())
                );
                echo json_encode($retdata);
            } else {
                echo json_encode(array('success'=>false, 'err'=>'Student attendance not inserted.'));
            }
        } else {
            echo json_encode(array('success'=>false, 'err'=>'Student ID is wrong.'));
        }
    }


    // function for get class details to result report
    public function load_class_for_result_report() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('verr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get exam for result report
    public function load_exam_for_result_report() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('verr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $exams = $this->system_model->get_exam_by_class($_POST['class_id']);

        if ($exams->num_rows() > 0) {
            foreach ($exams->result_array() as $key => $value) {
                $data['exams'][] = array(
                    'examid'=>$value['idexams'],
                    'exam'=>$value['exam_type_code'].' - '.$value['paper_code'].' - '.$value['date'].' '.$value['time']
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }


    // function for get class wise result report
    public function get_class_result_report () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('verr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $class_id = $_POST['class_id'];
        $exam_id = $_POST['exam_id'];

        $this->load->model('system_model');

        // get year and model paper related to the exam
        $exam_data = $this->system_model->get_exam_data($class_id, $exam_id)->row();

        // year, class type and model paper
        $year = $exam_data->years_idyears;
        $model_paper = $exam_data->model_papers_idmodel_papers;
        $class_type = $exam_data->class_types_idclass_types;

        // get sorted exam results array
        $rank_data = $this->system_model->rank_student($year, $model_paper, $class_type);

        if ($rank_data != false) {
            
            foreach ($rank_data as $key => $value) {

                if ($class_id == $value['other_data']['idclass']) {
                    $student_data = $this->system_model->get_student($value['other_data']['student_idstudent'])->row_array();
                    $data['data'][] = array (
                        'class' => $student_data['locations'].'-'.$student_data['types'],
                        'student' => $student_data['first_name'].' '.$student_data['last_name'],
                        'idNo' => $student_data['student_id'],
                        'result' => $value['other_data']['marks'],
                        'cRank' => $value['class_rank'],
                        'iRank' => $value['island_rank']
                    );
                }
            }
            echo json_encode($data);
        } else {
            $data['data'] = array();
            echo json_encode($data);
        }
    }


    // function for get all island result report
    public function get_island_result_report () {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('verr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $year = $_POST['year_id'];
        $class_type = $_POST['class_type_id'];
        $model_paper = $_POST['paper_id'];

        $this->load->model('system_model');

        // get sorted exam results array
        $rank_data = $this->system_model->rank_student($year, $model_paper, $class_type);

        if ($rank_data != false) {
            
            foreach ($rank_data as $key => $value) {
                $student_data = $this->system_model->get_student($value['other_data']['student_idstudent'])->row_array();
                $data['data'][] = array (
                    'class' => $student_data['locations'].'-'.$student_data['types'],
                    'student' => $student_data['first_name'].' '.$student_data['last_name'],
                    'idNo' => $student_data['student_id'],
                    'result' => $value['other_data']['marks'],
                    'cRank' => $value['class_rank'],
                    'iRank' => $value['island_rank']
                );
            }
            echo json_encode($data);
        } else {
            $data['data'] = array();
            echo json_encode($data);
        }
    }


    public function send_results_sms () {


        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('serm');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $class_id = $_POST['class_id'];
        $exam_id = $_POST['exam_id'];

        $this->load->model('system_model');

        //variable for data
        $data = null;

        // get year and model paper related to the exam
        $exam_data = $this->system_model->get_exam_data($class_id, $exam_id)->row();

        // year, class type and model paper
        $year = $exam_data->years_idyears;
        $model_paper = $exam_data->model_papers_idmodel_papers;
        $class_type = $exam_data->class_types_idclass_types;

        // get sorted exam results array
        $rank_data = $this->system_model->rank_student($year, $model_paper, $class_type);

        if ($rank_data != false) {
            
            foreach ($rank_data as $key => $value) {

                if ($class_id == $value['other_data']['idclass']) {
                    $student_data = $this->system_model->get_student($value['other_data']['student_idstudent'])->row_array();
                    $data[] = array (
                        'src' => 'TheEconClz',
                        'dst' => $student_data['contact_no'],
                        'dr' => '1',
                        'msg' => $student_data['year'].'-'.$student_data['types'].'
'.$value['other_data']['paper_type'].'-'.$value['other_data']['date'].'
'.$student_data['student_id'].'
Your Marks: '.$value['other_data']['marks'].'
Class Rank: '.$value['class_rank'].'
Island Rank: '.$value['island_rank'].'
High Marks: '.$value['high_marks']
                    );
                }
            }


            $tosend = array(
                'action' => 'bulk_put',
                'user' => 'theeconclz',
                'password' => 'Tec86eCZ',
                'ea' => 'theeconclz',
                'campaign' => 'bulk',
                'records' => $data
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => 'https://sms.textware.lk:5001/bulk/sms.php',
                CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
                CURLOPT_POSTFIELDS => json_encode($tosend),
			));
            $response = curl_exec($curl);
            if (!$response) {
                die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
            }
            curl_close($curl);
            echo(($response));
            
        } else {
            echo json_encode(false);
        }
    }

    // function for get class for create exam dropdown
    public function get_class_for_student_attendance() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('var');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function get_class_for_student_id() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpisi');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    // function for get attendance report
    public function get_att_report() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('var');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }


        $this->load->model('system_model');
        $class_id = $_POST['class_id'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        // get filtered data to object
        $attenanceObj = $this->system_model->get_attendance_for_daterange($class_id, $from_date, $to_date);

        if ($attenanceObj != false) {
            
            foreach ($attenanceObj as $key => $value) {
                $data['data'][] = array (
                    'name' => $value['name'],
                    'id' => $value['id'],
                    'contact' => $value['contact'],
                    'attCount' => $value['att_count']
                );
            }
            echo json_encode($data);
        } else {
            $data['data'] = array();
            echo json_encode($data);
        }

    }


    // function for get monthly payement status report for class
    public function get_pymt_report() {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vpr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }


        $this->load->model('system_model');
        $class_id = $_POST['class_id'];
        $month = $_POST['month'];

        // get filtered data to object
        $paymentobj = $this->system_model->get_class_payment_for_month($class_id, $month);

        if ($paymentobj != false) {
            
            foreach ($paymentobj as $key => $value) {
                $data['data'][] = array (
                    'name' => $value['name'],
                    'id' => $value['id'],
                    'contact' => $value['contact'],
                    'pymtstatus' => $value['pymtstatus'],
                    'amount' => $value['amount'],
                    'date' => $value['date']
                );
            }
            echo json_encode($data);
        } else {
            $data['data'] = array();
            echo json_encode($data);
        }
    }


    // get class data for send message function
    public function get_class_for_send_message() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('scm');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes();

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }
    }



    // send class message function
    public function send_class_sms () {


        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('scm');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $class_id = $_POST['class_id'];
        $message = $_POST['message'];

        $this->load->model('system_model');

        //variable for data
        $data = null;

        // get all students in the class
        $student_data = $this->db->select('*')->from('student')->where('class_idclass',$class_id)->get();

        if ($student_data->num_rows() > 0) {
            
            foreach ($student_data->result_array() as $key => $value) {

                if ($value['contact_no'] != null || $value['contact_no'] != "") {
                    $data[] = array (
                        'src' => 'TheEconClz',
                        'dst' => $value['contact_no'],
                        'dr' => '1',
                        'msg' => $message
                    );
                }
            }


            $tosend = array(
                'action' => 'bulk_put',
                'user' => 'theeconclz',
                'password' => 'Tec86eCZ',
                'ea' => 'theeconclz',
                'campaign' => 'bulk',
                'records' => $data
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => 'https://sms.textware.lk:5001/bulk/sms.php',
                CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
                CURLOPT_POSTFIELDS => json_encode($tosend),
			));
            $response = curl_exec($curl);
            if (!$response) {
                die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
            }
            curl_close($curl);
            echo(($response));
            
        } else {
			echo json_encode(false);
		}
    }

    // function for get sms available credit
	public function get_sms_credit() {
    $username = 'theeconclz';
    $password = 'Tec86eCZ';

    $curl = curl_init();
    curl_setopt_array(
    $curl,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://220.247.201.241:5000/creditchk/index.php?username='.$username.'&password='.$password.'',
				CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded")
			)
		);
		$response = curl_exec($curl);
		if (!$response) {
			die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
		}
		curl_close($curl);
		echo(($response));
    }
    
    // function for get class for student details dropdown
    public function load_class_for_student_details() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsdr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }

    public function load_class_for_send_sms() {

        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $class = $this->system_model->get_classes_filter_by_year($_POST['year_id']);

        if ($class->num_rows() > 0) {
            foreach ($class->result_array() as $key => $value) {
                $data['class'][] = array(
                    'classid'=>$value['idclass'],
                    'year'=>$value['year'],
                    'type'=>$value['types'],
                    'location'=>$value['locations'],
                    'no'=>$key
                );
            }
            echo json_encode($data);
        } else {
            echo json_encode(false);
        }

    }


    // function for get students data table for students details report
    public function get_student_details_table () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('vsdr');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }


        $class_id = $_POST['class_id'];

        // data to object
        $student_data = $this->db->select('*')->from('student')->where('class_idclass',$class_id)->get();

        if ($student_data->num_rows() > 0) {
            
            foreach ($student_data->result_array() as $key => $value) {
                $data['data'][] = array (
                    'no' => $key+1,
                    'name' => $value['first_name'].' '.$value['last_name'],
                    'address' => $value['address'],
                    'contact' => $value['contact_no'],
                    'studentid' => $value['student_id'],
                    'nic' => $value['nic']
                );
            }
            echo json_encode($data);
        } else {
            $data['data'] = array();
            echo json_encode($data);
        }
    }


    // function for create new collection
    public function create_collection () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $this->load->library('form_validation');

        $c_name = $_POST['collectionName'];

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('collectionName', 'Collection name', 'required|is_unique[collections.collection_name]');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'collectionName'=>form_error('collectionName')
            ))));
        } else {
            $collection_data = array(
                'collection_name' => $c_name
            );
            $stat = $this->system_model->create_collection($collection_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>$stat));
            }
        }
    }


    // get collection table details
    public function get_collection_table () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');

        $collections = $this->system_model->get_collections();
        if ($collections == false) {
            $data['data'] = array();
            echo json_encode($data);
        } else {
            foreach ($collections as $collection) {
                $data['data'][] = array (
                    'no' => $collection['no'],
                    'name' => $collection['name'],
                    'qty' => $collection['qty'],
                    'actions' => '  <button data-toggle="modal" data-target="#editCollectionModal" data-id="'.$collection['id'].'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                                    <button data-id="'.$collection['id'].'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>
                                    <button data-toggle="modal" data-target="#sendSmsModal" data-name="'.$collection['name'].'" data-id="'.$collection['id'].'" class="btn btn-sm btn-success sendsms"><i class="fa fa-sms"></i></button>
                                    <div class="divfile btn btn-sm btn-primary">Upload excel file<input class="infile" accept=".xls, .xlsx" name="excelImport" id="excelImport" type="file" data-id="'.$collection['id'].'"></div>'
                );
            }
            echo json_encode($data);
        }
    }

    // delete collection
    public function delete_collection () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $id = $_POST['id'];
        $this->load->model('system_model');

        $status = $this->system_model->delete_collection($id);
        if ($status == true) {
            echo json_encode(true);
        } else {
            echo json_encode($status);
        }
    }

    // add View existing numbers table
    public function get_numbers_table () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $id = $_POST['id'];
        $this->load->model('system_model');

        $numbers = $this->system_model->get_collection_numbers($id);
        if ($numbers == false) {
            $data['data'] = array();
            echo json_encode($data);
        } else {
            foreach ($numbers as $number) {
                $data['data'][] = array (
                    'no' => $number['no'],
                    'number' => $number['number'],
                    'actions' => '  <button data-id="'.$number['id'].'" class="btn btn-sm btn-danger deletenumber"><i class="fa fa-trash"></i></button>
                                '
                );
            }
            echo json_encode($data);
        }
    }

    // enter numbers to collection
    public function enter_collection_number () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $this->load->library('form_validation');

        $phone_no = $_POST['newNumber'];
        $collectionID = $_POST['collectionID'];

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('newNumber', 'Phone number', 'required|is_unique[collection_numbers.phone_number]');
        if ($this->form_validation->run() == FALSE) {
            echo (json_encode(array('form_err'=>array(
                'newNumber'=>form_error('newNumber')
            ))));
        } else {
            $number_data = array(
                'phone_number' => $phone_no,
                'collections_idcollections' => $collectionID
            );
            $stat = $this->system_model->enter_collection_number($number_data);
            if($stat) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>$stat));
            }
        }
    }

    // delete collection number
    public function delete_collection_number () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $id = $_POST['id'];
        $this->load->model('system_model');

        $status = $this->system_model->delete_collection_number($id);
        if ($status == true) {
            echo json_encode(true);
        } else {
            echo json_encode($status);
        }
    }

    // send collection message function
    public function send_collection_sms () {


        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }
        
        $collection_id = $_POST['collection_id'];
        $message = $_POST['message'];

        $this->load->model('system_model');

        //variable for data
        $data = null;

        // get all numbers in the collections
        $collection_data = $this->db->select('*')->from('collection_numbers')->where('collections_idcollections',$collection_id)->get();

        if ($collection_data->num_rows() > 0) {
            
            foreach ($collection_data->result_array() as $key => $value) {

                if ($value['phone_number'] != null || $value['phone_number'] != "") {
                    $data[] = array (
                        'src' => 'TheEconClz',
                        'dst' => $value['phone_number'],
                        'dr' => '1',
                        'msg' => $message
                    );
                }
            }


            $tosend = array(
                'action' => 'bulk_put',
                'user' => 'theeconclz',
                'password' => 'Tec86eCZ',
                'ea' => 'theeconclz',
                'campaign' => 'bulk',
                'records' => $data
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => 'https://sms.textware.lk:5001/bulk/sms.php',
                CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
                CURLOPT_POSTFIELDS => json_encode($tosend),
			));
            $response = curl_exec($curl);
            if (!$response) {
                die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
            }
            curl_close($curl);
            echo(($response));
            
        } else {
			echo json_encode(false);
		}
    }

    // save excel sheet numbers for collections
    public function saveExcelSheet () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access('sosms');
        if ($res === false) {
            exit(json_encode(array('err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');

        $col_id = $_POST['collectionID'];
        $number_obj = $_POST['numberObj'];

        $data = null;

        foreach (json_decode($number_obj, true) as $key => $value) {
            if (isset($value['phone number'])) {
                $data[] = array (
                    'phone_number' => $value['phone number'],
                    'collections_idcollections' => $col_id
                );
            }
        }

        if (empty($data)) {
            echo json_encode(array('err'=>'File is unsupported or unsupported excel template.'));
        } else {
            if ($this->system_model->save_excel_numbers($data)) {
                echo json_encode(true);
            } else {
                echo json_encode(array('err'=>'Saving numbers is failed'));
            }
        }

    }

    public function get_last_attendances () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('ca');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $this->load->model('system_model');
        $stid = $_POST['inputStudentID'];

        $lastAtts = $this->system_model->get_last_atts($stid);

        if ($lastAtts == false) {
            $returnData['data'] = ' <div class="btn btn-block btn-danger btn-lg">
                                    <p>No past attendances.</p>
                                    </div>';
        } else {
            $htmlString = "";
            foreach ($lastAtts as $key => $att) {
                $num = $key + 1;
                $htmlString .=  '<div class="btn btn-block btn-success btn-lg">
                                <p>'.$num.'</p>
                                <p><strong>'.$att['date'].'</strong></p>
                                <p>'.$att['time'].'</p>
                                </div>';
            }
            $returnData['data'] = $htmlString;
        }
        echo json_encode($returnData);
    }

    public function get_attend_count () {
        // check for eligibility for user to execute operation
        $res = $this->user_model->validate_user_access ('ca');
        if ($res === false) {
            exit (json_encode (array ('success'=>false,'err'=>'You have no permission to perform this action')));
        }

        $student_id = $_POST['inputStudentID'];
        $this->load->model('system_model');
        $date = date('Y-m-d', time());

        $student_data = $this->system_model->get_student_by_id($student_id);
        $class_student_count = $this->db->select('*')->from('student')->where('class_idclass', $student_data->row()->idclass)->count_all_results();
        $attendance_count = $this->db->select('*')->from('attendances')->where('class_idclass', $student_data->row()->idclass)->where('date', $date)->count_all_results();


        $data = array (
            'all' => $class_student_count,
            'att' => $attendance_count,
            'class' => $student_data->row()->year." ".$student_data->row()->types,
            'location' => $student_data->row()->locations
        );

        echo json_encode($data);
    }
}

