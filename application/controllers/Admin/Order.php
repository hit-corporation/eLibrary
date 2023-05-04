<?php

use SebastianBergmann\Environment\Console;
use SebastianBergmann\Type\NullType;

class Order extends Admin_Controller {

    public function __construct() {
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
     * Return Order View 
     *
     * @return void
     */
    public function return_order(): void {
		$post = $this->input->post();

		if(!empty($post)){
			$post = $this->input->post();

			$jumlah_bayar = $post['jumlah_bayar'];
			$i=0;
			foreach($post['id'] as $key => $val){
				if($val != ""){

					// update data book transaction
					$jumlah_bayar -= $post['denda'][$i];
	
					// jika sisa uang lebih dari 0
					if($jumlah_bayar > 0){
						// update data book transaction
						$this->db->update('transaction_book', 
						[
							'actual_return' => date('Y-m-d H:i:s', time()), 
							'amount_penalty'=> $post['denda'][$i],
							'amount_paid' 	=> $post['denda'][$i]
						], 
						['id' => $val]);
					}else{
						// update data book transaction
						$this->db->update('transaction_book', 
						[
							'actual_return' => date('Y-m-d H:i:s', time()), 
							'amount_penalty'=> $post['denda'][$i],
							'amount_paid' 	=> ($post['denda'][$i] + $jumlah_bayar) < 0 ? 0 : ($post['denda'][$i] + $jumlah_bayar)
						], 
						['id' => $val]);
	
					}
	
					// update book qty
					$this->db->set('qty', 'qty+1', FALSE)->where('id', $post['book_id'][$i])->update('books');

					// difference between actual return and return date
					$late_days = time() - strtotime($post['late_days'][$i]);
					$late_days = $late_days / 86400;
					$late_days = ceil($late_days) * -1;

					// jika late days kurang dari 0
					if($late_days < 0){
						$late_days = 0;
					}

					$report_data = [
					    'actual_return' => date('Y-m-d H:i:s'),
						// actual return - return date
					    'late_days'     => $late_days,
					    'fines_amount'  => $this->settings['fines_amount'],
					    'fines_period'  => $this->settings['fines_period_value'].' '.$this->settings['fines_period_unit'],
					    'fines_total'   => $post['denda'][$i],
					    'fines_payment' => ($post['denda'][$i] + $jumlah_bayar) < 0 ? 0 : ($post['denda'][$i] + $jumlah_bayar),
					    'notes'         => $post['jenis_pembayaran'],
					    'updated_at'    => (new DateTime)->format('Y-m-d H:i:s.u')
		
					];
		
					$updateReport = $this->db->update('reports', $report_data, ['trans_code' => $post['trans_code'][$i], 'book_code' => $post['book_code'][$i]]);
				}

				$i++;
			}

            $this->db->trans_complete();

            if(!$this->db->trans_status())
            {
                $resp = ['message' => 'Data gagal di input !!!'];
			    $this->session->set_flashdata('error', $resp);
                return;
            }

			// set flashdata
			$resp = ['message' => 'Data berhasil di input !!!'];
			$this->session->set_flashdata('success', $resp);
			redirect('order/return_order');
			return;
		}
        $this->template->registerFunction('set_value', function($field, $value = NULL) {
            return set_value($field, $value);
        });
        $this->render('return_order');
    }

	/**
     * get all data
     *
     * @return void
     */
    public function get_all(): void{

        $data = $this->transaction_model->get_all();
        echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
    }

    /**
     * Get All Paginated
     *
     * @return void
     */
	public function get_all_paginated(): void {
		$limit  = $this->input->get('length');
		$offset = $this->input->get('start');
        $filter = $this->input->get('columns');

        // generate data
        $data = [];
        $query = $this->transaction_model->get_all($filter, $limit, $offset);

        $date_mod = $this->settings['fines_period_value'].' '.$this->settings['fines_period_unit'];

        foreach($query as $q)
        {
            $dateDiff = (new DateTime('now'))->diff(new DateTime($q['return_date']));
            $denda = NULL;
            
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
	public function daily_order(): void {
        $this->template->registerFunction('set_value', function($field, $value = NULL) {
            return set_value($field, $value);
        });

        $this->render('daily_order');
	}

	/**
	 * Get get_order_by_member_id
	 *
	 * @return void
	 */

	public function get_by_member_id($member_id): void {
		$data = [];

		$query = $this->transaction_model->get_order_by_member_id($member_id);

		foreach($query as $q){
            $dateDiff = (new DateTime('now'))->diff(new DateTime($q['return_date']));
            $denda = NULL;
            
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
            $data[] = $q;
        }

		echo json_encode($data, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);
	}
}
