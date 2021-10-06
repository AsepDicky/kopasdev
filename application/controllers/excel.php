<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EXCEL extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->library('phpexcel');
		$this->load->model('model_laporan');
		$this->load->model('model_laporan_to_pdf');
	}

	/*
	| Laporan Arus Kas
	| created_by : sayyid nurkilah
	| created_date : 2014-10-25 13:28
	|*/
	function laporan_arus_kas()
	{

		/*
		| DECLARE URI SEGMENT DATA
		*/
		$branch_code=$this->uri->segment(3);
		$account_cash_code=$this->uri->segment(4);
		$periode=$this->datepicker_convert(false,$this->uri->segment(5),'');

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
		
		/*
		| DATA ARUS KAS
		*/

		$exp_periode  = explode('-',$periode);
		$periode_awal = $exp_periode[0].'-'.$exp_periode[1].'-01';
		$periode_akhir= $periode;

		$data_arus_kas = $this->model_laporan->data_laporan_arus_kas($branch_code,$account_cash_code,$periode_awal,$periode_akhir);
		$saldo_awal=$data_arus_kas['saldo_awal'];

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:C4')->getFont()->setBold(true);


		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Laporan Arus KAS");
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Periode : ".date('d-m-Y',strtotime($periode_awal))." - ".date('d-m-Y',strtotime($periode_akhir)));
		$row+=2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Keterangan");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Jumlah");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Saldo Awal");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($saldo_awal,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row+=2;
		
		/*
		| ROW PENERIMAAN
		*/
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Penerimaan");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row+=1;
		$data_penerimaan=$data_arus_kas['penerimaan'];
		$total_penerimaan=0;
		for($i=0;$i<count($data_penerimaan);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$data_penerimaan[$i]['account_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($data_penerimaan[$i]['amount'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$total_penerimaan+=$data_penerimaan[$i]['amount'];
			$row++;
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Jumlah Penerimaan");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($total_penerimaan,0,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row+=2;

		/*
		| ROW Pengeluaran
		*/
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Pengeluaran");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row+=1;
		$data_pengeluaran=$data_arus_kas['pengeluaran'];
		$total_pengeluaran=0;
		for($i=0;$i<count($data_pengeluaran);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$data_pengeluaran[$i]['account_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($data_pengeluaran[$i]['amount'],0,',','.').' ');
			$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$total_pengeluaran+=$data_pengeluaran[$i]['amount'];
			$row++;
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Jumlah Pengeluaran");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($total_pengeluaran,0,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$row+=2;

		/*
		| ROW SALDO AKHIR
		*/
		$saldo_akhir=$saldo_awal+$total_penerimaan-$total_pengeluaran;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Saldo Akhir");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,number_format($saldo_akhir,0,',','.').' ');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_Arus_KAS.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	/*
	| REKAP NOMINATIF
	| sayyid nurkilah
	| 2014-11-11 10:54
	*/
	function rekap_nominatif()
	{

		/*
		| DECLARE URI SEGMENT DATA
		*/
		$branch_code=$this->uri->segment(3);
		$from_date=$this->datepicker_convert(false,$this->uri->segment(4),'');
		$thru_date=$this->datepicker_convert(false,$this->uri->segment(5),'');

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
		
		/*
		| BORDER OPTION
		*/
		$styleArray['borders']['outline']['style']=PHPExcel_Style_Border::BORDER_THIN;
		$styleArray['borders']['outline']['color']['rgb']='000000';

		/*
		| DATA NOMINATIF
		*/

        if ($branch_code !='00000'){
            $branch = $this->model_laporan->get_branch_by_branch_code($branch_code);
            $branch_name=$branch['branch_name'];
            if($branch['branch_class']=="1"){
                $branch_name .= " (Perwakilan)";
            }
        }else{
            $branch_name = "PUSAT (Gabungan)";
        }
		$datas = $this->model_laporan->data_rekap_nominatif($branch_code,$from_date,$thru_date);

		/*
		| SET COLUMN WIDTH
		*/
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);

		/*
		| ROW HEADER TITLE
		*/
		$row=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$this->session->userdata('institution_name'));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$branch_name);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$row+=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Laporan Rekap Nominatif");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$row+=2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Periode");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,date('d-m-Y',strtotime($from_date)));
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"S/D");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,date('d-m-Y',strtotime($thru_date)));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=2;
		
		/*
		| ROW PENERIMAAN
		*/
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Petugas");
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Resort");
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Pencairan");
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,"Pelunasan");
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,"Outstanding");
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$row,"Angsuran");
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$row,"Kolektibilitas");
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':A'.($row+2));
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':B'.($row+2));
		$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':F'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('G'.$row.':J'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('K'.$row.':N'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('O'.$row.':R'.($row+1));
		$objPHPExcel->getActiveSheet()->mergeCells('S'.$row.':X'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':B'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$row.':F'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$row.':J'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$row.':N'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$row.':R'.($row+2))->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row.':X'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;

		$objPHPExcel->getActiveSheet()->setCellValue('S'.$row,"KL");
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$row,"Diragukan");
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$row,"Macet");
		$objPHPExcel->getActiveSheet()->mergeCells('S'.$row.':T'.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('U'.$row.':V'.$row);
		$objPHPExcel->getActiveSheet()->mergeCells('W'.$row.':X'.$row);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row.':T'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$row.':V'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$row.':X'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':W'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;

		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$row,"Total");
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$row,"Total");
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$row,"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$row,"Total");
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,"Margin");
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$row,"Total");
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
		$objPHPExcel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->setCellValue('S'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$row,"Count");
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$row,"Pokok");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$row+=1;

		/*
		| ROW DATA
		*/
		$gtotal_droping_count=0;
		$gtotal_droping_pokok=0;
		$gtotal_droping_margin=0;
		$gtotal_droping=0;
		$gtotal_lunas_count=0;
		$gtotal_lunas_pokok=0;
		$gtotal_lunas_margin=0;
		$gtotal_lunas=0;
		$gtotal_outstanding_count=0;
		$gtotal_outstanding_pokok=0;
		$gtotal_outstanding_margin=0;
		$gtotal_outstanding=0;
		$gtotal_angsuran_count=0;
		$gtotal_angsuran_pokok=0;
		$gtotal_angsuran_margin=0;
		$gtotal_angsuran=0;
		$gtotal_kol2_count=0;
		$gtotal_kol2_pokok=0;
		$gtotal_kol3_count=0;
		$gtotal_kol3_pokok=0;
		$gtotal_kol4_count=0;
		$gtotal_kol4_pokok=0;
		$petugas='';
		for($i=0;$i<count($datas);$i++){

			$total_droping=$datas[$i]['droping_pokok']+$datas[$i]['droping_margin'];
			$total_lunas=$datas[$i]['lunas_pokok']+$datas[$i]['lunas_margin'];
			$total_outstanding=$datas[$i]['outstanding_pokok']+$datas[$i]['outstanding_margin'];
			$total_angsuran=$datas[$i]['angsuran_pokok']+$datas[$i]['angsuran_margin'];

			if($petugas!=$datas[$i]['fa_name']){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$datas[$i]['fa_name']);
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
				$objPHPExcel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getFont()->setSize(10);
				$row++;
			}else{
			}
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$datas[$i]['resort_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' '.number_format($datas[$i]['droping_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,' '.number_format($datas[$i]['droping_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,' '.number_format($datas[$i]['droping_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row,' '.number_format($total_droping,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,' '.number_format($datas[$i]['lunas_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row,' '.number_format($datas[$i]['lunas_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,' '.number_format($datas[$i]['lunas_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$row,' '.number_format($total_lunas,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,' '.number_format($datas[$i]['outstanding_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$row,' '.number_format($datas[$i]['outstanding_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$row,' '.number_format($datas[$i]['outstanding_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$row,' '.number_format($total_outstanding,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$row,' '.number_format($datas[$i]['angsuran_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$row,' '.number_format($datas[$i]['angsuran_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,' '.number_format($datas[$i]['angsuran_margin'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$row,' '.number_format($total_angsuran,0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$row,' '.number_format($datas[$i]['kol2_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$row,' '.number_format($datas[$i]['kol2_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$row,' '.number_format($datas[$i]['kol3_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$row,' '.number_format($datas[$i]['kol3_pokok'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$row,' '.number_format($datas[$i]['kol4_count'],0,',','.'));
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$row,' '.number_format($datas[$i]['kol4_pokok'],0,',','.'));

			/*border style*/
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
			$objPHPExcel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getFont()->setSize(10);


			/*hitung grand total*/

			$gtotal_droping_count+=$datas[$i]['droping_count'];
			$gtotal_droping_pokok+=$datas[$i]['droping_pokok'];
			$gtotal_droping_margin+=$datas[$i]['droping_margin'];
			$gtotal_droping+=$total_droping;
			$gtotal_lunas_count+=$datas[$i]['lunas_count'];
			$gtotal_lunas_pokok+=$datas[$i]['lunas_pokok'];
			$gtotal_lunas_margin+=$datas[$i]['lunas_margin'];
			$gtotal_lunas+=$total_lunas;
			$gtotal_outstanding_count+=$datas[$i]['outstanding_count'];
			$gtotal_outstanding_pokok+=$datas[$i]['outstanding_pokok'];
			$gtotal_outstanding_margin+=$datas[$i]['outstanding_margin'];
			$gtotal_outstanding+=$total_outstanding;
			$gtotal_angsuran_count+=$datas[$i]['angsuran_count'];
			$gtotal_angsuran_pokok+=$datas[$i]['angsuran_pokok'];
			$gtotal_angsuran_margin+=$datas[$i]['angsuran_margin'];
			$gtotal_angsuran+=$total_angsuran;
			$gtotal_kol2_count+=$datas[$i]['kol2_count'];
			$gtotal_kol2_pokok+=$datas[$i]['kol2_pokok'];
			$gtotal_kol3_count+=$datas[$i]['kol3_count'];
			$gtotal_kol3_pokok+=$datas[$i]['kol3_pokok'];
			$gtotal_kol4_count+=$datas[$i]['kol4_count'];
			$gtotal_kol4_pokok+=$datas[$i]['kol4_pokok'];
			$petugas=$datas[$i]['fa_name'];
			$row++;
		}
		// $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.($row+1))->applyFromArray($styleArray);
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
		$objPHPExcel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($styleArray);
		$row++;
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
		$objPHPExcel->getActiveSheet()->getStyle('R'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('X'.$row)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'TOTAL');
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' '.number_format($gtotal_droping_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,' '.number_format($gtotal_droping_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row,' '.number_format($gtotal_droping_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$row,' '.number_format($gtotal_droping,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,' '.number_format($gtotal_lunas_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$row,' '.number_format($gtotal_lunas_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,' '.number_format($gtotal_lunas_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$row,' '.number_format($gtotal_lunas,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,' '.number_format($gtotal_outstanding_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$row,' '.number_format($gtotal_outstanding_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$row,' '.number_format($gtotal_outstanding_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$row,' '.number_format($gtotal_outstanding,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$row,' '.number_format($gtotal_angsuran_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$row,' '.number_format($gtotal_angsuran_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,' '.number_format($gtotal_angsuran_margin,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$row,' '.number_format($gtotal_angsuran,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$row,' '.number_format($gtotal_kol2_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$row,' '.number_format($gtotal_kol2_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$row,' '.number_format($gtotal_kol3_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$row,' '.number_format($gtotal_kol3_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$row,' '.number_format($gtotal_kol4_count,0,',','.'));
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$row,' '.number_format($gtotal_kol4_pokok,0,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':X'.$row)->getFont()->setSize(10);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Rekap Nominatif.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
}