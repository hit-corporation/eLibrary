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
	 *
	 * @return int
	 */
	 
	public function get_user_borrowed_book(int $user_id): int {
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

	/**
	 * Query for get get_users_loan
	 *
	 * @param int $member_id
	 * @param array $filter
	 *  
	 * @return array
	 */
	 
	public function get_users_loan(int $member_id, $filter): array {
		$this->db->select('books.*');
		$this->db->from('transactions');
		$this->db->join('books', 'transactions.book_id = books.id');
		$this->db->join('publishers', 'books.publisher_id = publishers.id');
		$this->db->where('member_id', $member_id);
		$this->db->where('actual_return', null);

		// sort by
		if ($filter['sort_by'] == 'title-asc')
			$this->db->order_by('books.title', 'ASC');

		if ($filter['sort_by'] == 'title-desc')
			$this->db->order_by('books.title', 'DESC');
		
		// filter limit offset
		$this->db->limit($filter['limit'], $filter['offset']);

		$res = $this->db->get();

		if($res->num_rows() == 0) {
			return [];
		}

		return $res->result_array();
	}

	/** 
	 * Query for get get_users_loan_count
	 * 
	 * @param int $member_id
	 * 
	 * @return int
	 */

	public function get_users_loan_count(int $member_id): int {
		$this->db->from('transactions');
		$this->db->where('member_id', $member_id);
		$this->db->where('actual_return', null);

		$res = $this->db->get();
		return $res->num_rows();
	}

}
