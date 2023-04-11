<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		
		$this->load->view('header');
		$this->load->view('home/index');
		$this->load->view('footer');
	}

	public function newest_book(){
		$this->load->view('header');
		$this->load->view('home/newest_book');
		$this->load->view('footer');
	}
}
