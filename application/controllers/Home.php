<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index(){
		$data['newBooks'] = $this->home_model->get_new_books();
		$data['popularBooks'] = $this->home_model->get_popular_books();
		
		$this->load->view('header');
		$this->load->view('home/index', $data);
		$this->load->view('footer');
	}

	public function newest_book(){
		$this->load->view('header');
		$this->load->view('home/newest_book');
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
}
