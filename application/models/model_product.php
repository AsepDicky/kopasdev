<?php

Class Model_product extends CI_Model {

	public function function_insert($table,$data)
	{
		$this->db->insert($table,$data);		
	}

	public function function_delete($table,$param){
		$this->db->delete($table,$param);
	}

	public function function_update($table,$data,$param)
	{
		$this->db->update($table,$data,$param);
	}

	public function function_select_all($table)
	{
		$sql = "SELECT * FROM $table ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function function_select_gl_account()
	{
		$sql = "SELECT account_code,account_name FROM mfi_gl_account ORDER BY 1 ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/****************************************************************************************/	
	// BEGIN PRODUCT TABUNGAN
	/****************************************************************************************/
	public function datatable_produk_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_product_saving ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_tabungan_by_product_id($product_saving_id)
	{
		$sql = "SELECT * from mfi_product_saving where product_saving_id = ?";
		$query = $this->db->query($sql,array($product_saving_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL PEMBIAYAAN
	/****************************************************************************************/
	public function datatable_produk_gl_pembiayaan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
							mfi_product_financing_gl.product_financing_gl_id
							,mfi_product_financing_gl.product_financing_gl_code
							,mfi_product_financing_gl.description
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_pokok = mfi_gl_account.account_code
							 ) AS gl_saldo_pokok
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_margin = mfi_gl_account.account_code
							 ) AS gl_saldo_margin
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_catab = mfi_gl_account.account_code
							 ) AS gl_saldo_catab
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_wajib = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_wajib
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_kelompok = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_kelompok
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_sukarela = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_sukarela
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_cad_resiko = mfi_gl_account.account_code
							 ) AS gl_saldo_cad_resiko
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_pendapatan_margin = mfi_gl_account.account_code
							 ) AS gl_pendapatan_margin
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_pendapatan_adm = mfi_gl_account.account_code
							 ) AS gl_pendapatan_adm
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_asuransi_jiwa = mfi_gl_account.account_code
							 ) AS gl_asuransi_jiwa
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_asuransi_jaminan = mfi_gl_account.account_code
							 ) AS gl_asuransi_jaminan
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_biaya_cpp = mfi_gl_account.account_code
							 ) AS gl_biaya_cpp
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_cpp = mfi_gl_account.account_code
							 ) AS gl_cpp
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_biaya_notaris = mfi_gl_account.account_code
							 ) AS gl_biaya_notaris
				FROM
							mfi_product_financing_gl
 ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_financing_gl_by_product_id_view($product_financing_gl_id)
	{
		$sql = "SELECT
							mfi_product_financing_gl.product_financing_gl_id
							,mfi_product_financing_gl.product_financing_gl_code
							,mfi_product_financing_gl.description
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_pokok = mfi_gl_account.account_code
							 ) AS gl_saldo_pokok
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_margin = mfi_gl_account.account_code
							 ) AS gl_saldo_margin
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_catab = mfi_gl_account.account_code
							 ) AS gl_saldo_catab
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_wajib = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_wajib
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_kelompok = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_kelompok
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_tab_sukarela = mfi_gl_account.account_code
							 ) AS gl_saldo_tab_sukarela
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_saldo_cad_resiko = mfi_gl_account.account_code
							 ) AS gl_saldo_cad_resiko
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_pendapatan_margin = mfi_gl_account.account_code
							 ) AS gl_pendapatan_margin
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_pendapatan_adm = mfi_gl_account.account_code
							 ) AS gl_pendapatan_adm
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_asuransi_jiwa = mfi_gl_account.account_code
							 ) AS gl_asuransi_jiwa
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_asuransi_jaminan = mfi_gl_account.account_code
							 ) AS gl_asuransi_jaminan
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_biaya_cpp = mfi_gl_account.account_code
							 ) AS gl_biaya_cpp
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_cpp = mfi_gl_account.account_code
							 ) AS gl_cpp
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_biaya_notaris = mfi_gl_account.account_code
							 ) AS gl_biaya_notaris
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_titipan_wakalah = mfi_gl_account.account_code
							 ) AS gl_titipan_wakalah
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_persediaan_mba = mfi_gl_account.account_code
							 ) AS gl_persediaan_mba
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_uangmuka = mfi_gl_account.account_code
							 ) AS gl_uangmuka
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_mukasah = mfi_gl_account.account_code
							 ) AS gl_mukasah
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_simpanan_wajib_pinjam = mfi_gl_account.account_code
							 ) AS gl_simpanan_wajib_pinjam
							,(	SELECT
									mfi_gl_account.account_name
								FROM
									mfi_gl_account
								WHERE mfi_product_financing_gl.gl_titipan_pencairan = mfi_gl_account.account_code
							 ) AS gl_titipan_pencairan
				FROM
							mfi_product_financing_gl
				WHERE product_financing_gl_id = ?";
		$query = $this->db->query($sql,array($product_financing_gl_id));

		return $query->row_array();
	}

	public function get_financing_gl_by_product_id($product_financing_gl_id)
	{
		$sql = "SELECT
							*
				FROM
							mfi_product_financing_gl
				WHERE product_financing_gl_id = ?";
		$query = $this->db->query($sql,array($product_financing_gl_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT GL PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL DEPOSITO
	/****************************************************************************************/
	public function datatable_produk_gl_deposito($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_product_deposit_gl.product_deposit_gl_id
						,mfi_product_deposit_gl.product_deposit_gl_code
						,mfi_product_deposit_gl.description
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_deposit_gl.gl_saldo = mfi_gl_account.account_code
						 ) AS gl_saldo
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_deposit_gl.gl_bagihasil = mfi_gl_account.account_code
						 ) AS gl_bagihasil
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_deposit_gl.gl_pajak_bagihasil = mfi_gl_account.account_code
						 ) AS gl_pajak_bagihasil
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_deposit_gl.gl_zakat_bagihasil = mfi_gl_account.account_code
						 ) AS gl_zakat_bagihasil
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_deposit_gl.gl_adm = mfi_gl_account.account_code
						 ) AS gl_adm
				FROM
						mfi_product_deposit_gl
 					";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_gl_deposito_by_product_id($product_deposit_gl_id)
	{
		$sql = "SELECT * from mfi_product_deposit_gl where product_deposit_gl_id = ?";
		$query = $this->db->query($sql,array($product_deposit_gl_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT GL DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL INSURANCE
	/****************************************************************************************/
	public function datatable_produk_gl_insurance($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_product_insurance_gl.product_insurance_gl_id
						,mfi_product_insurance_gl.product_insurance_gl_code
						,mfi_product_insurance_gl.description
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_insurance_gl.gl_premi = mfi_gl_account.account_code
						 ) AS gl_premi
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_insurance_gl.gl_ujroh = mfi_gl_account.account_code
						 ) AS gl_ujroh
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_insurance_gl.gl_tabarru = mfi_gl_account.account_code
						 ) AS gl_tabarru
				FROM
						mfi_product_insurance_gl ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_gl_insurance_by_product_id($product_insurance_gl_id)
	{
		$sql = "SELECT * from mfi_product_insurance_gl where product_insurance_gl_id = ?";
		$query = $this->db->query($sql,array($product_insurance_gl_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT GL INSURANCE
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT GL TABUNGAN
	/****************************************************************************************/
	public function datatable_produk_gl_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_product_saving_gl.product_saving_gl_id
						,mfi_product_saving_gl.product_saving_gl_code
						,mfi_product_saving_gl.description
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_saving_gl.gl_saldo = mfi_gl_account.account_code
						 ) AS gl_saldo
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_saving_gl.gl_biaya = mfi_gl_account.account_code
						 ) AS gl_biaya
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_saving_gl.gl_adm = mfi_gl_account.account_code
						 ) AS gl_adm
						,(	SELECT
								mfi_gl_account.account_name
							FROM
								mfi_gl_account
							WHERE mfi_product_saving_gl.gl_saldo_dalamproses = mfi_gl_account.account_code
						 ) AS gl_saldo_dalamproses
						FROM
						mfi_product_saving_gl
						 ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_gl_tabungan_by_product_id($product_saving_gl_id)
	{
		$sql = "SELECT * from mfi_product_saving_gl where product_saving_gl_id = ?";
		$query = $this->db->query($sql,array($product_saving_gl_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT GL TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN PRODUCT TABUNGAN
	/****************************************************************************************/
	public function datatable_produk_deposito($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_product_deposit ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_deposito_by_product_id($product_deposit_id)
	{
		$sql = "SELECT * from mfi_product_deposit where product_deposit_id = ?";
		$query = $this->db->query($sql,array($product_deposit_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN NOMINAL
	/****************************************************************************************/
	public function datatable_nominal($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$sql = "SELECT * FROM mfi_nominal WHERE branch_code = '$branch_code' ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_nominal_by_nominal_id($nominal_id)
	{
		$sql = "SELECT * from mfi_nominal where nominal_id = ?";
		$query = $this->db->query($sql,array($nominal_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END NOMINAL
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT PEMBIAYAAN
	/****************************************************************************************/
	public function datatable_produk_pembiayaan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_product_financing ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_financing_by_product_id($product_financing_gl_id)
	{
		$sql = "SELECT 		mfi_product_financing.product_financing_id,
							mfi_product_financing.product_code,
							mfi_product_financing.rate_margin1,
							mfi_product_financing.rate_margin2,
							mfi_product_financing.periode_angsuran,
							mfi_product_financing.product_name,
							mfi_product_financing.nick_name,
							mfi_product_financing.jenis_pembiayaan,
							mfi_product_financing.flag_asuransi,
							mfi_product_financing.insurance_product_code,
							mfi_product_financing.type_bya_adm,
							mfi_product_financing.rate_bya_adm,
							mfi_product_financing.nominal_bya_adm,
							mfi_product_financing.akad_code,
							mfi_product_financing.flag_manfaat_asuransi,
							mfi_product_financing.product_financing_gl_code,
							mfi_product_financing.flag_scoring,
							mfi_product_financing.rate_simpanan_wajib_pinjam,
							mfi_product_financing.bagihasil_nasabah,
							mfi_product_financing.bagihasil_perusahaan,
							mfi_product_financing.jasa_layanan,
							mfi_product_financing.jenis_margin,
							mfi_product_financing.uw_code,
							mfi_akad.jenis_keuntungan,
							mfi_product_insurance.product_name AS insurance_name,
							mfi_product_financing_gl.description AS gl_description
				FROM
							mfi_product_financing
				LEFT JOIN mfi_product_insurance ON mfi_product_insurance.product_code = mfi_product_financing.insurance_product_code
				LEFT JOIN mfi_product_financing_gl ON mfi_product_financing.product_financing_gl_code = mfi_product_financing_gl.product_financing_gl_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_product_financing.akad_code AND mfi_akad.type_product=2
				WHERE 		mfi_product_financing.product_financing_id = ?";
		$query = $this->db->query($sql,array($product_financing_gl_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PRODUCT PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN PRODUCT ASURANSI
	/****************************************************************************************/
	public function datatable_produk_asuransi($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_product_insurance ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_product_insurance_id($product_insurance_id)
	{
		$sql = "SELECT * from mfi_product_insurance where product_insurance_id = ?";
		$query = $this->db->query($sql,array($product_insurance_id));

		return $query->row_array();
	}

	public function get_insurance_gl()
	{
		$sql = "SELECT * from mfi_product_insurance_gl";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_rate_kode()
	{
		$sql = "SELECT rate_code FROM mfi_product_insurance_rate GROUP BY 1";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_plan_kode()
	{
		$sql = "SELECT * from mfi_product_insurance_plan";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END PRODUCT ASURANSI
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN AKAD
	/****************************************************************************************/
	public function datatable_akad($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_akad.akad_id,
						mfi_akad.akad_code,
						mfi_akad.akad_name,
						mfi_akad.type_product,
						mfi_akad.jenis_keuntungan
				FROM
						mfi_akad
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_akad_by_akad_id($akad_id)
	{
		$sql = "SELECT * from mfi_akad where akad_id = ?";
		$query = $this->db->query($sql,array($akad_id));

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END PAKAD
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIS CATEGORY
	/****************************************************************************************/
	public function datatable_list_category($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_list_code.list_code_id,
						mfi_list_code.code_description,
						mfi_list_code.code_group
				FROM
						mfi_list_code
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_list_category_by_list_code_id($list_code_id)
	{
		$sql = "SELECT * from mfi_list_code where list_code_id = ?";
		$query = $this->db->query($sql,array($list_code_id));

		return $query->row_array();
	}


	// DETAIL

	public function datatable_detail_list_category($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_list_code_detail.list_code_detail_id,
						mfi_list_code_detail.code_group,
						mfi_list_code_detail.code_value,
						mfi_list_code_detail.display_text,
						mfi_list_code_detail.display_sort
				FROM
						mfi_list_code_detail
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function get_detail_list_category_by_list_code_id($list_code_detail_id)
	{
		$sql = "SELECT * from mfi_list_code_detail where list_code_detail_id = ?";
		$query = $this->db->query($sql,array($list_code_detail_id));

		return $query->row_array();
	}

	public function get_akad_tabungan()
	{
		$sql = "SELECT * FROM mfi_akad WHERE type_product = 0";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_akad_deposit()
	{
		$sql = "SELECT * FROM mfi_akad WHERE type_product = 1";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_akad_financing()
	{
		$sql = "SELECT * FROM mfi_akad WHERE type_product = 2";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_akad_asuransi()
	{
		$sql = "SELECT * FROM mfi_akad WHERE type_product = 3";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	/****************************************************************************************/	
	// END LIS CATEGORY
	/****************************************************************************************/

	public function datatable_approval_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "select 
					mfi_product_financing_approval.*, 
					mfi_product_financing.product_name,
					mfi_jabatan.nama_jabatan 
				from 
					mfi_product_financing_approval 
				join mfi_product_financing on mfi_product_financing.product_code = mfi_product_financing_approval.product_code 
				join mfi_jabatan on mfi_jabatan.kode_jabatan=mfi_product_financing_approval.kode_jabatan
			";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_product_financing.jenis_pembiayaan = 0";
		}else{
			$sql .= "where mfi_product_financing.jenis_pembiayaan = 0";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_produk_pembiayaan()
	{
		$sql = "select * from mfi_product_financing where jenis_pembiayaan = 0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function save_approval_pembiayaan($data)
	{
		$this->db->insert('mfi_product_financing_approval',$data);
	}

	public function delete_approval_pembiayaan($param)
	{
		$this->db->delete('mfi_product_financing_approval',$param);
	}

	public function get_approval_by_id($product_financing_approval_id)
	{
		$sql = "select * from mfi_product_financing_approval where product_financing_approval_id = ?";
		$query = $this->db->query($sql,array($product_financing_approval_id));

		return $query->row_array();
	}

	public function edit_approval_pembiayaan($data,$param)
	{	
		$this->db->update('mfi_product_financing_approval',$data,$param);
	}
	/**
	* data product saving
	* @author : sayyid nurkilah
	*/
	function get_product_saving()
	{
		$query=$this->db->get('mfi_product_saving');
		return $query->result_array();
	}
	/**
	* parameter kolektibilitas
	* @author : sayyid nurkilah
	*/
	function insert_parameter_kolektibilitas($data)
	{
		$this->db->insert('mfi_param_par',$data);
	}
	function datatable_parameter_kolektibilitas($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_param_par ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	function get_parameter_kolektibilitas_by_id($param_par_id)
	{
		$sql="select param_par_id,jumlah_hari_1,jumlah_hari_2,par_desc,cpp from mfi_param_par where param_par_id=?";
		$query=$this->db->query($sql,array($param_par_id));
		return $query->row_array();
	}
	function update_parameter_kolektibilitas($data,$param)
	{
		$this->db->update('mfi_param_par',$data,$param);
	}
	function delete_parameter_kolektibilitas()
	{
		
	}
	function get_underwritings()
	{
		$sql = "select uw_code,uw_name from mfi_underwriting order by 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}