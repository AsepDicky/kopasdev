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
        <h3 class="page-title">Pendebetan Angsuran <small>Pendebetan Angsuran</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Pendebetan Angsuran</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>Pendebetan Angsuran</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="<?php echo site_url('transaction/do_upload_pendebetan_angsuran'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
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
                    <label class="control-label">Keterangan <span class="required">*</span></label>
                    <div class="controls">
                      <input type="text" class="medium m-wrap" name="keterangan" id="keterangan">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <button type="submit" id="upload" class="btn green"><i class="icon-upload"></i> <span>Proses</span></button>
                    </div>
                </div>
            </form>
            <!-- END FORM-->            
        </div>
        <div class="portlet-body form">
          <div class="append-bu" style="float:right;margin-right:10px;">
            <a href="<?= base_url() ?>index.php/transaction/list_tagihan" target="_blank"><button class="btn blue" style="font-size:13px;">Check Tagihan</button></a>
            <button id="delete_trx" class="btn red" style="font-size:13px;">Delete Pendebetan</button>
            <button id="save_trx" class="btn green" style="font-size:13px;">Save Pendebetan</button>
        </div>
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_pendebetan_angsuran"></table>
                <div id="jqGridPager_pendebetan_angsuran"></div>
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

  $("#jqGrid_pendebetan_angsuran").jqGrid({
      url: site_url+'transaction/jqgrid_pendebetan_angsuran',
      mtype: "GET",
      datatype: "json",
      colModel: [
          { label: 'ID', name: 'angsuran_id', key: true, width: 100, hidden:true },
          { label: 'No Pembiayaan', name: 'account_financing_no', width: 80, align:'center' },
          { label: 'NIK', name: 'nik', width: 80, align:'center' },
          { label: 'Nama Pegawai', name: 'nama', width: 220, align:'left' },
          { label: 'Pokok', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Margin', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Produk', name: 'product_name', width: 150 },
          { label: 'Jumlah Angsuran', name: 'total_angsuran', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Realisasi Tagihan', name: 'hasil_proses', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
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
          var $grid = $('#jqGrid_pendebetan_angsuran');
          var colAngsuran = $grid.jqGrid('getCol', 'total_angsuran', false, 'sum');
          var colSum = $grid.jqGrid('getCol', 'hasil_proses', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'total_angsuran': colAngsuran });
          $grid.jqGrid('footerData', 'set', { 'hasil_proses': colSum });
      },
      pager: "#jqGridPager_pendebetan_angsuran"
  });

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
                      $("#jqGrid_pendebetan_angsuran").trigger('reloadGrid');        
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
        url: site_url+'transaction/delete_upload_pendebetan_angsuran',
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

  /*Simpan Debet*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    selrow = $("#jqGrid_pendebetan_angsuran").jqGrid('getGridParam','selrow');
    data   = $("#jqGrid_pendebetan_angsuran").jqGrid('getRowData');
    
    var angsuran_id = data.angsuran_id;
    var nik = [];
    var nama = [];
    var hasil_proses = [];
    var account_financing_no = [];
    for($i=0;$i<data.length;$i++){
      nik[$i] = data[$i].nik;
      nama[$i] = data[$i].nama;
      hasil_proses[$i] = data[$i].hasil_proses;
      account_financing_no[$i] = data[$i].account_financing_no;
    }

    var keterangan = $("#keterangan").val();
    var trx_date = $("#trx_date").val();
  	
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
    } else if(keterangan==""){
      App.WarningAlert("Isi Keterangan Transaksi !");
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
        data:{nik:nik,hasil_proses:hasil_proses,nama:nama,trx_date:trx_date,keterangan:keterangan,account_financing_no:account_financing_no},
        url: site_url+'transaction/process_pendebetan_angsuran_pembiayaan_koptel',
        error: function(){
          $.unblockUI
          App.WarningAlert("Failed to Conenct into Databases !");
        },
        success: function(response){
          $.unblockUI
          if(response.success==true){
            var content_alert = "Proses Pendebetan SUKSES.";
            var angsuran_id = response.angsuran_id;
            
            if (response.is_unins>0) {
              content_alert += "<br>";
              content_alert += "<br>";
              content_alert += "Nik non-debet : <strong>("+response.is_unins+")</strong>";
              content_alert += "<br>";
              content_alert += "<strong><a id='download' href='"+site_url+"transaction/export_nik_unins_angsuran/"+angsuran_id+"' target='_blank'>Download NIK</a></strong>";
              window.location.href=site_url+"transaction/export_nik_unins_angsuran/"+angsuran_id;
              
              content_alert += "<br>";
              content_alert += "<br>";

              if (response.is_canceled>0) {
                content_alert += "Pembiayaan dibatalkan : <strong>("+response.is_canceled+")</strong><br><small>* dikarenakan terdapat pembiayaan yang belum diverifikasi.</small>";
                content_alert += "<br>";
                content_alert += "<strong><a id='download1' href='"+site_url+"transaction/export_finance_canceled_angsuran/"+angsuran_id+"' target='_blank'>Download Pembiayaan Dibatalkan</a></strong>";
                window.location.href=site_url+"transaction/export_finance_canceled_angsuran/"+angsuran_id;
              }
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
});
</script>