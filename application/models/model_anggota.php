<?php

Class Model_anggota extends CI_Model 
{

	public function list_anggota_report($sidx='',$sord='',$limit_rows='',$start='',$rembug='',$cabang='')
	{
		$order = '';
		$limit = '';
		$param = array();

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT
				mfi_cif_kelompok.cif_id,
				mfi_cif.nama,
				mfi_cif.cif_no,
				mfi_cif.kabupaten,
				mfi_cif.kecamatan,
				mfi_cif.desa,
				mfi_cif.created_timestamp,
				(case when mfi_cm.cm_name is null then 'Individu' else mfi_cm.cm_name end) AS cm_name,
				(case when mfi_cm.cm_code is null then '0' else mfi_cm.cm_code end) AS cm_code
				FROM mfi_cif
				LEFT JOIN mfi_cm ON mfi_cm.cm_code = mfi_cif.cm_code
				LEFT JOIN mfi_branch ON mfi_branch.branch_id = mfi_cm.branch_id
				LEFT JOIN mfi_cif_kelompok ON mfi_cif_kelompok.cif_id = mfi_cif.cif_id
				WHERE mfi_cif.cif_type = '0'
				";

		if($rembug!="") 
		{
			$sql .= " AND mfi_cm.cm_code = ?";
			$param[] = $rembug;
		}

		if($cabang!="") 
		{
			$sql .= " AND mfi_branch.branch_code = ? ";
			$param[] = $cabang;
		}

		$sql .= "$order $limit";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function list_individu_report($sidx='',$sord='',$limit_rows='',$start='',$branch_code,$tglawal='',$tglakhir='')
	{
		$order = '';
		$limit = '';
		$param = array();

		$flag_all_branch = $this->session->userdata('flag_all_branch');

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT nama, cif_no, jenis_kelamin, tgl_lahir, usia FROM mfi_cif WHERE cif_type = '1'";

		if($tglawal!="" && $tglakhir!="") 
		{
			$sql .= " AND tgl_gabung BETWEEN ? AND ? ";
			$param[] = $tglawal;
			$param[] = $tglakhir;
		}

		if($flag_all_branch=='0')
		{
			if($branch_code!="00000"){
				$sql.=" AND branch_code = ?";
				$param[] = $branch_code;
			}
		}

		$sql .= " $order $limit";

		// $query = $this->db->query($sql);
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	// search cif number
	public function search_cif_no($keyword)
	{
		$sql = "select cif_no,nama from mfi_cif where (upper(nama) like ? or cif_no like ?) and cif_type = '1'";

		$param[] = '%'.strtoupper(strtolower($keyword)).'%';
		$param[] = '%'.$keyword.'%';
		
		/*if($type!="") {

			$sql 	.= ' and cif_type = ?';
			$param[] = $type;

		}

		if($cm_code!="" && $type=="0") {
			$sql .= ' and cm_code = ?';
			$param[] = $cm_code;
		}*/

		// print_r($this->db);
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_kecamatan_data()
	{
		$sql = "select kecamatan_code,kecamatan from mfi_city_kecamatan";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_desa_by_keyword($keyword,$kecamatan_browse)
	{
		$sql = "SELECT
				mfi_kecamatan_desa.desa_code,
				mfi_kecamatan_desa.desa,
				mfi_city_kecamatan.kecamatan_code,
				mfi_city_kecamatan.kecamatan
				FROM
				mfi_kecamatan_desa
				INNER JOIN mfi_city_kecamatan ON mfi_city_kecamatan.kecamatan_code = mfi_kecamatan_desa.kecamatan_code
				where (UPPER(desa) like ? or UPPER(desa_code) like ?)";
		if($kecamatan_browse!=""){
			$sql .= " and mfi_city_kecamatan.kecamatan_code = ?";
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%',$kecamatan_browse));
		}
		else
		{
			$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));
		}

		return $query->result_array();
	}

}