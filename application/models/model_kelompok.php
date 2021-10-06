<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_kelompok extends CI_Model {

	
	/****************************************************************************************/	
	// BEGIN ANGGOTA KELUAR
	/****************************************************************************************/
	public function get_all_mfi_city_kecamatan()
	{
		$sql = "SELECT * from mfi_city_kecamatan";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_verifikasi_mutasi_anggota_keluar($sWhere='',$sOrder='',$sLimit='',$branch_id='',$branch_code='',$trx_date='')
	{
		$sql = "SELECT
						mfi_cif_mutasi.cif_mutasi_id,
						mfi_cif_mutasi.description as alasan,
						mfi_cif_mutasi.potongan_pembiayaan,
						mfi_cm.cm_code,
						mfi_cm.cm_name,
						mfi_cif.cif_no,
						mfi_cif.nama,
						mfi_cif_mutasi.tanggal_mutasi,
						mfi_cif_mutasi.created_date,
						mfi_cif_mutasi.created_by
				FROM
						mfi_cif_mutasi
				LEFT JOIN mfi_cif ON mfi_cif.cif_no = mfi_cif_mutasi.cif_no
				LEFT JOIN mfi_cm ON mfi_cif.cm_code = mfi_cm.cm_code
				";

		$param = array();
		if ( $sWhere != "" ){
			$sql .= "$sWhere mfi_cif_mutasi.status=0";

			if($branch_id!=""){
				$sql .= " AND mfi_cif.branch_code = ? ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_cif_mutasi.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}else{
			$sql .= "WHERE mfi_cif_mutasi.status=0";

			if($branch_id!=""){
				$sql .= " AND mfi_cif.branch_code = ? ";
				$param[] = $branch_code;
			}

			if($trx_date!=""){
				$sql .= " AND mfi_cif_mutasi.tanggal_mutasi = ? ";
				$param[] = $trx_date;
			}
		}

		if ( $sOrder != "" )
			$sql .= "order by mfi_cif_mutasi.tanggal_mutasi asc ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function update_mutasi_anggota($data,$param)
	{
		$this->db->update('mfi_cif_mutasi',$data,$param);
	}

	function cek_pembiayaan_aja($cif_no){
		$sql = "SELECT COUNT(*) AS jumlah
		FROM mfi_account_financing
		WHERE status_rekening = '1' AND saldo_pokok != '0'
		AND saldo_margin != '0' AND cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	function cek_tabungan_aja($cif_no){
		$sql = "SELECT COUNT(*) AS jumlah
		FROM mfi_account_saving
		WHERE status_rekening = '1'
		AND saldo_memo != '0' AND cif_no = ?";

		$param = array($cif_no);

		$query = $this->db->query($sql,$param);

		return $query->row_array();
	}

	public function delete_mutasi_anggota($param)
	{
		$this->db->delete('mfi_cif_mutasi',$param);
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

	function get_pegawai_by_keyword($keyword){
		$sql = "SELECT * FROM mfi_cif WHERE status = '1' AND (UPPER(cif_no) LIKE ? OR UPPER(nama) LIKE ?)";

		$param = array('%'.strtoupper($keyword).'%','%'.strtoupper($keyword).'%');

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function search_desa_by_kecamatan($keyword,$kecamatan)
	{
		$sql = "SELECT
							*
				FROM
							mfi_kecamatan_desa
				WHERE (desa_code like ? or desa like ?) ";
		if($kecamatan!=""){
			$sql .= ' and kecamatan_code = ?';
			$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%',$kecamatan));
		}else{

			$query = $this->db->query($sql,array('%'.$keyword.'%','%'.strtoupper(strtolower($keyword)).'%'));
		}

		// print_r($this->db);

		return $query->result_array();
	}

	public function get_rembug_by_desa_code($desa_code)
	{
		$sql = "SELECT * from mfi_cm WHERE desa_code=? ";
		$query = $this->db->query($sql,array($desa_code));

		return $query->result_array();
	}

	public function get_anggota_rembug_by_cm_code($cm_code)
	{
		$sql = "SELECT * from mfi_cif WHERE cm_code=? AND status!=2 AND status!=3 ";
		$query = $this->db->query($sql,array($cm_code));

		return $query->result_array();
	}

	public function get_cif_by_cif_no($cif_no)
	{
		$sql = "SELECT * from mfi_cif WHERE cif_no=? AND status!=2 order by kelompok::integer asc ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function get_saldo_by_cif_no($cif_no)
	{
		$sql = "SELECT
							 mfi_cif.cif_no
							,mfi_cif.nama
							,sum(mfi_account_financing.saldo_pokok) AS saldo_pokok
							,sum(mfi_account_financing.saldo_margin) AS saldo_margin
							,sum(mfi_account_financing.saldo_catab) AS saldo_catab
							,sum(mfi_account_default_balance.tabungan_wajib) AS tabungan_wajib
							,sum(mfi_account_default_balance.tabungan_kelompok) AS tabungan_kelompok
							,sum(mfi_account_default_balance.tabungan_sukarela) AS tabungan_sukarela
							,sum(mfi_account_default_balance.tabungan_minggon) AS tabungan_minggon
							,sum(mfi_account_saving.saldo_memo) AS saldo_memo
							,sum(mfi_account_deposit.nominal) AS nominal
							,sum(mfi_account_default_balance.cadangan_resiko) AS cadangan_resiko
							,sum(mfi_account_default_balance.simpanan_pokok) AS simpanan_pokok
							,sum(mfi_account_default_balance.smk) AS smk
							,mfi_cif_mutasi.saldo_pembiayaan_pokok
							,mfi_cif_mutasi.saldo_pembiayaan_margin
							,mfi_cif_mutasi.saldo_pembiayaan_catab
							,mfi_cif_mutasi.saldo_tab_wajib as saldo_pembiayaan_tab_wajib
							,mfi_cif_mutasi.saldo_tab_kelompok as saldo_pembiayaan_tab_kelompok
							,mfi_cif_mutasi.potongan_pembiayaan
				FROM
							mfi_cif
				LEFT JOIN 	mfi_account_financing 		ON mfi_cif.cif_no = mfi_account_financing.cif_no AND mfi_account_financing.status_rekening = '1'
				LEFT JOIN 	mfi_account_default_balance ON mfi_cif.cif_no = mfi_account_default_balance.cif_no 
				LEFT JOIN 	mfi_account_saving 			ON mfi_cif.cif_no = mfi_account_saving.cif_no AND mfi_account_saving.status_rekening = '1'
				LEFT JOIN 	mfi_account_deposit 		ON mfi_cif.cif_no = mfi_account_deposit.cif_no AND mfi_account_deposit.status_rekening = '1'
				LEFT JOIN   mfi_cif_mutasi 				ON mfi_cif.cif_no = mfi_cif_mutasi.cif_no

				WHERE 
								mfi_cif.cif_no=?
							
				GROUP BY mfi_cif.cif_no,mfi_cif.nama,mfi_cif_mutasi.saldo_pembiayaan_pokok,mfi_cif_mutasi.saldo_pembiayaan_margin,mfi_cif_mutasi.potongan_pembiayaan,mfi_cif_mutasi.saldo_pembiayaan_catab,mfi_cif_mutasi.saldo_tab_wajib,mfi_cif_mutasi.saldo_tab_kelompok ";
		$query = $this->db->query($sql,array($cif_no));

		return $query->row_array();
	}

	public function proses_anggota_keluar($data)
	{
		$this->db->insert('mfi_cif',$data);
	}

	public function update_cif_status($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}

	/****************************************************************************************/	
	// END ANGGOTA KELUAR
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN ANGGOTA PINDAH
	/****************************************************************************************/

	public function proses_anggota_pindah($data)
	{
		$this->db->insert('mfi_cif_mutasi',$data);
	}

	public function update_cif_cm_code($data,$param)
	{
		$this->db->update('mfi_cif',$data,$param);
	}
	/****************************************************************************************/	
	// END ANGGOTA PINDAH
	/****************************************************************************************/

}