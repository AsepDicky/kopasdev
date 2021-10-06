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
        <h3 class="page-title">Verifikasi Pendebetan Angsuran <small>Verifikasi Pendebetan Angsuran</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Verifikasi Pendebetan Angsuran</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>Verifikasi Pendebetan Angsuran</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
            </div>
        </div>
        
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_angsuran_temp"></table>
                <div id="jqGridPager_angsuran_temp"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
                <div class="alert alert-error hide">
                    <button class="close" data-dismiss="alert"></button>
                    You have some form errors. Please check below.
                </div>
                <!-- <div class="control-group">
                    <label class="control-label">Data Angsuran <span class="required">*</span></label>
                    <div class="controls">
                      <select class="medium m-wrap chosen" name="namafile" id="namafile">
                        <option value="">Pilih</option>
                        <?php foreach($debet as $data):?>
                        <option data-trx_date="<?php echo $data['trx_date'] ?>"
                                data-status="<?php echo $data['status'] ?>"
                                value="<?php echo $data['angsuran_id'];?>"
                                attrfilename="<?php echo $data['file_name'];?>"><?php echo $data['keterangan'];?></option>
                        <?php endforeach?>
                      </select>
                    </div>
                </div> -->
                <input type="hidden" name="namafile" id="namafile">
                <input type="hidden" name="status" id="status">
                <input type="hidden" name="attrfilename" id="attrfilename">
                <hr>
                <style type="text/css">
                  .chzn-container-single{ margin-top: 0 !important;}
                </style>
                <div class="row">
                  <div class="span4" style="margin-left: 0">
                    <div class="control-group">
                        <label class="control-label">Data Akun <span class="required">*</span></label>
                        <div class="controls">
                          <select class="medium m-wrap chosen" name="akun" id="akun">
                            <option value="">Pilih</option>
                            <?php foreach($akun as $data):?>
                            <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>
                  </div>
                  <div class="span3" style="margin-left: 0">
                    <div class="control-group">
                        <label class="control-label">No. Referensi <span class="required">*</span></label>
                        <div class="controls">
                          <input type="text" class="medium m-wrap" name="referensi" id="referensi" readonly="" style="width:140px !important;" maxlength="20">
                          <input type="text" id="seq" style="display: none">
                        </div>
                    </div>
                  </div>
                  <div class="span3">
                    <div class="control-group">
                        <label class="control-label">Tgl Transaksi <span class="required">*</span></label>
                        <div class="controls">
                          <input type="text" class="date-picker maskdate small m-wrap" name="trx_date" id="trx_date" value="<?php echo '25/'.date('m/Y',strtotime($v_periode_awal)) ?>">
                          <button type="submit" id="view" class="btn green hide"><i class="icon-upload"></i> <span>View</span></button>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="span3" style="margin-left: 85px;">
                    <button class="btn yellow" id="sequance">Create Ref.</button>
                  </div>
                </div>
                    
            </form>
            <!-- END FORM-->            
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
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span6">
              <div class="append-bu" style="margin-left:10px;">
                <button id="reject_trx" class="btn red" style="font-size:13px;">Reject</button>
                <button id="download" class="btn green" style="font-size:13px;">View Results</button>
                <button id="btn_check" class="btn blue" style="font-size:13px;">Check</button>
              </div>
             </div>
             <div class="span6">
              <div class="append-bu" style="float:right;margin-right:10px;">
                <button id="save_trx" class="btn blue" style="font-size:13px;">Verifikasi</button>
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
$(function(){
  $(".maskdate").inputmask("d/m/y", {autoUnmask: true});  //direct mask        
  App.init(); // initlayout and core plugins

  $("#referensi").val('');
  $("#seq").val('');

  $('#sequance').click(function(e){
    e.preventDefault();
    $.ajax({
       type: "POST",
       url: site_url+"transaction/create_no_reference3",
       dataType: "json",
       data: {},
       async: false,
       success: function(response){
          if(response.status){
            $("#referensi").val(response.no_ref);
            $("#seq").val(response.seq);
          }
          return false;
       }
    });
    return false;
  });

  // $('#namafile').change(function(){
  //   trx_date=$(this).find('option:selected').data('trx_date');
  //   status=$(this).find('option:selected').data('status');
  //   // alert(trx_date);
  //   $('#trx_date').datepicker('update',App.ToDatePicker(trx_date));
    
  //   if(status=='3'){
  //     $("#reject_trx").show();
  //     $("#download").show();
  //     $("#btn_check").hide();
  //     $("#save_trx").show();
  //   }else{
  //     $("#reject_trx").show();
  //     $("#download").show();
  //     $("#btn_check").show();
  //     $("#save_trx").hide();
  //   }

  // })

  $("#jqGrid_angsuran_temp").jqGrid({
      url: site_url+'transaction/jqgrid_angsuran_temp',
      mtype: "GET",
      datatype: "json",
      postData:{
        // filename : function(){return $("#namafile").val()}
      },
      colModel: [
          { label: 'angsuran_id', name: 'angsuran_id', key: true, width: 100, hidden:true },
          { label: 'Filename', name: 'file_name', width: 230, align:'left' },
          { label: 'import_date', name: 'import_date', width: 80, align:'center', hidden:true },
          { label: 'Import By', name: 'import_by', width: 120, align:'left' },
          { label: 'file_client_name', name: 'file_client_name', width: 80, align:'center', hidden:true },
          { label: 'file_ext', name: 'file_ext', width: 80, align:'center', hidden:true },
          { label: 'file_type', name: 'file_type', width: 80, align:'center', hidden:true },
          { label: 'Keterangan', name: 'keterangan', width: 210, align:'left' },
          { label: 'Status', name: 'vstatus', width: 80, align:'center', hidden:true },
          { label: 'trx_date', name: 'trx_date', width: 80, align:'center', hidden:true },
          { label: 'Trx Date', name: 'vtrx_date', width: 80, align:'center' },
          { label: 'Checked?', name: 'status', width: 80, align:'center' }
      ],
      viewrecords: true,
      autowidth: true,
      height: "200",
      rowNum: 20,
      rowList: [20,30,50],
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [false, "top"],
      sortname: "import_date",
      sortorder: "asc",
      multiselect: false,
      footerrow: false,
      pager: "#jqGridPager_angsuran_temp",
      ondblClickRow: function(rowId) {
          var rowData = jQuery(this).getRowData(rowId); 
          var angsuran_id = rowData['angsuran_id'];
          var file_name = rowData['file_name'];
          var trx_date = rowData['trx_date'];
          var status = rowData['vstatus'];

          $('#trx_date').datepicker('update',App.ToDatePicker(trx_date));
          $("#namafile").val(angsuran_id)
          $("#status").val(status)
          $("#attrfilename").val(file_name)
          
          if(status=='3'){
            $("#reject_trx").show();
            $("#download").show();
            $("#btn_check").hide();
            $("#save_trx").show();
          }else{
            $("#reject_trx").show();
            $("#download").show();
            $("#btn_check").show();
            $("#save_trx").hide();
          }
          window.scrollTo(500, 420);
          // $("#jqGrid_pendebetan_angsuran").trigger('reloadGrid');
          $("#view").trigger("click");
      }
  });

  $("#jqGrid_pendebetan_angsuran").jqGrid({
      url: site_url+'transaction/jqgrid_verifikasi_pendebetan_angsuran',
      mtype: "GET",
      datatype: "json",
      postData:{
        filename : function(){return $("#namafile").val()}
      },
      colModel: [
          { label: 'ID', name: 'angsuran_detail_id', sortable: false, key: true, width: 100, hidden:true },
          { label: 'NIK', name: 'nik', sortable: false, width: 70, align:'center' },
          { label: 'Rek. Pembiayaan', name: 'account_financing_no', sortable: false, width: 120, align:'left' },
          { label: 'Nama Pegawai', name: 'nama_pegawai', sortable: false, width: 190, align:'left' },
          { label: 'Angs. Pokok', name: 'pokok', sortable: false, width: 90, align:'right',hidden:true, formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Angs. Margin', name: 'margin', sortable: false, width: 90, align:'right',hidden:true, formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Angsuran', name: 'total_angsuran', sortable: false, width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jml Bayar', name: 'jumlah_bayar', sortable: false, width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jml Debet', name: 'jml_debet', sortable: false, width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jml Debet', name: 'hasil_proses', hidden:true, sortable: false, width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Tgl Angsuran', name: 'trx_date', sortable: false, width: 100, align:'center'}
      ],
      viewrecords: true,
      autowidth: true,
      height: "250",
      rowNum: 999999999,
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [false, "top"],
      sortname: "mfi_angsuran_temp_detail.nik",
      sortorder: "asc",
      multiselect: false,
      footerrow: true,
      userDataOnFooter : true,
      gridComplete: function() {
          var $grid = $('#jqGrid_pendebetan_angsuran');
          var colSumPokok = $grid.jqGrid('getCol', 'pokok', false, 'sum');
          var colSumMargin = $grid.jqGrid('getCol', 'margin', false, 'sum');
          var colSumHasilProses = $grid.jqGrid('getCol', 'jml_debet', false, 'sum');
          var colSumTotalAngsuran = $grid.jqGrid('getCol', 'total_angsuran', false, 'sum');
          var colSumTotaljumlah_bayar = $grid.jqGrid('getCol', 'jumlah_bayar', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'pokok': colSumPokok });
          $grid.jqGrid('footerData', 'set', { 'margin': colSumMargin });
          $grid.jqGrid('footerData', 'set', { 'total_angsuran': colSumTotalAngsuran });
          $grid.jqGrid('footerData', 'set', { 'jml_debet': colSumHasilProses });
          $grid.jqGrid('footerData', 'set', { 'jumlah_bayar': colSumTotaljumlah_bayar });
      },
      pager: "#jqGridPager_pendebetan_angsuran"
  });

  // $("#t_jqGrid_pendebetan_angsuran").append('<div class="append-bu" style="margin:2px;float:right;"><button id="btn_edit_tgl" class="btn red" style="font-size:13px;">Proses Debet</button>');

  var FormAdd = $("#FormAdd"), alert_error = $('.alert-error')

  $('#download').click(function(e){
    e.preventDefault();
    bValid = true;
    var namafile = $('#namafile').val();
    var akun = $('#akun').val();
    var referensi = $('#referensi').val();
    var trx_date = $('#trx_date').val();

    msg='';
    if (namafile=="") {
      bValid=false;
      msg+='- Pilih Data Angsuran <br>';
    }
    if (akun=="") {
      bValid=false;
      msg+='- Pilih Data Akun <br>';
    }
    if (referensi=="") {
      bValid=false;
      msg+='- Isi No. Referensi<br>';
    }
    if (trx_date=="") {
      bValid=false;
      msg+='- Isi No. Tanggal Transaksi';
    }

    if (bValid==false) {
      App.WarningAlert('Mohon Cek Isian ini : <br>'+msg);
    } else {
      trx_date = App.ToDateDefault(trx_date);
      window.location.href=site_url+'transaction/download_transaction_debeted/'+namafile+'/'+trx_date;
    }
  })

  $("#view").click(function(e){
    e.preventDefault();
    bValid = true;
    var namafile = $('#namafile').val();
    var akun = $('#akun').val();
    var referensi = $('#referensi').val();
    var trx_date = $('#trx_date').val();

    msg='';
    if (namafile=="") {
      bValid=false;
      msg+='- Pilih Data Angsuran <br>';
    }
    // if (akun=="") {
      // bValid=false;
      // msg+='- Pilih Data Akun <br>';
    // }
    // if (referensi=="") {
      // bValid=false;
      // msg+='- Isi No. Referensi<br>';
    // }
    if (trx_date=="") {
      bValid=false;
      msg+='- Isi No. Tanggal Transaksi';
    }

    if (bValid==false) {
      App.WarningAlert('Mohon Cek Isian ini : <br>'+msg)
    } else {
      $("#jqGrid_pendebetan_angsuran").trigger('reloadGrid');        
    }
  })

  $('#reject_trx').click(function(e){
    e.preventDefault();
    bValid = true;
    var namafile = $('#namafile').val();
    var akun = $('#akun').val();
    var referensi = $('#referensi').val();
    var trx_date = $('#trx_date').val();

    msg='';
    if (namafile=="") {
      bValid=false;
      msg+='- Pilih Data Angsuran <br>';
    }
    // if (akun=="") {
    //   bValid=false;
    //   msg+='- Pilih Data Akun <br>';
    // }
    // if (referensi=="") {
    //   bValid=false;
    //   msg+='- Isi No. Referensi<br>';
    // }
    // if (trx_date=="") {
    //   bValid=false;
    //   msg+='- Isi No. Tanggal Transaksi';
    // }

    if (bValid==false) {
      App.WarningAlert('Mohon Cek Isian ini : <br>'+msg)
    } else {
      App.ConfirmAlert("Reject Data Angsuran ini? Anda Yakin?",function(){
        $.ajax({
          type:"POST",dataType:"json",data:{
            namafile:namafile
          },
          url:site_url+'transaction/do_reject_verifikasi_pendebetan_angsuran_koptel',
          success:function(response){
            if (response.success==true) {
              alert('Reject Success!');
              window.location.reload(true);
            } else {
              alert(response.message);
            }
          },
          error:function(d){
            alert(d);
          }
        })
      })

    }
  })

  /*Simpan Debet*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    var namafile = $('#namafile').val();
    var akun = $('#akun').val();
    var referensi = $('#referensi').val();
    var seq = $('#seq').val();
    var trx_date = $('#trx_date').val();

    msg='';
    if (namafile=="") {
      bValid=false;
      msg+='- Pilih Data Angsuran <br>';
    }
    if (akun=="") {
      bValid=false;
      msg+='- Pilih Data Akun <br>';
    }
    if (referensi=="") {
      bValid=false;
      msg+='- Isi No. Referensi <br>';
    }
    if (trx_date=="") {
      bValid=false;
      msg+='- Isi No. Tanggal Transaksi';
    }

    if (bValid==false) {
      App.WarningAlert('Mohon Cek Isian ini : <br>'+msg)
    } else {

      selrow=$("#jqGrid_pendebetan_angsuran").jqGrid('getGridParam','selrow');
      data=$("#jqGrid_pendebetan_angsuran").jqGrid('getRowData');
      var filename = $("#namafile").val();
      var akun = $("#akun").val();
      var attrfilename = $("#namafile").find('option:selected').attr('attrfilename');
      var referensi = $("#referensi").val();
      var seq = $("#seq").val();
      var trx_date = $("#trx_date").val();
      var angsuran_id = data.angsuran_id;
      var nik = [];
      var hasil_proses = [];
      for($i=0;$i<data.length;$i++){
        nik[$i] = data[$i].nik;
        hasil_proses[$i] = data[$i].hasil_proses;
      }
      $("#save_trx").html('Loading....').attr('disabled',true);
      $.ajax({
        type:"POST",
        dataType: "json",
        data:{angsuran_id:angsuran_id,nik:nik,hasil_proses:hasil_proses,filename:filename,akun:akun,referensi:referensi,seq:seq,attrfilename:attrfilename,trx_date:trx_date},
        url: site_url+'transaction/verifikasi_pendebetan_angsuran_pembiayaan_koptel',
        async: false,
        error: function(){
          $("#save_trx").html('Verifikasi').removeAttr('disabled');
          App.WarningAlert("Failed to Conenct into Databases !");
        },
        success: function(response){
          $("#save_trx").html('Verifikasi').removeAttr('disabled');
            if(response.success==true){
              var trx_date=response.trx_date;
              var content_alert = "Verifikasi Pendebetan SUKSES.";
              content_alert += "<br>";
              content_alert += "<br>";
              content_alert += "<strong><a id='download' href='"+site_url+"transaction/export_log_trx_pendebetan/"+trx_date+"/"+filename+"'>Download Log</a></strong>";
              window.location.href = site_url+"transaction/export_log_trx_pendebetan/"+trx_date+"/"+filename;
              $.alert({
                title:"Success",icon:'icon-check',backgroundDismiss:false,
                content:content_alert,
                confirmButtonClass:'btn green',
                confirm:function(){
                  location.reload(true);
                }
              })
            }else{
              App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
            }
        }
      });
    }
  })
  
  /*Check transaksi agar bisa diverifikasi*/
  $('#btn_check').click(function(e){
    e.preventDefault();
    bValid = true;
    var namafile = $('#namafile').val();

    msg='';
    if (namafile=="") {
      bValid=false;
      msg+='- Pilih Data Angsuran <br>';
    }

    if (bValid==false) {
      App.WarningAlert('Mohon Cek Isian ini : <br>'+msg)
    } else {
      App.ConfirmAlert("Check agar bisa diverifikasi. Anda Yakin?",function(){
        $.ajax({
          type:"POST",dataType:"json",data:{
            namafile:namafile
          },
          url:site_url+'transaction/do_check_verifikasi_pendebetan_angsuran_koptel',
          success:function(response){
            if (response.success==true) {
              alert('Success!');
              window.location.reload(true);
            } else {
              alert(response.message);
            }
          },
          error:function(d){
            alert(d);
          }
        })
      })

    }
  })


});
</script>