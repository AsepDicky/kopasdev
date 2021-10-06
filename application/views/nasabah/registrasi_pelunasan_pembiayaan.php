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
			Pelunasan Pembiayaan<small> Pengaturan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Pembiayaan Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Pelunasan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('rekening_nasabah/proses_reg_pelunasan_pembayaran'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
            <input type="hidden" id="account_financing_schedulle_id" name="account_financing_schedulle_id">
            <input type="hidden" id="tanggal_jtempo" name="tanggal_jtempo">
            <input type="hidden" id="periode_jangka_waktu" name="periode_jangka_waktu">
            <input type="hidden" id="angsuran_pokok" name="angsuran_pokok">
            <input type="hidden" id="angsuran_margin" name="angsuran_margin">
            <input type="hidden" id="angsuran_catab" name="angsuran_catab">
            <input type="hidden" id="counter_angsuran" name="counter_angsuran">
            <input type="hidden" id="jtempo_angsuran_last" name="jtempo_angsuran_last">
            <input type="hidden" id="jtempo_angsuran_next" name="jtempo_angsuran_next">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Registrasi Pelunasan Pembiayaan Berhasil Diproses !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
                     <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                     <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
                  </div>
            </div>

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
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" class="m-wrap" readonly="" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" style="background-color:#eee;width:30px;" /> Tahun
                  <span class="help-inline"></span>&nbsp;
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="produk" id="produk" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Akad<span class="required">*</span></label>
               <div class="controls">
                  <input name="akad" id="akad" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input name="pokok_pembiayaan" id="pokok_pembiayaan" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  Nisbah Bagi Hasil
                  &nbsp;
                  <span class="help-inline"></span>
                   <input name="nisbah_bagihasil" id="nisbah_bagihasil" data-required="1" style="background-color:#eee;width:50px;" type="text" class="m-wrap" readonly="readonly"/> %
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" id="jangka_waktu" name="jangka_waktu" readonly=""  style="background-color:#eee;width:30px;"  maxlength="3" /> 
                  <span id="txt_periode_jangka_waktu"></span>
                  <span class="help-inline"></span>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_jtempo" id="input-mask" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                     <input name="saldo_pokok" id="saldo_pokok" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                </div>  
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_margin" id="saldo_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                     <input name="v_angsuran_pokok" id="v_angsuran_pokok" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                </div>  
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="v_angsuran_margin" id="v_angsuran_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Angsuran<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="v_jumlah_angsuran" id="v_jumlah_angsuran" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Catab<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_tabungan" id="saldo_tabungan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Potongan Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="potongan_margin" id="potongan_margin" data-required="1" type="text" class="m-wrap mask-money" style="width:120px;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Pembayaran<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="total_pembayaran" id="total_pembayaran" data-required="1" type="text" readonly="" class="mask-money m-wrap" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Pembayaran Melalui<span class="required">*</span></label>
               <div class="controls">
                  <select id="jenis_pembayaran" name="jenis_pembayaran" class="m-wrap">
                     <option value="">Silahkan Pilih</option>
                     <option value="1">Catab</option>
                     <option value="2">Rekening Tabungan</option>
                  </select>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Debet Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input name="debet_rekening" id="debet_rekening" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Saldo Rekening<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                   <input name="saldo_rekening" id="saldo_rekening" data-required="1" type="text" class="mask-money m-wrap" readonly="" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kas/Bank<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium chosen" id="account_cash_code" name="account_cash_code">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas): ?>
                    <option value="<?php echo $kas['account_code'] ?>"><?php echo $kas['account_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <input placeholder="dd/mm/yyyy" name="trx_date" id="trx_date" data-required="1" type="text" class="small m-wrap mask_date date-picker"/>
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
      $(".mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


    $("#select").click(function(){
        var no_pembiayaan = $("#result").val();
	     $("#close","#dialog_rembug").trigger('click');
        $("#no_pembiayaan").val(no_pembiayaan);
        var account_financing_no = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"rekening_nasabah/get_cif_by_account_financing_no",
          success: function(response){
            // if(response.length==0){
            //    alert("CIF ini belum memiliki Rekening Tabungan!");
            // }else{

               $("#form_add input[name='account_financing_id']").val(response.account_financing_id);
               $("#form_add input[name='account_financing_schedulle_id']").val(response.account_financing_schedulle_id);
               $("#form_add input[name='periode_jangka_waktu']").val(response.periode_jangka_waktu);
               $("#form_add input[name='jtempo_angsuran_last']").val(response.jtempo_angsuran_last);
               $("#form_add input[name='jtempo_angsuran_next']").val(response.jtempo_angsuran_next);
               $("#nama").val(response.nama);
               $("#panggilan").val(response.panggilan);
               $("#ibu_kandung").val(response.ibu_kandung);
               $("#tmp_lahir").val(response.tmp_lahir);
               $("#tgl_lahir").val(response.tgl_lahir);
               $("#usia").val(response.usia);
               $("#produk").val(response.product_name);
               $("#akad").val(response.akad_name);
               $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
               $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
               $("#jangka_waktu").val(response.jangka_waktu);
               $("#nisbah_bagihasil").val(response.nisbah_bagihasil);
               $("#form_add input[name='tanggal_jtempo']").val(response.tanggal_jtempo);
               $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
               $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
               $("#saldo_tabungan").val(number_format(response.saldo_catab,0,',','.'));
               $("#v_angsuran_pokok").val(number_format(response.angsuran_pokok,0,',','.'));
               $("#v_angsuran_margin").val(number_format(response.angsuran_margin,0,',','.'));
               $("#v_jumlah_angsuran").val(number_format(response.jumlah_angsuran,0,',','.'));
               $("#debet_rekening").val(response.account_saving_no);
               $("#angsuran_pokok").val(response.angsuran_pokok);
               $("#angsuran_margin").val(response.angsuran_margin);
               $("#angsuran_catab").val(response.angsuran_catab);
               $("#counter_angsuran").val(response.counter_angsuran);
               $("#jenis_pembayaran").val('');
               $("#saldo_rekening").val('0');
               $("#potongan_margin").val('0');
               total_pembayaran = parseFloat(response.saldo_pokok)+parseFloat(response.saldo_margin)+parseFloat(response.saldo_catab);
               $("#total_pembayaran").val(number_format(total_pembayaran,0,',','.'));
               txt_periode_jangka_waktu=response.periode_jangka_waktu;
               switch(txt_periode_jangka_waktu) {
                case "0": //harian
                txt_periode_jangka_waktu='Harian';
                break;
                case "1": //mingguan
                txt_periode_jangka_waktu='Mingguan';
                break;
                case "2": //bulanan
                txt_periode_jangka_waktu='Bulanan';
                break;
                case "3": //tanggal jtempo
                txt_periode_jangka_waktu='Jatuh Tempo';
                break;
               }
               $('#txt_periode_jangka_waktu').text(txt_periode_jangka_waktu)
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
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$("#keyword").val(),cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+number_format(response[i].besar_angsuran,0,',','.')+'</option>';
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
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$(this).val(),cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+number_format(response[i].besar_angsuran,0,',','.')+'</option>';
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
            return false;
          }
        });
        
        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$("#keyword").val(),cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+number_format(response[i].besar_angsuran,0,',','.')+'</option>';
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
      
       $("#potongan_margin","#form_add").keyup(function(){
         var margin = parseFloat(convert_numeric($(this).val()));  
         var saldo_pokok = parseFloat(convert_numeric($("#saldo_pokok","#form_add").val()));  
         var saldo_margin = parseFloat(convert_numeric($("#saldo_margin","#form_add").val()));  
         var total_pembayaran = saldo_pokok+saldo_margin-margin;
         $("#total_pembayaran","#form_add").val(number_format(total_pembayaran,0,',','.'));
         $("#total_pembayaran","#form_add").attr("readonly",true);
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
              no_pembiayaan: {
                  required: true
              },
              potongan_margin: {
                  required: true
              },
              jenis_pembayaran: {
                  required: true
              },
              trx_date: {
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

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        var saldo_rekening = parseFloat(convert_numeric($("#saldo_rekening").val()));
        var total_pembayaran = parseFloat(convert_numeric($("#total_pembayaran").val()));

        var account_cash_code = $('#account_cash_code').val();

        if($(this).valid()==true)
        {

          if ( account_cash_code == "" ) {
            alert("Pilih Kas/Bank!");
          } else {
          // if ( total_pembayaran <= saldo_rekening ) 
          // {
              form1.ajaxForm({
                // data: form1.serialize(),
                dataType: "json",
                success: function(response) {
                  if(response.success==true){
                    success1.show();
                    error1.hide();
                    form1.trigger('reset');
                    form1.children('div.control-group').removeClass('success');
                    $('#account_cash_code').val('').trigger('liszt:updated')
                  }else{
                    success1.hide();
                    error1.show();
                  }
                  App.scrollTo($('body'), 0);
                },
                error:function(){
                    success1.hide();
                    error1.show();
                    App.scrollTo($('body'), 0);
                }
              });
          }
          // else
          // {
            // alert("Saldo Rekening tidak mencukupi untuk membayar Angsuran Pelunasan!");
            // e.preventDefault();
          // }
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


      $("#jenis_pembayaran").change(function(){
        var val = $(this).val();
        var account_financing_no = $("#no_pembiayaan").val();
        if (val=='1'){
          $.ajax({
            type:"POST",dataType:"json",data:{
              account_financing_no:account_financing_no
            },url:site_url+"rekening_nasabah/get_saldo_catab_by_account_financing_no",
            success:function(response){
              $("#saldo_rekening").val(number_format(response.saldo_catab,0,',','.'));
            }
          })
        }else if(val=='2'){
          $.ajax({
            type:"POST",dataType:"json",data:{
              account_financing_no:account_financing_no
            },url:site_url+"rekening_nasabah/get_saldo_memo_by_account_financing_no",
            success:function(response){
              $("#saldo_rekening").val(number_format(response.saldo_memo,0,',','.'));
            }
          })
        }else{
          $("#saldo_rekening").val('');
        }
      })
});
</script>

<!-- END JAVASCRIPTS -->
