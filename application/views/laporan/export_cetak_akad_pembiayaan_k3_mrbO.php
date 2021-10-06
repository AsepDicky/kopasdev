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
   return "seratus".Terbilang($satuan - 100);  
  elseif ($satuan < 1000)  
   return Terbilang($satuan / 100)." ratus".  
   Terbilang($satuan % 100);  
  elseif ($satuan < 2000)  
   return "seribu".Terbilang($satuan - 1000);   
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
  $angsuran_pokok = (isset($cetak['angsuran_pokok'])) ? $cetak['angsuran_pokok'] : "0" ;
  $angsuran_margin = (isset($cetak['angsuran_margin'])) ? $cetak['angsuran_margin'] : "0" ;
  $angsuran_catab = (isset($cetak['angsuran_catab'])) ? $cetak['angsuran_catab'] : "0" ;
  $uang_muka = (isset($cetak['uang_muka'])) ? $cetak['uang_muka'] : "0" ;
  $biaya_administrasi = (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : 0 ;
  $biaya_administrasi += (isset($cetak['biaya_jasa_layanan'])) ? $cetak['biaya_jasa_layanan'] : 0 ;
  $biaya_administrasi += (isset($cetak['simpanan_wajib_pinjam'])) ? $cetak['simpanan_wajib_pinjam'] : 0 ;
  $piutangmurobahah = $totalhutang+$uang_muka;
  $Nominalbiaya_administrasi = (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : "0" ;
  $Nominalbiaya_jasa_layanan = (isset($cetak['biaya_jasa_layanan'])) ? $cetak['biaya_jasa_layanan'] : "0" ;
  $Nominalsimpanan_wajib_pinjam = (isset($cetak['simpanan_wajib_pinjam'])) ? $cetak['simpanan_wajib_pinjam'] : "0" ;

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

<div style="margin-left:70px;width:610px;">
  <div align="center" style="font-size:14px;font-style:italic;width:610px;">Bismillahirrahmanirrahim</div>
  <br>
  <br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;">
    AKAD PEMBIAYAAN MURABAHAH<br>
    ANTARA<br>
    <?php echo $institution['institution_name'];?><br>
    DAN <br>
    <?php echo $cetak['nama'];?><br>
    Nomor : &nbsp; <span style="font-weight:normal;"><?php echo $cetak['account_financing_no'];?>/Pby-Mrb/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?></span>
  </div>
  <br><br>
  <div style="font-size:13px;line-height:20px;width:610px;">
    <div style="text-align:justifywidth:610px;margin-bottom:10px;">
      Pada hari ini <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))]; ?> tanggal <?php echo (int)date('d',strtotime($cetak['tanggal_akad'])); ?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo date('Y',strtotime($cetak['tanggal_akad'])) ?> (<?php echo date("d/m/Y", strtotime($cetak['tanggal_akad']));?>),  kami yang bertanda tangan dibawah ini :
    </div>
    <table cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td width="20">1.</td>
          <td width="580">
            <?php echo $institution['institution_name'];?> berkantor pusat di <?php echo $institution['alamat'];?> dalam hal ini melalui :
            <table cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Kantor Cabang Syariah</strong></div></td>
                  <td width="380"><div style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $data_cabang['branch_name'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Alamat</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;Jl. Dermodjojo No.34 Nganjuk 64418<?php echo $institution['alamat'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Diwakili Oleh</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $data_cabang['branch_officer_name']; ?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Dalam kapasitasnya selaku</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $data_cabang['nama_jabatan'];?></div></td>
                </tr>
              </tbody>
            </table>
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              Berdasarkan Surat Keputusan/Surat Kuasa Pengurus Nomor ............ Tanggal ............ dalam hal ini bertindak untuk dan atas nama <?php echo $institution['institution_name'];?> selaku pemberi pembiayaan ............ Selanjutnya disebut KOPERASI ;
            </div>
          </td>
        </tr>
        <tr>
          <td width="20"><div style="padding-top:6px">2.</div></td>
          <td width="580">
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              <?php echo $cetak['nama'];?> pekerjaan <?php echo $cetak['pekerjaan'];?> usia <?php echo $cetak['usia'];?> tahun, bertempat tinggal di <?php echo $cetak['alamat'];?>, Rt/rw  <?php echo $cetak['rt_rw'];?>, Desa  <?php echo $cetak['desa'];?>, Kecamatan  <?php echo $cetak['kecamatan'];?>, Kabupaten  <?php echo $cetak['kabupaten'].' - '.$cetak['kodepos'];?> berdasarkan Kartu Tanda Penduduk (KTP) nomor <?php echo $cetak['no_ktp'];?> <!-- yang berlaku sampai tanggal <?php echo $cetak['masa_berlaku_ktp'];?> --> dalam hal ini bertindak untuk dan atas namanya sendiri, selanjutnya disebut <?php echo $status_anggota; ?> ;
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      KOPERASI dan <?php echo $status_anggota; ?> telah bersepakat melakukan transaksi seperti yang diuraikan dalam pasal-pasal berikat ini :
    </div>
  </div>
  
  <table cellspacing="0" cellpadding="0" style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI akan membayarkan sejumlah dana atas pembelian barang pada PIHAK KETIGA dan atau menguasakan pada <?php echo $status_anggota; ?> untuk membeli sendiri dengan menyerahkan uang tunai sebesar Rp <?php echo number_format($pokok,2,",",".").' ('.Terbilang($pokok).')'; ?> untuk Pembiayaan Kepemilikan Barang <?php echo $cetak['description'];?> 
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">2.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI kemudian menjual barang yang dibeli kepada <?php echo $status_anggota; ?> dengan margin bagi KOPERASI sebesar Rp <?php echo number_format($margin,2,",",".").' ('.Terbilang($margin).')';?>, sehingga nilai jual seluruhnya / total hutang <?php echo $status_anggota; ?> sebesar Rp. <?php echo number_format($totalhutang,2,",",".").' ('.Terbilang($totalhutang).')';?>. 
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          <?php echo $status_anggota; ?> sanggup membayar hingga lunas hutang tersebut kepada KOPERASI dengan mengangsur selama <?php echo $cetak['jangka_waktu'].' '.$periode_jangka_waktu;?> sebesar <?php echo number_format($totalangsuran,2,",",".").' ('.Terbilang($totalangsuran).')';?> per<?php echo $periode_jangka_waktu;?> mulai tanggal <?php echo date("d-m-Y",strtotime($cetak['tanggal_mulai_angsur']));?> dengan rincian sebagai berikut : 
          <table>
            <tr>
              <td>a. Angsuran pokok sebesar </td>
              <td>: Rp. <?php echo number_format($angsuran_pokok,2,",",".");?></td>
            </tr>
            <tr>
              <td>b. Angsuran margin sebesar</td>
              <td>: Rp. <?php echo number_format($angsuran_margin,2,",",".");?></td>
            </tr>
            <tr>
              <td>c. Angsuran cadangan tabungan</td>
              <td>: Rp. <?php echo number_format($angsuran_catab,2,",",".");?></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">4.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Terhadap fasilitas pembiayaan ini, <?php echo $status_anggota; ?> bersedia menyerahkan uang sejumlah Rp. <?php echo number_format($biaya_administrasi,2,",",".").' ('.Terbilang($biaya_administrasi).')';?> untuk pembayaran :
          <table>
            <tr>
              <td>a. Biaya administrasi </td>
              <td>: Rp. <?php echo number_format($Nominalbiaya_administrasi,2,",",".");?></td>
            </tr>
            <tr>
              <td>b. Biaya Jasa Layanan </td>
              <td>: Rp. <?php echo number_format($Nominalbiaya_jasa_layanan,2,",",".");?></td>
            </tr>
            <tr>
              <td>c. Simpanan Wajib Pinjam </td>
              <td>: Rp. <?php echo number_format($Nominalsimpanan_wajib_pinjam,2,",",".");?></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">5.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Jika di kemudian hari terjadi perselisihan diantara kedua belah pihak, maka akan diselesaikan dengan cara musyawarah mufakat yang dilandasi Ukhuwah Islamiyah.
        </div>
      </td>
    </tr>
  </table>

  <br>
  <br>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:30px;width:610px;">
    Demikian perjanjian dan pernyataan kesanggupan ini dibuat dan ditandatangani oleh kedua belah pihak, dan oleh karenanya mengikat untuk dijalankan sebagaimana mestinya dan menjadi bahan pembuktian yang sah bagi para pihak.
  </div>
  <div style="width:610px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td width="180" align="center"><?php echo $status_anggota; ?></td>
        <td width="140">&nbsp;</td>
        <td width="280" align="center"><?php echo $institution['institution_name'];?><br>KANTOR CABANG SYARIAH <?php echo $data_cabang['branch_name'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><?php echo $cetak['nama'];?></td>
        <td>&nbsp;</td>
        <td align="center"><?php echo $data_cabang['branch_officer_name'];?></td>
      </tr>
    </table>
  </div>
  <div style="width:610px;margin-top:30px;font-size:13px;">
    <div align="center">Menyetujui</div>
    <table>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center" width="610">( &nbsp; <?php echo $menyetujui; ?> &nbsp; )</td>
      </tr>
    </table>
  </div>
  <div style="width:610px;margin-top:30px;font-size:13px;">
  <div align="center">SAKSI-SAKSI</div>
    <table>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center" width="305">( &nbsp; <?php echo $saksi1;?> &nbsp; )</td>
        <td align="center" width="305">( &nbsp; <?php echo $saksi2;?> &nbsp; )</td>
      </tr>
    </table>
  </div>
</div>