<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['member_model']);
	}
	
	public function index(){
		if(isset($post['submit'])) {
			var_dump($post);die;
			$data = [
				'user_name' => $post['userName']
			];

			$this->form_validation->set_rules('username', 'Username', 'required|callback_is_exists', [
				'is_exists' => 'Username tidak di kenali !!!'
			]);

			$this->form_validation->set_rules('password', 'Password', 'required');


			if(!$this->form_validation->run()) 
			{
				$this->session->set_flashdata('error', ['errors' => $this->form_validation->error_array(),'old' => $_POST]);
				redirect('login');
			}

			$user = $this->member_model->login($data);

			

			if(!password_verify($post['password'], $user['user_pass']))
			{
				$this->session->set_flashdata('error', ['message' => 'Username atau password tidak valid','old' => $_POST]);
				redirect('login');
			}

			unset($user['user_pass']);
			$this->session->set_userdata('user', $user);
			redirect('dashboard');
		}

		$this->load->view('header');
		$this->load->view('home/user_profile');
		$this->load->view('footer');
	}

	public function profile(){
		$this->load->view('header');
		$this->load->view('home/user_profile');
		$this->load->view('footer');
	}

}
