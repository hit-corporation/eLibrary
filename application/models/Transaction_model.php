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

	// check_borrowed

	/**
	 * Query for check if book is borrowed
	 * 
	 * @param int $book_id
	 * @param int $user_id
	 * 
	 * @return array
	 */
	 
	public function check_borrowed(int $book_id, int $user_id): array {
		$this->db->from('transactions');
		$this->db->where('book_id', $book_id);
		$this->db->where('member_id', $user_id);
		$this->db->where('actual_return', null);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);

		$res = $this->db->get();

		if($res->num_rows() == 0) {
			return [];
		}

		return $res->row_array();
	}

	/**
	 * Query for get user borrowed book
	 * 
	 * @param int $user_id
	 * @return array
	 */
	 
	public function get_user_borrowed_book(int $user_id, int $limit=NULL, int $offset=NULL): array {
		$this->db->from('transactions a')
				 ->join('books b', 'a.book_id=b.id')
				 ->where('a.member_id', $user_id)
				 ->where('a.actual_return', null);

		$res = $this->db->get();
		return $res->result_array();
	}

	/**
	 * Query for get user borrowed book
	 * 
	 * @param int $user_id
	 * @return array
	 */
	 
	public function count_user_borrowed_book(int $user_id): array {
		$this->db->from('transactions');
		$this->db->where('member_id', $user_id);
		$this->db->where('actual_return', null);

		$res = $this->db->get();
		return $res->num_rows();
	}

	/**
	 * Query for get get_latest_transaction
	 * 
	 * @param int $book_id
	 * @param int $member_id
	 * 
	 * @return array
	 */

	public function get_latest_transaction(int $book_id, int $member_id): array {
		$this->db->from('transactions');
		$this->db->where('book_id', $book_id);
		$this->db->where('member_id', $member_id);
		$this->db->where('actual_return', null);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);

		$res = $this->db->get();

		if($res->num_rows() == 0) {
			return [];
		}
		
		return $res->row_array();
	}

}
