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
    <div style="width:100%;border-bottom:solid 1px #000;padding-bottom:5px;">
      <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
      <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
      </div>
      <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
      <?php echo $cabang; ?>
      </div>
      <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
      LAPORAN TRANSAKSI TABUNGAN
      </div>
      <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:12px;">
      Tanggal : <?php echo $CI->format_date_detail($tanggal1_,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_,'id',false,'-');?>
      </div>
      <!-- <hr> -->
    </div>
  
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:20px;">
    <thead>
      <tr>
            <th style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 10px; width:10px;">No.</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:50px;">Tanggal</th>
            <!-- <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:70px;">No. Rekening</th> -->
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:150px;">Nama</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:30px;">NIK</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:90px;">TIPE TRANSAKSI</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:10px;">D/C</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:30px;">Jumlah</th>
            <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 10px; width:130px;">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $no=1;
        $total_pokok  = 0;
        $debet_tunai=0;
        $credit_tunai=0;
        $debet_pinbuk=0;
        $credit_pinbuk=0;
      foreach ($result as $data):

        $total_pokok += $data['amount'];

        // if($data['flag_debit_credit']=="D"){
        //   $debet += $data['amount'];
        // }else{
        //   $debet = 0;
        // }   
        // if($data['flag_debit_credit']=="C"){
        //   $credit += $data['amount'];
        // }else{
        //   $credit = 0;
        // }

        switch($data['trx_saving_type']){
          case "1":
          $tipe_transaksi = "SETORAN TUNAI";
          if($data['flag_debit_credit']=='C'){
            $credit_tunai+=$data['amount'];
            $debet_tunai+=0;
          }else{
            $credit_tunai+=0;
            $debet_tunai+=$data['amount'];
          }
          break;
          case "2":
          $tipe_transaksi = "PENARIKAN TUNAI";
          if($data['flag_debit_credit']=='C'){
            $credit_tunai+=$data['amount'];
            $debet_tunai+=0;
          }else{
            $credit_tunai+=0;
            $debet_tunai+=$data['amount'];
          }
          break;
          case "3":
          $tipe_transaksi = "PEMINDAH BUKUAN KELUAR";
          if($data['flag_debit_credit']=='C'){
            $credit_pinbuk+=$data['amount'];
            $debet_pinbuk+=0;
          }else{
            $credit_pinbuk+=0;
            $debet_pinbuk+=$data['amount'];
          }
          break;
          case "4":
          $tipe_transaksi = "PEMINDAH BUKUAN MASUK";
          if($data['flag_debit_credit']=='C'){
            $credit_pinbuk+=$data['amount'];
            $debet_pinbuk+=0;
          }else{
            $credit_pinbuk+=0;
            $debet_pinbuk+=$data['amount'];
          }
          break;
          default:
          $tipe_transaksi = "-";
          break;
        }

      ?>
      <tr>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <!-- <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['account_saving_no'];?></td> -->
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nama'];?></td>
            <td style="padding:0px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['cif_no'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $tipe_transaksi; ?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $data['flag_debit_credit'];?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['amount'],0,',','.');?></td>
            <td style="padding:5px; font-size:9px; border-bottom:solid 1px #555; border-right: solid 1px #555; white-space:normal; width:130px;"><?php echo $data['description'];?></td>
      </tr>
    <?php endforeach?>
     <!--  <tr>
            <td colspan="6" style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;text-align:right;font-weight:bold;">Total</td>
            <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555;font-weight:bold;text-align:right;"><?php echo number_format($total_pokok,0,',','.');?></td>
            <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555;">&nbsp;</td>
      </tr> -->
      <tr>
            <td colspan="8" style="padding:5px; font-size:10px; text-align: center;float:right">&nbsp;</td>
      </tr>
      <tr>
            <td colspan="8">
              <table width="100%" style="border-bottom:solid 1px #555; border-left:solid 1px #555; border-top:solid 1px #555; border-right: solid 1px #555;float:right;">
                <tr>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;">Total</td>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;">Debet</td>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;">Credit</td>
                </tr>
                <tr>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;">Tunai</td>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;text-align:right;"><?php echo number_format($debet_tunai,0,',','.');?></td>
                  <td style="padding:5px; font-size:11px;width:80px;border-bottom:solid 1px #555;text-align:right;"><?php echo number_format($credit_tunai,0,',','.');?></td>
                </tr>
                <tr>
                  <td style="padding:5px; font-size:11px;width:80px;">Pinbuk</td>
                  <td style="padding:5px; font-size:11px;width:80px;text-align:right;"><?php echo number_format($debet_pinbuk,0,',','.');?></td>
                  <td style="padding:5px; font-size:11px;width:80px;text-align:right;"><?php echo number_format($credit_pinbuk,0,',','.');?></td>
                </tr>
              </table>
            </td>
      </tr>
    </tbody>
</table>
</page>