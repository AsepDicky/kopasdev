<style type="text/css">
#form input:focus, #form select:focus {
  border: solid 2px #1A8BCC;
}

</style>
<!-- DIALOG TABUNGAN BERENCANA -->
<div id="dialog_saldo_outstanding" class="modal hide fade"  data-width="500" style="position:fixed;top:10%" >
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>INFO CIF</h3>
      <input type="hidden" id="cif_no">
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
          <table width="100%">
            <tr>
              <td style="font-size:11px;" width="29%">Angsuran Masuk</td>
              <td width="29%"><input style="width:40px;font-size:12px;padding:0 4px;text-align:right;" readonly type="text" id="angsuran_masuk"></td>
              <td width="4%"></td>
              <td style="font-size:11px;" width="18%">Jangka Waktu</td>
              <td style="font-size:11px;" width="26%"><input style="width:40px;font-size:12px;padding:0 4px;text-align:right;" readonly type="text" id="jangka_waktu"> &nbsp; <span id="periode_jangka_waktu"></span></td>
            </tr>
          </table>
         </div>
      </div>
      <div class="row-fluid">
         <div class="span7">
          <table>
            <tr>
              <td style="font-size:11px;width:150px;vertical-align:top;padding-top:3px;">Angsuran Pokok</td>
              <td colspan="2"><input type="hidden" id="nyumput_angsuran_pokok"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_pokok"></td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Margin</td>
              <td><input type="hidden" id="nyumput_angsuran_margin"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_margin"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <input type="checkbox" checked="checked" id="angsuran_margin">
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Catab</td>
              <td><input type="hidden" id="nyumput_angsuran_catab"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_catab"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <input type="checkbox" checked="checked" id="angsuran_catab">
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Tab. Wajib</td>
              <td><input type="hidden" id="nyumput_angsuran_tab_wajib"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_tab_wajib"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <input type="checkbox" checked="checked" id="angsuran_tab_wajib">
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Tab. Kelompok</td>
              <td><input type="hidden" id="nyumput_angsuran_tab_kelompok"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_tab_kelompok"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <input type="checkbox" checked="checked" id="angsuran_tab_kelompok">
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Total Angsuran</td>
              <td colspan="2"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="total_angsuran"></td>
            </tr>
          </table> 
         </div>
         <div class="span5">
          <table>
            <tr>
              <td style="font-size:11px;width:106px;">Outstanding Pokok</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="outstanding_pokok"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Outstanding Margin</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="outstanding_margin"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Total Outstanding</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="total_outstanding"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Saldo Catab</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="saldo_catab"></td>
            </tr>
            <tr style="display:none;">
              <td style="font-size:11px;">Muqosha</td>
              <td><input type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" value="0" class="mask-money" id="muqosha"></td>
            </tr>
            <tr>
              <td colspan="2" style="font-size:11px;">
              <div id="pindah-catab" style="display:none;text-align:center;border:solid 1px #CCC;padding-top:5px;">
                Catab yang akan dipindahkan<br>
                <input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="catab_pindah">
              </div>
              </td>
            </tr>
          </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="btnoksaldooutstanding" data-dismiss="modal" class="btn green">OK</button>
      <button type="button" id="close" data-dismiss="modal" class="btn red">Close</button>
   </div>
</div>
<a href="#dialog_saldo_outstanding" id="open_dialog_saldo_outstanding" style="display:none;" data-toggle="modal">open</a>

<!-- DIALOG TABUNGAN BERENCANA -->
<div id="dialog_saldo_tabungan" class="modal hide fade"  data-width="500" style="position:fixed;top:10%">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>INFO SALDO TABUNGAN</h3>
   </div>
   <div class="modal-body">
      <table>
        <tr>
          <td width="200">Tabungan Sukarela</td>
          <td>
            <input type="text" id="tabungan_sukarela" readonly style="text-align:right">
          </td>
        </tr>
        <tr>
          <td>Tabungan Wajib</td>
          <td>
            <input type="text" id="tabungan_wajib" readonly style="text-align:right">
          </td>
        </tr>
        <tr>
          <td>Tabungan Kelompok</td>
          <td>
            <input type="text" id="tabungan_kelompok" readonly style="text-align:right">
          </td>
        </tr>
      </table>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>
<a href="#dialog_saldo_tabungan" id="open_dialog_saldo_tabungan" style="display:none;" data-toggle="modal">open</a>

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
        Transaksi Rembug <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
  <div class="portlet-body form">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>
    <div class="alert alert-success hide">
       Pemindah Bukuan Sukses !
    </div>

        <!-- DIALOG BRANCH -->
        <div id="dialog_branch" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Kantor Cabang</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>


        <!-- DIALOG CM -->
        <div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Rembug Pusat</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>

        <!-- DIALOG FA -->
        <div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari Field Assistant</h3>
           </div>
           <div class="modal-body">
              <div class="row-fluid">
                 <div class="span12">
                    <h4>Masukan Kata Kunci</h4>
                    <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                    <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                 </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>
      <form id="form_process" class="form-horizontal">
        <table>
          <tr>
            <td width="120">Kantor Cabang <span style="color:red">*</span></td>
            <td>
              <input type="text" tabindex="1" name="branch" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> 
              <?php if($this->session->userdata('flag_all_branch')){ ?>
              <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
              <?php } ?>
              <!-- <a id="browse_branch" class="btn blue" tabindex="1" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
            <td width="100"></td>
            <td width="100">Tanggal <span style="color:red">*</span></td>
            <td style="white-space:nowrap">
              <input type="text" name="tanggal" tabindex="3" placeholder="dd/mm/yyyy" value="<?php echo $current_date; ?>" class="date-picker mask_date" maxlength="10" style="width:100px;padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
            </td>
            <td></td>
          </tr>
          <tr>
            <td width="100">Rembug Pusat <span style="color:red">*</span></td>
            <td>
              <input type="text" tabindex="2" name="cm" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
              <a id="browse_cm" class="btn blue" tabindex="2" style="padding:4px 10px;" data-toggle="modal" href="#dialog_cm">...</a>
            </td>
            <td width="100"></td>
            <td>Kas Petugas <span style="color:red">*</span></td>
            <td width="500">
              <input type="text" tabindex="4" name="fa" value="<?php echo $fa_name_cm; ?>" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
              <a id="browse_fa" class="btn blue" tabindex="4" style="padding:4px 10px;" data-toggle="modal" href="#dialog_fa">...</a>
              <button class="btn green search" tabindex="5" style="margin-left:100px">Tampilkan</button>
            </td>
            <td></td>
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
      </form>

      
      <!-- <hr> -->
      <p>&nbsp;</p>
      <form id="process_trx_rembug" method="post">

        <input type="hidden" name="trx_cm_save_id">
        <input type="hidden" name="fa_name" value="<?php echo $fa_name_cm; ?>">
        <input type="hidden" name="fa_code" value="<?php echo $fa_code_cm; ?>">
        <input type="hidden" name="account_cash_code" value="<?php echo $account_cash_code_cm; ?>">
        <input type="hidden" name="cm_code">
        <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
        <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
        <input type="hidden" name="tanggal2" value="<?php echo $current_date; ?>">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
                <td style="background:#EEE;border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="3" valign="middle" align="center">ID</td>
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
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:2px;margin-bottom:2px;">
                    <option>H</option>
                    <option>I</option>
                    <option>S</option>
                    <option>A</option>
                  </select>
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" style="border-left: solid 1px #CCC"></td>
                <td align="right" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-left:solid 1px #CCC; border-right:solid 1px #CCC;">Total</td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_angsuran" name="total_angsuran" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_setoran_tab_sukarela" name="total_setoran_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_minggon" name="total_minggon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" class="mask-money" id="total_setoran_tab_berencana" name="total_setoran_tab_berencana" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" class="mask-money" id="total_penarikan_tab_sukarela" name="total_penarikan_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_realisasi_plafon" name="total_realisasi_plafon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_realisasi_adm" name="total_realisasi_adm" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" class="mask-money" id="total_realisasi_asuransi" name="total_realisasi_asuransi" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
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
                  <input type="text" id="kas_awal" name="kas_awal" class="mask-money" value="0" style="text-align: right; font-size:12px;width:100px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="infaq_kelompok" class="mask-money" name="infaq_kelompok" value="0" style="text-align: right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="setoran" name="setoran" readonly value="0" style="text-align: right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="penarikan" name="penarikan" readonly value="0" style="text-align: right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="saldo_kas" name="saldo_kas" readonly value="0" style="text-align: right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
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
      <div class="form-actions" align="center" style="padding-left:0; padding-right:0;border-left: solid 1px #CCC; border-right: solid 1px #CCC; border-bottom: solid 1px #CCC; border-top: solid 1px #CCC;">
         <button type="reset" class="btn green" id="print_formulir">Print Formulir</button>
         <button type="submit" style="margin-left:10px;" class="btn blue" id="save_trx">Process</button>
         <button type="reset" style="margin-left:10px;" class="btn red" id="cancel_trx">Cancel</button>
      </div>
  </div>
  <!-- END FORM-->

<!-- END PROSES PINBUK -->


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
     
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
      
   });
</script>

<script type="text/javascript">
$(function(){

  $("input#detail_berencana_freq").livequery('keyup',function(){
    frekuensi = parseFloat($(this).val());
    account_saving_no = $(this).parent().parent().find('#detail_berencana_account_no').val();
    setoran = parseFloat($(this).parent().parent().find('#detail_berencana_setoran').val());
    saldo = parseFloat($(this).parent().parent().find('#detail_berencana_saldo_angs_berencana').val());
    frekuensi_max=saldo/setoran;
    // alert('frekuensi:'+frekuensi);
    // alert('account_saving_no:'+account_saving_no)
    // alert('saldo:'+saldo)
    // alert('setoran:'+setoran)
    // alert('frekuensi_max:'+frekuensi_max)
    if(frekuensi_max==0){
      alert("Setoran untuk Tabungan Berencana "+account_saving_no+" sudah selesai. Silahkan Registrasi Tabungan Berencana Baru");
      $(this).val(frekuensi_max);
    }
    else if(frekuensi>frekuensi_max){
      alert("Frekuensi Setoran Tabungan Berencana Melebihi Jangka Waktu. Silahkan Registrasi Tabungan Berencana Baru");
      $(this).val(frekuensi_max);
    }
  })

  $("input#freq,input#setoran_tabungan_sukarela,input#penarikan_tabungan_sukarela,select#absen","#process_trx_rembug").livequery('focus',function(){
    $(this).closest('tr').css({backgroundColor:'#0E4686',color:'white'});
  });
  $("input#freq,input#setoran_tabungan_sukarela,input#penarikan_tabungan_sukarela,select#absen","#process_trx_rembug").livequery('blur',function(){
    $(this).closest('tr').css({backgroundColor:'white',color:'black'});
  });

  // $("input#setoran_tab_berencana","#process_trx_rembug").livequery('dblclick',function(){
  //   $(this).parent().parent().css({backgroundColor:'#0E4686'});
  //   $(this).parent().parent().children('td:nth-child(1)').css({color:'white'});
  //   $(this).parent().parent().children('td:nth-child(2)').css({color:'white'});
  // });

  // $("button#btnokfrmtaberencana").livequery('click',function(){
  //   $(this).parent().parent().css({backgroundColor:'#FFFFFF'});
  //   $(this).parent().parent().children('td:nth-child(1)').css({color:'black'});
  //   $(this).parent().parent().children('td:nth-child(2)').css({color:'black'});
  // })

  // $(".modal-backdrop").livequery('click',function(e){
  //   e.preventDefault();
  //   return false;
  // })

  // $("input#penarikan_tabungan_sukarela").livequery('keyup',function(){
  //   var balance_tabungan_sukarela = parseFloat($(this).parent().parent().find('#balance_tabungan_sukarela').val());
  //   tarik_sukarela = parseFloat($(this).val());
  //   if(tarik_sukarela>balance_tabungan_sukarela){
  //     alert("Penarikan sukarela melebihxi saldo \r\n Saldo Sukarela = "+number_format(balance_tabungan_sukarela,2,',','.'))
  //   }
  // })

  $("input#penarikan_tabungan_sukarela").livequery('dblclick',function(){
    var balance_tabungan_wajib = $(this).parent().parent().find('#balance_tabungan_wajib').val();
    var balance_tabungan_kelompok = $(this).parent().parent().find('#balance_tabungan_kelompok').val();
    var balance_tabungan_sukarela = $(this).parent().parent().find('#balance_tabungan_sukarela').val();
    console.log(balance_tabungan_sukarela);
    console.log(balance_tabungan_wajib);
    $("#tabungan_kelompok","#dialog_saldo_tabungan").val(number_format(balance_tabungan_kelompok,2,',','.'));
    $("#tabungan_sukarela","#dialog_saldo_tabungan").val(number_format(balance_tabungan_sukarela,2,',','.'));
    $("#tabungan_wajib","#dialog_saldo_tabungan").val(number_format(balance_tabungan_wajib,2,',','.'));
    $("#open_dialog_saldo_tabungan").trigger('click');
    // window.scrollTo(0,0)
  })

  $("input#jumlah_angsuran").livequery('dblclick',function(e){
    
    var cif_no = $(this).parent().parent().attr('cifno');
    var angsuran_pokok = $(this).parent().parent().find('#angsuran_pokok').val();
    var angsuran_margin = $(this).parent().parent().find('#angsuran_margin').val();
    var angsuran_catab = $(this).parent().parent().find('#angsuran_catab').val();
    var angsuran_tab_wajib = $(this).parent().parent().find('#angsuran_tab_wajib').val();
    var angsuran_tab_kelompok = $(this).parent().parent().find('#angsuran_tab_kelompok').val();
    var freq = $(this).parent().parent().find('#freq').val();
    var hide_angsuran_margin = $(this).parent().parent().find('#hide_angsuran_margin').val();
    var hide_angsuran_catab = $(this).parent().parent().find('#hide_angsuran_catab').val();
    var hide_angsuran_tab_wajib = $(this).parent().parent().find('#hide_angsuran_tab_wajib').val();
    var hide_angsuran_tab_kelompok = $(this).parent().parent().find('#hide_angsuran_tab_kelompok').val();
    var muqosha = parseFloat($(this).parent().parent().find('#muqosha').val());
    var total_angsuran = $(this).val();

    var pembiayaan_saldo_pokok = $(this).parent().parent().find('#pembiayaan_saldo_pokok').val();
    var pembiayaan_saldo_margin = $(this).parent().parent().find('#pembiayaan_saldo_margin').val();
    var pembiayaan_saldo_catab = $(this).parent().parent().find('#pembiayaan_saldo_catab').val();
    var pembiayaan_jangka_waktu = $(this).parent().parent().find('#pembiayaan_jangka_waktu').val();
    var pembiayaan_periode_jangka_waktu = $(this).parent().parent().find('#pembiayaan_periode_jangka_waktu').val();
    var pembiayaan_counter_angsuran = $(this).parent().parent().find('#pembiayaan_counter_angsuran').val();

    sisa_angsuran = parseFloat(pembiayaan_jangka_waktu)-parseFloat(pembiayaan_counter_angsuran);
    if(sisa_angsuran==freq && sisa_angsuran!=0){
      $("#muqosha","#dialog_saldo_outstanding").parent().parent().show();
    }else{
      $("#muqosha","#dialog_saldo_outstanding").parent().parent().hide();
    }

    var catab_pindah = parseFloat(pembiayaan_saldo_catab)+(parseFloat(angsuran_catab)*parseFloat(freq));

    switch(pembiayaan_periode_jangka_waktu){
      case "0":
      periode_jangka_waktu = "Hari";
      break;
      case "1":
      periode_jangka_waktu = "Minggu";
      break;
      case "2":
      periode_jangka_waktu = "Bulan";
      break;
      case "3":
      periode_jangka_waktu = "Jatuh Tempo";
      break;
    }

    var total_outstanding = parseFloat(pembiayaan_saldo_pokok)+parseFloat(pembiayaan_saldo_margin);

    $("#cif_no","#dialog_saldo_outstanding").val(cif_no);
    $("#angsuran_masuk","#dialog_saldo_outstanding").val(pembiayaan_counter_angsuran);
    $("#jangka_waktu","#dialog_saldo_outstanding").val(pembiayaan_jangka_waktu);
    $("#periode_jangka_waktu","#dialog_saldo_outstanding").text(periode_jangka_waktu);
    $("#angsuran_pokok","#dialog_saldo_outstanding").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin","#dialog_saldo_outstanding").val(number_format(angsuran_margin,0,',','.'));
    $("#nyumput_angsuran_margin","#dialog_saldo_outstanding").val(hide_angsuran_margin);
    $("#angsuran_catab","#dialog_saldo_outstanding").val(number_format(angsuran_catab,0,',','.'));
    $("#nyumput_angsuran_catab","#dialog_saldo_outstanding").val(hide_angsuran_catab);
    $("#angsuran_tab_wajib","#dialog_saldo_outstanding").val(number_format(angsuran_tab_wajib,0,',','.'));
    $("#nyumput_angsuran_tab_wajib","#dialog_saldo_outstanding").val(hide_angsuran_tab_wajib);
    $("#angsuran_tab_kelompok","#dialog_saldo_outstanding").val(number_format(angsuran_tab_kelompok,0,',','.'));
    $("#nyumput_angsuran_tab_kelompok","#dialog_saldo_outstanding").val(hide_angsuran_tab_kelompok);
    $("#total_angsuran","#dialog_saldo_outstanding").val(total_angsuran);
    $("#outstanding_pokok","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_pokok,0,',','.'));
    $("#outstanding_margin","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_margin,0,',','.'));
    $("#total_outstanding","#dialog_saldo_outstanding").val(number_format(total_outstanding,0,',','.'));
    $("#saldo_catab","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_catab,0,',','.'));
    $("#muqosha","#dialog_saldo_outstanding").val(number_format(muqosha,0,',','.'));
    if(parseFloat(pembiayaan_counter_angsuran)+parseFloat(freq)==parseFloat(pembiayaan_jangka_waktu) && parseFloat(pembiayaan_jangka_waktu)!=0){
      $("#pindah-catab","#dialog_saldo_outstanding").show();
      $("#catab_pindah","#dialog_saldo_outstanding").val(number_format(catab_pindah,0,',','.'));
    }else{
      $("#pindah-catab","#dialog_saldo_outstanding").hide();
    }

    $("#open_dialog_saldo_outstanding").trigger('click');
    // window.scrollTo(0,0)

    status_angsuran_margin = $(this).parent().parent().find('#status_angsuran_margin').val();
    status_angsuran_catab = $(this).parent().parent().find('#status_angsuran_catab').val();
    status_angsuran_tab_wajib = $(this).parent().parent().find('#status_angsuran_tab_wajib').val();
    status_angsuran_tab_kelompok = $(this).parent().parent().find('#status_angsuran_tab_kelompok').val();
    $("#cif_no","#dialog_saldo_outstanding").val(cif_no);
    // alert(status_angsuran_margin);
    console.log(status_angsuran_margin);
    console.log($("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span'));
    if(status_angsuran_margin=="1"){
      $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span').attr('class','checked');
      $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    }else{
      $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span').attr('class','');
      $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('input').attr('checked',false);
    }

    if(status_angsuran_catab=="1"){
      $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('span').attr('class','checked');
      $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    }else{
      $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('span').attr('class','');
      $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('input').attr('checked',false);
    }

    if(status_angsuran_tab_wajib=="1"){
      $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('span').attr('class','checked');
      $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    }else{
      $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('span').attr('class','');
      $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('input').attr('checked',false);
    }

    if(status_angsuran_tab_kelompok=="1"){
      $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('span').attr('class','checked');
      $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    }else{
      $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('span').attr('class','');
      $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('input').attr('checked',false);
    }

  });

  $("#btnoksaldooutstanding","#dialog_saldo_outstanding").click(function(e){
    e.preventDefault();
    cif_no = $("#cif_no","#dialog_saldo_outstanding").val();
    jumlah_angsuran = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#hide_jumlah_angsuran').val()
    angsuran_margin = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#hide_angsuran_margin').val()
    angsuran_catab = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#hide_angsuran_catab').val()
    angsuran_tab_wajib = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#hide_angsuran_tab_wajib').val()
    angsuran_tab_kelompok = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#hide_angsuran_tab_kelompok').val()

    new_jumlah_angsuran = jumlah_angsuran;
    if($("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('input').is(':checked')==true){
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_margin').val('1')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_margin').val(angsuran_margin)
    }else{
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_margin').val('0')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_margin').val(0)
      new_jumlah_angsuran -= parseFloat(angsuran_margin);
    }
    if($("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('input').is(':checked')==true){
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_catab').val('1')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_catab').val(angsuran_catab)
    }else{
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_catab').val('0')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_catab').val(0)
      new_jumlah_angsuran -= parseFloat(angsuran_catab);
    }
    if($("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('input').is(':checked')==true){
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_tab_wajib').val('1')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_tab_wajib').val(angsuran_tab_wajib)
    }else{
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_tab_wajib').val('0')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_tab_wajib').val(0)
      new_jumlah_angsuran -= parseFloat(angsuran_tab_wajib);
    }
    if($("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('input').is(':checked')==true){
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_tab_kelompok').val('1')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_tab_kelompok').val(angsuran_tab_kelompok)
    }else{
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#status_angsuran_tab_kelompok').val('0')
      $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#angsuran_tab_kelompok').val(0)
      new_jumlah_angsuran -= parseFloat(angsuran_tab_kelompok);
    }
    $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#jumlah_angsuran').val(number_format(new_jumlah_angsuran,0,',','.'));
    $("#freq").trigger('keyup')
  })

  $("#uniform-angsuran_margin,#uniform-angsuran_catab,#uniform-angsuran_tab_wajib,#uniform-angsuran_tab_kelompok").click(function(){
    id = $(this).attr('id');
    id = id.split('-');
    id = id[1];
    if($(this).find('input').is(':checked')==true){
      $("#"+id).val(number_format($("#nyumput_"+id).val(),0,',','.'))
    }else{
      $("#"+id).val(0); 
    }

    cif_no = $("#cif_no","#dialog_saldo_outstanding").val();
    angsuran_catab = convert_numeric($("#angsuran_catab","#dialog_saldo_outstanding").val());
    saldo_catab = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#pembiayaan_saldo_catab').val()
    freq = $("tr[cifno='"+cif_no+"']","#process_trx_rembug").find('#freq').val()
    catab_pindah = parseFloat(saldo_catab)+(parseFloat(freq)*parseFloat(angsuran_catab));
    console.log(angsuran_catab);
    console.log(freq);
    console.log(saldo_catab);
    console.log(catab_pindah);
    $("#catab_pindah").val(number_format(catab_pindah,0,',','.'));

    calc_saldo_total_angsuran();
  })

  var calc_saldo_total_angsuran = function(){
    var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok","#dialog_saldo_outstanding").val()));
    var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin","#dialog_saldo_outstanding").val()));
    var angsuran_catab = parseFloat(convert_numeric($("#angsuran_catab","#dialog_saldo_outstanding").val()));
    var angsuran_tab_wajib = parseFloat(convert_numeric($("#angsuran_tab_wajib","#dialog_saldo_outstanding").val()));
    var angsuran_tab_kelompok = parseFloat(convert_numeric($("#angsuran_tab_kelompok","#dialog_saldo_outstanding").val()));
    var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_catab+angsuran_tab_wajib+angsuran_tab_kelompok;
    $("#total_angsuran","#dialog_saldo_outstanding").val(number_format(total_angsuran,0,',','.'))
  }

  $("input[name='tanggal']").change(function(){
    $("input[name='tanggal2']").val($(this).val());
  });

  $("input[name='tanggal']").blur(function(){
    $("input[name='tanggal2']").val($(this).val());
  });

  $("#browse_branch").click(function(){
    if($("#keyword","#dialog_branch").val()==""){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:''},
         async: false,
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  })

  $("#keyword","#dialog_branch").keyup(function(e){
    e.preventDefault();
    keyword = $(this).val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  });

  $("#select","#dialog_branch").click(function(){
    branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    result_code = $("#result","#dialog_branch").val();
    if(result!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("input[name='branch_id']").val(branch_id);
      $("#close","#dialog_branch").trigger('click');
    }
  });

  $("#result option","#dialog_branch").livequery('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
    window.scrollTo(0,0)
  });

  $("#browse_cm").click(function(){
    cm = $("input[name='cm']","#form_process").val();
    $("#keyword","#dialog_cm").val(cm)
    // if($("#keyword","#dialog_cm").val()==""){
      branch_id = $("input[name='branch_id']").val();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:$("#keyword","#dialog_cm").val(),branch_id:branch_id},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_cm").html(html);
         }
      })
    // }
  })

  $("#keyword","#dialog_cm").keyup(function(e){
    e.preventDefault();
    keyword = $(this).val();
    branch_id = $("input[name='branch_id']").val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_id:branch_id},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_cm").html(html);
         }
      })
    }
  });

  $("#select","#dialog_cm").click(function(){
    result_name = $("#result option:selected","#dialog_cm").attr('cm_name');
    result_code = $("#result","#dialog_cm").val();
    if(result!=null)
    {
      $("input[name='cm']").val(result_name);
      $("input[name='cm_code']").val(result_code);
      $("#close","#dialog_cm").trigger('click');
    }
  });

  $("#result option","#dialog_cm").livequery('dblclick',function(){
    $("#select","#dialog_cm").trigger('click');
    window.scrollTo(0,0)
  });

  $("#browse_fa").click(function(){

    fa = $("input[name='fa']","#form_process").val();
    $("#keyword","#dialog_fa").val(fa)

    // if($("#keyword","#dialog_fa").val()==""){
      branch_code = $("input[name='branch_code']").val();
      $.ajax({
         type: "POST",
         url: site_url+"transaction/ajax_get_gl_account_cash_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:$("#keyword","#dialog_fa").val(),branch_code:branch_code},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].fa_code+'" account_cash_code="'+response[i].account_cash_code+'" fa_name="'+response[i].fa_name+'">'+response[i].account_cash_code+' | '+response[i].account_cash_name+'</option>';
            }
            $("#result","#dialog_fa").html(html);
         }
      })
    // }
  })

  $("#keyword","#dialog_fa").keyup(function(e){
    e.preventDefault();
    keyword = $(this).val();
    branch_code = $("input[name='branch_code']").val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"transaction/ajax_get_gl_account_cash_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_code:branch_code},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].fa_code+'" account_cash_code="'+response[i].account_cash_code+'" fa_name="'+response[i].fa_name+'">'+response[i].account_cash_code+' | '+response[i].account_cash_name+'</option>';
            }
            $("#result","#dialog_fa").html(html);
         }
      })
    }
  });

  $("#select","#dialog_fa").click(function(){
    result_name = $("#result option:selected","#dialog_fa").attr('fa_name');
    account_cash_code = $("#result option:selected","#dialog_fa").attr('account_cash_code');
    result_code = $("#result","#dialog_fa").val();
    if(result!=null)
    {
      $("input[name='fa']").val(result_name);
      $("input[name='fa_name']").val(result_name);
      $("input[name='fa_code']").val(result_code);
      $("input[name='account_cash_code']").val(account_cash_code);
      $("#close","#dialog_fa").trigger('click');
    }
  });

  $("#result option","#dialog_fa").livequery('dblclick',function(){
    $("#select","#dialog_fa").trigger('click');
    window.scrollTo(0,0)
  });

  var form1 = $('#form_process');
  var error1 = $('.alert-error');
  var success1 = $('.alert-success');

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    change: true,
    errorPlacement: function(error, element) {
      error.appendTo( element.parent(".controls") );
    },
    rules: {
         branch: 'required'
        ,tanggal: 'required cek_trx_kontrol_periode'
        ,cm: 'required'
        ,fa: 'required'
    },

    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },

    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.help-inline').removeClass('ok'); // display OK icon
        $(element)
            .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },

    unhighlight: function (element) { // revert the change dony by hightlight
        $(element)
            .closest('.control-group').removeClass('error'); // set error class to the control group
    },

    success: function (label) {
      if(label.closest('.input-append').length==0)
      {
        label
            .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
        .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
      }
      else
      {
         label.closest('.control-group').removeClass('error').addClass('success')
         label.remove();
      }
    },

    submitHandler: false
  
  });
  
  $(".search").click(function(e){
    e.preventDefault();
    var cm_code = $("#cm_code").val();

    if($("input[name='cm_code']").val()=="")
    {
      alert("Rembug Pusat belum di pilih")
    }

    if(form1.valid()===true && $("input[name='cm_code']").val()!="")
    {
      error1.hide();
      $.ajax({
        url: site_url+"transaction/get_trx_rembug_data",
        type: "POST",
        dataType: "json",
        data: { cm_code : $("input[name='cm_code']").val(), account_cash_code : $("input[name='account_cash_code']").val(), tanggal : $("input[name='tanggal']").val() },
        async: false,
        success: function(respon){
          html = '';
          total_angsuran = 0;
          response = respon['data'];
          mutasi = respon['mutasi'];
          total_realisasi_plafon = 0;
          total_realisasi_adm = 0;
          total_realisasi_asuransi = 0;
          total_setoran_tab_berencana = 0;
          total_setoran_minggon = 0;
          total_setoran_tabungan_sukarela = 0;
          if(response.length>0)
          {
            total_rencana_setoran = 0;
            for ( i = 0 ; i < response.length ; i++ )
            {
              rencana_setoran = 0;
              total_setoran_tabungan_sukarela += parseFloat((response[i].status==3)?mutasi[i].setoran_tambahan:0)
              tabungan_berencana = '';
              for ( h = 0 ; h < respon['tab_berencana'][i].length ; h++ )
              {
                setoran = respon['tab_berencana'][i][h].rencana_setoran;
                saldo_memo = respon['tab_berencana'][i][h].saldo_memo;
                saldo_angs_berencana = (respon['tab_berencana'][i][h].rencana_jangka_waktu*respon['tab_berencana'][i][h].rencana_setoran)-saldo_memo;
                frekuensi_max = saldo_angs_berencana/setoran;
                bgcolor = '';
                if(frekuensi_max==0){
                  bgcolor = 'background:#EEE';
                }
                frequensi = (frekuensi_max==0 || respon['tab_berencana'][i][h].product_code=="0006")?0:1;
                setoran_berencana = frequensi*parseFloat(respon['tab_berencana'][i][h].rencana_setoran);
                total_rencana_setoran += parseFloat(setoran_berencana);
                total_setoran_tab_berencana += parseFloat(setoran_berencana);
                // console.log('product_code:'+respon['tab_berencana'][i][h].product_code)
                // console.log('frequensi:'+frequensi)
                // console.log('setoran_berencana:'+setoran_berencana)
                rencana_setoran += parseFloat(setoran_berencana);
                tabungan_berencana += ' \
                  <tr> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;"><input type="hidden" name="detail_berencana_account_no['+i+'][]" value="'+respon['tab_berencana'][i][h].account_saving_no+'" id="detail_berencana_account_no">'+respon['tab_berencana'][i][h].account_saving_no+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;">'+respon['tab_berencana'][i][h].product_name+'<input type="hidden" id="detail_berencana_product_code" name="detail_berencana_product_code['+i+'][]" value="'+respon['tab_berencana'][i][h].product_code+'"></td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center">'+number_format(respon['tab_berencana'][i][h].rencana_setoran,0,',','.')+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;" align="center">'+respon['tab_berencana'][i][h].rencana_jangka_waktu+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;" align="center">'+respon['tab_berencana'][i][h].counter_angsruan+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;" align="center">'+number_format(respon['tab_berencana'][i][h].saldo_memo,0,',','.')+'<input type="hidden" name="detail_berencana_saldo_angs_berencana['+i+'][]" id="detail_berencana_saldo_angs_berencana" value="'+saldo_angs_berencana+'"></td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center"><input type="text" name="detail_berencana_freq['+i+'][]" id="detail_berencana_freq" maxlength="2" value="'+frequensi+'" style="text-align:center;width:20px;margin:0;'+bgcolor+'" class="m-wrap"><input type="hidden" id="detail_berencana_setoran" name="detail_berencana_setoran['+i+'][]" value="'+respon['tab_berencana'][i][h].rencana_setoran+'"></td> \
                  </tr> \
                ';
              }
              // total_angsuran += 0;
              // console.log('total_rencana_setoran:'+total_rencana_setoran)
              total_angsuran += parseFloat(response[i].jumlah_angsuran);
              total_realisasi_plafon += parseFloat(response[i].pokok);
              total_realisasi_adm += parseFloat(response[i].adm);
              total_realisasi_asuransi += parseFloat(response[i].asuransi);
              // total_setoran_tab_berencana += parseFloat(total_rencana_setoran);
              minggon = parseFloat(response[i]['setoran_mingguan'])+parseFloat(response[i]['setoran_lwk']);
              total_setoran_minggon+=parseFloat(minggon);
              html += ' \
              <tr cifno="'+response[i].cif_no+'" '+((response[i].status==3)?'bgcolor="#55ACEE"':'')+'> \
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">'+response[i].cif_no+'<input type="hidden" name="cif_no[]" id="cif_no" value="'+response[i].cif_no+'"></td> \
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">'+response[i].nama+'</td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  ';
              if(response[i].status==3){
              html += ' \
                  <select name="absen[]" id="absen" style="display:none;width:50px;margin-top:2px;margin-bottom:2px;"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                  <select disabled="disabled" style="width:50px;margin-top:2px;margin-bottom:2px;"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                  ';
              }
              else
              {
              html += ' \
                  <select name="absen[]" id="absen" style="width:50px;margin-top:2px;margin-bottom:2px;"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                  ';
              }
              html += ' \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="status_angsuran_margin[]" id="status_angsuran_margin" value="1"> \
                  <input type="hidden" name="status_angsuran_catab[]" id="status_angsuran_catab" value="1"> \
                  <input type="hidden" name="status_angsuran_tab_wajib[]" id="status_angsuran_tab_wajib" value="1"> \
                  <input type="hidden" name="status_angsuran_tab_kelompok[]" id="status_angsuran_tab_kelompok" value="1"> \
                  <input type="hidden" name="angsuran_pokok[]" id="angsuran_pokok" value="'+response[i].angsuran_pokok+'"> \
                  <input type="hidden" name="angsuran_margin[]" id="angsuran_margin" value="'+response[i].angsuran_margin+'"> \
                  <input type="hidden" name="hide_angsuran_margin[]" id="hide_angsuran_margin" value="'+response[i].angsuran_margin+'"> \
                  <input type="hidden" name="angsuran_catab[]" id="angsuran_catab" value="'+response[i].angsuran_catab+'"> \
                  <input type="hidden" name="hide_angsuran_catab[]" id="hide_angsuran_catab" value="'+response[i].angsuran_catab+'"> \
                  <input type="hidden" name="angsuran_tab_wajib[]" id="angsuran_tab_wajib" value="'+response[i].angsuran_tab_wajib+'"> \
                  <input type="hidden" name="hide_angsuran_tab_wajib[]" id="hide_angsuran_tab_wajib" value="'+response[i].angsuran_tab_wajib+'"> \
                  <input type="hidden" name="angsuran_tab_kelompok[]" id="angsuran_tab_kelompok" value="'+response[i].angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="hide_angsuran_tab_kelompok[]" id="hide_angsuran_tab_kelompok" value="'+response[i].angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="balance_angsuran[]" id="balance_angsuran" value="'+response[i].angsuran+'"> \
                  <input type="hidden" name="balance_tabungan_wajib[]" id="balance_tabungan_wajib" value="'+response[i].tabungan_wajib+'"> \
                  <input type="hidden" name="balance_tabungan_sukarela[]" id="balance_tabungan_sukarela" value="'+response[i].tabungan_sukarela+'"> \
                  <input type="hidden" name="balance_transaksi_lain[]" id="balance_transaksi_lain" value="'+response[i].transaksi_lain+'"> \
                  <input type="hidden" name="balance_pokok_pembiayaan[]" id="balance_pokok_pembiayaan" value="'+response[i].pokok_pembiayaan+'"> \
                  <input type="hidden" name="balance_margin_pembiayaan[]" id="balance_margin_pembiayaan" value="'+response[i].margin_pembiayaan+'"> \
                  <input type="hidden" name="balance_catab_pembiayaan[]" id="balance_catab_pembiayaan" value="'+response[i].catab_pembiayaan+'"> \
                  <input type="hidden" name="balance_tabungan_kelompok[]" id="balance_tabungan_kelompok" value="'+response[i].tabungan_kelompok+'"> \
                  <input type="hidden" name="pembiayaan_saldo_pokok[]" id="pembiayaan_saldo_pokok" value="'+response[i].saldo_pokok+'"> \
                  <input type="hidden" name="pembiayaan_saldo_margin[]" id="pembiayaan_saldo_margin" value="'+response[i].saldo_margin+'"> \
                  <input type="hidden" name="pembiayaan_saldo_catab[]" id="pembiayaan_saldo_catab" value="'+response[i].saldo_catab+'"> \
                  <input type="hidden" name="pembiayaan_jangka_waktu[]" id="pembiayaan_jangka_waktu" value="'+response[i].jangka_waktu+'"> \
                  <input type="hidden" name="pembiayaan_periode_jangka_waktu[]" id="pembiayaan_periode_jangka_waktu" value="'+response[i].periode_jangka_waktu+'"> \
                  <input type="hidden" name="pembiayaan_counter_angsuran[]" id="pembiayaan_counter_angsuran" value="'+response[i].counter_angsuran+'"> \
                  <input type="hidden" name="muqosha[]" id="muqosha" value="0"> \
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="freq[]" id="freq" maxlength="2" value="'+((response[i].jumlah_angsuran>0)?1:0)+'" style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" disabled="disabled" value="'+((response[i].jumlah_angsuran>0)?1:0)+'" style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="hide_jumlah_angsuran[]" id="hide_jumlah_angsuran" value="'+response[i].jumlah_angsuran+'"> \
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="jumlah_angsuran[]" class="mask-money" readonly id="jumlah_angsuran" value="'+response[i].jumlah_angsuran+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" class="mask-money" disabled="disabled" value="'+response[i].jumlah_angsuran+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="setoran_tabungan_sukarela[]" class="mask-money" id="setoran_tabungan_sukarela" value="'+((response[i].status==3)?mutasi[i].setoran_tambahan:0)+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" class="mask-money" disabled="disabled" value="'+((response[i].status==3)?mutasi[i].setoran_tambahan:0)+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="setoran_minggon[]" readonly class="mask-money" id="setoran_minggon" value="'+minggon+'" style="background:#EEE;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" class="mask-money" disabled="disabled" value="'+minggon+'" style="background:#EEE;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                    <!-- DIALOG MINGGON --> \
                    <div id="dialog_minggon_'+i+'" class="modal hide fade" data-width="500" style="top:10%;position:fixed"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h4 style="color:#000;">Setoran Minggon <span id="minggon_cif">"'+response[i]['cif_no']+'"</span></h4> \
                       </div> \
                       <div class="modal-body" style="overflow:auto;max-height:400px;"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="500"> \
                                  <tr> \
                                    <td width="150" style="color:#000">Setoran LWK</td> \
                                    <td width="10" style="color:#000">:</td> \
                                    <td style="color:#000"><input type="text" maxlength="10" name="setoran_lwk[]" id="setoran_lwk" value="'+response[i]['setoran_lwk']+'"></td> \
                                  </tr> \
                                  <tr> \
                                    <td style="color:#000">Setoran Mingguan</td> \
                                    <td style="color:#000">:</td> \
                                    <td style="color:#000"><input type="text" maxlength="10" name="setoran_mingguan[]" id="setoran_mingguan" value="'+response[i]['setoran_mingguan']+'"></td> \
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
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="setoran_tab_berencana[]" class="mask-money" readonly id="setoran_tab_berencana" value="'+rencana_setoran+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" class="mask-money" disabled="disabled" value="'+rencana_setoran+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
 \
                               \
                    <!-- DIALOG TABUNGAN BERENCANA --> \
                    <div id="dialog_tabungan_berencana_'+i+'" style="position:fixed;top:10%;width:800px;margin-left:-380px" class="modal hide fade"  data-width="800"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h3 style="color:#000;">Form Detil Setoran Tabungan Berencana</h3> \
                       </div> \
                       <div class="modal-body" style="overflow:auto;max-height:400px;"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="100%"> \
                                  <thead> \
                                    <tr> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Account</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Produk</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Setoran</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Jangka Waktu</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Dibayar</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Saldo</th> \
                                      <th style="color:#000;padding:3px;border:solid 1px #CCC;">Frekuensi</th> \
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
                  <input type="'+((response[i].status==3)?'hidden':'text')+'" name="penarikan_tabungan_sukarela[]" class="mask-money" id="penarikan_tabungan_sukarela" value="'+((response[i].status==3)?mutasi[i].penarikan_tabungan_sukarela:'0')+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="'+((response[i].status==3)?'text':'hidden')+'" class="mask-money" disabled="disabled" value="'+((response[i].status==3)?mutasi[i].penarikan_tabungan_sukarela:'0')+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_plafon[]" id="realisasi_plafon" class="mask-money" readonly value="'+response[i].pokok+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="hidden" name="realisasi_margin[]" id="realisasi_margin" class="mask-money" readonly value="'+response[i].margin+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_adm[]" id="realisasi_adm" class="mask-money" readonly value="'+response[i].adm+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="droping[]" id="droping" value="'+response[i].droping+'"> \
                  <input type="text" name="realisasi_asuransi[]" readonly class="mask-money" id="realisasi_asuransi" value="'+response[i].asuransi+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
              </tr> \
              ';
            }
            // alert(total_angsuran);
            // $("#kas_awal").val(respon['kas_awal']);
            $("#total_angsuran","#process_trx_rembug").val(number_format(total_angsuran,0,',','.'));
            $("#total_realisasi_plafon").val(number_format(total_realisasi_plafon,0,',','.'));
            $("#total_realisasi_adm").val(number_format(total_realisasi_adm,0,',','.'));
            $("#total_realisasi_asuransi").val(number_format(total_realisasi_asuransi,0,',','.'));
            $("#total_setoran_tab_sukarela").val(number_format(total_setoran_tabungan_sukarela,0,',','.'))
            console.log(total_setoran_tab_berencana)
            $("#total_setoran_tab_berencana").val(number_format(total_setoran_tab_berencana,0,',','.'));
            $("#total_minggon").val(number_format(total_setoran_minggon,0,',','.'));
            $("#form tbody").html(html);
            $("input#penarikan_tabungan_sukarela","#process_trx_rembug").trigger('keyup')
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
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:2px;margin-bottom:2px;"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
              </tr> \
            ';
            $("#total_angsuran","#process_trx_rembug").val(0);
            // $("#kas_awal").val(respon['kas_awal']);
            $("#realisasi_plafon").val(0);
            $("#realisasi_adm").val(0);
            $("#realisasi_asuransi").val(0);
            $("#form tbody").html(html);
          }
        }
      });
      $("#freq").trigger('blur');
    }

    $("input#freq").blur(function(){
      calc_total_angsuran();
    })

    $("input#freq").keyup(function(){
      if(parseFloat($(this).val())>=0){
        calc_total_angsuran();
      }else{
        $(this).val('');
      }
    });

    function calc_total_angsuran()
    {
      total_angsuran = 0;
      $("input#freq").each(function(){
        angsuran = parseFloat(convert_numeric($(this).parent().parent().find('#jumlah_angsuran').val()));
        freq = parseFloat($(this).val());
        if($(this).val()==""){
          freq = 0;
          $(this).val(0);
        }
        perangsuran = freq*angsuran;
        total_angsuran += parseFloat(perangsuran);
      });
      $("input#total_angsuran","#process_trx_rembug").val(number_format(total_angsuran,0,',','.'));
      calc_setoran();
      calc_penarikan();
      calc_saldo_kas();
    }

    $.ajax({
      type: "POST",
      dataType: "json",
      url: site_url+"transaction/get_trx_cm_save_by_param",
      async: false,
      data:{
        branch_id : $("input[name='branch_id']").val()
        ,cm_code : $("input[name='cm_code']").val()
        ,trx_date : $("input[name='tanggal2']").val()
        ,account_cash_code : $("input[name='account_cash_code']").val()
      },
      success: function(responsave){
        // console.log(responsave.length);
        if(responsave.length==1)
        {

          data3 = responsave[0];
          $("input[name='trx_cm_save_id']").val(data3.trx_cm_save_id);
          $("#infaq_kelompok","#process_trx_rembug").val(data3.infaq);
          $("#kas_awal","#process_trx_rembug").val(data3.kas_awal);

          $.ajax({
            type: "POST",
            url: site_url+"transaction/get_trx_cm_save_detail",
            data: {
              trx_cm_save_id:data3.trx_cm_save_id,
            },
            async: false,
            dataType: "json",
            success: function(respon){
              var i = 0;
              var data = respon;

              var total_setoran_tab_sukarela2 = 0;
              var total_setoran_minggon2 = 0;
              var total_setoran_tab_berencana2 = 0;
              var total_penarikan_tab_sukarela2 = 0;

              $("input#cif_no","#process_trx_rembug").each(function(){
                var parent = $(this).parent().parent();
                parent.children('td').find('#absen').val(data[i].absen);
                // console.log(data[i].frekuensi);
                parent.children('td').find('#freq').val(data[i].frekuensi);
                var status_angsuran_margin = data[i].status_angsuran_margin;
                var status_angsuran_catab = data[i].status_angsuran_catab;
                var status_angsuran_tab_wajib = data[i].status_angsuran_tab_wajib;
                var status_angsuran_tab_kelompok = data[i].status_angsuran_tab_kelompok;
                var hide_angsuran_margin = parseFloat(parent.children('td').find('#hide_angsuran_margin').val());
                var hide_angsuran_catab = parseFloat(parent.children('td').find('#hide_angsuran_catab').val());
                var hide_angsuran_tab_wajib = parseFloat(parent.children('td').find('#hide_angsuran_tab_wajib').val());
                var hide_angsuran_tab_kelompok = parseFloat(parent.children('td').find('#hide_angsuran_tab_kelompok').val());
                var hide_jumlah_angsuran = parent.children('td').find('#hide_jumlah_angsuran').val();
                
                if(status_angsuran_margin==0){
                  parent.children('td').find('#angsuran_margin').val(0);
                  hide_jumlah_angsuran -= parseFloat(hide_angsuran_margin);
                }
                if(status_angsuran_catab==0){
                  parent.children('td').find('#angsuran_catab').val(0);
                  hide_jumlah_angsuran -= parseFloat(hide_angsuran_catab);
                }
                if(status_angsuran_tab_wajib==0){
                  parent.children('td').find('#angsuran_tab_wajib').val(0);
                  hide_jumlah_angsuran -= parseFloat(hide_angsuran_tab_wajib);
                }
                if(status_angsuran_tab_kelompok==0){
                  parent.children('td').find('#angsuran_tab_kelompok').val(0);
                  hide_jumlah_angsuran -= parseFloat(hide_angsuran_tab_kelompok);
                }

                parent.children('td').find('#status_angsuran_margin').val(status_angsuran_margin);
                parent.children('td').find('#status_angsuran_catab').val(status_angsuran_catab);
                parent.children('td').find('#status_angsuran_tab_wajib').val(status_angsuran_tab_wajib);
                parent.children('td').find('#status_angsuran_tab_kelompok').val(status_angsuran_tab_kelompok);
                
                parent.children('td').find('#setoran_tabungan_sukarela').val(data[i].setoran_tab_sukarela);
                parent.children('td').find('#setoran_lwk').val(data[i].setoran_lwk);
                parent.children('td').find('#setoran_mingguan').val(data[i].setoran_mingguan);

                parent.children('td').find('#jumlah_angsuran').val(number_format(hide_jumlah_angsuran,0,',','.'))
                
                setoran_minggon = parseFloat(data[i].setoran_mingguan)+parseFloat(data[i].setoran_lwk);
                parent.children('td').find('#setoran_minggon').val(setoran_minggon);
                parent.children('td').find('#penarikan_tabungan_sukarela').val(data[i].penarikan_tab_sukarela);


                total_setoran_tab_sukarela2 += parseFloat(data[i].setoran_tab_sukarela);
                total_setoran_minggon2 += parseFloat(setoran_minggon);
                total_penarikan_tab_sukarela2 += parseFloat(data[i].penarikan_tab_sukarela);

                $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: site_url+"transaction/get_trx_cm_save_berencana",
                  data: {trx_cm_save_detail_id:data[i].trx_cm_save_detail_id},
                  async: false,
                  success: function(respon2){
                    data2 = respon2;
                    if(data2.length>0){
                      var j = 0;
                      var setoran_berencana2 = 0;
                      $("input#detail_berencana_account_no",parent).each(function(){
                        var parent2 = $(this).parent().parent();
                        parent2.children('td').find('#detail_berencana_account_no').val(data2[j].account_saving_no);
                        parent2.children('td').find('#detail_berencana_setoran').val(data2[j].amount);
                        parent2.children('td').find('#detail_berencana_freq').val(data2[j].frekuensi);
                        hitung_setoran_berencana = parseFloat(data2[j].amount)*parseFloat(data2[j].frekuensi);
                        setoran_berencana2 += parseFloat(hitung_setoran_berencana);
                        j++;
                      });
                      parent.children('td').find('#setoran_tab_berencana').val(setoran_berencana2);
                      total_setoran_tab_berencana2 += parseFloat(setoran_berencana2);
                    }
                  }
                });


                i++;
              });
              $("#freq").trigger('blur');
              $("#total_setoran_tab_sukarela").val(number_format(total_setoran_tab_sukarela2,0,',','.'));
              $("#total_minggon").val(number_format(total_setoran_minggon2,0,',','.'));
              $("#total_setoran_tab_berencana").val(number_format(total_setoran_tab_berencana2,0,',','.'));
              $("#total_penarikan_tab_sukarela").val(number_format(total_penarikan_tab_sukarela2,0,',','.'));

              calc_setoran();
              calc_penarikan();
              calc_saldo_kas();

            }
          })

        }
        else
        {
          $("input[name='trx_cm_save_id']").val('');
        }

      },
      error: function(){
        alert("Failed to Connect into Database, Please contact your administrator");
      }
    });

  });


  //cek pelunasan

  $("table#form > tbody > tr > td > #freq").livequery('cekpelunasan',function(){
    freq                  = parseFloat($(this).val());
    jumlah_angsuran       = parseFloat(convert_numeric($(this).parent().parent().find('#jumlah_angsuran').val()));
    saldo_pokok           = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_pokok').val()));
    saldo_margin          = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_margin').val()));
    saldo_catab           = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_catab').val()));
    tabungan_wajib        = parseFloat(convert_numeric($(this).parent().parent().find('#balance_tabungan_wajib').val()));
    tabungan_kelompok     = parseFloat(convert_numeric($(this).parent().parent().find('#balance_tabungan_wajib').val()));
    angsuran_pokok        = parseFloat(convert_numeric($(this).parent().find('#angsuran_pokok').val()));
    angsuran_catab        = parseFloat(convert_numeric($(this).parent().find('#angsuran_catab').val()));
    pembiayaan_jangka_waktu = $(this).parent().find("#pembiayaan_jangka_waktu").val();
    pembiayaan_counter_angsuran = $(this).parent().find("#pembiayaan_counter_angsuran").val();
    obj = $(this);
    max_freq = parseFloat(pembiayaan_jangka_waktu)-parseFloat(pembiayaan_counter_angsuran);

    total_angsuran        = freq*angsuran_pokok;
    total_saldo_angsuran  = saldo_pokok; 

    // console.log(jumlah_angsuran);
    // console.log($(this));
    if(total_angsuran>=total_saldo_angsuran && jumlah_angsuran!=0)
    {
      catab_pindah = saldo_catab+(angsuran_catab*freq);
      obj.closest('tr').children('td').css({backgroundColor:'#FD965A',color:'white'});
    }else{
      obj.closest('tr').children('td').css({backgroundColor:'',color:''});
    }

  });


  $("table#form > tbody > tr > td > #freq").livequery('blur',function(){
    freq                  = parseFloat($(this).val());
    jumlah_angsuran       = parseFloat(convert_numeric($(this).parent().parent().find('#jumlah_angsuran').val()));
    saldo_pokok           = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_pokok').val()));
    saldo_margin          = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_margin').val()));
    saldo_catab           = parseFloat(convert_numeric($(this).parent().parent().find('#pembiayaan_saldo_catab').val()));
    tabungan_wajib        = parseFloat(convert_numeric($(this).parent().parent().find('#balance_tabungan_wajib').val()));
    tabungan_kelompok     = parseFloat(convert_numeric($(this).parent().parent().find('#balance_tabungan_wajib').val()));
    angsuran_pokok        = parseFloat(convert_numeric($(this).parent().find('#angsuran_pokok').val()));
    angsuran_catab        = parseFloat(convert_numeric($(this).parent().find('#angsuran_catab').val()));
    pembiayaan_jangka_waktu = $(this).parent().find("#pembiayaan_jangka_waktu").val();
    pembiayaan_counter_angsuran = $(this).parent().find("#pembiayaan_counter_angsuran").val();
    obj = $(this);
    cif_no = $(this).parent().parent().attr('cifno');
    max_freq = parseFloat(pembiayaan_jangka_waktu)-parseFloat(pembiayaan_counter_angsuran);

    total_angsuran        = freq*angsuran_pokok;
    total_saldo_angsuran  = saldo_pokok; 

    console.log('total_angsuran:'+total_angsuran+',total_saldo_tabungan:'+total_saldo_angsuran);
    // console.log(jumlah_angsuran);
    // console.log($(this));
    if(total_angsuran>=total_saldo_angsuran && jumlah_angsuran!=0)
    {
      catab_pindah = saldo_catab+(angsuran_catab*freq);
      $("#cif_no","#dialog_saldo_outstanding").parent().parent().find('#muqosha').parent().parent().show();
      alert("Ini adalah Transaksi Pelunasan. \r\n- Sisa Saldo Pokok = "+number_format(total_saldo_angsuran,0,',','.')+".\r\n- Angsuran Pokok Terakhir = "+number_format(total_angsuran,0,',','.')+".\r\n- Saldo Catab yg akan dipindahkan = "+number_format(catab_pindah,0,',','.')+"\r\nMohon Periksa Kembali Sebelum di Proses");
      obj.val(max_freq)
      obj.closest('tr').children('td').css({backgroundColor:'#FD965A',color:'white'});
      obj.parent().parent().find('.modal-body table tbody tr').css({color:'#000'})
    }else{
      $("#cif_no","#dialog_saldo_outstanding").parent().parent().find('#muqosha').parent().parent().hide();
      obj.closest('tr').children('td').css({backgroundColor:'',color:''});
    }

  });

  $("input#penarikan_tabungan_sukarela").livequery('change',function(){
    cif_no = $(this).parent().parent().find("#cif_no").val();
    obj = $(this);
    var setoran_tabungan_sukarela = parseFloat(convert_numeric($(this).parent().parent().find('#setoran_tabungan_sukarela').val()));
    $.ajax({
      type: "POST",
      url: site_url+"transaction/check_saldo_tab_sukarela",
      data: {
        cif_no: cif_no
      },
      dataType: "json",
      success: function(respon){
        if(isNaN(setoran_tabungan_sukarela)==true) setoran_tabungan_sukarela = 0;
        var saldo_tabungan_sukarela = parseFloat(respon.saldo);
        var saldo = setoran_tabungan_sukarela+saldo_tabungan_sukarela;

        if( parseFloat(convert_numeric(obj.val())) > saldo )
        {
          msgadd = '';
          if(setoran_tabungan_sukarela>0){
            msgadd = "\r\n- total setoran tabungan sukarela = "+number_format(setoran_tabungan_sukarela,0,',','.');
            msgadd += "\r\n- maksimal penarikan = "+number_format(saldo,0,',','.');
          }
          alert("Sisa Saldo Tab. Sukarela CIF("+cif_no+") tidak mencukupi untuk melakukan Penarikan.\r\n- saldo sukarela = "+number_format(respon.saldo,0,',','.')+'.'+msgadd);
          obj.val('0').select();
          // console.log(obj);
          total_penarikan_tab_sukarela = 0;
          $("input#penarikan_tabungan_sukarela").each(function(){
            total_penarikan_tab_sukarela += parseFloat($(this).val());
          });

          $("#total_penarikan_tab_sukarela").val(number_format(total_penarikan_tab_sukarela,0,',','.'));
        }
      },
      error: function(){
        alert("Failed to Connect into Databases, Please Contact Your Administrator");
      }
    })
  });

    
  
  

  $("button#btnoksetminggon").live('click',function(){
    formid = $(this).attr('formid');
    setoran_lwk = convert_numeric($("#setoran_lwk","#dialog_minggon_"+formid).val());
    setoran_mingguan = convert_numeric($("#setoran_mingguan","#dialog_minggon_"+formid).val());
    total_setoran_minggon = parseFloat(setoran_lwk)+parseFloat(setoran_mingguan);
    if(total_setoran_minggon!=0){
      total_setoran_minggon = number_format(total_setoran_minggon,0,',','.');
    }

    $("#dialog_minggon_"+formid).parent().find("#setoran_minggon").val(total_setoran_minggon).select();
    
    grand_total_setoran_minggon = 0;
    $("input#setoran_minggon").each(function(){
      val = $(this).val();
      if(val==""){
        val = 0;
      }
      grand_total_setoran_minggon+= parseFloat(convert_numeric(val));
    });
    $("#total_minggon").val(number_format(grand_total_setoran_minggon,0,',','.'));
    $("button#close","#dialog_minggon_"+formid).trigger('click');
    
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();


  });
  

  $("button#btnokfrmtaberencana").live('click',function(){
    formid = $(this).attr('formid');
    total_tabungan_berencana = 0;
    $("input#detail_berencana_freq","#dialog_tabungan_berencana_"+formid).each(function(){
      total_tabungan_berencana += parseFloat(convert_numeric($(this).val())) * parseFloat(convert_numeric($(this).parent().find("#detail_berencana_setoran").val()));
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

  $("input#setoran_tab_berencana").livequery('dblclick',function(){
    $(this).parent().find('a').trigger('click');
    // window.scrollTo(0,0)
  });

  $("input#setoran_minggon").livequery('dblclick',function(){
    $(this).parent().find('a').trigger('click');
    // window.scrollTo(0,0)
  });
  
  function calc_setoran()
  {
    total_angsuran = parseFloat(convert_numeric($("#total_angsuran","#process_trx_rembug").val()));
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
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    $("#total_setoran_tab_sukarela").val(number_format(total_amount,0,',','.'));
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total setoran minggon ************************************************/
  $("input#setoran_minggon","form#process_trx_rembug").live('keyup',function(){
    return $(this).next();
    if($(this).val()==0){
      $(this).parent().find('#setoran_lwk').val(0);
      $(this).parent().find('#setoran_mingguan').val(0);
    }else{
      if($(this).parent().find('#setoran_lwk').val()=='0'){
        $(this).parent().find('#setoran_mingguan').val(convert_numeric($(this).val()));
      }
    }
    total_amount = 0;
    $("input#setoran_minggon").each(function(){
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    
    $("#total_minggon").val(number_format(total_amount,0,',','.'));
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total penarikan tabungan sukarela ************************************************/
  $("input#penarikan_tabungan_sukarela","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#penarikan_tabungan_sukarela").each(function(){
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    $("#total_penarikan_tab_sukarela").val(number_format(total_amount,0,',','.'));
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi plafon ************************************************/
  $("input#realisasi_plafon","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_plafon").each(function(){
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    $("#total_realisasi_plafon").val(number_format(total_amount,0,',','.'));
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi adm ************************************************/
  $("input#realisasi_adm","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_adm").each(function(){
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    $("#total_realisasi_adm").val(number_format(total_amount,0,',','.'));
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi asuransi ************************************************/
  $("input#realisasi_asuransi","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_asuransi").each(function(){
      value = parseFloat(convert_numeric($(this).val()));
      if(isNaN(value)==true){
        value = 0;
      }
      total_amount += value;
    });
    if(isNaN(total_amount)==true){
      total_amount = 0;
    }
    $("#total_realisasi_asuransi").val(number_format(total_amount,0,',','.'));
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
    $.ajax({
      type: "POST",
      dataType: "json",
      data: $("#process_trx_rembug").serialize(),
      url: site_url+"transaction/process_trx_rembug_save",
      async: false,
      success: function(response){
        if(response.success===true){
          alert(response.message);
          window.location.reload(true);
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
      }
    })
  });

  $("#cancel_trx").click(function(){
      $(".search").trigger('click');
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
          $(window).scrollTop($(this).parent().parent().next().find("#absen").offset().top - 200);
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child select#absen","#form").live('keydown',function(e){
        if(e.keyCode==9){
          $('tr:first-child #freq').focus()
          $(window).scrollTop($('tr:first-child #freq').offset().top - 200);
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
          $(window).scrollTop($(this).parent().parent().prev().find("#absen").offset().top - 200);
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
          if(typeof($(this).parent().parent().prev().find("#freq").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().prev().find("#freq").offset().top - 200);
          }
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
          $(window).scrollTop($('tr:last-child #absen').offset().top - 200);
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
        if(e.keyCode==40 || e.keyCode==13){
          $(this).parent().parent().next().find("#freq").select();
          if(typeof($(this).parent().parent().next().find("#freq").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().next().find("#freq").offset().top - 200);
          }
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
        if(e.keyCode==40 || e.keyCode==13){
          $('tr:first-child #setoran_tabungan_sukarela').select()
          $(window).scrollTop($('tr:first-child #setoran_tabungan_sukarela').offset().top - 200);
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
          if(typeof($(this).parent().parent().prev().find("#setoran_tabungan_sukarela").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().prev().find("#setoran_tabungan_sukarela").offset().top - 200);
          }
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
          $(window).scrollTop($('tr:last-child #freq').offset().top - 200);
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
        if(e.keyCode==40 || e.keyCode==13){
          $(this).parent().parent().next().find("#setoran_tabungan_sukarela").select();
          if(typeof($(this).parent().parent().next().find("#setoran_tabungan_sukarela").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().next().find("#setoran_tabungan_sukarela").offset().top - 200);
          }
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
        if(e.keyCode==40 || e.keyCode==13){
          $('tr:first-child #penarikan_tabungan_sukarela').select()
          $(window).scrollTop($('tr:first-child #penarikan_tabungan_sukarela').offset().top - 200);
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
          if(typeof($(this).parent().parent().prev().find("#penarikan_tabungan_sukarela").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().prev().find("#penarikan_tabungan_sukarela").offset().top - 200);
          }
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
          $(window).scrollTop($('tr:last-child #setoran_tabungan_sukarela').offset().top - 200);
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
        if(e.keyCode==40 || e.keyCode==13){
          $(this).parent().parent().next().find("#penarikan_tabungan_sukarela").select();
          if(typeof($(this).parent().parent().next().find("#penarikan_tabungan_sukarela").offset())!='undefined') {
            $(window).scrollTop($(this).parent().parent().next().find("#penarikan_tabungan_sukarela").offset().top - 200);
          }
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
        if(e.keyCode==40 || e.keyCode==13){
          $('#kas_awal').select()
          $(window).scrollTop($('#kas_awal').offset().top - 200);
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
          $(window).scrollTop($('tr:last-child input#penarikan_tabungan_sukarela').offset().top - 200);
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
        if(e.keyCode==40 || e.keyCode==13){
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

  $("input#detail_berencana_freq").livequery('keydown',function(e){
    if(e.keyCode==13){
      if($(this).val()==""){
        $(this).val(0);
      }
      $(this).closest('.modal-body').parent().find('#btnokfrmtaberencana').trigger('click')
    }
  });
  $("input#setoran_lwk,input#setoran_mingguan").livequery('keydown',function(e){
    if(e.keyCode==13){
      $(this).closest('.modal-body').parent().find('#btnoksetminggon').trigger('click')
    }
  });

  $("#print_formulir").click(function(){
    if(form1.valid())
    {
      var branch            = $("input[name='branch']").val();
      var cm                = $("input[name='cm']").val();
      var cm_code           = $("input[name='cm_code']").val();
      var fa                = $("input[name='fa']").val();
      var account_cash_code = $("input[name='account_cash_code']").val();
      var tanggal           = $("input[name='tanggal']").val().replace(/\//g,'-');
      window.open(site_url+'transaction/print_form_trx_rembug/'+cm_code+'/'+account_cash_code+'/'+tanggal+'/'+branch+'/'+cm);
    }
  })

  $("input#muqosha","#dialog_saldo_outstanding").livequery('keyup',function(){
    cif_no = $(this).closest("#dialog_saldo_outstanding").find("#cif_no").val();
    muqosha = convert_numeric($(this).val());
    console.log(cif_no)
    console.log(muqosha)
    $("tr[cifno='"+cif_no+"'] #muqosha").val(muqosha);
    console.log($("tr[cifno='"+cif_no+"'] #muqosha"));
  });

});
</script>

<?php $this->load->view('_jsfoot'); ?>