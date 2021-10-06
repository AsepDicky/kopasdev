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
        <h3 class="page-title">Percepatan Pelunasan <small>Percepatan Pelunasan Angsuran</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Percepatan Pelunasan</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>Percepatan Pelunasan</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="<?php echo site_url('transaction/do_upload_percepatan_pelunasan'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
                <div class="alert alert-error hide">
                    <button class="close" data-dismiss="alert"></button>
                    You have some form errors. Please check below.
                </div>
                <div id="file_baru">
                  <div class="control-group">
                      <label class="control-label">Load File</label>
                      <div class="controls">
                          <input type="file" id="userfile" name="userfile"/>
                          <p class="help-block"></p>
                      </div>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tanggal Transaksi <span class="required">*</span></label>
                    <div class="controls">
                      <input type="text" class="date-picker maskdate small m-wrap" name="trx_date" id="trx_date" value="<?php echo '25/'.date('m/Y',strtotime($v_periode_awal)) ?>">
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
                    <label class="control-label"></label>
                    <div class="controls">
                        <button type="submit" id="upload" class="btn green"><i class="icon-upload"></i> <span>Proses</span></button>
                    </div>
                </div>
                <hr>
                <div class="control-group">
                   <label class="control-label">Formula</label>
                   <div class="controls">
                      <select class="m-wrap large chosen" id="formula_base" name="formula_base">
                        <option value="">PILIH Formula</option>
                        <option value="A">Saldo Pokok + Saldo Margin</option>
                        <option value="B">Hanya Saldo Pokok</option>
                        <option value="C">Saldo Pokok + Angsuran Margin (FLAT)</option>
                        <option value="D">Saldo Pokok + Angsuran Margin selanjutnya (EFEKTIF)</option>
                        <option value="E">Saldo Pokok + Angsuran Margin terakhir (EFEKTIF)</option>
                        <option value="F">Smile lunas bayar lebih</option>
                        <option value="G">Smile lunas bayar kurang</option>
                      </select>
                   </div>
                </div>
                <hr>
            </form>
            <!-- END FORM-->            
        </div>
      <div class="portlet-body form">
        <div class="append-bu" style="float:right;margin-right:10px;">
          <a href="<?= base_url() ?>assets/template_excel/DATA_TEMPLETE_PELUNASAN.xlsx" download class="btn yellow" style="padding:7px 10px;margin-right:5px">
              Download Template
          </a>
          <button id="delete_trx" class="btn red" style="font-size:13px;">Delete Pelunasan</button>
          <button id="save_trx" class="btn blue" style="font-size:13px;">Save Pelunasan</button>
        </div>
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_pelunasan_angsuran"></table>
                <div id="jqGridPager_pelunasan_angsuran"></div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- END FORM ADD -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js" type="text/javascript"></script>     
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
$(function(){
  App.init(); // initlayout and core plugins

  $('#formula_base').change(function(){
    $('#jqGrid_pelunasan_angsuran').trigger( 'reloadGrid' );
    show_table();
  });

  show_table();

  function show_table()
  {
    $("#jqGrid_pelunasan_angsuran").jqGrid({
        url: site_url+'transaction/jqgrid_pelunasan_angsuran',
        mtype: "GET",
        datatype: "json",
        postData: { formula_base: function () { return $("#formula_base").val(); } },
        colModel: [
            { label: 'ID', name: 'excel_id', key: true, width: 100, hidden:true },
            { label: 'No Pembiayaan', name: 'account_financing_no', width: 80, align:'center' },
            { label: 'NIK', name: 'nik', width: 80, align:'center' },
            { label: 'Nama Pegawai', name: 'nama', width: 220, align:'left' },
            { label: 'Produk', width: 120, align:'left' },
            { label: 'Saldo Pokok', name: 'saldo_pokok', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
            { label: 'Saldo Margin', name: 'saldo_margin', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
            { label: 'Bayar Seharusnya', name: 'bayar_seharusnya', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
            { label: 'Total Bayar', name: 'total_bayar', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' }}
        ],
        viewrecords: true,
        autowidth: true,
        height: "250",
        rowNum: 999999999,
        rownumbers: true,
        shrinkToFit: false,
        toolbar: [false, "top"],
        multiselect: false,
        footerrow: true,
        gridComplete: function() {
            var $grid = $('#jqGrid_pelunasan_angsuran');
            var ColSaldo_pokok = $grid.jqGrid('getCol', 'saldo_pokok', false, 'sum');
            var ColSaldo_margin = $grid.jqGrid('getCol', 'saldo_margin', false, 'sum');
            var ColTotal_bayar = $grid.jqGrid('getCol', 'total_bayar', false, 'sum');
            $grid.jqGrid('footerData', 'set', { 'saldo_pokok': ColSaldo_pokok });
            $grid.jqGrid('footerData', 'set', { 'saldo_margin': ColSaldo_margin });
            $grid.jqGrid('footerData', 'set', { 'total_bayar': ColTotal_bayar });
        },
        pager: "#jqGridPager_pelunasan_angsuran"
    });
  }

  var FormAdd = $("#FormAdd"), alert_error = $('.alert-error')
      progress = $('.progress'), 
      bar = $('.bar'), 
      percent = $('.percent');

  FormAdd.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      errorPlacement: function(a,b){},
      rules: {
          trx_date:{required:true}
      },
      invalidHandler: function (event, validator) { //display error alert on form submit              
          alert_error.show();
          App.scrollTo(alert_error, -200);
      },
      highlight: function (element) { // hightlight error inputs
          $(element).closest('.form-group').removeClass('success').addClass('error'); // set error class to the control group
      },
      unhighlight: function (element) { // revert the change dony by hightlight
          $(element).closest('.form-group').removeClass('error'); // set error class to the control group
      },
      submitHandler: false,
      submitHandler: function (form) {
          $('#upload').attr('disabled',true);
          dontBlock = true
          var userfile = $("#userfile").val();
          var keterangan = $("#keterangan").val();
          
          if(userfile==""){
            App.WarningAlert("Mohon lengkapi file !");
            $('#upload').attr('disabled',false);
          }else{
            FormAdd.ajaxSubmit({
              dataType: 'json', 
              beforeSend: function() {
                  $('#upload').html('<i class="icon-spinner icon-spin"></i> <span>0%</span>');
              },
              uploadProgress: function(event, position, total, percentComplete) {
                  if (percentComplete>99) {
                      percentComplete=99;
                  }
                  $('#upload span').html(''+percentComplete+'%');
              },
              cache:false,
              success: function(response) {
                  $('#upload').html('<i class="icon-upload"></i> Upload');
                  $('#upload').attr('disabled',false);
                  if (response.success==true) {
                      $("#jqGrid_pelunasan_angsuran").trigger('reloadGrid');        
                  } else {
                      App.WarningAlert(response.error);
                  }

              },
              error: function(){
                  App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                  $('#upload').html('<i class="icon-upload"></i> Upload');
                  $('#upload').attr('disabled',false);
              }
            });
          }
      }
  });

  $("#delete_trx").click(function(e){
    var conf = confirm('Are you sure to delete this ?');
    if(conf){
      $.blockUI({ message: '<div style="padding:5px 0;">Deleting.. Please Wait...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} })

      $.ajax({
        type:"GET",
        dataType: "json",
        url: site_url+'transaction/delete_upload_percepatan_pelunasan',
        error: function(){
          $.unblockUI
          App.WarningAlert("Failed to Conenct into Databases !");
        },
        success: function(response){
          $.unblockUI
          if(response.success==true){
            var content_alert = "Data Berhasil di hapus!";
            
            $.alert({
              title:"Success",icon:'icon-check',backgroundDismiss:false,
              content:content_alert,
              confirmButtonClass:'btn green',
              confirm:function(){
                location.reload(true);
              }
            })
          }else if(response.success==false){
            App.WarningAlert(response.message);
            // location.reload(true);
          }else{
            App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
            // location.reload(true);
          }
        },
        error: function(){
          App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
          // location.reload(true);
        }
      });
    }

  })

  /*Simpan Lunas*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    selrow = $("#jqGrid_pelunasan_angsuran").jqGrid('getGridParam','selrow');
    data   = $("#jqGrid_pelunasan_angsuran").jqGrid('getRowData');
    
    var excel_id = data.excel_id;
    var nik = [];
    var nama = [];
    var total_bayar = [];
    var bayar_seharusnya = [];
    var account_financing_no = [];
    for($i=0;$i<data.length;$i++){
      nik[$i] = data[$i].nik;
      nama[$i] = data[$i].nama;
      total_bayar[$i] = data[$i].total_bayar;
      bayar_seharusnya[$i] = data[$i].bayar_seharusnya;
      account_financing_no[$i] = data[$i].account_financing_no;
    }

    var account_cash_code = $("#account_cash_code").val();    
    var trx_date = $("#trx_date").val();    
    var formula_base = $("#formula_base").val();  	
    var tanggal_transaksi = $('#trx_date').val().split('/');
  	var day_trx_date = tanggal_transaksi[0];
  	var month_trx_date = tanggal_transaksi[1];
  	var year_trx_date = tanggal_transaksi[2];
  	var from_date = '<?php echo $year_periode_awal ?>-<?php echo $month_periode_awal ?>-<?php echo $day_periode_awal ?>';
  	var to_date = '<?php echo $year_periode_akhir ?>-<?php echo $month_periode_akhir ?>-<?php echo $day_periode_akhir ?>';
  	var tanggal_transaksi = year_trx_date+'-'+month_trx_date+'-'+day_trx_date;

    if(trx_date==""){
      App.WarningAlert("Isi Tanggal Transaksi !");
      $('#upload').attr('disabled',false);
    } else if(account_cash_code==""){
      App.WarningAlert("Isi Kas/Bank !");
      $('#upload').attr('disabled',false);
    } else if(tanggal_transaksi < from_date || tanggal_transaksi > to_date){
      App.WarningAlert('Tanggal Transaksi di luar Periode Transaksi!');
      $('#upload').attr('disabled',false);
    }else{
      dontBlock = true;
      $.blockUI({ message: '<div style="padding:5px 0;">Saving.. Please Wait...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} })
      $.ajax({
        type:"POST",
        dataType: "json",
        data:{nik:nik,total_bayar:total_bayar,bayar_seharusnya:bayar_seharusnya,nama:nama,trx_date:trx_date,formula_base:formula_base,account_cash_code:account_cash_code,account_financing_no:account_financing_no},
        url: site_url+'transaction/process_pelunasan_angsuran',
        error: function(){
          $.unblockUI
          App.WarningAlert("Failed to Conenct into Databases !");
        },
        success: function(response){
          $.unblockUI
          if(response.success==true){
            var content_alert = "Proses Pelunasan SUKSES.";
            var excel_id = response.excel_id;
            
            if (response.is_unins>0) {
              content_alert += "<br>";
              content_alert += "<br>";
              content_alert += "Nik Tidak Terlunas, Total Bayar tidak cocok : <strong>("+response.is_unins+")</strong>";
              content_alert += "<br>";
              content_alert += "<strong><a id='download' href='"+site_url+"transaction/export_nik_unins_lunas/"+excel_id+"' target='_blank'>Download NIK</a></strong>";
              window.location.href=site_url+"transaction/export_nik_unins_lunas/"+excel_id;
              
              content_alert += "<br>";
              content_alert += "<br>";
            }

            $.alert({
              title:"Success",icon:'icon-check',backgroundDismiss:false,
              content:content_alert,
              confirmButtonClass:'btn green',
              confirm:function(){
                location.reload(true);
              }
            })
          }else if(response.success==false){
            App.WarningAlert(response.message);
          }else{
            App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
          }
        },
        error: function(){
          App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
        }
      });
    }
  })
});
</script>