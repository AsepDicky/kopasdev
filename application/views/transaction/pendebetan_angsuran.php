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
        Pendebetan Angsuran Pembiayaan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_list_pelunasan" class="modal hide fade" tabindex="-1" data-width="700" style="margin-top: -250px; width:750px; margin-left:-380px;" data-keyboard="false" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>List Pelunasan Pembiayaan</h3>
  </div>
  <div class="modal-body">
    <div style="overflow:auto;height:300px;">
      <div class="alert alert-warning" id="warning"></div>
      <form id="frm_print_pdf_list_pelunasan" method="post" target="_blank" action="<?php echo site_url('laporan_to_pdf/list_pelunasan_pendebetan_angsuran') ?>">
        <input type="hidden" id="lp_tanggal" name="lp_tanggal">
        <table data-toggle="table" style="border:solid 1px #CCC;width:100%;" cellpadding="5">
          <thead>
            <tr>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">No</th>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">No.Account</th>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Nama</th>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Angsuran</th>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Saldo Pokok</th>
              <th style="background:#F5F5F5;font-size:12px;border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;" align="center">Saldo Margin</th>
              <th style="background:#F5F5F5;font-size:12px;border-bottom:solid 1px #CCC;" align="center">Saldo Tabungan</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </form>
    </div>
  </div>
  <div class="modal-footer">
      <button type="button" id="btn_print_pdf_list_pelunasan" class="btn green">Print PDF</button>
      <button type="button" id="close" data-dismiss="modal" class="btn red">Close</button>
   </div>
</div>
<a href="#dialog_list_pelunasan" id="open_dialog_list_pelunasan" style="display:none;" data-toggle="modal">open</a>

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
  <div class="portlet-body form">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>
    <div class="alert alert-success hide">
       Pendebetan Sukses !
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

        <table>
          <tr>
            <td width="200">Kantor Cabang</td>
            <td>
              <input type="text" name="branch" tabindex="1" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background-color:#DDD;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
              <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
          <tr>
            <td width="200" valign="top">Tanggal Jatuh Tempo</td>
            <td valign="top"><input type="text" name="tanggal_jto" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y'); ?>" class="date-picker mask_date" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
          </tr>
          <tr>
            <td></td>
            <td>
               <button type="submit" tabindex="12" class="btn green search" id="search">Filter</button>
            </td>
          </tr>
        </table>
      </form>

      <form method="post" id="pendebetan">
        <table>
          <tr>
            <td width="200">Tanggal Transaksi</td>
            <td>
              <input type="text" id="tanggal_transaksi" name="tanggal_transaksi" placeholder="dd/mm/yyyy" value="<?php echo $current_date ?>" class="date-picker mask_date" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
            </td>
          </tr>
        </table>

        <div style="overflow:hidden;">
          <p><hr style="margin-top:0;"></p>
        </div>

        <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
        <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
        <input type="hidden" name="tanggal_jto2" value="<?php echo $current_date; ?>">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="16%">No. Account</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Nama</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="13%">Angsuran</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="12%">TGL <br> Angsuran</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="7%">JTO <br> Angsuran</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="13%">Pembayaran</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="13%">Saldo Tabungan</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		
              	</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              	
              <tr>
            </tbody>
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
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){

  /*BTN PRINT PDF LIST PELUNASAN*/
  $("#btn_print_pdf_list_pelunasan").click(function(){
    $("#frm_print_pdf_list_pelunasan").submit();
  });

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
    if(result_code!=null)
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

      $("input[name='tanggal_jto2']").val($("input[name='tanggal_jto']").val());

      error1.hide();
      var branch_code = $("input[name='branch_code']").val();
      var tanggal_jto = $("input[name='tanggal_jto2']").val();
      $.ajax({
        url: site_url+"transaction/ajax_get_data_pendebetan_angsuran_pembiayaan",
        type: "POST",
        dataType: "json",
        data: { branch_code : branch_code, tanggal_jto : tanggal_jto },
        async: false,
        success: function(response){
          
          html = '';
          for(i = 0 ; i < response.length ; i++)
          {
            angsuran=response[i].angsuran;
            sisa_freq_bayar=response[i].jangka_waktu-response[i].counter_angsuran;
            freq_bayar=response[i].freq_bayar;
            if(freq_bayar>sisa_freq_bayar){
              freq_bayar=sisa_freq_bayar;
            }
            pembayaran=(angsuran*freq_bayar);
            saldo_tabungan=response[i].saldo_tabungan;
            if(pembayaran>saldo_tabungan){
              //saldo tidak cukup
              freq_bayar=parseInt(saldo_tabungan/angsuran);
              pembayaran=angsuran*freq_bayar;
            }
            // jika non reguler
            if(response[i].flag_jadwal_angsuran==0){
              pembayaran=response[i].pembayaran_schedulle;
              freq_bayar=response[i].freq_bayar_schedulle;
            }
            jtempo_angsuran_next = response[i].jtempo_angsuran_next;
            s=jtempo_angsuran_next.split('-');
            jtempo_angsuran_next = s[2]+'/'+s[1]+'/'+s[0];
            
            html += '<tr> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" id="account_financing_no" readonly name="account_financing_no[]" value="'+response[i].account_financing_no+'" style="width:auto;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="left" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;"> \
                        '+response[i].nama+' \
                        <input type="hidden" id="nama" name="nama[]" value="'+response[i].nama+'"> \
                        <input type="hidden" id="jangka_waktu" name="jangka_waktu[]" value="'+response[i].jangka_waktu+'"> \
                        <input type="hidden" id="counter_angsuran" name="counter_angsuran[]" value="'+response[i].counter_angsuran+'"> \
                        <input type="hidden" id="angsuran_pokok" name="angsuran_pokok[]" value="'+parseFloat(response[i].angsuran_pokok)+'"> \
                        <input type="hidden" id="angsuran_margin" name="angsuran_margin[]" value="'+parseFloat(response[i].angsuran_margin)+'"> \
                        <input type="hidden" id="angsuran_tabungan" name="angsuran_tabungan[]" value="'+response[i].angsuran_tabungan+'"> \
                        <input type="hidden" id="saldo_pokok" name="saldo_pokok[]" value="'+response[i].saldo_pokok+'"> \
                        <input type="hidden" id="saldo_margin" name="saldo_margin[]" value="'+response[i].saldo_margin+'"> \
                        <input type="hidden" id="pokok" name="pokok[]" value="'+response[i].pokok+'"> \
                        <input type="hidden" id="margin" name="margin[]" value="'+response[i].margin+'"> \
                        <input type="hidden" id="saldo_catab" name="saldo_catab[]" value="'+response[i].saldo_catab+'"> \
                        <input type="hidden" id="jtempo_angsuran_next" name="jtempo_angsuran_next[]" value="'+response[i].jtempo_angsuran_next+'"> \
                        <input type="hidden" id="flag_jadwal_angsuran" name="flag_jadwal_angsuran[]" value="'+response[i].flag_jadwal_angsuran+'"> \
                        <input type="hidden" id="counter_angsuran" name="counter_angsuran[]" value="'+response[i].counter_angsuran+'"> \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="angsuran[]" id="angsuran" readonly="readonly" value="'+number_format(response[i].angsuran,0,',','.')+'" style="text-align:right;background:#EEEEEE;width:auto;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="jtempo_angsuran_next[]" id="jtempo_angsuran_next" readonly="readonly" value="'+(jtempo_angsuran_next)+'" style="text-align:center;background:#EEEEEE;width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="jto_angsuran[]" id="jto_angsuran" readonly value="'+freq_bayar+'" style="text-align:center;width:40px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="pembayaran[]" id="pembayaran" readonly="readonly" value="'+number_format(pembayaran,0,',','.')+'" style="text-align:right;background:#EEEEEE;width:auto;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="saldo_tabungan[]" id="saldo_tabungan" readonly="readonly" value="'+number_format(saldo_tabungan,0,',','.')+'" style="text-align:right;background:#EEEEEE;width:auto;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                        <a href="javascript:void(0);" id="yes" style="display:none;" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
                        <a href="javascript:void(0);" id="cancel" data-flag_jadwal_angsuran="'+response[i].flag_jadwal_angsuran+'" name="cancel[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
                      </td> \
                    <tr> \
                    ';
          }

          $("#pendebetan #form tbody").html(html);
        }
      });
    }
  });

  $("input#jto_angsuran").live('keyup',function(){
    var obj_tr = $(this).parent().parent();
    var nama = obj_tr.find('#nama').val();
    var jto_angsuran = parseFloat($(this).val());
    var angsuran = parseFloat(convert_numeric(obj_tr.find("input#angsuran").val()));
    var jangka_waktu = parseFloat(convert_numeric(obj_tr.find("#jangka_waktu").val()));
    var counter_angsuran = parseFloat(convert_numeric(obj_tr.find("#counter_angsuran").val()));
    var angsuran_pokok = parseFloat(convert_numeric(obj_tr.find("#angsuran_pokok").val()));
    var angsuran_margin = parseFloat(convert_numeric(obj_tr.find("#angsuran_margin").val()));
    var angsuran_tabungan = parseFloat(convert_numeric(obj_tr.find("#angsuran_tabungan").val()));
    var saldo_pokok = parseFloat(convert_numeric(obj_tr.find("#saldo_pokok").val()));
    var saldo_margin = parseFloat(convert_numeric(obj_tr.find("#saldo_margin").val()));
    var pokok = parseFloat(convert_numeric(obj_tr.find("#pokok").val()));
    var margin = parseFloat(convert_numeric(obj_tr.find("#margin").val()));
    var saldo_catab = parseFloat(convert_numeric(obj_tr.find("#saldo_catab").val()));
    if(isNaN(angsuran)==true){angsuran=0}
    if(isNaN(jto_angsuran)==true){jto_angsuran=0}
    if(isNaN(jangka_waktu)==true){jangka_waktu=0}
    if(isNaN(counter_angsuran)==true){counter_angsuran=0}
    if(isNaN(angsuran_pokok)==true){angsuran_pokok=0}
    if(isNaN(angsuran_margin)==true){angsuran_margin=0}
    if(isNaN(angsuran_tabungan)==true){angsuran_tabungan=0}
    if(isNaN(saldo_pokok)==true){saldo_pokok=0}
    if(isNaN(saldo_margin)==true){saldo_margin=0}
    if(isNaN(pokok)==true){pokok=0}
    if(isNaN(margin)==true){margin=0}
    if(isNaN(saldo_catab)==true){saldo_catab=0}

    var total_angsuran_pokok=0;
    var sisa_freq_angsuran=jangka_waktu-counter_angsuran;
    var hit_saldo_pokok=saldo_pokok;
    var hit_saldo_margin=saldo_margin;
    var hit_saldo_tabungan=saldo_catab;
    if(jto_angsuran<=sisa_freq_angsuran)
    {
      for(i=0;i<jto_angsuran;i++){
        counter_angsuran++;
        if(jangka_waktu==counter_angsuran){
          angsuran_terakhir=hit_saldo_pokok+hit_saldo_margin+hit_saldo_tabungan;
          total_angsuran_pokok+=parseFloat(angsuran_terakhir);
        }else{
          total_angsuran_pokok+=parseFloat(angsuran);
        }
        hit_saldo_pokok-=Math.round(parseFloat(angsuran_pokok));
        hit_saldo_margin-=Math.round(parseFloat(angsuran_margin));
        hit_saldo_tabungan-=Math.round(parseFloat(angsuran_tabungan));
      }
      $(this).parent().parent().find("input#pembayaran").val(number_format(total_angsuran_pokok,0,',','.'));
    }
    else
    {
      alert("Angsuran a.n \""+nama+"\" Mencapai Maksimum.\nTersisa : "+sisa_freq_angsuran+"x Angsuran!");
      $(this).val(sisa_freq_angsuran).blur();
      var e = $.Event('keyup');
      $(this).trigger(e);
    }
    
  });

  $("a#yes").live('click',function(){
    pembayaran = parseFloat(convert_numeric($(this).parent().parent().find("input#pembayaran").val()));
    saldo_tabungan = parseFloat(convert_numeric($(this).parent().parent().find("input#saldo_tabungan").val()));
    if(pembayaran>saldo_tabungan){
      alert("Saldo Tabungan Tidak Mencukupi untuk melakukan Pembayaran.");
    }else{
      $(this).parent().parent().find("input#jto_angsuran").attr('readonly',true);
      $(this).hide();
      $(this).parent().parent().find("a#cancel").show();
    }
  });

  $("a#cancel").live('click',function(){
    var flag_jadwal_angsuran = $(this).data('flag_jadwal_angsuran');
    if(flag_jadwal_angsuran==0){ // non reguler
      alert("Angsuran Non Reguler Tidak Bisa di Ubah Frekuensinya!");
    }else{ // reguler
      $(this).parent().parent().find("input#jto_angsuran").attr('readonly',false);
      $(this).hide();
      $(this).parent().parent().find("a#yes").show();
    }
  });

  $("#save_trx").click(function(){
    bValid = true;
    $("a#yes").each(function(){
      if($(this).is(':visible')==true){
        bValid = false;
      }
    });

    objid=$("#tanggal_transaksi");
    trx_date = objid.val();
    day_trx_date = trx_date.substr(0,2);
    month_trx_date = trx_date.substr(2,2);
    year_trx_date = trx_date.substr(4,4);
    
    from_date = new Date(<?php echo $year_periode_awal ?>,<?php echo $month_periode_awal ?>-1,<?php echo $day_periode_awal ?>);
    to_date = new Date(<?php echo $year_periode_akhir ?>,<?php echo $month_periode_akhir ?>-1,<?php echo $day_periode_akhir ?>);
    trx_date = new Date(year_trx_date,month_trx_date-1,day_trx_date);



    if(trx_date >= from_date && trx_date <= to_date) {

      tanggal_transaksi = $("#tanggal_transaksi").val();
      
      day = tanggal_transaksi.substr(0,2);
      month = tanggal_transaksi.substr(2,2);
      year = tanggal_transaksi.substr(4,4);
      tanggal_transaksi = new Date(year, month-1,day);
      today = new Date();
      day2 = today.getDate();
      month2 = today.getMonth();
      year2 = today.getFullYear();
      today = new Date(year2, month2, day2);

      conf = true;
      if(tanggal_transaksi < today)
      {
        conf = confirm("Transaksi Backdate (tanggal transaksi lebih kecil dr tanggal hari ini) , lanjutkan?");
      }
      
      if(conf==true)
      {

        /*
        | BEGIN DIALOG PELUNASAN CASE
        | ------------------------------------------------------------------------
        */

        var pokok = 0;
        var angsuran_pokok = 0;
        var jto_angsuran = 0;
        var saldo_tabungan = 0;
        var i=0;
        var html = '';

        $("#pendebetan #form tbody #pokok").each(function(){
          obj_parent = $(this).parent().parent();
          pokok = parseFloat($(this).val());
          counter_angsuran = parseFloat(obj_parent.find('#counter_angsuran').val());
          angsuran_pokok = parseFloat(obj_parent.find('#angsuran_pokok').val());
          saldo_pokok = parseFloat(obj_parent.find('#saldo_pokok').val());
          saldo_margin = parseFloat(obj_parent.find('#saldo_margin').val());
          
          angsuran = parseFloat(convert_numeric(obj_parent.find('#angsuran').val()));
          saldo_tabungan = parseFloat(convert_numeric(obj_parent.find('#saldo_tabungan').val()));
          
          nama = obj_parent.find('#nama').val();
          account_financing_no = obj_parent.find('#account_financing_no').val();
          jtempo_angsuran_next = obj_parent.find('#jtempo_angsuran_next').val();
          
          jto_angsuran = parseFloat(obj_parent.find('#jto_angsuran').val());
          
          total_angsuran = jto_angsuran*angsuran;
          
          if(saldo_tabungan > total_angsuran){
            
            saldo_pokok_after = pokok-((counter_angsuran+jto_angsuran)*angsuran_pokok)
            
            if(saldo_pokok_after==0){
              
              i++;
              html += '<tr> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="center">'+i+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="left"><input type="hidden" name="lp_account_financing_no[]" value="'+account_financing_no+'">'+account_financing_no+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="left"><input type="hidden" name="lp_nama[]" value="'+nama+'">'+nama+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right"><input type="hidden" name="lp_angsuran[]" value="'+angsuran+'">'+number_format(angsuran,0,',','.')+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right"><input type="hidden" name="lp_saldo_pokok[]" value="'+saldo_pokok+'">'+number_format(saldo_pokok,0,',','.')+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;" align="right"><input type="hidden" name="lp_saldo_margin[]" value="'+saldo_margin+'">'+number_format(saldo_margin,0,',','.')+'</td> \
              <td style="font-size:11px; border-bottom:solid 1px #CCC;" align="right"><input type="hidden" name="lp_saldo_tabungan[]" value="'+saldo_tabungan+'">'+number_format(saldo_tabungan,0,',','.')+'</td> \
              </tr>';
              //console.log(i+'. '+account_financing_no+','+nama+','+angsuran+','+jtempo_angsuran_next+','+jto_angsuran+','+(jto_angsuran*angsuran)+','+saldo_tabungan);
              //console.log('rinci: pokok='+pokok+', | saldo: pokok='+saldo_pokok+' | angsuran : pokok='+angsuran_pokok+' , counter='+counter_angsuran+'+'+jto_angsuran);
              
            }
          }
          
        });        

        /*
        | END DIALOG PELUNASAN CASE
        | ------------------------------------------------------------------------
        */

        if ( i > 0 )
        {
          alert("Warning : Terdapat Nasabah Yg akan Lunas. Silahkan Lakukan Transaksi Pelunasan pada Nasabah Tersebut. Klik 'OK' utk Melihat Nasabah Yg akan Lunas.")
          lp_tanggal = $("input[name='tanggal_jto']").val();
          $("#warning","#dialog_list_pelunasan").html("Warning : Terdapat Nasabah Yg akan Lunas. Input Transaksi Nasabah dibawah ini melalu Modul Pelunasan. <br> Jumlah Nasabah Yg akan Pelunasan = <strong>"+i+"</strong> Nasabah.")
          $("#dialog_list_pelunasan table tbody").html(html);
          $("#open_dialog_list_pelunasan").trigger('click');
          $("#lp_tanggal").val(lp_tanggal);
          App.scrollTo(0,0);
        }
        else
        {

          if(bValid==true)
          {
            $.ajax({
              type: "POST",
              dataType: "json",
              data: $("#pendebetan").serialize(),
              url: site_url+"transaction/process_pendebetan_angsuran_pembiayaan",
              success: function(response){
                if(response.success===true){
                  alert("Pendebetan Angsuran Berhasil !");
                  $("#pendebetan #form tbody").html('<tr></tr>');
                  $(".search").trigger('click');
                }else{
                  alert("Pendebetan Angsuran Gagal");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Contact Your Administrator !");
              }
            });
          }
          else
          {
            alert("Ada inputan yang belum di selesaikan. proses tidak dapat dilanjutkan !");
          }

        }

      }
      else
      {
        $("#tanggal_transaksi").select();
      }

    }else{
      alert("Tidak bisa melakukan transaksi diluar tanggal periode");
      objid.focus();
    }
  });

  $("#cancel_trx").click(function(){
      $("#pendebetan tbody").html('<tr></tr>');
      $(".search").trigger('click');
  });

});
</script>