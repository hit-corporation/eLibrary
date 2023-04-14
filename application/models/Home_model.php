<?php

class Home_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

	public function get_books($view_group = null, $limit = null, $offset = null, $title = null, $publisher_id = null, $author = null, $category_ids = null, $year = null, $sort_by = null){
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

		if(!empty($title))
			$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($title)).'%\'', NULL, FALSE);

		if(!empty($publisher_id))
			$this->db->where('publisher_id', $publisher_id);

		if(!empty($author))
			$this->db->where('LOWER(author) LIKE \'%'.trim(strtolower($author)).'%\'', NULL, FALSE);

		if(!empty($category_ids))
			$this->db->where_in('category_id', $category_ids);

		// parse year
		if(!empty($year)){
			$year = explode('-', $year);
			$this->db->where('publish_year >=', $year[0]);
			$this->db->where('publish_year <=', $year[1]);
		}


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

	

	public function get_total_books($view_group = null, $title = null, $publisher_id = null, $author = null, $category_ids = null, $year = null){
		if ($view_group == 'newest'){
			$this->db->order_by('created_at', 'DESC');
		} elseif ($view_group == 'popular'){
			$this->db->order_by('title', 'DESC');
		} elseif ($view_group == 'recomend'){
			$this->db->order_by('title', 'DESC');
		}

		if(!empty($title))
			$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($title)).'%\'', NULL, FALSE);

		if(!empty($publisher_id))
			$this->db->where('publisher_id', $publisher_id);

		if(!empty($author))
			$this->db->where('LOWER(author) LIKE \'%'.trim(strtolower($author)).'%\'', NULL, FALSE);

		if(!empty($category_ids))
			$this->db->where_in('category_id', $category_ids);	

		// parse year
		if(!empty($year)){
			$year = explode('-', $year);
			$this->db->where('publish_year >=', $year[0]);
			$this->db->where('publish_year <=', $year[1]);
		}

		$this->db->where('deleted_at IS NULL');
		$query = $this->db->get('books');
		return $query->num_rows();
	}

}
