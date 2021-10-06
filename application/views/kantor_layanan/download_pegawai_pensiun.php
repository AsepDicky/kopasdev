<style type="text/css">
  .error-field{
    background-color: #F4D8D6 !important;
  }
</style>
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
      DOWNLOAD DATA PEGAWAI PENSIUN
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="#">Kantor Layanan</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Kantor</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">DOWNLOAD DATA PEGAWAI PENSIUN</a></li>  
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>PEGAWAI PENSIUN</div>
   </div>
   <div class="portlet-body">
      <table id="filter-form">
         <tr>
            <td width="150">Tanggal Pensiun</td>
            <td>
              <input type="text" class="m-wrap small mask_date date-picker" placeholder="From Date" id="from_date" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              <input type="text" class="m-wrap small mask_date date-picker" placeholder="To Date" id="to_date" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="blue btn" id="download" style="margin-top:5px;"><i class="icon-download"></i> Download</button>
            </td>
         </tr>
      </table>
      <hr>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




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

  $("#download").click(function(){
    bValid=true;
    var from_date = datepicker_replace($("#from_date").val());
    var to_date = datepicker_replace($("#to_date").val());
    // alert(from_date)
    // alert(to_date)
    if(from_date==''){
      $("#from_date").addClass('error-field');
      bValid=false;
    }else{
      $("#from_date").removeClass('error-field');
    }
    if(to_date==''){
      $("#to_date").addClass('error-field');
      bValid=false;
    }else{
      $("#to_date").removeClass('error-field');
    }
    if(bValid==true){
      window.open('<?php echo site_url();?>laporan_to_excel/download_pegawai_pensiun/'+from_date+'/'+to_date+'/preview');
    }

  })
  

  // jQuery('#voucher_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table download input
  // jQuery('#voucher_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  jQuery('#voucher_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table download input
  // jQuery('#voucher_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

})
</script>