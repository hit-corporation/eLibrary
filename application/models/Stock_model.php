<?php

class Stock_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Undocumented function
	 *
	 * @param array|null $filter
	 * @param int|null $limit
	 * @param int|null $offset
	 * @return array
	 */
	public function get_all(array $filter = NULL, int $limit = NULL, int $offset = NULL): array {

		$query = $this->db->select('a.id, a.stock_code, a.is_available, a.rack_no, a.book_id, a.created_at, b.title, b.cover_img, b.author')
						  ->from('stocks a, books b')
						  ->where('a.book_id=b.id')
						  ->where('a.deleted_at IS NULL', NULL, FALSE);
		// Filtering
		if(!empty($filter[1]['search']['value']))
			$query->where('LOWER(a.stock_code) LIKE \'%'.$this->db->escape_like_str(strtolower($filter[1]['search']['value'])).'%\' ESCAPE \'!\' ', NULL, FALSE);
		if(!empty($filter[3]['search']['value']))
			$query->where('LOWER(b.title) LIKE \'%'.$this->db->escape_like_str(strtolower($filter[3]['search']['value'])).'%\' ESCAPE \'!\' ', NULL, FALSE);
		if(!empty($filter[5]['search']['value']))
		{
			$ok = NULL;
			switch($filter[5]['search']['value'])
			{
				case 'ya':
					$ok = 1;
					break;
				case 'tidak':
					$ok = 0;
					break;
			}
			$query->where('a.is_available', $ok);
		}
			
		return $query->get()->result_array();
	}

	/**
	 * Undocumented function
	 *
	 * @param array|null $filter
	 * @return integer
	 */
	public function count_all(array $filter = NULL): int {
		$query = $this->db->select('a.id, a.stock_code, a.is_available, a.book_id, a.created_at, b.title, b.cover_img, b.author')
						  ->from('stocks a, books b')
						  ->where('a.book_id=b.id');
		return $query->get()->num_rows();
	}
}

