<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
		$this->load->model('model_nasabah');
		$this->load->model('model_laporan');
		$this->load->library('html2pdf');
		$this->load->library('phpexcel');
	}

	public function datatable_rekening_tabungan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','product_name','account_saving_no','');
				
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

		$rResult 			= $this->model_transaction->datatable_rekening_tabungan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_tabungan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_tabungan_setup(); // get number of all data
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
			$rembug='';
			if($aRow['cm_name']!=""){
				$rembug=' <a href="javascript:void(0);" class="btn mini green-stripe">'.$aRow['cm_name'].'</a>';
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['account_saving_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'].$rembug;
			$row[] = $aRow['product_name'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini purple" account_saving_id="'.$aRow['account_saving_id'].'" id="link-edit"><i class="icon-edit"></i> Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function ajax_get_value_from_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->ajax_get_value_from_cif_no1($cif_no);

		echo json_encode($data);
	}

	public function ajax_get_tabungan_by_cif_type()
	{
		$cif_type = $this->input->post('cif_type');
		$data = $this->model_transaction->ajax_get_tabungan_by_cif_type($cif_type);

		echo json_encode($data);
	}


	public function ajax_get_value_from_cif_no2()
	{
		$cif_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_cif_no2($cif_no);

		echo json_encode($data);
	}

	public function add_rekening_tabungan()
	{
		$product				= $this->input->post('product');
		$product_code			= substr($product,1,5);;
		$cif_no		 			= $this->input->post('cif_no');
		$account_saving_no 		= $this->input->post('account_saving_no');
		$branch_code	 		= $this->input->post('branch_code');
		
		$rencana_setoran 		= $this->input->post('rencana_setoran');
		$rencana_periode_setoran= $this->input->post('rencana_periode_setoran');
		$rencana_jangka_waktu	= $this->input->post('rencana_jangka_waktu');
		$jenis_tabungan			= $this->input->post('jenis_tabungan');
		$rencana_setoran_next_	= $this->input->post('rencana_setoran_next');
        $rencana_setoran_next 	= substr($rencana_setoran_next_,4,4).'-'.substr($rencana_setoran_next_,2,2).'-'.substr($rencana_setoran_next_,0,2);
		$tanggal_pembukaan		= $this->input->post('tanggal_pembukaan');
        $tanggal_buka 			= substr($tanggal_pembukaan,4,4).'-'.substr($tanggal_pembukaan,2,2).'-'.substr($tanggal_pembukaan,0,2);
		

		if($jenis_tabungan=='1')
		{
			$data = array(
				'product_code'				=>$product_code,
				'cif_no' 					=>$cif_no,
				'account_saving_no' 		=>$account_saving_no,
				'branch_code' 				=>$branch_code,
				'tanggal_buka' 				=>$tanggal_buka,
				'status_rekening'			=> '1',
				'rencana_setoran' 			=>$this->convert_numeric($rencana_setoran),
				'rencana_periode_setoran' 	=>$rencana_periode_setoran,
				'rencana_jangka_waktu' 		=>$rencana_jangka_waktu,
				'rencana_setoran_last' 		=>$tanggal_buka,
				'rencana_setoran_next' 		=>$rencana_setoran_next,
				'created_by' 				=>$this->session->userdata('user_id'),
				'created_date' 				=>date("Y-m-d H:i:s")
				);
		}
		else
		{
			$data = array(
				'product_code'				=>$product_code,
				'cif_no' 					=>$cif_no,
				'status_rekening'			=> '1',
				'account_saving_no' 		=>$account_saving_no,
				'branch_code' 				=>$branch_code,
				'tanggal_buka' 				=>$tanggal_buka,
				'created_by' 				=>$this->session->userdata('user_id'),
				'created_date' 				=>date("Y-m-d H:i:s")
				// 'rencana_setoran_last' 		=>$tanggal_buka,
				// 'rencana_setoran_next' 		=>$rencana_setoran_next
				);
		}
		

		$this->db->trans_begin();
		$this->model_transaction->add_rekening_tabungan($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function count_cif_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_cif_by_product_code($product_code);

		echo json_encode($data);
	}
	
	public function delete_rekening_tabungan()
	{
		$account_saving_id = $this->input->post('account_saving_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_saving_id) ; $i++ )
		{
			$param = array('account_saving_id'=>$account_saving_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_tabungan($param);
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
	
	public function get_account_saving_by_account_saving_id()
	{
		$account_saving_id = $this->input->post('account_saving_id');
		$data = $this->model_transaction->get_account_saving_by_account_saving_id($account_saving_id);

		echo json_encode($data);
	}
	
	public function edit_rekening_tabungan()
	{
		$account_saving_id		= $this->input->post('account_saving_id');
		$product				= $this->input->post('product2');
		$product_code			= substr($product,1,5);;
		$cif_no		 			= $this->input->post('cif_no2');
		$account_saving_no 		= $this->input->post('account_saving_no2');
		$branch_code	 		= $this->input->post('branch_code2');
		
		$rencana_setoran 		= $this->input->post('rencana_setoran2');
		$rencana_periode_setoran= $this->input->post('rencana_periode_setoran2');
		$rencana_jangka_waktu	= $this->input->post('rencana_jangka_waktu2');

		$product2_code_old		= $this->input->post('product2_code_old');
		$account_saving_no2_old	= $this->input->post('account_saving_no2_old');
		$rencana_setoran_next_	= $this->input->post('rencana_setoran_next2');
        $rencana_setoran_next = substr($rencana_setoran_next_,4,4).'-'.substr($rencana_setoran_next_,2,2).'-'.substr($rencana_setoran_next_,0,2);
		$tanggal_pembukaan2	= $this->input->post('tanggal_pembukaan2');
        $tanggal_buka = substr($tanggal_pembukaan2,4,4).'-'.substr($tanggal_pembukaan2,2,2).'-'.substr($tanggal_pembukaan2,0,2);
		
		$data = array(
			'product_code'				=>$product_code,
			'cif_no' 					=>$cif_no,
			'account_saving_no' 		=>$account_saving_no,
			'branch_code' 				=>$branch_code
		);
		$datax = $this->model_transaction->count_cif_by_product_code($product_code);
		
		if($this->convert_numeric($rencana_setoran)>0){
			$data['rencana_setoran'] 		 = $this->convert_numeric($rencana_setoran);
			$data['rencana_periode_setoran'] = $rencana_periode_setoran;
			$data['rencana_jangka_waktu'] 	 = $rencana_jangka_waktu;
			$data['rencana_setoran_next'] 	 = $rencana_setoran_next;
		}

		$param = array('account_saving_id'=>$account_saving_id);

		$this->db->trans_begin();
		$this->model_transaction->edit_rekening_tabungan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Success: Edit rekening tabungan berhasil!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Error: Failed to connect into databases, please try again latter or contact your administrator!');
		}

		echo json_encode($return);
	}


	/* END REGISTRASI REKENING TABUNGAN *******************************************************/
	//Fungsi Untuk Datatable Deposito
	public function datatable_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','account_deposit_no','' );
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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

		$rResult 			= $this->model_transaction->datatable_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_deposito_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_deposit_no'];
			$row[] = '<a href="javascript:;" account_deposit_id="'.$aRow['account_deposit_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function get_cfi_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_cfi_by_cif_no($cif_no);

		echo json_encode($data);
	}
	
	public function add_deposito()
	{
		$cif_no		 			= $this->input->post('no_customer');
		$product_code			= $this->input->post('product');
		$branch_code	 		= $this->input->post('branch_code');
		$account_deposit_no 	= $this->input->post('no_rekening');
		$jangka_waktu	 		= $this->input->post('jangka_waktu');
		$jatuh_tempo_	 		= $this->input->post('jatuh_tempo');
		$jatuh_tempo 			= str_replace('/', '', $jatuh_tempo_);
		$jatuh_tempo_next_	 	= $this->input->post('jatuh_tempo_next');
		$jatuh_tempo_next		= str_replace('/', '', $jatuh_tempo_next_);
		$nominal	 			= $this->convert_numeric($this->input->post('nominal'));
		$nisbah_bagihasil 		= $this->input->post('nisbah_bagihasil');
		$rek_bagi_hasil 		= $this->input->post('rek_bagi_hasil');
		$ya		 				= $this->input->post('ya');

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_jtempo 		= substr("$jatuh_tempo",0,2);
	    $bln_jtempo 		= substr("$jatuh_tempo",2,2);
	    $thn_jtempo 		= substr("$jatuh_tempo",4,4);
	    $tglakhir 			= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_jtempo_next	= substr("$jatuh_tempo_next",0,2);
	    $bln_jtempo_next	= substr("$jatuh_tempo_next",2,2);
	    $thn_jtempo_next	= substr("$jatuh_tempo_next",4,4);
	    $tglakhir_next		= "$thn_jtempo_next-$bln_jtempo_next-$tgl_jtempo_next";  
		
		$data = array(
				'cif_no'				=>$cif_no,
				'branch_code'			=>$branch_code,
				'product_code'			=>$product_code,
				'account_deposit_no'	=>$account_deposit_no,
				'jangka_waktu'			=>$jangka_waktu,
				'nominal'				=>$nominal,
				'nisbah_bagihasil'		=>$nisbah_bagihasil,
				'tanggal_buka'			=>date('Y-m-d'),
				// 'tanggal_jtempo_last'	=>$tglakhir,
				// 'tanggal_jtempo_next'	=>$tglakhir_next,
				'account_saving_no'		=>$rek_bagi_hasil,
				'automatic_roll_over'	=>$ya,
				'created_by'			=>$this->session->userdata('user_id'),
				'created_date'			=>date('Y-m-d H:i:s')
				);
		
		$this->db->trans_begin();
		$this->model_transaction->add_deposito($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function delete_deposit()
	{
		$account_deposit_id = $this->input->post('account_deposit_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_deposit_id) ; $i++ )
		{
			$param = array('account_deposit_id'=>$account_deposit_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_deposit($param);
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
	
	public function get_deposit_by_id()
	{
		$account_deposit_id = $this->input->post('account_deposit_id');
		$data = $this->model_transaction->get_deposit_by_id($account_deposit_id);

		echo json_encode($data);
	}
	
	public function edit_deposit()
	{	
		$account_deposit_id		= $this->input->post('account_deposit_id');
		$product_code			= $this->input->post('product');
		$account_deposit_no 	= $this->input->post('no_rekening');
		$jangka_waktu	 		= $this->input->post('jangka_waktu');
		$jatuh_tempo_	 		= $this->input->post('jatuh_tempo');
		$jatuh_tempo 			= str_replace('-', '', $jatuh_tempo_);
		$jatuh_tempo_next_	 	= $this->input->post('jatuh_tempo_next');
		$jatuh_tempo_next		= str_replace('-', '', $jatuh_tempo_next_);
		$nominal	 			= $this->convert_numeric($this->input->post('nominal'));
		$nisbah_bagihasil 		= $this->input->post('nisbah_bagihasil');
		$rek_bagi_hasil 		= $this->input->post('rek_bagi_hasil');
		$ya		 				= $this->input->post('ya');

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_jtempo 		= substr("$jatuh_tempo",0,2);
	    $bln_jtempo 		= substr("$jatuh_tempo",2,2);
	    $thn_jtempo 		= substr("$jatuh_tempo",4,4);
	    $tglakhir 			= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_jtempo_next 	= substr("$jatuh_tempo_next",0,2);
	    $bln_jtempo_next 	= substr("$jatuh_tempo_next",2,2);
	    $thn_jtempo_next 	= substr("$jatuh_tempo_next",4,4);
	    $tglakhir_next		= "$thn_jtempo_next-$bln_jtempo_next-$tgl_jtempo_next"; 
		
		
		$param = array('account_deposit_id'=>$account_deposit_id);
		$data = array(
				'product_code'			=>$product_code,
				'account_deposit_no'	=>$account_deposit_no,
				'jangka_waktu'			=>$jangka_waktu,
				'tanggal_jtempo_last'	=>$tglakhir,
				'tanggal_jtempo_next'	=>$tglakhir_next,
				'nominal'				=>$nominal,
				'nisbah_bagihasil'		=>$nisbah_bagihasil,
				'account_saving_no'		=>$rek_bagi_hasil,
				'automatic_roll_over'	=>$ya
				);
		
		$this->db->trans_begin();
		$this->model_transaction->edit_deposit($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function cif_count_product_code()
	{
		$product_code	= $this->input->post('product_code');
		$data		= $this->model_transaction->cif_count_product_code($product_code);
		
		echo json_encode($data);
	}

	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	public function datatable_rekening_pembiayaan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		// $aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','mfi_account_financing_reg.registration_no','');
		$aColumns = array( '','mfi_account_financing_reg.registration_no','mfi_cif.nama','mfi_account_financing_reg.tanggal_pengajuan','mfi_account_financing_reg.amount','mfi_account_financing_reg.peruntukan','mfi_fa.fa_name','');
				
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

		$rResult 			= $this->model_transaction->datatable_rekening_pembiayaan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_pembiayaan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_pembiayaan_setup(); // get number of all data
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
			// if($aRow['status_rekening']==0){
			//   $aRow['status_rekening'] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Edit</a>';
			//   $label_class = $aRow['status_rekening'];
			// }
			// if($aRow['status_rekening']==0){
			//   $aRow['status_rekening'] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Edit</a>';
			//   $label_class = $aRow['status_rekening'];
			// }elseif($aRow['status_rekening']==1){
			//   $aRow['status_rekening'] = 'Active';
			//   $classs = 'info';
			//   $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			// }elseif($aRow['status_rekening']==2){
			//   $aRow['status_rekening'] = 'Lunas';
			//   $classs = 'success';
			//   $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			// }else{
			//   $aRow['status_rekening'] = 'Verified';
			//   $classs = 'important';
			//   $label_class = '<span class="label label-'.$classs.'">'.$aRow['status_rekening'].'</span>';
			// }
			if($aRow['financing_is_exist']==1){
			  $label = '<a href="javascript:;" class="btn mini purple" fa_code="'.$aRow['fa_code'].'" fa_name="'.$aRow['fa_name'].'" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit"><i class="icon-edit"></i> Edit</a>';
			}else{
			  $label = '<a href="javascript:;" class="btn mini green" fa_code="'.$aRow['fa_code'].'" fa_name="'.$aRow['fa_name'].'" registration_no="'.$aRow['registration_no'].'" cif_no="'.$aRow['cif_no'].'" id="link-regis"><i class="icon-book"></i> Registrasi</a>';
			}
			
			$resort_name='';
			if($aRow['resort_name']!=""){
				$resort_name=' <span class="btn mini green-stripe">'.$aRow['resort_name'].'</span>';
			}
			$row = array();
			// $row[] = '<input type="checkbox" value="'.$aRow['account_financing_reg_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['registration_no'];
			$row[] = $aRow['nama'].$resort_name;
			$row[] = date('d-m-Y',strtotime($aRow['tanggal_pengajuan']));
			$row[] = '<div align="right" style="white-space:nowrap;">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $aRow['display_peruntukan'];
			$row[] = $aRow['fa_name'];
			// $row[] = $skoring_link;
			$row[] = '<div align="center">'.$label.'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	
	public function count_cif_by_product_code_financing()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_cif_by_product_code_financing($product_code);

		echo json_encode($data);
	}

	
	public function count_cif_by_cif_no_financing()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->count_cif_by_cif_no_financing($cif_no);

		echo json_encode($data);
	}

	
	public function get_ajax_akad()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->get_ajax_akad($product_code);

		echo json_encode($data);
	}

	
	public function get_ajax_jenis_keuntungan()
	{
		$akad = $this->input->post('akad');
		$data = $this->model_transaction->get_ajax_jenis_keuntungan($akad);

		echo json_encode($data);
	}

	public function add_pembiayaan()
	{
		$jumlah_jaminan     		= $this->input->post('jumlah_jaminan');
		$presentase_jaminan     	= $this->input->post('presentase_jaminan');
		$jumlah_jaminan_sekunder     		= $this->input->post('jumlah_jaminan_sekunder');
		$presentase_jaminan_sekunder     	= $this->input->post('presentase_jaminan_sekunder');
		$product_code				= $this->input->post('product');
		//$product_code				= substr($product,1,3);;
		$registration_no		 	= $this->input->post('registration_no');
		$fa_code		 			= $this->input->post('fa_code');
		$cif_no		 				= $this->input->post('cif_no');
		$account_financing_reg_id	= $this->input->post('account_financing_reg_id');
		$account_financing_no		= $this->input->post('account_financing_no');
		$akad_code					= $this->input->post('akad');
		$nisbah_bagihasil			= $this->input->post('nisbah_bagihasil');
		$uang_muka					= $this->input->post('uang_muka');
		$pokok						= $this->input->post('nilai_pembiayaan');
		$account_saving				= $this->input->post('account_saving');
		$flag_wakalah				= $this->input->post('flag_wakalah');
		$titipan_notaris			= $this->convert_numeric($this->input->post('titipan_notaris'));
		$resort_code				= $this->input->post('resort_code');
		$resort_name				= $this->input->post('resort_name');

		if($pokok!=""){
			$pokok_ = $this->input->post('nilai_pembiayaan');
		}else{
			$pokok_ = "0";
		}

		if($uang_muka!=""){
			$uang_muka_ = $this->input->post('uang_muka');
		}else{
			$uang_muka_ = "0";
		}

		$margin = $this->input->post('margin_pembiayaan');
		if($margin!=""){
			$margin_ = $this->input->post('margin_pembiayaan');
		}else{
			$margin_ = "0";
		}

		$periode_jangka_waktu		= $this->input->post('periode_angsuran');
		$periode_jangka_waktu 		= str_replace('/', '', $periode_jangka_waktu);
		$jangka_waktu				= $this->input->post('jangka_waktu');
		$tanggal_pengajuan			= $this->input->post('tgl_pengajuan');
		$tanggal_pengajuan 			= str_replace('/', '', $tanggal_pengajuan);
		$tanggal_registrasi			= $this->input->post('tgl_registrasi');
		$tanggal_registrasi			= str_replace('/', '', $tanggal_registrasi);
		$tanggal_akad				= $this->input->post('tgl_akad');
		$tanggal_akad 				= str_replace('/', '', $tanggal_akad);
		$tanggal_mulai_angsur		= $this->input->post('angsuranke1');
		$tanggal_mulai_angsur 		= str_replace('/', '', $tanggal_mulai_angsur);
		$tanggal_jtempo				= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 			= str_replace('/', '', $tanggal_jtempo);
		$angs_tanggal				= $this->input->post('angs_tanggal');
		$angs_tanggal 				= str_replace('/', '', $angs_tanggal);
		$angs_pokok  				= $this->input->post('angs_pokok');
		$angs_margin				= $this->input->post('angs_margin');
		$angs_tabungan				= $this->input->post('angs_tabungan');
		$angsuran_pokok				= $this->input->post('angsuran_pokok');
		$angsuran_margin			= $this->input->post('angsuran_margin');
		$angsuran_tabungan			= $this->input->post('angsuran_tabungan');

		if($angsuran_tabungan!=""){
			$angsuran_tabungan_ = $this->input->post('angsuran_tabungan');
		}else{
			$angsuran_tabungan_ = "0";
		}

		$tabungan_wajib = $this->input->post('tabungan_wajib');
		if($tabungan_wajib!=""){
			$tabungan_wajib_ = $this->input->post('tabungan_wajib');
		}else{
			$tabungan_wajib_ = "0";
		}

		$tabungan_kelompok = $this->input->post('tabungan_kelompok');
		if($tabungan_kelompok!=""){
			$tabungan_kelompok_ = $this->input->post('tabungan_kelompok');
		}else{
			$tabungan_kelompok_ = "0";
		}

		$saldo_pokok = $this->input->post('nilai_pembiayaan');
		if($saldo_pokok!=""){
			$saldo_pokok_ = $this->input->post('nilai_pembiayaan');
		}else{
			$saldo_pokok_ = "0";
		}

		$saldo_margin = $this->input->post('margin_pembiayaan');
		if($saldo_margin!=""){
			$saldo_margin_ = $this->input->post('margin_pembiayaan');
		}else{
			$saldo_margin_ = "0";
		}

		$saldo_cadangan_resiko = $this->input->post('cadangan_resiko');
		if($saldo_cadangan_resiko!=""){
			$saldo_cadangan_resiko_ = $this->input->post('cadangan_resiko');
		}else{
			$saldo_cadangan_resiko_ = "0";
		}

		$dana_kebajikan	= $this->input->post('dana_kebajikan');
		if($dana_kebajikan!=""){
			$dana_kebajikan_ = $this->input->post('dana_kebajikan');
		}else{
			$dana_kebajikan_ = "0";
		}

		$biaya_administrasi	= $this->input->post('biaya_administrasi');
		if($biaya_administrasi!=""){
			$biaya_administrasi_ = $this->input->post('biaya_administrasi');
		}else{
			$biaya_administrasi_ = "0";
		}

		$biaya_notaris = $this->input->post('biaya_notaris');
		if($biaya_notaris!=""){
			$biaya_notaris_ = $this->input->post('biaya_notaris');
		}else{
			$biaya_notaris_ = "0";
		}

		$biaya_asuransi_jiwa = $this->input->post('p_asuransi_jiwa');
		if($biaya_asuransi_jiwa!=""){
			$biaya_asuransi_jiwa_ = $this->input->post('p_asuransi_jiwa');
		}else{
			$biaya_asuransi_jiwa_ = "0";
		}

		$biaya_asuransi_jaminan	= $this->input->post('p_asuransi_jaminan');
		if($biaya_asuransi_jaminan!=""){
			$biaya_asuransi_jaminan_ = $this->input->post('p_asuransi_jaminan');
		}else{
			$biaya_asuransi_jaminan_ = "0";
		}

		$sumber_dana = $this->input->post('sumber_dana_pembiayaan');
		$dana_sendiri = $this->input->post('dana_sendiri');
		if($dana_sendiri!=""){
			$dana_sendiri_ = $this->input->post('dana_sendiri');
		}else{
			$dana_sendiri_ = "0";
		}

		$dana_kreditur = $this->input->post('dana_kreditur');
		if($dana_kreditur!=""){
			$dana_kreditur_ = $this->input->post('dana_kreditur');
		}else{
			$dana_kreditur_ = "0";
		}

		$ujroh_kreditur	= $this->input->post('keuntungan');
		if($ujroh_kreditur!=""){
			$ujroh_kreditur_ = $this->input->post('keuntungan');
		}else{
			$ujroh_kreditur_ = "0";
		}

		$ujroh_kreditur_persen = $this->input->post('angsuran');
		if($ujroh_kreditur_persen!=""){
			$ujroh_kreditur_persen_ = $this->input->post('angsuran');
		}else{
			$ujroh_kreditur_persen_ = "0";
		}

		$ujroh_kreditur_carabayar	= $this->input->post('pembayaran_kreditur');
		$ujroh_kreditur_carabayar2	= $this->input->post('pembayaran_kreditur2');
		$jenis_program 				= $this->input->post('jenis_program');
		$jadwal_angsuran			= $this->input->post('jadwal_angsuran');
		$branch_code 				= $this->session->userdata('branch_code');
		$sektor_ekonomi				= $this->input->post('sektor_ekonomi');
		$peruntukan     			= $this->input->post('peruntukan_pembiayaan');
		$kreditur_code1     		= $this->input->post('kreditur_code1');
		$kreditur_code2     		= $this->input->post('kreditur_code2');
		$jaminan     				= $this->input->post('jaminan');
		$keterangan_jaminan     	= $this->input->post('keterangan_jaminan');
		$nominal_taksasi     		= $this->convert_numeric($this->input->post('nominal_taksasi'));

		$jaminan_sekunder     				= $this->input->post('jaminan_sekunder');
		$keterangan_jaminan_sekunder     	= $this->input->post('keterangan_jaminan_sekunder');
		$nominal_taksasi_sekunder     		= $this->convert_numeric($this->input->post('nominal_taksasi_sekunder'));

		$simpanan_wajib_pinjam     	= $this->convert_numeric($this->input->post('simpanan_wajib_pinjam'));
		
		/*biaya jasa layanan variable*/
		$biaya_jasa_layanan			= $this->convert_numeric($this->input->post('biaya_jasa_layanan'));

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_pengajuan 		=substr("$tanggal_pengajuan",0,2);
	    $bln_pangajuan 		=substr("$tanggal_pengajuan",2,2);
	    $thn_pengajuan 		=substr("$tanggal_pengajuan",4,4);
	    $tglakhir_pengajuan = "$thn_pengajuan-$bln_pangajuan-$tgl_pengajuan";  

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal registrasi
		$tgl_registrasi		=substr("$tanggal_registrasi",0,2);
	    $bln_registrasi		=substr("$tanggal_registrasi",2,2);
	    $thn_registrasi		=substr("$tanggal_registrasi",4,4);
	    $tglakhir_registrasi = "$thn_registrasi-$bln_registrasi-$tgl_registrasi";  

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

	    $array_data 		= array();

	    if($jadwal_angsuran==0)
		{

		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok_),
				'margin' 					=>$this->convert_numeric($margin_),
				'saldo_pokok' 				=>$this->convert_numeric($saldo_pokok_),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin_),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tglakhir_pengajuan,
				'tanggal_akad' 				=>$tglakhir_akad,
				'tanggal_mulai_angsur' 		=>$tglakhir_angsur,
				'tanggal_jtempo' 			=>$tglakhir_jtempo,
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko_),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi_),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris_),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa_),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan_),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan_),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'registration_no'			=>$registration_no,
				'uang_muka'					=>$this->convert_numeric($uang_muka_),
				'tanggal_registrasi'		=>$tglakhir_registrasi,
				'flag_wakalah'				=>$flag_wakalah,
				'titipan_notaris'			=>$titipan_notaris,
				'simpanan_wajib_pinjam'		=>$simpanan_wajib_pinjam,
				'biaya_jasa_layanan'		=>$biaya_jasa_layanan,
				'jenis_jaminan' 			=>($jaminan=="")?NULL:$jaminan,
				'keterangan_jaminan' 		=>($keterangan_jaminan=="")?NULL:$keterangan_jaminan,
				'nominal_taksasi'			=>($nominal_taksasi=="")?NULL:$nominal_taksasi,
				'jenis_jaminan_sekunder' 			=>($jaminan_sekunder=="")?NULL:$jaminan_sekunder,
				'keterangan_jaminan_sekunder' 		=>($keterangan_jaminan_sekunder=="")?NULL:$keterangan_jaminan_sekunder,
				'nominal_taksasi_sekunder'			=>($nominal_taksasi_sekunder=="")?NULL:$nominal_taksasi_sekunder,
				'jumlah_jaminan'					=>($jumlah_jaminan=="")?NULL:$jumlah_jaminan,
				'presentase_jaminan'				=>($presentase_jaminan=="")?NULL:$presentase_jaminan,
				'jumlah_jaminan_sekunder'			=>($jumlah_jaminan_sekunder=="")?NULL:$jumlah_jaminan_sekunder,
				'presentase_jaminan_sekunder'		=>($presentase_jaminan_sekunder=="")?NULL:$presentase_jaminan_sekunder,
				'fa_code'							=>($fa_code=="")?NULL:$fa_code,
				'resort_code'							=>($resort_code=="")?NULL:$resort_code
				);

			if($nisbah_bagihasil!=""){
				$data['nisbah_bagihasil'] = $nisbah_bagihasil;
			}

			if($sumber_dana=='0'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_);
			}else if($sumber_dana=='1'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_);
				$data['ujroh_kreditur']				= $ujroh_kreditur_;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			}else if($sumber_dana=='2'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_);
				$data['ujroh_kreditur']				= $ujroh_kreditur_;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}

			if($jenis_program!=""){
				$data['program_code']	= $jenis_program;
			}

     	    for($i=0;$i<count($angs_tanggal);$i++)
			{
				$tg_angsuran = substr($angs_tanggal[$i],0,2);
				$bl_angsuran = substr($angs_tanggal[$i],2,2);
				$th_angsuran = substr($angs_tanggal[$i],4,4);
				$tglakhir_angsuran = "$th_angsuran-$bl_angsuran-$tg_angsuran";

				$array_data[] = array(
					'account_no_financing'		=>$account_financing_no,
					'tangga_jtempo' 			=>$tglakhir_angsuran,
					'angsuran_pokok' 			=>$this->convert_numeric($angs_pokok[$i]),
					'angsuran_margin' 			=>$this->convert_numeric($angs_margin[$i]),
					'angsuran_tabungan' 		=>$this->convert_numeric($angs_tabungan[$i]),
					// 'tanggal_bayar'				=>$this->current_date()
				);
		    }
		}
		elseif($jadwal_angsuran==1)
		{

		$data = array(
				'product_code'				=>$product_code,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok_),
				'margin' 					=>$this->convert_numeric($margin_),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tglakhir_pengajuan,
				'tanggal_akad' 				=>$tglakhir_akad,
				'tanggal_mulai_angsur' 		=>$tglakhir_angsur,
				'tanggal_jtempo' 			=>$tglakhir_jtempo,
				'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok),
				'angsuran_margin'			=>$this->convert_numeric($angsuran_margin),
				'angsuran_catab'			=>$this->convert_numeric($angsuran_tabungan_),
				'angsuran_tab_wajib'		=>$this->convert_numeric($tabungan_wajib_),
				'angsuran_tab_kelompok'		=>$this->convert_numeric($tabungan_kelompok_),
				'saldo_pokok'				=>$this->convert_numeric($saldo_pokok_),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin_),
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko_),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi_),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris_),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa_),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan_),
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan_),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'program_code'				=>$jenis_program,
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'registration_no'			=>$registration_no,
				'uang_muka'					=>$this->convert_numeric($uang_muka_),
				'tanggal_registrasi'		=>$tglakhir_registrasi,
				'flag_wakalah'				=>$flag_wakalah,
				'simpanan_wajib_pinjam'		=>$simpanan_wajib_pinjam,
				'titipan_notaris'			=>$titipan_notaris,
				'biaya_jasa_layanan'		=>$biaya_jasa_layanan,
				'jenis_jaminan' 			=>($jaminan=="")?NULL:$jaminan,
				'keterangan_jaminan' 		=>($keterangan_jaminan=="")?NULL:$keterangan_jaminan,
				'nominal_taksasi'			=>($nominal_taksasi=="")?NULL:$nominal_taksasi,
				'jenis_jaminan_sekunder' 			=>($jaminan_sekunder=="")?NULL:$jaminan_sekunder,
				'keterangan_jaminan_sekunder' 		=>($keterangan_jaminan_sekunder=="")?NULL:$keterangan_jaminan_sekunder,
				'nominal_taksasi_sekunder'			=>($nominal_taksasi_sekunder=="")?NULL:$nominal_taksasi_sekunder,
				'jumlah_jaminan'					=>($jumlah_jaminan=="")?NULL:$jumlah_jaminan,
				'presentase_jaminan'				=>($presentase_jaminan=="")?NULL:$presentase_jaminan,
				'jumlah_jaminan_sekunder'			=>($jumlah_jaminan_sekunder=="")?NULL:$jumlah_jaminan_sekunder,
				'presentase_jaminan_sekunder'		=>($presentase_jaminan_sekunder=="")?NULL:$presentase_jaminan_sekunder,
				'fa_code'		=>($fa_code=="")?NULL:$fa_code,
				'resort_code'		=>($resort_code=="")?NULL:$resort_code
				);

			if($nisbah_bagihasil!=""){
				$data['nisbah_bagihasil'] = $nisbah_bagihasil;
			}

			if($sumber_dana=='0'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_);
			}else if($sumber_dana=='1'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_);
				$data['ujroh_kreditur']				= $ujroh_kreditur_;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code1;
			}else if($sumber_dana=='2'){
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri_);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur_);
				$data['ujroh_kreditur']				= $ujroh_kreditur_;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen_;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code2;
			}

			if($jenis_program!=""){
				$data['program_code']	= $jenis_program;
			}
		}

		$data_reg 	= array(
			 'status'=>"1"
			,'fa_code'=>$fa_code
			,'resort_code'=>($resort_code=="")?NULL:$resort_code
			,'biaya_administrasi'=>$this->convert_numeric($biaya_administrasi_)
			,'biaya_notaris'=>$this->convert_numeric($biaya_notaris_)
			// ,'premi_asuransi'=>$this->convert_numeric($biaya_asuransi_jiwa_)
		);
		$param_reg 	= array('account_financing_reg_id'=>$account_financing_reg_id);
		
		$this->db->trans_begin();
		$this->model_transaction->add_rekening_pembiayaan($data);
		$this->model_transaction->update_status_pengajuan_pembiayaan($data_reg,$param_reg);
		if(count($array_data)>0){
			$this->model_transaction->add_rekening_pembiayaan_array($array_data);
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

	
	public function delete_rekening_pembiayaan()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_no) ; $i++ )
		{
			$param = array('account_financing_no'=>$account_financing_no[$i]);
			$param2 = array('account_no_financing'=>$account_financing_no[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_pembiayaan($param);
			$this->model_transaction->delete_account_financing_schedulle($param2);
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

	
	public function delete_rek_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('user_id');

		
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
		
			$param = array('account_financing_id'=>$account_financing_id);

			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
			$this->model_transaction->delete_rekening_pembiayaan($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		echo json_encode($return);
	}
	
	public function get_account_financing_by_account_financing_id()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);

		echo json_encode($data);
	}
	
	public function get_account_financing_by_financing_id()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$is_banmod = $this->input->post('is_banmod');
		$data = $this->model_transaction->get_account_financing_by_financing_id($account_financing_id,$is_banmod);

		echo json_encode($data);
	}
	
	public function get_account_financing_schedulle_by_no_account()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_account_financing_schedulle_by_no_account($account_financing_no);
		$data['length'] = count($data);
		echo json_encode($data);
	}
	
	public function update_rek_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$saldo_pokok = $this->input->post('saldo_pokok');
		$counter = $this->input->post('counter');
		
		$param = array('account_financing_id'=>$account_financing_id);
		$data = array(
					'saldo_pokok' => $saldo_pokok
				   ,'counter_angsuran' => $counter
				);

		$this->db->trans_begin();
		$this->model_transaction->edit_rekening_pembiayaan($data,$param);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function edit_rekening_pembiayaan()
	{
		$jumlah_jaminan     		= $this->input->post('jumlah_jaminan');
		$presentase_jaminan     	= $this->input->post('presentase_jaminan');
		$jumlah_jaminan_sekunder     		= $this->input->post('jumlah_jaminan_sekunder');
		$presentase_jaminan_sekunder     	= $this->input->post('presentase_jaminan_sekunder');
		$account_financing_id	= $this->input->post('account_financing_id');
		$account_financing_schedulle_id	= $this->input->post('account_financing_schedulle_id');
		$product					= $this->input->post('product');
		// $product_code				= substr($product,1,5);
		$cif_no		 				= $this->input->post('cif_no');
		$account_financing_no		= $this->input->post('account_financing_no');
		$akad_code					= $this->input->post('akad');
		$nisbah_bagihasil			= $this->input->post('nisbah_bagihasil');
		$uang_muka					= $this->input->post('uang_muka');
		$pokok						= $this->input->post('nilai_pembiayaan');
		$margin         			= $this->input->post('margin_pembiayaan');
		$periode_jangka_waktu		= $this->input->post('periode_angsuran');
		$jangka_waktu				= $this->input->post('jangka_waktu');
		$tanggal_pengajuan			= $this->input->post('tgl_pengajuan_edit');
		$tanggal_pengajuan 			= str_replace('/', '', $tanggal_pengajuan);
		$tanggal_registrasi			= $this->input->post('tgl_registrasi_edit');
		$tanggal_registrasi 		= str_replace('/', '', $tanggal_registrasi);
		$tanggal_akad				= $this->input->post('tgl_akad_edit');
		$tanggal_akad 				= str_replace('/', '', $tanggal_akad);
		$tanggal_mulai_angsur		= $this->input->post('angsuranke1_edit');
		$tanggal_mulai_angsur 		= str_replace('/', '', $tanggal_mulai_angsur);
		$tanggal_jtempo				= $this->input->post('tgl_jtempo_edit');
		$tanggal_jtempo 			= str_replace('/', '', $tanggal_jtempo);
		$angs_tanggal				= $this->input->post('angs_tanggal');
		$angs_tanggal 				= str_replace('/', '', $angs_tanggal);
		$angs_pokok  				= $this->input->post('angs_pokok');
		$angs_margin				= $this->input->post('angs_margin');
		$angs_tabungan				= $this->input->post('angs_tabungan');
		$angsuran_pokok				= $this->input->post('angsuran_pokok');
		$angsuran_margin			= $this->input->post('angsuran_margin');
		$angsuran_tabungan			= $this->input->post('angsuran_tabungan');
		$tabungan_wajib				= $this->input->post('tabungan_wajib');
		$tabungan_kelompok			= $this->input->post('tabungan_kelompok');
		$saldo_pokok				= $pokok;
		$saldo_margin				= $margin;
		$saldo_cadangan_resiko		= $this->input->post('cadangan_resiko');
		$dana_kebajikan				= $this->input->post('dana_kebajikan');
		$biaya_administrasi			= $this->input->post('biaya_administrasi');
		$biaya_notaris				= $this->input->post('biaya_notaris');
		$biaya_asuransi_jiwa		= $this->input->post('p_asuransi_jiwa');
		$biaya_asuransi_jaminan		= $this->input->post('p_asuransi_jaminan');
		$sumber_dana				= $this->input->post('sumber_dana_pembiayaan');
		$dana_sendiri				= $this->input->post('dana_sendiri');
		$dana_kreditur				= $this->input->post('dana_kreditur');
		$ujroh_kreditur				= $this->input->post('keuntungan');
		$ujroh_kreditur_persen		= $this->input->post('angsuran');
		$ujroh_kreditur_carabayar	= $this->input->post('pembayaran_kreditur');
		$ujroh_kreditur_carabayar2	= $this->input->post('pembayaran_kreditur2');
		$jenis_program 				= $this->input->post('jenis_program');
		$jadwal_angsuran			= $this->input->post('jadwal_angsuran');
		$branch_code 				= $this->session->userdata('branch_code');
		$account_saving				= $this->input->post('account_saving');
		$sektor_ekonomi				= $this->input->post('sektor_ekonomi');
		$peruntukan     			= $this->input->post('peruntukan_pembiayaan');
		$kreditur_code21     		= $this->input->post('kreditur_code21');
		$kreditur_code_22     		= $this->input->post('kreditur_code_22');
		$jaminan     				= $this->input->post('jaminan');
		$keterangan_jaminan     	= $this->input->post('keterangan_jaminan');
		$nominal_taksasi     		= $this->convert_numeric($this->input->post('nominal_taksasi'));
		$jaminan_sekunder     				= $this->input->post('jaminan_sekunder');
		$keterangan_jaminan_sekunder     	= $this->input->post('keterangan_jaminan_sekunder');
		$nominal_taksasi_sekunder     		= $this->convert_numeric($this->input->post('nominal_taksasi_sekunder'));
		$flag_wakalah				= $this->input->post('flag_wakalah');
		$titipan_notaris			= $this->convert_numeric($this->input->post('titipan_notaris'));
		$simpanan_wajib_pinjam     	= $this->convert_numeric($this->input->post('simpanan_wajib_pinjam'));
		$biaya_jasa_layanan			= $this->convert_numeric($this->input->post('biaya_jasa_layanan'));
		$fa_code			= $this->input->post('fa_code');
		$resort_code			= $this->input->post('resort_code');

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal pengajuan
		$tgl_pengajuan 		=substr("$tanggal_pengajuan",0,2);
	    $bln_pangajuan 		=substr("$tanggal_pengajuan",2,2);
	    $thn_pengajuan 		=substr("$tanggal_pengajuan",4,4);
	    $tglakhir_pengajuan = "$thn_pengajuan-$bln_pangajuan-$tgl_pengajuan"; 

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal registrasi
		$tgl_registrasi 	 =substr("$tanggal_registrasi",0,2);
	    $bln_registrasi 	 =substr("$tanggal_registrasi",2,2);
	    $thn_registrasi 	 =substr("$tanggal_registrasi",4,4);
	    $tglakhir_registrasi = "$thn_registrasi-$bln_registrasi-$tgl_registrasi";  

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
	   
	    $array_data 		= array();
		
	    if($jadwal_angsuran==0) // REGULER
		{
		
		$param = array('account_financing_id'=>$account_financing_id);
		$data = array(
				// 'product_code'				=>$product_code,
				'product_code'				=>$product,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tglakhir_pengajuan,
				'tanggal_akad' 				=>$tglakhir_akad,
				'tanggal_mulai_angsur' 		=>$tglakhir_angsur,
				'tanggal_jtempo' 			=>$tglakhir_jtempo,
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'saldo_pokok'				=>$this->convert_numeric($saldo_pokok),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'sumber_dana' 				=>$sumber_dana,
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'uang_muka' 				=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi' 		=>$tglakhir_registrasi,
				'flag_wakalah'				=>$flag_wakalah,
				'biaya_jasa_layanan'		=>$biaya_jasa_layanan,
				'titipan_notaris'			=>$titipan_notaris,
				'simpanan_wajib_pinjam'		=>$simpanan_wajib_pinjam,
				'jenis_jaminan'				=>($jaminan=="")?NULL:$jaminan,
				'keterangan_jaminan'		=>($keterangan_jaminan=="")?NULL:$keterangan_jaminan,
				'nominal_taksasi'			=>($nominal_taksasi=="")?NULL:$nominal_taksasi,
				'jenis_jaminan_sekunder'		=>($jaminan_sekunder=="")?NULL:$jaminan_sekunder,
				'keterangan_jaminan_sekunder'	=>($keterangan_jaminan_sekunder=="")?NULL:$keterangan_jaminan_sekunder,
				'nominal_taksasi_sekunder'		=>($nominal_taksasi_sekunder=="")?NULL:$nominal_taksasi_sekunder,
				'jumlah_jaminan'					=>($jumlah_jaminan=="")?NULL:$jumlah_jaminan,
				'presentase_jaminan'				=>($presentase_jaminan=="")?NULL:$presentase_jaminan,
				'jumlah_jaminan_sekunder'			=>($jumlah_jaminan_sekunder=="")?NULL:$jumlah_jaminan_sekunder,
				'presentase_jaminan_sekunder'		=>($presentase_jaminan_sekunder=="")?NULL:$presentase_jaminan_sekunder,
				'fa_code'		=>($fa_code=="")?NULL:$fa_code,
				'resort_code'		=>($resort_code=="")?NULL:$resort_code
				);

			if($margin!=""){
				$data['margin'] = $this->convert_numeric($margin);
			}

			if($nisbah_bagihasil!=""){
				$data['nisbah_bagihasil'] = $nisbah_bagihasil;
			}

			if($sumber_dana==0)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
			}
			else if($sumber_dana==1)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code21;
			}
			else if($sumber_dana==2)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code22;
			}

			if($jenis_program!="")
			{
				$data['program_code']	= $jenis_program;
			}else{
				$data['program_code']	= '';
			}

     	    for($i=0;$i<count($angs_tanggal);$i++)
			{

				$tg_angsuran = substr($angs_tanggal[$i],0,2);
				$bl_angsuran = substr($angs_tanggal[$i],2,2);
				$th_angsuran = substr($angs_tanggal[$i],4,4);
				$tglakhir_angsuran = "$th_angsuran-$bl_angsuran-$tg_angsuran";

				$array_data[] = array(
					'account_no_financing'		=>$account_financing_no,
					'tangga_jtempo' 			=>$tglakhir_angsuran,
					'angsuran_pokok' 			=>$this->convert_numeric($angs_pokok[$i]),
					'angsuran_margin' 			=>$this->convert_numeric($angs_margin[$i]),
					'angsuran_tabungan' 		=>$this->convert_numeric($angs_tabungan[$i])
					);
		    
				// $cekdata = $this->model_transaction->cek_eksistensi_tanggal_jatuh_tempo($account_financing_no,$tglakhir_angsuran);

			    // if(count($cekdata)==0){
			    	// $array_data[]['tangga_jtempo'] = $tglakhir_angsuran[$i];
			    // }
		    }
			$param2 = array('account_no_financing'=>$account_financing_no);
			$this->model_transaction->delete_rekening_pembiayaan_array($param2);
			$this->model_transaction->insert_rekening_pembiayaan_array($array_data);
		}

		elseif($jadwal_angsuran==1)
		{
			
		$param = array('account_financing_id'=>$account_financing_id);
		$data = array(
				// 'product_code'				=>$product_code,
				'product_code'				=>$product,
				'branch_code'				=>$branch_code,
				'cif_no' 					=>$cif_no,
				'account_financing_no' 		=>$account_financing_no,
				'akad_code' 				=>$akad_code,
				'pokok'		 				=>$this->convert_numeric($pokok),
				'periode_jangka_waktu'	 	=>$periode_jangka_waktu,
				'jangka_waktu' 				=>$jangka_waktu,
				'tanggal_pengajuan'			=>$tglakhir_pengajuan,
				'tanggal_akad' 				=>$tglakhir_akad,
				'tanggal_mulai_angsur' 		=>$tglakhir_angsur,
				'tanggal_jtempo' 			=>$tglakhir_jtempo,
				'angsuran_pokok'			=>$this->convert_numeric($angsuran_pokok),
				'angsuran_margin'			=>$this->convert_numeric($angsuran_margin),
				'angsuran_catab'			=>$this->convert_numeric($angsuran_tabungan),
				'angsuran_tab_wajib'		=>$this->convert_numeric($tabungan_wajib),
				'angsuran_tab_kelompok'		=>$this->convert_numeric($tabungan_kelompok),
				'saldo_pokok'				=>$this->convert_numeric($saldo_pokok),
				'saldo_margin'				=>$this->convert_numeric($saldo_margin),
				'cadangan_resiko' 			=>$this->convert_numeric($saldo_cadangan_resiko),
				'biaya_administrasi' 		=>$this->convert_numeric($biaya_administrasi),
				'biaya_notaris' 			=>$this->convert_numeric($biaya_notaris),
				'biaya_asuransi_jiwa' 		=>$this->convert_numeric($biaya_asuransi_jiwa),
				'biaya_asuransi_jaminan' 	=>$this->convert_numeric($biaya_asuransi_jaminan),
				'sumber_dana' 				=>$sumber_dana,
				'dana_kebajikan'			=>$this->convert_numeric($dana_kebajikan),
				'created_by'				=>$this->session->userdata('user_id'),
				'created_date'				=>date('Y-m-d H:i:s'),
				'flag_jadwal_angsuran'		=>$jadwal_angsuran,
				'account_saving_no'			=>$account_saving,
				'sektor_ekonomi' 			=>$sektor_ekonomi,
				'peruntukan' 				=>$peruntukan,
				'uang_muka' 				=>$this->convert_numeric($uang_muka),
				'tanggal_registrasi' 		=>$tglakhir_registrasi,
				'flag_wakalah'				=>$flag_wakalah,
				'biaya_jasa_layanan'		=>$biaya_jasa_layanan,
				'titipan_notaris'			=>$titipan_notaris,
				'simpanan_wajib_pinjam'		=>$simpanan_wajib_pinjam,
				'jenis_jaminan'				=>($jaminan=="")?NULL:$jaminan,
				'keterangan_jaminan'		=>($keterangan_jaminan=="")?NULL:$keterangan_jaminan,
				'nominal_taksasi'			=>($nominal_taksasi=="")?NULL:$nominal_taksasi,
				'jenis_jaminan_sekunder'		=>($jaminan_sekunder=="")?NULL:$jaminan_sekunder,
				'keterangan_jaminan_sekunder'	=>($keterangan_jaminan_sekunder=="")?NULL:$keterangan_jaminan_sekunder,
				'nominal_taksasi_sekunder'		=>($nominal_taksasi_sekunder=="")?NULL:$nominal_taksasi_sekunder,
				'jumlah_jaminan'					=>($jumlah_jaminan=="")?NULL:$jumlah_jaminan,
				'presentase_jaminan'				=>($presentase_jaminan=="")?NULL:$presentase_jaminan,
				'jumlah_jaminan_sekunder'			=>($jumlah_jaminan_sekunder=="")?NULL:$jumlah_jaminan_sekunder,
				'presentase_jaminan_sekunder'		=>($presentase_jaminan_sekunder=="")?NULL:$presentase_jaminan_sekunder,
				'fa_code'		=>($fa_code=="")?NULL:$fa_code,
				'resort_code'		=>($resort_code=="")?NULL:$resort_code
				);

			if($margin!=""){
				$data['margin'] = $this->convert_numeric($margin);
			}

			if($nisbah_bagihasil!="")
			{
				$data['nisbah_bagihasil'] = $nisbah_bagihasil;
			}

			if($sumber_dana==0)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
			}
			else if($sumber_dana==1)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar;
				$data['kreditur_code']				= $kreditur_code21;
			}
			else if($sumber_dana==2)
			{
				$data['sumber_dana']				= $sumber_dana;
				$data['dana_sendiri']				= $this->convert_numeric($dana_sendiri);
				$data['dana_kreditur']				= $this->convert_numeric($dana_kreditur);
				$data['ujroh_kreditur']				= $ujroh_kreditur;
				$data['ujroh_kreditur_persen']		= $ujroh_kreditur_persen;
				$data['ujroh_kreditur_carabayar']	= $ujroh_kreditur_carabayar2;
				$data['kreditur_code']				= $kreditur_code22;
			}

			if($jenis_program!="")
			{
				$data['program_code']	= $jenis_program;
			}else{
				$data['program_code']	= '';
			}
		}
		$registration_no=$this->input->post('registration_no2');
		$data_reg=array(
			'fa_code'=>$fa_code
			,'resort_code'=>($resort_code=="")?NULL:$resort_code
			,'biaya_administrasi'=>$this->convert_numeric($biaya_administrasi)
			,'biaya_notaris'=>$this->convert_numeric($biaya_notaris)
			// ,'premi_asuransi'=>$this->convert_numeric($biaya_asuransi_jiwa)
		);
		$param_reg=array('registration_no'=>$registration_no);

	    $this->db->trans_begin();
		$this->model_transaction->edit_rekening_pembiayaan($data,$param);
		$this->model_transaction->update_status_pengajuan_pembiayaan($data_reg,$param_reg);
		// print_r($array_data);
		// print_r($param2);
		// die();
		// for ( $i = 0 ; $i < count($array_data) ; $i++ )
		// {
		// 	$this->model_transaction->delete_rekening_pembiayaan_array($param2[$i]);
		// }
		
		// $this->model_transaction->delete_rekening_pembiayaan_array($param2);
		// $this->model_transaction->insert_rekening_pembiayaan_array($array_data);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_ajax_biaya_administrasi()
	{
		$product 				= $this->input->post('product');
		$nilai_pembiayaan 		= $this->input->post('nilai_pembiayaan');
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	= substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	= substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        = substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff 				= abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years 	= floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days 	= floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>=0){
			$years++;
		}

		/*echo $years;
		die();*/

		//$tahun = $years;
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_administrasi($product,$nilai_pembiayaan,$years);

		echo json_encode(array('biaya_administrasi'=>$data));
	}

	public function get_ajax_biaya_premi_asuransi_jiwa()
	{
		$product 				= $this->input->post('product');
		$manfaat 				= $this->input->post('manfaat_asuransi');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('-', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		$usia 					= $this->input->post('usia');
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			= substr("$tanggal_akad",0,2);
	    $bln_akad 			= substr("$tanggal_akad",2,2);
	    $thn_akad	 		= substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	= substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	= substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        = substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;

		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years 	= floor($diff / (365*60*60*24));
		$months	= floor(($diff - ($years * (365*60*60*24))) / (30*60*60*24));
		$days 	= floor(($diff - ($years * (365*60*60*24))) - ($months * (30*60*60*24))/ (60*60*24));
		
		// if($months>0){
			// $years++;
		// }

		// echo $years;
		// echo $months;
		// die();
		
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff 				= abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year 	= floor($difff / (365*60*60*24));
		$month 	= floor(($difff - ($year * (365*60*60*24))) / (30*60*60*24));
		$day 	= floor(($difff - ($year * (365*60*60*24))) - ($month * (30*60*60*24))/ (60*60*24));
		
		// if($month>0){
		// 	$year++;
		// }

		if($tgl_lahir=="")
		{
			$year=$usia;
			$month=0;
		}

		// echo $year;
		// echo $month;
		// die();
		
		/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	public function get_ajax_value_from_cif_no()
	{
		$cif_no 			= $this->input->post('cif_no');
		$data 				= $this->model_transaction->get_ajax_value_from_cif_no($cif_no);
		// $data['tgl_lahir'] 	= $this->format_date_detail($data['tgl_lahir'],'id',false,'/');
		echo json_encode($data);
	}

	public function get_ajax_biaya_premi_asuransi_jiwa2()
	{
		$product 				= $this->input->post('product_ins');
		$manfaat 				= $this->input->post('manfaat');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir = str_replace('/', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad = str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo = str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	=substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	=substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        =substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>0){
			$years++;
		}

		/*echo $years;
		echo $months;
		die();*/
/*
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff = abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year = floor($difff / (365*60*60*24));
		$month = floor(($difff - $year * 365*60*60*24) / (30*60*60*24));
		$day = floor(($difff - $year * 365*60*60*24 - $month*30*60*60*24)/ (60*60*24));
		if($month>0){
			$year++;
		}

		/*echo $year;
		echo $month;
		die();*/
/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	//END REKENING PEMBIAYAAN

	//BEGIN VERIFIKASI REKENING PEMBIAYAAN


	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	

	public function datatable_rekening_ver_pembiayaan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'account_financing_no','mfi_cif.nama','mfi_akad.akad_name','pokok','');
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
			if($sWhere==""){
				$sWhere = " WHERE mfi_account_financing.status_rekening ='0'";
			}else{
				$sWhere .= " AND mfi_account_financing.status_rekening ='0'";
			}

		/*else
		{
			$sWhere = "where mfi_account_financing.status_rekening ='0'";
		}*/
		
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

		$rResult 			= $this->model_transaction->datatable_rekening_ver_pembiayaan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_ver_pembiayaan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_ver_pembiayaan_setup(); // get number of all data
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
			// $row[] = '<input type="checkbox" value="'.$aRow['account_financing_no'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_financing_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['akad_name'];
			$row[] = '<div align="right">Rp '.number_format($aRow['pokok'],0,',','.').',-</div>';
			//$row[] = $aRow['cm_name'];
			$row[] = '<a href="javascript:;" account_financing_no="'.$aRow['account_financing_no'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_rekening_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
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

	public function in_verifikasi_rekening_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
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

	public function verifikasi_rek_pembiayaan()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$cif_no 			  = $this->input->post('cif_no');
		$approve_by			  = $this->session->userdata('user_id');

			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id);

			$data2 = array(
							'status'=>1
						 );
			$param2 = array('cif_no'=>$cif_no);
		
		$this->db->trans_begin();
		$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
		$this->model_transaction->update_status_financing_reg($data2,$param2);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	//END VERIFIKASI REKENING PEMBIAYAAN


	/****************************************************************************************/	
	// BEGIN ASURANSI SETUP
	/****************************************************************************************/
	public function datatable_insurance_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_insurance.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name','mfi_account_insurance.status_rekening');
				
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
		$rResult 			= $this->model_transaction->datatable_insurance_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_insurance_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_insurance_setup(); // get number of all data
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
			$row[] = $aRow['status_rekening'];
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_insurance()
	{
		$product_code_ 		= $this->input->post('product_code');
		$product_code 		=substr("$product_code_",2,3);
		$cif_no 	 		= $this->input->post('cif_no');
		$rate_type	 		= $this->input->post('rate_type');
		if($rate_type==0)
		{
			$benefit_value 		= $this->input->post('benefit_value');
			$awal_kontrak_		= $this->input->post('awal_kontrak0');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak0');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= $this->input->post('premium_rate0');
			$premium_value 		= $this->input->post('premium_value0');
			$plan_code	 		= NULL;
		}
		else if($rate_type==1)
		{
			$benefit_value 		= $this->input->post('benefit_value');
			$awal_kontrak_		= $this->input->post('awal_kontrak0');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak0');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= $this->input->post('premium_rate0');
			$premium_value 		= $this->input->post('premium_value0');
			$plan_code	 		= NULL;
		}
		else if($rate_type==2)
		{
			$benefit_value 		='0';
			$awal_kontrak_		= $this->input->post('awal_kontrak1');
			$akhir_kontrak_		= $this->input->post('akhir_kontrak1');
			$usia_peserta 		= $this->input->post('usia');
			$premium_rate 		= '0';
			$premium_value 		= $this->input->post('premium_value1');
			$plan_code_	 		= $this->input->post('plan_code');
			$plan_code 			=substr("$plan_code_",0,8);
		}

		
		$created_by 		  = $this->session->userdata('user_id');
		$account_insurance_no = $this->input->post('account_no');
		$rekening_tabungan 	  = $this->input->post('rekening_tabungan');
		//$nama_pemegang_rek    = $this->input->post('nama_pemegang_rek');

		$tgl =substr("$awal_kontrak_",0,2);
	    $bln =substr("$awal_kontrak_",2,2);
	    $thn =substr("$awal_kontrak_",4,4);
	    $awal_kontrak = "$thn-$bln-$tgl";  

		$tgl2 =substr("$akhir_kontrak_",0,2);
	    $bln2 =substr("$akhir_kontrak_",2,2);
	    $thn2 =substr("$akhir_kontrak_",4,4);
	    $akhir_kontrak = "$thn2-$bln2-$tgl2"; 

			$data = array(
				'product_code'			=>$product_code,
				'cif_no'				=>$cif_no,
				'benefit_value' 		=>$benefit_value,
				'premium_rate' 			=>$premium_rate,
				'premium_value' 		=>$premium_value,
				'awal_kontrak' 			=>$awal_kontrak,
				'akhir_kontrak' 		=>$akhir_kontrak,
				'plan_code' 			=>$plan_code,
				'created_by' 			=>$created_by,
				'created_date' 			=>date('Y-m-d H:i:s'),
				'usia_peserta' 			=>$usia_peserta,
				'account_insurance_no'	=>$account_insurance_no,
				'account_saving_no'		=>$rekening_tabungan
				);
		

		$this->db->trans_begin();
		$this->model_transaction->add_insurance($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_insurance()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_insurance_id) ; $i++ )
		{
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_insurance($param);
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

	public function get_account_insurance_by_account_insurance_id()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_transaction->get_account_insurance_by_account_insurance_id($account_insurance_id);

		echo json_encode($data);
	}

	public function edit_insurance()
	{
		$smk_id				= $this->input->post('smk_id');
		$sertifikat_no 		= $this->input->post('sertifikat_no2');
		$nama 				= $this->input->post('nama2');
		$nominal 			= $this->input->post('nominal2');
		$status 			= "0";
		$created_by			= $this->session->userdata('user_id2');
		$created_date		= date('Y-m-d H:i:s');
		$status_anggota		= $this->input->post('status_anggota2');
		if ($status_anggota=='0') 
		{			
			$cif_no 		= $this->input->post('cif_no2');
		} 
		else 
		{
			$cif_no = '';
		}
		
		$tanggal_mulai		= $this->input->post('date_issued2');

		$tgl =substr("$tanggal_mulai",0,2);
	    $bln =substr("$tanggal_mulai",2,2);
	    $thn =substr("$tanggal_mulai",4,4);
	    $date_issued = "$thn-$bln-$tgl";  

		$param = array('smk_id'=>$smk_id);

			$data = array(
				'sertifikat_no'		=>$sertifikat_no,
				'nama' 				=>$nama,
				'nominal' 			=>$nominal,
				'date_issued' 		=>$date_issued,
				'status' 			=>$status,				
				'created_by' 		=>$created_by,
				'created_date' 		=>$created_date,
				'status_anggota'	=>$status_anggota,
				'cif_no' 			=>$cif_no
				);
		

		$this->db->trans_begin();
		$this->model_cif->edit_registrasi_smk($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function count_account_no_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->count_account_no_by_product_code($product_code);

		$jumlah = $data['jumlah'];
			if($jumlah==null)
            {
              $total = 0;
            }
            else
            {
              $total = $jumlah;
            }
            $no_urut = $total+1;
            $no_urut_ = sprintf('%03s', $no_urut);            
            $no_urut_account = $product_code.''.$no_urut_;

		echo $no_urut_account;
	}

	public function count_premi_rate_0()
	{
		$benefit_value 	= $this->input->post('benefit_value');
		$rate_type 		= '0';
		$data 			= $this->model_transaction->count_premi_rate_0($rate_type);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function count_premi_rate_1()
	{
		$param = $this->input->post('param');
		$pecah = explode("-", $param);
		$rate_code 		= $pecah[0];
		$usia 			= $pecah[1];
		$kontrak 		= $pecah[2];
		$benefit_value 	= $pecah[3];
		$data 			= $this->model_transaction->count_premi_rate_1($rate_code,$usia,$kontrak);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function count_premi_rate_2()
	{
		$plan_code = $this->input->post('plan_code');
		$data = $this->model_transaction->count_premi_rate_2($plan_code);

		if (count($data)==0) {
			$premium_value = "Tidak Ditemukan";
		} else {		
			$premi = $data['rate'];
			$premium_value = $premi * $benefit_value;
		}

		echo $premium_value;
	}

	public function menghitung_tahun()
	{
		$tanggal = $this->input->post('tanggal');
		$pecah = explode("-", $tanggal);
		$tgl1 = $pecah[0];
		$tgl2 = $pecah[1];

		$date1 = substr($tgl1,0,2);
		$month1 = substr($tgl1,2,2);
		$year1 = substr($tgl1,4,4);


		$date2 =  substr($tgl2,0,2);
		$month2 =  substr($tgl2,2,2);
		$year2 =   substr($tgl2,4,4);

		// menghitung JDN dari masing-masing tanggal

		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);

		// hitung selisih hari kedua tanggal

		$selisih = $jd2 - $jd1;
		$tahun = ceil($selisih/365);

		echo $tahun;
	}

	

	/****************************************************************************************/	
	// END ASURANSI SETUP
	/****************************************************************************************/


	/* BEGIN PENARIKAN TUNAI TABUNGAN *******************************************************/

	public function penarikan_tunai()
	{
		$data['container'] = 'transaction/penarikan_tunai';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function penarikan_tab_angsuran()
	{
		$data['container'] = 'transaction/penarikan_tab_angsuran';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function search_account_saving_no()
	{
		$keyword = $this->input->post('keyword');
		$cif_type = $this->input->post('cif_type');
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_transaction->search_account_saving_no($keyword,$cif_type,$cm_code);

		echo json_encode($data);
	}

	public function search_account_saving_no_active()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_account_saving_no_active($keyword);

		echo json_encode($data);
	}

	public function ajax_get_value_from_account_saving()
	{
		$no_rekening = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_account_saving($no_rekening);

		echo json_encode($data);
	}

	public function ajax_get_value_from_account_saving_status_3()
	{
		$no_rekening = $this->input->post('account_saving_no');
		$data = $this->model_transaction->ajax_get_value_from_account_saving_status_3($no_rekening);

		echo json_encode($data);
	}

	public function proses_pencairan_tabungan()
	{
	    $cif_no = $this->input->post('cif_no');
	    $cif_type = $this->input->post('cif_type');
	    // $nama = $this->input->post('nama');
	    // $product = $this->input->post('product');
	    // $tanggal_transaksi = $this->input->post('tanggal_transaksi');
	    // $tanggal_transaksi = $this->datepicker_convert(true,$tanggal_transaksi,'/');
	    $no_rekening = $this->input->post('no_rekening');
		// $status_rekening = $this->input->post('status_rekening');
	    $no_rekening_individu = $this->input->post('no_rekening_individu');
	    // $status_rekening_individu = $this->input->post('status_rekening_individu');
	    $pencairan_ke = $this->input->post('pencairan_ke');
	    $saldo_memo = $this->input->post('saldo_memo');
	    $saldo_memo = $this->convert_numeric($saldo_memo);
	    $jumlah_penarikan = $this->input->post('jumlah_penarikan');
	    $jumlah_penarikan = $this->convert_numeric($jumlah_penarikan);

	    $cif = $this->model_transaction->get_saldo_tab_sukarela($cif_no);

	    if($pencairan_ke=="PINBUK"){

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
					
					$this->db->trans_begin();
					$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
					$this->model_transaction->update_account_saving($data_saving_tujuan,$param_saving_tujuan); // update tabungan berencana tujuan
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

	    }else if($pencairan_ke=="TUNAI"){
			$data_saving = array('saldo_memo'=>0,'status_rekening'=>2);
			$param_saving = array('account_saving_no'=>$no_rekening);

			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data_saving,$param_saving); // update tabungan berencana & tutup buku
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Pencairan Tabungan Berencana Berhasil!');
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
			}
	    }else{
	    	$return = array('success'=>false,'message'=>'failed to connect into databases, please contact your administrator!');
	    }

	    echo json_encode($return);
	}

	public function ajax_get_rekening_tabungan_berencana_tujuan()
	{
		$cif_no = $this->input->post('cif_no');
		$account_saving_no = $this->input->post('cif_no');
		$rekening = $this->model_transaction->get_rekening_tabungan_berencana_tujuan($cif_no,$account_financing_no);
		echo json_encode($rekening);
	}

	public function proses_penarikan_tunai_tabungan()
	{
		$no_rekening			= $this->input->post('no_rekening');
		$saldo_efektif	 		= $this->convert_numeric($this->input->post('saldo_efektif'));
		$tanggal_transaksi 		= $this->datepicker_convert(true,$this->input->post('tanggal_transaksi'),'/');		
		$jumlah_penarikan 		= $this->convert_numeric($this->input->post('jumlah_penarikan'));
		$no_referensi			= $this->input->post('no_referensi');
		$keterangan				= $this->input->post('keterangan');
		$created_by			  	= $this->session->userdata('user_id');
	    $account_cash_code 		= $this->input->post('account_cash_code');

		$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening);

		$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] - $jumlah_penarikan);
		$param_account_saving   = array('account_saving_no' => $no_rekening);

		$trx_detail_id = uuid(false);

		if ($saldo_efektif>=$jumlah_penarikan)
		{

			$data_trx_account_saving = array(
								'branch_id' 		=> $this->session->userdata('branch_id'),
								'account_saving_no' => $no_rekening,
								'trx_saving_type' 	=> '2',
								'flag_debit_credit' => 'D',
								'trx_date' 			=> $tanggal_transaksi,
								'amount' 			=> $jumlah_penarikan,
								'reference_no' 		=> $no_referensi,
								'description' 		=> $keterangan,
								'created_date' 		=> date('Y-m-d H:i:s'),
								'created_by' 		=> $created_by,
								'trx_detail_id' 	=> $trx_detail_id,
								'account_cash_code' => $account_cash_code
				);

			$data_trx_detail = array(
								'trx_type'			=>'1',
								'trx_account_type' 	=>'2',
								'account_no'		=>$no_rekening,
								// 'account_no_dest'	=>$no_rekening,
								// 'account_type_dest'	=>'2',
								'flag_debit_credit' =>'D',
								'amount' 			=>$jumlah_penarikan,
								'trx_date' 			=>date('Y-m-d'),
								'reference_no' 		=>$no_referensi,
								'description'		=>$keterangan,
								'created_date'		=>date('Y-m-d H:i:s'),
								'created_by' 		=>$created_by,
								'trx_detail_id' 	=> $trx_detail_id			
				);
		
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving_penarikan($data_account_saving,$param_account_saving);
			$this->model_transaction->insert_trx_account_saving_penarikan($data_trx_account_saving);
			$this->model_transaction->insert_trx_detail_penarikan($data_trx_detail);

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				// $return = array('success'=>0);
				$account_saving = $no_rekening;
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$jumlah_penarikan;
				$date_time 		= $tanggal_transaksi.' '.date('H:i:s');
				$return = array('success'=>0,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
		
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>1);
			}
		}
		else if ($saldo_efektif<=$jumlah_penarikan) 
		{
			$return = array('success'=>2);
		}
		
		echo json_encode($return);
	}

	public function proses_penarikan_tabungan_angsuran()
	{
		//*** SET VAR TABUNGAN
		$no_rekening			= $this->input->post('no_rekening');
		$saldo_efektif	 		= $this->convert_numeric($this->input->post('saldo_efektif'));
		$tanggal_transaksi 		= $this->datepicker_convert(true,$this->input->post('tanggal_transaksi'),'/');		
		$jumlah_penarikan 		= $this->convert_numeric($this->input->post('jumlah_penarikan'));
		$no_referensi			= ($this->input->post('no_referensi')) ? $this->input->post('no_referensi') : 0;
		$keterangan				= $this->input->post('keterangan');
		$created_by			  	= $this->session->userdata('user_id');
	    $account_cash_code 		= $this->input->post('account_cash_code');
	    //*** END SET

	    //*** SET VAR ANGSURAN
	    $account_financing_id 			= $this->input->post('account_financing_id');
		$account_financing_schedulle_id = $this->input->post('account_financing_schedulle_id');
		$account_saving_id 	  			= "";
		$branch_id 		 	  			= $this->input->post('branch_id');
		$nama				  			= $this->input->post('nama');
		$produk				  			= $this->input->post('product_code');
		$pokok_pembiayaan 	  			= $this->convert_numeric($this->input->post('pokok_pembiayaan'));
		$margin_pembiayaan 	  			= $this->convert_numeric($this->input->post('margin_pembiayaan'));
		$jangka_waktu 		  			= $this->input->post('jangka_waktu');
		$pokok				  			= $this->convert_numeric($this->input->post('pokok'));
		$margin				  			= $this->convert_numeric($this->input->post('margin'));
		$cadangan_tabungan 	  			= 0;
		$total_angsuran 	  			= $jumlah_penarikan;
		$jtempo_angsuran 	  			= $this->input->post('jtempo_angsuran');
		$no_rek_tabungan 	  			= 0;
		$freq_pembayaran 	  			= $this->input->post('freq_pembayaran');
		$nominal_pembayaran   			= $jumlah_penarikan;
		$tgl_bayar 			  			= $this->input->post('tanggal_transaksi');
		$keterangan_angs 	  			= $this->input->post('keterangan_angs');
		$saldo_pokok 		  			= $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_catab 		  			= 0;
		$saldo_margin 		  			= $this->convert_numeric($this->input->post('saldo_margin'));
		$periode_jangka_waktu 			= $this->input->post('periode');
		$bayar_pokok 		  			= $this->convert_numeric($this->input->post('bayar_pokok'));
		$bayar_margin 		  			= $this->convert_numeric($this->input->post('bayar_margin'));
		$bayar_pokok_before   			= $this->input->post('bayar_pokok_before');
		$bayar_margin_before  			= $this->input->post('bayar_margin_before');
		$account_cash_code_angs			= $this->input->post('account_cash_code_angs');
		$account_financing_no 			= $this->input->post('account_financing_no');
		$product_code 					= $this->input->post('kode_produk');

		$tgl_jtempo 		  = substr("$jtempo_angsuran",0,2);
	    $bln_jtempo 		  = substr("$jtempo_angsuran",3,2);
	    $thn_jtempo 		  = substr("$jtempo_angsuran",6,4);
	    $tglakhir_jtempo 	  = "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

		$tanggal_bayar 		  = substr("$tgl_bayar",0,2);
	    $bulan_bayar 		  = substr("$tgl_bayar",3,2);
	    $tahun_bayar 		  = substr("$tgl_bayar",6,4);
	    $tglakhir_bayar 	  = "$tahun_bayar-$bulan_bayar-$tanggal_bayar"; 

	    $get_data_financing 	= $this->model_transaction->get_account_financing_by_account_financing_no($no_rekening);
		$jtempo_angsuran_last 	= $get_data_financing['jtempo_angsuran_last'];
		$jtempo_angsuran_next 	= $get_data_financing['jtempo_angsuran_next'];
		$tgl_angs_last 			= $jtempo_angsuran_last;
		$tgl_angs_next 			= $jtempo_angsuran_next;
		$counter_angsuran 		= $get_data_financing['counter_angsuran'];
		$jangka_wkatu 			= $get_data_financing['jangka_waktu'];
		$total_angsuran2        = 0;
		$angsuran_ke 			= $counter_angsuran;
		//*** END SET

		$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening);

		$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] - $jumlah_penarikan);
		$param_account_saving   = array('account_saving_no' => $no_rekening);

		$trx_detail_id = uuid(false);
		if ($saldo_efektif>=$jumlah_penarikan)
		{
			//*** PROCESS PENARIKAN TABUNGAN ***//
			$data_trx_account_saving = array(
											'branch_id' 		=> $this->session->userdata('branch_id'),
											'account_saving_no' => $no_rekening,
											'trx_saving_type' 	=> '2',
											'flag_debit_credit' => 'D',
											'trx_date' 			=> $tanggal_transaksi,
											'amount' 			=> $jumlah_penarikan,
											'reference_no' 		=> $no_referensi,
											'description' 		=> $keterangan,
											'created_date' 		=> date('Y-m-d H:i:s'),
											'created_by' 		=> $created_by,
											'trx_detail_id' 	=> $trx_detail_id,
											'account_cash_code' => $account_cash_code
										);
			$data_trx_detail = array(
									'trx_type'			=>'1',
									'trx_account_type' 	=>'2',
									'account_no'		=>$no_rekening,
									'flag_debit_credit' =>'D',
									'amount' 			=>$jumlah_penarikan,
									'trx_date' 			=>date('Y-m-d'),
									'reference_no' 		=>$no_referensi,
									'description'		=>$keterangan,
									'created_date'		=>date('Y-m-d H:i:s'),
									'created_by' 		=>$created_by,
									'trx_detail_id' 	=> $trx_detail_id			
								);
			//*** END PROCESS PENARIKAN TABUNGAN ***//

			if(in_array($product_code, array(53, 54, 56))){

				$bayar_saldo_pokok = $this->input->post('bayar_saldo_pokok');
				$bayar_saldo_margin = $this->input->post('bayar_saldo_margin');

				if($bayar_saldo_pokok == ''){

					$this->db->trans_rollback();
					$return = array('success'=>1);

				}else{

					$get_data_financing = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);
					$trx_gl_id = uuid(false);

					if($get_data_financing['saldo_pokok']>=$jumlah_penarikan)
					{
						$param_account_financing = array('account_financing_no' => $account_financing_no);
						$data_account_financing = array(
				    			'saldo_pokok' => $get_data_financing['saldo_pokok']-$jumlah_penarikan,
				    			// 'saldo_margin' => $get_data_financing['saldo_margin'],
				    		);

						$data_trx_gl = array(
								'trx_gl_id' => $trx_gl_id,
								'trx_date' 	=> $tanggal_transaksi,
								'voucher_date' => $tanggal_transaksi,
								'voucher_ref' => $account_financing_no,
								'branch_code' => $account_cash_code_angs,
								'created_by' => $this->session->userdata('user_id'),
								'jurnal_trx_type' => 0,
								'description' => $keterangan_angs,
								'created_date' => date('Y-m-d H:i:s')
							);

						// HANYA POTONG SALDO POKOK
						$data_trx_gl_detail_1 = array(
								'trx_gl_id' => $trx_gl_id,
								'account_code' => $account_cash_code_angs,
								'flag_debit_credit' => 'D',
								'amount' => $jumlah_penarikan,
								'description' => $keterangan_angs,
								'trx_sequence' => '0'
							);

						$data_trx_gl_detail_2 = array(
								'trx_gl_id' => $trx_gl_id,
								'account_code' => ($product_code == '53' || $product_code == '54') ? '12141' : '12131',
								'flag_debit_credit' => 'C',
								'amount' => $jumlah_penarikan,
								'description' => $keterangan_angs,
								'trx_sequence' => '1'
							);
						// END

						$this->model_transaction->update_account_financing($data_account_financing,$param_account_financing);
						$this->model_transaction->insert_trx_gl($data_trx_gl);
						$this->model_transaction->insert_mfi_trx_gl_detail($data_trx_gl_detail_1);
						$this->model_transaction->insert_mfi_trx_gl_detail($data_trx_gl_detail_2);
					
					}else{
						$this->db->trans_rollback();
						$return = array('success'=>2);
					}

				}

			}else{
				//*** PROSES ANGSURAN ***//
				for($i=1;$i<=$freq_pembayaran;$i++)
			    {
			    	$angsuran_ke++;
			    	$get_data_financing2 = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no);

			    	$saldo_pokok = $get_data_financing2['saldo_pokok'];
					$saldo_margin = $get_data_financing2['saldo_margin'];
					$saldo_catab = $get_data_financing2['saldo_catab'];
					
					$total_angsuran2+=$total_angsuran;

					$counter_angsuran++;
			    	if($jangka_waktu==$counter_angsuran){
			    		$pokok=$saldo_pokok;
			    	}

					if($periode_jangka_waktu=='0'){
						$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 days'));
						$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 days'));
					}else if($periode_jangka_waktu=='1'){
						$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 weeks'));
						$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 weeks'));
					}else if($periode_jangka_waktu=='2'){
						$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 months'));
						$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 months'));
					}

					$flag_jdwl_angsuran = $this->model_transaction->get_flag_jadwal($account_financing_id);

					$trx_detail_id = uuid(false);
					$trx_account_financing_id=uuid(false);

					if($flag_jdwl_angsuran=='1'){

						/* trx detail */
						$trx_sequence = $this->model_transaction->get_trx_sequence($account_financing_no);
						$arr_trx_detail = array(
							 'trx_detail_id'		=>$trx_detail_id
							,'trx_summary_id'		=>''
							,'trx_type'				=>3
							,'trx_account_type'		=>1
							,'account_no'			=>$account_financing_no
							,'flag_debit_credit'	=>'D'
							,'amount'				=>$total_angsuran
							,'trx_date'				=>$tglakhir_bayar
							,'reference_no'			=>''
							,'description'			=>$keterangan_angs
							,'created_by'			=>$this->session->userdata('user_id')
							,'created_date'			=>date("Y-m-d H:i:s")
							,'trx_sequence'			=>$trx_sequence
						);

						/*trx account financing*/
						$arr_trx_account_financing = array(
							 'branch_id'			=>$branch_id
							,'trx_account_financing_id'=>$trx_account_financing_id
							,'trx_detail_id'		=>$trx_detail_id
							,'account_financing_no'	=>$account_financing_no
							,'trx_financing_type'	=>'1'
							,'trx_date'				=>$tglakhir_bayar
							,'jto_date'				=>$tgl_angs_last
							,'pokok'				=>$pokok
							,'margin'				=>$margin
							,'catab'				=>$cadangan_tabungan
							,'reference_no'			=>$no_rek_tabungan
							,'description'			=>$keterangan_angs
							,'created_date'			=>date("Y-m-d H:i:s")
							,'created_by'			=>$this->session->userdata('user_id')
							,'trx_sequence'			=>0
							,'tab_wajib'			=>0
							,'tab_sukarela'			=>0
							,'freq'					=>1
							,'trx_status'			=>0
							,'angsuran_ke'			=>$angsuran_ke
							,'account_cash_code'	=>$account_cash_code_angs
							,'tipe_angsuran'		=>'3'
						);

					}else{

						/* trx detail */
						$trx_sequence = $this->model_transaction->get_trx_sequence($account_financing_no);
						$arr_trx_detail = array(
							 'trx_detail_id'		=>$trx_detail_id
							,'trx_summary_id'		=>''
							,'trx_type'				=>3
							,'trx_account_type'		=>1
							,'account_no'			=>$account_financing_no
							,'flag_debit_credit'	=>''
							,'amount'				=>$bayar_pokok+$bayar_margin
							,'trx_date'				=>$tglakhir_bayar
							,'reference_no'			=>''
							,'description'			=>$keterangan_angs
							,'created_by'			=>$this->session->userdata('user_id')
							,'created_date'			=>date("Y-m-d H:i:s")
							,'account_no_dest'		=>$no_rek_tabungan
							,'trx_sequence'			=>$trx_sequence
							,'account_type_dest'	=>1
						);
						
						/* trx account financing */
						$arr_trx_account_financing = array(
							 'branch_id'			=>$branch_id
							,'trx_account_financing_id'=>$trx_account_financing_id
							,'trx_detail_id'		=>$trx_detail_id
							,'account_financing_no'	=>$account_financing_no
							,'trx_financing_type'	=>'1'
							,'trx_date'				=>$tglakhir_bayar
							,'jto_date'				=>$tgl_angs_last
							,'pokok'				=>$bayar_pokok
							,'margin'				=>$bayar_margin
							,'catab'				=>$cadangan_tabungan
							,'reference_no'			=>$no_rek_tabungan
							,'description'			=>$keterangan_angs
							,'created_date'			=>date("Y-m-d H:i:s")
							,'created_by'			=>$this->session->userdata('user_id')
							,'trx_sequence'			=>0
							,'tab_wajib'			=>0
							,'tab_sukarela'			=>0
							,'freq'					=>1
							,'trx_status'			=>0
							,'angsuran_ke'			=>$angsuran_ke
							,'account_cash_code'	=>$account_cash_code_angs
							,'tipe_angsuran'		=>'3'
						);

					}

				}
				//*** END PROSES ANGSURAN ***//

				//*** ANGSURAN TRX
				$this->db->insert('mfi_trx_account_financing',$arr_trx_account_financing);
				$this->model_transaction->insert_on_mfi_trx_detail($arr_trx_detail);
				//*** END ANGSURAN TRX
			}

			$this->db->trans_begin();
			//*** TABUNGAN TRX
			$this->model_transaction->update_account_saving_penarikan($data_account_saving,$param_account_saving);
			$this->model_transaction->insert_trx_account_saving_penarikan($data_trx_account_saving);
			$this->model_transaction->insert_trx_detail_penarikan($data_trx_detail);
			//*** END TABUNGAN TRX

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				
				$account_saving = $no_rekening;
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$jumlah_penarikan;
				$date_time 		= $tanggal_transaksi.' '.date('H:i:s');
				$return = array('success'=>0,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
		
			}else{

				$this->db->trans_rollback();
				$return = array('success'=>1);

			}
		}
		else if ($saldo_efektif<=$jumlah_penarikan) 
		{
			$return = array('success'=>2);
		}
		
		echo json_encode($return);
	}

	public function check_no_referensi()
	{
		$no_referensi = $this->input->post('no_referensi');

		$no_referensi_validation = $this->model_transaction->check_no_referensi($no_referensi);

		if($no_referensi_validation==true){
			$return = array('success'=>true,'message'=>'No Referensi Bisa Dipakai');
		}else{
			$return = array('success'=>false,'message'=>'No Referensi Sudah Ada');
		}

		echo json_encode($return);

	}

	public function datatable_penarikan_tunai_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'c.cif_no','c.nama','a.account_saving_no','a.amount','a.trx_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_penarikan_tunai_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_penarikan_tunai_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_penarikan_tunai_tabungan(); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini red" trx_detail_id="'.$aRow['trx_detail_id'].'" nama="'.$aRow['nama'].'" account_saving_no="'.$aRow['account_saving_no'].'" id="link-delete">Delete</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_penarikan_tunai_by_id()
	{
		$trx_account_saving_id = $this->input->post('trx_account_saving_id');
		$data = $this->model_transaction->get_penarikan_tunai_by_id($trx_account_saving_id);

		echo json_encode($data);
	}

	public function update_penarikan_tunai_tabungan()
	{
		$trx_account_saving_id 	= $this->input->post('trx_account_saving_id');
		$trx_detail_id 		    = $this->input->post('trx_detail_id');
		$no_rekening			= $this->input->post('no_rekening');
		$saldo_efektif	 		= $this->convert_numeric($this->input->post('saldo_efektif'));
		//$tanggal_transaksi 		= $this->input->post('tanggal_transaksi');		
		$jumlah_penarikan 		= $this->convert_numeric($this->input->post('jumlah_penarikan'));
		$no_referensi			= $this->input->post('no_referensi');
		$keterangan				= $this->input->post('keterangan');
		$created_by			  	= $this->session->userdata('fullname');

		$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening);

		$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] - $jumlah_penarikan);
		$param_account_saving   = array('account_saving_no' => $no_rekening);

		if ($saldo_efektif>=$jumlah_penarikan)
		{

			$data_trx_account_saving = array(
								'branch_id' 		=> $this->session->userdata('branch_id'),
								'account_saving_no' => $no_rekening,
								'trx_saving_type' 	=> '2',
								'flag_debit_credit' => 'D',
								'trx_date' 			=> date('Y-m-d'),
								'amount' 			=> $jumlah_penarikan,
								'reference_no' 		=> $no_referensi,
								'description' 		=> $keterangan,
								'created_date' 		=> date('Y-m-d H:i:s'),
								'created_by' 		=> $this->session->userdata('fullname')
				);

			$param_trx_account_saving = array('trx_account_saving_id'=>$trx_account_saving_id);

			$data_trx_detail = array(
								'trx_type'			=>'1',
								'trx_account_type' 	=>'2',
								'account_no'		=>$no_rekening,
								// 'account_no_dest'	=>$no_rekening,
								// 'account_type_dest'	=>'2',
								'flag_debit_credit' =>'D',
								'amount' 			=>$jumlah_penarikan,
								'trx_date' 			=>date('Y-m-d'),
								'reference_no' 		=>$no_referensi,
								'description'		=>$keterangan,
								'created_date'		=>date('Y-m-d H:i:s'),
								'created_by' 		=>$created_by,
								'trx_detail_id' 	=> $trx_detail_id				
				);

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);
		
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving_penarikan($data_account_saving,$param_account_saving);
			$this->model_transaction->update_trx_account_saving_penarikan($data_trx_account_saving,$param_trx_account_saving);
			$this->model_transaction->update_trx_detail_penarikan($data_trx_detail,$param_trx_detail);

			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>0);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>1);
			}
		}
		else if ($saldo_efektif<=$jumlah_penarikan) 
		{
			$return = array('success'=>2);
		}
		
		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END PENARIKAN TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SETORAN TUNAI TABUNGAN
	/****************************************************************************************/
	public function setoran_tunai()
	{
		$data['container'] = 'transaction/setoran_tunai';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function datatable_setor_tunai_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'c.cif_no','c.nama','a.account_saving_no','a.amount','a.trx_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_setor_tunai_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_setor_tunai_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_setor_tunai_tabungan(); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['account_saving_no'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = '<div align="center"><a href="javascript:;" class="btn red mini" trx_detail_id="'.$aRow['trx_detail_id'].'" account_saving_no="'.$aRow['account_saving_no'].'" nama="'.$aRow['nama'].'" id="link-delete">Delete</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_cif_by_account_saving()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('cif_type');
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_transaction->search_cif_by_account_saving($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	public function search_cif_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_cif_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function add_setoran_tunai($arrdata=null)
	{
		$account_saving_no 	= !empty($this->input->post('account_saving_no')) ? $this->input->post('account_saving_no') : $arrdata['account_saving_no'];
		$amount 			= !empty($this->input->post('jumlah_setoran')) ? $this->convert_numeric($this->input->post('jumlah_setoran')) : $arrdata['jumlah_setoran'];
		$reference_no 		= !empty($this->input->post('no_referensi')) ? $this->input->post('no_referensi') : $arrdata['no_referensi'];
		$description 		= !empty($this->input->post('keterangan')) ? $this->input->post('keterangan') : @$arrdata['keterangan'];
		$trx_date 			= !empty($this->input->post('tgl_trx')) ? $this->datepicker_convert(true,$this->input->post('tgl_trx'),'/') : $arrdata['tgl_trx'];
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');
		$account_cash_code 	= !empty($this->input->post('account_cash_code')) ? $this->input->post('account_cash_code') : '11104';

		$trx_detail_id = uuid(false);

			//aray untuk input ke table mfi_trx_detail
			$data_trx_detail = array(				
				'trx_detail_id'		=>$trx_detail_id,		
				'trx_type'			=>'1',
				'trx_account_type' 	=>'1',
				'account_no'		=>$account_saving_no,
				'flag_debit_credit' =>'C',
				'amount' 			=>$amount,
				'trx_date' 			=>$trx_date,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_by' 		=>$created_by,
				'created_date' 		=> date('Y-m-d H:i:s')
				// 'account_no_dest' 	=> $account_saving_no,
				// 'account_type_dest' => '1'
				);

			//aray untuk input ke table mfi_trx_account_saving
			$data_trx_account_saving = array(				
				'branch_id'			=>$branch_id ,
				'account_saving_no' =>$account_saving_no,
				'trx_saving_type' 	=>'1',
				'flag_debit_credit' =>'C',
				'trx_date' 			=>$trx_date,
				'amount' 			=>$amount,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=>$created_by,
				'trx_detail_id' 	=> $trx_detail_id,
				'account_cash_code' => $account_cash_code
				);

			//parameter update
			$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] + $amount);
			$param_account_saving   = array('account_saving_no' => $account_saving_no);
		

		$this->db->trans_begin();
		$this->model_transaction->add_setoran_tunai_account_saving($data_trx_account_saving);
		$this->model_transaction->add_setoran_tunai_detail($data_trx_detail);
		$this->model_transaction->update_setoran_tunai_account_saving($data_account_saving,$param_account_saving);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
				$account_saving = $account_saving_no;
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$amount;
				$date_time 		= $trx_date.' '.date('H:i:s');
			$return = array('success'=>true,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		if(!empty($this->input->post('account_saving_no'))){
			echo json_encode($return);
		}
	}

	public function get_setor_tunai_by_id()
	{
		$trx_account_saving_id = $this->input->post('trx_account_saving_id');
		$data = $this->model_transaction->get_setor_tunai_by_id($trx_account_saving_id);

		echo json_encode($data);
	}

	public function edit_setoran_tunai()
	{
		$trx_account_saving_id 	= $this->input->post('trx_account_saving_id');
		$trx_detail_id 		= $this->input->post('trx_detail_id');
		$account_saving_no 	= $this->input->post('account_saving_no');
		$amount 			= $this->convert_numeric($this->input->post('jumlah_setoran'));
		$reference_no 		= $this->input->post('no_referensi');
		$description 		= $this->input->post('keterangan');
		$trx_date 			= $this->datepicker_convert(true,$this->input->post('tgl_trx'),'/');
		$created_by 		= $this->session->userdata('user_id');
		$branch_id 			= $this->session->userdata('branch_id');
		$nama 				= $this->session->userdata('nama');

			//aray untuk input ke table mfi_trx_detail
			$data_trx_detail = array(				
				'trx_type'			=>'1',
				'trx_account_type' 	=>'1',
				'account_no'		=>$account_saving_no,
				'flag_debit_credit' =>'C',
				'amount' 			=>$amount,
				'trx_date' 			=>$trx_date,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_by' 		=>$created_by,
				'created_date' 		=> date('Y-m-d H:i:s')
				// 'account_no_dest' 	=> $account_saving_no,
				// 'account_type_dest' => '1'
				);

			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);

			//aray untuk input ke table mfi_trx_account_saving
			$data_trx_account_saving = array(				
				'branch_id'			=>$branch_id,
				'account_saving_no' =>$account_saving_no,
				'trx_saving_type' 	=>'1',
				'flag_debit_credit' =>'C',
				'trx_date' 			=>$trx_date,
				'amount' 			=>$amount,
				'reference_no' 		=>$reference_no,
				'description' 		=>$description,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=>$created_by,
				'trx_detail_id' 	=> $trx_detail_id
				);

			$param_trx_account_saving = array('trx_account_saving_id'=>$trx_account_saving_id);

			//parameter update
			$dataaccsaving 			= $this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$data_account_saving 	= array('saldo_memo' => $dataaccsaving['saldo_memo'] + $amount);
			$param_account_saving   = array('account_saving_no' => $account_saving_no);
		

		$this->db->trans_begin();
		$this->model_transaction->update_setoran_tunai_trx_account_saving($data_trx_account_saving,$param_trx_account_saving);
		$this->model_transaction->update_setoran_tunai_detail($data_trx_detail,$param_trx_detail);
		$this->model_transaction->update_setoran_tunai_account_saving($data_account_saving,$param_account_saving);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
				$account_saving = $account_saving_no;
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$amount;
				$date_time 		= $trx_date.' '.date('H:i:s');
			$return = array('success'=>true,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	/****************************************************************************************/	
	// END SETORAN TUNAI TABUNGAN
	/****************************************************************************************/


	/*****************************************************************************************/
	// PIBUK
	/*****************************************************************************************/

	public function pinbuk()
	{
		$data['container'] = 'transaction/pinbuk';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function get_no_rekening_pinbuk_sumber()
	{
		$keyword = $this->input->post('keyword');
		$no_rekening_tujuan = $this->input->post('no_rekening_tujuan');

		$data = $this->model_transaction->get_no_rekening_pinbuk_sumber($keyword,$no_rekening_tujuan);

		echo json_encode($data);
	}

	public function get_no_rekening_pinbuk_tujuan()
	{
		$keyword = $this->input->post('keyword');
		$no_rekening_sumber = $this->input->post('no_rekening_sumber');

		$data = $this->model_transaction->get_no_rekening_pinbuk_tujuan($keyword,$no_rekening_sumber);

		echo json_encode($data);
	}

	public function process_pinbuk()
	{
		$no_rekening_sumber 		= $this->input->post('no_rekening_sumber');
		$nama_sumber				= $this->input->post('nama_sumber');
		$produk_sumber 				= $this->input->post('produk_sumber');
		$saldo_efektif_sumber 		= $this->convert_numeric($this->input->post('saldo_efektif_sumber'));

		$no_rekening_tujuan 		= $this->input->post('no_rekening_tujuan');
		$nama_tujuan				= $this->input->post('nama_tujuan');
		$produk_tujuan 				= $this->input->post('produk_tujuan');

		$tanggal_efektif_transaksi 	= $this->input->post('tanggal_efektif_transaksi');
		$tanggal_efektif_transaksi = str_replace('/', '', $tanggal_efektif_transaksi);
		$tanggal_efektif_transaksi  = substr($tanggal_efektif_transaksi,4,4).'-'.substr($tanggal_efektif_transaksi,2,2).'-'.substr($tanggal_efektif_transaksi,0,2);
		$jumlah_pinbuk_transaksi 	= $this->convert_numeric($this->input->post('jumlah_pinbuk_transaksi'));
		$no_referensi_transaksi 	= ($this->input->post('no_referensi_transaksi')=="")?NULL:$this->input->post('no_referensi_transaksi');
		$keterangan_transaksi 		= $this->input->post('keterangan_transaksi');

		$dataaccsavingsumber = $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening_sumber);
		$dataaccsavingtujuan = $this->model_transaction->get_account_saving_by_account_saving_no($no_rekening_tujuan);

		$data_account_saving_sumber = array('saldo_memo' => $dataaccsavingsumber['saldo_memo'] - $jumlah_pinbuk_transaksi);
		$param_account_saving_sumber = array('account_saving_no' => $no_rekening_sumber);

		$data_account_saving_tujuan = array('saldo_memo' => $dataaccsavingtujuan['saldo_memo'] + $jumlah_pinbuk_transaksi);
		$param_account_saving_tujuan = array('account_saving_no' => $no_rekening_tujuan);

		// print_r($data_account_saving_sumber);
		// print_r($data_account_saving_tujuan);
		// die();
		$trx_detail_id = uuid(false);

		// DEBIT
		$data_trx_account_saving1 = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rekening_sumber,
				'trx_saving_type' => 3,
				'flag_debit_credit' => 'D',
				'trx_date' => $tanggal_efektif_transaksi,
				'amount' => $jumlah_pinbuk_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => 'TRX TABUNGAN#PINBUK KELUAR ACCT.'.$no_rekening_sumber.' ('.$nama_sumber.') KE ACCT.'.$no_rekening_tujuan.' ('.$nama_tujuan.')',
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
				'trx_detail_id' => $trx_detail_id
			);

		// CREDIT
		$data_trx_account_saving2 = array(
				'branch_id' => $this->session->userdata('branch_id'),
				'account_saving_no' => $no_rekening_tujuan,
				'trx_saving_type' => 4,
				'flag_debit_credit' => 'C',
				'trx_date' => $tanggal_efektif_transaksi,
				'amount' => $jumlah_pinbuk_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => 'TRX TABUNGAN#PINBUK MASUK ACCT.'.$no_rekening_tujuan.' ('.$nama_tujuan.') DARI ACCT.'.$no_rekening_sumber.' ('.$nama_sumber.')',
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
				'trx_detail_id' => $trx_detail_id
			);

		$data_trx_detail = array(
				'trx_detail_id' => $trx_detail_id,
				'trx_type' => 1,
				'trx_account_type' => 3,
				'account_no' => $no_rekening_sumber,
				'flag_debit_credit' => 'D',
				'amount' => $jumlah_pinbuk_transaksi,
				'trx_date' => $tanggal_efektif_transaksi,
				'reference_no' => $no_referensi_transaksi,
				'description' => $keterangan_transaksi,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s'),
				'account_no_dest' => $no_rekening_tujuan,
				'account_type_dest' => 4
			);

		$this->db->trans_begin();

		$this->model_transaction->update_account_saving($data_account_saving_sumber,$param_account_saving_sumber); // DEBIT
		$this->model_transaction->update_account_saving($data_account_saving_tujuan,$param_account_saving_tujuan); // CREDIT

		$this->model_transaction->insert_trx_account_saving($data_trx_account_saving1); // DEBIT
		$this->model_transaction->insert_trx_account_saving($data_trx_account_saving2); // KREDIT

		$this->model_transaction->insert_trx_detail($data_trx_detail);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);

	}

	public function datatable_pinbuk_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'a.account_no','a.account_no_dest','a.amount','a.trx_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_pinbuk_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pinbuk_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pinbuk_tabungan(); // get number of all data
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
			$row[] = $aRow['no_rek_tabungan_sumber'].'-'.$aRow['nama_tabungan_sumber'];
			$row[] = $aRow['no_rek_tabungan_tujuan'].'-'.$aRow['nama_tabungan_tujuan'];
			$row[] = '<div align="right">Rp '.number_format($aRow['amount'],0,',','.').',-</div>';
			$row[] = '<div align="center">'.$this->format_date_detail($aRow['trx_date'],'id',false,'/').'</div>';
			$row[] = '<div align="center"><a href="javascript:;" trx_detail_id="'.$aRow['trx_detail_id'].'" no_rek_tabungan_sumber="'.$aRow['no_rek_tabungan_sumber'].'" nama_tabungan_sumber="'.$aRow['nama_tabungan_sumber'].'" id="link-delete" class="btn mini red">Delete</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	/****************************************************************************************/	
	// BEGIN REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/
	public function search_cif_by_account_deposit()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_cif_by_account_deposit($keyword);

		echo json_encode($data);
	}

	public function search_cif_by_account_deposit_no()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$data = $this->model_transaction->search_cif_by_account_deposit_no($account_deposit_no);

		echo json_encode($data);
	}

	public function search_name_by_account_saving_no()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_name_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}


	public function search_name_by_account_saving_no_klaim()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$data = $this->model_transaction->search_name_by_account_saving_no($account_saving_no);

		echo json_encode($data);
	}

	public function reg_pencairan_deposito()
	{
		$account_deposit_no = $this->input->post('account_deposit_no');
		$trx_date	 		= date('Y-m-d');
		$created_date	 	= date('Y-m-d H:i:s');
		$account_saving_no  = $this->input->post('account_saving_no');
		$created_by 		= $this->session->userdata('user_id');

			//aray untuk update status rekening deposito
			$data_pencairan_deposito = array(				
				'status_rekening'	=>'3'
				);
			$param_pencairan_deposito   = array('account_deposit_no' => $account_deposit_no);

			//aray untuk insert ke tabel deposite_break
			$data_deposito_break = array(	
				'account_deposit_no'	=>$account_deposit_no,	
				'trx_date'				=>$trx_date,	
				'account_saving_no'		=>$account_saving_no,	
				'created_by'			=>$created_by,	
				'created_date'			=>$created_date,	
				'status_break'			=>'0'
				);
		

		$this->db->trans_begin();

		$this->model_transaction->update_pencairan_deposito($data_pencairan_deposito,$param_pencairan_deposito); // UPDATE
		$this->model_transaction->insert_deposito_break($data_deposito_break); // INSERT
		
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
	// END REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	/*REGISTRASI REKENING PEMBIAYAAN *******************************************************/
	public function datatable_rekening_ver_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','account_deposit_no','mfi_cif.nama','nominal','jangka_waktu','');
		$cm_code = @$_GET['cm_code'];
				
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
			$sWhere = "where mfi_account_deposit.status_rekening ='0'";
		}

		if($sWhere==""){
			$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		}else{
			$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
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

		$rResult 			= $this->model_transaction->datatable_rekening_ver_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_rekening_ver_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_rekening_ver_deposito_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['nominal'],0,',','.').',-</div>';
			$row[] = $aRow['jangka_waktu']." Bulan";
			$row[] = '<a href="javascript:;" account_deposit_id="'.$aRow['account_deposit_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_rekening_deposito()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
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

	public function in_verifikasi_rekening_deposito()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$approve_by			  = $this->session->userdata('fullname');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$approve_by,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_financing_id'=>$account_financing_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_pembiayaan($data,$param);
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

	public function verifikasi_rek_deposito()
	{
		$account_deposit_id 		= $this->input->post('account_deposit_id');
		$account_saving_no			= $this->input->post('rek_bagi_hasil');
		$no_rekening				= $this->input->post('no_rekening');
		$nominal 					= $this->input->post('nominal');
		$saldo_memo_account_saving 	= $this->input->post('saldo_memo');
		$approve_by			  		= $this->session->userdata('user_id');
		$saldo_memo 				= $saldo_memo_account_saving-$nominal;
		$trx_detail_id 				= uuid(false);
		$created_by 				= $this->session->userdata('user_id');
		$created_date		  		= date('Y-m-d H:i:s');
		$date_current 				= $this->model_transaction->get_date_current();

		
			$data 				= array(
									'status_rekening'=>1,
									'verify_by'	 	 =>$approve_by,
									'verify_date'	 =>date('Y-m-d H:i:s')
								 );
			$param 				= array('account_deposit_id'=>$account_deposit_id);

			$data2 				= array('saldo_memo'=>$saldo_memo);
			$param2 			= array('account_saving_no'=>$account_saving_no);

			$data_trx_detail 	= array(
									'trx_detail_id'		=>$trx_detail_id,
									'trx_account_type'  =>'0',
									'account_type_dest' =>'3',
									'trx_type' 			=>'2',
									'account_no'		=>$no_rekening,
									'flag_debit_credit'	=>'C',
									'amount'			=>$this->convert_numeric($nominal),
									'trx_date'			=>$date_current,
									'account_no_dest'	=>$account_saving_no,
									'created_by'		=>$created_by,
									'created_date' 		=>$created_date
								  );

			$data_trx_account_deposit = array(
										'account_deposit_no'	=>$no_rekening,
										'trx_deposit_type' 		=>'0',
										'trx_date'				=>$date_current,
										'amount' 				=>$this->convert_numeric($nominal),
										'created_by'			=>$created_by,
										'created_date' 			=>$created_date,
										'trx_detail_id'			=>$trx_detail_id
										);

			$data_trx_account_saving = array(
										'branch_id' 		=> $this->session->userdata('branch_id'),
										'account_saving_no' => $account_saving_no,
										'trx_saving_type' 	=> '3',
										'flag_debit_credit' => 'C',
										'trx_date' 			=> $date_current,
										'amount' 			=> $this->convert_numeric($nominal),
										// 'description' 		=> $keterangan,
										'created_date' 		=> date('Y-m-d H:i:s'),
										'created_by' 		=> $this->session->userdata('user_id'),
										'trx_detail_id' 	=> $trx_detail_id
										);
 		
		$this->db->trans_begin();
		$this->model_transaction->verifikasi_rek_deposito($data,$param);
		$this->model_transaction->update_saldo_memo_from_account_saving($data2,$param2);
		$this->model_transaction->insert_mfi_trx_detail($data_trx_detail);
		$this->model_transaction->insert_mfi_trx_account_deposit($data_trx_account_deposit);
		$this->model_transaction->insert_mfi_trx_account_saving($data_trx_account_saving);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function delete_rek_deposito()
	{
		$account_deposito_id = $this->input->post('account_deposit_id');

		
			$param = array('account_deposit_id'=>$account_deposito_id);
			$this->db->trans_begin();
			$this->model_transaction->delete_rekening_deposito($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		echo json_encode($return);
	}
	//END VERIFIKASI REKENING PEMBIAYAAN


	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI SETUP
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// END VERIFIKASI PENCAIRAN DEPOSITO
	/****************************************************************************************/
	public function datatable_pencairan_deposito_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','mfi_account_deposit.account_deposit_no','mfi_cif.nama','mfi_account_deposit.nominal','mfi_account_deposit.jangka_waktu','');
		$cm_code = @$_GET['cm_code'];
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
			$sWhere = "where mfi_account_deposit_break.status_break = '0'";
		}

		if($sWhere==""){
			$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
		}else{
			$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
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

		$rResult 			= $this->model_transaction->datatable_pencairan_deposito_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_pencairan_deposito_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_pencairan_deposito_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['account_deposit_break_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_deposit_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['nominal'];
			$row[] = $aRow['jangka_waktu'];
			$row[] = '<a href="javascript:;" account_deposit_break_id="'.$aRow['account_deposit_break_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_cif_by_account_deposit_break_id()
	{
		$account_deposit_break_id = $this->input->post('account_deposit_break_id');
		$data = $this->model_transaction->search_cif_by_account_deposit_break_id($account_deposit_break_id);

		echo json_encode($data);
	}

	public function verifikasi_pencairan_deposito()
	{
		$account_deposit_break_id 	= $this->input->post('account_deposit_break_id');
		$account_deposit_no 		= $this->input->post('account_deposit_no');
		$account_saving_no 			= $this->input->post('account_saving_no');
		$nominal 					= $this->input->post('nominal');
		$verify_by			  		= $this->session->userdata('user_id');
		$verify_date		  		= date('Y-m-d H:i:s');
		$trx_detail_id 				= uuid(false);
		$current_date 				= $this->current_date();

			//array update deposit
			$data_account_deposit = array(
									'status_rekening'=>'2'
								 );
			$param_account_deposit = array('account_deposit_no'=>$account_deposit_no);

			//array update deposit break
			$data_account_deposit_break = array(
											'status_break'	 =>'1',
											'verify_by'	 	 =>$verify_by,
											'verify_date'	 =>$verify_date
										 );
			$param_account_deposit_break = array('account_deposit_break_id'=>$account_deposit_break_id);

			//array insert mfi_trx_detail
			$data_trx_detail = array(
					'trx_detail_id' => $trx_detail_id,
					'trx_type' => 2,
					'trx_account_type' => 0,
					'account_no' => $account_deposit_no,
					'flag_debit_credit' => 'D',
					'amount' => $nominal,
					'trx_date' => $current_date,
					'account_no_dest' => $account_saving_no,
					'account_type_dest' => 4,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'description' => 'Pencairan Deposito'
				);

			//array insert mfi_trx_account_saving
			$data_trx_account_saving = array(
					'trx_account_saving_id' => uuid(false),
					'branch_id' => $this->session->userdata('branch_id'),
					'account_saving_no' => $account_saving_no,
					'trx_saving_type' => 4,
					'flag_debit_credit' => 'C',
					'trx_date' => $current_date,
					'amount' => $nominal,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'trx_detail_id' => $trx_detail_id
				);

			//array insert mfi_trx_account_deposit
			$data_trx_account_deposit = array(
					'trx_account_deposit_id' => uuid(false),
					'account_deposit_no' => $account_deposit_no,
					'trx_deposit_type' => 0,
					'trx_date' => $current_date,
					'amount' => $nominal,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'trx_detail_id' => $trx_detail_id
				);

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_detail($data_trx_detail);
		$this->model_transaction->insert_trx_account_saving($data_trx_account_saving);
		$this->model_transaction->insert_trx_account_deposit($data_trx_account_deposit);
		$this->model_transaction->update_account_deposit($data_account_deposit,$param_account_deposit); //UPDATE TABEL DEPOSIT
		$this->model_transaction->update_account_deposit_break($data_account_deposit_break,$param_account_deposit_break); //UPDATE TABEL DEPOSIT BREAK
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function reject_ver_pencairan_deposito()
	{
		$account_deposit_break_id 	= $this->input->post('account_deposit_break_id');
		$account_deposit_no 		= $this->input->post('account_deposit_no');
		$verify_by			  		= $this->session->userdata('user_id');
		$verify_date		  		= date('Y-m-d H:i:s');

			//array update deposit
			$data_account_deposit = array(
									'status_rekening'=>'1'
								 );
			$param_account_deposit = array('account_deposit_no'=>$account_deposit_no);

			//array update deposit break
			$data_account_deposit_break = array(
											'verify_by'	 	 =>$verify_by,
											'verify_date'	 =>$verify_date
										 );
			$param_account_deposit_break = array('account_deposit_break_id'=>$account_deposit_break_id);

			//array delete deposit break
			$param_account_deposit_break_delete = array('account_deposit_break_id'=>$account_deposit_break_id);
		
		$this->db->trans_begin();

		$this->model_transaction->update_account_deposit($data_account_deposit,$param_account_deposit); //UPDATE TABEL DEPOSIT

		$this->model_transaction->update_account_deposit_break($data_account_deposit_break,$param_account_deposit_break); //UPDATE TABEL DEPOSIT BREAK
		
		$this->model_transaction->delete_account_deposit_break($param_account_deposit_break_delete); //DELETE
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
	// END VERIFIKASI PENCAIRAN DEPOSITO
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function datatable_verifikasi_insurance_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_insurance.account_insurance_no', 'mfi_cif.nama', 'mfi_product_insurance.product_name','mfi_account_insurance.benefit_value','mfi_account_insurance.premium_value','mfi_account_insurance.status_rekening','');
				
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
			$sWhere = "where mfi_account_insurance.status_rekening ='0'";
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_insurance_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_insurance_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_insurance_setup(); // get number of all data
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
			$row[] = $aRow['benefit_value'];
			$row[] = $aRow['premium_value'];
			$row[] = $aRow['status_rekening'];
			$row[] = '<a href="javascript:;" account_insurance_id="'.$aRow['account_insurance_id'].'" id="link-edit">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_account_insurance_by_account_insurance_id_on_verifikasi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$data = $this->model_transaction->get_account_insurance_by_account_insurance_id_on_verifikasi($account_insurance_id);

		echo json_encode($data);
	}

	public function mencari_nama_pemegang_rekening()
	{
		$pemegang_rekening = $this->input->post('pemegang_rekening');
		$data = $this->model_transaction->mencari_nama_pemegang_rekening($pemegang_rekening);

		echo json_encode($data);
	}

	public function verifikasi_rekening_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_insurance_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>1,
							'approve_by'	 =>$user_id,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_asuransi($data,$param);
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

	public function in_verifikasi_rekening_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_financing_id) ; $i++ )
		{
			$data = array(
							'status_rekening'=>0,
							'approve_by'	 =>$user_id,
							'approve_date'	 =>date('Y-m-d H:i:s')
						 );
			$param = array('account_insurance_id'=>$account_insurance_id[$i]);
			
			$this->db->trans_begin();
			$this->model_transaction->verifikasi_rekening_asuransi($data,$param);
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

	public function verifikasi_rek_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$account_saving_no 	  = $this->input->post('pemegang_rekening');
		$user_id			  = $this->session->userdata('user_id');

				//variable untuk insert ke mfi_trx_detail
				$trx_detail_id 			= uuid(false);
				$trx_type 				= '1';
				$trx_account_type 		= '3';
				$account_no				= $this->input->post('pemegang_rekening');
				$flag_debit_credit 		= 'D';
				$amount 				= $this->input->post('premium_value');
				$trx_date 				= $this->model_transaction->get_date_current();
				$created_by 			= $user_id;
				$created_date 			= date("Y-m-d H:i:s");
				$account_no_dest		= $this->input->post('account_no2');
				$account_type_dest		= '0';
					//array untuk insert ke mfi_trx_detail
					$mfi_trx_detail = array(
											 'trx_detail_id ' 	=> $trx_detail_id 
											,'trx_summary_id' 	=> NULL
											,'trx_type'			=> $trx_type 	
											,'trx_account_type' => $trx_account_type 
											,'account_no'		=> $account_saving_no	
											,'flag_debit_credit'=> $flag_debit_credit 
											,'amount' 			=> $amount 
											,'trx_date' 		=> $trx_date 	
											,'reference_no' 	=> NULL
											,'description' 		=> NULL
											,'created_by' 		=> $created_by 
											,'created_date' 	=> $created_date 
											,'account_no_dest' 	=> $account_no_dest	
											,'account_type_dest'=> $account_type_dest	
											);

				//variable untuk insert ke  mfi_trx_account_insurance 
				$trx_account_insurance_id 	= uuid(false);
				$account_insurance_no 		= $this->input->post('account_no2');
				$trx_insurance_type 		= '0';
					//array untuk insert ke  mfi_trx_account_insurance //note: beberapa variabel menggunakan variabel yang sudah ada
					$mfi_trx_account_insurance = array(
														 'trx_account_insurance_id' => $trx_account_insurance_id
														,'account_insurance_no'		=> $account_insurance_no	
														,'trx_insurance_type' 		=> $trx_insurance_type 
														,'trx_date' 				=> $trx_date 	
														,'amount' 					=> $amount 
														,'description' 				=> NULL
														,'created_by' 				=> $created_by 
														,'created_date' 			=> $created_date 	
														,'trx_detail_id' 			=> $trx_detail_id 	
													  );

				//variable untuk insert ke  mfi_trx_account_saving 
				$branch_id 				= $this->session->userdata('branch_id');
				$account_saving_no 		= $this->input->post('pemegang_rekening');
				$trx_saving_type	 	= '3';
				$flag_debit_credit_		= 'D';
					//array untuk insert ke  mfi_trx_account_saving //note: beberapa variabel menggunakan variabel yang sudah ada
					$mfi_trx_account_saving = array(
														 'branch_id' 			=> $branch_id
														,'account_saving_no'	=> $account_saving_no 
														,'trx_saving_type'		=> $trx_saving_type
														,'flag_debit_credit'	=> $flag_debit_credit_	
														,'trx_date'				=> $trx_date 
														,'amount'				=> $amount
														,'reference_no'			=> NULL
														,'description'			=> NULL
														,'created_date'			=> $created_date
														,'created_by'			=> $created_by 
														,'trx_detail_id'		=> $trx_detail_id 
													  );
				
				//variable update table  mfi_account_insurance.status_rekening=1, mfi_account_saving.saldo_memo
				//mfi_account_saving.saldo_memo
				$insurance_type	  = $this->input->post('insurance_type');
				$mfi_account_saving_saldo_memo	  = $this->input->post('saldo_memo');			
				$saldo_memo = $this->input->post('update_saldo_memo');
					//mfi_account_saving.saldo_memo
					$update_saldo_memo = array(
											'saldo_memo'=>$saldo_memo
										 );
					$account_saving_no = array('account_saving_no'=>$account_saving_no);
			
					//mfi_account_insurance.status_rekening=1
					$data = array(
									'status_rekening'=>1,
									'verify_by'	 	 =>$user_id,
									'verify_date'	 =>date('Y-m-d H:i:s')
								 );
					$param = array('account_insurance_id'=>$account_insurance_id);
		
		$this->db->trans_begin();
		//insert
		$this->model_transaction->insert_mfi_trx_detail_on_verifikasi_insurance($mfi_trx_detail); //insert mfi_trx_detail
		$this->model_transaction->insert_mfi_trx_account_insurance_on_verifikasi_insurance($mfi_trx_account_insurance); //insert mfi_trx_account_insurance
		$this->model_transaction->insert_mfi_trx_account_saving_on_verifikasi_insurance($mfi_trx_account_saving); //insert mfi_trx_account_saving
		//update
		$this->model_transaction->verifikasi_rek_asuransi($data,$param);//mfi_account_insurance.status_rekening=1
		$this->model_transaction->update_saldo_memo($update_saldo_memo,$account_saving_no); //update saldo_momo
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	
	public function delete_rek_asuransi()
	{
		$account_insurance_id = $this->input->post('account_insurance_id');
		$user_id			  = $this->session->userdata('user_id');

			$data = array(
							'status_rekening'=>1,
							'verify_by'	 	 =>$user_id,
							'verify_date'	 =>date('Y-m-d H:i:s')
						 );

			$param = array('account_insurance_id'=>$account_insurance_id);
			$this->db->trans_begin();

			$this->model_transaction->verifikasi_rek_asuransi($data,$param);
			$this->model_transaction->delete_rekening_asuransi($param);
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
	// END VERIFIKASI ASURANSI
	/****************************************************************************************/

	public function trx_rembug()
	{
		$data['container'] = 'transaction/trx_rembug';
		$data['current_date'] = ($this->session->userdata('trx_date_cm')==true)?$this->session->userdata('trx_date_cm'):$this->format_date_detail($this->current_date(),'id',false,'/');
		$data['fa_name_cm'] = ($this->session->userdata('fa_name_cm')==true)?$this->session->userdata('fa_name_cm'):'';
		$data['fa_code_cm'] = ($this->session->userdata('fa_code_cm')==true)?$this->session->userdata('fa_code_cm'):'';
		$data['account_cash_code_cm'] = ($this->session->userdata('account_cash_code_cm')==true)?$this->session->userdata('account_cash_code_cm'):'';
		
		$this->load->view('core',$data);
	}

	public function get_trx_rembug_data()
	{
		$cm_code = $this->input->post('cm_code');
		$tanggal = $this->input->post('tanggal');
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$account_cash_code = $this->input->post('account_cash_code');
		$rows = $this->model_transaction->get_trx_rembug_data($cm_code,$tanggal);
		$i=0;
		$data['data'] = array();
		$data['mutasi'] = array();
		$data['tab_berencana'] = array();
		foreach($rows as $row)
		{
			$data['data'][$i]['cif_id'] = ($row['cif_id']==null)?0:$row['cif_id'];
			$data['data'][$i]['cm_code'] = ($row['cm_code']==null)?0:$row['cm_code'];
			$data['data'][$i]['cif_no'] = ($row['cif_no']==null)?0:$row['cif_no'];
			$data['data'][$i]['nama'] = ($row['nama']==null)?0:$row['nama'];
			$data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela']==null)?0:$row['tabungan_sukarela'];
			$data['data'][$i]['tabungan_wajib'] = ($row['tabungan_wajib']==null)?0:$row['tabungan_wajib'];
			$data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain']==null)?0:$row['transaksi_lain'];
			$data['data'][$i]['angsuran'] = ($row['angsuran']==null)?0:$row['angsuran'];
			$data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan']==null)?0:$row['pokok_pembiayaan'];
			$data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan']==null)?0:$row['margin_pembiayaan'];
			$data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan']==null)?0:$row['catab_pembiayaan'];
			$data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok']==null)?0:$row['tabungan_kelompok'];
			$data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran']==null)?0:$row['jumlah_angsuran'];
			$data['data'][$i]['pokok'] = ($row['pokok']==null)?0:$row['pokok'];
			$data['data'][$i]['droping'] = ($row['droping']==null)?0:$row['droping'];
			$data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok']==null)?0:$row['angsuran_pokok'];
			$data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin']==null)?0:$row['angsuran_margin'];
			$data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab']==null)?0:$row['angsuran_catab'];
			$data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib']==null)?0:$row['angsuran_tab_wajib'];
			$data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok']==null)?0:$row['angsuran_tab_kelompok'];
			$data['data'][$i]['adm'] = ($row['adm']==null)?0:$row['adm'];
			$data['data'][$i]['asuransi'] = ($row['asuransi']==null)?0:$row['asuransi'];
			$data['data'][$i]['setoran_berencana'] = ($row['setoran_berencana']==null)?0:$row['setoran_berencana'];
			$data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk']==null)?0:$row['setoran_lwk'];
			$data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan']==null)?0:$row['setoran_mingguan'];
			$data['data'][$i]['margin'] = ($row['margin']==null)?0:$row['margin'];
			$data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok']==null)?0:$row['saldo_pokok'];
			$data['data'][$i]['saldo_margin'] = ($row['saldo_margin']==null)?0:$row['saldo_margin'];
			$data['data'][$i]['saldo_catab'] = ($row['saldo_catab']==null)?0:$row['saldo_catab'];
			$data['data'][$i]['jangka_waktu'] = ($row['jangka_waktu']==null)?0:$row['jangka_waktu'];
			$data['data'][$i]['periode_jangka_waktu'] = ($row['periode_jangka_waktu']==null)?0:$row['periode_jangka_waktu'];
			$data['data'][$i]['counter_angsuran'] = ($row['counter_angsuran']==null)?0:$row['counter_angsuran'];
			$data['data'][$i]['status'] = $row['status'];
			$data['tab_berencana'][$i] = $this->model_transaction->get_tabungan_berencana_by_cif_no($row['cif_no']);
			$mutasi = $this->model_transaction->get_mutasi_by_cif_no($row['cif_no']);
			$data['mutasi'][$i]['setoran_tambahan'] = (count($mutasi)>0)?$mutasi['setoran_tambahan']:0;
			$data['mutasi'][$i]['penarikan_tabungan_sukarela'] = (count($mutasi)>0)?$mutasi['penarikan_tabungan_sukarela']:0;
			$i++;
		}
		$data['kas_awal'] = $this->model_transaction->fn_get_saldoawal_kaspetugas($account_cash_code,$tanggal,1); // 1 = mencari kas awal
		echo json_encode($data);
	}

	public function process_trx_rembug_save()
	{
		// echo "<pre>";
		// print_r($_POST);
		// die();
		$branch_id 						= $this->input->post('branch_id');
		$cm_code 						= $this->input->post('cm_code');
		$fa_code 						= $this->input->post('fa_code');
		$fa_name 						= $this->input->post('fa_name');
		$account_cash_code 				= $this->input->post('account_cash_code');
		$trx_date 						= $this->input->post('tanggal2');
		$trx_date 						= str_replace('/', '', $trx_date);
		$trx_date 						= substr($trx_date,4,4).'-'.substr($trx_date,2,2).'-'.substr($trx_date,0,2);
		$cif_no 						= $this->input->post('cif_no');
		$absen 							= $this->input->post('absen');
		$frekuensi1 					= $this->input->post('freq');
		$setoran_tab_sukarela 			= $this->convert_numeric($this->input->post('setoran_tabungan_sukarela'));
		$setoran_lwk					= $this->convert_numeric($this->input->post('setoran_lwk'));
		$setoran_mingguan 				= $this->convert_numeric($this->input->post('setoran_mingguan'));
		$penarikan_tab_sukarela 		= $this->convert_numeric($this->input->post('penarikan_tabungan_sukarela'));
		$status_angsuran_margin 		= $this->input->post('status_angsuran_margin');
		$status_angsuran_catab 			= $this->input->post('status_angsuran_catab');
		$status_angsuran_tab_wajib 		= $this->input->post('status_angsuran_tab_wajib');
		$status_angsuran_tab_kelompok 	= $this->input->post('status_angsuran_tab_kelompok');
		$account_saving_no 				= $this->input->post('detail_berencana_account_no');
		$amount 						= $this->input->post('detail_berencana_setoran');
		$frekuensi2 					= $this->input->post('detail_berencana_freq');
		$infaq 							= $this->convert_numeric($this->input->post('infaq_kelompok'));
		$kas_awal 						= $this->convert_numeric($this->input->post('kas_awal'));
		$vtrx_cm_save_id				= $this->input->post('trx_cm_save_id');
	    $muqosha 						= $this->input->post('muqosha');
		// delete table trx_cm_save apabila sudah ada di database
		if($vtrx_cm_save_id!="")
		{
			$this->delete_trx_cm_save($vtrx_cm_save_id);
		}
		$trx_cm_save_id 				= uuid(false);
		$data_trx_cm_save_berencana 	= array();
		$data_trx_cm_save_detail 		= array();
		$data_trx_cm_save 				= array(
											'trx_cm_save_id' 		=> $trx_cm_save_id
											,'infaq' 				=> $infaq
											,'kas_awal' 			=> $kas_awal
											,'branch_id' 			=> $branch_id
											,'cm_code' 				=> $cm_code
											,'fa_code' 				=> $fa_code
											,'account_cash_code' 	=> $account_cash_code
											,'trx_date' 			=> $trx_date
											,'created_date' 		=> date('Y-m-d')
										  );

		for ( $i = 0 ; $i < count($cif_no) ; $i++ )
		{

			$trx_cm_save_detail_id 				= uuid(false);

			$data_trx_cm_save_detail[] 			= array(
					 'cif_no' 						=> $cif_no[$i]
					,'trx_cm_save_detail_id' 		=> $trx_cm_save_detail_id
					,'trx_cm_save_id' 				=> $trx_cm_save_id
					,'cif_no' 						=> $cif_no[$i]
					,'absen' 						=> $absen[$i]
					,'frekuensi' 					=> $frekuensi1[$i]
					,'setoran_tab_sukarela' 		=> $setoran_tab_sukarela[$i]
					,'setoran_lwk' 					=> $setoran_lwk[$i]
					,'setoran_mingguan' 			=> $setoran_mingguan[$i]
					,'penarikan_tab_sukarela' 		=> $penarikan_tab_sukarela[$i]
					,'status_angsuran_margin' 		=> $status_angsuran_margin[$i]
					,'status_angsuran_catab' 		=> $status_angsuran_catab[$i]
					,'status_angsuran_tab_wajib' 	=> $status_angsuran_tab_wajib[$i]
					,'status_angsuran_tab_kelompok' => $status_angsuran_tab_kelompok[$i]
					,'muqosha' 						=> $muqosha[$i]
				);

			if(isset($account_saving_no[$i]))
			{
				for ( $j = 0 ; $j < count($account_saving_no[$i]) ; $j++ )
				{

					$data_trx_cm_save_berencana[] 		= array(
							 'trx_cm_save_berencana_id' => uuid(false)
							,'trx_cm_save_detail_id' 	=> $trx_cm_save_detail_id
							,'account_saving_no' 		=> $account_saving_no[$i][$j]
							,'amount' 					=> $this->convert_numeric($amount[$i][$j])
							,'frekuensi' 				=> $frekuensi2[$i][$j]
						);
				}
			}

		}
		
		// echo "<pre>";
		// print_r($data_trx_cm_save_detail);
		// print_r($data_trx_cm_save_berencana);
		// die();

		$this->db->trans_begin();

		if ( count ( $data_trx_cm_save ) > 0 ) {
			$this->model_transaction->insert_trx_cm_save($data_trx_cm_save);
		}

		if ( count ( $data_trx_cm_save_detail ) > 0 ) {
			$this->model_transaction->insert_trx_cm_save_detail($data_trx_cm_save_detail);
		}

		if ( count ( $data_trx_cm_save_berencana ) > 0 ) {
			$this->model_transaction->insert_trx_cm_save_berencana($data_trx_cm_save_berencana);
		}


		if ( $this->db->trans_status() === true )
		{
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Transaksi Berhasil !');
			$this->session->set_userdata('trx_date_cm',$this->input->post('tanggal2'));
			$this->session->set_userdata('fa_name_cm',$fa_name);
			$this->session->set_userdata('fa_code_cm',$fa_code);
			$this->session->set_userdata('account_cash_code_cm',$account_cash_code);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Transaksi Gagal! Silahkan Hubungi Administrator untuk masalah ini.');
		}

		echo json_encode($return);


	}

	public function process_trx_rembug()
	{
		// echo "<pre>";
		// print_r($_POST);
		// die();

		$fa_code 								= $this->input->post('fa_code');
	    $account_cash_code 						= $this->input->post('account_cash_code');
	    $cm_code 								= $this->input->post('cm_code');
	    $branch_code 							= $this->input->post('branch_code');
	    $branch_id 								= $this->input->post('branch_id');
	    $tanggal 								= $this->input->post('tanggal2');
	    // $tanggal 								= str_replace('/', '', $tanggal);
		// $tanggal 								= substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
	    $cif_no 								= $this->input->post('cif_no');
	    $absen 									= $this->input->post('absen');
	    $angsuran_pokok 						= $this->input->post('angsuran_pokok');
	    $angsuran_margin 						= $this->input->post('angsuran_margin');
	    $angsuran_catab 						= $this->input->post('angsuran_catab');
	    $angsuran_tab_wajib 					= $this->input->post('angsuran_tab_wajib');
	    $angsuran_tab_kelompok 					= $this->input->post('angsuran_tab_kelompok');
	    $balance_angsuran 						= $this->input->post('balance_angsuran');
	    $balance_tabungan_wajib 				= $this->input->post('balance_tabungan_wajib');
	    $balance_tabungan_sukarela 				= $this->input->post('balance_tabungan_sukarela');
	    $balance_transaksi_lain 				= $this->input->post('balance_transaksi_lain');
	    $balance_pokok_pembiayaan 				= $this->input->post('balance_pokok_pembiayaan');
	    $balance_margin_pembiayaan 				= $this->input->post('balance_margin_pembiayaan');
	    $balance_catab_pembiayaan 				= $this->input->post('balance_catab_pembiayaan');
	    $balance_tabungan_kelompok 				= $this->input->post('balance_tabungan_kelompok');
	    $freq 									= $this->input->post('freq');
	    $jumlah_angsuran 						= $this->input->post('jumlah_angsuran');
	    $setoran_tabungan_sukarela 				= $this->input->post('setoran_tabungan_sukarela');
	    // $setoran_infaq 							= $this->input->post('setoran_infaq');
	    $penarikan_tabungan_sukarela 			= $this->input->post('penarikan_tabungan_sukarela');
	    $realisasi_plafon 						= $this->input->post('realisasi_plafon');
	    $realisasi_adm 							= $this->input->post('realisasi_adm');
	    $droping 								= $this->input->post('droping');
	    $realisasi_asuransi 					= $this->input->post('realisasi_asuransi');
	    $realisasi_margin 						= $this->input->post('realisasi_margin');
	    $total_angsuran 						= $this->input->post('total_angsuran');
	    $total_setoran_tab_sukarela 			= $this->input->post('total_setoran_tab_sukarela');
	    $total_infaq 							= $this->input->post('total_infaq');
	    $total_penarikan_tab_sukarela 			= $this->input->post('total_penarikan_tab_sukarela');
	    $total_realisasi_plafon 				= $this->input->post('total_realisasi_plafon');
	    $total_realisasi_adm 					= $this->input->post('total_realisasi_adm');
	    $total_realisasi_asuransi 				= $this->input->post('total_realisasi_asuransi');
	    $kas_awal 								= $this->input->post('kas_awal');
	    $infaq_kelompok 						= $this->input->post('infaq_kelompok');
	    $setoran 								= $this->input->post('setoran');
	    $penarikan 								= $this->input->post('penarikan');
	    $saldo_kas 								= $this->input->post('saldo_kas');
	    $setoran_tab_berencana 					= $this->input->post('setoran_tab_berencana');
	    $detail_berencana_account_no 			= $this->input->post('detail_berencana_account_no');
	    $detail_berencana_product_code 			= $this->input->post('detail_berencana_product_code');
	    $detail_berencana_setoran 				= $this->input->post('detail_berencana_setoran');
	    $detail_berencana_freq 					= $this->input->post('detail_berencana_freq');
	    $setoran_tab_berencana_product_code 	= $this->input->post('setoran_tab_berencana_product_code');
	    $setoran_lwk 							= $this->input->post('setoran_lwk');
	    $setoran_mingguan 						= $this->input->post('setoran_mingguan');
	    $setoran_minggon 						= $this->input->post('setoran_minggon');
	    $trx_cm_save_id 						= $this->input->post('trx_cm_save_id');
	    $muqosha 								= $this->input->post('muqosha');

		/**************************************/

		// $validate_double_transaction = $this->model_transaction->validate_double_transaction($cm_code,$tanggal);
		$validate_double_transaction=true;
		if($validate_double_transaction==false)
		{
			$return = array('success'=>false,'message'=>'Transaksi Dibatalkan. Dikarnakan Double Transaksi.');
		}
		else
		{
			$total_droping = 0;
			$total_angsuran_tab_wajib = 0;
			$total_angsuran_tab_kelompok = 0;
			$total_angsuran_pokok = 0;
			$total_angsuran_margin = 0;
			$total_angsuran_catab = 0;
			$total_minggon = 0;
			for ( $x = 0 ; $x < count($cif_no) ; $x++ )
			{
				$total_minggon+=$this->convert_numeric($setoran_minggon[$x]);
				$total_droping+=$this->convert_numeric($droping[$x]);
				$total_angsuran_tab_wajib+=$this->convert_numeric($angsuran_tab_wajib[$x]);
				$total_angsuran_tab_kelompok+=$this->convert_numeric($angsuran_tab_kelompok[$x]);
				$total_angsuran_pokok+=$this->convert_numeric($angsuran_pokok[$x])*$freq[$x];
				$total_angsuran_margin+=$this->convert_numeric($angsuran_margin[$x]);
				$total_angsuran_catab+=$this->convert_numeric($angsuran_catab[$x]);
			}

			$trx_cm_id = uuid(false);

			// $data_cm = array(
			// 	 'trx_cm_id' => $trx_cm_id
			// 	,'cm_code' => $cm_code
			// 	,'trx_date' => $tanggal
			// 	,'angsuran_pokok' => $total_angsuran_pokok
			// 	,'tab_wajib_cr' => $total_tab_wajib_cr
			// 	,'tab_sukarela_cr' => $total_tab_sukarela_cr
			// 	,'transaksi_lain_cr' => $total_transaksi_lain_cr
			// 	,'tab_wajib_db' => $total_tab_wajib_db
			// 	,'tab_sukarela_db' => $total_tab_sukarela_db
			// 	,'droping' => $total_droping
			// );
			$data_cm = array(
					'trx_cm_id' => $trx_cm_id
					,'cm_code' => $cm_code
					,'trx_date' => $tanggal
					,'droping' => $total_droping
					,'tab_wajib_cr' => $total_angsuran_tab_wajib
					,'tab_sukarela_cr' => $this->convert_numeric($total_setoran_tab_sukarela)
					,'transaksi_lain_cr' => $total_minggon
					,'trx_status' => 0
					// 'tab_wajib_db' => 
					,'tab_sukarela_db' => $this->convert_numeric($total_penarikan_tab_sukarela)
					,'fa_code' => $fa_code
					,'created_by' => $this->session->userdata('user_id')
					,'created_date' => date("Y-m-d H:i:s")
					,'angsuran_pokok' => $total_angsuran_pokok
					,'angsuran_margin' => $total_angsuran_margin
					,'angsuran_catab' => $total_angsuran_catab
					// 'transaksi_lain_db' => 
					,'infaq_kelompok' => $this->convert_numeric($infaq_kelompok)
				);

			$data_cm_detail = array();
			$data_cm_detail_droping = array();
			$data_savingplan = array();
			$data_savingplan_account = array();
			$batch_trx_cm_detail_id = array();
			for ( $y = 0 ; $y < count($cif_no) ; $y++ )
			{
				// $data_cm_detail[] = array(
				// 	'cif_no' => $cif_no[$y]
				// 	,'trx_cm_id' => $trx_cm_id
				// 	,'droping' => $saldo_droping[$y]
				// 	,'angsuran_pokok' => $jumlah_angsuran[$y]*$freq[$y]
				// 	,'tab_wajib_cr' => $setoran_tabungan_wajib[$y]
				// 	,'tab_sukarela_cr' => $setoran_tabungan_sukarela[$y]
				// 	,'transaksi_lain_cr' => $setoran_lain[$y]
				// 	,'tab_wajib_db' => $penarikan_tabungan_wajib[$y]
				// 	,'tab_sukarela_db' => $penarikan_tabungan_sukarela[$y]
				// 	,'absen' => $absen[$y]
				// );
				$trx_cm_detail_id = uuid(false);
				$batch_trx_cm_detail_id[$y] = $trx_cm_detail_id;
				$data_cm_detail[] = array(
						'trx_cm_id' => $trx_cm_id
						,'trx_cm_detail_id' => $trx_cm_detail_id
						,'cif_no' => $cif_no[$y]
						// ,'droping' => $droping[$y]
						,'angsuran_pokok' => $this->convert_numeric($angsuran_pokok[$y])
						,'angsuran_margin' => $this->convert_numeric($angsuran_margin[$y])
						,'angsuran_catab' => $this->convert_numeric($angsuran_catab[$y])
						,'tab_wajib_cr' => $this->convert_numeric($angsuran_tab_wajib[$y])
						,'tab_kelompok_cr' => $this->convert_numeric($angsuran_tab_kelompok[$y])
						,'tab_sukarela_cr' => $this->convert_numeric($setoran_tabungan_sukarela[$y])
						,'tab_sukarela_db' => $this->convert_numeric($penarikan_tabungan_sukarela[$y])
						,'minggon' => $this->convert_numeric($setoran_minggon[$y])
						,'absen' => $absen[$y]
						,'freq' => $freq[$y]
						// 'tab_wajib_db' => 
						// 'transaksi_lain_db' => 
					);

				if($setoran_lwk[$y]>0){
					$data_cm_lwk = array(
							'trx_cm_detail_id' => $trx_cm_detail_id
							,'cif_no' => $cif_no[$y]
							,'setoran_lwk' => $this->convert_numeric($setoran_lwk[$y])
						);
					$this->model_transaction->insert_trx_cm_lwk($data_cm_lwk);
				}
				
				$data_cm_detail_droping[] = array(
						'trx_cm_detail_id' => $trx_cm_detail_id,
						'cif_no' => $cif_no[$y],
						'droping' => $this->convert_numeric($droping[$y]),
						'administrasi' => $this->convert_numeric($realisasi_adm[$y]),
						'asuransi' => $this->convert_numeric($realisasi_asuransi[$y])
					);

				$trx_cm_detail_saving_plan_id = uuid(false);
				if($this->convert_numeric($setoran_tab_berencana[$y])>0)
				{
					$data_savingplan[] = array(
							'trx_cm_detail_savingplan_id' => $trx_cm_detail_saving_plan_id,
							'trx_cm_detail_id' => $trx_cm_detail_id,
							'cif_no' => $cif_no[$y],
							'amount' => $this->convert_numeric($setoran_tab_berencana[$y])
						);

					for ( $z = 0 ; $z < count(@$detail_berencana_product_code[$y]) ; $z++ ) // record nya berdasarkan kode produk
					{
						$data_savingplan_account[] = array(
								'trx_cm_detail_savingplan_account_id' => uuid(false),
								'trx_cm_detail_savingplan_id' => $trx_cm_detail_saving_plan_id,
								'product_code' => (isset($detail_berencana_product_code[$y][$z])?$detail_berencana_product_code[$y][$z]:null),
								'amount' => $this->convert_numeric($detail_berencana_setoran[$y][$z]),
								'flag_debet_credit' => 'C',
								'freq' => (isset($detail_berencana_freq[$y][$z])?$detail_berencana_freq[$y][$z]:0)
							);
					}	
				}
			}

			// print_r($data_savingplan);
			// echo '------------------------------------------------';
			// print_r($data_savingplan_account);
			// die();

			/**
			* TRANSAKSI KAS PETUGAS
			* PENGKREDITAN DAN PENDEBETAN
			*/
			$trx_gl_cash_id1 = uuid(false);
			$cm = $this->model_transaction->get_cm_data_by_code($cm_code);
			$TKP_penerimaan=array();
			$TKP_total_setoran = $this->convert_numeric($setoran)+$this->convert_numeric($infaq_kelompok);
			if($TKP_total_setoran>0)
			{
				$TKP_penerimaan = array(
						'trx_gl_cash_id'		=> $trx_gl_cash_id1
						,'trx_date'				=> $tanggal
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> 2
						,'flag_debet_credit'	=> 'D'
						,'account_teller_code'	=> $account_cash_code
						,'voucher_date'			=> $tanggal
						,'voucher_ref'			=> $cm_code
						,'description'			=> 'PENERIMAAN REMBUG '.$cm['cm_name'].' ('.$cm_code.')'
						,'created_by'			=> $this->session->userdata('username')
						,'created_date'			=> date('Y-m-d')
						,'amount'				=> $TKP_total_setoran
						,'status' 				=> 1
					);
			}
			$trx_gl_cash_id2 = uuid(false);
			$TKP_penarikan=array();
			if($this->convert_numeric($penarikan)>0)
			{
				$TKP_penarikan = array(
						'trx_gl_cash_id'		=> $trx_gl_cash_id2
						,'trx_date'				=> $tanggal
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> 3
						,'flag_debet_credit'	=> 'C'
						,'account_teller_code'	=> $account_cash_code
						,'voucher_date'			=> $tanggal
						,'voucher_ref'			=> $cm_code
						,'description'			=> 'PENARIKAN REMBUG '.$cm['cm_name'].' ('.$cm_code.')'
						,'created_by'			=> $this->session->userdata('username')
						,'created_date'			=> date('Y-m-d')
						,'amount'				=> $this->convert_numeric($penarikan)
						,'status' 				=> 1
					);
			}
			$TKP_detail[] = array(
					'trx_gl_cash_id' => $trx_gl_cash_id1
					,'cm_code' => $cm_code
					,'amount_setoran' => $this->convert_numeric($setoran)
					,'amount_penarikan' => 0
				);
			$TKP_detail[] = array(
					'trx_gl_cash_id' => $trx_gl_cash_id2
					,'cm_code' => $cm_code
					,'amount_setoran' => 0
					,'amount_penarikan' => $this->convert_numeric($penarikan)
				);

			$this->db->trans_begin();

			if(count($TKP_penerimaan)>0) $this->model_transaction->insert_trx_gl_cash($TKP_penerimaan);
			if(count($TKP_penarikan)>0) $this->model_transaction->insert_trx_gl_cash($TKP_penarikan);
			$this->model_transaction->insert_trx_gl_cash_detail($TKP_detail); // insert batch

			for ( $i = 0 ; $i < count($cif_no) ; $i++ )
			{
				$cif = $this->model_cif->get_cif_by_cif_no($cif_no[$i]);

				$data_balance = array(
						'pokok_pembiayaan' => ($this->convert_numeric($balance_pokok_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_pokok[$i])))
						,'margin_pembiayaan' => ($this->convert_numeric($balance_margin_pembiayaan[$i])-($freq[$i]*$this->convert_numeric($angsuran_margin[$i])))
						,'catab_pembiayaan' => ($this->convert_numeric($balance_catab_pembiayaan[$i])+($freq[$i]*$this->convert_numeric($angsuran_catab[$i])))
						,'tabungan_wajib' => ($this->convert_numeric($balance_tabungan_wajib[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_wajib[$i])))
						,'tabungan_kelompok' => ($this->convert_numeric($balance_tabungan_kelompok[$i])+($freq[$i]*$this->convert_numeric($angsuran_tab_kelompok[$i])))
						,'tabungan_sukarela' => ($this->convert_numeric($balance_tabungan_sukarela[$i])+$this->convert_numeric($setoran_tabungan_sukarela[$i])-$this->convert_numeric($penarikan_tabungan_sukarela[$i]))
						,'transaksi_lain' => ($this->convert_numeric($balance_transaksi_lain[$i])+$this->convert_numeric($setoran_minggon[$i]))
					);

				// data tabungan

				if(isset($detail_berencana_account_no[$i]))
				{
					for ( $j = 0 ; $j < count($detail_berencana_account_no[$i]) ; $j++ )
					{
						$record_saving = $this->model_transaction->get_account_saving_by_account_saving_no($detail_berencana_account_no[$i][$j]);
						if(count($record_saving)>0)
						{
							$param_saving = array('account_saving_no' => $detail_berencana_account_no[$i][$j] );
							$data_saving = array(
											'saldo_memo' => $record_saving['saldo_memo']+($this->convert_numeric($detail_berencana_setoran[$i][$j])*$detail_berencana_freq[$i][$j]),
											'counter_angsruan' => $record_saving['counter_angsruan']+$detail_berencana_freq[$i][$j]
										);
							$this->model_transaction->update_account_saving($data_saving,$param_saving);
						}
					}
				}

				$get_financing = $this->model_transaction->get_account_financing_by_cif_no($cif_no[$i]);
				if(count($get_financing) > 0)
				{
					$jtempo_angsuran_last 	= $get_financing['jtempo_angsuran_next'];
					$jtempo_angsuran_next 	= null;
					$periode_jangka_waktu 	= $get_financing['periode_jangka_waktu'];
					$tanggal_jtempo 		= $get_financing['tanggal_jtempo'];
					
					if($periode_jangka_waktu==0){
						$freq_jtempo = $freq[$i]*1;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' days'));
					}

					else if($periode_jangka_waktu==1){
						$freq_jtempo = $freq[$i]*7;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' days'));
					}

					else if($periode_jangka_waktu==2){
						$freq_jtempo = $freq[$i]*1;
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.$freq_jtempo.' month'));
					}

					else if($periode_jangka_waktu==3)
						$jtempo_angsuran_next = $tanggal_jtempo;

					if($get_financing['status_rekening'] == 0)
						$data_financing['status_rekening'] = 1;

					// update ke financing
					$data_financing['jtempo_angsuran_last'] = $jtempo_angsuran_last;
					$data_financing['jtempo_angsuran_next'] = $jtempo_angsuran_next;
					$data_financing['saldo_pokok'] 			= $get_financing['saldo_pokok']-($freq[$i]*$this->convert_numeric($angsuran_pokok[$i]));
					
					if($data_financing['saldo_pokok']==0)
					{
						$data_financing['saldo_margin'] = $get_financing['saldo_margin']-$get_financing['saldo_margin'];
					}
					else
					{
						$data_financing['saldo_margin'] = $get_financing['saldo_margin']-($freq[$i]*$this->convert_numeric($angsuran_margin[$i]));
					}

					$data_financing['saldo_catab'] 			= $get_financing['saldo_catab']+($freq[$i]*$this->convert_numeric($angsuran_catab[$i]));

					$saldo_syarat_lunas = $data_financing['saldo_pokok']+$data_financing['saldo_margin'];

					if($saldo_syarat_lunas==0){
						$data_financing['status_rekening'] = 2;
					}else{
						$data_financing['status_rekening'] = $get_financing['status_rekening'];
					}

					// jika pelunasan (status_rekening = 2) 
					// saldo catab di mutasi ke tabungan sukarela
					// sehingga saldo catab menjadi 0
					// ------------------------------------------------------
					// status_rekening : 0=baru registrasi 1=aktif 2=lunas 3=verified
					// ------------------------------------------------------
					if(isset($data_financing['status_rekening'])){
						if($data_financing['status_rekening'] == 2){
							// data balance
							$data_balance['tabungan_sukarela'] = $this->convert_numeric($balance_tabungan_sukarela[$i])+$this->convert_numeric($setoran_tabungan_sukarela[$i])-$this->convert_numeric($penarikan_tabungan_sukarela[$i])+$data_financing['saldo_catab'];
							$data_balance['catab_pembiayaan'] = 0;
							
							// data financing/pembiayaan
							$data_financing['saldo_catab'] = 0;
							$data_financing['tanggal_lunas'] = $tanggal;

							$data_financing_lunas = array(
									'account_financing_no'	=>$get_financing['account_financing_no'],
									'saldo_pokok' 			=>$get_financing['saldo_pokok'],
									'saldo_margin' 			=>$get_financing['saldo_margin'],
									'saldo_catab' 			=>$get_financing['saldo_catab'],
									'potongan_margin' 		=>$muqosha[$i],
									'status_pelunasan'		=>'1',
									'create_by' 			=>$this->session->userdata('user_id'),
									'created_date'			=>date("Y-m-d H:i:s"),
									'tanggal_lunas'			=>$tanggal,
									'trx_cm_detail_id'      =>$batch_trx_cm_detail_id[$i]
								);
							$this->model_nasabah->proses_reg_pelunasan_pembayaran($data_financing_lunas);
						}
					}

					if ( ( $jumlah_angsuran[$i]*$freq[$i] ) > 0 ) {
						$data_financing['counter_angsuran'] 	= ((int)$get_financing['counter_angsuran'])+$freq[$i];
					}else{
						$data_financing['counter_angsuran'] 	= ((int)$get_financing['counter_angsuran']);
					}
					$param_financing = array('cif_no' => $cif_no[$i],'status_rekening'=>1);

					$this->model_transaction->update_account_financing($data_financing,$param_financing);

					$get_financing_droping = $this->model_transaction->get_account_financing_droping($get_financing['account_financing_no']);

					if($get_financing_droping['status_droping']=='0' && $realisasi_plafon[$i]!='0')
					{
						// update ke financing droping (ketika pencairan)
						$data_financing_droping 	= array('status_droping'=>1,
															'droping_by'	=>$this->session->userdata('user_id'),
															'droping_date'	=>$tanggal);
						$param_financing_droping 	= array('account_financing_no'=>$get_financing['account_financing_no']);

						$this->model_transaction->update_account_financing_droping($data_financing_droping,$param_financing_droping);

						// update default balance (ketika pencairan)
						$data_balance['account_financing_no'] = $get_financing['account_financing_no'];
						$data_balance['pokok_pembiayaan'] = $this->convert_numeric($realisasi_plafon[$i]);
						$data_balance['margin_pembiayaan'] = $this->convert_numeric($realisasi_margin[$i]);
					}
				}


				// update data balance
				$param_balance = array('cif_no'=>$cif_no[$i]);
				$this->model_transaction->update_account_default_balance($data_balance,$param_balance);

				// ubah status transaksi cif menjadi 1
				// desc: 0 = registrasi, 1=aktif, 2=tidak aktif, 3=registrasi keluar
				if($cif['status']==0){
					$data_cif = array('status'=>1);
					$param_cif = array('cif_no'=>$cif_no[$i]);
					$this->model_cif->update_cif($data_cif,$param_cif);
				}
				if($cif['status']==3){

					// ak = anggota keluar
					// default balance
					$ak_data_balance 			= array(
													'tabungan_wajib'=>0
													,'tabungan_kelompok'=>0
													,'tabungan_minggon'=>0
													,'cadangan_resiko'=>0
													,'simpanan_pokok'=>0
													,'smk'=>0
												);
					$ak_param_balance 			= array('cif_no'=>$cif_no[$i]);
					//financing
					$ak_data_financing 			= array('status_rekening'=>2);
					$ak_param_financing 		= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);
					//saving
					$ak_data_saving 			= array('saldo_memo'=>0,'status_rekening'=>2);
					$ak_param_saving 			= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);
					//deposito
					$ak_data_deposito 			= array('nominal'=>0,'status_rekening'=>2);
					$ak_param_deposito 			= array('cif_no'=>$cif_no[$i],'status_rekening'=>4);

					$this->model_transaction->update_account_default_balance($ak_data_balance,$ak_param_balance);
					$this->model_transaction->update_account_financing($ak_data_financing,$ak_param_financing);
					$this->model_transaction->update_account_saving($ak_data_saving,$ak_param_saving);
					$this->model_transaction->update_account_deposit($ak_data_deposito,$ak_param_deposito);

					$data_cif = array('status'=>2,'tanggal_keluar'=>$tanggal);
					$param_cif = array('cif_no'=>$cif_no[$i]);
					$this->model_cif->update_cif($data_cif,$param_cif);
				}



			}

			$this->model_transaction->insert_trx_cm($data_cm);
			$this->model_transaction->insert_trx_cm_detail($data_cm_detail);
			$this->model_transaction->insert_trx_cm_detail_droping($data_cm_detail_droping);	
			$this->delete_trx_cm_save($trx_cm_save_id);


			// insert trx tabungan berencana
			if(count($data_savingplan)>0){
				$this->model_transaction->insert_trx_cm_detail_savingplan($data_savingplan);
			}
			// insert trx tabungan berencana detail
			if(count($data_savingplan_account)>0){
				$this->model_transaction->insert_trx_cm_detail_savingplan_account($data_savingplan_account);
			}

			$this->model_transaction->fn_create_jurnal_rembug($trx_cm_id);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true,'message'=>'Transaksi Berhasil !');
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Transaksi Gagal! Silahkan Hubungi Administrator untuk masalah ini.');
			}

			// $this->db->trans_begin();
			
			// if($this->db->trans_status()===true){
			// 	$this->db->trans_commit();
			// }else{
			// 	$this->db->trans_rollback();
			// }			


		}

		echo json_encode($return);
	}

	/**
	* JURNAL UMUM REV
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function jurnal_umum_rev()
	{
		$data['container'] = 'transaction/jurnal_umum_rev';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* GRID TABLE JURNAL UMUM REV
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function get_jurnal_umum_rev()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_jurnal_umum_rev('','','','',$from_date,$thru_date);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_jurnal_umum_rev($sidx,$sort,$limit_rows,$start,$from_date,$thru_date);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id'] = $row['trx_gl_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['trx_gl_id']
				,date('d/m/Y',strtotime(substr($row['trx_date'],0,10)))
				,date('d/m/Y',strtotime(substr($row['voucher_date'],0,10)))
				,$row['voucher_ref']
				,$row['description']
				,$row['total_debit']
				,$row['total_credit']
				,$row['fullname']
			);
			$i++;
		}

		echo json_encode($responce);
	}
	/**
	* GET JURNAL UMUM DETAIL
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function get_jurnal_umum_rev_detail()
	{
		$trx_gl_id=$this->input->post('trx_gl_id');
		$data=$this->model_transaction->get_trx_gl_detail($trx_gl_id);
		echo json_encode($data);
	}
	/**
	* PROSES SAVE UPDATE TRANSAKSI JURNAL UMUM
	* Rabu, 20 Agustus 2014
	* @author sayyid nurkilah
	*/
	public function update_transaksi_jurnal()
	{
		// echo "<pre>";
		// print_r($_POST);

		$branch_code 		= $this->input->post('branch_code');
		$no_referensi 		= $this->input->post('no_referensi2');
		$deskripsi 			= $this->input->post('deskripsi2');
		$tanggal 			= $this->input->post('tanggal2');
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal 			= substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);

		$gl_account_id 		= $this->input->post('gl_account_id');
		$account_code 		= $this->input->post('account_code');
		$credit 			= $this->convert_numeric($this->input->post('credit'));
		$debet 				= $this->convert_numeric($this->input->post('debet'));
		$description 		= $this->input->post('description');

		$account_group_code = $this->input->post('account_group_code');
		$account_type 		= $this->input->post('account_type');

		$trx_gl_id 			= $this->input->post('trx_gl_id');

		$data_trx_gl = array(
				// 'trx_gl_id' => $trx_gl_id,
				// 'trx_date' 	=> date("Y-m-d"),
				'voucher_date' => $tanggal,
				'voucher_ref' => $no_referensi,
				'branch_code' => $branch_code,
				// 'created_by' => $this->session->userdata('user_id'),
				// 'jurnal_trx_type' => 0,
				'description' => $deskripsi
				// 'created_date' => date('Y-m-d H:i:s')
			);
		$param_trx_gl = array('trx_gl_id'=>$trx_gl_id);

		$data_trx_gl_detail = array();
		for ( $i = 0 ; $i < count($gl_account_id) ; $i++ )
		{
			/** 1. mendapatkan flag D/C. Default = X 
			 * 	2. mencari amount
			 */
			$flag_debit_credit = 'X';
			$amount = 0;
			if ( $credit[$i] > $debet[$i] ) {
				$flag_debit_credit = 'C';
				$amount = $credit[$i];
			}
			else if ( $credit[$i] < $debet[$i] ) {
				$flag_debit_credit = 'D';
				$amount = $debet[$i];
			}
			

			$data_trx_gl_detail[] = array(
					'trx_gl_id' => $trx_gl_id,
					'account_code' => $account_code[$i],
					'flag_debit_credit' => $flag_debit_credit,
					'amount' => $amount,
					'description' => $description[$i],
					'trx_sequence' => $i
				);
		}

		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl($data_trx_gl,$param_trx_gl);
		$this->model_transaction->delete_trx_gl_detail($param_trx_gl);
		$this->model_transaction->insert_trx_gl_detail($data_trx_gl_detail);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'JURNAL BERHASIL DI REVISI!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to insert Journal ! please contact your administrator!');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/
	// JURNAL UMUM
	/****************************************************************************************/

	public function jurnal_umum()
	{
		$data['container'] = 'transaction/jurnal_umum';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->get_gl_account();

		echo json_encode($data);
	}

	public function process_transaksi_jurnal()
	{
		$branch_code 		= $this->input->post('branch_code');
		$no_referensi 		= $this->input->post('no_referensi2');
		$deskripsi 			= $this->input->post('deskripsi2');
		$tanggal 			= $this->input->post('tanggal2');
		$tanggal = str_replace('/', '', $tanggal);
		$tanggal 			= substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);

		$gl_account_id 		= $this->input->post('gl_account_id');
		$account_code 		= $this->input->post('account_code');
		$credit 			= $this->convert_numeric($this->input->post('credit'));
		$debet 				= $this->convert_numeric($this->input->post('debet'));
		$description 		= $this->input->post('description');

		$account_group_code = $this->input->post('account_group_code');
		$account_type 		= $this->input->post('account_type');

		$trx_gl_id 			= uuid(false);

		$data_trx_gl = array(
				'trx_gl_id' => $trx_gl_id,
				'trx_date' 	=> $tanggal,
				'voucher_date' => $tanggal,
				'voucher_ref' => $no_referensi,
				'branch_code' => $branch_code,
				'created_by' => $this->session->userdata('user_id'),
				'jurnal_trx_type' => 0,
				'description' => $deskripsi,
				'created_date' => date('Y-m-d H:i:s')
			);

		$data_trx_gl_detail = array();
		for ( $i = 0 ; $i < count($gl_account_id) ; $i++ )
		{
			/** 1. mendapatkan flag D/C. Default = X 
			 * 	2. mencari amount
			 */
			$flag_debit_credit = 'X';
			$amount = 0;
			if ( $credit[$i] > $debet[$i] ) {
				$flag_debit_credit = 'C';
				$amount = $credit[$i];
			}
			else if ( $credit[$i] < $debet[$i] ) {
				$flag_debit_credit = 'D';
				$amount = $debet[$i];
			}
			

			$data_trx_gl_detail[] = array(
					'trx_gl_id' => $trx_gl_id,
					'account_code' => $account_code[$i],
					'flag_debit_credit' => $flag_debit_credit,
					'amount' => $amount,
					'description' => $description[$i],
					'trx_sequence' => $i
				);
		}

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl($data_trx_gl);
		$this->model_transaction->insert_trx_gl_detail($data_trx_gl_detail);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'JURNAL BERHASIL DI TAMBAHKAN!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to insert Journal ! please contact your administrator!');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN DROPING KAS PETUGAS
	/****************************************************************************************/

	public function droping_kas_petugas()
	{
		$data['container'] = 'transaction/droping_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account_cash()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->ajax_get_gl_account_cash();

		echo json_encode($data);
	}

	public function process_droping()
	{
		$account_cash_id = $this->input->post('account_cash_id');
		$account_cash_name = $this->input->post('account_cash_name');
		$account_code = $this->input->post('account_code');
		$amount = $this->input->post('amount');
		$branch_code = $this->input->post('branch_code');
		$description = $this->input->post('description');
		$deskripsi2 = $this->input->post('deskripsi2');
		$fa_code = $this->input->post('fa_code');
		$no_referensi2 = $this->input->post('no_referensi2');
		$tanggal2 = $this->input->post('tanggal2');
		$tanggal2 = str_replace('/', '', $tanggal2);
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);


		$trx_gl_cash_id = uuid(false);
		$trx_gl_cash_data = array(
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'trx_date' => $tanggal2,
				'voucher_date' => $tanggal2,
				'description' => $deskripsi2,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s')
			);

		$trx_gl_cash_detail_data = array();
		for ( $i = 0 ; $i < count($account_cash_id) ; $i++ )
		{
			$trx_gl_cash_detail_data[] = array(
					'trx_gl_cash_detail_id' => uuid(false),
					'trx_gl_cash_id' => $trx_gl_cash_id,
					'account_cash_code' => $account_code[$i],
					'amount' => $amount[$i],
					'description' => $description[$i]
				);
		}

		$this->db->trans_begin();
		
		$this->model_transaction->insert_trx_gl_cash($trx_gl_cash_data);
		$this->model_transaction->insert_trx_gl_cash_detail($trx_gl_cash_detail_data);

		for ( $j = 0 ; $j < count($account_cash_id) ; $j++ )
		{
			$account_cash = $this->model_transaction->get_gl_account_cash_by_account_cash_id($account_cash_id[$j]);
			$gl_account_cash_param = array('account_cash_id'=>$account_cash_id[$j],'account_cash_code'=>$account_code[$j],'fa_code'=>$fa_code[$j]);
			$saldo = ($account_cash['saldo']+$amount[$j]);
			$gl_account_cash_data = array('saldo' => $saldo);

			$this->model_transaction->update_gl_account_cash($gl_account_cash_data,$gl_account_cash_param);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Droping Kas Sukses !');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Droping Kas Sukses !');
		}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// END DROPING KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SETORAN KAS PETUGAS
	/****************************************************************************************/

	public function setoran_kas_petugas()
	{
		$data['container'] = 'transaction/setoran_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_gl_account_cash_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');
		if($branch_code==false){
			$branch_code = "";
		}
		$data = $this->model_transaction->ajax_get_gl_account_cash_by_keyword($keyword,$branch_code,'0');

		echo json_encode($data);
	}

	public function ajax_get_cm_by_fa_code()
	{
		$fa_code = $this->input->post('fa_code');
		$data = $this->model_transaction->ajax_get_cm_by_fa_code($fa_code);

		echo json_encode($data);
	}

	public function process_setoran_kas_petugas()
	{
		$branch_code = $this->input->post('branch_code');
	    $tanggal2 = $this->input->post('tanggal2');
	    $tanggal2 = str_replace('/','',$tanggal2);
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	    $no_referensi2 = $this->input->post('no_referensi2');
	    $deskripsi2 = $this->input->post('deskripsi2');
	    $account_cash_id = $this->input->post('account_cash_id');
	    $account_cash_code = $this->input->post('account_cash_code');
	    $fa_code = $this->input->post('fa_code');
	    $account_code = $this->input->post('account_code');
	    $cm_id = $this->input->post('cm_id');
	    $cm_code = $this->input->post('cm_code');
	    $amount = $this->input->post('amount');
	    $description = $this->input->post('description');
	    $total_amount_def = $this->input->post('total_amount_def');
		$account_cash = $this->model_transaction->get_gl_account_cash_by_account_cash_id($account_cash_id);

		$trx_gl_cash_id = uuid(false);
		$trx_gl_cash_data = array(
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'trx_date' => $tanggal2,
				'voucher_date' => $tanggal2,
				'description' => $deskripsi2,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s')
			);
		$trx_gl_cash_detail_id = uuid(false);
		$trx_gl_cash_detail_data[] = array(
				'trx_gl_cash_detail_id' => $trx_gl_cash_detail_id,
				'trx_gl_cash_id' => $trx_gl_cash_id,
				'account_cash_code' => $account_cash_code,
				'amount' => $total_amount_def,
				'description' => $deskripsi2
			);

		$saldo = $account_cash['saldo']-$total_amount_def;

		$gl_account_cash_param = array(
									'account_cash_id'=>$account_cash_id
									,'account_cash_code'=>$account_cash_code
									,'fa_code'=>$fa_code
								);

		$gl_account_cash_data = array(
									'saldo' => $saldo
								);

		$trx_gl_cash_detail_cm = array();
		for ( $i = 0 ; $i < count($cm_id) ; $i++ )
		{
			$trx_gl_cash_detail_cm_data[] = array(
												'trx_gl_cash_detail_id' => $trx_gl_cash_detail_id,
												'cm_code' => $cm_code[$i],
												'amount' => $amount[$i],
												'description' => $description[$i]
											);
		}

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl_cash($trx_gl_cash_data);
		$this->model_transaction->insert_trx_gl_cash_detail($trx_gl_cash_detail_data);
		$this->model_transaction->update_gl_account_cash($gl_account_cash_data,$gl_account_cash_param);
		$this->model_transaction->insert_trx_gl_cash_detail_cm($trx_gl_cash_detail_cm_data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Setoran Kas Sukses !');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Setoran Kas Gagal !');
		}

		echo json_encode($return);
	}

	/* BEGIN DEBET ANGSURAN **************************************************************/

	public function pendebetan_angsuran()
	{
		$data['container'] = 'transaction/pendebetan_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function ajax_get_data_pendebetan_angsuran_pembiayaan()
	{
		$branch_code = $this->input->post('branch_code');
		$tanggal_jto = $this->input->post('tanggal_jto');
	    $tanggal_jto = str_replace('/', '', $tanggal_jto);
		$tanggal_jto = substr($tanggal_jto,4,4).'-'.substr($tanggal_jto,2,2).'-'.substr($tanggal_jto,0,2);

		$data = $this->model_transaction->get_data_pendebetan_angsuran_pembiayaan($tanggal_jto);

		echo json_encode($data);
	}

	public function process_pendebetan_angsuran_pembiayaan()
	{
		$branch_id 				= $this->input->post('branch_id');
		$branch_code 			= $this->input->post('branch_code');
	    $tanggal_jto 			= $this->input->post('tanggal_jto2');
	    $tanggal_jto = str_replace('/', '', $tanggal_jto);
	    $account_financing_no 	= $this->input->post('account_financing_no');
	    $angsuran_pokok 		= $this->convert_numeric($this->input->post('angsuran_pokok'));
	    $angsuran_margin 		= $this->convert_numeric($this->input->post('angsuran_margin'));
	    $angsuran_tabungan 		= $this->convert_numeric($this->input->post('angsuran_tabungan'));
	    $angsuran 				= $this->convert_numeric($this->input->post('angsuran'));
	    $jto_angsuran 			= $this->input->post('jto_angsuran');
	    $saldo_tabungan 		= $this->convert_numeric($this->input->post('saldo_tabungan'));
	    $jto_next 				= $this->input->post('jtempo_angsuran_next');
	    $flag_jadwal_angsuran	= $this->input->post('flag_jadwal_angsuran');
	    $tanggal_transaksi 		= $this->input->post('tanggal_transaksi');
	    $tanggal_transaksi 		= $this->datepicker_convert(true,$tanggal_transaksi,'/');
	    $success=0;
	    $failed=0;
	    $sub_success=0;
	    $sub_success_desc = '';
	    $sub_failed=0;
	    $sub_failed_desc = '';

	    for ( $i = 0 ; $i < count($account_financing_no) ; $i++ )
	    {
	    	$get_data_financing = $this->model_transaction->get_account_financing_by_account_financing_no($account_financing_no[$i]);

	    	if(count($get_data_financing)>0)
	    	{
	    		$jtempo_angsuran_last 	= $get_data_financing['jtempo_angsuran_last'];
	    		$jtempo_angsuran_next 	= $get_data_financing['jtempo_angsuran_next'];
				$periode_jangka_waktu 	= $get_data_financing['periode_jangka_waktu']; // 0 = harian, 1=mingguan, 2=bulanan, 3=jtempo
				$jangka_waktu 			= $get_data_financing['jangka_waktu'];
				$jtempo_db 				= $get_data_financing['tanggal_jtempo'];
				$counter_angsuran 		= $get_data_financing['counter_angsuran'];
				$counter_angsuran2 		= $counter_angsuran;
				$total_counter_angsuran = $get_data_financing['counter_angsuran']+$jto_angsuran[$i];
				$saldo_pokok 			= $get_data_financing['saldo_pokok'];
				$saldo_margin 			= $get_data_financing['saldo_margin'];
				$saldo_catab 			= $get_data_financing['saldo_catab'];

				$account_financing_schedulle_id=array();
				if($flag_jadwal_angsuran[$i]==0){
					for($z=0;$z<$jto_angsuran[$i];$z++){
						$account_financing_schedulle_id[] = $this->model_transaction->get_account_financing_schedulle_id($account_financing_no[$i],$z);
					}
					$new_jtempo_angsuran_next = $this->model_transaction->get_jtempo_angsuran_next_by_schedulle($account_financing_no[$i],$jto_angsuran[$i]);
					$jtempo_angsuran_last = $jtempo_angsuran_next;
					$jtempo_angsuran_next = $new_jtempo_angsuran_next;
				}else{
					if($periode_jangka_waktu==0){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +'.(1*$jto_angsuran[$i]).' days'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.(1*$jto_angsuran[$i]).' days'));
					}
					else if($periode_jangka_waktu==1){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +'.(7*$jto_angsuran[$i]).' days'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.(7*$jto_angsuran[$i]).' days'));
					}
					else if($periode_jangka_waktu==2){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +'.(1*$jto_angsuran[$i]).' month'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +'.(1*$jto_angsuran[$i]).' month'));
					}
					else if($periode_jangka_waktu==3){
						$jtempo_angsuran_next = $jtempo_db;
					}
				}

				/*
				| calculate total angsuran pokok
				| calculate total angsuran margin
				| calculate total angsuran tabungan
				*/
				$total_angsuran_pokok[$i]=0;
				$total_angsuran_margin[$i]=0;
				$total_angsuran_tabungan[$i]=0;
				$hit_saldo_pokok=$saldo_pokok;
				for($x=0;$x<$jto_angsuran[$i];$x++){

					$counter_angsuran++;
					// jika non reguler
					if($flag_jadwal_angsuran[$i]==0){
						$rowfinancing_schedulle = $this->model_transaction->get_account_financing_schedulle_by_offset($account_financing_no[$i],$x);
						$angsuran_pokok[$i] = round($rowfinancing_schedulle['angsuran_pokok'],0);
						$angsuran_margin[$i] = round($rowfinancing_schedulle['angsuran_margin'],0);
						$angsuran_tabungan[$i] = round($rowfinancing_schedulle['angsuran_tabungan'],0);
					}

					if($counter_angsuran==$jangka_waktu){
						$total_angsuran_pokok[$i]+=$hit_saldo_pokok;
					}else{
						$total_angsuran_pokok[$i]+=$angsuran_pokok[$i];
					}
					
					$total_angsuran_margin[$i]+=$this->convert_numeric($angsuran_margin[$i]);
					$total_angsuran_tabungan[$i]+=$angsuran_tabungan[$i];

					if($counter_angsuran==$jangka_waktu){
						$hit_saldo_pokok-=$hit_saldo_pokok;
					}else{
						$hit_saldo_pokok-=$angsuran_pokok[$i];
					}
				}
				
				$total_angsuran[$i]=$total_angsuran_pokok[$i]+$total_angsuran_margin[$i]+$total_angsuran_tabungan[$i];

				// if($account_financing_no[$i]=="000001500015101"){
				// 	echo $total_angsuran_pokok[$i];
				// 	echo '<br>';
				// 	echo $total_angsuran_margin[$i];
				// 	echo '<br>';
				// 	echo $total_angsuran_tabungan[$i];
				// 	// echo $total_angsuran_pokok[$i];
				// 	// echo '<br>';
				// 	// echo $jto_angsuran[$i];
				// 	// echo $saldo_pokok;
				// 	// echo $saldo_margin;
				// 	// echo $total_angsuran_margin[$i];
				// 	// echo '<br>';
				// 	// echo $angsuran_margin[$i];
				// 	// echo "<pre>";
				// 	// print_r($_POST);
				// 	die();
				// }
				
		    	// update mfi_account_financing
		    	$data_account_financing = array(
		    			'saldo_pokok' => $get_data_financing['saldo_pokok']-$total_angsuran_pokok[$i],
		    			'saldo_margin' => $get_data_financing['saldo_margin']-$total_angsuran_margin[$i],
		    			'saldo_catab' => $get_data_financing['saldo_catab']+$total_angsuran_tabungan[$i],
		    			'jtempo_angsuran_last' => $jtempo_angsuran_last,
		    			'jtempo_angsuran_next' => $jtempo_angsuran_next,
		    			'counter_angsuran' => $total_counter_angsuran
		    		);

		    	/*pelunasan*/
		    	// if($get_data_financing['saldo_pokok']-$total_angsuran_pokok[$i]==0){
		    	// 	$data_account_financing['status_rekening']=2;
		    	// }
		    	
		    	$param_account_financing = array('account_financing_no' => $account_financing_no[$i]);

		    	
		    	// update mfi_account_saving
		    	$data_account_saving = array('saldo_memo' => $saldo_tabungan[$i]-$total_angsuran[$i]);
		    	$param_account_saving = array('account_saving_no' => $get_data_financing['account_saving_no']);

		    	$jtempo_angsuran_last 	= $get_data_financing['jtempo_angsuran_last'];
	    		$jtempo_angsuran_next 	= $get_data_financing['jtempo_angsuran_next'];
		    	
		    	$hit_saldo_pokok2=0;
		    	for ( $j = 0 ; $j < $jto_angsuran[$i] ; $j++ )
		    	{
		    		$counter_angsuran2++;

					// jika non reguler
					if($flag_jadwal_angsuran[$i]==0){
						$rowfinancing_schedulle = $this->model_transaction->get_account_financing_schedulle_by_offset($account_financing_no[$i],$j);
						$angsuran_pokok[$i] = round($rowfinancing_schedulle['angsuran_pokok'],0);
						$angsuran_margin[$i] = round($rowfinancing_schedulle['angsuran_margin'],0);
						$angsuran_tabungan[$i] = round($rowfinancing_schedulle['angsuran_tabungan'],0);
					}

		    		if($counter_angsuran2==$jangka_waktu){
						$angsuran_pokok[$i]=$hit_saldo_pokok2;
					}

					if($counter_angsuran2==$jangka_waktu){
						$hit_saldo_pokok2-=$hit_saldo_pokok2;
					}else{
						$hit_saldo_pokok2-=$angsuran_pokok[$i];
					}

					$total_angsuran2[$i] = $angsuran_pokok[$i]+$this->convert_numeric($angsuran_margin[$i])+$angsuran_tabungan[$i];

		    		if($periode_jangka_waktu==0){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 days'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +1 days'));
					}
					else if($periode_jangka_waktu==1){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +7 days'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +7 days'));
					}
					else if($periode_jangka_waktu==2){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 month'));
						$jtempo_angsuran_last = date("Y-m-d",strtotime($jtempo_angsuran_last.' +1 month'));
					}
					else if($periode_jangka_waktu==3){
						$jtempo_angsuran_next = $jtempo_db;
					}

			    	$trx_detail_id = uuid(false);

			    	// insert mfi_trx_detail
			    	$data_trx_detail = array(
			    			'trx_detail_id' => $trx_detail_id,
			    			'trx_type' => 1,
			    			'trx_account_type' => 3,
			    			'account_no' => $get_data_financing['account_saving_no'],
			    			'flag_debit_credit' => 'D',
			    			'amount' => $total_angsuran2[$i],
			    			'trx_date' => $tanggal_transaksi,
			    			'created_by' => $this->session->userdata('user_id'),
			    			'created_date' => date('Y-m-d H:i:s'),
			    			'account_no_dest' => $account_financing_no[$i],
			    			'account_type_dest' => 1
			    		);

		    		// insert ke mfi_trx_account_saving
		    		$data_trx_account_financing = array(
		    				'trx_account_financing_id' => uuid(false),
		    				'branch_id' => $branch_id,
		    				'trx_detail_id' => $trx_detail_id,
		    				'account_financing_no' => $get_data_financing['account_financing_no'],
		    				'trx_financing_type' => 1,
		    				'trx_date' => $tanggal_transaksi,
		    				'jto_date' => $jtempo_angsuran_last,
		    				'pokok' => $angsuran_pokok[$i],
		    				'margin' => $this->convert_numeric($angsuran_margin[$i]),
		    				'catab' => $angsuran_tabungan[$i],
		    				'created_date' => date('Y-m-d H:i:s'),
		    				'created_by' => $this->session->userdata('user_id'),
		    				'freq' => 1,
		    				'description' => 'PEMBAYARAN ANGSURAN Rek.'.$get_data_financing['account_saving_no']
		    			);

			    	// insert mfi_trx_account_saving
			    	$data_trx_account_saving = array(
			    			'trx_detail_id' => $trx_detail_id,
			    			'trx_account_saving_id' => uuid(false),
			    			'branch_id' => $branch_id,
			    			'account_saving_no' => $get_data_financing['account_saving_no'],
			    			'trx_saving_type' => 3,
			    			'flag_debit_credit' => 'D',
			    			'trx_date' => $tanggal_transaksi,
			    			'amount' => $total_angsuran2[$i],
			    			'created_date' => date('Y-m-d H:i:s'),
			    			'created_by' => $this->session->userdata('user_id'),
			    			'verify_by' => $this->session->userdata('user_id'),
			    			'verify_date' => date('Y-m-d H:i:s'),
			    			'trx_status' => 1,
			    			'description' => 'PEMBAYARAN ANGSURAN Rek.'.$get_data_financing['account_saving_no']
			    		);

		    		$this->db->trans_begin();
		    		$this->model_transaction->insert_trx_account_financing($data_trx_account_financing);
			    	$this->model_transaction->insert_trx_account_saving($data_trx_account_saving);
			    	$this->model_transaction->insert_trx_detail($data_trx_detail);
		    		if($this->db->trans_status()===true){
		    			$this->db->trans_commit();
		    			$sub_success++;
		    		}else{
		    			$this->db->trans_rollback();
		    			$sub_failed++;
		    		}
		    	}
		    	$sub_success_desc .= '<success> Line '.$i.' : '.$sub_success.' <br>';
		    	$sub_failed_desc .= '<failed> Line '.$i.' : '.$sub_failed.' <br>';

		    	$this->db->trans_begin();

		    	if($jto_angsuran[$i]>0)
		    	{
		    		// jika non reguler
					if($flag_jadwal_angsuran[$i]==0){

						for($h=0;$h<count($account_financing_schedulle_id);$h++){

							$financing_schedulle = $this->model_transaction->get_account_financing_schedulle_by_id($account_financing_schedulle_id[$h]);
							$data_account_financing_schedulle = array(
									'status_angsuran'=>'1',
									'bayar_pokok'=>$financing_schedulle['angsuran_pokok'],
									'bayar_margin'=>$financing_schedulle['angsuran_margin'],
									'bayar_tabungan'=>$financing_schedulle['angsuran_tabungan']
								);
							$param_account_financing_schedulle = array('account_financing_schedulle_id'=>$account_financing_schedulle_id[$h]);
	    					$this->model_transaction->update_account_financing_schedulle($data_account_financing_schedulle,$param_account_financing_schedulle);
							
						}

    				}
			    	$this->model_transaction->update_account_financing($data_account_financing,$param_account_financing);
		    		$this->model_transaction->update_account_saving($data_account_saving,$param_account_saving);
			    }

		    	if($this->db->trans_status()===true){
		    		$this->db->trans_commit();
		    		$success++;
		    	}else{
		    		$this->db->trans_rollback();
		    		$failed++;
		    	}

		    } // end if

	    } // end for


	    if($success>0)
	    {
		    $return = array(
		    		'success' => true,
		    		'num_success'=>$success,
		    		'num_failed'=>$failed,
		    		'sub_success_desc' => $sub_success_desc,
		    		'sub_failed_desc' => $sub_failed_desc
		    	);
		}
		else
		{
		    $return = array(
		    		'success' => false,
		    		'num_success'=>$success,
		    		'num_failed'=>$failed,
		    		'sub_success_desc' => $sub_success_desc,
		    		'sub_failed_desc' => $sub_failed_desc
		    	);
		}

		echo json_encode($return);

	} // end function process_pendebetan_angsuran_pembiayaan()


	/* END DEBET ANGSURAN **************************************************************/


	/****************************************************************************************/	
	// BEGIN KAS PETUGAS
	/****************************************************************************************/
	public function kas_petugas()
	{
		$data['container']  = 'transaction/kas_petugas';
		$branch_code 		= $this->session->userdata('branch_code');
		$data['kas_petugas']= $this->model_transaction->get_fa_by_branch_code($branch_code);		
		$data['kas_teller'] = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}


	public function datatable_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','trx_date','account_cash_code','account_teller_code','mfi_trx_gl_cash.trx_gl_cash_type','mfi_trx_gl_cash.amount','mfi_trx_gl_cash.description','');
				
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

		$rResult 			= $this->model_transaction->datatable_transaksi_kas_petugas($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_transaksi_kas_petugas($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_transaksi_kas_petugas(); // get number of all data
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
			if ($aRow['trx_gl_cash_type']==1) 
			{
				$jenis_trx = "droping kas";
			} 
			else if ($aRow['trx_gl_cash_type']==2) 
			{
				$jenis_trx = "setoran rembug";
			}
			else if ($aRow['trx_gl_cash_type']==3) 
			{
				$jenis_trx = "penarikan rembug";
			}
			else if ($aRow['trx_gl_cash_type']==4) 
			{
				$jenis_trx = "setor ke teller";
			}
			
			$row[] = '<input type="checkbox" value="'.$aRow['trx_gl_cash_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['trx_date'];
			$row[] = $aRow['kode_kas_petugas'];
			$row[] = $aRow['kode_kas_teller'];
			$row[] = $jenis_trx;
			$row[] = '<div align="right">'.number_format($aRow['amount'],0,',','.').'</div>';
			$row[] = $aRow['description'];
			$row[] = '<a href="javascript:;" trx_gl_cash_id="'.$aRow['trx_gl_cash_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_trx_by_trx_gl_cash_id()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');
		$data = $this->model_transaction->get_trx_by_trx_gl_cash_id($trx_gl_cash_id);

		echo json_encode($data);
	}


	public function get_fa_by_branch_code()
	{
		$branch_code = $this->session->userdata('branch_code');;
		$data = $this->model_transaction->get_fa_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function get_account_cash_code_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function add_kas_petugas()
	{
		$trx_gl_cash_id		 	= uuid(false);

		$angs_tanggal	 = $this->input->post('trx_date');
		$angs_tanggal = str_replace('/', '', $angs_tanggal);
		$tg_angsuran = substr($angs_tanggal,0,2);
		$bl_angsuran = substr($angs_tanggal,2,2);
		$th_angsuran = substr($angs_tanggal,4,4);
		$trx_date 	 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$account_cash_code		= $this->input->post('kas_petugas');
		$trx_gl_cash_type		= $this->input->post('jenis_transaksi');
		if ($trx_gl_cash_type==1) 
		{			
			$flag_debet_credit		= 'D';
		} 
		else 
		{
			$flag_debet_credit		= 'C';
		}		
		$account_teller_code 	= $this->input->post('kas_teller');
		$voucher_date		 	= $this->current_date();
		$voucher_ref		 	= $this->input->post('no_referensi');
		$description		 	= $this->input->post('keterangan');
		$created_by 		  	= $this->session->userdata('user_id');
		$created_date		 	= date('Y-m-d H:i:s');
		$amount				 	= $this->input->post('jumlah_setoran');
		
		$data = array(
						 'trx_gl_cash_id'		=> $trx_gl_cash_id
						,'trx_date'				=> $trx_date
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> $trx_gl_cash_type
						,'flag_debet_credit'	=> $flag_debet_credit
						,'account_teller_code'	=> $account_teller_code
						,'voucher_date'			=> $voucher_date
						,'voucher_ref'			=> $voucher_ref
						,'description'			=> $description
						,'created_by'			=> $created_by
						,'created_date'			=> $created_date
						,'amount'				=> str_replace('.','',$amount)
						,'status' 				=> 0
					);
		
		$this->db->trans_begin();
		$this->model_transaction->add_kas_petugas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	
	public function edit_kas_petugas()
	{	
		$trx_gl_cash_id		 	= $this->input->post('trx_gl_cash_id');

		$angs_tanggal	 = $this->input->post('trx_date2');
		$angs_tanggal = str_replace('/', '', $angs_tanggal);
			$tg_angsuran = substr($angs_tanggal,0,2);
			$bl_angsuran = substr($angs_tanggal,2,2);
			$th_angsuran = substr($angs_tanggal,4,4);
			$trx_date 	 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$account_cash_code		= $this->input->post('kas_petugas2');
		$trx_gl_cash_type		= $this->input->post('jenis_transaksi2');
			if ($trx_gl_cash_type==1) 
			{			
				$flag_debet_credit		= 'D';
			} 
			else 
			{
				$flag_debet_credit		= 'C';
			}		
		$account_teller_code 	= $this->input->post('kas_teller2');
		$voucher_date		 	= $this->current_date();
		$voucher_ref		 	= $this->input->post('no_referensi2');
		$description		 	= $this->input->post('keterangan2');
		$created_by 		  	= $this->session->userdata('user_id');
		$created_date		 	= date('Y-m-d H:i:s');
		$amount				 	= $this->input->post('jumlah_setoran2');
		
		
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);
		$data = array(
						 'trx_gl_cash_id'		=> $trx_gl_cash_id
						,'trx_date'				=> $trx_date
						,'account_cash_code'	=> $account_cash_code
						,'trx_gl_cash_type'		=> $trx_gl_cash_type
						,'flag_debet_credit'	=> $flag_debet_credit
						,'account_teller_code'	=> $account_teller_code
						,'voucher_date'			=> $voucher_date
						,'voucher_ref'			=> $voucher_ref
						,'description'			=> $description
						,'created_by'			=> $created_by
						,'created_date'			=> $created_date
						,'amount'				=> str_replace('.','',$amount)
						,'status' 				=> 0
					);
		
		$this->db->trans_begin();
		$this->model_transaction->edit_kas_petugas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	
	public function delete_kas_petugas()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_gl_cash_id) ; $i++ )
		{
			$param = array('trx_gl_cash_id'=>$trx_gl_cash_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_kas_petugas($param);
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


	public function verifikasi_transaksi_kas_petugas()
	{
		$data['container']  = 'transaction/verifikasi_kas_petugas';
		$branch_code 		= $this->session->userdata('branch_code');
		$data['kas_petugas']= $this->model_transaction->get_fa_by_branch_code($branch_code);		
		$data['kas_teller'] = $this->model_transaction->get_account_cash_code_by_branch_code($branch_code);
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$from_date  = str_replace('/','',@$_GET['from_date']);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date  = str_replace('/','',@$_GET['thru_date']);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
		$aColumns = array( '','trx_date','account_cash_code','account_teller_code','mfi_trx_gl_cash.trx_gl_cash_type','mfi_trx_gl_cash.amount','mfi_trx_gl_cash.description','');
				
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas($sWhere,$sOrder,$sLimit,$from_date,$thru_date); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas($sWhere,'','',$from_date,$thru_date); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_transaksi_kas_petugas('','','',$from_date,$thru_date); // get number of all data
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
			if ($aRow['trx_gl_cash_type']==1) 
			{
				$jenis_trx = "droping kas";
			} 
			else if ($aRow['trx_gl_cash_type']==2) 
			{
				$jenis_trx = "setoran rembug";
			}
			else if ($aRow['trx_gl_cash_type']==3) 
			{
				$jenis_trx = "penarikan rembug";
			}
			else if ($aRow['trx_gl_cash_type']==4) 
			{
				$jenis_trx = "setor ke teller";
			}
			
			$row[] = '<input type="checkbox" value="'.$aRow['trx_gl_cash_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = '<div align="center">'.$aRow['trx_date'].'</div>';
			$row[] = $aRow['kode_kas_petugas'];
			$row[] = $aRow['kode_kas_teller'];
			$row[] = $jenis_trx;
			$row[] = '<div align="right">'.number_format($aRow['amount'],0,',','.').'</div>';
			$row[] = $aRow['description'];
			$row[] = '<a href="javascript:;" trx_gl_cash_id="'.$aRow['trx_gl_cash_id'].'" id="link-verifikasi">Verifikasi</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function verifikasi_reject_kas_petugas()
	{
		$trx_gl_cash_id = $this->input->post('trx_gl_cash_id');
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);
		$this->db->trans_begin();
		$this->model_transaction->delete_kas_petugas($param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function verifikasi_approve_kas_petugas()
	{

		$trx_gl_id	 	 	 = uuid(false);
		$trx_gl_cash_id	 	 = $this->input->post('trx_gl_cash_id');
		$angs_tanggal	 	 = $this->input->post('trx_date2');
		$angs_tanggal 		 = str_replace('/', '', $angs_tanggal);
		$tg_angsuran 		 = substr($angs_tanggal,0,2);
		$bl_angsuran 		 = substr($angs_tanggal,2,2);
		$th_angsuran 		 = substr($angs_tanggal,4,4);
		$trx_date 	 		 = "$th_angsuran-$bl_angsuran-$tg_angsuran";
		$voucher_date		 = $this->current_date();
		$voucher_ref		 = $this->input->post('no_referensi2');
		$branch_code 		 = $this->session->userdata('branch_code');
		$description		 = $this->input->post('keterangan2');
		$created_by 		 = $this->session->userdata('user_id');
		$created_date		 = date('Y-m-d H:i:s');
		$account_cash_code	 = $this->input->post('kas_petugas2_hidden');
		$account_teller_code = $this->input->post('kas_teller2_hidden');
		$trx_gl_cash_type	 = $this->input->post('jenis_transaksi2');
		$amount	 			 = $this->convert_numeric($this->input->post('jumlah_setoran2'));

		// if($trx_gl_cash_type==1){
		// 	$flag_debit_credit1 = "D";
		// 	$trx_sequence1 	    = 0;
		// 	$flag_debit_credit2 = "C";
		// 	$trx_sequence2 	    = 1;
		// }else{
		// 	$flag_debit_credit1 = "C";
		// 	$trx_sequence1 	    = 1;
		// 	$flag_debit_credit2 = "D";
		// 	$trx_sequence2 	    = 0;
		// }

		// $account_code_petugas = $this->model_transaction->get_account_code_petugas($account_cash_code);
		// $account_code_teller  = $this->model_transaction->get_account_code_teller($account_teller_code);
		
		// $data = array(
		// 				 'trx_gl_id'		=> $trx_gl_id
		// 				,'trx_date'			=> date("Y-m-d")
		// 				,'voucher_date'		=> $trx_date
		// 				,'voucher_ref'		=> $voucher_ref
		// 				,'branch_code'		=> $branch_code
		// 				,'jurnal_trx_type'	=> 0
		// 				,'created_by'		=> $created_by
		// 				,'created_date'		=> $created_date
		// 				,'description'		=> $description
		// 			);

		$data2 = array('status'=>1,'trx_gl_id'=>$trx_gl_id);
		$param = array('trx_gl_cash_id'=>$trx_gl_cash_id);

		// $data3 = array(
		// 			 'trx_gl_id'			=> $trx_gl_id
		// 			,'account_code'			=> $account_code_petugas
		// 			,'flag_debit_credit'	=> $flag_debit_credit1
		// 			,'amount'				=> $amount
		// 			,'description'			=> ''
		// 			,'trx_sequence'			=> $trx_sequence1
		// 			);

		// $data4 = array(
		// 			 'trx_gl_id'			=> $trx_gl_id
		// 			,'account_code'			=> $account_code_teller
		// 			,'flag_debit_credit'	=> $flag_debit_credit2
		// 			,'amount'				=> $amount
		// 			,'description'			=> ''
		// 			,'trx_sequence'			=> $trx_sequence2
					// );
		
		$this->db->trans_begin();
		$this->model_transaction->update_status_gl_cash($data2,$param);
		$this->model_transaction->fn_proses_jurnal_kaspetugas($trx_gl_cash_id);
		// $this->model_transaction->insert_mfi_trx_gl($data);
		// $this->model_transaction->insert_mfi_trx_gl_detail($data3);
		// $this->model_transaction->insert_mfi_trx_gl_detail($data4);
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
	// END KAS PETUGAS
	/****************************************************************************************/

	public function ajax_form_detail_setoran_tab_berencana()
	{
		$cif_no = $this->input->post('cif_no');

		$data = $this->model_transaction->get_tabungan_berencana_by_cif_no($cif_no);

		echo json_encode($data);
	}



	public function get_ajax_biaya_premi_asuransi()
	{
		$product 				= $this->input->post('produkpremi');
		$manfaat 				= $this->input->post('total');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('/', '', $tgl_lahir);
		$tanggal_akad 			= $this->input->post('tgl_akad');
		$tanggal_akad 			= str_replace('/', '', $tanggal_akad);
		//$tanggal_mulai_angsur 	= $this->input->post('angsuranke1');
		$tanggal_jtempo			= $this->input->post('tgl_jtempo');
		$tanggal_jtempo 		= str_replace('/', '', $tanggal_jtempo);

		//Merubah format tanggal ke dalam format Inggris Untuk tanggal akad
		$tgl_akad 			=substr("$tanggal_akad",0,2);
	    $bln_akad 			=substr("$tanggal_akad",2,2);
	    $thn_akad	 		=substr("$tanggal_akad",4,4);
	    $tglakhir_akad		= "$thn_akad-$bln_akad-$tgl_akad";  

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Angsuran
		/*$tgl_mulai_angsur 	=substr("$tanggal_mulai_angsur",0,2);
	    $bln_mulai_angsur 	=substr("$tanggal_mulai_angsur",2,2);
	    $thn_mulai_angsur	=substr("$tanggal_mulai_angsur",4,4);
	    $tglakhir_angsur	= "$thn_mulai_angsur-$bln_mulai_angsur-$tgl_mulai_angsur"; */

	    //Merubah format tanggal ke dalam format Inggris Untuk tanggal Jatuh Tempo
		$tgl_jtempo     	=substr("$tanggal_jtempo",0,2);
	    $bln_jtempo     	=substr("$tanggal_jtempo",2,2);
	    $thn_jtempo	        =substr("$tanggal_jtempo",4,4);
	    $tglakhir_jtempo	= "$thn_jtempo-$bln_jtempo-$tgl_jtempo";

		$awal_kontrak 		= $tglakhir_akad;
		$akhir_kontrak 		= $tglakhir_jtempo;
		$diff = abs(strtotime($akhir_kontrak) - strtotime($awal_kontrak));

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		if($months>0){
			$years++;
		}

		/*echo $years;
		echo $months;
		die();*/
/*
		$masa_kontrak_tahun = $years;
		$masa_kontrak_bulan = $months;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$awal_lahir 		= $tgl_lahir;
		$tanggal_skrng 		= date('Y-m-d');
		$difff = abs(strtotime($tanggal_skrng) - strtotime($awal_lahir));

		$year = floor($difff / (365*60*60*24));
		$month = floor(($difff - $year * 365*60*60*24) / (30*60*60*24));
		$day = floor(($difff - $year * 365*60*60*24 - $month*30*60*60*24)/ (60*60*24));
		if($month>0){
			$year++;
		}

		/*echo $year;
		echo $month;
		die();*/
/*
		$usia_tahun = $year;
		$usia_bulan = $month;*/
		//echo 'year:'.$years.'. months:'.$months.'. days:'.$days;

		$data = $this->model_transaction->get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months);
		if($data==null){
			$data=0;
		}

		echo json_encode(array('p_asuransi_jiwa'=>$data));
	}

	public function get_ajax_produk_by_cif_type()
	{
		$cif_type_hidden = $this->input->post('cif_type');
		// $jenis_pembiayaan='';
		if($cif_type_hidden=='0')
		{
			// $jenis_pembiayaan=1;
			$data = $this->model_transaction->get_ajax_produk_by_cif_type0();
		}
		else if($cif_type_hidden=='1')
		{
			$data = $this->model_transaction->get_ajax_produk_by_cif_type1();
		}

		echo json_encode($data);
	}

	public function check_account_financing_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');

		$no_validation = $this->model_transaction->check_account_financing_no($account_financing_no);

		if($no_validation==true){
			$return = array('stat'=>true,'message'=>'No Rekening Berlaku');
		}else{
			$return = array('stat'=>false,'message'=>'No Rekening Sudah Terdaftar dan Aktif');
		}

		echo json_encode($return);

	}

	public function get_ajax_produk_by_cif_type_link_edit()
	{
		$cif_type_hidden = $this->input->post('cif_type');
		// $cif_type_hidden = $this->input->post('cif_type_hidden2');
		// $jenis_pembiayaan='';
		if($cif_type_hidden=='0')
		{
			// $jenis_pembiayaan=1;
			$data = $this->model_transaction->get_ajax_produk_by_cif_type_link_edit0();
		}
		else if($cif_type_hidden=='1')
		{
			$data = $this->model_transaction->get_ajax_produk_by_cif_type_link_edit1();
		}

		echo json_encode($data);
	}

	//Fungsi Mencari No Registrasi Pembiayaan pada tabel mfi_account_financing_reg
	public function search_no_reg()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('cif_type');
		$cm_code = $this->input->post('cm_code');
		$data = $this->model_transaction->search_no_reg($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	//Fungsi untuk mencari data CIF ketika Button Select di tekan
	public function get_ajax_value_from_no_reg()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_ajax_value_from_no_reg($cif_no);

		echo json_encode($data);
	}

	//Fungsi untuk mencari tanggal akad
	public function ajax_get_tanggal_akad()
	{
		$tgl_akhir_pengajuan 	= $this->input->post('tgl_akhir_pengajuan');
		$tgl_akhir_pengajuan 	= $this->datepicker_convert(true,$tgl_akhir_pengajuan,'/');
		$hari 					= '7';
		$hari2 					= '14';
		$hari3 					= '21';

			$tgl_akad 			= date('d/m/Y',strtotime($tgl_akhir_pengajuan. '+'.$hari.' days'));
			$angsuranke1 		= date('d/m/Y',strtotime($tgl_akhir_pengajuan. '+'.$hari2.' days'));
			$tgl_jtempo 		= date('d/m/Y',strtotime($tgl_akhir_pengajuan. '+'.$hari3.' days'));

		echo json_encode(array('tgl_akad'=>$tgl_akad,'angsuranke1'=>$angsuranke1,'tgl_jtempo'=>$tgl_jtempo));
	}

	public function ajax_get_tanggal_akad2()
	{
		$tgl_pengajuan = $this->input->post('tgl_pengajuan');
		$periode_angsuran = $this->input->post('periode_angsuran');
		// $grace_periode = $this->model_transaction->get_grace_periode();
		// switch ($periode_angsuran) {
		// 	case '0'://harian
		// 		$grace=substr($grace_periode, 0,1); // digit 1
		// 		$tgl_akad = date('d/m/Y',strtotime($tgl_pengajuan.'+'.$grace.' days'));
		// 		break;
		// 	case '1'://mingguan
		// 		$grace=substr($grace_periode, 1,1); // digit 2
		// 		$tgl_akad = date('d/m/Y',strtotime($tgl_pengajuan.'+'.$grace.' week'));
		// 		break;
		// 	case '2'://bulanan
		// 		$grace=substr($grace_periode, 2,1); // digit 3
		// 		$tgl_akad = date('d/m/Y',strtotime($tgl_pengajuan.'+'.$grace.' month'));
		// 		break;
		// 	case '3': //jatuh tempo
		// 		$tgl_akad = date('d/m/Y');
		// 		break;
		// 	default: //default
		// 		$tgl_akad = $tgl_pengajuan;
		// 		break;
		// }

		$tgl_akad = date('d/m/Y');
		echo json_encode(array('tgl_akad'=>$tgl_akad));
	}

	//Fungsi untuk memanggil status rekening pembiayaan
	public function get_status_rekening_from_account_financing()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_status_rekening_from_account_financing($account_financing_no);

		echo json_encode($data);
	}


	//verifikasi transaksi rembug
	public function verifikasi_trx_rembug()
	{
		$data['container'] = 'transaction/verifikasi_trx_rembug';
		$data['title'] = 'Verifikasi Transaksi Rembug';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	//datatable verifikasi transaksi rembug
	public function datatable_verifikasi_trx_rembug()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		
		$branch_id 			= @$_GET['branch_id'];
		$branch_code 		= @$_GET['branch_code'];
		$trx_date 			= @$_GET['trx_date'];
		$trx_date 			= str_replace('/', '', $trx_date);
		$tgl_trx_date 		= substr($trx_date,0,2);
	    $bln_trx_date 		= substr($trx_date,2,2);
	    $thn_trx_date 		= substr($trx_date,4,4);
	    
	    if($trx_date!="")
	    	$trx_date 			= "$thn_trx_date-$bln_trx_date-$tgl_trx_date"; 
	    
	    // echo $trx_date;
	    // die();

		$aColumns 			= array( 'mfi_cm.cm_name','mfi_trx_cm_save.trx_date','mfi_gl_account_cash.account_cash_name','');
		
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
			for ( $i=0 ; $i<
				count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';

			$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
			
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

		$rResult 			= $this->model_transaction->datatable_verifikasi_trx_rembug($sWhere,$sOrder,$sLimit,$branch_id,$branch_code,$trx_date); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_verifikasi_trx_rembug($sWhere,'','',$branch_id,$branch_code,$trx_date); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_verifikasi_trx_rembug('','','',$branch_id,$branch_code,$trx_date); // get number of all data
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
			$row[] = $aRow['cm_name'];
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = $aRow['account_cash_name'];
			$row[] = '<div align="center"><a href="javascript:;" trx_cm_save_id="'.$aRow['trx_cm_save_id'].'" 
			fa_code = "'.$aRow['fa_code'].'"
			account_cash_code = "'.$aRow['account_cash_code'].'"
			account_cash_name = "'.$aRow['account_cash_name'].'"
			cm_code = "'.$aRow['cm_code'].'"
			cm_name = "'.$aRow['cm_name'].'"
			branch_name = "'.$aRow['branch_name'].'"
			branch_code = "'.$aRow['branch_code'].'"
			branch_id = "'.$aRow['branch_id'].'"
			infaq = "'.$aRow['infaq'].'"
			kas_awal = "'.$aRow['kas_awal'].'"
			tanggal2 = "'.$aRow['trx_date'].'"
			trx_date = "'.$this->format_date_detail($aRow['trx_date'],'id',false,'/').'"
			id="link-verifikasi">Verifikasi</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_branch_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_transaction->search_branch_by_keyword($keyword);

		echo json_encode($data);
	}

	public function get_trx_cm_save_detail()
	{
		$trx_cm_save_id = $this->input->post('trx_cm_save_id');
		$data = $this->model_transaction->get_trx_cm_save_detail($trx_cm_save_id);

		echo json_encode($data);
	}

	public function get_trx_cm_save_berencana()
	{
		$trx_cm_save_detail_id = $this->input->post('trx_cm_save_detail_id');
		$data = $this->model_transaction->get_trx_cm_save_berencana($trx_cm_save_detail_id);

		echo json_encode($data);
	}

	public function delete_trx_cm_save($trx_cm_save_id)
	{
		$data_trx_cm_save_detail 	= $this->model_transaction->get_trx_cm_save_detail($trx_cm_save_id);

		$this->db->trans_begin();
		$param_trx_cm_save = array('trx_cm_save_id'=>$trx_cm_save_id);
		$this->model_transaction->delete_trx_cm_save($param_trx_cm_save);
		for ( $i = 0 ; $i < count($data_trx_cm_save_detail) ; $i++ )
		{
			$param_trx_cm_save_berencana = array('trx_cm_save_detail_id'=>$data_trx_cm_save_detail[$i]['trx_cm_save_detail_id']);
			$this->model_transaction->delete_trx_cm_save_berencana($param_trx_cm_save_berencana);
		}

		$param_trx_cm_save_detail = array('trx_cm_save_id'=>$trx_cm_save_id);
		$this->model_transaction->delete_trx_cm_save_detail($param_trx_cm_save_detail);

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			return true;
		}else{
			$this->db->trans_rollback();
			return false;
		}
	}

	public function reject_trx_rembug()
	{
		$trx_cm_save_id = $this->input->post('trx_cm_save_id');

		$delete = $this->delete_trx_cm_save($trx_cm_save_id);

		if($delete==true){
			$return = array('success'=>true,'message'=>'Reject Success !');
		}else{
			$return = array('success'=>false,'message'=>'Reject Failed !');
		}

		echo json_encode($return);
	}

	public function get_trx_cm_save_by_param()
	{
		$branch_id 			= $this->input->post('branch_id');
		$cm_code 			= $this->input->post('cm_code');
		$trx_date 			= $this->input->post('trx_date');
		$trx_date 			= str_replace('/', '', $trx_date);
		$tgl_trx_date 		= substr($trx_date,0,2);
	    $bln_trx_date 		= substr($trx_date,2,2);
	    $thn_trx_date 		= substr($trx_date,4,4);
	    $trx_date 			= "$thn_trx_date-$bln_trx_date-$tgl_trx_date"; 
		$account_cash_code = $this->input->post('account_cash_code');

		$param = array($branch_id,$cm_code,$trx_date,$account_cash_code);
		$data = $this->model_transaction->get_trx_cm_save_by_param($param);

		echo json_encode($data);
	}

	public function check_saldo_tab_sukarela()
	{
		$cif_no = $this->input->post('cif_no');

		$data = $this->model_transaction->get_saldo_tab_sukarela($cif_no);
		if(count($data)>0){
			$return = array('saldo'=>$data['tabungan_sukarela']);
		}else{
			$return = array('saldo'=>0);
		}

		echo json_encode($return);
	}

	public function check_angsuran_terakhir()
	{
		$cif_no = $this->input->post('cif_no');

		$data_financing = $this->model_transaction->get_account_financing_by_cif_no($cif_no);

		$jangka_waktu 			= $data_financing['jangka_waktu'];
		$periode_jangka_waktu 	= $data_financing['periode_jangka_waktu'];
		$tgl_mulai_angsur 		= $data_financing['tanggal_mulai_angsur'];
		$jtempo_angsuran_next 	= $data_financing['jtempo_angsuran_next'];
		$jtempo_angsuran_last 	= $data_financing['jtempo_angsuran_last'];



	}

	function test_week()
	{
		echo "<pre>";
		print_r($this->get_week('2013-10-23'));
	}

	function get_week($date) {
        $start = strtotime($date) - strftime('%w', $date) * 24 * 60 * 60;
        $end = $start + 6 * 24 * 60 * 60;
        return array('start' => strftime('%Y-%m-%d', $start),
                     'end' => strftime('%Y-%m-%d', $end));
	}

	/**
	* JURNAL OTOMATIS
	*/
	function jurnal_otomatis()
	{
		$data['container'] = 'transaction/jurnal_otomatis';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* PROSES JURNAL OTOMATIS
	*/
	function proses_jurnal_otomatis()
	{
		$from_date = $this->input->post('from_date');
		$from_date = explode('/',$from_date);
		$from_date = $from_date[2].'-'.$from_date[1].'-'.$from_date[0];
		$thru_date = $this->input->post('thru_date');
		$thru_date = explode('/',$thru_date);
		$thru_date = $thru_date[2].'-'.$thru_date[1].'-'.$thru_date[0];

		$this->db->trans_begin();
		$this->model_transaction->proses_jurnal_otomatis($from_date,$thru_date);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('message','Proses Transaksi Jurnal Otomatis Sukses !');
			$this->session->set_flashdata('status','1');
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('message','Failed connection into Databases, Please Contact Your Administrator !');
			$this->session->set_flashdata('status','0');
		}
		redirect("transaction/jurnal_otomatis");
	}

	/**
	* CLOSING
	*/
	function closing()
	{
		$data['container'] = 'transaction/closing';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/**
	* PROSES CLOSING
	*/
	function proses_closing()
	{
		$this->db->trans_begin();
		$this->model_transaction->proses_closing();
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('message','Proses Closing Sukses !');
			$this->session->set_flashdata('status','1');
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('message','Failed connection into Databases, Please Contact Your Administrator !');
			$this->session->set_flashdata('status','0');
		}
		redirect("transaction/closing");
	}

	public function get_value_lap_rek_tab()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_transaction->get_value_lap_rek_tab($cif_no);

		echo json_encode($data);
	}

	public function get_value_lap_rek_tab_for_cetak()
	{
		$account_saving_no 	= $this->input->post('account_saving_no');
		$data 				= $this->model_transaction->get_value_lap_rek_tab_for_cetak($account_saving_no);

		echo json_encode($data);
	}

	public function get_account_deposit()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_account_deposit($cif_no);

		echo json_encode($data);
	}

	public function get_account_saving()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_account_saving($cif_no);

		echo json_encode($data);
	}

	public function search_account_deposit_no()
	{
		$keyword 	= $this->input->post('keyword');
		$cif_type 	= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_transaction->search_account_deposit_no($keyword,$cif_type,$cm_code);

		echo json_encode($data);
	}

	public function get_value_lap_rek_dep()
	{
		$cif_no = $this->input->post('cif_no');
		$data 	= $this->model_transaction->get_value_lap_rek_dep($cif_no);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN LIST TAGIHAN & PELUNASAN
	/****************************************************************************************/
	public function list_tagihan()
	{
		$data['container'] = 'transaction/list_tagihan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['peruntukan'] = $this->model_laporan->get_data_peruntukan();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$data['status_telkom'] = $this->model_laporan->get_status_telkom();
		$data['get_divisi'] = $this->model_laporan->get_divisi();
		$data['get_divisi_child'] = $this->model_laporan->get_divisi('1');
		$this->load->view('core',$data);
	}

	public function list_pelunasan()
	{
		$data['container'] = 'transaction/list_pelunasan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['peruntukan'] = $this->model_laporan->get_data_peruntukan();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	public function jqgrid_list_tagihan()
	{
		set_time_limit(0);
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$tanggal = $this->current_date();
		$resort = isset($_REQUEST['resort'])?$_REQUEST['resort']:'';
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$from_date = explode('/',$from_date);
		$from_date = $from_date[2].'-'.$from_date[1].'-'.$from_date[0];
		
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';
		$thru_date = explode('/',$thru_date);
		$thru_date = $thru_date[2].'-'.$thru_date[1].'-'.$thru_date[0];
		
		$akad = isset($_REQUEST['akad'])?$_REQUEST['akad']:'';
		$produk_pembiayaan = isset($_REQUEST['produk_pembiayaan'])?$_REQUEST['produk_pembiayaan']:'';
		$status_telkom = isset($_REQUEST['status_telkom'])?$_REQUEST['status_telkom']:'';
		$code_divisi = isset($_REQUEST['code_divisi'])?$_REQUEST['code_divisi']:'';
		
		$result = $this->model_transaction->jqgrid_list_tagihan('','','','',$from_date,$thru_date,$akad,$produk_pembiayaan,$status_telkom,$code_divisi);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->jqgrid_list_tagihan($sidx,$sort,$limit_rows,$start,$from_date,$thru_date,$akad,$produk_pembiayaan,$status_telkom,$code_divisi);
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;
		// $responce['total_tagihan'] = $total_tagihan;

		$i = 0;
		foreach ($result as $row)
		{
			//proses 1
			$_is_verified = $this->model_transaction->cek_unverified_transaction($row['account_financing_no']);
			if ($_is_verified==true && $row['sisa_angsuran'] > 1):

				//proses 2
				$data_akad = $this->model_transaction->get_akad_pembiayaan($row['account_financing_no']);

				if($data_akad['akad_code']=='MDA' || $data_akad['akad_code']=='MSA'){
					$flag_jadwal_angsuran = "";
					$saldo_pokok = "";
				}else{
					$data_flag = $this->model_transaction->get_flag_jadwal_angsuran($row['account_financing_no']);
					$flag_jadwal_angsuran = $data_flag['flag_jadwal_angsuran'];
					$saldo_pokok = $data_flag['saldo_pokok'];

					if($flag_jadwal_angsuran == "0"){
						$data_cif1 = $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($row['account_financing_no']);
						$account_financing_id = $data_cif1['account_financing_id'];
						$branch_id = $data_cif1['branch_id'];
						$pokok_pembiayaan = $data_cif1['pokok'];
						$margin_pembiayaan = $data_cif1['margin'];
						$jangka_waktu = $data_cif1['jangka_waktu'];
						$counter_angsuran = $data_cif1['counter_angsuran'];
						$angsuran_pokok = $data_cif1['angsuran_pokok'];
						$angsuran_margin = $data_cif1['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif1['angsuran_tabungan'];
						$keterangan = 'ANGSURAN A/N '.$row['nama'].' NIK '.$data_cif1['cif_no'];
					}else{
						$data_cif2 = $this->model_transaction->get_cif_for_pembayaran_angsuran($row['account_financing_no']);
						$account_financing_id = $data_cif2['account_financing_id'];
						$branch_id = $data_cif2['branch_id'];
						$pokok_pembiayaan = $data_cif2['pokok'];
						$margin_pembiayaan = $data_cif2['margin'];
						$jangka_waktu = $data_cif2['jangka_waktu'];
						$counter_angsuran = $data_cif2['counter_angsuran'];
						$angsuran_pokok = $data_cif2['angsuran_pokok'];
						$angsuran_margin = $data_cif2['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif2['angsuran_catab'];
						$keterangan = 'ANGSURAN A/N '.$row['nama'].' NIK '.$data_cif2['cif_no'];
					}
				}


				$responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
			    $responce['rows'][$i]['cell']=array(
				     $row['account_financing_no']
				    ,$row['cif_no']
					,$row['nama']
					,$row['product_name']
					,$row['product_code']
					,$flag_jadwal_angsuran
					,$saldo_pokok
					,$account_financing_id
					,$branch_id
					,$pokok_pembiayaan
					,$margin_pembiayaan
					,$jangka_waktu
					,$counter_angsuran
					,$angsuran_pokok
					,$angsuran_margin
					,$total_angsuran
					,$row['counter_angsuran']
					,$row['tanggal_jtempo']
					,$keterangan
			    );
			    $i++;

			endif;
		}

		echo json_encode($responce);
	}

	public function jqgrid_list_pelunasan()
	{
		set_time_limit(0);
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$tanggal = $this->current_date();
		$resort = isset($_REQUEST['resort'])?$_REQUEST['resort']:'';
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$from_date = explode('/',$from_date);
		$from_date = $from_date[2].'-'.$from_date[1].'-'.$from_date[0];
		
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';
		$thru_date = explode('/',$thru_date);
		$thru_date = $thru_date[2].'-'.$thru_date[1].'-'.$thru_date[0];
		
		$akad = isset($_REQUEST['akad'])?$_REQUEST['akad']:'';
		$produk_pembiayaan = isset($_REQUEST['produk_pembiayaan'])?$_REQUEST['produk_pembiayaan']:'';

		$result = $this->model_transaction->jqgrid_list_tagihan('','','','',$from_date,$thru_date,$akad,$produk_pembiayaan);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->jqgrid_list_tagihan($sidx,$sort,$limit_rows,$start,$from_date,$thru_date,$akad,$produk_pembiayaan);
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;
		// $responce['total_tagihan'] = $total_tagihan;

		$i = 0;
		foreach ($result as $row)
		{
			//proses 1
			$_is_verified = $this->model_transaction->cek_unverified_transaction($row['account_financing_no']);
			if ($_is_verified==true && $row['sisa_angsuran'] == '1'):

				//proses 2
				$data_akad = $this->model_transaction->get_akad_pembiayaan($row['account_financing_no']);

				if($data_akad['akad_code']=='MDA' || $data_akad['akad_code']=='MSA'){
					$flag_jadwal_angsuran = "";
					$saldo_pokok = "";
				}else{
					$data_flag = $this->model_transaction->get_flag_jadwal_angsuran($row['account_financing_no']);
					$flag_jadwal_angsuran = $data_flag['flag_jadwal_angsuran'];
					$saldo_pokok = $data_flag['saldo_pokok'];

					if($flag_jadwal_angsuran == "0"){
						$data_cif1 = $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($row['account_financing_no']);
						$account_financing_id = $data_cif1['account_financing_id'];
						$branch_id = $data_cif1['branch_id'];
						$pokok_pembiayaan = $data_cif1['pokok'];
						$margin_pembiayaan = $data_cif1['margin'];
						$jangka_waktu = $data_cif1['jangka_waktu'];
						$counter_angsuran = $data_cif1['counter_angsuran'];
						$angsuran_pokok = $data_cif1['angsuran_pokok'];
						$angsuran_margin = $data_cif1['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif1['angsuran_tabungan'];
						$keterangan = 'ANGSURAN A/N '.$row['nama'].' NIK '.$data_cif1['cif_no'];
					}else{
						$data_cif2 = $this->model_transaction->get_cif_for_pembayaran_angsuran($row['account_financing_no']);
						$account_financing_id = $data_cif2['account_financing_id'];
						$branch_id = $data_cif2['branch_id'];
						$pokok_pembiayaan = $data_cif2['pokok'];
						$margin_pembiayaan = $data_cif2['margin'];
						$jangka_waktu = $data_cif2['jangka_waktu'];
						$counter_angsuran = $data_cif2['counter_angsuran'];
						$angsuran_pokok = $data_cif2['angsuran_pokok'];
						$angsuran_margin = $data_cif2['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif2['angsuran_catab'];
						$keterangan = 'ANGSURAN A/N '.$row['nama'].' NIK '.$data_cif2['cif_no'];
					}
				}


				$responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
			    $responce['rows'][$i]['cell']=array(
				     $row['account_financing_no']
				    ,$row['cif_no']
					,$row['nama']
					,$row['product_name']
					,$row['product_code']
					,$flag_jadwal_angsuran
					,$saldo_pokok
					,$account_financing_id
					,$branch_id
					,$pokok_pembiayaan
					,$margin_pembiayaan
					,$jangka_waktu
					,$counter_angsuran
					,$angsuran_pokok
					,$angsuran_margin
					,$total_angsuran
					,$row['counter_angsuran']
					,$row['tanggal_jtempo']
					,$keterangan
			    );
			    $i++;

			endif;
		}

		echo json_encode($responce);
	}


	/****************************************************************************************/	
	// BEGIN PEMBAYARAN ANGSURAN
	/****************************************************************************************/
	public function pembayaran_angsuran()
	{
		$data['container'] = 'transaction/pembayaran_angsuran';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		// $data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	public function get_cif_for_pembayaran_angsuran()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_transaction->get_cif_for_pembayaran_angsuran($account_financing_no);
		// $current_date 			= $this->model_transaction->get_date_current();

		// $tgl     				=substr("$current_date",8,2);
	    // $bln     				=substr("$current_date",5,2);
	    // $thn	        		=substr("$current_date",0,4);
	    // $data['current_date']	= "$tgl/$bln/$thn";

		echo json_encode($data);
	}

	public function get_cif_for_pembayaran_angsuran_non_reguler()
	{
		$account_financing_no 	= $this->input->post('account_financing_no');
		$data 					= $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($account_financing_no);
		echo json_encode($data);
	}

	public function get_flag_jadwal_angsuran()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_flag_jadwal_angsuran($account_financing_no);
		echo json_encode($data);
	}

	public function proses_pembayaran_angsuran()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$account_financing_schedulle_id = $this->input->post('account_financing_schedulle_id');
		$account_saving_id 	  = $this->input->post('account_saving_id');
		$branch_id 		 	  = $this->input->post('branch_id');
		$no_rekening 		  = $this->input->post('no_rekening');
		$nama				  = $this->input->post('nama');
		$produk				  = $this->input->post('produk');
		$pokok_pembiayaan 	  = $this->convert_numeric($this->input->post('pokok_pembiayaan'));
		$margin_pembiayaan 	  = $this->convert_numeric($this->input->post('margin_pembiayaan'));
		$jangka_waktu 		  = $this->input->post('jangka_waktu');
		$pokok				  = $this->convert_numeric($this->input->post('pokok'));
		$margin				  = $this->convert_numeric($this->input->post('margin'));
		$cadangan_tabungan 	  = $this->convert_numeric($this->input->post('cadangan_tabungan'));
		$total_angsuran 	  = $this->convert_numeric($this->input->post('total_angsuran'));
		$jtempo_angsuran 	  = $this->input->post('jtempo_angsuran');
		$no_rek_tabungan 	  = $this->input->post('no_rek_tabungan');
		$freq_pembayaran 	  = $this->input->post('freq_pembayaran');
		$nominal_pembayaran   = $this->convert_numeric($this->input->post('nominal_pembayaran'));
		$tgl_bayar 			  = $this->input->post('tgl_bayar');
		$keterangan 		  = $this->input->post('keterangan');
		$saldo_pokok 		  = $this->convert_numeric($this->input->post('saldo_pokok'));
		// $saldo_memo 		  = $this->convert_numeric($this->input->post('saldo_memo'));
		$saldo_catab 		  = $this->convert_numeric($this->input->post('saldo_catab'));
		$saldo_margin 		  = $this->convert_numeric($this->input->post('saldo_margin'));
		$periode_jangka_waktu = $this->input->post('periode');
		$bayar_pokok 		  = $this->convert_numeric($this->input->post('bayar_pokok'));
		$bayar_margin 		  = $this->convert_numeric($this->input->post('bayar_margin'));
		$bayar_pokok_before   = $this->input->post('bayar_pokok_before');
		$bayar_margin_before  = $this->input->post('bayar_margin_before');
		$account_cash_code   = $this->input->post('account_cash_code');

		$tgl_jtempo 		  = substr("$jtempo_angsuran",0,2);
	    $bln_jtempo 		  = substr("$jtempo_angsuran",3,2);
	    $thn_jtempo 		  = substr("$jtempo_angsuran",6,4);
	    $tglakhir_jtempo 	  = "$thn_jtempo-$bln_jtempo-$tgl_jtempo";  

		$tanggal_bayar 		  = substr("$tgl_bayar",0,2);
	    $bulan_bayar 		  = substr("$tgl_bayar",3,2);
	    $tahun_bayar 		  = substr("$tgl_bayar",6,4);
	    $tglakhir_bayar 	  = "$tahun_bayar-$bulan_bayar-$tanggal_bayar"; 

	    $get_data_financing 	= $this->model_transaction->get_account_financing_by_account_financing_no($no_rekening);
		$jtempo_angsuran_last 	= $get_data_financing['jtempo_angsuran_last'];
		$jtempo_angsuran_next 	= $get_data_financing['jtempo_angsuran_next'];
		$tgl_angs_last 			= $jtempo_angsuran_last;
		$tgl_angs_next 			= $jtempo_angsuran_next;
		$counter_angsuran 		= $get_data_financing['counter_angsuran'];
		$jangka_wkatu 			= $get_data_financing['jangka_waktu'];
		$total_angsuran2        = 0;
		$angsuran_ke 			= $counter_angsuran;
	    for($i=1;$i<=$freq_pembayaran;$i++)
	    {
	    	$angsuran_ke++;
	    	$get_data_financing2 = $this->model_transaction->get_account_financing_by_account_financing_no($no_rekening);

	    	$saldo_pokok = $get_data_financing2['saldo_pokok'];
			$saldo_margin = $get_data_financing2['saldo_margin'];
			$saldo_catab = $get_data_financing2['saldo_catab'];
			
			$total_angsuran2+=$total_angsuran;

			$counter_angsuran++;
	    	if($jangka_waktu==$counter_angsuran){
	    		$pokok=$saldo_pokok;
	    	}

			if($periode_jangka_waktu=='0'){
				$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 days'));
				$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 days'));
			}else if($periode_jangka_waktu=='1'){
				$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 weeks'));
				$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 weeks'));
			}else if($periode_jangka_waktu=='2'){
				$tgl_angs_next = date('Y-m-d',strtotime($tgl_angs_next.'+1 months'));
				$tgl_angs_last = date('Y-m-d',strtotime($tgl_angs_last.'+1 months'));
			}

			$flag_jdwl_angsuran = $this->model_transaction->get_flag_jadwal($account_financing_id);

			$trx_detail_id = uuid(false);
			$trx_account_financing_id=uuid(false);

			if($flag_jdwl_angsuran=='1'){//reguler

				/* trx detail */
				$trx_sequence = $this->model_transaction->get_trx_sequence($no_rekening);
				$arr_trx_detail = array(
					 'trx_detail_id'		=>$trx_detail_id
					,'trx_summary_id'		=>''
					,'trx_type'				=>3
					,'trx_account_type'		=>1
					,'account_no'			=>$no_rekening
					,'flag_debit_credit'	=>'D'
					,'amount'				=>$total_angsuran
					,'trx_date'				=>$tglakhir_bayar
					,'reference_no'			=>''
					,'description'			=>$keterangan
					,'created_by'			=>$this->session->userdata('user_id')
					,'created_date'			=>date("Y-m-d H:i:s")
					,'trx_sequence'			=>$trx_sequence
				);

				/*trx account financing*/
				$arr_trx_account_financing = array(
					 'branch_id'			=>$branch_id
					,'trx_account_financing_id'=>$trx_account_financing_id
					,'trx_detail_id'		=>$trx_detail_id
					,'account_financing_no'	=>$no_rekening
					,'trx_financing_type'	=>'1'
					,'trx_date'				=>$tglakhir_bayar
					,'jto_date'				=>$tgl_angs_last
					,'pokok'				=>$pokok
					,'margin'				=>$margin
					,'catab'				=>$cadangan_tabungan
					,'reference_no'			=>$no_rek_tabungan
					,'description'			=>$keterangan
					,'created_date'			=>date("Y-m-d H:i:s")
					,'created_by'			=>$this->session->userdata('user_id')
					,'trx_sequence'			=>0
					,'tab_wajib'			=>0
					,'tab_sukarela'			=>0
					,'freq'					=>1
					,'trx_status'			=>0
					,'angsuran_ke'			=>$angsuran_ke
					,'account_cash_code'	=>$account_cash_code
					,'tipe_angsuran'		=>'3'
				);
				
				/* account_financing */
				/*$data2 = array(
					 'saldo_pokok'			=>($saldo_pokok-$pokok)
					,'saldo_margin'			=>($saldo_margin-$margin)
					,'saldo_catab'			=>($saldo_catab+$cadangan_tabungan)
					,'jtempo_angsuran_last'	=>$tgl_angs_last
					,'jtempo_angsuran_next'	=>$tgl_angs_next
					,'counter_angsuran' 	=>$get_data_financing2['counter_angsuran']+1
				);
				$param2 = array('account_financing_id'=>$account_financing_id);*/

				$this->db->trans_begin();
				$this->model_transaction->insert_on_mfi_trx_detail($arr_trx_detail);
				$this->db->insert('mfi_trx_account_financing',$arr_trx_account_financing);
				// $this->model_transaction->update_mfi_account_financing($data2,$param2);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}

			}else{ //non reguler


				/* trx detail */
				$trx_sequence = $this->model_transaction->get_trx_sequence($no_rekening);

				$arr_trx_detail = array(
					 'trx_detail_id'		=>$trx_detail_id
					,'trx_summary_id'		=>''
					,'trx_type'				=>3
					,'trx_account_type'		=>1
					,'account_no'			=>$no_rekening
					,'flag_debit_credit'	=>''
					,'amount'				=>$bayar_pokok+$bayar_margin
					,'trx_date'				=>$tglakhir_bayar
					,'reference_no'			=>''
					,'description'			=>$keterangan
					,'created_by'			=>$this->session->userdata('user_id')
					,'created_date'			=>date("Y-m-d H:i:s")
					,'account_no_dest'		=>$no_rek_tabungan
					,'trx_sequence'			=>$trx_sequence
					,'account_type_dest'	=>1
				);

				/* trx account financing */
				$arr_trx_account_financing = array(
					 'branch_id'			=>$branch_id
					,'trx_account_financing_id'=>$trx_account_financing_id
					,'trx_detail_id'		=>$trx_detail_id
					,'account_financing_no'	=>$no_rekening
					,'trx_financing_type'	=>'1'
					,'trx_date'				=>$tglakhir_bayar
					,'jto_date'				=>$tgl_angs_last
					,'pokok'				=>$bayar_pokok
					,'margin'				=>$bayar_margin
					,'catab'				=>$cadangan_tabungan
					,'reference_no'			=>$no_rek_tabungan
					,'description'			=>$keterangan
					,'created_date'			=>date("Y-m-d H:i:s")
					,'created_by'			=>$this->session->userdata('user_id')
					,'trx_sequence'			=>0
					,'tab_wajib'			=>0
					,'tab_sukarela'			=>0
					,'freq'					=>1
					,'trx_status'			=>0
					,'angsuran_ke'			=>$angsuran_ke
					,'account_cash_code'	=>$account_cash_code
					,'tipe_angsuran'		=>'3'
				);

				/* account_financing_no */
				/*$data2 = array(
					 'saldo_pokok'			=>($saldo_pokok-$bayar_pokok)
					,'saldo_margin'			=>($saldo_margin-$bayar_margin)
					,'saldo_catab'			=>($saldo_catab+$cadangan_tabungan)
				);
				$param2 = array('account_financing_id'=>$account_financing_id);
				*/

				/*
				$data6 = array(
					 'bayar_pokok'			=>($bayar_pokok_before+$bayar_pokok)
					,'bayar_margin'			=>($bayar_margin_before+$bayar_margin)
					,'tanggal_bayar'	    =>$tglakhir_bayar
				);
				if(($bayar_pokok_before+$bayar_pokok)==$pokok && ($bayar_margin_before+$bayar_margin)==$margin){
					$data2['counter_angsuran']=$get_data_financing2['counter_angsuran']+1;
					$data2['jtempo_angsuran_last']=$tgl_angs_last;
					$data2['jtempo_angsuran_next']=$tgl_angs_next;
				}else{
					$data6['status_angsuran'] = 0;
				}
				$param6 = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);
				*/

				$this->db->trans_begin();
				$this->db->insert('mfi_trx_account_financing',$arr_trx_account_financing);
				$this->model_transaction->insert_on_mfi_trx_detail($arr_trx_detail);
				// $this->model_transaction->update_on_financing_schedulle($data6,$param6);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}
			} /* end if else of flag_jadwal_angsuran (0=non reguler,1=reguler) */
		} /* end for */
		
		

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN VERIFIKASI TRANSAKSI
	/****************************************************************************************/
	
	public function verifikasi_transaksi()
	{
		$data['container'] = 'transaction/verifikasi_transaksi';
		// $data['rembugs'] = $this->model_cif->get_cm_data();
		// $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function grid_verifikasi_transaksi()
	{
		$page 			= isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows 	= isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx 			= isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
		$sort 			= isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$account_no 	= isset($_REQUEST['account_no'])?$_REQUEST['account_no']:'';
		$jenis_transaksi= isset($_REQUEST['jenis_transaksi'])?$_REQUEST['jenis_transaksi']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		if($jenis_transaksi=='all'){
			$result = $this->model_transaction->grid_verifikasi_transaksi('','','','',$account_no);//2
		}else if($jenis_transaksi=='1'){ // TABUNGAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_tabungan('','','','',$account_no);//2
		}else if($jenis_transaksi=='2'){ // PEMBIAYAAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_pembiayaan('','','','',$account_no);//2
		}

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		if($jenis_transaksi=='all'){
			$result = $this->model_transaction->grid_verifikasi_transaksi($sidx,$sort,$limit_rows,$start,$account_no);//3
		}else if($jenis_transaksi=='1'){ // TABUNGAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_tabungan($sidx,$sort,$limit_rows,$start,$account_no);//3
		}else if($jenis_transaksi=='2'){ // PEMBIAYAAN
			$result = $this->model_transaction->grid_verifikasi_transaksi_pembiayaan($sidx,$sort,$limit_rows,$start,$account_no);//3
		}

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$keterangan = $row['keterangan'];
			if($row['jenis_transaksi']=='Tabungan'){
				switch ($keterangan) {
					case '1':
						$keterangan='SETORAN TUNAI';
						break;
					case '2':
						$keterangan='PENARIKAN TUNAI';
						break;
					case '3':
						$keterangan='PEMINDAH BUKUAN KELUAR';
						break;
					case '7':
						$keterangan='DENDA ANGSURAN';
						break;
					default:
						$keterangan='PEMINDAH BUKUAN MASUK';
						break;
				}
			}else if($row['jenis_transaksi']=='Pembiayaan'){
				switch ($keterangan) {
					case '0':
						$keterangan='DROPING';
						break;
					case '1':
						$keterangan='ANGSURAN';
						break;
					case '2':
						$keterangan='PELUNASAN';
						break;
				}
			}
			$responce['rows'][$i]['id_transaksi']=$row['id_transaksi'];
		    $responce['rows'][$i]['cell']=array(
			    $row['id_transaksi']
			    ,$row['jenis_transaksi']
			    ,$row['tgl_transaksi']
			    ,$row['no_rekening']
			    ,$row['nama_cif']
			    ,$row['jumlah']
			    ,$keterangan
			    ,$row['fullname']
			    ,$row['product_name']
			    ,$row['no_referensi']
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	public function create_no_reference()
	{
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$periode_awal = $kontrol_periode['periode_awal'];

		// TABUNGAN SET NO REFF
		$sql_1 = $this->db->query("SELECT * FROM mfi_trx_account_saving WHERE seq='0' AND created_date > '2019-01-01 00:00:01'");
		if($sql_1->num_rows() > 0)
        {
            foreach($sql_1->result() as $row){
            	$id_transaksi = $row->trx_account_saving_id;

            	// SET NO REF
                $seql = $this->db->query("
                	SELECT X.seq FROM ((SELECT seq FROM mfi_trx_account_saving ORDER BY seq DESC LIMIT 1)
					UNION ALL
					(SELECT seq FROM mfi_trx_account_financing ORDER BY seq DESC LIMIT 1)) AS X ORDER BY seq DESC LIMIT 1")->row();
				$seq = $seql->seq+1;
				$M = strtoupper(date('M',strtotime($periode_awal)));
	            $seqs = str_pad($seq, 6, '0', STR_PAD_LEFT);
	            $no_ref =  $seqs.'/'.$M;

	            $this->db->query("UPDATE mfi_trx_account_saving SET seq='$seq', reference_no='$no_ref' WHERE trx_account_saving_id='$id_transaksi'");
            }
        }

        // PEMBIAYAAN SET NO REFF
		$sql_2 = $this->db->query("SELECT * FROM mfi_trx_account_financing WHERE seq='0' AND created_date > '2019-01-01 00:00:01' AND verify_by IS NULL");
		if($sql_2->num_rows() > 0)
        {
            foreach($sql_2->result() as $row){
            	$id_transaksi = $row->trx_account_financing_id;
            	if($row->tipe_angsuran!='2'):
	            	// SET NO REF
	                $seql = $this->db->query("
	                	SELECT X.seq FROM ((SELECT seq FROM mfi_trx_account_saving ORDER BY seq DESC LIMIT 1)
						UNION ALL
						(SELECT seq FROM mfi_trx_account_financing ORDER BY seq DESC LIMIT 1)) AS X ORDER BY seq DESC LIMIT 1")->row();
					$seq = $seql->seq+1;
					$M = strtoupper(date('M',strtotime($periode_awal)));
		            $seqs = str_pad($seq, 6, '0', STR_PAD_LEFT);
		            $no_ref =  $seqs.'/'.$M;

		            $this->db->query("UPDATE mfi_trx_account_financing SET seq='$seq', reference_no='$no_ref' WHERE trx_account_financing_id='$id_transaksi'");
	        	endif;
            }
        }

        $responce = array('status' => true);

        echo json_encode($responce);
	}

	public function create_no_reference2()
	{
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$periode_awal = $kontrol_periode['periode_awal'];


		// KONDISI PERTAMA
		$sql = $this->db->query("SELECT jurnal_trx_type, voucher_no, trx_date,
								array_to_string(
								ARRAY   (
								        SELECT  DISTINCT voucher_ref
								        FROM    mfi_trx_gl gl
								        WHERE   gl.voucher_no= gd.voucher_no
								        ORDER BY
								                voucher_ref
								        ),
								','
								) AS voucher_ref

								FROM
								(SELECT a.voucher_no, a.jurnal_trx_type, a.trx_date FROM mfi_trx_gl a JOIN mfi_account_financing b ON a.voucher_ref=b.account_financing_no GROUP BY a.voucher_no, a.jurnal_trx_type, a.trx_date) gd");
		if($sql->num_rows() > 0)
        {
        	foreach($sql->result() as $row){
        		$jurnal_trx_type = $row->jurnal_trx_type;
        		$voucher_ref = $row->voucher_ref;
        		$voucher_no = $row->voucher_no;
        		$trx_date = $row->trx_date;

        		// SET NO REF
                $seql = $this->db->query("SELECT seq FROM mfi_trx_account_financing ORDER BY seq DESC LIMIT 1")->row();
				$seq = $seql->seq+1;
				$M = strtoupper(date('M',strtotime($trx_date)));
	            $seqs = str_pad($seq, 6, '0', STR_PAD_LEFT);
	            $no_ref =  $seqs.'/'.$M;
	            
	            if($jurnal_trx_type == 3){
        			$arr = explode(',', $voucher_ref);
        			for($i=0; $i<count($arr); $i++){
        				$voucher_ref = $arr[$i];

        				$query = $this->db->query("SELECT * FROM mfi_trx_gl WHERE voucher_ref='$voucher_ref' AND voucher_no='$voucher_no'");
						if($query->num_rows() > 0)
				        {
				            $row = $query->row();
			            	$trx_account_financing_id = $row->jurnal_trx_id;
			            	$trx_gl_id = $row->trx_gl_id;

		            		$this->db->query("UPDATE mfi_trx_account_financing SET seq='$seq', reference_no='$no_ref' WHERE trx_account_financing_id='$trx_account_financing_id'");

		            		$this->db->query("UPDATE mfi_trx_gl SET voucher_ref='$no_ref' WHERE trx_gl_id='$trx_gl_id'");
				        }	
        			}
        		}
        	}
        }

        $responce = array('status' => true);

        echo json_encode($responce);
	}

	public function create_no_reference3()
	{
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$periode_awal = $kontrol_periode['periode_awal'];
		$sql = "
				SELECT X.seq FROM ((SELECT seq FROM mfi_trx_account_saving ORDER BY seq DESC LIMIT 1)
				UNION ALL
				(SELECT seq FROM mfi_trx_account_financing ORDER BY seq DESC LIMIT 1)) AS X ORDER BY seq DESC LIMIT 1";
		$seql = $this->db->query($sql)->row();
		$seq = $seql->seq+1;
		$M = strtoupper(date('M',strtotime($periode_awal)));
        $seqs = str_pad($seq, 6, '0', STR_PAD_LEFT);
        $no_ref =  $seqs.'/'.$M;

        $responce = array('status' => true, 'no_ref' => $no_ref, 'seq' => $seq);

        echo json_encode($responce);
	}

	public function get_no_rekening()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_transaction->get_no_rekening($keyword);

		echo json_encode($data);
	}

	public function aktivasi_transaksi()
	{
		$id 	= $this->input->post('id');
		$jenis 	= $this->input->post('jenis');
		$account_no = $this->input->post('account_no');

		$this->db->trans_begin();
		if($jenis=="Tabungan"){
			$trxsaving=$this->model_transaction->get_trx_account_saving_by_trx_id($id);
			$account_cash_code=$trxsaving['account_cash_code'];
			$tabungan=$this->model_transaction->get_account_saving_by_account_saving_no($account_no);
			$saldo_memo=$tabungan['saldo_memo'];
			$saldo_riil=$saldo_memo;
			$data_tab=array('saldo_riil'=>$saldo_riil);
			$param_tab=array('account_saving_no'=>$account_no);

			$data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$param 	= array('trx_account_saving_id'=>$id);
			$this->model_transaction->aktivasi_transaksi_saving($data,$param);
			$this->model_transaction->update_account_saving($data_tab,$param_tab);
			$this->model_transaction->fn_jurnal_trx_saving($id,$account_cash_code); // proses jurnal transaksi tabungan
		}

		if($jenis=="Pembiayaan"){

			/* begin run update saldo */

			/*
			| get data account pembiayaan
			*/
			$account = $this->model_transaction->get_account_financing_by_account_financing_no($account_no);
			$v_flag_jadwal_angsuran = $account['flag_jadwal_angsuran'];
			$v_saldo_pokok = $account['saldo_pokok'];
			$v_saldo_margin = $account['saldo_margin'];
			// $v_saldo_catab = $account['saldo_catab'];
			$v_jtempo_angsuran_last = $account['jtempo_angsuran_last'];
			$v_jtempo_angsuran_next = $account['jtempo_angsuran_next'];
			$v_counter_angsuran = $account['counter_angsuran'];
			$v_periode_jangka_waktu = $account['periode_jangka_waktu'];
			$v_akad_code = $account['akad_code'];
			/*
			| get data trx history pembiayaan
			*/
			$trx_account = $this->model_transaction->get_trx_account_financing_by_trx_id($id);
			$trx_angsuran_pokok = $trx_account['pokok'];
			$trx_angsuran_margin = $trx_account['margin'];
			$trx_date = $trx_account['trx_date'];
			$seq = $trx_account['seq'];

			if($seq=='0'){
				$this->db->trans_rollback();
				$return = array('success'=>false, 'msg'=> 'No Referensi belum di generate!');
				echo json_encode($return);
				exit;
			}

			/*
			| set variable for perubahan account pembiayaan
			*/
			$saldo_pokok = $v_saldo_pokok-$trx_angsuran_pokok;
			$saldo_margin = $v_saldo_margin-$trx_angsuran_margin;
			$counter_angsuran = $v_counter_angsuran+1;
			$jtempo_angsuran_last = $v_jtempo_angsuran_last;
			$jtempo_angsuran_next = $v_jtempo_angsuran_next;
			if($v_periode_jangka_waktu=='0'){
				$jtempo_angsuran_last = date('Y-m-d',strtotime($jtempo_angsuran_last.'+1 days'));
				$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next.'+1 days'));
			}else if($v_periode_jangka_waktu=='1'){
				$jtempo_angsuran_last = date('Y-m-d',strtotime($jtempo_angsuran_last.'+1 weeks'));
				$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next.'+1 weeks'));
			}else if($v_periode_jangka_waktu=='2'){
				$jtempo_angsuran_last = date('Y-m-d',strtotime($jtempo_angsuran_last.'+1 months'));
				$jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next.'+1 months'));
			}

			if ($v_flag_jadwal_angsuran=='0') { // non reguler
				$account_schedulle = $this->model_transaction->get_account_financing_schedulle_active($account_no,$v_jtempo_angsuran_next);
				$account_financing_schedulle_id = $account_schedulle['account_financing_schedulle_id'];
				$mustpayed_angsuran_pokok = $account_schedulle['angsuran_pokok'];
				$mustpayed_angsuran_margin = $account_schedulle['angsuran_margin'];
				$payed_angsuran_pokok = $account_schedulle['bayar_pokok'];
				$payed_angsuran_margin = $account_schedulle['bayar_margin'];
				$bayar_pokok = $trx_angsuran_pokok+$payed_angsuran_pokok;
				$bayar_margin = $trx_angsuran_margin+$payed_angsuran_margin;

				$account_financing = array(
					'saldo_pokok'=>$saldo_pokok,
					'saldo_margin'=>$saldo_margin
				);

				$account_financing_schedulle = array(
					'bayar_pokok'=>$bayar_pokok,
					'bayar_margin'=>$bayar_margin,
					'tanggal_bayar'=>$trx_date
				);

				/* 
				| membuat pengecualian utk akad MSA dan MDA
				*/
				switch ($v_akad_code) {
					case 'MSA':
					case 'MDA':
					$v_is_msamda = true;
					break;
					default:
					$v_is_msamda = false;
					break;
				}

				if ($v_is_msamda==true) {
					if ($mustpayed_angsuran_pokok==$bayar_pokok) {
						$account_financing['counter_angsuran'] = $counter_angsuran;
						$account_financing['jtempo_angsuran_last'] = $jtempo_angsuran_last;
						$account_financing['jtempo_angsuran_next'] = $jtempo_angsuran_next;

						$account_financing_schedulle['status_angsuran']=1;
					}
				} else {
					if ($mustpayed_angsuran_pokok==$bayar_pokok && $mustpayed_angsuran_margin==$bayar_margin) {
						$account_financing['counter_angsuran'] = $counter_angsuran;
						$account_financing['jtempo_angsuran_last'] = $jtempo_angsuran_last;
						$account_financing['jtempo_angsuran_next'] = $jtempo_angsuran_next;

						$account_financing_schedulle['status_angsuran']=1;
					}
				}

				$account_financing_param = array('account_financing_no'=>$account_no);
				$account_financing_schedulle_param = array('account_financing_schedulle_id'=>$account_financing_schedulle_id);
				
				/* update saldo in databases */
				$this->model_transaction->update_on_financing_schedulle($account_financing_schedulle,$account_financing_schedulle_param);
				$this->model_transaction->update_mfi_account_financing($account_financing,$account_financing_param);

			} else { // reguler

				$account_financing = array(
						'saldo_pokok'=>$saldo_pokok,
						'saldo_margin'=>$saldo_margin,
						// 'saldo_catab'=>,
						'jtempo_angsuran_last'=>$jtempo_angsuran_last,
						'jtempo_angsuran_next'=>$jtempo_angsuran_next,
						'counter_angsuran'=>$counter_angsuran
					);
				$account_financing_param = array('account_financing_no'=>$account_no);

				/* update saldo in databases */
				$this->model_transaction->update_mfi_account_financing($account_financing,$account_financing_param);
			}

			/* end run update saldo */

			/* begin run journal of trx financing */
			$data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$param 	= array('trx_account_financing_id'=>$id);
			$this->model_transaction->aktivasi_transaksi_financing($data,$param);
			$this->model_transaction->fn_proses_jurnal_angsuran_pyd2($id); // proses jurnal transaksi pembiayaan
			/* end run journal of trx financing */
		}

		if($jenis=="SMK"){
			$data   = array('verify_by'=>$this->session->userdata('user_id'),'verify_date'=>date('Y-m-d H:i:s'),'trx_status'=>'1');
			$param 	= array('trx_smk_id'=>$id);
			$this->model_transaction->aktivasi_transaksi_smk($data,$param);
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

	public function reject_transaksi()
	{
		$id 	= $this->input->post('id');
		$jenis 	= $this->input->post('jenis');

		$this->db->trans_begin();

		if($jenis=="Pembiayaan"){
			$trx_account = $this->model_transaction->get_trx_account_financing_by_trx_id($id);
			$trx_detail_id = $trx_account['trx_detail_id'];

			$param_trx_financing = array('trx_account_financing_id'=>$id);
			$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);

			$this->db->delete('mfi_trx_account_financing',$param_trx_financing);
			$this->db->delete('mfi_trx_detail',$param_trx_detail);
		}

		if ($jenis=='Tabungan'){
			$data_trx_account_saving=$this->model_transaction->get_trx_account_saving_by_trx_saving_id($id);
			if(count($data_trx_account_saving)==1){
				$data_trx_account_saving=$data_trx_account_saving[0];
				$trx_detail_id = $data_trx_account_saving['trx_detail_id'];
				$account_saving_no=$data_trx_account_saving['account_saving_no'];
				$flag_debit_credit=$data_trx_account_saving['flag_debit_credit'];
				$data_account_saving=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
				$amount=$data_trx_account_saving['amount'];
				if ($flag_debit_credit=='C') {
					$saldo_memo_back = $data_account_saving['saldo_memo']-$amount;
				} else if ($flag_debit_credit=='D') {
					$saldo_memo_back = $data_account_saving['saldo_memo']+$amount;
				} else {
					$saldo_memo_back = $data_account_saving['saldo_memo'];
				}
				$data=array('saldo_memo'=>$saldo_memo_back);
				$param=array('account_saving_no'=>$account_saving_no);
				$param_trx_saving=array('trx_account_saving_id'=>$id);
				$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
				$this->db->trans_begin();
				$this->model_transaction->update_account_saving($data,$param);
				$this->model_transaction->delete_trx_account_saving($param_trx_saving);
				$this->model_transaction->delete_trx_detail($param_trx_detail);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}
			}else{
				$return = array('success'=>false);
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

	public function detail_transaksi_tabungan()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_tabungan($id);

		echo json_encode($data);
	}

	public function detail_transaksi_pembiayaan()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_pembiayaan($id);

		echo json_encode($data);
	}

	public function detail_transaksi_smk()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_transaction->detail_transaksi_smk($id);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END VERIFIKASI TRANSAKSI
	/****************************************************************************************/

	public function print_form_trx_rembug()
	{
		$cm_code = $this->uri->segment(3);
		$account_cash_code = $this->uri->segment(4);
		$tanggal = $this->uri->segment(5);
		$branch = $this->uri->segment(6);
		$cm = $this->uri->segment(7);
		$tanggal = $this->datepicker_convert(true,$tanggal,'-');
        $rows = $this->model_transaction->get_trx_rembug_data($cm_code,$tanggal);
		$i=0;
		$data['data'] = array();
		$data['tab_berencana'] = array();
		foreach($rows as $row)
		{
			$data['data'][$i]['cif_id'] = ($row['cif_id']==null)?0:$row['cif_id'];
			$data['data'][$i]['cm_code'] = ($row['cm_code']==null)?0:$row['cm_code'];
			$data['data'][$i]['cif_no'] = ($row['cif_no']==null)?0:$row['cif_no'];
			$data['data'][$i]['nama'] = ($row['nama']==null)?0:$row['nama'];
			$data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela']==null)?0:$row['tabungan_sukarela'];
			$data['data'][$i]['tabungan_wajib'] = ($row['tabungan_wajib']==null)?0:$row['tabungan_wajib'];
			$data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain']==null)?0:$row['transaksi_lain'];
			$data['data'][$i]['angsuran'] = ($row['angsuran']==null)?0:$row['angsuran'];
			$data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan']==null)?0:$row['pokok_pembiayaan'];
			$data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan']==null)?0:$row['margin_pembiayaan'];
			$data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan']==null)?0:$row['catab_pembiayaan'];
			$data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok']==null)?0:$row['tabungan_kelompok'];
			$data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran']==null)?0:$row['jumlah_angsuran'];
			$data['data'][$i]['pokok'] = ($row['pokok']==null)?0:$row['pokok'];
			$data['data'][$i]['droping'] = ($row['droping']==null)?0:$row['droping'];
			$data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok']==null)?0:$row['angsuran_pokok'];
			$data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin']==null)?0:$row['angsuran_margin'];
			$data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab']==null)?0:$row['angsuran_catab'];
			$data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib']==null)?0:$row['angsuran_tab_wajib'];
			$data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok']==null)?0:$row['angsuran_tab_kelompok'];
			$data['data'][$i]['adm'] = ($row['adm']==null)?0:$row['adm'];
			$data['data'][$i]['asuransi'] = ($row['asuransi']==null)?0:$row['asuransi'];
			$data['data'][$i]['setoran_berencana'] = ($row['setoran_berencana']==null)?0:$row['setoran_berencana'];
			$data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk']==null)?0:$row['setoran_lwk'];
			$data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan']==null)?0:$row['setoran_mingguan'];
			$data['data'][$i]['margin'] = ($row['margin']==null)?0:$row['margin'];
			$data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok']==null)?0:$row['saldo_pokok'];
			$data['data'][$i]['saldo_margin'] = ($row['saldo_margin']==null)?0:$row['saldo_margin'];
			$data['data'][$i]['saldo_catab'] = ($row['saldo_catab']==null)?0:$row['saldo_catab'];
			$data['data'][$i]['status'] = $row['status'];
			$data['tab_berencana'][$i] = $this->model_transaction->get_tabungan_berencana_by_cif_no($row['cif_no']);
			$i++;
		}
		$data['kas_awal'] = $this->model_transaction->fn_get_saldoawal_kaspetugas($account_cash_code,$tanggal,1); // 1 = mencari kas awal
        $data['cabang'] = $branch;
        $data['majelis'] = $cm;

        ob_start();
        
        $this->load->view('transaction/print_form_trx_rembug',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('FORMULIR TRANSAKSI REMBUG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
	}

	/****************************************************************************************/	
	// BEGIN TRANSAKSI SETORAN POKOK
	/****************************************************************************************/
	public function setoran_pokok()
	{
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$data['container'] = 'transaction/setoran_pokok';
		$this->load->view('core',$data);
	}

	public function datatable_trx_setoran_pokok_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama','setor_tunai','setor_tabungan_wajib','setor_tabungan_kelompok','setor_tabungan_sukarela','trx_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_trx_setoran_pokok_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_trx_setoran_pokok_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_trx_setoran_pokok_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['trx_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="right">Rp '.number_format($aRow['setor_tunai'],0,',','.').',-</div>';
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			// $row[] = '<a href="javascript:;" trx_id="'.$aRow['trx_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_transaksi_setoran_pokok()
	{
		$cif_no		 				= $this->input->post('cif_no');
		$setor_tunai 				= $this->input->post('setor_tunai');
		$setor_tabungan_wajib	 	= $this->input->post('setor_tabungan_wajib');
		$setor_tabungan_kelompok 	= $this->input->post('setor_tabungan_kelompok');
		$setor_tabungan_sukarela 	= $this->input->post('setor_tabungan_sukarela');
		$total_setoran 				= $this->input->post('total_setoran');
			
		$data = array(
			'cif_no' 					=>$cif_no,
			'setor_tunai'				=>$this->convert_numeric($setor_tunai),
			'setor_tabungan_wajib' 		=>$this->convert_numeric($setor_tabungan_wajib),
			'setor_tabungan_kelompok' 	=>$this->convert_numeric($setor_tabungan_kelompok),
			'setor_tabungan_sukarela' 	=>$this->convert_numeric($setor_tabungan_sukarela),
			'total_setoran' 			=>$this->convert_numeric($total_setoran),
			'trx_date' 					=>date("Y-m-d H:i:s"),
			'created_by' 				=>$this->session->userdata('user_id')
			);

		$this->db->trans_begin();
		$this->model_transaction->add_transaksi_setoran_pokok($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function check_valid_cif_no()
	{
		$cif_no 		= $this->input->post('cif_no');
		$id_valid 		= $this->model_transaction->check_valid_cif_no($cif_no);

		if($id_valid==true){
			$return = array('stat'=>true);
		}else{
			$return = array('stat'=>false);
		}

		echo json_encode($return);

	}

	public function delete_trx_setoran_pokok()
	{
		$trx_id = $this->input->post('trx_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_id) ; $i++ )
		{
			$param = array('trx_id'=>$trx_id[$i]);
			$this->db->trans_begin();
			$this->model_transaction->delete_trx_setoran_pokok($param);
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
	// END TRANSAKSI SETORAN POKOK
	/****************************************************************************************/

	function cek_trx_kontrol_periode()
	{
		$tanggal = $this->input->post('tanggal');
		$tanggal = $this->datepicker_convert(true,$tanggal,$separator='/');
		$cek = $this->model_transaction->cek_trx_kontrol_periode($tanggal);
		$return = array('success'=>$cek);
		echo json_encode($return);
	}

	//Get tanggal realisasi pencairan
	public function get_plan_pencairan()
	{
		$tgl_pengajuan = $this->input->post('tanggal_pengajuan');
		$hari 		   = '7';
		$tanggal_pengajuan = date('d/m/Y',strtotime($tgl_pengajuan. '+'.$hari.' days'));

		echo json_encode(array('realisasi_pengajuan'=>$tanggal_pengajuan));
	}
	//Get tanggal realisasi pencairan

	// BEGIN REVIEW JURNAL TRANSAKSI
	public function review_transaksi()
	{
		$data['container'] 	= 'transaction/review_transaksi';
		$data['accounts'] 	= $this->model_transaction->get_gl_account();
		$this->load->view('core',$data);
	}

	public function get_review_transaksi()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_review_transaksi('','','','',$from_date,$thru_date);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_review_transaksi($sidx,$sort,$limit_rows,$start,$from_date,$thru_date);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			// $trx_detail = $this->model_transaction->get_trx_gl_detail($row['trx_gl_id']);
			// $desc = '';
			// for ( $j = 0 ; $j < count($trx_detail) ; $j++ ) {
			// 	if($j>0){
			// 		$desc.= '-';
			// 	}
			// 	$desc .= $trx_detail[$j]['description'];
			// }

			$responce['rows'][$i]['id'] = $row['trx_gl_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['trx_gl_id']
				,substr($row['trx_date'],0,10)
				,substr($row['voucher_date'],0,10)
				,$row['voucher_ref']
				,$row['description']
				,$row['total_debit']
				,$row['total_credit']
				,$row['jurnal_trx_type']
				,$row['jurnal_trx_id']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	function get_detail_review_transaksi()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'code';
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$trx_gl_id = isset($_REQUEST['trx_gl_id'])?$_REQUEST['trx_gl_id']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->get_detail_review_transaksi('','','','',$trx_gl_id);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->get_detail_review_transaksi($sidx,$sort,$limit_rows,$start,$trx_gl_id);
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id'] = $row['trx_gl_detail_id'];
			$responce['rows'][$i]['cell'] = array(
				 $row['trx_gl_detail_id']
				,$row['trx_gl_id']
				,$row['account_code']
				,$row['account_name']
				,$row['description']
				,$row['debit']
				,$row['credit']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function update_description_acctg_trans()
	{
		$acctg_trans_id = $this->input->post('acctg_trans_id');
		$description = $this->input->post('description');

		$data = array('description'=>$description);
		$param = array('acctg_trans_id'=>$acctg_trans_id);

		$this->db->trans_begin();
		$this->model_transaction->update_acctg_trans($data,$param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function update_acctg_trans_entry()
	{
		$trx_gl_detail_id = $this->input->post('trx_gl_detail_id');
		$trx_gl_id = $this->input->post('trx_gl_id');
		$account_code = $this->input->post('account_code');
		$description = $this->input->post('description');
		$debit = $this->input->post('debit');
		$credit = $this->input->post('credit');

		if($debit>$credit){
			$amount = $debit;
			$debit_credit_flag = 'D';
		}else if($credit>$debit){
			$amount = $credit;
			$debit_credit_flag = 'C';
		}else{
			$amount = 0;
			$debit_credit_flag = NULL;
		}

		$data = array(
				'account_code' => $account_code
				,'description' => $description
				,'flag_debit_credit' => $debit_credit_flag
				,'amount' => $this->convert_numeric($amount)
			);
		$param = array('trx_gl_detail_id'=>$trx_gl_detail_id,'trx_gl_id'=>$trx_gl_id);

		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl_detail($data,$param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function add_acctg_trans_entry()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$account_code = $this->input->post('account_code');
		$description = $this->input->post('description');
		$debit = $this->input->post('debit');
		$credit = $this->input->post('credit');

		if($debit>$credit){
			$amount = $debit;
			$debit_credit_flag = 'D';
		}else if($credit>$debit){
			$amount = $credit;
			$debit_credit_flag = 'C';
		}else{
			$amount = 0;
			$debit_credit_flag = NULL;
		}

		$trx_sequence = $this->model_transaction->get_trx_gl_detail_sequence($trx_gl_id);

		$data[] = array(
				'trx_gl_detail_id' => uuid(false)
				,'trx_gl_id' => $trx_gl_id
				,'account_code' => $account_code
				,'description' => $description
				,'flag_debit_credit' => $debit_credit_flag
				,'amount' => $this->convert_numeric($amount)
				,'trx_sequence' => $trx_sequence
			);

		$this->db->trans_begin();
		$this->model_transaction->insert_trx_gl_detail($data);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_jurnal_transaksi_detail()
	{
		$trx_gl_detail_id = $this->input->post('trx_gl_detail_id');
		$param = array('trx_gl_detail_id'=>$trx_gl_detail_id);

		$this->db->trans_begin();
		$this->model_transaction->delete_trx_gl_detail($param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();
			$return = array('success'=>true);
		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_jurnal_transaksi()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$param = array('trx_gl_id'=>$trx_gl_id);

		$this->db->trans_begin();
		$this->model_transaction->delete_trx_gl_detail($param);
		if($this->db->trans_status()===true)
		{
			$this->db->trans_commit();

			$this->db->trans_begin();
			$this->model_transaction->delete_trx_gl($param);
			$this->model_transaction->delete_trx_gl_cash($param);
			if($this->db->trans_status()===true)
			{
				$this->db->trans_commit();
				$return = array('success'=>true);
			}
			else
			{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}

		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/* PENCAIRAN TABUNGAN */

	public function pencairan_tabungan()
	{

		$data['container'] = 'transaction/pencairan_tabungan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/* DELETING TRANSACTION SAVING(TABUNGAN) */

	/**
	* DELETE SETORAN TUNAI
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_setoran_tunai()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		$data_trx_account_saving=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id);
		if(count($data_trx_account_saving)==1){
			$data_trx_account_saving=$data_trx_account_saving[0];
			$account_saving_no=$data_trx_account_saving['account_saving_no'];
			$data_account_saving=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$amount=$data_trx_account_saving['amount'];
			$data=array('saldo_memo'=>$data_account_saving['saldo_memo']-$amount);
			$param=array('account_saving_no'=>$account_saving_no);
			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data,$param);
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/**
	* DELETE PENARIKAN TUNAI
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_penarikan_tunai()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		$data_trx_account_saving=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id);
		if(count($data_trx_account_saving)==1){
			$data_trx_account_saving=$data_trx_account_saving[0];
			$account_saving_no=$data_trx_account_saving['account_saving_no'];
			$data_account_saving=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no);
			$amount=$data_trx_account_saving['amount'];
			$data=array('saldo_memo'=>$data_account_saving['saldo_memo']+$amount);
			$param=array('account_saving_no'=>$account_saving_no);
			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data,$param);
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}
	/**
	* DELETE PINBUK
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function delete_pinbuk()
	{
		$trx_detail_id=$this->input->post('trx_detail_id');
		
		$data_pinbuk_keluar=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id,3);
		$data_pinbuk_masuk=$this->model_transaction->get_trx_account_saving_by_trx_detail_id($trx_detail_id,4);
		// print_r($data_pinbuk_keluar);
		// print_r($data_pinbuk_masuk);
		// die();
		if(count($data_pinbuk_keluar)==1 && count($data_pinbuk_masuk)==1){

			$data_pinbuk_keluar=$data_pinbuk_keluar[0];
			$data_pinbuk_masuk=$data_pinbuk_masuk[0];

			$account_saving_no_sumber=$data_pinbuk_keluar['account_saving_no'];
			$account_saving_no_tujuan=$data_pinbuk_masuk['account_saving_no'];

			$data_account_saving_sumber=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no_sumber);
			$data_account_saving_tujuan=$this->model_transaction->get_account_saving_by_account_saving_no($account_saving_no_tujuan);

			$amount_sumber=$data_pinbuk_keluar['amount'];
			$amount_tujuan=$data_pinbuk_masuk['amount'];

			$data_sumber=array('saldo_memo'=>$data_account_saving_sumber['saldo_memo']+$amount_sumber);
			$param_sumber=array('account_saving_no'=>$account_saving_no_sumber);

			$data_tujuan=array('saldo_memo'=>$data_account_saving_tujuan['saldo_memo']-$amount_tujuan);
			$param_tujuan=array('account_saving_no'=>$account_saving_no_tujuan);

			$param_trx_detail=array('trx_detail_id'=>$trx_detail_id);
			// echo 'saldo_memo_sumber:'.$data_account_saving_sumber['saldo_memo'];
			// echo '|';
			// echo 'saldo_memo_tujuan:'.$data_account_saving_tujuan['saldo_memo'];
			// print_r($data_sumber);
			// print_r($data_tujuan);
			// die();
			$this->db->trans_begin();
			$this->model_transaction->update_account_saving($data_sumber,$param_sumber);
			$this->model_transaction->update_account_saving($data_tujuan,$param_tujuan);
			$this->model_transaction->delete_trx_account_saving($param_trx_detail);
			$this->model_transaction->delete_trx_detail($param_trx_detail);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}else{
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function get_product_financing_data_by_code()
	{
		$product_code=$this->input->post('product_code');
		$data=$this->model_transaction->get_product_financing_data_by_code($product_code);
		echo json_encode($data);
	}


	/**
	* GET FINANCING SCORING VALUE
	* @author sayyid nurkilah
	*/
	function get_scoring_pembiayaan()
	{
		$registration_no=$this->input->post('registration_no');
		$total_score=$this->model_transaction->get_total_scoring_pembiayaan($registration_no);
		echo json_encode(array('total_score'=>$total_score));
	}

	/**
	* AJAX GET DATA PENGAJUAN BY REGISTRATION NO
	* @author sayyid nurkilah
	*/
	function ajax_get_data_pengajuan_by_registration_no()
	{
		$registration_no=$this->input->post('registration_no');
		$data=$this->model_transaction->get_data_pengajuan_by_registration_no($registration_no);
		echo json_encode($data);
	}

	/**
	* AJAX GET SEQUENCE NUMBER OF ACCOUNT SAVING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	function get_seq_account_saving_no()
	{
		$product_code=$this->input->post('product_code');
		$cif_no=$this->input->post('cif_no');
		$data=$this->model_transaction->get_seq_account_saving_no($product_code,$cif_no);
		$jumlah=(int)$data['jumlah'];
		if(count($data)>0){
			$newseq=$jumlah+1;
			if($jumlah<10){
				$newseq='0'.$newseq;
			}
		}else{
			$newseq='01';
		}
		$return=array('newseq'=>$newseq);
		echo json_encode($return);
	}

	/**
	* AJAX GET SEQUENCE NUMBER OF ACCOUNT FINANCING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	function get_seq_account_financing_no()
	{
		$product_code=$this->input->post('product_code');
		$cif_no=$this->input->post('cif_no');
		$data=$this->model_transaction->get_seq_account_financing_no($product_code,$cif_no);
		$jumlah=(int)$data['jumlah'];
		if(count($data)>0){
			$newseq=$jumlah+1;
			if($jumlah<10){
				$newseq='0'.$newseq;
			}
		}else{
			$newseq='01';
		}
		$return=array('newseq'=>$newseq);
		echo json_encode($return);
	}

	/**
	* AJAX GET BIAYA JASA LAYANAN
	* @author sayyid nurkilah
	* @param nilai_pembiayaan
	*/
	function get_ajax_biaya_jasa_layanan()
	{
		$nilai_pembiayaan=$this->input->post('nilai_pembiayaan');
		$product_code=$this->input->post('product');
		$rate_jasa_layanan=$this->model_transaction->get_rate_jasa_layanan($product_code);
		$biaya_jasa_layanan = $nilai_pembiayaan*$rate_jasa_layanan/100;
		$return=array('biaya_jasa_layanan'=>$biaya_jasa_layanan,'rate_jasa_layanan'=>$rate_jasa_layanan);
		echo json_encode($return);
	}

	/*
	AJAX GET BIAYA SALDO MEMO TABUNGAN
	@author Ujang Irawan
	*/
	public function get_saldo_memo_tabungan()
	{
		$account_saving = $this->input->post('account_saving');
		$data = $this->model_transaction->get_saldo_memo_tabungan($account_saving);

		echo json_encode($data);
	}

	public function get_periode_angsuran_by_product_code()
	{
		$product_code = $this->input->post('product_code');
		$data = $this->model_transaction->get_periode_angsuran_by_product_code($product_code);
		echo json_encode($data);
	}

	public function get_status_pengajuan_pembiayaan()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_status_pengajuan_pembiayaan($cif_no);
		echo json_encode($data);
	}

	public function get_status_pembiayaan()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_status_pembiayaan($cif_no);
		echo json_encode($data);
	}

	public function count_data_pengajuan_pembiayaan()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->count_data_pengajuan_pembiayaan($cif_no);
		echo json_encode($data);
	}

	/***********************************************************************************************/
	//CETAK ULANG VALIDASI
	public function cetak_ulang_validasi()
	{
		$data['container'] = 'transaction/cetak_ulang_validasi';
		$this->load->view('core',$data);
	}

	function datatable_cetak_ulang_validasi()
	{
		$from_date = $this->datepicker_convert(true,$this->input->get('from_date'),'/');
		$to_date = $this->datepicker_convert(true,$this->input->get('to_date'),'/');
		$account_saving_no = $this->input->get('account_saving_no');
		$from_date = ($from_date=='')?'':$from_date;
		$to_date = ($to_date=='')?'':$to_date;
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','trx_date','account_saving_no', 'reference_no','description', 'flag_debit_credit','amount');
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
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
						$sWhere = " AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$dWhere['from_date'] 	= $from_date;
		$dWhere['to_date'] 		= $to_date;
		$dWhere['account_saving_no'] 	= $account_saving_no;

		$rResult 			= $this->model_transaction->datatable_cetak_ulang_validasi($dWhere,$sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_cetak_ulang_validasi($dWhere,$sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_cetak_ulang_validasi($dWhere); // get number of all data
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
			$row[] = '<div align="center" style="white-space:nowrap"><a href="javascript:void(0);" id="btn-cetakvoucher" class="btn mini green" style="white-space:nowrap" trx_account_saving_id="'.$aRow['trx_account_saving_id'].'"><i class="icon-print"></i> Cetak</a></div>';
			$row[] = '<div align="center">'.date('d-m-Y',strtotime($aRow['trx_date'])).'</div>';
			$row[] = '<div align="left">'.$aRow['account_saving_no'].'</div>';
			$row[] = $aRow['reference_no'];
			$row[] = $aRow['description'];
			$row[] = '<div align="center">'.$aRow['flag_debit_credit'].'</div>';
			$row[] = '<div align="right">'.number_format($aRow['amount'],2,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_data_cetak_ulang_validasi()
	{
		$trx_account_saving_id 	= $this->input->post('trx_account_saving_id');

		$data_cetak = $this->model_transaction->get_data_cetak_ulang_validasi($trx_account_saving_id);

				$account_saving = $data_cetak['account_saving_no'];
				$nama = $data_cetak['nama'];
				$teller 		= $this->session->userdata('branch_code').'.'.$this->session->userdata('user_id');
				$amount 		= 'IDR'.$data_cetak['amount'];
				$date_time 		= $data_cetak['trx_date'].' '.date('H:i:s');
		$return = array('success'=>true,'account_saving'=>$account_saving,'teller'=>$teller,'amount'=>$amount,'date_time'=>$date_time,'nama'=>$nama);
		
		echo json_encode($return);
	}
	//END CETAK ULANG VALIDASI
	/***********************************************************************************************/

	/*
	| Modul : Update Tanggal Transaksi Jurnal
	| author : Sayyid Nurkilah
	| Date : 09/10/2014 10:29
	*/
	public function jurnal_update_tanggal_transaksi()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$trx_date = $this->input->post('trx_date');
		$voucher_date = $this->input->post('voucher_date');
		$jurnal_trx_type = $this->input->post('jurnal_trx_type');
		$jurnal_trx_id = $this->input->post('jurnal_trx_id');

		// converting date from fromat id(dd/mm/yyyy) to en(yyyy-mm-dd)
		$trx_date = $this->datepicker_convert(true,$trx_date,'/');
		$voucher_date = $this->datepicker_convert(true,$voucher_date,'/');

		/*
		| get trx detail id di tabungan by jurnal trx id
		| get trx detail id di pembiayaan by jurnal trx id
		
		if($jurnal_trx_type=='1'){
			$trx_detail_id=$this->model_transaction->get_trx_detail_id_di_tabungan_by_jurnal_trx_id($jurnal_trx_id);
		}
		if($jurnal_trx_type=='3'){
			$trx_detail_id=$this->model_transaction->get_trx_detail_id_di_pembiayaan_by_jurnal_trx_id($jurnal_trx_id);
		}
		*/
		
		$data = array('trx_date'=>$trx_date,'voucher_date'=>$voucher_date);
		$param = array('trx_gl_id'=>$trx_gl_id);

		/*
		$data_tabungan = array('trx_date'=>$voucher_date);
		$param_tabungan = array('trx_account_saving_id'=>$jurnal_trx_id);

		$data_pembiayaan = array('trx_date'=>$voucher_date);
		$param_pembiayaan = array('trx_account_financing_id'=>$jurnal_trx_id);

		$data_trx_detail = array('trx_date'=>$voucher_date);
		$param_trx_detail = array('trx_detail_id'=>$trx_detail_id);
		*/

		$this->db->trans_begin();
		$this->model_transaction->update_trx_gl($data,$param);
		/*
		| execute update tabungan
		| execute update pembiayaan
		
		if($jurnal_trx_type=='1') {
			$this->model_transaction->update_trx_account_saving($data_tabungan,$param_tabungan);
			if($trx_detail_id!=false){
				$this->model_transaction->update_trx_detail($data_trx_detail,$param_trx_detail);
			}
		}
		else if($jurnal_trx_type=='3') {
			$this->model_transaction->update_trx_account_financing($data_pembiayaan,$param_pembiayaan); //pembiayaan
			if($trx_detail_id!=false){
				$this->model_transaction->update_trx_detail($data_trx_detail,$param_trx_detail);
			}
		}
		*/
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/**
	* @param : cif_no, tgl_akad
	*/
	function ajax_pembiayaan_same_is_exists()
	{
		$cif_no=$this->input->post('cif_no');
		$tgl_akad=$this->datepicker_convert(true,$this->input->post('tgl_akad'),'/');
		$pembiayaan_same_is_exists = $this->model_transaction->pembiayaan_same_is_exists($cif_no,$tgl_akad);
		$return = array('result'=>$pembiayaan_same_is_exists);
		echo json_encode($return);
	}
	/**
	* @param : cif_no
	*/
	function ajax_pembiayaan_active_is_exists()
	{
		$cif_no=$this->input->post('cif_no');
		$pembiayaan_active_is_exists = $this->model_transaction->pembiayaan_active_is_exists($cif_no);
		$return = array('result'=>$pembiayaan_active_is_exists);
		echo json_encode($return);
	}
	/* INSERT DENDA */
	function penalty_charge_finance()
	{
		$data['title'] = 'DENDA ANGSURAN PEMBIAYAAN';
		$data['container'] = 'transaction/penalty_charge_finance';
		$this->load->view('core',$data);
	}

	function do_penalty_charge_finance()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$account_saving_no = $this->input->post('account_saving_no');
		$trx_date = $this->input->post('trx_date');
		$trx_date = $this->datepicker_convert(true,$trx_date,'/');
		$angsuran_ke = $this->input->post('counter_angsuran');
		$nominal_denda = $this->input->post('nominal_denda');
		$nominal_denda = $this->convert_numeric($nominal_denda);
		$trx_detail_id = uuid(false);

		/* mfi trx detail */
		$data_detail = array(
				'trx_detail_id'=>$trx_detail_id
				,'trx_type'=>'1'
				,'trx_account_type'=>'7'
				,'account_no'=>$account_saving_no
				,'flag_debit_credit'=>'C'
				,'amount'=>$nominal_denda
				,'trx_date'=>$trx_date
				,'description'=>'PEMBAYARAN DENDA ANGSURAN KE-'.$angsuran_ke
				,'created_by' => $this->session->userdata('user_id')
				,'created_date' => date('Y-m-d H:i:s')
				,'account_no_dest'=>NULL
				,'account_type_dest'=>NULL
			);
		/* mfi trx account saving */
		$data = array(
				'branch_id' => $this->session->userdata('branch_id')
				,'account_saving_no' => $account_saving_no
				,'trx_saving_type' => '7'
				,'flag_debit_credit' => 'D'
				,'trx_date' => $trx_date
				,'amount' => $nominal_denda
				,'description' => 'PEMBAYARAN DENDA ANGSURAN KE-'.$angsuran_ke
				,'created_date' => date('Y-m-d H:i:s')
				,'created_by' => $this->session->userdata('user_id')
				,'trx_status' => 0
				,'flag_pencairan' => 0
				,'trx_detail_id'=>$trx_detail_id
			);

		$this->db->trans_begin();
		$this->db->insert('mfi_trx_detail',$data_detail);
		$this->db->insert('mfi_trx_account_saving',$data);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/*
	*koptel
	*/
	public function get_ajax_value_from_nik()
	{
		$nik = $this->input->post('nik');
		$data = $this->model_transaction->get_ajax_value_from_nik($nik);
		$saldo_kewajiban = $this->model_transaction->get_summary_saldo_kewajiban($nik);
		$data['saldo_kewajiban_ke_koptel'] = $saldo_kewajiban['total_saldo'];
		// $data['tgl_lahir'] 	= $this->format_date_detail($data['tgl_lahir'],'id',false,'/');
		$data['thp_40'] = $data['thp']*40/100;
		$j_kewajiban = $this->model_transaction->jumlah_kewajiban($nik);
		$data['jumlah_kewajiban'] = str_replace('-','',$j_kewajiban['total_koptel']);
		echo json_encode($data);
	}
	/*
	*end koptel
	*/

	/*
	| BEGIN PENDEBETAN ANGSURAN KOPTEL
	| 02 APRIL 2015 - UJANG IRAWAN
	*/
	public function pendebetan_angsuran_koptel()
	{
		$data['container'] = 'transaction/pendebetan_angsuran_koptel';
		$data['debet'] = $this->model_transaction->get_data_angsuran();
		$this->load->view('core',$data);
	}

	function do_upload_pendebetan_angsuran()
	{
		$keterangan = $this->input->post('keterangan');
		$userfile = @$_FILES['userfile'];
		$file_name = $userfile['name'];
		$return = array('success'=>true,'file_name'=>$file_name);
		// echo $file_name;die();

		// Desired folder structure
		// $now = date("m-Y");
		$structure = './assets/data_pendebetan_angsuran/';

		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (file_exists($structure)==false) {
			if (!mkdir($structure, 0777, true)) {
				$return = array('success'=>false,'error'=>'Failed to create folder.');
			    // die('Failed to create folders...');
			}
		}
		// END Folder Condition

		$check_data = $this->model_transaction->check_data_is_exist();
		if($check_data==true){
			$return = array('success'=>false,'error'=>'Data sudah ada, harap di proses terlebih dahulu dengan menekan tombol <b> Save Pendebetan </b> !');
		}else{
			$config['upload_path'] = $structure;
			$config['allowed_types'] = 'xls|xlsx|csv';
			$config['max_size']	= '500000';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
			}
			else
			{
				$upload_data = $this->upload->data();
				$angsuran_id = uuid(false);
				$raw_data = array(
						'angsuran_id'=>$angsuran_id,
						'file_name'=>$upload_data['file_name'],
						'import_date'=>date('Y-m-d H:i:s'),
						'import_by'=>$this->session->userdata('user_id'),
						'file_client_name'=>$upload_data['client_name'],
						'file_ext'=>$upload_data['file_ext'],
						'file_type'=>$upload_data['file_type'],
						'keterangan'=>$keterangan
					);

				$this->db->trans_begin();
				$this->db->insert('mfi_angsuran_temp',$raw_data);
				if($this->db->trans_status()===true){
					try {
						$objPHPExcel = @PHPExcel_IOFactory::load($structure.$upload_data['file_name']);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$file_exists = true;
					} catch (Exception $e) {
						$file_exists = false;
					}

					if ($file_exists) {
						if($sheetData[1]['A'] !== 'No Pembiayaan' ||
						   $sheetData[1]['B'] !== 'NIK' ||
						   $sheetData[1]['C'] !== 'Nama Pegawai' ||
						   $sheetData[1]['D'] !== 'Product Name' ||
						   $sheetData[1]['E'] !== 'Jumlah Angsuran' ||
						   $sheetData[1]['F'] !== 'Realisasi Tagihan')
						{
							$this->db->trans_rollback();
							$return = array('success'=>false,'error'=>"File excel tidak sesuai template, unduh di list tagihan agar sesuai!");
						}else{
							$this->db->trans_commit();
							$return = array('success'=>true,'file_name'=>$upload_data['file_name']);
						}
					}else{
						$this->db->trans_rollback();
						$return = array('success'=>false,'error'=>"File not exist or file can't load but currupt!");
					}
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false,'error'=>'Failed to Connect into Databases');
				}
			}
		}

		echo json_encode($return);
	}

	public function delete_upload_pendebetan_angsuran()
	{
		$this->db->trans_begin();
		$this->db->where("status", 0);
		$this->db->delete("mfi_angsuran_temp");
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function jqgrid_pendebetan_angsuran()
	{
		$this->load->library('phpexcel');

		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$file_name = $this->model_transaction->get_file_name_by_file_client_name();

		// Desired folder structure
		// $now = date("m-Y");
		$structure = './assets/data_pendebetan_angsuran/';
		$file_name = $structure.$file_name;
		
		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;

			foreach($sheetData as $row){
				if($i>0)
				{
					$nik = isset($row['B'])?$row['B']:'';
					$_totalangs = $this->model_transaction->jumlah_kewajiban_for_angsuran($nik);

					if($row['A'] != ''){
						$list = $this->model_transaction->get_account_financing((string)$row['A']);
					}

					// PERUBAHAN RUMUS ANGS. POKOK & MARGIN KMG KPR, ASDIK
					if(in_array($list['product_code'], array(53, 54, 56))){
						$_saldo_pokok = $list['saldo_pokok'];
						$_margin = ($_saldo_pokok * ($list['rate_margin2'])/100) / 12;
						$_pokok = str_replace(array(',','.'),'',$row['E'])-$_margin;

						$angsuran_pokok = $_pokok;
						$angsuran_margin = $_margin;
					}else{
						$angsuran_pokok = $list['angsuran_pokok'];
						$angsuran_margin = $list['angsuran_margin'];
					}


					$responce['rows'][$idx]['no'] = isset($row['A'])?$row['A']:'';
					$responce['rows'][$idx]['cell'] = array(
						 isset($row['A'])?$row['A']:''
						,isset($row['A'])?$row['A']:''
						,$nik
						,isset($row['C'])?$row['C']:''
						,isset($angsuran_pokok)?$angsuran_pokok:''
						,isset($angsuran_margin)?$angsuran_margin:''
						,isset($row['D'])?$row['D']:''
						,isset($row['E'])?str_replace(array(',','.'),'',$row['E']):''
						,isset($row['F'])?str_replace(array(',','.'),'',$row['F']):''
					);
					$idx++;
				}
				$i++;
			}
		} else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);
	}

	public function process_pendebetan_angsuran_pembiayaan_koptel()
	{
		ini_set('memory_limit','1G');

		$nik = $this->input->post('nik');
		$nama = $this->input->post('nama');
		$hasil_proses = $this->input->post('hasil_proses');
		$keterangan = $this->input->post('keterangan');
		$account_financing_no = $this->input->post('account_financing_no');
		$trx_date = $this->datepicker_convert(true,$this->input->post('trx_date'),'/');
		$angsuran_id = $this->model_transaction->get_angsuran_id_from_mfi_angsuran_temp();
		$trx_is_processed = $this->model_transaction->trx_angsuran_temp_is_processed();
		
		if ($trx_is_processed==false) {

			$arr_angsuran = array();
			$un_ins_data = array();
			for ( $i = 0 ; $i < count($nik) ; $i++ ){
				if (trim($nik[$i])!="") {
					$get_data_financing = $this->model_transaction->get_account_financing_by_nik($nik[$i],1,$trx_date);
					
					if(count($get_data_financing)>0)
					{
						$get_data_financing = $this->model_transaction->get_account_financing_vItsme($account_financing_no[$i],$trx_date);
						if(count($get_data_financing) == 1){
						    $angsuran_pokok = $get_data_financing[0]['angsuran_pokok'];
						    $angsuran_margin = $get_data_financing[0]['angsuran_margin'];
						    $product_code = $get_data_financing[0]['product_code'];
						    $jumlah_angsuran = $angsuran_pokok+$angsuran_margin;

						    if($hasil_proses[$i] < $jumlah_angsuran){
						    	
						    	$un_ins_data[] = array(
									'nik' => $nik[$i],
									'nama' => $nama[$i],
									'angsuran_id' => $angsuran_id
								);

						    }else if($hasil_proses[$i] > $jumlah_angsuran){
						    	
						    	$next_arr = $hasil_proses[$i] / $jumlah_angsuran;
						    	$check_case = in_array($product_code, array(53, 54, 56));
						    	$account_saving_no = $nik[$i];

						    	// untuk KPR dan KMG, jiga realisasi lebih. Sisanya masuk ke angsuran. Yang dibayarkan sesuai tgl bayar
						    	if($check_case){
						    		$jumlah_tabungan = $hasil_proses[$i] - $jumlah_angsuran;

						    		$arrdata = array(
						    						'account_saving_no' => $account_saving_no,
						    						'jumlah_setoran' 	=> $jumlah_tabungan,
						    						'no_referensi'		=> "",
						    						'keterangan'		=> "SETORAN TUNAI (". strtoupper($nama[$i]) .")",
						    						'tgl_trx'			=> $trx_date
						    					);
						    		
						    		$this->model_transaction->insert_mfi_angsuran_temp_tab($arrdata, $angsuran_id);
						    		// $this->add_setoran_tunai($arrdata);

						    		$arr_angsuran[] = array(
					    				'account_financing_no'=>$account_financing_no[$i],
										'angsuran_id'=>$angsuran_id,
										'nik'=>$nik[$i],
										'jumlah_bayar'=>$this->convert_numeric($jumlah_angsuran),
										'jumlah_real'=>$this->convert_numeric($hasil_proses[$i]),
										'jumlah_settle'=>0,
										'offset'=>0
									);

						    	}else{

						    		if( preg_match('/^\d+$/',$next_arr) ){
							    		
							    		$iix = $next_arr;

							    	}else{
							    		
							    		$next_arr_bulat = floor($next_arr);
							    		$iix = $next_arr_bulat;
							    		$total_bulat = $jumlah_angsuran * $next_arr_bulat;
							    		$jumlah_tabungan = $hasil_proses[$i] - $total_bulat;

							    		$data_saving = $this->model_transaction->search_cif_by_account_saving_no($account_saving_no);
							    		
							    		$arrdata = array(
							    						'account_saving_no' => $account_saving_no,
							    						'jumlah_setoran' 	=> $jumlah_tabungan,
							    						'no_referensi'		=> "000000",
							    						'tgl_trx'			=> $trx_date
							    					);

							    		$this->model_transaction->insert_mfi_angsuran_temp_tab($arrdata, $angsuran_id);
							    		// $result_saving = $this->add_setoran_tunai($arrdata);

							    	}

							    	for($x=1; $x <= $iix; $x++){

						    			$proses_jml = $hasil_proses[$i]/$x;
						    			$jumlah_bayar = ($proses_jml==$hasil_proses[$i]) ? $jumlah_angsuran : $proses_jml;
						    			$offset =$x-1;

						    			$arr_angsuran[] = array(
						    				'account_financing_no'=>$account_financing_no[$i],
											'angsuran_id'=>$angsuran_id,
											'nik'=>$nik[$i],
											'jumlah_bayar'=>$this->convert_numeric($jumlah_angsuran),
											'jumlah_real'=>$this->convert_numeric($hasil_proses[$i]),
											'jumlah_settle'=>0,
											'offset'=>$offset
										);

						    		}
						    	}

						    }else{
						    	$arr_angsuran[] = array(
									'account_financing_no'=>$account_financing_no[$i],
									'angsuran_id'=>$angsuran_id,
									'nik'=>$nik[$i],
									'jumlah_bayar'=>$this->convert_numeric($hasil_proses[$i]),
									'jumlah_real'=>$this->convert_numeric($hasil_proses[$i]),
									'jumlah_settle'=>0,
									'offset'=>0
								);
						    }

						}else{
							$this->db->update('mfi_angsuran_temp',array('status'=>99),array('angsuran_id'=>$angsuran_id));
							$return = array('success'=>false,'message'=> "Terjadi Kesalahan, hubungi administrator. <i>(file controller/transaction in process_pendebetan_angsuran_pembiayaan_koptel)</i> !!! ". $account_financing_no[$i].','.$trx_date);
							echo json_encode($return);
							exit;
						}
					}
					else
					{
						$un_ins_data[] = array(
							'nik' => $nik[$i],
							'nama' => $nama[$i],
							'angsuran_id' => $angsuran_id
						);
					}
				}
			}

			$this->db->trans_begin();
			$this->db->update('mfi_angsuran_temp',array('status'=>1),array('angsuran_id'=>$angsuran_id));
			
			if (count($arr_angsuran)) {
				$this->db->insert_batch('mfi_angsuran_bayar',$arr_angsuran);
			}

			if(count($un_ins_data)>0){
				$this->model_transaction->insert_unins_angsuran_pembiayaan($un_ins_data);
			}
			
			if($this->db->trans_status()==true){
				$this->db->trans_commit();
				$return = $this->sisir_pembiayaan($angsuran_id,$trx_date,$un_ins_data);
				
				if($return==false){
					$this->db->trans_rollback();
					$return = array('success'=>false,'message'=>'Terdapat angsuran yang belum diverifikasi, harap menunggu dan upload ulang kembali!');
				}

			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed to connect into database. please try again latter');
			}

		} else {

			$return = array('success'=>false,'message'=>'Source File ini Sudah diproses. Silahkan Lakukan Verifikasi!');

		}

		echo json_encode($return);
	}

	function sisir_pembiayaan($angsuran_id,$trx_date,$un_ins_data)
	{
		// declare
		date_default_timezone_set('Asia/Jakarta');
		$created_date = date('Y-m-d H:i:s');
		$created_by = $this->session->userdata('user_id');
		$insert = array();
		$insert2 = array();
		$insert3 = array();
		$insert4 = array();
		$arr_settle = array();
		$is_canceled = array();
		$this->db->trans_begin();
		
		// // qry ssr 1
		// $data1 = $this->model_transaction->sisir_pembiayaan1($angsuran_id,$trx_date);
		// // echo "1<pre>";
		// // print_r($data1);
		// // exit;
		// for ( $i1 = 0 ; $i1 < count($data1) ; $i1++ ) {
		// 	// declare
		// 	$angsuran_bayar_id = $data1[$i1]['angsuran_bayar_id'];
		// 	$nik = $data1[$i1]['nik'];
		// 	$account_financing_no = $data1[$i1]['account_financing_no'];
		// 	$pokok = $data1[$i1]['pokok'];
		// 	$margin = $data1[$i1]['margin'];
		// 	$jumlah_bayar = $data1[$i1]['jumlah_bayar'];
		// 	$jtempo_angsuran_next = $data1[$i1]['jtempo_angsuran_next'];
		// 	$jumlah_settle = $pokok+$margin;

		// 	$arr_settle[] = $jumlah_settle;
		// 	// debet jumlah bayar
		// 	$update1 = array('jumlah_settle'=>$jumlah_settle,'status'=>1);
		// 	$param1 = array('id'=>$angsuran_bayar_id,'nik'=>$nik,'angsuran_id'=>$angsuran_id);
		// 	$this->db->update('mfi_angsuran_bayar',$update1,$param1);

		// 	/* validate for unverified transaction */
		// 	$_is_verified = $this->model_transaction->cek_unverified_transaction($account_financing_no);
		// 	if ($_is_verified==true) {

		// 		// insert to temporary angsuran
		// 		$insert[] = array(
		// 				'account_financing_no'=>$account_financing_no,
		// 				'trx_date'=>$trx_date,
		// 				'jto_date'=>$jtempo_angsuran_next,
		// 				'pokok'=>$pokok,
		// 				'margin'=>$margin,
		// 				'created_date'=>$created_date,
		// 				'created_by'=>$created_by,
		// 				'freq'=>1,
		// 				'nik'=>$nik,
		// 				'hasil_proses'=>$pokok+$margin,
		// 				'angsuran_id'=>$angsuran_id
		// 			);

		// 	} else {

		// 		$is_canceled[] = array(
		// 			'account_financing_no'=>$account_financing_no,
		// 			'angsuran_id'=>$angsuran_id
		// 		);

		// 	}
		// }

		// // qry ssr 2
		// $data2 = $this->model_transaction->sisir_pembiayaan2($angsuran_id,$trx_date);
		// // echo "2<pre>";
		// // print_r($data2);
		// // exit;
		// for ( $i2 = 0 ; $i2 < count($data2) ; $i2++ ) {
		// 	// declare
		// 	$angsuran_bayar_id = $data1[$i1]['angsuran_bayar_id'];
		// 	$nik = $data2[$i2]['nik'];
		// 	$jumlah_bayar = $data2[$i2]['jumlah_bayar'];
		// 	$jumlah_settle = 0;
		// 	// get account by nik v2
		// 	$pembiayaan = $this->model_transaction->get_account_financing_by_nik_v2($nik,$trx_date);

		// 	foreach($pembiayaan as $pmb):
		// 		$account_financing_no = $pmb['account_financing_no'];
		// 		$pokok = $pmb['pokok'];
		// 		$margin = $pmb['margin'];
		// 		$jtempo_angsuran_next = $pmb['jtempo_angsuran_next'];

		// 		/* validate for unverified transaction */
		// 		$_is_verified = $this->model_transaction->cek_unverified_transaction($account_financing_no);
		// 		if ($_is_verified==true) {

		// 			// insert to temporary angsuran
		// 			$insert[] = array(
		// 					'account_financing_no'=>$account_financing_no,
		// 					'trx_date'=>$trx_date,
		// 					'jto_date'=>$jtempo_angsuran_next,
		// 					'pokok'=>$pokok,
		// 					'margin'=>$margin,
		// 					'created_date'=>$created_date,
		// 					'created_by'=>$created_by,
		// 					'freq'=>1,
		// 					'nik'=>$nik,
		// 					'hasil_proses'=>$pokok+$margin,
		// 					'angsuran_id'=>$angsuran_id
		// 				);
		// 			$jumlah_settle += $pokok+$margin;

		// 		} else {

		// 			$is_canceled[] = array(
		// 				'account_financing_no'=>$account_financing_no,
		// 				'angsuran_id'=>$angsuran_id
		// 			);

		// 		}
		// 	endforeach;
			
		// 	// debet jumlah bayar
		// 	$arr_settle[] = $jumlah_settle;
		// 	$update2 = array('jumlah_settle'=>$jumlah_settle,'status'=>1);
		// 	$param2 = array('id'=>$angsuran_bayar_id,'nik'=>$nik,'angsuran_id'=>$angsuran_id);
		// 	$this->db->update('mfi_angsuran_bayar',$update2,$param2);
		// }

		// // qry ssr 3
		// $data3 = $this->model_transaction->sisir_pembiayaan3($angsuran_id,$trx_date);
		// // echo "3<pre>";
		// // print_r($data3);
		// // exit;
		// for ( $i3 = 0 ; $i3 < count($data3) ; $i3++ ) {
		// 	// declare
		// 	$angsuran_bayar_id = $data1[$i1]['angsuran_bayar_id'];
		// 	$nik = $data3[$i3]['nik'];
		// 	$freq = $data3[$i3]['freq'];
		// 	$jumlah_settle = 0;

		// 	for ( $j3 = 1 ; $j3 <= $freq ; $j3++ ) {

		// 		// get account by nik v2
		// 		$pembiayaan = $this->model_transaction->get_account_financing_by_nik_v2($nik,$trx_date,$j3);
		// 		foreach($pembiayaan as $pmb):
		// 			$account_financing_no = $pmb['account_financing_no'];
		// 			$pokok = $pmb['pokok'];
		// 			$margin = $pmb['margin'];
		// 			$jtempo_angsuran_next = $pmb['jtempo_angsuran_next'];
		// 			// $jtempo_angsuran_next = date('Y-m-d',strtotime($jtempo_angsuran_next) ." +$j3 month");

		// 			/* validate for unverified transaction */
		// 			$_is_verified = $this->model_transaction->cek_unverified_transaction($account_financing_no);
		// 			if ($_is_verified==true) {
						
		// 				// insert to temporary angsuran
		// 				$insert[] = array(
		// 						'account_financing_no'=>$account_financing_no,
		// 						'trx_date'=>$trx_date,
		// 						'jto_date'=>$jtempo_angsuran_next,
		// 						'pokok'=>$pokok,
		// 						'margin'=>$margin,
		// 						'created_date'=>$created_date,
		// 						'created_by'=>$created_by,
		// 						'freq'=>1,
		// 						'nik'=>$nik,
		// 						'hasil_proses'=>$pokok+$margin,
		// 						'angsuran_id'=>$angsuran_id
		// 					);
		// 				$jumlah_settle += $pokok+$margin;

		// 			} else {

		// 				$is_canceled[] = array(
		// 					'account_financing_no'=>$account_financing_no,
		// 					'angsuran_id'=>$angsuran_id
		// 				);
		// 			}
		// 		endforeach;
		// 	}

		// 	// debet jumlah bayar
		// 	$arr_settle[] = $jumlah_settle;
		// 	$update3 = array('jumlah_settle'=>$jumlah_settle,'status'=>1);
		// 	$param3 = array('id'=>$angsuran_bayar_id,'nik'=>$nik,'angsuran_id'=>$angsuran_id);
		// 	$this->db->update('mfi_angsuran_bayar',$update3,$param3);
		// }

		// qry ssr 4
		$data4 = $this->model_transaction->sisir_pembiayaan4($angsuran_id,$trx_date);
		for ( $i4 = 0 ; $i4 < count($data4) ; $i4++ ) {
			// declare
			$angsuran_bayar_id = $data4[$i4]['angsuran_bayar_id'];
			$account_financing_no = $data4[$i4]['account_financing_no'];
			$nik = $data4[$i4]['nik'];
			$offset = $data4[$i4]['offset'];
			$jumlah_bayar = $data4[$i4]['jumlah_bayar'];
			$jumlah_settle = 0;

			$loop_n = 1;
			$is_break = false;
			$wait_verif = false;
			do {
				$loop_n = ($offset == 0) ? $loop_n : $offset+1;
    			$get_data_financing = $this->model_transaction->get_account_financing_by_no_pembiayaan($account_financing_no,$loop_n,$trx_date);
    			foreach($get_data_financing as $data_financing):
			    	
			    	// check apabila pelunasan atau tidak ada angsuran yg harus di angsur
			    	if ($data_financing['angsuran_pokok']>0 || $data_financing['angsuran_margin']>0) {
				    	
				    	// PERUBAHAN RUMUS ANGS. POKOK & MARGIN KMG KPR, ASDIK
						if(in_array($data_financing['product_code'], array(53, 54, 56))){
							$_saldo_pokok = $data_financing['saldo_pokok'];
							$_margin = ($_saldo_pokok * ($data_financing['rate_margin2'])/100) / 12;
							$_pokok = ($data_financing['angsuran_pokok']+$data_financing['angsuran_margin'])-$_margin;

							$pokok = $_pokok;
							$margin = $_margin;
						}else{
							$pokok = $data_financing['angsuran_pokok'];
							$margin = $data_financing['angsuran_margin'];
						}
						
						// new declare
		    			$account_financing_no = $data_financing['account_financing_no'];
						$jtempo_angsuran_next = $data_financing['jtempo_angsuran_next'];
						$jumlah_angsuran = $pokok+$margin;
						
						/* validate for unverified transaction */
						$_is_verified = $this->model_transaction->cek_unverified_transaction($account_financing_no);
						if ($_is_verified==true) {

							// checking jumlah_bayar is avaible for paying or not
							// if avaible the angsuran of this row/account will be processed
							// this what will do
							if ($jumlah_bayar>=$jumlah_angsuran)
							{
								$jumlah_bayar -= $jumlah_angsuran;
								$insert[] = array(
									'account_financing_no'=>$account_financing_no,
									'trx_date'=>$trx_date,
									'jto_date'=>$jtempo_angsuran_next,
									'pokok'=>$pokok,
									'margin'=>$margin,
									'created_date'=>$created_date,
									'created_by'=>$created_by,
									'freq'=>1,
									'nik'=>$nik,
									'hasil_proses'=>$pokok+$margin,
									'angsuran_id'=>$angsuran_id
								);
								$jumlah_settle += $pokok+$margin;
							}
							else
							{
								$is_break = true;
							}

						} else {
							$wait_verif = true;
							// $is_canceled[] = array(
							// 	'account_financing_no'=>$account_financing_no,
							// 	'angsuran_id'=>$angsuran_id
							// );
							$is_break = true;
						}

					} else {
						$is_break = true;
					}

	    		endforeach;
				if ($is_break==true) {
					break;
				}

	    		$loop_n++;

			} while ($loop_n > 1);

			// debet jumlah bayar
			$arr_settle[] = $jumlah_settle;
			$update4 = array('jumlah_settle'=>$jumlah_settle,'status'=>1);
			$param4 = array('id'=>$angsuran_bayar_id,'account_financing_no'=>$account_financing_no,'angsuran_id'=>$angsuran_id);
			$this->db->update('mfi_angsuran_bayar',$update4,$param4);

		}

		if($wait_verif==true){

			$this->db->trans_rollback();
			return false;
			exit;

		}else{

			if(count($insert)>0){
				$this->db->insert_batch('mfi_angsuran_temp_detail',$insert);
			}
			// if (count($is_canceled)>0) {
			// 	$this->db->insert_batch('mfi_angsuran_temp_detail_canceled',$is_canceled);
			// }

			if ($this->db->trans_status()===true) {
				$this->db->trans_commit();
			} else {
				$this->db->trans_rollback();
			}

			return array('success'=>true,'angsuran_id'=>$angsuran_id,'is_unins'=>count($un_ins_data),'is_canceled'=>count($is_canceled));	
		}
	}

	function export_log_trx_pendebetan()
	{
		/*
		| DECLARE URI SEGMENT DATA
		*/
		$trx_date=$this->uri->segment(3);
		$angsuran_id=$this->uri->segment(4);
		$datas = $this->model_transaction->get_log_trx_pendebetan($trx_date,$angsuran_id);
		$data_angsuran_temp = $this->model_transaction->get_mfi_angsuran_temp_by_angsuran_id($angsuran_id);

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
		
		/*
		| BORDER OPTION
		*/
		$styleArray['borders']['outline']['style']=PHPExcel_Style_Border::BORDER_THIN;
		$styleArray['borders']['outline']['color']['rgb']='000000';
		/*
		| SET COLUMN WIDTH
		*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

		/*
		| ROW HEADER TITLE
		*/
		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"List Angsuran Ter Debet");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		
		$row+=2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Jumlah Pembayaran");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,"Jumlah Terdebet");
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Selisih");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row.':C'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row.':D'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row.':E'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;
		/*
		| ROW DATA
		*/
		for($i=0;$i<count($datas);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$datas[$i]['nik']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$datas[$i]['jumlah_bayar']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$datas[$i]['jumlah_angsuran']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,($datas[$i]['jumlah_bayar']-$datas[$i]['jumlah_angsuran']));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setSize(11);
			$row++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ANGSURAN TER DEBET_'.$data_angsuran_temp['keterangan'].'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	function export_nik_unins_angsuran()
	{
		/*
		| DECLARE URI SEGMENT DATA
		*/
		$angsuran_id=$this->uri->segment(3);
		$datas = $this->model_transaction->get_angsuran_unins($angsuran_id);

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
		
		/*
		| BORDER OPTION
		*/
		$styleArray['borders']['outline']['style']=PHPExcel_Style_Border::BORDER_THIN;
		$styleArray['borders']['outline']['color']['rgb']='000000';
		/*
		| SET COLUMN WIDTH
		*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

		/*
		| ROW HEADER TITLE
		*/
		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"List Angsuran Non-Debet");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Nama");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;
		/*
		| ROW DATA
		*/
		for($i=0;$i<count($datas);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$datas[$i]['nik']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setSize(11);
			$row++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ANGSURAN NON-DEBET.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	/*
	| END PENDEBETAN ANGSURAN
	*/

	/*
	BEGIN PERCEPATAN PELUNASAN
	11-2018, Asep Dicky / dickysigma@gmail.com 
	*/
	
	public function percepatan_pelunasan()
	{
		$data['container'] = 'transaction/percepatan_pelunasan_koptel';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	function do_upload_percepatan_pelunasan()
	{
		$userfile = @$_FILES['userfile'];
		$file_name = $userfile['name'];
		
		// Desired folder structure
		$structure = './assets/data_percepatan_pelunasan/';

		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (file_exists($structure)==false) {
			if (!mkdir($structure, 0777, true)) {
				$return = array('success'=>false,'error'=>'Failed to create folder.');
			    // die('Failed to create folders...');
			}
		}
		// END Folder Condition

		$file_name = time().$_FILES["userfiles"]['name'];
		$config['file_name'] = $file_name;
		$config['upload_path'] = $structure;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']	= '500000';
		$return = array('success'=>true,'file_name'=>$file_name);

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
		}
		else
		{
			$upload_data = $this->upload->data();
			$excel_id = uuid(false);

			$raw_data = array(
					'excel_id'=>$excel_id,
					'file_name'=>$upload_data['file_name'],
					'import_date'=>date('Y-m-d H:i:s'),
					'import_by'=>$this->session->userdata('user_id'),
					'file_client_name'=>$upload_data['client_name'],
					'file_ext'=>$upload_data['file_ext'],
					'file_type'=>$upload_data['file_type']
				);

			$this->db->trans_begin();
			$this->db->insert('mfi_account_financing_lunas_temp',$raw_data);
			if($this->db->trans_status()===true){
				try {
					$objPHPExcel = @PHPExcel_IOFactory::load($structure.$upload_data['file_name']);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$file_exists = true;
				} catch (Exception $e) {
					$file_exists = false;
				}

				if($sheetData[1]['A'] !== 'No Pembiayaan' ||
				   $sheetData[1]['B'] !== 'NIK' ||
				   $sheetData[1]['C'] !== 'Nama Pegawai' ||
				   $sheetData[1]['D'] !== 'Total Bayar')
				{
					$this->db->trans_rollback();
					$return = array('success'=>false,'error'=>"File excel tidak sesuai template, unduh di list tagihan agar sesuai!");
				}else{
					$this->db->trans_commit();
					$return = array('success'=>true,'file_name'=>$upload_data['file_name']);
				}
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'error'=>'Failed to Connect into Databases');
			}
		}

		echo json_encode($return);
	}

	function delete_upload_percepatan_pelunasan()
	{
		$this->db->trans_begin();
		$this->db->where("status", 0);
		$this->db->delete("mfi_account_financing_lunas_temp");
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function jqgrid_pelunasan_angsuran()
	{
		$this->load->library('phpexcel');

		$formula_base = $this->input->get('formula_base');
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$file_name = $this->model_transaction->get_file_name_pelunasan();

		// Desired folder structure
		$structure = './assets/data_percepatan_pelunasan/';
		$file_name = $structure.$file_name;
		
		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;

			foreach($sheetData as $row){
				if($i>0)
				{
					$nik = isset($row['B'])?$row['B']:'';
					$total_bayar = str_replace(array(',','.'),'',$row['D']);
					
					$_saldo = $this->model_transaction->get_list_saldo((string)$nik,(string)$row['A']);
					$sisa = ($_saldo[0]['jangka_waktu'] - $_saldo[0]['counter_angsuran']);
					/*$margin_sisa = $total_bayar - $_saldo[0]['saldo_pokok'];
					$pokok_sisa= $total_bayar - $margin_sisa;
					$saldopokok = ($sisa == 1) ? $pokok_sisa : $_saldo[0]['saldo_pokok'];
					$saldomargin = ($sisa == 1) ? ($margin_sisa) : 0;*/

					switch ($formula_base) {
						case 'A':
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = $_saldo[0]['saldo_margin'];

							$bayar_seharusnya = $saldopokok + $saldomargin;
							break;
						case 'B':
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = 0;

							$bayar_seharusnya = $saldopokok + $saldomargin;

							break;
						case 'C':
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = $_saldo[0]['angsuran_margin'];

							$bayar_seharusnya = $saldopokok + $saldomargin;
							break;
						case 'D':
						case 'E':
							$list = $this->model_transaction->get_margin_from_schedulle($row['A'],$formula_base);
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = round($list->angsuran_margin);

							$bayar_seharusnya = $saldopokok + $saldomargin;
							break;

						case 'F': case 'G':
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = $_saldo[0]['saldo_margin'];

							$bayar_seharusnya = $saldopokok + $saldomargin;
							break;
						
						default:
							$saldopokok = $_saldo[0]['saldo_pokok'];
							$saldomargin = $_saldo[0]['saldo_margin'];

							$bayar_seharusnya = $saldopokok + $saldomargin;
							break;
					}

					$responce['rows'][$idx]['no'] = isset($row['A'])?$row['A']:'';
					$responce['rows'][$idx]['cell'] = array(
						 isset($row['A'])?$row['A']:''
						,isset($row['A'])?$row['A']:''
						,$nik
						,isset($row['C'])?$row['C']:''
						,isset($_saldo[0]['product_name'])?$_saldo[0]['product_name']:''
						,isset($saldopokok) ? str_replace(array(',','.'),'',$saldopokok):''
						,isset($saldomargin) ? str_replace(array(',','.'),'',$saldomargin):''
						,$bayar_seharusnya
						,isset($total_bayar) ? $total_bayar : ''
					);
					$idx++;
				}
				$i++;
			}
		} else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);
	}

	function process_pelunasan_angsuran()
	{

		ini_set('memory_limit','1G');

		$nik = $this->input->post('nik');
		$nama = $this->input->post('nama');
		$total_bayar = $this->input->post('total_bayar');
		$bayar_seharusnya = $this->input->post('bayar_seharusnya');
		$account_financing_no = $this->input->post('account_financing_no');
		$account_cash_code = $this->input->post('account_cash_code');
		$trx_date = $this->input->post('trx_date');
		$formula_base = $this->input->post('formula_base');
		$trx_date = $this->datepicker_convert(true,$trx_date,'/');
		$created_by = $this->session->userdata('user_id');
		$created_date = date('Y-m-d H:i:s');
		$excel_id = $this->model_transaction->get_excel_id_from_mfi_financing_lunas_temp();
		
		$data_lunas = array();
		$trx_detail = array();
		$trx_account_financing = array();
		$un_ins_data = array();
		for ( $i = 0 ; $i < count($nik) ; $i++ ){
			if (trim($nik[$i])!="") {

				$data_usr = $this->model_nasabah->get_cif_by_account_financing_no($account_financing_no[$i]);
				$sisa = ($data_usr['jangka_waktu'] - $data_usr['counter_angsuran']);
				$angsuran_pokok = $data_usr['angsuran_pokok'];
				$angsuran_margin = $data_usr['angsuran_margin'];
				$last_angst = ($sisa == 0) ? true : false;
				
				if($total_bayar[$i] < $bayar_seharusnya[$i] && $last_angst == false && $formula_base !== 'G'){
					$un_ins_data[] = array(
									'nik' => $nik[$i],
									'nama' => $nama[$i],
									'excel_id' => $excel_id
								);
				}else{

					$trx_detail_id = uuid(false);
					$trx_account_financing_id = uuid(false);

					switch ($formula_base) {
						case 'F':
							$jumlah_tabungan = $total_bayar[$i]-$data_usr['saldo_pokok']-$data_usr['saldo_margin'];
							if(jumlah_tabungan!='0'):
								$account_saving_no = $nik[$i];
								
								$saldo_pokok = $this->convert_numeric($data_usr['saldo_pokok']);
								$saldo_margin = $data_usr['saldo_margin'];
								$potongan_margin = -1 * abs($jumlah_tabungan);
				    		endif;
							break;

						case 'G':
								$hutang = $bayar_seharusnya[$i]-$total_bayar[$i];
								$jumlah_tabungan = $total_bayar[$i]-$data_usr['saldo_pokok'];

								// $saldo_pokok = $this->convert_numeric($data_usr['saldo_pokok'])-$this->convert_numeric($hutang);
								$saldo_pokok = $this->convert_numeric($data_usr['saldo_pokok']);
								// $saldo_margin = $data_usr['angsuran_margin'];
								$saldo_margin = $data_usr['saldo_margin'];
								$potongan_margin = -1 * $jumlah_tabungan+$data_usr['saldo_margin'];
							break;

						default:
							// if($sisa==0){
							// 	$saldo_pokok = $angsuran_pokok;
							// 	$saldo_margin = $angsuran_margin;
							// 	$potongan_margin = 0;
							// }else{
								$saldo_pokok = $data_usr['saldo_pokok'];
								$saldo_margin = $data_usr['saldo_margin'];
								$potongan_margin = $data_usr['saldo_margin'];
							// }
							break;
					}

					$check_lunas = $this->model_transaction->get_num_account_financing_lunas($account_financing_no[$i]);
					if($check_lunas->num_rows() > 0){
						$data_update_lunas = array(
								 'saldo_pokok' 			=> $saldo_pokok
								,'saldo_margin' 		=> $saldo_margin
								,'potongan_margin' 		=> $potongan_margin
								,'status_pelunasan'		=> '0'
								,'create_by' 			=> $created_by
								,'tanggal_lunas' 		=> $trx_date
								,'created_date'			=> $created_date
						);
						$param_update_lunas = array('account_financing_no'=>$account_financing_no[$i]);


						$this->db->update("mfi_account_financing_lunas", $data_update_lunas, $param_update_lunas);
					}else{
						/*data financing lunas*/
						$data_lunas[] = array(
								'account_financing_lunas_id'=>$trx_account_financing_id
								,'account_financing_no'	=> $account_financing_no[$i]
								,'saldo_pokok' 			=> $saldo_pokok
								,'saldo_margin' 		=> $saldo_margin
								,'potongan_margin' 		=> $potongan_margin
								,'status_pelunasan'		=> '0'
								,'create_by' 			=> $created_by
								,'tanggal_lunas' 		=> $trx_date
								,'created_date'			=> $created_date
						);
					}

					// print_r($data_lunas);exit;
					$trx_detail[] = array(
							 'trx_detail_id' 			=> $trx_detail_id
							,'trx_type' 				=> '3'
							,'trx_account_type' 		=> '2'
							,'account_no' 				=> $account_financing_no[$i]
							,'flag_debit_credit'		=> 'C'
							,'amount' 					=> $data_usr['saldo_pokok']+$data_usr['saldo_margin']
							,'trx_date' 				=> $trx_date
							,'created_by' 				=> $this->session->userdata('user_id')
							,'created_date' 			=> date('Y-m-d H:i:s')
						);

					$trx_account_financing[] = array(
						'trx_account_financing_id'  => $trx_account_financing_id
						,'branch_id' 				=> $this->session->userdata('branch_id')
						,'trx_detail_id' 			=> $trx_detail_id
						,'account_financing_no' 	=> $account_financing_no[$i]
						,'trx_financing_type' 		=> '2'
						,'trx_date' 				=> $trx_date
						,'jto_date' 				=> $data_usr['tanggal_jtempo']
						,'pokok' 					=> $data_usr['saldo_pokok']
						,'margin' 					=> $data_usr['saldo_margin']
						,'catab' 					=> 0
						,'account_cash_code' 		=> $account_cash_code
						,'angsuran_ke' 				=> $data_usr['jangka_waktu']
						,'trx_status' 				=> 0
						,'created_date' 			=> date('Y-m-d H:i:s')
						,'created_by' 				=> $this->session->userdata('user_id')
					);
				}
			}
		}

		// echo '#1#';
		// print_r($data_lunas);
		// echo '#2#';
		// print_r($trx_detail);
		// echo '#3#';
		// print_r($trx_account_financing);
		// echo '#4#';
		// print_r($un_ins_data);
		// exit;

		$this->db->trans_begin();
		$this->db->update('mfi_account_financing_lunas_temp',array('status'=>1),array('excel_id'=>$excel_id));

		if (count($data_lunas)) {
			$this->db->insert_batch('mfi_account_financing_lunas',$data_lunas);
		}

		if (count($trx_detail)) {
			$this->db->insert_batch('mfi_trx_detail',$trx_detail);
		}

		if (count($trx_account_financing)) {
			$this->db->insert_batch('mfi_trx_account_financing',$trx_account_financing);
		}

		if(count($un_ins_data)>0){
			$this->db->insert_batch('mfi_account_financing_lunas_gagal',$un_ins_data);
		}
		
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
			$return = array('success'=>true,'excel_id'=>$excel_id,'is_unins'=>count($un_ins_data));
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Failed to connect into database. please try again latter');
		}

		echo json_encode($return);

	}

	function export_nik_unins_lunas()
	{
		/*
		| DECLARE URI SEGMENT DATA
		*/
		$excel_id=$this->uri->segment(3);
		$datas = $this->model_transaction->get_lunas_gagal($excel_id);
		
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
		
		/*
		| BORDER OPTION
		*/
		$styleArray['borders']['outline']['style']=PHPExcel_Style_Border::BORDER_THIN;
		$styleArray['borders']['outline']['color']['rgb']='000000';
		/*
		| SET COLUMN WIDTH
		*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

		/*
		| ROW HEADER TITLE
		*/
		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"List Pelunasan Tidak Sesuai");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Nama");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;
		/*
		| ROW DATA
		*/
		for($i=0;$i<count($datas);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$datas[$i]['nik']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setSize(11);
			$row++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="PELUNASAN TIDAK SESUAI.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	/*
	END PELUNASAN
	*/

	/*
	BEGIN TOPUP (pelunasan dan pengajuan)
	11-2018, Asep Dicky / dickysigma@gmail.com 
	*/

	public function top_up()
	{
		$data['container'] = 'transaction/top_up_koptel';
		$this->load->view('core',$data);
	}

	public function do_upload_topup()
	{
		ini_set('memory_limit', '1G');
		set_time_limit(0);
		
		// Desired folder structure
		$structure = './assets/data_topup/';

		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (file_exists($structure)==false) {
			if (!mkdir($structure, 0777, true)) {
				$return = array('success'=>false,'error'=>'Failed to create folder.');
			    // die('Failed to create folders...');
			}
		}
		// END Folder Condition

		$filename = "topup";
		if (file_exists($structure.$filename.'.xlsx')==true) {
			$return = array('success'=>false,'error'=>'Terdapat file yang belum di proses!');
			echo json_encode($return);
			exit;
		}

		$config['file_name'] = $filename;
		$config['upload_path'] = $structure;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']	= '500000';
		$return = array('success'=>true,'file_name'=>$file_name);

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
		}else{
			$upload_data = $this->upload->data();
			
			$return = array('success'=>true);
		}

		echo json_encode($return);
	}

	function delete_upload_topup()
	{
		$file = "assets/data_topup/topup.xlsx";		 
		if (is_readable($file) && unlink($file)) {
		    $return = array('success'=>true);
		} else {
		    $return = array('success'=>false);
		}
		
		echo json_encode($return);
	}

	public function jqGrid_topup()
	{

		ini_set('memory_limit', '1G');
		ini_set('upload_max_filesize', '50M');
		ini_set('max_execution_time', '3600');
		set_time_limit(0);

		$this->load->library('phpexcel');

		$structure = './assets/data_topup/topup.xlsx';
		$file_client_name = isset($_REQUEST['file_name'])?$_REQUEST['file_name']:'';
		$file_name = $structure.$file_client_name;

		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;
			foreach($sheetData as $row){

				$nik = isset($row['A']) ? $row['A'] : '';
				$no_pembiayaan = isset($row['Z']) ? $row['Z'] : '';

				if($i>0 && !empty($nik)){

					$data = $this->model_transaction->get_ajax_value_from_nik($this->convert_numeric($nik));
					
	                $dates = $row['Q'];
	              	$months = $row['R'];
	              	$years = $row['S'];

	              	if($dates != "" || $months != "" || $years != ""){
	              		$ymd = $years.'-'.str_pad($months, 2, "0", STR_PAD_LEFT).'-'.str_pad($dates, 2, "0", STR_PAD_LEFT);
	              		$dmy = str_pad($dates, 2, "0", STR_PAD_LEFT).'/'.str_pad($months, 2, "0", STR_PAD_LEFT).'/'.$years;
	              		$tgl_akad = $ymd;
	              		$tgl_pengajuan = $ymd;
	              		$tgl_pengajuan2 = $dmy;
	              	}else{
	              		$tgl_akad = "";
	              		$tgl_pengajuan = "";
	              		$tgl_pengajuan2 = "";
	              	}

	              	$jangkawaktu = $row['G'];
					$amount = $row['F'];

					$product_code = $this->convert_numeric($row['C']);
	              	$product = $this->model_transaction->get_product_financing_by_productcode($this->convert_numeric($product_code));
	              	$jenis_margin = $product->jenis_margin;
	              	$rate = $product->rate_margin2;

					$jumlah_margin="";$angsuran_pokok="";
					if($jenis_margin == '2'){
						$jumlah_margin = $this->get_margin_efektif($amount, $jangkawaktu, $rate);
						$angsuran_pokok="0";
						$angsuran_margin="0";
						$total_angsuran="0";
					}else if($jenis_margin == '3'){ // anuitas
						$tmvalid = true;
						if ($amount=='' || $amount=='0') {
							$tmvalid = false;
						}
						if ($jangkawaktu=='' || $jangkawaktu=='0') {
							$tmvalid = false;
						}
						if ($tmvalid==true) {
							$res_anuitas = $this->get_total_angsuran_anuitas($amount, $jangkawaktu, $rate);

							$jumlah_margin = $res_anuitas['total_margin'];
							$angsuran_pokok = "0";
							$angsuran_margin = "0";
							$total_angsuran = in_array($row['C'], array(53, 54, 56)) ? $row['K'] : $res_anuitas['total_angsuran'];
						}
					}else{ // flat
						$angsuran_pokok = $row['I'];
				        $angsuran_margin = $row['J'];
				        $total_angsuran = $row['K'];
				        $jumlah_margin = $angsuran_margin*$jangkawaktu; //number_format($row['J'],0,',','.');
					}

					$counter = $row['L'];
					$lunasi_ke_koptel = $row['M'];
					$saldo_kewajiban_ke_koptel = $row['N'];
					$lunasi_ke_kopegtel = $row['O'];
					$saldo_kewajiban = $row['P'];
					
					$no_ktp = $row['T'];
					$bank = $row['U'];
					$cabang = $row['V'];
					$no_rekening = $row['W'];
					$nama_pemilik = $row['X'];
					$asuransi = $row['Y'];
					
					$usia = $this->get_usia_menurut_asuransi($data['tgl_lahir'],$tgl_pengajuan);
					$premi_asuransi = $this->get_premi_asuransi($jangkawaktu,$usia,$amount);

					$datas2 = $this->model_nasabah->cek_flag_thp100($this->convert_numeric($nik));
					$data2 = $this->model_nasabah->count_kopegtel_code_by_nik($this->convert_numeric($nik));
					$total = (count($datas2)==0) ? "0|".$data2 : $datas2['nik'].'|'.$data2;
					$explode2 = explode('|', $total);
                  	$flag_thp100 = ($explode2[0]=="0") ? "0" : "1";

                  	$_no_pembiayaan = ($no_pembiayaan==1) ? (!empty($no_pembiayaan) ? 1 : '') : (!empty($no_pembiayaan) ? $no_pembiayaan : '');

                  	if($_no_pembiayaan == ''){
                  		$_data = $this->model_transaction->get_financing_by_saldo_pokok((string)$nik, (string)$saldo_kewajiban_ke_koptel);	
                  	}else{
                  		$_data = $this->model_transaction->get_financing_by_saldo_pokok_v2((string)$nik, (string)$_no_pembiayaan);
                  	}
                  	$status_koptel = ($lunasi_ke_koptel=='1') ? '1' : '0';

					$responce['rows'][$idx]['cell'] = array(
						 $nik
						 ,$data['nik']
						 ,isset($data['nama_pegawai']) ? $data['nama_pegawai'] : ''
						 ,isset($product_code) ? $product_code : ''
						 ,isset($tgl_akad) ? $tgl_akad : ''
						 ,isset($tgl_pengajuan) ? $tgl_pengajuan : ''
						 ,isset($tgl_pengajuan2) ? $tgl_pengajuan2 : ''
						 ,isset($amount) ? $amount : ""
						 ,isset($jangkawaktu) ? $jangkawaktu : ""
						 ,isset($jumlah_margin) ? $jumlah_margin : ""
						 ,isset($counter) ? $counter : ""
						 ,isset($lunasi_ke_koptel) ? $lunasi_ke_koptel : ""
						 ,isset($saldo_kewajiban_ke_koptel) ? $saldo_kewajiban_ke_koptel : ""
						 ,isset($lunasi_ke_kopegtel) ? $lunasi_ke_kopegtel : '0'
						 ,isset($saldo_kewajiban) ? $saldo_kewajiban : ""
						 ,isset($data['gender']) ? $data['gender'] : ""
						 ,2,$status_koptel,0,""
						 ,isset($data['kopegtel_code']) ? $data['kopegtel_code'] : ""
						 ,isset($data['tempat_lahir']) ? $data['tempat_lahir'] : ''
						 ,isset($data['tgl_lahir']) ? $data['tgl_lahir'] : ''
						 ,isset($data['alamat']) ? $data['alamat'] : ''
						 ,isset($data['loker']) ? $data['loker'] : ''
						 ,isset($no_ktp) ? $no_ktp : ""
						 ,''
						 ,isset($data['telpon_seluler']) ? $data['telpon_seluler'] : ''
						 ,isset($data['nama_pasangan']) ? $data['nama_pasangan'] : ''
						 ,''
						 ,isset($bank) ? $bank : ""
						 ,isset($cabang) ? $cabang : ""
						 ,isset($no_rekening) ? $no_rekening : ""
						 ,isset($nama_pemilik) ? $nama_pemilik : ""
						 ,isset($data['thp']) ? $data['thp'] : ""
						 ,isset($asuransi) ? $asuransi : ""
						 ,$total_angsuran
						 ,$flag_thp100
						 ,$angsuran_pokok
						 ,$angsuran_margin
						 ,$_data['account_financing_no']
						 ,$_data['saldo_pokok']
						 ,$_data['saldo_margin']
						 ,"by_excel"
						 ,$jenis_margin
					);
					$idx++;
				}

				$i++;

			}

		}else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);

	}

	/*
	** Margin Efektif
	*/
	private function get_margin_efektif($pokok, $jangkawaktu, $margin_tahun)
	{
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
			// $angs_margin = round($margin_bulan*$sisa_pokok/100,2);
			$angs_margin = ($margin_bulan*$sisa_pokok)/100;
			// $angs_pokok  = round($pokok/$jangkawaktu,2);
			$angs_pokok  = ($pokok/$jangkawaktu);
			// $total_angsuran  = round(($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu),2);
			$total_angsuran  = ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			$Tangs_margin += $margin_bulan*$sisa_pokok/100;
			$Tangs_pokok += $pokok/$jangkawaktu;
			$Tangs += ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			
			$sisa_pokok  = $sisa_pokok-($pokok/$jangkawaktu);
		}

		return number_format($Tangs_margin,0,',','.');

	}

	/*
	Angsuran Anuitas
	*/
	function get_total_angsuran_anuitas($pokok, $jangkawaktu, $margin_tahun)
	{
		$pokok = $this->convert_numeric($pokok);
		if ($jangkawaktu==false) {
			$jangkawaktu = 0;
		}
		
		$ratemarginperbulan = $margin_tahun/100/12;
		$totalangss = round($pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu))))));
		$totalangs = $this->round_up($totalangss, -3);

		$totalmargin = 0;
		$saldopokok = $pokok;
		for ( $i = 1 ; $i <= $jangkawaktu ; $i++ ) {
			$angsmargin = $saldopokok*$ratemarginperbulan;
			$angspokok = $totalangs-$angsmargin;
			$saldopokok = $saldopokok-$angspokok;
			$totalmargin+=$angsmargin;
		}

		$data = array(
					"total_margin" => $totalmargin,
					"total_angsuran" => $totalangs
				);
		return $data;
	}

	function round_up ( $value, $precision )
	{ 
	    $pow = pow ( 10, $precision ); 
	    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	}

	/*
	PREMI ASURANSI
	*/
	function get_premi_asuransi($jangka_waktu,$usia,$manfaat)
	{
		$rate_code = '101';
		$kontrak = ceil($jangka_waktu/12);
		$rate_value = $this->model_nasabah->get_premium_rate($rate_code,$usia,$kontrak);
		$biaya_asuransi = $manfaat*($rate_value/1000);

		return $biaya_asuransi;

	}

	/*
	END PELUNASAN
	*/

	/*
	| BEGIN VERIFIKASI PENDEBETAN ANGSURAN KOPTEL
	| 02 APRIL 2015 - UJANG IRAWAN
	*/
	public function verifikasi_pendebetan_angsuran_koptel()
	{
		$data['container'] = 'transaction/verifikasi_pendebetan_angsuran_koptel';
		$data['debet'] = $this->model_transaction->get_data_angsuran1();
		$data['akun'] = $this->model_transaction->get_data_akun();
		$this->load->view('core',$data);
	}

	public function jqgrid_verifikasi_pendebetan_angsuran()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'mfi_angsuran_temp_detail.nik';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$filename = isset($_REQUEST['filename'])?$_REQUEST['filename']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->jqgrid_verifikasi_pendebetan_angsuran('','','','',$filename);
		// print_r($result);
		// exit;
		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->jqgrid_verifikasi_pendebetan_angsuran($sidx,$sord,$limit_rows,$start,$filename);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		for ($i=0; $i<count($result) ; $i++) 
		{ 
			$tx = $this->db->query("SELECT trx_date FROM mfi_angsuran_temp_detail WHERE angsuran_id='$filename' LIMIT 1")->row();

			$angsuran = ($result[$i]['pokok']+$result[$i]['margin']);
			$responce['rows'][$i]['id'] = $result[$i]['id'];
			$responce['rows'][$i]['cell'] = array(
				$result[$i]['angsuran_detail_id']
				,$result[$i]['nik']
				,$result[$i]['account_financing_no']
				,$result[$i]['nama_pegawai']
				,$result[$i]['pokok']
				,$result[$i]['margin']
				,$angsuran
				,($result[$i]['offset'] > 0) ? 0 : $result[$i]['jumlah_real']
				// ,$result[$i]['hasil_proses']
				,($result[$i]['offset'] > 0) ? 0 : $result[$i]['jumlah_real']
				,$angsuran
				// ,$result[$i]['trx_date']
				,$tx->trx_date
			);

			$x++;
		}

		echo json_encode($responce);
	}

	private function get_trx_angsuran_data($data)
	{
		// insert mfi_trx_detail
    	$ins_data_trx = array(
    			'trx_detail_id' => $data['b_trx_detail_id'],
    			'trx_type' => $data['b_trx_type'],
    			'trx_account_type' => $data['b_trx_account_type'],
    			'account_no' => $data['b_account_financing_no'],
    			'flag_debit_credit' => 'D',
    			'amount' => $data['b_jumlah_angsuran'],
    			'reference_no' =>$data['referensi'],
    			'trx_date' => $data['trx_date'],
    			'created_by' => $this->session->userdata('user_id'),
    			'created_date' => date('Y-m-d H:i:s')
    		);

		// insert mfi_trx_account_financing
		$ins_data = array(
				'trx_account_financing_id' => $data['b_trx_account_financing_id'],
				'branch_id' => $this->session->userdata('branch_id'),
				'trx_detail_id' => $data['b_trx_detail_id'],
				'account_financing_no' => $data['b_account_financing_no'],
				'trx_financing_type' => $data['b_trx_account_type'],
				'trx_date' => $data['trx_date'],
				'jto_date' => $data['b_jtempo_angsuran_next'],
				'pokok' => $data['b_angsuran_pokok'],
				'margin' =>$data['b_angsuran_margin'],
				'catab' =>'0',
				'reference_no' =>$data['referensi'],
				'seq' =>$data['seq'],
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id'),
				'freq' => 1,
				'trx_status' => 1,
				'verify_by' => $this->session->userdata('user_id'),
				'verify_date' => date('Y-m-d H:i:s'),
				'description' => 'PEMBAYARAN ANGSURAN Rek.'.$data['b_account_financing_no'],
				'account_cash_code'=>$data['akun'],
				'angsuran_ke'=>$data['b_new_counter_angsuran'],
				'tipe_angsuran'=>'2'
			);

		$return = array(
				'ins_data_trx'=>$ins_data_trx,
				'ins_data'=>$ins_data
			);
		return $return;
	}

	public function verifikasi_pendebetan_angsuran_pembiayaan_koptel()
	{
		// $debug = true; // debug aktif
		$debug = false; // debug non aktif
		$nik = $this->input->post('nik');
		$filename = $this->input->post('filename');
		$akun = $this->input->post('akun');
		$referensi = $this->input->post('referensi');
		$seq = $this->input->post('seq');
		$angsuran_id = $filename;
		date_default_timezone_set('Asia/Jakarta');
		$trx_date = $this->datepicker_convert(true,$this->input->post('trx_date'),'/');
		$ins_data = array();
		$ins_data_trx = array();

		$this->db->trans_begin();

		/* get angsuran */
		$angsurans = $this->model_transaction->get_angsuran_temp_by_id($angsuran_id);
		for ($i = 0 ;$i < count($angsurans) ; $i++)
		{
			$angsuran = $angsurans[$i];
			$a_account_financing_no = $angsuran['account_financing_no'];
			$a_jumlah_angsuran = $angsuran['pokok']+$angsuran['margin'];

			$data_financing = $this->model_transaction->get_account_financing_by_account($a_account_financing_no,$a_jumlah_angsuran);
			if ($angsuran['pokok'] > 0 || $angsuran['margin']>0)
			{
				$b_account_financing_no = $angsuran['account_financing_no'];
				$b_angsuran_pokok = $angsuran['pokok'];
				$b_angsuran_margin = $angsuran['margin'];
				$b_jtempo_angsuran_last = $data_financing['jto_last'];
				$b_jtempo_angsuran_next = $data_financing['jto_next'];
				$b_jangka_waktu = $data_financing['jangka_waktu'];
				$b_counter_angsuran = $data_financing['counter_angsuran'];
				$b_saldo_pokok = $data_financing['saldo_pokok'];
				$b_saldo_margin = $data_financing['saldo_margin'];
				$b_flag_jadwal_angsuran = $data_financing['flag_jadwal_angsuran'];
				$b_periode_jangka_waktu = $data_financing['periode_jangka_waktu'];
				$b_tanggal_jtempo = $data_financing['tanggal_jtempo'];

				// generate uuid for history
	    		$b_trx_detail_id = uuid(false);
		    	$b_trx_account_financing_id = uuid(false);

		    	// new declare
				$b_jumlah_angsuran = $b_angsuran_pokok+$b_angsuran_margin;
				// $b_new_counter_angsuran = $b_counter_angsuran+1;
				$b_new_counter_angsuran = $b_counter_angsuran;
				$b_trx_type = 3;
				$b_trx_account_type = 1;
				$is_pelunasan = false;
				$jtempo_angsuran_next = $b_jtempo_angsuran_next;

				if ($b_flag_jadwal_angsuran==1) {
					if($b_periode_jangka_waktu==0){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 days'));
					}else if($b_periode_jangka_waktu==1){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 weeks'));
					}else if($b_periode_jangka_waktu==2){
						$jtempo_angsuran_next = date("Y-m-d",strtotime($jtempo_angsuran_next.' +1 month'));
					}
					if($b_jangka_waktu==$b_new_counter_angsuran) {
						$jtempo_angsuran_next = $b_tanggal_jtempo;
					}
				} else {
					if($b_jangka_waktu==$b_new_counter_angsuran) {
						$jtempo_angsuran_next = $b_tanggal_jtempo;
					} else {
						$jtempo_angsuran_next = $data_financing['jto_next2'];
					}
				}

				// collect array for angsuran
		    	// if this angsuran is pelunasan then this condition will not run
		    	// else will insert to trx_detail and trx_account_financing
		    	if ($b_new_counter_angsuran!=$b_jangka_waktu) {
		    		$data_trx = array(
							 'b_trx_detail_id' => $b_trx_detail_id
							,'b_trx_type' => $b_trx_type
							,'b_trx_account_type' => $b_trx_account_type
							,'b_account_financing_no' => $b_account_financing_no
							,'b_jumlah_angsuran' => $b_jumlah_angsuran
							,'b_trx_account_financing_id' => $b_trx_account_financing_id
							,'trx_date' => $trx_date
							// ,'b_jtempo_angsuran_next' => $b_jtempo_angsuran_last
							,'b_jtempo_angsuran_next' => $b_jtempo_angsuran_next
							,'b_angsuran_pokok' => $b_angsuran_pokok
							,'b_angsuran_margin' => $b_angsuran_margin
							,'referensi' => $referensi
							,'seq' => $seq
							,'akun' => $akun
							,'b_new_counter_angsuran' => $b_new_counter_angsuran
		    			);

		    		$ins = $this->get_trx_angsuran_data($data_trx);
		    		$ins_data_trx[] = $ins['ins_data_trx'];
		    		$ins_data[] = $ins['ins_data'];
				} else {
		    		$is_pelunasan = true;
				}

				if ($is_pelunasan) {
					$jtempo_angsuran_next = $b_tanggal_jtempo;
				}

				// update saldo account pembiayaan
				$pembiayaan = array(
					'saldo_pokok'=>$b_saldo_pokok-$b_angsuran_pokok,
					'saldo_margin'=>$b_saldo_margin-$b_angsuran_margin,
					'jtempo_angsuran_last'=>$b_jtempo_angsuran_next,
					'jtempo_angsuran_next'=>$jtempo_angsuran_next,
					'counter_angsuran'=>$b_new_counter_angsuran
				);

				// begin
				// do this section if flag_jadwal_angsuran = non reguler ( 0 )
				$param_pembiayaan_schedulle=array();
				$pembiayaan_schedulle=array();
				if ($b_flag_jadwal_angsuran==0){
					$param_pembiayaan_schedulle = array(
						'account_no_financing'=>$b_account_financing_no
						,'tangga_jtempo'=>$b_jtempo_angsuran_next
					);
					$pembiayaan_schedulle = array(
							'status_angsuran'=>1,
							'tanggal_bayar'=>$trx_date,
							'bayar_pokok'=>$b_angsuran_pokok,
							'bayar_margin'=>$b_angsuran_margin
						);
				}
				// end 

				if ($is_pelunasan) {
					$pembiayaan['status_rekening'] = 2;

					$pembiayaan_lunas = array(
							'account_financing_lunas_id'=>$b_trx_account_financing_id,
							'account_financing_no'=>$b_account_financing_no,
							'saldo_pokok'=>$b_saldo_pokok,
							'saldo_margin'=>$b_saldo_margin,
							'potongan_margin'=>0,
							'status_pelunasan'=>1,
							'tanggal_lunas'=>$trx_date,
							'create_by'=>$this->session->userdata('user_id'),
							'created_date'=>date('Y-m-d H:i:s'),
							'verify_by'=>$this->session->userdata('user_id'),
							'verifiy_date'=>date('Y-m-d H:i:s'),
							'saldo_catab'=>0
						);

					$trx_pembiayaan_lunas = array(
							'trx_account_financing_id'=>$b_trx_account_financing_id
							,'branch_id' => $this->session->userdata('branch_id')
							,'trx_detail_id' => $b_trx_detail_id
							,'account_financing_no' => $b_account_financing_no
							,'trx_financing_type' => '2'
							,'trx_date' => $trx_date
							,'jto_date' => $b_jtempo_angsuran_next
							,'pokok' => $b_saldo_pokok
							,'margin' => $b_saldo_margin
							,'catab' => '0'
							,'description' => 'PELUNASAN PEMBIAYAAN Rek.'.$b_account_financing_no
							,'created_date' => date('Y-m-d H:i:s')
							,'created_by' => $this->session->userdata('user_id')
							,'verify_by' => $this->session->userdata('user_id')
							,'verify_date' => date('Y-m-d H:i:s')
							,'trx_status' => 1
							,'freq' => 1
							,'angsuran_ke' => $b_jangka_waktu
							,'account_cash_code'=>$akun
							,'tipe_angsuran'=>'2'
						);

					$trx_detail = array(
							'trx_detail_id' => $b_trx_detail_id
							,'trx_type' => '2'
							,'trx_account_type' => '3'
							,'account_no' => $b_account_financing_no
							,'flag_debit_credit' => 'C'
							,'amount' => ($b_saldo_pokok+$b_saldo_margin)
							,'trx_date' => $trx_date
							,'description' => 'PELUNASAN PEMBIAYAAN Rek.'.$b_account_financing_no
							,'created_date' => date('Y-m-d H:i:s')
							,'created_by' => $this->session->userdata('user_id')
						);

					if ($debug==true) {
						echo 'Pelunasan-------------------------------------<br>';
						echo "<pre>";
						print_r($pembiayaan_lunas);
						print_r($trx_detail);
						print_r($trx_pembiayaan_lunas);
					} else {
						$this->model_transaction->insert_account_financing_lunas($pembiayaan_lunas);
						$this->model_transaction->insert_trx_detail($trx_detail);
						$this->model_transaction->insert_trx_account_financing($trx_pembiayaan_lunas);
					}

				}
				// end check of if pelunasan

				$param_pembiayaan = array('account_financing_no'=>$b_account_financing_no);

				if ($debug==true) {
					echo 'ANGSURAN NORMAL '.$i.' -------------------------------------<br>';
					echo "<pre>";
					print_r($pembiayaan);
					print_r($param_pembiayaan);
					print_r($pembiayaan_schedulle);
				} else {
					$this->model_transaction->update_account_financing($pembiayaan,$param_pembiayaan);
					if (count($pembiayaan_schedulle)>0) {
						$this->model_transaction->update_account_financing_schedulle($pembiayaan_schedulle,$param_pembiayaan_schedulle);
					}
				}
			}
		}

		$log_payed_data = $this->model_transaction->get_log_payed_data($angsuran_id,$trx_date);
		if ($debug==true) {
			echo "<pre>";
			print_r($ins_data);
			print_r($ins_data_trx);
			die();
		} else {
			if(count($ins_data)>0){
				$this->model_transaction->insert_angsuran_into_mfi_trx_financing($ins_data);
			}
			if(count($ins_data_trx)>0){
				$this->model_transaction->insert_angsuran_into_trx_detail($ins_data_trx);
			}
			if(count($log_payed_data)>0){
				$this->model_transaction->insert_log_trx_pendebetan($log_payed_data);
			}
		}

		if ($debug==true) {
			echo "<pre>";
			print_r($angsuran_id);
			print_r($akun);
			print_r($referensi);
			print_r($param_temp);
			// print_r($param_temp_detail);
			die();
		} else {
			$this->model_transaction->fn_proses_jurnal_angsuran_pyd_koptel($angsuran_id,$akun,$referensi); // proses jurnal transaksi pembiayaan
			// $this->model_transaction->delete_from_mfi_angsuran_temp_detail_unins($param_temp_detail);
			$this->db->update('mfi_angsuran_temp',array('status'=>2),array('angsuran_id'=>$angsuran_id));

			$check_tab = $this->model_transaction->get_mfi_angsuran_temp_tab($angsuran_id);
			if($check_tab->num_rows() > 0)
			{
				foreach($check_tab->result_array() as $list){
					$arrdata = json_decode($list['data'], true);
					$this->add_setoran_tunai($arrdata);
				}
			}

			$this->db->update('mfi_angsuran_temp_tab',array('status'=>1),array('angsuran_id'=>$angsuran_id));
		}

		if($this->db->trans_status()==true){
			$this->db->trans_commit();

			$this->db->query("UPDATE mfi_trx_account_financing SET seq='$seq', reference_no='$no_ref' WHERE trx_account_financing_id='$id_transaksi'");

			$return = array('success'=>true,'trx_date'=>$trx_date);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function download_transaction_debeted()
	{
		$angsuran_id = $this->uri->segment(3);
		$trx_date = $this->uri->segment(4);
		$log_payed_data = $this->model_transaction->get_log_payed_data($angsuran_id,$trx_date);

		$this->db->trans_begin();
		if(count($log_payed_data)>0){
			$this->model_transaction->insert_log_trx_pendebetan($log_payed_data);
		}
		if($this->db->trans_status()==true){
			$this->db->trans_commit();
		}else{
			$this->db->trans_rollback();
		}
		redirect('transaction/export_log_trx_pendebetan/'.$trx_date.'/'.$angsuran_id);
	}
	/*
	| END VERIFIKASI PENDEBETAN ANGSURAN
	*/

	/*
	| BEGIN UPLOAD TWP. Ade Sagita 01-07-2015
	*/
	function setoran_twp()
	{
		$data['container'] = 'transaction/upload_setor_twp';
		$data['title'] = "Upload Setoran Tabungan TWP";
		$this->load->view('core',$data);
	}

	function do_upload_setoran_twp_csvfile()
	{
		ini_set('memory_limit', '-1');
		$date = date('Y-m-d H:i:s');
		$name = $_FILES['userfile']['name'];
		$type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$error = $_FILES['userfile']['error'];
		$size = $_FILES['userfile']['size'];
		$trx_date = $this->datepicker_convert($this->input->post('trx_date'));

		if (isset($_FILES['userfile'])) {

			// dir
			$filename = date('YmdHis').'.csv';
			$dir = './assets/data_setoran_twp/'.$filename;
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dir)) {
				if (($handle = fopen($dir, "r")) !== FALSE) {
					
					$row = array();
					$trx_id = uuid(false);
					$created_date = date("Y-m-d H:i:s");
					$created_by = $this->session->userdata('user_id');
					$no=1;
				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				    	if ($no>1) {
					        $num = count($data);
					        if ($num==2) {
					        	$cif_no = $data[0];
					        	$amount = $data[1];

					        	// $account_saving_no = $this->model_transaction->get_account_twp_by_cif($cif_no);
					        	$account_saving_no = '10000'.$cif_no.'0100';
								$row[] = array(
									 'account_saving_no' => $account_saving_no
									,'amount' 			 => $amount
									,'description' 		 => 'Upload TWP : '.date("d M Y")
									,'trx_date' 		 => $trx_date
									,'trx_id' 	 		 => substr('twp'.$trx_id,0,32)
									,'flag_debit_credit' => 'C'
									,'created_date'		 => $created_date
									,'created_by' 		 => $created_by
									,'trx_saving_type'	 => 1
									,'nik' 			 	 => trim($cif_no)
								);
					        }
					    }
				        $no++;
				    }

				    fclose($handle);

				    // echo "<pre>";
				    // print_r($row);
				    // die();
				    if (count($row)>0) {
						$this->db->trans_begin();
						$this->db->insert_batch('mfi_temp_twp',$row);
						if ($this->db->trans_status()===TRUE) {
							$this->db->trans_commit();
							$return = array('success'=>true);
						} else {
							$this->db->trans_rollback();
							$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
						}
					} else {
						$return = array('success'=>false,'error'=>'Trx in Resource File is Empty, Please Check Your File.');
					}
				}

			} else {
				$return = array('success'=>false,'error'=>'Upload Failed!');
			}

		} else {
			$return = array('success'=>false,'error'=>'Upload Failed!');
		}

		echo json_encode($return);
	}

	function do_upload_setoran_twp()
	{
		ini_set('memory_limit', '-1');
		$this->load->library('phpexcel');
		$date = date('Y-m-d H:i:s');
		$name = $_FILES['userfile']['name'];
		$type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$error = $_FILES['userfile']['error'];
		$size = $_FILES['userfile']['size'];
		$trx_date = $this->datepicker_convert(true,$this->input->post('trx_date'),'/');
		$deskripsi = $this->input->post('deskripsi');
		$product_code = $this->input->post('product_code');

		if (isset($_FILES['userfile'])) {

			switch ($type) {
				case 'application/msexcel':
				case 'application/vnd.ms-excel':
				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

				if ($size>100000000000) {

					$return = array('success'=>false,'error'=>'file size must be less than 100Mb');

				} else {

					try {
						$objPHPExcel = PHPExcel_IOFactory::load($tmp_name);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$file_exists = true;
					} catch (Exception $e) {
						$file_exists = false;
					}

					if ($file_exists) {

						$getHighestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

						// if ($getHighestColumn!='D') {

						// 	$return = array('success'=>false,'error'=>'Invalid Format of Column. File cant be process.');

						// } else {

							/*set time limit*/
							// set_time_limit(3600);

							$row = array();
							$i=0;
							$error_flag=0;
							$created_date = date("Y-m-d H:i:s");
							$created_by = $this->session->userdata('user_id');
							$trx_id = uuid(false);
							$code_twp = $this->model_transaction->select_code_twp();
							foreach ($sheetData as $data) {

								if ($i>0) {
									// if(strlen(preg_replace('/[^0-9]/', '', $data['A']))==6){

										$cif_no = $data['A'];
										// $account_saving_no = $this->model_transaction->get_account_twp_by_cif($cif_no);

										if($product_code=='01'){
											$saldo_twp_rev = $data['D'];
											$saldo_tdpk_rev = 0;
											$productcode = '01';
										}else if($product_code=='03'){
											$saldo_twp_rev = 0;
											$saldo_tdpk_rev = $data['D'];
											$productcode = '03';
										}else{
											$saldo_twp_rev = 0;
											$saldo_tdpk_rev = 0;
											$productcode = '01';
										}

										$row[] = array(
											 // 'account_saving_no' => $account_saving_no
											'amount' 			 => $data['C']
											,'description' 		 => $deskripsi
											,'trx_date' 		 => $trx_date
											,'trx_id' 	 		 => substr('twp'.$trx_id,0,32)
											,'flag_debit_credit' => 'C'
											,'created_date'		 => $created_date
											,'created_by' 		 => $created_by
											,'trx_saving_type'	 => 1
											,'nik' 			 	 => trim($cif_no)
											,'saldo_twp_rev' 	 => $saldo_twp_rev
											,'saldo_tdpk_rev' 	 => $saldo_tdpk_rev
											,'product_code' 	 => $productcode
										);
									// }

									// $row[] = array(
									// 	 'account_saving_no' => '10000'.preg_replace('/[^0-9]/', '', $data['A']).'0101' //depan dan belakang dibuat statis dahulu
									// 	,'branch_id' 	 	 => '2c078d4f884446d8af5ed2b5d7633c5c'
									// 	,'trx_saving_type' 	 => '1'
									// 	,'flag_debit_credit' => 'C'
									// 	,'amount' 			 => $data['B']
									// 	,'description' 		 => 'TWP bulan : '.date("M Y")
									// 	,'trx_date' 		 => $data['C']
									// 	,'created_date'		 => $created_date
									// 	,'trx_status' 		 => '0'
									// 	,'created_by' 		 => $created_by
									// 	,'trx_id' 	 => substr('twp'.$trx_id,0,32)
									// );

									// if(preg_replace('/[^a-z0-9_\-\.]/i', '', $data['D'])!="C"){
									// 	$error_flag++;
									// }

								}

								$i++;

							}

							// print_r($row);
							// die();
							if($error_flag==0){
								$this->db->trans_begin();
								if (count($row)>0) $this->db->insert_batch('mfi_temp_twp',$row);
								if ($this->db->trans_status()===TRUE) {
									$this->db->trans_commit();
									$return = array('success'=>true);
								} else {
									$this->db->trans_rollback();
									$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
								}
							}else{
									$return = array('success'=>false,'error'=>'Invalid Format of Column. Flags are not "C". File cant be process.');
							}

						// } //else $getHighestColumn!='D'

					} else {

						$return = array('success'=>false,'error'=>'File does not exist. maybe permission to the path of file is denied');

					}

				}

				break;
				
				default:
				$return = array('success'=>false,'error'=>'wrong file type. file type should use the extension .xls and .xlsx only');
				break;
			}

		} else {

			$return = array('success'=>false,'error'=>'no selected file.');

		}

		echo json_encode($return);
	}

	function verifikasi_twp()
	{
		$data['container'] = 'transaction/verifikasi_upload_twp';
		$data['title'] = "Verifikasi Upload TWP";
		$data['cashs'] = $this->model_transaction->get_data_akun();
		$this->load->view('core',$data);
	}

	public function datatable_upload_twp()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('description','jumlah','trx_id','created_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_upload_twp($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_upload_twp($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_upload_twp(); // get number of all data
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
			if($aRow['jumlah']>0){
				$link = '<div align="center"><a href="javascript:;" class="btn mini purple" trx_id="'.$aRow['trx_id'].'" deskripsi="'.$aRow['description'].'" id="link-approve"><i class="icon-check"></i> Verifikasi</a> 
						<a href="javascript:;" class="btn mini red" trx_id="'.$aRow['trx_id'].'" id="link-delete"><i class="icon-trash"></i> Reject</a>
						<a href="javascript:;" class="btn mini blue" trx_id="'.$aRow['trx_id'].'" id="link-view"><i class="icon-search"></i> Preview</a></div>';
			}else{
				$link = '';
			}

			$row = array();
			$row[] = $aRow['description'];
			$row[] = number_format($aRow['jumlah']);
			$row[] = date("d-m-Y H:i:s",strtotime($aRow['created_date']));
			$row[] = $this->model_transaction->get_user_by_id($aRow['created_by']);
			$row[] = $link;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}	

	public function do_verifikasi_twp()
	{
		ini_set('memory_limit', '-1');
		$trx_id = $this->input->post('trx_id');
		$account_cash_code = $this->input->post('account_cash_code');
		// $no_referensi = $this->input->post('no_referensi');
		$deskripsi = $this->input->post('deskripsi');

		$sql = "
				SELECT X.seq FROM ((SELECT seq FROM mfi_trx_account_saving ORDER BY seq DESC LIMIT 1)
				UNION ALL
				(SELECT seq FROM mfi_trx_account_financing ORDER BY seq DESC LIMIT 1)) AS X ORDER BY seq DESC LIMIT 1";

		$seql = $this->db->query($sql)->row();
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$periode_awal = $kontrol_periode['periode_awal'];

		$seq = $seql->seq+1;
		$M = strtoupper(date('M',strtotime($periode_awal)));
        $seqs = str_pad($seq, 6, '0', STR_PAD_LEFT);
        $no_referensi =  $seqs.'/'.$M;

		$this->db->trans_begin();
		$this->model_transaction->do_verifikasi_twp($trx_id,$account_cash_code,$no_referensi,$deskripsi,$seq);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function do_delete_verifikasi_twp()
	{
		$trx_id = $this->input->post('trx_id');

		$param = array('trx_id'=>$trx_id);

		$this->db->trans_begin();
		$this->model_transaction->do_delete_verifikasi_twp($param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function penarikan_twp()
	{
		$data['container'] = 'transaction/upload_penarikan_twp';
		$data['title'] = "Upload Penarikan Tabungan TWP";
		$this->load->view('core',$data);
	}

	function do_upload_penarikan_twp()
	{
		$this->load->library('phpexcel');
		$date = date('Y-m-d H:i:s');
		$name = $_FILES['userfile']['name'];
		$type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$error = $_FILES['userfile']['error'];
		$size = $_FILES['userfile']['size'];
		$trx_date = $this->datepicker_convert(true,$this->input->post('trx_date'),'/');
		$deskripsi = $this->input->post('deskripsi');

		if (isset($_FILES['userfile'])) {

			switch ($type) {
				case 'application/msexcel':
				case 'application/vnd.ms-excel':
				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

				if ($size>100000000000) {

					$return = array('success'=>false,'error'=>'file size must be less than 100Mb');

				} else {

					try {
						$objPHPExcel = PHPExcel_IOFactory::load($tmp_name);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$file_exists = true;
					} catch (Exception $e) {
						$file_exists = false;
					}

					if ($file_exists) {

						$getHighestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

						// if ($getHighestColumn!='D') {

						// 	$return = array('success'=>false,'error'=>'Invalid Format of Column. File cant be process.');

						// } else {

							/*set time limit*/
							// set_time_limit(3600);

							$row = array();
							$i=0;
							$error_flag=0;
							$created_date = date("Y-m-d H:i:s");
							$created_by = $this->session->userdata('user_id');
							$trx_id = uuid(false);
							$code_twp = $this->model_transaction->select_code_twp();
							foreach ($sheetData as $data) {

								if ($i>0) {
									// if(strlen(preg_replace('/[^0-9]/', '', $data['A']))==6){
										$row[] = array(
											 // 'account_saving_no' => '10000'.preg_replace('/[^0-9]/', '', $data['A']).$code_twp.'01' //depan dan belakang dibuat statis dahulu
											// ,'amount' 			 => $data['B']
											'description' 		 => $deskripsi
											,'trx_date' 		 => $trx_date
											,'trx_id' 	 		 => substr('twp'.$trx_id,0,32)
											,'flag_debit_credit' => 'D'
											,'created_date'		 => $created_date
											,'created_by' 		 => $created_by
											,'trx_saving_type'	 => 2
											,'nik' 			 	 => trim($data['A'])
										);
									// }

									// $row[] = array(
									// 	 'account_saving_no' => '10000'.preg_replace('/[^0-9]/', '', $data['A']).'0101' //depan dan belakang dibuat statis dahulu
									// 	,'branch_id' 	 	 => '2c078d4f884446d8af5ed2b5d7633c5c'
									// 	,'trx_saving_type' 	 => '2'
									// 	,'flag_debit_credit' => 'D'
									// 	,'amount' 			 => $data['B']
									// 	,'description' 		 => 'Penarikan TWP bulan : '.date("M Y")
									// 	,'trx_date' 		 => $data['C']
									// 	,'created_date'		 => $created_date
									// 	,'trx_status' 		 => '0'
									// 	,'created_by' 		 => $created_by
									// 	,'trx_id' 	 => substr('twp'.$trx_id,0,32)
									// );

									// if(preg_replace('/[^a-z0-9_\-\.]/i', '', $data['D'])!="D"){
									// 	$error_flag++;
									// }

								}

								$i++;

							}

							// print_r($row);
							// die();
							if($error_flag==0){
								$this->db->trans_begin();
								if (count($row)>0) $this->db->insert_batch('mfi_temp_twp',$row);
								if ($this->db->trans_status()===TRUE) {
									$this->db->trans_commit();
									$return = array('success'=>true);
								} else {
									$this->db->trans_rollback();
									$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
								}
							}else{
									$return = array('success'=>false,'error'=>'Invalid Format of Column. Flags are not "D". File cant be process.');
							}

						// } //$getHighestColumn!='D'

					} else {

						$return = array('success'=>false,'error'=>'File does not exist. maybe permission to the path of file is denied');

					}

				}

				break;
				
				default:
				$return = array('success'=>false,'error'=>'wrong file type. file type should use the extension .xls and .xlsx only');
				break;
			}

		} else {

			$return = array('success'=>false,'error'=>'no selected file.');

		}

		echo json_encode($return);
	}

	function verifikasi_penarikan_twp()
	{
		$data['container'] = 'transaction/verifikasi_penarikan_upload_twp';
		$data['title'] = "Verifikasi Penarikan TWP";
		$data['cashs'] = $this->model_transaction->get_data_akun();
		$this->load->view('core',$data);
	}

	public function datatable_upload_penarikan_twp()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('description','jumlah','trx_id','created_date','');
				
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

		$rResult 			= $this->model_transaction->datatable_upload_penarikan_twp($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_transaction->datatable_upload_penarikan_twp($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_transaction->datatable_upload_penarikan_twp(); // get number of all data
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
			$row[] = $aRow['description'];
			$row[] = $aRow['jumlah'].' Rekening';
			$row[] = date("d-m-Y H:i:s",strtotime($aRow['created_date']));
			$row[] = $this->model_transaction->get_user_by_id($aRow['created_by']);
			$row[] = '<div align="center"><a href="javascript:;" class="btn mini purple" trx_id="'.$aRow['trx_id'].'" id="link-approve"><i class="icon-check"></i> Verifikasi</a> 
						<a href="javascript:;" class="btn mini red" trx_id="'.$aRow['trx_id'].'" id="link-delete"><i class="icon-trash"></i> Reject</a>
						<a href="javascript:;" class="btn mini blue" trx_id="'.$aRow['trx_id'].'" id="link-view"><i class="icon-search"></i> Preview</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}	

	function do_reject_verifikasi_pendebetan_angsuran_koptel()
	{
		$angsuran_id = $this->input->post('namafile');
		// $angsuran_id = $this->model_transaction->get_angsuran_id_by_namafile($namafile);
		// print_r($_POST);

		if ($angsuran_id=='') {
			$return = array('success'=>false,'message'=>'Undefined Angsuran ID, please contact your administrator.');
		} else {
			$param = array('angsuran_id'=>$angsuran_id);

			$this->db->trans_begin();
			$this->db->delete('mfi_angsuran_temp_detail_unins',$param);
			$this->db->delete('mfi_angsuran_temp_detail',$param);
			$this->db->delete('mfi_angsuran_temp',$param);
			$this->db->delete('mfi_angsuran_bayar',$param);
			$this->db->update('mfi_angsuran_temp_tab',array('status'=>2),array('angsuran_id'=>$angsuran_id));

			if ($this->db->trans_status()==true) {
				$return = array('success'=>true);
				$this->db->trans_commit();
			} else {
				$return = array('success'=>false,'message'=>'Failed to connect into databases. please check your connection.');
				$this->db->trans_rollback();
			}
		}
		echo json_encode($return);
	}

	public function do_verifikasi_penarikan_twp()
	{
		$trx_id = $this->input->post('trx_id');
		$account_cash_code = $this->input->post('account_cash_code');
		$no_referensi = $this->input->post('no_referensi');

		$this->db->trans_begin();
		$this->model_transaction->do_verifikasi_penarikan_twp($trx_id,$account_cash_code,$no_referensi);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();

			$sql = "SELECT count(*) num from mfi_temp_twp WHERE status in('1','2') AND trx_id=? ";
			$query = $this->db->query($sql,array($trx_id));
			$row = $query->row_array();

			$return = array('success'=>true,'unprocessed'=>$row['num']);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function do_delete_verifikasi_penarikan_twp()
	{
		$trx_id = $this->input->post('trx_id');

		$param = array('trx_id'=>$trx_id, 'status'=>'2');

		$this->db->trans_begin();
		$this->model_transaction->do_delete_verifikasi_penarikan_twp($param);
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
	| END UPLOAD TWP. Ade Sagita 01-07-2015
	*/

	public function get_list_saldo()
	{
		$nik = $this->input->post('nik');
		$data = $this->model_transaction->get_list_saldo($nik);
		echo json_encode($data);
	}

	public function get_list_saldo_v2()
	{
		$nik = $this->input->post('nik');
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_list_saldo($nik,$account_financing_no);
		echo json_encode($data);
	}

	public function get_akad_pembiayaan()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_akad_pembiayaan($account_financing_no);
		echo json_encode($data);
	}

	public function get_list_saldo_lunas()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_list_saldo_lunas($cif_no);
		echo json_encode($data);
	}

	public function get_cif_pengajuan_pelunasan()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_cif_pengajuan_pelunasan($account_financing_no);
		echo json_encode($data);
	}

	public function get_cif_pengajuan_pelunasan_reguler()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_cif_pengajuan_pelunasan_reguler($account_financing_no);
		echo json_encode($data);
	}

	public function proses_pengajuan_pengurangan()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$potongan_margin = $this->convert_numeric($this->input->post('potongan_margin'));
		$nik = $this->input->post('nik');
		$nama = $this->input->post('nama');
		$produk = $this->input->post('produk');
		$nilai_pembiayaan = $this->convert_numeric($this->input->post('nilai_pembiayaan'));
		$tanggal_kontrak = $this->input->post('tanggal_kontrak');
		$tanggal_bayar_terakhir = $this->input->post('tanggal_bayar_terakhir');
		$v_tanggal_kontrak = substr("$tanggal_kontrak",0,2);
	    $v_tanggal_kontrak = substr("$tanggal_kontrak",3,2);
	    $v_tanggal_kontrak = substr("$tanggal_kontrak",6,4);
	    $vakhir_tanggal_kontrak = "$v_tanggal_kontrak-$v_tanggal_kontrak-$v_tanggal_kontrak"; 

		$v_tanggal_bayar_terakhir = substr("$tanggal_bayar_terakhir",0,2);
	    $v_tanggal_bayar_terakhir = substr("$tanggal_bayar_terakhir",3,2);
	    $v_tanggal_bayar_terakhir = substr("$tanggal_bayar_terakhir",6,4);
	    $vakhir_tanggal_bayar_terakhir = "$v_tanggal_bayar_terakhir-$v_tanggal_bayar_terakhir-$v_tanggal_bayar_terakhir";  
		$saldo_pokok = $this->convert_numeric($this->input->post('saldo_pokok'));
		$saldo_margin = $this->convert_numeric($this->input->post('saldo_margin'));
		$angsuran_pokok = $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin = $this->convert_numeric($this->input->post('angsuran_margin'));
		$total_pengajuan_pengurangan_hutang = $this->convert_numeric($this->input->post('total_pengajuan_pengurangan_hutang'));
		$jumlah_pengurangan_pokok = $this->convert_numeric($this->input->post('jumlah_pengurangan_pokok'));
		$jumlah_pengurangan_margin = $this->convert_numeric($this->input->post('jumlah_pengurangan_margin'));
		$jumlah_pembayaran = $this->convert_numeric($this->input->post('jumlah_pembayaran'));
		$account_cash_code = $this->input->post('account_cash_code');
		$tgl_bayar = $this->input->post('tgl_bayar');
		$counter_angsuran = $this->input->post('counter_angsuran');
		$jumlah_pembayaran = $this->convert_numeric($this->input->post('jumlah_pembayaran'));
		$bayar_pokok_before = $this->convert_numeric($this->input->post('bayar_pokok_before'));
		$bayar_margin_before = $this->convert_numeric($this->input->post('bayar_margin_before'));
		$bayar_pokok = $this->convert_numeric($this->input->post('bayar_pokok'));
		$bayar_margin = $this->convert_numeric($this->input->post('bayar_margin'));

		$v_tgl_bayar = substr("$tgl_bayar",0,2);
	    $v_tgl_bayar = substr("$tgl_bayar",3,2);
	    $v_tgl_bayar = substr("$tgl_bayar",6,4);
	    $vakhir_tgl_bayar = "$v_tgl_bayar-$v_tgl_bayar-$v_tgl_bayar";  

		$data = array(
			 'account_financing_no' =>$account_financing_no
			,'saldo_pokok' =>$saldo_pokok
			,'saldo_margin' =>$saldo_margin
			,'bayar_freq' =>$counter_angsuran
			,'bayar_pokok' =>($bayar_pokok_before+$bayar_pokok)
			,'bayar_margin'	=>($bayar_margin_before+$bayar_margin)
			,'created_date' =>date("Y-m-d")
			,'created_by' =>$this->session->userdata('user_id')
			,'status' =>'0'
			,'potongan_margin' =>$potongan_margin
			,'pengajuan_pengurangan' =>$total_pengajuan_pengurangan_hutang
		);

		// echo "<pre>";
		// print_r($data);
		// die();

		$this->db->trans_begin();
		$this->db->insert('mfi_account_financing_lunas_part',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_list_saldo_lunas_reg()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_transaction->get_list_saldo_lunas_reg($cif_no);
		echo json_encode($data);
	}

	function do_check_verifikasi_pendebetan_angsuran_koptel()
	{
		$angsuran_id = $this->input->post('namafile');
		// $angsuran_id = $this->model_transaction->get_angsuran_id_by_namafile($namafile);
		// print_r($_POST);

		if ($angsuran_id=='') {
			$return = array('success'=>false,'message'=>'Undefined Angsuran ID, please contact your administrator.');
		} else {
			$data = array('status'=>3);
			$param = array('angsuran_id'=>$angsuran_id);

			$this->db->trans_begin();
			$this->model_transaction->update_mfi_angsuran_temp($data,$param);
			if ($this->db->trans_status()==true) {
				$return = array('success'=>true);
				$this->db->trans_commit();
			} else {
				$return = array('success'=>false,'message'=>'Failed to connect into databases. please check your connection.');
				$this->db->trans_rollback();
			}
		}
		echo json_encode($return);
	}

	public function jqgrid_angsuran_temp()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'import_date';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		// $filename = isset($_REQUEST['filename'])?$_REQUEST['filename']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->jqgrid_angsuran_temp('','','','');

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->jqgrid_angsuran_temp($sidx,$sord,$limit_rows,$start);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			switch ($row['status']) {
				case '3': $status = '<span style="color:green">Checked</span>';
					break;				
				default: $status = 'Unchecked';
					break;
			}
			$responce['rows'][$i]['angsuran_id'] = $row['angsuran_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['angsuran_id']
				,$row['file_name']
				,$row['import_date']
				,$row['fullname']
				,$row['file_client_name']
				,$row['file_ext']
				,$row['file_type']
				,$row['keterangan']
				,$row['status']
				,$row['trx_date']
				,date('d-m-Y',strtotime($row['trx_date']))
				,$status
			);
			$i++;
		}

		echo json_encode($responce);
	}

	/* [NEW] 2016-03-21 
	*  PEMBAYARAN ANGSURAN
	*/

	public function pembayaran_angsuran_pokok()
	{
		$data['container'] = 'transaction/pembayaran_angsuran_pokok';
		$data['account_cash'] = $this->model_transaction->get_account_cash();
		$this->load->view('core',$data);
	}

	function get_data_pembayaran_angsuran_pokok()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_transaction->get_data_pembayaran_angsuran_pokok($account_financing_no);
		echo json_encode($data);
	}
	function validate_frekuensi_pembayaran_pokok()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$nominal_pembayaran = $this->input->post('nominal_pembayaran');
		$nominal_pembayaran = $this->convert_numeric($nominal_pembayaran);

		// get flag jadwal angsuran
		// 1 untuk reguler, 0 untuk non reguler
		$flag_jadwal_angsuran = $this->model_transaction->get_flag_jadwal_angsuran_v2($account_financing_no);

		if ( $flag_jadwal_angsuran == '0' )
		{
			$schedulles = $this->model_transaction->get_account_financing_schedulle($account_financing_no);

			$angsuran_pokok = 0;
			$total_angsuran_pokok = 0;
			$frekuensi = 0;
			for ( $i = 0 ; $i < count($schedulles) ; $i++ )
			{
				$angsuran_pokok += $schedulles[$i]['angsuran_pokok'];

				if ($angsuran_pokok>$nominal_pembayaran) {
					break;
				} else {
					$total_angsuran_pokok += $schedulles[$i]['angsuran_pokok'];
					$frekuensi++;
				}
			}

			// now total_angsuran_pokok didapatkan
			if ( $nominal_pembayaran == $total_angsuran_pokok )
			{
				$return = array('valid'=>true,'frekuensi'=>$frekuensi);
			}
			else
			{
				$return = array('valid'=>false,'frekuensi'=>$frekuensi,'message'=>'Nominal Pembayaran Pokok tidak Valid (Tidak menemukan Frekuensi yg Tepat)');
			}
		}
		else if ( $flag_jadwal_angsuran == '1' )
		{
			$financing = $this->model_transaction->get_account_financing($account_financing_no);
			$angsuran_pokok = $financing['angsuran_pokok'];

			$sisa_bagi = $nominal_pembayaran%$angsuran_pokok;
			$frekuensi = $nominal_pembayaran/$angsuran_pokok;
			if ($sisa_bagi==0) {
				$return = array('valid'=>true,'frekuensi'=>$frekuensi);
			} else {
				$return = array('valid'=>false,'frekuensi'=>$frekuensi,'message'=>'Nominal Pembayaran Pokok tidak Valid (Tidak menemukan Frekuensi yg Tepat)');
			}
		}

		echo json_encode($return);
	}

	function proses_pembayaran_angsuran_pokok()
	{
		$_account_financing_no = $this->input->post('no_rekening');
		$_nominal_pembayaran = $this->input->post('nominal_pembayaran');
		$_nominal_pembayaran = $this->convert_numeric($_nominal_pembayaran);
		$_tgl_bayar = $this->input->post('tgl_bayar');
		$_tgl_bayar = $this->datepicker_convert(true,$_tgl_bayar,'/');
		$_keterangan = $this->input->post('keterangan');
		$_account_cash_code = $this->input->post('account_cash_code');

		// validasi isian dulu deh
		if ( $_account_cash_code == "" ) 
		{
			$return = array('success'=>false,'message'=>'Mohon Pilih Kas/Bank!');
		}
		else
		{
			$flag_jadwal_angsuran = $this->model_transaction->get_flag_jadwal_angsuran_v2($_account_financing_no);

			if ( $flag_jadwal_angsuran == '0' ) // non reguler
			{
				$schedulles = $this->model_transaction->get_account_financing_schedulle($_account_financing_no);

				$angsuran_pokok = 0;
				$total_angsuran_pokok = 0;
				$total_angsuran_margin = 0;
				$frekuensi = 0;
				$arr_schedulle_id = array();
				$arr_angsuran_pokok = array();
				$arr_jto_date = array();
				for ( $i = 0 ; $i < count($schedulles) ; $i++ )
				{
					$angsuran_pokok += $schedulles[$i]['angsuran_pokok'];

					if ($angsuran_pokok>$_nominal_pembayaran) {
						break;
					} else {
						$total_angsuran_pokok += $schedulles[$i]['angsuran_pokok'];
						$total_angsuran_margin += $schedulles[$i]['angsuran_margin'];
						array_push($arr_schedulle_id, $schedulles[$i]['account_financing_schedulle_id']);
						array_push($arr_angsuran_pokok, $schedulles[$i]['angsuran_pokok']);
						array_push($arr_jto_date, $schedulles[$i]['tangga_jtempo']);
						$frekuensi++;
					}
				}

				// now total_angsuran_pokok didapatkan
				$financing = $this->model_transaction->get_account_financing($_account_financing_no);

				if ( $_nominal_pembayaran == $total_angsuran_pokok )
				{
					$_is_msa_mda = $this->_is_msa_mda($financing['akad_code']);

					// apabila bukan akad msa dan mda
					if ($_is_msa_mda==false)
					{
						$this->db->trans_begin();
						// buat histori transaksi
						$trx_account_financing = array();
						$trx_detail = array();
						$branch_id = $this->session->userdata('branch_id');
						$trx_financing_type = 1;
						$trx_date = $_tgl_bayar;
						$angsuran_ke = $financing['counter_angsuran'];
						$created_date = date('Y-m-d H:i:s');
						$created_by = $this->session->userdata('user_id');
						$verify_by = $this->session->userdata('user_id');
						$verify_date = date('Y-m-d H:i:s');
						$trx_status = 1;
						$freq = 1;
						$trx_type = 3; // (1=tabungan 2=deposito 3=pembiayaan 4=GL 5=asuransi)
						$flag_debit_credit = 'C';
						$tipe_angsuran = 5; // (1=angsruan pertama ,2=angsuran upload ,3=angsuran manual ,4=angsuran pelunasan, 5=angsuran pokok)
						for ( $j = 0 ; $j < count($arr_schedulle_id) ; $j++ )
						{
							$trx_account_financing_id = uuid(false);
							$trx_detail_id = uuid(false);

							$jto_date = $arr_jto_date[$j];
							$pokok = $arr_angsuran_pokok[$j];
							$margin = 0;
							$angsuran_ke++;
							// $description = 'PEMBAYARAN ANGSURAN POKOK KE '+$angsuran_ke;
							$description = $_keterangan;

							$trx_account_financing[] = array(
								'trx_account_financing_id' => $trx_account_financing_id,
								'branch_id' => $branch_id,
								'trx_detail_id' => $trx_detail_id,
								'account_financing_no' => $_account_financing_no,
								'trx_financing_type' => $trx_financing_type,
								'trx_date' => $trx_date,
								'jto_date' => $jto_date,
								'pokok' => $pokok,
								'margin' => $margin,
								'catab' => 0,
								'description' => $description,
								'created_date' => $created_date,
								'created_by' => $created_by,
								'verify_by' => $verify_by,
								'verify_date' => $verify_date,
								'trx_status' => $trx_status,
								'freq' => $freq,
								'angsuran_ke' => $angsuran_ke,
								'account_cash_code' => $_account_cash_code,
								'tipe_angsuran' => $tipe_angsuran
							);

							$trx_detail[] = array(
								'trx_detail_id' => $trx_detail_id,
								'trx_type' => $trx_type,
								'trx_account_type' => $trx_financing_type,
								'account_no' => $_account_financing_no,
								'flag_debit_credit' => $flag_debit_credit,
								'amount' => $pokok,
								'trx_date' => $trx_date,
								'description' => $description,
								'created_by' => $created_by,
								'created_date' => $created_date
							);
						}
						$this->db->insert_batch('mfi_trx_account_financing',$trx_account_financing);
						$this->db->insert_batch('mfi_trx_detail',$trx_detail);

						// perubahan data financing schedulle
						// delete dulu
						for ( $k = 0 ; $k < count($arr_schedulle_id) ; $k++ )
						{
							$param_schedulle = array('account_financing_schedulle_id'=>$arr_schedulle_id[$k]);
							$this->db->delete('mfi_account_financing_schedulle',$param_schedulle);
						}
						// lalu insert
						$new_tangga_jtempo = $schedulles[0]['tangga_jtempo'];
						$data_schedulle = array(
							'account_no_financing' => $_account_financing_no,
							'tangga_jtempo' => $new_tangga_jtempo,
							'angsuran_pokok' => $_nominal_pembayaran,
							'angsuran_margin' => 0,
							'tanggal_bayar'=>$_tgl_bayar,
							'status_angsuran'=>1,
							'bayar_pokok'=>$_nominal_pembayaran
						);
						$this->db->insert('mfi_account_financing_schedulle',$data_schedulle);

						// perubahan data financing
						$jtempo_angsuran_last = $new_tangga_jtempo;
						$jtempo_angsuran_next = (isset($schedulles[1]['tangga_jtempo'])) ? $schedulles[1]['tangga_jtempo'] : $financing['tangga_jtempo'];
						$new_saldo_pokok = $financing['saldo_pokok']-$total_angsuran_pokok;
						$new_saldo_margin = $financing['saldo_margin']-$total_angsuran_margin;
						$new_counter_angsuran = $financing['counter_angsuran']+$frekuensi;
						$new_jtempo_angsuran_last = $jtempo_angsuran_last;
						$new_jtempo_angsuran_next = $jtempo_angsuran_next;

						$param = array('account_financing_no'=>$_account_financing_no);
						$data = array(
							'saldo_pokok'=>$new_saldo_pokok,
							'saldo_margin'=>$new_saldo_margin,
							'counter_angsuran'=>$new_counter_angsuran,
							'jtempo_angsuran_last'=>$new_jtempo_angsuran_last,
							'jtempo_angsuran_next'=>$new_jtempo_angsuran_next
						);
						$this->db->update('mfi_account_financing',$data,$param);

						/*
						* REBUILD NEW SCHEDULLE BY SALDO
						* hanya akad yg bukan msa dan mda atau bukan produk smile saja yg di rebuild schedulle nya
						* product_code : (52 = smile, 54 = kmg, 56 = kpr, 58 = komersial, 99 = ump)
						*/

						if ( $financing['product_code'] != '52' )
						{
							$vars['account_financing_no'] = $_account_financing_no;
							$vars['product_code'] = $financing['product_code'];
							$vars['rate_margin'] = $financing['rate_margin'];
							$vars['jangka_waktu'] = $financing['jangka_waktu'];
							$vars['counter_angsuran'] = $new_counter_angsuran;
							$this->rebuild_financing_schedulle($vars);
						}

						if ( $this->db->trans_status() === TRUE ) 
						{
							$this->db->trans_commit();
							$return = array('success'=>true);
						}
						else
						{
							$this->db->trans_rollback();
							$return = array('success'=>false,'message'=>'Failed to connect into databases, Please contact your administrator!');
						}
					}
				}
				else
				{
					$return = array('success'=>false,'message'=>'Nominal Pembayaran Pokok tidak Valid (Tidak menemukan Frekuensi yg Tepat)');
				}
			}
			else if ( $flag_jadwal_angsuran == '1' ) // reguler
			{
				$financing = $this->model_transaction->get_account_financing($_account_financing_no);
				$angsuran_pokok = $financing['angsuran_pokok'];

				$sisa_bagi = $_nominal_pembayaran%$angsuran_pokok;
				$frekuensi = $_nominal_pembayaran/$angsuran_pokok;

				if ($sisa_bagi==0)
				{
					$this->db->trans_begin();
					// collect data for histori angsuran pokok
					$counter_angsuran = $financing['counter_angsuran'];
					$angsuran_ke = $counter_angsuran;
					$jtempo_angsuran_last = $financing['jtempo_angsuran_last'];
					$jtempo_angsuran_next = $financing['jtempo_angsuran_next'];
					$periode_jangka_waktu = $financing['periode_jangka_waktu'];
					$branch_id = $this->session->userdata('branch_id');
					$trx_financing_type = 1;
					$trx_date = $_tgl_bayar;
					$created_date = date('Y-m-d H:i:s');
					$created_by = $this->session->userdata('user_id');
					$verify_by = $this->session->userdata('user_id');
					$verify_date = date('Y-m-d H:i:s');
					$trx_status = 1;
					$trx_type = 3; // (1=tabungan 2=deposito 3=pembiayaan 4=GL 5=asuransi)
					$flag_debit_credit = 'C';
					$tipe_angsuran = 5; // (1=angsruan pertama ,2=angsuran upload ,3=angsuran manual ,4=angsuran pelunasan, 5=angsuran pokok)
					$pokok = $financing['angsuran_pokok'];
					$margin = $financing['angsuran_margin'];
					$trx_account_financing = array();
					$trx_detail = array();

					$i=0;
					for ( $freq = 1 ; $freq <= $frekuensi ; $freq++ )
					{
						$trx_account_financing_id = uuid(false);
						$trx_detail_id = uuid(false);

						$jto_date = $this->get_next_jto_date($jtempo_angsuran_last,$periode_jangka_waktu,$freq);

						$angsuran_ke++;
						// $description = 'PEMBAYARAN ANGSURAN POKOK KE '+$angsuran_ke;
						$description = $_keterangan;

						$trx_account_financing[] = array(
							'trx_account_financing_id' => $trx_account_financing_id,
							'branch_id' => $branch_id,
							'trx_detail_id' => $trx_detail_id,
							'account_financing_no' => $_account_financing_no,
							'trx_financing_type' => $trx_financing_type,
							'trx_date' => $trx_date,
							'jto_date' => $jto_date,
							'pokok' => $pokok,
							'margin' => $margin,
							'catab' => 0,
							'description' => $description,
							'created_date' => $created_date,
							'created_by' => $created_by,
							'verify_by' => $verify_by,
							'verify_date' => $verify_date,
							'trx_status' => $trx_status,
							'freq' => 1,
							'angsuran_ke' => $angsuran_ke,
							'account_cash_code' => $_account_cash_code,
							'tipe_angsuran' => $tipe_angsuran
						);

						$trx_detail[] = array(
							'trx_detail_id' => $trx_detail_id,
							'trx_type' => $trx_type,
							'trx_account_type' => $trx_financing_type,
							'account_no' => $_account_financing_no,
							'flag_debit_credit' => $flag_debit_credit,
							'amount' => $pokok,
							'trx_date' => $trx_date,
							'description' => $description,
							'created_by' => $created_by,
							'created_date' => $created_date
						);

						$i++;
					} // end for
					$this->db->insert_batch('mfi_trx_account_financing',$trx_account_financing);
					$this->db->insert_batch('mfi_trx_detail',$trx_detail);

					// perubahan data financing
					$total_angsuran_pokok = $financing['angsuran_pokok']*$frekuensi;
					$total_angsuran_margin = $financing['angsuran_margin']*$frekuensi;
					$new_saldo_pokok = $financing['saldo_pokok']-$total_angsuran_pokok;
					$new_saldo_margin = $financing['saldo_margin']-$total_angsuran_margin;
					$new_counter_angsuran = $financing['counter_angsuran']+$frekuensi;
					$new_jtempo_angsuran_last = $this->get_next_jto_date($jtempo_angsuran_last,$periode_jangka_waktu,1);
					$new_jtempo_angsuran_next = $this->get_next_jto_date($jtempo_angsuran_next,$periode_jangka_waktu,1);

					$param = array('account_financing_no'=>$_account_financing_no);
					$data = array(
						'saldo_pokok'=>$new_saldo_pokok,
						'saldo_margin'=>$new_saldo_margin,
						'counter_angsuran'=>$new_counter_angsuran,
						'jtempo_angsuran_last'=>$new_jtempo_angsuran_last,
						'jtempo_angsuran_next'=>$new_jtempo_angsuran_next
					);
					$this->db->update('mfi_account_financing',$data,$param);

					if ( $this->db->trans_status() === TRUE ) 
					{
						$this->db->trans_commit();
						$return = array('success'=>true);
					}
					else
					{
						$this->db->trans_rollback();
						$return = array('success'=>false,'message'=>'Failed to connect into databases, Please contact your administrator!');
					}
				}
				else
				{
					$return = array('success'=>false,'message'=>'Nominal Pembayaran Pokok tidak Valid (Tidak menemukan Frekuensi yg Tepat)');
				}
			}

		}

		echo json_encode($return);

	}

	private function _is_msa_mda($akad_code)
	{
		switch($akad_code) {
			case "MSA": // MUSYARAKAH
			case "MDA": // MUDHARABAH
				return true;
			break;
			default:
				return false;
			break;
		}
	}

	private function rebuild_financing_schedulle($vars)
	{
		$account_financing_no = $vars['account_financing_no'];
		$product_code = $vars['product_code'];
		$rate_margin = $vars['rate_margin'];
		$jangka_waktu = $vars['jangka_waktu'];
		$counter_angsuran = $vars['counter_angsuran'];
		$sisa_freq_bayar = $jangka_waktu - $counter_angsuran;


		// apabila kmg
		if ( $product_code == '53' || $product_code == '54' )
		{
			$this->rebuild_schedulle_kmg($account_financing_no,$sisa_freq_bayar,$rate_margin);
		}

		// apabila kpr
		if ( $product_code == '56' )
		{
			$this->rebuild_schedulle_kpr($account_financing_no,$sisa_freq_bayar,$rate_margin);
		}

	}

	private function get_next_jto_date($jto_last,$periode_jangka_waktu,$freq)
	{
		switch($periode_jangka_waktu)
		{
			case "0":
				return date('Y-m-d',strtotime($jto_last ." +$freq day"));
			break;
			case "1":
				return date('Y-m-d',strtotime($jto_last ." +$freq week"));
			break;
			case "2":
				return date('Y-m-d',strtotime($jto_last ." +$freq month"));
			break;
			case "3":
				return date('Y-m-d',strtotime($jto_last ." +$freq year"));
			break;
			default:
				return false;
			break;
		}
	}

	function cek_unverified_transaction()
	{
		$account_financing_no = $this->input->post('account_financing_no');

		$_is_verified = $this->model_transaction->cek_unverified_transaction($account_financing_no);

		$return = array('is_verified'=>$_is_verified);

		echo json_encode($return);
	}

	function export_finance_canceled_angsuran()
	{
		/*
		| DECLARE URI SEGMENT DATA
		*/
		$angsuran_id=$this->uri->segment(3);
		$datas = $this->model_transaction->get_angsuran_canceled($angsuran_id);

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
		
		/*
		| BORDER OPTION
		*/
		$styleArray['borders']['outline']['style']=PHPExcel_Style_Border::BORDER_THIN;
		$styleArray['borders']['outline']['color']['rgb']='000000';
		/*
		| SET COLUMN WIDTH
		*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

		/*
		| ROW HEADER TITLE
		*/
		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"List Angsuran Dibatalkan");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"No. Pembiayaan");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Nama");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;
		/*
		| ROW DATA
		*/
		for($i=0;$i<count($datas);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$datas[$i]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setSize(11);
			$row++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ANGSURAN DIBATALKAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	/*
	| END PENDEBETAN ANGSURAN
	*/

	/**
	* PEMBATALAN ANGSURAN
	*/
	
	public function pembatalan_angsuran()
	{
		$data['container'] = 'transaction/pembatalan_angsuran';
		$this->load->view('core',$data);
	}

	public function jqgrid_pembatalan_angsuran()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:50;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'';
		$cif_no = isset($_REQUEST['cif_no'])?$_REQUEST['cif_no']:'';
		$nama = isset($_REQUEST['nama'])?$_REQUEST['nama']:'';
		$account_financing_no = isset($_REQUEST['account_financing_no'])?$_REQUEST['account_financing_no']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_transaction->jqgrid_pembatalan_angsuran('','','','',$cif_no,$nama,$account_financing_no);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_transaction->jqgrid_pembatalan_angsuran($sidx,$sord,$limit_rows,$start,$cif_no,$nama,$account_financing_no);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['account_financing_id'] = $row['account_financing_id'];
			$responce['rows'][$i]['cell'] = array(
				$row['account_financing_id']
				,$row['account_financing_no']
				,$row['nama']
				,$row['pokok']
				,$row['margin']
				,$row['saldo_pokok']
				,$row['saldo_margin']
				,$row['tanggal_akad']
				,$row['jtempo_angsuran_last']
				,$row['jtempo_angsuran_next']
				,$row['counter_angsuran']
				,$row['flag_jadwal_angsuran']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	function get_data_for_pembatalan_angsuran()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		if (isset($_POST['account_financing_no'])) {
			$sql = "
				select
					a.trx_account_financing_id,
					b.account_financing_no,
					c.nama,
					b.pokok,
					b.margin,
					b.tanggal_akad,
					a.pokok as angsuran_pokok,
					a.margin as angsuran_margin,
					a.jto_date,
					a.trx_date,
					a.angsuran_ke
				from mfi_trx_account_financing a, mfi_account_financing b, mfi_cif c
				where a.account_financing_no=b.account_financing_no
				and b.cif_no=c.cif_no
				and b.status_rekening = 1
				and a.trx_financing_type = 1
				and a.trx_status=1
				and a.account_financing_no=?
				order by a.angsuran_ke desc limit 1
			";
			$param[] = $account_financing_no;
			$query = $this->db->query($sql,$param);
			$row = $query->row_array();
			echo json_encode($row);
		} else {
			echo json_encode(array());
		}
	}

	function do_pembatalan_angsuran()
	{
		$trx_account_financing_id = $this->input->post('trx_account_financing_id');
		if ( isset($_POST['trx_account_financing_id']) ) {
			$sql = "
				select
					a.trx_account_financing_id,
					a.trx_detail_id,
					b.account_financing_no,
					c.nama,
					b.pokok,
					b.margin,
					b.tanggal_akad,
					a.pokok as angsuran_pokok,
					a.margin as angsuran_margin,
					a.jto_date,
					a.trx_date,
					a.angsuran_ke,
					b.counter_angsuran,
					b.jtempo_angsuran_last,
					b.jtempo_angsuran_next,
					b.saldo_pokok,
					b.saldo_margin,
					a.reference_no,
					a.description,
					a.account_cash_code,
					a.freq,
					(
						select 
						  coalesce(max(angsuran_ke),0)
						from 
						  mfi_trx_account_financing x 
						where 
							x.account_financing_no=a.account_financing_no and 
							x.trx_financing_type in(1,2) and
							x.trx_account_financing_id<>a.trx_account_financing_id
						) as counter_angsuran_new,
					b.flag_jadwal_angsuran -- 0 = non reguler, 1 = reguler
				from mfi_trx_account_financing a, mfi_account_financing b, mfi_cif c
				where a.account_financing_no=b.account_financing_no
				and b.cif_no=c.cif_no
				and a.trx_account_financing_id=?
			";
			$param[] = $trx_account_financing_id;
			$query = $this->db->query($sql,$param);
			$row = $query->row_array();

			if ( count($row) > 0 ) {

				// update : saldo pokok ,saldo margin , jto last, jto next, counter angsuran, 
				// table : mfi_account_financing
				$financing = array(
					'saldo_pokok'=>$row['saldo_pokok']+$row['angsuran_pokok'],
					'saldo_margin'=>$row['saldo_margin']+$row['angsuran_margin'],
					'jtempo_angsuran_last'=>date('Y-m-d',strtotime($row['jtempo_angsuran_last'] . ' -1 month')),
					'jtempo_angsuran_next'=>date('Y-m-d',strtotime($row['jtempo_angsuran_next'] . ' -1 month')),
					// 'counter_angsuran'=>$row['counter_angsuran_new']
					'counter_angsuran'=>$row['counter_angsuran']-1
				);
				$financing_param = array('account_financing_no'=>$row['account_financing_no']);
				
				// delete : trx_gl_detail & trx_gl
				$sql_trx_gl = "select trx_gl_id from mfi_trx_gl where jurnal_trx_id=?";
				$query_trx_gl = $this->db->query($sql_trx_gl,array($row['trx_account_financing_id']));
				$result_trx_gl = $query_trx_gl->result_array();

				$trx_gl_detail_param = array();
				if ( count($result_trx_gl) > 0 ) {
					for ( $i = 0 ; $i < count($result_trx_gl) ; $i ++ ) {
						if ( isset($result_trx_gl[$i]['trx_gl_id']) ) {
							$trx_gl_detail_param[] = array('trx_gl_id'=>$result_trx_gl[$i]['trx_gl_id']);
						}
					}
				}
				$trx_gl_param = array('jurnal_trx_id'=>$row['trx_account_financing_id']);

				// delete : trx_detail & trx_account_financing
				$trx_detail_param = array('trx_detail_id'=>$row['trx_detail_id']);
				$trx_financing_param = array('trx_account_financing_id'=>$row['trx_account_financing_id']);

				// insert log : mfi_trx_account_financing_reject
				$trx_financing_reject = array(
					'id'=>$row['trx_account_financing_id'],
					'account_financing_no'=>$row['account_financing_no'],
					'trx_date'=>$row['trx_date'],
					'jto_date'=>$row['jto_date'],
					'pokok'=>$row['angsuran_pokok'],
					'margin'=>$row['angsuran_margin'],
					'reference_no'=>$row['reference_no'],
					'description'=>$row['description'],
					'angsuran_ke'=>$row['angsuran_ke'],
					'account_cash_code'=>$row['account_cash_code'],
					'created_date'=>date('Y-m-d H:i:s'),
					'created_by'=>$this->session->userdata('user_id')
				);

				// update : mfi_account_financing_schedulle
				$financing_schedulle = array();
				$financing_schedulle_param = array();
				if ( $row['flag_jadwal_angsuran'] == 0 ) { // non-reguler
					$financing_schedulle = array(
						'status_angsuran'=>0,
						'bayar_pokok'=>0,
						'bayar_margin'=>0,
						'tanggal_bayar'=>null
					);
					$financing_schedulle_param = array(
						'account_no_financing'=>$row['account_financing_no'],
						'tangga_jtempo'=>$row['jto_date']
					);
				}

				/* ----------------------------------
				* BEGIN TRANSACTION
				* ---------------------------------- */
				$this->db->trans_begin();

					// update : saldo pokok ,saldo margin , jto last, jto next, counter angsuran, 
					$this->db->update('mfi_account_financing',$financing,$financing_param);

					// delete : trx_gl_detail & trx_gl
					if ( count($trx_gl_detail_param) > 0 ) {
						for ( $j = 0 ; $j < count($trx_gl_detail_param) ; $j++ ) {
							$this->db->delete('mfi_trx_gl_detail',$trx_gl_detail_param[$j]);
						}
					}
					$this->db->delete('mfi_trx_gl',$trx_gl_param);

					// delete : trx_financing & trx_account_financing
					$this->db->delete('mfi_trx_detail',$trx_detail_param);
					$this->db->delete('mfi_trx_account_financing',$trx_financing_param);

					// insert log : trx_account_financing_reject
					$this->db->insert('mfi_trx_account_financing_reject',$trx_financing_reject);

					// update schedulle if non-reguler (0)
					if ( $row['flag_jadwal_angsuran'] == 0 ) { // non-reguler
						if ( count($financing_schedulle) > 0 ) {
							$this->db->update('mfi_account_financing_schedulle',$financing_schedulle,$financing_schedulle_param);
						}
					}

				if ( $this->db->trans_status() === true ) {
					$this->db->trans_commit();
					$return = array('success'=>true);
				} else {
					$this->db->trans_rollback();
					$return = array('success'=>false,'error'=>2);
				}
				/* ----------------------------------
				* END TRANSACTION
				* ---------------------------------- */

				echo json_encode($return);
			} else {
				echo json_encode(array('success'=>false,'error'=>1));
			}

		} else {
			echo json_encode(array('success'=>false,'error'=>0));
		}
	}
	/**
	* //PEMBATALAN ANGSURAN
	*/

	/*function test_code($account_financing_no, $trx_date)
	{
		$sql = "SELECT account_financing_no,flag_jadwal_angsuran,angsuran_pokok,angsuran_margin,product_code
				from mfi_account_financing
				where account_financing_no=?
				and status_rekening=1
				AND (not (counter_angsuran < 1 AND jtempo_angsuran_next >= (?::date + '1 month'::interval)::date )
					OR (counter_angsuran < 1 AND jtempo_angsuran_next >= (?::date + '1 month'::interval)::date 
					AND created_by='SYS' AND product_code not in('53','54','56','58','99'))
				)
				order by tanggal_akad";
		$query = $this->db->query($sql,array($account_financing_no,$trx_date,$trx_date));
		$rows = $query->result_array();
		print_r($rows);
	}*/

	/*function del_product($product_code)
	{
		$result = $this->db->query("SELECT * FROM mfi_account_financing WHERE product_code='$product_code'");
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				$account_financing_no = $row->account_financing_no;
				$hasil1 = $this->db->query("DELETE FROM mfi_account_financing_schedulle WHERE account_no_financing='$account_financing_no'");
			}
			
			$this->db->query("DELETE FROM mfi_account_financing WHERE product_code='$product_code'");
			$this->db->query("DELETE FROM mfi_account_financing_reg WHERE product_code='$product_code'");
			
			echo 'DONE';
		}else{
			echo 'NO DATA'; exit;
		}
	}*/

	/*function del_twp()
	{
		$result = $this->db->query("SELECT * FROM mfi_trx_gl WHERE jurnal_trx_type='1' AND branch_code='10000'");
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				$jurnal_trx_id = $row->jurnal_trx_id;
				$trx_gl_id = $row->trx_gl_id;
				$hasil1 = $this->db->query("DELETE FROM mfi_trx_gl_detail WHERE trx_gl_id='$jurnal_trx_id'");
				$hasil2 = $this->db->query("DELETE FROM mfi_trx_gl WHERE trx_gl_id='$trx_gl_id'");
				
				echo $hasil1.' | '.$hasil2;
			}

			$hasil3 = $this->db->query("DELETE FROM mfi_account_saving WHERE product_code='01'");
			echo $hasil3;
			echo '<br>';
		}else{
			echo 'NO DATA'; exit;
		}
	}*/
}

/* End of file transaction.php */
/* Location: ./application/controllers/transaction.php */