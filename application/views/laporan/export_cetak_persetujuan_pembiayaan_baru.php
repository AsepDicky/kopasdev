<?php 
  $CI = get_instance();

  function Terbilang($satuan){  
  $huruf = array ("", "satu", "dua", "tiga", "empat", "lima", "enam",   
  "tujuh", "delapan", "sembilan", "sepuluh","sebelas");  
  if ($satuan < 12)  
   return " ".$huruf[$satuan];  
  elseif ($satuan < 20)  
   return Terbilang($satuan - 10)." belas";  
  elseif ($satuan < 100)  
   return Terbilang($satuan / 10)." puluh".  
   Terbilang($satuan % 10);  
  elseif ($satuan < 200)  
   return " seratus".Terbilang($satuan - 100);  
  elseif ($satuan < 1000)  
   return Terbilang($satuan / 100)." ratus".  
   Terbilang($satuan % 100);  
  elseif ($satuan < 2000)  
   return " seribu".Terbilang($satuan - 1000);   
  elseif ($satuan < 1000000)  
   return Terbilang($satuan / 1000)." ribu".  
   Terbilang($satuan % 1000);   
  elseif ($satuan < 1000000000)  
   return Terbilang($satuan / 1000000)." juta".  
   Terbilang($satuan % 1000000);   
  elseif ($satuan >= 1000000000)  
   return "Angka terlalu Besar";  

  if($satuan==0){
    return "nol";
  }
  }  

  $totalhutang = (isset($cetak['pokok']) && isset($cetak['margin'])) ? $cetak['pokok']+$cetak['margin'] : "0" ;
  $pokok = (isset($cetak['pokok'])) ? $cetak['pokok'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;
  $totalangsuran = (isset($cetak['angsuran_pokok']) && isset($cetak['angsuran_margin']) && isset($cetak['angsuran_catab'])) ? $cetak['angsuran_pokok']+$cetak['angsuran_margin']+$cetak['angsuran_catab'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;
  $uang_muka = (isset($cetak['uang_muka'])) ? $cetak['uang_muka'] : "0" ;
  $biaya_administrasi = (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : 0 ;
  $biaya_administrasi += (isset($cetak['biaya_jasa_layanan'])) ? $cetak['biaya_jasa_layanan'] : 0 ;
  $biaya_administrasi += (isset($cetak['simpanan_wajib_pinjam'])) ? $cetak['simpanan_wajib_pinjam'] : 0 ;
  $piutangmurobahah = $totalhutang+$uang_muka;
  $cadangan_resiko = (isset($cetak['cadangan_resiko'])) ? $cetak['cadangan_resiko'] : "0" ;
  $angsuran_pokok = (isset($cetak['angsuran_pokok'])) ? $cetak['angsuran_pokok'] : "0" ;
  $angsuran_margin = (isset($cetak['angsuran_margin'])) ? $cetak['angsuran_margin'] : "0" ;
  $biaya_administrasi = (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : "0" ;
  $biaya_jasa_layanan = (isset($cetak['biaya_jasa_layanan'])) ? $cetak['biaya_jasa_layanan'] : "0" ;
  $simpanan_wajib_pinjam = (isset($cetak['simpanan_wajib_pinjam'])) ? $cetak['simpanan_wajib_pinjam'] : "0" ;

  if ($cetak['periode_jangka_waktu']==0) {
    $periode_jangka_waktu = "Hari";
  } 
  else if ($cetak['periode_jangka_waktu']==1) {
    $periode_jangka_waktu = "Minggu";
  }
  else if ($cetak['periode_jangka_waktu']==2) {
    $periode_jangka_waktu = "Bulan";
  }
  else{
    $periode_jangka_waktu = "Jatuh Tempo";
  }
  
  // echo date('a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z');
  $array_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
  $array_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

?> 

<div style="margin-left:70px;width:600px;">
  <br><br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;">
    BISMILLAHIRRAHMANIRRAHIM<br/>
    SURAT PENEGASAN PERSETUJUAN<br/>
    PENYEDIAAN PEMBIAYAAN <br/>(SP4)<br>
  </div><br/><br/><br/>
  <div style="font-size:13px;line-height:20px;width:610px;">
    Nomor : &nbsp; <?php echo $cetak['account_financing_no'];?>/SP3/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?>
  </div>
  <br/><br/>
  <div style="font-weight:bold;font-size:13px;line-height:20px;width:610px;">
    Kepada Yth, <br/>
    Sdr. EKA YULISRI<br/>
    NIK 730492<br/>
    Karyawan PT. TELKOM<br/>
    QUALITY & CHANGE MANAGEMENT (CTR-HCC) <br/>
  </div>
  <br><br>
  <div style="font-size:13px;line-height:20px;width:610px;">
    <div style="text-align:justifywidth:610px;margin-bottom:10px;">
      Assalamualaikum, Wr.Wb.<br/>
      Dengan Hormat,
    </div>
    <div style="text-align:justify;padding:10px 0px;margin-top:15px;width:610px;">
      Dengan ini diberitahukan, bahwa berdasarkan permohonan pembiayaan yang sudah ajukan, Koperasi PT. Telekomunikasi Indonesia (KOPTEL) 
      dapat menyetujui untuk menyediakan fasilitas Pembiayaan dengan ketentuan dan syarat sebagai berikut :
      <br/><br/>
      <table cellspacing="10">
        <tr>
          <td width="200">1 Jenis Pembiayaan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">2 Jumlah Pembiayaan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">3 Margin</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">4 Total Margin</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">5 Jumlah Pengembalian</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">6 Tujuan Pembiayaan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">7 Angsuran Per Bulan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">8 Jangka Waktu Pembiayaan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">9 Jaminan Pembiayaan</td>
          <td>:</td>
          <td></td>
        </tr>
        <tr>
          <td width="200">10 Ketentuan dan syarat lainnya</td>
          <td>:</td>
          <td></td>
        </tr>
      </table>
      <div style="margin-left:20px;">
        <table>
          <tr>
            <td width="20">a</td>
            <td>Pemohon telah membayar jumlah biaya tersebut di bawah ini :</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td>
            <table>
              <tr>
                <td width="20">1)</td>
                <td width="300">biaya Asuransi Jiwa Pembiayaan sebesar</td>
                <td>:</td>
                <td><b>Rp. </b></td>
              </tr>
              <tr>
                <td width="20">2)</td>
                <td width="300">Provinsi Pembiayaan 1,0% dari Rp. </td>
                <td>:</td>
                <td><b>Rp. </b></td>
              </tr>
              <tr>
                <td width="20">3)</td>
                <td width="300">Angsuran Bulan Pertama sebesar</td>
                <td>:</td>
                <td><b>Rp. </b></td>
              </tr>
              <tr>
                <td width="20">4)</td>
                <td width="300">Biaya Notaris</td>
                <td>:</td>
                <td><b>Rp. </b></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><b>JUMLAH</b></td>
                <td>:</td>
                <td><b>Rp. </b></td>
              </tr>
              <tr>
                <td colspan="4">Jumlah biaya tersebut di atas supaya dibayar secara cash melalui Bendahara KOPTEL</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="20">b</td>
            <td> 
              <div style="width:600px;">
                Pemohon telah bersedia untuk menggunakan fasilitas Pembiayaan yang disediakan oleh KOPTEL, setelah Pemohon
                menyetujui Perjanjian yang dituangkan dalam Perjanjian Pembiayaan terlampir yang akan ditandatangani oleh Pemohon 
                dan Pengurus KOPTEL, dibuat dalam rangkap 2 (dua) asli masing-masing di atas materai Rp. 6.000,00 dan akan disahkan oleh Notaris
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<div style="margin-left:90px;width:450px;">
  <div style="font-size:13px;line-height:20px;width:450px;">
    <div style="text-align:justify;width:450px;margin-bottom:10px;">
      11 Sehubungan dengan hal tersebut di atas, apabila Saudara menyetujui ketentuan dan syarat penyediaan fasilitas Pembiayaan 
      menurut SP4 ini, kami harapkan agar Saudara dapat mengisi dan menandatangani Surat Pernyataan terlampir dengan benar 
      di atas materai Rp. 6.000,- kemudian mengirimkannya kepada kami dengan dilampiri :
      <br/>
      <table>
        <tr>
          <td width="10">a</td>
          <td>Bukti Setor sebagaimana dimaksud butir 10 a</td>
        </tr>
        <tr>
          <td width="10">b</td>
          <td>Perjanjian Pembiayaan yang telah Saudara tanda tangani sebagaiman dimaksud butir 10 b</td>
        </tr>
        <tr>
          <td colspan="2">
            <br/>
            Selambat-lambatnya 1 (satu) bulan sejak diterbitkan SP4 ini, sebagai tanda persetujuan atas segala ketentuan <br/> dan syarat tersebut di atas
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div style="margin-left:90px;width:600px;">
  <div style="font-size:13px;line-height:20px;width:600px;">
    <div style="text-align:justify;width:610px;margin-bottom:10px;">
      12 Sehubungan dengan hal tersebut di atas, apabila Saudara menyetujui ketentuan dan syarat penyediaan fasilitas Pembiayaan 
      menurut SP4 ini, kami harapkan agar Saudara dapat mengisi dan menandatangani Surat Pernyataan terlampir dengan benar 
      di atas materai Rp. 6.000,- kemudian mengirimkannya kepada kami dengan dilampiri :
      <br/><br/>
    </div>
  </div>
</div>