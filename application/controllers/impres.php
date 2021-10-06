<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrasi extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_nasabah');
		$this->load->model('model_transaction');
		$this->load->model('model_cif');
	}

	public function index()
	{
		echo 'Not Found!';
	}

	public function pengajuan()
	{
		$data['container'] = 'migrasi/migrasi';
		$data['title'] = "Migrasi";
		$data['boxcolor'] = "blue";
		$data['fileupload'] = true;
		$data['filenameupload'] = 'migrasi2018.xlsx';
		$data['button_save'] = '<button id="save_trx" class="btn red" style="font-size:13px;">Save Pengajuan</button>';
		$data['savefile'] = 'add_pengajuan_pembiayaan_koptel';

		$this->load->view('core',$data);
	}

	public function regisakad()
	{
		$data['container'] = 'migrasi/migrasi';
		$data['title'] = "Migrasi - Regis Akad";
		$data['boxcolor'] = "red";
		$data['fileupload'] = false;
		$data['filenameupload'] = 'migrasi_regisakad2018.xlsx';
		$data['button_save'] = '<button id="save_trx" class="btn green" style="font-size:13px;">Save Akad</button>';
		$data['savefile'] = 'proses_registrasi_akad_pembiayaan';

		$this->load->view('core',$data);
	}

	public function do_upload_pengajuan()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		set_time_limit(0);

		$url = base_url() . 'assets/migrasi2018.xlsx';
		$headers = @get_headers($url);
		if(@strpos($headers[0],'200'))
	    {
	        $return = array('success'=>false,'error'=>"Proses Migrasi belum dalam proses, selesaikan terlebih dahulu!");
			echo json_encode($return);
			exit;
	    }

		$userfile = @$_FILES['userfile'];
		$file_name = $userfile['name'];
		$return = array('success'=>true);
		
		$structure = './assets/';

		$config['upload_path'] = $structure;
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '100000';
		$config['file_name'] = "migrasi2018";

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
		}else{
			$upload_data = $this->upload->data();
			
			$return = array('success'=>true);
		}

		echo json_encode($return);
	}

	function jqGrid_pengajuan()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		ini_set('upload_max_filesize', '50M');
		ini_set('max_execution_time', '3600');
		set_time_limit(0);

		$this->load->library('phpexcel');

		$structure = './assets/';
		$file_client_name = isset($_REQUEST['file_name'])?$_REQUEST['file_name']:'';
		$file_name = $structure.$file_client_name;

		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;
			foreach($sheetData as $row){

				if($i>0){
					// abaikan row pertama
					// set param
					$jangkawaktu = $row['I'];
					$amount = $row['H'];
					$counter = $row['N'];
					$saldo_pokok = $row['O'];

					$responce['rows'][$idx]['no'] = isset($row['A']) ? $row['A'] : '';
					$nik = isset($row['A']) ? $row['A'] : '';
					$data = $this->model_transaction->get_ajax_value_from_nik($this->convert_numeric($nik));
					$j_kewajiban = $this->model_transaction->jumlah_kewajiban($this->convert_numeric($nik));
					$saldo_kewajiban = $this->model_transaction->get_summary_saldo_kewajiban($this->convert_numeric($nik));
					
					$explode2 = explode('-', $data['tgl_pensiun_normal']);
                	$show_pensiun =  $explode2[2]+'-'+$explode2[1]+'-'+$explode2[0];
                	$status_financing_reg = $this->model_nasabah->cek_regis_pembiayaan($this->convert_numeric($nik));
                	
                	$datas = $this->model_nasabah->cek_nik_from_mfi_cif($this->convert_numeric($nik));
                	$cif_id = (count($datas) == 0) ? 0 : $data['cif_id'];
					
					$datas2 = $this->model_nasabah->cek_flag_thp100($this->convert_numeric($nik));
					$data2 = $this->model_nasabah->count_kopegtel_code_by_nik($this->convert_numeric($nik));
					$total = (count($datas2)==0) ? "0|".$data2 : $datas2['nik'].'|'.$data2;
					$explode2 = explode('|', $total);
                  	$flag_thp100 = ($explode2[0]=="0") ? "0" : "1";
                  	
                  	// mendapatkan jenis margin
                  	$product_code = $this->convert_numeric($row['C']);
                  	$product = $this->model_transaction->get_product_financing_by_productcode($this->convert_numeric($product_code));
                  	$jenis_margin = $product->jenis_margin;
                  	$rate = $product->rate_margin2;

                  	$dates = $row['P'];
                  	$months = $row['Q'];
                  	$years = $row['R'];

                  	if($dates != "" || $months != "" || $years != ""){
                  		$ymd = $years.'-'.str_pad($months, 2, "0", STR_PAD_LEFT).'-'.str_pad($dates, 2, "0", STR_PAD_LEFT);
                  		$tgl_akad = $ymd;
                  		$tgl_pengajuan = $ymd;
                  	}else{
                  		$tgl_akad = "";
                  		$tgl_pengajuan = "";
                  	}

					// $tgl_angsur1 = date("Y-m-d",strtotime("2017-12-25 - ".$counter." month"));
					$setakad = date("Y-m-25", strtotime($tgl_akad));
					$tgl_angsur1 = date("Y-m-25", strtotime($setakad.' +1 month'));
					$check_dateregis = $this->get_date_regis_by_tglakad_baru($jangkawaktu, $tgl_angsur1);
					$expregis = explode("|", $check_dateregis);
					$tgl_jatuhtempo = $expregis[1];

					// check premi angsuran
					$usia = $this->get_usia_menurut_asuransi($data['tgl_lahir'],$tgl_pengajuan);
					$premi_asuransi = $this->get_premi_asuransi($jangkawaktu,$usia,$amount);
					
					// hitung margin
					$jumlah_margin="";$angsuran_pokok="";
					if($jenis_margin == '2'){
						$jumlah_margin = $this->get_margin_efektif($amount, $jangkawaktu, $rate);
						$angsuran_pokok="0";
						$angsuran_margin="0";
						$total_angsuran="0";
					}else if($jenis_margin == '3'){ // anuitas
						$tmvalid = true;
						if ($amount=='' || $amount=='0') {
							$tmvalid = false;
						}
						if ($jangkawaktu=='' || $jangkawaktu=='0') {
							$tmvalid = false;
						}
						if ($tmvalid==true) {
							$res_anuitas = $this->get_total_angsuran_anuitas($amount, $jangkawaktu, $rate);

							$jumlah_margin = number_format($res_anuitas['total_margin'],0,',','.');
							$angsuran_pokok = "0";
							$angsuran_margin = "0";
							$total_angsuran = in_array($row['C'], array(53, 54, 56)) ? $row['M'] : $res_anuitas['total_angsuran'];
						}
					}else{ // flat
						$angsuran_pokok = $row['K'];
				        $angsuran_margin = $row['L'];
				        $total_angsuran = $row['M'];
				        $jumlah_margin = $angsuran_margin*$jangkawaktu; //number_format($row['J'],0,',','.');
					}

                  	$responce['rows'][$idx]['cell'] = array(
						 $cif_id
						 ,$data['nik']
						 // ,$nik
						 ,isset($data['nama_pegawai']) ? $data['nama_pegawai'] : ''
						 ,isset($data['tempat_lahir']) ? $data['tempat_lahir'] : ''
						 ,isset($data['tgl_lahir']) ? $data['tgl_lahir'] : ''
						 ,isset($data['band']) ? $data['band'] : ''
						 ,isset($data['posisi']) ? $data['posisi'] : ''
						 ,isset($data['loker']) ? $data['loker'] : ''
						 ,isset($data['alamat']) ? $data['alamat'] : ''
						 ,isset($data['no_ktp']) ? $data['no_ktp'] : ''
						 ,isset($data['telpon_seluler']) ? $data['telpon_seluler'] : ''
						 ,isset($data['nama_pasangan']) ? $data['nama_pasangan'] : ''
						 ,isset($data['nama_bank']) ? $data['nama_bank'] : ''
						 ,isset($data['bank_cabang']) ? $data['bank_cabang'] : ''
						 ,isset($data['no_rekening']) ? $data['no_rekening'] : ''
						 ,isset($data['atasnama_rekening']) ? $data['atasnama_rekening'] : $row['B']
						 ,isset($data['thp']) ? $data['thp'] : ""
						 ,isset($data['thp']) ? $data['thp']*40/100 : ""
						 ,$angsuran_pokok
						 ,$angsuran_margin
						 ,$total_angsuran
						 ,isset($j_kewajiban['total_koptel']) ? str_replace('-','',$j_kewajiban['total_koptel']) : ""
						 ,isset($saldo_kewajiban['total_saldo']) ? $saldo_kewajiban['total_saldo'] : ""
						 ,isset($data['tgl_pensiun_normal']) ? $data['tgl_pensiun_normal'] : ""
						 ,isset($show_pensiun) ? $show_pensiun : ""
						 ,isset($data['kopegtel_code']) ? $data['kopegtel_code'] : ""
						 ,isset($status_financing_reg['jumlah']) ? $status_financing_reg['jumlah'] : ""
						 ,$flag_thp100
						 ,isset($data['gender']) ? $data['gender'] : ""
						 ,isset($jenis_margin) ? $jenis_margin : ""
						 ,$tgl_pengajuan
						 ,$tgl_akad
						 ,$tgl_angsur1
						 ,$tgl_jatuhtempo
						 ,isset($row['F']) ? $row['F'] : ""
						 ,isset($row['G']) ? $row['G'] : ""
						 ,isset($row['C']) ? $row['C'] : ""
						 ,isset($amount) ? $amount : ""
						 ,isset($jangkawaktu) ? $jangkawaktu : ""
						 ,isset($jumlah_margin) ? $jumlah_margin : ""
						 ,isset($premi_asuransi) ? $premi_asuransi : ""
						 ,isset($counter) ? $counter : ""
						 ,isset($saldo_pokok) ? $saldo_pokok : ""
					);
				
					$idx++;
				
				}
				
				$i++;

			}

		} else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);
	}

	/*
	pengajuan pembiayaan
	*/
	public function add_pengajuan_pembiayaan_koptel()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		set_time_limit(0);
		
		$separator = array('.', ',');
		
		$cif_id				= $this->input->post('cif_id');
		$nik				= $this->input->post('nik');
		$jenis_kelamin 		= ($this->input->post('gender')=="PRIA") ? "P" : "W" ;
		$nama				= $this->input->post('nama');
		$peruntukan			= 2;
		$status				= 0;
		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$jumlah_angsuran 	= $this->input->post('jumlah_angsuran');
		$product_code_smile = $this->input->post('product_code_smile');
		$pcode 				= $this->input->post('product_code');
		$product_code 		= ($pcode == '52') ? (($product_code_smile == "") ? $pcode : $product_code_smile) : $pcode;
		$amount 			= $this->input->post('amount');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$pengajuan_melalui	= $this->input->post('pengajuan_melalui');
		$kopegtel 	 		= $this->input->post('kopegtel');
		
		$tempat_lahir 		= $this->input->post('tempat_lahir');
		$tgl_lahir 			= $this->input->post('tgl_lahir');
		$alamat 			= $this->input->post('alamat');
		$alamat_lokasi_kerja= $this->input->post('alamat_lokasi_kerja');
		$no_ktp 			= $this->input->post('no_ktp');
		$telpon_rumah  		= $this->input->post('telpon_rumah');
		$no_telpon  		= $this->input->post('no_telpon');
		$nama_pasangan 		= $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');
		$thp 				= $this->input->post('thp');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$premi_asuransi = $this->convert_numeric($this->input->post('premi_asuransi'));

		$total_angsuran 	= $this->input->post('total_angsuran');

		$tanggal_pengajuan	= $this->input->post('tanggal_pengajuan');
		$tgl_akad 			= $this->input->post('tgl_akad');
		$angsuranke1 		= $this->input->post('angsuranke1');
		$tgl_jtempo 		= $this->input->post('tgl_jtempo');
		
		$created_by			= 'sys';

		//tambahan baru 28-03-23-50
		$bank_cabang 			= $this->input->post('bank_cabang');
		$lunasi_ke_kopegtel 	= $this->input->post('lunasi_ke_kopegtel');
		$keterangan_peruntukan 	= $this->input->post('keterangan_peruntukan');
		$flag_thp 				= $this->input->post('flag_thp100');
		$saldo_kewajiban 		= $this->input->post('saldo_kewajiban');
		$angsuran_pokok 		= $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin 		= $this->convert_numeric($this->input->post('angsuran_margin'));

		if($saldo_kewajiban==false){$saldo_kewajiban=0;}
		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;

		
		$lunasi_ke_koptel 	= $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel = ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel 		= $this->input->post('saldo_kewajiban_ke_koptel');
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		
		//saldo kewajiban ke koptel sekarang sesuai yang dicheklist
		$check_saldo_val = $this->input->post('check_saldo_val');
		$account_financing_no = $this->input->post('account_financing_no');
		$check_saldo_pokok = $this->convert_numeric($this->input->post('check_saldo_pokok'));
		$check_saldo_margin = $this->convert_numeric($this->input->post('check_saldo_margin'));

		$saldo_kewajiban_ke_koptel = 0;
		$lunasi_ke_koptel = 0;
		for($i=0; $i<count($check_saldo_pokok); $i++){
			if($check_saldo_val[$i]=='1'){
				$lunasi_ke_koptel = 1;
				$saldo_kewajiban_ke_koptel += $check_saldo_pokok[$i];
			}
		}
		//end saldo kewajiban ke koptel sekarang sesuai yang dicheklist
		
		//jenis margin efektif
		$jenis_margin 		= $this->input->post('jenis_margin');
		$total_margin 		= $this->convert_numeric($this->input->post('jumlah_margin'));		
		$saldo_oustanding 	= $this->input->post('saldo_oustanding');		

		for ( $i = 0 ; $i < count($nik) ; $i++ ){
			if (trim($nik[$i])!="") {
				$account_financing_reg_id 	= uuid(false);
				$usia 						= $this->get_usia_menurut_asuransi($tgl_lahir[$i],date('Y-m-d'));
				$manfaat 					= $this->convert_numeric($amount[$i]);
				$created_date	 			= date('Y-m-d H:i:s');

				$status_asuransi = 0;
				$uw_policy = $this->model_nasabah->get_uw_policy($product_code[$i],$usia,$manfaat);
				if ($uw_policy=='NM') {
					$status_asuransi = 1;
				}

				$data = array(
					 'account_financing_reg_id'  =>$account_financing_reg_id
					,'cif_no'				     =>$nik[$i]
					,'amount'				     =>$this->convert_numeric($amount[$i])
					,'peruntukan'			     =>$peruntukan
					,'status'				     =>$status
					,'tanggal_pengajuan'	     =>$tanggal_pengajuan[$i]
					,'product_code'			     =>$product_code[$i]
					,'created_by'			     =>$created_by
					,'created_date'			     =>$created_date
					,'jumlah_kewajiban'		     =>!empty($jumlah_kewajiban[$i]) ? $this->convert_numeric($jumlah_kewajiban[$i]) : 0
					,'jumlah_angsuran'		     =>!empty($jumlah_angsuran[$i]) ? $this->convert_numeric($jumlah_angsuran[$i]) : 0
					,'jangka_waktu'			     =>$jangka_waktu[$i]
					,'pengajuan_melalui'	     =>$pengajuan_melalui[$i]
					,'kopegtel_code'		     =>$kopegtel[$i]
					,'nama_bank'			     =>$nama_bank[$i]
					,'no_rekening'			     =>$no_rekening[$i]
					,'atasnama_rekening'	     =>$atasnama_rekening[$i]
					,'bank_cabang'			     =>$bank_cabang[$i]
					,'lunasi_ke_kopegtel'	     =>!empty($lunasi_kopegtel[$i]) ? $lunasi_kopegtel[$i] : 0
					,'description'			     =>""
					,'flag_thp'				     =>!empty($flag_thp[$i]) ? $flag_thp[$i] : 0
					,'saldo_kewajiban'		     =>!empty($saldo_kewajiban[$i]) ? $this->convert_numeric($saldo_kewajiban[$i]) : 0
					,'status_asuransi'		     =>$status_asuransi
					,'uw_policy'			     =>$uw_policy
					,'premi_asuransi'		     =>$premi_asuransi[$i]
					,'lunasi_ke_koptel'		     =>0
					,'saldo_kewajiban_ke_koptel' =>!empty($saldo_kewajiban_ke_koptel[$i]) ? $saldo_kewajiban_ke_koptel[$i] : 0
					,'angsuran_pokok'			 =>$angsuran_pokok[$i]
					,'angsuran_margin'			 =>$angsuran_margin[$i]
					,'pelunasan_ke_kopeg_mana' 	 =>""
					,'status_dokumen_lengkap' 	 =>1
					,'total_margin' 		 	 =>$total_margin[$i]
				);

				$data_cif = array(
					 'nama'					=>$nama[$i]
					,'panggilan'			=>''
					,'tmp_lahir'			=>$tempat_lahir[$i]
					,'tgl_lahir'			=>(!empty($tgl_lahir[$i])) ? $tgl_lahir[$i] : NULL
					,'alamat'				=>$alamat[$i]
					,'no_ktp'				=>$no_ktp[$i]
					,'telpon_seluler'		=>$no_telpon[$i]
					,'telpon_rumah'			=>$telpon_rumah[$i]
					,'cif_type'				=>1
					,'koresponden_alamat'	=>$alamat[$i]
					,'status'				=>1
					,'nama_pasangan'		=>$nama_pasangan[$i]
					,'pekerjaan_pasangan'	=>$pekerjaan_pasangan[$i]
					,'nama_bank'			=>$nama_bank[$i]
					,'no_rekening'			=>$no_rekening[$i]
					,'atasnama_rekening'	=>$atasnama_rekening[$i]
					,'jenis_kelamin'		=>$jenis_kelamin[$i]
					,'bank_cabang'			=>$bank_cabang[$i]
					,'alamat_lokasi_kerja'	=>$alamat_lokasi_kerja[$i]
				);

				if($cif_id[$i]=='0'){
					$data_cif['cif_no'] 		= $nik[$i];
					$data_cif['created_by'] 	= $this->session->userdata('user_id');
					$data_cif['branch_code'] 	= $this->session->userdata('branch_code');
				}
				$param = array('cif_no'=>$nik[$i]);

				$param_thp = array('nik'=>$nik[$i]);
				$data_thp = array('status'=>2,'active_date'=>date('Y-m-d H:i:s'));

				$this->db->trans_begin();
				$this->model_nasabah->add_pengajuan_pembiayaan($data);

				$this->model_nasabah->update_flag_thp($data_thp, $param_thp);//update semua flag thp 100% (Take Home Pay) -- GAJI BERSIH
				if($cif_id[$i]=='0'){
					$this->model_nasabah->insert_cif($data_cif);
				}else{
					$this->model_nasabah->update_cif($data_cif,$param);
				}

				$update_thp = array('thp' => $this->convert_numeric($thp[$i]));
				$this->model_nasabah->update_thp_pegawai($update_thp,$param_thp);

				$list_data = array(
								'account_financing_reg_id' 	=> $account_financing_reg_id
								,'nik' 						=> $nik[$i]
								,'nama_bank'				=> $nama_bank[$i]
								,'no_rekening'				=> $no_rekening[$i]
								,'atasnama_rekening'		=> $atasnama_rekening[$i]
								,'bank_cabang'				=> $bank_cabang[$i]
								,'tgl_akad'					=> $tgl_akad[$i]
								,'tanggal_pengajuan'		=> $tanggal_pengajuan[$i]
								,'angsuranke1'				=> $angsuranke_1
								,'tgl_jtempo'				=> $tgl_jtempo[$i]
								,'melalui'					=> $pengajuan_melalui[$i]
								,'alamat_lokasi_kerja'		=> $alamat_lokasi_kerja[$i]
								,'product_code_post'		=> $product_code[$i]
								,'jumlah_angsuran'		   	=>!empty($jumlah_angsuran[$i]) ? $this->convert_numeric($jumlah_angsuran[$i]) : 0
								,'lunasi_ke_kopegtel'	    =>!empty($lunasi_kopegtel[$i]) ? $lunasi_kopegtel[$i] : 0
								,'saldo_kewajiban'		   	=>!empty($saldo_kewajiban[$i]) ? $this->convert_numeric($saldo_kewajiban[$i]) : 0
								,'jumlah_kewajiban'		    =>!empty($jumlah_kewajiban[$i]) ? $this->convert_numeric($jumlah_kewajiban[$i]) : 0
								,'saldo_kewajiban_ke_koptel'=>!empty($saldo_kewajiban_ke_koptel[$i]) ? $saldo_kewajiban_ke_koptel[$i] : 0
								,'amount' 		 			=>$amount[$i]
								,'jangkawaktu' 		 		=>$jangka_waktu[$i]
								,'jenis_margin' 		 	=>$jenis_margin[$i]
								,'total_margin' 		 	=>$total_margin[$i]
							);

				//** PROSES APPROVE
				$this->act_approve_pengajuan_pembiayaan($list_data);
				
			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'msg'=>"Row ke <b>". $i . "</b> NIK belum terdaftar!");
				echo json_encode($return);
				exit;
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$structure = './assets/';
			$file = $structure."migrasi2018.xlsx";
			rename($file, $structure . "migrasi_regisakad2018" . ".xlsx");

			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/*
	get date regis
	*/
	function get_date_regis_by_tglakad_baru($jangkawaktu, $tgl_akad) //Ade Sagita, 14-04-2015
	{
		$nValid = true;

		$jangka_waktu = $jangkawaktu;
		$akad = $tgl_akad;
		$expl = explode("-",$akad);
		
		$bulan = $expl[1];
		$tahun = $expl[0];

		if($bulan!='12'){
			$bulannya = ($bulan+1);
			if($bulannya<10){
				$bulannya = '0'.$bulannya;
			}
			$tahunnya = $tahun;
			$angsuranke1 = $tahunnya.'-'.$bulannya.'-25';
		}else{
			$bulannya = '01';
			$tahunnya = ($tahun+1);
			$angsuranke1 = $tahunnya.'-'.$bulannya.'-25';
		}

		$angsurankesatu = $tahunnya.'-'.$bulannya.'-25';

		$jangka_waktu = ($jangka_waktu-1);

		$tgl_jtempo = date("Y-m-d",strtotime($angsurankesatu." + $jangka_waktu month"));

		$return = $angsuranke1.'|'.$tgl_jtempo;
		return $return;
	}

	/*
	regis akad
	*/
	public function proses_registrasi_akad_pembiayaan()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		set_time_limit(0);

		$nik				= $this->input->post('nik');
		$nama_bank 			= $this->input->post('nama_bank');
		$no_rekening 		= $this->input->post('no_rekening');
		$atasnama_rekening 	= $this->input->post('atasnama_rekening');
		$bank_cabang 		= $this->input->post('bank_cabang');
		$tanggalpengajuan	= $this->input->post('tanggal_pengajuan');
		$tgl_akad 			= $this->input->post('tgl_akad');
		$angsuranke1 		= $this->input->post('angsuranke1');
		$tgl_jtempo 		= $this->input->post('tgl_jtempo');
		$pengajuan_melalui	= $this->input->post('pengajuan_melalui');
		$alamat_lokasi_kerja= $this->input->post('alamat_lokasi_kerja');
		$pcode 				= $this->input->post('product_code');
		$product_code 		= ($pcode == '52') ? (($product_code_smile == "") ? $pcode : $product_code_smile) : $pcode;
		$jumlah_angsuran 	= $this->input->post('total_angsuran');
		$saldo_kewajiban 	= $this->input->post('saldo_kewajiban');
		
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}
		
		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		$jumlah_kewajiban 	= $this->input->post('jumlah_kewajiban');
		$saldo_kewajiban_ke_koptel 		= $this->input->post('saldo_kewajiban_ke_koptel');
		
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		$amount 			= $this->input->post('amount');
		$jangka_waktu 		= $this->input->post('jangka_waktu');
		$jenis_margin 		= $this->input->post('jenis_margin');
		$total_margin 		= $this->convert_numeric($this->input->post('jumlah_margin'));
		$angsuran_pokok 	= $this->convert_numeric($this->input->post('angsuran_pokok'));
		$angsuran_margin 	= $this->convert_numeric($this->input->post('angsuran_margin'));
		
		$counter_angsuran	= $this->input->post('counter');
		$saldo_oustanding 	= $this->input->post('saldo_oustanding');
		$ttl_angsuran 		= $this->input->post('total_angsuran');

		for ( $i = 0 ; $i < count($nik) ; $i++ ){
			if (trim($nik[$i])!=""){
				
				$sql = "SELECT account_financing_reg_id FROM mfi_account_financing_reg WHERE cif_no='$nik[$i]' AND amount='$amount[$i]' AND status='1' AND tanggal_pengajuan='$tanggalpengajuan[$i]' AND product_code='$product_code[$i]'";
				$res = $this->db->query($sql);
				if($res->num_rows()){
					$account_financing_reg_id = $res->row()->account_financing_reg_id;
				}

				if (!empty($account_financing_reg_id)) {

					$data_reg = $this->model_nasabah->select_financing_reg_by_id($account_financing_reg_id);
					$asaving = $this->model_nasabah->get_account_saving_by_cif($nik[$i]);

					$registration_no		= $data_reg['registration_no'];
					$account_saving_no		= (count($asaving)==0) ? "0" : $asaving['account_saving_no'];
					$jumlah_margin			= $total_margin[$i];
					$tglakad				= $tgl_akad[$i];
					// $angsuranke_1			= $angsuranke1[$i];
					$angsuranke_1			= date("Y-m-d",strtotime($angsuranke1[$i]));
					$tgljtempo				= $tgl_jtempo[$i];
					$val_akad 	 			= "MBA"; //diset akad nya MURABAHAH
					$nisbah 	 			= '';
					
					$tanggal_akad = $tglakad;
					$tanggal_mulai_angsur = $angsuranke_1;
					$tanggal_jtempo = $tgljtempo;

					//** Generate akad_no by product_code and year
					$counter_year 	= date('Y');
				    $counter 		= $this->model_nasabah->get_counter_akad($product_code[$i],$counter_year,true);
				    $new_counter 	= $counter+1;
				    $akad_no  = date('y').str_pad($new_counter, 5, '0',STR_PAD_LEFT);
					
					$jumlahangsuran 		= !empty($jumlah_angsuran[$i]) ? $this->convert_numeric($jumlah_angsuran[$i]) : 0;
					$lunasi_ke_kopegtel 	= !empty($lunasi_kopegtel[$i]) ? $lunasi_kopegtel[$i] : 0;
					$lunasikopegtel 		= ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
					$saldo_kewajiban 		= !empty($saldo_kewajiban[$i]) ? $this->convert_numeric($saldo_kewajiban[$i]) : 0;
					if($jumlahangsuran==false){$jumlahangsuran=0;}
					if($saldo_kewajiban==false){$saldo_kewajiban=0;}

					$jumlahkewajiban 			= !empty($jumlah_kewajiban[$i]) ? $this->convert_numeric($jumlah_kewajiban[$i]) : 0;
					$lunasi_ke_koptel 			= 0;
					$lunasi_ke_koptel 			= ($lunasi_ke_koptel==false) ? '0' : '1' ;
					$saldo_kewajiban_ke_koptel 	= !empty($saldo_kewajiban_ke_koptel[$i]) ? $saldo_kewajiban_ke_koptel[$i] : 0;
					if($jumlahkewajiban==false){$jumlahkewajiban=0;}
					if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

					/*
					** insert into mfi_account_financing
					*/
					$datas=$this->model_transaction->get_seq_account_financing_no($data_reg['product_code'],$data_reg['cif_no']);
					$jumlah=(int)$datas['jumlah'];
					if(count($datas)>0){
						$newseq=$jumlah+1;
						if($jumlah<10){
							$newseq='0'.$newseq;
						}
					}else{
						$newseq='01';
					}

					$account_financing_no = $data_reg['cif_no'].$data_reg['product_code'].$newseq;

					/*
					insert schedulle financing
					*/
					$BYR_SHRSNY = $this->get_month_diff(strtotime($tglakad), strtotime(date('2017-12-31')));
					$data_sched = array(
									"account_financing_no" => $account_financing_no
									,"nik" 			=> $data_reg['cif_no']
									,"counter" 		=> $counter_angsuran[$i]
									,"amount" 		=> $amount[$i]
									,"jangkawaktu" 	=> $jangka_waktu[$i]
									,"product_code"	=> $product_code[$i]
									,"angsuranke1"	=> $angsuranke_1
									,"ttl_angsuran" => $ttl_angsuran[$i]
									,"total_margin" => $total_margin[$i]
									,"BYR_SHRSNY"   => $BYR_SHRSNY
									,"saldo_oustanding" => $saldo_oustanding[$i]
								  );

					$dataz = '';
					
					if($jenis_margin[$i]=='2'){

						$flag_jadwal_angsuran = 0;
						// $dataz = $this->generate_margin_efektif($data_sched);

					}elseif($jenis_margin[$i]=='3'){

						$flag_jadwal_angsuran = 0;
						$dataz = $this->generate_margin_anuitas($data_sched);
						$angsuran = explode("|", $dataz);
					
					}else{
						$flag_jadwal_angsuran = 1;
					}

					// print_r($dataz);
					// exit;

					/*
					** UPDATE DATA REKENING
					*/
					$data_update_rekening = array(
												 'nama_bank'			=> $data_reg['nama_bank']
												,'no_rekening'			=> $data_reg['no_rekening']
												,'atasnama_rekening'	=> $data_reg['atasnama_rekening']
												,'bank_cabang' 			=> $data_reg['bank_cabang']
												,'alamat_lokasi_kerja' 	=> $alamat_lokasi_kerja[$i]
											);
					$param_update_cif = array('cif_no'=>$data_reg['cif_no']);

					$data_update_financing_reg = array(
							 'pengajuan_melalui'		=>$pengajuan_melalui[$i]
							,'kopegtel_code'			=>0
							,'nama_bank'				=>$data_reg['nama_bank']
							,'no_rekening'				=>$data_reg['no_rekening']
							,'atasnama_rekening'		=>$data_reg['atasnama_rekening']
							,'bank_cabang'				=>$data_reg['bank_cabang']
							,'lunasi_ke_kopegtel'		=>$lunasikopegtel
							,'saldo_kewajiban'			=>$this->convert_numeric($saldo_kewajiban)
							,'angsuran_pokok'			=>(!empty($dataz)) ? $this->convert_numeric($angsuran[0]) : $angsuran_pokok[$i]
							,'angsuran_margin'			=>(!empty($dataz)) ? $this->convert_numeric($angsuran[1]) : $angsuran_margin[$i]
							,'jumlah_angsuran'			=>$this->convert_numeric($jumlahangsuran)
							,'jumlah_kewajiban'			=>$this->convert_numeric($jumlahkewajiban)
							,'pelunasan_ke_kopeg_mana' 	=>0
							,'biaya_administrasi' 		=>0
							,'biaya_notaris' 			=>0
							,'premi_asuransi' 			=>0
							,'tanggal_pengajuan'		=>$tanggalpengajuan[$i]
						);
					$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
					/*
					** END UPDATE DATA REKENING
					*/

					// saldo margin flat
					$sisawaktu = $jangka_waktu[$i] - $counter_angsuran[$i];
					$saldo_margin_flat = ($sisawaktu == 0) ? '0' : $angsuran_margin[$i] * $sisawaktu;
					
					$data_insert_to_financing = array(
							 'product_code'				=>$data_reg['product_code']
							,'branch_code'				=>$data_reg['branch_code']
							,'cif_no' 					=>$data_reg['cif_no']
							,'account_financing_no' 	=>$account_financing_no
							,'akad_code' 				=>$val_akad
							,'pokok'		 			=>$this->convert_numeric($data_reg['amount'])
							,'margin' 					=>$this->convert_numeric($jumlah_margin)
							,'saldo_pokok' 				=>$saldo_oustanding[$i]
							// ,'saldo_pokok' 				=>$this->convert_numeric($data_reg['amount'])
							// ,'saldo_margin'				=>$this->convert_numeric($jumlah_margin)
							,'saldo_margin'				=>(!empty($angsuran[2])) ? $angsuran[2] : $saldo_margin_flat
							,'angsuran_pokok'			=>(!empty($dataz)) ? $this->convert_numeric($angsuran[0]) : $angsuran_pokok[$i]
							,'angsuran_margin'			=>(!empty($dataz)) ? $this->convert_numeric($angsuran[1]) : $angsuran_margin[$i]
							,'periode_jangka_waktu'	 	=>2 //bulanan
							,'jangka_waktu' 			=>$data_reg['jangka_waktu']
							,'cadangan_resiko' 			=>0
							,'biaya_administrasi' 		=>0
							,'biaya_notaris' 			=>0
							,'biaya_asuransi_jiwa' 		=>0
							,'biaya_asuransi_jaminan' 	=>0
							,'dana_kebajikan'			=>0
							,'created_by'				=>'sys'
							,'created_date'				=>date('Y-m-d H:i:s')
							,'approve_by'				=>'sys'
							,'approve_date'				=>date('Y-m-d H:i:s')
							,'program_code'				=>$data_reg['product_code']
							,'flag_jadwal_angsuran'		=>$flag_jadwal_angsuran
							,'peruntukan' 				=>$data_reg['peruntukan']
							,'registration_no'			=>$data_reg['registration_no']
							,'uang_muka'				=>0
							,'flag_dokumen' 			=>1
							,'tanggal_registrasi'		=>$tanggalpengajuan[$i]
							,'flag_wakalah'				=>1
							,'titipan_notaris'			=>0
							,'simpanan_wajib_pinjam'	=>0
							,'account_saving_no'		=>$account_saving_no
							,'tanggal_akad'				=>$tanggal_akad
							,'tanggal_mulai_angsur'		=>$tanggal_mulai_angsur
							,'tanggal_jtempo'			=>$tanggal_jtempo
							,'jtempo_angsuran_last'		=>'2017-12-25'
							,'jtempo_angsuran_next'		=>'2018-01-25'
							,'akad_no'					=>$akad_no
							,'nisbah_bagihasil'			=>(!empty($nisbah)) ? $nisbah : 0
							,'amount_proyeksi_keuntungan'=>0
							,'tanggal_pengajuan'		=>$tanggalpengajuan[$i]
						);
					/*
					** END insert into mfi_account_financing
					*/

					// print_r($data_insert_to_financing);
					// exit;

					$count_financing = $this->model_nasabah->get_count_financing_by_reg($account_financing_reg_id); 
					$this->db->trans_begin(); 
					$this->model_transaction->add_rekening_pembiayaan($data_insert_to_financing);

					$this->model_nasabah->update_cif($data_update_rekening,$param_update_cif); 

					$this->model_nasabah->edit_pengajuan_pembiayaan($data_update_financing_reg,$param_update_financing_reg);

					/*
					proses pencairan
					*/

					// get data account financing
					$datafinancing = $this->model_nasabah->get_account_financing_by_account_financing_no($account_financing_no);
					$account_financing_id = $datafinancing['account_financing_id'];
					$status_rekening = $datafinancing['status_rekening'];
					$cif_no = $datafinancing['cif_no'];
					$pokok = $datafinancing['pokok'];
					$margin = $datafinancing['margin'];
					$saldo_pokok = $datafinancing['saldo_pokok'];
					$saldo_margin = $datafinancing['saldo_margin'];

					// banmod options
					$is_banmod = 0;
					$datatermin = array();
					$flag_update='0'; // 0-update seperti biasa, 1-update untuk pencairan termin ke 2,3,4,dst...
					$termin_ke = 1;

					$this->db->trans_begin();

					$data_financing_droping = array();
					$id_droping = uuid(false);
					$droping_by	= $this->session->userdata('user_id');
					$created_by	= $droping_by;
					$created_date = date("Y-m-d H:i:s");
					$tanggal_transfer = $tanggal_akad;
					$data_financing_droping = array(
						'account_financing_droping_id' => $id_droping,
						'account_financing_no' => $account_financing_no,
						'cif_no' => $cif_no,
						'status_droping' => 1, // cair/droping
						'create_by' => $created_by,
						'created_date' => $created_date,
						'droping_by' => $droping_by,
						'droping_date' => $tanggal_akad,
						'status_transfer' => '1',
						'no_spb' => 'sys',
						'tanggal_transfer' => $tanggal_transfer,
						'termin'=>1
				 	);

				 	/* set data pembiayaan */
					$data_financing = array();
					$param_financing = array();
					$data_financing = array(
						'tanggal_akad' => $tanggal_akad,
						'status_rekening' => 1,
						'tanggal_mulai_angsur' => $tanggal_mulai_angsur,
						'jtempo_angsuran_last'		=>'2021-07-25',
						'jtempo_angsuran_next'		=>'2021-08-25',
						'tanggal_jtempo' => $tanggal_jtempo,
						'saldo_pokok' => $saldo_pokok,
						'saldo_margin' => $saldo_margin,
						'counter_angsuran' => $counter_angsuran[$i]
					);
					$param_financing = array('account_financing_id'=>$account_financing_id);

					/* set data balance */
					$data_default_balance = array();
					$param_default_balance = array();
					$data_default_balance = array(
						'account_financing_no' => $account_financing_no,
						'pokok_pembiayaan' => $data_financing['saldo_pokok'],
						'margin_pembiayaan' => $data_financing['saldo_margin']
					);
					$param_default_balance = array('account_financing_no'=>$account_financing_no);

					/* do transaction */
					if ( count($data_financing_droping) > 0 ) $this->model_nasabah->insert_account_financing_droping($data_financing_droping);
					if ( count($data_financing) > 0 ) $this->model_nasabah->update_account_financing($data_financing,$param_financing);
					if ( count($data_default_balance) > 0 ) $this->model_nasabah->update_default_balance($data_default_balance,$param_default_balance);
					/* //do transaction */

					/* set data history transaction */
					$trx_detail = array();
					$trx_account_financing = array();
					$angs_trx_detail = array();
					$angs_trx_account_financing = array();
					$id_history_angsuran = uuid(false);
					$trx_detail_id = uuid(false);
					$angs_trx_detail_id = uuid(false);

					$trx_detail = array(
						 'trx_detail_id' => $trx_detail_id
						,'trx_type' => '3'
						,'trx_account_type'	=> '0'
						,'account_no' => $account_financing_no
						,'flag_debit_credit' => 'D'
						,'amount' => $data_financing['saldo_pokok']+$data_financing['saldo_margin']
						,'trx_date' => $tanggal_akad
						,'created_by' => $this->session->userdata('user_id')
						,'created_date' => date('Y-m-d H:i:s')
						,'account_no_dest' => $account_financing_no
						,'account_type_dest' => '1'
					);
					
					$trx_pembayaran = $jumlahangsuran * $counter_angsuran[$i];
					$trx_account_financing = array(
						'branch_id' => $this->session->userdata('branch_id')
						,'trx_detail_id' => $trx_detail_id
						,'trx_account_financing_id' => $id_droping
						,'account_financing_no' => $account_financing_no
						,'trx_financing_type' => '1'
						,'trx_date' => $tanggal_akad
						,'jto_date' => $angsuranke_1
						,'pokok' => $trx_pembayaran
						,'margin' => '0'
						,'catab' => '0'
						,'trx_status' => '1'
						,'created_date' => date('Y-m-d H:i:s')
						,'created_by' => $this->session->userdata('user_id')
						,'tipe_angsuran' => '1'
						,'angsuran_ke' => '0'
						,'verify_by' => $this->session->userdata('user_id')
						,'verify_date' => date('Y-m-d H:i:s')
						,'description' => 'migration of system'
					);
					
					/* history angsuran pertama */
					$angs_trx_detail = array(
						 'trx_detail_id' => $angs_trx_detail_id
						,'trx_type' => '3'
						,'trx_account_type' => '1'
						,'account_no' => $account_financing_no
						,'flag_debit_credit' => 'D'
						,'amount' => $data_financing['saldo_pokok'] + $data_financing['saldo_margin']
						,'trx_date' => $tanggal_akad
						,'created_by' => $this->session->userdata('user_id')
						,'created_date' => date('Y-m-d H:i:s')
						,'account_no_dest' => NULL
						,'account_type_dest' => NULL
					);

					/*$angs_trx_account_financing = array(
						'branch_id' => $this->session->userdata('branch_id')
						,'trx_account_financing_id' => $id_history_angsuran
						,'trx_detail_id' => $angs_trx_detail_id
						,'account_financing_no' => $account_financing_no
						,'trx_financing_type' => '1'
						,'trx_date' => $tanggal_akad
						,'jto_date' => $angsuranke_1
						,'pokok' => $data_financing['saldo_pokok']
						,'margin' => $data_financing['saldo_margin']
						,'catab' => 0
						,'trx_status' => '1'
						,'angsuran_ke' => '1'
						,'created_date' => date('Y-m-d H:i:s')
						,'created_by' => $this->session->userdata('user_id')
						,'tipe_angsuran' => '1'
						,'verify_by' => $this->session->userdata('user_id')
						,'verify_date' => date('Y-m-d H:i:s')
					);*/

					if($counter_angsuran[$i] > 0){
						if ( count($trx_detail) > 0 ) $this->model_nasabah->insert_mfi_trx_detail($trx_detail);
						if ( count($trx_account_financing) > 0 ) $this->model_nasabah->insert_mfi_trx_account_financing($trx_account_financing);
						if ( count($angs_trx_detail) > 0 ) $this->model_nasabah->insert_mfi_trx_detail($angs_trx_detail);
						// if ( count($angs_trx_account_financing) > 0 ) $this->model_nasabah->insert_mfi_trx_account_financing($angs_trx_account_financing);
						// if ( count($angs_trx_account_financing) > 0 ) $this->model_transaction->fn_proses_jurnal_angsuran_pyd($id_history_angsuran);
					}
				}
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$structure = './assets/';
			$file = $structure."migrasi_regisakad2018.xlsx";
			rename($file, $structure . "migrasi_done".date("ymdhis") . ".xlsx");

			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function pengajuan_komersial()
	{
		$data['container'] = 'migrasi/migrasi_banmod';
		$data['title'] = "Migrasi Banmod";
		$data['boxcolor'] = "light-grey";
		$data['fileupload'] = true;
		$data['filenameupload'] = 'migrasi_banmod2018.xlsx';
		$data['button_save'] = '<button id="save_trx" class="btn purple" style="font-size:13px;">Save Pengajuan</button>';
		$data['savefile'] = 'add_pengajuan_pembiayaan_koptel_banmod';

		$this->load->view('core',$data);
	}

	public function do_upload_pengajuan_banmod()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		set_time_limit(0);

		$url = base_url() . 'assets/migrasi_banmod2018.xlsx';
		$headers = @get_headers($url);
		if(@strpos($headers[0],'200'))
	    {
	        $return = array('success'=>false,'error'=>"Proses Migrasi belum dalam proses, selesaikan terlebih dahulu!");
			echo json_encode($return);
			exit;
	    }

		$userfile = @$_FILES['userfile'];
		$file_name = $userfile['name'];
		$return = array('success'=>true);
		
		$structure = './assets/';

		$config['upload_path'] = $structure;
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '100000';
		$config['file_name'] = "migrasi_banmod2018";

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$return = array('success'=>false,'error'=>$this->upload->display_errors('',''));
		}else{
			$upload_data = $this->upload->data();
			
			$return = array('success'=>true);
		}

		echo json_encode($return);
	}

	function jqGrid_pengajuan_banmod()
	{
		// ** MODIFIED BY ASDIK, 04 OKTOBER 2018 :)
		ini_set('memory_limit', '1G');
		ini_set('upload_max_filesize', '50M');
		ini_set('max_execution_time', '3600');
		set_time_limit(0);

		$this->load->library('phpexcel');

		$structure = './assets/';
		$file_client_name = isset($_REQUEST['file_name'])?$_REQUEST['file_name']:'';
		$file_name = $structure.$file_client_name;

		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;
			foreach($sheetData as $row){

				if($i>0){

					$data = $this->model_transaction->get_kopegtel($row['A']);
                  	$wilayah = isset($data[0]['wilayah']) ? $data[0]['wilayah'] : "";
                  	$nama_kopegtel = isset($data[0]['nama_kopegtel']) ? $data[0]['nama_kopegtel'] : "";
                  	$alamat = isset($data[0]['alamat']) ? $data[0]['alamat'] : "";
                  	$ketua_pengurus = isset($data[0]['ketua_pengurus']) ? $data[0]['ketua_pengurus'] : "";
                  	$jabatan = isset($data[0]['jabatan']) ? $data[0]['jabatan'] : "";
                  	$nik = isset($data[0]['nik']) ? $data[0]['nik'] : "";
                  	$deskripsi_ketua_pengurus = isset($data[0]['deskripsi_ketua_pengurus']) ? $data[0]['deskripsi_ketua_pengurus'] : "";
                  	$email = isset($data[0]['email']) ? $data[0]['email'] : "";
                  	$no_telpon = isset($data[0]['no_telpon']) ? $data[0]['no_telpon'] : "";
                  	$status_chaneling = isset($data[0]['status_chaneling']) ? $data[0]['status_chaneling'] : "";
                  	$nama_bank = isset($data[0]['nama_bank']) ? $data[0]['nama_bank'] : "";
                  	$bank_cabang = isset($data[0]['bank_cabang']) ? $data[0]['bank_cabang'] : "";
                  	$nomor_rekening = isset($data[0]['nomor_rekening']) ? $data[0]['nomor_rekening'] : "";
                  	$atasnama_rekening = isset($data[0]['atasnama_rekening']) ? $data[0]['atasnama_rekening'] : "";
                  	$peruntukan = 11;

                  	$dates1 = $row['H'];
                  	$months1 = $row['I'];
                  	$years1 = $row['J'];

                  	$dates2 = $row['K'];
                  	$months2 = $row['L'];
                  	$years2 = $row['M'];

                  	if($dates1 != "" || $months1 != "" || $years1 != ""){
                  		$ymd = $years1.'-'.str_pad($months1, 2, "0", STR_PAD_LEFT).'-'.str_pad($dates1, 2, "0", STR_PAD_LEFT);
                  		$tgl_pengajuan = $ymd;
                  	}else{
                  		$tgl_pengajuan = "";
                  	}

                  	if($dates2 != "" || $months2 != "" || $years2 != ""){
                  		$ymd = $years2.'-'.str_pad($months2, 2, "0", STR_PAD_LEFT).'-'.str_pad($dates2, 2, "0", STR_PAD_LEFT);
                  		$tgl_cair = $ymd;
                  	}else{
                  		$tgl_cair = "";
                  	}

                  	$responce['rows'][$idx]['cell'] = array(
						 isset($row['A']) ? $row['A'] : ""
						,isset($row['A']) ? $row['A'] : ""
						,$nama_kopegtel
						,$wilayah
						,$alamat
						,$ketua_pengurus
						,$jabatan
						,$nik
						,$deskripsi_ketua_pengurus
						,$email
						,$no_telpon
						,isset($row['B']) ? $row['B'] : $status_chaneling
						,$nama_bank
						,$bank_cabang
						,$nomor_rekening
						,$atasnama_rekening
						,isset($row['C']) ? $row['C'] : $peruntukan
						,isset($row['N']) ? $row['N'] : 0
						,isset($row['D']) ? $row['D'] : ""
						,isset($row['E']) ? $row['E'] : ""
						,$tgl_pengajuan
						,$tgl_cair
					);
				
					$idx++;
				
				}
				
				$i++;

			}

		} else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);
	}

	function add_pengajuan_pembiayaan_koptel_banmod()
	{

		ini_set('memory_limit', '1G');
		set_time_limit(0);

		$v_kopegtel = $this->input->post('kopegtel_code');
		$v_kopegtel_name = $this->input->post('kopegtel_name');
	    $v_wilayah = $this->input->post('wilayah');
	    $v_alamat = $this->input->post('alamat');
	    $v_ketua_pengurus = $this->input->post('pejabat');
	    $v_jabatan = $this->input->post('jabatan');
	    $v_nik = $this->input->post('nik');
	    $v_deskripsi_ketua_pengurus = $this->input->post('deskripsi_ketua_pengurus');
	    $v_email = $this->input->post('email');
	    $v_no_telpon = $this->input->post('no_telpon');
	    $v_status_chaneling = $this->input->post('status_chaneling');
	    $v_nama_bank = $this->input->post('nama_bank');
	    $v_bank_cabang = $this->input->post('bank_cabang');
	    $v_nomor_rekening = $this->input->post('nomor_rekening');
	    $v_atasnama_rekening = $this->input->post('atasnama_rekening');
	    $v_product_code = 58;
	    $v_peruntukan = $this->input->post('peruntukan');
	    $v_rate = $this->input->post('rate');
	    $v_keterangan_peruntukan = "";
	    $v_amount = $this->input->post('amount');
	    $v_jangka_waktu = $this->input->post('jangka_waktu');
	    $v_tanggal_pengajuan = $this->input->post('tanggal_pengajuan');
	    $v_rencana_droping = $this->input->post('rencana_droping');

    	for ( $i = 0 ; $i < count($v_kopegtel) ; $i++ ){
			if (trim($v_kopegtel[$i])!="") {

				/**
			    * cek cif if exist
			    * if not exist then insert a new cif by kopegtel
			    */
				$cek_cif_if_exist = $this->model_transaction->cek_cif_if_exist_by_kopegtel($v_kopegtel[$i]);
		    	$data_cif = array(
		    			 'nama' => $v_kopegtel_name[$i]
						,'panggilan' => $v_kopegtel_name[$i]
						,'tmp_lahir' => '-'
						,'tgl_lahir' => date('Y-m-d')
						,'alamat' => $v_alamat[$i]
						,'no_ktp' => '-'
						,'telpon_rumah' => $v_no_telpon[$i]
						,'cif_type' => 1
						,'koresponden_alamat' => $v_alamat[$i]
						,'status' => 1
						,'nama_pasangan' => '-'
						,'pekerjaan_pasangan' => '-'
						,'nama_bank' => $v_nama_bank[$i]
						,'no_rekening' => $v_nomor_rekening[$i]
						,'atasnama_rekening' => $v_atasnama_rekening[$i]
						,'jenis_kelamin' => 'P'
						,'bank_cabang' => $v_bank_cabang[$i]
		    		);

		    	if ($cek_cif_if_exist==0) {
					$data_cif['cif_no'] = $v_kopegtel[$i];
					$data_cif['created_by'] = $this->session->userdata('user_id');
					$data_cif['branch_code'] = $this->session->userdata('branch_code');
					$data_cif['cif_flag'] = 1;
			    }
				$param_cif = array('cif_no'=>$v_kopegtel[$i]);

				$product = $this->model_transaction->get_product_financing_by_productcode($this->convert_numeric($v_product_code));
              	$rate = $product->rate_margin2;
              	$pembiayaan = $v_amount[$i];
              	$jangkawaktu = $v_jangka_waktu[$i];
              	$rate_margin = $v_rate[$i];
              	$total_margin = ($pembiayaan * $jangkawaktu) * $rate_margin;
              	$total_margin = round($total_margin);

		    	/* collect data for new pengajuan banmod */
				$data_pengajuan = array(
					 'cif_no'				=>$v_kopegtel[$i]
					,'amount'				=>$this->convert_numeric($v_amount[$i])
					,'amount_disetujui'		=>$this->convert_numeric($v_amount[$i])
					,'peruntukan'			=>$v_peruntukan[$i]
					,'status'				=>1
					,'tanggal_pengajuan'	=>$v_tanggal_pengajuan[$i]
					,'rencana_droping'		=>$v_rencana_droping[$i]
					,'product_code'			=>$v_product_code
					,'created_by'			=>$this->session->userdata('user_id')
					,'created_date'			=>date('Y-m-d H:i:s')
					,'jangka_waktu'			=>$v_jangka_waktu[$i]
					,'nama_bank'			=>$v_nama_bank[$i]
					,'no_rekening'			=>$v_nomor_rekening[$i]
					,'atasnama_rekening'	=>$v_atasnama_rekening[$i]
					,'bank_cabang'			=>$v_bank_cabang[$i]
					,'description'			=>$v_keterangan_peruntukan[$i]
					,'status_asuransi'		=>1
					,'status_dokumen_lengkap'=>1
					,'f_proposal'			=>$v_kopegtel[$i].'-(proposal).jpg'
					,'f_kontrak'			=>$v_kopegtel[$i].'-(kontrak)'
					,'f_keuangan'			=>$v_kopegtel[$i].'-(keuangan)'
					,'f_rek_koran'			=>$v_kopegtel[$i].'-(rek_koran)'
					,'f_aki'				=>$v_kopegtel[$i].'-(AKI)'
					,'f_proyeksi'			=>$v_kopegtel[$i].'-(proyeksi)'
					,'f_jaminan'			=>$v_kopegtel[$i].'-(jaminan)'
					,'approve_date'			=>date("Y-m-d H:i:s")
					,'akad_code'			=>'MBA'
					,'total_margin'			=>$total_margin
					,'nisbah'				=>0
				);

				/* collect data for update data kopegtel */
			    $data_kopegtel = array(
						 'wilayah' => $v_wilayah[$i]
						,'alamat' => $v_alamat[$i]
						,'ketua_pengurus' => $v_ketua_pengurus[$i]
						,'jabatan' => $v_jabatan[$i]
						,'nik' => $v_nik[$i]
						,'deskripsi_ketua_pengurus' => $v_deskripsi_ketua_pengurus[$i]
						,'email' => $v_email[$i]
						,'no_telpon' => $v_no_telpon[$i]
						,'status_chaneling' => $v_status_chaneling[$i]
						,'nomor_rekening' => $v_nomor_rekening[$i]
						,'nama_bank' => $v_nama_bank[$i]
						,'bank_cabang' => $v_bank_cabang[$i]
						,'atasnama_rekening' => $v_atasnama_rekening[$i]
			    	);
			   	$param_kopegtel = array('kopegtel_code' => $v_kopegtel[$i]);

			   	$this->db->trans_begin();
				
				if ($cek_cif_if_exist==0) {
					$this->model_nasabah->insert_cif($data_cif);
				} else {
					$this->model_nasabah->update_cif($data_cif,$param_cif);
				}

				$this->model_nasabah->add_pengajuan_pembiayaan($data_pengajuan);
				$this->db->update('mfi_kopegtel',$data_kopegtel,$param_kopegtel);

			}else{
				$this->db->trans_rollback();
				$return = array('success'=>false,'msg'=>"Row ke <b>". $i . "</b> KOPEG CODE kosong!");
				echo json_encode($return);
				exit;
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$structure = './assets/';
			$file = $structure."migrasi_banmod2018.xlsx";
			rename($file, $structure . "migrasi_banmod_regisakad2018" . ".xlsx");

			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	public function saldo_awal()
	{
		$data['container'] = 'migrasi/saldo_awal';
		$data['title'] = "Migrasi - Saldo Masuk";
		$data['boxcolor'] = "blue";
		$data['fileupload'] = false;
		$data['filenameupload'] = 'saldo_awal_2018.xlsx';
		$data['button_save'] = '<button id="save_trx" class="btn purple" style="font-size:13px;">Save Saldo</button>';
		$data['savefile'] = 'proses_saldo_awal';

		$this->load->view('core',$data);
	}

	function jqGrid_saldo_awal()
	{
		$this->load->library('phpexcel');

		$structure = './assets/';
		$file_name = $structure."saldo_awal_2018.xlsx";

		try {
			$objPHPExcel = @PHPExcel_IOFactory::load($file_name);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$file_exists = true;
		} catch (Exception $e) {
			$file_exists = false;
		}

		if ($file_exists) {

			$responce['page'] = 1;
			$responce['total'] = 1;
			$responce['records'] = count($sheetData);

			$i=0;
			$idx=0;
			foreach($sheetData as $row){

				if($i>3){

					if(!empty($row['A'])):

						$responce['rows'][$idx]['no'] = isset($row['A']) ? $row['A'] : '';
						$responce['rows'][$idx]['cell'] = array(
							 $row['A']
							,$row['A']
							,$row['B']
							,isset($row['C'])?str_replace(array(',','.'),'',$row['C']):''
							,isset($row['D'])?str_replace(array(',','.'),'',$row['D']):''
						);

						$idx++;

					endif;

				}

				$i++;
			}
		}else {

			$responce['page'] = 0;
			$responce['total'] = 0;
			$responce['records'] = 0;
		}

		echo json_encode($responce);
	}

	/*
	upload saldo masuk
	*/
	function proses_saldo_awal()
	{

		$noid 	= $this->input->post('noid');		
		$kd_ac 	= $this->input->post('kd_ac');		
		$akun 	= $this->input->post('akun');		
		$debet 	= $this->input->post('debet');		
		$kredit = $this->input->post('kredit');		
		$jurnal_trx_id = uuid(false);

		for ( $i = 0 ; $i < count($noid) ; $i++ ){

			if($debet[$i] > 0 || $kredit[$i] > 0)
			{
				$trx_gl_id 		= uuid(false);
				$created_by 	= $this->session->userdata('user_id');
				$created_date	= date('2017-12-31 H:i:s');
				$description = "migration of system";

				$data = array(
						 'trx_gl_id'		=> $trx_gl_id
						,'trx_date'			=> "2017-12-31"
						,'voucher_date'		=> "2017-12-31"
						,'voucher_ref'		=> "By System"
						,'branch_code'		=> "00000"
						,'jurnal_trx_id'  	=> $jurnal_trx_id
						,'jurnal_trx_type'	=> 0 //0 = jurnal umum, 1 = tabungan, 2 = deposito, 3 = pembiayaan, 4 = asuransi
						,'created_by'		=> $created_by
						,'created_date'		=> $created_date
						,'description'		=> $description
					);
				
				$this->model_transaction->insert_mfi_trx_gl($data);

				// for debit
				if($debet[$i] > 0){
					$flag_debit_credit 	= "D";
					$amount 			= $debet[$i];

					$data_dt = array(
						 'trx_gl_id'			=> $trx_gl_id
						,'account_code'			=> $kd_ac[$i]
						,'flag_debit_credit'	=> $flag_debit_credit
						,'amount'				=> $amount
						,'description'			=> 'Saldo Awal'
						,'trx_sequence'			=> 0
					);

					$this->model_transaction->insert_mfi_trx_gl_detail($data_dt);
				}

				if($kredit[$i] > 0){
					$flag_debit_credit 	= "C";
					$amount 			= $kredit[$i];

					$data_dt = array(
						 'trx_gl_id'			=> $trx_gl_id
						,'account_code'			=> $kd_ac[$i]
						,'flag_debit_credit'	=> $flag_debit_credit
						,'amount'				=> $amount
						,'description'			=> ''
						,'trx_sequence'			=> 0
					);
		
					$this->model_transaction->insert_mfi_trx_gl_detail($data_dt);
				}				
			}
		}

		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			// $structure = './assets/';
			// $file = $structure."migrasi2018.xlsx";
			// rename($file, $structure . "migrasi_regisakad2018" . ".xlsx");

			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	/*
	generate margin efektif
	*/
	public function generate_margin_efektif($data)
	{
		$pokok = $this->convert_numeric($data['amount']);
		$amount = $pokok;
		$jangkawaktu = $data['jangkawaktu'];

		$product = $this->model_transaction->get_product_financing_by_productcode($this->convert_numeric($data['product_code']));
		// $jenis_margin = $product->jenis_margin;
		$rate = $product->rate_margin2;

		$margin_tahun = $rate;
		$margin_bulan = ($margin_tahun/12);
		$angsuranke1 = $data['angsuranke1'];

		$awal_angsur = $angsuranke1;
		$angs_pokok  = 0;
		$sisa_pokok  = $pokok;
		$angs_margin = 0;

	}

	/*
	generate margin anuitas
	*/
	public function generate_margin_anuitas($data)
	{
		$nik = $data['nik'];
		$ttl_angsuran = $data['ttl_angsuran'];
		$product_code = $data['product_code'];
		$angsuranke1 = $data['angsuranke1'];
		$counter = $data['counter'];
		$BYR_SHRSNY = $data['BYR_SHRSNY'];
		$awal_angsur = $angsuranke1;

		$pokok = $this->convert_numeric($data['amount']);
		$jumlah_margin = $this->convert_numeric($data['total_margin']);
		$jangkawaktu = $data['jangkawaktu'];
		$jw_thn = $jangkawaktu/12;

		$product = $this->model_transaction->get_product_financing_by_productcode($this->convert_numeric($data['product_code']));
		$rate = $product->rate_margin2;

		// 54, 56 KPR & KMG
		$ratemargin = $rate; //dalam persen
		$ratemarginperbulan = $ratemargin/100/12;
		if(in_array($row['C'], array(53, 54, 56))){
			$totalangss = round($pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu))))));
			$totalangs = $this->round_up($totalangss, -3);
		}else{
			$totalangs = $ttl_angsuran;
		}

		$saldopokok = $pokok;

		$n = 0;
		$totalmargin = 0;
		$totalpokok = 0;
		$Ttotalangs = 0;
		$saldo_margin_awal = 0;
		$saldo_margin_akhir = 0;
		$angsuran_pokok = 0;
		$angsuran_margin = 0;
		$data_batch_angsuran = array();
		$data_angsuran_bayar = array();

		for ( $i = 1 ; $i <= $jangkawaktu ; $i++ ) {
			/*
			RUMUS IPMT UNTUK PHP, IPMT DISINI MENGACU PADA RUMUS EXCEL
			source by https://github.com/markrogoyski/math-php/blob/master/src/Finance.php
			CREATED BY dickysigma@gmail.com
			*/
			$_rate = $ratemargin/100;
			$angsmargin = round(abs($this->ipmt($_rate/12, $i, ($jw_thn*12), $pokok)));
			/*
			END
			*/

			/*
			create outstanding variable & angsuran pokok
			*/
			$_pokok = $totalangs-$angsmargin;
			$angspokok = ($i==1) ? $_pokok : (($saldopokok<=$_pokok) ? $saldopokok : $_pokok);
			$saldopokok = ($i==1) ? $pokok-$angspokok : $saldopokok-$angspokok;
			/*
			END
			*/

			$tgl_angsur = date("d-m-Y",strtotime($awal_angsur." + ".$n." month"));
			$itgl_angsur = date("Y-m-d",strtotime($awal_angsur." + ".$n." month"));
			$totalmargin += $angsmargin;
			$totalpokok += $angspokok;
			$Ttotalangs += $angsmargin+$angspokok;

			$tgl_angsur = date('Y-m-d',strtotime($itgl_angsur));
			$itgl_angsur = $tgl_angsur;
			
			$account_financing_schedulle_id = uuid(false);			
			$strangsur_last = strtotime($itgl_angsur);
			$strangsur_new = strtotime('2018-01-01');
			$thn_angsur_new = date('Y',strtotime($itgl_angsur));
			$blnthn_angsur_new = date('m-Y',strtotime($itgl_angsur));
			
			if($strangsur_last < $strangsur_new){
				if($jangkawaktu>=$BYR_SHRSNY){
					$status_angsuran = '1';
					$tanggal_bayar 	 = date('Y-m-d');
					$bayar_pokok 	 = $angspokok;
					$bayar_margin  	 = $angsmargin;
				}else{
					if($i>$counter){
						$status_angsuran = 0;
						$tanggal_bayar 	 = NULL;
						$bayar_pokok 	 = 0;
						$bayar_margin  	 = 0;

						$saldo_margin_akhir += $saldo_margin_awal+$angsmargin;
						$angsuran_pokok = $this->convert_numeric($angspokok);
						$angsuran_margin = $this->convert_numeric($angsmargin);
					}else{
						$status_angsuran = '1';
						$tanggal_bayar 	 = date('Y-m-d');
						$bayar_pokok 	 = $angspokok;
						$bayar_margin  	 = $angsmargin;
					}
				}
			}else{
				$status_angsuran = 0;
				$tanggal_bayar 	 = NULL;
				$bayar_pokok 	 = 0;
				$bayar_margin  	 = 0;
			}

			if(strtotime($thn_angsur_new) >= strtotime('2018')){
				$saldo_margin_akhir += $saldo_margin_awal+$angsmargin;
				if($blnthn_angsur_new=='01-2018'){
					$angsuran_pokok = $this->convert_numeric($angspokok);
					$angsuran_margin = $this->convert_numeric($angsmargin);
				}
			}

			$data_batch_angsuran[] = array(
					 'account_financing_schedulle_id' => $account_financing_schedulle_id
					,'account_no_financing' => $data['account_financing_no']
					,'tangga_jtempo' 		=> $itgl_angsur
					,'angsuran_pokok' 		=> $angspokok
					,'angsuran_margin' 		=> $angsmargin
					,'status_angsuran' 		=> $status_angsuran
					,'tanggal_bayar' 		=> $tanggal_bayar
					,'bayar_pokok' 			=> $bayar_pokok
					,'bayar_margin' 		=> $bayar_margin
				);

			$n++;
		}

		// if($nik=='621545'):
			// print_r($data_batch_angsuran);
			// echo $ttl_angsuran.' ** '.$jangkawaktu.'#'.$angsuran_pokok.'|'.$angsuran_margin.'|'.$saldo_margin_akhir;
			// exit;
		// endif;

		$this->model_nasabah->insert_batch_schedulle($data_batch_angsuran);

		return $angsuran_pokok.'|'.$angsuran_margin.'|'.$saldo_margin_akhir;
	}

	/*
	approval pengajuan
	*/
	public function act_approve_pengajuan_pembiayaan($data)
	{
		$account_financing_reg_id = $data['account_financing_reg_id'];
		$account_saving_no_flag	= 'n';
		$nik = $data['nik'];
		$nama_bank = $data['nama_bank'];
		$no_rekening = $data['no_rekening'];
		$atasnama_rekening = $data['atasnama_rekening'];
		$bank_cabang = $data['bank_cabang'];

		$provisi_pembiayaan	= $this->convert_numeric(0);
		$biaya_administrasi	= $this->convert_numeric(0);
		$biaya_notaris	= $this->convert_numeric(0);
		$biaya_apht	= $this->convert_numeric(0);

		/*
		**UPDATE DATA PENGAJUAN
		*/
		$data_financing_reg = array(
									 'status'=>"1"
									 ,'approve_date'=>date("Y-m-d H:i:s")
									 ,'nama_bank'=>$nama_bank
									 ,'no_rekening'=>$no_rekening
									 ,'atasnama_rekening'=>$atasnama_rekening
									 ,'bank_cabang'=>$bank_cabang
									 ,'provisi_pembiayaan'=>$provisi_pembiayaan
									 ,'biaya_administrasi'=>$biaya_administrasi
									 ,'biaya_notaris'=>$biaya_notaris
									 ,'biaya_apht'=>$biaya_apht
									);
		$param_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);

		$data_update_cif = array(
							'nama_bank'=>$nama_bank
							,'no_rekening'=>$no_rekening
							,'atasnama_rekening'=>$atasnama_rekening
							,'bank_cabang'=>$bank_cabang
							);
		$param_update_cif = array('cif_no'=>$nik);
		/*
		**END UPDATE DATA PENGAJUAN
		*/


		$this->db->trans_begin();
		$this->model_nasabah->edit_pengajuan_pembiayaan($data_financing_reg,$param_financing_reg);
		$this->model_nasabah->update_cif($data_update_cif,$param_update_cif);
	}

	/*
	Angsuran Anuitas
	*/
	function get_total_angsuran_anuitas($pokok, $jangkawaktu, $margin_tahun)
	{
		$pokok = $this->convert_numeric($pokok);
		if ($jangkawaktu==false) {
			$jangkawaktu = 0;
		}
		
		$ratemarginperbulan = $margin_tahun/100/12;
		$totalangss = round($pokok*$ratemarginperbulan*(1/(1-(1/(pow((1+$ratemarginperbulan),$jangkawaktu))))));
		$totalangs = $this->round_up($totalangss, -3);

		$totalmargin = 0;
		$saldopokok = $pokok;
		for ( $i = 1 ; $i <= $jangkawaktu ; $i++ ) {
			$angsmargin = $saldopokok*$ratemarginperbulan;
			$angspokok = $totalangs-$angsmargin;
			$saldopokok = $saldopokok-$angspokok;
			$totalmargin+=$angsmargin;
		}

		$data = array(
					"total_margin" => $totalmargin,
					"total_angsuran" => $totalangs
				);
		return $data;
	}

	function round_up ( $value, $precision )
	{ 
	    $pow = pow ( 10, $precision ); 
	    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	}

	/*
	** Margin Efektif
	*/
	public function get_margin_efektif($pokok, $jangkawaktu, $margin_tahun)
	{
		$margin_bulan = ($margin_tahun/12);

		$angs_pokok  = 0;
		$sisa_pokok  = $pokok;
		$angs_margin = 0;

		$Tangs_pokok = 0;
		$Tsisa_pokok = 0;
		$Tangs_margin = 0;
		$Tangs = 0;

		for ($i=1; $i<=$jangkawaktu; $i++) 
		{			
			// $angs_margin = round($margin_bulan*$sisa_pokok/100,2);
			$angs_margin = ($margin_bulan*$sisa_pokok)/100;
			// $angs_pokok  = round($pokok/$jangkawaktu,2);
			$angs_pokok  = ($pokok/$jangkawaktu);
			// $total_angsuran  = round(($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu),2);
			$total_angsuran  = ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			$Tangs_margin += $margin_bulan*$sisa_pokok/100;
			$Tangs_pokok += $pokok/$jangkawaktu;
			$Tangs += ($margin_bulan*$sisa_pokok/100)+($pokok/$jangkawaktu);
			
			$sisa_pokok  = $sisa_pokok-($pokok/$jangkawaktu);
		}

		return number_format($Tangs_margin,0,',','.');

	}

	function get_premi_asuransi($jangka_waktu,$usia,$manfaat)
	{
		$rate_code = '101';
		$kontrak = ceil($jangka_waktu/12);
		$rate_value = $this->model_nasabah->get_premium_rate($rate_code,$usia,$kontrak);
		$biaya_asuransi = $manfaat*($rate_value/1000);

		return $biaya_asuransi;

	}

	public function fv($rate, $periods, $payment, $present_value, $beginning = false)
    {
        $when = $beginning ? 1 : 0;
        if ($rate == 0) {
            $fv = -($present_value + ($payment * $periods));
            return $this->checkZero($fv);
        }
        $initial  = 1 + ($rate * $when);
        $compound = pow(1 + $rate, $periods);
        $fv       = - (($present_value * $compound) + (($payment * $initial * ($compound - 1)) / $rate));
        return $this->checkZero($fv);
    }

    public function pmt($rate, $periods, $present_value, $future_value = 0, $beginning = false)
    {
        $when = $beginning ? 1 : 0;
        if ($rate == 0) {
            return - ($future_value + $present_value) / $periods;
        }
        return - ($future_value + ($present_value * pow(1 + $rate, $periods)))
            /
            ((1 + $rate*$when) / $rate * (pow(1 + $rate, $periods) - 1));
    }

	public function ipmt($rate, $period, $periods, $present_value, $future_value = 0, $beginning = false)
    {
        if ($period < 1 || $period > $periods) {
            return \NAN;
        }
        if ($rate == 0) {
            return 0;
        }
        if ($beginning && $period == 1) {
            return 0.0;
        }
        $payment = $this->pmt($rate, $periods, $present_value, $future_value, $beginning);
        if ($beginning) {
            $interest = ($this->fv($rate, $period - 2, $payment, $present_value, $beginning) - $payment) * $rate;
        } else {
            $interest = $this->fv($rate, $period - 1, $payment, $present_value, $beginning) * $rate;
        }
        return $this->checkZero($interest);
    }

    public function checkZero($value)
	{
        return abs($value) < $epsilon ? 0.0 : $value;
    }

    public function get_month_diff($start, $end = FALSE)
	{
		$end OR $end = time();
		$start = new DateTime("@$start");
		$end   = new DateTime("@$end");
		$diff  = $start->diff($end);
		return $diff->format('%y') * 12 + $diff->format('%m');
	}

}
