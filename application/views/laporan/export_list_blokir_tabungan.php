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
  border-top: 1px solid #6678b1;
  border-bottom: 1px solid #6678b1;
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
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .tgl
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .ket
{
  border: 1px solid #262626;
  color: #000;
  width: 15%;
  padding: 5px;
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
#hor-minimalist-b .val_ket
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 20px;
  text-align: center;
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
    <?php echo $cabang; ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
    Laporan Blokir Saldo Tabungan
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    Tanggal Blokir : <?php echo $tanggal1_view;?> s.d <?php echo $tanggal2_view;?>
    </div>
    <hr>
  </div>
  
  <table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
        <td class="no">No</td>
        <td class="anggota">No Rekening</td>
        <td class="jumlah">Nama</td>
        <td class="tgl">Tgl Blokir</td>
        <td class="status">Jumlah</td>
        <td class="tgl">Tgl Buka</td>
        <td class="ket">Keterangan</td>
      </tr>
      <?php
      $CI = get_instance();
      $no = 1; 
      $total_pokok = 0;
        foreach ($blokir_tabungan as $data):     
        $total_pokok+=$data['jumlah']; 
      ?>
      <tr class="value">
        <td class="val_anggota"><?php echo $no++;?></td>
        <td style="width:100px;" class="val_anggota"><?php echo $data['no_rek'];?></td>
        <td style="width:80px;" class="val_anggota"><?php echo $data['nama'];?></td>
        <td style="width:30px;" class="val_anggota"><?php echo $CI->format_date_detail(substr($data['tgl_blokir'],0,10),'id',false,'-');?></td>
        <td style="width:50px;" class="val_pokok"><?php echo number_format($data['jumlah'],0,',','.');?></td>
        <td class="val_ket"><?php echo $CI->format_date_detail(substr($data['tgl_buka'],0,10),'id',false,'-');?></td>
        <td class="val_ket"><?php echo $data['keterangan'];?></td>
      </tr>
      <?php 
        endforeach;
      ?>    
      <tr class="value">
        <td class="val_pokok" style="border-left:1px;" colspan="4">Total</td>
        <td class="val_pokok"><?php echo number_format($total_pokok,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>