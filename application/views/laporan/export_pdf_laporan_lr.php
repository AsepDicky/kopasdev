<page backbottom="10mm">
<page_footer><div style="text-align:center;width:100%;">([[page_cu]])</div></page_footer>
<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 30px 30px 30px 20px;
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
#hor-minimalist-b tr .nototal
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 50%;
  padding: 10px 8px;
  border: 1px solid #262626;

}
#hor-minimalist-b tr .end
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b tr .no_total
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  text-align: right;
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
}
#hor-minimalist-b tr .no_total_end
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b tr .total
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  text-align: right;
  font-weight: bold;
  padding: 10px 8px;
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
}
#hor-minimalist-b .ket
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  padding-left: 35px;
}
#hor-minimalist-b .ket_NaN
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .th_ket
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 12.5px;
  width: 50%;
  padding: 6px 8px;
  padding-left: 5px;
}
#hor-minimalist-b .ket_bold_th
{
  /*border-bottom: 1px solid #262626;*/
  font-weight: bold;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 20px;
}
#hor-minimalist-b .ket_bold
{
  /*border-bottom: 1px solid #262626;*/
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 20px;
}
#hor-minimalist-b .center_bold
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  text-align: center;
  font-weight: bold;
}
#hor-minimalist-b th .nominal
{
  /*border-bottom: 1px solid #262626;*/
  /*border-top: 1px solid #262626;*/
  /*border-right: 1px solid #262626;*/
  color: #000;
  width: 15%;
  text-align: right;
  padding: 6px 8px;
  font-size:12px;
}
#hor-minimalist-b .nominal
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  /*border-top: 1px solid #262626;*/
  border-right: 1px solid #262626;
  color: #000;
  width: 15%;
  text-align: right;
  padding: 6px 8px;
  font-size:12px;
}


-->
</style>

    <h1>
        <div style="text-align:center;width:100%;font-size:17px;line-height:25px">
          <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
          <br/>
          <?php echo $cabang;?>
          <br/>
          LAPORAN LABA RUGI
        </div>
      <!-- <div style="border-bottom:solid 1px #000"></div> -->
    </h1>
    <!-- <div style="padding-left:30px;font-size:12px;font-weight:bold;padding-bottom:5px;">Per Tanggal : <?php echo $CI->format_date_detail($last_date,'id',false,'-');?></div> -->
    <div style="padding-left:20px;font-size:12px;font-weight:bold;padding-bottom:5px;">Per Tanggal : <?php echo $CI->format_date_detail($last_date,'id',false,'-');?></div>
<table id="hor-minimalist-b" style="border:solid 1px #262626 !important;">
    <thead>
      <tr>
            <th style="border: 1px solid #262626;"></th>
            <th style="font-size:12px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">sd Bulan Lalu</th>
            <th style="font-size:12px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Bulan Ini</th>
            <th style="font-size:12px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Akumulasi</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $saldo='';
        $saldo_mutasi='';
        $total_saldo='';
        $num_data=count($report_item);
        $i=0;
        foreach ($report_item as $data):
          $i++;
          if($data['item_type']=="0") // title
          {
            if($data['posisi']=='0'){
              $class = "th_ket";
            }else if($data['posisi']=="1"){
              $class = "ket_bold_th";
            }else if($data['posisi']=="2"){
              $class = "ket";
            }else{
              $class = 'ket';
            }
            $saldo = '';
            $saldo_mutasi = '';
            $total_saldo = '';
          }
          else if($data['item_type']=="1") // summary
          {
            $class = "ket_bold";
            $saldo = number_format($data['saldo'],0,',','.');
            $saldo_mutasi = number_format($data['saldo_mutasi'],0,',','.');
            $total_saldo = number_format(($data['saldo']+$data['saldo_mutasi']),0,',','.');
          }
          else if($data['item_type']=="2") // formula
          {
            if($data['formula_text_bold']=='0')
            {
              if($data['posisi']=='0'){
                $class = "th_ket";
              }else if($data['posisi']=="1"){
                $class = "ket_bold";
              }else if($data['posisi']=="2"){
                $class = "ket_bold";
              }else{
                $class = 'ket_bold';
              }
            }
            else if($data['formula_text_bold']=='1')
            {
              if($data['posisi']=='0'){
                $class = "th_ket";
              }else if($data['posisi']=="1"){
                $class = "ket_bold_th";
              }else if($data['posisi']=="2"){
                $class = "ket_bold_th";
              }else{
                $class = 'ket_bold_th';
              }
            }
            $saldo = number_format($data['saldo'],0,',','.');
            $saldo_mutasi = number_format($data['saldo_mutasi'],0,',','.');
            $total_saldo = number_format(($data['saldo']+$data['saldo_mutasi']),0,',','.');
          }
          else if($data['item_type']=="3") // TOTAL
          {
            if($data['posisi']=='0'){
              $class = "th_ket";
            }else if($data['posisi']=="1"){
              $class = "ket_bold_th";
            }else if($data['posisi']=="2"){
              $class = "ket";
            }else{
              $class = 'ket';
            }
            $saldo = number_format($data['saldo'],0,',','.');
            $saldo_mutasi = number_format($data['saldo_mutasi'],0,',','.');
            $total_saldo = number_format(($data['saldo']+$data['saldo_mutasi']),0,',','.');
          }

          $border_bottom_last_row='';
          if($num_data==$i){
            $border_bottom_last_row='style="border-bottom:solid 1px #262626;"';
          }
      ?>
      <tr>
            <td <?php echo $border_bottom_last_row; ?> class="<?php echo $class?>"><?php echo $data['item_name'];?></td>
            <td <?php echo $border_bottom_last_row; ?> class="nominal"><?php echo $saldo;?></td>
            <td <?php echo $border_bottom_last_row; ?> class="nominal"><?php echo $saldo_mutasi;?></td>
            <td <?php echo $border_bottom_last_row; ?> class="nominal"><?php echo $total_saldo;?></td>
      </tr>
      <?php 
          endforeach;
      ?>
    </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- <table style="margin-left:30px;">
  <tr>
    <td style="width:335px;text-align:center;font-size:12px;">
      Mengetahui
      <br>
      &nbsp;
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php
      switch ($branch_class) {
        case '0':
          echo "Kepala Pusat";
          break;
        case '1':
          echo "Kepala Wilayah";
          break;
        case '2':
          echo "Kepala Cabang";
          break;
        case '3':
          echo "Kepala Capem";
          break;
        
        default:
          echo "-";
          break;
      }
      ?>
    </td>
    <td style="width:335px;text-align:center;font-size:12px;">
      <table align="center" style="width:auto;">
        <tr>
          <td style="text-align:left;">
            <?php echo $cabang.', '.date('d-m-Y'); ?>
            <br>
            dibuat
          </td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php echo $this->session->userdata('fullname'); ?>
    </td>
  </tr>
</table> -->
<table style="margin-left:30px;">
  <tr>
    <td style="width:335px;text-align:center;font-size:12px;">
      <br>
      Mengetahui
      <br>
      &nbsp;
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php
      // switch ($branch_class) {
      //   case '0':
      //     echo "Kepala Pusat";
      //     break;
      //   case '1':
      //     echo "Kepala Wilayah";
      //     break;
      //   case '2':
      //     echo "Kepala Cabang";
      //     break;
      //   case '3':
      //     echo "Kepala Capem";
      //     break;
      //   default:
      //     echo "-";
      //     break;
      // }
        echo $branch_officer_name;
      ?>
    </td>
    <td style="width:335px;text-align:center;font-size:12px;">
      <table align="center" style="width:auto;">
        <tr>
          <td style="text-align:center;">
            <?php echo 'BANDUNG, '.date('d-m-Y'); ?>
            <br>
            membuat
          </td>
        </tr>
      </table>
            <br>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php echo $this->session->userdata('fullname'); ?>
    </td>
  </tr>
</table>
</page>
