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
			Re-Schedulling<small> Pengaturan Re-Schedulling Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Re-Schedulling</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Re-Schedulling Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
            <input type="hidden" id="product_code_o" name="product_code_o">
            <input type="hidden" id="cif_no_o" name="cif_no_o">
            <input type="hidden" id="branch_code_o" name="branch_code_o">
            <input type="hidden" id="jangka_waktu_o" name="jangka_waktu_o">
            <input type="hidden" id="periode_jangka_waktu_o" name="periode_jangka_waktu_o">
            <input type="hidden" id="pokok_o" name="pokok_o">
            <input type="hidden" id="margin_o" name="margin_o">
            <input type="hidden" id="angsuran_pokok_o" name="angsuran_pokok_o">
            <input type="hidden" id="angsuran_margin_o" name="angsuran_margin_o">
            <input type="hidden" id="angsuran_catab_o" name="angsuran_catab_o">
            <input type="hidden" id="saldo_pokok_o" name="saldo_pokok_o">
            <input type="hidden" id="saldo_margin_o" name="saldo_margin_o">
            <input type="hidden" id="saldo_catab_o" name="saldo_catab_o">
            <input type="hidden" id="tanggal_akad_o" name="tanggal_akad_o">
            <input type="hidden" id="tanggal_mulai_angsur_o" name="tanggal_mulai_angsur_o">
            <input type="hidden" id="tanggal_jtempo_o" name="tanggal_jtempo_o">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Re-Schedulling Pembiayaan Berhasil Diproses !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No. Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
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
                  <!-- <h4>Masukan Kata Kunci</h4>
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                  <option value="">Pilih Tipe CIF</option>
                  <option value="">All</option>
                  <option value="1">Individu</option>
                  <option value="0">Kelompok</option>
                  </select></p>                    
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->
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
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      
		  
               </div>
            </div>
            <?php foreach ($grace as $data):?>
            <input type="hidden" id="grace_kelompok" name="grace_kelompok" value="<?php echo $data['grace_period_kelompok'];?>">
            <?php endforeach?>
            <div class="control-group">
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_panggilan" id="panggilan" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_ibu" id="ibu_kandung" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tempat_lahir" id="tmp_lahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" style="background-color:#eee;width:30px;" /> Tahun
                  <span class="help-inline"></span>&nbsp;
               </div>
            </div>
            <p><!-- 
            <div class="control-group">
               <label class="control-label">Status Dana<span class="required">*</span></label>
                  <div class="controls">
                     <label class="radio">
                       <input type="radio" name="status_dana" id="executing" value="0"/>
                       Executing
                     </label>
                     <div class="clearfix"></div>
                     <label class="radio">
                       <input type="radio" name="status_dana" id="chaneling" value="1"  checked />
                       Chaneling
                     </label>  
                  </div>
            </div> -->
            <div class="control-group">
               <label class="control-label">Saldo Hutang Pokok<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" name="saldo_hutang_pokok" id="saldo_hutang_pokok">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin" id="margin">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Catab<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="catab" id="catab">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Sumber Dana<span class="required">*</span></label>
              <div class="controls">
                 <select id="sumber_dana_pembiayaan" name="sumber_dana_pembiayaan" class="medium m-wrap" data-required="1">                     
                   <option value="">PILIH</option>
                   <option value="0">Sendiri</option>
                   <option value="1">Kreditur</option>
                   <option value="2">Campuran</option>
                 </select>
              </div>
            </div>    
              <div id="sendiri2">
              <div class="control-group">
                 <label class="control-label">Dana Sendiri</label>
                 <div class="controls">
                     <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri" id="dana_sendiri">
                       <span class="add-on">,00</span>
                     </div>
                   </div>
              </div>  
            </div> 
              <div id="sendiri_campuran2">
              <div class="control-group">
                 <label class="control-label">Dana Sendiri</label>
                 <div class="controls">
                     <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri" id="dana_sendiri_campuran">
                       <span class="add-on">,00</span>
                     </div>
                   </div>
              </div>  
            </div>
            <div id="kreditur2">
              <div class="control-group">
                 <label class="control-label">Dana Kreditur</label>
                 <div class="controls">
                     <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur">
                       <span class="add-on">,00</span>
                     </div>
                   </div>
              </div> 
              <div class="control-group">
                 <label class="control-label">Ujroh Kreditur</label>
                 <div class="controls">
                  <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> % Keuntungan
                  &nbsp;
                  <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> / Angsuran
                  <span class="help-inline"></span></div>
              </div>    
              <div class="control-group">
                 <label class="control-label">Pembayaran Kreditur</label>
                 <div class="controls">
                    <select id="pembayaran_kreditur" name="pembayaran_kreditur" class="medium m-wrap">                     
                      <option value="">PILIH</option>                     
                      <option value="0">Sesuai Angsuran</option>                     
                      <option value="1">Sekaligus</option>
                    </select>
                 </div>
              </div>    
            </div>    
           <div class="control-group">
              <label class="control-label">Jangka Waktu Angsuran</label>
              <div class="controls">
               &nbsp;
               <input type="text" value="0" class=" m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="2" style="width:30px;"/>
               <span class="help-inline"></span>
               &nbsp;
                 <select id="periode_angsuran" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                   <option value="">PILIH</option>                    
                   <option value="0">Harian</option>                    
                   <option value="1">Mingguan</option>                    
                   <option value="2">Bulanan</option>                    
                   <option value="3">Jatuh Tempo</option>
                 </select>
              </div>
           </div>           
           <div class="control-group">
              <label class="control-label">Pokok</label>
              <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                    <input type="text" class="m-wrap mask-money" style="width:120px;" name="nilai_pembiayaan" id="nilai_pembiayaan">
                    <span class="add-on">,00</span>
                  </div>
                </div>
           </div>        
           <div class="control-group">
              <label class="control-label">Margin</label>
              <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                    <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan">
                    <span class="add-on">,00</span>
                </div>
              </div>
           </div>           
           <div class="control-group">
              <label class="control-label">Total</label>
              <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                    <input type="text" class="m-wrap mask-money" style="width:120px;" style="background-color:#eee;width:30px;" readonly="" value="0" name="total" id="total">
                    <span class="add-on">,00</span>
                </div>
              </div>
           </div>           
           <div class="control-group">
              <label class="control-label">Pembaharuan Ke</label>
              <div class="controls">
                    <input type="text" class="m-wrap" value="0" style="width:20px;" name="pembaharuan_ke" id="pembaharuan_ke" maxlength="2">
              </div>
           </div>         
           <div class="control-group">
              <label class="control-label">Pembaharuan</label>
              <div class="controls">
                    <input type="text" class="m-wrap mask_date" style="width:120px;" placeholder="dd/mm/yyyy" name="tgl_pembaharuan" id="tgl_pembaharuan" maxlength="12">
              </div>
           </div>            
           <div class="control-group">
              <label class="control-label">Angsur</label>
              <div class="controls">
                    <input type="text" class="m-wrap mask_date" style="width:120px;" placeholder="dd/mm/yyyy" name="tgl_angsur" id="tgl_angsur" maxlength="12">
              </div>
           </div>            
           <div class="control-group">
              <label class="control-label">Jatuh Tempo</label>
              <div class="controls">
                    <input type="text" class="m-wrap mask_date" style="width:120px;" placeholder="dd/mm/yyyy" name="tgl_jtempo" id="tgl_jtempo" maxlength="12">
                   <!--  <p><p>      
                    <button type="submit" class="btn green">Cek Kartu Angsuran</button> -->
              </div>
           </div>  <!--  
           <div class="control-group">
              <label class="control-label">Petugas</label>
              <div class="controls">
                    <input type="text" class="m-wrap" style="width:120px;" name="petugas" id="petugas" maxlength="12">
              </div>
           </div>    --><!--    
           <div class="control-group">
              <label class="control-label">No. Pembaharuan</label>
              <div class="controls">
                    <input type="text" class="m-wrap" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan2" maxlength="12">
              </div>
           </div>      -->               
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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
     
      $(".mask_date").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

   $("#sendiri2").hide();
   $("#sendiri_campuran2").hide();
   $("#kreditur2").hide();

   //Event Total 
   $("#nilai_pembiayaan","#form_add").live('keyup',function(){
    /*var nilai_pembiayaan      = 0;
    var margin_pembiayaan     = 0;*/
    $("#nilai_pembiayaan","#form_add").each(function(){
    var nilai_pembiayaan = parseFloat(convert_numeric($(this).val()));  
    // console.log(margin_pembiayaan);
    var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val()));  
    // console.log(jangka_waktu);
    var total = nilai_pembiayaan+margin_pembiayaan;
    $("#total").val(number_format(total,0,',','.'));
    })
    });

   //Event Total 
   $("#margin_pembiayaan","#form_add").live('keyup',function(){
   /* var nilai_pembiayaan      = 0;
    var margin_pembiayaan     = 0;*/
    $("#margin_pembiayaan","#form_add").each(function(){
    var margin_pembiayaan = parseFloat(convert_numeric($(this).val()));  
    // console.log(margin_pembiayaan);
    var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));  
    // console.log(jangka_waktu);
    var total = nilai_pembiayaan+margin_pembiayaan;
    $("#total").val(number_format(total,0,',','.'));
    })
    });

   //Event ketika Pokok di ubah
   $("#margin").change(function(){
    var margin = parseFloat($(this).val());  
    // console.log(margin_pembiayaan);
    var jangka_waktu = parseFloat($("#jangka_waktu").val());  
    // console.log(jangka_waktu);
    var periode_angsuran =$("#periode_angsuran").val();  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {margin:margin,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_margin_reschedull",
              success: function(response){
                $("input[name='margin_pembiayaan']","#form_add").val(number_format(response.total_margin,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });

   //Event ketika Pokok di ubah
   $("#dana_sendiri").change(function(){
    var pokok = parseFloat($(this).val());  
    // console.log(margin_pembiayaan);
    var jangka_waktu = parseFloat($("#jangka_waktu").val());  
    // console.log(jangka_waktu);
    var periode_angsuran =$("#periode_angsuran").val();  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {pokok:pokok,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_pokok_reschedull",
              success: function(response){
                $("input[name='nilai_pembiayaan']","#form_add").val(number_format(response.total_pokok,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });

   //Event ketika Pokok di ubah
   $("#dana_sendiri_campuran").change(function(){
    var pokok = parseFloat($(this).val());  
    // console.log(margin_pembiayaan);
    var jangka_waktu = parseFloat($("#jangka_waktu").val());  
    // console.log(jangka_waktu);
    var periode_angsuran =$("#periode_angsuran").val();  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {pokok:pokok,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_pokok_reschedull",
              success: function(response){
                $("input[name='nilai_pembiayaan']","#form_add").val(number_format(response.total_pokok,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });

  //Event ketika Periode Angsuran di ubah
   $("#periode_angsuran").change(function(){
    var periode_angsuran = $(this).val();  
    // console.log(margin_pembiayaan);
    var jangka_waktu = parseFloat($("#jangka_waktu").val());  
    // console.log(jangka_waktu);
    var pokok = parseFloat($("#dana_sendiri").val());  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {pokok:pokok,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_pokok_reschedull",
              success: function(response){
                $("input[name='nilai_pembiayaan']","#form_add").val(number_format(response.total_pokok,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat(convert_numeric($("input[name='nilai_pembiayaan']","#form_add").val()));
       var margin = parseFloat(convert_numeric($("input[name='margin_pembiayaan']","#form_add").val()));
       var total  = pokok+margin;
       $("#total").val(total);
   });


  //Event ketika Pokok di ubah
   $("#periode_angsuran").change(function(){
    var periode_angsuran = $(this).val();  
    // console.log(margin_pembiayaan);
    var jangka_waktu = parseFloat($("#jangka_waktu").val());  
    // console.log(jangka_waktu);
    var margin = parseFloat($("#margin").val());  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {margin:margin,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_margin_reschedull",
              success: function(response){
                $("input[name='margin_pembiayaan']","#form_add").val(number_format(response.total_margin,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });

  //Event ketika jangka_waktu di ubah
   $("#jangka_waktu").change(function(){
    var jangka_waktu = parseFloat($(this).val());  
    // console.log(margin_pembiayaan);
    var periode_angsuran = $("#periode_angsuran").val();  
    // console.log(jangka_waktu);
    var margin = parseFloat($("#margin").val());  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {margin:margin,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_margin_reschedull",
              success: function(response){
                $("input[name='margin_pembiayaan']","#form_add").val(number_format(response.total_margin,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });

//Event ketika jangka_waktu di ubah
   $("#jangka_waktu").change(function(){
    var jangka_waktu = parseFloat($(this).val());  
    // console.log(margin_pembiayaan);
    var periode_angsuran = $("#periode_angsuran").val();  
    // console.log(jangka_waktu);
    var pokok = parseFloat($("#dana_sendiri").val());  
    // console.log(periode pembiayaan);

    if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async: false,
              data: {pokok:pokok,jangka_waktu:jangka_waktu,periode_angsuran:periode_angsuran},
              url: site_url+"/rekening_nasabah/ajax_get_pokok_reschedull",
              success: function(response){
                $("input[name='nilai_pembiayaan']","#form_add").val(number_format(response.total_pokok,0,'.',''));
              }
            });
            break;
          }
        }

       var pokok  = parseFloat($("input[name='nilai_pembiayaan']","#form_add").val());
       var margin = parseFloat($("input[name='margin_pembiayaan']","#form_add").val());
       var total  = pokok+margin;
       $("#total").val(total);
   });
  
    //Event ketika tanggal pembaharuan di change
    $("input[name='tgl_pembaharuan']","#form_add").change(function(){
        tgl_akad = $(this).val().replace(/\//g,'');
        day = tgl_akad.substr(0,2);
        month = tgl_akad.substr(2,2);
        year = tgl_akad.substr(4,4);
        tgl_akad = year+'-'+month+'-'+day;

        grace_kelompok = $("#grace_kelompok","#form_add").val();
        grace_kelompok_hari = grace_kelompok.substring(0,1);
        grace_kelompok_minggu = grace_kelompok.substring(2,1);
        grace_kelompok_bulan = grace_kelompok.substring(3,2);
        periode_angsuran = $("#periode_angsuran","#form_add").val();
        jangka_waktu = $("#jangka_waktu","#form_add").val();
        if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              async:false,
              // data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,tgl_akad:tgl_akad,grace_kelompok:grace_kelompok},
              data: {periode_angsuran:periode_angsuran,tgl_akad:tgl_akad,grace_kelompok_hari:grace_kelompok_hari,grace_kelompok_minggu:grace_kelompok_minggu,grace_kelompok_bulan:grace_kelompok_bulan},
              url: site_url+"/cif/ajax_get_tanggal_angsur_pertama",
              success: function(response){
                $("input[name='tgl_angsur']","#form_add").val(response.angsuranke1);
              }
            });

            angsuranpertama = $("input[name='tgl_angsur']","#form_add").val().replace(/\//g,'');
            day1 = angsuranpertama.substr(0,2);
            month1 = angsuranpertama.substr(2,2);
            year1 = angsuranpertama.substr(4,4);
            angsuranpertama = year1+'-'+month1+'-'+day1;

            $.ajax({
              type: "POST",
              dataType: "json",
              async:false,
              data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranpertama:angsuranpertama},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo2",
              success: function(response){
                $("input[name='tgl_jtempo']","#form_add").val(response.jatuh_tempo);
              }
            });
            break;
          }
        }
      });

      $("#periode_angsuran","#form_add").change(function(){
        $("input[name='tgl_pembaharuan']").trigger('change');
      });

    $("#select").click(function(){
        var no_pembiayaan = $("#result").val();
	      $("#close","#dialog_rembug").trigger('click');
        $("#no_rekening").val(no_pembiayaan);
        var account_financing_no = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"rekening_nasabah/get_cif_for_rechedulling",
          success: function(response){

               $("#form_add input[name='account_financing_id']").val(response.account_financing_id);
               $("#nama").val(response.nama);
               $("#product_code_o").val(response.product_code);
               $("#cif_no_o").val(response.cif_no);
               $("#branch_code_o").val(response.branch_code);
               $("#product_code_o").val(response.product_code);
               $("#panggilan").val(response.panggilan);
               $("#ibu_kandung").val(response.ibu_kandung);
               $("#tmp_lahir").val(response.tmp_lahir);
               $("#tgl_lahir").val(response.tgl_lahir);
               $("#usia").val(response.usia);
               $("#saldo_hutang_pokok").val(number_format(response.saldo_pokok),0,',','.');
               $("#pokok_o").val(response.saldo_pokok);
               $("#saldo_pokok_o").val(response.saldo_pokok);
               $("#margin").val(response.saldo_margin);
               $("#margin_o").val(response.saldo_margin);
               $("#saldo_margin_o").val(response.saldo_margin);
               $("#catab").val(response.saldo_catab);
               $("#angsuran_catab_o").val(response.saldo_catab);
               $("#saldo_catab_o").val(response.saldo_catab);
               $("#form_add select[name='periode_angsuran']").val(response.periode_jangka_waktu);
               $("#periode_jangka_waktu_o").val(response.periode_jangka_waktu);
               $("#form_add input[name='jangka_waktu']").val(response.jangka_waktu);
               $("#form_add input[name='jangka_waktu_o']").val(response.jangka_waktu);
               $("#form_add select[name='sumber_dana_pembiayaan']").val(response.sumber_dana);
               $("#dana_kreditur").val(response.dana_kreditur);
               $("#keuntungan").val(response.ujroh_kreditur_persen);
               $("#angsuran").val(response.ujroh_kreditur);
               $("#pembayaran_kreditur").val(response.ujroh_kreditur_carabayar);
               $("#nilai_pembiayaan").val(response.pokok);
               $("#angsuran_pokok_o").val(response.pokok);
               $("#margin_pembiayaan").val(response.margin);
               $("#angsuran_margin_o").val(response.margin);
               var pokok  = parseFloat(convert_numeric(response.pokok));
               var margin = parseFloat(convert_numeric(response.margin));
               var total  = pokok+margin;
               $("#total").val(total);

               $("#tgl_pembaharuan").val(response.current_date);

               var tanggal_mulai_angsur = response.tanggal_mulai_angsur;
               if(tanggal_mulai_angsur==undefined)
               {
                 tanggal_mulai_angsur='';
               }
               var tgl_angsur = tanggal_mulai_angsur.substring(8,10);
               var bln_angsur = tanggal_mulai_angsur.substring(5,7);
               var thn_angsur = tanggal_mulai_angsur.substring(0,4);
               var tgl_akhir_angsur = tgl_angsur+"/"+bln_angsur+"/"+thn_angsur;  
               $("#tgl_angsur").val(tgl_akhir_angsur);
               $("#tanggal_mulai_angsur_o").val(tgl_akhir_angsur);

               var tanggal_akad = response.tanggal_akad;
               if(tanggal_akad==undefined)
               {
                 tanggal_akad='';
               }
               var tgl_akad = tanggal_akad.substring(8,10);
               var bln_akad = tanggal_akad.substring(5,7);
               var thn_akad = tanggal_akad.substring(0,4);
               var tgl_akhir_akad = tgl_akad+"/"+bln_akad+"/"+thn_akad;  
               $("#tanggal_akad_o").val(tgl_akhir_akad);

               var tanggal_jtempo = response.tanggal_jtempo;
               if(tanggal_jtempo==undefined)
               {
                 tanggal_jtempo='';
               }
               var tgl_jtempo = tanggal_jtempo.substring(8,10);
               var bln_jtempo = tanggal_jtempo.substring(5,7);
               var thn_jtempo = tanggal_jtempo.substring(0,4);
               var tgl_akhir_jtempo = tgl_jtempo+"/"+bln_jtempo+"/"+thn_jtempo; 
               $("#tgl_jtempo").val(tgl_akhir_jtempo);
               $("#tanggal_jtempo_o").val(tgl_akhir_jtempo);

               //fungsi untuk menyembunyikan input sumber dana pembiayaan jika value=1
               var sumber_dana_pembiayaan = response.sumber_dana;  

               if(sumber_dana_pembiayaan=='0')
               {
                 $("#dana_sendiri").val(number_format(response.saldo_pokok),0,',','.');
                 $("#sendiri2").show();
                 $("#sendiri_campuran2").hide();
                 $("#kreditur2").hide();
               }
               else if (sumber_dana_pembiayaan=='1') 
               {
                 $("#kreditur2").show();
                 $("#sendiri2").hide();
                 $("#sendiri_campuran2").hide();
               }
               else if (sumber_dana_pembiayaan=='2') 
               {
                 $("#dana_sendiri").val(number_format(response.saldo_pokok),0,',','.');
                 $("#dana_sendiri_campuran").val(number_format(response.saldo_pokok),0,',','.');
                 $("#sendiri2").hide();
                 $("#sendiri_campuran2").show();
                 $("#kreditur2").show();
               }
               else
               {
                 $("#sendiri2").hide();
                 $("#sendiri_campuran2").hide();
                 $("#kreditur2").hide();
               }
          }
        });	

      //Event Sumber dana pembiayaan ketika di change
        $("#sumber_dana_pembiayaan","#form_add").change(function(){
          var sumber_dana_pembiayaan = $("#sumber_dana_pembiayaan","#form_add").val();
          if(sumber_dana_pembiayaan=='0')
           {
             $("#sendiri2").show();
             $("#sendiri_campuran2").hide();
             $("#kreditur2").hide();
           }
           else if (sumber_dana_pembiayaan=='1') 
           {
             $("#kreditur2").show();
             $("#sendiri2").hide();
             $("#sendiri_campuran2").hide();
           }
           else if (sumber_dana_pembiayaan=='2') 
           {
             $("#sendiri2").hide();
             $("#sendiri_campuran2").show();
             $("#kreditur2").show();
           }
           else
           {
             $("#sendiri2").hide();
             $("#sendiri_campuran2").hide();
             $("#kreditur2").hide();
           }
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
            url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
            data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
            dataType: "json",
            success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
                  }
                }
              // console.log(option);
              $("#result").html(option);
            }
          });
        })

        $("#keyword").keypress(function(e){
          if(e.keyCode==13){
            cm_code = $("select#cm").val();
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });

        $("select#cm").change,(function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
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
      
	  $(function(){

       $("#jangka_waktu","#form_add").change(function(){ 
        jangka_waktu = parseFloat($(this).val());  
        angsuranpertama = $("input[name='angsuranke1']","#form_add").val().replace(/\//g,'');
        day1 = angsuranpertama.substr(0,2);
        month1 = angsuranpertama.substr(2,2);
        year1 = angsuranpertama.substr(4,4);
        angsuranpertama = year1+'-'+month1+'-'+day1;

            $.ajax({
              type: "POST",
              dataType: "json",
              async:false,
              data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranpertama:angsuranpertama},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo2",
              success: function(response){
                $("input[name='tgl_jtempo']","#form_add").val(response.jatuh_tempo);
              }
            });

      })
		
		});



      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelunasan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pelunasan_pembiayaan_table .checkboxes").livequery(function(){
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
          
          rules: {
              no_rekening: {
                  required: true
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

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/proses_reschedulling",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.find('.control-group').removeClass('success');
                }else{
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(form1, -200);
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo(form1, -200);
              }
            });

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


      // begin first table
      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pelunasan_pembiayaan_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 5,
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

      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
