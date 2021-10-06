<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 9px;
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
#hor-minimalist-b .ket
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 70%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .ket_NaN
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 70%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .th_ket
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 12.5px;
  width: 70%;
  padding: 6px 8px;
  padding-left: 2px;
}
#hor-minimalist-b .ket_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: center;
  padding: 4px 3px;
}
#hor-minimalist-b .ket_bold_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
  padding: 6px 3px;
}
.ket_bold_total
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: right;
  padding: 6px 3px;
}
.val{
  font-weight: normal;
  font-size: 9px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 3%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .tanggal
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .anggota-luhur
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 26%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b th .nominal
{
  border-bottom: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
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
.val .ket_bold, .val .no_bold{
  text-align: center;
  font-weight: normal;
}.val_bold .no_bold{
  font-size: 9px;
  text-align: right;
  font-weight: bold;
}
.val_bold .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
.anggka
{
  width: 8.5%;
  text-align: right;
}


-->
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
        Laporan List Pencairan Pembiayaan
        </div>
        <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:12px;">
        Tanggal : <?php echo $CI->format_date_detail($tanggal1_,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_,'id',false,'-');?>
        </div>
        <hr>
      </div>
  
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:10px;">
    <tbody>
      <tr>
            <td style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 9px; width:20px;" rowspan="2">No.</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:50px;" rowspan="2">Tanggal</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px;" colspan="2">Anggota</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:100px;" rowspan="2">Majelis</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:100px;" rowspan="2">Petugas</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:70px;" rowspan="2">Plafon</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:70px;" rowspan="2">Margin</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:70px;" rowspan="2">Tab. 5%</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:50px;" rowspan="2">Periode</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:60px;" rowspan="2">Jangka Waktu</td>
      </tr>
      <tr>
            <td style="border-right:solid 1px #555; padding:5px; font-size:9px; font-weight:bold;border-bottom:solid 1px #555; text-align:center; width:100px;">No. Rekening</td>
            <td style="border-right:solid 1px #555; padding:5px; font-size:9px; font-weight:bold;border-bottom:solid 1px #555; text-align:center; width:120px;">Nama</td>
      </tr>
      <?php 
        $no=1;
        $total_pokok        = 0;
        $total_margin       = 0;
        $total_pokok_persen = 0;
      foreach ($result as $data):
        $total_pokok         += $data['pokok'];
        $total_margin        += $data['margin'];
        $total_pokok_persen  += 0.05*$data['pokok'];
        if($data['periode_jangka_waktu']==0){
          $periode_jangka_waktu = "Harian";
        }else if($data['periode_jangka_waktu']==1){
          $periode_jangka_waktu = "Mingguan";
        }else if($data['periode_jangka_waktu']==2){
          $periode_jangka_waktu = "Bulanan";
        }else{
          $periode_jangka_waktu = "Jatuh Tempo";
        }
      ?>
      <tr>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['droping_date'],'id',false,'-');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['account_financing_no'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nama'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['cm_name'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['fa_name'];?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['margin'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format(0.05*$data['pokok'],0,',','.');?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo $periode_jangka_waktu;?></td>
            <td style="padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo $data['jangka_waktu'];?></td>
      </tr>
    <?php endforeach?>
      <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right; padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;"><?php echo number_format($total_pokok,0,',','.');?></td>
            <td style="text-align: right; padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;"><?php echo number_format($total_margin,0,',','.');?></td>
            <td style="text-align: right; padding:5px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo number_format($total_pokok_persen,0,',','.');?></td>
            <td></td>
            <td></td>
            <td></td>
      </tr>
    </tbody>
</table>
</page>