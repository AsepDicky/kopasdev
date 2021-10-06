<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 11px;
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 15px;
  font-weight: normal;
  color: #000;
  padding: 10px 8px;
  border-top: 2px solid #6678b1;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b .ket_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
  padding: 3px 5px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}

/*value*/
.value
{
  font-size: 10px;
}
#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  padding: 6px 5px;
  text-align: center;
}
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang; ?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          Laporan Angsuran Pembiayaan
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Produk : <?php echo $produk_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b">
  <thead>
      <tr>
            <th style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 9px; width:20px;">No.</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:60px;">No.<br>Pembiayaan</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:60px;">Nama</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Plafon</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Margin</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:60px;">Jangka Waktu</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Ang.<br>Pokok</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Ang.<br>Margin</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Jml<br>Angsuran</th>
            <!-- <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:20px;">Ang.<br>Ke</th> -->
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:55px;">Jtempo Angs</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:55px;">Tgl Bayar</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:45px;">Saldo<br>Pokok</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:45px;">Saldo<br>Margin</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:45px;">Saldo<br>Hutang</th>
      </tr>
      </thead>
    <tbody>
      <?php 
        $no=1;
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_jml_bayar = 0;
        foreach ($result as $data):
        $total_jml_bayar += $data['jml_bayar'];

        if ($data['trx_date']==NULL) {
          $trx_date = "-";
        } else {
          $trx_date = $CI->format_date_detail($data['trx_date'],'id',false,'-');
        }

        // if ($data['jml_bayar']==NULL) {
        //   $jml_bayar = "-";
        // } else {
        //   $jml_bayar = "Rp. ".number_format($data['jml_bayar'],0,',','.');
        // }

        if($data['periode_jangka_waktu']=='0'){
          $periode_jangka_waktu = "Harian";
        }else if($data['periode_jangka_waktu']=='1'){
          $periode_jangka_waktu = "Mingguan";
        }else if($data['periode_jangka_waktu']=='2'){
          $periode_jangka_waktu = "Bulanan";
        }else if($data['periode_jangka_waktu']=='3'){
          $periode_jangka_waktu = "Jatuh Tempo";
        }else{
          $periode_jangka_waktu = "-";
        }
        
        $total_angsuran_pokok += $data['angsuran_pokok'];
        $total_angsuran_margin += $data['angsuran_margin'];

      ?>
      <tr class="value">
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['account_financing_no'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:left;"><?php echo $data['nama'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['margin'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $periode_jangka_waktu;?> <?php echo $data['jangka_waktu'];?> x</td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['angsuran_pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['angsuran_margin'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['jml_angsuran'],0,',','.');?></td>
            <!-- <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo number_format($data['angsuran_ke'],0,',','.');?></td> -->
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['jtempo_angsuran_last'],'id',false,'-');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $trx_date;?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format(($data['saldo_pokok']+$data['saldo_margin']),0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>
      <tr class="value">
            <td style="border-right:solid 1px #555;" colspan="5"></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align:right;">TOTAL</td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align:right;"><?php echo number_format($total_angsuran_pokok) ?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align:right;"><?php echo number_format($total_angsuran_margin) ?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align:right;"><?php echo number_format($total_jml_bayar,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>