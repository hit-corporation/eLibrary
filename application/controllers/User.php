<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['member_model', 'transaction_model']);

		// form validation library
		$this->load->library('form_validation');

		// load session library
		$this->load->library('session');

		// check if user is logged in
		if (empty($this->session->userdata('user')['user_name'])) {
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
				$resp = ['success' => false, 'message' => $this->form_validation->error_array(), 'old' => $post];
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
		$data['user'] 	= $this->member_model->get_user($_SESSION['user']['id']);

		$this->load->view('header');
		$this->load->view('home/user_profile', $data);
		$this->load->view('footer');
	}

	public function book_list() 
	{
		$data['user'] 	= $this->member_model->get_user($_SESSION['user']['id']);

		$this->load->view('header');
		$this->load->view('home/user_loan_list', $data);
		$this->load->view('footer');
	}

	/**
	 * Get all loaned books by users
	 *
	 * @return void
	 */
	public function get_user_loan(): void {

		$data = $this->transaction_model->get_user_borrowed_book($_SESSION['user']['id']);

		$userId 			= $_SESSION['user']['id'];
		$filter['sort_by'] 	= $this->input->get('sort_by');
		$filter['limit'] 	= $this->input->get('limit');
		$page 				= $this->input->get('page');
		$filter['offset'] 	= ($page - 1) * $filter['limit'];

		$data['books'] = $this->transaction_model->get_users_loan($userId, $filter);
		$data['total_records'] = $this->transaction_model->get_users_loan_count($userId);
		$data['total_pages'] = ceil($data['total_records'] / $filter['limit']);

		header('Content-Type: application/json');
		echo json_encode($data);

	}

	/**
	 * Member Password Change
	 *
	 * @return void
	 */
	public function change_password(){
		$post = $this->input->post();

		if(isset($post['change_password'])){
			// set validation rules
			$this->form_validation->set_rules('old_password', 'Password Lama', 'required|callback_check_password' , ['check_password' => 'Password lama tidak sesuai.'] );
			$this->form_validation->set_rules('new_password', 'Password Baru', 'required');
			$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

			// validate form input
			if($this->form_validation->run() == false){
				// validation fails
				$resp = ['success' => false, 'message' => $this->form_validation->error_array(), 'old' => $post];
				$this->session->set_flashdata('error', $resp);
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				// validation succeeds
				$data = [
					'password' => password_hash($post['new_password'], PASSWORD_DEFAULT)
				];

				// update user data
				$this->member_model->update($data, $post['id']);

				// set success message
				$resp = ['success' => true, 'message' => 'Password berhasil diubah.'];
				$this->session->set_flashdata('success', $resp);
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}



	/**
	 * ******************************************************************************
	 * 							LOGOUT
	 * ******************************************************************************
	 */

	public function logout(){
		$update = [
			'logout_time' => date('Y-m-d H:i:s.u'),
			'updated_at' => date('Y-m-d H:i:s.u')
		];
		$this->db->update('member_logs', $update, ['id' => $_SESSION['user']['log_id']]);
		// remove session data
		$this->session->unset_userdata('user');

		// redirect to login page
		redirect('home');
	}

	/**
	 * ******************************************************************************
	 * 							CUSTOM VALIDATION
	 * ******************************************************************************
	 */

		/**
		 * Custom Validation for user in validation
		*
		* @param mixed $str
		* @return boolean
		*/
	public function check_password($str): bool{
		$member = $this->member_model->get_user_by_username($this->session->userdata('user')['user_name']);

		if(isset($member) &&  password_verify($str, $member['password'])){
			return true;
		}else{
			return false;
		}
	}

	public function change_avatar(){
		$post = $this->input->post();

		// load file helper
		$this->load->helper('file');

		if(isset($post['change_avatar'])){
			// set validation rules
			if (empty($_FILES['avatar']['name'])){
				$this->form_validation->set_rules('avatar', 'Avatar', 'required');

				if($this->form_validation->run() == false){
					// validation fails
					$resp = ['success' => false, 'message' => $this->form_validation->error_array(), 'old' => $post];
					$this->session->set_flashdata('error', $resp);
					redirect($_SERVER['HTTP_REFERER']);
				}
			}

			// upload images
			$config['upload_path']          = './assets/landing-pages/images/avatar/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2048;
			$config['encrypt_name']         = true;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('avatar')){
				// upload fails
				$resp = ['success' => false, 'message' => $this->upload->display_errors()];
				$this->session->set_flashdata('error', $resp);
				redirect($_SERVER['HTTP_REFERER']);

			}else{

				// upload success
				$upload_data = $this->upload->data();

				// resize image
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/landing-pages/images/avatar/'.$upload_data['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['width']         = 300;
				$config['height']       = 300;

				$this->load->library('image_lib', $config);

				$this->image_lib->resize();

				
				// remove old image
				$old_image = $this->member_model->get_user($post['id'])['profile_img'];
				if($old_image != '' || $old_image != null){
					unlink('./assets/landing-pages/images/avatar/'.$old_image);
				}
				
				// update user data
				$data = [
					'profile_img' => $upload_data['file_name']
				];

				// update user data
				$this->member_model->update($data, $post['id']);

				

				// set success message
				$resp = ['success' => true, 'message' => 'Avatar berhasil diubah.'];
				$this->session->set_flashdata('success', $resp);
				redirect($_SERVER['HTTP_REFERER']);
			}
	
			
		}
	}

	public function user_favorite_list(){
		// get user data
		$userId 				= $this->member_model->get_user_by_username($this->session->userdata('user')['user_name'])['id'];
		$data['user'] 			= $this->member_model->get_user($userId);
		$data['favorite_books'] = $this->member_model->get_favorite_books($userId);

		$this->load->view('header');
		$this->load->view('home/user_favorite_list', $data);
		$this->load->view('footer');
	}

	public function delete_favorite_book(){
		$id = $_GET['id'];

		$this->member_model->delete_favorite_book($id);

		// set success message
		$resp = ['success' => true, 'message' => 'Buku berhasil dihapus dari daftar favorit.'];
		$this->session->set_flashdata('success', $resp);
		redirect($_SERVER['HTTP_REFERER']);
	}

}
