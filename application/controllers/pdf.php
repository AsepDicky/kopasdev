<?php
class PDF extends GMN_Controller {

	public function __construct(){
		parent::__construct(true);
		$this->load->library('html2pdf');
        $this->load->model('model_laporan');
        $this->load->model('model_laporan_to_pdf');
		$this->load->model('model_cif');

	}

    public function export_lap_list_outstanding_pembiayaan_kelompok()
    {       
        // $html='a';
        $cabang = $this->uri->segment(3);               
        $rembug = $this->uri->segment(4);
        $tanggal = $this->current_date();
        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_kelompok($cabang,$rembug);
        
        ob_start();
		
		// echo "<pre>";
		print_r($datas);
		// echo "</pre>";        
        // $data['result'] = $datas;
        // $data['tanggal'] = $tanggal;
        // $data['title'] = "Laporan Outstanding Pembiayaan Kelompok";

        // if ($cabang !='0000') {
        //     $data['nama_cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        // } else {
        //     $data['nama_cabang'] = "SEMUA CABANG";
        // }

        // $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_kelompok',$data);
        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_outstanding_pembiayaan_"'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
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

        /* branch data */
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = strtoupper($branch['branch_name']);

        /* account data*/
        $account = $this->model_cif->get_gl_account_by_account_code($account_cash_code);
        $account_name = $account['account_name'];

        /* set periode */
        $exp_periode  = explode('-',$periode);
        $periode_awal = $exp_periode[0].'-'.$exp_periode[1].'-01';
        $periode_akhir= $periode;

        $data_arus_kas = $this->model_laporan->data_laporan_arus_kas($branch_code,$account_cash_code,$periode_awal,$periode_akhir);
        $saldo_awal=$data_arus_kas['saldo_awal'];
        $data_penerimaan=$data_arus_kas['penerimaan'];
        $data_pengeluaran=$data_arus_kas['pengeluaran'];

        // HEAD
        $html = '
            <h3 align="center" style="line-height:30px;">'.$this->session->userdata('institution_name').'<br>'.$branch_name.'<br>LAPORAN ARUS KAS</h3>
            <table>
                <tr>
                    <td>GL Account</td>
                    <td>:</td>
                    <td>'.$account_name.'</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>'.date('d-m-Y',strtotime($periode_awal)).' s.d '.date('d-m-Y',strtotime($periode_akhir)).'</td>
                </tr>
            </table>
            <hr size="1">
        ';
        
        ob_start();

        echo $html;


        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan_Arus_KAS.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

}
