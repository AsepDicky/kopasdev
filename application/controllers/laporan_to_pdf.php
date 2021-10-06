<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_to_pdf extends GMN_Controller {

    public function __construct()
    {
        parent::__construct(true,'main','back');
        $this->load->library('html2pdf');
        // $this->load->library('tcpdf6');
        $this->load->model('model_laporan_to_pdf');
        $this->load->model('model_cif');
        $this->load->model('model_laporan');
        $this->load->model('model_nasabah');
        $CI =& get_instance();
    }

    /****************************************************************************/
    //BEGIN LAPORAN SALDO KAS PETUGAS
    /****************************************************************************/
    public function export_saldo_kas_petugas()
    {
        $cabang     = $this->uri->segment(4);
        $tanggal    = $this->uri->segment(3);
        $tanggal2 = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);

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

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['saldo_kas_petugas'] = $this->model_laporan_to_pdf->export_saldo_kas_petugas($cabang,$tanggal2);
            $data['tanggal']= $tanggal2;

            
            if ($cabang !='00000') 
            {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } 
            else 
            {
                $data['cabang'] = "Semua Data";
            }

            $this->load->view('laporan/export_pdf_saldo_kas_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_saldo_kas_petugas_"'.$tanggal2.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN SALDO KAS PETUGAS
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN TRANSAKSI KAS PETUGAS
    /****************************************************************************/
    public function export_transaksi_kas_petugas()
    {

        $account_cash_name  = $this->uri->segment(3);
        $pemegeng_kas       = $this->uri->segment(4);
        $tanggal            = $this->uri->segment(5);
        $tanggal = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
        $tanggal2           = $this->uri->segment(6); 
        $tanggal2 = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
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

            ob_start();

            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['transaksi_kas_petugas']  = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal,$tanggal2,$account_cash_code);
            $data['account_cash_name']  = $account_cash_name;
            $data['pemegeng_kas']       = $pemegeng_kas;
            $data['tanggal']            = $tanggal;
            $data['tanggal2']           = $tanggal2;

            $this->load->view('laporan/export_pdf_transaksi_kas_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_pdf_transaksi_kas_petugas_"'.$tanggal2.'-'.$tanggal2.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN TRANSAKSI KAS PETUGAS
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN LAPORAN LABA RUGI
    /****************************************************************************/
    public function export_lap_lr()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        $from_date = $periode_tahun.'-'.$periode_bulan.'-01';
        $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun==""){            
         echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            // $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$from_date,$last_date);
            // $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$periode_bulan,$periode_tahun,$periode_hari);
            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/export_pdf_laporan_lr',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Laba Rugi"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LABA RUGI
    /****************************************************************************/
	


    /****************************************************************************/
    //BEGIN EXPORT NERACA_GL
    /****************************************************************************/
    public function export_neraca_gl()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        if ($branch_code=="") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_gl($branch_code,$periode_bulan,$periode_tahun,$periode_hari);
            if ($branch_code !='00000'){
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                if($branch['branch_class']=="1"){
                    $data['branch_name'] .= " (Perwakilan)";
                }
            }else{
                $data['branch_name'] = "PUSAT (Gabungan)";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/export_pdf_neraca_gl',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_pdf_neraca_gl"'.$branch_code.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END EXPORT NERACA_GL
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LABA RUGI PUBLISH
    /****************************************************************************/
    public function export_lap_lr_publish()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);

        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun==""){            
         echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        }else{
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            }else{
                $data['cabang'] = "Semua Data";
            }
            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.date('t',strtotime($from_periode));
            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang,$periode_bulan,$periode_tahun);
            $data['last_date'] = $last_date;
            $this->load->view('laporan/export_pdf_laporan_lr_publish',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Laba Rugi"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LABA RUGI PUBLISH
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    public function export_lap_droping_pembiayaan_kelompok()
    {
        $from_date = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);          
        $cabang = $this->uri->segment(5);               
        $rembug = $this->uri->segment(6);               
        $cif_type = $this->uri->segment(7);               
        $petugas = $this->uri->segment(8);               
        $produk = $this->uri->segment(9);               
        if ($rembug==false){
            $rembug = "";
        }else{
            $rembug =   $rembug;            
        }

        if ($cabang==""){            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else if ($from_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else if ($thru_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else{   
            $datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan_kelompok($cabang,$rembug,$from_date,$thru_date,$cif_type,$petugas,$produk);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='00000'){
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            }else{
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;
            $this->load->view('laporan/export_lap_droping_pembiayaan_kelompok',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_droping_pembiayaan_kelompok"'.$from_date.'_"'.$thru_date.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
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
        $datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan_individu($from_date,$thru_date,$cif_type,$cabang,$petugas,$produk,$resort,$akad,$pengajuan_melalui);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['tanggal1_'] = $from_date;
        $data['tanggal2_'] = $thru_date;
        $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $this->load->view('laporan/export_lap_droping_pembiayaan_individu',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_lap_droping_pembiayaan_individu"'.$from_date.'_"'.$thru_date.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN AGING
    /****************************************************************************/
    public function export_lap_aging()
    {
        $branch_id = $this->uri->segment(3);
        $date = $this->uri->segment(4);
        $desc_date = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
        $date = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2);
        $branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_code = $branch_data['branch_code'];
        if ($branch_id=="") 
        {            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } 
        else
        {

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            //$data['lap_lr'] = $this->model_laporan_to_pdf->export_lap_lr($cabang);
            //$data['tanggal']= $tanggal;
            
            $data['result']= $datas;
            if ($branch_id !='00000') 
            {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } 
            else 
            {
                $data['cabang'] = "Semua Data";
            }
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();
            $data['par'] = $this->model_laporan_to_pdf->get_laporan_par($date);
            $data['branch_name'] = $branch_data['branch_name'];
            $data['date'] = $desc_date;

            $this->load->view('anggota/export_lap_aging',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Aging.pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN AGING
    /****************************************************************************/
	

    /****************************************************************************/
    //BEGIN LAPORAN LIST JATUH TEMPO
    /****************************************************************************/
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
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        // $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $this->load->view('laporan/export_list_jatuh_tempo',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST JATUH TEMPO
    /****************************************************************************/
    

    /****************************************************************************/
    //BEGIN LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/
    public function list_pelunasan_pembiayaan_kelompok()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);
        $rembug     = $this->uri->segment(6);               
            if ($rembug==false) 
            {
                $rembug = "";
            } 
            else 
            {
                $rembug =   $rembug;            
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
                
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_list_pelunasan_pembiayaan_kelompok',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_pelunasan_pembiayaan_kelompok"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
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
        $cabang = $this->uri->segment(5);
        $petugas = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan_individu($tanggal1_,$tanggal2_,$cabang,$petugas,$produk);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $this->load->view('laporan/export_list_pelunasan_pembiayaan_individu',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pelunasan_pembiayaan_individu"'.$tanggal1__.'_"'.$tanggal1__.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN OUTSTANDING
    /****************************************************************************/
    public function export_lap_list_outstanding_pembiayaan_individu()
    {       
        set_time_limit(0);
        $akad = $this->uri->segment(3);
        $produk_pembiayaan = $this->uri->segment(4);
        $pengajuan_melalui = $this->uri->segment(5);
        $peruntukan = $this->uri->segment(6);
        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_individu($akad,$produk_pembiayaan,$pengajuan_melalui,$peruntukan);
        $produk_name = $this->model_laporan->get_produk_name($produk_pembiayaan);
        // $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        // $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        // $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        // if ($cabang !='00000'){
        //     $data['data_cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        //     if($branch['branch_class']=="1"){
        //         $data['data_cabang'] .= " (Perwakilan)";
        //     }
        // }else{
        //     $data['data_cabang'] = "PUSAT (Gabungan)";
        // }
        $data['produk_name'] = $produk_name;
        // $data['petugas_name'] = $petugas_name;
        // $data['tanggal'] = $tanggal;
        // $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_individu',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_outstanding_pembiayaan.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_lap_list_outstanding_pembiayaan_kelompok()
    {
        $cabang = $this->uri->segment(3);               
        $rembug = $this->uri->segment(4);
        $tanggal = $this->current_date();
        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_kelompok($cabang,$rembug);
        $data['result'] = $datas;
        $data['tanggal'] = $tanggal;
        $data['title'] = "Laporan Outstanding Pembiayaan Kelompok";

        if ($cabang !='00000') {
            $data['nama_cabang'] = 'CABANG '.@strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['nama_cabang'] = "SEMUA CABANG";
        }
        ob_start();

        $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_kelompok',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_outstanding_pembiayaan_"'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    // public function export_lap_list_outstanding_pembiayaan_kelompok()
    // {       
    //     // create new PDF document
    //     $pdf = new TCPDF6('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //     // $this->SetFont('', 'B', 9 + 1);
    //     // $this->SetX();
    //     $pdf->Cell(0, 6, $this->session->userdata('institution_name'), 0, 1, 'C', 0, 'T', 0);    
    //     // remove default header/footer
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);

    //     // set default monospaced font
    //     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //     // set margins
    //     // $pdf->SetMargins(5, 5, 5);

    //     // set auto page breaks
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //     // set image scale factor
    //     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //     // set some language-dependent strings (optional)
    //     if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    //         require_once(dirname(__FILE__).'/lang/eng.php');
    //         $pdf->setLanguageArray($l);
    //     }
    //     // ---------------------------------------------------------

    //     // add a page
    //     $pdf->AddPage();

    //     $cabang = $this->uri->segment(3);               
    //     $rembug = $this->uri->segment(4);
    //     $tanggal = $this->current_date();
    //     $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_kelompok($cabang,$rembug);
    //     $data['result'] = $datas;
    //     $data['tanggal'] = $tanggal;
    //     $data['title'] = "Laporan Outstanding Pembiayaan Kelompok";

    //     if ($cabang !='00000') {
    //         $data['nama_cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
    //     } else {
    //         $data['nama_cabang'] = "SEMUA CABANG";
    //     }

    //     $html = $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_kelompok',$data,true);
        

    //     // Print text using writeHTMLCell()
    //     $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    //     // ---------------------------------------------------------

    //     // Close and output PDF document
    //     // This method has several options, check the source code documentation for more information.
    //     $pdf->Output('example_001.pdf', 'I');

    //     //============================================================+
    //     // END OF FILE
    //     //============================================================+



        
    //     // ob_start();
    //     // $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_kelompok',$data);
    //     // $content = ob_get_clean();

    //     // try
    //     // {
    //     //     $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 5);
    //     //     $html2pdf->pdf->SetDisplayMode('fullpage');
    //     //     $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //     //     $html2pdf->Output('export_list_outstanding_pembiayaan_"'.$cabang.'".pdf');
    //     // }
    //     // catch(HTML2PDF_exception $e) {
    //     //     echo $e;
    //     //     exit;
    //     // }
    // }

    public function teeest()
    {       
        // create new PDF document
        $pdf = new TCPDF6('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // $this->SetFont('', 'B', 9 + 1);
        // $this->SetX();
        $pdf->Cell(0, 6, $this->session->userdata('institution_name'), 0, 1, 'C', 0, 'T', 0);    
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        // $pdf->SetMargins(5, 5, 5);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // ---------------------------------------------------------

        // add a page
        $pdf->AddPage();

        $html = '
        <div align="center" style="line-height:22px;font-weight:bold;font-size:12">
        TUNAS ARTHA MANDIRI<br>
        CABANG NGANJUK<br>
        LAPORAN OUTSTANDING PEMBIAYAAN
        </div>
        <div style="border-bottom:1 solid #CCC;line-height:18px;font-size:11px;">Tanggal : 29/08/2014<br/>Produk : Amar Pembiayaan</div>
        <br/>
        
        <table style="font-size:8;width:100%;border:solid 1px #CCC;" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC;" rowspan="2">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                </tr>
                <tr>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                    <th style="text-align:center;font-weight:bold;border:solid 1px #CCC;background:#CCC">Header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC" colspan="2">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                    <td style="text-align:right;border:solid 1px #CCC;background:#CCC">body</td>
                </tr>
            </tbody>
        </table>
        
        ';

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+

    }
    /****************************************************************************/
    //END LAPORAN OUTSTANDING
    /****************************************************************************/
    

    /****************************************************************************/
    //BEGIN LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/
    public function list_registrasi_pembiayaan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(5);

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
        
            $datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($cabang,$tanggal1_,$tanggal2_,$cabang);
                
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_list_registrasi_pembiayaan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_registrasi_pembiayaan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/
    

    /****************************************************************************/
    //BEGIN LAPORAN REKAP JATUH TEMPO
    /****************************************************************************/

    //Rekap jatuh tempo by cabang
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Rembug
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } 
            else 
            {
                $data['cabang'] = "Semua Data";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_rembug',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_rembug"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Petugas
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Peruntukan
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_peruntukan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_peruntukan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Peruntukan
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_resort',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_resort"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP JATUH TEMPO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP OUTSTANDING PIUTANG
    /****************************************************************************/

    //Semua Cabang
    public function export_rekap_outstanding_pembiayaan_semua_cabang()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG.pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }

    //Berdasarkan Cabang Yang dipilih
    public function export_rekap_outstanding_pembiayaan_cabang()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_cabang($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG.pdf');
                // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }

    //Berdasarkan Rembug
    public function export_rekap_outstanding_pembiayaan_rembug()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_rembug($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_rembug',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY REMBUG.pdf');
                // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }

    //Berdasarkan Petugas
    public function export_rekap_outstanding_pembiayaan_petugas()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_petugas($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PETUGAS.pdf');
                // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }

    //Berdasarkan Produk
    public function export_rekap_outstanding_pembiayaan_produk()
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
    
        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_produk($cabang);

        ob_start();

        
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        
        $data['result']= $datas;
        
        $data['result']= $datas;
        if ($cabang !='00000') 
        {
            $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } 
        else 
        {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_produk',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PERUNTUKAN.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Peruntukan
    public function export_rekap_outstanding_pembiayaan_peruntukan()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_peruntukan($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_peruntukan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PERUNTUKAN.pdf');
                // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }

    //Berdasarkan Resort
    public function export_rekap_outstanding_pembiayaan_resort()
    {
       /* 
       $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        */

        $cabang         = $this->uri->segment(3);       
            if ($cabang==false) 
            {
                $cabang = "00000";
            } 
            else 
            {
                $cabang =   $cabang;            
            }

        /* 
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
        */
        
            // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_resort($cabang);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            /*
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            */
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_resort',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY RESORT.pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        // }
    }
    /****************************************************************************/
    //END LAPORAN REKAP OUTSTANDING PIUTANG
    /****************************************************************************/
    
    /****************************************************************************/
    //BEGIN LAPORAN REKAP PENCAIRAN PEMBIAYAAN
    /****************************************************************************/
    //Rekap jatuh tempo by cabang
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
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            // $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_cabang"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by cabang
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_cabang"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Rembug
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_rembug',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_rembug"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Petugas
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
            } else if($cabang=='0000') 
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Peruntukan
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_peruntukan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_peruntukan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Resort
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
            } else if($cabang=='0000') 
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_resort',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_resort_"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP PENCAIRAN PEMBIAYAAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP PENGAJUAN PEMBIAYAAN
    /****************************************************************************/
    //Rekap pengajuan by cabang
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_cabang"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap pengajuan by cabang
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_cabang"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap pengajuan by Rembug
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_rembug',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_rembug"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap pengajuan by Petugas
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
            }else if($cabang=='0000') 
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap pengajuan by Peruntukan
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_peruntukan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_peruntukan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap pengajuan by Resort
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_resort',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_resort_"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP PENGAJUAN PEMBIAYAAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST REGISTRASI PEMBIAYAAN
    /****************************************************************************/
    public function export_list_registrasi_pembiayaan()
    {
        $produk         = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_      = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_      = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang         = $this->uri->segment(6);       
        $akad         = $this->uri->segment(7);       
        $pengajuan_melalui = $this->uri->segment(8);       
        
        $datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($produk,$tanggal1_,$tanggal2_,$cabang,$akad,$pengajuan_melalui);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['produk'] = $produk;
        if ($cabang !='00000') {
            $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_list_registrasi_pembiayaan',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_registrasi_pembiayaan"'.$tanggal1__.'_"'.$tanggal1__.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST REGISTRASI PEMBIAYAAN
    /****************************************************************************/
    

    /****************************************************************************/
    //BEGIN LAPORAN LIST PENGAJUAN PEMBIAYAAN
    /****************************************************************************/
    public function export_list_pengajuan_pembiayaan_kelompok()
    {
        $tanggal1 = $this->uri->segment(3);
        $tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2 = $this->uri->segment(4);
        $tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cabang = $this->uri->segment(5);       
        $rembug = $this->uri->segment(6);               
        $cif_type = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);

        if ($rembug==false){
            $rembug = "";
        }else{
            $rembug =   $rembug;            
        }
            $datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan_kelompok($cabang,$tanggal1_,$tanggal2_,$rembug,$cif_type,$petugas,$produk);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='00000'){
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            }else{
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();
            $this->load->view('laporan/export_list_pengajuan_pembiayaan_kelompok',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_pengajuan_pembiayaan_kelompok"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
    }

    public function export_list_pengajuan_pembiayaan_individu()
    {
        $tanggal1 = $this->uri->segment(3);
        $tanggal1__ = substr($tanggal1,0,2).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,4,4);
        $tanggal1_ = substr($tanggal1,4,4).'-'.substr($tanggal1,2,2).'-'.substr($tanggal1,0,2);
        $tanggal2 = $this->uri->segment(4);
        $tanggal2__ = substr($tanggal2,0,2).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,4,4);
        $tanggal2_ = substr($tanggal2,4,4).'-'.substr($tanggal2,2,2).'-'.substr($tanggal2,0,2);
        $cif_type = $this->uri->segment(5);
        $cabang = $this->uri->segment(6);    
        $petugas = $this->uri->segment(7);
        $produk = $this->uri->segment(8);   
        $resort = $this->uri->segment(9);   
        $status = $this->uri->segment(10);   
        $akad = $this->uri->segment(11);   
        $pengajuan_melalui = $this->uri->segment(12);   
        $datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan_individu($tanggal1_,$tanggal2_,$cif_type,$cabang,$petugas,$produk,$resort,$status,$akad,$pengajuan_melalui);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;            
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $this->load->view('laporan/export_list_pengajuan_pembiayaan_individu',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pengajuan_pembiayaan_individu"'.$tanggal1__.'_"'.$tanggal1__.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PENGAJUAN PEMBIAYAAN
    /****************************************************************************/
    

    /****************************************************************************/
    //BEGIN LAPORAN LIST TRANSAKSI REMBUG
    /****************************************************************************/
    public function export_lap_trx_rembug()
    {
        $branch_code = $this->uri->segment(3);
        $from_trx_date = $this->datepicker_convert(false,$this->uri->segment(4));
        $thru_trx_date = $this->datepicker_convert(false,$this->uri->segment(5));
        $cm_code = $this->uri->segment(6);
        $fa_code = $this->uri->segment(7);
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

        $datas = $this->model_laporan->export_list_transaksi_rembug($branch_id,$cm_code,$from_trx_date,$thru_trx_date,$fa_code);
        
        
        if(count($datas)==0){
            echo '<script>alert("Data Tidak ditemukan");</script>';
            echo '<script>window.close();</script>';
            die();
        }

        ob_start();

        $grandtotal_angsuran_pokok = 0;
        $grandtotal_angsuran_margin = 0;
        $grandtotal_angsuran_catab = 0;
        $grandtotal_setoran_lwk = 0;
        $grandtotal_tab_sukarela_cr = 0;
        $grandtotal_minggon = 0;
        $grandtotal_tab_wajib_cr = 0;
        $grandtotal_tab_kelompok_cr = 0;
        $grandtotal_tab_rencana = 0;
        $grandtotal_tab_sukarela_db = 0;
        $grandtotal_pokok = 0;
        $grandtotal_administrasi = 0;
        $grandtotal_asuransi = 0;
        $grandtotal_infaq = 0;
        $grandtotal_setoran = 0;
        $grandtotal_penarikan = 0;

        $html = '
        
        <div style="font-size:11px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td colspan="17">
        
        <h4 style="margin-bottom:0;text-align:center">LAPORAN TRANSAKSI REMBUG</h4>
        <h4 style="margin-top:10px;text-align:center">'.$branch['branch_name'].'</h4>
        
        <p>&nbsp;</p>
        </td>
        </tr>
                 ';

        for($i = 0 ; $i < count($datas) ;$i++)
        {
            $datass = $this->model_laporan->export_list_transaksi_rembug_sub($datas[$i]['trx_cm_id'],$from_trx_date,$thru_trx_date,$datas[$i]['trx_date']);

            // $total_angsuran_pokok2 = 0;
            // $total_angsuran_margin2 = 0;
            // $total_angsuran_catab2 = 0;
            // $total_setoran_lwk2 = 0;
            // $total_tab_sukarela_cr2 = 0;
            // $total_minggon2 = 0;
            // $total_tab_wajib_cr2 = 0;
            // $total_tab_kelompok_cr2 = 0;
            // $total_tab_sukarela_db2 = 0;
            // $total_pokok2 = 0;
            // $total_administrasi2 = 0;
            // $total_asuransi2 = 0;
            // for ( $j = 0 ; $j < count($datass) ; $j++ )
            // {
            
            //     $total_angsuran_pokok2   += ($datass[$j]['freq']*$datass[$j]['angsuran_pokok']);
            //     $total_angsuran_margin2  += ($datass[$j]['freq']*$datass[$j]['angsuran_margin']);
            //     $total_angsuran_catab2   += ($datass[$j]['freq']*$datass[$j]['angsuran_catab']);
            //     $total_setoran_lwk2      += $datass[$j]['setoran_lwk'];
            //     $total_tab_sukarela_cr2  += $datass[$j]['tab_sukarela_cr'];
            //     $total_minggon2          += $datass[$j]['minggon'];
            //     $total_tab_wajib_cr2     += ($datass[$j]['freq']*$datass[$j]['tab_wajib_cr']);
            //     $total_tab_kelompok_cr2  += ($datass[$j]['freq']*$datass[$j]['tab_kelompok_cr']);
            //     $total_tab_sukarela_db2  += $datass[$j]['tab_sukarela_db'];
            //     $total_pokok2            += $datass[$j]['pokok'];
            //     $total_administrasi2     += $datass[$j]['administrasi'];
            //     $total_asuransi2         += $datass[$j]['asuransi'];

            // }

            if($i==0)
            {
                $html .= '<tr>';
                $html .= '<td style="padding:3px;">Rembug</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['cm_name'].'</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal Bayar</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['trx_date'].'</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Status Verifikasi</td>';
                $html .= '<td style="padding:3px 0;">: '.$datas[$i]['status_verifikasi'].'</td>';
                $html .= '<td style="padding:3px 3px 3px 0;" rowspan="2" colspan="7">';
                $html .= '
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Total Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Total Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($datas[$i]['infaq'],0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($datas[$i]['setoran'],0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">'.number_format($datas[$i]['penarikan'],0,',','.').'</td>
                            </tr>
                        </table>';
                $html .= '</td>';

                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="padding:3px;">Petugas</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['fa_name'].'</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal</td>';
                $html .= '<td style="padding:3px 0;" colspan="12">: '.$datas[$i]['created_date'].'</td>';
                $html .= '</tr>';

                $html .= '
                     <tr>
                        <td width="150" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;" colspan="2">ID</td>
                        <td width="150" valign="middle" align="center" style="border-top:solid 1px #999;border-bottom:solid 1px transparent;" rowspan="2">NAMA</td>
                        <td width="230" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;" colspan="5">ANGSURAN</td>
                        <td width="230" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;" colspan="4">Setoran</td>
                        <td width="60" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;">Penarikan</td>
                        <td width="180" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;" colspan="3">REALISASI PEMBIAYAAN</td>
                     </tr>
                     <tr>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">ANGGOTA</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;">PYD</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Freq</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Pokok</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Margin</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Catab</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:53px;text-align:center;">LWK</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:52px;text-align:center;">Sukarela</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:52px;text-align:center;">Wajib</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:53px;text-align:center;">Kelompok</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;text-align:center;">TABREN</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Sukarela</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:55px;">Plafon</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:55px;">Adm.</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;width:55px;">Asuransi</td>
                     </tr>
                ';
            }else{

            $html .= '<tr>';
            $html .= '<td style="padding:3px; border-left:solid 1px #999;">Rembug</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['cm_name'].'</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">Tanggal Bayar</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['trx_date'].'</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">Status Verifikasi</td>';
            $html .= '<td style="padding:3px 0;">: '.$datas[$i]['status_verifikasi'].'</td>';
            $html .= '<td style="padding:3px 3px 3px 0; border-right:solid 1px #999;" colspan="7" rowspan="2">';

            $html .= '
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Total Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Total Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($datas[$i]['infaq'],0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($datas[$i]['setoran'],0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">'.number_format($datas[$i]['penarikan'],0,',','.').'</td>
                            </tr>
                        </table>';

            $html .= '</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td style="padding:3px; border-left:solid 1px #999;">Petugas</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">: '.$datas[$i]['fa_name'].'</td>';
            $html .= '<td style="padding:3px 0;" colspan="2">Tanggal</td>';
            $html .= '<td style="padding:3px 0; border-right:solid 1px #999;" colspan="12">: '.$datas[$i]['created_date'].'</td>';
            $html .= '</tr>';
            
            }

            
            $total_angsuran_pokok = 0;
            $total_angsuran_margin = 0;
            $total_angsuran_catab = 0;
            $total_setoran_lwk = 0;
            $total_tab_sukarela_cr = 0;
            $total_minggon = 0;
            $total_tab_wajib_cr = 0;
            $total_tab_kelompok_cr = 0;
            $total_tab_rencana = 0;
            $total_tab_sukarela_db = 0;
            $total_pokok = 0;
            $total_administrasi = 0;
            $total_asuransi = 0;
            
            $grandtotal_infaq += $datas[$i]['infaq'];
            $grandtotal_setoran += $datas[$i]['setoran'];
            $grandtotal_penarikan += $datas[$i]['penarikan'];

            for ( $j = 0 ; $j < count($datass) ; $j++ )
            {
            
            $total_angsuran_pokok   += ($datass[$j]['freq']*$datass[$j]['angsuran_pokok']);
            $total_angsuran_margin  += ($datass[$j]['freq']*$datass[$j]['angsuran_margin']);
            $total_angsuran_catab   += ($datass[$j]['freq']*$datass[$j]['angsuran_catab']);
            $total_setoran_lwk      += $datass[$j]['setoran_lwk'];
            $total_tab_sukarela_cr  += $datass[$j]['tab_sukarela_cr'];
            $total_minggon          += $datass[$j]['minggon'];
            $total_tab_wajib_cr     += ($datass[$j]['freq']*$datass[$j]['tab_wajib_cr']);
            $total_tab_kelompok_cr  += ($datass[$j]['freq']*$datass[$j]['tab_kelompok_cr']);
            $total_tab_rencana      += $datass[$j]['tabren'];
            $total_tab_sukarela_db  += $datass[$j]['tab_sukarela_db'];
            $total_pokok            += $datass[$j]['pokok'];
            $total_administrasi     += $datass[$j]['administrasi'];
            $total_asuransi         += $datass[$j]['asuransi'];
            $html .= '<tr>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.$datass[$j]['cif_no'].'</td>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.(($datass[$j]['angsuran_pokok']==0 && $datass[$j]['pokok']==0)?'':$datass[$j]['pembiayaan_ke']).'</td>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.$datass[$j]['nama'].'</td>
                        <td align="center" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.$datass[$j]['freq'].'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['angsuran_pokok'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['angsuran_margin'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['angsuran_catab'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['setoran_lwk'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['tab_sukarela_cr'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['tab_wajib_cr'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['tab_kelompok_cr'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['tabren'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['tab_sukarela_db'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['pokok'],0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">'.number_format($datass[$j]['administrasi'],0,',','.').'</td>
                        <td align="right" style="text-align:right;padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;border-right:solid 1px #999">'.number_format($datass[$j]['asuransi'],0,',','.').'</td>
                     </tr>';
            }

            $html .= '
                     <tr>
                        <td align="right" style="padding:3px 6px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;font-weight:bold;" colspan="4">Total</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_angsuran_margin,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_angsuran_catab,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_setoran_lwk,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_tab_sukarela_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_tab_rencana,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_pokok,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">'.number_format($total_administrasi,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;">'.number_format($total_asuransi,0,',','.').'</td>
                     </tr>';


            $grandtotal_angsuran_pokok += $total_angsuran_pokok;
            $grandtotal_angsuran_margin += $total_angsuran_margin;
            $grandtotal_angsuran_catab += $total_angsuran_catab;
            $grandtotal_setoran_lwk += $total_setoran_lwk;
            $grandtotal_tab_sukarela_cr += $total_tab_sukarela_cr;
            $grandtotal_tab_wajib_cr += $total_tab_wajib_cr;
            $grandtotal_tab_kelompok_cr += $total_tab_kelompok_cr;
            $grandtotal_tab_rencana += $total_tab_rencana;
            $grandtotal_tab_sukarela_db += $total_tab_sukarela_db;
            $grandtotal_pokok += $total_pokok;
            $grandtotal_administrasi += $total_administrasi;
            $grandtotal_asuransi += $total_asuransi;

        }

            $html .= '
                     <tr>
                        <td align="right" style="padding:3px 6px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;font-weight:bold;" colspan="4">Grand Total</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_angsuran_pokok,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_angsuran_margin,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_angsuran_catab,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_setoran_lwk,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_tab_sukarela_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_tab_wajib_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_tab_kelompok_cr,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_tab_rencana,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_tab_sukarela_db,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_pokok,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">'.number_format($grandtotal_administrasi,0,',','.').'</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;">'.number_format($grandtotal_asuransi,0,',','.').'</td>
                     </tr>';

            $html .= '
                     <tr>
                        <td colspan="17" style="padding-top:5px;">
                        <table cellspacing="0" cellpadding="0" align="center" style="width:300px;">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Grand Total<br>Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Grand Total<br>Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($grandtotal_infaq,0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">'.number_format($grandtotal_setoran,0,',','.').'</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">'.number_format($grandtotal_penarikan,0,',','.').'</td>
                            </tr>
                        </table>
                        </td>
                     </tr>';

        $html .= '</table></div><p>&nbsp;</p>';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_lap_trx_rembug".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST TRANSAKSI REMBUG
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/
    public function export_list_saldo_tabungan()
    {
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);
        // $datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);

        if ($branch_code=="") 
        {            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } /*
        else if ($cm_code=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }*/
        else
        {

            ob_start();

            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['saldo_tabungan'] = $this->model_laporan->export_list_saldo_tabungan($branch_code,$cm_code);
            
            // $data['result']= $datas;
            if ($branch_code !='00000') 
            {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } 
            else 
            {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_list_saldo_tabungan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_saldo_tabungan_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/
    public function export_list_pembukaan_tabungan()
    {
        $produk = $this->uri->segment(3);
        $branch_code = $this->uri->segment(4);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        if($branch_code=='00000'){
            $data['cabang'] = "PUSAT (Gabungan)";
        }else{
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }
        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['saldo_tabungan'] = $this->model_laporan->export_list_pembukaan_tabungan($produk,$branch_code);
        $data['product_name']   = $this->model_laporan->get_produk($produk);
        $data['produk']         = $produk;

        $this->load->view('laporan/export_list_pembukaan_tabungan',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_saldo_tabungan_"'.$produk.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN BLOKIR TABUNGAN
    /****************************************************************************/
    public function export_list_blokir_tabungan()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2); 
        
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

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['blokir_tabungan'] = $this->model_laporan_to_pdf->export_list_blokir_tabungan($from_date,$thru_date,$branch_code);
        $data['tanggal1_view']   = $from_date;
        $data['tanggal2_view']   = $thru_date;

        $this->load->view('laporan/export_list_blokir_tabungan',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_blokir_tabungan_"'.$from_date.'s/d'.$thru_date.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN BLOKIR TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST REKENING TABUNGAN
    /****************************************************************************/
    public function export_list_rekening_tabungan()
    {
        $cif_no     = $this->uri->segment(3);
        $no_rek     = $this->uri->segment(4);
        $produk     = $this->uri->segment(5);
        $from_date1 = $this->uri->segment(6);
        $from_date  = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 = $this->uri->segment(7);   
        $thru_date  = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $awal_debit                 = $this->model_laporan->get_saldo_awal_debet($no_rek,$from_date);
        $awal_credit                = $this->model_laporan->get_saldo_awal_credit($no_rek,$from_date);
        $data['saldo_awal']         = $awal_credit['credit']-$awal_debit['debit'];
        $data['rek_tabungan']       = $this->model_laporan->export_list_statement_tabungan($cif_no,$no_rek,$produk,$from_date,$thru_date);
        $data['product_name']       = $this->model_laporan->get_produk($produk);
        $data['nama']               = $this->model_laporan->get_nama($cif_no);
        $data['produk']             = $produk;
        $data['tanggal1_view']      = $from_date;
        $data['tanggal2_view']      = $thru_date;
        $data['tgl_saldo_akhir']    = date("Y-m-d",strtotime($from_date.' -1 days'));
        $data['no_rek']             = $no_rek;
        $data['cif_no']             = $cif_no;

        $this->load->view('laporan/export_list_rekening_tabungan',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_rekening_tabungan_"'.$cif_no.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST REKENING TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST PEMBUKAAAN TABUNGAN
    /****************************************************************************/
    public function export_list_buka_tabungan()
    {
        $produk = $this->uri->segment(3);
        $from_date1 = $this->uri->segment(4);
        $from_date  = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 = $this->uri->segment(5);   
        $thru_date  = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  
        $branch_code = $this->uri->segment(6);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        if($branch_code=='00000'){
            $data['branch_name'] = "PUSAT (Gabungan)";
        }else{
            $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch['branch_class']=="1"){
                $data['branch_name'] .= " (Perwakilan)";
            }
        }

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['saldo_tabungan'] = $this->model_laporan->export_list_buka_tabungan($produk,$from_date,$thru_date,$branch_code);
        $data['product_name']   = $this->model_laporan->get_produk($produk);
        $data['produk']         = $produk;
        $data['tanggal1_view']  = $from_date;
        $data['tanggal2_view']  = $thru_date;

        $this->load->view('laporan/export_list_buka_tabungan',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pembukaan_tabungan_"'.$produk.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN CETAK TRANSAKSI BUKU TABUNGAN
    /****************************************************************************/
    public function cetak_trans_buku()
    {
        // $produk = $this->uri->segment(3);

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['cetak_buku']         = $this->model_laporan->export_cetak_trans_buku();
        // $data['margin']             = $this->model_laporan->get_margin();
        // $data['saldo_tabungan']  = $this->model_laporan->export_cetak_trans_buku($produk);
        // $data['product_name']    = $this->model_laporan->get_produk($produk);
        // $data['produk']          = $produk;

        $this->load->view('laporan/export_cetak_trans_buku',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_cetak_trans_buku.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END CETAK TRANSAKSI BUKU TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN PEMBUKAAN DEPOSITO
    /****************************************************************************/
    public function export_list_pembukaan_deposito()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2); 
        $branch_code = $this->uri->segment(5);
        if($branch_code=='00000'){
            $branch_name = '';
        }else{
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }
        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['regis_deposito']  = $this->model_laporan_to_pdf->export_list_pembukaan_deposito($from_date,$thru_date,$branch_code);
        $data['tanggal1_view']   = $from_date;
        $data['tanggal2_view']   = $thru_date;
        $data['cabang']         = ($branch_code=='00000')?'SEMUA CABANG':'CABANG '.$branch_name;

        $this->load->view('laporan/export_list_pembukaan_deposito',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pembukaan_deposito_"'.$from_date.'s/d'.$thru_date.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN PEMBUKAAN DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN SALDO DEPOSITO
    /****************************************************************************/
    public function export_list_saldo_deposito()
    {
        $produk = $this->uri->segment(3);

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['saldo_deposito'] = $this->model_laporan->export_list_saldo_deposito($produk);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);

        $this->load->view('laporan/export_list_saldo_deposito',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_saldo_deposito_"'.$produk.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN SALDO DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING DEPOSITO
    /****************************************************************************/
    public function export_lap_droping_deposito()
    {
        //REMBUG dihapus karna TAM ga pake rembug
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);          
        $cabang     = $this->uri->segment(5);               
        $rembug     = $this->uri->segment(6);               
            // if ($rembug==false) 
            // {
            //     $rembug = "";
            // } 
            // else 
            // {
            //     $rembug =   $rembug;            
            // }

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
                
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_droping_deposito',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_droping_deposito"'.$from_date.'_"'.$thru_date.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP PEMBUKAAN DEPOSITO
    /****************************************************************************/
    public function export_rekap_pembukaan_deposito()
    {
        $produk     = $this->uri->segment(3);
        $from_date  = $this->uri->segment(4);
        $from_date  = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(5);   
        $thru_date  = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);  

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['regis_deposito'] = $this->model_laporan->export_rekap_pembukaan_deposito($produk,$from_date,$thru_date);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['tanggal1']       = $from_date;
        $data['tanggal2']       = $thru_date;

        $this->load->view('laporan/export_rekap_pembukaan_deposito',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_pembukaan_deposito_"'.$produk.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP PEMBUKAAN DEPOSITO
    /****************************************************************************/

    //BEGIN LAPORAN OUTSTANDING
    /****************************************************************************/
    public function export_rekap_outstanding_deposito()
    {      
        $tanggal    = $this->current_date();
        $produk     = $this->uri->segment(3);               
        $cabang     = $this->uri->segment(4);               
        $rembug     = $this->uri->segment(5);    

            if ($rembug==false) 
            {
                $rembug = "";
            } 
            else 
            {
                $rembug =   $rembug;            
            }

            $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_deposito($cabang,$rembug,$tanggal,$produk);
                
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
                          
            $data['datas'] = $this->model_laporan_to_pdf->export_rekap_outstanding_deposito($cabang,$rembug,$tanggal,$produk);
            if ($cabang !='00000') 
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['data_cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } 
            else 
            {
                $data['data_cabang'] = "Semua Cabang";
            }

            $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
            $data['tanggal']        = $tanggal;

            $this->load->view('laporan/export_rekap_outstanding_deposito',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_outstanding_deposito_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
    }
    /****************************************************************************/
    //END LAPORAN OUTSTANDING
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP BAGI HASIL DEPOSITO
    /****************************************************************************/
    public function export_rekap_bagi_hasil_deposito()
    {
        $produk     = $this->uri->segment(3);
        $from_date  = $this->uri->segment(4);
        $from_date  = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(5);   
        $thru_date  = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);  

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['bahas_deposito'] = $this->model_laporan->export_rekap_bagi_hasil_deposito($produk,$from_date,$thru_date);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['tanggal1']       = $from_date;
        $data['tanggal2']       = $thru_date;

        $this->load->view('laporan/export_rekap_bagi_hasil_deposito',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_bagi_hasil_deposito_"'.$produk.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP BAGI HASIL DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN HISTORY TRANSAKSI DEPOSITO
    /****************************************************************************/
    public function export_list_rekening_deposito()
    {
        $cif_no     = $this->uri->segment(3);
        $no_rek     = $this->uri->segment(4);
        $produk     = $this->uri->segment(5);
        $from_date1 = $this->uri->segment(6);
        $from_date  = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 = $this->uri->segment(7);   
        $thru_date  = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  

        ob_start();
        
        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';
        
        $data['rek_tabungan']   = $this->model_laporan->export_list_rekening_deposito($cif_no,$no_rek,$produk,$from_date,$thru_date);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['nama']           = $this->model_laporan->get_nama($cif_no);
        $data['produk']         = $produk;
        $data['tanggal1_view']  = $from_date;
        $data['tanggal2_view']  = $thru_date;
        $data['no_rek']         = $no_rek;
        $data['cif_no']         = $cif_no;

        $this->load->view('laporan/export_list_rekening_deposito',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_rekening_deposito_"'.$cif_no.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN HISTORY TRANSAKSI DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    public function export_lap_transaksi_tabungan()
    {
        $from_date = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);          
        $cabang = $this->uri->segment(5);               
        $jenis_transaksi = $this->uri->segment(6);     

        if ($cabang==""){            
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }else if ($from_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else if ($thru_date==""){            
         echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        }else{   
        
            // $datas = $this->model_laporan_to_pdf->export_lap_transaksi_tabungan($cabang,$rembug,$from_date,$thru_date);
            $datas = $this->model_laporan_to_pdf->export_lap_transaksi_tabungan($cabang,$from_date,$thru_date,$jenis_transaksi); //rembug dihilangkan karena tam khusus individu
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;            
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_transaksi_tabungan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_transaksi_tabungan"'.$from_date.'_"'.$thru_date.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    public function export_lap_transaksi_akun()
    {
        $from_date  = $this->uri->segment(3);
        $from_date  = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date  = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);          
        $cabang     = $this->uri->segment(5);               
        $rembug     = $this->uri->segment(6);               
            if ($rembug==false) 
            {
                $rembug = "";
            } 
            else 
            {
                $rembug =   $rembug;            
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
                
            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } 
            else 
            {
                $data['cabang'] = "Semua Data";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_transaksi_akun',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_transaksi_akun"'.$from_date.'_"'.$thru_date.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/

    // public function export_rekap_saldo_anggota_semua_cabang()
    // {
    //     $cabang = $this->uri->segment(3);   

    //     $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
    //     // echo "<pre>";
    //     // print_r($datas);
    //     // die();
    //     ob_start();

    //     $config['full_tag_open'] = '<p>';
    //     $config['full_tag_close'] = '</p>';
        
    //     $data['result']= $datas;
    //     if ($cabang !='00000')  {
    //         $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
    //     } else {
    //         $data['cabang'] = "Semua Data";
    //     }

    //     $this->load->view('laporan/export_pdf_rekap_saldo_anggota',$data);

    //     $content = ob_get_clean();

    //     try
    //     {
    //         $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
    //         $html2pdf->pdf->SetDisplayMode('fullpage');
    //         $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //         $html2pdf->Output('REKAP SALDO ANGGOTA.pdf');
    //     }
    //     catch(HTML2PDF_exception $e) {
    //         echo $e;
    //         exit;
    //     }
    // }

    /****************************************************************************/
    //BEGIN LAPORAN REKAP SALDO ANGGOTA
    /****************************************************************************/
    public function export_rekap_saldo_anggota_semua_cabang()
    {
        $cabang = $this->uri->segment(3);  

        if($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
        ob_start();
        
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY CABANG "'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_cabang()
    {
        $cabang = $this->uri->segment(3);    

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
        
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY CABANG "'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_rembug()
    {
        $cabang = $this->uri->segment(3);    

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug($cabang);

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_by_rembug',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY REMBUG "'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_petugas()
    {
        $cabang = $this->uri->segment(3);    

        if ($cabang==false){
            $cabang = "00000";
        }else{
            $cabang =   $cabang;            
        }
        
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas($cabang);

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        }else{
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_by_petugas',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PETUGAS "'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP SALDO ANGGOTA
    /****************************************************************************/

    /* PDF GL INQUIRY */
    public function list_jurnal_umum_gl()
    {
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


        ob_start();
        
        // HEAD
        $html = '
            <h3 align="center" style="line-height:30px;">'.$this->session->userdata('institution_name').'<br>'.$branch_name.'<br>GL INQUIRY</h3>
            <table>
                <tr>
                    <td>GL Account</td>
                    <td>:</td>
                    <td>'.$account_name.'</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>'.$this->format_date_detail($from_date,'id',false,'/').' s.d '.$this->format_date_detail($thru_date,'id',false,'/').'</td>
                </tr>
            </table>
            <hr size="1">
        ';
        // TABLE DATA
        $html .= '
            <br>
            <table width="100" cellspacing="0" cellpadding="0" align="center">
                <thead>
                    <tr>
                        <th width="30" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">No.</th>
                        <th width="120" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Tanggal Transaksi</th>
                        <th width="400" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Deskripsi</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Debet</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Credit</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px;">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                ';

        for ( $i = 0 ; $i < count($data['data']) ; $i++ )
        {
            $html .= '
                    <tr>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">'.$data['data'][$i]['nomor'].'</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">'.(($data['data'][$i]['trx_date']=="")?"":$this->format_date_detail($data['data'][$i]['trx_date'],'id',false,'/')).'</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; white-space:normal; width:400px;">'.$data['data'][$i]['description'].'</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">'.(($data['data'][$i]['debit']=="")?'':number_format($data['data'][$i]['debit'],2,',','.')).'</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">'.(($data['data'][$i]['credit']=="")?'':number_format($data['data'][$i]['credit'],2,',','.')).'</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;" align="right">'.number_format($data['data'][$i]['saldo_akhir'],2,',','.').'</td>
                    </tr>
            ';
        }

        $html .= '
                    <tr>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" colspan="3" align="right">Total</td>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">'.number_format($data['total_debit'],2,',','.').'</td>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">'.number_format($data['total_credit'],2,',','.').'</td>
                        <td style="padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"></td>
                    </tr>
        ';

        $html .= '
                </tbody>
            </table>
        ';

        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN GL INQUIRY.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }

    }

    public function export_rekap_transaksi_rembug_by_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_semua_cabang($from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['branch_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA CABANG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA BY CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_cabang($cabang,$from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['branch_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY CABANG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_rembug_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA REMBUG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_semua_cabang($from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['cm_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA REMBUG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_rembug_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA BY REMBUG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_cabang($cabang,$from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['cm_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY REMBUG.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_petugas_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA PETUGAS</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_semua_cabang($from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['fa_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA PETUGAS.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_petugas_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(4),'-');
        $desc_from_date = ($from_date=="")?"":$this->format_date_detail($from_date,'id',false,'/');
        $thru_date = ($this->uri->segment(5)=="-")?"":$this->datepicker_convert(false,$this->uri->segment(5),'-');
        $desc_thru_date = ($thru_date=="")?"":$this->format_date_detail($thru_date,'id',false,'/');

        ob_start();
        
        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>'.$desc_from_date.' s.d '.$desc_thru_date.'</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';
        
        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_cabang($cabang,$from_date,$thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for($i=0;$i<count($datas);$i++){

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.$datas[$i]['fa_name'].'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_pokok'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_margin'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['angsuran_catab'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_wajib_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['tab_kelompok_cr'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">'.number_format($datas[$i]['droping'],0,',','.').'</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">'.number_format($datas[$i]['tab_sukarela_db'],0,',','.').'</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_pokok,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_margin,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_angsuran_catab,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_wajib_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_tab_kelompok_cr,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">'.number_format($total_droping,0,',','.').'</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">'.number_format($total_tab_sukarela_db,0,',','.').'</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY PETUGAS.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function laporan_jurnal_transaksi()
    {
        ob_start();

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

        // HEAD
        $html = '
            <h3 style="margin:5px 0;" align="center">'.$this->session->userdata('institution_name').'</h3>
            <h4 style="margin:5px 0;" align="center">'.$this->session->userdata('branch_name').'</h4>
            <img src="'.base_url().'assets/img/logo-koptel-min.png" style="width:128px;margin-top:-45px;float:right;">
            <h4 style="margin-left:0px;" align="center">LAPORAN JURNAL TRANSAKSI</h4>
            <table>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>'.$this->format_date_detail($from_date,'id',false,'/').' s.d '.$this->format_date_detail($thru_date,'id',false,'/').'</td>
                </tr>
                <tr>
                    <td>Jenis Transaksi</td>
                    <td>:</td>
                    <td>'.$jenis_transaksi.'</td>
                </tr>
            </table>
            <hr size="1">
        ';
        // TABLE DATA
        $html .= '
            <br>
            <table cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th width="18" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">No.</th>
                        <th width="120" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Tanggal Transaksi</th>
                        <th width="90" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Voucher Date</th>
                        <th width="200" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Keterangan</th>
                        <th width="80" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">No. Bukti</th>
                        <th width="200" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Account</th>
                        <th width="100" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Debit</th>
                        <th width="100" align="center" style="font-size:12px;background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px;">Credit</th>
                    </tr>
                </thead>
                <tbody>
                ';


        $trx_gl = $this->model_laporan->get_trx_gl($from_date,$thru_date,$branch_code,$jurnal_trx_type);
        $no = 0;
        $row_num=5;
        for($i=0;$i<count($trx_gl);$i++){
            $no++;

            $html_in1 = '<table cellspacing="0" cellpadding="0" style="border-spacing:0;padding:0;">';
            $html_in2 = '<table cellspacing="0" cellpadding="0" style="border-spacing:0;padding:0;">';
            $html_in3 = '<table cellspacing="0" cellpadding="0" style="border-spacing:0;padding:0;">';

            $trx_gl_detail = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl[$i]['trx_gl_id']);
            $num_row=count($trx_gl_detail);
            for($j=0;$j<count($trx_gl_detail);$j++)
            {
                $html_in1 .= '<tr>';
                $html_in2 .= '<tr>';
                $html_in3 .= '<tr>';
                if($j>0) $row_num++;
                if($num_row==($j+1)){
                    $html_in1 .= '<td style="margin:0;width:200px;font-size:12px;padding:5px;">'.$trx_gl_detail[$j]['account_name'].'</td>';
                    $html_in2 .= '<td style="margin:0;width:100px;font-size:12px;padding:5px;" align="right">'.(($trx_gl_detail[$j]['debit']=="")?'':number_format($trx_gl_detail[$j]['debit'],0,',','.')).'</td>';
                    $html_in3 .= '<td style="margin:0;width:100px;font-size:12px;padding:5px;" align="right">'.(($trx_gl_detail[$j]['credit']=="")?'':number_format($trx_gl_detail[$j]['credit'],0,',','.')).'</td>';
                }else{
                    $html_in1 .= '<td style="margin:0;width:200px;font-size:12px;padding:5px;border-bottom:solid 1px #CCC;">'.$trx_gl_detail[$j]['account_name'].'</td>';
                    $html_in2 .= '<td style="margin:0;width:100px;font-size:12px;padding:5px;border-bottom:solid 1px #CCC;" align="right">'.(($trx_gl_detail[$j]['debit']=="")?'':number_format($trx_gl_detail[$j]['debit'],0,',','.')).'</td>';
                    $html_in3 .= '<td style="margin:0;width:100px;font-size:12px;padding:5px;border-bottom:solid 1px #CCC;" align="right">'.(($trx_gl_detail[$j]['credit']=="")?'':number_format($trx_gl_detail[$j]['credit'],0,',','.')).'</td>';
                }
                $html_in1 .= '</tr>';
                $html_in2 .= '</tr>';
                $html_in3 .= '</tr>';
            }
            
            $html_in1 .= '</table>';
            $html_in2 .= '</table>';
            $html_in3 .= '</table>';

            $html .= '
                    <tr>
                        <td valign="top" style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center" width="18">'.$no.'</td>
                        <td valign="top" style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">'.(($trx_gl[$i]['trx_date']=="")?"":$this->format_date_detail($trx_gl[$i]['trx_date'],'id',false,'/')).'</td>
                        <td valign="top" style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">'.(($trx_gl[$i]['voucher_date']=="")?"":$this->format_date_detail($trx_gl[$i]['voucher_date'],'id',false,'/')).'</td>
                        <td valign="top" style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; width:200px;">'.$trx_gl[$i]['description'].'</td>
                        <td valign="top" style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; width:80;">'.$trx_gl[$i]['voucher_ref'].'</td>
                        <td valign="top" style="padding:0;margin:0;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;" valign="top">'.$html_in1.'</td>
                        <td valign="top" style="padding:0;margin:0;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;" valign="top">'.$html_in2.'</td>
                        <td valign="top" style="padding:0;margin:0;border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCCCCC;" valign="top">'.$html_in3.'</td>
                    </tr>
            ';

        }

        $html .= '
                </tbody>
            </table>
        ';

        echo $html;

        $content = ob_get_clean();

        // $trx_gl = $this->model_laporan->get_trx_gl($from_date,$thru_date);
        // $no = 0;
        // $row_num=5;
        // for($i=0;$i<count($trx_gl);$i++){
        //     $no++;
        //     $objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num,$no);
        //     $objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num,$trx_gl[$i]['trx_date']);
        //     $objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num,$trx_gl[$i]['voucher_date']);
        //     $objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num,$trx_gl[$i]['description']);
        //     $objPHPExcel->getActiveSheet()->getStyle('B'.$row_num.':D'.$row_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //     $trx_gl_detail = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl[$i]['trx_gl_id']);
        //     for($j=0;$j<count($trx_gl_detail);$j++)
        //     {
        //         if($j>0) $row_num++;
        //         $objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num,$trx_gl_detail[$j]['account_name']);
        //         $objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num,' '.number_format($trx_gl_detail[$j]['debit'],0,',','.'));
        //         $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num,' '.number_format($trx_gl_detail[$j]['credit'],0,',','.'));
        //         $objPHPExcel->getActiveSheet()->getStyle('G'.$row_num.':H'.$row_num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //     }
        //     $row_num++;
        // }

        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN JURNAL TRANSAKSI.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /**********************************************************************************************************/
    // BEGIN EXPORT KARTU PENGAWASAN ANGSURAN
    /**********************************************************************************************************/
    public function export_kartu_pengawasan_angsuran()
    {      
        $account_financing_no = $this->uri->segment(3);   
        // $cif_no = $this->uri->segment(4);   
        // $cif_type = $this->uri->segment(5);   

            ob_start();
            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data_cif = $this->model_laporan->get_cif_by_account_financing_no($account_financing_no);
            $cif_no=$data_cif['cif_no'];
            $cif_type=$data_cif['cif_type'];
            $datas['data'] = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);
            
            if (isset($datas['data']['nama'])) 
            {
                $data = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);
                if($cif_type==0){ //kelompok
                    $data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,0);
                }
                $html = '';
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
                        if($cif_type==1){ //individu
                            $data_trx = $this->model_laporan->get_trx_cm_by_account_cif_no($account_financing_no,$cif_no,1,$tgl_angsur);
                            $tgl_bayar = (isset($data_trx['trx_date'])==true)?$data_trx['trx_date']:'';
                            $validasi = (isset($data_trx['created_by'])==true)?$data_trx['created_by']:'';
                        }
                        $jumlah_angsur = $data['jumlah_angsuran'];
                        $angsuran_hutang = $data['angsuran_pokok']+$data['angsuran_margin']+$data['angsuran_catab'];
                        $saldo_hutang = ($data['pokok']+$data['margin'])-($angsuran_hutang*$no);
                        if($data['jangka_waktu']==$no){
                            $jumlah_angsur = ($data['pokok']+$data['margin'])-($angsuran_hutang*($no-1));
                            $saldo_hutang=0;
                        }
                        $tgl_bayar = ($tgl_bayar!='') ? date("d-m-Y", strtotime($tgl_bayar)) : '' ;
                        $html .= '<tr>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:center;">'.date("d-m-Y", strtotime($tgl_angsur)).'</td>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:center;">'.$tgl_bayar.'</td>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:right;">'.$no.'</td>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:right;">'.number_format($jumlah_angsur,0,',','.').'</td>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:right;">'.number_format($saldo_hutang,0,',','.').'</td>
                                      <td style="font-size:11px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:2px 5px 2px 5px; text-align:left;">'.$validasi.'</td>
                                  </tr>';

                        $no++;
                    }
                }
                $datas['row_angsuran']=$html;
            } else {
                $datas['row_angsuran']='';
            }
            


            $datas['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
            // $data['cetak']          = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data($account_financing_id);
            $datas['data_cabang']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_cabang($data_cif['branch_code']);
            // $datas['cetak_petugas']  = $this->model_laporan_to_pdf->get_nama_petugas_by_financing_reg_no($account_financing_no);

            $this->load->view('laporan/export_kartu_pengawasan_angsuran',$datas);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('kartu_pengawasan_angsuran"'.$cif_no.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }       
    }
    /**********************************************************************************************************/
    // END EXPORT KARTU PENGAWASAN ANGSURAN
    /**********************************************************************************************************/

    /****************************************************************************/
    //BEGIN CETAK AKAN PEMBIAYAAN Ade Sagita 18-08-2014
    /****************************************************************************/
    public function cetak_akad_pembiayaan()
    {

        $account_financing_id  = $this->uri->segment(3);
        $akad  = strtolower($this->uri->segment(4));
        $produk  = strtolower($this->uri->segment(5));

        $nama_pasangan  = urldecode($this->uri->segment(6));
        $status_pasangan  = urldecode($this->uri->segment(7));

        $saksi1 = (urldecode($this->uri->segment(8))) ? urldecode($this->uri->segment(8)) : '' ;
        // $saksi2 = (urldecode($this->uri->segment(9))) ? urldecode($this->uri->segment(9)) : '' ;
        $data['nama_pasangan']  = $nama_pasangan;
        $data['status_pasangan']= $status_pasangan;
        $data['saksi1'] = $saksi1;
        // $data['saksi2'] = $saksi2;

            $prod = strtolower(str_replace(' ','',$produk));
            $prod = str_replace('%20','',$prod);
            if($prod=='koptelsmile' || $prod=='smile'){
                $view = 'laporan/export_cetak_akad_pembiayaan_'.strtolower($akad);    
                $code_product = 52; //untuk memilih pejabat yg bertanda tangan (lookup ke list_code_detail)      
            }else if($prod=='kreditmultiguna' || $prod=='kmg'){
                $view = 'laporan/export_cetak_akad_pembiayaan_multiguna';    
                $code_product = 54; //untuk memilih pejabat yg bertanda tangan (lookup ke list_code_detail)      
            }else if($prod=='kreditpemilikanrumah' || $prod=='kpr'){
                $view = 'laporan/export_cetak_akad_pembiayaan_kpr';          
                $code_product = 56; //untuk memilih pejabat yg bertanda tangan (lookup ke list_code_detail)
            }else if($prod=='banmod' || $prod=='komersial'){
                $view = 'laporan/export_cetak_akad_pembiayaan_banmod_'.strtolower($akad);   
                $code_product = 58; //untuk memilih pejabat yg bertanda tangan (lookup ke list_code_detail)       
            }else{
                echo "<script>alert('Data tidak ditemukan !');javascript:window.close();</script>";
            }
            // echo $view;die();


            $data['cetak'] = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data($account_financing_id);
            if($prod=='banmod'){
                $data['cetak'] = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data_banmod($account_financing_id);
            }
            $data['termin'] = $this->model_laporan_to_pdf->termin_cetak_akad_pembiayaan_banmod($account_financing_id);
            
            if(count($data['cetak'])==0){
                echo "<script>alert('Data tidak ditemukan !');javascript:window.close();</script>";
            }

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            if ($prod!='banmod') { // bukan banmod
                if (strtolower($data['cetak']['status_chaneling'])=='y') { //yg bertandatangan pejabat kopegtel
                    // echo "string";die();
                    $data['pejabat_nama'] = $data['cetak']['ketua_pengurus'];
                    $data['pejabat_nik'] = $data['cetak']['nik'];
                    $data['pejabat_jabatan'] = $data['cetak']['jabatan'];
                    $data['pejabat_alamat'] = '-';
                } else {
                    $pejabatakad = $this->model_laporan_to_pdf->get_pejabatakad($code_product); // pejabat yg menandatangani akad lookup ke list_code_detail
                    foreach($pejabatakad as $pa) {
                        $data[$pa['code_value']] = $pa['display_text'];
                    }
                }
            } else { // banmod
                $pejabatakad = $this->model_laporan_to_pdf->get_pejabatakad($code_product); // pejabat yg menandatangani akad lookup ke list_code_detail
                foreach($pejabatakad as $pa) {
                    $data[$pa['code_value']] = $pa['display_text'];
                }
            }

            $data['seri_surat'] = $this->model_laporan_to_pdf->get_seri_akad_pembiayaan();

            if($prod=='kreditmultiguna' || $prod=='kmg'){
                $data['data_jaminan'] = $this->model_laporan_to_pdf->get_data_jaminan($data['cetak']['registration_no']);
                $data['jadwal_angsuran'] = $this->model_nasabah->get_schedulle_by_account_financing_id($data['cetak']['account_financing_id']);
            }
            if($prod=='kreditpemilikanrumah' || $prod=='kpr'){
                $data['data_jaminan'] = $this->model_laporan_to_pdf->get_data_jaminan($data['cetak']['registration_no']);
                $data['jadwal_angsuran'] = $this->model_nasabah->get_schedulle_by_account_financing_id($data['cetak']['account_financing_id']);
            }
            if($prod=='banmod' || $prod=='komersial'){
                $data['jadwal_angsuran'] = $this->model_nasabah->get_schedulle_by_account_financing_id($data['cetak']['account_financing_id']);
            }

            if($data['cetak']['pengajuan_melalui']=="koptel"){
                $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
            }else{
                $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_kopegtel_by_code($data['cetak']['kopegtel_code']);
            }
            
            // echo $view;die();
            $this->load->view($view,$data);    

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5,15,5,18));
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('cetak_akad_pembiayaan".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }

    }
    public function cetak_akad_pembiayaan_dgn_wakalah()
    {

        $account_financing_id  = $this->uri->segment(3);
        $akad  = strtolower($this->uri->segment(4));
        $produk  = strtolower($this->uri->segment(5));
        $saksi1  = urldecode($this->uri->segment(6));
        $saksi2  = urldecode($this->uri->segment(7));
        $menyetujui  = urldecode($this->uri->segment(8));
        $status_anggota  = urldecode($this->uri->segment(9));

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
            $data['cetak']          = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data($account_financing_id);
            $data['data_cabang']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_cabang($data['cetak']['branch_code']);
            if($saksi1!=""){
                $data['saksi1']         = $saksi1;
            }else{
                $data['saksi1']         = "..............................";
            }
            if($saksi2!=""){
                $data['saksi2']         = $saksi2;
            }else{
                $data['saksi2']         = "..............................";
            }
            if($menyetujui!=""){
                $data['menyetujui']         = $menyetujui;
            }else{
                $data['menyetujui']         = "..............................";
            }
            if($status_anggota!=""){
                $data['status_anggota']         = $status_anggota;
            }else{
                $data['status_anggota']         = "..............................";
            }

            // echo $produk;die();
            if ($produk=='k3%20murabahah') {
                $this->load->view('laporan/cetak_akad_pembiayaan_dgn_wakalah_k3_mrb',$data);
            } else {
                $this->load->view('laporan/cetak_akad_pembiayaan_dgn_wakalah_'.$akad,$data);
            }

    }

    public function cetak_persetujuan_pembiayaan()
    {

        $account_financing_id  = $this->uri->segment(3);
        $akad  = strtolower($this->uri->segment(4));
        $saksi1  = urldecode($this->uri->segment(6));
        $saksi2  = urldecode($this->uri->segment(7));

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
            $data['cetak']          = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data($account_financing_id);
            $data['data_cabang']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_cabang($data['cetak']['branch_code']);
            $data['saksi1']         = $saksi1;
            $data['saksi2']         = $saksi2;

            $this->load->view('laporan/export_cetak_persetujuan_pembiayaan_baru',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5,15,5,18));
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('cetak_persetujuan_pembiayaan".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }

    }
    /****************************************************************************/
    //END CETAK AKAN PEMBIAYAAN
    /****************************************************************************/

    /*LAPORAN LIST ANGSURAN PEMBIAYAAN*/
    public function export_list_angsuran_pembiayaan_individu()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
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
        $tipe_angsuran = $this->uri->segment(10);
        $status_telkom = $this->uri->segment(11);
        $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($tanggal1_,$tanggal2_,$cabang,$petugas,$produk,$akad,$pengajuan_melalui,$tipe_angsuran,$status_telkom);
        $produk_name = $this->model_laporan->get_produk_name($produk);
        $petugas_name = $this->model_laporan->get_petugas_name($petugas);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        // $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $this->load->view('laporan/export_list_angsuran_pembiayaan_individu',$data);
        $content = ob_get_clean();
        try{
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_angsuran_pembiayaan_individu"'.$tanggal1__.'_"'.$tanggal1__.'".pdf');
        }
        catch(HTML2PDF_exception $e){
            echo $e;
            exit;
        }
    }


    /**********************************************************************************************/
    //TAMBAHAN ADE 14-09-2014
    //Rekap jatuh tempo by Peruntukan
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_product',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_product"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_rekap_pengajuan_pembiayaan_status()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_status($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_status',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_status"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //END TAMBAHAN ADE 14-09-2014
    /**********************************************************************************************/

    /*LAPORAN JATUH TEMPO ANGSURAN*/
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
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
        }
        $data['produk_name'] = $produk_name;
        $data['petugas_name'] = $petugas_name;
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['resort_name'] = $this->model_laporan->get_resort_name($resort);
        $this->load->view('laporan/export_list_jatuh_tempo_angsuran',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_jatuh_tempo_angsuran"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /*LAPORAN DATA LENGKAP ANGGOTA*/
    public function export_data_lengkap_anggota()
    {
        $cif_no = $this->uri->segment(3);
        $data_anggota = $this->model_laporan_to_pdf->export_data_lengkap_anggota($cif_no);
        $data_tabungan = $this->model_laporan_to_pdf->export_data_lengkap_tabungan($cif_no);
        $data_deposito = $this->model_laporan_to_pdf->export_data_lengkap_deposito($cif_no);
        $data_pembiayaan = $this->model_laporan_to_pdf->export_data_lengkap_pembiayaan($cif_no);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['anggota'] = $data_anggota;
        $data['tabungan'] = $data_tabungan;
        $data['deposito'] = $data_deposito;
        $data['pembiayaan'] = $data_pembiayaan;
        $this->load->view('laporan/export_data_lengkap_anggota',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 6);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_data_lengkap_anggota"'.$cif_no.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
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

        for($i = 0; $i < count($datas); $i++){
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

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['branch_name'] = $branch_name;
        $data['periode_bulan'] = $from_periode;
        $data['periode_tahun'] = $thru_periode;
        $this->load->view('laporan/pdf_mutasi_saldo',$data);

        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Mutasi_Saldo_pembiayaan'.date('YmdHis').'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
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

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['branch_name'] = $branch_name;
        $data['periode_bulan'] = $periode_bulan;
        $data['periode_tahun'] = $periode_tahun;
        $this->load->view('laporan/pdf_neraca_saldo_gl',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Trial_Balance_'.date('YmdHis').'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /*LAPORAN TO PDF*/
    public function cetak_cover_buku_tabungan()
    {
        $account_saving_no = $this->uri->segment(3);
        $datasaving = $this->model_laporan_to_pdf->get_account_saving_data_by_account_saving_no($account_saving_no);
        ob_start();
        $data['saving'] = $datasaving;
        $this->load->view('laporan/pdf_cetak_cover_buku_tabungan',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Trial_Balance_'.date('YmdHis').'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    /*
    Modul : Laporan Rekapitulasi NPL
    author : Ujang Irawan
    date : 08-10-2014 08:50
    */

    public function export_rekapitulasi_npl()
    {
        $cabang = $this->uri->segment(3);    
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl($cabang);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result']= $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang !='00000'){
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if($branch['branch_class']=="1"){
                $data['cabang'] .= " (Perwakilan)";
                $nama_cabang = 'CABANG '.$data['cabang'];
            }
        }else{
            $data['cabang'] = "PUSAT (Gabungan)";
            $nama_cabang = "PUSAT (Gabungan)";
        }
        $this->load->view('laporan/export_rekapitulasi_npl',$data);
        $content = ob_get_clean();
        try
        {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl_"'.$nama_cabang.'".pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    /*
    | Modul : Laporan Neraca Rinci
    | author : Sayyid Nurkilah
    | date : 2014-10-09 09:24
    */

    public function export_neraca_rinci_gl()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari  = $this->uri->segment(6);
        if ($branch_code=="") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_rinci_gl($branch_code,$periode_bulan,$periode_tahun,$periode_hari);
            if ($branch_code !='00000'){
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                if($branch['branch_class']=="1"){
                    $data['branch_name'] .= " (Perwakilan)";
                }
            }else{
                $data['branch_name'] = "PUSAT (Gabungan)";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/pdf_neraca_rinci_gl',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_neraca_rinci_gl"'.$branch_code.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
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

        $from_date = $this->get_from_trx_date();
        $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
        
        if ($cabang==""){            
         echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun==""){            
         echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi_rinci($cabang,$from_date,$last_date);
            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/pdf_laba_rugi_rinci_gl',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_laba_rugi_rinci_gl".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    
    public function cetak_hasil_scoring()
    {

        $account_financing_scoring_id  = $this->uri->segment(3);

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            

            $data['cetak']  = $this->model_laporan_to_pdf->get_cif_by_account_financing_reg_scoring($account_financing_scoring_id);
            $data['scoring_adm']  = $this->model_laporan_to_pdf->cetak_hasil_scoring_adm($account_financing_scoring_id);
            $valscoring      = $this->model_laporan_to_pdf->cetak_hasil_scoring($account_financing_scoring_id);
            $scoringadmkeldoc     = $this->model_cif->get_list_code('scoringadmkeldoc');
            $scoringpendidikan    = $this->model_cif->get_list_code('scoringpendidikan');
            $scoringpemkewman    = $this->model_cif->get_list_code('scoringpemkewman');
            $scoringpnglmnusaha    = $this->model_cif->get_list_code('scoringpnglmnusaha');

            $data['tamleadm']   = '';
            for ($i=0; $i<count($scoringadmkeldoc); $i++) { 
                $cek_skor_adm      = $this->model_laporan_to_pdf->cek_skor_adm($account_financing_scoring_id,$scoringadmkeldoc[$i]['code_value']);
                $img = ($cek_skor_adm=='yes') ? '<img src="'.base_url().'assets/img/checklist.png">' : '' ;
                $data['tamleadm']   .=  '<tr>
                                          <td align="center" width="15">'.$img.'</td>
                                          <td width="450">'.$scoringadmkeldoc[$i]['display_text'].'</td>
                                        </tr>';
            }

            $data['tamlependidikan']   = '';
            for ($i=0; $i<count($scoringpendidikan); $i++) { 
                $img = ($valscoring['pendidikan']==$scoringpendidikan[$i]['code_value']) ? '<img src="'.base_url().'assets/img/checklist.png">' : '' ;
                $data['tamlependidikan']   .=  '<tr>
                                                  <td style="border:none;" align="center" width="15">'.$img.'</td>
                                                  <td style="border:none;" width="415">'.$scoringpendidikan[$i]['display_text'].'</td>
                                                </tr>';
            }

            $data['trlepkm']   = '';
            for ($i=0; $i<count($scoringpemkewman); $i++) { 
                $img = ($valscoring['pemkewman']==$scoringpemkewman[$i]['code_value']) ? '<img src="'.base_url().'assets/img/checklist.png">' : '' ;
                $data['trlepkm']   .=  '<tr>
                                                  <td style="border:none;" align="center" width="15">'.$img.'</td>
                                                  <td style="border:none;" width="415">'.$scoringpemkewman[$i]['display_text'].'</td>
                                                </tr>';
            }

            $data['tblpnglmnusaha']   = '';
            for ($i=0; $i<count($scoringpnglmnusaha); $i++) { 
                $img = ($valscoring['pnglmnusaha']==$scoringpnglmnusaha[$i]['code_value']) ? '<img src="'.base_url().'assets/img/checklist.png">' : '' ;
                $data['tblpnglmnusaha']   .=  '<tr>
                                                  <td style="border:none;" align="center" width="15">'.$img.'</td>
                                                  <td style="border:none;" width="415">'.$scoringpnglmnusaha[$i]['display_text'].'</td>
                                                </tr>';
            }
            
            $data['trusahaprod']   = '';
            $valtempatusaha = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringtempatusaha',$valscoring['tempatusaha']);
            $data['trusahaprod']   .=  '<tr>
                                          <td align="center" width="15">1</td>
                                          <td width="150">Tempat Usaha</td>
                                          <td width="250">'.$valtempatusaha.'</td>
                                       </tr>';
            $vallokasiusaha = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringlokasiusaha',$valscoring['lokasiusaha']);
            $data['trusahaprod']   .=  '<tr>
                                          <td align="center" width="15">2</td>
                                          <td width="150">Lokasi Usaha</td>
                                          <td width="250">'.$vallokasiusaha.'</td>
                                       </tr>';
            $valkegiatanusaha = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringkegiatanusaha',$valscoring['kegiatanusaha']);
            $data['trusahaprod']   .=  '<tr>
                                          <td align="center" width="15">3</td>
                                          <td width="150">Kegiatan Usaha</td>
                                          <td width="250">'.$valkegiatanusaha.'</td>
                                       </tr>';
            $valhubunganusaha = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringhubunganusaha',$valscoring['hubunganusaha']);
            $data['trusahaprod']   .=  '<tr>
                                          <td align="center" width="15">4</td>
                                          <td width="150">Hubungan Usaha</td>
                                          <td width="250">'.$valhubunganusaha.'</td>
                                       </tr>';
            $vallamaberusaha = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringlamaberusaha',$valscoring['lamaberusaha']);
            $data['trusahaprod']   .=  '<tr>
                                          <td align="center" width="15">5</td>
                                          <td width="150">Lama Berusaha</td>
                                          <td width="250">'.$vallamaberusaha.'</td>
                                       </tr>';

            $data['traset']   =  '';
            $valscoringhartatetap = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringhartatetap',$valscoring['hartatetap']);
            $data['traset']   .=  '<tr>
                                      <td align="center" width="15">1</td>
                                      <td width="150">Harta tetap yang dimiliki</td>
                                      <td width="250">'.$valscoringhartatetap.'</td>
                                   </tr>';
            $valscoringhartalancar = $this->model_laporan_to_pdf->get_value_scoring_by_code_val('scoringhartalancar',$valscoring['hartalancar']);
            $data['traset']   .=  '<tr>
                                      <td align="center" width="15">2</td>
                                      <td width="150">Harta Lancar</td>
                                      <td width="250">'.$valscoringhartalancar.'</td>
                                   </tr>';

            if ($valscoring['total_skor']>450) {
                $rekomendasi = 'Sangat Layak Diberikan Kredit';
            }else if ($valscoring['total_skor']>351){
                $rekomendasi = 'Layak diberikan kredit';
            }else if ($valscoring['total_skor']>301){
                $rekomendasi = 'Dapat diberikan kredit';
            }else if ($valscoring['total_skor']>201){
                $rekomendasi = 'Dapat diberikan dengan tambahan jaminan fisik';
            }else{
                $rekomendasi = 'Tidak dapat diberikan';
            }
            $data['hasil']='
                            <div align="center" style="color:red;font-weight:bold;font-size:15px;margin-bottom: 10px;margin-top: 3px;" id="txt_total_skor">'.$valscoring['total_skor'].'</div>
                            <div id="ket_score" align="center" style="background: rgb(73, 128, 226);margin: 0 7px;color:white;margin: 0 7px;border: solid 1px #1A4797;border-radius: 5px !important;line-height: 16px;padding: 4px;">'.$rekomendasi.'</div>
                            ';

            $this->load->view('laporan/export_cetak_hasil_scoring',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5,15,5,18));
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('cetak_hasil_scoring".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }

    }

    /**********************************************************************/
    //REKAP ANGSURAN
    public function export_rekap_angsuran_pembiayaan_petugas()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_pembiayaan_petugas($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_angsuran_by_pembiayaan_petugas',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_angsuran_pembiayaan_bypetugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_rekap_angsuran_pembiayaan_produk()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_pembiayaan_produk($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_angsuran_by_pembiayaan_produk',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_angsuran_pembiayaan_byproduk"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_rekap_angsuran_pembiayaan_peruntukan()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_pembiayaan_peruntukan($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_angsuran_by_pembiayaan_peruntukan',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_angsuran_pembiayaan_byperuntukan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_rekap_angsuran_pembiayaan_cabang()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_pembiayaan_cabang($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_angsuran_by_pembiayaan_cabang',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_angsuran_pembiayaan_bycabang"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_rekap_angsuran_pembiayaan_resort()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_pembiayaan_resort($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_angsuran_by_pembiayaan_resort',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_angsuran_pembiayaan_byresort"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //END REKAP ANGSURAN
    /**********************************************************************/

    /*
    | DATA LENGKAP PEMBIAYAAN
    */
    function data_lengkap_pembiayaan()
    {
        /*get no.rekening*/
        $account_financing_no=$this->uri->segment(3);
        if($account_financing_no==false){
            show_404();
        }

        /*get data pembiayaan*/
        $pembiayaan=$this->model_laporan->get_data_lengkap_pembiayaan($account_financing_no);
        $cif=$this->model_laporan->get_data_lengkap_anggota($pembiayaan['cif_no']);
        $fa=$this->model_laporan->get_data_fa_by_fa_code($pembiayaan['fa_code']);
        $resort=$this->model_laporan->get_data_resort_by_resort_code($pembiayaan['resort_code']);
        $produk=$this->model_laporan->get_data_product_financing_by_product_code($pembiayaan['product_code']);
        $akad=$this->model_laporan->get_akad_financing_by_akad_code($pembiayaan['akad_code']);
        /*generate pdf*/
        ob_start();

        $data['pembiayaan']=$pembiayaan;
        $data['cif']=$cif;
        $data['fa']=$fa;
        $data['resort']=$resort;
        $data['produk']=$produk;
        $data['akad']=$akad;

        $this->load->view('laporan/data_lengkap_pembiayaan_pdf',$data);

        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Data Lengkap Pembiayaan Rek.'.$pembiayaan['account_financing_no'].'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function list_pelunasan_pendebetan_angsuran()
    {
        $tanggal = $this->input->post('lp_tanggal');
        $account_financing_no = $this->input->post('lp_account_financing_no');
        $nama = $this->input->post('lp_nama');
        $angsuran = $this->input->post('lp_angsuran');
        $saldo_pokok = $this->input->post('lp_saldo_pokok');
        $saldo_margin = $this->input->post('lp_saldo_margin');
        $saldo_tabungan = $this->input->post('lp_saldo_tabungan');
        $branch_code = $this->session->userdata('branch_code');
        
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        if ($branch_code !='00000'){
            $cabang = $this->model_laporan_to_pdf->get_cabang($branch_code);
            if($branch['branch_class']=="1"){
                $cabang .= " (Perwakilan)";
            }
        }else{
            $cabang = "PUSAT (Gabungan)";
        }

        ob_start();
        $html = '
        <div style="text-align:center;line-height:22px;font-weight:bold;font-size:12">
        '.$this->session->userdata('institution_name').'<br>
        '.$cabang.'<br>
        LIST PELUNASAN PENDEBETAN ANGSURAN PEMBIAYAAN
        </div>
        <div style="padding:20px 0 5px 0;border-bottom:1 solid #CCC;line-height:18px;font-size:11px;">Tanggal Jatuh Tempo : '.substr($tanggal,0,2).'/'.substr($tanggal,2,2).'/'.substr($tanggal,4,4).'</div>
        <br/>
        <table style="border:solid 1px #CCC;" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:20px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">No</th>
                    <th style="width:100px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">No.Account</th>
                    <th style="width:160px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Nama</th>
                    <th style="width:80px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Angsuran</th>
                    <th style="width:80px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Saldo Pokok</th>
                    <th style="width:80px;background:#F5F5F5;padding:5px;font-size:10px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Saldo Margin</th>
                    <th style="width:80px;background:#F5F5F5;padding:5px;font-size:10px;border-bottom:solid 1px #CCC;" align="center">Saldo Tabungan</th>
                </tr>
            </thead>
            <tbody>';
        $no = 1;
        for ( $i = 0 ; $i < count($account_financing_no) ; $i++ )
        {

            $html .= '
                    <tr>                    
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="center">'.$no.'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="left">'.$account_financing_no[$i].'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="left">'.$nama[$i].'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right">'.number_format($angsuran[$i],0,',','.').'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right">'.number_format($saldo_pokok[$i],0,',','.').'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right">'.number_format($saldo_margin[$i],0,',','.').'</td>
                        <td style="font-size:10px;padding:5px;border-bottom:solid 1px #CCC;" align="right">'.number_format($saldo_tabungan[$i],0,',','.').'</td>
                    </tr>
            ';

            $no++;
        }

        $html .= '
            </tbody>
        </table>
        ';

        echo $html;


        $content = ob_get_clean();

        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('List Pelunasan Pendebetan Angsuran Tanggal : '.$tanggal.'.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /*
    ** Cetak SP4 06-04-2015
    */
    public function cetak_sp4()
    {

        $account_financing_reg_id  = $this->uri->segment(3);
        $akad  = strtolower($this->uri->segment(4));
        $nama_pasangan  = urldecode($this->uri->segment(5));
        $status_pasangan  = urldecode($this->uri->segment(6));

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
            $data['cetak']          = $this->model_nasabah->data_cetak_sp4($account_financing_reg_id);
            $data['nama_pasangan']  = $nama_pasangan;
            $data['status_pasangan']= $status_pasangan;
            
            $pejabatakad = $this->model_laporan_to_pdf->get_pejabatakad($data['cetak']['product_code']); // pejabat yg menandatangani akad lookup ke list_code_detail
            foreach($pejabatakad as $pa) {
                $data[$pa['code_value']] = $pa['display_text'];
            }

            $data['seri_surat'] = $this->model_laporan_to_pdf->get_seri_akad_pembiayaan();

            $this->load->view('laporan/export_cetak_sp4',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5,15,5,18));
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('cetak_sp4'.date('dmy').'_'.$data['cetak']['registration_no'].'.pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }

    }
    /*
    **End Cetak SP4
    */

    /*
    ** Preview TWP 27-07-2015
    */
    public function preview_penarikan_twp()
    {

        $trx_id  = $this->uri->segment(3);

            ob_start();
            
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            
            $data['result']          = $this->model_laporan_to_pdf->preview_penarikan_twp($trx_id);

            $this->load->view('laporan/preview_penarikan_twp',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5,15,5,18));
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('preview_penarikan_twp_'.date('dmy').'.pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }

    }
    /*
    **End Preview TWP
    */

    public function export_rekap_pengajuan_pembiayaan_melalui()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan_melalui($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pengajuan_by_melalui',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pengajuan_by_status"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }  

    public function export_rekap_pencairan_pembiayaan_melalui()
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
        
                $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_melalui($cabang,$tanggal1_,$tanggal2_);
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result']= $datas;
            if ($cabang !='00000') 
            {
                $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } 
            else 
            {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_melalui',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_peruntukan"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_melalui',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
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
            } else if($cabang=='0000') 
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_produk',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
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
            } else if($cabang=='0000') 
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
                //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();

            
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            
            $data['result']= $datas;
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

            if ($cabang !='00000'){
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if($branch['branch_class']=="1"){
                    $data['cabang'] .= " (Perwakilan)";
                }
            }else{
                $data['cabang'] = "PUSAT (Gabungan)";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_akad',$data);

            $content = ob_get_clean();

            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_petugas"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }


}