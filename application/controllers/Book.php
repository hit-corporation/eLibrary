<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Book extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['home_model', 'publisher_model', 'kategori_model', 'book_model']);
	}

	public function index(){
		$data['viewGroup'] = $_GET['viewGroup'];
		$data['viewStyle'] = $_GET['viewStyle'];

		$data['publishers'] = $this->publisher_model->get_all();
		$data['categories'] = $this->kategori_model->get_all();

		$this->load->view('header');
		$this->load->view('book/list_book', $data);
		$this->load->view('footer');
	}

	public function get_all(){
		$view_group 	= $_GET['view_group'];
		$page 			= isset($_GET['page']) ? $_GET['page'] : 1;
		$limit 			= isset($_GET['limit']) ? $_GET['limit'] : 3;
		$sort_by 		= isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';

		$filter = $_GET['filter'];


		$page = ($page - 1) * $limit;

		$data['books'] 	= $this->home_model->get_books($view_group, $limit, $page, $filter, $sort_by);
		$data['total_records'] = $this->home_model->get_total_books($view_group, $filter);
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

		// if(!isset($_SESSION['user']) && empty($_SESSION['user']['username']))
		// {
		// 	$data['heading'] = 'PERINGATAN';
		// 	$data['message'] = '<p>Halaman hanya di peruntukan untuk anggota aktif. Silahkan login terlebih dahulu !!!'.
		// 					   '<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
		// 	$this->load->view('errors/html/error_general', $data);
		// 	return;
		// }
		
		$cookie = ['e_key' => base64_encode('localhost'), 'time' => date('Y-m-d H:i:s')];
		$cookie_option = [
			'expires'	=> strtotime('+'.$this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit']),
			'path'		=> '/book/read_book',
			'samesite'	=> 'Lax'
		];

		setcookie('read_book', implode(', ', $cookie), $cookie_option);

		print_r($_COOKIE);

		
		$data['book'] = $this->book_model->get_one($id);
		$data['setting'] = $this->settings;
		$this->load->view('book/read', $data);
	}

	public function before_read_book() {
		$id = $this->input->get('id');
		

		redirect('book/read_book?id='.$id);
	}

}
