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
      Transaction <small>Registrasi Rekening Tabungan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Rekening Tabungan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekening Tabungan</div>
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
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
      </div>
      <table class="table table-striped table-bordered table-hover" id="rekening_tabungan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_tabungan_table .checkboxes" /></th>
               <th width="16%">No. Customer</th>
               <th width="27%">Nama Lengkap</th>
               <th width="26%">Nama Produk</th>
               <th width="20%">Nomor Rekening</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Rekening Tabungan</div>
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
               New Account Savings has been Created !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code" name="branch_code">
                          <input type="hidden" id="account_type" name="account_type">
                          <input type="hidden" id="jenis_tabungan" name="jenis_tabungan">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <?php
                                      if($this->session->userdata('cif_type')==0){
                                      ?>
                                        <input type="hidden" id="cif_type" name="cif_type" value="0">
                                        <p id="pcm" style="height:32px">
                                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                        <option value="">Pilih Rembug</option>
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
                                      <?php
                                      }else if($this->session->userdata('cif_type')==1){
                                        echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                                      }else{
                                      ?>
                                        <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                        <option value="">Pilih Tipe CIF</option>
                                        <option value="">All</option>
                                        <option value="1">Individu</option>
                                        <option value="0">Kelompok</option>
                                        </select></p>
                                        <p class="hide" id="pcm" style="height:32px">
                                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                        <option value="">Pilih Rembug</option>
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
                                      <?php
                                      }
                                      ?>
                                      
                                      
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
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir</label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                         <select name="product" id="product" class="m-wrap" data-required="1">  
                            <option value="">PILIH</option>
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_saving_no" id="account_saving_no" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pembukaan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pembukaan" style="width:120px;" id="tanggal_pembukaan" data-required="1" class="date-picker small m-wrap" value="<?php echo $current_date?>" />
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Gabung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_gabung_cif" style="width:120px;" id="tanggal_gabung_cif" readonly="" data-required="1" class="small m-wrap"/>
                       </div>
                    </div> 
                    <hr>  
                  <div id="tabungan_berencana">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran" style="width:120px;" id="rencana_setoran" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Periode Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="rencana_periode_setoran" name="rencana_periode_setoran" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="0">Bulanan</option>
                              <option value="1">Mingguan</option>
                              <option value="2">Harian</option>
                          </select>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu" style="width:120px;" id="rencana_jangka_waktu" data-required="1" class="m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next" style="width:120px;" id="rencana_setoran_next" data-required="1" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                  </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_saving_id" name="account_saving_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Account Savings Successful!
            </div>
          </br>      
          <!-- <input type="hidden" id="old_product2" name="old_product2"> -->
                    <div class="control-group">
                       <label class="control-label">No Customer</label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code2" name="branch_code2">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir2" id="tmp_lahir2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir</label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir2" id="tgl_lahir2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>               
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       
                       <div class="controls">
                          <input type="hidden" name="product2_old" id="product2_old"/>
                          <input type="hidden" id="product2_code_old" name="product2_code_old">
                       </div>
                       <div class="controls">
                          <select id="product2" name="product2" class="medium m-wrap" data-required="1">       
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_saving_no2" id="account_saving_no2" readonly="" class="medium m-wrap" style="background-color:#eee;"/>
                          <!-- <input type="hidden" id="account_saving_no2_old" name="account_saving_no2_old"> -->
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pembukaan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pembukaan2" style="width:120px;" id="tanggal_pembukaan2" data-required="1" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Gabung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_gabung_cif" style="width:120px;" id="tanggal_gabung_cif" readonly="" data-required="1" class="small m-wrap"/>
                       </div>
                    </div> 
                    <hr> 
                  <div id="tabungan_berencana2">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran2" style="width:120px;" id="rencana_setoran2" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Periode Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="rencana_periode_setoran2" name="rencana_periode_setoran2" style="width:120px;" class="m-wrap" data-required="1" >                     
                            <option value="">PILIH</option>
                              <option value="0">Bulanan</option>
                              <option value="1">Mingguan</option>
                              <option value="2">Harian</option>
                          </select>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu2" id="rencana_jangka_waktu2" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next2" id="rencana_setoran_next2" data-required="1" class="date-picker medium m-wrap"/>
                       </div>
                    </div> 
                  </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->

<p>&nbsp;</p>
  

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
    
      $("#tgl_lahir").inputmask("y/m/d", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_pembukaan").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_pembukaan2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'rekening_tabungan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  

      // fungsi untuk check all
      jQuery('#rekening_tabungan_table .group-checkable').live('change',function () {
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

      $("#rekening_tabungan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      
      $("#btn_add").click(function(){
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
              cif_no: {
                  required: true
              },
              product: {
                  required: true
              },
              rencana_setoran: {
                  required: true
              },
              rencana_periode_setoran: {
                  required: true
              },
              rencana_jangka_waktu: {
                  required: true
              },
              rencana_setoran_next: {
                  required: true
              },
              tanggal_pembukaan: {
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
            
            var tanggal_gabung_cif = $("#tanggal_gabung_cif","#form_add").val().replace(/\//g,'');
            var tanggal_pembukaan = $("#tanggal_pembukaan","#form_add").val().replace(/\//g,'');
            // tanggal_gabung_cif = tanggal_gabung_cif.split('/');
            day_gabung_cif = tanggal_gabung_cif[0];
            month_gabung_cif = tanggal_gabung_cif[1];
            year_gabung_cif = tanggal_gabung_cif[2];
            tanggal_gabung_cif = new Date(year_gabung_cif,month_gabung_cif-1,day_gabung_cif);
            // tanggal_pembukaan = tanggal_pembukaan.split('/');
            day_buka = tanggal_pembukaan[0];
            month_buka = tanggal_pembukaan[1];
            year_buka = tanggal_pembukaan[2];
            tanggal_pembukaan = new Date(year_buka,month_buka-1,day_buka);
            // alert(tanggal_gabung_cif);
            // alert(tanggal_pembukaan);
            if(tanggal_pembukaan<tanggal_gabung_cif){
              alert("Tanggal pembukaan tidak boleh kurang dari tanggal gabung");
              $("#tanggal_pembukaan","#form_add").css("background-color","yellow");
            }else{
              $.ajax({
                type: "POST",
                url: site_url+"transaction/add_rekening_tabungan",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                  if(response.success==true){
                    success1.show();
                    error1.hide();
                    form1.trigger('reset');
                    form1.children('div').removeClass('success');
                    $("#cancel",form_add).trigger('click')
                    alert('Successfully Saved Data');
                  }else{
                    success1.hide();
                    error1.show();
                  }
                  App.scrollTo(error2, -200);
                },
                error:function(){
                    success1.hide();
                    error1.show();
                    App.scrollTo(error2, -200);
                }
              });
            }
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
        var account_saving_id = $(this).attr('account_saving_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_saving_id:account_saving_id},
          url: site_url+"transaction/get_account_saving_by_account_saving_id",
          success: function(response)
          {

                 $.ajax({
                   type: "POST",
                   url: site_url+"transaction/ajax_get_tabungan_by_cif_type",
                   dataType: "json",
                   async: false,
                   data: {cif_type:response.cif_type},
                   success: function(response2){
                      html = '';
                      for ( i = 0 ; i < response2.length ; i++ )
                      {
                         html += '<option value="'+response2[i].jenis_tabungan+''+response2[i].product_code+'">'+response2[i].product_name+'</option>';
                      }
                      $("#product2").html(html);
                   }
                });  
                 
            $("#form_edit input[name='account_saving_id']").val(response.account_saving_id);
            $("#form_edit input[name='branch_code2']").val(response.branch_code);
      			$("#form_edit input[name='cif_no2']").val(response.cif_no);
      			$("#form_edit input[name='nama2']").val(response.nama);
      			$("#form_edit input[name='panggilan2']").val(response.panggilan);
      			$("#form_edit input[name='ibu_kandung2']").val(response.ibu_kandung);
      			$("#form_edit input[name='tmp_lahir2']").val(response.tmp_lahir);
      			$("#form_edit input[name='tgl_lahir2']").val(response.tgl_lahir);
      			$("#form_edit textarea[name='alamat2']").val(response.alamat);
      			$("#form_edit input[name='rt_rw2']").val(response.rt_rw);
      			$("#form_edit input[name='desa2']").val(response.desa);
      			$("#form_edit input[name='kecamatan2']").val(response.kecamatan);
      			$("#form_edit input[name='kabupaten2']").val(response.kabupaten);
      			$("#form_edit input[name='kodepos2']").val(response.kodepos);
      			$("#form_edit input[name='telpon_rumah2']").val(response.telpon_rumah);
      			$("#form_edit input[name='telpon_seluler2']").val(response.telpon_seluler);
            $("#form_edit input[name='account_saving_no2']").val(response.account_saving_no);
            $("#form_edit input[name='account_saving_no2_old']").val(response.account_saving_no);
            $("#form_edit input[name='product2_old']").val(response.product_name);
      			$("#form_edit input[name='product2_code_old']").val(response.product_code);
            tanggal_gabung_cif = response.tgl_gabung;
            tanggal_gabung_cif = tanggal_gabung_cif.split('-');
            var tanggal_gabung_cif =  tanggal_gabung_cif[2]+'/'+tanggal_gabung_cif[1]+'/'+tanggal_gabung_cif[0];
            $("#form_edit input[name='tanggal_gabung_cif']").val(tanggal_gabung_cif);
      			
      			var jenis_and_code_product = response.jenis_tabungan+''+response.product_code;
      			$("#form_edit select[name='product2']").val(jenis_and_code_product);
			
    			  //fungsi untuk menampilkan input TABUNGAN BERENCANA JIKA jenis_tabungan == "1" 
    			 	var product = jenis_and_code_product;
    				jenis_tabungan = product.substring(0,1);     
    				if(jenis_tabungan=='1')
    				{
    				  $("#tabungan_berencana2").show();
    				}
    				else
    				{
    				  $("#tabungan_berencana2").hide();
    				}
    				//fungsi untuk menampilkan input TABUNGAN BERENCANA JIKA jenis_tabungan == "1" (KETIKA DIGANTI/CHANGE)
    				$("#product2").change(function(){
    					var product = $("#product2").val();
    					jenis_tabungan = product.substring(0,1);     
    					if(jenis_tabungan=='1')
    					{
    					  $("#tabungan_berencana2").show();
    					}
    					else
    					{
    					  $("#tabungan_berencana2").hide();
    					}
    					
    				});  	
			
			      $("#form_edit input[name='rencana_setoran2']").val(response.rencana_setoran);
			      $("#form_edit select[name='rencana_periode_setoran2']").val(response.rencana_periode_setoran);
            $("#form_edit input[name='rencana_jangka_waktu2']").val(response.rencana_jangka_waktu);
            tgl_rencana_setoran_next = '';
            if(response.rencana_setoran_next!=null){
              tgl_rencana_setoran_next = response.rencana_setoran_next.substring(8,12)+''+response.rencana_setoran_next.substring(5,7)+''+response.rencana_setoran_next.substring(0,4);
            }
            $("#form_edit input[name='rencana_setoran_next2']").val(tgl_rencana_setoran_next);
            tgl_buka = '';
            if(response.tanggal_buka!=null){
              tgl_buka = response.tanggal_buka.substring(8,12)+''+response.tanggal_buka.substring(5,7)+''+response.tanggal_buka.substring(0,4);
            }
            $("#form_edit input[name='tanggal_pembukaan2']").val(tgl_buka);
                     
          }
        })

      });
	  
	  // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

        $("#dialog2").dialog({
          width: 270,
          height: 320,
          autoOpen: false,
          buttons: {
            'OK': function(){
              $("#dialog2").dialog('close');
              var customer_no = $("#result2").val();
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
            }
          }
        });
		$("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });
	 });
	 
	 //fungsi untuk menggenerate NO REKENING PADA FORM EDIT
	  $(function(){
		
			$("#product2").change(function(){
        if($(this).val()==""){
          $("#account_saving_no2").val('');
        }else{
          var cif_no = $("#cif_no2").val();  
  				var product_code = $("#product2").val().substring(1,5);
  				//mendapatkan jumlah maksimal sesuai product_code yang dipilih
  				$.ajax({
            // url: site_url+"transaction/count_cif_by_product_code",
  				  url: site_url+"transaction/get_seq_account_saving_no",
  				  type: "POST",
  				  dataType: "json",
  				  data: {product_code:product_code,cif_no:cif_no},
  				  success: function(response)
  				  {
              no_urut=response.newseq;
  					  /*var data = response.jumlah;
  					  if(data==null)
  					  {
  						  var total = 0;
  					  }
  					  else
  					  {
  						  var total = data;
  					  }
  					  var jumlah = parseFloat(total); 
  					  var no_urut = jumlah+1;
              if(no_urut<10){
                no_urut = '0'+no_urut;
              }*/
  					  //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
  					  $("#account_saving_no2").val(cif_no+''+product_code+''+no_urut);
  				  }
  				})				 
        }
      });

		});



      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              rencana_setoran2: {
                  required: true
              },
              rencana_periode_setoran2: {
                  required: true
              },
              rencana_jangka_waktu2: {
                  required: true
              },
              rencana_setoran_next2: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
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

            var tanggal_gabung_cif = $("#tanggal_gabung_cif","#form_edit").val().replace(/\//g,'');
            var tanggal_pembukaan = $("#tanggal_pembukaan2","#form_edit").val().replace(/\//g,'');
            // tanggal_gabung_cif = tanggal_gabung_cif.split('/');
            day_gabung_cif = tanggal_gabung_cif[0];
            month_gabung_cif = tanggal_gabung_cif[1];
            year_gabung_cif = tanggal_gabung_cif[2];
            tanggal_gabung_cif = new Date(year_gabung_cif,month_gabung_cif-1,day_gabung_cif);
            // tanggal_pembukaan = tanggal_pembukaan.split('/');
            day_buka = tanggal_pembukaan[0];
            month_buka = tanggal_pembukaan[1];
            year_buka = tanggal_pembukaan[2];
            tanggal_pembukaan = new Date(year_buka,month_buka-1,day_buka);
            // alert(tanggal_gabung_cif);
            // alert(tanggal_pembukaan);
            if(tanggal_pembukaan<tanggal_gabung_cif){
              alert("Tanggal pembukaan tidak boleh kurang dari tanggal gabung");
              $("#tanggal_pembukaan2","#form_edit").css("background-color","yellow");
            }else{

              // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
              $.ajax({
                type: "POST",
                url: site_url+"transaction/edit_rekening_tabungan",
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    alert(response.message);
                    success2.show();
                    error2.hide();
                    form2.children('div').removeClass('success');
                    $("#rekening_tabungan_table_filter input").val('');
                    dTreload();
                    $("#cancel",form_edit).trigger('click')
                    alert('Successfully Updated Data');
                  }else{
                    alert(response.message);
                    success2.hide();
                    error2.show();
                  }
                  App.scrollTo(error2, -200);
                },
                error:function(){
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                }
              });
            }
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

        var account_saving_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_saving_id[$i] = $(this).val();

          $i++;

        });

        if(account_saving_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_rekening_tabungan",
              dataType: "json",
              data: {account_saving_id:account_saving_id},
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


      // begin first table
      $('#rekening_tabungan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_rekening_tabungan_setup",
          "aoColumns": [
			      null,
            null,
            null,
            null,
            null,
            null
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


      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
              var customer_no = $("#result").val();
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#cif_no").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no",
                      success: function(response)
                      {
                        $("#branch_code").val(response.branch_code);
                        $("#nama").val(response.nama);
                        $("#panggilan").val(response.panggilan);
                        $("#ibu_kandung").val(response.ibu_kandung);
                        $("#tmp_lahir").val(response.tmp_lahir);
                        $("#tgl_lahir").val(response.tgl_lahir);
                        $("#alamat").val(response.alamat);
                        $("#rt_rw").val(response.rt_rw);
                        $("#desa").val(response.desa);
                        $("#kecamatan").val(response.kecamatan);
                        $("#kabupaten").val(response.kabupaten);
                        $("#kodepos").val(response.kodepos);
                        $("#telpon_rumah").val(response.telpon_rumah);
                        $("#telpon_seluler").val(response.telpon_seluler);
                        $("#account_type").val(response.cif_type);
                        tanggal_gabung_cif = response.tgl_gabung;
                        tanggal_gabung_cif = tanggal_gabung_cif.split('-');
                        var tanggal_gabung_cif =  tanggal_gabung_cif[2]+'/'+tanggal_gabung_cif[1]+'/'+tanggal_gabung_cif[0];
                        $("#tanggal_gabung_cif").val(tanggal_gabung_cif);

                         $.ajax({
                           type: "POST",
                           url: site_url+"transaction/ajax_get_tabungan_by_cif_type",
                           dataType: "json",
                           data: {cif_type:response.cif_type},
                           success: function(response){
                              html = '<option value="">PILIH</option>';
                              for ( i = 0 ; i < response.length ; i++ )
                              {
                                 html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
                              }
                              $("#product").html(html);
                           }
                        });   

                        $("#account_saving_no").val("");

                      }                 
                    });
            
        });

        $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
        });

        // //BEGIN baru 1-10-2013 UNTUK MENENTUKAN JENIS TABUNGAN BERDASARKAN CIF_TIPE ATAU ACCOUNT_TIPE
        // $("account_type").change(function(){
        //     var account_type = $(this).val();
        //    $.ajax({
        //      type: "POST",
        //      url: site_url+"transaction/ajax_get_tabungan_by_cif_type",
        //      dataType: "json",
        //      data: {cif_type:account_type},
        //      success: function(response){
        //         html = '';
        //         for ( i = 0 ; i < response.length ; i++ )
        //         {
        //            html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
        //         }
        //         $("#product").html(html);
        //      }
        //   });        
        // });  

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });

        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      

      //fungsi untuk menampilkan input TABUNGAN BERENCANA JIKA jenis_tabungan == "1"
      $(function(){
  
          $("#tabungan_berencana").hide();
          
          $("#product").change(function(){
            var product = $("#product").val();
            jenis_tabungan = product.substring(0,1);     
            if(jenis_tabungan=='1')
            {
              $("#tabungan_berencana").show();
              $("#jenis_tabungan").val("1");
            }
            else
            {
              $("#tabungan_berencana").hide();
              $("#jenis_tabungan").val("");
            }
            
          });     
          
      });
	  
	  //fungsi untuk menggenerate NO REKENING
	  $(function(){
		
			$("#product").change(function(){
        if($(this).val()==""){
          $("#account_saving_no").val('');
        }else{
          var cif_no = $("#cif_no").val();  
  				var product_code = $(this).val().substring(1,5);
  				//mendapatkan jumlah maksimal sesuai product_code yang dipilih
  				$.ajax({
            url: site_url+"transaction/get_seq_account_saving_no",
  				  // url: site_url+"transaction/count_cif_by_product_code",
  				  type: "POST",
  				  dataType: "json",
  				  data: {product_code:product_code,cif_no:cif_no},
  				  success: function(response)
  				  {
              no_urut=response.newseq;
  					  /*var data = response.jumlah;
  					  if(data==null)
  					  {
  						  var total = 0;
  					  }
  					  else
  					  {
  						  var total = data;
  					  }
  					  var jumlah = parseFloat(total); 
  					  var no_urut = jumlah+1;
              if(no_urut<10){
                no_urut = '0'+no_urut;
              }*/
  					  //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
  					  $("#account_saving_no").val(cif_no+''+product_code+''+no_urut);
  				  }
  				});
        }
      });
		});
		  
      
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

