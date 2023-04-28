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
			$this->form_validation->set_rules('password', 'Password', 'required|callback_valid_password', [
				'valid_password' => 'Password tidak sama'
			]);

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

			

			$return = ['success' => true, 'message' =>  'Data Berhasil Di Simpan'];
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
	public function valid_password($str): bool {
		$members = $this->member_model->login($str);
		if(isset($membes['username']) && password_verify($str, $members['password']))
			return false;
		return true;
	}
}
