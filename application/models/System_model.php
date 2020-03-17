<?php
class System_model extends CI_Model{

    // function for insert year data
    public function insert_year($year){
        if ($this->db->insert('years',array('year'=>$year))) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete specific year
    public function delete_year($id){
        if ($this->db->delete('years',array('idyears'=>$id))) {
            return true;
        } else {
            return false;
        }
    }

    // function for update specific year
    public function update_year($year,$id) {
        if ($this->db->where('idyears',$id)->update('years',array('year'=>$year))) {
            return true;
        } else {
            return false;
        }
    }

    // function for get class location data
    public function get_class_locations() {
        return $this->db->get('class_locations');
    }

    // function for get specific class location data
    public function get_class_location($id) {
        return $this->db->get_where('class_locations',array('idclass_locations'=>$id));
    }

    // function for create class location
    public function create_class_location($class_location) {
        if ($this->db->insert('class_locations',$class_location)) {
            return true;
        } else {
            return false;
        }
    }

    // function for update class location
    public function update_class_location($location_data,$id){
        if ($this->db->set($location_data)->where('idclass_locations',$id)->update('class_locations')) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete class location
    public function delete_class_location($id) {
        if ($this->db->where('idclass_locations',$id)->delete('class_locations')) {
            return true;
        } else {
            return false;
        }
    }

    // function for create class type
    public function insert_class_type($classType) {
        if($this->db->insert('class_types',$classType)) {
            return true;
        } else {
            return false;
        }
    }

    // function for get class types
    public function get_class_type($spd = 'all'){
        if ($spd === 'all') {
            return $this->db->get('class_types');
        } else {
            return $this->db->select('*')->from('class_types')->where('idclass_types',$spd)->get();
        }
    }

    // function for update class type
    public function update_class_type($data, $id) {
        if($this->db->where('idclass_types',$id)->update('class_types',$data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete class type
    public function delete_class_type($id){
        if ($this->db->delete('class_types',array('idclass_types'=>$id))) {
            return true;
        } else {
            return false;
        }
    }

    // function for get exams data
    public function get_exams() {
        $exams = $this->db->select('*')
                            ->from('class')
                            ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                            ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                            ->join('exams','exams.class_idclass = class.idclass')
                            ->join('model_papers','exams.model_papers_idmodel_papers = model_papers.idmodel_papers')
                            ->join('exam_types','exams.exam_types_idexam_types = exam_types.idexam_types')
                            ->join('years','class.years_idyears = years.idyears')
                            ->order_by('exams.idexams', 'DESC')
                            ->get();

        return $exams;
    }

    // function for get specific exam data
    public function get_exam($id) {
        $exams = $this->db->select('*')
                            ->from('class')
                            ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                            ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                            ->join('exams','exams.class_idclass = class.idclass')
                            ->join('model_papers','exams.model_papers_idmodel_papers = model_papers.idmodel_papers')
                            ->join('exam_types','exams.exam_types_idexam_types = exam_types.idexam_types')
                            ->join('years','class.years_idyears = years.idyears')
                            ->order_by('exams.idexams', 'DESC')
                            ->where('exams.idexams',$id)
                            ->get();

        return $exams;
    }

    // function for get specific exam data by class id
    public function get_exam_by_class($id) {
        $exams = $this->db->select('*')
                            ->from('class')
                            ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                            ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                            ->join('exams','exams.class_idclass = class.idclass')
                            ->join('model_papers','exams.model_papers_idmodel_papers = model_papers.idmodel_papers')
                            ->join('exam_types','exams.exam_types_idexam_types = exam_types.idexam_types')
                            ->join('years','class.years_idyears = years.idyears')
                            ->order_by('exams.idexams', 'DESC')
                            ->where('exams.class_idclass',$id)
                            ->get();

        return $exams;
    }

    // function for get class data
    public function get_classes() {
        return $this->db->select('*')
                        ->from('class')
                        ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                        ->order_by('class.idclass','DESC')
                        ->get();
    }

    // function for get specific class data
    public function get_class($id) {
        return $this->db->select('*')
                        ->from('class')
                        ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                        ->where('idclass',$id)
                        ->order_by('class.idclass','DESC')
                        ->get();
    }

    // function for update class
    public function update_class($data,$id) {
        if ($this->db->set($data)->where('idclass',$id)->update('class')) {
            return true;
        } else {
            return false;
        }
    }

    // function for create class
    public function create_class($data) {
        if ($this->db->insert('class',$data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete class
    public function delete_class($id) {
        if ($this->db->where('idclass',$id)->delete('class')) {
            return true;
        } else {
            return false;
        }
    }

    // function for get paper data
    public function get_papers() {
        return $this->db->select('*')
                        ->from('model_papers')
                        ->order_by('idmodel_papers','DESC')
                        ->get();
    }

    // function for get exam types
    public function get_exam_types() {
        return $this->db->select('*')
                        ->from('exam_types')
                        ->order_by('idexam_types','DESC')
                        ->get();
    }

    // function for create exam
    public function create_exam($exam) {
        if($this->db->insert('exams',$exam)) {
            return true;
        } else {
            return false;
        }
    }

    // function for update exam
    public function update_exam($data,$id) {
        if($this->db->where('idexams',$id)->update('exams',$data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete exam
    public function delete_exam($id) {
        if ($this->db->delete('exams',array('idexams'=>$id))) {
            return true;
        } else {
            return false;
        }
    }

    // function for get all sub_menus
    public function get_sub_menus(){
        return $this->db->get('sub_menu');
    }

    // function for get model papers
    public function get_model_papers($sp = 'all') {
        if ($sp === 'all') {
            return $this->db->get('model_papers');
        } else {
            return $this->db->get_where('model_papers',array('idmodel_papers'=>$sp));
        }
    }

    // function for create model paper
    public function insert_model_paper($data) {
        if ($this->db->insert('model_papers',$data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for update model paper
    public function update_model_paper($data,$modelPaperID) {
        if ($this->db->set($data)->where('idmodel_papers',$modelPaperID)->update('model_papers')) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete model paper
    public function delete_model_paper($model_paper_id) {
        if ($this->db->where('idmodel_papers',$model_paper_id)->delete('model_papers')) {
            return true;
        } else {
            return false;
        }
    }

    // function for get student types
    public function get_student_type() {
        return $this->db->get('student_types');
    }

    // function for get year
    public function get_year() {
        return $this->db->select('*')->from('years')->order_by('idyears','DESC')->get();
    }

    // function for get payment types
    public function get_payment_types() {
        return $this->db->get('class_payment_types');
    }

    // function for create student
    public function create_student($student_data) {

        $this->db->trans_begin();

            $class_data = $this->db->select('*')->from('class')->join('years','years_idyears = idyears')->join('class_locations','class_locations_idclass_locations = idclass_locations')->join('class_types','class_types_idclass_types = idclass_types')->where('idclass',$student_data['class_idclass'])->get();
            $st_number = 0;
            $st_count = $this->db->select('*')->from('student')->where('class_idclass',$student_data['class_idclass'])->get()->num_rows();
            if (isset($student_data['student_id']) && $student_data['student_id'] !== null && $student_data['student_id'] !== "") {
                if ($student_data['student_id'] > (int)$class_data->row()->from_id && $student_data['student_id'] <= (int)$class_data->row()->to_id) {
                    $str_length = 4;
                    $str = substr("000{$student_data['student_id']}", - $str_length);
                    $st_number = $str;
                } else {
                    return array ('success' => false, 'err'=>'Maximum student ID allocation for the is exceeded.');
                    exit();
                }
            }
            elseif ($st_count == 0) {
                $num = 1+(int)$class_data->row()->from_id;
                $str_length = 4;
                $str = substr("000{$num}", - $str_length);
                $st_number = $str;
            } else {
                $max_increment = $this->db->select_max('idstudent')->from('student')->where('class_idclass',$student_data['class_idclass'])->get()->row()->idstudent;
                $max_inc_stid = $this->db->get_where('student',array('idstudent'=>$max_increment))->row()->student_id;
                $exist_max_number = explode('-',$max_inc_stid)[3];
                $num = $exist_max_number+1;
                $str_length = 4;
                $str = substr("000{$num}", - $str_length);
                $st_number = $str;
            }
            $st_id = strtoupper($class_data->row()->locations_code).'-'.strtoupper($class_data->row()->class_type_code).'-'.$class_data->row()->year.'-'.$st_number;
            $student_data['student_id'] = $st_id;
            $this->db->insert('student',$student_data);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return array('success'=>false, 'err'=>'Student is not created due to the server error.');
        }
        else
        {
            $this->db->trans_commit();
            $last_id = $this->db->query('SELECT LAST_INSERT_ID()')->row_array()['LAST_INSERT_ID()'];
            return array('success'=>true, 'stid'=>$last_id);
        }
    }

    // function for update student
    public function update_student($student,$id) {
        if ($this->db->set($student)->where('idstudent',$id)->update('student')) {
            return true;
        } else {
            return false;
        }
    }

    // function for get students
    public function get_students() {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->order_by('class.idclass','DESC')
                        ->get();
    }


    // function for search student by student id
    public function get_student_by_id($id) {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->order_by('class.idclass','DESC')
                        ->where('student.student_id',$id)
                        ->get();
    }

    // function for search student by student id
    public function get_student_by_name($name) {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->order_by('class.idclass','DESC')
                        ->like('CONCAT(first_name, " ", last_name)',$name)
                        ->get();
    }

    // function for search student by contact
    public function get_student_by_contact($contact) {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->order_by('class.idclass','DESC')
                        ->where('student.contact_no',$contact)
                        ->get();
    }

    // function for get student by id number
    public function search_student_by_id ($id) {

        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->where('student_id',$id)
                        ->get();

    }

    // get student for bulk id print
    public function get_data_for_bulk_id($classID,$selectType) {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->where('idclass',$classID)
                        ->where('is_card_issue',$selectType)
                        ->get();
    }

    // function for get student
    public function get_student($id) {
        return $this->db->select('*')
                        ->from('student')
                        ->join('student_types','student.student_types_idstudent_types = student_types.idstudent_types')
                        ->join('class','class.idclass = student.class_idclass')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class_types.idclass_types = class.class_types_idclass_types')
                        ->join('class_payment_types','student.class_payment_types_idclass_payment_types = class_payment_types.idclass_payment_types')
                        ->join('class_locations','class_locations.idclass_locations = class.class_locations_idclass_locations')
                        ->where('idstudent',$id)
                        ->get();
    }

    // function for delete student
    public function delete_student($stid){
        $img_path = $this->db->get_where('student',array('idstudent'=>$stid))->row()->student_image;
        if ($this->db->where('idstudent',$stid)->delete('student')) {
            return array('success'=>true, 'img_path'=>$img_path);
        } else {
            return array('success'=>false);
        }
    }

    // function for enter student results
    public function enter_result ($result, $student, $exam) {
        if ($this->db->insert('exam_results', array('exams_idexams'=>$exam, 'student_idstudent' => $student, 'marks' => $result))) {
            return true;
        } else {
            return false;
        }
    }

    // function for get result data from student id and exam id
    public function get_result_data ($student,$exam) {

        $idstudent = $this->db->get_where('student',array('student_id'=>$student))->row()->idstudent;
        
        return $this->db->select('*')
                        ->from('exam_results')
                        ->where('student_idstudent',$idstudent)
                        ->where('exams_idexams',$exam)
                        ->get();
                        
    }

    // function for get result data from exam id
    public function get_result_data_by_id ($id) {
        
        return $this->db->select('*')
                        ->from('exam_results')
                        ->join('exams','exam_results.exams_idexams = exams.idexams')
                        ->join('student','exam_results.student_idstudent = student.idstudent')
                        ->join('class','exams.class_idclass = class.idclass')
                        ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                        ->join('model_papers','model_papers.idmodel_papers = exams.model_papers_idmodel_papers')
                        ->where('exams_idexams',$id)
                        ->get();

    }

    // function for get result data from student field id and exam id
    public function get_result_data_enter_res ($student,$exam) {
        
        return $this->db->select('*')
                        ->from('exam_results')
                        ->where('student_idstudent',$student)
                        ->where('exams_idexams',$exam)
                        ->get();
    }

    // function for exam validate by date and time
    public function check_date_for_result_enter ($exam) {
        $exam_data = $this->get_exam($exam);
        date_default_timezone_set('Asia/Colombo');
        $row_date_srting = $exam_data->row()->date.' '.$exam_data->row()->time;
        $date = date_create_from_format('m/d/Y H:i:s', $row_date_srting);

        $formated_date = date_format($date, 'Y-m-d H:i:s');
        $date_now = date("Y-m-d H:i:s");
        
        if ($formated_date < $date_now) {
            return true;
        } else {
            return false;
        }
    }

    // function for update results
    public function update_result ($result,$id) {
        if ($this->db->where('idexam_results',$id)->update('exam_results',array('marks'=>$result))) {
            return true;
        } else {
            return false;
        }
    }

    // function for delete result
    public function delete_result ($id) {
        if ($this->db->where('idexam_results',$id)->delete('exam_results')) {
            return true;
        } else {
            return false;
        }
    }


    // function for get last payment by key
    public function get_last_payment_by_key ($key) {
        return $this->db->select('*')
                        ->from('class_payment')
                        ->where('student_idstudent',$key)
                        ->get();
    }

    // function for insert default payment
    public function enter_default_payment ($data) {
        if ($this->db->insert('class_payment',$data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for get payments by student key
    public function get_payment_history_by_id($id) {
        return $this->db->select('*')->from('class_payment')->where('student_idstudent',$id)->order_by('idclass_payment','DESC')->get();
    }

    // get system permissions
    public function get_system_permissions_by_id ($subid) {
        return $this->db->select('*')->from('access_permissions')->where('is_view',0)->where('sub_menu_idsub_menu',$subid)->get();
    }

    // insert attendance
    public function insert_attendance($data) {
        $last_am = $this->db->select('*')->from('attendances')
                                        ->where('student_idstudent',$data['student_idstudent'])
                                        ->where('date',$data['date'])
                                        ->get();
        if ($last_am->num_rows() > 0) {
            $st = 'am';
            return $st;
        } else {
            if ($this->db->insert('attendances',$data)) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    // get exam data by class and exam id
    public function get_exam_data($class_id, $exam_id) {
        return $this->db->select('*')
                        ->from('exams')
                        ->join('class','class_idclass = idclass')
                        ->where('idexams',$exam_id)
                        ->where('idclass',$class_id)
                        ->get();
    }

    // calculate class rank for student result
    public function get_class_rank ($data) {
        $class_rank = null;
        $class_results = $this->db->select('*')->from('exam_results')->where('exams_idexams',$data['idexams'])->group_by('marks')->order_by('marks','DESC')->get();
        foreach ($class_results->result_array() as $key => $value) {
            if ($value['marks'] == $data['marks']) {
                $class_rank = $key+1; 
            }
        }
        return $class_rank;
    }

    public function rank_student ($year, $model_paper, $class_type) {

        // get all results without duplicate results
        $grouped_results = $this->db->select('*')
                                    ->from('exam_results')
                                    ->join('exams','idexams = exams_idexams')
                                    ->join('class','idclass = class_idclass')
                                    ->where('model_papers_idmodel_papers',$model_paper)
                                    ->where('years_idyears',$year)
                                    ->where('class_types_idclass_types',$class_type)
                                    ->group_by('marks')
                                    ->order_by('marks','DESC')
                                    ->get();
        
        
        
        // if result set is not empty
        if ($grouped_results->num_rows() > 0) {
            
            // loop through grouped results and get all results to array
            $result_array = $grouped_results->result_array();
            $high_marks = $result_array[0]['marks'];
            foreach ($result_array as $key => $value) {
                // get all results include mark duplicates
                $all_res = $this->db->select('*')
                                    ->from('exam_results')
                                    ->join('student','exam_results.student_idstudent = idstudent')
                                    ->join('exams','idexams = exam_results.exams_idexams')
                                    ->join('class','idclass = student.class_idclass')
                                    ->join('model_papers','idmodel_papers = exams.model_papers_idmodel_papers')
                                    ->where('model_papers_idmodel_papers',$model_paper)
                                    ->where('years_idyears',$year)
                                    ->where('class_types_idclass_types',$class_type)
                                    ->where('marks',$value['marks'])
                                    ->order_by('marks','DESC')
                                    ->get()->result_array();
                
                // insert all results to array
                foreach ($all_res as $key1 => $value1) {
                    $data[] = array(
                        'high_marks' => $high_marks,
                        'island_rank' => $key+1,
                        'class_rank' => $this->get_class_rank($value1),
                        'other_data' => $value1
                    );
                }
            }
            return $data;
        } else {
            return false;
        }
        
    }


    // get attendance data for selected date range
    public function get_attendance_for_daterange($class_id, $from_date, $to_date) {
        $studentsObj = $this->db->select('*')->from('student')->where('class_idclass',$class_id)->get();
        
        if ($studentsObj -> num_rows() > 0) {
            
            foreach ($studentsObj->result_array() as $key => $value) {
                $count = $this->db->where('student_idstudent',$value['idstudent'])
                                    ->where('date <=', $to_date)
                                    ->where('date >=', $from_date)
                                    ->from('attendances')
                                    ->count_all_results();


                $att_data[] = array (
                    'att_count' => $count,
                    'name' => $value['first_name'].' '.$value['last_name'],
                    'contact' => $value['contact_no'],
                    'id' => $value['student_id']
                );
            }
            return $att_data;
        } else {
            return false;
        }
    }


    // get class payment data for selected month
    public function get_class_payment_for_month($class_id, $monthYear) {
        $studentsObj = $this->db->select('*')->from('student')->where('class_idclass',$class_id)->get();
        $year = explode("-",$monthYear)[0];
        $month = explode("-",$monthYear)[1];

        if ($studentsObj -> num_rows() > 0) {
            
            foreach ($studentsObj->result_array() as $key => $value) {
                $paydataobj = $this->db->select('*')
                                    ->from('class_payment')
                                    ->where('student_idstudent',$value['idstudent'])
                                    ->where('year',$year)
                                    ->where('month',$month)
                                    ->get();

                if ($paydataobj->num_rows() > 0) {
                    $payment = $paydataobj->row_array();
                    $pay_data[] = array (
                        'pymtstatus' => '<span class="badge badge-success">PAYED</span>',
                        'date' => $payment['date'].' '.$payment['time'],
                        'amount' => 'Rs.'.number_format($payment['amount'],2),
                        'name' => $value['first_name'].' '.$value['last_name'],
                        'contact' => $value['contact_no'],
                        'id' => $value['student_id']
                    );
                } else {
                    $pay_data[] = array (
                        'pymtstatus' => '<span class="badge badge-danger">UNPAYED</span>',
                        'date' => '---',
                        'amount' => '---',
                        'name' => $value['first_name'].' '.$value['last_name'],
                        'contact' => $value['contact_no'],
                        'id' => $value['student_id']
                    );
                }
            }
            return $pay_data;
        } else {
            return false;
        }
    }


    // create a collection
    public function create_collection ($data) {
        if ($this->db->insert('collections', $data)) {
            return true;
        } else {
            return $this->db->error();
        }
    }

    // get collection data for main table
    public function get_collections () {
        $collections = $this->db->select('*')->from('collections')->get();
        if ($collections->num_rows() > 0) {
            foreach ($collections->result_array() as $key => $value) {
                $data[] = array (
                    'no' => $key+1,
                    'name' => $value['collection_name'],
                    'id' => $value['idcollections'],
                    'qty' => $this->db->where('collections_idcollections',$value['idcollections'])->from('collection_numbers')->count_all_results()
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    // delete collection
    public function delete_collection ($id) {
        $this->db->trans_start();
        $this->db->where('collections_idcollections',$id)->delete('collection_numbers');
        $this->db->where('idcollections',$id)->delete('collections');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return $this->db->log_user();
        }
        else
        {
            return true;
        }
    }

    // get collection numbers
    public function get_collection_numbers ($id) {
        $numbers = $this->db->select('*')->from('collection_numbers')->where('collections_idcollections',$id)->get();
        if ($numbers->num_rows() > 0) {
            foreach ($numbers->result_array() as $key => $value) {
                $data[] = array (
                    'no' => $key+1,
                    'number' => $value['phone_number'],
                    'id' => $value['idcollection_numbers']
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    // enter numbers to collection
    public function enter_collection_number ($data) {
        if ($this->db->insert('collection_numbers', $data)) {
            return true;
        } else {
            return $this->db->error();
        }
    }

    // delete collection number
    public function delete_collection_number ($id) {
        if ($this->db->where('idcollection_numbers',$id)->delete('collection_numbers')) {
            return true;
        } else {
            return $this->db->error();
        }
    }

    // save numbers from excel file for collections
    public function save_excel_numbers ($data) {
        if ($this->db->insert_batch('collection_numbers', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // function for get last attenaces of student
    public function get_last_atts ($stid) {
        $att = $this->db->select('*')->from('attendances')->where('student_number',$stid)->order_by('idattendances','DESC')->limit('5')->get();
        if ($att->num_rows() > 0) {
            $data = null;
            foreach ($att->result_array() as $value) {
                $data[] = array (
                    'date' => $value['date'],
                    'time' => $value['time']
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    // function for get classes filter by year
    public function get_classes_filter_by_year ($year_id) {
        return $this->db->select('*')
                        ->from('class')
                        ->join('class_locations','class.class_locations_idclass_locations = class_locations.idclass_locations')
                        ->join('years','class.years_idyears = years.idyears')
                        ->join('class_types','class.class_types_idclass_types = class_types.idclass_types')
                        ->where('years_idyears',$year_id)
                        ->order_by('class.idclass','DESC')
                        ->get();
    }

    
}