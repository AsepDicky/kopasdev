<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservices extends CI_Controller {

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
		$auth = $this->model_webservice->authentication($username,$password);
		if (count($auth)>0) {
			$role_id = $auth['role_id'];
			$user_id = $auth['user_id'];
			switch ($role_id) {
				case '42':
				$userdata = $this->model_webservice->userdata_nasabah($user_id);
				$userdata['is_logged_in'] = true;
				$result = array('login'=>'success','userdata'=>$userdata);
				break;
				case '43':
				$userdata = $this->model_webservice->userdata_kopegtel($user_id);
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
		$jumlah_tanggungan = $this->input->post('jumlah_tanggungan');
		$status_rumah = $this->input->post('status_rumah');
		$nama_bank = $this->input->post('nama_bank');
		$no_rekening = $this->input->post('no_rekening');
		$atasnama_rekening = $this->input->post('atasnama_rekening');
		$total_angsuran = $this->input->post('total_angsuran');
		$bank_cabang = $this->input->post('bank_cabang');
		$lunasi_kopegtel = $this->input->post('lunasi_kopegtel');
		$keterangan_peruntukan = $this->input->post('keterangan_peruntukan');
		$flag_thp = $this->input->post('flag_thp');

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
				,'nama_pasangan' =>$nama_pasangan
				,'pekerjaan_pasangan' =>$pekerjaan_pasangan
				,'jumlah_tanggungan' =>$jumlah_tanggungan
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
				,'jumlah_tanggungan' =>$jumlah_tanggungan
				,'status_rumah' =>$status_rumah
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

		$this->db->trans_begin();
		$this->model_webservice->save_pengajuan($data);
		if ($this->db->trans_status()===true) {
			if($cif_id=='0'){
				$this->model_webservice->insert_cif($data_cif);
			}else{
				$this->model_webservice->update_cif($data_cif,$param);
			}
			$this->db->trans_commit();
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
		$data = array('status' => '1','approve_date'=>date("Y-m-d H:i:s"));
		$param = array('account_financing_reg_id' => $account_financing_reg_id);
		$this->db->trans_begin();
		$this->model_webservice->do_update_pengajuan($data,$param);
		if ($this->db->trans_status()===true) {
			$this->db->trans_commit();
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

	public function get_product_financing()
	{
		$get =$this->model_webservice->get_product_financing();
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
				$status = "Registrasi";
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
				,$row['peruntukan']
				,$row['tanggal_pengajuan']
				,$status
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
		echo json_encode($get);
	}

	public function edit_pengajuan()
	{
		$account_financing_reg_id = $this->input->post('account_financing_reg_id');
		$bank = $this->input->post('bank');
		$nomor_rekening = $this->input->post('nomor_rekening');
		$atas_nama = $this->input->post('atas_nama');
		$nik = $this->input->post('nik');

		$data = array(
					 'nama_bank' => $bank
					,'no_rekening' => $nomor_rekening
					,'atasnama_rekening' => $atas_nama
				);

		$param = array('account_financing_reg_id' => $account_financing_reg_id);
		$param2 = array('cif_no' => $nik);

		$this->db->trans_begin();
		$this->model_webservice->edit_mfi_financing_reg($data,$param);
		$this->model_webservice->edit_mfi_cif($data,$param2);
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

}