<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
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
  width: 7%;
  font-size: 10px;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 15%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
  font-size: 10px;
}
#hor-minimalist-b .tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 2%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
  font-size: 10px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 6.5%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
  font-size: 10px;
}
#hor-minimalist-b .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 12%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
  font-size: 10px;
}
#hor-minimalist-b .ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
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
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
  width: 15%;
  font-size: 10px;
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
.head
{
  font-size: 9px;
}

/*value*/
.value
{
  font-size: 9px;
}

#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_no_rekening
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
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  padding: 5px 0 5px 0;
  text-align: center;
  font-size: 9px;
}

-->
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
        Laporan Registrasi Pembiayaan
        </div>
        <!-- <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
        Jenis Produk : <?php if($produk==1){ echo "Individu"; }else if($produk==0){ echo "Kelompok"; } else { echo "Kelompok & Individu"; } ?>
        </div> -->
        <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
        Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b">
    <tbody>
      <tr class="head">
            <td class="no_bold" rowspan="2">No.</td>
            <td class="no_rekening" rowspan="2" style="width:70px;">No. Rekening</td>
            <td class="anggota-luhur" rowspan="2">Nama</td>
            <td class="anggota" rowspan="2" style="width:30px;">Tanggal Registrasi</td>
            <td class="anggota" rowspan="2" style="width:50px;">Plafon</td>
            <td class="anggota" rowspan="2" style="width:50px;">Margin</td>
            <!-- <td class="anggota-luhur" colspan="4">Angsuran</td> -->
            <td class="anggota-luhur" colspan="3">Angsuran</td>
            <td class="anggota" rowspan="2" style="width:50px;">Jangka Waktu</td>
            <td class="anggota2" rowspan="2" style="width:60px;">Status Rekening</td>
            <td class="anggota2" rowspan="2" style="width:90px;">Produk</td>
      </tr>
      <tr>
            <td class="ket_bold" style="width:40px;">Pokok</td>
            <td class="ket_bold" style="width:40px;">Margin</td>
            <!-- <td class="ket_bold" style="width:40px;">Catab</td> -->
            <td class="ket_bold" style="width:40px;">Total</td>
      </tr>

      <?php 
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
          $setor = $data['pokok']*0.05;

          if($data['status_rekening']=="0"){
            $status = "Registrasi";
          }else if($data['status_rekening']=="1"){
            $status = "Aktif";
          }else if($data['status_rekening']=="2"){
            $status = "Lunas";
          }else{
            $status = "Verifikasi";
          }
          
      ?>
      <tr class="value">
            <td class="val" style="padding:4px 2px;"><?php echo $no++;?></td>
            <td class="val" style="padding:4px 2px;"><?php echo $data['account_financing_no'];?></td>
            <td class="val" style="padding:4px 2px;" align="left"><?php echo $data['nama'];?></td>
            <td class="val" style="padding:4px 2px;"><?php echo (($data['tanggal_registrasi']=="")?"-":$CI->format_date_detail($data['tanggal_registrasi'],'id',false,'-')); ?></td>
            <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['margin'],0,',','.');?></td>
            <!-- <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($setor,0,',','.');?></td> -->
            <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['angsuran_pokok'],0,',','.');?></td>
            <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['angsuran_margin'],0,',','.');?></td>
            <!-- <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['angsuran_catab'],0,',','.');?></td> -->
            <td class="val" style="padding:4px 2px; width:50px;" align="right"><?php echo number_format($data['angsuran_pokok']+$data['angsuran_margin']+$data['angsuran_catab'],0,',','.');?></td>
            <td class="val" style="padding:4px 2px;"><?php echo $data['jangka_waktu'];?> <?php echo $periode;?></td>
            <td class="val" style="padding:4px 2px;"><?php echo $status;?></td>
            <td class="val" style="padding:4px 2px;"><?php echo $data['product_name'];?></td>
      </tr>      
      <?php 
          endforeach;
      ?>
    </tbody>
</table>
</page>