<style type="text/css">
	.modal-lg {
		width: 900px;
	}
  .ui-jqgrid tr.jqgrow td {
      word-wrap: break-word; /* IE 5.5+ and CSS3 */
      white-space: pre-wrap; /* CSS3 */
      white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
      white-space: -pre-wrap; /* Opera 4-6 */
      white-space: -o-pre-wrap; /* Opera 7 */
      overflow: hidden;
      height: auto;
      vertical-align: middle;
      padding-top: 3px;
      padding-bottom: 3px
  }
  .ui-widget-header {
    border: 1px solid #8aa5c0;
    background: #8aa5c0;
    color: #fff;
    font-weight: bold
  }
</style>

<div id="detail_trx" class="modal hide fade bs-modal-lg" tabindex="-1" data-width="500" style="margin-top:-200px;width: 900px;left: 35%;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		   <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		      <h3>Histori Transaksi</h3>
		   </div>
		   <div class="modal-body">
		      <div class="row-fluid">
		         <div class="span12">
		            <table border="1" cellpadding="5" id="tbl_trx_detail" style="margin-bottom: 25px;">
		               <thead>
			               	<tr>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;" align="center">Diupload Oleh</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Tanggal Upload</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Verifikasi Oleh</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Tanggal Verifikasi</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Jumlah Pembayaran</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Tanggal Transaksi</td>
			               </tr>
			            </thead>
		               	<tbody></tbody>
		            </table> 

		            <table border="1" cellpadding="5" id="tbl_saving_detail" style="display:none; width: 70%">
		               <thead>
			               	<tr>
			               	 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;" align="center">Tanggal Transaksi</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;" align="center">Jumlah Tabungan</td>
			                 <td width="330" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center; font-weight: bold;"  align="center">Realisasi Pembayaran</td>
			               </tr>
			            </thead>
		               	<tbody></tbody>
		            </table> 
		         </div>
		      </div>
		   </div>
		   <div class="modal-footer">
		      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
		   </div>
		</div>
	</div>
</div>

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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Laporan <small>Kartu Pengawasan Angsuran</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->


<form action="#" id="form_add" class="form-horizontal">
<!-- BEGIN FILTER-->
<div class="row-fluid">
  <div class="span8">
    <div class="control-group" style="margin-bottom:0;">
       <label class="control-label" style="text-align:left;width:130px;">No Rekening<span class="required">*</span></label>
       <div class="controls" style="margin-left:0;">
          <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
          <input type="hidden" id="branch_code" name="branch_code">
          <input type="hidden" id="account_type" name="account_type">
          <input type="hidden" id="jenis_tabungan" name="jenis_tabungan">
          
          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3>Cari CIF</h3>
             </div>
             <div class="modal-body">
                <div class="row-fluid">
                   <div class="span12">
                      <h4>Masukan Kata Kunci</h4>
                      <?php
                      if($this->session->userdata('cif_type')==0){
                      ?>
                        <input type="hidden" id="cif_type" name="cif_type" value="0">
                        <p id="pcm" style="height:32px">
                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                        <option value="">Pilih Rembug</option>
                        <?php foreach($rembugs as $rembug): ?>
                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                        <?php endforeach; ?>;
                        </select></p>
                      <?php
                      }else if($this->session->userdata('cif_type')==1){
                        echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                      }else{
                      ?>
                        <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                        <option value="">Pilih Tipe CIF</option>
                        <option value="">All</option>
                        <option value="1">Individu</option>
                        <option value="0">Kelompok</option>
                        </select></p>
                        <p class="hide" id="pcm" style="height:32px">
                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                        <option value="">Pilih Rembug</option>
                        <?php foreach($rembugs as $rembug): ?>
                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                        <?php endforeach; ?>;
                        </select></p>
                      <?php
                      }
                      ?>
                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                      <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                <button type="button" id="select_res" class="btn blue">Select</button>
             </div>
          </div>

        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
       </div>
    </div>            
  </div>
  <div class="span4 text-right">
    <input type="hidden" name="hidden_account_financing_no" id="hidden_account_financing_no">
    <button type="button" id="export_pdf" class="btn green">Export Pdf</button> <button type="button" id="export_excel" class="btn green">Export Excel</button>  
  </div>
</div>
</form>
<table width="100%" style="border:solid 1px #CCC;margin-bottom:20px;" >
    <tr>
        <td>
          
          <table align="center" style="border:solid 1px #CCC; margin:10px auto;" width="60%">
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" width="15%">No.Rek Pembiayaan</td>
                    <td style="background:#EEE; padding:5px;" width="2%">:</td>
                    <td style="background:#EEE; padding:5px;" width="35%"><input id="res_no_rekening" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" width="15%">Plafon</td>
                    <td style="background:#EEE; padding:5px;" width="2%">:</td>
                    <td style="background:#EEE; padding:5px;"><input id="res_plafon" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >No.Rek Tabungan</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_no_rekening_tab" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Margin</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_margin" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Nama</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_nama" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Jangka Waktu</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_jangka_waktu" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Produk</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_produk" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Tgl. Cair</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_cair" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Untuk</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_untuk" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Tgl. J. Tempo</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_jtempo" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >PYD Ke</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_pydke" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Status Rek.</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_status_rek" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>

                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Saldo Pokok</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_salpokok" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Saldo Margin</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_salmargin" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>

                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Tertunggak Pokok</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_tertunggakpokok" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Tertunggak Margin</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_tertunggakmargin" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>

                <tr>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Tunggakan Freq.</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_tunggakanfreg" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                    <td style="white-space:nowrap; background:#EEE; padding:5px;" >Saldo Outstanding</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_saldooutstanding" type="text" style="font-size:12px;width:200px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;"></td>
                </tr>
          </table>

        </td>
    </tr>
    <tr>
        <td>
			<div class="span9 text-right" style="margin-bottom: 10px">
        <button type="button" id="btn_realisasi" class="btn blue">Lihat Realisasi <i class="icon-angle-down"></i></button>  
				<button type="button" id="btn_hide_realisasi" class="btn default" style="display: none">Tutup Realisasi <i class="icon-angle-up"></i></button>  
			</div>
			<div class="portlet-body form" style="border-bottom: 1px solid #eee; margin-bottom: 25px; padding-bottom: 25px;">
				<div class="row-fluid">
	             <div class="span10" id="span_realisasi" style="margin-left:25px;display: none">
	              <div id="wraper_table">
	                <table id="jqGrid_realisasi"></table>
	                <div id="jqGridPager_realisasi"></div>
	              </div>
	            </div>
	          </div>
			</div>
            <table align="center" style="border:solid 1px #CCC; margin:10px auto;"  width="70%"  id="isi_data">
              <thead>                  
                <tr>
                    <td colspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Tanggal</td>
                    <td colspan="4" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Angsuran</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Saldo Hutang</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Saldo Pokok</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Detail</td>
                </tr>
                <tr>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Angsur</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Bayar</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Ke</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Pokok</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Margin</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Jumlah</td>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </td>
    </tr>
</table>

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


<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
     
      $("#tanggal").inputmask("d/m/y", {autoUnmask: true});  //direct mask       
      $("#tanggal2").inputmask("d/m/y", {autoUnmask: true});  //direct mask      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'saldo_kas_petugas';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
$("#btn_realisasi").click(function(){
  view_jqGrid();
  $('#jqGrid_realisasi').trigger('reloadGrid');
  $("#span_realisasi").toggle();
  $("#btn_realisasi").hide();
  $("#btn_hide_realisasi").show();
  $('#jqGrid_realisasi').jqGrid('setGridWidth', '1020');
});

$("#btn_hide_realisasi").click(function(){
  $("#span_realisasi").toggle();
  $("#btn_realisasi").show();
  $("#btn_hide_realisasi").hide();
});

function view_jqGrid()
{
  	/*$("#jqGrid_realisasi").jqGrid({
      url: site_url+'laporan/jqGrid_realisasi',
      mtype: "GET",
      datatype: "json",
      postData:{
        account_financing_no : function(){return $("#account_financing_no").val()}
      },
      colModel: [
          { label: 'ID', name: 'trx_account_financing_id', sortable: false, key: true, width: 100, hidden:true },
          { label: 'Diupload Oleh', sortable: false, width: 120, align:'center' },
          { label: 'Tanggal Upload', sortable: false, width: 120, align:'center' },
          { label: 'Verifikasi Oleh', sortable: false, width: 120, align:'center' },
          // { label: 'Tanggal Verifikasi', sortable: false, width: 120, align:'center' },
          { label: 'Angsuran Pokok',  name: 'angs_pokok', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Angsuran Margin',  name: 'angs_margin', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Jumlah Pembayaran',  name: 'amount', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Tanggal Transaksi', sortable: false, width: 120, align:'center' },
          { label: 'Deskripsi', sortable: false, width: 120, align:'left' },
      ],
      autowidth: true,
      shrinkToFit: true,
      pager: "#jqGridPager_realisasi",
      viewrecords: true,
      sortname: 'trx_account_financing_id',
      grouping:false,
      rowNum: 999999999,
      rownumbers: true,
      footerrow: true,
      gridComplete: function() {
        var $grid = $('#jqGrid_realisasi');
        var colSum = $grid.jqGrid('getCol', 'amount', false, 'sum');
        $grid.jqGrid('footerData', 'set', { 'amount': colSum });
      }
  });*/

  jQuery("#jqGrid_realisasi").jqGrid({
     url: site_url+'laporan/jqGrid_realisasi',
     mtype: "GET",
     datatype: 'json',
     height: 'auto',
     postData:{
        account_financing_no : function(){return $("#account_financing_no").val()}
      },
     rowNum: 999999999,
     autowidth: true,
     shrinkToFit: false,
       colNames:['ID', 'Diupload Oleh', 'Tanggal Upload', 'Verifikasi Oleh', 'Angsuran Pokok', 'Angsuran Margin', 'Muqassah', 'Jumlah Pembayaran', 'Tanggal Transaksi', 'Deskripsi'],
       colModel:[
          { name: 'trx_account_financing_id', sortable: false, key: true, width: 100, hidden:true },
          { sortable: false, width: 120, align:'center' },
          { sortable: false, width: 120, align:'center' },
          { sortable: false, width: 120, align:'center' },
          { name: 'angs_pokok', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { name: 'angs_margin', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { name: 'amount', sortable: false, width: 120, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { sortable: false, width: 120, align:'center' },
          { sortable: false, width: 120, align:'left' }
       ],
       pager: "#jqGridPager_realisasi",
       viewrecords: true,
       sortname: 'trx_account_financing_id',
       grouping:false,
       caption: "List Realisasi"
  });
}

 $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"search/account_financing_no",
              data: {keyword:$("#keyword").val(),status_rekening:'0',inverse:true},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){

                  if(response[i].status_rekening=='0'){
                    status = "baru registrasi"
                  }else if(response[i].status_rekening=='1'){
                    status = "aktif"
                  }else if(response[i].status_rekening=='2'){
                    status = "lunas"
                  }else if(response[i].status_rekening=='3'){
                    status = "verified"
                  }

                  option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].product_name+' - '+status+' - '+number_format(response[i].angsuran,0,',','.')+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"search/account_financing_no",
              data: {keyword:$("#keyword").val(),status_rekening:'0',inverse:true},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){

                  if(response[i].status_rekening=='0'){
                    status = "baru registrasi"
                  }else if(response[i].status_rekening=='1'){
                    status = "aktif"
                  }else if(response[i].status_rekening=='2'){
                    status = "lunas"
                  }else if(response[i].status_rekening=='3'){
                    status = "verified"
                  }

                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].product_name+' - '+status+' - '+number_format(response[i].angsuran,0,',','.')+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });
      
        $("#result option:selected").live('dblclick',function(){
          $("#select_res").trigger('click');        
        })

        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"search/account_financing_no",
              data: {keyword:$("#keyword").val(),status_rekening:'0',inverse:true},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+'</option>';
                }
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      

      // VIEW DATA YANG TERPILIH
      $("#select_res","#form_add").click(function()
        {
          $("#close","#dialog_rembug").trigger('click');
          var account_financing_no = $("#result").val();
          $("#account_financing_no").val(account_financing_no);
          $("#hidden_account_financing_no").val(account_financing_no);
            $.ajax({
              type: "POST",
              url: site_url+"laporan/get_kartu_pengawasan_angsuran_by_account_no",
              data: {account_financing_no:account_financing_no},
              dataType: "json",
              success: function(response)
              {

                  periode_jangka_waktu = '';
                  switch(response.periode_jangka_waktu){
                    case "0":
                    periode_jangka_waktu=' Hari';
                    break;
                    case "1":
                    periode_jangka_waktu=' Minggu';
                    break;
                    case "2":
                    periode_jangka_waktu=' Bulan';
                    break;
                    case "3":
                    periode_jangka_waktu='x Jatuh Tempo';
                    break;
                  }

                  switch(response.status_rekening){
                    case "0":
                    res_status_rek=' Baru Registrasi';
                    break;
                    case "1":
                    res_status_rek=' Aktif';
                    break;
                    case "2":
                    res_status_rek=' Lunas';
                    break;
                    case "3":
                    res_status_rek=' Verified';
                    break;                    
                  }

                  $("#res_nama").val(response.nama);
                  // $("#res_rembug").val(response.cm_name);
                  // $("#res_desa").val(response.desa);
                  $("#res_no_rekening").val(response.account_financing_no);
                  $("#res_no_rekening_tab").val(response.account_saving_no);
                  $("#res_jangka_waktu").val(response.jangka_waktu+''+periode_jangka_waktu);
                  $("#res_produk").val(response.product_name);
                  $("#res_untuk").val(response.untuk);
                  $("#res_plafon").val(number_format(response.pokok,0,',','.'));
                  $("#res_margin").val(number_format(response.margin,0,',','.'));
                  $("#res_cair").val(response.droping_date);
                  $("#res_jtempo").val(response.tanggal_jtempo);
                  $("#res_pydke").val(response.pydke);
                  $("#res_status_rek").val(res_status_rek);
                  $("#res_salpokok").val(number_format(response.saldo_pokok,0,',','.'));
                  $("#res_salmargin").val(number_format(response.saldo_margin,0,',','.'));
                  $("#res_tertunggakpokok").val(number_format(response.tunggakan_pokok,0,',','.'));
                  $("#res_tertunggakmargin").val(number_format(response.tunggakan_margin,0,',','.'));
                  $("#res_saldooutstanding").val(number_format(response.saldo_outstanding,0,',','.'));
                  $("#res_tunggakanfreg").val(response.tunggakan_freq);
                  
                if(response.nama!=undefined)
                {
                   $.ajax({
                      type: "POST",
                      url: site_url+"laporan/get_row_pembiayaan_by_account_no",
                      data: {account_financing_no:account_financing_no,cif_no:response.cif_no,cif_type:response.cif_type},
                      dataType: "html",
                      success: function(response)
                      {
                        $("#isi_data tbody").html(response);
                      }
                    });
                 }
                 else
                 {
                    $("#isi_data tbody").html('');
                 }
              }
            });

        });

   	
		$("#btn_detail_trx").live('click',function()
		{
			$('#detail_trx').modal('show');
			var trx_date = $(this).data('trx_date');
			var account_no = $(this).data('account_no');

			$.ajax({
	          type: "POST",
	          url: site_url+"laporan/check_detail_trx",
	          data: {trx_date:trx_date,account_financing_no:account_no},
	          dataType: "json",
	          success: function(response)
	          {
	            $("#tbl_trx_detail tbody").html(response.trx_detail);
	            if(response.saving_detail != ''){
	            	$("#tbl_saving_detail").show();
	            	$("#tbl_saving_detail tbody").html(response.saving_detail);
	            }else{
	            	$("#tbl_saving_detail").hide();
	            }
	          }
	        });
		});

      //export PDF
      $("#export_pdf").live('click',function()
      {
        var account_financing_no    = $("#hidden_account_financing_no").val();
        window.open('<?php echo site_url();?>laporan_to_pdf/export_kartu_pengawasan_angsuran/'+account_financing_no+'/');
      });
      //export XLS
      $("#export_excel").live('click',function()
      {
        var account_financing_no    = $("#hidden_account_financing_no").val();
        window.open('<?php echo site_url();?>laporan_to_excel/export_kartu_pengawasan_angsuran/'+account_financing_no+'/');
      });



      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

