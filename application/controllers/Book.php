<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Book extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['home_model']);
	}

	public function list_book(){
		// create pagination
		if(isset($_GET['limit']))
			$limit = $_GET['limit'];
		else
			$limit = 10;

		if(isset($_GET['sort']))
			$sortBy = $_GET['sort'];
		else
			$sortBy = null;

		$offset = $this->uri->segment(4);
		$this->load->library('pagination');

		$config['base_url'] = base_url('book/list_book/').$this->uri->segment(3).'/';
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 3;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');
		
		if($this->uri->segment(3) == 'newest'){
			$data['books'] = $this->home_model->get_new_books($limit, $offset, $sortBy);
			$data['title'] = 'Newest Books';
			$config['total_rows'] = $this->home_model->get_new_book_count();
		} elseif ($this->uri->segment(3) == 'popular'){
			$data['books'] = $this->home_model->get_popular_books($limit, $offset, $sortBy);
			$data['title'] = 'Popular Books';
			$config['total_rows'] = $this->home_model->get_popular_book_count();
		} elseif ($this->uri->segment(3) == 'recomend') {
			$data['books'] = $this->home_model->get_recomend_books($limit, $offset, $sortBy);
			$data['title'] = 'Recomend Books';
			$config['total_rows'] = $this->home_model->get_recomend_book_count();
		}

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['limit'] = $limit;
		$data['total'] = $config['total_rows'];

		$this->load->view('header');
		$this->load->view('book/list_book', $data);
		$this->load->view('footer');
	}

}
