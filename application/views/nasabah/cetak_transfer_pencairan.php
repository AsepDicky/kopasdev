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
      Rekening Nasabah <small>Cetak Transfer Pencairan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Cetak Transfer Pencairan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN SEARCH -->
<div id="search">
  <div class="portlet box grey">
    <div class="portlet-title">
       <div class="caption"><i class="icon-reorder"></i>Cetak Transfer Pencairan</div>
       <div class="tools">
          <a href="javascript:;" class="collapse"></a>
       </div>
    </div>
    <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form id="form" method="post" action="<?php echo site_url('rekening_nasabah/do_cetak_transfer_pencairan'); ?>" class="form-horizontal">
        <div class="alert alert-error hide">
           <button class="close" data-dismiss="alert"></button>
           You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
           <button class="close" data-dismiss="alert"></button>
           Registrasi Transfer Pencairan Berhasil Di Proses !
        </div>
        <div class="form-body" style="padding-top:20px;padding-bottom:20px;">
          <div class="control-group">
            <label class="control-label">Tanggal SPB<span class="required">*</span></label>
            <div class="controls">
              <input type="text" name="tanggal_transfer" id="tanggal_transfer" data-required="1" class="small m-wrap mask-date date-picker" placeholder="DD/MM/YYYY" />
              <button type="button" class="btn blue hide" id="cari"><i class="icon-search"></i> Cari</button>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Nomor SPB<span class="required">*</span></label>
            <div class="controls">
              <select id="no_spb" name="no_spb" class="medium m-wrap">
                <option value="">PILIH</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-actions">
           <!-- <button type="submit" class="btn green" name="previewPDF" id="previewPDF"><i class="icon-pdf"></i> Preview</button> -->
           <button type="submit" class="btn green" name="previewXLS" id="previewXLS"><i class="icon-xls"></i> Preview XLS</button>
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
      $(".mask-date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){

  $('#tanggal_transfer').change(function(){
    $('#cari').trigger('click');
  })
  $('#cari').click(function(){
    tanggal_transfer = $("#tanggal_transfer").val();
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {tanggal_spb:tanggal_transfer},
      url: site_url+"rekening_nasabah/get_no_spb_by_tgl",
      success: function(response){
       if(response.length>0){
        html = '<option value="">PILIH NO SPB</option>';
       }else{
        html = '<option value="">NO SPB TIDAK DITEMUKAN</option>';
       }
       for ( i = 0 ; i < response.length ; i++ )
       {
          html += '<option value="'+response[i].no_spb+'">'+response[i].no_spb+'</option>';
       }
       $("#no_spb").html(html);
      }
    })
  })

  $('#form').validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error,element){},
    rules: {
      tanggal_transfer: {required: true}
      ,no_spb: {required: true}
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        $('.alert-success').hide();
        $('.alert-error').show();
        App.scrollTo($('.alert-error'), -200);
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
    }
  });
//  END FORM EDIT VALIDATION
});

</script>
<!-- END JAVASCRIPTS -->
