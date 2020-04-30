<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tenant extends CI_Controller {
	public function __construct(){
	    parent::__construct();
	    if($this->session->userdata('unit_id') == null)
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
			redirect("Tenant/home");
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("App/login");
	}
	public function home()
	{
		$this->load->model('Tenant_Model');
		$data['requests']=$this->Tenant_Model->tenant_get_requests();
		$data['payments']=$this->Tenant_Model->get_next_payment();
		$this->load->view('tenants/header');
		$this->load->view('tenants/nav');
		$this->load->view('tenants/home', $data);
		$this->load->view('tenants/footer');
	}
	public function create_request(){
		$this->load->model('Tenant_Model');
		$result = $this->Tenant_Model->create_request();
		if($result == 1){
			redirect('Tenant/home');
			}
		else{
			echo "FAILED";
		}	
	}
	public function payments(){
		$this->load->model('Tenant_Model');
		$data["payments"] = $this->Tenant_Model->get_payments();
		$this->load->view('tenants/header');
		$this->load->view('tenants/nav');
		$this->load->view('tenants/payments', $data);
		$this->load->view('tenants/footer');
	}
	public function payRent(){
		$this->load->model('Tenant_Model');
		$data["billing"] = $this->Tenant_Model->get_tenants_billing_address();
		$arr = array("payment_id" => $this->input->get("payment_id"), "rent" => $this->input->get("rent"), "due_date" => $this->input->get("due_date"));
		$data["payment"] = $arr;
		$this->load->view('tenants/header');
		$this->load->view('tenants/nav');
		$this->load->view('tenants/pay_rent', $data);
		$this->load->view('tenants/footer');
	}
	public function payRentFinalize(){
		$this->load->model('Tenant_Model');
		$result = $this->Tenant_Model->payRentFinalize();
		if($result){
			redirect("Tenant/payments");
		}
		else{
			echo "There was an error";
		}
	}
}
?>