<?php

class Member_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

	public function get_all(?array $filter = NULL, ?int $limit=NULL, ?int $offset=NULL): array {
        
		if(!empty($filter[1]['search']['value']))
		$this->db->where('LOWER(member_name) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[2]['search']['value']))
		$this->db->where('LOWER(card_number) LIKE \'%'.trim(strtolower($filter[2]['search']['value'])).'%\'', NULL, FALSE);

		if(!empty($filter[3]['search']['value']))
		$this->db->where('LOWER(no_induk) LIKE \'%'.trim(strtolower($filter[3]['search']['value'])).'%\'', NULL, FALSE);
	
		if(!empty($limit) && !is_null($offset))
		$this->db->limit($limit, $offset);
        
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('member_name', 'ASC');
        $query = $this->db->get('members');
        return $query->result_array();
    }

	public function count_all(?array $filter = NULL){
        $query = $this->db->get('members');
        return $query->num_rows();
    }

	public function get_top_borrow(): array {
		// date range 30 days postgresql
		$this->db->select('m.member_name, count(m.member_name) as total');
		$this->db->from('transactions t');
		$this->db->join('members m', 'm.id = t.member_id');
		$this->db->join('transaction_book tb', 'tb.transaction_id = t.id');
		$this->db->where('t.trans_timestamp >= now() - interval \'30 days\'');
		$this->db->group_by('m.member_name');
		$this->db->order_by('total', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_card_number(string $card_number) {
		$this->db->where('card_number', $card_number);
		$query = $this->db->get('members');
		return $query->row_array();
	}

	public function get_by_member_name(string $member_name): array {
		$this->db->like('member_name', $member_name);
		$query = $this->db->get('members');
		return $query->row_array();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function get_borrowing_member(): array {
		$this->db->distinct()
				 ->select('m.*')
				 ->join('transactions t', 't.member_id=m.id')
				 ->join('transaction_book tb', 't.id=tb.transaction_id')
				 ->where('tb.actual_return IS NULL', NULL, FALSE)
				 ->order_by('m.id', 'desc');
		$query = $this->db->get('members m');
		return $query->result_array();
	}

	/**
	 * Get membe by username
	 *
	 * @param mixed $username
	 * @return array
	 */
	public function login($username)
	{
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where('username', $username);
		$this->db->or_where('email', $username);
		$this->db->where('status', 'active');
		$this->db->where('deleted_at', null);
		$query = $this->db->get();

		return $query->row_array();
	}

	/**
	 * Get member by id
	 *
	 * @param mixed $id
	 * @return array
	 */
	public function get_user($id){
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->row_array();
	}

	/**
	 * Get member by username
	 * 
	 * @param mixed $username
	 * @return array
	 */
	public function get_user_by_username($username){
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where('username', $username);
		$query = $this->db->get();

		return $query->row_array();
	}
}
