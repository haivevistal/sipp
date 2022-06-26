<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/controllers/Mypdf.php';

class Profile extends CI_Controller {

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
        $this->load->library("fpdf");
    }
  
    /* Profile Home */
    public function index() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["attendance"] = $this->attendance_model->user_attendance();
            $data["activities"] = $this->activities_model->user_activities();
            $data["announcements"] = $this->announcement_model->user_announcements();
            $data["incoming_activities"] = $this->activities_model->incoming_activities();
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    /* Time IN */
    public function timein($n = '') {
        if( $this->session->userdata('user_id') ) {
            $user_id = $this->session->userdata('user_id');
            $attendance_exist = $this->attendance_model->attendance_exist( $user_id, "Login", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
            if( $attendance_exist ) {
                $data = array(
                    'save_date_time' => date("Y-m-d H:i:s")
                );
                $this->attendance_model->update_exist_attendance($attendance_exist[0]['id'], $data);
            } else {
                $data = array(
                    'user_id'  => $user_id,
                    'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                    'description' => "Login",
                    'date_time' => date("Y-m-d H:i:s"),
                    'company' => $this->session->userdata('company_id'),
                    'save_date_time' => date("Y-m-d H:i:s")
                );
                $this->attendance_model->insert_attendance($data);
            }
            $this->session->set_userdata($n.'_'.date("Y-m-d")."_".$user_id, 'y');
            redirect( base_url('/profile/attendance?msg=timein_success') );
        }
    }
    
    /* Time Out */
    public function timeout($n = '') {
        if( $this->session->userdata('user_id') ) {
            $user_id = $this->session->userdata('user_id');
            
            
            /* Update attendance picture */
            if (isset($_FILES['attachement']) && is_uploaded_file($_FILES['attachement']['tmp_name'])) {
                $config['upload_path'] = './assets/uploads/attendance';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2000;
                $config['max_width'] = 1500;
                $config['max_height'] = 1500;
                
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('attachement')) {
                    $this->session->set_flashdata('error', 'There was some error during uploading a attendance picture!<br />'.$this->upload->display_errors());
                    
                } else {
                    $this->session->set_flashdata('upload_msg', 'Attendance Picture Successfully Updated!');
                }
            }
            /* END - Update attendance picture */
                
            $attendance_exist = $this->attendance_model->attendance_exist( $user_id, "Logout", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
            if( $attendance_exist ) {
                $data = array( 'save_date_time' => date("Y-m-d H:i:s") );
                $this->attendance_model->update_exist_attendance($attendance_exist[0]['id'], $data);
            } else {
                $data = array(
                    'user_id'  => $user_id,
                    'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                    'description' => "Logout",
                    'date_time' => date("Y-m-d H:i:s"),
                    'company' => $this->session->userdata('company_id'),
                    'image' => $_FILES["attachement"]["name"],
                    'save_date_time' => date("Y-m-d H:i:s")
                );
                $this->attendance_model->insert_attendance($data);
            }
            $this->session->set_userdata($n.'_'.date("Y-m-d")."_".$user_id, 'y');
            redirect( base_url('/profile/attendance?msg=timeout_success') );
        }
    }
    
    /* Update Profile */
    public function update() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data['user'] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            if( isset( $_POST["updateprofile"]) ) {
                $this->form_validation->set_rules('firstname', 'First Name', 'required');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('phone', 'Phone', 'required');
                $this->form_validation->set_rules('gender', 'Gender', 'required');
                $this->form_validation->set_rules('bio', 'Bio', 'required');
                
                /* Update profile picture */
                if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $config['upload_path'] = './assets/uploads/profile';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 2000;
                    $config['max_width'] = 1500;
                    $config['max_height'] = 1500;
                    
                    $this->load->library('upload', $config);
                    
                    if( $data['user']->photo != '' ) {
                        if( file_exists( FCPATH."/assets/uploads/profile/".$data['user']->photo) ) {
                            unlink( FCPATH."/assets/uploads/profile/".$data['user']->photo);
                        }
                    }
                    
                    if (!$this->upload->do_upload('photo')) {
                        $this->session->set_flashdata('error', 'There was some error during uploading a profile picture!<br />'.$this->upload->display_errors());
                        
                    } else {
                        $this->session->set_flashdata('upload_msg', 'Profile Picture Successfully Updated!');
                    }
                }
                /* END - Update profile picture */
                
                if( $this->user_model->update_profile_user() ) {
                    $this->session->set_flashdata('msg', 'Profile Successfully Updated!');
                }
                
                $this->session->set_userdata('firstname',$data["user"]->firstname);
                $this->session->set_userdata('lastname',$data["user"]->lastname);
                $this->session->set_userdata('gender',$data["user"]->gender);
                $this->session->set_userdata('phone',$data["user"]->phone);
                $this->session->set_userdata('email',$data["user"]->email);
                
                
            }
            $data['user'] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('profile/updateprofile', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    /* My Attendance */
    public function attendance() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["attendance"] = $this->attendance_model->user_attendance();
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('profile/attendance', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    /* My Activities */
    public function activities() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["activities"] = $this->activities_model->user_activities();
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('profile/activities', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    /* Add New Activity */
    public function add_activity() {
        $data = array();
        
        if( isset($_POST["add_activity"]) ) {
            $this->form_validation->set_rules('user_id', 'User', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('activity_date', 'Activity Date', 'required');
            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->activities_model->add_activity();
                $this->session->set_flashdata('msg', 'Successfully Saved!');
            }
        }
        $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
        $data['activity_types'] = $this->setting_model->activitytypes_list();
        $this->load->view('includes/front/header', $data);
        $this->load->view('includes/front/headernav', $data);
        $this->load->view('includes/front/nav', $data);
        $this->load->view('profile/addactivity', $data);
        $this->load->view('includes/front/copyright', $data);
        $this->load->view('includes/front/footer', $data);
    }
    
    /* Update Activity */
    public function edit_activity() {
        $data = array();
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('profile_image')) {
            $data["upload_error"] = $this->upload->display_errors();
            $this->session->set_flashdata('upload_error', $this->upload->display_errors() );
        } else {
            $data = array('image_metadata' => $this->upload->data());
            $data["image_metadata"] = $this->upload->data();
            $this->session->set_flashdata('image_metadata', $this->upload->data() );
        }
        
        if( isset($_POST["update_activity"]) ) {
            $this->form_validation->set_rules('user_id', 'User', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('activity_date', 'Activity Date', 'required');
            $this->form_validation->set_rules('start_time', 'Start Time', 'required');
            $this->form_validation->set_rules('end_time', 'End Time', 'required');
        
            if ($this->form_validation->run() === TRUE)
            {
                $this->activities_model->update_activity();
                $this->session->set_flashdata('msg', 'Successfully Updated!');
            }
        }
        $data["ac"] = $this->activities_model->get_activity_by_id($id);
        $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
        $data['activity_types'] = $this->setting_model->activitytypes_list();
        $this->load->view('includes/front/header', $data);
        $this->load->view('includes/front/headernav', $data);
        $this->load->view('includes/front/nav', $data);
        $this->load->view('profile/editactivity', $data);
        $this->load->view('includes/front/copyright', $data);
        $this->load->view('includes/front/footer', $data);
    }
    
    /* Delete Activity */
    public function delete_activity() {
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        
        $res = $this->activities_model->delete_activity($id);
        redirect( base_url('profile') );
    }
    
    /* Update Profile */
    public function submit_portfolio() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data['user'] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["portfolio"] = $this->user_model->get_portfolio( $this->session->userdata('user_id') );
            if( isset( $_POST["submit_portfolio"]) ) {
                /* Upload Portfolio File */
                if( isset($_FILES['attachement']) && is_uploaded_file($_FILES['attachement']['tmp_name']) ) {
                    $config['upload_path'] = './assets/uploads/portfolio';
                    $config['max_size'] = 2000;
                    
                    $this->load->library('upload', $config);
                    $this->upload->set_allowed_types('*');

                    if( !$this->upload->do_upload('attachement') ) {
                        $this->session->set_flashdata('error', 'There was some error during submission of a portfolio file!<br />'.$this->upload->display_errors());
                    } else {
                        $this->session->set_flashdata('upload_msg', 'Portfolio Successfully Submitted!');
                    }
                }
                /* END - Upload Portfolio File */
                
                $this->user_model->import_portfolio();
                //redirect( base_url('profile/submit_portfolio') );
            }
            
            if( isset( $_POST["generate_pdf"]) ) {
                $file_name = $this->session->userdata('firstname')."_".$this->session->userdata('lastname');
                $pdf = new createPDF( 
                    array(
                        array($this->input->post('table_of_contents'), "Table Of Contents"),
                        array($this->input->post('acknowledgement'), "Acknowledgement"),
                        array($this->input->post('introduction'), "Introduction"),
                        array($this->input->post('vmg'), "HTE/Company Profile - VMG"),
                        array($this->input->post('history'), "HTE/Company Profile - History"),
                        array($this->input->post('org_chart'), "HTE/Company Profile - Org. Chart"),
                        array($this->input->post('weekly_narrative_report'), "Weekly Narrative Report"),
                        array($this->input->post('learnings'), "Narrative Report - Learnings"),
                        array($this->input->post('conclusion'), "Narrative Report - Conclusion"),
                        array($this->input->post('parent_consent'), "Appendices - Parent Consent"),
                        array($this->input->post('application_letter'), "Appendices - Application Letter"),
                        array($this->input->post('cor'), "Appendices - Certificate of Registration"),
                        array($this->input->post('endorsement_letter'), "Appendices - Endorsement Letter"),
                        array($this->input->post('pictures'), "Appendices - Pictures"),
                        array($this->input->post('dtr'), "Appendices - Daily Time Record"),
                        array($this->input->post('copy_moa'), "Appendices - Copy Moa"),
                        array($this->input->post('cert_ojt_completion'), "Appendices - Certificate Of OJT Completion"),
                        array($this->input->post('evaluation_sheet'), "Appendices - Evaluation Sheet"),
                        array($this->input->post('resume'), "Appendices - Resume")
                    ),
                    $file_name 
                );
                $pdf->run();
                
            }
            $data["portfolio"] = $this->user_model->get_user_portfolio();
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('profile/submitportfolio', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    public function delete_portfolio() {
        $id = $this->uri->segment(3);
        if (empty($id)) {
            show_404();
        }
        $res = $this->user_model->delete_portfolio($id);
        redirect( base_url('profile/submit_portfolio') );
    }
    
    /* My Announcements */
    public function announcements() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["announcements"] = $this->announcement_model->user_announcements();
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('profile/announcements', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
    
    /* Update Profile */
    public function submit_feedback() {
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data['user'] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            if( isset( $_POST["submit_feeback"]) ) {
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('description', 'Description', 'required');
                
                /* Upload Portfolio File */
                if( isset($_FILES['attachement']) && is_uploaded_file($_FILES['attachement']['tmp_name']) ) {
                    $config['upload_path'] = './assets/uploads/feedback';
                    $config['max_size'] = 2000;
                    
                    $this->load->library('upload', $config);
                    $this->upload->set_allowed_types('*');

                    if( !$this->upload->do_upload('attachement') ) {
                        $this->session->set_flashdata('error', 'There was some error during submission of a feedback file!<br />'.$this->upload->display_errors());
                    } else {
                        $this->session->set_flashdata('upload_msg', 'Feedback Successfully Submitted!');
                    }
                }
                /* END - Upload Portfolio File */
                
                $this->user_model->submit_feedback();
                redirect( $this->input->post('redirect_url') );
            }
        }
    }
    
    /* Start Incoming Activity */
    public function start_incoming_activity() {
        if( $this->session->userdata('user_id') ) {
            $id = $this->uri->segment(3);
            $user_id = $this->session->userdata('user_id');
            if (empty($id)) {
                show_404();
            }
           
            /* Save to events */
            $this->activities_model->insert_activity_event( $id, $user_id );
            
            /* Create New Activity for User */
            $this->activities_model->new_activity_from_incoming( $id, $user_id );
            
            redirect( base_url('profile') );
        }
    }
    
    /* Finish Activity */
    public function finish_activity() {
        if( $this->session->userdata('user_id') ) {
            $id = $this->uri->segment(3);
            if (empty($id)) {
                show_404();
            }
           
            /* Finish Activity */
            $this->activities_model->finish_activity( $id );
            
            redirect( base_url('profile') );
        }
    }
}
// End Class