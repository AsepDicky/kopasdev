<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservices extends GMN_Controller {

	private $_salt = 'microfinance';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_webservice');
	}

	public function toXml($data, $rootNodeName = 'data', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
		
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}
		
		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = "no". (string) $key;
			}
			
			// replace anything not alpha numeric
			// $key = preg_replace('/[^a-z]/i', '', $key);
			
			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				$this->toXml($value, $rootNodeName, $node);
			}
			else 
			{
				// add single node.
                                $value = htmlentities($value);
				$xml->addChild($key,$value);
			}
			
		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}

	public function authentication()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		// echo $username;
		// die();
		// print_r($_REQUEST);
		// die();
		$auth = $this->model_webservice->authentication($username,$password);
		$kontrol_periode = $this->model_webservice->get_trx_kontrol_periode_active();
		// print_r($auth);
		// die();
		if (count($auth)>0) {
			$role_id = $auth['role_id'];
			$user_id = $auth['user_id'];
			// echo $role_id;
			// die();
			switch ($role_id) {
				case '42':
				$userdata = $this->model_webservice->userdata_nasabah($user_id);
				// print_r($userdata);
				// die();
				$userdata['periode_awal'] = $kontrol_periode['periode_awal'];
				$userdata['periode_akhir'] = $kontrol_periode['periode_akhir'];
				$userdata['is_logged_in'] = true;
				$result = array('login'=>'success','userdata'=>$userdata);
				break;
				case '43':
				$userdata = $this->model_webservice->userdata_kopegtel($user_id);
				// print_r($userdata);
				// die();
				$userdata['periode_awal'] = $kontrol_periode['periode_awal'];
				$userdata['periode_akhir'] = $kontrol_periode['periode_akhir'];
				$userdata['is_logged_in'] = true;
				$result = array('login'=>'success','userdata'=>$userdata);
				break;
				default:
				$userdata['is_logged_in'] = false;
				$result = array('login'=>'failed','message'=>'Invalid Username or Password.');
				break;
			}
		} else {
			$result = array('login'=>'failed','message'=>'Invalid Username or Password.');
		}
		echo json_encode($result);
	}

	public function get_mitra_koperasi()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->get_kopegtel($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_statement_tabungan()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->get_statement_tabungan($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function save_pengajuan()
	{
		$cif_id = $this->input->post('cif_id');
		$nik = $this->input->post('nik');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$nama = $this->input->post('nama');
		$jumlah_pembiayaan = $this->input->post('jumlah_pembiayaan');
		$peruntukan = $this->input->post('peruntukan');
		$status = $this->input->post('status');
		$product_code = $this->input->post('product_code');
		$jumlah_kewajiban = $this->input->post('jumlah_kewajiban');
		$jumlah_angsuran = $this->input->post('jumlah_angsuran');
		$jangka_waktu = $this->input->post('jangka_waktu');
		$melalui = $this->input->post('melalui');
		$kopegtel = $this->input->post('kopegtel');
		$tempat_lahir = $this->input->post('tempat_lahir');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$alamat = $this->input->post('alamat');
		$no_ktp = $this->input->post('no_ktp');
		$no_telp_kantor = $this->input->post('no_telp_kantor');
		$no_handphone = $this->input->post('no_handphone');
		$nama_pasangan = $this->input->post('nama_pasangan');
		$pekerjaan_pasangan = $this->input->post('pekerjaan_pasangan');
		// $jumlah_tanggungan = $this->input->post('jumlah_tanggungan');
		// $status_rumah = $this->input->post('status_rumah');
		$nama_bank = $this->input->post('nama_bank');
		$no_rekening = $this->input->post('no_rekening');
		$atasnama_rekening = $this->input->post('atasnama_rekening');
		$total_angsuran = $this->input->post('total_angsuran');
		$bank_cabang = $this->input->post('bank_cabang');
		$lunasi_kopegtel = $this->input->post('lunasi_kopegtel');
		$lunasi_ke_koptel = $this->input->post('lunasi_ke_koptel');
		$keterangan_peruntukan = $this->input->post('keterangan_peruntukan');
		$flag_thp = $this->input->post('flag_thp');
		$status_asuransi = $this->input->post('status_asuransi');
		$uw_policy = $this->input->post('uw_policy');
		$saldo_kewajiban = $this->input->post('saldo_kewajiban');
		$saldo_kewajiban_ke_koptel = $this->input->post('saldo_kewajiban_ke_koptel');
		$angsuran_pokok = $this->input->post('angsuran_pokok');
		$angsuran_margin = $this->input->post('angsuran_margin');
		$jenis_margin = $this->input->post('jenis_margin');
		$total_margin = $this->input->post('total_margin');
		$thp = $this->input->post('thp');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$usia = $this->get_usia($tgl_lahir,date('Y-m-d'));
		$premi_asuransi = $this->get_premi_asuransi($jangka_waktu,$usia,$jumlah_pembiayaan);
		$status_dokumen_lengkap = $this->model_webservice->get_status_dokumen_lengkap_by_product_code($product_code);

		$update_thp = array(
					'thp' => $thp
				);

		$data = array(
				 'cif_no' =>$nik
				,'amount' =>$jumlah_pembiayaan
				,'peruntukan' =>$peruntukan
				,'status' =>$status
				,'tanggal_pengajuan' =>date("Y-m-d")
				,'product_code' =>$product_code
				,'created_by' =>$nik
				,'created_date' =>date("Y-m-d H:i:s")
				,'jumlah_kewajiban' =>$jumlah_kewajiban
				,'jumlah_angsuran' =>$jumlah_angsuran
				,'jangka_waktu' =>$jangka_waktu
				,'pengajuan_melalui' =>$melalui
				,'kopegtel_code' =>$kopegtel
				,'nama_bank' =>$nama_bank
				,'no_rekening' =>$no_rekening
				,'atasnama_rekening' =>$atasnama_rekening
				,'bank_cabang' =>$bank_cabang
				,'lunasi_ke_kopegtel' =>$lunasi_kopegtel
				,'description' =>$keterangan_peruntukan
				,'flag_thp' =>$flag_thp
				,'saldo_kewajiban' =>$saldo_kewajiban
				,'status_asuransi' =>$status_asuransi
				,'uw_policy' =>$uw_policy
				,'premi_asuransi' =>$premi_asuransi
				,'lunasi_ke_koptel' =>$lunasi_ke_koptel
				,'saldo_kewajiban_ke_koptel' =>$saldo_kewajiban_ke_koptel
				,'angsuran_pokok' =>$angsuran_pokok
				,'angsuran_margin' =>$angsuran_margin
				,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
				,'status_dokumen_lengkap'=>$status_dokumen_lengkap
				,'total_margin' =>$total_margin
				);
		
		$data_cif = array(
				 'nama' =>$nama
				,'panggilan' =>''
				,'tmp_lahir' =>$tempat_lahir
				,'tgl_lahir' =>$tgl_lahir
				,'alamat' =>$alamat
				,'no_ktp' =>$no_ktp
				,'telpon_rumah' =>$no_telp_kantor
				,'telpon_seluler' =>$no_handphone
				,'cif_type' =>1
				,'koresponden_alamat' =>$alamat
				,'status' =>1
				,'nama_pasangan' =>$nama_pasangan
				,'pekerjaan_pasangan' =>$pekerjaan_pasangan
				// ,'jumlah_tanggungan' =>$jumlah_tanggungan
				// ,'status_rumah' =>$status_rumah
				,'nama_bank' =>$nama_bank
				,'no_rekening' =>$no_rekening
				,'atasnama_rekening' =>$atasnama_rekening
				,'jenis_kelamin' =>$jenis_kelamin
				,'bank_cabang' =>$bank_cabang
			);

		if($cif_id=='0'){
			$data_cif['cif_no'] = $nik;
			$data_cif['created_by'] = $nik;
			$data_cif['branch_code'] = '00000';
		}

		$param = array('cif_no'=>$nik);
		$param_thp = array('nik'=>$nik);
		$data_thp = array('status'=>2,'active_date'=>date('Y-m-d H:i:s'));

		$sms_to = $no_handphone;
		$sms_message = 'Terimakasih pengajuan pembiayaan an. '.$nama.' telah diterima dan saat ini sedang dalam proses verifikasi';
		
		$this->db->trans_begin();
		$this->model_webservice->save_pengajuan($data);
		$this->model_webservice->update_flag_thp($data_thp,$param_thp);//update semua flag thp 100%
		if($cif_id=='0'){
			$this->model_webservice->insert_cif($data_cif);
		}else{
			$this->model_webservice->update_cif($data_cif,$param);
		}
		$this->model_webservice->update_thp_pegawai($update_thp,$param_thp);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();

			if(strlen($sms_to)>8){
				// $this->action_send_sms($sms_to,$sms_message);
			}

			$result = array('status'=>true);
			// $result = array('status'=>true,'message'=>'Pengajuan berhasil diproses');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function do_approval_pengajuan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$no_handphone = $this->input->post('no_handphone');
		$nama_pegawai = $this->input->post('nama_pegawai');

		$sms_to = $no_handphone;
		$sms_message = 'Terimakasih atas kepercayaan anda menjadi mitra KOPTEL, pengajuan an. '.$nama_pegawai.' telah diverifikasi';
		
		$data = array('status' => '1','approve_date'=>date("Y-m-d H:i:s"));
		$param = array('account_financing_reg_id' => $account_financing_reg_id);
		$this->db->trans_begin();
		$this->model_webservice->do_update_pengajuan($data,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();

			if(strlen($sms_to)>8){
				// $this->action_send_sms($sms_to,$sms_message);
			}

			$result = array('status'=>true,'message'=>'Pengajuan berhasil diverifikasi');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function do_reject_pengajuan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$data = array('status' => '2');
		$param = array('account_financing_reg_id' => $account_financing_reg_id);
		$this->db->trans_begin();
		$this->model_webservice->do_update_pengajuan($data,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$result = array('status'=>true,'message'=>'Pengajuan ditolak !');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function do_view_pengajuan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$get =$this->model_webservice->do_view_pengajuan($account_financing_reg_id);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function check_valid_data_on_pegawai()
	{
		$nik = $this->input->post('nik');
		$tanggal_lahir = $this->input->post('tanggal_lahir');
		$get =$this->model_webservice->check_valid_data_on_pegawai($nik,$tanggal_lahir);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function check_valid_data_on_user()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->check_valid_data_on_user($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function save_register_akun()
	{
		$nik = $this->input->post('nik');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$password = $this->input->post('password');
		$usia_password = $this->input->post('usia_password');
		$expired_password = $this->input->post('expired_password');

		$data_user = array(
					 'username' => $nik
					,'password' => sha1($password.$this->_salt)
					,'status' => '1'
					,'role_id' => '42'
					,'fullname' => $nama_lengkap
					,'created_stamp' => date("Y-m-d H:i:s")
					,'usia_password' => $usia_password
					,'last_update_password' => date("Y-m-d")
					,'expired_password' => $expired_password
					,'repassword' => $password
				);

		$this->db->trans_begin();
		$this->model_webservice->insert_mfi_user($data_user);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$result = array('status'=>true,'message'=>'Pendaftaran berhasil diproses');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function edit_profile()
	{
		$user_id = $this->input->post('user_id');
		$nik = $this->input->post('nik');
		$new_password = $this->input->post('new_password');
		$age_password = $this->input->post('age_password');
		$expired_password = $this->input->post('expired_password');

		$data_user = array(
					 'password' => sha1($new_password.$this->_salt)
					,'usia_password' => $age_password
					,'last_update_password' => date("Y-m-d")
					,'expired_password' => $expired_password
					,'repassword' => $new_password
				);

		$param = array('user_id' => $user_id);

		$this->db->trans_begin();
		$this->model_webservice->update_mfi_user($data_user,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$userdata = $this->model_webservice->userdata_nasabah($nik,$new_password);
			$userdata['is_logged_in'] = true;
			$result = array('status'=>true,'userdata'=>$userdata,'message'=>'Password berhasil diperbaharui. Mohon login kembali dengan password baru anda. Anda akan keluar otomatis dalam beberapa detik');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function detail_statement_tab()
	{
		$account_saving_no = $this->input->post('account_saving_no');
		$tanggal_dari = $this->input->post('tanggal_dari');
		$tanggal_sampai = $this->input->post('tanggal_sampai');
		$get = $this->model_webservice->detail_statement_tab($account_saving_no,$tanggal_dari,$tanggal_sampai);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_statement_pembiayaan()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->get_statement_pembiayaan($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_kartu_pengawasan_angsuran_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$data = $this->model_webservice->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
		// if (count($data)>0) {
		// 	$data['droping_date'] = (isset($data['droping_date'])) ?date("d-m-Y", strtotime($data['droping_date'])) : '-';
		// 	$data['tanggal_jtempo'] = (isset($data['droping_date'])) ?date("d-m-Y", strtotime($data['tanggal_jtempo'])) : '-';
		// }
		echo json_encode($data);
	}

	public function get_row_pembiayaan_by_account_no()
	{
		$account_financing_no = $this->input->post('account_financing_no');
		$cif_no = $this->input->post('cif_no');

		$data = $this->model_webservice->get_row_pembiayaan_by_account_no($account_financing_no);
		
		$html = '';
		$no=1;
		if($data['flag_jadwal_angsuran']==0) //NON REGULER lalu lookup ke tabel mfi_account_financing_schedulle
		{
			$get_jadwal_angsuran = $this->model_webservice->get_jadwal_angsuran($account_financing_no);
			$angsuran_hutang = 0;
			for ($jA=0; $jA < count($get_jadwal_angsuran) ; $jA++) 
			{
				$jumlah_angsur = $get_jadwal_angsuran[$jA]['angsuran_pokok']+$get_jadwal_angsuran[$jA]['angsuran_margin']+$get_jadwal_angsuran[$jA]['angsuran_tabungan'];
				$angsuran_hutang += $jumlah_angsur;
				$saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang);
				$tgl_bayar = (isset($get_jadwal_angsuran[$jA]['tanggal_bayar'])) ? date("d-m-Y", strtotime($get_jadwal_angsuran[$jA]['tanggal_bayar'])) : '' ;
				$html .= '<tr>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.date("d-m-Y", strtotime($get_jadwal_angsuran[$jA]['tangga_jtempo'])).'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$tgl_bayar.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$no.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_hutang,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">-</td>
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
				}else{

					if($data['periode_jangka_waktu']==0){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 day"));
					}else if($data['periode_jangka_waktu']==1){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 7 day"));
					}else if($data['periode_jangka_waktu']==2){
						$tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 month"));
					}else if($data['periode_jangka_waktu']==3){
						$tgl_angsur = $data['tgl_jtempo'];
					}

				}
				$tgl_bayar = '';
				$validasi = '';
				
				/*cif type dihilangkan*/
				$data_trx = $this->model_webservice->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,1,$tgl_angsur);
				$tgl_bayar = (isset($data_trx['trx_date'])==true)?$data_trx['trx_date']:'';
				$validasi = (isset($data_trx['created_by'])==true)?$data_trx['created_by']:'';
				
				$jumlah_angsur = $data['jumlah_angsuran'];
				$angsuran_hutang = $data['angsuran_pokok']+$data['angsuran_margin']+$data['angsuran_catab'];
				$saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang*$no);
				if($data['jangka_waktu']==$no){
	            	$jumlah_angsur = ($data['pokok']+$data['margin'])-($angsuran_hutang*($no-1));
	            	$saldo_hutang=0;
	            }
	            $tgl_bayar = ($tgl_bayar!='') ? date("d-m-Y", strtotime($tgl_bayar)) : '' ;

				$html .= '<tr>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.date("d-m-Y", strtotime($tgl_angsur)).'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$tgl_bayar.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$no.'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">'.number_format($saldo_hutang,0,',','.').'</td>
		                      <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">'.$validasi.'</td>
	                      </tr>';

				$no++;
			}
		}
		echo $html;
	}

	function old_password_check()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$check = $this->model_webservice->old_password_check($username,$password);
		if ($check==false) {
			$return = array('status'=>'false','message'=>'Password Lama Salah');
		} else {
			$return = array('status'=>'true');
		}
		echo json_encode($return);
	}

	function get_product_financing_by_band(){
		$band = $this->input->post('band');
		$get = $this->model_webservice->get_product_financing_by_band($band,'');
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	function get_angsuran_koptel(){
		$nik = $this->input->post('nik');
		$get = $this->model_webservice->get_angsuran_koptel($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	function get_kewajiban_koptel(){
		$nik = $this->input->post('nik');
		$get = $this->model_webservice->get_kewajiban_koptel($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_product_financing()
	{
		$get =$this->model_webservice->get_product_financing_by_band();
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_peruntukan_pembiayaan()
	{
		$get =$this->model_webservice->get_peruntukan_pembiayaan();
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	/*
	| Jqgrid Verifikasi Pengajuan
	| By : Sayyid
	*/
	function jqgrid_verifikasi_pengajuan()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = $this->input->post('sidx');
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$kopegtel_code = $this->input->post('kopegtel_code');
		$tipe_keyword = isset($_REQUEST['tipe_keyword'])?$_REQUEST['tipe_keyword']:'';
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_webservice->jqgrid_verifikasi_pengajuan('','','','',$kopegtel_code,$tipe_keyword,$keyword);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_webservice->jqgrid_verifikasi_pengajuan($sidx,$sord,$limit_rows,$start,$kopegtel_code,$tipe_keyword,$keyword);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			if($row['status']=='0'){
				if ($row['status_asuransi']=='0') {
					$status = "<span style='color:red'>Konfirmasi Koptel</span>";
				} else {
					$status = "Registrasi";
				}
			}else if($row['status']=='1'){
				$status = "Aktivasi";
			}else if($row['status']=='2'){
				$status = "Totak";
			}else if($row['status']=='3'){
				$status = "Batal";
			}else{
				$status = "-";
			}
			$responce['rows'][$i]['account_financing_reg_id']=$row['account_financing_reg_id'];
		    $responce['rows'][$i]['cell']=array(
			     $row['account_financing_reg_id']
			    ,$row['registration_no']
				,$row['nik']
				,$row['nama_pegawai']
				,$row['amount']
				,$row['product_name']
				,$row['peruntukan']
				,$row['tanggal_pengajuan']
				,$status
				,$row['status_asuransi']
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	public function get_data_pengajuan_by_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$get =$this->model_webservice->get_data_pengajuan_by_id($account_financing_reg_id);
		// $result = array('data'=>$get);
		$get['min_margin'] = ($get['amount']*$get['jangka_waktu']*$get['rate_margin1']/1200);
		$get['max_margin'] = ($get['amount']*$get['jangka_waktu']*$get['rate_margin2']/1200);
		if($get['jenis_margin']!='1') //efektif
		{
			$get['min_margin'] = '0';
			$get['max_margin'] = $get['amount'];
		}
		echo json_encode($get);
	}

	public function edit_pengajuan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$bank = $this->input->post('bank');
		$cabang = $this->input->post('cabang');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atas_nama = $this->input->post('atas_nama');
		$nik = $this->input->post('nik');
		$jumlah_pembiayaan = $this->input->post('jumlah_pembiayaan');
		$jangka_waktu = $this->input->post('jangka_waktu');
		$thp = $this->input->post('thp');
		$persen_thp = $this->input->post('persen_thp');
		$jumlah_margin = $this->input->post('jumlah_margin');
		$angsuran_pokok = $this->input->post('angsuran_pokok');
		$angsuran_margin = $this->input->post('angsuran_margin');
		$total_angsuran = $this->input->post('total_angsuran');

		$dataREG = array(
					 'nama_bank' => $bank
					,'no_rekening' => $nomor_rekening
					,'atasnama_rekening' => $atas_nama
					,'bank_cabang' => $cabang
					,'amount' =>$this->convert_numeric($jumlah_pembiayaan)
					,'jangka_waktu' =>$jangka_waktu
					,'angsuran_pokok' =>$this->convert_numeric($angsuran_pokok)
					,'angsuran_margin' =>$this->convert_numeric($angsuran_margin)
				);

		$data = array(
					 'nama_bank' => $bank
					,'no_rekening' => $nomor_rekening
					,'atasnama_rekening' => $atas_nama
					,'bank_cabang' => $cabang
				);

		$update_thp = array('thp' => $this->convert_numeric($thp));
		$param_thp = array('nik'=>$nik);

		$param = array('account_financing_reg_id' => $account_financing_reg_id);
		$param2 = array('cif_no' => $nik);

		$this->db->trans_begin();
		$this->model_webservice->edit_mfi_financing_reg($dataREG,$param);
		$this->model_webservice->edit_mfi_cif($data,$param2);
		$this->model_webservice->update_thp_pegawai($update_thp,$param_thp);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$result = array('status'=>true,'message'=>'Pengajuan berhasil diperbaharui');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function cek_max_jangka_waktu()
	{
		$produk_code = $this->input->post('produk_code');
		$get =$this->model_webservice->cek_max_jangka_waktu($produk_code);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function get_akad_by_peruntukan()
	{
		$code_value = $this->input->post('code_value');
		$get =$this->model_webservice->get_akad_by_peruntukan($code_value);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	function get_underwriting()
	{
		$product_code = $this->input->post('product_code');
		$usia = $this->input->post('usia');
		$manfaat = $this->input->post('manfaat');
		$uw_policy = $this->model_webservice->get_uw_policy($product_code,$usia,$manfaat);
		$ret = array('uw_policy'=>$uw_policy);
		echo json_encode($ret);
	}

	/*
	| Jqgrid Registrasi Akad
	| By : ujangirawan
	*/
	function jqgrid_registrasi_akad()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = $this->input->post('sidx');
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'ASC';
		$kopegtel_code = $this->input->post('kopegtel_code');
		$tipe_keyword = isset($_REQUEST['tipe_keyword'])?$_REQUEST['tipe_keyword']:'';
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:'';

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_webservice->jqgrid_registrasi_akad('','','','',$kopegtel_code,$tipe_keyword,$keyword);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_webservice->jqgrid_registrasi_akad($sidx,$sord,$limit_rows,$start,$kopegtel_code,$tipe_keyword,$keyword);

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			if($row['financing_is_exist']==1){
				$label = "Registrasi";
			}else{
				$label = "Belum Registrasi";
			}
			$nik = $row['cif_no'];
			$responce['rows'][$i]['account_financing_reg_id']=$row['account_financing_reg_id'];
		    $responce['rows'][$i]['cell']=array(
			     $row['account_financing_reg_id']
			    ,$row['registration_no']
				,$nik
				,$row['nama']
				,$row['amount']
				,$row['tanggal_pengajuan']
				,$row['approve_date']
				,$row['product_name']
				,$row['display_peruntukan']
				,$row['financing_is_exist']
				,$label
		    );
		    $i++;
		}

		echo json_encode($responce);
	}
	
	public function get_account_saving_by_cif()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->get_account_saving_by_cif($nik);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	function get_premi_asuransi($jangka_waktu,$usia,$jumlah_pembiayaan)
	{
		$rate_code = '101';
		$kontrak = round($jangka_waktu/12);
		$rate_value = $this->model_webservice->get_premium_rate_result($rate_code,$usia,$kontrak);
		$biaya_asuransi = $jumlah_pembiayaan*($rate_value/1000);

		return $biaya_asuransi;

	}

	public function proses_registrasi_akad_pembiayaan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$bank = $this->input->post('bank');
		$cabang = $this->input->post('cabang');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atas_nama = $this->input->post('atas_nama');
		$account_saving_no = $this->input->post('account_saving_no');
		$jumlah_margin = $this->input->post('jumlah_margin');
		$angsuran_pokok = $this->input->post('angsuran_pokok');
		$angsuran_margin = $this->input->post('angsuran_margin');
		$biaya_administrasi = $this->input->post('biaya_administrasi');
		$biaya_asuransi = $this->input->post('biaya_asuransi');
		$biaya_notaris = $this->input->post('biaya_notaris');
		$tgl_akad = $this->input->post('tanggal_akad');
		$angsuranke1 = $this->input->post('tanggal_mulai_angsur');
		$tgl_jtempo = $this->input->post('tanggal_jtempo');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$melalui = $this->input->post('melalui');
		$kopegtel = $this->input->post('kopegtel');

		$data_reg = $this->model_webservice->select_financing_reg_by_id($account_financing_reg_id);

		$jumlah_angsuran = $this->input->post('jumlah_angsuran');
		$lunasi_ke_kopegtel = $this->input->post('lunasi_ke_kopegtel');
		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		$saldo_kewajiban = $this->input->post('saldo_kewajiban');
		if($jumlah_angsuran==false){$jumlah_angsuran=0;}
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}

		$jumlah_kewajiban = $this->input->post('jumlah_kewajiban');
		$lunasi_ke_koptel = $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel = ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel = $this->input->post('saldo_kewajiban_ke_koptel');
		if($jumlah_kewajiban==false){$jumlah_kewajiban=0;}
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}

		/*
		** UPDATE DATA REKENING
		*/
			$data_update_rekening = array(
										 'nama_bank'=>$bank
										,'no_rekening'=>$nomor_rekening
										,'atasnama_rekening'=>$atas_nama
										,'bank_cabang'=>$cabang
									);
			
			$param_update_cif = array('cif_no'=>$data_reg['cif_no']);

			$data_update_financing_reg = array(
										 'pengajuan_melalui' =>$melalui
										,'kopegtel_code' =>$kopegtel
										,'nama_bank' =>$bank
										,'no_rekening' =>$nomor_rekening
										,'atasnama_rekening' =>$atas_nama
										,'bank_cabang' =>$cabang
										,'lunasi_ke_kopegtel' =>$lunasi_kopegtel
										,'lunasi_ke_koptel' =>$lunasi_ke_koptel
										,'saldo_kewajiban' =>$this->convert_numeric($saldo_kewajiban)
										,'saldo_kewajiban_ke_koptel' =>$this->convert_numeric($saldo_kewajiban_ke_koptel)
										,'angsuran_pokok' =>$this->convert_numeric($angsuran_pokok)
										,'angsuran_margin' =>$this->convert_numeric($angsuran_margin)
										,'jumlah_angsuran' =>$this->convert_numeric($jumlah_angsuran)
										,'jumlah_kewajiban' =>$this->convert_numeric($jumlah_kewajiban)
										,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
									);
			$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);
		/*
		** END UPDATE DATA REKENING
		*/

		/*
		** insert into mfi_account_financing
		*/

		$data=$this->model_webservice->get_seq_account_financing_no($data_reg['product_code'],$data_reg['cif_no']);
		$jumlah=(int)$data['jumlah'];
		if(count($data)>0){
			$newseq=$jumlah+1;
			if($jumlah<10){
				$newseq='0'.$newseq;
			}
		}else{
			$newseq='01';
		}

		$account_financing_no = $data_reg['cif_no'].$data_reg['product_code'].$newseq;

		$flag_jadwal_angsuran = $this->input->post('flag_jadwal_angsuran');
		$itgl_angsur = $this->input->post('tgl_angsur');
		$Bangs_margin = $this->input->post('angs_margin');
		$Bangs_pokok = $this->input->post('angs_pokok');

		$data_batch_angsuran = array();
		if($flag_jadwal_angsuran==0){
			for ($i=0; $i<count($itgl_angsur); $i++)
			{
				$angsuran_pokok = str_replace(',','',$Bangs_pokok[$i]);
				$angsuran_margin = str_replace(',','',$Bangs_margin[$i]);
				$data_batch_angsuran[] = array(
						 'account_financing_schedulle_id' => uuid(false)
						,'account_no_financing' => $account_financing_no
						,'tangga_jtempo' => $itgl_angsur[$i]
						,'angsuran_pokok' => $angsuran_pokok
						,'angsuran_margin' => $angsuran_margin
					);

			}
		}

		$data_insert_to_financing = array(
					 'product_code' => $data_reg['product_code']
					,'branch_code' => $data_reg['branch_code']
					,'cif_no' => $data_reg['cif_no']
					,'account_financing_no' => $account_financing_no
					,'akad_code' => $data_reg['akad_code']
					,'pokok' => $this->convert_numeric($data_reg['amount'])
					,'margin' => $this->convert_numeric($jumlah_margin)
					,'saldo_pokok' => $this->convert_numeric($data_reg['amount'])
					,'saldo_margin' => $this->convert_numeric($jumlah_margin)
					,'angsuran_pokok' => $this->convert_numeric($angsuran_pokok)
					,'angsuran_margin' => $this->convert_numeric($angsuran_margin)
					,'periode_jangka_waktu' => 2 //bulanan
					,'jangka_waktu' => $data_reg['jangka_waktu']
					,'tanggal_pengajuan' => $data_reg['tanggal_pengajuan']
					,'cadangan_resiko' => 0
					,'biaya_administrasi' => $this->convert_numeric($biaya_administrasi)
					,'biaya_notaris' => $this->convert_numeric($biaya_notaris)
					,'biaya_asuransi_jiwa' => $this->convert_numeric($biaya_asuransi)
					,'biaya_asuransi_jaminan' => 0
					,'dana_kebajikan' => 0
					,'created_by' => $this->session->userdata('user_id')
					,'created_date' => date('Y-m-d H:i:s')
					,'program_code' => $data_reg['product_code']
					,'flag_jadwal_angsuran' => 1
					,'peruntukan' => $data_reg['peruntukan']
					,'registration_no' => $data_reg['registration_no']
					,'uang_muka' => 0
					,'tanggal_registrasi' => $data_reg['tanggal_pengajuan']
					,'flag_wakalah' => 1
					,'titipan_notaris' => 0
					,'simpanan_wajib_pinjam' => 0
					,'account_saving_no' => $account_saving_no
					,'tanggal_akad' => $tgl_akad
					,'tanggal_mulai_angsur' => $angsuranke1
					,'tanggal_jtempo' => $tgl_jtempo
					,'jtempo_angsuran_last' =>$tgl_akad
					,'jtempo_angsuran_next' =>$angsuranke1
				);
		/*
		** END insert into mfi_account_financing
		*/

		$this->db->trans_begin();
		$this->model_webservice->add_rekening_pembiayaan($data_insert_to_financing);
		$this->model_webservice->edit_pengajuan_pembiayaan($data_update_rekening,$param_update_financing_reg);
		$this->model_webservice->update_cif($data_update_rekening,$param_update_cif);
		if(count($data_batch_angsuran)>0){
			$this->model_webservice->insert_batch_schedulle($data_batch_angsuran);
		}
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			$result = array('status'=>true,'message'=>'Registrasi Akad Berhasil Diproses');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function get_data_edit_pengajuan_by_id()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$get =$this->model_webservice->get_data_edit_pengajuan_by_id($account_financing_reg_id);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function edit_registrasi_akad_pembiayaan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$account_financing_id = $this->input->post('account_financing_id');
		$bank = $this->input->post('bank');
		$cabang = $this->input->post('cabang');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atas_nama = $this->input->post('atas_nama');
		$jumlah_margin = $this->input->post('jumlah_margin');
		$angsuran_pokok = $this->input->post('angsuran_pokok');
		$angsuran_margin = $this->input->post('angsuran_margin');
		$biaya_adm = $this->input->post('biaya_adm');
		$biaya_asuransi = $this->input->post('biaya_asuransi');
		$biaya_notaris = $this->input->post('biaya_notaris');
		$tgl_akad = $this->input->post('tanggal_akad');
		$angsuranke1 = $this->input->post('tanggal_mulai_angsur');
		$tgl_jtempo = $this->input->post('tanggal_jtempo');
		$pelunasan_ke_kopeg_mana = $this->input->post('pelunasan_ke_kopeg_mana');
		$melalui = $this->input->post('melalui');
		$kopegtel = $this->input->post('kopegtel');

		$jumlah_angsuran = $this->input->post('jumlah_angsuran');
		$lunasi_ke_kopegtel = $this->input->post('lunasi_ke_kopegtel');
		$lunasi_kopegtel = ($lunasi_ke_kopegtel==false) ? '0' : '1' ;
		$saldo_kewajiban = $this->input->post('saldo_kewajiban');
		if($saldo_kewajiban==false){$saldo_kewajiban=0;}
		if($jumlah_angsuran==false){$jumlah_angsuran=0;}

		$jumlah_kewajiban = $this->input->post('jumlah_kewajiban');
		$lunasi_ke_koptel = $this->input->post('lunasi_ke_koptel');
		$lunasi_ke_koptel = ($lunasi_ke_koptel==false) ? '0' : '1' ;
		$saldo_kewajiban_ke_koptel = $this->input->post('saldo_kewajiban_ke_koptel');
		if($saldo_kewajiban_ke_koptel==false){$saldo_kewajiban_ke_koptel=0;}
		if($jumlah_kewajiban==false){$jumlah_kewajiban=0;}

		$data_reg = $this->model_webservice->select_financing_reg_by_id($account_financing_reg_id);

		$data_update_rekening = array(
									 'nama_bank'=>$bank
									,'no_rekening'=>$nomor_rekening
									,'atasnama_rekening'=>$atas_nama
									,'bank_cabang'=>$cabang
								);
		$param_update_cif = array('cif_no'=>$data_reg['cif_no']);

		$data_update_financing_reg = array(
									 'pengajuan_melalui' =>$melalui
									,'kopegtel_code' =>$kopegtel
									,'nama_bank' =>$bank
									,'no_rekening' =>$nomor_rekening
									,'atasnama_rekening' =>$atas_nama
									,'bank_cabang' =>$cabang
									,'lunasi_ke_kopegtel' =>$lunasi_kopegtel
									,'lunasi_ke_koptel' =>$lunasi_ke_koptel
									,'saldo_kewajiban' =>$this->convert_numeric($saldo_kewajiban)
									,'saldo_kewajiban_ke_koptel' =>$this->convert_numeric($saldo_kewajiban_ke_koptel)
									,'angsuran_pokok' =>$this->convert_numeric($angsuran_pokok)
									,'angsuran_margin' =>$this->convert_numeric($angsuran_margin)
									,'jumlah_angsuran' =>$this->convert_numeric($jumlah_angsuran)
									,'jumlah_kewajiban' =>$this->convert_numeric($jumlah_kewajiban)
									,'pelunasan_ke_kopeg_mana' =>$pelunasan_ke_kopeg_mana
								);
		$param_update_financing_reg = array('account_financing_reg_id'=>$account_financing_reg_id);

		$account_financing_no = $this->input->post('account_financing_no');
		$flag_jadwal_angsuran = $this->input->post('flag_jadwal_angsuran');
		$itgl_angsur = $this->input->post('tgl_angsur');
		$Bangs_margin = $this->input->post('angs_margin');
		$Bangs_pokok = $this->input->post('angs_pokok');

		$data_batch_angsuran = array();
		if($flag_jadwal_angsuran==0){
			for ($i=0; $i<count($itgl_angsur); $i++)
			{
				$angsuran_pokok = str_replace(',','',$Bangs_pokok[$i]);
				$angsuran_margin = str_replace(',','',$Bangs_margin[$i]);
				$data_batch_angsuran[] = array(
						 'account_no_financing' => $account_financing_no
						,'tangga_jtempo' => $itgl_angsur[$i]
						,'angsuran_pokok' => $angsuran_pokok
						,'angsuran_margin' => $angsuran_margin
					);

			}
			$param_delete_schedulle = array('account_no_financing'=>$account_financing_no);
		}

		$data_update_to_financing = array(
					 'margin' => $this->convert_numeric($jumlah_margin)
					,'saldo_margin' => $this->convert_numeric($jumlah_margin)
					,'angsuran_pokok' => $this->convert_numeric($angsuran_pokok)
					,'angsuran_margin' => $this->convert_numeric($angsuran_margin)
					,'biaya_administrasi' => $this->convert_numeric($biaya_adm)
					,'biaya_notaris' => $this->convert_numeric($biaya_notaris)
					,'biaya_asuransi_jiwa' => $this->convert_numeric($biaya_asuransi)
					,'tanggal_akad' => $tgl_akad
					,'tanggal_mulai_angsur' => $angsuranke1
					,'tanggal_jtempo' => $tgl_jtempo
				);

		$param = array('account_financing_id' => $account_financing_id);

		$this->db->trans_begin();
		$this->model_webservice->update_to_mfi_financing($data_update_to_financing,$param);
		$this->model_webservice->edit_pengajuan_pembiayaan($data_update_rekening,$param_update_financing_reg);
		$this->model_webservice->update_cif($data_update_rekening,$param_update_cif);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
			if(count($data_batch_angsuran)>0){
				$this->model_webservice->delete_batch_schedulle($param_delete_schedulle);
				$this->model_webservice->insert_batch_schedulle($data_batch_angsuran);
			}
			$result = array('status'=>true,'message'=>'Registrasi Akad Berhasil Diperbarui');
		} else {
			$this->db->trans_rollback();
			$result = array('status'=>false,'message'=>'Failed to Connect into Database, Please Contact Your Administrator!');
		}
		echo json_encode($result);
	}

	public function get_customer_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_customer_by_keyword($keyword,$kopegtel_code);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function get_customer_by_no_pembiayaan()
	{
		$id = $this->input->post('id');
		$get =$this->model_webservice->get_customer_by_no_pembiayaan($id);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function cetak_akad_pembiayaan_data()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$get =$this->model_webservice->cetak_akad_pembiayaan_data($account_financing_id);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function cetak_akad_pembiayaan_get_institution()
	{
		$get =$this->model_webservice->cetak_akad_pembiayaan_get_institution();
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function cetak_akad_pembiayaan_get_kopegtel_by_code()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->cetak_akad_pembiayaan_get_kopegtel_by_code($kopegtel_code);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function get_informasi_dashboard()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_dashboard($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_1()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_1($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_2()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_2($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_3()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_3($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_4()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_4($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_5()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_5($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_6()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_6($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_informasi_pengajuan_by_id_7()
	{
		$kopegtel_code = $this->input->post('kopegtel_code');
		$get =$this->model_webservice->get_informasi_pengajuan_by_id_7($kopegtel_code);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	// private function action_send_sms($sms_to,$sms_message)
	// {
	// 	$plus62 = substr($sms_to,0,3);
	// 	if($plus62=="628"){
	// 		$sms_to = substr($sms_to,2);
	// 		$sms_to = "+62".$sms_to;
	// 	}else if($plus62!="+62"){
	// 		$sms_to = substr($sms_to,1);
	// 		$sms_to = "+62".$sms_to;
	// 	}
	// 	$sms_message = str_replace(' ', '+', $sms_message);
		
	// 	$link4execute = 'http://103.253.113.76/~playsms/index.php?app=webservices&u=mhd&h=d40021b3cbdbd504cfc657a8ecd5964d&ta=pv&to='.$sms_to.'&msg='.$sms_message.'&format=json';
	// 	// $link4execute = 'http://sms.tazkiaonline.com:8989/playsms/input.php?u=rohmat&p=rohmat2010&ta=pv&to='.$sms_to.'&msg='.$sms_message;
	// 	$ch = curl_init(); //buat resourcce cURL
	// 	curl_setopt($ch, CURLOPT_URL, $link4execute);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$output = curl_exec($ch);
	// 	$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 	curl_close($ch);
	// }

	public function get_status_dokumen_lengkap()
	{
		$product_code = $this->input->post('product_code');
		$status_dokumen_lengkap = $this->model_webservice->get_status_dokumen_lengkap_by_product_code($product_code);
		$data = array('status_dokumen_lengkap'=>$status_dokumen_lengkap);
		echo json_encode($data);
	}

	public function get_data_jaminan()
	{
		$registration_no = $this->input->post('registration_no');
		$get =$this->model_webservice->get_data_jaminan($registration_no);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function get_schedulle_by_account_financing_id()
	{
		$account_financing_id = $this->input->post('account_financing_id');
		$get =$this->model_webservice->get_schedulle_by_account_financing_id($account_financing_id);
		// $result = array('data'=>$get);
		echo json_encode($get);
	}

	public function get_mitra_koperasi_not_having_kopeg()
	{
		$get =$this->model_webservice->get_mitra_koperasi_not_having_kopeg();
		$result = array('data'=>$get);
		echo json_encode($result);
	}

	public function get_nama_tgllhr()
	{
		$nik = $this->input->post('nik');
		$get =$this->model_webservice->get_nama_tgllhr($nik);
		$result = array('data'=>$get);
		echo json_encode($result);
	}

}