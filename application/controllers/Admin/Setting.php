<?php

class Setting extends Admin_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('setting_model');
		$this->load->library('form_validation');
		$this->load->helper('form');

        // function register
        // $this->template->registerFunction('set_value', function(string $value, string $default = NULL, bool $escape = TRUE) {
        //     return set_value($value, $default, $escape);
        // });
    }

    /**
     * Main Setting View
     *
     * @return void
     */
    public function index(): void {
        echo $this->template->render('index');
    }

    /**
     * return date default setting
     *
     * @return void
     */
    public function loan(): void {

        echo $this->template->render('loan');
    }

	/**
	 * Store Loan Setting data to database
	 *
	 * @return void
	 */
	public function store_loan():void {
		
		$due_date = $this->input->post('due_date', TRUE);
		$max_book = $this->input->post('max_loan', TRUE);

		$this->form_validation->set_rules('due_date[value]', 'Nilai', 'trim|required|integer');
		$this->form_validation->set_rules('due_date[unit]', 'Unit', 'trim|required|alpha');
		$this->form_validation->set_rules('max_loan', 'Maximal Buku', 'trim|required|integer');

		if(!$this->form_validation->run())
		{
			$errors = ['errors' => $this->form_validation->error_array(), 'old' => $_POST];
			$this->session->set_flashdata('error', $errors);
			redirect('setting/loan');
			return;
		}

		$data = [
			'due_date_value' => $due_date['value'],
			'due_date_unit'  => $due_date['unit'],
			'max_allowed'    => $max_book,
			'updated_at'     => (new DateTime())->format('Y-m-d H:i:s.u')
		];

		if(!$this->db->update('settings', $data, ['id' => 1])) 
		{
			$this->session->set_flashdata('error', ['message' => 'Data gagal di simpan']);
			redirect('setting/loan');
			return;
		}
		$this->session->set_flashdata('success', ['message' => 'Data berhasil di simpan']);
		redirect('setting/loan');

	}

	public function get_all(): void {
		$data = $this->db->get('settings')->row_array();
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}
}
