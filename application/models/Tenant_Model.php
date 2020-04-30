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

    public function get_next_payment(){
        $user_id = $this->session->userdata['user_id'];
        // $currentDateTime = new DateTime();
        // $currentDateTime->modify($currentDateTime->format("Y-m"));
        // $currentDateTime->modify("-1 day");

        // $currentDateTime = $currentDateTime->format("Y-m-d h:m:s");

        // $rentDue = new DateTime();
        // $rentDue->modify("+1 month");
        // $rentDue->modify($rentDue->format("Y-m"));
        // $rentDue = $rentDue->format("Y-m-d h:m:s");
        $sql = "SELECT p.amount_paid, p.date_paid, u.rent, p.payment_id FROM payments p
        JOIN user_properties up ON p.user_id=up.user_id AND p.user_id='$user_id'
        JOIN units u ON u.unit_id=up.unit_id";// AND p.date_paid < '$rentDue' AND p.date_paid >= '$currentDateTime'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function get_payments(){
        $user_id = $this->session->userdata['user_id'];

        $sql = "SELECT p.amount_paid, p.date_paid, u.rent, p.payment_id FROM payments p
        JOIN user_properties up ON p.user_id=up.user_id AND p.user_id='$user_id'
        JOIN units u ON u.unit_id=up.unit_id";
        $result = $this->db->query($sql);
        return $result;
    }
    public function get_tenants_billing_address(){
        $user_id = $this->session->userdata['user_id'];
        $sql = "SELECT p.address, p.city, p.state, p.country, p.zip FROM properties p
        JOIN user_properties up ON p.property_id = up.property_id AND up.user_id='$user_id'";
        $result = $this->db->query($sql);
        return $result->row();
    }
    public function payRentFinalize(){
        $user_id = $this->session->userdata['user_id'];
        $rent = $this->input->post("rent");
        $dueDate = new DateTime($this->input->post("due_date"));
        $dueDate = $dueDate->format("Y-m-d h:m:s");
        $unit_id = $this->session->userdata['unit_id'];

        $sql = "INSERT INTO payments(user_id, unit_id, amount_paid, date_paid) VALUES('$user_id', 'unit_id', '$rent','$dueDate')";
        $result = $this->db->query($sql);
        return $result;
    }
}
?>