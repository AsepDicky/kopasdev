<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok extends GMN_Controller 
{


	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_kelompok');
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
	}

	public function index()
	{
		$data['container'] = 'kelompok';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/

	public function anggota_keluar()
	{
		$data['container'] = 'kelompok/anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}

	public function search_desa_by_kecamatan()
	{
		$keyword = $this->input->post('keyword');
		$kecamatan = $this->input->post('kecamatan');
		$data = $this->model_kelompok->search_desa_by_kecamatan($keyword,$kecamatan);

		echo json_encode($data);
	}

	public function get_rembug_by_desa_code()
	{
		$desa_code = $this->input->post('desa_code');
		$data = $this->model_kelompok->get_rembug_by_desa_code($desa_code);

		echo json_encode($data);
	}

	public function get_anggota_rembug_by_cm_code()
	{
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_kelompok->get_anggota_rembug_by_cm_code($cm_code);

		echo json_encode($data);
	}

	public function get_cif_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_kelompok->get_cif_by_cif_no($cif_no);

		echo json_encode($data);
	}

	public function get_saldo_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_kelompok->get_saldo_by_cif_no($cif_no);

		echo json_encode($data);
	}

	public function get_rembug_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_id = $this->session->userdata('branch_id');
		$data = $this->model_kelompok->get_rembug_by_keyword($keyword,$branch_id);

		echo json_encode($data);
	}

	function get_pegawai_by_keyword(){
		$keyword = $this->input->post('keyword');
		$data = $this->model_kelompok->get_pegawai_by_keyword($keyword);

		echo json_encode($data);
	}

	function proses_anggota_keluar(){
		$cif_no = $this->input->post('cif_no');

		$cek_financing = $this->model_kelompok->cek_pembiayaan_aja($cif_no);
		$cek_saving = $this->model_kelompok->cek_tabungan_aja($cif_no);

		if($cek_financing['jumlah'] == 0){
			if($cek_saving['jumlah'] == 0){
				$data = array('status' => '2');
				$param = array('cif_no' => $cif_no);
				$this->db->trans_begin();
				$this->model_kelompok->update_cif_status($data,$param);

				if($this->db->trans_status() === TRUE){
					$this->db->trans_commit();
					$return = array(
						'success'=> TRUE,
						'message'=>'Registrasi Pengeluaran Anggota Berhasil!'
					);
				} else {
					$this->db->trans_rollback();
					$return = array('success'=>false,'message'=>'Failed to Connect into Databases, Please Contact Your Administrator!');
				}
			} else {
				$return = array(
					'success'=> FALSE,
					'message'=>'Anggota ini masih memiliki tabungan aktif'
				);
			}
		} else {
			$return = array(
				'success'=> FALSE,
				'message'=>'Anggota ini masih memiliki pembiayaan aktif'
			);
		}

		echo json_encode($return);
	}

	public function verifikasi_approve_mutasi_anggota_keluar()
	{
		$cif_mutasi_id = $this->input->post('cif_mutasi_id');
		$cif_no = $this->input->post('cif_no');
		$data=array('status'=>1);
		$param=array('cif_mutasi_id'=>$cif_mutasi_id);
		$data_status = array('status'=>'3');
		$param_status = array('cif_no'=>$cif_no);
		$data_financing 			= array('status_rekening'=>4);
		$param_financing 			= array('cif_no'=>$cif_no,'status_rekening'=>1);
		$data_saving 				= array('status_rekening'=>4);
		$param_saving 				= array('cif_no'=>$cif_no,'status_rekening'=>1);
		$data_deposito 				= array('status_rekening'=>4);
		$param_deposito 			= array('cif_no'=>$cif_no,'status_rekening'=>1);

		$this->db->trans_begin();
		$this->model_transaction->update_account_financing($data_financing,$param_financing);
		$this->model_transaction->update_account_saving($data_saving,$param_saving);
		$this->model_transaction->update_account_deposit($data_deposito,$param_deposito);
		$this->model_kelompok->update_mutasi_anggota($data,$param);
		$this->model_kelompok->update_cif_status($data_status,$param_status);
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function verifikasi_reject_mutasi_anggota_keluar()
	{
		$cif_mutasi_id = $this->input->post('cif_mutasi_id');
		$cif_no = $this->input->post('cif_no');
		$data_status = array('status'=>1);
		$param_status= array('cif_no'=>$cif_no);
		$param=array('cif_mutasi_id'=>$cif_mutasi_id);
		$this->db->trans_begin();
		$this->model_kelompok->update_cif_status($data_status,$param_status);
		$this->model_kelompok->delete_mutasi_anggota($param);
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/
	public function anggota_mutasi()
	{
		$data['container'] = 'kelompok/anggota_mutasi';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}
	public function proses_anggota_pindah()
	{
		
		$cif_no						= $this->input->post('cif_no');
		$tipe_mutasi				= "2"; //untuk sementara karna tak tahu harus diisi apa 
		$cm_code					= $this->input->post('cm_code');
		$cm_code_baru				= $this->input->post('cm_code2'); 
		$description				= $this->input->post('alasan');
		$tanggal_mutasi				= date('Y-m-d H:i:s');
		$fa_code					= "0"; //untuk sementara karna tak tahu harus diisi apa
		$created_date				= date('Y-m-d H:i:s');
		$created_by					= $this->session->userdata('user_id');
	    //array input table mfi_cif_mutasi
		$data = array(
						 'cif_no'					=>$cif_no
						,'tipe_mutasi'				=>$tipe_mutasi
						,'cm_code'					=>$cm_code
						,'cm_code_baru'				=>$cm_code_baru
						,'description'				=>$description
						,'tanggal_mutasi'			=>$tanggal_mutasi
						,'fa_code'					=>$fa_code
						,'created_date'				=>$created_date
						,'created_by'				=>$created_by
					);
		//array data update cif cm_code
		$data_baru = array('cm_code'=>$cm_code_baru);
		$param = array('cif_no'=>$cif_no);

		$this->db->trans_begin();
		$this->model_kelompok->proses_anggota_pindah($data); //input ke tabel mfi_cif_mutasi
		$this->model_kelompok->update_cif_cm_code($data_baru,$param); //update status cif
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/


}