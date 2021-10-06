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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Proses Akhir Bulan <small>Distribusi Bonus Tabungan</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Distribusi Bonus Tabungan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="proses_bonus" method="post" action="<?php echo site_url('sys/do_bagihasil_tabungan'); ?>">
            <div class="alert alert-error <?php echo ($this->session->flashdata('failed')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success <?php echo ($this->session->flashdata('success')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               Proses Bonus Sukses.
            </div>
            <div class="control-group">
              <label class="control-label">Produk<span class="required">*</span></label>
              <div class="controls">
                <select name="product_code" id="product_code" class="medium m-wrap">
                  <option value="">Pilih Produk</option>
                  <?php foreach($product as $produk): ?>
                  <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Tanggal<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="tanggal" id="tanggal" placeholder="dd/mm/yyyy" class="mask_date date-picker small m-wrap" maxlength="10" >
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Rate Bonus<span class="required">*</span></label>
              <div class="controls">
              <div class="input-append">
                <input type="text" name="rate" id="rate" class="m-wrap" maxlength="6" style="width:60px">
                <span class="add-on">%</span>
                </div>
              </div>
            </div>
            <div class="form-actions">
               <button type="submit" id="update" class="btn green">Proses Bonus</button>
               <button type="reset" class="btn red" id="cancel">Reset</button>
            </div>
         </form>
          <!-- END FILTER-->
      </div>
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
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>       
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  


<script type="text/javascript">
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("#tanggal").inputmask("d/m/y");


      var form = $('#proses_bonus');
      var error = $('.alert-error', form);
      var success = $('.alert-success', form);
      form.validate({
        errorElement:"span",errorClass:"help-inline",focusInvalid:false,
        errorPlacement:function(error,element){},
        rules:{
          product_code:{required:true},
          tanggal:{required:true},
          rate:{number:true,required:true}
        },
        invalidHandler: function (event, validator) {
            success.hide();
            error.show();
            App.scrollTo(error, -200);
        },
        highlight: function (element) {
            $(element).closest('.help-inline').removeClass('ok');
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        unhighlight: function (element) {
            $(element).closest('.control-group').removeClass('error');
        }
      });
   });

</script>
<!-- END JAVASCRIPTS -->

