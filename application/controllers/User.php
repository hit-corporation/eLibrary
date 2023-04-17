<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['member_model']);

		// form validation library
		$this->load->library('form_validation');

		// load session library
		$this->load->library('session');

		// check if user is logged in
		if (!$this->session->userdata('user')['is_logged_in']) {
			redirect('home');
		}
	}

	public function index(){
		$post = $this->input->post();

		if(isset($post['save_profile'])){
			// set validation rules
			$this->form_validation->set_rules('member_name', 'Nama Lengkap', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('no_induk', 'Nomor Induk', 'required');
			$this->form_validation->set_rules('card_number', 'Nomor Kartu', 'required');
			$this->form_validation->set_rules('kelas', 'Kelas', 'required');

			// validate form input
			if ($this->form_validation->run() == FALSE) {
				// validation fails
				$resp = ['success' => false, 'message' => 'Data gagal di simpan', 'old' => $post];
				$this->session->set_flashdata('error', $resp);
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				// validation succeeds
				$data = [
					'member_name' 	=> $post['member_name'],
					'username' 		=> $post['username'],
					'no_induk' 		=> $post['no_induk'],
					'card_number' 	=> $post['card_number'],
					'kelas' 		=> $post['kelas'],
					'email' 		=> $post['email'],
					'phone' 		=> $post['phone'],
					'address' 		=> $post['address'],
				];

				// update user data
				$update = $this->member_model->update($data, $post['id']);

				if($update){
					// update session data
					$this->session->set_userdata('user', [
						'user_name' => $post['username'],
						'full_name' => $post['member_name'],
						'email'		=> $post['email'],
						'role'		=> 'member',
						'is_logged_in' => true
					]);
				}

				// set success message
				$resp = ['success' => true, 'message' => 'Data berhasil disimpan.'];
				$this->session->set_flashdata('success', $resp);
				redirect($_SERVER['HTTP_REFERER']);
			}
			
		}

		// get user data
		$userId 		= $this->member_model->get_user_by_username($this->session->userdata('user')['user_name'])['id'];
		$data['user'] 	= $this->member_model->get_user($userId);


		$this->load->view('header');
		$this->load->view('home/user_profile', $data);
		$this->load->view('footer');
	}

	public function logout(){
		// remove session data
		$this->session->unset_userdata('user');

		// redirect to login page
		redirect('home');
	}

}
