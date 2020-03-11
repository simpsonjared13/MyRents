<?php
class Renter_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    public function get_properties(){
        $sql1="SELECT * from properties";
        $result=$this->db->query($sql1);
        return $result->result_array();
    }
    public function get_tenants(){
        $sql2="select users.user_id, users.first_name, users.last_name, users.phone, users.email from users inner join user_properties on users.user_id=user_properties.user_id";
        $results=$this->db->query($sql2);
        return $results->result_array();
    }
}
?>