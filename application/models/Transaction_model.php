<?php

class Transaction_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Query for count transaction book per daily basis
	 *
	 * @return array
	 */
	public function count_read_daily(): array {
		$query = "SELECT COUNT(a.book_id), a.trans_timestamp, b.title 
				  FROM transactions a, books b
				  WHERE a.book_id=b.id 
				  GROUP BY  b.title, a.trans_timestamp 
				  HAVING a.trans_timestamp = CURRENT_DATE";
		$res = $this->db0->query($query);
		return $res->result_array();
	}

	public function avg_read_time() {
		$query = "SELECT ";		
	}
}
