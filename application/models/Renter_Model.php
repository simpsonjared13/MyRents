<?php
class Renter_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    public function get_properties(){
        $user=$this->session->userdata('username');
        $sql5="select user_id from users where username='$user'";
        $results=$this->db->query($sql5);
        $row=$results->row_array();
        $user_id=$row["user_id"];

        $sql6="select property_id from user_properties where user_id='$user_id'";
        $results=$this->db->query($sql6);
        $results_list=$results->result_array();
        $property_array= array();
        foreach($results_list as $row){
            array_push($property_array, $row['property_id']);
        }

        $sql1="SELECT * from properties where property_id in $property_array";
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