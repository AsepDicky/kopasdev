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
      Transaction <small>Kas Petugas</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Transaksi Kas Petugas</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#transaksi_kas_petugas .checkboxes" /></th>
               <th width="16.5%">Tanggal Transaksi</th>
               <th width="16.5%">Akun Kas</th>
               <th width="16.5%">Akun Teller</th>
               <th width="16.5%">Flag Debet Kredit</th>
               <th width="16.5%">Nominal</th>
               <th width="16.5%">Keterangan</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN TRX -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Transaksi Kas Petugas</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Transaksi Kas Petugas Sukses !
            </div>
            </br>                         
                    <div class="control-group">
                       <label class="control-label">Tanggal<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="trx_date" id="trx_date" data-required="1" value="<?php echo $current_date; ?>" class="date-picker medium m-wrap"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Kas Petugas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_petugas" id="kas_petugas" class="large m-wrap" data-required="1">                  
                            <option value="">PILIH</option>
                            <?php foreach ($kas_petugas as $data):?>
                            <option gl_account_code="<?php echo $data['gl_account_code'] ?>" value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?> 
                         </select>
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_transaksi" id="jenis_transaksi" class="large m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="1">Modal Awal Petugas</option>
                              <option value="4">Setor Ke Teller</option>
                          </select>
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Kas Teller / Bank<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_teller" id="kas_teller" class="large m-wrap" data-required="1">                   
                            <option value="">PILIH</option>
                            <?php foreach ($kas_teller as $data):?>
                            <option gl_account_code="<?php echo $data['gl_account_code'] ?>" value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?>  
                         </select>
                       </div>
                    </div>     
                    <div class="control-group">
                      <label class="control-label">Nominal<span class="required">*</span></label>
                         <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money" id="jumlah_setoran" name="jumlah_setoran">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>          
                    <div class="control-group">
                       <label class="control-label">No. Referensi</label>
                       <div class="controls">
                          <input type="text" name="no_referensi" id="no_referensi" data-required="1" class="medium m-wrap"/>
                          <!-- <div id="error_no_referensi"></div> -->
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan</label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
                       </div>
                    </div>
                    <input type="hidden" id="branch_id" name="branch_id">
                    <div class="form-actions">
                       <button type="submit" class="btn green">Save</button>
                       <button type="reset" class="btn" id="cancel">Back</button>
                    </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END TRX -->


<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Transaksi Kas Petugas</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="trx_gl_cash_id" name="trx_gl_cash_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Transaksi Kas Petugas Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
                       <label class="control-label">Tanggal<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="trx_date2" id="trx_date2" data-required="1" value="<?php echo $current_date; ?>" class="date-picker medium m-wrap"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Kas Petugas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_petugas2" id="kas_petugas2" class="m-wrap" data-required="1">                  
                            <option value="">PILIH</option>
                            <?php foreach ($kas_petugas as $data):?>
                            <option gl_account_code="<?php echo $data['gl_account_code'] ?>" value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?> 
                         </select>
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_transaksi2" id="jenis_transaksi2" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="1">Droping Kas</option>
                              <option value="4">Setor Ke Teller</option>
                          </select>
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Kas Teller / Bank<span class="required">*</span></label>
                       <div class="controls">
                         <select name="kas_teller2" id="kas_teller2" class="m-wrap" data-required="1">                   
                            <option value="">PILIH</option>
                            <?php foreach ($kas_teller as $data):?>
                            <option gl_account_code="<?php echo $data['gl_account_code'] ?>" value="<?php echo $data['account_cash_code'];?>" account_cash_name="<?php echo $data['account_cash_name'];?>"><?php echo $data['account_cash_name'];?></option>  
                            <?php endforeach; ?>  
                         </select>
                       </div>
                    </div>     
                    <div class="control-group">
                      <label class="control-label">Nominal<span class="required">*</span></label>
                         <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money" id="jumlah_setoran2" name="jumlah_setoran2">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Referensi</label>
                       <div class="controls">
                          <input type="text" name="no_referensi2" id="no_referensi2" data-required="1" class="medium m-wrap"/>
                          <!-- <div id="error_no_referensi2"></div> -->
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan</label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium"></textarea>
                       </div>
                    </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Update</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->



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
      
      // begin first table
      $('#transaksi_kas_petugas').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_transaksi_kas_petugas",
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


      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      $("#btn_add").click(function()
      {
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          onkeyup: false,
          onblur: false,          
          onchange: true,          
          rules: {
              
              trx_date: {
                  required: true,
                  cek_trx_kontrol_periode : true
              },
              kas_petugas: {
                  required: true
              },
              jenis_transaksi: {
                  required: true
              },
              kas_teller: {
                  required: true
              },
              jumlah_setoran: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          
          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {
              // var gl_account_code_kas_petugas = $("#kas_petugas option:selected").attr('gl_account_code');
              // var gl_account_code_kas_teller = $("#kas_teller option:selected").attr('gl_account_code');
              // if(gl_account_code_kas_teller==gl_account_code_kas_petugas){
                // alert("Error! GL Account tidak boleh Sama!");
              // }else{

              $.ajax({
                type: "POST",
                url: site_url+"transaction/add_kas_petugas",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                  if(response.success==true){
                    success1.show();
                    error1.hide();
                    form1.trigger('reset');
                    form1.find('.control-group').removeClass('success');
                  }else{
                    success1.hide();
                    error1.show();
                  }
                  App.scrollTo(form1, -200);
                },
                error:function(){
                    success1.hide();
                    error1.show();
                    App.scrollTo(form1, -200);
                }
              });
            // }
          }
      });

    
      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });


      // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var trx_gl_cash_id = $(this).attr('trx_gl_cash_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {trx_gl_cash_id:trx_gl_cash_id},
          url: site_url+"transaction/get_trx_by_trx_gl_cash_id",
          success: function(response)
          {
            $("#form_edit input[name='trx_gl_cash_id']").val(response.trx_gl_cash_id);
            tgl_trx_date = response.trx_date.substring(8,12)+''+response.trx_date.substring(5,7)+''+response.trx_date.substring(0,4);
            $("#form_edit input[name='trx_date2']").val(tgl_trx_date);
            $("#form_edit select[name='kas_petugas2']").val(response.account_cash_code);
            $("#form_edit select[name='jenis_transaksi2']").val(response.trx_gl_cash_type);
            $("#form_edit select[name='kas_teller2']").val(response.account_teller_code);
            $("#form_edit input[name='jumlah_setoran2']").val(response.amount);
            $("#form_edit input[name='no_referensi2']").val(response.voucher_ref);
            $("#form_edit textarea[name='keterangan2']").val(response.description);
                  
          }
        })

      });



      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              trx_date2: {
                  required: true
              },
              kas_petugas2: {
                  required: true
              },
              jenis_transaksi2: {
                  required: true
              },
              kas_teller2: {
                  required: true
              },
              jumlah_setoran2: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          
          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            // var gl_account_code_kas_petugas = $("#kas_petugas2 option:selected").attr('gl_account_code');
              // var gl_account_code_kas_teller = $("#kas_teller2 option:selected").attr('gl_account_code');
              // if(gl_account_code_kas_teller==gl_account_code_kas_petugas){
                // alert("Error! GL Account tidak boleh Sama!");
              // }else{

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"transaction/edit_kas_petugas",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  dTreload();
                }else{
                  success2.hide();
                  error2.show();
                }
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });
          // }
          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var trx_gl_cash_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          trx_gl_cash_id[$i] = $(this).val();

          $i++;

        });

        if(trx_gl_cash_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_kas_petugas",
              dataType: "json",
              data: {trx_gl_cash_id:trx_gl_cash_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });
      
      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS