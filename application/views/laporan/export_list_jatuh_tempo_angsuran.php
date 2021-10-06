<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 0;
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
/*value*/
.value
{
  font-size: 11px;
}
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          Laporan Jatuh Tempo Angsuran
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Produk : <?php echo $produk_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Petugas : <?php echo $petugas_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Resort : <?php echo $resort_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b">
    <tbody>
      <tr>
            <td style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 11px; width:20px;">No.</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:130px;">No. Rekening</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:150px;">Nama</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:100px;">Produk</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:120px;">Besar Angsuran</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:90px;">Tgl Angsur</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:90px;">Besar Yg Dibayarkan</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:90px;">Tgl Bayar</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:90px;">Angsuran Ke</td>
      </tr>
      <?php 
        $CI = get_instance();
        $no=1;
        foreach ($result as $data):
      ?>
      <tr class="value">
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['account_financing_no'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nama'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['product_name'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['besar_angsuran'],0,',','.');?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo "01".substr(date("dmY",strtotime($CI->format_date_detail($data['jtempo_angsuran_next'],'id',false,'-'))),-8);?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo (($data['besar_yg_dibayar']=="")?'':number_format($data['besar_yg_dibayar'],0,',','.')); ?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo (($data['trx_date']=="")?"":$CI->format_date_detail($data['tanggal_jtempo'],'id',false,'-')); ?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['angsuran_ke'];?></td>
      </tr>
    <?php 
        endforeach;
    ?>
    </tbody>
</table>
</page>