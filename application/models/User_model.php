<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function get_all(?array $filter = NULL, ?int $limit=NULL, ?int $offset=NULL): array {
        
		if(!empty($filter[1]['search']['value']))
		$this->db->where('LOWER(users.user_name) LIKE \'%'.trim(strtolower($filter[1]['search']['value'])).'%\'', NULL, FALSE);
	
		if(!empty($limit) && !is_null($offset))
		$this->db->limit($limit, $offset);
        
		$this->db->select('users.*, userrole.rolename');
		$this->db->where('users.deleted_at IS NULL');
        $this->db->join('userrole', 'userrole.id = users.role_id');
        $query = $this->db->get('users');
        return $query->result_array();
    }

	public function count_all(?array $filter = NULL){
        $query = $this->db->get('users');
        return $query->num_rows();
    }

	public function insert($data){
		$this->db->insert('users', $data);
	}

	public function login($data){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_name', $data['user_name']);
		$this->db->where('status', 'active');
		$this->db->where('deleted_at', null);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_all_users(){
		$this->db->select('u.*, ur.rolename');
		$this->db->from('users u');
		$this->db->join('userrole ur', 'ur.id = u.role_id');
		$this->db->where('u.deleted_at', null);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_user($id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->update('users', ['deleted_at' => date('Y-m-d H:i:s')] );
		return true;
	}

	public function get_user_role(){
		$this->db->select('*');
		$this->db->from('userrole');
		$this->db->where('deleted_at', null);
		$query = $this->db->get();
		return $query->result_array();
	}

}
