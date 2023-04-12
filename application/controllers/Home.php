<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index(){
		$data['newBooks'] 		= $this->home_model->get_new_books();
		$data['popularBooks'] 	= $this->home_model->get_popular_books();
		$data['recomendBooks'] 	= $this->home_model->get_recomend_books();
		
		$this->load->view('header');
		$this->load->view('home/index', $data);
		$this->load->view('footer');
	}

	public function list_book(){
		if(isset($_GET['name']) && $_GET['name'] == 'newest'){
			$data['books'] = $this->home_model->get_new_books();
			$data['title'] = 'Newest Books';
		} elseif (isset($_GET['name']) && $_GET['name'] == 'popular'){
			$data['books'] = $this->home_model->get_popular_books();
			$data['title'] = 'Popular Books';
		} else {
			$data['books'] = $this->home_model->get_recomend_books();
			$data['title'] = 'Recomended Books';
		}
			

		$this->load->view('header');
		$this->load->view('home/list_book', $data);
		$this->load->view('footer');
	}

	public function book_detail(){
		$id = $_GET['id'];

		if (isset($id)) {
			$this->load->model('home_model');
			$data['book'] = $this->home_model->get_book_by_id($id);
		}

		$this->load->view('header');
		$this->load->view('home/book_detail', $data);
		$this->load->view('footer');
	}

	public function login(){
		if(isset($post['submit'])) {
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

			$user = $this->user_model->login($data);

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

	public function user_favorite_list(){
		$this->load->view('header');
		$this->load->view('home/user_favorite_list');
		$this->load->view('footer');
	}
}
