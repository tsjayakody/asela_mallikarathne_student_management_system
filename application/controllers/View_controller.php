<?php
class View_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        if (!isset($_SESSION['user_data']) && $this->uri->segment(1) !== null) { // if unlogged client request others than login page
            
            redirect('/login');

        } elseif (!isset($_SESSION['user_data']) && $this->uri->segment(1) === null) { //if unlogged client request login page

            redirect('/login');

        } elseif (isset($_SESSION['user_data']) && $this->uri->segment(1) === null) {

            redirect('/dashbord');
            
        }
    }

    // create array for build menu
    public function build_user_menu($view){
        
        $user_id = $_SESSION['user_data']['id'];
        $user_type = $this->db->select('l_types')->from('user')->join('login_type','user.login_type_idlogin_type = login_type.idlogin_type')->where('user.iduser',$user_id)->get()->row()->l_types;
        if($user_type == 'admin') { // if user has admin rights
            $data = array();
            $main_menu = $this->db->select('*')->from('main_menu')->get(); // get main menu data
            foreach ($main_menu->result_array() as $key => $value) {
                $temp = null;
                $temp = array(
                    'idmain_menu' => $value['idmain_menu'],
                    'main_menu_name'=> $value['title'],
                    'main_menu_icon' => $value['icon'],
                    'main_nav_class' => " ",
                    'area_expand' => false,
                    'collaps' => " "
                );
                //get sub menu data
                $sub_menu = $this->db->select('*')->from('sub_menu')->where('main_menu_idmain_menu',$value['idmain_menu'])->get(); // get sub menu data
                foreach ($sub_menu->result_array() as $subkey => $subvalue) {
                    $temp['sub_menu'][$subkey] = array(
                        'idsub_menu' => $subvalue['idsub_menu'],
                        'sub_menu_name' => $subvalue['sub_menu_title'],
                        'view' => $subvalue['view'],
                        'short_name' => $subvalue['short_name'],
                        'sub_item' => " "
                    );
                    if($view != null) {
                        if($view == $subvalue['view']) {
                            $temp['main_nav_class'] = 'active';
                            $temp['area_expand'] = true;
                            $temp['collaps'] = 'show';
                            $temp['sub_menu'][$subkey]['sub_item'] = 'active';
                        }
                    }
                }
                $data[] = $temp;
            }
        }
        else {
            $data = array();
            $main_menu = $this->db
                                    ->select('*')
                                    ->from('user_menu')
                                    ->join('main_menu','main_menu.idmain_menu = user_menu.main_menu_idmain_menu')
                                    ->where('user_menu.user_iduser',$user_id)
                                    ->group_by('idmain_menu')
                                    ->get(); // get main menu data

            foreach ($main_menu->result_array() as $key => $value) {
                $temp = null;
                $temp = array(
                    'idmain_menu' => $value['idmain_menu'],
                    'main_menu_name'=> $value['title'],
                    'main_menu_icon' => $value['icon'],
                    'main_nav_class' => " ",
                    'area_expand' => false,
                    'collaps' => " "
                );
                //get sub menu data
                $sub_menu = $this->db->select('*')
                                        ->from('user_menu')
                                        ->join('sub_menu','sub_menu.idsub_menu = user_menu.sub_menu_idsub_menu')
                                        ->where('user_menu.main_menu_idmain_menu',$value['idmain_menu'])
                                        ->get(); // get sub menu data

                foreach ($sub_menu->result_array() as $subkey => $subvalue) {
                    $temp['sub_menu'][$subkey] = array(
                        'idsub_menu' => $subvalue['idsub_menu'],
                        'sub_menu_name' => $subvalue['sub_menu_title'],
                        'view' => $subvalue['view'],
                        'short_name' => $subvalue['short_name'],
                        'sub_item' => " "
                    );
                    if($view != null) {
                        if($view == $subvalue['view']) {
                            $temp['main_nav_class'] = 'active';
                            $temp['area_expand'] = true;
                            $temp['collaps'] = 'show';
                            $temp['sub_menu'][$subkey]['sub_item'] = 'active';
                        }
                    }
                }
                $data[] = $temp;
            }
        }
        return $data ;
    }

    // function for dashboard view
    public function dashbord(){
        $data = array(
            'menu'=>$this->build_user_menu(null),
            'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
            'nav_brand' => 'Dashboard'
        );
        $this->load->view('includes/header',$data);
        $this->load->view('contents/dashbord');
        $this->load->view('includes/footer',array('js'=>null));
    }

    public function view_access($view){
        $user_id = $_SESSION['user_data']['id'];
        if (!isset($user_id)) {
            redirect('/login');
        } else {
            $user_type = $this->db->select('l_types')
                                ->from('user')
                                ->join('login_type','login_type_idlogin_type = idlogin_type')
                                ->where('iduser',$user_id)
                                ->get()->row()->l_types;
            
            if ($user_type == 'admin') {
                return true;
            } else {
                $dt = $this->db->select('*')
                                ->from('sub_menu')
                                ->join('access_permissions','idsub_menu = sub_menu_idsub_menu')
                                ->where('access_permissions.is_view',1)
                                ->where('sub_menu.view',$view)
                                ->get()->row()->access_code;
                return $this->user_model->validate_user_access($dt);
            }
        }
    }


    // function for years view
    public function years(){
        $perm = $this->view_access('years');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('years'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Years'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/years');
            $this->load->view('includes/footer',array('js'=>'years'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('years'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for system user management view
    public function manage_system_users() {
        $perm = $this->view_access('manage_system_users');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_system_users'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage System Users'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_system_users');
            $this->load->view('includes/footer',array('js'=>'manage_system_users'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_system_users'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for class types view
    public function class_types() {
        $perm = $this->view_access('class_types');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('class_types'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Class Types'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/class_types');
            $this->load->view('includes/footer',array('js'=>'class_types'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('class_types'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for exam view
    public function exams() {
        $perm = $this->view_access('exams');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('exams'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Exams'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/exams');
            $this->load->view('includes/footer',array('js'=>'exams'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('exams'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for set user permissions view
    public function set_user_permissions() {
        $perm = $this->view_access('set_user_permissions');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('set_user_permissions'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Change User Permissions'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/set_user_permissions');
            $this->load->view('includes/footer',array('js'=>'set_user_permissions'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('set_user_permissions'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for set manage model papers view
    public function model_papers() {
        $perm = $this->view_access('model_papers');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('model_papers'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Model Papers'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/model_papers');
            $this->load->view('includes/footer',array('js'=>'model_papers'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('model_papers'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for set manage manage students view
    public function manage_students() {
        $perm = $this->view_access('manage_students');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_students'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Students'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_students');
            $this->load->view('includes/footer',array('js'=>'manage_students'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_students'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for manage classes view
    public function manage_classes() {
        $perm = $this->view_access('manage_classes');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_classes'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Classes'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_classes');
            $this->load->view('includes/footer',array('js'=>'manage_classes'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_classes'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }



    // function for manage class locations view
    public function class_locations() {
        $perm = $this->view_access('class_locations');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('class_locations'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Class Locations'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/class_locations');
            $this->load->view('includes/footer',array('js'=>'class_locations'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('class_locations'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for manage exam results view
    public function manage_exam_results() {
        $perm = $this->view_access('manage_exam_results');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_exam_results'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Exam Results'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_exam_results');
            $this->load->view('includes/footer',array('js'=>'manage_exam_results'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_exam_results'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for pyament view
    public function manage_payments() {
        $perm = $this->view_access('manage_payments');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_payments'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Payments'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_payments');
            $this->load->view('includes/footer',array('js'=>'manage_payments'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_payments'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for manage attendance view
    public function manage_attendances() {
        $perm = $this->view_access('manage_attendances');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('manage_attendances'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Manage Attendance'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/manage_attendances');
            $this->load->view('includes/footer',array('js'=>'manage_attendances'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('manage_attendances'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for manage students id view
    public function students_id() {
        $perm = $this->view_access('students_id');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('students_id'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Print Students ID'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/students_id');
            $this->load->view('includes/footer',array('js'=>'students_id'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('students_id'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for exam reports view
    public function exam_results_report() {
        $perm = $this->view_access('exam_results_report');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('exam_results_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Exam Results Report'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/exam_results_report');
            $this->load->view('includes/footer',array('js'=>'exam_results_report'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('exam_results_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for attendance report view
    public function students_attendance_report() {
        $perm = $this->view_access('students_attendance_report');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('students_attendance_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Student Attendance Report'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/students_attendance_report');
            $this->load->view('includes/footer',array('js'=>'students_attendance_report'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('students_attendance_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for payments report view
    public function students_payment_report() {
        $perm = $this->view_access('students_payment_report');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('students_payment_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Student Payment Report'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/students_payment_report');
            $this->load->view('includes/footer',array('js'=>'students_payment_report'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('students_payment_report'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for payments report view
    public function send_class_message() {
        $perm = $this->view_access('send_class_message');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('send_class_message'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Send Class Message'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/send_class_message');
            $this->load->view('includes/footer',array('js'=>'send_class_message'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('send_class_message'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }

    // function for students details report
    public function students_details() {
        $perm = $this->view_access('students_details');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('students_details'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Students Details Report'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/students_details');
            $this->load->view('includes/footer',array('js'=>'students_details'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('students_details'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }


    // function for other sms send view
    public function other_sms() {
        $perm = $this->view_access('other_sms');
        if ($perm) {
            $data = array(
                'menu'=>$this->build_user_menu('other_sms'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'Send Other SMS'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/other_sms');
            $this->load->view('includes/footer',array('js'=>'other_sms'));
        } else {
            $data = array(
                'menu'=>$this->build_user_menu('other_sms'),
                'name' => $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name'],
                'nav_brand' => 'No Access'
            );
            $this->load->view('includes/header',$data);
            $this->load->view('contents/noaccess');
            $this->load->view('includes/footer',array('js'=>null));
        }
    }
}