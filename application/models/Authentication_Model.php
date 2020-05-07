
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authentication_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    public function validateLogin(){
        $users = array(
            'user_id' => null,
            'first_name' => null,
            'last_name' => null,
            'username' => $this->input->post('username'),
            'email' => null,
            'phone' => null,
            "unit_id" => null,
            'password' => $this->input->post('password')
             );
        foreach ($users as $key => $value) {
            if(!$this->security->xss_clean($value, TRUE)){
                return "XSS Attack";
            }
        }
        $sql1 = "SELECT * FROM users WHERE username = '" . $users["username"] . "'";
        $result1 = $this->db->query($sql1);
        if($result1){
            $row1 = $result1->row();
            $sql2 = "SELECT hash FROM enpu WHERE user_id = '" . $row1->user_id . "'";
            $result2 = $this->db->query($sql2);
            if($result2){
                $hash = $result2->row()->hash;
                if(password_verify($users['password'], $hash)){
                    $users['user_id'] = $row1->user_id;
                    $users['first_name'] = $row1->first_name;
                    $users['last_name'] = $row1->last_name;
                    $users['email'] = $row1->email;
                    $users['phone'] = $row1->phone;
                    array_pop($users);
                    $sql3 = "SELECT unit_id FROM user_properties WHERE user_id = '" . $row1->user_id . "'";
                    $result3 = $this->db->query($sql3);
                    if($result3->row()->unit_id != null){
                        $users['unit_id'] = $result3->row()->unit_id;
                        $this->session->set_userdata($users);
                        return "Tenant";
                    }
                    else{
                        $this->session->set_userdata($users);
                        return "Renter";
                    }
                }
                else{
                    return "Bad Password";
                }
            }
            else{
                return "No Password";
            }
        }
        else{
            return "No User";
        }
    }
    public function registerRenter(){
        $users = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'password' => $this->input->post('password'),
            'confirm_password' => $this->input->post('confirm_password')
             );
        foreach ($users as $key => $value) {
            if(!$this->security->xss_clean($value, TRUE)){
                return "XSS Attack";
            }
        }
        if($users['password'] != $users['confirm_password']){
            return "passwords error";
        }
        $hash = password_hash($users['password'], PASSWORD_DEFAULT);

        array_pop($users);array_pop($users);

        // unset($users['password']);reset($users);
        // unset($users['confirm_password']);reset($users);
        $query = $this->db->insert('users', $users);
        if($query){
            $sql = "SELECT user_id FROM users WHERE username = '" . $users["username"] . "' AND email = '". $users["email"] . "'";
            $query = $this->db->query($sql);
            if($query != null){
                $row = $query->row();
                $enpu = array("user_id" => $row->user_id, "hash" => $hash);
                $query = $this->db->insert('enpu', $enpu);
            }
            else{
                return 0;
            }
            return 1;
        }
        else{
            return 0;
        }
        //return $users;

    }
    public function registerRentee(){
        $date = new DateTime($this->input->post("date"));
        $date= $date->format("Y-m-d h:m:s");
        $user_info = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'date' => $date,
            'password' => "123"//Temporary!
            //'password' => ""//Official
            );
        foreach ($user_info as $key => $value) {
            if(!$this->security->xss_clean($value, TRUE)){
                return "XSS Attack";
            }
        }
        //Temporpary!
        // $data = $user_info['first_name'] .$user_info['last_name'].'1234567890!@#$%^&*'.$user_info['email'];
        // $pass = substr(str_shuffle($data), 0, 7);
        $hash = password_hash($user_info['password'], PASSWORD_DEFAULT);
        array_pop($user_info);
        $query = $this->db->insert('users', $user_info);
        if($query){
            $user_id = $this->db->insert_id();
            $enpu = array("user_id" => $user_id, "hash" => $hash);
            $query = $this->db->insert('enpu', $enpu);
            return $user_id;
        }
        else{
            return 0;
        }
        
    }
}
?>