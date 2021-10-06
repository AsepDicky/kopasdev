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
        <form action="<?php echo site_url('migrasi/do_upload_pengajuan'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
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
                    <button type="submit" id="upload" class="btn green"><i class="icon-upload"></i> <span>Proses</span></button>
                </div>
            </div>
        </form>
        <!-- END FORM-->
      </div>
      <?php endif; ?>
      
      <div class="portlet-body form">
        
        <div class="append-bu" style="float:right;margin-right:10px;">
          <a href="<?= base_url() ?>assets/template_excel/DATA_TEMPLETE_MIGRASI_2018.xlsx" download class="btn yellow" style="padding:7px 10px;margin-right:5px">
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
      url: site_url+'migrasi/jqGrid_pengajuan',
      mtype: "GET",
      datatype: "json",
      postData:{
          file_name:function(){
            return $("#filenameupload").val();
          }
      },
      colModel: [
          { label: 'ID', name: 'cif_id', key: true, width: 100, hidden:true },
          { label: 'NIK', name: 'nik', width: 80, align:'center' },
          { label: 'Nama Pegawai', name: 'nama', width: 200, align:'left' },
          { label: 'Tempat Lahir', name: 'tempat_lahir', width: 95, align:'left' },
          { label: 'Tanggal Lahir', name: 'tgl_lahir', width: 95, align:'left' },
          { label: 'Band Posisi', name: 'band', width: 30, align:'left' },
          { label: 'Jabatan', name: 'jabatan', width: 220, align:'left' },
          { label: 'Lokasi Kerja', name: 'alamat_lokasi_kerja', width: 250, align:'left' },
          { label: 'Alamat Rumah', name: 'alamat', width: 250, align:'left' },
          { label: 'No KTP', name: 'no_ktp', width: 90, align:'left', hidden:true  },
          { label: 'Handphone', name: 'no_telpon', width: 90, align:'left', hidden:true  },
          { label: 'Nama Pasangan', name: 'nama_pasangan', width: 90, align:'left', hidden:true  },
          { label: 'Bank', name: 'nama_bank', width: 100, align:'left', hidden:true  },
          { label: 'Cabang', name: 'bank_cabang', width: 100, align:'left', hidden:true  },
          { label: 'No Rekening', name: 'no_rekening', width: 100, align:'left', hidden:true  },
          { label: 'Atas Nama', name: 'atasnama_rekening', width: 200, align:'left', hidden:true  },
          { label: 'THP', name: 'thp', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: '40% THP', name: 'thp_40', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'angsuran_pokok', name: 'angsuran_pokok', width: 90, align:'left', hidden:true },
          { label: 'angsuran_margin', name: 'angsuran_margin', width: 90, align:'left', hidden:true },
          { label: 'Total Angsuran', name: 'total_angsuran', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Ang.Koptel', name: 'jumlah_kewajiban', width: 90, align:'right', hidden:true },
          { label: 'Saldo Kewajiban', name: 'saldo_kewajiban_ke_koptel', width: 90, align:'right', hidden:true },
          { label: 'masa_pensiun', name: 'masa_pensiun', width: 90, align:'left', hidden:true },
          { label: 'show_masa_pensiun', name: 'show_masa_pensiun', width: 90, align:'left', hidden:true },
          { label: 'kopegtel', name: 'kopegtel', width: 90, align:'left', hidden:true },
          { label: 'status_financing_reg', name: 'status_financing_reg', width: 90, align:'left', hidden:true},
          { label: 'flag_thp100', name: 'flag_thp100', width: 90, align:'left', hidden:true},
          { label: 'gender', name: 'gender', width: 90, align:'left', hidden:true},
          { label: 'jenis_margin', name: 'jenis_margin', width: 90, align:'left', hidden:true  },
          { label: 'Tanggal Pengajuan', name: 'tanggal_pengajuan', width: 110, align:'center' },
          { label: 'Tanggal Akad', name: 'tgl_akad', width: 110, align:'center' },
          { label: 'Angke-1', name: 'angsuranke1', width: 110, align:'center' },
          { label: 'Jatuh Tempo', name: 'tgl_jtempo', width: 110, align:'center' },
          { label: 'Pengajuan Melalui', name: 'pengajuan_melalui', width: 90, align:'left', hidden:true  },
          { label: 'akad_code', name: 'akad_code', width: 90, align:'left', hidden:true },
          { label: 'product_code', name: 'product_code', width: 90, align:'left', hidden:true },
          { label: 'Jumlah Pembiayaan', name: 'amount', width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jangka Waktu', name: 'jangka_waktu', width: 90, align:'center' },
          { label: 'Total Margin', name: 'jumlah_margin', width: 90, align:'right' },
          { label: 'Premi Asuransi', name: 'premi_asuransi', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Counter Angs', name: 'counter', width: 90, align:'center' },
          { label: 'Saldo Outstanding', name: 'saldo_oustanding', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:2,defaultValue:'0' } }
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
          var colSum = $grid.jqGrid('getCol', 'hasil_proses', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'hasil_proses': colSum });
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
  
    var cif_id = []; var nik = []; var nama = []; var tempat_lahir = []; var tgl_lahir = []; var band = []; var jabatan = []; var alamat_lokasi_kerja = []; var alamat = []; var no_ktp = []; var no_telpon = []; var nama_pasangan = []; var nama_bank = []; var bank_cabang = []; var no_rekening = []; var atasnama_rekening = []; var thp = []; var thp_40 = []; var angsuran_pokok = []; var angsuran_margin = []; var total_angsuran = []; var jumlah_kewajiban = []; var saldo_kewajiban_ke_koptel = []; var masa_pensiun = []; var show_masa_pensiun = []; var kopegtel = []; var status_financing_reg = []; var flag_thp100 = []; var gender = []; var jenis_margin = []; var tanggal_pengajuan = []; var tgl_akad = []; var angsuranke1 = []; var tgl_jtempo = []; var pengajuan_melalui = []; var akad_code = []; var product_code = []; var amount = []; var jangka_waktu = []; var jumlah_margin = []; var premi_asuransi = []; var counter = []; var saldo_oustanding = [];

    for($i=0;$i<data.length;$i++){
      cif_id[$i] = data[$i].cif_id;
      nik[$i] = data[$i].nik;
      nama[$i] = data[$i].nama;
      tempat_lahir[$i] = data[$i].tempat_lahir;
      tgl_lahir[$i] = data[$i].tgl_lahir;
      band[$i] = data[$i].band;
      jabatan[$i] = data[$i].jabatan;
      alamat_lokasi_kerja[$i] = data[$i].alamat_lokasi_kerja;
      alamat[$i] = data[$i].alamat;
      no_ktp[$i] = data[$i].no_ktp;
      no_telpon[$i] = data[$i].no_telpon;
      nama_pasangan[$i] = data[$i].nama_pasangan;
      nama_bank[$i] = data[$i].nama_bank;
      bank_cabang[$i] = data[$i].bank_cabang;
      no_rekening[$i] = data[$i].no_rekening;
      atasnama_rekening[$i] = data[$i].atasnama_rekening;
      thp[$i] = data[$i].thp;
      thp_40[$i] = data[$i].thp_40;
      angsuran_pokok[$i] = data[$i].angsuran_pokok;
      angsuran_margin[$i] = data[$i].angsuran_margin;
      total_angsuran[$i] = data[$i].total_angsuran;
      jumlah_kewajiban[$i] = data[$i].jumlah_kewajiban;
      saldo_kewajiban_ke_koptel[$i] = data[$i].saldo_kewajiban_ke_koptel;
      masa_pensiun[$i] = data[$i].masa_pensiun;
      show_masa_pensiun[$i] = data[$i].show_masa_pensiun;
      kopegtel[$i] = data[$i].kopegtel;
      status_financing_reg[$i] = data[$i].status_financing_reg;
      flag_thp100[$i] = data[$i].flag_thp100;
      gender[$i] = data[$i].gender;
      jenis_margin[$i] = data[$i].jenis_margin;
      tanggal_pengajuan[$i] = data[$i].tanggal_pengajuan;
      tgl_akad[$i] = data[$i].tgl_akad;
      angsuranke1[$i] = data[$i].angsuranke1;
      tgl_jtempo[$i] = data[$i].tgl_jtempo;
      pengajuan_melalui[$i] = data[$i].pengajuan_melalui;
      akad_code[$i] = data[$i].akad_code;
      product_code[$i] = data[$i].product_code;
      amount[$i] = data[$i].amount;
      jangka_waktu[$i] = data[$i].jangka_waktu;
      jumlah_margin[$i] = data[$i].jumlah_margin;
      premi_asuransi[$i] = data[$i].premi_asuransi;
      counter[$i] = data[$i].counter;
      saldo_oustanding[$i] = data[$i].saldo_oustanding;
    }

    var inputpost = {
      cif_id : cif_id,
      nik : nik,
      nama : nama,
      tempat_lahir : tempat_lahir,
      tgl_lahir : tgl_lahir,
      band : band,
      jabatan : jabatan,
      alamat_lokasi_kerja : alamat_lokasi_kerja,
      alamat : alamat,
      no_ktp : no_ktp,
      no_telpon : no_telpon,
      nama_pasangan : nama_pasangan,
      nama_bank : nama_bank,
      bank_cabang : bank_cabang,
      no_rekening : no_rekening,
      atasnama_rekening : atasnama_rekening,
      thp : thp,
      thp_40 : thp_40,
      angsuran_pokok : angsuran_pokok,
      angsuran_margin : angsuran_margin,
      total_angsuran : total_angsuran,
      jumlah_kewajiban : jumlah_kewajiban,
      saldo_kewajiban_ke_koptel : saldo_kewajiban_ke_koptel,
      masa_pensiun : masa_pensiun,
      show_masa_pensiun : show_masa_pensiun,
      kopegtel : kopegtel,
      status_financing_reg : status_financing_reg,
      flag_thp100 : flag_thp100,
      gender : gender,
      jenis_margin : jenis_margin,
      tanggal_pengajuan : tanggal_pengajuan,
      tgl_akad : tgl_akad,
      angsuranke1 : angsuranke1,
      tgl_jtempo : tgl_jtempo,
      pengajuan_melalui : pengajuan_melalui,
      akad_code : akad_code,
      product_code : product_code,
      amount : amount,
      jangka_waktu : jangka_waktu,
      jumlah_margin : jumlah_margin,
      premi_asuransi : premi_asuransi,
      counter : counter,
      saldo_oustanding : saldo_oustanding
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