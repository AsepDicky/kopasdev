<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
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
#hor-minimalist-b .no
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .status
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .tgl
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}

/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_status
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
  width: 10px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #262626;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
-->
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo strtoupper($this->session->userdata('branch_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        STATEMENT TABUNGAN
        </div>
        <div style="text-align:left;padding-top:10px;padding-left:40px;font-family:Arial;font-size:13px;">
        No. Rekening : <?php echo $no_rek;?>  
        </div>
        <div style="text-align:left;padding-top:10px;padding-left:40px;font-family:Arial;font-size:13px;">
        Nama <span style="margin-left:44px;">: <?php echo $nama;?></span>  
        </div>
        <div style="text-align:left;padding-top:10px;padding-left:40px;font-family:Arial;font-size:13px;">
        Produk <span style="margin-left:37px;">: <?php echo $product_name;?></span>   
        </div>
        <div style="text-align:left;padding-top:10px;padding-left:40px;font-family:Arial;font-size:13px;">
        Periode <span style="margin-left:30px;"> : <?php echo $CI->format_date_detail($tanggal1_view,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_view,'id',false,'-');?></span>
        </div>
        <br>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no">No</td>
            <td class="tgl">Tanggal</td>
            <td class="anggota">Keterangan</td>
            <td class="no">D/C</td>
            <td class="pokok">Jumlah</td>
            <td class="pokok">Saldo</td>
      </tr>
      <tr class="value">
            <td class="val_anggota">1</td>
            <td class="val_anggota"><?php echo $CI->format_date_detail($tgl_saldo_akhir,'id',false,'-');?></td>
            <td class="val_jumlah" style="width:200px;">Saldo Awal</td>
            <td class="val_pokok">-</td>
            <td style="width:50px;" class="val_pokok">-</td>
            <td class="val_pokok"><?php echo number_format($saldo_awal,0,',','.');?></td>
      </tr>
      <?php
      $no     = 2; 
      $saldo  = $saldo_awal; 
        foreach ($rek_tabungan as $data):
          if($data['flag_debit_credit']=="D") {
            $saldo -= $data['amount'];
          }else{
            $saldo += $data['amount'];
          }
      ?>
      <tr class="value">
            <td class="val_anggota"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <td class="val_jumlah" style="width:200px;"><?php echo $data['description'];?></td>
            <td class="val_pokok"><?php echo $data['flag_debit_credit'];?></td>
            <td style="width:50px;" class="val_pokok"><?php echo number_format($data['amount'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($saldo,0,',','.');?></td>
      </tr>
      <?php 
          endforeach
      ?>  
    </tbody>
</table>
</page>