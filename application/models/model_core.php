<?php

class Model_core extends CI_Model {

	/**
	 * fungsi untuk mendapatkan menu id
	 * 
	 * @param menu_url (url)
	 *
	 */
	public function get_menu_id($menu_url)
	{
		$sql = "SELECT menu_id FROM mfi_menu WHERE menu_url = ?";
		$query = $this->db->query($sql,array($menu_url));

		$row = $query->row_array();

		if ( count($row) > 0 )
			return $row['menu_id'];
		else
			return NULL;
	}

	public function get_menu_title($menu_url)
	{
		$sql = "SELECT menu_title FROM mfi_menu WHERE menu_url = ?";
		$query = $this->db->query($sql,array($menu_url));

		$row = $query->row_array();

		if ( count($row) > 0 )
			return $row['menu_title'];
		else
			return NULL;
	}


	/**
	 * fungsi untuk mengambil menu
	 *
	 * @param role_id, menu_parent
	 *
	 * menu parent di set default 0 (Root Menu),
	 * 0 = Root Menu, > 0 = Sub Menu
	 */
	public function get_menu($role_id,$menu_parent=0)
	{
		$sql = "SELECT mfi_menu.menu_id
		,mfi_menu.menu_parent
		,mfi_menu.menu_title
		,mfi_menu.menu_url
		,mfi_menu.menu_flag_link
		,mfi_menu.menu_icon_parent 
		FROM mfi_menu 
		LEFT JOIN mfi_user_nav ON mfi_user_nav.menu_id = mfi_menu.menu_id
		WHERE mfi_user_nav.role_id = ? AND mfi_menu.menu_parent = ? ORDER BY position ASC";

		$query = $this->db->query($sql,array($role_id,$menu_parent));
		// echo "<pre>";
		// print_r($this->db);
		return $query->result_array();
	}

	public function get_menu_position($menu_parent=0)
	{
		$sql = "SELECT mfi_menu.menu_id
		,mfi_menu.menu_parent
		,mfi_menu.menu_title
		,mfi_menu.menu_url
		,mfi_menu.menu_flag_link
		,mfi_menu.menu_icon_parent 
		FROM mfi_menu 
		WHERE mfi_menu.menu_parent = ? ORDER BY position ASC";

		$query = $this->db->query($sql,array($menu_parent));
		// echo "<pre>";
		// print_r($this->db);
		return $query->result_array();
	}
	
	public function get_user()
	{
		$sql = "SELECT mfi_user.user_id,mfi_user.username,mfi_user_role.role_name,mfi_user.status FROM mfi_user
				LEFT JOIN mfi_user_role ON mfi_user_role.role_id = mfi_user.role_id
				ORDER BY mfi_user.created_stamp DESC
				";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_role()
	{
		$this->db->order_by('role_name','asc');
		$query = $this->db->get('mfi_user_role');
		return $query->result_array();
	}

	public function add_user($data)
	{
		$this->db->insert('mfi_user',$data);
	}

	public function save_device($device_id, $user_id)
	{
		// DELETE
		$this->db->where('user_id', $user_id);
   		$this->db->delete('mfi_user_device'); 

   		$arr = explode(';', $device_id);
		if(count($arr) > 1) {
			
			for ($i=0; count($arr) > $i ; $i++) { 
				$data = array(
					'user_id' 	=> $user_id
				   ,'device_id'	=> $arr[$i]
				);

				$this->db->insert('mfi_user_device',$data);
			}

		}else{
			
			$data = array(
					'user_id' 	=> $user_id
				   ,'device_id'	=> $device_id
				);
			$this->db->insert('mfi_user_device',$data);

		}
	}

	public function get_user_by_user_id($user_id)
	{
		$sql = "SELECT 
						*
				FROM 
						mfi_user 
				WHERE 
						user_id = ?";
		$query = $this->db->query($sql,array($user_id));

		return $query->row_array();
	}

	public function get_user_device($user_id)
	{
		$sql = "SELECT  user_id,
				        array_to_string
				        (
				        ARRAY   (
				                SELECT  DISTINCT device_id
				                FROM    mfi_user_device gi
				                WHERE   gi.user_id= gd.user_id
				                ORDER BY
				                        device_id
				                ),
				        ';'
				        ) AS device_id
				FROM    (
				        SELECT  user_id
				        FROM    mfi_user_device
				        GROUP BY
				                user_id
				        ) gd
				WHERE gd.user_id = ?
				ORDER BY user_id";
		$query = $this->db->query($sql,array($user_id));

		return $query->row_array();
	}

	public function edit_user($data,$param)
	{
		$this->db->update('mfi_user',$data,$param);
	}

	public function delete_user($param)
	{
		$this->db->delete('mfi_user',$param);
	}

	public function get_notification($status='')
	{
		$sql = "select * from mfi_notification";
		if($status!=''){
			$sql .= " where status = ?";
		}
		$query = $this->db->query($sql,array($status));

		return $query->result_array();

	}

	public function get_branch()
	{
		$sql = "select branch_id,branch_code,branch_name from mfi_branch where branch_status = '1'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function edit_profile($data,$param)
	{
		$this->db->update('mfi_user',$data,$param);
	}

	public function get_current_date()
	{
		// $sql = "select date_current from mfi_date_transaction";
		$sql = "select periode_awal from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['periode_awal'];
	}

	// get_user_by_user_keyword

	public function get_user_by_user_keyword($keyword,$branch_code)
	{
		$sql = "select * from mfi_user where username like ? and branch_code = ? order by user_id asc";
		$query = $this->db->query($sql,array('%'.$keyword.'%',$branch_code));

		return $query->result_array();
	}

	// get_trx_kontrol_periode_active

	public function get_trx_kontrol_periode_active()
	{
		$sql = "select periode_id, periode_awal, periode_akhir from mfi_trx_kontrol_periode where status = 1 limit 1";
		$query = $this->db->query($sql);

		return $query->row_array();
	}
	/**
	* get jabatan
	* @author sayyid
	*/
	public function get_jabatan()
	{
		$sql = "select * from mfi_jabatan order by kode_jabatan asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	/**
	* get status exists dari kas user
	* @author sayyid
	* @param $user_id
	*/
	public function get_is_exist_user_cash($user_id)
	{
		$sql = "select coalesce(count(*),0) as num_exist from mfi_gl_account_cash where user_id=?";
		$query=$this->db->query($sql,array($user_id));
		$row=$query->row_array();
		if($row['num_exist']>0){
			return true;
		}else{
			return false;
		}
	}

	public function get_role_kopegtel()
	{
		$sql = "select * from mfi_user_role where role_id = '43' order by role_name asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function get_approval_limit_time()
	{
		$sql = "select code_value from mfi_list_code_detail where code_group = 'approvelimittime'";
		$query = $this->db->query($sql);
		$row = $query->row_array();

		if (isset($row['code_value'])) { 
			return $row['code_value']; 
		} else { 
			return 0; 
		}
	}

	function cek_menu_is_exists($url)
	{
		$sql = "select count(*) jml from mfi_menu where upper(replace(menu_url,'/','')) = ?";
		$query = $this->db->query($sql,array($url));
		$row = $query->row_array();
		if ($row['jml']>0) {
			return true;
		} else {
			return false;
		}
	}

	function get_menu_id_by_url($url)
	{
		$sql = "select menu_id from mfi_menu where upper(replace(menu_url,'/','')) = ?";
		$query = $this->db->query($sql,array($url));
		$row = $query->row_array();
		if (isset($row['menu_id'])) {
			return $row['menu_id'];
		} else {
			return false;
		}
	}

	function cek_url_is_allowed($menu_id,$role_id)
	{
		$sql = "select count(*) jml from mfi_user_nav where menu_id = ? and role_id = ?";
		$query = $this->db->query($sql,array($menu_id,$role_id));
		$row = $query->row_array();
		if ($row['jml']>0) {
			return true;
		} else {
			return false;
		}
	}

}