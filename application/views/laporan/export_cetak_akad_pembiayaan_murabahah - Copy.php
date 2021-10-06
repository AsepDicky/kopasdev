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
   echo "Angka terlalu Besar";  
  }  

  $totalhutang = (isset($cetak['pokok']) && isset($cetak['margin'])) ? $cetak['pokok']+$cetak['margin'] : "0" ;
  $pokok = (isset($cetak['pokok'])) ? $cetak['pokok'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;
  $totalangsuran = (isset($cetak['angsuran_pokok']) && isset($cetak['angsuran_margin']) && isset($cetak['angsuran_catab'])) ? $cetak['angsuran_pokok']+$cetak['angsuran_margin']+$cetak['angsuran_catab'] : "0" ;
  $margin = (isset($cetak['margin'])) ? $cetak['margin'] : "0" ;

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
  
?> 
<page>
      <div style="width:80%;margin-left:75px;font-size:10px;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          <?php echo $institution['institution_name'];?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          <?php echo $institution['alamat'];?> 
        </div>
        <br>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
          AKAD PEMBIAYAAN
          <br>
          ALMUROBAHAH
        </div>
        <br>
        <hr>
    <div>
        <br><p style="text-align:center;"><span style="font-style:italic;">"Hai orang-orang yang beriman penuhilah akad perjanjian itu"</span>&nbsp;&nbsp;(QS 5:1 )</p>
        <p style="text-align:center;"><span style="font-style:italic;">Bismillahirrohmaanirrohiim</span></p>
        <br>Pada hari ini Tanggal <?php echo date("d-m-Y", strtotime($cetak['tanggal_akad']));?>,  kami yang bertanda tangan dibawah ini :
        <br>
        <table>
          <tr>
            <td>I.</td>
            <td width="90">Nama</td>
            <td>:</td>
            <td><?php echo $institution['officer_name'];?></td>
          </tr>
          <tr>
            <td></td>
            <td>Jabatan</td>
            <td>:</td>
            <td><?php echo $institution['officer_title'].'  '.$institution['institution_name'];?></td>
          </tr>
        </table> 
        <span style="line-height:15px;">Dalam Hal ini bertindak untuk dan atas nama <?php echo $institution['institution_name'];?>, yang berkedudukan di <?php echo $institution['alamat'];?>. Untuk selanjutnya disebut sebagai <span style="font-weight:bold;">PIHAK PERTAMA </span> atau <span style="font-weight:bold;">PENJUAL</span> .</span>
        <br>
        <br>
        <table>
          <tr>
            <td>II.</td>
            <td width="90">Nama</td>
            <td>:</td>
            <td><?php echo $cetak['nama'];?></td>
          </tr>
          <tr>
            <td></td>
            <td>Alamat (KTP)</td>
            <td>:</td>
            <td><?php echo $cetak['alamat'];?></td>
          </tr>
          <tr>
            <td></td>
            <td>Pekerjaan</td>
            <td>:</td>
            <td><?php echo $cetak['pekerjaan'];?></td>
          </tr>
          <tr>
            <td></td>
            <td>No KTP/SIM</td>
            <td>:</td>
            <td><?php echo $cetak['no_ktp'];?></td>
          </tr>
        </table> 
        Dalam hal ini bertindak atas nama <span style="font-style:italic;font-weight:bold;">Diri Sendiri</span> , selanjutnya dalam perjanjian ini disebut <span style="font-weight:bold;">PIHAK KEDUA  </span>  atau  <span style="font-weight:bold;">PEMBELI</span> .
        
        <br><br>PIHAK PERTAMA dan PIHAK KEDUA telah bersepakat melakukan transaksi seperti yang diuraikan dalam pasal-pasal berikat ini :
        <br>
        <br>
        <table style="line-height:15px;">
          <tr>
            <td>1.</td>
            <td style="width:600px;" align="justify">PIHAK PERTAMA akan membayarkan sejumlah dana atas pembelian barang pada PIHAK KETIGA dan atau menguasakan pada PIHAK KEDUA untuk membeli sendiri dengan menyerahkan uang tunai sebesar Rp <?php echo number_format($pokok,0,',','.');?> untuk <?php echo $cetak['display_text'];?></td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td>2.</td>
            <td style="width:600px;" align="justify">PIHAK PERTAMA kemudian menjual barang yang dibeli kepada PIHAK KEDUA dengan margin bagi PIHAK PERTAMA sebesar Rp <?php echo number_format($margin,0,',','.');?>, sehingga nilai jual seluruhnya / total hutang PIHAK KEDUA sebesar Rp. <?php echo number_format($totalhutang,0,',','.');?></td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td>3.</td>
            <td style="width:600px;" align="justify">Pihak kedua sanggup membayar hingga lunas hutang tersebut kepada PIHAK PERTAMA  dengan mengangsur selama <?php echo $cetak['jangka_waktu'];?> <?php echo $periode_jangka_waktu;?> sebesar <?php echo number_format($totalangsuran,0,',','.');?> / <?php echo $periode_jangka_waktu;?> mulai tanggal <?php echo date("d-m-Y", strtotime($cetak['tanggal_mulai_angsur']));?> dengan rincian sebagai berikut :</td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              <table>
                <tr>
                  <td>&nbsp;</td>
                  <td>a.</td>
                  <td>Angsuran pokok sebesar</td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">Rp. <?php if(isset($cetak['angsuran_pokok'])) echo number_format($cetak['angsuran_pokok'],0,',','.');?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>b.</td>
                  <td>Angsuran margin sebesar</td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">Rp. <?php if(isset($cetak['angsuran_margin'])) echo number_format($cetak['angsuran_margin'],0,',','.');?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>c.</td>
                  <td>Cadangan Tab sebesar </td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">Rp. <?php if(isset($cetak['angsuran_catab'])) echo number_format($cetak['angsuran_catab'],0,',','.');?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td>4.</td>
            <td style="width:600px;" align="justify">Terhadap fasilitas pembiayaan ini, PIHAK KEDUA bersedia menyerahkan uang sejumlah Rp. <?php echo number_format($cetak['biaya_administrasi']+$cetak['biaya_jasa_layanan'],0,',','.');?> untuk pembayaran :</td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              <table>
                <tr>
                  <td>&nbsp;</td>
                  <td>a.</td>
                  <td>Biaya administrasi</td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">Rp. <?php echo (isset($cetak['biaya_administrasi']))?number_format($cetak['biaya_administrasi'],0,',','.'):'0';?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>a.</td>
                  <td>Biaya Jasa Layanan</td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">Rp. <?php echo (isset($cetak['biaya_jasa_layanan']))?number_format($cetak['biaya_jasa_layanan'],0,',','.'):'0';?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td>5.</td>
            <td style="width:600px;" align="justify">Jika di kemudian hari terjadi perselisihan diantara kedua belah pihak, maka akan diselesaikan dengan cara musyawarah mufakat yang dilandasi Ukhuwah Islamiyah.</td>
          </tr>
        </table>
        <br><span style="line-height:20px;">Demikian perjanjian dan pernyataan kesanggupan ini dibuat dan ditandatangani oleh kedua belah pihak, dan oleh karenanya mengikat untuk dijalankan sebagaimana mestinya dan menjadi bahan pembuktian yang sah bagi para pihak.</span>
        <br><br>
        <br><br>
        <table style="margin-left:95px;">
          <tr>
            <td width="200" align="center">PIHAK PERTAMA</td>
            <td width="200" align="center">PIHAK KEDUA</td>
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
            <td align="center"><?php echo $institution['officer_name'];?></td>
            <td align="center"><?php echo $cetak['nama'];?></td>
          </tr>
        </table>
      </div>
    </div>
</page> 