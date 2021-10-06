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
  width: 7%;
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
#hor-minimalist-b .ket
{
  border: 1px solid #262626;
  color: #000;
  width: 30%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .db
{
  border-bottom: 1px solid #262626;
  /*border-left: 1px solid #262626;*/
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .cr
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .tgl
{
  border: 1px solid #262626;
  color: #000;
  width: 15%;
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
        History Transaksi Deposito
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
        Periode <span style="margin-left:30px;"> : <?php echo $tanggal1_view;?> s/d <?php echo $tanggal2_view;?></span>
        </div>
        <br>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
        <td rowspan="2" class="no">No</td>
        <td rowspan="2" class="tgl">Tanggal</td>
        <td rowspan="2" class="ket">Keterangan</td>
        <td colspan="2" class="jumlah">Jumlah</td>
      </tr>
      <tr>
        <td class="db">DB</td>
        <td class="cr">CR</td>
      </tr>
      <?php
      $CI = get_instance();
      $no = 1; 
      $total_pokok = 0;
      $total_bahas = 0;
      $total_pajak = 0;
      $total_depo  = 0;
        foreach ($rek_tabungan as $data): 
        $total_pokok+=$data['nominal'];     
        $total_bahas+=$data['nominal_bahas'];    
        $total_pajak+=$data['pajak_bahas'];    

        if($data['nominal']=""){
          $nominal = "0";
        }else{
          $nominal = $data['nominal'];
        }

        if($data['nominal_bahas']=""){
          $nilai_bagihasil_last = "0";
        }else{
          $nilai_bagihasil_last = $data['nominal_bahas'];
        }

      ?>
      <tr class="value">
            <td class="val_anggota"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <td class="val_jumlah"><?php echo $data['description'];?></td>
            <td class="val_pokok"><?php echo number_format($nominal,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($nilai_bagihasil_last,0,',','.');?></td>
      </tr>
      <?php 
          endforeach
      ?>     
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>  
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5"><hr></td>
      </tr>
      <tr>
        <td colspan="2" height="20">&nbsp;</td>
        <td align="left" height="20">Buka Deposito</td>
        <td align="right" height="20"><?php echo number_format($total_pokok,0,',','.');?></td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" height="20">&nbsp;</td>
        <td align="left" height="20">Bagi Hasil</td>
        <td align="right" height="20"><?php echo number_format($total_bahas,0,',','.');?></td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" height="20">&nbsp;</td>
        <td align="left" height="20">Pajak Bagi Hasil</td>
        <td align="right" height="20"><?php echo number_format($total_pajak,0,',','.');?></td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" height="20">&nbsp;</td>
        <td align="left" height="20">Pencairan Deposito</td>
        <td align="right" height="20"><?php echo number_format($total_depo,0,',','.');?></td>
        <td height="20">&nbsp;</td>
      </tr>
    </tbody>
</table>
</page>