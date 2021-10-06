<?php

Class Model_sys extends CI_Model {


	public function get_periode()
	{
		$sql = " SELECT 
						*
				from 	
						mfi_trx_kontrol_periode 
						";

		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function update_periode($data,$param)
	{
		$this->db->update('mfi_trx_kontrol_periode',$data,$param);
	}

	public function do_bagihasil_tabungan($product_code='',$tanggal='',$rate='')
	{
		$sql="SELECT fn_proses_distribusi_bahas_tabungan2(?,?,?)";
		$query=$this->db->query($sql,array($product_code,$tanggal,$rate));
	}

	public function do_debet_adm($tanggal)
	{
		$sql="SELECT fn_proses_debet_adm_tabungan(?)";
		$query=$this->db->query($sql,array($tanggal));
	}

	/**********************************************************************************/
	//BEGIN BAGI HASIL 17-09-2014
	public function pembiayaan_yg_diberikan($l='')
	{
		$sql = "SELECT sum(fn_get_saldo_gl_account_sayyid(a.code_value,?,'all')) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pembiayaan' ";

		$query = $this->db->query($sql,array($l));
		$data =  $query->row_array();
		return $data['saldo'];
	}	
	public function pendapatan_operasional($f='',$l='')
	{
		$sql = "SELECT 
				coalesce(sum(fn_get_mutasi_gl_account_sayyid(a.code_value, ?, ?, 'C', 'all')),0) -
				coalesce(sum(fn_get_mutasi_gl_account_sayyid(a.code_value, ?, ?, 'D', 'all')),0) as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_pendapatan'
				 ";

		$query = $this->db->query($sql,array($f,$l,$f,$l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	public function dana_pihak_ke3($l='')
	{
		$sql = "SELECT sum(fn_get_saldo_gl_account_sayyid(a.code_value,?,'all'))*-1 as saldo
				from mfi_list_code_detail a
				where a.code_group like 'bahas_dp3'
				 ";

		$query = $this->db->query($sql,array($l));
		$data =  $query->row_array();
		return $data['saldo'];
	}
	public function generate_product_deposito($l='')
	{
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_gl_account_sayyid(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_deposit a,mfi_product_deposit_gl b
				where a.product_deposit_gl_code=b.product_deposit_gl_code
				order by 1
				 ";

		$query = $this->db->query($sql,array($l));
		return $query->result_array();
	}	
	public function generate_product_mudharabah($l='')
	{
		$sql = "SELECT a.product_code,a.product_name,a.nisbah,
				(coalesce(fn_get_saldo_gl_account_sayyid(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=1
				order by 1
				 ";

		$query = $this->db->query($sql,array($l));
		return $query->result_array();
	}	
	public function generate_product_wadiah($l='')
	{
		$sql = "SELECT a.product_code,a.product_name,
				(coalesce(fn_get_saldo_gl_account_sayyid(b.gl_saldo, ?,'all'),0) *-1) as saldo
				from mfi_product_saving a,mfi_product_saving_gl b
				where a.product_saving_gl_code=b.product_saving_gl_code and a.akad=0
				order by 1
				 ";

		$query = $this->db->query($sql,array($l));
		return $query->result_array();
	}	

	public function insert_into_mfi_proyeksi_bahas($data)
	{
		$this->db->insert('mfi_proyeksi_bahas',$data);		
	}

	public function insert_batch_proyeksi_bahas_detail($data)
	{
		$this->db->insert_batch('mfi_proyeksi_bahas_detail',$data);		
	}
	public function cek_periode_bahas($b='',$t='')
	{
		$param = array();
		$sql = "SELECT COUNT(*) result FROM mfi_proyeksi_bahas WHERE bulan=? AND tahun=? ";
		$param[] = $b;
		$param[] = $t;

		$query = $this->db->query($sql,$param);
		$data = $query->row_array();
		return $data['result'];
	}
	public function select_proyeksi_bahas_detail($proyeksi_bahas_id='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas_detail WHERE proyeksi_bahas_id=? ";
		$param[] = $proyeksi_bahas_id;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	
	public function get_data_proyeksi_bahas($m='',$y='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas WHERE tahun=? AND bulan=? ";
		$param[] = $y;
		$param[] = $m;

		$query = $this->db->query($sql,$param);
		return $query->row_array();
	}		
	public function generate_product_komposisi($id_proyeksi_bahas='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_proyeksi_bahas_detail WHERE proyeksi_bahas_id=? ORDER BY product_type DESC ";
		$param[] = $id_proyeksi_bahas;

		$query = $this->db->query($sql,$param);
		return $query->result_array();
	}	
	public function datatable_sys_account_setup($sWhere='',$sOrder='',$sLimit='',$code_group='')
	{
		$param = array();
		$sql = "SELECT * FROM mfi_list_code_detail WHERE ";
		if ($code_group==''){
			$sql .= " code_group IN('bahas_pembiayaan','bahas_dp3','bahas_pendapatan') ";
		}else{
			$sql .= " code_group = ? ";
			$param[] = $code_group;
		}

		if ( $sOrder != "" )
			$sql .= "$sOrder ";
		else
			$sql .= "ORDER BY code_value ";

		if ( $sLimit != "" )
			$sql .= "$sLimit ";

		$query = $this->db->query($sql,$param);

		return $query->result_array();
	}
	public function delete_sys_account_bahas($param)
	{
		$this->db->delete('mfi_list_code_detail',$param);
	}	
	public function proses_input_setup_gl_bahas($data)
	{
		$this->db->insert('mfi_list_code_detail',$data);
	}
	public function proses_edit_setup_gl_bahas($data,$param)
	{
		$this->db->update('mfi_list_code_detail',$data,$param);
	}
	public function get_gl_account_bahas_by_id($list_code_detail_id)
	{
		$sql = "SELECT * FROM mfi_list_code_detail WHERE list_code_detail_id = ?";
				
		$query = $this->db->query($sql,array($list_code_detail_id));

		return $query->row_array();
	}
	//END BAGI HASIL
	/**********************************************************************************/

	/*
	| CLOSING TRANSACTION (TUTUP BUKU TRANSAKSI)
	| created_by : sayyid
	| created_date : 2014-10-28 09:38
	*/
	function get_saving_data_for_closing($branch_code)
	{
		$sql = " SELECT 
					mfi_account_saving.account_saving_no
				   ,mfi_account_saving.saldo_riil
				   ,mfi_account_saving.saldo_memo
				   ,mfi_cif.nama 
				 FROM mfi_account_saving,mfi_cif
				 WHERE mfi_account_saving.account_saving_no IN (SELECT account_saving_no FROM mfi_trx_account_saving GROUP BY 1)
				 AND mfi_account_saving.status_rekening = 1
				 AND mfi_cif.cif_no=mfi_account_saving.cif_no
				";
		$param=array();
		if($branch_code!="00000"){
			$sql .= " AND mfi_cif.branch_code IN (SELECT branch_code FROM mfi_branch_member WHERE branch_induk=?) ";
			$param[]=$branch_code;
		}
		$query=$this->db->query($sql,$param);
		return $query->result_array();
	}
	function get_ledger_data_for_closing()
	{
		$sql = "SELECT account_code FROM mfi_gl_account ORDER BY account_code ASC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	function get_average_saldo_tabungan($account_saving_no,$from_date,$thru_date)
	{
		$sql = "SELECT fn_get_average_saldo_tabungan(?,?,?) as saldo";
		$query=$this->db->query($sql,array($account_saving_no,$from_date,$thru_date));
		$row=$query->row_array();
		return $row['saldo'];
	}
	function get_average_saldo_ledger($account_code,$from_date,$thru_date)
	{
		$sql = "SELECT fn_get_average_saldo_ledger(?,?,?) as saldo";
		$query=$this->db->query($sql,array($account_code,$from_date,$thru_date));
		$row=$query->row_array();
		return $row['saldo'];
	}
	function get_branch_by_branch_class($branch_class)
	{
		$sql = "select * from mfi_branch where branch_class=? order by branch_code asc";
		$query=$this->db->query($sql,array($branch_class));
		return $query->result_array();		
	}
	function cek_par($thru_date,$branch_code)
	{
		$sql = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code=?";
		$query=$this->db->query($sql,array($thru_date,$branch_code));
		$row=$query->row_array();

		if(count($row)>0){
			$exists=$row['jum'];
		}else{
			$exists=0;
		}
		return $exists;
	}
	function delete_par($thru_date,$branch_code)
	{
		$param=array('tanggal_hitung'=>$thru_date,'branch_code'=>$branch_code);
		$this->db->delete('mfi_par',$param);
	}
	function insert_closing_saving_data($data)
	{
		$this->db->insert_batch('mfi_closing_saving_data',$data);
	}
	function insert_closing_ledger_data($data)
	{
		$this->db->insert_batch('mfi_closing_ledger_data',$data);
	}
	function insert_closing_kolektibilitas_data($data)
	{
		$this->db->insert_batch('mfi_par',$data);
	}

	/*
	| GET NUM VERIFIED TRX NOT YET
	*/
	function num_trx_financing_verified_not_yet()
	{
		$sql = "select count(*) as num from mfi_trx_account_financing where trx_status = 0";
		$query=$this->db->query($sql);
		$row=$query->row_array();
		return $row['num'];
	}
	function num_tanggal_financing_not_yet(){
		$sql = "SELECT trx_date FROM mfi_trx_account_financing WHERE trx_status = '0' GROUP BY 1";
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	function num_trx_saving_verified_not_yet()
	{
		$sql = "select count(*) as num from mfi_trx_account_saving where trx_status = 0";
		$query=$this->db->query($sql);
		$row=$query->row_array();
		return $row['num'];
	}
	function num_tanggal_saving_not_yet(){
		$sql = "SELECT trx_date FROM mfi_trx_account_saving WHERE trx_status = '0' GROUP BY 1";
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	function get_gl_list_code_detail($code_group)
	{
		$sql = "select code_value,display_text from mfi_list_code_detail where code_group=? limit 1";
		$query = $this->db->query($sql,array($code_group));
		return $query->row_array();
	}

}