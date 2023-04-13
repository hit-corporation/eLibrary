<?php

class Home_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

	public function get_books($limit = null, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_new_books($limit = 10, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		if ($sortBy == 'title-asc')
			$this->db->order_by('title', 'ASC');
		elseif ($sortBy == 'title-desc')
			$this->db->order_by('title', 'DESC');

		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_new_book_count(){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('created_at', 'DESC');
		$query = $this->db->get('books');
		return $query->num_rows();
	}
	

	public function get_popular_books($limit = 10, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_popular_book_count(){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

	public function get_recomend_books($limit = 4, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_recomend_book_count(){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

	public function get_book_by_id($id){
		$this->db->select('books.*, publishers.publisher_name, categories.category_name');
		$this->db->from('books');
		$this->db->where('books.id', $id);
		$this->db->join('publishers', 'books.publisher_id = publishers.id');
		$this->db->join('categories', 'books.category_id = categories.id');
		$query = $this->db->get();
		return $query->row_array();
	}

	

	public function get_total_books(){
		$this->db->where('deleted_at IS NULL');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

}
