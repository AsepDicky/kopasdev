<?php

class Model_android extends CI_Model {


	public function get_data_profile_anggota($CIFNO)
	{
		$sql = "select
		mfi_cif.nama,
		mfi_cm.cm_name
		from mfi_cif 
		left join mfi_cm on mfi_cm.cm_code = mfi_cif.cm_code
		where cif_no = ?";
		$query = $this->db->query($sql,array($CIFNO));

		return $query->result();
	}

	public function insert_data_profile_anggota($data)
	{
		$this->db->insert('mfi_profile_anggota',$data);
	}

}

?>