<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function running_fine(){
		$running_fine = $this->db->select('*')
			->from('reports')
			->where('actual_return', null)
			->get()->result_array();

		return $running_fine;
	}

	public function fines_this_month(){
		$this->db->select('SUM(fines_payment) as total_fine');
		$this->db->from('reports');
		$this->db->where('EXTRACT(MONTH FROM actual_return)=', date('m'));
		$this->db->where('EXTRACT(YEAR FROM actual_return)=', date('Y'));
		
		return $this->db->get()->row()->total_fine;
	}

	public function fines_last_month(){
		$this->db->select('SUM(fines_payment) as total_fine');
		$this->db->from('reports');
		$this->db->where('EXTRACT(MONTH FROM actual_return)=',date('m') - 1);
		$this->db->where('EXTRACT(YEAR FROM actual_return)=', date('Y'));

		return $this->db->get()->row()->total_fine;
	}

}
