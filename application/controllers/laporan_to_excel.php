<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_to_excel extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true,'main','back');
		$this->load->model("model_laporan_to_pdf");
		$this->load->model("model_laporan");
		$this->load->model("model_cif");
		$this->load->model("model_transaction");
		$this->load->library('phpexcel');
		$CI =& get_instance();
	}


	/****************************************************************************************/	
	// BEGIN SALDO KAS PERUGAS
	/****************************************************************************************/
	public function export_saldo_kas_petugas()
	{
		$tanggal = $this->uri->segment(3);
		$tanggal2 = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$cabang = $this->uri->segment(4);
		$account_cash_code = $this->uri->segment(5);

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } 
        else if ($tanggal=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
		
				$datas = $this->model_laporan_to_pdf->export_saldo_kas_petugas($cabang,$tanggal2);
				$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);
			
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

			//$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',"LAPORAN TRANSAKSI KAS PETUGAS");
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"NO");
			$objPHPExcel->getActiveSheet()->setCellValue('B2',':  '.$cabang_);
			$objPHPExcel->getActiveSheet()->setCellValue('B3',':  '.$tanggal2);
			$objPHPExcel->getActiveSheet()->setCellValue('B5',"Kas Petugas");
			$objPHPExcel->getActiveSheet()->setCellValue('C5',"Pemegang Kas");
			$objPHPExcel->getActiveSheet()->setCellValue('D5',"Saldo Awal");
			$objPHPExcel->getActiveSheet()->setCellValue('E5',"Mutasi Debet");
			$objPHPExcel->getActiveSheet()->setCellValue('F5',"Mutasi Credit");
			$objPHPExcel->getActiveSheet()->setCellValue('G5',"Saldo Akhir");

			//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);

					
			$ii = 6;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
				$saldoakhir = $datas[$i]['saldoawal']+$datas[$i]['mutasi_debet']-$datas[$i]['mutasi_credit'];

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['account_cash_code']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['saldoawal'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['mutasi_debet']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['mutasi_credit']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$saldoakhir);



				$ii++;
			
			}//END FOR

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_SALDO_KAS_PERUGAS.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END SALDO KAS PERUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN TRANSAKSI KAS PERUGAS
	/****************************************************************************************/
	public function export_transaksi_kas_petugas()
	{

        $account_cash_name  = $this->uri->segment(3);
        $account_cash_name_ = str_replace("%20"," ", $account_cash_name); 
        $pemegeng_kas       = $this->uri->segment(4);
        $pemegeng_kas_ = str_replace("%20"," ", $pemegeng_kas); 
        $tanggal            = $this->uri->segment(5);
        $tanggal_ = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
        $tanggal2           = $this->uri->segment(6); 
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $account_cash_code  = $this->uri->segment(7); 
		
        if ($account_cash_name=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } 
        else if ($tanggal=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
			
				$datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);
			
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

			//$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',"LAPORAN TRANSAKSI KAS PETUGAS");
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Kode Kas");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Pemegang KAs");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('B2',':  	'.$account_cash_name_);
			$objPHPExcel->getActiveSheet()->setCellValue('B3',':  	'.$pemegeng_kas_);
			$objPHPExcel->getActiveSheet()->setCellValue('B4',':  	'.$tanggal_.' sd '.$tanggal2_);
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Debet");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Credit");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Saldo ");

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);

					
			$ii = 7;
			$saldo = (isset($datas[0]['saldoawal']))?$datas[0]['saldoawal']:0;
			for( $i = 0 ; $i < count($datas) ; $i++ ){

				if($datas[$i]['flag_debet_credit']=='D'){
					$saldo += $datas[$i]['trx_debet'];
				}
				if($datas[$i]['flag_debet_credit']=='C'){
					$saldo -= $datas[$i]['trx_credit'];
				}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['description']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['trx_debet'],0,',','.').' ');
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['trx_credit'],0,',','.').' ');
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($saldo,0,',','.').' ');
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);



				$ii++;
			
			}//END FOR

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_TRANSAKSI_KAS_PERUGAS.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END TRANSAKSI KAS PERUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/
	public function export_lap_droping_pembiayaan()
	{
		$from_date 	= $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 	= $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang 	= $this->uri->segment(5);				
		$rembug 	= $this->uri->segment(6);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($from_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else if ($thru_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else
        {				
				
				
					$datas = $this->model_laporan_to_pdf->getReportDropingPembiayaan($cabang,$rembug,$from_date,$thru_date);
		            if ($cabang !='00000') 
		            {
		                $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $data_cabang = "Semua Cabang";
		            }

				
				
			
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Droping Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4',$from_date.' s/d '.$thru_date);
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Tanggal");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Majelis");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:F7');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Petugas");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Plafon");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Tab. 5%");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Cadangan Dana Kebajikan");

		$objPHPExcel->getActiveSheet()->mergeCells('J6:J7');
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Biaya Admin");

		$objPHPExcel->getActiveSheet()->mergeCells('K6:K7');
		$objPHPExcel->getActiveSheet()->setCellValue('K6',"Asuransi Jiwa");

		$objPHPExcel->getActiveSheet()->mergeCells('L6:L7');
		$objPHPExcel->getActiveSheet()->setCellValue('L6',"Asuransi Jaminan");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6:K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L6:L7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);

					
			$ii = 8;
			$row_total = count($datas)+9;


		        $total_pokok                  = 0;
		        $total_pokok_persen           = 0;
		        $total_dana_kebajikan         = 0;
		        $total_biaya_administrasi     = 0;
		        $total_biaya_asuransi_jiwa    = 0;
		        $total_biaya_asuransi_jaminan = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

		        $total_pokok                  += $datas[$i]['pokok'];
		        $total_pokok_persen           += $datas[$i]['pokok']*0.05;
		        $total_dana_kebajikan         += $datas[$i]['dana_kebajikan'];
		        $total_biaya_administrasi     += $datas[$i]['biaya_administrasi'];
		        $total_biaya_asuransi_jiwa    += $datas[$i]['biaya_asuransi_jiwa'];
		        $total_biaya_asuransi_jaminan += $datas[$i]['biaya_asuransi_jaminan'];

				$tab_persen = $datas[$i]['pokok']*0.05;

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$this->format_date_detail($datas[$i]['droping_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,"'".$datas[$i]['account_financing_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($tab_persen,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['dana_kebajikan'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['biaya_administrasi'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii," ".number_format($datas[$i]['biaya_asuransi_jiwa'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii," ".number_format($datas[$i]['biaya_asuransi_jaminan'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':L'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':L'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':L'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_pokok_persen,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_dana_kebajikan,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_total," ".number_format($total_biaya_administrasi,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_total," ".number_format($total_biaya_asuransi_jiwa,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_total," ".number_format($total_biaya_asuransi_jaminan,0,',','.'));

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT-DROPING-PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN DROPING PEMBIAYAAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/
	public function export_list_pengajuan_pembiayaan_kelompok()
	{
		$from_date 	= $this->uri->segment(3);
		$from_date 	= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 	= $this->uri->segment(4);	
		$thru_date 	= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang 	= $this->uri->segment(5);				
		$rembug 	= $this->uri->segment(6);				
		$cif_type 	= $this->uri->segment(7);	

		if ($rembug==false) 
		{
			$rembug = "";
		} 
		else 
		{
			$rembug =	$rembug;			
		}

		$datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan_kelompok($cabang,$from_date,$thru_date,$rembug,$cif_type);
        if ($cabang !='00000') 
        {
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } 
        else 
        {
            $data_cabang = "Semua Cabang";
        }
				
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Pengajuan Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4',$this->format_date_detail($from_date,'id',false,'-').' s/d '.$this->format_date_detail($thru_date,'id',false,'-'));
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"No Registrasi");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Majelis");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"Registrasi");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Rencana Cair");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Jumlah Pengajuan");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Status");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Tanggal Dicairkan");

		$objPHPExcel->getActiveSheet()->mergeCells('J6:J7');
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Jumlah Dicairkan");

		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
					
			$ii = 8;
			$row_total = count($datas)+9;
	        $total_amount      			= 0;
	        $total_jumlah_dicairkan     = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$tanggal_pengajuan = (isset($datas[$i]['tanggal_pengajuan'])) ? $this->format_date_detail($datas[$i]['tanggal_pengajuan'],'id',false,'-') : "" ;
				$rencana_droping = (isset($datas[$i]['rencana_droping'])) ? $this->format_date_detail($datas[$i]['rencana_droping'],'id',false,'-') : "" ;
				$tanggal_dicairkan = (isset($datas[$i]['tanggal_dicairkan'])) ? $this->format_date_detail($datas[$i]['tanggal_dicairkan'],'id',false,'-') : "" ;

		        $total_amount     			+= $datas[$i]['amount'];
		        $total_jumlah_dicairkan    	+= $datas[$i]['jumlah_dicairkan'];

		        if($datas[$i]['amount']==NULL){
		        	$amount = "-";
		        }else{
		        	$amount = number_format($datas[$i]['amount'],0,',','.');
		        }

		        if($datas[$i]['jumlah_dicairkan']==NULL){
		        	$jumlah_dicairkan = "-";
		        }else{
		        	$jumlah_dicairkan = number_format($datas[$i]['jumlah_dicairkan'],0,',','.');
		        }

		        if($datas[$i]['status']=='0'){
		        	$status = "Registrasi";
		        }else if($datas[$i]['status']=='1'){
		        	$status = "Diaktivasi";
		        }else if($datas[$i]['status']=='2'){
		        	$status = "Ditolak";
		        }else if($datas[$i]['status']=='3'){
		        	$status = "Batal";
		        }

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['registration_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$tanggal_pengajuan);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$rencana_droping);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".$amount);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$status);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$tanggal_dicairkan);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".$jumlah_dicairkan);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':J'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':J'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':J'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->getStyle('A'.$row_total.':J'.$row_total)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row_total.':J'.$row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row_total.':J'.$row_total)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_amount,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_total," ".number_format($total_jumlah_dicairkan,0,',','.'));

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-PENGAJUAN-PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

	public function export_list_pengajuan_pembiayaan_individu()
	{
		$from_date = $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
		$cif_type = $this->uri->segment(5);	
		$branch_code = $this->uri->segment(6);	
		$petugas = $this->uri->segment(7);	
		$produk = $this->uri->segment(8);	
		$resort = $this->uri->segment(9);	
		$status = $this->uri->segment(10);	
		$akad = $this->uri->segment(11);
		$pengajuan_melalui = $this->uri->segment(12);
		// echo $akad;die();	
		// $cif_type 	= 1;	
		$datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan_individu($from_date,$thru_date,$cif_type,$branch_code,$petugas,$produk,$resort,$status,$akad,$pengajuan_melalui);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        $resort_name = $this->model_laporan->get_resort_name($resort);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($branch_code !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:R2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A3:R3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan Pengajuan Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A5:R5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5',"Produk : ".$produk_name);
		// $objPHPExcel->getActiveSheet()->mergeCells('A6:J6');
		// $objPHPExcel->getActiveSheet()->setCellValue('A6',"Petugas : ".$petugas_name);
		$objPHPExcel->getActiveSheet()->mergeCells('A6:R6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"Tanggal Pengajuan : ".$this->format_date_detail($from_date,'id',false,'-').' s/d '.$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->setCellValue('A8',"Resort : ".$resort_name);
		$objPHPExcel->getActiveSheet()->mergeCells('A9:A10');
		$objPHPExcel->getActiveSheet()->mergeCells('B9:B10');
		$objPHPExcel->getActiveSheet()->setCellValue('A9',"NO");
		$objPHPExcel->getActiveSheet()->setCellValue('B9',"NO REG");
		$objPHPExcel->getActiveSheet()->mergeCells('C9:C10');
		$objPHPExcel->getActiveSheet()->setCellValue('C9',"TGL REG");
		$objPHPExcel->getActiveSheet()->mergeCells('D9:D10');
		$objPHPExcel->getActiveSheet()->setCellValue('D9',"NIK");
		$objPHPExcel->getActiveSheet()->mergeCells('E9:E10');
		$objPHPExcel->getActiveSheet()->setCellValue('E9',"NAMA");
		$objPHPExcel->getActiveSheet()->setCellValue('F9',"JUMLAH");
		$objPHPExcel->getActiveSheet()->setCellValue('F10',"PENGAJUAN");
		$objPHPExcel->getActiveSheet()->mergeCells('G9:H9');
		$objPHPExcel->getActiveSheet()->setCellValue('G9',"JANGKA WAKTU");	
		$objPHPExcel->getActiveSheet()->setCellValue('G10',"TAHUN");	
		$objPHPExcel->getActiveSheet()->setCellValue('H10',"BULAN");
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"TAKE HOME");
		$objPHPExcel->getActiveSheet()->setCellValue('I10',"PAY");
		$objPHPExcel->getActiveSheet()->mergeCells('J9:J10');
		$objPHPExcel->getActiveSheet()->setCellValue('J9',"ASURANSI");
		$objPHPExcel->getActiveSheet()->setCellValue('K9',"SALDO");
		$objPHPExcel->getActiveSheet()->setCellValue('K10',"{KOMP}");
		$objPHPExcel->getActiveSheet()->setCellValue('L9',"PERUNTUKAN");
		$objPHPExcel->getActiveSheet()->setCellValue('L10',"PEMBIAYAN");
		$objPHPExcel->getActiveSheet()->mergeCells('M9:M10');
		$objPHPExcel->getActiveSheet()->setCellValue('M9',"PRODUK");
		$objPHPExcel->getActiveSheet()->mergeCells('N9:N10');
		$objPHPExcel->getActiveSheet()->setCellValue('N9',"KOPEGTEL");
		$objPHPExcel->getActiveSheet()->setCellValue('O9',"JUMLAH");
		$objPHPExcel->getActiveSheet()->setCellValue('O10',"PENCAIRAN");
		$objPHPExcel->getActiveSheet()->mergeCells('P9:Q9');
		$objPHPExcel->getActiveSheet()->setCellValue('P9',"TANGGAL");
		$objPHPExcel->getActiveSheet()->setCellValue('P10',"PENCAIRAN");
		$objPHPExcel->getActiveSheet()->setCellValue('Q10',"AKAD");
		$objPHPExcel->getActiveSheet()->mergeCells('R9:R10');
		$objPHPExcel->getActiveSheet()->setCellValue('R9',"SUMBER DANA");

		/*$objPHPExcel->getActiveSheet()->mergeCells('G9:G10');
		$objPHPExcel->getActiveSheet()->setCellValue('G9',"Status");
		$objPHPExcel->getActiveSheet()->mergeCells('H9:H10');
		$objPHPExcel->getActiveSheet()->setCellValue('H9',"Tgl Dicairkan");
		$objPHPExcel->getActiveSheet()->mergeCells('I9:I10');
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"Jumlah Dicairkan");
		$objPHPExcel->getActiveSheet()->mergeCells('J9:J10');
		$objPHPExcel->getActiveSheet()->setCellValue('J9',"Produk");*/
		// $objPHPExcel->getActiveSheet()->mergeCells('K9:K10');
		// $objPHPExcel->getActiveSheet()->setCellValue('K9',"Petugas");

		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A9:R9')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A10:R10')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A9:R9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A9:R9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A10:R10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A10:R10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A9:A10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B9:B10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C9:C10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D9:D10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E9:E10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F9:F10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G9:H9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I9:I10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J9:J10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K9:K10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L9:L10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M9:M10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N9:N10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O9:O10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P9:Q10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('Q10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('R9:R10')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('A10:R10')->getFont()->setSize(11);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(14);


		// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);

					
			$ii = 11;
			$row_total = count($datas)+11;
	        $total_amount = 0;
	        $total_jumlah_dicairkan = 0;
	        $array_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$tanggal_pengajuan = (isset($datas[$i]['tanggal_pengajuan'])) ? $this->format_date_detail($datas[$i]['tanggal_pengajuan'],'id',false,'-') : "" ;
				$tanggal_dicairkan = (isset($datas[$i]['tanggal_dicairkan'])) ? $this->format_date_detail($datas[$i]['tanggal_dicairkan'],'id',false,'-') : "" ;

				if($datas[$i]['status']==0){
            		$status = "Registrasi";
				}else if($datas[$i]['status']==1){
            		$status = "Diaktivasi";
				}else if($datas[$i]['status']==2){
            		$status = "Ditolak";
				}else{
            		$status = "Batal";
				}

		        $total_amount     			+= $datas[$i]['amount'];
		        $total_jumlah_dicairkan    	+= $datas[$i]['jumlah_dicairkan'];

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['registration_no']);
				// $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
				// $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$array_hari[date('w',strtotime($datas[$i]['tanggal_pengajuan']))]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$tanggal_pengajuan);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['cif_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,round($datas[$i]['jangka_waktu']/12));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['jangka_waktu']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,"");
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,"");
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,"");
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,$datas[$i]['peruntukan']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,$datas[$i]['pelunasan_ke_kopegtel']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii," ".number_format($datas[$i]['jumlah_dicairkan'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii,$tanggal_dicairkan);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$ii,$tanggal_dicairkan);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$ii,$datas[$i]['fa_name']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':R'.$ii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':B'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':B'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$ii++;
			
			}//END FOR*/

			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_total," ".number_format($total_amount,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row_total," ".number_format($total_jumlah_dicairkan,0,',','.'));
			
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row_total.':O'.$row_total)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row_total.':F'.$row_total)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$row_total.':O'.$row_total)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row_total.':J'.$row_total)->getFont()->setSize(11);

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-PENGAJUAN-PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN PENGAJUAN PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN AGING
	/****************************************************************************************/
	public function export_lap_aging()
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

		/*set header*/
		$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A2:Q2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_data['branch_name']);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:Q3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan Kolektibilitas");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A4:Q4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal ".$desc_date);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);

		/* margined cell of header title */
		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
		$objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"ANGGOTA");
		$objPHPExcel->getActiveSheet()->mergeCells('D6:F6');
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"PENCAIRAN");
		$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"ANGSURAN");
		$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"OUTSTANDING");
		$objPHPExcel->getActiveSheet()->mergeCells('K6:N6');
		$objPHPExcel->getActiveSheet()->setCellValue('K6',"TUNGGAKKAN");
		$objPHPExcel->getActiveSheet()->mergeCells('O6:O7');
		$objPHPExcel->getActiveSheet()->setCellValue('O6',"KOL");
		$objPHPExcel->getActiveSheet()->mergeCells('P6:Q6');
		$objPHPExcel->getActiveSheet()->setCellValue('P6',"CPP");

		/* unmargined cell of header title */
		$objPHPExcel->getActiveSheet()->setCellValue('B7',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Hari");
		$objPHPExcel->getActiveSheet()->setCellValue('L7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('M7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('N7',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('P7',"%");
		$objPHPExcel->getActiveSheet()->setCellValue('Q7',"Nominal");
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getFont()->setSize(10);
		
		/* set border header title */
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6:N6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O6:O7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P6:Q6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P6:Q6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('Q7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);

		/**
		* [BEGIN] INSERT DATA TO CELL
		*/

		$data = $this->model_laporan_to_pdf->get_laporan_par_terhitung($date,$branch_code);
		$no = 0;
		$row = 7;

		/* declare total */
		$total_pokok=0;
		$total_margin=0;
		$total_saldo_pokok=0;
		$total_saldo_margin=0;
		$total_tunggakan_pokok=0;
		$total_tunggakan_margin=0;
		$total_cadangan_piutang=0;

		for ( $i = 0 ; $i < count($data) ; $i++ )
		{
			$result = $data[$i];
			$no++;
			$row++;

			/* akumulasi total */
			$total_pokok+=$result['pokok'];
			$total_margin+=$result['margin'];
			$total_saldo_pokok+=$result['saldo_pokok'];
			$total_saldo_margin+=$result['saldo_margin'];
			$total_tunggakan_pokok+=$result['tunggakan_pokok'];
			$total_tunggakan_margin+=$result['tunggakan_margin'];
			$total_cadangan_piutang+=$result['cadangan_piutang'];

			/* set row value */
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result['account_financing_no'].' ');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,number_format($result['pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,number_format($result['margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row,date('d-m-Y',strtotime($result['droping_date'])));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,number_format($result['angsuran_pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row,number_format($result['angsuran_margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,number_format($result['saldo_pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row,number_format($result['saldo_margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$result['hari_nunggak']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$result['freq_tunggakan']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row,number_format($result['tunggakan_pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row,number_format($result['tunggakan_margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$result['par_desc']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$result['par']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,number_format($result['cadangan_piutang'],0,',','.').' ');
			
			/* set align right for currency */
			$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			/* set align center */
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			/* set font size */
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->setSize(10);

			/* set border */
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray($styleArray);
		}

		/**
		* [END] INSERT DATA TO CELL
		*/

		$row++;

		/**
		* [BEGIN] INSERT TOTAL DATA TO CELL
		*/

		/* set row value */
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,number_format($total_pokok,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,number_format($total_margin,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,number_format($total_saldo_pokok,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$row,number_format($total_saldo_margin,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$row,number_format($total_tunggakan_pokok,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$row,number_format($total_tunggakan_margin,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,number_format($total_cadangan_piutang,0,',','.').' ');
		
		/* set align right for currency */
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		/* set font size */
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':Q'.$row)->getFont()->setSize(10);

		/* set border */
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->applyFromArray($styleArray);


		/**
		* [END] INSERT TOTAL DATA TO CELL
		*/

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REPORT-AGING.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN AGING
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST SALDO TABUNGAN (PEMBIAYAAN)
	/****************************************************************************************/

	public function export_list_saldo_tabungan()
	{
		$branch_code = $this->uri->segment(3);
		$cm_code = $this->uri->segment(4);
		// $datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:K1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:K2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$this->model_laporan->get_branch_name_by_branch_code($branch_code));
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:K3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Daftar Saldo Rekening Anggota");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('A7',"ID");
		$objPHPExcel->getActiveSheet()->setCellValue('B7',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:C7');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Rembug Pusat");

		$objPHPExcel->getActiveSheet()->mergeCells('D6:D7');
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Desa");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Tanggal Ralisasi");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:F7');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Pembiayaan Pokok");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Pembiayaan Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"PYD Ke");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Periode");

		$objPHPExcel->getActiveSheet()->mergeCells('J6:N6');
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Saldo Simpanan");

		$objPHPExcel->getActiveSheet()->setCellValue('J7',"LWK");
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Investasi");
		$objPHPExcel->getActiveSheet()->setCellValue('L7',"Mingguan");
		$objPHPExcel->getActiveSheet()->setCellValue('M7',"Sukarela");
		$objPHPExcel->getActiveSheet()->setCellValue('N7',"Kelompok");

		$objPHPExcel->getActiveSheet()->mergeCells('O6:P6');
		$objPHPExcel->getActiveSheet()->setCellValue('O6',"Saldo Pembiayaan");

		$objPHPExcel->getActiveSheet()->setCellValue('O7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('P7',"Margin");

		// $objPHPExcel->getActiveSheet()->mergeCells('P6:P7');
		// $objPHPExcel->getActiveSheet()->setCellValue('P6',"KD USH");
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:P7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('P6:P7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:M6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);

		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setHeight(0);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(true);
		// $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
		// $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setSize(12);

		$datas = $this->model_laporan->export_list_saldo_tabungan($branch_code,$cm_code);

		$ii=8;
		$total_pokok = 0;
		$total_margin = 0;
		$total_setoran_lwk = 0;
		$total_simpanan_pokok = 0;
		$total_tabungan_minggon = 0;
		$total_tabungan_sukarela = 0;
		$total_tabungan_kelompok = 0;
		$total_saldo_pokok = 0;
		$total_saldo_margin = 0;
		for ( $i = 0 ; $i < count($datas) ; $i++ )
		{

			if (@$datas[$i]['periode_jangka_waktu']=="0") 
			{
				$periode = "Hari";
			} 
			else if (@$datas[$i]['periode_jangka_waktu']=="1") 
			{
				$periode = "Minggu";
			}
			else if (@$datas[$i]['periode_jangka_waktu']=="2") 
			{
				$periode = "Bulan";
			}
			else if (@$datas[$i]['periode_jangka_waktu']=="3") 
			{
				$periode = "Jatuh Tempo";
			}
			else
			{
				$periode = "";
			}
			$total_pokok += $datas[$i]['pokok'];
			$total_margin += $datas[$i]['margin'];
			$total_setoran_lwk += $datas[$i]['setoran_lwk'];
			$total_simpanan_pokok += $datas[$i]['simpanan_pokok'];
			$total_tabungan_minggon += $datas[$i]['tabungan_minggon'];
			$total_tabungan_sukarela += $datas[$i]['tabungan_sukarela'];
			$total_tabungan_kelompok += $datas[$i]['tabungan_kelompok'];
			$total_saldo_pokok += $datas[$i]['saldo_pokok'];
			$total_saldo_margin += $datas[$i]['saldo_margin'];

			$tanggal_mulai_angsur = '';
			if(@$datas[$i]['tanggal_mulai_angsur']==null || @$datas[$i]['tanggal_mulai_angsur']==""){
				$tanggal_mulai_angsur = '';
			}else{
				$tanggal_mulai_angsur = $this->format_date_detail($datas[$i]['tanggal_mulai_angsur'],'id',false,'/');
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,' '.$datas[$i]['cif_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['cm_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['desa']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$tanggal_mulai_angsur);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($datas[$i]['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($datas[$i]['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['pyd_ke']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['jangka_waktu'].' '.$periode);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($datas[$i]['setoran_lwk'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,' '.number_format($datas[$i]['simpanan_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,' '.number_format($datas[$i]['tabungan_minggon'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($datas[$i]['tabungan_sukarela'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($datas[$i]['tabungan_kelompok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,' '.number_format($datas[$i]['saldo_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii,' '.number_format($datas[$i]['saldo_margin'],0,',','.'));

			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':P'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':P'.$ii)->getFont()->setSize(9);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('N'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$ii)->applyFromArray($styleArray);
			
			$ii++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,'Total :');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($total_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($total_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,'');
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,'');
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($total_setoran_lwk,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,' '.number_format($total_simpanan_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,' '.number_format($total_tabungan_minggon,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($total_tabungan_sukarela,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($total_tabungan_kelompok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,' '.number_format($total_saldo_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii,' '.number_format($total_saldo_margin,0,',','.'));

		$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':P'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':P'.$ii)->getFont()->setSize(9);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':I'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':P'.$ii)->getFont()->setBold(true);

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DAFTAR SALDO REKENING ANGGOTA.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN (PEMBIAYAAN)
	/****************************************************************************************/
	


	/****************************************************************************************/	
	// BEGIN LIST OUTSTANDING (PEMBIAYAAN)
	/****************************************************************************************/

	public function export_lap_list_outstanding_pembiayaan_kelompok()
	{		
		$tanggal = $this->current_date();
		$cabang 	= $this->uri->segment(3);				
		$rembug 	= $this->uri->segment(4);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {				
		$datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_kelompok($cabang,$rembug,$tanggal);
        if ($cabang !='00000') 
        {
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } 
        else 
        {
            $data_cabang = "Semua Cabang";
        }

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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:K1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:K2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:K3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Daftar Outstanding Pembiayaan Anggota");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:K4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4',"Tanggal ".$this->format_date_detail($tanggal,'id',false,'-'));
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('A7',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('B7',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:C7');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Rembug");

		$objPHPExcel->getActiveSheet()->mergeCells('D6:D7');
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Desa");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Tanggal Droping");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:F7');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Pokok");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Freq Bayar");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:K6');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Saldo");

		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Freq");
		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('L6:N6');
		$objPHPExcel->getActiveSheet()->setCellValue('L6',"Tertunggak");

		$objPHPExcel->getActiveSheet()->setCellValue('L7',"Freq");
		$objPHPExcel->getActiveSheet()->setCellValue('M7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('N7',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('O6:O7');
		$objPHPExcel->getActiveSheet()->setCellValue('O6',"Kolektibilitas");
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O7')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:O7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:O7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:O7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O6:O7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:K6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);

		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setHeight(0);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(true);
		// $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
		// $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setSize(12);

		$ii = 8;
		$total_pokok            = 0;
        $total_margin           = 0;
        $total_saldo_pokok      = 0;
        $total_saldo_margin     = 0;
        $total_tunggakan_pokok  = 0;
        $total_tunggakan_margin = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

		        $tunggakan_pokok      = $datas[$i]['freq_tunggakan']*$datas[$i]['angsuran_pokok'];
		        $tunggakan_margin     = $datas[$i]['freq_tunggakan']*$datas[$i]['angsuran_margin'];

		        $total_pokok                  += $datas[$i]['pokok'];
		        $total_margin                 += $datas[$i]['margin'];
		        $total_saldo_pokok            += $datas[$i]['saldo_pokok'];
		        $total_saldo_margin           += $datas[$i]['saldo_margin'];
		        $total_tunggakan_pokok        += $tunggakan_pokok;
		        $total_tunggakan_margin       += $tunggakan_margin;

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['account_financing_no'].' ');
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['desa']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,((isset($datas[$i]['droping_date'])==true)?$this->format_date_detail($datas[$i]['droping_date'],'id',false,'-'):''));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['freq_bayar_pokok']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['freq_bayar_margin']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['saldo_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii," ".number_format($datas[$i]['saldo_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,$datas[$i]['freq_tunggakan']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii," ".number_format($tunggakan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii," ".number_format($tunggakan_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,$datas[$i]['status_kolektibilitas']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->getFont()->setSize(9);	

				$ii++;
			
			}//END FOR

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->getFont()->setSize(9);	
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':E'.$ii);
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,'TOTAL :');
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,'');
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,'');
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($total_saldo_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,' '.number_format($total_saldo_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,'');
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($total_tunggakan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($total_tunggakan_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,'');

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST-OUTSTANDING-PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}


	public function export_lap_list_outstanding_pembiayaan_individu()
	{		
		set_time_limit(0);
		$akad = $this->uri->segment(3);	
		$produk_pembiayaan = $this->uri->segment(4);	
		$pengajuan_melalui = $this->uri->segment(5);	
		$peruntukan = $this->uri->segment(6);	
						
		$datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_individu($akad,$produk_pembiayaan,$pengajuan_melalui,$peruntukan);
        $produk_name = $this->model_laporan->get_produk_name($produk_pembiayaan);
        
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A3:S3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan Outstanding Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Produk : ".$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A7:D7');
		$objPHPExcel->getActiveSheet()->setCellValue('A7',"Anggota");
		$objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
		$objPHPExcel->getActiveSheet()->setCellValue('A8',"No Rekening");
		$objPHPExcel->getActiveSheet()->mergeCells('C8:D8');
		$objPHPExcel->getActiveSheet()->setCellValue('C8',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('E7:E8');
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tanggal Droping");

		$objPHPExcel->getActiveSheet()->mergeCells('F7:F8');
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Pokok");

		$objPHPExcel->getActiveSheet()->mergeCells('G7:G8');
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('H7:H8');
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"Freq Bayar");

		$objPHPExcel->getActiveSheet()->mergeCells('I7:J7');
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Saldo");

		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('J8',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('K7:M7');
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Tertunggak");

		$objPHPExcel->getActiveSheet()->setCellValue('K8',"Freq");
		$objPHPExcel->getActiveSheet()->setCellValue('L8',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('M8',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('N7:N8');
		$objPHPExcel->getActiveSheet()->setCellValue('N7',"Saldo Outstanding");

		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:S7')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A7:AB7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:AB7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:AB8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:AB8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:A8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7:B8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C7:C8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7:D8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E7:E8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F7:F8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G7:G8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H7:H8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7:I8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7:J8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7:K8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7:L8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7:M8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7:N8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17);
	
		$ii = 9;
		$total_pokok            = 0;
        $total_margin           = 0;
        $total_saldo_pokok      = 0;
        $total_saldo_margin     = 0;
        $total_tunggakan_pokok  = 0;
        $total_tunggakan_margin = 0;
        $total_saldo_outstanding = 0;

		for( $i = 0 ; $i < count($datas) ; $i++ )
		{

			$check = $this->model_laporan->get_acc_financing_by_no($datas[$i]['account_financing_no']);
	        $counter_angsuran = ($check['counter_angsuran'] > 0) ? $check['counter_angsuran']+1 : $check['counter_angsuran'];
	        $sisa_counter = ($check['sisa_counter'] > 0 ) ? $check['sisa_counter']-1 : $check['sisa_counter'];
	        $tunggakan_pokok      = $sisa_counter * $datas[$i]['angsuran_pokok'];
	        $tunggakan_margin     = $sisa_counter * $datas[$i]['angsuran_margin'];
	        $saldo_outstanding	  = $tunggakan_margin + $row['saldo_pokok'];
	        $droping_date = (isset($datas[$i]['droping_date'])==true)?$this->format_date_detail($datas[$i]['droping_date'],'id',false,'-'):'';

	        $total_pokok                  += $datas[$i]['pokok'];
	        $total_margin                 += $datas[$i]['margin'];
	        $total_saldo_pokok            += $datas[$i]['saldo_pokok'];
	        $total_saldo_margin           += $datas[$i]['saldo_margin'];
	        $total_tunggakan_pokok        += $tunggakan_pokok;
	        $total_tunggakan_margin       += $tunggakan_margin;
	        $total_saldo_outstanding      += $saldo_outstanding;

			$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':B'.$ii);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['account_financing_no'].' ');
			$objPHPExcel->getActiveSheet()->mergeCells('C'.$ii.':D'.$ii);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$droping_date);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$counter_angsuran);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['saldo_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['saldo_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,$sisa_counter);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii," ".number_format($tunggakan_pokok,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii," ".number_format($tunggakan_margin,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii," ".number_format($saldo_outstanding,0,',','.'));
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':AB'.$ii)->getFont()->setSize(9);

			$ii++;
		
		}
		//END FOR

		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':S'.$ii)->getFont()->setSize(9);	
		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':S'.$ii)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':E'.$ii);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,'TOTAL :');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($total_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($total_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,'');
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,' '.number_format($total_saldo_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($total_saldo_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,'');
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,' '.number_format($total_tunggakan_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($total_tunggakan_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($total_saldo_outstanding,0,',','.'));

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST-OUTSTANDING-PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/****************************************************************************************/	
	// END LIST SALDO TABUNGAN (PEMBIAYAAN)
	/****************************************************************************************/
	


	/*
	EXPORT TO EXCEL LIST TAGIHAN & PELUNASAN, created by dickysigma@gmail.com
	*/
	public function export_list_tagihan()
	{
		set_time_limit(0);
		$from_date = $this->uri->segment(3);
		$from_date 	= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);
		$thru_date 	= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);	
		$akad = $this->uri->segment(5);	
		$produk_pembiayaan = $this->uri->segment(6);
		$status_telkom = $this->uri->segment(7);
		$code_divisi = $this->uri->segment(8);

		$datas = $this->model_laporan_to_pdf->export_list_tagihan($from_date,$thru_date,$akad,$produk_pembiayaan,$status_telkom,$code_divisi);
		
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
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'd3d3d3')
		        )
		    );

		$objPHPExcel->getActiveSheet()->setCellValue('A1',"No Pembiayaan");
		$objPHPExcel->getActiveSheet()->setCellValue('B1',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('C1',"Nama Pegawai");
		$objPHPExcel->getActiveSheet()->setCellValue('D1',"Product Name");
		$objPHPExcel->getActiveSheet()->setCellValue('E1',"Jumlah Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('F1',"Realisasi Tagihan");

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

		$ii=2;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			//proses 1
			$_is_verified = $this->model_transaction->cek_unverified_transaction($datas[$i]['account_financing_no']);
			if ($_is_verified==true && $datas[$i]['sisa_angsuran'] !== '0'):

				//proses 2
				$data_akad = $this->model_transaction->get_akad_pembiayaan($datas[$i]['account_financing_no']);

				if($data_akad['akad_code']=='MDA' || $data_akad['akad_code']=='MSA'){
					$flag_jadwal_angsuran = "";
					$saldo_pokok = "";
				}else{
					$data_flag = $this->model_transaction->get_flag_jadwal_angsuran($datas[$i]['account_financing_no']);
					$flag_jadwal_angsuran = $data_flag['flag_jadwal_angsuran'];
					$saldo_pokok = $data_flag['saldo_pokok'];

					if($flag_jadwal_angsuran == "0"){
						$data_cif1 = $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($datas[$i]['account_financing_no']);
						$angsuran_pokok = $data_cif1['angsuran_pokok'];
						$angsuran_margin = $data_cif1['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif1['angsuran_tabungan'];
					}else{
						$data_cif2 = $this->model_transaction->get_cif_for_pembayaran_angsuran($datas[$i]['account_financing_no']);
						$angsuran_pokok = $data_cif2['angsuran_pokok'];
						$angsuran_margin = $data_cif2['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif2['angsuran_catab'];
					}
				}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $datas[$i]['account_financing_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $datas[$i]['cif_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $total_angsuran);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, "");

				$ii++;

			endif;
		}

		$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST-TAGIHAN-DOWNLOADED-'.date('dmY').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_list_pelunasan()
	{
		set_time_limit(0);
		$from_date = $this->uri->segment(3);
		$from_date 	= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);
		$thru_date 	= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);	
		$akad = $this->uri->segment(5);	
		$produk_pembiayaan = $this->uri->segment(6);

		$datas = $this->model_laporan_to_pdf->export_list_tagihan($from_date,$thru_date,$akad,$produk_pembiayaan);

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
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'd3d3d3')
		        )
		    );

		$objPHPExcel->getActiveSheet()->setCellValue('A1',"No Pembiayaan");
		$objPHPExcel->getActiveSheet()->setCellValue('B1',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('C1',"Nama Pegawai");
		$objPHPExcel->getActiveSheet()->setCellValue('D1',"Product Name");
		$objPHPExcel->getActiveSheet()->setCellValue('E1',"Jumlah Angsuran");

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

		$ii=2;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			//proses 1
			$_is_verified = $this->model_transaction->cek_unverified_transaction($datas[$i]['account_financing_no']);
			if ($_is_verified==true && $datas[$i]['sisa_angsuran'] == '0'):

				//proses 2
				$data_akad = $this->model_transaction->get_akad_pembiayaan($datas[$i]['account_financing_no']);

				if($data_akad['akad_code']=='MDA' || $data_akad['akad_code']=='MSA'){
					$flag_jadwal_angsuran = "";
					$saldo_pokok = "";
				}else{
					$data_flag = $this->model_transaction->get_flag_jadwal_angsuran($datas[$i]['account_financing_no']);
					$flag_jadwal_angsuran = $data_flag['flag_jadwal_angsuran'];
					$saldo_pokok = $data_flag['saldo_pokok'];

					if($flag_jadwal_angsuran == "0"){
						$data_cif1 = $this->model_transaction->get_cif_for_pembayaran_angsuran_non_reguler($datas[$i]['account_financing_no']);
						$angsuran_pokok = $data_cif1['angsuran_pokok'];
						$angsuran_margin = $data_cif1['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif1['angsuran_tabungan'];
					}else{
						$data_cif2 = $this->model_transaction->get_cif_for_pembayaran_angsuran($datas[$i]['account_financing_no']);
						$angsuran_pokok = $data_cif2['angsuran_pokok'];
						$angsuran_margin = $data_cif2['angsuran_margin'];
						$total_angsuran = $angsuran_pokok+$angsuran_margin+$data_cif2['angsuran_catab'];
					}
				}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $datas[$i]['account_financing_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $datas[$i]['cif_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $total_angsuran);

				$ii++;

			endif;
		}

		$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST-PELUNASAN-DOWNLOADED-'.date('dmY').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	/*
	END LIST TAGIGAN
	*/


	/****************************************************************************************/	
	// BEGIN LIST JATUH TEMPO
	/****************************************************************************************/
	public function export_list_jatuh_tempo()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$cabang = $this->uri->segment(5);		
		$petugas = $this->uri->segment(6);				
		$produk = $this->uri->segment(7);	
        $akad = $this->uri->segment(8);   
        $pengajuan_melalui = $this->uri->segment(9);   
		
		$datas = $this->model_laporan_to_pdf->export_list_jatuh_tempo($tanggal1_,$tanggal2_,$cabang,$petugas,$produk,$akad,$pengajuan_melalui);
		$produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        // $resort_name = $this->model_laporan->get_resort_name($resort);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
			
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan Jatuh Tempo Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4','Produk :'.$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5','Petugas :'.$petugas_name);
		
		// $objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
		// $objPHPExcel->getActiveSheet()->setCellValue('A6','Resort :'.$resort_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A7:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('A7','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);

		$objPHPExcel->getActiveSheet()->setCellValue('A8',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B8',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('C8',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('D8',"Produk");
		$objPHPExcel->getActiveSheet()->setCellValue('E8',"Plafon");
		$objPHPExcel->getActiveSheet()->setCellValue('F8',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('G8',"Jangka Waktu");
		$objPHPExcel->getActiveSheet()->setCellValue('H8',"Tgl. Droping");
		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Tgl. Jtempo");
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('A8:B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G8:I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
					
		$ii = 9;

		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
	          if ($datas[$i]['periode_jangka_waktu']=="0") 
	          {
	            $periode = "Hari";
	          } 
	          else if ($datas[$i]['periode_jangka_waktu']=="1") 
	          {
	            $periode = "Minggu";
	          }
	          else if ($datas[$i]['periode_jangka_waktu']=="2") 
	          {
	            $periode = "Bulan";
	          }
	          else if ($datas[$i]['periode_jangka_waktu']=="3") 
	          {
	            $periode = "Jatuh Tempo";
	          }

	          //Sisa angsuran
	          // $sisa_angsuran = $datas[$i]['saldo_pokok']/$datas[$i]['angsuran_pokok'];
	          // $sisa = ceil($sisa_angsuran);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".$datas[$i]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($datas[$i]['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['jangka_waktu']." ".$periode);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$this->format_date_detail($datas[$i]['droping_date'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$this->format_date_detail($datas[$i]['tanggal_jtempo'],'id',false,'-'));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':I'.$ii)->getFont()->setSize(9);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':B'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':I'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$ii++;
		
		}
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="list_jatuh_tempo_pembiayaan.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LIST JATUH TEMPO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/
	public function list_pelunasan_pembiayaan_kelompok()
	{
		$tanggal1 		= $this->uri->segment(3);
		$tanggal1__ 	= substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ 		= substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 		= $this->uri->segment(4);
		$tanggal2__ 	= substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ 		= substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$cabang 		= $this->uri->segment(5);
		$rembug 	= $this->uri->segment(6);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } 
        else if ($tanggal1=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
		
				$datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan_kelompok($cabang,$tanggal1_,$tanggal2_,$rembug);
				if ($cabang !='00000') 
		            {
		                $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $data_cabang = "Semua Cabang";
		            }
			
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Pelunasan Pembiayaan Kelompok");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Tanggal");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Nama Rembug");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:G6');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Plafon");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Jangka Waktu");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:K6');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Saldo Hutang");
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Cnt");
		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Margin");

		// $objPHPExcel->getActiveSheet()->mergeCells('L6:L7');
		// $objPHPExcel->getActiveSheet()->setCellValue('L6',"Muqassah");

		// $objPHPExcel->getActiveSheet()->mergeCells('M6:M7');
		// $objPHPExcel->getActiveSheet()->setCellValue('M6',"Jatuh Tempo");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:K6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6:K7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('L6:L7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('M6:M7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

					
			$ii = 8;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		          if ($datas[$i]['periode_jangka_waktu']=="0") 
		          {
		            $periode = "Hari";
		          } 
		          else if ($datas[$i]['periode_jangka_waktu']=="1") 
		          {
		            $periode = "Minggu";
		          }
		          else if ($datas[$i]['periode_jangka_waktu']=="2") 
		          {
		            $periode = "Bulan";
		          }
		          else if ($datas[$i]['periode_jangka_waktu']=="3") 
		          {
		            $periode = "Jatuh Tempo";
		          }

		          //Sisa angsuran
		          $cnt = $datas[$i]['saldo_pokok']/$datas[$i]['angsuran_pokok'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$this->format_date_detail($datas[$i]['tanggal_lunas'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,"'".$datas[$i]['account_financing_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['jangka_waktu']." ".$periode);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$cnt);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,number_format($datas[$i]['saldo_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,number_format($datas[$i]['saldo_margin'],0,',','.'));
				// $objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,number_format($datas[$i]['potongan_margin'],0,',','.'));
				// $objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,$this->format_date_detail($datas[$i]['tanggal_jtempo'],'id',false,'-'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$ii.':K'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('L'.$ii.':L'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('M'.$ii.':M'.$ii)->applyFromArray($styleArray);



				$ii++;
			
			}
			//END FOR

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="list_jatuh_tempo_pembiayaan_kelompok.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}

	public function list_pelunasan_pembiayaan_individu()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$branch_code = $this->uri->segment(5);
		$petugas = $this->uri->segment(6);
		$produk = $this->uri->segment(7);
		$datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan_individu($tanggal1_,$tanggal2_,$branch_code,$petugas,$produk);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($branch_code !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Pelunasan Pembiayaan Individu");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4','Produk :'.$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5','Petugas :'.$petugas_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);

		$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
		$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
		$objPHPExcel->getActiveSheet()->setCellValue('A8',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B8',"Tanggal");

		$objPHPExcel->getActiveSheet()->mergeCells('C8:E8');
		$objPHPExcel->getActiveSheet()->setCellValue('C8',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('C9',"No. Rekening");
		$objPHPExcel->getActiveSheet()->mergeCells('D9:E9');
		$objPHPExcel->getActiveSheet()->setCellValue('D9',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
		$objPHPExcel->getActiveSheet()->setCellValue('F8',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('F9',"Plafon");
		$objPHPExcel->getActiveSheet()->setCellValue('G9',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('H8:H9');
		$objPHPExcel->getActiveSheet()->setCellValue('H8',"Jangka Waktu");

		$objPHPExcel->getActiveSheet()->mergeCells('I8:K8');
		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Saldo Hutang");
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"Cnt");
		$objPHPExcel->getActiveSheet()->setCellValue('J9',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('K9',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
		$objPHPExcel->getActiveSheet()->setCellValue('L8',"Muqassah");

		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A8:L8')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A9:L9')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A8:L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:L8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A9:L9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:L8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A9:L9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D8:D9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E8:E9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F8:F9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G8:G9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H8:H9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I8:I9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A8:B8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J8:K8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A8:A9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B8:B9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K8:K9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L8:L9')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('M6:M7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
					
		$ii = 8;

		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
	          if ($datas[$i]['periode_jangka_waktu']=="0") 
	          {
	            $periode = "Hari";
	          } 
	          else if ($datas[$i]['periode_jangka_waktu']=="1") 
	          {
	            $periode = "Minggu";
	          }
	          else if ($datas[$i]['periode_jangka_waktu']=="2") 
	          {
	            $periode = "Bulan";
	          }
	          else if ($datas[$i]['periode_jangka_waktu']=="3") 
	          {
	            $periode = "Jatuh Tempo";
	          }

	          //Sisa angsuran
	          $cnt = $datas[$i]['saldo_pokok']/$datas[$i]['angsuran_pokok'];

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$this->format_date_detail($datas[$i]['tanggal_lunas'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,"'".$datas[$i]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nama']);
			// $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['cm_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,number_format($datas[$i]['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['jangka_waktu']." ".$periode);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$cnt);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,number_format($datas[$i]['saldo_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,number_format($datas[$i]['saldo_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,number_format($datas[$i]['potongan_margin'],0,',','.'));
			// $objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,$this->format_date_detail($datas[$i]['tanggal_jtempo'],'id',false,'-'));

			$objPHPExcel->getActiveSheet()->mergeCells('D'.$ii.':E'.$ii);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
			// $objPHPExcel->getActiveSheet()->getStyle('M'.$ii.':M'.$ii)->applyFromArray($styleArray);
			$ii++;
		
		}
		//END FOR

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="list_jatuh_tempo_pembiayaan_kelompok.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LIST PELUNASAN PEMBIAYAAN
	/****************************************************************************************/



	/****************************************************************************************/	
	// BEGIN LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/
	public function export_list_registrasi_pembiayaan()
	{
		$produk 		= $this->uri->segment(3);
		$tanggal1 		= $this->uri->segment(4);
		$tanggal1__ 	= substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ 		= substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 		= $this->uri->segment(5);
		$tanggal2__ 	= substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ 		= substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$cabang 		= $this->uri->segment(6);
		$akad 		= $this->uri->segment(7);
		$pengajuan_melalui 		= $this->uri->segment(8);
		if ($cabang !='00000'){
            $datacabang = "CABANG ".$this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $datacabang = "SEMUA CABANG";
        }
		$datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($produk,$tanggal1_,$tanggal2_,$cabang,$akad,$pengajuan_melalui);

		// if($produk==1){
		// 	$produk = "Individu";
		// }else if($produk==0){
		// 	$produk = "Kelompok";
		// }else{
		// 	$produk = "Kelompok & Individu";
		// }
			
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',"Laporan Registrasi Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',$datacabang);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// $objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		// $objPHPExcel->getActiveSheet()->setCellValue('E3',"Jenis Produk : ".$produk);
		// $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"No. Rekening");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:C7');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('D6:D7');
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Tgl. Reg.");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Plafon");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:F7');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"ANGSURAN");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"Margin");
		// $objPHPExcel->getActiveSheet()->setCellValue('I7',"Catab");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Total");

		$objPHPExcel->getActiveSheet()->mergeCells('J6:J7');
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Jangka Waktu");

		$objPHPExcel->getActiveSheet()->mergeCells('K6:K7');
		$objPHPExcel->getActiveSheet()->setCellValue('K6',"Status Rekening");

		$objPHPExcel->getActiveSheet()->mergeCells('L6:L7');
		$objPHPExcel->getActiveSheet()->setCellValue('L6',"Produk");
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L7')->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:I6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6:K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L6:L7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(35);

					
			$ii = 8;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		          if ($datas[$i]['periode_jangka_waktu']=="0") 
		          {
		            $periode = "Hari";
		          } 
		          else if ($datas[$i]['periode_jangka_waktu']=="1") 
		          {
		            $periode = "Minggu";
		          }
		          else if ($datas[$i]['periode_jangka_waktu']=="2") 
		          {
		            $periode = "Bulan";
		          }
		          else if ($datas[$i]['periode_jangka_waktu']=="3") 
		          {
		            $periode = "Jatuh Tempo";
		          }

		          if($datas[$i]['status_rekening']=="0"){
		          	$status = "Registrasi";
		          }else if($datas[$i]['status_rekening']=="1"){
		          	$status = "Aktif";
		          }else if($datas[$i]['status_rekening']=="2"){
		          	$status = "Lunas";
		          }else{
		          	$status = "Verifikasi";
		          }

		          if($datas[$i]['tanggal_registrasi']!=""){
		          	$tanggal_registrasi = $this->format_date_detail($datas[$i]['tanggal_registrasi'],'id',false,'-');
		          }else{
		          	$tanggal_registrasi = "-";
		          }

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['account_financing_no']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$tanggal_registrasi);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['angsuran_pokok']+$datas[$i]['angsuran_margin']+$datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,$datas[$i]['jangka_waktu']." ".$periode);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,$status);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,$datas[$i]['product_name']);
				// $objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));

				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':M'.$ii)->getFont()->setSize(9);
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('K'.$ii.':K'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('L'.$ii.':L'.$ii)->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$ii++;
			
			}
			//END FOR

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-REGISTRASI-PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LIST REGISTRASI PEMBIAYAAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP OUTSTANDING BY DESA
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_desa()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_outstanding_piutang_by_desa();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Berdasarkan DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"POKOK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"MARGIN");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['desa']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['margin'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP OUTSTANDING BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP OUTSTANDING BY REMBUG
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_rembug()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_outstanding_piutang_by_rembug();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Berdasarkan REMBUG");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"POKOK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"MARGIN");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['margin'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP OUTSTANDING BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP OUTSTANDING BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_petugas()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_outstanding_piutang_by_petugas();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Berdasarkan PETUGAS");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"POKOK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"MARGIN");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['margin'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP OUTSTANDING BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_outstanding_piutang_by_peruntukan()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_outstanding_piutang_by_peruntukan();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Berdasarkan PERUNTUKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"POKOK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"MARGIN");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				if($datas[$i]['peruntukan']=='1')
				{
					$peruntukan[$i]="Modal Kerja";
				}
				elseif($datas[$i]['peruntukan']=='2')
				{
					$peruntukan[$i]="Konsumtif";
				}
				elseif($datas[$i]['peruntukan']=='3')
				{
					$peruntukan[$i]="Investasi";
				}
				else
				{
					$peruntukan="-";
				}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$peruntukan[$i]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['margin'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP OUTSTANDING BY PERUNTUKAN
	/****************************************************************************************/

	

	/****************************************************************************************/	
	// BEGIN REKAP PENCAIRAN PEMBIAYAAN BY DESA
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_desa()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_desa();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"NOMINAL");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['desa']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['amount'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN BY DESA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENGAJUAN PEMBIAYAAN BY REMBUG
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_rembug()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_rembug();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"NOMINAL");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['amount'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN BY REMBUG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENCAIRAN PEMBIAYAAN BY PETUGAS
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_petugas()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_petugas();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"NOMINAL");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['amount'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN BY PETUGAS
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENCAIRAN PEMBIAYAAN BY PERUNTUKAN
	/****************************************************************************************/
	public function export_rekap_pencairan_pembiayaan_by_peruntukan()
	{
		/*$desa_code = $this->uri->segment(3);

		if ($desa_code=="") 
        {            
         echo "<script>alert('Parameter Belum Lengkap !');javascript:window.close();</script>";
        } 
        else
        {*/
		
				$datas = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_peruntukan();
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan DESA");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"KODE");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"KETERANGAN");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"JUMLAH");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"NOMINAL");

			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				if($datas[$i]['peruntukan']=='1')
				{
					$peruntukan[$i]="Modal Kerja";
				}
				elseif($datas[$i]['peruntukan']=='2')
				{
					$peruntukan[$i]="Konsumtif";
				}
				elseif($datas[$i]['peruntukan']=='3')
				{
					$peruntukan[$i]="Investasi";
				}
				else
				{
					$peruntukan="-";
				}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$peruntukan[$i]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($datas[$i]['amount'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		/*}*/
	}
	/****************************************************************************************/	
	// END REKAP PENCAIRAN PEMBIAYAAN BY PERUNTUKAN
	/****************************************************************************************/


	public function export_list_transaksi_rembug()
	{

		$branch_code = $this->uri->segment(3);
		$from_trx_date = $this->datepicker_convert(false,$this->uri->segment(4));
		$thru_trx_date = $this->datepicker_convert(false,$this->uri->segment(5));
		$cm_code = $this->uri->segment(6);
		if($branch_code!='00000'){
			$branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
		}else{
			$branch_id = $branch_code;
		}

		$branch = $this->model_cif->get_branch_by_branch_id($branch_id);
		if($cm_code==false){
			$rembug['cm_code'] = false;
			$rembug['cm_name'] = 'Semua Rembug';
		}else{
			$rembug = $this->model_cif->get_cm_by_cm_code($cm_code);
		}

		$datas = $this->model_laporan->export_list_transaksi_rembug($branch_id,$cm_code,$from_trx_date,$thru_trx_date);
		
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

		$objPHPExcel->getActiveSheet()->getStyle('A6:O28')->getFont()->setSize(8);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:O7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('A3',"LAPORAN TRANSAKSI REMBUG");
		$objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
		$objPHPExcel->getActiveSheet()->getStyle('A3:C4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A3:C4')->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"BRANCH");
		$objPHPExcel->getActiveSheet()->setCellValue('B4',":");
		$objPHPExcel->getActiveSheet()->setCellValue('C4',$branch['branch_name']);
		
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"ID");
		$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('A7',"ANGGOTA");
		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('B7',"PYD");
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"NAMA");
		$objPHPExcel->getActiveSheet()->mergeCells('C6:C7');
		$objPHPExcel->getActiveSheet()->getStyle('C6:C7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('D6',"ANGSURAN");
		$objPHPExcel->getActiveSheet()->mergeCells('D6:G6');
		$objPHPExcel->getActiveSheet()->getStyle('D6:G6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Freq");
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('E7',"Pokok");
		$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Margin");
		$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Catab");
		$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Setoran");
		$objPHPExcel->getActiveSheet()->mergeCells('H6:K6');
		$objPHPExcel->getActiveSheet()->getStyle('H6:K6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('H7',"LWK");
		$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Sukarela");
		$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Wajib");
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('K7',"Kelompok");
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('L6',"Penarikan");
		$objPHPExcel->getActiveSheet()->getStyle('L6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('L7',"Sukarela");
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('M6',"REALISASI PEMBIAYAAN");
		$objPHPExcel->getActiveSheet()->mergeCells('M6:O6');
		$objPHPExcel->getActiveSheet()->getStyle('M6:O6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('M7',"Plafon");
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('N7',"Adm.");
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('O7',"Asuransi");
		$objPHPExcel->getActiveSheet()->getStyle('O7')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(11.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(11.29);


		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

		// $objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
		
		// $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

		// $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

		// $objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
		$ii = 8;
		// echo "<pre>";
		// print_r($datas);
		// die();
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{


			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,'Rembug');
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,': '.$datas[$i]['cm_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,'Tanggal Bayar');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,': '.$datas[$i]['trx_date']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(8);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$ii.':C'.$ii);
			$objPHPExcel->getActiveSheet()->mergeCells('E'.$ii.':F'.$ii);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->applyFromArray(array(
	       		'borders' => array(
			             'right' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			             'left' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			       ),
			));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,'Petugas');
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,': '.$datas[$i]['fa_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,'Tanggal');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,': '.$this->format_date_detail($datas[$i]['created_date'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(8);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$ii.':C'.$ii);
			$objPHPExcel->getActiveSheet()->mergeCells('E'.$ii.':F'.$ii);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->applyFromArray(array(
	       		'borders' => array(
			             'right' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			             'left' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			       ),
			));
			$ii++;
			
			$datass = $this->model_laporan->export_list_transaksi_rembug_sub($datas[$i]['trx_cm_id'],$from_trx_date,$thru_trx_date,$datas[$i]['trx_date']);

			$total_angsuran_pokok = 0;
			$total_angsuran_margin = 0;
			$total_angsuran_catab = 0;
			$total_setoran_lwk = 0;
			$total_tab_sukarela_cr = 0;
			$total_minggon = 0;
			$total_tab_wajib_cr = 0;
			$total_kelompok = 0;
			$total_tab_sukarela_db = 0;
			$total_pokok = 0;
			$total_administrasi = 0;
			$total_asuransi = 0;

			for ( $j = 0 ; $j < count($datass) ; $j++ )
			{

				$total_angsuran_pokok += ($datass[$j]['freq']*$datass[$j]['angsuran_pokok']);
				$total_angsuran_margin += ($datass[$j]['freq']*$datass[$j]['angsuran_margin']);
				$total_angsuran_catab += ($datass[$j]['freq']*$datass[$j]['angsuran_catab']);
				$total_setoran_lwk += $datass[$j]['setoran_lwk'];
				$total_tab_sukarela_cr += $datass[$j]['tab_sukarela_cr'];
				$total_minggon += $datass[$j]['minggon'];
				$total_tab_wajib_cr += ($datass[$j]['freq']*$datass[$j]['tab_wajib_cr']);
				$total_kelompok += ($datass[$j]['freq']*$datass[$j]['tab_kelompok_cr']);
				$total_tab_sukarela_db += $datass[$j]['tab_sukarela_db'];
				$total_pokok += $datass[$j]['pokok'];
				$total_administrasi += $datass[$j]['administrasi']; 
				$total_asuransi += $datass[$j]['asuransi'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datass[$j]['cif_no'].' ');
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,'');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datass[$j]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datass[$j]['freq']); 
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,' '.number_format($datass[$j]['angsuran_pokok'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($datass[$j]['angsuran_margin'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($datass[$j]['angsuran_catab'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,' '.number_format($datass[$j]['setoran_lwk'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,' '.number_format($datass[$j]['tab_sukarela_cr'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($datass[$j]['tab_wajib_cr'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,' '.number_format($datass[$j]['tab_kelompok_cr'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,' '.number_format($datass[$j]['tab_sukarela_db'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($datass[$j]['pokok'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($datass[$j]['administrasi'],0,',','.'));   
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,' '.number_format($datass[$j]['asuransi'],0,',','.'));   

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->getFont()->setSize(8);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('M'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->applyFromArray($styleArray);
				$ii++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'Total');
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,' '.number_format($total_angsuran_pokok,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($total_angsuran_margin,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,' '.number_format($total_angsuran_catab,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,' '.number_format($total_setoran_lwk,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,' '.number_format($total_tab_sukarela_cr,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,' '.number_format($total_tab_wajib_cr,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,' '.number_format($total_kelompok,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,' '.number_format($total_tab_sukarela_db,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,' '.number_format($total_pokok,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,' '.number_format($total_administrasi,0,',','.'));   
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,' '.number_format($total_asuransi,0,',','.'));  

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('N'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->getFont()->setSize(8);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':O'.$ii)->applyFromArray(array(
	       		'borders' => array(
			             'right' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			             'left' => array(
			                    'style' => PHPExcel_Style_Border::BORDER_THIN,
			                    'color' => array('rgb' => '000000'),
			             ),
			       ),
			));
			// $objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$ii++;
		
		}//END FOR

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}



	/****************************************************************************************/	
	// BEGIN REKAP JATUH TEMPO BY CABANG
	/****************************************************************************************/
		//semua cabang
		public function export_rekap_jatuh_tempo_semua_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_semua_cabang($tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_cabang.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY cabang
		public function export_rekap_jatuh_tempo_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_cabang($cabang,$tanggal1_,$tanggal2_);
			    $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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


				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Cabang");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_cabang.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY rembug
		public function export_rekap_jatuh_tempo_rembug()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_rembug($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Rembug");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Rembug");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_rembug.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Petugas
		public function export_rekap_jatuh_tempo_petugas()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_petugas($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Petugas");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Petugas");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_petugas.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Peruntukan
		public function export_rekap_jatuh_tempo_peruntukan()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_peruntukan($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Peruntukan");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Peruntukan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['display_text']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_peruntukan.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Resort
		public function export_rekap_jatuh_tempo_resort()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_resort($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Resort");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Resort");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['resort_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_resort.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	/****************************************************************************************/	
	// END REKAP JATUH TEMPO BY CABANG
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN REKAP PENGAJUAN PEMBIAYAAN BY CABANG
	/****************************************************************************************/
		//semua cabang
		public function export_rekap_pengajuan_pembiayaan_semua_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_semua_cabang($tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".$total_pokok);

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY cabang
		public function export_rekap_pengajuan_pembiayaan_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_cabang($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}



		//BY rembug
		public function export_rekap_pengajuan_pembiayaan_rembug()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_rembug($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Rembug");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Petugas
		public function export_rekap_pengajuan_pembiayaan_petugas()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_petugas($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Petugas");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Peruntukan
		public function export_rekap_pengajuan_pembiayaan_peruntukan()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_peruntukan($cabang,$tanggal1_,$tanggal2_);
			    $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Peruntukan");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['display_text']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Resort
		public function export_rekap_pengajuan_pembiayaan_resort()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_resort($cabang,$tanggal1_,$tanggal2_);
			    $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Resort");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['resort_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		// ----------------------------------------------------------------------
		// END REPORT PENGAJUAN PEMBIAYAAN
		// ----------------------------------------------------------------------

		/****************************************************************************************/	
		// BEGIN REKAP PENCAIRAN PEMBIAYAAN BY CABANG
		/****************************************************************************************/
		//semua cabang
		public function export_rekap_pencairan_pembiayaan_semua_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_semua_cabang($tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}



		//BY cabang
		public function export_rekap_pencairan_pembiayaan_cabang()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_cabang($cabang,$tanggal1_,$tanggal2_);
				$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}



		//BY rembug
		public function export_rekap_pencairan_pembiayaan_rembug()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_rembug($cabang,$tanggal1_,$tanggal2_);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Rembug");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['amount'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Petugas
		public function export_rekap_pencairan_pembiayaan_petugas()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_petugas($cabang,$tanggal1_,$tanggal2_);
				$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Cabang");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Peruntukan
		public function export_rekap_pencairan_pembiayaan_peruntukan()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_peruntukan($cabang,$tanggal1_,$tanggal2_);
				$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Peruntukan");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['display_text']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Resort
		public function export_rekap_pencairan_pembiayaan_resort()
		{
			$tanggal1       = $this->uri->segment(3);
	        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
	        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
	        $tanggal2       = $this->uri->segment(4);
	        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
	        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
	        $cabang         = $this->uri->segment(5);       
	            if ($cabang==false) 
	            {
	                $cabang = "00000";
	            } 
	            else 
	            {
	                $cabang =   $cabang;            
	            }

	       if ($tanggal1=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else if ($tanggal2=="")
	        {
	         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
	        }
	        else
	        {
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_resort($cabang,$tanggal1_,$tanggal2_);
				$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Resort");
				$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
				// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=$datas[$i]['total'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['resort_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

				}

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		// ----------------------------------------------------------------------
		// END REPORT PENCAIRAN PEMBIAYAAN
		// ----------------------------------------------------------------------

		/****************************************************************************************/	
		// BEGIN REKAP OUTSTANDING PEMBIAYAAN BY CABANG
		/****************************************************************************************/
		//semua cabang
		public function export_rekap_outstanding_pembiayaan_semua_cabang()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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


				$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Cabang");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");

				$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':E'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':E'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':E'.$ii)->getFont()->setSize(10);
		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}



		//BY cabang
		public function export_rekap_outstanding_pembiayaan_cabang()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }
	        
	            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_cabang($cabang);
			    $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	            $branch_class = $branch['branch_class'];

	            switch ($branch_class) {
	                case '0':
	                  $branch_class_name = "Kepala Pusat";
	                  break;
	                case '1':
	                  $branch_class_name = "Kepala Wilayah";
	                  break;
	                case '2':
	                  $branch_class_name = "Kepala Cabang";
	                  break;
	                case '3':
	                  $branch_class_name = "Kepala Capem";
	                  break;
	                default:
	                  $branch_class_name = "-";
	                  break;
	            }


	            if ($cabang !='00000'){
	                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	                if($branch_class=="1"){
	                    $branch_name .= " (Perwakilan)";
	                }
	            }else{
	                $branch_name = "PUSAT (Gabungan)";
	            }
				
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


				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Cabang");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=($datas[$i]['pokok']+$datas[$i]['margin']);  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format(($datas[$i]['pokok']+$datas[$i]['margin']),0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}



		//BY rembug
		public function export_rekap_outstanding_pembiayaan_rembug()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else if ($cabang==true) 
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_rembug($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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


				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Rembug");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Catab");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);


				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_catab = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_catab+=$datas[$i]['catab'];  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['catab'],0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+8;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_catab,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);
		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Petugas
		public function export_rekap_outstanding_pembiayaan_petugas()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else if ($cabang==true) 
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_petugas($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Petugas");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				


						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=($datas[$i]['pokok']+$datas[$i]['margin']);  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format(($datas[$i]['pokok']+$datas[$i]['margin']),0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);


		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Peruntukan
		public function export_rekap_outstanding_pembiayaan_peruntukan()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else if ($cabang==true) 
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_peruntukan($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Peruntukan");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Akad");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('G6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=($datas[$i]['pokok']+$datas[$i]['margin']);  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['display_text']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['code_value']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format(($datas[$i]['pokok']+$datas[$i]['margin']),0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(10);
				

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':G'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':G'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(10);


		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Resort
		public function export_rekap_outstanding_pembiayaan_resort()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else if ($cabang==true) 
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_resort($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Resort");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=($datas[$i]['pokok']+$datas[$i]['margin']);  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['resort_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format(($datas[$i]['pokok']+$datas[$i]['margin']),0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);


		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		//BY Resort
		public function export_rekap_outstanding_pembiayaan_product()
		{
	        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else if ($cabang==true) 
            {
                $cabang =   $cabang;            
            }
	        
	                $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_product($cabang);
			            if ($cabang !='00000') 
			            {
			                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
			            } 
			            else 
			            {
			                $datacabang = "Semua Cabang";
			            }
				
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

				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
				$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
				$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Outstanding Piutang Berdasarkan Produk");/*
				$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".date('Y-m-d'));*/
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
				$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
				$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
				$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);

				$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
				$ii = 7;

	      		$total_anggota = 0;
	      		$total_pokok = 0;
	      		$total_margin = 0;
	      		$total_total = 0;

				for( $i = 0 ; $i < count($datas) ; $i++ )
				{ 
	        		 $total_anggota+=$datas[$i]['num'];     
	       			 $total_pokok+=$datas[$i]['pokok'];  
	       			 $total_margin+=$datas[$i]['margin'];  
	       			 $total_total+=($datas[$i]['pokok']+$datas[$i]['margin']);  

					$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['product_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format(($datas[$i]['pokok']+$datas[$i]['margin']),0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

					$ii++;
				
				}//END FOR

				$iii = count($datas)+7;
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);


		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT_REKAP_OUTSTANDING_PIUTANG.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}

		// ----------------------------------------------------------------------
		// END REPORT OUTSTANDING PEMBIAYAAN
		// ----------------------------------------------------------------------


	/****************************************************************************************/	
	// BEGIN LIST SALDO TABUNGAN
	/****************************************************************************************/
	public function export_list_pembukaan_tabungan()
	{
		$produk 		= $this->uri->segment(3);		
		$cabang			= $this->uri->segment(4);		
		$datas 			= $this->model_laporan->export_list_pembukaan_tabungan($produk,$cabang);
        $produk_name	= $this->model_laporan->get_produk($produk);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',"KANTOR PUSAT");
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"SALDO TABUNGAN");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:J4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Produk : ".$produk_name);
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Produk");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Status");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Saldo Revenue");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Total Saldo");
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
				$status_rekening = $datas[$i]['status_rekening'];
				if($status_rekening==1){
					$status_rekening = "Aktif";
				}else{
					$status_rekening = "Tidak Aktif";
				}

		        $total_saldo     			+= $datas[$i]['saldo_memo']+$datas[$i]['saldo_rev'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_saving_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$status_rekening);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['saldo_rev'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['saldo_memo'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['saldo_memo']+$datas[$i]['saldo_rev'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getFont()->setSize(9);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-SALDO-TABUNGAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN SALDO TABUNGAN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST BLOKIR TABUNGAN
	/****************************************************************************************/
	public function export_list_blokir_tabungan()
	{
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2); 
        $branch_code  = $this->uri->segment(5);   
		$datas 			= $this->model_laporan_to_pdf->export_list_blokir_tabungan($from_date,$thru_date,$branch_code);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }

        if ($branch_code !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',"KANTOR PUSAT");
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Blokir Saldo Tabungan");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Tanggal Blokir : ".$this->format_date_detail($from_date,'id',false,'-')." s/d ".$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Tanggal Blokir");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Tanggal Buka");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Keterangan");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['jumlah'];				
				
				$tgl_blokir = (isset($datas[$i]['tgl_blokir'])) ? $this->format_date_detail($datas[$i]['tgl_blokir'],'id',false,'-') : "" ;
				$tgl_buka = (isset($datas[$i]['tgl_buka'])) ? $this->format_date_detail($datas[$i]['tgl_buka'],'id',false,'-') : "" ;

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['no_rek']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$tgl_blokir);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['jumlah'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$tgl_buka);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['keterangan']);

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-BLOKIR-TABUNGAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN BLOKIR TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST REKENING TABUNGAN
	/****************************************************************************************/
	public function export_list_rekening_tabungan()
	{
        $cif_no     	 = $this->uri->segment(3);
        $no_rek     	 = $this->uri->segment(4);
        $produk     	 = $this->uri->segment(5);
        $from_date1  	 = $this->uri->segment(6);
        $from_date  	 = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1  	 = $this->uri->segment(7);   
        $thru_date  	 = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  
 
 		$datas 			 = $this->model_laporan->export_list_statement_tabungan($cif_no,$no_rek,$produk,$from_date,$thru_date);
        $produk_name	 = $this->model_laporan->get_produk($produk);
        $nama			 = $this->model_laporan->get_nama($cif_no);
 
        $awal_debit      = $this->model_laporan->get_saldo_awal_debet($no_rek,$from_date);
        $awal_credit     = $this->model_laporan->get_saldo_awal_credit($no_rek,$from_date);
        $saldo_awal      = $awal_credit['credit']-$awal_debit['debit'];
        $tgl_saldo_akhir = date("Y-m-d",strtotime($from_date.' -1 days'));
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',strtoupper($this->session->userdata('branch_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"STATEMENT TABUNGAN");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"No. Rekening : ".$no_rek);

		$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5',"Nama : ".$nama);

		$objPHPExcel->getActiveSheet()->mergeCells('C6:E6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Produk : ".$produk_name);

		$objPHPExcel->getActiveSheet()->mergeCells('C7:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Periode : ".$this->format_date_detail($from_date,'id',false,'-')." s/d ".$this->format_date_detail($thru_date,'id',false,'-'));

		$objPHPExcel->getActiveSheet()->setCellValue('C9',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D9',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('E9',"Keterangan");
		$objPHPExcel->getActiveSheet()->setCellValue('F9',"D/C");
		$objPHPExcel->getActiveSheet()->setCellValue('G9',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('H9',"Saldo");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C9:H9')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C9:H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C9:H9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C9:C9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D9:D9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E9:E9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F9:F9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G9:G9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H9:H9')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

			$objPHPExcel->getActiveSheet()->setCellValue('C10',"1");
			$objPHPExcel->getActiveSheet()->setCellValue('D10'," ".$this->format_date_detail($tgl_saldo_akhir,'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('E10',"Saldo Awal");
			$objPHPExcel->getActiveSheet()->setCellValue('F10',"-");
			$objPHPExcel->getActiveSheet()->setCellValue('G10',"-");
			$objPHPExcel->getActiveSheet()->setCellValue('H10'," ".number_format($saldo_awal,0,',','.'));

			$objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C10:H10')->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('C10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C10:H10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			$ii = 11;
      		$saldo  = $saldo_awal; 
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        if($datas[$i]['flag_debit_credit']=="D") {
		          $saldo -= $datas[$i]['amount'];
		        }else{
		          $saldo += $datas[$i]['amount'];
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+2));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['description']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['flag_debit_credit']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($saldo,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':H'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-REKENING-TABUNGAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN REKENING TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LAPORAN LABA RUGI
	/****************************************************************************************/
	public function export_lap_lr()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }if ($periode_bulan=="" && $periode_tahun==""){            
         echo "<script>alert('Periode belum dilengkapi !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}

            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
			$datas = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$periode_bulan,$periode_tahun);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }

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

			$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('C1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('C2',"LAPORAN LABA RUGI");
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('C4',"Per Tanggal : ".$this->format_date_detail($last_date,'id',false,'-'));

			$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('C5',"Cabang : ".$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('C1:C2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				if($datas[$i]['item_type']=="0")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1")
				{
					if($datas[$i]['posisi']=='0'){
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					}else{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(9);
				}
				else if($datas[$i]['item_type']=="3")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
					}
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$ii++;
			
			}//END FOR*/

			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-LABA-RUGI.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END LAPORAN LABA RUGI
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LAPORAN NERACA
	/****************************************************************************************/
	public function export_neraca_gl()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}


            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
			$datas = $this->model_laporan_to_pdf->export_neraca_gl($cabang,$periode_bulan,$periode_tahun);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }

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

			$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('C1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('C2',"LAPORAN NERACA");
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('C4',"Per Tanggal : ".$this->format_date_detail($last_date,'id',false,'-'));

			$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('C5',"Cabang : ".$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('C1:C2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				if($datas[$i]['item_type']=="0")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1")
				{
					if($datas[$i]['posisi']=='0'){
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					}else{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(9);
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$ii++;
			
			}//END FOR*/
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));


			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-NERACA.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END LAPORAN NERACA
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST PEMBUKAAN DEPOSITO
	/****************************************************************************************/
	public function export_list_pembukaan_deposito()
	{
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2); 
        $cabang  = $this->uri->segment(5);   
        $nama_cabang = ($cabang!='00000') ? 'CABANG '.$this->model_laporan_to_pdf->get_nama_cabang($cabang) : "SEMUA CABANG";

		$datas 			= $this->model_laporan_to_pdf->export_list_pembukaan_deposito($from_date,$thru_date,$cabang);
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->setCellValue('E1',$this->session->userdata('institution_name'));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$nama_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan Pembukaan Deposito");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:J4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Periode : ".$this->format_date_detail($from_date,'id',false,'-')." s/d ".$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Nominal");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Jangka Waktu");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Tanggal Buka");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Tanggal Jto");
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Aro");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];

		        if($datas[$i]['automatic_roll_over']==0){
		        	$aro = "T";
		        }else{
		        	$aro = "Y";
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_deposit_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['jangka_waktu']." Bulan");
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$this->format_date_detail($datas[$i]['tanggal_buka'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$this->format_date_detail($datas[$i]['tanggal_jtempo_last'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,$aro);

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-PEMBUKAAN-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN PEMBUKAAN DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST SALDO DEPOSITO
	/****************************************************************************************/
	public function export_list_saldo_deposito()
	{
        $produk  		= $this->uri->segment(3);
		$datas 	 		= $this->model_laporan->export_list_saldo_deposito($produk);
        $product_name  	= $this->model_laporan->get_produk_deposito($produk);
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('C1:G1');
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->setCellValue('C1',"KANTOR PUSAT");
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('C2',"Laporan Saldo Deposito Per Produk");
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Produk : ".$product_name);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Kode");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Keterangan");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Nominal");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

			$ii = 7;
			$row_total 		= count($datas)+8;
	        $total_saldo 	= 0;
	        $total_anggota 	= 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];
		        $total_anggota     			+= $datas[$i]['jumlah'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['kode']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['jumlah']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->getStyle('F'.$row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_total,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-SALDO-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN SALDO DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST PENCAIRAN DEPOSITO
	/****************************************************************************************/
	public function export_lap_droping_deposito()
	{
		$from_date 	= $this->uri->segment(3);
		$from_date 	= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 	= $this->uri->segment(4);	
		$thru_date 	= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang 	= $this->uri->segment(5);				
		$rembug 	= $this->uri->segment(6);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($from_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else if ($thru_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else
        {				
				
				
					$datas = $this->model_laporan_to_pdf->export_lap_droping_deposito($cabang,$rembug,$from_date,$thru_date);
		            if ($cabang !='00000') 
		            {
		                $data_cabang = "Cabang : ".$this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $data_cabang = "Semua Cabang";
		            }
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',"Laporan Pencairan Deposito");
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:J4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Periode : ".$this->format_date_detail($from_date,'id',false,'-')." s/d ".$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jangka Waktu");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Tanggal Buka");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Tanggal Cair");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Bagi Hasil");
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Nominal");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:J6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
	        $total_bahas = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];
		        $total_bahas     			+= $datas[$i]['nilai_bagihasil_last'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_deposit_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['jangka_waktu']." Bulan");
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$this->format_date_detail($datas[$i]['tanggal_buka'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['nilai_bagihasil_last'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_bahas,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-PENCAIRAN-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END LAPORAN PENCAIRAN DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST REKAP REKENING DEPOSITO
	/****************************************************************************************/
	public function export_rekap_pembukaan_deposito()
	{
        $produk  		= $this->uri->segment(3);
		$from_date 		= $this->uri->segment(4);
		$from_date 		= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 		= $this->uri->segment(5);	
		$thru_date 		= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);	
		$datas 	 		= $this->model_laporan->export_rekap_pembukaan_deposito($produk,$from_date,$thru_date);
        $product_name  	= $this->model_laporan->get_produk_deposito($produk);
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('C1:G1');
		// $objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->setCellValue('C1',"KANTOR PUSAT");
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('C2',"Laporan Rekap Registrasi Deposito Per Produk");
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('C3',"Produk : ".$product_name);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Tanggal : ".$from_date." s/d ".$thru_date);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Kode");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Keterangan");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Nominal");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

			$ii = 7;
			$row_total 		= count($datas)+8;
	        $total_saldo 	= 0;
	        $total_anggota 	= 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];
		        $total_anggota     			+= $datas[$i]['jumlah'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['kode']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['keterangan']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['jumlah']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->getStyle('F'.$row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_total,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-REKAP-REGISTRASI-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN REKAP REKENING DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST OUTSTANDING DEPOSITO
	/****************************************************************************************/
	public function export_rekap_outstanding_deposito()
	{		
		$tanggal 	= $this->current_date();
		$produk 	= $this->uri->segment(3);				
		$cabang 	= $this->uri->segment(4);				
		$rembug 	= $this->uri->segment(5);	

		if ($rembug==false) 
		{
			$rembug = "";
		} 
		else 
		{
			$rembug =	$rembug;			
		}

		// $datas 			= $this->model_laporan_to_pdf->export_rekap_outstanding_deposito($cabang,$rembug,$tanggal,$produk);
		$datas 			= $this->model_laporan_to_pdf->export_rekap_outstanding_deposito($cabang,$tanggal,$produk);
        $product_name   = $this->model_laporan->get_produk_deposito($produk);
        
        if ($cabang !='00000') 
        {
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } 
        else 
        {
            $data_cabang = "Semua Cabang";
        }
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',"Laporan Outstanding Deposito");
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Produk : ".$product_name);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4',"Tanggal : ".$tanggal);
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C7',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tanggal Jto");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Aro");
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"Nominal");
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Cad. Bagi Hasil");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C7:I7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C7:I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7:I7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7:C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E7:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F7:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G7:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H7:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7:I7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
	        $total_bahas = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];
		        $total_bahas     			+= $datas[$i]['nilai_cadangan_bagihasil'];

		        if($datas[$i]['automatic_roll_over']==0){
		        	$aro = "T";
		        }else{
		        	$aro = "Y";
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_deposit_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$this->format_date_detail($datas[$i]['tanggal_jtempo_last'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$aro);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['nilai_cadangan_bagihasil'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_saldo,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_bahas,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-OUTSTANDING-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN OUTSTANDING DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LIST BAGI HASIL DEPOSITO
	/****************************************************************************************/
	public function export_rekap_bagi_hasil_deposito()
	{	
        $produk  		= $this->uri->segment(3);
		$from_date 		= $this->uri->segment(4);
		$from_date 		= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 		= $this->uri->segment(5);	
		$thru_date 		= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);	
		$datas 	 		= $this->model_laporan->export_rekap_bagi_hasil_deposito($produk,$from_date,$thru_date);
        $product_name  	= $this->model_laporan->get_produk_deposito($produk);
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('C1:I1');
		$objPHPExcel->getActiveSheet()->setCellValue('C1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C2:I2');
		$objPHPExcel->getActiveSheet()->setCellValue('C2',"Laporan Outstanding Deposito");
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C3:I3');
		$objPHPExcel->getActiveSheet()->setCellValue('C3',"Produk : ".$product_name);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Tanggal : ".$from_date." s/d ".$thru_date);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C7',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Nominal");
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"Bagi Hasil");
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Zakat");
		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Pajak");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C7:J7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C7:J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7:J7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C7:C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E7:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F7:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G7:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H7:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7:J7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
	        $total_bahas = 0;
	        $total_pajak = 0;
	        $total_zakat = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_saldo     			+= $datas[$i]['nominal'];
		        $total_bahas     			+= $datas[$i]['nominal_bahas'];
		        $total_pajak     			+= $datas[$i]['pajak_bahas'];
		        $total_zakat     			+= $datas[$i]['zakat_bahas'];

		        if($datas[$i]['automatic_roll_over']==0){
		        	$aro = "T";
		        }else{
		        	$aro = "Y";
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->format_date_detail($datas[$i]['tanggal'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".$datas[$i]['account_deposit_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['saldo_bahas'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['nominal_bahas'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['zakat_bahas'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['pajak_bahas'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':J'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_saldo,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_bahas,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_zakat,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_total," ".number_format($total_pajak,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-BAGIHASIL-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN BAGI HASIL DEPOSITO
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LIST REKENING DEPOSITO
	/****************************************************************************************/
	public function export_list_rekening_deposito()
	{
        $cif_no     	= $this->uri->segment(3);
        $no_rek     	= $this->uri->segment(4);
        $produk     	= $this->uri->segment(5);
        $from_date1  	= $this->uri->segment(6);
        $from_date  	= substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1  	= $this->uri->segment(7);   
        $thru_date  	= substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  

		$datas 			= $this->model_laporan->export_list_rekening_deposito($cif_no,$no_rek,$produk,$from_date,$thru_date);
        $produk_name	= $this->model_laporan->get_produk_deposito($produk);
        $nama			= $this->model_laporan->get_nama($cif_no);
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',"History Transaksi Deposito");
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"No. Rekening : ".$no_rek);

		$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5',"Nama : ".$nama);

		$objPHPExcel->getActiveSheet()->mergeCells('C6:E6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Produk : ".$produk_name);

		$objPHPExcel->getActiveSheet()->mergeCells('C7:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Periode : ".$from_date." s/d ".$thru_date);

		$objPHPExcel->getActiveSheet()->mergeCells('C9:C10');
		$objPHPExcel->getActiveSheet()->mergeCells('D9:D10');
		$objPHPExcel->getActiveSheet()->mergeCells('E9:E10');
		$objPHPExcel->getActiveSheet()->mergeCells('F9:G9');
		$objPHPExcel->getActiveSheet()->setCellValue('C9',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D9',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('E9',"Keterangan");
		$objPHPExcel->getActiveSheet()->setCellValue('F9',"Jumlah");
		$objPHPExcel->getActiveSheet()->setCellValue('F10',"DB");
		$objPHPExcel->getActiveSheet()->setCellValue('G10',"CR");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C9:G9')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C9:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C9:G10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C9:C10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D9:D10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E9:E10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F9:F10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F9:F9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G9:G9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G9:G10')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);

			$ii = 11;
	        $total_saldo = 0;
	        $total_bahas = 0;
	        $total_pajak = 0;
	        $total_depo  = 0;
			$row_total = count($datas)+13;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				$total_saldo     			+= $datas[$i]['nominal'];
		        $total_bahas     			+= $datas[$i]['nominal_bahas'];
		        $total_pajak     			+= $datas[$i]['pajak_bahas'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['description']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['nominal'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['nominal_bahas'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_total,"Buka Deposito");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+1),"Bagi Hasil");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+2),"Pajak Bagi Hasil");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+3),"Pencairan Deposito");

				$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_total," ".number_format($total_saldo,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.($row_total+1)," ".number_format($total_bahas,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.($row_total+2)," ".number_format($total_pajak,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.($row_total+3)," ".number_format($total_depo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-HISTORY-TRX-DEPOSITO.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN REKENING DEPOSITO
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/
	public function export_lap_transaksi_tabungan()
	{
		$from_date = $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang = $this->uri->segment(5);				
        $jenis_transaksi = $this->uri->segment(6);     

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($from_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else if ($thru_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else
        {				
			$datas = $this->model_laporan_to_pdf->export_lap_transaksi_tabungan($cabang,$from_date,$thru_date,$jenis_transaksi);
		            
	        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
	        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
	        $branch_class = $branch['branch_class'];

	        switch ($branch_class) {
	            case '0':
	              $branch_class_name = "Kepala Pusat";
	              break;
	            case '1':
	              $branch_class_name = "Kepala Wilayah";
	              break;
	            case '2':
	              $branch_class_name = "Kepala Cabang";
	              break;
	            case '3':
	              $branch_class_name = "Kepala Capem";
	              break;
	            default:
	              $branch_class_name = "-";
	              break;
	        }


	        if ($cabang !='00000'){
	            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
	            if($branch_class=="1"){
	                $branch_name .= " (Perwakilan)";
	            }
	        }else{
	            $branch_name = "PUSAT (Gabungan)";
	        }
			
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('D1:I1');
		$objPHPExcel->getActiveSheet()->setCellValue('D1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('D2:I2');
		$objPHPExcel->getActiveSheet()->setCellValue('D2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('D3:I3');
		$objPHPExcel->getActiveSheet()->setCellValue('D3',"Laporan Transaksi Tabungan");
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('B4',"Tanggal : ".$this->format_date_detail($from_date,'id',false,'-').' s/d '.$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('B6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"TANGGAL");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"NAMA");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"KODE");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"D/C");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"JUMLAH");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"KETERANGAN");
		
		$objPHPExcel->getActiveSheet()->getStyle('D1:H3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1:H4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);

					
			$ii = 7;
			$row_total 	 = count($datas)+8;
		    $total_pokok = 0;
		    $debet_tunai = 0;
		    $credit_tunai = 0;
		    $debet_pinbuk = 0;
		    $credit_pinbuk = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

		        $total_pokok += $datas[$i]['amount'];

		        switch($datas[$i]['trx_saving_type']){
		          case "1":
		          $tipe_transaksi = "SETORAN TUNAI";
		          if($datas[$i]['flag_debit_credit']=='C'){
		            $credit_tunai+=$datas[$i]['amount'];
		            $debet_tunai+=0;
		          }else{
		            $credit_tunai+=0;
		            $debet_tunai+=$datas[$i]['amount'];
		          }
		          break;
		          case "2":
		          $tipe_transaksi = "PENARIKAN TUNAI";
		          if($datas[$i]['flag_debit_credit']=='C'){
		            $credit_tunai+=$datas[$i]['amount'];
		            $debet_tunai+=0;
		          }else{
		            $credit_tunai+=0;
		            $debet_tunai+=$datas[$i]['amount'];
		          }
		          break;
		          case "3":
		          $tipe_transaksi = "PEMINDAH BUKUAN KELUAR";
		          if($datas[$i]['flag_debit_credit']=='C'){
		            $credit_pinbuk+=$datas[$i]['amount'];
		            $debet_pinbuk+=0;
		          }else{
		            $credit_pinbuk+=0;
		            $debet_pinbuk+=$datas[$i]['amount'];
		          }
		          break;
		          case "4":
		          $tipe_transaksi = "PEMINDAH BUKUAN MASUK";
		          if($datas[$i]['flag_debit_credit']=='C'){
		            $credit_pinbuk+=$datas[$i]['amount'];
		            $debet_pinbuk+=0;
		          }else{
		            $credit_pinbuk+=0;
		            $debet_pinbuk+=$datas[$i]['amount'];
		          }
		          break;
		          default:
		          $tipe_transaksi = "-";
		          break;
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['cif_no']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$tipe_transaksi);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['flag_debit_credit']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['description']);
				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->getStyle('B7:I'.(6+count($datas)))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B7:I'.(6+count($datas)))->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('B7:D'.(6+count($datas)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F7:G'.(6+count($datas)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B7:G'.(6+count($datas)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('H7:H'.(6+count($datas)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


				// $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_pokok,0,',','.'));
				// $objPHPExcel->getActiveSheet()->getStyle('H'.$row_total)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.($row_total+4),"Total");
				$objPHPExcel->getActiveSheet()->setCellValue('C'.($row_total+5),"Tunai");
				$objPHPExcel->getActiveSheet()->setCellValue('C'.($row_total+6),"Pinbuk");
				$objPHPExcel->getActiveSheet()->setCellValue('D'.($row_total+4),"Debet");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+4),"Credit");

				$objPHPExcel->getActiveSheet()->setCellValue('D'.($row_total+5),number_format($debet_tunai,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.($row_total+6),number_format($debet_pinbuk,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+5),number_format($credit_tunai,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($row_total+6),number_format($credit_pinbuk,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.($row_total+4))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.($row_total+5))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.($row_total+6))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+4))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+5))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+6))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+4))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+5))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+6))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('C'.($row_total+4).':G'.($row_total+6))->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+4).':H'.($row_total+6))->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+4).':I'.($row_total+6))->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('D'.($row_total+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($row_total+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-TRANSAKSI-TABUNGAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI TABUNGAN
	/****************************************************************************************/


	/****************************************************************************************/	
	// BEGIN LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/
	public function export_lap_transaksi_akun()
	{
		$from_date 	= $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 	= $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang 	= $this->uri->segment(5);				
		$rembug 	= $this->uri->segment(6);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($from_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else if ($thru_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else
        {				
				
				
					$datas = $this->model_laporan_to_pdf->export_lap_transaksi_akun($cabang,$rembug,$from_date,$thru_date);
		            if ($cabang !='00000') 
		            {
		                $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $data_cabang = "Semua Cabang";
		            }

				
				
			
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('D1:H1');
		$objPHPExcel->getActiveSheet()->setCellValue('D1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
		$objPHPExcel->getActiveSheet()->setCellValue('D2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('D3:H3');
		$objPHPExcel->getActiveSheet()->setCellValue('D3',"Laporan Transaksi Tabungan");
		$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('D4:H4');
		$objPHPExcel->getActiveSheet()->setCellValue('D4',$from_date.' s/d '.$thru_date);
		$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('B6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"TANGGAL");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"VOUCHER");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"AKUN");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"NAMA");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"D/C");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"JUMLAH");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"KETERANGAN");
		
		$objPHPExcel->getActiveSheet()->getStyle('D1:H4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1:H4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

					
			$ii = 7;
			$row_total 	 = count($datas)+8;
		    $total_pokok = 0;
		    $debet 		 = 0;
		    $credit 	 = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

		        $total_pokok += $datas[$i]['amount'];

		        if($datas[$i]['flag_debit_credit']=="D"){
		          $debet += $datas[$i]['amount'];
		        }else{
		          $debet = 0;
		        }   
		        if($datas[$i]['flag_debit_credit']=="C"){
		          $credit += $datas[$i]['amount'];
		        }else{
		          $credit = 0;
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,"'".$datas[$i]['account_code']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['account_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['flag_debit_credit']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['description']);

				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':I'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':I'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':I'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_pokok,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-TRANSAKSI-AKUN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN TRANSAKSI AKUN
	/****************************************************************************************/

	/****************************************************************************************/	
	// BEGIN LAPORAN PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/
	public function export_lap_droping_pembiayaan_kelompok()
	{
		$from_date 	= $this->uri->segment(3);
		$from_date 	= substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date 	= $this->uri->segment(4);	
		$thru_date 	= substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cabang 	= $this->uri->segment(5);				
		$rembug 	= $this->uri->segment(6);				
		$cif_type 	= $this->uri->segment(7);				
			if ($rembug==false) 
			{
				$rembug = "";
			} 
			else 
			{
				$rembug =	$rembug;			
			}

		if ($cabang=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($from_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else if ($thru_date=="") 
        {            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }
        else
        {				
				
				
					$datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan_kelompok($cabang,$rembug,$from_date,$thru_date,$cif_type);
		            if ($cabang !='00000') 
		            {
		                $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $data_cabang = "Semua Cabang";
		            }

				
				
			
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',$data_cabang);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Laporan List Pencairan Pembiayaan");
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('E4',$from_date.' s/d '.$thru_date);
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Tanggal");

		$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Nama");

		$objPHPExcel->getActiveSheet()->mergeCells('E6:E7');
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Majelis");

		$objPHPExcel->getActiveSheet()->mergeCells('F6:F7');
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Petugas");

		$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Plafon");

		$objPHPExcel->getActiveSheet()->mergeCells('H6:H7');
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Margin");

		$objPHPExcel->getActiveSheet()->mergeCells('I6:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Tab. 5%");

		$objPHPExcel->getActiveSheet()->mergeCells('J6:J7');
		$objPHPExcel->getActiveSheet()->setCellValue('J6',"Periode");

		$objPHPExcel->getActiveSheet()->mergeCells('K6:K7');
		$objPHPExcel->getActiveSheet()->setCellValue('K6',"Jangka Waktu Angsuran");

		
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6:J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6:K7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

					
			$ii = 8;
			$row_total = count($datas)+9;


		        $total_pokok            = 0;
		        $total_margin           = 0;
		        $total_pokok_persen     = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

		        $total_pokok                  += $datas[$i]['pokok'];
		        $total_margin                 += $datas[$i]['margin'];
		        $total_pokok_persen           += $datas[$i]['pokok']*0.05;

				$tab_persen = $datas[$i]['pokok']*0.05;

				if($datas[$i]['periode_jangka_waktu']==0){
          			$periode_jangka_waktu = "Harian";
				}else if($datas[$i]['periode_jangka_waktu']==1){
          			$periode_jangka_waktu = "Mingguan";
				}else if($datas[$i]['periode_jangka_waktu']==2){
          			$periode_jangka_waktu = "Bulanan";
				}else{
          			$periode_jangka_waktu = "Jatuh Tempo";
				}

				//$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$this->format_date_detail($datas[$i]['droping_date'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,"'".$datas[$i]['account_financing_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($tab_persen,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,$periode_jangka_waktu);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,$datas[$i]['jangka_waktu']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':J'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$ii.':K'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$ii.':K'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':K'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':K'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_total," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_total," ".number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_pokok_persen,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT-PENCAIRAN-PEMBIAYAAN-KELOMPOK.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

	public function export_lap_droping_pembiayaan_individu()
	{
		$from_date = $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);			
		$cif_type = $this->uri->segment(5);				
        $cabang = $this->uri->segment(6);               
        $petugas = $this->uri->segment(7);               
        $produk = $this->uri->segment(8);  
        $resort = $this->uri->segment(9);  
        $akad = $this->uri->segment(10);  
        $pengajuan_melalui = $this->uri->segment(11);  

 		$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= "";
            }
        }else{
            $branch_name = "";
        }

		if ($from_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else if ($thru_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else{				
			$datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan_individu($from_date,$thru_date,$cif_type,$cabang,$petugas,$produk,$resort,$akad,$pengajuan_melalui);
	        $produk_name = $this->model_laporan->get_produk_name($produk);
	        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
	        $resort_name = $this->model_laporan->get_resort_name($resort);
				
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
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:O3');
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan List Pencairan Pembiayaan");
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCells('A5:O5');
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Produk : ".$produk_name);
			// $objPHPExcel->getActiveSheet()->mergeCells('A5:N5');
			// $objPHPExcel->getActiveSheet()->setCellValue('A5',"Petugas : ".$petugas_name);
			$objPHPExcel->getActiveSheet()->mergeCells('A6:O6');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Tanggal : ".$this->format_date_detail($from_date,'id',false,'-').' s/d '.$this->format_date_detail($thru_date,'id',false,'-'));
			// $objPHPExcel->getActiveSheet()->mergeCells('A7:Q7');
			// $objPHPExcel->getActiveSheet()->setCellValue('A7',"Resort : ".$resort_name);
			$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
			$objPHPExcel->getActiveSheet()->setCellValue('A8',"NO.");
			$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
			$objPHPExcel->getActiveSheet()->setCellValue('B8',"NO. REKENING");
			$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
			$objPHPExcel->getActiveSheet()->setCellValue('C8',"NAMA");
			$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
			$objPHPExcel->getActiveSheet()->setCellValue('D8',"PRODUK");
			$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
			$objPHPExcel->getActiveSheet()->setCellValue('E8',"AKAD");
			$objPHPExcel->getActiveSheet()->mergeCells('F8:F9');
			$objPHPExcel->getActiveSheet()->setCellValue('F8',"PLAFON");
			$objPHPExcel->getActiveSheet()->mergeCells('G8:G9');
			$objPHPExcel->getActiveSheet()->setCellValue('G8',"MARGIN");
			$objPHPExcel->getActiveSheet()->mergeCells('H8:H9');
			$objPHPExcel->getActiveSheet()->setCellValue('H8',"JANGKA WAKTU");
			$objPHPExcel->getActiveSheet()->mergeCells('I8:I9');
			$objPHPExcel->getActiveSheet()->setCellValue('I8',"ANGSURAN");
			$objPHPExcel->getActiveSheet()->mergeCells('J8:J9');
			$objPHPExcel->getActiveSheet()->setCellValue('J8',"BIAYA ADMIN");
			$objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
			$objPHPExcel->getActiveSheet()->setCellValue('K8',"BIAYA NOTARIS");
			$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
			$objPHPExcel->getActiveSheet()->setCellValue('L8',"PREMI ASURANSI");
			$objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
			$objPHPExcel->getActiveSheet()->setCellValue('M8',"PREMI TAMBAHAN");
			$objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
			$objPHPExcel->getActiveSheet()->setCellValue('N8',"STATUS TRANSFER");
			$objPHPExcel->getActiveSheet()->mergeCells('O8:O9');
			$objPHPExcel->getActiveSheet()->setCellValue('O8',"TGL TRANSFER");

			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A8:O8')->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('A9:O9')->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('A8:O8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A8:O8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A9:O9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A9:O9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A8:A9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B8:B9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C8:C9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D8:D9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E8:E9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F8:F9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G8:G9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H8:H9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I8:I9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J8:J9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K8:K9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('L8:L9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('M8:M9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('N8:N9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('O8:O9')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
			// $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			// $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

					
			$ii = 10;
			$row_total = count($datas)+10;
	        $total_pokok = 0;
	        $total_margin = 0;
	        $total_angsuran = 0;
	        $total_biaya_adm = 0;
	        $total_biaya_notaris = 0;
	        $total_biaya_asuransi_jiwa = 0;
	        $total_premi_asuransi_tambahan = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        $total_pokok  += $datas[$i]['pokok']; 
		        $total_margin += $datas[$i]['margin'];
		        $total_angsuran += $datas[$i]['besar_angsuran'];
		        $total_biaya_adm += $datas[$i]['biaya_administrasi'];
		        $total_biaya_notaris += $datas[$i]['biaya_notaris'];
		        $total_biaya_asuransi_jiwa += $datas[$i]['biaya_asuransi_jiwa'];
		        $total_premi_asuransi_tambahan += $datas[$i]['premi_asuransi_tambahan'];

				if($datas[$i]['periode_jangka_waktu']==0){
          			$periode_jangka_waktu = "Harian";
				}else if($datas[$i]['periode_jangka_waktu']==1){
          			$periode_jangka_waktu = "Mingguan";
				}else if($datas[$i]['periode_jangka_waktu']==2){
          			$periode_jangka_waktu = "Bulanan";
				}else{
          			$periode_jangka_waktu = "Jatuh Tempo";
				}

		        switch ($datas[$i]['status_transfer']) {
		          case '0': $status_transfer='Proses SPB';
		            break; 
		          case '1': $status_transfer='Belum Transfer';
		            break; 
		          case '2': $status_transfer='Sudah Transfer';
		            break;          
		          default: $status_transfer='Proses SPB';
		            break;
		        }

		        $tgl_transfer = ($datas[$i]['tanggal_transfer']) ? $this->format_date_detail($datas[$i]['tanggal_transfer'],'id',false,'-') :'';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['account_financing_no']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['cif_no'].' - '.$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$this->format_date_detail($datas[$i]['tanggal_akad'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($datas[$i]['pokok'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,number_format($datas[$i]['margin'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['jangka_waktu'].' Bulan');
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,number_format($datas[$i]['besar_angsuran'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,number_format($datas[$i]['biaya_administrasi'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,number_format($datas[$i]['biaya_notaris'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,number_format($datas[$i]['biaya_asuransi_jiwa'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,number_format($datas[$i]['premi_asuransi_tambahan'],0,',','.')." ");
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,$status_transfer);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,$tgl_transfer);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->getStyle('A10:A'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B10:B'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C10:C'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D10:D'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E10:E'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F10:F'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G10:G'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H10:H'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I10:I'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J10:J'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('K10:K'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('L10:L'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('M10:M'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('N10:N'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('O10:O'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('O10:O'.($ii-1))->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A10:O'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('A10:O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A10:O'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E10:K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($total_angsuran,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($total_biaya_adm,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii," ".number_format($total_biaya_notaris,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii," ".number_format($total_biaya_asuransi_jiwa,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii," ".number_format($total_premi_asuransi_tambahan,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('F10:L'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="REPORT-PENCAIRAN-PEMBIAYAAN-INDIVIDU.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}
	/****************************************************************************************/	
	// END LAPORAN PENCAIRAN PEMBIAYAAN
	/****************************************************************************************/

	public function export_list_buka_tabungan()
	{
		$produk 		= $this->uri->segment(3);	
        $from_date1 	= $this->uri->segment(4);
        $from_date  	= substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 	= $this->uri->segment(5);   
        $thru_date  	= substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  	
        $cabang 		= $this->uri->segment(6);   
		$datas 			= $this->model_laporan->export_list_buka_tabungan($produk,$from_date,$thru_date,$cabang);
        $produk_name	= $this->model_laporan->get_produk($produk);
        if($produk_name!=null){
        	$produk_name = $produk_name;
        }else{
        	$produk_name = "SEMUA PRODUK";
        }


        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
           
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

		$objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('E1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E2:G2');
		$objPHPExcel->getActiveSheet()->setCellValue('E2',"LAPORAN PEMBUKAAN TABUNGAN");
		$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('E3',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',"Produk : ".$produk_name);
		// $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('C5:I5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5',"Tanggal Pembukaan : ".$this->format_date_detail($from_date,'id',false,'-')." s/d ".$this->format_date_detail($thru_date,'id',false,'-'));
		// $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('C6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"No Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Tgl Buka");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('G6',"Produk");
		$objPHPExcel->getActiveSheet()->setCellValue('H6',"Status");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"Saldo");
		
		$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1:E4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:I6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6:I6')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
	        $total_saldo = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
				$status_rekening = $datas[$i]['status_rekening'];
				if($status_rekening==1){
					$status_rekening = "Aktif";
				}else{
					$status_rekening = "Tidak Aktif";
				}

		        $total_saldo     			+= $datas[$i]['saldo_memo'];

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_saving_no']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$this->format_date_detail($datas[$i]['tanggal_buka'],'id',false,'-'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['nama']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$status_rekening);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['saldo_memo'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getFont()->setSize(9);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':G'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':I'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$ii++;
			
			}//END FOR*/

				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_total," ".number_format($total_saldo,0,',','.'));

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LIST-PEMBUKAAN-TABUNGAN.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

	//EXPORT LAPORAN REKAP SALDO ANGGOTA
	public function export_rekap_saldo_anggota_semua_cabang()
	{
        $cabang         = $this->uri->segment(3);     

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
        if ($cabang !='00000'){
            $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $datacabang = "Semua Cabang";
        }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Saldo Anggota Berdasarkan Cabang");

			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"LWK");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Investasi");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Minggon");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Sukarela");
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"Kelompok");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

            $total_setoran_lwk  	 = 0;
            $total_simpanan_pokok    = 0;
            $total_tabungan_minggon  = 0;
            $total_tabungan_sukarela = 0;
            $total_tabungan_kelompok = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_setoran_lwk+=$datas[$i]['setoran_lwk'];     
       			 $total_simpanan_pokok+=$datas[$i]['simpanan_pokok'];  
       			 $total_tabungan_minggon+=$datas[$i]['tabungan_minggon'];  
       			 $total_tabungan_sukarela+=$datas[$i]['tabungan_sukarela'];  
       			 $total_tabungan_kelompok+=$datas[$i]['tabungan_kelompok'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['setoran_lwk'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['simpanan_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tabungan_minggon'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tabungan_sukarela'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['tabungan_kelompok'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_setoran_lwk,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_simpanan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tabungan_minggon,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tabungan_sukarela,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_tabungan_kelompok,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':G'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':G'.$iii)->getFont()->setSize(10);

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAP SALDO ANGGOTA BY CABANG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_saldo_anggota_cabang()
	{
        $cabang         = $this->uri->segment(3);     

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
        if ($cabang !='00000'){
            $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $datacabang = "Semua Cabang";
        }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Saldo Anggota Berdasarkan Cabang");

			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah Anggota");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"LWK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Investasi");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"Kelompok");
			$objPHPExcel->getActiveSheet()->setCellValue('H6',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

            $total_anggota  	 	 = 0;
            $total_setoran_lwk  	 = 0;
            $total_simpanan_pokok    = 0;
            $total_tabungan_minggon  = 0;
            $total_tabungan_sukarela = 0;
            $total_tabungan_kelompok = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
        		 $total_setoran_lwk+=$datas[$i]['setoran_lwk'];     
       			 $total_simpanan_pokok+=$datas[$i]['simpanan_pokok'];  
       			 $total_tabungan_minggon+=$datas[$i]['tabungan_minggon'];  
       			 $total_tabungan_sukarela+=$datas[$i]['tabungan_sukarela'];  
       			 $total_tabungan_kelompok+=$datas[$i]['tabungan_kelompok'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['setoran_lwk'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['simpanan_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tabungan_minggon'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['tabungan_kelompok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tabungan_sukarela'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_setoran_lwk,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_simpanan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tabungan_minggon,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_tabungan_kelompok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tabungan_sukarela,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAP SALDO ANGGOTA BY CABANG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_saldo_anggota_rembug()
	{
        $cabang         = $this->uri->segment(3);     

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug($cabang);
        if ($cabang !='00000'){
            $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $datacabang = "Semua Cabang";
        }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Saldo Anggota Berdasarkan Rembug");

			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah Anggota");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"LWK");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Investasi");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"Kelompok");
			$objPHPExcel->getActiveSheet()->setCellValue('H6',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

            $total_anggota  	 	 = 0;
            $total_setoran_lwk  	 = 0;
            $total_simpanan_pokok    = 0;
            $total_tabungan_minggon  = 0;
            $total_tabungan_sukarela = 0;
            $total_tabungan_kelompok = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
        		 $total_setoran_lwk+=$datas[$i]['setoran_lwk'];     
       			 $total_simpanan_pokok+=$datas[$i]['simpanan_pokok'];  
       			 $total_tabungan_minggon+=$datas[$i]['tabungan_minggon'];  
       			 $total_tabungan_sukarela+=$datas[$i]['tabungan_sukarela'];  
       			 $total_tabungan_kelompok+=$datas[$i]['tabungan_kelompok'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['setoran_lwk'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['simpanan_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tabungan_minggon'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['tabungan_kelompok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tabungan_sukarela'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_setoran_lwk,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_simpanan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tabungan_minggon,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_tabungan_kelompok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tabungan_sukarela,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAP SALDO ANGGOTA BY REMBUG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_saldo_anggota_petugas()
	{
        $cabang         = $this->uri->segment(3);     

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas($cabang);
        if ($cabang !='00000'){
            $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $datacabang = "Semua Cabang";
        }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Saldo Anggota Berdasarkan Petugas");

			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"LWK");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Investasi");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Minggon");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Sukarela");
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"Kelompok");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

            $total_setoran_lwk  	 = 0;
            $total_simpanan_pokok    = 0;
            $total_tabungan_minggon  = 0;
            $total_tabungan_sukarela = 0;
            $total_tabungan_kelompok = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_setoran_lwk+=$datas[$i]['setoran_lwk'];     
       			 $total_simpanan_pokok+=$datas[$i]['simpanan_pokok'];  
       			 $total_tabungan_minggon+=$datas[$i]['tabungan_minggon'];  
       			 $total_tabungan_sukarela+=$datas[$i]['tabungan_sukarela'];  
       			 $total_tabungan_kelompok+=$datas[$i]['tabungan_kelompok'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['setoran_lwk'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['simpanan_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tabungan_minggon'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tabungan_sukarela'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['tabungan_kelompok'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':G'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_setoran_lwk,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_simpanan_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tabungan_minggon,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tabungan_sukarela,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_tabungan_kelompok,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':G'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':G'.$iii)->getFont()->setSize(10);

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAP SALDO ANGGOTA BY PETUGAS.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	//EXPORT LAPORAN REKAP SALDO ANGGOTA
	

	public function list_jurnal_umum_gl()
	{
		/* (begin) GETTING DATA */
		$branch_code=$this->uri->segment(3);
        $account_code=$this->uri->segment(4);
        $from_date=$this->uri->segment(5);
        $thru_date=$this->uri->segment(6);
        
        $from_date=$this->datepicker_convert(false,$from_date,'');
        $thru_date=$this->datepicker_convert(false,$thru_date,'');

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];

        if($account_code=='-'){
            $account_name = '-';
        }else{
            $account = $this->model_cif->get_gl_account_by_account_code($account_code);
            $account_code = $account['account_code'];
            $account_name = $account['account_name'];
        }

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
					$saldo_akhir+=($datas[$i]['credit']-$datas[$i]['debit']);
				}
                $data['data'][$j]['nomor'] = $i+1;
                $data['data'][$j]['trx_date'] = $datas[$i]['trx_date'];
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

        /* (end) GETTING DATA */

        /* IMPLEMENTATION DATA */

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

		/* HEAD */
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang");
		$objPHPExcel->getActiveSheet()->setCellValue('B2',": ".$branch_name);
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"GL Account");
		$objPHPExcel->getActiveSheet()->setCellValue('B3',": ".$account_name);
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal");
		$objPHPExcel->getActiveSheet()->setCellValue('B4',": ".$this->format_date_detail($from_date,'id',false,'/').' s.d '.$this->format_date_detail($thru_date,'id',false,'/'));

		$objPHPExcel->getActiveSheet()->setCellValue('A6',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Tanggal Transaksi");
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"Deskripsi");
		$objPHPExcel->getActiveSheet()->setCellValue('D6',"Debet");
		$objPHPExcel->getActiveSheet()->setCellValue('E6',"Credit");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"Saldo Akhir");
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);


		$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

		$ii = 7;
		for( $i = 0 ; $i < count($data['data']) ; $i++ )
		{ 
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$data['data'][$i]['nomor']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,(($data['data'][$i]['trx_date']=="")?"":$this->format_date_detail($data['data'][$i]['trx_date'],'id',false,'/')));
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$data['data'][$i]['description']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,' '.(($data['data'][$i]['debit']=="")?"":number_format($data['data'][$i]['debit'],2,',','.')));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,' '.(($data['data'][$i]['credit']=="")?"":number_format($data['data'][$i]['credit'],2,',','.')));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,' '.number_format($data['data'][$i]['saldo_akhir'],2,',','.'));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

			$ii++;
		
		}//END FOR

		$iii = count($datas)+8;
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,"TOTAL:");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($data['total_debit'],2,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($data['total_credit'],2,',','.'));
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$iii.':C'.$iii);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);


	// Redirect output to a client's web browser (Excel2007)
	// Save Excel 2007 file

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="LAPORAN GL INQUIRY.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	}

	//LAPORAN REKAP TRANSAKSI ANGGOTA
	public function export_rekap_transaksi_rembug_by_semua_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_semua_cabang($from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"SEMUA CABANG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['branch_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA CABANG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	
	public function export_rekap_transaksi_rembug_by_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_cabang($cabang,$from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"BY CABANG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['branch_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY CABANG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_transaksi_rembug_by_rembug_semua_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_semua_cabang($from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"BY REMBUG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA REMBUG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_transaksi_rembug_by_rembug_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_cabang($cabang,$from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"BY REMBUG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['cm_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY REMBUG.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_transaksi_rembug_by_petugas_semua_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_semua_cabang($from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"BY REMBUG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA PETUGAS.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	public function export_rekap_transaksi_rembug_by_petugas_cabang()
	{
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_cabang($cabang,$from_date,$thru_date);
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAP TRANSAKSI ANGGOTA");
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"BY REMBUG");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Tanggal : ".$desc_from_date.' s.d '.$desc_thru_date);

			$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Keterangan");
			$objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"SETORAN");
			$objPHPExcel->getActiveSheet()->setCellValue('B7',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('C7',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Catab");
			$objPHPExcel->getActiveSheet()->setCellValue('E7',"Tabungan Wajib");
			$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tabungan Kelompok");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('G6',"PENARIKAN");
			$objPHPExcel->getActiveSheet()->setCellValue('G7',"Droping");
			$objPHPExcel->getActiveSheet()->setCellValue('H7',"Sukarela");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
			$ii = 8;

	        $total_angsuran_pokok = 0;
	        $total_angsuran_margin = 0;
	        $total_angsuran_catab = 0;
	        $total_tab_wajib_cr = 0;
	        $total_tab_sukarela_db = 0;
	        $total_droping = 0;
	        $total_tab_kelompok_cr = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
				$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
	            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
	            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
	            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
	            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
	            $total_droping += $datas[$i]['droping'];
	            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datas[$i]['fa_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['angsuran_catab'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['tab_wajib_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['tab_kelompok_cr'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['droping'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($datas[$i]['tab_sukarela_db'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':H'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Total : ");
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$iii," ".number_format($total_angsuran_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii," ".number_format($total_angsuran_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_angsuran_catab,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_tab_wajib_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_tab_kelompok_cr,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$iii," ".number_format($total_droping,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$iii," ".number_format($total_tab_sukarela_db,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':A'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$iii.':B'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$iii.':G'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$iii.':H'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':H'.$iii)->getFont()->setBold(true);
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY PETUGAS.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}
	//LAPORAN REKAP TRANSAKSI ANGGOTA


	// LAPORAN JURNAL TRANSAKSI
	public function laporan_jurnal_transaksi()
	{
		$from_date = $this->uri->segment(3);
		$thru_date = $this->uri->segment(4);
		$branch_code = $this->uri->segment(5);
		$jurnal_trx_type = $this->uri->segment(6);

		$from_date = $this->datepicker_convert(false,$from_date);
		$thru_date = $this->datepicker_convert(false,$thru_date);
		// ----------------------------------------------------------
    	// [BEGIN] EXPORT SCRIPT
		// ----------------------------------------------------------
		$jenis_transaksi='';
        switch ($jurnal_trx_type) {
            case '0':
                $jenis_transaksi = 'Jurnal Umum';
                break;
            case '1':
                $jenis_transaksi = 'Tabungan';
                break;
            case '2':
                $jenis_transaksi = 'Deposito';
                break;
            case '3':
                $jenis_transaksi = 'Pembiayaan';
                break;
        }
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

		$objPHPExcel->getActiveSheet()->setCellValue('A1','LAPORAN JURNAL TRANSAKSI');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"Tanggal : ".$from_date.' s.d '.$thru_date);
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Jenis Transaksi : ".$jenis_transaksi);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1.14);
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B5:I5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B5:B5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$objPHPExcel->getActiveSheet()->setCellValue('B5',"No");
		$objPHPExcel->getActiveSheet()->getStyle('C5:C5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
		$objPHPExcel->getActiveSheet()->setCellValue('C5',"Bukti (No.Referensi)");
		$objPHPExcel->getActiveSheet()->getStyle('D5:D5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11.14);
		$objPHPExcel->getActiveSheet()->setCellValue('D5',"Tgl Transaksi");
		$objPHPExcel->getActiveSheet()->getStyle('E5:E5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(70);
		$objPHPExcel->getActiveSheet()->setCellValue('E5',"Keterangan");
		$objPHPExcel->getActiveSheet()->getStyle('F5:F5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->setCellValue('F5',"Kode Akun");
		$objPHPExcel->getActiveSheet()->getStyle('G5:G5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(34.29);
		$objPHPExcel->getActiveSheet()->setCellValue('G5',"Account");
		$objPHPExcel->getActiveSheet()->getStyle('H5:H5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
		$objPHPExcel->getActiveSheet()->setCellValue('H5',"Debit");
		$objPHPExcel->getActiveSheet()->getStyle('I5:I5')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
		$objPHPExcel->getActiveSheet()->setCellValue('I5',"Credit");

		$trx_gl = $this->model_laporan->get_trx_gl($from_date,$thru_date,$branch_code,$jurnal_trx_type);
		$no = 0;
		$row_num=6;
		for($i=0;$i<count($trx_gl);$i++){
			$no++;
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num,$no);

			$trx_gl_detail = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl[$i]['trx_gl_id']);
			for($j=0;$j<count($trx_gl_detail);$j++)
			{
				if($j>0) $row_num++;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num,$trx_gl[$i]['voucher_ref']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num,$trx_gl[$i]['trx_date']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num,$trx_gl[$i]['description']);
				// $objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num,$trx_gl[$i]['voucher_ref']);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num.':D'.$row_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num,$trx_gl_detail[$j]['account_code']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num,$trx_gl_detail[$j]['account_name']);
				// $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num,' '.number_format($trx_gl_detail[$j]['debit'],0,',','.'));
				// $objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num,' '.number_format($trx_gl_detail[$j]['credit'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num,$trx_gl_detail[$j]['debit']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num,$trx_gl_detail[$j]['credit']);

				
				$objPHPExcel->getActiveSheet()->getStyle('F'.$row_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$row_num.':I'.$row_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
			$row_num++;
		}
		$objPHPExcel->getActiveSheet()->getStyle('B5:B'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C5:C'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D5:D'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E5:E'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F5:F'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G5:G'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H5:H'.($row_num-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I5:I'.($row_num-1))->applyFromArray($styleArray);


		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LAPORAN JURNAL TRANSAKSI.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/****************************************************************************************/	
	// BEGIN EXPORT KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/
	public function export_kartu_pengawasan_angsuran()
	{
		$account_financing_no = $this->uri->segment(3);
      	$data_cif = $this->model_laporan->get_cif_by_account_financing_no($account_financing_no);
        $cif_no=$data_cif['cif_no'];
        $cif_type=$data_cif['cif_type'];
        $datas = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
        
        if (!isset($datas['nama'])) 
        {
        	echo "<script>alert('Data Tidak Ditemukan !');javascript:window.close();</script>";
        }
        else
        {
			$periode_jangka_waktu = '';
            switch($datas['periode_jangka_waktu']){
              case "0":
              $periode_jangka_waktu=' Hari';
              break;
              case "1":
              $periode_jangka_waktu=' Minggu';
              break;
              case "2":
              $periode_jangka_waktu=' Bulan';
              break;
              case "3":
              $periode_jangka_waktu='x Jatuh Tempo';
              break;
            }

            $Sdroping_date 		= (isset($datas['droping_date'])) ? date("d-m-Y", strtotime($datas['droping_date'])) : '-' ;
            $Stanggal_jtempo 	= (isset($datas['tanggal_jtempo'])) ? date("d-m-Y", strtotime($datas['tanggal_jtempo'])) : '-' ;			
		    
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
			$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',"KARTU PENGAWASAN ANGSURAN ".$account_financing_no);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"No.Rek Pembiayaan");
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"No.Rek Tabungan");
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Nama");
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Produk");
			$objPHPExcel->getActiveSheet()->setCellValue('A7',"Untuk");
			$objPHPExcel->getActiveSheet()->setCellValue('A8',"PYD Ke");
			$objPHPExcel->getActiveSheet()->setCellValue('B3',":  ".$datas['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B4',":  ".$datas['account_saving_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B5',":  ".$datas['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('B6',":  ".$datas['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('B7',":  ".$datas['untuk']);
			$objPHPExcel->getActiveSheet()->setCellValue('B8',":  ".$datas['pydke']);
			$objPHPExcel->getActiveSheet()->setCellValue('D3',"Plafon");
			$objPHPExcel->getActiveSheet()->setCellValue('D4',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('D5',"Jangka Waktu");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Tgl Cair");
			$objPHPExcel->getActiveSheet()->setCellValue('D7',"Tgl. J. Tempo");
			$objPHPExcel->getActiveSheet()->setCellValue('E3',":  ".number_format($datas['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('E4',":  ".number_format($datas['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('E5',":  ".$datas['jangka_waktu']."".$periode_jangka_waktu);
			$objPHPExcel->getActiveSheet()->setCellValue('E6',":  ".$Sdroping_date);
			$objPHPExcel->getActiveSheet()->setCellValue('E7',":  ".$Stanggal_jtempo);
			$objPHPExcel->getActiveSheet()->getStyle('A3:F8')->getFont()->setSize(9);

			$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
			$objPHPExcel->getActiveSheet()->setCellValue('A10',"TANGGAL");
			$objPHPExcel->getActiveSheet()->mergeCells('C10:D10');
			$objPHPExcel->getActiveSheet()->setCellValue('C10',"ANGSURAN");
			$objPHPExcel->getActiveSheet()->mergeCells('E10:E11');
			$objPHPExcel->getActiveSheet()->setCellValue('E10',"SALDO HUTANG");
			$objPHPExcel->getActiveSheet()->mergeCells('F10:F11');
			$objPHPExcel->getActiveSheet()->setCellValue('F10',"VALIDASI");
			$objPHPExcel->getActiveSheet()->setCellValue('A11',"ANGSUR");
			$objPHPExcel->getActiveSheet()->setCellValue('B11',"BAYAR");
			$objPHPExcel->getActiveSheet()->setCellValue('C11',"KE");
			$objPHPExcel->getActiveSheet()->setCellValue('D11',"JUMLAH");

			$objPHPExcel->getActiveSheet()->getStyle('A3:F8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A10:B10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C10:D10')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E10:E11')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F10:F11')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B11')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A10:F11')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A10:F11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A10:F11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					
			$ii = 12;
            $data = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);
            if($cif_type==0){ //kelompok
	            $data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,0);
	        }
            $no=1;            
            if($data['flag_jadwal_angsuran']==0) //NON REGULER lalu lookup ke tabel mfi_account_financing_schedulle
            {
                $get_jadwal_angsuran = $this->model_laporan->get_jadwal_angsuran($account_financing_no);
                $angsuran_hutang = 0;
                for ($jA=0; $jA < count($get_jadwal_angsuran) ; $jA++) 
                {
                    $jumlah_angsur = $get_jadwal_angsuran[$jA]['angsuran_pokok']+$get_jadwal_angsuran[$jA]['angsuran_margin']+$get_jadwal_angsuran[$jA]['angsuran_tabungan'];
                    $angsuran_hutang += $jumlah_angsur;
                    $saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang);
                    $tgl_bayar = (isset($get_jadwal_angsuran[$jA]['tanggal_bayar'])) ? date("d-m-Y", strtotime($get_jadwal_angsuran[$jA]['tanggal_bayar'])) : '' ;

	                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,date("d-m-Y", strtotime($get_jadwal_angsuran[$jA]['tangga_jtempo']))." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$tgl_bayar." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$no);
	                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($jumlah_angsur,0,',','.')." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($saldo_hutang,0,',','.')." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,'');


					$alphabeth = array( 'A','B','C','D','E','F');
					for ($j=0; $j < count($alphabeth); $j++) { 
						$objPHPExcel->getActiveSheet()->getStyle($alphabeth[$j].$ii.':'.$alphabeth[$j].$ii)->applyFromArray($styleArray);	
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(9);

	                $no++;
	                $ii++;
	            }
            }
            else
            {
	            for($i=0;$i<$data['jangka_waktu'];$i++)
	            {
	                if($i==0) $tgl_angsur = $data['tanggal_mulai_angsur'];

	                if($data['periode_jangka_waktu']==0){
	                    $tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 day"));
	                }else if($data['periode_jangka_waktu']==1){
	                    $tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 7 day"));
	                }else if($data['periode_jangka_waktu']==2){
	                    $tgl_angsur = date("Y-m-d",strtotime($tgl_angsur." + 1 month"));
	                }else if($data['periode_jangka_waktu']==3){
	                    $tgl_angsur = $data['tgl_jtempo'];
	                }
	                $tgl_bayar = '';
	                $validasi = '';
	                if($cif_type==1){ //individu
	                    $data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,1,$tgl_angsur);
	                    $tgl_bayar = (isset($data_trx['trx_date'])==true)?$data_trx['trx_date']:'';
	                    $validasi = (isset($data_trx['created_by'])==true)?$data_trx['created_by']:'';
	                }
	                $jumlah_angsur = $data['jumlah_angsuran'];
	                $angsuran_hutang = $data['angsuran_pokok']+$data['angsuran_margin']+$data['angsuran_catab'];
	                $saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang*($i+1));
	                if($data['jangka_waktu']==$no){
		            	$jumlah_angsur = ($data['pokok']+$data['margin'])-($angsuran_hutang*($no-1));
		            	$saldo_hutang=0;
		            }
	                $tgl_bayar = ($tgl_bayar!='') ? date("d-m-Y", strtotime($tgl_bayar)) : '' ;

	                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,date("d-m-Y", strtotime($tgl_angsur))." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$tgl_bayar." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$no);
	                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($jumlah_angsur,0,',','.')." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($saldo_hutang,0,',','.')." ");
	                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$validasi);


					$alphabeth = array( 'A','B','C','D','E','F');
					for ($j=0; $j < count($alphabeth); $j++) { 
						$objPHPExcel->getActiveSheet()->getStyle($alphabeth[$j].$ii.':'.$alphabeth[$j].$ii)->applyFromArray($styleArray);	
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(9);

	                $no++;
	                $ii++;
	            }
        	}
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

		



			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="kartu_pengawasan_angsuran.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}
	/****************************************************************************************/	
	// END EXPORT KARTU PENGAWASAN ANGSURAN
	/****************************************************************************************/

	/*LAPORAN ANGSURAN PEMBIAYAAN*/
	public function export_list_angsuran_pembiayaan_individu()
	{
		$from_date = $this->uri->segment(3);
		$from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
		$thru_date = $this->uri->segment(4);	
		$thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);
		$cabang = $this->uri->segment(5);
		$petugas = $this->uri->segment(6);	
		$produk = $this->uri->segment(7);	
		$akad = $this->uri->segment(8);	
		$pengajuan_melalui = $this->uri->segment(9);	
		$tipe_angsuran = $this->uri->segment(10);	
		$status_telkom = $this->uri->segment(11);	
		$datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from_date,$thru_date,$cabang,$petugas,$produk,$akad,$pengajuan_melalui,$tipe_angsuran,$status_telkom);
		$produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        // $resort_name = $this->model_laporan->get_resort_name($resort);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
       
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

		$objPHPExcel->getActiveSheet()->mergeCells('B2:P2');
		$objPHPExcel->getActiveSheet()->setCellValue('B2',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('B3:P3');
		$objPHPExcel->getActiveSheet()->setCellValue('B3',strtoupper($branch_name));
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('B4:P4');
		$objPHPExcel->getActiveSheet()->setCellValue('B4',"LAPORAN ANGSURAN PEMBIAYAAN");
		$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B5:P5');
		$objPHPExcel->getActiveSheet()->setCellValue('B5',"Produk : ".$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B6:P6');
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Petugas : ".$petugas_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('B7:P7');
		$objPHPExcel->getActiveSheet()->setCellValue('B7',"Tanggal : ".$this->format_date_detail($from_date,'id',false,'-').' s/d '.$this->format_date_detail($thru_date,'id',false,'-'));

		// $objPHPExcel->getActiveSheet()->mergeCells('B8:P8');
		// $objPHPExcel->getActiveSheet()->setCellValue('B8',"Resort : ".$resort_name);
		
		$objPHPExcel->getActiveSheet()->setCellValue('B9',"No");
		$objPHPExcel->getActiveSheet()->setCellValue('C9',"Tanggal Bayar");
		$objPHPExcel->getActiveSheet()->setCellValue('D9',"No Pembiayaan");
		$objPHPExcel->getActiveSheet()->setCellValue('E9',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('F9',"Plafon");
		$objPHPExcel->getActiveSheet()->setCellValue('G9',"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('H9',"Jangka Waktu");
		$objPHPExcel->getActiveSheet()->setCellValue('I9',"Ang. Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('J9',"Ang. Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('K9',"Jml Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('L9',"Jtempo Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('M9',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('N9',"Saldo Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('O9',"Saldo Hutang");
		// $objPHPExcel->getActiveSheet()->setCellValue('L9',"Ang. Ke");
		
		$objPHPExcel->getActiveSheet()->getStyle('B2:B4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B9:P9')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B9:P9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B9:P9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O9')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P9')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);

		$ii = 10;
		$row_total = count($datas)+10;
	    $total_jml_bayar = 0;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			 if ($datas[$i]['trx_date']==NULL) {
	          $trx_date = "-";
	        } else {
	          $trx_date = $this->format_date_detail($datas[$i]['trx_date'],'id',false,'-');
	        }

			if($datas[$i]['periode_jangka_waktu']=='0'){
	          $periode_jangka_waktu = "Harian";
	        }else if($datas[$i]['periode_jangka_waktu']=='1'){
	          $periode_jangka_waktu = "Mingguan";
	        }else if($datas[$i]['periode_jangka_waktu']=='2'){
	          $periode_jangka_waktu = "Bulanan";
	        }else if($datas[$i]['periode_jangka_waktu']=='3'){
	          $periode_jangka_waktu = "Jatuh Tempo";
	        }else{
	          $periode_jangka_waktu = "-";
	        }

	        $total_jml_bayar += $datas[$i]['jml_bayar'];

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1));
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$trx_date);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".$datas[$i]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$periode_jangka_waktu." ".$datas[$i]['jangka_waktu']." x");
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".number_format($datas[$i]['angsuran_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($datas[$i]['angsuran_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii," ".number_format($datas[$i]['jml_angsuran'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii," ".$this->format_date_detail($datas[$i]['jtempo_angsuran_last'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii," ".number_format($datas[$i]['saldo_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii," ".number_format($datas[$i]['saldo_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii," ".number_format(($datas[$i]['saldo_pokok']+$datas[$i]['saldo_margin']),0,',','.'));
			// $objPHPExcel->getActiveSheet()->setCellValue('P'.$ii," ".number_format($datas[$i]['angsuran_ke'],0,',','.'));

			$ii++;
		
		}//END FOR*/

			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_total," ".number_format($total_jml_bayar,0,',','.'));
			$objPHPExcel->getActiveSheet()->getStyle('K'.$row_total.':K'.$row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LIST-ANGSURAN-PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}


	public function export_rekap_pengajuan_pembiayaan_product()
	{
		$tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

       if ($tanggal1=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
        
                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_product($cabang,$tanggal1_,$tanggal2_);
		            if ($cabang !='00000') 
		            {
		                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $datacabang = "Semua Cabang";
		            }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pengajuan Pembiayaan Berdasarkan Produk");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
			// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Nominal");

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

      		$total_anggota = 0;
      		$total_pokok = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['num'];     
       			 $total_pokok+=$datas[$i]['amount'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['amount'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':D'.$ii)->getFont()->setSize(10);
				
				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':D'.$iii)->getFont()->setSize(10);

			}

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REPORT_REKAP_PENGAJUAN_PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_list_jatuh_tempo_angsuran()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$cabang = $this->uri->segment(5);		
		$petugas = $this->uri->segment(6);	
		$produk = $this->uri->segment(7);	
		$resort = $this->uri->segment(8);	
		$datas = $this->model_laporan_to_pdf->export_list_jatuh_tempo_angsuran($tanggal1_,$tanggal2_,$cabang,$petugas,$produk,$resort);
		$produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        $resort_name = $this->model_laporan->get_resort_name($resort);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($cabang !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Laporan Jatuh Tempo Angsuran");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4','Produk :'.$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5','Petugas :'.$petugas_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6','Resort :'.$resort_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A7:I7');
		$objPHPExcel->getActiveSheet()->setCellValue('A7','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);

		$objPHPExcel->getActiveSheet()->setCellValue('A8',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B8',"No. Rekening");
		$objPHPExcel->getActiveSheet()->setCellValue('C8',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('D8',"Produk");
		$objPHPExcel->getActiveSheet()->setCellValue('E8',"Besar Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('F8',"Tanggal Angsur");
		$objPHPExcel->getActiveSheet()->setCellValue('G8',"Besar Yang Dibayarkan");
		$objPHPExcel->getActiveSheet()->setCellValue('H8',"Tanggal Bayar");
		$objPHPExcel->getActiveSheet()->setCellValue('I8',"Angsuran Ke");
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('A8:B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

		$ii = 9;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii," ".$datas[$i]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($datas[$i]['besar_angsuran'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,number_format($datas[$i]['besar_yg_dibayar'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$this->format_date_detail($datas[$i]['trx_date'],'id',false,'-'));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['angsuran_ke']);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':G'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$ii.':H'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$ii.':I'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':I'.$ii)->getFont()->setSize(9);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':B'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$ii++;
		
		}
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="list_jatuh_tempo_angsuran.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/*LAPORAN DATA LENGKAP ANGGOTA*/
	public function export_data_lengkap_anggota()
	{
        $cif_no = $this->uri->segment(3);
        $data_anggota = $this->model_laporan_to_pdf->export_data_lengkap_anggota($cif_no);
        $data_tabungan = $this->model_laporan_to_pdf->export_data_lengkap_tabungan($cif_no);
        $data_deposito = $this->model_laporan_to_pdf->export_data_lengkap_deposito($cif_no);
        $data_pembiayaan = $this->model_laporan_to_pdf->export_data_lengkap_pembiayaan($cif_no);
	
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

		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN DATA LENGKAP ANGGOTA");
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Id Anggota");
		$objPHPExcel->getActiveSheet()->setCellValue('A5',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"Alamat");
		$objPHPExcel->getActiveSheet()->setCellValue('A7',"Tempat Tanggal Lahir");
		$objPHPExcel->getActiveSheet()->setCellValue('A8',"Jenis Kelamin");
		$objPHPExcel->getActiveSheet()->setCellValue('A9',"Nama Ibu Kandung");
		$objPHPExcel->getActiveSheet()->setCellValue('A10',"No. KTP");
		$objPHPExcel->getActiveSheet()->setCellValue('A11',"No. KTP Pasangan");
		$objPHPExcel->getActiveSheet()->setCellValue('A12',"Pekerjaan");
		$objPHPExcel->getActiveSheet()->setCellValue('A13',"Pendapatan");
		$objPHPExcel->getActiveSheet()->setCellValue('A14',"Tanggal Gabung");
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
		foreach($data_anggota as $anggota){
			$id_anggota = isset($anggota['cif_no'])?$anggota['cif_no']:"-";
			$nama = isset($anggota['nama'])?$anggota['nama']:"-";
			$alamat = isset($anggota['alamat'])?$anggota['alamat']:"-";
			$tmp_lahir = isset($anggota['tmp_lahir'])?$anggota['tmp_lahir']:"-";
			$tgl_lahir = $this->format_date_detail($anggota['tgl_lahir'],'id',false,'-');
			$jenis_kelamin = isset($anggota['jenis_kelamin'])?$anggota['jenis_kelamin']:"-";
			$nama_ibu = isset($anggota['ibu_kandung'])?$anggota['ibu_kandung']:"-";
			$no_ktp = isset($anggota['no_ktp'])?$anggota['no_ktp']:"-";
			$no_ktp_pasangan = isset($anggota['identitas_pasangan'])?$anggota['identitas_pasangan']:"-";
			$pekerjaan = isset($anggota['pekerjaan'])?$anggota['pekerjaan']:"-";
			$pendapatan = isset($anggota['pendapatan_perbulan'])?$anggota['pendapatan_perbulan']:"-";
			$tgl_gabung = $this->format_date_detail($anggota['tgl_gabung'],'id',false,'-');
		}
		if($jenis_kelamin=="P"){
			$jenis_kelamin = "PRIA";
		}else{
			$jenis_kelamin = "WANITA";
		}
		$objPHPExcel->getActiveSheet()->setCellValue('B4'," : ".$id_anggota);
		$objPHPExcel->getActiveSheet()->setCellValue('B5'," : ".$nama);
		$objPHPExcel->getActiveSheet()->setCellValue('B6'," : ".$alamat);
		$objPHPExcel->getActiveSheet()->setCellValue('B7'," : ".$tmp_lahir.", ".$tgl_lahir);
		$objPHPExcel->getActiveSheet()->setCellValue('B8'," : ".$jenis_kelamin);
		$objPHPExcel->getActiveSheet()->setCellValue('B9'," : ".$nama_ibu);
		$objPHPExcel->getActiveSheet()->setCellValue('B10'," : ".$no_ktp);
		$objPHPExcel->getActiveSheet()->setCellValue('B11'," : ".$no_ktp_pasangan);
		$objPHPExcel->getActiveSheet()->setCellValue('B12'," : ".$pekerjaan);
		$objPHPExcel->getActiveSheet()->setCellValue('B13'," : Rp. ".number_format($pendapatan,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('B14'," : ".$tgl_gabung);

		$objPHPExcel->getActiveSheet()->setCellValue('A16',"Rekening Anggota");
		if(count($data_tabungan)>0){
			$objPHPExcel->getActiveSheet()->setCellValue('A18',"Tabungan");
			$objPHPExcel->getActiveSheet()->setCellValue('A19',"No. Rekening");
			$objPHPExcel->getActiveSheet()->setCellValue('B19',"Produk");
			$objPHPExcel->getActiveSheet()->setCellValue('C19',"Saldo");
			$objPHPExcel->getActiveSheet()->setCellValue('D19',"Status");
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle('A16')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A18')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A19:D19')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A19')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B19')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C19')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D19')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A19:D19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A19:D19')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}

		$ii = 20;
		for( $i = 0 ; $i < count($data_tabungan) ; $i++ ){
			if($data_tabungan[$i]['status_rekening']==1){
				$status_rekening = "Aktif";
			}else if($data_tabungan[$i]['status_rekening']==2){
				$status_rekening = "Tutup";
			}else if($data_tabungan[$i]['status_rekening']==3){
				$status_rekening = "Blokir";
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii," ".$data_tabungan[$i]['account_saving_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$data_tabungan[$i]['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,number_format($data_tabungan[$i]['saldo_memo'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$status_rekening);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			$ii++;
		
		}//END FOR

		if(count($data_deposito)>0){
			$iii = count($data_tabungan)+21;
			$iiii = count($data_tabungan)+22;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iii,"Deposito");
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iiii,"No. Rekening");
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$iiii,"Produk");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$iiii,"Saldo");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$iiii,"Status");
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiii.':D'.$iiii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$iiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$iiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiii.':D'.$iiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiii.':D'.$iiii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}

		$iiiii = count($data_tabungan)+23;
		for( $d = 0 ; $d < count($data_deposito) ; $d++ ){
			if($data_deposito[$d]['status_rekening']==0){
				$status_rekening = "Registrasi";
			}else if($data_deposito[$d]['status_rekening']==1){
				$status_rekening = "Aktif";
			}else if($data_deposito[$d]['status_rekening']==2){
				$status_rekening = "Tutup";
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iiiii," ".$data_deposito[$d]['account_deposit_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$iiiii,$data_deposito[$d]['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$iiiii,number_format($data_deposito[$d]['nominal'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$iiiii,$status_rekening);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiii.':A'.$iiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$iiiii.':B'.$iiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiiii.':C'.$iiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$iiiii.':D'.$iiiii)->applyFromArray($styleArray);
			$iiiii++;
		
		}//END FOR

		if(count($data_pembiayaan)>0){
			$iiiiii =  count($data_tabungan)+count($data_deposito)+24;
			$iiiiiii =  count($data_tabungan)+count($data_deposito)+25;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iiiiii,"Pembiayaan");
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iiiiiii,"No. Rekening");
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$iiiiiii,"Produk");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$iiiiiii,"Plafon");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$iiiiiii,"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$iiiiiii,"Jangka Waktu");
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$iiiiiii,"Saldo Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$iiiiiii,"Saldo Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$iiiiiii,"Status");
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii.':H'.$iiiiiii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii.':H'.$iiiiiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii.':H'.$iiiiiii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}

		$iiiiiiii = count($data_tabungan)+count($data_deposito)+26;
		for( $p = 0 ; $p < count($data_pembiayaan) ; $p++ ){
			if($data_pembiayaan[$p]['status_rekening']==0){
				$status_rekening = "Registrasi";
			}else if($data_pembiayaan[$p]['status_rekening']==1){
				$status_rekening = "Aktif";
			}else if($data_pembiayaan[$p]['status_rekening']==2){
				$status_rekening = "Lunas";
			}else if($data_pembiayaan[$p]['status_rekening']==3){
				$status_rekening = "Verifikasi";
			}
			if($data_pembiayaan[$p]['periode_jangka_waktu']==0){
				$periode_jangka_waktu = "Harian";
			}else if($data_pembiayaan[$p]['periode_jangka_waktu']==1){
				$periode_jangka_waktu = "Mingguan";
			}else if($data_pembiayaan[$p]['periode_jangka_waktu']==2){
				$periode_jangka_waktu = "Bulanan";
			}else if($data_pembiayaan[$p]['periode_jangka_waktu']==3){
				$periode_jangka_waktu = "Jatuh Tempo";
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$iiiiiiii," ".$data_pembiayaan[$p]['account_financing_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$iiiiiiii,$data_pembiayaan[$p]['product_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$iiiiiiii,number_format($data_pembiayaan[$p]['pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$iiiiiiii,number_format($data_pembiayaan[$p]['margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$iiiiiiii,$data_pembiayaan[$p]['jangka_waktu']." ".$periode_jangka_waktu);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$iiiiiiii,number_format($data_pembiayaan[$p]['saldo_pokok'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$iiiiiiii,number_format($data_pembiayaan[$p]['saldo_margin'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$iiiiiiii,$status_rekening);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiiiiii.':D'.$iiiiiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$iiiiiii.':G'.$iiiiiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$iiiiiii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$iiiiiii.':A'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$iiiiiii.':B'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$iiiiiii.':C'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$iiiiiii.':D'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$iiiiiii.':E'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$iiiiiii.':F'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$iiiiiii.':G'.$iiiiiii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$iiiiiii.':H'.$iiiiiii)->applyFromArray($styleArray);
			$iiiiiiii++;
		
		}//END FOR
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DATA-LENGKAP-ANGGOTA.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/*LAPORAN LABA RUGI PUBLISH*/
	public function export_lap_lr_publish()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }if ($periode_bulan=="" && $periode_tahun==""){            
         echo "<script>alert('Periode belum dilengkapi !');javascript:window.close();</script>";
        }else{

            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
			$datas = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$periode_bulan,$periode_tahun);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
            }else{
                $branch_name = "Semua";
            }

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

			$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('C1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('C2',"LAPORAN LABA RUGI PUBLISH");
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('C4',"Per Tanggal : ".$this->format_date_detail($last_date,'id',false,'-'));

			$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('C5',"Cabang : ".$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('C1:C2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

			$ii = 7;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				if($datas[$i]['item_type']=="0")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1")
				{
					if($datas[$i]['posisi']=='0'){
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					}else{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(false);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(9);
				}
				else if($datas[$i]['item_type']=="3")
				{
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->getFont()->setSize(10);
					}
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        }

				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');

				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$ii++;
			
			}//END FOR*/

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-LABA-RUGI-PUBLISH.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}

    function get_mutasi_saldo(){
        $branch_code = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];

        $last_date = date('Y-m-d',strtotime($periode_tahun.'-'.$periode_bulan.'-01 -1 days'));

        $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
        $thru_periode = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));

        $datas = $this->model_laporan->get_mutasi_saldo($branch_code,$from_periode,$thru_periode);

        $ii = 0;
        $total_awal_pokok = 0;
        $total_awal_margin = 0;
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_akhir_pokok = 0;
        $total_akhir_margin = 0;

        for($i = 0; $i < count($datas); $i++){
        	$total_awal_pokok += $datas[$i]['saldo_pokok'];
        	$total_awal_margin += $datas[$i]['saldo_margin'];
        	$total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
        	$total_angsuran_margin += $datas[$i]['angsuran_margin'];
        	$total_akhir_pokok = $total_awal_pokok - $total_angsuran_pokok;
        	$total_akhir_margin = $total_awal_margin - $total_angsuran_margin;

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
            
            $ii++;
        }

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
    }

	public function neraca_saldo_gl()
	{
		$periode_bulan = $this->uri->segment(3);
        $periode_tahun = $this->uri->segment(4);
        $branch_code = $this->uri->segment(5);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];
        $datas = $this->model_laporan->get_neraca_saldo_gl($branch_code,$periode_bulan,$periode_tahun);
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"NERACA SALDO");
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->mergeCells('A4:F4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Periode : ".$periode_bulan." - ".$periode_tahun);

		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);

		$objPHPExcel->getActiveSheet()->setCellValue('A6','No');
		$objPHPExcel->getActiveSheet()->setCellValue('B6','Account');
		$objPHPExcel->getActiveSheet()->setCellValue('C6','Saldo Awal');
		$objPHPExcel->getActiveSheet()->setCellValue('D6','Debit');
		$objPHPExcel->getActiveSheet()->setCellValue('E6','Credit');
		$objPHPExcel->getActiveSheet()->setCellValue('F6','Saldo Akhir');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$ii = 7;
		for( $i = 0 ; $i < count($data['data']) ; $i++ )
		{
			$datax = $data['data'];
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$datax[$i]['nomor']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datax[$i]['account']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,(($datax[$i]['saldo_awal']=='')?'':number_format($datax[$i]['saldo_awal'],2,',','.')));
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,(($datax[$i]['debit']=='')?'':number_format($datax[$i]['debit'],2,',','.')));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,(($datax[$i]['credit']=='')?'':number_format($datax[$i]['credit'],2,',','.')));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,(($datax[$i]['saldo_akhir']=='')?'':number_format($datax[$i]['saldo_akhir'],2,',','.')));

			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
			
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$ii++;
		
		}//END FOR*/
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,number_format($data['total_debit'],2,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,number_format($data['total_credit'],2,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Trial_Balance_'.date('YmdHis').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	/*
	Modul Laporan Kolektibilitas
	author : Ujang Irawan
	date : 08-10-2014 09:38
	*/

	public function export_rekapitulasi_npl()
	{
		$branch_code = $this->uri->segment(3);	
	 	$branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        switch ($branch_class) {
            case '0':
              $branch_class_name = "Kepala Pusat";
              break;
            case '1':
              $branch_class_name = "Kepala Wilayah";
              break;
            case '2':
              $branch_class_name = "Kepala Cabang";
              break;
            case '3':
              $branch_class_name = "Kepala Capem";
              break;
            default:
              $branch_class_name = "-";
              break;
        }


        if ($branch_code !='00000'){
            $branch_name = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch_class=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
		$datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl($branch_code);
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN REKAPITULASI NPL");
		$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4','Kantor Cabang');
		$objPHPExcel->getActiveSheet()->setCellValue('C4',':');
		$objPHPExcel->getActiveSheet()->setCellValue('D4',$branch_name);

		$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:B7');
		$objPHPExcel->getActiveSheet()->mergeCells('C6:E6');
		$objPHPExcel->getActiveSheet()->mergeCells('F6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('I6:K6');
		$objPHPExcel->getActiveSheet()->mergeCells('L6:N6');
		$objPHPExcel->getActiveSheet()->mergeCells('O6:Q6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6',"NO");
		$objPHPExcel->getActiveSheet()->setCellValue('B6',"Kantor");
		$objPHPExcel->getActiveSheet()->setCellValue('C6',"KOL 1");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"CPP");
		$objPHPExcel->getActiveSheet()->setCellValue('F6',"KOL 2");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('G7',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('H7',"CPP");
		$objPHPExcel->getActiveSheet()->setCellValue('I6',"KOL 3");
		$objPHPExcel->getActiveSheet()->setCellValue('I7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('J7',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('K7',"CPP");
		$objPHPExcel->getActiveSheet()->setCellValue('L6',"KOL 4");
		$objPHPExcel->getActiveSheet()->setCellValue('L7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('M7',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('N7',"CPP");
		$objPHPExcel->getActiveSheet()->setCellValue('O6',"TOTAL");
		$objPHPExcel->getActiveSheet()->setCellValue('O7',"Jml");
		$objPHPExcel->getActiveSheet()->setCellValue('P7',"Saldo Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('Q7',"CPP");

		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:Q7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('Q6')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('Q7')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C6:Q7')->getFont()->setSize(11);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);

					
			$ii = 8;
	        $total = 0;
	        $total_saldo = 0;
	        $total_cpp = 0;
	        $total_jumlah1 = 0;
	        $total_jumlah2 = 0;
	        $total_jumlah3 = 0;
	        $total_jumlah4 = 0;
	        $total_jumlah5 = 0;
	        $total_saldo1 = 0;
	        $total_saldo2 = 0;
	        $total_saldo3 = 0;
	        $total_saldo4 = 0;
	        $total_saldo5 = 0;
	        $total_cpp1 = 0;
	        $total_cpp2 = 0;
	        $total_cpp3 = 0;
	        $total_cpp4 = 0;
	        $total_cpp5 = 0;
			$row_total = count($datas)+8;
			$n=1;
			$cabang='';
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
		        
				if($datas[$i]['branch_class']==2){
					if($cabang!=$datas[$i]['branch_name']){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
						$ii++;
					}
				}

		        $total = $datas[$i]['jml1']+$datas[$i]['jml2']+$datas[$i]['jml3']+$datas[$i]['jml4'];
		        $total_saldo = $datas[$i]['saldo_pokok1']+$datas[$i]['saldo_pokok2']+$datas[$i]['saldo_pokok3']+$datas[$i]['saldo_pokok4'];
		        $total_cpp = $datas[$i]['cpp1']+$datas[$i]['cpp2']+$datas[$i]['cpp3']+$datas[$i]['cpp4'];
		        if($datas[$i]['branch_class']=='2'){
		          $total_jumlah1 += $datas[$i]['jml1'];
		          $total_jumlah2 += $datas[$i]['jml2'];
		          $total_jumlah3 += $datas[$i]['jml3'];
		          $total_jumlah4 += $datas[$i]['jml4'];
		          $total_jumlah5 += $total;
		          $total_saldo1 += $datas[$i]['saldo_pokok1'];
		          $total_saldo2 += $datas[$i]['saldo_pokok2'];
		          $total_saldo3 += $datas[$i]['saldo_pokok3'];
		          $total_saldo4 += $datas[$i]['saldo_pokok4'];
		          $total_saldo5 += $total_saldo;
		          $total_cpp1 += $datas[$i]['cpp1'];
		          $total_cpp2 += $datas[$i]['cpp2'];
		          $total_cpp3 += $datas[$i]['cpp3'];
		          $total_cpp4 += $datas[$i]['cpp4'];
		          $total_cpp5 += $total_cpp;
		      	}

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['branch_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,(($datas[$i]['jml1']=='')?'0':$datas[$i]['jml1']));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,(($datas[$i]['saldo_pokok1']=='')?'0':number_format($datas[$i]['saldo_pokok1'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,(($datas[$i]['cpp1']=='')?'0':number_format($datas[$i]['cpp1'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,(($datas[$i]['jml2']=='')?'0':$datas[$i]['jml2']));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,(($datas[$i]['saldo_pokok2']=='')?'0':number_format($datas[$i]['saldo_pokok2'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,(($datas[$i]['cpp2']=='')?'0':number_format($datas[$i]['cpp2'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,(($datas[$i]['jml3']=='')?'0':$datas[$i]['jml3']));
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,(($datas[$i]['saldo_pokok3']=='')?'0':number_format($datas[$i]['saldo_pokok3'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,(($datas[$i]['cpp3']=='')?'0':number_format($datas[$i]['cpp3'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,(($datas[$i]['jml4']=='')?'0':$datas[$i]['jml4']));
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,(($datas[$i]['saldo_pokok4']=='')?'0':number_format($datas[$i]['saldo_pokok4'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii,(($datas[$i]['cpp4']=='')?'0':number_format($datas[$i]['cpp4'],0,',','.')));
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii,number_format($total,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii,number_format($total_saldo,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$ii,number_format($total_cpp,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':Q'.$ii)->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('M'.$ii.':N'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$ii.':Q'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$ii++;

				$cabang=$datas[$i]['branch_name'];

				if($n==count($datas)){
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
					$ii++;
				}
				$n++;
			
			}//END FOR*/

			if(count($datas)==0){
					
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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
				$ii++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,"Total");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii," ".$total_jumlah1);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($total_saldo1,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($total_cpp1,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".$total_jumlah2);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii," ".number_format($total_saldo2,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii," ".number_format($total_cpp2,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii," ".$total_jumlah3);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii," ".number_format($total_saldo3,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii," ".number_format($total_cpp3,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii," ".$total_jumlah4);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii," ".number_format($total_saldo4,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$ii," ".number_format($total_cpp4,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$ii," ".$total_jumlah5);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$ii," ".number_format($total_saldo5,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$ii," ".number_format($total_cpp5,0,',','.'));
			$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':E'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$ii.':H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$ii.':K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$ii.':N'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$ii.':Q'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('L'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':Q'.$ii)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':Q'.$ii)->getFont()->setSize(10);


			$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
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

			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-REKAPITULASI-NPL.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
	}

    /*
    | Modul : Laporan Neraca Rinci
    | author : Sayyid Nurkilah
    | date : 2014-10-09 09:24
    */
	public function export_neraca_rinci_gl()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}

            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
			$datas = $this->model_laporan_to_pdf->export_neraca_rinci_gl($cabang,$periode_bulan,$periode_tahun,$periode_hari);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }

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

			// $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			// $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN NERACA RINCI");
			// $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Per Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('B4',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C4',$this->format_date_detail($last_date,'id',false,'-'));

			// $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Cabang");
			$objPHPExcel->getActiveSheet()->setCellValue('B5',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C5',$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(51);

			$cCA = createColumnsArray('XFD');

			if($branch_class=='0'){
				$branch_class_output='1';
			}else if($branch_class=='1'){
				$branch_class_output='2';
			}else if($branch_class=='2'){
				$branch_class_output='3';
			}else{
				$branch_class_output='';
			}
			$branch_child_data = $this->model_laporan_to_pdf->get_branch_by_branch_induk($cabang,$branch_class_output);

			$objPHPExcel->getActiveSheet()->setCellValue('D7','JUMLAH');
			$objPHPExcel->getActiveSheet()->getStyle('D7:D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
			for($h=0;$h<count($branch_child_data);$h++)
			{
				$branchColumn=$cCA[($h+4)];
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'7',$branch_child_data[$h]['branch_name']);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7'.':'.$branchColumn.'7')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setSize(12);
			}

			$ii = 8;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				/*
				| BEGIN SET OPTION
				*/
				if($datas[$i]['item_type']=="0") // TITLE
				{
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1") // SUMMARY
				{
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					}else{
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2") // FORMULA
				{
					if($datas[$i]['formula_text_bold']==0){
						if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}else if($datas[$i]['formula_text_bold']==1){
						if($datas[$i]['posisi']=='0'){
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
						}else{
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);		
					}
				}
				else if($datas[$i]['item_type']=="3") // TOTAL
				{
					if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setSize(10);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){ // total
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setBold(true);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        }
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':C'.$ii);
				/*
				| END SET OPTION
				*/

		        // CELL VALUE
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');
				if(count($branch_child_data)==0){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':C'.$ii)->applyFromArray($styleArray);
				}

				if($saldo!='')
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$saldo_per_item = $this->model_laporan_to_pdf->get_saldo_report_by_item_code('11',$datas[$i]['item_code'],$branch_child_data[$j]['branch_code'],$periode_bulan,$periode_tahun,$periode_hari);
						
						$branchColumn=$cCA[($j+4)];
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setSize(10);
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.$ii,number_format($saldo_per_item,2,',','.').' ');
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		        		if($datas[$i]['item_type']=='3' && $datas[$i]['posisi']=='0'){ // total
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setSize(11);
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setBold(true);
						}
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						// echo '('.$datas[$i]['item_code'].'|'.$periode_bulan.'|'.$periode_tahun.')';
					}	
				}
				else
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$branchColumn=$cCA[($j+4)];
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
					}
				}
				$ii++;
			
			}//END FOR*/
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));


			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-NERACA-RINCI.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}

	/*
    | Modul : Laporan Laba Rugi Rinci
    | author : Sayyid Nurkilah
    | date : 2014-10-09 09:24
    */
	public function export_lap_lr_rinci()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        $from_date=$this->get_from_trx_date();
        $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}

            
			$datas = $this->model_laporan_to_pdf->export_lap_laba_rugi_rinci($cabang,$from_date,$last_date);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= "";
                }
            }else{
                $branch_name = "PUSAT";
            }

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

			// $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			// $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN LABA RUGI RINCI");
			// $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Per Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('B4',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C4',$this->format_date_detail($last_date,'id',false,'-'));

			// $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Cabang");
			$objPHPExcel->getActiveSheet()->setCellValue('B5',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C5',$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(51);

			$cCA = createColumnsArray('XFD');

			if($branch_class=='0'){
				$branch_class_output='1';
			}else if($branch_class=='1'){
				$branch_class_output='2';
			}else if($branch_class=='2'){
				$branch_class_output='3';
			}else{
				$branch_class_output='';
			}
			$branch_child_data = $this->model_laporan_to_pdf->get_branch_by_branch_induk($cabang,$branch_class_output);

			$objPHPExcel->getActiveSheet()->setCellValue('D7','JUMLAH');
			$objPHPExcel->getActiveSheet()->mergeCells('D7:F7');
			$objPHPExcel->getActiveSheet()->getStyle('D7:F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
			
			$objPHPExcel->getActiveSheet()->setCellValue('D8','sd Bulan Lalu');
			$objPHPExcel->getActiveSheet()->setCellValue('E8','Bulan Ini');
			$objPHPExcel->getActiveSheet()->setCellValue('F8','Akumulasi');
			$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setSize(12);

			for($h=0;$h<count($branch_child_data);$h++)
			{
				$branchColumn_idx=$h+6;
				$branchColumn_idx2=$h+7;
				$branchColumn_idx3=$h+8;
				$branchColumn=$cCA[$branchColumn_idx];
				$branchColumn2=$cCA[$branchColumn_idx2];
				$branchColumn3=$cCA[$branchColumn_idx3];
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'7',$branch_child_data[$h]['branch_name']);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7'.':'.$branchColumn3.'7')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->mergeCells($branchColumn.'7:'.$branchColumn3.'7');
			
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'8','sd Bulan Lalu');
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn2.'8','Bulan Ini');
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn3.'8','Akumulasi');
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8'.':'.$branchColumn3.'8')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8'.':'.$branchColumn3.'8')->getFont()->setSize(12);
			}

			$ii = 9;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				/*
				| BEGIN SET OPTION
				*/
				if($datas[$i]['item_type']=="0") // TITLE
				{
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1") // SUMMARY
				{
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					}else{
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2") // FORMULA
				{
					if($datas[$i]['formula_text_bold']==0){
						if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}else if($datas[$i]['formula_text_bold']==1){
						if($datas[$i]['posisi']=='0'){
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
						}else{
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);		
					}
				}
				else if($datas[$i]['item_type']=="3") // TOTAL
				{
					if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setSize(10);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	$saldo_mutasi='';
		        	$total_saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){ // total
		        	$saldo=number_format($datas[$i]['saldo'],2,',','.');
		        	$saldo_mutasi=number_format($datas[$i]['saldo_mutasi'],2,',','.');
		        	$total_saldo=number_format($datas[$i]['saldo']+$datas[$i]['saldo_mutasi'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setBold(true);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],2,',','.');
		        	$saldo_mutasi=number_format($datas[$i]['saldo_mutasi'],2,',','.');
		        	$total_saldo=number_format($datas[$i]['saldo']+$datas[$i]['saldo_mutasi'],2,',','.');
		        }
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':C'.$ii);
				/*
				| END SET OPTION
				*/

		        // CELL VALUE
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$saldo_mutasi.' ');
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$total_saldo.' ');
				if(count($branch_child_data)==0){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':C'.$ii)->applyFromArray($styleArray);
				}

				if($saldo!='')
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$saldoarr = $this->model_laporan_to_pdf->get_saldo_report_by_item_code2('21',$datas[$i]['item_code'],$branch_child_data[$j]['branch_code'],$from_date,$last_date);
						$total_saldo=$saldoarr['saldo']+$saldoarr['saldo_mutasi'];

						$branchColumn_idx=$j+6;
						$branchColumn_idx2=$j+7;
						$branchColumn_idx3=$j+8;
						$branchColumn=$cCA[$branchColumn_idx];
						$branchColumn2=$cCA[$branchColumn_idx2];
						$branchColumn3=$cCA[$branchColumn_idx3];
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setSize(10);
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.$ii,number_format($saldoarr['saldo'],2,',','.').' ');
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn2.$ii,number_format($saldoarr['saldo_mutasi'],2,',','.').' ');
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn3.$ii,number_format($total_saldo,2,',','.').' ');
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn2)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn3)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.$ii.':'.$branchColumn2.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.$ii.':'.$branchColumn3.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		        		if($datas[$i]['item_type']=='3' && $datas[$i]['posisi']=='0'){ // total
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setSize(11);
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setBold(true);
						}
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						// echo '('.$datas[$i]['item_code'].'|'.$periode_bulan.'|'.$periode_tahun.')';
					}	
				}
				else
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$branchColumn_idx3=$j+8;
						$branchColumn3=$cCA[$branchColumn_idx3];
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn3.$ii)->applyFromArray($styleArray);
					}
				}
				$ii++;
			
			}//END FOR*/
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));


			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-LABA-RUGI-RINCI.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}




	/*
	| EXPORT NERACA GL
	| by sayyid
	*/
	public function export_neraca_gl2()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}

            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
			$datas = $this->model_laporan_to_pdf->export_neraca_gl($cabang,$periode_bulan,$periode_tahun,$periode_hari);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }

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

			// $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			// $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN NERACA");
			// $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Per Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('B4',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C4',$this->format_date_detail($last_date,'id',false,'-'));

			// $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Cabang");
			$objPHPExcel->getActiveSheet()->setCellValue('B5',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C5',$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(51);

			$cCA = createColumnsArray('XFD');

			if($branch_class=='0'){
				$branch_class_output='1';
			}else if($branch_class=='1'){
				$branch_class_output='2';
			}else if($branch_class=='2'){
				$branch_class_output='3';
			}else{
				$branch_class_output='';
			}
			$branch_child_data = $this->model_laporan_to_pdf->get_branch_by_branch_induk($cabang,$branch_class_output);

			$objPHPExcel->getActiveSheet()->setCellValue('D7','JUMLAH');
			$objPHPExcel->getActiveSheet()->getStyle('D7:D7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
			for($h=0;$h<count($branch_child_data);$h++)
			{
				$branchColumn=$cCA[($h+4)];
				// $objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'7',$branch_child_data[$h]['branch_name']);
				// $objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7'.':'.$branchColumn.'7')->applyFromArray($styleArray);
				// $objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// $objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setBold(true);
				// $objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setSize(12);
			}

			$ii = 8;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				/*
				| BEGIN SET OPTION
				*/
				if($datas[$i]['item_type']=="0") // TITLE
				{
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1") // SUMMARY
				{
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					}else{
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2") // FORMULA
				{
					if($datas[$i]['formula_text_bold']==0){
						if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}else if($datas[$i]['formula_text_bold']==1){
						if($datas[$i]['posisi']=='0'){
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
						}else{
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);		
					}
				}
				else if($datas[$i]['item_type']=="3") // TOTAL
				{
					if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setSize(10);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){ // total
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getFont()->setBold(true);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],0,',','.');
		        }
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':C'.$ii);
				/*
				| END SET OPTION
				*/

		        // CELL VALUE
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');
				if(count($branch_child_data)==0){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':C'.$ii)->applyFromArray($styleArray);
				}

				if($saldo!='')
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						// $saldo_per_item = $this->model_laporan_to_pdf->get_saldo_report_by_item_code('10',$datas[$i]['item_code'],$branch_child_data[$j]['branch_code'],$periode_bulan,$periode_tahun,$periode_hari);
						
						$branchColumn=$cCA[($j+3)];
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setSize(10);
						//$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.$ii,number_format($saldo_per_item,2,',','.').' ');
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		        		if($datas[$i]['item_type']=='3' && $datas[$i]['posisi']=='0'){ // total
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setSize(11);
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii)->getFont()->setBold(true);
						}
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
					}	
				}
				else
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$branchColumn=$cCA[($j+3)];
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
					}
				}
				$ii++;
			
			}//END FOR*/
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));


			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-NERACA.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}


	/*
	| EXPORT LABA RUGI GL
	| by sayyid
	*/
	public function export_lap_lr2()
	{
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        $from_date=$this->get_from_trx_date();
        $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
				case '0':
				  $branch_class_name = "Kepala Pusat";
				  break;
				case '1':
				  $branch_class_name = "Kepala Wilayah";
				  break;
				case '2':
				  $branch_class_name = "Kepala Cabang";
				  break;
				case '3':
				  $branch_class_name = "Kepala Capem";
				  break;
				default:
				  $branch_class_name = "-";
				  break;
			}

            
			$datas = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$from_date,$last_date);
            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= "";
                }
            }else{
                $branch_name = "PUSAT";
            }

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

			// $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			// $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"LAPORAN LABA RUGI");
			// $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
			$objPHPExcel->getActiveSheet()->setCellValue('A4',"Per Tanggal");
			$objPHPExcel->getActiveSheet()->setCellValue('B4',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C4',$this->format_date_detail($last_date,'id',false,'-'));

			// $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Cabang");
			$objPHPExcel->getActiveSheet()->setCellValue('B5',":");
			$objPHPExcel->getActiveSheet()->setCellValue('C5',$branch_name);

			$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(51);

			$cCA = createColumnsArray('XFD');

			if($branch_class=='0'){
				$branch_class_output='1';
			}else if($branch_class=='1'){
				$branch_class_output='2';
			}else if($branch_class=='2'){
				$branch_class_output='3';
			}else{
				$branch_class_output='';
			}
			$branch_child_data = $this->model_laporan_to_pdf->get_branch_by_branch_induk($cabang,$branch_class_output);

			$objPHPExcel->getActiveSheet()->setCellValue('D7','JUMLAH');
			$objPHPExcel->getActiveSheet()->mergeCells('D7:F7');
			$objPHPExcel->getActiveSheet()->getStyle('D7:F7')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
			
			$objPHPExcel->getActiveSheet()->setCellValue('D8','sd Bulan Lalu');
			$objPHPExcel->getActiveSheet()->setCellValue('E8','Bulan Ini');
			$objPHPExcel->getActiveSheet()->setCellValue('F8','Akumulasi');
			$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('E8')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setSize(12);

			for($h=0;$h<count($branch_child_data);$h++)
			{
				$branchColumn_idx=$h+6;
				$branchColumn_idx2=$h+7;
				$branchColumn_idx3=$h+8;
				$branchColumn=$cCA[$branchColumn_idx];
				$branchColumn2=$cCA[$branchColumn_idx2];
				$branchColumn3=$cCA[$branchColumn_idx3];
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'7',$branch_child_data[$h]['branch_name']);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7'.':'.$branchColumn3.'7')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->mergeCells($branchColumn.'7:'.$branchColumn3.'7');
			
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.'8','sd Bulan Lalu');
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn2.'8','Bulan Ini');
				$objPHPExcel->getActiveSheet()->setCellValue($branchColumn3.'8','Akumulasi');
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.'8')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8'.':'.$branchColumn3.'8')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($branchColumn.'8'.':'.$branchColumn3.'8')->getFont()->setSize(12);
			}

			$ii = 9;
			$row_total = count($datas)+8;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{

				/*
				| BEGIN SET OPTION
				*/
				if($datas[$i]['item_type']=="0") // TITLE
				{
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else if($datas[$i]['posisi']=='1'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
				}
				else if($datas[$i]['item_type']=="1") // SUMMARY
				{
					if($datas[$i]['posisi']=='0'){
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
					}else{
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
				}
				else if($datas[$i]['item_type']=="2") // FORMULA
				{
					if($datas[$i]['formula_text_bold']==0){
						if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
						}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(false);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}else if($datas[$i]['formula_text_bold']==1){
						if($datas[$i]['posisi']=='0'){
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
						}else{
								$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
						}
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);		
					}
				}
				else if($datas[$i]['item_type']=="3") // TOTAL
				{
					if($datas[$i]['posisi']=='0'){
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(12);
					}else{
							$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setSize(10);
					}
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii)->getFont()->setBold(true);
				}

		        $item_name = $datas[$i]['item_name'];
		        $item_name = str_replace('&nbsp;',' ',$item_name);
		        $item_name = str_replace('<b>','',$item_name);
		        $item_name = str_replace('</b>','',$item_name);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setSize(10);
		        if($datas[$i]['item_type']=='0'){ // title
		        	$saldo='';
		        	$saldo_mutasi='';
		        	$total_saldo='';
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
		        	}
		        }else if($datas[$i]['item_type']=='3'){ // total
		        	$saldo=number_format($datas[$i]['saldo'],2,',','.');
		        	$saldo_mutasi=number_format($datas[$i]['saldo_mutasi'],2,',','.');
		        	$total_saldo=number_format($datas[$i]['saldo']+$datas[$i]['saldo_mutasi'],0,',','.');
		        	if($datas[$i]['posisi']=='0'){
		        		$item_name = trim($item_name);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getFont()->setBold(true);
		        	}
		        }else{
		        	$saldo=number_format($datas[$i]['saldo'],2,',','.');
		        	$saldo_mutasi=number_format($datas[$i]['saldo_mutasi'],2,',','.');
		        	$total_saldo=number_format($datas[$i]['saldo']+$datas[$i]['saldo_mutasi'],2,',','.');
		        }
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$ii.':C'.$ii);
				/*
				| END SET OPTION
				*/

		        // CELL VALUE
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,$item_name);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$saldo.' ');
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$saldo_mutasi.' ');
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$total_saldo.' ');
				if(count($branch_child_data)==0){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':C'.$ii)->applyFromArray($styleArray);
				}

				if($saldo!='')
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$saldoarr = $this->model_laporan_to_pdf->get_saldo_report_by_item_code2('20',$datas[$i]['item_code'],$branch_child_data[$j]['branch_code'],$from_date,$last_date);
						$total_saldo=$saldoarr['saldo']+$saldoarr['saldo_mutasi'];

						$branchColumn_idx=$j+6;
						$branchColumn_idx2=$j+7;
						$branchColumn_idx3=$j+8;
						$branchColumn=$cCA[$branchColumn_idx];
						$branchColumn2=$cCA[$branchColumn_idx2];
						$branchColumn3=$cCA[$branchColumn_idx3];
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setSize(10);
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn.$ii,number_format($saldoarr['saldo'],2,',','.').' ');
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn2.$ii,number_format($saldoarr['saldo_mutasi'],2,',','.').' ');
						$objPHPExcel->getActiveSheet()->setCellValue($branchColumn3.$ii,number_format($total_saldo,2,',','.').' ');
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn2)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getColumnDimension($branchColumn3)->setWidth(24);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn2.$ii.':'.$branchColumn2.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn3.$ii.':'.$branchColumn3.$ii)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		        		if($datas[$i]['item_type']=='3' && $datas[$i]['posisi']=='0'){ // total
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setSize(11);
							$objPHPExcel->getActiveSheet()->getStyle($branchColumn.$ii.':'.$branchColumn3.$ii)->getFont()->setBold(true);
						}
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn.$ii)->applyFromArray($styleArray);
						// echo '('.$datas[$i]['item_code'].'|'.$periode_bulan.'|'.$periode_tahun.')';
					}	
				}
				else
				{
					for($j=0;$j<count($branch_child_data);$j++)
					{
						$branchColumn_idx3=$j+8;
						$branchColumn3=$cCA[$branchColumn_idx3];
						$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':'.$branchColumn3.$ii)->applyFromArray($styleArray);
					}
				}
				$ii++;
			
			}//END FOR*/
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,'Mengetahui');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$branch_name.', '.date('d-m-Y'));
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,'dibuat');
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$ii++;
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$branch_class_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$this->session->userdata('fullname'));


			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="LAPORAN-LABA-RUGI.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}

	public function export_list_jatuh_tempo_angsuran_koptel()
	{
		$tanggal1 = $this->uri->segment(3);
		$tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
		$tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
		$tanggal2 = $this->uri->segment(4);
		$tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
		$tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$produk = $this->uri->segment(5);		
		$datas = $this->model_laporan->export_list_jatuh_tempo_angsuran($tanggal1_,$tanggal2_,$produk);
		$produk_name = $this->model_laporan->get_produk_name($produk);
        
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

		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2',"Laporan Jatuh Tempo Angsuran");
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4','Produk :'.$produk_name);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5','Tanggal :'.$tanggal1__.' s/d '.$tanggal2__);

		$objPHPExcel->getActiveSheet()->setCellValue('A7',"No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B7',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('C7',"Saldo Sebelumnya");
		$objPHPExcel->getActiveSheet()->setCellValue('D7',"Jumlah Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('E7',"JTO Angsuran Next");
		$objPHPExcel->getActiveSheet()->setCellValue('F7',"Tanggal Jatuh Tempo");
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:I7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('A7:B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(23);

		$ii = 8;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['cif_no']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['saldo_sebelumnya']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['besar_angsuran']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,"01".substr(date("dmY",strtotime($datas[$i]['jtempo_angsuran_next'])),-6)." ");
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,date("dmY",strtotime($datas[$i]['tanggal_jtempo']))." ");
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['code_divisi']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['loker']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,$datas[$i]['kerja_bantu']." ");

			// $objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);

			// $objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':B'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$ii++;
		
		}
			$objPHPExcel->getActiveSheet()->getStyle('A8:I'.($ii+count($datas)))->getFont()->setSize(9);
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="list_jatuh_tempo_angsuran.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function preview_penarikan_twp() //27-07-2015
	{
		$trx_id = $this->uri->segment(3);		
		$datas = $this->model_laporan_to_pdf->preview_penarikan_twp($trx_id);
        
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


		$objPHPExcel->getActiveSheet()->setCellValue('B3',"No");
		$objPHPExcel->getActiveSheet()->setCellValue('C3',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('D3',"Nama");
		// $objPHPExcel->getActiveSheet()->setCellValue('E3',"Divisi");
		// $objPHPExcel->getActiveSheet()->setCellValue('F3',"Loker");
		// $objPHPExcel->getActiveSheet()->setCellValue('G3',"Kerja bantu");
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Saldo Rill");
		
		$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

		$ii = 4;
		$total_saldo_riil=0;
		$total_saldo_riil_trx=0;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			if($datas[$i]['saldo_riil']==''){
				$datas[$i]['nama_pegawai'] = 'Tidak ditemukan';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1)." ");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nik']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nama_pegawai']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['code_divisi']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['loker']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['kerja_bantu']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['saldo_riil']);
			// $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['saldo_riil_trx']);
			// $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,($datas[$i]['saldo_riil']-$datas[$i]['saldo_riil_trx']));
			$total_saldo_riil+=$datas[$i]['saldo_riil'];
			$ii++;		
		}		
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$total_saldo_riil);
		// $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$total_saldo_riil_trx);
		$objPHPExcel->getActiveSheet()->getStyle('B4:E'.(3+count($datas)))->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B4:E'.(3+count($datas)))->applyFromArray($styleArray);
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="preview_penarikan_twp.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function preview_setoran_twp() //27-07-2015
	{
		$trx_id = $this->uri->segment(3);		
		$datas = $this->model_laporan_to_pdf->preview_setoran_twp($trx_id);
        
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


		$objPHPExcel->getActiveSheet()->setCellValue('B3',"No");
		$objPHPExcel->getActiveSheet()->setCellValue('C3',"Nama");
		$objPHPExcel->getActiveSheet()->setCellValue('D3',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('E3',"Saldo");
		// $objPHPExcel->getActiveSheet()->setCellValue('F3',"Loker");
		// $objPHPExcel->getActiveSheet()->setCellValue('G3',"Kerja bantu");
		// $objPHPExcel->getActiveSheet()->setCellValue('H3',"Saldo");
		
		$objPHPExcel->getActiveSheet()->getStyle('B3:E3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B3:E3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);
		// $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

		$ii = 4;
		$total = 0;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1)." ");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama_pegawai']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nik']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['code_divisi']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['loker']." ");
			// $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['kerja_bantu']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['amount']);
			$total += $datas[$i]['amount'];
			$ii++;		
		}
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$total);
		$objPHPExcel->getActiveSheet()->getStyle('B4:E'.(3+count($datas)))->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('B4:E'.(3+count($datas)))->applyFromArray($styleArray);
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="preview_setoran_twp.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function download_pegawai_pensiun() //28-07-2015
	{
		$tgl1 = $this->uri->segment(3);		
		$tgl2 = $this->uri->segment(4);		

        if (strlen($tgl1)!=8 || strlen($tgl2)!=8){            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else{
        	$tgl1 = substr($tgl1,4,4).'-'.substr($tgl1,2,2).'-'.substr($tgl1,0,2);
        	$tgl2 = substr($tgl2,4,4).'-'.substr($tgl2,2,2).'-'.substr($tgl2,0,2);
			$datas = $this->model_laporan_to_pdf->download_pegawai_pensiun($tgl1,$tgl2);
	        
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


			$objPHPExcel->getActiveSheet()->setCellValue('B1',"Pegawai Pensiun");
			$objPHPExcel->getActiveSheet()->setCellValue('D1',$tgl1.' s/d '.$tgl2);
			$objPHPExcel->getActiveSheet()->setCellValue('B3',"No");
			$objPHPExcel->getActiveSheet()->setCellValue('C3',"Nama");
			$objPHPExcel->getActiveSheet()->setCellValue('D3',"NIK");
			$objPHPExcel->getActiveSheet()->setCellValue('E3',"Divisi");
			$objPHPExcel->getActiveSheet()->setCellValue('F3',"Loker");
			$objPHPExcel->getActiveSheet()->setCellValue('G3',"Kerja bantu");
			// $objPHPExcel->getActiveSheet()->setCellValue('H3',"Saldo TWP");
			
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleArray);
			// $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleArray);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			$ii = 4;
			$total = 0;
			for( $i = 0 ; $i < count($datas) ; $i++ )
			{
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,($i+1)." ");
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama_pegawai']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['nik']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['code_divisi']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,$datas[$i]['loker']." ");
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$datas[$i]['kerja_bantu']." ");
				// $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,$datas[$i]['amount']);
				// $total += $datas[$i]['amount'];
				$ii++;		
			}
			// $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$total);
			$objPHPExcel->getActiveSheet()->getStyle('B4:G'.(3+count($datas)))->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('B4:G'.(3+count($datas)))->applyFromArray($styleArray);
			//END FOR
		
			// Redirect output to a client's web browser (Excel2007)
			// Save Excel 2007 file

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="download_pegawai_pensiun.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

			// ----------------------------------------------------------------------
			// [END] EXPORT SCRIPT
			// ----------------------------------------------------------------------
		}
	}


	public function export_list_peserta_asuransi() //27-07-2015
	{
		$tanggal = $this->uri->segment(3);		
		$tanggal2 = $this->uri->segment(4);	
		$product = $this->uri->segment(5);	
		$from_date = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
		$thru_date = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
		$datas = $this->model_laporan->export_list_peserta_asuransi($from_date,$thru_date,$product);

		$show_tgl = $from_date.' s/d '.$thru_date;

		if($product!='-'){
			$show_produk = $this->model_laporan->get_produk_name($product);
		}else{
			$show_produk = 'semua';
		}
        
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


		$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1',"LIST PREMI ASURANSI PEMBIAYAAN");
		$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('A3',"Tanggal : ".$show_tgl);
		$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4',"Produk : ".$show_produk);

		$objPHPExcel->getActiveSheet()->setCellValue('A10',"NO");
		$objPHPExcel->getActiveSheet()->setCellValue('B10',"NIK");
		$objPHPExcel->getActiveSheet()->setCellValue('C10',"NAMA");
		$objPHPExcel->getActiveSheet()->setCellValue('D10',"TANGGAL LAHIR");
		$objPHPExcel->getActiveSheet()->setCellValue('E10',"TEMPAT LAHIR");
		$objPHPExcel->getActiveSheet()->setCellValue('F10',"BESAR PEMBIAYAAN");
		$objPHPExcel->getActiveSheet()->setCellValue('G10',"JANGKA WAKTU (tahun)");
		$objPHPExcel->getActiveSheet()->setCellValue('H10',"PREMI ASURANSI");
		$objPHPExcel->getActiveSheet()->setCellValue('I10',"UJRAH");
		$objPHPExcel->getActiveSheet()->setCellValue('J10',"PREMI ASURANSI TAMBAHAN");
		$objPHPExcel->getActiveSheet()->setCellValue('K10',"TRANSFER PREMI");
		$objPHPExcel->getActiveSheet()->setCellValue('L10',"TANGGAL EFEKTIF");
		$objPHPExcel->getActiveSheet()->setCellValue('M10',"NO SPB");
		
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(25);
		$objPHPExcel->getActiveSheet()->getStyle('A1:M10')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A10:M10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A10:M10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A10:M10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L10')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M10')->applyFromArray($styleArray);
		
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);

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

		$ii = 11;
		$totalF=0;
		$totalH=0;
		$totalI=0;
		$totalJ=0;
		$totalK=0;
		for( $i = 0 ; $i < count($datas) ; $i++ )
		{
			$transfer_premi_asuransi = $datas[$i]['premi_asuransi']-$datas[$i]['ujroh'];
			$jangka_waktu = ceil($datas[$i]['jangka_waktu']/12);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1)." ");
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['nik']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['nama_pegawai']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii,$datas[$i]['tgl_lahir']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii,$datas[$i]['tempat_lahir']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($datas[$i]['jumlah_pembiayaan']));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$ii,$jangka_waktu.' ');
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,number_format($datas[$i]['premi_asuransi']));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,number_format($datas[$i]['ujroh']));
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,number_format($datas[$i]['premi_asuransi_tambahan']));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,number_format($transfer_premi_asuransi));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$ii,date("d-M-Y",strtotime($datas[$i]['tanggal_spb'])));
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$ii,$datas[$i]['no_spb']);

			$totalF += $datas[$i]['jumlah_pembiayaan'];
			$totalH += $datas[$i]['premi_asuransi'];
			$totalI += $datas[$i]['ujroh'];
			$totalJ += $datas[$i]['premi_asuransi_tambahan'];
			$totalK += $transfer_premi_asuransi;
			
			$ii++;		
		}		

			$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii,number_format($totalF));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$ii,number_format($totalH));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$ii,number_format($totalI));
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$ii,number_format($totalJ));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$ii,number_format($totalK));
			
		$objPHPExcel->getActiveSheet()->getStyle('A11:M'.($ii-1))->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->getStyle('A11:A'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B11:B'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C11:C'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D11:D'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E11:E'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F11:F'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G11:G'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H11:H'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I11:I'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J11:J'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K11:K'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L11:L'.($ii-1))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M11:M'.($ii-1))->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getStyle('F11:F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('H11:H'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('I11:I'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('J11:J'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('K11:K'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		//END FOR
	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="export_list_peserta_asuransi.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_jatuh_tempo_melalui()
	{
		$tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

       if ($tanggal1=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
        
                $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_melalui($cabang,$tanggal1_,$tanggal2_);
		            if ($cabang !='00000') 
		            {
		                $datacabang = $this->model_laporan_to_pdf->get_cabang($cabang);
		            } 
		            else 
		            {
		                $datacabang = "Semua Cabang";
		            }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',"Cabang : ".$datacabang);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Jatu Tempo Pembiayaan Berdasarkan Pengajuan Melalui");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
			// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"No");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Total");

			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

      		$total_anggota = 0;
      		$total_pokok = 0;
      		$total_margin = 0;
      		$total_total = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['jumlah_anggota'];     
       			 $total_pokok+=$datas[$i]['pokok'];  
       			 $total_margin+=$datas[$i]['margin'];  
       			 $total_total+=$datas[$i]['total'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['pengajuan_melalui']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['jumlah_anggota']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':F'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+7;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':F'.$iii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);
			}

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="export_rekap_jatuh_tempo_petugas.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_pencairan_pembiayaan_produk()
	{
		$tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

       if ($tanggal1=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
        
            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_produk($cabang,$tanggal1_,$tanggal2_);
			$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
                case '0':
                  $branch_class_name = "Kepala Pusat";
                  break;
                case '1':
                  $branch_class_name = "Kepala Wilayah";
                  break;
                case '2':
                  $branch_class_name = "Kepala Cabang";
                  break;
                case '3':
                  $branch_class_name = "Kepala Capem";
                  break;
                default:
                  $branch_class_name = "-";
                  break;
            }


            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Produk");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
			// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

      		$total_anggota = 0;
      		$total_pokok = 0;
      		$total_margin = 0;
      		$total_total = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['num'];     
       			 $total_pokok+=$datas[$i]['pokok'];  
       			 $total_margin+=$datas[$i]['margin'];  
       			 $total_total+=$datas[$i]['total'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['product_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

			}

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

	public function export_rekap_pencairan_pembiayaan_akad()
	{
		$tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

       if ($tanggal1=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else if ($tanggal2=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }
        else
        {
        
            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_akad($cabang,$tanggal1_,$tanggal2_);
			$branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_class = $branch['branch_class'];

            switch ($branch_class) {
                case '0':
                  $branch_class_name = "Kepala Pusat";
                  break;
                case '1':
                  $branch_class_name = "Kepala Wilayah";
                  break;
                case '2':
                  $branch_class_name = "Kepala Cabang";
                  break;
                case '3':
                  $branch_class_name = "Kepala Capem";
                  break;
                default:
                  $branch_class_name = "-";
                  break;
            }


            if ($cabang !='00000'){
                $branch_name = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch_class=="1"){
                    $branch_name .= " (Perwakilan)";
                }
            }else{
                $branch_name = "PUSAT (Gabungan)";
            }
			
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

			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A1',strtoupper($this->session->userdata('institution_name')));
			$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
			$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A2',$branch_name);
			$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
			$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A3',"Rekap Pencairan Pembiayaan Berdasarkan Akad");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
			// $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->setCellValue('A5',"Periode : ".$tanggal1__.' s/d '.$tanggal2__);
			$objPHPExcel->getActiveSheet()->setCellValue('A6',"Kode");
			$objPHPExcel->getActiveSheet()->setCellValue('B6',"Keterangan");
			$objPHPExcel->getActiveSheet()->setCellValue('C6',"Jumlah");
			$objPHPExcel->getActiveSheet()->setCellValue('D6',"Pokok");
			$objPHPExcel->getActiveSheet()->setCellValue('E6',"Margin");
			$objPHPExcel->getActiveSheet()->setCellValue('F6',"Jumlah");

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getFont()->setSize(10);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			


					
			$ii = 7;

      		$total_anggota = 0;
      		$total_pokok = 0;
      		$total_margin = 0;
      		$total_total = 0;

			for( $i = 0 ; $i < count($datas) ; $i++ )
			{ 
        		 $total_anggota+=$datas[$i]['num'];     
       			 $total_pokok+=$datas[$i]['pokok'];  
       			 $total_margin+=$datas[$i]['margin'];  
       			 $total_total+=$datas[$i]['total'];  

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii,($i+1));
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii,$datas[$i]['akad_name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii,$datas[$i]['num']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii," ".number_format($datas[$i]['pokok'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii," ".number_format($datas[$i]['margin'],0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$ii," ".number_format($datas[$i]['total'],0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':A'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$ii.':B'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$ii.':C'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$ii.':D'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$ii.':E'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$ii.':F'.$ii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$ii.':F'.$ii)->getFont()->setSize(10);

				$ii++;
			
			}//END FOR

			$iii = count($datas)+8;
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$iii,$total_anggota);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$iii," ".number_format($total_pokok,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$iii," ".number_format($total_margin,0,',','.'));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$iii," ".number_format($total_total,0,',','.'));

				$objPHPExcel->getActiveSheet()->getStyle('C'.$iii.':C'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$iii.':D'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$iii.':E'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$iii.':F'.$iii)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$iii.':F'.$iii)->getFont()->setSize(10);

			}

	
		// Redirect output to a client's web browser (Excel2007)
		// Save Excel 2007 file

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REPORT_REKAP_PENCAIRAN_PEMBIAYAAN.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		// ----------------------------------------------------------------------
		// [END] EXPORT SCRIPT
		// ----------------------------------------------------------------------
	}

}
