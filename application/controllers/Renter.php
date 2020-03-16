<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Renter extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
	    parent::__construct();
	    $params = array('user_id' => null, 'first_name' =>null, 'last_name' =>null, 'username' =>null, 'email' =>null, 'phone' =>null,'unit_id' =>null,'password' =>null);

	    $this->load->library('User', $params);

	}
	public function index()
	{
		if($this->session->userdata('username') == null)
		{
			$this->load->view('templates/header');
			echo print_r($this->session->userdata());
			$this->load->view('login');
			$this->load->view('templates/footer');		}
		else{
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			$this->load->view('home');
			$this->load->view('templates/footer');
		}
	}
	public function login()
	{
		//temporary login on local host
		// $sql = "SELECT * FROM users";
		// $query = $this->db->query($sql);

		//future code for when on GCP
		// $conn = new mysqli('35.243.179.29', 'testing', 'zBflahjPMMKKIMBo', 'information_schema');
		// $sql = "SELECT * FROM information_schema";
		// $query = $conn->query($query);
		// if($query != false){
		// 	echo "worked";
		// }

		echo "<p>hello</p>";
		$params = array('user_id' => 123, 'first_name' =>"hared", 'last_name' =>"poo", 'username' =>"dude", 'email' =>null, 'phone' =>null,'unit_id' =>null,'password' =>null);
		$this->user->set_user_info($params);
		echo "<p>" .$this->user->get_first_name() . "</p>";
		
		// $current_user->load->view('templates/header');
		// echo print_r($this->session->userdata());

		// $this->load->view('login');
		// $this->load->view('templates/footer');
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("Renter/login");
	}

	public function doLogin(){
		$this->load->model('Authentication_Model');
		$result = $this->Authentication_Model->validateLogin();
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
		else{
			echo "Successful Login!";
			echo "<br><br>";
			redirect("Renter/home");
			echo print_r($this->session->userdata());
		}
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
	public function home()
	{

		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			//echo print_r($this->session->userdata());
			$data['properties']=$this->Renter_Model->get_properties();
			$data['tenants']=$this->Renter_Model->get_tenants();
			$data['requests']=$this->Renter_Model->get_requests();
			$data['finances']=$this->Renter_Model->get_finances();
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			$this->load->view('home', $data);
			$this->load->view('templates/footer');
		}
	}
	public function finances(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			$this->load->view('finances');
			$this->load->view('templates/footer');
		}
	}
	public function properties(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			$data['properties']=$this->Renter_Model->get_properties();
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			$this->load->view('properties', $data);
			$this->load->view('templates/footer');
		}
	}
	public function insert_property(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			$result = $this->Renter_Model->insert_property();
			if($result){
				redirect("Renter/properties");
			}
			else{
				echo "FAILED";
			}
		}
	}

	public function update_property(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			$result = $this->Renter_Model->update_property();
			redirect("Renter/properties");
		}
	}


	public function tenants(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
			$data['properties']=$this->Renter_Model->getUnitsAndProperties();
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			$this->load->view('tenants',$data);
			$this->load->view('templates/footer');
		}
	}
	public function registerTenant(){
		if($this->session->userdata('username') == null)
		{
			echo "You are not logged in, please go to the <a href='http://localhost/MyRents/Renter/login'>login page</a>";
		}
		else{
		// 	var_dump($this->input->post());
		// 	echo "<br><br>";
		// 	$unit_chosen = $this->input->post("unit_chosen");
		// 	echo $this->input->post($unit_chosen);
		// }
			$result = $this->Renter_Model->registerTenant();
			if($result == 1){
				$this->load->view('templates/header');
				$this->load->view('templates/nav');
				var_dump($this->input->post());
				$this->load->view('templates/footer');
			}
			else{
				$this->load->view('templates/header');
				$this->load->view('templates/nav');
				echo "error";
				$this->load->view('templates/footer');
			}
		}
	}
}