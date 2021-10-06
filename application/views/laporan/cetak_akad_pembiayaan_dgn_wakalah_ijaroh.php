<?php
        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header('Content-disposition: attachment; filename=akad_'.$cetak['nama'].'.doc');
?>
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
  $uang_muka = (isset($cetak['uang_muka'])) ? $cetak['uang_muka'] : "0" ;
  $biaya_administrasi = (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : 0 ;
  $biaya_administrasi += (isset($cetak['biaya_jasa_layanan'])) ? $cetak['biaya_jasa_layanan'] : 0 ;
  $biaya_administrasi += (isset($cetak['simpanan_wajib_pinjam'])) ? $cetak['simpanan_wajib_pinjam'] : 0 ;
  $piutangmurobahah = $totalhutang+$uang_muka;

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

<div style="margin-left:30px;width:610px;">
  <div align="center" style="font-size:14px;font-style:italic;width:610px;">Bismillahirrahmanirrahim</div>
  <br>
  <br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;">
    AKAD PEMBIAYAAN IJARAH<br>
    ANTARA<br>
    <?php echo $institution['institution_name'];?><br>
    DAN <br>
    <?php echo $cetak['nama'];?><br>
    Nomor : &nbsp; <span style="font-weight:normal;"><?php echo $cetak['account_financing_no'];?>/Pby-Ijr/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?></span>
  </div>
  <br><br>
  <div style="line-height:20px;width:610px;">
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
              Berdasarkan Surat Keputusan/Surat Kuasa Pengurus Nomor ... Tanggal ... dalam hal ini bertindak untuk dan atas nama <?php echo $institution['institution_name'];?> selaku pemberi pembiayaan ... Selanjutnya disebut KOPERASI ;
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
    
    <div style="text-align:justify;padding:10px 0px;margin-top:15px;width:610px;">Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:</div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa <?php echo $status_anggota; ?> telah mengajukan pembiayaan Ijarah sebagaimana tertuang dalam Surat Permohonan Pembiayaan tanggal <?php echo date("d-m-Y",strtotime($cetak['tanggal_pengajuan']));?> untuk mengambil manfaat objek jarah milik KOPERASI berupa: "<?php echo $cetak['description'];?>"
    </div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa KOPERASI telah menyatakan persetujuannya untuk memberikan Pembiayaan Ijarah kepada <?php echo $status_anggota; ?> melalui Surat Pemberitahuan Persetujuan Pembiayaan (SP3) nomor <?php echo $cetak['account_financing_no'];?>/SP3/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?> yang merupakan bagian dan satu kesatuan dengan akad ini.
    </div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa selanjutnya KOPERASI dan <?php echo $status_anggota; ?> dengan ini telah setuju dan sepakat untuk mengadakan Akad Pembiayaan Ijarah (selanjutnya disebut “Akad”) berdasarkan ketentuan-ketentuan sebagai berikut:
    </div>
  </div>
  

  <!-- PASAL 1 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;margin-top:;30px">
    PASAL 1<br>
    KETENTUAN POKOK AKAD<br>
  </div>
  
  <div style="text-align:justify;line-height:20px;margin-top:10px;width:610px">
    Ketentuan-ketentuan pokok Akad ini meliputi sebagai berikut:
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">a.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Objek Ijarah/Ijarah Multijasa
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($pokok,2,",",".").' ('.Terbilang($pokok).')'; ?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">b.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Harga Sewa (Ujrah)
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
      <td width="20"><div style="padding-top:6px">c.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Angsuran
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($totalangsuran,2,",",".").' ('.Terbilang($totalangsuran).')';?> per<?php echo $periode_jangka_waktu;?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">d.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Biaya Administrasi
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($biaya_administrasi,2,",",".").' ('.Terbilang($biaya_administrasi).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">e.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Denda Tunggakan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. -
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">f.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Tujuan Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $cetak['display_text'];?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">g.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jangka Waktu Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $cetak['jangka_waktu'].' '.$periode_jangka_waktu;?>, terhitung sejak tanggal <?php echo date("d/m/Y", strtotime($cetak['tanggal_akad']));?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">h.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jatuh Tempo Pembiayaan
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
      <td width="20"><div style="padding-top:6px">i.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Cara Pembayaran Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Sekaligus atau Angsuran Rp. <?php echo number_format($totalangsuran,2,",",".").' ('.Terbilang($totalangsuran).')';?> per<?php echo $periode_jangka_waktu;?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">k.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jatuh Tempo Angsuran
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
      <td width="20"><div style="padding-top:6px">n.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Ganti Rugi (Ta'Widh)
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp.......... per hari/bulan*).
        </div>
      </td>
    </tr>
  </table>
  
  <!-- PASAL 2 -->
  <div style="margin-left:30px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 2<br>
    PELAKSANAAN PRINSIP IJARAH<br>
  </div>
  
  <div style="text-align:justify;line-height:20px;margin-top:10px;width:610px;">
    Pelaksanaan prinsip Ijarah yang berlangsung antara KOPERASI dengan <?php echo $status_anggota; ?> dilaksanakan berdasarkan ketentuan Syariah dan diatur menurut ketentuan- ketentuan dan persyaratan sebagai berikut: 
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          <?php echo $status_anggota; ?> membutuhkan Objek Ijarah untuk disewa dan meminta kepada KOPERASI untuk menyediakan Pembiayaan Ijarah guna menyewa manfaat dari Objek Ijarah.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">2.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI bersedia menyediakan Pembiayaan Ijarah sesuai dengan permohonan <?php echo $status_anggota; ?> 
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          <?php echo $status_anggota; ?>  bersedia membayar harga sewa sesuai Akad ini, dan harga sewa tidak dapat berubah selama berlakunya Akad ini.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI dapat mewakilkan secara penuh dan/atau memberikan kuasa kepada <?php echo $status_anggota; ?> untuk menandatangani Akad sewa-menyewa atas namanya sendiri langsung dengan pemilik Objek Ijarah dan memperoleh manfaat dari penggunaan Objek Ijarah yang disewa (Ijarah) tersebut dengan Akad Wakalah yang merupakan satu kesatuan yang tidak dapat dipisahkan dari Akad ini. 
        </div>
      </td>
    </tr>
  </table>

  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 3<br>
    SYARAT REALISASI PEMBIAYAAN<br>
  </div>
  
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI akan merealisasikan Pembiayaan berdasarkan prinsip Ijarah berdasarkan Akad ini, setelah <?php echo $status_anggota; ?> terlebih dahulu memenuhi seluruh persyaratan sebagai berikut:
          <table cellspacing="0" cellpadding="0">
            <tr>
              <td width="20"><div style="padding-top:6px">a.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Menyerahkan kepada KOPERASI seluruh dokumen yang disyaratkan oleh KOPERASI termasuk tetapi tidak terbatas pada dokumen bukti diri <?php echo $status_anggota; ?>, dokumen kepemilikan Jaminan dan/atau surat lainnya yang berkaitan dengan Akad ini dan pengikatan Jaminan, yang ditentukan dalam Surat Pemberitahuan Persetujuan Pembiayaan (SP3) dari KOPERASI.
                </div>
              </td>
            </tr>
            <tr>
              <td width="20"><div style="padding-top:6px">b.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  <?php echo $status_anggota; ?> wajib membuka dan memelihara rekening tabungan pada KOPERASI selama <?php echo $status_anggota; ?> mendapatkan Pembiayaan dari KOPERASI.
                </div>
              </td>
            </tr>
            <tr>
              <td width="20"><div style="padding-top:6px">c.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Menandatangani Akad ini dan perjanjian pengikatan Jaminan yang disyaratkan oleh KOPERASI. 
                </div>
              </td>
            </tr>
            <tr>
              <td width="20"><div style="padding-top:6px">d.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Menyetorkan uang muka sewa dan/atau biaya-biaya yang disyaratkan oleh KOPERASI sebagaimana yang tercantum dalam SP3.
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
          Realisasi pembayaran harga sewa kepada pemilik Objek Ijarah akan dilakukan oleh KOPERASI kepada Pemilik Objek Ijarah, baik secara langsung maupun melalui rekening <?php echo $status_anggota; ?>.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Sejak ditandatanganinya Akad ini dan <?php echo $status_anggota; ?> telah memperoleh manfaat dari penggunaan Objek Ijarah yang disewa, maka risiko atas Objek Ijarah tersebut sepenuhnya menjadi tanggung jawab <?php echo $status_anggota; ?> dan dengan ini <?php echo $status_anggota; ?> membebaskan KOPERASI dari segala tuntutan dan/atau ganti rugi berupa apapun atas risiko tersebut.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">5.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Dalam hal KOPERASI telah membayar kepada Pemilik Objek Ijarah maka <?php echo $status_anggota; ?> dengan ini menyatakan dan mengakui mempunyai kewajiban/Utang Ijarah berdasarkan Akad ini.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">4.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Apabila KOPERASI telah membayar kepada Pemilik Objek Ijarah termasuk pembayaran uang muka, maka <?php echo $status_anggota; ?> tidak dapat membatalkan secara sepihak Akad ini.
        </div>
      </td>
    </tr>
  </table>
<br>
<br>
<br>
  
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 4 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 4<br>
    JATUH TEMPO PEMBIAYAAN<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">Berakhirnya jatuh tempo Pembiayaan tidak dengan sendirinya menyebabkan Utang Ijarah lunas sepanjang masih terdapat sisa Utang Ijarah <?php echo $status_anggota; ?>.</div>
</div>
<br>

<div style="margin-left:10px;width:610px;">
  <!-- PASAL 5 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 5<br>
    PEMBAYARAN KEMBALI PEMBIAYAAN<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    <?php echo $status_anggota; ?> wajib melakukan pembayaran kembali Pembiayaan sampai dengan seluruh Utang Ijarah  <?php echo $status_anggota; ?> lunas sesuai jadwal Angsuran yang disepakati.
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 6 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 6<br>
    GANTI RUGI (TA’WIDH) <br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    Utang Ijarah <?php echo $status_anggota; ?> yang tidak dilunasi selambat-lambatnya pada saat jatuh tempo akan dikenakan Ganti Rugi (Ta’widh) yang besarnya sebagaimana diatur dalam Pasal 1 huruf k.
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 7  -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 7 <br>
    UANG MUKA<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    KOPERASI dapat meminta kepada <?php echo $status_anggota; ?> uang muka (urbun) untuk pembayaran harga sewa Objek Ijarah  pada saat Akad dengan ketentuan Uang muka tersebut menjadi bagian pelunasan Utang Ijarah <?php echo $status_anggota; ?> apabila Pembiayaan Ijarah  dilaksanakan, 
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 8 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 8<br>
    JAMINAN DAN PENGIKATANNYA<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    Guna menjamin pembayaran kembali Utang Ijarah, <?php echo $status_anggota; ?> wajib menyerahkan barang sebagai Jaminan serta menyerahkan Bukti Kepemilikan Jaminan yang asli dan sah  untuk diikat sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, berupa : "<?php if(isset($cetak['keterangan_jaminan']))echo $cetak['keterangan_jaminan']; ?>"
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 9  -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 9 <br>
    ASURANSI <br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    Selama jangka waktu Pembiayaan atau seluruh Utang Ijarah belum dilunasi, <?php echo $status_anggota; ?> wajib menutup asuransi atas barang yang dijaminkan pada perusahaan asuransi berdasarkan Syariah yang disetujui oleh KOPERASI. 
  </div>
</div>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 10<br>
  PEMELIHARAAN OBJEK IJARAH<br>
</div>
<div style="margin-left:10px;text-align:justify;line-height:20px;margin-top:10px;">
  <?php echo $status_anggota; ?> berdasarkan Akad ini wajib:
</div>
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        menjaga keutuhan Objek Ijarah yang disewa serta menggunakannya sesuai dengan Akad sewa menyewa.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">2.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        menanggung biaya pemeliharaan Objek Ijarah.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">3.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        menanggung biaya perbaikan atas kerusakan Objek Ijarah yang disebabkan karena kelalaian <?php echo $status_anggota; ?>.
      </div>
    </td>
  </tr>
</table>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 11  -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 11 <br>
    CIDERA JANJI<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    <?php echo $status_anggota; ?> dinyatakan cidera janji, apabila tidak memenuhi dengan baik kewajiban-kewajibannya atau melanggar ketentuan-ketentuan di dalam Akad ini.
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 12 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 12<br>
    PENGAWASAN, PEMERIKSAAN DAN TINDAKAN TERHADAP BARANG  JAMINAN <br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    Selama <?php echo $status_anggota; ?> belum melunasi seluruh Utang Ijarah  yang timbul dari Akad ini, KOPERASI berhak melakukan pemeriksaan dan meminta keterangan-keterangan yang diperlukan terkait dengan barang Jaminan. 
  </div>
</div>
<br>
<div style="margin-left:10px;width:610px;">
  <!-- PASAL 13 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 13<br>
    PENAGIHAN SEKETIKA SELURUH UTANG IJARAH DAN PENYERAHAN/PENGOSONGAN BARANG JAMINAN<br>
  </div>
  <div style="text-align:justify;line-height:20px;margin-top:10px;">
    Menyimpang dari jangka waktu Pembiayaan, KOPERASI berhak mengakhiri jangka waktu Pembiayaan ini dan menagih pelunasan sekaligus atas seluruh sisa Utang Ijarah dan <?php echo $status_anggota; ?> wajib membayar dengan seketika dan melunasi sekaligus atas sisa Utang Ijarah atau KOPERASI berhak melakukan upaya-upaya hukum lain untuk menyelesaikan Pembiayaan sesuai Akad ini, apabila <?php echo $status_anggota; ?> cidera janji.
  </div>
</div>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 14<br>
  PENGUASAAN DAN PENJUALAN (EKSEKUSI) BARANG JAMINAN.<br>
</div>  
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Apabila <?php echo $status_anggota;?> cidera janji, maka setelah memperingatkan <?php echo $status_anggota; ?>, KOPERASI berhak untuk melakukan tindakan-tindakan sebagai berikut: 
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td width="20"><div style="padding-top:6px">a.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                melaksanakan eksekusi terhadap barang Jaminan berdasarkan ketentuan perundang- undangan yang berlaku.
              </div>
            </td>
          </tr>
          <tr>
            <td width="20"><div style="padding-top:6px">b.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                melaksanakan penjualan terhadap barang Jaminan berdasarkan Surat Kuasa Untuk Menjual yang dibuat oleh <?php echo $status_anggota;?>.
              </div>
            </td>
          </tr>
          <tr>
            <td width="20"><div style="padding-top:6px">c.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                Menetapkan harga penjualan dengan harga yang dianggap wajar oleh KOPERASI.
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
        Hasil eksekusi dan/atau penjualan barang Jaminan tersebut diprioritaskan untuk melunasi seluruh sisa Utang Ijarah <?php echo $status_anggota;?> kepada KOPERASI, termasuk semua biaya yang telah dikeluarkan KOPERASI guna melaksanakan eksekusi barang Jaminan, dan apabila masih ada sisanya maka jumlah sisa tersebut akan dibayarkan kepada <?php echo $status_anggota;?>.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">3.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Apabila dari hasil penjualan atau eksekusi barang Jaminan Pembiayaan jumlahnya belum mencukupi untuk melunasi seluruh Utang Ijarah <?php echo $status_anggota;?> kepada KOPERASI, maka sesuai dengan ketentuan atau peraturan yang berlaku, KOPERASI berhak untuk mengambil pelunasan atas sisa Utang Ijarah tersebut dari penjualan barang- barang lain milik <?php echo $status_anggota;?>.
      </div>
    </td>
  </tr>
</table>
<br>
<br>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 15<br>
  TIMBUL DAN BERAKHIRNYA HAK-HAK DAN KEWAJIBAN<br>
</div>  
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Dalam hal seluruh Utang Ijarah telah dilunasi, KOPERASI wajib menyerahkan kembali semua surat-surat dan/atau dokumen-dokumen mengenai barang Jaminan, serta surat- surat bukti lainnya yang disimpan atau dikuasai KOPERASI kepada:
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td width="20"><div style="padding-top:6px">a.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                <?php echo $status_anggota;?>
              </div>
            </td>
          </tr>
          <tr>
            <td width="20"><div style="padding-top:6px">b.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                Ahli waris <?php echo $status_anggota;?>
              </div>
            </td>
          </tr>
          <tr>
            <td width="20"><div style="padding-top:6px">c.</div></td>
            <td width="550">
              <div style="padding-top:6px;text-align:justify;line-height:20px;">
                Pemenang lelang eksekusi Jaminan; atau
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
        Apabila <?php echo $status_anggota;?> meninggal dunia, hak dan kewajibannya beralih kepada ahli waris dan KOPERASI berhak untuk meminta kepada ahli waris.
      </div>
    </td>
  </tr>
</table>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 16<br>
  FORCE MAJEURE (KEADAAN KAHAR)<br>
</div>
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Dalam hal terjadi Force Majeure, maka pihak yang terkena akibat langsung dari Force Majeure tersebut wajib memberitahukan secara tertulis dengan melampirkan bukti-bukti dari instansi yang berwenang kepada pihak lainnya mengenai peristiwa Force Majeure tersebut dalam waktu selambat-lambatnya 14 (empat belas) hari kerja terhitung sejak tanggal Force Majeure terjadi.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">2.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Keterlambatan atau kelalaian pihak yang mengalami Force Majeure untuk memberitahukan adanya Force Majeure tersebut kepada pihak lainnya mengakibatkan tidak diakuinya peristiwa tersebut sebagai Force Majeure.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">3.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Seluruh permasalahan yang timbul akibat terjadinya Force Majeure akan diselesaikan oleh KOPERASI dan <?php echo $status_anggota;?> secara musyawarah untuk mufakat. Hal tersebut tanpa mengurangi hak-hak KOPERASI sebagaimana diatur dalam Akad ini.
      </div>
    </td>
  </tr>
</table>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 17<br>
  HUKUM YANG BERLAKU<br>
</div>
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Pelaksanaan Akad ini tunduk kepada ketentuan perundang-undangan yang berlaku di Indonesia dan ketentuan Syariah yang berlaku bagi KOPERASI.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">2.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Apabila dikemudian hari terjadi perselisihan dalam penafsiran atau pelaksanaan ketentuan-ketentuan dari Akad, maka para pihak sepakat untuk terlebih dahulu menyelesaikan secara musyawarah.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">3.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Bilamana musyawarah tidak menghasilkan kata sepakat mengenai penyelesaian perselisihan, maka semua sengketa yang timbul dari Akad ini akan diselesaikan dan diputus oleh Badan Arbitrase Syariah Nasional (BASYARNAS) yang keputusannya mengikat kedua belah pihak yang bersengketa, sebagai keputusan tingkat pertama dan terakhir.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">4.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Mengenai pelaksanaan (eksekusi) putusan BASYARNAS, sesuai dengan ketentuan Undang- undang tentang Arbitrase dan Alternatif Penyelesaian Sengketa, PARA PIHAK sepakat bahwa KOPERASI dapat meminta pelaksanaan (eksekusi) putusan BASYARNAS tersebut pada setiap Pengadilan Negeri di wilayah hukum Republik Indonesia.
      </div>
    </td>
  </tr>
</table>
<br>
<div style="margin-left:10px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
  PASAL 18<br>
  PENUTUP<br>
</div>
<table cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
    <td width="20"><div style="padding-top:6px">1.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Segala sesuatu yang belum diatur atau perubahan dalam Akad ini akan diatur dalam surat- menyurat dan/atau addendum berdasarkan kesepakatan bersama antara KOPERASI dan <?php echo $status_anggota;?> yang merupakan bagian yang tidak terpisahkan dari Akad ini.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">2.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Lampiran-lampiran Akad ini (jika ada) merupakan bagian yang tidak terpisahkan dari Akad ini serta wajib dipatuhi oleh <?php echo $status_anggota;?> sebagaimana mestinya.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">3.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Uraian Pasal demi Pasal dalam Akad ini, telah dibaca, dimengerti dan dipahami serta disetujui oleh <?php echo $status_anggota;?> dan KOPERASI.
      </div>
    </td>
  </tr>
  <tr>
    <td width="20"><div style="padding-top:6px">4.</div></td>
    <td width="580">
      <div style="padding-top:6px;text-align:justify;line-height:20px;">
        Akad Pembiayaan ini mulai berlaku sejak tanggal ditandatanganinya.
      </div>
    </td>
  </tr>
</table>
  <br>
  <div style="margin-left:10px;text-align:justify;line-height:20px;margin-top:30px;width:610px;">
    Demikian Akad ini dibuat dan ditandatangani oleh para pihak di atas materai cukup dalam rangkap 2 (dua) yang mempunyai kekuatan hukum yang sama.
  </div>
  <div style="width:610px;margin-left:10px;margin-top:30px;">
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
        <td align="center"><?php echo $cetak['nama'];?></td>
        <td>&nbsp;</td>
        <td align="center"><?php echo $data_cabang['branch_officer_name'];?></td>
      </tr>
    </table>
  </div>
  <div style="width:610px;margin-left:0px;margin-top:30px;">
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
        <td align="center" width="610">( &nbsp; <?php echo $menyetujui; ?> &nbsp; )</td>
      </tr>
    </table>
  </div>
  <div style="width:610px;margin-left:0px;margin-top:30px;">
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
        <td align="center" width="305">( &nbsp; <?php echo $saksi1;?> &nbsp; )</td>
        <td align="center" width="305">( &nbsp; <?php echo $saksi2;?> &nbsp; )</td>
      </tr>
    </table>
  </div>

  <br>
  <br>
  <br>
  <div align="center" style="font-size:14px;font-style:italic;width:610px;">Bismillahirrahmanirrahim</div>
  <br>
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;">
    SURAT KUASA KHUSUS <br>
    (AKAD WAKALAH) <br>
    Nomor : &nbsp; <span style="font-weight:normal;"><?php echo $cetak['account_financing_no'];?>/wakalah/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?></span>
  </div>
  <br><br>
  <div style=";line-height:20px;width:610px;">
    <div style="text-align:justifywidth:610px;margin-bottom:10px;">
      Pada hari ini <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))]; ?> tanggal <?php echo (int)date('d',strtotime($cetak['tanggal_akad'])); ?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo date('Y',strtotime($cetak['tanggal_akad'])) ?> (<?php echo date("d/m/Y", strtotime($cetak['tanggal_akad']));?>),  kami yang bertanda tangan dibawah ini :
    </div>
    <table cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
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
              bertindak dalam  jabatannya tersebut di atas sesuai Surat Keputusan Direksi Nomor ................ Tanggal ................ dan Surat Kuasa Direksi Nomor ................ Tanggal................ dari dan karenanya, bertindak untuk dan atas nama serta mewakili, selanjutnya disebut "PEMBERI KUASA.
              <br>Dengan ini memberi kuasa kepada:
            </div>
          </td>
        </tr>
        <tr>
          <td width="580">
            <div style="padding-top:6px;text-align:justify;line-height:20px;">
              <?php echo $cetak['nama'];?> pekerjaan <?php echo $cetak['pekerjaan'];?> usia <?php echo $cetak['usia'];?> tahun, bertempat tinggal di <?php echo $cetak['alamat'];?>, Rt/rw  <?php echo $cetak['rt_rw'];?>, Desa  <?php echo $cetak['desa'];?>, Kecamatan  <?php echo $cetak['kecamatan'];?>, Kabupaten  <?php echo $cetak['kabupaten'].' - '.$cetak['kodepos'];?> berdasarkan Kartu Tanda Penduduk (KTP) nomor <?php echo $cetak['no_ktp'];?> <!-- yang berlaku sampai tanggal <?php echo $cetak['masa_berlaku_ktp'];?> -->  dalam hal ini bertindak untuk dan atas namanya sendiri, selanjutnya disebut "PENERIMA KUASA; 
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  <div style="text-align:justify;line-height:20px;;margin-top:10px;width:610px">
    Khusus untuk dan atas nama PEMBERI KUASA, mencari, membayar dan menerima Barang dengan spesifikasi sebagai berikut  :
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20" valign="top"><div style="padding-top:6px">1.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Nama dan jenis barang
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          .............................................
        </div>
      </td>
    </tr>
    <tr>
      <td width="20" valign="top"><div style="padding-top:6px">2.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Merk, Type, Jenis
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          .............................................
        </div>
      </td>
    </tr>
    <tr>
      <td width="20" valign="top"><div style="padding-top:6px">3.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jumlah Satuan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          .............................................
        </div>
      </td>
    </tr>
    <tr>
      <td width="20" valign="top"><div style="padding-top:6px">4.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Developer/Dealer/Supplier
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          .............................................
        </div>
      </td>
    </tr>
  </table>
  <div style="text-align:justify;line-height:20px;;margin-top:10px;width:610px">
    PENERIMA KUASA atas beban dan tanggung jawabnya, berkewajiban melakukan pemeriksaan, baik terhadap keadaan fisik barang maupun sahnya bukti-bukti, surat-surat dan atau dokumen-dokumen yang berkaitan dengan kepemilikan atau hak-hak lainnya atas barang, sehingga karena itu PENERIMA KUASA berjanji dan dengan ini membebaskan PEMBERI KUASA dari risiko cacat maupun ketidaksesuaian barang yang telah dipilih/ditentukan oleh PENERIMA KUASA dan juga dari segala tuntutan, gugatan dan atau ganti rugi yang datang dari pihak mana pun dan atau berdasar alasan apa pun atas risiko dimaksud, dan PENERIMA KUASA tidak akan membatalkan pembiayaan Akad Ijarah dengan alasan cacatnya barang maupun ketidaksesuaian barang maupun dokumen yang terkait dengannya. PENERIMA KUASA wajib menyerahkan bukti/kwitansi pembayaran pelunasan dan penerimaan barang kepada PEMBERI KUASA.
  </div>
  <br>
  <br>
  Surat Kuasa ini diberikan tanpa hak substitusi.
  <br>
  <div style="width:590px;margin-left:10px;margin-top:30px;;">
    <table>
      <tr>
        <td width="280" align="center">PEMBERI KUASA</td>
        <td width="140">&nbsp;</td>
        <td width="180" align="center">PENERIMA KUASA</td>
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
        <td align="center"><?php echo $institution['institution_name'];?><br>KANTOR CABANG SYARIAH <?php echo $data_cabang['branch_name'];?><br><?php echo $data_cabang['branch_officer_name'];?></td>
        <td>&nbsp;</td>
        <td align="center"><?php echo $cetak['nama'];?></td>
      </tr>
    </table>
  </div>
</div>