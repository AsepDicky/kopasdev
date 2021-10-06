<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */
	 
	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_transaction');
		$this->load->model('model_laporan');
		$this->load->model('model_cif');
		$this->load->model('model_laporan_to_pdf');
		$this->load->library('html2pdf');
		$this->load->library('phpexcel');
	}

	public function index()
	{
		$data['container'] = 'laporan';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN SALDO KAS PERUGAS
	/****************************************************************************************/

	public function saldo_kas_petugas()
	{
		$data['container'] = 'laporan/saldo_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function datatable_saldo_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','account_cash_code','fa_name', 'saldoawal', 'mutasi_debet','mutasi_credit','');
		$cabang  = @$_GET['cabang'];
		$tanggal = @$_GET['tanggal'];
		$tanggal = str_replace('/','',$tanggal);
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		$rResult 			= $this->model_laporan->datatable_saldo_kas_petugas($sOrder,$sLimit,$cabang,$tanggal); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_saldo_kas_petugas('','',$cabang,$tanggal); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_saldo_kas_petugas('','',$cabang,$tanggal); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		$no=1;
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = $no++;
			$row[] = $aRow['account_cash_code'];
			$row[] = $aRow['fa_name'];
			$row[] = '<div align="right">'.number_format($aRow['saldoawal'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['mutasi_debet'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['mutasi_credit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format(($aRow['saldoawal']+$aRow['mutasi_debet']-$aRow['mutasi_credit']),0,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	/****************************************************************************************/	
	// END SALDO KAS PERUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	public function transaksi_kas_petugas()
	{
		$data['container'] = 'laporan/transaksi_kas_petugas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}


	public function search_code_cash_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$type = $this->input->post('account_type');
		$data = $this->model_laporan->search_code_cash_by_keyword($keyword,$type);

		echo json_encode($data);
	}

	public function datatable_transaksi_kas_petugas()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '', 'trx_date', 'trx_type', 'trx_debet','trx_credit','saldoawal');
		$tanggal  = @$_GET['tanggal'];
		$tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$tanggal2 = @$_GET['tanggal2'];
		$tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$account_cash_code = @$_GET['account_cash_code'];
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		$rResult 			= $this->model_laporan->datatable_transaksi_kas_petugas_setup($sOrder,$sLimit,$tanggal,$tanggal2,$account_cash_code); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_transaksi_kas_petugas_setup('','',$tanggal,$tanggal2,$account_cash_code); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_transaksi_kas_petugas_setup('','',$tanggal,$tanggal2,$account_cash_code); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		$no=1;
		$saldo = (isset($rResult[0]['saldoawal']))?$rResult[0]['saldoawal']:0;
		foreach($rResult as $aRow)
		{
			$row = array();
			if($aRow['flag_debet_credit']=='D'){
				$saldo += $aRow['trx_debet'];
			}
			if($aRow['flag_debet_credit']=='C'){
				$saldo -= $aRow['trx_credit'];
			}
			$row[] = $no++;
			$row[] = '<div align="center">'.$aRow['trx_date'].'</div>';
			$row[] = '<div align="center">'.$aRow['description'].'</div>';
			$row[] = '<div align="right">'.number_format($aRow['trx_debet'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['trx_credit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($saldo,0,',','.').'</div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	/****************************************************************************************/	
	// END TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	/*GL ACCOUNT HISTORY / LIST JURNAL UMUM*/

	public function list_jurnal_umum_gl()
	{
		$data['container'] = 'laporan/list_jurnal_umum_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function get_gl_account_history()
	{
		$branch_code = $this->input->post('branch_code');
		$account_code = $this->input->post('account_code');
		$from_date = $this->input->post('from_date');
		$from_date = str_replace('/', '', $from_date);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = str_replace('/', '', $thru_date);
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);

		$datas = $this->model_laporan->get_gl_account_history($branch_code,$account_code,$from_date,$thru_date);
		$saldo = $this->model_laporan->fn_get_saldo_gl_account2($account_code,$from_date,$branch_code);

		$saldo_akhir = $saldo['saldo_awal'];
		$total_debit = 0;
		$total_credit = 0;
		$i = 0;
		for ( $j = 0 ; $j < count($datas)+1 ; $j++ )
		{
			if($j==0)
			{
				$data['data'][$j]['nomor'] = '';
				$data['data'][$j]['trx_date'] = '';
				$data['data'][$j]['description'] = 'Saldo Awal';
				$data['data'][$j]['debit'] = '';
				$data['data'][$j]['credit'] = '';
				$data['data'][$j]['saldo_akhir'] = $saldo_akhir;
				$data['data'][$j]['trx_gl_id'] = '';
			}
			else
			{

				if($datas[$i]['transaction_flag_default']=='D'){
					$saldo_akhir+=($datas[$i]['debit']-$datas[$i]['credit']);
				}else{
					$saldo_akhir-=($datas[$i]['credit']+$datas[$i]['debit']);
				}

				$data['data'][$j]['nomor'] = $i+1;
				$data['data'][$j]['trx_date'] = date('d-m-Y',strtotime($datas[$i]['voucher_date']));
				$data['data'][$j]['description'] = $datas[$i]['description'];
				$data['data'][$j]['debit'] = $datas[$i]['debit'];
				$data['data'][$j]['credit'] = $datas[$i]['credit'];
				$data['data'][$j]['saldo_akhir'] = $saldo_akhir;
				$data['data'][$j]['trx_gl_id'] = $datas[$i]['trx_gl_id'];
				
				$total_debit  += $datas[$i]['debit'];
				$total_credit += $datas[$i]['credit'];

				$i++;
			}
		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	/*GL REKAP TRANSAKSI*/

	public function rekap_trx_gl()
	{
		$data['container'] = 'laporan/rekap_trx_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_gl_rekap_transaksi()
	{
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->input->post('thru_date');
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);

		$datas = $this->model_laporan->get_gl_rekap_transaksi($branch_code,$from_date,$thru_date);

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;
		
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$data['data'][$i]['nomor'] = $i+1;
			$data['data'][$i]['saldo_awal'] = 0;
			$data['data'][$i]['account'] = $datas[$i]['account_code'].' - '.$datas[$i]['account_name'];
			$data['data'][$i]['debit'] = $datas[$i]['debit'];
			$data['data'][$i]['credit'] = $datas[$i]['credit'];
			$data['data'][$i]['saldo_akhir'] = 0;
			
			$total_debit  += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];

		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	/* MUTASI SALDO PEMBIAYAAN */
	function mutasi_saldo(){
		$data['container'] = 'laporan/mutasi_saldo_pembiayaan';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$this->load->view('core',$data);
	}


	function get_mutasi_saldo(){
		$branch_code = $this->input->post('branch_code');
		$periode_bulan = $this->input->post('periode_bulan');
		$periode_tahun = $this->input->post('periode_tahun');
		$product = $this->input->post('product');

		$last_date = date('Y-m-d',strtotime($periode_tahun.'-'.$periode_bulan.'-01 -1 days'));

		$from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
		$thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));

		$datas = $this->model_laporan->get_mutasi_saldo($branch_code,$from_periode,$thru_periode,$product);

		$total_awal_pokok = 0;
		$total_awal_margin = 0;
		$total_angsuran_pokok = 0;
		$total_angsuran_margin = 0;
		$total_akhir_pokok = 0;
		$total_akhir_margin = 0;

		$ii = 0;
		$data['data'] = array();
		for($i = 0; $i < count($datas); $i++){
			$data['data'][$ii]['account_financing_no'] = $datas[$i]['account_financing_no'];
			$data['data'][$ii]['nama'] = $datas[$i]['nama'];
			$data['data'][$ii]['product_name'] = $datas[$i]['product_name'];
			$data['data'][$ii]['tanggal_akad'] = $datas[$i]['tanggal_akad'];
			$data['data'][$ii]['pokok'] = $datas[$i]['pokok'];
			$data['data'][$ii]['saldo_pokok'] = $datas[$i]['saldo_pokok'];
			$data['data'][$ii]['saldo_margin'] = $datas[$i]['saldo_margin'];
			$data['data'][$ii]['angsuran_pokok'] = $datas[$i]['angsuran_pokok'];
			$data['data'][$ii]['angsuran_margin'] = $datas[$i]['angsuran_margin'];
			$data['data'][$ii]['akhir_pokok'] = $datas[$i]['saldo_pokok'] - $datas[$i]['angsuran_pokok'];
			$data['data'][$ii]['akhir_margin'] = $datas[$i]['saldo_margin'] - $datas[$i]['angsuran_margin'];
			
			$total_awal_pokok  += $datas[$i]['saldo_pokok'];
			$total_awal_margin += $datas[$i]['saldo_margin'];

			$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
			$total_angsuran_margin += $datas[$i]['angsuran_margin'];

			$total_akhir_pokok = $total_awal_pokok - $total_angsuran_pokok;
			$total_akhir_margin = $total_awal_margin - $total_angsuran_margin;

			$ii++;
		}

		$data['total_awal_pokok'] = $total_awal_pokok;
		$data['total_awal_margin'] = $total_awal_margin;
		$data['total_angsuran_pokok'] = $total_angsuran_pokok;
		$data['total_angsuran_margin'] = $total_angsuran_margin;
		$data['total_akhir_pokok'] = $total_akhir_pokok;
		$data['total_akhir_margin'] = $total_akhir_margin;

		echo json_encode($data);
	}
	/* END MUTASI SALDO PEMBIAYAAN */

	/* NERACA SALDO GL */

	public function neraca_saldo_gl()
	{
		$data['container'] = 'laporan/neraca_saldo_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_neraca_saldo_gl()
	{
		$branch_code = $this->input->post('branch_code');
		$periode_bulan = $this->input->post('periode_bulan');
		$periode_tahun = $this->input->post('periode_tahun');

		$datas = $this->model_laporan->get_neraca_saldo_gl($branch_code,$periode_bulan,$periode_tahun);

		$saldo_akhir = 0;
		$total_debit = 0;
		$total_credit = 0;
		$ii=0;
		$group_name='';
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$group = $this->model_laporan->get_account_group_by_code($datas[$i]['account_group_code']);
			if(count($group)>0){
				if($group_name!=$group['group_name']){
					$group_name=$group['group_name'];
					$data['data'][$ii]['nomor'] = '';
					$data['data'][$ii]['saldo_awal'] = '';
					$data['data'][$ii]['account'] = $group_name;
					$data['data'][$ii]['debit'] = '';
					$data['data'][$ii]['credit'] = '';
					$data['data'][$ii]['saldo_akhir'] = '';
					$ii++;
				}
			}else{
				$group_name='';
			}

			$data['data'][$ii]['nomor'] = $i+1;
			$data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
			$data['data'][$ii]['account'] = $datas[$i]['account_code'].' - '.$datas[$i]['account_name'];
			$data['data'][$ii]['debit'] = $datas[$i]['debit'];
			$data['data'][$ii]['credit'] = $datas[$i]['credit'];
			$data['data'][$ii]['saldo_akhir'] = $datas[$i]['saldo_awal']+$datas[$i]['debit']-$datas[$i]['credit'];
			
			$total_debit  += $datas[$i]['debit'];
			$total_credit += $datas[$i]['credit'];
			if(count($group)>0){
				$group_name=$group['group_name'];
			}
			$ii++;
		}
		$data['total_debit'] = $total_debit;
		$data['total_credit'] = $total_credit;

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// BEGIN REPORT LABA RUGI
	/****************************************************************************************/

	public function laba_rugi_gl()
	{
		$data['container'] = 'laporan/laba_rugi_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LABA RUGI
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN NERACA_GL
	/****************************************************************************************/
	public function neraca_gl()
	{
		$data['container'] = 'laporan/neraca_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN NERACA_GL
	/****************************************************************************************/




	/****************************************************************************************/	
	// BEGIN LIST JATUH TEMPO
	/****************************************************************************************/

	public function list_jatuh_tempo()
	{
		$data['container'] = 'laporan/list_jatuh_tempo';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT LABA RUGI PUBLISH
	/****************************************************************************************/

	public function laba_rugi_publish()
	{
		$data['container'] = 'laporan/laba_rugi_publish';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LABA RUGI PUBLISH
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_droping_pembiayaan()
	{
		$data['container'] = 'laporan/list_droping_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	

	/****************************************************************************************/	
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pelunasan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pelunasan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	

	/****************************************************************************************/	
	// BEGIN REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_outstanding_pembiayaan()
	{
		$data['container'] = 'laporan/list_outstanding_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['peruntukan'] = $this->model_laporan->get_data_peruntukan();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	public function jqgrid_list_outstanding_pembiayaan()
	{
		set_time_limit(0);
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$tanggal = $this->current_date();
		$akad = isset($_REQUEST['akad'])?$_REQUEST['akad']:'';
		$produk_pembiayaan = isset($_REQUEST['produk_pembiayaan'])?$_REQUEST['produk_pembiayaan']:'';
		$pengajuan_melalui = isset($_REQUEST['pengajuan_melalui'])?$_REQUEST['pengajuan_melalui']:'';
		$peruntukan = isset($_REQUEST['peruntukan'])?$_REQUEST['peruntukan']:'';
		$resort = isset($_REQUEST['resort'])?$_REQUEST['resort']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan_individu('','','','',$akad,$produk_pembiayaan,$pengajuan_melalui,$peruntukan);//2

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan_to_pdf->jqgrid_list_outstanding_pembiayaan_individu($sidx,$sort,$limit_rows,$start,$akad,$produk_pembiayaan,$pengajuan_melalui,$peruntukan);//3
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{

	        $check = $this->model_laporan->get_acc_financing_by_no($row['account_financing_no']);
	        $counter_angsuran = ($check['counter_angsuran'] > 0) ? $check['counter_angsuran']+1 : $check['counter_angsuran'];
	        $sisa_counter = ($check['sisa_counter'] > 0 ) ? $check['sisa_counter']-1 : $check['sisa_counter'];

	        $tunggakan_pokok      = $sisa_counter * $row['angsuran_pokok'];
	        $tunggakan_margin     = $sisa_counter * $row['angsuran_margin'];
	        $saldo_outstanding	  = $tunggakan_margin + $row['saldo_pokok'];

			$responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
		    $responce['rows'][$i]['cell']=array(
			     $row['account_financing_no']
				,$row['nama']
				,$row['droping_date']
				,$row['pokok']
				,$row['margin']
				,$counter_angsuran
				,$row['saldo_pokok']
				,$row['saldo_margin']
				,$sisa_counter
				,$tunggakan_pokok
				,$tunggakan_margin
				,$saldo_outstanding
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/	
	// END REPORT LIST PENGHAPUSAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	public function list_registrasi_pembiayaan()
	{
		$data['container'] = 'laporan/list_registrasi_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	/* LAPORAN PAR atau AGING REPORT */
	public function laporan_par()
	{
		$data['container'] = 'anggota/aging_report';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['pars'] = $this->model_laporan->get_par();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	public function kartu_pengawasan_angsuran()
	{
		$data['container'] = 'laporan/kartu_pengawasan_angsuran';
		$data['rembugs'] = $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function get_kartu_pengawasan_angsuran_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
		if (count($data)>0) {
			$data['droping_date'] = (isset($data['droping_date'])) ?date("d-m-Y", strtotime($data['droping_date'])) : '-';
			$data['tanggal_jtempo'] = (isset($data['droping_date'])) ?date("d-m-Y", strtotime($data['tanggal_jtempo'])) : '-';

			$check = $this->model_laporan->get_acc_financing_by_no($account_financing_no);
			$sisa_counter = ($check['sisa_counter'] > 0 ) ? $check['sisa_counter']-1 : $check['sisa_counter'];

			$data['tunggakan_pokok']	= $sisa_counter * $data['angsuran_pokok'];
			$data['tunggakan_margin']	= $sisa_counter * $data['angsuran_margin'];
			$data['saldo_outstanding']	= $data['tunggakan_margin'] + $data['saldo_pokok'];
			$data['tunggakan_freq']		= $sisa_counter;

		}

		echo json_encode($data);
	}

	public function get_trx_pembiayaan_by_cif_no()
	{
		$cif_no = $this->input->post('cif_no');
		$data = $this->model_laporan->get_trx_pembiayaan_by_cif_no($cif_no);

		echo json_encode($data);
	}


	/** 
	* UPDATED 2014-08-27 at NGANJUK
	* @author : sayyid
	*/
	public function get_row_pembiayaan_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$cif_no = $this->input->post('cif_no');
		$cif_type = $this->input->post('cif_type');
		$data = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);

		if($cif_type==0){ //kelompok
			$data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,0);
		}

		$html = '';
		$no=1;
		$saldo_pokok = $data['pokok'];
		$saldo_margin = $data['margin'];

		if($data['flag_jadwal_angsuran']==0) //NON REGULER lalu lookup ke tabel mfi_account_financing_schedulle
		{
			$get_jadwal_angsuran = $this->model_laporan->get_jadwal_angsuran($account_financing_no);
			$angsuran_hutang = 0;
			for ($jA=0; $jA < count($get_jadwal_angsuran) ; $jA++) 
			{
				$angsuran_pokok 	= $get_jadwal_angsuran[$jA]['angsuran_pokok'];
				$angsuran_margin 	= $get_jadwal_angsuran[$jA]['angsuran_margin'];
				$angsuran_tabungan 	= $get_jadwal_angsuran[$jA]['angsuran_tabungan'];
				$tanggal_bayar 		= $get_jadwal_angsuran[$jA]['tanggal_bayar'];
				$pokok 				= $data['pokok'];
				$margin 			= $data['margin'];

				$jumlah_angsur 		= $angsuran_pokok + $angsuran_margin + $angsuran_tabungan;
				$angsuran_hutang   += $jumlah_angsur;
				$saldo_hutang 		= ($pokok + $margin) - ($angsuran_hutang);
				$saldo_pokok 		= ($saldo_pokok - $angsuran_pokok);
				
				if(($saldo_hutang) !=0 && $jA == (count($get_jadwal_angsuran)-1))
				{
					$jumlah_angsur 		= $saldo_hutang + $jumlah_angsur;
					$angsuran_hutang   += $jumlah_angsur;
					$saldo_hutang 		= $jumlah_angsur - $jumlah_angsur;
				}

				$_tgl_bayar = (isset($tanggal_bayar)) ? date("d-m-Y", strtotime($tanggal_bayar)) : '' ;

				$date_payment1 	= strtotime(date('2017-12-31'));
				$tgl_angsur 	= $get_jadwal_angsuran[$jA]['tangga_jtempo'];
				$date_payment2 	= strtotime($tgl_angsur);

				$case_bayar 	= ($date_payment1 > $date_payment2) ? date("d-m-Y", strtotime($tgl_angsur)) : '';
	            $tgl_bayar 		= ($case_bayar=='' && !empty($tgl_bayar)) ? $_tgl_bayar : $case_bayar ;

				$btn_detail = (!empty($_tgl_bayar)) ? '<center><a id="btn_detail_trx" data-trx_date="'.$get_jadwal_angsuran[$jA]['tanggal_bayar'].'" data-account_no="'.$account_financing_no.'" class="btn yellow" >detail</a></center>' : '';
				
				$html .= '<tr>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.date("d-m-Y", strtotime($get_jadwal_angsuran[$jA]['tangga_jtempo'])).'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$_tgl_bayar.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$no.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($get_jadwal_angsuran[$jA]['angsuran_pokok'],0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($get_jadwal_angsuran[$jA]['angsuran_margin'],0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_hutang,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_pokok,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.$btn_detail.'</td>
	                      </tr>';

				$no++;
			}
		}
		else //REGULER
		{
			for($i=0;$i<$data['jangka_waktu'];$i++)
			{
				if($i==0) {
					$tgl_angsur = $data['tanggal_mulai_angsur'];
					$tgl_angsur_day = date('d',strtotime($tgl_angsur));
				}else{
					if($data['periode_jangka_waktu']==0){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 day"));
					}else if($data['periode_jangka_waktu']==1){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 7 day"));
					}else if($data['periode_jangka_waktu']==2){
						if (date('m',strtotime($tgl_angsur)) == '01') {
							$last_day_feb = date('t',strtotime($tgl_angsur . ' + 7 day '));
							if ((int)$tgl_angsur_day>(int)$last_day_feb) {
								$tgl_angsur = date('Y-m-t',strtotime($tgl_angsur . ' + 7 day '));
							} else {
								$tgl_angsur = date('Y-m-',strtotime($tgl_angsur . ' + 1 month ')).$tgl_angsur_day;
							}
						} else {
							$tgl_angsur = date('Y-m-',strtotime($tgl_angsur . ' + 1 month ')).$tgl_angsur_day;
						}
					}else if($data['periode_jangka_waktu']==3){
						$tgl_angsur = $data['tgl_jtempo'];
					}
				}

				$tgl_bayar = '';
				$validasi = '';
				if($cif_type==1){ //individu
					$data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,1,$tgl_angsur);
					$tgl_bayar = (isset($data_trx['trx_date'])==true)?$data_trx['trx_date']:'';
					$validasi = (isset($data_trx['created_by'])==true)?$data_trx['created_by']:'';
				}

				if($i==($data['jangka_waktu']-1)){
					$data['angsuran_pokok'] = $saldo_pokok;
					$data['angsuran_margin'] = $saldo_margin;
				}

				$counter_angsuran = $data['counter_angsuran'];
				$jumlah_angsur = $data['jumlah_angsuran'];
				$angsuran_hutang = $data['angsuran_pokok']+$data['angsuran_margin']+$data['angsuran_catab'];
				$saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang*$no);
				$saldo_pokok = ($saldo_pokok-$data['angsuran_pokok']);
				$saldo_margin = ($saldo_margin-$data['angsuran_margin']);

				if($data['jangka_waktu']==$no){
	            	$jumlah_angsur = ($data['pokok']+$data['margin'])-($angsuran_hutang*($no-1));
	            	$jumlah_angsur = ($saldo_pokok+$saldo_margin);
	            	$saldo_hutang=0;
	            }

	            $date_payment1 = strtotime(date('2017-12-31'));
				$date_payment2 = strtotime($tgl_angsur);

				$case_bayar = ($date_payment1 > $date_payment2) ? (($i<$counter_angsuran) ? date("d-m-Y", strtotime($tgl_angsur)) : '') : '';
	            $tgl_bayar = ($case_bayar=='' && !empty($tgl_bayar)) ? date("d-m-Y", strtotime($tgl_bayar)) : $case_bayar ;
	            // $tgl_bayar = ($counter_angsuran<=$i) ? "" : date("d-m-Y", strtotime($tgl_angsur));

				$btn_detail = (!empty($tgl_bayar) || $date_payment1 > $date_payment2) ? '<center><a id="btn_detail_trx" data-trx_date="'.$data_trx['trx_date'].'" data-account_no="'.$account_financing_no.'" class="btn yellow" >detail</a></center>' : '' ;

				$html .= '<tr>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.date("d-m-Y", strtotime($tgl_angsur)).'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$tgl_bayar.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$no.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($data['angsuran_pokok'],0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($data['angsuran_margin'],0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_hutang,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_pokok,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.$btn_detail.'</td>
	                      </tr>';

				$no++;
			}
		}
		echo $html;
	}
	/****************************************************************************************/	
	// END KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/


	public function check_detail_trx()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$trx_date = $this->input->post('trx_date');
		$list = $this->model_laporan->check_detail_trx($account_financing_no,$trx_date);
		
		$date_payment1 = strtotime(date('2017-12-31'));
		$date_payment2 = strtotime($trx_date);

        if(($date_payment1 < $date_payment2)){
        	if($list->num_rows() > 0){
				$row = $list->row();
				$html = '<tr>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">'.$row->created_by.'</td>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">'.date('d F Y', strtotime($row->created_date)).'</td>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">'.$row->verify_by.'</td>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">'.date('d F Y', strtotime($row->verify_date)).'</td>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="right">Rp. '.number_format($row->pokok+$row->margin).'</td>
			                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" width="100" align="center">'.date('d F Y', strtotime($row->trx_date)).'</td>
			               </tr>';
			    $data['trx_detail'] = $html;


			    $datax = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);
			   	$cif_no = $datax['cif_no'];
			    $list2 = $this->model_laporan->check_detail_saving($cif_no,$trx_date);
				if($list2->num_rows() > 0){
					$row2 = $list2->row();
					$html2 = '<tr>
				                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">'.date('d F Y', strtotime($row2->trx_date)).'</td>
				                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="right">Rp. '.number_format($row2->amount).'</td>
				                 <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="right">Rp. '.number_format(($row->pokok+$row->margin)-$row2->amount).'</td>
				               </tr>';
				    $data['saving_detail'] = $html2;
				}else{
					$data['saving_detail'] = "";
				}
			}else{
				$html = '<tr>
		                 <td colspan="6" style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">Migration of System</td>
		               </tr>';
				$data['trx_detail'] = $html;
				$data['saving_detail'] = "";
			}
        }else{
        	$html = '<tr>
		                 <td colspan="6" style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px;" align="center">Migration of System</td>
		               </tr>';
		    $data['trx_detail'] = $html;
			$data['saving_detail'] = "";
        }

		echo json_encode($data);
	}

	public function jqGrid_realisasi()
	{
		set_time_limit(0);
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$account_financing_no = isset($_REQUEST['account_financing_no'])?$_REQUEST['account_financing_no']:'';
		$resort = isset($_REQUEST['resort'])?$_REQUEST['resort']:'';
		$sidx = 'trx_date';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_laporan->jqGrid_realisasi('','','','',$account_financing_no);//2
		
		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan->jqGrid_realisasi($sidx,$sort,$limit_rows,$start,$account_financing_no);//3
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$check = $this->model_laporan->get_lunas_realisasi($row['trx_date'],$row['account_financing_no']);
			if($check->num_rows() > 0)
			{
				$list = $check->row();
				$angsuran_pokok = $list->saldo_pokok;
				$angsuran_margin = $list->saldo_margin;
				$muqassah = $list->potongan_margin;
				$jumlah_pembayaran = $angsuran_pokok + $angsuran_margin - $muqassah;
			}else{
				$angsuran_pokok = $row['angsuran_pokok'];
				$angsuran_margin = $row['angsuran_margin'];
				$jumlah_pembayaran = $row['pokok']+$row['margin'];
				$muqassah = 0;
			}


			$responce['rows'][$i]['account_financing_no']=$row['account_financing_no'];
		    $responce['rows'][$i]['cell']=array(
			     $row['account_financing_no']
				,$row['created_by']
				,date('d F Y', strtotime($row['created_date']))
				,$row['verify_by']
				,$angsuran_pokok
				,$angsuran_margin
				,$muqassah
				,$jumlah_pembayaran
				,date('d F Y', strtotime($row['trx_date']))
				,$row['description']
			);
		    $i++;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/	
	// BEGIN REKAP JATUH TEMPO
	/****************************************************************************************/

	public function rekap_jatuh_tempo()
	{
		$data['container'] = 'laporan/rekap_jatuh_tempo';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END REKAP JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN OUTSTANDING BERDASARKAN DESA
	/****************************************************************************************/

	public function rekap_outstanding_piutang()
	{
		$data['container'] = 'laporan/rekap_outstanding_piutang';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function get_desa_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$data = $this->model_laporan->get_desa_by_keyword($keyword);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING BERDASARKAN DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN REKAP PENGAJUAN
	/****************************************************************************************/

	public function rekap_pengajuan()
	{
		$data['container'] = 'laporan/rekap_pengajuan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN REKAP PENGAJUAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pencairan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pencairan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END LAPORAN PENCARIAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST TRANSAKSI REMBUG
	/****************************************************************************************/

	public function list_transaksi_rembug()
	{
		$data['container'] = 'laporan/list_transaksi_rembug';
		$data['title'] = 'List Transaksi rembug';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data); 
	}

	/****************************************************************************************/	
	// END LIST TRANSAKSI REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST SALDO TABUNGAN
	/****************************************************************************************/

	public function list_saldo_tabungan()
	{
		$data['container'] = 'laporan/list_saldo_tabungan';
		$data['title'] = 'List Saldo Tabungan';
		$data['trx_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		// $data['petugas'] = $this->model_laporan->get_all_petugas();
		$this->load->view('core',$data); 
	}

	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	public function list_pengajuan_pembiayaan()
	{
		$data['container'] = 'laporan/list_pengajuan_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST SALDO TABUNGAN
	/****************************************************************************************/

	public function list_pembukaan_tabungan()
	{
		$data['container'] 	= 'laporan/list_pembukaan_tabungan';
		$data['produk'] 	= $this->model_laporan->get_all_produk_tabungan();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST SALDO UNTUK ANGSURAN
	/****************************************************************************************/

	public function list_saldo_angsuran()
	{
		$data['container'] 	= 'laporan/list_saldo_angsuran';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST SALDO UNTUK ANGSURAN
	/****************************************************************************************/


	public function jqgrid_list_saldo_angsuran()
	{
		set_time_limit(0);
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$cif_no = isset($_REQUEST['cif_no'])?$_REQUEST['cif_no']:'';
		$resort = isset($_REQUEST['resort'])?$_REQUEST['resort']:'';
		$sidx = 'X.cif_no';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_laporan->jqgrid_list_saldo_angsuran('','','','',$cif_no);//2
		
		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan->jqgrid_list_saldo_angsuran($sidx,$sort,$limit_rows,$start,$cif_no);//3

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$cif_no = $row['account_saving_no'];
			$saldo_efektif = $row['saldo_efektif'];
			$nama = $row['nama'];

			if($saldo_efektif > 0):
				$query = $this->model_transaction->get_account_financing_by_cif_no2($cif_no);
				$bayar = 0;
				foreach($query as $list){
					$angsuran_pokok = $list['angsuran_pokok'];
					$angsuran_margin = $list['angsuran_margin'];
					$nominal_pembayaran =$angsuran_pokok+$angsuran_margin;
					if($saldo_efektif > $nominal_pembayaran){
						$bayar = 1;
					}

				}

				if($bayar > 0)
				{
					$responce['rows'][$i]['account_saving_no']=$cif_no;
				    $responce['rows'][$i]['cell']=array(
					     $cif_no
						,$row['nama']
						,$row['saldo_efektif']
					);
				    $i++;
				}
			endif;
		}

		echo json_encode($responce);
	}

	/****************************************************************************************/	
	// BEGIN LIST BLOKIR TABUNGAN
	/****************************************************************************************/

	public function list_blokir_tabungan()
	{
		$data['container'] 		= 'laporan/list_blokir_tabungan';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST BLOKIR TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST REKENING TABUNGAN
	/****************************************************************************************/

	public function list_rekening_tabungan()
	{
		$data['container'] 		= 'laporan/list_rekening_tabungan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST REKENING TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PEMBUKAAN TABUNGAN
	/****************************************************************************************/

	public function list_buka_tabungan()
	{
		$data['container'] 		= 'laporan/list_buka_tabungan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LIST PEMBUKAAN TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN CETAK TRANSAKSI BUKU TABUNGAN
	/****************************************************************************************/

	public function cetak_trans_buku()
	{
		$data['container'] 		= 'laporan/cetak_trans_buku';
		$data['produk'] 		= $this->model_laporan->get_all_produk_tabungan();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['rembugs'] 		= $this->model_cif->get_cm_data();
		$this->load->view('core',$data);
	}

	public function setup_margin()
	{
		$data['container'] 	= 'laporan/setup_margin';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END CETAK TRANSAKSI BUKU TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN DEPOSITO
	/****************************************************************************************/

	public function list_pembukaan_deposito()
	{
		$data['container'] 		= 'laporan/list_pembukaan_deposito';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function list_saldo_deposito()
	{
		$data['container'] 	= 'laporan/list_saldo_deposito';
		$data['produk'] 	= $this->model_laporan->get_all_produk_deposito();
		$this->load->view('core',$data);
	}

	public function list_pencairan_deposito()
	{
		$data['container'] 		= 'laporan/list_pencairan_deposito';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function list_rekap_pembukaan()
	{
		$data['container'] 		= 'laporan/list_rekap_pembukaan';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_outstanding()
	{
		$data['container'] 		= 'laporan/rekap_outstanding';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_bagi_hasil()
	{
		$data['container'] 		= 'laporan/rekap_bagi_hasil';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function rekap_history()
	{
		$data['container'] 		= 'laporan/rekap_history';
		$data['produk'] 		= $this->model_laporan->get_all_produk_deposito();
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// END LAPORAN DEPOSITO
	/****************************************************************************************/


	//CETAK TRANSAKSI BUKU TABUNGAN

	public function datatable_rekening_buku_tabungan_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','trx_date','nama','account_saving_no','flag_debit_credit','saldo_riil','username','');
		$no_rek   = @$_GET['no_rek'];
		$tanggal  = @$_GET['tanggal'];
		$tanggal2 = @$_GET['tanggal2'];
        $date1    = $this->datepicker_convert(true,$tanggal);
        $date2    = $this->datepicker_convert(true,$tanggal2); 
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		if($sWhere==""){
			if($no_rek!="" or ($tanggal!="" && $tanggal2!="") )
			{
				$sWhere = 'WHERE ';
				if($no_rek!=""){
					$sWhere .= " mfi_trx_account_saving.account_saving_no = '".$no_rek."' ";
				}
				if($date1!="" && $date2!=""){
					if($no_rek!="")
					{
						$sWhere .= " AND ";
					}
					$sWhere .= " mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
				}
				// $sWhere = " WHERE mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
			}
		}else{
			if($no_rek!=""){
				$sWhere .= " AND mfi_trx_account_saving.account_saving_no = '".$no_rek."' ";
			}
			if($date1!="" && $date2!=""){
				$sWhere .= "  AND mfi_trx_account_saving.trx_date BETWEEN '".$date1."' AND '".$date2."' ";
			}
			// $sWhere .= " AND mfi_trx_account_saving.account_saving_no = '".$no_rek."' AND mfi_trx_account_saving.trx_date BETWEEN '".$tanggal."' AND '".$tanggal2."' ";
		}

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		if($flag_all_branch!='1'){
			$sWhere .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk = '".$branch_code."' )";
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_laporan->datatable_rekening_buku_tabungan_setup($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_rekening_buku_tabungan_setup($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_rekening_buku_tabungan_setup(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
        $awal_debit                 = $this->model_laporan->get_saldo_awal_debet($no_rek,$date1);
        $awal_credit                = $this->model_laporan->get_saldo_awal_credit($no_rek,$date1);
        $data['saldo_awal']         = $awal_credit['credit']-$awal_debit['debit'];

        $saldo = $data['saldo_awal'];
		foreach($rResult as $aRow)
		{

          if($aRow['flag_debit_credit']=="D") {
            $saldo -= $aRow['amount'];
          }else{
            $saldo += $aRow['amount'];
          }

			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['trx_account_saving_id'].'" id="checkbox[]" name="checkbox[]" class="checkboxes" >';
			$row[] = date("d-m-Y", strtotime($aRow['trx_date']));
			$row[] = $aRow['flag_debit_credit'];
			if ($aRow['flag_debit_credit']=='C') {			
				$row[] = "";
				$row[] = '<span style="float:right">'.number_format($aRow['amount'], 2, ",", ".").'</span>';
			} else {		
				$row[] = '<span style="float:right">'.number_format($aRow['amount'], 2, ",", ".").'</span>';
				$row[] = "";
			}
			$row[] = '<span style="float:right">'.number_format($saldo, 2, ",", ".").'</span>';
			$row[] = $this->session->userdata('username');

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

    public function export_cetak_trans_buku()
    {
    	// echo "<pre>";
    	// print_r($_POST);
    	// die();
		$mulai_no  			= $this->input->post('mulai_no');
		$mulai_kolom  			= $this->input->post('mulai_kolom');
		// echo $mulai_no."".$mulai_kolom;
		// die();
		$no_rekening  			= $this->input->post('no_rekening');
		$trx_account_saving_id  = $this->input->post('checkbox');
		$institution_name		= $this->session->userdata('institution_name');
		
		// print_r($this->$trx_account_saving_id);
		// die();
		if($trx_account_saving_id==""){
			echo "<script>alert('Please select some row to print !');window.close();</script>";
		}else{

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
		
        $data['mulai_no'] 			= $mulai_no;
        $data['mulai_kolom'] 		= $mulai_kolom;
        $dateawal                 	= $this->model_laporan->get_tgl_awal_export_cetak_trans_buku($trx_account_saving_id[0]);
        $date1 						= $dateawal['trx_date'];
        $awal_debit                 = $this->model_laporan->get_saldo_awal_debet($no_rekening,$date1);
        $awal_credit                = $this->model_laporan->get_saldo_awal_credit($no_rekening,$date1);
        $data['saldo_awal']         = $awal_credit['credit']-$awal_debit['debit'];

        $data['cetak_buku'] = array();
		for ( $i = 0 ; $i < count($trx_account_saving_id) ; $i++ )
		{
			$data['cetak_buku'][] = $this->model_laporan->export_cetak_trans_buku($trx_account_saving_id[$i]);
		}
		$data['margin'] = $this->model_laporan->get_margin($institution_name);
       
        $this->load->view('laporan/export_cetak_trans_buku',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A5', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('BUKU-TRANSAKSI-REK-TABUNGAN-'.$no_rekening.'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    	}
    }
    /****************************************************************************/
    //END LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/

	//END CETAK TRANSAKSI BUKU TABUNGAN

	/****************************************************************************************/	
	// BEGIN REPORT TRANSAKSI TABUNGAN
	/****************************************************************************************/

	public function transaksi_tabungan()
	{
		$data['container'] 		= 'laporan/transaksi_tabungan';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT TRANSAKSI TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REPORT TRANSAKSI AKUN
	/****************************************************************************************/

	public function transaksi_akun()
	{
		$data['container'] 		= 'laporan/transaksi_akun';
		$data['current_date'] 	= $this->format_date_detail($this->current_date(),'id',false,'/');
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT TRANSAKSI AKUN
	/****************************************************************************************/

	public function get_detail_transaction()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$data = $this->model_laporan->get_detail_transaction($trx_gl_id);

		echo json_encode($data);
	}

	/* laporan cetak voucher */

	function cetak_voucher()
	{
		$data['container'] = 'laporan/cetak_voucher';
		$this->load->view('core',$data);
	}

	function datatable_cetak_voucher()
	{
		$from_date = $this->datepicker_convert(true,$this->input->get('from_date'),'/');
		$to_date = $this->datepicker_convert(true,$this->input->get('to_date'),'/');
		$voucher_ref = $this->input->get('voucher_ref');
		$voucher_no = $this->input->get('voucher_no');
		$jurnal_trx_type = $this->input->get('jurnal_trx_type');
		$branch_code = $this->input->get('branch_code');
		$from_date = ($from_date=='')?'':$from_date;
		$to_date = ($to_date=='')?'':$to_date;
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( 'mfi_trx_gl.trx_date','mfi_trx_gl.voucher_no','mfi_trx_gl.voucher_ref', '', 'total_debit','total_credit','');
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch'])."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = " AND ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(".$aColumns[$i].") LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$dWhere['from_date'] 	= $from_date;
		$dWhere['to_date'] 		= $to_date;
		$dWhere['voucher_ref'] 	= $voucher_ref;
		$dWhere['voucher_no'] 	= $voucher_no;
		$dWhere['branch_code'] 	= $branch_code;
		$dWhere['jurnal_trx_type'] 	= $jurnal_trx_type;

		$rResult 			= $this->model_laporan->datatable_cetak_voucher($dWhere,$sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_cetak_voucher($dWhere,$sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_cetak_voucher($dWhere); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<div align="center">'.date('d-m-Y',strtotime($aRow['trx_date'])).'</div>';
			$row[] = '<div align="center">'.$aRow['voucher_no'].'</div>';
			$row[] = $aRow['voucher_ref'];
			$row[] = $aRow['description'];
			$row[] = '<div align="right">'.number_format($aRow['total_debit'],0,',','.').'</div>';
			$row[] = '<div align="right">'.number_format($aRow['total_credit'],0,',','.').'</div>';
			$row[] = '<div align="center" style="white-space:nowrap"><a href="javascript:void(0);" id="btn-cetakvoucher" class="btn mini green" style="white-space:nowrap" trx_gl_id="'.$aRow['trx_gl_id'].'"><i class="icon-print"></i> Cetak</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	public function get_data_cetak_voucher()
	{
		$trx_gl_id = $this->input->post('trx_gl_id');
		$data['trx_gl'] = $this->model_laporan->get_trx_gl_by_id($trx_gl_id);
		$data['trx_gl']['trx_date'] = $this->format_date_detail(substr($data['trx_gl']['trx_date'],0,10),'id',false,'-');
		$data['trx_gl_detail'] = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl_id);
		echo json_encode($data);
	}

	/* REKAP SALDO ANGGOTA */

	public function rekap_saldo_anggota()
	{
		$data['container'] = 'laporan/rekap_saldo_anggota';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/* REKAP TRANSAKSI REMBUG */
	
	public function rekap_transaksi_rembug()
	{
		$data['container'] = 'laporan/rekap_transaksi_rembug';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/* LAPORAN JURNAL TRANSAKSI */
	public function jurnal_transaksi()
	{

		$data['container'] = 'laporan/jurnal_transaksi';
		$this->load->view('core',$data);
	}

	/* BEGIN LIST ANGSURAN PEMBIAYAAN */
	public function list_angsuran_pembiayaan()
	{
		$data['container'] = 'laporan/list_angsuran_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		// $data['produk'] = $this->model_laporan->get_produk_pembiayaan_individu();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['kopegtel'] = $this->model_laporan->get_data_kopegtel();
		$data['status_telkom'] = $this->model_laporan->get_status_telkom();
		$data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	/**********************************************************************************************/
	//PROSES PAR 14-09-2014
	/**********************************************************************************************/
	public function proses_par()
	{
		$data['container'] = 'laporan/proses_par';
		$this->load->view('core',$data);
	}
	/**********************************************************************************************/
	//END PROSES PAR
	/**********************************************************************************************/

	/*LAPORAN LIST JATUH TEMPO ANGSURAN*/
	public function jtempo_angsuran()
	{
		$data['container'] = 'laporan/jtempo_angsuran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$data['petugas'] = $this->model_laporan->get_all_petugas();
		$data['produk'] = $this->model_transaction->get_product_financing(false, true);
		$data['product_smile'] = $this->model_transaction->get_product_financing(false, false, '52');
		$this->load->view('core',$data);
	}

	/**
	* MODUL : HITUNG KOLEKTIBILITAS
	* date : 2014-09-17 22:00
	* @TAM
	* @author sayyid nurkilah
	*/
	public function hitung_kolektibilitas()
	{
		$data['container'] = 'laporan/hitung_kolektibilitas';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function proses_hitung_kolektibilitas()
	{
		$branch_id = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$desc_date = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
		$date = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2);
		if($branch_id=="00000"){
			$branch_id = '';
		}
		$branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);
		$branch_code = $branch_data['branch_code'];
		$branch_class = $branch_data['branch_class'];
		
		$sql_cek_par = "select count(*) as jum from mfi_par where tanggal_hitung=? and branch_code=?";
		$query_cek_par=$this->db->query($sql_cek_par,array($date,$branch_code));
		$row_cek_par=$query_cek_par->row_array();

		if(count($row_cek_par)>0){
			$cek_par_exists=$row_cek_par['jum'];
		}else{
			$cek_par_exists=0;
		}

		if($branch_class!="3"){
			$this->session->set_flashdata('failed','Maaf, Perhitungan Kolektibilitas hanya dapat digunakan oleh CABANG PEMBANTU (CAPEM) SAJA!');
		}
		else if($cek_par_exists>0)
		{
			$this->session->set_flashdata('failed','Proses Hitung Dibatalkan! Perhitungan pernah dilakukan pada tanggal ini!');
		}
		else
		{
			$data = $this->model_laporan_to_pdf->get_laporan_par($date,$branch_code);

			$kolektibilitas = array();
			for($i=0;$i<count($data);$i++)
			{
				$kolektibilitas[] = array(
						'branch_code' => $branch_code
						,'tanggal_hitung' => $date
						,'account_financing_no' => $data[$i]['account_financing_no']
						,'saldo_pokok' => $data[$i]['saldo_pokok']
						,'saldo_margin' => $data[$i]['saldo_margin']
						,'hari_nunggak' => $data[$i]['hari_nunggak']
						,'freq_tunggakan' => $data[$i]['freq_tunggakan']
						,'tunggakan_pokok' => $data[$i]['tunggakan_pokok']
						,'tunggakan_margin' => $data[$i]['tunggakan_margin']
						,'par_desc' => $data[$i]['par_desc']
						,'par' => $data[$i]['par']
						,'cadangan_piutang' => $data[$i]['cadangan_piutang']
					);
			}

			$this->db->trans_begin();
			if(count($kolektibilitas)>0){
				$this->db->insert_batch('mfi_par',$kolektibilitas);
			}
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$this->session->set_flashdata('success','Proses Hitung Kolektibilitas SUKSES!');
			}else{
				$this->db->trans_rollback();
				$this->session->set_flashdata('failed','Something went wrong! please contact your administrator!');
			}
		}

		redirect("laporan/hitung_kolektibilitas");

	}

	/*cetak cover buku*/
	function cetak_cover_buku()
	{
		$data['container'] = 'laporan/cetak_cover_buku';
		$this->load->view('core',$data);
	}


	//CETAK TRANSAKSI BUKU TABUNGAN

	public function datatable_cetak_cover_buku_tabungan()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */
		$aColumns = array( '','mfi_account_saving.account_saving_no','mfi_cif.cif_no','mfi_cif.nama');
		$account_saving_no   = @$_GET['account_saving_no'];
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		if($sWhere==""){
			if($account_saving_no!="")
			{
				$sWhere = 'WHERE ';
				if($account_saving_no!=""){
					$sWhere .= " UPPER(mfi_account_saving.account_saving_no) like '%".strtoupper(strtolower($account_saving_no))."%'";
				}
			}
		}else{
			if($account_saving_no!=""){
				$sWhere .= " AND UPPER(mfi_account_saving.account_saving_no) like '%".strtoupper(strtolower($account_saving_no))."%'";
			}
		}

		$branch_code = $this->session->userdata('branch_code');
		$flag_all_branch = $this->session->userdata('flag_all_branch');
		if($flag_all_branch!='1'){
			$sWhere .= " AND mfi_cif.branch_code in(select branch_code from mfi_branch_member where branch_induk = '".$branch_code."' )";
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] != '' )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_laporan->datatable_cetak_cover_buku_tabungan($sWhere,$sOrder,$sLimit); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_cetak_cover_buku_tabungan($sWhere); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_cetak_cover_buku_tabungan(); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{

			$row = array();
			$row[] = '<div align="center"><a href="javascript:void(0);" account_saving_no="'.$aRow['account_saving_no'].'" id="printpdfcoverbuku" class="btn red mini">Cetak Cover Buku <span class="icon-print"></span></a></div>';
			$row[] = $aRow['account_saving_no'];
			$row[] = $aRow['cif_no'];
			$row[] = $aRow['nama'];

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	public function get_data_cetak_cover_buku()
	{
		$account_saving_no = $this->input->post('account_saving_no');
        $datasaving = $this->model_laporan_to_pdf->get_account_saving_data_by_account_saving_no($account_saving_no);
        echo json_encode($datasaving);
	}

	/**
	* MODUL : LAPORAN  KOLEKTIBILITAS
	* date : 2014-10-08 08:50
	* @TAM
	* @author Ujang Irawan
	*/
	public function kolektibilitas()
	{
		$data['container'] = 'laporan/kolektibilitas';
		// $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/**
	* MODUL : LAPORAN NERACA RINCI
	* date : 2014-10-09 09:20
	* @TAM
	* @author Sayyid Nurkilah
	*/
	public function neraca_rinci_gl()
	{
		$data['container'] = 'laporan/neraca_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/**
	* MODUL : LAPORAN LABA RUGI RINCI
	* date : 2014-10-09 09:20
	* @TAM
	* @author Sayyid Nurkilah
	*/
	public function laba_rugi_rinci_gl()
	{
		$data['container'] = 'laporan/laba_rugi_rinci_gl';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/*
	| Laporan Arus KAS
	| created_by : sayyid nurkilah
	| created_date : 2014-10-25
	*/
	public function laporan_arus_kas()
	{
		$data['container'] = 'laporan/laporan_arus_kas';
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	/***************************************************************************************/
	//REKEP ANGSURAN
	public function rekap_angsuran_pembiayaan()
	{
		$data['container'] = 'laporan/rekap_angsuran_pembiayaan';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	//END REKEP ANGSURAN
	/***************************************************************************************/

	/***************************************************************************************/
	//TAMBAH VARIABEL RESORT
	public function get_all_resort_by_branch_code()
	{
		$branch_code = $this->input->post('branch_code');
		$data = $this->model_laporan->get_all_resort_by_branch_code($branch_code);
		echo json_encode($data);
	}
	//END TAMBAH VARIABEL RESORT
	/***************************************************************************************/

	/*
	| REKAP NOMINATIF
	| sayyid nurkilah
	| 2014-11-11 10:54
	*/
	function rekap_nominatif()
	{
		$data['container']='laporan/rekap_nominatif';
		$data['title']='REKAP NOMINATIF';
		$this->load->view('core',$data);
	}

	/*
	| DATA LENGKAP PEMBIAYAAN
	*/
	function data_lengkap_pembiayaan()
	{
		$data['container']='laporan/data_lengkap_pembiayaan';
		$data['title']='Laporan Data Lengkap Pembiayaan';
		$this->load->view('core',$data);
	}

	/*
	| EXPORT Txt KOPTEL
	| Ade Sagita
	| 2015-04-01 20:25
	*/
    public function export_txt_list_jatuh_tempo_angsuran()
    {
        $tanggal1 = $this->uri->segment(3);
        $tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2 = $this->uri->segment(4);
        $tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $produk = $this->uri->segment(5); 
        $datas = $this->model_laporan_to_pdf->export_txt_list_jatuh_tempo_angsuran($tanggal1_,$tanggal2_,$produk);

        $html = '';
        foreach ($datas as $key) {
        	$html .=$key['cif_no'].' | '.$key['besar_angsuran'].' | '.$key['jtempo_angsuran_next'].' | '.$key['tanggal_jtempo'].'<br>';
        }
        $data['datas']=$datas;
        $this->load->view('laporan/export_txt_list_jatuh_tempo_angsuran',$data);
    }

	public function datatable_jtempo_angsuran()
	{
		$branch=@$_GET['branch'];
		$produk=@$_GET['produk'];
		$tanggal=@$_GET['tanggal'];
		$tanggal2=@$_GET['tanggal2'];
		$expl1  = explode('/',$tanggal);
		$expl2  = explode('/',$tanggal2);
        $tanggal = $expl1[2].'-'.$expl1[1].'-'.$expl1[0];
        $tanggal2 = $expl2[2].'-'.$expl2[1].'-'.$expl2[0];

		$aColumns = array( 'a.cif_no','a.saldo_sebelumnya','a.besar_angsuran','a.jtempo_angsuran_next','a.tanggal_jtempo','a.counter_angsuran');
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
			$sWhere = "AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				if ( $aColumns[$i] != '' )
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower( $_GET['sSearch'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $aColumns[$i] != '' ){
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
					if ( $sWhere == "" ){
						$sWhere = "AND ";
					}else{
						$sWhere .= " AND ";
					}
					$sWhere .= "LOWER(CAST(".$aColumns[$i]." AS VARCHAR)) LIKE '%".strtolower($_GET['sSearch_'.$i])."%' ";
				}
			}
		}

		$rResult 			= $this->model_laporan->datatable_jtempo_angsuran($sWhere,$sOrder,$sLimit,$branch,$produk,$tanggal,$tanggal2); // query get data to view
		$rResultFilterTotal = $this->model_laporan->datatable_jtempo_angsuran($sWhere,'','',$branch,$produk,$tanggal,$tanggal2); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_laporan->datatable_jtempo_angsuran('','','',$branch,$produk,$tanggal,$tanggal2); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$counter = ($aRow['counter_angsuran']=='') ? 0 : $aRow['counter_angsuran'] ;
			$row = array();
			$row[] = $aRow['cif_no'];
			$row[] = number_format($aRow['saldo_sebelumnya'],0,',','.');
			$row[] = number_format($aRow['besar_angsuran'],0,',','.');
			$row[] = "01".substr(date("d-m-Y",strtotime($aRow['jtempo_angsuran_next'])),-8);
			$row[] = date("d-m-Y",strtotime($aRow['tanggal_jtempo']));
			$row[] = $aRow['counter_angsuran']+1;

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	/*
	| END EXPORT Txt KOPTEL
	| Ade Sagita
	| 2015-04-01 20:25
	*/

	/*
	| Begin export pengajuan asuransi koptel. 26-08-2015
	| Ade sagita
	*/
	public function list_peserta_asuransi()
	{
		$data['container'] = 'laporan/list_peserta_asuransi';
		$data['produk'] = $this->model_laporan->get_all_produk();
		$data['date1'] = date('d/m/Y', strtotime(date("Y-m-d") . ' -10 day'));
		$data['date2'] = date("d/m/Y");
		$data['produk'] = $this->model_laporan->get_all_produk();
		// $data['akad'] = $this->model_laporan->get_all_akad('2');
		$this->load->view('core',$data);
	}

	public function get_list_spb()
	{
		$keyword = $this->input->post('keyword',true);
		$keyword = strtolower($keyword);
		$datas = $this->model_laporan->get_list_spb($keyword);
		echo json_encode($datas);
	}
	/*
	| End export pengajuan asuransi koptel. 26-08-2015
	| Ade sagita
	*/


	/*
	| Begin laporan pembayaran. 13-01-2016
	| Ade sagita
	*/
	public function pembayaran()
	{
		$data['container'] = 'laporan/pembayaran';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	public function grid_angsuran()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'data_peserta_id';
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:date("d/m/Y");
		$thru_date = isset($_REQUEST['thru_date'])?$_REQUEST['thru_date']:date("d/m/Y");
		$from_date = $this->datepicker_convert(true,$from_date);
		$thru_date = $this->datepicker_convert(true,$thru_date);
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_laporan->grid_angsuran('','','','',$from_date,$thru_date);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_laporan->grid_angsuran($sidx,$sord,$limit_rows,$start,$from_date,$thru_date);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{

			$responce['rows'][$i]['angsuran_id'] = $row['angsuran_id'];
			$responce['rows'][$i]['cell'] = array(
				 $row['angsuran_id']
				,$row['import_date']
				,$row['file_name']
				,$row['keterangan']
				,$row['fullname']
				,$row['status']
			);
			$i++;
		}

		echo json_encode($responce);
	}

	public function data_detail_angsuran_temp()
	{
		$angsuran_id = $this->input->post('angsuran_id');
		$data = $this->model_laporan->data_detail_angsuran_temp($angsuran_id);
		echo json_encode($data);
	}
	/*
	| End laporan pembayaran. 13-01-2016
	| Ade sagita
	*/
}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */