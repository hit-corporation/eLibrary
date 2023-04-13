<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['member_model']);
	}

	public function index(){
		$this->load->view('header');
		$this->load->view('home/user_profile');
		$this->load->view('footer');
	}

}