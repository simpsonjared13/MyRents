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
	public function index()
	{
		$this->load->view('login');
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
		$this->load->view('templates/header');
		$this->load->view('login');
		$this->load->view('templates/footer');
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
		$this->load->view('templates/header');
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
		$this->load->view('HomePage');
	}
	public function finances(){
		$this->load->view('finances');
	}
}