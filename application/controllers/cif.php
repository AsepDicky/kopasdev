<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cif extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_cif');
		$this->load->model('model_kelompok');
		$this->load->model('model_transaction');
	}

	// [BEGIN] CIF KELOMPOK 

	public function cif_kelompok()
	{
		$data['container'] 				= 'cif/cif_kelompok';
		// $data['branch'] 				= $this->model_cif->get_all_branch();
		$data['branch'] 				= $this->session->userdata('branch_id');
		$institution 					= $this->model_cif->get_institution();
		$data['default_setoran_lwk'] 	= $institution['setoran_lwk'];
		$data['default_minggon'] 		= $institution['minggon'];
		$data['current_date'] 			= $this->current_date();
		$this->load->view('core',$data);
	}

	public function add_cif_kelompok()
	{
		$cm_code 								= $this->input->post('add_cm_code');
		$step1_cif_no 							= $this->input->post('step1_cif_no');
	    $step1_tanggal_gabung 					= str_replace('/','',$this->input->post('step1_tanggal_gabung'));
	    $step1_tanggal_gabung 					= substr($step1_tanggal_gabung,4,4).'-'.substr($step1_tanggal_gabung,2,2).'-'.substr($step1_tanggal_gabung,0,2);
	    $step1_nama 							= $this->input->post('step1_nama');
	    $step1_panggilan 						= $this->input->post('step1_panggilan');
	    $step1_kelompok 						= $this->input->post('step1_kelompok');
	    $step1_setoran_lwk 						= $this->convert_numeric($this->input->post('step1_setoran_lwk'));
	    $step1_setoran_mingguan 				= $this->convert_numeric($this->input->post('step1_setoran_mingguan'));
	    $step2_pribadi_jenis_kelamin 			= $this->input->post('step2_pribadi_jenis_kelamin');
	    $step2_pribadi_ibu_kandung 				= $this->input->post('step2_pribadi_ibu_kandung');
	    $step2_pribadi_tmp_lahir 				= $this->input->post('step2_pribadi_tmp_lahir');
	    $step2_pribadi_tgl_lahir 				= $this->input->post('step2_pribadi_tgl_lahir');
	    $step2_pribadi_tgl_lahir 				= STR_REPLACE('/','',$step2_pribadi_tgl_lahir);
	    $step2_pribadi_tgl_lahir 				= substr($step2_pribadi_tgl_lahir,4,4).'-'.substr($step2_pribadi_tgl_lahir,2,2).'-'.substr($step2_pribadi_tgl_lahir,0,2);
	    $step2_pribadi_usia 					= $this->input->post('step2_pribadi_usia');
	    $step2_pribadi_alamat 					= $this->input->post('step2_pribadi_alamat');
	    $step2_pribadi_rt 						= $this->input->post('step2_pribadi_rt');
	    $step2_pribadi_rw 						= $this->input->post('step2_pribadi_rw');
	    $step2_pribadi_desa 					= $this->input->post('step2_pribadi_desa');
	    $step2_pribadi_kecamatan 				= $this->input->post('step2_pribadi_kecamatan');
	    $step2_pribadi_kabupaten 				= $this->input->post('step2_pribadi_kabupaten');
	    $step2_pribadi_kodepos 					= $this->input->post('step2_pribadi_kodepos');
	    $step2_pribadi_koresponden_alamat 		= $this->input->post('step2_pribadi_koresponden_alamat');
	    $step2_pribadi_koresponden_rt 			= $this->input->post('step2_pribadi_koresponden_rt');
	    $step2_pribadi_koresponden_rw 			= $this->input->post('step2_pribadi_koresponden_rw');
	    $step2_pribadi_koresponden_desa 		= $this->input->post('step2_pribadi_koresponden_desa');
	    $step2_pribadi_koresponden_kecamatan 	= $this->input->post('step2_pribadi_koresponden_kecamatan');
	    $step2_pribadi_koresponden_kabupaten 	= $this->input->post('step2_pribadi_koresponden_kabupaten');
	    $step2_pribadi_koresponden_kodepos 		= $this->input->post('step2_pribadi_koresponden_kodepos');
	    $step2_pribadi_pendidikan 				= $this->input->post('step2_pribadi_pendidikan');
	    $step2_pribadi_pekerjaan 				= $this->input->post('step2_pribadi_pekerjaan');
	    $step2_pribadi_pendapatan 				= $this->convert_numeric($this->input->post('step2_pribadi_pendapatan'));
	    $step2_pribadi_ket_pekerjaan 			= $this->input->post('step2_pribadi_ket_pekerjaan');
	    $step2_pribadi_literasi_latin 			= $this->input->post('step2_pribadi_literasi_latin');
	    $step2_pribadi_literasi_arab 			= $this->input->post('step2_pribadi_literasi_arab');
		$step2_pasangan_nama 					= $this->input->post('step2_pasangan_nama');
	    $step2_pasangan_tmplahir 				= $this->input->post('step2_pasangan_tmplahir');
	    $step2_pasangan_tglahir 				= $this->input->post('step2_pasangan_tglahir');
	    $step2_pasangan_tglahir 				= STR_REPLACE('/','',$step2_pasangan_tglahir);
	    $step2_pasangan_tglahir 				= substr($step2_pasangan_tglahir,4,4).'-'.substr($step2_pasangan_tglahir,2,2).'-'.substr($step2_pasangan_tglahir,0,2);
	    $step2_pasangan_usia 					= $this->input->post('step2_pasangan_usia');
	    $step2_pasangan_pendidikan 				= $this->input->post('step2_pasangan_pendidikan');
	    $step2_pasangan_pekerjaan 				= $this->input->post('step2_pasangan_pekerjaan');
	    $step2_pasangan_pendapatan 				= $this->convert_numeric($this->input->post('step2_pasangan_pendapatan'));
	    $step2_pasangan_ketpekerjaan 			= $this->input->post('step2_pasangan_ketpekerjaan');
	    $step2_pasangan_jmlkeluarga 			= $this->input->post('step2_pasangan_jmlkeluarga');
	    $step2_pasangan_jmltanggungan 			= $this->input->post('step2_pasangan_jmltanggungan');
	    $step2_pasangan_literasi_latin 			= $this->input->post('step2_pasangan_literasi_latin');
	    $step2_pasangan_literasi_arab 			= $this->input->post('step2_pasangan_literasi_arab');
	    $step3_rmhstatus 						= $this->input->post('step3_rmhstatus');
	    $step3_rmhukuran 						= $this->input->post('step3_rmhukuran');
	    $step3_rmhdinding 						= $this->input->post('step3_rmhdinding');
	    $step3_rmhatap 							= $this->input->post('step3_rmhatap');
	    $step3_rmhlantai 						= $this->input->post('step3_rmhlantai');
	    $step3_rmhjamban 						= $this->input->post('step3_rmhjamban');
	    $step3_rmhair 							= $this->input->post('step3_rmhair');
	    $step3_lahansawah 						= $this->input->post('step3_lahansawah');
	    $step3_lahankebun 						= $this->input->post('step3_lahankebun');
	    $step3_lahanpekarangan 					= $this->input->post('step3_lahanpekarangan');
	    $step3_ternakunggas 					= $this->input->post('step3_ternakunggas');
	    $step3_ternakdomba 						= $this->input->post('step3_ternakdomba');
	    $step3_sapi_ternakkerbau 				= $this->input->post('step3_sapi_ternakkerbau');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step3_elektape 						= $this->input->post('step3_elektape');
	    $step3_elekplayer 						= $this->input->post('step3_elekplayer');
	    $step3_elektv 							= $this->input->post('step3_elektv');
	    $step3_elekkulkas 						= $this->input->post('step3_elekkulkas');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step4_ushrumahtangga 					= $this->input->post('step4_ushrumahtangga');
	    $step4_ushkomoditi 						= $this->input->post('step4_ushkomoditi');
	    $step4_ushlokasi 						= $this->input->post('step4_ushlokasi');
	    $step4_ushomset 						= $this->convert_numeric($this->input->post('step4_ushomset'));
	    $step4_byaberas 						= $this->convert_numeric($this->input->post('step4_byaberas'));
	    $step4_byadapur 						= $this->convert_numeric($this->input->post('step4_byadapur'));
	    $step4_byalistrik 						= $this->convert_numeric($this->input->post('step4_byalistrik'));
	    $step4_byatelpon 						= $this->convert_numeric($this->input->post('step4_byatelpon'));
	    $step4_byasekolah 						= $this->convert_numeric($this->input->post('step4_byasekolah'));
	    $step4_byalain 							= $this->convert_numeric($this->input->post('step4_byalain'));

	    $cif_id 								= rand(0,100000);

	    $data_cif = array(
	    		 'nama' 					=> ($step1_nama=="") ? null : $step1_nama
	    		,'cif_id' 					=> ($cif_id=="") ? null : $cif_id
	    		,'cm_code' 					=> ($cm_code=="") ? null : $cm_code
				,'tgl_gabung' 				=> ($step1_tanggal_gabung=="") ? null : $step1_tanggal_gabung
				,'panggilan' 				=> ($step1_panggilan=="") ? null : $step1_panggilan
				,'kelompok' 				=> ($step1_kelompok=="") ? null : $step1_kelompok
				,'jenis_kelamin' 			=> ($step2_pribadi_jenis_kelamin=="") ? null : $step2_pribadi_jenis_kelamin
				,'ibu_kandung' 				=> ($step2_pribadi_ibu_kandung=="") ? null : $step2_pribadi_ibu_kandung
				,'tmp_lahir' 				=> ($step2_pribadi_tmp_lahir=="") ? null : $step2_pribadi_tmp_lahir
				,'tgl_lahir' 				=> ($step2_pribadi_tgl_lahir=="--") ? null : $step2_pribadi_tgl_lahir
				,'usia' 					=> ($step2_pribadi_usia=="") ? null : $step2_pribadi_usia
				,'alamat' 					=> ($step2_pribadi_alamat=="") ? null : $step2_pribadi_alamat
				,'rt_rw' 					=> ($step2_pribadi_rt.'/'.$step2_pribadi_rw=="") ? null : $step2_pribadi_rt.'/'.$step2_pribadi_rw
				,'desa' 					=> ($step2_pribadi_desa=="") ? null : $step2_pribadi_desa
				,'kecamatan' 				=> ($step2_pribadi_kecamatan=="") ? null : $step2_pribadi_kecamatan
				,'kabupaten' 				=> ($step2_pribadi_kabupaten=="") ? null : $step2_pribadi_kabupaten
				,'kodepos' 					=> ($step2_pribadi_kodepos=="") ? null : $step2_pribadi_kodepos
				,'koresponden_alamat' 		=> ($step2_pribadi_koresponden_alamat=="") ? null : $step2_pribadi_koresponden_alamat
				,'koresponden_rt_rw' 		=>($step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw=="") ? null : $step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw
				,'koresponden_desa' 		=> ($step2_pribadi_koresponden_desa=="") ? null : $step2_pribadi_koresponden_desa
				,'koresponden_kecamatan' 	=> ($step2_pribadi_koresponden_kecamatan=="") ? null : $step2_pribadi_koresponden_kecamatan
				,'koresponden_kabupaten' 	=> ($step2_pribadi_koresponden_kabupaten=="") ? null : $step2_pribadi_koresponden_kabupaten
				,'koresponden_kodepos' 		=> ($step2_pribadi_koresponden_kodepos=="") ? null : $step2_pribadi_koresponden_kodepos
				,'pendidikan' 				=> ($step2_pribadi_pendidikan=="") ? null : $step2_pribadi_pendidikan
				,'pekerjaan' 				=> ($step2_pribadi_pekerjaan=="") ? null : $step2_pribadi_pekerjaan
				,'ket_pekerjaan' 			=> ($step2_pribadi_ket_pekerjaan=="") ? null : $step2_pribadi_ket_pekerjaan
				,'branch_code' 				=> $this->session->userdata('branch_code')
				,'cif_type' 				=> 0
				,'status' 					=> 1
	    	);
	    $data_cif_kelompok = array(
	    		 'setoran_lwk' 				=> ($step1_setoran_lwk=="")?null:$step1_setoran_lwk
	    		,'cif_id' 					=> ($cif_id=="")?null:$cif_id
	    		,'setoran_mingguan' 		=> ($step1_setoran_mingguan=="")?null:$step1_setoran_mingguan
	    		,'literasi_latin' 			=> ($step2_pribadi_literasi_latin==true) ? $step2_pribadi_literasi_latin : 0 
				,'literasi_arab' 			=> ($step2_pribadi_literasi_arab==true) ? $step2_pribadi_literasi_arab : 0 
				,'pendapatan' 				=> ($step2_pribadi_pendapatan=="")?null:$step2_pribadi_pendapatan
	    		,'p_nama' 					=> ($step2_pasangan_nama=="")?null:$step2_pasangan_nama
				,'p_tmplahir' 				=> ($step2_pasangan_tmplahir=="")?null:$step2_pasangan_tmplahir
				,'p_tglahir' 				=> ($step2_pasangan_tglahir=="--")?null:$step2_pasangan_tglahir
				,'p_usia' 					=> ($step2_pasangan_usia=="")?null:$step2_pasangan_usia
				,'p_pendidikan' 			=> ($step2_pasangan_pendidikan=="")?null:$step2_pasangan_pendidikan
				,'p_pekerjaan' 				=> ($step2_pasangan_pekerjaan=="")?null:$step2_pasangan_pekerjaan
				,'p_ketpekerjaan'			=> ($step2_pasangan_ketpekerjaan=="")?null:$step2_pasangan_ketpekerjaan
				,'p_pendapatan' 			=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_periodependapatan' 		=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_literasi_latin' 		=> ($step2_pasangan_literasi_latin==true) ? $step2_pasangan_literasi_latin : 0
				,'p_literasi_arab' 			=> ($step2_pasangan_literasi_arab==true) ? $step2_pasangan_literasi_arab : 0
				,'p_jmltanggungan' 			=> ($step2_pasangan_jmltanggungan=="")?null:$step2_pasangan_jmltanggungan
				,'p_jmlkeluarga'	 		=> ($step2_pasangan_jmlkeluarga=="")?null:$step2_pasangan_jmlkeluarga
				,'rmhstatus' 				=> ($step3_rmhstatus=="")?null:$step3_rmhstatus
				,'rmhukuran' 				=> ($step3_rmhukuran=="")?null:$step3_rmhukuran
				,'rmhatap' 					=> ($step3_rmhatap=="")?null:$step3_rmhatap
				,'rmhdinding' 				=> ($step3_rmhdinding=="")?null:$step3_rmhdinding
				,'rmhlantai' 				=> ($step3_rmhlantai=="")?null:$step3_rmhlantai
				,'rmhjamban' 				=> ($step3_rmhjamban=="")?null:$step3_rmhjamban
				,'rmhair' 					=> ($step3_rmhair=="")?null:$step3_rmhair
				,'lahansawah' 				=> ($step3_lahansawah=="")?null:$step3_lahansawah
				,'lahankebun' 				=> ($step3_lahankebun=="")?null:$step3_lahankebun
				,'lahanpekarangan' 			=> ($step3_lahanpekarangan=="")?null:$step3_lahanpekarangan
				,'ternakkerbau' 			=> ($step3_sapi_ternakkerbau=="")?null:$step3_sapi_ternakkerbau
				,'ternakdomba' 				=> ($step3_ternakdomba=="")?null:$step3_ternakdomba
				,'ternakunggas' 			=> ($step3_ternakunggas=="")?null:$step3_ternakunggas
				,'elektape' 				=> ($step3_elektape == false) ? null : $step3_elektape
				,'elektv' 					=> ($step3_elektv == false) ? null : $step3_elektv
				,'elekplayer' 				=> ($step3_elekplayer == false) ? null : $step3_elekplayer
				,'elekkulkas' 				=> ($step3_elekkulkas == false) ? null : $step3_elekkulkas
				,'kendsepeda' 				=> ($step3_kendsepeda=="")?null:$step3_kendsepeda
				,'kendmotor' 				=> ($step3_kendmotor=="")?null:$step3_kendmotor
				,'ushrumahtangga' 			=> ($step4_ushrumahtangga=="")?null:$step4_ushrumahtangga
				,'ushkomoditi' 				=> ($step4_ushkomoditi=="")?null:$step4_ushkomoditi
				,'ushlokasi' 				=> ($step4_ushlokasi=="")?null:$step4_ushlokasi
				,'ushomset' 				=> ($step4_ushomset=="")?null:$step4_ushomset
				,'byaberas' 				=> ($step4_byaberas=="")?null:$step4_byaberas
				,'byadapur' 				=> ($step4_byadapur=="")?null:$step4_byadapur
				,'byalistrik' 				=> ($step4_byalistrik=="")?null:$step4_byalistrik
				,'byatelpon' 				=> ($step4_byatelpon=="")?null:$step4_byatelpon
				,'byasekolah'	 			=> ($step4_byasekolah=="")?null:$step4_byasekolah
				,'byalain' 					=> ($step4_byalain=="")?null:$step4_byalain
	    	);
		
		$this->db->trans_begin();
		$this->model_cif->insert_cif($data_cif);
		$this->model_cif->insert_cif_kelompok($data_cif_kelompok);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Add CIF Successed!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Add CIF Failed!');
		}

		echo json_encode($return);
	}

	public function datatable_cif_kelompok()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_cif.cif_no','mfi_cif.nama', 'mfi_cm.cm_name', 'mfi_cif.kelompok','mfi_cif.status','');
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		// if($cm_code!="")
		// {
			if($sWhere==""){
				$sWhere = " WHERE mfi_cif.cm_code = '".$cm_code."' ";
			}else{
				$sWhere .= " AND mfi_cif.cm_code = '".$cm_code."' ";
			}
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
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_cif_kelompok($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_cif_kelompok($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_cif_kelompok(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['cif_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['cm_name'];
			$row[] = $aRow['kelompok'];
			if($aRow['status']==0){
				$status = '<span class="btn mini blue-stripe">register</span>';
			}else if($aRow['status']==1){
				$status = '<span class="btn mini green-stripe">aktif</span>';
			}else{
				$status = '<span class="btn mini red-stripe">tidak aktif</span>';
			}
			$row[] = $status;
			$row[] = '<a href="javascript:;" cif_id="'.$aRow['cif_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_cif_kelompok()
	{
		$cif_id = $this->input->post('cif_id');
		$data = $this->model_cif->get_cif_kelompok_by_cif_id($cif_id);

		echo json_encode($data);
	}

	public function update_cif_kelompok()
	{
		// $cm_code 							= $this->input->post('cm_code');
		$cif_id 								= $this->input->post('cif_id');
		$step1_cif_no 							= $this->input->post('step1_cif_no');
	    $step1_tanggal_gabung 					= str_replace('/','',$this->input->post('step1_tanggal_gabung'));
	    $step1_tanggal_gabung 					= substr($step1_tanggal_gabung,4,4).'-'.substr($step1_tanggal_gabung,2,2).'-'.substr($step1_tanggal_gabung,0,2);
	    $step1_nama 							= $this->input->post('step1_nama');
	    $step1_panggilan 						= $this->input->post('step1_panggilan');
	    $step1_kelompok 						= $this->input->post('step1_kelompok');
	    $step1_setoran_lwk 						= $this->convert_numeric($this->input->post('step1_setoran_lwk'));
	    $step1_setoran_mingguan 				= $this->convert_numeric($this->input->post('step1_setoran_mingguan'));
	    $step2_pribadi_jenis_kelamin 			= $this->input->post('step2_pribadi_jenis_kelamin');
	    $step2_pribadi_ibu_kandung 				= $this->input->post('step2_pribadi_ibu_kandung');
	    $step2_pribadi_tmp_lahir 				= $this->input->post('step2_pribadi_tmp_lahir');
	    $step2_pribadi_tgl_lahir 				= $this->input->post('step2_pribadi_tgl_lahir');
	    $step2_pribadi_tgl_lahir 				= str_replace('/','',$step2_pribadi_tgl_lahir);
	    $step2_pribadi_tgl_lahir 				= substr($step2_pribadi_tgl_lahir,4,4).'-'.substr($step2_pribadi_tgl_lahir,2,2).'-'.substr($step2_pribadi_tgl_lahir,0,2);
	    $step2_pribadi_usia 					= $this->input->post('step2_pribadi_usia');
	    $step2_pribadi_alamat 					= $this->input->post('step2_pribadi_alamat');
	    $step2_pribadi_rt 						= $this->input->post('step2_pribadi_rt');
	    $step2_pribadi_rw 						= $this->input->post('step2_pribadi_rw');
	    $step2_pribadi_desa 					= $this->input->post('step2_pribadi_desa');
	    $step2_pribadi_kecamatan 				= $this->input->post('step2_pribadi_kecamatan');
	    $step2_pribadi_kabupaten 				= $this->input->post('step2_pribadi_kabupaten');
	    $step2_pribadi_kodepos 					= $this->input->post('step2_pribadi_kodepos');
	    $step2_pribadi_koresponden_alamat 		= $this->input->post('step2_pribadi_koresponden_alamat');
	    $step2_pribadi_koresponden_rt 			= $this->input->post('step2_pribadi_koresponden_rt');
	    $step2_pribadi_koresponden_rw 			= $this->input->post('step2_pribadi_koresponden_rw');
	    $step2_pribadi_koresponden_desa 		= $this->input->post('step2_pribadi_koresponden_desa');
	    $step2_pribadi_koresponden_kecamatan 	= $this->input->post('step2_pribadi_koresponden_kecamatan');
	    $step2_pribadi_koresponden_kabupaten 	= $this->input->post('step2_pribadi_koresponden_kabupaten');
	    $step2_pribadi_koresponden_kodepos 		= $this->input->post('step2_pribadi_koresponden_kodepos');
	    $step2_pribadi_pendidikan 				= $this->input->post('step2_pribadi_pendidikan');
	    $step2_pribadi_pekerjaan 				= $this->input->post('step2_pribadi_pekerjaan');
	    $step2_pribadi_pendapatan 				= $this->convert_numeric($this->input->post('step2_pribadi_pendapatan'));
	    $step2_pribadi_ket_pekerjaan 			= $this->input->post('step2_pribadi_ket_pekerjaan');
	    $step2_pribadi_literasi_latin 			= $this->input->post('step2_pribadi_literasi_latin');
	    $step2_pribadi_literasi_arab 			= $this->input->post('step2_pribadi_literasi_arab');
		$step2_pasangan_nama 					= $this->input->post('step2_pasangan_nama');
	    $step2_pasangan_tmplahir 				= $this->input->post('step2_pasangan_tmplahir');
	    $step2_pasangan_tglahir 				= $this->input->post('step2_pasangan_tglahir');
	    $step2_pasangan_tglahir 				= str_replace('/','',$step2_pasangan_tglahir);
	    $step2_pasangan_tglahir 				= substr($step2_pasangan_tglahir,4,4).'-'.substr($step2_pasangan_tglahir,2,2).'-'.substr($step2_pasangan_tglahir,0,2);
	    $step2_pasangan_usia 					= $this->input->post('step2_pasangan_usia');
	    $step2_pasangan_pendidikan 				= $this->input->post('step2_pasangan_pendidikan');
	    $step2_pasangan_pekerjaan 				= $this->input->post('step2_pasangan_pekerjaan');
	    $step2_pasangan_pendapatan 				= $this->convert_numeric($this->input->post('step2_pasangan_pendapatan'));
	    $step2_pasangan_ketpekerjaan 			= $this->input->post('step2_pasangan_ketpekerjaan');
	    $step2_pasangan_jmlkeluarga 			= $this->input->post('step2_pasangan_jmlkeluarga');
	    $step2_pasangan_jmltanggungan 			= $this->input->post('step2_pasangan_jmltanggungan');
	    $step2_pasangan_literasi_latin 			= $this->input->post('step2_pasangan_literasi_latin');
	    $step2_pasangan_literasi_arab 			= $this->input->post('step2_pasangan_literasi_arab');
	    $step3_rmhstatus 						= $this->input->post('step3_rmhstatus');
	    $step3_rmhukuran 						= $this->input->post('step3_rmhukuran');
	    $step3_rmhdinding 						= $this->input->post('step3_rmhdinding');
	    $step3_rmhatap 							= $this->input->post('step3_rmhatap');
	    $step3_rmhlantai 						= $this->input->post('step3_rmhlantai');
	    $step3_rmhjamban 						= $this->input->post('step3_rmhjamban');
	    $step3_rmhair 							= $this->input->post('step3_rmhair');
	    $step3_lahansawah 						= $this->input->post('step3_lahansawah');
	    $step3_lahankebun 						= $this->input->post('step3_lahankebun');
	    $step3_lahanpekarangan 					= $this->input->post('step3_lahanpekarangan');
	    $step3_ternakunggas 					= $this->input->post('step3_ternakunggas');
	    $step3_ternakdomba 						= $this->input->post('step3_ternakdomba');
	    $step3_sapi_ternakkerbau 				= $this->input->post('step3_sapi_ternakkerbau');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step3_elektape 						= $this->input->post('step3_elektape');
	    $step3_elekplayer 						= $this->input->post('step3_elekplayer');
	    $step3_elektv 							= $this->input->post('step3_elektv');
	    $step3_elekkulkas 						= $this->input->post('step3_elekkulkas');
	    $step3_kendsepeda 						= $this->input->post('step3_kendsepeda');
	    $step3_kendmotor 						= $this->input->post('step3_kendmotor');
	    $step4_ushrumahtangga 					= $this->input->post('step4_ushrumahtangga');
	    $step4_ushkomoditi 						= $this->input->post('step4_ushkomoditi');
	    $step4_ushlokasi 						= $this->input->post('step4_ushlokasi');
	    $step4_ushomset 						= $this->convert_numeric($this->input->post('step4_ushomset'));
	    $step4_byaberas 						= $this->convert_numeric($this->input->post('step4_byaberas'));
	    $step4_byadapur 						= $this->convert_numeric($this->input->post('step4_byadapur'));
	    $step4_byalistrik 						= $this->convert_numeric($this->input->post('step4_byalistrik'));
	    $step4_byatelpon 						= $this->convert_numeric($this->input->post('step4_byatelpon'));
	    $step4_byasekolah 						= $this->convert_numeric($this->input->post('step4_byasekolah'));
	    $step4_byalain 							= $this->convert_numeric($this->input->post('step4_byalain'));

	    // $cif_id = rand(0,100000);
	    $param = array('cif_id'=>$cif_id);
	    $data_cif = array(
	    		 'nama' 						=> @$step1_nama
	    		// ,'cif_id' 					=> $get_cif_kelompok_by_cif_id
				,'tgl_gabung' 					=> ($step1_tanggal_gabung=="")?null:$step1_tanggal_gabung
				,'panggilan' 					=> ($step1_panggilan=="")?null:$step1_panggilan
				,'kelompok' 					=> ($step1_kelompok=="")?null:$step1_kelompok
				,'jenis_kelamin' 				=> ($step2_pribadi_jenis_kelamin=="")?null:$step2_pribadi_jenis_kelamin
				,'ibu_kandung' 					=> ($step2_pribadi_ibu_kandung=="")?null:$step2_pribadi_ibu_kandung
				,'tmp_lahir' 					=> ($step2_pribadi_tmp_lahir=="")?null:$step2_pribadi_tmp_lahir
				,'tgl_lahir' 					=> ($step2_pribadi_tgl_lahir=="")?null:$step2_pribadi_tgl_lahir
				,'usia' 						=> ($step2_pribadi_usia=="")?null:$step2_pribadi_usia
				,'alamat' 						=> ($step2_pribadi_alamat=="")?null:$step2_pribadi_alamat
				,'rt_rw' 						=> @$step2_pribadi_rt.'/'.$step2_pribadi_rw
				,'desa' 						=> ($step2_pribadi_desa=="")?null:$step2_pribadi_desa
				,'kecamatan' 					=> ($step2_pribadi_kecamatan=="")?null:$step2_pribadi_kecamatan
				,'kabupaten' 					=> ($step2_pribadi_kabupaten=="")?null:$step2_pribadi_kabupaten
				,'kodepos' 						=> ($step2_pribadi_kodepos=="")?null:$step2_pribadi_kodepos
				,'koresponden_alamat' 			=> ($step2_pribadi_koresponden_alamat=="")?null:$step2_pribadi_koresponden_alamat
				,'koresponden_rt_rw' 			=> $step2_pribadi_koresponden_rt.'/'.$step2_pribadi_koresponden_rw
				,'koresponden_desa' 			=> ($step2_pribadi_koresponden_desa=="")?null:$step2_pribadi_koresponden_desa
				,'koresponden_kecamatan' 		=> ($step2_pribadi_koresponden_kecamatan=="")?null:$step2_pribadi_koresponden_kecamatan
				,'koresponden_kabupaten' 		=> ($step2_pribadi_koresponden_kabupaten=="")?null:$step2_pribadi_koresponden_kabupaten
				,'koresponden_kodepos' 			=> ($step2_pribadi_koresponden_kodepos=="")?null:$step2_pribadi_koresponden_kodepos
				,'pendidikan' 					=> ($step2_pribadi_pendidikan=="")?null:$step2_pribadi_pendidikan
				,'pekerjaan' 					=> ($step2_pribadi_pekerjaan=="")?null:$step2_pribadi_pekerjaan
				,'ket_pekerjaan' 				=> ($step2_pribadi_ket_pekerjaan=="")?null:$step2_pribadi_ket_pekerjaan
				,'branch_code' 					=> $this->session->userdata('branch_code')
	    	);
	    $data_cif_kelompok = array(
	    		 'setoran_lwk' 					=> @$step1_setoran_lwk
	    		// ,'cif_id' 					=> $cif_id
	    		,'setoran_mingguan' 			=> ($step1_setoran_mingguan=="")?null:$step1_setoran_mingguan
	    		,'literasi_latin' 				=> ($step2_pribadi_literasi_latin==true) ? $step2_pribadi_literasi_latin : 0 
				,'literasi_arab' 				=> ($step2_pribadi_literasi_arab==true) ? $step2_pribadi_literasi_arab : 0 
				,'pendapatan' 					=> ($step2_pribadi_pendapatan=="")?null:$step2_pribadi_pendapatan
	    		,'p_nama' 						=> ($step2_pasangan_nama=="")?null:$step2_pasangan_nama
				,'p_tmplahir' 					=> ($step2_pasangan_tmplahir=="")?null:$step2_pasangan_tmplahir
				,'p_tglahir' 					=> ($step2_pasangan_tglahir=="--")?null:$step2_pasangan_tglahir
				,'p_usia' 						=> ($step2_pasangan_usia=="")?null:$step2_pasangan_usia
				,'p_pendidikan' 				=> ($step2_pasangan_pendidikan=="")?null:$step2_pasangan_pendidikan
				,'p_pekerjaan' 					=> ($step2_pasangan_pekerjaan=="")?null:$step2_pasangan_pekerjaan
				,'p_ketpekerjaan' 				=> ($step2_pasangan_ketpekerjaan=="")?null:$step2_pasangan_ketpekerjaan
				,'p_pendapatan' 				=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_periodependapatan' 			=> ($step2_pasangan_pendapatan=="")?null:$step2_pasangan_pendapatan
				,'p_literasi_latin' 			=> ($step2_pasangan_literasi_latin==true) ? $step2_pasangan_literasi_latin : 0
				,'p_literasi_arab' 				=> ($step2_pasangan_literasi_arab==true) ? $step2_pasangan_literasi_arab : 0
				,'p_jmltanggungan' 				=> ($step2_pasangan_jmltanggungan=="")?null:$step2_pasangan_jmltanggungan
				,'p_jmlkeluarga' 				=> ($step2_pasangan_jmlkeluarga=="")?null:$step2_pasangan_jmlkeluarga
				,'rmhstatus' 					=> ($step3_rmhstatus=="")?null:$step3_rmhstatus
				,'rmhukuran' 					=> ($step3_rmhukuran=="")?null:$step3_rmhukuran
				,'rmhatap' 						=> ($step3_rmhatap=="")?null:$step3_rmhatap
				,'rmhdinding' 					=> ($step3_rmhdinding=="")?null:$step3_rmhdinding
				,'rmhlantai' 					=> ($step3_rmhlantai=="")?null:$step3_rmhlantai
				,'rmhjamban' 					=> ($step3_rmhjamban=="")?null:$step3_rmhjamban
				,'rmhair' 						=> ($step3_rmhair=="")?null:$step3_rmhair
				,'lahansawah' 					=> ($step3_lahansawah=="")?null:$step3_lahansawah
				,'lahankebun' 					=> ($step3_lahankebun=="")?null:$step3_lahankebun
				,'lahanpekarangan' 				=> ($step3_lahanpekarangan=="")?null:$step3_lahanpekarangan
				,'ternakkerbau' 				=> ($step3_sapi_ternakkerbau=="")?null:$step3_sapi_ternakkerbau
				,'ternakdomba' 					=> ($step3_ternakdomba=="")?null:$step3_ternakdomba
				,'ternakunggas' 				=> ($step3_ternakunggas=="")?null:$step3_ternakunggas
				,'elektape' 					=> ($step3_elektape == false) ? null : $step3_elektape
				,'elektv' 						=> ($step3_elektv == false) ? null : $step3_elektv
				,'elekplayer' 					=> ($step3_elekplayer == false) ? null : $step3_elekplayer
				,'elekkulkas' 					=> ($step3_elekkulkas == false) ? null : $step3_elekkulkas
				,'kendsepeda' 					=> ($step3_kendsepeda=="")?null:$step3_kendsepeda
				,'kendmotor'	 				=> ($step3_kendmotor=="")?null:$step3_kendmotor
				,'ushrumahtangga' 				=> ($step4_ushrumahtangga=="")?null:$step4_ushrumahtangga
				,'ushkomoditi' 					=> ($step4_ushkomoditi=="")?null:$step4_ushkomoditi
				,'ushlokasi' 					=> ($step4_ushlokasi=="")?null:$step4_ushlokasi
				,'ushomset' 					=> ($step4_ushomset=="")?null:$step4_ushomset
				,'byaberas' 					=> ($step4_byaberas=="")?null:$step4_byaberas
				,'byadapur' 					=> ($step4_byadapur=="")?null:$step4_byadapur
				,'byalistrik' 					=> ($step4_byalistrik=="")?null:$step4_byalistrik
				,'byatelpon' 					=> ($step4_byatelpon=="")?null:$step4_byatelpon
				,'byasekolah' 					=> ($step4_byasekolah=="")?null:$step4_byasekolah
				,'byalain' 						=> ($step4_byalain=="")?null:$step4_byalain
	    	);
		
		$this->db->trans_begin();
		$this->model_cif->update_cif($data_cif,$param);
		$this->model_cif->update_cif_kelompok($data_cif_kelompok,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true,'message'=>'Edit CIF Successed!');
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false,'message'=>'Edit CIF Failed!');
		}

		echo json_encode($return);
	}

	public function get_rembug_by_keyword()
	{
		$keyword 		= $this->input->post('keyword');
		$branch_id 		= $this->input->post('branch_id');
		if($branch_id=="00000") $branch_id = "";
		$data = $this->model_cif->get_rembug_by_keyword($keyword,$branch_id);

		echo json_encode($data);
	}


	public function delete_cif_kelompok()
	{
		$cif_id = $this->input->post('cif');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cif_id) ; $i++ )
		{
			$param = array('cif_id'=>$cif_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_cif_kelompok($param);
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

	// [END] CIF KELOMPOK 
	
	/********************************************************************************************/

	// [BEGIN] CIF KELOMPOK LOG

	public function edit_cif_kelompok()
	{
		$data['container'] 				= 'cif/edit_cif_kelompok';
		// $data['branch'] 				= $this->model_cif->get_all_branch();
		$data['branch'] 				= $this->session->userdata('branch_id');
		$institution 					= $this->model_cif->get_institution();
		$data['default_setoran_lwk'] 	= $institution['setoran_lwk'];
		$data['default_minggon'] 		= $institution['minggon'];
		$data['current_date'] 			= $this->current_date();
		$this->load->view('core',$data);
	}

	// [BEGIN] BRANCH SETUP

	public function branch_setup()
	{
		$data['container'] = 'cif/branch_setup';
		$this->load->view('core',$data);
	}

	// [END] BRANCH SETUP

	/********************************************************************************************/

	// [BEGIN] SERVICE AREA SETUP

	public function service_area_setup()
	{
		$data['container'] = 'cif/service_area_setup';
		$this->load->view('core',$data);
	}

	// [END] SERVICE AREA  SETUP


	// ------------------------------------------------------------------------------------------
	// BEGIN REMBUG SETUP
	// ------------------------------------------------------------------------------------------

	public function rembug_setup()
	{
		$data['container'] 		= 'cif/rembug_setup';
		$data['branch_id'] 		= $this->session->userdata('branch_id');
		$data['branch_code'] 	= $this->session->userdata('branch_code');
		//$data['cabang'] 		= $this->model_cif->get_all_branch_();
		$data['petugas'] 		= $this->model_cif->get_all_petugas();
		$data['kecamatan'] 		= $this->model_cif->get_kecamatan();
		$data['branch'] 		= $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_rembug_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$branch_code = @$_GET['branch_code'];
		$aColumns = array( '','cm_name','mfi_kecamatan_desa.desa','');
				
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
			if($branch_code!="")
				$sWhere .= " and branch_code = '".$branch_code."'";
		}
		else
		{
			$sWhere .= "WHERE branch_code = '".$branch_code."'";
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

		$rResult 			= $this->model_cif->datatable_rembug_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_rembug_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_rembug_setup(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['cm_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cm_name'];
			$row[] = $aRow['desa'];
			$row[] = '<a href="javascript:;" cm_id="'.$aRow['cm_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_rembug()
	{
		$cm_code 			= $this->input->post('id_rembug');
		$branch_name 		= $this->input->post('branch_name');
		$cm_name 			= $this->input->post('nama_rembug');
		$fa_code 			= $this->input->post('petugas_lapangan');
		$tgl_pembentukan 	= $this->input->post('tanggal_pembentukan');
		$hari_transaksi 	= $this->input->post('hari_transaksi');
		$branch_code 		= $this->input->post('add_branch_code');
		$desa_code 			= $this->input->post('desa_code');
		
		$branch_id 			= $this->model_cif->get_branch_id_by_branch_code($branch_code);

		$tgl =substr("$tgl_pembentukan",0,2);
	    $bln =substr("$tgl_pembentukan",2,2);
	    $thn =substr("$tgl_pembentukan",4,4);
	    $tglakhir = "$thn-$bln-$tgl";  
	    
		$data = array(
				'cm_code'			=> $cm_code,
				'cm_name'			=> $cm_name,
				'branch_id' 		=> $branch_id,
				'fa_code'  			=> $fa_code,
				'tgl_pembentukan'	=> $tglakhir,
				'created_by'		=> 'Admin',
				'created_timestamp'	=> date('Y-m-d H:i:s'),
				'hari_transaksi'	=> $hari_transaksi,
				'jam_transaksi'		=> date('H:i'),
				'desa_code'			=> $desa_code
			);
		$this->db->trans_begin();
		$this->model_cif->add_rembug($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_rembug()
	{
		$cm_id = $this->input->post('cm_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cm_id) ; $i++ )
		{
			$param = array('cm_id'=>$cm_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_rembug($param);
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


	public function get_user_by_cm_id()
	{
		$cm_id = $this->input->post('cm_id');
		$data = $this->model_cif->get_user_by_cm_id($cm_id);

		echo json_encode($data);
	}


	public function edit_rembug()
	{
		$cm_id 			= $this->input->post('cm_id');
		$cm_name 		= $this->input->post('nama_rembug');
		$fa_code 		= $this->input->post('petugas_lapangan');
		$hari_transaksi = $this->input->post('hari_transaksi');

		$param = array('cm_id'=>$cm_id);
		$data = array(
				'cm_name'			=> $cm_name,
				'fa_code'  			=> $fa_code,
				'hari_transaksi'	=> $hari_transaksi
			);

		$this->db->trans_begin();
		$this->model_cif->edit_rembug($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	
	public function get_ajax_branch_code_()
	{
		$branch_code 	= $this->input->post('branch_code');
		$branch_id 		= $this->model_cif->get_branch_id_by_branch_code($branch_code);
		$data 			= $this->model_cif->get_ajax_branch_code_($branch_id);

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
            $no_urut_ = sprintf('%04s', $no_urut);            
            $no_urut_rembug = $branch_code.''.$no_urut_;

		echo $no_urut_rembug;
	}
	
	
	public function get_ajax_name()
	{
		$input		= $this->input->post('code');
		$code		= substr($input,0,4);
		$id 		= substr($input,4);
		$data		= $this->model_cif->get_all_petugas_($id);
		
		echo json_encode($data);
	}



	// ------------------------------------------------------------------------------------------
	// END REMBUG SETUP
	// ------------------------------------------------------------------------------------------


		// [BEGIN] BRANCH {KANTOR CABANG}

	public function kantor_cabang()
	{
		$data['container'] = 'cif/branch_kantor_cabang';
		$data['cabang'] = $this->model_cif->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_kantor_cabang_setup()
	{
		// $branch_class =	$this->model_kantor_layanan->get_branch_class_login($this->session->userdata('branch_code'));
		// if
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','branch_code', 'branch_name','branch_class','branch_officer_name','display_text','');
				
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
						$sWhere = " AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}
		$rResult 			= $this->model_cif->datatable_kantor_cabang_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kantor_cabang_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kantor_cabang_setup(); // get number of all data
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
			
			$jenis='-';
			if($aRow['branch_class']==1){$jenis="WILAYAH";}
			else if($aRow['branch_class']==2){$jenis="CABANG";}
			else if($aRow['branch_class']==3){$jenis="CAPEM";}
			else if($aRow['branch_class']==0){$jenis="PUSAT";}

			$row[] = '<input type="checkbox" value="'.$aRow['branch_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['branch_code'];
			$row[] = $aRow['branch_name'];
			$row[] = $jenis;
			$row[] = $aRow['branch_officer_name'];
			$row[] = $aRow['display_text'];
			$row[] = '<center><a href="javascript:;" branch_id="'.$aRow['branch_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_kantor_cabang()
	{
		$branch_name 			= $this->input->post('branch_name');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_class 			= $this->input->post('branch_class');
		$branch_code 			= $this->input->post('branch_code');
		$branch_officer_title 	= $this->input->post('branch_officer_title');
		$branch_officer_name 	= $this->input->post('branch_officer_name');
		$wilayah 				= $this->input->post('wilayah');

		if($branch_induk=="")
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'wilayah' 				=> $wilayah,
				'branch_class' 			=> $branch_class
				);
		}
		else
		{
			$data = array(
				'branch_name'			=> $branch_name,
				'branch_code' 			=> $branch_code,
				'branch_officer_title' 	=> $branch_officer_title,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_status' 		=> '1',
				'branch_class' 			=> $branch_class,
				'wilayah' 				=> $wilayah,
				'branch_induk' 			=> $branch_induk
				);
		}

		/**
		* description branch_class
		* 1 = wilayah
		* 2 = cabang
		* 3 = capem
		*/
		$branch_member = array();
		if($branch_class==1){
			// branch_induk = wilayah & branch_child/code = wilayah
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
		}else if($branch_class==2){
			// branch_induk = cabang & branch_child/code = cabang
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
			// branch_induk = wilayah & branch_child/code = cabang
			$branch_member[]=array(
					'branch_induk' => $branch_induk,
					'branch_code' => $branch_code
				);
		}else if($branch_class==3){
			// branch_induk = capem & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $branch_code,
					'branch_code' => $branch_code
				);
			// branch_induk = cabang & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $branch_induk,
					'branch_code' => $branch_code
				);

			$wilayah_code = $this->model_cif->get_wilayah_code_by_branch_induk($branch_induk);
			// branch_induk = wilayah & branch_child/code = capem
			$branch_member[]=array(
					'branch_induk' => $wilayah_code,
					'branch_code' => $branch_code
				);
		}

		$this->db->trans_begin();
		$this->model_cif->add_kantor_cabang($data);
		if(count($branch_member)>0){
			$this->model_cif->add_branch_member($branch_member);
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

	public function delete_kantor_cabang()
	{
		$branch_id = $this->input->post('branch_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($branch_id) ; $i++ )
		{	
			$branch_code = $this->model_cif->get_branch_code_by_branch_id($branch_id[$i]);
			$param = array('branch_id'=>$branch_id[$i]);
			$param2 = array('branch_code'=>$branch_code);
			$this->db->trans_begin();
			$this->model_cif->delete_kantor_cabang($param);
			$this->model_cif->delete_kantor_cabang_member($param2);
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

	public function get_branch_by_branch_id()
	{
		$branch_id 	= $this->input->post('branch_id');
		$data 		= $this->model_cif->get_branch_by_branch_id($branch_id);

		echo json_encode($data);
	}

	public function edit_kantor_cabang()
	{
		$branch_id 				= $this->input->post('branch_id');
		$branch_name 			= $this->input->post('branch_name');
		$branch_code 			= $this->input->post('branch_code');
		$branch_induk 			= $this->input->post('branch_induk');
		$branch_class 			= $this->input->post('branch_class');
		$branch_officer_name 	= $this->input->post('branch_officer_name');
		$branch_officer_title 	= $this->input->post('branch_officer_title');
		$wilayah 				= $this->input->post('wilayah');

		$param = array('branch_id'=>$branch_id);


			$data = array(
				'branch_name'			=> $branch_name,
				'branch_officer_name' 	=> $branch_officer_name,
				'branch_officer_title' 	=> $branch_officer_title
				);

		$this->db->trans_begin();
		$this->model_cif->edit_kantor_cabang($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function ajax_get_branch_id()
	{
		$branch_class = $this->input->post('branch_class');
		$id = substr(($branch_class),0,3);

		echo $id;
	}

	// [END] BRANCH {KANTOR CABANG}

	// [BEGIN] PETUGAS LAPANGAN SETUP

	public function petugas_lapangan()
	{
		$data['container'] = 'cif/petugas_lapangan';
		$data['cabang'] = $this->model_cif->get_all_branch_();
		$this->load->view('core',$data);
	}

	public function datatable_petugas_lapangan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '' ,'fa_id','fa_name','');
				
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
					$sWhere = "AND ";
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_petugas_lapangan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_petugas_lapangan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_petugas_lapangan(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['fa_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['fa_code'];
			$row[] = $aRow['fa_name'];
			$row[] = $aRow['branch_name'];
			$row[] = '<center><a href="javascript:;" fa_id="'.$aRow['fa_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_petugas()
	{
		$branch_name		= $this->input->post('branch_name');
		$id_petugas			= $this->input->post('id_petugas');
		$nama_petugas		= $this->input->post('nama_petugas');
		$level				= $this->input->post('level');
		$tgl_gabung			= $this->input->post('tanggal_bergabung');
		$tgl_gabung     	= str_replace('/', '', $tgl_gabung);
		$tgl 				= substr("$tgl_gabung",0,2);
	    $bln 				= substr("$tgl_gabung",2,2);
	    $thn 				= substr("$tgl_gabung",4,4);
	    $tglakhir 			= "$thn-$bln-$tgl";  

	$data = array(
					'branch_code'		=> $branch_name,
					'fa_code'			=> $id_petugas,
					'fa_name'			=> $nama_petugas,
					'fa_level'			=> $level,
					'tgl_gabung'		=> $tglakhir,
					'created_by'		=> $this->session->userdata('user_id'),
					'created_timestamp'	=> date('Y-m-d H:i:s')
				);

		$this->db->trans_begin();
		$this->model_cif->add_petugas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}


	public function delete_petugas()
	{
		$fa_id = $this->input->post('fa_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($fa_id) ; $i++ )
		{
			$param = array('fa_id'=>$fa_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_petugas($param);
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

	public function edit_petugas()
	{
		$fa_id 			= $this->input->post('fa_id');
		$branch_name 	= $this->input->post('branch_name2');
		$id_petugas2 	= $this->input->post('id_petugas2');
		$fa_name 		= $this->input->post('nama_petugas');
		$level 			= $this->input->post('level');

		$param = array('fa_id'=>$fa_id);
		$data = array(
				'fa_name'		=> $fa_name,
				'fa_code'		=> $id_petugas2,
				'fa_level'		=> $level,
				'branch_code'	=> $branch_name
			);

		$this->db->trans_begin();
		$this->model_cif->edit_petugas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function get_petugas_by_id()
	{
		$fa_id 	= $this->input->post('fa_id');
		$data 	= $this->model_cif->get_petugas_by_id($fa_id);

		echo json_encode($data);
	}

	public function search_cif_no()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_no($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	public function search_pemegang_rekening_bycif_no()
	{
		$cif_no 	= $this->input->post('cif_no');
		$data 		= $this->model_cif->search_pemegang_rekening_bycif_no($cif_no);

		echo json_encode($data);
	}

	public function search_cif_no2()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$data 		= $this->model_cif->search_cif_no2($keyword,$type);

		echo json_encode($data);
	}
	
	
	public function search_fa_name()
	{
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->search_fa_name($branch_code);

		echo json_encode($data);
	}
	
	public function get_ajax_branch_code()
	{
		$code		= $this->input->post('code');
		$data		= $this->model_cif->get_ajax_branch_code($code);

		$jumlah = $data['jumlah'];
			if($jumlah==null)
            {
              $total = 0;
            }
            else
            {
              $total = $jumlah;
            }
            $no_urut 	= $total+1;
            $no_urut_ 	= sprintf('%04s', $no_urut);            
            $no_urut_petugas = $code.''.$no_urut_;

		echo $no_urut_petugas;
	}
	
	public function get_ajax_sequenc_fa()
	{
		$branch_code = $this->input->post('code');
		$data		 = $this->model_cif->get_ajax_sequenc_fa($branch_code);

		$max = $data['max'];
			if($max==null)
            {
              $total = 0;
            }
            else
            {
              $total = $max;
            }
            $no_urut 	= $total+1;
            $no_urut_ 	= sprintf('%04s', $no_urut);            
            $no_urut_petugas = $branch_code.''.$no_urut_;

		echo $no_urut_petugas;
	}

	// [END] PETUGAS LAPANGAN  SETUP


	// ------------------------------------------------------------------------------------------
	// BEGIN KABUPATEN SETUP
	// ------------------------------------------------------------------------------------------

	public function kabupaten()
	{
		$data['container'] = 'cif/kabupaten';
		$data['province'] = $this->model_cif->get_province();
		$this->load->view('core', $data);
	}

	public function datatable_kabupaten()
	{
		$aColumns = array( '','city_code', 'city_abbr','');
				
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

		$rResult 			= $this->model_cif->datatable_kabupaten($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kabupaten($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kabupaten(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['city_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['city_code'];
			$row[] = $aRow['city'];
			$row[] = '<a href="javascript:;" city_code="'.$aRow['city_code'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_city()
	{
		$province_code 	= $this->input->post('province_code');
		$city_code 		= $this->input->post('city_code');
		$city_abbr 		= $this->input->post('city_abbr');
		$data = array(
				'province_code'	=> $province_code,
				'city_code'		=> $city_code,
				'city_abbr'		=> $city_abbr,
				'city'			=> $city_abbr
			);

		$this->db->trans_begin();
		$this->model_cif->add_city($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_city_by_id()
	{
		$city_code = $this->input->post('city_code');
		$data = $this->model_cif->get_city_by_id($city_code);

		echo json_encode($data);
	}


	public function delete_city()
	{
		$city_code = $this->input->post('city_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($city_code) ; $i++) 
		{ 
			$param = array('city_code' =>$city_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_city($param);
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


	public function edit_city()
	{
		$city_code2 	= $this->input->post('city_code2');
		$city_code 		= $this->input->post('city_code');
		$province_code 	= $this->input->post('province_code');
		$city_abbr 		= $this->input->post('city_abbr');

		$param = array('city_code'=>$city_code2);
		$data = array(
				'city_code'		=> $city_code,
				'province_code'	=> $province_code,
				'city_abbr' 	=> $city_abbr,
				'city'			=> $city_abbr
			);

		$this->db->trans_begin();
		$this->model_cif->edit_city($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}
		// [END] SERVICE KABUPATEN

	public function kecamatan()
	{
		$data['container'] 	= 'cif/kecamatan';
		$data['city'] 		= $this->model_cif->get_city();
		$this->load->view('core', $data);
	}

	public function datatable_kecamatan()
	{
		$aColumns = array( '','kecamatan_code','kecamatan', 'mfi_city_kecamatan.city_code','');
				
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

		$rResult 			= $this->model_cif->datatable_kecamatan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_kecamatan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_kecamatan(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['kecamatan_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['kecamatan_code'];
			$row[] = $aRow['kecamatan'];
			$row[] = $aRow['city'];
			$row[] = '<a href="javascript:;" city_kecamatan_id="'.$aRow['city_kecamatan_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}


	public function add_kecamatan()
	{
		$city_kecamatan_id 	= rand(0000,9999);
		$kecamatan_code 	= $this->input->post('kecamatan_code');
		$city_code 			= $this->input->post('city_code');
		$kecamatan 			= $this->input->post('kecamatan');
		$data = array(
				'city_kecamatan_id'	=> $city_kecamatan_id,
				'kecamatan_code'	=> $kecamatan_code,
				'city_code'			=> $city_code,
				'kecamatan'			=> $kecamatan
			);

		$this->db->trans_begin();
		$this->model_cif->add_kecamatan($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_kecamatan_by_id()
	{
		$city_kecamatan_id 	= $this->input->post('city_kecamatan_id');
		$data 				= $this->model_cif->get_kecamatan_by_id($city_kecamatan_id);

		echo json_encode($data);
	}


	public function delete_kecamatan()
	{
		$kecamatan_code = $this->input->post('kecamatan_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($kecamatan_code) ; $i++) 
		{ 
			$param = array('kecamatan_code' =>$kecamatan_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_kecamatan($param);
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


	public function edit_kecamatan()
	{
		$kecamatan_code 	= $this->input->post('kecamatan_code');
		$city_code 			= $this->input->post('city_code2');
		$kecamatan 			= $this->input->post('kecamatan');
		$city_kecamatan_id 	= $this->input->post('city_kecamatan_id');
		$param 				= array('city_kecamatan_id'=>$city_kecamatan_id);
		$data = array(
				'kecamatan_code'=>$kecamatan_code,
				'city_code'=>$city_code,
				'kecamatan'=>$kecamatan
			);

		$this->db->trans_begin();
		$this->model_cif->edit_kecamatan($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	
	public function get_ajax_city_code()
	{
		$city_code		= $this->input->post('code');
		$data		= $this->model_cif->get_ajax_city_code($city_code);

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
            $no_urut_kecamatan = $city_code.''.$no_urut_;

		echo $no_urut_kecamatan;
	}

	public function search_city_code()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->search_city_code($keyword);

		echo json_encode($data);
	}
	


	public function desa()
	{
		$data['container'] 	= 'cif/desa';
		$data['kecamatan'] 	= $this->model_cif->get_kecamatan();
		$data['city'] 		= $this->model_cif->get_city();
		$this->load->view('core', $data);
	}

	public function datatable_desa()
	{
		$aColumns = array( '','desa_code','desa', 'mfi_city_kecamatan.kecamatan','');
				
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

		$rResult 			= $this->model_cif->datatable_desa($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_desa($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_desa(); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['desa_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['desa_code'];
			$row[] = $aRow['desa'];
			$row[] = $aRow['kecamatan'];
			$row[] = '<a href="javascript:;" kecamatan_desa_id="'.$aRow['kecamatan_desa_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_desa()
	{
		$desa_code 		= $this->input->post('desa_code');
		$kecamatan_code = $this->input->post('kecamatan_code');
		$desa 			= $this->input->post('desa');
		$data = array(
				'desa_code'			=> $desa_code,
				'kecamatan_code'	=> $kecamatan_code,
				'desa'				=> $desa
			);

		$this->db->trans_begin();
		$this->model_cif->add_desa($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success', false);
		}

		echo json_encode($return);
	}

	public function get_desa_by_id()
	{
		$kecamatan_desa_id = $this->input->post('kecamatan_desa_id');
		$data = $this->model_cif->get_desa_by_id($kecamatan_desa_id);

		echo json_encode($data);
	}


	public function delete_desa()
	{
		$desa_code = $this->input->post('desa_code');

		$success = 0;
		$failed = 0;
		for ($i=0; $i < count($desa_code) ; $i++) 
		{ 
			$param = array('desa_code' =>$desa_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_desa($param);
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


	public function edit_desa()
	{
		$desa_code 			= $this->input->post('desa_code');
		$kecamatan_code 	= $this->input->post('kecamatan_code2');
		$desa 				= $this->input->post('desa');
		$kecamatan_desa_id 	= $this->input->post('kecamatan_desa_id');
		$param = array('kecamatan_desa_id'=>$kecamatan_desa_id);
		$data = array(
				'desa_code'			=> $desa_code,
				'kecamatan_code'	=> $kecamatan_code,
				'desa'				=> $desa
			);

		$this->db->trans_begin();
		$this->model_cif->edit_desa($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	
	public function get_ajax_kecamatan_code()
	{
		$kecamatan_code		= $this->input->post('code');
		$data				= $this->model_cif->get_ajax_kecamatan_code($kecamatan_code);

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
        $no_urut_desa = $kecamatan_code.''.$no_urut_;

		echo $no_urut_desa;
	}

	public function search_kecamatan_code()
	{
		$keyword 	= $this->input->post('keyword');
		$city 		= $this->input->post('city_code');
		$data 		= $this->model_cif->search_kecamatan_code($keyword,$city);

		echo json_encode($data);
	}


	// [BEGIN] CIF INDIVIDU 

	public function cif_individu()
	{
		$data['container'] = 'cif/cif_individu';
		$data['pekerjaan'] = $this->model_cif->get_all_pekerjaan();
		$this->load->view('core',$data);
	}

	public function add_cif_individu()
	{
		$nama 					= $this->input->post('nama');
		$tgl_gabung 			= $this->input->post('tgl_gabung');
		$tgl_gabung 			= str_replace('/', '', $tgl_gabung);
		$tgl_gabung 			= substr($tgl_gabung,4,4).'-'.substr($tgl_gabung,2,2).'-'.substr($tgl_gabung,0,2);
		$panggilan 				= $this->input->post('panggilan');
		$jenis_kelamin 			= $this->input->post('jenis_kelamin');
		$ibu_kandung 			= $this->input->post('ibu_kandung');
		$tmp_lahir 				= $this->input->post('tmp_lahir');
		$tgl_lahir 				= $this->input->post('tgl_lahir');
		$tgl_lahir 				= str_replace('/', '', $tgl_lahir);
		$tgl_lahir 				= substr($tgl_lahir,4,4).'-'.substr($tgl_lahir,2,2).'-'.substr($tgl_lahir,0,2);
		$usia 					= $this->input->post('usia');
		$alamat 				= $this->input->post('alamat');
		$rt 					= $this->input->post('rt');
		$rw 					= $this->input->post('rw');
		$desa 					= $this->input->post('desa');
		$kecamatan 				= $this->input->post('kecamatan');
		$kabupaten 				= $this->input->post('kabupaten');
		$kode_pos 				= $this->input->post('kode_pos');
		$sama 					= $this->input->post('sama');
		$koresponden_alamat 	= $this->input->post('koresponden_alamat');
		$koresponden_rt 		= $this->input->post('koresponden_rt');
		$koresponden_rw 		= $this->input->post('koresponden_rw');
		$koresponden_desa 		= $this->input->post('koresponden_desa');
		$koresponden_kecamatan 	= $this->input->post('koresponden_kecamatan');
		$koresponden_kabupaten 	= $this->input->post('koresponden_kabupaten');
		$koresponden_kode_pos 	= $this->input->post('koresponden_kode_pos');
		$jenis_id 				= $this->input->post('jenis_id');
		$jenis_id2 				= $this->input->post('jenis_id2');
		$no_ktp 				= $this->input->post('no_ktp');
		$telpon_rumah 			= $this->input->post('telpon_rumah');
		$no_npwp 				= $this->input->post('no_npwp');
		$pendidikan 			= $this->input->post('pendidikan');
		$status_perkawinan 		= $this->input->post('status_perkawinan');
		$nama_pasangan 			= $this->input->post('nama_pasangan');
		$jenis_id_pasangan 		= $this->input->post('jenis_id_pasangan');
		$jenis_id_pasangan2 	= $this->input->post('jenis_id_pasangan2');
		$identitas_pasangan 	= $this->input->post('identitas_pasangan');
		$pekerjaan 				= $this->input->post('pekerjaan');
		$pendapatan 			= $this->convert_numeric($this->input->post('pendapatan'));
		$keterangan_pekerjaan 	= $this->input->post('keterangan_pekerjaan');
		if($jenis_id=="dll"){
			$id_jenis = $jenis_id2;
		}else{
			$id_jenis = $jenis_id;
		}
		if($jenis_id_pasangan=="dll"){
			$id_jenis_pasangan = $jenis_id_pasangan2;
		}else{
			$id_jenis_pasangan = $jenis_id_pasangan;
		}
		$data = array(
			 'nama' 					=> ($nama=="") ? null : $nama
			,'tgl_gabung' 				=> ($tgl_gabung=="") ? null : $tgl_gabung
			,'panggilan' 				=> ($panggilan=="") ? null : $panggilan
			,'jenis_kelamin' 			=> ($jenis_kelamin=="") ? null : $jenis_kelamin
			,'ibu_kandung' 				=> ($ibu_kandung=="") ? null : $ibu_kandung
			,'tmp_lahir' 				=> ($tmp_lahir=="") ? null : $tmp_lahir
			,'tgl_lahir' 				=> ($tgl_lahir=="") ? null : $tgl_lahir
			,'usia' 					=> ($usia=="") ? null : $usia
			,'alamat' 					=> ($alamat=="") ? null : $alamat
			,'rt_rw' 					=> $rt.'/'.$rw
			,'desa' 					=> ($desa=="") ? null : $desa
			,'kecamatan' 				=> ($kecamatan=="") ? null : $kecamatan
			,'kabupaten' 				=> ($kabupaten=="") ? null : $kabupaten
			,'kodepos'	 				=> ($kode_pos=="") ? null : $kode_pos
			,'koresponden_alamat' 		=> ($koresponden_alamat=="") ? null : $koresponden_alamat
			,'koresponden_rt_rw' 		=> $koresponden_rt.'/'.$koresponden_rw
			,'koresponden_desa' 		=> ($koresponden_desa=="") ? null : $koresponden_desa
			,'koresponden_kecamatan' 	=> ($koresponden_kecamatan=="") ? null : $koresponden_kecamatan
			,'koresponden_kabupaten' 	=> ($koresponden_kabupaten=="") ? null : $koresponden_kabupaten
			,'koresponden_kodepos' 		=> ($koresponden_kode_pos=="") ? null : $koresponden_kode_pos
			,'jenis_id' 				=> ($id_jenis=="") ? null : $id_jenis
			,'no_ktp' 					=> ($no_ktp=="") ? null : $no_ktp
			,'telpon_rumah' 			=> ($telpon_rumah=="") ? null : $telpon_rumah
			,'no_npwp' 					=> ($no_npwp=="") ? null : $no_npwp
			,'pendidikan' 				=> ($pendidikan=="") ? null : $pendidikan
			,'status_perkawinan' 		=> ($status_perkawinan=="") ? null : $status_perkawinan
			,'nama_pasangan' 			=> ($nama_pasangan=="") ? null : $nama_pasangan
			,'jenis_id_pasangan' 		=> ($id_jenis_pasangan=="") ? null : $id_jenis_pasangan
			,'identitas_pasangan' 		=> ($identitas_pasangan=="") ? null : $identitas_pasangan
			,'pekerjaan' 				=> ($pekerjaan=="") ? null : $pekerjaan
			,'pendapatan_perbulan'	 	=> ($pendapatan=="") ? null : $pendapatan
			,'ket_pekerjaan' 			=> ($keterangan_pekerjaan=="") ? null : $keterangan_pekerjaan
			,'cif_type' 				=> 1
			,'branch_code' 				=> $this->session->userdata('branch_code')
		);

		$this->db->trans_begin();
		$this->model_cif->add_cif_individu($data);
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

	public function datatable_cif_individu()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','cif_no','nama','jenis_kelamin','tgl_lahir','usia','');
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
					$sWhere .= "LOWER(".$aColumns[$i]."::varchar) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i]."::varchar) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_cif_individu($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_cif_individu($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_cif_individu(); // get number of all data
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
			if($aRow['jenis_kelamin']=="P"){
				$aRow['jenis_kelamin'] = "Pria";
			}else if($aRow['jenis_kelamin']=="W"){
				$aRow['jenis_kelamin'] = "Wanita";
			}
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['cif_id'].'" cif_no="'.$aRow['cif_no'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['jenis_kelamin'];
			$row[] = $this->format_date_detail($aRow['tgl_lahir'],'id',false,'/');
			$row[] = $aRow['usia']." Tahun";
			$row[] = '<a href="javascript:;" cif_id="'.$aRow['cif_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_cif_individu()
	{
		$cif_id = $this->input->post('cif_id');
		$data 	= $this->model_cif->get_cif_individu($cif_id);

		echo json_encode($data);
	}

	public function update_cif_individu()
	{
		$cif_id 				= $this->input->post('cif_id');
		$nama 					= $this->input->post('nama');
		$tgl_gabung 			= $this->input->post('tgl_gabung');
		$tgl_gabung 			= str_replace('/', '', $this->input->post('tgl_gabung'));
		$tgl_gabung 			= substr($tgl_gabung,4,4).'-'.substr($tgl_gabung,2,2).'-'.substr($tgl_gabung,0,2);
		$panggilan 				= $this->input->post('panggilan');
		$jenis_kelamin 			= $this->input->post('jenis_kelamin');
		$ibu_kandung 			= $this->input->post('ibu_kandung');
		$tmp_lahir 				= $this->input->post('tmp_lahir');
		$tgl_lahir 				= str_replace('/', '', $this->input->post('tgl_lahir'));
		$tgl_lahir 				= substr($tgl_lahir,4,4).'-'.substr($tgl_lahir,2,2).'-'.substr($tgl_lahir,0,2);
		$usia 					= $this->input->post('usia');
		$alamat 				= $this->input->post('alamat');
		$rt 					= $this->input->post('rt');
		$rw 					= $this->input->post('rw');
		$desa 					= $this->input->post('desa');
		$kecamatan 				= $this->input->post('kecamatan');
		$kabupaten 				= $this->input->post('kabupaten');
		$kode_pos 				= $this->input->post('kode_pos');
		$koresponden_alamat 	= $this->input->post('koresponden_alamat');
		$koresponden_rt 		= $this->input->post('koresponden_rt');
		$koresponden_rw 		= $this->input->post('koresponden_rw');
		$koresponden_desa 		= $this->input->post('koresponden_desa');
		$koresponden_kecamatan 	= $this->input->post('koresponden_kecamatan');
		$koresponden_kabupaten 	= $this->input->post('koresponden_kabupaten');
		$koresponden_kode_pos 	= $this->input->post('koresponden_kode_pos');
		$jenis_id 				= $this->input->post('jenis_id');
		$jenis_id2 				= $this->input->post('jenis_id2');
		$no_ktp 				= $this->input->post('no_ktp');
		$telpon_rumah 			= $this->input->post('telpon_rumah');
		$no_npwp 				= $this->input->post('no_npwp');
		$pendidikan 			= $this->input->post('pendidikan');
		$status_perkawinan 		= $this->input->post('status_perkawinan');
		$nama_pasangan 			= $this->input->post('nama_pasangan');
		$jenis_id_pasangan 		= $this->input->post('jenis_id_pasangan');
		$jenis_id_pasangan2 	= $this->input->post('jenis_id_pasangan2');
		$identitas_pasangan 	= $this->input->post('identitas_pasangan');
		$pekerjaan 				= $this->input->post('pekerjaan');
		$pendapatan 			= $this->convert_numeric($this->input->post('pendapatan'));
		$keterangan_pekerjaan 	= $this->input->post('keterangan_pekerjaan');
		if($jenis_id=="dll"){
			$id_jenis = $jenis_id2;
		}else{
			$id_jenis = $jenis_id;
		}
		if($jenis_id_pasangan=="dll"){
			$id_jenis_pasangan = $jenis_id_pasangan2;
		}else{
			$id_jenis_pasangan = $jenis_id_pasangan;
		}
		$param = array('cif_id'=>$cif_id);
		$data = array(
			 'nama' 					=> $nama
			,'panggilan' 				=> $panggilan
			,'jenis_kelamin' 			=> $jenis_kelamin
			,'ibu_kandung' 				=> $ibu_kandung
			,'tmp_lahir' 				=> $tmp_lahir
			,'tgl_gabung' 				=> $tgl_gabung
			,'tgl_lahir' 				=> $tgl_lahir
			,'usia' 					=> $usia
			,'alamat' 					=> $alamat
			,'rt_rw' 					=> $rt.'/'.$rw
			,'desa' 					=> $desa
			,'kecamatan' 				=> $kecamatan
			,'kabupaten' 				=> $kabupaten
			,'kodepos' 					=> $kode_pos
			,'koresponden_alamat' 		=> $koresponden_alamat
			,'koresponden_rt_rw' 		=> $koresponden_rt.'/'.$koresponden_rw
			,'koresponden_desa' 		=> $koresponden_desa
			,'koresponden_kecamatan' 	=> $koresponden_kecamatan
			,'koresponden_kabupaten' 	=> $koresponden_kabupaten
			,'koresponden_kodepos' 		=> $koresponden_kode_pos
			,'jenis_id' 				=> $id_jenis
			,'no_ktp' 					=> $no_ktp
			,'telpon_rumah' 			=> $telpon_rumah
			,'no_npwp' 					=> $no_npwp
			,'pendidikan' 				=> $pendidikan
			,'status_perkawinan' 		=> $status_perkawinan
			,'nama_pasangan' 			=> $nama_pasangan
			,'jenis_id_pasangan' 		=> $id_jenis_pasangan
			,'identitas_pasangan' 		=> $identitas_pasangan
			,'pekerjaan' 				=> $pekerjaan
			,'pendapatan_perbulan' 		=> $pendapatan
			,'ket_pekerjaan' 			=> $keterangan_pekerjaan
		);
	
		$this->db->trans_begin();
		$this->model_cif->update_cif_individu($data,$param);

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

	public function delete_cif_individu()
	{
		$cif_id = $this->input->post('cif_id');
		$cif_no = $this->input->post('cif_no');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($cif_id) ; $i++ )
		{
			$check_exist_tabungan = $this->model_cif->check_exist_tabungan($cif_no[$i]);
			$check_exist_pembiayaan = $this->model_cif->check_exist_pembiayaan($cif_no[$i]);

			if($check_exist_tabungan==false and $check_exist_pembiayaan==false)
			{
				$param = array('cif_id'=>$cif_id[$i]);
				$this->db->trans_begin();
				$this->model_cif->delete_cif_individu($param);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					$success++;
				}else{
					$this->db->trans_rollback();
					$failed++;
				}
			}
			else
			{
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_failed'=>$failed);
		}

		echo json_encode($return);
	}

	/****************************************************************************************/	
	// BEGIN PROGRAM SETUP
	/****************************************************************************************/
	public function program()
	{
		$data['container'] = 'cif/program';
		$data['kreditur'] = $this->model_cif->get_list_code('kreditur');
		$this->load->view('core',$data);
	}

	public function datatable_program_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','program_code', 'program_name','program_owner','sifat_dana','');
				
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
		$rResult 			= $this->model_cif->datatable_program_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_program_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_program_setup(); // get number of all data
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
			
			if($aRow['sifat_dana']==0)
				{
					$sifat_dana="Hibah";
				}
			else if($aRow['sifat_dana']==1)
				{
					$sifat_dana="Dana Bergulir";
				}
			else
				{
					$sifat_dana="Pembiayaan";
				}

			$row[] = '<input type="checkbox" value="'.$aRow['financing_program_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['program_code'];
			$row[] = $aRow['program_name'];
			$row[] = $aRow['program_owner'];
			$row[] = $sifat_dana;
			$row[] = '<center><a href="javascript:;" financing_program_id="'.$aRow['financing_program_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_program()
	{
		$program_code 		= $this->input->post('program_code');
		$program_name 		= $this->input->post('program_name');
		$program_owner 		= $this->input->post('program_owner');
		$sifat_dana 		= $this->input->post('sifat_dana');
		$target_customer 	= $this->input->post('target_customer');
		$target_pembiayaan 	= $this->input->post('target_pembiayaan');

		$tanggal_mulai 		= $this->input->post('tanggal_mulai');
		$tgl_mulai			= str_replace("/","", $tanggal_mulai);
        $tgl_m_pengajuan	= substr($tgl_mulai,4,4).'-'.substr($tgl_mulai,2,2).'-'.substr($tgl_mulai,0,2);

		$tanggal_berakhir 	= $this->input->post('tanggal_berakhir');
		$tgl_berakhir		= str_replace("/","", $tanggal_berakhir);
        $tgl_b_pengajuan	= substr($tgl_berakhir,4,4).'-'.substr($tgl_berakhir,2,2).'-'.substr($tgl_berakhir,0,2);

        $program_owner_text = $this->model_cif->get_list_code_text('kreditur',$program_owner);
        $program_owner_text = $program_owner_text['display_text'];

		// $tgl 				= substr("$tanggal_mulai",0,2);
	    // $bln 				= substr("$tanggal_mulai",2,2);
	    // $thn 				= substr("$tanggal_mulai",4,4);
	    // $tgl_mulai 			= "$thn-$bln-$tgl";  

	    // $tgl2 				= substr("$tanggal_berakhir",0,2);
	    // $bln2 				= substr("$tanggal_berakhir",2,2);
	    // $thn2 				= substr("$tanggal_berakhir",4,4);
	    // $tgl_berakhir 		= "$thn2-$bln2-$tgl2"; 

			$data = array(
				'program_code'		=> $program_code,
				'program_name' 		=> $program_name,
				'program_owner' 	=> $program_owner_text,
				'program_owner_code'=> $program_owner,
				'sifat_dana' 		=> $sifat_dana,
				'tanggal_mulai' 	=> $tgl_m_pengajuan,				
				'tanggal_berakhir' 	=> $tgl_b_pengajuan,
				'target_customer' 	=> $target_customer,
				'target_pembiayaan' => $this->convert_numeric($target_pembiayaan),
				'status_program' 	=> '0'
				);
		

		$this->db->trans_begin();
		$this->model_cif->add_program($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_program()
	{
		$financing_program_id = $this->input->post('financing_program_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($financing_program_id) ; $i++ )
		{
			$param = array('financing_program_id'=>$financing_program_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_program($param);
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

	public function get_program_by_financing_program_id()
	{
		$financing_program_id = $this->input->post('financing_program_id');
		$data = $this->model_cif->get_program_by_financing_program_id($financing_program_id);

		echo json_encode($data);
	}

	public function edit_program()
	{
		$financing_program_id 		= $this->input->post('financing_program_id');
		$program_code 				= $this->input->post('program_code2');
		$program_name 				= $this->input->post('program_name2');
		$program_owner 				= $this->input->post('program_owner2');
		$sifat_dana 				= $this->input->post('sifat_dana2');
		$target_customer 			= $this->input->post('target_customer2');
		$target_pembiayaan 			= $this->input->post('target_pembiayaan2');

		$tanggal_mulai 		= $this->input->post('tanggal_mulai2');
		$tgl_mulai			= str_replace("/","", $tanggal_mulai);
        $tgl_m_pengajuan	= substr($tgl_mulai,4,4).'-'.substr($tgl_mulai,2,2).'-'.substr($tgl_mulai,0,2);

		$tanggal_berakhir 	= $this->input->post('tanggal_berakhir2');
		$tgl_berakhir		= str_replace("/","", $tanggal_berakhir);
        $tgl_b_pengajuan	= substr($tgl_berakhir,4,4).'-'.substr($tgl_berakhir,2,2).'-'.substr($tgl_berakhir,0,2);

        $program_owner_text = $this->model_cif->get_list_code_text('kreditur',$program_owner);
        $program_owner_text = $program_owner_text['display_text'];

		// $tgl 						= substr("$tanggal_mulai",0,2);
	    // $bln 						= substr("$tanggal_mulai",2,2);
	    // $thn 						= substr("$tanggal_mulai",4,4);
	    // $tgl_mulai 					= "$thn-$bln-$tgl";  

	    // $tgl2 						= substr("$tanggal_berakhir",0,2);
	    // $bln2 						= substr("$tanggal_berakhir",2,2);
	    // $thn2 						= substr("$tanggal_berakhir",4,4);
	    // $tgl_berakhir 				= "$thn2-$bln2-$tgl2"; 

		$param = array('financing_program_id'=>$financing_program_id);

			$data = array(
				'program_code'		=> $program_code,
				'program_name' 		=> $program_name,
				'program_owner' 	=> $program_owner_text,
				'program_owner_code'=> $program_owner,
				'sifat_dana' 		=> $sifat_dana,
				'tanggal_mulai' 	=> $tgl_m_pengajuan,				
				'tanggal_berakhir' 	=> $tgl_b_pengajuan,
				'target_customer' 	=> $target_customer,
				'target_pembiayaan' => $this->convert_numeric($target_pembiayaan),
				'status_program' 	=> '0'
				);

		$this->db->trans_begin();
		$this->model_cif->edit_program($data,$param);
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
	// END PROGRAM SETUP
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN SMK SETUP
	/****************************************************************************************/
	public function registrasi_smk()
	{
		$data['container'] 		= 'cif/registrasi_smk';
		$data['branch_code'] 	= $this->session->userdata('branch_code');
		$data['tanggal'] 		= date('d-m-Y');
		$branch_code 			= $this->session->userdata('branch_code');
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['kas_petugas'] 	= $this->model_cif->get_fa_by_branch_code($branch_code);
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$data['nominal'] 		= $this->model_cif->get_nominal_awal();
		$this->load->view('core',$data);
	}

	public function datatable_registrasi_smk_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_trx_smk.cif_no','mfi_smk.nama', 'mfi_trx_smk.trx_type', 'mfi_trx_smk.trx_date','mfi_smk.nominal', '');
				
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
		$rResult 			= $this->model_cif->datatable_registrasi_smk_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_registrasi_smk_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_registrasi_smk_setup(); // get number of all data
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

			$trx_type = $aRow['trx_type'];
			if($trx_type=='1'){
				$aTrx_type = "Tunai";
			}else{
				$aTrx_type = "Pinbuk";
			}

			$row[] = '<input type="checkbox" value="'.$aRow['trx_smk_code'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = $aTrx_type;
			$row[] = $this->format_date_detail($aRow['trx_date'],'id',false,'/');
			$row[] = "Rp. ".number_format($aRow['nominal'],0,',','.');
			$row[] = $aRow['jml_sertifikat']." Sertifikat";
			// $row[] = '<center><a href="javascript:;" trx_smk_id="'.$aRow['trx_smk_id'].'" id="link-edit">Edit</a></center>';
			$row[] = '<center><a href="#dialog_detail" data-toggle="modal" trx_smk_id="'.$aRow['trx_smk_id'].'" id="link-detail">Detail</a></center>';
			// $row[] = '<center><a href="'.site_url('cif/export_smk/'.$aRow['smk_id'].'/'.$aRow['status'].'').'" target="_blank">Print</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function count_no_sertifikat_by_branch_code()
	{
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);

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
            $no_urut_ = sprintf('%06s', $no_urut);            
            $no_urut_sertifikat = $branch_code.''.$no_urut_;

		echo $no_urut_sertifikat;
	}

	public function get_fa_by_branch_code()
	{
		$branch_code = $this->session->userdata('branch_code');
		$data = $this->model_cif->get_fa_by_branch_code($branch_code);

		echo json_encode($data);
	}

	public function add_registrasi_smk()
	{
		$sertifikat_no 			= $this->input->post('sertifikat_no');
		$status_anggota			= $this->input->post('status_anggota');
		$nama 					= $this->input->post('nama');
		$nominal 				= $this->convert_numeric($this->input->post('nominal'));
		$tipe_trx				= $this->input->post('status_option');
		$created_by				= $this->session->userdata('user_id');
		$created_date			= date('Y-m-d H:i:s');

		if ($status_anggota=='0'){			
			$cif_no = "";
		}else{
			$cif_no 			= $this->input->post('cif_no');
		}

		if($tipe_trx=='0'){
			$account_cash_code	= "";
			$setoran_tunai 		= 0;
			$tabungan_wajib 	= $this->convert_numeric($this->input->post('tabungan_wajib'));
			$tabungan_kelompok 	= $this->convert_numeric($this->input->post('tabungan_kelompok'));
			$total 				= $this->convert_numeric($this->input->post('total'));
		}else{
			$account_cash_code	= $this->input->post('account_cash_code');
			$setoran_tunai 		= $this->convert_numeric($this->input->post('setoran_tunai'));
			$tabungan_wajib 	= 0;
			$tabungan_kelompok 	= 0;
			$total 				= $this->convert_numeric($this->input->post('total'));
		}
		
		$tanggal_			= $this->input->post('date_issued');
		$tanggal_mulai		= str_replace("/", "", $tanggal_);
	    $date_issued 		= substr($tanggal_mulai,0,2).'-'.substr($tanggal_mulai,2,2).'-'.substr($tanggal_mulai,4,4);
	    $total_rec 			= $total/50000;

	    //Mendapatkan No Sertifikat Jika Total Merupakan Kelipatan 50000
	    $branch_code 		= $this->session->userdata('branch_code');
		$data 				= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);
		$datas 				= $this->model_cif->count_code_trx_smk();
		$jumlah 			= $data['jumlah'];
		$jumlah2 			= $datas['jumlah'];

		if($jumlah==null){
          $num = 0;
        }else{
          $num = $jumlah;
        }

        if($jumlah2==null){
          $num2 = 0;
        }else{
          $num2 = $jumlah2;
        }

        $trx_smk_code = sprintf('%06s', $num2+1);

				$data1 = array(
					'cif_no'			=> $cif_no,
					'trx_type'			=> $tipe_trx,
					'account_cash_code'	=> $account_cash_code,
					'setor_tunai'		=> $setoran_tunai,
					'tabungan_wajib'	=> $tabungan_wajib,
					'tabungan_kelompok'	=> $tabungan_kelompok,
					'total'				=> $total,
					'trx_date'			=> $created_date,
					'created_date'		=> $created_date,
					'created_by'		=> $created_by,
					'trx_smk_code'		=> $trx_smk_code
					);

			for($i=1;$i<=$total_rec;$i++){
				$data2[] = array(
					'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
					'cif_no' 			=> $cif_no,
					'nama' 				=> $nama,
					'nominal' 			=> 50000,
					'date_issued' 		=> $date_issued,
					'created_by' 		=> $created_by,
					'created_date' 		=> $created_date,
					'status_anggota'	=> $status_anggota,
					'trx_smk_code'		=> $trx_smk_code
				);
			}

		$this->db->trans_begin();
		$this->model_cif->add_trx_smk($data1);
		if(count($data2)>0){
			$this->model_cif->add_registrasi_smk($data2);
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

	public function delete_registrasi_smk()
	{
		$trx_smk_code = $this->input->post('trx_smk_code');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($trx_smk_code) ; $i++ )
		{
			$param = array('trx_smk_code'=>$trx_smk_code[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_registrasi_smk($param);
			$this->model_cif->delete_registrasi_trx_smk($param);
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

	public function get_smk_by_smk_id()
	{
		$trx_smk_id = $this->input->post('trx_smk_id');
		$data = $this->model_cif->get_smk_by_smk_id($trx_smk_id);

		echo json_encode($data);
	}

	public function edit_registrasi_smk()
	{
		$smk_id 				= $this->input->post('smk_id');
		$trx_smk_id 			= $this->input->post('trx_smk_id');
		$sertifikat_no 			= $this->input->post('sertifikat_no2');
		$status_anggota			= $this->input->post('status_anggota2');
		$nama 					= $this->input->post('nama2');
		$nominal 				= $this->convert_numeric($this->input->post('nominal2'));
		$tipe_trx				= $this->input->post('status_option2');
		$created_by				= $this->session->userdata('user_id');
		$created_date			= date('Y-m-d H:i:s');
		// $total2_hide			= $this->input->post('total2_hide');

		if ($status_anggota=='0'){			
			$cif_no 			= $this->input->post('cif_no2');
		}else{
			$cif_no = "";
		}

		if($tipe_trx=='0'){
			$account_cash_code	= "";
			$setoran_tunai 		= 0;
			$tabungan_wajib 	= $this->convert_numeric($this->input->post('tabungan_wajib2'));
			$tabungan_kelompok 	= $this->convert_numeric($this->input->post('tabungan_kelompok2'));
			$total 				= $this->convert_numeric($this->input->post('total2'));
		}else{
			$account_cash_code	= $this->input->post('account_cash_code2');
			$setoran_tunai 		= $this->convert_numeric($this->input->post('setoran_tunai2'));
			$tabungan_wajib 	= 0;
			$tabungan_kelompok 	= 0;
			$total 				= $this->convert_numeric($this->input->post('total2'));
		}
		
		$tanggal_			= $this->input->post('date_issued2');
		$tanggal_mulai		= str_replace("/", "", $tanggal_);
	    $date_issued 		= substr($tanggal_mulai,0,2).'-'.substr($tanggal_mulai,2,2).'-'.substr($tanggal_mulai,4,4);
	    $total_rec 			= $total/50000;

	    //Mendapatkan No Sertifikat Jika Total Merupakan Kelipatan 50000
	    $branch_code 		= $this->session->userdata('branch_code');
		$data 				= $this->model_cif->count_no_sertifikat_by_branch_code($branch_code);
		$jumlah 			= $data['jumlah'];

		if($jumlah==null){
          $num = 0;
        }else{
          $num = $jumlah;
        }

				$data1 = array(
					'cif_no'			=> $cif_no,
					'trx_type'			=> $tipe_trx,
					'account_cash_code'	=> $account_cash_code,
					'setor_tunai'		=> $setoran_tunai,
					'tabungan_wajib'	=> $tabungan_wajib,
					'tabungan_kelompok'	=> $tabungan_kelompok,
					'total'				=> $total,
					'trx_date'			=> $created_date,
					'created_date'		=> $created_date,
					'created_by'		=> $created_by
					);

				$param1 = array('trx_smk_id'=>$trx_smk_id);

			for($i=1;$i<=$total_rec;$i++){
				$data2[] = array(
					'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
					'cif_no' 			=> $cif_no,
					'nama' 				=> $nama,
					'nominal' 			=> 50000,
					'date_issued' 		=> $date_issued,
					'created_by' 		=> $created_by,
					'created_date' 		=> $created_date,
					'status_anggota'	=> $status_anggota,
				);
				$param2[] = array('cif_no'=>$cif_no);
			}

			// if($total_rec!=$total2_hide){
			// 	for($i=1;$i<=($total_rec-$total2_hide);$i++){
			// 		$data3[] = array(
			// 			'sertifikat_no'		=> $branch_code.''.sprintf('%06s', $num+$i),
			// 			'cif_no' 			=> $cif_no,
			// 			'nama' 				=> $nama,
			// 			'nominal' 			=> 50000,
			// 			'date_issued' 		=> $date_issued,
			// 			'created_by' 		=> $created_by,
			// 			'created_date' 		=> $created_date,
			// 			'status_anggota'	=> $status_anggota,
			// 		);
			// 	}
			// }

		$this->db->trans_begin();
		$this->model_cif->edit_trx_smk($data1,$param1);
		for ( $i = 0 ; $i < count($data2) ; $i++ )
		{
			$this->model_cif->edit_registrasi_smk($data2[$i],$param2[$i]);
		}
		// if(count($data3)>0){
		// 	$this->model_cif->add_registrasi_smk($data3);
		// }
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
		
	}

	public function detail_registrasi_smk()
	{
		$trx_smk_id = $this->input->post('trx_smk_id');
		$data 		= $this->model_cif->detail_registrasi_smk($trx_smk_id);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END SMK SETUP
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PELEPASAN SMK SETUP
	/****************************************************************************************/
	public function pelepasan_smk()
	{
		$data['container'] = 'cif/pelepasan_smk';
		$data['branch_code'] = $this->session->userdata('branch_code');
		$data['tanggal'] = date('d-m-Y');
		$this->load->view('core',$data);
	}

	public function datatable_pelepasan_smk_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','sertifikat_no', 'nama', 'nominal','date_issued','');
				
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
		$rResult 			= $this->model_cif->datatable_pelepasan_smk_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_pelepasan_smk_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_pelepasan_smk_setup(); // get number of all data
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

			$row[] = '<input type="checkbox" value="'.$aRow['smk_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['sertifikat_no'];
			$row[] = $aRow['nama'];
			$row[] = $aRow['nominal'];
			$row[] = $aRow['date_issued'];
			$row[] = '<center><a href="javascript:;" smk_id="'.$aRow['smk_id'].'" id="link-edit">Edit</a></center>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function add_pelepasan_smk()
	{
		$smk_id 			= $this->input->post('smk_id3');
		$sertifikat_no 		= $this->input->post('sertifikat_no3');
		$status             = "0";
		$tanggal_mulai		= $this->input->post('date_close3');
		$tgl 				= substr("$tanggal_mulai",0,2);
	    $bln 				= substr("$tanggal_mulai",3,2);
	    $thn 				= substr("$tanggal_mulai",6,4);
	    $date_close 		= "$thn-$bln-$tgl";  

	    $param = array('smk_id'=>$smk_id);

			$data = array(
				'status'			=> $status,
				'date_close' 		=> $date_close
				);
		

		$this->db->trans_begin();
		$this->model_cif->add_pelepasan_smk($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function delete_pelepasan_smk()
	{
		$smk_id = $this->input->post('smk_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($smk_id) ; $i++ )
		{
			$param = array('smk_id'=>$smk_id[$i]);
			$this->db->trans_begin();
			$this->model_cif->delete_registrasi_smk($param);
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

	public function get_pelepasan_smk_by_smk_id()
	{
		$smk_id = $this->input->post('smk_id');
		$data = $this->model_cif->get_smk_by_smk_id($smk_id);

		echo json_encode($data);
	}

	public function edit_pelepasan_smk()
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

		$tgl 				= substr("$tanggal_mulai",0,2);
	    $bln 				= substr("$tanggal_mulai",2,2);
	    $thn 				= substr("$tanggal_mulai",4,4);
	    $date_issued 		= "$thn-$bln-$tgl";  

		$param = array('smk_id'=>$smk_id);

			$data = array(
				'sertifikat_no'		=> $sertifikat_no,
				'nama' 				=> $nama,
				'nominal' 			=> $nominal,
				'date_issued' 		=> $date_issued,
				'status' 			=> $status,				
				'created_by' 		=> $created_by,
				'created_date' 		=> $created_date,
				'status_anggota'	=> $status_anggota,
				'cif_no' 			=> $cif_no
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


	public function ajax_get_value_from_sertifikat_no()
	{
		$sertifikat_no 	= $this->input->post('sertifikat_no');
		$data 			= $this->model_cif->ajax_get_value_from_sertifikat_no($sertifikat_no);

		echo json_encode($data);
	}

	public function search_sertifikat_no()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->search_sertifikat_no($keyword);

		echo json_encode($data);
	}

	public function export_smk()
	{
		$smk_id = $this->uri->segment(3);
		$status = $this->uri->segment(4);

		if ($status==0) 
		{			
			echo "<script>alert('Status Belum Aktif');javascript:window.close();</script>";
		} 
		else if ($status==2)
		{
			echo "<script>alert('Status Tidak Aktif');javascript:window.close();</script>";
		}
		else
		{

		$this->load->library('html2pdf');
		ob_start();

		
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		
		$data['sertifikat'] = $this->model_cif->get_data_from_sertifikat($smk_id,$status);

		$this->load->view('cif/export_smk',$data);

		$content = ob_get_clean();

		try
	    {
	        $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
	        $html2pdf->pdf->SetDisplayMode('fullpage');
	        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	        $html2pdf->Output('Sertifikat.pdf');
	    }
	    catch(HTML2PDF_exception $e) {
	        echo $e;
	        exit;
	    }
	  }
	}
	

	/****************************************************************************************/	
	// END PELEPASAN SMK SETUP
	/****************************************************************************************/

	public function get_all_branch()
	{
		$branch = $this->model_cif->get_all_branch();
		echo json_encode($branch);
	}

	public function get_all_branch_by_id()
	{
		$branch_id 	= $this->input->post('branch_id');
		$branch 	= $this->model_cif->get_all_branch_by_id($branch_id);
		echo json_encode($branch);
	}

	public function get_branch_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->get_branch_by_keyword($keyword);

		echo json_encode($data);
	}


	public function ajax_get_tanggal_jatuh_tempo()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$hari 				= '7';
		$minggu 			= '1';
		$bln 				= '1';
		$angsuranke1 = $this->input->post('angsuranpertama');
		if($periode_angsuran=='0'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' days'));
		}else if($periode_angsuran=='1'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' weeks'));
		}else{
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' months'));
		}

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}

	public function get_desa_by_keyword()
	{
		$keyword 	= $this->input->post('keyword');
		$kecamatan 	= $this->input->post('kecamatan');

		$data 		= $this->model_cif->get_desa_by_keyword($keyword,$kecamatan);

		echo json_encode($data);
	}

	public function get_fa_by_keyword()
	{
		$keyword 		= $this->input->post('keyword');
		$branch_code 	= $this->input->post('branch_code');
		$data 			= $this->model_cif->get_fa_by_keyword($keyword,$branch_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN REGISTRASI PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	public function search_cif_for_pelunasan_pembiayaan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_pelunasan_pembiayaan_v2($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN BLOKIR TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_blokir_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_blokir_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN BUKA BLOKIR TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_buka_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_buka_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN TUTUP TABUNGAN
	/****************************************************************************************/

	public function search_cif_for_tutup_tabungan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_tutup_tabungan($keyword,$type,$cm_code);

		echo json_encode($data);
	}



	/****************************************************************************************/	
	// BEGIN FUNCTION
	/****************************************************************************************/
	public function search_cabang()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_cif->search_cabang($keyword);

		echo json_encode($data);
	}
	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// END FUNCTION CARI ACCOUNT INSURANCE NO
	/****************************************************************************************/

	public function search_account_insurance_no()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_account_insurance_no($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/
	public function anggota_mutasi()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/anggota_mutasi';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/
	public function anggota_keluar()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$this->load->view('core',$data);
	}	

	public function verifikasi_anggota_keluar()
	{
		$this->load->model('model_kelompok');

		$data['container'] = 'kelompok/verifikasi_anggota_keluar';
		$data['kecamatan'] = $this->model_kelompok->get_all_mfi_city_kecamatan();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function datatable_verifikasi_mutasi_anggota_keluar()
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
	    
		$aColumns = array( '','cm_code','cif_no','nama','created_date','created_by','');
				
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

		$rResult 			= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar($sWhere,$sOrder,$sLimit,$branch_id,$branch_code,$trx_date); // query get data to view
		$rResultFilterTotal = $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar($sWhere,'','',$branch_id,$branch_code,$trx_date); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_kelompok->datatable_verifikasi_mutasi_anggota_keluar('','','',$branch_id,$branch_code,$trx_date); // get number of all data
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
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];
			$row[] = '<div align="center">'.$aRow['tanggal_mutasi'].'</div>';
			$row[] = '<div align="center">'.$aRow['created_date'].'</div>';
			$row[] = '<div align="center">'.$aRow['created_by'].'</div>';
			$row[] = '<div align="center">
						<a href="javascript:;" cm_code="'.$aRow['cm_code'].'" cm_name="'.$aRow['cm_name'].'" cif_no="'.$aRow['cif_no'].'" nama="'.$aRow['nama'].'" cif_mutasi_id="'.$aRow['cif_mutasi_id'].'" id="link-verifikasi">Verifikasi</a>
						<input type="hidden" id="h_alasan" value="'.$aRow['alasan'].'">
						<input type="hidden" id="h_potongan_pembiayaan" value="'.$aRow['potongan_pembiayaan'].'">
					  </div>';
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL MULAI ANGSUR
	/****************************************************************************************/
	public function ajax_get_tanggal_angsur_pertama()
	{
		$tgl_akad = $this->input->post('tgl_akad');
		$periode_angsuran = $this->input->post('periode_angsuran');
		// $grace_periode = $this->model_transaction->get_grace_periode();
		// $grace = 0;
		/**
		* tidak jadi menggunakan grace periode
		* ketentuan tanggal sesuai ketentuan dari TAM
		*/
		switch ($periode_angsuran) {
			case '0'://harian
				// $grace=substr($grace_periode, 0,1); // digit 1
				$angsuranke1 = date('d/m/Y',strtotime($tgl_akad.'+4 days'));
				break;
			case '1'://mingguan
				// $grace=substr($grace_periode, 1,1); // digit 2
				$angsuranke1 = date('d/m/Y',strtotime($tgl_akad.'+1 week'));
				break;
			case '2'://bulanan
				// $grace=substr($grace_periode, 2,1); // digit 3
				$angsuranke1 = date('d/m/Y',strtotime($tgl_akad.'+1 month'));
				break;
			case '3': //jatuh tempo
				$angsuranke1 = $tgl_akad;
				break;
			default: //default
				$angsuranke1 = $tgl_akad;
				break;
		}

		echo json_encode(array('angsuranke1'=>$angsuranke1));
	}

	/****************************************************************************************/	
	// END GET AJAX TANGGAL MULAI ANGSUR
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL SEKARANG
	/****************************************************************************************/
	public function ajax_get_date_now()
	{
		$tgl_akad 				= $this->input->post('tgl_akad');
		$date_now				= date('Y-m-d');
		$tgl     				= substr("$date_now",8,2);
	    $bln     				= substr("$date_now",5,2);
	    $thn	        		= substr("$date_now",0,4);
	    $tglakhir				= "$tgl-$bln-$thn";
	    $hari 					= '7';
	    $tgl_akad_sementara 	= date('d/m/Y',strtotime($tglakhir. '+'.$hari.' days'));

		echo json_encode(array('date_now'=>$tglakhir,'date_akad'=>$tgl_akad_sementara));
	}

	/****************************************************************************************/	
	// END GET AJAX TANGGAL SEKARANG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/
	public function ajax_get_tanggal_jatuh_tempo2()
	{
		$periode_angsuran 	= $this->input->post('periode_angsuran');
		$angsuranke1 		= $this->input->post('angsuranpertama');
		$jangka_waktu 		= $this->input->post('jangka_waktu')-1;
		if($periode_angsuran=='0'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' days'));
		}else if($periode_angsuran=='1'){
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' weeks'));
		}else{
			$jatuh_tempo = date('d/m/Y',strtotime($angsuranke1. '+'.$jangka_waktu.' months'));
		}

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}
	/****************************************************************************************/	
	// END GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN FUNCTION
	/****************************************************************************************/
	public function search_cif()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_cif->search_cif($keyword);

		echo json_encode($data);
	}
	/****************************************************************************************/	
	// END FUNCTION
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/
	public function ajax_get_tanggal_jatuh_tempo_deposito()
	{
		$jangka_waktu 	= $this->input->post('jangka_waktu');
		$tgl_sekarang 	= $this->input->post('tgl_sekarang');

		$jatuh_tempo = date('d/m/Y',strtotime($tgl_sekarang. '+'.$jangka_waktu.' months'));

		echo json_encode(array('jatuh_tempo'=>$jatuh_tempo));
	}

	public function ajax_get_tanggal_jatuh_tempo_next_deposito()
	{
		$jangka_waktu 	= "1";
		$tgl_sekarang 	= $this->input->post('tgl_sekarang');
		
		$jatuh_tempo_next = date('d/m/Y',strtotime($tgl_sekarang. '+'.$jangka_waktu.' months'));

		echo json_encode(array('jatuh_tempo_next'=>$jatuh_tempo_next));
	}
	/****************************************************************************************/	
	// END GET AJAX TANGGAL JATUH TEMPO
	/****************************************************************************************/

	public function search_no_pembiayaan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_no_pembiayaan($keyword,$type,$cm_code);

		echo json_encode($data);
	}

	/******************************************************************************************/
	//TAMBAHAN ADE, BRANCH 5 DIGIT
	public function get_all_branch_wilayah()
	{
		$branch = $this->model_cif->get_all_branch_wilayah();
		echo json_encode($branch);
	}
	public function get_all_branch_cabang()
	{
		$branch = $this->model_cif->get_all_branch_cabang();
		echo json_encode($branch);
	}
	//END TAMBAHAN ADE, BRANCH 5 DIGIT
	/******************************************************************************************/

	public function get_cabang()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_cif->get_cabang($keyword);
		echo json_encode($data);
	}

	public function search_cif_for_cetak_persetujuan_pembiayaan()
	{
		$keyword 	= $this->input->post('keyword');
		$type 		= $this->input->post('cif_type');
		$cm_code 	= $this->input->post('cm_code');
		$data 		= $this->model_cif->search_cif_for_cetak_persetujuan_pembiayaan($keyword,$type,$cm_code);

		echo json_encode($data);
	}/*

	public function check_exist_rekening()
	{
	    
		$table = $this->uri->segment(3);
		$field = $this->uri->segment(4);
		$param = $this->input->post('cif_no');

		for ( $i = 0 ; $i < count($param) ; $i++ )
		{
			$param = array('cif_no'=>$param[$i]);
			$check_exist = $this->model_cif->check_exist($table,"$field = '$param' ",$field);

		}
		
		if($check_exist['total']>0){
			$return = array('stat'=>true);
		}else{
			$return = array('stat'=>false);
		}

		echo json_encode($return);
		
	}*/

	/**
	* @param : id_jenis, no_identitas
	*/
	function ajax_no_identitas_same_is_exists()
	{
		$id_jenis = $this->input->post('id_jenis');
		$no_ktp = $this->input->post('no_ktp');
		$no_identitas_same_is_exists = $this->model_cif->no_identitas_same_is_exists($id_jenis,$no_ktp);
		$return = array('result'=>$no_identitas_same_is_exists);
		echo json_encode($return);
	}

	/**
	* @param : id_jenis, no_identitas
	*/
	function ajax_no_identitas_pasangan_same_is_exists()
	{
		$id_jenis = $this->input->post('id_jenis');
		$no_ktp = $this->input->post('no_ktp');
		$no_identitas_pasangan_same_is_exists = $this->model_cif->no_identitas_pasangan_same_is_exists($id_jenis,$no_ktp);
		$return = array('result'=>$no_identitas_pasangan_same_is_exists);
		echo json_encode($return);
	}

	
	/*********************************************************************************************/
	//BEGIN KOPTEL
	/*********************************************************************************************/
	public function search_cif_no_koptel()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_cif->search_cif_no_koptel($keyword);

		echo json_encode($data);
	}

	/**
	*Begin Daftar pegawai & special rate, Ade Sagita 28-03-2015 20:30
	*/
	public function list_pegawai()
	{
		$data['container'] = 'cif/list_pegawai';
		$this->load->view('core',$data);
	}

	public function datatable_pegawai_koptel()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$aColumns = array('mfi_pegawai.nik','nama_pegawai','kode_posisi','thp','thp','');
				
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

		$rResult 			= $this->model_cif->datatable_pegawai_koptel($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_pegawai_koptel($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_pegawai_koptel(); // get number of all data
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
			if($aRow['status_rate']=='1'){
				$btn = '<button type="button" class="btn mini purple" disabled=""><i class="icon-ok-sign"></i> Spesial Rate</button>';
			}else{
				$btn = '<a class="btn mini green" href="javascript:;" nik="'.$aRow['nik'].'" nama_pegawai="'.$aRow['nama_pegawai'].'" id="link-spesial-rate"><i class="icon-ok-sign"></i> Spesial Rate</a>';
			}
			$row[] = $aRow['nik'];
			$row[] = $aRow['nama_pegawai'];
			$row[] = $aRow['code_divisi'].' | '.$aRow['kode_posisi'].' | '.$aRow['posisi'];
			$row[] = number_format($aRow['thp']);
			$row[] = number_format(($aRow['thp']*40/100));
			$row[] = $btn;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function do_spesial_rate()
	{
		$nik = $this->input->post('nik');
		$nama_pegawai = $this->input->post('nama_pegawai');

		$data = array(
						'nik'=>$nik
						,'nama'=>trim($nama_pegawai)
						,'status'=>1
						,'created_date'=>date('Y-m-d H:i:s')
						,'created_by'=>$this->session->userdata('user_id')
					 );

		$param = array('nik'=>$nik,'status'=>1);

		$this->db->trans_begin();		
		$this->model_cif->delete_spesial_rate($param); //hapus semua rate atas nik tsb yang status masih 1 (belum digunakan)
		$this->model_cif->save_spesial_rate($data);//hapus semua rate atas nik tsb
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
	*End pegawai & special rate
	*/


	public function registrasi()
	{
		$data['container'] = 'cif/registrasi';
		$data['kopegtel'] = $this->model_cif->get_kopegtel();
		$this->load->view('core',$data);
	}

	public function datatable_cif()
	{
		ini_set('memory_limit', '-1');
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array('a.code_divisi','a.kode_loker','a.loker','a.nik','a.nama_pegawai','a.tgl_lahir','');
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
					$sWhere .= "LOWER(".$aColumns[$i]."::varchar) LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
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
					$sWhere .= "LOWER(".$aColumns[$i]."::varchar) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_cif->datatable_cif($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_cif->datatable_cif($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_cif->datatable_cif(); // get number of all data
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
			// $row[] = '<input type="checkbox" value="'.$aRow['pegawai_id'].'" pegawai_id="'.$aRow['pegawai_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_divisi'];
			$row[] = $aRow['kode_loker'];
			$row[] = $aRow['loker'];
			$row[] = $aRow['nik'];
			$row[] = $aRow['nama_pegawai'];
			$row[] = $aRow['tgl_lahir'];
			$row[] = '<a href="javascript:;" class="btn purple mini" pegawai_id="'.$aRow['pegawai_id'].'" id="link-edit">Edit</a>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}	

	public function add_new_cif()
	{
		$nik 				= $this->input->post('nik');
		$nama_pegawai 		= $this->input->post('nama_pegawai');
		$personal_area 		= $this->input->post('personal_area');
		$psa 				= $this->input->post('psa');
		$vpsa 				= $this->input->post('vpsa');
		$code_divisi 		= $this->input->post('code_divisi');
		$kode_loker 		= $this->input->post('kode_loker');
		$loker 				= $this->input->post('loker');
		$kode_posisi 		= $this->input->post('kode_posisi');
		$posisi 			= $this->input->post('posisi');
		$tgl_mulai_kerja	= $this->datepicker_convert(true,$this->input->post('tgl_mulai_kerja'),'/');;
		$kerja_bantu 		= $this->input->post('kerja_bantu');
		$band 				= $this->input->post('band');
		$klas 				= $this->input->post('klas');
		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->datepicker_convert(true,$this->input->post('tgl_lahir'),'/');;
		$gender 			= $this->input->post('gender');
		$tgl_capeg 			= $this->datepicker_convert(true,$this->input->post('tgl_capeg'),'/');;
		$tgl_pensiun_normal = $this->datepicker_convert(true,$this->input->post('tgl_pensiun_normal'),'/');;
		$alamat				= $this->input->post('alamat');
		$kota 				= $this->input->post('kota');
		$status 			= $this->input->post('status');
		$agama 				= $this->input->post('agama');
		$gadas 				= $this->convert_numeric($this->input->post('gadas'));
		$perumahan 			= $this->convert_numeric($this->input->post('perumahan'));
		$koptel 			= $this->convert_numeric($this->input->post('koptel'));
		$thp 				= $this->convert_numeric($this->input->post('thp'));
		$kopegtel_code 		= $this->input->post('kopegtel_code');
		
		$data = array(
				 'nik'					=> $nik
				,'nama_pegawai'			=> $nama_pegawai
				,'personal_area'		=> $personal_area
				,'psa'					=> $psa
				,'vpsa'					=> $vpsa
				,'code_divisi'			=> $code_divisi
				,'kode_loker'			=> $kode_loker
				,'loker'				=> $loker
				,'kode_posisi'			=> $kode_posisi
				,'posisi'				=> $posisi
				,'tgl_mulai_kerja'		=> $tgl_mulai_kerja
				,'kerja_bantu'			=> $kerja_bantu
				,'band'					=> $band
				,'klas'					=> $klas
				,'tempat_lahir'			=> $tempat_lahir
				,'tgl_lahir'			=> $tgl_lahir
				,'gender'				=> $gender
				,'tgl_capeg'			=> $tgl_capeg
				,'tgl_pensiun_normal'	=> $tgl_pensiun_normal
				,'alamat'				=> $alamat
				,'kota'					=> $kota
				,'status'				=> $status
				,'agama'				=> $agama
				,'gadas'				=> $gadas
				,'perumahan'			=> $perumahan
				,'koptel'				=> $koptel
				,'thp'					=> $thp
			);
		$usia = $this->getUsia($tgl_lahir,date('Y-m-d'));
		$this->db->trans_begin();
		$this->model_cif->save_pegawai($data);
		$this->db->query("insert into mfi_cif (cif_no,nama,panggilan,branch_code,status,cif_type,tmp_lahir,tgl_lahir,usia,alamat,kabupaten,pekerjaan,tgl_gabung)
		select nik,nama_pegawai,nama_pegawai,'00000','1','1',tempat_lahir,tgl_lahir,$usia,alamat,kota,kode_loker,tgl_mulai_kerja
		from mfi_pegawai
		where nik ='$nik' ");
		$this->db->query("insert into mfi_account_saving (product_code,cif_no,account_saving_no,branch_code,tanggal_buka,status_rekening,saldo_riil,saldo_memo,created_by,created_date,counter_angsruan)
		select '09',cif_no,cif_no,branch_code,now(),1,0,0,'SYS',now(),0 from mfi_cif 
		where cif_no='$nik' ");

		/* inserting to pegawai kopegtel */
		$this->db->query("
			INSERT INTO mfi_pegawai_kopegtel_log (id,nik,kopegtel_code,kopegtel_code_lama,log_date)
			SELECT pegawai_kopegtel_id,nik,kopegtel_code,kopegtel_code_lama,now() FROM mfi_pegawai_kopegtel WHERE nik=?;

			DELETE FROM mfi_pegawai_kopegtel WHERE nik=?;

			INSERT INTO mfi_pegawai_kopegtel (pegawai_kopegtel_id,nik,kopegtel_code,kopegtel_code_lama)
			VALUES (uuid(),?,?,NULL);
		", array($nik,$nik,$nik,$kopegtel_code));

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function getUsia($date,$date2='')
	{
		date_default_timezone_set('Asia/Jakarta');
		if ($date2=='') {
			$date2 = date('Y-m-d');
		}
		$day = $this->ExtractPeriodDate($date2,$date,'FullDay');
		$usia = round($day/365.25,0);
    	// $usia = array('usia'=>$usia);
    	return $usia;
	}
	function ExtractPeriodDate($from_date,$thru_date,$type) {

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
			case 'FullMonth':
			$time = $interval->format('%m') + ($interval->format('%y') * 12);
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

	function get_pegawai_by_pegawai_id()
	{
		$pegawai_id = $this->input->post('pegawai_id');
		$data = $this->model_cif->get_pegawai_by_pegawai_id($pegawai_id);
		echo json_encode($data);
	}

	public function update_pegawai()
	{
		$pegawai_id 		= $this->input->post('pegawai_id');
		$nik 				= $this->input->post('nik');
		$nama_pegawai 		= $this->input->post('nama_pegawai');
		$personal_area 		= $this->input->post('personal_area');
		$psa 				= $this->input->post('psa');
		$vpsa 				= $this->input->post('vpsa');
		$code_divisi 		= $this->input->post('code_divisi');
		$kode_loker 		= $this->input->post('kode_loker');
		$loker 				= $this->input->post('loker');
		$kode_posisi 		= $this->input->post('kode_posisi');
		$posisi 			= $this->input->post('posisi');
		$tgl_mulai_kerja	= $this->datepicker_convert(true,$this->input->post('tgl_mulai_kerja'),'/');;
		$kerja_bantu 		= $this->input->post('kerja_bantu');
		$band 				= $this->input->post('band');
		$klas 				= $this->input->post('klas');
		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->datepicker_convert(true,$this->input->post('tgl_lahir'),'/');;
		$gender 			= $this->input->post('gender');
		$tgl_capeg 			= $this->datepicker_convert(true,$this->input->post('tgl_capeg'),'/');;
		$tgl_pensiun_normal = $this->datepicker_convert(true,$this->input->post('tgl_pensiun_normal'),'/');;
		$alamat				= $this->input->post('alamat');
		$kota 				= $this->input->post('kota');
		$status 			= $this->input->post('status');
		$agama 				= $this->input->post('agama');
		$gadas 				= $this->convert_numeric($this->input->post('gadas'));
		$perumahan 			= $this->convert_numeric($this->input->post('perumahan'));
		$koptel 			= $this->convert_numeric($this->input->post('koptel'));
		$thp 				= $this->convert_numeric($this->input->post('thp'));
		$kopegtel_code 		= $this->input->post('kopegtel_code');
		
		$usia = $this->getUsia($tgl_lahir,date('Y-m-d'));

		$data = array(
				 'nama_pegawai'			=> $nama_pegawai
				,'personal_area'		=> $personal_area
				,'psa'					=> $psa
				,'vpsa'					=> $vpsa
				,'code_divisi'			=> $code_divisi
				,'kode_loker'			=> $kode_loker
				,'loker'				=> $loker
				,'kode_posisi'			=> $kode_posisi
				,'posisi'				=> $posisi
				,'tgl_mulai_kerja'		=> $tgl_mulai_kerja
				,'kerja_bantu'			=> $kerja_bantu
				,'band'					=> $band
				,'klas'					=> $klas
				,'tempat_lahir'			=> $tempat_lahir
				,'tgl_lahir'			=> $tgl_lahir
				,'gender'				=> $gender
				,'tgl_capeg'			=> $tgl_capeg
				,'tgl_pensiun_normal'	=> $tgl_pensiun_normal
				,'alamat'				=> $alamat
				,'kota'					=> $kota
				,'status'				=> $status
				,'agama'				=> $agama
				,'gadas'				=> $gadas
				,'perumahan'			=> $perumahan
				,'koptel'				=> $koptel
				,'thp'					=> $thp
			);
		$param = array('pegawai_id'=>$pegawai_id);
			$data_cif = array(
									'nama' => $nama_pegawai
									,'panggilan' => $nama_pegawai
									,'tmp_lahir' => $tempat_lahir
									,'tgl_lahir' => $tgl_lahir
									,'usia' => $usia
									,'alamat' => $alamat
									,'kabupaten' => $kota
									,'pekerjaan' => $kode_loker
									,'tgl_gabung' => $tgl_mulai_kerja
								);
		$param_cif = array('cif_no'=>$nik);

		$this->db->trans_begin();
		$this->model_cif->update_pegawai($data,$param);
		$this->model_cif->update_cif($data_cif,$param_cif);


		/* inserting to pegawai kopegtel */
		$this->db->query("
			INSERT INTO mfi_pegawai_kopegtel_log (id,nik,kopegtel_code,kopegtel_code_lama,log_date)
			SELECT pegawai_kopegtel_id,nik,kopegtel_code,kopegtel_code_lama,now() FROM mfi_pegawai_kopegtel WHERE nik=?;

			DELETE FROM mfi_pegawai_kopegtel WHERE nik=?;

			INSERT INTO mfi_pegawai_kopegtel (pegawai_kopegtel_id,nik,kopegtel_code,kopegtel_code_lama)
			VALUES (uuid(),?,?,NULL);
		", array($nik,$nik,$nik,$kopegtel_code));
		
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/*********************************************************************************************/
	//END KOPTEL
	/*********************************************************************************************/

}

/* End of file group.php */
/* Location: ./application/controllers/group.php */