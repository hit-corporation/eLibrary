<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}

	public function index(){
		$data['newBooks'] = $this->home_model->get_new_books();
		
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
		$this->load->view('header');
		$this->load->view('home/book_detail');
		$this->load->view('footer');
	}
}
