<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User{
	protected $user_id;
	protected $first_name;
	protected $last_name;
	protected $username;
	protected $email;
	protected $phone;
	protected $unit_id;
	protected $password;

	public function __construct($arr){
		$this->user_id = $arr['user_id'];
		$this->first_name = $arr['first_name'];
		$this->last_name = $arr['last_name'];
		$this->username =$arr['username'];
		$this->email = $arr['email'];
		$this->phone =$arr['phone'];
		$this->unit_id = $arr['unit_id'];
		$this->password = $arr['password'];
	}
	//Getters
	public function get_user_id(){
		return $this->user_id;
	}
	public function get_first_name(){
		return $this->first_name;
	}
	public function get_last_name(){
		return $this->last_name;
	}
	public function get_username(){
		return $this->username;
	}
	public function get_email(){
		return $this->email;
	}
	public function get_phone(){
		return $this->phone;
	}
	public function get_unit_id(){
		return $this->unit_id;
	}
	public function get_password(){
		return $this->password;
	}

	//Setters
	public function set_user_info($arr){
		$this->user_id = $arr['user_id'];
		$this->first_name = $arr['first_name'];
		$this->last_name = $arr['last_name'];
		$this->username =$arr['username'];
		$this->email = $arr['email'];
		$this->phone =$arr['phone'];
		$this->unit_id = $arr['unit_id'];
		$this->password = $arr['password'];
	}

}
?>