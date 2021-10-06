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
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- DIALOG REMBUG -->
<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari Rembug</h3>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>List Registrasi Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form>
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
            <table id="filter-form">
               <!-- <tr>
                  <td style="padding-bottom:10px;" width="100">Cabang</td>
                  <td>
                     <input type="text" name="branch" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                     <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
                  </td>
               </tr>
               <tr id="field_rembug">
                  <td style="padding-bottom:10px;" width="100">Rembug</td>
                  <td>
                    <input type="hidden" name="cm_code" id="cm_code">
                     <input type="text" name="rembug" id="rembug" class="m-wrap mfi-textfield" readonly="" style="background:#eee;"> 
                     <a id="browse_rembug" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_rembug">...</a>
                  </td>
               </tr> -->
               <tr style="display:none;">
                  <td style="padding-bottom:10px;" width="200">Kantor Cabang</td>
                  <td>
                    <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="<?php echo $this->session->userdata('branch_name'); ?>" />
                    <input type="hidden" id="cabang" name="cabang" value="<?php echo $this->session->userdata('branch_code'); ?>">
                    <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_cabang" class="btn blue" data-toggle="modal" href="#dialog_cabang">...</a><?php } ?>
                    <div id="dialog_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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
                          <button type="button" id="select_cabang" class="btn blue">Select</button>
                       </div>
                    </div>
                  </td>
               </tr>
               <tr style="display:none;">
                  <td style="padding-bottom:10px;" width="100">Tipe CIF</td>
                  <td>
                    <select name="produkOLD" id="produkOLD" style="width:220px;">
                      <option value="1">Pilih</option>
                      <option value="2">Semua Produk</option>
                      <option value="0">Kelompok</option>
                      <option value="1">Individu</option>
                    </select>
                  </td>
               </tr>
               <tr>
                  <td width="100" valign="top">Akad</td>
                  <td valign="top">
                    <select name="akad" id="akad" style="width:190px;" class="">
                      <option value="-">Semua</option>
                      <?php foreach($akad as $data):?>
                      <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_code'].' - '.$data['akad_name'];?></option>
                      <?php endforeach?>
                    </select>
                  </td>
               </tr>
               <tr>
                  <td valign="top" width="100">Produk</td>
                  <td>
                    <div class="controls">
                       <select id="produk_pembiayaan" name="produk_pembiayaan" class="chosen" style="width:190px;">
                         <option value="0000">Semua</option>
                          <?php foreach($produk as $produk){ ?>
                         <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                         <?php } ?>
                       </select>
                    </div>
                  </td>
               </tr>
               <tr class="group-smile" style="display: none;">
                  <td valign="middle" width="100">SMILE product list</td>
                  <td>
                    <div class="controls">
                      <select class="m-wrap chosen" name="product_code_smile" id="product_code_smile">
                        <option value="" maxrate="">PILIH</option>
                        <option value="semua">SEMUA</option>
                        <option value="52">FLAT</option>
                        <?php foreach($product_smile as $key){ ?>
                        <option value="<?php echo $key['product_code'] ?>"><?php echo $key['product_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </td>
                </tr>
               <tr>
                  <td width="150" valign="top">Kopegtel</td>
                  <td valign="top">
                    <select name="pengajuan_melalui" id="pengajuan_melalui" style="width:190px;" class="chosen">
                      <option value="-">Semua</option>
                      <option value="koptel">KOPTEL LANGSUNG</option>
                      <?php foreach($kopegtel as $data):?>
                      <option value="<?php echo $data['kopegtel_code'];?>"><?php echo $data['nama_kopegtel'];?></option>
                      <?php endforeach?>
                    </select>
                  </td>
               </tr>
               <tr>
                  <td width="100" valign="top">Tanggal</td>
                  <td valign="top">
                    <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                    sd
                    <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="previewpdf">Preview</button>
                     <button class="green btn" id="previewxls">Preview Excel</button>
                  </td>
               </tr>
            </table>
         </form>
            <p><hr></p>
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

  $('#produk_pembiayaan').on('change', function() {
    if(this.value=='52'){
      $('.group-smile').show();
      $('#product_code_smile').val(null).trigger('change');
    }else{
      $('.group-smile').hide();
      $('#product_code_smile').val(null).trigger('change');
    }
  });

  $("#browse_cabang").click(function(){
    $.ajax({
      type: "POST",
      url: site_url+"cif/get_branch_by_keyword",
      data: {keyword:$(this).val()},
      dataType: "json",
      success: function(response){
        var option = '';
        for(i = 0 ; i < response.length ; i++){
           option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
        }
        // console.log(option);
        $("#result").html(option);
      }
    });
  });

  $("#keyword").on('keypress',function(e){
      if(e.which==13){
        $.ajax({
          type: "POST",
          url: site_url+"cif/get_branch_by_keyword",
          data: {keyword:$(this).val()},
          dataType: "json",
          success: function(response){
            var option = '';
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            // console.log(option);
            $("#result").html(option);
          }
        });
      }
  });

  $("#select_cabang").click(function(){
    $("#close","#dialog_cabang").trigger('click');
    branch_code = $("#result option:selected","#dialog_cabang").attr('branch_code');
    branch_name = $("#result option:selected","#dialog_cabang").attr('branch_name');
    $("#cabang").val(branch_code);
    $("#branch_name").val(branch_name);
                
  });

  $("#result option:selected").live('dblclick',function(){
    $("#select_cabang").trigger('click');
  })

  //export PDF
  $("#previewpdf").click(function(e)
  {
    e.preventDefault();
    // var branch_code = $("#branch_code").val();
    // var cm_code = $("#cm_code").val();
    // var produk    = $("#produk").val();
    var tanggal   = datepicker_replace($("#tanggal").val());
    var tanggal2  = datepicker_replace($("#tanggal2").val());
    var cabang    = $("#cabang").val();
    var akad    = $("#akad").val();
    var pengajuan_melalui    = $("#pengajuan_melalui").val();

    var produk_pembiayaan = $("#produk_pembiayaan").val();
    var product_code_smile = $("#product_code_smile").val();
    if(produk_pembiayaan == '52'){
      var produk = product_code_smile;
    }else{
      var produk = produk_pembiayaan;
    }

    if(produk==""){
      alert("Produk Belum Di Pilih !");
    }else if(tanggal=="" && tanggal2==""){
      alert('Tanggal Masih Kosong !');
    }else{
      window.open('<?php echo site_url();?>laporan_to_pdf/export_list_registrasi_pembiayaan/'+produk+'/'+tanggal+'/'+tanggal2+'/'+cabang+'/'+akad+'/'+pengajuan_melalui);
      // window.open('<?php echo site_url();?>laporan_to_pdf/export_list_registrasi_pembiayaan/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code);
    }
  });

  //export XLS
  $("#previewxls").click(function(e)
  {
    e.preventDefault();
    // var branch_code = $("#branch_code").val();
    // var cm_code = $("#cm_code").val();
    // var produk    = $("#produk").val();
    var tanggal   = datepicker_replace($("#tanggal").val());
    var tanggal2  = datepicker_replace($("#tanggal2").val());
    var cabang    = $("#cabang").val();
    var akad    = $("#akad").val();
    var pengajuan_melalui    = $("#pengajuan_melalui").val();
    
    var produk_pembiayaan = $("#produk_pembiayaan").val();
    var product_code_smile = $("#product_code_smile").val();
    if(produk_pembiayaan == '52'){
      var produk = product_code_smile;
    }else{
      var produk = produk_pembiayaan;
    }

    if(produk==""){
      alert("Produk Belum Di Pilih !");
    }else if(tanggal=="" && tanggal2==""){
      alert('Tanggal Masih Kosong !');
    }else{
      window.open('<?php echo site_url();?>laporan_to_excel/export_list_registrasi_pembiayaan/'+produk+'/'+tanggal+'/'+tanggal2+'/'+cabang+'/'+akad+'/'+pengajuan_melalui);
      // window.open('<?php echo site_url();?>laporan_to_excel/export_list_registrasi_pembiayaan/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code);
    }
  });



  $(".dataTables_filter").parent().hide(); //menghilangkan serch

  jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

