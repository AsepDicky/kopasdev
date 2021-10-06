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
      Transaksi <small>Denda Angsuran Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
        <li><i class="icon-home"></i> <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a> <i class="icon-angle-right"></i></li>
        <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
        <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Denda Angsuran Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog-finance" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- BEGIN ADD  -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Transaksi Denda Angsuran Pembiayaan</div>
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
               Transaksi Denda Angsuran Pembiayaan Berhasil.
            </div>
            <div class="control-group">
                <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee"/>
                    <a id="browse-finance" class="btn blue" data-toggle="modal" href="#dialog-finance">...</a>
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
                  <input name="product_name" id="product_name" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                    <span class="add-on">Rp</span>
                      <input name="pokok" id="pokok" type="text" data-required="1" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;width:50px;"/>
                  <input name="periode_jangka_waktu" id="periode_jangka_waktu" data-required="1" type="text" class="m-wrap small" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Akad<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_akad" id="tanggal_akad" type="text" data-required="1" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jatuh Tempo Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input name="jtempo_angsuran_next" id="jtempo_angsuran_next" type="text" data-required="1" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="saldo_pokok" id="saldo_pokok" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="saldo_margin" id="saldo_margin" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Angsuran Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="angsuran_pokok" id="angsuran_pokok" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Angsuran Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="angsuran_margin" id="angsuran_margin" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Angsuran Catab<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="angsuran_catab" id="angsuran_catab" data-required="1" type="text" class="small m-wrap mask-money" style="background-color:#eee;" readonly="" />
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <h3 class="form-section">Denda</h3>
            <div class="control-group">
               <label class="control-label">Saldo Tabungan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="saldo_memo" id="saldo_memo" data-required="1" type="text" class="small m-wrap mask-money" readonly="" style="background-color:#eee"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <input name="trx_date" id="trx_date" type="text" data-required="1" class="small m-wrap date-picker maskdate" placeholder="dd/mm/yyyy"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Denda<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                    <input name="nominal_denda" id="nominal_denda" data-required="1" type="text" class="small m-wrap mask-money"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 
            <input type="hidden" name="counter_angsuran" id="counter_angsuran">
            <input type="hidden" name="account_saving_no" id="account_saving_no">
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
        </form>
        <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD  -->


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
    
      $(".maskdate").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

/* BEGIN FUNCTIONS */
$(function(){

var ToDatePicker = function(date){
    var Sdate = date.split('-');
    var date =  Sdate[2]+'/'+Sdate[1]+'/'+Sdate[0];
    return date;
}
/* begin dialog-finance */
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
           option += '<option value="'+response[i].account_financing_no+'">'+response[i].account_financing_no+' - '+response[i].nama+'</option>';
        }
        $("#result").html(option);
      }
    });
  }
});
$("#select").click(function(){
    var account_financing_no = $("#result").val();
    $("#close","#dialog-finance").trigger('click');
    $("#account_financing_no").val(account_financing_no);
    $.ajax({
        type:"POST",dataType:"json",data:{account_financing_no:account_financing_no},
        url:site_url+'rekening_nasabah/get_account_financing',
        success: function(response){
            var periode_jangka_waktu = '';
            switch(response.periode_jangka_waktu) {
                case "0":
                periode_jangka_waktu = 'Hari';
                break;
                case "1":
                periode_jangka_waktu = 'Minggu';
                break;
                case "2":
                periode_jangka_waktu = 'Bulan';
                break;
                case "3":
                periode_jangka_waktu = 'Jatuh Tempo';
                break;
            }

            $('#nama').val(response.nama)
            $('#product_name').val(response.product_name)
            $('#pokok').val(number_format(response.pokok,0,',','.'))
            $('#margin').val(number_format(response.margin,0,',','.'))
            $('#jangka_waktu').val(response.jangka_waktu)
            $('#periode_jangka_waktu').val(periode_jangka_waktu)
            $('#tanggal_akad').val(ToDatePicker(response.tanggal_akad))
            $('#jtempo_angsuran_next').val(ToDatePicker(response.jtempo_angsuran_next))
            $('#saldo_pokok').val(number_format(response.saldo_pokok,0,',','.'))
            $('#saldo_margin').val(number_format(response.saldo_margin,0,',','.'))
            $('#angsuran_pokok').val(number_format(response.angsuran_pokok,0,',','.'))
            $('#angsuran_margin').val(number_format(response.angsuran_margin,0,',','.'))
            $('#angsuran_catab').val(number_format(response.angsuran_catab,0,',','.'))
            $('#counter_angsuran').val(response.counter_angsuran)
            $('#account_saving_no').val(response.account_saving_no)
            $('#saldo_memo').val(number_format(response.saldo_memo,0,',','.'))
        }
    })
});
$("#result option").live('dblclick',function(){
    $("#select").trigger('click');
});
/* end dialog-finance */

$('#nominal_denda').change(function(){

})

var form1 = $('#form_add');
var error1 = $('.alert-error', form1);
var success1 = $('.alert-success', form1);

form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    rules: {
        trx_date: {required: true},
        nominal_denda: {required: true}
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },
    highlight: function (element) { // hightlight error inputs
        $(element).closest('.help-inline').removeClass('ok'); // display OK icon
        $(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).closest('.control-group').removeClass('error'); // set error class to the control group
    },
    success: function (label) {
        if (label.closest('.input-append').length==0) {
            label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
            .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
        } else {
            label.closest('.control-group').removeClass('error').addClass('success')
            label.remove();
        }
    },
    submitHandler: function (form) {
        nominal_denda = convert_numeric($('#nominal_denda').val());
        saldo_memo = convert_numeric($('#saldo_memo').val());
        if (nominal_denda>saldo_memo) {
            alert("Nominal Denda melebihi Saldo Rekening!");
        } else {
            $.ajax({
                type: "POST",
                url: site_url+"transaction/do_penalty_charge_finance",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                    if(response.success==true){
                        alert('Transaksi Denda Angsuran Pembiayaan Berhasil.');
                        success1.show();
                        error1.hide();
                        form1.trigger('reset');
                        form1.find('.control-group').removeClass('success');
                        $("#account_financing_no").focus();
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
    }
});


});
/* END FUNCTIONS */
</script>
<!-- END JAVASCRIPTS -->

