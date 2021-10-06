<?php

Class Model_cif extends CI_Model {

	public function insert_cif($data)
	{
		$this->db->insert('mfi_cif',$data);		
	}

	public function insert_cif_kelompok($data)
	{
		$this->db->insert('mfi_cif_kelompok',$data);
	}

	public function update_cif($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);		
	}

	public function update_cif_kelompok($data,$param)
	{
		$this->db->update('mfi_cif_kelompok',$data,$param);
	}

	public function datatable_cif_kelompok($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_cif.*,mfi_cm.cm_name FROM mfi_cif LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND cif_type = 0";
		}else{
			$sql .= " WHERE cif_type = 0";
		}

		// if ( $sOrder != "" )
			$sql .= "ORDER BY mfi_cif.status,mfi_cif.kelompok::integer ASC ";
			// $sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_rembug_by_keyword($keyword,$branch_id)
	{
		$sql = "select cm_code,cm_name from mfi_cm where (UPPER(cm_name) like ? or UPPER(cm_code) like ?)";
		if($branch_id!=""){
			$sql .= " and branch_id = ?";
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%',$branch_id));
		}
		else
		{
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));
		}

		return $query->result_array();
	}

	public function delete_cif_kelompok($param){

		$cif_no = $this->get_cif_no_by_cif_id($param['cif_id']);
		
		$this->db->delete('mfi_account_default_balance',array('cif_no'=>$cif_no));
		$this->db->delete('mfi_cif_kelompok',$param);
		$this->db->delete('mfi_cif',$param);
	}

	public function get_cif_no_by_cif_id($cif_id)
	{	
		$this->db->select('cif_no');
		$this->db->where('cif_id',$cif_id);
		$sql = $this->db->get('mfi_cif');
		$row = $sql->row_array();

		return $row['cif_no'];
	}

	public function delete_cif_individu($param){
		$this->db->delete('mfi_cif',$param);
	}

	/********************************************************************************************/

	public function datatable_rembug_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_cm.cm_id,mfi_cm.cm_name,mfi_cm.branch_id,mfi_branch.branch_id,mfi_branch.branch_name, mfi_kecamatan_desa.desa_code,mfi_kecamatan_desa.desa 
				FROM mfi_cm
				LEFT JOIN mfi_kecamatan_desa ON mfi_kecamatan_desa.desa_code = mfi_cm.desa_code
				LEFT JOIN mfi_branch ON mfi_cm.branch_id = mfi_branch.branch_id ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add_rembug($data)
	{
		$this->db->insert('mfi_cm',$data);
	}

	public function delete_rembug($param)
	{
		$this->db->delete('mfi_cm',$param);
	}

	public function get_user_by_cm_id($cm_id)
	{
		$sql = "SELECT
				mfi_cm.cm_id,
				mfi_cm.cm_name,
				mfi_cm.cm_code,
				mfi_cm.desa_code,
				mfi_kecamatan_desa.desa,
				mfi_cm.fa_code,
				mfi_cm.hari_transaksi,
				mfi_fa.fa_name
				FROM
				mfi_fa
				INNER JOIN mfi_cm ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_kecamatan_desa ON mfi_kecamatan_desa.desa_code = mfi_cm.desa_code
				WHERE cm_id = ?";
		$query = $this->db->query($sql,array($cm_id));

		return $query->row_array();
	}

	public function edit_rembug($data,$param)
	{
		$this->db->update('mfi_cm',$data,$param);
	}

	public function get_all_petugas()
	{
		$sql = "SELECT * from mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_gl_account_by_account_code($account_code)
	{
		$sql = 'select * from mfi_gl_account where account_code = ?';
		$query = $this->db->query($sql,array($account_code));

		return $query->row_array();
	}

	public function get_ajax_branch_code_($branch_id)
	{
		$sql = "select max(right(cm_code,4)) AS jumlah from mfi_cm where branch_id = ?";
		$query = $this->db->query($sql,array($branch_id));

		return $query->row_array();
	}

	public function get_ajax_sequenc_fa($branch_code)
	{
		$sql = "select max(right(fa_code,4)) AS max from mfi_fa where left(branch_code,5) = ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->row_array();
	}

	/********************************************************************************************/

	// [BEGIN] BRANCH SETUP KANTOR CABANG

	public function datatable_kantor_cabang_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
							mfi_branch.branch_id,
							mfi_branch.branch_name,
							mfi_branch.branch_status,
							mfi_branch.branch_code,
							mfi_branch.branch_induk,
							mfi_branch.branch_class,
							mfi_branch.branch_grade,
							mfi_branch.tanggal_buka,
							mfi_branch.branch_officer_name,
							mfi_branch.branch_officer_title,
							mfi_jabatan.kode_jabatan as code_value,
							mfi_jabatan.nama_jabatan as display_text
				FROM
							mfi_branch
				LEFT JOIN mfi_jabatan ON mfi_branch.branch_officer_title = mfi_jabatan.kode_jabatan
				WHERE mfi_branch.branch_code!='00000'				
				 ";

			if ($flag_all_branch==0) {
				$sql .= " AND mfi_branch.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
				$param[] = $branch_code;
			}
		
		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_all_branch()
    {
        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        			FROM 
        				 mfi_branch
				WHERE 
						branch_class=0";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	function get_all_branch_by_id($branch_id)
    {
        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        			FROM 
        				 mfi_branch
				WHERE 
						branch_class=0 AND branch_id = ?";

		$query = $this->db->query($sql,array($branch_id));

		return $query->result_array();
    }

	public function add_kantor_cabang($data)
	{
		$this->db->insert('mfi_branch',$data);
	}

	public function delete_kantor_cabang($param)
	{
		$this->db->delete('mfi_branch',$param);
	}

	public function edit_kantor_cabang($data,$param)
	{
		$this->db->update('mfi_branch',$data,$param);
	}

	public function get_branch_by_branch_id($branch_id)
	{
		$sql = "SELECT
							mfi_branch.branch_id,
							mfi_branch.branch_name,
							mfi_branch.branch_status,
							mfi_branch.branch_code,
							mfi_branch.branch_induk,
							mfi_branch.branch_class,
							mfi_branch.branch_grade,
							mfi_branch.tanggal_buka,
							mfi_branch.wilayah,
							mfi_branch.branch_officer_name,
							mfi_branch.branch_officer_title,
							mfi_jabatan.kode_jabatan as code_value,
							mfi_jabatan.nama_jabatan display_text
				FROM
							mfi_branch
				INNER JOIN mfi_jabatan ON mfi_branch.branch_officer_title = mfi_jabatan.kode_jabatan
				WHERE  mfi_branch.branch_id = ?";

		$query = $this->db->query($sql,array($branch_id));

		return $query->row_array();
	}

	// [END] BRANCH  SETUP KANTOR CABANG

	/********************************************************************************************/

	/********************************************************************************************/

	// [BEGIN] BRANCH SETUP PETUGAS LAPANGAN

	public function datatable_petugas_lapangan($sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_fa.fa_id,
				mfi_fa.fa_name,
				mfi_fa.fa_code,
				mfi_fa.branch_code,
				mfi_branch.branch_name
				FROM
				mfi_branch
				INNER JOIN mfi_fa ON mfi_branch.branch_code = mfi_fa.branch_code
				WHERE mfi_fa.fa_id IS NOT NULL
 				";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function add_petugas($data)
	{
		$this->db->insert('mfi_fa',$data);
	}

	public function delete_petugas($param)
	{
		$this->db->delete('mfi_fa',$param);
	}

	public function get_petugas_by_id($fa_id)
	{
		$sql = "SELECT fa_id,fa_name,fa_code,branch_code,fa_level FROM mfi_fa WHERE fa_id = ?";
		$query = $this->db->query($sql,array($fa_id));

		return $query->row_array();
	}

	public function get_ajax_branch_code($code)
	{
		$sql = "select max(substr(fa_code,5)) AS jumlah from mfi_fa where left(branch_code,5) = ?";
		$query = $this->db->query($sql,array($code));

		return $query->row_array();
	}

	function get_all_branch_()
	{
	    $sql = "SELECT 
					     branch_id
					    ,branch_code
					    ,branch_name
				    FROM 
					     mfi_branch";
    
		    $query = $this->db->query($sql);
    
		    return $query->result_array();
	}

	public function edit_petugas($data,$param)
	{
		$this->db->update('mfi_fa',$data,$param);
	}

	public function search_fa_name($branch_code)
	{
		$sql = "select * from mfi_fa where branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
	}

	public function search_cabang($keyword)
	{
		$sql = "SELECT 
							'00000' branch_id
							,'Semua Branch' branch_name
							,1 branch_status
							,'00000' branch_code
							,'00000' branch_induk
							,null branch_grade
							,null tanggal_buka
							,officer_name branch_officer_name
							, officer_title branch_officer_title 
				from mfi_institution
				union all
				select 
							a.branch_id
							,a.branch_name
							,a.branch_status
							,a.branch_code
							,a.branch_induk
							,a.branch_grade
							,a.tanggal_buka
							,a.branch_officer_name
							,b.display_text branch_officer_title 
				from mfi_branch a, mfi_list_code_detail b 
			where 
					a.branch_officer_title=b.code_value
					AND b.code_group='jabatan'
					AND (upper(branch_name) like ? or branch_code like ?)";

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		

		// print_r($this->db);

		return $query->result_array();
	}

	// search cif number
	public function search_cif_no($keyword,$type,$cm_code)
	{

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT   cif_no
						,nama
						,cm_name 
				FROM mfi_cif 
				left join mfi_cm on mfi_cm.cm_code = mfi_cif.cm_code 
				left join mfi_pegawai ON mfi_pegawai.nik=mfi_cif.cif_no
				where (upper(mfi_cif.nama) like ? or mfi_cif.cif_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		// if($type!="") {

		// 	$sql 	.= ' and mfi_cif.cif_type = ?';
		// 	$param[] = $type;

		// }

		// if($cm_code!="" && $type=="0") {
		// 	$sql .= ' and mfi_cif.cm_code = ?';
		// 	$param[] = $cm_code;
		// }


		// if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
		// 	$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
		// 	$param[] = $branch_code;
		// }

		$query = $this->db->query($sql,$param);
		// print_r($this->db);

		return $query->result_array();
	}

	public function search_pemegang_rekening_bycif_no($cif_no)
	{
			$sql = "SELECT
			mfi_cif.nama,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			where mfi_cif.cif_no = ?";
			$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function search_cif_no2($keyword,$type)
	{
			$sql = "SELECT
			mfi_cif.nama,
			mfi_cm.cm_name,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
			where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)";
		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%',$type));
		}else{

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_cif_kelompok_by_cif_id($cif_id)
	{
		$sql = "select 
		mfi_cif.cif_id,
		mfi_cif.tgl_gabung,
		mfi_cif.cm_code,
		mfi_cif.cif_no,
		mfi_cif.nama,
		mfi_cif.panggilan,
		mfi_cif.kelompok,
		mfi_cif.jenis_kelamin,
		mfi_cif.ibu_kandung,
		mfi_cif.tmp_lahir,
		mfi_cif.tgl_lahir,
		mfi_cif.usia,
		mfi_cif.alamat,
		mfi_cif.rt_rw,
		mfi_cif.desa,
		mfi_cif.kecamatan,
		mfi_cif.kabupaten,
		mfi_cif.kodepos,
		mfi_cif.no_ktp,
		mfi_cif.no_npwp,
		mfi_cif.telpon_rumah,
		mfi_cif.telpon_seluler,
		mfi_cif.pendidikan,
		mfi_cif.status_perkawinan,
		mfi_cif.pekerjaan,
		mfi_cif.ket_pekerjaan,
		mfi_cif.pendapatan_perbulan,
		mfi_cif.tgl_gabung,
		mfi_cif.created_by,
		mfi_cif.created_timestamp,
		mfi_cif.branch_code,
		mfi_cif.cif_type,
		mfi_cif.koresponden_alamat,
		mfi_cif.koresponden_rt_rw,
		mfi_cif.koresponden_desa,
		mfi_cif.koresponden_kecamatan,
		mfi_cif.koresponden_kabupaten,
		mfi_cif.koresponden_kodepos,

		mfi_cif_kelompok.cif_kelompok_id,
		mfi_cif_kelompok.setoran_lwk,
		mfi_cif_kelompok.setoran_mingguan,
		mfi_cif_kelompok.pendapatan,
		mfi_cif_kelompok.literasi_latin,
		mfi_cif_kelompok.literasi_arab,
		mfi_cif_kelompok.p_nama,
		mfi_cif_kelompok.p_tmplahir,
		mfi_cif_kelompok.p_tglahir,
		mfi_cif_kelompok.p_usia,
		mfi_cif_kelompok.p_pendidikan,
		mfi_cif_kelompok.p_pekerjaan,
		mfi_cif_kelompok.p_ketpekerjaan,
		mfi_cif_kelompok.p_pendapatan,
		mfi_cif_kelompok.p_periodependapatan,
		mfi_cif_kelompok.p_literasi_latin,
		mfi_cif_kelompok.p_literasi_arab,
		mfi_cif_kelompok.p_jmltanggungan,
		mfi_cif_kelompok.p_jmlkeluarga,
		mfi_cif_kelompok.rmhstatus,
		mfi_cif_kelompok.rmhukuran,
		mfi_cif_kelompok.rmhatap,
		mfi_cif_kelompok.rmhdinding,
		mfi_cif_kelompok.rmhlantai,
		mfi_cif_kelompok.rmhjamban,
		mfi_cif_kelompok.rmhair,
		mfi_cif_kelompok.lahansawah,
		mfi_cif_kelompok.lahankebun,
		mfi_cif_kelompok.lahanpekarangan,
		mfi_cif_kelompok.ternakkerbau,
		mfi_cif_kelompok.ternakdomba,
		mfi_cif_kelompok.ternakunggas,
		mfi_cif_kelompok.elektape,
		mfi_cif_kelompok.elektv,
		mfi_cif_kelompok.elekplayer,
		mfi_cif_kelompok.elekkulkas,
		mfi_cif_kelompok.kendsepeda,
		mfi_cif_kelompok.kendmotor,
		mfi_cif_kelompok.ushrumahtangga,
		mfi_cif_kelompok.ushkomoditi,
		mfi_cif_kelompok.ushlokasi,
		mfi_cif_kelompok.ushomset,
		mfi_cif_kelompok.byaberas,
		mfi_cif_kelompok.byadapur,
		mfi_cif_kelompok.byalistrik,
		mfi_cif_kelompok.byatelpon,
		mfi_cif_kelompok.byasekolah,
		mfi_cif_kelompok.byalain,
		mfi_cm.cm_name
		from mfi_cif
		left join mfi_cif_kelompok on mfi_cif.cif_id = mfi_cif_kelompok.cif_id 
		left join mfi_cm on mfi_cm.cm_code = mfi_cif.cm_code
		where 
		mfi_cif.cif_id = ?";
		$query = $this->db->query($sql,array($cif_id));
		// print_r($this->db);
		return $query->row_array();
	}
	
	// ###########################################################################

	//kabupaten

	public function add_city($data)
	{
		$this->db->insert('mfi_province_city', $data);
	}

	public function get_city_by_id($city_code)
	{
		$sql = "SELECT * FROM mfi_province_city WHERE city_code = ? ";
		$query = $this->db->query($sql, array($city_code));

		return $query->row_array();
	}

	public function get_province()
	{
		$query = $this->db->get('mfi_province_code');
		return $query->result_array();
	}

	public function edit_city($data, $param)
	{
		$this->db->update('mfi_province_city',$data, $param);
	}

	public function delete_city($param)
	{
		$this->db->delete('mfi_province_city',$param);
	}

	//kecamatan

	public function add_kecamatan($data)
	{
		$this->db->insert('mfi_city_kecamatan', $data);
	}

	public function get_kecamatan_by_id($city_kecamatan_id)
	{
		$sql = "SELECT
				mfi_city_kecamatan.city_kecamatan_id,
				mfi_city_kecamatan.city_code,
				mfi_city_kecamatan.kecamatan_code,
				mfi_city_kecamatan.kecamatan,
				mfi_province_city.city
				FROM
				mfi_city_kecamatan
				INNER JOIN mfi_province_city ON mfi_province_city.city_code = mfi_city_kecamatan.city_code
				WHERE city_kecamatan_id = ? ";
		$query = $this->db->query($sql, array($city_kecamatan_id));

		return $query->row_array();
	}

	public function get_ajax_city_code($city_code)
	{
		$sql = "select max(substr(kecamatan_code,5)) AS jumlah from mfi_city_kecamatan where left(city_code,4) = ?";
		$query = $this->db->query($sql,array($city_code));

		return $query->row_array();
	}

	public function get_city()
	{
		$sql = "select * from mfi_province_city order by city_abbr,city_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function edit_kecamatan($data, $param)
	{
		$this->db->update('mfi_city_kecamatan', $data, $param);
	}

	public function delete_kecamatan($param)
	{
		$this->db->delete('mfi_city_kecamatan', $param);
	}

	public function search_city_code($keyword)
	{
		$sql = "select city_code,city from mfi_province_city where UPPER(city) like ? or city_code like ?";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));

		return $query->result_array();
	}

	//desa

	public function add_desa($data)
	{
		$this->db->insert('mfi_kecamatan_desa', $data);
	}

	public function get_desa_by_id($kecamatan_desa_id)
	{
		$sql = "SELECT
				mfi_kecamatan_desa.desa,
				mfi_kecamatan_desa.kecamatan_code,
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.kecamatan_desa_id,
				mfi_city_kecamatan.kecamatan
				FROM
				mfi_kecamatan_desa
				INNER JOIN mfi_city_kecamatan ON mfi_city_kecamatan.kecamatan_code = mfi_kecamatan_desa.kecamatan_code
				WHERE kecamatan_desa_id = ? ";
		$query = $this->db->query($sql, array($kecamatan_desa_id));

		return $query->row_array(); 
	}

	public function get_kecamatan()
	{
		$sql = "SELECT
					 mfi_city_kecamatan.city_kecamatan_id,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.city_code,
					 mfi_city_kecamatan.kecamatan,
					 mfi_province_city.city_code,
					 mfi_province_city.city_abbr,
					 mfi_province_city.city
				FROM
					 mfi_city_kecamatan
				INNER JOIN  mfi_province_city ON  mfi_city_kecamatan.city_code =  mfi_province_city.city_code
				ORDER BY 
					 mfi_city_kecamatan.kecamatan asc
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function edit_desa($data, $param)
	{
		$this->db->update('mfi_kecamatan_desa', $data, $param);
	}

	public function delete_desa($param)
	{
		$this->db->delete('mfi_kecamatan_desa', $param);
	}

	public function search_kecamatan_code($keyword,$city)
	{
		$sql = "select kecamatan_code,kecamatan from mfi_city_kecamatan where (upper(kecamatan) like ? or kecamatan_code like ?)";
		if($city!=""){
			$sql .= ' and city_code = ?';
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%',$city));
		}else{

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_ajax_kecamatan_code($kecamatan_code)
	{
		$sql = "select max(substr(desa_code,7)) AS jumlah from mfi_kecamatan_desa where kecamatan_code = ?";
		$query = $this->db->query($sql,array($kecamatan_code));

		return $query->row_array();
	}


	// [BEGIN] KABUPATEN

	public function datatable_kabupaten($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = "SELECT * FROM mfi_province_city";

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/********************************************************************************************/

	// [BEGIN] KECAMATAN

	public function datatable_kecamatan($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = 'SELECT
					 mfi_city_kecamatan.city_kecamatan_id,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.city_code,
					 mfi_city_kecamatan.kecamatan,
					 mfi_province_city.city_code,
					 mfi_province_city.city_abbr,
					 mfi_province_city.city
				FROM
					 mfi_city_kecamatan
				INNER JOIN  mfi_province_city ON  mfi_city_kecamatan.city_code =  mfi_province_city.city_code
					';

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/********************************************************************************************/

	// [BEGIN] DESA

	public function datatable_desa($sWhere='', $sOrder='', $sLimit='')
	{
		$sql = 'SELECT
					 mfi_kecamatan_desa.kecamatan_desa_id,
					 mfi_kecamatan_desa.desa_code,
					 mfi_kecamatan_desa.kecamatan_code,
					 mfi_kecamatan_desa.desa,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.kecamatan
				FROM
					 mfi_kecamatan_desa
				INNER JOIN  mfi_city_kecamatan ON  mfi_kecamatan_desa.kecamatan_code =  mfi_city_kecamatan.kecamatan_code
					';

		if($sWhere !="")
			$sql .= "$sWhere";

		if($sOrder !="")
			$sql .= "$sOrder";

		if ($sLimit !="")
			$sql .= "$sLimit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/*************************************************************************************************/
	// CIF INDIVIDU
	/*************************************************************************************************/

	public function add_cif_individu($data)
	{
		$this->db->insert('mfi_cif',$data);
	}

	public function datatable_cif_individu($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT * from mfi_cif ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere and cif_type = 1 ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			$sql .= "WHERE cif_type = 1 ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_cif_individu($cif_id)
	{
		$sql = "select * from mfi_cif where cif_id = ?";
		$query = $this->db->query($sql,array($cif_id));

		return $query->row_array();
	}

	public function update_cif_individu($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}


	/********************************************************************************************/
	// [BEGIN] PROGRAM
	/********************************************************************************************/

	public function datatable_program_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_financing_program";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_program()
    {
        $sql = "SELECT * FROM mfi_financing_program";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function add_program($data)
	{
		$this->db->insert('mfi_financing_program',$data);
	}

	public function delete_program($param)
	{
		$this->db->delete('mfi_financing_program',$param);
	}

	public function edit_program($data,$param)
	{
		$this->db->update('mfi_financing_program',$data,$param);
	}

	public function get_program_by_financing_program_id($financing_program_id)
	{
		$sql = "select * from mfi_financing_program where financing_program_id = ?";
		$query = $this->db->query($sql,array($financing_program_id));

		return $query->row_array();
	}


	/********************************************************************************************/
	// [END] PROGRAM
	/********************************************************************************************/

	/********************************************************************************************/
	// [BEGIN] SMK
	/********************************************************************************************/

	public function datatable_registrasi_smk_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_trx_smk.trx_smk_id,
				mfi_trx_smk.trx_smk_code,
				mfi_trx_smk.cif_no,
				mfi_trx_smk.trx_type,
				mfi_trx_smk.trx_date,
				mfi_smk.nominal,
				mfi_smk.nama,
				COUNT(mfi_smk.sertifikat_no) AS jml_sertifikat
				FROM
				mfi_trx_smk
				INNER JOIN mfi_smk ON mfi_smk.cif_no = mfi_trx_smk.cif_no
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			$sql .= " GROUP BY 1,2,3,4,5,6,7 ";
		}else{
			$sql .= " GROUP BY 1,2,3,4,5,6,7 ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";


		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_registrasi_smk()
    {
        $sql = "SELECT * FROM mfi_smk ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

    
   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='0' ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }

	public function add_trx_smk($data1)
	{
		$this->db->insert('mfi_trx_smk',$data1);
	}

	public function add_registrasi_smk($data2)
	{
		$this->db->insert_batch('mfi_smk',$data2);
	}

	public function edit_trx_smk($data1,$param1)
	{
		$this->db->update('mfi_trx_smk',$data1,$param1);
	}

	public function edit_registrasi_smk($data2,$param2)
	{
		$this->db->update('mfi_smk',$data2,$param2);
	}

	public function delete_registrasi_smk($param)
	{
		$this->db->delete('mfi_smk',$param);
	}

	public function delete_registrasi_trx_smk($param)
	{
		$this->db->delete('mfi_trx_smk',$param);
	}

	public function get_smk_by_smk_id($trx_smk_id)
	{
		$sql = "SELECT 
				mfi_smk.*,
				mfi_trx_smk.*
				FROM
				mfi_smk
				INNER JOIN mfi_trx_smk ON mfi_trx_smk.trx_smk_code = mfi_smk.trx_smk_code
				WHERE mfi_trx_smk.trx_smk_id = ?";

		$query = $this->db->query($sql,array($trx_smk_id));

		return $query->row_array();
	}

	public function detail_registrasi_smk($trx_smk_id)
	{
		$sql = "SELECT 
				mfi_smk.nama,
				mfi_smk.sertifikat_no,
				mfi_smk.smk_id,
				mfi_smk.status AS stat,
				mfi_trx_smk.cif_no
				FROM 
				mfi_smk
				INNER JOIN mfi_trx_smk ON mfi_trx_smk.cif_no = mfi_smk.cif_no 
				WHERE mfi_trx_smk.trx_smk_id = ?
				";
		$query = $this->db->query($sql,array($trx_smk_id));

		return $query->result_array();
	}

	public function count_no_sertifikat_by_branch_code($branch_code)
	{
		$sql = "select max(substr(sertifikat_no,5)) AS jumlah from mfi_smk where left(sertifikat_no,4) =  ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->row_array();
	}

	public function count_code_trx_smk()
	{
		$sql = "select max(substr(trx_smk_code,5)) AS jumlah from mfi_trx_smk";
		$query = $this->db->query($sql);

		return $query->row_array();
	}


	/********************************************************************************************/
	// [END] SMK
	/********************************************************************************************/


	/********************************************************************************************/
	// [BEGIN] PELEPASAN SMK
	/********************************************************************************************/

	public function datatable_pelepasan_smk_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_smk WHERE status=2 ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_all_pelepasan_smk()
    {
        $sql = "SELECT * FROM mfi_smk ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function add_pelepasan_smk($data,$param)
	{
		$this->db->update('mfi_smk',$data,$param);
	}

	public function delete_pelepasan_smk($param)
	{
		$this->db->delete('mfi_smk',$param);
	}

	public function edit_pelepasan_smk($data,$param)
	{
		$this->db->update('mfi_smk',$data,$param);
	}

	public function get_pelepasan_smk_by_smk_id($smk_id)
	{
		$sql = "select * from mfi_smk where smk_id = ?";
		$query = $this->db->query($sql,array($smk_id));

		return $query->row_array();
	}

	public function count_no_pelepasan_by_branch_code($branch_code)
	{
		$sql = "select max(substr(sertifikat_no,5)) AS jumlah from mfi_smk where left(sertifikat_no,4) =  ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->row_array();
	}

	public function ajax_get_value_from_sertifikat_no($sertifikat_no)
	{
		$sql = "select * from mfi_smk where sertifikat_no = ?";
		$query = $this->db->query($sql,array($sertifikat_no));

		return $query->row_array();
	}

	// search sertifikat number
	public function search_sertifikat_no($keyword)
	{
		$sql = "SELECT * FROM mfi_smk where status=1 AND (upper(nama) like ? or sertifikat_no like ?)";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));

		return $query->result_array();
	}

	public function get_data_from_sertifikat($smk_id,$status)
	{
		$sql = "select nama, cif_no, sertifikat_no, nominal, smk_id from mfi_smk where smk_id= ? AND status = ?";
		$query = $this->db->query($sql,array($smk_id,$status));

		return $query->result_array();
	}


	/********************************************************************************************/
	// [END] PELEPASAN SMK
	/********************************************************************************************/

	public function get_branch_by_keyword($keyword)
	{
		$param = array();
		$branch_induk = $this->session->userdata('branch_induk');
		$sql = "select b.branch_id,a.branch_code,b.branch_name,b.branch_class from mfi_branch_member a, mfi_branch b where a.branch_code=b.branch_code";

		if($keyword!=""){
			$sql .=" and UPPER(b.branch_name) like ? or UPPER(b.branch_code) like ?";
			$param[] = '%'.strtoupper(strtolower($keyword)).'%';
			$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		}
		if($branch_induk!="00000"){
			$sql .=" and a.branch_induk = ?";
			$param[] = $branch_induk;
		}
		$sql .=" group by 1,2,3 order by a.branch_code asc";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_branch_id_by_branch_code($branch_code){
		$sql = "select branch_id from mfi_branch where branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));
		
		$row = $query->row_array();
		return $row['branch_id'];
	}

	public function get_desa_by_keyword($keyword,$kecamatan)
	{
		$sql = "select
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.desa 
				from mfi_kecamatan_desa
		
				";
		if($kecamatan!=""){
			$sql .= "where kecamatan_code = ?";
		}

		$query = $this->db->query($sql,array($kecamatan));

		return $query->result_array();
	}

	public function get_fa_by_keyword($keyword,$branch_code)
	{
		$sql = "select fa_code,fa_name from mfi_fa where branch_code = ? and ( fa_code like ? or upper(fa_name) like ? )";
		$query = $this->db->query($sql,array($branch_code,'%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_pelunasan_pembiayaan($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_akad,
				(mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin) as besar_angsuran,
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_cm.cm_name,
				mfi_product_financing.product_name
				FROM
				mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				where (upper(mfi_cif.nama) like ? or upper(mfi_account_financing.account_financing_no) like ?) 
				and (mfi_account_financing.status_rekening = '1' OR mfi_account_financing.status_rekening = '0')
				and account_financing_no not in (select account_financing_no from mfi_account_financing_lunas)
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}
	// search cif number
	public function search_cif_for_pelunasan_pembiayaan_v2($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_akad,
				(mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin) as besar_angsuran,
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_cm.cm_name,
				mfi_product_financing.product_name
				FROM
				mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				where (upper(mfi_cif.nama) like ? or upper(mfi_account_financing.account_financing_no) like ?) 
				and (mfi_account_financing.status_rekening = '1')
				and account_financing_no not in (select account_financing_no from mfi_account_financing_lunas)
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_blokir_tabungan($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving.status_rekening=1";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';

		$param[] = '%'.$keyword.'%';
		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_buka_tabungan($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_account_saving_blokir.tipe_mutasi
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_saving_blokir ON mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) AND mfi_account_saving_blokir.tipe_mutasi=2";
		
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	// search cif number
	public function search_cif_for_tutup_tabungan($keyword,$type,$cm_code)
	{

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_account_saving_blokir.tipe_mutasi
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_account_saving_blokir ON mfi_account_saving_blokir.account_saving_no = mfi_account_saving.account_saving_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) AND mfi_account_saving_blokir.tipe_mutasi!=1";
		
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	// search cif number
	public function search_account_insurance_no($keyword,$type,$cm_code)
	{
		$sql = "select 
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama, 
				mfi_cm.cm_name 
				from mfi_cif 
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_insurance.account_insurance_no like ?)";
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		// print_r($this->db);

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	/** GET REMBUG DATA OPTION (CM) **************************************************/

	public function get_cm_data()
	{
		$sql = "select cm_code,cm_name from mfi_cm";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	// institution

	public function get_institution()
	{
		$query = $this->db->get('mfi_institution');
		return $query->row_array();
	}


	public function search_cif($keyword)
	{
		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.nama
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				where (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)";

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_nominal_awal()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='SMK' ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		$nominal = $row['code_value'];
		return $nominal;
	}

	public function search_no_pembiayaan($keyword,$type,$cm_code)
	{
		$sql = "SELECT 
				mfi_account_financing.account_financing_no,
				mfi_cif.nama,
				mfi_account_financing.status_rekening
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				WHERE (upper(mfi_cif.nama) like ? or mfi_account_financing.account_financing_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($type!="") {

			$sql 	.= ' AND mfi_cif.cif_type = ?';
			$param[] = $type;

		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' AND mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}

		// print_r($this->db);
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	/* GET CM */
	public function get_cm_by_cm_code($cm_code)
	{
		$sql = "select cm_code,cm_name from mfi_cm where cm_code = ?";
		$query = $this->db->query($sql,array($cm_code));

		return $query->row_array();
	}

	/* GET CIF BY CIF NO */
	public function get_cif_by_cif_no($cif_no)
	{
		$sql = "select
		
				  cif_id
				  ,cm_code
				  ,nama
				  ,kelompok
				  ,jenis_kelamin
				  ,tgl_lahir
				  ,usia
				  ,tgl_gabung
				  ,branch_code
				  ,cif_type
				  ,status
				  ,tanggal_keluar 
				
				from mfi_cif 
				
				where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}

	public function get_list_code($code_group)
	{
		$sql = "select * from mfi_list_code_detail where code_group = ? order by display_sort asc";
		$query = $this->db->query($sql,array($code_group));

		return $query->result_array();
	}

	public function get_list_code_text($code_group,$code_value)
	{
		$sql = "select * from mfi_list_code_detail where code_group = ? and code_value = ? order by display_sort asc";
		$query = $this->db->query($sql,array($code_group,$code_value));

		return $query->row_array();
	}

	//TAMBAHAN ADE, BRANCH 5 DIGIT
	function get_all_branch_wilayah()
    {
    	$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        		FROM 
        				 mfi_branch
				WHERE 
						branch_class=1
				";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= " ORDER BY 2 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
    }

	function get_all_branch_cabang()
    {
    	$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        				,wilayah
        		FROM 
        				 mfi_branch
				WHERE 
						branch_class=2
				";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= " ORDER BY 2 ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
    }
	//END TAMBAHAN ADE, BRANCH 5 DIGIT

    /**
    * get wilayah code by branch induk
    * @param branch_induk
    */
    function get_wilayah_code_by_branch_induk($branch_induk)
    {
    	$sql = "select wilayah from mfi_branch where branch_code = ?";
    	$query = $this->db->query($sql,array($branch_induk));
    	$row = $query->row_array();
    	return (isset($row['wilayah'])==true)?$row['wilayah']:'00000';
    }

    /**
    * insert batch to mfi_branch_member
    * @param branch_member
    */
    function add_branch_member($branch_member)
    {
    	$this->db->insert_batch('mfi_branch_member',$branch_member);
    }

    function get_branch_code_by_branch_id($branch_id)
    {
    	$sql = "select branch_code from mfi_branch where branch_id=?";
    	$query=$this->db->query($sql,array($branch_id));
    	$row=$query->row_array();
    	if(isset($row['branch_code'])==true){
    		return $row['branch_code'];
    	}else{
    		return '0';
    	}
    }

    function delete_kantor_cabang_member($param)
    {
    	$this->db->delete('mfi_branch_member',$param);
    }    

	public function get_all_pekerjaan()
	{
		$sql = "SELECT * from mfi_list_code_detail WHERE code_group='pekerjaan' ORDER BY code_value";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	public function search_cif_for_cetak_persetujuan_pembiayaan($keyword,$type,$cm_code)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_financing.account_financing_no,
				mfi_cif.nama,
				mfi_cm.cm_name
				FROM
				mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where mfi_account_financing.status_rekening in(0,1) AND (upper(mfi_cif.nama) like ? or mfi_account_financing.account_financing_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and mfi_cif.cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and mfi_cif.cm_code = ?';
			$param[] = $cm_code;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}
    
	public function check_exist($table,$param,$field)
	{
		$sql = "SELECT count($field) AS total FRO $table WHERE $param";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function check_exist_tabungan($cif_no)
	{
		$sql = "select coalesce(count(*),0) as jml from mfi_account_saving where cif_no=?";
		$query = $this->db->query($sql,array($cif_no));
		$row=$query->row_array();
		if($row['jml']>0){
			return true;
		}else{
			return false;
		}
	}

	public function check_exist_pembiayaan($cif_no)
	{
		$sql = "select coalesce(count(*),0) as jml from mfi_account_financing where cif_no=?";
		$query = $this->db->query($sql,array($cif_no));
		$row=$query->row_array();
		if($row['jml']>0){
			return true;
		}else{
			return false;
		}
	}

	/*
	| RESORTS
	*/
	public function get_resorts()
	{
		$branch_code=$this->session->userdata('branch_code');
		$flag_all_branch=$this->session->userdata('flag_all_branch');
		$param=array();
		$sql="select * from mfi_resort";
		if($branch_code!="00000"){
			$sql.=" where branch_code in (select branch_code from mfi_branch_member where branch_induk=?)";
			$param[]=$branch_code;
		}
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

	function no_identitas_same_is_exists($id_jenis,$no_ktp)
	{
		$sql = "select count(*) num from mfi_cif where jenis_id = ? and no_ktp = ?";
		$query = $this->db->query($sql,array($id_jenis,$no_ktp));
		$row = $query->row_array();

		if($row['num']>0){
			return 1;
		}else{
			return 0;
		}
	}

	function no_identitas_pasangan_same_is_exists($id_jenis,$no_ktp)
	{
		$sql = "select count(*) num from mfi_cif where jenis_id_pasangan = ? and identitas_pasangan = ?";
		$query = $this->db->query($sql,array($id_jenis,$no_ktp));
		$row = $query->row_array();

		if($row['num']>0){
			return 1;
		}else{
			return 0;
		}
	}

	/*********************************************************************************************/
	//END KOPTEL
	/*********************************************************************************************/
	public function search_cif_no_koptel($keyword)
	{

		$sql = "SELECT 
		nik,
		nama_pegawai 
		FROM mfi_pegawai 
		WHERE (UPPER(nama_pegawai) LIKE ? OR nik LIKE ?)";
		// AND status = '1'";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		$query = $this->db->query($sql,$param);
		// print_r($this->db);

		return $query->result_array();
	}

	/**
	*Begin Daftar pegawai & special rate, Ade Sagita 28-03-2015 20:30
	*/
	public function datatable_pegawai_koptel($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT 
						 mfi_pegawai.nik
						,nama_pegawai
						,code_divisi
						,kode_posisi 
						,posisi
						,thp
						,b.status status_rate
				FROM mfi_pegawai left join mfi_spesial_rate b on b.nik=mfi_pegawai.nik  ";

		if ( $sWhere != "" )
			$sql .= " $sWhere ";

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}
		$sql .= "  GROUP BY 1,2,3,4,5,6,7 ";
		if ( $sLimit != "" )
			$sql .= "$sLimit ";


		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function delete_spesial_rate($param)
	{
		$this->db->delete('mfi_spesial_rate',$param);
	}

	public function save_spesial_rate($data){
		$this->db->insert('mfi_spesial_rate',$data);
	}
	/**
	*End pegawai & special rate
	*/

	public function datatable_cif($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT a.*
					FROM mfi_pegawai a
					INNER JOIN mfi_cif b on b.cif_no=a.nik
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere  ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function delete_pegawai($param)
	{
		$this->db->delete('mfi_pegawai',$param);
	}

	public function save_pegawai($data){
		$this->db->insert('mfi_pegawai',$data);
	}

	public function get_pegawai_by_pegawai_id($pegawai_id)
	{
		$sql = "
			SELECT
				a.*,
				upper(b.kopegtel_code) kopegtel_code
			FROM mfi_pegawai a
			LEFT JOIN mfi_pegawai_kopegtel b ON a.nik=b.nik
			WHERE a.pegawai_id=?
		";
		$query = $this->db->query($sql,array($pegawai_id));
		return $query->row_array();
	}

	public function update_pegawai($data,$param)
	{
		$this->db->update('mfi_pegawai',$data,$param);		
	}

	/*********************************************************************************************/
	//END KOPTEL
	/*********************************************************************************************/

	function get_kopegtel()
	{
		$sql = " SELECT kopegtel_code,nama_kopegtel FROM mfi_kopegtel ORDER BY 2 ASC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}