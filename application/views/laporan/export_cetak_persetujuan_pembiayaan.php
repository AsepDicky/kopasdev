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
  <div align="center" style="font-size:13px;font-style:italic;width:610px;">Bismillahirrahmanirrahim</div>
  <br>
  <br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;">
    SURAT PEMBERITAHUAN PERSETUJUAN PEMBIAYAAN<br>
    <span style="font-weight:normal;">Nomor : &nbsp; <?php echo $cetak['account_financing_no'];?>/SP3/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?></span>
    <br><span style="font-weight:normal;">Nomor Penyimpanan Obyek Jaminan : &nbsp; <?php echo $cetak['account_financing_no'];?><?php echo date("Ymd",strtotime($cetak['tanggal_akad']));?></span>
  </div>
  <br><br>
  <div align="center" style="font-size:12px;font-style:italic;width:610px;">“Hai orang-orang yang beriman, penuhilah akad-akad (perjanjian) itu” <span style="font-style:normal;font-weight:blod;">(QS. Al-Maidah : 1)</span></div>
  <div align="center" style="font-size:12px;font-style:italic;width:610px;">“Cukupkanlah takaran jangan kamu menjadi orang-orang yang merugi” <span style="font-style:normal;font-weight:blod;">(QS. Asy – Syu’ara’ : 181)</span></div>
  <br><br>
  <div style="font-size:13px;line-height:20px;width:610px;">
    <div style="text-align:justifywidth:610px;margin-bottom:10px;">
      Yang bertanda tangan dibawah ini :
    </div>
    <table cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td width="20">1.</td>
          <td width="580">
            <table cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Nama</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $institution['officer_name'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Jabatan</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $institution['officer_title'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Alamat</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $institution['alamat'];?></div></td>
                </tr>
              </tbody>
            </table>
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              Bertindak untuk dan atas nama <?php echo $institution['institution_name'];?>  Selanjutnya disebut <b>Pihak I</b> 
            </div>
          </td>
        </tr>
        <tr>
          <td width="20"><div style="padding-top:6px">2.</div></td>
          <td width="580">
            <table cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Nama</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $cetak['nama'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Tempat/Tgl. Lahir</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $cetak['tmp_lahir'];?> / <?php echo date("d-m-Y",strtotime($cetak['tgl_lahir']));?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Alamat</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php echo $cetak['alamat'];?></div></td>
                </tr>
              </tbody>
            </table>
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              Dalam Perbuatan hukum dibantu oleh Suami/Istri 
            </div>
          </td>
        </tr>
        <tr>
          <td width="20"></td>
          <td width="580">
            <table cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Nama</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php if(isset($cetak['nama_pasangan']))echo $cetak['nama_pasangan'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Alamat</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;<?php if(isset($cetak['nama_pasangan']))echo $cetak['alamat'];?></div></td>
                </tr>
              </tbody>
            </table>
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              Selanjutnya disebut <b>Pihak II</b> 
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    
    <div style="text-align:justify;padding:10px 0px;margin-top:15px;width:610px;">Kedua belah pihak sepakat untuk mengadakan persetujuan pembiayaan dengan ketentuan dan syarat sebagai berikut :</div>
    
  </div>
  

  <!-- PASAL 1 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;margin-top:;30px">
    PASAL 1<br>
  </div>
  
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px">
    Pihak I telah memberikan pembiayaan kepada Pihak II , untuk pembiayaan MD /BBA /MBA /QH kedua belah pihak telah sepakat bahwa :
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Besar Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($totalhutang,2,",",".").' ('.Terbilang($totalhutang).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">2.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jangka Waktu Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $cetak['jangka_waktu'].' '.$periode_jangka_waktu;?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Cara Setor
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $periode_jangka_waktu;?>an
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">4.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Tanggal Setor
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php $echo = ($cetak['periode_jangka_waktu']==2)? ' Setiap tanggal '.date("d",strtotime($cetak['tanggal_mulai_angsur'])).' per bulan' :  '-' ; echo $echo;?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">5.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Tanggal Jatuh Tempo
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo date("d-m-Y",strtotime($cetak['tanggal_jtempo']));?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">6.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Total Mark Up
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($margin,2,",",".").' ('.Terbilang($margin).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">7.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Setoran Cadangan Resiko
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($cadangan_resiko,2,",",".").' ('.Terbilang($cadangan_resiko).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">8.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Besar angsuran  pokok
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($angsuran_pokok,2,",",".").' ('.Terbilang($angsuran_pokok).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">9.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Besar Bagi Hasil / Margin / Ujroh
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($angsuran_margin,2,",",".").' ('.Terbilang($angsuran_margin).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">10.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Total Setoran
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($totalangsuran,2,",",".").' ('.Terbilang($totalangsuran).')';?> per<?php echo $periode_jangka_waktu;?>
        </div>
      </td>
    </tr>
  </table>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px">
    Jangka waktu pembayaran bisa berubah manakala dianggap perlu Pihak I atas permohonan Pihak II
  </div>
  <!-- PASAL 2 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 2<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">Pihak II setuju/sepakat untuk membayar seluruh biaya yang timbul karena persetujuan ini, meliputi :</div>
  <table>
    <tr>
      <td width="250">
        <div style="padding-top:6px;">
          Biaya Administrasi
        </div>
      </td>
      <td width="305">
        <div style="padding-top:6px;">
          : Rp. <?php echo number_format($biaya_administrasi,2,",",".");?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="250">
        <div style="padding-top:6px;">
          simpanan wajib Pinjam
        </div>
      </td>
      <td width="305">
        <div style="padding-top:6px;">
          : Rp. <?php echo number_format($simpanan_wajib_pinjam,2,",",".");?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="250">
        <div style="padding-top:6px;">
          Biaya Jasa Layanan
        </div>
      </td>
      <td width="305">
        <div style="padding-top:6px;">
          : Rp. <?php echo number_format($biaya_jasa_layanan,2,",",".");?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="250">
        <div style="padding-top:6px;" align="center">
          Jumlah Total
        </div>
      </td>
      <td width="305">
        <div style="padding-top:6px;">
          : Rp. <?php echo number_format($biaya_administrasi+$simpanan_wajib_pinjam+$biaya_jasa_layanan,2,",",".");?>
        </div>
      </td>
    </tr>
  </table>
  <!-- PASAL 3 -->
  <br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 3<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">Dalam rangka pengawasan dan pembinaan, maka Pihak II bersedia untuk setiap waktu diperlukan Pihak I memberikan keterangan tentang perkembangan usaha yang di biayai pihak I</div>
  
  <!-- PASAL 4 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 4<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">Untuk menjamin keamanan pembiayaan maka</div>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Selama Pihak II belum melakukan pelunasan pembiayaan kepada Pihak I, maka
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td width="20"><div style="padding-top:6px">a.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                Seluruh barang dagang yang di biayai merupakan hak milik Pihak I secara bersama-sama dengan pihak II
              </div>
            </td>
          </tr>
          <tr>
            <td width="20"><div style="padding-top:6px">b.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                Barang yang dibeli sebagian atau seluruhnya dari harga pembelian atas pembiayaan Pihak I merupakan hak Pihak I secara bbersama-sama dengan Pihak II
              </div>
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">2.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        pihak kedua bersedia menyerahkan jaminan berupa <?php echo $cetak['keterangan_jaminan'];?>
      </div>
    </td>
  </tr>
</table>
<br>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:30px;width:610px;">
    Demikian persetujuan ini disepakati dan ditanda tangani oleh kedua belah pihak pada hari / tanggal
  </div>
  <div style="width:610px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td width="180" align="center">Pihak II/Debitur</td>
        <td width="140">&nbsp;</td>
        <td width="280" align="center">Pihak I/Kreditur</td>
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

  </div>
</div>