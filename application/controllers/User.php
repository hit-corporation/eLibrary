<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['member_model']);

		// load session library
		$this->load->library('session');

		// check if user is logged in
		if (!$this->session->userdata('user')['is_logged_in']) {
			redirect('login');
		}
	}

	public function index(){
		// get user data
		$userId 		= $this->member_model->get_user_by_username($this->session->userdata('user')['user_name'])['id'];
		$data['user'] 	= $this->member_model->get_user($userId);


		$this->load->view('header');
		$this->load->view('home/user_profile', $data);
		$this->load->view('footer');
	}

}
