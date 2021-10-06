<?php 
  $CI = get_instance();
?>
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
        Laporan Data Lengkap Anggota
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" width="300">
    <tbody>
    <?php 
    foreach($anggota as $data):
    if($data['jenis_kelamin']=="P"){
      $jenis_kelamin = "PRIA";
    }else{
      $jenis_kelamin = "WANITA";
    }
    if($data['pendapatan_perbulan']==""){
      $pendapatan_perbulan = "";
    }else{
      $pendapatan_perbulan =  isset($data['pendapatan_perbulan'])?number_format($data['pendapatan_perbulan'],0,',','.'):"";
    }
    ?>
      <tr>
        <td width="150" align="left">Id Anggota</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['cif_no']) ? $data['cif_no'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">Nama</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['nama']) ? $data['nama'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">Alamat</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['alamat']) ? $data['alamat'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">Tempat, Tanggal Lahir</td>
        <td width="3" align="left">:</td>
        <td><?php echo $data['tmp_lahir'];?>, <?php echo $CI->format_date_detail($data['tgl_lahir'],'id',false,'-');?></td>
      </tr>
      <tr>
        <td width="150" align="left">Jenis Kelamin</td>
        <td width="3" align="left">:</td>
        <td><?php echo $jenis_kelamin;?></td>
      </tr>
      <tr>
        <td width="150" align="left">Nama Ibu Kandung</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['ibu_kandung']) ? $data['ibu_kandung'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">No. KTP</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['no_ktp']) ? $data['no_ktp'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">No. KTP Pasangan</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['identitas_pasangan']) ? $data['identitas_pasangan'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">Pekerjaan</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['pekerjaan']) ? $data['pekerjaan'] : "-";?></td>
      </tr>
      <tr>
        <td width="150" align="left">Pendapatan</td>
        <td width="3" align="left">:</td>
        <td>Rp. <?php echo $pendapatan_perbulan;?> ,-</td>
      </tr>
      <tr>
        <td width="150" align="left">Tanggal Gabung</td>
        <td width="3" align="left">:</td>
        <td><?php echo isset($data['tgl_gabung'])?$CI->format_date_detail($data['tgl_gabung'],'id',false,'-'):"";?></td>
      </tr>
    <?php endforeach?>
    </tbody>
</table>
<div style="border-bottom:solid 1px #A5A5A5;margin-top:15px;"></div>
<div style="font-weight:bold;">REKENING ANGGOTA</div>
<?php if(count($tabungan)>0){?>
<div style="font-weight:bold;margin-top:10px;">Tabungan</div>
<?php } ?>
<table id="hor-minimalist-b" width="100%">
    <tbody>
      <?php if(count($tabungan)>0){?>
      <tr>
        <td width="20" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">NO</td>
        <td width="150" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">NO REKENING</td>
        <td width="150" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">PRODUK</td>
        <td width="100" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">SALDO</td>
        <td width="100" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">STATUS</td>
      </tr>
      <?php } ?>
    <?php 
    $no=1;
    foreach($tabungan as $data):
      if($data['status_rekening']==1){
        $status = "Aktif";
      }else if($data['status_rekening']==2){
        $status = "Tutup";
      }else if($data['status_rekening']==3){
        $status = "Blokir";
      }
    ?>
      <tr>
        <td width="20" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $no++;?></td>
        <td width="150" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $data['account_saving_no'];?></td>
        <td width="150" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $data['product_name'];?></td>
        <td width="100" style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:10px;"><?php echo number_format($data['saldo_memo'],0,',','.');?></td>
        <td width="100" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $status;?></td>
      </tr>
    <?php endforeach?>
    </tbody>
</table>
<?php if(count($deposito)>0){?>
<div style="font-weight:bold;margin-top:10px;">Deposito</div>
<?php } ?>
<table id="hor-minimalist-b" width="100%">
    <tbody>
      <?php if(count($deposito)>0){?>
      <tr>
        <td width="20" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">NO</td>
        <td width="150" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">NO REKENING</td>
        <td width="150" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">PRODUK</td>
        <td width="100" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">SALDO</td>
        <td width="100" style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:10px;">STATUS</td>
      </tr>
      <?php } ?>
    <?php 
    $no=1;
    foreach($deposito as $data):
      if($data['status_rekening']==0){
        $status = "Registrasi";
      }else if($data['status_rekening']==1){
        $status = "Aktif";
      }else if($data['status_rekening']==2){
        $status = "Tutup";
      }
    ?>
      <tr>
        <td width="20" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $no++;?></td>
        <td width="150" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $data['account_deposit_no'];?></td>
        <td width="150" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $data['product_name'];?></td>
        <td width="100" style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:10px;"><?php echo number_format($data['nominal'],0,',','.');?></td>
        <td width="100" style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:10px;"><?php echo $status;?></td>
      </tr>
    <?php endforeach?>
    </tbody>
</table>
<?php if(count($pembiayaan)>0){?>
<div style="font-weight:bold;margin-top:10px;">Pembiayaan</div>
<?php } ?>
<table id="hor-minimalist-b" width="100%">
    <tbody>
      <?php if(count($pembiayaan)>0){?>
      <tr>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">NO</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">NO REKENING</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">PRODUK</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">PLAFON</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">MARGIN</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">JANGKA WAKTU</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">ANGSURAN</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">SALDO POKOK</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">SALDO MARGIN</td>
        <td style="border:solid 1px #555; padding:8px; text-align:center;font-weight:bold;font-size:9px;">STATUS</td>
      </tr>
      <?php } ?>
    <?php 
    $no=1;
    foreach($pembiayaan as $data):
      if($data['status_rekening']==0){
        $status = "Registrasi";
      }else if($data['status_rekening']==1){
        $status = "Aktif";
      }else if($data['status_rekening']==2){
        $status = "Lunas";
      }else if($data['status_rekening']==3){
        $status = "Verifikasi";
      }
      if($data['periode_jangka_waktu']==0){
        $periode = "Harian";
      }else if($data['periode_jangka_waktu']==1){
        $periode = "Mingguan";
      }else if($data['periode_jangka_waktu']==2){
        $periode = "Bulanan";
      }else if($data['periode_jangka_waktu']==3){
        $periode = "Jatuh Tempo";
      }
	  
	  $angsuran = $data['angsuran_pokok'] + $data['angsuran_margin'] + $data['angsuran_catab'];
    ?>
      <tr>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=20px;"><?php echo $no++;?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=100px;"><?php echo $data['account_financing_no'];?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=50px;"><?php echo $data['product_name'];?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:8px;width=50px;"><?php echo number_format($data['pokok'],0,',','.');?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:8px;width=50px;"><?php echo number_format($data['margin'],0,',','.');?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=70px;"><?php echo $data['jangka_waktu'];?> <?php echo $periode;?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=50px;"><?php echo number_format($angsuran,0,',','.');?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:8px;width=50px;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:right;font-weight:bold;font-size:8px;width=50px;"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
        <td style="border:solid 1px #555; padding:3px; text-align:center;font-weight:bold;font-size:8px;width=50px;"><?php echo $status;?></td>
      </tr>
    <?php endforeach?>
    </tbody>
</table>
</page>