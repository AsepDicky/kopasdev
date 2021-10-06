<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 10px 10px 10px 5px;
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
  width: 10%;
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
  width: 4%;
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
  width: 20%;
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
#hor-minimalist-b .val_tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
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
  width: 15%;
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
  padding: 6px 6px;
  text-align: center;
}
#hor-minimalist-b .val_ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
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
        <?php echo $cabang; ?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          Laporan List Pengajuan Pembiayaan
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Produk : <?php echo $produk_name;?>
        </div>
        <!-- <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Petugas : <?php echo $petugas_name;?>
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Resort : <?php echo $resort_name;?>
        </div> -->
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
          Tanggal : <?php echo $tanggal1_;?> s/d <?php echo $tanggal2_;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" >
    <tbody>
      <tr>
            <td class="no_bold">No.</td>
            <td class="ket_bold">No Registrasi</td>
            <td class="ket_bold">Nama</td>
            <td class="ket_bold">Tanggal<br>Registrasi</td>
            <td class="ket_bold">Jumlah Pengajuan</td>
            <td class="ket_bold">Status</td>
            <td class="ket_bold">Tanggal Dicairkan</td>
            <td class="ket_bold">Jumlah<br>Dicairkan</td>
            <td class="ket_bold">Melalui</td>
            <td class="ket_bold">Produk</td>
      </tr>
      <?php 
        $no=1;
        $total_amount    = 0;
        $total_jumlah_dicairkan = 0;

        foreach ($result as $data):

        $total_amount    += $data['amount'];
        $total_jumlah_dicairkan += $data['jumlah_dicairkan']; 
          if ($data['status']=='0') 
          {
            $status = "Registrasi";
          } 
          else if ($data['status']=='1')
          {
            $status = "Diaktivasi";
          }
          else if ($data['status']=='2')
          {
            $status = "Ditolak";
          }
          else if ($data['status']=='3')
          {
            $status = "Batal";
          }else{
            $status = "-";
          }

          if ($data['tanggal_dicairkan']==NULL) {
            $tanggal_dicairkan = "-";
          } else {
            $tanggal_dicairkan = $CI->format_date_detail($data['tanggal_dicairkan'],'id',false,'-');
          }

          if ($data['jumlah_dicairkan']==NULL) {
            $jumlah_dicairkan = "-";
          } else {
            $jumlah_dicairkan = number_format($data['jumlah_dicairkan'],0,',','.');
          }
          
          $array_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');          
      ?>
      <tr class="value">
            <td class="val_no_bold"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $data['registration_no'];?></td>
            <td class="val_anggota" style="width:100px;text-align:left;"><?php echo $data['nama'];?></td>
            <td class="val_anggota" style="width:100px;"><?php echo $array_hari[date('w',strtotime($data['tanggal_pengajuan']))].', '.$CI->format_date_detail($data['tanggal_pengajuan'],'id',false,'-');?></td>
            <td class="val_anggota" style="text-align:right;width:9%;"><?php echo number_format($data['amount'],0,',','.');?></td>
            <td class="val_anggota"><?php echo $status;?></td>
            <td class="val_anggota"><?php echo $tanggal_dicairkan;?></td>
            <td class="val_anggota" style="width:70px;text-align:right;"><?php echo $jumlah_dicairkan;?></td>
            <td class="val_anggota" style="width:90px"><?php echo $data['melalui'];?></td>
            <td class="val_anggota" style="width:90px;"><?php echo $data['product_name'];?></td>
      </tr>
    <?php 
        endforeach;
    ?>
      <tr class="value">
            <td colspan="3"></td>
            <td style="border-right:1px solid #000;"></td>
            <td class="val_anggota" style="text-align:right;width:70px;"><?php echo number_format($total_amount,0,',','.');?></td>
            <td></td>
            <td style="border-right:1px solid #000;"></td>
            <td class="val_anggota" style="text-align:right;width:70px;"><?php echo number_format($total_jumlah_dicairkan,0,',','.');?></td>
            <td colspan="2"></td>
      </tr>
    </tbody>
</table>
</page>