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
           
      <div class="portlet-body form">
        
        <div class="append-bu" style="float:right;margin-right:10px;">
          <?= $button_save ?>
        </div>
        
        <div class="portlet-body form">
          <div class="row-fluid">
             <div class="span12">
              <div id="wraper_table">
                <table id="jqGrid_saldo_awal"></table>
                <div id="jqGridPager_saldo_awal"></div>
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

  $("#jqGrid_saldo_awal").jqGrid({
      url: site_url+'migrasi/jqGrid_saldo_awal',
      mtype: "GET",
      datatype: "json",
      postData:{
          // file_name:function(){
          //   return $("#filenameupload").val();
          // }
      },
      colModel: [
          { label: 'ID', name: 'noid', key: true, width: 100, hidden:true },
          { label: 'KD_AC', name: 'kd_ac', width: 80, align:'center' },
          { label: 'ACCOUNT', name: 'akun', width: 270, align:'left' },
          { label: 'DEBET', name: 'debet', width: 100, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'KREDIT', name: 'kredit', width: 100, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ],
      viewrecords: true,
      autowidth: true,
      height: "400",
      rowNum: 999999999,
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [false, "top"],
      multiselect: false,
      footerrow: true,
      gridComplete: function() {
          var $grid = $('#jqGrid_saldo_awal');
          var colDebit = $grid.jqGrid('getCol', 'debet', false, 'sum');
          var colKredit = $grid.jqGrid('getCol', 'kredit', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'debet': colDebit, 'kredit' : colKredit });
      },
      pager: "#jqGridPager_saldo_awal"
  });

  /*Simpan Debet*/
  $("#save_trx").click(function(e){
    e.preventDefault();
    bValid = true;
    selrow=$("#jqGrid_saldo_awal").jqGrid('getGridParam','selrow');
    data=$("#jqGrid_saldo_awal").jqGrid('getRowData');
  
    var noid = []; var kd_ac = []; var akun = []; var debet = []; var kredit = [];

    for($i=0;$i<data.length;$i++){
      noid[$i] = data[$i].noid;
      kd_ac[$i] = data[$i].kd_ac;
      akun[$i] = data[$i].akun;
      debet[$i] = data[$i].debet;
      kredit[$i] = data[$i].kredit;
    }

    var inputpost = {
      noid : noid,
      kd_ac : kd_ac,
      akun : akun,
      debet : debet,
      kredit : kredit
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