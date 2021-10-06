<style>
ol li{
  margin-bottom: 10px;

}
</style>
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
  
  // echo date('a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z');
  $array_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
  $array_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

?> 
<page>
<div style="margin-left:70px;width:600px;">
  <div style="font-weight:bold;font-size:14px;line-height:15px;text-align:center;width:610px;">
    BISMILLAHIRRAHMAANIRRAHIM<br>SURAT PENEGASAN <br>PERSETUJUAN PENYEDIAAN PEMBIAYAAN ( SP4 )<br>
  </div>
  <br><br>
  <div align="left" style="font-size:12px;width:610px;">Nomor  :<?php echo $cetak['registration_no'];?>/<?php echo $seri_surat;?>/<?php echo date('Y');?></div><br>
  <div align="left" style="font-size:12px;width:610px;font-weight:bold;">
    Kepada Yth,
    <br>Sdr. <?php echo $cetak['nama'].' / NIK. '.$cetak['cif_no'];?> 
    <br>Karyawan PT. TELKOM
    <br><?php echo $cetak['loker'].'<br>'.$cetak['code_divisi'];?> 
  </div>
  <br><br>
  <div align="left" style="font-size:12px;">
    Ass. Wr. Wb.
    <br>Dengan Hormat,
    <br>
    <br>
    <div style="width:620px;text-align:justify;text-justify:inter-word;">
      Dengan ini diberitahukan, bahwa berdasarkan permohonan kredit yang Saudara ajukan, Koperasi PT. Telekomunikasi Indonesia ( KOPTEL ) dapat menyetujui untuk menyediakan fasilitas Pembiayaan dengan ketentuan dan syarat sebagai berikut :
    </div>
    <table>
      <tr>
        <td>1.</td>
        <td>Jenis Pembiayaan</td>
        <td>:</td>
        <td><strong><?php echo $cetak['product_name'].' ('.$cetak['nick_name'].')';?></strong></td>
      </tr>
      <tr>
        <td>2.</td>
        <td>Jumlah Pembiayaan</td>
        <td>:</td>
        <td><strong>Rp. <?php echo number_format($cetak['amount']);?></strong></td>
      </tr>
      <tr>
        <td>3.</td>
        <td>Total Margin</td>
        <td>:</td>
        <td><strong>Rp. <?php echo number_format($cetak['total_margin']);?></strong></td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Jumlah Pengembalian</td>
        <td>:</td>
        <td><strong>Rp. <?php echo number_format(($cetak['amount']+$cetak['total_margin']));?></strong></td>
      </tr>
      <tr>
        <td>5.</td>
        <td>Tujuan Pembiayaan</td>
        <td>:</td>
        <td><strong><?php echo $cetak['display_peruntukan'];?></strong></td>
      </tr>
      <tr>
        <td>6.</td>
        <td>Angsuran per bulan</td>
        <td>:</td>
        <td><strong>Rp. <?php echo number_format((($cetak['amount']+$cetak['total_margin'])/$cetak['jangka_waktu']));?></strong></td>
      </tr>
      <tr>
        <td>7.</td>
        <td>Jangka waktu Pembiayaan</td>
        <td>:</td>
        <td><strong><?php echo $cetak['jangka_waktu'];?> Bulan</strong></td>
      </tr>
      <tr>
        <td>8.</td>
        <td>Jaminan Pembiayaan</td>
        <td>:</td>
        <td>Sertifikat Tanah dan Bangunan</td>
      </tr>
      <tr>
        <td>9.</td>
        <td colspan="3">Ketentuan dan syarat lainnya :
          <table>
            <tr>
              <td>a.</td>
              <td>Pemohon telah membayar jumlah biaya tersebut dibawah ini :</td>
            </tr>
            <tr>
              <td></td>
              <td style="padding-left:10px;">
                <table>
                  <?php $jumlah=0;?>
                  <tr>
                    <td>1)</td>
                    <td>Biaya Administrasi</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format($cetak['biaya_administrasi']);$jumlah+=$cetak['biaya_administrasi']?></td>
                  </tr>
                  <tr>
                    <td>2)</td>
                    <td>Biaya Asuransi Jiwa Pembiayaan sebesar</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format($cetak['premi_asuransi']+$cetak['premi_asuransi_tambahan']);$jumlah+=($cetak['premi_asuransi']+$cetak['premi_asuransi_tambahan']);?></td>
                  </tr>
                  <tr>
                    <td>3)</td>
                    <td>Biaya Notaris</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format($cetak['biaya_notaris']);$jumlah+=$cetak['biaya_notaris']?></td>
                  </tr>
                  <tr>
                    <td>4)</td>
                    <td>Angsuran Bulan Pertama sebesar</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format((($cetak['amount']+$cetak['total_margin'])/$cetak['jangka_waktu'])); $jumlah+=(($cetak['amount']+$cetak['total_margin'])/$cetak['jangka_waktu']);?></td>
                  </tr>
                  <!-- <tr>
                    <td>5)</td>
                    <td>Biaya APHT</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format($cetak['biaya_apht']);$jumlah+=$cetak['biaya_apht']?></td>
                  </tr> -->
                  <tr>
                    <td></td>
                    <td align="center">JUMLAH</td>
                    <td>: Rp.</td>
                    <td align="right"><?php echo number_format($jumlah);?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="3">Jumlah biaya tersebut di atas supaya dibayar secara cash melalui Bendahara KOPTEL.</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>b.</td>
              <td><div style="width:590px;text-align:justify;text-justify:inter-word;">Pemohon telah bersedia untuk menggunakan fasilitas Pembiayaan yang disediakan oleh KOPTEL, 
                      setelah Pemohon menyetujui Perjanjian yang dituangkan dalam Perjanjian Pembiayaan terlampir 
                      yang akan ditandatangani oleh Pemohon dan Pengurus KOPTEL, dibuat dalam rangkap 2 (dua) asli 
                      masing-masing di atas  meterai Rp. 6.000,00 dan akan disahkan oleh Notaris.</div></td>
            </tr>
          </table>          
        </td>
      </tr>
      <tr>
        <td>10.</td>
        <td colspan="3"><div style="width:610px;text-align:justify;text-justify:inter-word;">Sehubungan dengan hal tersebut di atas, apabila Saudara menyetujui ketentuan dan syarat penyediaan fasilitas Pembiayaan menurut SP4 ini, kami harapkan agar Saudara dapat mengisi dan menandatangani Surat Pernyataan terlampir dengan benar di atas meterai Rp. 6.000,00 kemudian mengirimkannya kepada kami dengan dilampiri :</div>
          <table>
            <tr>
              <td>a.</td>
              <td>Bukti Setor sebagaimana dimaksud butir 9 a.</td>
            </tr>
            <tr>
              <td>b.</td>
              <td>PUP yang telah Saudara tanda tangani sebagaimana dimaksud butir 9 b.</td>
            </tr>
            <tr>
              <td colspan="2">selambat-lambatnya 1 (satu) bulan sejak diterbitkan SP4 ini, sebagai tanda persetujuan atas segala ketentuan dan <br>syarat tersebut di atas.</td>
            </tr>
          </table>          
        </td>
      </tr>
      <tr>
        <td>11.</td>
        <td colspan="3"><div style="width:610px;text-align:justify;text-justify:inter-word;">Selanjutnya apabila sampai dengan 1 (satu) bulan sejak diterbitkan SP4 ini, Saudara belum menyampaikan kepada kami Surat Pernyataan beserta lampirannya sebagaimana tercantum pada butir 11 di atas, maka Surat Penegasan Persetujuan Penyediaan Pembiayaan (SP4) ini batal dengan sendirinya dan tidak berlaku lagi.</div></td>
      </tr>
    </table>
    <br>
    Bandung, <?php echo date('d').' '; if(date('m')<10){echo $array_bulan[str_replace('0','',date('m'))];}else{echo $array_bulan[date('m')];} echo ' '.date('Y') ;?>
    <br>
    <div style="font-weight:bold;">
    A/n.  Pengurus KOPTEL,
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <span style="text-decoration:underline;"><?php if(isset($pejabat_nama)) echo $pejabat_nama; if(isset($pejabat_nik)) echo ' / '.$pejabat_nik;?></span>
    <br><?php if(isset($pejabat_jabatan)) echo $pejabat_jabatan;?>
    </div>

  </div>
</div>
</page>


<page>
  <div style="margin-left:70px;">    
    <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;width:610px;text-decoration:underline;">
      SURAT PERNYATAAN&nbsp;
    </div>
    <br>
    <div style="width:610px">
      Yang bertanda tangan di bawah ini  :
      <table width="600px">
        <tr>
          <td>Nama</td>
          <td>:&nbsp;<div style="width:500px"> <?php echo $cetak['nama'];?></div></td>
        </tr>
        <tr>
          <td>NIK</td>
          <td>:&nbsp;<div style="width:500px"> <?php echo $cetak['cif_no'];?></div></td>
        </tr>
        <tr>
          <td>ALamat</td>
          <td>:&nbsp;<div style="width:500px"> <?php echo $cetak['alamat'];?></div></td>
        </tr>
        <tr>
          <td>Lokasi Kerja</td>
          <td>:&nbsp;<div style="width:500px"> <?php echo $cetak['loker'].'<br>'.$cetak['code_divisi'];?></div></td>
        </tr>
        <tr>
          <td>Alamat Lokasi Kerja</td>
          <td>:&nbsp;<div style="width:500px"> <?php echo 'alamat loker';?></div></td>
        </tr>
      </table>
      <br><div style="width:600px;text-align:justify;text-justify:inter-word;">Setelah mempelajari ketentuan dan syarat di dalam Surat Penegasan Persetujuan Penyediaan Pembiayaan (SP4) dari KOPTEL, dengan ini menyatakan  :</div>
      <ol>
        <li>Menyetujui sepenuhnya untuk menggunakan fasilitas Pembiayaan yang disediakan oleh KOPTEL sesuai dengan ketentuan dan syarat yang tercantum dalam SP4 dari KOPTEL.</li>
        <li>Pembiayaan yang kami ambil adalah sebagai berikut :
            <table>
              <tr>
                <td>a.</td>
                <td>Jumlah Pembiayaan</td>
                <td>: <strong>Rp. <?php echo number_format($cetak['amount']);?></strong></td>
              </tr>
              <tr>
                <td>b.</td>
                <td>Jangka Waktu</td>
                <td>: <strong><?php echo $cetak['jangka_waktu'];?> Bulan</strong></td>
              </tr>
              <tr>
                <td>c.</td>
                <td>Peruntukan</td>
                <td>: <strong><?php echo $cetak['display_peruntukan'];?></strong></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td>&nbsp;<?php echo $cetak['description'];?></td>
              </tr>
            </table>
        </li>
        <li><div style="width:580px;text-align:justify;text-justify:inter-word;">Apabila sampai dengan saat saya berhenti bekerja di PT. TELKOM atau meninggal dunia, masih mempunyai cicilan / kewajiban yang belum terselesaikan kepada KOPTEL, maka saya bersedia untuk dipotong langsung hak-hak saya yang ada di TELKOM antara lain :</div>
            <table>
              <tr>
                <td>a.</td>
                <td>Bantuan Fasilitas Perumahan Terakhir</td>
              </tr>
              <tr>
                <td>b.</td>
                <td>MPS (Manfaat Pensiun Sekaligus)</td>
              </tr>
              <tr>
                <td>c.</td>
                <td>Purnabakti</td>
              </tr>
              <tr>
                <td>d.</td>
                <td>Perjalanan Pensiun</td>
              </tr>
              <tr>
                <td>e.</td>
                <td>Dan hak-hak lainnya</td>
              </tr>
              <tr>
                <td colspan="2">melalui Payroll oleh unit HR Area yang bertalian berdasarkan tagihan KOPTEL, sebesar<br> sisa kewajiban saya yang belum dilunasi kepada KOPTEL.</td>
              </tr>
            </table>
        </li>
      </ol>
      <br>Surat pernyataan ini kami buat dengan kesadaran tanpa adanya tekanan dari pihak manapun juga.
      <br>
      <br>
      <br>
      <table>
        <tr>
          <td width="180" align="center"></td>
          <td width="140"></td>
          <td width="280" align="center">Bandung, <?php echo date('d').' '; if(date('m')<10){echo $array_bulan[str_replace('0','',date('m'))];}else{echo $array_bulan[date('m')];} echo ' '.date('Y') ;?></td>
        </tr>
        <?php
        $bValid = true;
        if($nama_pasangan=='-'){
          $bValid=false;
        }
        if($nama_pasangan==' '){
          $bValid=false;
        }
        if($nama_pasangan==null){
          $bValid=false;
        }
        if(!isset($nama_pasangan)){
          $bValid=false;
        }
        ?>
        <tr>
          <td align="center"><?php $m = ($bValid==true) ? 'Menyetujui,' : '' ; echo $m; ?></td>
          <td align="center">&nbsp;</td>
          <td align="center"><strong>Pemohon</strong></td>
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
          <td align="center" style="font-weight:bold;"><?php if($bValid==true){ $m='<span style="text-decoration:underline;">'.$nama_pasangan.' </span><br>'.$status_pasangan;}else{ $m='';} echo $m; ?> <br></td>
          <td>&nbsp;</td>
          <td align="center" style="font-weight:bold;"><span style="text-decoration:underline;"><?php echo $cetak['nama'];?> </span><br>KONSUMEN</td>
        </tr>
      </table>
    </div>
  </div> 
</page>