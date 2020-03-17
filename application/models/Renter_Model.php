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
        
        $sql1="SELECT DISTINCT p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses FROM users u JOIN user_properties up ON u.user_id=$user_id JOIN properties p ON p.property_id=up.property_id";
        $result=$this->db->query($sql1);
        return $result->result_array();
    }
    public function get_tenants(){
        $sql2="SELECT u.user_id, u.first_name, u.last_name, u.phone, u.email, up.unit_id, p.address, p.city FROM users u
        INNER JOIN user_properties up ON u.user_id=up.user_id AND up.unit_id IS NOT NULL
        JOIN properties p USING (property_id)";
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
    public function get_finances(){
        $user=$this->session->userdata('username');
        $sql5="select user_id from users where username='$user'";
        $results=$this->db->query($sql5);
        $row=$results->row_array();
        $user_id=$row["user_id"];

        $sql="select p.property_id, sum(r.request_cost) as requests_cost, sum(p.rent_income) as rent_total, sum(p.upkeep_cost) as upkeep_total from requests r join user_properties up on up.user_id=$user_id join properties p on p.property_id=up.property_id group by p.property_id";
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
    public function getUnitsAndProperties(){
        $user_id=$this->session->userdata('user_id');
        
        $sql="
        SELECT p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses, un.unit_id, un.unit_num, un.rent FROM users u 
        JOIN user_properties up ON u.user_id=$user_id 
        JOIN properties p ON p.property_id=up.property_id
        JOIN units un ON un.property_id=up.property_id";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
    public function registerTenant(){
        $user_id=$this->session->userdata('user_id');
        $this->load->model('Authentication_Model');
        $user_id = $this->Authentication_Model->registerRentee();
        $unit_id = $this->input->post($this->input->post("unit_chosen"));
        $property_id = $this->input->post("property_id");
        $sql = "INSERT INTO user_properties(user_id, unit_id, property_id) VALUES('$user_id', '$unit_id', '$property_id')";
        $result=$this->db->query($sql);
        if ($result) {
            return 1;
        }
        else{
            return 0;
        }
    }
}
?>