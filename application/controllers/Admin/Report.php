<?php
ini_set('max_execution_time', -1);

defined('BASEPATH') or exit('No direct script access allowed');

class Report extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaction_model');
		$this->load->model('book_model');
		$this->load->model('report_model');
		$this->load->library('form_validation');
	}

    /**
     * function for view
     *
     * @return void
     */
	public function index(): void
	{
		$this->render('order_report');
	}

    /**
     * get all paginated data and send as json for datatable consume
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
        $query = $this->report_model->get_all($filter, $limit, $offset);

        $date_mod = $this->settings['fines_period_value'].' '.$this->settings['fines_period_unit'];

        foreach($query as $q)
        {
            $denda = (new DateTime('now')) > (new DateTime($q['return_date'])) ? 
                          ((new DateTime('now'))->diff(new DateTime($q['return_date'])))->days * $this->settings['fines_amount'] : NULL;
            $q['denda'] = $denda >= $this->settings['fines_maximum'] ? $this->settings['fines_maximum'] : $denda;
            $data[] = $q;
        }

        $dataTable = [
            'draw'            => $this->input->get('draw') ?? NULL,
            'data'            => $data,
            'recordsTotal'    => $this->db->count_all_results('reports'),
            'recordsFiltered' => $this->report_model->count_all($filter)
        ];

        echo json_encode($dataTable, JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
	}

    /**
     * get all data
     *
     * @return void
     */
    public function get_all(): void
    {
        $data = $this->report_model->get_all();
        echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
    }

	 /**
     * function for view book report
     *
     * @return void
     */
	public function book(): void
	{
		$this->render('book_report');
	}

	/**
	 * get all books data
	 *
	 * @return void
	 */
	public function get_all_book(): void
	{
		$data = $this->book_model->get_all_book();
		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * get all paginated data and send as json for datatable consume
	 *
	 * @return void
	 */
	public function get_all_book_paginated(): void{
		$limit  = $this->input->get('length');
		$offset = $this->input->get('start');
		$filter = $this->input->get('columns');

		// generate data
		$data = $this->book_model->get_all_book($filter, $limit, $offset);

		$dataTable = [
			'draw'            => $this->input->get('draw') ?? NULL,
			'data'            => $data,
			'recordsTotal'    => $this->db->count_all_results('books'),
			'recordsFiltered' => $this->book_model->count_all_book($filter)
		];

		echo json_encode($dataTable, JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
	}

	/**
	 * Download Transaction REport
	 *
	 * @method GET
	 * @return void
	 */
	public function download_trans(): void {
		$filter[1]['search']['value'] = $this->input->get('s_member_name');
		$filter[2]['search']['value'] = $this->input->get('daterange');
		$filter[3]['search']['value'] = $this->input->get('status');
		$filter[4]['search']['value'] = $this->input->get('s_book_name');

		$type = $this->input->get('type');
		$records = $this->report_model->get_all($filter, 30000, 0);
		$data = [];

		foreach($records as $record)
		{
			unset($record['id']);
			$record['loan_date'] = (new DateTime($record['loan_date']))->format('Y-m-d');
			$record['return_date'] = (new DateTime($record['return_date']))->format('Y-m-d');
			$record['actual_return'] = (new DateTime($record['actual_return']))->format('Y-m-d');
			$record['fines_info'] = empty($record['fines_amount']) && empty($record['fines_period']) ? '' : trim($record['fines_amount'].'/'.$record['fines_period']);
			unset($record['notes']);
			unset($record['fines_amount']); 
			unset($record['fines_period']);

			$data[] = (array) $record;
		}
		
		$options = [
			'header' 	=> ['Kode Transaksi', 'Peminjam', 'Kode Stok', 'Judul Buku', 'Tanggal Pinjam', 'Batas Waktu (Tanggal)',  'Batas Waktu (Hari)', 'Tanggal Kembali', 'Terlambat', 'Denda', 'Terbayar', 'Info Denda'],
			'data'   	=> $data,
			'title'  	=> 'Laporan Transaksi Peminjaman<br />'
							.'Periode '.$this->input->get('daterange'),
			'filepath'	=> 'assets/files/download/order',
			'filename'	=> 'loan_report_'.(new DateTime)->format('YmdHis'),
			'pdf'		=> [
				'page-size' 	=> 'Legal',
				'orientation' 	=> 'Landscape'
			]
			
		];

		$this->load->library('export', $options);

		switch($type)
		{
			case 'pdf':
				$this->export->toPDF()->download();
				break;
			case 'excel':
				$this->export->toExcel()->download();
				break;
		}
	}

	/**
	 * Download Book Report
	 * 
	 * @method GET 
	 * @return void
	 */
	public function download_book(): void {
		// Data
		$filter[1]['search']['value'] = $this->input->get('s_book_name');
		$filter[2]['search']['value'] = $this->input->get('s_author_name');
		$filter[3]['search']['value'] = $this->input->get('s_publisher_name');
		$filter[5]['search']['value'] = $this->input->get('s_rack_number');

		$type = $this->input->get('type');
		$records = $this->book_model->get_all_book($filter, 30000, 0);

		function remap($val) 
		{
			return [
				'cover_img' 	=> $val['cover_img'],
				'title' 		=> $val['title'],
				'qty' 			=> $val['qty'],
				'qty_dipinjam' 	=> $val['qty_dipinjam'],
				'author' 		=> $val['author'],
				'publihser_name'=> $val['publisher_name'],
				'isbn'			=> $val['isbn'],
				'publish_year'	=> $val['publish_year'],
				'category_name' => $val['category_name'],
				'created_at'	=> $val['created_at'],
				'rack_no'		=> $val['rack_no'],
			];
		}
		$data = array_map('remap', $records);

		$options = [
			'header' 	=> ['Gambar', 'Judul', 'Stok', 'Stok Keluar', 'Penulis', 'Penerbit',  'ISBN', 'Tahun Terbit', 'Kategori', 'Tanggal Masuk', 'No. Rak'],
			'image'		=> [
				'cover_img' => FCPATH.'assets/img/books/',
			],
			'data'   	=> $data,
			'title'  	=> 'Laporan Detail Buku',
			'filepath'	=> 'assets/files/download/books',
			'filename'	=> 'book_report_'.(new DateTime)->format('YmdHis'),
			'pdf'		=> [
				'page-size' 	=> 'Legal',
				'orientation' 	=> 'Landscape',
				'margin-bottom'	=> '6mm',
				'print-media-type'
			]
			
		];

		$this->load->library('export', $options);

		switch($type)
		{
			case 'pdf':
				$this->export->toPDF()->download();
				break;
			case 'excel':
				$this->export->toExcel()->download();
				break;
		}
	}

	
}

