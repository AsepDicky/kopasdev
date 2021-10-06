<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_search');
	}

	/********************************************
	* BEGIN ajax search
	*********************************************/

	/**
	* nomor rekening pembiayaan
	* @author sayyid nurkilah
	*/
	public function account_financing_no()
	{
		$keyword=$this->input->post('keyword');
		$status_rekening=$this->input->post('status_rekening');
		$inverse=$this->input->post('inverse'); //kebalikan dari status rekening, default:false
		$data=$this->model_search->account_financing_no($keyword,$status_rekening,$inverse);
		echo json_encode($data);
	}


	/**
	* nomor rekening pembiayaan
	* @author sayyid nurkilah
	*/
	public function account_financing_reg_no()
	{
		$keyword=$this->input->post('keyword');
		$status=$this->input->post('status');
		$inverse=$this->input->post('inverse'); //kebalikan dari status rekening, default:false
		$data=$this->model_search->account_financing_reg_no($keyword,$status,$inverse);
		echo json_encode($data);
	}

	/**
	* nomor rekening tabungan
	* @author sayyid nurkilah
	*/
	public function account_saving_no()
	{

	}


	/********************************************
	* END ajax search
	*********************************************/

}
