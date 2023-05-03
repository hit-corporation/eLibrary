<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Book extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['home_model', 'publisher_model', 'kategori_model', 'book_model', 'transaction_model']);
	}

	public function index(){
		$data['viewGroup'] = $_GET['viewGroup'];
		$data['viewStyle'] = $_GET['viewStyle'];
		$data['category_id'] = isset($_GET['category_id']) ? $_GET['category_id'] : null;

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
			'path'		=> '/book',
			'samesite'	=> 'Lax'
		];

		if(!isset($_COOKIE['read_book']))
			setcookie('read_book', base64_encode(json_encode(['key' => $transcode, 'expired' => date('Y-m-d H:i:s', $cookie_option['expires'])])), $cookie_option);

		// get latest transaction book
		$latest_transaction = $this->transaction_model->get_latest_transaction($id, $_SESSION['user']['id']);

		$insert = [
			'trans_code' 	=> $transcode,
			'start_time' 	=> date('Y-m-d H:i:s.u'),
			'member_id' 	=> $_SESSION['user']['id'],
			'book_id'		=> $id,
			// 'config_idle'	=> $this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit'],
			// 'config_borrow_limit' => $this->settings['max_allowed'],
			// 'end_time'		=> isset($latest_transaction['end_time']) ? $latest_transaction['end_time'] : date('Y-m-d H:i:s.u', strtotime('+'.$this->settings['due_date_value'].' '.$this->settings['due_date_unit'])),
		];

		$this->db->insert('read_log', $insert);

		// jika end_time dari transaksi sebelumnya lebih besar dari waktu sekarang, maka update actual_return menjadi tanggal sekarang
		if(isset($latest_transaction['end_time']) && strtotime($latest_transaction['end_time']) < strtotime(date('Y-m-d H:i:s.u')))
		{
			// $this->db->update('transactions', ['actual_return' => date('Y-m-d H:i:s.u')], ['id' => $latest_transaction['id']]);
			$this->db->set('actual_return', date('Y-m-d H:i:s.u'));
			$this->db->update('transactions');
			$this->db->where('book_id', $id);
			$this->db->where('member_id', $_SESSION['user']['id']);
			$this->db->where('actual_return', NULL);
			
		}
		
		redirect('book/read_book?id='.$id);
	}

	/**
	 * Closing after read book
	 *
	 * @return void
	 */
	public function close_book(): void {
		$id = $this->input->get('id');
		$lastPage = $this->input->get('last-page');
		$cookie = json_decode(base64_decode($_COOKIE['read_book']), TRUE);

		$update = [
			'trans_code' => $cookie['key'],
			'book_id'  => $id,
			'end_time' => date('Y-m-d H:i:s.u'),
			'last_page'	=> $lastPage
		];

		$this->db->update('read_log', $update, ['trans_code' => trim($cookie['key'])]);

		setcookie('read_book', NULL, time() - 1000);
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

	/**
	 * Borrow a Book
	 * 
	 * @return void
	 */

	public function borrow_book(): void {
		$id = $this->input->get('id');

		// get book data
		$book = $this->book_model->get_one($id);

		// check if book is available
		if($book['qty'] <= 0)
		{
			$data['heading'] = 'PERINGATAN';
			$data['message'] = '<p>Buku yang anda pilih tidak tersedia. Silahkan pilih buku lain !!!'.
								'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
			$this->load->view('errors/html/error_general', $data);
			return;
		}

		// check if member not login
		if(!isset($_SESSION['user']) && empty($_SESSION['user']['user_name']))
		{
			$data['heading'] = 'PERINGATAN';
			$data['message'] = '<p>Halaman hanya di peruntukan untuk anggota aktif. Silahkan login terlebih dahulu !!!'.
								'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
			$this->load->view('errors/html/error_general', $data);
			return;
		}

		// check if member has reached the limit
		// $member = $this->transaction_model->get_one($_SESSION['user']['id']);
		// if($member['borrowed'] >= $this->settings['max_allowed'])
		// {
		// 	$data['heading'] = 'PERINGATAN';
		// 	$data['message'] = '<p>Anda telah mencapai batas peminjaman. Silahkan kembalikan buku yang anda pinjam !!!'.
		// 						'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
		// 	$this->load->view('errors/html/error_general', $data);
		// 	return;
		// }

		// check if member has borrowed the same book
		$check = $this->transaction_model->check_borrowed($id, $_SESSION['user']['id']);

		if(isset($check['id']) && !empty($check['id']))
		{
			$data['heading'] = 'PERINGATAN';
			$data['message'] = '<p>Anda telah meminjam buku ini. Silahkan kembalikan buku yang anda pinjam !!!'.
								'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
			$this->load->view('errors/html/error_general', $data);
			return;
		}



		// set transaction code
		$transcode = strtoupper(bin2hex(random_bytes(8)));

		// set cookie for reading time limit and idle time limit
		$cookie_option = [
			'expires'	=> strtotime('+'.$this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit']),
			'path'		=> '/book',
			'samesite'	=> 'Lax'
		];

		if(!isset($_COOKIE['read_book']))
			setcookie('read_book', base64_encode(json_encode(['key' => $transcode, 'expired' => date('Y-m-d H:i:s', $cookie_option['expires'])])), $cookie_option);

		$insert = [
			'trans_code' 	=> $transcode,
			'start_time' 	=> date('Y-m-d H:i:s.u'),
			'member_id' 	=> $_SESSION['user']['id'],
			'book_id'		=> $id,
			'config_idle'	=> $this->settings['limit_idle_value'].' '.$this->settings['limit_idle_unit'],
			'config_borrow_limit' => $this->settings['max_allowed'],
			'end_time'		=> date('Y-m-d H:i:s.u', strtotime('+'.$this->settings['due_date_value'].' '.$this->settings['due_date_unit'])),
		];

		// insert transaction
		$this->db->insert('transactions', $insert);

		// update book qty
		$this->db->update('books', ['qty' => $book['qty'] - 1], ['id' => $id]);

		redirect('book/read_book?id='.$id);
	}

	/**
		* Return a Book
		* 
		* 
		*/

	public function return_book() {
		$id = $this->input->get('id');

		// update actual_return
		$this->db->update('transactions', ['actual_return' => date('Y-m-d H:i:s.u')], ['book_id' => $id, 'member_id' => $_SESSION['user']['id'], 'actual_return' => null]);

		// update book qty
		$this->db->where('id', $id);
		$this->db->set('qty', 'qty+1', FALSE);
		$this->db->update('books');

		// return to book detail
		redirect('home/book_detail?id='.$id);
	}

	/**
	 * Add to Favorite
	 *
	 */

	public function add_to_favorite(){
		$id = $this->input->get('id');
		$member_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;

		// check if member not login
		if(!isset($_SESSION['user']) && empty($_SESSION['user']['user_name'])){
			// create flashdata
			$this->session->set_flashdata('error', 'Halaman hanya di peruntukan untuk anggota aktif. Silahkan login terlebih dahulu !!!');
			redirect('home');
		}

		// check favorite book
		$check = $this->db->get_where('favorite_books', ['book_id' => $id, 'member_id' => $member_id])->row_array();

		if(isset($check['id']) && !empty($check['id'])){
			// create flashdata
			$this->session->set_flashdata('error', 'Buku telah ada di daftar favorit !!!');
			redirect('home');
		}

		$insert = $this->db->insert('favorite_books', ['book_id' => $id, 'member_id' => $member_id]);

		// jika berhasil
		if($insert){
			// create flashdata
			$this->session->set_flashdata('success', 'Buku berhasil ditambahkan ke daftar favorit');

			// return to book detail
			redirect('home/book_detail?id='.$id);
		}else{
			$data['heading'] = 'PERINGATAN';
			$data['message'] = '<p>Terjadi kesalahan saat menambahkan buku ke daftar favorit !!!'.
								'<br/> <a href="'.$_SERVER['HTTP_REFERER'].'">Kembali</a></p>';
			$this->load->view('errors/html/error_general', $data);
			return;
		}

	}

	/**
	 * Remove from Favorite
	 *
	 */

	public function remove_from_favorite(){
		$id = $this->input->get('id');
		$member_id = $_SESSION['user']['id'];

		$delete = $this->db->delete('favorite_books', ['book_id' => $id, 'member_id' => $member_id]);
		if($delete){
			$this->session->set_flashdata('success', 'Buku berhasil dihapus dari daftar favorit');
		}else{
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus buku dari daftar favorit !!!');
		}

		// return to book detail
		redirect('home/book_detail?id='.$id);

	}


}
