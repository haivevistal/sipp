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
            $data["incoming_activities"] = $this->activities_model->incoming_activities( $this->session->userdata('user_id') );
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
    public function timein() {
        if( $this->session->userdata('user_id') ) {
            $user_id = $this->session->userdata('user_id');
            $attendance_exist1 = $this->attendance_model->attendance_exist( $user_id, 1, "Login", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
            if( $attendance_exist1 ) {
                $attendance_exist2 = $this->attendance_model->attendance_exist( $user_id, 2, "Login", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
                if( !$attendance_exist2 ) {
                    $attendance_exist3 = $this->attendance_model->attendance_exist( $user_id, 1, "Logout", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
                    if( $attendance_exist3 ) {
                        $data = array(
                            'user_id'  => $user_id,
                            'count' => 2,
                            'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                            'description' => "Login",
                            'date_time' => date("Y-m-d H:i:s"),
                            'company' => $this->session->userdata('company_id'),
                            'save_date_time' => date("Y-m-d H:i:s"),
                            'status' => 1
                        );
                        $this->attendance_model->insert_attendance($data);
                    }
                }
            } else {
                $data = array(
                    'user_id'  => $user_id,
                    'count' => 1,
                    'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                    'description' => "Login",
                    'date_time' => date("Y-m-d H:i:s"),
                    'company' => $this->session->userdata('company_id'),
                    'save_date_time' => date("Y-m-d H:i:s"),
                    'status' => 1
                );
                $this->attendance_model->insert_attendance($data);
            }
            $this->session->set_userdata('timein_'.date("Y-m-d")."_".$user_id, 'y');
            redirect( base_url('/profile/attendance?msg=timein_success') );
        }
    }
    
    /* Time Out */
    public function timeout() {
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
                
            $attendance_exist1 = $this->attendance_model->attendance_exist( $user_id, 1, "Logout", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
            if( $attendance_exist1 ) {
                $attendance_exist2 = $this->attendance_model->attendance_exist( $user_id, 2, "Logout", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
                if( !$attendance_exist2 ) {
                    $attendance_exist3 = $this->attendance_model->attendance_exist( $user_id, 2, "Login", date("Y-m-d 00:00:01"), date("Y-m-d 23:59:59") );
                    if( $attendance_exist3 ) {
                        $data = array(
                            'user_id'  => $user_id,
                            'count' => 2,
                            'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                            'description' => "Logout",
                            'date_time' => date("Y-m-d H:i:s"),
                            'company' => $this->session->userdata('company_id'),
                            'image' => $_FILES["attachement"]["name"],
                            'save_date_time' => date("Y-m-d H:i:s"),
                            'status' => 1
                        );
                        $this->attendance_model->insert_attendance($data);
                    }
                }
            } else {
                $data = array(
                    'user_id'  => $user_id,
                    'count' => 1,
                    'title' => $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
                    'description' => "Logout",
                    'date_time' => date("Y-m-d H:i:s"),
                    'company' => $this->session->userdata('company_id'),
                    'image' => $_FILES["attachement"]["name"],
                    'save_date_time' => date("Y-m-d H:i:s"),
                    'status' => 1
                );
                $this->attendance_model->insert_attendance($data);
            }
            $this->session->unset_userdata('timein_'.date("Y-m-d")."_".$user_id, 'y');
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
        set_time_limit(0);
        error_reporting(E_ALL);
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data['user'] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $data["portfolio"] = $this->user_model->get_portfolio( $this->session->userdata('user_id') );
            $data["attendance"] = $this->attendance_model->user_attendance();
            $data["attendances"] = $this->attendance_model->dtr_lists( $this->session->userdata('user_id') );
            $data["activities"] = $this->activities_model->user_activities();
            
            $new_attendances = array();
            foreach($data["attendances"] as $atd) {
                $comp = $this->setting_model->get_company_by_id($atd->company);
                $new_attendances[date("Y_m_d", strtotime($atd->date_time) )."_".$atd->user_id][] = array(
                    'date' => date("F d, Y", strtotime($atd->date_time) ),
                    'info' => $atd->firstname." ".$atd->lastname,
                    'company' => $comp->name,
                    'time' => date("h:i A", strtotime($atd->date_time) ),
                    'duration' => strtotime($atd->date_time)
                );
            }
            
            $data_attendance = array();
            foreach($new_attendances as $atrd ) {
                $total = 0;
                $time1 = $atrd[0]["time"];
                $time2 = $atrd[1]["time"];
                $time3 = $atrd[2]["time"];
                $time4 = $atrd[3]["time"];
                $lasttime = '';
                if( isset($atrd[0]["duration"]) && isset($atrd[1]["duration"]) ) {
                    $duration1 = $atrd[0]["duration"];
                    $duration2 = $atrd[1]["duration"];
                    $total = $total + ( $duration2 - $duration1 );
                    $lasttime = $time2;
                }
                
                if( isset($atrd[2]["duration"]) && isset($atrd[3]["duration"]) ) {
                    $duration3 = $atrd[2]["duration"];
                    $duration4 = $atrd[3]["duration"];
                    $total = $total + ( $duration4 - $duration3 );
                    $lasttime = $time4;
                }
                
                $data_attendance[] = array( $atrd[0]["date"], $atrd[0]["info"], $atrd[0]["company"], ($time1 ." - ".$lasttime), number_format( ( $total / 60 ) / 60, 2) );
            }
            $data["myattendance"] = $data_attendance;
            
            $data_activities = array();
            foreach( $data["activities"] as $act ) {
                $data_activities[] = array( $act->title, $act->description, date('m/d/Y', strtotime($act->activity_date) ), date('H:i', strtotime($act->start_time) ),  date('H:i', strtotime($act->end_time) ) );
            }
            
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
                
                /* Create PDF */
                $file_name = $this->session->userdata('user_id');
                $pdf = new createPDF( 
                    array(
                        array($this->input->post('table_of_contents'), "Table Of Contents"),
                        array($this->input->post('acknowledgement'), "Acknowledgement"),
                        array($this->input->post('introduction'), "Introduction"),
                        array($this->input->post('vmg'), "VMG"),
                        array($this->input->post('history'), "History"),
                        array($this->input->post('org_chart'), "Organizational Chart"),
                        array($data_activities, "Weekly Narrative Report"),
                        array($this->input->post('learnings'), "Learnings"),
                        array($this->input->post('conclusion'), "Conclusion"),
                        array($this->input->post('parent_consent'), "Parent Consent"),
                        array($this->input->post('application_letter'), "Application Letter"),
                        array($this->input->post('cor'), "Certificate of Registration"),
                        array($this->input->post('endorsement_letter'), "Endorsement Letter"),
                        array($this->input->post('pictures'), "Pictures"),
                        array($data_attendance, "Daily Time Record"),
                        array($this->input->post('copy_moa'), "Copy Moa"),
                        array($this->input->post('cert_ojt_completion'), "Certificate Of OJT Completion"),
                        array($this->input->post('evaluation_sheet'), "Evaluation Sheet"),
                        array($this->input->post('resume'), "Resume")
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
            $this->activities_model->read_incoming_activity( $id, $user_id );
            
            redirect( base_url('profile') );
        }
    }
    
    /* Finish Activity */
    public function finish_activity() {
        if( $this->session->userdata('user_id') ) {
            if( isset( $_POST["done_activity_attachment"]) ) {
                $this->form_validation->set_rules('activity_id', 'Activity ID', 'required');

                /* Upload activity image */
                if( isset($_FILES['attachment']) && is_uploaded_file($_FILES['attachment']['tmp_name']) ) {
                    $config['upload_path'] = './assets/uploads/activities';
                    $config['max_size'] = 2000;
                    
                    $this->load->library('upload', $config);
                    $this->upload->set_allowed_types('*');

                    if( !$this->upload->do_upload('attachment') ) {
                        $this->session->set_flashdata('error', 'There was some error during submission of a activity picture!<br />'.$this->upload->display_errors());
                    } else {
                        $this->session->set_flashdata('upload_msg', 'Activity Picture Successfully Submitted!');
                    }
                }
                /* END - Upload activity image */
                
                $this->activities_model->finish_activity();
                redirect( $this->input->post('redirect_url') );
            }
        }
    }
    
    /* Reject Activity */
    public function reject_activity() {
        if( $this->session->userdata('user_id') ) {
            $id = $this->uri->segment(3);
            if (empty($id)) {
                show_404();
            }
           
            /* Finish Activity */
            $this->activities_model->reject_activity( $id );
            
            redirect( base_url('profile') );
        }
    }
    
    public function uploads() {
        $this->load->helper('directory');
        $data = array();
        if( $this->session->userdata('user_id') ) {
            $data["user"] = $this->user_model->get_user_by_id( $this->session->userdata('user_id') );
            $this->load->view('includes/front/header', $data);
            $this->load->view('includes/front/headernav', $data);
            $this->load->view('includes/front/nav', $data);
            $this->load->view('profile/uploads', $data);
            $this->load->view('includes/front/copyright', $data);
            $this->load->view('includes/front/footer', $data);
        } else {
            redirect( base_url('/?msg=logout') );
        }
    }
}
// End Class