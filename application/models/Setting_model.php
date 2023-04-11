<?php

class Setting_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get Stting By Fields (setting module)
	 *
	 * @param string $field
	 * @return array
	 */
	public function get_by_field(string $field): array {
		$array = $this->db->get_where('settings', ['field' => $field])->result_array();

		$reduce = array_reduce($array, function($sum, $item) {
			$sum[$item['key']] = $item['value'];
			return $sum;
		}, []);

		return $reduce;
	}
}
