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
        Laporan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
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

<!-- DIALOG PETUGAS LAPANGAN -->
<div id="dialog_petugas_lapangan" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Petugas Lapangan</h3>
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

<!-- DIALOG REMBUG -->
<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Rembug</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select" class="btn blue">Select</button>
   </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue">
  <div class="portlet-title">
     <div class="caption"><i class="icon-reorder"></i>LIST TRANSAKSI REMBUG</div>
     <div class="tools">
        <!-- <a href="javascript:;" class="collapse"></a>
        <a href="#portlet-config" data-toggle="modal" class="config"></a>
        <a href="javascript:;" class="reload"></a>
        <a href="javascript:;" class="remove"></a> -->
     </div>
  </div>

  <div class="portlet-body form">
     <!-- BEGIN FORM-->
     <form action="<?php echo site_url('cif/add_cif_individu'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

        <div class="alert alert-error hide">
           <button class="close" data-dismiss="alert"></button>
           Terdapat beberapa form yang error. Mohon periksa kembali
        </div>
        <div class="alert alert-success hide">
           <button class="close" data-dismiss="alert"></button>
           CIF Baru berhasil di buat !
        </div>
        <br>
        <div class="control-group">
           <label class="control-label">Kantor Cabang</label>
           <div class="controls">
              <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
              <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
              <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
              <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a><?php } ?>
           </div>
        </div>
        <div class="control-group">
           <label class="control-label">Petugas Lapangan</label>
           <div class="controls">
              <input type="text" name="fa_name" id="fa_name" data-required="1" value="Semua Petugas" class="medium m-wrap" readonly style="background:#EEE"/>
              <input type="hidden" name="fa_code" id="fa_code" value="0000">
              <a id="browse_fa" class="btn blue" data-toggle="modal" href="#dialog_petugas_lapangan">...</a>
           </div>
        </div>
        <div class="control-group">
           <label class="control-label">Rembug</label>
           <div class="controls">
            <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" value="Semua Rembug" readonly style="background:#EEE;">
            <input type="hidden" name="cm_code" id="cm_code" value="0000">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
           </div>
        </div>
        <div class="control-group">
           <label class="control-label">Periode Transaksi</label>
           <div class="controls">
              <input type="text" name="awal_trx_date" id="awal_trx_date" value="<?php echo $trx_date; ?>" data-required="1" placeholder="dd/mm/yyyy" class="mask-date date-picker small m-wrap"/>
              <span style="line-height:32px;">-&nbsp;</span>
              <input type="text" name="akhir_trx_date" id="akhir_trx_date" value="<?php echo $trx_date; ?>" data-required="1" placeholder="dd/mm/yyyy" class="mask-date date-picker small m-wrap"/>
           </div>
        </div>
        <div class="form-actions">
           <button type="submit" id="export_pdf" class="btn green">Preview</button>
           <button type="submit" id="export_excel" class="btn green">Preview Excel</button>
        </div>
     </form>
     <!-- END FORM-->
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
      App.init(); 
      $(".mask-date").inputmask("d/m/y");
   });
</script>

<script type="text/javascript">

// BEGIN SEARCH BRANCH
$("#keyword","#dialog_kantor_cabang").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang").html(html);
         }
      })
   }
});

$("a#browse_branch").click(function(){
   keyword = $("#keyword","#dialog_kantor_cabang").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang").html(html);
         }
      })
});

$("#select","#dialog_kantor_cabang").click(function(){
  $(".close","#dialog_kantor_cabang").trigger('click');
  branch_code = $("#result","#dialog_kantor_cabang").val();
  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
  $("#branch_code").val(branch_code);
  $("#branch_name").val(branch_name);
  $("#branch_id").val(branch_id);
});

$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
  $("#select","#dialog_kantor_cabang").trigger('click');
});

// BEGIN SEARCH PETUGAS LAPANGAN
$("#keyword","#dialog_petugas_lapangan").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_fa_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_code:$("#branch_code").val()},
         success: function(response){
            html = '<option value="0000" fa_name="Semua Petugas">0000 - Semua Petugas</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_code+' - '+response[i].fa_name+'</option>';
            }
            $("#result","#dialog_petugas_lapangan").html(html);
         }
      })
   }
});

$("a#browse_fa").click(function(){
   keyword = $("#keyword","#dialog_petugas_lapangan").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_fa_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_code:$("#branch_code").val()},
         success: function(response){
            html = '<option value="0000" fa_name="Semua Petugas">0000 - Semua Petugas</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_code+' - '+response[i].fa_name+'</option>';
            }
            $("#result","#dialog_petugas_lapangan").html(html);
         }
      })
});

$("#select","#dialog_petugas_lapangan").click(function(){
  $(".close","#dialog_petugas_lapangan").trigger('click');
  fa_code = $("#result","#dialog_petugas_lapangan").val();
  fa_name = $("#result option:selected","#dialog_petugas_lapangan").attr('fa_name');
  $("#fa_code").val(fa_code);
  $("#fa_name").val(fa_name);
});

$("#result option","#dialog_petugas_lapangan").live('dblclick',function(){
  $("#select","#dialog_petugas_lapangan").trigger('click');
});



// BEGIN SEARCH REMBUG
$("#keyword","#dialog_rembug").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      var branch = $("#branch_id").val();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_id:branch},
         success: function(response){
            html = '';
            html += '<option value="0000" cm_id="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   }
});

$("#browse_rembug").click(function(){
   keyword = $("#keyword","#dialog_rembug").val();
   branch = $("#branch_id").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:keyword,branch_id:branch},
         success: function(response){
            html = '';
            html += '<option value="0000" cm_id="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
});

$("#select","#dialog_rembug").click(function(){
  $(".close","#dialog_rembug").trigger('click');
  cm_code = $("#result","#dialog_rembug").val();
  cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
  $("#cm_code").val(cm_code);
  $("#cm_name").val(cm_name);
});

$("#result option","#dialog_rembug").live('dblclick',function(){
  $("#select","#dialog_rembug").trigger('click');
});

$("#export_excel").click(function(e){
  e.preventDefault();
  branch_code = $("#branch_code").val();
  fa_code = $("#fa_code").val();
  cm_code = $("#cm_code").val();
  awal_trx_date = datepicker_replace($("#awal_trx_date").val());
  akhir_trx_date = datepicker_replace($("#akhir_trx_date").val());
  window.open(site_url+"laporan_to_excel/export_list_transaksi_rembug/"+branch_code+"/"+awal_trx_date+"/"+akhir_trx_date+"/"+cm_code+"/"+fa_code);
});

$("#export_pdf").click(function(e){
  e.preventDefault();
  branch_code = $("#branch_code").val();
  fa_code = $("#fa_code").val();
  cm_code = $("#cm_code").val();
  awal_trx_date = datepicker_replace($("#awal_trx_date").val());
  akhir_trx_date = datepicker_replace($("#akhir_trx_date").val());
  window.open(site_url+"laporan_to_pdf/export_lap_trx_rembug/"+branch_code+"/"+awal_trx_date+"/"+akhir_trx_date+"/"+cm_code+"/"+fa_code);
});

</script>