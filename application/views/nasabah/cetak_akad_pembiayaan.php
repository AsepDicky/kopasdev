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
			Cetak Akad<small> Cetak Akad Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Cetak Akad</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Cetak Akad Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
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
                        <p style="display:none"><select name="cif_type" id="cif_type" class="span12 m-wrap">
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
                  <!-- Nisbah Bagi Hasil -->
                  &nbsp;
                  <span class="help-inline hide"></span>
                   <input name="nisbah_bagihasil" id="nisbah_bagihasil" data-required="1" style="background-color:#eee;width:50px;display:none;" type="text" class="m-wrap" readonly="readonly"/>
                </div>
            </div>
            <div class="control-group" style="display:none;">
               <label class="control-label">Nisbah Nasabah<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-append">
                   <input type="text" class="m-wrap" name="nisbah" id="nisbah" value="0" style="width:50px;background:#eee;" maxlength="6" readonly="">
                   <span class="add-on">%</span>
                 </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" id="jangka_waktu" name="jangka_waktu" readonly=""  style="background-color:#eee;width:30px;"  maxlength="2" /> Bulan
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Menggunakan Wakalah?<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" id="menggunakan_wakalah" name="menggunakan_wakalah" readonly=""  style="background-color:#eee;width:60px;"/>
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Status Anggota<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" id="status_anggota" name="status_anggota">
                    <option>ANGGOTA</option>
                    <option>CALON ANGGOTA</option>
                  </select>
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Menyetujui<!-- <span class="required">*</span> --></label>
               <div class="controls">
                  <input type="text" class="medium m-wrap" id="menyetujui" name="menyetujui" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saksi 1<!-- <span class="required">*</span> --></label>
               <div class="controls">
                  <!-- <input type="text" class="medium m-wrap" id="saksi1" name="saksi1" />
                  <span class="help-inline"></span> -->
                  <select class="medium m-wrap" id="saksi1" name="saksi2">
                    <option value="">SILAHKAN PILIH SAKSI</option>
                    <?php foreach($saksi1 as $saksi): ?>
                    <option><?php echo $saksi['display_text'] ?></option>
                    <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Pasangan<!-- <span class="required">*</span> --></label>
               <div class="controls">
                  <input type="text" class="medium m-wrap" id="nama_pasangan" name="nama_pasangan" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status Pasangan<!-- <span class="required">*</span> --></label>
               <div class="controls">
                  <input type="text" class="medium m-wrap" id="status_pasangan" name="status_pasangan" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="form-actions">
               <button type="button" class="btn green" id="cetak_pdf"><i class="icon-print"></i> Cetak</button>
               <button type="button" class="btn blue" id="cetak_wakalah" style="display:none;">Cetak Akad & Wakalah</button>
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
               $("#nama").val(response.nama);
               $("#produk").val(response.product_name);
               $("#akad").val(response.akad_name);
               $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
               $("#jangka_waktu").val(response.jangka_waktu);
               $("#nisbah_bagihasil").val(response.nisbah_bagihasil);
               jenis_keuntungan = response.jenis_keuntungan;
               if (jenis_keuntungan=='2') {
                 $("#nisbah").val(response.nisbah_bagihasil).closest('.control-group').show();
                 $("#margin_pembiayaan").val(number_format(response.margin,0,',','.')).closest('.control-group').hide();
               } else {
                 $("#nisbah").val(response.nisbah_bagihasil).closest('.control-group').hide();
                 $("#margin_pembiayaan").val(number_format(response.margin,0,',','.')).closest('.control-group').show();
               }

               $("#status_anggota").val(response.status_anggota);
               $("#menyetujui").val(response.menyetujui);
               $("#saksi1").val(response.saksi1);
               // $("#saksi2").val(response.saksi2);
               if (response.flag_wakalah==0) {
                var wakalah='Tidak';
                // $("#cetak_wakalah").hide();
               } else{
                var wakalah='Ya';
                // $("#cetak_wakalah").show();
               };
               $("#menggunakan_wakalah").val(wakalah);
               $("#nama_pasangan").val(response.nama_pasangan);
               $("#status_pasangan").val(response.status_pasangan);
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
              data: {keyword:$("#keyword").val(),cif_type:type},
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
              data: {keyword:$(this).val(),cif_type:type},
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
            return false;
          }
        });
        
        $("select#cm").on('change',function(e){
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
		
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'cetak_akad_pembiayaan_table';
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
        window.location.href=site_url;
      });

      
      //export PDF
      $("#cetak_pdf").click(function(e)
      {
        e.preventDefault();
        var account_financing_id = $("#account_financing_id").val().trim();
        var produk = $("#produk").val().trim();
        var akad = $("#akad").val().trim();
        var nama_pasangan = $("#nama_pasangan").val().trim();
        var status_pasangan = $("#status_pasangan").val().trim();
        // var status_anggota = $("#status_anggota").val().trim();
        // var menyetujui = $("#menyetujui").val().trim();
        var saksi1 = $("#saksi1").val().trim();
        // var saksi2 = $("#saksi2").val().trim();
        if(account_financing_id==''){
         alert("Tidak data untuk ditampilkan!");
        // }
        // else if(menyetujui==''){
        //  alert("Pihak dari Anggota/Calon Anggota yang menyetujui harus diisi!");
        // }
        // else if(saksi1==''){
        //  alert("Saksi 1 harus diisi!");
        // }
        // else if(saksi2==''){
        //  alert("Saksi 2 harus diisi!");
        // }else{
        }else{
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/update_data_financing_for_akad",
            dataType: "json",
            data: {
               account_financing_id:account_financing_id
              ,saksi1:saksi1
              // ,saksi2:saksi2

            },
            success: function(response){
              if(response.success==true){
                // alert("success");
              }else{
                // alert("failed");
              }
            },
            error:function(){
              alert("Failed to Connect into Databases, Please Contact Your Administration!");
            }
          }); 
          // window.open('<?php echo site_url();?>laporan_to_pdf/cetak_akad_pembiayaan/'+account_financing_id+'/'+akad+'/'+produk+'/'+nama_pasangan+'/'+status_pasangan+'/'+saksi1+'/'+saksi2+'/');
          window.open('<?php echo site_url();?>laporan_to_pdf/cetak_akad_pembiayaan/'+account_financing_id+'/'+akad+'/'+produk+'/'+nama_pasangan+'/'+status_pasangan+'/'+saksi1+'/');
        }
      });
      
      //export PDF With Wakalah
      $("#cetak_wakalah").click(function(e)
      {
        e.preventDefault();
        var account_financing_id = $("#account_financing_id").val().trim();
        var produk = $("#produk").val().trim();
        var akad = $("#akad").val().trim();
        var status_anggota = $("#status_anggota").val().trim();
        var menyetujui = $("#menyetujui").val().trim();
        var saksi1 = $("#saksi1").val().trim();
        // var saksi2 = $("#saksi2").val().trim();
        if(account_financing_id==''){
         alert("Tidak data untuk ditampilkan!");
        // }
        // else if(menyetujui==''){
        //  alert("Pihak dari Anggota/Calon Anggota yang menyetujui harus diisi!");
        // }
        // else if(saksi1==''){
        //  alert("Saksi 1 harus diisi!");
        // }
        // else if(saksi2==''){
        //  alert("Saksi 2 harus diisi!");
        // }else{
        }else{
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/update_data_financing_for_akad",
            dataType: "json",
            data: {
               account_financing_id:account_financing_id
              ,status_anggota:status_anggota
              ,menyetujui:menyetujui
              ,saksi1:saksi1
              // ,saksi2:saksi2

            },
            success: function(response){
              if(response.success==true){
                // alert("success");
              }else{
                // alert("failed");
              }
            },
            error:function(){
              alert("Failed to Connect into Databases, Please Contact Your Administration!");
            }
          }); 
          // window.open('<?php echo site_url();?>laporan_to_pdf/cetak_akad_pembiayaan_dgn_wakalah/'+account_financing_id+'/'+akad+'/'+produk+'/'+saksi1+'/'+saksi2+'/'+menyetujui+'/'+status_anggota);
          window.open('<?php echo site_url();?>laporan_to_pdf/cetak_akad_pembiayaan_dgn_wakalah/'+account_financing_id+'/'+akad+'/'+produk+'/'+saksi1+'/'+menyetujui+'/'+status_anggota);
        }
      });


      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
