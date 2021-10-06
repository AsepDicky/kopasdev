<?php

Class Model_administration extends CI_Model {

	public function jqgrid_menu_setup($sidx='',$sort='',$limit='',$start='')
	{
		$this->db->select("
			menu_id,
			menu_parent,
			menu_title,
			menu_url,
			menu_flag_link,
			menu_icon_parent,
			position
		");
		$this->db->from('mfi_menu');

		if($sidx!="" && $sort!="")
			$this->db->order_by($sidx,$sort);

		if($limit!="" && $start!="")
			$this->db->limit($limit,$start);
 
        $return = $this->db->get();

		return $return->result_array();
	}

	public function get_role_by_role_id($role_id)
	{
		$sql = "select * from mfi_user_role where role_id = ?";
		$query = $this->db->query($sql,array($role_id));

		return $query->row_array();
	}

	public function add_role($data)
	{
		$this->db->insert('mfi_user_role',$data);
	}

	public function delete_role($param)
	{
		$this->db->delete('mfi_user_role',$param);
	}

	public function edit_role($data,$param)
	{
		$this->db->update('mfi_user_role',$data,$param);
	}

	public function datatable_user_role_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT  role_id,role_name,role_desc FROM mfi_user_role ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_user_approval_spb($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_list_code_detail.list_code_detail_id,mfi_user.user_id,mfi_user.username,mfi_user.fullname,mfi_list_code_detail.code_group,mfi_list_code_detail.display_text, mfi_jabatan.nama_jabatan FROM mfi_user
				LEFT JOIN mfi_list_code_detail ON mfi_user.kode_jabatan = mfi_list_code_detail.code_value
				LEFT JOIN mfi_jabatan ON mfi_jabatan.kode_jabatan = mfi_list_code_detail.code_value
				WHERE mfi_list_code_detail.code_group='approvalspb'
				ORDER BY mfi_list_code_detail.display_text ASC";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function datatable_user_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT mfi_user.flag_all_branch,mfi_user.user_id,mfi_user.username,mfi_user_role.role_name,mfi_user.status,mfi_user.fullname,mfi_branch.branch_name FROM mfi_user
				LEFT JOIN mfi_user_role ON mfi_user_role.role_id = mfi_user.role_id 
				LEFT JOIN mfi_branch ON mfi_branch.branch_code = mfi_user.branch_code
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

	public function datatable_menu_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT 
				menu_id,
				menu_parent,
				(select a.menu_title from mfi_menu a where a.menu_id = mfi_menu.menu_parent) as menu_parent2,
				menu_title,
				menu_url,
				menu_flag_link,
				menu_icon_parent,
				position
				FROM mfi_menu
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

	public function get_menu_parent()
	{
		$sql = "select
				mfi_menu.menu_id,
				mfi_menu.menu_parent,
				(select (select b.menu_title from mfi_menu as b where b.menu_id = a.menu_parent) from mfi_menu as a where a.menu_id = mfi_menu.menu_parent) as menu_parent_parent_title,
				(select c.menu_title from mfi_menu as c where c.menu_id = mfi_menu.menu_parent) as menu_parent_title,
				mfi_menu.menu_title,
				mfi_menu.menu_url,
				mfi_menu.menu_flag_link,
				mfi_menu.menu_icon_parent,
				mfi_menu.position
				from mfi_menu 
				order by menu_parent,position asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add_menu($data)
	{
		$this->db->insert('mfi_menu',$data);
	}

	public function get_new_position_menu($position)
	{
		$sql = "select max(position) as position from mfi_menu where menu_parent = ?";
		$query = $this->db->query($sql,array($position));

		$row = $query->row_array();
		return $row['position']+1;
	}

	public function delete_menu($param)
	{
		$this->db->delete('mfi_menu',$param);
	}

	public function get_menu_by_menu_id($menu_id)
	{
		$sql = "select * from mfi_menu where menu_id = ?";
		$query = $this->db->query($sql,array($menu_id));

		return $query->row_array();
	}

	public function edit_menu($data,$param)
	{
		$this->db->update('mfi_menu',$data,$param);
	}

	public function get_menu_parent_by_role($role_id)
	{
		$sql = "SELECT
				mfi_menu.menu_id,
				mfi_menu.menu_title,
				mfi_user_nav.role_id
				FROM mfi_menu
				LEFT JOIN mfi_user_nav ON mfi_user_nav.menu_id = mfi_menu.menu_id and mfi_user_nav.role_id = ?
				WHERE mfi_menu.menu_parent = '0' order by mfi_menu.position asc";

		$query = $this->db->query($sql,array($role_id));

		return $query->result_array();
	}

	public function get_menu_child_by_role($role_id,$menu_parent)
	{
		$sql = "SELECT
				mfi_menu.menu_id,
				mfi_menu.menu_title,
				mfi_user_nav.role_id
				FROM mfi_menu
				LEFT JOIN mfi_user_nav ON mfi_user_nav.menu_id = mfi_menu.menu_id and mfi_user_nav.role_id = ?
				WHERE mfi_menu.menu_parent = ? order by mfi_menu.position asc";

		$query = $this->db->query($sql,array($role_id,$menu_parent));

		return $query->result_array();
	}

	public function delete_user_nav($param)
	{
		$this->db->delete('mfi_user_nav',$param);
	}

	public function insert_batch_user_nav($data)
	{
		$this->db->insert_batch('mfi_user_nav',$data);
	}

	public function change_themes($data,$param)
	{
		$this->db->update('mfi_user',$data,$param);
	}

	public function get_new_menu_id()
	{
		$sql = "select max(menu_id)+1 as menu_id from mfi_menu";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['menu_id'];
	}

	public function datatable_setup_margin($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_setup_margin_buku_tab ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add_margin_setup($data)
	{
		$this->db->insert('mfi_setup_margin_buku_tab',$data);
	}

	public function edit_margin_setup($data,$param)
	{
		$this->db->update('mfi_setup_margin_buku_tab',$data,$param);
	}

	public function get_margin_setup_by_id($setup_id)
	{
		$sql = "SELECT * FROM mfi_setup_margin_buku_tab WHERE setup_id = ? ";
		$query = $this->db->query($sql, array($setup_id));

		return $query->row_array(); 
	}

	public function delete_margin_setup($param)
	{
		$this->db->delete('mfi_setup_margin_buku_tab',$param);
	}
	
	public function check_no_in_setup_margin($no)
	{
		$sql = "select count(*) as num from mfi_setup_margin_buku_tab where item = ?";
		$query = $this->db->query($sql,array($no));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}

	public function datatable_user_kopegtel_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT 
				mfi_user.flag_all_branch,
				mfi_user.user_id,
				mfi_user.username,
				mfi_user_role.role_name,
				mfi_user.status,
				mfi_user.fullname,
				mfi_branch.branch_name 
				FROM mfi_user
				LEFT JOIN mfi_user_role ON mfi_user_role.role_id = mfi_user.role_id 
				LEFT JOIN mfi_branch ON mfi_branch.branch_code = mfi_user.branch_code
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

	public function search_username_kopegtel($keyword)
	{
		$sql = "select * from mfi_kopegtel where UPPER(nama_kopegtel) like ? or kopegtel_code like ?";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.$keyword.'%'));

		return $query->result_array();
	}

}

?>