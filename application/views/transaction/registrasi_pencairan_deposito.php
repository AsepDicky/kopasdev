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
      Registrasi <small>Pencairan Deposito</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Registrasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pencairan Deposito</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN TRX -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Pencairan Deposito</div>
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
               Registrasi Pencairan Deposito Sukses !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Rekening Deposito<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_deposit_no" id="account_deposit_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;" /><input type="hidden" id="branch_id" name="branch_id">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari No. Rekening</h3>
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                       </div>
                    </div>    
                    <h4 class="form-section">Customer</h4>   
                    <div class="control-group">
                       <label class="control-label">No. Customer </label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap </label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung </label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir </label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    </br>         
                    <div class="control-group">
                       <label class="control-label">Produk </label>
                       <div class="controls">
                          <input type="text" name="produk" id="produk" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu</label>
                       <div class="controls">
                            <input name="jangka_waktu" id="jangka_waktu" type="text" class="m-wrap" maxlength="4" readonly="" style="background-color:#eee;width:50px" /> bulan
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Nominal</label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="m-wrap mask-money" readonly="" name="nominal" id="nominal" style="background-color:#eee;width:120px;">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo</label>
                       <div class="controls">
                            <input name="jatuh_tempo" id="jatuh_tempo" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px;" /> &nbsp; ARO &nbsp; <input type="checkbox" name="aro" id="aro" readonly="" style="background-color:#eee;">
                        </div>
                    </div>  
                    <h4 class="form-section">Rekening Pencarian</h4> 
                    <div class="control-group">
                       <label class="control-label">Nomor Rekening<span class="required">*</span></label>
                       <div class="controls">
                            <input name="account_saving_no" id="account_saving_no" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px" />
                       
                            <div id="dialog_rembug2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari No. Rekening</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword2" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="result2" id="result2" size="7" class="span12 m-wrap"></select></p>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close2" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select2" class="btn blue">Select</button>
                             </div>
                          </div>
                          <a id="browse_rembug2" class="btn blue" data-toggle="modal" href="#dialog_rembug2">...</a>
                       </div>
                    </div> <div class="control-group">
                       <label class="control-label">Atas Nama</label>
                       <div class="controls">
                            <input name="atas_nama" id="atas_nama" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px;" />
                        </div>
                    </div>
                    <input type="hidden" id="branch_id" name="branch_id">
                    <div class="form-actions">
                       <button type="submit" class="btn green">Save</button>
                       <button type="reset" class="btn red" id="cancel">Reset</button>
                    </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END TRX -->



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
     
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });
        

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"transaction/search_cif_by_account_deposit",
              data: {keyword:$(this).val(),cif_type:type},
              async: false,
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].status_rekening+''+response[i].account_deposit_no+'">'+response[i].account_deposit_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
      });


        $("#select","#dialog_rembug").click(function()
        {
          var status = $("#result").val();
          var status_rekening = status.substring(0,1);          
          var account_deposit_no = status.substring(1,20);
            if(status_rekening!='1')
            {
               alert('Rekening Tidak Bisa Dicairkan');
               $("#dialog").dialog('open');
            }
            else
            {
              $("#close","#dialog_rembug").trigger('click');
              $.ajax({
                type:"POST",
                url: site_url+"transaction/search_cif_by_account_deposit_no",
                data:{account_deposit_no:account_deposit_no},
                dataType:"json",
                success: function(response)
                {
                    $("#account_deposit_no").val(response.account_deposit_no);
                    $("#cif_no").val(response.cif_no);
                    $("#nama").val(response.nama);
                    $("#ibu_kandung").val(response.ibu_kandung);
                    $("#tgl_lahir").val(response.tgl_lahir);
                    $("#produk").val(response.productx_name);
                    $("#jangka_waktu").val(response.jangka_waktu);
                    $("#nominal").val(number_format(response.nominal),0,',','.'); 
                    $("#jatuh_tempo").val(response.tanggal_jtempo_last); 
                    var aro = response.automatic_roll_over;
                      if(aro=='1'){
                        $("#aro").attr('checked',true);
                        $("#aro").closest('span').addClass('checked');
                      }
                      else
                      {
                        $("#aro").attr('checked',false);;
                        $("#aro").closest('span').removeClass('checked');
                      }
                    $("#account_saving_no").val(response.account_saving_no); 
                    
                    var account_saving_no = $("#account_saving_no").val();
                      if(account_saving_no!="")
                      {
                        $.ajax({
                          type:"POST",
                          url: site_url+"transaction/search_name_by_account_saving_no",
                          data:{account_saving_no:account_saving_no},
                          dataType:"json",
                          success: function(response)
                          {
                            $("#atas_nama").val(response.atasnama); 
                          }
                        });
                      }
                }
              });
              
            }
        });

$("#result option","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
  });

      //dialog account_saving
      $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });
        

        $("#keyword2").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"transaction/search_cif_by_account_saving",
              data: {keyword:$(this).val(),cif_type:type},
              async: false,
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            });
            return false;
          }
        });

        $("#select2","#dialog_rembug2").click(function()
        {
          var account_saving_no = $("#result2").val();
          
              $("#close2","#dialog_rembug2").trigger('click');
              $.ajax({
                type:"POST",
                url: site_url+"transaction/search_name_by_account_saving_no",
                data:{account_saving_no:account_saving_no},
                dataType:"json",
                success: function(response)
                {
                    $("#account_saving_no").val(response.account_saving_no); 
                    $("#atas_nama").val(response.atasnama); 
                }
              });
             
        });

        $("#result2 option","#dialog_rembug2").live('dblclick',function(){
          $("#select2","#dialog_rembug2").trigger('click');
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
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              account_saving_no: {
                  required: true
              },
              account_deposit_no: {
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

            $.ajax({
              type: "POST",
              url: site_url+"transaction/reg_pencairan_deposito",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  //$("#cancel").trigger('click');
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                }else{
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(error2, -200);
              },
              error:function(){
                  success1.hide();
                  error1.show();
              }
            });

          }
      });

      
      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->