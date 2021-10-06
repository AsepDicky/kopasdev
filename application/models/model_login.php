<?php

class Model_login extends CI_Model {

	public function authentication($username,$password,$salt)
	{
		$password = sha1($password.$salt);
		$sql = "SELECT 
							mfi_user.user_id
							,mfi_user.username
							,mfi_user.role_id
							,mfi_user.fullname
							,mfi_user.photo
							,mfi_user.branch_code 
							,mfi_branch.branch_id 
							,mfi_branch.branch_code 
							,mfi_branch.branch_name 
							,mfi_branch.branch_induk 
							,mfi_branch.branch_class 
							,mfi_user.themes
							,mfi_user.flag_all_branch
							,mfi_user.kode_jabatan
							,mfi_institution.institution_name
							,mfi_institution.officer_name
							,mfi_institution.officer_title
							,mfi_institution.day_transaction
							,mfi_institution.max_plafon
							,mfi_institution.grace_period_kelompok
							,mfi_institution.grace_period_individu
							,mfi_institution.setoran_lwk
							,mfi_institution.minggon
							,mfi_institution.cif_type
							,mfi_institution.titipan_notaris
				from 
							mfi_user
				left join 	mfi_branch on mfi_branch.branch_code = mfi_user.branch_code ,
							mfi_institution
				WHERE 
						mfi_user.username = ? 
						AND mfi_user.password = ? 
						AND mfi_user.status = '1'";
		$query = $this->db->query($sql,array($username,$password));

		return $query->row_array();
	}

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

	public function get_user_device($user_id,$device_id)
	{
		$sql = "SELECT device_id FROM mfi_user_device WHERE user_id = '$user_id'
				UNION ALL
				SELECT device_id FROM mfi_user_device_list WHERE device_id = '$device_id'
				UNION ALL
				SELECT device_id FROM mfi_user_device_list WHERE device_id = 'free'";
		
		$query = $this->db->query($sql,array($user_id));

		return $query->num_rows();
	}

}