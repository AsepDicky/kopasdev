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
      Verifikasi Transaksi <small>Kas Petugas</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Transaksi Kas Petugas</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div style="margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:8px;">
        TANGGAL TRANSAKSI : &nbsp;<input type="text" class="m-wrap date" id="from_date" placeholder="DD/MM/YYYY"> s.d&nbsp; <input type="text" class="m-wrap date" id="thru_date" placeholder="DD/MM/YYYY"> <button id="btn_filter" class="btn green">Filter</button>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#transaksi_kas_petugas .checkboxes" /></th>
               <th style="text-align:center" width="16.5%">Tanggal Transaksi</th>
               <th style="text-align:center" width="16.5%">Akun Kas</th>
               <th style="text-align:center" width="16.5%">Akun Teller</th>
               <th style="text-align:center" width="16.5%">Jenis Transaksi</th>
               <th style="text-align:center" width="13.5%">Nominal</th>
               <th style="text-align:center" width="19.5%">Keterangan</th>
               <th style="text-align:center">Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN verifikasi USER -->
<div id="verifikasi" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Transaksi Kas Petugas</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_verifikasi" class="form-horizontal">
          <input type="hidden" id="trx_gl_cash_id" name="trx_gl_cash_id">
          <input type="hidden" id="kas_petugas2_hidden" name="kas_petugas2_hidden">
          <input type="hidden" id="kas_teller2_hidden" name="kas_teller2_hidden">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Approve Transaksi Kas Petugas Sukses !
            </div>
            <div class="alert alert-success2 hide">
               <button class="close" data-dismiss="alert"></button>
               Reject Transaksi Kas Petugas Sukses !
            </div>
          </br>
            <div class="control-group">
                       <label class="control-label">Tanggal<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="trx_date2" id="trx_date2" data-required="1" class="date-picker medium m-wrap" style="background:#EEE" readonly/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Kas Petugas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_petugas2" id="kas_petugas2" class="medium m-wrap" data-required="1" disabled>                  
                            <option value="">PILIH</option>
                            <?php foreach ($kas_petugas as $data):?>
                            <option value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?> 
                         </select>
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_transaksi2" id="jenis_transaksi2" class="medium m-wrap" data-required="1" disabled>                     
                            <option value="">PILIH</option>
                              <option value="1">Droping Kas</option>
                              <option value="4">Setor Ke Teller</option>
                          </select>
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Kas Teller / Bank<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_teller2" id="kas_teller2" class="medium m-wrap" data-required="1" disabled>                   
                            <option value="">PILIH</option>
                            <?php foreach ($kas_teller as $data):?>
                            <option value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?>  
                         </select>
                       </div>
                    </div>     
                    <div class="control-group">
                      <label class="control-label">Nominal<span class="required">*</span></label>
                         <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money" id="jumlah_setoran2" name="jumlah_setoran2" style="background:#EEE" readonly>
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>       
                    <div class="control-group">
                       <label class="control-label">No. Referensi</label>
                       <div class="controls">
                          <input type="text" name="no_referensi2" id="no_referensi2" data-required="1" class="medium m-wrap" style="background:#EEE" readonly/>
                          <!-- <div id="error_no_referensi2"></div> -->
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan</label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium" style="background:#EEE" readonly></textarea>
                       </div>
                    </div>
            <div class="form-actions">
               <button type="submit" id="approve" class="btn green">Approve</button>
               <button type="button" id="reject" class="btn red">Reject</button>
               <button type="button" id="cancel" class="btn blue">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END VERIFIKASI USER -->



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<!-- END PAGE LEVEL SCRIPTS -->  


<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
      Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
      $(".date").inputmask("d/m/y");  //direct mask        
      $("#trx_date").inputmask("d/m/y");  //direct mask        
      $("#trx_date2").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'transaksi_kas_petugas';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#transaksi_kas_petugas .group-checkable').live('change',function () {
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

      $("#transaksi_kas_petugas .checkboxes").livequery(function(){
        $(this).uniform();
      });

      $("#btn_filter").click(function(){
        $('#transaksi_kas_petugas').dataTable({
               "bDestroy":true,
               "bProcessing": true,
               "bServerSide": true,
               "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "from_date", "value": $("#from_date").val() } );
                    aoData.push( { "name": "thru_date", "value": $("#thru_date").val() } );
                },
               "sAjaxSource": site_url+"transaction/datatable_verifikasi_transaksi_kas_petugas",
                "aoColumns": [
                  {"bSearchable": false},
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  { "bSortable": false, "bSearchable": false }
                ],
                "aLengthMenu": [
                    [15, 30, 45, -1],
                    [15, 30, 45, "All"] // change per page values here
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
               "umnDefs": [{
                       'bSortable': false,
                       'aTargets': [0]
                   }
               ]
            });
      })

      // begin first table
      $('#transaksi_kas_petugas').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_verifikasi_transaksi_kas_petugas",
          "aoColumns": [
            {"bSearchable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
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
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0]
              }
          ]
      });

      // event button Edit ketika di tekan
      $("a#link-verifikasi").live('click',function(){
        $("#wrapper-table").hide();
        $("#verifikasi").show();
        var trx_gl_cash_id = $(this).attr('trx_gl_cash_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {trx_gl_cash_id:trx_gl_cash_id},
          url: site_url+"transaction/get_trx_by_trx_gl_cash_id",
          success: function(response)
          {
            $("#form_verifikasi input[name='trx_gl_cash_id']").val(response.trx_gl_cash_id);
            tgl_trx_date = response.trx_date.substring(8,12)+'/'+response.trx_date.substring(5,7)+'/'+response.trx_date.substring(0,4);
            $("#form_verifikasi input[name='trx_date2']").val(tgl_trx_date);
            $("#form_verifikasi select[name='kas_petugas2']").val(response.account_cash_code);
            $("#form_verifikasi input[name='kas_petugas2_hidden']").val(response.account_cash_code);
            $("#form_verifikasi select[name='jenis_transaksi2']").val(response.trx_gl_cash_type);
            $("#form_verifikasi select[name='kas_teller2']").val(response.account_teller_code);
            $("#form_verifikasi input[name='kas_teller2_hidden']").val(response.account_teller_code);
            $("#form_verifikasi input[name='jumlah_setoran2']").val(number_format(response.amount,0,',','.'));
            $("#form_verifikasi input[name='no_referensi2']").val(response.voucher_ref);
            $("#form_verifikasi textarea[name='keterangan2']").val(response.description);
                  
          }
        })

      });

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_verifikasi');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);
      var success3 = $('.alert-success2', form2);

      $("#approve").click(function(e){
        e.preventDefault();
        // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
        $.ajax({
          type: "POST",
          url: site_url+"transaction/verifikasi_approve_kas_petugas",
          dataType: "json",
          data: form2.serialize(),
          success: function(response){
            if(response.success==true){
              alert("Approve Transaksi Kas Petugas Sukses!")
              $("#cancel","#form_verifikasi").trigger('click')
            }else{
              alert("Approve Transaksi Kas Petugas Error!")
            }
            App.scrollTo(0,-200);
          },
          error:function(){
            alert("Failed to Connect into Databases, Please Contact Your Administartor!")
            App.scrollTo(0,-200);
          }
        });
      });

      $("#reject").click(function(e){
        e.preventDefault();
        // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
        $.ajax({
          type: "POST",
          url: site_url+"transaction/verifikasi_reject_kas_petugas",
          dataType: "json",
          data: form2.serialize(),
          success: function(response){
            if(response.success==true){
              alert("Reject Transaksi Kas Petugas Sukses!")
              $("#cancel","#form_verifikasi").trigger('click')
            }else{
              alert("Reject Transaksi Kas Petugas Error!")
            }
          },
          error:function(){
            alert("Failed to Connect into Databases, Please Contact Your Administartor!")
            App.scrollTo(0,-200);
          }
        });
      });



      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_verifikasi").click(function(){
        $("#verifikasi").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });
      
      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS