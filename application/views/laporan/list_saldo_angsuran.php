<!--BEGIN PAGE HEADER-->
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
        Saldo untuk Angsuran <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN FILTER FORM -->
<table id="list_saldo_angsuran"></table>
<div id="plist_saldo_angsuran"></div>
<!-- END FILTER-->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">
  $(function(){
  /* BEGIN SCRIPT */

	view_grid_saldo_angsuran();

  function view_grid_saldo_angsuran()
  {
    jQuery("#list_saldo_angsuran").jqGrid({
      url: site_url+"laporan/jqgrid_list_saldo_angsuran",
      datatype: 'json',
      height: 'auto',
      autowidth: true,
      postData: {
         from_date : function(){return $('#from_date').val()}
        ,thru_date : function(){return $('#thru_date').val()}
        ,akad : function(){return $("#akad").val()}
        ,status_telkom : function(){return $("#status_telkom").val()}
        // ,code_divisi : function(){return $("#code_divisi").val()}
        ,code_divisi : function(){
          var code_divisi = $("#code_divisi").val();
          var divisi_child = $("#divisi_child").val();
          if(code_divisi == 'PT. TELEKOMUNIKASI INDONESIA, Tbk'){
            return divisi_child;
          }else{
            return code_divisi
          }
        }
        ,produk_pembiayaan : function(){
          var produk_pembiayaan = $("#produk_pembiayaan").val();
          var product_code_smile = $("#product_code_smile").val();
          if(produk_pembiayaan == '52'){
            return product_code_smile;
          }else{
            return produk_pembiayaan
          }
        }
      },
      rowNum: 15,
      rowList: [50,100,150,200,250,300,350,400],
        colModel: [
          { label: 'No. Customer', name: 'account_saving_no', key: true, width: 80 },
          { label: 'Nama Lengkap', name: 'name', width: 50 },
          { label: 'Saldo Efektif', name: 'saldo_efektif', width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
        ],
        autowidth: true,
        shrinkToFit: true,
        pager: "#plist_saldo_angsuran",
        viewrecords: true,
        sortname: 'account_saving_no',
        grouping:false,
        rowNum: 999999999,
        rownumbers: true,
        footerrow: true,
        caption: "List Saldo untuk bayar angsuran",
        ondblClickRow:function(rowid){
          var selrow = $("#list_saldo_angsuran").jqGrid('getGridParam','selrow');
          var data   = $("#list_saldo_angsuran").jqGrid('getRowData',selrow);
          var account_saving_no     = data.account_saving_no;
          var win = window.open(site_url + 'transaction/penarikan_tab_angsuran/' + account_saving_no, '_blank');

       },
       gridComplete: function() {
          var $grid = $('#list_saldo_angsuran');
          var colSum = $grid.jqGrid('getCol', 'saldo_efektif', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'saldo_efektif': colSum });
        }

    });
  }

});
</script>
<!-- END JAVASCRIPTS