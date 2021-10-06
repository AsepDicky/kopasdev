<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_gl extends CI_Model {

	/* BEGIN SETUP GL ACCOUNT *******************************************************/
	public function get_code_value()
	{
		$sql = "SELECT code_value, code_group, display_text from mfi_list_code_detail where code_group='account_type' order by code_value asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function search_account_group($code_value)
	{
		$sql = "select group_code,group_name,account_type from mfi_gl_account_group where account_type = ? order by group_code asc";
		$query = $this->db->query($sql,array($code_value));

		return $query->result_array();
	}

	public function proses_input_setup_gl_account($data)
	{
		$this->db->insert('mfi_gl_account',$data);
	}

	public function proses_input_setup_gl_account_budget($data)
	{
		$this->db->insert('mfi_gl_account_budget',$data);
	}

	public function datatable_gl_account_setup($sWhere='',$sOrder='',$sLimit='',$account_type='',$account_group='')
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_type,
				mfi_gl_account.account_name,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere";
			if($account_type!=""){
				$sql .= " AND mfi_gl_account.account_type = '".$account_type."'";
				if($account_group!=""){
					$sql .= " AND mfi_gl_account.account_group_code = '".$account_group."'";
				}
			}
		}
		else{
			if($account_type!=""){
				$sql .= "WHERE mfi_gl_account.account_type = '".$account_type."'";
				if($account_group!=""){
					$sql .= " AND mfi_gl_account.account_group_code = '".$account_group."'";
				}
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";
		else
			$sql .= "ORDER BY mfi_gl_account.account_code asc ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function delete_gl_account($param)
	{
		$this->db->delete('mfi_gl_account',$param);
	}

	public function get_gl_account_by_id($gl_account_id)
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_type,
				mfi_gl_account.account_name,
				mfi_gl_account.account_group_code,
				mfi_gl_account.transaction_flag_default,
				mfi_gl_account_group.group_name,
				mfi_list_code_detail.code_value,
				mfi_list_code_detail.code_group,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				LEFT JOIN mfi_gl_account_group ON mfi_gl_account_group.account_type  = mfi_gl_account.account_type
				WHERE mfi_gl_account.gl_account_id = ?";
				
		$query = $this->db->query($sql,array($gl_account_id));

		return $query->row_array();
	}

	public function proses_edit_setup_gl_account($data,$param)
	{
		$this->db->update('mfi_gl_account',$data,$param);
	}

	public function get_gl_account_budget_by_id($account_code)
	{
		$sql = "SELECT
				* FROM mfi_gl_account_budget
				WHERE account_code = ?";
				
		$query = $this->db->query($sql,array($account_code));

		return $query->result_array();
	}

	public function proses_edit_setup_gl_account_budget($data,$param)
	{
		$this->db->update('mfi_gl_account_budget',$data,$param);
	}

	public function get_data_from_account_group($gl_account_id)
	{
		$sql = "SELECT
				mfi_gl_account.gl_account_id,
				mfi_gl_account.account_code,
				mfi_gl_account.account_name,
				mfi_list_code_detail.display_text
				FROM
				mfi_gl_account
				LEFT JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account.account_type AS VARCHAR) 
				WHERE mfi_list_code_detail.code_group = 'account_type'
				AND mfi_gl_account.gl_account_id = ? ";
		$query = $this->db->query($sql,array($gl_account_id));

		return $query->result_array();
	}

	/* END SETUP GL ACCOUNT *******************************************************/
	/****************************************************************************************/	
	// BEGIN ACCOUNT GROUP SETUP
	/****************************************************************************************/
	public function datatable_account_group_setup($sWhere='',$sOrder='',$sLimit='',$group_type='')
	{
		$sql = "SELECT
						mfi_gl_account_group.account_type,
						mfi_gl_account_group.group_name,
						mfi_gl_account_group.group_code,
						mfi_list_code_detail.display_text,
						mfi_list_code_detail.code_group,
						mfi_gl_account_group.gl_account_group_id
				FROM
						mfi_gl_account_group
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account_group.account_type AS VARCHAR)
				 ";

		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($group_type!=""){
				$sql .= " AND mfi_gl_account_group.account_type = '".$group_type."'";
			}
		}else{
			if($group_type!=""){
				$sql .= "WHERE mfi_gl_account_group.account_type = '".$group_type."'";
			}
		}

		if ( $sOrder != "" ){
			$sql .= "$sOrder ";
		}else{
			$sql .= "ORDER BY mfi_gl_account_group.group_code ASC";
		}

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_group_type()
	{
		$sql = "SELECT
						mfi_list_code_detail.code_group,
						mfi_list_code_detail.code_value,
						mfi_list_code_detail.display_text
				FROM
						mfi_list_code_detail
				where mfi_list_code_detail.code_group = 'account_type' ";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function add_account_group($data)
	{
		$this->db->insert('mfi_gl_account_group',$data);
	}

	public function delete_account_group($param)
	{
		$this->db->delete('mfi_gl_account_group',$param);
	}

	public function get_account_group_by_id($gl_account_group_id)
	{
		$sql = "SELECT
						mfi_gl_account_group.account_type,
						mfi_gl_account_group.group_name,
						mfi_gl_account_group.group_code,
						mfi_list_code_detail.display_text,
						mfi_list_code_detail.code_group,
						mfi_gl_account_group.gl_account_group_id
				FROM
						mfi_gl_account_group
				INNER JOIN mfi_list_code_detail ON mfi_list_code_detail.code_value  = CAST(mfi_gl_account_group.account_type AS VARCHAR) 
				WHERE 	mfi_list_code_detail.code_group = 'account_type' 
				AND 	mfi_gl_account_group.gl_account_group_id = ?
				";

		$query = $this->db->query($sql,array($gl_account_group_id));
		return $query->row_array();
	}

	public function edit_account_group($data,$param)
	{
		$this->db->update('mfi_gl_account_group',$data,$param);
	}
	
	public function check_group_code($group_code)
	{
		$sql = "select count(*) as num from mfi_gl_account_group where group_code = ?";
		$query = $this->db->query($sql,array($group_code));

		$row = $query->row_array();
		if($row['num']>0){
			return false;
		}else{
			return true;
		}
	}
	/****************************************************************************************/	
	// END ACCOUNT GROUP SETUP
	/****************************************************************************************/

	/****************************************************************************************/	
	// END SETUP KAS PETUGAS
	/****************************************************************************************/

	public function datatable_setup_kas_petugas($sWhere='',$sOrder='',$sLimit='')
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');

		$sql = "SELECT
				mfi_gl_account_cash.fa_code,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.account_cash_name,
				mfi_fa.fa_name,
				mfi_user.fullname,
				mfi_gl_account_cash.account_cash_id
				FROM
				mfi_gl_account_cash
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				LEFT JOIN mfi_user ON mfi_user.user_id = mfi_gl_account_cash.user_id
				WHERE mfi_gl_account_cash.fa_code is not null
				 ";

		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND mfi_fa.branch_code in(select branch_code from mfi_branch_member where branch_induk=?) ";
			$param[] = $branch_code;
		}

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= " $sOrder ";

		if ( $sLimit != "" )
			$sql .= " $sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	public function get_fa_name()
	{
		$sql = "SELECT fa_code, fa_name FROM mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_account_name()
	{
		$sql = "SELECT account_code, account_name FROM mfi_gl_account ORDER BY 1 ";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_ajax_count_cash_name($fa_code)
	{
		$sql = "select max(right(account_cash_code,2)) AS jumlah from mfi_gl_account_cash where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));

		return $query->row_array();
	}

	public function get_fa_code_from_mfi_fa($fa_code){
		$sql = "select fa_id,fa_code, fa_name from mfi_fa where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));
		
		$row = $query->row_array();
		return $row['fa_id'];
	}

	public function get_fa_name_from_mfi_fa($fa_code){
		$sql = "select fa_name from mfi_fa where fa_code = ?";
		$query = $this->db->query($sql,array($fa_code));
		
		$row = $query->row_array();
		return (isset($row['fa_name'])==false)?'':$row['fa_name'];
	}

	public function get_ajax_account_name($account_code){
		$sql = "select account_name from mfi_gl_account where account_code = ?";
		$query = $this->db->query($sql,array($account_code));
		
		$row = $query->row_array();
		return (isset($row['account_name'])==false)?'':$row['account_name'];
	}

	public function proses_input_setup_kas_petugas($data)
	{
		$this->db->insert('mfi_gl_account_cash',$data);
	}

	public function delete_gl_account_cash($param)
	{
		$this->db->delete('mfi_gl_account_cash',$param);
	}

	public function get_gl_account_cash_by_id($account_cash_id)
	{
		$sql = "SELECT
				mfi_user.fullname,
				mfi_gl_account_cash.user_id,
				mfi_gl_account_cash.account_cash_code,
				mfi_gl_account_cash.fa_code,
				mfi_gl_account_cash.account_cash_id,
				mfi_gl_account_cash.account_cash_name,
				mfi_gl_account_cash.gl_account_code,
				mfi_gl_account_cash.account_cash_type,
				mfi_gl_account.account_name,
				mfi_fa.fa_name,
				mfi_fa.branch_code
				FROM
				mfi_gl_account_cash
				INNER JOIN mfi_gl_account ON mfi_gl_account.account_code = mfi_gl_account_cash.gl_account_code
				INNER JOIN mfi_fa ON mfi_fa.fa_code = mfi_gl_account_cash.fa_code
				LEFT JOIN mfi_user ON mfi_user.user_id = mfi_gl_account_cash.user_id
				WHERE mfi_gl_account_cash.account_cash_id = ?";
				
		$query = $this->db->query($sql,array($account_cash_id));

		return $query->row_array();
	}

	public function proses_edit_setup_kas_petugas($data,$param)
	{
		$this->db->update('mfi_gl_account_cash',$data,$param);
	}

	function get_all_branch()
    {
        $sql = "SELECT * FROM  mfi_branch ";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

   	function get_fa_by_branch_code($branch_code)
    {
        $sql = "SELECT * FROM  mfi_fa WHERE branch_code = ? ";

		$query = $this->db->query($sql,array($branch_code));

		return $query->result_array();
    }

	/****************************************************************************************/	
	// END SETUP KAS PETUGAS
	/****************************************************************************************/

	public function get_gl_account_by_keyword($keyword)
	{
		$sql = "select * from mfi_gl_account where UPPER(account_code) like ? or UPPER(account_name) like ? order by account_code asc";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%'));

		return $query->result_array();
	}

	public function get_gl_account_kas_by_keyword($keyword)
	{
		$kode_kas='1010000';
		$sql = "select * from mfi_gl_account where (UPPER(account_code) like ? or UPPER(account_name) like ?)
				AND account_group_code=?
				order by account_code asc";
		$query = $this->db->query($sql,array('%'.strtoupper(strtolower($keyword)).'%','%'.strtoupper(strtolower($keyword)).'%',$kode_kas));

		return $query->result_array();
	}

	public function datatable_report_setup($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_gl_report ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);
		// print_r($this->db);
		return $query->result_array();
	}

	public function add_report_setup($data)
	{
		$this->db->insert('mfi_gl_report',$data);
	}

	public function delete_report_setup($param)
	{
		$this->db->delete('mfi_gl_report',$param);
	}

	public function get_row_report_setup($gl_report_id)
	{
		$sql = "select * from mfi_gl_report where gl_report_id = ?";
		$query = $this->db->query($sql,array($gl_report_id));

		return $query->row_array();
	}

	public function update_report_setup($data,$param)
	{
		$this->db->update('mfi_gl_report',$data,$param);
	}

	/* REPORT ITEM */

	public function datatable_report_item_setup($report_code='',$sOrder='',$sLimit='')
	{
		$sql = " SELECT * FROM mfi_gl_report_item WHERE report_code = ? ";

		if ( $sOrder != "" ){
			$sql .= " $sOrder ";
		}else{
			$sql .= " ORDER BY item_code ";
		}

		if ( $sLimit != "" )
			$sql .= " $sLimit ";

		$query = $this->db->query($sql,array($report_code));
		// print_r($this->db);
		return $query->result_array();
	}

	// add item
	public function add_report_item_setup($data)
	{
		$this->db->insert('mfi_gl_report_item',$data);
	}

	// delete item
	public function delete_report_item_setup($param)
	{
		$this->db->delete('mfi_gl_report_item',$param);
	}

	// get ajax
	public function get_row_report_item_setup($gl_report_item_id)
	{
		$sql = "select * from mfi_gl_report_item where gl_report_item_id = ?";
		$query = $this->db->query($sql,array($gl_report_item_id));

		return $query->row_array();
	}

	// update item
	public function update_report_item_setup($data,$param)
	{
		$this->db->update('mfi_gl_report_item',$data,$param);
	}

	/* report item member */

	// datatable
	public function datatable_report_item_member_setup($gl_report_item_id='',$sOrder='',$sLimit='',$account_type='',$account_code='')
	{
		$sql = "
		select 
		mfi_gl_account.account_code,
		mfi_gl_account.account_name,
		(select count(*) from mfi_gl_report_item_member where mfi_gl_report_item_member.account_code = mfi_gl_account.account_code and mfi_gl_report_item_member.gl_report_item_id = ?) as count
		from mfi_gl_account 
		";

		if ( $account_type != "0" ){
			$sql .= "WHERE account_type = $account_type ";
		}else{
			$sql .= "WHERE account_type IN(1,2,3,4,5) ";
		}

		if( $account_code != '0' && $account_code != 'selected' ){
			$sql .= " AND account_code LIKE '$account_code%'";
		}else{
			$sql .= " AND account_code != ''";
		}

		if ( $sOrder != "" ){ 
			$sql .= "$sOrder ";
		}else{
			$sql .=" ORDER BY account_code ";
		}
		if ( $sLimit != "" ){
			$sql .= "$sLimit ";
		}

		$query = $this->db->query($sql,array($gl_report_item_id));
		// print_r($this->db);
		return $query->result_array();
	}
	
	// delete report item member
	public function delete_report_item_member($param)
	{
		$this->db->delete('mfi_gl_report_item_member',$param);
	}

	// insert report item member
	public function insert_report_item_member($data)
	{
		$this->db->insert_batch('mfi_gl_report_item_member',$data);
	}

	function jqgrid_gl_report($sidx='',$sord='',$limit_rows='',$start='')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT * FROM mfi_gl_report $order $limit";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	function jqgrid_gl_report_item($sidx='',$sord='',$limit_rows='',$start='',$report_code)
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT * FROM mfi_gl_report_item WHERE report_code=? $order $limit";
		$param[] = $report_code;
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function jqgrid_gl_report_item_member_out($sidx='',$sord='',$limit_rows='',$start='',$gl_report_item_id,$account_type='all')
	{
		if ($gl_report_item_id!="") {
			$order = '';
			$limit = '';

			if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
			if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

			$sql = "SELECT account_code,account_name FROM mfi_gl_account WHERE status_account=1 AND account_code not in(SELECT account_code FROM mfi_gl_report_item_member WHERE gl_report_item_id=?)";
			$param[] = $gl_report_item_id;
			
			if ($account_type!='all') {
				$sql.= " AND account_type=?";
				$param[] = $account_type;
			}
			$sql.=" $order $limit";
			$query = $this->db->query($sql,$param);

			return $query->result_array();
		} else {
			return array();
		}
	}
	function jqgrid_gl_report_item_member_in($sidx='',$sord='',$limit_rows='',$start='',$gl_report_item_id,$account_type='all')
	{
		$order = '';
		$limit = '';

		if ($sidx!='' && $sord!='') $order = "ORDER BY $sidx $sord";
		if ($limit_rows!='' && $start!='') $limit = "LIMIT $limit_rows OFFSET $start";

		$sql = "SELECT a.gl_report_item_member , b.account_code, b.account_name
				FROM mfi_gl_report_item_member a, mfi_gl_account b
				WHERE a.gl_report_item_id=?  and a.account_code=b.account_code
				";
		$param[] = $gl_report_item_id;
		
		if ($account_type!="all") {
			$sql .= " AND b.account_type=?";
			$param[] = $account_type;
		}
		$sql .= " $order $limit";
		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}

	function insert_gl_report_item_member($data)
	{
		$this->db->insert_batch('mfi_gl_report_item_member',$data);
	}
	function delete_gl_report_item_member($id)
	{
		$this->db->where_in('gl_report_item_member',$id);
		$this->db->delete('mfi_gl_report_item_member');
	}

}