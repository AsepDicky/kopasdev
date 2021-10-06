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
        Proses Akhir Bulan <small>Tutup Buku Transaksi</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Tutup Buku Transaksi</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="closing_transaction_process" method="post" action="<?php echo site_url('sys/closing_transaction_process'); ?>">
            <?php
            if( $num_trx_financing_verified_not_yet > 0 || $num_trx_saving_verified_not_yet > 0 ){
              $n=0;
            ?>
            <div class="alert alert-warning">
              <div style="font-weight:bold">Warning!</div>
              <?php if($num_trx_financing_verified_not_yet>0){ $n++; echo $n.'. ('.$num_trx_financing_verified_not_yet.') Transaksi Pembiayaan belum diverifikasi<br>Tanggal : '.$tanggal_financing; } ?>
              <?php if($num_trx_saving_verified_not_yet>0){ $n++; echo $n.'. ('.$num_trx_saving_verified_not_yet.') Transaksi Tabungan belum diverifikasi<br>Tanggal : '. $tanggal_saving; } ?>
              <br>
              <span style="font-weight:bold;">Proses tidak bisa dijalankan.</span>
            </div>
            <?php
            }
            ?>
            <div class="alert alert-error <?php echo ($this->session->flashdata('failed')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               Internal Server Error!
            </div>
            <div class="alert alert-success <?php echo ($this->session->flashdata('success')==false)?"hide":""; ?>">
               <button class="close" data-dismiss="alert"></button>
               Proses Tutup Buku Transaksi Sukses.
            </div>
            <?php if($this->session->userdata('branch_code')!='00000'){ ?>
            <div class="alert alert-warning">
               <button class="close" data-dismiss="alert"></button>
               Proses Tutup Buku Transaksi hanya bisa dilakukan oleh PUSAT
            </div>
            <?php } ?>
            <div class="control-group">
              <label class="control-label">Cabang<span class="required">*</span></label>
              <div class="controls">
                <input type="text" id="branch_name" name="branch_name" class="m-wrap medium" readonly style="background-color:#F5F5F5;" value="<?php echo $this->session->userdata('branch_name') ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Periode<span class="required">*</span></label>
              <div class="controls">
                <input type="hidden" name="periode" id="periode" placeholder="dd/mm/yyyy" class="mask_date date-picker small m-wrap" value="<?php echo $day_periode_akhir.'/'.$month_periode_akhir.'/'.$year_periode_akhir; ?>">
                <input type="text" class="m-wrap medium" readonly style="background-color:#F5F5F5" value="<?php echo $periode_akhir; ?>">
              </div>
            </div>
            <div class="form-actions">
              <?php if( $num_trx_financing_verified_not_yet > 0 || $num_trx_saving_verified_not_yet > 0 ){ ?>
              <a href="javascript:void(0);" class="btn grey">Proses Sekarang</a>
              <?php }else{ ?>
              <button type="submit" id="proses" class="btn green">Proses Sekarang</button>
              <?php } ?>
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
    
      $(".mask_date").inputmask("d/m/y");

      var form = $('#closing_transaction_process');
      form.validate({
        errorElement:"span",errorClass:"help-inline",focusInvalid:false,
        errorPlacement:function(error,element){},
        rules:{
          periode:{required:true}
        },
        invalidHandler: function (event, validator) {
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

