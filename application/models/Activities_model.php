<?php
class Activities_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function public_activity_list()
    {
        $this->db->order_by('save_date_time', "desc");
        $this->db->like('start_date_time', date("Y-m-d") );
        $query = $this->db->get("activities");
        return $query->result();
    }
    
    public function user_activities()
    {
        $this->db->order_by('save_date_time', "desc");
        $this->db->where('user_id', $this->session->userdata('user_id') );
        $this->db->where('activity_status != 1');
        $query = $this->db->get("activities");
        return $query->result();
    }
    
    public function activity_list()
    {
        $this->db->order_by('save_date_time', "desc");
        $this->db->select('users.firstname,users.lastname, activities.*');
        $this->db->join('users', 'users.id = activities.user_id');
        $query = $this->db->get("activities");
        return $query->result();
    }
    
    public function get_activity_by_id($id)
    {
        $this->db->order_by('save_date_time', "desc");
        $query = $this->db->get_where("activities", array('id' => $id));
        return $query->row();
    }
    
    public function add_activity()
    {
        $data = array(
            'user_id'  => $this->input->post('user_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'activity_type_id' => $this->input->post('activity_type_id'),
            'activity_date' => $this->input->post('activity_date'),
            'start_time' => $this->input->post('start_time'),
            'activity_status' => 1,
            'end_time' => $this->input->post('end_time'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("activities", $data);
    }

    public function update_activity()
    {
        $id = $this->input->post('id');
        $data = array(
            'user_id'  => $this->input->post('user_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'activity_type_id' => $this->input->post('activity_type_id'),
            'activity_date' => $this->input->post('activity_date'),
            'start_time' => $this->input->post('start_time'),
            'activity_status' => 1,
            'end_time' => $this->input->post('end_time'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }
    
    public function delete_activity($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("activities");
    }
    
    public function incoming_activities($user_id)
    {
        $this->db->order_by('save_date_time', "desc");
        $this->db->where("activity_status", 1);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get("activities");
        return $query->result();
    }
    
    public function get_incoming_activity_by_id($id) {
        $query = $this->db->get_where("activities", array('id' => $id, "activity_status" => 1));
        return $query->row();
    }
    
    public function read_incoming_activity($id, $user_id)
    {
        $data = array( 'activity_status'  => 2, 'user_id' => $user_id );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }
    
    public function check_incoming_activity_exist_in_user($id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('activities');
        $this->db->where('activity_status', 1);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function count_incoming_activities($user_id)
    {
        $this->db->where("activity_status", 1);
        $this->db->where("user_id", $user_id);
        $query = $this->db->get("activities");
        return $query->num_rows();
    }
    
    public function finish_activity() {
        $id = $this->input->post('activity_id');
        $image = $_FILES['attachment']['name'];
        $data = array(
            'end_time' => date("H:i:s"),
            'activity_status' => 3,
            'attachment' => $image
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }
    
    public function reject_activity($id) {
        $data = array(
            'end_time' => "00:00:00",
            'activity_status' => 4
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }
    
    public function update_activity_rating($id, $rating_id, $user_id)
    {
        $data = array( 'user_id'  => $user_id, 'rating' => $rating_id );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }

}