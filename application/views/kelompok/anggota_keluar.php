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
      CIF Kelompok
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD USER -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pegawai Keluar</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM--> 
         <form action="#" id="form_add" class="form-horizontal">  <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Pegawai Berhasil Dikeluarkan !
            </div>
            <br>
            <!-- DIALOG CM -->
            <div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3>Cari Pegawai</h3>
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
            <div style="clear:both;overflow:auto;">
            <div style="width:50%;float:left">

            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#f9f9f9;"/>  
                <a id="browse_cm" class="btn blue" data-toggle="modal" href="#dialog_cm">...</a>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Nama </label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir </label>
               <div class="controls">
                  <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir </label>
               <div class="controls">
                  <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Usia </label>
               <div class="controls">
                  <input type="text" name="usia" id="usia" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
               </div>
            </div>
            </div>       
            </div>       
            <div class="form-actions">
               <button type="submit" class="btn green">Proses</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>       
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
     App.init(); // initlayout and core plugins
     $(".datemask").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
     });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){
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
              desa: {
                  required: true
              },
              rembug: {
                  required: true
              },
              id_anggota: {
                  required: true
              },
              tanggal_mutasi: {
                  required: true
              },
              alasan: {
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
              // .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              label.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
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
              url: site_url+"kelompok/proses_anggota_keluar",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  alert(response.message);
                  window.location.reload(true);
                }else{
                  alert(response.message);
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
                App.scrollTo(error1, -200);
              }
            });

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



      $("#button-dialog").click(function(){
        $("#dialog").dialog('open');
      });

      $("#browse_cm").click(function(){
          if($("#keyword","#dialog_cm").val()==""){
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_pegawai_by_keyword",
               dataType: "json",
               data: {keyword:''},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'" tempat="'+response[i].tmp_lahir+'" tgl_lahir="'+response[i].tgl_lahir+'" usia="'+response[i].usia+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            })
          }
        })

        $("#keyword","#dialog_cm").keypress(function(e){
          keyword = $(this).val();
          if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_pegawai_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
               async: false,
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'" tempat="'+response[i].tmp_lahir+'" tgl_lahir="'+response[i].tgl_lahir+'" usia="'+response[i].usia+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            });
            return false;
          }
        });

        //mencari anggota rembug sesuai rembug yang dipilih
        $("#select","#dialog_cm").click(function(){
          $("#close","#dialog_cm").trigger('click');
          var cm_code = $("#result").val();
          cif_no = $("#result option:selected","#dialog_cm").val();
		  nama = $("#result option:selected","#dialog_cm").attr('nama');
		  tempat = $("#result option:selected","#dialog_cm").attr('tempat');
		  tanggal = $("#result option:selected","#dialog_cm").attr('tgl_lahir');
		  usia = $("#result option:selected","#dialog_cm").attr('usia');

          $("#cif_no").val(cif_no);
		  $("#nama").val(nama);
		  $("#tmp_lahir").val(tempat);
		  $("#tgl_lahir").val(tanggal);
		  $("#usia").val(usia);
        }); 

        $("#result option","#dialog_cm").live('dblclick',function(){
            $("#select","#dialog_cm").trigger('click');
        });

      jQuery('#desa_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#desa_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

