<style type="text/css">
#plist485_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}
select {
    margin: 0;
    padding: 0;
    width: 40px;
    font-size:13px;
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
    <h3 class="page-title">
      Laporan Upload Pembayaran <small>Laporan Upload Pembayaran</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Upload Pembayaran</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

      <div class="clearfix">
            Tanggal Upload &nbsp; : &nbsp;
            <input type="text" tabindex="1" name="from_date" id="from_date" class="small m-wrap mask_date date-picker" placeholder="dd/mm/yyyy" style="width:100px !important;" value="<?php echo date('d/m/Y', strtotime("- 10 days"));?>">
            <span>s/d</span>
            <input type="text" tabindex="1" name="thru_date" id="thru_date" class="small m-wrap mask_date date-picker" placeholder="dd/mm/yyyy" style="width:100px !important;" value="<?php echo date('d/m/Y');?>">
            <button class="btn blue" id="filter">Filter</button>
            <button class="btn blue pull-right" id="download">Download  <i class="icon-download"></i></button>
      </div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<table id="jqGrid_table"></table>
<div id="pager_dataTable"></div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
      
    function detail_data(data) {
      var html = '';
      var nomor = 0;
      var tbody = '';
      for ( i in data ) {
          nomor++;
          if (data[i].flag_excess=='1') {
            _flag_excess = '<small class="badge bg-green center"><i class="fa fa-check"></i></small>';
          } else{
            _flag_excess = '<small class="badge bg-red center"><i class="fa fa-times"></i></small>';
          };
          tbody +='<tr> \
                    <td style="padding:3px;border:1px solid #ccc;">'+nomor+'</td> \
                    <td style="padding:3px;border:1px solid #ccc;">'+data[i].nik+'</td> \
                    <td style="padding:3px;border:1px solid #ccc;">'+data[i].nama_pegawai+'</td> \
                    <td style="padding:3px;border:1px solid #ccc;text-align:right;">'+number_format(data[i].jumlah_bayar,0,',','.')+'</td> \
                    <td style="padding:3px;border:1px solid #ccc;text-align:right;">'+number_format(data[i].jumlah_settle,0,',','.')+'</td> \
                    <td style="padding:3px;border:1px solid #ccc;text-align:right;">'+number_format(data[i].selisih,0,',','.')+'</td> \
                  </tr>';
      }

      /* begin detail */
      html += ' \
      <div class="bg-wrapper-detail"> \
          <div class="wrapper-detail" style="background:#fff;"> \
              <div class="row"> \
                  <div class="col-md-6"> \
                    <table style="margin:10px 0px 10px 40px"> \
                      <thead> \
                      <tr> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">No</th> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">Nik</th> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">Nama</th> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">Jumlah Bayar</th> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">Riil Debet</th> \
                        <th style="padding:4px;fotn-weight:bold;text-align:center;border:1px solid #ccc;">Selisih Debet</th> \
                      <tr> \
                      </thead> \
                      <tbody> \
                      '+tbody+' \
                      </tbody> \
                    </table> \
                  </div> \
              </div> \
          </div> \
      </div>'; /*end detail */
      
      return html;
    }


   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
   });

   $("#filter").click(function(){
    $("#jqGrid_table").trigger('reloadGrid');
   })
   $("#download").click(function(){
      var tanggal   = datepicker_replace($("#from_date").val());
      var tanggal2  = datepicker_replace($("#thru_date").val());
      window.open('<?php echo site_url();?>laporan_to_csv/export_data_pembayaran/'+tanggal+'/'+tanggal2+'/download');
   })

   //GRID SEMUA DATA TRANSAKSI
   jQuery("#jqGrid_table").jqGrid({
     url: site_url+'laporan/grid_angsuran',
     //data: mydata,
     datatype: 'json',
     height: 'auto',
     postData: {
       from_date : function(){return $("#from_date").val()},
       thru_date: function(){return $("#thru_date").val()}
     },
      colModel: [
          { label: 'angsuran_id', name: 'angsuran_id' , key:true, hidden:true }
          ,{ label: 'Tanggal', name: 'import_date' , width: 120, align:'center' }
          ,{ label: 'File', name: 'file_name' , width: 200, align:'left' }
          ,{ label: 'Keterangan', name: 'keterangan' , width: 150, align:'left' }
          ,{ label: 'Import Oleh', name: 'import_by' , width: 100, align:'left' }
          ,{ label: 'Status', name: 'status' , width: 90, align:'left',hidden:true }
      ],
      viewrecords: true,
      autowidth: true,
      height: 400,
      rowNum: 20,
      rowList: [10,15,20,50],
      rownumbers: true,
      shrinkToFit: false,
      // toolbar: [false, "top"],
      sortname: "import_date",
      sortorder: "desc",
      multiselect: false,
      pager: "#pager_dataTable",
      subGrid:true,
      subGridRowExpanded: function(subgrid_id, row_id) {
          row = $("#jqGrid_table").jqGrid('getRowData',row_id);
          angsuran_id = row.angsuran_id;
          $.ajax({
              type:"POST",dataType:"json",data:{angsuran_id:angsuran_id},async:false,
              url:site_url+'laporan/data_detail_angsuran_temp',
              success:function(data) {
                  html = detail_data(data);
                  $("#" + subgrid_id).append(html);

              },
              error:function(){
                  alert('Failed to connect into databases, please contact your Administrator');
              }
          })
      }
   });
   </script>
   <!-- END JAVASCRIPTS -->

