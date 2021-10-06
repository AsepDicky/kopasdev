<!--- CREATED BY dickysigma@gmail.com -->

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
        <h3 class="page-title">Topup</h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Topup</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>List Topup</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="<?php echo site_url('transaction/do_upload_topup'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
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
                    <label class="control-label"></label>
                    <div class="controls">
                        <button type="submit" id="upload" class="btn yellow"><i class="icon-upload"></i> <span>Proses</span></button>
                    </div>
                </div>
            </form>
            <!-- END FORM-->            
        </div>
      <div class="portlet-body form">
        <div class="append-bu" style="float:right;margin-right:10px;">
          <a href="<?= base_url() ?>assets/template_excel/DATA_TEMPLETE_TOPUP.xlsx" download class="btn blue" style="padding:7px 10px;margin-right:5px"> 
              Download Template
          </a>
          <button id="delete_trx" class="btn red" style="font-size:13px;">Delete Topup</button>
          <button id="save_trx" class="btn green" style="font-size:13px;">Save Topup</button>
        </div>
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_topup_angsuran"></table>
                <div id="jqGridPager_topup_angsuran"></div>
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

  $("#jqGrid_topup_angsuran").jqGrid({
      url: site_url+'transaction/jqGrid_topup',
      mtype: "GET",
      datatype: "json",
      colModel: [
          { label: 'ID', name: 'cif_id', key: true, width: 100, hidden:true },
          { label: 'NIK', name: 'nik', width: 80, align:'center' },
          { label: 'Nama Pegawai', name: 'nama', width: 200, align:'left' },
          { label: 'Product Code', name: 'product_code', width: 80, align:'center' },
          { label: 'Tanggal Akad', name: 'tanggal_akad', width: 110, align:'center' },
          { label: 'Tanggal Pengajuan', name: 'tanggal_pengajuan', width: 110, align:'center' },
          { label: 'Tanggal Pengajuan', name: 'none', width: 110, align:'center', hidden:true },
          { label: 'Jumlah Pembiayaan', name: 'amount', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jangka Waktu', name: 'jangka_waktu', width: 90, align:'center' },
          { label: 'Total Margin', name: 'jumlah_margin', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Counter Angs', name: 'counter', width: 90, align:'center', hidden:true },
          { label: 'Lunasi Ke Koptel', name: 'lunasi_ke_koptel', width: 90, align:'center' },
          { label: 'Kewajiban Ke Koptel', name: 'saldo_kewajiban_ke_koptel', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Lunasi Ke Kopegtel', name: 'lunasi_ke_kopegtel', width: 90, align:'center' },
          { label: 'Kewajiban Ke Kopegtel', name: 'saldo_kewajiban', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Gender', name: 'gender', width: 90, align:'center', hidden:true },
          { label: 'Peruntukan', name: 'peruntukan', width: 90, align:'center', hidden:true },
          { label: 'jumlah_kewajiban', name: 'jumlah_kewajiban', width: 90, align:'center', hidden:true },
          { label: 'jumlah_angsuran', name: 'jumlah_angsuran', width: 90, align:'center', hidden:true },
          { label: 'melalui', name: 'melalui', width: 90, align:'center', hidden:true },
          { label: 'kopegtel', name: 'kopegtel', width: 90, align:'center', hidden:true },
          { label: 'tempat_lahir', name: 'tempat_lahir', width: 90, align:'center', hidden:true },
          { label: 'tgl_lahir', name: 'tgl_lahir', width: 90, align:'center', hidden:true },
          { label: 'alamat', name: 'alamat', width: 90, align:'center', hidden:true },
          { label: 'alamat_lokasi_kerja', name: 'alamat_lokasi_kerja', width: 90, align:'center', hidden:true },
          { label: 'No. KTP', name: 'no_ktp', width: 100, align:'left' },
          { label: 'telpon_rumah', name: 'telpon_rumah', width: 90, align:'center', hidden:true },
          { label: 'no_telpon', name: 'no_telpon', width: 90, align:'center', hidden:true },
          { label: 'nama_pasangan', name: 'nama_pasangan', width: 90, align:'center', hidden:true },
          { label: 'pekerjaan_pasangan', name: 'pekerjaan_pasangan', width: 90, align:'center', hidden:true },
          { label: 'Bank', name: 'nama_bank', width: 90, align:'left' },
          { label: 'Cabang', name: 'bank_cabang', width: 90, align:'left' },
          { label: 'No Rekening', name: 'no_rekening', width: 90, align:'left' },
          { label: 'Nama Pemilik', name: 'atasnama_rekening', width: 90, align:'left' },
          { label: 'thp', name: 'thp', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' }},
          { label: 'Premi Asuransi', name: 'premi_asuransi', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Total Angsuran', name: 'total_angsuran', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' }},
          { label: 'flag_thp100', name: 'flag_thp100', width: 90, align:'center', hidden:true },
          { label: 'angsuran_pokok', name: 'angsuran_pokok', hidden:true, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'angsuran_margin', name: 'angsuran_margin', hidden:true, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'account_financing_no', name: 'account_financing_no', width: 90, align:'center', hidden:true  },
          { label: 'check_saldo_pokok', name: 'check_saldo_pokok', width: 90, align:'center', hidden:true  },
          { label: 'check_saldo_margin', name: 'check_saldo_margin', width: 90, align:'center', hidden:true  },
          { label: 'by_excel', name: 'by_excel', width: 90, align:'center', hidden:true },
          { label: 'jenis_margin', name: 'jenis_margin', width: 90, align:'center', hidden:true }
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
      pager: "#jqGridPager_topup_angsuran"
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
                      $("#jqGrid_topup_angsuran").trigger('reloadGrid');        
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
        url: site_url+'transaction/delete_upload_topup',
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

  /*Simpan TopUp*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    selrow = $("#jqGrid_topup_angsuran").jqGrid('getGridParam','selrow');
    data   = $("#jqGrid_topup_angsuran").jqGrid('getRowData');
    
    var cif_id = [];
    var nik = [];
    var nama = [];
    var product_code = [];
    var tanggal_akad = [];
    var tanggal_pengajuan = [];
    var amount = [];
    var jangka_waktu = [];
    var jumlah_margin = [];
    var counter = [];
    var lunasi_ke_koptel = [];
    var saldo_kewajiban_ke_koptel = [];
    var lunasi_ke_kopegtel = [];
    var saldo_kewajiban = [];
    var gender = [];
    var peruntukan = [];
    var jumlah_kewajiban = [];
    var jumlah_angsuran = [];
    var melalui = [];
    var kopegtel = [];
    var tempat_lahir = [];
    var tgl_lahir = [];
    var alamat = [];
    var alamat_lokasi_kerja = [];
    var no_ktp = [];
    var telpon_rumah = [];
    var no_telpon = [];
    var nama_pasangan = [];
    var pekerjaan_pasangan = [];
    var nama_bank = [];
    var no_rekening = [];
    var atasnama_rekening = [];
    var thp = [];
    var premi_asuransi = [];
    var total_angsuran = [];
    var bank_cabang = [];
    var flag_thp100 = [];
    var angsuran_pokok = [];
    var angsuran_margin = [];
    var account_financing_no = [];
    var check_saldo_pokok = [];
    var check_saldo_margin = [];
    var by_excel = [];
    var jenis_margin = [];

    for($i=0;$i<data.length;$i++){
      cif_id[$i] = data[$i].cif_id;
      nik[$i] = data[$i].nik;
      nama[$i] = data[$i].nama;
      product_code[$i] = data[$i].product_code;
      tanggal_akad[$i] = data[$i].tanggal_akad;
      tanggal_pengajuan[$i] = data[$i].tanggal_pengajuan;
      amount[$i] = data[$i].amount;
      jangka_waktu[$i] = data[$i].jangka_waktu;
      jumlah_margin[$i] = data[$i].jumlah_margin;
      counter[$i] = data[$i].counter;
      lunasi_ke_koptel[$i] = data[$i].lunasi_ke_koptel;
      saldo_kewajiban_ke_koptel[$i] = data[$i].saldo_kewajiban_ke_koptel;
      lunasi_ke_kopegtel[$i] = data[$i].lunasi_ke_kopegtel;
      saldo_kewajiban[$i] = data[$i].saldo_kewajiban;
      gender[$i] = data[$i].gender;
      peruntukan[$i] = data[$i].peruntukan;
      jumlah_kewajiban[$i] = data[$i].jumlah_kewajiban;
      jumlah_angsuran[$i] = data[$i].jumlah_angsuran;
      melalui[$i] = data[$i].melalui;
      kopegtel[$i] = data[$i].kopegtel;
      tempat_lahir[$i] = data[$i].tempat_lahir;
      tgl_lahir[$i] = data[$i].tgl_lahir;
      alamat[$i] = data[$i].alamat;
      alamat_lokasi_kerja[$i] = data[$i].alamat_lokasi_kerja;
      no_ktp[$i] = data[$i].no_ktp;
      telpon_rumah[$i] = data[$i].telpon_rumah;
      no_telpon[$i] = data[$i].no_telpon;
      nama_pasangan[$i] = data[$i].nama_pasangan;
      pekerjaan_pasangan[$i] = data[$i].pekerjaan_pasangan;
      nama_bank[$i] = data[$i].nama_bank;
      no_rekening[$i] = data[$i].no_rekening;
      atasnama_rekening[$i] = data[$i].atasnama_rekening;
      thp[$i] = data[$i].thp;
      premi_asuransi[$i] = data[$i].premi_asuransi;
      total_angsuran[$i] = data[$i].total_angsuran;
      bank_cabang[$i] = data[$i].bank_cabang;
      flag_thp100[$i] = data[$i].flag_thp100;
      angsuran_pokok[$i] = data[$i].angsuran_pokok;
      angsuran_margin[$i] = data[$i].angsuran_margin;
      account_financing_no[$i] = data[$i].account_financing_no;
      check_saldo_pokok[$i] = data[$i].check_saldo_pokok;
      check_saldo_margin[$i] = data[$i].check_saldo_margin;
      by_excel[$i] = data[$i].by_excel;
      jenis_margin[$i] = data[$i].jenis_margin;
    }

    var inputpost = {
      cif_id : cif_id,
      nik : nik,
      nama : nama,
      product_code : product_code,
      tanggal_akad : tanggal_akad,
      tanggal_pengajuan : tanggal_pengajuan,
      amount : amount,
      jangka_waktu : jangka_waktu,
      jumlah_margin : jumlah_margin,
      counter : counter,
      lunasi_ke_koptel : lunasi_ke_koptel,
      saldo_kewajiban_ke_koptel : saldo_kewajiban_ke_koptel,
      lunasi_ke_kopegtel : lunasi_ke_kopegtel,
      saldo_kewajiban : saldo_kewajiban,
      gender : gender,
      peruntukan : peruntukan,
      jumlah_kewajiban : jumlah_kewajiban,
      jumlah_angsuran : jumlah_angsuran,
      melalui : melalui,
      kopegtel : kopegtel,
      tempat_lahir : tempat_lahir,
      tgl_lahir : tgl_lahir,
      alamat : alamat,
      alamat_lokasi_kerja : alamat_lokasi_kerja,
      no_ktp : no_ktp,
      telpon_rumah : telpon_rumah,
      no_telpon : no_telpon,
      nama_pasangan : nama_pasangan,
      pekerjaan_pasangan : pekerjaan_pasangan,
      nama_bank : nama_bank,
      no_rekening : no_rekening,
      atasnama_rekening : atasnama_rekening,
      thp : thp,
      premi_asuransi : premi_asuransi,
      total_angsuran : total_angsuran,
      bank_cabang : bank_cabang,
      flag_thp100 : flag_thp100,
      angsuran_pokok : angsuran_pokok,
      angsuran_margin : angsuran_margin,
      account_financing_no : account_financing_no,
      check_saldo_pokok : check_saldo_pokok,
      check_saldo_margin : check_saldo_margin,
      by_excel : by_excel,
      jenis_margin : jenis_margin
    }

    $.blockUI({ message: '<div style="padding:5px 0;">Saving.. Please Wait...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} })
    $.ajax({
      type:"POST",
      dataType: "json",
      data:inputpost,
      url: site_url+'rekening_nasabah/add_pengajuan_pembiayaan_koptel_v2',
      error: function(){
        $.unblockUI
        App.WarningAlert("Failed to Conenct into Databases !");
      },
      success: function(response){
        $.unblockUI
        if(response.success==true){
          var content_alert = "Proses topup SUKSES.";
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
  })
});
</script>