<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_nasabah extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
		$this->load->library('html2pdf');
	}

	/****************************************************************************************/	
	// BEGIN PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function pelunasan()
	{
		$data['container'] = 'nasabah/registrasi_pelunasan_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function get_cif_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_cif_by_account_financing_no($account_financing_no);
		$data['status_pasangan'] = (isset($data['jenis_kelamin']) && $data['jenis_kelamin']=="P")?"ISTRI":"SUAMI";
		$data['jumlah_angsuran'] = ($data['angsuran_pokok']+$data['angsuran_margin']);
		echo json_encode($data);
	}

	public function proses_reg_pelunasan_pembayaran()
	{
		$account_financing_id 			= $this->input->post('account_financing_id');
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$trx_date 						= $this->input->post('trx_date');
		$trx_date 						= $this->datepicker_convert(true,$trx_date,'/');
		$account_financing_no 			= $this->input->post('no_pembiayaan');
		$saldo_pokok		 			= $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_margin 					= $this->convert_numeric($this->input->post('saldo_margin'));
		$saldo_tabungan 				= $this->convert_numeric($this->input->post('saldo_tabungan'));
		$saldo_pokok2		 			= $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_margin2 					= $this->convert_numeric($this->input->post('saldo_margin'));
		$saldo_tabungan2 				= $this->convert_numeric($this->input->post('saldo_tabungan'));
		$potongan_margin 	 			= $this->convert_numeric($this->input->post('potongan_margin'));
		$created_by 					= $this->session->userdata('user_id');
		$tanggal_jtempo 				= $this->input->post('tanggal_jtempo');
		$jtempo_angsuran_next			= $this->input->post('jtempo_angsuran_next');
		$jtempo_angsuran_last			= $this->input->post('jtempo_angsuran_last');
		$periode_jangka_waktu			= $this->input->post('periode_jangka_waktu');
		$jangka_waktu					= $this->input->post('jangka_waktu');
		$jenis_pembayaran				= $this->input->post('jenis_pembayaran');
		$angsuran_pokok					= $this->input->post('angsuran_pokok');
		$angsuran_margin				= $this->input->post('angsuran_margin');
		$angsuran_catab					= $this->input->post('angsuran_catab');
		$counter_angsuran				= $this->input->post('counter_angsuran');
		$account_cash_code				= $this->input->post('account_cash_code');
		$created_date 					= date('Y-m-d H:i:s');
		$date_current 					= $this->model_transaction->get_date_current();
		$sisa_angsuran 					= $jangka_waktu-$counter_angsuran;

		$jtempo_db = $tanggal_jtempo;


		$trx_detail_id = uuid(false);
		$trx_account_financing_id = uuid(false);

		/*data financing lunas*/
		$data = array(
				'account_financing_lunas_id'=>$trx_account_financing_id,
				'account_financing_no'	=>$account_financing_no,
				'saldo_pokok' 			=>$saldo_pokok,
				'saldo_margin' 			=>$saldo_margin,
				'potongan_margin' 		=>$potongan_margin,
				'status_pelunasan'		=>'0',
				'create_by' 			=>$created_by,
				'tanggal_lunas' 		=>$trx_date,
				'created_date'			=>$created_date
		);
		
		$trx_detail = array(
				 'trx_detail_id' 			=> $trx_detail_id
				,'trx_type' 				=> '3'
				,'trx_account_type' 		=> '2'
				,'account_no' 				=> $account_financing_no
				,'flag_debit_credit'		=> 'C'
				,'amount' 					=> $saldo_pokok+$saldo_margin
				,'trx_date' 				=> $trx_date
				,'created_by' 				=> $this->session->userdata('user_id')
				,'created_date' 			=> date('Y-m-d H:i:s')
			);

		$trx_account_financing = array(
			'trx_account_financing_id'  => $trx_account_financing_id
			,'branch_id' 				=> $this->session->userdata('branch_id')
			,'trx_detail_id' 			=> $trx_detail_id
			,'account_financing_no' 	=> $account_financing_no
			,'trx_financing_type' 		=> '2'
			,'trx_date' 				=> $trx_date
			,'jto_date' 				=> $jtempo_db
			,'pokok' 					=> $saldo_pokok
			,'margin' 					=> $saldo_margin
			,'catab' 					=> 0
			,'account_cash_code' 		=> $account_cash_code
			,'angsuran_ke' 				=> $jangka_waktu
			,'trx_status' 				=> 0
			,'created_date' 			=> date('Y-m-d H:i:s')
			,'created_by' 				=> $this->session->userdata('user_id')
		);

		$this->db->trans_begin();
		
		// financing pelunasan transaction
		$this->model_nasabah->proses_reg_pelunasan_pembayaran($data);
		
		// financing transaction
		$this->model_nasabah->insert_mfi_trx_detail($trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);
		
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_financing_by_id()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		$data = $this->model_nasabah->get_financing_by_id($account_financing_lunas_id);
		if($data['tgl_lahir']=='' || $data['tgl_lahir']==NULL) $data['tgl_lahir'] = date('Y-m-d');
		if($data['trx_date']=='' || $data['trx_date']==NULL) $data['trx_date'] = date('Y-m-d');
		if($data['tanggal_jtempo']=='' || $data['tanggal_jtempo']==NULL) $data['tanggal_jtempo'] = date('Y-m-d');
		echo json_encode($data);
	}

	public function proses_edit_pelunasan_pembayaran()
	{
		$account_financing_lunas_id 	= $this->input->post('account_financing_lunas_id');
		$account_financing_id 			= $this->input->post('account_financing_id');
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$account_financing_no 			= $this->input->post('no_pembiayaan');
		$saldo_pokok		 			= $this->input->post('saldo_pokok');
		$saldo_margin 					= $this->input->post('saldo_margin');
		$saldo_tabungan 				= $this->input->post('saldo_tabungan');
		$potongan_margin 	 			= $this->input->post('potongan_margin');
		$created_by 					= $this->session->userdata('user_id');
		$created_date 					= date('Y-m-d H:i:s');
		$date_current 					= $this->model_transaction->get_date_current();

		$data = array(
				/*'account_financing_no'	=>$account_financing_no,
				'saldo_pokok' 			=>$saldo_pokok,
				'saldo_margin' 			=>$saldo_margin,*/
				'potongan_margin' 		=>$potongan_margin,
				/*'status_pelunasan'		=>'0',
				'create_by' 			=>$created_by,
				'created_date'			=>$created_date*/
				);
		$param = array('account_financing_lunas_id'=>$account_financing_lunas_id);

		$data_financing = array(
							'saldo_pokok'			=>$saldo_pokok,
							'saldo_margin'			=>$saldo_margin,
							'saldo_cadangan_resiko'	=>$saldo_tabungan
							/*'jtempo_angsuran_last'	=>$jtempo_angsuran_last,
							'jtempo_angsuran_next'	=>$jtempo_angsuran_next*/
							);

		$param_financing = array('account_financing_id'=>$account_financing_id);

		$data_financing_schedulle = array(
									'tanggal_bayar' 	=>$date_current,
									'bayar_pokok'		=>$saldo_pokok,
									'bayar_margin'		=>$saldo_margin,
									'bayar_tabungan'	=>$saldo_tabungan
									);

		$param_financing_schedulle = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);

		$this->db->trans_begin();
		$this->model_nasabah->proses_edit_pelunasan_pembayaran($data,$param);
		$this->model_nasabah->update_account_financing($data_financing,$param_financing);
		$this->model_nasabah->update_account_financing_schedulle($data_financing_schedulle,$param_financing_schedulle);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_data_pelunasan_pembiayaan()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_lunas_id) ; $i++ )
		{
			$param = array('account_financing_lunas_id'=>$account_financing_lunas_id[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_data_pelunasan_pembiayaan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN VERIFIKASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function verifikasi_pelunasan()
	{
		$data['container'] = 'nasabah/verifikasi_pelunasan';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_pelunasan_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_financing.account_financing_no','mfi_cif.nama','mfi_akad.akad_name','mfi_account_financing.jangka_waktu','');
		// $cm_code = @$_GET['cm_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		else
		{
			$sWhere = "where mfi_account_financing_lunas.status_pelunasan ='0'";
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_pelunasan_pembiayaan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_lunas_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['akad_name'];
			$row[] = $aRow['jangka_waktu']." Bulan";
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini green" account_financing_lunas_id="'.$aRow['account_financing_lunas_id'].'" id="link-edit">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function proses_verifikasi_pelunasan_pembayaran()
	{
		/*
		| note : account_financing_lunas_id = id valuenya=trx_account_financing_id
		*/
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		// $trx_account_financing_id   = $this->input->post('trx_account_financing_id');
		$account_financing_id 		= $this->input->post('account_financing_id');
		$cif_no 					= $this->input->post('cif_no');
		$account_financing_no 		= $this->input->post('no_pembiayaan');
		$total_pembayaran 			= $this->convert_numeric($this->input->post('total_pembayaran'));
		$potongan_margin 			= $this->convert_numeric($this->input->post('potongan_margin'));
		$tanggal_jtempo 			= $this->input->post('tanggal_jtempo');
		$debet_rekening 			= $this->input->post('debet_rekening');
		$saldo_pokok 				= $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_margin 				= $this->convert_numeric($this->input->post('saldo_margin'));
		$saldo_tabungan				= $this->convert_numeric($this->input->post('saldo_tabungan'));
		$user_id			  		= $this->session->userdata('user_id');
		$date_current 				= $this->model_transaction->get_date_current();
		$trx_detail_id 				= uuid(false);
		$created_by 				= $this->session->userdata('user_id');
		$created_date		  		= date('Y-m-d H:i:s');
		$jangka_waktu 		 		= $this->input->post('jangka_waktu');

		
		/*
		| get data account pembiayaan
		*/
		$account = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);
		$v_jtempo_angsuran_last = $account['jtempo_angsuran_last'];
		$v_jtempo_angsuran_next = $account['jtempo_angsuran_next'];
		$v_tanggal_jtempo = $account['tanggal_jtempo'];
		$v_jangka_waktu = $account['jangka_waktu'];
		$v_counter_angsuran = $account['counter_angsuran'];
		$v_flag_jadwal_angsuran = $account['flag_jadwal_angsuran'];
		$v_periode_jangka_waktu = $account['periode_jangka_waktu'];

		/*
		| get data trx history pembiayaan
		*/
		$trx_account = $this->model_transaction->get_trx_account_financing_by_trx_id($account_financing_lunas_id);
		$trx_angsuran_pokok = $trx_account['pokok'];
		$trx_angsuran_margin = $trx_account['margin'];
		$trx_date = $trx_account['trx_date'];
		$account_cash_code = $trx_account['account_cash_code'];

		/*
		| set variable for perubahan account pembiayaan
		*/
		$jtempo_angsuran_last = $v_jtempo_angsuran_last;
		$jtempo_angsuran_next = $v_jtempo_angsuran_next;
		$jtempo_db = $v_tanggal_jtempo;
		$sisa_angsuran = $v_jangka_waktu-$v_counter_angsuran;
		$flag_jadwal_angsuran = $v_flag_jadwal_angsuran;
		$periode_jangka_waktu = $v_periode_jangka_waktu;

		// data account financing
		$jto_next = $jtempo_angsuran_next;
		$jto_last = $jtempo_angsuran_last;
		if($periode_jangka_waktu=='0'){
			$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran days"));
			$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran days"));
		}else if($periode_jangka_waktu=='1'){
			$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran weeks"));
			$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran weeks"));
		}else if($periode_jangka_waktu=='2'){
			$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran months"));
			$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran months"));
		} else if($periode_jangka_waktu==3) {
			$jto_next = $jtempo_db;
			$jto_last = $jtempo_db;
		}

		//** PERUBAHAN JIKA BAYAR LUNAS NYA KURANG, JADI MASIH NUNGGAK
		$data_usr = $this->model_nasabah->get_cif_by_account_financing_no($account_financing_no);
		$_saldo_pokok = $data_usr['saldo_pokok'];

		$hasil_pokok = $_saldo_pokok-$total_pembayaran;
		$saldo_pokok_save = ($hasil_pokok > 0) ? $hasil_pokok : (sign($hasil_pokok) == -1) ? $hasil_pokok : 0;
		//*****************//

		// account financing
		$data_acc_financing	= array(
			// 'saldo_pokok'=>0,
			'saldo_pokok'=>$saldo_pokok_save,
			'saldo_margin'=>0,
			'tanggal_lunas'=>$trx_date,
			'jtempo_angsuran_last'=>$jto_last,
			'jtempo_angsuran_next'=>$jto_next,
			'counter_angsuran'=>$v_jangka_waktu,
			'status_rekening'=>($saldo_pokok_save!=0) ? 1 : 2
		);

		$param_acc_financing = array('account_financing_id'=>$account_financing_id);

		// account financing lunas
		$data_acc_financing_lunas = array(
			'status_pelunasan'=>1,
			'verify_by'	 	  =>$user_id,
			'verifiy_date'	  =>$created_date
		 );
		$param_acc_financing_lunas = array('account_financing_lunas_id'=>$account_financing_lunas_id);

		/*update status tab.simpan wajib pinjam*/
		// $dataswp = array('status_rekening'=>1);
		// $paramswp = array('account_saving_no'=>$cif_no);

		// update trx account financing lunas
		$data   = array('verify_by'=>$this->session->userdata('user_id')
						,'verify_date'=>date('Y-m-d H:i:s')
						,'trx_status'=>'1'
						,'tipe_angsuran'=>'4'
						);
		$param 	= array('trx_account_financing_id'=>$account_financing_lunas_id);

		$this->db->trans_begin();
		// update to lunas financing schedulle
		$this->model_nasabah->update_account_financing_data($data_acc_financing,$param_acc_financing);
		if ($flag_jadwal_angsuran=='0') {
			$this->model_nasabah->update_account_financing_schedulle_to_lunas($account_financing_no,$trx_date);
		}
		
		$this->model_nasabah->proses_verifikasi_pelunasan_pembayaran($data_acc_financing_lunas,$param_acc_financing_lunas);
		$this->model_transaction->aktivasi_transaksi_financing($data,$param);
		// $this->model_nasabah->update_account_financing_data($dataswp,$paramswp);
		// $this->model_nasabah->fn_proses_jurnal_pelunasan_pyd($account_financing_lunas_id);
		$this->model_nasabah->fn_proses_jurnal_pelunasan_pyd_koptel($account_financing_lunas_id,$account_cash_code);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function reject_data_pelunasan_pembiayaan()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');

		$success = 0;
		$failed  = 0;
		// for ( $i = 0 ; $i < count($account_financing_lunas_id) ; $i++ )
		// {
			$param = array('account_financing_lunas_id'=>$account_financing_lunas_id);
			$this->db->trans_begin();
			$this->model_nasabah->reject_data_pelunasan_pembiayaan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		// }

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END VERIFIKASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
	public function pencairan_pembiayaan()
	{
		$data['container'] = 'nasabah/pencairan_pembiayaan';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		// $data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);
	}



	public function datatable_pencairan_pembiayaanTAM()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_account_financing.account_financing_no','mfi_cif.nama','mfi_akad.akad_name','pokok','jangka_waktu','mfi_fa.fa_name','');
		// $cm_code = @$_GET['cm_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pencairan_pembiayaan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$periode_jangka_waktu = '';
			switch ($aRow['periode_jangka_waktu']) {
				case '0':
				$periode_jangka_waktu = ' Hari';
				break;
				case '1':
				$periode_jangka_waktu = ' Minggu';
				break;
				case '2':
				$periode_jangka_waktu = ' Bulan';
				break;
				case '3':
				$periode_jangka_waktu = 'x Jatuh Tempo';
				break;
			}
			$row = array();
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['kewajiban_koptel'],0,',','.').',-</div>';
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['kewajiban_kopegtel'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu'].$periode_jangka_waktu;
			$row[] = $aRow['fa_name'];
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini purple" account_financing_id="'.$aRow['account_financing_id'].'" id="link-edit">Pencairan</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function reject_pencairan_pembiayaan()
	{
		//HAPUS SEMUA DATA PENGAJUAN DAN REGISTRASI AKAD
		$registration_no2 = $this->input->post('registration_no2');
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');

		
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>null,
							'approve_date'	 =>null
						 );
		
			$param = array('account_financing_id'=>$account_financing_id);
			$param_droping = array('account_financing_no'=>$account_financing_no);
			$param_delete = array('registration_no'=>$registration_no2);

			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			$this->model_nasabah->delete_data_financing_from_financing_droping($param_droping);
			$this->model_nasabah->delete_data_financing_from_financing_reg($param_delete);
			$this->model_nasabah->delete_data_financing_from_financing($param_delete);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		echo json_encode($return);
	}

	public function proses_pencairan_rekening_pembiayaan()
	{
		$debug = false;

		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');
		$account_saving = $this->input->post('account_saving_hide');
		$tanggal_akad	= $this->input->post('tgl_akad');
		$tanggal_mulai_angsur = $this->input->post('angsuranke1');
		$tanggal_jtempo = $this->input->post('tgl_jtempo');
		$tanggal_transfer = $this->datepicker_convert(true,$this->input->post('tanggal_transfer'),'/');
		$nilai_pembiayaan = $this->convert_numeric($this->input->post('nilai_pembiayaan'));
		$margin_pembiayaan = $this->convert_numeric($this->input->post('margin_pembiayaan'));
		$simpanan_wajib_pinjam = $this->convert_numeric($this->input->post('simpanan_wajib_pinjam'));
		$angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
		$angsuran_tabungan = $this->convert_numeric($this->input->post('angsuran_tabungan'));
		$total_angsuran = $angsuran_pokok+$angsuran_margin+$angsuran_tabungan;
		$droping_by	= $this->session->userdata('user_id');
		$created_by	= $droping_by;
		$created_date = date("Y-m-d H:i:s");

	  	//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad = substr("$tanggal_akad",0,2);
		$bln_akad = substr("$tanggal_akad",2,2);
		$thn_akad	= substr("$tanggal_akad",4,4);
		$tglakhir_akad = "$thn_akad-$bln_akad-$tgl_akad";  

	  	//Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		$tgl_mulai_angsur = substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur = substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	= substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur = "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; 

	 	 //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo	= substr("$tanggal_jtempo",0,2);
	    $bln_jtempo = substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	= substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo = "$thn_jtempo-$bln_jtempo-$tgl_jtempo"; 
		
	  	// get data account financing
		$datafinancing = $this->model_nasabah->get_account_financing_by_account_financing_no($account_financing_no);
		$status_rekening = $datafinancing['status_rekening'];
		$cif_no = $datafinancing['cif_no'];
		$pokok = $datafinancing['pokok'];
		$margin = $datafinancing['margin'];
		$saldo_pokok = $datafinancing['saldo_pokok'];
		$saldo_margin = $datafinancing['saldo_margin'];
		
		// banmod options
		$is_banmod = $this->input->post('is_banmod');
		$datatermin = array();
		$flag_update='0'; // 0-update seperti biasa, 1-update untuk pencairan termin ke 2,3,4,dst...
		$termin_ke = 1;
		if ($is_banmod==1) {
			$datatermin = $this->model_transaction->get_account_financing_reg_termin_id($account_financing_reg_id);
			$termin_ke = $datatermin['termin'];
			if ($termin_ke>1) {
				$flag_update='1';
			}
		}

		$this->db->trans_begin();

		/**
		* PERUBAHAN SCRIPT
		* dari UPDATE data droping ke INSERT data droping
		*
		* set data droping pembiayaan
		* @author sayyid nurkilah
		*/
		$data_financing_droping = array();
		$id_droping = uuid(false);
		if ( $flag_update == '0' ) {
			$data_financing_droping = array(
				'account_financing_droping_id' => $id_droping,
				'account_financing_no' => $account_financing_no,
				'cif_no' => $cif_no,
				'status_droping' => 1, // cair/droping
				'create_by' => $created_by,
				'created_date' => $created_date,
				'droping_by' => $droping_by,
				'droping_date' => $tglakhir_akad,
				'status_transfer' => '0',
				'tanggal_transfer' => $tanggal_transfer,
				'termin'=>1
		 	);
		} else if ( $flag_update == '1' ) {
			$data_financing_droping = array(
				'account_financing_droping_id' => $id_droping,
				'account_financing_no' => $account_financing_no,
				'cif_no' => $cif_no,
				'status_droping' => 1, // cair/droping
				'create_by' => $created_by,
				'created_date' => $created_date,
				'droping_by' => $droping_by,
				'droping_date' => $tglakhir_akad,
				'status_transfer' => '0',
				'tanggal_transfer' => $tanggal_transfer,
				'termin'=>$termin_ke
		 	);
		}

		/* set data pembiayaan */
		$data_financing = array();
		$param_financing = array();
		if ( $flag_update == '0' ) {
			$data_financing = array(
				'tanggal_akad' => $tglakhir_akad,
				'status_rekening' => 1,
				'tanggal_mulai_angsur' => $tglakhir_angsur,
				'jtempo_angsuran_last' => $tglakhir_angsur, // sama dengan angsuran pertama
				'jtempo_angsuran_next' => date('Y-m-d',strtotime($tglakhir_angsur.' +1 month')),
				'tanggal_jtempo' => $tglakhir_jtempo,
				'saldo_pokok' => $nilai_pembiayaan,
				'saldo_margin' => $margin_pembiayaan,
				'counter_angsuran' => '1'
			);
			$param_financing = array('account_financing_id'=>$account_financing_id);
		} else if ($flag_update == '1') {
			$data_financing = array(
				'saldo_pokok' => $saldo_pokok+$nilai_pembiayaan,
				'saldo_margin' => $saldo_margin+($margin/$pokok*$nilai_pembiayaan)
			);
		}

		/* set data balance */
		$data_default_balance = array();
		$param_default_balance = array();
		if ($flag_update == '0')
		{
			$data_default_balance = array(
				'account_financing_no' => $account_financing_no,
				'pokok_pembiayaan' => $data_financing['saldo_pokok'],
				'margin_pembiayaan' => $data_financing['saldo_margin']
			);
			$param_default_balance = array('account_financing_no'=>$account_financing_no);
		}

		/* do transaction */
		if ( count($data_financing_droping) > 0 ) $this->model_nasabah->insert_account_financing_droping($data_financing_droping);
		if ( count($data_financing) > 0 ) $this->model_nasabah->update_account_financing($data_financing,$param_financing);
		if ( count($data_default_balance) > 0 ) $this->model_nasabah->update_default_balance($data_default_balance,$param_default_balance);
		/* //do transaction */

		/* set data history transaction */
		$trx_detail = array();
		$trx_account_financing = array();
		$angs_trx_detail = array();
		$angs_trx_account_financing = array();
		$id_history_angsuran = uuid(false);
		$trx_detail_id = uuid(false);
		$angs_trx_detail_id = uuid(false);

		/* history droping */
		if ( $flag_update == '0' )
		{
			$trx_detail = array(
				 'trx_detail_id' => $trx_detail_id
				,'trx_type' => '3'
				,'trx_account_type'	=> '0'
				,'account_no' => $account_financing_no
				,'flag_debit_credit' => 'D'
				,'amount' => $nilai_pembiayaan+$margin_pembiayaan
				,'trx_date' => $tglakhir_akad
				,'created_by' => $this->session->userdata('user_id')
				,'created_date' => date('Y-m-d H:i:s')
				,'account_no_dest' => $account_financing_no
				,'account_type_dest' => '1'
			);
			$trx_account_financing = array(
				'branch_id' => $this->session->userdata('branch_id')
				,'trx_detail_id' => $trx_detail_id
				,'trx_account_financing_id' => $id_droping
				,'account_financing_no' => $account_financing_no
				,'trx_financing_type' => '0'
				,'trx_date' => $tglakhir_akad
				,'jto_date' => $tglakhir_akad
				,'pokok' => $nilai_pembiayaan
				,'margin' => $margin_pembiayaan
				,'catab' => '0'
				,'trx_status' => '1'
				,'created_date' => date('Y-m-d H:i:s')
				,'created_by' => $this->session->userdata('user_id')
				,'tipe_angsuran' => '1'
				,'angsuran_ke' => '0'
				,'verify_by' => $this->session->userdata('user_id')
				,'verify_date' => date('Y-m-d H:i:s')
			);
		}
		else if( $flag_update == '1' )
		{
			$trx_detail = array(
				 'trx_detail_id' => $trx_detail_id
				,'trx_type' => '3'
				,'trx_account_type'	=> '0'
				,'account_no' => $account_financing_no
				,'flag_debit_credit' => 'D'
				,'amount' => $nilai_pembiayaan+($margin/$pokok*$nilai_pembiayaan)
				,'trx_date' => $tglakhir_akad
				,'created_by' => $this->session->userdata('user_id')
				,'created_date' => date('Y-m-d H:i:s')
				,'account_no_dest' => $account_financing_no
				,'account_type_dest' => '1'
			);
			$trx_account_financing = array(
				'branch_id' => $this->session->userdata('branch_id')
				,'trx_detail_id' => $trx_detail_id
				,'trx_account_financing_id' => $id_droping
				,'account_financing_no' => $account_financing_no
				,'trx_financing_type' => '0'
				,'trx_date' => $tglakhir_akad
				,'jto_date' => $tglakhir_akad
				,'pokok' => $nilai_pembiayaan
				,'margin' => ($margin/$pokok*$nilai_pembiayaan)
				,'catab' => '0'
				,'trx_status' => '1'
				,'created_date' => date('Y-m-d H:i:s')
				,'created_by' => $this->session->userdata('user_id')
				,'tipe_angsuran' => '1'
				,'angsuran_ke' => '0'
				,'verify_by' => $this->session->userdata('user_id')
				,'verify_date' => date('Y-m-d H:i:s')
			);
		}

		/* history angsuran pertama */
		if ( $flag_update == '0' && $is_banmod==0 )
		{
			$angs_trx_detail = array(
				 'trx_detail_id' => $angs_trx_detail_id
				,'trx_type' => '3'
				,'trx_account_type' => '1'
				,'account_no' => $account_financing_no
				,'flag_debit_credit' => 'D'
				,'amount' => $total_angsuran
				,'trx_date' => $tglakhir_akad
				,'created_by' => $this->session->userdata('user_id')
				,'created_date' => date('Y-m-d H:i:s')
				,'account_no_dest' => NULL
				,'account_type_dest' => NULL
			);

			$angs_trx_account_financing = array(
				'branch_id' => $this->session->userdata('branch_id')
				,'trx_account_financing_id' => $id_history_angsuran
				,'trx_detail_id' => $angs_trx_detail_id
				,'account_financing_no' => $account_financing_no
				,'trx_financing_type' => '1'
				,'trx_date' => $tglakhir_akad
				,'jto_date' => $tglakhir_angsur
				,'pokok' => $angsuran_pokok
				,'margin' => $angsuran_margin
				,'catab' => $angsuran_tabungan
				,'trx_status' => '1'
				,'angsuran_ke' => '1'
				,'created_date' => date('Y-m-d H:i:s')
				,'created_by' => $this->session->userdata('user_id')
				,'tipe_angsuran' => '1'
				,'verify_by' => $this->session->userdata('user_id')
				,'verify_date' => date('Y-m-d H:i:s')
			);
		}

		/*update status termin dan tanggal realisasi pencairan*/
		if ($is_banmod==1) {
			$account_financing_reg_termin_id = $datatermin['account_financing_reg_termin_id'];
			$data_termin = array(
					'status'=>1,
					'tgl_realisasi_pencairan'=>$tglakhir_akad
				);
			$param_termin = array('account_financing_reg_termin_id'=>$account_financing_reg_termin_id);
			$this->db->update('mfi_account_financing_reg_termin',$data_termin,$param_termin);
		}

		// financing transaction
		// if ($is_banmod==0)
		// {
		if ( count($trx_detail) > 0 ) $this->model_nasabah->insert_mfi_trx_detail($trx_detail);
		if ( count($trx_account_financing) > 0 ) $this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);
		if ( count($angs_trx_detail) > 0 ) $this->model_nasabah->insert_mfi_trx_detail($angs_trx_detail);
		if ( count($angs_trx_account_financing) > 0 ) $this->model_nasabah->insert_mfi_trx_account_financing($angs_trx_account_financing);
		if ( count($angs_trx_account_financing) > 0 ) $this->model_transaction->fn_proses_jurnal_angsuran_pyd($id_history_angsuran);
		// }
		
		// jurnal_trx_id = account_financing_droping_id
		// if ( $flag_update == '0' ) {
		// $this->model_nasabah->fn_proses_jurnal_droping_pyd($account_financing_no);
		$this->model_nasabah->fn_proses_jurnal_droping_pyd_v2($account_financing_no,$termin_ke);
		// }

		// now run the transaction
		if ($debug==true) {

			echo "<pre>";
			// print_r($id_droping);
			// print_r($id_history_angsuran);
			print_r($data_financing_droping);
			print_r($data_financing);
			print_r($data_default_balance);
			print_r($trx_detail);
			print_r($trx_account_financing);
			print_r($angs_trx_detail);
			print_r($angs_trx_account_financing);
			
			$this->db->trans_rollback();
			die();

		} else {

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
			
			echo json_encode($return);

		}
		// end of all transaction

	}


	/****************************************************************************************/	
	// END PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN BLOKIR TABUNGAN
	/****************************************************************************************/
	public function blokir_rekening()
	{
		$data['container'] = 'nasabah/blokir_rekening';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function get_cif_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_nasabah->get_cif_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function proses_blokir_rek_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');
		$account_saving_no = $this->input->post('account_saving_no');
		$status_blokir	   = $this->input->post('status_blokir');
		$saldo_hold		   = $this->input->post('saldo_ditahan');
		$alasan 		   = $this->input->post('alasan');


		$data_blokir_saving=array(
			'account_saving_no'=>$account_saving_no,
			'tipe_mutasi'=>2,
			// 'amount'=>$saldo_hold,
			'description'=>$alasan,
			'created_date'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('user_id')
		);

		if($status_blokir==1){ // apabila status blokir adalah Rekening
			$data_blokir_saving['amount']=0;
			$data=array('status_rekening'=>3);
		}else{ // apabila status blokir adalah Saldo
			$data_blokir_saving['amount']=$this->convert_numeric($saldo_hold);
			$data=array('saldo_hold'=>$this->convert_numeric($saldo_hold));
		}
		$param=array('account_saving_id'=>$account_saving_id);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_from_blokir($data,$param);
		$this->model_nasabah->insert_account_saving_blokir($data_blokir_saving);
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
	// END BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN BUKA ATAU PEMBATALAN TABUNGAN
	/****************************************************************************************/
	public function pembatalan_blokir()
	{
		$data['container'] = 'nasabah/pembatalan_blokir';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function get_cif_by_account_saving_no_for_buka()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_nasabah->get_cif_by_account_saving_no_for_buka($account_saving_no);

		echo json_encode($data);
	}

	public function proses_buka_blokir_rek_tabungan()
	{
		$account_saving_blokir_id 	= $this->input->post('account_saving_blokir_id');
		$account_saving_id 			= $this->input->post('account_saving_id');
		$account_saving_no 			= $this->input->post('account_saving_no');
		$saldo_ditahan		   		= $this->convert_numeric($this->input->post('saldo_ditahan'));
		$saldo_hold		   			= $this->convert_numeric($this->input->post('saldo_hold'));
		$alasan 		   			= $this->input->post('alasan');
		$status_blokir 		   		= $this->input->post('status_blokir');

		if($status_blokir==1){ // apabila status blokir adalah Rekening
			$data=array('status_rekening'=>1);
		}else{ // apabila status blokir adalah Saldo
			$data=array('saldo_hold'=>$saldo_hold-$saldo_ditahan);
		}

		$data_blokir_saving = array(
			//'account_saving_no'=>$account_saving_no,
			'tipe_mutasi'=>3,
			'amount'=>$saldo_hold,
			'description'=>$alasan
			//'created_date'=>date('Y-m-d H:i:s'),
			//'created_by'=>$this->session->userdata('user_id')
		);

		$param			   	   	= array('account_saving_id'	=>$account_saving_id);
		$param_blokir_saving 	= array('account_saving_no'	=>$account_saving_no,'tipe_mutasi'=>2);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_from_blokir($data,$param);
		$this->model_nasabah->update_account_saving_blokir($data_blokir_saving,$param_blokir_saving);
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
	// END BUKA PEMBATALAN BLOKIR TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TUTUP REKENING TABUNGAN
	/****************************************************************************************/
	public function penutupan_rekening()
	{
		$data['container'] = 'nasabah/penutupan_rekening';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function proses_penutupan_rek_tabungan()
	{
		//$account_saving_blokir_id = $this->input->post('account_saving_blokir_id');
		$account_saving_no = $this->input->post('account_saving_no');
		//$saldo_hold		   = $this->input->post('saldo_ditahan');
		$alasan 		   = $this->input->post('alasan');

		$data_blokir_saving			   		= array(
													//'saldo_hold'			=>$saldo_hold,
													'tipe_mutasi'		=>1,
													'description'		=>$alasan
													);
		$param_blokir_saving			   	= array('account_saving_no'		=>$account_saving_no);

		$this->db->trans_begin();
		$this->model_nasabah->update_account_saving_blokir($data_blokir_saving,$param_blokir_saving);
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
	// END TUTUP REKENING TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN ASURANSI KLAIM
	/****************************************************************************************/

	public function klaim_asuransi()
	{
		$data['container'] = 'nasabah/klaim_asuransi';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function search_cif_by_account_insurance_no()
	{
		$account_insurance_no = $this->input->post('account_insurance_no');
		$data = $this->model_nasabah->search_cif_by_account_insurance_no($account_insurance_no);

		echo json_encode($data);
	}

	public function pengajuan_klaim_asuransi()
	{
		$account_insurance_no = $this->input->post('no_rekening');
		$type_claim  		  = $this->input->post('jenis_klaim');
		$date_claim 		  = $this->input->post('tgl_klaim');
		$amount_claim 		  = $this->input->post('benefit_value');
		$created_by			  = $this->session->userdata('user_id');

		//Merubah format tanggal ke dalam format Inggris
		$tgl_klaim 			=substr("$date_claim",0,2);
	    $bln_klaim 			=substr("$date_claim",2,2);
	    $thn_klaim	 		=substr("$date_claim",4,4);
	    $tglakhir_klaim		= "$thn_klaim-$bln_klaim-$tgl_klaim";  

		$data 		= array(
							'account_insurance_no'	=>$account_insurance_no,
							'date_claim'			=>$tglakhir_klaim,
							'type_claim'			=>$type_claim,
							'amount_claim'			=>$amount_claim,
							'claim_status'			=>0,
							'desc_status'			=>'Pengajuan Klaim',
							'payment_status'		=>0,
							'created_by'			=>$created_by,
							'created_date'			=>date('Y-m-d H:i:s')

						);

		$this->db->trans_begin();
		$this->model_nasabah->pengajuan_klaim_asuransi($data);
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
	// END ASURANSI KLAIM
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI KLAIM
	/****************************************************************************************/

	public function verifikasi_klaim_asuransi()
	{
		$data['container'] = 'nasabah/verifikasi_klaim_asuransi';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function datatable_verifikasi_insurance_klaim()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_insurance_claim.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name','mfi_insurance_claim.type_claim','mfi_insurance_claim.amount_claim','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Orderuing
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		else
		{
			$sWhere = "where mfi_insurance_claim.claim_status ='0'";
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_verifikasi_insurance_klaim($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_insurance_klaim($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_insurance_klaim(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_insurance_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_insurance_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['product_name'];
			if($aRow['type_claim']==0)
			{
				$type_claim="Meninggal Dunia";
			}
			else if($aRow['type_claim']==2)
			{
				$type_claim="Dana Tunai";
			}
			else if($aRow['type_claim']==3)
			{
				$type_claim="Rawat Jalan";
			}
			else if($aRow['type_claim']==4)
			{
				$type_claim="Rawat Inap";
			}
			$row[] = $type_claim;
			$row[] = $aRow['amount_claim'];
			$row[] = '<a href="javascript:;" account_insurance_id="'.$aRow['account_insurance_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_cif_by_account_insurance_id()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_nasabah->search_cif_by_account_insurance_id($account_insurance_id);

		echo json_encode($data);
	}

	public function proses_verifikasi_klaim_asuransi()
	{
		$insurance_claim_id 		= $this->input->post('insurance_claim_id');
		$approve_by 				= $this->session->userdata('user_id');
		$approve_date		  		= date('Y-m-d H:i:s');

			$data 				= array(
									'claim_status'			=>1,
									'approve_by'	 	  	=>$approve_by,
									'approve_date'	  		=>$approve_date
								 );
			$param 				= array('insurance_claim_id'=>$insurance_claim_id);

			
		$this->db->trans_begin();
		$this->model_nasabah->proses_verifikasi_klaim_asuransi($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function reject_data_klaim_asuransi()
	{
		$insurance_claim_id = $this->input->post('insurance_claim_id');

		$param = array('insurance_claim_id'=>$insurance_claim_id);

		$this->db->trans_begin();
		$this->model_nasabah->reject_data_klaim_asuransi($param);
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
	// END VERIFIKASI ASURANSI KLAIM
	/****************************************************************************************/

	/* BEGIN REGISTRASI REKENING TABUNGAN *******************************************************/
	public function registrasi_rekening_tabungan()
	{
		$data['container'] = 'transaction/registrasi_rekening_tabungan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_all_product_tabungan();
		$data['current_date'] = date("d/m/Y");
		// $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	/* END REGISTRASI REKENING TABUNGAN *******************************************************/

	/* BEGIN REGISTRASI REKENING DEPOSITO *******************************************************/
	//Fungsi Untuk Menampilakan data Deposito
	public function registrasi_rekening_deposito()
	{
		$data['container'] = 'transaction/registrasi_rekening_deposito';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_all_product();
		$this->load->view('core',$data);
	}
	/* END REGISTRASI REKENING DEPOSITO *******************************************************/

	/* BEGIN PENCAIRAN REKENING DEPOSITO *******************************************************/
	public function pencairan_deposito()
	{
		$data['container'] = 'transaction/registrasi_pencairan_deposito';
		$this->load->view('core',$data);
	}
	/* END PENCAIRAN REKENING DEPOSITO *******************************************************/

	/* BEGIN VERIFIKASI DEPOSITO *******************************************************/
	public function verifikasi_reg_deposito()
	{
		$data['container'] = 'transaction/verifikasi_reg_deposito';
		$data['product'] = $this->model_transaction->get_product_deposito();
		$data['branch'] = $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}
	/* END VERIFIKASI DEPOSITO *******************************************************/

	/* BEGIN VERIFIKASI CAIR DEPOSITO *******************************************************/
	public function verifikasi_cair_deposito()
	{
		$data['container'] = 'transaction/verifikasi_cair_deposito';
		$data['branch'] = $this->model_cif->get_all_branch();
		$data['product'] = $this->model_transaction->get_product_deposito();
		$this->load->view('core',$data);
	}
	/* END VERIFIKASI CAIR DEPOSITO *******************************************************/

	/* BEGIN PEMBIAYAAN *******************************************************/
	public function pembiayaan()
	{
		// $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['container'] 		= 'transaction/registrasi_rekening_pembiayaan';
		// $data['product'] 	= $this->model_transaction->get_product_financing();
		$date_current 			= $this->model_transaction->date_current();

		$tgl 					= substr("$date_current",8,2);
	    $bln 					= substr("$date_current",5,2);
	    $thn	 				= substr("$date_current",0,4);
	    $current_date			= "$tgl/$bln/$thn";
		$data['petugas'] 	= $this->model_transaction->get_petugas();
	    $data['date'] 			= $current_date;
	    $data['kreditur'] 		= $this->model_cif->get_list_code('kreditur');
		$data['sektor'] 		= $this->model_transaction->get_sektor();
		$data['peruntukan'] 	= $this->model_transaction->get_peruntukan();
		$data['grace'] 			= $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] 			= $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] 	= $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] 		= $this->model_transaction->get_jenis_jaminan();
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$data['resorts'] 		= $this->model_cif->get_resorts();
		$this->load->view('core',$data);
	}
	/* END PEMBIAYAAN *******************************************************/

	/* BEGIN VERIFIKASI PEMBIAYAAN *******************************************************/
	public function verifikasi_reg_pembiayaan()
	{
		$data['container'] = 'transaction/verifikasi_reg_pembiayaan';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] = $this->model_transaction->get_jenis_jaminan();
		$data['branch'] = $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}
	/* END VERIFIKASI PEMBIAYAAN *******************************************************/

	/* BEGIN ASURANSI *******************************************************/
	public function asuransi()
	{
		$data['container'] = 'transaction/asuransi';
		$data['product'] = $this->model_transaction->get_all_product_insurance();
		$data['plan'] = $this->model_transaction->get_all_insurance_plan();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}
	/* END ASURANSI *******************************************************/

	/* BEGIN VERIFIKASI ASURANSI *******************************************************/
	public function verifikasi_peserta_asuransi()
	{
		$data['container'] = 'transaction/verifikasi_peserta_asuransi';
		$data['product'] = $this->model_transaction->get_all_product_insurance();
		$data['plan'] = $this->model_transaction->get_all_insurance_plan();
		$this->load->view('core',$data);
	}
	/* END VERIFIKASI ASURANSI *******************************************************/

	/*********************************************************************************/
	// BEGIN PENGAJUAN PEMBIAYAAN 
	/*********************************************************************************/
	public function pengajuan_pembiayaan()
	{
		$data['container'] 	= 'transaction/pengajuan_pembiayaan';
		$data['petugas'] 	= $this->model_transaction->get_petugas();
		// $data['product'] = $this->model_transaction->get_product_financing();
		$date_current 		= $this->model_transaction->date_current();

		$tgl 		  = substr("$date_current",8,2);
	    $bln 		  = substr("$date_current",5,2);
	    $thn	 	  = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;

		$tgl_pencairan  = date('Y-m-d',strtotime($date_current. '+'.'7'.' days'));
		$tgl1 			= substr("$tgl_pencairan",8,2);
	    $bln1 			= substr("$tgl_pencairan",5,2);
	    $thn1	 		= substr("$tgl_pencairan",0,4);
	    $tanggal_cair	= "$tgl1/$bln1/$thn1";
	    $data['tanggal_pencairan'] = $tanggal_cair;


		$data['sektor'] = $this->model_transaction->get_sektor();
		// $data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['scoringadmkeldoc']=$this->model_cif->get_list_code('scoringadmkeldoc');
		$data['scoringpemkewman']=$this->model_cif->get_list_code('scoringpemkewman');
		$data['scoringtempatusaha']=$this->model_cif->get_list_code('scoringtempatusaha');
		$data['scoringlokasiusaha']=$this->model_cif->get_list_code('scoringlokasiusaha');
		$data['scoringkegiatanusaha']=$this->model_cif->get_list_code('scoringkegiatanusaha');
		$data['scoringhubunganusaha']=$this->model_cif->get_list_code('scoringhubunganusaha');
		$data['scoringlamaberusaha']=$this->model_cif->get_list_code('scoringlamaberusaha');
		$data['scoringhartatetap']=$this->model_cif->get_list_code('scoringhartatetap');
		$data['scoringhartalancar']=$this->model_cif->get_list_code('scoringhartalancar');
		$data['scoringpendidikan']=$this->model_cif->get_list_code('scoringpendidikan');
		$data['scoringpnglmnusaha']=$this->model_cif->get_list_code('scoringpnglmnusaha');
		$data['resorts']=$this->model_cif->get_resorts();
		$this->load->view('core',$data);
	}

	public function datatable_pengajuan_pembiayaan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','','mfi_account_financing_reg.registration_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pengajuan_pembiayaan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_pembiayaan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_pembiayaan_setup(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$aRow['status'] = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
			$label_class = $aRow['status'];

			if($aRow['flag_scoring']==0){
				$skoring_link='<div align="center">-</div>';
				$skoring_acceptation='<a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_setuju" class="btn mini green"><i class="icon-check"></i> Setujui</a> <a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_batal" class="btn mini black"><i class="icon-remove"></i> Batalkan</a> <a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_tolak" class="btn mini red"><i class="icon-remove"></i> Tolak</a></div>';
			}else{
				if($aRow['scoring_exist']==0){
					$skoring_link='<div align="center"><a href="#" class="btn mini purple" id="btnSkor" registration_no="'.$aRow['registration_no'].'">...</a></div>';
					$skoring_acceptation='<a href="javascript:;" class="btn mini"><i class="icon-check"></i> Setujui</a> <a href="javascript:;" class="btn mini"><i class="icon-remove"></i> Batalkan</a> <a href="javascript:;" class="btn mini"><i class="icon-remove"></i> Tolak</a></div>';
				}else{
					$skoring_link='<div align="center">'.$aRow['total_skor'].'</div>';
					$skoring_acceptation='<a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_setuju" class="btn mini green"><i class="icon-check"></i> Setujui</a> <a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_batal" class="btn mini black"><i class="icon-remove"></i> Batalkan</a> <a href="javascript:;" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link_tolak" class="btn mini red"><i class="icon-remove"></i> Tolak</a></div>';
				}
			}

			$resort_name='';
			if($aRow['resort_name']!=""){
				$resort_name=' <span class="btn mini green-stripe">'.$aRow['resort_name'].'</span>';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nama'].$resort_name;
			$row[] = $this->format_date_detail($aRow['tanggal_pengajuan'],'id',false,'/');
			// $row[] = $this->format_date_detail($aRow['rencana_droping'],'id',false,'/');
			$row[] = '<div align="right" style="white-space:nowrap;">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = $skoring_link;
			// $row[] = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link-edit">Edit</a>';
			// $row[] = '<div style="white-space:nowrap">'.$label_class.' '.$skoring_acceptation;
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_pengajuan_pembiayaan()
	{
		$petugas			= $this->input->post('petugas');
		$resort_code		= $this->input->post('resort_code');
		$cif_no				= $this->input->post('cif_no');
		$uang_muka			= $this->input->post('uang_muka');
		$amount				= $this->input->post('amount');
		$peruntukan			= $this->input->post('peruntukan');
		$status				= 0;
		$description		= $this->input->post('keterangan');
		$pyd				= $this->input->post('pyd');
		$product_code		= $this->input->post('product_code');

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d');
		
		$rencana_drop	 = $this->input->post('rencana_droping');
		$rencana_droping_ =str_replace("/","", $rencana_drop);
        $rencana_droping = substr($rencana_droping_,4,4).'-'.substr($rencana_droping_,2,2).'-'.substr($rencana_droping_,0,2);
		
			$data = array(
				 'cif_no'				=>$cif_no
				,'fa_code'				=>$petugas
				,'resort_code'			=>$resort_code
				,'amount'				=>$this->convert_numeric($amount)
				,'peruntukan'			=>$peruntukan
				,'rencana_droping'		=>$rencana_droping
				,'status'				=>$status
				,'description'			=>$description
				,'tanggal_pengajuan'	=>$tanggal_pengajuan
				,'product_code'			=>$product_code
				,'created_by'			=>$created_by
				,'created_date'			=>$created_date
				,'pembiayaan_ke'		=>$pyd
				,'uang_muka'			=>$this->convert_numeric($uang_muka)
				);
			

		$this->db->trans_begin();
		$this->model_nasabah->add_pengajuan_pembiayaan($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_pengajuan_pembiayaan_by_account_financing_reg_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_pengajuan_pembiayaan_by_account_financing_reg_id($account_financing_reg_id);
		$data['thp'] = $data['thp'];
		$data['thp_40'] = $data['thp']*40/100;

		$data['premi_asuransi'] = number_format($data['premi_asuransi']);
		$data['premi_asuransi_tambahan'] = number_format($data['premi_asuransi_tambahan']);
		$data['angsruan_pertama'] = number_format(($data['amount']+$data['total_margin'])/$data['jangka_waktu']);


		echo json_encode($data);
	}

	public function edit_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$petugas			= $this->input->post('petugas2');
		$resort_code		= $this->input->post('resort_code2');
		$pyd				= $this->input->post('pyd2');
		$uang_muka			= $this->input->post('uang_muka2');
		$amount				= $this->input->post('amount2');
		$peruntukan			= $this->input->post('peruntukan2');
		$description		= $this->input->post('keterangan2');
		$created_by			= $this->session->userdata('user_id');
		$product_code		= $this->input->post('product_code2');

		
		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan2');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan 	= substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);
		
		$rencana_drop	 	= $this->input->post('rencana_droping2');
		$rencana_droping_ 	= str_replace("/","", $rencana_drop);
        $rencana_droping 	= substr($rencana_droping_,4,4).'-'.substr($rencana_droping_,2,2).'-'.substr($rencana_droping_,0,2);
		
		$financing_reg = $this->model_nasabah->get_financing_reg_by_id($account_financing_reg_id);
		$product_code_old=$financing_reg['product_code'];
		$registration_no=$financing_reg['registration_no'];

		$data = array(
			'amount'				=>$this->convert_numeric($amount)
			,'fa_code'				=>$petugas
			,'resort_code'			=>$resort_code
			,'peruntukan'			=>$peruntukan
			,'rencana_droping'		=>($rencana_drop=='')?NULL:$rencana_droping
			,'description'			=>$description
			,'created_by'			=>$created_by
			,'tanggal_pengajuan'	=>$tanggal_pengajuan
			,'pembiayaan_ke'		=>$pyd
			,'product_code'			=>$product_code
			,'uang_muka'			=>$this->convert_numeric($uang_muka)
		);	

		$param = array('account_financing_reg_id'=>$account_financing_reg_id);

		/*scoring data*/
		$scoring=$this->model_nasabah->get_scoring_id_by_registration_no($registration_no);
		$scoring_id=(isset($scoring['account_financing_scoring_id'])==false)?'0':$scoring['account_financing_scoring_id'];
		$param_scoring=array('registration_no'=>$registration_no);
		$param_scoring_adm=array('account_financing_scoring_id'=>$scoring_id);
		/*scoring data*/

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		if($product_code_old!=$product_code){ //delete scoring
			$this->db->delete('mfi_account_financing_scoring',$param_scoring);
			$this->db->delete('mfi_account_financing_scoring_adm',$param_scoring_adm);
		}
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_pengajuan_pembiayaan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_reg_id) ; $i++ )
		{
			$param = array('account_financing_reg_id'=>$account_financing_reg_id[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_pengajuan_pembiayaan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	
	public function batal_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$registration_no	= $this->input->post('registration_no');

			$data = array(
				'status'				=>"3"
			);	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

			$data_score = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'));
			$param_score = array('registration_no'=>$registration_no);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		$this->model_nasabah->update_account_financing_scoring($data_score,$param_score);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function setuju_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$registration_no	= $this->input->post('registration_no');

			$data = array(
				'status'				=>"1"
			);	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

			$data_score = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'));
			$param_score = array('registration_no'=>$registration_no);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		$this->model_nasabah->update_account_financing_scoring($data_score,$param_score);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function tolak_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$registration_no	= $this->input->post('registration_no');

			$data = array(
				'status'				=>"2"
			);	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

			$data_score = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'));
			$param_score = array('registration_no'=>$registration_no);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		$this->model_nasabah->update_account_financing_scoring($data_score,$param_score);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function history_outstanding_pembiayaan()
	{
		$cif_no 			= $this->input->post('cif_no');
		$data 				= $this->model_nasabah->history_outstanding_pembiayaan($cif_no);

		echo json_encode($data);
	}

	public function get_pyd_ke()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_nasabah->get_pyd_ke($cif_no);

		$jumlah = $data['jumlah'];
		if($jumlah==null){
          $total = 0;
        }else{
          $total = $jumlah;
        }
        
        $pyd = $total+1;

		echo $pyd;
	}

	public function cek_regis_pembiayaan()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_nasabah->cek_regis_pembiayaan($cif_no);

		$jumlah = $data['jumlah'];
		if($jumlah==null){
          $total = 0;
        }else{
          $total = $jumlah;
        }

		echo $total;
	}
	/*********************************************************************************/
	// END PENGAJUAN PEMBIAYAAN 
	/*********************************************************************************/

	/****************************************************************************************/	
	// BEGIN RESCHEDULLING PEMBIAYAAN
	/****************************************************************************************/
	public function re_scheduling()
	{
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['container'] 	= 'nasabah/re_scheduling';
		$this->load->view('core',$data);
	}

	public function get_cif_for_rechedulling()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_nasabah->get_cif_for_rechedulling($account_financing_no);
		$current_date 			= $this->model_transaction->get_date_current();

		$tgl     				=substr("$current_date",8,2);
	    $bln     				=substr("$current_date",5,2);
	    $thn	        		=substr("$current_date",0,4);
	    $data['current_date']	= "$tgl/$bln/$thn";

		echo json_encode($data);
	}

	public function ajax_get_pokok_reschedull()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$pokok 				= $this->input->post('pokok');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		if($periode_angsuran=='0'){
			$tgl = $jangka_waktu.' days';
			$total_pokok = $pokok/$tgl;
		}else if($periode_angsuran=='1'){
			$tgl = $jangka_waktu.' weeks';
			$total_pokok = $pokok/$tgl;
		}else{
			$tgl = $jangka_waktu.' months';
			$total_pokok = $pokok/$tgl;
		}

		echo json_encode(array('total_pokok'=>$total_pokok));
	}

	public function ajax_get_margin_reschedull()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$margin 				= $this->input->post('margin');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		if($periode_angsuran=='0'){
			$tgl = $jangka_waktu.' days';
			$total_margin = $margin/$tgl;
		}else if($periode_angsuran=='1'){
			$tgl = $jangka_waktu.' weeks';
			$total_margin = $margin/$tgl;
		}else{
			$tgl = $jangka_waktu.' months';
			$total_margin = $margin/$tgl;
		}

		echo json_encode(array('total_margin'=>$total_margin));
	}

	public function proses_reschedulling()
	{
		$cif_no 					= $this->input->post('cif_no_o');
		$product_code				= $this->input->post('product_code_o');
		$branch_code				= $this->input->post('branch_code_o');
		$account_financing_no 		= $this->input->post('no_rekening');
		$jangka_waktu_o 			= $this->input->post('jangka_waktu_o');
		$jangka_waktu_n 			= $this->input->post('jangka_waktu');
		$periode_jangka_waktu_o		= $this->input->post('periode_jangka_waktu_o');
		$periode_jangka_waktu_n		= $this->input->post('periode_angsuran');
		$pokok_o 					= $this->input->post('pokok_o');
		if($pokok_o!="")
		{
			$pokok_o_ = $this->input->post('pokok_o');
		}
		else
		{
			$pokok_o_ = "0";
		}

		$pokok_n 					= $this->input->post('dana_sendiri');
		if($pokok_n!="")
		{
			$pokok_n_ = $this->input->post('dana_sendiri');
		}
		else
		{
			$pokok_n_ = "0";
		}

		$margin_o 					= $this->input->post('margin_o');
		if($margin_o!="")
		{
			$margin_o_ = $this->input->post('margin_o');
		}
		else
		{
			$margin_o_ = "0";
		}

		$margin_n 					= $this->input->post('margin');
		if($margin_n!="")
		{
			$margin_n_ = $this->input->post('margin');
		}
		else
		{
			$margin_n_ = "0";
		}

		$angsuran_pokok_o			= $this->input->post('angsuran_pokok_o');
		if($angsuran_pokok_o!="")
		{
			$angsuran_pokok_o_ = $this->input->post('angsuran_pokok_o');
		}
		else
		{
			$angsuran_pokok_o_ = "0";
		}

		$angsuran_pokok_n			= $this->input->post('nilai_pembiayaan');
		if($angsuran_pokok_n!="")
		{
			$angsuran_pokok_n_ = $this->input->post('nilai_pembiayaan');
		}
		else
		{
			$angsuran_pokok_n_ = "0";
		}

		$angsuran_margin_o			= $this->input->post('angsuran_margin_o');
		if($angsuran_margin_o!="")
		{
			$angsuran_margin_o_ = $this->input->post('angsuran_margin_o');
		}
		else
		{
			$angsuran_margin_o_ = "0";
		}

		$angsuran_margin_n			= $this->input->post('margin_pembiayaan');
		if($angsuran_margin_n!="")
		{
			$angsuran_margin_n_ = $this->input->post('margin_pembiayaan');
		}
		else
		{
			$angsuran_margin_n_ = "0";
		}

		$angsuran_catab_o			= $this->input->post('angsuran_catab_o');
		if($angsuran_catab_o!="")
		{
			$angsuran_catab_o_ = $this->input->post('angsuran_catab_o');
		}
		else
		{
			$angsuran_catab_o_ = "0";
		}

		$angsuran_catab_n			= $this->input->post('catab');
		if($angsuran_catab_n!="")
		{
			$angsuran_catab_n_ = $this->input->post('catab');
		}
		else
		{
			$angsuran_catab_n_ = "0";
		}

		$saldo_pokok_o				= $this->input->post('saldo_pokok_o');
		if($saldo_pokok_o!="")
		{
			$saldo_pokok_o_ = $this->input->post('saldo_pokok_o');
		}
		else
		{
			$saldo_pokok_o_ = "0";
		}

		$saldo_margin_o				= $this->input->post('saldo_margin_o');
		if($saldo_margin_o!="")
		{
			$saldo_margin_o_ = $this->input->post('saldo_margin_o');
		}
		else
		{
			$saldo_margin_o_ = "0";
		}

		$saldo_catab_o				= $this->input->post('angsuran_catab_o');
		if($saldo_catab_o!="")
		{
			$saldo_catab_o_ = $this->input->post('angsuran_catab_o');
		}
		else
		{
			$saldo_catab_o_ = "0";
		}

		$tanggal_akad_o				= $this->input->post('tanggal_akad_o');
		$tanggal_akad_o 			= str_replace('/', '', $tanggal_akad_o);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_akad 					=substr("$tanggal_akad_o",0,2);
	    $bln_akad 					=substr("$tanggal_akad_o",2,2);
	    $thn_akad 					=substr("$tanggal_akad_o",4,4);
	    $tglakhir_akad 				= "$thn_akad-$bln_akad-$tgl_akad";  

		$tangal_reschedule			= $this->input->post('tgl_pembaharuan');
		$tangal_reschedule 			= str_replace('/', '', $tangal_reschedule);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_re 					=substr("$tangal_reschedule",0,2);
	    $bln_re 					=substr("$tangal_reschedule",2,2);
	    $thn_re 					=substr("$tangal_reschedule",4,4);
	    $tglakhir_re 				= "$thn_re-$bln_re-$tgl_re";  

		$tanggal_mulai_angsur_o		= $this->input->post('tanggal_mulai_angsur_o');
		$tanggal_mulai_angsur_o 	= str_replace('/', '', $tanggal_mulai_angsur_o);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_mulai_angsur_o 		=substr("$tanggal_mulai_angsur_o",0,2);
	    $bln_mulai_angsur_o 		=substr("$tanggal_mulai_angsur_o",2,2);
	    $thn_mulai_angsur_o			=substr("$tanggal_mulai_angsur_o",4,4);
	    $tglakhir_mulai_angsur_o 	= "$thn_mulai_angsur_o-$bln_mulai_angsur_o-$tgl_mulai_angsur_o";  

		$tanggal_mulai_angsur_n		= $this->input->post('tgl_angsur');
		$tanggal_mulai_angsur_n 	= str_replace('/', '', $tanggal_mulai_angsur_n);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_mulai_angsur_n 		=substr("$tanggal_mulai_angsur_n",0,2);
	    $bln_mulai_angsur_n 		=substr("$tanggal_mulai_angsur_n",2,2);
	    $thn_mulai_angsur_n 		=substr("$tanggal_mulai_angsur_n",4,4);
	    $tglakhir_mulai_angsur_n 	= "$thn_mulai_angsur_n-$bln_mulai_angsur_n-$tgl_mulai_angsur_n";  

		$tanggal_jtempo_o			= $this->input->post('tanggal_jtempo_o');
		$tanggal_jtempo_o 			= str_replace('/', '', $tanggal_jtempo_o);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_jtempo_o 				=substr("$tanggal_jtempo_o",0,2);
	    $bln_jtempo_o 				=substr("$tanggal_jtempo_o",2,2);
	    $thn_jtempo_o 				=substr("$tanggal_jtempo_o",4,4);
	    $tglakhir_jtempo_o 			= "$thn_jtempo_o-$bln_jtempo_o-$tgl_jtempo_o";  

		$tanggal_jtempo_n			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo_n 			= str_replace('/', '', $tanggal_jtempo_n);
		//Merubah format tanggal ke dalam format Inggris Untuk tanggal Akad
		$tgl_jtempo_n 				=substr("$tanggal_jtempo_n",0,2);
	    $bln_jtempo_n 				=substr("$tanggal_jtempo_n",2,2);
	    $thn_jtempo_n 				=substr("$tanggal_jtempo_n",4,4);
	    $tglakhir_jtempo_n 			= "$thn_jtempo_n-$bln_jtempo_n-$tgl_jtempo_n";  

		$reschedul_ke				= $this->input->post('pembaharuan_ke');
		$created_by					= $this->session->userdata('user_id');
		$created_date				= date('Y-m-d H:i:s');

		$data = array(
					'product_code'				=>$product_code
					,'cif_no'					=>$cif_no
					,'branch_code'				=>$branch_code
					,'account_financing_no'		=>$account_financing_no
					,'jangka_waktu_o'			=>$jangka_waktu_o
					,'jangka_waktu_n'			=>$jangka_waktu_n
					,'periode_jangka_waktu_o'	=>$periode_jangka_waktu_o
					,'periode_jangka_waktu_n'	=>$periode_jangka_waktu_n
					,'pokok_o'					=>$this->convert_numeric($pokok_o_)
					,'pokok_n'					=>$this->convert_numeric($pokok_n_)
					,'margin_o'					=>$this->convert_numeric($margin_o_)
					,'margin_n'					=>$this->convert_numeric($margin_n_)
					,'angsuran_pokok_o'			=>$this->convert_numeric($angsuran_pokok_o_)
					,'angsuran_pokok_n'			=>$this->convert_numeric($angsuran_pokok_n_)
					,'angsuran_margin_o'		=>$this->convert_numeric($angsuran_margin_o_)
					,'angsuran_margin_n'		=>$this->convert_numeric($angsuran_margin_n_)
					,'angsuran_catab_o'			=>$this->convert_numeric($angsuran_catab_o_)
					,'angsuran_catab_n'			=>$this->convert_numeric($angsuran_catab_n_)
					,'saldo_pokok_o'			=>$this->convert_numeric($saldo_pokok_o_)
					,'saldo_margin_o'			=>$this->convert_numeric($saldo_margin_o_)
					,'saldo_catab_o'			=>$this->convert_numeric($saldo_catab_o_)
					,'tanggal_akad_o'			=>$tglakhir_akad
					,'tangal_reschedule'		=>$tglakhir_re
					,'tanggal_mulai_angsur_o'	=>$tglakhir_mulai_angsur_o
					,'tanggal_mulai_angsur_n'	=>$tglakhir_mulai_angsur_n
					,'tanggal_jtempo_o'			=>$tglakhir_jtempo_o
					,'tanggal_jtempo_n'			=>$tglakhir_jtempo_n
					,'reschedul_ke'				=>$reschedul_ke
					,'created_by'				=>$created_by
					,'created_date'				=>$created_date
				);

		$this->db->trans_begin();
		$this->model_nasabah->proses_reschedulling($data);
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
	// END RESCHEDULLING PEMBIAYAAN
	/****************************************************************************************/
	

	/* GET PROGRAM KHUSUS BY KREDITUR */	
	function get_program_khusus()
	{
		$program_owner_code = $this->input->post('program_owner_code');
		$data = $this->model_nasabah->get_program_khusus_by_program_owner_code($program_owner_code);

		echo json_encode($data);
	}



	/****************************************************************************************/	
	// BEGIN PENCAIRAN TABUNGAN Ade 14072014
	/****************************************************************************************/
	public function pencairan_tabungan()
	{

		$data['container'] = 'nasabah/pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function proses_pencairan_tabungan()
	{
		$account_saving_no 	= $this->input->post('no_rekening');
		$saldo_memo 		= $this->convert_numeric($this->input->post('saldo_memo'));
		$trx_detail_id 		= uuid(false);
		$saving 			= $this->model_nasabah->get_account_saving($account_saving_no);

		$counter_angsruan = $saving['counter_angsruan'];
		$rencana_jangka_waktu = $saving['rencana_jangka_waktu'];

		if($counter_angsruan==$rencana_jangka_waktu){
			$flag_pencairan = 1;
		}else{
			$flag_pencairan = 2;
		}

		$data = array(
				'status_rekening'	=>3
			);

		$data_trx_account_saving = array(
				'branch_id' => $this->session->userdata('branch_id')
				,'account_saving_no' => $account_saving_no
				,'trx_saving_type' => 5 // tutup rekening
				,'flag_debit_credit' => 'D'
				,'trx_date' => date('Y-m-d')
				,'amount' => $saldo_memo
				,'created_date' => date('Y-m-d')
				,'created_by' => $this->session->userdata('username')
				,'description' => 'pencairan tabungan sekaligus penutupan rekening'
				,'trx_status' => 0
				,'trx_detail_id' => $trx_detail_id
				,'flag_pencairan'=>$flag_pencairan
			);

		$data_trx_detail = array(
				 'trx_detail_id' => $trx_detail_id
				,'trx_type' => 1
				,'trx_account_type' => 5 // tutup rekening
				,'account_no' => $account_saving_no
				,'flag_debit_credit' => 'D'
				,'amount' => $saldo_memo
				,'trx_date' => date('Y-m-d')
				,'description' => 'pencairan tabungan sekaligus penutupan rekening'
				,'created_by' => $this->session->userdata('username')
				,'created_date' => date('Y-m-d')
			);

		$param = array('account_saving_no'=>$account_saving_no);

		$this->db->trans_begin();
		$this->model_nasabah->proses_pencairan_tabungan($data,$param);
		$this->model_nasabah->insert_mfi_trx_detail($data_trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function reject_pencairan_tabungan()
	{
		$account_saving_no 			= $this->input->post('no_rekening');
		$trx_account_saving_id 			= $this->input->post('trx_account_saving_id');

		$trx_saving = $this->model_nasabah->get_trx_saving_by_id($trx_account_saving_id);
		$trx_detail_id=$trx_saving['trx_detail_id'];

		$data = array(
			'status_rekening' => 1
		);

		$param = array('account_saving_no'=>$account_saving_no);
		$param2 = array('trx_account_saving_id'=>$trx_account_saving_id);
		$param3 = array('trx_detail_id'=>$trx_detail_id);
		$this->db->trans_begin();
		$this->model_nasabah->proses_pencairan_tabungan($data,$param);
		$this->model_nasabah->delete_trx_account_saving($param2);
		$this->model_nasabah->delete_trx_detail($param3);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function verifikasi_pencairan_tabungan()
	{
		$data['container'] = 'nasabah/verifikasi_pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['branch'] = $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}

	public function grid_verifikasi_pencairan_tabungan()
	{
		$page 			= isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows 	= isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx 			= isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
		$sort 			= isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$branch_id 		= isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:'';
		$cm_name 		= isset($_REQUEST['cm_name'])?$_REQUEST['cm_name']:'';
		$nama 			= isset($_REQUEST['nama'])?$_REQUEST['nama']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_nasabah->grid_verifikasi_pencairan_tabungan('','','','',$branch_id,$cm_name,$nama);//2

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_nasabah->grid_verifikasi_pencairan_tabungan($sidx,$sort,$limit_rows,$start,$branch_id,$cm_name,$nama);//3

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['account_saving_no']=$row['account_saving_no'];
		    $responce['rows'][$i]['cell']=array(
			     $row['branch_name']
			    ,$row['cm_name']
			    ,$row['account_saving_no']
			    ,$row['nama']
			    ,$row['saldo_memo']
			    ,$row['trx_account_saving_id']
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	public function proses_verifikasi_pencairan_tabungan()
	{
	    $cif_no 					= $this->input->post('cif_no');
	    $cif_type 					= $this->input->post('cif_type');
	    $trx_account_saving_id 		= $this->input->post('trx_account_saving_id');
	    $no_rekening 				= $this->input->post('no_rekening');
	    $no_rekening_individu 		= $this->input->post('no_rekening_individu');
	    $pencairan_ke 				= $this->input->post('pencairan_ke');
	    $saldo_memo 				= $this->input->post('saldo_memo');
	    $saldo_memo 				= $this->convert_numeric($saldo_memo);
	    $jumlah_penarikan 			= $this->input->post('jumlah_penarikan');
	    $jumlah_penarikan 			= $this->convert_numeric($jumlah_penarikan);

	    $cif = $this->model_transaction->get_saldo_tab_sukarela($cif_no);

			//di cek nomor rekeningnya
			//individu atau kelompok
			if($cif_type=='0'){ // tabungan berencana
				$data_balance = array('tabungan_sukarela'=>$cif['tabungan_sukarela']+$jumlah_penarikan);
				$param_balance = array('cif_no'=>$cif_no);

				$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
				$param_saving = array('account_saving_no'=>$no_rekening);

				$this->db->trans_begin();
				$this->model_nasabah->update_default_balance($data_balance,$param_balance);
				$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');

					$data_trx_account_saving = array(
						'verify_by' => $this->session->userdata('username')
						,'verify_date'=>date('Y-m-d')
						,'trx_status' => 1
					);

					$param_trx_account_saving = array(
						'trx_account_saving_id' => $trx_account_saving_id
					);

					$this->db->trans_begin();
					$this->model_nasabah->update_mfi_trx_account_saving($data_trx_account_saving,$param_trx_account_saving);
					$this->model_transaction->fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id);
					if($this->db->trans_status()===true){
						$this->db->trans_commit();
					}else{
						$this->db->trans_rollback();
					}

				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
				}
			}else if($cif_type=='1'){
				if($no_rekening_individu!=""){ //validate nomor rekening tujuan
					$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
					$param_saving = array('account_saving_no'=>$no_rekening);
					$data_saving_tujuan = array('saldo_memo'=>$saving['saldo_memo']+$saldo_memo);
					$param_saving_tujuan = array('account_saving_no'=>$no_rekening_individu);

					$data_trx_account_saving = array(
						'verify_by' => $this->session->userdata('username')
						,'verify_date'=>date('Y-m-d')
						,'trx_status' => 1
					);

					$param_trx_account_saving = array(
						'trx_account_saving_id' => $trx_account_saving_id
					);
					
					$this->db->trans_begin();
					$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
					$this->model_transaction->update_account_saving($data_saving_tujuan,$param_saving_tujuan); // update tabungan berencana tujuan
					$this->model_nasabah->update_mfi_trx_account_saving($data_trx_account_saving,$param_trx_account_saving);
					$this->model_transaction->fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id);
					if($this->db->trans_status()===true){
						$this->db->trans_commit();
						$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');
					}else{
						$this->db->trans_rollback();
						$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
					}
				}
			}else{
	    		$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
			}

	    echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PENCAIRAN TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN CETAK AKAD PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/
	public function cetak_akad_pembiayaan()
	{
		$data['container'] = 'nasabah/cetak_akad_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['saksi1'] = $this->model_nasabah->get_list_saksi1();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END CETAK AKAD PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/

	public function proses_scoring_pembiayaan()
	{
	    $registration_no = $this->input->post('registration_no');
	    $scoringadmkeldoc = $this->input->post('scoringadmkeldoc');
	    $scoringpendidikan = $this->input->post('scoringpendidikan');
	    $scoringpemkewman = $this->input->post('scoringpemkewman');
	    $scoringpnglmnusaha = $this->input->post('scoringpnglmnusaha');
	    $scoringtempatusaha = $this->input->post('scoringtempatusaha');
	    $scoringlokasiusaha = $this->input->post('scoringlokasiusaha');
	    $scoringkegiatanusaha = $this->input->post('scoringkegiatanusaha');
	    $scoringhubunganusaha = $this->input->post('scoringhubunganusaha');
	    $scoringlamaberusaha = $this->input->post('scoringlamaberusaha');
	    $scoringhartatetap = $this->input->post('scoringhartatetap');
	    $scoringhartalancar = $this->input->post('scoringhartalancar');
	    $total_skor = $this->input->post('total_skor');

	    $account_financing_scoring_id=uuid(false);

	    $data=array(
	    	'account_financing_scoring_id'=>$account_financing_scoring_id
			,'registration_no'=> $registration_no
			,'pendidikan'=>$scoringpendidikan
			,'pemkewman'=>$scoringpemkewman
			,'pnglmnusaha'=>$scoringpnglmnusaha
			,'tempatusaha'=>$scoringtempatusaha
			,'lokasiusaha'=>$scoringlokasiusaha
			,'kegiatanusaha'=>$scoringkegiatanusaha
			,'hubunganusaha'=>$scoringhubunganusaha
			,'lamaberusaha'=>$scoringlamaberusaha
			,'hartatetap'=>$scoringhartatetap
			,'hartalancar'=>$scoringhartalancar
			,'total_skor'=>$total_skor
			,'created_by'=>$this->session->userdata('user_id')
			,'created_date'=>date('Y-m-d H:i:s')
		);

	    $data_adm=array();
	    for($i=0;$i<count($scoringadmkeldoc);$i++){
	    	$data_adm[]=array(
	    			'account_financing_scoring_id'=>$account_financing_scoring_id
	    		    ,'administrasi_value'=>$scoringadmkeldoc[$i]
	    		);
	    }

		$this->db->trans_begin();
		$this->model_nasabah->insert_account_financing_scoring($data);
		if(count($data_adm)>0){
			$this->model_nasabah->insert_account_financing_scoring_adm($data_adm);
		}
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return=array('success'=>false);
		}
		echo json_encode($return);

	}
	

	/**********************************************************************************************/
	//Tambahan Ade 11092014 pas begadang Verifikasi Pengajuan Pembiayaan
	/**********************************************************************************************/
	public function pengajuan_pembiayaan_verifikasi()
	{
		$data['container'] 	= 'transaction/pengajuan_pembiayaan_verifikasi';
		// $data['product'] = $this->model_transaction->get_product_financing();
		$date_current 		= $this->model_transaction->date_current();

		$tgl 		  = substr("$date_current",8,2);
	    $bln 		  = substr("$date_current",5,2);
	    $thn	 	  = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;

		$tgl_pencairan  = date('Y-m-d',strtotime($date_current. '+'.'7'.' days'));
		$tgl1 			= substr("$tgl_pencairan",8,2);
	    $bln1 			= substr("$tgl_pencairan",5,2);
	    $thn1	 		= substr("$tgl_pencairan",0,4);
	    $tanggal_cair	= "$tgl1/$bln1/$thn1";
	    $data['tanggal_pencairan'] = $tanggal_cair;


		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);
	}

	public function datatable_pengajuan_pembiayaan_verifikasiOld()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_financing_reg.registration_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.rencana_droping','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pengajuan_pembiayaan_verifikasi($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_pembiayaan_verifikasi($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_pembiayaan_verifikasi(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$flag_scoring=0;
			if($aRow['flag_scoring']==0){ //tidak menggunakan scoring
				$skoring_link='<div align="center">-</div>';
			}else{
				if($aRow['scoring_exist']==0){ // scoring belum di lakukan
					$skoring_link='<div align="center">-</div>';
				}else{
					$skoring_link='<div align="center">'.$aRow['total_skor'].'</div>';
					$flag_scoring=1;
				}
			}
			$aRow['status'] = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-ok-sign"></i> Appove</a>';
			$label_class = $aRow['status'];
			
			$resort_name='';
			if($aRow['resort_name']!=""){
				$resort_name=' <span class="btn mini green-stripe">'.$aRow['resort_name'].'</span>';
			}
			
			$row = array();
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nama'].$resort_name;
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = date('d-m-Y',strtotime($aRow['rencana_droping']));
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = $skoring_link;
			$row[] = '<div style="white-space:nowrap">'.$label_class;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function act_tolak_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$cif_no	= $this->input->post('cif_no');

			$data = array('status'=>"2",'approve_date'=>date("Y-m-d H:i:s"));	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function act_batal_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$cif_no	= $this->input->post('cif_no');

			$data = array(
				'status'				=>"3"
				,'approve_date'=>date("Y-m-d H:i:s")
			);	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function act_approve_pengajuan_pembiayaanTam()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$cif_no	= $this->input->post('cif_no');

		$provisi_pembiayaan	= $this->convert_numeric($this->input->post('provisi_pembiayaan'));
		$biaya_administrasi	= $this->convert_numeric($this->input->post('biaya_administrasi'));
		$biaya_notaris	= $this->convert_numeric($this->input->post('biaya_notaris'));
		$biaya_apht	= $this->convert_numeric($this->input->post('biaya_apht'));

			$data = array(
				'status'				=>"1"
				,'approve_date'=>date("Y-m-d H:i:s")
				,'provisi_pembiayaan'=>$provisi_pembiayaan
				,'biaya_administrasi'=>$biaya_administrasi
				,'biaya_notaris'=>$biaya_notaris
				,'biaya_apht'=>$biaya_apht
			);	

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/**********************************************************************************************/
	//END Tambahan Ade 11092014 Verifikasi Pengajuan Pembiayaan
	/**********************************************************************************************/

	/****************************************************************************************/	
	// BEGIN CETAK PERSETUJUAN PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/
	public function cetak_persetujuan_pembiayaan()
	{
		$data['container'] = 'nasabah/cetak_persetujuan_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END CETAK PERSETUJUAN PEMBIAYAAN Ade Sagita 18-08-2014
	/****************************************************************************************/

	/*
	Modul update cetak akad pembiyaan
	author : Ujang Irawan
	date : 10-10-2014 16:20
	*/
	public function update_data_financing_for_akad()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		// $status_anggota = $this->input->post('status_anggota');
		// $menyetujui = $this->input->post('menyetujui');
		$saksi1 = $this->input->post('saksi1');
		// $saksi2 = $this->input->post('saksi2');

		$data = array(
				// 'status_anggota' => $status_anggota,
				// 'menyetujui' => $saksi1,
				'saksi1' => $saksi1
				// 'saksi2' => $saksi2
			);

		$param = array('account_financing_id'=>$account_financing_id);

		$this->db->trans_begin();
		$this->model_nasabah->update_data_financing_for_akad($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/*************************************************************************************************/
	//CETAK HASIL SCORING
	public function cetak_hasil_scoring()
	{
		$data['container'] = 'nasabah/cetak_hasil_scoring';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}
	public function search_cif_for_cetak_hasil_scoring()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_nasabah->search_cif_for_cetak_hasil_scoring($keyword);

		echo json_encode($data);
	}
	public function get_cif_by_account_financing_reg_scoring()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_cif_by_account_financing_reg_scoring($account_financing_reg_id);
		$data['tanggal_pengajuan'] = date("d-m-Y",strtotime($data['tanggal_pengajuan']));

		echo json_encode($data);
	}
	//END CETAK HASIL SCORING
	/*************************************************************************************************/

	public function koreksi_droping()
	{
		$data['title'] = "Koreksi Droping Pembiayaan";
		$data['container'] = 'nasabah/koreksi_droping';
		$data['sektor'] 		= $this->model_transaction->get_sektor();
		$data['peruntukan'] 	= $this->model_transaction->get_peruntukan();
		$data['jenis_program'] 	= $this->model_transaction->get_jenis_program_financing();
		$data['jaminan'] 		= $this->model_transaction->get_jenis_jaminan();
		$data['petugas'] 		= $this->model_transaction->get_petugas();
		$data['resorts'] 		= $this->model_cif->get_resorts();
		$this->load->view('core',$data);
	}

	public function search_account_financing_no()
	{
		$keyword = $this->input->post('keyword');
		$status_rekening = $this->input->post('status_rekening');

		$data = $this->model_nasabah->search_account_financing_no($keyword,$status_rekening);

		echo json_encode($data);
	}

	public function get_tanggal_mulai_angsur()
	{
		$tanggal_droping=$this->input->post('tanggal_droping');
		$periode_jangka_waktu=$this->input->post('periode_jangka_waktu');

		/*convert tanggal_droping*/
		$tanggal_droping = $this->datepicker_convert(true,$tanggal_droping,'/');
		
		switch ($periode_jangka_waktu) {
			case '0';
			$tanggal_mulai_angsur=date('Y-m-d',strtotime($tanggal_droping." +1 day"));
			break;
			case '1';
			$tanggal_mulai_angsur=date('Y-m-d',strtotime($tanggal_droping." +1 week"));
			break;
			case '2';
			$tanggal_mulai_angsur=date('Y-m-d',strtotime($tanggal_droping." +1 month"));
			break;
			case '3';
			$tanggal_mulai_angsur='';
			break;
		}
		echo json_encode(array('tanggal_mulai_angsur'=>$tanggal_mulai_angsur));
	}

	public function get_tanggal_jatuh_tempo()
	{
		$tanggal_droping=$this->input->post('tanggal_droping');
		$jangka_waktu=(int)$this->input->post('jangka_waktu');
		$periode_jangka_waktu=$this->input->post('periode_jangka_waktu');

		/*convert tanggal_droping*/
		$tanggal_droping = $this->datepicker_convert(true,$tanggal_droping,'/');

		switch ($periode_jangka_waktu) {
			case '0';
			$tanggal_jtempo=date('Y-m-d',strtotime($tanggal_droping." +".$jangka_waktu." day"));
			break;
			case '1';
			$tanggal_jtempo=date('Y-m-d',strtotime($tanggal_droping." +".$jangka_waktu." week"));
			break;
			case '2';
			$tanggal_jtempo=date('Y-m-d',strtotime($tanggal_droping." +".$jangka_waktu." month"));
			break;
			case '3';
			$tanggal_jtempo='';
			break;
		}
		echo json_encode(array('tanggal_jtempo'=>$tanggal_jtempo));
	}

	public function proses_koreksi_droping()
	{
		$account_financing_no = $this->input->post('account_financing_no');
	    
	    $pokok = $this->convert_numeric($this->input->post('pokok'));
	    $margin = $this->convert_numeric($this->input->post('margin'));
	    $jangka_waktu = $this->input->post('jangka_waktu');
	    $tanggal_droping = $this->datepicker_convert(true,$this->input->post('tanggal_droping'),'/');
	    $tanggal_mulai_angsur = $this->datepicker_convert(true,$this->input->post('tanggal_mulai_angsur'),'/');
	    $tanggal_jtempo = $this->datepicker_convert(true,$this->input->post('tanggal_jtempo'),'/');
	    $angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
	    $angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
	    // ------------------------------- new
	    $uang_muka = $this->convert_numeric($this->input->post('uangmuka'));
	    $titipan_notaris = $this->convert_numeric($this->input->post('titipannotaris'));
	    $periode_jangka_waktu = $this->input->post('periode_jangka_waktu');
	    $angsuran_catab = $this->convert_numeric($this->input->post('angsurancatab'));
	    $simpanan_wajib_pinjam = $this->convert_numeric($this->input->post('simpananwajibpinjam'));
	    $biaya_administrasi = $this->convert_numeric($this->input->post('biayaadministrasi'));
	    $biaya_jasa_layanan = $this->convert_numeric($this->input->post('biayajasalayanan'));
	    $biaya_notaris = $this->convert_numeric($this->input->post('biayanotaris'));
	    $biaya_asuransi_jiwa = $this->convert_numeric($this->input->post('premiasuransijiwa'));
	    $biaya_asuransi_jaminan = $this->convert_numeric($this->input->post('premiasuransijaminan'));
	    $jenis_jaminan = $this->input->post('jaminanprimer');
	    $keterangan_jaminan = $this->input->post('ketjaminanprimer');
	    $jumlah_jaminan = $this->input->post('jmljaminanprimer');
	    $nominal_taksasi = $this->convert_numeric($this->input->post('nominaljaminanprimer'));
	    $presentasi_jaminan = $this->input->post('presentasejaminanprimer');
	    $jenis_jaminan_sekunder = $this->input->post('jaminansekunder');
	    $keterangan_jaminan_sekunder = $this->input->post('ketjaminansekunder');
	    $jumlah_jaminan_sekunder = $this->input->post('jmljaminansekunder');
	    $nominal_taksasi_sekunder = $this->convert_numeric($this->input->post('nominaljaminansekunder'));
	    $presentasi_jaminan_sekunder = $this->input->post('presentasejaminansekunder');
	    $sektor_ekonomi = $this->input->post('sektorekonomi');
	    $peruntukan = $this->input->post('peruntukanpembiayaan');
	    $flag_wakalah = $this->input->post('flagwakalah');
	    $fa_code_o = $this->input->post('fa_code_o');
	    $resort_code_o = $this->input->post('resort_code_o');
	    
	    $pokok2 = $this->convert_numeric($this->input->post('pokok2'));
	    $margin2 = $this->convert_numeric($this->input->post('margin2'));
	    $jangka_waktu2 = $this->input->post('jangka_waktu2');
	    $tanggal_droping2 = $this->datepicker_convert(true,$this->input->post('tanggal_droping2'),'/');
	    $tanggal_mulai_angsur2 = $this->datepicker_convert(true,$this->input->post('tanggal_mulai_angsur2'),'/');
	    $tanggal_jtempo2 = $this->datepicker_convert(true,$this->input->post('tanggal_jtempo2'),'/');
	    $angsuran_pokok2 = $this->convert_numeric($this->input->post('angsuran_pokok2'));
	    $angsuran_margin2 = $this->convert_numeric($this->input->post('angsuran_margin2'));
	    // ------------------------------- new
	    $uang_muka2 = $this->convert_numeric($this->input->post('uangmuka2'));
	    $titipan_notaris2 = $this->convert_numeric($this->input->post('titipannotaris2'));
	    $periode_jangka_waktu2 = $this->input->post('periode_jangka_waktu2');
	    $angsuran_catab2 = $this->convert_numeric($this->input->post('angsurancatab2'));
	    $simpanan_wajib_pinjam2 = $this->convert_numeric($this->input->post('simpananwajibpinjam2'));
	    $biaya_administrasi2 = $this->convert_numeric($this->input->post('biayaadministrasi2'));
	    $biaya_jasa_layanan2 = $this->convert_numeric($this->input->post('biayajasalayanan2'));
	    $biaya_notaris2 = $this->convert_numeric($this->input->post('biayanotaris2'));
	    $biaya_asuransi_jiwa2 = $this->convert_numeric($this->input->post('premiasuransijiwa2'));
	    $biaya_asuransi_jaminan2 = $this->convert_numeric($this->input->post('premiasuransijaminan2'));
	    $jenis_jaminan2 = $this->input->post('jaminanprimer2');
	    $keterangan_jaminan2 = $this->input->post('ketjaminanprimer2');
	    $jumlah_jaminan2 = $this->input->post('jmljaminanprimer2');
	    $nominal_taksasi2 = $this->convert_numeric($this->input->post('nominaljaminanprimer2'));
	    $presentasi_jaminan2 = $this->input->post('presentasejaminanprimer2');
	    $jenis_jaminan_sekunder2 = $this->input->post('jaminansekunder2');
	    $keterangan_jaminan_sekunder2 = $this->input->post('ketjaminansekunder2');
	    $jumlah_jaminan_sekunder2 = $this->input->post('jmljaminansekunder2');
	    $nominal_taksasi_sekunder2 = $this->convert_numeric($this->input->post('nominaljaminansekunder2'));
	    $presentasi_jaminan_sekunder2 = $this->input->post('presentasejaminansekunder2');
	    $sektor_ekonomi2 = $this->input->post('sektorekonomi2');
	    $peruntukan2 = $this->input->post('peruntukanpembiayaan2');
	    $flag_wakalah2 = $this->input->post('flagwakalah2');
	    $fa_code_n = $this->input->post('fa_code_n');
	    $resort_code_n = $this->input->post('resort_code_n');
	    //----------------new 14-02-2015
	    $jml_angsuran = $this->input->post('jml_angsuran');
	    $desc_peruntukan2 = $this->input->post('desc_peruntukan2');

	    $bValid=true;
	    $debug=false;

	    /*
	    /-----------new 14-12-2015 palentin saurna mah :D
	    /jika jml_angsuran lebih dari 0 maka hanya data jaminan dan peruntukan yg bisa diupdate
	    */
	    if ($jml_angsuran>0) {

		    /*
		    | updating mfi_account_financing_reg (desc peruntukan) //----------------new 14-02-2015
		    */
		    if($bValid==true)
		    {
			    $registration_no = $this->input->post('registration_no');
			    $desc_peruntukan = $this->input->post('desc_peruntukan');
			    $desc_peruntukan2 = $this->input->post('desc_peruntukan2');

			    if($desc_peruntukan!=$desc_peruntukan2){ //do update description

			    	$raw_account_financing_reg = array ( 'description' => $desc_peruntukan2 );
			    	$param_account_financing_reg = array ( 'registration_no' => $registration_no );


			    	if($debug==true)
			    	{
			    		echo "<pre>";
			    		print_r($raw_account_financing_reg);
			    		print_r($param_account_financing_reg);
			    	}
			    	else
			    	{
				    	$this->db->trans_begin();
				    	$this->db->update('mfi_account_financing_reg',$raw_account_financing_reg,$param_account_financing_reg);
				    	if($this->db->trans_status()===true){
				    		$this->db->trans_commit();
				    	}else{
				    		$this->db->trans_rollback();
				    		$bValid=false;
				    		$error_state = 1;
				    	}
				    }
				}

		    }
		    /*
		    | updating mfi_account_financing (data non nominal) //----------------new 14-02-2015
		    */
		    if($bValid==true)
		    {
		    	$raw_account_financing = array ( 		    									
												 'jenis_jaminan'=>($jenis_jaminan2=="")?NULL:$jenis_jaminan2
												,'keterangan_jaminan'=>($keterangan_jaminan2=="")?NULL:$keterangan_jaminan2
												,'jumlah_jaminan'=>($jumlah_jaminan2=="")?NULL:$jumlah_jaminan2
												,'nominal_taksasi'=>($nominal_taksasi2=="")?NULL:$nominal_taksasi2
												,'presentase_jaminan'=>($presentasi_jaminan2=="")?NULL:$presentasi_jaminan2
												,'jenis_jaminan_sekunder'=>($jenis_jaminan_sekunder2=="")?NULL:$jenis_jaminan_sekunder2
												,'keterangan_jaminan_sekunder'=>($keterangan_jaminan_sekunder2=="")?NULL:$keterangan_jaminan_sekunder2
												,'jumlah_jaminan_sekunder'=>($jumlah_jaminan_sekunder2=="")?NULL:$jumlah_jaminan_sekunder2
												,'nominal_taksasi_sekunder'=>($nominal_taksasi_sekunder2=="")?NULL:$nominal_taksasi_sekunder2
												,'presentase_jaminan_sekunder'=>($presentasi_jaminan_sekunder2=="")?NULL:$presentasi_jaminan_sekunder2
												,'sektor_ekonomi'=>$sektor_ekonomi2
												,'peruntukan'=>$peruntukan2
												,'flag_wakalah'=>$flag_wakalah2
		    								 );
		    	$param_account_financing = array ( 'account_financing_no' => $account_financing_no );


		    	if($debug==true)
		    	{
		    		echo "<pre>";
		    		print_r($raw_account_financing);
		    		print_r($param_account_financing);
		    	}
		    	else
		    	{
			    	$this->db->trans_begin();
			    	$this->db->update('mfi_account_financing',$raw_account_financing,$param_account_financing);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = 2;
			    	}
			    }

		    }

	    } 
	    else //---------------- jumlah angsuran >0
	    {    

		    /*
	    	| updating mfi_trx_account_financing
	    	| updating mfi_trx_detail
	    	*/
		    if($pokok!=$pokok2 || $margin!=$margin2 || $tanggal_droping!=$tanggal_droping2){

		    	$param_upd_trx_acct_financing 	= array('account_financing_no'=>$account_financing_no,'trx_financing_type'=>'0');
		    	$raw_upd_trx_acct_financing		= array('pokok'=>$pokok2,'margin'=>$margin2,'jto_date'=>$tanggal_mulai_angsur2,'trx_date'=>$tanggal_droping2);

		    	$param_upd_trx_detail 			= array('account_no'=>$account_financing_no,'trx_type'=>'3','trx_account_type'=>'0');
		    	$raw_upd_trx_detail 			= array('amount'=>$pokok2+$margin2,'trx_date'=>$tanggal_droping2);

		    	if($debug==true)
		    	{
		    		echo "<pre>";
		    		print_r($raw_upd_trx_acct_financing);
		    		print_r($raw_upd_trx_detail);
		    	}
		    	else
		    	{
			    	$this->db->trans_begin();
			    	$this->model_nasabah->update_trx_account_financing($raw_upd_trx_acct_financing,$param_upd_trx_acct_financing);
			    	$this->model_nasabah->update_trx_detail($raw_upd_trx_detail,$param_upd_trx_detail);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = 1;
			    	}
			    }
		    }

		    /*
		    | updating mfi_account_saving
		    */
		    if($bValid==true){

		    	$account_saving_no = $this->model_nasabah->get_account_saving_by_account_financing_no($account_financing_no);
		    	$account_saving = $this->model_nasabah->get_account_saving($account_saving_no);

		    	$biaya_sebelumnya = $biaya_administrasi+$biaya_notaris+$biaya_asuransi_jiwa+$biaya_asuransi_jaminan+$biaya_jasa_layanan+$simpanan_wajib_pinjam;
		    	$saldo_memo_sebelumnya = $account_saving['saldo_memo']-($pokok-$biaya_sebelumnya);
		    	$saldo_riil_sebelumnya = $account_saving['saldo_riil']-($pokok-$biaya_sebelumnya);
		    	$account_saving_no 	   = $account_saving['account_saving_no'];
		    	$raw_account_saving = array( 'saldo_memo'=>$saldo_memo_sebelumnya, 'saldo_riil'=>$saldo_riil_sebelumnya );

		    	$param_account_saving = array ( 'account_saving_no' => $account_saving_no );


		    	if($debug==true)
		    	{
		    		echo "<pre>";
		    		print_r($raw_account_saving);
		    		print_r($param_account_saving);
		    	}
		    	else
		    	{
			    	$this->db->trans_begin();
			    	$this->model_nasabah->update_account_saving($raw_account_saving,$param_account_saving);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = '1.1';
			    	}
			    }

		    }

		    /* 
		    | updating mfi_account_financing_droping
		    | updating mfi_account_financing
		    */
		    if($bValid==true){

		    	$param_acct_financing_droping	= array('account_financing_no'=>$account_financing_no);
		    	$raw_acct_financing_droping		= array('droping_date'=>$tanggal_droping2);

		    	$param_acct_financing 			= array('account_financing_no'=>$account_financing_no);
			    $raw_acct_financing 			= array(
														 'pokok'=>$pokok2
											    		,'margin'=>$margin2
											    		,'jangka_waktu'=>$jangka_waktu2
											    		,'tanggal_akad'=>$tanggal_droping2
											    		,'tanggal_mulai_angsur'=>$tanggal_mulai_angsur2
											    		,'tanggal_jtempo'=>$tanggal_jtempo2
											    		,'jtempo_angsuran_last'=>$tanggal_droping2
											    		,'jtempo_angsuran_next'=>$tanggal_mulai_angsur2
											    		,'angsuran_pokok'=>$angsuran_pokok2
											    		,'angsuran_margin'=>$angsuran_margin2
											    		,'uang_muka'=>$uang_muka2
														,'titipan_notaris'=>$titipan_notaris2
														,'periode_jangka_waktu'=>$periode_jangka_waktu2
														,'angsuran_catab'=>$angsuran_catab2
														,'simpanan_wajib_pinjam'=>$simpanan_wajib_pinjam2
														,'biaya_administrasi'=>$biaya_administrasi2
														,'biaya_jasa_layanan'=>$biaya_jasa_layanan2
														,'biaya_notaris'=>$biaya_notaris2
														,'biaya_asuransi_jiwa'=>$biaya_asuransi_jiwa2
														,'biaya_asuransi_jaminan'=>$biaya_asuransi_jaminan2
														,'jenis_jaminan'=>($jenis_jaminan2=="")?NULL:$jenis_jaminan2
														,'keterangan_jaminan'=>($keterangan_jaminan2=="")?NULL:$keterangan_jaminan2
														,'jumlah_jaminan'=>($jumlah_jaminan2=="")?NULL:$jumlah_jaminan2
														,'nominal_taksasi'=>($nominal_taksasi2=="")?NULL:$nominal_taksasi2
														,'presentase_jaminan'=>($presentasi_jaminan2=="")?NULL:$presentasi_jaminan2
														,'jenis_jaminan_sekunder'=>($jenis_jaminan_sekunder2=="")?NULL:$jenis_jaminan_sekunder2
														,'keterangan_jaminan_sekunder'=>($keterangan_jaminan_sekunder2=="")?NULL:$keterangan_jaminan_sekunder2
														,'jumlah_jaminan_sekunder'=>($jumlah_jaminan_sekunder2=="")?NULL:$jumlah_jaminan_sekunder2
														,'nominal_taksasi_sekunder'=>($nominal_taksasi_sekunder2=="")?NULL:$nominal_taksasi_sekunder2
														,'presentase_jaminan_sekunder'=>($presentasi_jaminan_sekunder2=="")?NULL:$presentasi_jaminan_sekunder2
														,'sektor_ekonomi'=>$sektor_ekonomi2
														,'peruntukan'=>$peruntukan2
														,'flag_wakalah'=>$flag_wakalah2
														,'fa_code'=>$fa_code_n
														,'resort_code'=>$resort_code_n
											    	);
				$registration_no=$this->model_nasabah->get_registration_no_by_account_financing_no($account_financing_no);
				$raw_acct_financing_reg=array('fa_code'=>$fa_code_n,'resort_code'=>$resort_code_n);
				$param_acct_financing_reg=array('registration_no'=>$registration_no);
				
				if($debug==true)
				{
					echo "<pre>";
					print_r($raw_acct_financing_droping);
					print_r($raw_acct_financing);
					print_r($raw_acct_financing_reg);
				}
				else
				{
			    	$this->db->trans_begin();
			    	$this->model_nasabah->update_account_financing_droping($raw_acct_financing_droping,$param_acct_financing_droping);
			    	$this->model_nasabah->update_account_financing($raw_acct_financing,$param_acct_financing);
			    	/*tambahan(update ke table mfi financing reg)*/
			    	$this->model_nasabah->update_account_financing_reg($raw_acct_financing_reg,$param_acct_financing_reg);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = 2;
			    	}
				}

			}

		    /*
		    | running procedure function droping by postgresql
		    */
		    if($bValid==true){

		    	if($debug==false)
		    	{
			    	$this->db->trans_begin();
			    	$this->model_nasabah->fn_proses_jurnal_droping_pyd($account_financing_no);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = 3;
			    	}
			    }

		    }

		    /*
		    | insert log koreksi droping
		    */
		    if($bValid==true){

		    	$raw_log_koreksi_droping = array(
			    		 'account_financing_no' => $account_financing_no
			    		,'tanggal_koreksi' => date('Y-m-d H:i:s')
			    		,'user_id' => $this->session->userdata('user_id')
			    		,'status' => 0
			    		,'verify_by' => NULL
			    		,'verify_date' => NULL
			    		,'pokok' => $pokok
						,'margin' => $margin
						,'jangka_waktu' => $jangka_waktu
						,'tanggal_droping' => $tanggal_droping
						,'tanggal_mulai_angsur' => $tanggal_mulai_angsur
						,'tanggal_jtempo' => $tanggal_jtempo
						,'angsuran_pokok' => $angsuran_pokok
						,'angsuran_margin' => $angsuran_margin
						// ------------- new
						,'uang_muka' => $uang_muka
						,'titipan_notaris' => $titipan_notaris
						,'periode_jangka_waktu' => $periode_jangka_waktu
						,'angsuran_catab' => $angsuran_catab
						,'simpanan_wajib_pinjam' => $simpanan_wajib_pinjam
						,'biaya_administrasi' => $biaya_administrasi
						,'biaya_jasa_layanan' => $biaya_jasa_layanan
						,'biaya_notaris' => $biaya_notaris
						,'biaya_asuransi_jiwa' => $biaya_asuransi_jiwa
						,'biaya_asuransi_jaminan' => $biaya_asuransi_jaminan
						,'jenis_jaminan' => ($jenis_jaminan=="")?NULL:$jenis_jaminan
						,'keterangan_jaminan' => ($keterangan_jaminan=="")?NULL:$keterangan_jaminan
						,'jumlah_jaminan' => ($jumlah_jaminan=="")?NULL:$jumlah_jaminan
						,'nominal_taksasi' => ($nominal_taksasi=="")?NULL:$nominal_taksasi
						,'presentase_jaminan' => ($presentasi_jaminan=="")?NULL:$presentasi_jaminan
						,'jenis_jaminan_sekunder' => ($jenis_jaminan_sekunder=="")?NULL:$jenis_jaminan_sekunder
						,'keterangan_jaminan_sekunder' => ($keterangan_jaminan_sekunder=="")?NULL:$keterangan_jaminan_sekunder
						,'jumlah_jaminan_sekunder' => ($jumlah_jaminan_sekunder=="")?NULL:$jumlah_jaminan_sekunder
						,'nominal_taksasi_sekunder' => ($nominal_taksasi_sekunder=="")?NULL:$nominal_taksasi_sekunder
						,'presentase_jaminan_sekunder' => ($presentasi_jaminan_sekunder=="")?NULL:$presentasi_jaminan_sekunder
						,'sektor_ekonomi' => $sektor_ekonomi
						,'peruntukan' => $peruntukan
						,'flag_wakalah' => $flag_wakalah
						,'fa_code' => $fa_code_o
						,'resort_code' => $resort_code_o

						,'pokok2' => $pokok2
						,'margin2' => $margin2
						,'jangka_waktu2' => $jangka_waktu2
						,'tanggal_droping2' => $tanggal_droping2
						,'tanggal_mulai_angsur2' => $tanggal_mulai_angsur2
						,'tanggal_jtempo2' => $tanggal_jtempo2
						,'angsuran_pokok2' => $angsuran_pokok2
						,'angsuran_margin2' => $angsuran_margin2
						// ------------- new
						,'uang_muka2' => $uang_muka2
						,'titipan_notaris2' => $titipan_notaris2
						,'periode_jangka_waktu2' => $periode_jangka_waktu2
						,'angsuran_catab2' => $angsuran_catab2
						,'simpanan_wajib_pinjam2' => $simpanan_wajib_pinjam2
						,'biaya_administrasi2' => $biaya_administrasi2
						,'biaya_jasa_layanan2' => $biaya_jasa_layanan2
						,'biaya_notaris2' => $biaya_notaris2
						,'biaya_asuransi_jiwa2' => $biaya_asuransi_jiwa2
						,'biaya_asuransi_jaminan2' => $biaya_asuransi_jaminan2
						,'jenis_jaminan2' => ($jenis_jaminan2=="")?NULL:$jenis_jaminan2
						,'keterangan_jaminan2' => ($keterangan_jaminan2=="")?NULL:$keterangan_jaminan2
						,'jumlah_jaminan2' => ($jumlah_jaminan2=="")?NULL:$jumlah_jaminan2
						,'nominal_taksasi2' => ($nominal_taksasi2=="")?NULL:$nominal_taksasi2
						,'presentase_jaminan2' => ($presentasi_jaminan2=="")?NULL:$presentasi_jaminan2
						,'jenis_jaminan_sekunder2' => ($jenis_jaminan_sekunder2=="")?NULL:$jenis_jaminan_sekunder2
						,'keterangan_jaminan_sekunder2' => ($keterangan_jaminan_sekunder2=="")?NULL:$keterangan_jaminan_sekunder2
						,'jumlah_jaminan_sekunder2' => ($jumlah_jaminan_sekunder2=="")?NULL:$jumlah_jaminan_sekunder2
						,'nominal_taksasi_sekunder2' => ($nominal_taksasi_sekunder2=="")?NULL:$nominal_taksasi_sekunder2
						,'presentase_jaminan_sekunder2' => ($presentasi_jaminan_sekunder2=="")?NULL:$presentasi_jaminan_sekunder2
						,'sektor_ekonomi2' => $sektor_ekonomi2
						,'peruntukan2' => $peruntukan2
						,'flag_wakalah2' => $flag_wakalah2
						,'fa_code2' => $fa_code_n
						,'resort_code2' => $resort_code_n
						//--------------------new
						// ,'description' => $desc_peruntukan2
						
					);
				
				if($debug==true)
				{
					echo "<pre>";
					print_r($raw_log_koreksi_droping);
				}
				else
				{
					$this->db->trans_begin();
			    	$this->model_nasabah->insert_log_koreksi_droping($raw_log_koreksi_droping);
			    	if($this->db->trans_status()===true){
			    		$this->db->trans_commit();
			    	}else{
			    		$this->db->trans_rollback();
			    		$bValid=false;
			    		$error_state = 4;
			    	}
				}

		    }

		    /*
		    | updating mfi_account_financing_reg (desc peruntukan) //----------------new 14-02-2015
		    */
		    if($bValid==true){

			    $registration_no = $this->input->post('registration_no');
			    $desc_peruntukan = $this->input->post('desc_peruntukan');
			    $desc_peruntukan2 = $this->input->post('desc_peruntukan2');

			    if($desc_peruntukan!=$desc_peruntukan2){ //do update description

			    	$raw_account_saving_reg = array ( 'description' => $desc_peruntukan2 );
			    	$param_account_saving_reg = array ( 'registration_no' => $registration_no );


			    	if($debug==true)
			    	{
			    		echo "<pre>";
			    		print_r($raw_account_saving_reg);
			    		print_r($param_account_saving_reg);
			    	}
			    	else
			    	{
				    	$this->db->trans_begin();
				    	$this->db->update('mfi_account_financing_reg',$raw_account_saving_reg,$param_account_saving_reg);
				    	if($this->db->trans_status()===true){
				    		$this->db->trans_commit();
				    	}else{
				    		$this->db->trans_rollback();
				    		$bValid=false;
				    		$error_state = 5;
				    	}
				    }
				}

		    }
		} //------------end new 14-12-2015

	    if($bValid==true){
	    	$return = array('success'=>true);
	    }else{
	    	$return = array('success'=>false,'error_state'=>$error_state);
	    }

	    echo json_encode($return);

	}

	/***************************************************************************/
	//VERIFIKASI KOREKSI DROPING
	public function verifikasi_koreksi_droping()
	{
		$data['container'] = 'nasabah/verifikasi_koreksi_droping';
		$this->load->view('core',$data);
	}

	public function datatable_koreksi_droping()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'c.nama','a.account_financing_no','a.tanggal_koreksi','d.fullname','');
		// $cm_code = @$_GET['cm_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_koreksi_droping($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_koreksi_droping($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_koreksi_droping(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$tgl = date("d-m-Y",strtotime(substr($aRow['tanggal_koreksi'],0,10))).'&nbsp;&nbsp;'.substr($aRow['tanggal_koreksi'],10,10);
			$row = array();
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = $tgl;
			$row[] = $aRow['fullname'];
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini purple" log_id="'.$aRow['log_id'].'" id="link-edit"><i class="icon-ok-sign"></i> Verifikasi/Reject</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	function get_koreksi_by_log_id()
	{
		$log_id = $this->input->post('log_id');
		$data = $this->model_nasabah->get_koreksi_by_log_id($log_id);
		echo json_encode($data);
	}
	public function act_reject_koreksi_droping()
	{
		$log_id = $this->input->post('log_id');

		$data = array(
			 'status' => 2
			,'verify_by' => $this->session->userdata('user_id')
			,'verify_date' => date("Y-m-d H:i:s")
		);

		$param = array('log_id'=>$log_id);
		$this->db->trans_begin();
		$this->model_nasabah->update_status_koreksi_droping($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	public function act_approve_koreksi_droping()
	{
		$log_id = $this->input->post('log_id');

		$data = array(
			 'status' => 1
			,'verify_by' => $this->session->userdata('user_id')
			,'verify_date' => date("Y-m-d H:i:s")
		);

		$param = array('log_id'=>$log_id);
		$this->db->trans_begin();
		$this->model_nasabah->update_status_koreksi_droping($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	//END VERIFIKASI KOREKSI DROPING
	/***************************************************************************/

	function get_saldo_catab_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$saldo_catab = $this->model_nasabah->get_saldo_catab_by_account_financing_no($account_financing_no);

		echo json_encode(array('saldo_catab'=>$saldo_catab));
	}
	function get_saldo_memo_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$saldo_memo = $this->model_nasabah->get_saldo_memo_by_account_financing_no($account_financing_no);

		echo json_encode(array('saldo_memo'=>$saldo_memo));
	}

	function cek_angsuran()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$cek_angsuran = $this->model_nasabah->cek_angsuran($account_financing_no);
		$return = array('result'=>$cek_angsuran);
		echo json_encode($return);
	}

	function update_data_pembiayaan()
	{
		$data['title'] = 'Update Data Pembiayaan';
		$data['container'] = 'nasabah/update_data_pembiayaan';

		$data['petugass'] = $this->model_transaction->get_petugas();
		$data['resorts'] = $this->model_cif->get_resorts();
		$data['sektors'] = $this->model_transaction->get_sektor();
		$data['peruntukans'] = $this->model_transaction->get_peruntukan();
		$data['jaminans'] = $this->model_transaction->get_jenis_jaminan();

		$this->load->view('core',$data);
	}

	function datatable_update_data_pembiayaan()
	{
		$aColumns = array( 'b.cif_no','a.account_financing_no','b.nama','c.fa_name','d.resort_name','');

		/* Paging */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/* Ordering */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ) {
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
			if ( $aColumns[$i] != '' ) {
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ) {
					if ( $sWhere == "" ) {
						$sWhere = "WHERE ";
					} else {
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_update_data_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_update_data_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_update_data_pembiayaan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<div align="center">'.$aRow['cif_no'].'</div>';
			$row[] = '<div align="center">'.$aRow['account_financing_no'].'</div>';
			$row[] = $aRow['nama'];
			$row[] = $aRow['fa_name'];
			$row[] = $aRow['resort_name'];
			$row[] = '<a href="javascript:;" data-accountfinancingid="'.$aRow['account_financing_id'].'" class="btn mini green" id="update">UPDATE</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_akun_saving_for_update_data_pembiayaan()
	{
		$account_financing_id = $this->input->post('accountfinancingid');
		$datas = $this->model_nasabah->get_akun_saving_for_update_data_pembiayaan($account_financing_id);
		echo json_encode($datas);
	}

	function get_data_for_update_data_pembiayaan()
	{
		$account_financing_id = $this->input->post('accountfinancingid');
		$datas = $this->model_nasabah->get_data_for_update_data_pembiayaan($account_financing_id);
		echo json_encode($datas);
	}	

	public function action_update_data_pembiayaan()
	{
		$account_financing_id 	= $this->input->post('account_financing_id');
		$fa_code 				= $this->input->post('fa_code');
		$resort_code 			= $this->input->post('resort_code');
		$account_saving_no 		= $this->input->post('account_saving_no');
		$primer_jaminan 		= $this->input->post('primer_jaminan');
		$primer_keterangan 		= $this->input->post('primer_keterangan');
		$primer_jumlah 			= $this->input->post('primer_jumlah');
		$primer_taksasi 		= str_replace(".","",$this->input->post('primer_taksasi'));
		$primer_presentase 		= str_replace(",",".",$this->input->post('primer_presentase'));
		$sekunder_jaminan 		= $this->input->post('sekunder_jaminan');
		$sekunder_keterangan 	= $this->input->post('sekunder_keterangan');
		$sekunder_jumlah 		= $this->input->post('sekunder_jumlah');
		$sekunder_taksasi 		= str_replace(".","",$this->input->post('sekunder_taksasi'));
		$sekunder_presentase 	= str_replace(",",".",$this->input->post('sekunder_presentase'));
		$sektor_ekonomi 		= $this->input->post('sektor_ekonomi');
		$peruntukan 			= $this->input->post('peruntukan');
		$flag_wakalah 			= $this->input->post('flag_wakalah');

		$primer_presentase		= str_replace('0.00','0', $primer_presentase);
		$sekunder_presentase	= str_replace('0.00','0', $sekunder_presentase);

		$fa_code 				= ($fa_code=='')?NULL:$fa_code;
		$resort_code 			= ($resort_code=='')?NULL:$resort_code;
		$account_saving_no 		= ($account_saving_no=='')?NULL:$account_saving_no;
		$primer_jaminan 		= ($primer_jaminan=='')?NULL:$primer_jaminan;
		$primer_keterangan 		= ($primer_keterangan=='')?NULL:$primer_keterangan;
		$primer_jumlah 			= ($primer_jumlah=='')?NULL:$primer_jumlah;
		$primer_taksasi 		= ($primer_taksasi=='')?NULL:$primer_taksasi;
		$primer_presentase 		= ($primer_presentase=='')?NULL:$primer_presentase;
		$sekunder_jaminan 		= ($sekunder_jaminan=='')?NULL:$sekunder_jaminan;
		$sekunder_keterangan 	= ($sekunder_keterangan=='')?NULL:$sekunder_keterangan;
		$sekunder_jumlah 		= ($sekunder_jumlah=='')?NULL:$sekunder_jumlah;
		$sekunder_taksasi 		= ($sekunder_taksasi=='')?NULL:$sekunder_taksasi;
		$sekunder_presentase 	= ($sekunder_presentase=='')?NULL:$sekunder_presentase;
		$sektor_ekonomi 		= ($sektor_ekonomi=='')?NULL:$sektor_ekonomi;
		$peruntukan 			= ($peruntukan=='')?NULL:$peruntukan;
		$flag_wakalah 			= ($flag_wakalah=='')?NULL:$flag_wakalah;

		$data = array(
					 'fa_code' 						=>$fa_code
					,'resort_code' 					=>$resort_code
					,'account_saving_no' 			=>$account_saving_no
					,'jenis_jaminan' 				=>$primer_jaminan
					,'keterangan_jaminan' 			=>$primer_keterangan
					,'jumlah_jaminan' 				=>$primer_jumlah
					,'nominal_taksasi' 				=>$primer_taksasi
					,'presentase_jaminan' 			=>$primer_presentase
					,'jenis_jaminan_sekunder' 		=>$sekunder_jaminan
					,'keterangan_jaminan_sekunder' 	=>$sekunder_keterangan
					,'jumlah_jaminan_sekunder' 		=>$sekunder_jumlah
					,'nominal_taksasi_sekunder' 	=>$sekunder_taksasi
					,'presentase_jaminan_sekunder' 	=>$sekunder_presentase
					,'sektor_ekonomi' 				=>$sektor_ekonomi
					,'peruntukan' 					=>$peruntukan
					,'flag_wakalah' 				=>$flag_wakalah
				);
		$param = array('account_financing_id'=>$account_financing_id);

		$this->db->trans_begin();
		$this->model_nasabah->action_update_data_pembiayaan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/* FINANCING */
	function get_account_financing()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_account_financing($account_financing_no);
		echo json_encode($data);
	}


	/*
	//pengajuan pembiayaan koptel 
	*/
	public function pengajuan_pembiayaan_koptel()
	{
		$data['container'] 	= 'transaction/pengajuan_pembiayaan_koptel';
		$data['petugas'] 	= $this->model_transaction->get_petugas();
		// $data['product'] = $this->model_transaction->get_product_financing();
		$date_current 		= $this->model_transaction->date_current();

		$tgl 		  = substr("$date_current",8,2);
	    $bln 		  = substr("$date_current",5,2);
	    $thn	 	  = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;

		$tgl_pencairan  = date('Y-m-d',strtotime($date_current. '+'.'7'.' days'));
		$tgl1 			= substr("$tgl_pencairan",8,2);
	    $bln1 			= substr("$tgl_pencairan",5,2);
	    $thn1	 		= substr("$tgl_pencairan",0,4);
	    $tanggal_cair	= "$tgl1/$bln1/$thn1";
	    $data['tanggal_pencairan'] = $tanggal_cair;


	    $data['sumber_dana']=$this->model_nasabah->get_sumber_dana();
		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['scoringadmkeldoc']=$this->model_cif->get_list_code('scoringadmkeldoc');
		$data['scoringpemkewman']=$this->model_cif->get_list_code('scoringpemkewman');
		$data['scoringtempatusaha']=$this->model_cif->get_list_code('scoringtempatusaha');
		$data['scoringlokasiusaha']=$this->model_cif->get_list_code('scoringlokasiusaha');
		$data['scoringkegiatanusaha']=$this->model_cif->get_list_code('scoringkegiatanusaha');
		$data['scoringhubunganusaha']=$this->model_cif->get_list_code('scoringhubunganusaha');
		$data['scoringlamaberusaha']=$this->model_cif->get_list_code('scoringlamaberusaha');
		$data['scoringhartatetap']=$this->model_cif->get_list_code('scoringhartatetap');
		$data['scoringhartalancar']=$this->model_cif->get_list_code('scoringhartalancar');
		$data['scoringpendidikan']=$this->model_cif->get_list_code('scoringpendidikan');
		$data['scoringpnglmnusaha']=$this->model_cif->get_list_code('scoringpnglmnusaha');
		$data['resorts']=$this->model_cif->get_resorts();
		$this->load->view('core',$data);
	}

	public function datatable_pengajuan_pembiayaan_koptel()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','','a.registration_no','b.nik','b.nama_pegawai','c.product_name','a.tanggal_pengajuan','a.amount','a.peruntukan','','');
		$src_product = @$_GET['src_product'];
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel($sWhere,$sOrder,$sLimit,$src_product); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel($sWhere,'','',$src_product); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel('','','',$src_product); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$aRow['status'] = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
			// if($aRow['pengajuan_melalui']=='koptel'){
				$label_class = $aRow['status'];
			// }else{
				// $label_class = '<a href="javascript:;" class="btn mini"><i class="icon-edit"></i> Edit</a>';;
			// }

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nik'];
			$row[] = $aRow['nama_pegawai'];
			$row[] = $aRow['product_name'];
			$row[] = $this->format_date_detail($aRow['tanggal_pengajuan'],'id',false,'-');
			$row[] = date("d-m-Y H:i:s",strtotime($aRow['created_date']));
			$row[] = '<div align="right" style="white-space:nowrap;">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_pyd_ke_koptel()
	{
		$nik 	= $this->input->post('nik');
		$data 		= $this->model_nasabah->get_pyd_ke_koptel($nik);

		$jumlah = $data['jumlah'];
		if($jumlah==null){
          $total = 0;
        }else{
          $total = $jumlah;
        }
        
        $pyd = $total+1;

		echo $pyd;
	}

	public function cek_regis_pembiayaan_koptel()
	{
		$nik 	= $this->input->post('nik');
		$data 		= $this->model_nasabah->cek_regis_pembiayaan($nik);

		$jumlah = $data['jumlah'];
		if($jumlah==null){
          $total = 0;
        }else{
          $total = $jumlah;
        }

		echo $total;
	}

	function get_usia_asuransi()
	{
		$tgl_lahir = $this->input->post('tgl_lahir');
		$tgl_pengajuan = $this->input->post('tgl_pengajuan');
		$tgl_pengajuan = $this->datepicker_convert(true,$tgl_pengajuan,'/');
		$usia = $this->get_usia_menurut_asuransi($tgl_lahir,$tgl_pengajuan);
		$ret = array('usia'=>$usia);
		echo json_encode($ret);
	}

	function get_premi_asuransi_ajax()
	{
		$rate_askrindo = array(0, 0.243, 0.401, 0.528, 0.686, 0.792, 0.897, 1.055, 1.214, 1.404, 1.583);
		$jangkawaktu = $this->input->post('jangkawaktu');
		$show_asuransi = $this->input->post('show_asuransi');
		$usia = $this->input->post('usia');
		$manfaat = $this->convert_numeric($this->input->post('manfaat'));
		if($show_asuransi==1){
			$kontrak = ceil($jangkawaktu/12);
			$premi_asuransi = $manfaat*($rate_askrindo[$kontrak]/100);
		}elseif ($show_asuransi==2) {
			$premi_asuransi = $this->get_premi_asuransi($jangkawaktu,$usia,$manfaat);
		}
		$ret = array('premi'=>$premi_asuransi);
		echo json_encode($ret);
	}

	function get_premi_asuransi($jangka_waktu,$usia,$manfaat)
	{
		$rate_code = '101';
		$kontrak = ceil($jangka_waktu/12);
		$rate_value = $this->model_nasabah->get_premium_rate($rate_code,$usia,$kontrak);
		$biaya_asuransi = $manfaat*($rate_value/1000);

		return $biaya_asuransi;

	}

	public function add_pengajuan_pembiayaan_koptel()
	{
		$cif_id				= $this->input->post('cif_id');
		$nik				= $this->input->post('nik');
		$jenis_kelamin 		= ($this->input->post('gender')=="PRIA") ? "P" : "W" ;
		$nama				= $this->input->post('nama');
		$peruntukan			= $this->input->post('peruntukan');
		$status				= 0;
		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$jumlah_angsuran 	= $this->input->post('jumlah_angsuran');
		$product_code_smile = $this->input->post('product_code_smile');
		$pcode 				= $this->input->post('product_code');
		$product_code 		= ($pcode == '52') ? (($product_code_smile == "") ? $pcode : $product_code_smile) : $pcode;
		$amount 			= $this->input->post('amount');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$melalui 	 		= $this->input->post('melalui');
		$kopegtel 	 		= $this->input->post('kopegtel');
		
		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->input->post('tgl_lahir');
		$alamat 			= $this->input->post('alamat');
		$alamat_lokasi_kerja= $this->input->post('alamat_lokasi_kerja');
		$no_ktp 			= $this->input->post('no_ktp');
		$telpon_rumah  		= $this->input->post('telpon_rumah');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');
		$thp 				= $this->input->post('thp');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$premi_asuransi = $this->convert_numeric($this->input->post('premi_asuransi'));

		$total_angsuran 	= $this->input->post('total_angsuran');

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d H:i:s');

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 	= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		$angsuran_pokok 		= $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin 		= $this->convert_numeric($this->input->post('angsuran_margin'));

		if($saldo_kewajiban==false){$saldo_kewajiban=0;}
		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		
		$lunasi_ke_koptel 	= $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel = ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel 		= $this->input->post('saldo_kewajiban_ke_koptel');
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		//saldo kewajiban ke koptel sekarang sesuai yang dicheklist
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no = $this->input->post('account_financing_no');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));

		$saldo_kewajiban_ke_koptel = 0;
		$lunasi_ke_koptel = 0;
		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$lunasi_ke_koptel = 1;
				$saldo_kewajiban_ke_koptel += $check_saldo_pokok[$i];
			}
		}
		//end saldo kewajiban ke koptel sekarang sesuai yang dicheklist

		$usia = $this->get_usia_menurut_asuransi($tgl_lahir,date('Y-m-d'));
		$manfaat = $this->convert_numeric($amount);

		$status_asuransi = 0;
		$uw_policy = $this->model_nasabah->get_uw_policy($product_code,$usia,$manfaat);
		if ($uw_policy=='NM') {
			$status_asuransi = 1;
		}

		// get status_dokumen_lengkap
		$status_dokumen_lengkap = $this->model_nasabah->get_status_dokumen_lengkap_by_product_code($product_code);
		$update_thp = array('thp' => $this->convert_numeric($thp));

		//jenis margin efektif
		$jenis_margin 		= $this->input->post('jenis_margin');
		$total_margin 		= $this->convert_numeric($this->input->post('jumlah_margin'));
		$account_financing_reg_id = uuid(false);

		$data = array(
				 'account_financing_reg_id'  =>$account_financing_reg_id
				,'cif_no'				     =>$nik
				,'amount'				     =>$this->convert_numeric($amount)
				,'peruntukan'			     =>$peruntukan
				,'status'				     =>$status
				,'tanggal_pengajuan'	     =>$tanggal_pengajuan
				,'product_code'			     =>$product_code
				,'created_by'			     =>$created_by
				,'created_date'			     =>$created_date
				,'jumlah_kewajiban'		     =>$this->convert_numeric($jumlah_kewajiban)
				,'jumlah_angsuran'		     =>$this->convert_numeric($jumlah_angsuran)
				,'jangka_waktu'			     =>$jangka_waktu
				,'pengajuan_melalui'	     =>$melalui
				,'kopegtel_code'		     =>$kopegtel
				,'nama_bank'			     =>$nama_bank
				,'no_rekening'			     =>$no_rekening
				,'atasnama_rekening'	     =>$atasnama_rekening
				,'bank_cabang'			     =>$bank_cabang
				,'lunasi_ke_kopegtel'	     =>$lunasi_kopegtel
				,'description'			     =>$keterangan_peruntukan
				,'flag_thp'				     =>$flag_thp
				,'saldo_kewajiban'		     =>$this->convert_numeric($saldo_kewajiban)
				,'status_asuransi'		     =>$status_asuransi
				,'uw_policy'			     =>$uw_policy
				,'premi_asuransi'		     =>$premi_asuransi
				,'lunasi_ke_koptel'		     =>$lunasi_ke_koptel
				,'saldo_kewajiban_ke_koptel' =>$saldo_kewajiban_ke_koptel
				,'angsuran_pokok'			 =>$angsuran_pokok
				,'angsuran_margin'			 =>$angsuran_margin
				,'pelunasan_ke_kopeg_mana' 	 =>$pelunasan_ke_kopeg_mana
				,'status_dokumen_lengkap' 	 =>$status_dokumen_lengkap
				,'total_margin' 		 	 =>$total_margin
			);
		
		$data_cif = array(
				 'nama'					=>$nama
				,'panggilan'			=>''
				,'tmp_lahir'			=>$tempat_lahir
				,'tgl_lahir'			=>$tgl_lahir
				,'alamat'				=>$alamat
				,'no_ktp'				=>$no_ktp
				,'telpon_seluler'		=>$no_telpon
				,'telpon_rumah'			=>$telpon_rumah
				,'cif_type'				=>1
				,'koresponden_alamat'	=>$alamat
				,'status'				=>1
				,'nama_pasangan'		=>$nama_pasangan
				,'pekerjaan_pasangan'	=>$pekerjaan_pasangan
				,'nama_bank'			=>$nama_bank
				,'no_rekening'			=>$no_rekening
				,'atasnama_rekening'	=>$atasnama_rekening
				,'jenis_kelamin'		=>$jenis_kelamin
				,'bank_cabang'			=>$bank_cabang
				,'alamat_lokasi_kerja'	=>$alamat_lokasi_kerja
			);
		if($cif_id=='0'){
			$data_cif['cif_no'] 		= $nik;
			$data_cif['created_by'] 	= $this->session->userdata('user_id');
			$data_cif['branch_code'] 	= $this->session->userdata('branch_code');
		}

		$param = array('cif_no'=>$nik);

		$param_thp = array('nik'=>$nik);
		$data_thp = array('status'=>2,'active_date'=>date('Y-m-d H:i:s'));
			
		$this->db->trans_begin();
		$this->model_nasabah->add_pengajuan_pembiayaan($data);
		$this->model_nasabah->update_flag_thp($data_thp,$param_thp);//update semua flag thp 100% (Take Home Pay) -- GAJI BERSIH
		if($cif_id=='0'){
			$this->model_nasabah->insert_cif($data_cif);
		}else{
			$this->model_nasabah->update_cif($data_cif,$param);
		}
		$this->model_nasabah->update_thp_pegawai($update_thp,$param_thp);

		$registration_no_val = $this->model_transaction->get_registrasion_no_by_id($account_financing_reg_id);
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no = $this->input->post('account_financing_no');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));
		$data_fn_lunas = array();

		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$data_fn_lunas[]=array(
					 'registration_no' => $registration_no_val
					,'saldo_pokok' => $check_saldo_pokok[$i]
					,'saldo_margin' => $check_saldo_margin[$i]
					,'account_financing_no' => $account_financing_no[$i]
					,'flag_registrasi' => '0'
				);
			}
		}

		// echo "<pre>";
		// print_r($data_fn_lunas);
		// die();
		if(count($data_fn_lunas)>0){
			$this->db->insert_batch('mfi_account_financing_reg_lunas',$data_fn_lunas);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'uw_policy'=>$uw_policy,'status_dokumen_lengkap'=>$status_dokumen_lengkap,'product_code'=>$product_code);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function add_pengajuan_pembiayaan_koptel_v2()
	{
		$cif_id				= $this->input->post('cif_id');
		$nik				= $this->input->post('nik');
		$jenis_kelamin 		= ($this->input->post('gender')=="PRIA") ? "P" : "W" ;
		$nama				= $this->input->post('nama');
		$peruntukan			= $this->input->post('peruntukan');
		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$jumlah_angsuran 	= $this->input->post('jumlah_angsuran');
		$product_code_smile = $this->input->post('product_code_smile');
		$pcode 				= $this->input->post('product_code');
		$amount 			= $this->input->post('amount');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$melalui 	 		= $this->input->post('melalui');
		$kopegtel 	 		= $this->input->post('kopegtel');
		
		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->input->post('tgl_lahir');
		$alamat 			= $this->input->post('alamat');
		$alamat_lokasi_kerja= $this->input->post('alamat_lokasi_kerja');
		$no_ktp 			= $this->input->post('no_ktp');
		$telpon_rumah  		= $this->input->post('telpon_rumah');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');
		$thp 				= $this->input->post('thp');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$premi_asuransi 	= $this->convert_numeric($this->input->post('premi_asuransi'));

		$total_angsuran 	= $this->input->post('total_angsuran');
		$tanggal_pengajuan	= $this->input->post('tanggal_pengajuan');

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d H:i:s');

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 	= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		$angsuran_pokok 		= $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin 		= $this->convert_numeric($this->input->post('angsuran_margin'));
		
		$lunasi_ke_koptel 		= $this->input->post('lunasi_ke_koptel');
		$saldo_kewajiban_ke_koptel = $this->input->post('saldo_kewajiban_ke_koptel');

		//saldo kewajiban ke koptel sekarang sesuai yang dicheklist
		$account_financing_no = $this->input->post('account_financing_no');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));
		//end saldo kewajiban ke koptel sekarang sesuai yang dicheklist

		$jenis_margin = $this->input->post('jenis_margin');
		$total_margin = $this->convert_numeric($this->input->post('jumlah_margin'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));

		for ( $i = 0 ; $i < count($nik) ; $i++ )
		{
			if (trim($nik[$i])!="") {

				$account_financing_reg_id = uuid(false);

				$product_code = ($pcode[$i] == '52') ? (($product_code_smile[$i] == "") ? $pcode[$i] : $product_code_smile[$i]) : $pcode[$i];
				$usia = $this->get_usia_menurut_asuransi($tgl_lahir[$i],date('Y-m-d'));
				$manfaat = $this->convert_numeric($amount[$i]);

				$status_asuransi = 0;
				$uw_policy = $this->model_nasabah->get_uw_policy($product_code[$i],$usia,$manfaat);
				if ($uw_policy=='NM') {
					$status_asuransi = 1;
				}

				// get status_dokumen_lengkap
				// $status_dokumen_lengkap = $this->model_nasabah->get_status_dokumen_lengkap_by_product_code($product_code[$i]);
				$update_thp = array('thp' => $this->convert_numeric($thp[$i]));

				if($saldo_kewajiban[$i]==false)
				{
					$saldokewajiban = 0;
				}else{
					$saldokewajiban = $saldo_kewajiban[$i];
				}

				$lunasi_kopegtel = ($lunasi_ke_kopegtel[$i]==false) ? '0' : '1' ;
				$lunasi_ke_koptel = ($lunasi_ke_koptel[$i]==false) ? '0' : '1' ;

				if($saldo_kewajiban_ke_koptel[$i]==false)
				{
					$saldokewajiban_ke_koptel = 0;
				}else{
					$saldokewajiban_ke_koptel = $saldo_kewajiban_ke_koptel[$i];
				}

				$data = array(
						 'account_financing_reg_id'  =>$account_financing_reg_id
						,'cif_no'				     =>$nik[$i]
						,'amount'				     =>$this->convert_numeric($amount[$i])
						,'peruntukan'			     =>$peruntukan[$i]
						,'tanggal_pengajuan'	     =>$tanggal_pengajuan[$i]
						,'product_code'			     =>$product_code
						,'created_by'			     =>$created_by
						,'created_date'			     =>$created_date
						,'jumlah_kewajiban'		     =>$this->convert_numeric($jumlah_kewajiban[$i])
						,'jumlah_angsuran'		     =>$this->convert_numeric($jumlah_angsuran[$i])
						,'jangka_waktu'			     =>$jangka_waktu[$i]
						,'pengajuan_melalui'	     =>$melalui[$i]
						,'kopegtel_code'		     =>$kopegtel[$i]
						,'nama_bank'			     =>$nama_bank[$i]
						,'no_rekening'			     =>$no_rekening[$i]
						,'atasnama_rekening'	     =>$atasnama_rekening[$i]
						,'bank_cabang'			     =>$bank_cabang[$i]
						,'lunasi_ke_kopegtel'	     =>$lunasi_kopegtel
						,'description'			     =>$keterangan_peruntukan[$i]
						,'flag_thp'				     =>$flag_thp[$i]
						,'saldo_kewajiban'		     =>$saldokewajiban
						,'status_asuransi'		     =>$status_asuransi
						,'uw_policy'			     =>$uw_policy
						,'premi_asuransi'		     =>$premi_asuransi[$i]
						,'lunasi_ke_koptel'		     =>$lunasi_ke_koptel
						,'saldo_kewajiban_ke_koptel' =>$saldokewajiban_ke_koptel
						,'angsuran_pokok'			 =>$angsuran_pokok[$i]
						,'angsuran_margin'			 =>$angsuran_margin[$i]
						,'pelunasan_ke_kopeg_mana' 	 =>$pelunasan_ke_kopeg_mana[$i]
						,'total_margin' 		 	 =>$total_margin[$i]
						,'status' 		 	 		 =>1
						,'status_asuransi' 		 	 =>1
						,'status_dokumen_lengkap' 	 =>1
					);

				$data_cif = array(
						 'nama'					=>$nama[$i]
						,'panggilan'			=>''
						,'tmp_lahir'			=>$tempat_lahir[$i]
						,'tgl_lahir'			=>$tgl_lahir[$i]
						,'alamat'				=>$alamat[$i]
						,'no_ktp'				=>$no_ktp[$i]
						,'telpon_seluler'		=>$no_telpon[$i]
						,'telpon_rumah'			=>$telpon_rumah[$i]
						,'cif_type'				=>1
						,'koresponden_alamat'	=>$alamat[$i]
						,'status'				=>1
						,'nama_pasangan'		=>$nama_pasangan[$i]
						,'pekerjaan_pasangan'	=>$pekerjaan_pasangan[$i]
						,'nama_bank'			=>$nama_bank[$i]
						,'no_rekening'			=>$no_rekening[$i]
						,'atasnama_rekening'	=>$atasnama_rekening[$i]
						,'jenis_kelamin'		=>$jenis_kelamin[$i]
						,'bank_cabang'			=>$bank_cabang[$i]
						,'alamat_lokasi_kerja'	=>$alamat_lokasi_kerja[$i]
					);

				if($cif_id=='0'){
					$data_cif['cif_no'] 		= $nik[$i];
					$data_cif['created_by'] 	= $this->session->userdata('user_id');
					$data_cif['branch_code'] 	= $this->session->userdata('branch_code');
				}

				$param = array('cif_no'=>$nik[$i]);

				$param_thp = array('nik'=>$nik[$i]);
				$data_thp = array('status'=>2,'active_date'=>date('Y-m-d H:i:s'));
					
				$this->db->trans_begin();
				$this->model_nasabah->add_pengajuan_pembiayaan($data);
				$this->model_nasabah->update_flag_thp($data_thp,$param_thp);
				if($cif_id=='0'){
					$this->model_nasabah->insert_cif($data_cif);
				}else{
					$this->model_nasabah->update_cif($data_cif,$param);
				}
				$this->model_nasabah->update_thp_pegawai($update_thp,$param_thp);

				$arr = explode(';', $account_financing_no[$i]);				
				for($k=0; $k<count($arr); $k++)
				{
					if($arr[$k]!=''){
						$registration_no_val = $this->model_transaction->get_registrasion_no_by_id($account_financing_reg_id);
						$list = $this->model_transaction->get_financing_by_saldo_pokok_v3($arr[$k]);
						$data_fn_lunas = array(
											 'registration_no' => $registration_no_val
											,'saldo_pokok' => $list['saldo_pokok']
											,'saldo_margin' => $list['saldo_margin']
											,'account_financing_no' => $list['account_financing_no']
											,'flag_registrasi' => '0'
										);
						if(!empty($list['saldo_pokok'])){
							$this->db->insert('mfi_account_financing_reg_lunas',$data_fn_lunas);
						}
					}else{
						$this->db->trans_rollback();
						$no=$i+1;
						$return = array('success'=>false,'message'=>"Row ke <b>". $no . "</b> Pelunasan Gagal, please confirm Administrator about template No Pembiayaan!");
						echo json_encode($return);
						exit;
					}
				}
			}else{
				$this->db->trans_rollback();
				$no=$i+1;
				$return = array('success'=>false,'message'=>"Row ke <b>". $no . "</b> NIK belum terdaftar!");
				echo json_encode($return);
				exit;
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$structure = './assets/data_topup/';
			$file = $structure."topup.xlsx";
			rename($file, $structure . "topup-done" . date('Y-m-d') . ".xlsx");
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function cek_masa_pensiun()
	{
		$sekarang = date("Y-m-d");

		$jangka_waktu 	= $this->input->post('jangka_waktu');
		$masa_pensiun 	= $this->input->post('masa_pensiun');
		$jangka_waktu 	= $jangka_waktu+1;

		$akhir_kontrak = date("Y-m-d",strtotime($sekarang." + $jangka_waktu month"));

		//MEnghitung waktu pensiun dalam bulan
		$date1 = date("Y-m-d");
		$date2 = $masa_pensiun;
		$ts1 = strtotime($date1);
		$ts2 = strtotime($date2);
		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);
		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);
		$diff = (($year2-$year1)*12) + ($month2-$month1)-4;
		//END MEnghitung waktu pensiun dalam bulan

		$pensiun = strtotime($masa_pensiun);
		$akhir = strtotime($akhir_kontrak);
		// echo $pensiun.' | '.$akhir.' | '.$diff; die();

		if($akhir<$pensiun){
          $return = 'true|'.$diff.'|'.$akhir_kontrak.'|'.$masa_pensiun;
        }else{
          $return = 'false|'.$diff.'|'.$akhir_kontrak.'|'.$masa_pensiun;
        }

		echo $return;
	}

	public function cek_nik_from_mfi_cif()
	{
		$nik 	= $this->input->post('nik');
		$data 		= $this->model_nasabah->cek_nik_from_mfi_cif($nik);

		if(count($data)==0){
          $return = 0;
        }else{
          $return = $data['cif_id'];
        }

		echo $return;
	}

	public function approval_pengajuan_pembiayaan()
	{
		$data['container'] 	= 'transaction/approval_pengajuan_pembiayaan';
		// $data['product'] = $this->model_transaction->get_product_financing();
		$date_current 		= $this->model_transaction->date_current();

		$tgl 		  = substr("$date_current",8,2);
	    $bln 		  = substr("$date_current",5,2);
	    $thn	 	  = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;

		$tgl_pencairan  = date('Y-m-d',strtotime($date_current. '+'.'7'.' days'));
		$tgl1 			= substr("$tgl_pencairan",8,2);
	    $bln1 			= substr("$tgl_pencairan",5,2);
	    $thn1	 		= substr("$tgl_pencairan",0,4);
	    $tanggal_cair	= "$tgl1/$bln1/$thn1";
	    $data['tanggal_pencairan'] = $tanggal_cair;

		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);
	}


	public function get_peruntukan()
	{
		$akad = $this->input->post('akad');
		$datas = $this->model_transaction->get_peruntukan($akad);
		echo json_encode($datas);
	}

	public function datatable_approval_pengajuan_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_financing_reg.registration_no','mfi_cif.cif_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.rencana_droping','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','mfi_product_financing.product_name','','','');
		$src_product = @$_GET['src_product'];
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE (";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_approval_pengajuan_pembiayaan($sWhere,$sOrder,$sLimit,$src_product); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_approval_pengajuan_pembiayaan($sWhere,'','',$src_product); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_approval_pengajuan_pembiayaan('','','',$src_product); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$flag_scoring=0;
			if($aRow['flag_scoring']==0){ //tidak menggunakan scoring
				$skoring_link='<div align="center">-</div>';
			}

			$aRow['status'] = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" product_code="'.$aRow['product_code'].'" id="link-edit" class="btn mini purple"><i class="icon-ok-sign"></i> Appove</a>';
			$label_class = $aRow['status'];
			
			$total_margin = ($aRow['amount']*$aRow['rate_margin2']*$aRow['jangka_waktu']/100);

			$nik=' <span class="btn mini green-stripe">'.$aRow['cif_no'].'</span>';

			$melalui = ($aRow['pengajuan_melalui']!='koptel') ? $this->model_nasabah->get_kopegname_by_code($aRow['kopegtel_code']):"Koptel (Langsung)";

			// if ($aRow['pengajuan_melalui']!='koptel') {
			// 	$time_pengajuan = strtotime($aRow['tanggal_pengajuan'].' +'.$this->get_approval_limit_time().' days');
			// 	$time_now = strtotime(date('Y-m-d'));
			// 	if (($time_pengajuan-$time_now)>0) {
			// 		$label_class = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" class="btn mini"><i class="icon-ok-sign"></i> Appove</a>';
			// 	}
			// }

			$row = array();
			$row[] = $aRow['registration_no'];
			$row[] = $nik;
			$row[] = $aRow['nama'];
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = $aRow['product_name'];
			$row[] = '<div align="left">'.$melalui.'</div>';
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function edit_pengajuan_pembiayaan_koptel()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$nik				= $this->input->post('nik');
		$jenis_kelamin 		= ($this->input->post('gender')=="PRIA") ? "P" : "W" ;
		$nama				= $this->input->post('nama');
		$peruntukan			= $this->input->post('peruntukan');
		$status				= 0;
		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$jumlah_angsuran 	= $this->input->post('jumlah_angsuran');
		$product_code 		= $this->input->post('product_code');
		$amount 			= $this->input->post('amount');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$melalui 	 		= $this->input->post('melalui');
		$kopegtel 	 		= $this->input->post('kopegtel');

		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->input->post('tgl_lahir');
		$alamat 			= $this->input->post('alamat');
		$alamat_lokasi_kerja= $this->input->post('alamat_lokasi_kerja');
		$no_ktp 			= $this->input->post('no_ktp');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		// $jumlah_tanggungan 	= $this->input->post('jumlah_tanggungan');
		// $status_rumah 		= $this->input->post('status_rumah');
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');
		$thp 				= $this->input->post('thp');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');

		$total_angsuran 	= $this->input->post('total_angsuran');
		$premi_asuransi 	= $this->convert_numeric($this->input->post('premi_asuransi'));

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d H:i:s');

		//tambahan baru 15-04-2015

			$update_thp = array(
					'thp'		=>$this->convert_numeric($thp)
				);
			$param_thp = array('nik' =>$nik);

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 		= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		$angsuran_pokok 		= $this->input->post('angsuran_pokok');
		$angsuran_margin 		= $this->input->post('angsuran_margin');
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}

		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		
		$lunasi_ke_koptel 	= $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel = ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel 		= $this->input->post('saldo_kewajiban_ke_koptel');
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		//jenis margin efektif
		$jenis_margin 		= $this->input->post('jenis_margin');
		$total_margin 		= $this->convert_numeric($this->input->post('jumlah_margin'));
		
		$usia = $this->get_usia_menurut_asuransi($tgl_lahir,date('Y-m-d'));
		$manfaat = $this->convert_numeric($amount);

		$status_asuransi = 0;
		$uw_policy = $this->model_nasabah->get_uw_policy($product_code,$usia,$manfaat);
		if ($uw_policy=='NM') {
			$status_asuransi = 1;
		}
		// $premi_asuransi = $this->get_premi_asuransi($jangka_waktu,$usia,$manfaat);


		//saldo kewajiban ke koptel sekarang sesuai yang dicheklist
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no = $this->input->post('account_financing_no');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));

		$saldo_kewajiban_ke_koptel = 0;
		$lunasi_ke_koptel = 0;
		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$lunasi_ke_koptel = 1;
				$saldo_kewajiban_ke_koptel += $check_saldo_pokok[$i];
			}
		}
		//end saldo kewajiban ke koptel sekarang sesuai yang dicheklist

		// get status_dokumen_lengkap
		$status_dokumen_lengkap = $this->model_nasabah->get_status_dokumen_lengkap_by_product_code($product_code);

			$data = array(
					 'amount'				=>$this->convert_numeric($amount)
					,'peruntukan'			=>$peruntukan
					,'tanggal_pengajuan'	=>$tanggal_pengajuan
					,'product_code'			=>$product_code
					,'created_by'			=>$created_by
					,'jumlah_kewajiban'		=>$this->convert_numeric($jumlah_kewajiban)
					,'jumlah_angsuran'		=>$this->convert_numeric($jumlah_angsuran)
					,'jangka_waktu'			=>$jangka_waktu
					,'pengajuan_melalui'	=>$melalui
					,'kopegtel_code'		=>$kopegtel
					,'nama_bank'			=>$nama_bank
					,'no_rekening'			=>$no_rekening
					,'atasnama_rekening'	=>$atasnama_rekening
					,'bank_cabang'			=>$bank_cabang
					,'lunasi_ke_kopegtel'	=>$lunasi_kopegtel
					,'description'			=>$keterangan_peruntukan
					,'flag_thp'				=>$flag_thp
					,'saldo_kewajiban'		=>$this->convert_numeric($saldo_kewajiban)
					,'status_asuransi'		=>$status_asuransi
					,'uw_policy'			=>$uw_policy
					,'premi_asuransi'		=>$premi_asuransi
					,'lunasi_ke_koptel'		=>$lunasi_ke_koptel
					,'saldo_kewajiban_ke_koptel'=>$this->convert_numeric($saldo_kewajiban_ke_koptel)
					,'angsuran_pokok'		=>$this->convert_numeric($angsuran_pokok)
					,'angsuran_margin'		=>$this->convert_numeric($angsuran_margin)
					,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
					// ,'status_dokumen_lengkap' =>$status_dokumen_lengkap
					,'total_margin' =>$total_margin
				);

		$param = array('account_financing_reg_id'=>$account_financing_reg_id);
		
			$data_cif = array(
					 'nama'					=>$nama
					,'tmp_lahir'			=>$tempat_lahir
					,'tgl_lahir'			=>$tgl_lahir
					,'alamat'				=>$alamat
					,'no_ktp'				=>$no_ktp
					,'telpon_seluler'		=>$no_telpon
					,'cif_type'				=>1
					,'koresponden_alamat'	=>$alamat
					,'status'				=>1
					,'nama_pasangan'		=>$nama_pasangan
					,'pekerjaan_pasangan'	=>$pekerjaan_pasangan
					// ,'jumlah_tanggungan'	=>$jumlah_tanggungan
					// ,'status_rumah'			=>$status_rumah
					,'nama_bank'			=>$nama_bank
					,'no_rekening'			=>$no_rekening
					,'atasnama_rekening'	=>$atasnama_rekening
					,'bank_cabang'			=>$bank_cabang
					,'alamat_lokasi_kerja'	=>$alamat_lokasi_kerja
				);
			$param_cif = array('cif_no'=>$nik);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		$this->model_nasabah->update_cif($data_cif,$param_cif);
		$this->model_nasabah->update_thp_pegawai($update_thp,$param_thp);

		$registration_no_val = $this->model_transaction->get_registrasion_no_by_id($account_financing_reg_id);
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no = $this->input->post('account_financing_no');
		$no_pembiayaan = $this->input->post('no_pembiayaan');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));
		$data_fn_lunas = array();

		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$data_fn_lunas[]=array(
					 'registration_no' => $registration_no_val
					,'saldo_pokok' => $check_saldo_pokok[$i]
					,'saldo_margin' => $check_saldo_margin[$i]
					,'account_financing_no' => $account_financing_no[$i]
					,'flag_registrasi' => '0'
				);
			}
		}


		// echo "<pre>";
		// print_r($data_fn_lunas);
		// die();

		$param_lunas_reg = array(
							 'registration_no' => $registration_no_val
							// ,'flag_registrasi' => '0'
						);

		if(count($account_financing_no)>0){
			if($no_pembiayaan!=false){
				$this->db->delete('mfi_account_financing_reg_lunas',$param_lunas_reg);
			}
			if(count($data_fn_lunas)>0){
				$this->db->insert_batch('mfi_account_financing_reg_lunas',$data_fn_lunas);
			}
		}
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'uw_policy'=>$uw_policy,'status_dokumen_lengkap'=>$status_dokumen_lengkap,'product_code'=>$product_code);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function act_approve_pengajuan_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$account_saving_no_flag	= $this->input->post('account_saving_no');
		$nik	= $this->input->post('nik');
		$nama_bank	= $this->input->post('nama_bank');
		$no_rekening	= $this->input->post('no_rekening');
		$atasnama_rekening	= $this->input->post('atasnama_rekening');
		$bank_cabang	= $this->input->post('bank_cabang');

		$provisi_pembiayaan	= $this->convert_numeric($this->input->post('provisi_pembiayaan'));
		$biaya_administrasi	= $this->convert_numeric($this->input->post('biaya_administrasi'));
		$biaya_notaris	= $this->convert_numeric($this->input->post('biaya_notaris'));
		$biaya_apht	= $this->convert_numeric($this->input->post('biaya_apht'));

		// echo $account_saving_no_flag; die();

		/*
		** insert into mfi_account_financing
		*/

		// $data=$this->model_transaction->get_seq_account_financing_no($data_reg['product_code'],$data_reg['cif_no']);
		// $jumlah=(int)$data['jumlah'];
		// if(count($data)>0){
		// 	$newseq=$jumlah+1;
		// 	if($jumlah<10){
		// 		$newseq='0'.$newseq;
		// 	}
		// }else{
		// 	$newseq='01';
		// }

		// $account_financing_no = $data_reg['cif_no'].$data_reg['product_code'].$newseq;


		// $data_insert_to_financing = array(
		// 			 'product_code'				=>$data_reg['product_code']
		// 			,'branch_code'				=>$data_reg['branch_code']
		// 			,'cif_no' 					=>$data_reg['cif_no']
		// 			,'account_financing_no' 	=>$account_financing_no
		// 			,'akad_code' 				=>$data_reg['akad_code']
		// 			,'pokok'		 			=>$this->convert_numeric($data_reg['amount'])
		// 			,'margin' 					=>$this->convert_numeric($jumlah_margin)
		// 			,'saldo_pokok' 				=>$this->convert_numeric($data_reg['amount'])
		// 			,'saldo_margin'				=>$this->convert_numeric($jumlah_margin)
		// 			,'periode_jangka_waktu'	 	=>2 //bulanan
		// 			,'jangka_waktu' 			=>$data_reg['jangka_waktu']
		// 			,'tanggal_pengajuan'		=>$data_reg['tanggal_pengajuan']
		// 			,'cadangan_resiko' 			=>0
		// 			,'biaya_administrasi' 		=>0
		// 			,'biaya_notaris' 			=>0
		// 			,'biaya_asuransi_jiwa' 		=>0
		// 			,'biaya_asuransi_jaminan' 	=>0
		// 			,'dana_kebajikan'			=>0
		// 			,'created_by'				=>$this->session->userdata('user_id')
		// 			,'created_date'				=>date('Y-m-d H:i:s')
		// 			,'program_code'				=>$data_reg['product_code']
		// 			,'flag_jadwal_angsuran'		=>0
		// 			,'peruntukan' 				=>$data_reg['peruntukan']
		// 			,'registration_no'			=>$data_reg['registration_no']
		// 			,'uang_muka'				=>0
		// 			,'tanggal_registrasi'		=>$data_reg['tanggal_pengajuan']
		// 			,'flag_wakalah'				=>1
		// 			,'titipan_notaris'			=>0
		// 			,'simpanan_wajib_pinjam'	=>0
		// 		);
		/*
		** END insert into mfi_account_financing
		*/

		/*
		** insert into mfi_account_saving
		*/
		// if($account_saving_no_flag=="n"){
		// 	$data_reg = $this->model_nasabah->select_financing_reg_by_id($account_financing_reg_id);

		// 	$product_saving_code = $this->model_nasabah->select_product_saving_code_koptel();

		// 	$account_saving_no = $data_reg['cif_no'].$product_saving_code;

		// 	$data_insert_to_saving = array(
		// 			 'product_code'				=>$product_saving_code
		// 			,'cif_no' 					=>$data_reg['cif_no']
		// 			,'status_rekening'			=> '1'
		// 			,'account_saving_no' 		=>$account_saving_no
		// 			,'branch_code' 				=>$data_reg['branch_code']
		// 			,'tanggal_buka' 			=>date("Y-m-d")
		// 			,'created_by' 				=>$this->session->userdata('user_id')
		// 			,'created_date' 			=>date("Y-m-d H:i:s")
		// 		);
		// }
		/*
		** END insert into mfi_account_saving
		*/

		/*
		**UPDATE DATA PENGAJUAN
		*/
			$data_financing_reg = array(
										 'status'=>"1"
										 ,'approve_date'=>date("Y-m-d H:i:s")
										 ,'nama_bank'=>$nama_bank
										 ,'no_rekening'=>$no_rekening
										 ,'atasnama_rekening'=>$atasnama_rekening
										 ,'bank_cabang'=>$bank_cabang
										 ,'provisi_pembiayaan'=>$provisi_pembiayaan
										 ,'biaya_administrasi'=>$biaya_administrasi
										 ,'biaya_notaris'=>$biaya_notaris
										 ,'biaya_apht'=>$biaya_apht
										 // ,'pengajuan_melalui'=>'koptel'
										 // ,'kopegtel_code'=>''
										);
			$param_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);

			$data_update_cif = array(
										 'nama_bank'=>$nama_bank
										,'no_rekening'=>$no_rekening
										,'atasnama_rekening'=>$atasnama_rekening
										,'bank_cabang'=>$bank_cabang
									);
			$param_update_cif = array('cif_no'=>$nik);
		/*
		**END UPDATE DATA PENGAJUAN
		*/


		$this->db->trans_begin();
		// if($account_saving_no_flag=="n"){ 
		// 	$this->model_transaction->add_rekening_tabungan($data_insert_to_saving); 
		// }
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_financing_reg,$param_financing_reg);
		$this->model_nasabah->update_cif($data_update_cif,$param_update_cif);
		// $this->model_transaction->add_rekening_pembiayaan($data_insert_to_financing);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	public function datatable_pencairan_pembiayaan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_account_financing.account_financing_no','mfi_account_financing.cif_no','nama','akad_name','mfi_account_financing.pokok','mfi_account_financing.jangka_waktu','');
		$src_product = @$_GET['src_product'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere,$sOrder,$sLimit,$src_product); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pencairan_pembiayaan($sWhere,'','',$src_product); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pencairan_pembiayaan('','','',$src_product); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		$aregid='';
		foreach($rResult as $aRow)
		{
			$periode_jangka_waktu = '';
			switch ($aRow['periode_jangka_waktu']) {
				case '0':
				$periode_jangka_waktu = ' Hari';
				break;
				case '1':
				$periode_jangka_waktu = ' Minggu';
				break;
				case '2':
				$periode_jangka_waktu = ' Bulan';
				break;
				case '3':
				$periode_jangka_waktu = 'x Jatuh Tempo';
				break;
			}
			$stttmbl=true;
			if ($aregid==$aRow['account_financing_reg_id']){
				$stttmbl=false;
			}
			if($aRow['status']=='0'){
				$aregid=$aRow['account_financing_reg_id'];
			}

			$displaytermin='';
			$is_banmod=0;
			if ($aRow['banmod']==1){
				$displaytermin=' <span class="btn mini blue-stripe">termin '.$aRow['termin'].'</span>';
				$is_banmod=1;
			}
			if ($stttmbl==true){
				if ($aRow['termin']<>'1') {
					$aksi = '<div align="center"><a href="javascript:;" class="btn mini purple" account_financing_id="'.$aRow['account_financing_id'].'" product_code="'.$aRow['product_code'].'" is_banmod="'.$is_banmod.'" id="link-edit">Pencairan</a></div>'; 
				} else {
					if($aRow['flag_dokumen']=='1'){
						$aksi = '<div align="center"><a href="javascript:;" class="btn mini purple" account_financing_id="'.$aRow['account_financing_id'].'" product_code="'.$aRow['product_code'].'" is_banmod="'.$is_banmod.'" id="link-edit">Pencairan</a></div>'; 
					}else{
						$aksi = '<div align="center"><a href="javascript:;" class="btn mini green" account_financing_id="'.$aRow['account_financing_id'].'" id="link-flag-dokumen" style="white-space:nowrap;">Akad Diterima</a></div>'; 
					}
				}
			} else {
				$aksi = '<div align="center">-</div>'; 			
			}
			$row = array();
			$row[] = '<div align="center">'.$aRow['account_financing_no'].$displaytermin.'</div>';
			$row[] = '<div align="center">'.$aRow['cif_no'].'</div>';
			$row[] = '<div align="center">'.$aRow['nama'].'</div>';
			$row[] = '<div align="center">'.$aRow['akad_name'].'</div>';
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['kewajiban_koptel'],0,',','.').',-</div>';
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['kewajiban_kopegtel'],0,',','.').',-</div>';
			$row[] = '<div align="center">'.$aRow['jangka_waktu'].$periode_jangka_waktu.'</div>';
			$row[] = $aksi;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_account_saving_by_cif()
	{
		$nik 	= $this->input->post('nik');
		$data 		= $this->model_nasabah->get_account_saving_by_cif($nik);

		if(count($data)==0){
          $return = "0";
        }else{
          $return = $data['account_saving_no'];
        }

		echo $return;
	}

	public function registrasi_akad()
	{
		$data['container'] 	= 'transaction/registrasi_akad';
		// $data['product'] = $this->model_transaction->get_product_financing();
		$date_current 		= $this->model_transaction->date_current();

		$tgl 		  = substr("$date_current",8,2);
	    $bln 		  = substr("$date_current",5,2);
	    $thn	 	  = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;

		$tgl_pencairan  = date('Y-m-d',strtotime($date_current. '+'.'7'.' days'));
		$tgl1 			= substr("$tgl_pencairan",8,2);
	    $bln1 			= substr("$tgl_pencairan",5,2);
	    $thn1	 		= substr("$tgl_pencairan",0,4);
	    $tanggal_cair	= "$tgl1/$bln1/$thn1";
	    $data['tanggal_pencairan'] = $tanggal_cair;


		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);
	}

	public function datatable_registrasi_akad()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$product_code = $_GET['product_code'];

		$aColumns = array( 
							 'mfi_account_financing_reg.registration_no'
							,'mfi_cif.cif_no'
							,'mfi_cif.nama'
							,'mfi_account_financing_reg.amount'
							,'mfi_account_financing_reg.tanggal_pengajuan'
							,'mfi_account_financing_reg.approve_date'
							,'mfi_list_code_detail.display_text'
							,'mfi_account_financing.status_rekening'
							,'mfi_product_financing.product_name'
							);
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_registrasi_akad($sWhere,$sOrder,$sLimit,$product_code); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_registrasi_akad($sWhere,'','',$product_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_registrasi_akad('','','',$product_code); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			if($aRow['financing_is_exist']==1){
			  $label = '<a href="javascript:;" class="btn mini purple" account_financing_no="'.$aRow['account_financing_no'].'" product_code="'.$aRow['product_code'].'" id="link-edit"> Edit</a>';
			}else{
			  $label = '<a href="javascript:;" class="btn mini green" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" product_code="'.$aRow['product_code'].'" nik="'.$aRow['cif_no'].'" id="link-regis"> Regis</a>';
			}

			$nik=' <span class="btn mini green-stripe">'.$aRow['cif_no'].'</span>';

			$row = array();
			$row[] = $aRow['registration_no'];
			$row[] = $nik;
			$row[] = $aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = date('d-m-Y H:i:s',strtotime($aRow['approve_date']));
			// $row[] = $aRow['display_peruntukan'];
			$row[] = $aRow['pengajuan_melalui'];
			$row[] = $aRow['product_name'];
			$row[] = '<div align="center">'.$label.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_date_regis_by_tglakad()
	{
		$nValid = true;

		$jangka_waktu = $this->input->post('jangka_waktu');
		$akad = $this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		// $tgl_akad = str_replace("_","",$this->input->post('tgl_akad'));
		$len = strlen($akad);
		// $expl = explode("/",$tgl_akad);
		// $akad = $expl[2].'-'.$expl[1].'-'.$expl[0];

		$angsuranke1 = date("d/m/Y",strtotime($akad." + 1 month"));
		$tgl_jtempo = date("d/m/Y",strtotime($akad." + $jangka_waktu month"));

		$angsuranke1 = '25'.substr($angsuranke1,2,10);
		$tgl_jtempo = '25'.substr($tgl_jtempo,2,10);

		$return = ($len==10) ? $angsuranke1.'|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	function get_date_regis_by_angs1()
	{
		$nValid = true;

		$jangka_waktu = $this->input->post('jangka_waktu');
		// $angs1 = $this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		$angsuranke1 = $this->input->post('angsuranke1');
		$len = strlen($angsuranke1);
		if($len==8 && substr($akad,2,1)!='/'){
			$angsuranke1 = substr($angsuranke1,0,2).'/'.substr($angsuranke1,2,2).'/'.substr($angsuranke1,4,4);
			$len = strlen($angsuranke1);
		}
		$expl = explode('/', $angsuranke1);
		// $expl = explode("/",$angsuranke1);
		$angs1 = $expl[2].'-'.$expl[1].'-'.$expl[0];

		$tgl_jtempo = date("d/m/Y",strtotime($angs1." + $jangka_waktu month"));

		$return = ($len==10) ? 'yes|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	public function get_data_for_akad_by_account_financing_reg_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$nik = $this->input->post('nik');
		$data = $this->model_nasabah->get_data_for_akad_by_account_financing_reg_id($account_financing_reg_id);
		// $data['saldo_kewajiban_ke_koptel'] = $this->model_transaction->get_summary_saldo_kewajiban($nik);
		if ($data['cif_flag']==0) { // by pegawai
			$data['thp'] = $data['thp'];
			$data['thp_40'] = $data['thp']*40/100;
		
			$usia = $this->get_usia_menurut_asuransi($data['tgl_lahir'],$data['tanggal_pengajuan']);
			$data['usia2'] = $usia;
			$data['biaya_asuransi'] = $data['premi_asuransi']+$data['premi_asuransi_tambahan'];
		} else { // by kopegtel
			$data['usia2'] = 0;
			$data['biaya_asuransi'] = 0;
		}

		$data['min_margin'] = ceil(($data['amount']*$data['jangka_waktu']*$data['rate_margin1']/1200));
		$data['max_margin'] = ceil(($data['amount']*$data['jangka_waktu']*$data['rate_margin2']/1200));
		if($data['jenis_margin']!='1') //efektif / anuitas
		{
			$data['min_margin'] = '0';
			$data['max_margin'] = $data['amount'];
		}

		echo json_encode($data);
	}

	public function get_data_for_akad_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_data_for_akad_by_account_financing_no($account_financing_no);
		// $data['thp'] = $data['thp'];
		// $data['thp_40'] = $data['thp']*40/100;
		// $data['min_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin1']/1200);
		// $data['max_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin2']/1200);
		// if($data['jenis_margin']!='1') 
		// {
		// 	$data['min_margin'] = '0';
		// 	$data['max_margin'] = $data['amount'];
		// }

		if ($data['cif_flag']==0) { // by pegawai
			$data['thp'] = $data['thp'];
			$data['thp_40'] = $data['thp']*40/100;
		}

		$data['min_margin'] = ceil(($data['amount']*$data['jangka_waktu']*$data['rate_margin1']/1200));
		$data['max_margin'] = ceil(($data['amount']*$data['jangka_waktu']*$data['rate_margin2']/1200));
		if($data['jenis_margin']!='1') //efektif
		{
			$data['min_margin'] = '0';
			$data['max_margin'] = $data['amount'];
		}

		echo json_encode($data);
	}

	public function compare_masa_pensiun()
	{
		$tgl_jtempo = $this->input->post('tgl_jtempo');
		$masa_pensiun = $this->input->post('masa_pensiun');

		$expl = explode("/",$tgl_jtempo);
		$akhir_kontrak = $expl[2].'-'.$expl[1].'-'.$expl[0];


		$pensiun = strtotime($masa_pensiun);
		$akhir = strtotime($akhir_kontrak);
		// echo $pensiun." | ".$akhir; die();

		if($akhir<$pensiun){
          $return = 'true';
        }else{
          $return = 'false';
        }

		echo $return;
	}
 
	public function proses_registrasi_akad_pembiayaan()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$registration_no				= $this->input->post('registration_no');
		$nama_bank				= $this->input->post('nama_bank');
		$no_rekening			= $this->input->post('no_rekening');
		$atasnama_rekening		= $this->input->post('atasnama_rekening');
		$bank_cabang 			= $this->input->post('bank_cabang');
		$account_saving_no		= $this->input->post('account_saving_no');
		$jumlah_margin			= $this->input->post('jumlah_margin');
		$angsuran_pokok			= $this->input->post('angsuran_pokok');
		$angsuran_margin		= $this->input->post('angsuran_margin');
		$biaya_adm				= $this->input->post('biaya_adm');
		$biaya_asuransi			= $this->input->post('biaya_asuransi');
		$biaya_notaris			= $this->input->post('biaya_notaris');
		$tgl_akad				= $this->input->post('tgl_akad');
		$tanggal_pengajuan		= $this->input->post('tanggal_pengajuan');
		$angsuranke1			= $this->input->post('angsuranke1');
		$tgl_jtempo				= $this->input->post('tgl_jtempo');
		$pelunasan_ke_kopeg_mana= $this->input->post('pelunasan_ke_kopeg_mana');
		$melalui 	 			= $this->input->post('melalui');
		$kopegtel 	 			= $this->input->post('kopegtel');
		$val_akad 	 			= $this->input->post('val_akad');
		$nisbah 	 			= $this->input->post('nisbah');
		$alamat_lokasi_kerja 	= $this->input->post('alamat_lokasi_kerja');
		if($nisbah=='')$nisbah=0;
		$amount_proyeksi_keuntungan = $this->convert_numeric($this->input->post('amount_proyeksi_keuntungan'));
		if ($amount_proyeksi_keuntungan=="") $amount_proyeksi_keuntungan = 0;
		if ($nisbah=="") $nisbah = NULL;

		$expltgl_akad=explode("/",$tgl_akad);
		$explangsuranke1=explode("/",$angsuranke1);
		$expltgl_jtempo=explode("/",$tgl_jtempo);
		$expltanggal_pengajuan=explode("/",$tanggal_pengajuan);

		$tanggal_akad = $expltgl_akad[2].'-'.$expltgl_akad[1].'-'.$expltgl_akad[0];
		$tanggal_mulai_angsur = $explangsuranke1[2].'-'.$explangsuranke1[1].'-'.$explangsuranke1[0];
		$tanggal_jtempo = $expltgl_jtempo[2].'-'.$expltgl_jtempo[1].'-'.$expltgl_jtempo[0];
		$tanggal_pengajuan = $expltanggal_pengajuan[2].'-'.$expltanggal_pengajuan[1].'-'.$expltanggal_pengajuan[0];
		// echo $account_saving_no; die();

		$data_reg = $this->model_nasabah->select_financing_reg_by_id($account_financing_reg_id);


		//Generate akad_no by product_code and year
		$product_code 	 		= $this->input->post('product_code_post');
		$counter_year 	= date('Y');
	    $counter 		= $this->model_nasabah->get_counter_akad($product_code,$counter_year,true);
	    $new_counter 	= $counter+1;
	    $akad_no  = date('y').str_pad($new_counter, 5, '0',STR_PAD_LEFT);

		
		$jumlah_angsuran 		= $this->input->post('jumlah_angsuran');
		$lunasi_ke_kopegtel 	= $this->input->post('lunasi_ke_kopegtel');
		$lunasi_kopegtel 		= ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		if($jumlah_angsuran==false){$jumlah_angsuran=0;}
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}

		$jumlah_kewajiban 		= $this->input->post('jumlah_kewajiban');
		$lunasi_ke_koptel 			= $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel 			= ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel 	= $this->input->post('saldo_kewajiban_ke_koptel');
		if($jumlah_kewajiban==false){$jumlah_kewajiban=0;}
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		/*
		** insert into mfi_account_financing
		*/

		$data=$this->model_transaction->get_seq_account_financing_no($data_reg['product_code'],$data_reg['cif_no']);
		$jumlah=(int)$data['jumlah'];
		if(count($data)>0){
			$newseq=$jumlah+1;
			if($jumlah<10){
				$newseq='0'.$newseq;
			}
		}else{
			$newseq='01';
		}

		$account_financing_no = $data_reg['cif_no'].$data_reg['product_code'].$newseq;

		$flag_jadwal_angsuran = $this->input->post('flag_jadwal_angsuran');
		// var_dump($flag_jadwal_angsuran);
		if ($flag_jadwal_angsuran!='0') {
			$flag_jadwal_angsuran = '1';
		}
		$itgl_angsur = $this->input->post('tgl_angsur');
		$Bangs_margin = $this->input->post('angs_margin');
		$Bangs_pokok = $this->input->post('angs_pokok');

		$data_batch_angsuran = array();
		// echo $flag_jadwal_angsuran;
		// print_r($itgl_angsur);
		if($flag_jadwal_angsuran==0){

			for ($i=0; $i<count($itgl_angsur); $i++)
			{
				if ($i==0) {
					$angsuran_pokok = $this->convert_numeric($Bangs_pokok[$i]);
					$angsuran_margin = $this->convert_numeric($Bangs_margin[$i]);
				}
				if ( $this->datepicker_convert(true,$itgl_angsur[$i],'/') != '' && $this->convert_numeric($Bangs_pokok[$i]) != 0 && $this->convert_numeric($Bangs_margin[$i]) != 0)
				$data_batch_angsuran[] = array(
						 'account_financing_schedulle_id' => uuid(false)
						,'account_no_financing' => $account_financing_no
						,'tangga_jtempo' 		=> $this->datepicker_convert(true,$itgl_angsur[$i],'/')
						,'angsuran_pokok' 		=> $this->convert_numeric($Bangs_pokok[$i])
						,'angsuran_margin' 		=> $this->convert_numeric($Bangs_margin[$i])
					);

			}
		}
		// echo "<pre>";
		// print_r($this->input->post('angs_pokok'));
		// print_r($data_batch_angsuran);
		// die();


		/*
		** UPDATE DATA REKENING
		*/
			$data_update_rekening = array(
										 'nama_bank'=>$nama_bank
										,'no_rekening'=>$no_rekening
										,'atasnama_rekening'=>$atasnama_rekening
										,'bank_cabang'=>$bank_cabang
										,'alamat_lokasi_kerja'=>$alamat_lokasi_kerja
									);
			$param_update_cif = array('cif_no'=>$data_reg['cif_no']);

			$data_update_financing_reg = array(
										 'pengajuan_melalui'		=>$melalui
										,'kopegtel_code'			=>$kopegtel
										,'nama_bank'				=>$nama_bank
										,'no_rekening'				=>$no_rekening
										,'atasnama_rekening'		=>$atasnama_rekening
										,'bank_cabang'				=>$bank_cabang
										,'lunasi_ke_kopegtel'		=>$lunasi_kopegtel
										,'saldo_kewajiban'			=>$this->convert_numeric($saldo_kewajiban)
										,'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok)
										,'angsuran_margin'			=>$this->convert_numeric($angsuran_margin)
										,'jumlah_angsuran'			=>$this->convert_numeric($jumlah_angsuran)
										,'jumlah_kewajiban'			=>$this->convert_numeric($jumlah_kewajiban)
										,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
										,'biaya_administrasi' 		=>$this->convert_numeric($biaya_adm)
										,'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris)
										,'premi_asuransi' 		=>$this->convert_numeric($biaya_asuransi)
										,'tanggal_pengajuan'			=>$tanggal_pengajuan
									);
			$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
		/*
		** END UPDATE DATA REKENING
		*/
		$data_insert_to_financing = array(
					 'product_code'				=>$data_reg['product_code']
					,'branch_code'				=>$data_reg['branch_code']
					,'cif_no' 					=>$data_reg['cif_no']
					,'account_financing_no' 	=>$account_financing_no
					// ,'akad_code' 				=>$data_reg['akad_code']
					,'akad_code' 				=>$val_akad
					,'pokok'		 			=>$this->convert_numeric($data_reg['amount'])
					,'margin' 					=>$this->convert_numeric($jumlah_margin)
					,'saldo_pokok' 				=>$this->convert_numeric($data_reg['amount'])
					,'saldo_margin'				=>$this->convert_numeric($jumlah_margin)
					,'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok)
					,'angsuran_margin'			=>$this->convert_numeric($angsuran_margin)
					,'periode_jangka_waktu'	 	=>2 //bulanan
					,'jangka_waktu' 			=>$data_reg['jangka_waktu']
					// ,'tanggal_pengajuan'		=>$data_reg['tanggal_pengajuan']
					,'cadangan_resiko' 			=>0
					,'biaya_administrasi' 		=>$this->convert_numeric($biaya_adm)
					,'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris)
					,'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi)
					,'biaya_asuransi_jaminan' 	=>0
					,'dana_kebajikan'			=>0
					,'created_by'				=>$this->session->userdata('user_id')
					,'created_date'				=>date('Y-m-d H:i:s')
					,'program_code'				=>$data_reg['product_code']
					,'flag_jadwal_angsuran'		=>$flag_jadwal_angsuran
					,'peruntukan' 				=>$data_reg['peruntukan']
					,'registration_no'			=>$data_reg['registration_no']
					,'uang_muka'				=>0
					,'tanggal_registrasi'		=>$tanggal_pengajuan
					,'flag_wakalah'				=>1
					,'titipan_notaris'			=>0
					,'simpanan_wajib_pinjam'	=>0
					,'account_saving_no'		=>$account_saving_no
					,'tanggal_akad'				=>$tanggal_akad
					,'tanggal_mulai_angsur'		=>$tanggal_mulai_angsur
					,'tanggal_jtempo'			=>$tanggal_jtempo
					,'jtempo_angsuran_last'		=>$tanggal_akad
					,'jtempo_angsuran_next'		=>$tanggal_mulai_angsur
					,'akad_no'					=>$akad_no
					,'nisbah_bagihasil'			=>$nisbah
					,'amount_proyeksi_keuntungan'=>$amount_proyeksi_keuntungan
					,'tanggal_pengajuan'			=>$tanggal_pengajuan
				);
		/*
		** END insert into mfi_account_financing
		*/
 
 
		$count_financing = $this->model_nasabah->get_count_financing_by_reg($account_financing_reg_id); 
		if ($count_financing>0) { 

			$return = array('success'=>false,'message'=>'Pembiayaan ini sudah terdaftar. Please contact your administrator!'); 
 
		} else { 
 
			$this->db->trans_begin(); 
			$this->model_transaction->add_rekening_pembiayaan($data_insert_to_financing); 

			$this->model_nasabah->update_cif($data_update_rekening,$param_update_cif); 

			if(count($data_batch_angsuran)>0){ 
				$this->model_nasabah->insert_batch_schedulle($data_batch_angsuran); 
			} 

			$lunasi_ke_koptel = 0;
			$saldo_kewajiban_ke_koptel = 0;
		    $flag_registrasi = $this->input->post('flag_registrasi');
			if ( $flag_registrasi != "" )
			{
		        $check_saldo_val = $this->input->post('check_saldo_val');
		        $account_financing_no_val = $this->input->post('account_financing_no');
		        $check_saldo_pokok = $this->input->post('check_saldo_pokok');
		        $check_saldo_margin = $this->input->post('check_saldo_margin');
		        $data_fn_lunas = array();

			    for($i=0; $i<count($check_saldo_pokok); $i++){
			        if($check_saldo_val[$i]=='1'){
			          $data_fn_lunas[]=array(
			             'registration_no' => $registration_no
			            ,'saldo_pokok' => $check_saldo_pokok[$i]
			            ,'saldo_margin' => $check_saldo_margin[$i]
			            ,'account_financing_no' => $account_financing_no_val[$i]
			            ,'flag_registrasi' => $flag_registrasi
			          );
			          //maka saldo kewajiban diupdate;
			          $lunasi_ke_koptel = 1;
			          $saldo_kewajiban_ke_koptel += $check_saldo_pokok[$i];
					  $data_update_financing_reg['lunasi_ke_koptel'] = $lunasi_ke_koptel; 
					  $data_update_financing_reg['saldo_kewajiban_ke_koptel'] = $saldo_kewajiban_ke_koptel; 
			          //end maka saldo kewajiban diupdate;
			          //delete yang sebelumnya
			    		$param_fn_lunas = array('registration_no' => $registration_no, 'account_financing_no' => $account_financing_no_val[$i]);
						$this->db->delete('mfi_account_financing_reg_lunas',$param_fn_lunas);
			          //end delete yang sebelumnya
			        }
			    }

			    // echo "<pre>";
			    // print_r($data_fn_lunas);
			    // die();

				if(count($data_fn_lunas)>0){
					$this->db->insert_batch('mfi_account_financing_reg_lunas',$data_fn_lunas);
				}
			}
			
			$this->model_nasabah->edit_pengajuan_pembiayaan($data_update_financing_reg,$param_update_financing_reg);

			if($this->db->trans_status()===true){ 
				$this->db->trans_commit(); 
				$return = array('success'=>true,'message'=>'Registrasi Akad SUKSES! ');
			}else{ 
				$this->db->trans_rollback(); 
				$return = array('success'=>false,'message'=>'Failed to connect into databases, Please contact your administrator!'); 
			} 

		} 
 
		echo json_encode($return); 
	}

	public function proses_update_akad_pembiayaan()
	{
		$account_financing_id	= $this->input->post('account_financing_id');

		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		
		$nik					= $this->input->post('nik');
		$nama_bank				= $this->input->post('nama_bank');
		$no_rekening			= $this->input->post('no_rekening');
		$atasnama_rekening		= $this->input->post('atasnama_rekening');
		$bank_cabang 			= $this->input->post('bank_cabang');
		
		$jumlah_margin			= $this->input->post('jumlah_margin');
		$angsuran_pokok			= $this->input->post('angsuran_pokok');
		$angsuran_margin		= $this->input->post('angsuran_margin');
		$biaya_adm				= $this->input->post('biaya_adm');
		$biaya_asuransi			= $this->input->post('biaya_asuransi');
		$biaya_notaris			= $this->input->post('biaya_notaris');
		$tgl_akad				= $this->input->post('tgl_akad');
		$tanggal_pengajuan		= $this->input->post('tanggal_pengajuan');
		$angsuranke1			= $this->input->post('angsuranke1');
		$tgl_jtempo				= $this->input->post('tgl_jtempo');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$melalui 	 			= $this->input->post('melalui');
		$kopegtel 	 			= $this->input->post('kopegtel');
		$alamat_lokasi_kerja 	= $this->input->post('alamat_lokasi_kerja');

		$expltgl_akad=explode("/",$tgl_akad);
		$explangsuranke1=explode("/",$angsuranke1);
		$expltgl_jtempo=explode("/",$tgl_jtempo);
		$expltanggal_pengajuan=explode("/",$tanggal_pengajuan);

		$tanggal_akad = $expltgl_akad[2].'-'.$expltgl_akad[1].'-'.$expltgl_akad[0];
		$tanggal_mulai_angsur = $explangsuranke1[2].'-'.$explangsuranke1[1].'-'.$explangsuranke1[0];
		$tanggal_jtempo = $expltgl_jtempo[2].'-'.$expltgl_jtempo[1].'-'.$expltgl_jtempo[0];
		$tanggal_pengajuan = $expltanggal_pengajuan[2].'-'.$expltanggal_pengajuan[1].'-'.$expltanggal_pengajuan[0];

		
		$jumlah_angsuran 	= $this->input->post('jumlah_angsuran');
		$lunasi_ke_kopegtel 	= $this->input->post('lunasi_ke_kopegtel');
		$lunasi_kopegtel 		= ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}
		if($jumlah_angsuran==false){$jumlah_angsuran=0;}

		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$lunasi_ke_koptel 			= $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel 			= ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel 	= $this->input->post('saldo_kewajiban_ke_koptel');
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}
		if($jumlah_kewajiban==false){$jumlah_kewajiban=0;}

		if($angsuran_pokok=='')$angsuran_pokok=0;
		if($angsuran_margin=='')$angsuran_margin=0;
		
		/*
		** update data rekening
		*/
			$data_update_cif = array(
										 'nama_bank'=>$nama_bank
										,'no_rekening'=>$no_rekening
										,'atasnama_rekening'=>$atasnama_rekening
										,'bank_cabang'=>$bank_cabang
										,'alamat_lokasi_kerja'=>$alamat_lokasi_kerja
									);
			$param_update_cif = array('cif_no'=>$nik);

			$data_update_financing_reg = array(
										 'pengajuan_melalui'		=>$melalui
										,'kopegtel_code'			=>$kopegtel
										,'nama_bank'				=>$nama_bank
										,'no_rekening'				=>$no_rekening
										,'atasnama_rekening'		=>$atasnama_rekening
										,'bank_cabang'				=>$bank_cabang
										,'lunasi_ke_kopegtel'		=>$lunasi_kopegtel
										,'saldo_kewajiban'			=>$this->convert_numeric($saldo_kewajiban)
										,'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok)
										,'angsuran_margin'			=>$this->convert_numeric($angsuran_margin)
										,'jumlah_angsuran'			=>$this->convert_numeric($jumlah_angsuran)
										,'jumlah_kewajiban'			=>$this->convert_numeric($jumlah_kewajiban)
										,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
										,'biaya_administrasi'=>$this->convert_numeric($biaya_adm)
										,'biaya_notaris'=>$this->convert_numeric($biaya_notaris)
										,'premi_asuransi'=>$this->convert_numeric($biaya_asuransi)
										,'tanggal_pengajuan'			=>$tanggal_pengajuan
									);
			$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
		/*
		** end update data rekening
		*/

		

		$account_financing_no = $this->input->post('account_financing_no');
		$flag_jadwal_angsuran = $this->input->post('flag_jadwal_angsuran');
		$itgl_angsur = $this->input->post('tgl_angsur');
		$Bangs_margin = $this->input->post('angs_margin');
		$Bangs_pokok = $this->input->post('angs_pokok');

		$v_angsuran_pokok = 0;
		$v_angsuran_margin = 0;


		$data_batch_angsuran = array();
		if($flag_jadwal_angsuran==0){
			for ($i=0; $i<count($itgl_angsur); $i++)
			{
				$angsuran_pokok = str_replace(',','_',$Bangs_pokok[$i]);
				$angsuran_margin = str_replace(',','_',$Bangs_margin[$i]);
				$angsuran_pokok = str_replace('.','',$angsuran_pokok);
				$angsuran_margin = str_replace('.','',$angsuran_margin);
				$angsuran_pokok = str_replace('_','.',$angsuran_pokok);
				$angsuran_margin = str_replace('_','.',$angsuran_margin);

				if ($i==0) {
					$v_angsuran_pokok = $angsuran_pokok;
					$v_angsuran_margin = $angsuran_margin;
				}

				$data_batch_angsuran[] = array(
						 'account_no_financing' => $account_financing_no
						,'tangga_jtempo' 		=> $this->datepicker_convert(true,$itgl_angsur[$i],'/')
						,'angsuran_pokok' 		=> $angsuran_pokok
						,'angsuran_margin' 		=> $angsuran_margin
					);

			}
			$param_delete_schedulle = array('account_no_financing'=>$account_financing_no);
		}

		// echo "<pre>";
		// print_r($param_delete_schedulle);
		// print_r($data_batch_angsuran);
		// die();

		if ($flag_jadwal_angsuran==0) {
			if (count($itgl_angsur)>0) {
				$angsuran_pokok = $v_angsuran_pokok;
				$angsuran_margin = $v_angsuran_margin;
			}
		}

		$data_update_to_financing = array(
					 'margin' 					=>$this->convert_numeric($jumlah_margin)
					,'saldo_margin'				=>$this->convert_numeric($jumlah_margin)
					,'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok)
					,'angsuran_margin'			=>$this->convert_numeric($angsuran_margin)
					,'biaya_administrasi' 		=>$this->convert_numeric($biaya_adm)
					,'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris)
					,'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi)
					,'tanggal_akad'				=>$tanggal_akad
					,'tanggal_mulai_angsur'		=>$tanggal_mulai_angsur
					,'tanggal_jtempo'			=>$tanggal_jtempo
					,'tanggal_pengajuan'			=>$tanggal_pengajuan
				);
		/*
		** END insert into mfi_account_financing
		*/

		$param = array('account_financing_id'=>$account_financing_id);

		$this->db->trans_begin();
		$this->model_transaction->update_to_mfi_financing($data_update_to_financing,$param);
	
		$this->model_nasabah->update_cif($data_update_cif,$param_update_cif);
		// echo 'a';
		if(count($data_batch_angsuran)>0){
			$this->model_nasabah->delete_batch_schedulle($param_delete_schedulle);
			$this->model_nasabah->insert_batch_schedulle($data_batch_angsuran);
		}

		$registration_no_val = $this->model_transaction->get_registrasion_no_by_id($account_financing_reg_id);
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no_arr = $this->input->post('account_financing_no_arr');
		$no_pembiayaan = $this->input->post('no_pembiayaan');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));
		$data_fn_lunas = array();

		$lunasi_ke_koptel = 0;
		$saldo_kewajiban_ke_koptel = 0;
		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$data_fn_lunas[]=array(
					 'registration_no' => $registration_no_val
					,'saldo_pokok' => $check_saldo_pokok[$i]
					,'saldo_margin' => $check_saldo_margin[$i]
					,'account_financing_no' => $account_financing_no_arr[$i]
					,'flag_registrasi' => '1'
				);
				$lunasi_ke_koptel = 1;
				$saldo_kewajiban_ke_koptel += $check_saldo_pokok[$i];
				$data_update_financing_reg['lunasi_ke_koptel'] = $lunasi_ke_koptel; 
				$data_update_financing_reg['saldo_kewajiban_ke_koptel'] = $saldo_kewajiban_ke_koptel; 
			}
		}

		$this->model_nasabah->edit_pengajuan_pembiayaan($data_update_financing_reg,$param_update_financing_reg);
		// echo "<pre>";
		// print_r($data_fn_lunas);
		// die();

		$param_lunas_reg = array(
							 'account_financing_no' => $no_pembiayaan
							,'flag_registrasi' => '1'
						);

		if(count($data_fn_lunas)>0){
			$this->db->delete('mfi_account_financing_reg_lunas',$param_lunas_reg);
			if (count($data_fn_lunas)>0){
				$this->db->insert_batch('mfi_account_financing_reg_lunas',$data_fn_lunas);
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function cek_flag_thp100()
	{
		$nik 	= $this->input->post('nik');
		$data 		= $this->model_nasabah->cek_flag_thp100($nik);
		$data2 		= $this->model_nasabah->count_kopegtel_code_by_nik($nik);

		if(count($data)==0){
          $total = "0|".$data2;
        }else{
          $total = $data['nik'].'|'.$data2;
        }

		echo $total;
	}

	public function get_kopegtel_list_by_nik()
	{
		$nik 	= $this->input->post('nik');

		$datas 		= $this->model_nasabah->get_kopegtel_list_by_nik($nik);

		echo json_encode($datas);
	}
	/*
	//end pengajuan pembiayaan koptel 
	*/
	function registrasi_transfer_pencairan()
	{

		$data['container'] 	= 'nasabah/registrasi_transfer_pencairan';
		$this->load->view('core',$data);
	}
	function datatable_registrasi_transfer_pencairan()
	{
		$aColumns = array( 'a.account_financing_no','c.nama','b.droping_date','a.pokok','');
		// $cm_code = @$_GET['cm_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_registrasi_transfer_pencairan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_registrasi_transfer_pencairan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_registrasi_transfer_pencairan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['droping_date'])).'</div>';
			$row[] = '<div align="right">'.number_format($aRow['pokok'],0,',','.').'</div>';
			$row[] = '<div align="center"><a href="javascript:void(0);" class="btn mini green" data-cif_no="'.$aRow['cif_no'].'" data-account_financing_no="'.$aRow['account_financing_no'].'" id="link-registrasi">Registrasi</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_data_registrasi_transfer_pencairan()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_data_registrasi_transfer_pencairan($account_financing_no);
		 $data['jumlah_transfer'] = ($data['pokok']-($data['angsuran_pertama']+$data['biaya_administrasi']+$data['biaya_notaris']+$data['biaya_asuransi_jiwa']+$data['kewajiban_koptel']+$data['kewajiban_kopegtel']));
		//$data['jumlah_transfer'] = ($data['pokok']-$data['angsuran_pertama']-$data['kewajiban_koptel']);
		echo json_encode($data);
	}
	function do_registrasi_transfer_pencairan()
	{
		$account_financing_no = $this->input->post('no_pembiayaan');
		$tanggal_transfer = $this->datepicker_convert(true,$this->input->post('tanggal_transfer'),'/');

		$data = array(
				// 'status_transfer'=>1,
				'tanggal_transfer'=>$tanggal_transfer
			);
		$param = array('account_financing_no'=>$account_financing_no);

		$this->db->trans_begin();
		$this->model_nasabah->do_registrasi_transfer_pencairan($data,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to connect into databases, please contact your administrator.');
		}

		echo json_encode($return);
	}
	function cetak_transfer_pencairan()
	{
		$data['container'] 	= 'nasabah/cetak_transfer_pencairan';
		$this->load->view('core',$data);
	}
	function do_cetak_transfer_pencairan()
	{
		$no_spb = str_replace("%20", " ", $this->uri->segment(3));
		$datas = $this->model_nasabah->get_data_cetak_transfer_pencairan($no_spb);

		$data['datas'] = $datas;
		$data['tanggal_transfer'] = (!isset($datas[0]['tanggal_spb']))?'':$datas[0]['tanggal_spb'];
		$data['no_spb'] = $no_spb;

		if (isset($datas[0]['jenis_pembiayaan'])) {
			$product_name = (!isset($datas[0]['jenis_pembiayaan']))?'':$datas[0]['jenis_pembiayaan'];
		} else {
			$product_name = '-';
		}

		$data['product_name'] = $product_name;

		if ($this->uri->segment(4)=='previewPDF') {
			$this->cetak_pdf_transfer_pencairan($data);
		} else if ($this->uri->segment(4)=='previewXLS') {
			$this->cetak_xls_transfer_pencairan($data);
		} else {
			show_404();
		}
	}

	function get_no_spb_by_tgl()
	{
		$tgl = $this->input->post('tanggal_spb');
		$tgl_ = substr($tgl,4,4).'-'.substr($tgl,2,2).'-'.substr($tgl,0,2);
		$datas = $this->model_nasabah->get_no_spb_by_tgl($tgl_);
		echo json_encode($datas);
	}

	private function cetak_pdf_transfer_pencairan($datas)
	{
		$data['datas'] = $datas['datas'];
		$tanggal_transfer = $datas['tanggal_transfer'];

		ob_start();

        $this->load->view('nasabah/cetak_pdf_transfer_pencairan',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('CETAK PDF TRANSFER PENCAIRAN".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }

	}
	
	private function cetak_xls_transfer_pencairan($datas)
	{
		$data = $datas['datas'];
		$tanggal_transfer = $datas['tanggal_transfer'];
		$no_spb = $datas['no_spb'];
		$product_name = $datas['product_name'];

		$this->load->library('phpexcel');
		// Create new PHPExcel object
		$objPHPExcel = $this->phpexcel;
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
									 ->setLastModifiedBy("MICROFINANCE")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("REPORT, generated using PHP classes.")
									 ->setKeywords("REPORT")
									 ->setCategory("Test result file");
		$objPHPExcel->setActiveSheetIndex(0); 
		$styleArray = array(
       		'borders' => array(
		             'outline' => array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                    'color' => array('rgb' => '000000'),
		             ),
		       ),
		);
		$sheet = $objPHPExcel->getActiveSheet();
		$cols = array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');
		$nRow=1;

		//SET ROW HEIGHT
		$sheet->getRowDimension('2')->setRowHeight(60);
		$sheet->getRowDimension('3')->setRowHeight(20);
		$sheet->getRowDimension('4')->setRowHeight(20);
		$sheet->getRowDimension('5')->setRowHeight(20);
		$sheet->getRowDimension('6')->setRowHeight(25);
		$sheet->getColumnDimension('A')->setWidth(0);
		$sheet->getColumnDimension('B')->setWidth(1);
		$sheet->getColumnDimension('C')->setWidth(6);
		$sheet->getColumnDimension('D')->setWidth(10);
		$sheet->getColumnDimension('E')->setWidth(25);
		$sheet->getColumnDimension('F')->setWidth(0);
		$sheet->getColumnDimension('G')->setWidth(30);
		$sheet->getColumnDimension('H')->setWidth(17);
		$sheet->getColumnDimension('I')->setWidth(25);
		$sheet->getColumnDimension('J')->setWidth(17);
		$sheet->getColumnDimension('K')->setWidth(35);
		$sheet->getColumnDimension('L')->setWidth(14);
		$sheet->getColumnDimension('M')->setWidth(14);
		$sheet->getColumnDimension('N')->setWidth(14);
		$sheet->getColumnDimension('O')->setWidth(14);
		$sheet->getColumnDimension('P')->setWidth(14);
		$sheet->getColumnDimension('Q')->setWidth(14);
		$sheet->getColumnDimension('R')->setWidth(14);
		$sheet->getColumnDimension('S')->setWidth(14);
		$sheet->getColumnDimension('T')->setWidth(14);
		$sheet->getColumnDimension('U')->setWidth(14);
		$sheet->getColumnDimension('V')->setWidth(14);
		$sheet->getColumnDimension('W')->setWidth(14);

		$nRow++;
		$sheet->mergeCells('C'.$nRow.':V'.$nRow);
		$sheet->setCellValue('C'.$nRow,'DAFTAR PENYALURAN PEMBIAYAAN '.$product_name.' TAHUN '.date('Y'));
		$sheet->getStyle('C'.$nRow)->getFont()->setSize(20)
											  ->setUnderline('single')
											  ->setBold(true);
		$sheet->getStyle('C'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
												   ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$nRow=$nRow+1;
		$sheet->mergeCells('C'.$nRow.':C'.($nRow+2));
		$sheet->setCellValue('C'.$nRow,'NO');

		$sheet->mergeCells('D'.$nRow.':D'.($nRow+2));
		$sheet->setCellValue('D'.$nRow,'NIK');

		$sheet->mergeCells('E'.$nRow.':E'.($nRow+2));
		$sheet->setCellValue('E'.$nRow,'NAMA');

		$sheet->mergeCells('F'.$nRow.':F'.($nRow+2));
		$sheet->setCellValue('F'.$nRow,'TANGGAL LAHIR');

		$sheet->mergeCells('G'.$nRow.':G'.($nRow+2));
		$sheet->setCellValue('G'.$nRow,'HR AREA');

		$sheet->mergeCells('H'.($nRow+1).':H'.($nRow+2));
		$sheet->setCellValue('H'.$nRow,'JENIS');
		$sheet->setCellValue('H'.($nRow+1),'PEMBIAYAAN');

		$sheet->mergeCells('I'.$nRow.':I'.($nRow+2));
		$sheet->setCellValue('I'.$nRow,'BANK/CABANG');

		$sheet->mergeCells('J'.$nRow.':J'.($nRow+2));
		$sheet->setCellValue('J'.$nRow,'NOMOR');

		$sheet->mergeCells('K'.$nRow.':K'.($nRow+2));
		$sheet->setCellValue('K'.$nRow,'ATAS NAMA');

		$sheet->mergeCells('L'.($nRow+1).':L'.($nRow+2));
		$sheet->setCellValue('L'.$nRow,'BESAR');
		$sheet->setCellValue('L'.($nRow+1),'PEMBIAYAAN');

		$sheet->setCellValue('M'.$nRow,'POTONGAN');
		$sheet->setCellValue('M'.($nRow+1),'PREMI');
		$sheet->setCellValue('M'.($nRow+2),'ASURANSI');

		$sheet->mergeCells('N'.$nRow.':N'.($nRow+2));
		$sheet->setCellValue('N'.$nRow,'UJRAH');

		$sheet->setCellValue('O'.$nRow,'POTONGAN');
		$sheet->setCellValue('O'.($nRow+1),'ANGSURAN');
		$sheet->setCellValue('O'.($nRow+2),'PERTAMA');

		$sheet->setCellValue('P'.$nRow,'BIAYA');
		$sheet->setCellValue('P'.($nRow+1),'ADMINISTRASI');

		$sheet->setCellValue('Q'.$nRow,'BIAYA');
		$sheet->setCellValue('Q'.($nRow+1),'NOTARIS');

		$sheet->setCellValue('R'.$nRow,'BIAYA');
		$sheet->setCellValue('R'.($nRow+1),'PREMI');
		$sheet->setCellValue('R'.($nRow+2),'TAMBAHAN');

		$sheet->setCellValue('S'.$nRow,'KOMPENSASI');
		$sheet->setCellValue('S'.($nRow+1),'PELUNASAN');
		$sheet->setCellValue('S'.($nRow+2),'KOPTEL');
		
		$sheet->setCellValue('T'.$nRow,'JUMLAH');
		$sheet->setCellValue('T'.($nRow+1),'KOPTEL');
		$sheet->setCellValue('T'.($nRow+2),'TRANSFER');
		
		$sheet->setCellValue('U'.$nRow,'TRANSFER');
		$sheet->setCellValue('U'.($nRow+1),'PREMI');
		$sheet->setCellValue('U'.($nRow+2),'ASURANSI');

		$sheet->setCellValue('V'.$nRow,'KOMPENSASI');
		$sheet->setCellValue('V'.($nRow+1),'PELUNASAN');
		$sheet->setCellValue('V'.($nRow+2),'KOPEGTEL');

		$sheet->setCellValue('W'.$nRow,'JUMLAH');
		$sheet->setCellValue('W'.($nRow+1),'DITERIMA');
		$sheet->setCellValue('W'.($nRow+2),'KARYAWAN');

		$sheet->getStyle('C'.$nRow.':W'.($nRow+2))->getFont()->setBold(true);

		$sheet->getStyle('C'.$nRow.':W'.($nRow+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
												   ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		for ($i=0;$i<count($cols);$i++) {
			$sheet->getStyle($cols[$i].$nRow.':'.$cols[$i].($nRow+2))->applyFromArray($styleArray);
		}

		$nRow=$nRow+3;
		$SubTitle = array(
       		'borders' => array(
		             'outline' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '000000'),
		            ),
		        ),
       		'font' => array(
       				'bold' => true,
       				'size' => 12,
       				'color' => array('rgb'=>'0000FF')
       			)
		);
		$sheet->mergeCells('C'.$nRow.':W'.$nRow);
		$sheet->setCellValue('C'.$nRow,' DI TRANSFER KE REKENING PRIBADI');
		$sheet->getStyle('C'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('C'.$nRow.':W'.$nRow)->applyFromArray($SubTitle);
		$sheet->getColumnDimension('F')->setVisible(false);
		$nRow++;
		
		$total_L = 0;
		$total_M = 0;
		$total_N = 0;
		$total_O = 0;
		$total_P = 0;
		$total_Q = 0;
		$total_R = 0;
		$total_S = 0;
		$total_T = 0;
		$total_U = 0;
		$total_V = 0;
		$total_W = 0;

		$grand_total_biaya_notaris=0;
		$grand_total_biaya_asuransi=0;

		$no=1;
		foreach($data as $row) {

			$sheet->getRowDimension($nRow)->setRowHeight(20);
			$sheet->getStyle('C'.$nRow.':W'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('C'.$nRow,$no);
			$sheet->setCellValue('D'.$nRow,$row['cif_no']);
			$sheet->setCellValue('E'.$nRow,$row['nama']);
			$sheet->setCellValue('F'.$nRow,'');
			$sheet->setCellValue('G'.$nRow,$row['nama_kopegtel']);
			$sheet->setCellValue('H'.$nRow,$row['jenis_pembiayaan']);
			$sheet->setCellValue('I'.$nRow,$row['nama_bank'].' '.$row['bank_cabang']);
			$sheet->setCellValue('J'.$nRow,$row['no_rekening'].' ');
			$sheet->setCellValue('K'.$nRow,$row['atasnama_rekening']);
			$sheet->setCellValue('L'.$nRow,number_format($row['pokok'],0,',','.').' ');
			$sheet->setCellValue('M'.$nRow,number_format($row['premi_asuransi'],0,',','.').' ');
			// $sheet->setCellValue('M'.$nRow,number_format($row['biaya_asuransi_jiwa'],0,',','.').' ');
			$ujroh = $row['premi_asuransi']*0;
			$sheet->setCellValue('N'.$nRow,number_format($ujroh,0,',','.').' ');
			$angsuran_pertama = $row['angsuran_pertama'];
			$sheet->setCellValue('O'.$nRow,number_format($angsuran_pertama,0,',','.').' ');
			$sheet->setCellValue('P'.$nRow,number_format($row['biaya_administrasi'],0,',','.').' ');
			$sheet->setCellValue('Q'.$nRow,number_format($row['biaya_notaris'],0,',','.').' ');
			$sheet->setCellValue('R'.$nRow,number_format($row['premi_asuransi_tambahan'],0,',','.').' ');
			$sheet->setCellValue('S'.$nRow,number_format($row['outstanding_koptel'],0,',','.').' ');
			$transfer_premi_asuransi = $row['biaya_asuransi_jiwa']-$ujroh;
			// $jumlah_diterima_karyawan = $row['pokok']-$row['biaya_asuransi_jiwa']-$angsuran_pertama-$row['biaya_administrasi']-$row['kewajiban_koptel']-$row['kewajiban_kopegtel'];
			// $jumlah_koptel_transfer = $transfer_premi_asuransi+$row['kewajiban_kopegtel']+$jumlah_diterima_karyawan;
			$jumlah_koptel_transfer = $row['pokok']-$ujroh-$angsuran_pertama-$row['outstanding_koptel']+$row['biaya_notaris'];
			$jumlah_diterima_karyawan = $row['pokok']-$row['premi_asuransi']-$angsuran_pertama-$row['biaya_administrasi']-$row['biaya_notaris']-$row['premi_asuransi_tambahan']-$row['outstanding_koptel']-$row['outstanding_kopegtel'];
			$sheet->setCellValue('T'.$nRow,number_format($jumlah_koptel_transfer,0,',','.').' ');
			$sheet->setCellValue('U'.$nRow,number_format($transfer_premi_asuransi,0,',','.').' ');
			$sheet->setCellValue('V'.$nRow,number_format($row['outstanding_kopegtel'],0,',','.').' ');
			$sheet->setCellValue('W'.$nRow,number_format($jumlah_diterima_karyawan,0,',','.').' ');
			$sheet->getStyle('G'.$nRow.':K'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('L'.$nRow.':W'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$total_L += $row['pokok'];
			$total_M += $row['biaya_asuransi_jiwa'];
			$total_N += $ujroh;
			$total_O += $angsuran_pertama;
			$total_P += $row['biaya_administrasi'];
			$total_Q += $row['biaya_notaris'];
			$total_R += $row['premi_asuransi_tambahan'];
			$total_S += $row['outstanding_koptel'];
			$total_T += $jumlah_koptel_transfer;
			$total_U += $transfer_premi_asuransi;
			$total_V += $row['outstanding_kopegtel'];
			$total_W += $jumlah_diterima_karyawan;

			for ($j=0;$j<count($cols);$j++) {
				$sheet->getStyle($cols[$j].$nRow)->applyFromArray($styleArray);
			}

			$no++;
			$nRow++;
		}
		for ($j=0;$j<count($cols);$j++) {
			$sheet->getStyle($cols[$j].$nRow)->applyFromArray($styleArray);
		}
		$sheet->getStyle('I'.$nRow.':W'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getRowDimension($nRow)->setRowHeight(25);
		$sheet->getStyle('L'.$nRow.':W'.$nRow)->getFont()->setBold(true);
		$sheet->getStyle('I'.$nRow.':K'.$nRow)->applyFromArray($SubTitle);
		$sheet->mergeCells('I'.$nRow.':K'.$nRow);
		$sheet->setCellValue('I'.$nRow,' DI TRANSFER KE REKENING PRIBADI');
		$sheet->setCellValue('L'.$nRow,number_format($total_L,0,',','.').' ');
		$sheet->setCellValue('M'.$nRow,number_format($total_M,0,',','.').' ');
		$sheet->setCellValue('N'.$nRow,number_format($total_N,0,',','.').' ');
		$sheet->setCellValue('O'.$nRow,number_format($total_O,0,',','.').' ');
		$sheet->setCellValue('P'.$nRow,number_format($total_P,0,',','.').' ');
		$sheet->setCellValue('Q'.$nRow,number_format($total_Q,0,',','.').' ');
		$sheet->setCellValue('R'.$nRow,number_format($total_R,0,',','.').' ');
		$sheet->setCellValue('S'.$nRow,number_format($total_S,0,',','.').' ');
		$sheet->setCellValue('T'.$nRow,number_format($total_T,0,',','.').' ');
		$sheet->setCellValue('U'.$nRow,number_format($total_U,0,',','.').' ');
		$sheet->setCellValue('V'.$nRow,number_format($total_V,0,',','.').' ');
		$sheet->setCellValue('W'.$nRow,number_format($total_W,0,',','.').' ');
		$grand_total_biaya_notaris+=$total_Q;
		$grand_total_biaya_asuransi+=$total_U;
		$sheet->getStyle('I'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('L'.$nRow.':W'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$nRow++;
		/*page break*/
		$sheet->getStyle('C'.$nRow.':W'.$nRow)->applyFromArray($styleArray);
		$nRow++;

		$kopegtels = $this->model_nasabah->get_data_cetak_transfer_pencairan_kopegtel2($no_spb);
		$nnRow=$nRow;
		$nama_kopegtel = '';
		$grand_total_kewajiban_kopegtel=0;
		foreach($kopegtels as $kopegtel) {
			$total_kewajiban_kopegtel=0;
			$_no=1;
			$nasabahs = $this->model_nasabah->get_data_cetak_transfer_pencairan_nasabah2($kopegtel['kopegtel_code'],$no_spb);
			$lmgc = count($nasabahs);
			for ($j=0;$j<count($cols);$j++) {
				if ($lmgc>0){
					$sheet->getStyle($cols[$j].$nRow.':'.$cols[$j].($nRow+$lmgc))->applyFromArray($styleArray);
				} else {
					$sheet->getStyle($cols[$j].$nRow)->applyFromArray($styleArray);
				}
			}
			foreach ($nasabahs as $nasabah) {
				$sheet->getRowDimension($nnRow)->setRowHeight(20);
				$sheet->mergeCells('D'.$nnRow.':G'.$nnRow);
				$sheet->getStyle('C'.$nnRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$sheet->getStyle('D'.$nnRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$sheet->getStyle('V'.$nnRow.':W'.$nnRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet->getStyle('V'.$nnRow.':W'.$nnRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$sheet->setCellValue('C'.$nnRow,$_no);
				$sheet->setCellValue('D'.$nnRow,$nasabah['keterangan']);
				$sheet->setCellValue('V'.$nnRow,number_format($nasabah['outstanding_kopegtel'],0,',','.').' ');
				// $sheet->setCellValue('W'.$nnRow,number_format($nasabah['outstanding_kopegtel'],0,',','.').' ');
				$total_kewajiban_kopegtel+=$nasabah['outstanding_kopegtel'];
				$_no++;
				$nnRow++;
			}
			$nnRow++;
			if ($lmgc>0){
				$sheet->mergeCells('I'.$nRow.':I'.($nRow+$lmgc-1));
				$sheet->mergeCells('J'.$nRow.':J'.($nRow+$lmgc-1));
				$sheet->mergeCells('K'.$nRow.':K'.($nRow+$lmgc-1));
			}
			$sheet->getStyle('I'.$nRow.':K'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('I'.$nRow.':K'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->setCellValue('I'.$nRow,($kopegtel['nama_bank']=="")?"-":$kopegtel['nama_bank']);
			$sheet->setCellValue('J'.$nRow,($kopegtel['nomor_rekening']=="")?"-":' '.$kopegtel['nomor_rekening']);
			$sheet->setCellValue('K'.$nRow,$kopegtel['nama_kopegtel']);
			$nRow++;

			$desc_trx_kopegtel = array(
	       		'font' => array(
	       				'color' => array('rgb'=>'FF0000')
	       			)
			);
			$dnRow=$nRow;
			if ($lmgc>0) {
				$dnRow=$nRow+$lmgc-1;
			}
			$sheet->getStyle('I'.$dnRow)->applyFromArray($desc_trx_kopegtel);
			$sheet->getStyle('I'.$dnRow.':K'.$dnRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('V'.$dnRow.':W'.$dnRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->mergeCells('I'.$dnRow.':K'.$dnRow);
			$sheet->setCellValue('I'.$dnRow,'DI TRANSFER KE '.$kopegtel['nama_kopegtel']);
			$sheet->setCellValue('V'.$dnRow,number_format($total_kewajiban_kopegtel,0,',','.').' ');
			// $sheet->setCellValue('W'.$dnRow,number_format($total_kewajiban_kopegtel,0,',','.').' ');
			$grand_total_kewajiban_kopegtel += $total_kewajiban_kopegtel;
			$nama_kopegtel = $kopegtel['nama_kopegtel'];
			if ($lmgc>0){
				$nRow+=$lmgc;
			}
		}
		$sheet->mergeCells('C'.$nRow.':W'.$nRow);
		$sheet->getStyle('C'.$nRow.':W'.$nRow)->applyFromArray($styleArray);
		$nRow++;
		for ($j=0;$j<count($cols);$j++) {
			$sheet->getStyle($cols[$j].$nRow)->applyFromArray($styleArray);
		}
		
		$desc_total_trx_kopegtel = array(
       		'font' => array(
       				'bold' => true,
       				'color' => array('rgb'=>'C00000')
       			)
		);
		$sheet->getStyle('E'.$nRow.':W'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$sheet->getRowDimension($nRow)->setRowHeight(25);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getFont()->setBold(true);
		$sheet->getStyle('E'.$nRow.':K'.$nRow)->applyFromArray($desc_total_trx_kopegtel);
		$sheet->setCellValue('E'.$nRow,'JUMLAH DITRANSFER KE  REKENING KOPEGTEL ');
		$sheet->setCellValue('V'.$nRow,number_format($grand_total_kewajiban_kopegtel,0,',','.').' ');

		$nRow++;
		for ($k=0;$k<count($cols);$k++) {
			$sheet->getStyle($cols[$k].$nRow)->applyFromArray($styleArray);
		}
		// DI TRANSFER KE NOTARIS
		$sheet->getStyle('E'.$nRow.':W'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$sheet->getRowDimension($nRow)->setRowHeight(25);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getFont()->setBold(true);
		$sheet->getStyle('E'.$nRow.':K'.$nRow)->applyFromArray($desc_total_trx_kopegtel);
		$sheet->setCellValue('E'.$nRow,'JUMLAH DITRANSFER KE  NOTARIS ');
		$sheet->setCellValue('V'.$nRow,number_format($grand_total_biaya_notaris,0,',','.').' ');

		$nRow++;
		for ($l=0;$l<count($cols);$l++) {
			$sheet->getStyle($cols[$l].$nRow)->applyFromArray($styleArray);
		}
		// DI TRANSFER KE ASURANSI
		$sheet->getStyle('E'.$nRow.':W'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$sheet->getRowDimension($nRow)->setRowHeight(25);
		$sheet->getStyle('V'.$nRow.':W'.$nRow)->getFont()->setBold(true);
		$sheet->getStyle('E'.$nRow.':K'.$nRow)->applyFromArray($desc_total_trx_kopegtel);
		$sheet->setCellValue('E'.$nRow,'JUMLAH DITRANSFER KE  ASURANSI ');
		$sheet->setCellValue('V'.$nRow,number_format($grand_total_biaya_asuransi,0,',','.').' ');


		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="CETAK TRANSFER PENCAIRAN '.$no_spb.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

	}


	public function ExtractPeriodDate($from_date,$thru_date,$type) {

		$from_date = new DateTime($from_date);
		$thru_date =new DateTime($thru_date);
		$interval = $thru_date->diff($from_date);

		switch ($type) {
			case 'FullYear':
			$time = $interval->format('%y');
			break;
			case 'FullDay':
			$time = $interval->format('%a');
			break;
			case 'MonthOfLastYear':
			$time = $interval->format('%m');
			break;
			case 'DayOfLastYear':
			$time = $interval->format('%d');
			break;
			default:
			die("error function ExtractPeriodDate() : The Parameter of Type \"".$type."\" Is Undefined.");
			break;
		}
		return $time;

	}

	function verifikasi_status_asuransi()
	{
		$data['title'] = 'Verifikasi Status Asuransi';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['container'] = 'nasabah/verifikasi_status_asuransi';
		$this->load->view('core',$data);
	}
	function datatable_verifikasi_status_asuransi()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_account_financing_reg.registration_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','','mfi_account_financing_reg.uw_policy','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_verifikasi_status_asuransi($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_status_asuransi($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_status_asuransi(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$flag_scoring=0;
			if($aRow['flag_scoring']==0){ //tidak menggunakan scoring
				$skoring_link='<div align="center">-</div>';
			}

			$aRow['status'] = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-ok-sign"></i> Verifikasi</a>';
			$label_class = $aRow['status'];
			
			$total_margin = ($aRow['amount']*$aRow['rate_margin2']*$aRow['jangka_waktu']/100);

			$nik=' <span class="btn mini green-stripe">'.$aRow['cif_no'].'</span>';

			$melalui = ($aRow['pengajuan_melalui']!='koptel') ? $this->model_nasabah->get_kopegname_by_code($aRow['kopegtel_code']):"Koptel (Langsung)";

			$row = array();
			$row[] = '<div style="text-align:center;white-space:nowrap;">'.$aRow['registration_no'].$nik.'</div>';
			$row[] = '<div style="white-space:nowrap">'.$aRow['nama'].'</div>';
			$row[] = '<div align="center">'.date('d-m-Y',strtotime($aRow['tanggal_pengajuan'])).'</div>';
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = '<div align="left">'.$melalui.'</div>';
			$row[] = '<div align="center"><span class="btn mini red" style="font-weight:bold;">'.(($aRow['uw_policy']=="")?"-":$aRow['uw_policy']).'</span></div>';
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	public function act_verifikasi_status_asuransi()
	{
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$account_saving_no_flag	= $this->input->post('account_saving_no');
		$premi_asuransi_tambahan	= $this->convert_numeric($this->input->post('premi_asuransi_tambahan'));
		$nik	= $this->input->post('nik');

		/*
		**UPDATE DATA PENGAJUAN
		*/
		$data_financing_reg = array('status_asuransi' => 1,'premi_asuransi_tambahan'=>$premi_asuransi_tambahan);
		$param_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
		/*
		**END UPDATE DATA PENGAJUAN
		*/


		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_financing_reg,$param_financing_reg);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function verifikasi_transfer_pencairan()
	{
		$data['container'] 	= 'nasabah/verifikasi_transfer_pencairan';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);		
	}

	function datatable_verifikasi_transfer_pencairan()
	{
		$aColumns = array( 'a.account_financing_no','c.nama','a.tanggal_akad','b.tanggal_transfer','a.pokok','d.jumlah_kewajiban','d.jumlah_angsuran','');
		$product_code = @$_GET['product_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		// if($sWhere==""){
			// $sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		// }else{
			// $sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
		// }
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_verifikasi_transfer_pencairan($sWhere,$sOrder,$sLimit,$product_code); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_verifikasi_transfer_pencairan($sWhere,'','',$product_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_verifikasi_transfer_pencairan('','','',$product_code); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$jumlah_transfer = ($aRow['pokok']-($aRow['angsuran_pertama']+$aRow['biaya_administrasi']+$aRow['biaya_notaris']+$aRow['biaya_asuransi_jiwa']+$aRow['kewajiban_koptel']+$aRow['kewajiban_kopegtel']));
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['droping_date'])).'</div>';
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['tanggal_transfer'])).'</div>';
			$row[] = '<div align="right">'.number_format($jumlah_transfer,0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['biaya_asuransi_jiwa'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['pokok'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['kewajiban_koptel'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['kewajiban_kopegtel'],0,',','.').'</div>';
			$row[] = '<div align="center"><a href="javascript:void(0);" class="btn mini green" data-cif_no="'.$aRow['cif_no'].'" data-account_financing_no="'.$aRow['account_financing_no'].'" id="link-verifikasi">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );		
	}

	function do_verifikasi_transfer_pencairan()
	{
		$account_financing_no = $this->input->post('no_pembiayaan');
		$account_cash_code = $this->input->post('account_cash_code');
		$tanggal_transfer = $this->datepicker_convert(true,$this->input->post('tanggal_transfer'),'/');

		$nama = $this->input->post('nama');
		$sms_to = $this->input->post('telpon_seluler');
		$sms_message = 'Terimakasih atas kepercayaan anda menjadi mitra KOPTEL, dana pembiayaan an. '.$nama.' telah ditransfer ke rekening anda.';


		$data = array('status_transfer'=>1);
		$param = array('account_financing_no'=>$account_financing_no);

		$this->db->trans_begin();
		$this->model_nasabah->do_verifikasi_transfer_pencairan($data,$param);
		$this->db->query('select fn_jurnal_transfer_droping_pyd(?,?)',array($account_financing_no,$account_cash_code));


		/*[BEGIN] Pelunasan Pembiayaan terdahulu
		| melunasi pembiayaan jika ada di tabel mfi_account_financing_reg_lunas
		| Ade Sagita. 14-01-2016
		*/
		$data_droping = $this->model_transaction->get_droping_date_and_registration_no($account_financing_no);

		$reg_lunas_data = $this->model_transaction->get_financing_reg_lunas($data_droping['registration_no']);
		$reg_lunas_created_by = $this->session->userdata('user_id');
		$reg_lunas_created_date = $data_droping['droping_date'].' '.date('H:i:s');
		$trx_date = $data_droping['droping_date'];
		$account_cash_code = $account_cash_code;
		//lunasi pembiayaan sesuai jumlah pembiayaan di table mfi_account_financing_reg_lunas
		for ($i_pelunasan=0; $i_pelunasan<count($reg_lunas_data) ; $i_pelunasan++) { 
			$trx_detail_id = uuid(false);
			$trx_account_financing_id = uuid(false);
			$account_financing_lunas_id = $trx_account_financing_id;
			$data_account_financing_lunas = array(
													 'account_financing_lunas_id' => $trx_account_financing_id
													,'account_financing_no' => $reg_lunas_data[$i_pelunasan]['account_financing_no']
													,'saldo_pokok' => $reg_lunas_data[$i_pelunasan]['saldo_pokok']
													,'saldo_margin' => $reg_lunas_data[$i_pelunasan]['saldo_margin']
													,'potongan_margin' => $reg_lunas_data[$i_pelunasan]['saldo_margin']
													,'status_pelunasan' => 1 //langsung approved
													,'tanggal_lunas' => $trx_date
													,'create_by' => $reg_lunas_created_by
													,'created_date' => $reg_lunas_created_date
													,'verify_by' => $reg_lunas_created_by
													,'verifiy_date' => $reg_lunas_created_date
													,'trx_cm_detail_id' => NULL
													,'jenis_pembayaran' => 2 // dari rekening tabungan
												);
			//insert into mfi_account_financing_lunas
			$this->model_transaction->insert_account_financing_lunas($data_account_financing_lunas);

			/*
			| get data account pembiayaan
			*/
			$account = $this->model_transaction->get_account_financing_by_account_financing_no($reg_lunas_data[$i_pelunasan]['account_financing_no']);
			$v_jtempo_angsuran_last = $account['jtempo_angsuran_last'];
			$v_jtempo_angsuran_next = $account['jtempo_angsuran_next'];
			$v_tanggal_jtempo = $account['tanggal_jtempo'];
			$v_jangka_waktu = $account['jangka_waktu'];
			$v_counter_angsuran = $account['counter_angsuran'];
			$v_flag_jadwal_angsuran = $account['flag_jadwal_angsuran'];
			$v_periode_jangka_waktu = $account['periode_jangka_waktu'];
			$jtempo_db = $account['tanggal_jtempo'];

			// BEGIN financing transaction
			$trx_detail = array(
					 'trx_detail_id' 			=> $trx_detail_id
					,'trx_type' 				=> '3'
					,'trx_account_type' 		=> '2'
					,'account_no' 				=> $reg_lunas_data[$i_pelunasan]['account_financing_no']
					,'flag_debit_credit'		=> 'C'
					,'amount' 					=> $reg_lunas_data[$i_pelunasan]['saldo_pokok']+$reg_lunas_data[$i_pelunasan]['saldo_margin']
					,'trx_date' 				=> $trx_date
					,'created_by' 				=> $reg_lunas_created_by
					,'created_date' 			=> $reg_lunas_created_date
				);

			$trx_account_financing = array(
				'trx_account_financing_id'  => $trx_account_financing_id
				,'branch_id' 				=> $this->session->userdata('branch_id')
				,'trx_detail_id' 			=> $trx_detail_id
				,'account_financing_no' 	=> $reg_lunas_data[$i_pelunasan]['account_financing_no']
				,'trx_financing_type' 		=> '2'
				,'trx_date' 				=> $trx_date
				,'jto_date' 				=> $v_tanggal_jtempo
				,'pokok' 					=> $reg_lunas_data[$i_pelunasan]['saldo_pokok']
				,'margin' 					=> $reg_lunas_data[$i_pelunasan]['saldo_margin']
				,'catab' 					=> 0
				,'account_cash_code' 		=> $account_cash_code
				,'angsuran_ke' 				=> $v_jangka_waktu
				,'trx_status' 				=> 1
				,'verify_by' 				=> $reg_lunas_created_by
				,'verify_date' 				=> $reg_lunas_created_date
				,'created_by' 				=> $reg_lunas_created_by
				,'created_date' 			=> $reg_lunas_created_date
				,'tipe_angsuran' 			=> '5'
				,'description' 				=> 'Dilunasi ketika pencairan Reg. '.$reg_lunas_data[$i_pelunasan]['registration_no'].' an. '.$nama
			);
			
			$this->model_nasabah->insert_mfi_trx_detail($trx_detail);
			$this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);
			// END financing transaction			

			/*
			| get data trx history pembiayaan
			*/
			$trx_angsuran_pokok = $reg_lunas_data[$i_pelunasan]['saldo_pokok'];
			$trx_angsuran_margin = $reg_lunas_data[$i_pelunasan]['saldo_margin'];
			$trx_date = $trx_date;
			$account_cash_code = $account_cash_code;

			/*
			| set variable for perubahan account pembiayaan
			*/
			$jtempo_angsuran_last = $v_jtempo_angsuran_last;
			$jtempo_angsuran_next = $v_jtempo_angsuran_next;
			$jtempo_db = $v_tanggal_jtempo;
			$sisa_angsuran = $v_jangka_waktu-$v_counter_angsuran;
			$flag_jadwal_angsuran = $v_flag_jadwal_angsuran;
			$periode_jangka_waktu = $v_periode_jangka_waktu;

			// data account financing
			$jto_next = $jtempo_angsuran_next;
			$jto_last = $jtempo_angsuran_last;
			if($periode_jangka_waktu=='0'){
				$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran days"));
				$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran days"));
			}else if($periode_jangka_waktu=='1'){
				$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran weeks"));
				$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran weeks"));
			}else if($periode_jangka_waktu=='2'){
				$jto_next = date('Y-m-d',strtotime($jto_next."+$sisa_angsuran months"));
				$jto_last = date('Y-m-d',strtotime($jto_last."+$sisa_angsuran months"));
			} else if($periode_jangka_waktu==3) {
				$jto_next = $jtempo_db;
				$jto_last = $jtempo_db;
			}

			// account financing
			$data_acc_financing	= array(
				'saldo_pokok'=>0,
				'saldo_margin'=>0,
				'tanggal_lunas'=>$trx_date,
				'jtempo_angsuran_last'=>$jto_last,
				'jtempo_angsuran_next'=>$jto_next,
				'counter_angsuran'=>$v_jangka_waktu,
				'status_rekening'=>2
			);
			$param_acc_financing = array('account_financing_no'=>$reg_lunas_data[$i_pelunasan]['account_financing_no']);

			// account financing lunas
			$data_acc_financing_lunas = array(
				'status_pelunasan'=>1,
				'verify_by'	 	  =>$reg_lunas_created_by,
				'verifiy_date'	  =>$reg_lunas_created_date
			 );
			$param_acc_financing_lunas = array('account_financing_lunas_id'=>$account_financing_lunas_id);

			/*update status tab.simpan wajib pinjam*/

			$this->db->trans_begin();
			// update to lunas financing schedulle
			$this->model_nasabah->update_account_financing_data($data_acc_financing,$param_acc_financing);
			if ($flag_jadwal_angsuran=='0') {
				$this->model_nasabah->update_account_financing_schedulle_to_lunas($reg_lunas_data[$i_pelunasan]['account_financing_no'],$trx_date);
			}
			$this->model_nasabah->proses_verifikasi_pelunasan_pembayaran($data_acc_financing_lunas,$param_acc_financing_lunas);
			$this->model_nasabah->fn_proses_jurnal_pelunasan_pyd_koptel($account_financing_lunas_id,$account_cash_code);
		}
		/*[END] Pelunasan Pembiayaan terdahulu
		| melunasi pembiayaan jika ada di tabel mfi_account_financing_reg_lunas
		*/


		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();

			if(strlen($sms_to)>8){
				// $this->action_send_sms($sms_to,$sms_message);
			}
			
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to connect into databases, please contact your administrator.');
		}

		echo json_encode($return);
	}

	function get_date_regis_by_tglakad_baru() //Ade Sagita, 14-04-2015
	{
		$nValid = true;

		$jangka_waktu = $this->input->post('jangka_waktu');
		$akad = $this->input->post('tgl_akad');
		// $tgl_akad = str_replace("_","",$this->input->post('tgl_akad'));
		$len = strlen($akad);
		// echo $akad;die();
		if($len==8 && substr($akad,2,1)!='/'){
			$akad = substr($akad,0,2).'/'.substr($akad,2,2).'/'.substr($akad,4,4);
			$len = strlen($akad);

			$expl = explode("/",$akad);
			$bulan = $expl[1];
			$tahun = $expl[2];
		}else{

			$akad = $this->input->post('tgl_akad');
			$expl = explode("/",$akad);
			// $tglexpl = $expl[2].'-'.$expl[1].'-'.$expl[0];

			$bulan = $expl[1];
			$tahun = $expl[2];

			$len = strlen($akad);

		}
		// echo $bulan.'|'.$tahun;
		// die();
		if($bulan!='12'){
			$bulannya = ($bulan+1);
			if($bulannya<10){
				$bulannya = '0'.$bulannya;
			}
			$tahunnya = $tahun;
			$angsuranke1 = '25/'.$bulannya.'/'.$tahunnya;
		}else{
			$bulannya = '01';
			$tahunnya = ($tahun+1);
			$angsuranke1 = '25/'.$bulannya.'/'.$tahunnya;
		}

		$angsurankesatu = $tahunnya.'-'.$bulannya.'-25';

		$jangka_waktu = ($jangka_waktu-1);

		$tgl_jtempo = date("d/m/Y",strtotime($angsurankesatu." + $jangka_waktu month"));

		// $angsuranke1 = '25'.substr($angsuranke1,2,10);
		// $tgl_jtempo = '25'.substr($tgl_jtempo,2,10);

		$return = ($len==10) ? $angsuranke1.'|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	function get_date_regis_by_tglakad_baru_pencairan() //Ade Sagita, 14-04-2015
	{
		$nValid = true;

		$jangka_waktu = $this->input->post('jangka_waktu');
		$akad = $this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		// $tgl_akad = str_replace("_","",$this->input->post('tgl_akad'));
		$len = strlen($akad);

		$expl = explode("/",$this->input->post('tgl_akad'));
		// $tglexpl = $expl[2].'-'.$expl[1].'-'.$expl[0];

		$bulan = $expl[1];
		$tahun = $expl[2];
		// echo $bulan.'|'.$tahun;
		// die();
		if($bulan!='12'){
			$bulannya = ($bulan+1);
			if($bulannya<10){
				$bulannya = '0'.$bulannya;
			}
			$tahunnya = $tahun;
			$angsuranke1 = '25/'.$bulannya.'/'.$tahunnya;
		}else{
			$bulannya = '01';
			$tahunnya = ($tahun+1);
			$angsuranke1 = '25/'.$bulannya.'/'.$tahunnya;
		}

		$angsurankesatu = $tahunnya.'-'.$bulannya.'-25';

		// $jangka_waktu = ($jangka_waktu-1);

		$tgl_jtempo = date("d/m/Y",strtotime($angsurankesatu." + $jangka_waktu month"));

		// $angsuranke1 = '25'.substr($angsuranke1,2,10);
		// $tgl_jtempo = '25'.substr($tgl_jtempo,2,10);

		$return = ($len==10) ? $angsuranke1.'|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	function act_dokumen_diterima()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$datas = array('flag_dokumen' =>1);
		$param = array('account_financing_id' =>$account_financing_id);
		// echo $account_financing_id; die();

		$this->model_nasabah->act_dokumen_diterima($datas,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	
	/*
	|BEGIN APPROVE SPB
	|ujangirawan
	|18 April 2014
	*/

	public function create_spb()
	{
		$data['container'] = 'nasabah/create_spb';
		$data['akun'] = $this->model_nasabah->get_akun_giro();
		$data['product'] = $this->model_transaction->get_product_financing();
		$this->load->view('core',$data);
	}

	function datatable_create_spb()
	{
		$aColumns = array('', 'a.account_financing_no','c.nama','a.tanggal_akad','b.tanggal_transfer','a.pokok','a.angsuran_pokok','a.biaya_administrasi','a.biaya_notaris','d.saldo_kewajiban_ke_koptel','d.saldo_kewajiban','d.premi_asuransi');
		$status_transfer = @$_GET['status_transfer'];
		$product_code = @$_GET['product_code'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		if($sWhere==""){
			// $sWhere = " AND b.status_transfer = '".$status_transfer."' AND a.product_code = '".$product_code."'";
			$sWhere = " AND b.status_transfer = '".$status_transfer."'";
		}else{
			// $sWhere .= " AND b.status_transfer = '".$status_transfer."' AND a.product_code = '".$product_code."'";
			$sWhere .= " AND b.status_transfer = '".$status_transfer."'";
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}
		
		$rResult 			= $this->model_nasabah->datatable_create_spb($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_create_spb($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_create_spb(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$biaya_adm = $aRow['biaya_administrasi'];
			$biaya_notaris = $aRow['biaya_notaris'];
			//+$aRow['biaya_notaris']+$aRow['biaya_asuransi_jiwa'];
			if ($aRow['product_code']=='58') {
				$angsuranke1 = 0;
			} else {
				$angsuranke1 = $aRow['angsuran_pokok']+$aRow['angsuran_margin'];
			}
			$row = array();
			$row[] = '<div align="center"><input type="checkbox" value="'.$aRow['account_financing_no'].'" id="checkbox" class="checkboxes" ></div>';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['droping_date'])).'</div>';
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['tanggal_transfer'])).'</div>';
			$row[] = '<div align="right">'.number_format($aRow['pokok'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($angsuranke1,0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($biaya_adm,0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($biaya_notaris,0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['kewajiban_koptel'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['kewajiban_kopegtel'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['premi_asuransi'],0,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );		
	}
	
	public function do_save_spb()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$product_nickname = $this->input->post('product_nickname');
		$tanggal_spb = $this->input->post('tanggal_spb');
		$tgl_spb = substr("$tanggal_spb",0,2);
	    $bln_spb = substr("$tanggal_spb",2,2);
	    $thn_spb = substr("$tanggal_spb",4,4);
	    $tglakhir_spb = "$thn_spb-$bln_spb-$tgl_spb"; 

	    $paramCounter = date('y.m');
	    $current_sequence = $this->model_nasabah->getCounterSequence($paramCounter,'product');
	    $new_sequence = $current_sequence+1;
	    $no_spb = $paramCounter.'.'.str_pad($new_sequence, 4, '0',STR_PAD_LEFT);

		$ins_data_spb = array(
						'no_spb' => $no_spb,
						'tanggal_spb' => $tglakhir_spb,
						'created_date' => date("Y-m-d H:i:s"),
						'user_id' => $this->session->userdata('user_id')
					);

		$ins_data_spb_detail = array();
		for ( $i = 0 ; $i < count($account_financing_no) ; $i++ ){
	    	$get_data_spb = $this->model_nasabah->get_data_spb_by_account_financing_no($account_financing_no[$i]);
	    	if(count($get_data_spb)>0)
	    	{
				if($account_financing_no[$i]!="") {
					
					$biaya_adm = (isset($get_data_spb['biaya_administrasi'])?$get_data_spb['biaya_administrasi']:'0');
					$biaya_notaris = (isset($get_data_spb['biaya_notaris'])?$get_data_spb['biaya_notaris']:'0');
					
					$angsuran_pertama = (isset($get_data_spb['angsuran_pokok'])?$get_data_spb['angsuran_pokok']:'0')+(isset($get_data_spb['angsuran_margin'])?$get_data_spb['angsuran_margin']:'0');
					$ujroh = (isset($get_data_spb['biaya_asuransi_jiwa'])?$get_data_spb['biaya_asuransi_jiwa']:'0')*5/100;
					$jumlah_koptel_transfer = (isset($get_data_spb['pokok'])?$get_data_spb['pokok']:'0')-$ujroh-$angsuran_pertama-(isset($get_data_spb['outstanding_koptel'])?$get_data_spb['outstanding_koptel']:'0');
					$ins_data_spb_detail[] = array(
						 			'id_spb_detail' => uuid(false),
									'no_spb' => $no_spb,
									'jumlah_pembiayaan' => isset($get_data_spb['pokok'])?$get_data_spb['pokok']:'0',
									'pelunasan_koptel' => isset($get_data_spb['outstanding_koptel'])?$get_data_spb['outstanding_koptel']:'0',
									'angsuran_pertama' => isset($angsuran_pertama)?$angsuran_pertama:'0',
									'premi_asuransi_tambahan' => isset($get_data_spb['premi_asuransi_tambahan'])?$get_data_spb['premi_asuransi_tambahan']:'0',
									'ujroh' => isset($ujroh)?$ujroh:'0',
									'jumlah_koptel_transfer' => isset($jumlah_koptel_transfer)?$jumlah_koptel_transfer:'0',
									'pelunasan_kopeg' => isset($get_data_spb['outstanding_kopegtel'])?$get_data_spb['outstanding_kopegtel']:'0',
									'premi_asuransi' => isset($get_data_spb['premi_asuransi'])?$get_data_spb['premi_asuransi']:'0',
									'account_financing_no' => $account_financing_no[$i],
									'biaya_administrasi' => isset($biaya_adm)?$biaya_adm:'0',
									'biaya_notaris' => isset($biaya_notaris)?$biaya_notaris:'0'
								);
				}
			}

		}

		$upd_data_droping = array();
		for ( $j = 0 ; $j < count($account_financing_no) ; $j++ ){
	    	$get_data_droping = $this->model_nasabah->get_data_droping_sebelumnya($account_financing_no[$j]);

	    	if(count($get_data_droping)>0)
	    	{
				if($account_financing_no[$j]!="")
					$upd_data_droping[] = array(
									'account_financing_no' => $get_data_droping['account_financing_no'],
									'status_droping' => $get_data_droping['status_droping'],
									'droping_date' => $get_data_droping['droping_date'],
									'create_by' => $get_data_droping['create_by'],
									'created_date' => $get_data_droping['created_date'],
									'cif_no' => $get_data_droping['cif_no'],
									'droping_by' => $get_data_droping['droping_by'],
									'status_transfer' => $get_data_droping['status_transfer'],
									'tanggal_transfer' => $get_data_droping['tanggal_transfer'],
									'no_spb' => $no_spb
								);
			}

		}

		$this->db->trans_begin();

		if(count($ins_data_spb_detail)>0){
			$this->model_nasabah->insert_data_spb_detail($ins_data_spb_detail);
		}
		$this->model_nasabah->insert_data_spb($ins_data_spb);

		for ( $k = 0 ; $k < count($account_financing_no) ; $k++ )
		{
			$param_droping = array('account_financing_no'=>$account_financing_no[$k]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_data_droping_sebelumnya($param_droping);
		}

		if(count($upd_data_droping)>0){
			$this->model_nasabah->insert_data_droping_new($upd_data_droping);
		}

		$this->model_nasabah->updateCounter($paramCounter,'product',$current_sequence);

		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true,'no_spb'=>$no_spb);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/*
	| End
	*/

	/*
	|Approval SPB
	|18 April 2015
	|ujangirawan
	*/


	public function approval_spb()
	{
		$data['container'] 	= 'nasabah/approval_spb';
		$this->load->view('core',$data);
	}

	public function datatable_approval_spb()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_spb.no_spb','mfi_spb.tanggal_spb','mfi_spb.approve_1','mfi_spb.approve_2','mfi_spb.approve_3','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_approval_spb($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_approval_spb($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_approval_spb(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$display_text = $this->model_nasabah->get_display_text_for_approval($this->session->userdata('kode_jabatan'));

			if($display_text=='approval_1_spb'){
				if($aRow['approve_1']!='1'){
					// $approved1 = "Not Approved";
					// $approved2 = "Not Approved";
					// $approved3 = "Not Approved";
					$aRow['status'] = '<a href="javascript:;" id_spb="'.$aRow['id_spb'].'" no_spb="'.$aRow['no_spb'].'" tanggal_spb="'.$aRow['tanggal_spb'].'" status_approve="1" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}else{
					// $approved1 = "Approved";
					// $approved2 = "Not Approved";
					// $approved3 = "Not Approved";
					$aRow['status'] = 'Approved';
				}
			}else if($display_text=='approval_2_spb'){
				if($aRow['approve_2']!='1'){
					// $approved2 = "Not Approved";
					// $approved1 = "Not Approved";
					// $approved3 = "Not Approved";
					$aRow['status'] = '<a href="javascript:;" id_spb="'.$aRow['id_spb'].'" no_spb="'.$aRow['no_spb'].'" tanggal_spb="'.$aRow['tanggal_spb'].'" status_approve="2" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}else{
					// $approved2 = "Approved";
					// $approved1 = "Not Approved";
					// $approved3 = "Not Approved";
					$aRow['status'] = 'Approved';
				}
			}else if($display_text=='approval_3_spb'){
				if($aRow['approve_3']!='1'){
					// $approved3 = "Not Approved";
					// $approved2 = "Not Approved";
					// $approved1 = "Not Approved";
					$aRow['status'] = '<a href="javascript:;" id_spb="'.$aRow['id_spb'].'" no_spb="'.$aRow['no_spb'].'" tanggal_spb="'.$aRow['tanggal_spb'].'" status_approve="3" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}else{
					// $approved3 = "Approved";
					// $approved2 = "Not Approved";
					// $approved1 = "Not Approved";
					$aRow['status'] = 'Approved';
				}
			}else{
					// $approved3 = "Not Approved";
					// $approved2 = "Not Approved";
					// $approved1 = "Not Approved";
				$aRow['status'] = '-';
			}
			$label_class = $aRow['status'];

			$row = array();
			$row[] = $aRow['no_spb'];
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_spb']));
			$row[] = $aRow['approve_1_by'];
			$row[] = $aRow['approve_2_by'];
			$row[] = $aRow['approve_3_by'];
			// $row[] = $approved1;
			// $row[] = $approved2;
			// $row[] = $approved3;
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function jqgrid_approval_spb()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'id_spb';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';

		$product_code = isset($_REQUEST['product_code'])?$_REQUEST['product_code']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_nasabah->jqgrid_approval_spb('','','','');

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_nasabah->jqgrid_approval_spb($sidx,$sord,$limit_rows,$start);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$display_text = $this->model_nasabah->get_display_text_for_approval($this->session->userdata('kode_jabatan'));
			if($display_text=='approval_1_spb'){
				if($row['approve_2']=='1'){
					$row['status'] = '<a href="javascript:;" id_spb="'.$row['id_spb'].'" no_spb="'.$row['no_spb'].'" tanggal_spb="'.$row['tanggal_spb'].'" status_approve="1" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}elseif($row['approve_1']=='1'){
					$row['status'] = 'Approved';
				}else{
					$row['status'] = '-';
				}
			}else if($display_text=='approval_2_spb'){
				if($row['approve_3']=='1'){
					$row['status'] = '<a href="javascript:;" id_spb="'.$row['id_spb'].'" no_spb="'.$row['no_spb'].'" tanggal_spb="'.$row['tanggal_spb'].'" status_approve="2" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}elseif($row['approve_2']=='1'){
					$row['status'] = 'Approved';
				}else{
					$row['status'] = '-';
				}
			}else if($display_text=='approval_3_spb'){
				if($row['checked']=='1'){
					$row['status'] = '<a href="javascript:;" id_spb="'.$row['id_spb'].'" no_spb="'.$row['no_spb'].'" tanggal_spb="'.$row['tanggal_spb'].'" status_approve="3" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}elseif($row['approve_3']=='1'){
					$row['status'] = 'Approved';
				}else{
					$row['status'] = '-';
				}
			}elseif($display_text=='checker_spb'){
				if($row['checked']!='1'){
					$row['status'] = '<a href="javascript:;" id_spb="'.$row['id_spb'].'" no_spb="'.$row['no_spb'].'" tanggal_spb="'.$row['tanggal_spb'].'" status_approve="4" id="link-detail" class="btn mini green"><i class="icon-ok-sign"></i> View</a>';
				}else{
					$row['status'] = 'Checked';
				}
			}else{
					$row['status'] = '-';
			}
			$label_class = $row['status'];

			$responce['rows'][$i]['id_spb'] = $row['id_spb'];
			$responce['rows'][$i]['cell'] = array(
				 $row['id_spb']
				,$row['no_spb']
				,$row['tanggal_spb']
				,$row['pokok']
				// ,$row['angsuran_pertama']
				,$row['biaya_administrasi']
				,$row['biaya_notaris']
				,$row['kewajiban_koptel']
				,$row['kewajiban_kopegtel']
				,$row['premi_asuransi']
				,$row['approve_1_by']
				,$row['approve_2_by']
				,$row['approve_3_by']
				,$row['checked_by']
				// ,$approved1
				// ,$approved2
				// ,$approved3
				,'<div style="white-space:nowrap">'.$label_class.'</div>'
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function jqgrid_approval_spb_detail()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'b.no_spb';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$no_spb = isset($_REQUEST['no_spb'])?$_REQUEST['no_spb']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_nasabah->jqgrid_approval_spb_detail('','','','',$no_spb);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_nasabah->jqgrid_approval_spb_detail($sidx,$sord,$limit_rows,$start,$no_spb);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$biaya_adm = $row['biaya_administrasi'];
			if ($row['product_code']=='58') {
				$angsuranke1=0;
			} else {
				$angsuranke1 = $row['angsuran_pokok']+$row['angsuran_margin']; 
			}
			$responce['rows'][$i]['no_spb'] = $row['no_spb'];
			$responce['rows'][$i]['cell'] = array(
				 $row['no_spb']
				,$row['account_financing_no']
				,$row['nama']
				,$row['droping_date']
				,$row['tanggal_transfer']
				,$row['pokok']
				,$angsuranke1
				,$biaya_adm
				,$row['biaya_notaris']
				,$row['kewajiban_koptel']
				,$row['kewajiban_kopegtel']
				,$row['premi_asuransi']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function get_data_spb_by_no()
	{
		$no_spb = $this->input->post('no_spb');
		$data = $this->model_nasabah->get_data_spb_by_no($no_spb);
		echo json_encode($data);
	}

	public function act_approve_spb()
	{
		$id_spb	= $this->input->post('id_spb');
		$status_approve	= $this->input->post('status_approve');
		$no_spb	= $this->input->post('no_spb');

		$upd_status_transfer_droping = array(
			 'status_transfer' => '2'
		);	

		$param_droping = array('no_spb'=>$no_spb);
		$msg='';

		if ( $status_approve == '1' ){
			$data = array(
				 'approve_1' => '1'
				,'approve_1_by' => $this->session->userdata('user_id')
				,'approve_1_date' => date("Y-m-d")
			);
			$msg = 'SPB berhasil diapprove !';
		}else if ( $status_approve == '2' ){
			$data = array(
				 'approve_2' => '1'
				,'approve_2_by' => $this->session->userdata('user_id')
				,'approve_2_date' => date("Y-m-d")
			);
			$msg = 'SPB berhasil diapprove !';
		}else if ( $status_approve == '3' ){
			$data = array(
				 'approve_3' => '1'
				,'approve_3_by' => $this->session->userdata('user_id')
				,'approve_3_date' => date("Y-m-d")
			);
			$msg = 'SPB berhasil diapprove !';
		}else if ( $status_approve == '4' ){
			$data = array(
				 'checked' => '1'
				,'checked_by' => $this->session->userdata('user_id')
				,'checked_date' => date("Y-m-d")
			);
			$msg = 'SPB berhasil diverivikasi !';
		}

		$param = array('id_spb'=>$id_spb);

		$this->db->trans_begin();
		$this->model_nasabah->act_approve_spb($data,$param);
		$this->model_nasabah->update_status_transfer_droping($upd_status_transfer_droping,$param_droping);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true, 'msg'=>$msg);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/*
	|End
	*/


	/*
	| Cetak SPB
	| Ujang Irawan
	| 18 April 2015
	*/

	function cetak_spb()
	{
		$data['container'] 	= 'nasabah/cetak_spb';
		$data['date1'] = date('d/m/Y', strtotime(date("Y-m-d") . ' -10 day'));
		$data['date2'] = date("d/m/Y");
		$this->load->view('core',$data);
	}

	function do_cetak_spb_pdfOld()
	{
		$no_spb = str_replace("%20", " ", $this->uri->segment(3));
		$product_name = $this->model_nasabah->get_product_name_by_no_spb($no_spb);
		$tanggal_spb1 = $this->uri->segment(4);
        $tanggal_spb = substr($tanggal_spb1,4,4).'-'.substr($tanggal_spb1,2,2).'-'.substr($tanggal_spb1,0,2);
		$datas = $this->model_nasabah->get_data_cetak_spb($no_spb,$tanggal_spb);
		$data['get'] = $datas;
		$data['get']['product_name'] = $product_name;
		ob_start();
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->load->view('nasabah/cetak_pdf_spb',$data);
		$content = ob_get_clean();
		try
		{
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 7);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('CETAK_SPB.pdf');
		}
		catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
		}
	}

	function do_cetak_spb_pdf()
	{
		$id_spb = $this->uri->segment(3);
		$datas = $this->model_nasabah->get_data_cetak_spb($id_spb);
		$data['get'] = $datas;
		ob_start();
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$this->load->view('nasabah/cetak_pdf_spb',$data);
		$content = ob_get_clean();
		try
		{
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 7);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('CETAK_SPB.pdf');
		}
		catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
		}
	}
	
	function do_cetak_spb_xlsOld()
	{
		$no_spb = str_replace("%20", " ", $this->uri->segment(3));
		$product_name = $this->model_nasabah->get_product_name_by_no_spb($no_spb);
		$tanggal_spb1 = $this->uri->segment(4);
        $tanggal_spb = substr($tanggal_spb1,4,4).'-'.substr($tanggal_spb1,2,2).'-'.substr($tanggal_spb1,0,2);
		$datas = $this->model_nasabah->get_data_cetak_spb($no_spb,$tanggal_spb);
		$data = $datas;
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->library('phpexcel');
		// Create new PHPExcel object
		$objPHPExcel = $this->phpexcel;

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
									 ->setLastModifiedBy("MICROFINANCE")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("REPORT, generated using PHP classes.")
									 ->setKeywords("REPORT")
									 ->setCategory("Test result file");
									 
		$objPHPExcel->setActiveSheetIndex(0); 

		$styleArray = array(
       		'borders' => array(
		             'outline' => array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                    'color' => array('rgb' => '000000'),
		             ),
		       ),
		);

		$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',"KOPERASI PT TELEKOMUNIKASI");
		$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:P75')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"Jl. Ciwulan No. 23 Bandung - 40114");
		$objPHPExcel->getActiveSheet()->mergeCells('A3:P3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Tlp  022 - 7201420, 022 - 7200431");
		$objPHPExcel->getActiveSheet()->mergeCells('A5:P5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5',"SURAT PERINTAH BAYAR (SPB)");
		$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:P12')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle('A15:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A15:P16')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A21:P43')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A8:E8');
		$objPHPExcel->getActiveSheet()->setCellValue('A8',"Catatan Bagian Asal :");
		$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
		$objPHPExcel->getActiveSheet()->setCellValue('A9',"NOMOR");
		$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
		$objPHPExcel->getActiveSheet()->setCellValue('A10',"TANGGAL");
		$objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
		$objPHPExcel->getActiveSheet()->setCellValue('A11',"AKUN");
		$objPHPExcel->getActiveSheet()->mergeCells('A12:B12');
		$objPHPExcel->getActiveSheet()->setCellValue('A12',"TAHUN");
		$objPHPExcel->getActiveSheet()->setCellValue('C9',": ".(isset($data['no_spb'])?$data['no_spb']:""));
		$objPHPExcel->getActiveSheet()->setCellValue('C10',": ".(isset($data['tanggal_spb'])?date('d-m-Y',strtotime($data['tanggal_spb'])):""));
		$objPHPExcel->getActiveSheet()->setCellValue('C11',": ".(isset($data['akun'])?$data['akun']:""));
		$objPHPExcel->getActiveSheet()->setCellValue('C12',": ".date("Y"));

		$objPHPExcel->getActiveSheet()->mergeCells('I8:M8');
		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Catatan di Bagian Anggaran :");
		$objPHPExcel->getActiveSheet()->mergeCells('I9:J9');
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"LOKASI");
		$objPHPExcel->getActiveSheet()->mergeCells('I10:J10');
		$objPHPExcel->getActiveSheet()->setCellValue('I10',"BEBAN/TAHUN");
		$objPHPExcel->getActiveSheet()->mergeCells('I11:J11');
		$objPHPExcel->getActiveSheet()->setCellValue('I11',"AKUN");
		$objPHPExcel->getActiveSheet()->setCellValue('K9',": -");
		$objPHPExcel->getActiveSheet()->setCellValue('K10',": Eksploitasi /  Investasi / ".date("Y"));
		$objPHPExcel->getActiveSheet()->setCellValue('K11',": ".(isset($data['akun'])?$data['akun']:""));

		$objPHPExcel->getActiveSheet()->mergeCells('A15:P15');
		$objPHPExcel->getActiveSheet()->setCellValue('A15',"PENGURUS/MANAGER");
		$objPHPExcel->getActiveSheet()->mergeCells('A16:P16');
		$objPHPExcel->getActiveSheet()->setCellValue('A16',"KOPERASI PT TELEKOMUNIKASI INDONESIA (KOPTEL)");

		$objPHPExcel->getActiveSheet()->mergeCells('A18:P18');
		$objPHPExcel->getActiveSheet()->setCellValue('A18',"Bendahara Koperasi PT Telekomunikasi Indonesia di Jl. Ciwulan No. 23 Bandung diminta untuk membayarkan uang sebesar :");

		$objPHPExcel->getActiveSheet()->mergeCells('A19:P19');
		$objPHPExcel->getActiveSheet()->setCellValue('A19',"Rp ".(isset($data['jumlah_pembiayaan'])?number_format($data['jumlah_pembiayaan'],0,',','.'):"0")." (".ucwords((isset($data['jumlah_pembiayaan'])?$this->terbilang($data['jumlah_pembiayaan']):"-"))." Rupiah)");

		$objPHPExcel->getActiveSheet()->mergeCells('A21:B21');
		$objPHPExcel->getActiveSheet()->setCellValue('A21',"KEPADA");
		$objPHPExcel->getActiveSheet()->mergeCells('A22:B22');
		$objPHPExcel->getActiveSheet()->setCellValue('A22',"NAMA");
		$objPHPExcel->getActiveSheet()->mergeCells('A23:B23');
		$objPHPExcel->getActiveSheet()->setCellValue('A23',"ALAMAT");
		$objPHPExcel->getActiveSheet()->mergeCells('A24:B24');
		$objPHPExcel->getActiveSheet()->setCellValue('A24',"UNTUK");
		$objPHPExcel->getActiveSheet()->setCellValue('C21',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C22',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C23',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C24',": Penyaluran Pembiayaan ".$product_name." Thn ".date("Y")."");

		$objPHPExcel->getActiveSheet()->mergeCells('I21:J21');
		$objPHPExcel->getActiveSheet()->setCellValue('I21',"NAMA");
		$objPHPExcel->getActiveSheet()->mergeCells('I22:J22');
		$objPHPExcel->getActiveSheet()->setCellValue('I22',"NO. REKENING");
		$objPHPExcel->getActiveSheet()->mergeCells('I23:J23');
		$objPHPExcel->getActiveSheet()->setCellValue('I23',"PADA BANK");
		$objPHPExcel->getActiveSheet()->mergeCells('I24:J24');
		$objPHPExcel->getActiveSheet()->setCellValue('I24',"CABANG");
		$objPHPExcel->getActiveSheet()->setCellValue('K21',": Daftar Terlampir AJB BUMI PUTERA 1912");
		$objPHPExcel->getActiveSheet()->setCellValue('K22',": Daftar Terlampir NO. REKENING 130-00-0129707-9");
		$objPHPExcel->getActiveSheet()->setCellValue('K23',": Daftar Terlampir BANK MANDIRI");
		$objPHPExcel->getActiveSheet()->setCellValue('K24',": Daftar Terlampir Cabang BANDUNG");

		$objPHPExcel->getActiveSheet()->getStyle('A27:P43')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('L27:N27');
		$objPHPExcel->getActiveSheet()->setCellValue('L27',"BANDUNG, ".date("d/m/Y"));

		$objPHPExcel->getActiveSheet()->mergeCells('A28:P28');
		$objPHPExcel->getActiveSheet()->setCellValue('A28',"MENGETAHUI/MENYETUJUI");

		$objPHPExcel->getActiveSheet()->mergeCells('B30:D30');
		$objPHPExcel->getActiveSheet()->setCellValue('B30',"RUSBID TWP/BANPER");

		$objPHPExcel->getActiveSheet()->mergeCells('G30:I30');
		$objPHPExcel->getActiveSheet()->setCellValue('G30',"KETUA KOPTEL");

		$objPHPExcel->getActiveSheet()->mergeCells('L30:N30');
		$objPHPExcel->getActiveSheet()->setCellValue('L30',"BENDAHARA");

		$objPHPExcel->getActiveSheet()->mergeCells('B34:D34');
		$objPHPExcel->getActiveSheet()->setCellValue('B34',(isset($data['approve_3_by'])?$data['approve_3_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('B35:D35');
		$objPHPExcel->getActiveSheet()->setCellValue('B35',"NIK : 590430");

		$objPHPExcel->getActiveSheet()->mergeCells('G34:I34');
		$objPHPExcel->getActiveSheet()->setCellValue('G34',(isset($data['approve_1_by'])?$data['approve_1_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('G35:I35');
		$objPHPExcel->getActiveSheet()->setCellValue('G35',"NIK : 641905");

		$objPHPExcel->getActiveSheet()->mergeCells('L34:N34');
		$objPHPExcel->getActiveSheet()->setCellValue('L34',(isset($data['approve_2_by'])?$data['approve_2_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('L35:N35');
		$objPHPExcel->getActiveSheet()->setCellValue('L35',"NIK : 642003");

		// $objPHPExcel->getActiveSheet()->mergeCells('B38:D38');
		// $objPHPExcel->getActiveSheet()->setCellValue('B38',"SEKRETARIS KOPTEL");

		// $objPHPExcel->getActiveSheet()->mergeCells('G38:I38');
		// $objPHPExcel->getActiveSheet()->setCellValue('G38',"RUSBID USAHA");

		// $objPHPExcel->getActiveSheet()->mergeCells('B42:D42');
		// $objPHPExcel->getActiveSheet()->setCellValue('B42',"DENNY HERJADI");
		// $objPHPExcel->getActiveSheet()->mergeCells('B43:D43');
		// $objPHPExcel->getActiveSheet()->setCellValue('B43',"NIK : 591731");

		// $objPHPExcel->getActiveSheet()->mergeCells('G42:I42');
		// $objPHPExcel->getActiveSheet()->setCellValue('G42',"BENNY SUYATNO MAHATMANTA");
		// $objPHPExcel->getActiveSheet()->mergeCells('G43:I43');
		// $objPHPExcel->getActiveSheet()->setCellValue('G43',"NIK : 642019");

		$objPHPExcel->getActiveSheet()->getStyle('A46:P46')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('J51:M51')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B53:E53')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B56:E56')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A59:P59')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A66:P66')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B53:E53')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('B56:E56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->setCellValue('A46',"1");
		$objPHPExcel->getActiveSheet()->mergeCells('B46:E46');
		$objPHPExcel->getActiveSheet()->setCellValue('B46',"Catatan Pembayaran : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B47:E47');
		$objPHPExcel->getActiveSheet()->setCellValue('B47',"Jumlah Pembiayaan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B48:E48');
		$objPHPExcel->getActiveSheet()->setCellValue('B48',"Potongan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B49:E49');
		$objPHPExcel->getActiveSheet()->setCellValue('B49',"Konpensasi Pembiayaan Koptel ");
		$objPHPExcel->getActiveSheet()->mergeCells('B50:E50');
		$objPHPExcel->getActiveSheet()->setCellValue('B50',"Angsuran Pertama ");
		$objPHPExcel->getActiveSheet()->mergeCells('B51:E51');
		$objPHPExcel->getActiveSheet()->setCellValue('B51',"Premi Asuransi Tambahan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B52:E52');
		$objPHPExcel->getActiveSheet()->setCellValue('B52',"Ujrah ");
		$objPHPExcel->getActiveSheet()->mergeCells('B53:E53');
		$objPHPExcel->getActiveSheet()->setCellValue('B53',"Jumlah Koptel Transfer ");
		$objPHPExcel->getActiveSheet()->mergeCells('B54:E54');
		$objPHPExcel->getActiveSheet()->setCellValue('B54',"Konpensasi Pelunasan kopegtel ");
		$objPHPExcel->getActiveSheet()->mergeCells('B55:E55');
		$objPHPExcel->getActiveSheet()->setCellValue('B55',"Premi Asuransi ");
		$objPHPExcel->getActiveSheet()->mergeCells('B56:E56');
		$objPHPExcel->getActiveSheet()->setCellValue('B56',"Jumlah diterima pegawai ");

		$jumlah_pembiayaan = (isset($data['jumlah_pembiayaan'])?$data['jumlah_pembiayaan']:"0");
		$pelunasan_koptel = (isset($data['pelunasan_koptel'])?$data['pelunasan_koptel']:"0");
		$angsuran_pertama = (isset($data['angsuran_pertama'])?$data['angsuran_pertama']:"0");
		$premi_asuransi_tambahan = (isset($data['premi_asuransi_tambahan'])?$data['premi_asuransi_tambahan']:"0");
		$ujroh = (isset($data['ujroh'])?$data['ujroh']:"0");
		$jumlah_koptel_transfer = (isset($data['jumlah_koptel_transfer'])?$data['jumlah_koptel_transfer']:"0");
		$pelunasan_kopeg = (isset($data['pelunasan_kopeg'])?$data['pelunasan_kopeg']:"0");
		$premi_asuransi = (isset($data['premi_asuransi'])?$data['premi_asuransi']:"0");
		$jumlah_diterima_karyawan = $jumlah_pembiayaan+$pelunasan_koptel+$angsuran_pertama+$premi_asuransi_tambahan+$ujroh+$jumlah_koptel_transfer+$pelunasan_kopeg+$premi_asuransi;

		$objPHPExcel->getActiveSheet()->getStyle('F47:F56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->setCellValue('F47'," ". (isset($data['jumlah_pembiayaan'])?number_format($data['jumlah_pembiayaan'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F49'," ". (isset($data['pelunasan_koptel'])?number_format($data['pelunasan_koptel'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F50'," ". (isset($data['angsuran_pertama'])?number_format($data['angsuran_pertama'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F51'," ". (isset($data['premi_asuransi_tambahan'])?number_format($data['premi_asuransi_tambahan'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F52'," ". (isset($data['ujroh'])?number_format($data['ujroh'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F53'," ". (isset($data['jumlah_koptel_transfer'])?number_format($data['jumlah_koptel_transfer'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F54'," ". (isset($data['pelunasan_kopeg'])?number_format($data['pelunasan_kopeg'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F55'," ". (isset($data['premi_asuransi'])?number_format($data['premi_asuransi'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F56'," ". (isset($jumlah_diterima_karyawan)?number_format($jumlah_diterima_karyawan,0,',','.'):"0"));

		$objPHPExcel->getActiveSheet()->setCellValue('I46',"2");
		$objPHPExcel->getActiveSheet()->mergeCells('J46:M46');
		$objPHPExcel->getActiveSheet()->setCellValue('J46',"Perhitungan Uang Muka : ");
		$objPHPExcel->getActiveSheet()->mergeCells('J47:M47');
		$objPHPExcel->getActiveSheet()->setCellValue('J47',"Besar Uang Muka ");
		$objPHPExcel->getActiveSheet()->mergeCells('J48:M48');
		$objPHPExcel->getActiveSheet()->setCellValue('J48',"Sudah Dikembalikan ");
		$objPHPExcel->getActiveSheet()->mergeCells('J49:M49');
		$objPHPExcel->getActiveSheet()->setCellValue('J49',"Sisa Yang Dikembalikan ");
		$objPHPExcel->getActiveSheet()->mergeCells('J50:M50');
		$objPHPExcel->getActiveSheet()->setCellValue('J50',"Dikembalikan Dengan SPB ini ");
		$objPHPExcel->getActiveSheet()->mergeCells('J51:M51');
		$objPHPExcel->getActiveSheet()->setCellValue('J51',"Saldo ");

		$objPHPExcel->getActiveSheet()->setCellValue('N47'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N48'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N49'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N50'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N51'," : ");

		$objPHPExcel->getActiveSheet()->setCellValue('A59',"3");
		$objPHPExcel->getActiveSheet()->mergeCells('B59:E59');
		$objPHPExcel->getActiveSheet()->setCellValue('B59',"Catatan Penerimaan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B60:E60');
		$objPHPExcel->getActiveSheet()->setCellValue('B60',"Telah terima uang sebesar : ");

		$objPHPExcel->getActiveSheet()->setCellValue('I59',"4");
		$objPHPExcel->getActiveSheet()->mergeCells('J59:M59');
		$objPHPExcel->getActiveSheet()->setCellValue('J59',"Catatan Transfer : ");
		$objPHPExcel->getActiveSheet()->mergeCells('J60:M60');
		$objPHPExcel->getActiveSheet()->setCellValue('J60',"Transfer Tanggal ");
		$objPHPExcel->getActiveSheet()->mergeCells('J61:M61');
		$objPHPExcel->getActiveSheet()->setCellValue('J61',"Nomor GB ");
		$objPHPExcel->getActiveSheet()->mergeCells('J62:M62');
		$objPHPExcel->getActiveSheet()->setCellValue('J62',"Tanggal GB ");
		$objPHPExcel->getActiveSheet()->mergeCells('J63:M63');
		$objPHPExcel->getActiveSheet()->setCellValue('J63',"Rek. Bank No. ");

		$objPHPExcel->getActiveSheet()->setCellValue('N60'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N61'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N62'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N63'," : ");

		$objPHPExcel->getActiveSheet()->setCellValue('A66',"5");
		$objPHPExcel->getActiveSheet()->mergeCells('B66:E66');
		$objPHPExcel->getActiveSheet()->setCellValue('B66',"Catatan Pembukuan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B67:E67');
		$objPHPExcel->getActiveSheet()->setCellValue('B67',"Dicatat dalam SIMAK ");
		$objPHPExcel->getActiveSheet()->mergeCells('B68:E68');
		$objPHPExcel->getActiveSheet()->setCellValue('B68',"Nomor Bukti Pembukuan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B69:E69');
		$objPHPExcel->getActiveSheet()->setCellValue('B69',"Tanggal ");
		$objPHPExcel->getActiveSheet()->mergeCells('B70:E70');
		$objPHPExcel->getActiveSheet()->setCellValue('B70',"Tanggal Entry ");

		$objPHPExcel->getActiveSheet()->setCellValue('F67'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F68'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F69'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F70'," : ");

		$objPHPExcel->getActiveSheet()->getStyle('A8:P70')->applyFromArray($styleArray);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="CETAK_SPB.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	
	function do_cetak_spb_xls()
	{
		$id_spb = $this->uri->segment(3);
		$datas = $this->model_nasabah->get_data_cetak_spb($id_spb);
		$data = $datas;
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->library('phpexcel');
		// Create new PHPExcel object
		$objPHPExcel = $this->phpexcel;

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
									 ->setLastModifiedBy("MICROFINANCE")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("REPORT, generated using PHP classes.")
									 ->setKeywords("REPORT")
									 ->setCategory("Test result file");
									 
		$objPHPExcel->setActiveSheetIndex(0); 

		$styleArray = array(
       		'borders' => array(
		             'outline' => array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                    'color' => array('rgb' => '000000'),
		             ),
		       ),
		);

		$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',"KOPERASI PT TELEKOMUNIKASI");
		$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:P75')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"Jl. Ciwulan No. 23 Bandung - 40114");
		$objPHPExcel->getActiveSheet()->mergeCells('A3:P3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Tlp  022 - 7201420, 022 - 7200431");
		$objPHPExcel->getActiveSheet()->mergeCells('A5:P5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5',"SURAT PERINTAH BAYAR (SPB)");
		$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:P12')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle('A15:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A15:P16')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A21:P43')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A8:E8');
		$objPHPExcel->getActiveSheet()->setCellValue('A8',"Catatan Bagian Asal :");
		$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
		$objPHPExcel->getActiveSheet()->setCellValue('A9',"NOMOR");
		$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
		$objPHPExcel->getActiveSheet()->setCellValue('A10',"TANGGAL");
		$objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
		$objPHPExcel->getActiveSheet()->setCellValue('A11',"AKUN");
		$objPHPExcel->getActiveSheet()->mergeCells('A12:B12');
		$objPHPExcel->getActiveSheet()->setCellValue('A12',"TAHUN");
		$objPHPExcel->getActiveSheet()->setCellValue('C9',": ".(isset($data['no_spb'])?$data['no_spb']:""));
		$objPHPExcel->getActiveSheet()->setCellValue('C10',": ".(isset($data['tanggal_spb'])?date('d-m-Y',strtotime($data['tanggal_spb'])):""));
		$objPHPExcel->getActiveSheet()->setCellValue('C11',": ".(isset($data['akun'])?$data['akun']:""));
		$objPHPExcel->getActiveSheet()->setCellValue('C12',": ".date("Y"));

		$objPHPExcel->getActiveSheet()->mergeCells('I8:M8');
		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Catatan di Bagian Anggaran :");
		$objPHPExcel->getActiveSheet()->mergeCells('I9:J9');
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"LOKASI");
		$objPHPExcel->getActiveSheet()->mergeCells('I10:J10');
		$objPHPExcel->getActiveSheet()->setCellValue('I10',"BEBAN/TAHUN");
		$objPHPExcel->getActiveSheet()->mergeCells('I11:J11');
		$objPHPExcel->getActiveSheet()->setCellValue('I11',"AKUN");
		$objPHPExcel->getActiveSheet()->setCellValue('K9',": TWP & BANPER");
		$objPHPExcel->getActiveSheet()->setCellValue('K10',": Eksploitasi /  Investasi / ".date("Y"));
		$objPHPExcel->getActiveSheet()->setCellValue('K11',": ".(isset($data['akun'])?$data['akun']:""));

		$objPHPExcel->getActiveSheet()->mergeCells('A15:P15');
		$objPHPExcel->getActiveSheet()->setCellValue('A15',"PENGURUS/MANAGER");
		$objPHPExcel->getActiveSheet()->mergeCells('A16:P16');
		$objPHPExcel->getActiveSheet()->setCellValue('A16',"KOPERASI PT TELEKOMUNIKASI INDONESIA (KOPTEL)");

		$objPHPExcel->getActiveSheet()->mergeCells('A18:P18');
		$objPHPExcel->getActiveSheet()->setCellValue('A18',"Bendahara Koperasi PT Telekomunikasi Indonesia di Jl. Ciwulan No. 23 Bandung diminta untuk membayarkan uang sebesar :");

		$objPHPExcel->getActiveSheet()->mergeCells('A19:P19');
		$objPHPExcel->getActiveSheet()->setCellValue('A19',"Rp ".(isset($data['jumlah_pembiayaan'])?number_format($data['jumlah_pembiayaan'],0,',','.'):"0")." (".ucwords((isset($data['jumlah_pembiayaan'])?$this->terbilang($data['jumlah_pembiayaan']):"-"))." Rupiah)");

		$objPHPExcel->getActiveSheet()->mergeCells('A21:B21');
		$objPHPExcel->getActiveSheet()->setCellValue('A21',"KEPADA");
		$objPHPExcel->getActiveSheet()->mergeCells('A22:B22');
		$objPHPExcel->getActiveSheet()->setCellValue('A22',"NAMA");
		$objPHPExcel->getActiveSheet()->mergeCells('A23:B23');
		$objPHPExcel->getActiveSheet()->setCellValue('A23',"ALAMAT");
		$objPHPExcel->getActiveSheet()->mergeCells('A24:B24');
		$objPHPExcel->getActiveSheet()->setCellValue('A24',"UNTUK");
		$objPHPExcel->getActiveSheet()->setCellValue('C21',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C22',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C23',": Daftar Terlampir");
		$objPHPExcel->getActiveSheet()->setCellValue('C24',": Penyaluran Pembiayaan ".$data['product_name']." Thn ".date("Y")."");

		$objPHPExcel->getActiveSheet()->mergeCells('I21:J21');
		$objPHPExcel->getActiveSheet()->setCellValue('I21',"NAMA");
		$objPHPExcel->getActiveSheet()->mergeCells('I22:J22');
		$objPHPExcel->getActiveSheet()->setCellValue('I22',"NO. REKENING");
		$objPHPExcel->getActiveSheet()->mergeCells('I23:J23');
		$objPHPExcel->getActiveSheet()->setCellValue('I23',"PADA BANK");
		$objPHPExcel->getActiveSheet()->mergeCells('I24:J24');
		$objPHPExcel->getActiveSheet()->setCellValue('I24',"CABANG");
		$objPHPExcel->getActiveSheet()->setCellValue('K21',": Daftar Terlampir AJB BUMI PUTERA 1912");
		$objPHPExcel->getActiveSheet()->setCellValue('K22',": Daftar Terlampir NO. REKENING 130-00-0129707-9");
		$objPHPExcel->getActiveSheet()->setCellValue('K23',": Daftar Terlampir BANK MANDIRI");
		$objPHPExcel->getActiveSheet()->setCellValue('K24',": Daftar Terlampir Cabang BANDUNG");

		$objPHPExcel->getActiveSheet()->getStyle('A27:P43')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('L27:N27');
		$objPHPExcel->getActiveSheet()->setCellValue('L27',"BANDUNG, ".date("d/m/Y"));

		$objPHPExcel->getActiveSheet()->mergeCells('A28:P28');
		$objPHPExcel->getActiveSheet()->setCellValue('A28',"MENGETAHUI/MENYETUJUI");

		$jabatan_approver_3 = ($data['approve_3_id'] == '753') ? 'PENGEMBANGAN BISNIS' : 'RUSBID TWP/BANPER';
		$objPHPExcel->getActiveSheet()->mergeCells('B30:D30');
		$objPHPExcel->getActiveSheet()->setCellValue('B30',$jabatan_approver_3);

		$objPHPExcel->getActiveSheet()->mergeCells('G30:I30');
		$objPHPExcel->getActiveSheet()->setCellValue('G30',"KETUA KOPTEL");

		$objPHPExcel->getActiveSheet()->mergeCells('L30:N30');
		$objPHPExcel->getActiveSheet()->setCellValue('L30',"BENDAHARA");

		$nik_approver_3 = ($data['approve_3_id'] == '753') ? '660389' : '590430';
		$objPHPExcel->getActiveSheet()->mergeCells('B34:D34');
		$objPHPExcel->getActiveSheet()->setCellValue('B34',(isset($data['approve_3_by'])?$data['approve_3_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('B35:D35');
		$objPHPExcel->getActiveSheet()->setCellValue('B35',"NIK : ". $nik_approver_3);
		
		$objPHPExcel->getActiveSheet()->mergeCells('G34:I34');
		$objPHPExcel->getActiveSheet()->setCellValue('G34',(isset($data['approve_1_by'])?$data['approve_1_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('G35:I35');
		$objPHPExcel->getActiveSheet()->setCellValue('G35',"NIK : 642090");

		$objPHPExcel->getActiveSheet()->mergeCells('L34:N34');
		$objPHPExcel->getActiveSheet()->setCellValue('L34',(isset($data['approve_2_by'])?$data['approve_2_by']:""));
		$objPHPExcel->getActiveSheet()->mergeCells('L35:N35');
		$objPHPExcel->getActiveSheet()->setCellValue('L35',"NIK : 642003");

		// $objPHPExcel->getActiveSheet()->mergeCells('B38:D38');
		// $objPHPExcel->getActiveSheet()->setCellValue('B38',"SEKRETARIS KOPTEL");

		// $objPHPExcel->getActiveSheet()->mergeCells('G38:I38');
		// $objPHPExcel->getActiveSheet()->setCellValue('G38',"RUSBID USAHA");

		// $objPHPExcel->getActiveSheet()->mergeCells('B42:D42');
		// $objPHPExcel->getActiveSheet()->setCellValue('B42',"DENNY HERJADI");
		// $objPHPExcel->getActiveSheet()->mergeCells('B43:D43');
		// $objPHPExcel->getActiveSheet()->setCellValue('B43',"NIK : 591731");

		// $objPHPExcel->getActiveSheet()->mergeCells('G42:I42');
		// $objPHPExcel->getActiveSheet()->setCellValue('G42',"BENNY SUYATNO MAHATMANTA");
		// $objPHPExcel->getActiveSheet()->mergeCells('G43:I43');
		// $objPHPExcel->getActiveSheet()->setCellValue('G43',"NIK : 642019");

		$objPHPExcel->getActiveSheet()->getStyle('A46:P46')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('J51:M51')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B53:E53')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B56:E56')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A59:P59')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A66:P66')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B53:E53')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('B56:E56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->setCellValue('A46',"1");
		$objPHPExcel->getActiveSheet()->mergeCells('B46:E46');
		$objPHPExcel->getActiveSheet()->setCellValue('B46',"Catatan Pembayaran : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B47:E47');
		$objPHPExcel->getActiveSheet()->setCellValue('B47',"Jumlah Pembiayaan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B48:E48');
		$objPHPExcel->getActiveSheet()->setCellValue('B48',"Potongan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B49:E49');
		$objPHPExcel->getActiveSheet()->setCellValue('B49',"Konpensasi Pembiayaan Koptel ");
		$objPHPExcel->getActiveSheet()->mergeCells('B50:E50');
		$objPHPExcel->getActiveSheet()->setCellValue('B50',"Angsuran Pertama ");
		$objPHPExcel->getActiveSheet()->mergeCells('B51:E51');
		$objPHPExcel->getActiveSheet()->setCellValue('B51',"Premi Asuransi Tambahan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B52:E52');
		$objPHPExcel->getActiveSheet()->setCellValue('B52',"Ujrah ");
		$objPHPExcel->getActiveSheet()->mergeCells('B53:E53');
		$objPHPExcel->getActiveSheet()->setCellValue('B53',"Jumlah Koptel Transfer ");
		$objPHPExcel->getActiveSheet()->mergeCells('B54:E54');
		$objPHPExcel->getActiveSheet()->setCellValue('B54',"Konpensasi Pelunasan kopegtel ");
		$objPHPExcel->getActiveSheet()->mergeCells('B55:E55');
		$objPHPExcel->getActiveSheet()->setCellValue('B55',"Premi Asuransi ");
		$objPHPExcel->getActiveSheet()->mergeCells('B56:E56');
		$objPHPExcel->getActiveSheet()->setCellValue('B56',"Jumlah diterima pegawai ");

		$jumlah_pembiayaan = (isset($data['jumlah_pembiayaan'])?$data['jumlah_pembiayaan']:"0");
		$pelunasan_koptel = (isset($data['pelunasan_koptel'])?$data['pelunasan_koptel']:"0");
		if ($data['product_code']=='58') {
			$angsuran_pertama = 0;
		} else {
			$angsuran_pertama = (isset($data['angsuran_pertama'])?$data['angsuran_pertama']:"0");
		}
		$premi_asuransi_tambahan = (isset($data['premi_asuransi_tambahan'])?$data['premi_asuransi_tambahan']:"0");
		$ujroh = (isset($data['ujroh'])?$data['ujroh']:"0");
		$jumlah_koptel_transfer = (isset($data['jumlah_koptel_transfer'])?$data['jumlah_koptel_transfer']:"0");
		$pelunasan_kopeg = (isset($data['pelunasan_kopeg'])?$data['pelunasan_kopeg']:"0");
		$premi_asuransi = (isset($data['premi_asuransi'])?$data['premi_asuransi']:"0");
		$jumlah_diterima_karyawan = $jumlah_pembiayaan+$pelunasan_koptel+$angsuran_pertama+$premi_asuransi_tambahan+$ujroh+$jumlah_koptel_transfer+$pelunasan_kopeg+$premi_asuransi;

		$objPHPExcel->getActiveSheet()->getStyle('F47:F56')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->setCellValue('F47'," ". (isset($data['jumlah_pembiayaan'])?number_format($data['jumlah_pembiayaan'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F49'," ". (isset($data['pelunasan_koptel'])?number_format($data['pelunasan_koptel'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F50'," ". number_format($angsuran_pertama,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('F51'," ". (isset($data['premi_asuransi_tambahan'])?number_format($data['premi_asuransi_tambahan'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F52'," ". (isset($data['ujroh'])?number_format($data['ujroh'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F53'," ". (isset($data['jumlah_koptel_transfer'])?number_format($data['jumlah_koptel_transfer'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F54'," ". (isset($data['pelunasan_kopeg'])?number_format($data['pelunasan_kopeg'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F55'," ". (isset($data['premi_asuransi'])?number_format($data['premi_asuransi'],0,',','.'):"0"));
		$objPHPExcel->getActiveSheet()->setCellValue('F56'," ". (isset($jumlah_diterima_karyawan)?number_format($jumlah_diterima_karyawan,0,',','.'):"0"));

		$objPHPExcel->getActiveSheet()->setCellValue('I46',"2");
		$objPHPExcel->getActiveSheet()->mergeCells('J46:M46');
		$objPHPExcel->getActiveSheet()->setCellValue('J46',"Perhitungan Uang Muka : ");
		$objPHPExcel->getActiveSheet()->mergeCells('J47:M47');
		$objPHPExcel->getActiveSheet()->setCellValue('J47',"Besar Uang Muka ");
		$objPHPExcel->getActiveSheet()->mergeCells('J48:M48');
		$objPHPExcel->getActiveSheet()->setCellValue('J48',"Sudah Dikembalikan ");
		$objPHPExcel->getActiveSheet()->mergeCells('J49:M49');
		$objPHPExcel->getActiveSheet()->setCellValue('J49',"Sisa Yang Dikembalikan ");
		$objPHPExcel->getActiveSheet()->mergeCells('J50:M50');
		$objPHPExcel->getActiveSheet()->setCellValue('J50',"Dikembalikan Dengan SPB ini ");
		$objPHPExcel->getActiveSheet()->mergeCells('J51:M51');
		$objPHPExcel->getActiveSheet()->setCellValue('J51',"Saldo ");

		$objPHPExcel->getActiveSheet()->setCellValue('N47'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N48'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N49'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N50'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N51'," : ");

		$objPHPExcel->getActiveSheet()->setCellValue('A59',"3");
		$objPHPExcel->getActiveSheet()->mergeCells('B59:E59');
		$objPHPExcel->getActiveSheet()->setCellValue('B59',"Catatan Penerimaan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B60:E60');
		$objPHPExcel->getActiveSheet()->setCellValue('B60',"Telah terima uang sebesar : ");

		$objPHPExcel->getActiveSheet()->setCellValue('I59',"4");
		$objPHPExcel->getActiveSheet()->mergeCells('J59:M59');
		$objPHPExcel->getActiveSheet()->setCellValue('J59',"Catatan Transfer : ");
		$objPHPExcel->getActiveSheet()->mergeCells('J60:M60');
		$objPHPExcel->getActiveSheet()->setCellValue('J60',"Transfer Tanggal ");
		$objPHPExcel->getActiveSheet()->mergeCells('J61:M61');
		$objPHPExcel->getActiveSheet()->setCellValue('J61',"Nomor GB ");
		$objPHPExcel->getActiveSheet()->mergeCells('J62:M62');
		$objPHPExcel->getActiveSheet()->setCellValue('J62',"Tanggal GB ");
		$objPHPExcel->getActiveSheet()->mergeCells('J63:M63');
		$objPHPExcel->getActiveSheet()->setCellValue('J63',"Rek. Bank No. ");

		$objPHPExcel->getActiveSheet()->setCellValue('N60'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N61'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N62'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('N63'," : ");

		$objPHPExcel->getActiveSheet()->setCellValue('A66',"5");
		$objPHPExcel->getActiveSheet()->mergeCells('B66:E66');
		$objPHPExcel->getActiveSheet()->setCellValue('B66',"Catatan Pembukuan : ");
		$objPHPExcel->getActiveSheet()->mergeCells('B67:E67');
		$objPHPExcel->getActiveSheet()->setCellValue('B67',"Dicatat dalam SIMAK ");
		$objPHPExcel->getActiveSheet()->mergeCells('B68:E68');
		$objPHPExcel->getActiveSheet()->setCellValue('B68',"Nomor Bukti Pembukuan ");
		$objPHPExcel->getActiveSheet()->mergeCells('B69:E69');
		$objPHPExcel->getActiveSheet()->setCellValue('B69',"Tanggal ");
		$objPHPExcel->getActiveSheet()->mergeCells('B70:E70');
		$objPHPExcel->getActiveSheet()->setCellValue('B70',"Tanggal Entry ");

		$objPHPExcel->getActiveSheet()->setCellValue('F67'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F68'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F69'," : ");
		$objPHPExcel->getActiveSheet()->setCellValue('F70'," : ");

		$objPHPExcel->getActiveSheet()->getStyle('A8:P70')->applyFromArray($styleArray);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="CETAK_SPB.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	// public function cetak_pdf_spb($datas)
	// {
	// 	$data['get'] = $datas;
	// 	ob_start();
	// 	$config['full_tag_open'] = '<p>';
	// 	$config['full_tag_close'] = '</p>';
	// 	$this->load->view('nasabah/cetak_pdf_spb',$data);
	// 	$content = ob_get_clean();
	// 	try
	// 	{
	// 	$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 7);
	// 	$html2pdf->pdf->SetDisplayMode('fullpage');
	// 	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	// 	$html2pdf->Output('CETAK_SPB.pdf');
	// 	}
	// 	catch(HTML2PDF_exception $e) {
	// 	echo $e;
	// 	exit;
	// 	}
	// }

	function get_tanggal_spb_by_no_spb()
	{
		$no_spb = $this->input->post('no_spb');
		$data = $this->model_nasabah->get_tanggal_spb_by_no_spb($no_spb);
		echo json_encode($data);
	}
	// private function action_send_sms($sms_to,$sms_message)
	// {
	// 	$plus62 = substr($sms_to,0,3);
	// 	if($plus62=="628"){
	// 		$sms_to = substr($sms_to,2);
	// 		$sms_to = "+62".$sms_to;
	// 	}else if($plus62!="+62"){
	// 		$sms_to = substr($sms_to,1);
	// 		$sms_to = "+62".$sms_to;
	// 	}
	// 	$sms_message = str_replace(' ', '+', $sms_message);
		
	// 	$link4execute = 'http://103.253.113.76/~playsms/index.php?app=webservices&u=mhd&h=d40021b3cbdbd504cfc657a8ecd5964d&ta=pv&to='.$sms_to.'&msg='.$sms_message.'&format=json';
	// 	// $link4execute = 'http://sms.tazkiaonline.com:8989/playsms/input.php?u=rohmat&p=rohmat2010&ta=pv&to='.$sms_to.'&msg='.$sms_message;
	// 	$ch = curl_init(); //buat resourcce cURL
	// 	curl_setopt($ch, CURLOPT_URL, $link4execute);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$output = curl_exec($ch);
	// 	$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 	curl_close($ch);
	// }

	
	/*
	| EDIT SPB
	*/
	public function edit_spb()
	{
		$data['container'] = 'nasabah/edit_spb';
		$data['no_spb'] = $this->model_nasabah->get_no_spb_not_approve();
		$data['tgl_spb'] = $this->model_nasabah->get_tgl_spb_not_approve();
		$this->load->view('core',$data);
	}
	function get_no_spb_by_tanggal_spb()
	{
		$tanggal_spb = $this->input->post('tanggal_spb');
		$data = $this->model_nasabah->get_no_spb_by_tanggal_spb($tanggal_spb);
		echo json_encode($data);
	}
	function reload_get_tanggal_spb()
	{
		$data = $this->model_nasabah->get_tgl_spb_not_approve();
		echo json_encode($data);
	}
	
	public function jqgrid_data_spb_status_transfer_nol()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'b.tanggal_transfer';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'asc';
		$no_spb = isset($_REQUEST['no_spb'])?$_REQUEST['no_spb']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_nasabah->jqgrid_data_spb_status_transfer_nol('','','','',$no_spb);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_nasabah->jqgrid_data_spb_status_transfer_nol($sidx,$sord,$limit_rows,$start,$no_spb);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			if ($row['product_code']=='58') {
				$angsuranke1 = 0;
			} else {
				$angsuranke1 = $row['angsuran_pokok']+$row['angsuran_margin'];
			}
			$biaya_adm = $row['biaya_administrasi']+$row['biaya_notaris']+$row['biaya_asuransi_jiwa'];
			$responce['rows'][$i]['no_spb'] = $row['no_spb'];
			$responce['rows'][$i]['cell'] = array(
				 $row['no_spb']
				,$row['account_financing_no']
				,$row['nama']
				,$row['droping_date']
				,$row['tanggal_transfer']
				,$row['pokok']
				,$angsuranke1
				,$row['biaya_administrasi']
				,$row['biaya_notaris']
				,$row['biaya_asuransi_jiwa']
				,$row['kewajiban_koptel']
				,$row['kewajiban_kopegtel']
				,$row['premi_asuransi']
			);
			$i++;
		}

		echo json_encode($responce);
	}
	
	public function jqgrid_data_spb_status_transfer_tidak_nol()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'b.tanggal_transfer';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'asc';
		$no_spb = isset($_REQUEST['no_spb'])?$_REQUEST['no_spb']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_nasabah->jqgrid_data_spb_status_transfer_tidak_nol('','','','',$no_spb);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_nasabah->jqgrid_data_spb_status_transfer_tidak_nol($sidx,$sord,$limit_rows,$start,$no_spb);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			if ($row['product_code']=='58') {
				$angsuranke1 = 0;
			} else {
				$angsuranke1 = $row['angsuran_pokok']+$row['angsuran_margin'];
			}
			$biaya_adm = $row['biaya_administrasi']+$row['biaya_notaris']+$row['biaya_asuransi_jiwa'];
			$responce['rows'][$i]['no_spb'] = $row['no_spb'];
			$responce['rows'][$i]['cell'] = array(
				 $row['no_spb']
				,$row['account_financing_no']
				,$row['nama']
				,$row['droping_date']
				,$row['tanggal_transfer']
				,$row['pokok']
				,$angsuranke1
				,$row['biaya_administrasi']
				,$row['biaya_notaris']
				,$row['biaya_asuransi_jiwa']
				,$row['kewajiban_koptel']
				,$row['kewajiban_kopegtel']
				,$row['premi_asuransi']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function save_tambahan_spb()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$no_spb = $this->input->post('no_spb');
		$tanggal_spb = $this->input->post('tanggal_spb');

    	$get_data_spb = $this->model_nasabah->get_data_tambahan_spb_by_account_financing_no($account_financing_no);
    	if(count($get_data_spb)>0)
    	{
			if($account_financing_no!="")
				$biaya_adm = (isset($get_data_spb['biaya_administrasi'])?$get_data_spb['biaya_administrasi']:'0')+(isset($get_data_spb['biaya_notaris'])?$get_data_spb['biaya_notaris']:'0')+(isset($get_data_spb['biaya_asuransi_jiwa'])?$get_data_spb['biaya_asuransi_jiwa']:'0');
				$angsuran_pertama = (isset($get_data_spb['angsuran_pokok'])?$get_data_spb['angsuran_pokok']:'0')+(isset($get_data_spb['angsuran_margin'])?$get_data_spb['angsuran_margin']:'0');
				$ujroh = (isset($get_data_spb['biaya_asuransi_jiwa'])?$get_data_spb['biaya_asuransi_jiwa']:'0')*5/100;
				$jumlah_koptel_transfer = (isset($get_data_spb['pokok'])?$get_data_spb['pokok']:'0')-$ujroh-$angsuran_pertama-(isset($get_data_spb['outstanding_koptel'])?$get_data_spb['outstanding_koptel']:'0');
				$ins_data_spb_detail = array(
								'no_spb' => $no_spb,
								'jumlah_pembiayaan' => isset($get_data_spb['pokok'])?$get_data_spb['pokok']:'0',
								'pelunasan_koptel' => isset($get_data_spb['outstanding_koptel'])?$get_data_spb['outstanding_koptel']:'0',
								'angsuran_pertama' => isset($angsuran_pertama)?$angsuran_pertama:'0',
								'premi_asuransi_tambahan' => isset($get_data_spb['premi_asuransi_tambahan'])?$get_data_spb['premi_asuransi_tambahan']:'0',
								'ujroh' => isset($ujroh)?$ujroh:'0',
								'jumlah_koptel_transfer' => isset($jumlah_koptel_transfer)?$jumlah_koptel_transfer:'0',
								'pelunasan_kopeg' => isset($get_data_spb['outstanding_kopegtel'])?$get_data_spb['outstanding_kopegtel']:'0',
								'premi_asuransi' => isset($get_data_spb['premi_asuransi'])?$get_data_spb['premi_asuransi']:'0',
								'account_financing_no' => $get_data_spb['account_financing_no'],
								'biaya_administrasi' => isset($biaya_adm)?$biaya_adm:'0'
							);
		}

		$data_financing_droping = array('no_spb' => $no_spb);
		$param_financing_droping = array('account_financing_no' => $account_financing_no);

		$this->db->trans_begin();
		if(count($get_data_spb)>0)
    	{
			$this->model_nasabah->ins_data_tambahan_spb_detail($ins_data_spb_detail);
			$this->model_nasabah->update_account_financing_droping($data_financing_droping,$param_financing_droping);
		}
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function delete_tambahan_spb()
	{
		$account_financing_no=$this->input->post('account_financing_no');
		$no_spb=$this->input->post('no_spb');

		$param=array('account_financing_no'=>$account_financing_no,'no_spb'=>$no_spb);

		$data_financing_droping = array('no_spb' => '0');
		$param_financing_droping = array('account_financing_no' => $account_financing_no);

		$this->db->trans_begin();
		$this->model_nasabah->delete_data_tambahan_spb_detail($param);
		$this->model_nasabah->update_account_financing_droping($data_financing_droping,$param_financing_droping);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/*
	End
	*/

	/*
	** Begin Data Jaminan
	** 03-04-2015, Ade Sagita
	*/
	public function data_jaminan()
	{
		$data['container'] = 'nasabah/registrasi_data_jaminan';
		$data['product'] = $this->model_transaction->get_product_financing();
		$data['province'] = $this->model_cif->get_province();
		$this->load->view('core',$data);
	}

	public function datatable_data_jaminan()
	{
		$aColumns = array( '','a.registration_no', 'a.cif_no','b.nama','c.tipe_jaminan::varchar','c.nomor_jaminan','');
		$src_product = @$_REQUEST['src_product'];
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( trim($sOrder) == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = " WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_data_jaminan($sWhere,$sOrder,$sLimit,$src_product); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_data_jaminan($sWhere,'','',$src_product); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_data_jaminan('','','',$src_product); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$tipe = ($aRow['tipe_jaminan']==1) ? "Sertifikat" : "BPKB" ;
			$row[] = '<input type="checkbox" value="'.$aRow['id_jaminan'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $tipe;
			$row[] = $aRow['nomor_jaminan'];
			$row[] = '<a href="javascript:;" class="btn mini purple" id_jaminan="'.$aRow['id_jaminan'].'" id="link-edit"><i class="icon-edit"></i> Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_pengajuan_pembiayaan()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_nasabah->search_pengajuan_pembiayaan($keyword);

		echo json_encode($data);
	}

	public function search_pengajuan_pembiayaan_dokumen_lengkap()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_nasabah->search_pengajuan_pembiayaan_dokumen_lengkap($keyword);

		echo json_encode($data);
	}

	public function search_pengajuan_pembiayaan_dokumen_tdk_lengkap()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_nasabah->search_pengajuan_pembiayaan_dokumen_tdk_lengkap($keyword);

		echo json_encode($data);
	}

	public function search_kota_by_provinsi()
	{
		$provinsi_code = $this->input->post('provinsi_code');
		$data = $this->model_nasabah->search_kota_by_provinsi($provinsi_code);

		echo json_encode($data);
	}

	public function action_data_jaminan()
	{
		$kode_produk = $this->input->post('kode_produk');
		$registration_no = $this->input->post('registration_no');
		$tipe_jaminan = $this->input->post('tipe_jaminan');
		$nomor_jaminan = $this->input->post('nomor_jaminan');
		$atas_nama = $this->input->post('atas_nama');
		$atas_nama2 = $this->input->post('atas_nama2');
		$atas_nama3 = $this->input->post('atas_nama3');
		$jenis_surat = $this->input->post('jenis_surat');
		$provinsi = $this->input->post('provinsi');
		$kota = $this->input->post('kota');
		$kecamatan = $this->input->post('kecamatan');
		$kelurahan = $this->input->post('kelurahan');
		$blok = $this->input->post('blok');
		// $no_imb = $this->input->post('no_imb');
		// $tanggal_imb = $this->input->post('tanggal_imb');
		$tanggal_surat_jaminan = $this->input->post('tanggal_surat_jaminan');
		// $nop = $this->input->post('nop');
		$nilai_jual = $this->convert_numeric($this->input->post('nilai_jual'));		
		$luas_tanah = $this->input->post('luas_tanah');
		$alamat = $this->input->post('alamat');

		// if($tanggal_imb=='') $tanggal_imb=date("d/m/Y");
		if($tanggal_surat_jaminan=='') $tanggal_surat_jaminan=date("d/m/Y");
		// $tanggal_imb = $this->datepicker_convert(true,$tanggal_imb,'/');
		$tanggal_surat_jaminan = $this->datepicker_convert(true,$tanggal_surat_jaminan,'/');
		
		$status_dokumen_lengkap = 1;

		$tipe_developer = $this->input->post('tipe_developer');
		$nama_penjual_individu = $this->input->post('nama_penjual_individu');
		$nomer_ktp = $this->input->post('nomer_ktp');
		$nama_pasangan_developer = $this->input->post('nama_pasangan_developer');
		$nama_perusahaan = $this->input->post('nama_perusahaan');

		if($kode_produk=='53' || $kode_produk=='54'){ // PRODUK KMG
			$nama_pasangan = $this->input->post('nama_pasangan');
			if ($nama_pasangan!="") {
				$status_menikah = 1;
			} else {
				$status_menikah = 0;
			}
			$check_ktp = $this->input->post('check_ktp');
			$check_kk = $this->input->post('check_kk');
			$check_surat_nikah = $this->input->post('check_surat_nikah');
			$check_cover_buku_tabungan = $this->input->post('check_cover_buku_tabungan');
			$check_no_rekening = $this->input->post('check_no_rekening');
			$check_slip_gaji = $this->input->post('check_slip_gaji');
			$check_sk = $this->input->post('check_sk');
			$check_sertifikat_tanah = $this->input->post('check_sertifikat_tanah');
			$check_imb = $this->input->post('check_imb');
			$check_pbb = $this->input->post('check_pbb');
			if ($check_ktp==false) { 
				$check_ktp='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_kk==false) { 
				$check_kk='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($status_menikah==1) {
				if ($check_surat_nikah==false) { 
					$check_surat_nikah='T'; 
					$status_dokumen_lengkap=0;
				}
			}
			if ($check_cover_buku_tabungan==false) { 
				$check_cover_buku_tabungan='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_no_rekening==false) { 
				$check_no_rekening='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_slip_gaji==false) { 
				$check_slip_gaji='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_sk==false) { 
				$check_sk='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_sertifikat_tanah==false) { 
				$check_sertifikat_tanah='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_imb==false) { 
				$check_imb='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($check_pbb==false) { 
				$check_pbb='T'; 
				$status_dokumen_lengkap=0;
			}
		}

		/*
		| BEGIN CHECK DOKUMEN KPR
		| ADDENDUM BY UI
		| 24 JULI 2015
		*/
		if($kode_produk=='56'){ // PRODUK KPR
			$nama_pasangan_kpr = $this->input->post('nama_pasangan_kpr');
			if ($nama_pasangan_kpr!="") {
				$status_menikah_kpr = 1;
			} else {
				$status_menikah_kpr = 0;
			}

			$kpr_check_npwp_pemohon = $this->input->post('kpr_check_npwp_pemohon');
			$kpr_check_ktp_pemohon = $this->input->post('kpr_check_ktp_pemohon');
			$kpr_check_ktp_pasangan_pemohon = $this->input->post('kpr_check_ktp_pasangan_pemohon');
			$kpr_check_kartu_keluarga = $this->input->post('kpr_check_kartu_keluarga');
			$kpr_check_surat_nikah_pemohon = $this->input->post('kpr_check_surat_nikah_pemohon');
			$kpr_check_slip_gaji = $this->input->post('kpr_check_slip_gaji');
			$kpr_check_buku_tabungan = $this->input->post('kpr_check_buku_tabungan');
			$kpr_check_surat_perjanjian = $this->input->post('kpr_check_surat_perjanjian');
			$kpr_check_sertifikat_tanah = $this->input->post('kpr_check_sertifikat_tanah');
			$kpr_check_surat_imb = $this->input->post('kpr_check_surat_imb');
			$kpr_check_pbb = $this->input->post('kpr_check_pbb');
			$kpr_check_npwp_penjual = $this->input->post('kpr_check_npwp_penjual');
			$kpr_check_ktp_pasangan = $this->input->post('kpr_check_ktp_pasangan');
			$kpr_check_kk_penjual = $this->input->post('kpr_check_kk_penjual');
			$kpr_check_surat_nikah = $this->input->post('kpr_check_surat_nikah');
			$kpr_check_surat_cerai = $this->input->post('kpr_check_surat_cerai');
			$kpr_check_surat_penetapan = $this->input->post('kpr_check_surat_penetapan');
			$kpr_check_surat_kematian = $this->input->post('kpr_check_surat_kematian');
			$kpr_check_surat_waris = $this->input->post('kpr_check_surat_waris');
			$kpr_check_npwp_developer = $this->input->post('kpr_check_npwp_developer');
			$kpr_check_ktp_developer = $this->input->post('kpr_check_ktp_developer');
			$kpr_check_akta_developer = $this->input->post('kpr_check_akta_developer');
			$kpr_check_siup = $this->input->post('kpr_check_siup');
			$kpr_check_surat_pencairan = $this->input->post('kpr_check_surat_pencairan');

			if ($kpr_check_npwp_pemohon==false) { 
				$kpr_check_npwp_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($status_menikah_kpr==1) {
				if ($kpr_check_surat_nikah_pemohon==false) { 
					$kpr_check_surat_nikah_pemohon='T'; 
					if($tipe_developer==0){
						$status_dokumen_lengkap=0;
					}else{
						$status_dokumen_lengkap=1;
					}
				}
			}
			if ($kpr_check_ktp_pemohon==false) { 
				$kpr_check_ktp_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_ktp_pasangan_pemohon==false) { 
				$kpr_check_ktp_pasangan_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_kartu_keluarga==false) { 
				$kpr_check_kartu_keluarga='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_surat_nikah_pemohon==false) { 
				$kpr_check_surat_nikah_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_slip_gaji==false) { 
				$kpr_check_slip_gaji='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_buku_tabungan==false) { 
				$kpr_check_buku_tabungan='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_surat_perjanjian==false) { 
				$kpr_check_surat_perjanjian='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_sertifikat_tanah==false) { 
				$kpr_check_sertifikat_tanah='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_imb==false) { 
				$kpr_check_surat_imb='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_pbb==false) { 
				$kpr_check_pbb='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_npwp_penjual==false) { 
				$kpr_check_npwp_penjual='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_ktp_pasangan==false) { 
				$kpr_check_ktp_pasangan='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_kk_penjual==false) { 
				$kpr_check_kk_penjual='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_nikah==false) { 
				$kpr_check_surat_nikah='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_cerai==false) { 
				$kpr_check_surat_cerai='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_penetapan==false) { 
				$kpr_check_surat_penetapan='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_kematian==false) { 
				$kpr_check_surat_kematian='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_waris==false) { 
				$kpr_check_surat_waris='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_npwp_developer==false) { 
				$kpr_check_npwp_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_ktp_developer==false) { 
				$kpr_check_ktp_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_akta_developer==false) { 
				$kpr_check_akta_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_siup==false) { 
				$kpr_check_siup='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_surat_pencairan==false) { 
				$kpr_check_surat_pencairan='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			/*
			| END CHECK DOKUMEN KPR
			| ADDENDUM BY UI
			| 24 JULI 2015
			*/
		}

		$data	= array(
			 'registration_no'	 		=> $registration_no
			,'tipe_jaminan'	 			=> $tipe_jaminan
			,'nomor_jaminan'		 	=> $nomor_jaminan
			,'atas_nama'		 		=> $atas_nama
			,'atas_nama1'		 		=> $atas_nama2
			,'atas_nama2'		 		=> $atas_nama3
			,'jenis_surat'		 		=> $jenis_surat
			,'provinsi'		 			=> $provinsi
			,'kota'		 				=> $kota
			,'kecamatan'		 		=> $kecamatan
			,'kelurahan'		 		=> $kelurahan
			,'blok'		 				=> $blok
			// ,'no_imb'		 			=> $no_imb
			// ,'tanggal_imb'		 		=> $tanggal_imb
			,'tanggal_surat_jaminan'	=> $tanggal_surat_jaminan
			// ,'nop'		 				=> $nop
			,'nilai_jual'		 		=> $nilai_jual
			// ,'check_ktp'  				=> $check_ktp
			// ,'check_kk'  				=> $check_kk
			// ,'check_surat_nikah'  		=> $check_surat_nikah
			// ,'check_cover_buku_tabungan'=> $check_cover_buku_tabungan
			// ,'check_no_rekening'  		=> $check_no_rekening
			// ,'check_slip_gaji'  		=> $check_slip_gaji
			// ,'check_sk'  				=> $check_sk
			// ,'check_sertifikat_tanah'  	=> $check_sertifikat_tanah
			// ,'check_imb'  				=> $check_imb
			// ,'check_pbb'  				=> $check_pbb
			,'created_date'  			=> date("Y-m-d H:i:s")
			,'created_by'  				=> $this->session->userdata('user_id')
			,'luas_tanah'  				=> $luas_tanah
			,'alamat'  					=> $alamat
			,'product_code' 			=> $kode_produk
		);

		if ( $kode_produk == '53' || $kode_produk == '54' ) { // PRODUK KMG
			$data['check_ktp'] = $check_ktp;
			$data['check_kk'] = $check_kk;
			$data['check_surat_nikah'] = $check_surat_nikah;
			$data['check_cover_buku_tabungan'] = $check_cover_buku_tabungan;
			$data['check_no_rekening'] = $check_no_rekening;
			$data['check_slip_gaji'] = $check_slip_gaji;
			$data['check_sk'] = $check_sk;
			$data['check_sertifikat_tanah'] = $check_sertifikat_tanah;
			$data['check_imb'] = $check_imb;
			$data['check_pbb'] = $check_pbb;
		}

		if ( $kode_produk == '56' ) { // PRODUK KPR
			$data['kpr_check_npwp_pemohon'] = $kpr_check_npwp_pemohon;
			$data['kpr_check_ktp_pemohon'] = $kpr_check_ktp_pemohon;
			$data['kpr_check_kartu_keluarga'] = $kpr_check_kartu_keluarga;
			$data['kpr_check_slip_gaji'] = $kpr_check_slip_gaji;
			$data['kpr_check_buku_tabungan'] = $kpr_check_buku_tabungan;
			$data['kpr_check_surat_perjanjian'] = $kpr_check_surat_perjanjian;
			$data['kpr_check_sertifikat_tanah'] = $kpr_check_sertifikat_tanah;
			$data['kpr_check_surat_imb'] = $kpr_check_surat_imb;
			$data['kpr_check_pbb'] = $kpr_check_pbb;
			$data['kpr_check_npwp_penjual'] = $kpr_check_npwp_penjual;
			$data['kpr_check_ktp_pasangan'] = $kpr_check_ktp_pasangan;
			$data['kpr_check_kk_penjual'] = $kpr_check_kk_penjual;
			$data['kpr_check_surat_nikah'] = $kpr_check_surat_nikah;
			$data['kpr_check_surat_cerai'] = $kpr_check_surat_cerai;
			$data['kpr_check_surat_penetapan'] = $kpr_check_surat_penetapan;
			$data['kpr_check_surat_kematian'] = $kpr_check_surat_kematian;
			$data['kpr_check_surat_waris'] = $kpr_check_surat_waris;
			$data['kpr_check_npwp_developer'] = $kpr_check_npwp_developer;
			$data['kpr_check_ktp_developer'] = $kpr_check_ktp_developer;
			$data['kpr_check_akta_developer'] = $kpr_check_akta_developer;
			$data['kpr_check_siup'] = $kpr_check_siup;
			$data['kpr_check_surat_pencairan'] = $kpr_check_surat_pencairan;
			$data['kpr_check_ktp_pasangan_pemohon'] = $kpr_check_ktp_pasangan_pemohon;
			$data['kpr_check_surat_nikah_pemohon'] = $kpr_check_surat_nikah_pemohon;

			$data['tipe_developer'] = $tipe_developer;
			$data['nama_penjual_individu'] = $nama_penjual_individu;
			$data['nomer_ktp'] = $nomer_ktp;
			$data['nama_pasangan_developer'] = $nama_pasangan_developer;
			$data['nama_perusahaan'] = $nama_perusahaan;
		}

	
		$data_reg = array('status_dokumen_lengkap'=>$status_dokumen_lengkap);
		$param_reg = array('registration_no'=>$registration_no);

		$this->db->trans_begin();
		$this->model_nasabah->insert_data_jaminan($data);
		$this->model_nasabah->update_account_financing_reg($data_reg,$param_reg);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function update_data_jaminan()
	{
		$kode_produk = $this->input->post('kode_produk');
		$id_jaminan = $this->input->post('id_jaminan');
		$registration_no = $this->input->post('registration_no');
		$tipe_jaminan = $this->input->post('tipe_jaminan');
		$nomor_jaminan = $this->input->post('nomor_jaminan');
		$atas_nama = $this->input->post('atas_nama');
		$atas_nama2 = $this->input->post('atas_nama2');
		$atas_nama3 = $this->input->post('atas_nama3');
		$jenis_surat = $this->input->post('jenis_surat');
		$provinsi = $this->input->post('provinsi2');
		$kota = $this->input->post('kota2');
		$kecamatan = $this->input->post('kecamatan');
		$kelurahan = $this->input->post('kelurahan');
		$blok = $this->input->post('blok');
		// $no_imb = $this->input->post('no_imb');
		// $tanggal_imb = $this->input->post('tanggal_imb');
		$tanggal_surat_jaminan = $this->input->post('tanggal_surat_jaminan');
		$luas_tanah = $this->input->post('luas_tanah');
		$alamat = $this->input->post('alamat');
		// $nop = $this->input->post('nop');
		$nilai_jual = $this->convert_numeric($this->input->post('nilai_jual'));		

		// if($tanggal_imb=='') $tanggal_imb=date("d/m/Y");
		if($tanggal_surat_jaminan=='') $tanggal_surat_jaminan=date("d/m/Y");
		// $tanggal_imb = $this->datepicker_convert(true,$tanggal_imb,'/');
		$tanggal_surat_jaminan = $this->datepicker_convert(true,$tanggal_surat_jaminan,'/');
		
		$status_dokumen_lengkap = 1;

		$tipe_developer = $this->input->post('tipe_developer');
		$nama_penjual_individu = $this->input->post('nama_penjual_individu');
		$nomer_ktp = $this->input->post('nomer_ktp');
		$nama_pasangan_developer = $this->input->post('nama_pasangan_developer');
		$nama_perusahaan = $this->input->post('nama_perusahaan');

		if($kode_produk=='53' || $kode_produk=='54'){ // PRODUK KMG
			$nama_pasangan = $this->input->post('nama_pasangan');
			if ($nama_pasangan!="") {
				$status_menikah = 1;
			} else {
				$status_menikah = 0;
			}
			$check_ktp = $this->input->post('check_ktp');
			$check_kk = $this->input->post('check_kk');
			$check_surat_nikah = $this->input->post('check_surat_nikah');
			$check_cover_buku_tabungan = $this->input->post('check_cover_buku_tabungan');
			$check_no_rekening = $this->input->post('check_no_rekening');
			$check_slip_gaji = $this->input->post('check_slip_gaji');
			$check_sk = $this->input->post('check_sk');
			$check_sertifikat_tanah = $this->input->post('check_sertifikat_tanah');
			$check_imb = $this->input->post('check_imb');
			$check_pbb = $this->input->post('check_pbb');
			if ($check_ktp==false) {
				$check_ktp='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_kk==false) {
				$check_kk='T';
				$status_dokumen_lengkap = 0;
			}
			if ($status_menikah==1) {
				if ($check_surat_nikah==false) {
					$check_surat_nikah='T';
					$status_dokumen_lengkap = 0;
				}
			}
			if ($check_cover_buku_tabungan==false) {
				$check_cover_buku_tabungan='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_no_rekening==false) {
				$check_no_rekening='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_slip_gaji==false) {
				$check_slip_gaji='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_sk==false) {
				$check_sk='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_sertifikat_tanah==false) {
				$check_sertifikat_tanah='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_imb==false) {
				$check_imb='T';
				$status_dokumen_lengkap = 0;
			}
			if ($check_pbb==false) {
				$check_pbb='T';
				$status_dokumen_lengkap = 0;
			}
		}

		/*
		| BEGIN CHECK DOKUMEN KPR
		| ADDENDUM BY UI
		| 24 JULI 2015
		*/
		if($kode_produk=='56'){ // PRODUK KPR
			$nama_pasangan_kpr = $this->input->post('nama_pasangan_kpr');
			if ($nama_pasangan_kpr!="") {
				$status_menikah_kpr = 1;
			} else {
				$status_menikah_kpr = 0;
			}

			$kpr_check_npwp_pemohon = $this->input->post('kpr_check_npwp_pemohon');
			$kpr_check_ktp_pemohon = $this->input->post('kpr_check_ktp_pemohon');
			$kpr_check_ktp_pasangan_pemohon = $this->input->post('kpr_check_ktp_pasangan_pemohon');
			$kpr_check_kartu_keluarga = $this->input->post('kpr_check_kartu_keluarga');
			$kpr_check_surat_nikah_pemohon = $this->input->post('kpr_check_surat_nikah_pemohon');
			$kpr_check_slip_gaji = $this->input->post('kpr_check_slip_gaji');
			$kpr_check_buku_tabungan = $this->input->post('kpr_check_buku_tabungan');
			$kpr_check_surat_perjanjian = $this->input->post('kpr_check_surat_perjanjian');
			$kpr_check_sertifikat_tanah = $this->input->post('kpr_check_sertifikat_tanah');
			$kpr_check_surat_imb = $this->input->post('kpr_check_surat_imb');
			$kpr_check_pbb = $this->input->post('kpr_check_pbb');
			$kpr_check_npwp_penjual = $this->input->post('kpr_check_npwp_penjual');
			$kpr_check_ktp_pasangan = $this->input->post('kpr_check_ktp_pasangan');
			$kpr_check_kk_penjual = $this->input->post('kpr_check_kk_penjual');
			$kpr_check_surat_nikah = $this->input->post('kpr_check_surat_nikah');
			$kpr_check_surat_cerai = $this->input->post('kpr_check_surat_cerai');
			$kpr_check_surat_penetapan = $this->input->post('kpr_check_surat_penetapan');
			$kpr_check_surat_kematian = $this->input->post('kpr_check_surat_kematian');
			$kpr_check_surat_waris = $this->input->post('kpr_check_surat_waris');
			$kpr_check_npwp_developer = $this->input->post('kpr_check_npwp_developer');
			$kpr_check_ktp_developer = $this->input->post('kpr_check_ktp_developer');
			$kpr_check_akta_developer = $this->input->post('kpr_check_akta_developer');
			$kpr_check_siup = $this->input->post('kpr_check_siup');
			$kpr_check_surat_pencairan = $this->input->post('kpr_check_surat_pencairan');

			if ($kpr_check_npwp_pemohon==false) { 
				$kpr_check_npwp_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($status_menikah_kpr==1) {
				if ($kpr_check_surat_nikah_pemohon==false) { 
					$kpr_check_surat_nikah_pemohon='T'; 
					if($tipe_developer==0){
						$status_dokumen_lengkap=0;
					}else{
						$status_dokumen_lengkap=1;
					}
				}
			}
			if ($kpr_check_ktp_pemohon==false) { 
				$kpr_check_ktp_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_ktp_pasangan_pemohon==false) { 
				$kpr_check_ktp_pasangan_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_kartu_keluarga==false) { 
				$kpr_check_kartu_keluarga='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_surat_nikah_pemohon==false) { 
				$kpr_check_surat_nikah_pemohon='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_slip_gaji==false) { 
				$kpr_check_slip_gaji='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_buku_tabungan==false) { 
				$kpr_check_buku_tabungan='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_surat_perjanjian==false) { 
				$kpr_check_surat_perjanjian='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=0;
				}else{
					$status_dokumen_lengkap=1;
				}
			}
			if ($kpr_check_sertifikat_tanah==false) { 
				$kpr_check_sertifikat_tanah='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_imb==false) { 
				$kpr_check_surat_imb='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_pbb==false) { 
				$kpr_check_pbb='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_npwp_penjual==false) { 
				$kpr_check_npwp_penjual='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_ktp_pasangan==false) { 
				$kpr_check_ktp_pasangan='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_kk_penjual==false) { 
				$kpr_check_kk_penjual='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_nikah==false) { 
				$kpr_check_surat_nikah='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_cerai==false) { 
				$kpr_check_surat_cerai='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_penetapan==false) { 
				$kpr_check_surat_penetapan='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_kematian==false) { 
				$kpr_check_surat_kematian='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_surat_waris==false) { 
				$kpr_check_surat_waris='T'; 
				$status_dokumen_lengkap=0;
			}
			if ($kpr_check_npwp_developer==false) { 
				$kpr_check_npwp_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_ktp_developer==false) { 
				$kpr_check_ktp_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_akta_developer==false) { 
				$kpr_check_akta_developer='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_siup==false) { 
				$kpr_check_siup='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			if ($kpr_check_surat_pencairan==false) { 
				$kpr_check_surat_pencairan='T'; 
				if($tipe_developer==0){
					$status_dokumen_lengkap=1;
				}else{
					$status_dokumen_lengkap=0;
				}
			}
			/*
			| END CHECK DOKUMEN KPR
			| ADDENDUM BY UI
			| 24 JULI 2015
			*/
		}

		$data	= array(
			 'tipe_jaminan'	 			=> $tipe_jaminan
			,'nomor_jaminan'		 	=> $nomor_jaminan
			,'atas_nama'		 		=> $atas_nama
			,'atas_nama1'		 		=> $atas_nama2
			,'atas_nama2'		 		=> $atas_nama3
			,'jenis_surat'		 		=> $jenis_surat
			,'provinsi'		 			=> $provinsi
			,'kota'		 				=> $kota
			,'kecamatan'		 		=> $kecamatan
			,'kelurahan'		 		=> $kelurahan
			,'blok'		 				=> $blok
			// ,'no_imb'		 			=> $no_imb
			// ,'tanggal_imb'		 		=> $tanggal_imb
			,'tanggal_surat_jaminan'	=> $tanggal_surat_jaminan
			// ,'nop'		 				=> $nop
			,'nilai_jual'		 		=> $nilai_jual
			// ,'check_ktp'  				=> $check_ktp
			// ,'check_kk'  				=> $check_kk
			// ,'check_surat_nikah'  		=> $check_surat_nikah
			// ,'check_cover_buku_tabungan'=> $check_cover_buku_tabungan
			// ,'check_no_rekening'  		=> $check_no_rekening
			// ,'check_slip_gaji'  		=> $check_slip_gaji
			// ,'check_sk'  				=> $check_sk
			// ,'check_sertifikat_tanah'  	=> $check_sertifikat_tanah
			// ,'check_imb'  				=> $check_imb
			// ,'check_pbb'  				=> $check_pbb
			,'created_date'  			=> date("Y-m-d H:i:s")
			,'created_by'  				=> $this->session->userdata('user_id')
			,'luas_tanah'  				=> $luas_tanah
			,'alamat'  					=> $alamat
			,'product_code' 			=> $kode_produk
		);

		if ( $kode_produk == '53' || $kode_produk == '54' ) { // PRODUK KMG
			$data['check_ktp'] = $check_ktp;
			$data['check_kk'] = $check_kk;
			$data['check_surat_nikah'] = $check_surat_nikah;
			$data['check_cover_buku_tabungan'] = $check_cover_buku_tabungan;
			$data['check_no_rekening'] = $check_no_rekening;
			$data['check_slip_gaji'] = $check_slip_gaji;
			$data['check_sk'] = $check_sk;
			$data['check_sertifikat_tanah'] = $check_sertifikat_tanah;
			$data['check_imb'] = $check_imb;
			$data['check_pbb'] = $check_pbb;
		}

		if ( $kode_produk == '56' ) { // PRODUK KPR
			$data['kpr_check_npwp_pemohon'] = $kpr_check_npwp_pemohon;
			$data['kpr_check_ktp_pemohon'] = $kpr_check_ktp_pemohon;
			$data['kpr_check_kartu_keluarga'] = $kpr_check_kartu_keluarga;
			$data['kpr_check_slip_gaji'] = $kpr_check_slip_gaji;
			$data['kpr_check_buku_tabungan'] = $kpr_check_buku_tabungan;
			$data['kpr_check_surat_perjanjian'] = $kpr_check_surat_perjanjian;
			$data['kpr_check_sertifikat_tanah'] = $kpr_check_sertifikat_tanah;
			$data['kpr_check_surat_imb'] = $kpr_check_surat_imb;
			$data['kpr_check_pbb'] = $kpr_check_pbb;
			$data['kpr_check_npwp_penjual'] = $kpr_check_npwp_penjual;
			$data['kpr_check_ktp_pasangan'] = $kpr_check_ktp_pasangan;
			$data['kpr_check_kk_penjual'] = $kpr_check_kk_penjual;
			$data['kpr_check_surat_nikah'] = $kpr_check_surat_nikah;
			$data['kpr_check_surat_cerai'] = $kpr_check_surat_cerai;
			$data['kpr_check_surat_penetapan'] = $kpr_check_surat_penetapan;
			$data['kpr_check_surat_kematian'] = $kpr_check_surat_kematian;
			$data['kpr_check_surat_waris'] = $kpr_check_surat_waris;
			$data['kpr_check_npwp_developer'] = $kpr_check_npwp_developer;
			$data['kpr_check_ktp_developer'] = $kpr_check_ktp_developer;
			$data['kpr_check_akta_developer'] = $kpr_check_akta_developer;
			$data['kpr_check_siup'] = $kpr_check_siup;
			$data['kpr_check_surat_pencairan'] = $kpr_check_surat_pencairan;
			$data['kpr_check_ktp_pasangan_pemohon'] = $kpr_check_ktp_pasangan_pemohon;
			$data['kpr_check_surat_nikah_pemohon'] = $kpr_check_surat_nikah_pemohon;

			$data['tipe_developer'] = $tipe_developer;
			$data['nama_penjual_individu'] = $nama_penjual_individu;
			$data['nomer_ktp'] = $nomer_ktp;
			$data['nama_pasangan_developer'] = $nama_pasangan_developer;
			$data['nama_perusahaan'] = $nama_perusahaan;
		}

		$param = array('id_jaminan'=>$id_jaminan);

		$data_reg = array('status_dokumen_lengkap'=>$status_dokumen_lengkap);
		$param_reg = array('registration_no'=>$registration_no);

		$this->db->trans_begin();
		$this->model_nasabah->update_data_jaminan($data,$param);
		$this->model_nasabah->update_account_financing_reg($data_reg,$param_reg);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_jaminan_by_id()
	{
		$id_jaminan = $this->input->post('id_jaminan');
		$data = $this->model_nasabah->get_jaminan_by_id($id_jaminan);
		$data['tanggal_imb'] = date('d/m/Y',strtotime($data['tanggal_imb']));
		$data['tanggal_surat_jaminan'] = date('d/m/Y',strtotime($data['tanggal_surat_jaminan']));
		echo json_encode($data);
	}

	public function delete_jaminan()
	{
		$id_jaminan = $this->input->post('id_jaminan');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($id_jaminan) ; $i++ )
		{
			$param = array('id_jaminan'=>$id_jaminan[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_jaminan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	/*
	** End Data Jaminan
	*/

	/*
	** Begin SP4
	** 04-06-2015
	*/
	public function akad_kmg()
	{
		$data['container'] = 'nasabah/cetak_sp4';
		$this->load->view('core',$data);
	}

	public function cetak_sp4()
	{
		$data['container'] = 'nasabah/cetak_sp4';
		$this->load->view('core',$data);
	}

	public function account_financing_reg_no()
	{
		$keyword=$this->input->post('keyword');
		$data=$this->model_nasabah->account_financing_reg_no($keyword);
		echo json_encode($data);
	}

	public function get_cif_by_account_financing_reg_sp4()
	{
		$account_financing_reg = $this->input->post('account_financing_reg');
		$data = $this->model_nasabah->get_cif_by_account_registration_no_sp4($account_financing_reg);

		$data['status_pasangan'] = ($data['jenis_kelamin']=="P") ? "ISTRI" : "SUAMI" ;
		// $data['total_margin'] = 0;

		echo json_encode($data);
	}

	public function get_cif_by_account_financing_reg()
	{
		$account_financing_reg = $this->input->post('account_financing_reg');
		$data = $this->model_nasabah->get_cif_by_account_registration_no($account_financing_reg);

		echo json_encode($data);
	}

	public function update_data_cif_for_sp4()
	{
		$cif_no = $this->input->post('cif_no');
		$nama_pasangan = $this->input->post('nama_pasangan');

		$data = array('nama_pasangan'=>$nama_pasangan);

		$param = array('cif_no'=>$cif_no);

		$this->db->trans_begin();
		$this->model_nasabah->update_cif($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/*
	** End SP4
	*/

	public function get_status_dokumen_lengkap()
	{
		$product_code = $this->input->post('product_code');
		$status_dokumen_lengkap = $this->model_nasabah->get_status_dokumen_lengkap_by_product_code($product_code);
		$data = array('status_dokumen_lengkap'=>$status_dokumen_lengkap);
		echo json_encode($data);
	}

	/*
	** Margin Efektif
	*/
	public function get_margin_efektif()
	{
		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$jangkawaktu = $this->input->post('jangkawaktu');
		$margin_tahun = $this->input->post('margin_tahun');
		$margin_bulan = ($margin_tahun/12);

		$angs_pokok  = 0;
		$sisa_pokok  = $pokok;
		$angs_margin = 0;

		$Tangs_pokok = 0;
		$Tsisa_pokok = 0;
		$Tangs_margin = 0;
		$Tangs = 0;

		for ($i=1; $i<=$jangkawaktu; $i++) 
		{			
			$angs_margin = $margin_bulan*$sisa_pokok/100;
			$angs_pokok  = $pokok/$jangkawaktu;
			$total_angsuran  =($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			$Tangs_margin += $margin_bulan*$sisa_pokok/100;
			$Tangs_pokok += $pokok/$jangkawaktu;
			$Tangs += ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			
			$sisa_pokok  = $sisa_pokok-($pokok/$jangkawaktu);
		}

		echo $Tangs_margin;

	}

	function get_total_angsuran_anuitas()
	{
		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$product_code = $this->input->post('product_code');
		$jangkawaktu = $this->input->post('jangkawaktu');
		if ($jangkawaktu==false) {
			$jangkawaktu = 0;
		}
		$ratemargin = $this->input->post('margin_tahun'); //dalam persen
		$ratemarginperbulan = $ratemargin/100/12;
		$totalangs = $pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu)))));
		$totalmargin = 0;
		$saldopokok = $pokok;
		for ( $i = 1 ; $i <= $jangkawaktu ; $i++ ) {
			$angsmargin = $saldopokok*$ratemarginperbulan;
			$angspokok = $totalangs-$angsmargin;
			$saldopokok = $saldopokok-$angspokok;
			$totalmargin+=$angsmargin;
		}

		$data['total_margin'] = $totalmargin;
		$data['total_angsuran'] = ($product_code=='56') ? $totalangs : $totalangs;
		echo json_encode($data);
	}

	public function generate_margin_anuitas()
	{
		$angsuranke1 = $this->input->post('angsuranke1');
		$product_code = $this->input->post('product_code');
		$awal_angsur = $this->datepicker_convert(true,$angsuranke1,'/');

		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$jumlah_margin = $this->convert_numeric($this->input->post('jumlah_margin'));
		$jangkawaktu = $this->input->post('jangkawaktu');
		$ratemargin = $this->input->post('margin_tahun'); //dalam persen
		$ratemarginperbulan = $ratemargin/100/12;
		$totalangs1 = $pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu)))));
		$totalangs2 = $pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu)))));
		$totalangs = ($product_code=='56') ? $totalangs2 : $totalangs1;

		$saldopokok = $pokok;
		$html = '
		<table border="1">
			<thead>
				<tr>
					<td style="text-align:center;font-weight:bold;padding:5px;">No</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Tanggal Angsuran</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Margin</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Pokok</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Total Angsuran</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Sisa Hutang</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align:center;padding:3px;"></td>
					<td style="text-align:center;padding:3px;"></td>
					<td style="text-align:right;padding:3px;"></td>
					<td style="text-align:right;padding:3px;"></td>
					<td style="text-align:right;padding:3px;">'.number_format($totalangs,0,',','.').'</td>
					<td style="text-align:right;padding:3px;">'.number_format($saldopokok,0,',','.').'</td>
				</tr>
		';
		$n=0;
		$totalmargin = 0;
		$totalpokok = 0;
		$Ttotalangs = 0;
		for ( $i = 1 ; $i <= $jangkawaktu ; $i++ ) {
			$angsmargin = round($saldopokok*$ratemarginperbulan);
			$angspokok = $totalangs-$angsmargin;
			$saldopokok = $saldopokok-$angspokok;
			$tgl_angsur = date("d-m-Y",strtotime($awal_angsur." + ".$n." month"));
			$itgl_angsur = date("Y-m-d",strtotime($awal_angsur." + ".$n." month"));
			$totalmargin += $angsmargin;
			$totalpokok += $angspokok;
			$Ttotalangs += $angsmargin+$angspokok;

			if($i==$jangkawaktu){
				// echo $totalmargin.'|'.$jumlah_margin;die();
				$selisih_margin = 0;
				$selisih_pokok = 0;
				if($totalmargin!=$jumlah_margin){
					$selisih_margin = $jumlah_margin-$totalmargin;
					$angsmargin+=$selisih_margin;
					$totalmargin += ($selisih_margin);
				}
				if($totalpokok!=$pokok){
					$selisih_pokok = $pokok-$totalpokok;
					$angspokok+=$selisih_pokok;
					$totalpokok+=($selisih_pokok);
				}
				if($selisih_margin!=0 || $selisih_pokok!=0){
					$totalangs = ($angsmargin+$angspokok);
				}
				$Ttotalangs += ($selisih_margin+$selisih_pokok);
				$saldopokok = $saldopokok-$selisih_pokok;
			}

			$html .= '
					<tr>
						<td style="text-align:center;padding:3px;">'.$i.'</td>
						<td style="text-align:center;padding:3px;"><input type="hidden" name="tgl_angsur[]" value="'.date('d/m/Y',strtotime($itgl_angsur)).'">'.$tgl_angsur.'</td>
						<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_margin[]" value="'.number_format($angsmargin,0,',','.').'">'.number_format($angsmargin,0,',','.').'</td>
						<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_pokok[]" value="'.number_format($angspokok,0,',','.').'">'.number_format($angspokok,0,',','.').'</td>
						<td style="text-align:right;padding:3px;">'.number_format($totalangs,0,',','.').'</td>
						<td style="text-align:right;padding:3px;">'.number_format($saldopokok,0,',','.').'</td>
					</tr>
			';
			$n++;
		}

		$html .= '<tr style="display:nones">';
		$html .= '<td style="text-align:center;padding:3px;"></td>'; 
		$html .= '<td style="text-align:center;padding:3px;">TOTAL</td>'; 
		$html .= '<td style="text-align:right;padding:3px;font-weight:bold;">'.number_format($totalmargin,0,',','.').'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;font-weight:bold;">'.number_format($totalpokok,0,',','.').'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;font-weight:bold;">'.number_format($Ttotalangs,0,',','.').'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;"></td>'; 
		$html .='</tr>';

		$html .= '
			</tbody>
		</table>
		';

		echo $html;
	}

	public function generate_margin_efektif()
	{
		$pokok = $this->convert_numeric($this->input->post('pokok'));
		$amount = $pokok;
		$jangkawaktu = $this->input->post('jangkawaktu');
		$margin_tahun = $this->input->post('margin_tahun');
		$margin_bulan = ($margin_tahun/12);
		$angsuranke1 = $this->input->post('angsuranke1');

		// $awal_angsur = '2015-06-25';
		$awal_angsur = $this->datepicker_convert(true,$angsuranke1,'/');
		
		$html = '<table border=1>
				<tr>
					<td style="text-align:center;font-weight:bold;padding:5px;">No</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Tanggal Angsuran</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Margin</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Pokok</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Total Angsuran</td>
					<td style="text-align:center;font-weight:bold;padding:5px;">Sisa Hutang</td>
				<tr>';
		$angs_pokok  = 0;
		$sisa_pokok  = $pokok;
		$angs_margin = 0;

		$html .= '<tr>
					<td style="text-align:center;padding:3px;">0</td>
					<td style="text-align:center;padding:3px;">-</td>
					<td style="text-align:right;padding:3px;">'.$angs_margin.'</td>
					<td style="text-align:right;padding:3px;">'.$angs_pokok.'</td>
					<td style="text-align:right;padding:3px;">'.number_format($angs_margin+$angs_pokok).'</td>
					<td style="text-align:right;padding:3px;">'.number_format($sisa_pokok).'</td>
				<tr>';

		$Tangs_pokok = 0;
		$Tsisa_pokok = 0;
		$Tangs_margin = 0;
		$Tangs = 0;
		$n=0;
		for ($i=1; $i<=$jangkawaktu; $i++) { 

			
			$angs_margin = round($margin_bulan*$sisa_pokok/100);
			$angs_pokok  = round($pokok/$jangkawaktu);
			$total_angsuran  = round(($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu));
			$Tangs_margin += $margin_bulan*$sisa_pokok/100;
			$Tangs_pokok += $pokok/$jangkawaktu;
			$Tangs += ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			
			$sisa_pokok  = $sisa_pokok-($pokok/$jangkawaktu);

			$tgl_angsur = date("d-m-Y",strtotime($awal_angsur." + ".$n." month"));
			$itgl_angsur = date("Y-m-d",strtotime($awal_angsur." + ".$n." month"));
			$n++;

			if($i==$jangkawaktu){
				if(($jangkawaktu*$angs_pokok)!=$amount){
					$angs_pokok = $angs_pokok+($amount-($jangkawaktu*$angs_pokok)); 
					$total_angsuran = $angs_pokok+$angs_margin; 
				}
			}

			$html .= '<tr>';
			$html .= '<td style="text-align:center;padding:3px;">'.$i.'</td>'; 
			$html .= '<td style="text-align:center;padding:3px;"><input type="hidden" name="tgl_angsur[]" value="'.date('d/m/Y',strtotime($itgl_angsur)).'">'.$tgl_angsur.'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_margin[]" value="'.number_format($angs_margin,0,',','.').'">'.number_format($angs_margin).'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_pokok[]" value="'.number_format($angs_pokok,0,',','.').'">'.number_format($angs_pokok).'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;">'.number_format($total_angsuran).'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;">'.number_format($sisa_pokok).'</td>'; 
			$html .='</tr>';
			

		}
		$html .= '<tr style="display:none">';
		$html .= '<td style="text-align:center;padding:3px;"></td>'; 
		$html .= '<td style="text-align:center;padding:3px;">TOTAL</td>'; 
		$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs_margin).'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs_pokok).'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs).'</td>'; 
		$html .= '<td style="text-align:right;padding:3px;"></td>'; 
		$html .='</tr>';
		$html .= '</table>';

		echo $html;
		// $res = array('html'=>$htm);
		// echo json_encode($res);
	}

	public function generate_angsuran_nonreguler()
	{
		$account_financing_id = $this->input->post('account_financing_id');

		$datas = $this->model_nasabah->get_schedulle_by_account_financing_id($account_financing_id);
		if(count($datas)>0){
			$pokok = $datas[0]['pokok'];
			
			$html = '<table border=1>
					<tr>
						<td style="text-align:center;font-weight:bold;padding:5px;">No</td>
						<td style="text-align:center;font-weight:bold;padding:5px;">Tanggal Angsuran</td>
						<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Margin</td>
						<td style="text-align:center;font-weight:bold;padding:5px;">Angsuran Pokok</td>
						<td style="text-align:center;font-weight:bold;padding:5px;">Total Angsuran</td>
						<td style="text-align:center;font-weight:bold;padding:5px;">Sisa Hutang</td>
					<tr>';
			$angs_pokok  = 0;
			$sisa_pokok  = $pokok;
			$angs_margin = 0;

			$html .= '<tr>
						<td style="text-align:center;padding:3px;">0</td>
						<td style="text-align:center;padding:3px;">-</td>
						<td style="text-align:right;padding:3px;"></td>
						<td style="text-align:right;padding:3px;"></td>
						<td style="text-align:right;padding:3px;">0</td>
						<td style="text-align:right;padding:3px;">'.number_format($sisa_pokok).'</td>
					<tr>';

			$Tangs_pokok = 0;
			$Tsisa_pokok = 0;
			$Tangs_margin = 0;
			$n=0;

			for ($i=1; $i<=count($datas); $i++) { 

				$angs_margin = $datas[($i-1)]['angsuran_margin'];
				$angs_pokok  = $datas[($i-1)]['angsuran_pokok'];
				$total_angsuran = $angs_margin+$angs_pokok;

				// $sisa_pokok  = $sisa_pokok-$datas[($i-1)]['angsuran_pokok'];
				
				$sisa_pokok  = $sisa_pokok-$datas[($i-1)]['angsuran_pokok'];
				// $sisa_pokok  = $sisa_pokok-($pokok/$jangkawaktu);

				$Tangs_margin += $angs_margin;
				$Tangs_pokok += $angs_pokok;
				

				$html .= '<tr>';
				$html .= '<td style="text-align:center;padding:3px;">'.$i.'</td>'; 
				$html .= '<td style="text-align:center;padding:3px;"><input type="hidden" name="tgl_angsur[]" value="'.date('d/m/Y',strtotime($datas[($i-1)]['tangga_jtempo'])).'">'.date('d-m-Y',strtotime($datas[($i-1)]['tangga_jtempo'])).'</td>'; 
				$html .= '<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_margin[]" value="'.number_format($angs_margin,0,',','.').'">'.number_format($angs_margin,0,',','.').'</td>'; 
				$html .= '<td style="text-align:right;padding:3px;"><input type="hidden" name="angs_pokok[]" value="'.number_format($angs_pokok,0,',','.').'">'.number_format($angs_pokok,0,',','.').'</td>'; 
				$html .= '<td style="text-align:right;padding:3px;">'.number_format($total_angsuran,0,',','.').'</td>'; 
				$html .= '<td style="text-align:right;padding:3px;">'.number_format($sisa_pokok,0,',','.').'</td>'; 
				$html .='</tr>';
				

			}
			$Tangs = $Tangs_margin+$Tangs_pokok;
			$html .= '<tr style="display:nones">';
			$html .= '<td style="text-align:center;padding:3px;"></td>'; 
			$html .= '<td style="text-align:center;padding:3px;">TOTAL</td>'; 
			$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs_margin,0,',','.').'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs_pokok,0,',','.').'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;">'.number_format($Tangs,0,',','.').'</td>'; 
			$html .= '<td style="text-align:right;padding:3px;"></td>'; 
			$html .='</tr>';
			$html .= '</table>';
		}else{
			$html = 'Harap ubah tanggal akad untuk mengenerate angsuran';
		}

		echo $html;
		// $res = array('html'=>$htm);
		// echo json_encode($res);
	}

	public function get_product_financing_by_band($banmod=false)
	{
		$band = $this->input->post('band');
		$default_parent = !empty($this->input->post('default_parent')) ? false : true;
		$datas = $this->model_transaction->get_product_financing_by_band($band,$banmod,$default_parent);
		echo json_encode($datas);
	}
	/*
	** ENd Margin Efektif
	*/


	/**
	* BEGIN PENGAJUAN PEMBIAYAAN BANMOD
	*/
	function pengajuan_banmod()
	{
		$data['date'] 		= date('d/m/Y',strtotime($this->model_transaction->date_current()));
		$data['kopegtel'] 	= $this->model_transaction->get_kopegtel();
		$data['product'] 	= $this->model_transaction->get_product_financing_by_banmod();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan_by_banmod();
		$data['container'] 	= 'transaction/pengajuan_pembiayaan_koptel_banmod';
		$this->load->view('core',$data);
	}
	function add_pengajuan_banmod()
	{
		if (isset($_POST['save'])) {

		$v_kopegtel = $this->input->post('kopegtel');
		$v_kopegtel_name = $this->input->post('kopegtel_name');
	    $v_wilayah = $this->input->post('wilayah');
	    $v_alamat = $this->input->post('alamat');
	    $v_ketua_pengurus = $this->input->post('ketua_pengurus');
	    $v_jabatan = $this->input->post('jabatan');
	    $v_nik = $this->input->post('nik');
	    $v_deskripsi_ketua_pengurus = $this->input->post('deskripsi_ketua_pengurus');
	    $v_email = $this->input->post('email');
	    $v_no_telpon = $this->input->post('no_telpon');
	    $v_status_chaneling = $this->input->post('status_chaneling');
	    $v_nama_bank = $this->input->post('nama_bank');
	    $v_bank_cabang = $this->input->post('bank_cabang');
	    $v_nomor_rekening = $this->input->post('nomor_rekening');
	    $v_atasnama_rekening = $this->input->post('atasnama_rekening');
	    $v_product_code = $this->input->post('product_code');
	    $v_peruntukan = $this->input->post('peruntukan');
	    $v_keterangan_peruntukan = $this->input->post('keterangan_peruntukan');
	    $v_amount = $this->input->post('amount');
	    $v_jangka_waktu = $this->input->post('jangka_waktu');
	    $v_tanggal_pengajuan = $this->datepicker_convert(true,$this->input->post('tanggal_pengajuan'),'/');
	    $v_rencana_droping = $this->datepicker_convert(true,$this->input->post('rencana_droping'),'/');
	    
	    /**
	    * cek cif if exist
	    * if not exist then insert a new cif by kopegtel
	    */
	    $cek_cif_if_exist = $this->model_transaction->cek_cif_if_exist_by_kopegtel($v_kopegtel);
    	$data_cif = array(
    			 'nama' => $v_kopegtel_name
				,'panggilan' => $v_kopegtel_name
				,'tmp_lahir' => '-'
				,'tgl_lahir' => date('Y-m-d')
				,'alamat' => $v_alamat
				,'no_ktp' => '-'
				,'telpon_rumah' => $v_no_telpon
				,'cif_type' => 1
				,'koresponden_alamat' => $v_alamat
				,'status' => 1
				,'nama_pasangan' => '-'
				,'pekerjaan_pasangan' => '-'
				,'nama_bank' => $v_nama_bank
				,'no_rekening' => $v_nomor_rekening
				,'atasnama_rekening' => $v_atasnama_rekening
				,'jenis_kelamin' => 'P'
				,'bank_cabang' => $v_bank_cabang
    		);

	    if ($cek_cif_if_exist==0) {
			$data_cif['cif_no'] = $v_kopegtel;
			$data_cif['created_by'] = $this->session->userdata('user_id');
			$data_cif['branch_code'] = $this->session->userdata('branch_code');
			$data_cif['cif_flag'] = 1;
	    }
		$param_cif = array('cif_no'=>$v_kopegtel);

	    /* collect data for new pengajuan banmod */
	    $data_pengajuan = array(
				 'cif_no'				=>$v_kopegtel
				,'amount'				=>$this->convert_numeric($v_amount)
				,'peruntukan'			=>$v_peruntukan
				,'status'				=>0
				,'tanggal_pengajuan'	=>$v_tanggal_pengajuan
				,'rencana_droping'		=>$v_rencana_droping
				,'product_code'			=>$v_product_code
				,'created_by'			=>$this->session->userdata('user_id')
				,'created_date'			=>date('Y-m-d H:i:s')
				,'jangka_waktu'			=>$v_jangka_waktu
				,'nama_bank'			=>$v_nama_bank
				,'no_rekening'			=>$v_nomor_rekening
				,'atasnama_rekening'	=>$v_atasnama_rekening
				,'bank_cabang'			=>$v_bank_cabang
				,'description'			=>$v_keterangan_peruntukan
				,'status_asuransi'		=>1
				,'status_dokumen_lengkap'=>1
			);

	    /* collect data for update data kopegtel */
	    $data_kopegtel = array(
				 'wilayah' => $v_wilayah
				,'alamat' => $v_alamat
				,'ketua_pengurus' => $v_ketua_pengurus
				,'jabatan' => $v_jabatan
				,'nik' => $v_nik
				,'deskripsi_ketua_pengurus' => $v_deskripsi_ketua_pengurus
				,'email' => $v_email
				,'no_telpon' => $v_no_telpon
				,'status_chaneling' => $v_status_chaneling
				,'nomor_rekening' => $v_nomor_rekening
				,'nama_bank' => $v_nama_bank
				,'bank_cabang' => $v_bank_cabang
				,'atasnama_rekening' => $v_atasnama_rekening
	    	);
	   	$param_kopegtel = array('kopegtel_code' => $v_kopegtel);

		$this->db->trans_begin();
		if ($cek_cif_if_exist==0) {
			$this->model_nasabah->insert_cif($data_cif);
		} else {
			$this->model_nasabah->update_cif($data_cif,$param_cif);
		}
		$this->model_nasabah->add_pengajuan_pembiayaan($data_pengajuan);
		$this->db->update('mfi_kopegtel',$data_kopegtel,$param_kopegtel);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		} else {
			$return = array('success'=>false);
		} //end isset submit

		echo json_encode($return);
	}
	function edit_pengajuan_banmod()
	{
		if (isset($_POST['update'])) {

		$v_account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$v_kopegtel = $this->input->post('kopegtel');
		$v_kopegtel_name = $this->input->post('kopegtel_name');
	    $v_wilayah = $this->input->post('wilayah');
	    $v_alamat = $this->input->post('alamat');
	    $v_ketua_pengurus = $this->input->post('ketua_pengurus');
	    $v_jabatan = $this->input->post('jabatan');
	    $v_nik = $this->input->post('nik');
	    $v_deskripsi_ketua_pengurus = $this->input->post('deskripsi_ketua_pengurus');
	    $v_email = $this->input->post('email');
	    $v_no_telpon = $this->input->post('no_telpon');
	    $v_status_chaneling = $this->input->post('status_chaneling');
	    $v_nama_bank = $this->input->post('nama_bank');
	    $v_bank_cabang = $this->input->post('bank_cabang');
	    $v_nomor_rekening = $this->input->post('nomor_rekening');
	    $v_atasnama_rekening = $this->input->post('atasnama_rekening');
	    $v_product_code = $this->input->post('product_code');
	    $v_peruntukan = $this->input->post('peruntukan');
	    $v_keterangan_peruntukan = $this->input->post('keterangan_peruntukan');
	    $v_amount = $this->input->post('amount');
	    $v_jangka_waktu = $this->input->post('jangka_waktu');
	    $v_tanggal_pengajuan = $this->datepicker_convert(true,$this->input->post('tanggal_pengajuan'),'/');
	    $v_rencana_droping = $this->datepicker_convert(true,$this->input->post('rencana_droping'),'/');
	    
	    /**
	    * cek cif if exist
	    * if not exist then insert a new cif by kopegtel
	    */
	    $cek_cif_if_exist = $this->model_transaction->cek_cif_if_exist_by_kopegtel($v_kopegtel);
    	$data_cif = array(
    			 'nama' => $v_kopegtel_name
				,'panggilan' => $v_kopegtel_name
				,'tmp_lahir' => '-'
				,'tgl_lahir' => date('Y-m-d')
				,'alamat' => $v_alamat
				,'no_ktp' => '-'
				,'telpon_rumah' => $v_no_telpon
				,'cif_type' => 1
				,'koresponden_alamat' => $v_alamat
				,'status' => 1
				,'nama_pasangan' => '-'
				,'pekerjaan_pasangan' => '-'
				,'nama_bank' => $v_nama_bank
				,'no_rekening' => $v_nomor_rekening
				,'atasnama_rekening' => $v_atasnama_rekening
				,'jenis_kelamin' => 'P'
				,'bank_cabang' => $v_bank_cabang
    		);

	    if ($cek_cif_if_exist==0) {
			$data_cif['cif_no'] = $v_kopegtel;
			$data_cif['created_by'] = $this->session->userdata('user_id');
			$data_cif['branch_code'] = $this->session->userdata('branch_code');
			$data_cif['cif_flag'] = 1;
	    }
		$param_cif = array('cif_no'=>$v_kopegtel);

	    /* collect data for update pengajuan banmod */
	    $data_pengajuan = array(
				 'cif_no'				=>$v_kopegtel
				,'amount'				=>$this->convert_numeric($v_amount)
				,'peruntukan'			=>$v_peruntukan
				,'status'				=>0
				,'tanggal_pengajuan'	=>$v_tanggal_pengajuan
				,'rencana_droping'		=>$v_rencana_droping
				,'product_code'			=>$v_product_code
				,'created_by'			=>$this->session->userdata('user_id')
				,'created_date'			=>date('Y-m-d H:i:s')
				,'jangka_waktu'			=>$v_jangka_waktu
				,'nama_bank'			=>$v_nama_bank
				,'no_rekening'			=>$v_nomor_rekening
				,'atasnama_rekening'	=>$v_atasnama_rekening
				,'bank_cabang'			=>$v_bank_cabang
				,'description'			=>$v_keterangan_peruntukan
			);
	    $param_pengajuan = array('account_financing_reg_id'=>$v_account_financing_reg_id);

	    /* collect data for update data kopegtel */
	    $data_kopegtel = array(
				 'wilayah' => $v_wilayah
				,'alamat' => $v_alamat
				,'ketua_pengurus' => $v_ketua_pengurus
				,'jabatan' => $v_jabatan
				,'nik' => $v_nik
				,'deskripsi_ketua_pengurus' => $v_deskripsi_ketua_pengurus
				,'email' => $v_email
				,'no_telpon' => $v_no_telpon
				,'status_chaneling' => $v_status_chaneling
				,'nomor_rekening' => $v_nomor_rekening
				,'nama_bank' => $v_nama_bank
				,'bank_cabang' => $v_bank_cabang
				,'atasnama_rekening' => $v_atasnama_rekening
	    	);
	   	$param_kopegtel = array('kopegtel_code' => $v_kopegtel);

		$this->db->trans_begin();
		if ($cek_cif_if_exist==0) {
			$this->model_nasabah->insert_cif($data_cif);
		} else {
			$this->model_nasabah->update_cif($data_cif,$param_cif);
		}
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_pengajuan,$param_pengajuan);
		$this->db->update('mfi_kopegtel',$data_kopegtel,$param_kopegtel);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		} else {
			$return = array('success'=>false);
		} //end isset submit

		echo json_encode($return);
	}

	public function datatable_pengajuan_banmod()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','a.registration_no','c.nama','a.tanggal_pengajuan','a.amount','b.display_text','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_pengajuan_banmod($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_banmod($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_banmod(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$btn_upload = '<a href="#dialog_upload" data-toggle="modal" 
							id="link-upload"
							account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" 
							kopegtel_code="'.$aRow['kopegtel_code'].'" 
							registration_no="'.$aRow['registration_no'].'"
							f_proposal="'.$aRow['f_proposal'].'"
							f_kontrak="'.$aRow['f_kontrak'].'"
							f_keuangan="'.$aRow['f_keuangan'].'"
							f_rek_koran="'.$aRow['f_rek_koran'].'"
							f_aki="'.$aRow['f_aki'].'"
							f_proyeksi="'.$aRow['f_proyeksi'].'"
							f_jaminan="'.$aRow['f_jaminan'].'"
							class="btn mini green"><i class="icon-upload"></i> Upload</a>';
			$btn_edit = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';

			$status_dokumen_upload = '-';
			if ($aRow['status_dokumen_upload']==0) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini red-stripe">New</a>';
			} else if ($aRow['status_dokumen_upload']==1) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini green-stripe">Completed</a>';
			} else if ($aRow['status_dokumen_upload']==2) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini blue-stripe">Uncompleted</a>';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['kopegtel_name'];
			$row[] = '<center>'.$this->format_date_detail($aRow['tanggal_pengajuan'],'id',false,'-').'</center>';
			$row[] = '<center>'.date("d-m-Y H:i:s",strtotime($aRow['created_date'])).'</center>';
			$row[] = '<div align="right" style="white-space:nowrap;">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = '<div style="white-space:nowrap;text-align:center;">'.$status_dokumen_upload.'</div>';
			$row[] = '<div style="white-space:nowrap">'.$btn_upload.' '.$btn_edit.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function get_pengajuan_banmod_by_account_financing_reg_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_pengajuan_banmod_by_account_financing_reg_id($account_financing_reg_id);

		echo json_encode($data);
	}

	function upload_pengajuan_banmod()
	{
		$this->load->library('upload');
		$bValid=true;
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$v_kopegtel_code = $this->input->post('kopegtel_code');
		$oldf = $this->model_nasabah->get_file_by_financing_reg($account_financing_reg_id);

		// BEGIN userfile1
		if (isset($_FILES['userfile1'])) {
			$config['upload_path'] = './assets/data_pengajuan_banmod/';
			$config['file_name'] = $v_kopegtel_code.'-(proposal)';
			$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
			$config['max_size'] = '100000';
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('userfile1') ) {
				$bValid=false;
				$error1 = $this->upload->display_errors('','');
			} else {
				$data1 = $this->upload->data();
				if ($oldf['f_proposal']!="") {
					@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_proposal']);
				}
			}
		} // END

		// BEGIN userfile2
		if (isset($_FILES['userfile2'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(kontrak)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile2') ) {
					$bValid=false;
					$error2 = $this->upload->display_errors('','');
				} else {
					$data2 = $this->upload->data();
					if ($oldf['f_kontrak']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_kontrak']);
					}
				}
			}
		} // END

		// BEGIN userfile3
		if (isset($_FILES['userfile3'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(keuangan)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile3') ) {
					$bValid=false;
					$error3 = $this->upload->display_errors('','');
				} else {
					$data3 = $this->upload->data();
					if ($oldf['f_keuangan']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_keuangan']);
					}
				}
			}
		} // END

		// BEGIN userfile4
		if (isset($_FILES['userfile4'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(rek_koran)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile4') ) {
					$bValid=false;
					$error4 = $this->upload->display_errors('','');
				} else {
					$data4 = $this->upload->data();
					if ($oldf['f_rek_koran']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_rek_koran']);
					}
				}
			}
		} // END

		// BEGIN userfile5
		if (isset($_FILES['userfile5'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(AKI)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile5') ) {
					$bValid=false;
					$error5 = $this->upload->display_errors('','');
				} else {
					$data5 = $this->upload->data();
					if ($oldf['f_aki']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_aki']);
					}
				}
			}
		} // END

		// BEGIN userfile6
		if (isset($_FILES['userfile6'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(proyeksi)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile6') ) {
					$bValid=false;
					$error6 = $this->upload->display_errors('','');
				} else {
					$data6 = $this->upload->data();
					if ($oldf['f_proyeksi']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_proyeksi']);
					}
				}
			}
		} // END

		// BEGIN userfile7
		if (isset($_FILES['userfile7'])) {
			if ($bValid==true) {
				$config['upload_path'] = './assets/data_pengajuan_banmod/';
				$config['file_name'] = $v_kopegtel_code.'-(jaminan)';
				$config['allowed_types'] = 'doc|docx|pdf|xls|xlsx|jpeg|jpg|png|gif';
				$config['max_size'] = '100000';
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile7') ) {
					$bValid=false;
					$error7 = $this->upload->display_errors('','');
				} else {
					$data7 = $this->upload->data();
					if ($oldf['f_jaminan']!="") {
						@unlink('./assets/data_pengajuan_banmod/'.$oldf['f_jaminan']);
					}
				}
			}
		} // END

		// BEGIN if no selected file
		if (isset($_FILES['userfile1'])==false && isset($_FILES['userfile2'])==false && isset($_FILES['userfile3'])==false && isset($_FILES['userfile4'])==false && isset($_FILES['userfile5'])==false && isset($_FILES['userfile6'])==false && isset($_FILES['userfile7'])==false ) {
			
			$return = array('success'=>false,'message'=>'No file Selected!');

		} else {

			// BEGIN response for bValid
			$message = '';
			if ($bValid==false) {
				// because this have some error, then deleting uploaded file
				if (isset($data1)==true) @unlink('./assets/data_pengajuan_banmod/'.$data1['file_name']);
				if (isset($data2)==true) @unlink('./assets/data_pengajuan_banmod/'.$data2['file_name']);
				if (isset($data3)==true) @unlink('./assets/data_pengajuan_banmod/'.$data3['file_name']);
				if (isset($data4)==true) @unlink('./assets/data_pengajuan_banmod/'.$data4['file_name']);
				if (isset($data5)==true) @unlink('./assets/data_pengajuan_banmod/'.$data5['file_name']);
				if (isset($data6)==true) @unlink('./assets/data_pengajuan_banmod/'.$data6['file_name']);
				if (isset($data7)==true) @unlink('./assets/data_pengajuan_banmod/'.$data7['file_name']);

				// set message to response
				if (isset($error1)==true) $message  = 'Error Uploading File 1 : ' . $error1 .'<br>';
				if (isset($error2)==true) $message .= 'Error Uploading File 2 : ' . $error2 .'<br>';
				if (isset($error3)==true) $message .= 'Error Uploading File 3 : ' . $error3 .'<br>';
				if (isset($error4)==true) $message .= 'Error Uploading File 4 : ' . $error4 .'<br>';
				if (isset($error5)==true) $message .= 'Error Uploading File 5 : ' . $error5 .'<br>';
				if (isset($error6)==true) $message .= 'Error Uploading File 6 : ' . $error6 .'<br>';
				if (isset($error7)==true) $message .= 'Error Uploading File 7 : ' . $error7 .'<br>';
				
				// array for response
				$return = array('success'=>false,'message'=>$message);
			} else {
				// set filename to null if user not select the file
				if (isset($data1)) {
					$filename1 = $data1['file_name'];
				} else {
					$filename1 = $oldf['f_proposal'];
				}
				if (isset($data2)) {
					$filename2 = $data2['file_name'];
				} else {
					$filename2 = $oldf['f_kontrak'];
				}
				if (isset($data3)) {
					$filename3 = $data3['file_name'];
				} else {
					$filename3 = $oldf['f_keuangan'];
				}
				if (isset($data4)) {
					$filename4 = $data4['file_name'];
				} else {
					$filename4 = $oldf['f_rek_koran'];
				}
				if (isset($data5)) {
					$filename5 = $data5['file_name'];
				} else {
					$filename5 = $oldf['f_aki'];
				}
				if (isset($data6)) {
					$filename6 = $data6['file_name'];
				} else {
					$filename6 = $oldf['f_proyeksi'];
				}
				if (isset($data7)) {
					$filename7 = $data7['file_name'];
				} else {
					$filename7 = $oldf['f_jaminan'];
				}
				// collect the data for update to account financing reg
				$data['f_proposal'] = $filename1;
				$data['f_kontrak'] = $filename2;
				$data['f_keuangan'] = $filename3;
				$data['f_rek_koran'] = $filename4;
				$data['f_aki'] = $filename6;
				$data['f_proyeksi'] = $filename5;
				$data['f_jaminan'] = $filename7;
				$param = array('account_financing_reg_id'=>$account_financing_reg_id);
				// begin transaction
				$this->db->trans_begin();
				$this->db->update('mfi_account_financing_reg',$data,$param);
				if ($this->db->trans_status()===true) {
					$this->db->trans_commit();
					$this->status_upload_document_is_completed($account_financing_reg_id);
					$message = 'Upload Success!';
					$return = array(
								'success'=>true
								,'message'=>$message
								,'filename1'=>$filename1
								,'filename2'=>$filename2
								,'filename3'=>$filename3
								,'filename4'=>$filename4
								,'filename5'=>$filename5
								,'filename6'=>$filename6
								,'filename7'=>$filename7
							);
				} else {
					$this->db->trans_rollback();
					$message = '';
					$return = array('success'=>false,'message'=>$message);
				} //end
			} // END

		} // END

		echo json_encode($return);
	}

	private function status_upload_document_is_completed($account_financing_reg_id)
	{
		$f = $this->model_nasabah->get_file_by_financing_reg($account_financing_reg_id);
		$f_proposal = $f['f_proposal'];
		$f_kontrak = $f['f_kontrak'];
		$f_keuangan = $f['f_keuangan'];
		$f_rek_koran = $f['f_rek_koran'];
		$f_aki = $f['f_aki'];
		$f_proyeksi = $f['f_proyeksi'];
		$f_jaminan = $f['f_jaminan'];

		$bValid=true;
		if ($f_proposal=="") $bValid=false;
		if ($f_kontrak=="") $bValid=false;
		if ($f_keuangan=="") $bValid=false;
		if ($f_rek_koran=="") $bValid=false;
		if ($f_aki=="") $bValid=false;
		if ($f_proyeksi=="") $bValid=false;
		if ($f_jaminan=="") $bValid=false;

		if ($bValid==false) {
			$status=2;
		} else {
			if ($f_proposal=="" && $f_kontrak=="" && $f_keuangan=="" && $f_rek_koran=="" && $f_aki=="" && $f_proyeksi=="" && $f_jaminan=="") {
				$status=0;
			} else {
				$status=1;
			}
		}

		$data = array('status_dokumen_upload'=>$status);
		$param = array('account_financing_reg_id'=>$account_financing_reg_id);

		$this->db->trans_begin();
		$this->db->update('mfi_account_financing_reg',$data,$param);
		if ($this->db->trans_status()===TRUE) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function delete_pengajuan_pembiayaan_banmod()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_reg_id) ; $i++ )
		{
			$f = $this->model_nasabah->get_file_by_financing_reg($account_financing_reg_id[$i]);
			$f_proposal = $f['f_proposal'];
			$f_kontrak = $f['f_kontrak'];
			$f_keuangan = $f['f_keuangan'];
			$f_rek_koran = $f['f_rek_koran'];
			$f_aki = $f['f_aki'];
			$f_proyeksi = $f['f_proyeksi'];
			$f_jaminan = $f['f_jaminan'];

			if ($f_proposal!="") @unlink('./assets/data_pengajuan_banmod/'.$f_proposal);
			if ($f_kontrak!="") @unlink('./assets/data_pengajuan_banmod/'.$f_kontrak);
			if ($f_keuangan!="") @unlink('./assets/data_pengajuan_banmod/'.$f_keuangan);
			if ($f_rek_koran!="") @unlink('./assets/data_pengajuan_banmod/'.$f_rek_koran);
			if ($f_aki!="") @unlink('./assets/data_pengajuan_banmod/'.$f_aki);
			if ($f_proyeksi!="") @unlink('./assets/data_pengajuan_banmod/'.$f_proyeksi);
			if ($f_jaminan!="") @unlink('./assets/data_pengajuan_banmod/'.$f_jaminan);

			$param = array('account_financing_reg_id'=>$account_financing_reg_id[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->delete_pengajuan_pembiayaan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	/**
	* BEGIN
	* APPROVAL PENGAJUAN BANMOD
	*/
	function approval_pengajuan_banmod()
	{
		$data['date'] 		= date('d/m/Y',strtotime($this->model_transaction->date_current()));
		$data['kopegtel'] 	= $this->model_transaction->get_kopegtel();
		$data['product'] 	= $this->model_transaction->get_product_financing_by_banmod();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan_by_banmod();
		$data['akads'] 		= $this->model_transaction->get_akad();
		$data['container'] 	= 'transaction/approval_pengajuan_pembiayaan_koptel_banmod';
		$this->load->view('core',$data);
	}
	public function datatable_approval_pengajuan_banmod()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','a.registration_no','c.nama','a.tanggal_pengajuan','a.amount','b.display_text','','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_approval_pengajuan_banmod($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_approval_pengajuan_banmod($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_approval_pengajuan_banmod(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$btn_view_file = '<a href="#dialog_upload" data-toggle="modal" 
							id="link-upload"
							account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" 
							kopegtel_code="'.$aRow['kopegtel_code'].'" 
							registration_no="'.$aRow['registration_no'].'"
							f_proposal="'.$aRow['f_proposal'].'"
							f_kontrak="'.$aRow['f_kontrak'].'"
							f_keuangan="'.$aRow['f_keuangan'].'"
							f_rek_koran="'.$aRow['f_rek_koran'].'"
							f_aki="'.$aRow['f_aki'].'"
							f_proyeksi="'.$aRow['f_proyeksi'].'"
							f_jaminan="'.$aRow['f_jaminan'].'"
							class="btn mini green"><i class="icon-book"></i> Lihat Dokumen</a>';
			$btn_approve = '<a href="javascript:;" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-ok-sign"></i> Approve</a>';

			$status_dokumen_upload = '-';
			if ($aRow['status_dokumen_upload']==0) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini red-stripe">New</a>';
			} else if ($aRow['status_dokumen_upload']==1) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini green-stripe">Completed</a>';
			} else if ($aRow['status_dokumen_upload']==2) {
				$status_dokumen_upload = '<a href="javascript:void(0);" class="btn mini blue-stripe">Uncompleted</a>';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['kopegtel_name'];
			$row[] = '<center>'.$this->format_date_detail($aRow['tanggal_pengajuan'],'id',false,'-').'</center>';
			$row[] = '<center>'.date("d-m-Y H:i:s",strtotime($aRow['created_date'])).'</center>';
			$row[] = '<div align="right" style="white-space:nowrap;">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = '<div style="white-space:nowrap;text-align:center;">'.$status_dokumen_upload.'</div>';
			$row[] = '<div style="white-space:nowrap">'.$btn_view_file.' '.$btn_approve.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	function do_approve_pengajuan_banmod()
	{
		if (isset($_POST['approve'])) {
			$account_financing_reg_id = $this->input->post('account_financing_reg_id');
			$jangka_waktu = $this->input->post('jangka_waktu');
			$termin = $this->input->post('termin');
			$akad_code = $this->input->post('akad_code');
			$jenis_keuntungan = $this->input->post('jenis_keuntungan');
			$total_margin = $this->convert_numeric($this->input->post('total_margin'));
			$amount_proyeksi_keuntungan = $this->convert_numeric($this->input->post('amount_proyeksi_keuntungan'));
			$nisbah = $this->input->post('nisbah');
			$amount_disetujui = $this->convert_numeric($this->input->post('amount_disetujui'));
			$rencana_droping = $this->datepicker_convert(true,$this->input->post('rencana_droping'),'/');
			// conditional
			if ($termin==false) {
				$termin=1;
			}

			// collect data for pengajuan
			$data = array(
					'status'=>1
					,'approve_date'=>date("Y-m-d H:i:s")
					,'akad_code'=>$akad_code
					,'amount_disetujui'=>$amount_disetujui
					,'jangka_waktu'=>$jangka_waktu
				);
			if ($jenis_keuntungan==2) {
				$data['amount_proyeksi_keuntungan'] = $amount_proyeksi_keuntungan;
				$data['nisbah'] = $nisbah;
			}else{
				$data['total_margin'] = $total_margin;
			}

			$param = array('account_financing_reg_id'=>$account_financing_reg_id);
			// collect data for pengajuan termin
			$data_termin = array();
			if ($termin==1) {
				$data_termin[] = array(
						'account_financing_reg_id' => $account_financing_reg_id,
						'termin' => $termin,
						'nominal' => $amount_disetujui,
						'tgl_rencana_pencairan' => $rencana_droping
					);
			} else {
				$x=0;
				for ( $i=1; $i <= $termin; $i++ ) {
					$arr_amount = $this->input->post('arr_amount');
					$arr_rencana_droping = $this->input->post('arr_rencana_droping');
					$data_termin[] = array(
							'account_financing_reg_id' => $account_financing_reg_id,
							'termin' => $i,
							'nominal' => $this->convert_numeric($arr_amount[$x]),
							'tgl_rencana_pencairan' => $this->datepicker_convert(true,$arr_rencana_droping[$x],'/')
						);
					$x++;
				}
			}
			$this->db->trans_begin();
			$this->db->update('mfi_account_financing_reg',$data,$param);
			$this->db->insert_batch('mfi_account_financing_reg_termin',$data_termin);
			if ($this->db->trans_status()===true) {
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Approve Pengajuan Pembiayaan BANMOD BERHASIL!!');
			} else {
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed to connect into databases, please contact your administrator!');
			}
			echo json_encode($return);
		}
		if (isset($_POST['reject'])) {
			$account_financing_reg_id = $this->input->post('account_financing_reg_id');
			$data = array('status'=>2,'approve_date'=>date("Y-m-d H:i:s"));
			$param = array('account_financing_reg_id'=>$account_financing_reg_id);
			$this->db->trans_begin();
			$this->db->update('mfi_account_financing_reg',$data,$param);
			if ($this->db->trans_status()===true) {
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Reject Pengajuan Pembiayaan BANMOD BERHASIL!!');
			} else {
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed to connect into databases, please contact your administrator!');
			}
			echo json_encode($return);
		}
		if (!isset($_POST)) {
			show_404();
		}
	}
	function get_termin_pembiayaan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_termin_pembiayaan($account_financing_reg_id);
		echo json_encode($data);
	}
	/**
	* END
	*/

	function get_account_financing_schedulle()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$data = $this->model_nasabah->get_schedulle_by_account_financing_id($account_financing_id);
		echo json_encode($data);
	}

	//cetak SPB. adesagita.com 07-09-2015
	function get_spb_by_rage()
	{
		$tanggal = $this->input->post('tanggal');
		$tanggal2 = $this->input->post('tanggal2');
		$from_date = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$thru_date = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$data = $this->model_nasabah->get_spb_by_rage($from_date,$thru_date);
		echo json_encode($data);
	}
	//END cetak SPB. adesagita.com 07-09-2015

	function do_save_edit_spb()
	{
		$no_spb=$this->input->post('no_spb');
		$tgl_spb=$this->input->post('tgl_spb');
		$data_master=array('tanggal_spb'=>$tgl_spb);
		$data_financing_droping=array('tanggal_transfer'=>$tgl_spb);
		$param1=array('no_spb'=>$no_spb);
		$param2=array('no_spb'=>$no_spb);
		$this->db->trans_begin();
		$this->db->update('mfi_account_financing_droping',$data_financing_droping,$param1);
		$this->db->update('mfi_spb',$data_master,$param2);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function pengajuan_pengurangan()
	{
		$data['container'] = 'nasabah/pengajuan_pengurangan';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$date_current = $this->model_transaction->date_current();
		$tgl = substr("$date_current",8,2);
	    $bln = substr("$date_current",5,2);
	    $thn = substr("$date_current",0,4);
	    $current_date = "$tgl/$bln/$thn";
	    $data['date'] = $current_date;
		$this->load->view('core',$data);
	}

	function otorisasi_pengajuan_pengurangan()
	{
		$data['title'] = 'Otorisasi Pengajuan Pengurangan';
		$data['container'] = 'nasabah/otorisasi_pengajuan_pengurangan';
		$this->load->view('core',$data);
	}

	function datatable_otorisasi_pengajuan_pengurangan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('mfi_account_financing.account_financing_no','mfi_cif.nama','mfi_product_financing.product_name','mfi_account_financing.pokok','mfi_account_financing_lunas_part.pengajuan_pengurangan','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_nasabah->datatable_otorisasi_pengajuan_pengurangan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_otorisasi_pengajuan_pengurangan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_otorisasi_pengajuan_pengurangan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$aRow['verif'] = '<a href="javascript:;" part_id="'.$aRow['id'].'" id="link-verif" class="btn mini purple"><i class="icon-ok-sign"></i> Verifikasi</a>';
			$label_class = $aRow['verif'];
			$row = array();
			$row[] = '<div style="text-align:center;white-space:nowrap;">'.$aRow['account_financing_no'].'</div>';
			$row[] = '<div style="white-space:nowrap">'.$aRow['nama'].'</div>';
			$row[] = '<div align="center">'.$aRow['product_name'].'</div>';
			$row[] = '<div align="right">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = '<div align="right">Rp '.number_format($aRow['pengajuan_pengurangan'],0,',','.').',-</div>';
			$row[] = '<div style="white-space:nowrap">'.$label_class.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_otorisasi_pengajuan()
	{
		$id = $this->input->post('id');
		$data = $this->model_transaction->get_otorisasi_pengajuan($id);
		echo json_encode($data);
	}

	public function do_act_otorisasi_pengajuan_pengurangan()
	{
		$part_id = $this->input->post('part_id');
		$tanggal_jtempo = $this->input->post('tanggal_jtempo');
		$counter_angsuran = $this->input->post('counter_angsuran');
		$nik = $this->input->post('nik');
		$no_pembiayaan = $this->input->post('no_pembiayaan');
		$nilai_pembiayaan = $this->convert_numeric($this->input->post('nilai_pembiayaan'));
		$saldo_pokok = $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_margin = $this->convert_numeric($this->input->post('saldo_margin'));
		$angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
		$bayar_pokok = $this->convert_numeric($this->input->post('bayar_pokok'));
		$bayar_margin = $this->convert_numeric($this->input->post('bayar_margin'));
		$potongan_margin = $this->convert_numeric($this->input->post('potongan_margin'));
		$pengajuan_pengurangan = $this->convert_numeric($this->input->post('pengajuan_pengurangan'));

		$data_lunas_part = array(
							 'status' => 1
							,'approved_by'=>$this->session->userdata('user_id')
							,'approved_date'=>date("Y-m-d")
							,'potongan_margin'=>$potongan_margin
						);
		
		$data_financing = array(
							 'saldo_pokok' =>($saldo_pokok-$bayar_pokok)
							,'saldo_margin'=>($saldo_margin-$potongan_margin)
							,'tanggal_jtempo'=>date('Y-m-d',strtotime($tanggal_jtempo."-$counter_angsuran year"))
						);

		// $data_trx_finan = array(
		// 					 'branch_id' =>
		// 					,'trx_detail_id' =>
		// 					,'account_financing_no' =>
		// 					,'trx_financing_type' =>
		// 					,'trx_date' =>
		// 					,'jto_date' =>
		// 					,'pokok' =>
		// 					,'margin' =>
		// 					,'catab' =>
		// 					,'reference_no' =>
		// 					,'description' =>
		// 					,'created_date' =>
		// 					,'created_by' =>
		// 					,'trx_sequence' =>
		// 					,'tab_wajib' =>
		// 					,'tab_sukarela' =>
		// 					,'verify_by' =>
		// 					,'verify_date' =>
		// 					,'trx_status' =>
		// 					,'freq' =>
		// 					,'angsuran_ke' =>
		// 					,'account_cash_code' =>
		// 				);

		$param_lunas_part = array('id'=>$part_id);
		$param_financing = array('account_financing_no'=>$no_pembiayaan);

		$this->db->trans_begin();
		$this->db->update('mfi_account_financing_lunas_part',$data_lunas_part,$param_lunas_part);
		$this->db->update('mfi_account_financing',$data_financing,$param_financing);
		// $this->db->insert('mfi_trx_account_financing',$data_trx_finan);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function do_del_otorisasi_pengajuan_pengurangan()
	{
		$part_id = $this->input->post('part_id');
		$param = array('id'=>$part_id);
		$this->db->trans_begin();
		$this->db->delete('mfi_account_financing_lunas_part',$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/*[BEGIN] Reject reg akad
	| mengembalikan record ke halaman approval. edit status di account_financing_reg dan menghapus record di account_financing
	| 31-03-2016. Ade Sagita
	*/
	public function act_reject_reg_akad()
	{
		$registration_no	= $this->input->post('registration_no');
		/*
		**UPDATE DATA PENGAJUAN
		*/
			$data_financing_reg = array(
										 'status'=>"0"
										 ,'approve_date'=>date("Y-m-d H:i:s")
										);
			$param_financing_reg = array('registration_no'=>$registration_no);
		/*
		**END UPDATE DATA PENGAJUAN
		*/


		$this->db->trans_begin();
		$this->model_nasabah->delete_reg_akad($param_financing_reg);
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_financing_reg,$param_financing_reg);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function act_reject_reg_akad_edit()
	{
		$account_financing_id	= $this->input->post('account_financing_id');
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		/*
		**UPDATE DATA PENGAJUAN
		*/
			$data_financing_reg = array(
										 'status'=>"0"
										 ,'approve_date'=>date("Y-m-d H:i:s")
										);
			$param_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
			$param_financing = array('account_financing_id'=>$account_financing_id);
		/*
		**END UPDATE DATA PENGAJUAN
		*/


		$this->db->trans_begin();
		$this->model_nasabah->delete_reg_akad($param_financing);
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_financing_reg,$param_financing_reg);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/*[END] Reject reg akad
	*/

	function get_rate_dinamis($kopegtel_code=null)
	{
		$var = array(
					'KP304_689866662_36'=> 0, 
					'KP729_1473263468_36'=> 0, 
					'KP301_1000000000_12'=> 0, 
					'KP733_700000000_36'=> 0, 
					'KP124_700000000_24'=> 0, 
					'KP128_250000000_6'=> 0, 
					'KP720_700000000_24'=> 0, 
					'KP307_400000000_24' => '0.12', 
					'KP524_500000000_24' => '0.12', 
					'KP304_130900000_24' => '0.1', 
					'KP305_325000000_24' => '0.12', 
					'KP726_59950000_24' => '0.1', 
					'KP525_120450000_24' => '0.1', 
					'KP205_80300000_24' => '0.1', 
					'KP303_49500000_24' => '0.1', 
					'KP211_50600000_12' => '0.12', 
					'KP409_244200000_12' => '0.12', 
					'KP209_436150000_12' => '0.18', 
					'KP108_344300000_12' => '0.18', 
					'KP106_522500000_15' => '0.18', 
					'KP205_400000000_12' => '0.18', 
					'KP404_213675000_12' => '0.18', 
					'KP525_22500000_12' => '0.18', 
					'KP722_27197500_12' => '0.18', 
					'KP305_66000000_12' => '0.18', 
					'KP810_150000000_10' => '0.21', 
					'KP301_300000000_3'=> 0, 
					'KP910_816313000_1' => '0.025', 
					'KP524_2500000000_6' => '0.0194', 
					'KP205_5156532000_8' => '0.0194', 
					'KP517_1500000000_8' => '0.0194', 
					'KP524_1000000000_8' => '0.0194', 
					'KP206_4351895606_7' => '0.0194', 
					'MAS001_15007540000_12' => '0.02', 
					'KP205_2115000000_4' => '0.0187', 
					'KP302_600000000_4' => '0.0194', 
					'KP524_500000000_3' => '0.0194', 
					'KP304_840000000_3' => '0.0194', 
					'KP305_1028070407_4' => '0.0194', 
					'KP310_400000000_3' => '0.0194', 
					'KP304_860000000_3' => '0.0194', 
					'NON002_740300000_3' => '0.0194', 
					'KP302_700000000_4' => '0.0194', 
					'KP302_800000000_4' => '0.0194', 
					'KP524_1500000000_3' => '0.0194', 
					'KP205_2372000000_3' => '0.0187'
				);
		
		echo $var[$kopegtel_code];
	}

}