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
        Transaction <small>Pencairan Rekening Tabungan Berencana</small>
      </h3>
      <ul class="breadcrumb">
        <li>
          <i class="icon-home"></i>
          <a href="<?php echo site_url('dashboard'); ?>">Home</a>
          <i class="icon-angle-right"></i>
        </li>
          <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>
        <li><a href="#">Pencairan Tabungan</a></li>
      </ul>
    <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN ADD USER -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pencairan Rekening Tabungan Berencana</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
          <div class="alert alert-error hide">
             <button class="close" data-dismiss="alert"></button>
             You have some form errors. Please check below.
          </div>
          <div class="alert alert-success hide">
             <button class="close" data-dismiss="alert"></button>
             Transaksi Penarikan Tunai Tabungan Berencana Berhasil Diproses !
          </div>
          <h3 class="form-section">Pencairan Rekening Tabungan Berencana</h3> 
            <div class="control-group">
              <input type="hidden" id="status_rekening" name="status_rekening">
               <label class="control-label">No Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input type="hidden" id="cif_no" name="cif_no">
                  <input type="hidden" id="cif_type" name="cif_type">
                  <input type="text" name="no_rekening" id="no_rekening" readonly="" style="background-color:#eee;" data-required="1" class="medium m-wrap"/>
                  <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="700" style="width:700px;margin-top:-200px;">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Cari No Rekening</h3>
                     </div>
                     <div class="modal-body">
                        <div class="row-fluid">
                           <div class="span12">
                              <h4>Masukan Kata Kunci</h4>
                              <p><input type="text" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                              <p><select id="result" size="7" class="span12 m-wrap"></select></p>
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
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product" id="product" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>                       
            <div class="control-group">
               <label class="control-label">Saldo<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" style="background-color:#eee;" name="saldo_memo" id="saldo_memo" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Pencairan Ke<span class="required">*</span></label>
               <div class="controls">
                   <select id="pencairan_ke" name="pencairan_ke" class="m-wrap">
                     <option></option>
                     <option>TUNAI</option>
                     <option>PINBUK</option>
                   </select>
               </div>
            </div>
            <div id="pinbuk-individu" style="display:none;">
              <hr size="1">
              <div class="control-group">
                <label class="control-label">No Rekening Tujuan<span class="required">*</span></label>
                <div class="controls">
                 <select id="no_rekening_individu" name="no_rekening_individu" class="large m-wrap">
                   <option></option>
                 </select>
                </div>
              </div>
            </div>
            <hr size="1">
            <!-- <div class="control-group">
               <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_transaksi" id="tanggal_transaksi" value="<?php echo $current_date; ?>" data-required="1" class="mask_date date-picker medium m-wrap" />
               </div>
            </div> -->
            <div class="control-group">
               <label class="control-label">Jumlah Penarikan<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" readonly="readonly" style="width:120px;background-color:#eee;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="jumlah_penarikan" id="jumlah_penarikan" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
                 </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn red" id="cancel">Reset</button>
            </div>
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
      Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
      $(".mask_date").inputmask("d/m/y");  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'rekening_tabungan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  
      $("#pencairan_ke").change(function(){
        pencairan_ke = $(this).val();
        cif_type = $("#cif_type").val(); // 0 kelompok 1 individu
        if(pencairan_ke=="PINBUK"){
          if(cif_type=='1'){
            $("#pinbuk-individu").show();
          }else{
            $("#pinbuk-individu").hide();
          }
        }else if(pencairan_ke=="TUNAI"){
          $("#pinbuk-individu").hide();
        }else{
          $("#pinbuk-individu").hide();
        }
      })

      // fungsi untuk check all
      jQuery('#rekening_tabungan_table .group-checkable').live('change',function () {
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

      $("#rekening_tabungan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
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
              },
              // tanggal_transaksi: {
              //     cek_trx_kontrol_periode : true
              // },
              jumlah_penarikan: {
                  required: true
              },
              no_rekening_individu: {
                  required: true
              },/*
              no_referensi: {
                  required: true
              },*/
              // keterangan: {
              //   required: true
              // }
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
              url: site_url+"transaction/proses_pencairan_tabungan",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                }else if(response.success==false){
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(error1, -200);
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo(error1, -200);
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        form1.trigger('reset');
      });


      // fungsi untuk mencari CIF_NO
      $(function(){
        $("#select","#dialog_rembug").click(function(){
          var status = $("#result").val().split('|');
          var status_rekening = status[0];
          var account_saving_no = status[1];
          if(status_rekening=='1')
          {
            $("#close","#dialog_rembug").trigger('click');
            $.ajax({
              type:"POST",
              url: site_url+"transaction/ajax_get_value_from_account_saving",
              data:{account_saving_no:account_saving_no},
              dataType:"json",
              success: function(response)
              {
                $("#cif_no").val(response.cif_no);
                $("#cif_type").val(response.cif_type);
                $("#no_rekening").val(response.account_saving_no);
                $("#nama").val(response.nama);
                $("#product").val(response.product_name);
                $("#saldo_memo").val(number_format(response.saldo_memo,0,',','.'));
                $("#jumlah_penarikan").val(number_format(response.saldo_memo,0,',','.'));

                if(response.cif_type=='1') { // kalo rekening milik anggota individu
                  $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                      cif_no:response.cif_no,
                      no_rekening:response.no_rekening
                    },
                    url: site_url+"transaction/ajax_get_rekening_tabungan_berencana_tujuan",
                    success: function(response){
                      option = '';
                      if(response.length>0){
                        for(i in response){
                          option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                        }
                      }
                      $("#no_rekening_individu").html(option);
                    }
                  })
                }
              }
            })
          }
          else
          {
             alert('Status Rekening Tidak Aktif');
          }
        });
      });

      $("#button-dialog").click(function(){
        $("#dialog").dialog('open');
      });

      $("#no_referensi","#form_add").change(function(){
       var no_referensi = $("#no_referensi").val();
        $.ajax({
          type: "POST",
          url: site_url+"transaction/check_no_referensi",
          async: false,
          dataType: "json",
          data: {no_referensi:no_referensi},
          success: function(response){
            if(response.success==true){
              $("#error_no_referensi").hide();                  
            }else{
              $("#error_no_referensi").show();
              $("#error_no_referensi").html('<span style="color:red;">'+response.message+'</span>');
            }
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
            url: site_url+"transaction/search_account_saving_no_active",
            data: {keyword:$(this).val()},
            dataType: "json",
            async: false,
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                 option += '<option value="'+response[i].status_rekening+'|'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+' - '+response[i].product_name+' - '+response[i].cm_name+'</option>';
              }
              // console.log(option);
              $("#result").html(option);
            }
          });
          return false;
        }
      });

      $("#result option").live('dblclick',function(){
         $("#select").trigger('click');
      });
</script>
<!-- END JAVASCRIPTS -->

