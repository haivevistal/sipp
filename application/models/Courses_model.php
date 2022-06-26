<?php
class Courses_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function courses_list()
    {
        $query = $this->db->get("courses");
        return $query->result();
    }
    
    public function get_course_by_id($id)
    {
        $query = $this->db->get_where("courses", array('id' => $id));
        return $query->row();
    }
    
    public function add_course()
    {
        $data = array(
            'name'  => $this->input->post('name'),
            'shortname' => $this->input->post('shortname'),
            'description' => $this->input->post('description'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("courses", $data);
    }

    public function update_course()
    {
        $id = $this->input->post('id');
        $data = array(
            'name'  => $this->input->post('name'),
            'shortname' => $this->input->post('shortname'),
            'description' => $this->input->post('description'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("courses", $data);
        }
    }
    
    public function delete_course($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("courses");
    }
    

}