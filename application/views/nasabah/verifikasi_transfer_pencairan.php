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
      Rekening Nasabah <small>Verifikasi Transfer Pencairan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Transfer Pencairan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Transfer Pencairan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div>
        <select id="product_code" name="product_code" class="medium m-wrap">
          <option value="">Silahkan Pilih Produk</option>
          <?php foreach($product as $produk): ?>
          <option value="<?php echo $produk['product_code'] ?>" data-nick_name="<?php echo $produk['nick_name'] ?>"><?php echo $produk['product_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transfer_pencairan">
         <thead>
            <tr>
              <th width="13%">No.Pembiayaan</th>
              <th width="15%">Nama</th>
              <th width="12%">Tgl.Akad</th>
              <th width="12%">Tgl.Transfer</th>
              <th width="12%">Jumlah Koptel Transfer</th>
              <th width="12%">Biaya Asuransi</th>
              <th width="10%">Pembiayaan</th>
              <th width="15%">Kewajiban Koptel</th>
              <th width="15%">Kewajiban Kopegtel</th>
              <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT -->
<div id="add" style="display:none;">
  <div class="portlet box red">
    <div class="portlet-title">
       <div class="caption"><i class="icon-reorder"></i>Verifikasi Transfer Pencairan</div>
       <div class="tools">
          <a href="javascript:;" class="collapse"></a>
       </div>
    </div>
    <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form action="#" id="form" class="form-horizontal">
        <div class="alert alert-error hide">
           <button class="close" data-dismiss="alert"></button>
           You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
           <button class="close" data-dismiss="alert"></button>
           Verifikasi Transfer Pencairan Berhasil Di Proses !
        </div>
        <div class="form-body" style="padding-top:20px;padding-bottom:20px;">
          <div class="control-group">
            <label class="control-label">NIK</label>
            <div class="controls">
              <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">NAMA</label>
            <div class="controls">
              <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">No Handphone</label>
            <div class="controls">
              <input type="text" name="telpon_seluler" id="telpon_seluler" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">No. Pembiayaan</label>
            <div class="controls">
              <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
            </div> 
          </div>
          <div class="control-group">
            <label class="control-label">Jumlah Pembiayaan</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="jumlah_pembiayaan" id="jumlah_pembiayaan" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Biaya Administrasi</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="biaya_administrasi" id="biaya_administrasi" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Biaya Notaris</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="biaya_notaris" id="biaya_notaris" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Biaya Asuransi</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="biaya_asuransi" id="biaya_asuransi" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Kewajiban ke Koptel</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="kewajiban_koptel" id="kewajiban_koptel" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Kewajiban ke Kopegtel</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="kewajiban_kopegtel" id="kewajiban_kopegtel" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div> 
          <div class="control-group">
            <label class="control-label">Angsuran Pertama</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="angsuran_pertama" id="angsuran_pertama" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>  
          <div class="control-group">
            <label class="control-label">Jumlah Koptel Transfer</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">Rp</span>
                <input type="text" name="jumlah_transfer" id="jumlah_transfer" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
              </div>
            </div>
          </div>          
          <div class="control-group">
            <label class="control-label">Rekening</label>
            <div class="controls">
               <div class="input-prepend">
                 <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Bank</span>
                 <input type="text" class="medium m-wrap" name="rek_bank" id="rek_bank" readonly="" style="background:#f5f5f5">
               </div>
            </div>
          </div> 
          <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
               <div class="input-prepend">
                 <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                 <input type="text" class="medium m-wrap" name="rek_cabang" id="rek_cabang" maxlength="100" readonly="" style="background:#f5f5f5">
               </div>
            </div>
          </div>      
          <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
               <div class="input-prepend">
                 <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                 <input type="text" class="medium m-wrap" name="rek_no" id="rek_no" readonly="" style="background:#f5f5f5">
               </div>
            </div>
          </div>   
          <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
               <div class="input-prepend">
                 <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Atas Nama</span>
                 <input type="text" class="medium m-wrap" name="rek_atasnama" id="rek_atasnama" readonly="" style="background:#f5f5f5">
               </div>
            </div>
          </div>    
          <div class="control-group">
            <label class="control-label">Tanggal Transfer<span class="required">*</span></label>
            <div class="controls">
              <input type="text" name="tanggal_transfer" id="tanggal_transfer" data-required="1" class="small m-wrap" placeholder="DD/MM/YYYY" readonly="readonly" style="background:#f5f5f5" />
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
        </div>
        <div class="form-actions">
           <button type="submit" class="btn purple" id="register">Verifikasi</button>
           <button type="button" class="btn red" id="cancel">Cancel</button>
        </div>
      </form>
      <!-- END FORM-->
    </div>
  </div>
</div>
<!-- END EDIT USER -->

  

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/fnReloadAjax.js" type="text/javascript"></script> 
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
      $(".mask-date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
table = $('#transfer_pencairan').dataTable({
  "bProcessing": true,
  "bServerSide": true,
  "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_transfer_pencairan",
  "fnServerParams": function ( aoData ) {
      aoData.push( { "name": "product_code", "value": $("#product_code").val() } );
  },

  "aLengthMenu": [
      [15, 20, -1],
      [15, 20, "All"] // change per page values here
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
          'aTargets': [7]
      }
  ]
});
$(function(){

jQuery('#transfer_pencairan .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
jQuery('#transfer_pencairan .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

$("#product_code").change(function(){
  table.fnReloadAjax(); 
})

$('a#link-verifikasi').live('click',function(){
  $('#add').show();
  $('#wrapper-table').hide();
  cif_no = $(this).data('cif_no');
  account_financing_no = $(this).data('account_financing_no');
  $.ajax({
    type:"POST",dataType:"json",data:{account_financing_no:account_financing_no},
    url:site_url+'rekening_nasabah/get_data_registrasi_transfer_pencairan',
    success:function(response) {
      $('#nik').val(response.cif_no)
      $('#nama').val(response.nama)
      $('#no_pembiayaan').val(response.account_financing_no)
      $('#jumlah_pembiayaan').val(number_format(response.pokok,0,',','.'))
      $('#biaya_administrasi').val(number_format(response.biaya_administrasi,0,',','.'))
      $('#biaya_notaris').val(number_format(response.biaya_notaris,0,',','.'))
      $('#biaya_asuransi').val(number_format(response.biaya_asuransi_jiwa,0,',','.'))
      $('#kewajiban_koptel').val(number_format(response.kewajiban_koptel,0,',','.'))
      $('#kewajiban_kopegtel').val(number_format(response.kewajiban_kopegtel,0,',','.'))
      $('#angsuran_pertama').val(number_format(response.angsuran_pertama,0,',','.'))
      $('#jumlah_transfer').val(number_format(response.jumlah_transfer,0,',','.'))
      $('#rek_bank').val(response.nama_bank)
      $('#rek_cabang').val(response.bank_cabang)
      $('#rek_no').val(response.no_rekening)
      $('#rek_atasnama').val(response.atasnama_rekening)
      $('#tanggal_transfer').val(App.ToDatePicker(response.tanggal_transfer))
      $('#telpon_seluler').val(response.telpon_seluler)
    }
  })
});

$('#form').validate({
  errorElement: 'span', //default input error message container
  errorClass: 'help-inline', // default input error message class
  focusInvalid: false, // do not focus the last invalid input
  errorPlacement: function(error,element){},
  invalidHandler: function (event, validator) { //display error alert on form submit              
      $('.alert-success').hide();
      $('.alert-error').show();
      App.scrollTo($('.alert-error'), -200);
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
  submitHandler: function (form) {
    var account_cash_code = $('#account_cash_code').val();
    if (account_cash_code!="") {
      $.ajax({
        type:"POST",dataType:"json",data:$('#form').serialize()
        ,url: site_url+'rekening_nasabah/do_verifikasi_transfer_pencairan',
        success:function(response) {
          if (response.success===true) {
            $.alert({
              title:"Sukses",icon:'icon-check',backgroundDismiss:false,
              confirmButtonClass:'btn green',content:'Verifikasi Transfer Pencairan SUKSES',
              confirm:function() {
                table.fnReloadAjax();          
                $('.alert-success').hide();
                $('.alert-error').hide();
                $('#wrapper-table').show();
                $('#add').hide();
                App.scrollTo($('#wrapper-table'), -200);
                $('#account_cash_code').val('').trigger("liszt:updated");
                $('#form').trigger('reset');
              }
            })
          }else{
            App.WarningAlert(response.message);
          }
        },
        error: function() {
          App.WarningAlert('Failed to connect into databases, please contact your administrator.');
        }
      })
    } else {
      App.WarningAlert('Mohon Pilih Kas/Bank.');
    }
  }
});
//  END FORM EDIT VALIDATION

$('#cancel').click(function(){
  $('#wrapper-table').show();
  $('#add').hide();
  App.scrollTo($('#wrapper-table'), -200);
  $('#form').trigger('reset');
})

});

</script>
<!-- END JAVASCRIPTS -->
