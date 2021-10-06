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
      <h3 class="form-section">
      Transaction
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN ADD USER -->
<div id="add">
   
   <div class="portlet box blue">
      <div class="portlet-title">
         <div class="caption"><i class="icon-globe"></i>History Transaksi Deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
          <p>
                <div class="control-group">
                  <input type="hidden" id="status_rekening" name="status_rekening">
                   <label class="control-label">Nama<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="nama" id="nama" readonly="" style="background-color:#eee;" data-required="1" class="medium m-wrap"/>
                      <input type="hidden" name="cif_no" id="cif_no"/>
                      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                         <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Search Account Saving</h3>
                         </div>
                         <div class="modal-body">
                            <div class="row-fluid">
                               <div class="span12">
                                  <h4>Masukan Kata Kunci</h4>
                                  <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                  <option value="">Pilih Tipe CIF</option>
                                  <option value="">All</option>
                                  <option value="1">Individu</option>
                                  <option value="0">Kelompok</option>
                                  </select></p>
                                  <p class="hide" id="pcm"><select id="cm" class="span12 m-wrap">
                                  <option value="">Pilih Rembug</option>
                                  <?php foreach($rembugs as $rembug): ?>
                                  <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                  <?php endforeach; ?>;
                                  </select></p>
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

                    <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                   </div>
                </div>            
                <div class="control-group">
                   <label class="control-label">No Rekening<span class="required">*</span></label>
                   <div class="controls">
                      <select name="no_rek" id="no_rek" style="width:170px;">
                        <option value="">Pilih</option>
                    </select>
                   </div>
                </div>             
                <div class="control-group">
                   <label class="control-label">Produk<span class="required">*</span></label>
                   <div class="controls">
                      <select name="produk" id="produk" style="width:170px;">
                        <option value="">Pilih</option>
                      <?php foreach($produk as $data):?>
                        <option value="<?php echo $data['product_code'];?>"><?php echo $data['product_name'];?></option>
                      <?php endforeach?>
                    </select>
                   </div>
                </div>             
                <div class="control-group">
                   <label class="control-label">Periode<span class="required">*</span></label>
                   <div class="controls">
                     <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                      sd
                     <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                   </div>
                </div>  
                <div style="padding-left:180px;">
                   <button class="green btn" id="previewpdf">Preview</button>
                   <button class="green btn" id="previewxls">Preview Excel</button>
                </div>
            <p><hr></p>
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
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk mencari CIF_NO
      $(function(){
        $("#select","#dialog_rembug").click(function(){
          var status = $("#result").val();
          var cif_no = status;
              $("#close","#dialog_rembug").trigger('click');
              $.ajax({
                type:"POST",
                url: site_url+"transaction/get_value_lap_rek_dep",
                data:{cif_no:cif_no},
                dataType:"json",
                success: function(response)
                      {
                     
                        $("#nama").val(response.nama);
                        $("#cif_no").val(response.cif_no);

                         $.ajax({
                               type: "POST",
                               url: site_url+"transaction/get_account_deposit",
                               dataType: "json",
                               data: {cif_no:response.cif_no},
                               success: function(response){
                                  html = '<option value="">PILIH</option>';
                                  for ( i = 0 ; i < response.length ; i++ )
                                  {
                                     html += '<option value="'+response[i].account_deposit_no+'">'+response[i].account_deposit_no+'</option>';
                                  }
                                  $("#no_rek","#form_add").html(html);
                               }
                          });   
                      }
              })
          });
        });

   
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
              url: site_url+"transaction/search_account_deposit_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
           // type = $("#cif_type","#form_add").val();
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"transaction/search_account_deposit_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
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
              url: site_url+"transaction/search_account_deposit_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });

        $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
        });


      //export PDF
      $("#previewpdf").click(function(e)
      {
        e.preventDefault();
        var nama      = $("#nama").val();
        var cif_no    = $("#cif_no").val();
        var no_rek    = $("#no_rek").val();
        var produk    = $("#produk").val();
        var tanggal   = $("#tanggal").val().replace(/\//g,'');;
        var tanggal2  = $("#tanggal2").val().replace(/\//g,'');;
        if (nama=="") {
          alert("Nama Belum Terisi");
        }else if(no_rek=="") {
          alert("No Rekening Belum Di Pilih");
        }else if(produk=="") {
          alert("Produk Belum Di Pilih");
        }else if(tanggal=="") {
          alert("Tanggal Belum Terisi");
        }else if(tanggal2=="") {
          alert("Tanggal Belum Terisi");
        }else{
          window.open('<?php echo site_url();?>laporan_to_pdf/export_list_rekening_deposito/'+cif_no+'/'+no_rek+'/'+produk+'/'+tanggal+'/'+tanggal2);
        }
      });

      //export XLS
      $("#previewxls").click(function(e)
      {
        e.preventDefault();
        var nama      = $("#nama").val();
        var cif_no    = $("#cif_no").val();
        var no_rek    = $("#no_rek").val();
        var produk    = $("#produk").val();
        var tanggal   = $("#tanggal").val().replace(/\//g,'');;
        var tanggal2  = $("#tanggal2").val().replace(/\//g,'');;
        if (nama=="") {
          alert("Nama Belum Terisi");
        }else if(no_rek=="") {
          alert("No Rekening Belum Di Pilih");
        }else if(produk=="") {
          alert("Produk Belum Di Pilih");
        }else if(tanggal=="") {
          alert("Tanggal Belum Terisi");
        }else if(tanggal2=="") {
          alert("Tanggal Belum Terisi");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_list_rekening_deposito/'+cif_no+'/'+no_rek+'/'+produk+'/'+tanggal+'/'+tanggal2);
        }
      });

</script>
<!-- END JAVASCRIPTS -->

