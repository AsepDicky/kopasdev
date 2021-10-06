<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <!-- <h3 class="page-title">Migrasi</h3> -->
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    
    <div class="portlet box <?= $boxcolor ?>">
      <input type="hidden" id="filenameupload" value="<?= $filenameupload ?>">
      <input type="hidden" id="savefile" value="<?= $savefile ?>">
      <div class="portlet-title">
          <div class="caption"><i class="icon-upload"></i><?= $title ?> 2018</div>
      </div>
      
      <?php if($fileupload): ?>
      <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="<?php echo site_url('migrasi/do_upload_pengajuan_banmod'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
            <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert"></button>
                You have some form errors. Please check below.
            </div>
            <input type="hidden" id="flag" name="flag">
            <div id="file_baru">
              <div class="control-group">
                  <label class="control-label"><b>Upload File Pengajuan</b></label>
                  <div class="controls">
                      <input type="file" id="userfile" name="userfile"/>
                      <p class="help-block"></p>
                  </div>
                  <input type="hidden" name="userfilename" id="userfilename">
              </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <button type="submit" id="upload" class="btn yellow"><i class="icon-upload"></i> <span>Proses</span></button>
                </div>
            </div>
        </form>
        <!-- END FORM-->
      </div>
      <?php endif; ?>
      
      <div class="portlet-body form">
        
        <div class="append-bu" style="float:right;margin-right:10px;">
          <a href="<?= base_url() ?>assets/template_excel/DATA_TEMPLETE_BANMOD.xlsx" download class="btn blue" style="padding:7px 10px;margin-right:5px">
              Download Template Migrasi <i class="icon-cloud-download"></i>
          </a>

          <?= $button_save ?>
        </div>
        
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_pengajuan"></table>
                <div id="jqGridPager_pengajuan"></div>
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

  $(".page-sidebar").hide();

  $("#jqGrid_pengajuan").jqGrid({
      url: site_url+'migrasi/jqGrid_pengajuan_banmod',
      mtype: "GET",
      datatype: "json",
      postData:{
          file_name:function(){
            return $("#filenameupload").val();
          }
      },
      colModel: [
          { label: 'ID', name: 'kopegtel_code', key: true, width: 100, hidden:true },
          { label: 'Code', name: 'kopegtel_code', width: 80, align:'center' },
          { label: 'Kopegtel Name', name: 'kopegtel_name', width: 150, align:'left' },
          { label: 'Wilayah', name: 'wilayah', width: 80, align:'left' },
          { label: 'Alamat', name: 'alamat', width: 170, align:'left' },
          { label: 'Pejabat', name: 'pejabat', width: 120, align:'left' },
          { label: 'Jabatan', name: 'jabatan', width: 120, align:'left' },
          { label: 'NIK', name: 'nik', width: 95, align:'left' },
          { label: 'Deskripsi', name: 'deskripsi_ketua_pengurus', width: 200, align:'left' },
          { label: 'Email', name: 'email', width: 100, align:'left' },
          { label: 'No Tlpn', name: 'no_telpon', width: 95, align:'left' },
          { label: 'Kerjasama Channeling', name: 'status_chaneling', width: 95, align:'center' },
          { label: 'Nama Bank', name: 'nama_bank', width: 95, align:'left' },
          { label: 'Cabang Bank', name: 'bank_cabang', width: 95, align:'left' },
          { label: 'No. Rekening', name: 'nomor_rekening', width: 95, align:'left' },
          { label: 'Atas Nama', name: 'atasnama_rekening', width: 95, align:'left' },
          { label: 'Peruntukan Pembiayaan', name: 'peruntukan', width: 95, align:'left', hidden:true },
          { label: 'Rate Margin', name: 'rate', width: 95, align:'right' },
          { label: 'Jumlah Pembiayaan', name: 'amount', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jangka Waktu', name: 'jangka_waktu', width: 95, align:'center' },
          { label: 'Tanggal Pengajuan', name: 'tanggal_pengajuan', width: 95, align:'center' },
          { label: 'Tanggal Rencana Pencairan', name: 'rencana_droping', width: 95, align:'center' }
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
          var $grid = $('#jqGrid_pengajuan');
          var colSum = $grid.jqGrid('getCol', 'amount', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'amount': colSum });
      },
      pager: "#jqGridPager_pengajuan"
  });

  var FormAdd = $("#FormAdd"), alert_error = $('.alert-error')
      progress = $('.progress'), 
      bar = $('.bar'), 
      percent = $('.percent');

  $("#userfile",FormAdd).change(function(){
    $("#flag",FormAdd).val('2');
    $("#file_lama",FormAdd).hide();
  })

  FormAdd.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      errorPlacement: function(a,b){},
      // ignore: "",
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
          var flag = $("#flag").val();
          var userfile = $("#userfile").val();
          if(flag=="2"){
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
                      $('#userfilename').val(response.file_name);
                      $('#upload').html('<i class="icon-upload"></i> Upload');
                      $('#upload').attr('disabled',false);
                      if (response.success==true) {
                          $("#jqGrid_pengajuan").trigger('reloadGrid');        
                      } else {
                          App.WarningAlert(response.error);
                      }

                  },
                  error: function(){
                      App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                      // var percentVal = '100%';
                      // percent.html(percentVal);
                      $('#upload').html('<i class="icon-upload"></i> Upload');
                      $('#upload').attr('disabled',false);
                  }
              });
            }
          }
      }
  });

  /*Simpan Debet*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    selrow=$("#jqGrid_pengajuan").jqGrid('getGridParam','selrow');
    data=$("#jqGrid_pengajuan").jqGrid('getRowData');
  
    var kopegtel_code = []; var kopegtel_name = []; var wilayah = []; var alamat = []; var pejabat = []; var jabatan = []; var nik = []; var deskripsi_ketua_pengurus = []; var email = []; var no_telpon = []; var status_chaneling = []; var nama_bank = []; var bank_cabang = []; var nomor_rekening = []; var atasnama_rekening = []; var peruntukan = []; var rate = []; var amount = []; var jangka_waktu = []; var tanggal_pengajuan = []; var rencana_droping = [];

    for($i=0;$i<data.length;$i++){
      kopegtel_code[$i] = data[$i].kopegtel_code;
      kopegtel_name[$i] = data[$i].kopegtel_name;
      wilayah[$i] = data[$i].wilayah;
      alamat[$i] = data[$i].alamat;
      pejabat[$i] = data[$i].pejabat;
      jabatan[$i] = data[$i].jabatan;
      nik[$i] = data[$i].nik;
      deskripsi_ketua_pengurus[$i] = data[$i].deskripsi_ketua_pengurus;
      email[$i] = data[$i].email;
      no_telpon[$i] = data[$i].no_telpon;
      status_chaneling[$i] = data[$i].status_chaneling;
      nama_bank[$i] = data[$i].nama_bank;
      bank_cabang[$i] = data[$i].bank_cabang;
      nomor_rekening[$i] = data[$i].nomor_rekening;
      atasnama_rekening[$i] = data[$i].atasnama_rekening;
      peruntukan[$i] = data[$i].peruntukan;
      rate[$i] = data[$i].rate;
      amount[$i] = data[$i].amount;
      jangka_waktu[$i] = data[$i].jangka_waktu;
      tanggal_pengajuan[$i] = data[$i].tanggal_pengajuan;
      rencana_droping[$i] = data[$i].rencana_droping;
    }

    var inputpost = {
      kopegtel_code : kopegtel_code,
      kopegtel_name : kopegtel_name,
      wilayah : wilayah,
      alamat : alamat,
      pejabat : pejabat,
      jabatan : jabatan,
      nik : nik,
      deskripsi_ketua_pengurus : deskripsi_ketua_pengurus,
      email : email,
      no_telpon : no_telpon,
      status_chaneling : status_chaneling,
      nama_bank : nama_bank,
      bank_cabang : bank_cabang,
      nomor_rekening : nomor_rekening,
      atasnama_rekening : atasnama_rekening,
      peruntukan : peruntukan,
      rate : rate,
      amount : amount,
      jangka_waktu : jangka_waktu,
      tanggal_pengajuan : tanggal_pengajuan,
      rencana_droping : rencana_droping
    }
 
    if(data.length < 0){
    
      App.WarningAlert("Tidak ada data!");
      $('#upload').attr('disabled',false);
    
    }else{

      $.blockUI({ message: '<div style="padding:5px 0;">Saving.. Please Wait...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} });
      
      $.ajax({
        type:"POST",
        dataType: "json",
        data:inputpost,
        url: site_url+'migrasi/'+ $('#savefile').val(),
        error: function(){
          $.unblockUI
          App.WarningAlert("Failed to Conenct into Databases !");
        },
        success: function(response){
            $.unblockUI
            if(response.success==true){
              var content_alert = "Proses Upload SUKSES.";
              
              $.alert({
                title:"Success",icon:'icon-check',backgroundDismiss:false,
                content:content_alert,
                confirmButtonClass:'btn green',
                confirm:function(){
                  location.reload(true);
                }
              })
            }else{
              if(response.msg){
                App.WarningAlert(response.msg);
              }else{
                App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
              }
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