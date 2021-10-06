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
      CETAK VALIDASI <small>cetak ulang validasi transaksi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="#">Transaksi</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Tabungan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">CETAK VALIDASI</a></li>  
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>CETAK VALIDASI TRANSAKSI</div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-left">
         <input type="text" class="m-wrap normal" id="account_saving_no" placeholder="No Rekening" style="width:200px">
          <input type="text" class="m-wrap small mask_date date-picker" placeholder="From Date" id="from_date">
          <input type="text" class="m-wrap small mask_date date-picker" placeholder="To Date" id="to_date">
            <button id="btn_search" class="btn purple" style="margin-right:10px;">
              Search <i class="icon-search"></i>
            </button>
         </div>
      </div>
      
      <table class="table table-striped table-bordered table-hover" id="voucher_table">
         <thead>
            <tr>
               <th width="9%">Cetak</th>
               <th width="9%">Tanggal</th>
               <th width="12%">No Rekening</th>
               <th width="15%">No Referensi</th>
               <th width="20%">Description</th>
               <th width="9%">Flag D/C</th>
               <th width="15%">Jumlah</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- print validasi area -->
<div id="print_validasi_setoran" style="font-size:10px;display:none">

  <div style="padding:10px;">

    <table style="width:70%" id="pa_transaction" align="center">
      <thead>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="60%" align="left"><span id="span_validasi_row1"></span></th>
          <th style="">&nbsp;</th>
        </tr>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="60%" align="left"><span id="span_validasi_row2"></span></th>
          <th style="">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
    <br>
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

  $("a#btn-cetakvoucher").live('click',function(){    
      trx_account_saving_id = $(this).attr('trx_account_saving_id');

      $.ajax({
        type: "POST",
        url: site_url+"transaction/get_data_cetak_ulang_validasi",
        dataType: "json",
        data: {
          trx_account_saving_id: trx_account_saving_id
        },
        async: false,
        success: function(response)
        {
          $("#span_validasi_row1").html(response.account_saving+', '+response.nama);
          $("#span_validasi_row2").html(response.amount+', '+response.teller+', '+response.date_time);
        }
      })    
    $("#print_validasi_setoran").show();
    $("#print_validasi_setoran").printElement();
    $("#print_validasi_setoran").hide();
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

  $("#btn_search").click(function(){

    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var account_saving_no = $("#account_saving_no").val();

      // begin first table
      $('#voucher_table').dataTable({
         "bDestroy":true,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": site_url+"transaction/datatable_cetak_ulang_validasi",
         "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "from_date",   "value": from_date } )
              aoData.push( { "name": "to_date",     "value": to_date } )
              aoData.push( { "name": "account_saving_no",  "value": account_saving_no } )
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
             [5, 15, 20, -1],
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
      $(".dataTables_length,.dataTables_filter").parent().hide()

  })



  // begin first table
  $('#voucher_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_cetak_ulang_validasi",
      "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "from_date",   "value": '' } )
          aoData.push( { "name": "to_date",     "value": '' } )
          aoData.push( { "name": "account_saving_no", "value": '' } )
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
          [5, 15, 20, -1],
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
  $(".dataTables_length,.dataTables_filter").parent().hide();
  

  jQuery('#voucher_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#voucher_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

})
</script>