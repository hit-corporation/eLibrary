<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['stock_model', 'book_model']);
		$this->load->library('form_validation');
	}

	/**
	 * Views default
	 *
	 * @method GET
	 * @return void
	 */
	public function index(): void {

		try
		{
			echo $this->template->render('stock', [], 'book');
		}
		catch(Exception $e)
		{
			log_message('error', $e->__toString());
		}
	}

	/**
	 * Get All Data 
	 *
	 * @method GET
	 * @return void
	 */
	public function get_all(): void {
		$books  = $this->stock_model->get_all();
		echo json_encode($books, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Read data with pagination and send json response 
	 *
	 * @method GET
	 * @return void
	 */
	public function get_all_paginated(): void {
		$draw = $this->input->get('draw');
		$limit = $this->input->get('length');
		$offset = $this->input->get('start');
		$filter = $this->input->get('columns');
		$data = $this->stock_model->get_all($filter, $limit, $offset);

		$resp = [
			'draw'  => $draw,
			'data'	=> $data,
			'recordsTotal' => $this->db->count_all_results('stocks'),
			'recordsFiltered' => $this->stock_model->count_all($filter)
		];

		echo json_encode($resp, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Store new data to database
	 *
	 * @method POST
	 * @return void
	 */
	public function store(): void 
	{
		try
		{
			$book = $this->input->post('book', TRUE);
			$stocks = $this->input->post('stock_codes', TRUE);

			// Vaidations
			$validations = 
			[
				[
					'field' => 'book',
					'label' => 'Buku',
					'rules' => 'required|in_list['.implode(',', array_column($this->book_model->get_all(), 'id')).']'
				],
				[
					'field' => 'stock_codes[]',
					'label' => 'Kode Stok',
					'rules' => 'required'
				]
			];

			$i=0;
			foreach($stocks as $stock)
			{
				$validations[] = [
					'field' => 'stock_codes['.$i.']',
					'label' => 'Kode Stok',
					'rules' => 'required|is_unique[stocks.stock_code]'
				];
				$i++;
			}
			$this->form_validation->set_message('is_array', 'Tipe data dari {field} harus berupa larik (array)');
			$this->form_validation->set_rules($validations);
			// Check Valiations
			if(!$this->form_validation->run())
			{
				$errors = ['errors' => $this->form_validation->error_array(), 'old' => $_POST, 'is_stockform' => true];
				$this->session->set_flashdata('error', $errors);
				redirect($_SERVER['HTTP_REFERER']);
				return;
			}

			// INSert
			$this->db->trans_start();
			foreach($stocks as $stock)
			{
				$data = [
					'stock_code'	=> $stock,
					'book_id'	 	=> $book,
					'is_available' 	=> 1
				];

				$this->db->insert('stocks', $data);
			}
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)
			{
				$resp = ['message' => 'Data gagal di input !!!', 'old' => $_POST, 'is_stockform' => TRUE];
				$this->session->set_flashdata('error', $resp);
				redirect($_SERVER['HTTP_REFERER']);
				return;
			}
	
			$resp = ['message' => 'Data berhasil di input !!!'];
			$this->session->set_flashdata('success', $resp);
			redirect($_SERVER['HTTP_REFERER']);

		}
		catch(Exception $e)
		{
			log_message('error', $e->__toString());
		}
	}

	/**
	 * Modify a data in database
	 *
	 * @return void
	 */
	public function edit(): void {
		$id   = $this->input->post('stock_id', TRUE);
		$code = $this->input->post('stock_code', TRUE);
		$book = $this->input->post('stock_book', TRUE);

		$validations = [
			[
				'field' => 'stock_id',
				'label' => 'ID Stok',
				'rules' => 'required|integer'
			],
			[
				'field' => 'stock_code',
				'label' => 'Kode Stok',
				'rules' => 'required'
			],
			[
				'field' => 'stock_book',
				'label' => 'Buku',
				'rules' => 'required|in_list['.implode(',', array_column($this->book_model->get_all(), 'id')).']'
			]
		];

		$this->form_validation->set_rules($validations);

		if(!$this->form_validation->run())
		{
			$errors = ['errors' => $this->form_validation->error_array(), 'old' => $_POST, 'is_stockform' => false];
			$this->session->set_flashdata('error', $errors);
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$data = [
			'stock_code' => $code,
			'book_id'	 => $book
		];

		if(!$this->db->update('stocks', $data, ['id' => $id])) {
			$resp = ['message' => 'Data gagal di input !!!', 'old' => $_POST, 'is_stockform' => FALSE];
			$this->session->set_flashdata('error', $resp);
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$resp = ['message' => 'Data berhasil di input !!!'];
		$this->session->set_flashdata('success', $resp);
		redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Remove data from database
	 *
	 * @method GET
	 * @return void
	 */
	public function delete($id): void {
		
		if(!$this->db->update('stocks', ['deleted_at' => (new DateTime)->format('Y-m-d H:i:s.u')], ['id' => $id])) {
			$resp = ['message' => 'Data gagal di hapus !!!'];
			$this->session->set_flashdata('error', $resp);
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$resp = ['message' => 'Data berhasil di hapus !!!'];
		$this->session->set_flashdata('success', $resp);
		redirect($_SERVER['HTTP_REFERER']);

	}
}
