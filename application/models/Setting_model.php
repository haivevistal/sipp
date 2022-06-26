<?php
class Setting_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function setting_list()
    {
        $query = $this->db->get("setting");
        return $query->result();
    }
    
    public function add_setting()
    {
        $data = array(
            'code'  => $this->input->post('code'),
            'value' => $this->input->post('value'),
            'setting_id' => $this->input->post('setting_id'),
            'by_who' => $this->input->post('by_who'),
            'data_type' => $this->input->post('data_type'),
            'date_added' => date("Y-m-d H:i:s"),
            'date_updated' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("setting", $data);
    }

    public function update_setting()
    {
        $setting = $this->input->post('setting');
        $images = $this->input->post('images');
        foreach($setting as $key => $val ) {
            $expl_field = explode("_", $key);
            $type = $expl_field[0];
            $code = $expl_field[1];
            
            $data = array(
                'code'  => $code,
                'value' => $val,
                'setting_id' => 1,
                'by_who' => $this->session->userdata('user_id'),
                'data_type' => $type,
                'date_updated' => date("Y-m-d H:i:s")
            );
            $this->db->where('code', $code);
            $this->db->update("setting", $data);
        }
        
        foreach($images as $key => $val ) {
            if( isset($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name']) ) {
                $data = array(
                    'code'  => $key,
                    'value' => $_FILES[$key]["name"],
                    'setting_id' => 1,
                    'by_who' => $this->session->userdata('user_id'),
                    'data_type' => 'image',
                    'date_updated' => date("Y-m-d H:i:s")
                );
                $this->db->where('code', $key);
                $this->db->update("setting", $data);
            }
        }
    }
    
    public function get_setting($code)
    {
        $query = $this->db->get_where("setting", array('code' => $code));
        return $query->row();
    }
    
    public function delete_setting($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("setting");
    }
    
    /* User Types */
    public function get_usertype_by_id($id)
    {
        $query = $this->db->get_where("user_types", array('id' => $id));
        return $query->row();
    }
    
    public function usertypes_list()
    {
        $query = $this->db->get("user_types");
        return $query->result();
    }
    
    public function add_usertype()
    {
        $data = array(
            'usertype'  => $this->input->post('usertype'),
            'type_desc' => $this->input->post('type_desc')
        );
        return $this->db->insert("user_types", $data);
    }
    
    public function update_usertype()
    {
        $id = $this->input->post('id');
        $data = array(
            'usertype'  => $this->input->post('usertype'),
            'type_desc' => $this->input->post('type_desc')
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("user_types", $data);
        }
    }
    
    public function delete_usertype($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("user_types");
    }
    /* END- User Types */
    
    /* Activity Types */
    public function activitytypes_list()
    {
        $query = $this->db->get("activity_types");
        return $query->result();
    }
    
    public function get_activitytype_by_id($id)
    {
        $query = $this->db->get_where("activity_types", array('id' => $id));
        return $query->row();
    }
    
    public function add_activitytype()
    {
        $data = array(
            'name'  => $this->input->post('name'),
            'description' => $this->input->post('description')
        );
        return $this->db->insert("activity_types", $data);
    }
    
    public function update_activitytype()
    {
        $id = $this->input->post('id');
        $data = array(
            'name'  => $this->input->post('name'),
            'description' => $this->input->post('description')
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("activity_types", $data);
        }
    }
    
    public function delete_activitytype($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("activity_types");
    }
    /* END - Activity Types */
    
    /* Companies */
    public function company_list()
    {
        $query = $this->db->get("companies");
        return $query->result();
    }
    
    public function get_company_by_id($id)
    {
        $query = $this->db->get_where("companies", array('id' => $id));
        return $query->row();
    }
    
    public function add_company()
    {
        $data = array(
            'name'  => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("companies", $data);
    }

    public function update_company()
    {
        $id = $this->input->post('id');
        $data = array(
            'name'  => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'contact' => $this->input->post('contact'),
            'save_date_time' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("companies", $data);
        }
    }
    
    public function delete_company($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("companies");
    }
    /* END- Companies */
    
    
    /* Feedbacks */
    public function get_all_feedbacks()
    {
        $this->db->where('seen', 0);
        $query = $this->db->get("feedback");
        return $query->result();
    }
    
    public function get_all_seen_feedbacks()
    {
        $this->db->where('seen', 1);
        $query = $this->db->get("feedback");
        return $query->result();
    }
    
    public function count_feedbacks()
    {
        $this->db->select('*');
        $this->db->from('feedback');
        $this->db->where('seen', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function seenFeedback($id) {
        $data = array('seen'  => 1);
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("feedback", $data);
        }
    }
    public function delete_complaint($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete("feedback");
    }
    
    /* Send message to admin */
    public function seenMessageToAdmin($sid, $content) {
        $data = array('supervisor_id' => $sid, 'content' => $content, 'date_save' => date("Y-m-d H:i:s") );
        return $this->db->insert("messages", $data);
    }
    
    public function count_messages()
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('seen', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function get_all_messages()
    {
        $this->db->where('seen', 0);
        $query = $this->db->get("messages");
        return $query->result();
    }
    
    public function seenMessage($id) {
        $data = array('seen'  => 1);
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("messages", $data);
        }
    }
    
    public function get_internship_plan()
    {
        $query = $this->db->get("internship_plan");
        return $query->result();
    }
    
    public function add_internship_plan()
    {
        $data = array(
            'title'  => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'date_save' => date("Y-m-d H:i:s")
        );
        return $this->db->insert("internship_plan", $data);
    }

    public function update_internship_plan()
    {
        $id = $this->input->post('id');
        $data = array(
            'title'  => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'date_save' => date("Y-m-d H:i:s")
        );
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update("internship_plan", $data);
        }
    }
    
    public function get_internship_plan_by_id($id)
    {
        $query = $this->db->get_where("internship_plan", array('id' => $id));
        return $query->row();
    }

}