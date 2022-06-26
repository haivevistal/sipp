<?php
class User_model extends CI_Model {
  
    public function __construct()
    {
        $this->load->database();
    }
    
    public function users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }
    
    public function get_students()
    {
        $query = $this->db->get_where('users', array('usertype' => 4));
        return $query->result();
    }
    
    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }
    
    public function create()
    {
        $data = array(
            'firstname'  => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'bio' => $this->input->post('bio'),
            'gender' => $this->input->post('gender'),
            'usertype' => $this->input->post('usertype'),
            'course' => $this->input->post('course'),
            'total_hours' => $this->input->post('total_hours'),
            'remaining_hours' => $this->input->post('total_hours'),
            'company_id' => $this->input->post('company_id'),
            'start_ojt' => $this->input->post('start_ojt'),
            'end_ojt' => $this->input->post('end_ojt'),
            'password' => md5($this->input->post('password')),
            'date_saved' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        );
        if( $this->user_exist( $this->input->post('email'),$this->input->post('username'),$this->input->post('phone') ) ) {
            return $this->db->insert('users', $data);
        } else {
            return false;
        }
    }

    public function update_user()
    {
        $id = $this->input->post('id');
        $data = array(
            'firstname'  => $this->input->post('firstname'),
            'lastname'  => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'username' => $this->input->post('username'),
            'bio' => $this->input->post('bio'),
            'gender' => $this->input->post('gender'),
            'usertype' => $this->input->post('usertype'),
            'course' => $this->input->post('course'),
            'total_hours' => $this->input->post('total_hours'),
            'company_id' => $this->input->post('company_id'),
            'start_ojt' => $this->input->post('start_ojt'),
            'end_ojt' => $this->input->post('end_ojt'),
            'date_updated' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
    }
    
    public function update_profile_user()
    {
        $id = $this->session->userdata('user_id');
        $data = array(
            'firstname'  => $this->input->post('firstname'),
            'lastname'  => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'bio' => $this->input->post('bio'),
            'gender' => $this->input->post('gender'),
            'date_updated' => date("Y-m-d H:i:s")
        );
        if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $data['photo'] = $_FILES["photo"]["name"]; 
        }
        if( $this->input->post('password') ) {
            $data["password"] = md5($this->input->post('password'));
        }
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
    }
    
    public function deleteuser($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
    
    public function user_exist($email,$username,$phone)
    {
        $email = $this->input->post('user_email');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->or_where('username', $username);
        $this->db->or_where('phone', $phone);
        $query = $this->db->get();
        if( $query->num_rows() == 0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function user_types()
    {
        $query = $this->db->get('user_types');
        return $query->result();
    }
    
    public function loginuser() {
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
        $this->db->where('password',md5($pass) );
        $this->db->limit(1);
        
        if($query=$this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function login_admin_user() {
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
        $this->db->where('usertype',"1");
        $this->db->or_where('usertype', "2");
        $this->db->where('password',md5($pass) );
        $this->db->limit(1);
        
        if($query=$this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function get_user_info($email) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
        $this->db->limit(1);
        return $query->result_row();
    }
    
    public function get_user_portfolio() {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('portfolio');
        $this->db->where('user_id',$user_id);
        if($query=$this->db->get()) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function portfolio_exist($user_id)
    {
        $this->db->select('*');
        $this->db->from('portfolio');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if( $query->num_rows() == 0 ) {
            return false;
        } else {
            return true;
        }
    }
    
    public function import_portfolio() {
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'table_of_contents' => $this->input->post('table_of_contents'),
            'acknowledgement' => $this->input->post('acknowledgement'),
            'introduction' => $this->input->post('introduction'),
            'vmg' => $this->input->post('vmg'),
            'history' => $this->input->post('history'),
            'org_chart' => $this->input->post('org_chart'),
            'weekly_narrative_report' => '',
            'learnings' => $this->input->post('learnings'),
            'conclusion' => $this->input->post('conclusion'),
            'parent_consent' => $this->input->post('parent_consent'),
            'application_letter' => $this->input->post('application_letter'),
            'cor' => $this->input->post('cor'),
            'endorsement_letter' => $this->input->post('endorsement_letter'),
            'pictures' => '',
            'dtr' => '',
            'copy_moa' => $this->input->post('copy_moa'),
            'cert_ojt_completion' => $this->input->post('cert_ojt_completion'),
            'evaluation_sheet' => $this->input->post('evaluation_sheet'),
            'resume' => $this->input->post('resume'),
            'user_id' => $user_id,
            'pdf_link' => $user_id.'_portfolio.pdf',
            'date_save' => date("Y-m-d H:i:s")
        );
        
        if (isset($_FILES['attachement']) && is_uploaded_file($_FILES['attachement']['tmp_name'])) {
            $data['attachement'] = $_FILES["attachement"]["name"]; 
        }
        if( $this->portfolio_exist($user_id) ) {
            $this->db->where('user_id', $user_id);
            return $this->db->update('portfolio', $data);
        } else {
            return $this->db->insert('portfolio', $data);
        }
    }
    
    public function get_portfolio($user_id)
    {
        $query = $this->db->get_where('portfolio', array('user_id' => $user_id));
        return $query->row();
    }
    
    public function get_attendance_images($user_id) {
        $this->db->select('*');
        $this->db->from('attendances');
        $this->db->where('user_id',$user_id);
        return $query = $this->db->get()->result();
    }
    
    public function submit_feedback() {
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'title'  => $this->input->post('title'),
            'description'  => $this->input->post('description'),
            'user_id' => $user_id,
            'date_save' => date("Y-m-d H:i:s")
        );
        if (isset($_FILES['attachement']) && is_uploaded_file($_FILES['attachement']['tmp_name'])) {
            $data['attachement'] = $_FILES["attachement"]["name"]; 
        }
        return $this->db->insert('feedback', $data);
    }
    
    public function get_all_portfolio() {
        $this->db->select('*');
        $this->db->from('portfolio');
        if($query=$this->db->get()) {
            return $query->result();
        } else {
            return false;
        }
    }
}