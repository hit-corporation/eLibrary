<?php

class Home_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

	public function get_books($view_group = null, $limit = null, $offset = null, $filter = null, $sort_by = null){
		if ($view_group == 'newest'){
			$this->db->order_by('b.created_at', 'DESC');
		} elseif ($view_group == 'popular'){
			$this->db->order_by('title', 'DESC');
		} elseif ($view_group == 'recomend'){
			$this->db->order_by('title', 'DESC');
		}

		if ($sort_by == 'title-asc')
			$this->db->order_by('title', 'ASC');

		if ($sort_by == 'title-desc')
			$this->db->order_by('title', 'DESC');

		if(!empty($filter['title']))
			$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($filter['title'])).'%\'', NULL, FALSE);

		if(!empty($filter['publisher_id']))
			$this->db->where('publisher_id', $filter['publisher_id']);

		if(!empty($filter['author']))
			$this->db->where('LOWER(author) LIKE \'%'.trim(strtolower($filter['author'])).'%\'', NULL, FALSE);

		if(!empty($filter['category_ids']))
			$this->db->where_in('category_id', $filter['category_ids']);

		// parse year
		if(!empty($filter['year'])){
			$year = explode('-', $filter['year']);
			$this->db->where('publish_year >=', $year[0]);
			$this->db->where('publish_year <=', $year[1]);
		}

		$this->db->select('b.*, p.publisher_name, c.category_name');
		$this->db->where('b.deleted_at IS NULL');
		$this->db->limit($limit, $offset);
		$this->db->join('publishers p', 'p.id = b.publisher_id');
		$this->db->join('categories c', 'c.id = b.category_id');
		$query = $this->db->get('books b');
		return $query->result_array();
	}

	public function get_new_books($limit = 10, $offset = null, $title = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		if ($sortBy == 'title-asc')
			$this->db->order_by('title', 'ASC');
		elseif ($sortBy == 'title-desc')
			$this->db->order_by('title', 'DESC');

		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_popular_books($limit = 10, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('books');
		return $query->result_array();
	}

	public function get_recomend_books($limit = 4, $offset = null, $sortBy = null){
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('title', 'DESC');
		$this->db->limit($limit, $offset);
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

	

	public function get_total_books($view_group = null, $filter = null){
		if ($view_group == 'newest'){
			$this->db->order_by('created_at', 'DESC');
		} elseif ($view_group == 'popular'){
			$this->db->order_by('title', 'DESC');
		} elseif ($view_group == 'recomend'){
			$this->db->order_by('title', 'DESC');
		}

		if(!empty($filter['title']))
			$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($filter['title'])).'%\'', NULL, FALSE);

		if(!empty($filter['publisher_id']))
			$this->db->where('publisher_id', $filter['publisher_id']);

		if(!empty($filter['author']))
			$this->db->where('LOWER(author) LIKE \'%'.trim(strtolower($filter['author'])).'%\'', NULL, FALSE);

		if(!empty($filter['category_ids']))
			$this->db->where_in('category_id', $filter['category_ids']);	

		// parse year
		if(!empty($filter['year'])){
			$year = explode('-', $filter['year']);
			$this->db->where('publish_year >=', $year[0]);
			$this->db->where('publish_year <=', $year[1]);
		}

		$this->db->where('deleted_at IS NULL');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

	public function get_favorite_books($limit = null, $page = null, $sort_by = null){

		if($sort_by == 'title-asc')
			$this->db->order_by('title', 'ASC');

		if($sort_by == 'title-desc')
			$this->db->order_by('title', 'DESC');

		// $this->db->select('fb.id, b.title, b.cover_img, b.author, b.isbn, b.publish_year, b.description, p.publisher_name, c.category_name');
		$this->db->select('fb.*');
		$this->db->from('favorite_books fb');
		$this->db->where('fb.member_id', $this->get_user_id()['id']);
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_total_favorite_books(){
		$this->db->where('deleted_at IS NULL');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

	public function get_user_id(){
		$this->db->select('id');
		$this->db->where('username', $this->session->userdata('user')['user_name']);
		$query = $this->db->get('members');
		return $query->row_array();
	}

}
