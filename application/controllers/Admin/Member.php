<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('member_model');
		$this->load->library('form_validation');
	}

	 /**
     * function for view
     *
     * @return void
     */
	public function index(): void {
		$this->render('index');
	}

    /**
     * Get List With Pagination
     *
     * @return void
     */
	public function get_all_paginated(): void {
		$limit  = $this->input->get('length');
		$offset = $this->input->get('start');
        $filter = $this->input->get('columns');

        $dataTable = [
            'draw'            => $this->input->get('draw') ?? NULL,
            'data'            => $this->member_model->get_all($filter, $limit, $offset),
            'recordsTotal'    => $this->db->count_all_results('members'),
            'recordsFiltered' => $this->member_model->count_all($filter)
        ];

        echo json_encode($dataTable, JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
	}

	/**
     * get all data
     *
     * @return void
     */
    public function get_all(): void {
        $data = $this->member_model->get_all();

        if(!empty($this->input->get('is_borrowing')))
            $data = $this->member_model->get_borrowing_member();

        echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
    }

	/**
     * Storing submitted Data to database
     *
     * @return void
     */
    public function store(): void
    {
        $member_name   	= $this->input->post('member_name');
		$jenis_kelamin 	= $this->input->post('jenis_kelamin');
        $card_number 	= $this->input->post('card_number');
        $no_induk 	= $this->input->post('no_induk');
        $email 		= $this->input->post('email');
        $address 	= $this->input->post('address');
        $phone 		= $this->input->post('phone');

        $this->form_validation->set_rules('no_induk', 'Nomor Induk', 'required');
        $this->form_validation->set_rules('member_name', 'Nama', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if(!$this->form_validation->run())
        {
            $return = ['success' => false, 'errors' => $this->form_validation->error_array(), 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            'member_name' 			=> $member_name,
			'jenis_kelamin' 		=> $jenis_kelamin,
			'card_number'			=> $card_number,
            'no_induk' 				=> $no_induk,
            'email' 				=> $email,
            'address' 				=> $address,
            'phone' 				=> $phone,
			'created_at' 			=> date('Y-m-d H:i:s'),
        ];

        if(!$this->db->insert('members', $data))
        {
            $return = ['success' => false, 'message' =>  'Data Gagal Di Simpan', 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }
       
       $return = ['success' => true, 'message' =>  'Data Berhasil Di Simpan'];
       $this->session->set_flashdata('success', $return);
       redirect($_SERVER['HTTP_REFERER']);
    }

	/**
     * Editing data in database
     *
     * @return void
     */
    public function edit(): void
    {
        $id     		= trim($this->input->post('member_id', TRUE));
        $member_name   	= trim($this->input->post('member_name', TRUE));
		$jenis_kelamin 	= trim($this->input->post('jenis_kelamin', TRUE));
        $card_number 	= trim($this->input->post('card_number', TRUE));
        $no_induk   	= trim($this->input->post('no_induk', TRUE));
        $email   		= trim($this->input->post('email', TRUE));
        $address   		= trim($this->input->post('address', TRUE));
        $phone   		= trim($this->input->post('phone', TRUE));

		$this->form_validation->set_rules('no_induk', 'Nomor Induk', 'required');
		$this->form_validation->set_rules('member_name', 'Nama Member', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

        if(!$this->form_validation->run())
        {
            $return = ['success' => false, 'errors' => $this->form_validation->error_array(), 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            'member_name' => $member_name,
			'jenis_kelamin' => $jenis_kelamin,
            'no_induk' => $no_induk,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'card_number' => $card_number
        ];

        if(!$this->db->update('members', $data, ['id' => $id]))
        {
            $return = ['success' => false, 'message' =>  'Data Gagal Di Simpan', 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }
       
       $return = ['success' => true, 'message' =>  'Data Berhasil Di Simpan'];
       $this->session->set_flashdata('success', $return);
       redirect($_SERVER['HTTP_REFERER']);
    }

	/**
     * Delete data in db
     *
     * @return void
     */
    public function erase(int $id): void {
        if(!$this->db->update('members', ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]))
        {
            $return = ['success' => false, 'message' =>  'Data Gagal Di Hapus'];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $return = ['success' => true, 'message' =>  'Data Berhasil Di Hapus'];
        $this->session->set_flashdata('success', $return);
        redirect($_SERVER['HTTP_REFERER']);
    }

	/**
	 * Get data by id
	 *
	 * @return void
	 */
	public function get_by_card_number(string $card_number): void {
		$data = $this->member_model->get_by_card_number($card_number);
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Get data by member name
	 *
	 * @return void
	 */
	public function get_by_member_name(string $member_name): void {
		$data = $this->member_model->get_by_member_name($member_name);
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Import dataa from excel
	 *
	 * @return void
	 */
	public function import(): void {
		require_once APPPATH.'third_party'.DIRECTORY_SEPARATOR.'xlsx'.DIRECTORY_SEPARATOR.'SimpleXLSX.php';
		// Upload
		$config['upload_path'] = 'assets/files/uploads';
		$config['allowed_types'] = 'xlsx|xls';
		$config['max_size'] = 10000;
		$config['overwrite'] = TRUE;
		$config['file_name'] = 'member_'.time();

		$this->load->library('upload', $config);

		if(!$this->upload->do_upload('file'))
		{
			$resp = ['success' => false, 'message' => $this->upload->display_errors(), 'old' => $_POST];
			$this->session->set_flashdata('error', $resp);
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$data = $this->upload->data();
		// Parse Excel
		if(!$xlsx = SimpleXLSX::parse($data['full_path']))
			throw new Exception(SimpleXLSX::parseError());
		$excel = $xlsx->rows(0);
		unset($excel[0]);
		// looping data

		$this->db->trans_start();
		foreach($excel as $x)
		{
			$ls = [
				'member_name'	=> "$x[0]",
				'jenis_kelamin'	=> "$x[1]",
				'no_induk'		=> "$x[2]",
				'kelas'			=> "$x[3]",
				'card_number'	=> "$x[4]",
				'email'			=> "$x[5]",
				'phone'			=> "$x[6]",
				'address'		=> "$x[7]"
			];
			
			if($this->db->get_where('members', ['no_induk' => "$x[2]" ])->num_rows() > 0)
				$this->db->update('members', $ls, ['no_induk' => "$x[2]"]);
			else
				$this->db->insert('members', $ls);
		}
		$this->db->trans_complete();

		if($this->db->trans_status() == FALSE)
		{
			$this->session->set_flashdata('error', ['message' => 'Beberapa data gagal di input']);
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		@unlink($data['full_path']);

		$this->session->set_flashdata('success', ['message' => 'Beberapa data berhasil di input']);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
