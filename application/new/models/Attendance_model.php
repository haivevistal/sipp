<?php
class Attendance_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function public_attendances_list()
    {
        $this->db->like('start_date_time', date("Y-m-d") );
        $query = $this->db->get("attendances");
        return $query->result();
    }
    
    public function user_attendance()
    {
        $this->db->where('user_id', $this->session->userdata('user_id') );
        $query = $this->db->get("attendances");
        return $query->result();
    }
    
    public function attendances_list()
    {
        $this->db->select('users.firstname,users.lastname, attendances.*');
        $this->db->join('users', 'users.id = attendances.user_id');
        $query = $this->db->get("attendances");
        return $query->result();
    }
    
    public function get_attendance_by_id($id)
    {
        $query = $this->db->get_where("attendances", array('id' => $id));
        return $query->row();
    }
    
    public function add_attendance()
    {
        $data = array(
     
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date_time' => $this->input->post('start_date_time'),
            'end_date_time' => $this->input->post('start_date_time'),
            'company' => $this->input->post('company'),
            'save_date_time' => date("F d, Y h:i A")
        );
        return $this->db->insert("attendances", $data);
    }
    
    public function insert_attendance($data)
    {
        return $this->db->insert("attendances", $data);
    }

    public function update_attendance()
    {
        
        $data = array(

            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date_time' => $this->input->post('start_date_time'),
            'end_date_time' => $this->input->post('end_date_time'),
            'save_date_time' => date("F d, Y h:i A")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("attendances", $data);
        }
    }
    
    public function update_exist_attendance($id, $data)
    {
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("attendances", $data);
        }
    }
    
    public function approve_attendance($id)
    {
        $data = array( 'status' => 1, 'approve_date' => date("Y-m-d H:i:s") );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("attendances", $data);
        }
    }
    
    public function delete_attendance($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("attendances");
    }
    
    public function attendance_exist($user_id,$type,$date1, $date2)
    {
        $this->db->select('*');
        $this->db->from('attendances');
        $this->db->where('user_id', $user_id);
        $this->db->where('date_time >=', $date1);
        $this->db->where('date_time <=', $date2);
        $this->db->like('description', $type);
        
        $this->db->limit(1);
        $query = $this->db->get();
        
        if( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }
    }

}