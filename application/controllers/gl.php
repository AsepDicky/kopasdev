<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gl extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_gl');
		$this->load->model('model_kantor_layanan');
	}

	public function index()
	{
		$data['container'] = 'gl';
		$this->load->view('core',$data);
	}

	/* BEGIN SETUP GL ACCOUNT *******************************************************/

	public function account_setup()
	{
		$data['container'] = 'gl/gl_account';
		$data['account_type'] = $this->model_gl->get_code_value(); 
		$this->load->view('core',$data);
	}

	public function datatable_gl_account_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$account_type = isset($_GET['account_type'])?$_GET['account_type']:'';
		$account_group = isset($_GET['account_group'])?$_GET['account_group']:'';

		$aColumns = array('','account_code','account_name','mfi_list_code_detail.display_text','','');
				
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
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
			$sWhere .= ") and mfi_list_code_detail.code_group = 'account_type'";
		}
		else
		{
		$sWhere = "where mfi_list_code_detail.code_group = 'account_type'";
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

		$rResult 			= $this->model_gl->datatable_gl_account_setup($sWhere,$sOrder,$sLimit,$account_type,$account_group); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_gl_account_setup($sWhere,'','',$account_type,$account_group); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_gl_account_setup('','','',$account_type,$account_group); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['gl_account_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_code'];
			$row[] = $aRow['account_name'];
			$row[] = $aRow['display_text'];
			$row[] = '<div align="center"><a class="btn mini green" href="'.site_url('gl/export_gl_account/'.$aRow['gl_account_id']).'" target="_blank">Print</a></div>';
			$row[] = '<div align="center"><a class="btn mini purple" href="javascript:;" gl_account_id="'.$aRow['gl_account_id'].'" id="link-edit">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_account_group()
	{
		$code_value = $this->input->post('code_value');
		$data = $this->model_gl->search_account_group($code_value);

		echo json_encode($data);
	}

	public function proses_input_setup_gl_account()
	{
		$account_code 	= $this->input->post('account_code');
		$account_name 	= $this->input->post('account_name');
		$account_type 	= $this->input->post('account_type');
		$account_group 	= $this->input->post('account_group');
		$default_saldo 	= $this->input->post('default_saldo');
		$user_id		= $this->session->userdata('user_id');

		$data = array
				(
					'account_code'				=> $account_code,
					'account_name'				=> $account_name,
					'account_type'				=> $account_type,
					'account_group_code'		=> $account_group,
					'transaction_flag_default'	=> $default_saldo,
					'status_account'			=> 0,
					'created_by'				=> $user_id,
					'created_date'				=> date('Y-m-d H:i:s')
				);

		$this->db->trans_begin();
		$this->model_gl->proses_input_setup_gl_account($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function proses_input_setup_gl_account_budget()
	{
		$account_code	= $this->input->post('code_account');
		$tahun			= $this->input->post('tahun');
		$januari		= $this->input->post('januari');
		$februari		= $this->input->post('februari');
		$maret			= $this->input->post('maret');
		$april			= $this->input->post('april');
		$mei			= $this->input->post('mei');
		$juni			= $this->input->post('juni');
		$juli			= $this->input->post('juli');
		$agustus		= $this->input->post('agustus');
		$september		= $this->input->post('september');
		$oktober		= $this->input->post('oktober');
		$november		= $this->input->post('november');
		$desember		= $this->input->post('desember');

		$data = array(
					'budget_year'		=> $tahun,
					'account_code'		=> $account_code,
					'm1'				=> $this->convert_numeric($januari),
					'm2'				=> $this->convert_numeric($februari),
					'm3'				=> $this->convert_numeric($maret),
					'm4'				=> $this->convert_numeric($april),
					'm5'				=> $this->convert_numeric($mei),
					'm6'				=> $this->convert_numeric($juni),
					'm7'				=> $this->convert_numeric($juli),
					'm8'				=> $this->convert_numeric($agustus),
					'm9'				=> $this->convert_numeric($september),
					'm10'				=> $this->convert_numeric($oktober),
					'm11'				=> $this->convert_numeric($november),
					'm12'				=> $this->convert_numeric($desember)
			);

		$this->db->trans_begin();
		$this->model_gl->proses_input_setup_gl_account_budget($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function delete_gl_account()
	{
		$gl_account_id = $this->input->post('gl_account_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($gl_account_id) ; $i++ )
		{
			$param = array('gl_account_id'=>$gl_account_id[$i]);
			$this->db->trans_begin();
			$this->model_gl->delete_gl_account($param);
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

	public function get_gl_account_by_id()
	{
		$gl_account_id = $this->input->post('gl_account_id');
		$data = $this->model_gl->get_gl_account_by_id($gl_account_id);

		echo json_encode($data);
	}

	public function proses_edit_setup_gl_account()
	{
		$gl_account_id 	= $this->input->post('gl_account_id');
		$account_code 	= $this->input->post('account_code2');
		$account_name 	= $this->input->post('account_name');
		$account_type 	= $this->input->post('account_type');
		$account_group 	= $this->input->post('account_group');
		$default_saldo 	= $this->input->post('default_saldo');
		$user_id		= $this->session->userdata('user_id');

		$param = array('gl_account_id'=>$gl_account_id);
		$data = array
				(
					'account_code'				=> $account_code,
					'account_name'				=> $account_name,
					'account_type'				=> $account_type,
					'account_group_code'		=> $account_group,
					'transaction_flag_default'	=> $default_saldo,
					'status_account'			=> 0,
					'created_by'				=> $user_id,
					'created_date'				=> date('Y-m-d H:i:s')
				);

		$this->db->trans_begin();
		$this->model_gl->proses_edit_setup_gl_account($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function proses_edit_setup_gl_account_budget()
	{

		$account_code			= $this->input->post('code_account');
		$tahun					= $this->input->post('tahun');
		$januari				= $this->input->post('januari');
		$februari				= $this->input->post('februari');
		$maret					= $this->input->post('maret');
		$april					= $this->input->post('april');
		$mei					= $this->input->post('mei');
		$juni					= $this->input->post('juni');
		$juli					= $this->input->post('juli');
		$agustus				= $this->input->post('agustus');
		$september				= $this->input->post('september');
		$oktober				= $this->input->post('oktober');
		$november				= $this->input->post('november');
		$desember				= $this->input->post('desember');

		$param = array('account_code'=>$account_code);
		$data = array(
					'budget_year'		=> $tahun,
					'm1'				=> $januari,
					'm2'				=> $februari,
					'm3'				=> $maret,
					'm4'				=> $april,
					'm5'				=> $mei,
					'm6'				=> $juni,
					'm7'				=> $juli,
					'm8'				=> $agustus,
					'm9'				=> $september,
					'm10'				=> $oktober,
					'm11'				=> $november,
					'm12'				=> $desember
			);

		$this->db->trans_begin();
		$this->model_gl->proses_edit_setup_gl_account_budget($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_gl_account_budget_by_id()
	{
		$account_code = $this->input->post('account_code');
		$data = $this->model_gl->get_gl_account_budget_by_id($account_code);

		echo json_encode($data);
	}

	public function export_gl_account()
	{
		$gl_account_id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		// if ($status==0) 
		// {			
		// 	echo "<script>alert('Status Masih 0');javascript:history.back();</script>";
		// } 
		// else if ($status==2)
		// {
		// 	echo "<script>alert('Status Masih 2');javascript:history.back();</script>";
		// }
		// else
		// {

		$this->load->library('html2pdf');
		ob_start();

		
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		$data['account_group'] = $this->model_gl->get_data_from_account_group($gl_account_id);

		$this->load->view('gl/export_gl',$data);

		$content = ob_get_clean();

		try
	    {
	        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
	        $html2pdf->pdf->SetDisplayMode('fullpage');
	        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	        $html2pdf->Output('gl_account.pdf');
	    }
	    catch(HTML2PDF_exception $e) {
	        echo $e;
	        exit;
	    }
	  //}
	}
	

	/* END SETUP GL ACCOUNT *******************************************************/


	/****************************************************************************************/	
	// BEGIN ACCOUNT GROUP SETUP
	/****************************************************************************************/
	public function account_group()
	{
		$data['container'] = 'gl/account_group';
		$data['group_type'] = $this->model_gl->get_group_type();
		$this->load->view('core',$data);
	}

	public function datatable_account_group()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$group_type=isset($_GET['group_type'])?$_GET['group_type']:'';

		$aColumns = array( '','mfi_gl_account_group.group_code', 'mfi_gl_account_group.group_name', 'mfi_list_code_detail.display_text','');
				
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
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
			$sWhere .= ") and mfi_list_code_detail.code_group = 'account_type'";
		}
		else
		{
			$sWhere = "where mfi_list_code_detail.code_group = 'account_type'";
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

		$rResult 			= $this->model_gl->datatable_account_group_setup($sWhere,$sOrder,$sLimit,$group_type); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_account_group_setup($sWhere,'','',$group_type); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_account_group_setup('','','',$group_type); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['gl_account_group_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['group_code'];
			$row[] = $aRow['group_name'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" gl_account_group_id="'.$aRow['gl_account_group_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_account_group()
	{
		$group_code 	= $this->input->post('group_code');
		$group_name 	= $this->input->post('group_name');
		$account_type 	= $this->input->post('group_type');
		$created_by 	= $this->session->userdata('user_id');
		$created_date	= date('Y-m-d H:i:s');

			$data = array(
							'group_code' 	=> $group_code
							,'group_name' 	=> $group_name
							,'account_type' => $account_type
							,'created_by'	=> $created_by
							,'created_date'	=> $created_date
						 );
		$this->db->trans_begin();
		$this->model_gl->add_account_group($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_account_group()
	{
		$gl_account_group_id = $this->input->post('gl_account_group_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($gl_account_group_id) ; $i++ )
		{
			$param = array('gl_account_group_id'=>$gl_account_group_id[$i]);
			$this->db->trans_begin();
			$this->model_gl->delete_account_group($param);
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

	public function get_account_group_by_id()
	{
		$gl_account_group_id = $this->input->post('gl_account_group_id');
		$data = $this->model_gl->get_account_group_by_id($gl_account_group_id);

		echo json_encode($data);
	}

	public function edit_account_group()
	{
		$gl_account_group_id 	= $this->input->post('gl_account_group_id');
		$group_code 			= $this->input->post('group_code2');
		$group_name 			= $this->input->post('group_name2');
		$account_type 			= $this->input->post('group_type2');
		$created_by 			= $this->session->userdata('user_id');
		$created_date			= date('Y-m-d H:i:s');

			$param = array('gl_account_group_id'=>$gl_account_group_id);
			$data = array(
							'group_code' 	=> $group_code
							,'group_name' 	=> $group_name
							,'account_type' => $account_type
							,'created_by'	=> $created_by
							,'created_date'	=> $created_date
						 );
		$this->db->trans_begin();
		$this->model_gl->edit_account_group($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function check_group_code()
	{
		$group_code = $this->input->post('group_code');

		$group_code_validation = $this->model_gl->check_group_code($group_code);

		if($group_code_validation==true){
			$return = array('success'=>true,'message'=>'Kode Group Bisa Dipakai');
		}else{
			$return = array('success'=>false,'message'=>'Kode Group Sudah Ada');
		}

		echo json_encode($return);

	}
	/****************************************************************************************/	
	// END ACCOUNT GROUP SETUP
	/****************************************************************************************/



	/* BEGIN SETUP KAS PETUGAS *******************************************************/

	public function setup_kas_petugas()
	{
		$data['container'] = 'gl/setup_kas_petugas';
		$data['fa_name'] = $this->model_gl->get_fa_name(); 
		$data['branch'] = $this->model_kantor_layanan->get_all_branch_by_parent(); 
		$data['account_name'] = $this->model_gl->get_account_name(); 
		$this->load->view('core',$data);
	}

	public function datatable_setup_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('','account_cash_code','account_cash_name','mfi_fa.fa_name','mfi_user.fullname','');
				
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
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

		$rResult 			= $this->model_gl->datatable_setup_kas_petugas($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_setup_kas_petugas($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_setup_kas_petugas(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['account_cash_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['account_cash_code'];
			$row[] = $aRow['account_cash_name'];
			$row[] = $aRow['fa_name'];
			$row[] = $aRow['fullname'];
			$row[] = '<div align="center"><a href="javascript:;" account_cash_id="'.$aRow['account_cash_id'].'" id="link-edit" class="btn mini purple">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_ajax_fa_code()
	{
		$fa_code = $this->input->post('fa_code');
		//$fa_id = $this->model_gl->get_fa_code_from_mfi_fa($fa_code);
		$data = $this->model_gl->get_ajax_count_cash_name($fa_code);

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
            $no_urut_ = sprintf('%02s', $no_urut);            
            $kode_kas = $fa_code.'.'.$no_urut_;

		echo $kode_kas;
	}

	public function get_ajax_nama_kas()
	{
		$account_code 	= $this->input->post('account_code');
		$fa_code 		= $this->input->post('fa_code');
		$fa_name		= $this->model_gl->get_fa_name_from_mfi_fa($fa_code);
		$account_name	= $this->model_gl->get_ajax_account_name($account_code);

		/*$name_fa 		= $fa_name['fa_name'];
		$name_account 	= $account_name['account_name'];*/
        $nama_kas 		= $fa_name.'.'.$account_name;

		echo $nama_kas;
	}

	public function proses_input_setup_kas_petugas()
	{
		$branch_code	= $this->input->post('petugas');
		$petugas 		= $this->input->post('petugas');
		$account_name 	= $this->input->post('account_name');
		$nama_kas 		= $this->input->post('nama_kas');
		$kode_kas 		= $this->input->post('kode_kas');
		$created_by		= $this->session->userdata('user_id');
		$jenis_kas 		= $this->input->post('jenis_kas');
		$user_id 		= $this->input->post('user_id');

		$data = array 
				(
					'account_cash_code' 	=>$kode_kas,
					'fa_code'				=>$petugas,
					'account_cash_name'		=>$nama_kas,
					'gl_account_code'		=>$account_name,
					'created_by'			=>$created_by,
					'created_date'			=>date('Y-m-d H:i:s'),
					'account_cash_type'		=>$jenis_kas,
					'user_id'				=>$user_id
				);

		$this->db->trans_begin();
		$this->model_gl->proses_input_setup_kas_petugas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_gl_account_cash()
	{
		$account_cash_id = $this->input->post('account_cash_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($account_cash_id) ; $i++ )
		{
			$param = array('account_cash_id'=>$account_cash_id[$i]);
			$this->db->trans_begin();
			$this->model_gl->delete_gl_account_cash($param);
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

	public function get_gl_account_cash_by_id()
	{
		$account_cash_id = $this->input->post('account_cash_id');
		$data = $this->model_gl->get_gl_account_cash_by_id($account_cash_id);

		echo json_encode($data);
	}

	public function proses_edit_setup_kas_petugas()
	{
		$account_cash_id 		= $this->input->post('account_cash_id');
		$petugas 				= $this->input->post('petugas2');
		$account_name 			= $this->input->post('account_name2');
		$nama_kas 				= $this->input->post('nama_kas2');
		$kode_kas 				= $this->input->post('kode_kas2');
		$jenis_kas 				= $this->input->post('jenis_kas2');
		$user_id				= $this->input->post('user_id');
		$created_by				= $this->session->userdata('user_id');

		$param = array('account_cash_id'=>$account_cash_id);
		$data = array 
			(
				'account_cash_code' 	=>$kode_kas,
				'fa_code'				=>$petugas,
				'account_cash_name'		=>$nama_kas,
				'gl_account_code'		=>$account_name,
				'user_id'				=>$user_id,
				'account_cash_type'		=>$jenis_kas,
				'created_by'			=>$created_by,
				'created_date'			=>date('Y-m-d H:i:s')
			);

		$this->db->trans_begin();
		$this->model_gl->proses_edit_setup_kas_petugas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function get_fa_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_gl->get_fa_by_branch_code($branch_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END SETUP KAS PETUGAS
	/****************************************************************************************/

	public function get_gl_account_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_gl->get_gl_account_by_keyword($keyword);

		echo json_encode($data);
	}
	
	public function get_gl_account_kas_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_gl->get_gl_account_kas_by_keyword($keyword);

		echo json_encode($data);
	}

	/*---------------------------------------------------
	GL REPORT SETUP
	-----------------------------------------------------*/

	public function report_setup()
	{
		$data['container'] = 'gl/report_setup';
		$this->load->view('core',$data);
	}

	public function datatable_report_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','report_code','report_name', 'report_type','');
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}

		$rResult 			= $this->model_gl->datatable_report_setup('',$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_report_setup(''); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_report_setup(); // get number of all data
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
			if($aRow['report_type']=="0"){
				$aRow['report_type'] = "NERACA";
			}else if($aRow['report_type']=="1"){
				$aRow['report_type'] = "LABA RUGI";
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['gl_report_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['report_code'];
			$row[] = $aRow['report_name'];
			$row[] = $aRow['report_type'];
			$row[] = '<div style="text-align:center;"><a href="#dialog_edit_report" class="btn mini purple" data-toggle="modal"  gl_report_id="'.$aRow['gl_report_id'].'" id="link-edit"><i class="icon-edit"></i> Edit</a> &nbsp; <a href="#item-splitter" report_name="'.$aRow['report_name'].'" report_code="'.$aRow['report_code'].'" id="link-show-item" class="btn mini blue-stripe">Show Item</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_report_setup()
	{
		$report_code = $this->input->post('report_code');
		$report_name = $this->input->post('report_name');
		$report_type = $this->input->post('report_type');

		$data = array(
				'gl_report_id'=>uuid(false),
				'report_code'=>$report_code,
				'report_name'=>$report_name,
				'report_type'=>$report_type
			);

		$this->db->trans_begin();
		$this->model_gl->add_report_setup($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->Db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/* DELETE */
	public function delete_report_setup()
	{
		$gl_report_id = $this->input->post('gl_report_id');
		$param = array('gl_report_id'=>$gl_report_id);
		$this->db->trans_begin();
		$this->model_gl->delete_report_setup($param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function ajax_get_report_setup()
	{
		$gl_report_id = $this->input->post('gl_report_id');
		$data = $this->model_gl->get_row_report_setup($gl_report_id);

		echo json_encode($data);
	}

	public function edit_report_setup()
	{
		$gl_report_id = $this->input->post('gl_report_id');
		$report_code = $this->input->post('report_code');
		$report_name = $this->input->post('report_name');
		$report_type = $this->input->post('report_type');

		$data = array(
				'report_code'=>$report_code,
				'report_name'=>$report_name,
				'report_type'=>$report_type
			);
		$param = array('gl_report_id'=>$gl_report_id);

		$this->db->trans_begin();
		$this->model_gl->update_report_setup($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->Db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/* REPORT ITEM */

	public function datatable_report_item_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','item_code','item_name', 'item_type', 'posisi','');
		$report_code = @$_GET['report_code'];
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 */

		$rResult 			= $this->model_gl->datatable_report_item_setup($report_code,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_report_item_setup($report_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_report_item_setup($report_code); // get number of all data
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
			if($aRow['item_type']=="0"){
				$aRow['item_type'] = "TITLE";
			}else if($aRow['item_type']=="1"){
				$aRow['item_type'] = "SUMMARY";
			}else if($aRow['item_type']=="2"){
				$aRow['item_type'] = "FORMULA";
			}else if($aRow['item_type']=="3"){
				$aRow['item_type'] = "TOTAL";
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['gl_report_item_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['item_code'];
			$row[] = $aRow['item_name'];
			$row[] = $aRow['item_type'];
			$row[] = 'Posisi '.$aRow['posisi'];
			$row[] = '<div style="text-align:center;"><a href="#dialog_edit_report_item" data-toggle="modal"  gl_report_item_id="'.$aRow['gl_report_item_id'].'" id="link-edit" class="btn mini purple"><i class="icon-edit"></i> Edit</a> &nbsp; <a href="javascript:void(0);" class="btn mini blue-stripe" item_name="'.$aRow['item_name'].'" gl_report_item_id="'.$aRow['gl_report_item_id'].'" id="link-show-item-member">Account</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	// add item
	public function add_report_item_setup()
	{
		$report_code = $this->input->post('report_code');
		$item_code = $this->input->post('item_code');
		$item_name = $this->input->post('item_name');
		$item_type = $this->input->post('item_type');
		$posisi = $this->input->post('posisi');
		$display_saldo = $this->input->post('display_saldo');
		$formula = $this->input->post('formula');
		$formula_text_bold = $this->input->post('formula_text_bold');

		$data = array(
				'gl_report_item_id'=>uuid(false),
				'report_code'=>$report_code,
				'item_code'=>$item_code,
				'item_name'=>$item_name,
				'item_type'=>$item_type,
				'posisi'=>$posisi,
				'display_saldo'=>$display_saldo,
				'formula'=>($item_type=='2')?$formula:NULL,
				'formula_text_bold'=>($item_type=='2')?$formula_text_bold:NULL
			);

		$this->db->trans_begin();
		$this->model_gl->add_report_item_setup($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->Db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	function do_upload_report_setup()
	{
		$userfile = @$_FILES['userfile'];
		$report_code = $this->input->post('report_code_v2');
		$file_name = $userfile['name'];
		$return = array('success'=>true,'file_name'=>$file_name);

		// Desired folder structure
		// $now = date("m-Y");
		$structure = './assets/data_setup_report/';

		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (file_exists($structure)==false) {
			if (!mkdir($structure, 0777, true)) {
				$return = array('success'=>false,'error'=>'Failed to create folder.');
			    // die('Failed to create folders...');
			}
		}
		// END Folder Condition

		$config['upload_path'] = $structure;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']	= '500000';

		$this->load->library('upload', $config);
		$this->load->library('phpexcel');

		if ( ! $this->upload->do_upload())
		{
			$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
		}
		else
		{
			//** DELETING
			$xquery = $this->db->query("SELECT gl_report_item_id FROM mfi_gl_report_item WHERE report_code='$report_code'");
			foreach($xquery->result_array() as $list)
			{
				$gl_report_item_id = $list['gl_report_item_id'];
				$del_param1 = array('gl_report_item_id' => $gl_report_item_id );
				$this->db->delete('mfi_gl_report_item_member',$del_param1);
			}

			$del_param2 = array('report_code' => $report_code );
			$this->db->delete('mfi_gl_report_item',$del_param2);
			//** END DELETING

			$upload_data = $this->upload->data();
			try {
				$objPHPExcel = @PHPExcel_IOFactory::load($structure.$upload_data['file_name']);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$file_exists = true;
			} catch (Exception $e) {
				$file_exists = false;
			}

			if ($file_exists) {
				for($i=2; $i <= count($sheetData); $i++)
				{
					$item_code 		= $sheetData[$i]['A'];
					$item_name 		= $sheetData[$i]['B'];
					$item_type 		= $sheetData[$i]['C'];
					$posisi	   		= $sheetData[$i]['D'];
					$display_saldo	= $sheetData[$i]['E'];
					$account_code	= $sheetData[$i]['F'];
					
					$gl_report_item_id = uuid(false);
					$data = array(
							'gl_report_item_id'=>$gl_report_item_id,
							'report_code'=>$report_code,
							'item_code'=>$item_code,
							'item_name'=>ltrim($item_name," "),
							'item_type'=>$item_type,
							'posisi'=>$posisi,
							'display_saldo'=>$display_saldo,
							'formula'=>($item_type=='2')?$formula:NULL,
							'formula_text_bold'=>($item_type=='2')?$formula_text_bold:NULL
						);

					$this->db->trans_begin();
					$this->model_gl->add_report_item_setup($data);

					if($account_code):
						$arr = explode(',', $account_code);
						for($x=0; $x<count($arr); $x++){
							$_account_code = $arr[$x];

							$squery = "SELECT  mfi_gl_account.account_code, mfi_gl_account.account_name FROM mfi_gl_account WHERE account_code LIKE '$_account_code%'";
							$dquery = $this->db->query($squery);
							if($dquery->num_rows() > 0){
								foreach($dquery->result_array() as $row)
								{
									$account_code_ = $row['account_code'];
									$show = $this->db->query("SELECT * FROM mfi_gl_report_item_member WHERE account_code='$account_code_' AND gl_report_item_id='$gl_report_item_id'")->num_rows();
									if($show==0){
										$ins_data = array(
													'gl_report_item_member'	=> uuid(false),
													'account_code'			=> $account_code_,
													'gl_report_item_id'		=> $gl_report_item_id
												);
										$this->db->insert('mfi_gl_report_item_member',$ins_data);
									}
								}
							}
						}
					endif;
				}

				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}
			}
		}

		echo json_encode($return);
	}

	public function delete_report_item_setup()
	{
		$gl_report_item_id = $this->input->post('gl_report_item_id');

		for ( $i = 0 ; $i < count($gl_report_item_id) ; $i++ ){
			if (trim($gl_report_item_id[$i])!="") {
				$param = array('gl_report_item_id'=>$gl_report_item_id[$i]);
				$this->db->trans_begin();
				$this->model_gl->delete_report_item_setup($param);
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

	// get ajax report item
	public function ajax_get_report_item_setup()
	{
		$gl_report_item_id = $this->input->post('gl_report_item_id');
		$data = $this->model_gl->get_row_report_item_setup($gl_report_item_id);

		echo json_encode($data);
	}

	// edit report item
	public function edit_report_item_setup()
	{
		$gl_report_item_id = $this->input->post('gl_report_item_id');
		$item_code = $this->input->post('item_code');
		$item_name = $this->input->post('item_name');
		$item_type = $this->input->post('item_type');
		$posisi = $this->input->post('posisi');
		$display_saldo = $this->input->post('display_saldo');
		$formula = $this->input->post('formula');
		$formula_text_bold = $this->input->post('formula_text_bold');

		$data = array(
				'item_code'=>$item_code,
				'item_name'=>$item_name,
				'item_type'=>$item_type,
				'posisi'=>$posisi,
				'display_saldo'=>$display_saldo,
				'formula'=>($item_type=='2')?$formula:NULL,
				'formula_text_bold'=>($item_type=='2')?$formula_text_bold:NULL
			);
		$param = array('gl_report_item_id'=>$gl_report_item_id);

		$this->db->trans_begin();
		$this->model_gl->update_report_item_setup($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->Db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	/* report item member */

	public function datatable_report_item_member_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','account_code','account_name');
		$gl_report_item_id = @$_GET['gl_report_item_id'];
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}

		/* 
		 * Filtering
		 */
		$account_type  = $_GET['sort_account_type'];
		$account_code  = $_GET['sort_account_code'];

		$rResult 			= $this->model_gl->datatable_report_item_member_setup($gl_report_item_id,$sOrder,$sLimit,$account_type,$account_code); // query get data to view
		$rResultFilterTotal = $this->model_gl->datatable_report_item_member_setup($gl_report_item_id,'','',$account_type,$account_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_gl->datatable_report_item_member_setup($gl_report_item_id,'','',$account_type,$account_code); // get number of all data
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

			if($aRow['count']>0){
				$row[] = '<input type="checkbox" value="'.$aRow['account_code'].'" id="checkbox" class="checkboxes" checked>';
			}else{
				if($account_code != "selected"){
					$row[] = '<input type="checkbox" value="'.$aRow['account_code'].'" id="checkbox" class="checkboxes" >';
				}
			}

			if($account_code == "selected")
			{
				if($aRow['count']>0){
					$row[] = $aRow['account_code'];
					$row[] = $aRow['account_name'];
				}
			}else{
				$row[] = $aRow['account_code'];
				$row[] = $aRow['account_name'];
			}


			if($account_code == "selected")
			{
				if($aRow['count']>0){
			
					$output['aaData'][] = $row;
				}
			
			}else{

				$output['aaData'][] = $row;
			
			}
		}
		
		echo json_encode( $output );
	}

	// save report item member
	public function save_report_item_member_setup()
	{
		$account_code = $this->input->post('account_code');
		$gl_report_item_id = $this->input->post('gl_report_item_id');
		$push_update = $this->input->post('push_update');
		
		$del_param = array('gl_report_item_id' => $gl_report_item_id );
		$ins_data = array();
		for ( $i = 0 ; $i < count($account_code) ; $i++ ){
			if($account_code[$i]!="")
				$ins_data[] = array('gl_report_item_member'=>uuid(false),'account_code'=>$account_code[$i],'gl_report_item_id'=>$gl_report_item_id);
		}

		$this->db->trans_begin();

		if($push_update==0){
			$this->model_gl->delete_report_item_member($del_param);
			if(count($ins_data)>0){
				$this->model_gl->insert_report_item_member($ins_data);
			}
		}else if($push_update==1){
			if(count($ins_data)>0){
				$this->model_gl->insert_report_item_member($ins_data);
			}
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

	function report_setup_v2()
	{
		$data['title'] = 'Report Setup V2';
		$data['container'] = 'gl/report_setup_v2';
		$this->load->view('core',$data);
	}
	function jqgrid_gl_report()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'data_peserta_id';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_gl->jqgrid_gl_report('','','','');

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_gl->jqgrid_gl_report($sidx,$sord,$limit_rows,$start);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id'] = $row['gl_report_id'];
			$responce['rows'][$i]['cell'] = array(
				 $row['gl_report_id']
				,$row['report_code']
				,$row['report_name']
				,$row['report_type']
			);
			$i++;
		}

		echo json_encode($responce);
	}
	function jqgrid_gl_report_item()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'data_peserta_id';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$report_code = isset($_REQUEST['report_code'])?$_REQUEST['report_code']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_gl->jqgrid_gl_report_item('','','','',$report_code);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_gl->jqgrid_gl_report_item($sidx,$sord,$limit_rows,$start,$report_code);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['gl_report_item_id'] = $row['gl_report_item_id'];
			$responce['rows'][$i]['cell'] = array(
				 $row['gl_report_item_id']
				,$row['report_code']
				,$row['item_code']
				,$row['item_name']
				,$row['item_type']
				,$row['posisi']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	function jqgrid_gl_report_item_member_out()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'data_peserta_id';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$gl_report_item_id = isset($_REQUEST['gl_report_item_id'])?$_REQUEST['gl_report_item_id']:'';
		$account_type = isset($_REQUEST['account_type'])?$_REQUEST['account_type']:'all';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_gl->jqgrid_gl_report_item_member_out('','','','',$gl_report_item_id,$account_type);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_gl->jqgrid_gl_report_item_member_out($sidx,$sord,$limit_rows,$start,$gl_report_item_id,$account_type);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['account_code'] = $row['account_code'];
			$responce['rows'][$i]['cell'] = array(
				 $row['account_code']
				,$row['account_name']
			);
			$i++;
		}

		echo json_encode($responce);
	}
	function jqgrid_gl_report_item_member_in()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'data_peserta_id';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$gl_report_item_id = isset($_REQUEST['gl_report_item_id'])?$_REQUEST['gl_report_item_id']:'';
		$account_type = isset($_REQUEST['account_type'])?$_REQUEST['account_type']:'all';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_gl->jqgrid_gl_report_item_member_in('','','','',$gl_report_item_id,$account_type);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_gl->jqgrid_gl_report_item_member_in($sidx,$sord,$limit_rows,$start,$gl_report_item_id,$account_type);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['gl_report_item_member'] = $row['gl_report_item_member'];
			$responce['rows'][$i]['cell'] = array(
				 $row['gl_report_item_member']
				,$row['account_code']
				,$row['account_name']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	function insert_item_member_gl_report()
	{
		$debug=false;

		$accounts = $this->input->post('accounts');
		$gl_report_item_id = $this->input->post('gl_report_item_id');

		$row = array();
		for ($i=0;$i<count($accounts);$i++) {
			$account_code=$accounts[$i];
			$row[] = array(
					'gl_report_item_id'=>$gl_report_item_id,
					'account_code'=>$account_code
				);
		}

		if ($debug==true) {
			echo "<pre>";
			print_r($row);
			die();
		} else {
			$this->db->trans_begin();
			$this->model_gl->insert_gl_report_item_member($row);
			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();
				$return = array('success'=>true);
			} else {
				$this->db->trans_rollback();
				$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
			}

			echo json_encode($return);
		}
	}

	function remove_item_member_gl_report()
	{
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->model_gl->delete_gl_report_item_member($id);
		if ($this->db->trans_status()===TRUE) {
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
		}

		echo json_encode($return);
	}

}

/* End of file gl.php */
/* Location: ./application/controllers/gl.php */