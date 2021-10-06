<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
            <input type="checkbox" class="header" checked value="" />
            <span class="color-mode-label">Fixed Header</span>
            </label>                   
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        GL Inquiry <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG DETAIL TRANSACTION -->
<div id="dialog_detail_transaction" style="display:none" title="Detail Transaction">
  <table id="table_detail_transaction" width="100%">
    <thead>
      <tr>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;border-left:solid 1px #999;width:5%">NO</th>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;width:15%">ACCOUNT CODE</th>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;width:25%">ACCOUNT NAME</th>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;width:30%">DESCRIPTION</th>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;width:15%;">AMOUNT</th>
        <th style="text-align:center;font-size:11px;border-bottom:solid 1px #999;border-top:solid 1px #999;border-right:solid 1px #999;width:10%">D/C</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari Kantor Cabang</h3>
  </div>
  <div class="modal-body">
     <div class="row-fluid">
        <div class="span12">
           <h4>Masukan Kata Kunci</h4>
           <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
           <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
        </div>
     </div>
  </div>
  <div class="modal-footer">
     <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
     <button type="button" id="select" class="btn blue">Select</button>
  </div>
</div>
<!-- DIALOG GL ACCOUNT -->
<div id="dialog_gl_account" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari GL Account</h3>
  </div>
  <div class="modal-body">
     <div class="row-fluid">
        <div class="span12">
           <h4>Masukan Kata Kunci</h4>
           <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
           <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
        </div>
     </div>
  </div>
  <div class="modal-footer">
     <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
     <button type="button" id="select" class="btn blue">Select</button>
  </div>
</div>

<!-- BEGIN FORM-->
<div class="portlet-body form">
   <!-- BEGIN FILTER FORM -->
   <form class="form-horizontal">
      <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
      <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
      <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
      <input type="hidden" name="gl_account_id" id="gl_account_id">
      <input type="hidden" name="account_code" id="account_code">
      <table id="filter-form">
         <tr>
            <td width="100">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap mfi-textfield" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background:#EEE"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
            </td>
         </tr>
         <tr>
            <td>GL Account</td>
            <td>
               <input type="text" name="gl_account" class="m-wrap mfi-textfield" readonly style="background:#EEE"> 
               <a id="browse_gl_account" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_gl_account">...</a>
            </td>
         </tr>
         <tr>
            <td>Tanggal</td>
            <td valign="middle">
               <input type="text" class="mfi-textfield mask_date m-wrap date-picker" value="<?php echo $current_date; ?>" id="from_date" name="from_date" style="width:100px"> 
               <span style="line-height:45px;">&nbsp;s/d &nbsp;</span>
               <input type="text" class="mfi-textfield mask_date m-wrap date-picker" value="<?php echo $current_date; ?>" id="thru_date" name="thru_date" style="width:100px">
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="filter">Filter</button>
               <button class="green btn" id="preview-pdf">Preview</button>
               <button class="green btn" id="preview-excel">Preview Excel</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
   <table width="100%" border="1" bordercolor="#CCC" cellpadding="5" id="general_ledger">
      <thead>
         <tr>
            <th style="background:#EEE;" width="5%">No.</th>
            <th style="background:#EEE;" width="10%">Tanggal Transaksi</th>
            <th style="background:#EEE;">Deskripsi</th>
            <th style="background:#EEE;" width="15%">Debet</th>
            <th style="background:#EEE;" width="15%">Credit</th>
            <th style="background:#EEE;" width="15%">Saldo Akhir</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td colspan="6" align="center" style="padding:10px 5px;">
              Please Fill The Filter Option to Show Form
            </td>
         </tr>
      </tbody>
      <tfoot>
         <tr>
            <td></td>
            <td align="center"></td>
            <td align="right">Total</td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_debit"></span></td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_credit"></span></td>
            <td></td>
         </tr>
      </tfoot>
   </table>
</div>

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">

$(function(){
/* BEGIN SCRIPT */
  
  /* BEGIN PREVIEW PDF */
  $("#preview-pdf").click(function(e){
    e.preventDefault();
    var branch_code = $("#branch_code").val();
    var account_code = $("#account_code").val();
    if(account_code==""){
      account_code = '-';
    }
    var from_date = $("#from_date").val().replace(/\//g,'');
    var thru_date = $("#thru_date").val().replace(/\//g,'');

    window.open(site_url+"laporan_to_pdf/list_jurnal_umum_gl/"+branch_code+"/"+account_code+"/"+from_date+"/"+thru_date);
  })
  /* BEGIN PREVIEW PDF */
  $("#preview-excel").click(function(e){
    e.preventDefault();
    var branch_code = $("#branch_code").val();
    var account_code = $("#account_code").val();
    if(account_code==""){
      account_code = '-';
    }
    var from_date = $("#from_date").val().replace(/\//g,'');
    var thru_date = $("#thru_date").val().replace(/\//g,'');

    window.open(site_url+"laporan_to_excel/list_jurnal_umum_gl/"+branch_code+"/"+account_code+"/"+from_date+"/"+thru_date);
  })

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '<option value="0000" branch_id="0000" branch_name="Semua Branch">Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '<option value="0000" branch_id="0000" branch_name="Semua Branch">Semua Branch</option>';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
      result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      result_code = $("#result","#dialog_branch").val();
      if(result!=null)
      {
         $("input[name='branch']").val(result_name);
         $("input[name='branch_code']").val(result_code);
         $("input[name='branch_id']").val(branch_id);
         $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })

   /* END DIALOG ACTION BRANCH */
   /*---------------------------------------------------------------------------------------------------------*/
   /* BEGIN DIALOG ACTION GL ACCOUNT */
  
   $("#browse_gl_account").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"gl/get_gl_account_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_gl_account").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].account_code+'" account_name="'+response[i].account_name+'">'+response[i].account_code+' - '+response[i].account_name+'</option>';
            }
            $("#result","#dialog_gl_account").html(html);
         }
      })
   })

   $("#keyword","#dialog_gl_account").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"gl/get_gl_account_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].account_code+'" gl_account_id="'+response[i].gl_account_id+'" account_name="'+response[i].account_name+'">'+response[i].account_code+' - '+response[i].account_name+'</option>';
               }
               $("#result","#dialog_gl_account").html(html);
            }
         })
      }
   });

   $("#select","#dialog_gl_account").click(function(){
      gl_account_id = $("#result option:selected","#dialog_gl_account").attr('gl_account_id');
      account_code = $("#result","#dialog_gl_account").val();
      account_name = $("#result option:selected","#dialog_gl_account").attr('account_name');
      if(result!=null)
      {
         $("input[name='gl_account']").val(account_name);
         $("input[name='gl_account_id']").val(gl_account_id);
         $("input[name='account_code']").val(account_code);
         $("#close","#dialog_gl_account").trigger('click');
      }
   });

   $("#result option:selected","#dialog_gl_account").live('dblclick',function(){
    $("#select","#dialog_gl_account").trigger('click');
   })

   /* END DIALOG ACTION GL ACCOUNT */

   $("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_gl_account_history",
         data: {
            branch_code : $("#branch_code").val(),
            account_code : $("#account_code").val(),
            from_date : $("#from_date").val(),
            thru_date : $("#thru_date").val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td align="center"><a href="javascript:void(0);" data-id="'+response['data'][i].trx_gl_id+'" id="btn_detail_transaction">'+response['data'][i].trx_date+'</a></td> \
                  <td>'+response['data'][i].description+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].debit!="")?number_format(response['data'][i].debit,2,',','.'):"-")+'</td> \
                  <td align="right" style="font-size:14px;">'+((response['data'][i].credit!="")?number_format(response['data'][i].credit,2,',','.'):"-")+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_akhir,2,',','.')+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });

  $("#dialog_detail_transaction").dialog({
    modal:true,
    autoOpen:false,
    width:800,
    height:400,
    buttons:{
      'Close':function(){
        $(this).dialog('close');
      }
    }
  });
  
  $("a#btn_detail_transaction").live('click',function(){
    $("#dialog_detail_transaction").dialog('open');
    trx_gl_id=$(this).attr('data-id');
    $.ajax({
      type:"POST",
      url:site_url+"laporan/get_detail_transaction",
      dataType:"json",
      data: {
        trx_gl_id:trx_gl_id
      },
      success:function(response){
        html = '';
        for(x in response){
          html += '<tr> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999; font-size:11px; text-align:center;">'+(parseFloat(x)+1)+'</td> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; font-size:11px; text-align:center;">'+response[x].account_code+'</td> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; font-size:11px; text-align:left;padding:0 5px;">'+response[x].account_name+'</td> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; font-size:11px; text-align:left;padding:0 5px;">'+response[x].description+'</td> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; font-size:11px; text-align:right;padding:0 5px">'+number_format(response[x].amount,0,',','.')+'</td> \
            <td style="border-bottom:solid 1px #999; border-right:solid 1px #999; font-size:11px; text-align:center;">'+response[x].flag_debit_credit+'</td> \
          </tr>';
        }
        $("#table_detail_transaction tbody").html(html);
      }
    });
  });

/* END SCRIPT */
})
</script>