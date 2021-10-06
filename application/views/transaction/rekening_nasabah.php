<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_nasabah extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
	}

	/****************************************************************************************/	
	// BEGIN PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function pelunasan()
	{
		$data['container'] = 'nasabah/registrasi_pelunasan_pembiayaan';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function get_cif_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_cif_by_account_financing_no($account_financing_no);

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
		$created_date 					= date('Y-m-d H:i:s');
		$date_current 					= $this->model_transaction->get_date_current();
		$sisa_angsuran 					= $jangka_waktu-$counter_angsuran;

		$account_saving_no = $this->model_nasabah->get_account_saving_by_account_financing_no($account_financing_no);
		$saving = $this->model_nasabah->get_account_saving($account_saving_no);
		$saldo_memo = $saving['saldo_memo'];
		$saldo_riil = $saving['saldo_riil'];

		$jtempo_next = $jtempo_angsuran_next;
		$jtempo_last = $jtempo_angsuran_last;
		$jtempo_db = $tanggal_jtempo;

		/* set jto next */
		$jto_next = null;
		if ($periode_jangka_waktu==0) {
			$numnext=$sisa_angsuran;
			$jto_next = date("Y-m-d",strtotime($jtempo_next." +$numnext days"));
		} else if($periode_jangka_waktu==1) {
			$numnext=$sisa_angsuran*7;
			$jto_next = date("Y-m-d",strtotime($jtempo_next." +$numnext days"));	
		} else if($periode_jangka_waktu==2) {
			$numnext=$sisa_angsuran;
			$jto_next = date("Y-m-d",strtotime($jtempo_next." +$numnext month"));
		} else if($periode_jangka_waktu==3) {
			$jto_next = $jtempo_db;
		}

		/* set jto last */
		$jto_last = null;
		if ($periode_jangka_waktu==0) {
			$numnext=$sisa_angsuran;
			$jto_last = date("Y-m-d",strtotime($jtempo_last." +$numnext days"));
		} else if($periode_jangka_waktu==1) {
			$numnext=$sisa_angsuran*7;
			$jto_last = date("Y-m-d",strtotime($jtempo_last." +$numnext days"));	
		} else if($periode_jangka_waktu==2) {
			$numnext=$sisa_angsuran;
			$jto_last = date("Y-m-d",strtotime($jtempo_last." +$numnext month"));
		} else if($periode_jangka_waktu==3) {
			$jto_last = $jtempo_db;
		}

		// echo '<pre>';
		// echo $jenis_pembayaran;
		// echo '|';
		// echo $trx_date;
		// die();
		/*data financing lunas*/
		$data = array(
				'account_financing_no'	=>$account_financing_no,
				'saldo_pokok' 			=>$saldo_pokok,
				'saldo_margin' 			=>$saldo_margin,
				'saldo_catab' 			=>$saldo_tabungan,
				'potongan_margin' 		=>$potongan_margin,
				'status_pelunasan'		=>'0',
				'jenis_pembayaran'		=>$jenis_pembayaran,
				'create_by' 			=>$created_by,
				'tanggal_lunas' 		=>$trx_date,
				'created_date'			=>$created_date
		);

		/*data financing*/
		$data_financing = array(
				'saldo_pokok'			=>$saldo_pokok-$saldo_pokok2,
				'saldo_margin'			=>$saldo_margin-$saldo_margin2,
				'tanggal_lunas' 		=>$trx_date,
				'jtempo_angsuran_last' 	=>$jto_last,
				'jtempo_angsuran_next' 	=>$jto_next,
				'cadangan_resiko'	    =>$saldo_tabungan+$saldo_tabungan2,
				'counter_angsuran' 		=>$jangka_waktu
			);


		$trx_detail_id = uuid(false);
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


		/*jika pelunasannya mau di ambil dari tabungan catab/tabungan anggota*/
		$data_saving = array();
		$trx_account_saving = array();
		if ($jenis_pembayaran=='1') {
			$data_financing['saldo_catab']=$saldo_tabungan-($saldo_pokok+$saldo_margin);
		} else if ($jenis_pembayaran=='2') {
			$data_saving['saldo_memo']=$saldo_memo-($saldo_pokok+$saldo_margin);
			$data_saving['saldo_riil']=$saldo_riil-($saldo_pokok+$saldo_margin);
			$param_saving = array('account_saving_no'=>$account_saving_no);

			$trx_account_saving = array(
					'branch_id' 		=> $this->session->userdata('branch_id'),
					'account_saving_no' => $account_saving_no,
					'trx_saving_type' 	=> '3',
					'flag_debit_credit' => 'D',
					'trx_date' 			=> $trx_date,
					'amount' 			=> ($saldo_pokok+$saldo_margin),
					'trx_status' 		=> 1,
					'verify_date' 		=> $trx_date,
					'verify_by' 		=> $this->session->userdata('user_id'),
					'created_date' 		=> date('Y-m-d H:i:s'),
					'created_by' 		=> $this->session->userdata('user_id'),
					'trx_detail_id' 	=> $trx_detail_id,
					'description' 		=> 'PELUNASAN PEMBIAYAAN Rek.'.$account_financing_no
				);
		}

		// echo '<pre>';
		// print_r($trx_account_saving);
		// echo '|';
		// echo $jenis_pembayaran;
		// echo '|';
		// echo $trx_date;
		// die();
		$param_financing = array('account_financing_id'=>$account_financing_id);

		/*financing schedult / musiman */
		if($account_financing_schedulle_id!="") {
			$data_financing_schedulle = array(
					'tanggal_bayar' 	=>$trx_date,
					'bayar_pokok'		=>$saldo_pokok,
					'bayar_margin'		=>$saldo_margin,
					'tangga_jtempo'		=>$tanggal_jtempo,
					'bayar_tabungan'	=>$saldo_tabungan
				);

			$param_financing_schedulle = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);
		}


		$trx_account_financing = array();
		$jtempo_date = $jtempo_angsuran_last;
		for ($i = 0 ; $i < $sisa_angsuran; $i++) {

			$jto_date = null;
			if($periode_jangka_waktu==0)
			$jto_date = date("Y-m-d",strtotime($jtempo_date.' +1 days'));
			else if($periode_jangka_waktu==1)
			$jto_date = date("Y-m-d",strtotime($jtempo_date.' +7 days'));
			else if($periode_jangka_waktu==2)
			$jto_date = date("Y-m-d",strtotime($jtempo_date.' +1 month'));
			else if($periode_jangka_waktu==3)
			$jto_date = $jtempo_db;

			$trx_account_financing[] = array(
					'branch_id' 				=> $this->session->userdata('branch_id')
					,'trx_detail_id' 			=> $trx_detail_id
					,'account_financing_no' 	=> $account_financing_no
					,'trx_financing_type' 		=> '2'
					,'trx_date' 				=> $trx_date
					,'jto_date' 				=> $jto_date
					,'pokok' 					=> $angsuran_pokok
					,'margin' 					=> $angsuran_margin
					,'catab' 					=> $angsuran_catab
					,'created_date' 			=> date('Y-m-d H:i:s')
					,'created_by' 				=> $this->session->userdata('user_id')
					,'trx_status' 				=> 1
					,'verify_date' 				=> $trx_date
					,'verify_by' 				=> $this->session->userdata('user_id')
				);

			$jtempo_date=$jto_date;
		}

		// echo '<pre>';
		// print_r($trx_account_saving);
		// echo '|';
		// print_r($trx_account_financing);
		// echo '|';
		// echo $jenis_pembayaran;
		// echo '|';
		// echo $trx_date;
		// die();
		$this->db->trans_begin();
		
		// financing pelunasan transaction
		$this->model_nasabah->proses_reg_pelunasan_pembayaran($data);
		
		// account financing
		$this->model_nasabah->update_account_financing($data_financing,$param_financing);
		
		// account financing schedule
		if($account_financing_schedulle_id!="") $this->model_nasabah->update_account_financing_schedulle($data_financing_schedulle,$param_financing_schedulle);
		
		// account saving
		$this->model_nasabah->update_account_saving($data_saving,$param_saving);

		// financing transaction
		$this->model_nasabah->insert_mfi_trx_detail($trx_detail);
		$this->model_nasabah->insert_batch_mfi_trx_account_financing($trx_account_financing);
		
		// saving transaction
		if($jenis_pembayaran=='2') $this->model_nasabah->insert_mfi_trx_account_saving($trx_account_saving);

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
			$row[] = '<a href="javascript:;" account_financing_lunas_id="'.$aRow['account_financing_lunas_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function proses_verifikasi_pelunasan_pembayaran()
	{
		$account_financing_lunas_id = $this->input->post('account_financing_lunas_id');
		// $trx_account_financing_id   = $this->input->post('trx_account_financing_id');
		$account_financing_id 		= $this->input->post('account_financing_id');
		$cif_no 					= $this->input->post('cif_no');
		$account_financing_no 		= $this->input->post('no_pembiayaan');
		$total_pembayaran 			= $this->convert_numeric($this->input->post('total_pembayaran'));
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

		$data = array(
			'status_pelunasan'=>1,
			'verify_by'	 	  =>$user_id,
			'verifiy_date'	  =>$created_date
		 );

		$param = array('account_financing_lunas_id'=>$account_financing_lunas_id);

		$data_acc_financing	= array(
			'status_rekening'	=>'2',
			'saldo_pokok'		=>'0',
			'saldo_margin'		=>'0',
			'counter_angsuran'  =>$jangka_waktu
		);

		$param_acc_financing = array('account_financing_id'=>$account_financing_id);

		/*update status tab.simpan wajib pinjam*/
		$dataswp = array('status_rekening'=>1);
		$paramswp = array('account_saving_no'=>$cif_no);

		$this->db->trans_begin();
		$this->model_nasabah->proses_verifikasi_pelunasan_pembayaran($data,$param);
		$this->model_nasabah->update_account_financing_data($data_acc_financing,$param_acc_financing);
		$this->model_nasabah->update_account_financing_data($dataswp,$paramswp);
		$this->model_nasabah->fn_proses_jurnal_pelunasan_pyd($account_financing_lunas_id);
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
		for ( $i = 0 ; $i < count($account_financing_lunas_id) ; $i++ )
		{
			$param = array('account_financing_lunas_id'=>$account_financing_lunas_id[$i]);
			$this->db->trans_begin();
			$this->model_nasabah->reject_data_pelunasan_pembiayaan($param);
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

		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_no = $this->input->post('account_financing_no');
		$account_saving 	  = $this->input->post('account_saving_hide');
		$tanggal_akad		  = $this->input->post('tgl_akad');
		$tanggal_mulai_angsur = $this->input->post('angsuranke1');
		$tanggal_jtempo 	  = $this->input->post('tgl_jtempo');
		$tanggal_transfer 	  = $this->datepicker_convert(true,$this->input->post('tanggal_transfer'),'/');
		$nilai_pembiayaan 	  = $this->convert_numeric($this->input->post('nilai_pembiayaan'));
		$margin_pembiayaan 	  = $this->convert_numeric($this->input->post('margin_pembiayaan'));
		$simpanan_wajib_pinjam = $this->convert_numeric($this->input->post('simpanan_wajib_pinjam'));
		$angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
		$angsuran_tabungan = $this->convert_numeric($this->input->post('angsuran_tabungan'));
		$total_angsuran = $angsuran_pokok+$angsuran_margin+$angsuran_tabungan;
		$droping_by			  = $this->session->userdata('user_id');
		$created_by			  = $droping_by;
		$created_date 		  = date("Y-m-d H:i:s");

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; 

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	=substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	=substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        =substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo"; 
		
	    // get data account financing
		$datafinancing=$this->model_nasabah->get_account_financing_by_account_financing_no($account_financing_no);
		$status_rekening=$datafinancing['status_rekening'];
		$cif_no=$datafinancing['cif_no'];
		
		$this->db->trans_begin();

		/**
		* PERUBAHAN SCRIPT
		* dari UPDATE data droping ke INSERT data droping
		*
		* set data droping pembiayaan
		* @author sayyid nurkilah
		*/
		$data_financing_droping 	= array(
											'account_financing_no'=>$account_financing_no,
											'cif_no'=>$cif_no,
											'status_droping'=>1, // cair/droping
											'create_by'=>$created_by,
											'created_date'	=>$created_date,
											'droping_by'	=>$droping_by,
											'droping_date'	=>$tglakhir_akad,
											'status_transfer'	=>'1',
											'tanggal_transfer'	=>$tanggal_transfer
									 	);
		// $param_financing_droping 	= array('account_financing_no'=>$account_financing_no);

		$data_financing 			= array(
											'tanggal_akad'			=>$tglakhir_akad,
											'status_rekening'		=>1,
											'tanggal_mulai_angsur'	=>$tglakhir_angsur,
											// 'jtempo_angsuran_last'	=>$tglakhir_akad,
											'jtempo_angsuran_last'	=>$tglakhir_angsur,
											// 'jtempo_angsuran_next'	=>$tglakhir_angsur,
											'jtempo_angsuran_next'	=>date('Y-m-d',strtotime($tglakhir_angsur.' +1 month')),
											'tanggal_jtempo'		=>$tglakhir_jtempo,
											'saldo_pokok' 			=> $nilai_pembiayaan-$angsuran_pokok,
											'saldo_margin' 			=> $margin_pembiayaan-$angsuran_margin,
											'counter_angsuran'		=>'1'
										);
		$param_financing 			= array('account_financing_id'=>$account_financing_id);

		$data_default_balance 		= array(
											'account_financing_no'	=>$account_financing_no,
											'pokok_pembiayaan'		=>$nilai_pembiayaan,
											'margin_pembiayaan'		=>$margin_pembiayaan
										);
		$param_default_balance		= array('account_financing_no'=>$account_financing_no);
		// print_r($data_financing);
		// print_r($param_financing);
		// die();
		// $this->db->trans_begin();
		// pencairan financing
		// $this->model_nasabah->update_account_financing_droping($data_financing_droping,$param_financing_droping);
		$this->model_nasabah->insert_account_financing_droping($data_financing_droping);
		$this->model_nasabah->update_account_financing($data_financing,$param_financing);
		$this->model_nasabah->update_default_balance($data_default_balance,$param_default_balance);
		// if($this->db->trans_status()===true){
			// $this->db->trans_commit();
		// }else{
			// $this->db->trans_rollback();
		// }

		$get_financing = $this->model_nasabah->get_account_financing_by_account_financing_no($account_financing_no);


		$id_droping = uuid(false);
		$id_history_angsuran = uuid(false);

		$trx_detail_id = uuid(false);
		$trx_detail = array(
				 'trx_detail_id' 			=> $trx_detail_id
				,'trx_type' 				=> '3'
				,'trx_account_type' 		=> '0'
				,'account_no' 				=> $account_financing_no
				,'flag_debit_credit'		=> 'D'
				,'amount' 					=> $nilai_pembiayaan+$margin_pembiayaan
				,'trx_date' 				=> $tglakhir_akad
				// ,'reference_no' 			=> ''
				// ,'description' 			=> ''
				,'created_by' 				=> $this->session->userdata('user_id')
				,'created_date' 			=> date('Y-m-d H:i:s')
				,'account_no_dest' 			=> $account_financing_no
				,'account_type_dest' 		=> '1'
			);

		$trx_account_financing = array(
				'branch_id' 				=> $this->session->userdata('branch_id')
				,'trx_detail_id' 			=> $trx_detail_id
				,'trx_account_financing_id' 			=> $id_droping
				,'account_financing_no' 	=> $account_financing_no
				,'trx_financing_type' 		=> '0'
				,'trx_date' 				=> $tglakhir_akad
				,'jto_date' 				=> $get_financing['jtempo_angsuran_next']
				,'pokok' 					=> $nilai_pembiayaan
				,'margin' 					=> $margin_pembiayaan
				,'catab' 					=> '0'
				,'trx_status' 				=> '1'
				// ,'reference_no' 			=> ''
				// ,'description' 			=> ''
				,'created_date' 			=> date('Y-m-d H:i:s')
				,'created_by' 				=> $this->session->userdata('user_id')
			);

		$angs_trx_detail_id = uuid(false);
		$angs_trx_detail = array(
				 'trx_detail_id' 			=> $angs_trx_detail_id
				,'trx_type' 				=> '3'
				,'trx_account_type' 		=> '1'
				,'account_no' 				=> $account_financing_no
				,'flag_debit_credit'		=> 'D'
				,'amount' 					=> $total_angsuran
				,'trx_date' 				=> $tglakhir_angsur
				// ,'reference_no' 			=> ''
				// ,'description' 			=> ''
				,'created_by' 				=> $this->session->userdata('user_id')
				,'created_date' 			=> date('Y-m-d H:i:s')
				,'account_no_dest' 			=> NULL
				,'account_type_dest' 		=> NULL
			);

		$angs_trx_account_financing = array(
				'branch_id' 				=> $this->session->userdata('branch_id')
				,'trx_account_financing_id' 			=> $id_history_angsuran
				,'trx_detail_id' 			=> $angs_trx_detail_id
				,'account_financing_no' 	=> $account_financing_no
				,'trx_financing_type' 		=> '1'
				,'trx_date' 				=> $tglakhir_angsur
				,'jto_date' 				=> $tglakhir_angsur
				,'pokok' 					=> $angsuran_pokok
				,'margin' 					=> $angsuran_margin
				,'catab' 					=> $angsuran_tabungan
				,'trx_status' 				=> '1'
				// ,'reference_no' 			=> ''
				// ,'description' 			=> ''
				,'created_date' 			=> date('Y-m-d H:i:s')
				,'created_by' 				=> $this->session->userdata('user_id')
			);

		/*
		author ujangirawan
		date 14 februari 2015
		Insert ke mfi_account_saving
		*/
		// $cek_exist_data_on_account_saving = $this->model_nasabah->cek_exist_data_on_account_saving($cif_no);
		// if($cek_exist_data_on_account_saving==true){

		// 	$product_code = $this->model_nasabah->get_product_code_on_list_code_detail();
		// 	$data_account_saving = array(
		// 			 'product_code' => $product_code
		// 			,'cif_no' => $cif_no
		// 			,'account_saving_no' => $cif_no
		// 			,'branch_code' => $this->session->userdata('branch_code')
		// 			,'tanggal_buka' => $tglakhir_akad
		// 			,'status_rekening' => '3'
		// 			,'saldo_riil' => $simpanan_wajib_pinjam
		// 			,'saldo_memo' => $simpanan_wajib_pinjam
		// 			,'saldo_hold' => $simpanan_wajib_pinjam
		// 			,'created_by' => $this->session->userdata('user_id')
		// 			,'created_date' => date('Y-m-d H:i:s')
		// 		);

		// 	$data_trx_account_saving = array(
		// 			 'branch_id' => $this->session->userdata('branch_id')
		// 			,'account_saving_no' => $cif_no
		// 			,'trx_saving_type' => '6'
		// 			,'flag_debit_credit' => 'C'
		// 			,'trx_date' => date('Y-m-d')
		// 			,'amount' => $simpanan_wajib_pinjam
		// 			// ,'reference_no' => 
		// 			,'description' => 'Setoran Simpanan Wajib Pembiayaan'
		// 			,'created_date' => date('Y-m-d H:i:s')
		// 			,'created_by' => $this->session->userdata('user_id')
		// 			// ,'trx_sequence' => 
		// 			,'trx_detail_id' => uuid(false)
		// 			,'verify_by' => $this->session->userdata('user_id')
		// 			,'verify_date' => date('Y-m-d H:i:s')
		// 			,'trx_status' => 1
		// 			,'flag_pencairan' => 0
		// 		);

		// 	$data_trx_account_saving_detail = array(
		// 			 'trx_detail_id' => uuid(false)
		// 			,'trx_type' => 1
		// 			,'trx_account_type' => 1
		// 			,'account_no' => $account_saving
		// 			,'flag_debit_credit' => 'C'
		// 			,'amount' => $simpanan_wajib_pinjam
		// 			,'trx_date' => date('Y-m-d')
		// 			// ,'reference_no' => 
		// 			,'description' => 'Setoran Simpanan Wajib Pembiayaan'
		// 			,'created_by' => $this->session->userdata('user_id')
		// 			,'created_date' => date('Y-m-d H:i:s')
		// 			,'account_no_dest' => $cif_no
		// 			// ,'trx_sequence' => 
		// 			,'account_type_dest' => '6'
		// 		);

		// 	$this->db->trans_begin();
		// 	$this->model_nasabah->insert_mfi_account_saving($data_account_saving);
		// 	$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		// 	$this->model_nasabah->insert_mfi_trx_account_saving_detail($data_trx_account_saving_detail);
		// 	if($this->db->trans_status()===true){
		// 		$this->db->trans_commit();
		// 	}else{
		// 		$this->db->trans_rollback();
		// 	}
		// }else{
		// 	$row = $this->model_nasabah->get_saldo_sebelumnya_from_account_saving($cif_no);
		// 	$saldo_riil = $row['saldo_riil'];
		// 	$saldo_memo = $row['saldo_memo'];
		// 	$saldo_hold = $row['saldo_hold'];

		// 	$data_update_account_saving = array(
		// 			 'status_rekening' => '3'
		// 			,'saldo_riil' => ($saldo_riil+$simpanan_wajib_pinjam)
		// 			,'saldo_memo' => ($saldo_memo+$simpanan_wajib_pinjam)
		// 			,'saldo_hold' => ($saldo_hold+$simpanan_wajib_pinjam)
		// 		);

		// 	$data_trx_account_saving = array(
		// 			 'branch_id' => $this->session->userdata('branch_id')
		// 			,'account_saving_no' => $cif_no
		// 			,'trx_saving_type' => '6'
		// 			,'flag_debit_credit' => 'C'
		// 			,'trx_date' => date('Y-m-d')
		// 			,'amount' => $simpanan_wajib_pinjam
		// 			// ,'reference_no' => 
		// 			,'description' => 'Setoran Simpanan Wajib Pembiayaan'
		// 			,'created_date' => date('Y-m-d H:i:s')
		// 			,'created_by' => $this->session->userdata('user_id')
		// 			// ,'trx_sequence' => 
		// 			,'trx_detail_id' => uuid(false)
		// 			,'verify_by' => $this->session->userdata('user_id')
		// 			,'verify_date' => date('Y-m-d H:i:s')
		// 			,'trx_status' => 1
		// 			,'flag_pencairan' => 0
		// 		);

		// 	$data_trx_account_saving_detail = array(
		// 			 'trx_detail_id' => uuid(false)
		// 			,'trx_type' => 1
		// 			,'trx_account_type' => 1
		// 			,'account_no' => $account_saving
		// 			,'flag_debit_credit' => 'C'
		// 			,'amount' => $simpanan_wajib_pinjam
		// 			,'trx_date' => date('Y-m-d')
		// 			// ,'reference_no' => 
		// 			,'description' => 'Setoran Simpanan Wajib Pembiayaan'
		// 			,'created_by' => $this->session->userdata('user_id')
		// 			,'created_date' => date('Y-m-d H:i:s')
		// 			,'account_no_dest' => $cif_no
		// 			// ,'trx_sequence' => 
		// 			,'account_type_dest' => '6'
		// 		);

		// 	$param_update_account_saving = array('account_saving_no' => $cif_no);
		// 	$this->db->trans_begin();
		// 	$this->model_nasabah->update_mfi_account_saving($data_update_account_saving,$param_update_account_saving);
		// 	$this->model_nasabah->insert_mfi_trx_account_saving($data_trx_account_saving);
		// 	$this->model_nasabah->insert_mfi_trx_account_saving_detail($data_trx_account_saving_detail);
		// 	if($this->db->trans_status()===true){
		// 		$this->db->trans_commit();
		// 	}else{
		// 		$this->db->trans_rollback();
		// 	}
		// }

		// financing transaction
		$this->model_nasabah->insert_mfi_trx_detail($trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);
		$this->model_nasabah->insert_mfi_trx_detail($angs_trx_detail);
		$this->model_nasabah->insert_mfi_trx_account_financing($angs_trx_account_financing);
		$this->model_nasabah->fn_proses_jurnal_droping_pyd($account_financing_no);
		$this->model_transaction->fn_proses_jurnal_angsuran_pyd($id_history_angsuran);

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
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing();
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

			$data = array(
				'status'				=>"1"
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
		$status_anggota = $this->input->post('status_anggota');
		$menyetujui = $this->input->post('menyetujui');
		$saksi1 = $this->input->post('saksi1');
		$saksi2 = $this->input->post('saksi2');

		$data = array(
				'status_anggota' => $status_anggota,
				'menyetujui' => $saksi1,
				'saksi1' => $menyetujui,
				'saksi2' => $saksi2
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


		$data['kopegtel'] = $this->model_transaction->get_kopegtel();
		$data['sektor'] = $this->model_transaction->get_sektor();
		$data['peruntukan'] = $this->model_transaction->get_peruntukan();
		$data['grace'] = $this->model_transaction->get_grace_periode_kelompok();
		$data['akad'] = $this->model_transaction->get_ambil_akad();
		$data['jenis_program'] = $this->model_transaction->get_jenis_program_financing();
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['product'] = $this->model_transaction->get_product_financing();
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
		$aColumns = array( '','','mfi_account_financing_reg.registration_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','','');
				
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

		$rResult 			= $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_pengajuan_pembiayaan_koptel(); // get number of all data
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

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nik'].' - '.$aRow['nama_pegawai'];
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

	public function add_pengajuan_pembiayaan_koptel()
	{
		$cif_id				= $this->input->post('cif_id');
		$nik				= $this->input->post('nik');
		$jenis_kelamin 		= ($this->input->post('gender')=="PRIA") ? "P" : "W" ;
		$nama				= $this->input->post('nama');
		$amount				= $this->input->post('amount');
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
		$no_ktp 			= $this->input->post('no_ktp');
		$telpon_rumah  		= $this->input->post('telpon_rumah');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		$jumlah_tanggungan 	= $this->input->post('jumlah_tanggungan');
		$status_rumah 		= $this->input->post('status_rumah');
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');

		$total_angsuran 	= $this->input->post('total_angsuran');

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d H:i:s');

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 		= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');

		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;

		
			$data = array(
					 'cif_no'				=>$nik
					,'amount'				=>$this->convert_numeric($amount)
					,'peruntukan'			=>$peruntukan
					,'status'				=>$status
					,'tanggal_pengajuan'	=>$tanggal_pengajuan
					,'product_code'			=>$product_code
					,'created_by'			=>$created_by
					,'created_date'			=>$created_date
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
					,'jumlah_tanggungan'	=>$jumlah_tanggungan
					,'status_rumah'			=>$status_rumah
					,'nama_bank'			=>$nama_bank
					,'no_rekening'			=>$no_rekening
					,'atasnama_rekening'	=>$atasnama_rekening
					,'jenis_kelamin'		=>$jenis_kelamin
					,'bank_cabang'			=>$bank_cabang
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
		if($this->db->trans_status()===true){
			$this->model_nasabah->update_flag_thp($data_thp,$param_thp);//update semua flag thp 100%
			if($cif_id=='0'){
				$this->model_nasabah->insert_cif($data_cif);
			}else{
				$this->model_nasabah->update_cif($data_cif,$param);
			}
			$this->db->trans_commit();
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
		$jangka_waktu 	= $jangka_waktu+3;

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


	public function datatable_approval_pengajuan_pembiayaan()
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

		$rResult 			= $this->model_nasabah->datatable_approval_pengajuan_pembiayaan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_approval_pengajuan_pembiayaan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_approval_pengajuan_pembiayaan(); // get number of all data
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

			$aRow['status'] = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" id="link-edit" class="btn mini purple"><i class="icon-ok-sign"></i> Appove</a>';
			$label_class = $aRow['status'];
			
			$total_margin = ($aRow['amount']*$aRow['rate_margin2']*$aRow['jangka_waktu']/100);

			$nik=' <span class="btn mini green-stripe">'.$aRow['cif_no'].'</span>';

			$melalui = ($aRow['pengajuan_melalui']!='koptel') ? $this->model_nasabah->get_kopegname_by_code($aRow['kopegtel_code']):"Koptel (Langsung)";

			// if ($aRow['pengajuan_melalui']!='koptel') {
			// 	$time_pengajuan = strtotime($aRow['tanggal_pengajuan'].' +'.$this->get_approval_limit_time().' days');
			// 	$time_now = strtotime(date('Y-m-d'));
			// 	if ($time_now>$time_pengajuan) {
			// 		$label_class = '<a href="javascript:;" flag_scoring="'.$flag_scoring.'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" registration_no="'.$aRow['registration_no'].'" class="btn mini"><i class="icon-ok-sign"></i> Appove</a>';
			// 	}
			// }

			$row = array();
			$row[] = $aRow['registration_no'];
			$row[] = $nik.' '.$aRow['nama'];
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
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
		$amount				= $this->input->post('amount');
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
		$no_ktp 			= $this->input->post('no_ktp');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		$jumlah_tanggungan 	= $this->input->post('jumlah_tanggungan');
		$status_rumah 		= $this->input->post('status_rumah');
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');

		$total_angsuran 	= $this->input->post('total_angsuran');

		$tanggal_penga	 	= $this->input->post('tanggal_pengajuan');
		$tanggal_pengajuan_ =str_replace("/","", $tanggal_penga);
        $tanggal_pengajuan = substr($tanggal_pengajuan_,4,4).'-'.substr($tanggal_pengajuan_,2,2).'-'.substr($tanggal_pengajuan_,0,2);

		$created_by			= $this->session->userdata('user_id');
		$created_date	 	= date('Y-m-d H:i:s');

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 		= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');

		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		
		
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
					,'jumlah_tanggungan'	=>$jumlah_tanggungan
					,'status_rumah'			=>$status_rumah
					,'nama_bank'			=>$nama_bank
					,'no_rekening'			=>$no_rekening
					,'atasnama_rekening'	=>$atasnama_rekening
					,'bank_cabang'			=>$bank_cabang
				);
			$param_cif = array('cif_no'=>$nik);

		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data,$param);
		if($this->db->trans_status()===true){
			$this->model_nasabah->update_cif($data_cif,$param_cif);
			$this->db->trans_commit();
			$return = array('success'=>true);
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
		$aColumns = array( 'mfi_account_financing.account_financing_no','mfi_cif.nama','mfi_akad.akad_name','pokok','jangka_waktu','');
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
			$row[] = $aRow['cif_no'].' - '.$aRow['nama'];
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right" style="white-space:nowrap">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu'].$periode_jangka_waktu;
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini purple" account_financing_id="'.$aRow['account_financing_id'].'" id="link-edit">Pencairan</a></div>';

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
		$aColumns = array( 
							 'mfi_account_financing_reg.registration_no'
							,'mfi_cif.cif_no'
							,'mfi_account_financing_reg.amount'
							,'mfi_account_financing_reg.tanggal_pengajuan'
							,'mfi_account_financing_reg.approve_date'
							,'display_peruntukan'
							,'mfi_account_financing_reg.status,mfi_account_financing.status_rekening'
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

		$rResult 			= $this->model_nasabah->datatable_registrasi_akad($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_nasabah->datatable_registrasi_akad($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_nasabah->datatable_registrasi_akad(); // get number of all data
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
			  $label = '<a href="javascript:;" class="btn mini purple" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit"><i class="icon-edit"></i> Edit</a>';
			}else{
			  $label = '<a href="javascript:;" class="btn mini green" registration_no="'.$aRow['registration_no'].'" account_financing_reg_id="'.$aRow['account_financing_reg_id'].'" id="link-regis"><i class="icon-book"></i> Registrasi</a>';
			}

			$nik=' <span class="btn mini green-stripe">'.$aRow['cif_no'].'</span>';

			$row = array();
			$row[] = $aRow['registration_no'];
			$row[] = $nik.' '.$aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = date('d-m-Y H:i:s',strtotime($aRow['approve_date']));
			$row[] = $aRow['display_peruntukan'];
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

		$return = ($len==10) ? $angsuranke1.'|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	function get_date_regis_by_angs1()
	{
		$nValid = true;

		$jangka_waktu = $this->input->post('jangka_waktu');
		$angs1 = $this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		// $angsuranke1 = str_replace("_","",$this->input->post('angsuranke1'));
		$len = strlen($angs1);
		// $expl = explode("/",$angsuranke1);
		// $angs1 = $expl[2].'-'.$expl[1].'-'.$expl[0];

		$tgl_jtempo = date("d/m/Y",strtotime($angs1." + $jangka_waktu month"));

		$return = ($len==10) ? 'yes|'.$tgl_jtempo : "non|Format tanggal tidak lengkap" ;
		echo $return;
	}

	public function get_data_for_akad_by_account_financing_reg_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = $this->model_nasabah->get_data_for_akad_by_account_financing_reg_id($account_financing_reg_id);
		$data['thp'] = $data['thp'];
		$data['thp_40'] = $data['thp']*40/100;
		$data['min_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin1']/100);
		$data['max_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin2']/100);

		$usia = $this->get_usia($data['tgl_lahir'],$data['tanggal_pengajuan']);
		$data['usia2'] = $usia;
		$data['biaya_asuransi'] = $this->get_premi_asuransi($data['jangka_waktu'],$usia,$data['amount']);

		echo json_encode($data);
	}

	public function get_data_for_akad_by_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_nasabah->get_data_for_akad_by_account_financing_no($account_financing_no);
		$data['thp'] = $data['thp'];
		$data['thp_40'] = $data['thp']*40/100;
		$data['min_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin1']/100);
		$data['max_margin'] = ($data['amount']*$data['jangka_waktu']*$data['rate_margin2']/100);

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
		
		$nama_bank				= $this->input->post('nama_bank');
		$no_rekening			= $this->input->post('no_rekening');
		$atasnama_rekening		= $this->input->post('atasnama_rekening');
		$account_saving_no		= $this->input->post('account_saving_no');
		$jumlah_margin			= $this->input->post('jumlah_margin');
		$angsuran_pokok			= $this->input->post('angsuran_pokok');
		$angsuran_margin		= $this->input->post('angsuran_margin');
		$biaya_adm				= $this->input->post('biaya_adm');
		$biaya_asuransi			= $this->input->post('biaya_asuransi');
		$biaya_notaris			= $this->input->post('biaya_notaris');
		$tgl_akad				= $this->input->post('tgl_akad');
		$angsuranke1			= $this->input->post('angsuranke1');
		$tgl_jtempo				= $this->input->post('tgl_jtempo');
		$expltgl_akad=explode("/",$tgl_akad);
		$explangsuranke1=explode("/",$angsuranke1);
		$expltgl_jtempo=explode("/",$tgl_jtempo);

		$tanggal_akad = $expltgl_akad[2].'-'.$expltgl_akad[1].'-'.$expltgl_akad[0];
		$tanggal_mulai_angsur = $explangsuranke1[2].'-'.$explangsuranke1[1].'-'.$explangsuranke1[0];
		$tanggal_jtempo = $expltgl_jtempo[2].'-'.$expltgl_jtempo[1].'-'.$expltgl_jtempo[0];
		// echo $account_saving_no; die();

		$data_reg = $this->model_nasabah->select_financing_reg_by_id($account_financing_reg_id);

		/*
		** UPDATE DATA REKENING
		*/
			$data_update_rekening = array(
										 'nama_bank'=>$nama_bank
										,'no_rekening'=>$no_rekening
										,'atasnama_rekening'=>$atasnama_rekening
									);
			$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
			$param_update_cif = array('cif_no'=>$data_reg['cif_no']);
		/*
		** END UPDATE DATA REKENING
		*/

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


		$data_insert_to_financing = array(
					 'product_code'				=>$data_reg['product_code']
					,'branch_code'				=>$data_reg['branch_code']
					,'cif_no' 					=>$data_reg['cif_no']
					,'account_financing_no' 	=>$account_financing_no
					,'akad_code' 				=>$data_reg['akad_code']
					,'pokok'		 			=>$this->convert_numeric($data_reg['amount'])
					,'margin' 					=>$this->convert_numeric($jumlah_margin)
					,'saldo_pokok' 				=>$this->convert_numeric($data_reg['amount'])
					,'saldo_margin'				=>$this->convert_numeric($jumlah_margin)
					,'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok)
					,'angsuran_margin'			=>$this->convert_numeric($angsuran_margin)
					,'periode_jangka_waktu'	 	=>2 //bulanan
					,'jangka_waktu' 			=>$data_reg['jangka_waktu']
					,'tanggal_pengajuan'		=>$data_reg['tanggal_pengajuan']
					,'cadangan_resiko' 			=>0
					,'biaya_administrasi' 		=>$this->convert_numeric($biaya_adm)
					,'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris)
					,'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi)
					,'biaya_asuransi_jaminan' 	=>0
					,'dana_kebajikan'			=>0
					,'created_by'				=>$this->session->userdata('user_id')
					,'created_date'				=>date('Y-m-d H:i:s')
					,'program_code'				=>$data_reg['product_code']
					,'flag_jadwal_angsuran'		=>1
					,'peruntukan' 				=>$data_reg['peruntukan']
					,'registration_no'			=>$data_reg['registration_no']
					,'uang_muka'				=>0
					,'tanggal_registrasi'		=>$data_reg['tanggal_pengajuan']
					,'flag_wakalah'				=>1
					,'titipan_notaris'			=>0
					,'simpanan_wajib_pinjam'	=>0
					,'account_saving_no'		=>$account_saving_no
					,'tanggal_akad'				=>$tanggal_akad
					,'tanggal_mulai_angsur'		=>$tanggal_mulai_angsur
					,'tanggal_jtempo'			=>$tanggal_jtempo
				);
		/*
		** END insert into mfi_account_financing
		*/


		$this->db->trans_begin();
		$this->model_transaction->add_rekening_pembiayaan($data_insert_to_financing);

		$this->model_nasabah->edit_pengajuan_pembiayaan($data_update_rekening,$param_update_financing_reg);
		$this->model_nasabah->update_cif($data_update_rekening,$param_update_cif);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function proses_update_akad_pembiayaan()
	{
		$account_financing_id	= $this->input->post('account_financing_id');
		
		$jumlah_margin			= $this->input->post('jumlah_margin');
		$angsuran_pokok			= $this->input->post('angsuran_pokok');
		$angsuran_margin		= $this->input->post('angsuran_margin');
		$biaya_adm				= $this->input->post('biaya_adm');
		$biaya_asuransi			= $this->input->post('biaya_asuransi');
		$biaya_notaris			= $this->input->post('biaya_notaris');
		$tgl_akad				= $this->input->post('tgl_akad');
		$angsuranke1			= $this->input->post('angsuranke1');
		$tgl_jtempo				= $this->input->post('tgl_jtempo');
		$expltgl_akad=explode("/",$tgl_akad);
		$explangsuranke1=explode("/",$angsuranke1);
		$expltgl_jtempo=explode("/",$tgl_jtempo);

		$tanggal_akad = $expltgl_akad[2].'-'.$expltgl_akad[1].'-'.$expltgl_akad[0];
		$tanggal_mulai_angsur = $explangsuranke1[2].'-'.$explangsuranke1[1].'-'.$explangsuranke1[0];
		$tanggal_jtempo = $expltgl_jtempo[2].'-'.$expltgl_jtempo[1].'-'.$expltgl_jtempo[0];


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
				);
		/*
		** END insert into mfi_account_financing
		*/

		$param = array('account_financing_id'=>$account_financing_id);

		$this->db->trans_begin();
		$this->model_transaction->update_to_mfi_financing($data_update_to_financing,$param);
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
		$tanggal_transfer = $this->datepicker_convert(true,$this->input->post('tanggal_transfer'),'/');
		$data = $this->model_nasabah->get_data_cetak_transfer_pencairan($tanggal_transfer);

		if (isset($_POST['previewPDF'])) {
			$this->cetak_pdf_transfer_pencairan($data);
		} else if (isset($_POST['previewXLS'])) {
			$this->cetak_xls_transfer_pencairan($data);
		} else {
			show_404();
		}
	}
	private function cetak_pdf_transfer_pencairan($data)
	{
	}
	private function cetak_xls_transfer_pencairan($data)
	{
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
		$cols = array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U');
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
		$sheet->getColumnDimension('G')->setWidth(16);
		$sheet->getColumnDimension('H')->setWidth(17);
		$sheet->getColumnDimension('I')->setWidth(16);
		$sheet->getColumnDimension('J')->setWidth(17);
		$sheet->getColumnDimension('K')->setWidth(14);
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

		$nRow++;
		$sheet->mergeCells('C'.$nRow.':U'.$nRow);
		$sheet->setCellValue('C'.$nRow,'DAFTAR PENYALURAN PEMBIAYAAN MANDIRI KOPTEL & KOPTEL SMILE TAHUN '.date('Y'));
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
		$sheet->setCellValue('P'.($nRow+1),'PREMI');
		$sheet->setCellValue('P'.($nRow+2),'TAMBAHAN');

		$sheet->mergeCells('Q'.($nRow+1).':Q'.($nRow+2));
		$sheet->setCellValue('Q'.$nRow,'KOMPENSASI');
		$sheet->setCellValue('Q'.($nRow+1),'PEMBIAYAAN');
		
		$sheet->setCellValue('R'.$nRow,'JUMLAH');
		$sheet->setCellValue('R'.($nRow+1),'KOPEGTEL');
		$sheet->setCellValue('R'.($nRow+2),'TRANSFER');
		
		$sheet->setCellValue('S'.$nRow,'TRANSFER');
		$sheet->setCellValue('S'.($nRow+1),'PREMI');
		$sheet->setCellValue('S'.($nRow+2),'ASURANSI');

		$sheet->setCellValue('T'.$nRow,'KOMPENSASI');
		$sheet->setCellValue('T'.($nRow+1),'PELUNASAN');
		$sheet->setCellValue('T'.($nRow+2),'KOPEGTEL');

		$sheet->setCellValue('U'.$nRow,'JUMLAH');
		$sheet->setCellValue('U'.($nRow+1),'DITERIMA');
		$sheet->setCellValue('U'.($nRow+2),'KARYAWAN');

		$sheet->getStyle('C'.$nRow.':U'.($nRow+2))->getFont()->setBold(true);

		$sheet->getStyle('C'.$nRow.':U'.($nRow+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
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
		$sheet->mergeCells('C'.$nRow.':U'.$nRow);
		$sheet->setCellValue('C'.$nRow,' DI TRANSFER KE REKENING PRIBADI');
		$sheet->getStyle('C'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('C'.$nRow.':U'.$nRow)->applyFromArray($SubTitle);
		$nRow++;
		
		$no=1;
		foreach($data as $row) {

			$sheet->getRowDimension($nRow)->setRowHeight(20);
			$sheet->getStyle('C'.$nRow.':U'.$nRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$sheet->setCellValue('C'.$nRow,$no);
			$sheet->setCellValue('D'.$nRow,$row['cif_no']);
			$sheet->setCellValue('E'.$nRow,$row['nama']);
			$sheet->setCellValue('F'.$nRow,'');
			$sheet->setCellValue('G'.$nRow,'');
			$sheet->setCellValue('H'.$nRow,$row['jenis_pembiayaan']);
			$sheet->setCellValue('I'.$nRow,$row['nama_bank'].' '.$row['bank_cabang']);
			$sheet->setCellValue('J'.$nRow,$row['no_rekening'].' ');
			$sheet->setCellValue('K'.$nRow,$row['atasnama_rekening']);
			$sheet->setCellValue('L'.$nRow,number_format($row['pokok'],0,',','.').' ');
			$sheet->setCellValue('M'.$nRow,number_format($row['biaya_asuransi_jiwa'],0,',','.').' ');
			$sheet->setCellValue('N'.$nRow,'');
			$sheet->setCellValue('O'.$nRow,number_format($row['angsuran_margin'],0,',','.').' ');
			$sheet->setCellValue('P'.$nRow,number_format($row['biaya_administrasi'],0,',','.').' ');
			$sheet->setCellValue('Q'.$nRow,number_format($row['kewajiban_koptel'],0,',','.').' ');
			$sheet->setCellValue('R'.$nRow,'');
			$sheet->setCellValue('S'.$nRow,number_format($row['biaya_asuransi_jiwa'],0,',','.').' ');
			$sheet->setCellValue('T'.$nRow,number_format($row['kewajiban_kopegtel'],0,',','.').' ');
			$sheet->setCellValue('U'.$nRow,'');
			$sheet->getStyle('G'.$nRow.':K'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('L'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('M'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('N'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('O'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('P'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('Q'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('R'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('S'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('T'.$nRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			for ($j=0;$j<count($cols);$j++) {
				$sheet->getStyle($cols[$j].$nRow)->applyFromArray($styleArray);
			}

			$no++;
			$nRow++;
		}
		// $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		// $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
		// $objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		// $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
		// $objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="CETAK TRANSFER PENCAIRAN.xlsx"');
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

	function get_premi_asuransi($jangka_waktu,$usia,$manfaat)
	{
		$rate_code = '101';
		$kontrak = round($jangka_waktu/12);
		$rate_value = $this->model_nasabah->get_premium_rate($rate_code,$usia,$kontrak);
		$biaya_asuransi = $manfaat*($rate_value/1000);

		return $biaya_asuransi;

	}

}