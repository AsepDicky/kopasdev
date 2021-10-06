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
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}


-->
</style>

    <h1>
        <div style="text-align:center;width:100%;font-size:17px;">
          <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
          <br/>
          LAPORAN LABA RUGI PULISH
        </div>
      <!-- <div style="border-bottom:solid 1px #000"></div> -->
    </h1>
    <div style="padding-left:30px;font-size:12px;font-weight:bold;padding-bottom:5px;">Per Tanggal : <?php echo $CI->format_date_detail($last_date,'id',false,'-');?></div>
    <div  style="padding-left:30px;font-size:12px;font-weight:bold;">Cabang  <span style="margin-left:23px;"> : <?php echo $cabang;?></span></div>
<table id="hor-minimalist-b">
    <tbody>
      <?php 
        foreach ($report_item as $data):
          if($data['item_type']=="0")
          {
            $class = "th_ket";
          }
          else if($data['item_type']=="1")
          {
            $class = "ket_bold";
          }
          else if($data['item_type']=="2")
          {
            $class = "ket";
          }
      ?>
      <tr>
            <td class="<?php echo $class?>"><?php echo $data['item_name'];?></td>
            <td class="nominal"><?php echo number_format($data['saldo'],0,',','.');?></td>
      </tr>
      <?php 
          endforeach;
      ?>
      <tr>
            <td style="border-bottom: 1px solid #262626;" colspan="2"></td>
      </tr>
    </tbody>
</table>