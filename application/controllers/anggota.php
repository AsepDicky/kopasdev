<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model('model_laporan');
		$this->load->model('model_anggota');
		$this->load->model('model_cif');
		$this->load->model('model_laporan_to_pdf');
		$this->load->library('html2pdf');
		$this->load->library('phpexcel');
		$CI =& get_instance();
	}

	public function index()
	{
		$data['container'] = 'anggota';
		$this->load->view('core',$data);
	}

	/****************************************************************************************/	
	// BEGIN REPORT LIST AGING 
	/****************************************************************************************/

	public function aging_report()
	{
		$data['container'] = 'anggota/aging_report';
		//$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}
	/****************************************************************************************/	
	// END REPORT LIST AGING 
	/****************************************************************************************/
	
	/****************************************************************************************/	
	// BEGIN LAPORAN DAFTAR ANGGOTA
	/****************************************************************************************/
	public function list_anggota()
	{
		$data['container'] = 'anggota/list_anggota';
		$data['kecamatans'] = $this->model_anggota->get_kecamatan_data();
		$this->load->view('core',$data);
	}

	public function list_anggota_report()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$cm = isset($_REQUEST['cm'])?$_REQUEST['cm']:'';
		$branch = isset($_REQUEST['branch'])?$_REQUEST['branch']:'';

		if($cm=="00000"){
            $rembug = "";
        }else{
            $rembug = $cm;            
        }

		if($branch=="00000"){
            $cabang = "";
        }else{
            $cabang = $branch;            
        }

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_anggota->list_anggota_report('','','','',$rembug,$cabang);//2

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_anggota->list_anggota_report($sidx,$sort,$limit_rows,$start,$rembug,$cabang);//3

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['cif_no']=$row['cif_no'];
		    $responce['rows'][$i]['cell']=array(
			    $row['cif_no']
			    ,$row['nama']
			    ,$row['cm_name']
			    ,$row['kabupaten']
			    ,$row['kecamatan']
			    ,$row['desa']
			    ,$row['created_timestamp']
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	public function export_list_anggota()
	{
		$branch_id 	= $this->uri->segment(3);
		$cm_code 	= $this->uri->segment(4);

				$datas = $this->model_laporan_to_pdf->export_list_anggota($branch_id,$cm_code);
				//$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);
			
			// ----------------------------------------------------------
	    	// [BEGIN] EXPORT SCRIPT
			// ----------------------------------------------------------

			// Create new PHPExcel object
			$objPHPExcel = $this->phpexcel;
			// Set document properties
			$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
										 ->setLastModifiedBy("MICROFINANCE")
										 ->setTitle("Office 2007 XLSX Test Document")
										 ->setSubject("Office 2007 XLSX Test Document")
										 ->setDescription("REPORT, generated using PHP classes.")
										 ->setKeywords("REPORT")
										 ->setCategory("Test result file");
										 
			$objPHPExcel->setActiveSheetIndex(0); 

			$styleArray = array(
       		'borders' => array(
		             'outline' => array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                    'color' => array('rgb' => '000000'),
		             ),
		       ),
			);

			//$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->mergeCells('C1:F1');
			$objPHPExcel->getActiveSheet()->setCellValue('C1',"LAPORAN LIST ANGGOTA");
			$objPHPExcel->getActiveSheet()->setCellValue('C4',"ID ANGGOTA");
			$objPHPExcel->getActiveSheet()->setCellValue('D4',"NAMA");
			$objPHPExcel->getActiveSheet()->setCellValue('E4',"PANGGILAN");
			$objPHPExcel->getActiveSheet()->setCellValue('F4',"DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('G4',"KECAMATAN");
			$objPHPExcel->getActiveSheet()->setCellValue('H4',"KABUPATEN");
			$objPHPExcel->getActiveSheet()->setCellValue('I4',"TANGGAL REGIS");
			$objPHPExcel->getActiveSheet()->setCellValue('J4',"JENIS KELAMIN");
			$objPHPExcel->getActiveSheet()->setCellValue('K4',"BIN");
			$objPHPExcel->getActiveSheet()->setCellValue('L4',"TMP LAHIR");
			$objPHPExcel->getActiveSheet()->setCellValue('M4',"TGL LAHIR");
			$objPHPExcel->getActiveSheet()->setCellValue('N4',"USIA");
			$objPHPExcel->getActiveSheet()->setCellValue('O4',"ALAMAT");
			$objPHPExcel->getActiveSheet()->setCellValue('P4',"RT/RW");
			$objPHPExcel->getActiveSheet()->setCellValue('Q4',"KODE POS");
			$objPHPExcel->getActiveSheet()->setCellValue('R4',"NO KTP");
			$objPHPExcel->getActiveSheet()->setCellValue('S4',"NPWP");
			$objPHPExcel->getActiveSheet()->setCellValue('T4',"TLP RUMAH");
			$objPHPExcel->getActiveSheet()->setCellValue('U4',"TLP SELULER");
			$objPHPExcel->getActiveSheet()->setCellValue('V4',"PENDIDIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('W4',"STATUS KAWIN");
			$objPHPExcel->getActiveSheet()->setCellValue('X4',"PEKERJAAN");
			$objPHPExcel->getActiveSheet()->setCellValue('Y4',"KET. PEKERJAAN");
			$objPHPExcel->getActiveSheet()->setCellValue('Z4',"PENDAPATAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AA4',"SETORAN LWK");
			$objPHPExcel->getActiveSheet()->setCellValue('AB4',"SETORAN MINGGUAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AC4',"LITERASI LATIN");
			$objPHPExcel->getActiveSheet()->setCellValue('AD4',"LITERASI ARAB");
			$objPHPExcel->getActiveSheet()->setCellValue('AE4',"NAMA PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AF4',"TMP LAHIR PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AG4',"TGL LAHIR PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AH4',"USIA PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AI4',"PENDIDIKAN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AJ4',"PEKERJAAN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AK4',"KET. PEKERJAAN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AL4',"PENDAPATAN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AM4',"PERIODE PENDAPATAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AN4',"LITERASI LATIN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AO4',"LITERASI ARAB PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AP4',"JML TANGGUNGAN PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AQ4',"JML KELUARGA PASANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AR4',"RMH STATUS");
			$objPHPExcel->getActiveSheet()->setCellValue('AS4',"RMH UKURAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AT4',"RMH ATAP");
			$objPHPExcel->getActiveSheet()->setCellValue('AU4',"RMH DINDING");
			$objPHPExcel->getActiveSheet()->setCellValue('AV4',"RMH LANTAI");
			$objPHPExcel->getActiveSheet()->setCellValue('AW4',"RMH JAMBAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AX4',"RMH AIR");
			$objPHPExcel->getActiveSheet()->setCellValue('AY4',"LAHAN SAWAN");
			$objPHPExcel->getActiveSheet()->setCellValue('AZ4',"LAHAN KEBUN");
			$objPHPExcel->getActiveSheet()->setCellValue('BA4',"LAHAN PEKARANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('BB4',"TERNAK KERBAU");
			$objPHPExcel->getActiveSheet()->setCellValue('BC4',"TERNAK DOMBA");
			$objPHPExcel->getActiveSheet()->setCellValue('BD4',"TERNAK UNGGAS");
			$objPHPExcel->getActiveSheet()->setCellValue('BE4',"ELEK TAPE");
			$objPHPExcel->getActiveSheet()->setCellValue('BF4',"ELEK TV");
			$objPHPExcel->getActiveSheet()->setCellValue('BG4',"ELEK PLAYER");
			$objPHPExcel->getActiveSheet()->setCellValue('BH4',"ELEK KULKAS");
			$objPHPExcel->getActiveSheet()->setCellValue('BI4',"SEPEDA");
			$objPHPExcel->getActiveSheet()->setCellValue('BJ4',"MOTOR");
			$objPHPExcel->getActiveSheet()->setCellValue('BK4',"USH RMH TANGGA");
			$objPHPExcel->getActiveSheet()->setCellValue('BL4',"USH KOMODITI");
			$objPHPExcel->getActiveSheet()->setCellValue('BM4',"USH LOKASI");
			$objPHPExcel->getActiveSheet()->setCellValue('BN4',"USH OMSET");
			$objPHPExcel->getActiveSheet()->setCellValue('BO4',"BIAYA BERAS");
			$objPHPExcel->getActiveSheet()->setCellValue('BP4',"BIAYA DAPUR");
			$objPHPExcel->getActiveSheet()->setCellValue('BQ4',"BIAYA LISTRIK");
			$objPHPExcel->getActiveSheet()->setCellValue('BR4',"BIAYA TELPON");
			$objPHPExcel->getActiveSheet()->setCellValue('BS4',"BIAYA SEKOLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('BT4',"BIAYA LAIN");

			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('C4:BT4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('M4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('N4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('P4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('Q4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('R4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('S4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('T4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('U4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('V4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('W4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('X4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('Y4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('Z4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AA4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AB4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AC4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AD4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AE4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AF4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AG4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AH4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AI4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AJ4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AK4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AL4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AM4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AN4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AO4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AP4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AQ4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AR4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AS4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AT4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AU4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AV4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AW4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AX4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AY4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('AZ4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BA4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BB4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BC4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BD4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BE4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BF4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BG4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BH4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BI4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BJ4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BK4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BL4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BM4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BN4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BO4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BP4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BQ4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BR4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BS4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('BT4')->applyFromArray($styleArray);


			$ii = 5;
			for($i=0;$i<count($datas);$i++)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':BT'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->mergeCells('C'.$ii.':BT'.$ii);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':BT'.$ii)->getFont()->setBold(true);

				if ($cm_code!=""){
					$cm = $cm_code;
				}else{
					$cm = "";
					// $cm = $datas[$i]['cm_code'];
				}

					$result2 = $this->model_laporan_to_pdf->export_list_anggota2($cm);
				
				$ii++;

				for($j=0;$j<count($result2);$j++)
				{
					if($result2[$j]['jenis_kelamin']=="P"){
						$jenis_kelamin = "Perempuan";
					}else{
						$jenis_kelamin = "Laki-laki";
					}
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".$result2[$j]['cif_no']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$result2[$j]['nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$result2[$j]['panggilan']);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$result2[$j]['desa']);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$result2[$j]['kecamatan']);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$result2[$j]['kabupaten']);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$result2[$j]['tgl_gabung']);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,$jenis_kelamin);
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,$result2[$j]['ibu_kandung']);
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,$result2[$j]['tmp_lahir']);
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,$result2[$j]['tgl_lahir']);
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,$result2[$j]['usia']);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,$result2[$j]['alamat']);
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii,$result2[$j]['rt_rw']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$ii,$result2[$j]['kodepos']);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$ii," ".$result2[$j]['no_ktp']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$ii,$result2[$j]['no_npwp']);
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$ii,$result2[$j]['telpon_rumah']);
					$objPHPExcel->getActiveSheet()->setCellValue('U'.$ii,$result2[$j]['telpon_seluler']);
					$objPHPExcel->getActiveSheet()->setCellValue('V'.$ii,$result2[$j]['pendidikan']);
					$objPHPExcel->getActiveSheet()->setCellValue('W'.$ii,$result2[$j]['status_perkawinan']);
					$objPHPExcel->getActiveSheet()->setCellValue('X'.$ii,$result2[$j]['pekerjaan']);
					$objPHPExcel->getActiveSheet()->setCellValue('Y'.$ii,$result2[$j]['ket_pekerjaan']);
					$objPHPExcel->getActiveSheet()->setCellValue('Z'.$ii,$result2[$j]['pendapatan_perbulan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AA'.$ii,$result2[$j]['setoran_lwk']);
					$objPHPExcel->getActiveSheet()->setCellValue('AB'.$ii,$result2[$j]['setoran_mingguan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AC'.$ii,$result2[$j]['literasi_latin']);
					$objPHPExcel->getActiveSheet()->setCellValue('AD'.$ii,$result2[$j]['literasi_arab']);
					$objPHPExcel->getActiveSheet()->setCellValue('AE'.$ii,$result2[$j]['p_nama']);
					$objPHPExcel->getActiveSheet()->setCellValue('AF'.$ii,$result2[$j]['p_tmplahir']);
					$objPHPExcel->getActiveSheet()->setCellValue('AG'.$ii,$result2[$j]['p_tglahir']);
					$objPHPExcel->getActiveSheet()->setCellValue('AH'.$ii,$result2[$j]['p_usia']);
					$objPHPExcel->getActiveSheet()->setCellValue('AI'.$ii,$result2[$j]['p_pendidikan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$ii,$result2[$j]['p_pekerjaan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AK'.$ii,$result2[$j]['p_ketpekerjaan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AL'.$ii,$result2[$j]['p_pendapatan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AM'.$ii,$result2[$j]['p_periodependapatan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AN'.$ii,$result2[$j]['p_literasi_latin']);
					$objPHPExcel->getActiveSheet()->setCellValue('AO'.$ii,$result2[$j]['p_literasi_arab']);
					$objPHPExcel->getActiveSheet()->setCellValue('AP'.$ii,$result2[$j]['p_jmltanggungan']);
					$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$ii,$result2[$j]['p_jmlkeluarga']);
					$objPHPExcel->getActiveSheet()->setCellValue('AR'.$ii,$result2[$j]['rmhstatus']);
					$objPHPExcel->getActiveSheet()->setCellValue('AS'.$ii,$result2[$j]['rmhukuran']);
					$objPHPExcel->getActiveSheet()->setCellValue('AT'.$ii,$result2[$j]['rmhatap']);
					$objPHPExcel->getActiveSheet()->setCellValue('AU'.$ii,$result2[$j]['rmhdinding']);
					$objPHPExcel->getActiveSheet()->setCellValue('AV'.$ii,$result2[$j]['rmhlantai']);
					$objPHPExcel->getActiveSheet()->setCellValue('AW'.$ii,$result2[$j]['rmhjamban']);
					$objPHPExcel->getActiveSheet()->setCellValue('AX'.$ii,$result2[$j]['rmhair']);
					$objPHPExcel->getActiveSheet()->setCellValue('AY'.$ii,$result2[$j]['lahansawah']);
					$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$ii,$result2[$j]['lahankebun']);
					$objPHPExcel->getActiveSheet()->setCellValue('BA'.$ii,$result2[$j]['lahanpekarangan']);
					$objPHPExcel->getActiveSheet()->setCellValue('BB'.$ii,$result2[$j]['ternakkerbau']);
					$objPHPExcel->getActiveSheet()->setCellValue('BC'.$ii,$result2[$j]['ternakdomba']);
					$objPHPExcel->getActiveSheet()->setCellValue('BD'.$ii,$result2[$j]['ternakunggas']);
					$objPHPExcel->getActiveSheet()->setCellValue('BE'.$ii,$result2[$j]['elektape']);
					$objPHPExcel->getActiveSheet()->setCellValue('BF'.$ii,$result2[$j]['elektv']);
					$objPHPExcel->getActiveSheet()->setCellValue('BG'.$ii,$result2[$j]['elekplayer']);
					$objPHPExcel->getActiveSheet()->setCellValue('BH'.$ii,$result2[$j]['elekkulkas']);
					$objPHPExcel->getActiveSheet()->setCellValue('BI'.$ii,$result2[$j]['kendsepeda']);
					$objPHPExcel->getActiveSheet()->setCellValue('BJ'.$ii,$result2[$j]['kendmotor']);
					$objPHPExcel->getActiveSheet()->setCellValue('BK'.$ii,$result2[$j]['ushrumahtangga']);
					$objPHPExcel->getActiveSheet()->setCellValue('BL'.$ii,$result2[$j]['ushkomoditi']);
					$objPHPExcel->getActiveSheet()->setCellValue('BM'.$ii,$result2[$j]['ushlokasi']);
					$objPHPExcel->getActiveSheet()->setCellValue('BN'.$ii,$result2[$j]['ushomset']);
					$objPHPExcel->getActiveSheet()->setCellValue('BO'.$ii,$result2[$j]['byaberas']);
					$objPHPExcel->getActiveSheet()->setCellValue('BP'.$ii,$result2[$j]['byadapur']);
					$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$ii,$result2[$j]['byalistrik']);
					$objPHPExcel->getActiveSheet()->setCellValue('BR'.$ii,$result2[$j]['byatelpon']);
					$objPHPExcel->getActiveSheet()->setCellValue('BS'.$ii,$result2[$j]['byasekolah']);

					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('K'.$ii.':K'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('L'.$ii.':L'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('M'.$ii.':M'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('N'.$ii.':N'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('O'.$ii.':O'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('P'.$ii.':P'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('Q'.$ii.':Q'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('R'.$ii.':R'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('S'.$ii.':S'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('T'.$ii.':T'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('U'.$ii.':U'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('V'.$ii.':V'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('W'.$ii.':W'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('X'.$ii.':X'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('Y'.$ii.':Y'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('Z'.$ii.':Z'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AA'.$ii.':AA'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AB'.$ii.':AB'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AC'.$ii.':AC'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AD'.$ii.':AD'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AE'.$ii.':AE'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AF'.$ii.':AF'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AG'.$ii.':AG'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AH'.$ii.':AH'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AI'.$ii.':AI'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AJ'.$ii.':AJ'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AK'.$ii.':AK'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AL'.$ii.':AL'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AM'.$ii.':AM'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AN'.$ii.':AN'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AO'.$ii.':AO'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AP'.$ii.':AP'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AQ'.$ii.':AQ'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AR'.$ii.':AR'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AS'.$ii.':AS'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AT'.$ii.':AT'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AU'.$ii.':AU'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AV'.$ii.':AV'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AW'.$ii.':AW'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AX'.$ii.':AX'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AY'.$ii.':AY'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('AZ'.$ii.':AZ'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BA'.$ii.':BA'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BB'.$ii.':BB'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BC'.$ii.':BC'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BD'.$ii.':BD'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BE'.$ii.':BE'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BF'.$ii.':BF'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BG'.$ii.':BG'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BH'.$ii.':BH'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BI'.$ii.':BI'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BJ'.$ii.':BJ'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BK'.$ii.':BK'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BL'.$ii.':BL'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BM'.$ii.':BM'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BN'.$ii.':BN'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BO'.$ii.':BO'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BP'.$ii.':BP'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BQ'.$ii.':BQ'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BR'.$ii.':BR'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BS'.$ii.':BS'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('BT'.$ii.':BT'.$ii)->applyFromArray($styleArray);
					// $objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':BT'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':BT'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$ii++;
				}

			}

				/*$ii++;
			
			}//END FOR*/

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT-LIST-ANGGOTA.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

	public function get_desa_by_keyword()
	{
		$keyword = $this->input->post('keyword');
		$kecamatan_browse = $this->input->post('kecamatan_browse');
		$data = $this->model_anggota->get_desa_by_keyword($keyword,$kecamatan_browse);

		echo json_encode($data);
	}

	/****************************************************************************************/	
	// END LAPORAN DAFTAR ANGGOTA
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LAPORAN DAFTAR ANGGOTA
	/****************************************************************************************/
	public function list_individu()
	{
		$data['container'] = 'anggota/list_individu';
		$data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
		$this->load->view('core',$data);
	}

	public function list_individu_report()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'cif_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$branch_code = isset($_REQUEST['branch_code'])?$_REQUEST['branch_code']:'';
		$tanggal = isset($_REQUEST['tanggal'])?$_REQUEST['tanggal']:'';
		$tanggal2 = isset($_REQUEST['tanggal2'])?$_REQUEST['tanggal2']:'';
		
		if($tanggal!=""){
		$tgl_ 	 	= substr("$tanggal",0,2);
	    $bln_ 	 	= substr("$tanggal",2,2);
	    $thn_ 	 	= substr("$tanggal",4,4);
	    $tglawal 	= "$thn_-$bln_-$tgl_"; 
		}else{
			$tglawal = "";
		}

		if($tanggal2!=""){
		$tgl__ 	 	= substr("$tanggal2",0,2);
	    $bln__ 	 	= substr("$tanggal2",2,2);
	    $thn__ 	 	= substr("$tanggal2",4,4);
	    $tglakhir 	= "$thn__-$bln__-$tgl__"; 
		}else{
			$tglakhir = "";
		}

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_anggota->list_individu_report('','','','',$branch_code,$tglawal,$tglakhir);//2

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_anggota->list_individu_report($sidx,$sort,$limit_rows,$start,$branch_code,$tglawal,$tglakhir);//3

		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			if($row['jenis_kelamin']=="P"){
				$jk = "Laki-laki";
			}else{
				$jk = "Perempuan";
			}
			$responce['rows'][$i]['spa_no']=$row['cif_no'];
		    $responce['rows'][$i]['cell']=array(
			    $row['cif_no']
			    ,$row['nama']
			    ,$jk
			    ,$this->format_date_detail($row['tgl_lahir'],'id',false,'-')
			    ,$row['usia']." tahun"
		    );
		    $i++;
		}

		echo json_encode($responce);
	}

	public function search_cif_no()
	{
		$keyword 	= $this->input->post('keyword');
		$data 		= $this->model_anggota->search_cif_no($keyword);

		echo json_encode($data);
	}

	public function export_list_individu()
	{
		$tanggal = $this->uri->segment(3);
		$tanggal2 = $this->uri->segment(4);
		$branch_code = $this->uri->segment(5);

        if ($branch_code !='00000'){
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($branch_code);
        }else{
            $data_cabang = "Semua Cabang";
        }

		if($tanggal!=""){
		$tgl_ 	 	= substr("$tanggal",0,2);
	    $bln_ 	 	= substr("$tanggal",2,2);
	    $thn_ 	 	= substr("$tanggal",4,4);
	    $tglawal 	= "$thn_-$bln_-$tgl_"; 
		}else{
			$tglawal = "";
		}

		if($tanggal2!=""){
		$tgl__ 	 	= substr("$tanggal2",0,2);
	    $bln__ 	 	= substr("$tanggal2",2,2);
	    $thn__ 	 	= substr("$tanggal2",4,4);
	    $tglakhir 	= "$thn__-$bln__-$tgl__"; 
		}else{
			$tglakhir = "";
		}

			$datas = $this->model_laporan_to_pdf->export_list_individu($tglawal,$tglakhir,$branch_code);
			
			// ----------------------------------------------------------
	    	// [BEGIN] EXPORT SCRIPT
			// ----------------------------------------------------------

			// Create new PHPExcel object
			$objPHPExcel = $this->phpexcel;
			// Set document properties
			$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
										 ->setLastModifiedBy("MICROFINANCE")
										 ->setTitle("Office 2007 XLSX Test Document")
										 ->setSubject("Office 2007 XLSX Test Document")
										 ->setDescription("REPORT, generated using PHP classes.")
										 ->setKeywords("REPORT")
										 ->setCategory("Test result file");
										 
			$objPHPExcel->setActiveSheetIndex(0); 

			$styleArray = array(
       		'borders' => array(
		             'outline' => array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                    'color' => array('rgb' => '000000'),
		             ),
		       ),
			);

			$objPHPExcel->getActiveSheet()->getStyle('B3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B3:J3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B5:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B5:J5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B8:J8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B8:J8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$objPHPExcel->getActiveSheet()->mergeCells('B3:J3');
			$objPHPExcel->getActiveSheet()->setCellValue('B3',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('B4:J4');
			$objPHPExcel->getActiveSheet()->setCellValue('B4',"LAPORAN LIST INDIVIDU");
			$objPHPExcel->getActiveSheet()->mergeCells('B5:J5');
			$objPHPExcel->getActiveSheet()->setCellValue('B5',"CABANG ".strtoupper($data_cabang));
			$objPHPExcel->getActiveSheet()->mergeCells('B6:J6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"TANGGAL GABUNG"." : ".$this->format_date_detail($tglawal,'id',false,'-')." s/d ".$this->format_date_detail($tglakhir,'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('B8',"NO");
			$objPHPExcel->getActiveSheet()->setCellValue('C8',"TANGGAL GABUNG");
			$objPHPExcel->getActiveSheet()->setCellValue('D8',"ID ANGGOTA");
			$objPHPExcel->getActiveSheet()->setCellValue('E8',"NAMA");
			$objPHPExcel->getActiveSheet()->setCellValue('F8',"JENIS KELAMIN");
			$objPHPExcel->getActiveSheet()->setCellValue('G8',"TEMPAT & TANGGAL LAHIR");
			$objPHPExcel->getActiveSheet()->setCellValue('H8',"ALAMAT");
			$objPHPExcel->getActiveSheet()->setCellValue('I8',"NO IDENTITAS");
			$objPHPExcel->getActiveSheet()->setCellValue('J8',"PEKERJAAN");

			$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B8:J8')->getFont()->setBold(true);
			// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			// $objPHPExcel->getActiveSheet()->getStyle('C4:Z4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);


			$ii = 9;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
				if($datas[$i]['jenis_kelamin']=="P"){
					$jenis_kelamin = "Laki-laki";
				}else{
					$jenis_kelamin = "Perempuan";
				}
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$this->format_date_detail($datas[$i]['tgl_gabung'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['cif_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$jenis_kelamin);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['tmp_lahir']." ".$this->format_date_detail($datas[$i]['tgl_lahir'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['alamat']." ".$datas[$i]['rt_rw']." ".$datas[$i]['desa']." ".$datas[$i]['kecamatan']." ".$datas[$i]['kabupaten']." ".$datas[$i]['kodepos']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ",$datas[$i]['no_ktp']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,$datas[$i]['pekerjaan']);

				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$alphabeth = array('B','C','D','E','F','G','H','I','J');
				for ($j=0; $j < count($alphabeth); $j++) { 
					$objPHPExcel->getActiveSheet()->getStyle($alphabeth[$j].$ii.':'.$alphabeth[$j].$ii)->applyFromArray($styleArray);				
				}

				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':J'.$ii)->getFont()->setSize(9);

				$ii++;
			
			}//END FOR*/
			
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT-LIST-INDIVIDU.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

    public function export_list_individu_pdf()
    {
		$tanggal = $this->uri->segment(3);
		$tanggal2 = $this->uri->segment(4);
		$branch_code = $this->uri->segment(5);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($branch_code !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }

		if($tanggal!=""){
		$tgl_ 	 	= substr("$tanggal",0,2);
	    $bln_ 	 	= substr("$tanggal",2,2);
	    $thn_ 	 	= substr("$tanggal",4,4);
	    $tglawal 	= "$thn_-$bln_-$tgl_"; 
		}else{
			$tglawal = "";
		}

		if($tanggal2!=""){
		$tgl__ 	 	= substr("$tanggal2",0,2);
	    $bln__ 	 	= substr("$tanggal2",2,2);
	    $thn__ 	 	= substr("$tanggal2",4,4);
	    $tglakhir 	= "$thn__-$bln__-$tgl__"; 
		}else{
			$tglakhir = "";
		}
        
			$datas = $this->model_laporan_to_pdf->export_list_individu($tglawal,$tglakhir,$branch_code);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            $data['tanggal1_'] = $tglawal;
            $data['tanggal2_'] = $tglakhir;

            $this->load->view('anggota/export_list_individu_pdf',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('LIST-INDIVIDU-"'.$tglawal.'_"'.$tglakhir.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
    }

    /*LAPORAN DATA LENGKAP ANGGOTA*/
    public function data_lengkap_anggota()
    {
		$data['container'] = 'anggota/data_lengkap_anggota';
		$this->load->view('core',$data);
    }

}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */