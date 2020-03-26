<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	   	if($this->session->userdata('user_id') != null){
	   		if($this->session->userdata('unit_id') != null){
	   			redirect("Tenant/home");
	   		}
	   		else{
	   			redirect("Renter/home");
	   		}
	   	}
	}
	public function index()
	{
		redirect("App/login");
	}
	public function register()
	{
		$this->load->view('templates/header');
		$this->load->view('register');
		$this->load->view('templates/footer');
	}
	public function registerRenter()
	{
		$this->load->model('Authentication_Model');
		$result = $this->Authentication_Model->registerRenter();
		$this->load->view('templates/header_redirect');
		if ($result == "XSS Attack") {
			echo "XSS Attack";
		}
		else if($result == "passwords error"){
			echo "Passwords do not match";
			//sleep(2);
			//redirect("MyRents/Renter/register");
		}
		else{
			echo "Successful Registration!";
		}

		$this->load->view('templates/footer');
	}
	public function login()
	{	
		$this->load->view('templates/header');
		$this->load->view('login');
		$this->load->view('templates/footer');
	}
	public function doLogin(){
		$this->load->model('Authentication_Model');
		$result = $this->validateLogin();
		if ($result == "XSS Attack") {
			echo "XSS Attack";
		}
		else if($result == "Bad Password"){
			echo "Wrong Password";
		}
		else if($result == "No Password"){
			echo "Wrong Password";
		}
		else if($result == "No User"){
			echo "Wrong Password";
		}
		else if($result == "Tenant"){
			redirect("Tenant/home");
		}
		else{
			redirect("Renter/home");
		}
	}
	private function validateLogin(){
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

}

?>