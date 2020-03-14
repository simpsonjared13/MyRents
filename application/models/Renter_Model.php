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
        
        $sql1="select p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses FROM users u join user_properties up on u.user_id=$user_id join properties p on p.property_id=up.property_id";
        $result=$this->db->query($sql1);
        return $result->result_array();
    }
    public function get_tenants(){
        $sql2="SELECT users.user_id, users.first_name, users.last_name, users.phone, users.email FROM users INNER JOIN user_properties ON users.user_id=user_properties.user_id";
        $results=$this->db->query($sql2);
        return $results->result_array();
    }
    public function get_requests(){
        $user=$this->session->userdata('username');
        $sql5="select user_id from users where username='$user'";
        $results=$this->db->query($sql5);
        $row=$results->row_array();
        $user_id=$row["user_id"];
        
        $sql="select r.request_id, r.unit_id, r.request_type, r.comments FROM requests r join user_properties up on up.user_id=$user_id join properties p on p.property_id=up.property_id";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
    public function insert_property(){
        $address=$this->input->post("address");
        $city=$this->input->post("city");
        $state=$this->input->post("state");
        $country=$this->input->post("country");
        $zip=$this->input->post("zip");
        $num_units=$this->input->post("num_units");
        $user_id = $this->session->userdata('user_id');

        $sql="INSERT INTO properties(address, city, state, country, zip, num_units) VALUES('$address', '$city', '$state', '$country', '$zip', '$num_units')";
        $this->db->query($sql);
        $property_id = $this->db->insert_id();

        $sql = "INSERT INTO user_properties(user_id, property_id) VALUES('$user_id','$property_id')";
        $result = $this->db->query($sql);
        if($result){
           //$unit_ids = array();
           for ($i=1; $i <= $num_units ; $i++) {
               $unit_num = $this->input->post("unit_num_".$i); $rent = $this->input->post("rent_".$i);
               $sql = "INSERT INTO units(property_id,unit_num,rent) VALUES('$property_id', '$unit_num', '$rent')";
               $result = $this->db->query($sql);
               if($result){
                   //array_push($unit_ids, $this->db->insert_id());
               }
               else{
                   return 0;
               }
           } 
        }
        else{
            return 0;
        }

        
        // foreach ($unit_ids as $key => $value) {
            
        // }
        return 1;
    }
    public function update_property(){
        $property_id=$this->input->post("property_select");        
        if($address=$this->input->post("new_address")){
            $sql="update properties set address='$address' where property_id=$property_id";
            if($this->db->query($sql)){
                //echo "success";
            }
        }
        if($city=$this->input->post("new_city")){
            $sql="update properties set city='$city' where property_id=$property_id";
            if($this->db->query($sql)){
                //echo "success";
            }
        }
        if($state=$this->input->post("new_state")){
            $sql="update properties set state='$state' where property_id=$property_id";
            if($this->db->query($sql)){
                //echo "success";
            }
        }
        if($zip=$this->input->post("new_zip")){
            $sql="update properties set zip='$zip' where property_id=$property_id";
            if($this->db->query($sql)){
                //echo "success";
            }
        }            
    }
}
?>