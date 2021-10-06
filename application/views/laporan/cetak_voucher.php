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
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title">
      CETAK JURNAL VOUCHER <small>modul untuk mencetak jurnal voucher</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="#">Transaction</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">General Ledger</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">CETAK VOUCHER</a></li>  
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- 
<div id="dialog_search" class="modal hide fade" tabindex="-1" data-width="500">
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Cari Jurnal</h3>
 </div>
 <div class="modal-body">
    <div class="row-fluid">
       <div class="span3" style="line-height:30px;">Tanggal Transaksi</div>
       <div class="span1" style="line-height:30px;" align="right">:</div>
       <div class="span8">
          <input type="text" class="m-wrap small mask_date date-picker" placeholder="From Date" id="from_date">
          <input type="text" class="m-wrap small mask_date date-picker" placeholder="To Date" id="to_date">
       </div>
    </div>
    <div class="row-fluid">
       <div class="span3" style="line-height:30px;">Voucher Ref</div>
       <div class="span1" style="line-height:30px;" align="right">:</div>
       <div class="span8">
          <input type="text" class="m-wrap normal" id="voucher_ref">
       </div>
    </div>
    <div class="row-fluid">
       <div class="span3" style="line-height:30px;">Voucher No</div>
       <div class="span1" style="line-height:30px;" align="right">:</div>
       <div class="span8">
          <input type="text" class="m-wrap normal" id="voucher_no">
       </div>
    </div>
 </div>
 <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
    <button type="button" id="search" class="btn blue">Search</button>
 </div>
</div> -->

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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>CETAK JURNAL VOUCHER</div>
   </div>
   <div class="portlet-body">
      <!-- <div class="clearfix">
         <div class="btn-group pull-left">
            <a href="#dialog_search" data-toggle="modal" id="btn_search" class="btn purple" style="margin-right:10px;">
              Search <i class="icon-search"></i>
            </a>
         </div>
      </div>
 -->
      <table id="filter-form">
         <!-- <tr>
            <td width="150">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap mfi-textfield" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background:#EEE"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
               <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
            </td>
         </tr> -->
         <tr>
            <td width="150">Tanggal Transaksi</td>
            <td>
              <input type="text" class="m-wrap small mask_date date-picker" placeholder="From Date" id="from_date" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              <input type="text" class="m-wrap small mask_date date-picker" placeholder="To Date" id="to_date" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
            </td>
         </tr>
         <tr>
            <td width="150">Jenis Transaksi</td>
            <td valign="top">
              <select id="jurnal_trx_type" class="m-wrap small" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                <option value="">Semua</option>
                <option value="0">Jurnal Umum</option>
                <option value="1">Tabungan</option>
                <!-- <option value="2">Deposito</option> -->
                <option value="3">Pembiayaan</option>
              </select>
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="blue btn" id="search" style="margin-top:5px;">Search</button>
            </td>
         </tr>
      </table>
      <hr>
      <table class="table table-striped table-bordered table-hover" id="voucher_table">
         <thead>
            <tr>
               <th width="10%">Tanggal</th>
               <th width="15%">Voucher No</th>
               <th width="10%">No Referensi</th>
               <th width="30%">Description</th>
               <th width="13%">Total Debit</th>
               <th width="13%">Total Credit</th>
               <th width="9%">Cetak</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- print voucher area -->
<div id="print_voucher_area" style="display:none;font-size:10px;">

  <div style="border:solid 1px #000; padding:10px;">

    <div align="center">
      <h4 class="pa_voucher_type" style="font-weight:bold;">JURNAL MEMORIAL VOUCHER</span></h4>
    </div>
    <br>
    <table style="width:100%">
      <tr>
        <td valign="top" width="12%" style="font-size:12px;white-space:nowrap">Nomor Voucher</td>
        <td valign="top" width="1%" style="font-size:12px">:</td>
        <td class="print_nomor_voucher" style="font-size:12px"></td>
        <td width="5%">&nbsp;</td>
        <td style="white-space:nowrap;font-size:12px;width:25%">
          Tanggal Pembukuan : <span class="print_tanggal_pembukuan" style="font-size:12px;"></span>
        </td>
      </tr>
    </table>

    <p></p>

    <table style="width:100%" id="pa_transaction">
      <thead>
        <tr>
          <th style="font-size:12px; border:solid 1px #AAA;" width="7%">NO</th>
          <th style="font-size:12px; border:solid 1px #AAA;" width="15%">ACCOUNT CODE</th>
          <th style="font-size:12px; border:solid 1px #AAA;">ACCOUNT NAME</th>
          <th style="font-size:12px; border:solid 1px #AAA;" width="15%">DEBIT</th>
          <th style="font-size:12px; border:solid 1px #AAA;" width="15%">CREDIT</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
    <br>
    <!-- <div style="font-size:12px">Amount Received : <span class="pa_amount" style="font-size:12px"></span></div>
    <div style="font-size:12px">Say : <span class="pa_say_amount" style="font-size:12px"></span></div>
    <br> -->
    <div style="font-size:12px">Printed By : <span class="pa_printed_by" style="font-size:12px"><?php echo $this->session->userdata('username'); ?></span>, <span class="pa_printed_date"><?php echo date('d-m-Y'); ?></span></div>
    <div style="overflow:hidden;">
      <table align="right" width="200">
      <tr>
        <td style="font-size:12px">
          <span class="pa_branch" style="font-size:12px"><?php echo $this->session->userdata('branch_name'); ?>,</span> <?php echo date('d-m-Y') ?> <br>
          Approve by : <br>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <span style="font-size:14px;">(</span>......................................................<span style="font-size:14px;">)</span>
        </td>
      </tr>
      </table>
    </div>
  </div>
  <div align="center" style="padding:10px;">
    <button class="btn green print_now">Print Now</button>
    &nbsp;
    <button class="btn red cancel">Cancel</button>
  </div>

</div>



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-components.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>           
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/scripts/ui-modals.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {
      App.init() // initlayout and core plugins
      Index.init()
      $(".mask_date").inputmask("d/m/y")  //direct mask    
      // FormComponents.init();
      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){


   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
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
               html = '';
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

  $(".print_now").click(function(){
    $(".print_now").hide();
    $(".cancel").hide();
    $("#print_voucher_area").printElement();
    $(".cancel").show();
    $(".print_now").show();
  });

  $(".cancel").click(function(){
    $("#print_voucher_area").hide();
    $("#wrapper-table").show();
  })

  $("a#btn-cetakvoucher").live('click',function(){
    // n = 0;
    // $("input#checkbox:checked").each(function(){
    //   n++;
    // });
    // if(n>1 || n==0){
    //   alert("mohon pilih salah satu");
    // }else{
      $("#wrapper-table").hide();
      $("#print_voucher_area").show();
      trx_gl_id = $(this).attr('trx_gl_id');


      $.ajax({
        type: "POST",
        url: site_url+"laporan/get_data_cetak_voucher",
        dataType: "json",
        data: {
          trx_gl_id: trx_gl_id
        },
        async: false,
        success: function(response)
        {
          trx_gl = response.trx_gl;
          trx_gl_detail = response.trx_gl_detail;
          
          $(".print_nomor_voucher","#print_voucher_area").text((trx_gl.voucher_no==null)?"-":trx_gl.voucher_no);
          $(".print_tanggal_pembukuan","#print_voucher_area").text((trx_gl.trx_date==null)?"-":trx_gl.trx_date);
          $(".print_deskripsi","#print_voucher_area").text(trx_gl.description);
          // $(".pa_amount","#print_voucher_area").text(number_format(trx_gl.cash_amount,2,',','.'));
          // $(".pa_say_amount","#print_voucher_area").text(terbilang(parseFloat(trx_gl.cash_amount).toString())+' rupiah');
          
          tbody = '';
          total_debit = 0;
          total_credit = 0;
          x = 1;
          for ( i in trx_gl_detail )
          {
            total_debit += parseFloat(trx_gl_detail[i].debit);
            total_credit += parseFloat(trx_gl_detail[i].credit);
            tbody += '<tr> \
              <td style="font-size:12px; padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;border-left:solid 1px #AAA;" align="center">'+x+'</td> \
              <td style="font-size:12px; padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;">'+trx_gl_detail[i].account_code+'</td> \
              <td style="font-size:12px; padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;">'+trx_gl_detail[i].account_name+'</td> \
              <td style="font-size:12px; padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;" align="right">'+number_format(trx_gl_detail[i].debit,2,',','.')+'</td> \
              <td style="font-size:12px; padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;" align="right">'+number_format(trx_gl_detail[i].credit,2,',','.')+'</td> \
            </tr>';
            x++;
          }
          tbody += '<tr> \
            <td style="font-size:12px; font-weight:bold;padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;border-left:solid 1px #AAA;" align="right" colspan="3">Total</td> \
            <td style="font-size:12px; font-weight:bold;padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;" align="right">'+number_format(total_debit,2,',','.')+'</td> \
            <td style="font-size:12px; font-weight:bold;padding:5px;border-bottom:solid 1px #AAA;border-right:solid 1px #AAA;" align="right">'+number_format(total_credit,2,',','.')+'</td> \
          </tr>';
          $("table#pa_transaction > tbody").html(tbody);
        }
      })


    // }
  });

  // fungsi untuk check all
  jQuery('#voucher_table .group-checkable').live('change',function () {
      var set = jQuery(this).attr("data-set");
      var checked = jQuery(this).is(":checked");
      jQuery(set).each(function () {
          if (checked) {
              $(this).attr("checked", true);
          } else {
              $(this).attr("checked", false);
          }
      });
      jQuery.uniform.update(set);
  });

  $("#voucher_table .checkboxes").livequery(function(){
    $(this).uniform();
  });

  $("#search").click(function(){

    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var voucher_ref = $("#voucher_ref").val();
    var voucher_no = $("#voucher_no").val();
    var branch_code = $("#branch_code").val();
    var jurnal_trx_type = $("#jurnal_trx_type").val();

    // if(from_date=='' || to_date==''){
    //   alert('Tanggal Transaksi diperlukan');
    // }
    // else
    // {

      $("#close","#dialog_search").trigger('click')

      // begin first table
      $('#voucher_table').dataTable({
         "bDestroy":true,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": site_url+"laporan/datatable_cetak_voucher",
         "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "from_date",   "value": from_date } )
              aoData.push( { "name": "to_date",     "value": to_date } )
              aoData.push( { "name": "voucher_ref", "value": voucher_ref } )
              aoData.push( { "name": "voucher_no",  "value": voucher_no } )
              aoData.push( { "name": "branch_code",  "value": branch_code } )
              aoData.push( { "name": "jurnal_trx_type",  "value": jurnal_trx_type } )
          },
         "aoColumns": [
           null,
           null,
           null,
           null,
           null,
           null,
           null
         ],
         "aLengthMenu": [
             [5, 15, 20, 99999999999],
             [5, 15, 20, "All"] // change per page values here
         ],
         // set the initial value
         "iDisplayLength": 15,
         "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
         "sPaginationType": "bootstrap",
         "oLanguage": {
             "sLengthMenu": "_MENU_ records per page",
             "oPaginate": {
                 "sPrevious": "Prev",
                 "sNext": "Next"
             }
         },
         "sZeroRecords" : "Jurnal Tidak ditemukan",
         "aoColumnDefs": [{
                 'bSortable': false,
                 'aTargets': [0]
             }
         ]
      })
      // $(".dataTables_length,.dataTables_filter").parent().hide()
      $(".dataTables_length").parent().hide()

    // }

  })



  // begin first table
  $('#voucher_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"laporan/datatable_cetak_voucher",
      "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "from_date",   "value": '' } )
          aoData.push( { "name": "to_date",     "value": '' } )
          aoData.push( { "name": "voucher_ref", "value": '' } )
          aoData.push( { "name": "voucher_no",  "value": '' } )
          aoData.push( { "name": "branch_code",  "value": $("#branch_code").val() } )
          aoData.push( { "name": "jurnal_trx_type",  "value": $("#jurnal_trx_type").val() } )
      },
      "aoColumns": [
        null,
        null,
        null,
        null,
        null,
        null,
        null
      ],
      "aLengthMenu": [
          [5, 15, 20, 999999999999],
          [5, 15, 20, "All"] // change per page values here
      ],
      // set the initial value
      "iDisplayLength": 15,
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
          "sLengthMenu": "_MENU_ records per page",
          "oPaginate": {
              "sPrevious": "Prev",
              "sNext": "Next"
          }
      },
      "sZeroRecords" : "Data Pada Rembug ini Kosong",
      "aoColumnDefs": [{
              'bSortable': false,
              'aTargets': [0]
          }
      ]
  });
  // $(".dataTables_length,.dataTables_filter").parent().hide();
  $(".dataTables_length,").parent().hide();
  

  // jQuery('#voucher_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  // jQuery('#voucher_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  jQuery('#voucher_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  // jQuery('#voucher_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

})
</script>