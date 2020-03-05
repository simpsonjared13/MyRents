
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
                    'userid' => $row->id,
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
        $user_data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'password' => $this->input->post('password'),
            'confirm_password' => $this->input->post('confirm_password') );
        return $user_data;

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