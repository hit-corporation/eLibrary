<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['user_model', 'member_model', 'book_model', 'dashboard_model','transaction_model']);

		$this->load->library('form_validation');
		
	}

	public function index(){
		//$data['user'] = $this->user_model->get_user($this->session->userdata('user')['id']) ?? $this->user_model->get_user(1) ?? [];
		$data['user'] = $this->user_model->get_user(1) ?? [];
		$data['total_member'] = count($this->member_model->get_all());
		$data['total_book'] = count($this->book_model->get_all());
		$data['total_borrow_book']	= count($this->book_model->get_all_borrow());
		$data['late_borrow'] = count($this->book_model->get_late_borrow());
		$data['top_book_borrow'] = $this->book_model->get_top_borrow();
		$data['percentage_book_borrow'] = $this->book_model->get_percentage_borrow();
		//$data['top_member_borrow'] = $this->member_model->get_top_borrow();
		$data['daily_borrow'] = $this->book_model->get_daily_borrow();

		// MENGGUNAKAN TEMPLATE ENGINE PLATES
		$this->render('index', $data);
	}

	public function dashboard2(){
		$data['fines_this_month'] = $this->dashboard_model->fines_this_month();
		$data['fines_last_month'] = $this->dashboard_model->fines_last_month();
		$data['daily_borrow'] = $this->book_model->get_daily_borrow();
		$data['daily_borrow_last_month'] = $this->book_model->get_daily_borrow_last_month();

		$running_fines = $this->dashboard_model->running_fine();
		$data['running_fine'] = [];

		// Calculate fines
		foreach($running_fines as $q){
            $dateDiff = (new DateTime('now'))->diff(new DateTime($q['return_date']));
            $denda = NULL;

			// jika tanggal hari ini lebih besar dari tanggal kembali
            if((new DateTime('now')) > (new DateTime($q['return_date'])))
            {
                switch($this->settings['fines_period_unit'])
                {
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

			if($denda === NULL){
				$denda = 0;
			}

            $q['denda'] = $denda >= $this->settings['fines_maximum'] ? $this->settings['fines_maximum'] : $denda;
            $data['running_fine'][] = $q;
        }

		// telat pengembalian
		$late_return = 0;
		foreach($data['running_fine'] as $val){
			if($val['denda'] > 0){
				$late_return++;
			}
		}

		$data['late_return'] = $late_return;

		// MENGGUNAKAN TEMPLATE ENGINE PLATES
		$this->render('/admin/dashboard/dashboard_2', $data);
	}

	/**
	 * Get member reader by categories
	 *
	 * @return void
	 */
	public function get_by_categories(): void {
		$type = $this->input->get('type') ?? 'monthly';
		$time = new DateTime($this->input->get('value')) ?? new DateTime('now');
		$data = $this->transaction_model->get_by_category($type, $time);

		echo json_encode(['data' => $data], JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * get reader by grades
	 *
	 * @return void
	 */
	public function get_by_grades(): void {
		$type = $this->input->get('type') ?? 'monthly';
		$time = new DateTime($this->input->get('value')) ?? new DateTime('now');
		$data = $this->transaction_model->get_by_grade($type, $time);

		echo json_encode(['data' => $data], JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Get all members classified by sex
	 *
	 * @return void
	 */
	public function get_member_by_gender(): void {
		$data = $this->member_model->get_by_gender();
		$total = $this->db->count_all_results('members');

		$male = number_format((count($data['l']) / $total) * 100, 2);
		$female = number_format((count($data['p']) / $total) * 100, 2);

		echo json_encode(['male' => $male, 'female' => $female], JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Get Average time reading by Members
	 *
	 * @return void
	 */
	public function get_average_read_member(): void {
		$data = $this->transaction_model->get_avg_read_member();

		echo json_encode(['data' => $data], JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function get_average_read_dow(): void {
		$data = $this->transaction_model->get_avg_person_by_day();

		echo json_encode(['data' => $data], JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}
}
