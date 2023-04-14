<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Book extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['home_model', 'publisher_model', 'kategori_model']);
	}

	public function index(){
		// $page = $this->input->post('page');
		// $page = $page ? $page : 1;
		// $limit = 5;
		// $limit_start = ($page - 1) * $limit;
		// // $no = $limit_start + 1;

		// $data['books'] 	= $this->home_model->get_books($limit, $limit_start);

		// $data['total_records'] = $this->home_model->get_total_books();

		// $data['newBooks'] 	= $this->home_model->get_new_books();

		$data['publishers'] = $this->publisher_model->get_all();
		$data['categories'] = $this->kategori_model->get_all();

		$this->load->view('header');
		$this->load->view('book/list_book', $data);
		$this->load->view('footer');
	}

	public function get_all(){
		$page 			= isset($_GET['page']) ? $_GET['page'] : 1;
		$limit 			= isset($_GET['limit']) ? $_GET['limit'] : 3;
		$title 			= isset($_GET['title']) ? $_GET['title'] : '';
		$publisher_id 	= isset($_GET['publisher_id']) ? $_GET['publisher_id'] : '';
		$author 		= isset($_GET['author']) ? $_GET['author'] : '';
		$categori_ids 	= isset($_GET['category_ids']) ? ($_GET['category_ids']) : '';
		$year 			= isset($_GET['year']) ? $_GET['year'] : '';

		$page = ($page - 1) * $limit;

		$data['books'] 	= $this->home_model->get_books($limit, $page, $title, $publisher_id, $author, $categori_ids, $year);
		$data['total_records'] = $this->home_model->get_total_books();
		$data['total_pages'] = ceil($data['total_records'] / $limit);
		
		// create json header	
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	/**
	 * Read a Book
	 *
	 * @return void
	 */
	public function read_book(): void {
		$id = $this->input->get('id');

		$this->load->view('book/read', );
	}

}
