<?php

class Home_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

	public function get_new_books(){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_popular_books(){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get('books');
		return $query->result_array();
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

}
