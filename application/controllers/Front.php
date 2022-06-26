<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('attendance_model');
        $this->load->model('activities_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    
    public function index() {
        $this->load->view('includes/front/header.php');
        $this->load->view('includes/front/nav.php');
        $this->load->view('home');
        $this->load->view('includes/front/copyright.php');
        $this->load->view('includes/front/footer.php');
        
    }
    
    public function register_user() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
    
        if ($this->form_validation->run() === TRUE)
        {
            $this->user_model->create();
            redirect( base_url('/') );
        }
    }
    
    public function login() {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        
        if ($this->form_validation->run() === TRUE)
        {
            $login = $this->user_model->loginuser();
            if( $login != false ) {
                $this->session->set_userdata('user_id',$login[0]['id']);
                $this->session->set_userdata('firstname',$login[0]['firstname']);
                $this->session->set_userdata('lastname',$login[0]['lastname']);
                $this->session->set_userdata('gender',$login[0]['gender']);
                $this->session->set_userdata('phone',$login[0]['phone']);
                $this->session->set_userdata('email',$login[0]['email']);
                $this->session->set_userdata('username',$login[0]['username']);
                $this->session->set_userdata('usertype',$login[0]['usertype']);
                $this->session->set_userdata('company_id',$login[0]['company_id']);
                
                redirect( base_url('/profile?msg=success') );
                
            } else {
                $this->session->set_flashdata('error_msg', 'Wrong email or password, please try again.');
                redirect( base_url('/?msg=error') );
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Error occured, please try again.');
            redirect( base_url('/?msg=error') );
        }
    }
    
    public function user_logout(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('firstname');
        $this->session->unset_userdata('lastname');
        $this->session->unset_userdata('gender');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('usertype');
        $this->session->unset_userdata('company_id');
        redirect( base_url('/?msg=logout_success') );
    }
    
    public function public_attendance() {
        $data["attendance"] = $this->attendance_model->public_attendances_list();
        $this->load->view('includes/front/header.php');
        $this->load->view('includes/front/nav.php');
        $this->load->view('public_attendance', $data);
        $this->load->view('includes/front/copyright.php');
        $this->load->view('includes/front/footer.php');
    }
    
    public function public_activities() {
        $data["activities"] = $this->activities_model->public_activity_list();
        $this->load->view('includes/front/header.php');
        $this->load->view('includes/front/nav.php');
        $this->load->view('public_activities', $data);
        $this->load->view('includes/front/copyright.php');
        $this->load->view('includes/front/footer.php');
    }
}
