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
        //p.amount_paid, p.date_paid
        $currentDateTime = new DateTime();
        $currentDateTime->modify($currentDateTime->format("Y-m"));
        $currentDateTime->modify("-1 day");

        $currentDateTime = $currentDateTime->format("Y-m-d h:m:s");

        $rentDue = new DateTime();
        $rentDue->modify("+1 month");
        $rentDue->modify($rentDue->format("Y-m"));
        $rentDue = $rentDue->format("Y-m-d h:m:s");
        $sql = "SELECT p.amount_paid, p.date_paid, u.rent, p.payment_id FROM payments p
        JOIN user_properties up ON p.user_id=up.user_id AND p.user_id='$user_id'
        JOIN units u ON u.unit_id=up.unit_id AND p.date_paid < '$rentDue' AND p.date_paid >= '$currentDateTime'";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function get_payments(){
        $user_id = $this->session->userdata['user_id'];
        //p.amount_paid, p.date_paid
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
        JOIN units u ON u.unit_id=up.unit_id";
        $result = $this->db->query($sql);
        return $result;
    }
}
?>