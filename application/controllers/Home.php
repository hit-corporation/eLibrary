<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['home_model','member_model', 'book_model']);
	}

	public function index(){
		$data['newBooks'] 		= $this->home_model->get_new_books();
		$data['popularBooks'] 	= $this->home_model->get_popular_books();
		$data['recomendBooks'] 	= $this->home_model->get_recomend_books();

		$i = 0;
		foreach ($data['newBooks'] as $key => $val) {
			$data['newBooks'][$i]['rating'] = $this->book_model->rating($val['id'])['rating'];
			$data['newBooks'][$i]['total_read'] = $this->book_model->total_read($val['id']);
			$i++;
		}

		$i = 0;
		foreach ($data['popularBooks'] as $key => $val) {
			$data['popularBooks'][$i]['rating'] = $this->book_model->rating($val['id'])['rating'];
			$data['popularBooks'][$i]['total_read'] = $this->book_model->total_read($val['id']);
			$i++;
		}
		
		$this->load->view('header');
		$this->load->view('home/index', $data);
		$this->load->view('footer');
	}

	public function book_detail(){
		$id = $_GET['id'];

		if (isset($id)) {
			$this->load->model('home_model');
			$data['book'] = $this->home_model->get_book_by_id($id);
		}

		$user = $this->session->userdata('user');
		$user_id = isset($user['id']) ? $user['id'] : NULL;

		if(isset($user_id)){
			// get transaction book	
			$data['transaction'] = $this->book_model->get_transaction_book($id, $user_id);
		}

		// get favorite book
		$data['favorite'] = $this->book_model->get_favorite_book($id, $user_id);

		$this->load->view('header');
		$this->load->view('home/book_detail', $data);
		$this->load->view('footer');
	}

	

	/**
	 * User login
	 *
	 * @return void
	 */
	public function login(): void
	{
		$this->load->library('form_validation');
		try
		{
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);

			$this->form_validation->set_rules('username', 'Usernmae', 'required|callback_is_exists', [
				'is_exists'	=> 'ID Pengguna tidak di temukan'
			]);

			$this->form_validation->set_rules('password', 'Password', 'required', [
				'required'	=> 'Password tidak boleh kosong'
			]);

			// check password
			$checkPassword = $this->valid_password($username, $password);
			if(!$checkPassword){
				$return = ['success' => false, 'errors' => ['password' => 'Username atau Password yang anda masukan salah'], 'old' => $_POST];
				$this->session->set_flashdata('error', $return);
				redirect($_SERVER['HTTP_REFERER']);
			}

			if(!$this->form_validation->run())
			{
				$return = ['success' => false, 'errors' => $this->form_validation->error_array(), 'old' => $_POST];
				$this->session->set_flashdata('error', $return);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$members = $this->member_model->login($username);

			$insert = [
				'fullname'		=> $members['member_name'],
				'username'		=> $members['username'],
				'email'			=> $members['email'],
				'login_time'	=> date('Y-m-d H:i:s.u'),
				'ip_address'	=> $_SERVER['REMOTE_ADDR']
			];

			$this->db->insert('member_logs', $insert);
			$_logId = $this->db->insert_id();

			$_SESSION['user'] = [
				'id'		=> $members['id'],
				'user_name'	=> $members['username'],
				'full_name'	=> $members['member_name'],
				'email'		=> $members['email'],
				'role'		=> 'member',
				'log_id'	=> $_logId,
				'is_logged_in'	=> TRUE
			];

			

			$return = ['success' => true, 'message' =>  'Login berhasil'];
			$this->session->set_flashdata('success', $return);
			redirect('/');
		}
		catch(Exception $e)
		{
			log_message('error', $e->__toString());
		}
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
	 public function is_exists($str): bool {
		$members = $this->member_model->login($str);
		if(!isset($members['username']))
			return false;
		return true;
	}

	/**
	 * Custom valiation for check password
	 *
	 * @return boolean
	 */
	public function valid_password($username, $password): bool {
		$members = $this->member_model->login($username);
		if(isset($members['username']) && password_verify($password, $members['password']))
			return true;
		return false;
	}
}
