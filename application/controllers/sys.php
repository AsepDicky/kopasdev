<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys extends GMN_Controller {

	/**
	 * Halaman untuk mengatur System Periode
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model("model_sys");
		$this->load->model("model_core");
		$this->load->model("model_product");
		$this->load->model("model_laporan_to_pdf");
	}

	public function index()
	{
		$this->periode();
	}

	/***************************************************************************************/
	//BEGIN PERIODE SYSTEM
	/***************************************************************************************/
	public function periode()
	{
		$datas	= $this->model_sys->get_periode();
		$data['pawal'] = $datas['periode_awal'];
		$data['pakhir'] = $datas['periode_akhir'];
		$data['pid'] = $datas['periode_id'];
		$data['title'] = 'Proses Akhir Bulan';
		$data['container'] = 'sys/periode_system';
		$this->load->view('core',$data);
	}

	public function update_periode()
	{
		$id			= $this->input->post('id');
		$tanggal1	= $this->input->post('tanggal');
		$tanggal2	= $this->input->post('tanggal2');

		$exp1 = explode("/", $tanggal1);
		$awal = $exp1[2].'-'.$exp1[1].'-'.$exp1[0];
		$exp2 = explode("/", $tanggal2);
		$akhir = $exp2[2].'-'.$exp2[1].'-'.$exp2[0];
		

			$data = array(
						  'periode_awal'	=>$awal
						 ,'periode_akhir'	=>$akhir
					);

		 	$param = array('periode_id' => $id );

		$this->db->trans_begin();
		$this->model_sys->update_periode($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}		

		echo json_encode($return);
	}
	/***************************************************************************************/
	//BEGIN PERIODE SYSTEM
	/***************************************************************************************/


	/**
	* MODUL : BAGIHASIL/BONUS TABUNGAN
	* @author : sayyid nurkilah
	*/
	function bagihasil_tabungan()
	{
		$data['title'] = 'Bagi Hasil Tabungan';
		$data['container'] = 'sys/bagihasil_tabungan';
		$data['product'] = $this->model_product->get_product_saving();
		$this->load->view('core',$data);
	}
	function do_bagihasil_tabungan()
	{
		$product_code=$this->input->post('product_code');
		$tanggal=$this->datepicker_convert(true,$this->input->post('tanggal'),'/');
		$rate=$this->input->post('rate');

		/*transaction database*/
		$this->db->trans_begin();
		$this->model_sys->do_bagihasil_tabungan($product_code,$tanggal,$rate);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('success',true);
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('failed',true);
		}
		redirect('sys/bagihasil_tabungan');
	}

	/**
	* MODUL : BAGIHASIL/BONUS TABUNGAN
	* @author : sayyid nurkilah
	*/
	function debet_adm()
	{
		$data['title'] = 'Debet Administrasi';
		$data['container'] = 'sys/debet_adm';
		$this->load->view('core',$data);
	}
	function do_debet_adm()
	{
		$tanggal=$this->datepicker_convert(true,$this->input->post('tanggal'),'/');

		/*transaction database*/
		$this->db->trans_begin();
		$this->model_sys->do_debet_adm($product_code,$tanggal,$rate);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('success',true);
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('failed',true);
		}
		redirect('sys/debet_adm');
	}

	/***************************************************************************************/
	//BEGIN BAGI HASIL BARU 17-09-2014
	function proses_bagihasil()
	{
		$data['title'] = 'Proses Bagi Hasil';
		$data['container'] = 'sys/proses_bagihasil';
		$data['product'] = $this->model_product->get_product_saving();
		$this->load->view('core',$data);
	}	

	public function get_data_bahas()
	{
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');

		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$pembiayaan_yg_diberikan 	= $this->model_sys->pembiayaan_yg_diberikan($last);
		$pendapatan_operasional 	= $this->model_sys->pendapatan_operasional($first,$last);
		$dana_pihak_ke3 			= $this->model_sys->dana_pihak_ke3($last);
		if($dana_pihak_ke3<0)
		{
		 $dana_pihak_ke3=0;
		}

		if ($pendapatan_operasional!=0) {
			$porsi_pendapatan_dp3 = $pendapatan_operasional*($dana_pihak_ke3/$pembiayaan_yg_diberikan);
		} else {
			$porsi_pendapatan_dp3 = 0;
		}

		if ($porsi_pendapatan_dp3>$pendapatan_operasional) {
			$porsi_pendapatan_dp3 = $pendapatan_operasional;
		}
		

		$data['pembiayaan_yg_diberikan']	= number_format($pembiayaan_yg_diberikan, 0, ",", ".");
		$data['pendapatan_operasional']		= number_format($pendapatan_operasional, 0, ",", ".");
		$data['dana_pihak_ke3']				= number_format($dana_pihak_ke3, 0, ",", ".");
		$data['porsi_pendapatan_dp3']		= number_format($porsi_pendapatan_dp3, 0, ",", ".");
		// $data['porsi_pendapatan_dp3']		= $porsi_pendapatan_dp3;
		
		echo json_encode($data);
	}

	public function generate_product_deposito()
	{
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');
		$dana_pihak_ke3			= str_replace(",", '.', str_replace(".", '', $this->input->post('dana_pihak_ke3')));
		$porsi_pendapatan_dp3	= str_replace(",", '.', str_replace(".", '', $this->input->post('porsi_pendapatan_dp3')));

		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$data 	= $this->model_sys->generate_product_deposito($last);
		// Rate = (saldo/dana_pihak_ke3*porsi_pendapatan_d3*nisbah)/saldo*100
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{ 
			
			if ($data[$i]['saldo']==0 || $porsi_pendapatan_dp3==0 || $dana_pihak_ke3==0) {
				$rate = 0;
			} else {
				$rate = ($data[$i]['saldo']/$dana_pihak_ke3*$porsi_pendapatan_dp3*$data[$i]['nisbah']/100)/$data[$i]['saldo']*100;
			}
			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$html .='<tr>
					  <input type="hidden" name="deposit_product_code[]" value="'.$data[$i]['product_code'].'">
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                        <input name="deposit_saldo[]" readonly="" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_nisbah[]" readonly="" value="'.$data[$i]['nisbah'].'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_rate[]" readonly="" value="'.round($rate, 2).'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;"> 
                      </td>
                    </tr>';
		}
		
		echo $html;
	}
	public function generate_product_mudharabah()
	{
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');
		$dana_pihak_ke3			= str_replace(",", '.', str_replace(".", '', $this->input->post('dana_pihak_ke3')));
		$porsi_pendapatan_dp3	= str_replace(",", '.', str_replace(".", '', $this->input->post('porsi_pendapatan_dp3')));

		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$data 	= $this->model_sys->generate_product_mudharabah($last);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{
			
			if ($data[$i]['saldo']==0 || $dana_pihak_ke3==0 || $dana_pihak_ke3==0) {
				$rate = 0;
			} else {
				// $rate = $data[$i]['saldo'].' - '.$dana_pihak_ke3.' - '.$porsi_pendapatan_dp3.' - '.$data[$i]['nisbah'].' - '.$data[$i]['saldo'].' - 100';
				$rate = ($data[$i]['saldo']/$dana_pihak_ke3*$porsi_pendapatan_dp3*$data[$i]['nisbah']/100)/$data[$i]['saldo']*100;
			} 

			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$saldo_bahas = ($saldo==0 || round($rate, 2)==0) ? 0 : $saldo*(round($rate, 2)/100) ;
			
                  $html .= '
                          <tr>
						  	  <input type="hidden" name="mudharabah_product_code[]" value="'.$data[$i]['product_code'].'">
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                            <input name="mudharabah_saldo[]" readonly="" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_nisbah[]" readonly="" value="'.(($data[$i]['nisbah']=="")?0:$data[$i]['nisbah']).'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:80%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_rate[]" readonly="" value="'.number_format(round($rate, 2), 2, ".", ",").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:80%;"> 
	                          </td>	                          
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                            <input name="mudharabah_jumlah_bahas[]" readonly="" value="'.number_format($saldo_bahas, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
                          </tr>';
		}
		
		echo $html;
	}
	public function generate_product_wadiah()
	{
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');

		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$data 	= $this->model_sys->generate_product_wadiah($last);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) { 

			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$html .= '     <tr id="tr_wadiah'.$i.'">
                          <input type="hidden" id="jumlah_product_wadiah" value="'.count($data).'">
                          <input type="hidden" name="wadiah_product_code[]" value="'.$data[$i]['product_code'].'">
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input id="wadiah_product_name" name="wadiah_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input readonly="" id="wadiah_saldo" name="wadiah_saldo[]" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input id="wadiah_rate" name="wadiah_rate[]" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;" maxlength="8" value="0.00"> 
                          <span id="td_span_wadiah_rate" style="display:none;padding-right:5px;">0.00</span>
                          </td> 
                          <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input readonly="" id="wadiah_jumlah_bonus" name="wadiah_jumlah_bonus[]" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;" value="0"> 
                          <span id="td_span_wadiah_jumlah_bonus" style="display:none;padding-right:5px;">0</span>
                          </td>
                          </tr>';
		}
		
		echo $html;
	}

	public function action_proses_bagihasil()
	{
		$proyeksi_bahas_id = $this->uuids(false);
		$periode_bulan = $this->input->post('periode_bulan');
		if ($periode_bulan<10) {
			$periode_bulan = str_replace("0", '', $periode_bulan);
		}
		$periode_tahun = $this->input->post('periode_tahun');

		$cek_periode = $this->model_sys->cek_periode_bahas($periode_bulan,$periode_tahun);
		if($cek_periode==1)
		{
			$return = array('success'=>false,'stat'=>'1','message'=>'Periode ini sudah diproses. Silahkan lihat komposisi bagi hasil');
		}
		else
		{
			$pembiayaan_yg_diberikan 	= $this->input->post('span_1');
			$pendapatan_operasional 	= $this->input->post('span_2');
			$dana_pihak_ke3 			= $this->input->post('span_3');
			$porsi_pendapatan_dp3 		= $this->input->post('span_4');
			
			$deposito_product_code 	= $this->input->post('deposit_product_code');
			$deposito_product_name 	= $this->input->post('deposit_product_name');
			$deposito_product_type 	= 2;
			$deposito_saldo 		= $this->input->post('deposit_saldo');
			$deposito_nisbah 		= $this->input->post('deposit_nisbah');
			$deposito_rate 			= $this->input->post('deposit_rate');
			$deposito_akad 			= 1;
	
			$mudharabah_product_code= $this->input->post('mudharabah_product_code');
			$mudharabah_product_name= $this->input->post('mudharabah_product_name');
			$mudharabah_product_type= 1;
			$mudharabah_saldo 		= $this->input->post('mudharabah_saldo');
			$mudharabah_jumlah_bahas= $this->input->post('mudharabah_jumlah_bahas');
			$mudharabah_nisbah 		= $this->input->post('mudharabah_nisbah');
			$mudharabah_rate 		= $this->input->post('mudharabah_rate');
			$mudharabah_akad 		= 1;
	
			$wadiah_product_code 	= $this->input->post('wadiah_product_code');
			$wadiah_product_name 	= $this->input->post('wadiah_product_name');
			$wadiah_product_type 	= 1; // 1 = Tabungan 2=deposito
			$wadiah_saldo 			= $this->input->post('wadiah_saldo');
			$jumlah_bonus 			= $this->input->post('wadiah_jumlah_bonus');
			$wadiah_rate 			= $this->input->post('wadiah_rate');
			$wadiah_akad 			= 0;
	
			$data_proyeksi_bahas = array(
					 'id' 				=> $proyeksi_bahas_id
					,'bulan' 			=> $periode_bulan
					,'tahun' 			=> $periode_tahun
					,'saldo_pembiayaan' => str_replace(",", ".", str_replace(".", "", $pembiayaan_yg_diberikan))
					,'saldo_dp3' 		=> str_replace(",", ".", str_replace(".", "", $dana_pihak_ke3))
					,'saldo_pendapatan' => str_replace(",", ".", str_replace(".", "", $pendapatan_operasional))
					,'pendapatan_dp3' 	=> str_replace(",", ".", str_replace(".", "", $porsi_pendapatan_dp3))
				);
				
			$data_batch1 = array(); //BATCH1 UNTUK DEPOSITO
			for ( $i = 0 ; $i < count($deposito_product_code) ; $i++ )
			{
				$data_batch1[] = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> $deposito_product_code[$i]
						,'product_name' 	=> $deposito_product_name[$i]
						,'product_type' 	=> 2
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $deposito_saldo[$i]))
						,'nisbah' 			=> $deposito_nisbah[$i]
						,'rate' 			=> $deposito_rate[$i]
						,'akad' 			=> 1
					);
			}
				
			$data_batch2 = array(); //BATCH2 UNTUK TABUNGAN MUDARABAH
			for ( $i = 0 ; $i < count($mudharabah_product_code) ; $i++ )
			{
				$data_batch2[] = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> $mudharabah_product_code[$i]
						,'product_name' 	=> $mudharabah_product_name[$i]
						,'product_type' 	=> 1
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $mudharabah_saldo[$i]))
						,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $mudharabah_jumlah_bahas[$i]))
						,'nisbah' 			=> $mudharabah_nisbah[$i]
						,'rate' 			=> $mudharabah_rate[$i]
						,'akad' 			=> 1
					);
			}
				
			$data_batch3 = array(); //BATCH2 UNTUK TABUNGAN WADIAH
			for ( $i = 0 ; $i < count($wadiah_product_code) ; $i++ )
			{
				$data_batch3[] = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> $wadiah_product_code[$i]
						,'product_name' 	=> $wadiah_product_name[$i]
						,'product_type' 	=> 1
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $wadiah_saldo[$i]))
						,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $jumlah_bonus[$i]))
						,'rate' 			=> $wadiah_rate[$i]
						,'akad' 			=> 0
					);
			}
			
			$this->db->trans_begin();
			$this->model_sys->insert_into_mfi_proyeksi_bahas($data_proyeksi_bahas);
			if ( $this->db->trans_status() === true )
			{
				$this->db->trans_commit();
	
				if ( count($data_batch1) > 0 || count($data_batch2)>0 || count($data_batch3)>0) {
					$this->db->trans_begin();
					// if(count($data_batch1)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch1);				
					if(count($data_batch2)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch2);
					if(count($data_batch3)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch3);
					if ( $this->db->trans_status() === true )
					{
						$this->db->trans_commit();
						//mulai proses distribusi bagi hasil
							//select semua data di mfi_proyeksi_bahas_detail
							$proyeksi_bahas = $this->model_sys->select_proyeksi_bahas_detail($proyeksi_bahas_id);
							for ($j=0; $j <count($proyeksi_bahas) ; $j++) { //panggil function distribusi bahas
								$this->model_sys->do_bagihasil_tabungan($proyeksi_bahas[$j]['product_code'],date('Y-m-d'),$proyeksi_bahas[$j]['rate']);
							}
						//beres proses distribusi bagi hasil
						$return = array('success'=>true,'message'=>'Success');
					}
					else
					{
						$this->db->trans_rollback();
						$return = array('success'=>false,'message'=>'Failed');
					}
				} else {
					$return = array('success'=>true,'message'=>'Success');
				}
	
			}
			else
			{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed');
			}
		}

		echo json_encode($return);
	}
	public function action_cek_bagihasil()
	{
		$proyeksi_bahas_id = $this->uuids(false);
		$periode_bulan = $this->input->post('periode_bulan');
		if ($periode_bulan<10) {
			$periode_bulan = str_replace("0", '', $periode_bulan);
		}
		$periode_tahun = $this->input->post('periode_tahun');

		$cek_periode = $this->model_sys->cek_periode_bahas($periode_bulan,$periode_tahun);
		if($cek_periode==1)
		{
			$return = array('success'=>false,'stat'=>'1');
		}
		else
		{
			$return = array('success'=>false,'stat'=>'2');
		}

		echo json_encode($return);
	}
	public function uuids($hyphen = true) {

		// The field names refer to RFC 4122 section 4.1.2
		if($hyphen == false){
			return sprintf('%04x%04x%04x%03x4%04x%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
			);
		}else{
			return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
			);
		}
	} 

	public function get_data_proyeksi_bahas()
	{
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');

		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$data_bahas 	= $this->model_sys->get_data_proyeksi_bahas($m,$y);
		

		$data['pembiayaan_yg_diberikan']	= number_format($data_bahas['saldo_pembiayaan'], 0, ",", ".");
		$data['pendapatan_operasional']		= number_format($data_bahas['saldo_pendapatan'], 0, ",", ".");
		$data['dana_pihak_ke3']				= number_format($data_bahas['saldo_dp3'], 0, ",", ".");
		$data['porsi_pendapatan_dp3']		= number_format($data_bahas['pendapatan_dp3'], 0, ",", ".");
		$data['id_proyeksi_bahas']			= $data_bahas['id'];
		
		echo json_encode($data);
	}
	public function generate_product_komposisi()
	{
		$id_proyeksi_bahas	= $this->input->post('id_proyeksi_bahas');

		$data 	= $this->model_sys->generate_product_komposisi($id_proyeksi_bahas);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{
			$jumlah_bonus = ($data[$i]['jumlah_bonus']>0) ? number_format($data[$i]['jumlah_bonus'], 0, ",", ".") : '-' ;
			$nisbah = ($data[$i]['akad']==0) ? '-' : $data[$i]['nisbah'] ;
			$html .= '  <tr>
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="product_name" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input id="saldo"readonly="" value="'.number_format($data[$i]['saldo'], 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td>
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input id="saldo"readonly="" value="'.$nisbah.'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="rate" type="text"readonly="" value="'.round($data[$i]['rate'],2).'" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border-color:#fff" maxlength="8"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="jumlah_bonus"readonly="" type="text" value="'.$jumlah_bonus.'" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;"> 
                          </td>
                        </tr>';
		}
		
		echo $html;
	}
	//END BEGIN BAGI HASIL BARU
	/***************************************************************************************/

	/***************************************************************************************/
	//BEGIN GL BAHAS
	public function account_gl_bahas()
	{
		$data['container'] = 'sys/account_gl_bahas';
		$this->load->view('core',$data);
	}

	public function datatable_sys_account_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$code_group = isset($_GET['code_group'])?$_GET['code_group']:'';
		$aColumns = array('','code_group','code_value','display_text','');
				
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
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}
		
		$sWhere = '';

		$rResult 			= $this->model_sys->datatable_sys_account_setup($sWhere,$sOrder,$sLimit,$code_group); // query get data to view
		$rResultFilterTotal = $this->model_sys->datatable_sys_account_setup($sWhere,'','',$code_group); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_sys->datatable_sys_account_setup('','','',$code_group); // get number of all data
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
			$row[] = '<input type="checkbox" value="'.$aRow['list_code_detail_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_group'];
			$row[] = $aRow['code_value'];
			$row[] = $aRow['display_text'];
			$row[] = '<div align="center"><a class="btn mini purple" href="javascript:;" list_code_detail_id="'.$aRow['list_code_detail_id'].'" id="link-edit">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	public function delete_sys_account_bahas()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_detail_id) ; $i++ )
		{
			$param = array('list_code_detail_id'=>$list_code_detail_id[$i]);
			$this->db->trans_begin();
			$this->model_sys->delete_sys_account_bahas($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	public function proses_input_setup_gl_bahas()
	{
		$code_group 	= $this->input->post('code_group1');
		$code_value 	= $this->input->post('code_value1');
		$display_text 	= $this->input->post('display_text1');

		$data = array
				(
					'code_group'				=> $code_group
					,'code_value'				=> $code_value
					,'display_text'				=> $display_text
				);

		$this->db->trans_begin();
		$this->model_sys->proses_input_setup_gl_bahas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	public function get_gl_account_bahas_by_id()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');
		$data = $this->model_sys->get_gl_account_bahas_by_id($list_code_detail_id);

		echo json_encode($data);
	}
	public function proses_edit_setup_gl_bahas()
	{
		$list_code_detail_id 	= $this->input->post('list_code_detail_id');
		$code_group 	= $this->input->post('code_group2');
		$code_value 	= $this->input->post('code_value2');
		$display_text 	= $this->input->post('display_text2');

		$param = array('list_code_detail_id'=>$list_code_detail_id);
		$data = array
				(
					'code_group'				=> $code_group
					,'code_value'				=> $code_value
					,'display_text'				=> $display_text
				);

		$this->db->trans_begin();
		$this->model_sys->proses_edit_setup_gl_bahas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	//END BEGIN GL BAHAS
	/***************************************************************************************/

	/*
	| BACKUP DATABASE
	*/
	function backup_database()
	{
		$data['title']='Backup Database';
		$data['container']='sys/backup_database';
		$this->load->view('core',$data);
	}
	function process_backup_database()
	{
		$db_name=$this->input->post('db_name');
		$db_name=$db_name.'_'.date('Ymd_His').'.sql';
		exec('pg_dump -U postgres mfitam_20141027_1044 > assets/backup_db/'.$db_name,$op,$retval);
		// var_dump($op);
		// var_dump($retval);
		// print shell_exec('C:\Program Files (x86)\PostgreSQL\9.2\bin\pg_dump.exe -U postgres mfitam_20141027_1044 > '.$db_name);
		// $cmd = escapeshellarg('pg_dump -U postgres mfitam_20141027_1044 > '.$db_name);
		// exec();
		// print_r($out);
		redirect('sys/backup_database');
	}

	/*
	| CLOSING TRANSACTION (TUTUP BUKU TRANSAKSI)
	| created_by : sayyid
	| created_date : 2014-10-28 09:38
	*/
	function closing_transaction()
	{
		$data['title'] = 'Tutup Buku Transaksi';
		$data['container'] = 'sys/closing_transaction';

		$data['num_trx_financing_verified_not_yet']=$this->model_sys->num_trx_financing_verified_not_yet();
		$num_tanggal_financing = $this->model_sys->num_tanggal_financing_not_yet();
		$z = 0;
		$date_list = '';
		foreach($num_tanggal_financing as $ntf){
			if ($z>0) $date_list .= ', ';
			$date_list .= date('d M',strtotime($ntf['trx_date']));
			$i++;
		}
		$data['tanggal_financing'] = $date_list;
		
		$data['num_trx_saving_verified_not_yet']=$this->model_sys->num_trx_saving_verified_not_yet();
		$num_tanggal_saving = $this->model_sys->num_tanggal_saving_not_yet();
		$i = 0;
		$list_date = '';
		foreach($num_tanggal_saving as $nts){
			if ($i>0) $list_date .= ', ';
			$list_date .= date('d M',strtotime($nts['trx_date']));
			$i++;
		}
		$data['tanggal_saving'] = $list_date;

		$this->load->view('core',$data);
	}
	function closing_transaction_process()
	{
		$periode=$this->input->post('periode');
		$periode=$this->datepicker_convert(true,$periode,'/');
		$pexp=explode('-',$periode);
		$from_date=$pexp[0].'-'.$pexp[1].'-01';
		$thru_date=$periode;
		$branch_code=$this->session->userdata('branch_code');

		/*date next*/
		$next_from_date=date('Y-m-d',strtotime($from_date.' +1 month'));
		$next_thru_date=date('Y-m-t',strtotime($from_date.' +1 month'));
		

		/*set closing id*/
		$closing_id=uuid(false);

		/*
		| SIMPAN DATA TABUNGAN & SALDO RATA RATA
		*/
		$closing_tabungan=array();

		$saving=$this->model_sys->get_saving_data_for_closing($branch_code);
		foreach($saving as $tabungan){
			$saldo_rata_rata=$this->model_sys->get_average_saldo_tabungan($tabungan['account_saving_no'],$from_date,$thru_date);
			$closing_tabungan[]=array(
					'closing_id'=>$closing_id
					,'closing_from_date'=>$from_date
					,'closing_thru_date'=>$thru_date
					,'account_saving_no'=>$tabungan['account_saving_no']
					,'saldo_riil'=>$tabungan['saldo_riil']
					,'saldo_memo'=>$tabungan['saldo_memo']
					,'saldo_rata_rata'=>$saldo_rata_rata
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		/*
		| SIMPAN DATA LEDGER & SALDO RATA-RATA
		*/
		$closing_ledger=array();

		$ledger=$this->model_sys->get_ledger_data_for_closing($branch_code);
		foreach($ledger as $account){
			$saldo_rata_rata=$this->model_sys->get_average_saldo_ledger($account['account_code'],$from_date,$thru_date);
			$closing_ledger[]=array(
					'closing_id'=>$closing_id
					,'closing_from_date'=>$from_date
					,'closing_thru_date'=>$thru_date
					,'account_code'=>$account['account_code']
					,'saldo_rata_rata'=>$saldo_rata_rata
					,'created_stamp'=>date('Y-m-d H:i:s')
					,'created_by'=>$this->session->userdata('user_id')
				);
		}
		/*
		| SIMPAN DATA KOLEKTIBILITAS & SALDO OUTSTANDING
		*/
		$closing_kolektibilitas=array();

		$branch=$this->model_sys->get_branch_by_branch_class(3);
		foreach($branch as $capem){
			/* cek & delete exists par */
			$cek_par = $this->model_sys->cek_par($thru_date,$capem['branch_code']);
			if($cek_par>0){
				$this->db->trans_begin();
				$this->model_sys->delete_par($thru_date,$capem['branch_code']);
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
				}else{
					$this->db->trans_rollback();
				}
			}

			$data = $this->model_laporan_to_pdf->get_laporan_par($thru_date,$capem['branch_code']);

			for($i=0;$i<count($data);$i++)
			{
				$closing_kolektibilitas[] = array(
						'branch_code' => $capem['branch_code']
						,'tanggal_hitung' => $thru_date
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
		}
		/*
		| UPDATE PERIODE SYSTEM TO NEXT
		*/
		$data_next_periode = array(
				'periode_awal'=>$next_from_date
				,'periode_akhir'=>$next_thru_date
			);
		$param_next_periode = array('periode_id'=>'1');

		$first_date_at_year = date('Y',strtotime($thru_date)).'-01-01'; // will get 2014-01-01
		$last_date_at_year = date('Y',strtotime($thru_date)).'-12-'.date('t',strtotime($thru_date)); // will get 2014-12-31
		$month_of_date = date('m',strtotime($thru_date));

		/*
		| GET GL SHU TAHUN LALU
		*/
		$data_gl_shu_tahun_lalu = $this->model_sys->get_gl_list_code_detail('gl_shu_tahun_lalu');
		$gl_shu_tahun_lalu = $data_gl_shu_tahun_lalu['code_value'];


		/*
		| EXECUTE TRANSACTION
		*/
		$this->db->trans_begin();

		/*simpan data tabungan*/
		if(count($closing_tabungan)>0) $this->model_sys->insert_closing_saving_data($closing_tabungan);
		/*simpan data ledger*/
		if(count($closing_ledger)>0) $this->model_sys->insert_closing_ledger_data($closing_ledger);
		/*simpan kolektibilitas*/
		if(count($closing_kolektibilitas)>0) $this->model_sys->insert_closing_kolektibilitas_data($closing_kolektibilitas);
		/*update periode system*/
		$this->model_sys->update_periode($data_next_periode,$param_next_periode);

		// run jurnal funtion last_year
		if($month_of_date=='12') { // jika bulan desember
			$sql = "select fn_proses_jurnal_akhir_tahun(?,?,?,?)";
			$query = $this->db->query($sql,array($first_date_at_year,$last_date_at_year,'00000',$gl_shu_tahun_lalu));
		}
		
		/*cek transaction database*/
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('success',true);
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('failed',true);
		}

		/*redirect to previous page*/
		redirect('sys/closing_transaction');
	}
}