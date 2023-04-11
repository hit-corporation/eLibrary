<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');

		// if(!$this->session->userdata('user')){
		// 	redirect(base_url('login'));
		// }
	}

	/**
     * function for view
     *
     * @return void
     */
	public function index(): void {
		echo $this->template->render('index');
	}

	public function get_all_paginated(): void {
		$limit  = $this->input->get('length');
		$offset = $this->input->get('start');
        $filter = $this->input->get('columns');

        $dataTable = [
            'draw'            => $this->input->get('draw') ?? NULL,
            'data'            => $this->user_model->get_all($filter, $limit, $offset),
            'recordsTotal'    => $this->db->count_all_results('users'),
            'recordsFiltered' => $this->user_model->count_all($filter)
        ];

        echo json_encode($dataTable, JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
	}

	/**
     * get all data
     *
     * @return void
     */
    public function get_all(): void{
        $data = $this->user_model->get_all();
        echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
    }

	/**
     * Editing data in database
     *
     * @return void
     */
    public function edit(): void
    {
        $id     		= trim($this->input->post('user_id', TRUE));
        $user_name   	= trim($this->input->post('user_name', TRUE));
        $full_name   	= trim($this->input->post('full_name', TRUE));
        $email   		= trim($this->input->post('email', TRUE));
        $user_pass   	= trim($this->input->post('user_pass', TRUE));
        $status   		= trim($this->input->post('status', TRUE));
		$role_id  		= trim($this->input->post('role_id', TRUE));

		$this->form_validation->set_rules('user_name', 'Username', 'required');
		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('user_pass', 'Password', 'required');
		$this->form_validation->set_rules('role_id', 'Role', 'required');

        if(!$this->form_validation->run())
        {
            $return = ['success' => false, 'errors' => $this->form_validation->error_array(), 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

		// CHECK OLD PASSWORD
		$old_pass = $this->db->get_where('users', ['id' => $id])->row()->user_pass;
		if($user_pass != $old_pass){
			$user_pass = password_hash($user_pass, PASSWORD_DEFAULT);
		}

        $data = [
            'user_name' => $user_name,
            'full_name' => $full_name,
            'email' => $email,
            'user_pass' => $user_pass,
            'status' => $status,
            'role_id' => $role_id,
        ];

        if(!$this->db->update('users', $data, ['id' => $id]))
        {
            $return = ['success' => false, 'message' =>  'Data Gagal Di Simpan', 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }
       
       $return = ['success' => true, 'message' =>  'Data Berhasil Di Simpan'];
       $this->session->set_flashdata('success', $return);
       redirect($_SERVER['HTTP_REFERER']);
    }

	public function get_role(): void {
		$data = $this->user_model->get_user_role();
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

		/**
     * Storing submitted Data to database
     *
     * @return void
     */
    public function store(): void
    {
        $user_name   	= $this->input->post('user_name');
		$full_name   	= $this->input->post('full_name');
		$email   		= $this->input->post('email');
		$user_pass   	= $this->input->post('user_pass');
		$status   		= $this->input->post('status');
		$role_id  		= $this->input->post('role_id');

        $this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');
		$this->form_validation->set_rules('user_pass', 'Password', 'required');


        if(!$this->form_validation->run())
        {
            $return = ['success' => false, 'errors' => $this->form_validation->error_array(), 'old' => $_POST];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            'user_name' => $user_name,
			'full_name' => $full_name,
			'email' => $email,
			'user_pass' => password_hash($user_pass, PASSWORD_DEFAULT),
			'status' => $status,
			'role_id' => $role_id
        ];

        if(!$this->db->insert('users', $data))
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
        if(!$this->db->update('users', ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]))
        {
            $return = ['success' => false, 'message' =>  'Data Gagal Di Hapus'];
            $this->session->set_flashdata('error', $return);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $return = ['success' => true, 'message' =>  'Data Berhasil Di Hapus'];
        $this->session->set_flashdata('success', $return);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
