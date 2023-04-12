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

}
