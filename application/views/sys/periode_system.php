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
        SYSTEM <small>Periode Transaksi</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Periode Transaksi</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal">
            <div class="control-group">
               <label class="control-label">Periode<span class="required">*</span></label>
               <div class="controls">
                <?php
                 $exp1 = explode("-", $pawal);
                 $p_awal  = $exp1[2]."/".$exp1[1]."/".$exp1[0];
                ?>
                <?php
                 $exp1 = explode("-", $pakhir);
                 $p_akhir  = $exp1[2]."/".$exp1[1]."/".$exp1[0];
                ?>
                  <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $p_awal;?>" class="mask_date date-picker small m-wrap" maxlength="10" >
                  <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $p_akhir;?>" class="mask_date date-picker small m-wrap" maxlength="10" >
               </div>
            </div>
            <input type="hidden" id="id" id="id" value="<?php echo $pid;?>">
            <div class="form-actions">
               <button type="button" id="update" class="btn green">Update</button>
               <button type="button" class="btn" id="cancel">Back</button>
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


<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("#tanggal").inputmask("d/m/y");  //direct mask       
      $("#tanggal2").inputmask("d/m/y");  //direct mask      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
/* BEGIN SCRIPT */
   
      //export XLS
      $("#update").click(function(e)
      {
        e.preventDefault();
        // var branch_code = $("#branch_code").val();
        // var cm_code = $("#cm_code").val();
        var id   = $("#id").val();
        var tanggal   = $("#tanggal").val();
        var tanggal2  = $("#tanggal2").val();
        if(tanggal=="" || tanggal2==""){
          alert('Tanggal Masih Kosong !');
        }else{                    
                $("#div_loading").show();
          $.ajax({
              type: "POST",
              async:false,
              url: site_url+"sys/update_periode",
              dataType: "json",
              data: {id:id,tanggal:tanggal,tanggal2:tanggal2},
              success: function(response){
                if(response.success==true){
                  alert("success !");
                  window.location.reload();
                }else{
                  alert("Failed !");
                  window.location.reload();
                }
                $("#div_loading").hide(); 
              },
              error:function(){
                $("#div_loading").hide();
                 alert("Failed to Connect into Databases, Please Contact Your Administration!");
              }
          });
        }
      });

      $("#cancel").click(function()
      {
        window.location.href=site_url;
      });



      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

