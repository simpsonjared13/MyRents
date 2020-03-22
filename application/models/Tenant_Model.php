<?php
class Tenant_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function create_request(){
        $unit_id=$this->session->userdata['unit_id'];
        $request_type=$this->input->post("request_type");
        $comment=$this->input->post("comments");

        $sql="insert into requests (request_type, comments, unit_id) values ('$request_type', '$comment', '$unit_id')";
        $sql2="update units set request_active=1 where unit_id=$unit_id";
        if($this->db->query($sql) and $this->db->query($sql2)){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function tenant_get_requests(){
        $unit_id=$this->session->userdata['unit_id'];

        $sql="select request_type, comments, date_completed from requests where $unit_id=unit_id";
        $results=$this->db->query($sql);
        return $results->result_array();
    }
}
?>