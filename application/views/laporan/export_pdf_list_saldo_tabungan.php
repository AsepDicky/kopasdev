<?php
$CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 8px;
  background: #fff;
  margin-top: 10px;
  border-collapse: collapse;
  /*text-align: left;*/
}
#hor-minimalist-b td {
  font-size: 8px;
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
  width: 9%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 14%;
  font-weight: bold;
  /*text-align: center;*/
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
  /*text-align: center;*/
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
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
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
  /*text-align: center;*/
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
  /*text-align: center;*/
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
  /*text-align: center;*/
}
#hor-minimalist-b th .nominal
{
  border-bottom: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  /*text-align: right;*/
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
  /*text-align: right;*/
  padding: 6px 8px;
}

/*value*/
.value
{
  /*font-size: 11px;*/
}

#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val_ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  padding: 5px 0 5px 0;
  /*text-align: center;*/
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
        Daftar Saldo Rekening Anggota
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b">
    <tbody>
        <tr>
          <td colspan="2" align="center" valign="middle" class="anggota-luhur">Anggota</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:50px;">Rembug Pusat</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:50px;">Desa</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:20px;">Tanggal Relisasi</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:30px;">Pembiayaan Pokok</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:30px;">Pembiayaan Margin</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:5px;">PYD Ke</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:30px;">Periode</td>
          <td colspan="5" align="center" valign="middle" class="anggota2" >Saldo Simpanan</td>
          <td colspan="2" align="center" valign="middle" class="anggota2" >Saldo Pembiayaan</td>
        </tr>
        <tr>
          <td align="center" valign="middle" class="no_bold" style="wiidth:85px;">ID</td>
          <td align="center" valign="middle" class="no_bold" style="width:45px;">Nama</td>
          <td align="center" valign="middle" class="no_bold" style="width:21px;">LWK</td>
          <td align="center" valign="middle" class="no_bold" style="width:21px;">Investasi</td>
          <td align="center" valign="middle" class="no_bold" style="width:21px;">Mingguan</td>
          <td align="center" valign="middle" class="no_bold" style="width:21px;">Sukarela</td>
          <td align="center" valign="middle" class="no_bold" style="width:21px;">Kelompok</td>
          <td align="center" valign="middle" class="no_bold" style="width:30px;">Pokok</td>
          <td align="center" valign="middle" class="no_bold" style="width:30px;">Margin</td>
        </tr>
     <?php 
        $no=1;
        $total_pokok = 0;
        $total_margin = 0;
        $total_setoran_lwk = 0;
        $total_simpanan_pokok = 0;
        $total_tabungan_minggon = 0;
        $total_tabungan_sukarela = 0;
        $total_tabungan_kelompok = 0;
        $total_saldo_pokok = 0;
        $total_saldo_margin = 0;
        foreach ($saldo_tabungan as $data):
          if (@$data['periode_jangka_waktu']=="0") 
          {
            $periode = "Hari";
          } 
          else if (@$data['periode_jangka_waktu']=="1") 
          {
            $periode = "Minggu";
          }
          else if (@$data['periode_jangka_waktu']=="2") 
          {
            $periode = "Bulan";
          }
          else if (@$data['periode_jangka_waktu']=="3") 
          {
            $periode = "Jatuh Tempo";
          }
          else
          {
            $periode = "";
          }
          $total_pokok += $data['pokok'];
          $total_margin += $data['margin'];
          $total_setoran_lwk += $data['setoran_lwk'];
          $total_simpanan_pokok += $data['simpanan_pokok'];
          $total_tabungan_minggon += $data['tabungan_minggon'];
          $total_tabungan_sukarela += $data['tabungan_sukarela'];
          $total_tabungan_kelompok += $data['tabungan_kelompok'];
          $total_saldo_pokok += $data['saldo_pokok'];
          $total_saldo_margin += $data['saldo_margin'];

          // $cnt = $data['saldo_pokok']/$data['angsuran_pokok'];
      ?>

      <tr class="value">
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;"><?php echo $data['cif_no'];?></td>
        <td align="left" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['nama'];?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['cm_name'];?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['desa'];?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo @$CI->format_date_detail($data['tanggal_mulai_angsur'],'id',false,'-');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['pokok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['margin'],0,',','.');?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['pyd_ke']; ?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['jangka_waktu']. ' '. $periode;?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['setoran_lwk'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['simpanan_pokok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tabungan_minggon'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tabungan_sukarela'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tabungan_kelompok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
      </tr>
     <?php 
          endforeach;
      ?>

      <tr class="value">
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;" colspan="5">Total :</td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_pokok,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_margin,0,',','.');?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;" colspan="2">&nbsp;</td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_setoran_lwk,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_simpanan_pokok,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_tabungan_minggon,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_tabungan_sukarela,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_tabungan_kelompok,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_saldo_margin,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>