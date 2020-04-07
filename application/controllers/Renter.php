<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Renter extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if($this->session->userdata('username') == null)
	    {
	    	echo "You are not logged in, please go to the <a href='http://localhost/MyRents/App/login'>login page</a>";
	    }
	}
	public function index()
	{
		if($this->session->userdata('username') == null)
		{
			redirect("App/login");
		}
		else{
			redirect("Renter/home");
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("App/login");
	}
	public function home()
	{
			//echo print_r($this->session->userdata());
		$data['properties']=$this->Renter_Model->get_properties();
		$data['tenants']=$this->Renter_Model->get_tenants();
		$data['requests']=$this->Renter_Model->get_requests();
		$data['finances']=$this->Renter_Model->get_homepage_finances();
		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('home', $data);
		$this->load->view('templates/footer');
	}
	public function finances(){
		$data['payments']=$this->Renter_Model->get_payments_by_year();
		$data['finances']=$this->Renter_Model->get_finances();

		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('finances', $data);
		$this->load->view('templates/footer');
	}
	public function properties(){
		$data['properties']=$this->Renter_Model->get_properties();
		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('properties', $data);
		$this->load->view('templates/footer');
	
	}
	public function units(){
		$data['properties']=$this->Renter_Model->get_properties();
		$data['units']=$this->Renter_Model->get_units();
		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('units', $data);
		$this->load->view('templates/footer');
	}
	public function insert_property(){
		$result = $this->Renter_Model->insert_property();
		if($result){
			redirect("Renter/properties");
		}
		else{
			echo "FAILED";
		}		
	}
	public function update_property(){
		$result = $this->Renter_Model->update_property();
		if($result == 1){
			redirect("Renter/properties");
		}
		else{
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			echo "error<br>";
			echo $result;
			$this->load->view('templates/footer');
		}	
	}
	public function tenants(){
		$data['properties']=$this->Renter_Model->getUnitsAndProperties();
		$data['tenants']=$this->Renter_Model->get_tenants();
		$this->load->view('templates/header');
		$this->load->view('templates/nav');
		$this->load->view('tenants',$data);
		$this->load->view('templates/footer');
	}
	public function registerTenant(){
		$result = $this->Renter_Model->registerTenant();
		if($result == 1){
			redirect("Renter/tenants");
		}
		else{
			$this->load->view('templates/header');
			$this->load->view('templates/nav');
			echo "error";
			$this->load->view('templates/footer');
		}
	}
	public function complete_request(){
		$result = $this->Renter_Model->complete_request();
		if($result == 1){
			redirect('Renter/home');
			}
		else{
			echo "FAILED";
		}
	}
	public function update_unit(){
		$result = $this->Renter_Model->update_unit();
		if($result == 1){
			redirect('Renter/units');
			}
		else{
			echo "FAILED";
		}
	}
	public function removeTenant(){
		$result = $this->Renter_Model->removeTenant();
		if($result == 1){
			redirect('Renter/tenants');
			}
		else{
			echo "FAILED";
		}
	}
}