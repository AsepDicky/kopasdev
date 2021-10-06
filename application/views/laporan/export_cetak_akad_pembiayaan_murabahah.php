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

?> 

<page>
<div style="margin-left:70px;width:610px;">
  <div align="center" style="font-size:13px;width:610px;">
    <?php if (strtolower($cetak['agama'])=='islam'){ ?>
      BISMILLAHIRRAHMAANIRRAHIM
    <?php }else{?>
      DENGAN NAMA TUHAN YANG MAHA ESA
    <?php }?>
  </div>
  <div align="center" style="font-size:12px;width:610px;padding-bottom:7px;border-bottom:1px solid #000;">
    PERJANJIAN PEMBERIAN PEMBIAYAAN MUROBAHAH  
    <br>ANTARA
    <br><?php if (strtolower($cetak['pengajuan_melalui'])=='koptel'){ ?><strong><?php echo $institution['institution_name'];?></strong> <?php }else{?> <strong><?php echo strtoupper($cetak['nama_kopegtel']);?></strong> <?php }?> 
    <br>DENGAN 
    <br>NAMA : <strong><?php echo $cetak['nama']."&nbsp;&nbsp;";?></strong> NIK. <strong><?php echo $cetak['cif_no']."&nbsp;&nbsp;";?></strong>
  </div>

  <div align="center" style="font-size:11px;width:610px;padding-top:7px;">
    <?php if($cetak['akad_no']=='0'){ ?>
      <br>Nomor  : <?php echo $cetak['product_code'].$cetak['registration_no'];?>/<?php echo $seri_surat;?>/<?php echo date("Y");?>
    <?php }else{?>
      <br>Nomor  : <?php echo $cetak['product_code'].$cetak['akad_no'];?>/<?php echo $seri_surat;?>/<?php echo date("Y");?>
    <?php }?>
  </div>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;line-height:14px;">
    Pada hari ini, <?php echo $array_hari[date('w',strtotime($cetak['tanggal_akad']))];?> tanggal <?php echo (int)date('d',strtotime($cetak['tanggal_akad'])); ?> bulan <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_akad']))] ?> tahun <?php echo date('Y',strtotime($cetak['tanggal_akad'])) ?> bertempat di Bandung <?php if($cetak['kopegtel_code']){echo " / ".$institution['alamat'];}?>, antara pihak-pihak :
  </div>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;line-height:14px;">
    <table>
      <tr>
        <td style="width:20px">I.</td>
        <td colspan="2">
        <?php if (strtolower($cetak['pengajuan_melalui'])=='koptel'){ ?><strong><?php echo $institution['institution_name'];?></strong> <?php }else{?> <strong><?php echo strtoupper($cetak['nama_kopegtel']);?></strong> <?php }?>  , yang diwakili oleh :
          </td>
      </tr>
      <tr>
        <td></td>
        <td>Nama / NIK.</td>
        <td style="font-weight:bold;">: <?php if(isset($pejabat_nama)) echo $pejabat_nama; if(isset($pejabat_nik)) echo ' / '.$pejabat_nik;?></td>
      </tr>
      <tr>
        <td></td>
        <td>Jabatan </td>
        <td style="font-weight:bold;">: <?php if(isset($pejabat_jabatan)) echo $pejabat_jabatan;?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK PERTAMA</strong>.</td>
      </tr>
      <tr>
        <td>II.</td>
        <td>Nama / NIK.</td>
        <td>: <?php echo $cetak['nama'];?> / NIK <?php echo $cetak['cif_no'];?>.</td>
      </tr>
      <tr>
        <td></td>
        <td>Band Posisi</td>
        <td>: <?php echo $cetak['band'];?></td>
      </tr>
      <tr>
        <td></td>
        <td>Unit Kerja</td>
        <td>: <?php echo $cetak['posisi'];?></td>
      </tr>
      <tr>
        <td></td>
        <td>Alamat</td>
        <td>: <?php echo $cetak['alamat'];?></td>
      </tr>
      <tr>
        <td></td>
        <td>No. Rekening</td>
        <td>: Pada Bank <strong><?php echo $cetak['nama_bank']."&nbsp;&nbsp;";?></strong> nomor  <strong><?php echo $cetak['no_rekening']."&nbsp;&nbsp;";?></strong> atas nama <strong><?php echo $cetak['atasnama_rekening'];?></strong></td>
      </tr>
      <tr>
        <td></td>
        <td>No Telepon</td>
        <td>: <?php echo $cetak['telpon_seluler'];?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK KEDUA</strong>  atau <strong>PEMBELI</strong>.</td>
      </tr>
    </table>
  </div>
<br>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;line-height:14px;">
    PIHAK PERTAMA dan PIHAK KEDUA telah bersepakat melakukan transaksi seperti yang diuraikan dalam pasal-pasal berikut ini : 
  </div>
<br>
  <div align="center" style="font-size:11px;width:610px;padding-top:7px;font-weight:bold;">
    Pasal 1
    <br>JUMLAH DAN SYARAT-SYARAT PEMBIAYAAN
  </div>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;" >PIHAK PERTAMA akan membayarkan sejumlah dana atas pembelian barang pada PIHAK KETIGA dan atau menguasakan pada PIHAK KEDUA untuk membeli sendiri dengan menyerahkan uang tunai sebesar Rp <?php echo number_format($pokok);?> untuk <?php echo strtoupper($cetak['display_text']);?> </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;" >
        PIHAK PERTAMA kemudian menjual barang yang dibeli kepada PIHAK KEDUA dengan margin bagi PIHAK PERTAMA sebesar Rp <?php echo number_format($margin);?>, sehingga nilai jual seluruhnya / total hutang PIHAK KEDUA sebesar Rp. <?php echo number_format($totalhutang);?> 
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(3)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;" >
          Pihak kedua sanggup membayar hingga lunas hutang tersebut kepada <strong>PIHAK PERTAMA</strong>  dengan mengangsur selama <?php echo $cetak['jangka_waktu'];?> <?php echo $periode_jangka_waktu;?> sebesar <?php echo number_format($totalangsuran);?> / <?php echo $periode_jangka_waktu;?> yang jatuh tempo setiap tanggal 25, mulai bulan  <?php echo $array_bulan[(int)date('m',strtotime($cetak['tanggal_mulai_angsur']))] ?> <!--  dengan rincian sebagai berikut :  -->
          <br>
          <!-- <table>
            <tr>
              <td>a.</td>
              <td>Angsuran pokok sebesar</td>
              <td>: <?php echo number_format($cetak['angsuran_pokok']);?></td>
            </tr>
            <tr>
              <td>b.</td>
              <td>Angsuran margin sebesar</td>
              <td>: <?php echo number_format($cetak['angsuran_margin']);?></td>
            </tr>
          </table> -->
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(4)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;" >Terhadap fasilitas pembiayaan ini, PIHAK KEDUA bersedia menyerahkan uang sejumlah Rp <?php echo number_format($biaya_administrasi);?> untuk pembayaran : 
          <br>
          <table>
            <tr>
              <td>a.</td>
              <td>Angsuran Bulan Pertama <?php echo number_format($totalangsuran);?></td>
            </tr>
            <tr>
              <td>b.</td>
              <td>Biaya Asuransi <?php echo number_format($cetak['biaya_asuransi_jiwa']);?></td>
            </tr>
            <tr>
              <td>c.</td>
              <td>Biaya Administrasi <?php echo number_format($cetak['biaya_administrasi']);?></td>
            </tr>
            <tr>
              <td>d.</td>
              <td>Biaya Notaris <?php echo number_format($cetak['biaya_notaris']);?> </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <div align="center" style="font-size:11px;width:610px;padding-top:7px;font-weight:bold;">
    Pasal 2
    <br>PENGEMBALIAN PEMBIAYAAN
  </div>
  <table>
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          PIHAK KEDUA menyetujui angsuran Pembiayaan dipotong melalui Payroll oleh unit HR Area yang bertalian hingga lunas
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          Apabila PIHAK KEDUA berhenti atau diberhentikan bekerja dari PT. TELKOM maka PIHAK KEDUA harus   menyelesaikan kewajibannya kepada PIHAK PERTAMA.
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(3)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          Apabila sampai dengan saat berhenti bekerja di PT. TELKOM masih mempunyai cicilan / kewajiban yang belum terselesaikan kepada KOPTEL, maka PIHAK KEDUA dan atau suami / istri sanggup untuk dikenakan pemotongan terhadap hak-hak  PIHAK KEDUA dan atau suami / istri yang ada di PT.TELKOM sebesar cicilan / kewajiban yang belum terselesaikan antara lain Bantuan Fasilitas Perumahan Terakhir (BPFT), Manfaat Pensiun Sekaligus (MPS), Purnabakti, Perjalanan Pensiun.
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(4)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
         Apabila sampai dengan saat  berhenti bekerja di PT. TELKOM masih mempunyai cicilan / kewajiban yang belum terselesaikan kepada KOPTEL atau meninggal dunia namun karena satu dan lain hal klaim asuransi tidak dilaksanakan, maka PIHAK KEDUA dan atau suami / istri meminta kepada DAPENTEL untuk memotong / membayarkan hak PIHAK KEDUA dan atau suami / istri / ahli waris yang berupa Tunjangan Hari Tua (THT) dan manfaat pensiun bulanan sebesar kewajiban PIHAK KEDUA kepada KOPTEL yang ditentukan oleh KOPTEL.
        </div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td align="right">Pasal 3..../</td>
    </tr>
  </table>
  </div>
  </page>
  <page>
  <div style="width:610px;">
  <div align="center" style="font-size:11px;width:610px;padding-top:7px;font-weight:bold;margin-left:70px;">
    Pasal 3
    <br>LAIN-LAIN
  </div>
  <table style="margin-left:70px;">
    <tr>
      <td style="width:20px;font-size:11px;">(1)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          PIHAK KEDUA bersedia untuk mengalihkan utangnya ke dalam sistem syariah, apabila PIHAK PERTAMA telah menggunakan sistem syariah
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(2)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          Segala ketentuan-ketentuan dan syarat-syarat dalam Perjanjian ini berlaku serta mengikat bagi pihak-pihak yang menandatangani dan pengganti-penggantinya.
        </div>
      </td>
    </tr>
    <tr>
      <td style="width:20px;font-size:11px;">(3)</td>
      <td style="font-size:11px;">
        <div style="float:left;width:570px;text-align:justify;text-justify:inter-word;line-height:14px;">
          Perjanjian ini dibuat dalam rangkap 2 (dua) ASLI, masing-masing sama bunyinya di atas kertas yang bermeterai cukup serta mempunyai kekuatan hukum yang sama setelah ditandatangani.
        </div>
      </td>
    </tr>
  </table>
  <br>
  <div style="font-size:11px;width:610px;padding-top:15px;text-align:justify;text-justify:inter-word;line-height:14px;margin-left:70px;">
    Demikian perjanjian ini dibuat dengan itikad baik untuk dipatuhi para pihak dan berlaku setelah ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA.
  </div>
  <br>
  <br>
  <br>
  <br>
  <table style="font-size:11px;font-weight:bold;margin-left:70px;">
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
      <td align="center" style="font-weight:normal;font-size:9px;">Materai Rp. 6.000,</td>
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
           <span style="text-decoration:underline;color:#000;"> <?php if(isset($pejabat_nama)) echo $pejabat_nama; if(isset($pejabat_nik)) echo ' / '.$pejabat_nik;?></span>        
        <br><?php if(isset($pejabat_jabatan)) echo $pejabat_jabatan;?>
      </td>
      <td align="center">&nbsp;</td>
      <td align="center">
          <span style="text-decoration:underline;color:#000;"> <?php echo $cetak['nama'];?> </span>
        <br>NIK. <?php echo $cetak['cif_no'];?></td>
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
  <!-- <br>
  <table style="font-size:11px;font-weight:bold;margin-left:70px;">
    <tr>
      <td align="center" width="190">SAKSI 1</td>
      <td align="center" width="190">&nbsp;</td>
      <td align="center" width="190">SAKSI 2</td>
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
      <td align="center"><?php //echo $saksi1;?></td>
      <td align="center">&nbsp;</td>
      <td align="center"><?php //echo $saksi2;?></td>
    </tr>
  </table> -->
</div>
</page>