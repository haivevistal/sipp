<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('courses_model');
        $this->load->model('attendance_model');
        $this->load->model('activities_model');
        $this->load->model('setting_model');
        $this->load->model('announcement_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url'); 
    }
    
    public function is_logged_in() {
        if( !$this->session->userdata('admin_user_id') ) {
            $this->session->set_flashdata('error_msg', 'Wrong email or password, please try again.');
            redirect( base_url('/portal/login/?msg=error') );
        }
    }
    
    /* Login */
    public function login() {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        
        if( isset($_POST["submit_login"]) ) {
        if ($this->form_validation->run() === TRUE)
            {
                $login = $this->user_model->login_admin_user();
                if( $login != false ) {
                    $this->session->set_userdata('admin_user_id',$login[0]['id']);
                    $this->session->set_userdata('admin_firstname',$login[0]['firstname']);
                    $this->session->set_userdata('admin_lastname',$login[0]['lastname']);
                    $this->session->set_userdata('admin_email',$login[0]['email']);
                    $this->session->set_userdata('admin_username',$login[0]['username']);
                    $this->session->set_userdata('admin_usertype', $login[0]['usertype']);
                    $this->session->set_userdata('admin_companyid', $login[0]['company_id']);
                    
                    redirect( base_url('/portal?msg=success') );
                    
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong email or password, please try again.');
                    redirect( base_url('/portal/login/?msg=error') );
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Error occured, please try again.');
                redirect( base_url('/portal/login/?msg=error') );
            }
        }
        
        $data = array();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('admin/login', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    /* Logout */
    public function admin_logout(){
        $this->session->unset_userdata('admin_user_id',);
        $this->session->unset_userdata('admin_firstname');
        $this->session->unset_userdata('admin_lastname');
        $this->session->unset_userdata('admin_email');
        $this->session->unset_userdata('admin_username');
        $this->session->unset_userdata('admin_usertype');
        $this->session->unset_userdata('admin_companyid');
        redirect( base_url('/portal/login/?msg=logout_success') );
    }
  
    /* Users */
    public function index() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    /* Users */
    public function users() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['companies'] = $this->setting_model->company_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('includes/admin/footer', $data);
        
    }
    
    public function add_user() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['user_types'] = $this->user_model->user_types();
        $data['companies'] = $this->setting_model->company_list();
        $data['courses'] = $this->courses_model->courses_list();
        if( isset($_POST["save_user"]) ) {
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            $this->form_validation->set_rules('emergency_phone', 'Emergency Phone Number', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('usertype', 'Type of User', 'required');
            $this->form_validation->set_rules('bio', 'Bio', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                if( $this->user_model->check_email_exist( $this->input->post('email') ) ) {
                    $data["errormsg"] = "Email already exist! Please try again.";
                } else if( $this->user_model->check_phone_exist( $this->input->post('phone') ) ) {
                    $data["errormsg"] = "Phone number already exist! Please try again.";
                } else if( $this->user_model->check_username_exist( $this->input->post('username') ) ) {
                    $data["errormsg"] = "Username already exist! Please try again.";
                } else {
                    if( $this->user_model->create() != false ) {
                        $data["msg"] = "Successfully Saved";
                    } else {
                        $data["errormsg"] = "Something wrong in saving user, possible duplicated information.";
                    }
                }
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/users/adduser', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_user() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['user_types'] = $this->user_model->user_types();
        $data['user'] = $this->user_model->get_user_by_id($id);
        $data['companies'] = $this->setting_model->company_list();
        $data['courses'] = $this->courses_model->courses_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_user"]) ) {
                $this->form_validation->set_rules('firstname', 'First Name', 'required');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('usertype', 'Type of User', 'required');
                $this->form_validation->set_rules('bio', 'Bio', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->user_model->update_user();
                    $data['user'] = $this->user_model->get_user_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/users/edituser', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/users/edituser', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }

    public function delete_user() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $notes = $this->user_model->deleteuser($id);
        redirect( base_url('portal/users') );
    }
    /* END - Users */
    
    /* Courses */
    public function courses() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['courses'] = $this->courses_model->courses_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/courses/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_course() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_course"]) ) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('shortname', 'Abbreviation', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->courses_model->add_course();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/courses/addcourse', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_course() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_course"]) ) {
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('shortname', 'Abbreviation', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->courses_model->update_course();
                    $data['course'] = $this->courses_model->get_course_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/courses/editcourse', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['course'] = $this->courses_model->get_course_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/courses/editcourse', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }

    public function delete_course() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->courses_model->delete_course($id);
        redirect( base_url('portal/courses') );
    }
    
    /* END - Courses */
    
    
    /* Attendance */
    public function attendances() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['attendances'] = $this->attendance_model->attendances_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/attendance/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_attendance() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        if( isset($_POST["save_attendance"]) ) {
          
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('start_date_time', 'Start Date and Time', 'required');
            $this->form_validation->set_rules('end_date_time', 'End Date and Time', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->attendance_model->add_attendance();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/attendance/addattendance', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_attendance() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_attendance"]) ) {
                $this->form_validation->set_rules('user_id', 'User', 'required');
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
                $this->form_validation->set_rules('start_date_time', 'Start Date and Time', 'required');
                $this->form_validation->set_rules('end_date_time', 'End Date and Time', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->attendance_model->update_attendance();
                    $data['attendance'] = $this->attendance_model->get_attendance_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/attendance/editattendance', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['attendance'] = $this->attendance_model->get_attendance_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/attendance/editattendance', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    
    public function approve_attendance() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $res = $this->attendance_model->approve_attendance($id);
        redirect( base_url('portal/attendances') );
    }

    public function delete_attendance() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->attendance_model->delete_attendance($id);
        redirect( base_url('portal/attendances') );
    }
    
    /* END - Attendance */
    
    /* Activities */
    public function activities() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->get_students();
        $data['activities'] = $this->activities_model->activity_list();
        $data['rating_options'] = $this->setting_model->ratingoption_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/activities/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_activity() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->get_students();
        
        if( isset($_POST["save_activity"]) ) {
            
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('activity_date', 'Activity Date', 'required');
            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->activities_model->add_activity();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/activities/addactivity', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_activity() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->get_students();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_activity"]) ) {
                
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
                $this->form_validation->set_rules('activity_date', 'Activity Date', 'required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'required');
                $this->form_validation->set_rules('end_time', 'End Time', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->activities_model->update_activity();
                    $data['activity'] = $this->activities_model->get_activity_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/activities/editactivity', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['activity'] = $this->activities_model->get_activity_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/activities/editactivity', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }

    public function delete_activity() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->activities_model->delete_activity($id);
        redirect( base_url('portal/activities') );
    }
    /* END - Activites */
    
    /* SEttings */
    public function setting() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        
        if( isset( $_POST["update_setting"]) ) {
            /* Upload Image */
            $files = $this->input->post('images');
            foreach( $files as $key => $val ) {
                if( isset($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name']) ) {
                    $config['upload_path'] = './assets/uploads/setting';
                    $config['max_size'] = 2000;
                    
                    $this->load->library('upload', $config);
                    $this->upload->set_allowed_types('*');

                    if( !$this->upload->do_upload($key) ) {
                        $this->session->set_flashdata('error', 'There was some error during submission of a portfolio file!<br />'.$this->upload->display_errors());
                    } else {
                        $this->session->set_flashdata('upload_msg', 'Portfolio Successfully Submitted!');
                    }
                }
            }
            /* END - Upload Image */
                
            $this->setting_model->update_setting();
            $data['setting'] = $this->setting_model->setting_list();
            $this->load->view('includes/admin/header', $data);
            $this->load->view('includes/admin/nav', $data);
            $this->load->view('admin/setting/index', $data);
            $this->load->view('includes/admin/footer', $data);
        } else {
            $data['setting'] = $this->setting_model->setting_list();
            $this->load->view('includes/admin/header', $data);
            $this->load->view('includes/admin/nav', $data);
            $this->load->view('admin/setting/index', $data);
            $this->load->view('includes/admin/footer', $data);
        }
        
    }
    /* END - Settings */
    
    /* User Types */
    public function user_types() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['user_types'] = $this->setting_model->usertypes_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/user_types', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_usertype() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_usertype"]) ) {
            $this->form_validation->set_rules('usertype', 'User Type', 'required');
            $this->form_validation->set_rules('type_desc', 'Type Description', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->setting_model->add_usertype();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/addusertype', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_usertype() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_usertype"]) ) {
                $this->form_validation->set_rules('usertype', 'User Type', 'required');
                $this->form_validation->set_rules('type_desc', 'Type Description', 'required');
                
                if ($this->form_validation->run() === TRUE)
                {
                    $this->setting_model->update_usertype();
                    $data['ut'] = $this->setting_model->get_usertype_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/setting/editusertype', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['ut'] = $this->setting_model->get_usertype_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/setting/editusertype', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    public function delete_usertype() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_usertype($id);
        redirect( base_url('portal/user_types') );
    }
    /* END - User Types */
    
    /* User Types */
    public function rating_options() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['rating_options'] = $this->setting_model->ratingoption_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/rating_options', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    public function add_ratingoption() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_ratingoption"]) ) {
            $this->form_validation->set_rules('title', 'Title', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->setting_model->add_ratingoption();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/addratingoption', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_ratingoption() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_ratingoption"]) ) {
                $this->form_validation->set_rules('title', 'Title', 'required');
                
                if ($this->form_validation->run() === TRUE)
                {
                    $this->setting_model->update_ratingoption();
                    $data['ut'] = $this->setting_model->get_ratingoption_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/setting/editratingoption', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['ut'] = $this->setting_model->get_ratingoption_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/setting/editratingoption', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    public function delete_ratingoption() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_ratingoption($id);
        redirect( base_url('portal/rating_options') );
    }
    /* END - Rating Options */
    
    /* Activity Types */
    public function activity_types() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['activity_types'] = $this->setting_model->activitytypes_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/activity_types', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_activitytype() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_activitytype"]) ) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->setting_model->add_activitytype();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/setting/addactivitytype', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_activitytype() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_activitytype"]) ) {
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
                
                if ($this->form_validation->run() === TRUE)
                {
                    $this->setting_model->update_activitytype();
                    $data['at'] = $this->setting_model->get_activitytype_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/setting/editactivitytype', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['at'] = $this->setting_model->get_activitytype_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/setting/editactivitytype', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    public function delete_activitytype() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_activitytype($id);
        redirect( base_url('portal/activity_types') );
    }
    /* END - User Types */
    
    /* Companies */
    public function companies() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['companies'] = $this->setting_model->company_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/company/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_company() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['supervisors'] = $this->user_model->get_supervisors();
        if( isset($_POST["save_company"]) ) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('contact', 'Contact', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->setting_model->add_company();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/company/addcompany', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_company() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        $data['supervisors'] = $this->user_model->get_supervisors();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_company"]) ) {
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('contact', 'Contact', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                
                if ($this->form_validation->run() === TRUE)
                {
                    $this->setting_model->update_company();
                    $data['comp'] = $this->setting_model->get_company_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/company/editcompany', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['comp'] = $this->setting_model->get_company_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/company/editcompany', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }

    public function delete_company() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_company($id);
        redirect( base_url('portal/companies') );
    }
    
    /* END - Company */
    
    
    /* Announcements */
    
    public function announcements() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['announcements'] = $this->announcement_model->announcement_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/announcements/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_announcement() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_announcement"]) ) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->announcement_model->add_announcement();
                $data["msg"] = "Successfully Saved";
            }
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/announcements/addannouncement', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_announcement() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_announcement"]) ) {
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->announcement_model->update_announcement();
                    $data['announcement'] = $this->announcement_model->get_announcement_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/announcements/editannouncement', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['announcement'] = $this->announcement_model->get_announcement_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/announcements/editannouncement', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    
    public function delete_announcement() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->announcement_model->delete_announcement($id);
        redirect( base_url('portal/announcements') );
    }
    
    /* Feedbacks */
    
    public function seenFeedback() {
        $this->setting_model->seenFeedback($_POST["id"]);
    }
    
    /* Messages */
    public function sendMessageToAdmin() {
        $this->setting_model->seenMessageToAdmin($_POST["sid"], $_POST["content"]);
    }
    public function seenMessage() {
        $this->setting_model->seenMessage($_POST["id"]);
    }
    
    public function internship_plan() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['internship_plan'] = $this->setting_model->get_internship_plan();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/reports/internship_plan/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function add_internship_plan() {
        $this->is_logged_in();
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();
        if( isset($_POST["save_plan"]) ) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->setting_model->add_internship_plan();
                $data["msg"] = "Successfully Saved";
            }
        }
        
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/reports/internship_plan/add_plan', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function edit_internship_plan() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $data = array();
        $data["msg"] = "";
        $data["errormsg"] = "";
        $data["setting"] = $this->setting_model->setting_list();

        if (empty($id)) { 
            show_404();
        } else {
            if( isset( $_POST["update_internship_plan"]) ) {
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
            
                if ($this->form_validation->run() === TRUE)
                {
                    $this->setting_model->update_internship_plan();
                    $data['internship_plan'] = $this->setting_model->get_internship_plan_by_id($id);
                    $data["msg"] = "Successfully Updated";
                    $this->load->view('includes/admin/header', $data);
                    $this->load->view('includes/admin/nav', $data);
                    $this->load->view('admin/reports/internship_plan/edit_plan', $data);
                    $this->load->view('includes/admin/footer', $data);
                }
            } else {
                $data['internship_plan'] = $this->setting_model->get_internship_plan_by_id($id);
                $this->load->view('includes/admin/header', $data);
                $this->load->view('includes/admin/nav', $data);
                $this->load->view('admin/reports/internship_plan/edit_plan', $data);
                $this->load->view('includes/admin/footer', $data);
            }
        }
    }
    
    public function delete_internship_plan() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_internship_plan($id);
        redirect( base_url('portal/internship_plan') );
    }
    
    public function portfolio() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['portfolio'] = $this->user_model->get_all_portfolio();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/reports/portfolio/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function issues_concerns($type='', $start= '', $end = '') {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        if($type == 'supervisor') {
            $this->load->view('admin/reports/issues_concerns/supervisor', $data);
        } else if( $type == 'intern' ) {
            $this->load->view('admin/reports/issues_concerns/intern', $data);
        } else {
            $this->load->view('admin/reports/issues_concerns/index', $data);
        }
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function list_host_reports() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/reports/list_host_reports/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function daily_time_record() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $student_id = $this->input->post('student');
        if( isset($student_id) ) {
            $data['attendance'] = $this->attendance_model->dtr_lists($student_id);
        }
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/reports/daily_time_record/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function complaints() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['feedbacks'] = $this->setting_model->get_all_seen_feedbacks();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/feedbacks/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function delete_complaint() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_complaint($id);
        redirect( base_url('portal/complaints') );
    }
    
    public function messages() {
        $this->is_logged_in();
        $data = array();
        $data["setting"] = $this->setting_model->setting_list();
        $data['users'] = $this->user_model->users();
        $data['messages'] = $this->setting_model->get_all_seen_messages();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/messages/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
    
    public function delete_message() {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->setting_model->delete_message($id);
        redirect( base_url('portal/messages') );
    }
    
    public function updateactivityrating() {
        $this->activities_model->update_activity_rating($_POST["id"], $_POST["rating_id"], $_POST["user_id"]);
    }
    
    public function uploads() {
        $this->is_logged_in();
        $data = array();
        //$this->load->helper('general_helper');
        //$opts = initialize_elfinder();
        //$this->load->library('elfinder_lib', $opts);
        $data["setting"] = $this->setting_model->setting_list();
        $this->load->view('includes/admin/header', $data);
        $this->load->view('includes/admin/nav', $data);
        $this->load->view('admin/uploads/index', $data);
        $this->load->view('includes/admin/footer', $data);
    }
}
