<?php

Class Model_nasabah extends CI_Model 
{
	/* BEGIN REGISTRASI PELUNASAN PEMBIAYAAN *******************************************************/
	public function datatable_pelunasan_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_financing_lunas.account_financing_no,
				mfi_cif.nama,
				mfi_akad.akad_name,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing_lunas.account_financing_lunas_id
				FROM
				mfi_account_financing_lunas
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
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

	public function get_cif_by_account_financing_no($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
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
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cif.jenis_kelamin,
				mfi_cif.nama_pasangan,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.status_anggota,
				mfi_account_financing.menyetujui,
				mfi_account_financing.saksi1,
				mfi_account_financing.saksi2,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.counter_angsuran,
				mfi_account_financing_schedulle.account_financing_schedulle_id,
				mfi_akad.akad_name,
				mfi_akad.akad_code,
				mfi_akad.jenis_keuntungan,
				mfi_product_financing.product_name,
				mfi_product_financing.product_code
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_account_financing_schedulle ON mfi_account_financing_schedulle.account_no_financing = mfi_account_financing.account_financing_no
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				WHERE mfi_account_financing.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function proses_reg_pelunasan_pembayaran($data)
	{
		$this->db->insert('mfi_account_financing_lunas',$data);
	}

	public function get_financing_by_id($account_financing_lunas_id)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_product_financing.product_name,
				mfi_akad.akad_name,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.account_saving_no,
				mfi_account_financing_lunas.account_financing_lunas_id,
				mfi_account_financing_lunas.saldo_pokok,
				mfi_account_financing_lunas.saldo_margin,
				mfi_account_financing_lunas.saldo_catab,
				mfi_account_financing_lunas.potongan_margin,
				mfi_account_saving.saldo_memo,
				x.trx_date,
				x.account_cash_code
				FROM
				mfi_account_financing_lunas
				INNER JOIN  mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_account_financing.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				LEFT JOIN mfi_trx_account_financing x ON x.trx_account_financing_id=mfi_account_financing_lunas.account_financing_lunas_id
				WHERE mfi_account_financing_lunas.account_financing_lunas_id = ?";
				
		$query = $this->db->query($sql,array($account_financing_lunas_id));

		return $query->row_array();
	}

	public function proses_edit_pelunasan_pembayaran($data,$param)
	{
		$this->db->update('mfi_account_financing_lunas',$data,$param);
	}

	public function delete_data_pelunasan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_lunas',$param);
	}

	public function update_account_financing($data_financing,$param_financing)
	{
		$this->db->update('mfi_account_financing',$data_financing,$param_financing);
	}

	public function update_account_financing_schedulle($data_financing_schedulle,$param_financing_schedulle)
	{
		$this->db->update('mfi_account_financing_schedulle',$data_financing_schedulle,$param_financing_schedulle);
	}
	/* END PELUNASAN PEMBIAYAAN**********************************************************/


	/* BEGIN VERIFIKASI PELUNASAN PEMBIAYAAN**********************************************************/

	public function datatable_verifikasi_pelunasan_pembiayaan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_financing_lunas.account_financing_no,
				mfi_cif.nama,
				mfi_akad.akad_name,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing_lunas.account_financing_lunas_id
				FROM
				mfi_account_financing_lunas
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_account_financing_lunas.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " WHERE mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function proses_verifikasi_pelunasan_pembayaran($data,$param)
	{
		$this->db->update('mfi_account_financing_lunas',$data,$param);
	}

	public function update_account_financing_data($data_acc_financing,$param_acc_financing)
	{
		$this->db->update('mfi_account_financing',$data_acc_financing,$param_acc_financing);
	}

	public function insert_mfi_trx_detail($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function insert_mfi_trx_account_financing($data_trx_account_financing)
	{
		$this->db->insert('mfi_trx_account_financing',$data_trx_account_financing);
	}

	public function insert_batch_mfi_trx_account_financing($data_trx_account_financing)
	{
		$this->db->insert_batch('mfi_trx_account_financing',$data_trx_account_financing);
	}

	public function insert_mfi_trx_account_saving($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function reject_data_pelunasan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_lunas',$param);
	}

	/* END VERIFIKASI PELUNASAN PEMBIAYAAN**********************************************************/

	/* BEGIN PENCAIRAN PEMBIAYAAN**********************************************************/
	public function datatable_pencairan_pembiayaanTAM($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing_droping.status_droping,
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_fa.fa_name
				FROM
				mfi_account_financing
				LEFT JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				INNER JOIN mfi_fa ON mfi_account_financing_reg.fa_code=mfi_fa.fa_code
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing.status_rekening='0' AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			$sql .= "WHERE mfi_account_financing.status_rekening='0' AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function delete_data_financing_from_financing_droping($param_droping)
	{
		$this->db->delete('mfi_account_financing_droping',$param_droping);
	}

	public function update_account_financing_droping($data_financing_droping,$param_financing_droping)
	{
		$this->db->update('mfi_account_financing_droping',$data_financing_droping,$param_financing_droping);
	}

	public function update_default_balance($data_default_balance,$param_default_balance)
	{
		$this->db->update('mfi_account_default_balance',$data_default_balance,$param_default_balance);
	}
	/* END PENCAIRAN PEMBIAYAAN**********************************************************/


	/* BEGIN BLOKIR TABUNGAN**********************************************************/

	public function get_cif_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_saving.account_saving_id,
				mfi_account_saving.account_saving_no,
				mfi_product_saving.product_code,
				mfi_product_saving.product_name,
				mfi_account_saving.saldo_memo,
				mfi_product_saving.saldo_minimal
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving_from_blokir($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function insert_account_saving_blokir($data_blokir_saving)
	{
		$this->db->insert('mfi_account_saving_blokir',$data_blokir_saving);
	}
	/* END BLOKIR TABUNGAN**********************************************************/

	/* BEGIN BUKA BLOKIR TABUNGAN**********************************************************/

	public function get_cif_by_account_saving_no_for_buka($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_saving.account_saving_id,
				mfi_account_saving.account_saving_no,
				mfi_product_saving.product_code,
				mfi_product_saving.product_name,
				mfi_account_saving.saldo_memo,
				mfi_account_saving_blokir.account_saving_blokir_id,
				mfi_account_saving_blokir.amount,
				mfi_account_saving_blokir.description,
				mfi_product_saving.saldo_minimal,
				mfi_account_saving.saldo_hold,
				mfi_account_saving.status_rekening
				FROM mfi_account_saving_blokir
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no=mfi_account_saving_blokir.account_saving_no
				LEFT JOIN mfi_product_saving ON mfi_product_saving.product_code=mfi_account_saving.product_code
				LEFT JOIN mfi_cif ON mfi_cif.cif_no=mfi_account_saving.cif_no
				WHERE mfi_account_saving_blokir.account_saving_no = ? AND mfi_account_saving_blokir.tipe_mutasi=2";

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving_from_buka($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function update_account_saving_blokir($data_blokir_saving,$param_blokir_saving)
	{
		$this->db->update('mfi_account_saving_blokir',$data_blokir_saving,$param_blokir_saving);
	}
	/* END BUKA BLOKIR TABUNGAN**********************************************************/

	/* BEGIN PENGAJUAN KLAIM ASURANSI**********************************************************/
	// search account saving number
	public function search_cif_by_account_insurance_no($account_insurance_no)
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_account_insurance.product_code,
				mfi_product_insurance.product_name,
				mfi_product_insurance.insurance_type,
				mfi_account_insurance.account_insurance_id,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.plan_code,
				mfi_account_insurance.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code= mfi_account_insurance.product_code
				WHERE (mfi_account_insurance.account_insurance_no = ?)";
		
		$query = $this->db->query($sql,array($account_insurance_no));

		return $query->row_array();
	}

	public function pengajuan_klaim_asuransi($data)
	{
		$this->db->insert('mfi_insurance_claim',$data);
	}
	/* END PENGAJUAN KLAIM ASURANSI**********************************************************/

	//BEGIN VERIFIKASI ASURANSI KLAIM
	public function datatable_verifikasi_insurance_klaim($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_insurance.account_insurance_no,
				mfi_account_insurance.account_insurance_id,
				mfi_product_insurance.product_name,
				mfi_insurance_claim.type_claim,
				mfi_insurance_claim.claim_status,
				mfi_insurance_claim.amount_claim
				FROM
				mfi_insurance_claim
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.account_insurance_no = mfi_insurance_claim.account_insurance_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code = mfi_account_insurance.product_code
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

	public function search_cif_by_account_insurance_id($account_insurance_id)
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_account_insurance.product_code,
				mfi_product_insurance.product_name,
				mfi_product_insurance.insurance_type,
				mfi_account_insurance.account_insurance_id,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.plan_code,
				mfi_insurance_claim.type_claim,
				mfi_insurance_claim.date_claim,
				mfi_insurance_claim.insurance_claim_id,
				mfi_account_insurance.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_insurance ON mfi_product_insurance.product_code= mfi_account_insurance.product_code
				INNER JOIN mfi_insurance_claim ON mfi_insurance_claim.account_insurance_no= mfi_account_insurance.account_insurance_no
				WHERE (mfi_account_insurance.account_insurance_id = ?)";
		
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}

	public function proses_verifikasi_klaim_asuransi($data,$param)
	{
		$this->db->update('mfi_insurance_claim',$data,$param);
	}

	public function reject_data_klaim_asuransi($param)
	{
		$this->db->delete('mfi_insurance_claim',$param);
	}

	/****************************************************************************************/
	//BEGIN PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
	public function datatable_pengajuan_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
	{

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							mfi_account_financing_reg.registration_no
							,mfi_cif.cif_no
							,mfi_cif.nama
							,mfi_resort.resort_code
							,mfi_resort.resort_name
							,mfi_account_financing_reg.amount
							,mfi_account_financing_reg.peruntukan
							,mfi_account_financing_reg.tanggal_pengajuan
							,mfi_account_financing_reg.account_financing_reg_id
							,mfi_account_financing_reg.status
							,mfi_account_financing_reg.rencana_droping
							,mfi_product_financing.flag_scoring
							,coalesce((select count(*) from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as scoring_exist
							,coalesce((select total_skor from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as total_skor
							,(SELECT
									mfi_list_code_detail.display_text
								FROM
									mfi_list_code_detail
								WHERE mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.code_value AS integer )
									  AND code_group = 'peruntukan'
							 ) AS display_peruntukan
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code 
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing_reg.resort_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing_reg.status = '0'";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			$sql .= "WHERE mfi_account_financing_reg.status = '0'";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add_pengajuan_pembiayaan($data)
	{
		$this->db->insert('mfi_account_financing_reg',$data);
	}

	public function get_pengajuan_pembiayaan_by_account_financing_reg_id($account_financing_reg_id)
	{
		$sql = "SELECT
							mfi_account_financing_reg.*
							,mfi_cif.nama
							,mfi_cif.cif_type
							,mfi_cif.alamat
							,mfi_cif.telpon_seluler
							,mfi_cif.telpon_rumah
							,mfi_cif.no_ktp
							,mfi_cif.nama_pasangan
							,mfi_cif.pekerjaan_pasangan
							,mfi_cif.jumlah_tanggungan
							,mfi_cif.status_rumah
							,mfi_cif.alamat_lokasi_kerja
							,mfi_pegawai.nik
							,mfi_pegawai.nama_pegawai
							,mfi_pegawai.band
							,mfi_pegawai.posisi
							,mfi_pegawai.loker
							,mfi_pegawai.tempat_lahir
							,mfi_pegawai.tgl_lahir
							,mfi_pegawai.thp
							,mfi_pegawai.koptel
							,mfi_pegawai.tgl_pensiun_normal
							,mfi_pegawai.gender
							,mfi_jaminan.tipe_developer
							,mfi_jaminan.nama_penjual_individu
							,mfi_jaminan.nomer_ktp
							,mfi_jaminan.nama_pasangan_developer
							,mfi_jaminan.nama_perusahaan
							,mfi_list_code_detail.code_value
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_pegawai ON mfi_account_financing_reg.cif_no = mfi_pegawai.nik
				LEFT JOIN mfi_jaminan ON mfi_jaminan.registration_no = mfi_account_financing_reg.registration_no
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value=mfi_account_financing_reg.product_code AND mfi_list_code_detail.code_group='produkbiayadiawal'
				WHERE 		mfi_account_financing_reg.account_financing_reg_id=? ";

		$query = $this->db->query($sql,array($account_financing_reg_id));

		return $query->row_array();
	}

	public function edit_pengajuan_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}
	
	public function delete_pengajuan_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing_reg',$param);
	}

	/****************************************************************************************/
	//END PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	//BEGIN RE SCHEDULLING


	public function get_cif_for_rechedulling($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.jenis_kelamin,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.periode_jangka_waktu
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				WHERE mfi_account_financing.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function proses_reschedulling($data)
	{
		$this->db->insert('mfi_account_financing_re_schedulle',$data);
	}

	//END RE SCHEDULLING

	public function get_account_financing_by_account_financing_no($account_financing_no)
	{
		$sql = "select * from mfi_account_financing where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function history_outstanding_pembiayaan($cif_no)
	{
		$sql = "SELECT account_financing_no, saldo_pokok, saldo_margin, saldo_catab FROM mfi_account_financing WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function get_pyd_ke($cif_no)
	{
		$sql = "SELECT count(cif_no) AS jumlah from mfi_account_financing WHERE cif_no = ? ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function cek_regis_pembiayaan($cif_no)
	{
		$sql = "SELECT count(cif_no) AS jumlah from mfi_account_financing_reg WHERE cif_no = ? AND status=0 ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function validate_pembiayaan($cif_no)
	{
		$sql = "select count(*) as num from mfi_account_financing where cif_no = ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no));

		$row = $query->row_array();
		if(isset($row['num'])){
			if($row['num']==0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	public function get_program_khusus_by_program_owner_code($program_owner_code)
	{
		$sql = "select * from mfi_financing_program where program_owner_code = ?";
		$query = $this->db->query($sql,array($program_owner_code));
		return $query->result_array();
	}

	/**************************************************************************************************/
	//BEGIN PENCAIRAN TABUNGAN Ade 14072014
	/**************************************************************************************************/
	public function proses_pencairan_tabungan($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function grid_verifikasi_pencairan_tabungan($sidx='',$sord='',$limit_rows='',$start='',$branch_id='',$cm_name='',$nama='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
						 a.nama
						,b.cif_no
						,b.account_saving_no
						,b.status_rekening
						,b.saldo_memo
						,c.branch_name
						,d.cm_name 
						,e.trx_account_saving_id
				FROM 	mfi_cif a, mfi_account_saving b, mfi_branch c, mfi_cm d, mfi_trx_account_saving e
				WHERE 
						b.status_rekening=3
				AND c.branch_id = d.branch_id
				AND a.cm_code = d.cm_code
				AND a.cif_no=b.cif_no
				AND a.cif_type=0 
				AND e.account_saving_no=e.account_saving_no
				AND e.trx_status = 0
				";
			if($branch_id!='SEMUA')
			{
				$sql .= "AND c.branch_id = ? ";
				$param[] = $branch_id;
			}
			if($cm_name!='')
			{
				$sql .= "AND upper(d.cm_name) LIKE ? ";
				$param[] = "%".strtoupper($cm_name)."%";				
			}
			if($nama!='')
			{
				$sql .= "AND upper(a.nama) LIKE ? ";
				$param[] = "%".strtoupper($nama)."%";				
			}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	/**************************************************************************************************/
	//END PENCAIRAN TABUNGAN
	/**************************************************************************************************/

	public function update_mfi_trx_account_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}

	public function get_trx_saving_by_id($trx_id)
	{
		$sql = "select * from mfi_trx_account_saving where trx_account_saving_id = ?";
		$query = $this->db->query($sql,array($trx_id));
		return $query->row_array();
	}

	public function delete_trx_account_saving($param)
	{
		$this->db->delete('mfi_trx_account_saving',$param);
	}

	public function delete_trx_detail($param)
	{
		$this->db->delete('mfi_trx_detail',$param);
	}

	public function get_account_saving($account_saving_no)
	{
		$sql = "select * from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}

	/* FUNCTION EXECUTE */
	/**
	* fungsi untuk men-jurnal droping pembiayaan
	* created date 07-aug-2014
	* @author : sayyid
	*/
	public function fn_proses_jurnal_droping_pyd($account_financing_no)
	{
		$sql = "select fn_proses_jurnal_droping_pyd(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}
	public function fn_proses_jurnal_droping_pyd_v2($account_financing_no,$termin)
	{
		$sql = "select fn_proses_jurnal_droping_pyd(?,?)";
		$query = $this->db->query($sql,array($account_financing_no,$termin));
	}
	/**
	* fungsi untuk men-jurnal pelunasan pembiayaan
	* created date 11-aug-2014
	* @author : sayyid
	*/
	public function fn_proses_jurnal_pelunasan_pyd($account_financing_lunas_id)
	{
		$sql = "select fn_proses_jurnal_pelunasan_pyd(?)";
		$query = $this->db->query($sql,array($account_financing_lunas_id));
	}
	public function fn_proses_jurnal_pelunasan_pyd_koptel($account_financing_lunas_id,$account_cash_code)
	{
		$sql = "select fn_proses_jurnal_pelunasan_pyd_koptel(?,?)";
		$query = $this->db->query($sql,array($account_financing_lunas_id,$account_cash_code));
	}
	public function insert_account_financing_scoring($data)
	{
		$this->db->insert('mfi_account_financing_scoring',$data);
	}
	public function insert_account_financing_scoring_adm($data)
	{
		$this->db->insert_batch('mfi_account_financing_scoring_adm',$data);
	}
	public function update_account_financing_scoring($data,$param)
	{
		$this->db->update('mfi_account_financing_scoring',$data,$param);
	}

	/*****************************************************************************************/
	//TAMBAHAN Ade 11092014 Pas begadang
	/*****************************************************************************************/
	public function datatable_pengajuan_pembiayaan_verifikasiold($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							mfi_account_financing_reg.registration_no
							,mfi_cif.cif_no
							,mfi_cif.nama
							,mfi_resort.resort_code
							,mfi_resort.resort_name
							,mfi_account_financing_reg.amount
							,mfi_account_financing_reg.peruntukan
							,mfi_account_financing_reg.tanggal_pengajuan
							,mfi_account_financing_reg.account_financing_reg_id
							,mfi_account_financing_reg.status
							,mfi_account_financing_reg.rencana_droping
							,mfi_product_financing.flag_scoring
							,coalesce((select count(*) from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as scoring_exist
							,coalesce((select total_skor from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as total_skor
							,(SELECT
									mfi_list_code_detail.display_text
								FROM
									mfi_list_code_detail
								WHERE mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.code_value AS integer )
									  AND code_group = 'peruntukan'
							 ) AS display_peruntukan
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				LEFT JOIN mfi_account_financing_scoring ON mfi_account_financing_reg.registration_no=mfi_account_financing_scoring.registration_no
				JOIN mfi_product_financing_approval ON mfi_product_financing.product_code = mfi_product_financing_approval.product_code
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing_reg.resort_code

				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing_reg.status = '0' 
						AND mfi_account_financing_reg.registration_no = (case 
							when mfi_product_financing.flag_scoring = '0' 
							then mfi_account_financing_reg.registration_no
							else mfi_account_financing_scoring.registration_no
						end) AND 
					  mfi_account_financing_reg.amount BETWEEN mfi_product_financing_approval.nominal_min AND
					  mfi_product_financing_approval.nominal_max AND
					  mfi_product_financing_approval.kode_jabatan='".$this->session->userdata('kode_jabatan')."'";

			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		} else {
			$sql .= " WHERE mfi_account_financing_reg.status = '0' 
						AND mfi_account_financing_reg.registration_no = (case 
							when mfi_product_financing.flag_scoring = '0' 
							then mfi_account_financing_reg.registration_no
							else mfi_account_financing_scoring.registration_no
						end) AND 
					  mfi_account_financing_reg.amount BETWEEN mfi_product_financing_approval.nominal_min AND
					  mfi_product_financing_approval.nominal_max AND
					  mfi_product_financing_approval.kode_jabatan='".$this->session->userdata('kode_jabatan')."'";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	/*****************************************************************************************/
	//END TAMBAHAN Ade 11092014 Pas begadang
	/*****************************************************************************************/

	/**
	* NEW INSERT FINANCING DROPING
	* @author sayyid nurkilah
	*/

	public function insert_account_financing_droping($data_financing_droping)
	{
		$this->db->insert('mfi_account_financing_droping',$data_financing_droping);
	}

	public function get_financing_reg_by_id($account_financing_reg_id)
	{
		$sql = "select * from mfi_account_financing_reg where account_financing_reg_id=?";
		$query=$this->db->query($sql,array($account_financing_reg_id));
		$row=$query->row_array();
		return $row;
	}

	public function get_scoring_id_by_registration_no($registration_no)
	{
		$sql = "select * from mfi_account_financing_scoring where registration_no=?";
		$query = $this->db->query($sql,array($registration_no));
		return $query->row_array();
	}

	public function update_data_financing_for_akad($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	/*********************************************************************************/
	//CETAK HASIL SCORING	
	public function search_cif_for_cetak_hasil_scoring($keyword)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT   c.nama
						,a.account_financing_reg_id
						,a.registration_no
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_account_financing_scoring b ON a.registration_no=b.registration_no
				INNER JOIN mfi_cif c ON a.cif_no=c.cif_no
				where (upper(c.nama) like ? or a.registration_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->result_array();
	}	

	public function get_cif_by_account_financing_reg_scoring($account_financing_reg_id)
	{
		$sql = "SELECT   c.branch_code
						,c.nama
						,a.account_financing_reg_id
						,a.amount
						,a.description 
						,a.registration_no
						,a.tanggal_pengajuan
						,a.status
						,b.account_financing_scoring_id
						,b.total_skor
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_account_financing_scoring b ON a.registration_no=b.registration_no
				INNER JOIN mfi_cif c ON a.cif_no=c.cif_no 
				WHERE a.account_financing_reg_id=? ";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}
	//END CETAK HASIL SCORING
	/*********************************************************************************/

	public function search_account_financing_no($keyword,$status_rekening=false)
	{
		/* definition */
		$param = array();

		$sql = "SELECT
				a.account_financing_no,
				a.tanggal_akad,
				a.tanggal_mulai_angsur,
				a.tanggal_jtempo,
				a.pokok,
				a.margin,
				a.jangka_waktu,
				a.periode_jangka_waktu,
				a.angsuran_pokok,
				a.angsuran_margin,
				b.nama,
				a.uang_muka,
				a.titipan_notaris,
				a.angsuran_catab,
				a.simpanan_wajib_pinjam,
				a.biaya_administrasi,
				a.biaya_jasa_layanan,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.biaya_asuransi_jaminan,
				a.jenis_jaminan,
				a.keterangan_jaminan,
				a.jumlah_jaminan,
				a.nominal_taksasi,
				a.presentase_jaminan,
				a.jenis_jaminan_sekunder,
				a.keterangan_jaminan_sekunder,
				a.jumlah_jaminan_sekunder,
				a.nominal_taksasi_sekunder,
				a.presentase_jaminan_sekunder,
				a.sektor_ekonomi,
				a.peruntukan,
				a.flag_wakalah,
				a.fa_code,
				a.resort_code,
				(case when (select count(*) from mfi_trx_account_financing where account_financing_no=a.account_financing_no and trx_financing_type=1) > 0 
				then 0 else 1 end) as is_avaible_to_correct,
				c.product_name,
				a.registration_no,
				d.description
				FROM mfi_account_financing a
				LEFT JOIN mfi_cif b ON b.cif_no = a.cif_no
				LEFT JOIN mfi_product_financing c ON c.product_code = a.product_code
				LEFT JOIN mfi_account_financing_reg d ON d.registration_no = a.registration_no
				WHERE (UPPER(a.account_financing_no) like ? OR UPPER(b.nama) like ?)
		";
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		if($status_rekening!=false){
			$sql .= "AND a.status_rekening = ?";
			$param[] = $status_rekening;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}


	/*
	| model for update histori transaksi pembiayaan
	| by : sayyid
	*/
	public function update_trx_account_financing($data,$param)
	{
		$this->db->update('mfi_trx_account_financing',$data,$param);
	}
	/*
	| model for update history transaksi detail
	| by : sayyid
	*/
	public function update_trx_detail($data,$param)
	{
		$this->db->update('mfi_trx_detail',$data,$param);
	}
	/*
	| model for insert log koreksi droping
	| by : sayyid
	*/
	public function insert_log_koreksi_droping($data)
	{
		$this->db->insert('mfi_log_koreksi_droping',$data);
	}

	/*****************************************************************/
	//VERIFIKASI KOREKSI DROPING
	public function datatable_koreksi_droping($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT 
						 a.log_id
						,c.nama
						,a.account_financing_no
						,a.tanggal_koreksi 
						,d.fullname
				FROM 
						mfi_log_koreksi_droping a
				INNER JOIN mfi_account_financing b ON a.account_financing_no=b.account_financing_no
				INNER JOIN mfi_cif c ON c.cif_no=b.cif_no
				INNER JOIN mfi_user d ON d.user_id=a.user_id
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND a.status=0 ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			$sql .= "WHERE a.status=0 ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}
	function get_koreksi_by_log_id($log_id='')
	{
		$sql = "SELECT c.nama,b.periode_jangka_waktu, d.product_name, a.* FROM mfi_log_koreksi_droping a 
				INNER JOIN mfi_account_financing b ON a.account_financing_no=b.account_financing_no
				INNER JOIN mfi_cif c ON c.cif_no=b.cif_no
				INNER JOIN mfi_product_financing d ON b.product_code=d.product_code
				WHERE a.log_id = ? ";
		$query = $this->db->query($sql,array($log_id));
		return $query->row_array();
	}
	public function update_status_koreksi_droping($data,$param)
	{
		$this->db->update('mfi_log_koreksi_droping',$data,$param);
	}
	//END VERIFIKASI KOREKSI DROPING
	/*****************************************************************/

	function get_registration_no_by_account_financing_no($account_financing_no)
	{
		$sql = "select registration_no from mfi_account_financing where account_financing_no=?";
		$query=$this->db->query($sql,array($account_financing_no));
		$row=$query->row_array();
		return (isset($row['registration_no'])==true)?$row['registration_no']:'';
	}

	function update_account_financing_reg($data,$param)
	{
		$this->db->update('mfi_account_financing_reg',$data,$param);
	}

	function get_account_saving_by_account_financing_no($account_financing_no)
	{
		$sql = "select 
				b.account_saving_no,
				b.saldo_memo,
				b.saldo_riil
				from mfi_account_financing a, mfi_account_saving b 
				where a.account_saving_no=b.account_saving_no and 
				a.account_financing_no=?
				";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();

		if(isset($row['account_saving_no'])==true){
			$account_saving_no=$row['account_saving_no'];
		}else{
			$account_saving_no=false;
		}

		return $account_saving_no;
	}

	function update_account_saving($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	function get_saldo_catab_by_account_financing_no($account_financing_no)
	{
		$sql = "select saldo_catab from mfi_account_financing where account_financing_no=?";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['saldo_catab'];
	}

	function get_saldo_memo_by_account_financing_no($account_financing_no)
	{
		$sql = "select b.saldo_memo from mfi_account_financing a,mfi_account_saving b 
				where a.account_saving_no=b.account_saving_no 
	
				and account_financing_no=?
				";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['saldo_memo'];
	}

	function cek_angsuran($account_financing_no)
	{
		$sql = "select count(*) num from mfi_trx_account_financing where account_financing_no=? and trx_financing_type=1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['num'];
	}
	function datatable_update_data_pembiayaan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				  a.account_financing_id,
				  a.account_financing_no,
				  b.cif_no,
				  b.nama,
				  c.fa_name,
				  d.resort_name
				FROM mfi_account_financing a, mfi_cif b, mfi_fa c, mfi_resort d ";

		if ( $sWhere != "" ) {
			$sql .= "$sWhere AND a.cif_no=b.cif_no AND a.fa_code=c.fa_code AND a.resort_code=d.resort_code AND a.status_rekening=1  ";
		} else {
			$sql .= "WHERE a.cif_no=b.cif_no AND a.fa_code=c.fa_code AND a.resort_code=d.resort_code AND a.status_rekening=1 ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_akun_saving_for_update_data_pembiayaan($account_financing_id='')
	{
		$param = array();
		$sql = "SELECT 
						a.account_saving_no
				FROM mfi_account_saving a, mfi_account_financing b
				WHERE a.cif_no=b.cif_no AND b.account_financing_id=? ";

		$param[]=$account_financing_id;
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_data_for_update_data_pembiayaan($account_financing_id='')
	{
		$param = array();
		$sql = "SELECT 
						b.cif_no
						,b.nama
						,b.panggilan
						,b.ibu_kandung
						,b.tmp_lahir
						,b.tgl_lahir
						,b.usia
						,a.fa_code
						,a.resort_code
						,a.account_saving_no
						,a.jenis_jaminan
						,a.keterangan_jaminan
						,a.jumlah_jaminan
						,a.nominal_taksasi
						,a.presentase_jaminan
						,a.jenis_jaminan_sekunder
						,a.keterangan_jaminan_sekunder
						,a.jumlah_jaminan_sekunder
						,a.nominal_taksasi_sekunder
						,a.presentase_jaminan_sekunder
						,a.sektor_ekonomi
						,a.peruntukan
						,a.flag_wakalah
				FROM mfi_account_financing a, mfi_cif b
				WHERE a.account_financing_id=?
				AND a.cif_no=b.cif_no ";
		$param[]=$account_financing_id;
		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}

	public function action_update_data_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	public function get_product_code_on_list_code_detail()
	{
		$sql = "select code_value as product_code from mfi_list_code_detail where code_group='simpananwajibpinjam'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(isset($row['product_code'])){
			return $row['product_code'];
		}else{
			return '';
		}
	}

	function cek_exist_data_on_account_saving($cif_no)
	{
		$sql = "select count(*) num from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();

		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	public function get_saldo_sebelumnya_from_account_saving($cif_no)
	{
		$sql = "select saldo_riil, saldo_memo,saldo_hold from mfi_account_saving where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}

	public function insert_mfi_account_saving($data)
	{
		$this->db->insert('mfi_account_saving',$data);
	}

	// public function insert_mfi_trx_account_saving($data)
	// {
	// 	$this->db->insert('mfi_trx_account_saving',$data);
	// }

	public function insert_mfi_trx_account_saving_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	public function update_mfi_account_saving($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	/* GET ACCOUNT FINANCING */
	function get_account_financing($account_financing_no)
	{
		$sql = "select 
				b.nama,c.product_name,d.saldo_memo,a.*
				from mfi_account_financing a, mfi_cif b, mfi_product_financing c, mfi_account_saving d
				where a.cif_no = b.cif_no and a.product_code=c.product_code and a.account_saving_no=d.account_saving_no
				and a.account_financing_no = ?
		";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row;
	}

	/*
	*koptel
	*/
	public function get_pyd_ke_koptel($nik)
	{
		$sql = "SELECT count(*) AS jumlah from mfi_account_financing WHERE cif_no = ? ";
		$query = $this->db->query($sql,array($nik));

		return $query->row_array();
	}
	public function cek_nik_from_mfi_cif($nik)
	{
		$sql = "SELECT cif_id from mfi_cif WHERE cif_no = ? ";
		$query = $this->db->query($sql,array($nik));

		return $query->row_array();
	}

	public function update_cif($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}

	public function insert_cif($data)
	{
		$this->db->insert('mfi_cif',$data);
	}

	public function datatable_pengajuan_pembiayaan_koptel($sWhere='',$sOrder='',$sLimit='',$src_product='')
	{

		$sql = "SELECT a.account_financing_reg_id
				,a.registration_no
				,a.amount
				,a.tanggal_pengajuan
				,a.created_date
				,a.pengajuan_melalui
				,b.nama_pegawai
				,b.nik
				,c.product_name
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_pegawai b ON b.nik=a.cif_no
				INNER JOIN mfi_product_financing c ON c.product_code=a.product_code ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND a.status = '0'";
		}else{
			$sql .= "WHERE a.status = '0'";
		}

		if($src_product!=''){
			$sql .= " AND c.product_code = '$src_product' ";			
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_approval_pengajuan_pembiayaan($sWhere='',$sOrder='',$sLimit='',$src_product='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							mfi_account_financing_reg.registration_no
							,mfi_cif.cif_no
							,mfi_cif.nama
							,mfi_account_financing_reg.amount
							,mfi_account_financing_reg.peruntukan
							,mfi_account_financing_reg.tanggal_pengajuan
							,mfi_account_financing_reg.account_financing_reg_id
							,mfi_account_financing_reg.status
							,mfi_account_financing_reg.rencana_droping
							,mfi_account_financing_reg.jangka_waktu
							,mfi_product_financing.flag_scoring
							,mfi_product_financing.rate_margin2
							,mfi_product_financing.product_name
							,mfi_account_financing_reg.pengajuan_melalui
							,mfi_account_financing_reg.kopegtel_code
							,mfi_account_financing_reg.product_code
							,(SELECT
									mfi_list_code_detail.display_text
								FROM
									mfi_list_code_detail
								WHERE mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort AS integer )
									  AND code_group = 'peruntukan'
							 ) AS display_peruntukan
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				LEFT JOIN mfi_account_financing_scoring ON mfi_account_financing_reg.registration_no=mfi_account_financing_scoring.registration_no
				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing_reg.status = '0' AND mfi_account_financing_reg.status_asuransi='1' AND mfi_account_financing_reg.status_dokumen_lengkap='1' ";
		} else {
			$sql .= " WHERE mfi_account_financing_reg.status = '0' AND mfi_account_financing_reg.status_asuransi='1' AND mfi_account_financing_reg.status_dokumen_lengkap='1' ";
		}

		if($src_product!=''){
			$sql .= " AND mfi_account_financing_reg.product_code = '$src_product' ";			
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function select_financing_reg_by_id($id='')
	{

		$sql = "SELECT 
					 a.*
					,b.branch_code
					,c.akad_code 
				FROM 
					 mfi_account_financing_reg a, mfi_cif b, mfi_product_financing c 
				WHERE 
					a.cif_no=b.cif_no 
					AND a.product_code=c.product_code
					AND a.account_financing_reg_id=? ";

		$query = $this->db->query($sql,array($id));

		return $query->row_array();
	}public function datatable_pencairan_pembiayaan($sWhere='',$sOrder='',$sLimit='',$product_code='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.flag_dokumen,
				mfi_account_financing_droping.status_droping,
				mfi_account_financing_reg.jumlah_kewajiban as kewajiban_koptel,
				mfi_account_financing_reg.jumlah_angsuran as kewajiban_kopegtel,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.product_code,
				mfi_cif.cif_no,
				mfi_cif.nama,
				'1' termin,'0' status,
				0 as banmod
				FROM
				mfi_account_financing
				LEFT JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='produkbanmod' and mfi_list_code_detail.code_value<>mfi_product_financing.product_code
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing.status_rekening='0' AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			// if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			// 	$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			// }
			if($product_code!=''){	
				$sql .=" AND mfi_account_financing.product_code=? ";
				$param[] = $product_code;		
			}
		}else{
			$sql .= "WHERE mfi_account_financing.status_rekening='0' AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			// if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			// 	$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			// }
			if($product_code!=''){	
				$sql .=" AND mfi_account_financing.product_code=? ";
				$param[] = $product_code;		
			}
		}


		$sql .= " UNION ALL ";

		$sql .= "SELECT
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing_reg_termin.nominal as pokok,
				mfi_account_financing.flag_dokumen,
				mfi_account_financing_droping.status_droping,
				mfi_account_financing_reg.jumlah_kewajiban as kewajiban_koptel,
				mfi_account_financing_reg.jumlah_angsuran as kewajiban_kopegtel,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.product_code,
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_financing_reg_termin.termin,
				mfi_account_financing_reg_termin.status,
				1 as banmod
				FROM
				mfi_account_financing
				LEFT JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.registration_no=mfi_account_financing.registration_no
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='produkbanmod' and mfi_list_code_detail.code_value=mfi_product_financing.product_code
				LEFT JOIN mfi_account_financing_reg_termin ON mfi_account_financing_reg_termin.account_financing_reg_id=mfi_account_financing_reg.account_financing_reg_id AND mfi_account_financing_reg_termin.status=0
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing.status_rekening in('0','1') AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			// if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			// 	$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			// }
			if($product_code!=''){	
				$sql .=" AND mfi_account_financing.product_code=? ";
				$param[] = $product_code;		
			}
		}else{
			$sql .= "WHERE mfi_account_financing.status_rekening in('0','1') AND mfi_product_financing.jenis_pembiayaan = '0'"; // PEMBIAYAAN INDIVIDU
			// if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			// 	$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			// }
			if($product_code!=''){	
				$sql .=" AND mfi_account_financing.product_code=? ";
				$param[] = $product_code;		
			}
		}

		$sql .= " AND (SELECT count(*) FROM mfi_account_financing_reg_termin x WHERE x.account_financing_reg_id=mfi_account_financing_reg.account_financing_reg_id AND x.status=0)>0";

		if ( $sOrder != "" )
			$sql .= " order by account_financing_no,termin ";

		if ( $sLimit != "" )
			$sql .= " $sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_account_saving_by_cif($nik)
	{
		$sql = "SELECT account_saving_no from mfi_account_saving WHERE cif_no = ? ";
		$query = $this->db->query($sql,array($nik));

		return $query->row_array();
	}

	public function datatable_registrasi_akad($sWhere='',$sOrder='',$sLimit='',$product_code='all')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							mfi_account_financing_reg.registration_no
							,mfi_cif.cif_no
							,mfi_cif.nama
							,mfi_account_financing_reg.amount
							,mfi_account_financing_reg.peruntukan
							,mfi_account_financing_reg.tanggal_pengajuan
							,mfi_account_financing_reg.account_financing_reg_id
							,mfi_account_financing_reg.status
							,mfi_account_financing_reg.jangka_waktu
							,mfi_account_financing_reg.approve_date
							,mfi_account_financing_reg.product_code
							,mfi_product_financing.flag_scoring
							,mfi_product_financing.product_name
							,mfi_account_financing.status_rekening
							,mfi_account_financing.account_financing_no
							,(case when mfi_account_financing_reg.pengajuan_melalui = 'koptel' then 
								'Koptel'
							else
								(SELECT
								mfi_kopegtel.nama_kopegtel
								FROM
								mfi_kopegtel
								WHERE mfi_kopegtel.kopegtel_code = mfi_account_financing_reg.kopegtel_code) 
							end) as pengajuan_melalui
							,(select count(*) from mfi_account_financing ex where ex.registration_no=mfi_account_financing_reg.registration_no) as financing_is_exist
							,mfi_list_code_detail.display_text as display_peruntukan
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				LEFT JOIN mfi_account_financing_scoring ON mfi_account_financing_reg.registration_no=mfi_account_financing_scoring.registration_no
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='peruntukan' AND mfi_list_code_detail.display_sort::integer = mfi_account_financing_reg.peruntukan
				LEFT JOIN mfi_account_financing on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no			

				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing_reg.status = 1  AND (case when mfi_account_financing.status_rekening is null then 0 else mfi_account_financing.status_rekening end) not in(1,2,3,4)";
		} else {
			$sql .= " WHERE mfi_account_financing_reg.status = 1  AND (case when mfi_account_financing.status_rekening is null then 0 else mfi_account_financing.status_rekening end) not in(1,2,3,4)";
		}

		if ($product_code!="all") {
			$sql .= " AND mfi_product_financing.product_code='".$product_code."'";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_data_for_akad_by_account_financing_reg_id($account_financing_reg_id)
	{
		$s = "select b.cif_flag from mfi_account_financing_reg a,mfi_cif b
			  where a.cif_no=b.cif_no AND a.account_financing_reg_id=?";
		$q = $this->db->query($s,array($account_financing_reg_id));
		$r = $q->row_array();

		if ($r['cif_flag']==1) { //by kopegtel
			$sql = "SELECT a.*
					  ,b.cif_flag
					  ,b.nama
					  ,b.cif_type
					  ,b.alamat
					  ,b.telpon_seluler
					  ,b.no_ktp
					  ,b.nama_pasangan
					  ,b.pekerjaan_pasangan
					  ,b.jumlah_tanggungan
					  ,b.status_rumah
					  ,b.tgl_lahir
					  ,b.usia
					  ,b.alamat_lokasi_kerja
					  ,b.cif_no as nik
					  ,b.nama as nama_pegawai
					  ,'-' as band
					  ,'-' as posisi
					  ,b.alamat as loker
					  ,'-' as tempat_lahir
					  ,NULL as tgl_lahir
					  ,'-' as thp
					  ,b.nama as koptel
					  ,NULL as tgl_pensiun_normal
					  ,'-' as gender
					  ,c.rate_margin1
					  ,c.rate_margin2
					  ,c.jenis_margin
					  ,d.akad_name
					  ,d.jenis_keuntungan
					  ,a.amount_proyeksi_keuntungan
				FROM mfi_account_financing_reg a
				LEFT JOIN mfi_cif b ON a.cif_no=b.cif_no
				LEFT JOIN mfi_product_financing c ON a.product_code=c.product_code
				LEFT JOIN mfi_akad d ON d.akad_code=a.akad_code
				WHERE a.account_financing_reg_id=?
			";
			$query = $this->db->query($sql,array($account_financing_reg_id));
			return $query->row_array();	
		} else {
			$sql = "SELECT
						mfi_account_financing_reg.*
						,mfi_cif.cif_flag
						,mfi_cif.nama
						,mfi_cif.cif_type
						,mfi_cif.alamat
						,mfi_cif.telpon_seluler
						,mfi_cif.no_ktp
						,mfi_cif.nama_pasangan
						,mfi_cif.pekerjaan_pasangan
						,mfi_cif.jumlah_tanggungan
						,mfi_cif.status_rumah
						,mfi_cif.tgl_lahir
						,mfi_cif.usia
						,mfi_cif.alamat_lokasi_kerja
						,mfi_pegawai.nik
						,mfi_pegawai.nama_pegawai
						,mfi_pegawai.band
						,mfi_pegawai.posisi
						,mfi_pegawai.loker
						,mfi_pegawai.tempat_lahir
						,mfi_pegawai.tgl_lahir
						,mfi_pegawai.thp
						,mfi_pegawai.koptel
						,mfi_pegawai.tgl_pensiun_normal
						,mfi_pegawai.gender
						,fn_get_rate_margin(mfi_product_financing.product_code,mfi_pegawai.band,'min') rate_margin1
						,fn_get_rate_margin(mfi_product_financing.product_code,mfi_pegawai.band,'max') rate_margin2
						,mfi_product_financing.jenis_margin
						,mfi_jaminan.tipe_developer
						,mfi_jaminan.nama_penjual_individu
						,mfi_jaminan.nomer_ktp
						,mfi_jaminan.nama_pasangan_developer
						,mfi_jaminan.nama_perusahaan
						,mfi_account_financing_reg.amount_proyeksi_keuntungan
					FROM 
						mfi_account_financing_reg
					INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_pegawai ON mfi_account_financing_reg.cif_no = mfi_pegawai.nik
					INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
					LEFT JOIN mfi_jaminan ON mfi_jaminan.registration_no=mfi_account_financing_reg.registration_no
					WHERE mfi_account_financing_reg.account_financing_reg_id=? ";

			$query = $this->db->query($sql,array($account_financing_reg_id));

			return $query->row_array();	
		}
		
	}

	public function get_data_for_akad_by_account_financing_no($account_financing_no)
	{

		$s = "SELECT b.cif_flag from mfi_account_financing_reg a,mfi_cif b,mfi_account_financing c
			  WHERE a.cif_no=b.cif_no AND c.registration_no=a.registration_no
			  AND c.account_financing_no=?";
		$q = $this->db->query($s,array($account_financing_no));
		$r = $q->row_array();

		if ($r['cif_flag']==1) { //by kopegtel
			$sql = "SELECT
					   a.account_financing_reg_id
					  ,a.registration_no
					  ,a.cif_no
					  ,a.amount
					  ,a.peruntukan
					  ,a.tanggal_pengajuan
					  ,a.product_code
					  ,a.jumlah_kewajiban
					  ,a.jumlah_angsuran
					  ,a.jangka_waktu
					  ,a.pengajuan_melalui
					  ,a.kopegtel_code
					  ,a.nama_bank
					  ,a.no_rekening
					  ,a.atasnama_rekening
					  ,a.bank_cabang
					  ,a.lunasi_ke_kopegtel
					  ,a.saldo_kewajiban
					  ,a.lunasi_ke_koptel
					  ,a.saldo_kewajiban_ke_koptel
					  ,a.pelunasan_ke_kopeg_mana
					  ,a.nisbah
					  ,a.amount_disetujui
					  ,b.cif_flag
					  ,b.nama
					  ,b.cif_type
					  ,b.alamat
					  ,b.telpon_seluler
					  ,b.no_ktp
					  ,b.nama_pasangan
					  ,b.pekerjaan_pasangan
					  ,b.jumlah_tanggungan
					  ,b.status_rumah
					  ,b.tgl_lahir
					  ,b.usia
					  ,b.alamat_lokasi_kerja
					  ,b.cif_no as nik
					  ,b.nama as nama_pegawai
					  ,b.status_rumah
					  ,'-' as band
					  ,'-' as posisi
					  ,b.alamat as loker
					  ,'-' as tempat_lahir
					  ,NULL as tgl_lahir
					  ,'-' as thp
					  ,b.nama as koptel
					  ,NULL as tgl_pensiun_normal
					  ,'-' as gender
					  ,c.rate_margin1
					  ,c.rate_margin2
					  ,c.jenis_margin
					  ,d.akad_code
					  ,d.akad_name
					  ,d.jenis_keuntungan
					  ,e.account_financing_no
					  ,e.margin
					  ,e.account_financing_id
					  ,e.angsuran_pokok
					  ,e.angsuran_margin
					  ,e.biaya_administrasi
					  ,e.biaya_asuransi_jiwa
					  ,e.biaya_notaris
					  ,e.tanggal_akad
					  ,e.tanggal_mulai_angsur
					  ,e.tanggal_jtempo
					  ,e.flag_jadwal_angsuran
					  ,a.amount_proyeksi_keuntungan
				FROM mfi_account_financing_reg a
				LEFT JOIN mfi_cif b ON a.cif_no=b.cif_no
				LEFT JOIN mfi_product_financing c ON a.product_code=c.product_code
				LEFT JOIN mfi_account_financing e ON e.registration_no=a.registration_no
				LEFT JOIN mfi_akad d ON d.akad_code=e.akad_code
				WHERE e.account_financing_no=?
			";
			$query = $this->db->query($sql,array($account_financing_no));
			return $query->row_array();	
		} else {
			$sql = "SELECT
						 mfi_account_financing_reg.account_financing_reg_id
						,mfi_account_financing_reg.registration_no
						,mfi_account_financing_reg.cif_no
						,mfi_account_financing_reg.amount
						,mfi_account_financing_reg.peruntukan
						,mfi_account_financing_reg.tanggal_pengajuan
						,mfi_account_financing_reg.product_code
						,mfi_account_financing_reg.jumlah_kewajiban
						,mfi_account_financing_reg.jumlah_angsuran
						,mfi_account_financing_reg.jangka_waktu
						,mfi_account_financing_reg.pengajuan_melalui
						,mfi_account_financing_reg.kopegtel_code
						,mfi_account_financing_reg.nama_bank
						,mfi_account_financing_reg.no_rekening
						,mfi_account_financing_reg.atasnama_rekening
						,mfi_account_financing_reg.bank_cabang
						,mfi_account_financing_reg.lunasi_ke_kopegtel
						,mfi_account_financing_reg.saldo_kewajiban
						,mfi_account_financing_reg.lunasi_ke_koptel
						,mfi_account_financing_reg.saldo_kewajiban_ke_koptel
						,mfi_account_financing_reg.pelunasan_ke_kopeg_mana
						,mfi_account_financing_reg.nisbah
					  	,mfi_account_financing_reg.amount_disetujui
					  	,mfi_account_financing_reg.amount_proyeksi_keuntungan
						,mfi_cif.cif_flag
						,mfi_cif.nama
						,mfi_cif.cif_type
						,mfi_cif.alamat
						,mfi_cif.telpon_seluler
						,mfi_cif.no_ktp
						,mfi_cif.nama_pasangan
						,mfi_cif.pekerjaan_pasangan
						,mfi_cif.jumlah_tanggungan
						,mfi_cif.status_rumah
						,mfi_cif.alamat_lokasi_kerja
						,mfi_pegawai.nik
						,mfi_pegawai.nama_pegawai
						,mfi_pegawai.band
						,mfi_pegawai.posisi
						,mfi_pegawai.loker
						,mfi_pegawai.tempat_lahir
						,mfi_pegawai.tgl_lahir
						,mfi_pegawai.thp
						,mfi_pegawai.koptel
						,mfi_pegawai.tgl_pensiun_normal
						,mfi_pegawai.gender
						,fn_get_rate_margin(mfi_product_financing.product_code,mfi_pegawai.band,'min') rate_margin1
						,fn_get_rate_margin(mfi_product_financing.product_code,mfi_pegawai.band,'max') rate_margin2
						,mfi_product_financing.jenis_margin
						,mfi_account_financing.account_financing_no
						,mfi_account_financing.margin
						,mfi_account_financing.account_financing_id
						,mfi_account_financing.angsuran_pokok
						,mfi_account_financing.angsuran_margin
						,mfi_account_financing.biaya_administrasi
						,mfi_account_financing.biaya_asuransi_jiwa
						,mfi_account_financing.biaya_notaris
						,mfi_account_financing.tanggal_akad
						,mfi_account_financing.tanggal_mulai_angsur
						,mfi_account_financing.tanggal_jtempo
						,mfi_account_financing.flag_jadwal_angsuran
						,mfi_jaminan.tipe_developer
						,mfi_jaminan.nama_penjual_individu
						,mfi_jaminan.nomer_ktp
						,mfi_jaminan.nama_pasangan_developer
						,mfi_jaminan.nama_perusahaan
						,mfi_akad.akad_code
						,mfi_akad.akad_name

					FROM mfi_account_financing_reg
					INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_pegawai ON mfi_account_financing_reg.cif_no = mfi_pegawai.nik
					INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
					INNER JOIN mfi_account_financing ON mfi_account_financing.registration_no=mfi_account_financing_reg.registration_no
					LEFT JOIN mfi_jaminan ON mfi_jaminan.registration_no=mfi_account_financing_reg.registration_no
					LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_product_financing.akad_code
					WHERE mfi_account_financing.account_financing_no=? ";

			$query = $this->db->query($sql,array($account_financing_no));
		
		}

		return $query->row_array();
	}

	function select_product_saving_code_koptel()
	{
		$sql = "SELECT code_value FROM mfi_list_code_detail WHERE code_group='TabunganPembiayaan' ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data['code_value'];
	}

	public function delete_data_financing_from_financing_reg($param)
	{
		$this->db->delete('mfi_account_financing',$param);
	}	

	public function delete_data_financing_from_financing($param)
	{
		$this->db->delete('mfi_account_financing_reg',$param);
	}

	public function get_saldo_sebelumnya_from_account_saving_koptel($account_saving_no)
	{
		$sql = "select saldo_riil, saldo_memo,saldo_hold from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));
		return $query->row_array();
	}

	public function get_cif_by_account_financing_reg($registration_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
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
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_account_financing_reg.amount pokok,
				mfi_akad.akad_name,
				mfi_akad.akad_code,
				mfi_product_financing.product_name,
				mfi_product_financing.product_code
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_product_financing.akad_code
				WHERE mfi_account_financing_reg.registration_no = ?";
		$query = $this->db->query($sql,array($registration_no));

		return $query->row_array();
	}
	public function datatable_registrasi_transfer_pencairan($sWhere='',$sOrder='',$sLimit='')
	{
		echo $sWhere;die();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT a.account_financing_no,b.droping_date,c.nama,a.pokok,c.cif_no
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c
				WHERE a.account_financing_no=b.account_financing_no 
				AND a.cif_no=c.cif_no AND b.status_transfer='0' 
				AND a.status_rekening='1' AND b.status_droping='1'
		";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	public function cek_flag_thp100($nik)
	{
		$sql = "SELECT nik from mfi_spesial_rate WHERE nik = ? AND status=1 ";
		$query = $this->db->query($sql,array($nik));

		return $query->row_array();
	}
	function get_data_registrasi_transfer_pencairan($account_financing_no)
	{
		$sql = "SELECT
					a.cif_no
					,(a.angsuran_pokok+a.angsuran_margin) angsuran_pertama
					,c.nama
					,c.telpon_seluler
					,a.account_financing_no
					,a.biaya_administrasi
					,a.biaya_notaris
					,a.biaya_asuransi_jiwa
					,d.nama_bank
					,d.bank_cabang
					,d.no_rekening
					,d.atasnama_rekening
					,b.tanggal_transfer
					,a.pokok
					,d.saldo_kewajiban_ke_koptel as kewajiban_koptel
					,d.saldo_kewajiban as kewajiban_kopegtel
				from mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d
				where a.account_financing_no=b.account_financing_no and a.cif_no=c.cif_no and a.registration_no=d.registration_no
				and a.account_financing_no=?
				";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function do_registrasi_transfer_pencairan($data,$param)
	{
		$this->db->update('mfi_account_financing_droping',$data,$param);
	}
	
	function get_no_spb_by_tgl($tanggal_spb)
	{
		$sql = "SELECT a.no_spb from mfi_spb a 
				inner join mfi_spb_detail b on a.no_spb=b.no_spb
				where b.account_financing_no IS NOT NULL AND  a.tanggal_spb=? group by a.no_spb ";
		$query = $this->db->query($sql,array($tanggal_spb));
		return $query->result_array();
	}
	
	function get_data_cetak_transfer_pencairan($no_spb)
	{
		$sql = "SELECT
					h.tanggal_spb,
					d.cif_no,
					d.nama,
					e.product_name as jenis_pembiayaan,
					c.nama_bank,
					c.bank_cabang,
					c.no_rekening,
					c.atasnama_rekening,
					b.pokok,
					b.angsuran_pokok,
					b.angsuran_margin,
					b.biaya_asuransi_jiwa,
					b.biaya_administrasi,
					b.biaya_notaris,
					c.jumlah_kewajiban as kewajiban_koptel,
					c.jumlah_angsuran as kewajiban_kopegtel,
					c.saldo_kewajiban as outstanding_kopegtel,
					c.saldo_kewajiban_ke_koptel as outstanding_koptel,
					c.premi_asuransi as premi_asuransi,
					c.premi_asuransi_tambahan as premi_asuransi_tambahan,
					f.nama_kopegtel,
					(case when e.product_code='58' then 0 else (b.angsuran_pokok+b.angsuran_margin) end) as angsuran_pertama
				from mfi_account_financing_droping a
				join mfi_account_financing b on a.account_financing_no=b.account_financing_no
				join mfi_account_financing_reg c on b.registration_no=c.registration_no
				join mfi_cif d on d.cif_no=b.cif_no
				join mfi_product_financing e on e.product_code=b.product_code
				left join mfi_kopegtel f on c.kopegtel_code=f.kopegtel_code
				INNER JOIN mfi_spb h ON a.no_spb=h.no_spb
				where a.no_spb = ?
				order by f.nama_kopegtel asc
			";
		$query = $this->db->query($sql,array($no_spb));
		// $query = $this->db->query($sql);

		return $query->result_array();
	}
	
	function get_data_cetak_transfer_pencairan_kopegtel($tanggal_transfer)
	{
		$sql = "select 
				d.nama_kopegtel
				,d.nama_bank
				,d.nomor_rekening
				,d.kopegtel_code
				from mfi_account_financing_droping a
				join mfi_account_financing b on a.account_financing_no=b.account_financing_no
				join mfi_account_financing_reg c on b.registration_no=c.registration_no
				left join mfi_kopegtel d on c.pelunasan_ke_kopeg_mana=d.kopegtel_code
				WHERE c.jumlah_angsuran>0 and a.tanggal_transfer = ?
				group by 1,2,3,4
				order by 1
			";
		$query = $this->db->query($sql,array($tanggal_transfer));
		// $query = $this->db->query($sql);

		return $query->result_array();
	}
	
	function get_data_cetak_transfer_pencairan_kopegtel2($no_spb)
	{
		$sql = "SELECT 
				d.nama_kopegtel
				,d.nama_bank
				,d.nomor_rekening
				,d.kopegtel_code
				from mfi_account_financing_droping a
				join mfi_account_financing b on a.account_financing_no=b.account_financing_no
				join mfi_account_financing_reg c on b.registration_no=c.registration_no
				left join mfi_kopegtel d on c.pelunasan_ke_kopeg_mana=d.kopegtel_code
				WHERE c.jumlah_angsuran>0 and a.no_spb = ?
				group by 1,2,3,4
				order by 1
			";
		$query = $this->db->query($sql,array($no_spb));
		// $query = $this->db->query($sql);

		return $query->result_array();
	}

	
	function get_data_cetak_transfer_pencairan_nasabah($kopegtel_code,$tanggal_transfer)
	{
		$sql = "SELECT
					'Pelunasan pinj. Kopegtel an '||d.nama||' NIK.'||d.cif_no as keterangan,
					c.jumlah_angsuran as kewajiban_kopegtel,
					c.saldo_kewajiban as outstanding_kopegtel,
					c.saldo_kewajiban_ke_koptel as outstanding_koptel
				from mfi_account_financing_droping a
				join mfi_account_financing b on a.account_financing_no=b.account_financing_no
				join mfi_account_financing_reg c on b.registration_no=c.registration_no
				join mfi_cif d on d.cif_no=b.cif_no
				join mfi_product_financing e on e.product_code=b.product_code
				where c.pelunasan_ke_kopeg_mana=? and c.jumlah_angsuran>0 and a.tanggal_transfer=?
			";
		// $query = $this->db->query($sql,array($tanggal_transfer));
		$query = $this->db->query($sql,array($kopegtel_code,$tanggal_transfer));

		return $query->result_array();
	}

	
	function get_data_cetak_transfer_pencairan_nasabah2($kopegtel_code,$no_spb)
	{
		$sql = "SELECT
					'Pelunasan pinj. Kopegtel an '||d.nama||' NIK.'||d.cif_no as keterangan,
					c.jumlah_angsuran as kewajiban_kopegtel,
					c.saldo_kewajiban as outstanding_kopegtel,
					c.saldo_kewajiban_ke_koptel as outstanding_koptel
				from mfi_account_financing_droping a
				join mfi_account_financing b on a.account_financing_no=b.account_financing_no
				join mfi_account_financing_reg c on b.registration_no=c.registration_no
				join mfi_cif d on d.cif_no=b.cif_no
				join mfi_product_financing e on e.product_code=b.product_code
				where c.pelunasan_ke_kopeg_mana=? and c.saldo_kewajiban>0 and a.no_spb=?
			";
		// $query = $this->db->query($sql,array($tanggal_transfer));
		$query = $this->db->query($sql,array($kopegtel_code,$no_spb));

		return $query->result_array();
	}

	public function count_kopegtel_code_by_nik($nik)
	{
		$sql = "SELECT count(a.kopegtel_code) jumlah
				FROM 
				mfi_pegawai_kopegtel a
				,mfi_kopegtel b
				WHERE a.nik=? AND a.kopegtel_code=b.kopegtel_code AND b.status_chaneling='Y' ";
		$query = $this->db->query($sql,array($nik));

		$data =  $query->row_array();
		return $data['jumlah'];
	}

	public function get_kopegtel_list_by_nik($nik)
	{
		$sql = "SELECT 
					b.*
				FROM 
				mfi_pegawai_kopegtel a
				,mfi_kopegtel b
				WHERE a.nik=? AND a.kopegtel_code=b.kopegtel_code AND b.status_chaneling='Y' ";
		$query = $this->db->query($sql,array($nik));

		return  $query->result_array();
	}

	public function update_flag_thp($data,$param)
	{
		$this->db->update('mfi_spesial_rate',$data,$param);
	}

	public function get_kopegname_by_code($kopegtel_code)
	{
		$sql = "SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=? ";
		$query = $this->db->query($sql,array($kopegtel_code));

		$data = $query->row_array();
		$retVal = (count($data)>0) ? $data['nama_kopegtel'] : "Not Found" ;
		return $retVal;
	}

	function get_premium_rate($rate_code,$usia,$kontrak)
	{
		$sql = "select fn_get_premium_rate(?,?,?) as rate_value";
		$query = $this->db->query($sql,array($rate_code,$usia,$kontrak));
		$row = $query->row_array();
		return $row['rate_value'];
	}

	public function get_uw_policy($product_code,$usia,$manfaat)
	{
		$sql = "select fn_get_uwpolicy(?,?,?) uw_policy";
		$query = $this->db->query($sql,array($product_code,$usia,$manfaat));
		$row = $query->row_array();
		return $row['uw_policy'];
	}

	public function datatable_verifikasi_status_asuransi($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
							mfi_account_financing_reg.registration_no
							,mfi_cif.cif_no
							,mfi_cif.nama
							,mfi_account_financing_reg.amount
							,mfi_account_financing_reg.peruntukan
							,mfi_account_financing_reg.tanggal_pengajuan
							,mfi_account_financing_reg.account_financing_reg_id
							,mfi_account_financing_reg.status
							,mfi_account_financing_reg.rencana_droping
							,mfi_account_financing_reg.jangka_waktu
							,mfi_product_financing.flag_scoring
							,mfi_product_financing.rate_margin2
							,mfi_account_financing_reg.pengajuan_melalui
							,mfi_account_financing_reg.kopegtel_code
							,mfi_account_financing_reg.status_asuransi
							,mfi_account_financing_reg.uw_policy
							,(SELECT
									mfi_list_code_detail.display_text
								FROM
									mfi_list_code_detail
								WHERE mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort AS integer )
									  AND code_group = 'peruntukan'
							 ) AS display_peruntukan
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code

				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing_reg.status = '0' AND mfi_account_financing_reg.status_asuransi='0' ";
		} else {
			$sql .= " WHERE mfi_account_financing_reg.status = '0' AND mfi_account_financing_reg.status_asuransi='0' ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function datatable_verifikasi_transfer_pencairan($sWhere='',$sOrder='',$sLimit='',$product_code='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT a.account_financing_no,b.droping_date,c.nama,a.pokok,c.cif_no
					  ,d.saldo_kewajiban_ke_koptel as kewajiban_koptel,d.saldo_kewajiban as kewajiban_kopegtel, b.tanggal_transfer, a.biaya_asuransi_jiwa,(a.angsuran_pokok+a.angsuran_margin) angsuran_pertama, a.biaya_administrasi, a.biaya_notaris
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d
				WHERE a.account_financing_no=b.account_financing_no AND a.registration_no = d.registration_no
				AND a.cif_no=c.cif_no AND b.status_transfer='2' 
				AND a.status_rekening='1' AND b.status_droping='1'
		";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if($product_code!=''){
			$sql .= " AND a.product_code='$product_code' ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();		
	}

	function do_verifikasi_transfer_pencairan($data,$param)
	{
		$this->db->update('mfi_account_financing_droping',$data,$param);
	}

	public function update_thp_pegawai($data,$param)
	{
		$this->db->update('mfi_pegawai',$data,$param);
	}

	public function get_data_param_by_financing_id($account_financing_id)
	{
		$sql = "SELECT cif_no, registration_no FROM mfi_account_financing WHERE account_financing_id=? ";
		$query = $this->db->query($sql,array($account_financing_id));

		return $query->row_array();
	}

	public function act_dokumen_diterima($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	

	function datatable_create_spb($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT 
				a.account_financing_no,
				b.droping_date,
				c.nama,
				a.pokok,
				a.biaya_administrasi,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.angsuran_pokok,
				a.angsuran_margin,
				-- (a.biaya_administrasi+a.biaya_notaris+a.biaya_asuransi_jiwa) as biaya_adm,
				c.cif_no,
				d.saldo_kewajiban_ke_koptel as kewajiban_koptel,
				d.saldo_kewajiban as kewajiban_kopegtel,
				d.premi_asuransi,
				b.tanggal_transfer,
				a.product_code
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d
				WHERE a.account_financing_no=b.account_financing_no AND a.registration_no = d.registration_no
				AND a.cif_no=c.cif_no 
				AND a.status_rekening='1' AND b.status_droping='1'
				AND b.no_spb = '0'
		";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}else{
			$sql .= " order by b.tanggal_transfer asc ";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();		
	}

	public function get_data_spb_by_account_financing_no($account_financing_no)
	{
		$sql = "select
				d.cif_no,
				d.nama,
				e.product_name as jenis_pembiayaan,
				c.nama_bank,
				c.bank_cabang,
				c.no_rekening,
				c.atasnama_rekening,
				b.pokok,
				b.angsuran_pokok,
				b.angsuran_margin,
				b.biaya_asuransi_jiwa,
				b.biaya_administrasi,
				b.biaya_notaris,
				c.jumlah_kewajiban as kewajiban_koptel,
				c.jumlah_angsuran as kewajiban_kopegtel,
				c.saldo_kewajiban as outstanding_kopegtel,
				c.saldo_kewajiban_ke_koptel as outstanding_koptel,
				c.premi_asuransi as premi_asuransi,
				c.premi_asuransi_tambahan as premi_asuransi_tambahan
				from mfi_account_financing_droping a, mfi_account_financing b, mfi_account_financing_reg c, mfi_cif d, mfi_product_financing e
				where a.account_financing_no=b.account_financing_no and b.registration_no=c.registration_no and e.product_code=b.product_code
				and d.cif_no=b.cif_no and b.account_financing_no = ?
			   ";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_data_droping_sebelumnya($account_financing_no)
	{
		$sql = "select * from mfi_account_financing_droping where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}
	
	public function insert_data_spb_detail($ins_data_spb_detail)
	{
		$this->db->insert_batch('mfi_spb_detail',$ins_data_spb_detail);
	}

	public function insert_data_droping_new($upd_data_droping)
	{
		$this->db->insert_batch('mfi_account_financing_droping',$upd_data_droping);
	}

	public function insert_data_spb($ins_data_spb)
	{
		$this->db->insert('mfi_spb',$ins_data_spb);
	}

	public function delete_data_droping_sebelumnya($param_droping)
	{
		$this->db->delete('mfi_account_financing_droping',$param_droping);
	}

	function get_display_text_for_approval($kode_jabatan)
	{
		$sql = "select display_text from mfi_list_code_detail where code_value = ? and code_group = 'approvalspb'";
		$query=$this->db->query($sql,array($kode_jabatan));
		$row=$query->row_array();
		return (isset($row['display_text'])==true)?$row['display_text']:'';
	}

	function datatable_approval_spb($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_spb.id_spb,
				mfi_spb.no_spb,
				mfi_spb.tanggal_spb,
				mfi_spb.approve_1,
				mfi_spb.approve_2,
				mfi_spb.approve_3,
				mfi_spb.created_date,
				mfi_spb.user_id,
				mfi_spb.approve_1_by,
				mfi_spb.approve_2_by,
				mfi_spb.approve_3_by,
				mfi_user.fullname
				FROM
				mfi_spb
				INNER JOIN mfi_user ON CAST(mfi_spb.user_id AS integer ) = mfi_user.user_id
			   ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_user.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_user.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();		
	}

	public function get_data_spb_by_no($no_spb)
	{
		$sql = "select
				mfi_spb.id_spb,
				mfi_spb.no_spb,
				(select sum(jumlah_pembiayaan) from mfi_spb_detail where no_spb = ? group by no_spb) as jumlah_pembiayaan,
				(select sum(pelunasan_koptel) from mfi_spb_detail where no_spb = ? group by no_spb) as pelunasan_koptel,
				(select sum(angsuran_pertama) from mfi_spb_detail where no_spb = ? group by no_spb) as angsuran_pertama,
				(select sum(premi_asuransi_tambahan) from mfi_spb_detail where no_spb = ? group by no_spb) as premi_asuransi_tambahan,
				(select sum(ujroh) from mfi_spb_detail where no_spb = ? group by no_spb) as ujroh,
				(select sum(jumlah_koptel_transfer) from mfi_spb_detail where no_spb = ? group by no_spb) as jumlah_koptel_transfer,
				(select sum(pelunasan_kopeg) from mfi_spb_detail where no_spb = ? group by no_spb) as pelunasan_kopeg,
				(select sum(premi_asuransi) from mfi_spb_detail where no_spb = ? group by no_spb) as premi_asuransi
				from
				mfi_spb
				where no_spb = ?
			   ";

		$query = $this->db->query($sql,array($no_spb,$no_spb,$no_spb,$no_spb,$no_spb,$no_spb,$no_spb,$no_spb,$no_spb));
		return $query->row_array();
	}

	public function act_approve_spb($data,$param)
	{
		$this->db->update('mfi_spb',$data,$param);
	}

	function jqgrid_approval_spb($sidx='',$sord='',$limit_rows='',$start='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				mfi_spb.id_spb,
				mfi_spb.no_spb,
				mfi_spb.tanggal_spb,
				mfi_spb.approve_1,
				mfi_spb.approve_2,
				mfi_spb.approve_3,
				mfi_spb.checked,
				(case when mfi_spb.approve_1=1 then (select fullname from mfi_user where user_id = cast(mfi_spb.approve_1_by as integer)) else '' end) as approve_1_by,
				(case when mfi_spb.approve_2=1 then (select fullname from mfi_user where user_id = cast(mfi_spb.approve_2_by as integer)) else '' end) as approve_2_by,
				(case when mfi_spb.approve_3=1 then (select fullname from mfi_user where user_id = cast(mfi_spb.approve_3_by as integer)) else '' end) as approve_3_by,
				(case when mfi_spb.checked=1 then (select fullname from mfi_user where user_id = cast(mfi_spb.checked_by as integer)) else '' end) as checked_by,
				(select coalesce(sum(a.pokok),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as pokok,
				(select coalesce(sum(b.saldo_kewajiban_ke_koptel),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as kewajiban_koptel,
				(select coalesce(sum(b.saldo_kewajiban),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as kewajiban_kopegtel,
				
				(select coalesce(sum(a.biaya_administrasi),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as biaya_administrasi,
				(select coalesce(sum(a.biaya_notaris),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as biaya_notaris,
				(select coalesce(sum(a.biaya_asuransi_jiwa),0)
					from mfi_account_financing a, mfi_account_financing_reg b, mfi_account_financing_droping c
					where a.registration_no=b.registration_no and a.account_financing_no=c.account_financing_no
					and c.no_spb = mfi_spb.no_spb
					group by c.no_spb) as premi_asuransi
				from
				mfi_spb
				where approve_1 = '0' or approve_2 = '0' or approve_3 = '0'
			   ";

		$sql .= " $order $limit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function jqgrid_approval_spb_detail($sidx='',$sord='',$limit_rows='',$start='',$no_spb='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				a.account_financing_no,
				b.droping_date,
				b.no_spb,
				c.nama,
				a.pokok,
				a.biaya_administrasi,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.angsuran_pokok,
				a.angsuran_margin,
				c.cif_no,
				d.saldo_kewajiban_ke_koptel as kewajiban_koptel,
				d.saldo_kewajiban as kewajiban_kopegtel, 
				d.premi_asuransi,
				b.tanggal_transfer,
				a.product_code
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d, mfi_spb_detail e
				WHERE a.account_financing_no=b.account_financing_no 
				AND a.registration_no = d.registration_no
				AND a.cif_no=c.cif_no 
				AND a.status_rekening='1' AND b.status_droping='1'
				AND e.no_spb = b.no_spb
			   ";

		if ($no_spb!="") {
			$sql .= " AND b.no_spb = ? ";
			$param[] = $no_spb;
		}else{
			$sql .= " AND b.no_spb = ? ";
			$param[] = '0';
		}

		$sql .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16";
		$sql .= " $order $limit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function update_status_transfer_droping($data,$param)
	{
		$this->db->update('mfi_account_financing_droping',$data,$param);
	}
	

	function get_no_spb()
	{
		$sql = "select * from mfi_spb where approve_1 = '1' and approve_2 = '1' and approve_3 = '1' order by no_spb asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_data_cetak_spb($id_spb)
	{
		//(select product_name FROM mfi_product_financing WHERE mfi_product_financing.nick_name LIKE '%'||LEFT(a.no_spb,2)||'%') product_name,
		//(select product_code FROM mfi_product_financing WHERE mfi_product_financing.nick_name LIKE '%'||LEFT(a.no_spb,2)||'%') product_code
		
		$sql = "SELECT
				a.id_spb,
				a.no_spb,
				a.tanggal_spb,
				c1.user_id AS approve_1_id,
				c2.user_id AS approve_2_id,
				c3.user_id AS approve_3_id,
				c1.fullname as approve_1_by,
				c2.fullname as approve_2_by,
				c3.fullname as approve_3_by,
				coalesce(sum(b.jumlah_pembiayaan),0) as jumlah_pembiayaan,
				coalesce(sum(b.pelunasan_koptel),0) as pelunasan_koptel,
				coalesce(sum(b.angsuran_pertama),0) as angsuran_pertama,
				coalesce(sum(b.premi_asuransi_tambahan),0) as premi_asuransi_tambahan,
				coalesce(sum(b.ujroh),0) as ujroh,
				coalesce(sum(b.jumlah_koptel_transfer),0) as jumlah_koptel_transfer,
				coalesce(sum(b.pelunasan_kopeg),0) as pelunasan_kopeg,
				coalesce(sum(b.premi_asuransi),0) as premi_asuransi,
				coalesce(sum(b.biaya_administrasi),0) as biaya_administrasi,
				coalesce(sum(b.biaya_notaris),0) as biaya_notaris,
				(select nick_name FROM mfi_product_financing WHERE mfi_product_financing.nick_name LIKE '%'||LEFT(a.no_spb,2)||'%' LIMIT 1) AS product_name,
				(select product_code FROM mfi_product_financing WHERE mfi_product_financing.nick_name LIKE '%'||LEFT(a.no_spb,2)||'%' LIMIT 1) AS product_code
				from mfi_spb a
				left join mfi_spb_detail b on a.no_spb=b.no_spb
				left join mfi_user c1 on c1.user_id=a.approve_1_by::integer
				left join mfi_user c2 on c2.user_id=a.approve_2_by::integer
				left join mfi_user c3 on c3.user_id=a.approve_3_by::integer
				left join mfi_product_financing on mfi_product_financing.nick_name = substring(a.no_spb, 1, 3)
				WHERE a.id_spb = ?
				GROUP BY 1,2,3,4,5,6,7,8,9
			   ";
		$query = $this->db->query($sql,array($id_spb));
		return $query->row_array();
	}

	function get_data_cetak_spbOld($no_spb,$tanggal_spb)
	{
		$sql = "SELECT
				a.id_spb,
				a.no_spb,
				a.tanggal_spb,
				c1.fullname as approve_1_by,
				c2.fullname as approve_2_by,
				c3.fullname as approve_3_by,
				coalesce(sum(b.jumlah_pembiayaan),0) as jumlah_pembiayaan,
				coalesce(sum(b.pelunasan_koptel),0) as pelunasan_koptel,
				coalesce(sum(b.angsuran_pertama),0) as angsuran_pertama,
				coalesce(sum(b.premi_asuransi_tambahan),0) as premi_asuransi_tambahan,
				coalesce(sum(b.ujroh),0) as ujroh,
				coalesce(sum(b.jumlah_koptel_transfer),0) as jumlah_koptel_transfer,
				coalesce(sum(b.pelunasan_kopeg),0) as pelunasan_kopeg,
				coalesce(sum(b.premi_asuransi),0) as premi_asuransi,
				coalesce(sum(b.biaya_administrasi),0) as biaya_administrasi,
				coalesce(sum(b.biaya_notaris),0) as biaya_notaris
				from mfi_spb a
				left join mfi_spb_detail b on a.no_spb=b.no_spb
				left join mfi_user c1 on c1.user_id=a.approve_1_by::integer
				left join mfi_user c2 on c2.user_id=a.approve_2_by::integer
				left join mfi_user c3 on c3.user_id=a.approve_3_by::integer
				WHERE a.no_spb = ? AND a.tanggal_spb = ? 
				GROUP BY 1,2,3,4,5,6
			   ";
		$query = $this->db->query($sql,array($no_spb,$tanggal_spb));
		return $query->row_array();
	}

	function get_akun_giro()
	{
		$sql = "select * from mfi_list_code_detail where code_group = 'rekening_bank' order by code_value asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_tanggal_spb_by_no_spb($no_spb)
	{
		$sql = "SELECT * from mfi_spb where no_spb = ?";
		$query = $this->db->query($sql,array($no_spb));
		return $query->row_array();
	}
	
	function jqgrid_data_spb_status_transfer_nol($sidx='',$sord='',$limit_rows='',$start='',$no_spb='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				a.account_financing_no,
				b.no_spb,
				b.droping_date,
				c.nama,
				a.pokok,
				a.biaya_administrasi,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.angsuran_pokok,
				a.angsuran_margin,
				c.cif_no,
				d.saldo_kewajiban_ke_koptel as kewajiban_koptel,
				d.saldo_kewajiban as kewajiban_kopegtel, 
				d.premi_asuransi,
				b.tanggal_transfer,
				a.product_code
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d
				WHERE a.account_financing_no=b.account_financing_no 
				AND a.registration_no = d.registration_no
				AND a.cif_no=c.cif_no 
				AND a.status_rekening='1' 
				AND b.status_droping='1'
			   ";

		if ($no_spb!="") {
			$sql .= " AND b.no_spb = ? ";
			$param[] = $no_spb;
		}else{
			$sql .= " AND b.no_spb = ? ";
			$param[] = '';
		}

		$sql .= " $order $limit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_data_spb_status_transfer_tidak_nol($sidx='',$sord='',$limit_rows='',$start='',$no_spb='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				a.account_financing_no,
				b.droping_date,
				b.no_spb,
				c.nama,
				a.biaya_administrasi,
				a.biaya_notaris,
				a.biaya_asuransi_jiwa,
				a.angsuran_pokok,
				a.angsuran_margin,
				a.pokok,
				c.cif_no,
				d.saldo_kewajiban_ke_koptel as kewajiban_koptel,
				d.saldo_kewajiban as kewajiban_kopegtel, 
				d.premi_asuransi,
				b.tanggal_transfer,
				a.product_code
				FROM mfi_account_financing a, mfi_account_financing_droping b, mfi_cif c, mfi_account_financing_reg d, mfi_spb_detail e
				WHERE a.account_financing_no=b.account_financing_no 
				AND a.registration_no = d.registration_no
				AND a.cif_no=c.cif_no 
				AND a.status_rekening='1' AND b.status_droping='1'
				AND e.no_spb = b.no_spb
			   ";

		if ($no_spb!="") {
			$sql .= " AND b.no_spb = ? ";
			$param[] = $no_spb;
		}else{
			$sql .= " AND b.no_spb = ? ";
			$param[] = '0';
		}

		$sql .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16";
		$sql .= " $order $limit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function ins_data_tambahan_spb_detail($data)
	{
		$this->db->insert('mfi_spb_detail',$data);
	}

	public function delete_data_tambahan_spb_detail($param)
	{
		$this->db->delete('mfi_spb_detail',$param);
	}

	public function get_data_tambahan_spb_by_account_financing_no($account_financing_no)
	{
		$sql = "select
				d.cif_no,
				d.nama,
				e.product_name as jenis_pembiayaan,
				e.nick_name as nick_pembiayaan,
				c.nama_bank,
				c.bank_cabang,
				c.no_rekening,
				c.atasnama_rekening,
				b.pokok,
				b.angsuran_pokok,
				b.angsuran_margin,
				b.biaya_asuransi_jiwa,
				b.biaya_administrasi,
				b.biaya_notaris,
				b.account_financing_no,
				c.jumlah_kewajiban as kewajiban_koptel,
				c.jumlah_angsuran as kewajiban_kopegtel,
				c.saldo_kewajiban as outstanding_kopegtel,
				c.saldo_kewajiban_ke_koptel as outstanding_koptel,
				c.premi_asuransi as premi_asuransi,
				c.premi_asuransi_tambahan as premi_asuransi_tambahan
				from mfi_account_financing_droping a, mfi_account_financing b, mfi_account_financing_reg c, mfi_cif d, mfi_product_financing e
				where a.account_financing_no=b.account_financing_no and b.registration_no=c.registration_no and e.product_code=b.product_code
				and d.cif_no=b.cif_no and b.account_financing_no = ?
			   ";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function get_no_spb_not_approve()
	{
		$sql = "select * from mfi_spb where approve_1 != '1' and approve_2 != '1' and approve_3 != '1'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_tgl_spb_not_approve()
	{
		$sql = "select tanggal_spb from mfi_spb where approve_1 != '1' and approve_2 != '1' and approve_3 != '1' group by 1 order by 1 asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_no_spb_by_tanggal_spb($tanggal_spb)
	{
		$sql = "select no_spb from mfi_spb where approve_1 != '1' and approve_2 != '1' and approve_3 != '1' and tanggal_spb=?";
		$query = $this->db->query($sql,array($tanggal_spb));
		return $query->result_array();
	}

	public function datatable_data_jaminan($sWhere='',$sOrder='',$sLimit='',$src_product='')
	{
		$sql = "SELECT
						 c.id_jaminan
						,a.registration_no
						,a.cif_no
						,b.nama
						,c.tipe_jaminan
						,c.nomor_jaminan
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
				INNER JOIN mfi_jaminan c ON c.registration_no=a.registration_no
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
		}

		if ($src_product!="") {
			if ($sWhere!="") {
				$sql .= " AND a.product_code='".$src_product."'";
			} else {
				$sql .= " WHERE a.product_code='".$src_product."'";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function search_pengajuan_pembiayaan($keyword='')
	{
		$param = array();
		$sql = "SELECT
						 a.registration_no
						,a.cif_no
						,b.nama
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
				 ";

		if ( $keyword != "" ){
			$sql .= " WHERE (upper(b.nama) LIKE ? OR a.registration_no LIKE ? OR a.cif_no LIKE ?) ";
			$param[] = '%'.strtoupper($keyword).'%';
			$param[] = '%'.strtoupper($keyword).'%';
			$param[] = '%'.strtoupper($keyword).'%';
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_pengajuan_pembiayaan_dokumen_lengkap($keyword='')
	{
		$param = array();
		$sql = "SELECT
						 a.registration_no
						,a.cif_no
						,b.nama
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
				WHERE (upper(b.nama) LIKE ? OR a.registration_no LIKE ? OR a.cif_no LIKE ?)
				AND a.status_dokumen_lengkap='1'
				";

		$param[] = '%'.strtoupper($keyword).'%';
		$param[] = '%'.strtoupper($keyword).'%';
		$param[] = '%'.strtoupper($keyword).'%';

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_pengajuan_pembiayaan_dokumen_tdk_lengkap($keyword='')
	{
		$param = array();
		$sql = "SELECT
						 a.registration_no
						,a.cif_no
						,a.product_code
						,b.nama
						,b.nama_pasangan
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif b ON a.cif_no=b.cif_no
				WHERE (upper(b.nama) LIKE ? OR a.registration_no LIKE ? OR a.cif_no LIKE ?)
				AND a.status_dokumen_lengkap='0'
				";

		$param[] = '%'.strtoupper($keyword).'%';
		$param[] = '%'.strtoupper($keyword).'%';
		$param[] = '%'.strtoupper($keyword).'%';

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_kota_by_provinsi($provinsi_code='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_province_city WHERE province_code=? order by city ";

		$param[] = $provinsi_code;

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function insert_data_jaminan($data)
	{
		$this->db->insert('mfi_jaminan',$data);
	}

	public function get_jaminan_by_id($id_jaminan='')
	{
		$param = array();
		$sql = "SELECT
				 a.*
				,c.nama nasabah
				,c.nama_pasangan
				FROM 
				mfi_jaminan a
				INNER JOIN mfi_account_financing_reg b ON b.registration_no=a.registration_no
				INNER JOIN mfi_cif c ON c.cif_no=b.cif_no
				WHERE a.id_jaminan=? ";

		$param[] = $id_jaminan;

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function update_data_jaminan($data,$param)
	{
		$this->db->update('mfi_jaminan',$data,$param);
	}

	public function delete_jaminan($param)
	{
		$this->db->delete('mfi_jaminan',$param);
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

	public function get_cif_by_account_registration_no_sp4($account_financing_reg)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.jenis_kelamin,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cif.nama_pasangan,
				mfi_account_financing_reg.*,
				mfi_product_financing.product_name,
				mfi_product_financing.product_code,
				(
					case when mfi_account_financing_reg.akad_code is null then
						(select b.akad_name
						from mfi_list_code_detail a, mfi_product_financing_akad b
						where a.code_group='peruntukan'
						and a.display_sort::integer=mfi_account_financing_reg.peruntukan::integer
						and a.code_value=b.akad_code)
					else 
						mfi_product_financing_akad.akad_name
					end) as akad_name
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				LEFT JOIN mfi_product_financing_akad ON mfi_product_financing_akad.akad_code=mfi_account_financing_reg.akad_code
				WHERE mfi_account_financing_reg.registration_no = ? ";
		$query = $this->db->query($sql,array($account_financing_reg));

		return $query->row_array();
	}

	public function get_cif_by_account_registration_no($account_financing_reg)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
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
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.status_anggota,
				mfi_account_financing.menyetujui,
				mfi_account_financing.saksi1,
				mfi_account_financing.saksi2,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.counter_angsuran,
				mfi_account_financing_schedulle.account_financing_schedulle_id,
				mfi_akad.akad_name,
				mfi_akad.akad_code,
				mfi_product_financing.product_name,
				mfi_product_financing.product_code
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_account_financing_schedulle ON mfi_account_financing_schedulle.account_no_financing = mfi_account_financing.account_financing_no
				WHERE mfi_account_financing.registration_no = ?";
		$query = $this->db->query($sql,array($account_financing_reg));

		return $query->row_array();
	}
	function get_account_financing_reg_data($registration_no)
	{
		$sql = "select * from mfi_account_financing_reg where registration_no=?";
		$query = $this->db->query($sql,array($registration_no));
		return $query->row_array();
	}

	public function account_financing_reg_no($keyword='')
	{
		$sql="SELECT 
				b.cif_no,
				b.nama,
				a.registration_no,
				a.status
			  from 
			  	mfi_account_financing_reg a
			  	INNER JOIN mfi_cif b on a.cif_no=b.cif_no
			  where
			  	(a.registration_no like ? or upper(b.nama) like ?)
			";
		$param[]='%'.$keyword.'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';

		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

	public function data_cetak_sp4($account_financing_reg_id='')
	{
		$sql="SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.jenis_kelamin,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_cif.nama_pasangan,
				mfi_account_financing_reg.*,
				mfi_product_financing.product_name,
				mfi_product_financing.nick_name,
				mfi_product_financing.product_code,
				mfi_product_financing_akad.akad_name,
				mfi_pegawai.code_divisi,
				mfi_pegawai.loker,
				mfi_pegawai.posisi,
				mfi_list_code_detail.display_text as display_peruntukan
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				INNER JOIN mfi_product_financing_akad ON mfi_product_financing_akad.akad_code=mfi_product_financing.akad_code
				LEFT JOIN mfi_pegawai ON mfi_pegawai.nik=mfi_cif.cif_no
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='peruntukan' AND mfi_list_code_detail.display_sort::integer = mfi_account_financing_reg.peruntukan
				WHERE mfi_account_financing_reg.account_financing_reg_id = ? ";
		$param[]=$account_financing_reg_id;

		$query=$this->db->query($sql,$param);
		return $query->row_array();
	}
	
	public function insert_batch_schedulle($datas)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$datas);
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

	public function delete_batch_schedulle($param)
	{
		$this->db->delete('mfi_account_financing_schedulle',$param);
	}


	// NEW QUERY DATATABLE PENGAJUAN PEMBIAYAAN BANMOD


	public function datatable_pengajuan_banmod($sWhere='',$sOrder='',$sLimit='')
	{

		$sql = "select a.account_financing_reg_id
				,a.registration_no
				,a.amount
				,a.tanggal_pengajuan
				,a.created_date
				,c.nama as kopegtel_name
				,c.cif_no as kopegtel_code
				,b.display_text as product_name
				,a.f_proposal
				,a.f_kontrak
				,a.f_keuangan
				,a.f_rek_koran
				,a.f_aki
				,a.f_proyeksi
				,a.f_jaminan
				,a.status_dokumen_upload
				from mfi_account_financing_reg a
				inner join mfi_list_code_detail b on b.code_group='produkbanmod' and b.code_value=a.product_code
				left join mfi_cif c on a.cif_no=c.cif_no ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND a.status = '0'";
		}else{
			$sql .= "WHERE a.status = '0'";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	public function datatable_approval_pengajuan_banmod($sWhere='',$sOrder='',$sLimit='')
	{

		$sql = "select a.account_financing_reg_id
				,a.registration_no
				,a.amount
				,a.tanggal_pengajuan
				,a.created_date
				,c.nama as kopegtel_name
				,c.cif_no as kopegtel_code
				,b.display_text as product_name
				,a.f_proposal
				,a.f_kontrak
				,a.f_keuangan
				,a.f_rek_koran
				,a.f_aki
				,a.f_proyeksi
				,a.f_jaminan
				,a.status_dokumen_upload
				from mfi_account_financing_reg a
				inner join mfi_list_code_detail b on b.code_group='produkbanmod' and b.code_value=a.product_code
				left join mfi_cif c on a.cif_no=c.cif_no ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND a.status = '0'";
		}else{
			$sql .= "WHERE a.status = '0'";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_pengajuan_banmod_by_account_financing_reg_id($account_financing_reg_id)
	{
		$sql = "select a.account_financing_reg_id
				,d.nama_kopegtel as kopegtel_name
				,d.kopegtel_code as kopegtel
				,d.wilayah
				,d.alamat
				,d.ketua_pengurus
				,d.jabatan
				,d.nik
				,d.deskripsi_ketua_pengurus
				,d.email
				,d.no_telpon
				,d.status_chaneling
				,d.nama_bank
				,d.bank_cabang
				,d.nomor_rekening
				,d.atasnama_rekening
				,a.product_code
				,a.peruntukan
				,a.description as keterangan_peruntukan
				,a.amount
				,a.jangka_waktu
				,a.tanggal_pengajuan
				,a.rencana_droping
				from mfi_account_financing_reg a
				inner join mfi_list_code_detail b on b.code_group='produkbanmod' and b.code_value=a.product_code
				inner join mfi_cif c on a.cif_no=c.cif_no
				inner join mfi_kopegtel d on c.cif_no=d.kopegtel_code
				where a.account_financing_reg_id=? ";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}

	function get_file_by_financing_reg($account_financing_reg_id)
	{
		$sql = "select f_proposal,f_kontrak,f_keuangan,f_rek_koran,f_aki,f_proyeksi,f_jaminan
				from mfi_account_financing_reg where account_financing_reg_id=?";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}

	function get_termin_pembiayaan($account_financing_reg_id)
	{
		$sql = "select * from mfi_account_financing_reg_termin where account_financing_reg_id=? order by termin asc";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->result_array();
	}
	function get_count_financing_by_reg($account_financing_reg_id)
	{
		$sql = "select count(*) num from mfi_account_financing a, mfi_account_financing_reg b where a.registration_no=b.registration_no
				and b.account_financing_reg_id=?";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		$row = $query->row_array();
		return $row['num'];
	}
	/*
	*end koptel
	*/

	/*
	*generate counter akad 03-08-2015
	*/
	public function get_counter_akad($product_code='',$tahun='',$add_new_counter_if_not_exist=true)
	{
		$sql = "SELECT seq AS counter from mfi_akad_serial where product_code = ? and tahun = ?";
		$query = $this->db->query($sql,array($product_code,$tahun));
		$row = $query->row_array();

		if(count($row)>0){
			return $row['counter'];
		}else{
			if($add_new_counter_if_not_exist==true) {
				$this->db->insert('mfi_akad_serial',array('product_code'=>$product_code,'tahun'=>$tahun,'seq'=>0));
			}
			return 0;
		}
	}
	/*
	*end generate counter akad
	*/
	function get_list_saksi1()
	{
		$sql = "SELECT display_text FROM mfi_list_code_detail WHERE code_group='SAKSI1'
				ORDER BY display_text ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	// BEGIN COUNTER GLOBAL
	function getCounterSequence($param,$type)
	{
		$sql = "select sequence from mfi_counter where param=? and type=?";
		$query = $this->db->query($sql,array($param,$type));
		$row = $query->row_array();
		if (count($row)>0) {
			return $row['sequence'];
		} else {
			$this->insertNewCounter($param,$type);
		}
	}

	function updateCounter($param,$type,$current_sequence)
	{
		$data = array('sequence'=>$current_sequence+1);
		$param = array('param'=>$param,'type'=>$type);
		$this->db->trans_begin();
		$this->db->update('mfi_counter',$data,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
		}
	}

	function insertNewCounter($param,$type)
	{
		$data = array('param'=>$param,'type'=>$type,'sequence'=>0);
		$this->db->trans_begin();
		$this->db->insert('mfi_counter',$data);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
		}
	}
	function get_product_name_by_no_spb($no_spb)
	{
		$sql = "select c.product_name
				from mfi_account_financing_droping a, mfi_account_financing b, mfi_product_financing c
				where a.account_financing_no=b.account_financing_no and b.product_code=c.product_code
				and a.no_spb=?
				limit 1
		";
		$query = $this->db->query($sql,array($no_spb));
		$row = $query->row_array();
		return $row['product_name'];
	}
	// END

	function get_spb_by_rage($from='',$thru='')
	{
		$sql = "SELECT id_spb, no_spb, tanggal_spb FROM mfi_spb 
				WHERE approve_1=1
				AND approve_2=1 
				AND approve_3=1 
				AND tanggal_spb BETWEEN ? AND ? ORDER BY tanggal_spb desc ";

		$query = $this->db->query($sql,array($from,$thru));
		return $query->result_array();
	}

	function update_account_financing_schedulle_to_lunas($account_financing_no,$trx_date)
	{
		$sql = "
			UPDATE mfi_account_financing_schedulle SET
			status_angsuran=1,
			tanggal_bayar=?,
			bayar_pokok=angsuran_pokok,
			bayar_margin=angsuran_margin
			WHERE status_angsuran=0 AND account_no_financing=?
		";
		$query = $this->db->query($sql,array($trx_date,$account_financing_no));
	}

	public function datatable_otorisasi_pengajuan_pengurangan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_account_financing_lunas_part.id,
				mfi_account_financing.account_financing_no,
				mfi_cif.nama,
				mfi_product_financing.product_name,
				mfi_account_financing.pokok,
				mfi_account_financing_lunas_part.pengajuan_pengurangan
				FROM
				mfi_account_financing_lunas_part
				INNER JOIN mfi_account_financing ON mfi_account_financing_lunas_part.account_financing_no = mfi_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing_lunas_part.status = '0' ";
		} else {
			$sql .= " WHERE mfi_account_financing_lunas_part.status = '0' ";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function delete_reg_akad($param)
	{
		$this->db->delete('mfi_account_financing',$param);
		$this->db->query('
			delete from mfi_account_financing_reg_termin 
			where account_financing_reg_id in(select account_financing_reg_id from mfi_account_financing_reg where registration_no=?);
		',array($param['registration_no']));
	}

	public function get_sumber_dana()
	{
		$sql = "SELECT * FROM mfi_sumber_dana";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
}