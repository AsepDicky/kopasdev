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
        <!-- <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang;?>
        </div> -->
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
          Laporan List Pencairan Pembiayaan
        </div>
        <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
          Produk : <?php echo $produk_name;?>
        </div>
        <!-- <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
          Petugas : <?php echo $petugas_name;?>
        </div>
        <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
          Resort : <?php echo $resort_name;?>
        </div> -->
        <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
          Tanggal : <?php echo $CI->format_date_detail($tanggal1_,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_,'id',false,'-');?>
        </div>
        <hr>
      </div>
  
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:10px;">
    <tbody>
      <tr>
            <td style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 9px; width:15px;">No.</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">No. Rekening</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:160px;">Nama</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:30px;">Produk</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Akad</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Plafon</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:40px;">Margin</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:20px;">Jangka Waktu</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Angsuran</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Biaya Adm</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Biaya Notaris</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Premi Asuransi</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Premi Asuransi Tambahan</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:50px;">Status Transfer</td>
            <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:35px;">Tgl Transfer</td>
      </tr>
      <?php 
        $no=1;
        $total_pokok  = 0;
        $total_margin = 0;
        $total_ang_pokok = 0;
        $total_ang_margin = 0;
        $total_angsuran = 0;
        $total_biaya_adm = 0;
        $total_biaya_notaris = 0;
        $total_biaya_asuransi_jiwa = 0;
        $total_premi_asuransi_tambahan = 0;
        // $total_biaya_wajib_pinjam = 0;
        foreach ($result as $data):
        $total_ang_pokok  += $data['angsuran_pokok']; 
        $total_ang_margin  += $data['angsuran_margin']; 
        $total_pokok  += $data['pokok']; 
        $total_margin += $data['margin']; 
        $total_angsuran += $data['besar_angsuran']; 
        $total_biaya_adm += $data['biaya_administrasi']; 
        $total_biaya_notaris += $data['biaya_notaris']; 
        $total_biaya_asuransi_jiwa += $data['biaya_asuransi_jiwa']; 
        $total_premi_asuransi_tambahan += $data['premi_asuransi_tambahan']; 
        // $total_biaya_wajib_pinjam += $data['simpanan_wajib_pinjam']; 

        if($data['periode_jangka_waktu']==0){
          $periode_jangka_waktu = "Harian";
        }else if($data['periode_jangka_waktu']==1){
          $periode_jangka_waktu = "Mingguan";
        }else if($data['periode_jangka_waktu']==2){
          $periode_jangka_waktu = "Bulanan";
        }else{
          $periode_jangka_waktu = "Jatuh Tempo";
        }

        switch ($data['status_transfer']) {
          case '0': $status_transfer='Proses SPB';
            break; 
          case '1': $status_transfer='Belum Transfer';
            break; 
          case '2': $status_transfer='Sudah Transfer';
            break;          
          default: $status_transfer='Proses SPB';
            break;
        }
      ?>
      <tr>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['account_financing_no'];?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['cif_no'].' - '.$data['nama'];?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['product_name'];?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['tanggal_akad'],'id',false,'-');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['pokok'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['margin'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['jangka_waktu']." Bulan";?></td>
            <!-- <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['angsuran_pokok'],0,',','.');?></td> -->
            <!-- <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['angsuran_margin'],0,',','.');?></td> -->
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['besar_angsuran'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['biaya_administrasi'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['biaya_notaris'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['biaya_asuransi_jiwa'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['premi_asuransi_tambahan'],0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $status_transfer;?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php if($data['tanggal_transfer']) echo $CI->format_date_detail($data['tanggal_transfer'],'id',false,'-');?></td>
      </tr>
      <?php endforeach?>
      <tr>
            <td colspan="5"></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align:right;"><?php echo number_format($total_pokok,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_margin,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_angsuran,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_biaya_adm,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_biaya_notaris,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_biaya_asuransi_jiwa,0,',','.');?></td>
            <td style="padding:5px 2px 5px 2px; font-size:8px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($total_premi_asuransi_tambahan,0,',','.');?></td>
            <td colspan="2"></td>
      </tr>
    </tbody>
</table>
</page>