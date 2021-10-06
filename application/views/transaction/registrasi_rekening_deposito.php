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
			Deposito Setup <small>Pengaturan Deposito</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Deposito Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Deposito</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete Record <i class="icon-remove"></i>
            </button>
         </div>
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
      </div>
      <table class="table table-striped table-bordered table-hover" id="deposito_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#deposito_table .checkboxes" /></th>
               <th width="40%">No. Customer</th>
               <th width="40%">Nama Lengkap</th>
               <th width="40%">No. Rekening</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD DEPOSITO -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Rekening Deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('transaction/add_deposito'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
	 
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Deposito has been Created !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No. Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_customer" id="cif_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input type="hidden" id="branch_code" name="branch_code">
                  <input type="hidden" id="date_now" name="date_now" value="<?php echo date('Y-m-d');?>">
                  <input type="hidden" id="jatuh_tempo" name="jatuh_tempo">
                  <input type="hidden" id="jatuh_tempo_next" name="jatuh_tempo_next">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         </label>
      
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari CIF</h3>
         </div>
         <div class="modal-body">
            <div class="row-fluid">
               <div class="span12">

                  <h4>Masukan Kata Kunci</h4>
                  <?php
                    if($this->session->userdata('cif_type')==0){
                    ?>
                      <input type="hidden" id="cif_type" name="cif_type" value="0">
                      <p id="pcm" style="height:32px">
                      <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                      <option value="">Pilih Rembug</option>
                      <?php foreach($rembugs as $rembug): ?>
                      <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                      <?php endforeach; ?>;
                      </select></p>
                    <?php
                    }else if($this->session->userdata('cif_type')==1){
                      echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                    }else{
                    ?>
                      <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                      <option value="">Pilih Tipe CIF</option>
                      <option value="">All</option>
                      <option value="1">Individu</option>
                      <option value="0">Kelompok</option>
                      </select></p>
                      <p class="hide" id="pcm" style="height:32px">
                      <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                      <option value="">Pilih Rembug</option>
                      <?php foreach($rembugs as $rembug): ?>
                      <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                      <?php endforeach; ?>;
                      </select></p>
                    <?php
                    }
                    ?>
                  
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>

                  <!-- <h4>Masukan Kata Kunci</h4>
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                  <option value="">Pilih Tipe CIF</option>
                  <option value="">All</option>
                  <option value="1">Individu</option>
                  <option value="0">Kelompok</option>
                  </select></p>                    
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      
		  
               </div>
	       <input type="hidden" id="cif_no" name="cif_no">
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan</label>
               <div class="controls">
                  <input name="nama_panggilan" id="panggilan" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="nama_ibu" id="ibu_kandung" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tempat_lahir" id="tmp_lahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir</label>
               <div class="controls">
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" style="background-color:#eee;width:30px;" readonly=""/> 
                  <span style="color:black;margin-right:20px;display:inline-block;margin-top:6px">Tahun</span>
                  <span class="help-inline"></span>&nbsp;
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                          <select name="product" id="product" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($product as $data): ?>
                              <option value="<?php echo $data['product_code'];?>"><?php echo $data['product_name'];?></option>
                            <?php endforeach?>
                          </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening</label>
               <div class="controls">
                  <input name="no_rekening" id="account_deposit_no" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="jangka_waktu" id="jangka_waktu" style="width:30px;"  maxlength="2" /> 
                  <span style="color:black;margin-right:20px;display:inline-block;padding:7px 0">Bulan</span>
	       </div>
            </div> 
            <div class="control-group">
              <label class="control-label">Nominal<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="m-wrap mask-money" style="width:120px;"  name="nominal" id="nominal">
                       <span class="add-on">,00</span>
                    </div>
                 </div>
              </div>
            <div class="control-group">
               <label class="control-label">Nisbah Bagi Hasil Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="nisbah_bagihasil" style="width:30px;"  maxlength="3" />
                  <span class="help-inline"> %</span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rekening Bagi Hasil <br><smal>(opsional)</small></label>
               <div class="controls">
                 <select id="rek_bagi" name="rek_bagi_hasil" class="medium m-wrap">                     
                 </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Auto Roll Over (ARO)</label>
                  <div class="controls">
                           <label class="radio">
                             <input type="radio" name="ya" id="ya" value="1"/>
                             Ya
                           </label>
                           <div class="clearfix"></div>
                           <label class="radio">
                             <input type="radio" name="ya" id="tidak" value="0"  checked />
                             Tidak
                           </label>  
                  </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_deposit_id" name="account_deposit_id">
            <input type="hidden" id="date_now" name="date_now">
            <input type="hidden" id="jatuh_tempo" name="jatuh_tempo">
            <input type="hidden" id="jatuh_tempo_next" name="jatuh_tempo_next">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Deposito Successful!
            </div>

            <br>
            <div class="control-group">
               <label class="control-label">No. Customer</label>
               <div class="controls">
                  <input type="text" name="no_customer" id="cif_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan</label>
               <div class="controls">
                  <input name="nama_panggilan" id="panggilan" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="nama_ibu" id="ibu_kandung" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tempat_lahir" id="tmp_lahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir</label>
               <div class="controls">
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="readonly" style="background-color:#eee;width:30px;"/> Tahun
                  <span class="help-inline"></span>
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                          <select name="product" id="product" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($product as $data): ?>
                              <option value="<?php echo $data['product_code'];?>"><?php echo $data['product_name'];?></option>
                            <?php endforeach?>
                          </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening</label>
               <div class="controls">
                  <input name="no_rekening" id="account_deposit_no" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  name="jangka_waktu" id="jangka_waktu" style="width:30px;"  maxlength="2" /> Bulan
                  <span class="help-inline"></span>
	       </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nominal<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="m-wrap mask-money"  name="nominal" id="nominal" style="width:120px;">
                       <span class="add-on">,00</span>
                    </div>
                 </div>
              </div>
            <div class="control-group">
               <label class="control-label">Nisbah Bagi Hasil Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  name="nisbah_bagihasil" style="width:30px;"  maxlength="3" /> %
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rekening Bagi Hasil <br><smal>(opsional)</small></label>
               <div class="controls">
                 <select id="rek_bagi2" name="rek_bagi_hasil" class="medium m-wrap">                     
                 </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Auto Roll Over (ARO)</label>
                  <div class="controls">
                           <label class="radio">
                             <input type="radio" name="ya" id="ya" value="1"/>
                             Ya
                           </label>
                           <div class="clearfix"></div>
                           <label class="radio">
                             <input type="radio" name="ya" id="tidak" value="0"/>
                             Tidak
                           </label>  
                  </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT REMBUG -->





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
     
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


    $("#select").click(function(){
        var no_customer = $("#result").val();
	$("#close","#dialog_rembug").trigger('click');
        $("#cif_no").val(no_customer);
        var cif_no = no_customer;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {cif_no:cif_no},
          url: site_url+"transaction/get_cfi_by_cif_no",
          success: function(response){
            // if(response.length==0){
            //    alert("CIF ini belum memiliki Rekening Tabungan!");
            // }else{

               $("#nama").val(response.nama);
               $("#branch_code").val(response.branch_code);
               $("#panggilan").val(response.panggilan);
               $("#ibu_kandung").val(response.ibu_kandung);
               $("#tmp_lahir").val(response.tmp_lahir);
               $("#tgl_lahir").val(response.tgl_lahir);
               $("#usia").val(response.usia);
               $("#alamat").val(response.alamat);

               var rt = response.rt_rw;
               var rt_ok = rt.substring(0,2);
               $("#rt").val(rt_ok);

               var rw = response.rt_rw;
               var rw_ok = rw.substring(5,3);
               $("#rw").val(rw_ok);

               $("#desa").val(response.desa);
               $("#kecamatan").val(response.kecamatan);
               $("#kabupaten").val(response.kabupaten);
               $("#kodepos").val(response.kodepos);
               $("#telpon_rumah").val(response.telpon_rumah);
               $("#telpon_seluler").val(response.telpon_seluler);
                
               $.ajax({
                   type: "POST",
                   url: site_url+"transaction/get_account_saving",
                   dataType: "json",
                   data: {cif_no:response.cif_no},
                   success: function(response){
                      html = '<option value="">-</option>';
                      for ( i = 0 ; i < response.length ; i++ )
                      {
                         html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                      }
                      $("#rek_bagi","#form_add").html(html);
                   }
                }); 

            // }
          }
        });	
  });
   $("#result option").live('dblclick',function(){
    $("#select").trigger('click');
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
               url: site_url+"cif/search_cif_no",
               data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
               dataType: "json",
               success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                 // console.log(option);
                 $("#result").html(option);
               }
             });
        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
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
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          if(cm_code=="")
          {
            $("#result").html('');
          }
        });


      $("#jangka_waktu","#form_add").change(function(){
        jangka_waktu       = $("#jangka_waktu","#form_add").val();
        tgl_sekarang       = $("#date_now","#form_add").val();
        if($(this).val()!="" && jangka_waktu!="")
        {
          // switch(periode_angsuran){
            // case "0":
            // case "1":
            // case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {jangka_waktu:jangka_waktu,tgl_sekarang:tgl_sekarang},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo_deposito",
              success: function(response){
                $("input[name='jatuh_tempo']","#form_add").val(response.jatuh_tempo);
              }
            });

            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tgl_sekarang:tgl_sekarang},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo_next_deposito",
              success: function(response){
                $("input[name='jatuh_tempo_next']","#form_add").val(response.jatuh_tempo_next);
              }
            });
            // break;
          // }
        }
        
      });

      $("#jangka_waktu","#form_edit").change(function(){
        jangka_waktu       = $("#jangka_waktu","#form_edit").val();
        tgl_sekarang       = $("#date_now","#form_edit").val();
        if($(this).val()!="" && jangka_waktu!="")
        {
          // switch(periode_angsuran){
            // case "0":
            // case "1":
            // case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {jangka_waktu:jangka_waktu,tgl_sekarang:tgl_sekarang},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo_deposito",
              success: function(response){
                $("input[name='jatuh_tempo']","#form_edit").val(response.jatuh_tempo);
              }
            });

            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tgl_sekarang:tgl_sekarang},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo_next_deposito",
              success: function(response){
                $("input[name='jatuh_tempo_next']","#form_edit").val(response.jatuh_tempo_next);
              }
            });
            // break;
          // }
        }
        
      });

      
	  $(function(){
		
			$("#product").change(function(){
				var product = $("#product").val();
					product_code = product;
				var cif_no = $("#cif_no").val();  
				$.ajax({
				  url: site_url+"transaction/cif_count_product_code",
				  type: "POST",
				  dataType: "json",
				  data: {product_code:product_code},
				  success: function(response)
				  {
					  var data = response.jumlah;
					  if(data==null)
					  {
						  var total = 0;
					  }
					  else
					  {
						  var total = data;
					  }
					  var jumlah = parseFloat(total); 
					  var no_urut = jumlah+1;
					  $("#account_deposit_no").val(cif_no+''+product_code+''+no_urut);
				  }
				})				 
				
          });
		
		});



      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'deposito_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#deposito_table .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#deposito_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
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
              no_customer: {
                  required: true
              },
              product: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              nominal: {
                  required: true
              },
	      nisbah_bagihasil: {
		  required:true
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div.control-group').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
                }else{
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(success1, -200);
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo(success1, -200);
              }
          });
        }
        else
        {
          alert('Please fill the empty field before.');
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





      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_deposit_id = $(this).attr('account_deposit_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_deposit_id:account_deposit_id},
          url: site_url+"transaction/get_deposit_by_id",
          success: function(response){
            form2.trigger('reset');
            $("#form_edit input[name='account_deposit_id']").val(response.account_deposit_id);
            $("#form_edit input[name='no_customer']").val(response.cif_no);
            $("#form_edit input[name='nama_lengkap']").val(response.nama);
            $("#form_edit input[name='nama_panggilan']").val(response.panggilan);
            $("#form_edit input[name='nama_ibu']").val(response.ibu_kandung);
            $("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
            $("#form_edit input[name='tanggal_lahir']").val(response.tgl_lahir);
            $("#form_edit input[name='usia']").val(response.usia);
            $("#form_edit input[name='no_rekening']").val(response.account_deposit_no);
            $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
            $("#form_edit input[name='date_now']").val(response.tanggal_buka);

            tgl_jtempo_last = response.tanggal_jtempo_last;
            day             = tgl_jtempo_last.substr(8,2);
            month           = tgl_jtempo_last.substr(5,2);
            year            = tgl_jtempo_last.substr(0,4);
            tgl_jtempo      = day+'-'+month+'-'+year;

            $("#form_edit input[name='jatuh_tempo']").val(tgl_jtempo);

            tgl_jtempo_next = response.tanggal_jtempo_next;
            day1            = tgl_jtempo_next.substr(8,2);
            month1          = tgl_jtempo_next.substr(5,2);
            year1           = tgl_jtempo_next.substr(0,4);
            tgl_jtempo_next = day1+'-'+month1+'-'+year1;

            $("#form_edit input[name='jatuh_tempo_next']").val(tgl_jtempo_next);

            $("#form_edit input[name='nisbah_bagihasil']").val(number_format(response.nisbah_bagihasil,0,'.',''));
            $("#form_edit input[name='nominal']").val(response.nominal);

            $.ajax({
                   type: "POST",
                   url: site_url+"transaction/get_account_saving",
                   dataType: "json",
                   async:false,
                   data: {cif_no:response.cif_no},
                   success: function(response){
                      html = '<option value="">-</option>';
                      for ( i = 0 ; i < response.length ; i++ )
                      {
                         html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                      }
                      $("#rek_bagi2","#form_edit").html(html);
                   }
                });   
            
            $("#form_edit select[name='rek_bagi_hasil']").val(response.account_saving_no);
	         
            $("#form_edit select[name='product']").val(response.product_code);
            var aro = response.automatic_roll_over;
                      if(aro=='1'){
                        $("input[name='ya'][value='1']").attr('checked');
                        $("input[name='ya'][value='1']").closest('span').addClass('checked');
                        $("input[name='ya'][value='0']").closest('span').removeClass('checked');
                      }
                      else
                      {
                        $("input[name='ya'][value='0']").attr('checked');
                        $("input[name='ya'][value='0']").closest('span').addClass('checked');
                        $("input[name='ya'][value='1']").closest('span').removeClass('checked');
                      }
			
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              no_customer: {
                  required: true
              },
              product: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              nominal: {
                  required: true
              },
	      nisbah_bagihasil: {
		  required:true
	      }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
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
              url: site_url+"transaction/edit_deposit",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#deposito_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');

                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo(success1, -200);
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo(success1, -200);
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      $("#btn_delete").click(function(){

        var account_deposit_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_deposit_id[$i] = $(this).val();

          $i++;

        });

        if(account_deposit_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_deposit",
              dataType: "json",
              data: {account_deposit_id:account_deposit_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      // begin first table
      $('#deposito_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_deposito_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
              "sLengthMenu": "_MENU_ records per page",
              "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
              }
          },
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0]
              }
          ]
      });

      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
