<?php

class Report_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
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

			$this->db->where('date(r.loan_date) >=',  date('Y-m-d', strtotime($date_range[0].' 00:00:00')));
			$this->db->where('date(r.loan_date) <=', date('Y-m-d', strtotime($date_range[1].' 00:00:00')));
		}

		if(!empty($filter[3]['search']['value'])){
			if($filter[3]['search']['value'] == 'belum'){
				$this->db->where('r.actual_return IS NULL', NULL, FALSE);
			}elseif($filter[3]['search']['value'] == 'sudah'){
				$this->db->where('r.actual_return IS NOT NULL', NULL, FALSE);
			}
		}

		// where book name
		if(!empty($filter[4]['search']['value']))
			$this->db->where('LOWER(book_title) LIKE \'%'.trim(strtolower($filter[4]['search']['value'])).'%\'', NULL, FALSE);
	
		if(!empty($limit) && !is_null($offset))
			$this->db->limit($limit, $offset);
			
		$this->db->select('r.id, r.trans_code, r.member_name, r.book_code, r.book_title, r.loan_date, r.return_date,
						   AGE(r.return_date::date, r.loan_date::date) AS loan_days, r.actual_return,
						   r.late_days,r.fines_amount, r.fines_period, r.fines_total, r.fines_payment, r.notes', FALSE);
        $this->db->from('reports r');
		$this->db->order_by('r.loan_date', 'DESC');

		$results = $this->db->get()->result_array();
		
		foreach($results as $res)
		{
			yield $res;
		}
    }

	public function count_all(?array $filter = NULL): int {
		if(!empty($filter[1]['search']['value']))
			$this->db->where('LOWER(member_name) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[2]['search']['value'])){
			// PARSING DATE RANGE
			$date_range = explode(' - ', $filter[2]['search']['value']);

			$this->db->where('date(r.loan_date) >=',  date('Y-m-d', strtotime($date_range[0].' 00:00:00')));
			$this->db->where('date(r.loan_date) <=', date('Y-m-d', strtotime($date_range[1].' 00:00:00')));
		}
		// else{
		// 	$this->db->where('date(r.loan_date) >=',  date('Y-m-d', time() - (60 * 60 * 24 * 30) ));
		// 	$this->db->where('date(r.loan_date) <=', date('Y-m-d', time()));
		// }

		if(!empty($filter[3]['search']['value'])){
			if($filter[3]['search']['value'] == 'belum'){
				$this->db->where('r.actual_return IS NULL', NULL, FALSE);
			}elseif($filter[3]['search']['value'] == 'sudah'){
				$this->db->where('r.actual_return IS NOT NULL', NULL, FALSE);
			}
		}

		// where book name
		if(!empty($filter[4]['search']['value']))
			$this->db->where('LOWER(book_title) LIKE \'%'.trim(strtolower($filter[4]['search']['value'])).'%\'', NULL, FALSE);
			
        // ['Kode Transaksi', 'Nama Peminjam', 'Nama Buku', 'Tanggal Pinjam', 'Jumlah Hari', 'Batas Waktu Pengembalian', 'Tanggal Kembali', 'Terlambat', 'Denda', 'Terbayar']
		$this->db->select('r.id, r.trans_code, r.member_name, r.book_code, r.book_title, r.loan_date, r.return_date,
						   AGE(r.return_date::date, r.loan_date::date) AS loan_days, r.actual_return,
						   r.late_days,r.fines_amount, r.fines_period, r.fines_total, r.fines_payment, r.notes', FALSE);
        $this->db->from('reports r');
		$this->db->order_by('r.loan_date', 'DESC');

		$results = $this->db->get();
		
		return $results->num_rows();
    }

	/**
	 * read log report
	 *
	 * @param array|null $filter
	 * @param integer|null $limit
	 * @param integer|null $offset
	 * @return void
	 */
	public function get_read_report(?array $filter = NULL, ?int $limit=NULL, ?int $offset=NULL): Generator {
		$query = $this->queryString();
		// buat where nya

		// abis where baru limit 
		if(!empty($limit) && !is_null($offset))
			$query .= " LIMIT {$limit} OFFSET {$offset}";
		// results
		$results = $this->db->query($query)->result_array();

		foreach($results as $k => $v)
			yield $k => $v;
	}

	/**
	 * Count read log with filter
	 *
	 * @param array|null $filter
	 * @return integer
	 */
	public function get_read_count(?array $filter = NULL): int {
		$query = $this->queryString();

		$res = $this->db->query();
		return $res->num_rows();
	}

	/**
	 * Query For read log
	 *
	 * @return string
	 */
	private function queryString(): string 
	{
		$query = "SELECT a.member_id, a.book_id, a.trans_code,  a.start_time::date as tanggal, b.member_name, c.title
						 a.start_time::time, a.end_time::time, a.end_time::time - a.start_time::time as duration 
				  FROM read_log a, members b, books c
				  WHERE a.member_id=b.id AND a.book_id=c.id";
	}

}
