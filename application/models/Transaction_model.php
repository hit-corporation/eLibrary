<?php

class Transaction_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Insert or update
	 *
	 * @param array $data
	 * @param array $where
	 * @return void
	 */
    public function upsert($data, $where) {

        if($this->db->get_where('transaction_book', $where)->num_rows() > 0)
            return $this->db->update('transaction_book', $data, $where);
        else
            return $this->db->insert('transaction_book', $data);
    }

	/**
	 * Get One By Transaction Code
	 *
	 * @param string $code
	 * @return array
	 */
	public function get_by_code(string $code): array
	{
		$this->db->select('a.*, b.trans_code, b.trans_timestamp, d.member_name, c.title, c.book_code')
				->from('transaction_book a, transactions b, books c, members d', FALSE)
				->where('a.transaction_id=b.id AND a.book_id=c.id AND b.member_id=d.id', NULL, FALSE)
				->where('b.trans_code', $code);

		return $this->db->get()->result_array();
	}

	/**
	 * Get All Data With Generator 
	 *
	 * @param array|null $filter
	 * @param integer|null $limit
	 * @param integer|null $offset
	 * @return Generator
	 */
	public function get_all(?array $filter = NULL, ?int $limit=NULL, ?int $offset=NULL): Generator {
		if(!empty($filter[1]['search']['value']))
		$this->db->where('LOWER(member_name) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[2]['search']['value'])){
			// PARSING DATE RANGE
			$date_range = explode(' - ', $filter[2]['search']['value']);

			$this->db->where('date(t.trans_timestamp) >=', $date_range[0]);
			$this->db->where('date(t.trans_timestamp) <=', $date_range[1]);
		}

		if(!empty($filter[3]['search']['value'])){
			if($filter[3]['search']['value'] == 'belum'){
				$this->db->where('tb.actual_return IS NULL', NULL, FALSE);
			}elseif($filter[3]['search']['value'] == 'sudah'){
				$this->db->where('tb.actual_return IS NOT NULL', NULL, FALSE);
			}
		}else{
			$this->db->where('tb.actual_return IS NULL', NULL, FALSE);
		}

		// where book name
		if(!empty($filter[4]['search']['value']))
		$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($filter[4]['search']['value'])).'%\'', NULL, FALSE);
	
		if(!empty($limit) && !is_null($offset))
		$this->db->limit($limit, $offset);
        
		$this->db->select('t.*, tb.transaction_id, tb.book_id, tb.qty, 
						   tb.return_date, tb.actual_return, tb.amount_paid, 
						   tb.note, b.title, m.member_name, 
						   AGE(tb.return_date::date, trans_timestamp::date) AS jumlah_hari_pinjam,
						   CASE 
						   		WHEN (CURRENT_DATE > tb.return_date::date) and (tb.actual_return IS NULL)
						   			THEN AGE(CURRENT_DATE, tb.return_date::date)
								WHEN (CURRENT_DATE > tb.return_date::date) and (tb.actual_return IS NOT NULL)
									THEN AGE(tb.actual_return::date, tb.return_date::date)
								ELSE NULL
							END as jumlah_hari_terlambat', FALSE);
        $this->db->from('transactions t');
		$this->db->join('transaction_book tb', 't.id = tb.transaction_id');
		$this->db->join('books b', ' b.id = tb.book_id');
		$this->db->join('members m', 't.member_id = m.id');
		$this->db->order_by('t.trans_timestamp', 'DESC');

		$results = $this->db->get()->result_array();
		
		foreach($results as $res => $val)
		{
			yield $res => $val;
		}
    }

	public function count_all(?array $filter = NULL): int {
        $query = $this->db->get('transactions');
        return $query->num_rows();
    }

	/**
	 * Get All Data With Generator 
	 *
	 * @param array|null $filter
	 * @param integer|null $limit
	 * @param integer|null $offset
	 * @return Generator
	 */
	public function get_all_penalty(?array $filter = NULL, ?int $limit=NULL, ?int $offset=NULL): Generator {
		if(!empty($filter[1]['search']['value']))
		$this->db->where('LOWER(member_name) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[2]['search']['value'])){
			// PARSING DATE RANGE
			$date_range = explode(' - ', $filter[2]['search']['value']);

			$this->db->where('date(t.created_at) >=', $date_range[0]);
			$this->db->where('date(t.created_at) <=', $date_range[1]);
		}

		// where book name
		if(!empty($filter[3]['search']['value']))
		$this->db->where('LOWER(title) LIKE \'%'.trim(strtolower($filter[3]['search']['value'])).'%\'', NULL, FALSE);
	
		if(!empty($limit) && !is_null($offset))
		$this->db->limit($limit, $offset);

		$this->db->select('*, AGE(CURRENT_DATE, tb.return_date::date) AS jumlah_hari_terlambat, AGE(return_date::date, t.trans_timestamp::date) AS jumlah_hari_pinjam');
		$this->db->from('transaction_book tb');
		$this->db->join('transactions t', 't.id = tb.transaction_id');
		$this->db->join('books b', 'tb.book_id = b.id');
		$this->db->join('members m', 't.member_id = m.id');
		$this->db->where('tb.actual_return IS NULL', NULL, FALSE);

		$results = $this->db->get()->result_array();
		
		foreach($results as $res)
		{
			yield $res;
		}
	}

	public function count_all_penalty(): int {
		$this->db->select('*, AGE(CURRENT_DATE, tb.return_date::date) AS jumlah_hari_terlambat, AGE(return_date::date, t.trans_timestamp::date) AS jumlah_hari_pinjam');
		$this->db->from('transaction_book tb');
		$this->db->join('transactions t', 't.id = tb.transaction_id');
		$this->db->join('books b', 'tb.book_id = b.id');
		$this->db->join('members m', 't.member_id = m.id');
		$this->db->where('tb.actual_return IS NULL', NULL, FALSE);

		return $this->db->get()->num_rows();
	}

	
	public function get_order_by_member_id($member_id){
		$this->db->select('tb.*, b.book_code, b.title, t.trans_timestamp, t.trans_code, AGE(CURRENT_DATE, tb.return_date::date) AS jumlah_hari_terlambat');
		$this->db->from('transactions t');
		$this->db->join('transaction_book tb', 't.id = tb.transaction_id');
		$this->db->join('books b', 'tb.book_id = b.id');
		$this->db->where('t.member_id', $member_id);
		$this->db->where('tb.actual_return IS NULL', NULL, FALSE);

		return $this->db->get()->result_array();
	}

}
