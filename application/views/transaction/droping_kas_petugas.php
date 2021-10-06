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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Droping Kas Petugas <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
  <div class="portlet-body form">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>
    <div class="alert alert-success hide">
       Pemindah Bukuan Sukses !
    </div>
      <form id="form_process" class="form-horizontal">

        <!-- DIALOG BRANCH -->
        <div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Kantor Cabang</h3>
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

        <!-- DIALOG CM -->
        <div id="dialog_cm" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Rembug Pusat</h3>
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

        <!-- DIALOG FA -->
        <div id="dialog_fa" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Field Assistant</h3>
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
        <table>
          <tr>
            <td width="120">Kantor Cabang</td>
            <td>
              <input type="text" name="branch" tabindex="1" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background-color:#DDDDDD;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
              <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
            <td width="50"></td>
            <td width="100">No. Referensi</td>
            <td><input type="text" name="no-referensi" tabindex="3" size="10" id="no_referensi" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
            <td></td>
          </tr>
          <tr>
            <td width="100" valign="top">Tanggal</td>
            <td valign="top"><input type="text" name="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
            <td width="50"></td>
            <td valign="top">Deskripsi</td>
            <td valign="top" width="260">
              <textarea id="deskripsi" name="deskripsi" tabindex="4" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea>
            </td>
            <td valign="bottom" style="padding-bottom:5px;"><button tabindex="5" class="btn green search">FILTER</button></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
        </table>
      </form>
            
      <p><hr></p>

      <form id="process_transaksi_jurnal" method="post">

        <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
        <input type="hidden" name="tanggal2" value="<?php echo $current_date; ?>">
        <input type="hidden" name="no_referensi2">
        <input type="hidden" name="deskripsi2">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="496px">KAS PETUGAS</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">JUMLAH</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">DESKRIPSI</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		<img src="<?php echo base_url('assets/img/yes.png'); ?>">
              	</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		<img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26">
              	</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              	
              <tr>
            </tbody>
            <tfoot>
              <tr>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<select id="account_def" tabindex="6" style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              			<option value="">&nbsp;</option>
              		</select>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<input type="text" tabindex="7" value="0" id="amount_def" style="width:200px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
              		<textarea id="description_def" tabindex="9" rows="1" style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">
              		<a href="javascript:void(0);" tabindex="10" id="yes_def"><img src="<?php echo base_url('assets/img/yes.png'); ?>"></a>
              	</td>
              	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">
              		<a href="javascript:void(0);" tabindex="11" id="no_def"><img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26"></a>
              	</td>
              <tr>
            </tfoot>
          </table>
      <!-- </div> -->
      </form>
      <div align="center" style="margin-top:20px;">
         <button type="submit" style="margin-right:20px;" tabindex="12" class="btn blue" id="save_trx">Save</button>
         <button type="reset" class="btn red" tabindex="13" id="cancel_trx">Cancel</button>
      </div>
  </div>
  <!-- END FORM-->

<!-- END PROSES PINBUK -->


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
     
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y", {autoUnmask: false});  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){

  $("input[name='tanggal']").change(function(){
    $("input[name='tanggal2']").val($(this).val());
  });
  $("input[name='no_referensi']").keyup(function(){
    $("input[name='no_referensi2']").val($(this).val());
  });
  $("input[name='deskripsi']").keyup(function(){
    $("input[name='deskripsi2']").val($(this).val());
  });

  $("#keyword","#dialog_branch").keypress(function(e){
    e.preventDefault();
    keyword = $(this).val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  });

  $("#select","#dialog_branch").click(function(){
    branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    result_code = $("#result","#dialog_branch").val();
    if(result!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("input[name='branch_id']").val(branch_id);
      $("#close","#dialog_branch").trigger('click');
    }
  });

  $("#result option","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  });

  var form1 = $('#form_process');
  var error1 = $('.alert-error');
  var success1 = $('.alert-success');

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error, element) {
      error.appendTo( element.parent(".controls") );
    },
    rules: {
         branch: 'required'
        ,tanggal: 'required'
        ,cm: 'required'
        ,fa: 'required'
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

  $(".search").click(function(e){
    e.preventDefault();
    if(form1.valid()===true)
    {

      $("input[name='tanggal2']").val($("input[name='tanggal']").val());
      $("input[name='no_referensi2']").val($("#no_referensi").val());
      $("input[name='deskripsi2']").val($("#deskripsi").val());

      error1.hide();
      var branch_code = $("#branch_code").val();
      $.ajax({
        url: site_url+"transaction/ajax_get_gl_account_cash",
        type: "POST",
        dataType: "json",
        data: { branch_code : branch_code },
        async: false,
        success: function(response){
          html = '<option selected></option>';

          for ( i = 0 ; i < response.length ; i++ )
          {
            html += '<option value="'+response[i].account_cash_code+'" account_cash_id="'+response[i].account_cash_id+'" fa_code="'+response[i].fa_code+'" account_cash_name="'+response[i].account_cash_name+'">('+response[i].account_cash_code+') '+response[i].account_cash_name+'</option>';
          }

          $("#account_def").html(html);
        }
      });
    }
  });

  $("a#yes").live('click',function(){

  	var account_copied = $("#account_def").html();
  	html = ' \
  	      <tr> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="hidden" name="account_code[]" id="account_code" value="0"> \
          		<input type="hidden" name="account_cash_id[]" id="account_cash_id" value="0"> \
          		<input type="hidden" name="fa_code[]" id="fa_code" value="0"> \
          		<input type="hidden" name="account_cash_name[]" id="account_cash_name" value="0"> \
          		<select id="account" name="account[]" style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+account_copied+'</select> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="text" id="amount" name="amount[]" style="width:200px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="0"> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<textarea id="description" name="description[]" rows="1" style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></textarea> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="save"><img src="<?php echo base_url("assets/img/save.gif"); ?>" width="26"/></a> \
              	<a href="javascript:void(0);" id="yes" style="display:none;" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="no" name="no[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
          	</td> \
          <tr>';

  	$(this).parent().parent().after(html);

  });

  $("a#save").live('click',function(){
    if($(this).parent().parent().find("#account").val()=="" || $(this).parent().parent().find("#amount")=="")
    {
      alert("Harap isi dengan benar!");
    }
    else
    {

      var account_def_option = $(this).parent().parent().find("#account option:selected");
      var account_code = account_def_option.val();
      var account_cash_id = account_def_option.attr('account_cash_id');
      var fa_code = account_def_option.attr('fa_code');
      var account_cash_name = account_def_option.attr('account_cash_name');

      $(this).parent().parent().find("#account_code").val(account_code);
      $(this).parent().parent().find("#account_cash_id").val(account_cash_id);
      $(this).parent().parent().find("#fa_code").val(fa_code);
      $(this).parent().parent().find("#account_cash_name").val(account_cash_name);

      $(this).parent().parent().find("#account").attr('disabled',true);
      $(this).parent().parent().find("#amount").attr('readonly',true);
      $(this).parent().parent().find("#description").attr('readonly',true);
      $(this).parent().find('#yes').show();
      $(this).remove();
    }
  });

  $("a#no").live('click',function(){
  	$(this).parent().parent().remove();
  });

  $("#no_def").click(function(){
  	$("#account_def").val('');
  	$("#amount").val('');
  	$("#description_def").val('');
  });

  $("#yes_def").click(function(){

  	var account_def = $("#account_def");
  	var amount = $("#amount_def");
  	var description_def = $("#description_def");
  	var account_copied = $("#account_def").html();
  	var account_def_option = $("select#account_def option:selected");
  	var account_code = account_def.val();
  	var account_cash_id = account_def_option.attr('account_cash_id');
  	var fa_code = account_def_option.attr('fa_code');
  	var account_cash_name = account_def_option.attr('account_cash_name');
	if( account_def.val()=="" || amount.val()=="" )
	{
		alert("Harap isi dengan benar!");
	}
	else
	{

  	html = ' \
  	      <tr> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="hidden" name="account_code[]" id="account_code" value="'+account_code+'"> \
          		<input type="hidden" name="account_cash_id[]" id="account_cash_id" value="'+account_cash_id+'"> \
          		<input type="hidden" name="fa_code[]" id="fa_code" value="'+fa_code+'"> \
          		<input type="hidden" name="account_cash_name[]" id="account_cash_name" value="'+account_cash_name+'"> \
          		<select id="account" name="account[]" disabled style="width:480px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+account_copied+'</select> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<input type="text" id="amount" name="amount[]" readonly style="width:200px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" value="'+amount.val()+'"> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;"> \
          		<textarea id="description" name="description[]" rows="1" readonly style="resize:none;height:20px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">'+description_def.val()+'</textarea> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="yes" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
          	</td> \
          	<td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
              	<a href="javascript:void(0);" id="no" name="no[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
          	</td> \
          <tr>';

  	$("#process_transaksi_jurnal tbody").append(html);
    $("select#account:last").val(account_def.val());
    $("#account_def").val('');
    $("#amount_def").val('');
  	$("#description_def").val('');

    }

  });

  $("#save_trx").click(function(){
    bValid = true;
    $("select#account").each(function(){
      if($(this).is(':disabled')==false){
        bValid = false;
      }
    });
    $("input#amount").each(function(){
      if($(this).attr('readonly')==undefined){
        bValid = false;
      }
    });
    $("textarea#description").each(function(){
      if($(this).attr('readonly')==undefined){
        bValid = false;
      }
    });

    if(bValid==true)
    {
      $.ajax({
        type: "POST",
        dataType: "json",
        data: $("#process_transaksi_jurnal").serialize(),
        url: site_url+"transaction/process_droping",
        success: function(response){
          if(response.success===true){
            alert(response.message);
            $("#process_transaksi_jurnal tbody").html('<tr></tr>');
          }else{
            alert(response.message);
          }
        }
      });
    }
    else
    {
      alert("Ada inputan yang belum di selesaikan. proses tidak dapat dilanjutkan !");
    }
  });

  $("#cancel_trx").click(function(){
      $("#process_transaksi_jurnal tbody").html('<tr></tr>');
      $(".search").trigger('click');
      $("#amount_def").val('0');
      $("#description_def").val('');
  });

});
</script>