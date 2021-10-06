<?php

class Model_webservice extends CI_Model {

	public function cek_user_online($user_id,$ip,$browser)
	{
		$sql1 = "select coalesce(count(*),0) as exist from user_online where user_id=?";
		$query1 = $this->db->query($sql1,array($user_id));
		$row1 = $query1->row_array();
		$sql2 = "select coalesce(count(*),0) as exist from user_online where user_id=? and ip=?";
		$query2 = $this->db->query($sql2,array($user_id,$ip));
		$row2 = $query2->row_array();
		$sql3 = "select coalesce(count(*),0) as exist from user_online where user_id=? and ip=? and browser=?";
		$query3 = $this->db->query($sql3,array($user_id,$ip,$browser));
		$row3 = $query3->row_array();
		
		if($row1['exist']>0){
			if($row3['exist']>0){
				return true;
			}else{
				return false;
			}
		}else{
			$data=array('user_id'=>$user_id,'ip'=>$ip,'browser'=>$browser,'date'=>date('Y-m-d H:i:s'));
			$this->db->trans_begin();
			$this->db->insert('user_online',$data);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				return true;
			}else{
				$this->db->trans_rollback();
				return false;
			}
		}
	}

	function old_password_check($username,$password)
	{
		$sql = "select count(*)  as num from mfi_user where username = ? and repassword = ? and status = '1' and role_id = '42'";
		$query = $this->db->query($sql,array($username,$password));
		$row = $query->row_array();
		if ($row['num']==0){
			return false;
		} else {
			return true;
		}
	}

	public function authentication($username,$password)
	{
		$sql = "select user_id,role_id from mfi_user where username = ? and password = ? and status = '1' and role_id in('42','43')";
		$query = $this->db->query($sql,array($username,$password));
		$row = $query->row_array();
		return $row;
	}

	// public function userdata_nasabah($user_id)
	// {
	// 	$sql = "select 
	// 			a.user_id,
	// 			a.username,
	// 			a.repassword,
	// 			a.fullname,
	// 			a.role_id,
	// 			a.usia_password,
	// 			a.last_update_password,
	// 			a.expired_password,
	// 			b.nik,
	// 			b.nama_pegawai,
	// 			b.band,
	// 			b.posisi,
	// 			b.loker,
	// 			b.alamat,
	// 			b.tempat_lahir,
	// 			b.tgl_lahir,
	// 			b.thp,
	// 			(b.thp*40/100) as thp_40,
	// 			b.koptel as jumlah_kewajiban,
	// 			b.tgl_pensiun_normal,
	// 			(select count(*) from mfi_account_financing_reg where cif_no = b.nik and status = 0) as status_financing_reg,
	// 			(case when (select count(*) from mfi_spesial_rate where nik = b.nik and status = 1) = 1 then 
	// 				1
	// 			else
	// 				0 
	// 			end) as flag_thp100,
	// 			c.cif_id,
	// 			c.jenis_kelamin as gender,
	// 			(case when (select count(*) from mfi_pegawai_kopegtel where nik = b.nik) > 0 then 
	// 				1
	// 			else
	// 				0
	// 			end) as jml_pegawai_kopeg
	// 			from mfi_user a, mfi_pegawai b, mfi_cif c
	// 			where a.user_id = ? and b.nik = a.username and c.cif_no = b.nik
	//      	   ";
	// 	$query = $this->db->query($sql,array($user_id));
	// 	return $query->row_array();
	// }

	public function userdata_nasabah($user_id)
	{
		$sql = "SELECT 
				mfi_user.user_id,
				mfi_user.username,
				mfi_user.repassword,
				mfi_user.fullname,
				mfi_user.role_id,
				mfi_user.usia_password,
				mfi_user.last_update_password,
				mfi_user.expired_password,
				mfi_pegawai.nik,
				mfi_pegawai.nama_pegawai,
				mfi_pegawai.band,
				mfi_pegawai.posisi,
				mfi_pegawai.loker,
				mfi_pegawai.alamat,
				mfi_pegawai.tempat_lahir,
				mfi_pegawai.tgl_lahir,
				mfi_pegawai.thp,
				(mfi_pegawai.thp*40/100) as thp_40,
				((mfi_pegawai.thp*40/100)+100000) as thp_40_plus,
				(SELECT SUM(x.saldo_pokok) FROM mfi_account_financing x WHERE x.status_rekening=1 and x.cif_no=mfi_pegawai.nik) as jumlah_kewajiban,
				mfi_pegawai.tgl_pensiun_normal,
				(select count(*) from mfi_account_financing_reg where cif_no = mfi_pegawai.nik and status = 0) as status_financing_reg,
				(case when (select count(*) from mfi_spesial_rate where nik = mfi_pegawai.nik and status = 1) = 1 then 
					1
				else
					0 
				end) as flag_thp100,
				mfi_cif.cif_id,
				mfi_cif.jenis_kelamin as gender,
				(case when (select count(*) from mfi_pegawai_kopegtel where nik = mfi_pegawai.nik) > 0 then 
					1
				else
					0
				end) as jml_pegawai_kopeg
				from mfi_user
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_user.username
				left join mfi_cif on mfi_cif.cif_no = mfi_pegawai.nik
				where mfi_user.user_id = ?
	     	   ";
		$query = $this->db->query($sql,array($user_id));
		return $query->row_array();
	}

	public function userdata_kopegtel($user_id)
	{
		$sql = "select 
				a.username,
				a.fullname,
				a.role_id,
				a.usia_password,
				a.last_update_password,
				a.expired_password,
				b.nama_kopegtel,
				b.ketua_pengurus,
				b.kopegtel_code
				from mfi_user a, mfi_kopegtel b
				where a.user_id = ? and b.kopegtel_code = a.username
	     	   ";
		$query = $this->db->query($sql,array($user_id));
		return $query->row_array();
	}

	public function save_pengajuan($data)
	{
		$this->db->insert('mfi_account_financing_reg',$data);
	}
	
	public function get_kopegtel($nik)
	{
		$sql = "select 
				mfi_pegawai_kopegtel.kopegtel_code,
				mfi_kopegtel.nama_kopegtel
				from mfi_pegawai_kopegtel
				inner join mfi_kopegtel on mfi_kopegtel.kopegtel_code = mfi_pegawai_kopegtel.kopegtel_code
				where mfi_pegawai_kopegtel.nik = ?
			   ";
		$query = $this->db->query($sql,array($nik));
		return $query->result_array();
	}
	
public function get_nama_tgllhr($nik)
	{
		$sql = "select nama_pegawai, tempat_lahir from mfi_pegawai where nik=?";
		$query = $this->db->query($sql,array($nik));
		return $query->result_array();
	}
	public function get_statement_tabungan($nik)
	{
		$sql = "select 
				mfi_account_saving.account_saving_no,
				mfi_account_saving.saldo_memo,
				mfi_pegawai.nama_pegawai 
				from mfi_account_saving 
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_saving.cif_no
				where mfi_account_saving.cif_no = ?
			   ";
		$query = $this->db->query($sql,array($nik));
		return $query->result_array();
	}

	public function jqgrid_verifikasi_pengajuan($sidx='',$sord='',$limit_rows='',$start='',$kopegtel_code,$tipe_keyword='',$keyword='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				b.nama_pegawai,
				b.nik,
				a.registration_no,
				a.account_financing_reg_id,
				a.amount,
				a.status,
				a.tanggal_pengajuan,
				a.status_asuransi,
				c.display_text as peruntukan,
				d.product_name
				FROM
				mfi_account_financing_reg a
				INNER JOIN mfi_pegawai b ON a.cif_no = b.nik
				INNER JOIN mfi_list_code_detail c ON c.code_group='peruntukan' and c.display_sort=a.peruntukan
				INNER JOIN mfi_product_financing d ON a.product_code = d.product_code
				WHERE a.status = '0' and a.kopegtel_code=?
			   ";

		$param[] 	= $kopegtel_code;

		if ($keyword!="") {
			$sql .= " and upper(b.".$tipe_keyword.") like ? ";
			$keyword 	= strtolower($keyword);
			$keyword 	= strtoupper($keyword);
			$param[] 	= '%'.$keyword.'%';
		}

		$sql .= " $order $limit ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function do_update_pengajuan($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}
	
	public function do_view_pengajuan($account_financing_reg_id)
	{
		$sql = "SELECT
				mfi_pegawai.nama_pegawai,
				mfi_pegawai.nik,
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				(select display_text from mfi_list_code_detail where code_group = 'peruntukan' and CAST(mfi_list_code_detail.code_value as integer) = mfi_account_financing_reg.peruntukan) as peruntukan,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_pegawai ON mfi_account_financing_reg.cif_no = mfi_pegawai.nik
				WHERE mfi_account_financing_reg.account_financing_reg_id = ?
			   ";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}
	
	public function check_valid_data_on_pegawai($nik,$tanggal_lahir)
	{
		$sql = "select count(*) as total from mfi_pegawai where nik = ? and tgl_lahir = ?";
		$query = $this->db->query($sql,array($nik,$tanggal_lahir));
		return $query->row_array();
	}

	public function check_valid_data_on_user($nik)
	{
		$sql = "select count(*) as total from mfi_user where username = ?";
		$query = $this->db->query($sql,array($nik));
		return $query->row_array();
	}


	public function insert_mfi_user($data_user)
	{
		$this->db->insert('mfi_user',$data_user);
	}

	public function update_mfi_user($data_user,$param)
	{
		$this->db->update('mfi_user',$data_user,$param);
	}

	function detail_statement_tab($account_saving_no,$tanggal_dari,$tanggal_sampai)
	{
		$sql = "select * from mfi_trx_account_saving where account_saving_no = ? and trx_date between ? and ? order by trx_date asc";
		$query=$this->db->query($sql,array($account_saving_no,$tanggal_dari,$tanggal_sampai));
		return $query->result_array();
	}

	public function get_statement_pembiayaan($nik)
	{
		$sql = "select * from mfi_account_financing where cif_no = ?";
		$query = $this->db->query($sql,array($nik));
		return $query->result_array();
	}

	public function get_kartu_pengawasan_angsuran_by_account_no($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.cif_type,
				mfi_cm.cm_name,
				mfi_kecamatan_desa.desa,
				mfi_account_financing.registration_no,
				mfi_account_financing.pokok,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.margin,
				mfi_account_financing_droping.droping_date,
				mfi_account_financing.tanggal_jtempo,
				mfi_product_financing.product_name,
				mfi_list_code_detail.display_text AS untuk,
				mfi_account_financing_reg.pembiayaan_ke as pydke,
				mfi_account_financing.flag_jadwal_angsuran
				FROM
				mfi_account_financing
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				LEFT JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				LEFT JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value=mfi_account_financing.peruntukan::varchar AND mfi_list_code_detail.code_group='peruntukan'
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				WHERE 
				mfi_account_financing.account_financing_no = ?
			   ";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_row_pembiayaan_by_account_no($account_financing_no)
	{
		$sql = "SELECT
						cif_no,
						jangka_waktu,
						tanggal_mulai_angsur,
						tanggal_jtempo,
						periode_jangka_waktu,
						(angsuran_pokok+angsuran_margin+angsuran_catab+angsuran_tab_wajib+angsuran_tab_kelompok) as jumlah_angsuran,
						saldo_pokok,
						saldo_margin,
						pokok,
						margin,
						angsuran_pokok,
						angsuran_margin,
						angsuran_catab,
						counter_angsuran,
						flag_jadwal_angsuran
				FROM
						mfi_account_financing

				WHERE mfi_account_financing.account_financing_no = ?
				--AND mfi_account_financing.status_rekening='1'
			  ";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,$cif_type,$jtempo='')
	{
		$param=array();
		if($cif_type==0){ // kelompok
			$sql = "select
					b.trx_date,
					(select fullname from mfi_user where user_id=b.created_by::integer) as created_by
					from mfi_trx_cm_detail a, mfi_trx_cm b
					where a.trx_cm_id = b.trx_cm_id
					and a.cif_no = ?
				  ";
			$param[]=$cif_no;
		}
		if($cif_type==1){ //individu
			$sql = "select 
					a.trx_date,
					(select fullname from mfi_user where user_id=a.created_by::integer) as created_by
					from mfi_trx_account_financing a
					where a.account_financing_no=? and a.jto_date=? and a.trx_financing_type='1'
				  ";
			$param[]=$account_financing_no;
			$param[]=$jtempo;
		}


		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	//GET JADWAL ANGSURAN NON REGULER -- Ade Sagita 17-11-2014
	public function get_jadwal_angsuran($account_no_financing='')
	{
		$sql = "SELECT 
						 tangga_jtempo
						,angsuran_pokok
						,angsuran_margin
						,angsuran_tabungan
						,status_angsuran
						,tanggal_bayar
						,bayar_pokok
						,bayar_margin
						,bayar_tabungan
				FROM mfi_account_financing_schedulle 
				WHERE account_no_financing=? ORDER BY 1 ";
		$param[]=$account_no_financing;
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_product_financing()
	{
		$sql = "select
				product_code,
				product_name,
				jenis_pembiayaan,
				insurance_product_code,
				rate_margin1,
				rate_margin2,
				flag_manfaat_asuransi,
				max_jangka_waktu,
				jenis_margin
				from
				mfi_product_financing
			   ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_product_financing_by_band($band='',$banmod=true){
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.nick_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				fn_get_rate_margin(mfi_product_financing.product_code,?,'min') rate_margin1,
				fn_get_rate_margin(mfi_product_financing.product_code,?,'max') rate_margin2,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.max_jangka_waktu,
				mfi_product_financing.jenis_margin
				FROM mfi_product_financing
				";
		if ($banmod==false) {
		$sql .= "LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='produkbanmod'
				WHERE mfi_product_financing.product_code<>mfi_list_code_detail.code_value";
		}
		$query = $this->db->query($sql,array($band,$band));

		return $query->result_array();
	}

	function get_kewajiban_koptel($nik){
		$sql = "SELECT
		mpf.product_name,
		SUM(maf.saldo_pokok) AS total_pokok,
		SUM(maf.saldo_margin) AS total_margin
		FROM mfi_account_financing AS maf
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code

		WHERE maf.status_rekening = '1' AND maf.cif_no = ?
		GROUP BY 1";

		$param = array($nik);

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function get_angsuran_koptel($nik){
		$sql = "SELECT
		SUM(angsuran_pokok) AS angsuran_pokok,
		SUM(angsuran_margin) AS angsuran_margin
		FROM mfi_account_financing

		WHERE status_rekening = '1' AND cif_no = ?";

		$param = array($nik);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function get_peruntukan_pembiayaan()
	{
		$sql = "select
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text,
				mfi_list_code_detail.display_sort
				from
				mfi_list_code
				inner join mfi_list_code_detail on mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='peruntukan' order by display_sort asc
			   ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_cif($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}

	public function insert_cif($data)
	{
		$this->db->insert('mfi_cif',$data);
	}

	public function get_data_pengajuan_by_id($account_financing_reg_id)
	{
		$sql = "select
				mfi_pegawai.nik,
				mfi_pegawai.nama_pegawai,
				mfi_pegawai.band,
				mfi_pegawai.loker,
				mfi_pegawai.posisi,
				mfi_pegawai.tempat_lahir,
				mfi_pegawai.tgl_lahir,
				mfi_pegawai.tgl_pensiun_normal,
				mfi_cif.alamat,
				mfi_cif.nama_pasangan,
				mfi_cif.pekerjaan_pasangan,
				mfi_cif.jumlah_tanggungan,
				mfi_pegawai.thp,
				(mfi_pegawai.thp*40/100) as thp_40,
				mfi_account_financing_reg.jumlah_kewajiban,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cif.no_ktp,
				mfi_cif.status_rumah,
				mfi_cif.nama_bank,
				mfi_cif.bank_cabang,
				mfi_cif.no_rekening,
				mfi_cif.atasnama_rekening,
				mfi_cif.usia,
				(select distinct rate_margin2 from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as rate_margin2,
				(select distinct rate_margin1 from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as rate_margin1,
				(select distinct product_name from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as produk,
				(select distinct jenis_margin from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as jenis_margin,
				(select distinct display_text from mfi_list_code_detail where code_group='peruntukan' and display_sort = mfi_account_financing_reg.peruntukan) as peruntukan,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.jangka_waktu,
				mfi_account_financing_reg.pengajuan_melalui,
				(select distinct nama_kopegtel from mfi_kopegtel where kopegtel_code = mfi_account_financing_reg.kopegtel_code) as kopegtel_code,
				(select distinct nama_kopegtel from mfi_kopegtel where kopegtel_code = mfi_account_financing_reg.pelunasan_ke_kopeg_mana) as pelunasan_ke_kopeg_mana,
				mfi_account_financing_reg.jangka_waktu,
				mfi_account_financing_reg.jumlah_angsuran,
				mfi_account_financing_reg.product_code,
				mfi_account_financing_reg.angsuran_pokok,
				mfi_account_financing_reg.angsuran_margin,
				mfi_account_financing_reg.lunasi_ke_koptel,
				mfi_account_financing_reg.lunasi_ke_kopegtel,
				mfi_account_financing_reg.saldo_kewajiban_ke_koptel,
				mfi_account_financing_reg.saldo_kewajiban,
				(mfi_account_financing_reg.premi_asuransi+mfi_account_financing_reg.premi_asuransi_tambahan) as premi_asuransi
				from mfi_account_financing_reg
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				inner join mfi_cif on mfi_cif.cif_no = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.account_financing_reg_id = ? and mfi_account_financing_reg.status_dokumen_lengkap = '1'
			   ";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}

	public function edit_mfi_financing_reg($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}

	public function edit_mfi_cif($data,$param2)
	{
		$this->db->update('mfi_cif',$data,$param2);
	}
	
	public function cek_max_jangka_waktu($produk_code)
	{
		$sql = "select max_jangka_waktu from mfi_product_financing where product_code = ?";
		$query = $this->db->query($sql,array($produk_code));
		return $query->row_array();
	}
	
	public function get_akad_by_peruntukan($code_value)
	{
		$sql = "select akad_name from mfi_akad where akad_code = ?";
		$query = $this->db->query($sql,array($code_value));
		return $query->row_array();
	}

	public function get_uw_policy($product_code,$usia,$manfaat)
	{
		$sql = "select fn_get_uwpolicy(?,?,?) uw_policy";
		$query = $this->db->query($sql,array($product_code,$usia,$manfaat));
		$row = $query->row_array();
		return $row['uw_policy'];
	}

	public function jqgrid_registrasi_akad($sidx='',$sord='',$limit_rows='',$start='',$kopegtel_code,$tipe_keyword='',$keyword='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select
				mfi_account_financing_reg.registration_no,
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.peruntukan,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.jangka_waktu,
				mfi_account_financing_reg.approve_date,
				mfi_product_financing.flag_scoring,
				mfi_account_financing.status_rekening,
				mfi_account_financing.account_financing_no,
				mfi_product_financing.product_name,
				(select count(*) from mfi_account_financing ex where ex.registration_no=mfi_account_financing_reg.registration_no) as financing_is_exist,						
				(select
						mfi_list_code_detail.display_text
					from
						mfi_list_code_detail
					where mfi_account_financing_reg.peruntukan = cast(mfi_list_code_detail.display_sort as integer )
						  and code_group = 'peruntukan'
				) as display_peruntukan
				from
				mfi_account_financing_reg
				inner join mfi_cif on mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				inner join mfi_product_financing on mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				left join mfi_account_financing_scoring on mfi_account_financing_reg.registration_no=mfi_account_financing_scoring.registration_no
				left join mfi_account_financing on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no	
				where mfi_account_financing_reg.status = 1 and (case when mfi_account_financing.status_rekening is null then 0 else mfi_account_financing.status_rekening end) not in(1,2,3,4)		
			   ";

		if ($keyword!="") {
			$sql .= " and upper(mfi_cif.".$tipe_keyword.") like ?";
			$keyword 	= strtolower($keyword);
			$keyword 	= strtoupper($keyword);
			$param[] 	= '%'.$keyword.'%';
			$param[] 	= '%'.$keyword.'%';
		}

		$sql .= " and mfi_account_financing_reg.kopegtel_code = ?";
		$param[] = $kopegtel_code;

		$sql .= " $order $limit ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_account_saving_by_cif($nik)
	{
		$sql = "select account_saving_no from mfi_account_saving where cif_no = ?";
		$query = $this->db->query($sql,array($nik));
		$row = $query->row_array();
		if(isset($row['account_saving_no'])==null){
          return 0;
        }else{
          return $row['account_saving_no'];
        }
	}

	function get_premium_rate_result($rate_code,$usia,$kontrak)
	{
		$sql = "select fn_get_premium_rate(?,?,?) as rate_value";
		$query = $this->db->query($sql,array($rate_code,$usia,$kontrak));
		$row = $query->row_array();
		return $row['rate_value'];
	}

	public function select_financing_reg_by_id($id='')
	{
		$sql = "select 
				a.*,
				b.branch_code,
				c.akad_code
				from 
				mfi_account_financing_reg a, mfi_cif b, mfi_product_financing c 
				where a.cif_no=b.cif_no 
				and a.product_code=c.product_code
				and a.account_financing_reg_id = ?
			   ";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function get_seq_account_financing_no($product_code,$cif_no)
	{
		$sql = "SELECT max(RIGHT(account_financing_no,2)) AS jumlah from mfi_account_financing where product_code = ? and cif_no = ?";
		$query = $this->db->query($sql,array($product_code,$cif_no));
		return $query->row_array();
	}

	public function add_rekening_pembiayaan($data)
	{
		$this->db->insert('mfi_account_financing',$data);
	}

	public function edit_pengajuan_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}

	public function get_data_edit_pengajuan_by_id($account_financing_reg_id)
	{
		$sql = "select
				mfi_pegawai.nik,
				mfi_pegawai.nama_pegawai,
				mfi_pegawai.band,
				mfi_pegawai.loker,
				mfi_pegawai.posisi,
				mfi_pegawai.tempat_lahir,
				mfi_pegawai.tgl_lahir,
				mfi_pegawai.tgl_pensiun_normal,
				mfi_cif.alamat,
				mfi_cif.nama_pasangan,
				mfi_cif.pekerjaan_pasangan,
				mfi_cif.jumlah_tanggungan,
				mfi_pegawai.thp,
				(mfi_pegawai.thp*40/100) as thp_40,
				mfi_account_financing_reg.jumlah_kewajiban,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cif.no_ktp,
				mfi_cif.status_rumah,
				mfi_cif.nama_bank,
				mfi_cif.bank_cabang,
				mfi_cif.no_rekening,
				mfi_cif.atasnama_rekening,
				mfi_cif.usia,
				mfi_cif.cif_type,
				(select rate_margin2 from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as rate_margin2,
				(select rate_margin1 from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as rate_margin1,
				(select product_name from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as produk,
				(select jenis_margin from mfi_product_financing where product_code = mfi_account_financing_reg.product_code) as jenis_margin,
				(select display_text from mfi_list_code_detail where code_group='peruntukan' and display_sort = mfi_account_financing_reg.peruntukan) as peruntukan,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.jangka_waktu,
				mfi_account_financing_reg.pengajuan_melalui,
				(select nama_kopegtel from mfi_kopegtel where kopegtel_code = mfi_account_financing_reg.kopegtel_code) as kopegtel_code,
				(select nama_kopegtel from mfi_kopegtel where kopegtel_code = mfi_account_financing_reg.pelunasan_ke_kopeg_mana) as pelunasan_ke_kopeg_mana,
				mfi_account_financing_reg.jangka_waktu,
				mfi_account_financing_reg.jumlah_angsuran,
				mfi_account_financing_reg.product_code,
				mfi_account_financing_reg.lunasi_ke_koptel,
				mfi_account_financing_reg.lunasi_ke_kopegtel,
				mfi_account_financing_reg.saldo_kewajiban_ke_koptel,
				mfi_account_financing_reg.saldo_kewajiban,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.margin,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo
				from mfi_account_financing_reg
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				inner join mfi_cif on mfi_cif.cif_no = mfi_account_financing_reg.cif_no
				left join mfi_account_financing on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
				where mfi_account_financing_reg.account_financing_reg_id = ?
			   ";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}

	public function update_to_mfi_financing($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	public function get_customer_by_keyword($keyword,$kopegtel_code)
	{
		$param = array();
		$sql = "select
				mfi_account_financing.account_financing_no,
				mfi_cif.nama
				from
				mfi_account_financing
				left join mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
				left join mfi_account_financing_reg on mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				where (upper(mfi_cif.nama) like ? or mfi_account_financing.account_financing_no like ?) 
				and (mfi_account_financing.status_rekening = '1' or mfi_account_financing.status_rekening = '0')
				and mfi_cif.cif_type = '1'
			   ";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		$sql .= " and mfi_account_financing_reg.kopegtel_code = ?";
		$param[] = $kopegtel_code;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_customer_by_no_pembiayaan($id)
	{
		$param = array();
		$sql = "select
				mfi_account_financing.account_financing_id,
				mfi_cif.nama,
				mfi_akad.akad_name,
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_account_financing.registration_no,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.status_anggota
				from
				mfi_account_financing
				left join mfi_cif on mfi_cif.cif_no = mfi_account_financing.cif_no
				left join mfi_akad on mfi_akad.akad_code = mfi_account_financing.akad_code
				left join mfi_product_financing on mfi_product_financing.product_code = mfi_account_financing.product_code
				where mfi_account_financing.account_financing_no = ?
			   ";

		$param[] = $id;

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}
	
	public function cetak_akad_pembiayaan_data($account_financing_id="")
	{
		$sql = "select
						 mfi_account_financing.account_financing_id
						,mfi_account_financing.cif_no
						,mfi_account_financing.account_financing_no
						,mfi_account_financing.pokok
						,mfi_account_financing.margin
						,mfi_cif.nama
						,mfi_cif.alamat
						,mfi_cif.rt_rw
						,mfi_cif.desa
						,mfi_cif.kecamatan
						,mfi_cif.kabupaten
						,mfi_cif.kodepos
						,mfi_cif.pekerjaan
						,mfi_cif.no_ktp
						,mfi_cif.usia
						,mfi_cif.branch_code
						,mfi_cif.tmp_lahir
						,mfi_cif.tgl_lahir
						,mfi_cif.nama_pasangan
						,mfi_cif.telpon_seluler
						,mfi_account_financing_reg.description
						,mfi_account_financing_reg.tanggal_pengajuan
						,mfi_account_financing_reg.nama_bank
						,mfi_account_financing_reg.no_rekening
						,mfi_account_financing_reg.atasnama_rekening
						,mfi_account_financing_reg.pengajuan_melalui
						,mfi_account_financing_reg.kopegtel_code
						,mfi_account_financing.tanggal_akad
						,mfi_account_financing.jangka_waktu
						,mfi_account_financing.periode_jangka_waktu
						,mfi_product_financing.product_name
						,mfi_product_financing.product_code
						,mfi_account_financing.angsuran_pokok
						,mfi_account_financing.angsuran_margin
						,mfi_account_financing.angsuran_catab
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.tanggal_jtempo
						,mfi_account_financing.biaya_administrasi
						,mfi_account_financing.biaya_jasa_layanan
						,mfi_account_financing.biaya_asuransi_jiwa
						,mfi_account_financing.biaya_notaris
						,mfi_account_financing.keterangan_jaminan
						,mfi_account_financing.uang_muka
						,mfi_list_code_detail.display_text
						,(select mfi_list_code_detail.display_text from mfi_list_code_detail where mfi_account_financing.jenis_jaminan = mfi_list_code_detail.display_sort and mfi_list_code_detail.code_group='jaminan') jenis_jaminan
						,(select mfi_list_code_detail.display_text from mfi_list_code_detail where mfi_account_financing.jenis_jaminan_sekunder = mfi_list_code_detail.display_sort and mfi_list_code_detail.code_group='jaminan') jenis_jaminan_sekunder
						,mfi_account_financing.keterangan_jaminan_sekunder
						,mfi_pegawai.band
						,mfi_pegawai.posisi
						,mfi_pegawai.loker
						,mfi_pegawai.code_divisi
					from
						mfi_account_financing
					inner join mfi_account_financing_reg  on mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
					inner join mfi_cif on mfi_account_financing.cif_no = mfi_cif.cif_no
					inner join mfi_product_financing on mfi_account_financing.product_code = mfi_product_financing.product_code
					inner join mfi_list_code_detail on mfi_account_financing.peruntukan = mfi_list_code_detail.display_sort
					inner join mfi_pegawai on mfi_account_financing.cif_no = mfi_pegawai.nik
					where mfi_account_financing.account_financing_id = ?
						and mfi_list_code_detail.code_group='peruntukan'
						";
		$query = $this->db->query($sql,array($account_financing_id));
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_get_institution()
	{
		$sql = "select * from mfi_institution";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function cetak_akad_pembiayaan_get_kopegtel_by_code($kopegtel_code)
	{
		$sql = "SELECT 
					 nama_kopegtel AS institution_name
					,wilayah
					,alamat 
					,ketua_pengurus AS officer_name
					,'Ketua Kopegtel' AS officer_title
				FROM mfi_kopegtel WHERE kopegtel_code=? ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->row_array();
	}
	
	public function get_informasi_dashboard($kopegtel_code)
	{
		$sql = "SELECT 
				1 as urut,
				'Pengajuan pembiayaan baru' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_reg 
				where status=0 and kopegtel_code = ?
				union all
				select 
				2 as urut,
				'Pengajuan waiting approval asuransi' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_reg 
				where uw_policy not in ('FC','NM') and status=0 and kopegtel_code = ?
				union all
				select 
				3 as urut,
				'Proses approval melebihi batas waktu' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_reg 
				where uw_policy in ('FC','NM') and (tanggal_pengajuan-current_date)>3 and kopegtel_code = ? and status=0
				union all
				select 
				4 as urut,
				'Proses asuransi melebihi batas waktu' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_reg 
				where uw_policy not in ('FC','NM') and status=0 and (tanggal_pengajuan-current_date)>10 and kopegtel_code = ?
				union all
				select 
				5 as urut,
				'Pengajuan pembiayaan di approval' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing
				inner join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no
				where mfi_account_financing_reg.kopegtel_code = ? and status=1
					and mfi_account_financing_reg.registration_no 
					not in(select b.registration_no from mfi_account_financing b)
				union all
				select 
				6 as urut,
				'Pembiayaan sedang proses transfer' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_droping
				inner join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing_droping.cif_no
				where mfi_account_financing_reg.kopegtel_code = ? and mfi_account_financing_droping.status_transfer=0
				union all
				select 
				7 as urut,
				'Pembiayaan selesai proses transfer hari ini' as deskripsi, 
				count(*) as jumlah 
				from mfi_account_financing_droping 
				inner join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing_droping.cif_no
				where mfi_account_financing_droping.created_date=current_date and mfi_account_financing_reg.kopegtel_code = ?
			   ";
		$query = $this->db->query($sql,array($kopegtel_code,$kopegtel_code,$kopegtel_code,$kopegtel_code,$kopegtel_code,$kopegtel_code,$kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_1($kopegtel_code)
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.status,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_reg 
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.status=0 and mfi_account_financing_reg.kopegtel_code = ?
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_2($kopegtel_code)
	{
		$sql = "SELECT 
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.status,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_reg 
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.uw_policy not in ('FC','NM') and mfi_account_financing_reg.status=0 and mfi_account_financing_reg.kopegtel_code = ?
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_3($kopegtel_code)
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_reg 
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.uw_policy in ('FC','NM') and (mfi_account_financing_reg.tanggal_pengajuan-current_date)>3 and mfi_account_financing_reg.kopegtel_code = ? and mfi_account_financing_reg.status=0 
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_4($kopegtel_code)
	{
		$sql = "SELECT 
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.status,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_reg 
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.uw_policy not in ('FC','NM') and mfi_account_financing_reg.status=0 and (mfi_account_financing_reg.tanggal_pengajuan-current_date)>10 and mfi_account_financing_reg.kopegtel_code = ? 
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_5($kopegtel_code)
	{
		$sql = "SELECT 
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_account_financing_reg.status,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_reg
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_reg.cif_no
				where mfi_account_financing_reg.kopegtel_code = ? and mfi_account_financing_reg.status=1
				 and mfi_account_financing_reg.registration_no not in
				 (select registration_no from mfi_account_financing);
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_6($kopegtel_code)
	{
		$sql = "SELECT 
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_droping
				inner join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing_droping.cif_no
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_droping.cif_no
				where mfi_account_financing_reg.kopegtel_code = ? and mfi_account_financing_droping.status_transfer=0
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}
	
	public function get_informasi_pengajuan_by_id_7($kopegtel_code)
	{
		$sql = "select 
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_pegawai.nama_pegawai
				from mfi_account_financing_droping 
				inner join mfi_account_financing_reg on mfi_account_financing_reg.cif_no = mfi_account_financing_droping.cif_no
				inner join mfi_pegawai on mfi_pegawai.nik = mfi_account_financing_droping.cif_no
				where mfi_account_financing_droping.created_date=current_date and mfi_account_financing_reg.kopegtel_code = ?
			   ";
		$query = $this->db->query($sql,array($kopegtel_code));
		return $query->result_array();
	}

	public function update_flag_thp($data,$param)
	{
		$this->db->update('mfi_spesial_rate',$data,$param);
	}

	public function update_thp_pegawai($data,$param)
	{
		$this->db->update('mfi_pegawai',$data,$param);
	}
	
	public function get_status_dokumen_lengkap_by_product_code($product_code)
	{
		$sql = "select count(*) as num from mfi_list_code_detail where code_value = ? and code_group='statusdoktdklengkap'";
		$query = $this->db->query($sql,array($product_code));
		$row = $query->row_array();
		if ($row['num']==0) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function insert_batch_schedulle($datas)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$datas);
	}
	
	// public function insert_mfi_user($data_user)
	// {
	// 	$this->db->insert_mfi_user('mfi_user',$data_user);
	// }
	public function delete_batch_schedulle($param)
	{
		$this->db->delete('mfi_account_financing_schedulle',$param);
	}

	public function get_data_jaminan($registration_no='')
	{
		$sql = "SELECT a.*, b.province,c.city
				FROM
				mfi_jaminan a
				LEFT JOIN mfi_province_code b ON a.provinsi=b.province_code
				LEFT JOIN mfi_province_city c ON a.kota=c.city_code
				WHERE a.registration_no = ? ";

		$query = $this->db->query($sql,array($registration_no));
		return $query->row_array();
	}

	public function get_schedulle_by_account_financing_id($account_financing_id='')
	{
		$sql="SELECT 
					a.*
					,b.pokok
				FROM mfi_account_financing_schedulle a
				INNER JOIN mfi_account_financing b ON a.account_no_financing=b.account_financing_no
				AND b.account_financing_id=?
				ORDER BY a.tangga_jtempo ";
		$param[]=$account_financing_id;

		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_mitra_koperasi_not_having_kopeg()
	{
		$sql = "select 
				distinct
				mfi_pegawai_kopegtel.kopegtel_code,
				mfi_kopegtel.nama_kopegtel
				from mfi_pegawai_kopegtel
				inner join mfi_kopegtel on mfi_kopegtel.kopegtel_code = mfi_pegawai_kopegtel.kopegtel_code
			   ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_trx_kontrol_periode_active()
	{
		$sql = "SELECT periode_id, periode_awal, periode_akhir from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

}