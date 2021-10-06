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
  $display_margin_perbulan = number_format($cetak['margin'],0,',','.');
  $display_margin_perbulan_terbilang = Terbilang($cetak['margin']);
  $display_margin = number_format($cetak['margin'],0,',','.');
  $display_margin_terbilang = Terbilang($cetak['margin']);
  $display_harga_jual = number_format($cetak['pokok']+$cetak['margin'],0,',','.');
  $display_harga_jual_terbilang = Terbilang($cetak['pokok']+$cetak['margin']);
  $display_tanggal_mulai_angsuran = date('d',strtotime($cetak['tanggal_mulai_angsur'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_mulai_angsur']))].' '.date('Y',strtotime($cetak['tanggal_mulai_angsur']));
  $display_jangka_waktu = $cetak['jangka_waktu'];
  $display_jangka_waktu_terbilang = Terbilang($cetak['jangka_waktu']);
  $display_tanggal_jtempo = date('d',strtotime($cetak['tanggal_jtempo'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_jtempo']))].' '.date('Y',strtotime($cetak['tanggal_jtempo']));
  $display_nisbah_nasabah = $cetak['nisbah_bagihasil'];
  $display_nisbah_nasabah_terbilang = Terbilang($cetak['nisbah_bagihasil']);
  $display_nisbah_perusahaan = 100-$cetak['nisbah_bagihasil'];
  $display_nisbah_perusahaan_terbilang = Terbilang(100-$cetak['nisbah_bagihasil']);
  $display_ganti_rugi = number_format($cetak['pokok']*1/1000,0,',','.');
  $display_keterangan_peruntukan = nl2br($cetak['description']);
  $display_account_financing_no = $cetak['account_financing_no'];
  $display_ketua_pengurus = $cetak['ketua_pengurus'];
  $display_deskripsi_ketua_pengurus = $cetak['deskripsi_ketua_pengurus'];
  $display_tanggal_akad = date('d',strtotime($cetak['tanggal_akad'])).' '.$month[(int)date('m',strtotime($cetak['tanggal_akad']))].' '.date('Y',strtotime($cetak['tanggal_akad']));
  $title_jumlah_pembiayaan = 'Harga Beli';

?> 

<!-- <div style="margin-left:70px;width:610px;"> -->
<page>
<div  style="margin-left:70px;width:610px;">
  <div align="center" style="font-size:13px;width:610px;line-height:20px;border-bottom:2px;padding-bottom:10px;margin-bottom:10px;">
    <span style="font-size:11px;font-style:italic;">Dengan Menyebut Nama Allah Yang Maha Pengasih Lagi Maha Penyayang
    <br>
    <br>
    ”.. Dan sesungguhnya kebanyakan dari orang-orang yang berserikat itu sebahagian mereka berbuat zalim kepada sebahagian yang lain, kecuali orang orang yang beriman dan mengerjakan amal yang saleh...(QS. Shad (38) : 24)
    <br>
    <br>
“Sesungguhnya orang-orang yang mengelola harta Allah dengan tidak benar, maka bagi mereka api neraka pada hari kiamat”.(HR. Bukhari)
</span>
<br>
<br>
    <strong>
      AKAD PEMBIAYAAN
      <br>BERDASARKAN PRINSIP MUSYARAKAH
    </strong>
  </div>
  <div align="center">No. <?php echo $cetak['akad_no'] ?>/HK410/PPB/<?php echo date('Y',strtotime($cetak['tanggal_akad'])) ?></div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
      Pada hari ini <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))];?> tanggal <?php $date=date('d',strtotime($cetak['tanggal_akad'])); $tgl = ($date<10) ? str_replace('0','',$date) : $date ; echo Terbilang($tgl);?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo Terbilang(date('Y',strtotime($cetak['tanggal_akad'])));?>, bertempat di Bandung yang bertanda tangan dibawah ini:
  </div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;text-align:justify;text-justify:inter-word;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="width:20px;">1.</td>
        <td><div style="width:580px;margin-bottom:10px;">
          <strong>MUH. ARIS SUBEKTI&nbsp;</strong> dalam jabatannya selaku <strong>Pengurus Pengembangan Bisnis &nbsp; </strong> berdasarkan Surat Keputusan  Operation Senior Manager Human Resource Partner V Perusahaan Perseroan (PERSERO) PT. Telekomunikasi Indonesia Tbk. tanggal 18 Mei 2015 dan oleh karenanya berhak mewakili secara sah untuk dan atas nama Koperasi PT. Telekomunikasi Indonesia, Tbk (KOPTEL) yang berkedudukan di Jl. Ciwulan No. 23, Bandung – Jawa Barat yang didirikan berdasarkan Akta Pendirian Nomor 8307 tanggal 21 Nopember 1990, yang telah disahkan oleh Direktur Jenderal Bina Lembaga Koperasi Nomor 29/KEP/BLK/XI/1990 tanggal 21 Nopember 1990  dan Perubahan Anggaran Dasar Koperasi PT Telekomunikasi Indonesia (KOPTEL) No. 05 tanggal 21 Februari 2012 yang dibuat oleh Notaris Pembuat Akta Koperasi (NP. Akta) dan Pejabat Pembuat Akta Tanah (PPAT) Dian Gandirawati, SH. yang telah disahkan berdasarkan Keputusan Kementerian Koperasi dan Usaha Kecil dan Menengah Republik Indonesia Nomor : 165/PAD/M.KUKM.2/III/2012 tanggal 29 Maret 2012, selanjutnya disebut <strong>PIHAK PERTAMA&nbsp;</strong>;
        </div></td>
      </tr>
      <tr>
        <td>2.</td>
        <td><div style="width:580px;margin-bottom:10px;">
        <table cellspacing="0" cellpadding="0">
          <tr>
            <!-- <td style="width:20px;text-align:center;padding:0;">A.</td> -->
            <td style="padding:0;"><div style="width:575px;padding-bottom:10px;">
            <strong><?php echo $display_ketua_pengurus; ?>&nbsp;</strong>
            <?php echo $display_deskripsi_ketua_pengurus; ?>

            </div></td>
          </tr>
          <!-- <tr>
            <td style="text-align:center;padding:0;">B.</td>
            <td style="padding:0;"><div style="width:555px;padding-bottom:10px;">
            TRI HARTONO PAMILIH pekerjaan Pensiunan usia 60 tahun, bertempat tinggal di Jl. Kemang Raya Gg. Bersama No. 34 RT. 002 RW. 005 Kelurahan Cilodong, Kecamatan Cilodong Kota Depok berdasarkan Kartu Tanda Penduduk (KTP) nomor 3276052909550002 yang berlaku sampai tanggal 29 September 2017 dalam hal ini bertindak dalam jabatannya selaku Direktur Utama PT. PUTRA TIMUR JAYA  berdasarkan Akta Pendirian, nomor 66 tanggal 15 Oktober 2009 yang dibuat dihadapan Notaris DEWI HIMIJATI TANDIKA, SH. Akta pendirian tersebut telah mendapat pengesahan dari Menteri Hukum dan Hak Asasi Manusia dengan keputusan nomor C-643.HT.03.02-Th 2000 tanggal 15 Oktober 2009 dan telah dilakukan perubahan dengan Akta Perubahan Nomor 58 tanggal 30 September 2011 yang dibuat dihadapan Notaris BONAR SIHOMBING SH nomor AHU-61585.AH.01.02 tanggal 14 Desember 2011 dan telah dimuat dalam Berita Negara RI nomor 4756, Tambahan Berita Negara RI tanggal 12/2-2013 berkedudukan di Jl. Basuki Rahmat No. 8 Jakarta Timur
            </div></td>
          </tr> -->
        </table>
        </div></td>
      </tr>
    </table>
    <div style="padding-left:30px;">Selanjutnya disebut <strong>PIHAK KEDUA&nbsp;</strong></div>
  </div>
<br>
  <div style="font-size:11px;line-height:15px;width:610px;padding-top:5px;text-align:justify;text-justify:inter-word;">
  <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> secara bersama-sama selanjutnya disebut PARA PIHAK.
  <br>
    PARA PIHAK terlebih dahulu menerangkan hal hal sebagai berikut :
    <br>
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td>a.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Dalam melaksanakan <?php echo $display_keterangan_peruntukan ?>, <?php $cetak['nama'] ?>.</div></td>
      </tr>
      <tr>
        <td>b.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Bahwa <strong>PIHAK KEDUA&nbsp;</strong> mengajukan Permohonan Pembiayaan Komersial yang akan digunakan untuk Pekerjaan <?php echo $display_keterangan_peruntukan ?>, untuk hal tersebut <strong>PIHAK KEDUA&nbsp;</strong> mengajukan pembiayaan kepada <strong>PIHAK  PERTAMA</strong> ;</div></td>
      </tr>
      <tr>
        <td>c.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">Bahwa <strong>PIHAK PERTAMA&nbsp;</strong> telah menyatakan persetujuannya untuk memberikan Pembiayaan Musyarakah kepada <strong>PIHAK KEDUA&nbsp;</strong> melalui Surat Pemberitahuan Persetujuan Pembiayaan (SP3) nomor <?php echo $display_account_financing_no ?> tanggal <?php echo $display_tanggal_akad ?> yang merupakan bagian dan satu kesatuan dengan akad ini.</div></td>
      </tr>
    </table>
    <br>
    <div style="width:580px;">
    Bahwa selanjutnya <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> dengan ini telah setuju dan sepakat untuk mengadakan Akad Pembiayaan Musyarakah (selanjutnya disebut “Akad”) berdasarkan ketentuan-ketentuan sebagai berikut:
    </div>
  </div>
<br>
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="3" align="center">PASAL 1<br>KETENTUAN POKOK AKAD</td>
    </tr>
    <tr>
      <td colspan="2"><div style="width:600px;margin-bottom:10px;">
        Ketentuan-ketentuan pokok Akad ini meliputi sebagai berikut:
      </div></td>
    </tr>
      <tr>
        <td>a.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
          Modal Musyarakah <strong>PIHAK PERTAMA&nbsp;</strong>/Pembiayaan Musyarakah:  
          Rp. <?php echo $display_pokok ?>,- (<?php echo $display_pokok_terbilang ?>),dari total kebutuhan modal usaha dan sisanya oleh <strong>PIHAK KEDUA&nbsp;</strong>.
        </div></td>
      </tr>
      <tr>
        <td>b.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        Nisbah Bagi Hasil untuk masing-masing pihak adalah:
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td>1.</td>
            <td><?php echo $display_nisbah_nasabah ?>% (<?php echo $display_nisbah_nasabah_terbilang ?>) dari keuntungan untuk <strong>PIHAK PERTAMA&nbsp;</strong>;</td>
          </tr>
          <tr>
            <td>2.</td>
            <td><?php echo $display_nisbah_perusahaan ?>% (<?php echo $display_nisbah_perusahaan_terbilang ?>) dari keuntungan untuk <strong>PIHAK KEDUA&nbsp;</strong>.</td>
          </tr>
        </table>
        </div></td>
      </tr>
      <tr>
        <td>c.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
          Pembagian keuntungan dilakukan sesuai kesepakatan PARA PIHAK.
        </div></td>
      </tr>
      <tr>
        <td>d.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:170px">Tujuan Pembiayaan</td>
            <td>: <?php echo $display_keterangan_peruntukan ?> </td>
          </tr>
        </table>
        </div></td>
      </tr>
      <tr>
        <td>e.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:170px">Jangka Waktu Pembiayaan</td>
            <td>: <?php echo $display_jangka_waktu ?> (<?php echo $display_jangka_waktu_terbilang ?>) bulan </td>
          </tr>
        </table>
        </div></td>
      </tr>
      <tr>
        <td>f.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:170px">Jatuh Tempo Pembiayaan</td>
            <td>: <?php echo $display_tanggal_jtempo ?> </td>
          </tr>
        </table>
        </div></td>
      </tr>
      <tr>
        <td>g.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:170px">Ganti Rugi (Ta’widh)  </td>
            <td>: Rp. <?php echo $display_ganti_rugi ?>,- per hari ( 1/1000) % dari Pokok 
              Pembiayaan)</td>
          </tr>
        </table>
        </div></td>
      </tr>
  </table>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 2<br>PELAKSANAAN PRINSIP MUSYARAKAH</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Pelaksanaan prinsip Musyarakah yang berlangsung antara <strong>PIHAK PERTAMA&nbsp;</strong> dengan <strong>PIHAK KEDUA&nbsp;</strong> dilaksanakan berdasarkan ketentuan Syariah dan diatur menurut ketentuan-ketentuan dan persyaratan sebagai berikut:
      </div></td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Kedua belah pihak akan melaksanakan transaksi Pembiayaan Musyarakah menurut ketentuan peraturan perundang-undangan yang berlaku di Indonesia dan ketentuan Syariah yang berlaku bagi koperasi. 
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Kedua belah pihak bersedia bekerjasama dalam bentuk usaha patungan untuk membiayai usaha tertentu yang halal dan produktif. 
      </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Pendapatan dari usaha kerjasama patungan tersebut, dibagi sesuai dengan Nisbah Bagi Hasil yang disepakati.
      </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Kerugian Usaha ditanggung bersama oleh <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> secara proporsional sesuai dengan kontribusi Modal Musyarakah. 
      </div></td>
    </tr>
    <tr>
      <td>5.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Biaya operasional usaha kerjasama patungan dibebankan pada Modal Musyarakah.
      </div></td>
    </tr>
  </table>
  </div>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 3<br>SYARAT REALISASI PEMBIAYAAN MUSYARAKAH</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
      <strong>PIHAK PERTAMA&nbsp;</strong> akan merealisasikan Pembiayaan berdasarkan prinsip Musyarakah  sesuai dengan Akad ini, setelah <strong>PIHAK KEDUA&nbsp;</strong> terlebih dahulu memenuhi seluruh persyaratan sebagai berikut:
      </div></td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Menyerahkan kepada <strong>PIHAK PERTAMA&nbsp;</strong> seluruh dokumen yang disyaratkan oleh <strong>PIHAK PERTAMA&nbsp;</strong> termasuk tetapi tidak terbatas pada dokumen bukti diri <strong>PIHAK KEDUA&nbsp;</strong>, dan/atau surat lainnya yang berkaitan dengan Akad ini, yang ditentukan dalam Surat Pemberitahuan Persetujuan Pemberian Pembiayaan (SP3) dari <strong>PIHAK PERTAMA&nbsp;</strong>;
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      <strong>PIHAK KEDUA&nbsp;</strong> wajib membuka dan memelihara rekening tabungan nomor <?php echo $cetak['nomor_rekening'] ?> pada <?php echo $cetak['nama_bank'] ?> atas nama <?php echo $cetak['atasnama_rekening'] ?> Kantor Kas <?php echo $cetak['bank_cabang'] ?> selama <strong>PIHAK KEDUA&nbsp;</strong> mempunyai Pembiayaan Musyarakah dari <strong>PIHAK PERTAMA&nbsp;</strong>;
      </div></td>
    </tr>
  </table>
  </div>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 4<br>PENARIKAN MODAL MUSYARAKAH </td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
      <strong><strong>PIHAK PERTAMA&nbsp;</strong> </strong> akan merealisasikan pembiayaan berdasarkan prinsip Murabahah sesuai dengan Akad ini, setelah <strong><strong>PIHAK KEDUA&nbsp;</strong> </strong> terlebih dahulu memenuhi seluruh persyaratan sebagai berikut: 
      </div></td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Penarikan Modal Musyarakah dilakukan secara bertahap ataupun sekaligus sesuai kebutuhan dan permintaan <strong>PIHAK KEDUA&nbsp;</strong>, sesudah syarat-syarat realisasi telah dipenuhi oleh <strong>PIHAK KEDUA&nbsp;</strong>.
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Dalam hal <strong>PIHAK PERTAMA&nbsp;</strong> telah memberikan sebagian atau seluruh dana Pembiayaan Musyarakah kepada <strong>PIHAK KEDUA&nbsp;</strong>, maka <strong>PIHAK KEDUA&nbsp;</strong> dengan ini menyatakan dan mengakui mempunyai kewajiban atau Utang Musyarakah berdasarkan Akad ini.
      </div></td>
    </tr>
  </table>
  </div>
  <!-- <p align="right">pasal 5/....</p> -->
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" align="center">PASAL 5<br>JATUH TEMPO PEMBIAYAAN MUSYARAKAH</td>
    </tr>
    <tr>
      <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
        Berakhirnya jatuh tempo Pembiayaan tidak dengan sendirinya menyebabkan Utang Musyarakah lunas sepanjang masih terdapat sisa Utang Musyarakah  <strong>PIHAK KEDUA&nbsp;</strong>. 
      </div></td>
    </tr>
  </table>
  </div>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 6<br>PEMBAYARAN KEMBALI</td>
      </tr>
      <tr>
        <td>1.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        <strong>PIHAK KEDUA&nbsp;</strong> wajib mengembalikan kepada <strong>PIHAK PERTAMA&nbsp;</strong> seluruh Modal Musyarakah <strong>PIHAK PERTAMA&nbsp;</strong>, dan menyerahkan keuntungan yang menjadi hak <strong>PIHAK PERTAMA&nbsp;</strong> sampai lunas sesuai dengan Nisbah Bagi Hasil menurut jadwal pembayaran.
        </div></td>
      </tr>
      <tr>
        <td>2.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        Apabila <strong>PIHAK KEDUA&nbsp;</strong> membayar kembali atau melunasi Modal Musyarakah  <strong>PIHAK PERTAMA&nbsp;</strong> lebih awal dari waktu yang diperjanjikan, maka tidak berarti pembayaran tersebut akan menghapus atau mengurangi bagian dari Pendapatan yang menjadi hak <strong>PIHAK PERTAMA&nbsp;</strong> sebagaimana telah di tetapkan dalam Akad ini.
        </div></td>
      </tr>
    </table>
  </div>
  <br>  
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="font-weight:bold;" align="center">PASAL 7<br>GANTI RUGI (TA’WIDH)</td>
      </tr>
      <tr>
        <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
          Utang Musyarakah  <strong>PIHAK KEDUA&nbsp;</strong> yang tidak dilunasi selambat-lambatnya pada saat jatuh tempo akan dikenakan Ganti Rugi (Ta’widh) yang besarnya sebagaimana diatur dalam Pasal 1 huruf g. 
        </div></td>
      </tr>
    </table>
  </div>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="font-weight:bold;" colspan="2" align="center">PASAL 8<br>PENUNJUKAN DAN KEWAJIBAN <strong>PIHAK KEDUA&nbsp;</strong> SEBAGAI PENGELOLA</td>
      </tr>
      <tr>
        <td>1.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        PARA PIHAK sepakat menunjuk <strong>PIHAK KEDUA&nbsp;</strong> sebagai pengelola usaha kerjasama patungan yang dibiayai bersama, dan <strong>PIHAK KEDUA&nbsp;</strong> menyatakan menerima penunjukan tersebut.
        </div></td>
      </tr>
      <tr>
        <td>2.</td>
        <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
        Kewajiban <strong>PIHAK KEDUA&nbsp;</strong> sebagai pengelola adalah sebagai berikut:
        <table cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:20px;">a.</td>
            <td><div style="width:555px;text-align:justify;text-justify:inter-word;">
            Menjalankan kerjasama usaha (syirkah) sebagaimana kebijakan-kebijakan yang telah ditetapkan dan disetujui kedua belah pihak dan sesuai dengan prinsip Syariah.
            </div></td>
          </tr>
          <tr>
            <td>b.</td>
            <td><div style="width:555px;text-align:justify;text-justify:inter-word;">
            Bertindak untuk mewakili <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> sebagai Mitra Musyarakah (Musyarik), didalam maupun di luar pengadilan pada saat berhadapan dengan pihak ketiga untuk kepentingan kerjasama usaha (syirkah).
            </div></td>
          </tr>
        </table>
        </div></td>
      </tr>
    </table>
  </div>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="font-size:11px;line-height:15px;font-weight:bold;" align="center">PASAL 9<br>PENGAWASAN </td>
      </tr>
      <tr>
        <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
          <strong>PIHAK PERTAMA&nbsp;</strong> dan/atau pihak lain yang ditunjuk oleh <strong>PIHAK PERTAMA&nbsp;</strong> berhak untuk memeriksa pembukuan <strong>PIHAK KEDUA&nbsp;</strong> dan segala sesuatu yang berhubungan dengan Pembiayaan Musyarakah yang diterima oleh <strong>PIHAK KEDUA&nbsp;</strong> dari <strong>PIHAK PERTAMA&nbsp;</strong> berdasarkan Akad ini, baik secara langsung atau tidak langsung dan/atau melakukan tindakan-tindakan pengawasan lainnya untuk mengamankan kepentingan <strong>PIHAK PERTAMA&nbsp;</strong>.
        </div></td>
      </tr>
    </table>
  </div>
  <br>
  <div style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
    <table style="font-size:11px;line-height:15px;">
      <tr>
        <td style="font-size:11px;line-height:15px;font-weight:bold;" align="center">PASAL 10<br>ASURANSI</td>
      </tr>
      <tr>
        <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
          Selama jangka waktu Pembiayaan Musyarakah atau seluruh Modal Musyarakah <strong>PIHAK PERTAMA&nbsp;</strong> dan kewajiban lainnya belum dilunasi, <strong>PIHAK KEDUA&nbsp;</strong> wajib menutup asuransi pelaksanaan pekerjaan yang dijaminkan pada perusahaan asuransi dan premi asuransinya menjadi beban <strong>PIHAK KEDUA&nbsp;</strong>.
        </div></td>
      </tr>
    </table>
    <!-- <p align="right">pasal 11/....</p> -->
  </div>
<br>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" align="center">PASAL 11<br><strong>PIHAK KEDUA&nbsp;</strong>  CIDERA JANJI</td>
    </tr>
    <tr>
      <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
        <strong>PIHAK KEDUA&nbsp;</strong> dinyatakan cidera janji apabila tidak memenuhi dengan baik kewajiban-kewajibannya atau melanggar ketentuan-ketentuan di dalam Akad ini.
      </div></td>
    </tr>
  </table>
</div>
  <br>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 12<br>PENAGIHAN SEKETIKA SELURUH UTANG MUSYARAKAH  </td>
    </tr>
    <tr>
      <td align="left"><div style="width:590px;text-align:justify;text-justify:inter-word;">
        Menyimpang dari jangka waktu Pembiayaan, <strong>PIHAK PERTAMA&nbsp;</strong> berhak mengakhiri jangka waktu Pembiayaan Musyarakah dan menagih pelunasan sekaligus atas seluruh sisa Utang Musyarakah dan <strong>PIHAK KEDUA&nbsp;</strong> wajib membayar dengan seketika dan melunasi sekaligus atas sisa Utang Musyarakah atau <strong>PIHAK PERTAMA&nbsp;</strong> berhak melakukan upaya-upaya hukum lain untuk menyelesaikan Pembiayaan Musyarakah sesuai Akad ini, apabila <strong>PIHAK KEDUA&nbsp;</strong> cidera janji.
      </div></td>
    </tr>
  </table>
</div>
  <br>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 13<br>FORCE MAJEURE (KEADAAN KAHAR)</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Dalam hal terjadi Force Majeure, maka pihak yang terkena akibat langsung dari Force Majeure tersebut wajib memberitahukan secara tertulis dengan melampirkan bukti-bukti dari instansi yang berwenang kepada pihak lainnya mengenai peristiwa Force Majeure tersebut dalam waktu selambat-lambatnya 14 (empat belas) hari kerja terhitung sejak tanggal Force Majeure terjadi.
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Keterlambatan atau kelalaian pihak yang mengalami Force Majeure untuk memberitahukan adanya Force Majeure tersebut kepada pihak lainnya mengakibatkan tidak diakuinya peristiwa tersebut sebagai Force Majeure. 
      </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Seluruh permasalahan yang timbul akibat terjadinya Force Majeure akan diselesaikan oleh <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> secara musyawarah untuk mufakat. Hal tersebut tanpa mengurangi hak-hak <strong>PIHAK PERTAMA&nbsp;</strong> sebagaimana diatur dalam Akad ini.
      </div></td>
    </tr>
  </table>
</div>
  <br>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 14<br>HUKUM YANG BERLAKU </td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Pelaksanaan Akad ini tunduk kepada ketentuan perundang-undangan yang berlaku di Indonesia dan ketentuan Syariah yang berlaku bagi <strong>PIHAK PERTAMA&nbsp;</strong>
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Apabila di kemudian hari terjadi perselisihan dalam penafsiran atau pelaksanaan ketentuan-ketentuan dari Akad ini, maka para pihak sepakat untuk terlebih dahulu menyelesaikan secara musyawarah. 
      </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Bilamana musyawarah tidak menghasilkan kata sepakat mengenai penyelesaian perselisihan, maka semua sengketa yang timbul dari Akad ini akan diselesaikan dan diputus oleh Badan Arbitrase Syariah Nasional (BASYARNAS) yang keputusannya mengikat kedua belah pihak yang bersengketa, sebagai keputusan tingkat pertama dan terakhir. 
      </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Mengenai pelaksanaan (eksekusi) putusan BASYARNAS, sesuai dengan ketentuan Undang-undang tentang Arbitrase dan Alternatif Penyelesaian Sengketa, PARA PIHAK sepakat bahwa <strong>PIHAK PERTAMA&nbsp;</strong> dapat meminta pelaksanaan (eksekusi) putusan BASYARNAS tersebut pada setiap Pengadilan Negeri di wilayah hukum Republik Indonesia. 
      </div></td>
    </tr>
  </table>
</div>
  <br>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  <table style="font-size:11px;line-height:15px;">
    <tr>
      <td style="font-size:11px;line-height:15px;font-weight:bold;" colspan="2" align="center">PASAL 15<br>PENUTUP</td>
    </tr>
    <tr>
      <td>1.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Segala sesuatu yang belum diatur atau perubahan dalam Akad ini akan diatur dalam surat-menyurat dan/atau addendum berdasarkan kesepakatan bersama antara <strong>PIHAK PERTAMA&nbsp;</strong> dan <strong>PIHAK KEDUA&nbsp;</strong> yang merupakan bagian yang tidak terpisahkan dari Akad ini.
      </div></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Lampiran-lampiran Akad ini (jika ada) merupakan bagian yang tidak terpisahkan dari Akad ini serta wajib dipatuhi oleh <strong>PIHAK KEDUA&nbsp;</strong> sebagaimana mestinya. 
      </div></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Uraian Pasal demi Pasal dalam Akad ini, telah dibaca, dimengerti dan dipahami serta disetujui oleh <strong>PIHAK KEDUA&nbsp;</strong> dan <strong>PIHAK PERTAMA&nbsp;</strong>.
      </div></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><div style="width:580px;text-align:justify;text-justify:inter-word;">
      Akad ini mulai berlaku sejak tanggal ditandatanganinya.
      </div></td>
    </tr>
  </table>
</div>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
  Demikian Akad ini dibuat dan ditandatangani oleh PARA PIHAK di atas materai cukup dalam rangkap 2 (dua) yang mempunyai kekuatan hukum yang sama.
</div>
  <br><br>
</div>
<div  style="margin-left:70px;width:610px;font-size:11px;line-height:15px;">
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
        <span style="text-decoration:underline;"><?php echo $cetak['ketua_pengurus'];?>&nbsp;</span>
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
<div style="margin-left:70px;width:610px;">
  <table style="font-size:11px;line-height:15px;" align="center">
    <tr>
      <td colspan="3" align="center">JADWAL PENCAIRAN PEMBIAYAAN<br>PER-TERMIN<br><br>&nbsp;</td>
    </tr>
    <tr>
      <td>NAMA KONSUMEN</td>
      <td>:</td>
      <td><?php echo $cetak['nama'];?></td>
    </tr>
    <tr>
      <td>Besarnya Pokok Pembiayaan</td>
      <td>:</td>
      <td><?php echo number_format($cetak['pokok']);?></td>
    </tr>
    <tr>
      <td>Jangka Waktu (Bulan)</td>
      <td>:</td>
      <td><?php echo $cetak['jangka_waktu'];?> bulan</td>
    </tr>
  </table>
</div>
</page>
<table style="margin-top:15px;font-size:11px;line-height:15px;" cellpadding="0" cellspacing="0" align="center">
  <thead>
    <tr>
      <th align="center" style="width:50px;border:0.5px solid #000; padding:5px; font-size:11px;">Termin&nbsp; </th>
      <th align="center" style="width:100px;border:0.5px solid #000; padding:5px; font-size:11px;">Jumlah&nbsp; </th>
      <th align="center" style="width:150px;border:0.5px solid #000; padding:5px; font-size:11px;">Tgl. Rencana Pencairan&nbsp; </th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $total_nominal = 0;
    for ($i=0; $i < count($termin) ; $i++){
      $tgl_rencana_pencairan = date('d',strtotime($termin[$i]['tgl_rencana_pencairan'])).' '.$month[(int)date('m',strtotime($termin[$i]['tgl_rencana_pencairan']))].' '.date('Y',strtotime($termin[$i]['tgl_rencana_pencairan']));
      $total_nominal += $termin[$i]['nominal'];
    ?>
    <tr>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"><?php echo $termin[$i]['termin']; ?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($termin[$i]['nominal'],0,',','.');?></td>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;"><?php echo $tgl_rencana_pencairan ?></td>
    </tr>
    <?php }?>
    <tr>
      <td>&nbsp;</td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:11px; font-weight:bold;">Rp. <?php echo number_format($total_nominal,0,',','.');?></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<!-- END TERMIN -->
<page>
<div style="margin-left:70px;width:610px;">
  <table style="font-size:11px;line-height:15px;" align="center">
    <tr>
      <td colspan="3" align="center">JADWAL ANGSURAN PEMBIAYAAN KOMERSIAL<br><br>&nbsp;</td>
    </tr>
    <tr>
      <td>NAMA KONSUMEN</td>
      <td>:</td>
      <td><?php echo $cetak['nama'];?></td>
    </tr>
    <tr>
      <td>Besarnya Pokok Pembiayaan</td>
      <td>:</td>
      <td><?php echo number_format($cetak['pokok']);?></td>
    </tr>
    <tr>
      <td>Jangka Waktu (Bulan)</td>
      <td>:</td>
      <td><?php echo $cetak['jangka_waktu'];?> bulan</td>
    </tr>
  </table>
</div>
</page>
<table style="margin-top:15px;font-size:11px;line-height:15px;" cellpadding="0" cellspacing="0" align="center">
  <thead>
    <tr>
      <th align="center" rowspan="2" style="width:50px;border:0.5px solid #000; padding:5px; font-size:11px;">Angs. Ke&nbsp; </th>
      <th align="center" rowspan="2" style="width:140px;border:0.5px solid #000; padding:5px; font-size:11px;">Tgl. Jatuh Tempo&nbsp; </th>
      <th align="center" colspan="3" style="border:0.5px solid #000; padding:5px; font-size:11px;">ANGSURAN</th>
      <th align="center" rowspan="2" style="border:0.5px solid #000; padding:5px; font-size:11px;">Saldo Pokok<br> Pembiayaan</th>
    </tr>
    <tr>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:11px;">POKOK</th>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:11px;">MARGIN</th>
      <th align="center" style="border:0.5px solid #000; padding:5px; font-size:11px;">JUMLAH</th>
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

      $tangga_jtempo = date('d',strtotime($jadwal_angsuran[($i-1)]['tangga_jtempo'])).' '.$month[(int)date('m',strtotime($jadwal_angsuran[($i-1)]['tangga_jtempo']))].' '.date('Y',strtotime($jadwal_angsuran[($i-1)]['tangga_jtempo']));
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
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"><?php echo $tangga_jtempo ?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($angs_pokok,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($angs_margin,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($total_angsuran,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;">Rp. <?php echo number_format($sisa_pokok,0,',','.');?></td>
    </tr>
    <?php }?>
    <tr>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"></td>
      <td align="center" style="border:0.5px solid #000; padding:3px; font-size:10px;"></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Tangs_pokok,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Tangs_margin,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px; font-weight:bold;">Rp. <?php echo number_format($Ttotal_angsuran,0,',','.');?></td>
      <td align="right" style="border:0.5px solid #000; padding:3px; font-size:10px; padding-left:10px;"></td>
    </tr>
  </tbody>
</table>
<!-- </div> -->