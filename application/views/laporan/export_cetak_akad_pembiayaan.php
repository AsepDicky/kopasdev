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

  if ($cetak['periode_jangka_waktu']==0) {
    $periode_jangka_waktu = "Hari";
  } 
  else if ($cetak['periode_jangka_waktu']==1) {
    $periode_jangka_waktu = "Minggu";
  }
  else if ($cetak['periode_jangka_waktu']==2) {
    $periode_jangka_waktu = "Bulanan";
  }
  else{
    $periode_jangka_waktu = "Jatuh Tempo";
  }
  
?> 
<page>
      <div style="width:80%;margin-left:75px;font-size:10px;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        AKAD PERJANJIAN PEMBIAYAAN
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cetak['product_name'];?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $institution['institution_name'];?> 
        </div>
        <br>
        <hr>
        Nomor : <?php echo $cetak['product_code'];?>
        <br><br>Lampiran : 1 (satu) Berkas

        <br><p style="text-align:center;font-style:italic;">Bismillaahirrahmaanirrahiim</p>
        <br><br>Yang bertandatangan dibawah ini 
        <br>
        <br>
        <table>
          <tr>
            <td>1.</td>
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
        Bertindak atas nama <?php echo $institution['institution_name'];?>, untuk selanjutnya disebut <span style="font-weight:bold;">Pihak Kesatu</span> .
        <br>
        <br>
        <table>
          <tr>
            <td>1.</td>
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
        Dalam hal ini bertindak atas nama <span style="font-style:italic;font-weight:bold;">Diri Sendiri</span> , selanjutnya dalam perjanjian ini disebut <span style="font-weight:bold;">Pihak Kedua</span> .
        
        <br><br>Telah bersepakat melakukan jualbeli <span style="font-weight:bold;"><?php echo $cetak['product_name'];?></span>&nbsp;&nbsp;dengan ketentuan sebagai berikut :
        <br><br>
        <table>
          <tr>
            <td>1.</td>
            <td style="width:600px;" align="justify">Pihak Kesatu mewakilkan kepada Pihak Kedua untuk membeli barang seperti tersebut dalam lampiran atau sebagai berikut :</td>
          </tr>
          <tr>
            <td></td>
            <td>
              <table style="font-weight:bold;">
                <tr>
                  <td style="width:10px;">a.</td>
                  <td style="width:250px;">[alokasi]</td>
                  <td style="width:50px;">seharga</td>
                  <td style="width:10px;">Rp.</td>
                  <td style="width:100px;text-align:right;"><?php echo number_format($pokok,0,',','.');?></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>Jumlah</td>
                  <td>Rp.</td>
                  <td style="text-align:right;"><?php echo number_format($pokok,0,',','.');?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>2.</td>
            <td style="width:600px;" align="justify">Untuk keperluan itu (butir 1) Pihak Kesatu menitipkan kepada Pihak Kedua uang sejumlah (<?php echo Terbilang($pokok);?>)</td>
          </tr>
          <tr>
            <td>3.</td>
            <td style="width:600px;" align="justify">
              Barang-barang tersebut dalam butir 1 di atas selanjutnya dibeli oleh Pihak Kedua seharga Rp. <?php echo number_format($totalhutang,0,',','.');?>   (<?php echo Terbilang($totalhutang);?>) dengan rincian
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              <table>
                <tr>
                  <td style="width:10px;">&nbsp;</td>
                  <td style="width:110px;">- Harga Pokok</td>
                  <td style="width:10px;">Rp</td>
                  <td style="width:80px;text-align:right;"><?php echo number_format($pokok,0,',','.');?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>- Mark Up</td>
                  <td>Rp</td>
                  <td style="text-align:right;"><?php echo number_format($margin,0,',','.');?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>4.</td>
            <td style="width:600px;" align="justify">
              Pihak Kedua telah atau tidak membayar uang muka sebesar Rp 0,00 (Nol rupiah),  dengan demikian Pihak Kedua mengaku masih berhutang pada Pihak Kesatu sebesar Rp. <?php echo number_format($totalhutang,0,',','.');?>   (<?php echo Terbilang($totalhutang);?>)
            </td>
          </tr>
          <tr>
            <td>5.</td>
            <td style="width:600px;" align="justify">
              Pihak Kedua bersedia melunasi hutang tersebut paling lama <?php echo $cetak['jangka_waktu'].' '.$periode_jangka_waktu;?> dimulai dari tanggal <?php echo date("d-m-Y", strtotime($cetak['tanggal_mulai_angsur']))?> s/d <?php echo date("d-m-Y", strtotime($cetak['tanggal_jtempo']))?>. Pelunasan akan dilakukan dengan cara cicilan sebesar Rp. <?php echo number_format($totalangsuran,0,',','.');?> per <?php echo $periode_jangka_waktu;?>, dengan perincian sebagai berikut :
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              <table>
                <tr>
                  <td style="width:10px;">&nbsp;</td>
                  <td style="width:110px;">- Pokok</td>
                  <td style="width:10px;">Rp</td>
                  <td style="width:80px;text-align:right;"><?php echo number_format($cetak['angsuran_pokok'],0,',','.');?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>- Margin</td>
                  <td>Rp</td>
                  <td style="text-align:right;"><?php echo number_format($cetak['angsuran_margin'],0,',','.');?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>- Catab</td>
                  <td>Rp</td>
                  <td style="text-align:right;"><?php echo number_format($cetak['angsuran_catab'],0,',','.');?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              Masa penyelesaian hutang ini disebut 1 (satu) periode
            </td>
          </tr>
          <tr>
            <td>6.</td>
            <td style="width:600px;" align="justify">
              Pihak Kedua bersedia menyerahkan kepada pihak ke satu jaminan
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              Utama / primer , berupa [JAMINANPRIMER]
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              Pelengkap / sekunder, berupa [JAMINANSKUNDER]
            </td>
          </tr>
          <tr>
            <td>7.</td>
            <td style="width:600px;" align="justify">
              Kerugian yang terjadi oleh sebab apapun tidak mengubah kewajiban Pihak Kedua kepada  Pihak Kesatu.
            </td>
          </tr>
          <tr>
            <td>8.</td>
            <td style="width:600px;" align="justify" align="justify">
              Pihak Kesatu dapat membatalkan akad murabahah bila ternyata Pihak Kedua menyalahi ketentuan-ketentuan dalam perjanjian dan karenanya seluruh modal pembiayaan serta mark up yang menjadi hak Pihak Kesatu harus segera dikembalikan.
            </td>
          </tr>
          <tr>
            <td>9.</td>
            <td style="width:600px;" align="justify">
              Ketentuan khusus sebagai berikut :
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="width:600px;" align="justify">
              <table>
                <tr>
                  <td>a.</td>
                  <td style="width:580px;">Pihak Kedua menjamin bahwa usaha yang dijalankan benar-benar halal menurut syara dan tidak bertentangan dengan undang-undang atau hukum yang berlaku.</td>
                </tr>
                <tr>
                  <td>b.</td>
                  <td style="width:580px;">bila kekuasaan untuk pembelian barang (pasal 1) di salahgunakan untuk tujuan lain atau sebab kecurangan / khianat, maka akad murabahah ini akan berubah menjadi akad jaminan (dhomanah), dan terhadap barang jaminan atau kolateral (pasal 6) yang diserahkan kepada Pihak Kesatu menurut ketentuan pengikat jaminan menjadi pengganti modal tersebut dengan sepenuhnya (pasal 2) setelah terlebih dahulu diperhitungkan ongkos-ongkos.</td>
                </tr>
                <tr>
                  <td>c.</td>
                  <td style="width:580px;">Terhadap akad ini, Pihak Kedua bersedia membayar kepada Pihak Kesatu sejumlah Rp. [TOTALBIAYA]  ([totalbiayaterbilang]) dengan rincian : </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <table>
                      <tr>
                        <td>- Iuran Administrasi</td>
                        <td>Rp.</td>
                        <td><?php echo number_format($cetak['biaya_administrasi'],0,',','.');?></td>
                      </tr>
                      <tr>
                        <td>- Biaya Materai </td>
                        <td>Rp.</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>- Biaya sumbangan Pengawasan</td>
                        <td>Rp.</td>
                        <td></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>10.</td>
            <td style="width:600px;" align="justify">
              Jika dikemudian hari ternyata terdapat kesalahan di dalam perjanjian ini dan atau terjadi perselisihan antara kedua belah pihak berkaitan dengan perjanjian itu, maka akan diselesaikan  dengan cara musyawarah mufakat yang dilandasi oleh ukhuwah islamiyyah.
            </td>
          </tr>
        </table>
        <br>Demikian perjanjian ini telah disepakati dan ditanda tangani di Bogor pada hari <?php echo date('d-m-Y');?>.
        <br><p style="text-align:center;font-style:italic;">Walhamdulillaahirabbil’aalamiin</p>
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
</page> 