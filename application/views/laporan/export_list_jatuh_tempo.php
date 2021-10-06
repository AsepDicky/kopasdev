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
          Laporan Jatuh Tempo Pembiayaan
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Produk : <?php echo $produk_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Petugas : <?php echo $petugas_name;?>
        </div>
        <!-- <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Resort : <?php echo $resort_name;?>
        </div> -->
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b">
    <tbody>
      <tr>
            <td style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 11px; width:20px;">No.</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:120px;">No. Rekening</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:190px;">Nama</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:150px;">Produk</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:100px;">Plafon</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:100px;">Margin</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:80px;">Jangka Waktu</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:60px;">Tgl Droping</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:60px;">Tgl Jtempo</td>
      </tr>
      <?php 
        $CI = get_instance();
        $no=1;
        foreach ($result as $data):
          if ($data['periode_jangka_waktu']=="0") 
          {
            $periode = "Hari";
          } 
          else if ($data['periode_jangka_waktu']=="1") 
          {
            $periode = "Minggu";
          }
          else if ($data['periode_jangka_waktu']=="2") 
          {
            $periode = "Bulan";
          }
          else if ($data['periode_jangka_waktu']=="3") 
          {
            $periode = "Jatuh Tempo";
          }

          //Sisa angsuran
          // $sisa_angsuran = $data['saldo_pokok']/$data['angsuran_pokok'];
          // $sisa = ceil($sisa_angsuran);
          
      ?>
      <tr class="value">
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['account_financing_no'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nama'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['product_name'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['margin'],0,',','.');?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['jangka_waktu'];?> <?php echo $periode;?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $CI->format_date_detail($data['droping_date'],'id',false,'-');?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $CI->format_date_detail($data['tanggal_jtempo'],'id',false,'-');?></td>
      </tr>
    <?php 
        endforeach;
    ?>
    </tbody>
</table>
</page>