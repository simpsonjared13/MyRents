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
        
        $sql1="SELECT DISTINCT p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses, p.num_units, p.upkeep_cost FROM users u JOIN user_properties up ON u.user_id=$user_id JOIN properties p ON p.property_id=up.property_id";
        $result=$this->db->query($sql1);
        return $result->result_array();
    }
    public function get_tenants(){
        $sql2="SELECT u.user_id, u.first_name, u.last_name, u.phone, u.email, up.unit_id, p.address, p.city, up.property_id FROM users u
        INNER JOIN user_properties up ON u.user_id=up.user_id AND up.unit_id IS NOT NULL
        JOIN properties p USING (property_id)";
        $results=$this->db->query($sql2);
        return $results->result_array();
    }
    public function get_requests(){
        $user=$this->session->userdata('username');
        $sql5="select distinct user_id from users where username='$user'";
        $results=$this->db->query($sql5);
        $row=$results->row_array();
        $user_id=$row["user_id"];
        
        $sql="select distinct r.request_id, r.unit_id, r.request_type, r.comments, r.date_completed FROM requests r join user_properties up on up.user_id=$user_id join properties p on p.property_id=up.property_id and r.date_completed is null";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
    public function get_homepage_finances(){
        $user_id=$this->session->userdata('user_id');

        $sql="SELECT p.property_id, sum(r.request_cost) as requests_cost, sum(p.rent_income) as rent_total, sum(p.upkeep_cost) as upkeep_total from requests r join user_properties up on up.user_id=$user_id join properties p on p.property_id=up.property_id group by p.property_id";
        $result=$this->db->query($sql);
        return $result->result_array();
    }
    public function get_finances(){
        $user_id=$this->session->userdata('user_id');

        $sql="SELECT p.upkeep_cost, p.rent_income, p.recurring_expenses, p.address, p.city FROM properties p
        JOIN user_properties up ON up.property_id=p.property_id
        WHERE up.user_id='$user_id'";
        $result=$this->db->query($sql);
        return $result;
    }

    public function get_payments(){
        $user_id=$this->session->userdata('user_id');
        $units = "SELECT u.unit_id FROM units u
            JOIN user_properties up ON up.property_id=u.property_id AND up.user_id = '$user_id'";
        $units=$this->db->query($units);

        if($units->num_rows() > 0){
            $unit_str = "";
            foreach ($units->result() as $row) {
                $unit_str .= $row->unit_id . ",";
            }
            $unit_str = substr($unit_str, 0, -1);

            $sql="SELECT pm.amount_paid, pm.date_paid, u.first_name, u.last_name, p.address, p.city, ut.unit_num FROM payments pm
                JOIN user_properties up ON up.user_id=pm.user_id AND up.unit_id IN ($unit_str)
                JOIN users u ON up.user_id=u.user_id AND u.user_id !='$user_id' AND up.unit_id IN ($unit_str)
                JOIN properties p ON up.property_id=p.property_id AND u.user_id !='$user_id' AND up.unit_id IN ($unit_str)
                JOIN units ut ON up.unit_id=ut.unit_id
                ORDER BY pm.date_paid, u.last_name DESC";
            $result=$this->db->query($sql);
        }
        else{
            $sql="SELECT pm.amount_paid, pm.date_paid, u.first_name, u.last_name, p.address, p.city, ut.unit_num FROM payments pm
                JOIN user_properties up ON up.user_id=pm.user_id
                JOIN users u ON up.user_id=u.user_id AND u.user_id !='$user_id'
                JOIN properties p ON up.property_id=p.property_id AND u.user_id !='$user_id'
                JOIN units ut ON up.unit_id=ut.unit_id
                ORDER BY pm.date_paid, u.last_name DESC";
            $result=$this->db->query($sql);
        }
        
        return $result;
    }
    public function get_units(){
        $user_id=$this->session->userdata('user_id');
        $sql="SELECT DISTINCT un.unit_id, un.property_id, un.unit_num, un.rent, un.request_active FROM users u JOIN user_properties up ON u.user_id=$user_id JOIN units un ON un.property_id=up.property_id;";
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
        $date = new DateTime($this->input->post("date"));
        $date= $date->format("Y-m-d h:m:s");  


        $sql="INSERT INTO properties(address, city, state, country, zip, num_units, date) VALUES('$address', '$city', '$state', '$country', '$zip', '$num_units', '$date')";
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
        $update_string = "";
        foreach ($this->input->post() as $key => $value) {
            if($value != "" && $key != "property_select" && $key != "submit"){
                $update_string .= $key. " = '".$value."', ";
            }
        }
        $update_string = substr($update_string, 0, -2);
        $sql = "UPDATE properties SET $update_string WHERE property_id='$property_id'";
        //return $sql;
        $result = $this->db->query($sql);
        if($result){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function getUnitsAndProperties(){
        $user_id=$this->session->userdata('user_id');

        //Get the already Occupied Units
        $sql="SELECT unit_id FROM user_properties WHERE unit_id IS NOT NULL";
        $occupied_units = $this->db->query($sql);
        $unit_str = "";
        //Checks that a unit is occupied
        if($occupied_units->num_rows() > 0){
            //Create a string that can be used for the IN part of the sql query below
            foreach ($occupied_units->result() as $unit) {
                $unit_str .= $unit->unit_id . ",";
            }
            //Take out the final comma
            $unit_str = substr($unit_str, 0, -1);
            //Select all the available properties and units
            $sql="
            SELECT DISTINCT p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses, un.unit_id, un.unit_num, un.rent, up.user_id FROM users u 
            JOIN user_properties up ON u.user_id=$user_id
            JOIN properties p ON p.property_id=up.property_id
            JOIN units un ON un.property_id=up.property_id AND up.unit_id IS NULL AND un.unit_id NOT IN ($unit_str)";
            $result=$this->db->query($sql);
            //Return the result
            return $result->result_array();
        }
        //If no units are occupied
        else{
            //Select all the properties and units
            $sql="
            SELECT DISTINCT p.property_id, p.address, p.city, p.state, p.zip, p.country, p.rent_income, p.recurring_expenses, un.unit_id, un.unit_num, un.rent, up.user_id FROM users u 
            JOIN user_properties up ON u.user_id=$user_id
            JOIN properties p ON p.property_id=up.property_id
            JOIN units un ON un.property_id=up.property_id AND up.unit_id IS NULL AND un.unit_id";
            $result=$this->db->query($sql);
            //Return the result
            return $result->result_array();
        }
    }
    public function registerTenant(){
        $user_id=$this->session->userdata('user_id');
        $this->load->model('Authentication_Model');
        $user_id = $this->Authentication_Model->registerRentee();
        $unit_id = $this->input->post($this->input->post("unit_chosen"));
        $property_id = $this->input->post("property_id");
        $sql="SELECT p.rent_income, un.rent FROM user_properties up
        JOIN properties p ON p.property_id=up.property_id AND p.property_id='$property_id'
        JOIN units un ON un.property_id=p.property_id AND un.unit_id='$unit_id'";
        $property = $this->db->query($sql);
        $unit_rent = $property->row()->rent;
        $property_rental_income = $property->row()->rent_income;

        //Setting the due date to the first of this month
        //Edit line below to set when tenant moved in
        $dueDate = new DateTime("2010-1-1");

        // $duteDate = $dueDate->modify("-3 years");
        $duteDate = $dueDate->modify($dueDate->format("Y-m"));
        $dueDate = $dueDate->format("Y-m-d h:m:s");

        $sql = "INSERT INTO payments(user_id, unit_id, amount_paid, date_paid) VALUES('$user_id', '$unit_id', '0', '$dueDate')";
        $result=$this->db->query($sql);

        //Create relation between user, property, and unit
        $sql = "INSERT INTO user_properties(user_id, unit_id, property_id) VALUES('$user_id', '$unit_id', '$property_id')";
        $result=$this->db->query($sql);
        if ($result) {
            if($property_rental_income === null or $property_rental_income == 0){
                $sql = "UPDATE properties SET rent_income = '$unit_rent' WHERE property_id = '$property_id'";
                $this->db->query($sql);
                return 1;
            }
            else{
                $sql = "UPDATE properties SET rent_income = rent_income + '$unit_rent' WHERE property_id = '$property_id'";
                $this->db->query($sql);
                return 1;
            }
        }
        else{
            return 0;
        }
    }
    public function complete_request(){
        $request_id=$this->input->post('request_select');
        $request_cost=$this->input->post('request_cost');
        $sql="select unit_id from requests where request_id='$request_id'";
        $results=$this->db->query($sql);
        $row=$results->row_array();
        $unit_id=$row["unit_id"];
        $timestamp=@date('Y-m-d H:i:s');
        $sql2="update requests set request_cost=$request_cost, date_completed='$timestamp' where request_id='$request_id'";
        $sql3="update units set request_active=0 where unit_id='$unit_id'";
        if($this->db->query($sql2)){
            if($this->db->query($sql3)){
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
    public function update_unit(){
        $unit_id=$this->input->post('unit_id');
        $rent=$this->input->post('rent');
        $sql="update units set rent=$rent where unit_id='$unit_id'";
        if($this->db->query($sql)){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function removeTenant(){
        $user_id=$this->input->post('user_id');
        $unit_id=$this->input->post('unit_id');
        $property_id=$this->input->post('property_id');
        $sql="DELETE FROM user_properties WHERE user_id='$user_id' AND  unit_id='$unit_id' AND property_id='$property_id'";
        $this->db->query($sql);
        $rent="SELECT rent FROM units WHERE unit_id='$unit_id'";
        $rent=$this->db->query($rent);
        $rent=$rent->row()->rent;
        $sql="UPDATE properties SET rent_income = rent_income - '$rent'";
        if($this->db->query($sql)){
            return 1;
        }
        else{
            return 0;
        }
    }
}
?>