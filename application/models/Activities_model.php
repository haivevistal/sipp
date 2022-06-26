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
    
    public function incoming_activities()
    {
        $this->db->order_by('date_save', "desc");
        $this->db->join('activities', 'incoming_activities.iid = activities.incoming_id', "left");
        $this->db->where("activities.incoming_id IS NULL");
        $query = $this->db->get("incoming_activities");
        return $query->result();
    }
    
    public function get_incoming_activity_by_id($id) {
        $query = $this->db->get_where("incoming_activities", array('iid' => $id));
        return $query->row();
    }
    
    public function check_event_activity_exist($id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('activity_events');
        $this->db->where('id', $id);
        $this->db->or_where('user_id', $user_id);
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function insert_activity_event($id, $user_id)
    {
        if( !$this->check_event_activity_exist($id, $user_id) ) {
            $data = array(
                'user_id'  => $user_id,
                'activity_id ' => $id,
                'type' => 'incoming',
                'save_date' => date("Y-m-d H:i:s")
            );
            return $this->db->insert("activity_events", $data);
        }
    }
    
    public function check_incoming_activity_exist_in_user($id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('activities');
        $this->db->where('incoming_id', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function new_activity_from_incoming($id, $user_id)
    {
        if( !$this->check_incoming_activity_exist_in_user($id, $user_id) ) {
            $incoming_activity = $this->get_incoming_activity_by_id($id);
            $data = array(
                'user_id'  => $user_id,
                'incoming_id' => $id,
                'title' => $incoming_activity->ititle,
                'description' => $incoming_activity->idescription,
                'activity_type_id' => 4,
                'activity_date' => date("Y-m-d H:i:s"),
                'start_time' => date("H:i:s"),
                'end_time' => "",
                'save_date_time' => date("Y-m-d H:i:s")
            );
            return $this->db->insert("activities", $data);
        }
    }
    
    public function count_incoming_activities()
    {
        $this->db->join('activities', 'incoming_activities.iid = activities.incoming_id', "left");
        $this->db->where("activities.incoming_id IS NULL");
        $query = $this->db->get("incoming_activities");
        return $query->num_rows();
    }
    
    public function finish_activity($id) {
        $data = array(
            'end_time' => date("H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activities", $data);
        }
    }

}