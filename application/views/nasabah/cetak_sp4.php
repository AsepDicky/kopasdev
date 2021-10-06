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
			Cetak SP4<small> Cetak Penegasan Persetujuan Penyediaan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Cetak SP4</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-print"></i>Penegasan Persetujuan Penyediaan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <input type="hidden" id="cif_no" name="cif_no">
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
               <label class="control-label">No. Pengajuan<span class="required">*</span></label>
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
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" id="jangka_waktu" name="jangka_waktu" readonly=""  style="background-color:#eee;width:30px;" /> Bulan
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Menyetujui<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class="medium m-wrap" id="nama_pasangan" name="nama_pasangan" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class="medium m-wrap" id="status_pasangan" name="status_pasangan" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="form-actions">
               <button type="button" class="btn green" id="cetak_pdf"><i class="icon icon-print" style="color:#fff;"></i>Cetak</button>
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
      $("#nama").val('');
      $("#produk").val('');
      $("#akad").val('');
      $("#pokok_pembiayaan").val('');
      $("#margin_pembiayaan").val('');
      $("#jangka_waktu").val('');
      $("#nama_pasangan").val('');
      $("#status_pasangan").val('');
        var no_pembiayaan = $("#result").val();
       $("#close","#dialog_rembug").trigger('click');
        $("#no_pembiayaan").val(no_pembiayaan);
        var account_financing_reg = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_reg:account_financing_reg},
          url: site_url+"rekening_nasabah/get_cif_by_account_financing_reg_sp4",
          success: function(response){
            // if(response.length==0){
            //    alert("CIF ini belum memiliki Rekening Tabungan!");
            // }else{
               $("#form_add input[name='account_financing_reg_id']").val(response.account_financing_reg_id);
               $("#nama").val(response.nama);
               $("#cif_no").val(response.cif_no);
               $("#produk").val(response.product_name);
               $("#akad").val(response.akad_name);
               $("#pokok_pembiayaan").val(number_format(response.amount,0,',','.'));
               $("#margin_pembiayaan").val(number_format(response.total_margin,0,',','.'));
               $("#jangka_waktu").val(response.jangka_waktu);
               $("#nama_pasangan").val(response.nama_pasangan);
               $("#status_pasangan").val(response.status_pasangan);
            // }
          },
          error: function(){
            alert('Something error. Please contact your IT support')
          }
        });	
  });

         $("#result option").live('dblclick',function(){
          $("#select").trigger('click');
         });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });


        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/account_financing_reg_no",
              data: {keyword:$("#keyword").val()},
              dataType: "json",
              success: function(response){
                var option = '';
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].registration_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
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
        account_financing_reg_id = $("#account_financing_reg_id").val();
        produk = $("#produk").val();
        akad = $("#akad").val();
        cif_no = $("#cif_no").val();
        nama_pasangan = $("#nama_pasangan").val();
        status_pasangan = $("#status_pasangan").val();
        // alert($("#akad").val()+'|'+nama_pasangan+'|'+status_pasangan);
        if(account_financing_reg_id==''){
         alert("Tidak data untuk ditampilkan!");
        }else if(nama_pasangan==''){
         alert("Nama Pasangan (menyetujui) harus diisi!");
        }
        else if(status_pasangan==''){
         alert("status pasangan harus diisi!");
        }else{
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/update_data_cif_for_sp4",
            dataType: "json",
            async:false,
            data: {
               cif_no:cif_no
              ,nama_pasangan:nama_pasangan
            },
            success: function(response){
              if(response.success==true){
              }else{
                alert("Something error, Please contact your administration!");
              }
            },
            error:function(){
              alert("Failed to Connect into Databases, Please Contact Your Administration!");
            }
          });
          window.open('<?php echo site_url();?>laporan_to_pdf/cetak_sp4/'+account_financing_reg_id+'/'+akad+'/'+nama_pasangan+'/'+status_pasangan);
        }
      });


      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
