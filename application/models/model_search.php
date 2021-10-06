<?php

class Model_search extends CI_Model {

	function account_financing_no($keyword,$status_rekening=false,$inverse=false)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql="select 
				b.cif_no,
				b.nama,
				a.account_financing_no,
				a.status_rekening,
				(a.angsuran_pokok+a.angsuran_margin) angsuran,
				a.saldo_pokok,
				c.product_name
			  from 
			  	mfi_account_financing a
			  join mfi_cif b on a.cif_no=b.cif_no
			  join mfi_product_financing c ON c.product_code=a.product_code
			  where
			  	(a.account_financing_no like ? or upper(b.nama) like ?)
			";
		$param[]='%'.$keyword.'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		if($status_rekening!=false){
			if($inverse==true){
				$sql.=" and a.status_rekening<>?";
			}else{
				$sql.=" and a.status_rekening=?";
			}
			$param[]=$status_rekening;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}
	public function account_financing_reg_no($keyword,$status=false,$inverse=false)
	{
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		$sql="select 
				b.cif_no,
				b.nama,
				a.registration_no,
				a.status
			  from 
			  	mfi_account_financing_reg a
			  join mfi_cif b on a.cif_no=b.cif_no
			  where
			  	(a.registration_no like ? or upper(b.nama) like ?)
			";
		$param[]='%'.$keyword.'%';
		$param[]='%'.strtoupper(strtolower($keyword)).'%';
		if($status!=false){
			if($inverse==true){
				$sql.=" and a.status<>?";
			}else{
				$sql.=" and a.status=?";
			}
			$param[]=$status;
		}
		
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}

		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}

}
