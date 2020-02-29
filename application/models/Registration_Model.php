
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registration_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    public function validate(){
        // grab user input
        
        $username = $this->input->post('user');
        if(!$this->security->xss_clean($username, TRUE)){
            $username = NULL;
        }
        $password = $this->input->post('pass');
        if(!$this->security->xss_clean($password, TRUE)){
            $password = NULL;
        }else{
            //hash password for verification??
            $password = hash('sha256', $password);
        }
        
        // Prep the query
        //$this->db->where('username', $username);
        //$this->db->where('hashpass', $password);
        $data = array('username'=>$username, 'hashpass'=>$password);
        // Run the query
        $query = $this->db->get_where('users', $data);
        // Let's check if there are any results
        if($query->num_rows() > 0)
        {
            // If there is a user, then create session data
            $row = $query->row();
            
            $sql = $this->db->get_where('halls', array('hallid'=>$row->hall));
            $hall = $sql->row();
            
            $data = array(
                    'user_id' => $row->id,
                    'fist_name' => $row->fname,
                    'last_name' => $row->lname,
                    'username' => $row->username,


                    );
            $this->session->set_userdata($data);
            return 1;
        }else{
            return 0;
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


    
    public function register(){
        // grab user input
        
        $username = $this->input->post('user');
        if(!$this->security->xss_clean($username, TRUE)){
            $username = NULL;
        }
        
        //confirm password
        $password = $this->input->post('pass');
        $confirm = $this->input->post('cpass');
        if($password != $confirm){
            return 1;
        }
        
        //hash password for storage
        if(!$this->security->xss_clean($password, TRUE)){
            $password = NULL;
            return 3;
        }else{
            $password = hash('sha256', $password);
        }
        
        
        $query = $this->db->get_where('users', array('username'=>$username));
        
        if($query->num_rows() > 0){
            return 2;
        }else{
            //get the necessary data from auth table to insert into reslife_portal db
            // i already set up the auth credentials in database.php
            
            $this->db->insert('users', $data);
        }
    }
}
?>