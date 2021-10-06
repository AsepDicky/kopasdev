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
      Transaction <small>Penarikan Tabungan untuk Angsuran</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Penarikan Tabungan Angsuran</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box green" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Penarikan Tabungan Angsuran</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <?php if($_is_exist_user_cash==false){ ?>
      <div class="alert alert-warning">
      WARNING : USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!
      </div>
      <?php } ?>
      <div class="clearfix" style="position:absolute">
         <div class="btn-group">
            <button id="btn_add" class="btn blue">
            Create New <i class="icon-money"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="penarikan_tunai_table">
         <thead>
            <tr>
               <th width="20%">No. Customer</th>
               <th width="20%">Nama Lengkap</th>
               <th width="20%">Nomor Rekening</th>
               <th width="20%">Jumlah Penarikan</th>
               <th width="20%">Tanggal Transaksi</th>
               <th>Delete</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Penarikan Tabungan Angsuran</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">
          <input name="account_financing_id" id="account_financing_id" type="hidden"/>
          <input name="branch_id" id="branch_id" type="hidden"/>
          <input name="counter_angsuran" id="counter_angsuran" type="hidden"/>
          <input name="saldo_pokok" id="saldo_pokok" type="hidden"/>
          <input name="saldo_margin" id="saldo_margin" type="hidden"/>
          <input name="account_financing_schedulle_id" id="account_financing_schedulle_id" type="hidden"/>
          <input name="periode" id="periode" type="hidden"/>
          <input name="bayar_pokok_before" id="bayar_pokok_before" type="hidden"/>
          <input name="bayar_margin_before" id="bayar_margin_before" type="hidden"/>
          <input name="kode_produk" id="kode_produk" type="hidden"/>

            <?php if($_is_exist_user_cash==false){ ?>
            <div class="alert alert-warning">
            WARNING : USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!
            </div>
            <?php } ?>
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Transaksi Penarikan Tabungan Angsuran Berhasil Diproses !
            </div>
            <div id="block_angsuran" style="display:none;">
              <div class="alert alert-warning">
                Pada Akun Pembiayaan ini, ada Transaksi Angsuran yang belum diverifikasi, Silahkan Verifikasi terlebih dahulu untuk melanjutkan.
              </div>
            </div>

            <div class="control-group">
              <input type="hidden" id="status_rekening" name="status_rekening">
               <label class="control-label">No Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap"/>
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

                <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <select id="account_financing_no" name="account_financing_no" class="large m-wrap" data-required="1" disabled="">
                      <option value="">PILIH No. Pembiayaan</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input name="product_code" id="product_code" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="pokok_pembiayaan" id="pokok_pembiayaan" type="text" data-required="1" class="small m-wrap mask-money" style="background-color:#eee;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;width:50px;"/><span id="periode_jangka_waktu"></span>
               </div>
            </div>

            <div class="control-group div_extra" style="display: none">
               <label class="control-label">Formula</label>
               <div class="controls">
                  <select class="m-wrap large chosen" id="formula_base" name="formula_base">
                    <option value="">PILIH Formula</option>
                    <!-- <option value="A">Saldo Pokok + Saldo Margin</option> -->
                    <option value="B">Hanya Saldo Pokok</option>
                  </select>
               </div>
            </div>
            
            <h3 class="form-section">Rekening Tabungan</h3>
            <input type="hidden" id="saldo_efektif_int"> 
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
               <label class="control-label">Saldo Riil<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;" name="saldo_memo" id="saldo_memo" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>                     
            <div class="control-group">
               <label class="control-label">Saldo Diblokir<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;" name="saldo_hold" id="saldo_hold" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Saldo Efektif<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;" name="saldo_efektif" id="saldo_efektif" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>
          
          <div id="wrap-angsuran" style="display: none">
            <h3 class="form-section">Angsuran</h3>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="bayar_saldo_pokok" id="bayar_saldo_pokok" data-required="1" type="text" class="small m-wrap mask-money" disabled="" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
              </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="bayar_saldo_margin" id="bayar_saldo_margin" data-required="1" type="text" class="small m-wrap mask-money" disabled="" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
              </div>
            </div>
            <div class="control-group div__extra">
               <label class="control-label">Pokok<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                      <input name="pokok" id="pokok" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
              </div>
            </div>    
            <div class="control-group div__extra">
               <label class="control-label">Margin<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;"/>
                   <span class="add-on">,00</span>
                 </div>
               </div>
            </div>    
            <div class="control-group div__extra">
               <label class="control-label">Total Angsuran<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="total_angsuran" id="total_angsuran" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#FFFF7F;" disabled="" />
                   <span class="add-on">,00</span>
                 </div>
               </div>
            </div>   
            <div class="control-group div__extra">
               <label class="control-label">Jatuh Tempo Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input name="jtempo_angsuran" id="jtempo_angsuran" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group div__extra">
               <label class="control-label">Frekuensi Pembayaran<span class="required">*</span></label>
               <div class="controls">
                  <input name="freq_pembayaran" id="freq_pembayaran" data-required="1" type="text" class="m-wrap" style="width:50px;"/>
               </div>
            </div>
            <div id="non_reguler" style="display:none;">       
              <div class="control-group">
                 <label class="control-label">Bayar Pokok<span class="required">*</span></label>
                 <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                        <input name="bayar_pokok" id="bayar_pokok" data-required="1" type="text" class="small m-wrap mask-money"/>
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
                        <input name="bayar_margin" id="bayar_margin" data-required="1" type="text" class="small m-wrap mask-money"/>
                      <span class="add-on">,00</span>
                   </div>
                   <span id="sisa_bayar_margin" style="font-size:11px;font-style:italic;color:red"></span>
                 </div>
              </div>  
            </div>
            <div class="control-group div__extra">
               <label class="control-label">Nominal Pembayaran<span class="required">*</span></label>
               <div class="controls">
                 <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="nominal_pembayaran" id="nominal_pembayaran" data-required="1" type="text" class="small m-wrap mask-money"/>
                    <span class="add-on">,00</span>
                 </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan_angs" name="keterangan_angs" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kas/Bank Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium chosen" id="account_cash_code_angs" name="account_cash_code_angs">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas): ?>
                    <option value="<?php echo $kas['account_code'] ?>"><?php echo $kas['account_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
               </div>
            </div>

            <h3 class="form-section">Transaksi</h3>
            <div class="control-group">
               <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_transaksi" id="tanggal_transaksi" value="<?php echo $current_date; ?>" data-required="1" class="mask_date date-picker medium m-wrap"/>
               </div>
            </div>                       
            <div class="control-group">
               <label class="control-label">Jumlah Penarikan<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="jumlah_penarikan" id="jumlah_penarikan" maxlength="12">
                     <span class="add-on">,00</span>
                   </div>
                 </div>
            </div>                         
            <div class="control-group">
               <label class="control-label">No Referensi</label>
               <div class="controls">
                  <input type="text" maxlength="15" name="no_referensi" id="no_referensi" data-required="1" class="medium m-wrap"/>
                  <div id="error_no_referensi"></div>
               </div>
            </div>                         
            <div class="control-group">
               <label class="control-label">Keterangan Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="keterangan" id="keterangan" class="medium m-wrap"/></textarea>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Kas/Bank Tabungan<span class="required">*</span></label>
               <div class="controls">
                <select class="m-wrap medium" id="account_cash_code" name="account_cash_code">
                  <option value="">-PILIH-</option>
                  <?php foreach($account_cash as $account): ?>
                    <option value="<?php echo $account['account_code'] ?>"><?php echo $account['account_name'] ?></option>
                  <?php endforeach; ?>
                </select>
               </div>
            </div>
          </div>
            <div class="form-actions">
               <button type="submit" style="display: none" id="save_trx" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>
</div>
<!-- END ADD USER -->

<!-- print voucher area -->
<div id="print_validasi_setoran" style="font-size:10px;display:none">

  <div style="padding:10px;">

    <table style="width:70%" id="pa_transaction" align="center">
      <thead>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="50%" align="left"><span id="span_validasi_row1"></span></th>
        </tr>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="50%" align="left"><span id="span_validasi_row2"></span></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
    <br>
  </div>
</div>

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
      $(".mask_date").inputmask("d/m/y");  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$("#account_financing_no").attr('disabled', true);
$("#wrap-angsuran").hide();
$("#save_trx").hide();

// BEGIN FORM ADD USER VALIDATION
var form1 = $('#form_add');
var error1 = $('.alert-error', form1);
var warning1 = $('.alert-warning', form1);
var success1 = $('.alert-success', form1);

var cif_backend = '<?= $this->uri->segment(3)?>';

if(cif_backend !== '')
{
  $("#wrapper-table").hide();
  $("#wrap-angsuran").hide();
  $("#save_trx").hide();
  $("#add").show();
  form1.trigger('reset');
  $('#no_rekening', '#form_add').focus();

  $.ajax({
      type:"POST",
      url: site_url+"transaction/ajax_get_value_from_account_saving",
      data:{account_saving_no:cif_backend},
      async:false,
      dataType:"json",
      success: function(responses)
      {
        $.ajax({
          type: "POST",
          url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
          data: {keyword:responses.cif_no},
          dataType: "json",
          success: function(response){
            if(response.length > 0)
            {
              $("#account_financing_no").attr('disabled', false);
              //** Detil Tabungan
              $("#no_rekening").val(responses.account_saving_no);
              $("#nama").val(responses.nama);
              $("#product").val(responses.product_name);
              $("#saldo_memo").val(number_format(responses.saldo_memo,0,',','.'));
              $("#saldo_hold").val(number_format(responses.saldo_hold,0,',','.'));
              $("#saldo_efektif_int").val(responses.saldo_efektif);
              if (responses.saldo_memo>responses.saldo_minimal) {
                  $("#saldo_efektif").val(number_format(responses.saldo_efektif,0,',','.'));
              } else{
                  $("#saldo_efektif").val(number_format(0,0,',','.'));
              };

              $("#keterangan").val("PENARIKAN TUNAI A/N "+responses.nama);

              var option = '<option value="">PILIH No. Pembiayaan</option>';
              for(i = 0 ; i < response.length ; i++){
                 var tanggal_akad = response[i].tanggal_akad;
                 day = tanggal_akad.substr(8,2);
                 month = tanggal_akad.substr(5,2);
                 year = tanggal_akad.substr(0,4);
                 tgl_akad = day+'/'+month+'/'+year;
                 option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'" cif_no="'+response[i].cif_no+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+tgl_akad+' - '+number_format(response[i].besar_angsuran,0,',','.')+' - '+response[i].product_name+'</option>';
              }

              $("select[name='account_financing_no']").html(option);
            
            }else{
              $("#account_financing_no").attr('disabled', true);
            }
          }
        });  
      }
    })
}

// fungsi untuk reload data table
// di dalam fungsi ini ada variable tbl_id
// gantilah value dari tbl_id ini sesuai dengan element nya
var dTreload = function()
{
  var tbl_id = 'penarikan_tunai_table';
  $("select[name='"+tbl_id+"_length']").trigger('change');
  $(".paging_bootstrap li:first a").trigger('click');
  $("#"+tbl_id+"_filter input").val('').trigger('keyup');
}

/**
* DELETE PENARIKAN TUNAI
* element : link-delete
* @author : sayyid
* date : 25 agustus 2014
*/

$("a#link-delete").live('click',function(e){
  e.preventDefault();
  var trx_detail_id=$(this).attr('trx_detail_id');
  var nama=$(this).attr('nama');
  var account_saving_no=$(this).attr('account_saving_no');
  var conf=confirm("Akan melakukan Delete Transaksi Penarikan Tunai "+account_saving_no+" ("+nama+"), Apakah anda Yakin?");
  if(conf){
    $.ajax({
      type:"POST",
      dataType:"json",
      url:site_url+"transaction/delete_penarikan_tunai",
      async:false,
      data:{trx_detail_id:trx_detail_id},
      success:function(response){
        if(response.success==true){
          alert("Delete Transaksi Penarikan Tunai, Sukses!");
        }else{
          alert("Internal Server Error");
        }
        dTreload();
      },
      error: function(){
        alert("Failed to Connect into Databases, Please Contact Your Administrator");
      }
    })
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

$("#penarikan_tunai_table .checkboxes").livequery(function(){
  $(this).uniform();
});

// begin first table
$('#penarikan_tunai_table').dataTable({
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": site_url+"transaction/datatable_penarikan_tunai_tabungan",
    "aoColumns": [
      null,
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

jQuery('#penarikan_tunai_table_length').hide();

$("#btn_add").click(function(){
  $("#wrapper-table").hide();
  $("#wrap-angsuran").hide();
  $("#save_trx").hide();
  $("#add").show();
  form1.trigger('reset');
  $('#no_rekening', '#form_add').focus();
});

form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error,element){},
    // ignore: "",
    rules: {
        no_rekening: {
            required: true
        },
        tanggal_transaksi: {
            cek_trx_kontrol_periode : true
        },
        jumlah_penarikan: {
            required: true
        },
        keterangan: {
          required: true
        },
        keterangan_angs: {
          required: true
        },
        account_cash_code: {
            required: true
        },
        account_cash_code_angs: {
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

    },

    submitHandler: function (form) {
      var _is_exist_user_cash = "<?php echo $_is_exist_user_cash; ?>";
      console.log(_is_exist_user_cash);

      trx_date = $("#tanggal_transaksi").val();
      jumlah_penarikan = $("#jumlah_penarikan").val();
      bayar_saldo_pokok = $("#bayar_saldo_pokok").val();
      bayar_saldo_margin = $("#bayar_saldo_margin").val();
      freq_pembayaran = $("#freq_pembayaran").val();
      tanggal_transaksi = $("#tanggal_transaksi").val();
      s = trx_date.split('/');
      day=s[0];
      month=s[1];
      year=s[2];
      trx_date = new Date(year, month-1,day);
      today = new Date();
      day2 = today.getDate();
      month2 = today.getMonth();
      year2 = today.getFullYear();
      today = new Date(year2, month2, day2);

      if(_is_exist_user_cash==0){
        App.scrollTo(warning1, -200);
        alert("WARING: USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!")
      }else{
        conf = true;
        if(trx_date < today)
        {
          conf = confirm("Transaksi Backdate (tanggal transaksi lebih kecil dr tanggal hari ini) , lanjutkan?");
        }

        if(conf==true)
        {
          $.ajax({
            type: "POST",
            url: site_url+"transaction/proses_penarikan_tabungan_angsuran",
            dataType: "json",
            async:false,
            data: form1.serialize() + "&jumlah_penarikan=" + jumlah_penarikan+ "&freq_pembayaran=" + freq_pembayaran+ "&tanggal_transaksi=" + tanggal_transaksi+ "&bayar_saldo_pokok=" + bayar_saldo_pokok+ "&bayar_saldo_margin=" + bayar_saldo_margin,
            success: function(response){
              if(response.success==0){
                success1.show();
                error1.hide();
                form1.trigger('reset');
                form1.children('div').removeClass('success');
                $("#no_rekening").focus();
              }else if(response.success==1){
                success1.hide();
                error1.show();
              }else{
                alert("Jumlah Penarikan Melebihi Saldo Efektif");
                $("#jumlah_penarikan").val('0');
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
        else
        {
          $("#tanggal_transaksi").select();
        }

      }

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

// fungsi untuk mencari CIF_NO
$(function(){
  $("#select","#dialog_rembug").click(function(){
    var status = $("#result").val();
    var status_rekening = status.substring(0,1);          
    var account_saving_no = status.substring(1);
      
    $("#close","#dialog_rembug").trigger('click');
    $.ajax({
      type:"POST",
      url: site_url+"transaction/ajax_get_value_from_account_saving",
      data:{account_saving_no:account_saving_no},
      async:false,
      dataType:"json",
      success: function(responses)
      {
        $.ajax({
          type: "POST",
          url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
          data: {keyword:responses.cif_no},
          dataType: "json",
          success: function(response){
            if(response.length > 0)
            {
              $("#account_financing_no").attr('disabled', false);
              //** Detil Tabungan
              $("#no_rekening").val(responses.account_saving_no);
              $("#nama").val(responses.nama);
              $("#product").val(responses.product_name);
              $("#saldo_memo").val(number_format(responses.saldo_memo,0,',','.'));
              $("#saldo_hold").val(number_format(responses.saldo_hold,0,',','.'));
              $("#saldo_efektif_int").val(responses.saldo_efektif);
              if (responses.saldo_memo>responses.saldo_minimal) {
                  $("#saldo_efektif").val(number_format(responses.saldo_efektif,0,',','.'));
              } else{
                  $("#saldo_efektif").val(number_format(0,0,',','.'));
              };

              $("#keterangan").val("PENARIKAN TUNAI A/N "+responses.nama);

              var option = '<option value="">PILIH No. Pembiayaan</option>';
              for(i = 0 ; i < response.length ; i++){
                 var tanggal_akad = response[i].tanggal_akad;
                 day = tanggal_akad.substr(8,2);
                 month = tanggal_akad.substr(5,2);
                 year = tanggal_akad.substr(0,4);
                 tgl_akad = day+'/'+month+'/'+year;
                 option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'" cif_no="'+response[i].cif_no+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+tgl_akad+' - '+number_format(response[i].besar_angsuran,0,',','.')+' - '+response[i].product_name+'</option>';
              }

              $("select[name='account_financing_no']").html(option);
            
            }else{
              $("#account_financing_no").attr('disabled', true);
            }
          }
        });  
      }
    })
  });

  $("select[name='account_financing_no']").change(function(){
    var account_financing_no = $(this).val();    
    var saldo_efektif = $("#saldo_efektif_int").val();
    App.scrollTo($('#nama',"#form_add"),-200);  
    $.ajax({
      type:"POST",dataType:"json",data:{
        account_financing_no:account_financing_no
      },
      url:site_url+'transaction/cek_unverified_transaction',
      success:function(response){
        
        v_is_verified = response.is_verified;
        if (response.is_verified==true) {
          $('#block_angsuran').hide();
          $.ajax({
            type: "POST",
            dataType: "json",
            data: {account_financing_no:account_financing_no},
            url: site_url+"transaction/get_akad_pembiayaan",
            success: function(response){

              // MDA & MSA BELUM DI PROSES
              if(response.akad_code=='MDA' || response.akad_code=='MSA'){
                
                $.ajax({
                  type: "POST",
                  dataType: "json",
                  data: {account_financing_no:account_financing_no},
                  url: site_url+"transaction/get_flag_jadwal_angsuran",
                  success: function(response){

                    }
                  })
                alert("Akad MDA & MSA belum dilakukan proses secara program!");
                $("#save_trx").hide();
              }else{

                $.ajax({
                  type: "POST",
                  dataType: "json",
                  data: {account_financing_no:account_financing_no},
                  url: site_url+"transaction/get_flag_jadwal_angsuran",
                  success: function(response){

                    if(response.flag_jadwal_angsuran=='0'){

                      $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {account_financing_no:account_financing_no},
                        url: site_url+"transaction/get_cif_for_pembayaran_angsuran_non_reguler",
                        success: function(response){
                          if(response.length==0){
                            alert("Tidak ada data pembayaran angsuran yang harus dilakukan");
                            $("#save_trx").hide();
                          }else{

                            if(response.product_code == 53 || response.product_code == 54 || response.product_code == 56)
                            {
                              $(".div_extra").show();
                              $(".div__extra").hide();
                            }else{
                              $(".div_extra").hide();
                              $(".div__extra").show();
                            }

                            $("#account_financing_id").val(response.account_financing_id);
                            $("#branch_id").val(response.branch_id);
                            $("#product_code").val(response.product_name);
                            $("#kode_produk").val(response.product_code);
                            $("#keterangan_angs").val('ANGSURAN A/N '+response.nama+' NIK '+response.account_saving_no);
                            $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
                            $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
                            $("#jangka_waktu").val(response.jangka_waktu);
                            $("#counter_angsuran").val(response.counter_angsuran);

                            var periode_jangka_waktu = response.periode_jangka_waktu;
                            if(periode_jangka_waktu==0){
                              periode = "Hari";
                            }else if(periode_jangka_waktu==1){
                              periode = "Minggu";
                            }else if(periode_jangka_waktu==2){
                              periode = "Bulan";
                            }else{
                              periode = "Jatuh Tempo";
                            }
                            $("#periode_jangka_waktu").html(periode);
                            $("#periode").val(periode_jangka_waktu);
                            $("#pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                            $("#margin").val(number_format(response.angsuran_margin,0,',','.'));

                            var tanggal_jtempo = response.tanggal_jtempo;
                            day    = tanggal_jtempo.substr(8,2);
                            month  = tanggal_jtempo.substr(5,2);
                            year   = tanggal_jtempo.substr(0,4);
                            tgl_jtempo = day+'/'+month+'/'+year;

                            $("#tanggal_transaksi").val(tgl_jtempo);

                            var angsuran_pokok = parseFloat(response.angsuran_pokok);
                            var angsuran_margin = parseFloat(response.angsuran_margin);
                            var angsuran_tabungan = parseFloat(response.angsuran_tabungan);
                            var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_tabungan;

                            $("#jtempo_angsuran").val(tgl_jtempo);
                            $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
                            $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
                            $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                            $("#bayar_pokok").val(number_format(response.bayar_pokok,0,',','.'));
                            $("#bayar_pokok_before").val(response.byr_pokok);
                            $("#bayar_margin").val(number_format(response.bayar_margin,0,',','.'));
                            $("#bayar_margin_before").val(response.byr_margin);
                            $("#account_financing_schedulle_id").val(response.account_financing_schedulle_id);
                            $("#freq_pembayaran").attr("disabled", true);
                            $("#freq_pembayaran").val('1');

                            var bayar_pokok = parseFloat(response.bayar_pokok);
                            var bayar_margin = parseFloat(response.bayar_margin);
                            var nominal_pembayaran = bayar_pokok+bayar_margin;
                            
                            // Proses singkron saldo
                            var case_if=true;
                            if(response.product_code == '53' || response.product_code == '54' || response.product_code == '56')
                            {
                              case_if = false;
                            }else{
                              if(saldo_efektif > nominal_pembayaran)
                              {
                                case_if = true;
                              }else{
                                case_if = false;
                              }
                            }

                            if(case_if==false){
                              
                              $("#nominal_pembayaran").attr("disabled", true);
                              $("#jumlah_penarikan").attr("disabled", true);
                              $("#nominal_pembayaran").val(number_format(nominal_pembayaran,0,',','.'));
                              $("#jumlah_penarikan").val(number_format(nominal_pembayaran,0,',','.'));
                              $("#wrap-angsuran").show();
                              $("#save_trx").show();
                            }else{
                              alert("Saldo tabungan belum cukup untuk melakukan pembayaran!");
                              $("#wrap-angsuran").hide();
                              $("#save_trx").hide();
                            }
                          }
                        }
                      })
                    }else{

                      $.ajax({
                        type: "POST",
                        dataType: "json",
                        // async: false,
                        data: {account_financing_no:account_financing_no},
                        url: site_url+"transaction/get_cif_for_pembayaran_angsuran",
                        success: function(response){
                          if(response.length==0){
                            alert("Tidak ada data pembayaran angsuran yang harus dilakukan");
                            $("#save_trx").hide();
                          }else{

                            if(response.product_code == 53 || response.product_code == 54 || response.product_code == 56)
                            {
                              $(".div_extra").show();
                              $(".div__extra").hide();
                            }else{
                              $(".div_extra").hide();
                              $(".div__extra").show();
                            }

                            $("#account_financing_id").val(response.account_financing_id);
                            $("#branch_id").val(response.branch_id);
                            $("#keterangan_angs").val('ANGSURAN A/N '+response.nama+' NIK '+response.cif_no)
                            $("#product_code").val(response.product_name);
                            $("#kode_produk").val(response.product_code);
                            $("#pokok_pembiayaan").val(number_format(response.pokok,0,',','.'));
                            $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
                            $("#jangka_waktu").val(response.jangka_waktu);
                            $("#counter_angsuran").val(response.counter_angsuran);
                            $("#freq_pembayaran").attr("disabled", true);
                            $("#freq_pembayaran").val(1);
                            $("#nominal_pembayaran").val(0);

                            var periode_jangka_waktu = response.periode_jangka_waktu;
                            if(periode_jangka_waktu==0){
                              periode = "Hari";
                            }else if(periode_jangka_waktu==1){
                              periode = "Minggu";
                            }else if(periode_jangka_waktu==2){
                              periode = "Bulan";
                            }else{
                              periode = "Jatuh Tempo";
                            }
                            $("#periode_jangka_waktu").html(periode);
                            $("#periode").val(periode_jangka_waktu);
                            $("#pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                            $("#margin").val(number_format(response.angsuran_margin,0,',','.'));

                            var jtempo_angsuran_next = response.jtempo_angsuran_next;
                            if(jtempo_angsuran_next!=null){
                             day    = jtempo_angsuran_next.substr(8,2);
                             month  = jtempo_angsuran_next.substr(5,2);
                             year   = jtempo_angsuran_next.substr(0,4);
                             jtempo_angsuran_next = day+'/'+month+'/'+year;
                            }else{
                             jtempo_angsuran_next = '';
                            }

                            $("#tanggal_transaksi").val(jtempo_angsuran_next);

                            var angsuran_pokok = parseFloat(response.angsuran_pokok);
                            var angsuran_margin = parseFloat(response.angsuran_margin);
                            var angsuran_catab = parseFloat(response.angsuran_catab);
                            var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_catab;

                            $("#jtempo_angsuran").val(jtempo_angsuran_next);
                            $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
                            $("#saldo_pokok").val(number_format(response.saldo_pokok,0,',','.'));
                            $("#saldo_margin").val(number_format(response.saldo_margin,0,',','.'));
                            
                            $("#freq_pembayaran").attr("readonly", false);
                            $("#freq_pembayaran").css("backgroundColor","#fff");
                            $("#pokok_pembiayaan").attr("readonly", true);
                            $("#margin_pembiayaan").attr("readonly", true);
                            $("#pokok").attr("readonly", true);
                            $("#margin").attr("readonly", true);
                            $("#cadangan_tabungan").attr("readonly", true);
                            $("#total_angsuran").attr("readonly", true);
                            $("#nominal_pembayaran").attr("readonly", true);
                            $("#nominal_pembayaran").css("backgroundColor","#eee");

                            var bayar_pokok = parseFloat(response.angsuran_pokok);
                            var bayar_margin = parseFloat(response.angsuran_margin);
                            var nominal_pembayaran = bayar_pokok+bayar_margin;

                            // Proses singkron saldo
                            if(saldo_efektif > nominal_pembayaran){
                              
                              $("#nominal_pembayaran").attr("disabled", true);
                              $("#jumlah_penarikan").attr("disabled", true);
                              $("#nominal_pembayaran").val(number_format(nominal_pembayaran,0,',','.'));
                              $("#jumlah_penarikan").val(number_format(nominal_pembayaran,0,',','.'));
                              $("#wrap-angsuran").show();
                              $("#save_trx").show();
                            }else{
                              alert("Saldo tabungan belum cukup untuk melakukan pembayaran!");
                              $("#wrap-angsuran").hide();
                              $("#save_trx").hide();
                            }

                          }
                        }
                      })

                    }

                  }
                })

              }

            }
          })
        }else{
          $('#block_angsuran').show();
          $("#save_trx").hide();
        }
      }
    })
  });

  $("select[name='formula_base']").change(function(){
    var formula = $(this).val(); 
    var account_financing_no = $('#account_financing_no').val(); 
    $.ajax({
      type:"POST",dataType:"json",data:{
        account_financing_no:account_financing_no,
        nik:cif_backend
      },
      url:site_url+'transaction/get_list_saldo_v2',
      success:function(response){
        var saldo_pokok = response[0].saldo_pokok;
        var saldo_margin = response[0].saldo_margin;
        var saldo_efektif = $("#saldo_efektif_int").val();
        
        if(formula == 'A'){
        
          $('#bayar_saldo_pokok').val(number_format(saldo_pokok,0,',','.'));
          $('#bayar_saldo_margin').val(number_format(saldo_margin,0,',','.'));
        
        }else if(formula == 'B'){

          $('#bayar_saldo_pokok').val(number_format(saldo_pokok,0,',','.'));
          $('#bayar_saldo_margin').val(number_format(0,0,',','.'));

        }

        $("#jumlah_penarikan").val(number_format(saldo_efektif,0,',','.'));
      }
    })
  });
});

$("#button-dialog").click(function(){
  $("#dialog").dialog('open');
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
      url: site_url+"transaction/search_account_saving_no",
      data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
      dataType: "json",
      async: false,
      success: function(response){
        var option = '';
        for(i = 0 ; i < response.length ; i++){
           option += '<option value="'+response[i].status_rekening+''+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
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

<script type="text/javascript">
  $(function(){
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
        $(this).val('');
        e.preventDefault();
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
      $('#no_rekening', '#form_add').focus();
      $("#result","#dialog_rembug").val('');
    });
    $('#select', '#dialog_rembug').click(function (e) {
      // $('#tanggal_transaksi',"#form_add").focus().select();
      $("#result","#dialog_rembug").val('');
      // App.scrollTo($('#tanggal_transaksi',"#form_add"),-200);
    });
    $(window).keydown(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });


    /*
    |-------------------------------------------------------------------------------
    | BEGIN : ENTER EVENT FOR ADD
    |-------------------------------------------------------------------------------
    */
    $("input,select,textarea","#form_add").live('keypress',function(e){
        if(e.keyCode==13) {
         e.preventDefault();
          if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT' || $(this).next().prop('tagName')=='TEXTAREA') {
            $(this).next().focus();
          }else{
            if($(this).closest('.control-group').next('.form-actions').length==1){
              $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
            }else{
              if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select,textarea').attr('readonly'))!='undefined'){
                $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select,textarea').focus();
              }else{
                $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select,textarea').focus();
              }
            }
          }
        }
    });

    /*
    |-------------------------------------------------------------------------------
    | END : ENTER EVENT FOR ADD
    |-------------------------------------------------------------------------------
    */
  })
</script>
<!-- END JAVASCRIPTS -->

