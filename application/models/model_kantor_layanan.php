<?php

Class Model_kantor_layanan extends CI_Model {

	function get_all_branch()
    {
        $sql = "SELECT 
        				 branch_id
        				,branch_code 
        				,branch_name
        			FROM 
        				 mfi_branch
				WHERE 
						branch_class=0";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	function get_all_jabatan()
    {
        $sql = "SELECT 
        				 kode_jabatan as code_value
        				,nama_jabatan as display_text 
        			FROM 
        				 mfi_jabatan
        			ORDER BY 
        				kode_jabatan ASC";

		$query = $this->db->query($sql);

		return $query->result_array();
    }

	public function get_all_petugas()
	{
		$sql = "SELECT * from mfi_fa";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_kecamatan()
	{
		$sql = "SELECT
					 mfi_city_kecamatan.city_kecamatan_id,
					 mfi_city_kecamatan.kecamatan_code,
					 mfi_city_kecamatan.city_code,
					 mfi_city_kecamatan.kecamatan,
					 mfi_province_city.city_code,
					 mfi_province_city.city_abbr,
					 mfi_province_city.city
				FROM
					 mfi_city_kecamatan
				INNER JOIN  mfi_province_city ON  mfi_city_kecamatan.city_code =  mfi_province_city.city_code
				ORDER BY 
					 mfi_city_kecamatan.kecamatan asc
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_all_branch_()
	{
	    $sql = "SELECT 
					     branch_id
					    ,branch_code
					    ,branch_name
				    FROM 
					     mfi_branch";
    
		    $query = $this->db->query($sql);
    
		    return $query->result_array();
	}

	public function get_city()
	{
		$sql = "select * from mfi_province_city order by city_abbr,city_code asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_province()
	{
		$query = $this->db->get('mfi_province_code');
		return $query->result_array();
	}

	function get_branch_class_login($branch_code='')
	{
	    $sql = "SELECT 
					     branch_class
				    FROM 
					     mfi_branch WHERE branch_code=? ";
    
		    $query = $this->db->query($sql,array($branch_code));
    
		    $data = $query->row_array();
		    return $data['branch_class'];
	}

	function get_all_branch_by_parent()
	{
		$param = array();
		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		
	    $sql = "SELECT 
					     branch_id
					    ,branch_code
					    ,branch_name
				    FROM 
					     mfi_branch
					";
					//--WHERE branch_code !='00000'
    
		if($flag_all_branch!='1'){ // tidak punya akses seluruh cabang
			$sql .= " AND branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " ORDER BY branch_code ";
		    $query = $this->db->query($sql,$param);
    
		    return $query->result_array();
	}

	function get_lembaga()
	{
		$sql = "SELECT * FROM mfi_institution";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function edit_lembaga($data)
	{
		$this->db->update('mfi_institution',$data);
	}

	/*
	| RESORT
	| Sayyid Nurkilah
	| 04 November 2014
	*/
	function datatable_resort($sWhere='',$sOrder='',$sLimit='',$branch_code='')
	{
		$param=array();

		$sql = "SELECT * FROM mfi_resort";
		if ( $sWhere != "" ){
			$sql .= "$sWhere ";
			if($branch_code!="0000"){
				$sql .= " AND branch_code IN(select branch_code from mfi_branch_member where branch_induk = ?)";
				$param[]=$branch_code;
			}
		}else{
			if($branch_code!="0000"){
				$sql .= " WHERE branch_code IN(select branch_code from mfi_branch_member where branch_induk = ?)";
				$param[]=$branch_code;
			}
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	function get_max_resort_code_by_branch($branch_code)
	{
		$sql="select count(*) num from mfi_resort where branch_code=?";
		$query=$this->db->query($sql,array($branch_code));
		$row=$query->row_array();
		return $row['num'];
	}
	function insert_resort_setup($data)
	{
		$this->db->insert('mfi_resort',$data);
	}
	function get_resort_by_id($resortid)
	{
		$sql="select * from mfi_resort where resort_id=?";
		$query=$this->db->query($sql,array($resortid));
		return $query->row_array();
	}
	function update_resort_setup($data,$param)
	{
		$this->db->update('mfi_resort',$data,$param);
	}

	/*Data Kopegtel*/
	public function datatable_kopegtel($sWhere='',$sOrder='',$sLimit='')
	{
		$sql = "SELECT * FROM mfi_kopegtel ";

		if ( $sWhere != "" )
			$sql .= "$sWhere ";

		if ( $sOrder != "" )
			$sql .= "$sOrder ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	function add_kopegtel($data)
	{
		$this->db->insert('mfi_kopegtel',$data);
	}

	public function delete_kopegtel($param)
	{
		$this->db->delete('mfi_kopegtel',$param);
	}

	public function get_kopegtel_by_kopegtel_id($kopegtel_id)
	{
		$sql = "select * from mfi_kopegtel where kopegtel_id = ?";
		$query = $this->db->query($sql,array($kopegtel_id));

		return $query->row_array();
	}

	public function edit_kopegtel($data,$param)
	{
		$this->db->update('mfi_kopegtel',$data,$param);
	}
	/*Data Kopegtel*/


}