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
	 * Set Config Befor reading a book
	 *
	 * @return void
	 */
	public function set_book(): void {
		$id = $this->input->get('id');
		// only active member that can read the book
		if(!isset($_SESSION['user']) && empty($_SESSION['user']['user_name']))
		{
			$data['heading'] = 'PERINGATAN';
			$data['message'] = '<p>Halaman hanya di peruntukan untuk anggota aktif. Silahkan login terlebih dahulu !!!'.
								'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
			$this->load->view('errors/html/error_general', $data);
			return;
		}
		// set transaction code
		$transcode = strtoupper(bin2hex(random_bytes(8)));
		// set cookie for reading time limit and idle time limit
		$cookie_option = [
			'expires'	=> strtotime('+'.$this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit']),
			'path'		=> '/book/read_book',
			'samesite'	=> 'Lax'
		];

		if(!isset($_COOKIE['read_book']))
			setcookie('read_book', $transcode, $cookie_option);

		$insert = [
			'trans_code' 	=> $transcode,
			'start_time' 	=> date('Y-m-d H:i:s.u'),
			'member_id' 	=> $_SESSION['user']['id'],
			'book_id'		=> $id,
			'config_idle'	=> $this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit'],
			'config_borrow_limit' => $this->settings['max_allowed']
		];

		$this->db->insert('transactions', $insert);
		
		redirect('book/read_book?id='.$id);
	}

	/**
	 * Closing after read book
	 *
	 * @return void
	 */
	public function close_book(): void {
		$id = $this->input->get('id');

		$update = [
			'end_time' => date('Y-m-d H:i:s.u'),
			'updated_at' => date('Y-m-d H:i:s.u')
		];

		$this->db->update('transactions', $update, ['trans_code' => $_COOKIE['read_book']]);

		setcookie('read_book', NULL, time() - 1000);
		echo json_encode(['message' => 'Idle time out']);
		redirect('home/book_detail?id='.$id);
	}

	/**
	 * Read a Book
	 *
	 * @return void
	 */
	public function read_book(): void {
		$id = $this->input->get('id');	
		
		if(!isset($_COOKIE['read_book']))
		{
			echo '<script>';
			echo 'window.location.href="'.base_url('home/book_detail?id='.$id).'"';
			echo '</script>';
			return;
		}

		$data['book'] = $this->book_model->get_one($id);
		$data['setting'] = $this->settings;
		$this->load->view('book/read', $data);
	}

	public function get_favorite_books(){
		$page 			= isset($_GET['page']) ? $_GET['page'] : 1;
		$limit 			= isset($_GET['limit']) ? $_GET['limit'] : 3;
		$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';

		$page = ($page - 1) * $limit;

		$data['books'] 	= $this->home_model->get_favorite_books($limit, $page, $sort_by);
		$data['total_records'] = $this->home_model->get_total_favorite_books();
		$data['total_pages'] = ceil($data['total_records'] / $limit);
		
		// create json header	
		header('Content-Type: application/json');
		echo json_encode($data);
	}

}
