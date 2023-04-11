<?php

class Fines extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}

	/**
	 * Views 
	 *
	 * @return void
	 */
	public function index(): void {
		echo $this->template->render('fines', [], 'setting');
	}

	/**
	 * Store data into database
	 *
	 * @return void
	 */
	public function store(): void {
		$nilai = $this->input->post('amount', TRUE);
		$periode = $this->input->post('period', TRUE);
		$max_value = $this->input->post('max-amount', TRUE);

		// Validation rules
		$validation = [
			[
				'field'	=> 'amount',
				'label' => 'Nilai',
				'rules' => 'trim|integer'
			],
			[
				'field'	=> 'period',
				'label' => 'Periode',
				'rules' => 'is_array'
			],
			[
				'field'	=> 'period[value]',
				'label' => 'Periode',
				'rules' => 'integer'
			],
			[
				'field'	=> 'period[unit]',
				'label' => 'Periode',
				'rules' => 'trim|alpha'
			],
			[
				'field'	=> 'max-amount',
				'label' => 'Nilai Maksimum',
				'rules' => 'integer'
			]
		];

		$this->form_validation->set_message('is_array', 'Tipe {field} harus berupa larik (array)');
		$this->form_validation->set_rules($validation);

		if(!$this->form_validation->run())
		{
			$error = ['errors' => $this->form_validation->error_array(), 'old' => $_POST];
			$this->session->set_flashdata('error', $error);
			redirect('fines');
			return;
		}

		$data = [
			'fines_amount' => $nilai,
			'fines_period_value' => $periode['value'],
			'fines_period_unit' => $periode['unit'],
			'fines_maximum' => $max_value
		];

		if(!$this->db->update('settings', $data, ['id' => 1]))
		{
			$error = ['message' => 'Data gagal di simpan !!!', 'old' => $_POST];
			$this->session->set_flashdata('error', $error);
			redirect('fines');
		}

		$error = ['message' => 'Data berhasil di simpan !!!'];
		$this->session->set_flashdata('success', $error);
		redirect('fines');
	}
}
