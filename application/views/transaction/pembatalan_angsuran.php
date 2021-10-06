<style type="text/css">
  .ui-jqgrid .ui-userdata {
    height: auto !important;
  }
</style>
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
        <h3 class="page-title">Pembatalan Angsuran <small>Pembatalan Angsuran</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaksi</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Pembatalan Angsuran</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN FORM ADD -->
<div id="add">
  <div class="portlet box red">
    <div class="portlet-title">
      <div class="caption"><i class="icon-refresh"></i>Pembatalan Angsuran</div>
      <div class="tools">
        <a href="javascript:;" class="collapse"></a>
        <a href="javascript:;" class="reload"></a>
      </div>
    </div>
    
    <div class="portlet-body form">
      
      <form class="form-horizontal" id="form-batal" action="#">
        
        <input type="hidden" id="trx_account_financing_id" name="trx_account_financing_id">

        <div class="control-group">
          <label class="control-label">No Pembiayaan</label>
          <div class="controls">
            <input type="text" class="m-wrap medium" readonly="readonly" id="account_financing_no" name="account_financing_no" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Nama</label>
          <div class="controls">
            <input type="text" class="m-wrap medium" readonly="readonly" id="nama" name="nama" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Tanggal Akad</label>
          <div class="controls">
            <input type="text" class="m-wrap medium" readonly="readonly" id="tanggal_akad" name="tanggal_akad" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Pokok</label>
          <div class="controls">
            <div class="input-prepend input-append">
              <span class="add-on">Rp</span>
              <input type="text" class="m-wrap small" readonly="readonly" id="pokok" name="pokok" style="text-align:right;background-color: #eeeeee;">
              <span class="add-on">.00</span>
            </div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Margin</label>
          <div class="controls">
            <div class="input-prepend input-append">
              <span class="add-on">Rp</span>
              <input type="text" class="m-wrap small" readonly="readonly" id="margin" name="margin" style="text-align:right;background-color: #eeeeee;">
              <span class="add-on">.00</span>
            </div>
          </div>
        </div>

        <h3 class="form-section">Angsuran yang akan Dibatalkan.</h3>

        <div class="control-group">
          <label class="control-label">Angsuran Pokok</label>
          <div class="controls">
            <div class="input-prepend input-append">
              <span class="add-on">Rp</span>
              <input type="text" class="m-wrap small" readonly="readonly" id="angsuran_pokok" name="angsuran_pokok" style="text-align:right;background-color: #eeeeee;">
              <span class="add-on">.00</span>
            </div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Angsuran Margin</label>
          <div class="controls">
            <div class="input-prepend input-append">
              <span class="add-on">Rp</span>
              <input type="text" class="m-wrap small" readonly="readonly" id="angsuran_margin" name="angsuran_margin" style="text-align:right;background-color: #eeeeee;">
              <span class="add-on">.00</span>
            </div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Tanggal J.Tempo</label>
          <div class="controls">
            <input type="text" class="m-wrap medium" readonly="readonly" id="jto_date" name="jto_date" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Tanggal Transaksi</label>
          <div class="controls">
            <input type="text" class="m-wrap medium" readonly="readonly" id="trx_date" name="trx_date" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Angsuran Ke</label>
          <div class="controls">
            <input type="text" class="m-wrap small" readonly="readonly" id="angsuran_ke" name="angsuran_ke" style="background-color: #eeeeee;">
          </div>
        </div>
        <div class="form-actions">
           <button type="submit" class="btn green" id="btn-submit-batal">Submit</button>
           <button type="reset" class="btn blue" id="btn-kembali">Kembali</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- END FORM ADD -->

<!-- BEGIN GRID -->
<div id="grid">
  <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption"><i class="icon-book"></i>Data Pembiayaan</div>
      <div class="tools">
        <a href="javascript:;" class="collapse"></a>
        <a href="javascript:;" class="reload"></a>
      </div>
    </div>
    
    <div class="portlet-body form">
      <div class="row-fluid">
        <div class="span2">
          <label class="control-label">NIK</label>
          <input type="text" class="m-wrap small" id="cif_no" placeholder="ketik keyword...">
        </div>
        <div class="span2">
          <label class="control-label">Nama</label>
          <input type="text" class="m-wrap small" id="nama" placeholder="ketik keyword...">
        </div>
        <div class="span2">
          <label class="control-label">No. Pembiayaan</label>
          <input type="text" class="m-wrap small" id="account_financing_no" placeholder="ketik keyword...">
        </div>
        <div class="span2">
          <label class="control-label">&nbsp;</label>
          <button type="button" id="btn-search" class="btn-info" style="margin-top:3px;">Search</button>
        </div>
        <div class="span2">
          <label class="control-label">&nbsp;</label>
          <button class="btn blue pull-right" id="detail">Detail  <i class="icon-th-list"></i></button>
        </div>
      </div>
      <hr size="1" style="margin-top:5px;margin-bottom:15px;">
      <div class="row-fluid">
         <div class="span12">
          <div id="wraper_table">
            <table id="jqGrid_pembatalan_angsuran"></table>
            <div id="jqGridPager_pembatalan_angsuran"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Dialog Detail Tabungan-->
<div id="dialog_detail" title="Detail Transaksi Tabungan" style="display:none;">    
<form id="t_dialog">  
  <table width="490">
     <tr>
       <td>Nama</td>
       <td><div id="t_nama"></div></td>
     </tr>
     <tr>
       <td>No. Rekening</td>
       <td><div id="t_account_no"></div></td>
     </tr>
     <tr>
       <td>Pokok</td>
       <td><div id="t_pokok"></div></td>
     </tr>
     <tr>
       <td>Margin</td>
       <td><div id="t_margin"></div></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td>Saldo Pokok</td>
       <td>
        <div class="input-prepend">
          <span class="add-on">Rp</span>
          <input type="text" id="t_saldo_pokok" class="medium m-wrap mask-money" style="width:120px !important;" />
          <span class="add-on">,00</span>
        </div>
      </td>
     </tr>
     <tr>
       <td>Saldo Margin</td>
       <td><div id="t_saldo_margin"></div></td>
     </tr>
     <tr>
       <td>Counter</td>
       <td>
        <input type="text" id="t_counter" class="small m-wrap" maxlength="5"/>
        <input type="hidden" id="t_account_financing_id" class="small m-wrap" maxlength="5"/>
       </td>
     </tr>
  </table>
  <button type="button" id="act_submit" class="btn green">Save</button>
  <button type="button" class="btn" id="cancel">Back</button>
</form>
</div>

<!-- END GRID -->

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
  $('#add').hide();
  $("#jqGrid_pembatalan_angsuran").jqGrid({
      url: site_url+'transaction/jqgrid_pembatalan_angsuran',
      mtype: "GET",
      datatype: "json",
      postData:{
        cif_no : function(){return $("#cif_no",'#grid').val()}
        ,nama : function(){return $("#nama",'#grid').val()}
        ,account_financing_no : function(){return $("#account_financing_no",'#grid').val()}
      },
      colModel: [
          { label: 'ID', name: 'account_financing_id', key: true, width: 100, hidden:true },
          { label : 'No. Pembiayaan', name : 'account_financing_no', width: 100, align:'left' },
          { label : 'Nama', name : 'nama', width: 150, align:'left' },
          { label : 'Pokok', name : 'pokok', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label : 'Margin', name : 'margin', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label : 'Saldo Pokok', name : 'saldo_pokok', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label : 'Saldo Margin', name : 'saldo_margin', width: 100, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label : 'Tanggal Akad', name : 'tanggal_akad', width: 75, align:'center', formatter:'date', formatoptions: {newformat: 'd/m/Y'} },
          { label : 'Angs. Terakhir', name : 'jtempo_angsuran_last', width: 80, align:'center', formatter:'date', formatoptions: {newformat: 'd/m/Y'} },
          { label : 'Angs. Selanjutnya', name : 'jtempo_angsuran_next', width: 80, align:'center', formatter:'date', formatoptions: {newformat: 'd/m/Y'} },
          { label : 'Total Angsuran', name : 'counter_angsuran', width: 75, align:'center' },
          { label : 'Jenis Angsuran', name : 'flag_jadwal_angsuran', width: 75, align:'center', formatter:function(cellvalue) {
            if ( cellvalue==0 ) {
              return 'Non-Reguler';
            } else {
              return 'Reguler';
            }
          } }
      ],
      viewrecords: true,
      autowidth: true,
      height: "200",
      rowNum: 50,
      rowList: [50,100,150],
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [true, "top"],
      sortname: "nama",
      sortorder: "asc",
      multiselect: false,
      footerrow: false,
      pager: "#jqGridPager_pembatalan_angsuran",
  });

  $('#t_jqGrid_pembatalan_angsuran').append('\
    <div style="padding:5px;"> \
      <button class="btn-primary" id="btn-batal">Batalkan Angsuran</button> \
    </div> \
  ');

  $('#btn-search').click(function(e){
    e.preventDefault();
    $('#jqGrid_pembatalan_angsuran').trigger('reloadGrid');
  })

  $('#nama,#cif_no,#account_financing_no').keypress(function(e){
    if ( e.keyCode == 13 ) {
      $('#jqGrid_pembatalan_angsuran').trigger('reloadGrid');
    }
  })

  //BEGIN DIALOG DETAIL
  $("#dialog_detail").dialog({
    autoOpen: false,
    modal: true,
    width:500,
    height:400
  });

  var t_dialog = $("#t_dialog");
  $("#cancel").click(function(){
    $("#dialog_detail").dialog('close');
  });
  $("#detail").click(function(){
    var selrow = $("#jqGrid_pembatalan_angsuran").jqGrid('getGridParam','selrow');
    var data   = $("#jqGrid_pembatalan_angsuran").jqGrid('getRowData',selrow);
    var account_financing_id = data.account_financing_id;
    if (account_financing_id==null){
      alert("Please Select Row !");
    }else{
      $.ajax({
        type: "POST",
        url: site_url+"transaction/get_account_financing_by_financing_id",
        dataType: "json",
        data: {account_financing_id:account_financing_id},
        success: function(response){
            $("#t_nama",t_dialog).html(": "+response.nama);
            $("#t_account_no",t_dialog).html(": "+response.account_financing_no);
            $("#t_pokok",t_dialog).html(": Rp. "+number_format(response.pokok,0,',','.'));
            $("#t_margin",t_dialog).html(": Rp. "+number_format(response.margin,0,',','.'));
            $("#t_saldo_pokok",t_dialog).val(response.saldo_pokok);
            $("#t_saldo_pokok",t_dialog).val(response.saldo_pokok);
            $("#t_saldo_margin",t_dialog).html(": Rp. "+number_format(response.saldo_margin,0,',','.'));
            $("#t_counter",t_dialog).val(response.counter_angsuran);
            $("#t_account_financing_id",t_dialog).val(response.account_financing_id);
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administration!")
        }
      });
      $("#dialog_detail").dialog('open');
    }
  })

  $("#act_submit").click(function(){
    var conf = confirm('Apakah anda yakin ingin merubah Angsuran ini?');
    if ( conf ) {
      var t_account_financing_id = $('#t_account_financing_id').val();
      var t_saldo_pokok = convert_numeric($('#t_saldo_pokok').val());
      var t_counter = $('#t_counter').val();
      $.ajax({
        type:"POST",dataType:"json",data:{
          account_financing_id:t_account_financing_id
         ,saldo_pokok:t_saldo_pokok
         ,counter:t_counter
        },
        url:site_url+'transaction/update_rek_pembiayaan',
        success: function(response){
          if(response.success==true){
            alert('Data berhasil diubah!');
            $("#dialog_detail").dialog('close');
            $('#jqGrid_pembatalan_angsuran').trigger('reloadGrid');
          } else {
            alert('Data gagal diubah!');
          }
        }
      })
    }
  });

  $('#btn-batal').click(function(){
    selrow = $('#jqGrid_pembatalan_angsuran').jqGrid('getGridParam','selrow');
    $('#add').show();
    $('#grid').hide();
    if ( selrow ) {
      data = $('#jqGrid_pembatalan_angsuran').jqGrid('getRowData',selrow);
      account_financing_no = data.account_financing_no;
      $.ajax({
        type:"POST",dataType:"json",data:{
          account_financing_no:account_financing_no
        },
        url:site_url+'transaction/get_data_for_pembatalan_angsuran',
        success: function(response){
          if ( typeof(response.trx_account_financing_id) == 'undefined' ) {
            alert('Maaf, Pembiayaan ini belum melakukan Angsuran!');
          } else {
            form = $('#form-batal');
            $('#trx_account_financing_id',form).val(response.trx_account_financing_id);
            $('#account_financing_no',form).val(response.account_financing_no);
            $('#nama',form).val(response.nama);
            $('#tanggal_akad',form).val(App.ToDatePicker(response.tanggal_akad));
            $('#pokok',form).val(number_format(response.pokok,0,',','.'));
            $('#margin',form).val(number_format(response.margin,0,',','.'));
            $('#angsuran_pokok',form).val(number_format(response.angsuran_pokok,0,',','.'));
            $('#angsuran_margin',form).val(number_format(response.angsuran_margin,0,',','.'));
            $('#jto_date',form).val(App.ToDatePicker(response.jto_date));
            $('#trx_date',form).val(App.ToDatePicker(response.trx_date));
            $('#angsuran_ke',form).val(response.angsuran_ke);
          }
        }
      })
    } else {
      alert('Please select a row!');
    }
  })

  $('#btn-kembali').click(function(e){
    e.preventDefault();
    $("#add").hide();
    $('#grid').show();
  });

  $("#btn-submit-batal").click(function(e){
    e.preventDefault();
    conf = confirm('Apakah anda yakin ingin membatalkan Angsuran ini?');
    if ( conf ) {
      $.ajax({
        type:"POST",dataType:"json",data:form.serialize(),
        url:site_url+'transaction/do_pembatalan_angsuran',
        success: function(response) {
          if ( response.success===true ) {
            App.SuccessAlert('Pembatalan Angsuran Berhasil.');
            $('#add').hide();
            $('#grid').show();
            $('#jqGrid_pembatalan_angsuran').trigger('reloadGrid');
          } else {
            App.WarningAlert('Failed to connect into database, Please Contact Your Administrator!')
          }
        },
        error: function(){
          App.WarningAlert('Failed to connect into database, Please Contact Your Administrator!')
        }
      })
    }
  })

});
</script>