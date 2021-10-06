<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends GMN_Controller {

	/**
	 * Halaman untuk mengatur System Administrator
	 */
	private $_salt = 'microfinance';

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model("model_administration");
		$this->load->model("model_core");
		$this->gallery_path = realpath(APPPATH . '../assets/img/profile');

	}

	public function index()
	{
		$data['container'] = 'dashboard';
		$this->load->view('core',$data);
	}

	// ------------------------------------------------------------------------------------------
	// BEGIN USER SETUP
	// ------------------------------------------------------------------------------------------

	public function user_setup()
	{
		$data['roles'] 		= $this->model_core->get_role();
		$data['branchs'] 	= $this->model_core->get_branch();
		$data['datas'] 		= $this->model_core->get_user();
		$data['jabatan'] 	= $this->model_core->get_jabatan();
		$data['deviceID'] 	= getDeviceID();
		$data['container'] 	= 'administration/user_setup';
		$this->load->view('core',$data);
	}

	public function add_user()
	{
		$username 			= $this->input->post('username');
		$password 			= $this->input->post('password');
		$fullname 			= $this->input->post('fullname');
		$role 				= $this->input->post('role');
		$branch_code 		= $this->input->post('branch_code');
		$kode_jabatan 		= $this->input->post('kode_jabatan');
		$flag_all_branch 	= $this->input->post('flag_all_branch');

		$data = array(
				'username'			=> $username,
				'fullname'			=> $fullname,
				'password'			=> sha1($password.$this->_salt),
				'role_id' 			=> $role,
				'branch_code' 		=> $branch_code,
				'flag_all_branch' 	=> $flag_all_branch,
				'kode_jabatan' 		=> $kode_jabatan,
				'status'  			=> 0,
				'created_stamp'		=> date('Y-m-d H:i:s')
			);

		// upload
		if ( count($_FILES) > 0 )
		{
			$config['upload_path'] 		= './assets/img/profile/';
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['max_size']			= '1000';
			$config['encrypt_name']		= true;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile'))
			{
				$return = array('success'=>false,'message'=>$this->upload->display_errors());
			}
			else
			{
				$datas = array('upload_data' => $this->upload->data());

				$config2['image_library'] 	= 'gd2';
				$config2['source_image'] 	= './assets/img/profile/'.$datas['upload_data']['file_name'];
				$config2['new_image'] 		= './assets/img/profile/thumb/'.$datas['upload_data']['file_name'];
				$config2['create_thumb'] 	= TRUE;
				$config2['maintain_ratio'] 	= TRUE;
				$config2['thumb_marker'] 	= '';
				$config2['width'] 			= 75;
				$config2['height'] 			= 50;

				$this->load->library('image_lib', $config2);

				$this->image_lib->resize();

				$data['photo'] = $datas['upload_data']['file_name'];

				$this->db->trans_begin();
				$this->model_core->add_user($data);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$return = array('success'=>true);
				}else{
					$this->db->trans_rollback();
					$return = array('success'=>false);
				}
			}
		}
		else
		{
			$this->db->trans_begin();
			$this->model_core->add_user($data);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}

		echo json_encode($return);
	}

	public function get_user_by_user_id()
	{
		$user_id = $this->input->post('user_id');
		$data = $this->model_core->get_user_by_user_id($user_id);

		echo json_encode($data);
	}

	public function get_user_device()
	{
		$user_id = $this->input->post('user_id');
		$data = $this->model_core->get_user_device($user_id);

		echo json_encode($data);
	}

	public function edit_user()
	{
		$user_id 			= $this->input->post('user_id');
		$username 			= $this->input->post('username');
		$fullname 			= $this->input->post('fullname');
		$password 			= $this->input->post('password');
		$role 				= $this->input->post('role');
		$flag_all_branch 	= $this->input->post('flag_all_branch');
		$branch_code 		= $this->input->post('branch_code');
		$kode_jabatan 		= $this->input->post('kode_jabatan');
		$deviceID 			= $this->input->post('deviceID');

		$param = array('user_id'=>$user_id);
		$data = array(
				'username'			=> $username,
				'fullname'			=> $fullname,
				'role_id' 			=> $role,
				'flag_all_branch'	=> $flag_all_branch,
				'kode_jabatan'		=> $kode_jabatan,
				'branch_code'		=> $branch_code
			);

		if ( $password != "" )
			$data['password'] = sha1($password.$this->_salt);

		$this->db->trans_begin();
		$this->model_core->edit_user($data,$param);
		if(deviceID){ $this->model_core->save_device($deviceID,$user_id); }
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function delete_user()
	{
		$user_id = $this->input->post('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($user_id) ; $i++ )
		{
			$data = $this->model_core->get_user_by_user_id($user_id[$i]);
			$photo = $data['photo'];

			@unlink('./assets/img/profile/'.$photo);
			@unlink('./assets/img/profile/thumb/'.$photo);

			$param = array('user_id'=>$user_id[$i]);
			$this->db->trans_begin();
			$this->model_core->delete_user($param);
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

	public function activate_user()
	{
		$user_id = $this->input->post('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($user_id) ; $i++ )
		{
			$data = array('status'=>1);
			$param = array('user_id'=>$user_id[$i]);
			
			$this->db->trans_begin();
			$this->model_core->edit_user($data,$param);
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

	public function inactivate_user()
	{
		$user_id = $this->input->post('user_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($user_id) ; $i++ )
		{
			$data = array('status'=>0);
			$param = array('user_id'=>$user_id[$i]);

			$this->db->trans_begin();
			$this->model_core->edit_user($data,$param);
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

	public function set_device_list()
	{
		$val = $this->input->post('val');
		
		$success = 0;
		$failed = 0;
		$this->db->trans_begin();

		if($val == 'lock'){
			$this->db->where('device_id', 'free');
			$this->db->delete('mfi_user_device_list');
		}else{
			$data = array("device_id"=>"free");
			$this->db->insert('mfi_user_device_list', $data);
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$success=1;
		}else{
			$this->db->trans_rollback();
			$failed=1;
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}

	public function datatable_user_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','username','fullname', 'role_name', 'branch_name', '','');
				
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

		$rResult 			= $this->model_administration->datatable_user_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_user_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_user_setup(); // get number of all data
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
			if($aRow['status']==1){
			  $aRow['status'] = 'Active';
			  $label_class = 'success';
			}else{
			  $aRow['status'] = 'Inactive';
			  $label_class = 'important';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['user_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['username'];
			$row[] = $aRow['fullname'];
			$row[] = $aRow['role_name'];
			$row[] = ($aRow['flag_all_branch']=="1")?"All Branch":$aRow['branch_name'];
			$row[] = '<span class="label label-'.$label_class.'">'.$aRow['status'].'</span>';
			$row[] = '<a href="javascript:;" user_id="'.$aRow['user_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	// ------------------------------------------------------------------------------------------
	// END USER SETUP
	// ------------------------------------------------------------------------------------------





	// ------------------------------------------------------------------------------------------
	// BEGIN MENU SETUP
	// ------------------------------------------------------------------------------------------

	public function menu_setup()
	{
		$data['container'] = 'administration/menu_setup';
		$this->load->view('core',$data);
	}

	public function datatable_menu_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '', 'menu_id', 'menu_parent', 'menu_title', 'menu_url', 'menu_flag_link', 'menu_icon_parent', '' );

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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." as VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
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
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." as VARCHAR) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_administration->datatable_menu_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_menu_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_menu_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['menu_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['menu_id'];
			$row[] = $aRow['menu_parent2'];
			$row[] = $aRow['menu_title'];
			$row[] = $aRow['menu_url'];
			$row[] = $aRow['menu_flag_link'];
			$row[] = $aRow['menu_icon_parent'];
			$row[] = '<a href="javascript:;" menu_id="'.$aRow['menu_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_menu_parent()
	{
		$data = $this->model_administration->get_menu_parent();

		echo json_encode($data);
	}

	public function add_menu()
	{
		$menu_parent 		= $this->input->post('menu_parent');
		$menu_title 		= $this->input->post('menu_title');
		$menu_url 			= $this->input->post('menu_url');
		$menu_flag_link 	= $this->input->post('menu_flag_link');
		$menu_icon_parent 	= $this->input->post('menu_icon_parent');

		if ( $menu_parent == '' )
			$menu_parent = 0;
		
		$new_position = $this->model_administration->get_new_position_menu($menu_parent);
		$menu_id = $this->model_administration->get_new_menu_id();

		$data = array(
				'menu_id' 			=> $menu_id,
				'menu_parent' 		=> $menu_parent,
				'menu_title' 		=> $menu_title,
				'menu_url' 			=> $menu_url,
				'menu_flag_link' 	=> $menu_flag_link,
				'menu_icon_parent' 	=> $menu_icon_parent,
				'position' 			=> $new_position
			);

		$this->db->trans_begin();
		$this->model_administration->add_menu($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);

	}

	public function delete_menu()
	{
		$menu_id = $this->input->post('menu_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($menu_id) ; $i++ )
		{
			$param = array('menu_id'=>$menu_id[$i]);
			$this->db->trans_begin();
			$this->model_administration->delete_menu($param);
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

	public function get_menu_by_menu_id()
	{
		$menu_id 	= $this->input->post('menu_id');
		$data 		= $this->model_administration->get_menu_by_menu_id($menu_id);

		echo json_encode($data);
	}

	public function edit_menu()
	{
		$menu_id 			= $this->input->post('menu_id');
		$menu_parent 		= $this->input->post('menu_parent');
		$menu_title 		= $this->input->post('menu_title');
		$menu_url 			= $this->input->post('menu_url');
		$menu_flag_link 	= $this->input->post('menu_flag_link');
		$menu_icon_parent 	= $this->input->post('menu_icon_parent');

		if ( $menu_parent == '' )
			$menu_parent = 0;

		$param = array('menu_id'=>$menu_id);
		$data = array(
				'menu_parent'		=> $menu_parent,
				'menu_title' 		=> $menu_title,
				'menu_url' 			=> $menu_url,
				'menu_flag_link' 	=> $menu_flag_link,
				'menu_icon_parent' 	=> $menu_icon_parent
			);

		$this->db->trans_begin();
		$this->model_administration->edit_menu($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	// ------------------------------------------------------------------------------------------
	// END MENU SETUP
	// ------------------------------------------------------------------------------------------





	// ------------------------------------------------------------------------------------------
	// BEGIN USER ROLE SETUP
	// ------------------------------------------------------------------------------------------

	public function user_role_setup()
	{
		$data['roles'] 		= $this->model_core->get_role();
		$data['datas'] 		= $this->model_core->get_user();
		$data['container'] 	= 'administration/user_role_setup';
		$this->load->view('core',$data);
	}

	public function datatable_user_role_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','role_name', 'role_desc','','');
				
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
		else
		{
			$sWhere = " where role_id not in ('42','43')";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' AND role_id not in ('42','43')";
				}
			}
		}

		$rResult 			= $this->model_administration->datatable_user_role_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_user_role_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_user_role_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['role_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['role_name'];
			$row[] = $aRow['role_desc'];
			$row[] = '<center><a href="javascript:;" role_id="'.$aRow['role_id'].'" id="link-edit">Edit</a></center>';
			$row[] = '<center><a href="javascript:;" role_id="'.$aRow['role_id'].'" id="link-edit-priviledge">Edit Priviledge</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_role_by_role_id()
	{
		$role_id = $this->input->post('role_id');
		$data = $this->model_administration->get_role_by_role_id($role_id);

		echo json_encode($data);
	}

	public function add_role()
	{
		$role_name = $this->input->post('role_name');
		$role_desc = $this->input->post('role_desc');

		$data = array(
				'role_name'		=> $role_name,
				'role_desc' 	=> $role_desc,
				'created_by'  	=> $this->session->userdata('user_id'),
				'created_stamp'	=> date('Y-m-d H:i:s')
			);

		$this->db->trans_begin();
		$this->model_administration->add_role($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_role()
	{
		$role_id = $this->input->post('role_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($role_id) ; $i++ )
		{
			$param = array('role_id'=>$role_id[$i]);
			$this->db->trans_begin();
			$this->model_administration->delete_user_nav($param);
			$this->model_administration->delete_role($param);
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

	public function edit_role()
	{
		$role_id 		= $this->input->post('role_id');
		$role_name 		= $this->input->post('role_name');
		$role_desc 		= $this->input->post('role_desc');

		$param = array('role_id'=>$role_id);
		$data = array(
				'role_name'	=> $role_name,
				'role_desc' => $role_desc
			);

		$this->db->trans_begin();
		$this->model_administration->edit_role($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function get_menu_by_role()
	{
		$role_id = $this->input->post('role_id');

		$menuroleparent = $this->model_administration->get_menu_parent_by_role($role_id);
		
		$menu = '<ol>';

		foreach($menuroleparent as $parent)
		{
			$parent_is = '';
			if ( $parent['role_id'] != "" )
				$parent_is = ' checked="checked"';

			$menu .= '<li>
					    <input type="checkbox" name="menu_id[]" id="parent"'.$parent_is.' value="'.$parent['menu_id'].'"> '.$parent['menu_title'];

		    $menurolechild = $this->model_administration->get_menu_child_by_role($role_id,$parent['menu_id']);

		    if ( count($menurolechild) > 0 )
		    	$menu .= '<ol>';

		    foreach($menurolechild as $child)
		    {

		    	$menurolegrandchild = $this->model_administration->get_menu_child_by_role($role_id,$child['menu_id']);

				$child_is = '';
				if ( $child['role_id'] != "" )
					$child_is = ' checked="checked"';

		    	$menu .= '<li>
					    	<input type="checkbox" name="menu_id[]" id="child"'.$child_is.' value="'.$child['menu_id'].'"> '.$child['menu_title'];

			    if ( count($menurolegrandchild) > 0 )
			    	$menu .= '<ol>';

			    foreach($menurolegrandchild as $grandchild)
		    	{
					$grandchild_is = '';
					if ( $grandchild['role_id'] != "" )
						$grandchild_is = ' checked="checked"';

				    $menu .= '<li><input type="checkbox" name="menu_id[]" id="grandchild"'.$grandchild_is.' value="'.$grandchild['menu_id'].'"> '.$grandchild['menu_title'].'</li>';
				}

				if ( count($menurolegrandchild) > 0 )
		    		$menu .= '</ol>';

				$menu .= '</li>';
		    }

		    if ( count($menurolechild) > 0 )
		    	$menu .= '</ol>';

			$menu .= '					    
					  </li>';
		}

		$menu .= '</ol>';

		echo $menu;
	}

	public function edit_role_priviledge()
	{
		$role_id = $this->input->post('role_id');
		$menu_id = $this->input->post('menu_id');
		
		$data_batch = array();

		for ( $i = 0 ; $i < count($menu_id) ; $i++ )
		{
			$data_batch[] = array(
					'role_id' => $role_id,
					'menu_id' => $menu_id[$i]
				);
		}

		$param_delete = array('role_id'=>$role_id);
		
		$this->db->trans_begin();
		$this->model_administration->delete_user_nav($param_delete);
		if ( $this->db->trans_status() === true )
		{
			$this->db->trans_commit();

			if ( count($data_batch) > 0 )
			{
				$this->db->trans_begin();
				$this->model_administration->insert_batch_user_nav($data_batch);
				if ( $this->db->trans_status() === true )
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
				$return = array('success'=>true);
			}

		}
		else
		{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	// ------------------------------------------------------------------------------------------
	// END USER ROLE SETUP
	// ------------------------------------------------------------------------------------------

	// ------------------------------------------------------------------------------------------
	// USER APPROVAL SPB
	// ------------------------------------------------------------------------------------------
	public function user_approval_spb()
	{
		$data['container'] 	= 'administration/user_approval_spb';
		$this->load->view('core',$data);
	}

	public function datatable_user_approval_spb()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		// $aColumns = array( '','role_name', 'role_desc','','');
		// $aColumns = array( '','', '','','');
				
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
		else
		{
			// $sWhere = " where role_id not in ('42','43')";
			$sWhere = " ";
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' AND role_id not in ('42','43')";
				}
			}
		}

		$rResult 			= $this->model_administration->datatable_user_approval_spb($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_user_approval_spb($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_user_approval_spb(); // get number of all data
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
		
		$i=1;
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = "<center>".$i."</center>";
			$row[] = $aRow['username'];
			$row[] = $aRow['fullname'];
			$row[] = $aRow['nama_jabatan'];
			$row[] = $aRow['code_group'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" code_detail_id="'.$aRow['list_code_detail_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
			$i++;
		}
		
		echo json_encode( $output );
	}

	// ------------------------------------------------------------------------------------------
	// END USER APPROVAL SPB
	// ------------------------------------------------------------------------------------------

	public function change_position_menu()
	{
		$data = $this->input->post('data');
		
		$n1 = 1;
		foreach ( $data as $key_parent => $val_parent )
		{
			/*[BEGIN] UPDATE KE DATABASE*/
			$data_parent = array('position'=>$n1,'menu_parent'=>0);
			$param_parent = array('menu_id'=>$val_parent['id']);
			$this->db->trans_begin();
			$this->model_administration->edit_menu($data_parent,$param_parent);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
			}else{
				$this->db->trans_rollback();
			}
			/*[END] UPDATE KE DATABASE*/

			$n2 = 1;

			if( isset ( $val_parent['children'] ) )
			{
				foreach ( $val_parent['children'] as $key_child => $val_child )
				{
					$n3 = 1;

					/*[BEGIN] UPDATE KE DATABASE*/
					$data_child = array('position'=>$n2,'menu_parent'=>$val_parent['id']);
					$param_child = array('menu_id'=>$val_child['id']);
					$this->db->trans_begin();
					$this->model_administration->edit_menu($data_child,$param_child);
					if($this->db->trans_status()===true){
						$this->db->trans_commit();
					}else{
						$this->db->trans_rollback();
					}
					/*[END] UPDATE KE DATABASE*/

					if( isset ( $val_child['children'] ) )
					{
						foreach ( $val_child['children'] as $key_grandchild => $val_grandchild )
						{
							/*[BEGIN] UPDATE KE DATABASE*/
							$data_grandchild = array('position'=>$n3,'menu_parent'=>$val_child['id']);
							$param_grandchild = array('menu_id'=>$val_grandchild['id']);
							$this->db->trans_begin();
							$this->model_administration->edit_menu($data_grandchild,$param_grandchild);
							if($this->db->trans_status()===true){
								$this->db->trans_commit();
							}else{
								$this->db->trans_rollback();
							}
							/*[END] UPDATE KE DATABASE*/

							$n3++;
						}
					}

					$n2++;
				}
			}

			$n1++;
		}
	}

	public function get_menu_position()
	{
		$role_id = $this->session->userdata('role_id');

		$html = '
		<div class="dd" id="menu">
			<ol class="dd-list">';

        $menu = $this->model_core->get_menu_position(0);

        for ( $i = 0 ; $i < count($menu) ; $i++ )
        {

        $html .= '
              <li class="dd-item dd3-item" data-id="'.$menu[$i]['menu_id'].'">
                 <div class="dd-handle dd3-handle"></div>
                 <div class="dd3-content">'.$menu[$i]['menu_title'].'</div>';
        
        $childmenu = $this->model_core->get_menu_position($menu[$i]['menu_id']);

        if ( count($childmenu) > 0 )
        $html .= '  <ol class="dd-list">';

        for ( $j = 0 ; $j < count($childmenu) ; $j++ )
        {

        $html .= '  <li class="dd-item dd3-item" data-id="'.$childmenu[$j]['menu_id'].'">
                       <div class="dd-handle dd3-handle"></div>
                       <div class="dd3-content">'.$childmenu[$j]['menu_title'].'</div>';
        
        $grandchildmenu = $this->model_core->get_menu_position($childmenu[$j]['menu_id']);

        if ( count($grandchildmenu) > 0 )
        $html .= '     <ol class="dd-list">';
		
    	for ( $k = 0 ; $k < count($grandchildmenu) ; $k++ )
    	{

		$html .= '     		<li class="dd-item dd3-item" data-id="'.$grandchildmenu[$k]['menu_id'].'">
		                       <div class="dd-handle dd3-handle"></div>
		                       <div class="dd3-content">'.$grandchildmenu[$k]['menu_title'].'</div>
		                    </li>';
		
        }

        if ( count($grandchildmenu) > 0 )
		$html .= '      </ol>';
        
        $html .= '  </li>';
        
        }

        if ( count($childmenu) > 0 )
        $html .= '
                 </ol>';


        $html .= '
              </li>';
        
        }

        $html .= '
			</ol>
		</div>
		';

		echo $html;
	}

	//BEGIN PROFILE SETUP
	public function profile_setup()
	{
		$user_id 			= $this->uri->segment(3);
		$data 				= $this->model_core->get_user_by_user_id($user_id);
		$data['container'] 	= 'administration/profile_setup';
		$this->load->view('core',$data);
	}

	public function edit_profile()
	{
	    $user_id  		= $this->input->post('user_id');
		$username 		= $this->input->post('username');
		$fullname 		= $this->input->post('fullname');
		$password 		= $this->input->post('password');
		$role_id  		= $this->session->userdata('role_id');
		$branch_code  	= $this->session->userdata('branch_code');
	    $foto_lama		= $this->input->post('foto');
		$userfile 		= @$_FILES['userfile'];
	   
	   if($userfile['name']!="")
	   {	   
		    //rename
	   		$nama_file_foto = str_replace(' ', '-', strtoupper($fullname));
	   	
			//hapus foto lama
			@unlink($this->gallery_path . '/'.$foto_lama);
			@unlink($this->gallery_path . '/thumb/'.$foto_lama);
			//end hapus foto lama
		   
		    //upload images
			$userfile = @$_FILES['userfile'];
			$ext = pathinfo(@$userfile['name'], PATHINFO_EXTENSION);
			$file_name = $nama_file_foto.'.'.$ext;

			
			$config = array(
							 'allowed_types'=>'jpg|jpeg|gif|png',
							 'upload_path' 	=> $this->gallery_path,
							 'file_name' 	=> $file_name,
							 'max_size' 	=> 5000
							);
			 
			$this->load->library('upload',$config);
				$this->upload->do_upload();
				$image_data = $this->upload->data();
			 
			$config = array(
							 'source_image'		=> $image_data['full_path'],
							 'new_image'		=>$this->gallery_path . '/' . $file_name,
							 'new_image'		=>$this->gallery_path . '/thumb/' . $file_name,
							 'maintain_ration'	=>true,
							 'width'			=>160,
							 'master_dim' 		=> 'width',
							 'height'			=>120
							);
			 
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//end upload images
		

		$param = array('user_id'=>$user_id);
		$data = array(
				'username'		=> $username,
				'fullname'		=> $fullname,
				'photo'	  		=> $file_name,
				'role_id' 		=> $role_id,
				'branch_code' 	=> $branch_code
			);
		if ( $password != "" )
			$data['password'] = sha1($password.$this->_salt);

		$this->db->trans_begin();
		$this->model_core->edit_profile($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,
							'photo'=>$data['photo']
					);
			$this->session->set_userdata('photo',$data['photo']);
			$this->session->set_userdata('fullname',$fullname);
			}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
			}
		
		}
		else
		{
			
			$param = array('user_id'=>$user_id);
			$data = array(
					'username'		=> $username,
					'fullname'		=> $fullname,
					'role_id' 		=> $role_id,
					'branch_code' 	=> $branch_code
				);

			if ( $password != "" )
			$data['password'] = sha1($password.$this->_salt);

			$this->db->trans_begin();
			$this->model_core->edit_profile($data,$param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$return = array('success'=>true,
								'photo'=>$foto_lama
					);
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false);
			}
		}	


		echo json_encode($return);
		//END PROFILE SETUP
	}

	/* CHANGE THEMES ******************************************/

	public function change_themes()
	{
		$themes 	= $this->input->post('themes');
		$data 		= array('themes'=>$themes);
		$param 		= array('user_id'=>$this->session->userdata('user_id'));

		$this->db->trans_begin();
		$this->model_administration->change_themes($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_userdata('themes',$themes);
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	

	// cari user by keyword

	public function ajax_get_user_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$branch_code = $this->input->post('branch_code');

		$data = $this->model_core->get_user_by_user_keyword($keyword,$branch_code);

		echo json_encode($data);
	}

	//Setup Margin


	public function datatable_setup_margin()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','item','top_margin', 'bottom_margin', 'left_margin', 'right_margin','');
				
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
					$sWhere .= "LOWER(mfi_setup_margin_buku_tab.".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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

		$rResult 			= $this->model_administration->datatable_setup_margin($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_setup_margin($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_setup_margin(); // get number of all data
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
			if($row[] = $aRow['item']=="no"){
				$item = "No";
			}else if($row[] = $aRow['item']=="trx_date"){
				$item = "Tanggal Transaksi";
			}else if($row[] = $aRow['item']=="type"){
				$item = "Kode Transaksi";
			}else if($row[] = $aRow['item']=="debet"){
				$item = "Debet";
			}else if($row[] = $aRow['item']=="credit"){
				$item = "Credit";
			}else if($row[] = $aRow['item']=="saldo"){
				$item = "Saldo";
			}else{
				$item = "User ID";
			}	
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['setup_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $item;
			$row[] = $aRow['top_margin'].' Pixels';
			$row[] = $aRow['bottom_margin'].' Pixels';
			$row[] = $aRow['left_margin'].' Pixels';
			$row[] = $aRow['right_margin'].' Pixels';
			$row[] = '<a href="javascript:;" setup_id="'.$aRow['setup_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_margin_setup()
	{
		$institution_name 	= $this->session->userdata('institution_name');
		$branch_code 		= $this->session->userdata('branch_code');
		$item 				= $this->input->post('item');
		$top 				= $this->input->post('top');
		$bottom 			= $this->input->post('bottom');
		$left 				= $this->input->post('left');
		$right 				= $this->input->post('right');
		$posisi 			= $this->input->post('posisi');

		$data = array(
				'item'				=> $item,
				'top_margin'		=> $top,
				'bottom_margin'		=> $bottom,
				'left_margin'		=> $left,
				'right_margin'		=> $right,
				'institution_name'	=> $institution_name,
				'branch_code'		=> $branch_code,
				'posisi'			=> $posisi
			);

		$this->db->trans_begin();
		$this->model_administration->add_margin_setup($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_margin_setup_by_id()
	{
		$setup_id 	= $this->input->post('setup_id');
		$data 		= $this->model_administration->get_margin_setup_by_id($setup_id);

		echo json_encode($data);
	}


	public function delete_margin_setup()
	{
		$setup_id = $this->input->post('setup_id');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($setup_id) ; $i++) 
		{ 
			$param = array('setup_id' =>$setup_id[$i]);
			$this->db->trans_begin();
			$this->model_administration->delete_margin_setup($param);
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
			$return = array('succes'=>true,'num_success'=>$success,'num_failed'=>$failed);
		}

		echo json_encode($return);
	}


	public function edit_margin_setup()
	{
		$setup_id 				= $this->input->post('setup_id');
		$institution_name 		= $this->session->userdata('institution_name');
		$branch_code 			= $this->session->userdata('branch_code');
		// $item 					= $this->input->post('item');
		$top 					= $this->input->post('top');
		$bottom 				= $this->input->post('bottom');
		$left 					= $this->input->post('left');
		$right 					= $this->input->post('right');

		$data = array(
				// 'item'				=> $item,
				'top_margin'		=> $top,
				'bottom_margin'		=> $bottom,
				'left_margin'		=> $left,
				'right_margin'		=> $right,
				'institution_name'	=> $institution_name,
				'branch_code'		=> $branch_code
			);

		$param = array('setup_id'=>$setup_id);

		$this->db->trans_begin();
		$this->model_administration->edit_margin_setup($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function check_no_in_setup_margin()
	{
		$no  = $this->input->post('no');

		if($no=="no"){
			$item = "No.";
		}else if($no=="trx_date"){
			$item = "Transaction Date";
		}else if($no=="type"){
			$item = "Transaction Code";
		}else if($no=="debet"){
			$item = "Debet";
		}else if($no=="credit"){
			$item = "Credit";
		}else if($no=="saldo"){
			$item = "Saldo";
		}else{
			$item = "User ID";
		}

		$no_ = $this->model_administration->check_no_in_setup_margin($no);

		if($no_==true){
			$return = array('stat'=>true,'message'=>"Item $item is not exists in database.");
		}else{
			$return = array('stat'=>false,'message'=>"Item $item already exists in database. You only allowed to update the item $item");
		}

		echo json_encode($return);

	}


	// ------------------------------------------------------------------------------------------
	// BEGIN USER KOPEGTEL SETUP
	// ------------------------------------------------------------------------------------------

	public function kopegtel_user()
	{
		$data['roles'] 		= $this->model_core->get_role_kopegtel();
		$data['branchs'] 	= $this->model_core->get_branch();
		$data['datas'] 		= $this->model_core->get_user();
		$data['jabatan'] 	= $this->model_core->get_jabatan();
		$data['container'] 	= 'administration/kopegtel_user';
		$this->load->view('core',$data);
	}

	public function datatable_user_kopegtel_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','username','fullname', 'role_name', 'branch_name', '','');
				
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
		else
		{
			$sWhere = "where mfi_user.role_id = '43'";
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

		$rResult 			= $this->model_administration->datatable_user_kopegtel_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_administration->datatable_user_kopegtel_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_administration->datatable_user_kopegtel_setup(); // get number of all data
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
			if($aRow['status']==1){
			  $aRow['status'] = 'Active';
			  $label_class = 'success';
			}else{
			  $aRow['status'] = 'Inactive';
			  $label_class = 'important';
			}

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['user_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['username'];
			$row[] = $aRow['fullname'];
			$row[] = $aRow['role_name'];
			$row[] = ($aRow['flag_all_branch']=="1")?"All Branch":$aRow['branch_name'];
			$row[] = '<span class="label label-'.$label_class.'">'.$aRow['status'].'</span>';
			$row[] = '<a href="javascript:;" user_id="'.$aRow['user_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function search_username_kopegtel()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_administration->search_username_kopegtel($keyword);

		echo json_encode($data);
	}
	// ------------------------------------------------------------------------------------------
	// END USER KOPEGTEL SETUP
	// ------------------------------------------------------------------------------------------


}

/* End of file administration.php */
/* Location: ./application/controllers/administration.php */