<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_to_csv extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true,'main','back');
		$this->load->model("model_laporan_to_pdf");
		$this->load->model("model_laporan");
		$this->load->model("model_cif");
		$this->load->library('phpexcel');
		$CI =& get_instance();
	}

	public function export_list_pembukaan_tabungan()
	{
		$produk 		= $this->uri->segment(3);		
		$cabang			= $this->uri->segment(4);		
		$datas 			= $this->model_laporan->export_list_pembukaan_tabungan($produk,$cabang);

		$arr_csv = array();
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$status_rekening = $datas[$i]['status_rekening'];
			if($status_rekening==1){
				$status_rekening = "Aktif";
			}else{
				$status_rekening = "Tidak Aktif";
			}
			$arr_csv[] = array(
				'No'=>($i+1),
				'No.Rekening'=>$datas[$i]['account_saving_no'].'_',
				'Nama'=>$datas[$i]['nama'],
				'Produk'=>$datas[$i]['product_name'],
				'Status'=>$status_rekening,
				'Saldo'=>$datas[$i]['saldo_memo']
			);
		}

		download_send_headers('Saldo Tabungan.csv');
		echo array2csv($arr_csv);
		die();
	}

	public function export_data_pembayaran()
	{
		$tanggal1 		= $this->uri->segment(3);		
		$tanggal2		= $this->uri->segment(4);		

		$from_date = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);	
		$thru_date = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);	

		$datas 			= $this->model_laporan->export_data_pembayaran($from_date,$thru_date);

		$arr_csv = array();
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$keterangan = '';
			if($datas[$i]['selisih']>0){ //cari alasan selisih
				$data_acc_financing = $this->model_laporan->get_acc_financing_by_no($datas[$i]['account_financing_no']);
				if($data_acc_financing['sisa_counter']==1){ //angsuran terakhir
					if($data_acc_financing['saldo_pokok']+$data_acc_financing['saldo_margin']!=$datas[$i]['selisih']){
						$keterangan = "Saldo tidak cukup - angsuran terakhir";
					}
				}else{
					$keterangan = "Saldo tidak cukup";					
				}
			}

			if($i>0){
				if( $datas[$i]['file_name']==$datas[($i-1)]['file_name']
					&& $datas[$i]['import_date']==$datas[($i-1)]['import_date']
					&& $datas[$i]['nik']==$datas[($i-1)]['nik']
					&& $datas[$i]['nama_pegawai']==$datas[($i-1)]['nama_pegawai']
					&& $datas[$i]['jumlah_bayar']==$datas[($i-1)]['jumlah_bayar'] ){

					$datas[$i]['file_name'] = ' ';
					$datas[$i]['import_date'] = ' ';
					$datas[$i]['nik'] = ' ';
					$datas[$i]['nama_pegawai'] = ' ';
					$datas[$i]['jumlah_bayar'] = ' ';
					$datas[$i]['jumlah_settle'] = ' ';
					$datas[$i]['selisih'] = ' ';					
				}
			}
			$arr_csv[] = array(
				 'No'=>($i+1)
				,'Tanggal'		=> $datas[$i]['import_date']
				,'File'			=> $datas[$i]['file_name']
				,'Nik'			=> $datas[$i]['nik']
				,'Nama'			=> $datas[$i]['nama_pegawai']
				,'Jumlah.Bayar'	=> $datas[$i]['jumlah_bayar']
				,'Riil.Debet'	=> $datas[$i]['jumlah_settle']
				,'Selisih.Debet'=> $datas[$i]['selisih']
				,'No.Rekening'	=> $datas[$i]['account_financing_no']
				,'Jml.Debet'	=> $datas[$i]['hasil_proses']
				,'Keterangan'	=> $keterangan
			);
		}

		download_send_headers('Upload_angsuran_'.$tanggal1.'_'.$tanggal2.'.csv');
		echo array2csv($arr_csv);
		die();
	}

	function export_lap_list_outstanding_pembiayaan_individu()
	{
		$akad = $this->uri->segment(3);	
		$produk_pembiayaan = $this->uri->segment(4);	
		$pengajuan_melalui = $this->uri->segment(5);	
		$peruntukan = $this->uri->segment(6);	
						
		$datas 			= $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_individu($akad,$produk_pembiayaan,$pengajuan_melalui,$peruntukan);
        // $produk_name 	= $this->model_laporan->get_produk_name($produk_pembiayaan);


		$arr_csv = array();
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
	        $tunggakan_pokok      = $datas[$i]['freq_tunggakan']*$datas[$i]['angsuran_pokok'];
	        $tunggakan_margin     = $datas[$i]['freq_tunggakan']*$datas[$i]['angsuran_margin'];

			$arr_csv[] = array(
				 'No'=>($i+1)
				// ,'Anggota' 				=> $datas[$i]['account_financing_no']
				,'No Rekening' 			=> $datas[$i]['account_financing_no']
				,'Nama' 				=> $datas[$i]['nama']
				,'Tanggal Droping' 		=> ((isset($datas[$i]['droping_date'])==true)? $datas[$i]['droping_date']:'-')
				,'Pokok' 				=> $datas[$i]['pokok']
				,'Margin' 				=> $datas[$i]['margin']
				,'Freq Bayar' 			=> $datas[$i]['freq_bayar_pokok']
				,'Freq Saldo' 			=> $datas[$i]['saldo_freq_bayar']
				,'Saldo Pokok' 			=> $datas[$i]['saldo_pokok']
				,'Saldo Margin' 		=> $datas[$i]['saldo_margin']
				,'Freq Tertunggak' 		=> $datas[$i]['freq_tunggakan']
				,'Pokok Tertunggak' 	=> $tunggakan_pokok
				,'Margin Tertunggak' 	=> $tunggakan_margin
				,'Jatuh Tempo' 			=> ((isset($datas[$i]['tanggal_jtempo'])==true)?$datas[$i]['tanggal_jtempo']:'')
				,'Besar Angsuran' 		=> $datas[$i]['besar_angsuran']
				,'Produk' 				=> $datas[$i]['product_name']

			);
		}

		download_send_headers('List_Outstanding.csv');
		echo array2csv($arr_csv);
		die();
	}

    function get_mutasi_saldo(){
        $branch_code = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $product = $this->uri->segment(6);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];

        $last_date = date('Y-m-d',strtotime($periode_tahun.'-'.$periode_bulan.'-01 -1 days'));

        $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
        $thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));

        $datas = $this->model_laporan->get_mutasi_saldo($branch_code,$from_periode,$thru_periode,$product);

        $ii = 0;
        $total_awal_pokok = 0;
        $total_awal_margin = 0;
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_akhir_pokok = 0;
        $total_akhir_margin = 0;

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
        	$total_awal_pokok += $datas[$i]['saldo_pokok'];
        	$total_awal_margin += $datas[$i]['saldo_margin'];
        	$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
        	$total_angsuran_margin += $datas[$i]['angsuran_margin'];
        	$total_akhir_pokok = $total_awal_pokok - $total_angsuran_pokok;
        	$total_akhir_margin = $total_awal_margin - $total_angsuran_margin;

            $account_financing_no = $datas[$i]['account_financing_no'];
            $nama = $datas[$i]['nama'];
            $product_name = $datas[$i]['product_name'];
            $tanggal_akad = $datas[$i]['tanggal_akad'];
            $pokok = $datas[$i]['pokok'];
            $saldo_pokok = $datas[$i]['saldo_pokok'];
            $saldo_margin = $datas[$i]['saldo_margin'];
            $angsuran_pokok = $datas[$i]['angsuran_pokok'];
            $angsuran_margin = $datas[$i]['angsuran_margin'];
            $akhir_pokok = $datas[$i]['saldo_pokok'] - $datas[$i]['angsuran_pokok'];
            $akhir_margin = $datas[$i]['saldo_margin'] - $datas[$i]['angsuran_margin'];

            $arr_csv[] = array(
            	'No' => ($i + 1),
            	'No. Rekening' => $account_financing_no,
            	'Nama' => $nama,
            	'Produk' => $product_name,
            	'Tanggal Droping' => $tanggal_akad,
            	'Plafon' => $pokok,
            	'Saldo Pokok Awal' => $saldo_pokok,
            	'Saldo Margin Awal' => $saldo_margin,
            	'Angsuran Pokok' => $angsuran_pokok,
            	'Angsuran Margin' => $angsuran_margin,
            	'Saldo Pokok Akhir' => $akhir_pokok,
            	'Saldo Margin Akhir' => $akhir_margin
            );
            
            $ii++;
        }

		download_send_headers('List_Mutasi_Saldo_'.$from_periode.'-'.$thru_periode.'.csv');
		echo array2csv($arr_csv);
		die();
    }

}