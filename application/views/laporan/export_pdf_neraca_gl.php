<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 30px;
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
  width: 70%;
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
  width: 70%;
  padding: 6px 8px;
  padding-left: 35px;
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
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 12.5px;
  width: 70%;
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
  width: 70%;
  padding: 6px 20px;
}
#hor-minimalist-b .ket_bold
{
  /*border-bottom: 1px solid #262626;*/
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 70%;
  padding: 6px 20px;
}
#hor-minimalist-b .center_bold
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 70%;
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
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}
#hor-minimalist-b .nominal
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  /*border-top: 1px solid #262626;*/
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}


-->
</style>

  <h1>
      <div style="text-align:center;width:100%;font-size:17px;line-height:25px">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        <br/>
        <?php echo $branch_name;?>
        <br>
        LAPORAN NERACA
      </div>
    <!-- <div style="border-bottom:solid 1px #000"></div> -->
  </h1>
  <div style="padding-left:30px;font-size:12px;font-weight:bold;padding-bottom:5px;">Per Tanggal : <?php echo $CI->format_date_detail($last_date,'id',false,'-');?></div>
  
  <table id="hor-minimalist-b">
    <tbody>
      <tr>
            <td style="border-bottom: 1px solid #262626;" colspan="2"></td>
      </tr>
      <?php
      $i = 0;
      
        foreach ($result as $data):
          
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
          }
          else if($data['item_type']=="1") // summary
          {
            $class = "ket_bold";
            $saldo = number_format($data['saldo'],0,',','.');
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
          }

          $i++;
      ?>
      <tr>
            <td class="<?php echo $class?>"><?php echo $data['item_name'];?></td>
            <td class="nominal"><?php echo $saldo;?></td>
      </tr>
    <?php 
        endforeach;
    ?>
      <tr>
            <td style="border-bottom: 1px solid #262626;" colspan="2"></td>
      </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
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