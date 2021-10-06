<?php

Class Model_dashboard extends CI_Model {

	public function get_anggota($branch_code)
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_cif
				WHERE branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
	}

	public function get_all_anggota()
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_cif";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_petugas($branch_code)
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_fa
				WHERE branch_code = ?";
		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
	}

	public function get_all_petugas()
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_all_rembug()
	{
		$sql = "SELECT
				COUNT (*) AS num
				FROM 
				mfi_cm";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function jumlah_pengajuan_pembiayaan()
	{
		$sql = "select count(*) num from mfi_account_financing_reg where status = '0'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['num'];
	}

	public function jumlah_proses_pembiayaan()
	{
		$sql = "select count(*) num
				from mfi_account_financing_reg a
				left join mfi_account_financing b on a.registration_no=b.registration_no
				where a.status = 1
				and coalesce(b.status_rekening,0)<>1
				";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['num'];
	}

	public function jumlah_cair_pembiayaan()
	{
		$sql = "select count(*) num from mfi_account_financing a, mfi_account_financing_droping b 
				where a.account_financing_no=b.account_financing_no 
				and a.status_rekening='1' and b.status_droping = '1'";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['num'];
	}

	public function outstanding()
	{
		$sql = "SELECT 
				COUNT(a.account_financing_no) count
				,SUM(a.saldo_pokok) saldo_pokok
				,SUM(a.saldo_margin) saldo_margin 
				FROM mfi_account_financing a, mfi_cif b, mfi_list_code_detail c
				WHERE a.cif_no=b.cif_no 
				AND a.peruntukan=c.display_sort AND c.code_group='peruntukan'
				AND a.status_rekening=1 ";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function jumlah_proses_terlambat($tgl)
	{
		$sql = "SELECT 
						a.kopegtel_code
						,b.nama_kopegtel
						,COUNT(registration_no) count
				FROM mfi_account_financing_reg a
				LEFT JOIN mfi_kopegtel b ON a.kopegtel_code=b.kopegtel_code
				INNER JOIN mfi_cif ON a.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = a.product_code
				WHERE a.status=0 AND a.tanggal_pengajuan<?
				GROUP BY 1,2
				ORDER BY 3 DESC
				";
		$query = $this->db->query($sql,array($tgl));
		return $query->result_array();
	}

	public function sum_proses_terlambat($tgl)
	{
		$sql = "SELECT 
						COUNT(a.registration_no) count
				FROM mfi_account_financing_reg a
				INNER JOIN mfi_cif ON a.cif_no = mfi_cif.cif_no
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = a.product_code
				WHERE a.status=0 AND a.tanggal_pengajuan<?
				";
		$query = $this->db->query($sql,array($tgl));
		$data = $query->row_array();
		return $data['count'];
	}

	public function count_peruntukan()
	{
		$sql = "SELECT a.peruntukan, b.display_text, COUNT(a.*) count FROM mfi_account_financing a,mfi_list_code_detail b
				WHERE a.peruntukan=b.display_sort AND b.code_group='peruntukan' AND a.status_rekening=1
				GROUP BY 1,2
				ORDER BY 3 DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function count_rekenig_aktif()
	{
		$sql = "SELECT COUNT(a.*) count
				FROM mfi_account_financing a,mfi_list_code_detail b
				WHERE a.peruntukan=b.display_sort AND b.code_group='peruntukan' AND a.status_rekening=1
				";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data['count'];
	}

	public function chart_peruntukan()
	{
		$sql = "SELECT a.peruntukan, b.display_text, COUNT(a.*) count, SUM(a.saldo_pokok) saldo_pokok FROM mfi_account_financing a,mfi_list_code_detail b
				WHERE a.peruntukan=b.display_sort AND b.code_group='peruntukan' AND a.status_rekening=1
				GROUP BY 1,2
				ORDER BY 3 DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function chart_product()
	{
		$sql = "SELECT b.product_name, COUNT(a.*) count, SUM(a.saldo_pokok) saldo_pokok FROM mfi_account_financing a,mfi_product_financing b
				WHERE a.product_code=b.product_code AND a.status_rekening=1
				GROUP BY 1
				ORDER BY 2 DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function show_unapproved()
	{
		$sql = "select count(*) as valid from mfi_user where kode_jabatan in(select code_value from mfi_list_code_detail where code_group='approvalspb') and user_id=?";
		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		$row = $query->row_array();
		if ($row['valid']==1){
			return true;
		} else {
			return false;
		}
	}

	function jumlah_pengajuan_unapproved()
	{
		$sql = "select count(*) as valid from mfi_user where kode_jabatan in(select code_value from mfi_list_code_detail where code_group='approvalspb') and user_id=?";
		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		$row = $query->row_array();
		if ($row['valid']>0){
			$sql2 = "select count(*) as jumlah from mfi_account_financing_reg where status='0' and status_asuransi='1'";
			$query2 = $this->db->query($sql2,array($this->session->userdata('user_id')));
			$row2 = $query2->row_array();
			return $row2['jumlah'];
		} else {
			return 0;
		}
	}
	function jumlah_spb_unapproved()
	{
		$sql = "select * from mfi_user where kode_jabatan in(select code_value from mfi_list_code_detail where code_group='approvalspb') and user_id=?";
		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		$row = $query->row_array();
		
		if (count($row)>0){
			$sqll = "select display_text from mfi_list_code_detail where code_value=? and code_group='approvalspb'";
			$queryy = $this->db->query($sqll,array($row['kode_jabatan']));
			$roww = $queryy->row_array();
			$approve = $roww['display_text'];
			if ($approve=='approval_1_spb') {
				$sql2 = "select count(*) as jumlah from mfi_spb where approve_1='0'";
			} else if ($approve=='approval_2_spb') {
				$sql2 = "select count(*) as jumlah from mfi_spb where approve_2='0'";
			} else if ($approve=='approval_3_spb') {
				$sql2 = "select count(*) as jumlah from mfi_spb where approve_3='0'";
			} else {
				$sql2 = "select 0 as jumlah";
			}
			$query2 = $this->db->query($sql2,array($this->session->userdata('user_id')));
			$row2 = $query2->row_array();
			return $row2['jumlah'];
		} else {
			return 0;
		}
	}

	public function view_proses_terlambat($tgl)
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name,
				mfi_fa.fa_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code limit 1) 
					end) as melalui
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				WHERE mfi_account_financing_reg.status=0 AND mfi_account_financing_reg.tanggal_pengajuan<?
				";
		$query = $this->db->query($sql,array($tgl));
		return $query->result_array();
	}

	public function view_pengajuan_pembiayaan()
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name,
				mfi_fa.fa_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code limit 1) 
					end) as melalui
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				WHERE mfi_account_financing_reg.status=0
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_proses_pembiayaan()
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name,
				mfi_fa.fa_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code limit 1) 
					end) as melalui
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				WHERE mfi_account_financing_reg.status=1
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function view_cair_pembiayaan()
	{
		$sql = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name,
				mfi_fa.fa_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code limit 1) 
					end) as melalui
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_account_financing_droping ON mfi_account_financing.account_financing_no = mfi_account_financing_droping.account_financing_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				WHERE mfi_account_financing.status_rekening='1' and mfi_account_financing_droping.status_droping = '1'
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function view_spb_unapproved()
	{
		$sql = "select * from mfi_user where kode_jabatan in(select code_value from mfi_list_code_detail where code_group='approvalspb') and user_id=?";
		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		$row = $query->row_array();
		
		if (count($row)>0){
			$sqll = "select display_text from mfi_list_code_detail where code_value=? and code_group='approvalspb'";
			$queryy = $this->db->query($sqll,array($row['kode_jabatan']));
			$roww = $queryy->row_array();
			$approve = $roww['display_text'];
			if ($approve=='approval_1_spb') {
				$sql2 = "select * from mfi_spb where approve_1='0'";
			} else if ($approve=='approval_2_spb') {
				$sql2 = "select * from mfi_spb where approve_2='0'";
			} else if ($approve=='approval_3_spb') {
				$sql2 = "select * from mfi_spb where approve_3='0'";
			} else {
				$sql2 = "select 0 as jumlah";
			}
			$query2 = $this->db->query($sql2,array($this->session->userdata('user_id')));
			return $query2->result_array();
		} else {
			return 0;
		}
	}

	function view_pengajuan_unapproved()
	{
		$sql = "select count(*) as valid from mfi_user where kode_jabatan in(select code_value from mfi_list_code_detail where code_group='approvalspb') and user_id=?";
		$query = $this->db->query($sql,array($this->session->userdata('user_id')));
		$row = $query->row_array();
		if ($row['valid']>0){
			$sql2 = "SELECT
				mfi_account_financing_reg.registration_no,
				mfi_account_financing_reg.rencana_droping,
				mfi_account_financing_reg.status,
				mfi_account_financing_reg.tanggal_pengajuan,
				mfi_cif.nama,
				(SELECT 
				mfi_list_code_detail.display_text AS peruntukan
				FROM mfi_list_code_detail
				WHERE mfi_list_code_detail.code_group= 'peruntukan' AND mfi_account_financing_reg.peruntukan = CAST(mfi_list_code_detail.display_sort as integer) limit 1
				),
				mfi_account_financing_reg.amount,
				mfi_account_financing.pokok AS jumlah_dicairkan,
				mfi_account_financing.tanggal_akad AS tanggal_dicairkan,
				mfi_product_financing.product_name,
				mfi_fa.fa_name,
				(case when mfi_account_financing_reg.pengajuan_melalui ='koptel' 
						then 'Koptel'
						else (SELECT nama_kopegtel FROM mfi_kopegtel WHERE kopegtel_code=mfi_account_financing_reg.kopegtel_code limit 1) 
					end) as melalui
				FROM
				mfi_account_financing_reg
				INNER JOIN mfi_cif ON mfi_account_financing_reg.cif_no = mfi_cif.cif_no
				LEFT JOIN mfi_account_financing ON mfi_account_financing_reg.registration_no = mfi_account_financing.registration_no
				LEFT JOIN mfi_fa ON mfi_fa.fa_code = mfi_account_financing.fa_code
				INNER JOIN mfi_product_financing ON mfi_product_financing.product_code = mfi_account_financing_reg.product_code
				WHERE mfi_account_financing_reg.status='0' and mfi_account_financing_reg.status_asuransi='1'";
			$query2 = $this->db->query($sql2,array($this->session->userdata('user_id')));
			return $query2->result_array();
		} else {
			return 0;
		}
	}

}