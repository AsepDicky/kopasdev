<style type="text/css">
#hor-minimalist-b
{
  
  font-size: 12px;
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


/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_status
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
  width: 10px;
}
#hor-minimalist-b .val_jumlah
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
</style>
<page>
<div style="margin-left:0px">
<table id="hor-minimalist-b" align="left" style="padding-left:0px;margin-left:-20px;">
    <tbody>
      <tr class="value">
            <td style="padding:3px 5px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 5px 5px 2px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
      </tr>
      <?php
      $CI = get_instance();
      $no = $mulai_no; 
      $saldo  = $saldo_awal;
      if ($mulai_kolom>1) 
      {
        for ($i=0; $i <($mulai_kolom-1) ; $i++) {           
      ?>
      <tr class="value">
            <td style="padding:3px 5px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 5px 5px 2px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
            <td style="padding:3px 3px 5px 0px;">&nbsp;</td>
      </tr>
      <?php
        }
      } 
      foreach ($cetak_buku as $data): 

        if($data['trx_saving_type']==3){
          $sandi="PBK";
        }else if($data['trx_saving_type']==4){
          $sandi="PBM";
        }else if($data['trx_saving_type']==5){
          $sandi="TR";
        }else{
          $sandi="KAS";
        } 

        if($data['flag_debit_credit']=="D"){
          $debet = $data['amount'];
          $saldo -= $data['amount'];
        }else{
          $debet = "0";
        }   
        if($data['flag_debit_credit']=="C"){
          $credit = $data['amount'];
          $saldo += $data['amount'];
        }else{
          $credit = "0";
        }
      

      ?>
      <tr class="value">
            <td style="width:10px;font-size:8px;                  padding:3px 5px 5px 0px"><?php echo $no++;?></td>
            <td style="width:35px;font-size:8px;text-align:center;padding:3px 5px 5px 2px"><?php echo  $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <td style="width:25px;font-size:8px;text-align:right; padding:3px 3px 5px 0px"><?php echo $sandi;?></td>
            <td style="width:80px;font-size:8px;text-align:right; padding:3px 3px 5px 0px"><?php echo number_format($debet,2,',','.');?></td>
            <td style="width:68px;font-size:8px;text-align:right; padding:3px 3px 5px 0px"><?php echo number_format($credit,2,',','.');?></td>
            <td style="width:80px;font-size:8px;text-align:right; padding:3px 3px 5px 0px"><?php echo number_format($saldo,2,',','.');?></td>
            <td style="width:30px;font-size:8px;text-align:center;padding:3px 3px 5px 0px"><?php echo $this->session->userdata('user_id');;?></td>
      </tr>
    <?php 
        endforeach;
    ?>  
    </tbody>
</table>
</div>
</page>