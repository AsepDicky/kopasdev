<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kantor_layanan extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_kantor_layanan');
		$this->load->model('model_product');
		$this->load->library('phpexcel');
	}

	/****************************************************************************************/	
	// BEGIN KANTOR CABANG
	/****************************************************************************************/
	public function kantor_cabang()
	{
		$data['container'] = 'kantor_layanan/branch_kantor_cabang';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch();
		$data['jabatan'] = $this->model_kantor_layanan->get_all_jabatan();
		$data['branch_class_login'] = $this->model_kantor_layanan->get_branch_class_login($this->session->userdata('branch_code'));
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END KANTOR CABANG
	/****************************************************************************************/

	// ------------------------------------------------------------------------------------------
	// BEGIN REMBUG SETUP
	// ------------------------------------------------------------------------------------------
	public function rembug_setup()
	{
		$data['container'] = 'kantor_layanan/rembug_setup';
		$data['branch_id'] = $this->session->userdata('branch_id');
		$data['branch_code'] = $this->session->userdata('branch_code');
		//$data['cabang'] = $this->model_cif->get_all_branch_();
		$data['petugas'] = $this->model_kantor_layanan->get_all_petugas();
		$data['kecamatan'] = $this->model_kantor_layanan->get_kecamatan();
		$data['branch'] = $this->model_kantor_layanan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REMBUG SETUP
	/****************************************************************************************/

	// [BEGIN] PETUGAS LAPANGAN SETUP

	public function petugas_lapangan()
	{
		$data['container'] = 'kantor_layanan/petugas_lapangan';
		$data['cabang'] = $this->model_kantor_layanan->get_all_branch_by_parent();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}
	// [END] PETUGAS LAPANGAN SETUP


	// [BEGIN] DESA
	public function desa()
	{
		$data['container'] = 'kantor_layanan/desa';
		$data['kecamatan'] = $this->model_kantor_layanan->get_kecamatan();
		$data['city'] = $this->model_kantor_layanan->get_city();
		$this->load->view('core', $data);
	}
	// [END] DESA


	// [BEGIN] KECAMATAN
	public function kecamatan()
	{
		$data['container'] = 'kantor_layanan/kecamatan';
		$data['city'] = $this->model_kantor_layanan->get_city();
		$this->load->view('core', $data);
	}

	// [END] KECAMATAN

	// [BEGIN] KABUPATEN
	public function kabupaten()
	{
		$data['container'] = 'kantor_layanan/kabupaten';
		$data['province'] = $this->model_kantor_layanan->get_province();
		$this->load->view('core', $data);
	}
	// [END] KABUPATEN

	/*
	Identitas Lembaga
	Ujang Irawan
	30 September 2014
	*/

	public function lembaga()
	{
		$data = $this->model_kantor_layanan->get_lembaga();
		$data['container'] = 'kantor_layanan/identitas_lembaga';
		$this->load->view('core',$data);
	}

	public function edit_lembaga()
	{
		$institution_name = $this->input->post('institution_name');
		// $officer_name = $this->input->post('officer_name');
		// $officer_title = $this->input->post('officer_title');
		$alamat = $this->input->post('alamat');
		// $cadangan = $this->input->post('cadangan');
		// $titipan_notaris = $this->input->post('titipan_notaris');
		$cif_type = $this->input->post('cif_type');

		$data = array(
				'institution_name' => $institution_name,
				// 'officer_name' => $officer_name,
				// 'officer_title' => $officer_title,
				'alamat' => $alamat,
				'cif_type' => $cif_type
				// 'cadangan' => $cadangan,
				// 'titipan_notaris' => $this->convert_numeric($titipan_notaris)
			);

		$this->db->trans_begin();
		$this->model_kantor_layanan->edit_lembaga($data);
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
	| Sayyid Nurkilah
	| 04 November 2014
	| Resort Setup
	*/
	public function resort_setup()
	{
		$data['container'] = 'kantor_layanan/resort_setup';
		$data['current_date'] = date('d/m/Y',strtotime($this->current_date()));
		$data['title'] = "Resort Setup";
		$this->load->view('core',$data);
	}

	public function datatable_resort_setup()
	{
		$branch_code=@$_GET['branch_code'];
		$aColumns = array( '','resort_code','resort_name','tgl_pembentukan','');
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $aColumns[$i] != '' ){
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
					if ( $sWhere == "" ){
						$sWhere = "WHERE ";
					}else{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_kantor_layanan->datatable_resort($sWhere,$sOrder,$sLimit,$branch_code); // query get data to view
		$rResultFilterTotal = $this->model_kantor_layanan->datatable_resort($sWhere,'','',$branch_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kantor_layanan->datatable_resort('','','',$branch_code); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['resort_id'].'" id="checkbox" class="checkboxes">';
			$row[] = $aRow['resort_code'];
			$row[] = $aRow['resort_name'];
			$row[] = '<div align="center">'.date('d/m/Y',strtotime($aRow['tgl_pembentukan'])).'</div>';
			$row[] = '<div style="white-space:nowrap;text-align:center;"><a href="javascript:void(0);" data-resortid="'.$aRow['resort_id'].'" class="btn mini purple" id="link-edit">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	function get_resort_code_by_branch()
	{
		$branch_code=$this->input->post('branch_code');
		$resort=$this->model_kantor_layanan->get_max_resort_code_by_branch($branch_code);
		$sequence=($resort+1);
		$sequence=str_pad($sequence, 3,'0',STR_PAD_LEFT);
		$resort_code=$branch_code.$sequence;
		$return=array('resort_code'=>$resort_code);
		echo json_encode($return);
	}
	function add_resort_setup()
	{
		$branch_code=$this->input->post('add_branch_code');
		$resort_code=$this->input->post('resort_code');
		$resort_name=$this->input->post('resort_name');
		$tanggal_pembentukan=$this->input->post('tanggal_pembentukan');
		$data=array(
				'branch_code'=>$branch_code,
				'resort_code'=>$resort_code,
				'resort_name'=>$resort_name,
				'tgl_pembentukan'=>$this->datepicker_convert(true,$tanggal_pembentukan,'/'),
				'created_timestamp'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id')
			);
		
		$this->db->trans_begin();
		$this->model_kantor_layanan->insert_resort_setup($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return=array('success'=>false);
		}
		echo json_encode($return);
	}
	function get_resort_by_id()
	{
		$resortid=$this->input->post('resortid');
		$data=$this->model_kantor_layanan->get_resort_by_id($resortid);
		echo json_encode($data);
	}
	function edit_resort_setup()
	{
		$resortid=$this->input->post('resortid');
		$resort_name=$this->input->post('resort_name');
		$tanggal_pembentukan=$this->input->post('tanggal_pembentukan');
		$data=array(
				'resort_name'=>$resort_name,
				'tgl_pembentukan'=>$this->datepicker_convert(true,$tanggal_pembentukan,'/')
			);
		$param=array('resort_id'=>$resortid);

		$this->db->trans_begin();
		$this->model_kantor_layanan->update_resort_setup($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return=array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return=array('success'=>false);
		}
		echo json_encode($return);
	}
	/**
	* UPLOAD DATA PEGAWAI
	* @author SAYYID NURKILAH
	*/
	function upload_data_pegawai()
	{
		$data['container'] = 'kantor_layanan/upload_data_pegawai';
		$data['title'] = "Upload Data Pegawai";

		$sql = "SELECT 1 FROM mfi_pegawai_temp";
		$data['pegawai_temp'] = $this->db->query($sql)->num_rows();

		$this->load->view('core',$data);
	}
	function FormatDateExcel($date)
	{
		if (date('Y-m-d',strtotime($date))=='1970-01-01') {
			$list_month = array(
					'Jan'=>'01'
					,'Feb'=>'02'
					,'Mar'=>'03'
					,'Apr'=>'04'
					,'May'=>'05'
					,'Jun'=>'06'
					,'Jul'=>'07'
					,'Aug'=>'08'
					,'Sep'=>'09'
					,'Oct'=>'10'
					,'Nov'=>'11'
					,'Dec'=>'12'
				);
			$exp = explode('-',$date);
			$day = $exp[1];
			$month = $exp[0];//$list_month[$exp[1]];
			$year = '19'.$exp[2];
			return $year.'-'.$month.'-'.$day;
		} else {
			return date('Y-m-d',strtotime($date));
		}
	}
	function do_upload_data_pegawai()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		set_time_limit(0);
		
		$date = date('Y-m-d H:i:s');
		$name = $_FILES['userfile']['name'];
		$type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$error = $_FILES['userfile']['error'];
		$size = $_FILES['userfile']['size'];

		if(empty($type)){
			$return = array('success'=>'false','error'=>"File Type : " .$type);
			echo json_encode($return);
			exit;
		}
		
		$sql = "SELECT 1 FROM mfi_pegawai_temp";
		if($this->db->query($sql)->num_rows() > 0){
			$return = array('success'=>'false','error'=>'Lakukan singkronikasi terlebih dahulu!');
			echo json_encode($return);
			exit;
		}

		if (isset($_FILES['userfile'])) {
			
			switch ($type) {
				case 'application/msexcel':
				case 'application/vnd.ms-excel':
				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

				if ($size>100000000000) {

					$return = array('success'=>'false','error'=>'file size must be less than 100Mb');

				} else {

					try {
						$objPHPExcel = PHPExcel_IOFactory::load($tmp_name);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$file_exists = true;
					} catch (Exception $e) {
						$file_exists = false;
					}

					if ($file_exists) {

						$getHighestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
						if($getHighestColumn > 45000){
							$return = array('success'=>'false','error'=>'Maksimum row 45rb row (untuk menghemat resiko <i>crash</i> data). Lakukan upload data secara bertahap.');
							echo json_encode($return);
							exit;
						}

						if($sheetData[1]['A'] != '469e1d5cba5a6780d84ffdb3c8f8f138'){
							$return = array('success'=>'false','error'=>'Template tidak sesuai, mohon upload terlebih dahulu!');
							echo json_encode($return);
							exit;
						}

						$row = array();
						$i=0;
						foreach ($sheetData as $data) {

							if ($i>1) {

								$msglen = false;
								if ($data['K']=='') {
									$tgl_mulai_kerja = NULL;
								} else {
									if(strlen($data['K']) < 6){
										$return = array('success'=>'false','error'=>'Format <b>TglMliKerja</b> salah!');
										echo json_encode($return);
										exit;
									}

									$tgl_mulai_kerja = $this->FormatDateExcel($data['K']);
								}

								if ($data['Q']=='') {
									$tgl_lahir = NULL;
								} else {
									if(strlen($data['Q']) < 6){
										$return = array('success'=>'false','error'=>'Format <b>TGLLAHIR</b> salah!');
										echo json_encode($return);
										exit;
									}
									
									$tgl_lahir = $this->FormatDateExcel($data['Q']);
								}

								if ($data['S']=='') {
									$tgl_capeg = NULL;
								} else {
									if(strlen($data['S']) < 6){
										$return = array('success'=>'false','error'=>'Format <b>TGLCAPEG</b> salah!');
										echo json_encode($return);
										exit;
									}

									$tgl_capeg = $this->FormatDateExcel($data['S']);
								}

								if ($data['T']=='') {
									$tgl_pensiun_normal = NULL;
								} else {
									if(strlen($data['T']) < 6){
										$return = array('success'=>'false','error'=>'Format <b>TglPensiunNorm</b> salah!');
										echo json_encode($return);
										exit;
									}

									$tgl_pensiun_normal = $this->FormatDateExcel($data['T']);
								}

								$rplc_perum = array("- ", "-", " ");
								$perumahan = str_replace($rplc_perum, "", $data['Z']);
								$koptel = str_replace($rplc_perum, "", $data['AA']);

								$row[] = array(
									 'nik' => $data['A']
									,'nama_pegawai' => htmlentities($data['B'])
									,'personal_area' => $data['C']
									,'psa' => $data['D']
									,'vpsa' => htmlentities($data['E'])
									,'code_divisi' => $data['F']
									,'kode_loker' => $data['H']
									,'loker' => $data['I']
									,'posisi' => htmlentities($data['J'])
									,'tgl_mulai_kerja' => $tgl_mulai_kerja
									,'kerja_bantu' => htmlentities($data['M'])
									,'band' => htmlentities($data['N'])
									,'klas' => (htmlentities($data['O'])) ? htmlentities($data['O']) : ""
									,'tempat_lahir' => htmlentities($data['P'])
									,'tgl_lahir' => $tgl_lahir
									,'gender' => $data['R']
									,'tgl_capeg' => $tgl_capeg
									,'tgl_pensiun_normal' => $tgl_pensiun_normal
									,'alamat' => $data['U']
									,'kota' => $data['V']
									,'status' => htmlentities($data['W'])
									,'agama' => $data['X']
									,'gadas' => ($data['AD']) ? $data['AD'] : 0
									,'perumahan' => ($perumahan) ? $perumahan : 0
									,'koptel' => ($koptel) ? $koptel : 0
									,'thp' => ($data['AG']) ? $data['AG'] : 0
									,'pegawai_id' => uuid(false)
									,'status_telkom' => ($data['AI']) ? $data['AI'] : ''
								);
							}

							$i++;

						}

						$log = array(
								'file'=>$name,
								'file_type'=>$type,
								'file_size'=>$size,
								'upload_date'=>$date,
								'upload_by'=>$this->session->userdata('user_id')
							);

						$this->db->trans_begin();
						$this->db->insert('mfi_log_upload_pegawai',$log);
						if (count($row)>0) $this->db->insert_batch('mfi_pegawai_temp',$row);

						if ($this->db->trans_status()) {
							$this->db->trans_commit();
							$return = array('success'=>'true');
						} else {
							$this->db->trans_rollback();
							$return = array('success'=>'false','error'=>'Failed to connect into databases, please contact your administrator.');
						}

					} else {

						$return = array('success'=>'false','error'=>'File does not exist. maybe permission to the path of file is denied');

					}

				}

				break;
				
				default:
				$return = array('success'=>'false','error'=>'wrong file type. file type should use the extension .xls and .xlsx only');
				break;
			}

		} else {

			$return = array('success'=>'false','error'=>'no selected file.');

		}

		echo json_encode($return);
	}

	public function execute_pegawai_temp()
	{
		$this->db->trans_begin();
		$sql = "UPDATE mfi_pegawai set 
				 nik=mfi_pegawai_temp.nik
				,nama_pegawai=mfi_pegawai_temp.nama_pegawai
				,personal_area=mfi_pegawai_temp.personal_area
				,psa=mfi_pegawai_temp.psa
				,vpsa=mfi_pegawai_temp.vpsa
				,code_divisi=mfi_pegawai_temp.code_divisi
				,kode_loker=mfi_pegawai_temp.kode_loker
				,loker=mfi_pegawai_temp.loker
				,kode_posisi=mfi_pegawai_temp.kode_posisi
				,posisi=mfi_pegawai_temp.posisi
				,tgl_mulai_kerja=mfi_pegawai_temp.tgl_mulai_kerja
				,kerja_bantu=mfi_pegawai_temp.kerja_bantu
				,band=mfi_pegawai_temp.band
				,klas=mfi_pegawai_temp.klas
				,tempat_lahir=mfi_pegawai_temp.tempat_lahir
				,tgl_lahir=mfi_pegawai_temp.tgl_lahir
				,gender=mfi_pegawai_temp.gender
				,tgl_capeg=mfi_pegawai_temp.tgl_capeg
				,tgl_pensiun_normal=mfi_pegawai_temp.tgl_pensiun_normal
				,alamat=mfi_pegawai_temp.alamat
				,kota=mfi_pegawai_temp.kota
				,status=mfi_pegawai_temp.status
				,agama=mfi_pegawai_temp.agama
				,gadas=mfi_pegawai_temp.gadas
				,perumahan=mfi_pegawai_temp.perumahan
				,koptel=mfi_pegawai_temp.koptel
				,thp=mfi_pegawai_temp.thp
				,pegawai_id=mfi_pegawai_temp.pegawai_id
				,nama_pasangan=mfi_pegawai_temp.nama_pasangan
				,pekerjaan_pasangan=mfi_pegawai_temp.pekerjaan_pasangan
				,jumlah_tanggungan=mfi_pegawai_temp.jumlah_tanggungan
				,status_telkom=mfi_pegawai_temp.status_telkom
			from mfi_pegawai_temp
			where mfi_pegawai_temp.nik = mfi_pegawai.nik;
			
			insert into mfi_pegawai
			select * from mfi_pegawai_temp
			where nik not in(select nik from mfi_pegawai)
			";
			$this->db->query($sql);
			$this->db->query("
				INSERT into mfi_cif (cif_no,nama,panggilan,branch_code,status,cif_type)
					select nik,nama_pegawai,nama_pegawai,'00000','1','1'
					from mfi_pegawai
					where nik not in (select cif_no from mfi_cif)
			");
			$this->db->query("INSERT into mfi_account_saving (product_code,cif_no,account_saving_no,branch_code,tanggal_buka,status_rekening,saldo_riil,saldo_memo,created_by,created_date,counter_angsruan)
			select '09',cif_no,cif_no,branch_code,now(),1,0,0,'SYS',now(),0 from mfi_cif 
			where cif_no not in(select cif_no from mfi_account_saving where product_code='09')");
			$this->db->truncate('mfi_pegawai_temp');
			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();
				$this->db->truncate('mfi_pegawai_temp');
				$return = array('success'=>true);
			} else {
				$this->db->trans_rollback();
				$return = array('success'=>false,'error'=>'Failed to connect into databases, please contact your administrator.');
			}
		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN CATEGORY
	/****************************************************************************************/
	public function list_category()
	{
		$data['container']  = 'kantor_layanan/list_category';
		$data['list_category']	= $this->model_product->function_select_all('mfi_list_code');
		$this->load->view('core',$data);
	}

	function get_lists_code()
	{
		$lists = $this->model_product->function_select_all('mfi_list_code');
		echo json_encode($lists);
	}

	public function datatable_list_category()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','list_code_id','code_description','code_group','');
				
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
		$rResult 			= $this->model_product->datatable_list_category($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_list_category($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_list_category(); // get number of all data
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

			$row[] = '<input type="checkbox" value="'.$aRow['list_code_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_description'];
			$row[] = $aRow['code_group'];
			$row[] = '<center><a href="javascript:;" class="btn mini purple" list_code_id="'.$aRow['list_code_id'].'" id="link-edit"><i class="icon-pencil"></i></a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_list_category()
	{
		$code_description 		= $this->input->post('code_description');
		$code_group 			= $this->input->post('code_group');
		
			$data = array(
				 'code_description'			=>$code_description
				,'code_group'				=>$code_group
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_list_code',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_list_category_by_list_code_id()
	{
		$list_code_id 		= $this->input->post('list_code_id');
		$data 				= $this->model_product->get_list_category_by_list_code_id($list_code_id);

		echo json_encode($data);
	}

	public function edit_list_category()
	{
		$list_code_id 			= $this->input->post('list_code_id');
		$code_description 		= $this->input->post('code_description');
		$code_group 			= $this->input->post('code_group');

			$param = array('list_code_id'=>$list_code_id);
			$data = array(
				 'code_description'			=>$code_description
				,'code_group'				=>$code_group
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_list_code',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_list_category()
	{
		$list_code_id = $this->input->post('list_code_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_id) ; $i++ )
		{
			$param = array('list_code_id'=>$list_code_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_list_code',$param);
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
	// END CATEGORY
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN DETAIL CATEGORY
	/****************************************************************************************/	

	public function datatable_detail_list_category()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','code_group','code_value','display_text','');
				
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
		$rResult 			= $this->model_product->datatable_detail_list_category($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_product->datatable_detail_list_category($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_product->datatable_detail_list_category(); // get number of all data
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

			$row[] = '<input type="checkbox" value="'.$aRow['list_code_detail_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_group'];
			$row[] = $aRow['code_value'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" class="btn mini purple" list_code_detail_id="'.$aRow['list_code_detail_id'].'" id="link-edit2"><i class="icon-pencil"></i></a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	

	public function add_detail_list_category()
	{
		$code_group 		= $this->input->post('code_group');
		$code_value 		= $this->input->post('code_value');
		$display_text 		= $this->input->post('display_text');
		
			$data = array(
				 'code_group'			=>$code_group
				,'code_value'			=>$code_value
				,'display_text'			=>$display_text
				);

		$this->db->trans_begin();
		$this->model_product->function_insert('mfi_list_code_detail',$data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}	

	public function get_detail_list_category_by_list_code_id()
	{
		$list_code_id_detail 		= $this->input->post('list_code_detail_id');
		$data 				= $this->model_product->get_detail_list_category_by_list_code_id($list_code_id_detail);

		echo json_encode($data);
	}

	public function edit_detail_list_category()
	{
		$list_code_detail_id 	= $this->input->post('list_code_detail_id');
		$code_group 			= $this->input->post('code_group');
		$code_value 			= $this->input->post('code_value');
		$display_text 			= $this->input->post('display_text');

			$param = array('list_code_detail_id'=>$list_code_detail_id);
			$data = array(
				 'code_group'			=>$code_group
				,'code_value'			=>$code_value
				,'display_text'			=>$display_text
				);
		
		

		$this->db->trans_begin();
		$this->model_product->function_update('mfi_list_code_detail',$data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_detail_list_category()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_detail_id) ; $i++ )
		{
			$param = array('list_code_detail_id'=>$list_code_detail_id[$i]);
			$this->db->trans_begin();
			$this->model_product->function_delete('mfi_list_code_detail',$param);
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
	// END DETAIL CATEGORY
	/****************************************************************************************/


	// ------------------------------------------------------------------------------------------
	// BEGIN DATA KOPEGTEL SETUP
	// ------------------------------------------------------------------------------------------

	public function data_kopegtel()
	{
		$data['roles'] 		= $this->model_core->get_role();
		$data['datas'] 		= $this->model_core->get_user();
		$data['container'] 	= 'kantor_layanan/data_kopegtel';
		$this->load->view('core',$data);
	}

	public function datatable_kopegtel()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','nama_kopegtel', 'ketua_pengurus','kopegtel_code','no_telpon','status_chaneling','');
				
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%'";
				}
			}
		}

		$rResult 			= $this->model_kantor_layanan->datatable_kopegtel($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_kantor_layanan->datatable_kopegtel($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kantor_layanan->datatable_kopegtel(); // get number of all data
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
			if($aRow['status_chaneling']=="Y"){
				$status_chaneling = "Ya";
			}else{
				$status_chaneling = "Tidak";
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['kopegtel_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['nama_kopegtel'];
			$row[] = $aRow['ketua_pengurus'];
			$row[] = $aRow['kopegtel_code'];
			$row[] = $aRow['no_telpon'];
			$row[] = $status_chaneling;
			$row[] = '<center><a href="javascript:;" kopegtel_id="'.$aRow['kopegtel_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_kopegtel_by_kopegtel_id()
	{
		$kopegtel_id = $this->input->post('kopegtel_id');
		$data = $this->model_kantor_layanan->get_kopegtel_by_kopegtel_id($kopegtel_id);

		echo json_encode($data);
	}

	public function add_kopegtel()
	{
		$nama_kopegtel = $this->input->post('nama_kopegtel');
		$wilayah = $this->input->post('wilayah');
		$alamat = $this->input->post('alamat');
		$ketua_pengurus = $this->input->post('ketua_pengurus');
		$jabatan = $this->input->post('jabatan');
		$nik = $this->input->post('nik');
		$deskripsi_ketua_pengurus = $this->input->post('deskripsi_ketua_pengurus');
		$kopegtel_code = $this->input->post('kopegtel_code');
		$email = $this->input->post('email');
		$no_telp = $this->input->post('no_telp');
		$chaneling = $this->input->post('chaneling');
		$nama_bank = $this->input->post('nama_bank');
		$bank_cabang = $this->input->post('bank_cabang');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atasnama_rekening = $this->input->post('atasnama_rekening');

		$data = array(
				'nama_kopegtel' => $nama_kopegtel,
				'wilayah' => $wilayah,
				'alamat' => $alamat,
				'ketua_pengurus' => $ketua_pengurus,
				'jabatan' => $jabatan,
				'nik' => $nik,
				'deskripsi_ketua_pengurus' => $deskripsi_ketua_pengurus,
				'kopegtel_code' => $kopegtel_code,
				'email' => $email,
				'no_telpon' => $no_telp,
				'status_chaneling' => $chaneling,
				'nama_bank' => $nama_bank,
				'bank_cabang' => $bank_cabang,
				'nomor_rekening' => $nomor_rekening,
				'atasnama_rekening' => $atasnama_rekening
			);

		$this->db->trans_begin();
		$this->model_kantor_layanan->add_kopegtel($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_kopegtel()
	{
		$kopegtel_id = $this->input->post('kopegtel_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($kopegtel_id) ; $i++ )
		{
			$param = array('kopegtel_id'=>$kopegtel_id[$i]);
			$this->db->trans_begin();
			$this->model_kantor_layanan->delete_kopegtel($param);
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

	public function edit_kopegtel()
	{
		$kopegtel_id = $this->input->post('kopegtel_id');
		$nama_kopegtel = $this->input->post('nama_kopegtel');
		$wilayah = $this->input->post('wilayah');
		$alamat = $this->input->post('alamat');
		$ketua_pengurus = $this->input->post('ketua_pengurus');
		$jabatan = $this->input->post('jabatan');
		$nik = $this->input->post('nik');
		$deskripsi_ketua_pengurus = $this->input->post('deskripsi_ketua_pengurus');
		$kopegtel_code = $this->input->post('kopegtel_code');
		$email = $this->input->post('email');
		$no_telp = $this->input->post('no_telp');
		$chaneling = $this->input->post('chaneling');
		$nama_bank = $this->input->post('nama_bank');
		$bank_cabang = $this->input->post('bank_cabang');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atasnama_rekening = $this->input->post('atasnama_rekening');

		$data = array(
				'nama_kopegtel' => $nama_kopegtel,
				'wilayah' => $wilayah,
				'alamat' => $alamat,
				'ketua_pengurus' => $ketua_pengurus,
				'jabatan' => $jabatan,
				'nik' => $nik,
				'deskripsi_ketua_pengurus' => $deskripsi_ketua_pengurus,
				'kopegtel_code' => $kopegtel_code,
				'email' => $email,
				'no_telpon' => $no_telp,
				'status_chaneling' => $chaneling,
				'nama_bank' => $nama_bank,
				'bank_cabang' => $bank_cabang,
				'nomor_rekening' => $nomor_rekening,
				'atasnama_rekening' => $atasnama_rekening
			);

		$param = array('kopegtel_id'=>$kopegtel_id);

		$this->db->trans_begin();
		$this->model_kantor_layanan->edit_kopegtel($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	function download_pegawai_pensiun()
	{
		$data['container'] = 'kantor_layanan/download_pegawai_pensiun';
		$data['title'] = "download pegawai pensiun";
		$this->load->view('core',$data);
	}

	// ------------------------------------------------------------------------------------------
	// END DATA KOPEGTEL SETUP
	// ------------------------------------------------------------------------------------------

	
}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */