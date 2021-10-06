<style type="text/css">
#form input:focus, #form select:focus {
  border: solid 1px blue;
}
</style>
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
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title">
      Verifikasi Transaksi Rembug <small>Untuk melakukan verifikasi transaksi rembug</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select" class="btn blue">Select</button>
   </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Transaksi Rembug</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <label>
            Kantor Cabang &nbsp; : &nbsp;
            <input type="text" name="src_branch_name" id="src_branch_name" class="medium m-wrap" disabled>
            <input type="hidden" name="branch_code" id="branch_code">
            <input type="hidden" name="branch_id" id="branch_id">
            <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
            &nbsp; &nbsp;
            Tanggal Transaksi &nbsp; : &nbsp;
            <input type="text" name="src_trx_date" id="src_trx_date" value="<?php echo $current_date; ?>" class="small m-wrap date-picker date-mask">
            <input type="submit" id="search" value="Filter" class="btn green">
         </label>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#transaksi_kas_petugas .checkboxes" /></th> -->
               <!-- <th width="16.5%">Kantor Cabang</th> -->
               <th width="35%" style="text-align:center;">Rembug Pusat</th>
               <th width="20%" style="text-align:center;">Tanggal</th>
               <th width="35%" style="text-align:center;">Kas Petugas</th>
               <!-- <th width="16.5%">Nominal</th> -->
               <!-- <th width="16.5%">Keterangan</th> -->
               <th width="10%" style="text-align:center;">Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->








<div id="edit" class="hide">
      <hr size="1">
      <table>
        <tr>
          <td width="120">Kantor Cabang <span style="color:red">*</span></td>
          <td>
            <input type="text" id="view_branch_name" readonly value="" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
            <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
          </td>
          <td width="100"></td>
          <td width="100">Tanggal <span style="color:red">*</span></td>
          <td><input type="text" id="view_trx_date" readonly value="" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
          <td></td>
        </tr>
        <tr>
          <td width="100">Rembug Pusat <span style="color:red">*</span></td>
          <td>
            <input type="text" id="view_cm_name" readonly style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
          </td>
          <td width="100"></td>
          <td>Kas Petugas <span style="color:red">*</span></td>
          <td width="300">
            <input type="text" id="view_account_cash_name" readonly style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;width:100% !important">
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
      </table>
      <form id="process_trx_rembug" method="post" style="margin-bottom:0px;">
        <input type="hidden" name="fa_code" id="fa_code">
        <input type="hidden" name="account_cash_code" id="account_cash_code">
        <input type="hidden" name="cm_code" id="cm_code">
        <input type="hidden" name="branch_code" id="branch_code">
        <input type="hidden" name="branch_id" id="branch_id">
        <input type="hidden" name="tanggal2" id="tanggal2">
        <input type="hidden" name="trx_cm_save_id" id="trx_cm_save_id">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
                <td style="background:#EEE;border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="3" valign="middle" align="center"><div id="loading-overlay"></div>ID</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="15%" rowspan="3" valign="middle" align="center">NAMA</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="5%" rowspan="3" valign="middle" align="center">Absen</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="30%" colspan="5" valign="middle" align="center">SETORAN</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="10%" colspan="1" valign="middle" align="center">PENARIKAN</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="25%" colspan="3" valign="middle" align="center">REALISASI PEMBIAYAAN</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="90" rowspan="3" valign="middle" align="center">+/-</td> -->
              </tr>
              <tr>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" colspan="2" valign="middle" align="center">Angsuran</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Wajib</td> -->
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Sukarela</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Setoran Lain</td> -->
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Minggon</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Berencana</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Droping</td> -->
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Wajib</td> -->
                <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Sukarela</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Plafon</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Adm.</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Asuransi</td>
              </tr>
              <tr>
                <td valign="middle" align="center" style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">Frek</td>
                <td valign="middle" align="center" style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">@</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td>
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:8px">
                    <option>H</option>
                    <option>I</option>
                    <option>S</option>
                    <option>A</option>
                  </select>
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:20px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" style="border-left: solid 1px #CCC"></td>
                <td align="right" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-left:solid 1px #CCC; border-right:solid 1px #CCC;">Total</td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_angsuran" name="total_angsuran" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_setoran_tab_sukarela" name="total_setoran_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_minggon" name="total_minggon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" id="total_setoran_tab_berencana" name="total_setoran_tab_berencana" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" id="total_penarikan_tab_sukarela" name="total_penarikan_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_plafon" name="total_realisasi_plafon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_adm" name="total_realisasi_adm" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_asuransi" name="total_realisasi_asuransi" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
              </tr>
              <tr>
                <td colspan="3" style="border-left: solid 1px #CCC"></td>
                <td align="right" valign="middle" style="padding:0 5px;"></td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">
                  &nbsp;
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">
                  &nbsp;
                </td>
              </tr>
              <tr>               
                <td colspan="3" style="border-left:solid 1px #CCC;"></td>
                <td colspan="2" align="center" valign="middle" style="background:#EEE; padding:0 5px; border:solid 1px #CCC;">
                  Kas Awal
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Infaq
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Setoran
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Penarikan
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Saldo Kas
                </td>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">&nbsp;</td>
              </tr>
              <tr>               
                <td colspan="3" style="border-left:solid 1px #CCC;"></td>
                <td colspan="2" align="center" valign="middle" style="padding:0 5px; border-left:solid 1px #CCC; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="kas_awal" class="mask-money" readonly name="kas_awal" value="0" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="infaq_kelompok" class="mask-money" readonly name="infaq_kelompok" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="setoran" class="mask-money" name="setoran" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="penarikan" class="mask-money" name="penarikan" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="saldo_kas" class="mask-money" name="saldo_kas" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                </td>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="12" style="border-left: solid 1px #CCC; border-right:solid 1px #CCC;"> &nbsp; </td>
              </tr>
            </tfoot>
          </table>
      <!-- </div> -->
      </form>
      <div class="form-actions" align="center" style="padding-left:0; padding-right:0;border-left: solid 1px #CCC; border-right: solid 1px #CCC; border-bottom: solid 1px #CCC; border-top: solid 1px #CCC; margin-top:0px;">
         <button type="submit" class="btn green" id="save_trx">Approve</button>
         <button type="submit" style="margin-left:10px;" class="btn purple" id="reject_trx">Reject</button>
         <button type="reset" style="margin-left:10px;" class="btn red" id="cancel_trx">Cancel</button>
      </div>

</div>


























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
      Index.init();
      $(".date-mask").inputmask("d/m/y");  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  $("#browse_branch").click(function(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$("input#keyword","#dialog_branch").val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
  });

  $("#result option","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  });

  $("input#keyword","#dialog_branch").keypress(function(e){
    if(e.which==13){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$(this).val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
    }
  });

  // select
  $("#select","#dialog_branch").click(function(){
    branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
    branch_id = $("#result","#dialog_branch").val();
    $("#src_branch_name").val(branch_name);
    $("#branch_code").val(branch_code);
    $("#branch_id").val(branch_id);
    $("#close").click();
  });

  $("#search").click(function(){
      $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
      $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
      $("#close","#dialog_rembug").trigger('click');

      // begin first table
      $('#transaksi_kas_petugas').dataTable({
         "bDestroy":true,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": site_url+"transaction/datatable_verifikasi_trx_rembug",
         "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_id", "value": $("#branch_id").val() } );
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
              aoData.push( { "name": "trx_date", "value": $("#src_trx_date").val() } );
          },
         "aoColumns": [
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
              "sLengthMenu": "_MENU_ records per page",
              "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
              }
          },
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [3]
              }
          ]
      });
      $(".dataTables_length,.dataTables_filter").parent().hide();
  })

  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload = function()
  {
    var tbl_id = 'transaksi_kas_petugas';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  // begin first table
  $('#transaksi_kas_petugas').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_verifikasi_trx_rembug",
      "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_id", "value": $("#branch_id").val() } );
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
              aoData.push( { "name": "trx_date", "value": $("#src_trx_date").val() } );
          },
      "aoColumns": [
        null,
        null,
        null,
        { "bSortable": false, "bSearchable": false }
      ],
      "aLengthMenu": [
          [5, 15, 20, -1],
          [5, 15, 20, "All"] // change per page values here
      ],
      // set the initial value
      "iDisplayLength": 15,
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
          "sLengthMenu": "_MENU_ records per page",
          "oPaginate": {
              "sPrevious": "Prev",
              "sNext": "Next"
          }
      },
      "aoColumnDefs": [{
              'bSortable': false,
              'aTargets': [3]
          }
      ]
  });
  $(".dataTables_length,.dataTables_filter").parent().hide();

  // event button Edit ketika di tekan
  $("a#link-verifikasi").live('click',function(){
    $("#wrapper-table").hide();
    $("#edit").show();
    var trx_cm_save_id = $(this).attr('trx_cm_save_id');
    $("#trx_cm_save_id").val(trx_cm_save_id);

    $("#fa_code","#process_trx_rembug").val($(this).attr('fa_code'));
    $("#account_cash_code","#process_trx_rembug").val($(this).attr('account_cash_code'));
    $("#cm_code","#process_trx_rembug").val($(this).attr('cm_code'));
    $("#branch_code","#process_trx_rembug").val($(this).attr('branch_code'));
    $("#branch_id","#process_trx_rembug").val($(this).attr('branch_id'));
    $("#tanggal2","#process_trx_rembug").val($(this).attr('tanggal2'));

    $("#view_branch_name").val($(this).attr('branch_name'));
    $("#view_cm_name").val($(this).attr('cm_name'));
    $("#view_trx_date").val($(this).attr('trx_date'));
    $("#view_account_cash_name").val($(this).attr('account_cash_name'));


    /* loading */
    // [begin] generate from transaksi rembug
    $.ajax({
        url: site_url+"transaction/get_trx_rembug_data",
        type: "POST",
        dataType: "json",
        data: { cm_code : $("input[name='cm_code']").val(), account_cash_code : $("input[name='account_cash_code']").val(), tanggal : $("#src_trx_date").val() },
        async: false,
        success: function(respon){
          html = '';
          total_angsuran = 0;
          response = respon['data'];
          total_realisasi_plafon = 0;
          total_realisasi_adm = 0;
          total_realisasi_asuransi = 0;
          total_setoran_tab_berencana = 0;
          total_setoran_minggon = 0;
          if(response.length>0)
          {
            for ( i = 0 ; i < response.length ; i++ )
            {
              tabungan_berencana = '';
              for ( h = 0 ; h < respon['tab_berencana'][i].length ; h++ )
              {
                tabungan_berencana += ' \
                  <tr> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;"><input type="hidden" name="detail_berencana_account_no['+i+'][]" value="'+respon['tab_berencana'][i][h].account_saving_no+'" id="detail_berencana_account_no">'+respon['tab_berencana'][i][h].account_saving_no+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;">'+respon['tab_berencana'][i][h].product_name+'<input type="hidden" name="detail_berencana_product_code['+i+'][]" value="'+respon['tab_berencana'][i][h].product_code+'"></td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center">'+respon['tab_berencana'][i][h].rencana_setoran+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center"><input type="text" name="detail_berencana_freq['+i+'][]" id="detail_berencana_freq" maxlength="2" value="1" style="text-align:center;width:20px;margin:0;background:#CCC" class="m-wrap" readonly="readonly"><input type="hidden" id="detail_berencana_setoran" name="detail_berencana_setoran['+i+'][]" value="'+respon['tab_berencana'][i][h].rencana_setoran+'"></td> \
                  </tr> \
                ';
              }
              total_angsuran += parseFloat(response[i].jumlah_angsuran);
              total_realisasi_plafon += parseFloat(response[i].pokok);
              total_realisasi_adm += parseFloat(response[i].adm);
              total_realisasi_asuransi += parseFloat(response[i].asuransi);
              total_setoran_tab_berencana += parseFloat(response[i].setoran_berencana);
              minggon = parseFloat(response[i]['setoran_mingguan'])+parseFloat(response[i]['setoran_lwk']);
              total_setoran_minggon+=parseFloat(minggon);
              html += ' \
              <tr '+((response[i].status==3)?'bgcolor="#55ACEE"':'')+'> \
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">'+response[i].cif_no+'<input type="hidden" name="cif_no[]" id="cif_no" value="'+response[i].cif_no+'"></td> \
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">'+response[i].nama+'</td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" id="absen" name="absen[]"> \
                  <select disabled readonly id="vabsen" style="width:50px;margin-top:8px"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="angsuran_pokok[]" id="angsuran_pokok" value="'+response[i].angsuran_pokok+'"> \
                  <input type="hidden" name="angsuran_margin[]" id="angsuran_margin" value="'+response[i].angsuran_margin+'"> \
                  <input type="hidden" name="angsuran_catab[]" id="angsuran_catab" value="'+response[i].angsuran_catab+'"> \
                  <input type="hidden" name="angsuran_tab_wajib[]" id="angsuran_tab_wajib" value="'+response[i].angsuran_tab_wajib+'"> \
                  <input type="hidden" name="angsuran_tab_kelompok[]" id="angsuran_tab_kelompok" value="'+response[i].angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="balance_angsuran[]" id="balance_angsuran" value="'+response[i].angsuran+'"> \
                  <input type="hidden" name="balance_tabungan_wajib[]" id="balance_tabungan_wajib" value="'+response[i].tabungan_wajib+'"> \
                  <input type="hidden" name="balance_tabungan_sukarela[]" id="balance_tabungan_sukarela" value="'+response[i].tabungan_sukarela+'"> \
                  <input type="hidden" name="balance_transaksi_lain[]" id="balance_transaksi_lain" value="'+response[i].transaksi_lain+'"> \
                  <input type="hidden" name="balance_pokok_pembiayaan[]" id="balance_pokok_pembiayaan" value="'+response[i].pokok_pembiayaan+'"> \
                  <input type="hidden" name="balance_margin_pembiayaan[]" id="balance_margin_pembiayaan" value="'+response[i].margin_pembiayaan+'"> \
                  <input type="hidden" name="balance_catab_pembiayaan[]" id="balance_catab_pembiayaan" value="'+response[i].catab_pembiayaan+'"> \
                  <input type="hidden" name="balance_tabungan_kelompok[]" id="balance_tabungan_kelompok" value="'+response[i].tabungan_kelompok+'"> \
                  <input type="hidden" name="muqosha[]" id="muqosha" value="0"> \
                  <input type="text" readonly name="freq[]" id="freq" value="0" style="font-size:12px;width:20px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="jumlah_angsuran[]" class="mask-money" readonly id="jumlah_angsuran" value="'+response[i].jumlah_angsuran+'" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" readonly class="mask-money" name="setoran_tabungan_sukarela[]" id="setoran_tabungan_sukarela" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="setoran_minggon[]" id="setoran_minggon" value="'+number_format(minggon,0,',','.')+'" readonly style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
\
                               \
                    <!-- DIALOG MINGGON --> \
                    <div id="dialog_minggon_'+i+'" class="modal hide fade"  data-width="500" style="margin-top:-200px;"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h4>Setoran Minggon <span id="minggon_cif">"'+response[i]['cif_no']+'"</span></h4> \
                       </div> \
                       <div class="modal-body"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="500"> \
                                  <tr> \
                                    <td width="150">Setoran LWK</td> \
                                    <td width="10">:</td> \
                                    <td><input type="text" maxlength="10" class="mask-money" name="setoran_lwk[]" id="setoran_lwk" readonly style="#EEE" value="'+response[i]['setoran_lwk']+'"></td> \
                                  </tr> \
                                  <tr> \
                                    <td>Setoran Mingguan</td> \
                                    <td>:</td> \
                                    <td><input type="text" maxlength="10" class="mask-money" name="setoran_mingguan[]" id="setoran_mingguan" disabled value="'+response[i]['setoran_mingguan']+'"></td> \
                                  </tr> \
                                </table> \
                             </div> \
                          </div> \
                       </div> \
                       <div class="modal-footer"> \
                          <button type="button" id="close" style="display:none;" data-dismiss="modal" class="btn">Close</button> \
                          <button type="button" id="btnoksetminggon" formid="'+i+'" class="btn blue">OK</button> \
                       </div> \
                    </div> \
                    <a href="#dialog_minggon_'+i+'" id="open_dialog_minggon" style="display:none;" data-toggle="modal">open</a> \
 \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="setoran_tab_berencana[]" readonly id="setoran_tab_berencana" value="'+number_format(response[i].setoran_berencana,0,',','.')+'" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                  <input type="hidden" name="setoran_tab_berencana_product_code[]" id="setoran_tab_berencana_product_code" value="'+response[i].product_code+'"> \
 \
                               \
                    <!-- DIALOG TABUNGAN BERENCANA --> \
                    <div id="dialog_tabungan_berencana_'+i+'" class="modal hide fade"  data-width="500" style="margin-top:-200px;"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h3>Form Detil Setoran Tabungan Berencana</h3> \
                       </div> \
                       <div class="modal-body"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="100%"> \
                                  <thead> \
                                    <tr> \
                                      <th style="border:solid 1px #CCC;">Account</th> \
                                      <th style="border:solid 1px #CCC;">Produk</th> \
                                      <th style="border:solid 1px #CCC;">Setoran</th> \
                                      <th style="border:solid 1px #CCC;">Frekuensi</th> \
                                    </tr> \
                                  </thead> \
                                  <tbody> \
                                  '+tabungan_berencana+' \
                                  </tbody> \
                                </table> \
                             </div> \
                          </div> \
                       </div> \
                       <div class="modal-footer"> \
                          <button type="button" id="close" style="display:none;" data-dismiss="modal" class="btn">Close</button> \
                          <button type="button" id="btnokfrmtaberencana" formid="'+i+'" class="btn blue">OK</button> \
                       </div> \
                    </div> \
                    <a href="#dialog_tabungan_berencana_'+i+'" id="open_dialog_tabungan_berencana" style="display:none;" data-toggle="modal">open</a> \
 \
                     \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" readonly name="penarikan_tabungan_sukarela[]" class="mask-money" id="penarikan_tabungan_sukarela" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_plafon[]" id="realisasi_plafon" class="mask-money" readonly value="'+response[i].pokok+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                  <input type="hidden" name="realisasi_margin[]" id="realisasi_margin" class="mask-money" readonly value="'+response[i].margin+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_adm[]" id="realisasi_adm" readonly class="mask-money" value="'+response[i].adm+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="droping[]" id="droping" value="'+response[i].droping+'"> \
                  <input type="text" name="realisasi_asuransi[]" readonly class="mask-money" id="realisasi_asuransi" value="'+response[i].asuransi+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
              </tr> \
              ';
            }
            
            $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
            // $("#kas_awal").val(respon['kas_awal']);
            $("#total_realisasi_plafon").val(number_format(total_realisasi_plafon,0,',','.'));
            $("#total_realisasi_adm").val(number_format(total_realisasi_adm,0,',','.'));
            $("#total_realisasi_asuransi").val(number_format(total_realisasi_asuransi,0,',','.'));
            $("#total_setoran_tab_berencana").val(number_format(total_setoran_tab_berencana,0,',','.'));
            $("#total_minggon").val(number_format(total_setoran_minggon,0,',','.'));
            $("#form tbody").html(html);
            calc_setoran();
            calc_penarikan();
            calc_saldo_kas();
          }
          else
          {
            alert("Data Peserta Tidak Ditemukan !");
            html = ' \
              <tr> \
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td> \
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:8px"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:20px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> \
                </td> \
              </tr> \
            ';
            $("#total_angsuran").val(0);
            // $("#kas_awal").val(respon['kas_awal']);
            $("#realisasi_plafon").val(0);
            $("#realisasi_adm").val(0);
            $("#realisasi_asuransi").val(0);
            $("#form tbody").html(html);
          }
        }
      });
      // [end] generate transaksi rembug

      $("#infaq_kelompok","#process_trx_rembug").val(number_format($(this).attr('infaq'),0,',','.'));
      $("#kas_awal","#process_trx_rembug").val(number_format($(this).attr('kas_awal'),0,',','.'));

      $("#loading-overlay").css({
        height:$("#form").height(),
        width:$("#form").width(),
        backgroundColor:'rgba(0,0,0,.3)',
        position:'absolute',
        margin:'-25px 0 0 0'
      })    
      $.ajax({
        type: "POST",
        url: site_url+"transaction/get_trx_cm_save_detail",
        data: {
          trx_cm_save_id:trx_cm_save_id,
        },
        dataType: "json",
        success: function(respon){
          var i = 0;
          var data = respon;

          var total_setoran_tab_sukarela2 = 0;
          var total_setoran_minggon2 = 0;
          var total_setoran_tab_berencana2 = 0;
          var total_penarikan_tab_sukarela2 = 0;
          var total_angsuran = 0;

          $("input#cif_no").each(function(){
            var parent = $(this).parent().parent();
            setoran_minggon = parseFloat(data[i].setoran_mingguan)+parseFloat(data[i].setoran_lwk);
            total_setoran_minggon2 += parseFloat(setoran_minggon);

            if(typeof(data[i])!="undefined")
            {
              parent.children('td').find('#absen').val(data[i].absen);
              parent.children('td').find('#vabsen').val(data[i].absen);
              parent.children('td').find('#freq').val(data[i].frekuensi);
              parent.children('td').find('#muqosha').val(data[i].muqosha);
              parent.children('td').find('#setoran_tabungan_sukarela').val(number_format(data[i].setoran_tab_sukarela,0,',','.'));
              parent.children('td').find('#setoran_lwk').val(number_format(data[i].setoran_lwk,0,',','.'));
              parent.children('td').find('#setoran_mingguan').val(number_format(data[i].setoran_mingguan,0,',','.'));
              parent.children('td').find('#setoran_minggon').val(number_format(setoran_minggon,0,',','.'));
              parent.children('td').find('#penarikan_tabungan_sukarela').val(number_format(data[i].penarikan_tab_sukarela,0,',','.'));

              var status_angsuran_margin = data[i].status_angsuran_margin;
              var status_angsuran_catab = data[i].status_angsuran_catab;
              var status_angsuran_tab_wajib = data[i].status_angsuran_tab_wajib;
              var status_angsuran_tab_kelompok = data[i].status_angsuran_tab_kelompok;
              var angsuran_margin = parseFloat(convert_numeric(parent.children('td').find('#angsuran_margin').val()));
              var angsuran_catab = parseFloat(convert_numeric(parent.children('td').find('#angsuran_catab').val()));
              var angsuran_tab_wajib = parseFloat(convert_numeric(parent.children('td').find('#angsuran_tab_wajib').val()));
              var angsuran_tab_kelompok = parseFloat(convert_numeric(parent.children('td').find('#angsuran_tab_kelompok').val()));
              var jumlah_angsuran = parseFloat(convert_numeric(parent.children('td').find('#jumlah_angsuran').val()));
              
              if(status_angsuran_margin==0){
                parent.children('td').find('#angsuran_margin').val(0);
                jumlah_angsuran -= parseFloat(angsuran_margin);
              }
              if(status_angsuran_catab==0){
                parent.children('td').find('#angsuran_catab').val(0);
                jumlah_angsuran -= parseFloat(angsuran_catab);
              }
              if(status_angsuran_tab_wajib==0){
                parent.children('td').find('#angsuran_tab_wajib').val(0);
                jumlah_angsuran -= parseFloat(angsuran_tab_wajib);
              }
              if(status_angsuran_tab_kelompok==0){
                parent.children('td').find('#angsuran_tab_kelompok').val(0);
                jumlah_angsuran -= parseFloat(angsuran_tab_kelompok);
              }

              // parent.children('td').find('#status_angsuran_margin').val(status_angsuran_margin);
              // parent.children('td').find('#status_angsuran_catab').val(status_angsuran_catab);
              // parent.children('td').find('#status_angsuran_tab_wajib').val(status_angsuran_tab_wajib);
              // parent.children('td').find('#status_angsuran_tab_kelompok').val(status_angsuran_tab_kelompok);
              
              parent.children('td').find('#setoran_tabungan_sukarela').val(number_format(data[i].setoran_tab_sukarela,0,',','.'));
              parent.children('td').find('#setoran_lwk').val(data[i].setoran_lwk);
              parent.children('td').find('#setoran_mingguan').val(data[i].setoran_mingguan);

              parent.children('td').find('#jumlah_angsuran').val(number_format(jumlah_angsuran,0,',','.'))

              total_setoran_tab_sukarela2 += parseFloat(data[i].setoran_tab_sukarela);
              total_penarikan_tab_sukarela2 += parseFloat(data[i].penarikan_tab_sukarela);
              var jumlah_angsuran = parseFloat(convert_numeric(parent.children('td').find('#jumlah_angsuran').val()));
              var frekuensi = data[i].frekuensi;
              total_angsuran += parseFloat(frekuensi*jumlah_angsuran);

              $.ajax({
                type: "POST",
                dataType: "json",
                url: site_url+"transaction/get_trx_cm_save_berencana",
                data: {trx_cm_save_detail_id:data[i].trx_cm_save_detail_id},
                async: false,
                success: function(respon2){
                  data2 = respon2;
                  var j = 0;
                  var setoran_berencana2 = 0;
                  $("input#detail_berencana_account_no",parent).each(function(){
                    var parent2 = $(this).parent().parent();
                    if(typeof(data2[j])!="undefined"){
                      parent2.children('td').find('#detail_berencana_account_no').val(data2[j].account_saving_no);
                      parent2.children('td').find('#detail_berencana_setoran').val(number_format(data2[j].amount,0,',','.'));
                      parent2.children('td').find('#detail_berencana_freq').val(data2[j].frekuensi);
                      hitung_setoran_berencana = parseFloat(data2[j].amount)*parseFloat(data2[j].frekuensi);
                      setoran_berencana2 += parseFloat(hitung_setoran_berencana);
                    }
                    j++;
                  });
                  parent.children('td').find('#setoran_tab_berencana').val(number_format(setoran_berencana2,0,',','.'));
                  total_setoran_tab_berencana2 += parseFloat(setoran_berencana2);
                }
              });
            }else{
              setoran_minggon = parseFloat(convert_numeric(parent.children('td').find('#setoran_minggon').val()));
              total_setoran_minggon2 += parseFloat(setoran_minggon);
            }

            i++;
          });

          $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
          $("#total_setoran_tab_sukarela").val(number_format(total_setoran_tab_sukarela2,0,',','.'));
          $("#total_minggon").val(number_format(total_setoran_minggon2,0,',','.'));
          $("#total_setoran_tab_berencana").val(number_format(total_setoran_tab_berencana2,0,',','.'));
          $("#total_penarikan_tab_sukarela").val(number_format(total_penarikan_tab_sukarela2,0,',','.'));

          calc_setoran();
          calc_penarikan();
          calc_saldo_kas();
          $("#loading-overlay").css({
            height:0,
            width:0
          })   
        }
      })




  });
  
  jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown









  
  

  $("button#btnoksetminggon").live('click',function(){
    formid = $(this).attr('formid');
    // setoran_lwk = $("#setoran_lwk","#dialog_minggon_"+formid).val();
    // setoran_mingguan = $("#setoran_mingguan","#dialog_minggon_"+formid).val();
    // total_setoran_minggon = parseFloat(setoran_lwk)+parseFloat(setoran_mingguan);
    // $("#dialog_minggon_"+formid).parent().find("#setoran_minggon").val(total_setoran_minggon);
    
    // grand_total_setoran_minggon = 0;
    // $("input#setoran_minggon").each(function(){
    //   grand_total_setoran_minggon+= parseFloat($(this).val());
    // });
    // $("#total_minggon").val(grand_total_setoran_minggon);
    $("button#close","#dialog_minggon_"+formid).trigger('click');
    
    // calc_setoran();
    // calc_penarikan();
    // calc_saldo_kas();


  });
  

  $("button#btnokfrmtaberencana").live('click',function(){
    formid = $(this).attr('formid');
    total_tabungan_berencana = 0;
    $("input#detail_berencana_freq","#dialog_tabungan_berencana_"+formid).each(function(){
      total_tabungan_berencana += parseFloat($(this).val()) * parseFloat(convert_numeric($(this).parent().find("#detail_berencana_setoran").val()));
    });
    $("#dialog_tabungan_berencana_"+formid).parent().find("#setoran_tab_berencana").val(number_format(total_tabungan_berencana,0,',','.'));
    total_setoran_tabungan_berencana = 0;
    $("input#setoran_tab_berencana").each(function(){
      total_setoran_tabungan_berencana+= parseFloat(convert_numeric($(this).val()));
    });
    $("#total_setoran_tab_berencana").val(number_format(total_setoran_tabungan_berencana,0,',','.'));
    $("button#close","#dialog_tabungan_berencana_"+formid).trigger('click');
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("input#setoran_tab_berencana").live('dblclick',function(){
    $(this).parent().find('a').trigger('click');
  });

  $("input#setoran_minggon").live('dblclick',function(){
    $(this).parent().find('a').trigger('click');
    window.scrollTo(0,0);
  });
  
  function calc_setoran()
  {
    total_angsuran = parseFloat(convert_numeric($("#total_angsuran").val()));
    total_setoran_tab_sukarela = parseFloat(convert_numeric($("#total_setoran_tab_sukarela").val()));
    total_minggon = parseFloat(convert_numeric($("#total_minggon").val()));
    total_realisasi_adm = parseFloat(convert_numeric($("#total_realisasi_adm").val()));
    total_realisasi_asuransi = parseFloat(convert_numeric($("#total_realisasi_asuransi").val()));
    total_setoran_berencana = parseFloat(convert_numeric($("#total_setoran_tab_berencana").val()));
    var setoran = total_angsuran+total_setoran_tab_sukarela+total_minggon+total_realisasi_adm+total_realisasi_asuransi+total_setoran_berencana;
    
    $("#setoran").val(number_format(setoran,0,',','.'));
  }
  
  function calc_penarikan()
  {
    total_penarikan_tab_sukarela = parseFloat(convert_numeric($("#total_penarikan_tab_sukarela").val()));
    total_realisasi_plafon = parseFloat(convert_numeric($("#total_realisasi_plafon").val()));
    var penarikan = total_penarikan_tab_sukarela+total_realisasi_plafon;
    $("#penarikan").val(number_format(penarikan,0,',','.'));
  }

  function calc_saldo_kas()
  {
    kas_awal = parseFloat(convert_numeric($("#kas_awal").val()));
    if(isNaN(kas_awal)==true){
      kas_awal = 0;
    }
    infaq_kelompok = parseFloat(convert_numeric($("#infaq_kelompok").val()));
    if(isNaN(infaq_kelompok)==true){
      infaq_kelompok = 0;
    }
    setoran = parseFloat(convert_numeric($("#setoran").val()));
    if(isNaN(setoran)==true){
      setoran = 0;
    }
    penarikan = parseFloat(convert_numeric($("#penarikan").val()));
    if(isNaN(penarikan)==true){
      penarikan = 0;
    }
    saldo_kas = kas_awal+infaq_kelompok+setoran-penarikan;
    $("#saldo_kas").val(number_format(saldo_kas,0,',','.'));
  }

  /* hitung total setoran tabungan sukarela ************************************************/
  $("input#setoran_tabungan_sukarela","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#setoran_tabungan_sukarela").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_setoran_tab_sukarela").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total setoran minggon ************************************************/
  $("input#setoran_minggon","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#setoran_minggon").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_minggon").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total penarikan tabungan sukarela ************************************************/
  $("input#penarikan_tabungan_sukarela","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#penarikan_tabungan_sukarela").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_penarikan_tab_sukarela").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi plafon ************************************************/
  $("input#realisasi_plafon","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_plafon").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_plafon").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi adm ************************************************/
  $("input#realisasi_adm","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_adm").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_adm").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi asuransi ************************************************/
  $("input#realisasi_asuransi","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_asuransi").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_asuransi").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#infaq_kelompok").keyup(function(){
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#kas_awal").keyup(function(){
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#save_trx").click(function(){
    var conf = confirm("Approve Transaksi, Apakah anda yakin ?");
    if(conf)
    {
      $.ajax({
        type: "POST",
        dataType: "json",
        data: $("#process_trx_rembug").serialize(),
        url: site_url+"transaction/process_trx_rembug",
        success: function(response){
          if(response.success===true){
            alert(response.message);
            // window.location.reload();
            $("#wrapper-table").show();
            $("#edit").hide();
            App.scrollTo(0, -200);
            trx_cm_save_id = $("#trx_cm_save_id").val();
            $("#link-verifikasi[trx_cm_save_id='"+trx_cm_save_id+"']").parent().parent().parent().remove();
            // alert('Successfully Updated Data');
            // $("input#freq").val('0');
            // $("#total_setoran_tab_sukarela").val(0);
            // $("#total_minggon").val(0);
            // $("#total_penarikan_tab_sukarela").val(0);
            // $("#infaq_kelompok").val(0);
            // $("#setoran").val(0);
            // $("#penarikan").val(0);
            // $("#saldo_kas").val(0);
            // $(".search").trigger('click');
          }else{
            alert(response.message);
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator.")
        }
      });
    }
  });

  $("#reject_trx").click(function(){

    var conf = confirm("Reject Transaksi, Apakah anda yakin ?");
    if(conf)
    {
      trx_cm_save_id = $("#trx_cm_save_id").val();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/reject_trx_rembug",
        data: {trx_cm_save_id:trx_cm_save_id},
        success: function(respon){
          if(respon.success==true){
            alert(respon.message);
            $("#wrapper-table").show();
            $("#edit").hide();
            App.scrollTo(0, -200);
            trx_cm_save_id = $("#trx_cm_save_id").val();
            $("#link-verifikasi[trx_cm_save_id='"+trx_cm_save_id+"']").parent().parent().parent().remove();
          }else{
            alert(respon.message);
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      });
    }

  });

  $("#cancel_trx").click(function(){
      $("#wrapper-table").show();
      $("#edit").hide();
      App.scrollTo(0, -200);
  });

  // --------------------------------------------------------------------
  //  KEYCODE (ASCII)
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] ABSEN
      
      /*DOWN*/
      $("select#absen","#form").live('keydown',function(e){
        if(e.keyCode==9){
          $(this).parent().parent().next().find("#absen").focus();
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child select#absen","#form").live('keydown',function(e){
        if(e.keyCode==9){
          $('tr:first-child #freq').focus()
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child select#absen","#form").live('keydown',function(e){
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
      });

      /*UP*/
      $("select#absen","#form").live('keydown',function(e){
        if(e.shiftKey && e.keyCode==9){
          $(this).parent().parent().prev().find("#absen").focus();
          return false;
        }
      });

  //  [END] ABSEN
  // --------------------------------------------------------------------
  // --------------------------------------------------------------------
  //  [BEGIN] FREKUENSI

      /*UP*/
      $("input#freq","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#freq").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#freq","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #absen').focus()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*DOWN*/
      $("input#freq","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#freq").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#freq","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('tr:first-child #setoran_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  //  [END] FREKUENSI
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] SETORAN TABUNGAN SUKARELA

      /*UP*/
      $("input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#setoran_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #freq').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN*/
      $("input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#setoran_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('tr:first-child #penarikan_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  //  [END] SETORAN TABUNGAN SUKARELA
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] minggon

      /*UP*/
      // $("input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==38){
      //     $(this).parent().parent().prev().find("#setoran_minggon").select();
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });
      
      // /*UP+PREVIOUS*/
      // $("tr:first-child input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==38){
      //     $('tr:last-child #setoran_tabungan_sukarela').select()
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

      // DOWN
      // $("input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==40){
      //     $(this).parent().parent().next().find("#setoran_minggon").select();
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

      // /*DOWN+NEXT*/
      // $("tr:last-child input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==40){
      //     $('tr:first-child #penarikan_tabungan_sukarela').select()
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

  //  [END] minggon
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] PENARIKAN TAB SUKARELA

      /*UP*/
      $("input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#penarikan_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #setoran_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN*/
      $("input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#penarikan_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('#kas_awal').select()
          return false;
        }
      });

  //  [END] PENARIKAN TAB SUKARELA
  // --------------------------------------------------------------------
  //  [BEGIN] KAS AWAL

      //PREVIOUS
      $("#kas_awal","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child input#penarikan_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      //NEXT
      $("#kas_awal","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('#infaq_kelompok').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  // [END] KAS AWAL
  // --------------------------------------------------------------------
  // [BEGIN] INFAQ KELOMPOK
      // PREVIOUS
      $("#infaq_kelompok","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('#kas_awal').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
  // [END] INFAQ KELOMPOK









  


});
</script>

<!-- END JAVASCRIPTS