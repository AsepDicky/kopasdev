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
    <h3 class="page-title">
      Pembiayaan <small>Approval SPB</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Approval SPB</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Approval SPB</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
    <input type="hidden" id="kode_jabatan" value="<?= $this->session->userdata('kode_jabatan') ?>">
    <table id="grid_spb"></table>
    <div id="pgrid_spb"></div>
   </div>
</div>
<div class="portlet box green" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Detail Data SPB</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
    <input type="hidden" name="id_spb" id="id_spb">
    <input type="hidden" name="no_spb" id="no_spb">
    <input type="hidden" name="status_approve" id="status_approve">
    <table id="grid_spb_detail"></table>
    <div id="pgrid_spb_detail"></div>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

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

<style type="text/css">
  #t_grid_spb_detail{
    padding: 5px 5px 5px 5px;
  }
</style>

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

    /*JQGRID SPB*/
    $("#grid_spb").jqGrid({
        url: site_url+'rekening_nasabah/jqgrid_approval_spb',
        mtype: "GET",
        datatype: "json",
        colModel: [
            { label: 'ID', name: 'id_spb', key: true, hidden:true, width: 80 },
            { label: 'No. SPB', name: 'no_spb', width: 80, align:"center" },
            { label: 'Tanggal SPB', name: 'tanggal_spb', width: 80, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
            { label: 'Pembiayaan', name: 'pokok', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            // { label: 'Angs. Pertama', name: 'angsuran_pertama', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Biaya Adm', name: 'biaya_administrasi', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Biaya Notaris', name: 'approval_spb', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Kewajiban Koptel', name: 'kewajiban_koptel', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Kewajiban Kopegtel', name: 'kewajiban_kopegtel', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Premi Asuransi', name: 'premi_asuransi', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Approved 1', name: 'approved1', width: 80, align:"center" },
            { label: 'Approved 2', name: 'approved2', width: 80, align:"center" },
            { label: 'Approved 3', name: 'approved3', width: 80, align:"center" },
            { label: 'Checked', name: 'checked', width: 80, align:"center" },
            { label: 'Action', name: 'label_class', width: 80, align:"center" }
        ],
        viewrecords: true,
        autowidth: true,
        height: 150,
        rowNum: 9999999,
        rownumbers: true,
        shrinkToFit: false,
        toolbar: [false, "top"],
        sortname: "no_spb",
        sortorder: "asc",
        multiselect: false
    });

    $("a#link-detail").livequery('click',function(){
        var id_spb = $(this).attr('id_spb');
        var no_spb = $(this).attr('no_spb');
        var tanggal_spb = $(this).attr('tanggal_spb');
        var status_approve = $(this).attr('status_approve');
        $("#id_spb").val(id_spb);
        $("#status_approve").val(status_approve);
        $("#no_spb").val(no_spb);
        jQuery("#grid_spb_detail").setGridParam({ 
          postData: { 
            no_spb : no_spb
          }
        }).trigger("reloadGrid");
    });

    /*JQGRID SPB DETAIL*/
    $("#grid_spb_detail").jqGrid({
        url: site_url+'rekening_nasabah/jqgrid_approval_spb_detail',
        mtype: "GET",
        datatype: "json",
        colModel: [
            { label: 'ID', name: 'no_spb', key: true, hidden:true, width: 100 },
            { label: 'No. Pembiayaan', name: 'account_financing_no', width: 100, align:"center" },
            { label: 'Nama', name: 'nama', width: 200, align:"left" },
            { label: 'Tgl Akad', name: 'droping_date', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
            { label: 'Tgl Transfer', name: 'tanggal_transfer', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
            { label: 'Pembiayaan', name: 'pokok', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Angs. Pertama', name: 'angsuranke1', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Biaya Adm', name: 'biaya_adm', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Biaya Notaris', name: 'biaya_notaris', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Kewajiban Koptel', name: 'kewajiban_koptel', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Kewajiban Kopegtel', name: 'kewajiban_kopegtel', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
            { label: 'Premi Asuransi', name: 'premi_asuransi', width: 80, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}}
        ],
        viewrecords: true,
        autowidth: true,
        height: 200,
        rowNum: 99999999,
        rownumbers: true,
        shrinkToFit: false,
        toolbar: [true, "top"],
        sortname: "b.no_spb",
        sortorder: "asc",
        multiselect: false
    });

    var kode_jabatan = $("#kode_jabatan").val();
    if(kode_jabatan==201){
      btn_txt = 'Verification';
    }else{
      btn_txt = 'Approve';
    }

    $("#t_grid_spb_detail").append('<button class="btn mini green" id="act_approve">'+ btn_txt +'</button>');

    $("#act_approve").live('click',function()
    {
        var id_spb = $("#id_spb").val();
        var status_approve = $("#status_approve").val();
        var no_spb = $("#no_spb").val();
        var conf = confirm('Approval SPB ?');
        
        if(conf){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/act_approve_spb",
            dataType: "json",
            data: {
               id_spb:id_spb
              ,status_approve:status_approve
              ,no_spb:no_spb
            },
            success: function(response){
              if(response.success==true){
                $.alert({
                  title:"Success",icon:'icon-check',backgroundDismiss:false,
                  content:response.msg,
                  confirmButtonClass:'btn green',
                  confirm:function(){
                    location.reload();
                  }
                })
              }else{
                App.WarningAlert("Gagal diapprove!");
              }
            },
            error: function(){
              App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
          })
        }    
    });

</script>
<!-- END JAVASCRIPTS -->

