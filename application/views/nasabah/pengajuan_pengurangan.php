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
      Pengajuan Pengurangan Hutang<small> Pengajuan Pengurangan Hutang</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pengajuan Pengurangan Hutang</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Pengurangan Hutang</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
            <input type="hidden" name="potongan_margin" id="potongan_margin">
            <input type="hidden" name="account_financing_no" id="account_financing_no">
            <input name="bayar_pokok_before" id="bayar_pokok_before" type="hidden">
            <input name="bayar_margin_before" id="bayar_margin_before" type="hidden">
            <input name="counter_angsuran" id="counter_angsuran" type="hidden">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Pengajuan Pengurangan Hutang Berhasil Diproses !
            </div>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
               <div class="controls">
               <input type="text" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap"/>
               <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
         </label>
      
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari No Rekening</h3>
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
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input name="nik" id="nik" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="produk" id="produk" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="nilai_pembiayaan" id="nilai_pembiayaan" type="text" data-required="1" readonly="readonly" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Kontrak<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_kontrak" id="tanggal_kontrak" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Bayar Terakhir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_bayar_terakhir" id="tanggal_bayar_terakhir" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="saldo_pokok" id="saldo_pokok" type="text" data-required="1" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="saldo_margin" id="saldo_margin" type="text" data-required="1" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="angsuran_pokok" id="angsuran_pokok" type="text" data-required="1" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="angsuran_margin" id="angsuran_margin" type="text" data-required="1" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div id="non_reguler" style="display:none;">       
              <div class="control-group">
                 <label class="control-label">Bayar Pokok<span class="required">*</span></label>
                 <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                        <input name="bayar_pokok" id="bayar_pokok" value="0" data-required="1" type="text" class="small m-wrap mask-money"/>
                      <span class="add-on">,00</span>
                   </div>
                   <span id="sisa_bayar_pokok" style="font-size:11px;font-style:italic;color:red"></span>
                 </div>
              </div>          
              <div class="control-group">
                 <label class="control-label">Bayar Margin<span class="required">*</span></label>
                 <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                        <input name="bayar_margin" id="bayar_margin" value="0" data-required="1" type="text" class="small m-wrap mask-money"/>
                      <span class="add-on">,00</span>
                   </div>
                   <span id="sisa_bayar_margin" style="font-size:11px;font-style:italic;color:red"></span>
                 </div>
              </div>  
            </div>
            <div class="control-group">
               <label class="control-label">Pengajuan Pengurangan Hutang<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="pengajuan_pengurangan_hutang" id="pengajuan_pengurangan_hutang" type="text" data-required="1" class="small m-wrap mask-money"/>
                    <span class="add-on">,00</span>
                    <span>x angsuran pokok</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Pengajuan Pengurangan Hutang<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="total_pengajuan_pengurangan_hutang" id="total_pengajuan_pengurangan_hutang" type="text" data-required="1" readonly="readonly" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Pengurangan Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="jumlah_pengurangan_pokok" id="jumlah_pengurangan_pokok" type="text" data-required="1" readonly="readonly" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Pengurangan Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="jumlah_pengurangan_margin" id="jumlah_pengurangan_margin" type="text" data-required="1" readonly="readonly" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Pembayaran<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="jumlah_pembayaran" id="jumlah_pembayaran" type="text" data-required="1" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pembayaran Melalui Bank<span class="required">*</span></label>
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
               <label class="control-label">Tanggal Pembayaran<span class="required">*</span></label>
               <div class="controls">
                  <input name="tgl_bayar" id="tgl_bayar" data-required="1" type="text" class="mask_date date-picker small m-wrap"/>
               </div>
            </div>     
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="reset" class="btn">Reset</button>
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
    $("#select").click(function(){
        var no_pembiayaan = $("#result").val();
        $("#close","#dialog_rembug").trigger('click');
        var account_financing_no = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          // async: false,
          data: {account_financing_no:account_financing_no},
          url: site_url+"transaction/get_flag_jadwal_angsuran",
          success: function(response){
            if(response.flag_jadwal_angsuran=='0'){
              $.ajax({
                type: "POST",
                dataType: "json",
                data: {account_financing_no:account_financing_no},
                url: site_url+"transaction/get_cif_pengajuan_pelunasan",
                success: function(response){
                   var tanggal_akad = response.tanggal_akad;
                   day = tanggal_akad.substr(8,2);
                   month = tanggal_akad.substr(5,2);
                   year = tanggal_akad.substr(0,4);
                   tgl_akad = day+'/'+month+'/'+year;

                   var jtempo_angsuran_last = response.jtempo_angsuran_last;
                   day1 = jtempo_angsuran_last.substr(8,2);
                   month1 = jtempo_angsuran_last.substr(5,2);
                   year1 = jtempo_angsuran_last.substr(0,4);
                   tgl_jtempo_angsuran_last = day1+'/'+month1+'/'+year1;

                   $("#account_financing_id").val(response.account_financing_id);
                   $("#account_financing_no").val(response.account_financing_no);
                   $("#branch_id").val(response.branch_id);
                   $("#no_rekening").val(response.account_financing_no);
                   $("#nik").val(response.cif_no);
                   $("#nama").val(response.nama);
                   $("#produk").val(response.product_name);
                   $("#nilai_pembiayaan").val(number_format(response.pokok,0,',','.'));
                   $("#tanggal_kontrak").val(tgl_akad);
                   $("#tanggal_bayar_terakhir").val(tgl_jtempo_angsuran_last);
                   $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
                   $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                   $("#angsuran_pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                   $("#angsuran_margin").val(number_format(response.angsuran_margin,0,',','.'));
                   $("#jumlah_pembayaran").val(number_format(response.jumlah_pembayaran,0,',','.'));
                   $("#potongan_margin").val(number_format(response.potongan_margin,0,',','.'));
                   $("#bayar_pokok").val(number_format(response.bayar_pokok,0,',','.'));
                   $("#bayar_pokok_before").val(response.byr_pokok);
                   $("#bayar_margin").val(number_format(response.bayar_margin,0,',','.'));
                   $("#bayar_margin_before").val(response.byr_margin);
                   $("#counter_angsuran").val(response.counter_angsuran);
                }
              }); 
              $("#non_reguler").show();
            }else{
              $.ajax({
                type: "POST",
                dataType: "json",
                data: {account_financing_no:account_financing_no},
                url: site_url+"transaction/get_cif_pengajuan_pelunasan_reguler",
                success: function(response){
                   var tanggal_akad = response.tanggal_akad;
                   day = tanggal_akad.substr(8,2);
                   month = tanggal_akad.substr(5,2);
                   year = tanggal_akad.substr(0,4);
                   tgl_akad = day+'/'+month+'/'+year;

                   var jtempo_angsuran_last = response.jtempo_angsuran_last;
                   day1 = jtempo_angsuran_last.substr(8,2);
                   month1 = jtempo_angsuran_last.substr(5,2);
                   year1 = jtempo_angsuran_last.substr(0,4);
                   tgl_jtempo_angsuran_last = day1+'/'+month1+'/'+year1;

                   $("#account_financing_id").val(response.account_financing_id);
                   $("#account_financing_no").val(response.account_financing_no);
                   $("#branch_id").val(response.branch_id);
                   $("#no_rekening").val(response.account_financing_no);
                   $("#nik").val(response.cif_no);
                   $("#nama").val(response.nama);
                   $("#produk").val(response.product_name);
                   $("#nilai_pembiayaan").val(number_format(response.pokok,0,',','.'));
                   $("#tanggal_kontrak").val(tgl_akad);
                   $("#tanggal_bayar_terakhir").val(tgl_jtempo_angsuran_last);
                   $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
                   $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                   $("#angsuran_pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                   $("#angsuran_margin").val(number_format(response.angsuran_margin,0,',','.'));
                   $("#jumlah_pembayaran").val(number_format(response.jumlah_pembayaran,0,',','.'));
                   $("#potongan_margin").val(number_format(response.potongan_margin,0,',','.'));
                   $("#counter_angsuran").val(response.counter_angsuran);
                }
              }); 
              $("#non_reguler").hide();
            }
          }
        }); 
    });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });

        $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
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
              },
              pengajuan_pengurangan_hutang: {
                  required: true
              },
              tgl_bayar: {
                  required: true,
                  cek_trx_kontrol_periode : true
              },
              accoutn_cash_code: {
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
              url: site_url+"transaction/proses_pengajuan_pengurangan",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  alert('Successfully Saved Data');
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.find('.control-group').removeClass('success');
                  $("#no_rekening").focus();
                  $('#account_cash_code').trigger('liszt:updated');
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

      $("#pengajuan_pengurangan_hutang").live('keyup',function(){
        var pengajuan_pengurangan_hutang = parseFloat(convert_numeric($(this).val()));
        var saldo_pokok = parseFloat(convert_numeric($("#saldo_pokok").val()));
        var saldo_margin = parseFloat(convert_numeric($("#saldo_margin").val()));
        var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
        var jumlah_pengurangan_pokok = saldo_pokok-pengajuan_pengurangan_hutang;
        var jumlah_pengurangan_margin = saldo_margin-pengajuan_pengurangan_hutang;
        var total_pengajuan_pengurangan_hutang = pengajuan_pengurangan_hutang*angsuran_pokok;
        $("#jumlah_pengurangan_pokok","#form_add").val(number_format(jumlah_pengurangan_pokok,0,',','.'));
        $("#jumlah_pengurangan_margin","#form_add").val(number_format(jumlah_pengurangan_margin,0,',','.'));
        $("#total_pengajuan_pengurangan_hutang","#form_add").val(number_format(total_pengajuan_pengurangan_hutang,0,',','.'));
      })

});
</script>
<script type="text/javascript">
  $(function(){
    $('#no_rekening', '#form_add').focus();
    $('#no_rekening', '#form_add').keydown(function (e) {
      if (e.which == 123) {
        $('#browse_rembug').trigger('click');
        e.preventDefault();
      }else{
        e.preventDefault();
      }
    });
    $('#browse_rembug').click(function(e){
      setTimeout(function () {
        $('#keyword', '#dialog_rembug').focus();
      }, 1000);
      e.preventDefault();
    })
    $('#result').keyup(function (e) {
      if (e.which == 13) {
        $('#select', '#dialog_rembug').trigger('click');
      }
    });
    $('#result').keydown(function (e) {
      if (e.which == 123) {
        $('#keyword', '#dialog_rembug').focus();
        e.preventDefault();
        $(this).val('');
      }
    });
    $('#keyword', '#dialog_rembug').keyup(function (e) {
      if (e.which == 13) {
        $('#result', '#dialog_rembug').focus();
        $('#result option:first-child', '#dialog_rembug').attr('selected', true);
      }
    });
    $('#keyword', '#dialog_rembug').keydown(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });
    $('#close', '#dialog_rembug').click(function (e) {
      $("#result","#dialog_rembug").val('');
      $('#no_rekening', '#form_add').focus();
    });
    $(window).keydown(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });
  })
</script>

<!-- END JAVASCRIPTS -->
