<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GMN_Controller extends CI_Controller {

	public static $_is_exist_user_cash = false;

	public $_thisDate;

	public function __construct($securePage=false)
	{
		parent::__construct();
		ini_set('MAX_EXECUTION_TIME', 3600);
		// ini_set('memory_limit','1024M');
		ini_set('upload_max_filesize','100M');
		ini_set('post_max_size','100M');
		date_default_timezone_set('Asia/Jakarta');
		
		if($securePage==true)
		{
			if($this->session->userdata('is_logged_in')==false)
			{
				redirect('login');
			}
		}
		else
		{
			if($this->session->userdata('is_logged_in')==true)
			{
				redirect('dashboard');
			}	
		}

		$url 				= $this->uri->segment(1); // get url by segment 1

		if($url==false)
		{
			redirect('login');
		}



		$url = strtoupper($this->uri->segment(1).$this->uri->segment(2));
		if ($url!="") {
			$menu_is_exists = $this->model_core->cek_menu_is_exists($url);
			if ($menu_is_exists==true) {
				$menu_id = $this->model_core->get_menu_id_by_url($url);
				$url_is_allowed = $this->model_core->cek_url_is_allowed($menu_id,$this->session->userdata('role_id'));
				if ($menu_id!='4') { // if not dashboard
					if ($url_is_allowed==false) {
						show_404();
					}
				}
			}
		}


		$url 				= $this->uri->segment(1); // get url by segment 1
		
		$role_id 			= $this->session->userdata('role_id');
		$title 				= $this->model_core->get_menu_title($url); // get title by url
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$_is_exist_user_cash= $this->model_core->get_is_exist_user_cash($this->session->userdata('user_id'));
		$this->_is_exist_user_cash=$_is_exist_user_cash;
		$data['title'] 		= $title;
		$data['allnotif']   = $this->model_core->get_notification();
		$data['notif']		= $this->model_core->get_notification(1);
		$data['v_periode_awal'] = $kontrol_periode['periode_awal'];
		$data['v_periode_akhir'] = $kontrol_periode['periode_akhir'];
		$data['day_periode_awal'] = date('d',strtotime($kontrol_periode['periode_awal']));
		$data['month_periode_awal'] = date('m',strtotime($kontrol_periode['periode_awal']));
		$data['year_periode_awal'] = date('Y',strtotime($kontrol_periode['periode_awal']));
		$data['day_periode_akhir'] = date('d',strtotime($kontrol_periode['periode_akhir']));
		$data['month_periode_akhir'] = date('m',strtotime($kontrol_periode['periode_akhir']));
		$data['year_periode_akhir'] = date('Y',strtotime($kontrol_periode['periode_akhir']));
		$data['periode_awal'] = $this->format_date_detail($kontrol_periode['periode_awal'],'id',true,' ');
		$data['periode_akhir'] = $this->format_date_detail($kontrol_periode['periode_akhir'],'id',true,' ');
		$data['biaya_notaris'] = $this->session->userdata('titipan_notaris');
		// $data['jabatan_logged_in'] = $this->get_deskripsi_jabatan_by_kode($this->session->userdata('kode_jabatan'));
		$data['_is_exist_user_cash'] = $_is_exist_user_cash;

		$this->_thisDate = $kontrol_periode['periode_akhir'];

		$this->load->vars($data);
		$this->generate_menu($role_id,$url);

	}

	// public function get_deskripsi_jabatan_by_kode($kode_jabatan)
	// {
	// 	$sql = "select nama_jabatan from mfi_jabatan where kode_jabatan=?";
	// 	$query = $this->db->query($sql,array($kode_jabatan));
	// 	$row = $query->row_array();
	// 	return $row['nama_jabatan'];
	// }

	public function get_approval_limit_time()
	{
		$timelimit = $this->model_core->get_approval_limit_time();
		return $timelimit;
	}

	public function get_from_trx_date(){
		$kontrol_periode = $this->model_core->get_trx_kontrol_periode_active();
		return $kontrol_periode['periode_awal'];
	}

	public function get_thru_trx_date(){
		$kontrol_periode = $this->model_core->get_trx_kontrol_periode_active();
		return $kontrol_periode['periode_akhir'];
	}

	public function current_date()
	{
		return $this->model_core->get_current_date();
	}

	public function get_menu_id($menu_url)
	{
		$menu_id = $this->model_core->get_menu_id($menu_url);
		return $menu_id;
	}

	public function datepicker_convert($has_separator=false,$datepicker,$separator='/')
	{
		if(trim($datepicker)==''){
			return '';
		}
		if($has_separator==true){
			$datepicker = str_replace($separator, '', $datepicker);
		}
        $date = substr($datepicker,4,4).'-'.substr($datepicker,2,2).'-'.substr($datepicker,0,2);

        return $date;
	}

	public function generate_menu($role_id,$url)
	{
		$html = '';
		
		$menu = $this->model_core->get_menu($role_id,0);

		for ( $i = 0 ; $i < count($menu) ; $i++ )
		{

			/* BEGIN MENU */
			if($menu[$i]['menu_url']==$url)
			{
				$li_active = 'start active';
				$span_selected = 'selected';
			}
			else
			{
				$li_active = '';
				if($menu[$i]['menu_url']=="dashboard" || $menu[$i]['menu_flag_link']==1)
					$span_selected = '';
				else
					$span_selected = 'arrow';
			}

			if($menu[$i]['menu_flag_link']==0)
				$link_menu = 'javascript:;';
			else
				$link_menu = site_url($menu[$i]['menu_url']);

			$html .= '
			<li class="'.$li_active.'">
               <a href="'.$link_menu.'">
                  <i class="icon-'.$menu[$i]['menu_icon_parent'].'"></i>
                  <span class="title">'.$menu[$i]['menu_title'].'</span>
                  <span class="'.$span_selected.'"></span>
               </a>
			';
            
            /* BEGIN SUB MENU */
			$submenu = $this->model_core->get_menu($role_id,$menu[$i]['menu_id']);
			if ( count($submenu) > 0 )
            	$html .= '<ul class="sub-menu">';

			for ( $j = 0 ; $j < count($submenu) ; $j++ )
			{

				$submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
				if($submenu[$j]['menu_url']==$submenu_url)
					$lisub_active = ' class="active"';
				else
					$lisub_active = '';

				$sub_submenu = $this->model_core->get_menu($role_id,$submenu[$j]['menu_id']);
            	for ( $jtk = 0 ; $jtk < count($sub_submenu) ; $jtk++ )
            	{
					$sub_submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
					if($sub_submenu[$jtk]['menu_url']==$sub_submenu_url){
						$lisub_active = ' class="active"';
						break;
					}
					else{
						$lisub_active = '';
					}
				}

				if($submenu[$j]['menu_flag_link']==0)
					$span_selected2 = 'arrow';
				else
					$span_selected2 = '';

				$html .= '
				  <li'.$lisub_active.'>
                     <a href="'.site_url($submenu[$j]['menu_url']).'">
				        <i class="icon-'.$submenu[$j]['menu_icon_parent'].'"></i>
                     	<span class="title">'.$submenu[$j]['menu_title'].'</span>
				        <span class="'.$span_selected2.'"></span>
                     </a>
				';

				if ( count($sub_submenu) > 0 )
            		$html .= '<ul class="sub-menu">';

            	for ( $k = 0 ; $k < count($sub_submenu) ; $k++ )
				{
					$sub_submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
					if($sub_submenu[$k]['menu_url']==$sub_submenu_url)
						$lisub_sub_active = ' class="active"';
					else
						$lisub_sub_active = '';

					if($sub_submenu[$k]['menu_flag_link']==0)
						$span_selected3 = 'arrow';
					else
						$span_selected3 = '';

					$html .= '
					  <li'.$lisub_sub_active.'>
						 <a href="'.site_url($sub_submenu[$k]['menu_url']).'">
					        <i class="icon-'.$sub_submenu[$k]['menu_icon_parent'].'"></i>
	                     	<span class="title">'.$sub_submenu[$k]['menu_title'].'</span>
	                     </a>
	                  </li>
					';
				}

				if ( count($sub_submenu) > 0 )
	            	$html .= '</ul>';

				$html .= '
                  </li>
                ';

			}

			if ( count($submenu) > 0 )
            	$html .= '</ul>';
            /* END SUB MENU */

			$html .= '</li>';
			/* END MENU */
		}

		$data['menu'] = $html;

		$this->load->vars($data);
	}

	/**
	 * fungsi untuk mengambil root menu
	 * @param role_id
	 */
	public function load_menu($role_id)
	{
		$menu = $this->model_core->get_menu($role_id,0);
		$this->load->vars('menu',$menu);
	}

	/**
	 * fungsi untuk mengambil sub menu
	 * @param role_id, menu_parent
	 */
	public function load_sub_menu($role_id,$menu_parent)
	{
		$submenu = $this->model_core->get_menu($role_id,$menu_parent);
		$this->load->vars('submenu',$submenu);
	}

	public function get_age_by_ajax()
	{
		$date = $this->input->post('date');

		$age = $this->get_usia($date,date('Y-m-d'));

		echo json_encode(array('age'=>$age));
	}

	// untuk menghitung interval/hari dari suatu bulan ke bulan tujuan
	public function get_usia_menurut_asuransi( $date1 , $date2, $type = 'nearest')
	{
	 	$date1exp = explode('-',$date1);
		$date1year = $date1exp[0];
		$date1month = $date1exp[1];
		$date1date = $date1exp[2];
		
	 	$date2exp = explode('-',$date2);
		$date2year = $date2exp[0];
		$date2month = $date2exp[1];
		$date2date = $date2exp[2];
		if($date2month<$date1month){
			$date2year = $date2year - 1;
		}
		
		$year = $date2year-$date1year;
		
		$date3 = $date2year.'-'.$date1month.'-'.$date1date;
		
		$date3 = strtotime($date3); // tanggal ulang tahun sekarang
		$date2 = strtotime($date2); // tanggal sekarang
		
		$count = $this->count_days($date3,$date2);
		//echo $year;
		//echo $count;
		if($type=="nearest"){
			if($count>=180)
			{
				$age = $year+1;
			}
			else if($count<0)
			{
				$age = $year-1;
			}
			else
			{
				$age = $year;
			}
		}else if($type=="next"){
			if($count>0)
			{
				$age = $year+1;
			}
			else
			{
				$age = $year;
			}
		}
		
		return $age;
	}

	// untuk menghitung interval/hari dari suatu bulan ke bulan tujuan
	public function get_usia( $birthdate , $now)
	{
	 	$date1exp = explode('-',$birthdate);
		$date1year = $date1exp[0];
		$date1month = $date1exp[1];
		$date1date = $date1exp[2];
		
	 	$date2exp = explode('-',$now);
		$date2year = $date2exp[0];
		$date2month = $date2exp[1];
		$date2date = $date2exp[2];
		if($date2month<$date1month){
			$date2year = $date2year - 1;
		}
		
		$year = $date2year-$date1year;
		
		$date3 = $date2year.'-'.$date1month.'-'.$date1date;
		
		$date3 = strtotime($date3); // tanggal ulang tahun sekarang
		$date2 = strtotime($now); // tanggal sekarang
		
		$count = $this->count_days($date3,$date2);
		// echo $count;
		if($count>0)
		{
			$age = $year;
		}
		else
		{
			$age = $year-1;
		}
		
		return $age;
	}
	// untuk menghitung interval/hari dari suatu bulan ke bulan tujuan
	public function count_days( $a, $b )
	{
	    $gd_a = getdate( $a );
	    $gd_b = getdate( $b );
	 
	    $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
	    $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );

	    // echo "a_new:".$a_new.",b_new:".$b_new."count:".round( ( $b_new - $a_new ) / 86400 );

	    return round( ( $b_new - $a_new ) / 86400 );
	}

	// pada parameter $tanggal. format datenya harus yyyy-mm-dd
	public function format_date_detail($tanggal,$lang='id',$description=false,$separator='/')
	{
		
		if($tanggal!="0000-00-00" || $tanggal!="" || $tanggal!=NULL)
		{
			$exp = explode('-',$tanggal);
			$year = $exp[0];
			$month = $exp[1];
			$date = $exp[2];
	
			if($description==true)
			{
				$month = $this->get_month_description($month,$lang);
			}
	
			if($lang=='id' || $lang=='en' || $lang=='iden')
			{
				if($lang=="id")
				{
					$return = $date.$separator.$month.$separator.$year;
				}
				else if($lang=="en")
				{
					$return = $year.$separator.$month.$separator.$date;
				}
				else if($lang=="iden")
				{
					$return = ((int)$date).$separator.$month.$separator.$year;
				}
			}
			else
			{
				die("Bahasa pada bulan tidak ditemukan. lang:$lang <strong>function:format_date_detail()</strong>");
			}
		}
		else
		{
			$return = '';
		}
		return $return;
	}

	// get description of month number
	public function get_month_description($month,$lang='id')
	{
		$month = (int) $month;

		if($lang!='id' || $lang!='en' || $lang!='iden')
		{
			if($lang=="en")
			{
				$month_name = array('','January','February','March','April','May','June','July','August','September','October','November','December');
			}
			else if($lang=="id")
			{
				$month_name = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			}
			else if($lang=="iden")
			{
				$month_name = array('','January','February','March','April','May','June','July','August','September','October','November','December');
			}
		}
		else
		{
			die("Bahasa pada bulan tidak ditemukan. lang:$lang <strong>function:get_month_description()</strong>");
		}

		return $month_name[$month];

	}

	public function convert_numeric($value)
	{
		$value = str_replace('.', '', $value);
		$result = str_replace(',', '.', $value);

		return $result;
	}
	
	
	public function convert_date($date='',$month_length='long',$lang='en_to_id')
	{
		if ( $date == '' )
			$date = date('Y-m-d');
	
		$e = explode ( '-' , $date );
	
		if ( $lang == 'en_to_id' )
		{
			if ( $month_length == 'short' )
			{
				$month = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nop','Des');
			}
			else
			{
				$month = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			}
	
			return $e[2] . '-' . $month [ (int) $e[1] ] . '-' . $e[0];
		}
	
		else if ( $lang == 'id_to_en' )
		{
			if ( $month_length == 'short' )
			{
				$month = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			}
			else
			{
				$month = array('','January','February','March','April','Mei','June','July','August','September','October','November','December');
			}
	
			return $e[0] . '-' . $month [ (int) $e[1] ] . '-' . $e[2];
		}
	
		else 
		{
			return $date;
		}
	}

 	function terbilang($angka) {
	    // pastikan kita hanya berususan dengan tipe data numeric
	    $angka = (float)$angka;
	     
	    // array bilangan 
	    // sepuluh dan sebelas merupakan special karena awalan 'se'
	    $bilangan = array(
	            '',
	            'satu',
	            'dua',
	            'tiga',
	            'empat',
	            'lima',
	            'enam',
	            'tujuh',
	            'delapan',
	            'sembilan',
	            'sepuluh',
	            'sebelas'
	    );
	     
	    // pencocokan dimulai dari satuan angka terkecil
	    if ($angka < 12) {
	        // mapping angka ke index array $bilangan
	        return $bilangan[$angka];
	    } else if ($angka < 20) {
	        // bilangan 'belasan'
	        // misal 18 maka 18 - 10 = 8
	        return $bilangan[$angka - 10] . ' belas';
	    } else if ($angka < 100) {
	        // bilangan 'puluhan'
	        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
	        // untuk mendapatkan sisa bagi gunakan modulus
	        // 27 mod 10 = 7 'tujuh'
	        $hasil_bagi = (int)($angka / 10);
	        $hasil_mod = $angka % 10;
	        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
	    } else if ($angka < 200) {
	        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
	        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
	        // daripada menulis ulang rutin kode puluhan maka gunakan
	        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
	        return sprintf('seratus %s', $this->terbilang($angka - 100));
	    } else if ($angka < 1000) {
	        // bilangan 'ratusan'
	        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
	        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif $this->terbilang(67))
	        $hasil_bagi = (int)($angka / 100);
	        $hasil_mod = $angka % 100;
	        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
	    } else if ($angka < 2000) {
	        // bilangan 'seribuan'
	        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
	        // gunakan rekursif $this->terbilang(250)
	        return trim(sprintf('seribu %s', $this->terbilang($angka - 1000)));
	    } else if ($angka < 1000000) {
	        // bilangan 'ribuan' (sampai ratusan ribu
	        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
	        $hasil_mod = $angka % 1000;
	        return sprintf('%s ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
	    } else if ($angka < 1000000000) {
	        // bilangan 'jutaan' (sampai ratusan juta)
	        // 'satu puluh' => SALAH
	        // 'satu ratus' => SALAH
	        // 'satu juta' => BENAR 
	        // @#$%^ WT*
	         
	        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
	        $hasil_bagi = (int)($angka / 1000000);
	        $hasil_mod = $angka % 1000000;
	        return trim(sprintf('%s juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
	    } else if ($angka < 1000000000000) {
	        // bilangan 'milyaran'
	        $hasil_bagi = (int)($angka / 1000000000);
	        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
	        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
	        $hasil_mod = fmod($angka, 1000000000);
	        return trim(sprintf('%s milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
	    } else if ($angka < 1000000000000000) {
	        // bilangan 'triliun'
	        $hasil_bagi = $angka / 1000000000000;
	        $hasil_mod = fmod($angka, 1000000000000);
	        return trim(sprintf('%s triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
	    } else {
	        return '-';
	    }
	}

}

/* End of file GMN_Controller.php */
/* Location: ./application/core/GMN_Controller.php */