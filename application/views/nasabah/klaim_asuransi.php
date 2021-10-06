BEGIN PAGE HEADER-->
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
      Pengajuan <small>Klaim Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Klaim Asuransi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN TRX -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Klaim Asuransi</div>
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
               Pengajuan Klaim Asuransi Berhasil Diproses !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
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
                                      <!-- <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                      <option value="">Pilih Tipe CIF</option>
                                      <option value="">All</option>
                                      <option value="1">Individu</option>
                                      <option value="0">Kelompok</option>
                                      </select></p>   
                                      <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->
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
                       <label class="control-label">Nama <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tempat_lahir" id="tempat_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" readonly="" style="background-color:#eee;width:100px;"/>
                       </div>
                    </div> 
                    <hr>
                    <div class="control-group">
                       <label class="control-label">Produk <span class="required">*</span></label>
                       <div class="controls">
                          <input type="hidden" id="insurance_type" name="insurance_type">
                          <input type="text" name="produk" id="produk" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <hr>  
                  <div id="ins_tipe0">
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak" id="awal_kontrak" data-required="1" readonly="" style="background-color:#eee;width:100px"/> sd <input type="text" readonly="" style="background-color:#eee;width:100px;" name="akhir_kontrak" id="akhir_kontrak" data-required="1"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Manfaat Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;" maxlength="10" name="benefit_value" id="benefit_value" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" style="background-color:#eee;" name="premium_value" id="premium_value" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>  
                    <hr>  
                  </div>
                 <div id="ins_tipe1">    
                    <div class="control-group">
                       <label class="control-label">Plan<span class="required">*</span></label>
                       <div class="controls">
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;" name="plan" id="plan">
                       </div>
                    </div>                           
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value1" id="premium_value1" style="background-color:#eee;" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak1" id="awal_kontrak1" data-required="1" style="background-color:#eee;width:100px" readonly=""/> sd <input type="text" readonly=""  style="background-color:#eee;width:100px" name="akhir_kontrak1" id="akhir_kontrak1" data-required="1"/>
                       </div>
                    </div>  
                    <hr>
                  </div>
                    <div class="control-group">
                       <label class="control-label">Rekening Tabungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" style="background-color:#eee;" name="rekening_tabungan" id="rekening_tabungan" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Nama Pemegang Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" style="background-color:#eee;" name="nama_pemegang_rek" id="nama_pemegang_rek" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                    <hr>
                    <div class="control-group">
                       <label class="control-label">Jenis Klaim<span class="required">*</span></label>
                       <div class="controls">
                         <select id="jenis_klaim" name="jenis_klaim" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="0">Meninggal Dunia</option>
                              <option value="2">Nilai Tunai</option>
                              <option value="3">Rawat Jalan</option>
                              <option value="4">Rawat Inap</option>
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Klaim (Kejadian)<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_klaim" id="mask_date" data-required="1" value="<?php echo $current_date; ?>" class="date-picker medium m-wrap"/>
                       </div>
                    </div>    
                    <div class="form-actions">
                       <button type="submit" class="btn green">Save</button>
                       <button type="reset" class="btn red" id="cancel">Cancel</button>
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
     
      $("#mask_date").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


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
            url: site_url+"cif/search_account_insurance_no",
            data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
            dataType: "json",
            success: function(response){
              var option = '';
              if(type=="0"){
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+' - '+response[i].cm_name+'</option>';
                }
              }else if(type=="1"){
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+'</option>';
                }
              }else{
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].cm_name!=null){
                    cm_name = " - "+response[i].cm_name;   
                  }else{
                    cm_name = "";
                  }
                  option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+''+cm_name+'</option>';
                }
              }
              // console.log(option);
              $("#result").html(option);
            }
          });
        })

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
              url: site_url+"cif/search_account_insurance_no",
              async: false,
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+''+cm_name+'</option>';
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
              url: site_url+"cif/search_account_insurance_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_insurance_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_insurance_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });


        $("#select","#dialog_rembug").click(function()
        {
          var account_insurance_no = $("#result").val();
          /*var account_insurance_no = status.substring(1,20);*/
              $("#close","#dialog_rembug").trigger('click');
              $.ajax({
                type:"POST",
                async: false,
                dataType: "json",
                url: site_url+"rekening_nasabah/search_cif_by_account_insurance_no",
                data:{account_insurance_no:account_insurance_no},
                success: function(response)
                {
                    $("#no_rekening").val(response.account_insurance_no);
                    $("#nama").val(response.nama);
                    $("#tempat_lahir").val(response.tmp_lahir);
                    $("#tgl_lahir").val(response.tgl_lahir);
                    $("#form_add textarea[name='alamat']").val(response.alamat);
                    $("#rt_rw").val(response.rt_rw);
                    $("#desa").val(response.desa);
                    $("#kecamatan").val(response.kecamatan);
                    $("#kabupaten").val(response.kabupaten);
                    $("#kode_pos").val(response.kode_pos);
                    $("#telpon_rumah").val(response.telpon_rumah);
                    $("#produk").val(response.product_name); 
                    $("#jatuh_tempo").val(response.tanggal_jtempo_last); 
                    $("#awal_kontrak").val(response.awal_kontrak); 
                    $("#akhir_kontrak").val(response.akhir_kontrak); 
                    $("#benefit_value").val(response.benefit_value); 
                    $("#awal_kontrak1").val(response.awal_kontrak); 
                    $("#akhir_kontrak1").val(response.akhir_kontrak); 
                    $("#premium_value1").val(number_format(response.premium_value,0,'.','')); 
                    $("#plan").val(response.plan_code); 
                    $("#rekening_tabungan").val(response.account_saving_no); 
                    //fungsi untuk menyembunyikan input jadwal angsuran jika value=0
                    var insurance_type =  response.insurance_type;
                    if(insurance_type=='1')
                    {
                        $("#ins_tipe1").show();
                        $("#ins_tipe0").hide();
                    }
                    else
                    {
                        $("#ins_tipe1").hide();
                        $("#ins_tipe0").show();
                    }
                    
                    var account_saving_no = response.account_saving_no;
                      if(account_saving_no!="")
                      {
                        $.ajax({
                          type:"POST",
                          url: site_url+"transaction/search_name_by_account_saving_no_klaim",
                          data:{account_saving_no:account_saving_no},
                          dataType:"json",
                          success: function(response)
                          {
                            $("#nama_pemegang_rek").val(response.nama); 
                          }
                        });
                      }
                }
              });
        });

$("#result option","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
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
          
          rules: {
              no_rekening: {
                  required: true
              },
              jenis_klaim: {
                  required: true
              },
              tgl_klaim: {
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
              url: site_url+"rekening_nasabah/pengajuan_klaim_asuransi",
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

<!-- END JAVASCRIPTS