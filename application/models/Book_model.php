<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Data
	 *
	 * @param array|null $filter
	 * @param integer|null $limit
	 * @param integer|null $offset
	 * @return array
	 */
	public function get_all(?array $filter=NULL, ?int $limit=NULL, int $offset=NULL): array 
	{
		$this->db->distinct();
		$this->db->select('a.id, a.title, a.book_code, a.cover_img, a.author, a.isbn, a.publish_year, a.description, a.qty, a.category_id, a.publisher_id, a.author, 
							s.rack_no, b.category_name, c.publisher_name, TO_CHAR(a.created_at, \'YYYY-MM-DD\') as created_at', FALSE)
				 ->from('books a')
				 ->join('categories b', 'a.category_id=b.id')
				 ->join('publishers c', 'a.publisher_id=c.id')
				 ->join('stocks s', 'a.id=s.book_id', 'left	')
				 ->where('a.deleted_at IS NULL');

		if(!empty($filter[1]['search']['value']))
		$this->db->where('LOWER(a.title) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[2]['search']['value']))
		$this->db->where('LOWER(a.author) LIKE \'%'.trim(strtolower($filter[2]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[3]['search']['value']))
		$this->db->where('LOWER(c.publisher_name) LIKE \'%'.trim(strtolower($filter[3]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($limit) && !is_null($offset))
			$this->db->limit($limit, $offset);
		
		return $this->db->get()->result_array();
	}

	/**
	 * Count All Results With Filters
	 *
	 * @param array|null $filter
	 * @return integer
	 */
	public function count_all(?array $filter=NULL): int 
	{
		$this->db->join('categories', 'books.category_id=categories.id')
				 ->join('publishers', 'books.publisher_id=publishers.id')
				 ->where('books.deleted_at IS NULL');

		if(!empty($filters))
		{

		}
		$query = $this->db->get('books');
		return $query->num_rows();
	}

	/**
	 * Get a record by id
	 *
	 * @param int $id
	 * @return array
	 */
	public function get_one($id): ?array
	{
		$this->db->join('categories', 'books.category_id=categories.id');
		$this->db->join('publishers', 'books.publisher_id=publishers.id');
		return $this->db->get_where('books', ['books.id' => $id, 'books.deleted_at' => NULL])->row_array();
	}

	/**
	 * Get a transaction_book
	 *
	 * @param int $id
	 * @param int $user_id
	 * 
	 * @return array
	 */
	public function get_transaction_book($id, $user_id): ?array {
		$this->db->select('*');
		$this->db->from('transactions');
		$this->db->where('book_id', $id);
		$this->db->where('member_id', $user_id);
		$this->db->where('actual_return', null);

		return $this->db->get()->row_array();
	}

		/**
	 * Get All Borrowed Book
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_all_borrow(): array
	{
		$this->db->select('b.*');
		$this->db->from('transaction_book tb');
		$this->db->join('books b', 'tb.book_id=b.id');
		$this->db->where('tb.actual_return IS NULL');
		return $this->db->get()->result_array();
	}

	/**
	 * Get All Late Book
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_late_borrow(): array
	{
		$this->db->select('b.*');
		$this->db->from('transaction_book tb');
		$this->db->join('books b', 'tb.book_id=b.id');
		$this->db->where('tb.actual_return IS NULL');
		$this->db->where('tb.return_date < NOW()');
		return $this->db->get()->result_array();
	}

	/**
	 * Get Top 5 Borrowed Book
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_top_borrow(): array
	{
		$this->db->select('b.*, COUNT(tb.book_id) as total');
		$this->db->from('transaction_book tb');
		$this->db->join('books b', 'tb.book_id=b.id');
		$this->db->group_by('b.id');
		$this->db->order_by('total', 'DESC');
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}

	/**
	 * Get Top 5 Borrowed Book
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_percentage_borrow(): array{
		// persentase siswa yang pernah meminjam buku
		$this->db->select('COUNT(DISTINCT t.member_id) as total');
		$this->db->from('transactions t');
		$has_borrow = $this->db->get()->row_array();

		// persentase siswa yang belum pernah meminjam buku
		$this->db->select('COUNT(DISTINCT m.id) as total');
		$this->db->from('members m');
		$this->db->where('m.id NOT IN (SELECT DISTINCT t.member_id FROM transactions t)', NULL, FALSE);
		$never_borrow = $this->db->get()->row_array();

		return [
			'has_borrow' => $has_borrow['total'],
			'never_borrow' => $never_borrow['total']
		];

	}

	/**
	 * Get Daily Borrow
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_daily_borrow(): array{
		// create query for 30 days	
		$this->db->select('COUNT(t.id) as total, TO_CHAR(t.trans_timestamp, \'YYYY-MM-DD\') as date', FALSE);
		$this->db->from('transactions t');
		$this->db->where('EXTRACT(MONTH FROM t.trans_timestamp) =', date('m'), FALSE);
		$this->db->group_by('date');
		$this->db->order_by('date', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * Get Daily Borrow Last Month
	 * for Dashboard
	 *
	 * @return array
	 */
	public function get_daily_borrow_last_month(): array{
		$this->db->select('COUNT(t.id) as total, TO_CHAR(t.trans_timestamp, \'YYYY-MM-DD\') as date', FALSE);
		$this->db->from('transactions t');
		$this->db->where("date_trunc('month', t.trans_timestamp) = date_trunc('month', current_date - interval '1' month)", NULL, FALSE);
		$this->db->group_by('date');
		$this->db->order_by('date', 'ASC');
		return $this->db->get()->result_array();
	}

	/** 
	 * get a get_favorite_book
	 * 
	 * @param int $id
	 * @param int $member_id
	 * 
	 * @return array
	 */

	public function get_favorite_book($id, $member_id): ?array {
		$this->db->select('*');
		$this->db->from('favorite_books');
		$this->db->where('book_id', $id);
		$this->db->where('member_id', $member_id);

		return $this->db->get()->row_array();
	}

}
