<?php

Class Model_transaction extends CI_Model 
{
	/* BEGIN REGISTRASI REKENING TABUNGAN *******************************************************/

	public function get_all_product_tabungan()
	{
		$sql = "SELECT product_code, product_name, jenis_tabungan from mfi_product_saving ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_rekening_tabungan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
							 mfi_account_saving.account_saving_id				
							,mfi_account_saving.product_code
							,mfi_account_saving.account_saving_no
							,mfi_cif.nama
							,mfi_cif.cif_no
							,mfi_cm.cm_name
							,mfi_product_saving.product_name
				FROM
							mfi_cif
				INNER JOIN 
							mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no 
				INNER JOIN 
							mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				LEFT JOIN
							mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				";

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



	public function ajax_get_value_from_cif_no1($cif_no)
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.cif_type,
				mfi_cif.tgl_gabung,
				mfi_cif.telpon_seluler
				FROM
				mfi_cif
        		where mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function ajax_get_tabungan_by_cif_type($cif_type)
	{
		$sql = "SELECT
						*
				FROM
						mfi_product_saving
        		where 	mfi_product_saving.product_type = ?";
		$query = $this->db->query($sql,array($cif_type));

		return $query->result_array();
	}

	public function ajax_get_value_from_cif_no($cif_no) //ini kode yang dulu. trus sekarang diganti ke yang atas. karna yang iini ada relasi ke mfi_account_saving 
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_account_saving.account_saving_no,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
        		where mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function ajax_get_value_from_cif_no2($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_saving.account_saving_no
				FROM
				mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				where mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}
	
	public function count_cif_by_product_code($product_code)
	{
		$sql = "SELECT max(substr(account_saving_no,19)) AS jumlah from mfi_account_saving where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}
	
	public function add_rekening_tabungan($data)
	{
		$this->db->insert('mfi_account_saving',$data);
	}
	
	public function delete_rekening_tabungan($param)
	{
		$this->db->delete('mfi_account_saving',$param);
	}
	
	public function get_account_saving_by_account_saving_id($account_saving_id)
	{
		$sql = "SELECT
							mfi_account_saving.account_saving_id,
							mfi_account_saving.cif_no,
							mfi_account_saving.rencana_setoran_next,
							mfi_cif.nama,
							mfi_cif.panggilan,
							mfi_cif.ibu_kandung,
							mfi_cif.tmp_lahir,
							mfi_cif.tgl_lahir,
							mfi_cif.alamat,
							mfi_cif.rt_rw,
							mfi_cif.desa,
							mfi_cif.kecamatan,
							mfi_cif.kabupaten,
							mfi_cif.kodepos,
							mfi_cif.telpon_rumah,
							mfi_cif.telpon_seluler,
							mfi_cif.cif_type,
							mfi_cif.tgl_gabung,
							mfi_account_saving.product_code,
							mfi_account_saving.branch_code,
							mfi_account_saving.account_saving_no,
							mfi_account_saving.rencana_jangka_waktu,
							mfi_account_saving.rencana_setoran,
							mfi_account_saving.rencana_periode_setoran,
							mfi_account_saving.tanggal_buka,
							mfi_product_saving.jenis_tabungan,
							mfi_product_saving.product_name,
							mfi_product_saving.product_code
				FROM
							mfi_account_saving
				INNER JOIN 
							mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN 
							mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE 
							account_saving_id = ? ";
		$query = $this->db->query($sql,array($account_saving_id));

		return $query->row_array();
	}
	
	public function edit_rekening_tabungan($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}
	/* END REGISTRASI REKENING TABUNGAN *******************************************************/

	public function datatable_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.account_deposit_id,
				mfi_cif.nama,
				mfi_account_deposit.cif_no
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
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

	public function get_cfi_by_cif_no($cif_no)
	{
		$sql = "SELECT
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.panggilan,
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
			mfi_cif.branch_code,
			mfi_account_saving.account_saving_no
			FROM
			mfi_cif
			LEFT JOIN mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no
			WHERE mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}
	
	
	public function add_deposito($data)
	{
		$this->db->insert('mfi_account_deposit',$data);
	}

	
	public function get_all_product()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function delete_deposit($param)
	{
		$this->db->delete('mfi_account_deposit',$param);
	}
	
	public function get_deposit_by_id($account_deposit_id)
	{
		$sql = "SELECT
			mfi_account_deposit.account_deposit_id,
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.panggilan,
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
			mfi_account_deposit.jangka_waktu,
			mfi_account_deposit.tanggal_buka,
			mfi_account_deposit.tanggal_jtempo_last,
			mfi_account_deposit.tanggal_jtempo_next,
			mfi_account_deposit.automatic_roll_over,
			mfi_account_deposit.nisbah_bagihasil,
			mfi_account_deposit.nominal,
			mfi_account_deposit.account_deposit_no,
			mfi_account_deposit.account_saving_no,
			-- mfi_account_saving.saldo_memo,
			mfi_account_deposit.product_code
			FROM
			mfi_account_deposit
			INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
			-- INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
			WHERE mfi_account_deposit.account_deposit_id = ?";
		$query = $this->db->query($sql,array($account_deposit_id));

		return $query->row_array();
	}

	public function edit_deposit($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}
	
	public function cif_count_product_code($product_code)
	{
		$sql = "select max(substr(account_deposit_no,19)) AS jumlah from mfi_account_deposit where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	/* BEGIN REGISTRASI REKENING PEMBIAYAAN *******************************************************/	
	public function get_product_financing($banmod=true,$default_parent=false,$parent=false)
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.nick_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.rate_margin1,
				mfi_product_financing.rate_margin2,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.max_jangka_waktu,
				mfi_product_financing.jenis_margin
				FROM mfi_product_financing
				";
		if ($banmod==false) {
			$sql .= "
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='produkbanmod'
				WHERE mfi_product_financing.product_code<>mfi_list_code_detail.code_value";

			if($default_parent==true) {
			$sql .= " AND mfi_product_financing.parent_default = '1'";
			}
		}else{
			if($default_parent==true) {
				$sql .= " WHERE mfi_product_financing.parent_default = '1'";
			}
		}

		if($parent==true){
			$sql .= " AND mfi_product_financing.product_financing_gl_code='".$parent."' AND product_code <> '".$parent."'";
		}
		
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_product_financing_by_productcode($product_code)
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.nick_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.max_jangka_waktu,
				mfi_product_financing.jenis_margin,
				fn_get_rate_margin(mfi_product_financing.product_code,'00','min') rate_margin1,
				fn_get_rate_margin(mfi_product_financing.product_code,'00','max') rate_margin2
				FROM mfi_product_financing
				WHERE mfi_product_financing.product_code = ?
				";

		$query = $this->db->query($sql, array($product_code));
		return $query->row();
	}

	public function get_product_financing_by_band($band='',$banmod=true,$default_parent=false)
	{
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
			$sql .= "
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group='produkbanmod'
				WHERE mfi_product_financing.product_code<>mfi_list_code_detail.code_value";
			
			if($default_parent==true) {
				$sql .= " AND mfi_product_financing.parent_default = '1'";
			}
		}
		$query = $this->db->query($sql,array($band,$band));

		return $query->result_array();
	}

	public function datatable_setor_tunai_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 1 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'C'
				AND a.trx_status = 0
				AND a.created_by = ?
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

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));

		return $query->result_array();
	}

	public function datatable_penarikan_tunai_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d
		       ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 2 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'D'
				AND a.trx_status = 0
				AND a.created_by=? AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}else{
				$sql .= " AND a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 2 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'D'
				AND a.trx_status = 0
				AND a.created_by=? ";
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 2 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'D'
				AND a.trx_status = 0
				AND a.created_by=? AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}else{
				$sql .= "WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no 
				AND d.trx_detail_id = a.trx_detail_id 
				AND a.trx_saving_type = 2 
				AND b.status_rekening = 1 
				AND d.trx_type = 1
				AND a.flag_debit_credit = 'D'
				AND a.trx_status = 0
				AND a.created_by=?";
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function count_cif_by_product_code_financing($product_code)
	{
		$sql = "select max(substr(account_financing_no,19)) AS jumlah from mfi_account_financing where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	
	public function count_cif_by_cif_no_financing($cif_no)
	{
		$sql = "select max(substr(account_financing_no,19)) AS jumlah from mfi_account_financing where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	
	public function get_ajax_akad($product_code)
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_akad.akad_name,
				mfi_akad.akad_code
				FROM
				mfi_product_financing
				INNER JOIN mfi_product_akad ON mfi_product_akad.product_code = mfi_product_financing.product_code
				INNER JOIN mfi_akad ON mfi_akad.akad_code = mfi_product_akad.akad_code

				WHERE mfi_product_financing.product_code  = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	
	public function get_ajax_jenis_keuntungan($akad)
	{
		$sql = "SELECT
				akad_name,
				jenis_keuntungan,
				akad_code
				FROM
				mfi_akad
				WHERE akad_code  = ?";
		$query = $this->db->query($sql,array($akad));

		return $query->row_array();
	}

	public function get_jenis_program_financing()
	{
		$sql = "SELECT program_code, program_name from mfi_financing_program ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_sektor()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='sektor_ekonomi' ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_peruntukan($akad_code=null)
	{
		$where = !empty($akad_code) ? " AND mfi_list_code_detail.code_value = '$akad_code'" : "";
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_sort,
				mfi_list_code_detail.display_text,
				mfi_akad.akad_name
				FROM mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_list_code_detail.code_value
				where mfi_list_code.code_group='peruntukan' $where ORDER BY display_sort ASC";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function add_rekening_pembiayaan($data)
	{
		$this->db->insert('mfi_account_financing',$data);
	}
	
	public function add_rekening_pembiayaan_array($array_data)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$array_data);
	}
	
	public function delete_rekening_pembiayaan($param)
	{
		$this->db->delete('mfi_account_financing',$param);
	}

	public function get_account_financing_by_cif_no($cif_no)
	{
		$sql = "select 
					cif_no,
					(case when mfi_account_financing.jtempo_angsuran_next is null 
						then mfi_account_financing.tanggal_mulai_angsur 
						else mfi_account_financing.jtempo_angsuran_next 
					end) as jtempo_angsuran_next,
					tanggal_jtempo,
					jangka_waktu,
					account_financing_no,
					periode_jangka_waktu,
					saldo_pokok,
					saldo_margin,
					saldo_catab,
					counter_angsuran,
					status_rekening 
				from 
					mfi_account_financing 
				where 
					cif_no = ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function get_account_financing_by_cif_no2($cif_no)
	{
		$sql = "select 
					angsuran_pokok, angsuran_margin
				from 
					mfi_account_financing 
				where 
					cif_no = ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}
	
	public function get_account_financing_by_account_financing_id($account_financing_id)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.cif_type,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.usia,
				mfi_cif.tgl_lahir,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.telpon_seluler,
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.jenis_pembiayaan,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.margin,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.akad_code,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.registration_no,
				mfi_akad.akad_name
				FROM
				mfi_cif
				LEFT JOIN mfi_account_financing ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				LEFT JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_account_financing.cif_no
				WHERE mfi_account_financing.account_financing_id = ? ";
		$query = $this->db->query($sql,array($account_financing_id));

		return $query->row_array();
	}
	
	public function get_account_financing_schedulle_by_no_account($account_financing_no)
	{
		$sql = "SELECT
				mfi_account_financing_schedulle.account_financing_schedulle_id,
				mfi_account_financing_schedulle.account_no_financing,
				mfi_account_financing_schedulle.tangga_jtempo,
				mfi_account_financing_schedulle.angsuran_pokok,
				mfi_account_financing_schedulle.angsuran_margin,
				mfi_account_financing_schedulle.angsuran_tabungan
				FROM
				mfi_account_financing
				LEFT JOIN mfi_account_financing_schedulle ON mfi_account_financing.account_financing_no = mfi_account_financing_schedulle.account_no_financing
				";
		if($account_financing_no==true)
			$sql .="WHERE mfi_account_financing_schedulle.account_no_financing = ? ";

		$query = $this->db->query($sql,array($account_financing_no));

		return $query->result_array();
	}
	
	public function cek_eksistensi_tanggal_jatuh_tempo($account_financing_no,$tglakhir_angsuran)
	{
		$sql = "select count(*) as num from mfi_account_financing_schedulle where account_no_financing = ? AND tangga_jtempo = ?";
		$query = $this->db->query($sql,array($account_financing_no,$tglakhir_angsuran));
		$row = $query->row_array();
		if(count($row)>0){
			return $row['num'];
		}else{
			return 0;
		}
		// return $query->result_array();
	}

	public function get_ambil_akad()
	{
		$sql = "SELECT
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_akad.jenis_keuntungan
				FROM
				mfi_akad
				WHERE type_product = '2'
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function edit_rekening_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}
	
	public function edit_rekening_pembiayaan_array($array_data,$param2)
	{
		$this->db->update('mfi_account_financing_schedulle',$array_data,$param2);
	}
	
	public function delete_rekening_pembiayaan_array($param2)
	{
		$this->db->delete('mfi_account_financing_schedulle',$param2);
	}

	public function insert_rekening_pembiayaan_array($array_data)
	{
		$this->db->insert_batch('mfi_account_financing_schedulle',$array_data);
	}

	public function get_ajax_biaya_administrasi($product,$biaya_administrasi,$tahun)
	{
		$sql = "select fn_get_biaya_adm_pembiayaan(?,?,?) as biaya_adm";

		$query = $this->db->query($sql,array($product,$biaya_administrasi,$tahun));
		$row = $query->row_array();

		return $row['biaya_adm'];
	}

	public function get_ajax_biaya_premi_asuransi_jiwa($product,$manfaat,$year,$month,$years,$months)
	{
		$sql = "select fn_get_premi_asuransi(?,?,?,?,?,?) as biaya_premi";

		$query = $this->db->query($sql,array($product,$manfaat,$year,$month,$years,$months));
		$row = $query->row_array();
		// print_r($this->db);
		return $row['biaya_premi'];
	}

	public function get_ajax_value_from_cif_no($cif_no)
	{
		$sql = "SELECT
				mfi_cif.branch_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.alamat,
				mfi_cif.rt_rw,
				mfi_cif.desa,
				mfi_cif.kecamatan,
				mfi_cif.kabupaten,
				mfi_cif.cif_no,
				mfi_cif.cif_type,
				mfi_cif.cm_code,/*
				mfi_account_insurance.product_code,
				mfi_account_insurance.benefit_value,*/
				mfi_cif.kodepos,
				mfi_cif.telpon_rumah,
				mfi_cif.tgl_gabung,
				mfi_cif.telpon_seluler
				FROM
				mfi_cif
				/*INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no*/
        		where mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//END REKENING PEMBIAYAAN

	//BEGIN VERIFIKASI PEMBIAYAAN


	public function datatable_rekening_ver_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "select
				mfi_akad.akad_code,
				mfi_akad.akad_name,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.pokok,
				mfi_cif.cif_no,
				mfi_cif.nama
				from mfi_account_financing
				JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				JOIN mfi_akad ON mfi_akad.akad_code = mfi_account_financing.akad_code
				JOIN mfi_product_financing ON mfi_account_financing.product_code=mfi_product_financing.product_code
				JOIN mfi_product_financing_approval ON mfi_product_financing.product_code = mfi_product_financing_approval.product_code
				";

		if ( $sWhere != "" ){
			$sql .= " $sWhere AND mfi_account_financing.pokok BETWEEN mfi_product_financing_approval.nominal_min AND
					  mfi_product_financing_approval.nominal_max AND
					  mfi_product_financing_approval.kode_jabatan='".$this->session->userdata('kode_jabatan')."'";
		} else {
			$sql .= " WHERE mfi_account_financing.pokok BETWEEN mfi_product_financing_approval.nominal_min AND
					  mfi_product_financing_approval.nominal_max AND
					  mfi_product_financing_approval.kode_jabatan='".$this->session->userdata('kode_jabatan')."'";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function verifikasi_rekening_pembiayaan($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}

	public function update_status_financing_reg($data2,$param2)
	{
		$this->db->update('mfi_account_financing_reg',$data2,$param2);
	}

	//END VERIFIKASI PEMBIAYAAN
	

	/* BEGIN INSURANCE *******************************************************/
	public function get_all_insurance()
	{
		$sql = "SELECT
						mfi_cif.nama,
						mfi_account_insurance.account_insurance_no,
						mfi_product_insurance.product_name,
						mfi_account_insurance.status,
						mfi_account_insurance.account_insurance_id
				FROM
						mfi_cif
			INNER JOIN 	
						mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
			INNER JOIN 	
						mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_product_insurance()
	{
		$sql = "SELECT * from mfi_product_insurance ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_insurance_plan()
	{
		$sql = "SELECT * from mfi_product_insurance_plan ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_insurance_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						mfi_cif.nama,
						mfi_account_insurance.account_insurance_no,
						mfi_product_insurance.product_name,
						mfi_account_insurance.status_rekening,
						mfi_account_insurance.account_insurance_id
				FROM
						mfi_cif
			INNER JOIN 	
						mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
			INNER JOIN 	
						mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	
	public function add_insurance($data)
	{
		$this->db->insert('mfi_account_insurance',$data);
	}
	
	public function delete_insurance($param)
	{
		$this->db->delete('mfi_account_insurance',$param);
	}
	
	public function get_account_insurance_by_account_insurance_id($account_insurance_id)
	{
		$sql = "SELECT
							mfi_cif.cif_no,
							mfi_cif.nama,
							mfi_cif.panggilan,
							mfi_cif.ibu_kandung,
							mfi_cif.tmp_lahir,
							mfi_cif.tgl_lahir,
							mfi_cif.alamat,
							mfi_cif.rt_rw,
							mfi_cif.desa,
							mfi_cif.kecamatan,
							mfi_cif.kabupaten,
							mfi_cif.kodepos,
							mfi_cif.telpon_rumah,
							mfi_cif.telpon_seluler,
							mfi_account_insurance.account_insurance_id,
							mfi_account_insurance.product_code,
							mfi_account_insurance.account_insurance_no,
							mfi_account_insurance.awal_kontrak,
							mfi_account_insurance.akhir_kontrak,
							mfi_account_insurance.benefit_value,
							mfi_account_insurance.premium_value,
							mfi_account_insurance.premium_rate,
							mfi_account_insurance.plan_code,
							mfi_account_insurance.account_saving_no,
							mfi_account_insurance.usia_peserta,
							mfi_product_insurance.product_name,
							mfi_product_insurance.insurance_type,
							mfi_product_insurance.rate_type,
							mfi_product_insurance.rate_code
					FROM
							mfi_cif
				INNER JOIN 	
							mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN 
							mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code

				WHERE 
							account_insurance_id = ? ";
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}
	
	public function edit_insurance($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}

	public function count_account_no_by_product_code($product_code)
	{
		$sql = "select max(right(account_insurance_no,3)) AS jumlah from mfi_account_insurance where product_code = ?";
		$query = $this->db->query($sql,array($product_code));

		return $query->row_array();
	}

	public function count_premi_rate_0($rate_type)
	{
		$sql = "select rate_tunggal as rate from mfi_product_insurance where rate_type = ?";
		$query = $this->db->query($sql,array($rate_type));

		return $query->row_array();
	}

	public function count_premi_rate_1($rate_code,$usia,$kontrak)
	{
		$sql = "select rate_value as rate from mfi_product_insurance_rate where rate_code = ? AND usia = ? AND kontrak = ? ";
		$query = $this->db->query($sql,array($rate_code,$usia,$kontrak));

		return $query->row_array();
	}

	public function count_premi_rate_2($plan_code)
	{
		$sql = "select premium_value AS rate from mfi_product_insurance_plan where plan_code = ?";
		$query = $this->db->query($sql,array($plan_code));

		return $query->row_array();
	}
	/* END INSURANCE *******************************************************/

	/* PENARIKAN TUNAI TABUNGAN *******************************************************/
	// search account saving number
	public function search_account_saving_no($keyword='',$cif_type='',$cm_code='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_saving.cif_no,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.product_code,
				mfi_account_saving.status_rekening,
				mfi_product_saving.product_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				WHERE (UPPER(nama) like ? or account_saving_no like ?)
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($cif_type!=""){
			$sql .= " and cif_type = ? ";
			$param[] = $cif_type;
		}

		if($cm_code!=""){
			$sql .= " and cm_code = ? ";
			$param[] = $cm_code;
		}

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function search_account_saving_no_active($keyword='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_type,
				mfi_cm.cm_code,
				mfi_cm.cm_name,
				mfi_account_saving.cif_no,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.product_code,
				mfi_account_saving.status_rekening,
				mfi_product_saving.product_name
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				WHERE (UPPER(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) and mfi_account_saving.status_rekening = 1
				AND mfi_cif.cif_type=0
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function ajax_get_value_from_account_saving($no_rekening)
	{
		// (SELECT SUM(amount) FROM mfi_trx_account_saving WHERE mfi_trx_account_saving.account_saving_no=mfi_account_saving.account_saving_no AND trx_status='0')
		// case when (cif.status in(1,3) and balance.transaksi_lain=0) then cif_kelompok.setoran_lwk else 0 end

		// mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal

		$sql = "SELECT CASE WHEN X.not_verif=0 OR X.not_verif IS NULL THEN X.saldo_efektif ELSE X.saldo_efektif-X.not_verif END AS saldo_efektif, X.nama, X.account_saving_no, X.cif_no, X.product_name, X.saldo_memo, X.saldo_hold, X.saldo_minimal, X.branch_id FROM (
					SELECT
						(SELECT SUM(amount) FROM mfi_trx_account_saving WHERE mfi_trx_account_saving.account_saving_no=mfi_account_saving.account_saving_no AND trx_status='0' AND flag_debit_credit='C') AS not_verif,
						(mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) AS saldo_efektif,
						mfi_cif.nama,
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_product_saving.product_name,
						mfi_account_saving.saldo_memo,
						mfi_account_saving.saldo_hold,
						mfi_product_saving.saldo_minimal,
						mfi_branch.branch_id
					FROM
							mfi_cif
					INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
					INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
					INNER JOIN mfi_branch ON mfi_account_saving.branch_code = mfi_branch.branch_code
					WHERE mfi_account_saving.account_saving_no = ?
				) AS X";
		$query = $this->db->query($sql,array($no_rekening));
		
		return $query->row_array();
	}

	public function ajax_get_value_from_account_saving_status_3($no_rekening)
	{
		$sql = "SELECT (mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) 
				as saldo_efektif,mfi_account_saving.saldo_memo,mfi_account_saving.account_saving_no,nama,mfi_account_saving.product_code,product_name,status_rekening ,mfi_cif.cif_type,mfi_cif.cif_no
				,mfi_trx_account_saving.trx_account_saving_id
				from mfi_account_saving 
				left join mfi_product_saving on mfi_account_saving.product_code = mfi_product_saving.product_code
				left join mfi_cif on mfi_account_saving.cif_no = mfi_cif.cif_no
				left join mfi_trx_account_saving on mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				where mfi_account_saving.account_saving_no = ? AND status_rekening = '3' AND mfi_cif.cif_type=0
				";
		$query = $this->db->query($sql,array($no_rekening));
		
		return $query->row_array();
	}

	public function get_rekening_tabungan_berencana_tujuan($cif_no,$account_financing_no)
	{
		$sql = "select * from mfi_account_saving where cif_no = ? and account_financing_no <> ? and status_rekening = 1";
		$query = $this->db->query($sql,array($cif_no,$account_saving_no));
		return $query->result_array();
	}

	public function update_account_saving_penarikan($data_account_saving,$param_account_saving)
	{
		$this->db->update('mfi_account_saving',$data_account_saving,$param_account_saving);
	}

	public function insert_trx_account_saving_penarikan($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function insert_trx_detail_penarikan($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function update_trx_account_saving_penarikan($data_trx_account_saving,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data_trx_account_saving,$param);
	}

	public function update_trx_detail_penarikan($data_trx_detail,$param)
	{
		$this->db->update('mfi_trx_detail',$data_trx_detail,$param);
	}
	
	public function check_no_referensi($no_referensi)
	{
		$sql = "select count(*) as num from mfi_trx_account_saving where reference_no = ?";
		$query = $this->db->query($sql,array($no_referensi));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	
	/**************************************************************************************/
	// BEGIN SETORAN TUNAI TABUNGAN 
	/**************************************************************************************/
	

	// search cif number
	public function search_cif_by_account_saving($keyword='',$type='',$cm_code='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_cif.nama,
						mfi_product_saving.product_name,
						mfi_product_saving.product_code,
						mfi_account_saving.status_rekening,
						mfi_resort.resort_code,
						mfi_resort.resort_name
				FROM
						mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				LEFT JOIN mfi_account_financing ON mfi_account_financing.account_saving_no=mfi_account_saving.account_saving_no
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing.resort_code
				WHERE (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?) AND mfi_account_saving.status_rekening !=2";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($type!=""){
			$sql .= ' and cif_type = ?';
			$param[] = $type;
		}

		if($cm_code!=""){
			$sql .= ' and cm_code = ?';
			$param[] = $cm_code;
		} 

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function search_cif_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
						(mfi_account_saving.saldo_memo-mfi_account_saving.saldo_hold-mfi_product_saving.saldo_minimal) AS saldo_efektif,
						mfi_cif.nama,
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_product_saving.product_name,
						mfi_account_saving.saldo_memo,
						mfi_account_saving.saldo_hold,
						mfi_product_saving.saldo_minimal,
						mfi_branch.branch_id
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				INNER JOIN mfi_branch ON mfi_account_saving.branch_code = mfi_branch.branch_code
				WHERE mfi_account_saving.account_saving_no = ?";
		

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function add_setoran_tunai_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	public function add_setoran_tunai_account_saving($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function update_setoran_tunai_detail($data,$param)
	{
		$this->db->update('mfi_trx_detail',$data,$param);
	}

	public function update_setoran_tunai_trx_account_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}

	public function update_setoran_tunai_account_saving($data_account_saving,$param_account_saving)
	{
		$this->db->update('mfi_account_saving',$data_account_saving,$param_account_saving);
	}
	

	/**************************************************************************************/
	// END SETORAN TUNAI TABUNGAN 
	/**************************************************************************************/



	/* BEGIN PINBUK ************************************************************/

	public function get_no_rekening_pinbuk_sumber($keyword,$no_rekening_tujuan)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "select 
				mfi_account_saving.account_saving_no,
				mfi_account_saving.status_rekening,
				mfi_cif.nama,
				mfi_product_saving.product_name,
				(mfi_account_saving.saldo_memo - mfi_account_saving.saldo_hold - mfi_product_saving.saldo_minimal) as saldo_efektif
				from mfi_account_saving
				left join mfi_cif on mfi_cif.cif_no = mfi_account_saving.cif_no
				left join mfi_product_saving on mfi_product_saving.product_code = mfi_account_saving.product_code
				where (mfi_account_saving.account_saving_no like ? or upper(mfi_cif.nama) like ?)
				and mfi_cif.cif_type = 1 and mfi_account_saving.account_saving_no<>?
			";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
		}

		$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$no_rekening_tujuan));

		return $query->result_array();
	}

	public function get_no_rekening_pinbuk_tujuan($keyword,$no_rekening_sumber)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "select 
				mfi_account_saving.account_saving_no,
				mfi_account_saving.status_rekening,
				mfi_cif.nama,
				mfi_product_saving.product_name,
				(mfi_account_saving.saldo_memo - mfi_account_saving.saldo_hold - mfi_product_saving.saldo_minimal) as saldo_efektif
				from mfi_account_saving
				left join mfi_cif on mfi_cif.cif_no = mfi_account_saving.cif_no
				left join mfi_product_saving on mfi_product_saving.product_code = mfi_account_saving.product_code
				where (mfi_account_saving.account_saving_no like ? or upper(mfi_cif.nama) like ?)
				and mfi_cif.cif_type = 1 and mfi_account_saving.account_saving_no<>?
			";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
		}
		
		$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$no_rekening_sumber));

		return $query->result_array();
	}

	public function get_account_saving_by_account_saving_no($account_saving_no)
	{
		$sql = "select * from mfi_account_saving where account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function update_account_saving($data,$param)
	{
		$this->db->update('mfi_account_saving',$data,$param);
	}

	public function insert_trx_account_saving($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function insert_trx_detail($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	/* END PINBUK ************************************************************/



	/****************************************************************************************/	
	// BEGIN REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	public function search_cif_by_account_deposit($keyword)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.account_deposit_no,
						mfi_account_deposit.account_saving_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_account_deposit.status_rekening
				FROM
						mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code

				WHERE (upper(nama) like ? or account_saving_no like ?)
				";

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		
		// print_r($this->db);

		return $query->result_array();
	}

	public function search_cif_by_account_deposit_no($account_deposit_no)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit.account_deposit_no,
						mfi_account_deposit.account_saving_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_cif.ibu_kandung,
						mfi_cif.tgl_lahir,
						mfi_cif.rt_rw,
						mfi_cif.alamat,
						mfi_cif.desa,
						mfi_cif.kecamatan,
						mfi_cif.kabupaten,
						mfi_product_deposit.product_code,
						mfi_product_deposit.product_name,
						mfi_account_deposit.jangka_waktu,
						mfi_account_deposit.nominal,
						mfi_account_deposit.tanggal_jtempo_last,
						mfi_account_deposit.automatic_roll_over
				FROM
						mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code


				WHERE (mfi_account_deposit.account_deposit_no = ?)";
		

		$query = $this->db->query($sql,array($account_deposit_no));

		return $query->row_array();
	}

	public function search_name_by_account_saving_no($account_saving_no)
	{
		$sql = "SELECT
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_cif.nama AS atasnama
				FROM
						mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no


				WHERE (mfi_account_saving.account_saving_no = ?)";
		

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	public function search_name_by_account_saving_no_klaim($account_saving_no)
	{
		$sql = "SELECT
						mfi_account_saving.account_saving_no,
						mfi_cif.cif_no,
						mfi_cif.nama
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_account_saving.account_saving_no = ?";

		$query = $this->db->query($sql,array($account_saving_no));

		return $query->result_array();
	}

	public function update_pencairan_deposito($data_pencairan_deposito,$param_pencairan_deposito)
	{
		$this->db->update('mfi_account_deposit',$data_pencairan_deposito,$param_pencairan_deposito);
	}

	public function insert_deposito_break($data)
	{
		$this->db->insert('mfi_account_deposit_break',$data);
	}
	
	/****************************************************************************************/	
	// END REGISTRASI PENCAIRAN DEPOSITO
	/****************************************************************************************/

	//BEGIN VERIFIKASI DEPOSITO
	public function datatable_rekening_ver_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_deposit.account_deposit_id,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit.nominal
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
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

	public function verifikasi_rekening_deposito($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}

	public function verifikasi_rek_deposito($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}
	
	public function delete_rekening_deposito($param)
	{
		$this->db->delete('mfi_account_deposit',$param);
	}

	public function get_product_deposito()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function update_saldo_memo_from_account_saving($data2,$param2)
	{
		$this->db->update('mfi_account_saving',$data2,$param2);
	}

	public function insert_mfi_trx_detail($data_trx_detail)
	{
		$this->db->insert('mfi_trx_detail',$data_trx_detail);
	}

	public function insert_mfi_trx_account_deposit($data_trx_account_deposit)
	{
		$this->db->insert('mfi_trx_account_deposit',$data_trx_account_deposit);
	}

	public function insert_mfi_trx_account_saving($data_trx_account_saving)
	{
		$this->db->insert('mfi_trx_account_saving',$data_trx_account_saving);
	}

	public function get_date_current()
	{
		// $sql = "SELECT date_current from mfi_date_transaction";
		$sql = "select periode_awal from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		return $row['periode_awal'];
	}

	//END VERIFIKASI DEPOSITO

	/**************************************************************************************/
	// BEGIN VERIFIKASI PENCAIRAN DEPOSITO 
	/**************************************************************************************/
	public function datatable_pencairan_deposito_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_deposit.account_deposit_id,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.nominal,
				mfi_account_deposit.jangka_waktu,
				mfi_account_deposit_break.account_deposit_break_id,
				mfi_account_deposit_break.status_break
				FROM
				mfi_account_deposit_break
				INNER JOIN mfi_account_deposit ON mfi_account_deposit.account_deposit_no = mfi_account_deposit_break.account_deposit_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
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

	public function search_cif_by_account_deposit_break_id($account_deposit_break_id)
	{
		$sql = "SELECT
						mfi_product_deposit.product_name,
						mfi_account_deposit.account_deposit_no,
						mfi_cif.nama,
						mfi_cif.cif_no,
						mfi_cif.ibu_kandung,
						mfi_cif.tgl_lahir,
						mfi_cif.rt_rw,
						mfi_cif.alamat,
						mfi_cif.desa,
						mfi_cif.kecamatan,
						mfi_cif.kabupaten,
						mfi_product_deposit.product_name,
						mfi_account_deposit.jangka_waktu,
						mfi_account_deposit.nominal,
						mfi_account_deposit.tanggal_jtempo_last,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit.automatic_roll_over,
						mfi_account_deposit_break.account_deposit_break_id,
						mfi_account_deposit_break.account_saving_no
				FROM
						mfi_account_deposit
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				LEFT JOIN mfi_product_deposit ON mfi_account_deposit.product_code = mfi_product_deposit.product_code
				LEFT JOIN mfi_account_deposit_break ON mfi_account_deposit_break.account_deposit_no = mfi_account_deposit.account_deposit_no



				WHERE (mfi_account_deposit_break.account_deposit_break_id = ?)";
		

		$query = $this->db->query($sql,array($account_deposit_break_id));

		return $query->row_array();
	}

	public function update_account_deposit($data,$param)
	{
		$this->db->update('mfi_account_deposit',$data,$param);
	}

	public function update_account_deposit_break($data,$param)
	{
		$this->db->update('mfi_account_deposit_break',$data,$param);
	}

	public function delete_account_deposit_break($param)
	{
		$this->db->delete('mfi_account_deposit_break',$param);
	}
	/**************************************************************************************/
	// END VERIVIKASI PENCAIRAN DEPOSITO 
	/**************************************************************************************/

	//BEGIN VERIFIKASI ASURANSI
	public function datatable_verifikasi_insurance_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_insurance.account_insurance_no,
				mfi_cif.nama,
				mfi_product_insurance.product_name,
				mfi_product_insurance.product_code,
				mfi_account_insurance.benefit_value,
				mfi_account_insurance.premium_value,
				mfi_account_insurance.awal_kontrak,
				mfi_account_insurance.akhir_kontrak,
				mfi_account_insurance.status_rekening,
				mfi_cif.cif_no,
				mfi_account_insurance.account_insurance_id
				FROM
				mfi_cif
				INNER JOIN mfi_account_insurance ON mfi_account_insurance.cif_no = mfi_cif.cif_no
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

	public function get_account_insurance_by_account_insurance_id_on_verifikasi($account_insurance_id)
	{
		$sql = "SELECT
							mfi_cif.cif_no,
							mfi_cif.nama,
							mfi_cif.panggilan,
							mfi_cif.ibu_kandung,
							mfi_cif.tmp_lahir,
							mfi_cif.tgl_lahir,
							mfi_cif.alamat,
							mfi_cif.rt_rw,
							mfi_cif.desa,
							mfi_cif.kecamatan,
							mfi_cif.kabupaten,
							mfi_cif.kodepos,
							mfi_cif.telpon_rumah,
							mfi_cif.telpon_seluler,
							mfi_account_insurance.account_insurance_id,
							mfi_account_insurance.product_code,
							mfi_account_insurance.account_insurance_no,
							mfi_account_insurance.awal_kontrak,
							mfi_account_insurance.akhir_kontrak,
							mfi_account_insurance.benefit_value,
							mfi_account_insurance.premium_value,
							mfi_account_insurance.premium_rate,
							mfi_account_insurance.plan_code,
							mfi_account_insurance.account_saving_no AS pemegang_rekening,
							mfi_account_insurance.usia_peserta,
							mfi_product_insurance.product_name,
							mfi_product_insurance.insurance_type,
							mfi_product_insurance.rate_type,
							mfi_product_insurance.rate_code,
							mfi_account_saving.saldo_memo
					FROM
							mfi_cif
				INNER JOIN 	
							mfi_account_insurance ON mfi_cif.cif_no = mfi_account_insurance.cif_no
				INNER JOIN 
							mfi_product_insurance ON mfi_account_insurance.product_code = mfi_product_insurance.product_code
				INNER JOIN 
							mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no

				WHERE 
							account_insurance_id = ? ";
		$query = $this->db->query($sql,array($account_insurance_id));

		return $query->row_array();
	}


	public function mencari_nama_pemegang_rekening($pemegang_rekening)
	{
		$sql = "SELECT
						mfi_cif.nama
				FROM
						mfi_cif
				INNER JOIN mfi_account_saving ON mfi_cif.cif_no = mfi_account_saving.cif_no
				where mfi_account_saving.account_saving_no = ?";
		$query = $this->db->query($sql,array($pemegang_rekening));

		return $query->row_array();
	}

	public function update_saldo_memo($update_saldo_memo,$account_saving_no)
	{
		$this->db->update('mfi_account_saving',$update_saldo_memo,$account_saving_no);
	}

	public function insert_mfi_trx_detail_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_detail',$data);
	}

	public function insert_mfi_trx_account_insurance_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_account_insurance',$data);
	}
	
	public function insert_mfi_trx_account_saving_on_verifikasi_insurance($data)
	{
		$this->db->insert('mfi_trx_account_saving',$data);
	}

	public function verifikasi_rekening_asuransi($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}

	public function verifikasi_rek_asuransi($data,$param)
	{
		$this->db->update('mfi_account_insurance',$data,$param);
	}
	
	public function delete_rekening_asuransi($param)
	{
		$this->db->delete('mfi_account_insurance',$param);
	}

	public function get_product_asuransi()
	{
		$sql = "SELECT product_code, product_name from mfi_product_deposit ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_trx_rembug_data($cm_code,$tanggal)
	{
		$sql = "
		SELECT 
		cif.cif_id
		,cif.cm_code
		,cif.cif_no
		,cif.nama
		,(case when (cif.status in(1,3) and balance.transaksi_lain=0) then cif_kelompok.setoran_lwk else 0 end) as setoran_lwk
		,cif_kelompok.setoran_mingguan
		,balance.tabungan_sukarela
		,balance.tabungan_wajib
		,balance.transaksi_lain
		,balance.angsuran
		,balance.pokok_pembiayaan
		,balance.margin_pembiayaan
		,balance.catab_pembiayaan
		,balance.tabungan_kelompok
		--,coalesce(droping.amount,0) droping
		,pembiayaan.saldo_pokok as saldo_pokok
		,pembiayaan.saldo_margin as saldo_margin
		,pembiayaan.saldo_catab as saldo_catab
		,pembiayaan.jangka_waktu as jangka_waktu
		,pembiayaan.periode_jangka_waktu as periode_jangka_waktu
		,pembiayaan.counter_angsuran as counter_angsuran
		,(case when pembiayaan.tanggal_akad <= ? then(case when pembiayaan.status_rekening = 1 then
			(case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then 
				(pembiayaan.angsuran_pokok+pembiayaan.angsuran_margin+pembiayaan.angsuran_catab+pembiayaan.angsuran_tab_wajib+pembiayaan.angsuran_tab_kelompok)
			else
				0 
			end)
		else 0 end ) else 0 end) as jumlah_angsuran,
		(select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no),
		pembiayaan.tanggal_akad,
		(case when pembiayaan.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 0 then pembiayaan.pokok else 0 end) else 0 end) as pokok
		,(case when pembiayaan.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 0 then pembiayaan.margin else 0 end) else 0 end) as margin
		--,pembiayaan.margin as margin
		,(case when pembiayaan.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 0 then pembiayaan.pokok else 0 end) else 0 end) as droping
		,(case when pembiayaan.tanggal_akad <= ? then (case when pembiayaan.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then pembiayaan.angsuran_pokok else 0 end) else 0 end) else 0 end) as angsuran_pokok
		,(case when pembiayaan.tanggal_akad <= ? then (case when pembiayaan.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then pembiayaan.angsuran_margin else 0 end) else 0 end) else 0 end) as angsuran_margin
		,(case when pembiayaan.tanggal_akad <= ? then (case when pembiayaan.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then pembiayaan.angsuran_catab else 0 end) else 0 end) else 0 end) as angsuran_catab
		,(case when pembiayaan.tanggal_akad <= ? then (case when pembiayaan.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then pembiayaan.angsuran_tab_wajib else 0 end) else 0 end) else 0 end) as angsuran_tab_wajib
		,(case when pembiayaan.tanggal_akad <= ? then (case when pembiayaan.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 1 then pembiayaan.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end) as angsuran_tab_kelompok
		,pembiayaan.product_code
		,(case when pembiayaan.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 0 then (pembiayaan.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end) as adm
		,(case when pembiayaan.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = pembiayaan.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end) asuransi 
		,cif.status
		,COALESCE(SUM(berencana.rencana_setoran),0) as setoran_berencana
		FROM mfi_cif AS cif
		LEFT OUTER JOIN mfi_cif_kelompok AS cif_kelompok ON cif_kelompok.cif_id = cif.cif_id
		LEFT OUTER JOIN mfi_account_default_balance AS balance  ON (cif.cif_no = balance.cif_no)
		LEFT OUTER JOIN mfi_account_financing AS pembiayaan ON (pembiayaan.cif_no=cif.cif_no) AND (pembiayaan.status_rekening = 1)
		LEFT OUTER JOIN mfi_account_saving AS berencana ON (berencana.cif_no = cif.cif_no
			AND berencana.product_code = (select pberencana.product_code from mfi_product_saving as pberencana where pberencana.product_code = berencana.product_code and pberencana.jenis_tabungan = 1)
		)
		WHERE cif.cm_code=? AND cif.cif_type=0 AND cif.status in (1,3)
		GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35
		ORDER BY cif.kelompok::integer asc;
		";
		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$cm_code));
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	//END VERIFIKASI ASURANSI

	/* BEGIN TRANSAKSI REMBUG **********************************************************/

	public function update_account_default_balance($data,$param)
	{
		$this->db->update('mfi_account_default_balance',$data,$param);
	}

	public function insert_trx_cm($data)
	{
		$this->db->insert('mfi_trx_cm',$data);
	}

	public function insert_trx_cm_detail($data)
	{
		$this->db->insert_batch('mfi_trx_cm_detail',$data);
	}

	public function get_gl_account()
	{
		$sql = "select gl_account_id,account_code,account_name,account_type,account_group_code from mfi_gl_account order by account_code asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/* END TRANSAKSI REMBUG **********************************************************/


	/* BEGIN TRANSAKSI JURNAL **********************************************************/

	public function insert_trx_gl($data)
	{
		$this->db->insert("mfi_trx_gl",$data);
	}

	public function insert_trx_gl_detail($data)
	{
		$this->db->insert_batch("mfi_trx_gl_detail",$data);
	}

	/* END TRANSAKSI JURNAL **********************************************************/


	/* BEGIN GL ACCOUNT CASH **********************************************************/

	public function ajax_get_gl_account_cash()
	{
		$sql = "select 
				mfi_gl_account_cash.account_cash_id,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.fa_code,
				mfi_fa.fa_name,
				mfi_gl_account_cash.account_cash_name,
				mfi_gl_account_cash.gl_account_code
				from mfi_gl_account_cash
				left join mfi_fa on mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function insert_trx_gl_cash($data)
	{
		$this->db->insert('mfi_trx_gl_cash',$data);
	}

	public function insert_trx_gl_cash_detail($data)
	{
		$this->db->insert_batch('mfi_trx_gl_cash_detail',$data);
	}

	public function update_gl_account_cash($data,$param)
	{
		$this->db->update('mfi_gl_account_cash',$data,$param);
	}

	public function get_gl_account_cash_by_account_cash_id($account_cash_id)
	{
		$sql = "select * from mfi_gl_account_cash where account_cash_id = ?";
		$query = $this->db->query($sql,array($account_cash_id));

		return $query->row_array();
	}

	public function ajax_get_gl_account_cash_by_keyword($keyword,$branch_code='',$account_cash_type='')
	{
		$sql = "select 
				mfi_gl_account_cash.*
				,mfi_fa.fa_name
				from mfi_gl_account_cash 
				left join mfi_fa on mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				where mfi_fa.branch_code = ? and 
				((mfi_gl_account_cash.account_cash_code like ? or upper(mfi_gl_account_cash.account_cash_name) like ? or mfi_fa.fa_code like ? or upper(mfi_fa.fa_name) like ?))";

		if($account_cash_type!=""){
			$sql .= " and mfi_gl_account_cash.account_cash_type = ?";
		}

		$query = $this->db->query($sql,array($branch_code,'%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$account_cash_type));
		// print_r($this->db);
		return $query->result_array();
	}

	public function ajax_get_cm_by_fa_code($fa_code)
	{
		$sql = "select * from mfi_cm where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));

		return $query->result_array();
	}

	public function insert_trx_gl_cash_detail_cm($data)
	{
		$this->db->insert_batch('mfi_trx_gl_cash_detail_cm',$data);
	}

	/* END GL ACCOUNT CASH **********************************************************/


	/* BEGIN VERIFICATION TRANSACTION **********************************************************/

	public function insert_trx_account_deposit($data)
	{
		$this->db->insert('mfi_trx_account_deposit',$data);
	}

	/* END VERIFICATION TRANSACTION **********************************************************/

	

	/* BEGIN PENDEBETAN ANGSURAN PEMBIAYAAN **********************************************************/

	public function get_data_pendebetan_angsuran_pembiayaan($tanggal_jto)
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		// $sql = "
		// select a.jtempo_angsuran_next,a.account_financing_no,c.nama,date_part('month', age(date(?), a.jtempo_angsuran_next) ) as freq_bayar,
		// a.angsuran_pokok,a.angsuran_margin,a.angsuran_catab as angsuran_tabungan,(a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab) angsuran,
		// (b.saldo_memo-b.saldo_hold-e.saldo_minimal) as saldo_tabungan
		// from mfi_account_financing a,mfi_account_saving b,mfi_cif c,mfi_product_financing d,mfi_product_saving e
		// where a.account_saving_no=b.account_saving_no and a.cif_no=c.cif_no and e.product_code=b.product_code
		// and a.product_code=d.product_code and d.jenis_pembiayaan=0
		// and date_part('month', age(date(?), a.jtempo_angsuran_next) ) > 0
		// ";
		$sql = "
				select a.jtempo_angsuran_next,a.account_financing_no,c.nama,
				(case when periode_jangka_waktu = 0 then (date(?)-a.jtempo_angsuran_last)::integer
				      when periode_jangka_waktu = 1 then (date(?)-a.jtempo_angsuran_last)/7::integer
				      when periode_jangka_waktu = 2 then date_part('month', age(date(?), a.jtempo_angsuran_last) )
				      when periode_jangka_waktu = 3 then 1
				end) as freq_bayar,a.periode_jangka_waktu,
				(case when a.flag_jadwal_angsuran = 0 then 
				(select angsuran_pokok from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 order by tangga_jtempo asc limit 1)
				else a.angsuran_pokok end) as angsuran_pokok,
				(case when a.flag_jadwal_angsuran = 0 then 
				(select angsuran_margin from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 order by tangga_jtempo asc limit 1)
				else a.angsuran_margin end) as angsuran_margin,
				(case when a.flag_jadwal_angsuran = 0 then 
				(select angsuran_tabungan from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 order by tangga_jtempo asc limit 1)
				else a.angsuran_catab end) as angsuran_tabungan
				,(case when a.flag_jadwal_angsuran = 0 then 
				(select (angsuran_pokok+angsuran_margin+angsuran_tabungan) from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 order by tangga_jtempo asc limit 1) 
				else 
				(a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab)
				end) angsuran,
				a.flag_jadwal_angsuran,
				coalesce((select sum(angsuran_pokok+angsuran_margin+angsuran_tabungan) from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 and tangga_jtempo <= ?),0) pembayaran_schedulle,
				coalesce((select count(*) from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 and tangga_jtempo <= ?),0) freq_bayar_schedulle,
				(b.saldo_memo-b.saldo_hold-e.saldo_minimal) as saldo_tabungan,
				a.jtempo_angsuran_next,a.pokok,a.margin,
				a.saldo_pokok,a.saldo_margin,a.saldo_catab,
				a.jangka_waktu,a.counter_angsuran
				from mfi_account_financing a,mfi_account_saving b,mfi_cif c,mfi_product_financing d,mfi_product_saving e
				where a.account_saving_no=b.account_saving_no and a.cif_no=c.cif_no and e.product_code=b.product_code
				and a.product_code=d.product_code and d.jenis_pembiayaan=0
				and (case when a.flag_jadwal_angsuran = 0 then 
				coalesce((select count(*) from mfi_account_financing_schedulle where account_no_financing=a.account_financing_no and status_angsuran=0 and tangga_jtempo <= ?),0)
				else (case when periode_jangka_waktu = 0 then (date(?)-a.jtempo_angsuran_last)::integer
			      when periode_jangka_waktu = 1 then (date(?)-a.jtempo_angsuran_last)/7::integer
			      when periode_jangka_waktu = 2 then date_part('month', age(date(?), a.jtempo_angsuran_last) )
			      when periode_jangka_waktu = 3 then 1
				end) end)  > 0
				and a.status_rekening=1
		";

		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;
		$param[] = $tanggal_jto;

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_jtempo_angsuran_next_by_schedulle($account_financing_no,$offset)
	{
		$sql = "select tangga_jtempo from mfi_account_financing_schedulle where account_no_financing=? order by tangga_jtempo asc offset $offset limit 1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		if(count($row)>0){
			return $row['tangga_jtempo'];
		}else{
			$sql2 = "select tanggal_jtempo from mfi_account_financing where account_financing_no=?";
			$query2 = $this->db->query($sql2,array($account_financing_no));
			$row2 = $query2->row_array();
			return $row2['tanggal_jtempo'];
		}
	}

	public function get_account_financing_schedulle_by_offset($account_financing_no,$offset)
	{
		$sql = "select * from mfi_account_financing_schedulle where account_no_financing=? order by tangga_jtempo asc offset $offset limit 1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row;
	}

	public function get_account_financing_schedulle_id($account_financing_no,$offset)
	{
		$sql = "select account_financing_schedulle_id from mfi_account_financing_schedulle where account_no_financing=? order by tangga_jtempo asc offset $offset limit 1";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		return $row['account_financing_schedulle_id'];
	}

	public function get_account_financing_schedulle_by_id($account_financing_schedulle_id)
	{
		$sql = "select * from mfi_account_financing_schedulle where account_financing_schedulle_id=?";
		$query = $this->db->query($sql,array($account_financing_schedulle_id));
		$row = $query->row_array();
		return $row;
	}

	public function update_account_financing_schedulle($data,$param)
	{
		$this->db->update('mfi_account_financing_schedulle',$data,$param);
	}

	public function get_account_financing_by_account_financing_no_schedulle($account_financing_no)
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.uang_muka,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.titipan_notaris,
				mfi_account_financing.nominal_taksasi,
				mfi_account_financing.simpanan_wajib_pinjam,
				mfi_account_financing.flag_wakalah,
				mfi_product_financing.rate_margin1,
				mfi_product_financing.rate_margin2,
				mfi_product_financing.rate_simpanan_wajib_pinjam,
				mfi_account_financing.jenis_jaminan_sekunder,
				mfi_account_financing.keterangan_jaminan_sekunder,
				mfi_account_financing.nominal_taksasi_sekunder,
				mfi_account_financing.jumlah_jaminan,
				mfi_account_financing.jumlah_jaminan_sekunder,
				mfi_account_financing.presentase_jaminan,
				mfi_account_financing.presentase_jaminan_sekunder,
				mfi_account_financing.biaya_jasa_layanan,
				mfi_account_financing.counter_angsuran,
				mfi_resort.resort_code,
				mfi_resort.resort_name
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing.product_code
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing.resort_code
				WHERE account_financing_no = ?
				";

		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function get_account_financing_by_account_financing_no($account_financing_no)
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.uang_muka,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.titipan_notaris,
				mfi_account_financing.nominal_taksasi,
				mfi_account_financing.simpanan_wajib_pinjam,
				mfi_account_financing.flag_wakalah,
				mfi_product_financing.rate_margin1,
				mfi_product_financing.rate_margin2,
				mfi_product_financing.rate_simpanan_wajib_pinjam,
				mfi_account_financing.jenis_jaminan_sekunder,
				mfi_account_financing.keterangan_jaminan_sekunder,
				mfi_account_financing.nominal_taksasi_sekunder,
				mfi_account_financing.jumlah_jaminan,
				mfi_account_financing.jumlah_jaminan_sekunder,
				mfi_account_financing.presentase_jaminan,
				mfi_account_financing.presentase_jaminan_sekunder,
				mfi_account_financing.biaya_jasa_layanan,
				mfi_account_financing.counter_angsuran,
				mfi_resort.resort_code,
				mfi_resort.resort_name
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing.product_code
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing.resort_code
				WHERE account_financing_no = ?
				";

		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function update_account_financing($data,$param)
	{
		$this->db->update("mfi_account_financing",$data,$param);
	}

	public function insert_trx_account_financing($data)
	{
		$this->db->insert("mfi_trx_account_financing",$data);
	}

	public function fn_get_saldoawal_kaspetugas($account_cash_code,$date,$type=0)
	{
		$sql = "select fn_get_saldoawal_kaspetugas(?,?,?) as val";
		$query = $this->db->query($sql,array($account_cash_code,$date,$type));
		$row = $query->row_array();
		return $row['val'];
	}

	public function delete_account_financing_schedulle($param2){
		$this->db->delete('mfi_account_financing_schedulle',$param2);
	}

	/* END PENDEBETAN ANGSURAN PEMBIAYAAN **********************************************************/

	public function insert_trx_cm_detail_droping($data)
	{
		$this->db->insert_batch('mfi_trx_cm_detail_droping',$data);
	}


	/****************************************************************************************/	
	// BEGIN KAS PETUGAS
	/****************************************************************************************/

	function get_all_branch()
    {
        $sql = "SELECT * FROM  mfi_branch ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }


	public function datatable_transaksi_kas_petugas($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
						 mfi_trx_gl_cash.trx_gl_cash_id
						,mfi_trx_gl_cash.trx_date
						,mfi_trx_gl_cash.account_cash_code
						,mfi_trx_gl_cash.account_teller_code
						,mfi_trx_gl_cash.trx_gl_cash_type
						,mfi_trx_gl_cash.description
						,mfi_trx_gl_cash.amount
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_cash_code
						 ) as kode_kas_petugas
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_teller_code
						)	as kode_kas_teller	
				FROM
						mfi_trx_gl_cash ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_trx_gl_cash.status=0";
		}else{
			$sql .= "WHERE mfi_trx_gl_cash.status=0";
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_verifikasi_transaksi_kas_petugas($sWhere='',$sOrder='',$sLimit='',$from_date='',$thru_date='')
	{
		$sql = "SELECT
						 mfi_trx_gl_cash.trx_gl_cash_id
						,mfi_trx_gl_cash.trx_date
						,mfi_trx_gl_cash.account_cash_code
						,mfi_trx_gl_cash.account_teller_code
						,mfi_trx_gl_cash.trx_gl_cash_type
						,mfi_trx_gl_cash.description
						,mfi_trx_gl_cash.amount
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_cash_code
						 ) as kode_kas_petugas
						,(SELECT
								mfi_gl_account_cash.account_cash_name
								FROM
								mfi_gl_account_cash
								WHERE account_cash_code = mfi_trx_gl_cash.account_teller_code
						)	as kode_kas_teller	
				FROM
						mfi_trx_gl_cash ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_trx_gl_cash.status=0";
		}else{
			$sql .= "WHERE mfi_trx_gl_cash.status=0";
		}

		$param = array();
		if($from_date!="--" && $thru_date!="--"){
			$sql.=" AND mfi_trx_gl_cash.trx_date between ? and ? ";
			$param[] = $from_date;
			$param[] = $thru_date;
		}

		$sql.=" ORDER BY mfi_trx_gl_cash.trx_date ASC ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	public function get_trx_by_trx_gl_cash_id($trx_gl_cash_id)
	{
		$sql = "SELECT
							*
					FROM
							mfi_trx_gl_cash

				WHERE 
							trx_gl_cash_id = ? "; 

		$query = $this->db->query($sql,array($trx_gl_cash_id));

		return $query->row_array();
	}


   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='0' ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }


   	function get_account_cash_code_by_branch_code($branch_code)
    {
        $sql = "SELECT 
        					mfi_fa.fa_code
        					,mfi_fa.fa_name
        					,mfi_fa.branch_code
        					,mfi_gl_account_cash.account_cash_name
        					,mfi_gl_account_cash.account_cash_code
        					,mfi_gl_account_cash.gl_account_code
				FROM
							mfi_fa
				INNER JOIN mfi_gl_account_cash ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
        		WHERE mfi_fa.branch_code = ? AND account_cash_type='1' ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }	

	public function add_kas_petugas($data)
	{
		$this->db->insert('mfi_trx_gl_cash',$data);
	}
	
	public function edit_kas_petugas($data,$param)
	{
		$this->db->update('mfi_trx_gl_cash',$data,$param);
	}

	public function delete_kas_petugas($param)
	{
		$this->db->delete('mfi_trx_gl_cash',$param);
	}	

	public function update_status_gl_cash($data2,$param)
	{
		$this->db->update('mfi_trx_gl_cash',$data2,$param);
	}

	public function insert_mfi_trx_gl($data)
	{
		$this->db->insert('mfi_trx_gl',$data);
	}

	public function insert_mfi_trx_gl_detail($data3)
	{
		$this->db->insert('mfi_trx_gl_detail',$data3);
	}

	/****************************************************************************************/	
	// END KAS PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TABUNGAN BERENCANA
	/****************************************************************************************/

	public function get_tabungan_berencana_by_cif_no($cif_no)
	{
		$sql = "select 
					mfi_account_saving.*
					,mfi_product_saving.product_name
					,mfi_product_saving.product_code 
				from 
					mfi_account_saving
				left join mfi_product_saving on (mfi_product_saving.product_code = mfi_account_saving.product_code)
				where 
					mfi_product_saving.jenis_tabungan = 1
					and mfi_account_saving.cif_no = ?
					and mfi_account_saving.status_rekening <> 2
			   ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	/**
	* untuk mencari data tabungan berdasarkan cif_no
	* jumlah record yg di return = 1 record
	* @param cif_no
	*/

	public function get_account_saving_by_cif_no($cif_no)
	{
		$sql = "select * from mfi_account_saving where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//Function untuk mencari get grace produk kelompok di tabel mfi_institution
	public function get_grace_periode_kelompok()
	{
		$sql = "select * from mfi_institution";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_produk_by_cif_type0()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '1'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_produk_by_cif_type1()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '0'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function check_account_financing_no($account_financing_no)
	{
		$sql = "select count(*) as num from mfi_account_financing where account_financing_no = ? AND status_rekening='1'";
		$query = $this->db->query($sql,array($account_financing_no));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	public function date_current()
	{
		// $sql = "SELECT date_current from mfi_date_transaction ORDER BY date_current DESC LIMIT 1";
		$sql = "select periode_awal from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);

		$row = $query->row_array();
		return $row['periode_awal'];
	}

	public function get_ajax_produk_by_cif_type_link_edit1()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '0'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_produk_by_cif_type_link_edit0()
	{
		$sql = "SELECT
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_product_financing.insurance_product_code,
				mfi_product_financing.flag_manfaat_asuransi,
				mfi_product_financing.jenis_pembiayaan
				FROM
				mfi_product_financing
				WHERE jenis_pembiayaan = '1'
				";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	//Fungsi Mencari No Registrasi Pembiayaan pada tabel mfi_account_financing_reg
	public function search_no_reg($keyword,$type,$cm_code)
	{
		$sql = "select 
				mfi_account_financing_reg.registration_no,
				mfi_cif.nama, 
				mfi_cif.cif_no, 
				mfi_cm.cm_name 
				from mfi_account_financing_reg 
				inner join mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no and mfi_account_financing_reg.status = '1'
				left join mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				where (upper(mfi_cif.nama) like ? or mfi_account_financing_reg.cif_no like ? or mfi_account_financing_reg.registration_no like ?)";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.$keyword.'%';
		
		if($type!="") {

			$sql 	.= ' and mfi_cif.cif_type = ?';
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

	public function get_ajax_value_from_no_reg($cif_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_cif.branch_code,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.uang_muka,
				mfi_account_financing_reg.peruntukan,
				mfi_account_financing_reg.product_code,
				mfi_product_financing.product_name,
				mfi_account_financing_reg.tanggal_pengajuan
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
        		WHERE mfi_cif.cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function update_status_pengajuan_pembiayaan($data_reg,$param_reg)
	{
		$this->db->update('mfi_account_financing_reg',$data_reg,$param_reg);
	}

	//Fungsi Untuk memanggil status rekening pembiayaan

	
	public function get_status_rekening_from_account_financing($account_financing_no)
	{
		$sql = "SELECT
				status_rekening
				FROM
				mfi_account_financing
				WHERE account_financing_no = ? ";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function datatable_verifikasi_trx_rembug($sWhere='',$sOrder='',$sLimit='',$branch_id='',$branch_code='',$trx_date='')
	{

		$sql = "select 
				mfi_trx_cm_save.trx_cm_save_id
				,mfi_trx_cm_save.infaq
				,mfi_trx_cm_save.kas_awal
				,mfi_trx_cm_save.branch_id
				,mfi_trx_cm_save.cm_code
				,mfi_trx_cm_save.trx_date
				,mfi_trx_cm_save.account_cash_code
				,mfi_trx_cm_save.fa_code
				,mfi_branch.branch_name
				,mfi_branch.branch_code
				,mfi_gl_account_cash.account_cash_name
				,mfi_cm.cm_name
				,mfi_fa.fa_name
				from mfi_trx_cm_save
				left join mfi_branch on mfi_branch.branch_id = mfi_trx_cm_save.branch_id
				left join mfi_gl_account_cash on mfi_gl_account_cash.account_cash_code = mfi_trx_cm_save.account_cash_code
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm_save.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm_save.fa_code
		";

		$param = array();
		if ( $sWhere != "" ){
			$sql .= "$sWhere ";

			if($branch_id!=""){
				$sql .= " AND mfi_trx_cm_save.branch_id = ? ";
				$param[] = $branch_id;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_trx_cm_save.trx_date = ? ";
				$param[] = $trx_date;
			}

		}else{

			if($branch_id!=""){
				$sql .= " WHERE mfi_trx_cm_save.branch_id = ? ";
				$param[] = $branch_id;
			}

			if($trx_date!=""){
				if($branch_id!=""){
					$sql .= " AND ";
				}else{
					$sql .= " WHERE ";
				}
				$sql .= "  mfi_trx_cm_save.trx_date = ? ";
				$param[] = $trx_date;
			}
		}


		if ( $sOrder != "" )
			$sql .= "order by fa_name,cm_name,mfi_trx_cm_save.created_date asc";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function search_branch_by_keyword($keyword)
	{
		$sql = "select * from mfi_branch where branch_name like ? or branch_code like ?";
		$query = $this->db->query($sql,array('%'.$keyword.'%','%'.$keyword.'%'));
		return $query->result_array();
	}

	public function insert_trx_cm_save($data)
	{
		$this->db->insert('mfi_trx_cm_save',$data);
	}

	public function insert_trx_cm_save_detail($data)
	{
		$this->db->insert_batch('mfi_trx_cm_save_detail',$data);
	}

	public function insert_trx_cm_save_berencana($data)
	{
		$this->db->insert_batch('mfi_trx_cm_save_berencana',$data);
	}

	public function get_trx_cm_save_detail($trx_cm_save_id)
	{
		$sql = "select mfi_trx_cm_save_detail.* from mfi_trx_cm_save_detail, mfi_cif 
				where mfi_trx_cm_save_detail.cif_no = mfi_cif.cif_no and
				mfi_trx_cm_save_detail.trx_cm_save_id = ? 
				order by mfi_cif.kelompok::integer asc
				";
		$query = $this->db->query($sql,array($trx_cm_save_id));
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_trx_cm_save_berencana($trx_cm_save_detail_id)
	{
		$sql = "select trx_cm_save_berencana_id,trx_cm_save_detail_id,account_saving_no,amount,frekuensi from mfi_trx_cm_save_berencana where trx_cm_save_detail_id = ?";
		$query = $this->db->query($sql,array($trx_cm_save_detail_id));

		return $query->result_array();
	}

	public function delete_trx_cm_save($param)
	{
		$this->db->delete('mfi_trx_cm_save',$param);
	}

	public function delete_trx_cm_save_berencana($param)
	{
		$this->db->delete('mfi_trx_cm_save_berencana',$param);
	}

	public function delete_trx_cm_save_detail($param)
	{
		$this->db->delete('mfi_trx_cm_save_detail',$param);
	}

	public function get_trx_cm_save_by_param($param)
	{
		$sql = "select * from mfi_trx_cm_save where 
				branch_id = ? and
				cm_code = ? and
				trx_date = ? and 
				account_cash_code = ?
		";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_saldo_tab_sukarela($cif_no)
	{
		$sql = "select tabungan_sukarela from mfi_account_default_balance where cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function update_account_financing_droping($data,$param)
	{
		$this->db->update('mfi_account_financing_droping',$data,$param);
	}

	public function get_account_financing_droping($account_financing_no)
	{
		$sql = "select * from mfi_account_financing_droping where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	/**
	* PROSES JURNAL OTOMATIS
	*/
	public function proses_jurnal_otomatis($from_date,$thru_date)
	{
		$sql = "select fn_proses_jurnal_trx(?, ?)";
		$query = $this->db->query($sql,array($from_date,$thru_date));
	}

	/**
	* PROSES CLOSING
	*/
	public function proses_closing()
	{
		/* do proses closing function */
	}

	//Proses dapatkan account_saving
	public function get_value_lap_rek_tab($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_saving.account_saving_no
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_cif.cif_no like ?
				";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function search_account_deposit_no($keyword='',$cif_type='',$cm_code='')
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_deposit.cif_no,
				mfi_account_deposit.account_deposit_no,
				mfi_account_deposit.product_code,
				mfi_account_deposit.status_rekening,
				mfi_product_deposit.product_name
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE (UPPER(nama) like ? or account_deposit_no like ?)
				";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		if($cif_type!=""){
			$sql .= " and cif_type = ? ";
			$param[] = $cif_type;
		}

		if($cm_code!=""){
			$sql .= " and cm_code = ? ";
			$param[] = $cm_code;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_account_deposit($cif_no)
	{
		$sql = "SELECT account_deposit_no, account_deposit_id FROM mfi_account_deposit WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	public function get_account_saving($cif_no)
	{
		$sql = "SELECT account_saving_no, account_saving_id, product_code FROM mfi_account_saving WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
	}

	//Proses dapatkan account_saving
	public function get_value_lap_rek_dep($cif_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_deposit.account_deposit_no
				FROM
				mfi_account_deposit
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				where mfi_cif.cif_no like ?
				";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	//BEGIN PEMBAYARAN ANGSURAN
	public function get_cif_for_pembayaran_angsuran($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.branch_code,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.counter_angsuran,
				mfi_account_financing.cif_no,
				mfi_product_financing.product_code,
				mfi_product_financing.product_name,
				mfi_account_saving.saldo_memo,
				mfi_account_saving.account_saving_id,
				mfi_branch.branch_id,
				(mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin+mfi_account_financing.cadangan_resiko) AS total_angsuran
				FROM
				mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_account_financing.account_saving_no
				LEFT JOIN mfi_branch ON mfi_branch.branch_code = mfi_account_financing.branch_code
				WHERE mfi_account_financing.account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function get_cif_for_pembayaran_angsuran_non_reguler($account_financing_no)
	{
		$sql = "select
				c.nama, 
				a.account_financing_id, 
				a.branch_code, 
				a.cadangan_resiko, 
				b.angsuran_pokok, 
				b.angsuran_margin, 
				b.angsuran_tabungan,
				a.account_saving_no,
				a.pokok,a.margin,
				a.jangka_waktu,
				a.periode_jangka_waktu,
				a.account_financing_no,
				b.tangga_jtempo as tanggal_jtempo, 
				a.saldo_pokok, 
				a.saldo_catab, 
				a.saldo_margin, 
				e.product_name,
				e.rate_margin2,
				a.product_code, 
				--d.saldo_memo, 
				--d.account_saving_id, 
				b.tanggal_bayar, 
				(b.angsuran_pokok-b.bayar_pokok) bayar_pokok, 
				(b.angsuran_margin-b.bayar_margin) bayar_margin, 
				(b.angsuran_tabungan-b.bayar_tabungan) bayar_tabungan,
				b.bayar_pokok as byr_pokok,
				b.bayar_margin as byr_margin,
				b.account_financing_schedulle_id,
				a.counter_angsuran,
				f.branch_id,
				a.akad_code
				from mfi_account_financing a, mfi_account_financing_schedulle b, mfi_cif c, mfi_product_financing e, mfi_branch f
				where a.account_financing_no=b.account_no_financing and a.cif_no=c.cif_no 
				and a.product_code=e.product_code
				and f.branch_code=a.branch_code
				and b.status_angsuran=0 and a.flag_jadwal_angsuran=0 and a.account_financing_no = ?
				order by b.tangga_jtempo asc limit 1
			   ";
		$query = $this->db->query($sql,array($account_financing_no));

		return $query->row_array();
	}

	public function get_flag_jadwal_angsuran($account_financing_no)
	{
		$sql ="SELECT flag_jadwal_angsuran, saldo_pokok, saldo_margin from mfi_account_financing where account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_flag_jadwal($account_financing_id)
	{
		$sql ="select flag_jadwal_angsuran from mfi_account_financing where account_financing_id = ?";
		$query = $this->db->query($sql,array($account_financing_id));
		$row = $query->row_array();
		return $row['flag_jadwal_angsuran'];
	}
	
	public function insert_mfi_trx_account_financing($data1)
	{
		$this->db->insert('mfi_trx_account_financing',$data1);
	}
	
	public function update_mfi_account_financing($data2,$param2)
	{
		$this->db->update('mfi_account_financing',$data2,$param2);
	}
	
	public function update_mfi_account_saving($data3,$param3)
	{
		$this->db->update('mfi_account_saving',$data3,$param3);
	}
	
	public function insert_mfi_trx_account_tabungan($data4)
	{
		$this->db->insert('mfi_trx_account_saving',$data4);
	}
	
	public function insert_on_mfi_trx_detail($data5)
	{
		$this->db->insert('mfi_trx_detail',$data5);
	}
	
	public function update_on_financing_schedulle($data6,$param6)
	{
		$this->db->update('mfi_account_financing_schedulle',$data6,$param6);
	}

	public function get_trx_sequence($no_rekening)
	{
		$sql = "select max(trx_sequence) as sequence from mfi_trx_detail where account_no = ?";
		$query = $this->db->query($sql,array($no_rekening));
		$row = $query->row_array();
		return $row['sequence'];
	}

	//Verifikasi Transaksi
	public function grid_verifikasi_transaksi_tabungan($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mfi_trx_account_saving.trx_account_saving_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Tabungan' AS jenis_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_saving.trx_saving_type AS keterangan,
				mfi_trx_account_saving.amount AS jumlah,
				mfi_gl_account.account_name,
				mfi_product_saving.product_name,
				mfi_user.fullname,
				mfi_trx_account_saving.reference_no AS no_referensi
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				INNER JOiN mfi_gl_account ON mfi_gl_account.account_code=mfi_trx_account_saving.account_cash_code
				LEFT JOIN mfi_product_saving on mfi_product_saving.product_code=mfi_account_saving.product_code
				LEFT JOIN mfi_user on mfi_user.user_id=mfi_trx_account_saving.created_by::integer
				WHERE mfi_trx_account_saving.account_saving_no LIKE ? AND mfi_trx_account_saving.trx_status !='1' AND mfi_cif.cif_type = '1' ";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function grid_verifikasi_transaksi_pembiayaan($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				mfi_trx_account_financing.trx_account_financing_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Pembiayaan' AS jenis_transaksi,
				mfi_trx_account_financing.trx_date AS tgl_transaksi,
				mfi_trx_account_financing.account_financing_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_financing.trx_financing_type AS keterangan,
				(mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin+mfi_trx_account_financing.catab)*mfi_trx_account_financing.freq AS jumlah,
				mfi_gl_account.account_name,
				mfi_product_financing.product_name,
				mfi_user.fullname,
				mfi_trx_account_financing.reference_no AS no_referensi
				FROM
				mfi_trx_account_financing
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				INNER JOiN mfi_gl_account ON mfi_gl_account.account_code=mfi_trx_account_financing.account_cash_code
				LEFT JOIN mfi_product_financing on mfi_product_financing.product_code=mfi_account_financing.product_code
				LEFT JOIN mfi_user on mfi_user.user_id=mfi_trx_account_financing.created_by::integer
				WHERE mfi_trx_account_financing.account_financing_no LIKE ? AND mfi_trx_account_financing.trx_status !='1' and mfi_trx_account_financing.trx_financing_type='1'";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function grid_verifikasi_transaksi($sidx='',$sord='',$limit_rows='',$start='',$no_rekening='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		// TABUNGAN
		$sql = "SELECT 
				mfi_trx_account_saving.trx_account_saving_id AS id_transaksi,
				mfi_cif.cif_no AS no_cif,
				'Tabungan' AS jenis_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_saving.trx_saving_type AS keterangan,
				mfi_trx_account_saving.amount AS jumlah,
				mfi_trx_account_saving.reference_no AS no_referensi,
				mfi_gl_account.account_name,
				mfi_user.fullname,
				mfi_product_saving.product_name
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				INNER JOiN mfi_gl_account ON mfi_gl_account.account_code=mfi_trx_account_saving.account_cash_code
				LEFT JOIN mfi_product_saving on mfi_product_saving.product_code=mfi_account_saving.product_code
				LEFT JOIN mfi_user on mfi_user.user_id=mfi_trx_account_saving.created_by::integer
				WHERE mfi_trx_account_saving.account_saving_no LIKE ? AND mfi_trx_account_saving.trx_status !='1' ";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		// PEMBIAYAAN
		$sql .=	"UNION ALL
			SELECT 
			mfi_trx_account_financing.trx_account_financing_id AS id_transaksi,
			mfi_cif.cif_no AS no_cif,
			'Pembiayaan' AS jenis_transaksi,
			mfi_trx_account_financing.trx_date AS tgl_transaksi,
			mfi_trx_account_financing.account_financing_no AS no_rekening,
			mfi_cif.nama AS nama_cif,
			mfi_trx_account_financing.trx_financing_type AS keterangan,
			(mfi_trx_account_financing.pokok+mfi_trx_account_financing.margin+mfi_trx_account_financing.catab)*mfi_trx_account_financing.freq AS jumlah,
			mfi_trx_account_financing.reference_no AS no_referensi,
			mfi_gl_account.account_name,
			mfi_user.fullname,
			mfi_product_financing.product_name
			FROM
			mfi_trx_account_financing
			INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
			INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
			INNER JOiN mfi_gl_account ON mfi_gl_account.account_code=mfi_trx_account_financing.account_cash_code
			LEFT JOIN mfi_product_financing on mfi_product_financing.product_code=mfi_account_financing.product_code
			LEFT JOIN mfi_user on mfi_user.user_id=mfi_trx_account_financing.created_by::integer
			WHERE mfi_trx_account_financing.account_financing_no LIKE ? AND mfi_trx_account_financing.trx_status !='1' and mfi_trx_account_financing.trx_financing_type='1' ";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		// SMK
		$sql .=	"UNION ALL
			SELECT 
			mfi_trx_smk.trx_smk_id AS id_transaksi,
			mfi_smk.cif_no AS no_cif,
			'SMK' AS jenis_transaksi,
			mfi_trx_smk.trx_date AS tgl_transaksi,
			mfi_smk.sertifikat_no AS no_rekening,
			mfi_smk.nama AS nama_cif,
			mfi_trx_smk.trx_type AS keterangan,
			-- (case when mfi_trx_smk.trx_type = 0 then 'Pinbuk' else 'Tunai' end) AS keterangan,
			mfi_smk.nominal AS jumlah,
			' - ' no_referensi,
			mfi_gl_account.account_name,
			mfi_user.fullname,
			' - ' product_name
			FROM
			mfi_trx_smk
			LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_smk.cif_no
			AND mfi_cif.cif_type = '1'
			INNER JOIN mfi_smk ON mfi_smk.trx_smk_code = mfi_trx_smk.trx_smk_code
			INNER JOiN mfi_gl_account ON mfi_gl_account.account_code=mfi_trx_smk.account_cash_code
			AND mfi_smk.status = '1'
			LEFT JOIN mfi_user on mfi_user.user_id=mfi_trx_smk.created_by::integer
			WHERE mfi_smk.sertifikat_no LIKE ? AND mfi_trx_smk.trx_status !='1'
			";
		$param[] = "%".$no_rekening."%";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_no_rekening($keyword)
	{
		$sql = "

		SELECT
		mfi_account_financing.account_financing_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'PEMBIAYAAN' AS jenis_transaksi
		FROM
		mfi_account_financing,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_account_financing.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_account_financing.account_financing_no like ?)

		UNION ALL

		SELECT
		mfi_account_saving.account_saving_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'TABUNGAN' AS jenis_transaksi
		FROM
		mfi_account_saving,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_account_saving.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_account_saving.account_saving_no like ?)

		UNION ALL

		SELECT
		mfi_smk.sertifikat_no AS no_rekening,
		mfi_cif.nama AS nama_cif,
		'SMK' AS jenis_transaksi
		FROM
		mfi_smk,mfi_cif 
		WHERE mfi_cif.cif_no = mfi_smk.cif_no
		AND (upper(mfi_cif.nama) like ? or mfi_smk.sertifikat_no like ?)

		";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function aktivasi_transaksi_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}
	
	public function aktivasi_transaksi_financing($data,$param)
	{
		$this->db->update('mfi_trx_account_financing',$data,$param);
	}
	
	public function aktivasi_transaksi_smk($data,$param)
	{
		$this->db->update('mfi_trx_smk',$data,$param);
	}

	public function detail_transaksi_tabungan($id)
	{
		$sql = "SELECT
				mfi_branch.branch_name AS nama_cabang,
				mfi_cif.nama AS nama_cif,
				mfi_trx_account_saving.account_saving_no AS no_rekening,
				mfi_trx_account_saving.trx_saving_type AS tipe_transaksi,
				mfi_trx_account_saving.trx_date AS tgl_transaksi,
				mfi_trx_account_saving.amount AS jumlah,
				mfi_trx_account_saving.reference_no AS no_referensi,
				mfi_trx_account_saving.description AS keterangan
				FROM 
				mfi_trx_account_saving
				INNER JOIN mfi_branch ON mfi_branch.branch_id = mfi_trx_account_saving.branch_id
				INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_trx_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_trx_account_saving.trx_account_saving_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function detail_transaksi_pembiayaan($id)
	{
		$sql = "SELECT
				mfi_branch.branch_name,
				mfi_cif.nama,
				mfi_trx_account_financing.account_financing_no,
				mfi_trx_account_financing.trx_financing_type,
				mfi_trx_account_financing.trx_date,
				mfi_trx_account_financing.jto_date,
				mfi_trx_account_financing.pokok,
				mfi_trx_account_financing.margin,
				mfi_trx_account_financing.catab,
				mfi_trx_account_financing.reference_no,
				mfi_trx_account_financing.tab_wajib,
				mfi_trx_account_financing.tab_sukarela,
				mfi_trx_account_financing.freq,
				mfi_trx_account_financing.description
				FROM
				mfi_trx_account_financing
				INNER JOIN mfi_branch ON mfi_branch.branch_id = mfi_trx_account_financing.branch_id
				INNER JOIN mfi_account_financing ON mfi_account_financing.account_financing_no = mfi_trx_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				WHERE mfi_trx_account_financing.trx_account_financing_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function detail_transaksi_smk($id)
	{
		$sql = "SELECT
				mfi_smk.nama,
				mfi_smk.sertifikat_no,
				mfi_smk.cif_no,
				mfi_smk.nominal,
				mfi_smk.date_issued,
				mfi_trx_smk.account_cash_code,
				mfi_trx_smk.trx_type,
				mfi_trx_smk.setor_tunai,
				mfi_trx_smk.tabungan_wajib,
				mfi_trx_smk.tabungan_kelompok,
				mfi_trx_smk.total,
				mfi_trx_smk.trx_date
				FROM
				mfi_trx_smk
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_smk.cif_no
				INNER JOIN mfi_smk ON mfi_smk.trx_smk_code = mfi_smk.trx_smk_code
				WHERE mfi_trx_smk.trx_smk_id  = ?
				";

		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function get_value_lap_rek_tab_for_cetak($account_saving_no)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_account_saving.account_saving_no
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				WHERE mfi_account_saving.account_saving_no like ?
				";
		$query = $this->db->query($sql,array($account_saving_no));

		return $query->row_array();
	}

	//TRANSAKSI SETORAN POKOK
	public function datatable_trx_setoran_pokok_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_trx_setoran_pokok.trx_id,
				mfi_trx_setoran_pokok.setor_tunai,
				mfi_trx_setoran_pokok.trx_date
				FROM
				mfi_trx_setoran_pokok
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_trx_setoran_pokok.cif_no
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

	public function add_transaksi_setoran_pokok($data)
	{
		$this->db->insert('mfi_trx_setoran_pokok',$data);
	}
	
	public function delete_trx_setoran_pokok($param)
	{
		$this->db->delete('mfi_trx_setoran_pokok',$param);
	}

    public function check_valid_cif_no($cif_no)
    {
        $sql = "SELECT COUNT(*) AS num FROM mfi_trx_setoran_pokok WHERE cif_no = ?";
        $query = $this->db->query($sql,array($cif_no));

        $row = $query->row_array();
        if($row['num']>0){
            return false;
        }else{
            return true;
        }
    }
	//TRANSAKSI SETORAN POKOK

    function cek_trx_kontrol_periode($tanggal)
    {
    	$sql = "select count(*) as num from mfi_trx_kontrol_periode where status = 1 and ? between periode_awal and periode_akhir";
    	$query = $this->db->query($sql,array($tanggal));

    	$row = $query->row_array();
    	if($row['num']>0){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function insert_trx_cm_lwk($data)
    {
    	$this->db->insert('mfi_trx_cm_lwk',$data);
    }

	public function get_review_transaksi($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='')
	{
		$CI = get_instance();
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "select 
				trx_gl_id,
				trx_date,
				voucher_no,
				description,
				voucher_date,
				voucher_ref,
				jurnal_trx_type,
				jurnal_trx_id,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit
				from mfi_trx_gl
				WHERE jurnal_trx_type = 0 ";
		if($from_date!="" && $thru_date!=""){
			$sql .= " AND voucher_date between ? and ? ";
			$param[] = $CI->datepicker_convert(true,$from_date,'/');
			$param[] = $CI->datepicker_convert(true,$thru_date,'/');
			
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
		}else{
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
		}
		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_trx_gl_detail($trx_gl_id)
	{
		$sql = "select * from mfi_trx_gl_detail where trx_gl_id = ? order by trx_sequence asc";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	public function get_detail_review_transaksi($sidx='',$sord='',$limit_rows='',$start='',$trx_gl_id='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select 
				mfi_trx_gl_detail.trx_gl_detail_id
				,mfi_trx_gl_detail.trx_gl_id
				,mfi_trx_gl_detail.account_code
				,mfi_gl_account.account_name
				,mfi_trx_gl_detail.description
				,(case when flag_debit_credit = 'D' then amount else 0 end) debit
				,(case when flag_debit_credit = 'C' then amount else 0 end) credit
				from mfi_trx_gl_detail
				join mfi_gl_account on mfi_trx_gl_detail.account_code = mfi_gl_account.account_code
				where mfi_trx_gl_detail.trx_gl_id = ?
		 ";

		$sql .= "$order $limit";

		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	public function delete_trx_gl_detail($param)
	{
		$this->db->delete('mfi_trx_gl_detail',$param);
	}

	public function delete_trx_gl($param)
	{
		$this->db->delete('mfi_trx_gl',$param);
	}

	public function update_trx_gl($data,$param)
	{
		$this->db->update('mfi_trx_gl',$data,$param);
	}

	public function get_trx_gl_detail_sequence($trx_gl_id)
	{
		$sql = "select (coalesce(trx_sequence,0)+1) as seq from mfi_trx_gl_detail where trx_gl_id = ? order by trx_sequence desc";
		$query = $this->db->query($sql,array($trx_gl_id));
		$row = $query->row_array();

		return $row['seq'];
	}

	public function update_trx_gl_detail($data,$param)
	{
		$this->db->update('mfi_trx_gl_detail',$data,$param);
	}

	public function validate_double_transaction($cm_code,$trx_date)
	{
		$sql = "select count(*) as num from mfi_trx_cm where cm_code = ? and trx_date = ?";
		$query = $this->db->query($sql,array($cm_code,$trx_date));
		$row = $query->row_array();
		if($row['num']==0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_trx_cm_detail_savingplan($data)
	{
		$this->db->insert_batch('mfi_trx_cm_detail_savingplan',$data);
	}

	public function insert_trx_cm_detail_savingplan_account($data)
	{
		$this->db->insert_batch('mfi_trx_cm_detail_savingplan_account',$data);
	}

	public function get_mutasi_by_cif_no($cif_no)
	{
		$sql = "select * from mfi_cif_mutasi where cif_no = ? and status = 1";
		$query = $this->db->query($sql,array($cif_no));
		return $query->row_array();
	}

	public function get_account_code_petugas($account_cash_code)
	{
		$sql = "select gl_account_code from mfi_gl_account_cash where account_cash_code = ?";
		$query = $this->db->query($sql,array($account_cash_code));

		$row = $query->row_array();
		return $row['gl_account_code'];
	}

	public function get_account_code_teller($account_teller_code)
	{
		$sql = "select gl_account_code from mfi_gl_account_cash where account_cash_code = ?";
		$query = $this->db->query($sql,array($account_teller_code));

		$row = $query->row_array();
		return $row['gl_account_code'];
	}

	public function delete_trx_gl_cash($param)
	{
		$this->db->delete('mfi_trx_gl_cash',$param);
	}

	public function fn_create_jurnal_rembug($trx_cm_id)
	{
		$sql = "select fn_proses_jurnal_trx_rembug(?)";
		$query = $this->db->query($sql,array($trx_cm_id));
	}

	public function get_account_financing_by_financing_id($account_financing_id,$is_banmod=0)
	{
		if ($is_banmod==0) {
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.cif_type,
				mfi_pegawai.posisi,
				mfi_pegawai.loker,

				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.jumlah_kewajiban,
				mfi_account_financing_reg.jumlah_angsuran,
				mfi_account_financing_reg.nama_bank,
				mfi_account_financing_reg.no_rekening,
				mfi_account_financing_reg.atasnama_rekening,
				mfi_account_financing_reg.bank_cabang,
				mfi_account_financing_reg.lunasi_ke_kopegtel,
				mfi_account_financing_reg.saldo_kewajiban,
				mfi_account_financing_reg.lunasi_ke_koptel,
				mfi_account_financing_reg.saldo_kewajiban_ke_koptel,
				mfi_account_financing_reg.pengajuan_melalui,
				mfi_account_financing_reg.kopegtel_code,
				mfi_account_financing_reg.pelunasan_ke_kopeg_mana,

				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.simpanan_wajib_pinjam,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.titipan_notaris,
				mfi_account_financing.nominal_taksasi,
				mfi_account_financing.jenis_jaminan_sekunder,
				mfi_account_financing.keterangan_jaminan_sekunder,
				mfi_account_financing.nominal_taksasi_sekunder,
				mfi_account_financing.biaya_jasa_layanan,
				mfi_account_financing.counter_angsuran,
				mfi_jaminan.tipe_developer,
				mfi_jaminan.nama_penjual_individu,
				mfi_jaminan.nomer_ktp,
				mfi_jaminan.nama_pasangan_developer,
				mfi_jaminan.nama_perusahaan,
				mfi_cif.cif_flag,
				mfi_account_financing.amount_proyeksi_keuntungan,
				mfi_akad.jenis_keuntungan
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_pegawai ON mfi_pegawai.nik= mfi_account_financing.cif_no
				INNER JOIN mfi_account_financing_reg on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
				LEFT JOIN mfi_jaminan on mfi_jaminan.registration_no = mfi_account_financing_reg.registration_no
				LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_account_financing.akad_code
				WHERE account_financing_id = ?
				";
		} else {
		$sql = "SELECT 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cif.cif_type,
				'Ketua Pengurus' as posisi,
				mfi_kopegtel.alamat as loker,

				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.jumlah_kewajiban,
				mfi_account_financing_reg.jumlah_angsuran,
				mfi_account_financing_reg.nama_bank,
				mfi_account_financing_reg.no_rekening,
				mfi_account_financing_reg.atasnama_rekening,
				mfi_account_financing_reg.bank_cabang,
				mfi_account_financing_reg.lunasi_ke_kopegtel,
				mfi_account_financing_reg.saldo_kewajiban,
				mfi_account_financing_reg.lunasi_ke_koptel,
				mfi_account_financing_reg.saldo_kewajiban_ke_koptel,
				mfi_account_financing_reg.pengajuan_melalui,
				mfi_account_financing_reg.kopegtel_code,
				mfi_account_financing_reg.pelunasan_ke_kopeg_mana,

				mfi_account_financing.account_financing_id,
				mfi_account_financing.product_code,
				mfi_account_financing.branch_code,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.jangka_waktu,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing_reg_termin.nominal as pokok,
				mfi_account_financing.margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.dana_kebajikan,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.cadangan_resiko,
				mfi_account_financing.biaya_administrasi,
				mfi_account_financing.biaya_asuransi_jiwa,
				mfi_account_financing.biaya_asuransi_jaminan,
				mfi_account_financing.biaya_notaris,
				mfi_account_financing.sumber_dana,
				mfi_account_financing.dana_sendiri,
				mfi_account_financing.dana_kreditur,
				mfi_account_financing.ujroh_kreditur,
				mfi_account_financing.ujroh_kreditur_persen,
				mfi_account_financing.ujroh_kreditur_nominal,
				mfi_account_financing.ujroh_kreditur_carabayar,
				mfi_account_financing.tanggal_pengajuan,
				-- mfi_account_financing.tanggal_akad,
				mfi_account_financing_reg_termin.tgl_rencana_pencairan as tanggal_akad,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.jtempo_angsuran_next,
				mfi_account_financing.rate_margin,
				mfi_account_financing.status_rekening,
				mfi_account_financing.tanggal_lunas,
				mfi_account_financing.status_kolektibilitas,
				mfi_account_financing.status_par,
				mfi_account_financing.account_saving_no,
				mfi_account_financing.sektor_ekonomi,
				mfi_account_financing.peruntukan,
				mfi_account_financing.akad_code,
				mfi_account_financing.program_code,
				mfi_account_financing.flag_jadwal_angsuran,
				mfi_account_financing.nisbah_bagihasil,
				mfi_account_financing.fa_code,
				mfi_account_financing.registration_no,
				mfi_account_financing.angsuran_tab_wajib,
				mfi_account_financing.kreditur_code,
				mfi_account_financing.angsuran_tab_kelompok,
				mfi_account_financing.tanggal_registrasi,
				mfi_account_financing.jenis_jaminan,
				mfi_account_financing.keterangan_jaminan,
				mfi_account_financing.simpanan_wajib_pinjam,
				mfi_account_financing.flag_wakalah,
				mfi_account_financing.titipan_notaris,
				mfi_account_financing.nominal_taksasi,
				mfi_account_financing.jenis_jaminan_sekunder,
				mfi_account_financing.keterangan_jaminan_sekunder,
				mfi_account_financing.nominal_taksasi_sekunder,
				mfi_account_financing.biaya_jasa_layanan,
				mfi_jaminan.tipe_developer,
				mfi_jaminan.nama_penjual_individu,
				mfi_jaminan.nomer_ktp,
				mfi_jaminan.nama_pasangan_developer,
				mfi_jaminan.nama_perusahaan,
				mfi_cif.cif_flag,
				mfi_account_financing.amount_proyeksi_keuntungan,
				mfi_akad.jenis_keuntungan
				FROM mfi_account_financing 
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_pegawai ON mfi_pegawai.nik= mfi_account_financing.cif_no
				LEFT JOIN mfi_kopegtel ON mfi_kopegtel.kopegtel_code=mfi_account_financing.cif_no
				INNER JOIN mfi_account_financing_reg on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
				LEFT JOIN mfi_jaminan on mfi_jaminan.registration_no = mfi_account_financing_reg.registration_no
				INNER JOIN mfi_account_financing_reg_termin ON mfi_account_financing_reg_termin.account_financing_reg_id=mfi_account_financing_reg.account_financing_reg_id
				LEFT JOIN mfi_akad ON mfi_akad.akad_code=mfi_account_financing.akad_code
				WHERE account_financing_id = ? AND mfi_account_financing_reg_termin.status=0
				ORDER BY mfi_account_financing_reg_termin.termin ASC LIMIT 1
				";
		}

		$query = $this->db->query($sql,array($account_financing_id));

		return $query->row_array();
	}

	public function fn_proses_jurnal_tutuptabunganberencana($trx_account_saving_id)
	{
		$sql = "select fn_proses_jurnal_tutuptabunganberencana(?)";
		$query = $this->db->query($sql,array($trx_account_saving_id));
	}

	public function fn_proses_jurnal_kaspetugas($trx_gl_cash_id)
	{
		$sql = "select fn_proses_jurnal_kaspetugas(?)";
		$query = $this->db->query($sql,array($trx_gl_cash_id));
	}

	public function fn_jurnal_trx_saving($trx_account_saving_id,$account_cash_code)
	{
		$sql = "select fn_jurnal_trx_saving(?,?,?)";
		$query = $this->db->query($sql,array($trx_account_saving_id,$this->session->userdata('user_id'),$account_cash_code));
	}

	/**
	* fungsi untuk menjurnal angsuran pembiayaan individu
	* @author : sayyid
	*/
	public function fn_proses_jurnal_angsuran_pyd($account_financing_no)
	{
		$sql = "select fn_proses_jurnal_angsuran_pyd(?)";
		$query = $this->db->query($sql,array($account_financing_no));
	}

	/**
	* get data majelis
	* @author : sayyid
	*/
	public function get_cm_data_by_code($cm_code)
	{
		$sql = "select * from mfi_cm where cm_code=?";
		$query = $this->db->query($sql,array($cm_code));
		return $query->row_array();
	}

	/**
	* get jurnal umum review
	* @author : sayyid
	*/
	public function get_jurnal_umum_rev($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='')
	{
		$CI = get_instance();
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "select 
				trx_gl_id,
				trx_date,
				voucher_no,
				description,
				voucher_date,
				voucher_ref,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
				(select sum(amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit,
				mfi_user.fullname
				from mfi_trx_gl
				left join mfi_user on mfi_user.user_id=mfi_trx_gl.created_by::integer
				where created_by = ?
				";
		$param[] = $this->session->userdata('user_id');
		if($from_date!="" && $thru_date!=""){
			$sql .= " and voucher_date between ? and ? ";
			$param[] = $CI->datepicker_convert(true,$from_date,'/');
			$param[] = $CI->datepicker_convert(true,$thru_date,'/');
		}
		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_jenis_jaminan()
	{
		$sql = "SELECT
				mfi_list_code.code_group,
				mfi_list_code.code_description,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.display_text
				FROM
				mfi_list_code
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_group = mfi_list_code.code_group
				where mfi_list_code.code_group='jaminan' ORDER BY display_sort ASC
			   ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function get_setor_tunai_by_id($trx_account_saving_id)
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id,
				e.product_name,
				(b.saldo_memo-b.saldo_hold-e.saldo_minimal) AS saldo_efektif,
				a.reference_no,
				a.description,
				a.branch_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d,
				mfi_product_saving e
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no AND d.trx_detail_id = a.trx_detail_id 
				AND e.product_code = b.product_code
				AND a.trx_saving_type = 1 AND b.status_rekening = 1 
				AND d.trx_type = 1 AND a.flag_debit_credit = 'C' AND a.trx_account_saving_id = ?
			   ";
		$query = $this->db->query($sql,array($trx_account_saving_id));

		return $query->row_array();
	}
	
	public function get_penarikan_tunai_by_id($trx_account_saving_id)
	{
		$sql = "SELECT
				a.trx_date,
				a.amount,
				a.account_saving_no,
				a.trx_account_saving_id,
				c.cif_no,
				c.nama,
				d.trx_detail_id,
				e.product_name,
				(b.saldo_memo-b.saldo_hold-e.saldo_minimal) AS saldo_efektif,
				a.reference_no,
				a.description,
				a.branch_id
				FROM 
				mfi_trx_account_saving a,
				mfi_account_saving b,
				mfi_cif c,
				mfi_trx_detail d,
				mfi_product_saving e
				WHERE a.account_saving_no = b.account_saving_no 
				AND b.cif_no = c.cif_no AND d.trx_detail_id = a.trx_detail_id 
				AND e.product_code = b.product_code
				AND a.trx_saving_type = 2 AND b.status_rekening = 1 
				AND d.trx_type = 1 AND a.flag_debit_credit = 'D' AND  a.trx_account_saving_id = ?
			   ";
		$query = $this->db->query($sql,array($trx_account_saving_id));

		return $query->row_array();
	}

	public function datatable_rekening_pembiayaan_setup($sWhere='',$sOrder='',$sLimit='')
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
							,mfi_product_financing.flag_scoring
							,mfi_account_financing.account_financing_no
							,mfi_resort.resort_code
							,mfi_resort.resort_name
							,(select count(*) from mfi_account_financing ex where ex.registration_no=mfi_account_financing_reg.registration_no) as financing_is_exist
							,coalesce((select count(*) from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as scoring_exist
							,coalesce((select total_skor from mfi_account_financing_scoring where mfi_account_financing_scoring.registration_no=mfi_account_financing_reg.registration_no),0) as total_skor
							,(SELECT
									mfi_list_code_detail.display_text
								FROM
									mfi_list_code_detail
								WHERE mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.code_value AS integer )
									  AND code_group = 'peruntukan'
							 ) AS display_peruntukan
							,mfi_fa.fa_name
							,mfi_fa.fa_code
				FROM
							mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code=mfi_account_financing_reg.product_code
				LEFT JOIN mfi_account_financing on mfi_account_financing.registration_no = mfi_account_financing_reg.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing_reg.fa_code
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing_reg.resort_code
				";

		if ( $sWhere != "" ){
			$sql .= "$sWhere AND mfi_account_financing_reg.status='1' and (case when mfi_account_financing.status_rekening is null then 0 else mfi_account_financing.status_rekening end) not in(1,2,3,4) ";
			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
			}
		}else{
			$sql .= "WHERE mfi_account_financing_reg.status='1' and (case when mfi_account_financing.status_rekening is null then 0 else mfi_account_financing.status_rekening end) not in(1,2,3,4) ";
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

	public function datatable_pinbuk_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		/*$sql = "select 
				a.trx_detail_id,
				a.account_no as no_rek_tabungan_sumber,
				a.account_no_dest as no_rek_tabungan_tujuan,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=a.account_no) as nama_tabungan_sumber,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=a.account_no_dest) as nama_tabungan_tujuan,
				a.amount,
				a.trx_date
				from mfi_trx_detail a, mfi_cif b, mfi_account_saving
					where a.trx_type=1 and a.trx_account_type=3 and a.cif_no=b.cif_no
					and (a.trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=a.trx_detail_id and b.trx_saving_type=3 and b.trx_status=0) 
					and a.trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=a.trx_detail_id and b.trx_saving_type=4 and b.trx_status=0))
				and a.created_by=?
		       ";*/
		$sql = "select
				trx_detail_id,
				account_no as no_rek_tabungan_sumber,
				account_no_dest as no_rek_tabungan_tujuan,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=account_no) as nama_tabungan_sumber,
				(select b.nama from mfi_cif b,mfi_account_saving c where b.cif_no=c.cif_no and c.account_saving_no=account_no_dest) as nama_tabungan_tujuan,
				amount,
				trx_date
				from mfi_trx_detail
				where trx_type=1 and (trx_account_type=3)
				and (trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=trx_detail_id and b.trx_saving_type=3 and b.trx_status=0) 
				and trx_detail_id in(select b.trx_detail_id from mfi_trx_account_saving b where b.trx_detail_id=trx_detail_id and b.trx_saving_type=4 and b.trx_status=0))";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk='".$branch_code."')";
		}

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($this->session->userdata('user_id')));

		return $query->result_array();
	}



	/* DELETING TRANSACTION SAVING(TABUNGAN) */

	/**
	* GET DATA TRANSAKSI SAVING(TABUNGAN)
	* @author : sayyid
	* date : 25 agustus 2014
	* @param : trx_detail_id
	*/
	public function get_trx_account_saving_by_trx_detail_id($trx_detail_id,$trx_saving_type='')
	{
		$sql = "select trx_account_saving_id,branch_id,account_saving_no,trx_saving_type,flag_debit_credit,trx_date,amount from mfi_trx_account_saving where trx_detail_id=?";
		$param[]=$trx_detail_id;
		if($trx_saving_type!=''){
			$sql.=" and trx_saving_type=?";
			$param[]=$trx_saving_type;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	public function get_trx_account_saving_by_trx_saving_id($trx_account_saving_id,$trx_saving_type='')
	{
		$sql = "select
					trx_account_saving_id,
					branch_id,
					account_saving_no,
					trx_saving_type,
					flag_debit_credit,
					trx_date,amount,
					trx_detail_id
				from mfi_trx_account_saving
				where trx_account_saving_id=?";
		$param[]=$trx_account_saving_id;
		if($trx_saving_type!=''){
			$sql.=" and trx_saving_type=?";
			$param[]=$trx_saving_type;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/**
	* DELETE TRX ACCOUNT SAVING
	* @author : sayyid
	* date : 25 agustus 2014
	*/
	public function delete_trx_account_saving($param)
	{
		$this->db->delete('mfi_trx_account_saving',$param);
	}
	/**
	* DELETE TRX DETAIL
	* @author : sayyid
	* date : 25 agustus 2014
	*/
	public function delete_trx_detail($param)
	{
		$this->db->delete('mfi_trx_detail',$param);
	}

	public function get_product_financing_data_by_code($product_code)
	{
		$sql="select * from mfi_product_financing where product_code=?";
		$query=$this->db->query($sql,array($product_code));
		return $query->row_array();
	}

	/**
	* GET FINANCING SCORING VALUE
	* @author sayyid nurkilah
	*/
	function get_total_scoring_pembiayaan($registration_no)
	{
		$sql="select
				total_skor
			  from
			  	mfi_account_financing_scoring
			  where
			  	registration_no = ?
			";
		$query=$this->db->query($sql,array($registration_no));
		$row=$query->row_array();
		if(count($row)>0){
			return $row['total_skor'];
		}else{
			return 0;
		}
	}

	/**
	* AJAX GET DATA PENGAJUAN BY REGISTRATION NO
	* @author sayyid nurkilah
	*/
	public function get_data_pengajuan_by_registration_no($registration_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.cm_code,
				mfi_cif.nama,
				mfi_cif.panggilan,
				mfi_cif.ibu_kandung,
				mfi_cif.tmp_lahir,
				mfi_cif.tgl_lahir,
				mfi_cif.usia,
				mfi_cif.cif_type,
				mfi_cif.branch_code,
				mfi_account_financing_reg.account_financing_reg_id,
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.amount,
				mfi_account_financing_reg.uang_muka,
				mfi_account_financing_reg.peruntukan,
				mfi_account_financing_reg.product_code,
				mfi_product_financing.product_name,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_resort.resort_code,
				mfi_resort.resort_name
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing_reg.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				LEFT JOIN mfi_resort ON mfi_resort.resort_code=mfi_account_financing_reg.resort_code
        		WHERE mfi_account_financing_reg.registration_no = ?";
		$query = $this->db->query($sql,array($registration_no));

		return $query->row_array();
	}
	

	/**
	* GET SEQUENCE NUMBER OF ACCOUNT SAVING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	public function get_seq_account_saving_no($product_code,$cif_no)
	{
		$sql = "SELECT max(RIGHT(account_saving_no,2)) AS jumlah from mfi_account_saving where product_code = ? and cif_no = ?";
		$query = $this->db->query($sql,array($product_code,$cif_no));

		return $query->row_array();
	}

	/**
	* GET SEQUENCE NUMBER OF ACCOUNT FINANCING NO
	* @author sayyid nurkilah
	* @param product_code
	* @param cif_no
	*/
	public function get_seq_account_financing_no($product_code,$cif_no)
	{
		$sql = "SELECT max(RIGHT(account_financing_no,2)) AS jumlah from mfi_account_financing where product_code = ? and cif_no = ?";
		$query = $this->db->query($sql,array($product_code,$cif_no));

		return $query->row_array();
	}

	/**
	* GET GRACE PERIODE
	* @author sayyid nurkilah
	*/
	public function get_grace_periode()
	{
		$sql = "select grace_period_individu from mfi_institution limit 1";
		$query = $this->db->query($sql);
		$return = $query->row_array();
		return $return['grace_period_individu'];
	}

	/**
	* GET RATE JASA LAYANAN BY CODE
	* @author sayyid nurkilah
	* @param product_code
	*/
	public function get_rate_jasa_layanan($product_code)
	{
		$sql = "select jasa_layanan from mfi_product_financing where product_code=?";
		$query = $this->db->query($sql,array($product_code));
		$return = $query->row_array();
		return isset($return['jasa_layanan'])?$return['jasa_layanan']:0;
	}



	public function get_saldo_memo_tabungan($account_saving)
	{
		$sql = "SELECT saldo_memo FROM mfi_account_saving WHERE account_saving_no = ?";
		$query = $this->db->query($sql,array($account_saving));
		$row = $query->row_array();
		if(isset($row['saldo_memo'])){
			return $row['saldo_memo'];
		}else{
			return 0 ;
		}
	}

	public function get_petugas()
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
						 fa_code
						,fa_name
				FROM
						mfi_fa
				";

			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " WHERE branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_periode_angsuran_by_product_code($product_code)
	{
		$sql = "SELECT periode_angsuran FROM mfi_product_financing WHERE product_code = ?";
		$query = $this->db->query($sql,array($product_code));
		$row = $query->row_array();
		if(isset($row['periode_angsuran'])){
			return $row['periode_angsuran'];
		}else{
			return '';
		}
	}

	public function get_status_pengajuan_pembiayaan($cif_no)
	{
		$sql = "SELECT status FROM mfi_account_financing_reg WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		if(isset($row['status'])){
			$status = $row['status'];
		}else{
			$status = 4;
			// 4 digunakan untuk meng alias bahwa data tidak ada di dalam tabel financing reg
		}
		return array('status'=>$status);
	}

	public function get_status_pembiayaan($cif_no)
	{
		$sql = "SELECT status_rekening FROM mfi_account_financing WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		if(isset($row['status_rekening'])){
			$status_rekening = $row['status_rekening'];
		}else{
			$status_rekening = 2;
			// 4 digunakan untuk meng alias bahwa data tidak ada di dalam tabel financing reg
		}
		return array('status_rekening'=>$status_rekening);
	}

	public function count_data_pengajuan_pembiayaan($cif_no)
	{
		$sql = "SELECT COUNT(*) AS jumlah FROM mfi_account_financing_reg WHERE cif_no = ? AND status=0 ";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		if($row['jumlah']>0){
			$jumlah = $row['jumlah'];
		}else{
			$jumlah = 0;
		}
		return array('jumlah'=>$jumlah);
	}

	public function count_data_pengajuan_pembiayaanade($cif_no)
	{
		$sql = "SELECT COUNT(*) AS jumlah FROM mfi_account_financing_reg WHERE cif_no = ? AND status=0";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		if($row['jumlah']>0){
			$jumlah = $row['jumlah'];
		}else{			
			$sql = "SELECT COUNT(*) AS jumlah FROM mfi_account_financing WHERE cif_no = ? AND status_rekening!=2";
			$query = $this->db->query($sql,array($cif_no));
			$row = $query->row_array();
				if($row['jumlah']>0){
					$jumlah = $row['jumlah'];
				}else{		
					$jumlah = 0;
				}
		}
		return array('jumlah'=>$jumlah);
	}


	function datatable_cetak_ulang_validasi($dWhere='', $sWhere='',$sOrder='',$sLimit='')
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT  b.branch_code, a.*
				FROM mfi_trx_account_saving a, mfi_account_saving b
				WHERE a.account_saving_no=b.account_saving_no
		";
		$param = array();

			if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
				$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
				$param[] = $branch_code;
			}

			if($dWhere['from_date']!="" || $dWhere['to_date']!=""){
				$sql .= " and a.trx_date between ? and ? ";
				$param[] = $dWhere['from_date'];
				$param[] = $dWhere['to_date'];
			}

			if( $dWhere['account_saving_no'] != "" ) {
				$sql .= " and a.account_saving_no like ? ";
				$param[] = '%'.$dWhere['account_saving_no'].'%';
			}

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}else{
			$sql .= " ORDER BY a.trx_date ";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	public function get_data_cetak_ulang_validasi($trx_account_saving_id='')
	{
		$sql = "SELECT  a.*,c.nama
				FROM mfi_trx_account_saving a, mfi_account_saving b, mfi_cif c
				WHERE a.account_saving_no=b.account_saving_no AND b.cif_no=c.cif_no AND a.trx_account_saving_id=? ";
		$query = $this->db->query($sql,array($trx_account_saving_id));

		return $query->row_array();
	}

	public function update_trx_account_saving($data,$param)
	{
		$this->db->update('mfi_trx_account_saving',$data,$param);
	}

	public function update_trx_account_financing($data,$param)
	{
		$this->db->update('mfi_trx_account_financing',$data,$param);
	}

	public function update_trx_detail($data,$param)
	{
		$this->db->update('mfi_trx_detail',$data,$param);
	}

	public function get_trx_detail_id_di_tabungan_by_jurnal_trx_id($jurnal_trx_id)
	{
		$sql = "select trx_detail_id from mfi_trx_account_saving where trx_account_saving_id = ?";
		$query = $this->db->query($sql,array($jurnal_trx_id));
		$row = $query->row_array();
		if(isset($row['trx_detail_id'])==true){
			$trx_detail_id=$row['trx_detail_id'];
		}else{
			$trx_detail_id=false;
		}
		return $trx_detail_id;
	}

	public function get_trx_detail_id_di_pembiayaan_by_jurnal_trx_id($jurnal_trx_id)
	{
		$sql = "select trx_detail_id from mfi_trx_account_financing where trx_account_financing_id = ?";
		$query = $this->db->query($sql,array($jurnal_trx_id));
		$row = $query->row_array();
		if(isset($row['trx_detail_id'])==true){
			$trx_detail_id=$row['trx_detail_id'];
		}else{
			$trx_detail_id=false;
		}
		return $trx_detail_id;
	}

	public function cek_trx_pelunasan($no_rekening,$freq_bayar){
		$sql="select jangka_waktu,counter_angsuran from mfi_account_financing where account_financing_no=?";
		$query=$this->db->query($sql,array($no_rekening));
		$row=$query->row_array();
		$jangka_waktu=$row['jangka_waktu'];
		$counter_angsuran=$row['counter_angsuran'];
		$total_counter_angsuran=$counter_angsuran+$freq_bayar;

		if($total_counter_angsuran!=$jangka_waktu){
			return false; // bukan pelunasan
		}else{
			return true; // adalah pelunasan
		}
	}

	function pembiayaan_same_is_exists($cif_no,$tgl_akad)
	{
		$sql = "select count(*) num from mfi_account_financing where cif_no=? and tanggal_akad=? and status_rekening=0";
		$query = $this->db->query($sql,array($cif_no,$tgl_akad));
		$row = $query->row_array();

		if($row['num']>0){
			return 1;
		}else{
			return 0;
		}
	}

	function pembiayaan_active_is_exists($cif_no)
	{
		$sql = "select count(*) num from mfi_account_financing where cif_no=? and status_rekening=1";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();

		if($row['num']>0){
			return 1; // is exists
		}else{
			return 0; // is not exists
		}
	}

	/*
	*koptel
	*/
	public function get_ajax_value_from_nik($nik)
	{
		$sql = "SELECT
					a.*
					,b.no_ktp
					,b.telpon_seluler
					,b.nama_pasangan
					,b.pekerjaan_pasangan
					,b.jumlah_tanggungan
					,b.status_rumah
					,b.telpon_rumah
					,b.nama_bank
					,b.no_rekening
					,b.atasnama_rekening
					,b.bank_cabang
					,c.kopegtel_code
				FROM mfi_pegawai a
				LEFT JOIN mfi_cif b ON b.cif_no=a.nik
				LEFT JOIN mfi_pegawai_kopegtel c ON c.nik=a.nik
				WHERE a.nik = ?";
		$query = $this->db->query($sql,array($nik));

		return $query->row_array();
	}
	
	public function get_kopegtel($kopegtel=null)
	{
		$isWhere = ($kopegtel!=null) ? "WHERE kopegtel_code='$kopegtel'" : "";
		$sql = "SELECT * FROM mfi_kopegtel $isWhere ORDER BY kopegtel_code ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function update_to_mfi_financing($data,$param)
	{
		$this->db->update('mfi_account_financing',$data,$param);
	}
	/*
	*end koptel
	*/

	function check_data_is_exist()
	{
		$sql = "select count(*) num from mfi_angsuran_temp where status=0";
		$query = $this->db->query($sql,array($file_name));
		$row = $query->row_array();

		if($row['num']>0){
			return true; // is exists
		}else{
			return false; // is not exists
		}
	}

	function insert_mfi_angsuran_temp_tab($datas, $angsuran_id)
	{
		$data = array(
					 'id'			=> uuid(false)
					,'angsuran_id'	=> $angsuran_id
					,'data'			=> json_encode($datas)
					,'created_date'	=> date('Y-m-d H:i:s')
				);
		$this->db->insert('mfi_angsuran_temp_tab',$data);
	}

	function get_mfi_angsuran_temp_tab($angsuran_id)
	{
		$sql = "SELECT * from mfi_angsuran_temp_tab WHERE angsuran_id=? AND status='0'";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query;
	}

	function get_data_angsuran1()
	{
		$sql = "SELECT 
				a.*,
				(select trx_date from mfi_angsuran_temp_detail where angsuran_id=a.angsuran_id group by 1 limit 1) trx_date
			from mfi_angsuran_temp a
			where a.status in(0,1,3)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_data_angsuran()
	{
		$sql = "select * from mfi_angsuran_temp where status=0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_account_financing_by_account($account_financing_no,$jumlah_angsuran)
	{
		$sql = "select account_financing_no,flag_jadwal_angsuran
				from mfi_account_financing
				where account_financing_no=?";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();

		// $result = array();
		// foreach($rows as $row):
		
			$v_flag_jadwal_angsuran = $row['flag_jadwal_angsuran'];
			$v_account_financing_no = $row['account_financing_no'];

			switch ($v_flag_jadwal_angsuran) {
				case '0': // non reguler
					$sql = "
						SELECT 
							a.account_financing_no,
							a.jtempo_angsuran_next,
							a.jangka_waktu,
							a.saldo_pokok,
							a.saldo_margin,
							a.counter_angsuran,
							b.angsuran_pokok,
							b.angsuran_margin,
							a.flag_jadwal_angsuran,
							a.periode_jangka_waktu,
							a.tanggal_jtempo,
							(select tangga_jtempo from mfi_account_financing_schedulle
								where account_no_financing=a.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc
								limit 1 offset 0) as jto_next,
							(select tangga_jtempo from mfi_account_financing_schedulle
								where account_no_financing=a.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc
								limit 1 offset 1) as jto_next2,
							a.jtempo_angsuran_last as jto_last
						FROM mfi_account_financing a
						LEFT JOIN mfi_account_financing_schedulle b ON a.account_financing_no=b.account_no_financing 
							AND b.status_angsuran=0
							AND b.tangga_jtempo in(select tangga_jtempo
										from mfi_account_financing_schedulle 
										where account_no_financing=a.account_financing_no and status_angsuran=0
										order by tangga_jtempo asc 
										limit 1 offset 0)
						WHERE a.account_financing_no = ? AND a.status_rekening=1
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				case '1': // reguler
					$sql = "
						SELECT 
							account_financing_no,
							jtempo_angsuran_next,
							jangka_waktu,
							saldo_pokok,
							saldo_margin,
							counter_angsuran,
							angsuran_pokok,
							angsuran_margin,
							flag_jadwal_angsuran,
							periode_jangka_waktu,
							tanggal_jtempo,
							jtempo_angsuran_next jto_next,
							NULL jto_next2,
							jtempo_angsuran_last jto_last
						FROM mfi_account_financing 
						WHERE account_financing_no = ? AND status_rekening=1
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				default:
					$return = array();
				break;
			}

			// if (count($return)) {

			// 	$result = array(
			// 		'account_financing_no' => $return['account_financing_no']
			// 		,'jtempo_angsuran_next' => $return['jtempo_angsuran_next']
			// 		,'jangka_waktu' => $return['jangka_waktu']
			// 		,'saldo_pokok' => $return['saldo_pokok']
			// 		,'saldo_margin' => $return['saldo_margin']
			// 		,'counter_angsuran' => $return['counter_angsuran']
			// 		,'angsuran_pokok' => $return['angsuran_pokok']
			// 		,'angsuran_margin' => $return['angsuran_margin']
			// 		,'flag_jadwal_angsuran' => $return['flag_jadwal_angsuran']
			// 		,'periode_jangka_waktu' => $return['periode_jangka_waktu']
			// 		,'tanggal_jtempo' => $return['tanggal_jtempo']
			// 		,'jto_next' => $return['jto_next']
			// 		,'jto_next2' => $return['jto_next2']
			// 		,'jto_last' => $return['jto_last']
			// 	);

			// }

		// endforeach;

		return $return;

		// if (count($row)) {
		// 	$flag_jadwal_angsuran = $row['flag_jadwal_angsuran'];

		// 	switch ($flag_jadwal_angsuran) {
		// 		case '0': // non reguler
		// 			$sql = "
		// 				SELECT 
		// 					a.account_financing_no,
		// 					a.jtempo_angsuran_next,
		// 					a.jangka_waktu,
		// 					a.saldo_pokok,
		// 					a.saldo_margin,
		// 					a.counter_angsuran,
		// 					b.angsuran_pokok,
		// 					b.angsuran_margin,
		// 					a.flag_jadwal_angsuran
		// 				FROM mfi_account_financing a
		// 				LEFT JOIN mfi_account_financing_schedulle b ON a.account_financing_no=b.account_no_financing AND b.status_angsuran=0 AND b.tangga_jtempo=a.jtempo_angsuran_next
		// 				WHERE a.cif_no = ? AND a.status_rekening=1
		// 			";
		// 			$query = $this->db->query($sql,array($nik));
		// 			return $query->row_array();
		// 		break;
		// 		case '1': // reguler
		// 			$sql = "
		// 				SELECT 
		// 					account_financing_no,
		// 					jtempo_angsuran_next,
		// 					jangka_waktu,
		// 					saldo_pokok,
		// 					saldo_margin,
		// 					counter_angsuran,
		// 					angsuran_pokok,
		// 					angsuran_margin,
		// 					flag_jadwal_angsuran
		// 				FROM mfi_account_financing 
		// 				WHERE cif_no = ? AND status_rekening=1
		// 			";
		// 			$query = $this->db->query($sql,array($nik));
		// 			return $query->row_array();
		// 		break;
				
		// 		default:
		// 			return array();
		// 		break;
		// 	}
		// } else {
		// 	return array();
		// }
	}

	public function get_account_financing_vItsme($account_financing_no,$trx_date)
	{
		$offset = $freq-1;

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
		return $rows;

	}

	public function get_account_financing_by_nik($nik,$freq=1,$trx_date)
	{
		$offset = $freq-1;

		$sql = "SELECT account_financing_no,flag_jadwal_angsuran
				from mfi_account_financing
				where cif_no=?
				and status_rekening=1
				AND (not (counter_angsuran < 1 AND jtempo_angsuran_next >= (?::date + '1 month'::interval)::date )
					OR (counter_angsuran < 1 AND jtempo_angsuran_next >= (?::date + '1 month'::interval)::date 
					AND created_by='SYS' AND product_code not in('53','54','56','58','99'))
				)
				order by tanggal_akad";
		$query = $this->db->query($sql,array($nik,$trx_date,$trx_date));
		$rows = $query->result_array();

		$result = array();
		foreach($rows as $row):
		
			$v_flag_jadwal_angsuran = $row['flag_jadwal_angsuran'];
			$v_account_financing_no = $row['account_financing_no'];

			switch ($v_flag_jadwal_angsuran) {
				case '0': // non reguler
					$sql = "
						SELECT 
							a.account_financing_no,
							(select tangga_jtempo from mfi_account_financing_schedulle
								where account_no_financing=a.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc
								limit 1 offset $offset) as jtempo_angsuran_next,
							a.jangka_waktu,
							a.saldo_pokok,
							a.saldo_margin,
							a.counter_angsuran,
							b.angsuran_pokok,
							b.angsuran_margin,
							a.flag_jadwal_angsuran,
							a.periode_jangka_waktu,
							a.product_code
						FROM mfi_account_financing a
						LEFT JOIN mfi_account_financing_schedulle b ON a.account_financing_no=b.account_no_financing 
						AND b.status_angsuran=0
						AND b.tangga_jtempo in(select tangga_jtempo
												from mfi_account_financing_schedulle 
												where account_no_financing=a.account_financing_no and status_angsuran=0
												order by tangga_jtempo asc 
												limit 1 offset $offset)
						WHERE a.account_financing_no = ? AND a.status_rekening=1
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				case '1': // reguler
					$sql = "
						SELECT 
							account_financing_no,
							(jtempo_angsuran_next + ' $offset month'::interval)::date jtempo_angsuran_next,
							jangka_waktu,
							saldo_pokok,
							saldo_margin,
							counter_angsuran,
							angsuran_pokok,
							angsuran_margin,
							flag_jadwal_angsuran,
							periode_jangka_waktu,
							product_code
						FROM mfi_account_financing 
						WHERE account_financing_no = ? AND status_rekening=1
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				default:
					$return = array();
				break;
			}

			if (count($return)) {

				$result[] = array(
					'account_financing_no' => $return['account_financing_no']
					,'jtempo_angsuran_next' => $return['jtempo_angsuran_next']
					,'jangka_waktu' => $return['jangka_waktu']
					,'saldo_pokok' => $return['saldo_pokok']
					,'saldo_margin' => $return['saldo_margin']
					,'counter_angsuran' => $return['counter_angsuran']
					,'angsuran_pokok' => $return['angsuran_pokok']
					,'angsuran_margin' => $return['angsuran_margin']
					,'flag_jadwal_angsuran' => $return['flag_jadwal_angsuran']
					,'periode_jangka_waktu' => $return['periode_jangka_waktu']
					,'product_code' => $return['product_code']
				);

			}

		endforeach;

		return $result;

		// if (count($row)) {
		// 	$flag_jadwal_angsuran = $row['flag_jadwal_angsuran'];

		// 	switch ($flag_jadwal_angsuran) {
		// 		case '0': // non reguler
		// 			$sql = "
		// 				SELECT 
		// 					a.account_financing_no,
		// 					a.jtempo_angsuran_next,
		// 					a.jangka_waktu,
		// 					a.saldo_pokok,
		// 					a.saldo_margin,
		// 					a.counter_angsuran,
		// 					b.angsuran_pokok,
		// 					b.angsuran_margin,
		// 					a.flag_jadwal_angsuran
		// 				FROM mfi_account_financing a
		// 				LEFT JOIN mfi_account_financing_schedulle b ON a.account_financing_no=b.account_no_financing AND b.status_angsuran=0 AND b.tangga_jtempo=a.jtempo_angsuran_next
		// 				WHERE a.cif_no = ? AND a.status_rekening=1
		// 			";
		// 			$query = $this->db->query($sql,array($nik));
		// 			return $query->row_array();
		// 		break;
		// 		case '1': // reguler
		// 			$sql = "
		// 				SELECT 
		// 					account_financing_no,
		// 					jtempo_angsuran_next,
		// 					jangka_waktu,
		// 					saldo_pokok,
		// 					saldo_margin,
		// 					counter_angsuran,
		// 					angsuran_pokok,
		// 					angsuran_margin,
		// 					flag_jadwal_angsuran
		// 				FROM mfi_account_financing 
		// 				WHERE cif_no = ? AND status_rekening=1
		// 			";
		// 			$query = $this->db->query($sql,array($nik));
		// 			return $query->row_array();
		// 		break;
				
		// 		default:
		// 			return array();
		// 		break;
		// 	}
		// } else {
		// 	return array();
		// }
	}

	public function get_account_financing_by_no_pembiayaan($account_financing_no,$freq=1,$trx_date)
	{
		$offset = $freq-1;

		$sql = "SELECT account_financing_no,flag_jadwal_angsuran
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

		$result = array();
		foreach($rows as $row):
		
			$v_flag_jadwal_angsuran = $row['flag_jadwal_angsuran'];
			$v_account_financing_no = $row['account_financing_no'];

			switch ($v_flag_jadwal_angsuran) {
				case '0': // non reguler
					$sql = "
						SELECT 
							a.account_financing_no,
							a.product_code,
							(select tangga_jtempo from mfi_account_financing_schedulle
								where account_no_financing=a.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc
								limit 1 offset $offset) as jtempo_angsuran_next,
							a.jangka_waktu,
							a.saldo_pokok,
							a.saldo_margin,
							a.counter_angsuran,
							b.angsuran_pokok,
							b.angsuran_margin,
							a.flag_jadwal_angsuran,
							a.periode_jangka_waktu,
							c.rate_margin2
						FROM mfi_account_financing a
						JOIN mfi_product_financing c ON a.product_code=c.product_code
						LEFT JOIN mfi_account_financing_schedulle b ON a.account_financing_no=b.account_no_financing 
						AND b.status_angsuran=0
						AND b.tangga_jtempo in(select tangga_jtempo
												from mfi_account_financing_schedulle 
												where account_no_financing=a.account_financing_no and status_angsuran=0
												order by tangga_jtempo asc 
												limit 1 offset $offset)
						WHERE a.account_financing_no = ? AND a.status_rekening=1
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				case '1': // reguler
					$sql = "
						SELECT 
							a.account_financing_no,
							a.product_code,
							(a.jtempo_angsuran_next + ' $offset month'::interval)::date jtempo_angsuran_next,
							a.jangka_waktu,
							a.saldo_pokok,
							a.saldo_margin,
							a.counter_angsuran,
							a.angsuran_pokok,
							a.angsuran_margin,
							a.flag_jadwal_angsuran,
							a.periode_jangka_waktu,
							b.rate_margin2
						FROM mfi_account_financing a, mfi_product_financing b
						WHERE a.account_financing_no = ? AND a.status_rekening=1 AND a.product_code=b.product_code
					";
					$query = $this->db->query($sql,array($v_account_financing_no));
					$return = $query->row_array();
				break;
				default:
					$return = array();
				break;
			}

			if (count($return)) {

				$result[] = array(
					'account_financing_no' => $return['account_financing_no']
					,'jtempo_angsuran_next' => $return['jtempo_angsuran_next']
					,'jangka_waktu' => $return['jangka_waktu']
					,'saldo_pokok' => $return['saldo_pokok']
					,'saldo_margin' => $return['saldo_margin']
					,'counter_angsuran' => $return['counter_angsuran']
					,'angsuran_pokok' => $return['angsuran_pokok']
					,'angsuran_margin' => $return['angsuran_margin']
					,'flag_jadwal_angsuran' => $return['flag_jadwal_angsuran']
					,'periode_jangka_waktu' => $return['periode_jangka_waktu']
					,'product_code' => $return['product_code']
					,'rate_margin2' => $return['rate_margin2']
				);

			}

		endforeach;

		return $result;
	}

	public function insert_angsuran_into_mfi_angsuran_temp_detail($data)
	{
		$this->db->insert_batch('mfi_angsuran_temp_detail',$data);
	}

	function jqgrid_verifikasi_pendebetan_angsuran($sidx='',$sord='',$limit_rows='',$start='',$filename='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		/*$sql = "SELECT DISTINCT X.angsuran_detail_id, X.account_financing_no, X.trx_date, X.jto_date, X.created_date, X.created_by, X.freq, X.nik, X.hasil_proses, X.angsuran_id, X.pokok, X.margin, X.nama_pegawai, X.jumlah_bayar, X.jumlah_real FROM (
					SELECT
						a.angsuran_detail_id,
						a.account_financing_no,
						a.trx_date,
						a.jto_date,
						a.created_date,
						a.created_by,
						a.freq,
						a.nik,
						a.hasil_proses,
						a.angsuran_id,
						mfi_angsuran_bayar.jumlah_real,
						(case when d.flag_jadwal_angsuran=1 then 
								a.pokok
							else 
								(select x.angsuran_pokok from mfi_account_financing_schedulle x
									where x.account_no_financing=a.account_financing_no
									and x.status_angsuran=0
									order by x.tangga_jtempo asc limit 1)
							end) pokok,
						(case when d.flag_jadwal_angsuran=1 then 
								a.margin
							else 
								(select y.angsuran_margin from mfi_account_financing_schedulle y
									where y.account_no_financing=a.account_financing_no
									and y.status_angsuran=0
									order by y.tangga_jtempo asc limit 1)
							end) margin,
						c.nama as nama_pegawai,
						mfi_angsuran_bayar.jumlah_bayar
					FROM mfi_angsuran_temp_detail a
					INNER JOIN mfi_cif c on c.cif_no=a.nik
					INNER JOIN mfi_account_financing d on d.account_financing_no=a.account_financing_no
					INNER JOIN mfi_angsuran_bayar on mfi_angsuran_bayar.angsuran_id=a.angsuran_id and mfi_angsuran_bayar.nik=a.nik and a.hasil_proses= mfi_angsuran_bayar.jumlah_bayar
					where a.angsuran_id = ?
				) AS X
			   ";*/

		$sql = "SELECT DISTINCT a.id, a.nik, a.jumlah_bayar, a.account_financing_no, a.offset, a.jumlah_real, b.angsuran_pokok as pokok, b.angsuran_margin as margin, c.nama as nama_pegawai
				FROM mfi_angsuran_bayar a
				INNER JOIN mfi_account_financing b on b.account_financing_no=a.account_financing_no
				INNER JOIN mfi_cif c on c.cif_no=a.nik
				WHERE a.angsuran_id =? ";
		$param[] = $filename;

		$sql .= " ORDER BY a.nik, a.offset ASC $limit ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_mfi_angsuran_bayar($angsuran_id,$account_financing_no)
	{
		$sql = "
			SELECT
				a.id AS angsuran_bayar_id,
				a.account_financing_no,
				a.nik,
				a.jumlah_bayar,
				a.jumlah_real,
				a.offset
			FROM mfi_angsuran_bayar a
			WHERE angsuran_id=? AND account_financing_no=?
		";
		$query = $this->db->query($sql,array($angsuran_id,$account_financing_no));
		return $query->result_array();
	}

	function get_mfi_angsuran_temp_detail($angsuran_id,$account_financing_no)
	{
		$sql = "SELECT * FROM mfi_angsuran_temp_detail a WHERE angsuran_id=? AND account_financing_no=?";
		$query = $this->db->query($sql,array($angsuran_id,$account_financing_no));
		return $query;
	}

	public function insert_angsuran_into_mfi_trx_financing($data)
	{
		$this->db->insert_batch('mfi_trx_account_financing',$data);
	}

	public function insert_angsuran_into_trx_detail($data)
	{
		$this->db->insert_batch('mfi_trx_detail',$data);
	}

	public function delete_from_mfi_angsuran_temp($param)
	{
		$this->db->delete('mfi_angsuran_temp',$param);
	}

	public function delete_from_mfi_angsuran_temp_detail($param)
	{
		$this->db->delete('mfi_angsuran_temp_detail',$param);
	}

	public function delete_from_mfi_angsuran_temp_detail_unins($param)
	{
		$this->db->delete('mfi_angsuran_temp_detail_unins',$param);
	}

	public function get_data_akun()
	{
		$sql = "select * from mfi_gl_account
				where account_type = '1'
				and account_group_code in('11100','11110','11120')
				order by account_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_angsuran_id_from_mfi_angsuran_temp()
	{
		$sql = "select angsuran_id from mfi_angsuran_temp where status=0";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(isset($row['angsuran_id'])){
			return $row['angsuran_id'];
		}else{
			return null;
		}
	}

	function get_excel_id_from_mfi_financing_lunas_temp()
	{
		$sql = "select excel_id from mfi_account_financing_lunas_temp where status=0";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(isset($row['excel_id'])){
			return $row['excel_id'];
		}else{
			return null;
		}
	}

	function trx_angsuran_temp_is_processed()
	{
		$sql = "select count(*) num from mfi_angsuran_temp where status = 1";
		$query = $this->db->query($sql,array($filename,$filename));
		$row = $query->row_array();
		if ($row['num']>0) {
			return true;
		}else{
			return false;
		}
	}

	/**
	* fungsi untuk menjurnal angsuran pembiayaan
	* @author : ujang
	*/
	public function fn_proses_jurnal_angsuran_pyd_koptel($angsuran_id,$akun,$referensi)
	{
		$sql = "select fn_proses_jurnal_angsuran_pyd_koptel(?,?,?)";
		$query = $this->db->query($sql,array($angsuran_id,$akun,$referensi));
	}

	function insert_account_financing_lunas($data)
	{
		$this->db->insert('mfi_account_financing_lunas',$data);
	}

	function get_num_account_financing_lunas($account_financing_no)
	{
		return $this->db->query("SELECT * FROM mfi_account_financing_lunas WHERE account_financing_no='$account_financing_no'");
	}


	
	function get_account_cash()
	{
		// $sql = "select account_code,account_name from mfi_gl_account where account_type='1'";
		$sql = "SELECT account_code,account_name from mfi_gl_account where account_group_code in('11100','11110','11120') ORDER BY 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_file_name_by_file_client_name()
	{
		$sql = "select file_name from mfi_angsuran_temp where status=0";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (count($row)>0) {
			return $row['file_name'];
		} else {
			return '';
		}
	}

	function get_file_name_pelunasan()
	{
		$sql = "select file_name from mfi_account_financing_lunas_temp where status=0";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if (count($row)>0) {
			return $row['file_name'];
		} else {
			return '';
		}
	}


	/**
	* fungsi untuk menjurnal angsuran pembiayaan individu
	* @author : sayyid
	*/
	public function fn_proses_jurnal_angsuran_pyd2($param)
	{
		$sql = "select fn_proses_jurnal_angsuran_pyd2(?)";
		$query = $this->db->query($sql,array($param));
	}


	public function datatable_upload_twp($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT  
					sum(amount) jumlah
					,trx_id
					,description
					,created_date 
					,created_by
				FROM mfi_temp_twp
				WHERE trx_saving_type=1
				";

		if ( $sWhere != "" ){	
			$sql .= "$sWhere ";
		}

		$sql .= " GROUP BY 2,3,4,5 ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_user_by_id($id='')
	{
		$sql = "SELECT fullname FROM mfi_user WHERE user_id=? LIMIT 1";
		$query = $this->db->query($sql,array($id));
		$data = $query->row_array();
		return $data['fullname'];
	}
	
	public function do_verifikasi_twp($trx_id,$account_cash_code,$no_referensi,$deskripsi,$seq)
	{
		ini_set('memory_limit', '-1');
		
		// ASDIK
		$this->validasi_setoran_twp($trx_id);

		/*$sql = "SELECT validasi_setoran_twp(?)";
		$query = $this->db->query($sql,array($trx_id));*/

		$this->verifikasi_twp($trx_id, $no_referensi, $seq);

		// $sql = "SELECT do_verifikasi_twp(?,?,?)";
		// $query = $this->db->query($sql,array($trx_id,$this->session->userdata('user_id'), $seq));

		// DISABLE UPLOAD SALDO AWAL TWP & TDPK, ASDIK
		$sql = "SELECT fn_jurnal_trx_saving_twp_setoran(?,?,?,?,?)"; //tambah deskripsi, adesagita 11-05-2016
		$query = $this->db->query($sql,array($trx_id,$this->session->userdata('user_id'),$account_cash_code,$no_referensi,$deskripsi));

		$sql = "DELETE FROM mfi_temp_twp WHERE trx_id=? AND status=0 ";
		$query = $this->db->query($sql,array($trx_id));

		return $query;
	}
	
	public function validasi_setoran_twp($trx_id)
	{
		$query = $this->db->query("SELECT a.id FROM mfi_temp_twp a, mfi_pegawai b WHERE a.nik=b.nik AND a.trx_id='$trx_id' AND a.flag_debit_credit='C'");
		$rows = $query->result_array();
		foreach($rows as $row)
		{
			$id = $row['id'];
			$this->db->query("UPDATE mfi_temp_twp SET status=0 WHERE id='$id'");
		}
	}

	public function verifikasi_twp($trx_id, $no_referensi, $seq)
	{
		$user_id = $this->session->userdata('user_id');
		$query = $this->db->query("
						SELECT a.id, a.amount, a.description, a.trx_date, a.trx_id, a.flag_debit_credit, a.trx_saving_type, a.nik, a.product_code, a.saldo_twp_rev, a.saldo_tdpk_rev,
						       -- INI UNTUK TDPK DAN UPLOAD SALDO AWAL TWP & TDPK, ASDIK
						       --(SELECT count(*) FROM mfi_account_saving WHERE cif_no=a.nik AND product_code='03') as jml_account_2,
						       (SELECT count(*) FROM mfi_account_saving WHERE cif_no=a.nik AND product_code='01') as jml_account_1
						FROM mfi_temp_twp a
						WHERE a.status=0 AND a.trx_id='$trx_id' AND a.amount>0 AND a.nik<>''");
		$rows = $query->result_array();
		foreach($rows as $row)
		{
			$v_product_code = $row['product_code'];
			// INSERT NEW ACCOUNT IF ACCOUNT IS UNDEFINED
			// INI UNTUK TDPK DAN UPLOAD SALDO AWAL TWP & TDPK, ASDIK
			// if($row['jml_account_1']==0 || $row['jml_account_2']==0){
			if($row['jml_account_1']==0){
				
				$v_new_account_saving_no = '10000'.$row['nik'].$v_product_code.'00';
				$data1 = array(
							"product_code" 		=> $v_product_code
						   ,"cif_no" 			=> $row['nik']
						   ,"account_saving_no" => $v_new_account_saving_no
						   ,"branch_code" 		=> '10000'
						   ,"status_rekening" 	=> 1
						   ,"saldo_riil" 		=> 0
						   ,"saldo_memo" 		=> 0
						   ,"saldo_twp_rev" 	=> $row['saldo_twp_rev']
						   ,"saldo_tdpk_rev" 	=> $row['saldo_tdpk_rev']
						 );

				$this->db->insert('mfi_account_saving', $data1);

			}

			// INSERT TRX DETAIL
			$v_trx_detail_id = $row['id'];
			$v_nik = $row['nik'];
			$v_created_date = date("Y-m-d H:i:s");

			$query2 = $this->db->query("SELECT account_saving_no FROM mfi_account_saving WHERE cif_no='$v_nik' AND product_code='$v_product_code'");
			$rows2 = $query2->row();
			$account_saving_no = $rows2->account_saving_no;

			$data2 = array(
						"trx_detail_id" => $v_trx_detail_id
					   ,"trx_type" => 1
					   ,"trx_account_type" => 1
					   ,"account_no" => $account_saving_no
					   ,"flag_debit_credit" => $row['flag_debit_credit']
					   ,"amount" => $row['amount']
					   ,"trx_date" => $row['trx_date']
					   ,"description" => $row['description']
					   ,"created_by" => $user_id
					   ,"created_date" => $v_created_date
					   ,"status_saldo_twp" => 0
					 );

			$this->db->insert('mfi_trx_detail', $data2);

			// INSERT TRX SAVING
			$v_trx_account_saving_id = $row['id'];

			$data3 = array(
						"trx_account_saving_id" => $v_trx_account_saving_id
					   ,"account_saving_no" => $account_saving_no
					   ,"branch_id" => '2c078d4f884446d8af5ed2b5d7633c5c'
					   ,"trx_saving_type" => $row['trx_saving_type']
					   ,"flag_debit_credit" => $row['flag_debit_credit']
					   ,"amount" => $row['amount']
					   ,"reference_no" => $no_referensi
					   ,"description" => $row['description']
					   ,"trx_date" => $row['trx_date']
					   ,"created_date" => $v_created_date
					   ,"trx_status" => 1
					   ,"created_by" => $user_id
					   ,"trx_detail_id" => $v_trx_detail_id
					   ,"seq" => $seq
					 );


			$this->db->insert('mfi_trx_account_saving', $data3);

			// UPDATE SALDO TWP PER NIK
			$v_amount = $row['amount'];
			$this->db->query("UPDATE mfi_account_saving SET saldo_riil=(saldo_riil+$v_amount), saldo_memo=(saldo_memo+$v_amount) WHERE cif_no='$v_nik' AND product_code='$v_product_code';");
		}
	}

	public function do_delete_verifikasi_twp($param)
	{
		$this->db->delete('mfi_temp_twp',$param);
	}

	public function datatable_upload_penarikan_twp($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT  
					count(*) jumlah
					,trx_id
					,description
					,created_date 
					,created_by
				FROM mfi_temp_twp
				WHERE trx_saving_type=2
				GROUP BY 2,3,4,5
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
	
	public function do_verifikasi_penarikan_twp($trx_id,$account_cash_code,$no_referensi)
	{
		$sql = "SELECT validasi_penarikan_twp(?,?)";
		$query = $this->db->query($sql,array($trx_id,$this->session->userdata('user_id')));

		$sql = "SELECT fn_jurnal_trx_saving_twp_penarikan(?,?,?,?)";
		$query = $this->db->query($sql,array($trx_id,$this->session->userdata('user_id'),$account_cash_code,$no_referensi));

		$sql = "SELECT do_verifikasi_penarikan_twp(?,?)";
		$query = $this->db->query($sql,array($trx_id,$this->session->userdata('user_id')));

		$sql = "DELETE FROM mfi_temp_twp WHERE status=0 AND trx_id=?";
		$query = $this->db->query($sql,array($trx_id));

		return $query;
	}
	
	public function do_delete_verifikasi_penarikan_twp($param)
	{
		$this->db->delete('mfi_temp_twp',$param);
	}
	
	public function select_code_twp()
	{
		$sql = "SELECT code_value FROM mfi_list_code_detail WHERE code_group='produktwp';";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data['code_value'];
	}

	function get_product_financing_by_banmod()
	{
		$sql = "select b.product_code,b.product_name,b.nick_name,b.rate_margin1,b.rate_margin2
				from mfi_list_code_detail a, mfi_product_financing b
				where a.code_group='produkbanmod' and a.code_value=b.product_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_peruntukan_by_banmod()
	{
		$sql = "select a.code_value,a.display_text,b.code_value as akad_code
				from mfi_list_code_detail a, mfi_list_code_detail b
				where a.code_group='peruntukanbanmod' and b.code_group='peruntukan' and
				a.code_value::integer=b.display_sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	/**
	* CEK CIF IF EXIST BY PENGAJUAN PEMBIAYAAN BANMOD
	*/
	function cek_cif_if_exist_by_kopegtel($kopegtel_code)
	{
		$sql = "select count(*) as num from mfi_cif where cif_flag=1 and cif_no=?";
		$query = $this->db->query($sql,array($kopegtel_code));
		$row = $query->row_array();
		return $row['num'];
	}

	function get_akad()
	{
		$sql = "select akad_code,akad_name,jenis_keuntungan from mfi_akad where type_product='2' order by akad_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_account_financing_reg_termin_id($account_financing_reg_id)
	{
		$sql = "select account_financing_reg_termin_id,termin
				from mfi_account_financing_reg_termin
				where account_financing_reg_id=? and status=0
				order by termin asc limit 1;
				";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		return $query->row_array();
	}

	function insert_unins_angsuran_pembiayaan($data)
	{
		$this->db->insert_batch('mfi_angsuran_temp_detail_unins',$data);
	}

	function get_angsuran_unins($angsuran_id)
	{
		$sql = "select * from mfi_angsuran_temp_detail_unins where angsuran_id=?";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	function get_lunas_gagal($excel_id)
	{
		$sql = "SELECT distinct X.nik, X.nama, X.excel_id FROM (select id, nik, nama, excel_id from mfi_account_financing_lunas_gagal where excel_id=?) AS X";
		$query = $this->db->query($sql,array($excel_id));
		return $query->result_array();
	}

	function get_log_trx_pendebetan($trx_date,$angsuran_id='')
	{
		$sql = "select * from mfi_log_trx_pendebetan where trx_date=?";
		$param[] = $trx_date;
		if ($angsuran_id!="") {
			$sql .= " and angsuran_id=?";
			$param[] = $angsuran_id;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_nama_by_cif_no($cif_no)
	{
		$sql = "select nama from mfi_cif where cif_no=?";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		return @$row['nama'];
	}

	function insert_log_trx_pendebetan($data)
	{
		$this->db->insert_batch('mfi_log_trx_pendebetan',$data);
	}

	function get_account_twp_by_cif($cif_no)
	{
		$sql = "select account_saving_no from mfi_account_saving where product_code='01'";
		$query = $this->db->query($sql,array($cif_no));
		$row = $query->row_array();
		if (isset($row['account_saving_no'])) {
			return $row['account_saving_no'];
		} else {
			return $cif_no;
		}
	}

	function get_trx_account_financing_by_trx_id($trx_id)
	{
		$sql = "SELECT * from mfi_trx_account_financing where trx_account_financing_id=?";
		$query=$this->db->query($sql,array($trx_id));
		return $query->row_array();
	}

	function get_trx_account_saving_by_trx_id($trx_id)
	{
		$sql = "select * from mfi_trx_account_saving where trx_account_saving_id=?";
		$query=$this->db->query($sql,array($trx_id));
		return $query->row_array();
	}

	function get_account_financing_schedulle_active($account_financing_no,$tanggal_jtempo)
	{
		$sql1 = "SELECT * from mfi_account_financing_schedulle where account_no_financing=? and tangga_jtempo = ? and status_angsuran=0";
		$query1 = $this->db->query($sql1,array($account_financing_no,$tanggal_jtempo));
		if($query1->num_rows() > 0)
        {
        	return $query1->row_array();	
        }else{
        	$sql2 = "SELECT * from mfi_account_financing_schedulle where account_no_financing=? and status_angsuran=0 ORDER BY tangga_jtempo ASC LIMIT 1";
        	$query2 = $this->db->query($sql2,array($account_financing_no));
        	return $query2->row_array();
        }
	}

	function get_niks_by_angsuran_temp_detail($angsuran_id)
	{
		$sql = "
			select nik, hasil_proses
			from mfi_angsuran_temp_detail 
			where angsuran_id=?
			group by nik, hasil_proses
		";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	function get_angsuran_id_by_namafile($namafile)
	{
		$sql = "select angsuran_id from mfi_angsuran_temp where file_client_name=?";
		$query = $this->db->query($sql,array($namafile));
		$return = $query->row_array();
		if (count($return)>0)
			return $return['angsuran_id'];
		else 
			return '';
	}

	function sisir_pembiayaan1($angsuran_id,$_offset=1,$trx_date)
	{
		$offset = $_offset-1;
		$sql = "
			SELECT 
				a.id AS angsuran_bayar_id,
				a.nik,
				a.jumlah_bayar,
				b.account_financing_no,
				(case when b.flag_jadwal_angsuran=1 then 
					b.angsuran_pokok
						else 
					(select angsuran_pokok from mfi_account_financing_schedulle
						where account_no_financing=b.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) pokok,
				(case when b.flag_jadwal_angsuran=1 then 
					b.angsuran_margin
						else 
					(select angsuran_margin from mfi_account_financing_schedulle
						where account_no_financing=b.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) margin,
				(case when b.flag_jadwal_angsuran=1 then 
					b.jtempo_angsuran_next
						else 
					(select tangga_jtempo from mfi_account_financing_schedulle
						where account_no_financing=b.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) jtempo_angsuran_next
			FROM mfi_angsuran_bayar a, mfi_account_financing b
			WHERE a.angsuran_id=? AND a.nik=b.cif_no AND b.status_rekening=1
			AND a.jumlah_bayar = (case when b.flag_jadwal_angsuran=1 then 
									(b.angsuran_pokok+b.angsuran_margin) 
										else 
									(select (angsuran_pokok+angsuran_margin) from mfi_account_financing_schedulle
										where account_no_financing=b.account_financing_no
										and status_angsuran=0
										order by tangga_jtempo asc limit 1 offset $offset)
								 end)
			AND (not (b.counter_angsuran <= 1 AND b.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
					OR (b.counter_angsuran <= 1 AND b.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
					AND b.created_by='SYS' AND b.product_code not in('53','54','56','58','99'))
				)
		";
		$trx_date = explode('-',$trx_date);
		$trx_date = @$trx_date[0].'-'.@$trx_date[1].'-01';
		$query = $this->db->query($sql,array($angsuran_id,$trx_date,$trx_date));
		return $query->result_array();
	}

	function sisir_pembiayaan2($angsuran_id,$trx_date)
	{
		$sql = "
			SELECT 
				a.id AS angsuran_bayar_id,
				a.nik,
				a.jumlah_bayar
			FROM mfi_angsuran_bayar a
			WHERE a.status=0 AND a.angsuran_id=? AND a.jumlah_bayar = (
					select 
						sum((case when a1.flag_jadwal_angsuran=1 then 
							(a1.angsuran_pokok+a1.angsuran_margin) 
								else 
							(select (angsuran_pokok+angsuran_margin) from mfi_account_financing_schedulle
								where account_no_financing=a1.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc limit 1)
						end))
					from mfi_account_financing a1
					where a1.cif_no=a.nik and a1.status_rekening=1
					and (not (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
						OR (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a1.created_by='SYS' AND a1.product_code not in('53','54','56','58','99')))
				)
			and (
				select count(*) from mfi_account_financing a1
				where a1.cif_no=a.nik and a1.status_rekening=1
				and (not (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
					OR (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a1.created_by='SYS' AND a1.product_code not in('53','54','56','58','99'))
					)
			) > 1
		";
		$trx_date = explode('-',$trx_date);
		$trx_date = @$trx_date[0].'-'.@$trx_date[1].'-01';
		$query = $this->db->query($sql,array($angsuran_id,$trx_date,$trx_date,$trx_date,$trx_date));
		return $query->result_array();
	}

	function sisir_pembiayaan3($angsuran_id,$trx_date)
	{
		$sql = "
			SELECT
				a.id AS angsuran_bayar_id,
				a.nik,
				(a.jumlah_bayar/(
					select 
						sum((case when a1.flag_jadwal_angsuran=1 then 
							(a1.angsuran_pokok+a1.angsuran_margin) 
								else 
							(select (angsuran_pokok+angsuran_margin) from mfi_account_financing_schedulle
								where account_no_financing=a1.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc limit 1)
						end))
					from mfi_account_financing a1
					where a1.cif_no=a.nik and a1.status_rekening=1
					and (not (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
						OR (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a1.created_by='SYS' AND a1.product_code not in('53','54','56','58','99'))
					)
				)) freq
			FROM mfi_angsuran_bayar a
			WHERE a.status=0 AND a.angsuran_id=?
			AND (a.jumlah_bayar%(
					select 
						sum((case when a1.flag_jadwal_angsuran=1 then 
							(a1.angsuran_pokok+a1.angsuran_margin) 
								else 
							(select (angsuran_pokok+angsuran_margin) from mfi_account_financing_schedulle
								where account_no_financing=a1.account_financing_no
								and status_angsuran=0
								order by tangga_jtempo asc limit 1)
						end))
					from mfi_account_financing a1
					where a1.cif_no=a.nik and a1.status_rekening=1
					and (not (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
						OR (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a1.created_by='SYS' AND a1.product_code not in('53','54','56','58','99'))
					)
				))=0
			and (a.jumlah_bayar/(
				select 
					sum((case when a1.flag_jadwal_angsuran=1 then 
						(a1.angsuran_pokok+a1.angsuran_margin) 
							else 
						(select (angsuran_pokok+angsuran_margin) from mfi_account_financing_schedulle
							where account_no_financing=a1.account_financing_no
							and status_angsuran=0
							order by tangga_jtempo asc limit 1)
					end))
				from mfi_account_financing a1
				where a1.cif_no=a.nik and a1.status_rekening=1
				and (not (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
					OR (a1.counter_angsuran <= 1 AND a1.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a1.created_by='SYS' AND a1.product_code not in('53','54','56','58','99'))
				)
			)) > 1
		";
		$trx_date = explode('-',$trx_date);
		$trx_date = @$trx_date[0].'-'.@$trx_date[1].'-01';
		$query = $this->db->query($sql,array($trx_date,$trx_date,$angsuran_id,$trx_date,$trx_date,$trx_date,$trx_date));
		return $query->result_array();
	}

	function sisir_pembiayaan4($angsuran_id)
	{
		$sql = "
			SELECT
				a.id AS angsuran_bayar_id,
				a.account_financing_no,
				a.nik,
				a.jumlah_bayar,
				a.offset
			FROM mfi_angsuran_bayar a
			WHERE status=0 AND angsuran_id=?
		";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	function get_account_financing_by_nik_v2($nik,$trx_date,$freq=1)
	{
		// untuk menghitung offset
		// jika freq 1 maka offset 0
		$offset = $freq - 1;
		$sql = "
			SELECT
				a.account_financing_no,
				(case when a.flag_jadwal_angsuran=1 then 
					a.angsuran_pokok
						else 
					(select angsuran_pokok from mfi_account_financing_schedulle
						where account_no_financing=a.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) pokok,
				(case when a.flag_jadwal_angsuran=1 then 
					a.angsuran_margin
						else 
					(select angsuran_margin from mfi_account_financing_schedulle
						where account_no_financing=a.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) margin,
				(case when a.flag_jadwal_angsuran=1 then
					(a.jtempo_angsuran_last + ' $offset month'::interval)::date
						else
					(select tangga_jtempo from mfi_account_financing_schedulle
						where account_no_financing=a.account_financing_no
						and status_angsuran=0
						order by tangga_jtempo asc limit 1 offset $offset)
				end) as jtempo_angsuran_next
			FROM mfi_account_financing a
			WHERE a.cif_no=?
			AND a.status_rekening=1
			AND (not (a.counter_angsuran <= 1 AND a.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date )
				OR (a.counter_angsuran <= 1 AND a.jtempo_angsuran_last >= (?::date + '1 month'::interval)::date 
						AND a.created_by='SYS' AND a.product_code not in('53','54','56','58','99'))
			)
		";
		$trx_date = explode('-',$trx_date);
		$trx_date = @$trx_date[0].'-'.@$trx_date[1].'-01';
		$query = $this->db->query($sql,array($nik,$trx_date,$trx_date));
		return $query->result_array();
	}

	function get_angsuran_temp_by_id($angsuran_id)
	{
		$sql = "
			select * from mfi_angsuran_temp_detail
			where angsuran_id=? order by nik,account_financing_no,jto_date asc
		";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	function get_log_payed_data($angsuran_id,$trx_date)
	{
		$sql = "
			select
				? as trx_date,
				a.nik,
				b.nama,
				a.jumlah_bayar,
				a.jumlah_settle as jumlah_angsuran,
				a.angsuran_id
			from mfi_angsuran_bayar a, mfi_cif b
			where a.nik=b.cif_no and a.angsuran_id=?
			and (select count(*) from mfi_log_trx_pendebetan where angsuran_id=a.angsuran_id) = 0
		";
		$query = $this->db->query($sql,array($trx_date,$angsuran_id));
		return $query->result_array();
	}


	public function get_cif_pengajuan_pelunasan($account_financing_no)
	{
		$sql = "select
				c.cif_no, 
				c.nama, 
				a.account_financing_id, 
				a.branch_code, 
				b.angsuran_pokok, 
				(b.angsuran_pokok*a.counter_angsuran) as jumlah_pembayaran, 
				(b.angsuran_margin*a.counter_angsuran) as potongan_margin, 
				(b.angsuran_pokok-b.bayar_pokok) bayar_pokok, 
				(b.angsuran_margin-b.bayar_margin) bayar_margin, 
				b.bayar_pokok as byr_pokok,
				b.bayar_margin as byr_margin,
				b.angsuran_margin, 
				a.account_financing_no,
				a.pokok,
				a.tanggal_akad,
				a.jtempo_angsuran_last,
				a.saldo_pokok, 
				a.saldo_catab, 
				a.saldo_margin, 
				e.product_name, 
				a.counter_angsuran,
				d.branch_id
				from mfi_account_financing a, mfi_account_financing_schedulle b, mfi_cif c, mfi_product_financing e, mfi_branch d
				where a.account_financing_no=b.account_no_financing and a.cif_no=c.cif_no 
				and a.product_code=e.product_code
				and d.branch_code=a.branch_code
				and b.status_angsuran=0 and a.flag_jadwal_angsuran=0 and a.account_financing_no = ?
				order by b.tangga_jtempo asc limit 1
			   ";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_cif_pengajuan_pelunasan_reguler($account_financing_no)
	{
		$sql = "SELECT
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_financing.account_financing_id,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.branch_code,
				mfi_account_financing.angsuran_pokok,
				(mfi_account_financing.angsuran_pokok*mfi_account_financing.counter_angsuran) as jumlah_pembayaran, 
				(mfi_account_financing.angsuran_margin*mfi_account_financing.counter_angsuran) as potongan_margin, 
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.angsuran_catab,
				mfi_account_financing.account_financing_no,
				mfi_account_financing.pokok,
				mfi_account_financing.tanggal_akad,
				mfi_account_financing.jtempo_angsuran_last,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_catab,
				mfi_account_financing.saldo_margin,
				mfi_product_financing.product_name,
				mfi_account_financing.counter_angsuran,
				mfi_branch.branch_id
				FROM
				mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing.product_code
				LEFT JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_account_financing.account_saving_no
				LEFT JOIN mfi_branch ON mfi_branch.branch_code = mfi_account_financing.branch_code
				WHERE mfi_account_financing.account_financing_no = ? AND mfi_account_financing.flag_jadwal_angsuran=1";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_akad_pembiayaan($account_financing_no)
	{
		$sql = "SELECT akad_code FROM mfi_account_financing WHERE account_financing_no = ?";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_otorisasi_pengajuan($id)
	{
		$sql = "SELECT
				mfi_account_financing_lunas_part.id,
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_account_financing.account_financing_no,
				mfi_product_financing.product_name,
				mfi_account_financing.pokok,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.tanggal_jtempo,
				mfi_account_financing.counter_angsuran,
				mfi_account_financing_lunas_part.saldo_pokok,
				mfi_account_financing_lunas_part.saldo_margin,
				mfi_account_financing_lunas_part.bayar_pokok,
				mfi_account_financing_lunas_part.bayar_margin,
				mfi_account_financing_lunas_part.potongan_margin,
				mfi_account_financing_lunas_part.pengajuan_pengurangan
				FROM
				mfi_account_financing_lunas_part
				INNER JOIN mfi_account_financing ON mfi_account_financing_lunas_part.account_financing_no = mfi_account_financing.account_financing_no
				INNER JOIN mfi_cif ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				WHERE mfi_account_financing_lunas_part.id = ?
		  	   ";
		$query = $this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function get_summary_saldo_kewajiban($nik)
	{
		$sql = "select sum(saldo_pokok) total_saldo from mfi_account_financing where status_rekening=1 and cif_no = ?";
		$query = $this->db->query($sql,array($nik));
		return $query->row_array();
	}

	function jumlah_kewajiban($nik){
		$sql = "SELECT
				SUM(a.angsuran_pokok + a.angsuran_margin) AS total_koptel
				FROM mfi_account_financing AS a, mfi_pegawai AS b
				WHERE a.cif_no = b.nik AND a.status_rekening = '1'
				AND b.nik = ?";

		$param = array($nik);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function jumlah_kewajiban_for_angsuran($nik)
	{

		$sql = "select
		         SUM(a.angsuran_pokok + a.angsuran_margin) AS total_bayar
				from
				 mfi_account_financing AS a, mfi_pegawai AS b
				where
				a.cif_no = b.nik AND (b.nik = '$nik') AND
				a.status_rekening = 1 AND
				a.account_financing_no NOT IN (SELECT account_financing_no FROM mfi_account_financing_lunas)";
		$query = $this->db->query($sql);
		return $query->row();

	}

	public function get_list_saldo($nik,$account_financing_no=null)
	{
		$param = array();
		$sql = "select 
				a.registration_no,
				a.angsuran_pokok,
				a.angsuran_margin,
				a.saldo_pokok,
				a.saldo_margin,
				a.account_financing_no,
				a.jangka_waktu,
				a.counter_angsuran,
				b.product_name,
				(select count(*) from mfi_account_financing_reg_lunas where account_financing_no=a.account_financing_no) as is_checked
				from mfi_account_financing a
				left join mfi_product_financing b on (a.product_code = b.product_code)
				where a.status_rekening=1
			   ";
		if ( $nik != "" ) {
			$sql .= " and a.cif_no=? ";
			$param[] = $nik;
		}
		
		if ( $account_financing_no != "" ) {
			$sql .= " and a.account_financing_no=? ";
			$param[] = $account_financing_no;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_list_saldo_lunas($cif_no)
	{
		$sql = "select 
				a.registration_no,
				a.saldo_pokok,
				a.saldo_margin,
				a.account_financing_no,
				(select count(*) from mfi_account_financing_reg_lunas where account_financing_no=a.account_financing_no) as is_checked
				from mfi_account_financing a
				where a.status_rekening=1 and a.cif_no=?
			   ";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	public function get_registrasion_no_by_id($account_financing_reg_id)
	{
		$sql = "select registration_no from mfi_account_financing_reg where account_financing_reg_id = ?";
		$query = $this->db->query($sql,array($account_financing_reg_id));
		$row = $query->row_array();
		return isset($row['registration_no'])?$row['registration_no']:'';
	}

	public function get_list_saldo_lunas_reg($cif_no)
	{
		$sql = "select 
				a.registration_no,
				a.saldo_pokok,
				a.saldo_margin,
				a.account_financing_no,
				(select count(*) from mfi_account_financing_reg_lunas where account_financing_no=a.account_financing_no) as is_checked
				from mfi_account_financing a
				where a.status_rekening=1 and a.cif_no=?
			   ";
		$query = $this->db->query($sql,array($cif_no));
		return $query->result_array();
	}

	/*[BEGIN]
	| Pelunasan rekening terdahulu, dilakukan ketika pencairan
	*/
	public function get_financing_reg_lunas($registration_no)
	{
		$sql = "SELECT 
						a.registration_no
						,a.account_financing_no
						,a.saldo_pokok
						,a.saldo_margin
						,b.account_financing_reg_id
				FROM mfi_account_financing_reg_lunas a, mfi_account_financing_reg b 
				WHERE b.registration_no=a.registration_no
				AND b.registration_no=?
				GROUP BY 1,2,3,4,5
			   ";
		$query = $this->db->query($sql,array($registration_no));
		return $query->result_array();
	}

	public function get_account_cash_for_pelunasan()
	{
		$sql = "SELECT code_value
				FROM mfi_list_code_detail 
				WHERE code_group='account_pelunasan'
			   ";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		$retVal = (count($data['code_value'])>0) ? $data['code_value'] : '0' ;
		return $retVal;
	}

	public function get_droping_date_and_registration_no($account_financing_no)
	{
		$sql = "SELECT 
						 b.registration_no
						,a.droping_date 
				FROM mfi_account_financing_droping a 
				INNER JOIN mfi_account_financing b ON a.account_financing_no=b.account_financing_no
				WHERE b.account_financing_no=?
			   ";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}
	/*[END]
	| Pelunasan rekening terdahulu, dilakukan ketika pencairan
	*/

	function get_data_pembayaran_angsuran_pokok($account_financing_no)
	{
		$sql = "
			SELECT
				a.account_financing_id
				,b.nama,c.product_name,a.pokok,a.margin
				,a.jangka_waktu,a.saldo_pokok,a.saldo_margin
				,a.jtempo_angsuran_next
				,a.angsuran_pokok,a.angsuran_margin
				,a.flag_jadwal_angsuran
			FROM mfi_account_financing a, mfi_cif b, mfi_product_financing c
			WHERE a.cif_no=b.cif_no AND a.product_code=c.product_code
			AND a.account_financing_no=?
		";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function get_account_financing($account_financing_no)
	{
		$sql = "
			SELECT
				a.*, b.rate_margin2
			FROM mfi_account_financing a, mfi_product_financing b
			WHERE a.account_financing_no=? AND a.product_code=b.product_code
		";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	function get_flag_jadwal_angsuran_v2($account_financing_no)
	{
		$sql = "
			SELECT
				flag_jadwal_angsuran
			FROM mfi_account_financing
			WHERE account_financing_no=?
		";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		if (count($row)>0) {
			return $row['flag_jadwal_angsuran'];
		} else {
			return false;
		}
	}

	function get_account_financing_schedulle($account_financing_no)
	{
		$sql = "
			SELECT
				account_financing_schedulle_id,
				tangga_jtempo,
				angsuran_pokok,
				angsuran_margin,
				bayar_pokok,
				bayar_margin
			FROM mfi_account_financing_schedulle
			WHERE account_no_financing = ?
			AND status_angsuran = 0
			ORDER BY tangga_jtempo ASC
		";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->result_array();
	}
	
	public function update_mfi_angsuran_temp($data,$param)
	{
		$this->db->update('mfi_angsuran_temp',$data,$param);
	}

	function jqgrid_angsuran_temp($sidx='',$sord='',$limit_rows='',$start='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT 
				a.*,
				mfi_user.fullname,
				(select trx_date from mfi_angsuran_temp_detail where angsuran_id=a.angsuran_id group by 1 limit 1) trx_date
			from mfi_angsuran_temp a
			INNER JOIN mfi_user ON mfi_user.user_id::varchar=a.import_by::varchar
			where a.status in(1,3)";
			// where a.status in(0,1,3)";

		$sql .= " $order $limit ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	function get_mfi_angsuran_temp_by_angsuran_id($angsuran_id)
	{
		$sql = "select * from mfi_angsuran_temp where angsuran_id=?";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->row_array();
	}

	function cek_unverified_transaction($account_financing_no)
	{
		$sql = "
			SELECT 
				count(*) jml 
			FROM mfi_trx_account_financing 
			WHERE account_financing_no=? 
			AND trx_status=0
		";
		$query = $this->db->query($sql,array($account_financing_no));
		$row = $query->row_array();
		if ($row['jml']!=0) {
			return false;
		} else {
			return true;
		}
	}

	function get_angsuran_canceled($angsuran_id)
	{
		$sql = "
			select
				a.account_financing_no,
				c.nama
			from mfi_angsuran_temp_detail_canceled a, mfi_account_financing b, mfi_cif c
			where a.account_financing_no=b.account_financing_no and b.cif_no=c.cif_no
			and a.angsuran_id=?
		";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	/**
	* PEMBATALAN ANGSURAN
	*/

	function jqgrid_pembatalan_angsuran($sidx='',$sord='',$limit_rows='',$start='',$cif_no='',$nama='',$account_financing_no='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "
			SELECT
				a.account_financing_id,
				a.account_financing_no,
				b.nama,
				a.tanggal_akad,
				a.pokok,
				a.margin,
				a.saldo_pokok,
				a.saldo_margin,
				a.jtempo_angsuran_last,
				a.jtempo_angsuran_next,
				a.flag_jadwal_angsuran,
				a.counter_angsuran
			FROM 
				mfi_account_financing a,
				mfi_cif b
			WHERE
			  a.cif_no=b.cif_no and
			  a.status_rekening=1 and
			  a.counter_angsuran<>0
		";
		
		if ( $cif_no != "" ) {
			$sql .= " and upper(b.cif_no) like ? ";
			$param[] = '%'.trim(strtoupper(strtolower($cif_no))).'%';
		}
		if ( $nama != "" ) {
			$sql .= " and upper(b.nama) like ? ";
			$param[] = '%'.trim(strtoupper(strtolower($nama))).'%';
		}
		if ( $account_financing_no != "" ) {
			$sql .= " and upper(a.account_financing_no) like ? ";
			$param[] = '%'.trim(strtoupper(strtolower($account_financing_no))).'%';
		}
		$sql .= " $order $limit ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	/**
	* //PEMBATALAN ANGSURAN
	*/


	/*
	LIST TAGIHAN & PELUNASAN
	*/
	public function jqgrid_list_tagihan($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='',$akad='',$product_code='',$status_telkom=null,$code_divisi=null)
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";


		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				  mfi_account_financing.account_financing_no,
				  mfi_account_financing.tanggal_akad,
				  mfi_account_financing.tanggal_jtempo,
				  mfi_account_financing.counter_angsuran,
				  (mfi_account_financing.jangka_waktu-mfi_account_financing.counter_angsuran) as sisa_angsuran,
				  (mfi_account_financing.angsuran_pokok+mfi_account_financing.angsuran_margin) as besar_angsuran,
				  mfi_cif.nama,
				  mfi_cif.cif_no,
				  mfi_cm.cm_name,
				  mfi_product_financing.product_name,
				  mfi_product_financing.product_code
				FROM
				  mfi_account_financing
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_financing.cif_no
				LEFT JOIN mfi_pegawai ON mfi_pegawai.nik = mfi_cif.cif_no
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_product_financing ON mfi_account_financing.product_code = mfi_product_financing.product_code
				WHERE (mfi_account_financing.status_rekening = '1')
				AND account_financing_no NOT IN (SELECT account_financing_no FROM mfi_account_financing_lunas)
				";
		
		if($from_date!='' && $thru_date){
			$sql .= " AND mfi_account_financing.jtempo_angsuran_next BETWEEN ? AND ?";
			$param[] = $from_date;
			$param[] = $thru_date;
		}

		if($akad!='-'){
			$sql .= " AND mfi_account_financing.akad_code=?";
			$param[] = $akad;
		}

		if($product_code!='0000'){
			if($product_code=='semua'){
				$sql .= " AND mfi_product_financing.product_financing_gl_code='52'";
			}else{
				$sql .= " AND mfi_account_financing.product_code=?";
				$param[] = $product_code;
			}
		}

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		if($status_telkom!=''){
			$sql .= " AND mfi_pegawai.status_telkom=? ";
			$param[] = $status_telkom;
		}

		if($code_divisi!=''){
			$sql .= " AND mfi_pegawai.code_divisi=? ";
			$param[] = $code_divisi;
		}

		$sql .= "$order $limit";
		// die($sql);
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_financing_by_saldo_pokok($cif_no, $saldo_pokok)
	{
		$sql = "SELECT * FROM mfi_account_financing WHERE cif_no='$cif_no' AND saldo_pokok='$saldo_pokok'";
		$query = $this->db->query($sql);
		return $query->row_array();

	}

	public function get_financing_by_saldo_pokok_v2($cif_no, $account_financing_no='')
	{
		if($account_financing_no != 1){
			
			$arr = explode(';', $account_financing_no);
			$out1 = array(); $out2 = array(); $out3 = array();
			for($i=0; $i < count($arr); $i++)
			{
				$sql = "SELECT account_financing_no, saldo_pokok, saldo_margin FROM mfi_account_financing WHERE account_financing_no='$arr[$i]'";
				$result = $this->db->query($sql)->row();
				array_push($out1, $result->account_financing_no);
				array_push($out2, $result->saldo_pokok);
				array_push($out3, $result->saldo_margin);
			}

			$account_financing_no = implode(';', $out1);
			$saldo_pokok = implode(';', $out2);
			$saldo_margin = implode(';', $out3);
			$data = array('account_financing_no' => $account_financing_no, 'saldo_pokok' => $saldo_pokok, 'saldo_margin' => $saldo_margin);
			
			return $data;

		}else{
			$sql = "
			SELECT
			array_to_string(
			ARRAY   (
			        SELECT  DISTINCT account_financing_no
			        FROM    mfi_account_financing gl
			        WHERE   gl.cif_no= gd.cif_no
			        ORDER BY
			                account_financing_no
			        ),
			';'
			) AS account_financing_no,
			array_to_string(
			ARRAY   (
			        SELECT  DISTINCT saldo_pokok
			        FROM    mfi_account_financing gl
			        WHERE   gl.cif_no= gd.cif_no
			        ORDER BY
			                saldo_pokok
			        ),
			';'
			) AS saldo_pokok,
			array_to_string(
			ARRAY   (
			        SELECT  DISTINCT saldo_margin
			        FROM    mfi_account_financing gl
			        WHERE   gl.cif_no= gd.cif_no
			        ORDER BY
			                saldo_margin
			        ),
			';'
			) AS saldo_margin
			FROM mfi_account_financing gd WHERE gd.cif_no='$cif_no'
			GROUP BY 1,2,3";

			$query = $this->db->query($sql);
			return $query->row_array();
		}
	}

	public function get_financing_by_saldo_pokok_v3($account_financing_no)
	{
		$sql = "SELECT * FROM mfi_account_financing WHERE account_financing_no='$account_financing_no'";
		$query = $this->db->query($sql);
		return $query->row_array();

	}

	public function get_margin_from_schedulle($account_financing_no,$formula)
	{
		$order = ($formula=='D') ? "ORDER BY tangga_jtempo ASC" : (($formula=='E') ? "ORDER BY tangga_jtempo DESC" : "");
		$sql = "SELECT angsuran_margin FROM mfi_account_financing_schedulle WHERE account_no_financing='$account_financing_no' AND status_angsuran='0'  $order LIMIT 1";
		
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row;
	}

}