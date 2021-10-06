<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laporan extends CI_Model {

	/****************************************************************************************/	
	// BEGIN SALDO KAS PETUGAS
	/****************************************************************************************/

	public function get_all_branch()
	{
		$sql = "SELECT * from mfi_branch";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_saldo_kas_petugas($sOrder='',$sLimit='',$cabang='',$tanggal)
	{
		$sql = " SELECT 
						mfi_gl_account_cash.account_cash_code,
						mfi_fa.fa_name,
						fn_get_saldoawal_kaspetugas(mfi_gl_account_cash.account_cash_code,?,0) as saldoawal,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'D') as mutasi_debet,
						fn_get_mutasi_kaspetugas(mfi_gl_account_cash.account_cash_code,?,'C') as mutasi_credit
				from 	
						mfi_gl_account_cash 
				left outer join mfi_fa on (mfi_gl_account_cash.fa_code=mfi_fa.fa_code)
				where 
						mfi_gl_account_cash.account_cash_type = '0'
		";
		if($cabang!="0000"){
			$sql .= " AND mfi_fa.branch_code = ? ";
		}

		$sql .= " order by mfi_gl_account_cash.account_cash_code ";


		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal,$cabang));
		// print_r($this->db);
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END SALDO KAS PETUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PETUGAS
	/****************************************************************************************/
	public function search_code_cash_by_keyword($keyword,$type)
	{
		$sql = "SELECT
							mfi_gl_account_cash.account_cash_name,
							mfi_gl_account_cash.account_cash_code,
							mfi_gl_account_cash.fa_code,
							mfi_fa.fa_name
				FROM
							mfi_gl_account_cash
				INNER JOIN 
							mfi_fa ON mfi_gl_account_cash.fa_code=mfi_fa.fa_code
				WHERE (account_cash_name like ? or account_cash_code like ?) ";
		if($type!=""){
			$sql .= ' and account_cash_type = ?';
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%',$type));
		}else{

			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function datatable_transaksi_kas_petugas_setup($sOrder='',$sLimit='',$tanggal='',$tanggal2='',$account_cash_code='')
	{
		$sql = "SELECT 
							fn_get_saldoawal_kaspetugas(a.account_cash_code,?,0) as saldoawal,
							a.trx_gl_cash_type,
							a.trx_date,
							b.display_text trx_type,
							a.description,
							a.flag_debet_credit,
							(case when a.flag_debet_credit='D' then a.amount else 0 end) as trx_debet,
							(case when a.flag_debet_credit='C' then a.amount else 0 end) as trx_credit
				from 
							mfi_trx_gl_cash as a
				left outer join 
							mfi_list_code_detail b on (a.trx_gl_cash_type=CAST(b.code_value as integer) 
							and b.code_group='trx_gl_cash_type')
				where 
							a.trx_date between ? and ?
							and a.account_cash_code = ?
				order by 	a.trx_date,a.trx_gl_cash_type ";


		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,array($tanggal,$tanggal,$tanggal2,$account_cash_code));
		// print_r($this->db);
		return $query->result_array();
	}


	/****************************************************************************************/	
	// END TRANSAKSI KAS PETUGAS
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN GL REPORT
	/****************************************************************************************/

	public function get_gl_account_history($branch_code='',$account_code='',$from_date='',$thru_date='')
	{
		$sql = "SELECT
				mfi_trx_gl_detail.trx_gl_detail_id,
				mfi_trx_gl.trx_gl_id,
				mfi_trx_gl_detail.account_code,
				mfi_trx_gl_detail.flag_debit_credit,
				mfi_trx_gl_detail.amount,
				mfi_trx_gl.trx_date,
				mfi_trx_gl.voucher_date,
				(case when mfi_trx_gl_detail.flag_debit_credit = 'C' then mfi_trx_gl_detail.amount else 0 end) as credit,
				(case when mfi_trx_gl_detail.flag_debit_credit = 'D' then mfi_trx_gl_detail.amount else 0 end) as debit,
				mfi_gl_account.transaction_flag_default,
				mfi_trx_gl.description
				from mfi_trx_gl
				left join mfi_trx_gl_detail on mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id
				left join mfi_gl_account on mfi_gl_account.account_code = mfi_trx_gl_detail.account_code
				where mfi_trx_gl_detail.account_code = ?
				and mfi_trx_gl.voucher_date	between ? and ?
		";

		$param[] = $account_code;
		$param[] = $from_date;
		$param[] = $thru_date;

		if ( $branch_code == "" || $branch_code != "00000" ) {
			$sql .= " and mfi_trx_gl.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		
		$sql .= "
				order by mfi_trx_gl.voucher_date,mfi_trx_gl.created_date asc
		";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_gl_rekap_transaksi($branch_code='',$from_date='',$thru_date='')
	{
		$sql = "select
				gl_account.gl_account_id, 
				gl_account.account_code, 
				gl_account.account_name, 
				(select sum(amount) from mfi_trx_gl_detail 
					join mfi_trx_gl on mfi_trx_gl.trx_gl_id = mfi_trx_gl_detail.trx_gl_id
					where mfi_trx_gl_detail.flag_debit_credit = 'C' 
					and mfi_trx_gl.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
					and mfi_trx_gl.trx_date between ? and ?
					and mfi_trx_gl_detail.account_code = gl_account.account_code) as credit,
				(select sum(amount) from mfi_trx_gl_detail 
					join mfi_trx_gl on mfi_trx_gl.trx_gl_id = mfi_trx_gl_detail.trx_gl_id
					where mfi_trx_gl_detail.flag_debit_credit = 'D'
					and mfi_trx_gl.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)
					and mfi_trx_gl.trx_date between ? and ?
					and mfi_trx_gl_detail.account_code = gl_account.account_code) as debit
				from mfi_gl_account gl_account
				join mfi_trx_gl_detail trx_gl_detail on trx_gl_detail.account_code = gl_account.account_code
				group by 1,2,3,4,5
		";

		$query = $this->db->query($sql,array($branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date));
		
		return $query->result_array();
	}

	function get_mutasi_saldo($branch_code,$from_periode,$thru_periode,$product){
		$sql = "SELECT
		mcfd.account_financing_no,
		mc.nama,
		mpf.product_name,
		maf.tanggal_akad,
		maf.pokok,
		maf.margin,
		mcfd.saldo_pokok,
		mcfd.saldo_margin,
		mcfd.angsuran_pokok,
		mcfd.angsuran_margin
		FROM mfi_closing_financing_data AS mcfd
		JOIN mfi_account_financing AS maf ON maf.account_financing_no = mcfd.account_financing_no
		JOIN mfi_cif AS mc ON mc.cif_no = maf.cif_no
		JOIN mfi_product_financing AS mpf ON mpf.product_code = maf.product_code

		WHERE mcfd.closing_from_date = ? AND mcfd.closing_thru_date = ?
		
		";

		$param = array($from_periode,$thru_periode);
		if($product==''){
			$sql .= " AND maf.product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
		}else{
			$sql .= " AND maf.product_code = ?";
			$param[] = $product;
		}

		$sql .= 'order by 1 asc';

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_neraca_saldo_gl($branch_code='',$periode_bulan='',$periode_tahun='')
	{
		$last_date = date('Y-m-d',strtotime($periode_tahun.'-'.$periode_bulan.'-01 -1 days'));

		$from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
		$thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
		$sql = "SELECT
				gl_account.gl_account_id, 
				gl_account.account_code, 
				gl_account.account_name, 
				gl_account.account_group_code, 
				fn_get_saldo_gl_account_sayyid(gl_account.account_code,?,?) as saldo_awal,
				fn_get_mutasi_gl_account_sayyid(gl_account.account_code,?,?,'D',?) as debit,
				fn_get_mutasi_gl_account_sayyid(gl_account.account_code,?,?,'C',?) as credit
				from mfi_gl_account gl_account
				order by gl_account.account_group_code,gl_account.account_code asc
				--group by 1,2,3,4,5
		";

		if($branch_code=='00000'){
			$branch_code = 'all';
		}

		$query = $this->db->query($sql,array(
				$last_date,
				$branch_code,

				$from_periode,
				$thru_periode,
				$branch_code,

				$from_periode,
				$thru_periode,
				$branch_code
			));
		// print_r($this->db);
		// die();
		return $query->result_array();
	}
	/****************************************************************************************/	
	// END GL REPORT
	/****************************************************************************************/

	/****************************************************************************************/	
	// LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/

	public function getReportDropingPembiayaan()
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_account_financing_droping.droping_date,
				mfi_account_financing_droping.droping_by,
				mfi_account_financing_droping.account_financing_no,
				mfi_account_financing.pokok,
				mfi_account_financing.dana_kebajikan,
				mfi_cm.cm_name,
				mfi_fa.fa_name
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing_droping ON mfi_account_financing_droping.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				WHERE mfi_account_financing.status_rekening !=0
				ORDER BY mfi_account_financing_droping.account_financing_droping_id ASC
				";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/



	
	/****************************************************************************************/	
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/
	public function get_kartu_pengawasan_angsuran_by_account_no($account_no)
	{
		$sql = "SELECT
			mfi_cif.cif_no,
			mfi_cif.nama,
			mfi_cif.cif_type,
			mfi_cm.cm_name,
			mfi_kecamatan_desa.desa,
			mfi_account_financing.angsuran_pokok,
			mfi_account_financing.angsuran_margin,
			mfi_account_financing.saldo_pokok,
			mfi_account_financing.saldo_margin,
			mfi_account_financing.registration_no,
			mfi_account_financing.pokok,
			mfi_account_financing.account_financing_no,
			mfi_account_financing.account_saving_no,
			mfi_account_financing.jangka_waktu,
			mfi_account_financing.periode_jangka_waktu,
			mfi_account_financing.margin,
			mfi_account_financing_droping.droping_date,
			mfi_account_financing.tanggal_jtempo,
			mfi_account_financing.status_rekening,
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
		$query = $this->db->query($sql,array($account_no));

		return $query->row_array();
	}

	public function get_trx_pembiayaan_by_cif_no($cif_no)
	{
		$sql = "SELECT
						mfi_account_financing.cif_no,
						mfi_account_financing.jangka_waktu,
						mfi_account_financing.tanggal_mulai_angsur,
						mfi_trx_cm.trx_date,
						mfi_trx_cm.angsuran_pokok,
						mfi_trx_cm.angsuran_margin,
						mfi_trx_cm.angsuran_catab
				FROM
						mfi_account_financing
				INNER JOIN mfi_trx_cm_detail ON mfi_account_financing.cif_no = mfi_trx_cm_detail.cif_no
				INNER JOIN mfi_trx_cm ON mfi_trx_cm_detail.trx_cm_id = mfi_trx_cm.trx_cm_id

				WHERE mfi_account_financing.cif_no = ? 
				AND mfi_account_financing.status_rekening='1' ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->result_array();
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
					(select fullname from mfi_user where user_id::varchar=a.created_by) as created_by
					from mfi_trx_account_financing a
					where a.account_financing_no=? and a.jto_date=? --and a.trx_financing_type='1'

					UNION ALL
					
					select 
					a.trx_date,
					(select fullname from mfi_user where user_id::varchar=a.created_by) as created_by
					from mfi_trx_account_financing a
					where a.account_financing_no=? and a.trx_financing_type='2'
				  ";
			$param[]=$account_financing_no;
			$param[]=$jtempo;
		}


		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}
	/****************************************************************************************/	
	// END KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/


	public function check_detail_trx($account_financing_no,$trx_date)
	{
		$sql = "SELECT 
				 a.trx_date,
				 (select fullname from mfi_user where user_id::varchar=a.created_by) as created_by,
				 a.created_date,
				 (select fullname from mfi_user where user_id::varchar=a.verify_by 	) as verify_by,
				 a.verify_date, a.pokok, a.margin
				FROM mfi_trx_account_financing a
				WHERE a.account_financing_no=? and a.trx_date=?
			  ";
		$param[]=$account_financing_no;
		$param[]=$trx_date;
		$query = $this->db->query($sql,$param);
		return $query;
	}

	public function check_detail_saving($cif_no,$trx_date)
	{
		$sql = "SELECT 
				 a.trx_date, a.amount
				FROM mfi_trx_account_saving a
				WHERE a.account_saving_no=? and a.trx_date=?
			  ";
		$param[]=$cif_no;
		$param[]=$trx_date;
		$query = $this->db->query($sql,$param);
		return $query;
	}

	/****************************************************************************************/	
	// FUNGSI UNTUK MEMANGGIL NAMA DESA
	/****************************************************************************************/
	public function get_all_desa()
	{
		$sql = "SELECT * from mfi_kecamatan_desa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_desa_by_keyword($keyword)
	{
		$sql = "SELECT
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.desa
				FROM
				mfi_kecamatan_desa
				where (UPPER(desa) like ? or UPPER(desa_code) like ?)";
		
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}
	/****************************************************************************************/	
	// FUNGSI UNTUK MEMANGGIL NAMA DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY DESA
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY REMBUG
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_rembug()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_cm.cm_name,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_cm.cm_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_petugas()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_fa.fa_name,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_fa.fa_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_peruntukan()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_account_financing.peruntukan,
				SUM(mfi_account_financing.pokok) AS pokok,
				SUM(mfi_account_financing.margin) AS margin
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_account_financing.peruntukan";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY DESA
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY REMBUG
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_rembug()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_cm.cm_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_cm.cm_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_petugas()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_fa.fa_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_fa.fa_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENGAJUAN BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_pengajuan_pembiayaan_by_peruntukan()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_account_financing.peruntukan,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_account_financing.peruntukan";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENGAJUAN BY PERUNTUKAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY DESA
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_desa()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_kecamatan_desa.desa,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_kecamatan_desa ON mfi_cm.desa_code = mfi_kecamatan_desa.desa_code
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_kecamatan_desa.desa";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY REMBUG
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_rembug()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_cm.cm_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_cm.cm_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_petugas()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_fa.fa_name,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_cm.fa_code
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				group by mfi_fa.fa_name";

		$query = $this->db->query($sql);

		return $query->result_array();
		// print_r($this->db);
	}
	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN EXPORT REKAP PENCAIRAN BY PERUNTUKAN
	/****************************************************************************************/

	public function export_rekap_pencairan_pembiayaan_by_peruntukan()
	{
		$sql = "SELECT
				COUNT(*) AS num,
				mfi_account_financing.peruntukan,
				SUM(mfi_account_financing_reg.amount) AS amount
				FROM
				mfi_cif
				INNER JOIN mfi_account_financing_reg ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_account_financing ON mfi_account_financing.cif_no = mfi_cif.cif_no
				group by mfi_account_financing.peruntukan";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/****************************************************************************************/	
	// END EXPORT REKAP PENCAIRAN BY PERUNTUKAN
	/****************************************************************************************/

	public function export_list_transaksi_rembug($branch_id='',$cm_code='',$from_date='',$thru_date='',$fa_code='')
	{
		// $sql = "select
		// 		mfi_trx_cm.trx_cm_id,
		// 		mfi_cm.cm_name,
		// 		mfi_fa.fa_name,
		// 		mfi_trx_cm.trx_date,
		// 		CAST(mfi_trx_cm.created_date as varchar(10))
		// 		from mfi_trx_cm
		// 		left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm.cm_code
		// 		left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm.fa_code
		// 		where trx_date between ? and ? ";
		$sql = "select
				'Ya' as status_verifikasi,
				mfi_trx_cm.infaq_kelompok infaq,
				((select sum((a.angsuran_pokok+a.angsuran_margin+a.angsuran_catab+a.tab_wajib_cr+a.tab_kelompok_cr) * a.freq)+sum(a.tab_sukarela_cr)+sum(a.minggon)+sum(b.administrasi)+sum(b.asuransi)+coalesce(sum(c.amount),0)
				from mfi_trx_cm_detail a
				left join mfi_trx_cm_detail_droping b on a.trx_cm_detail_id = b.trx_cm_detail_id
				left join mfi_trx_cm_detail_savingplan c on a.trx_cm_detail_id = c.trx_cm_detail_id 
				where a.trx_cm_id = mfi_trx_cm.trx_cm_id
				)) setoran,
				(droping+tab_sukarela_db) penarikan,
				mfi_trx_cm.trx_cm_id,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_trx_cm.trx_date,
				CAST(mfi_trx_cm.created_date as varchar(10))
				
				from mfi_trx_cm
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm.fa_code
				where trx_date between ? and ?
				";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($branch_id!="0000"){
			$sql .= " and mfi_cm.branch_id = ? ";
			$param[] = $branch_id;
		}

		if($cm_code!="0000"){
			$sql .= " and mfi_cm.cm_code = ? ";
			$param[] = $cm_code;
		}

		if($fa_code!="0000"){
			$sql .= " and mfi_trx_cm.fa_code = ? ";
			$param[] = $fa_code;
		}

		$sql .= "
				union all
				select
				'Tidak' as status_verifikasi,
				mfi_trx_cm_save.infaq,
				((select sum((
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_pokok else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_margin else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_catab else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_wajib else 0 end) else 0 end) else 0 end)+
				(case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end)
				) * a.frekuensi)+
				sum(a.setoran_tab_sukarela)+
				sum(a.setoran_mingguan)+
				sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (mfi_account_financing.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end))+
				sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end))+
				sum( (select sum(b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id ))
				--(select (b.amount*b.frekuensi) from mfi_trx_cm_save_berencana b where b.trx_cm_save_detail_id=a.trx_cm_save_detail_id)
				--coalesce(sum(b.amount*b.frekuensi),0)
				from mfi_trx_cm_save_detail a
				left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no  and mfi_account_financing.status_rekening = 1
				--left join mfi_trx_cm_save_berencana b on a.trx_cm_save_detail_id = b.trx_cm_save_detail_id 
				where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id
				)) setoran,
				(select (sum(a.penarikan_tab_sukarela)+sum((case when mfi_account_financing.tanggal_akad <= mfi_trx_cm_save.trx_date then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end)))
				from mfi_trx_cm_save_detail a
				left join mfi_account_financing on mfi_account_financing.cif_no = a.cif_no and mfi_account_financing.status_rekening = 1
				where a.trx_cm_save_id = mfi_trx_cm_save.trx_cm_save_id 
				) penarikan,
				mfi_trx_cm_save.trx_cm_save_id,
				mfi_cm.cm_name,
				mfi_fa.fa_name,
				mfi_trx_cm_save.trx_date,
				CAST(mfi_trx_cm_save.created_date as varchar(10))

				from mfi_trx_cm_save
				left join mfi_cm on mfi_cm.cm_code = mfi_trx_cm_save.cm_code
				left join mfi_fa on mfi_fa.fa_code = mfi_trx_cm_save.fa_code
				where trx_date between ? and ? ";

		$param[] = $from_date;
		$param[] = $thru_date;

		if($branch_id!="0000"){
			$sql .= " and mfi_cm.branch_id = ? ";
			$param[] = $branch_id;
		}

		if($cm_code!="0000"){
			$sql .= " and mfi_cm.cm_code = ? ";
			$param[] = $cm_code;
		}

		if($fa_code!="0000"){
			$sql .= " and mfi_trx_cm_save.fa_code = ? ";
			$param[] = $fa_code;
		}

		$sql .= " order by trx_date asc ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function export_list_transaksi_rembug_sub($trx_cm_id,$from_date,$thru_date,$trx_date='')
	{
		// $sql = "select
		// 		mfi_cif.cif_no,
		// 		mfi_cif.nama,
		// 		mfi_trx_cm_detail.angsuran_pokok,
		// 		mfi_trx_cm_detail.angsuran_margin,
		// 		mfi_trx_cm_detail.angsuran_catab,
		// 		mfi_trx_cm_lwk.setoran_lwk,
		// 		mfi_trx_cm_detail.tab_sukarela_cr,
		// 		mfi_trx_cm_detail.freq,
		// 		mfi_trx_cm_detail.minggon,
		// 		mfi_trx_cm_detail.tab_wajib_cr,
		// 		mfi_trx_cm_detail.tab_sukarela_db,
		// 		mfi_trx_cm_detail.tab_kelompok_cr,
		// 		(	select 
		// 				(case when count(*) = 0 then '0' else mfi_account_financing.pokok end)
		// 			from mfi_account_financing
		// 			join mfi_account_financing_droping on mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
		// 				and mfi_account_financing_droping.droping_date = ? and status_droping = 1
		// 			where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_account_financing.status_rekening = 1
		// 			group by mfi_account_financing.pokok
		// 			limit 1
		// 		) as pokok,
		// 		mfi_trx_cm_detail_droping.droping,
		// 		mfi_trx_cm_detail_droping.administrasi,
		// 		mfi_trx_cm_detail_droping.asuransi,
		// 		(select mfi_account_financing_reg.pembiayaan_ke from mfi_account_financing_reg where mfi_account_financing_reg.cif_no = mfi_cif.cif_no order by pembiayaan_ke desc limit 1) as pembiayaan_ke
		// 		from mfi_trx_cm_detail
		// 		left join mfi_cif on mfi_cif.cif_no = mfi_trx_cm_detail.cif_no
		// 		left join mfi_trx_cm_lwk on mfi_trx_cm_lwk.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
		// 		left join mfi_trx_cm_detail_droping on mfi_trx_cm_detail_droping.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
		// 		where mfi_trx_cm_detail.trx_cm_id = ?
		// 		order by mfi_cif.kelompok::integer asc
		// 		";
		$sql = "
				select
				mfi_cif.cif_no,
				mfi_cif.nama,
				cast(mfi_cif.kelompok as integer) kelompok,
				mfi_trx_cm_detail.angsuran_pokok,
				mfi_trx_cm_detail.angsuran_margin,
				mfi_trx_cm_detail.angsuran_catab,
				mfi_trx_cm_lwk.setoran_lwk,
				mfi_trx_cm_detail.tab_sukarela_cr,
				mfi_trx_cm_detail.freq,
				mfi_trx_cm_detail.minggon,
				mfi_trx_cm_detail.tab_wajib_cr,
				mfi_trx_cm_detail.tab_sukarela_db,
				mfi_trx_cm_detail.tab_kelompok_cr,
				(	select 
						(case when count(*) = 0 then '0' else mfi_account_financing.pokok end)
					from mfi_account_financing
					join mfi_account_financing_droping on mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
						and mfi_account_financing_droping.droping_date = ? and status_droping = 1
					where mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_account_financing.status_rekening = 1
					group by mfi_account_financing.pokok
					limit 1
				) as pokok,
				mfi_trx_cm_detail_droping.droping,
				mfi_trx_cm_detail_droping.administrasi,
				mfi_trx_cm_detail_droping.asuransi,
				(select count(*) from mfi_account_financing where mfi_account_financing.cif_no = mfi_cif.cif_no) as pembiayaan_ke,
				(select mfi_trx_cm_detail_savingplan.amount from mfi_trx_cm_detail_savingplan where mfi_trx_cm_detail_savingplan.trx_cm_detail_id=mfi_trx_cm_detail.trx_cm_detail_id) as tabren
				from mfi_trx_cm_detail
				left join mfi_cif on mfi_cif.cif_no = mfi_trx_cm_detail.cif_no
				left join mfi_trx_cm_lwk on mfi_trx_cm_lwk.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
				left join mfi_trx_cm_detail_droping on mfi_trx_cm_detail_droping.trx_cm_detail_id = mfi_trx_cm_detail.trx_cm_detail_id
				where mfi_trx_cm_detail.trx_cm_id = ?

				union all

				select
				mfi_cif.cif_no,
				mfi_cif.nama,
				cast(mfi_cif.kelompok as integer) kelompok,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_pokok else 0 end) else 0 end) else 0 end) as angsuran_pokok,
				(case when mfi_trx_cm_save_detail.status_angsuran_margin = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_margin else 0 end) else 0 end) else 0 end) end) as angsuran_margin,
				(case when mfi_trx_cm_save_detail.status_angsuran_catab = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_catab else 0 end) else 0 end) else 0 end) end) as angsuran_catab,
				mfi_trx_cm_save_detail.setoran_lwk,
				mfi_trx_cm_save_detail.setoran_tab_sukarela AS tab_sukarela_cr,
				mfi_trx_cm_save_detail.frekuensi as freq,
				'0' as minggon,
				(case when mfi_trx_cm_save_detail.status_angsuran_tab_wajib = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_wajib else 0 end) else 0 end) else 0 end) end) as tab_wajib_cr,
				mfi_trx_cm_save_detail.penarikan_tab_sukarela as tab_sukarela_db,
				(case when mfi_trx_cm_save_detail.status_angsuran_tab_kelompok = 0 then 0 else (case when mfi_account_financing.tanggal_akad <= ? then (case when mfi_account_financing.status_rekening = 1 then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 1 then mfi_account_financing.angsuran_tab_kelompok else 0 end) else 0 end) else 0 end) end) as tab_kelompok_cr,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then mfi_account_financing.pokok else 0 end) else 0 end) as pokok,
				null as droping,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (mfi_account_financing.cadangan_resiko + dana_kebajikan + biaya_administrasi + biaya_notaris) else 0 end) else 0 end) as administrasi,
				(case when mfi_account_financing.tanggal_akad <= ? then (case when (select status_droping from mfi_account_financing_droping droping where droping.account_financing_no = mfi_account_financing.account_financing_no) = 0 then (biaya_asuransi_jiwa + biaya_asuransi_jaminan) else 0 end) else 0 end) asuransi,
				(select count(*) from mfi_account_financing where mfi_account_financing.cif_no = mfi_cif.cif_no) as pembiayaan_ke,
				(select SUM(mfi_trx_cm_save_berencana.amount*mfi_trx_cm_save_berencana.frekuensi) from mfi_trx_cm_save_berencana where mfi_trx_cm_save_berencana.trx_cm_save_detail_id=mfi_trx_cm_save_detail.trx_cm_save_detail_id) as tabren
				from mfi_trx_cm_save_detail
				left join mfi_cif on mfi_cif.cif_no = mfi_trx_cm_save_detail.cif_no
				left join mfi_account_financing ON (mfi_account_financing.cif_no=mfi_cif.cif_no) AND (mfi_account_financing.status_rekening = 1)
				where mfi_trx_cm_save_detail.trx_cm_save_id = ?
				order by kelompok asc
				";
		$query = $this->db->query($sql,array($trx_date,$trx_cm_id,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_date,$trx_cm_id));

		return $query->result_array();
	}

	public function export_list_saldo_tabungan($branch_code='',$cm_code='')
	{
		$sql = "select 
				mfi_cif.cif_no,
				mfi_cif.nama,
				mfi_cm.cm_name,
				mfi_kecamatan_desa.desa,
				(select count(b.account_financing_no) from mfi_account_financing b where b.cif_no = mfi_cif.cif_no) as pyd_ke,
				mfi_account_financing.periode_jangka_waktu,
				mfi_account_financing.tanggal_mulai_angsur,
				mfi_account_financing.angsuran_pokok,
				mfi_account_financing.angsuran_margin,
				mfi_account_financing.jangka_waktu,
				mfi_account_default_balance.setoran_lwk,
				mfi_account_default_balance.simpanan_pokok,
				mfi_account_default_balance.tabungan_wajib as tabungan_minggon,
				mfi_account_default_balance.tabungan_sukarela,
				mfi_account_default_balance.tabungan_kelompok,
				mfi_account_financing.saldo_pokok,
				mfi_account_financing.saldo_margin,
				mfi_account_financing.pokok,
				mfi_account_financing.margin
				from mfi_cif
				left join mfi_account_default_balance on mfi_account_default_balance.cif_no = mfi_cif.cif_no
				left join mfi_cm on mfi_cm.cm_code = mfi_cif.cm_code
				left join mfi_kecamatan_desa on mfi_kecamatan_desa.desa_code = mfi_cm.desa_code
				left join mfi_account_financing on mfi_account_financing.cif_no = mfi_cif.cif_no and mfi_account_financing.status_rekening = '1'
				WHERE mfi_cif.status <> 2
		";
		
		if($branch_code!=""){
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}
		
		if($cm_code!=""){
			$sql .= " AND mfi_cif.cm_code = ? ";
			$param[] = $cm_code;
		}

		$sql .= " ORDER BY 4,3,2";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_cm_name_by_cm_code($cm_code)
	{
		$sql = "select cm_name from mfi_cm where cm_code = ?";
		$query = $this->db->query($sql,array($cm_code));

		$row = $query->row_array();

		return $row['cm_name'];
	}

	public function get_branch_name_by_branch_code($branch_code)
	{
		$sql = "select branch_name from mfi_branch where branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
		$query = $this->db->query($sql,array($branch_code));

		$row = $query->row_array();

		return $row['branch_name'];
	}

	public function get_all_produk_tabungan()
	{
		$sql = "SELECT 
				mfi_product_saving.product_code,
				mfi_product_saving.product_name
				FROM 
				mfi_account_saving 
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				GROUP BY 1,2
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function export_list_pembukaan_tabungan($produk='',$branch_code='')
	{
		$param = array();
		$sql = "SELECT 
				mfi_product_saving.product_name, 
				mfi_account_saving.account_saving_no, 
				mfi_account_saving.status_rekening, 
				mfi_account_saving.saldo_memo,
				(CASE WHEN mfi_product_saving.product_code = '01' THEN mfi_account_saving.saldo_twp_rev else mfi_account_saving.saldo_tdpk_rev end) AS saldo_rev,
				mfi_cif.nama 
				FROM mfi_account_saving 
				inner join mfi_product_saving on mfi_account_saving.product_code=mfi_product_saving.product_code 
				left join mfi_cif on mfi_account_saving.cif_no=mfi_cif.cif_no 
				where mfi_product_saving.product_code = ?
				";
				$param[] = $produk; 
				if ($branch_code!='00000') {
					$sql .=" AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
					$param[] = $branch_code; 
				}
				$sql .= " ORDER BY 2";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_produk($produk)
	{
		$sql = "SELECT 
				mfi_product_saving.product_code,
				mfi_product_saving.product_name
				FROM 
				mfi_account_saving , mfi_product_saving
				WHERE mfi_product_saving.product_code = mfi_account_saving.product_code
				AND mfi_product_saving.product_code = ?
				";

		$query = $this->db->query($sql,array($produk));

		$row = $query->row_array();
		if(isset($row['product_name'])){
			return $row['product_name'];
		}else{
			return 0;
		}
	}

	public function export_list_rekening_tabungan($cif_no,$no_rek,$produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_cif.nama,
				mfi_product_saving.product_name,
				mfi_product_saving.product_code,
				mfi_account_saving.account_saving_no,
				mfi_account_saving.saldo_memo,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.trx_account_saving_id,
				mfi_trx_account_saving.branch_id,
				mfi_trx_account_saving.account_saving_no,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.reference_no,
				mfi_trx_account_saving.description,
				mfi_trx_account_saving.created_date,
				mfi_trx_account_saving.created_by,
				mfi_trx_account_saving.trx_sequence,
				mfi_trx_account_saving.trx_detail_id
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE mfi_cif.cif_no = ? AND mfi_account_saving.account_saving_no = ? AND mfi_product_saving.product_code = ? AND mfi_trx_account_saving.trx_date BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function export_list_statement_tabungan($cif_no,$no_rek,$produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.description
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
				WHERE mfi_cif.cif_no = ? AND mfi_account_saving.account_saving_no = ? AND mfi_product_saving.product_code = ? AND mfi_trx_account_saving.trx_date BETWEEN ? AND ?
				ORDER BY mfi_trx_account_saving.trx_date, mfi_trx_account_saving.trx_sequence ASC
				";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function get_saldo_awal_credit($no_rek,$from_date)
	{
		$sql = "SELECT 
				SUM(amount) AS credit
				FROM mfi_trx_account_saving WHERE account_saving_no = ? AND trx_date < ? AND flag_debit_credit = 'C'
				";
		$query = $this->db->query($sql,array($no_rek,$from_date));

		return $query->row_array();
		// return $row['credit'];
	}

	public function get_saldo_awal_debet($no_rek,$from_date)
	{
		$sql = "SELECT 
				SUM(amount) AS debit
				FROM mfi_trx_account_saving WHERE account_saving_no = ? AND trx_date < ? AND flag_debit_credit = 'D'
				";
		$query = $this->db->query($sql,array($no_rek,$from_date));

		return $query->row_array();
		// return $row['debit'];
	}

	public function get_nama($cif_no)
	{
		$sql = "SELECT nama FROM mfi_cif WHERE cif_no = ?";
		$query = $this->db->query($sql,array($cif_no));

		$row = $query->row_array();
		return $row['nama'];
	}

	public function export_list_buka_tabungan($produk='',$from_date='',$thru_date='',$branch_code='')
	{
		$param = array();
		$sql = "SELECT 
				mfi_product_saving.*,
				mfi_account_saving.*,
				mfi_cif.nama
				FROM 
				mfi_account_saving 
				INNER JOIN mfi_product_saving ON mfi_product_saving.product_code = mfi_account_saving.product_code
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_saving.cif_no
				WHERE mfi_account_saving.status_rekening=1 AND mfi_cif.cif_type=1
				";

		if($produk!="0000"){
			$sql .= " AND mfi_product_saving.product_code = ?";
			$param[] = $produk;
		}
		if($from_date!="" && $thru_date!=""){
			$sql .= " AND mfi_account_saving.tanggal_buka BETWEEN ? AND ?";
			$param[] = $from_date;
			$param[] = $thru_date;
		}
		if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	public function get_tgl_awal_export_cetak_trans_buku($param)
	{
		$sql = "SELECT
				mfi_trx_account_saving.trx_date
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				WHERE mfi_trx_account_saving.trx_account_saving_id = ?
				";
		$query = $this->db->query($sql,array($param));

		return $query->row_array();
	}

	public function export_cetak_trans_buku($param)
	{
		$sql = "SELECT
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.trx_saving_type,
				mfi_trx_account_saving.amount
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				WHERE mfi_trx_account_saving.trx_account_saving_id = ?
				";
		$query = $this->db->query($sql,array($param));

		return $query->row_array();
	}

	/*public function export_cetak_trans_buku($param)
	{
		$sql = "SELECT
				mfi_setup_margin_buku_tab.item,
				mfi_setup_margin_buku_tab.top_margin,
				mfi_setup_margin_buku_tab.bottom_margin,
				mfi_setup_margin_buku_tab.left_margin,
				mfi_setup_margin_buku_tab.right_margin,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_setup_margin_buku_tab ON mfi_account_saving.branch_code = mfi_setup_margin_buku_tab.branch_code
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				WHERE mfi_trx_account_saving.trx_account_saving_id = ?
				";
		$query = $this->db->query($sql,array($param));

		return $query->row_array();
	}*/

	public function get_margin($institution_name)
	{
		$sql = "SELECT * FROM mfi_setup_margin_buku_tab WHERE institution_name = ? order by posisi ASC";
		$query = $this->db->query($sql,array($institution_name));

		return $query->result_array();
	}

	public function get_all_produk_deposito()
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code,
				mfi_product_deposit.product_name
				FROM 
				mfi_product_deposit";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function export_list_saldo_deposito($produk)
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code as kode,
				mfi_product_deposit.product_name as keterangan,
				COUNT(mfi_account_deposit.*) as jumlah,
				SUM(mfi_account_deposit.nominal) as nominal
				FROM 
				mfi_account_deposit 
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE mfi_product_deposit.product_code = ?
				AND mfi_account_deposit.status_rekening = '1'
				GROUP BY 1,2
				";
		$query = $this->db->query($sql,array($produk));

		return $query->result_array();
	}

	public function get_produk_deposito($produk)
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code,
				mfi_product_deposit.product_name
				FROM 
				mfi_product_deposit 
				WHERE mfi_product_deposit.product_code = ?
				";
		$query = $this->db->query($sql,array($produk));

		$row = $query->row_array();
		return $row['product_name'];
	}

	public function export_rekap_pembukaan_deposito($produk,$from_date,$thru_date)
	{
		$sql = "SELECT 
				mfi_product_deposit.product_code as kode,
				mfi_product_deposit.product_name as keterangan,
				COUNT(mfi_account_deposit.*) as jumlah,
				SUM(mfi_account_deposit.nominal) as nominal
				FROM 
				mfi_account_deposit 
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE mfi_product_deposit.product_code = ?
				AND mfi_account_deposit.tanggal_buka BETWEEN ? AND ?
				GROUP BY 1,2
				";
		$query = $this->db->query($sql,array($produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function export_rekap_bagi_hasil_deposito($produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_account_deposit_bahas.account_deposit_no,
				mfi_account_deposit_bahas.tanggal,
				mfi_cif.nama,
				mfi_account_deposit_bahas.saldo_bahas,
				mfi_account_deposit_bahas.nominal_bahas,
				mfi_account_deposit_bahas.zakat_bahas,
				mfi_account_deposit_bahas.pajak_bahas
				FROM
				mfi_account_deposit_bahas
				INNER JOIN mfi_account_deposit ON mfi_account_deposit_bahas.account_deposit_no = mfi_account_deposit.account_deposit_no
				INNER JOIN mfi_cif ON mfi_account_deposit.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				WHERE mfi_product_deposit.product_code = ?
				AND mfi_account_deposit_bahas.tanggal BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function export_list_rekening_deposito($cif_no,$no_rek,$produk,$from_date,$thru_date)
	{
		$sql = "SELECT
				mfi_trx_account_deposit.trx_date,
				mfi_trx_account_deposit.description,
				mfi_account_deposit.nominal,
				mfi_account_deposit.nilai_bagihasil_last,
				mfi_account_deposit_bahas.nominal_bahas,
				mfi_account_deposit_bahas.pajak_bahas
				FROM
				mfi_trx_account_deposit
				INNER JOIN mfi_account_deposit ON mfi_trx_account_deposit.account_deposit_no = mfi_account_deposit.account_deposit_no
				INNER JOIN mfi_product_deposit ON mfi_product_deposit.product_code = mfi_account_deposit.product_code
				INNER JOIN mfi_cif ON mfi_cif.cif_no = mfi_account_deposit.cif_no
				INNER JOIN mfi_account_deposit_bahas ON mfi_trx_account_deposit.account_deposit_no = mfi_account_deposit_bahas.account_deposit_no
				WHERE mfi_cif.cif_no = ? AND mfi_account_deposit.account_deposit_no = ? AND mfi_product_deposit.product_code = ? AND mfi_trx_account_deposit.trx_date BETWEEN ? AND ?
				";
		$query = $this->db->query($sql,array($cif_no,$no_rek,$produk,$from_date,$thru_date));

		return $query->result_array();
	}

	public function datatable_rekening_buku_tabungan_setup($sWhere='',$sOrder='',$sLimit='')
	{
		// $branch_code = $this->session->userdata('branch_code');
		// $flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "SELECT
				mfi_trx_account_saving.account_saving_no,
				mfi_trx_account_saving.trx_date,
				mfi_trx_account_saving.amount,
				mfi_trx_account_saving.flag_debit_credit,
				mfi_account_saving.saldo_riil,
				mfi_trx_account_saving.trx_account_saving_id,
				mfi_cif.nama
				FROM
				mfi_trx_account_saving
				INNER JOIN mfi_account_saving ON mfi_trx_account_saving.account_saving_no = mfi_account_saving.account_saving_no
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				";


		

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		// if ( $sOrder != "" )
			// $sql .= "$sOrder ";
			$sql .= " ORDER BY mfi_trx_account_saving.trx_date, mfi_trx_account_saving.trx_sequence ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);	
		return $query->result_array();
	}

	function get_detail_transaction($trx_gl_id)
	{
		$sql = "select 
				mfi_gl_account.account_code,
				mfi_gl_account.account_name,
				mfi_trx_gl_detail.flag_debit_credit,
				mfi_trx_gl_detail.amount,
				mfi_trx_gl_detail.description
				from mfi_trx_gl_detail , mfi_gl_account
				where mfi_trx_gl_detail.account_code = mfi_gl_account.account_code 
				and mfi_trx_gl_detail.trx_gl_id = ?
				order by mfi_trx_gl_detail.trx_sequence asc
				";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}

	/*CETAK VOUCHER BEGIN*/


	function datatable_cetak_voucher($dWhere='', $sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();

		$sql = "SELECT
			mfi_trx_gl.trx_gl_id,
			mfi_trx_gl.voucher_no,
			mfi_trx_gl.voucher_ref,
			mfi_trx_gl.trx_date,
			mfi_trx_gl.voucher_date,
			mfi_trx_gl.description,
			(select sum(mfi_trx_gl_detail.amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'C') as total_credit,
			(select sum(mfi_trx_gl_detail.amount) from mfi_trx_gl_detail where mfi_trx_gl_detail.trx_gl_id = mfi_trx_gl.trx_gl_id and mfi_trx_gl_detail.flag_debit_credit = 'D') as total_debit
			from mfi_trx_gl where branch_code is not null
		";
		if ( $sWhere != "" ) {

			if($dWhere['from_date']!="" || $dWhere['to_date']!=""){
				$sql .= " $sWhere and mfi_trx_gl.trx_date between ? and ? ";
				$param[] = $dWhere['from_date'];
				$param[] = $dWhere['to_date'];
			}else{
				$sql .= " $sWhere ";
			}

		}else{

			if($dWhere['from_date']!="" || $dWhere['to_date']!=""){
				$sql .= " and mfi_trx_gl.voucher_date between ? and ? ";
				$param[] = $dWhere['from_date'];
				$param[] = $dWhere['to_date'];
			}

		}

		if( $dWhere['voucher_ref'] != "" ) {
			$sql .= " and voucher_ref like ? ";
			$param[] = $dWhere['voucher_ref'];
		}
		
		if( $dWhere['voucher_no'] != "" ) {
			$sql .= " and voucher_no like ? ";
			$param[] = $dWhere['voucher_no'];
		}
		
		if( $dWhere['jurnal_trx_type'] != "" ) {
			$sql .= " and jurnal_trx_type = ? ";
			$param[] = $dWhere['jurnal_trx_type'];
		}
		$branch_code = $this->session->userdata('branch_code');
		if ($branch_code!='00000') {
			$sql .= " AND mfi_trx_gl.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $this->session->userdata('branch_code');
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_trx_gl_by_id($trx_gl_id)
	{
		$sql = "select
					a.voucher_no,
					a.trx_date
				from mfi_trx_gl a
				where a.trx_gl_id = ?";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->row_array();
	}

	public  function get_trx_gl_detail_by_trx_gl_id($trx_gl_id)
	{
		/*$sql = "select
					b.account_code,
					b.account_name,
					(case when flag_debit_credit = 'C' then coalesce(a.amount,0) else 0 end) as credit,
					(case when flag_debit_credit = 'D' then coalesce(a.amount,0) else 0 end) as debit
				from mfi_trx_gl_detail a, mfi_gl_account b
				where a.account_code = b.account_code and
				a.trx_gl_id = ?
				order by a.trx_sequence asc
		";*/
		$sql = "select
					b.account_code,
					b.account_name,
					(case when flag_debit_credit = 'C' then coalesce(a.amount,0) else 0 end) as credit,
					(case when flag_debit_credit = 'D' then coalesce(a.amount,0) else 0 end) as debit
				from mfi_trx_gl_detail a, mfi_gl_account b
				where a.account_code = b.account_code and
				a.trx_gl_id = ?
				order by a.trx_sequence asc
		";
		$query = $this->db->query($sql,array($trx_gl_id));

		return $query->result_array();
	}


	public function get_trx_gl($from_date,$thru_date,$branch_code,$jurnal_trx_type='')
	{
		if($from_date=="---" && $thru_date=="---"){
			$sql = "select * from mfi_trx_gl";
			$param=array();
			if($branch_code!='00000'){
				$sql .= " where branch_code in (select branch_code from mfi_branch_member where branch_induk = ?)";
				$param[] = $branch_code;
			}
			if($jurnal_trx_type!=''){
				$sql .= " and jurnal_trx_type = ? ";
				$param[] = $jurnal_trx_type;
			}
			$query = $this->db->query($sql,$param);
		}else{
			$sql = "select * from mfi_trx_gl where voucher_date between ? and ?";
			$param[] = $from_date;
			$param[] = $thru_date;
			if($branch_code!='00000'){
				$sql .= " and branch_code in (select branch_code from mfi_branch_member where branch_induk = ?)";
				$param[] = $branch_code;
			}
			if($jurnal_trx_type!=''){
				$sql .= " and jurnal_trx_type = ? ";
				$param[] = $jurnal_trx_type;
			}
			$query = $this->db->query($sql,$param);
		}

		return $query->result_array();
	}

	public function get_cif_by_account_financing_no($account_financing_no)
	{
		$sql="select 
				mfi_cif.cif_no,
				mfi_cif.branch_code,
				mfi_cif.cif_type
			  from mfi_account_financing,mfi_cif
			  where mfi_account_financing.cif_no=mfi_cif.cif_no
			  and mfi_account_financing.account_financing_no=?
			";
		$query=$this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_produk_pembiayaan_individu()
	{
		$sql = "select * from mfi_product_financing where jenis_pembiayaan = 0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/************************************************************/
	//TAMBAHAN ADE (RESORT)
	public function get_all_resort_by_branch_code($branch_code='')
	{
		$param = array();
		$sql = "SELECT resort_code,resort_name from mfi_resort ";
		if ($branch_code!='00000') {
			$sql .=" WHERE branch_code=? ";
			$param[] = $branch_code;
		}
		$sql .=" ORDER BY 1 ";
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}
	public function get_resort_name($resort_code)
	{
		$sql = "SELECT resort_name FROM mfi_resort WHERE resort_code = ?";
		$query = $this->db->query($sql,array($resort_code));
		$row = $query->row_array();
		if(isset($row['resort_name'])){
			return $row['resort_name'];
		}else{
			return 'Semua';
		}
	}
	//END TAMBAHAN ADE (RESORT)
	/************************************************************/

	public function get_all_petugas()
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql = "select * from mfi_fa where branch_code!='00000'";
		if ($flag_all_branch==0) {
			$sql .= " AND branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[] = $branch_code;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_all_produk()
	{
		$sql = "select * from mfi_product_financing where jenis_pembiayaan = 0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_produk_name($produk)
	{
		$sql = "select product_name from mfi_product_financing where product_code = ?";
		$query = $this->db->query($sql,array($produk));
		$row = $query->row_array();
		if(isset($row['product_name'])){
			return $row['product_name'];
		}else{
			return 'Semua';
		}
	}

	public function get_petugas_name($petugas)
	{
		$sql = "select fa_name from mfi_fa where fa_code = ?";
		$query = $this->db->query($sql,array($petugas));
		$row = $query->row_array();
		if(isset($row['fa_name'])){
			return $row['fa_name'];
		}else{
			return 'Semua';
		}
	}

	public function get_par()
	{
		$sql = "select tanggal_hitung from mfi_par group by 1 order by tanggal_hitung desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_account_group_by_code($group_code)
	{
		$sql = "select group_code, group_name from mfi_gl_account_group where group_code=?";
		$query=$this->db->query($sql,array($group_code));
		return $query->row_array();
	}

	public function datatable_cetak_cover_buku_tabungan($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT
				mfi_account_saving.account_saving_no,
				mfi_cif.cif_no,
				mfi_cif.nama
				FROM
				mfi_account_saving
				INNER JOIN mfi_cif ON mfi_account_saving.cif_no = mfi_cif.cif_no
				";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		$sql .= " ORDER BY mfi_account_saving.account_saving_no ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function fn_get_saldo_gl_account2($account_code,$last_date,$branch_code)
	{
		$sql = "select fn_get_saldo_awal_gl_account2(?,?,?) as saldo_awal";
		$param[]=$account_code;
		$param[]=$last_date;
		if($branch_code!='00000'){
			$param[]=$branch_code;
		}else{
			$param[]='all';
		}
		$query = $this->db->query($sql,$param);
		// print_r($this->db);
		return $query->row_array();
	}

	public function fn_get_saldo_gl_account_sayyid($account_code,$last_date,$branch_code)
	{
		$sql = "select fn_get_saldo_awal_gl_account_sayyid(?,?,?) as saldo_awal";
		$param[]=$account_code;
		$param[]=$last_date;
		if($branch_code!='00000'){
			$param[]=$branch_code;
		}else{
			$param[]='all';
		}
		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	/*
	| DATA UNTUK LAPORAN ARUS KAS
	| parameter : Cabang, GL Account Cash, Periode
	| Output : Saldo Awal, Data Penerimaan, Data Pengeluaran
	*/
	function data_laporan_arus_kas($branch_code,$account_cash_code,$periode_awal,$periode_akhir)
	{
		/*saldo awal*/
		$sql_saldo_awal = "select fn_get_saldo_awal_gl_account_sayyid(?,?,?) as saldo_awal";
	    $param_saldo_awal[] = $account_cash_code;
	    $param_saldo_awal[] = $periode_awal;
	    if($branch_code=='00000'){
	    	$param_saldo_awal[] = 'all';
	    }else{
	    	$param_saldo_awal[] = $branch_code;
	    }

	    $query_saldo_awal = $this->db->query($sql_saldo_awal,$param_saldo_awal);
	    $row_saldo_awal = $query_saldo_awal->row_array();
	    
		/*Penerimaan*/
		$sql_penerimaan = "SELECT a.account_code,d.account_name,sum(a.amount) as amount
		FROM mfi_trx_gl_detail a,mfi_gl_account d
	    WHERE a.account_code=d.account_code AND 
	    	  a.trx_gl_id IN(select b.trx_gl_id from mfi_trx_gl b where b.trx_gl_id in(select c.trx_gl_id from mfi_trx_gl_detail c where c.account_code=?)
	    ";
	    $param_penerimaan[] = $account_cash_code;
	    if($branch_code!="00000"){
	    	$sql_penerimaan .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
		    $param_penerimaan[] = $branch_code;
		}
	    $sql_penerimaan .= " and b.voucher_date between ? and ?
	    ) AND a.account_code<>? AND a.flag_debit_credit='C' 
		GROUP BY 1,2
	    ";
	    $param_penerimaan[] = $periode_awal;
	    $param_penerimaan[] = $periode_akhir;
	    $param_penerimaan[] = $account_cash_code;
	    $param_penerimaan[] = $account_cash_code;

	    $query_penerimaan = $this->db->query($sql_penerimaan,$param_penerimaan);
	    $row_penerimaan = $query_penerimaan->result_array();

		/*Pengeluaran*/
		$sql_pengeluaran = "SELECT a.account_code,d.account_name,sum(a.amount) as amount
		FROM mfi_trx_gl_detail a,mfi_gl_account d
	    WHERE a.account_code=d.account_code AND 
	    	  a.trx_gl_id IN(select b.trx_gl_id from mfi_trx_gl b where b.trx_gl_id in(select c.trx_gl_id from mfi_trx_gl_detail c where c.account_code=?)
	    ";
	    $param_pengeluaran[] = $account_cash_code;
	    if($branch_code!="00000"){
	    	$sql_pengeluaran .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
		    $param_pengeluaran[] = $branch_code;
		}
	    $sql_pengeluaran .= " and b.voucher_date between ? and ?
	    ) AND a.account_code<>? AND a.flag_debit_credit='D' 
		GROUP BY 1,2
	    ";
	    $param_pengeluaran[] = $periode_awal;
	    $param_pengeluaran[] = $periode_akhir;
	    $param_pengeluaran[] = $account_cash_code;
	    $param_pengeluaran[] = $account_cash_code;

	    $query_pengeluaran = $this->db->query($sql_pengeluaran,$param_pengeluaran);
	    $row_pengeluaran = $query_pengeluaran->result_array();

	    $data['saldo_awal'] = isset($row_saldo_awal['saldo_awal'])?$row_saldo_awal['saldo_awal']:0;
	    $data['penerimaan'] = $row_penerimaan;
	    $data['pengeluaran'] = $row_pengeluaran;

	    return $data;
	}

	/*
	| REKAP NOMINATIF
	| SAYYID NURKILAH
	*/
	function data_rekap_nominatif($branch_code,$from_date,$thru_date)
	{
		$sql = "SELECT
				A.fa_code,
				C.resort_code,
				B.resort_code,
				A.fa_name,
				C.resort_name,
				(select count(*) from mfi_account_financing WHERE resort_code=B.resort_code AND tanggal_akad BETWEEN ? AND ?";
		/*concatenate for branch clause (droping)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as droping_count,
				(select sum(pokok) from mfi_account_financing WHERE resort_code=B.resort_code AND tanggal_akad BETWEEN ? AND ?";
		/*concatenate for branch clause (droping)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as droping_pokok,
				(select sum(margin) from mfi_account_financing WHERE resort_code=B.resort_code AND tanggal_akad BETWEEN ? AND ?";
		/*concatenate for branch clause (droping)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as droping_margin,
				(select count(*) from mfi_account_financing_lunas X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE Y.resort_code=B.resort_code AND X.tanggal_lunas BETWEEN ? AND ?";
		/*concatenate for branch clause (pelunasan)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as lunas_count,
				(select sum(X.saldo_pokok) from mfi_account_financing_lunas X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE Y.resort_code=B.resort_code AND X.tanggal_lunas BETWEEN ? AND ?";
		/*concatenate for branch clause (pelunasan)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as lunas_pokok,
				(select sum(X.saldo_margin) from mfi_account_financing_lunas X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE Y.resort_code=B.resort_code AND X.tanggal_lunas BETWEEN ? AND ?";
		/*concatenate for branch clause (pelunasan)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as lunas_margin,
				(select count(*) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (outstanding)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as outstanding_count,
				(select sum(saldo_pokok) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (outstanding)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as outstanding_pokok,
				(select sum(saldo_margin) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (outstanding)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as outstanding_margin,
				(select count(*) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (angsuran)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as angsuran_count,
				(select sum(angsuran_pokok) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (angsuran)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as angsuran_pokok,
				(select sum(angsuran_margin) from mfi_account_financing WHERE resort_code=B.resort_code";
		/*concatenate for branch clause (angsuran)*/
		if($branch_code!="00000"){
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as angsuran_margin,
				(select count(X.*) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='KL' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol2_count,
				(select sum(X.saldo_pokok) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='KL' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol2_pokok,
				(select count(X.*) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='R' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol3_count,
				(select sum(X.saldo_pokok) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='R' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol3_pokok,
				(select count(X.*) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='M' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol4_count,
				(select sum(X.saldo_pokok) from mfi_par X INNER JOIN mfi_account_financing Y ON X.account_financing_no=Y.account_financing_no WHERE X.par_desc='M' AND Y.resort_code=B.resort_code AND X.tanggal_hitung BETWEEN ? AND ?";
		/*concatenate for branch clause (kolektibilitas)*/
		$param[]=$from_date;
		$param[]=$thru_date;
		if($branch_code!="00000"){
			$sql .= " AND Y.branch_code in(select branch_code from mfi_branch_member where branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= ") as kol4_pokok
				FROM mfi_fa A
				INNER JOIN mfi_account_financing B ON A.fa_code=B.fa_code
				INNER JOIN mfi_resort C ON C.resort_code=B.resort_code
				";
		if($branch_code!="00000"){
			$sql .= "WHERE B.branch_code IN(select branch_code FROM mfi_branch_member WHERE branch_induk = ?) ";
			$param[] = $branch_code;
		}
		$sql .= "GROUP BY 1,2,3,4,5
				ORDER BY A.fa_code, B.resort_code, C.resort_code";

		$query = $this->db->query($sql,$param);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		return $query->result_array();
	}

	/*
	|get data branch
	*/
	function get_branch_by_branch_code($branch_code)
	{
		$sql="select * from mfi_branch where branch_code=?";
		$query=$this->db->query($sql,array($branch_code));
		return $query->row_array();
	}

	/*
	| GET DATA LENGKAP PEMBIAYAAN
	*/
	function get_data_lengkap_pembiayaan($account_financing_no)
	{
		$sql =" select 
					a.*,
					b.display_text as txt_sektor_ekonomi,
					c.display_text as txt_peruntukan,
					(select display_text from mfi_list_code_detail where code_value=a.jenis_jaminan::varchar and mfi_list_code_detail.code_group= 'jaminan') txt_jenis_jaminan,
					(select display_text from mfi_list_code_detail where code_value=a.jenis_jaminan_sekunder::varchar and mfi_list_code_detail.code_group= 'jaminan') txt_jenis_jaminan_sekunder
				from mfi_account_financing a
				left join mfi_list_code_detail b on b.code_value=a.sektor_ekonomi::varchar and b.code_group='sektor_ekonomi' 
				left join mfi_list_code_detail c on c.code_value=a.peruntukan::varchar and c.code_group='peruntukan' 
				where a.account_financing_no=?";
		$query=$this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	/*
	| GET DATA LENGKAP ANGGOTA
	*/
	function get_data_lengkap_anggota($cif_no)
	{
		$sql="select * from mfi_cif where cif_no=?";
		$query=$this->db->query($sql,array($cif_no));
		return $query->row_array();
	}

	/*
	| GET DATA FA
	*/
	function get_data_fa_by_fa_code($fa_code)
	{
		$sql="select * from mfi_fa where fa_code=?";
		$query=$this->db->query($sql,array($fa_code));
		return $query->row_array();
	}

	/*
	| GET DATA RESORT
	*/
	function get_data_resort_by_resort_code($resort_code)
	{
		$sql="select * from mfi_resort where resort_code=?";
		$query=$this->db->query($sql,array($resort_code));
		return $query->row_array();
	}
	/*
	| GET DATA PRODUCT FINANCING
	*/
	function get_data_product_financing_by_product_code($product_code)
	{
		$sql="select * from mfi_product_financing where product_code=?";
		$query=$this->db->query($sql,array($product_code));
		return $query->row_array();
	}
	/*
	| GET DATA AKAD FINANCING
	*/
	function get_akad_financing_by_akad_code($akad_code)
	{
		$sql="select * from mfi_akad where akad_code=?";
		$query=$this->db->query($sql,array($akad_code));
		return $query->row_array();
	}

	/***********************************************************************************/
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
	//END GET JADWAL ANGSURAN NON REGULER -- Ade Sagita 17-11-2014
	/***********************************************************************************/

	public function datatable_jtempo_angsuran($sWhere='',$sOrder='',$sLimit='',$branch='',$produk='',$tanggal='',$tanggal2='')
	{
		$param = array();
		// $sql = "SELECT
		// 		 a.cif_no
		// 		,a.jtempo_angsuran_next
		// 		,(a.angsuran_pokok+a.angsuran_margin) as besar_angsuran				
		// 		-- ,get_history_angsuran_ke(a.account_financing_no,a.jtempo_angsuran_last) as angsuran_ke
		// 		,a.counter_angsuran
		// 		,a.tanggal_akad
		// 		,(last_day(a.tanggal_jtempo) + INTERVAL '1' MONTH) as tanggal_jtempo
		// 		from mfi_account_financing a
		// 		left join mfi_product_financing c on c.product_code=a.product_code
		// 		where a.status_rekening=1
		// 		AND a.jtempo_angsuran_next BETWEEN ? AND ?
		// 		 ";

		$sql = "select 
				a.cif_no,
				a.counter_angsuran,
				(select sum(saldo_pokok+saldo_margin+angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as saldo_sebelumnya,
				(select sum(angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as besar_angsuran,
				(select jtempo_angsuran_next from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as jtempo_angsuran_next,
				(select last_day(tanggal_jtempo) from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as tanggal_jtempo
				from mfi_account_financing a
				where a.status_rekening=1
			";

		if($tanggal!="" && $tanggal2!=""){
		 	$sql .=" AND a.jtempo_angsuran_next BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}

		if($produk!="0000"){
			if($produk=='semua'){
				$sql .= " AND a.product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
			}else{
				$sql .= " AND a.product_code=?";
				$param[] = $produk;
			}
			// $sql .=" AND a.product_code=? ";
			// $param[]=$produk;
		}
		if ( $sWhere != "" )
			$sql .= "$sWhere ";

			$sql .= " group by 1,2 ";

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}else{
			$sql .= " ORDER BY a.counter_angsuran ";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	public function export_list_jatuh_tempo_angsuran($tanggal='',$tanggal2='',$produk='')
	{
		$param = array();
		// $sql = "SELECT
		// 		 a.cif_no
		// 		,a.jtempo_angsuran_next
		// 		,(a.angsuran_pokok+a.angsuran_margin) as besar_angsuran				
		// 		-- ,get_history_angsuran_ke(a.account_financing_no,a.jtempo_angsuran_last) as angsuran_ke
		// 		,a.counter_angsuran
		// 		,a.tanggal_akad
		// 		,(last_day(a.tanggal_jtempo) + INTERVAL '1' MONTH) as tanggal_jtempo
		// 		from mfi_account_financing a
		// 		left join mfi_product_financing c on c.product_code=a.product_code
		// 		where a.status_rekening=1
		// 		AND a.jtempo_angsuran_next BETWEEN ? AND ?
		// 		AND a.counter_angsuran=1
		// 		 ";
		// $param[] = $tanggal;
		// $param[] = $tanggal2;

		$sql = "select 
				a.cif_no,
				a.counter_angsuran,b.code_divisi, b.loker, b.kerja_bantu,
				(select sum(saldo_pokok+saldo_margin+angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as saldo_sebelumnya,
				(select sum(angsuran_pokok+angsuran_margin) from mfi_account_financing where cif_no = a.cif_no) as besar_angsuran,
				(select jtempo_angsuran_next from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as jtempo_angsuran_next,
				(select last_day(tanggal_jtempo) from mfi_account_financing where cif_no=a.cif_no and status_rekening=1 AND jtempo_angsuran_next BETWEEN '".$tanggal."' AND '".$tanggal2."' order by 1 asc limit 1) as tanggal_jtempo
				from mfi_account_financing a, mfi_pegawai b 
				where a.status_rekening=1 AND a.cif_no=b.nik
			";

		if($tanggal!="" && $tanggal2!=""){
		 	$sql .=" AND a.jtempo_angsuran_next BETWEEN ? AND ?";
			$param[] = $tanggal;
			$param[] = $tanggal2;
		}

		if($produk!="0000"){
			if($produk=='semua'){
				$sql .= " AND a.product_code IN ('61','62','63','64','65','66','67','68','69','70','74','52')";
			}else{
				$sql .= " AND a.product_code=?";
				$param[] = $produk;
			}
			/*$sql .=" AND a.product_code=? ";
			$param[]=$produk;*/
		}

		$sql .= " group by 1,2,b.code_divisi, b.loker, b.kerja_bantu ORDER BY b.code_divisi, b.loker, b.kerja_bantu ";
		
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function jqgrid_list_saldo_angsuran($sidx='',$sord='',$limit_rows='',$start='',$cif_no='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$where = !empty($cif_no) ? "mfi_account_saving.account_saving_no = '$cif_no'" : "";

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
					INNER JOIN mfi_account_saving ON mfi_account_saving.account_saving_no = mfi_cif.cif_no
					INNER JOIN mfi_product_saving ON mfi_account_saving.product_code = mfi_product_saving.product_code
					INNER JOIN mfi_branch ON mfi_account_saving.branch_code = mfi_branch.branch_code
					$where
				) AS X WHERE X.saldo_efektif > 0 ";

		$sql .= "$order $limit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	public function jqGrid_realisasi($sidx='',$sord='',$limit_rows='',$start='',$account_financing_no='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				 a.trx_account_financing_id,
				 a.trx_date,
				 a.account_financing_no,
				 (select fullname from mfi_user where user_id::varchar=a.created_by) as created_by,
				 a.created_date,
				 (select fullname from mfi_user where user_id::varchar=a.verify_by 	) as verify_by,
				 a.verify_date, a.pokok, a.margin, (case when a.trx_financing_type='2' then 'Pelunasan' else a.description end) AS description,
				 (select angsuran_pokok from mfi_account_financing where a.account_financing_no=account_financing_no) AS angsuran_pokok,
				 (select angsuran_margin from mfi_account_financing where a.account_financing_no=account_financing_no) AS angsuran_margin
				FROM mfi_trx_account_financing a
				WHERE a.account_financing_no=? AND a.trx_financing_type IN (1,2)
			  ";
		
		$param = array();
		$param[]=$account_financing_no;

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_lunas_realisasi($date='', $account_financing_no='')
	{
		$sql = "SELECT * from mfi_account_financing_lunas WHERE tanggal_lunas='$date' AND account_financing_no='$account_financing_no'";
		$query = $this->db->query($sql);
		return $query;
	}

	public function get_all_akad($produk='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_akad ";
		if($produk!=""){
			$sql .= " WHERE type_product=? ";
			$param[] = $produk;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_list_spb($keyword='')
	{
		$param = array();
		$sql = "SELECT id_spb, no_spb, tanggal_spb from mfi_spb WHERE approve_1=1 AND approve_2=1 AND approve_3=1 ";
		if($keyword!=""){
			$sql .= " AND LOWER(no_spb) LIKE ? ";
			$param[] = '%'.$keyword.'%';
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function export_list_peserta_asuransi($from_date='',$thru_date='',$product='')
	{
		$param = array();
		$sql = "SELECT 
					a.tanggal_spb
					,a.no_spb
					,d.nik
					,d.nama_pegawai
					,d.tgl_lahir
					,d.tempat_lahir
					,c.pokok jumlah_pembiayaan
					,c.jangka_waktu
					,c.biaya_asuransi_jiwa premi_asuransi
					,b.ujroh
					,b.premi_asuransi_tambahan
				FROM mfi_spb a 
				INNER JOIN mfi_spb_detail b ON a.no_spb=b.no_spb
				INNER JOIN mfi_account_financing c ON b.account_financing_no=c.account_financing_no
				INNER JOIN mfi_pegawai d ON d.nik=c.cif_no
				WHERE c.status_rekening=1 AND a.tanggal_spb BETWEEN ? AND ? ";
		$param[] = $from_date;
		$param[] = $thru_date;
		if ($product!='') {
			$sql .=" AND c.product_code=? ";
			$param[] = $product;
		}
		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}

	public function get_data_kopegtel()
	{
		$sql = "select * from mfi_kopegtel order by nama_kopegtel asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_status_telkom()
	{
		$sql = "SELECT distinct status_telkom FROM mfi_pegawai ORDER BY status_telkom ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_data_peruntukan()
	{
		$sql = "select display_text as peruntukan, code_value from mfi_list_code_detail where code_group = 'peruntukan'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function grid_angsuran($sidx='',$sord='',$limit_rows='',$start='',$from_date='',$thru_date='')
	{
		$param=array();
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT a.*, b.fullname 
				FROM mfi_angsuran_temp a 
				INNER JOIN mfi_user b ON b.user_id::varchar=a.import_by::varchar
				";
		if($from_date!='' && $thru_date!=''){
			$sql .= " WHERE import_date::date between ? AND ? ";
			$param[] = $from_date; 
			$param[] = $thru_date; 
		}
		$sql.= " $order $limit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function data_detail_angsuran_temp($angsuran_id)
	{
		$sql = "SELECT 
					 c.nik
					,c.nama_pegawai
					,b.jumlah_bayar
					,b.jumlah_settle
					,(b.jumlah_bayar-b.jumlah_settle) selisih
				FROM mfi_angsuran_temp_detail a
				INNER JOIN mfi_angsuran_bayar b ON b.nik=a.nik AND b.angsuran_id=a.angsuran_id
				INNER JOIN mfi_pegawai c ON c.nik=a.nik
				WHERE a.angsuran_id=?
				GROUP BY 1,2,3,4
				";
		$query = $this->db->query($sql,array($angsuran_id));
		return $query->result_array();
	}

	public function export_data_pembayaran($from_date,$thru_date)
	{
		$sql = "SELECT 
					 d.file_name
					,d.import_date
					,c.nik
					,c.nama_pegawai
					,b.jumlah_bayar
					,b.jumlah_settle
					,(b.jumlah_bayar-b.jumlah_settle) selisih
					,a.account_financing_no
					,a.hasil_proses
				FROM mfi_angsuran_temp_detail a
				INNER JOIN mfi_angsuran_bayar b ON b.nik=a.nik AND b.angsuran_id=a.angsuran_id
				INNER JOIN mfi_pegawai c ON c.nik=a.nik
				INNER JOIN mfi_angsuran_temp d ON d.angsuran_id=a.angsuran_id
				WHERE d.import_date::date between ? AND ?
				ORDER BY 2,1,3,9
				";
		$query = $this->db->query($sql,array($from_date,$thru_date));
		return $query->result_array();
	}

	public function get_acc_financing_by_no($account_financing_no='')
	{
		$sql = "SELECT 
						jangka_waktu
						,saldo_pokok
						,saldo_margin
						,counter_angsuran
						,(jangka_waktu-counter_angsuran) sisa_counter
				FROM mfi_account_financing 
				WHERE account_financing_no=?
				";
		$query = $this->db->query($sql,array($account_financing_no));
		return $query->row_array();
	}

	public function get_divisi($parent=null,$name=null)
	{
		if($parent=='1'){
			$sql = "SELECT DISTINCT code FROM mfi_divisi WHERE parent='$parent' ORDER BY code ASC";
		}else if($parent=='2'){
			$sql = "SELECT code FROM mfi_divisi WHERE name='$name'";
		}else{
			$sql = "SELECT DISTINCT name FROM mfi_divisi ORDER BY name ASC";
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}