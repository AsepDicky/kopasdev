<?php 
  $CI = get_instance();

  function Terbilang($angka){  
    // pastikan kita hanya berususan dengan tipe data numeric
    $angka = (float)$angka;
     
    // array bilangan 
    // sepuluh dan sebelas merupakan special karena awalan 'se'
    $bilangan = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
    );
     
    // pencocokan dimulai dari satuan angka terkecil
    if ($angka < 12) {
        // mapping angka ke index array $bilangan
        return $bilangan[$angka];
    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'tujuh'
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi Terbilang(51)
        return sprintf('seratus %s', Terbilang($angka - 100));
    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif Terbilang(67))
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], Terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif Terbilang(250)
        return trim(sprintf('seribu %s', Terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', Terbilang($hasil_bagi), Terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR 
        // @#$%^ WT*
         
        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', Terbilang($hasil_bagi), Terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', Terbilang($hasil_bagi), Terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', Terbilang($hasil_bagi), Terbilang($hasil_mod)));
    } else {
        return 'Wow...';
    }
  }  

  $totalhutang = (isset($cetak['pokok']) && isset($cetak['margin'])) ? $cetak['pokok']+$cetak['margin'] : "0" ;
  $pokok = (isset($cetak['pokok'])) ? $cetak['pokok'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;
  $totalangsuran = (isset($cetak['angsuran_pokok']) && isset($cetak['angsuran_margin'])) ? $cetak['angsuran_pokok']+$cetak['angsuran_margin'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;
  $uang_muka = (isset($cetak['uang_muka'])) ? $cetak['uang_muka'] : "0" ;
  $biaya_administrasi = $totalangsuran;
  $biaya_administrasi += (isset($cetak['biaya_administrasi'])) ? $cetak['biaya_administrasi'] : 0 ;
  $biaya_administrasi += (isset($cetak['biaya_asuransi_jiwa'])) ? $cetak['biaya_asuransi_jiwa'] : 0 ;
  $biaya_administrasi += (isset($cetak['biaya_notaris'])) ? $cetak['biaya_notaris'] : 0 ;
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

  $J_tipe_jaminan           = (isset($data_jaminan['tipe_jaminan'])) ? $data_jaminan['tipe_jaminan'] : '-' ;
  $J_nomor_jaminan          = (isset($data_jaminan['nomor_jaminan'])) ? $data_jaminan['nomor_jaminan'] : '-' ;
  $J_atas_nama              = (isset($data_jaminan['atas_nama'])) ? $data_jaminan['atas_nama'] : '-' ;
  $J_jenis_surat            = (isset($data_jaminan['jenis_surat'])) ? $data_jaminan['jenis_surat'] : '-' ;
  $J_provinsi               = (isset($data_jaminan['province'])) ? $data_jaminan['province'] : '-' ;
  $J_kota                   = (isset($data_jaminan['city'])) ? $data_jaminan['city'] : '-' ;
  $J_kecamatan              = (isset($data_jaminan['kecamatan'])) ? $data_jaminan['kecamatan'] : '-' ;
  $J_kelurahan              = (isset($data_jaminan['kelurahan'])) ? $data_jaminan['kelurahan'] : '-' ;
  $J_blok                   = (isset($data_jaminan['blok'])) ? $data_jaminan['blok'] : '-' ;
  $J_no_imb                 = (isset($data_jaminan['no_imb'])) ? $data_jaminan['no_imb'] : '-' ;
  $J_tanggal_imb            = (isset($data_jaminan['tanggal_imb'])) ? $data_jaminan['tanggal_imb'] : '-' ;
  $J_tanggal_surat_jaminan  = (isset($data_jaminan['tanggal_surat_jaminan'])) ? $data_jaminan['tanggal_surat_jaminan'] : '-' ;
  $J_nop                    = (isset($data_jaminan['nop'])) ? $data_jaminan['nop'] : '-' ;
  $J_nilai_jual             = (isset($data_jaminan['nilai_jual'])) ? $data_jaminan['nilai_jual'] : '-' ;
  $J_luas_tanah             = (isset($data_jaminan['luas_tanah'])) ? $data_jaminan['luas_tanah'] : 0 ;
  $J_alamat                 = (isset($data_jaminan['alamat'])) ? $data_jaminan['alamat'] : '-' ;

  $month = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
  $display_pokok = number_format($cetak['pokok'],0,',','.');
  $display_pokok_terbilang = Terbilang($cetak['pokok']);
  $display_margin_perbulan = number_format($cetak['angsuran_margin'],0,',','.');
  $display_margin_perbulan_terbilang = Terbilang($cetak['angsuran_margin']);
  $display_margin = number_format($cetak['margin'],0,',','.');
  $display_margin_terbilang = Terbilang($cetak['margin']);
  $display_harga_jual = number_format($cetak['pokok']+$cetak['margin'],0,',','.');
  $display_harga_jual_terbilang = Terbilang($cetak['pokok']+$cetak['margin']);
  $display_tanggal_mulai_angsuran = date('d',strtotime($cetak['tanggal_mulai_angsur'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_mulai_angsur']))].' '.date('Y',strtotime($cetak['tanggal_mulai_angsur']));
  $display_jangka_waktu = $cetak['jangka_waktu'];
  $display_jangka_waktu_terbilang = Terbilang($cetak['jangka_waktu']);
  $display_tanggal_jtempo = date('d',strtotime($cetak['tanggal_jtempo'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_jtempo']))].' '.date('Y',strtotime($cetak['tanggal_jtempo']));
  $display_keterangan_peruntukan = nl2br($cetak['description']);
  $display_account_financing_no = $cetak['account_financing_no'];
  $display_ketua_pengurus = $cetak['ketua_pengurus'];
  $display_deskripsi_ketua_pengurus = $cetak['deskripsi_ketua_pengurus'];
  $display_tanggal_akad = date('d',strtotime($cetak['tanggal_akad'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_akad']))].' '.date('Y',strtotime($cetak['tanggal_akad']));
  $display_angsuran_perbulan = number_format($cetak['angsuran_pokok']+$cetak['angsuran_margin'],0,',','.');
  $display_angsuran_perbulan_terbilang = Terbilang($cetak['angsuran_pokok']+$cetak['angsuran_margin']);

  $title_jumlah_pembiayaan = 'Harga Beli';

?> 

<!-- <div style="margin-left:70px;width:610px;"> -->
<page>
<div  style="margin-left:70px;width:610px;">
  <div align="center" style="font-size:13px;width:610px;line-height:20px;border-bottom:2px;padding-bottom:10px;margin-bottom:10px;">
    <span style="font-size:11px;font-style:italic;">Dengan Menyebut Nama Allah Yang Maha Pengasih Lagi Maha Penyayang</span>
    <br>
    <br>
    <strong>
      AKAD PEMBIAYAAN MURABAHAH
      <br>ANTARA 
      <br>KOPERASI PT TELEKOMUNIKASI INDONESIA (KOPTEL)
      <br>DAN 
      <br><?php echo $cetak['nama'] ?>
    </strong>
  </div>
  <div align="center">NOMOR : <?php echo $cetak['akad_no'] ?>/HK410/PK/<?php echo date('Y',strtotime($cetak['tanggal_akad'])) ?></div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
      Pada hari ini <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))];?> tanggal <?php $date=date('d',strtotime($cetak['tanggal_akad'])); $tgl = ($date<10) ? str_replace('0','',$date) : $date ; echo Terbilang($tgl);?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo Terbilang(date('Y',strtotime($cetak['tanggal_akad'])));?>, bertempat di Jalan Ciwulan Nomor 23 Bandung, antara pihak-pihak :
  </div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td>I.</td>
        <td><div style="width:580px;margin-bottom:10px;"><strong>KOPERASI TELEKOMUNIKASI (KOPTEL)  </strong> , NPWP : <strong>01.531.854.6423.000 </strong>  yang didirikan dengan Akte Pendirian Nomor <strong>29/KEP/BLK/XUI990  </strong>  tanggal 21 Nopember 1990, yang telah disahkan oleh Direktur Jenderal Blna Lembaga Koperasi Nomor 29/KEP/BLK/XUI990 tanggal 21 Nopember 1990 dan Perubahan Anggaran Dasar KOPERASI PT Telekomunikasi lndonesia (KOPTEL) No. 05 tanggal 21 Februari 2012 yang dibuat oleh Notaris Pembuat Akta Koperasi (NP. Akta) dan Pejabat Pembuat Akta Tanah (PPAT) Dian Gandirawati, SH. yang telah disahkan berdasarkan Keputusan Kementerian Koperasi dan Usaha Kecil dan Menengah Republik lndonesia Nomor: 165/PADiM.KUKM-2Alll2O12 tanggal 29 Maie|2012, berkedudukan di <strong>Jalan Ciwulan Nomor 23 Bandung </strong> , dalam perbuatan hukum ini diwakili oleh <strong>MUSLIKHUDIN </strong>  Jabatan <strong>Ketua KOPTEL </strong> , selanjutnya dalam Perjanjian ini disebut <strong>PIHAK PERTAMA </strong> ;-</div></td>
      </tr>
      <tr>
        <td>II.</td>
        <td><div style="width:580px;margin-bottom:10px;"><strong><?php echo $cetak['nama'] ?></strong> 
        <?php echo $display_deskripsi_ketua_pengurus ?>
        selanjutnya dalam Perjanjian ini disebut <strong>PIHAK KEDUA </strong> ;
        </div></td>
      </tr>
    </table>
  </div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;padding-top:5px;text-align:justify;text-justify:inter-word;">
    PARA PIHAK terlebih dahulu menerangkan hal hal sebagai berikut :
    <br><br>
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td>a.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">bahwa <strong>PIHAK KEDUA </strong>  mengajukan Permohonan Pembiayaan Modal Usaha yang akan digunakan untuk <?php echo $display_keterangan_peruntukan ?>, untuk hal tersebut <strong>PIHAK KEDUA </strong>  mengajukan pembiayaan kepada <strong>PIHAK PERTAMA </strong> </div></td>
      </tr>
      <tr>
        <td>b.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">bahwa sebagaimana hasil evaluasi <strong>PIHAK PERTAMA </strong>  atas surat Permohonan pembiayaan yang diajukan <strong>PIHAK KEDUA </strong> , <strong>PIHAK PERTAMA </strong>  menyepakati untuk memberikan pembiayaan Modal Usaha kepada <strong>PIHAK KEDUA </strong>  sebesar <strong>Rp <?php echo $display_harga_jual ?>,- ( <?php echo $display_harga_jual_terbilang ?> rupiah ) </strong> ; </div></td>
      </tr>
      <tr>
        <td>c.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">bahwa <strong>PIHAK PERTAMA </strong>  dan <strong>PIHAK KEDUA </strong>  sepakat untuk menuangkan hal-hal yang dimaksud pada butir a dan b diatas dalam Perjanjian ini ;</div></td>
      </tr>
    </table>
    Setelah menimbang hal-hal sebagaimana dimaksud huruf a., b., c Perjanjian ini, PIHAK PERTAMA dan PIHAK KEDUA sepakat mengikatkan diri satu kepada lainnya untuk mengadakan Perjanjian Pembiayaan Modal Usaha, sebagaimana diatur Perjanjian ini;
  </div>
<br>
  <div align="center" style="font-size:11px;line-height:15px;width:610px;padding-top:7px;font-weight:bold;">
    PASAL 1
    <br>PENGERTIAN
  </div>
  <table style="font-size:11px;line-height:15px;" style="font-size:11px;line-height:15px;">
    <tr>
      <td colspan="2">
        <div style="float:left;width:600px;margin-bottom:10px;" >Dalam Akad ini, yang dimaksud dengan:</div>
      </td>
    </tr>
      <tr>
        <td>1.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>Akad Murabahah </strong> adalah Akad jual-beli antara <strong>PIHAK PERTAMA </strong> dan <strong>PIHAK KEDUA </strong>. <strong>PIHAK PERTAMA </strong> membeli Barang yang diperlukan oleh <strong>PIHAK KEDUA </strong>, kemudian menjualnya kepada <strong>PIHAK KEDUA </strong> sebesar harga beli ditambah dengan marjin yang disepakati antara <strong>PIHAK PERTAMA </strong> dan <strong>PIHAK KEDUA </strong>.</div></td>
      </tr>
      <tr>
        <td>2.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>Syariah </strong> adalah hukum lslam yang bersumber dari Al Qur'an, Al Sunnah dan Fatwa yang dikeluarkan oleh Dewan Syariah Nasional - MUI.</div></td>
      </tr>
      <tr>
        <td>3.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>Pembiayaan Murabahah </strong> adalah penyediaan dana yang berdasarkan kesepakatan antara <strong>PIHAK PERTAMA </strong> dengan <strong>PIHAK KEDUA </strong>, yang mewajibkan <strong>PIHAK KEDUA </strong> untuk mengembalikan dana atau tagihan tersebut dalam jangka waktu tertentu beserta marjin yang telah disepakati. </div></td>
      </tr>
      <tr>
        <td>4.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Harga Beli </strong> adalah harga pokok dari harga pemasok ditambah biaya-biaya yang dikeluarkan oleh <strong>PIHAK PERTAMA </strong>, untuk memperoleh barang yang dipesan oleh <strong>PIHAK KEDUA </strong>.</div></td>
      </tr>
      <tr>
        <td>5.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Harga Jual </strong> adalah Harga Beli ditambah marjin <strong>PIHAK PERTAMA </strong>, yang disepakati oleh <strong>PIHAK KEDUA </strong>, yang merupakan jumlah Pembiayaan.</div></td>
      </tr>
      <tr>
        <td>6.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Marjin </strong> adalah jumlah dana yang wajib dibayar <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> sebagai keuntungan atas pembiayaan yang merupakan selisih antara Harga Jual dengan Harga Beli.</div></td>
      </tr>
      <tr>
        <td>7.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Piutang Murabahah </strong> adalah hak tagih <strong>PIHAK PERTAMA </strong> kepada <strong>PIHAK KEDUA </strong>, yang timbul karena <strong>PIHAK KEDUA </strong> telah membeli barang yang dibutuhkannya dengan menggunakan Modal Pembiayaan Murabahah dari <strong>PIHAK PERTAMA </strong>.</div></td>
      </tr>
      <tr>
        <td>8.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Utang Murabahah </strong> adalah sejumlah kewajiban <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong>, yang timbul dari realisasi Pembiayaan berdasarkan Akad ini, maksimal sebesar Harga Jual.</div></td>
      </tr>
      <tr>
        <td>9.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Angsuran </strong> adalah sejumlah kewajiban <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> untuk pembayaran Harga Jual, yang wa.iib dibayar secara bulanan sebagaimana ditentukan dalam Akad ini.</div></td>
      </tr>
      <tr>
        <td>10.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>Jatuh Tempo Pembayaran Angsuran </strong> adalah tanggal <strong>PIHAK KEDUA </strong> berkewajiban membayar angsuran setiap bulan.</div></td>
      </tr>
      <tr>
        <td>11.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>Tunggakan </strong> adalah suatu Utang Murabahah yang telah jatuh tempo, tetapi belum dibayar oleh <strong>PIHAK KEDUA </strong>.</div></td>
      </tr>
      <tr>
        <td>12.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">  <strong>Akad Wakalah </strong> adalah Akad pemberian kuasa dari <strong>PIHAK PERTAMA </strong> kepada <strong>PIHAK KEDUA </strong> untuk melakukan pembelian barang dari Pemasok yang dipesan oleh <strong>PIHAK KEDUA </strong>.</div></td>
      </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="3" align="center">PASAL 2<br>KETENTUAN POKOK AKAD</td>
    </tr>
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="3" align="left">Ketentuan-ketentuan pokok Akad ini, meliputi sebagai berikut : </td>
    </tr>
    <tr>
      <td>a.  <?php echo $title_jumlah_pembiayaan ?> (Jumlah Pembiayaan)</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Rp <?php echo $display_pokok; ?>,- ( <?php echo $display_pokok_terbilang; ?> rupiah ) </div></td>
    </tr>
    <tr>
      <td>b. Marjin per bulan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Rp <?php echo $display_margin_perbulan; ?>,- ( <?php echo $display_margin_perbulan_terbilang; ?> rupiah) setara dengan 12% pertahun berdasarkan perhitungan flat</div></td>
    </tr>
    <tr>
      <td>c. Marjin</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Rp <?php echo $display_margin; ?>,- ( <?php echo $display_margin_terbilang; ?> rupiah ) </div></td>
    </tr>
    <tr>
      <td>d.  Harga Jual (Total Pengembalian)</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Rp <?php echo $display_harga_jual; ?>,- ( <?php echo $display_harga_jual_terbilang; ?> rupiah )</div></td>
    </tr>
    <tr>
      <td>e.  Jenis Pembiayaan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Pembiayaan Murabahah </div></td>
    </tr>
    <tr>
      <td>f. Tujuan Pembiaan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> <?php echo $display_keterangan_peruntukan ?> oleh <strong>PIHAK KEDUA </strong> </div></td>
    </tr>
    <tr>
      <td>g. Angsuran per bulan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Rp <?php echo $display_angsuran_perbulan ?> ( <?php echo $display_angsuran_perbulan_terbilang ?> rupiah ) </div></td>
    </tr>
    <tr>
      <td>h. Terhitung mulai bulan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"><?php echo $display_tanggal_mulai_angsuran; ?> </div></td>
    </tr>
    <tr>
      <td>i. Jangka Waktu Pembiayaan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> <?php echo $display_jangka_waktu; ?> (<?php echo $display_jangka_waktu_terbilang ?>) bulan </div></td>
    </tr>
    <tr>
      <td>j. Jatuh Tempo Pembiayaan</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"><?php echo $display_tanggal_jtempo; ?> </div></td>
    </tr>
    <tr>
      <td>k. Jatuh Tempo Pembayaran</td>
      <td>:</td>
      <td><div style="width:420px;text-align:justify;text-justify:inter-word;"> Setiap tanggal <?php echo date('d',strtotime($cetak['tanggal_mulai_angsur'])) ?> per bulan terhitung mulai bulan <?php echo $month[(int)date('m',strtotime($cetak['tanggal_mulai_angsur']))] ?> <?php echo date('Y',strtotime($cetak['tanggal_mulai_angsur'])) ?> </div></td>
    </tr>
    <tr>
      <td colspan="3">l. Bea Materai ditanggung oleh PIHAK KEDUA</td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 3<br>PELAKSANAAN PRINSIP MURABAHAH</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">Pelaksanaan prinsip Murabahah yang berlangsung antara <strong>PIHAK PERTAMA </strong> sebagai Penjual dengan <strong>PIHAK KEDUA </strong> sebagai Pembeli, dilaksanakan berdasarkan ketentuan Syariah dan diatur menurut ketentuan-ketentuan dan persyaratan sebagai berikut: </div></td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK KEDUA </strong> membutuhkan barang dan meminta kepada <strong>PIHAK PERTAMA </strong> untuk memberikan Pembiayaan Modal Usaha KOPTEL guna Pengadaan Material Proyek oleh <strong>PIHAK KEDUA </strong>. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK PERTAMA </strong> menyediakan Pembiayaan Murabahah sesuai dengan permohonan <strong>PIHAK KEDUA </strong>.</div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK KEDUA </strong> bersedia membayar Pembiayaan Murabahah sesuai Akad ini. </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK PERTAMA </strong> dapat memberikan kuasa secara penuh kepada <strong>PIHAK KEDUA </strong> untuk membeli dan menerima barang dari Pemasok untuk dan atas nama <strong>PIHAK KEDUA </strong> sendiri dengan Akad Wakalah, yang merupakan satu kesatuan yang tidak terpisahkan dari Akad ini. </div></td>
    </tr>
    <tr>
      <td>5.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Pemberian kuasa sebagaimana dimaksud dalam ayat 4 pasal ini, tidak mengakibatkan <strong>PIHAK KEDUA </strong> dapat membatalkan jual beli barang. <strong>PIHAK KEDUA </strong> tidak dapat menuntut <strong>PIHAK PERTAMA </strong> untuk memberikan ganti rugi sebagaimana dimaksud dalam Pasal 1471 Kitab Undang-Undang Hukum Perdata.</div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 4<br>SYARAT REALISASI PEMBIAYAAN MURABAHAH</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
      <strong>PIHAK PERTAMA </strong> akan merealisasikan pembiayaan berdasarkan prinsip Murabahah sesuai dengan Akad ini, setelah <strong>PIHAK KEDUA </strong> terlebih dahulu memenuhi seluruh persyaratan sebagai berikut: 
      </div></td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK KEDUA </strong> menyerahkan kepada <strong>PIHAK PERTAMA </strong> seluruh dokumen yang disyaratkan oleh <strong>PIHAK PERTAMA </strong>, termasuk tetapi tidak terbatas pada dokumen bukti diri <strong>PIHAK KEDUA </strong> dan/atau surat lainnya yang berkaitan dengan Akad ini. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK KEDUA </strong> dan <strong>PIHAK PERTAMA </strong> menandatangani Akad ini. </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Sejak ditandatanganinya Akad ini dan telah diterimanya barang oleh <strong>PIHAK KEDUA </strong>, maka resiko atas barang tersebut sepenuhnya menjadi tanggung jawab <strong>PIHAK KEDUA </strong> dan dengan ini <strong>PIHAK KEDUA </strong> membebaskan <strong>PIHAK PERTAMA </strong> dari segala tuntutan dan/atau ganti rugi berupa apapun atas resiko tersebut. </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Realisasi pemberian Pembiayaan Murabahah, dilakukan oleh <strong>PIHAK PERTAMA </strong> kepada <strong>PIHAK KEDUA </strong>, melalui rekening <strong>PIHAK KEDUA </strong>.</div></td>
    </tr>
  </table>
  <p align="right">pasal 5/....</p>
</div>
</page>

<page>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 5<br>JATUH TEMPO PEMBIAYAAN</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
        Berakhirnya jatuh tempo Pembiayaan tidak dengan sendirinya menyebabkan Utang lunas, sepanjang masih terdapat sisa Utang PIHAK KEDUA.
      </div></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
  </table>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 6<br>PENGEMBALIAN PEMBIAYAAN</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"><strong>PIHAK KEDUA </strong> wajib melakukan Pengembalian Pembiayaan secara angsuran, sampai dengan seluruh Utang Murabahah <strong>PIHAK KEDUA </strong> lunas sesuai dengan jadual angsuran yang disepakati. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Setiap pembayaran yang diterima oleh <strong>PIHAK PERTAMA </strong> dari <strong>PIHAK KEDUA </strong> atas kewajiban Pembiayaan, dibukukan oleh <strong>PIHAK PERTAMA </strong> ke dalam rekening <strong>PIHAK KEDUA </strong>, sesuai dengan catatan dan pembukuan yang ada pada <strong>PIHAK PERTAMA </strong>. </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:590px;text-align:justify;">Dalam hal PIHAK KEDUA merasa bahwa pembukuan/pencatatan <strong>PIHAK PERTAMA </strong> atas kewajiban dan pembayaran yang telah dilakukan tidak benar, <strong>PIHAK KEDUA </strong> berhak untuk mengajukan keberatan/klaim kepada <strong>PIHAK PERTAMA </strong> dengan disertai bukti-bukti pembayaran yang sah. Namun bila <strong>PIHAK KEDUA </strong> tidak dapat menunjukkan bukti-bukti pembayaran yang sah, maka yang dianggap benar adalah catatan pembukuan PIHAK PERTAMA. </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;">Seluruh pembayaran Utang atau setiap bagian dari Utang yang auto debet oleh <strong>PIHAK KEDUA </strong> ke rekening <strong>PIHAK PERTAMA </strong>
      Melalui <?php echo $cetak['nama_bank'] ?> Cabang <?php echo $cetak['bank_cabang'] ?> atas nama <?php echo $cetak['atasnama_rekening'] ?> dengan nomor rekening <?php echo $cetak['nomor_rekening'] ?>, atau.</div></td>
    </tr>
    <tr>
      <td>5.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Bilyet Giro (BG) yang issued dan sudah ditandatangani oleh <strong>PIHAK KEDUA </strong></div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 7<br>PELUNASAN DIPERCEPAT</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> <strong>PIHAK KEDUA </strong> dapat melakukan pelunasan dipercepat, baik sebagian maupun seluruhnya, yang dilakukan sebelum berakhirnya jatuh tempo Pembiayaan dengan Saldo Piutang Murabahah ditentukan oleh <strong>PIHAK PERTAMA </strong>.</div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Jika <strong>PIHAK KEDUA </strong> mengembalikan seluruh dana pembiayaan <strong>PIHAK PERTAMA </strong> lebih awal dari jangka waktu yang telah ditentukan, maka tidak berarti pengembalian tersebut akan menghapuskan alau mengurangi Marjin yang menjadi hak <strong>PIHAK PERTAMA </strong> pada bulan itu, sebagaimana ditentukan dalam Akad ini.</div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Seluruh pembayaran Utang atau setiap bagian dari Utang yang dibayar secara tunai oleh PTHAK KEDUA dilakukan pada hari dan jam kerja atau ditransfer ke rekening <strong>PIHAK PERTAMA </strong>
      melalui <?php echo $cetak['nama_bank'] ?> Cabang <?php echo $cetak['bank_cabang'] ?> atas nama <?php echo $cetak['atasnama_rekening'] ?> dengan nomor rekening <?php echo $cetak['nomor_rekening'] ?>.</div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 8<br>JAMINAN</td>
    </tr>
    <tr>
      <td style="font-size:11px;line-height:15px;" colspan="2" align="left">Jaminan pemenuhan kewajiban <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> dapat berupa : </td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Surat Pernyataan Bersedia dikompensasikan dengan Sentralisasi Potongan Payroll bila 2 (dua) bulan berturut-turut tidak membayar kewajiban kepada <strong>PIHAK PERTAMA </strong>. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"> Tanah seluas 210 m2 (dua ratus sepuluh meter persegi) sebagaimana dimaksud dalam sertifikat Hak Guna Bangunan No. 368 Propinsi Jawa Timur Kabupaten Pasuruan Kecamatan Pandaan Kelurahan Petungasri atas nama Koperasi Karyawan TELKOM Cabang Pandaan serta Bangunan yang berdiri diatasnya atas Pembiayaan Modal Usaha yang diterimanya, dengan menyerahkan Sertifikat Tanah kepada <strong>PIHAK PERTAMA </strong>.</div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 9<br>PIHAK KEDUA WANPRESTASI</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"><strong>PIHAK KEDUA </strong> dinyatakan wanprestasi, apabila tidak memenuhi kewajiban- kewajibannya atau melanggar ketentuan-ketentuan di dalam Akad ini.</div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Apabila <strong>PIHAK KEDUA </strong> wanprestasi maka, <strong>PIHAK PERTAMA </strong> berhak untuk memberikan peringatan secara lisan maupun dalam bentuk pernyataan lalai/wanprestasi berupa surat atau yang sejenis, yang dikirimkan ke alamat <strong>PIHAK KEDUA </strong>. </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Apabila selama 2 (dua) bulan <strong>PIHAK KEDUA </strong> tidak memenuhi kewajibannya kepada <strong>PIHAK PERTAMA </strong>, maka <strong>PIHAK PERTAMA </strong> dapat mengkompensasikannya dengan Sentralisasi Potongan Payroll malik <strong>PIHAK KEDUA </strong> dan/ atau mengeksekusi jaminan yang dUaminkan ke <strong>PIHAK PERTAMA </strong>.</div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 10<br>TANGGUNG JAWAB PARA-PIHAK</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Segala sesuatu bekaitan penggunaan Pembiayaan Murabahah oleh <strong>PIHAK KEDUA </strong>, termasuk akibatnya maka segala risiko sepenuhnya menjadi tanggung jawab <strong>PIHAK KEDUA </strong>. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Adanya kerugian atau masalah apapun pada <strong>PIHAK KEDUA </strong>, tidak dapat dijadikan alasan untuk mengingkari atau melalaikan atau menunda pelaksanaan kewajiban <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> sesuai Akad ini, termasuk antara lain membayar angsuran dan sebagainya.</div></td>
    </tr>
  </table>
  <p align="right">pasal 11/....</p>
</div>
</page>

<page>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 11<br>KUASA YANG TIDAK DAPAT DITARIK KEMBALI</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Semua kuasa yang dibuat dan diberikan oleh <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> dalam Akad ini, maupun dalam dokumen lain sebagai pelaksanaan Akad ini dan selama kewajiban <strong>PIHAK KEDUA </strong> kepada <strong>PIHAK PERTAMA </strong> belum diselesaikan seluruhnya, maka kuasa-kuasa tersebut tidak akan diakhiri oleh <strong>PIHAK KEDUA </strong> dan tidak akan berakhir karena sebab apapun juga, termasuk tetapi tidak terbatas pada sebab-sebab yang diatur dalam Pasal 1813 Kitab Undang-Undang Hukum Perdata.</div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;"><strong>PIHAK KEDUA </strong> mengikatkan dan mewajibkan diri untuk tidak membuat surat-surat kuasa dan/atau janji-janji yang sifat dan/atau isinya serupa kepada pihak lain, selain kepada <strong>PIHAK PERTAMA </strong></div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 12<br>HUKUM YANG BERLAKU</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Pelaksanaan Akad ini tunduk kepada ketentuan perundang-undangan yang berlaku di lndonesia dan ketentuan Syariah yang berlaku. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Apabila dikemudian hari terjadi perselisihan dalam penafsiran atau pelaksanaan ketentuan-ketentuan dari Akad ini, maka PARA PIHAK sepakat untuk terlebih dahulu menyelesaikan secara musyawarah. </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Bilamana musyawarah tidak menghasilkan kata sepakat mengenai penyelesaian perselisihan, maka semua sengketa yang timbul dari Akad ini akan diselesaikan dan diputus oleh Badan Arbitrase Syariah Nasional (BASYARNAS), yang keputusannya mengikat PARA PIHAK yang bersengketa, sebagai keputusan tingkat pertama dan terakhir. </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Mengenai pelaksanaan (eksekusi) putusan BASYARNAS, sesuai dengan ketentuan Undang-undang tentang Arbitrase dan Alternatif Penyelesaian Sengketa, PARA PIHAK sepakat bahwa <strong>PIHAK PERTAMA&nbsp;</strong> dapat meminta pelaksanaan (eksekusi) putusan BASYARNAS tersebut, pada setiap Pengadilan Negeri di Wilayah Hukum Republik lndonesia.</div></td>
    </tr>
  </table>
  <br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 13<br>PENUTUP</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Uraian pasal demi pasal Akad ini, telah dibaca, dimengerti dan dipahami serta disetujui oleh <strong>PIHAK KEDUA&nbsp;</strong> dan <strong>PIHAK PERTAMA&nbsp;</strong>. </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Segala sesuatu yang belum diatur atau perubahan dalam Akad ini, akan di atur dalam addendum berdasarkan kesepakatan bersama antara <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong>, yang merupakan bagian yang tidak terpisahkan dari Akad ini.</div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Akad ini mulai berlaku sejak tanggal ditandatangani.</div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Mengenai pelaksanaan (eksekusi) putusan BASYARNAS, sesuai dengan ketentuan Undang-undang tentang Arbitrase dan Alternatif Penyelesaian Sengketa, PARA PIHAK sepakat bahwa <strong>PIHAK PERTAMA&nbsp;</strong> dapat meminta pelaksanaan (eksekusi) putusan BASYARNAS tersebut, pada setiap Pengadilan Negeri di Wilayah Hukum Republik lndonesia.</div></td>
    </tr>
  </table>
  <br><br>
  <table style="font-size:11px;font-weight:bold;">
    <tr>
      <td align="center" width="190">PIHAK PERTAMA,</td>
      <td align="center" width="190">&nbsp;</td>
      <td align="center" width="190">PIHAK KEDUA,</td>
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
      <td align="center" style="font-weight:normal;font-size:9px;"></td>
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
      <td align="center">
            <span style="text-decoration:underline;"><?php if(isset($pejabat_nama)) echo $pejabat_nama; if(isset($pejabat_nik)) echo ' / '.$pejabat_nik;?>&nbsp;</span>
        <br><?php if(isset($pejabat_jabatan)) echo $pejabat_jabatan;?>
      </td>
      <td align="center">&nbsp;</td>
      <td align="center">
          <span style="text-decoration:underline;"><?php echo $cetak['nama'];?>&nbsp;</span>
          <br>KONSUMEN
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <!-- BEGIN SAKSI -->
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">SAKSI </td>
      <td>&nbsp;</td>
      <td align="center"></td>
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
      <td align="center"><?php echo $saksi1;?></td>
      <td align="center">&nbsp;</td>
      <td align="center">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <!-- END SAKSI -->
  </table>
</div>
</page>
<page>
  
</page>

<page>
<div style="margin-left:70px;width:610px;">
  <table style="font-size:11px;line-height:15px;" align="center">
    <tr>
      <td colspan="3" align="center">JADWAL ANGSURAN <br>KMG KOPTEL<br><br>&nbsp;</td>
    </tr>
    <tr>
      <td>NAMA KONSUMEN</td>
      <td>:</td>
      <td><?php echo $cetak['nama'];?> NIK. <?php echo $cetak['cif_no'];?></td>
    </tr>
    <tr>
      <td>Besarnya Pokok Pembiayaan</td>
      <td>:</td>
      <td><?php echo number_format($cetak['pokok']);?></td>
    </tr>
    <tr>
      <td>Margin Efektif / Tahun</td>
      <td>:</td>
      <td>13,0 % = 1,083 % Perbulan</td>
    </tr>
    <tr>
      <td>Jangka Waktu (Bulan)</td>
      <td>:</td>
      <td><?php echo $cetak['jangka_waktu'];?> bulan</td>
    </tr>
    <tr>
      <td>Angsuran</td>
      <td>:</td>
      <td><?php $angs = ($cetak['pokok']+$cetak['margin'])/$cetak['jangka_waktu']; echo number_format($angs);?></td>
    </tr>
    <tr>
      <td>Jumlah Pengembalian</td>
      <td>:</td>
      <td><?php echo number_format(($cetak['pokok']+$cetak['margin']));?></td>
    </tr>
  </table>
</div>
</page>
<table style="font-size:11px;line-height:15px;" cellpadding="0" cellspacing="0" align="center">
  <thead>
    <tr>
      <th align="center" rowspan="2" style="border:0.5px solid #000; padding:5px; font-size:12px;">Angs. Ke</th>
      <th align="center" rowspan="2" style="border:0.5px solid #000; padding:5px; font-size:12px;">Angs. Bln</th>
      <th align="center" rowspan="2" style="border:0.5px solid #000; padding:5px; font-size:12px;">Tanggal<br> JTH Tempo</th>
      <th align="center" colspan="3" style="border:0.5px solid #000; padding:5px; font-size:12px;">ANGSURAN</th>
      <th align="center" rowspan="2" style="border:0.5px solid #000; padding:5px; font-size:12px;">Saldo Pokok<br> Pembiayaan</th>
    </tr>
    <tr>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:12px;">POKOK</th>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:12px;">MARGIN</th>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:12px;">JUMLAH</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $pokok = $cetak['pokok'];
    $sisa_pokok = $pokok;
    $Tangs_pokok = 0;
    $Tangs_margin = 0;
    $Ttotal_angsuran = 0;
    for ($i=1; $i <=count($jadwal_angsuran) ; $i++){

      $angs_pokok  = $jadwal_angsuran[($i-1)]['angsuran_pokok'];
      $angs_margin = $jadwal_angsuran[($i-1)]['angsuran_margin'];
      $total_angsuran  = $angs_margin+$angs_pokok;
      $sisa_pokok  = $sisa_pokok-$angs_pokok;

      $Tangs_pokok += $angs_pokok;
      $Tangs_margin += $angs_margin;
      $Ttotal_angsuran += $total_angsuran;
    ?>
    <tr>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"><?php echo $i;?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px;"><?php echo date('M-Y',strtotime($jadwal_angsuran[($i-1)]['tangga_jtempo']));?></td>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;">25</td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($angs_pokok,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($angs_margin,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($total_angsuran,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($sisa_pokok,0,',','.');?></td>
    </tr>
    <?php }?>
    <tr>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px;"></td>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Tangs_pokok,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Tangs_margin,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Ttotal_angsuran,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;"></td>
    </tr>
  </tbody>
</table>
<!-- </div> -->