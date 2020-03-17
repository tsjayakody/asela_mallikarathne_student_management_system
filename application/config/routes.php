<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'login_controller';
$route['forgot_password'] = 'user_controller/forgot_password';
$route['dashbord'] = 'view_controller/dashbord';
$route['view_controller'] = 'view_controller/dashbord';
$route['years'] = 'view_controller/years';
$route['manage_system_users'] = 'view_controller/manage_system_users';
$route['class_types'] = 'view_controller/class_types';
$route['exams'] = 'view_controller/exams';
$route['set_user_permissions'] = 'view_controller/set_user_permissions';
$route['model_papers'] = 'view_controller/model_papers';
$route['manage_students'] = 'view_controller/manage_students';
$route['manage_classes'] = 'view_controller/manage_classes';
$route['class_locations'] = 'view_controller/class_locations';
$route['manage_exam_results'] = 'view_controller/manage_exam_results';
$route['manage_payments'] = 'view_controller/manage_payments';
$route['manage_attendances'] = 'View_controller/manage_attendances';
$route['students_id'] = 'view_controller/students_id';
$route['exam_results_report'] = 'view_controller/exam_results_report';
$route['students_attendance_report'] = 'view_controller/students_attendance_report';
$route['students_payment_report'] = 'view_controller/students_payment_report';
$route['other_sms'] = 'view_controller/other_sms';
$route['send_class_message'] = 'view_controller/send_class_message';
$route['students_details'] = 'view_controller/students_details';
$route['logout'] = 'user_controller/logout';