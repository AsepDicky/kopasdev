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
                  <td width="380"><div style="padding:3px 0;line-height:20px;">: &nbsp;Pusat<?php //echo $data_cabang['branch_name'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Alamat</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;Jl. Dermodjojo No.34 Nganjuk 64418<?php echo $institution['alamat'];?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Diwakili Oleh</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;H. I GUSTI MADE MEDIA , SE.MM<?php //echo $data_cabang['branch_officer_name']; ?></div></td>
                </tr>
                <tr>
                  <td><div width="200" style="padding:3px 0;line-height:20px;"><strong>Dalam kapasitasnya selaku</strong></div></td>
                  <td><div width="380" style="padding:3px 0;line-height:20px;">: &nbsp;Wakil Ketua Umum KSP TAM Syariah<?php //echo $data_cabang['nama_jabatan'];?></div></td>
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
              <?php echo $cetak['nama'];?> pekerjaan <?php echo $cetak['pekerjaan'];?> usia <?php echo $cetak['usia'];?> tahun, bertempat tinggal di <?php echo $cetak['alamat'];?> berdasarkan Kartu Tanda Penduduk (KTP) nomor <?php echo $cetak['no_ktp'];?> <!-- yang berlaku sampai tanggal <?php echo $cetak['masa_berlaku_ktp'];?> --> dalam hal ini bertindak untuk dan atas namanya sendiri, selanjutnya disebut ANGGOTA ;
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    
    <div style="text-align:justify;padding:10px 0px;margin-top:15px;width:610px;">Para Pihak terlebih dahulu menerangkan hal-hal sebagai berikut:</div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa ANGGOTA telah mengajukan Surat Permohonan Pembiayaan tanggal <?php echo date("d-m-Y",strtotime($cetak['tanggal_pengajuan']));?> untuk pembelian/pengadaan barang berupa: "<?php echo $cetak['description'];?>"
    </div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa BANK telah menyatakan persetujuannya untuk memberikan Pembiayaan Murabahah kepada ANGGOTA melalui Surat Pemberitahuan Persetujuan Pembiayaan (SP3) nomor <?php echo $cetak['account_financing_no'];?>/SP3/<?php echo date("Y/m/d",strtotime($cetak['tanggal_akad']));?> yang merupakan bagian dan satu kesatuan dengan akad ini.
    </div>
    <div style="text-align:justify;padding:10px 0px;width:610px;">
      Bahwa selanjutnya KOPERASI dan ANGGOTA dengan ini telah setuju dan sepakat untuk mengadakan Akad Pembiayaan Murabahah (selanjutnya disebut "Akad") berdasarkan ketentuan-ketentuan sebagai berikut:
    </div>
  </div>
  

  <!-- PASAL 1 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;margin-top:;30px">
    PASAL 1<br>
    KETENTUAN POKOK AKAD<br>
  </div>
  
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px">
    Ketentuan-ketentuan pokok Akad ini meliputi sebagai berikut:
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">a.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Harga Beli
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
          Marjin Keuntungan
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
          Harga Jual
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
      <td width="20"><div style="padding-top:6px">d.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Uang Muka
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($uang_muka,2,",",".").' ('.Terbilang($uang_muka).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">e.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          PIUTANG &nbsp;<em>Murabahah</em>
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Rp. <?php echo number_format($piutangmurobahah,2,",",".").' ('.Terbilang($piutangmurobahah).')';?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">f.</div></td>
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
      <td width="20"><div style="padding-top:6px">g.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jenis Pembiayaan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          Pembiayaan Kepemilikan Barang <?php echo $cetak['description'];?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">h.</div></td>
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
      <td width="20"><div style="padding-top:6px">i.</div></td>
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
      <td width="20"><div style="padding-top:6px">j.</div></td>
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
      <td width="20"><div style="padding-top:6px">k.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jatuh Tempo Pembayaran Angsuran
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
      <td width="20"><div style="padding-top:6px">l.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Jenis Jaminan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $cetak['jenis_jaminan'];?>
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">m.</div></td>
      <td width="250">
        <div style="padding-top:6px;">
          Bukti Kepemilikan Jaminan
        </div>
      </td>
      <td width="20"><div style="padding-top:6px;">:</div></td>
      <td width="305">
        <div style="padding-top:6px;">
          <?php echo $cetak['keterangan_jaminan'];?>
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
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 2<br>
    PELAKSANAAN PRINSIP MURABAHAH<br>
  </div>
  
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">
    Pelaksanaan prinsip Murabahah yang berlangsung antara KOPERASI sebagai Penjual dengan ANGGOTA sebagai Pembeli dilaksanakan berdasarkan ketentuan Syariah dan diatur menurut ketentuan-ketentuan dan persyaratan sebagai berikut:
  </div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          ANGGOTA membutuhkan barang dan meminta kepada KOPERASI untuk membeli barang tersebut serta menyediakan Pembiayaan Murabahah guna pembelian barang.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">2.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI bersedia membeli dan kemudian menjual barang tersebut kepada ANGGOTA serta memberikan Pembiayaan Murabahah sesuai dengan permohonan ANGGOTA.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Apabila KOPERASI telah memiliki barang yang diminta dan dibutuhkan ANGGOTA, maka KOPERASI dapat langsung memberikan Pembiayaan Murabahah guna pembelian barang.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">4.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          ANGGOTA bersedia membayar Harga Jual barang sesuai Akad ini, dan Harga Jual tersebut tidak berubah selama berlakunya Akad ini.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">5.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          KOPERASI dapat mewakilkan secara penuh dan/atau memberi kuasa kepada ANGGOTA untuk membeli dan menerima barang dari Pemasok dengan Akad Wakalah yang merupakan satu kesatuan yang tidak dapat dipisahkan dari Akad ini.
        </div>
      </td>
    </tr>
  </table>

  <!-- PASAL 3 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 3<br>
    SYARAT REALISASI PEMBIAYAAN<br>
  </div>

  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;width:610px;">
    KOPERASI akan merealisasikan Pembiayaan berdasarkan prinsip Murabahah berdasarkan Akad ini, setelah ANGGOTA terlebih dahulu memenuhi seluruh persyaratan sebagai berikut:
  </div>
  <div style="margin-left:30px;">
    <table cellspacing="0" cellpadding="0">
      <tr>
        <td width="20"><div style="padding-top:6px">a.</div></td>
        <td width="550">
          <div style="padding-top:6px;text-align:justify;line-height:20px;">
            Menyerahkan kepada KOPERASI seluruh dokumen yang disyaratkan oleh KOPERASI termasuk tetapi tidak terbatas pada dokumen bukti diri ANGGOTA, Bukti Kepemilikan Jaminan dan/atau surat lainnya yang berkaitan dengan Akad ini dan pengikatan Jaminan, yang ditentukan dalam Surat Pemberitahuan Persetujuan Pembiayaan (SP3) dari KOPERASI.
          </div>
        </td>
      </tr>
      <tr>
        <td width="20"><div style="padding-top:6px">b.</div></td>
        <td width="550">
          <div style="padding-top:6px;text-align:justify;line-height:20px;">
            ANGGOTA wajib membuka dan memelihara rekening tabungan pada KOPERASI selama ANGGOTA mendapatkan Pembiayaan Murabahah dari KOPERASI.
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
            Menyetorkan Uang Muka pembelian dan/atau biaya-biaya yang disyaratkan oleh KOPERASI sebagaimana tercantum dalam SP3.
          </div>
        </td>
      </tr>
    </table>
  </div>
<br>
<br>
<br>
<br>
  
  <div style="margin-left:70px;width:610px;">
    <!-- PASAL 4 -->
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
      PASAL 4<br>
      JATUH TEMPO PEMBIAYAAN<br>
    </div>
    <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">Berakhirnya jatuh tempo Pembiayaan tidak dengan sendirinya menyebabkan Utang Murabahah lunas sepanjang masih terdapat sisa Utang Murabahah ANGGOTA.</div>
  </div>
<br>
  <div style="width:610px;margin-left:70px;">
    <!-- PASAL 5 -->
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
      PASAL 5<br>
      POTONGAN HARGA/DISKON<br>
    </div>
    <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">Jika KOPERASI mendapat potongan harga dari pemasok, maka potongan itu merupakan hak ANGGOTA, baik terjadi sebelum maupun sesudah Akad.</div>
  </div>
<br>
  <div style="width:610px;margin-left:70px;">
    <!-- PASAL 6 -->
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
      PASAL 6<br>
      PEMBAYARAN KEMBALI PEMBIAYAAN<br>
    </div>
    <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">ANGGOTA wajib melakukan pembayaran kembali Pembiayaan Murabahah secara Angsuran sampai dengan seluruh Utang Murabahah ANGGOTA lunas sesuai dengan jadwal Angsuran yang disepakati.</div>
  </div>
<br>
  <div style="width:610px;margin-left:70px;">
    <!-- PASAL 7 -->
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
      PASAL 7<br>
      GANTI RUGI (TA'WIDH)<br>
    </div>
    <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">Utang Murabahah ANGGOTA yang tidak dilunasi selambat-lambatnya pada saat jatuh tempo akan dikenakan Ganti Rugi (Ta'widh) yang besarnya sebagaimana diatur dalam Pasal 1 huruf n.</div>
  </div>
<br>
  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 8 -->
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
      PASAL 8<br>
      UANG MUKA<br>
    </div>
    <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
      KOPERASI dapat meminta kepada ANGGOTA Uang Muka (urbun) untuk pembelian barang pada saat Akad ini dengan ketentuan Uang Muka tersebut menjadi bagian pelunasan Utang Murabahah ANGGOTA apabila Pembiayaan Murabahah dilaksanakan.
    </div>
  </div>
  <br>

  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 9 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 9<br>
    PELUNASAN DIPERCEPAT<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
    Menyimpang dari pembayaran Angsuran, ANGGOTA dapat melakukan Pelunasan Dipercepat yang dilakukan sebelum berakhirnya jatuh tempo Pembiayaan.
  </div>
  </div>
  <br>

  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 10 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 10<br>
    JAMINAN DAN PENGIKATANNYA<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
    Guna menjamin pembayaran kembali Utang Murabahah, ANGGOTA wajib menyerahkan barang yang dibiayai sebagai Jaminan, serta menyerahkan Bukti Kepemilikan Jaminan yang asli dan sah untuk diikat sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, berupa : "........................................................."
  </div>
  </div>
  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 11 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 11<br>
    ASURANSI<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
    Selama jangka waktu Pembiayaan, ANGGOTA wajib untuk menutup asuransi jiwa dan asuransi atas barang yang dijaminkan pada perusahaan asuransi berdasarkan Syariah yang disetujui oleh KOPERASI.
  </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 12 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 12<br>
    ANGGOTA CIDERA JANJI<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
    ANGGOTA dinyatakan cidera janji, apabila tidak memenuhi dengan baik kewajiban-kewajibannya atau melanggar ketentuan-ketentuan di dalam Akad ini.
  </div>
  </div>
  <br>

  <div style="width:610px;margin-left:70px;">
  <!-- PASAL 13 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    PASAL 13<br>
    PENAGIHAN SEKETIKA SELURUH UTANG MURABAHAH<br>
    DAN PENYERAHAN/PENGOSONGAN BARANG<br>
  </div>
  <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">
    Menyimpang dari jangka waktu Pembiayaan, KOPERASI berhak mengakhiri jangka waktu Pembiayaan dan menagih pelunasan sekaligus atas seluruh sisa Utang Murabahah dan ANGGOTA wajib membayar dengan seketika dan melunasi sekaligus atas sisa Utang Murabahah atau KOPERASI berhak melakukan upaya-upaya hukum lain untuk menyelesaikan Pembiayaan sesuai Akad ini, apabila ANGGOTA cidera janji.
  </div>
  </div>
  <br>

  <!-- PASAL 14 -->
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 14<br>
    PENGUASAAN DAN PENJUALAN (EKSEKUSI) BARANG JAMINAN.<br>
  </div>
  
  <table cellspacing="0" cellpadding="0" style="margin-left:70px">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Apabila ANGGOTA cidera janji, maka setelah memperingatkan ANGGOTA, KOPERASI berhak untuk melakukan tindakan-tindakan sebagai berikut:
          <table cellspacing="0" cellpadding="0">
            <tr>
              <td width="20"><div style="padding-top:6px">a.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Melaksanakan eksekusi terhadap barang Jaminan berdasarkan ketentuan perundang-undangan yang berlaku.
                </div>
              </td>
            </tr>
            <tr>
              <td width="20"><div style="padding-top:6px">b.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Melaksanakan penjualan terhadap barang Jaminan berdasarkan Surat Kuasa Untuk Menjual yang dibuat oleh ANGGOTA.
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
          Hasil eksekusi dan/atau penjualan barang Jaminan tersebut diprioritaskan untuk melunasi seluruh sisa Utang Murabahah ANGGOTA kepada KOPERASI, termasuk semua biaya yang telah dikeluarkan KOPERASI guna melaksanakan eksekusi barang Jaminan, dan apabila masih ada sisanya maka jumlah sisa tersebut akan dibayarkan kepada ANGGOTA.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Apabila dari hasil penjualan atau eksekusi barang Jaminan Pembiayaan jumlahnya belum mencukupi untuk melunasi seluruh Utang Murabahah ANGGOTA kepada KOPERASI, maka sesuai dengan ketentuan atau peraturan yang berlaku, KOPERASI berhak untuk mengambil pelunasan atas sisa Utang Murabahah tersebut dari penjualan barang-barang lain milik ANGGOTA.
        </div>
      </td>
    </tr>
  </table>
  <br>

  <!-- PASAL 15 -->
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 15<br>
    TIMBUL DAN BERAKHIRNYA HAK-HAK DAN KEWAJIBAN<br>
  </div>
  <table cellspacing="0" cellpadding="0" style="margin-left:70px;">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Dalam hal seluruh Utang Murabahah telah dilunasi, KOPERASI wajib menyerahkan kembali semua surat-surat dan/atau Bukti Kepemilikan Jaminan, serta surat-surat bukti lainnya yang disimpan atau dikuasai KOPERASI kepada:
          <table cellspacing="0" cellpadding="0">
            <tr>
              <td width="20"><div style="padding-top:6px">a.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  ANGGOTA;
                </div>
              </td>
            </tr>
            <tr>
              <td width="20"><div style="padding-top:6px">b.</div></td>
              <td width="550">
                <div style="padding-top:6px;text-align:justify;line-height:20px;">
                  Ahli Waris ANGGOTA;
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
          Apabila ANGGOTA meninggal dunia, hak dan kewajibannya beralih kepada ahli waris dan KOPERASI berhak untuk meminta kepada ahli waris.
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
  <br>
  <!-- PASAL 16 -->
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 16<br>
    FORCE MAJEURE (KEADAAN KAHAR)<br>
  </div>
  <table cellspacing="0" cellpadding="0" style="margin-left:70px;">
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
            Seluruh permasalahan yang timbul akibat terjadinya Force Majeure akan diselesaikan oleh KOPERASI dan ANGGOTA secara musyawarah untuk mufakat. Hal tersebut tanpa mengurangi hak-hak KOPERASI sebagaimana diatur dalam Akad ini.
          </div>
        </td>
      </tr>
  </table>
<br>
  <!-- PASAL 17 -->
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 17<br>
    HUKUM YANG BERLAKU<br>
  </div>
  <table cellspacing="0" cellpadding="0" style="margin-left:70px;">
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
          Apabila dikemudian hari terjadi perselisihan dalam penafsiran atau pelaksanaan ketentuan-ketentuan dari Akad ini, maka para pihak sepakat untuk terlebih dahulu menyelesaikan secara musyawarah.
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
          Mengenai pelaksanaan (eksekusi) putusan BASYARNAS, sesuai dengan ketentuan Undang-undang tentang Arbitrase dan Alternatif Penyelesaian Sengketa, para pihak sepakat bahwa KOPERASI dapat meminta pelaksanaan (eksekusi) putusan BASYARNAS tersebut pada setiap Pengadilan Negeri di wilayah hukum Republik Indonesia.
        </div>
      </td>
    </tr>
  </table>

<br>
  <!-- PASAL 18 -->
  <div style="margin-left:70px;font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;width:610px;">
    PASAL 18<br>
    PENUTUP<br>
  </div>
  <table cellspacing="0" cellpadding="0" style="margin-left:70px;">
    <tr>
      <td width="20"><div style="padding-top:6px">1.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Segala sesuatu yang belum diatur atau perubahan dalam Akad ini akan diatur dalam surat-menyurat dan/atau addendum berdasarkan kesepakatan bersama antara KOPERASI dan ANGGOTA yang merupakan bagian yang tidak terpisahkan dari Akad ini.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">2.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Lampiran-lampiran Akad ini (jika ada) merupakan bagian yang tidak terpisahkan dari Akad ini serta wajib dipatuhi oleh ANGGOTA sebagaimana mestinya.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">3.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Uraian Pasal demi Pasal dalam Akad ini, telah dibaca, dimengerti dan dipahami serta disetujui oleh ANGGOTA dan KOPERASI.
        </div>
      </td>
    </tr>
    <tr>
      <td width="20"><div style="padding-top:6px">4.</div></td>
      <td width="580">
        <div style="padding-top:6px;text-align:justify;line-height:20px;">
          Akad ini mulai berlaku sejak tanggal ditandatanganinya.
        </div>
      </td>
    </tr>
  </table>
  <div style="margin-left:70px;text-align:justify;line-height:20px;font-size:13px;margin-top:30px;width:610px;">
    Demikian Akad ini dibuat dan ditandatangani oleh para pihak di atas materai cukup dalam rangkap 2 (dua) yang mempunyai kekuatan hukum yang sama.
  </div>
  <div style="width:610px;margin-left:70px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td width="180" align="center">ANGGOTA</td>
        <td width="140">&nbsp;</td>
        <td width="280" align="center"><?php echo $institution['institution_name'];?><br>KANTOR CABANG SYARIAH PUSAT<?php //echo $data_cabang['branch_name'];?></td>
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
        <td align="center">H. I GUSTI MADE MEDIA , SE.MM<?php //echo $data_cabang['branch_officer_name'];?></td>
      </tr>
    </table>
  </div>
  <div style="width:610px;margin-left:70px;">SAKSI-SAKSI</div>
  <div style="width:610px;margin-left:70px;margin-top:30px;font-size:13px;">
    <table>
      <tr>
        <td width="230" align="center">SAKSI 1</td>
        <td width="140">&nbsp;</td>
        <td width="230" align="center">SAKSI 2</td>
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
        <td align="center">H. I GUSTI MADE MEDIA , SE.MM<?php //echo $data_cabang['branch_officer_name'];?></td>
      </tr>
    </table>
  </div>
</div>