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
    public function insert_property(){
        $address=$this->input->post("address");
        $city=$this->input->post("city");
        $state=$this->input->post("state");
        $country=$this->input->post("country");
        $zip=$this->input->post("zip");
        $num_units=$this->input->post("num_units");

        $sql3="insert into properties(address, city, state, country, zip, num_units) values('$address', '$city', '$state', '$country', '$zip', '$num_units')";
        $this->db->query($sql3);
    }
}
?>