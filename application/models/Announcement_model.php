<?php
class Announcement_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function public_announcement_list()
    {
        $this->db->like('start_date', date("Y-m-d") );
        $query = $this->db->get("announcements");
        return $query->result();
    }
    
    public function user_announcements()
    {
        $this->db->order_by('save_date', "desc");
        $query = $this->db->get("announcements");
        return $query->result();
    }
    
    public function announcement_list()
    {
        $this->db->order_by('save_date', "desc");
        $query = $this->db->get("announcements");
        return $query->result();
    }
    
    public function get_announcement_by_id($id)
    {
        $query = $this->db->get_where("announcements", array('id' => $id));
        /* SELECT * FROM announcements where 1=1 and */
        return $query->row();
    }
    
    public function add_announcement()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'added_by' => $this->session->userdata('user_id'),
            'save_date' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("announcements", $data);
    }

    public function update_announcement()
    {
        $id = $this->input->post('id');
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'save_date' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("announcements", $data);
        }
    }
    
    public function delete_announcement($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("announcements");
    }
    
     public function announcement_count()
    {
        $query = $this->db->get("announcements");
        return $query->num_rows();
    }

}