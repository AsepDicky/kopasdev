<?php 
  $CI = get_instance();

  // echo date('a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z');
  $array_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
  $array_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

?> 
<style type="text/css">
.hovertable {
  /*font-family: verdana,arial,sans-serif;*/
  font-size:11px;
  color:#333333;
  border-width: 1px;
  border-color: #999999;
  border-collapse: collapse;
}
.hovertable th {
  background-color:#fff;
  border-width: 1px;
  padding: 5px;
  border-style: solid;
  border-color: #a9c6c9;
}
.hovertable tr {
  background-color:#fff;
}
.hovertable td {
  border-width: 1px;
  padding: 5px;
  border-style: solid;
  border-color: #a9c6c9;
}
</style>
<div style="margin-left:75px;width:610px">
  <!-- PASAL 4 -->
  <div style="font-weight:bold;font-size:14px;line-height:25px;text-align:center;margin-top:15px;">
    LEMBAR HASIL SKORIN<br> 
    <?php echo $cetak['nama'].' - '.$cetak['registration_no'];?><br>
  </div>
  <br>
  <div style="margin-left:55px">
      <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">I. ADMINISTRASI KELENGKAPAN DOKUMEN</div>
      <table cellpadding="0" cellspacing="0" class="hovertable">
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">KOMPONEN YANG DINILAI</td>
        </tr>
        <?php echo $tamleadm;?>
      </table>
      <br>
      <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">II. KARAKTER CALON DEBITUR</div>
      <table cellpadding="0" cellspacing="0" class="hovertable">
        <tr>
          <td align="center">NO</td>
          <td align="center">KOMPONEN YANG DINILAI</td>
        </tr>
        <tr>
          <td>1</td>
          <td>Pendidikan</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <table>
              <?php echo $tamlependidikan;?>
            </table>
          </td>
        </tr> 
        <tr>
          <td>2</td>
          <td>Pemahaman Kewirausahaan & Managerial</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <table>
              <?php echo $trlepkm;?>
            </table>
          </td>
        </tr> 
        <tr>
          <td>3</td>
          <td>Pengalaman Berusaha</td>
        </tr>   
        <tr>
          <td>&nbsp;</td>
          <td>
            <table>
              <?php echo $tblpnglmnusaha;?>
            </table>
          </td>
        </tr> 
      </table>
      <br>  
      <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">III. USAHA PRODUKTIF</div>
      <table cellpadding="0" cellspacing="0" class="hovertable">
        <tr>
          <td align="center">NO</td>
          <td align="center">KOMPONEN YANG DINILAI</td>
          <td align="center" width="280">&nbsp;</td>
        </tr>
        <?php echo $trusahaprod;?>
      </table>
      <br>  
      <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">IV. ASET / KEKAYAAN BERSIH</div>
      <table cellpadding="0" cellspacing="0" class="hovertable">
        <tr>
          <td align="center">NO</td>
          <td align="center">KOMPONEN YANG DINILAI</td>
          <td align="center" width="280">&nbsp;</td>
        </tr>
        <?php echo $traset;?>
      </table>
      <br>         
      <div style="text-align:justify;line-height:20px;font-size:13px;margin-top:10px;">V. Rekomendasi Dari Hasil Scoring</div>
      <table cellpadding="0" cellspacing="0" class="hovertable">
        <tr>
          <td width="170">
            <div align="center" style="font-size:12px;font-weight:bold;">Total Score Sebesar</div>
            <?php echo $hasil;?>
          </td>
          <td>
            <table cellpadding="0" cellspacing="0" class="hovertable">
              <tr>
                <td align="center">Skoring<br>Terbobot</td>
                <td align="center">Rekomendasi</td>
              </tr>
              <tr>
                <td align="center">
                  > 450 <br>
                  351 s/d 450 <br>
                  301 s/d 350 <br>
                  201 s/d 300 <br>
                  &lt; 200
                </td>
                <td style="padding:5px;">
                  Sangat Layak Diberikan Kredit <br>
                  Layak diberikan kredit <br>
                  Dapat diberikan kredit <br>
                  Dapat diberikan dengan tambahan jaminan fisik <br>
                  Tidak dapat diberikan <br>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  </div>
</div>