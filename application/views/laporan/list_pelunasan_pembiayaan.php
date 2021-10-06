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
      <div class="caption"><i class="icon-globe"></i>List Pelunasan Pembiayaan</div>
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
               <tbody>
               <tr>
                  <td style="padding-bottom:10px;" width="100">Cabang</td>
                  <td>
                     <input type="text" name="branch" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                     <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
                  </td>
               </tr>
               <tr style="display:none;">
                  <td style="padding-bottom:10px;" width="100">Tipe CIF</td>
                  <td>
                    <select name="tipe" id="tipe" class="m-wrap">
                      <option value="1">Pilih</option>
                      <option value="1">Individu</option>
                      <option value="0">Kelompok</option>
                    </select>
                  </td>
               </tr>
               <tr id="kelompok" style="display:none;">
                  <td style="padding-bottom:10px;" width="100">Rembug</td>
                  <td>
                    <input type="hidden" name="cm_code" id="cm_code">
                     <input type="text" name="rembug" id="rembug" class="m-wrap mfi-textfield" readonly="" style="background:#eee;"> 
                     <a id="browse_rembug" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_rembug">...</a>
                  </td>
               </tr>
               </tbody>
                   <tr>
                      <td width="100" valign="top">Petugas</td>
                      <td valign="top">
                        <select name="petugas" id="petugas" style="width:190px;" class="chosen">
                          <option value="000000">Semua</option>
                          <?php foreach($petugas as $data):?>
                          <option value="<?php echo $data['fa_code'];?>"><?php echo $data['fa_name'];?></option>
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

/* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
      result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      result_code = $("#result","#dialog_branch").val();
      if(result!=null)
      {
         $("input[name='branch']").val(result_name);
         $("input[name='branch_code']").val(result_code);
         $("input[name='branch_id']").val(branch_id);
         $("#field_rembug").show();
         $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })

   /* END DIALOG ACTION BRANCH */


    $(function(){
      branch_code = $("#branch_code").val();
      if(branch_code=='')
      {
        $("#field_rembug").hide();
      }
      else
      {
        $("#field_rembug").show();
      }
    });


   /* BEGIN DIALOG ACTION REMBUG */
  
   $("#browse_rembug").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_rembug").val(),branch_id:$("#branch_id").val()},
         success: function(response){
            html = '';
            html += '<option value="0000" cm_id="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   })

   $("#keyword","#dialog_rembug").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword",
            dataType: "json",
            data: {keyword:keyword,branch_id:$("#branch_id").val()},
            success: function(response){
              html = '';
              html += '<option value="0000" cm_id="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
              }
              $("#result","#dialog_rembug").html(html);
            }
         })
      }
   });

   $("#select","#dialog_rembug").click(function(){
      cm_id = $("#result option:selected","#dialog_rembug").attr('cm_id');
      cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
      cm_code = $("#result","#dialog_rembug").val();
      if(result!=null)
      {
         $("input[name='rembug']").val(cm_name);
         $("input[name='cm_code']").val(cm_code);
         $("#close","#dialog_rembug").trigger('click');
      }
   });

   $("#result option:selected","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
   })

   /* END DIALOG ACTION REMBUG */

  $("#tipe").change(function(e){
    var tipe = $(this).val();
    if(tipe==0){
      $("#kelompok").hide();
      // $("#kelompok").show();
    }else if(tipe==1){
      $("#kelompok").hide();
    }else{
      $("#kelompok").hide();
    }
  });   

      //export PDF
      $("#previewpdf").click(function(e)
      {
        e.preventDefault();
        var tipe = $("#tipe").val();
        var branch_code = $("#branch_code").val();
        var cm_code = $("#cm_code").val();
        var petugas = $("#petugas").val();
        // var produk = $("#produk").val();

        var produk_pembiayaan = $("#produk_pembiayaan").val();
        var product_code_smile = $("#product_code_smile").val();
        if(produk_pembiayaan == '52'){
          var produk = product_code_smile;
        }else{
          var produk = produk_pembiayaan;
        }

        var tanggal = datepicker_replace($("#tanggal").val());
        var tanggal2 = datepicker_replace($("#tanggal2").val());
        if(tipe==0){
          window.open('<?php echo site_url();?>laporan_to_pdf/list_pelunasan_pembiayaan_kelompok/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code+'/'+petugas+'/'+produk);
        }else{
          if(branch_code==""){
            alert("Cabang belum dipilih");
          }else if(petugas==""){
            alert("Petugas belum dipilih");
          }else if(produk==""){
            alert("Produk belum dipilih");
          }else if(tanggal=="" && tanggal2==""){
            alert("Tanggal belum dilengkapi");
          }else{
            window.open('<?php echo site_url();?>laporan_to_pdf/list_pelunasan_pembiayaan_individu/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+petugas+'/'+produk);
          }
        }
      });

      //export XLS
      $("#previewxls").click(function(e)
      {
        e.preventDefault();
        var tipe = $("#tipe").val();
        var branch_code = $("#branch_code").val();
        var cm_code = $("#cm_code").val();
        var petugas = $("#petugas").val();
        // var produk = $("#produk").val();
        
        var produk_pembiayaan = $("#produk_pembiayaan").val();
        var product_code_smile = $("#product_code_smile").val();
        if(produk_pembiayaan == '52'){
          var produk = product_code_smile;
        }else{
          var produk = produk_pembiayaan;
        }

        var tanggal = datepicker_replace($("#tanggal").val());
        var tanggal2 = datepicker_replace($("#tanggal2").val());
        if(tipe==0){
          window.open('<?php echo site_url();?>laporan_to_excel/list_pelunasan_pembiayaan_kelompok/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+cm_code+'/'+petugas+'/'+produk);
        }else{
          if(branch_code==""){
            alert("Cabang belum dipilih");
          }else if(petugas==""){
            alert("Petugas belum dipilih");
          }else if(produk==""){
            alert("Produk belum dipilih");
          }else if(tanggal=="" && tanggal2==""){
            alert("Tanggal belum dilengkapi");
          }else{
            window.open('<?php echo site_url();?>laporan_to_excel/list_pelunasan_pembiayaan_individu/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+petugas+'/'+produk);
          }
        }
      });

</script>
<!-- END JAVASCRIPTS -->

