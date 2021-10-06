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
?> 

<!-- <div style="margin-left:70px;width:610px;"> -->
<page>
<div  style="margin-left:70px;width:610px;">
  <div align="center" style="font-size:13px;width:610px;">
    <strong>
    <?php if (strtolower($cetak['agama'])=='islam'){ ?>
      BISMILLAHIRRAHMAANIRRAHIM
    <?php }else{?>
      DENGAN NAMA TUHAN YANG MAHA ESA
    <?php }?>
    <br>
    <br><span style="text-decoration:underline;">PERJANJIAN PEMBIAYAAN&nbsp;&nbsp;</span>
    <?php if($cetak['akad_no']=='0'){ ?>
      <br>Nomor  : <?php echo $cetak['product_code'].$cetak['registration_no'];?>/<?php echo $seri_surat;?>/<?php echo date("Y");?>
    <?php }else{?>
      <br>Nomor  : <?php echo $cetak['product_code'].$cetak['akad_no'];?>/<?php echo $seri_surat;?>/<?php echo date("Y");?>
    <?php }?>
    </strong>
  </div>
<br><br><br>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
      Pada hari ini <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))];?> tanggal <?php $date=date('d',strtotime($cetak['tanggal_akad'])); $tgl = ($date<10) ? str_replace('0','',$date) : $date ; echo Terbilang($tgl);?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo Terbilang(date('Y',strtotime($cetak['tanggal_akad'])));?>, bertempat di Jalan Ciwulan Nomor 23 Bandung, antara pihak-pihak :
  </div>
<br><br>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
    <table>
      <tr>
        <td>I</td>
        <td>Nama / NIK</td>
        <td>: <strong><?php if(isset($pejabat_nama)) echo $pejabat_nama; if(isset($pejabat_nik)) echo ' / '.$pejabat_nik; ?> </strong></td>
      </tr>
      <tr>
        <td></td>
        <td>Jabatan </td>
        <td>: <strong><?php if(isset($pejabat_jabatan)) echo $pejabat_jabatan;?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td>Alamat </td>
        <td>:<strong> <?php if(isset($pejabat_alamat)) echo $pejabat_alamat;?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><div style="width:580px;margin-bottom:10px;">dalam hal ini bertindak dalam jabatannya oleh karena itu sah mewakili Pengurus Koperasi PT. Telekomunikasi Indonesia ( KOPTEL ), yang didirikan dengan Akta Pendirian Nomor 8307 tanggal 21 Nopember 1990, yang telah disahkan oleh Direktur Jenderal Bina Lembaga Koperasi Nomor 29/KEP/BLK/XI/1990 tanggal 21 Nopember 1990  dan terakhir telah diadakan perubahan dengan Akta Perubahan Anggaran Dasar Koperasi PT Telekomunikasi Indonesia (KOPTEL) No. 05 tanggal 21 Februari 2012 yang dibuat oleh Notaris Pembuat Akta Koperasi (NP. Akta) dan Pejabat Pembuat Akta Tanah (PPAT) Dian Gandirawati, SH. yang telah disahkan berdasarkan Keputusan Kementerian Koperasi dan Usaha Kecil dan Menengah Republik Indonesia Nomor : 165/PAD/M.KUKM.2/III/2012 tanggal 29 Maret 2012, berkedudukan di Jalan Ciwulan Nomor 23 Bandung, selanjutnya dalam perjanjian ini disebut sebagai PIHAK PERTAMA;</div></td>
      </tr>
      <tr>
        <td>II.</td>
        <td>Nama</td>
        <td>:<strong> <?php echo $cetak['nama'];?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td>NIK.</td>
        <td>:<strong> <?php echo $cetak['cif_no'];?>.</strong></td>
      </tr>
      <tr>
        <td></td>
        <td>Pekerjaan</td>
        <td>:<strong> Karyawan PT. TELKOM<br>&nbsp;&nbsp;<?php echo $cetak['loker'];?><br>&nbsp;&nbsp;<?php echo $cetak['code_divisi'];?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td>Alamat</td>
        <td>:<div style="width:500px"><strong> <?php echo $cetak['alamat'];?></strong></div></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">dalam hal ini bertindak untuk dan nama pribadi yang selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK KEDUA</strong>;</td>
      </tr>
    </table>
  </div>
<br>
  <div style="font-size:11px;width:610px;padding-top:10px;text-align:justify;text-justify:inter-word;">
    dengan terlebih dahulu mempertimbangkan hal-hal sebagai berikut  : 
    <br>
    <br>
    <table>
      <tr>
        <td>a.</td>
        <td><div style="width:580px;">Peraturan Perusahaan (PERSERO) PT Telekomunikasi Indonesia Tbk, Nomor: PR.202.04/r.00/PS560/COP-B0013000/2011 tanggal 26 Agustus 2011 tentang Penyempurnaan Aturan Yang Terkait Dengan Sistem Remunerasi Pasca PKB IV;</div></td>
      </tr>
      <tr>
        <td>b.</td>
        <td><div style="width:580px;">Peraturan Perusahaan Direktur Human Capital & General Affairs Perusahaan Perseroan (PERSERO) PT Telekomunikasi Indonesia Tbk Nomor: PR.202.06/r.00/PS620/COP-B0013000/2012 tanggal 8 Februari 2012 tentang Pemanfaatan Tabungan Wajib Perumahan Karyawan</div></td>
      </tr>
      <tr>
        <td>c.</td>
        <td><div style="width:580px;">bahwa sesuai dengan Keputusan Pengurus Koperasi PT. Telekomunikasi Indonesia, Tbk  (KOPTEL) Nomor : SK. 153/HK340/PK/2010 tanggal 18 Mei 2010 tentang Perubahan Prosedur Pemberian Kredit Renovasi Rumah (KRR) dan Kredit Multiguna (KMG) dan Surat Edaran No : 29/YAN-000/PK/2011 tanggal 24 Januari 2011 tentang Penetapan Marjin, Jangka Waktu dan Biaya Administrasi Pemberian Kredit Multiguna (KMG) bahwa salah satu bentuk pengembangan KOPTEL adalah memberikan  Kredit Multiguna (KMG) bagi karyawan PT. Telkom;</div></td>
      </tr>
    </table>
  </div>
<br>
  <div align="center" style="font-size:11px;width:610px;padding-top:7px;font-weight:bold;">
    Pasal 1
    <br>Pengakuan Pembiayaan Beserta Besarnya
  </div>
  <table style="font-size:11px;">
    <tr>
      <td colspan="3">
        <div style="float:left;width:600px;margin-bottom:10px;" >PIHAK KEDUA menerangkan bahwa benar-benar dan dengan sah berutang kepada PIHAK PERTAMA posisi pada hari Selasa tanggal tiga bulan Juni tahun dua ribu empat belas dengan ketentuan-ketentuan pokok akad sebagai berikut :</div>
      </td>
    </tr>
    <tr>
      <td>1.</td>
      <td>Jenis Pembiayaan</td>
      <td>: <strong>Kredit Multiguna (KMG)</strong></td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Jumlah Pembiayaan</td>
      <td>: <strong>Rp. <?php echo number_format($cetak['pokok']);?></strong></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Total Margin</td>
      <td>: <strong>Rp. <?php echo number_format($cetak['margin']);?></strong></td>
    </tr>
    <tr>
      <td>4.</td>
      <td>Jumlah Pengembalian</td>
      <td>: <strong>Rp. <?php echo number_format(($cetak['pokok']+$cetak['margin']));?></strong></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Tujuan Pembiayaan</td>
      <td>: <strong><?php echo $cetak['display_text'];?></strong></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Angsuran per bulan</td>
      <td>: <strong>Rp. <?php $angs = ($cetak['pokok']+$cetak['margin'])/$cetak['jangka_waktu']; echo number_format($angs);?></strong></td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Jangka waktu pembiayaan</td>
      <td>: <strong><?php echo $cetak['jangka_waktu'];?> bulan</strong></td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Jaminan Pembiayaan</td>
      <td>: Sertifikat Tanah dan  Bangunan</td>
    </tr>
  </table>
  <p align="right">Pasal 2/....</p>
</div>
</page>
<page>
<div  style="margin-left:70px;width:610px;">
  <table>
    <tr>
      <td style="width:20px;font-size:11px;font-weight:bold;" colspan="2" align="center">Pasal 2<br>Penyerahan Jaminan</td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          PIHAK KEDUA menjaminkan tanah seluas <?php echo number_format($J_luas_tanah);?> m2 (<?php echo Terbilang($J_luas_tanah);?> meter persegi) sebagaimana dimaksud dalam Sertipikat Hak Milik No. <?php echo $J_nomor_jaminan;?> terletak di Propinsi <?php echo $J_provinsi;?> Kota <?php echo $J_kota;?> Kecamatan <?php echo $J_kecamatan;?> Kelurahan <?php echo $J_kelurahan;?> atas nama <?php echo $J_atas_nama;?> yang berlokasi di <?php echo $J_alamat;?> serta Bangunan Rumah yang berdiri diatasnya, atas Pembiayaan KMG yang diterimanya, dengan menyerahkan Sertifikat Tanah dan Bangunan kepada PIHAK PERTAMA melalui NOTARIS/PPAT rekanan KOPTEL yang saat ini sedang dalam proses pengurusan/penyelesaian;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          Terhadap jaminan atas nama PIHAK KEDUA sebagaimana dimaksud ayat (1) Pasal ini, dilaksanakan pengikatan hak tanggungan yang disahkan oleh Notaris.
        </div>
      </td>
    </tr>
  </table>
  <div align="center" style="font-size:11px;width:610px;padding-top:7px;font-weight:bold;">
    Pasal 3
    <br>Pelaksanaan Pembayaran Angsuran
  </div>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          (1) PIHAK KEDUA akan membayar Angsuran paling lambat tanggal 25 (dua puluh lima) untuk setiap bulan terhitung bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_mulai_angsur']))] ?> <?php echo date('Y',strtotime($cetak['tanggal_akad']));?> kepada PIHAK PERTAMA yang besarnya sebagaimana dimaksud dalam lampiran Pasal 3 ayat (3) di atas;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          (2) 
          Untuk memenuhi persyaratan 40% THP sesuai peraturan yang berlaku maka PIHAK KEDUA memberi kuasa kepada PIHAK PERTAMA agar semua pembayaran dimaksud ayat 1 Pasal ini, dipotong melalui Payroll atas nama PIHAK KEDUA.
        </div>
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;font-weight:bold;" colspan="2" align="center">Pasal 4<br>Sanksi</td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          Apabila pada tanggal sebagaimana dimaksud dalam Pasal 4 ayat (1), PIHAK KEDUA tidak melaksanakan kewajibannya, maka untuk setiap hari kelambatan pembayaran tersebut akan dikenakan sanksi denda sebesar 0,15 % (15/100 prosen) dari jumlah kewajiban angsuran bulanan pada bulan yang bersangkutan diperhitungkan dari hari ke hari;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          kewajiban angsuran bulanan pada bulan yang bersangkutan diperhitungkan dari hari ke hari;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(3)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          Apabila setelah 3 (tiga) bulan berturut-turut, PIHAK KEDUA tidak melaksanakan kewajibannya, maka dengan berlalunya waktu tersebut, PIHAK PERTAMA tanpa harus memperoleh persetujuan terlebih dahulu dari PIHAK KEDUA mempunyai hak untuk mengambil tindakan sebagai berikut :
          <table>
            <tr>
              <td>a.</td>
              <td>
                  <div style="float:left;width:530px;">
                  Memotong secara langsung hak-hak yang seharusnya diperoleh PIHAK KEDUA dari PT. TELKOM berupa gaji bulanan, insentif dan hak lainnya termasuk BFPT (Biaya Fasilitas Perumahan Terakhir), MPS (Manfaat Pensiun Sekaligus), BPP (Biaya Perjalanan Pensiun), Purnabhakti (THT) Tunjangan Hari Tua dan dana Tabungan Wajib Perumahan.
                  </div>
              </td>
            </tr>
            <tr>
              <td>b.</td>
              <td>
                  <div style="float:left;width:530px;">
                    Menyita dan menjual Tanah dan Bangunan yang dijaminkan kepada PIHAK PERTAMA;
                  </div>
              </td>
            </tr>
            <tr>
              <td>c.</td>
              <td>
                  <div style="float:left;width:530px;">
                  Hasil dari penjualan tersebut akan dibayarkan kepada PIHAK KEDUA setelah dipotong saldo Pembiayaan dan biaya-biaya lain yang ditimbulkannya;
                  </div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;font-weight:bold;" colspan="2" align="center">Pasal 5<br>Penyelesaian Perselisihan</td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          Apabila dikemudian hari terjadi perselisihan dalam penafsiran dan atau pelaksanaan ketentuan-ketentuan dalam Perjanjian ini, PIHAK PERTAMA dan PIHAK KEDUA sepakat untuk menyelesaikan secara musyawarah;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;">
          Apabila musyawarah tersebut pada ayat (1) pasal ini tidak menghasilkan kata sepakat, maka PIHAK PERTAMA dan PIHAK KEDUA sepakat untuk menyerahkan penyelesaiannya kepada Kantor Pengadilan Negeri Bandung;
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;font-weight:bold;" colspan="2" align="center">Pasal 6<br>Lain-lain</td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          PIHAK KEDUA bersedia untuk mengalihkan Pembiayaan ke Bank dan tidak dapat menuntut apapun kepada PIHAK PERTAMA apabila PIHAK PERTAMA mengalihkan Pembiayaan tersebut kepada Bank;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          PIHAK KEDUA bersedia untuk mengalihkan Pembiayaan ke dalam sistem syariah, apabila PIHAK PERTAMA telah menggunakan sistem syariah;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(3)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Apabila sampai tanggal jatuh tempo akhir pembiayaan, PIHAK KEDUA belum melunasi, maka PIHAK PERTAMA akan memperhitungkannya dengan Hak-hak PIHAK KEDUA yang ada di PT. TELKOM;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(4)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Apabila PIHAK KEDUA berhenti atau diberhentikan sebagai karyawan  PT. TELKOM atau meninggal dunia dan masih mempunyai angsuran/kewajiban yang belum terselesaikan kepada PIHAK PERTAMA, maka PIHAK KEDUA dan/atau Suami/Istri/Ahli Waris memberi kuasa kepada KOPTEL untuk memotongkan hak-hak PIHAK KEDUA dan/atau Suami/Istri/Ahli Waris yang ada di PT. TELKOM, sebesar cicilan/kewajiban yang belum terselesaikan, antara lain: Bantuan Fasilitas Perumahan Terakhir (BFPT), Manfaat Pensiun Bulanan, Manfaat Pensiun Sekaligus (MPS), Penghargaan Pengabdian Purnabhakti dan Perjalanan Pensiun serta hak-hak lainnya dari PT. TELKOM.;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(5)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Apabila PIHAK KEDUA berhenti atau diberhentikan sebagai karyawan  PT. TELKOM atau meninggal dunia  dan masih mempunyai angsuran/kewajiban yang belum terselesaikan kepada PIHAK PERTAMA, maka PIHAK KEDUA dan atau suami / istri meminta kepada DAPENTEL untuk memotong / membayarkan hak PIHAK KEDUA dan atau suami / istri / ahli waris yang berupa Tunjangan Hari Tua (THT) dan manfaat pensiun bulanan sebesar kewajiban PIHAK KEDUA kepada KOPTEL yang ditentukan oleh KOPTEL;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(6)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Apabila PIHAK KEDUA meninggal dunia, maka seluruh sisa saldo Pembiayaan akan dibayar oleh Pihak Asuransi yang ditunjuk oleh PIHAK PERTAMA, sepanjang memenuhi persyaratan klaim;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;" colspan="2" align="right">(7) Setelah....</td>
    </tr>
  </table>
</div>
</page>
<page>
<div  style="margin-left:70px;width:610px;">
  <table>
    <tr>
      <td style="width:20px;font-size:11px;">(7)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Setelah klaim asuransi dibayar oleh Pihak Asuransi kepada PIHAK PERTAMA, maka PIHAK PERTAMA berkewajiban untuk mengembalikan hasil klaim asuransi kepada Ahli Waris PIHAK KEDUA;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(8)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          PIHAK PERTAMA bersedia menyerahkan Sertifikat Tanah dan Bangunan  serta Surat-Surat lainnya  kepada  PIHAK KEDUA apabila PIHAK KEDUA telah melunasi Saldo Pinjamannya;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(9)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Segala ketentuan-ketentuan dan syarat-syarat dalam perjanjian ini berlaku dan mengikat bagi pihak-pihak yang menandatangani dan pengganti-penggantinya;
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(10)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;">
          Perjanjian ini terdiri dari 6 Pasal, dibuat dalam rangkap 2 (dua) Asli di atas kertas yang bunyinya masing-masing sama dan mempunyai kekuatan hukum yang sama setelah ditandatangani di atas meterai oleh kedua belah pihak;
        </div>
      </td>
    </tr>
  </table>
  <br>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;">
    Demikian perjanjian ini dibuat dengan itikad baik untuk dipatuhi para pihak dan berlaku sejak tanggal ditandatanganinya perjanjian ini;
  </div>
  <br>
  <br>
  <br>
  <br>
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
        
    <!-- BEGIN SAKSI -->
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">SAKSI </td>
      <td>&nbsp;</td>
      <td align="center">Menyetujui</td>
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
        <?php $m = '<span style="text-decoration:underline;"> '.$nama_pasangan.' </span><br>'.$status_pasangan; echo $m; ?>
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
  <table align="center">
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
<table cellpadding="0" cellspacing="0" align="center">
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