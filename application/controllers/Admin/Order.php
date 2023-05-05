<?php

use SebastianBergmann\Environment\Console;
use SebastianBergmann\Type\NullType;

class Order extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model(['member_model', 'transaction_model']);
	}

	/**
	 * **********************************************************
	 * 
	 *                  CUSTOM VALIDATION
	 * 
	 * **********************************************************
	 */

	/**
	 * get all data
	 *
	 * @return void
	 */
	public function get_all(): void
	{

		$data = $this->transaction_model->get_all();
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Get All Paginated
	 *
	 * @return void
	 */
	public function get_all_paginated(): void
	{
		$limit  = $this->input->get('length');
		$offset = $this->input->get('start');
		$filter = $this->input->get('columns');

		// generate data
		$data = [];
		$query = $this->transaction_model->get_all($filter, $limit, $offset);

		$date_mod = $this->settings['fines_period_value'] . ' ' . $this->settings['fines_period_unit'];

		foreach ($query as $q) {
			$dateDiff = (new DateTime('now'))->diff(new DateTime($q['return_date']));
			$denda = NULL;

			if ((new DateTime('now')) > (new DateTime($q['return_date']))) {
				switch ($this->settings['fines_period_unit']) {
					case 'days':
						$denda = $dateDiff->days / $this->settings['fines_period_value'];
						break;
					case 'weeks':
						$denda = intval($dateDiff->days / 7) / $this->settings['fines_period_value'];
						break;
					case 'months':
						$denda = $dateDiff->m / $this->settings['fines_period_value'];
						break;
				}
				$denda = ceil($denda);
				$denda = $denda * $this->settings['fines_amount'];
			}
			$q['denda'] = $denda >= $this->settings['fines_maximum'] ? $this->settings['fines_maximum'] : $denda;
			$data[] = $q;
		}

		$dataTable = [
			'draw'            => $this->input->get('draw') ?? NULL,
			'data'            => $data,
			'recordsTotal'    => $this->db->count_all_results('transactions'),
			'recordsFiltered' => $this->transaction_model->count_all($filter)
		];

		echo json_encode($dataTable, JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
	}

	/**
	 * Show Daily Order
	 *
	 * @return void
	 */
	public function daily_order(): void
	{
		$this->template->registerFunction('set_value', function ($field, $value = NULL) {
			return set_value($field, $value);
		});

		$this->render('daily_order');
	}
}
