<style type="text/css">
  .pink{
    background-color:pink !important;
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
      Pembiayaan <small>Registrasi Akad</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Akad</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Registrasi Akad</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:44px;float:left;margin-bottom:0;padding:0 5px 0 10px">Produk</label>
        <div style="padding:5px;float:left;">
          <select id="product_code" name="product_code" class="medium m-wrap" data-required="1" style="margin:0 5px;">
            <option value="all">SEMUA PRODUK</option>
            <?php foreach($product as $produk): ?>
              <option value="<?php echo $produk['product_code'];?>"><?php echo $produk['product_name'];?></option>
            <?php endforeach?>
          </select>
        </div>
        <div style="padding:5px;float:left;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th> -->
               <th width="12%">No Pengajuan</th>
               <th width="10%">CIF NO</th>
               <th width="15%">Nama Lengkap</th>
               <th width="10%">Jumlah</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="10%">Tgl Approval</th>
               <th width="15%">Pengajuan Melalui</th>
               <th width="15%">Produk</th>
               <th width="15%">&nbsp;</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog_history" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:150px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>History Outstanding Pembiayaan</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <table>
               <tr>
                 <td width="150">No. Pembiayaan</td>
                 <td><div id="history_no_pembiayaan"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Pokok</td>
                 <td><div id="history_sisa_pokok"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Margin</td>
                 <td><div id="history_sisa_margin"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Catab</td>
                 <td><div id="history_sisa_catab"></div></td>
               </tr>
            </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>



<!-- BEGIN EDIT REGIS -->
<div id="edit_regis" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Registrasi Akad Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_id" name="account_financing_id">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
          <input type="hidden" id="cif_flag" name="cif_flag">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message"></span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>

            </div>
          </br>      
                    <div class="control-group">
                       <label style="text-align:left"><h4>Data CIF ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">CIF NO<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Jabatan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jabatan" id="jabatan" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                      
                    <div class="control-group">
                       <label class="control-label">Lokasi Kerja<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="lokasi_kerja" id="lokasi_kerja" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group hide">
                       <label class="control-label">Alamat Lokasi Kerja</label>
                       <div class="controls">
                          <textarea name="alamat_lokasi_kerja" id="alamat_lokasi_kerja" class="large m-wrap"/>
                          </textarea>
                       </div>
                    </div>               
                    <div class="control-group">
                       <label class="control-label">No Telpon<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" maxlength="15"  readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30" placeholder="Suami/Istri"/>
                       </div>
                    </div>                 
                    <div class="control-group hide">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30"/>
                       </div>
                    </div>                
                   <!--  <div class="control-group">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" readonly="" style="background-color:#eee;width:50px;" maxlength="2" value="0" />
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Status Rumah<span class="required">*</span></label>
                       <div class="controls">
                           <select id="status_rumah" name="status_rumah" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="1">Sendiri</option>
                             <option value="2">Sewa/Kontrak</option>
                             <option value="3">Orang Tua</option>
                           </select>
                        </div>
                    </div>    -->         
                    <div class="control-group">
                        <label class="control-label">Rekening<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Bank</span>
                             <input type="text" class="medium m-wrap" name="nama_bank" id="nama_bank" maxlength="30" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                             <input type="text" class="medium m-wrap" name="bank_cabang" id="bank_cabang" maxlength="100" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                             <input type="text" class="medium m-wrap" name="no_rekening" id="no_rekening" maxlength="20" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>   
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Atas Nama</span>
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" maxlength="50" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>    
                    <hr data-cifflag="1">    

                    <div class="control-group" data-cifflag="1">
                       <label style="text-align:left"><h4>Data Penghasilan Perbulan::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">THP <span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="thp" id="thp" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">40% THP<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                          <input type="text" name="thp_40" id="thp_40" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>            
                    <hr data-cifflag="1">  

                    <div class="control-group" data-cifflag="1">
                       <label style="text-align:left"><h4>Kewajiban dan angsuran ::</h4></label>
                    </div> 
                    <div style="display:none;">                      
                      <div class="control-group">
                         <label class="control-label">Angsuran Ke Koptel<span class="required">*</span></label>
                         <div class="controls" id="checker_jumlah_kewajiban_edit">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap mask-money"  style="width:120px !important;"/>
                              <span class="add-on">,00</span>
                            </div>
                         </div>
                      </div> 
                      <div class="control-group" id="div_saldo_kewajiban_ke_koptel">
                          <label class="control-label">Saldo Kewajiban Ke Koptel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" readonly="" style="width:120px;" name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel" value="0">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="control-group">                    
                      <label class="control-label">Saldo Kewajiban Ke Koptel</label>
                      <div class="controls" style="margin-top:20px;margin-bottom:20px;">
                        <input type="hidden" name="flag_registrasi" id="flag_registrasi">
                        <table width="35%" id="list_saldo_pokok">
                          <thead>
                            <tr>
                              <td style="height:30px;width:8%;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                &nbsp;
                              </td>
                              <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                Saldo Pokok
                              </td>
                              <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                Saldo Margin
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                            </tr> -->
                            <!-- <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val">
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no">
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_pokok[]" value="10000">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_margin[]" value="20000">
                              </td>
                            </tr>
                            <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val">
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no">
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_pokok[]" value="30000">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_margin[]" value="40000">
                              </td>
                            </tr> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_angsuran_edit">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1"/><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <div id="div_saldo_kewajiban" style="display:none;">
                      <div class="control-group">
                          <label class="control-label">Saldo Kewajiban Ke Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="saldo_kewajiban" id="saldo_kewajiban" value="0">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div> 
                      <div class="control-group">
                          <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <select class="m-wrap chosen" name="pelunasan_ke_kopeg_mana" id="pelunasan_ke_kopeg_mana">
                              <?php foreach($kopegtel as $data):?>
                              <option value="<?php echo $data['kopegtel_code'];?>"><?php echo $data['nama_kopegtel'];?></option>
                              <?php endforeach?>
                            </select>
                          </div>
                      </div>          
                    </div>          
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pengajuan ::</h4></label>
                    </div>  
                    <div class="row">
                    <div class="span5">
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group" data-cifflag="1">
                      <label class="control-label">Pengajuan Melalui <span class="required">*</span></label>
                      <div class="controls" style="padding-left:20px;">
                         <label class="radio" id="radio1">
                           <input type="radio" name="melalui" id="melalui1" value="koptel"/>
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi"/>
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="chosen m-wrap">
                             <option value="">PILIH</option>
                              <?php foreach($kopegtel as $key){ ?>
                             <option value="<?php echo $key['kopegtel_code'] ?>" ><?php echo $key['nama_kopegtel'] ?></option>
                             <?php } ?>
                           </select>
                         </span> 
                      </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <input type="hidden" name="product_code_post" id="product_code_post">
                           <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" jenis_margin="<?php echo $produk['jenis_margin'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" disabled="" class="medium m-wrap" data-required="1" readonly="" style="background-color:#eee;">
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>" akad_value="<?php echo $data['code_value'];?>" akad_name="<?php echo $data['akad_name'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>                                   
                    <div class="control-group">
                       <label class="control-label">Akad : </label>
                       <div class="controls" style="padding-top:7px">
                            <span id="span_akad">-</span>
                            <input type="hidden" name="val_akad" id="val_akad">
                       </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="amount" id="amount"  value="0" readonly="" style="background-color:#eee;">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;width:50px;"> *bulan
                        </div>
                    </div>     
                    <div class="control-group" id="div_jumlah_margin">
                       <label class="control-label"><span id="label-total-margin">Total Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Total Proyeksi Keuntungan</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="amount_proyeksi_keuntungan" id="amount_proyeksi_keuntungan" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Nisbah Nasbaah<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-append">
                             <input type="text" class="m-wrap" name="nisbah" id="nisbah" value="0" style="width:50px;" maxlength="6">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>   
                    </div>
                    <div class="span5" style="display:none;">
                      <table class="table table-striped table-bordered" id="table-termin">
                        <thead>
                          <tr>
                            <th>Termin</th>
                            <th>Nominal</th>
                            <th>Tgl. Rencana Pencairan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- body of termin goes here -->
                        </tbody>
                      </table>
                    </div>
                    </div>
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Angsuran ::</h4></label>
                    </div> 

                    <div class="control-group" id="control_tipe_angsuran">
                       <label class="control-label">Tipe Angsuran</label>
                       <div class="controls">
                          <select id="tipe_angsuran" class="m-wrap medium">
                            <option value="">PILIH</option>
                            <option value="reguler">Reguler</option>
                            <option value="nonreguler">Non Reguler</option>
                          </select>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_pokok">
                       <label class="control-label">Porsi Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_margin">
                       <label class="control-label"><span id="label-pendapatan-margin">Porsi Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>
                    <div class="control-group" id="div_angsuran_rate_margin">
                       <label class="control-label">Rate Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <input type="text" name="rate_margin" id="rate_margin" class="small m-wrap mask-money" style="text-align:right;"/>
                            <span class="add-on">%</span>
                          </div>
                       </div>
                    </div>
                    <div class="control-group" id="div_total_angsuran">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 

                      <div id="schedulle" style="display:none;">
                        <table class="table table-striped table-bordered" id="table-schedulle">
                          <thead>
                            <tr>
                              <th>Tgl. Angsuran</th>
                              <th>Porsi Pokok</th>
                              <th><span id="label-pendapatan-margin">Angsuran Margin</span></th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                            <tr>
                              <td style="text-align:right;font-weight:bold;">Total Angsuran</td>
                              <td style="text-align:center;"><input type="text" id="txtTotalAngsuranPokok" class="m-wrap medium" value="0" style="background:#f5f5f5;text-align:right;" disabled></td>
                              <td style="text-align:center;"><input type="text" id="txtTotalAngsuranMargin" class="m-wrap medium" value="0" style="background:#f5f5f5;text-align:right;" disabled></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>

                    <hr data-cifflag="1">  
                    <div id="div_tipe_developer" style="display:none;">
                      <div class="control-group">
                         <label style="text-align:left"><h4>Data PENJUAL ::</h4></label>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Tipe Penjual</label>
                         <div class="controls">
                            <select class="medium m-wrap" name="tipe_developer" id="tipe_developer" disabled="" style="background-color:#eee;">
                               <option value="">Select</option>
                               <option value="0">Individu</option>
                               <option value="1">Perusahaan</option>
                            </select>
                         </div>
                      </div> 
                    </div> 
                    <div id="div_individu" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Nama Penjual</label>
                         <div class="controls">
                            <input type="text" name="nama_penjual_individu" id="nama_penjual_individu" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                      <div class="control-group hide">
                         <label class="control-label">Nomer KTP</label>
                         <div class="controls">
                            <input type="text" name="nomer_ktp" id="nomer_ktp" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Nama Pasangan</label>
                         <div class="controls">
                            <input type="text" name="nama_pasangan_developer" id="nama_pasangan_developer" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                    </div>
                    <div id="div_perusahaan" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Nama Perusahaan</label>
                         <div class="controls">
                            <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                    </div>          
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Biaya-biaya ::</h4></label>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_adm" id="biaya_adm" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_notaris" id="biaya_notaris" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Biaya Asuransi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_asuransi" id="biaya_asuransi" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Total Biaya</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_biaya" id="total_biaya" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 
                    <hr>   
                  <div class="row">
                    <div class="span4">         
                      <div class="control-group">
                         <label style="text-align:left"><h4>Tanggal Akad ::</h4></label>
                         <div class="controls" id="div_alert_tgl" style="color:red;">
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                         <div class="controls">
                            <input type="text" name="tgl_akad" id="tgl_akad" class="mask_date small m-wrap" placeholder="dd/mm/yyyy" />
                         </div>
                      </div>           
                      <div class="control-group">
                         <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                         <div class="controls">
                            <input type="text" name="angsuranke1" id="angsuranke1" class="mask_date small m-wrap" placeholder="dd/mm/yyyy"/>
                         </div>
                      </div>   
                      <div class="control-group">
                         <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                         <div class="controls">
                            <input type="text" name="tgl_jtempo" id="tgl_jtempo" class="small m-wrap" placeholder="dd/mm/yyyy" readonly="" />
                         </div>
                      </div>  
                    </div> 
                    <div class="span6" id="span_angsuran_nonreguler"> </div>
                  </div>          
            <div class="form-actions">
               <input type="hidden" name="min_margin" id="min_margin" value="0">
               <input type="hidden" name="max_margin" id="max_margin" value="0">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_jadwal_angsuran" id="flag_jadwal_angsuran">
               <input type="hidden" name="account_financing_no" id="account_financing_no">
               <button type="button" id="act_update" class="btn purple">Update</button>
               <button type="button" id="act_reject_edit" class="btn red">Reject</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT REGIS -->


<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Akad Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_regis" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
          <input type="hidden" id="registration_no" name="registration_no">
          <input type="hidden" id="cif_flag" name="cif_flag">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message"></span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>

            </div>
          </br>      
                    <div class="control-group">
                       <label style="text-align:left"><h4>Data CIF ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">CIF NO<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Jabatan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jabatan" id="jabatan" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                      
                    <div class="control-group">
                       <label class="control-label">Lokasi Kerja<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="lokasi_kerja" id="lokasi_kerja" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group hide">
                       <label class="control-label">Alamat Lokasi Kerja</label>
                       <div class="controls">
                          <textarea name="alamat_lokasi_kerja" id="alamat_lokasi_kerja" class="large m-wrap"/>
                          </textarea>
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">No Telpon<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" maxlength="15"  readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30" placeholder="Suami/Istri"/>
                       </div>
                    </div>                 
                    <div class="control-group hide">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30"/>
                       </div>
                    </div>                
                    <!-- <div class="control-group">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" readonly="" style="background-color:#eee;width:50px;" maxlength="2" value="0" />
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Status Rumah<span class="required">*</span></label>
                       <div class="controls">
                           <select id="status_rumah" name="status_rumah" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="1">Sendiri</option>
                             <option value="2">Sewa/Kontrak</option>
                             <option value="3">Orang Tua</option>
                           </select>
                        </div>
                    </div>      -->       
                    <div class="control-group">
                        <label class="control-label">Rekening<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Bank</span>
                             <input type="text" class="medium m-wrap" name="nama_bank" id="nama_bank" maxlength="30" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>     
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                             <input type="text" class="medium m-wrap" name="bank_cabang" id="bank_cabang" maxlength="100" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                             <input type="text" class="medium m-wrap" name="no_rekening" id="no_rekening" maxlength="20" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>   
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Atas Nama</span>
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" maxlength="50"  onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>    
                    <hr data-cifflag="1">    

                    <div class="control-group" data-cifflag="1">
                       <label style="text-align:left"><h4>Data Penghasilan Perbulan::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">THP <span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="thp" id="thp" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">40% THP<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                          <input type="text" name="thp_40" id="thp_40" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>            
                    <hr data-cifflag="1">  

                    <div class="control-group" data-cifflag="1">
                       <label style="text-align:left"><h4>Kewajiban dan angsuran ::</h4></label>
                    </div> 
                    <div style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Angsuran Ke Koptel<span class="required">*</span></label>
                         <div class="controls" id="checker_jumlah_kewajiban_regis">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap mask-money"  style="width:120px !important;"/>
                              <span class="add-on">,00</span>
                            </div>
                         </div>
                      </div> 
                      <div class="control-group" id="div_saldo_kewajiban_ke_koptel">
                        <label class="control-label">Saldo Kewajiban Ke Koptel<span class="required">*</span></label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" readonly="" style="width:120px;" name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel" value="0">
                            <span class="add-on">,00</span>
                          </div>
                        </div>
                      </div>
                    </div> 
                    <div class="control-group">
                      <label class="control-label">Saldo Kewajiban Ke Koptel</label>
                      <div class="controls" style="margin-top:20px;margin-bottom:20px;">
                        <input type="hidden" name="flag_registrasi" id="flag_registrasi">
                        <table width="35%" id="list_saldo_pokok">
                          <thead>
                            <tr>
                              <td style="height:30px;width:8%;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                &nbsp;
                              </td>
                              <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                Saldo Pokok
                              </td>
                              <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                Saldo Margin
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                -
                              </td>
                            </tr> -->
                            <!-- <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val">
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no">
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_pokok[]" value="10000">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_margin[]" value="20000">
                              </td>
                            </tr>
                            <tr>
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val">
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no">
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_pokok[]" value="30000">
                              </td>
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                <input type="text" name="check_saldo_margin[]" value="40000">
                              </td>
                            </tr> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_angsuran_regis">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="20" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1"/><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <div id="div_saldo_kewajiban" style="display:none;">
                      <div class="control-group">
                          <label class="control-label">Saldo Kewajiban Ke Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="saldo_kewajiban" id="saldo_kewajiban" value="0">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div>   
                      <div class="control-group">
                          <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <select class="m-wrap chosen" name="pelunasan_ke_kopeg_mana" id="pelunasan_ke_kopeg_mana2">
                              <?php foreach($kopegtel as $data):?>
                              <option value="<?php echo $data['kopegtel_code'];?>"><?php echo $data['nama_kopegtel'];?></option>
                              <?php endforeach?>
                            </select>
                          </div>
                      </div>      
                    </div>      
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pengajuan ::</h4></label>
                    </div>  
                    <div class="row">
                    <div class="span5">
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>    
                    <div class="control-group" data-cifflag="1">
                      <label class="control-label">Pengajuan Melalui <span class="required">*</span></label>
                      <div class="controls" style="padding-left:20px;">
                         <label class="radio" id="radio1">
                           <input type="radio" name="melalui" id="melalui1" value="koptel" />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel1" name="kopegtel" class="m-wrap chosen">
                             <option value="">PILIH</option>
                              <?php foreach($kopegtel as $key){ ?>
                             <option value="<?php echo $key['kopegtel_code'] ?>" ><?php echo $key['nama_kopegtel'] ?></option>
                             <?php } ?>
                           </select>
                         </span> 
                      </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <input type="hidden" name="product_code_post" id="product_code_post">
                           <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" jenis_margin="<?php echo $produk['jenis_margin'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" disabled="" class="medium m-wrap" data-required="1" readonly="" style="background-color:#eee;">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>" akad_value="<?php echo $data['code_value'];?>" akad_name="<?php echo $data['akad_name'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>                            
                    <div class="control-group">
                       <label class="control-label">Akad : </label>
                       <div class="controls" style="padding-top:7px">
                            <span id="span_akad">-</span>
                            <input type="hidden" name="val_akad" id="val_akad">
                       </div>
                    </div>               
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="amount" id="amount" maxlength="15" value="0" readonly="" style="background-color:#eee;">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;width:50px;"> *bulan
                        </div>
                    </div>     
                    <div class="control-group" id="div_jumlah_margin">
                       <label class="control-label"><span id="label-total-margin">Total Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money"  readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Total Proyeksi Keuntungan</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="amount_proyeksi_keuntungan" id="amount_proyeksi_keuntungan" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Nisbah Nasabah<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-append">
                             <input type="text" class="m-wrap" name="nisbah" id="nisbah" value="0" style="width:50px;" maxlength="6">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>
                    </div>
                    <div class="span5" style="display:none;">
                      <table class="table table-striped table-bordered" id="table-termin">
                        <thead>
                          <tr>
                            <th>Termin</th>
                            <th>Nominal</th>
                            <th>Tgl. Rencana Pencairan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- body of termin goes here -->
                        </tbody>
                      </table>
                    </div>
                    </div>
                    <hr>                     
                      <div class="control-group">
                         <label style="text-align:left"><h4>Angsuran ::</h4></label>
                      </div> 
                      <div class="control-group" id="control_tipe_angsuran">
                         <label class="control-label">Tipe Angsuran</label>
                         <div class="controls">
                            <select id="tipe_angsuran" class="m-wrap medium">
                              <option value="">PILIH</option>
                              <option value="reguler">Reguler</option>
                              <option value="nonreguler">Non Reguler</option>
                            </select>
                         </div>
                      </div> 
                      <div class="control-group" id="div_angsuran_pokok">
                         <label class="control-label">Porsi Pokok</label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" />
                            </div>
                         </div>
                      </div> 
                      <div class="control-group" id="div_angsuran_margin">
                         <label class="control-label"><span id="label-pendapatan-margin">Porsi Margin</span></label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                            </div>
                         </div>
                      </div>
                      <div class="control-group" id="div_angsuran_rate_margin">
                       <label class="control-label">Rate Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <input type="text" name="rate_margin" id="rate_margin" class="small m-wrap mask-money" style="text-align:right;"/>
                            <span class="add-on">%</span>
                          </div>
                       </div>
                    </div>
                      <div class="control-group" id="div_total_angsuran">
                         <label class="control-label">Total Angsuran</label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap mask-money" readonly="" style="background-color:#eee;text-align:right;"/>
                            </div>
                         </div>
                      </div>

                      <div id="schedulle" style="display:none;">
                        <table class="table table-striped table-bordered" id="table-schedulle">
                          <thead>
                            <tr>
                              <th>Tgl. Angsuran</th>
                              <th>Porsi Pokok</th>
                              <th><span id="label-pendapatan-margin">Angsuran Margin</span></th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                            <tr>
                              <td style="text-align:right;font-weight:bold;">Total Angsuran</td>
                              <td style="text-align:center;"><input type="text" id="txtTotalAngsuranPokok" class="m-wrap medium" value="0" style="background:#f5f5f5;text-align:right;" disabled></td>
                              <td style="text-align:center;"><input type="text" id="txtTotalAngsuranMargin" class="m-wrap medium" value="0" style="background:#f5f5f5;text-align:right;" disabled></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>

                    <hr data-cifflag="1">   

                    <div id="div_tipe_developer" style="display:none;">
                      <div class="control-group">
                         <label style="text-align:left"><h4>Data PENJUAL ::</h4></label>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Tipe Penjual</label>
                         <div class="controls">
                            <select class="medium m-wrap" name="tipe_developer" id="tipe_developer" disabled="" style="background-color:#eee;">
                               <option value="">Select</option>
                               <option value="0">Individu</option>
                               <option value="1">Perusahaan</option>
                            </select>
                         </div>
                      </div> 
                    </div> 
                    <div id="div_individu" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Nama Penjual</label>
                         <div class="controls">
                            <input type="text" name="nama_penjual_individu" id="nama_penjual_individu" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                      <div class="control-group hide">
                         <label class="control-label">Nomer KTP</label>
                         <div class="controls">
                            <input type="text" name="nomer_ktp" id="nomer_ktp" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Nama Pasangan</label>
                         <div class="controls">
                            <input type="text" name="nama_pasangan_developer" id="nama_pasangan_developer" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                    </div>
                    <div id="div_perusahaan" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Nama Perusahaan</label>
                         <div class="controls">
                            <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="medium m-wrap" disabled="" style="background-color:#eee;" />
                         </div>
                      </div> 
                    </div>          
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Biaya-biaya ::</h4></label>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_adm" id="biaya_adm" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_notaris" id="biaya_notaris" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Biaya Asuransi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="biaya_asuransi" id="biaya_asuransi" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Total Biaya</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_biaya" id="total_biaya" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 
                    <hr>   

                    <div class="row">
                      <div class="span4">    
                        <div class="control-group">
                           <label style="text-align:left"><h4>Tanggal Akad ::</h4></label>
                           <div class="controls" id="div_alert_tgl" style="color:red;">
                           </div>
                        </div>    
                        <div class="control-group">
                           <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                           <div class="controls">
                              <input type="text" name="tgl_akad" id="tgl_akad" class="mask_date small m-wrap" placeholder="dd/mm/yyyy" />
                           </div>
                        </div>           
                        <div class="control-group">
                           <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                           <div class="controls">
                              <input type="text" name="angsuranke1" id="angsuranke1" class="mask_date small m-wrap" placeholder="dd/mm/yyyy"/>
                           </div>
                        </div>   
                        <div class="control-group">
                           <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                           <div class="controls">
                              <input type="text" name="tgl_jtempo" id="tgl_jtempo" class="small m-wrap" placeholder="dd/mm/yyyy" readonly="" />
                           </div>
                        </div> 
                      </div> 
                      <div class="span6" id="span_angsuran_nonreguler"> </div>
                    </div>        
            <div class="form-actions">
               <input type="hidden" name="account_saving_no" id="account_saving_no" value="n">
               <input type="hidden" name="min_margin" id="min_margin" value="0">
               <input type="hidden" name="max_margin" id="max_margin" value="0">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_jadwal_angsuran" id="flag_jadwal_angsuran">
               <button type="button" id="act_regis" class="btn green">Registrasi</button>
               <button type="button" id="act_reject" class="btn red">Reject</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT  -->


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
<script src="<?php echo base_url(); ?>assets/plugins/ba-throttle-debounce.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
v_regis_jenis_keuntungan = 0;
v_edit_jenis_keuntungan = 0;

    function generate_angsuran_nonreguler()
    {
        var jenis_margin  = $('#product_code option:selected',"#form_edit").attr('jenis_margin');
        var account_financing_id  = $('#account_financing_id', "#form_edit").val();
        if(jenis_margin=='2' || jenis_margin=='3') //margin efektif atau anuitas maka lookup ke schedulle
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_angsuran_nonreguler",
            type: "POST",
            async:false,
            dataType: "html",
            data: {account_financing_id:account_financing_id},
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_edit").html(response);
              $("#flag_jadwal_angsuran","#form_edit").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }
    }

      //angsuran ke koptel 15-04-2015 13:00
      // $("#jumlah_kewajiban","#form_regis").keyup(function(){
      //   if(convert_numeric($("#jumlah_kewajiban","#form_regis").val())>0){
      //     $(".checker","#checker_jumlah_kewajiban_regis").show();
      //     $("#span_txt_lunasi_ke_koptel","#form_regis").show();
      //     $("#lunasi_ke_koptel","#form_regis").show();
      //   }else{
      //     $(".checker","#checker_jumlah_kewajiban_regis").hide();
      //     $("#span_txt_lunasi_ke_koptel","#form_regis").hide();
      //     $("#lunasi_ke_koptel","#form_regis").parent().removeClass('checked');
      //     $("#lunasi_ke_koptel","#form_regis").attr('checked',false);
      //     $("#lunasi_ke_koptel","#form_regis").prop('checked',false);
      //     $("#div_saldo_kewajiban_ke_koptel","#form_regis").hide();
      //   }
      // })

      // $("#lunasi_ke_koptel","#form_regis").change(function() {
      //     if(this.checked) {
      //       $("#div_saldo_kewajiban_ke_koptel","#form_regis").show();
      //     }else{
      //       $("#div_saldo_kewajiban_ke_koptel","#form_regis").hide();
      //     }
      // });

      $("#jumlah_angsuran","#form_regis").keyup(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_regis").val())>0){
          $(".checker","#checker_jumlah_angsuran_regis").show();
          $("#span_txt_lunasi","#form_regis").show();
          $("#lunasi_ke_kopegtel","#form_regis").show();
        }else{
          $(".checker","#checker_jumlah_angsuran_regis").hide();
          $("#span_txt_lunasi","#form_regis").hide();
          $("#lunasi_ke_kopegtel","#form_regis").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_regis").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_regis").prop('checked',false);
          $("#div_saldo_kewajiban","#form_regis").hide();
        }
      })

      $("#lunasi_ke_kopegtel","#form_regis").change(function() {
          if(this.checked) {
            $("#div_saldo_kewajiban","#form_regis").show();
          }else{
            $("#div_saldo_kewajiban","#form_regis").hide();
          }
      });

      // $("#jumlah_kewajiban","#form_edit").keyup(function(){
      //   if(convert_numeric($("#jumlah_kewajiban","#form_edit").val())>0){
      //     $(".checker","#checker_jumlah_kewajiban_edit").show();
      //     $("#span_txt_lunasi_ke_koptel","#form_edit").show();
      //     $("#lunasi_ke_koptel","#form_edit").show();
      //   }else{
      //     $(".checker","#checker_jumlah_kewajiban_edit").hide();
      //     $("#span_txt_lunasi_ke_koptel","#form_edit").hide();
      //     $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked');
      //     $("#lunasi_ke_koptel","#form_edit").attr('checked',false);
      //     $("#lunasi_ke_koptel","#form_edit").prop('checked',false);
      //     $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
      //   }
      // })

      // $("#lunasi_ke_koptel","#form_edit").change(function() {
      //     if(this.checked) {
      //       $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
      //     }else{
      //       $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
      //     }
      // });

      $("#jumlah_angsuran","#form_edit").keyup(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_edit").val())>0){
          $(".checker","#checker_jumlah_angsuran_edit").show();
          $("#span_txt_lunasi","#form_edit").show();
          $("#lunasi_ke_kopegtel","#form_edit").show();
        }else{
          $(".checker","#checker_jumlah_angsuran_edit").hide();
          $("#span_txt_lunasi","#form_edit").hide();
          $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false);
          $("#div_saldo_kewajiban","#form_edit").hide();
        }
      })

      $("#lunasi_ke_kopegtel","#form_edit").change(function() {
          if(this.checked) {
            $("#div_saldo_kewajiban","#form_edit").show();
          }else{
            $("#div_saldo_kewajiban","#form_edit").hide();
          }
      });

      //end angsuran ke koptel 15-04-2015 13:00
      $("#angsuran_pokok","#form_regis").keyup(function(){
        hitung_margin_by_angsuran_pokok_form_regis();
      })

      function hitung_margin_by_angsuran_pokok_form_regis()
      {

        var angsuran_pokok    = convert_numeric($("#angsuran_pokok","#form_regis").val());
        var angsuran_margin   = convert_numeric($("#angsuran_margin","#form_regis").val());

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

        $("#total_angsuran","#form_regis").val(number_format(total_angsuran,0,',','.'));
      }

      $("#angsuran_pokok","#form_edit").keyup(function(){
        hitung_margin_by_angsuran_pokok_form_edit();
      })

      function hitung_margin_by_angsuran_pokok_form_edit()
      {

        var angsuran_pokok    = convert_numeric($("#angsuran_pokok","#form_edit").val());
        var angsuran_margin   = convert_numeric($("#angsuran_margin","#form_edit").val());

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

        $("#total_angsuran","#form_edit").val(number_format(total_angsuran,0,',','.'));
      }

      function get_total_pokok_efektif_form1(){
        var margin  = $('#product_code option:selected', "#form_regis").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_regis").val();
        var amount  = $('#amount', "#form_regis").val();

          $.ajax({
            url: site_url+"rekening_nasabah/get_margin_efektif",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
              },
            success: function(response)
            {
              $("#jumlah_margin","#form_regis").val(number_format(response,0,',','.'));
              $("#angsuran_pokok","#form_regis").val('0');
              $("#angsuran_margin","#form_regis").val('0');
              $("#total_angsuran","#form_regis").val('0');
              $("#angsuran_pokok","#form_regis").prop('0');
              $("#angsuran_margin","#form_regis").prop('0');
              $("#total_angsuran","#form_regis").prop('0');
              $("#div_angsuran_pokok","#form_regis").hide();
              $("#div_angsuran_margin","#form_regis").hide();
              $("#div_angsuran_rate_margin","#form_regis").hide();
              $("#div_total_angsuran","#form_regis").hide();
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        
      }

      function hitung_margin_form_regis()
      {
        var jenis_margin = $("#product_code","#form_regis").find('option:selected').attr('jenis_margin');
        var product_code = $("#product_code","#form_regis").val();
        var jangkawaktu = $("#jangka_waktu",'#add').val();
        var pokok = $('#amount','#add').val();
        if(jenis_margin=='2'){//efektif
          get_total_pokok_efektif_form1();
        } else if (jenis_margin=='3') {
          var tmvalid = true;
          if (pokok=='' || pokok=='0') {
            tmvalid = false;
          }
          if (jangkawaktu=='' || jangkawaktu=='0') {
            tmvalid = false;
          }
          if (tmvalid==true) {
            get_total_margin_dan_angsuran_anuitas_formregis();
          }
        } else{ //flat

          var amount        = convert_numeric($("#amount","#form_regis").val());
          var jangka_waktu  = parseFloat($("#jangka_waktu","#form_regis").val());
          var v_total_angsuran = 0;
          var v_angsuran_pokok = 0;

          if(product_code == '58'){
            
            //** KEBUTUHAN MIGRASI ASDIK
            var kopegtel_code  = $('#nik', "#form_regis").val();
            var code_rate = kopegtel_code+'_'+amount+'_'+jangka_waktu;
            
            var rate = function () {
                var tmp = null;
                $.ajax({
                  url: site_url+"rekening_nasabah/get_rate_dinamis/"+code_rate,
                  type: "GET",
                  async:false,
                  success: function(result)
                  {
                    tmp = result*100;
                  }
                });
                return tmp;
            }();
            //** END KEBUTUHAN MIGRASI

          }else{
            var rate = $("#product_code","#form_regis").find('option:selected').attr('maxrate');
          }

          if(rate==''){
            rate = eval(0);
          }else{
            rate = eval(rate);
          }
          if(amount==''){
            amount = eval(0);
          }else{
            amount = eval(amount);
          }
          if(jangka_waktu==''){
            jangka_waktu = eval(0);
          }else{
            jangka_waktu = eval(jangka_waktu);
          }

          total_margin = ((rate/1200)*amount*jangka_waktu);

          angsuran_pokok = (amount/jangka_waktu);

          angsuran_margin = (eval(total_margin)/jangka_waktu);

          total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))
          var v_total_angsuran = pembulatan_angsuran(total_angsuran);
          var v_angsuran_pokok = v_total_angsuran-angsuran_margin;

          if(product_code=='58'){
            $("#angsuran_margin","#form_regis").attr("readonly", false); 
            $("#angsuran_margin","#form_regis").css("background-color", "#fff"); 
            $("#rate_margin","#form_regis").val(rate); 
          }else{
            $("#angsuran_margin","#form_regis").attr("readonly", true); 
            $("#angsuran_margin","#form_regis").css("background-color", "#eee"); 
          }

          $("#jumlah_margin","#form_regis").val(number_format(total_margin,0,',','.'));
          $("#angsuran_pokok","#form_regis").val(number_format(v_angsuran_pokok,0,',','.'));
          $("#angsuran_margin","#form_regis").val(number_format(angsuran_margin,0,',','.'));
          $("#total_angsuran","#form_regis").val(number_format(v_total_angsuran,0,',','.'));
        }
      }

      function hitung_margin()
      {
        var amount        = convert_numeric($("#amount","#form_regis").val());
        var jumlah_margin = convert_numeric($("#jumlah_margin","#form_regis").val());
        var jangka_waktu  = $("#jangka_waktu","#form_regis").val();

        if(amount==''){
          amount = eval(0);
        }else{
          amount = eval(amount);
        }
        if(jangka_waktu==''){
          jangka_waktu = eval(0);
        }else{
          jangka_waktu = eval(jangka_waktu);
        }
        if(jumlah_margin==''){
          jumlah_margin = eval(0);
        }else{
          jumlah_margin = eval(jumlah_margin);
        }

        total_margin = jumlah_margin;

        angsuran_pokok = (amount/jangka_waktu);

        angsuran_margin = (eval(total_margin)/jangka_waktu);

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

        $("#angsuran_pokok","#form_regis").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_regis").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_regis").val(number_format(total_angsuran,0,',','.'));

        // $("#span_test","#form_regis").html(rate+' | '+amount+' | '+jangka_waktu+' | '+jumlah_margin);
        // $("#span_test2","#form_regis").html(angsuran_pokok+' | '+angsuran_margin+' | '+total_angsuran);
      }

      $("#jumlah_margin","#form_regis").keyup(function(){
        hitung_margin();
      })
      $("#jumlah_margin","#form_regis").change(function(){
        hitung_margin();
      })

      $("#angsuran_margin","#form_regis").keyup(function(){
        var angsuran_pokok  = convert_numeric($("#angsuran_pokok","#form_regis").val());
        var angsuran_margin  = convert_numeric($(this).val());

        if(angsuran_margin != '' || angsuran_margin != 0 ){
          total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))
          $("#total_angsuran","#form_regis").val(number_format(total_angsuran,0,',','.'));
        }
      })

      $("#rate_margin","#form_regis").keyup(function(){
        var rate          = $(this).val();
        var amount        = convert_numeric($("#amount","#form_regis").val());
        var jangka_waktu  = parseFloat($("#jangka_waktu","#form_regis").val());
        var product_code  = $("#product_code","#form_regis").val();
        var v_total_angsuran = 0;
        var v_angsuran_pokok = 0;

        if(rate==''){
          rate = eval(0);
        }else{
          rate = eval(rate);
        }

        total_margin = ((rate/1200)*amount*jangka_waktu);

        angsuran_pokok = (amount/jangka_waktu);

        angsuran_margin = (eval(total_margin)/jangka_waktu);

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))
        var v_total_angsuran = pembulatan_angsuran(total_angsuran);
        var v_angsuran_pokok = v_total_angsuran-angsuran_margin;

        if(product_code=='58'){
          $("#angsuran_margin","#form_regis").attr("readonly", false); 
          $("#angsuran_margin","#form_regis").css("background-color", "#fff");
        }else{
          $("#angsuran_margin","#form_regis").attr("readonly", true); 
          $("#angsuran_margin","#form_regis").css("background-color", "#eee"); 
        }

        $("#jumlah_margin","#form_regis").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_regis").val(number_format(v_angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_regis").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_regis").val(number_format(v_total_angsuran,0,',','.'));
      })

      function hitung_total_biaya_regis()
      {
        var biaya_notaris        = convert_numeric($("#biaya_notaris","#form_regis").val());
        var biaya_adm = convert_numeric($("#biaya_adm","#form_regis").val());
        var biaya_asuransi = convert_numeric($("#biaya_asuransi","#form_regis").val());

        if(biaya_notaris==''){
          biaya_notaris = eval(0);
        }else{
          biaya_notaris = eval(biaya_notaris);
        }
        if(biaya_adm==''){
          biaya_adm = eval(0);
        }else{
          biaya_adm = eval(biaya_adm);
        }
        if(biaya_asuransi==''){
          biaya_asuransi = eval(0);
        }else{
          biaya_asuransi = eval(biaya_asuransi);
        }

        total_biaya = (biaya_notaris+biaya_adm+biaya_asuransi)

        $("#total_biaya","#form_regis").val(number_format(total_biaya,0,',','.'));
      }
      $("#biaya_notaris","#form_regis").keyup(function(){
        hitung_total_biaya_regis();
      })
      $("#biaya_notaris","#form_regis").change(function(){
        hitung_total_biaya_regis();
      })
      $("#biaya_adm","#form_regis").keyup(function(){
        hitung_total_biaya_regis();
      })
      $("#biaya_adm","#form_regis").change(function(){
        hitung_total_biaya_regis();
      })
      $("#biaya_asuransi","#form_regis").keyup(function(){
        hitung_total_biaya_regis();
      })
      $("#biaya_asuransi","#form_regis").change(function(){
        hitung_total_biaya_regis();
      })

      function get_total_margin_dan_angsuran_anuitas_formregis(){
        var margin  = $('#product_code option:selected', "#form_regis").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_regis").val();
        var amount  = $('#amount', "#form_regis").val();
        var product_code  = $("#product_code","#form_regis").val();

        $.ajax({
          url: site_url+"rekening_nasabah/get_total_angsuran_anuitas",
          type: "POST",
          async:false,
          dataType: "json",
          data: {
              pokok:amount
              ,jangkawaktu:jangka_waktu
              ,margin_tahun:margin
              ,product_code:product_code
            },
          success: function(response)
          {
            $("#jumlah_margin","#form_regis").val(number_format(response.total_margin,0,',','.'));
            $("#total_angsuran","#form_regis").val(number_format(response.total_angsuran,0,',','.'));
            $("#angsuran_pokok","#form_regis").val('0');
            $("#angsuran_pokok","#form_regis").prop('0');
            $("#angsuran_margin","#form_regis").val('0');
            $("#angsuran_margin","#form_regis").prop('0');
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
      }

      function get_date_form_regis_by_akad()
      {
        var tgl_akad = $("#tgl_akad","#form_regis").val();
        var jangka_waktu = $("#jangka_waktu","#form_regis").val();
        $.ajax({
          url: site_url+"rekening_nasabah/get_date_regis_by_tglakad_baru",
          type: "POST",
          dataType: "html",
          async:false,
          data: {
             tgl_akad:tgl_akad
            ,jangka_waktu:jangka_waktu
          },
          success: function(response2)
          {
            res = response2.split("|");
            if (res[0]=="non") {
              $("#div_alert_tgl","#form_regis").html(res[1]);
              $("#tgl_jtempo","#form_regis").val("");
            } else{
              $("#angsuranke1","#form_regis").val(res[0]);
              $("#tgl_jtempo","#form_regis").val(res[1]);
              $("#div_alert_tgl","#form_regis").html("");
            }
          },
          error: function(){
              $("#div_alert_tgl","#form_regis").html("Kesalahan database, harap hubungi IT support");
          }
        })

        var jenis_margin  = $('#product_code option:selected',"#form_regis").attr('jenis_margin');
        var margin  = $('#product_code option:selected', "#form_regis").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_regis").val();
        var amount  = $('#amount', "#form_regis").val();
        var angsuranke1  = $('#angsuranke1', "#form_regis").val();
        var jumlah_margin  = $('#jumlah_margin', "#form_regis").val();
        var product_code  = $('#product_code', "#form_regis").val();
        if(jenis_margin=='2') //margin efektif
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_efektif",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_regis").html(response);
              $("#flag_jadwal_angsuran","#form_regis").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        } 
        else if (jenis_margin=='3') 
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_anuitas",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
                ,jumlah_margin:jumlah_margin
                ,product_code:product_code
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_regis").html(response);
              $("#flag_jadwal_angsuran","#form_regis").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }
      }

      function get_date_form_regis_by_angs1()
      {
        var angsuranke1 = $("#angsuranke1","#form_regis").val();
        var jangka_waktu = $("#jangka_waktu","#form_regis").val();
        $.ajax({
          url: site_url+"rekening_nasabah/get_date_regis_by_angs1",
          type: "POST",
          dataType: "html",
          async:false,
          data: {
             angsuranke1:angsuranke1
            ,jangka_waktu:jangka_waktu
          },
          success: function(response2)
          {
            res = response2.split("|");
            if (res[0]=="non") {
              $("#div_alert_tgl","#form_regis").html(res[1]);
              $("#tgl_jtempo","#form_regis").val("");
            } else{
              $("#tgl_jtempo","#form_regis").val(res[1]);
              $("#div_alert_tgl","#form_regis").html("");
            }
          },
          error: function(){
              $("#div_alert_tgl","#form_regis").html("Kesalahan database, harap hubungi IT support");
          }
        })

        var jenis_margin  = $('#product_code option:selected',"#form_regis").attr('jenis_margin');
        var margin  = $('#product_code option:selected', "#form_regis").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_regis").val();
        var amount  = $('#amount', "#form_regis").val();
        var angsuranke1  = $('#angsuranke1', "#form_regis").val();
        var jumlah_margin  = $('#jumlah_margin', "#form_regis").val();
        var product_code  = $('#product_code', "#form_regis").val();
        if(jenis_margin=='2') //margin efektif
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_efektif",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_regis").html(response);
              $("#flag_jadwal_angsuran","#form_regis").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }
        else if (jenis_margin=='3') 
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_anuitas",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
                ,jumlah_margin:jumlah_margin
                ,product_code:product_code
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_regis").html(response);
              $("#flag_jadwal_angsuran","#form_regis").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }

      }
      $("#tgl_akad","#form_regis").change(function(){
        get_date_form_regis_by_akad();
      })
      $("#angsuranke1","#form_regis").change(function(){
        get_date_form_regis_by_angs1();
      })

      /*
      ** function-function Edit
      */
      function hitung_margin_form_edit()
      {
        var rate          = $("#product_code","#form_edit").find('option:selected').attr('maxrate');
        var amount        = convert_numeric($("#amount","#form_edit").val());
        var jangka_waktu  = $("#jangka_waktu","#form_edit").val();
        var v_total_angsuran = 0;
        var v_angsuran_pokok = 0;

        if(rate==''){
          rate = eval(0);
        }else{
          rate = eval(rate);
        }
        if(amount==''){
          amount = eval(0);
        }else{
          amount = eval(amount);
        }
        if(jangka_waktu==''){
          jangka_waktu = eval(0);
        }else{
          jangka_waktu = eval(jangka_waktu);
        }

        total_margin = (rate*amount*jangka_waktu/1200);

        angsuran_pokok = (amount/jangka_waktu);

        angsuran_margin = (eval(total_margin)/jangka_waktu);

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))
        var v_total_angsuran = pembulatan_angsuran(total_angsuran);
        var v_angsuran_pokok = v_total_angsuran-angsuran_margin;

        $("#jumlah_margin","#form_edit").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_edit").val(number_format(v_angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_edit").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_edit").val(number_format(v_total_angsuran,0,',','.'));
      }

      function hitung_margin_edit()
      {
        var amount        = convert_numeric($("#amount","#form_edit").val());
        var jumlah_margin = convert_numeric($("#jumlah_margin","#form_edit").val());
        var jangka_waktu  = $("#jangka_waktu","#form_edit").val();

        if(amount==''){
          amount = eval(0);
        }else{
          amount = eval(amount);
        }
        if(jangka_waktu==''){
          jangka_waktu = eval(0);
        }else{
          jangka_waktu = eval(jangka_waktu);
        }
        if(jumlah_margin==''){
          jumlah_margin = eval(0);
        }else{
          jumlah_margin = eval(jumlah_margin);
        }

        total_margin = jumlah_margin;

        angsuran_pokok = (amount/jangka_waktu);

        angsuran_margin = (eval(total_margin)/jangka_waktu);

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

        $("#angsuran_pokok","#form_edit").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_edit").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_edit").val(number_format(total_angsuran,0,',','.'));

        // $("#span_test","#form_edit").html(rate+' | '+amount+' | '+jangka_waktu+' | '+jumlah_margin);
        // $("#span_test2","#form_edit").html(angsuran_pokok+' | '+angsuran_margin+' | '+total_angsuran);
      }

      $("#jumlah_margin","#form_edit").keyup(function(){
        hitung_margin_edit();
      })
      $("#jumlah_margin","#form_edit").change(function(){
        hitung_margin_edit();
      })

      function hitung_total_biaya_edit()
      {
        var biaya_notaris        = convert_numeric($("#biaya_notaris","#form_edit").val());
        var biaya_adm = convert_numeric($("#biaya_adm","#form_edit").val());
        var biaya_asuransi = convert_numeric($("#biaya_asuransi","#form_edit").val());

        if(biaya_notaris==''){
          biaya_notaris = eval(0);
        }else{
          biaya_notaris = eval(biaya_notaris);
        }
        if(biaya_adm==''){
          biaya_adm = eval(0);
        }else{
          biaya_adm = eval(biaya_adm);
        }
        if(biaya_asuransi==''){
          biaya_asuransi = eval(0);
        }else{
          biaya_asuransi = eval(biaya_asuransi);
        }

        total_biaya = (biaya_notaris+biaya_adm+biaya_asuransi)

        $("#total_biaya","#form_edit").val(number_format(total_biaya,0,',','.'));
      }
      $("#biaya_notaris","#form_edit").keyup(function(){
        hitung_total_biaya_edit();
      })
      $("#biaya_notaris","#form_edit").change(function(){
        hitung_total_biaya_edit();
      })
      $("#biaya_adm","#form_edit").keyup(function(){
        hitung_total_biaya_edit();
      })
      $("#biaya_adm","#form_edit").change(function(){
        hitung_total_biaya_edit();
      })
      $("#biaya_asuransi","#form_edit").keyup(function(){
        hitung_total_biaya_edit();
      })
      $("#biaya_asuransi","#form_edit").change(function(){
        hitung_total_biaya_edit();
      })

      function get_date_form_edit_by_akad()
      {
        var tgl_akad = $("#tgl_akad","#form_edit").val();
        var jangka_waktu = $("#jangka_waktu","#form_edit").val();
        $.ajax({
          url: site_url+"rekening_nasabah/get_date_regis_by_tglakad_baru",
          type: "POST",
          dataType: "html",
          async:false,
          data: {
             tgl_akad:tgl_akad
            ,jangka_waktu:jangka_waktu
          },
          success: function(response2)
          {
            res = response2.split("|");
            if (res[0]=="non") {
              $("#div_alert_tgl","#form_edit").html(res[1]);
              $("#tgl_jtempo","#form_edit").val("");
            } else{
              $("#angsuranke1","#form_edit").val(res[0]);
              $("#tgl_jtempo","#form_edit").val(res[1]);
              $("#div_alert_tgl","#form_edit").html("");
            }
          },
          error: function(){
              $("#div_alert_tgl","#form_edit").html("Kesalahan database, harap hubungi IT support");
          }
        })

        var jenis_margin  = $('#product_code option:selected',"#form_edit").attr('jenis_margin');
        var margin  = $('#product_code option:selected', "#form_edit").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_edit").val();
        var amount  = $('#amount', "#form_edit").val();
        var angsuranke1  = $('#angsuranke1', "#form_edit").val();
        var jumlah_margin  = $('#jumlah_margin', "#form_edit").val();
        var product_code  = $('#product_code', "#form_edit").val();
        if(jenis_margin=='2') //margin efektif
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_efektif",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_edit").html(response);
              $("#flag_jadwal_angsuran","#form_edit").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }
        else if (jenis_margin=='3') 
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_anuitas",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
                ,jumlah_margin:jumlah_margin
                ,product_code:product_code
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_edit").html(response);
              $("#flag_jadwal_angsuran","#form_edit").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }

      }

      function get_date_form_edit_by_angs1()
      {
        var angsuranke1 = $("#angsuranke1","#form_edit").val();
        var jangka_waktu = $("#jangka_waktu","#form_edit").val();
        $.ajax({
          url: site_url+"rekening_nasabah/get_date_regis_by_angs1",
          type: "POST",
          dataType: "html",
          async:false,
          data: {
             angsuranke1:angsuranke1
            ,jangka_waktu:jangka_waktu
          },
          success: function(response2)
          {
            res = response2.split("|");
            if (res[0]=="non") {
              $("#div_alert_tgl","#form_edit").html(res[1]);
              $("#tgl_jtempo","#form_edit").val("");
            } else{
              $("#tgl_jtempo","#form_edit").val(res[1]);
              $("#div_alert_tgl","#form_edit").html("");
            }
          },
          error: function(){
              $("#div_alert_tgl","#form_edit").html("Kesalahan database, harap hubungi IT support");
          }
        });

        var jenis_margin  = $('#product_code option:selected',"#form_edit").attr('jenis_margin');
        var margin  = $('#product_code option:selected', "#form_edit").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_edit").val();
        var amount  = $('#amount', "#form_edit").val();
        var angsuranke1  = $('#angsuranke1', "#form_edit").val();
        var jumlah_margin  = $('#jumlah_margin', "#form_edit").val();
        var product_code  = $('#product_code', "#form_edit").val();
        if(jenis_margin=='2') //margin efektif
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_efektif",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_edit").html(response);
              $("#flag_jadwal_angsuran","#form_edit").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }
        else if (jenis_margin=='3') 
        {
          $.ajax({
            url: site_url+"rekening_nasabah/generate_margin_anuitas",
            type: "POST",
            async:false,
            dataType: "html",
            data: {
                 pokok:amount
                ,jangkawaktu:jangka_waktu
                ,margin_tahun:margin
                ,angsuranke1:angsuranke1
                ,jumlah_margin:jumlah_margin
                ,product_code:product_code
              },
            success: function(response)
            {
              $("#span_angsuran_nonreguler","#form_edit").html(response);
              $("#flag_jadwal_angsuran","#form_edit").val('0');
              // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
            },
            error: function(){
              alert("terjadi kesalahan, harap hubungi IT Support");
            }
          })
        }        

      }
      $("#tgl_akad","#form_edit").change(function(){
        get_date_form_edit_by_akad();
      })
      $("#angsuranke1","#form_edit").change(function(){
        get_date_form_edit_by_angs1();
      })
      /*
      ** end function-function Edit
      */
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'pengajuan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  

      // fungsi untuk check all
      jQuery('#pengajuan_pembiayaan_table .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#pengajuan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT REGIS VALIDATION
      var form1 = $('#form_edit');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_regis');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       // event button Regis ketika di tekan
      $("a#link-regis").live('click',function(){  
        success2.hide();
        error2.hide();      
        form2.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit").show();

        $("#biaya_notaris","#form_regis").val('0').prop('0');
        $("#biaya_adm","#form_regis").val('0').prop('0');
        $("#total_biaya","#form_regis").val('0').prop('0');
        $("#biaya_asuransi","#form_regis").val('0').prop('0');

        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
        var registration_no = $(this).attr('registration_no');
        var product_code = $(this).attr('product_code');
        var nik = $(this).attr('nik');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id,nik:nik},
          url: site_url+"rekening_nasabah/get_data_for_akad_by_account_financing_reg_id",
          success: function(response)
          {  
            $('#cif_flag','#form_regis').val(response.cif_flag);
            table_termin = $('#table-termin','#form_regis');
            if (response.cif_flag!=1) {
              $.ajax({
                url: site_url+"rekening_nasabah/get_product_financing_by_band/true",
                type: "POST",
                dataType: "json",
                async:false,
                data: {band:response.band},
                success: function(response)
                {
                  option = '<option value="" maxrate="">PILIH</option>';
                  for (var i = 0; i < response.length; i++) {
                    option +='<option value="'+response[i].product_code+'" maxrate="'+response[i].rate_margin2+'" max_jangka_waktu="'+response[i].max_jangka_waktu+'" jenis_margin="'+response[i].jenis_margin+'">'+response[i].product_name+'</option>';
                  };
                  $("#product_code","#form_regis").html(option);
                }
              })
            } else {
              $.ajax({
                url: site_url+"rekening_nasabah/get_termin_pembiayaan",
                type: "POST",
                dataType: "json",
                async:false,
                data: {account_financing_reg_id:account_financing_reg_id},
                success: function(responsex)
                {
                  var table_body = '';
                  for (i in responsex) {
                    console.log(responsex[i].tgl_rencana_pencairan);
                    table_body += '<tr>';
                    table_body += '<td style="text-align:center;vertical-align:middle;">'+responsex[i].termin+'</td>';
                    table_body += '<td style="text-align:center"><div class="input-prepend input-append"><span class="add-on">Rp</span><input type="text" class="m-wrap mask-money" id="arr_amount" name="arr_amount[]" value="'+number_format(responsex[i].nominal,0,',','.')+'" style="background:#f5f5f5;" disabled><span class="add-on">.00</span></div></td>';
                    table_body += '<td style="text-align:center"><input type="text" class="m-wrap mask_date" id="arr_rencana_droping" name="arr_rencana_droping[]" placeholder="dd/mm/yyyy" style="text-align:center;background:#f5f5f5;" disabled value="'+App.ToDatePicker(responsex[i].tgl_rencana_pencairan)+'"></td>';
                    table_body += '</tr>';
                  }
                  table_termin.find('tbody').html(table_body);
                  console.log(response.jenis_keuntungan)
                  if (response.jenis_keuntungan=='2') { //bagi hasil
                    // $('#nisbah','#form_regis').closest('.control-group').show();
                    // $('#jumlah_margin','#form_regis').closest('.control-group').hide();
                    table_termin.parent().show();
                  } else {
                    // $('#nisbah','#form_regis').closest('.control-group').hide();
                    // $('#jumlah_margin','#form_regis').closest('.control-group').show();
                    table_termin.parent().hide();
                  }
                  if (responsex.length>1) { // termin
                    table_termin.parent().show();
                  } else {
                    table_termin.parent().hide();
                  }
                }
              })
            }
            $("#account_financing_reg_id","#form_regis").val(account_financing_reg_id);
            $("#registration_no","#form_regis").val(registration_no);
            $("#nik","#form_regis").val(response.nik);
            $("#gender","#form_regis").val(response.gender);
            $("#nama","#form_regis").val(response.nama_pegawai);
            $("#band","#form_regis").val(response.band);
            $("#jabatan","#form_regis").val(response.posisi);
            $("#lokasi_kerja","#form_regis").val(response.loker);
            $("#alamat_lokasi_kerja","#form_regis").val(response.alamat_lokasi_kerja);
            $("#tempat_lahir","#form_regis").val(response.tempat_lahir);
            $("#tgl_lahir","#form_regis").val(response.tgl_lahir);
            $("#alamat","#form_regis").val(response.alamat);
            $("#no_ktp","#form_regis").val(response.no_ktp);
            $("#no_telpon","#form_regis").val(response.telpon_seluler);
            $("#nama_pasangan","#form_regis").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_regis").val(response.pekerjaan_pasangan);
            // $("#jumlah_tanggungan","#form_regis").val(response.jumlah_tanggungan);
            // $("#status_rumah","#form_regis").val(response.status_rumah);
            $("#nama_bank","#form_regis").val(response.nama_bank);
            $("#no_rekening","#form_regis").val(response.no_rekening);
            $("#bank_cabang","#form_regis").val(response.bank_cabang);
            $("#atasnama_rekening","#form_regis").val(response.atasnama_rekening);
            $("#thp","#form_regis").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_regis").val(number_format(response.thp_40,0,',','.'));
            $("#jumlah_kewajiban","#form_regis").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_regis").val(number_format(response.jumlah_angsuran,0,',','.'));
            $('#biaya_adm','#form_regis').val(number_format(response.biaya_administrasi,0,',','.'))
            $('#biaya_notaris','#form_regis').val(number_format(response.biaya_notaris,0,',','.'))
            $('#biaya_asuransi','#form_regis').val(number_format(response.biaya_asuransi,0,',','.'))
            $('#total_biaya','#form_regis').val(number_format(parseFloat(response.biaya_asuransi)+parseFloat(response.biaya_notaris)+parseFloat(response.biaya_administrasi),0,',','.'))
            
            if (response.cif_flag==1) {
              $('#amount_proyeksi_keuntungan','#form_regis').val(number_format(response.amount_proyeksi_keuntungan,0,',','.'));
              $('#nisbah','#form_regis').val(response.nisbah);
              // $('#nisbah','#form_regis').closest('.control-group').show();
            } else {
              $('#amount_proyeksi_keuntungan','#form_regis').val('');
              $('#nisbah','#form_regis').val('');
              // $('#nisbah','#form_regis').closest('.control-group').hide();
            }


            if(response.jumlah_angsuran=="0.00"){
              $("#uniform-lunasi_ke_kopegtel","#form_regis").hide();
              $("#span_txt_lunasi","#form_regis").hide();
            }else{
              $("#uniform-lunasi_ke_kopegtel","#form_regis").show();
              $("#span_txt_lunasi","#form_regis").show();              
            }
            if(response.jumlah_kewajiban=="0.00"){
              $("#uniform-lunasi_ke_koptel","#form_regis").hide();
              $("#span_txt_lunasi","#form_regis").hide();
            }else{
              $("#uniform-lunasi_ke_koptel","#form_regis").show();
              $("#span_txt_lunasi","#form_regis").show();              
            }

            if(response.pengajuan_melalui=="koperasi"){
              $("#radio1","#form_regis").show();
              $("#radio2","#form_regis").show();
              $("#div_kopegtel","#form_regis").show();
              $("#kopegtel1","#form_regis").val(response.kopegtel_code).trigger('liszt:updated');              
              $("#melalui2","#form_regis").attr('checked',true);
            }else{
              $("#radio1","#form_regis").show();
              $("#radio2","#form_regis").show();
              $("#melalui1","#form_regis").attr('checked',true);
            }

            $("#product_code,input[name='product_code']","#form_regis").val(response.product_code);
            $("#product_code_post,input[name='product_code_post']","#form_regis").val(response.product_code);
            $("#product_code","#form_regis").trigger('change');
            $("#peruntukan","#form_regis").val(response.peruntukan);
            akad = $("#peruntukan","#form_regis").find('option:selected').attr('akad_value');
            akad_name = $("#peruntukan","#form_regis").find('option:selected').attr('akad_name');

            labeltotalmarginujroh(akad,$('span#label-total-margin','#form_regis'));
            labelpendapatanmarginujroh(akad,$('span#label-pendapatan-margin','#form_regis'));

            if(response.peruntukan==''){
                $("#span_akad","#form_regis").html('');
                $("#val_akad","#form_regis").val('');
            }else{
              if (response.cif_flag==0) { //by pegawai
                $("#span_akad","#form_regis").html(akad_name);
                $("#val_akad","#form_regis").val(akad);
              } else { // by kopegtel
                $("#span_akad","#form_regis").html(response.akad_name);
                $("#val_akad","#form_regis").val(response.akad_code);
              }
            }
            if (response.cif_flag==1) {
              response.amount=response.amount_disetujui;
            } else {
              response.amount=response.amount;
            }
            $("#amount","#form_regis").val(number_format(response.amount,0,',','.'));
            $("#jangka_waktu","#form_regis").val(response.jangka_waktu);

            explode = response.tanggal_pengajuan.split('-');
            var tgl_pengajuan =  explode[2]+'/'+explode[1]+'/'+explode[0];
            $("#mask_date","#form_regis").val(tgl_pengajuan);
            
            if (response.cif_flag==0) { // by pegawai
              if(response.tgl_pensiun_normal){
                explode2 = response.tgl_pensiun_normal.split('-');
                var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
                $("#show_masa_pensiun","#form_regis").val(show_pensiun);
                $("#masa_pensiun","#form_regis").val(response.tgl_pensiun_normal);
              }
            } else { // by kopegtel
              var show_pensiun = '';
              $("#show_masa_pensiun","#form_regis").val(show_pensiun);
              $("#masa_pensiun","#form_regis").val('');
            }


            $("#min_margin","#form_regis").val(response.min_margin);
            $("#max_margin","#form_regis").val(response.max_margin);

            $("#jumlah_kewajiban","#form_regis").trigger('keyup');

            if(response.lunasi_ke_kopegtel=="1"){
              $("#lunasi_ke_kopegtel","#form_regis").parent().addClass('checked');
              $("#lunasi_ke_kopegtel","#form_regis").attr('checked',true);
              $("#lunasi_ke_kopegtel","#form_regis").prop('checked',true);
              $("#saldo_kewajiban","#form_regis").val(number_format(response.saldo_kewajiban,0,',','.'));
              $("#saldo_kewajiban","#form_regis").prop(number_format(response.saldo_kewajiban,0,',','.'));
              $("#div_saldo_kewajiban","#form_regis").show();
              $("#span_txt_lunasi","#form_regis").show();
              $("#pelunasan_ke_kopeg_mana2","#form_regis").val(response.pelunasan_ke_kopeg_mana);
              $("#pelunasan_ke_kopeg_mana2","#form_regis").trigger('liszt:updated');
            }else{
              $("#lunasi_ke_kopegtel","#form_regis").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_regis").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_regis").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban","#form_regis").hide();
              $("#saldo_kewajiban","#form_regis").val('0').prop('0');
              $("#span_txt_lunasi","#form_regis").hide();
            }

            // if(response.lunasi_ke_koptel=="1"){
            //   $("#lunasi_ke_koptel","#form_regis").parent().addClass('checked');
            //   $("#lunasi_ke_koptel","#form_regis").attr('checked',true);
            //   $("#lunasi_ke_koptel","#form_regis").prop('checked',true);
              $("#saldo_kewajiban_ke_koptel","#form_regis").val(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#saldo_kewajiban_ke_koptel","#form_regis").prop(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));

              console.log(response.saldo_kewajiban_ke_koptel)
            //   $("#div_saldo_kewajiban_ke_koptel","#form_regis").show();
            //   $("#span_txt_lunasi_ke_koptel","#form_regis").show();
              
            // }else{
            //   $("#lunasi_ke_koptel","#form_regis").parent().removeClass('checked'); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_regis").attr('checked',false); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_regis").prop('checked',false); //menghilangkan checklist
            //   $("#div_saldo_kewajiban_ke_koptel","#form_regis").hide();
              // $("#saldo_kewajiban_ke_koptel","#form_regis").val('0').prop('0');
            //   $("#span_txt_lunasi_ke_koptel","#form_regis").hide();
            // }

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_list_saldo",
               dataType: "json",
               data: {nik:response.nik},
               success: function(response3){
                  html = '';
                  for(i = 0 ; i < response3.length ; i++){
                    html += ' \
                          <tr>\
                            <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="0">\
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no" value="'+response3[i].account_financing_no+'">\
                    ';
                    if(response3[i].is_checked!='0'){
                      html += ' \
                                  <input type="checkbox" name="check_saldo[]" id="check_saldo" checked disabled="">\
                      ';
                    }else{
                      html += ' \
                                  <input type="checkbox" name="check_saldo[]" id="check_saldo" disabled="">\
                      ';
                    }
                    html += ' \
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_pokok[]" value="'+response3[i].saldo_pokok+'">'+number_format(response3[i].saldo_pokok,0,',','.')+'\
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_margin[]" value="'+response3[i].saldo_margin+'">'+number_format(response3[i].saldo_margin,0,',','.')+'\
                            </td>\
                          </tr>\
                    ';
                  }
                  $("#list_saldo_pokok tbody","#form_regis").html(html);
               }
            });
            
            $.ajax({
              url: site_url+"rekening_nasabah/get_account_saving_by_cif",
              type: "POST",
              dataType: "html",
              async:false,
              data: {nik:response.nik},
              success: function(response2)
              {
                if (response2==0) {
                  $("#account_saving_no","#form_regis").val('n');
                } else{
                  $("#account_saving_no","#form_regis").val(response2);
                };
              }
            })

            // get_total_margin_dan_angsuran_anuitas_formregis();
            // $("#product_code","#form_regis").trigger('change');
            if (response.cif_flag==0) {
              hitung_margin_form_regis();
              $('#schedulle','#form_regis').hide();
              table_termin.parent().hide();
            } else {
              hitung_margin_form_regis();
              total_margin = response.total_margin;
              $("#jumlah_margin","#form_regis").val(number_format(total_margin,0,',','.'));
              $('#div_angsuran_pokok','#form_regis').hide();
              $('#div_angsuran_margin','#form_regis').hide();
              $('#div_angsuran_rate_margin','#form_regis').hide();
              $('#div_total_angsuran','#form_regis').hide();
              // table schedulle di munculkan
              $('#schedulle','#form_regis').show();
              $("#flag_jadwal_angsuran","#form_regis").val('0');
              html = ' \
              <tr> \
                <td style="text-align:center;"><input type="text" id="tgl_angsur" name="tgl_angsur[]" class="m-wrap medium mask_date date-picker" placeholder="dd/mm/yyyy" style="background:#fff;text-align:center"></td> \
                <td style="text-align:center;"><input type="text" id="angs_pokok" name="angs_pokok[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                <td style="text-align:center;"><input type="text" id="angs_margin" name="angs_margin[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                <td style="text-align:center;"> \
                  <button class="btn green" id="insert"><i class="icon-plus"></i></button> \
                  <button class="btn red" id="remove"><i class="icon-remove"></i></button> \
                </td> \
              </tr> \
              ';
              $('#table-schedulle tbody','#form_regis').html(html);
            }

             /*
            | PENAMBAHAN DATA PENJUAL UNTUK PRODUK KPR
            | ADDENDUM BY UI
            | 24 JULI 2015
            */
            if(response.product_code==56){
              if(response.tipe_developer==0){
                $("#tipe_developer","#form_regis").val(response.tipe_developer);
                $("#nama_penjual_individu","#form_regis").val(response.nama_penjual_individu);
                $("#nomer_ktp","#form_regis").val(response.nomer_ktp);
                $("#nama_pasangan_developer","#form_regis").val(response.nama_pasangan_developer);
                $("#nama_perusahaan","#form_regis").val('');
                $("#div_tipe_developer","#form_regis").show();
                $("#div_individu","#form_regis").show();
                $("#div_perusahaan","#form_regis").hide();
              }else if(response.tipe_developer==1){
                $("#tipe_developer","#form_regis").val(response.tipe_developer);
                $("#nama_penjual_individu","#form_regis").val('');
                $("#nomer_ktp","#form_regis").val('');
                $("#nama_pasangan_developer","#form_regis").val('');
                $("#nama_perusahaan","#form_regis").val(response.nama_perusahaan);
                $("#div_tipe_developer","#form_regis").show();
                $("#div_individu","#form_regis").hide();
                $("#div_perusahaan","#form_regis").show();
              }
            }else{
                $("#div_tipe_developer","#form_regis").hide();
                $("#div_individu","#form_regis").hide();
                $("#div_perusahaan","#form_regis").hide();
            }
            /*END*/

            /*
            |BEGIN
            |CONDITION OF CIF_FLAG
            |0=by pegawai, 1=by kopegtel
            */
            if (response.cif_flag=='0') {
              $('hr[data-cifflag=1]','#form_regis').show();
              $('div[data-cifflag=1]','#form_regis').show();

              $('#thp','#form_regis').closest('.control-group').show();
              $('#thp_40','#form_regis').closest('.control-group').show();
              $('#jumlah_kewajiban','#form_regis').closest('.control-group').show();
              $('#lunasi_ke_kopegtel','#form_regis').closest('.control-group').show();
              $('#tipe_angsuran','#form_regis').val('reguler');

              $('#control_tipe_angsuran','#form_regis').hide();

            } else {
              $('hr[data-cifflag=1]','#form_regis').hide();
              $('div[data-cifflag=1]','#form_regis').hide();

              $('#thp','#form_regis').closest('.control-group').hide();
              $('#thp_40','#form_regis').closest('.control-group').hide();
              $('#jumlah_kewajiban','#form_regis').closest('.control-group').hide();
              $('#lunasi_ke_kopegtel','#form_regis').closest('.control-group').hide();
              v_regis_jenis_keuntungan = response.jenis_keuntungan;
              if (response.jenis_keuntungan=='2') { //bagi hasil
                $('#amount_proyeksi_keuntungan','#form_regis').closest('.control-group').show();
                $('#nisbah','#form_regis').closest('.control-group').show();
                $('#jumlah_margin','#form_regis').closest('.control-group').hide();
              } else {
                $('#amount_proyeksi_keuntungan','#form_regis').closest('.control-group').hide();
                $('#nisbah','#form_regis').closest('.control-group').hide();
                $('#jumlah_margin','#form_regis').closest('.control-group').show();
              }

              $('#tipe_angsuran','#form_regis').val('nonreguler');

              $('#control_tipe_angsuran','#form_regis').show();
            }


            /*END*/

          }
        });

      });
      
      $('#tipe_angsuran','#form_regis').change(function(){
        var product_code = $("#product_code_post",'#form_regis').val();
        if ($(this).val()=='reguler') {
          $('#flag_jadwal_angsuran','#form_regis').val('1');
          $('#div_angsuran_pokok','#form_regis').show();
          $('#div_angsuran_margin','#form_regis').show();
          $('#div_angsuran_rate_margin','#form_regis').show();
          $('#div_total_angsuran','#form_regis').show();
          $('#schedulle','#form_regis').hide();

        } else if ($(this).val()=='nonreguler') {
          $('#flag_jadwal_angsuran','#form_regis').val('0');
          $('#div_angsuran_pokok','#form_regis').hide();
          $('#div_angsuran_margin','#form_regis').hide();
          $('#div_angsuran_rate_margin','#form_regis').hide();
          $('#div_total_angsuran','#form_regis').hide();
          if(product_code=='56' || product_code=='54'){ // KPR & KMG schedulle dihide
            $('#schedulle','#form_regis').hide();
            $('#control_tipe_angsuran','#form_regis').hide();
          }else{
            $('#schedulle','#form_regis').show();
            $('#control_tipe_angsuran','#form_regis').show();
          }
        } else {
          $('#flag_jadwal_angsuran','#form_regis').val('1');
          $('#div_angsuran_pokok','#form_regis').show();
          $('#div_angsuran_margin','#form_regis').show();
          $('#div_angsuran_rate_margin','#form_regis').show();
          $('#div_total_angsuran','#form_regis').show();
          $('#schedulle','#form_regis').hide();
        }
      })
      
      $('#tipe_angsuran','#form_edit').change(function(){
        var product_code = $("#product_code_post",'#form_edit').val();
        if ($(this).val()=='reguler') {
          $('#flag_jadwal_angsuran','#form_edit').val('1');
          $('#div_angsuran_pokok','#form_edit').show();
          $('#div_angsuran_margin','#form_edit').show();
          $('#div_angsuran_rate_margin','#form_edit').show();
          $('#div_total_angsuran','#form_edit').show();
          $('#schedulle','#form_edit').hide();

        } else if ($(this).val()=='nonreguler') {
          $('#flag_jadwal_angsuran','#form_edit').val('0');
          $('#div_angsuran_pokok','#form_edit').hide();
          $('#div_angsuran_margin','#form_edit').hide();
          $('#div_angsuran_rate_margin','#form_edit').hide();
          $('#div_total_angsuran','#form_edit').hide();
          if(product_code=='56' || product_code=='54'){ // KPR & KMG schedulle dihide
            $('#schedulle','#form_edit').hide();
            $('#control_tipe_angsuran','#form_edit').hide();
          }else{
            $('#schedulle','#form_edit').show();
            $('#control_tipe_angsuran','#form_edit').show();
          }
        } else {
          $('#flag_jadwal_angsuran','#form_edit').val('1');
          $('#div_angsuran_pokok','#form_edit').show();
          $('#div_angsuran_margin','#form_edit').show();
          $('#div_angsuran_rate_margin','#form_edit').show();
          $('#div_total_angsuran','#form_edit').show();
          $('#schedulle','#form_edit').hide();
        }
      })

      // event for schedulle table
      var calculate_total_angsuran_regis = function() {
        total_angsuran_pokok = 0;
        total_angsuran_margin = 0;
        $('#table-schedulle tbody tr','#form_regis').each(function(){
          total_angsuran_pokok += parseFloat(convert_numeric($(this).find('#angs_pokok').val()));
          total_angsuran_margin += parseFloat(convert_numeric($(this).find('#angs_margin').val()));
        })
        $('#table-schedulle #txtTotalAngsuranPokok','#form_regis').val(number_format(total_angsuran_pokok,0,',','.'));
        $('#table-schedulle #txtTotalAngsuranMargin','#form_regis').val(number_format(total_angsuran_margin,0,',','.'));
      }

      $('#table-schedulle button#insert','#form_regis').live('click',function(e){
        e.preventDefault();
        trn = '<tr>';
        trn += '<td style="text-align:center;"><input type="text" id="tgl_angsur" name="tgl_angsur[]" class="m-wrap medium mask_date date-picker" placeholder="dd/mm/yyyy"  style="background:#fff;text-align:center;"></td>';
        trn += '<td style="text-align:center;"><input type="text" id="angs_pokok" name="angs_pokok[]" class="mask-money m-wrap medium" value="0" style="background:#fff;"></td>';
        trn += '<td style="text-align:center;"><input type="text" id="angs_margin" name="angs_margin[]" class="mask-money m-wrap medium" value="0" style="background:#fff;"></td>';
        trn += '<td style="text-align:center;">';
        trn += '<button class="btn green" id="insert"><i class="icon-plus"></i></button> ';
        trn += '<button class="btn red" id="remove"><i class="icon-remove"></i></button>';
        trn += '</td>';
        trn += '</tr>';
        $('#table-schedulle tbody','#form_regis').append(trn);
      })

      $('#table-schedulle button#remove','#form_regis').livequery('click',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        calculate_total_angsuran_regis();
      })

      $('#table-schedulle input#angs_pokok,#table-schedulle input#angs_margin','#form_regis').livequery('keyup',function(){
        calculate_total_angsuran_regis();
        amount = parseFloat(convert_numeric($('#amount','#form_regis').val()));
        jumlah_margin = parseFloat(convert_numeric($('#jumlah_margin','#form_regis').val()));
        TotalAngsuranPokok = parseFloat(convert_numeric($('#txtTotalAngsuranPokok','#form_regis').val()));
        TotalAngsuranMargin = parseFloat(convert_numeric($('#txtTotalAngsuranMargin','#form_regis').val()));
        bValid=true;
        jenis_keuntungan = v_regis_jenis_keuntungan;
        msg = '';
        if (TotalAngsuranPokok>amount) {
          bValid=false;
          msg += '- Total Angsuran Pokok melebihi Jumlah Pembiayaan.<br>';
        }
        // if (jenis_keuntungan!=2) {
        //   if (TotalAngsuranMargin>jumlah_margin) {
        //     bValid=false;
        //     akad = $("#val_akad","#form_regis").val();
        //     if (akad=='IJR') {
        //       marginujroh = 'Ujroh';
        //     } else {
        //       marginujroh = 'Margin';
        //     }
        //     msg += '- Total Angsuran '+marginujroh+' melebihi Total '+marginujroh+'.';
        //   }
        // }
        if (bValid==false) {
          App.WarningAlert(msg);
        }
      })

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_regis").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
        App.scrollTo($("#wrapper-table"),-200);
      });

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_financing_reg_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_reg_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_reg_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/delete_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      $("#act_regis").click(function()
      {
        bValid=true;
        var margin      = eval(convert_numeric($("#jumlah_margin","#form_regis").val()));
        var min_margin  = eval(convert_numeric($("#min_margin","#form_regis").val()));
        var max_margin  = eval(convert_numeric($("#max_margin","#form_regis").val()));
        var cif_flag = $('#cif_flag','#form_regis').val();
        // alert(margin+"|"+min_margin+"|"+max_margin);
        // die;

        if($("#tgl_akad","#form_regis").val()==""){
          $("#tgl_akad","#form_regis").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#tgl_akad","#form_regis").removeClass('pink');
        }
        if($("#angsuranke1","#form_regis").val()==""){
          $("#angsuranke1","#form_regis").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#angsuranke1","#form_regis").removeClass('pink');
        }
        if($("#tgl_jtempo","#form_regis").val()==""){
          $("#tgl_jtempo","#form_regis").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#tgl_jtempo","#form_regis").removeClass('pink');
        }
        if (cif_flag!=1) {
          if(max_margin-margin<-100000000){
            message = "Batas Maksimal Margin Adalah Rp. "+number_format(max_margin,0,',','.');
            bValid=false;
            $("#jumlah_margin","#form_regis").addClass("pink");
          }else{
            $("#jumlah_margin","#form_regis").removeClass("pink");
          }
          if(margin-min_margin<-1000000000){          
            message = "Batas Minimal Margin Adalah Rp. "+number_format(min_margin,0,',','.');
            bValid=false;
            $("#jumlah_margin","#form_regis").addClass("pink");
          }else{
            $("#jumlah_margin","#form_regis").removeClass("pink");
          }
          if(max_margin-margin<-10000000 || margin-min_margin<-5){
            $("#jumlah_margin","#form_regis").addClass("pink");
          }
        }
        
        var tgl_jtempo =   $("#tgl_jtempo","#form_regis").val();
        var masa_pensiun =   $("#masa_pensiun","#form_regis").val();
        // $.ajax({
        //   url: site_url+"rekening_nasabah/compare_masa_pensiun",
        //   type: "POST",
        //   async:false,
        //   dataType: "html",
        //   data: {tgl_jtempo:tgl_jtempo,masa_pensiun:masa_pensiun},
        //   success: function(response)
        //   {
        //     if(response=="false"){
        //       bValid = false;
        //       message = "Jatuh Tempo Angsuran Melebihi Masa Pensiun ( "+$("#show_masa_pensiun","#form_regis").val()+" )";
        //     }
        //   },
        //   error: function(){
        //     bValid = false;
        //     message = "Error. Please Contact Your Administrator";
        //   }
        // })
        
        calculate_total_angsuran_regis();
        amount = parseFloat(convert_numeric($('#amount','#form_regis').val()));
        jumlah_margin = parseFloat(convert_numeric($('#jumlah_margin','#form_regis').val()));
        TotalAngsuranPokok = parseFloat(convert_numeric($('#txtTotalAngsuranPokok','#form_regis').val()));
        TotalAngsuranMargin = parseFloat(convert_numeric($('#txtTotalAngsuranMargin','#form_regis').val()));
        jenis_keuntungan = v_regis_jenis_keuntungan;
        if($("#tipe_angsuran",'#form_regis').val()=='nonreguler'){ //agar tidak keriting
          if (cif_flag=='1') { // banmod
            if (TotalAngsuranPokok>amount) {
              bValid=false;
              App.WarningAlert('Total Angsuran Pokok melebihi Jumlah Pembiayaan!');
              message = 'Total Angsuran Pokok melebihi Jumlah Pembiayaan!'
            } else if (TotalAngsuranPokok<amount) {
              bValid=false;
              App.WarningAlert('Total Angsuran Pokok tidak sama dengan Jumlah Pembiayaan!');
              message = 'Total Angsuran Pokok tidak sama dengan Jumlah Pembiayaan!'
            }
          }
        }
        // if (jenis_keuntungan!=2) {
        //   if (TotalAngsuranMargin>jumlah_margin) {
        //     bValid=false;
        //     akad = $("#val_akad","#form_regis").val();
        //     if (akad=='IJR') {
        //       marginujroh = 'Ujroh';
        //     } else {
        //       marginujroh = 'Margin';
        //     }
        //     msg += '- Total Angsuran '+marginujroh+' melebihi Total '+marginujroh+'.';
        //   }
        // }

        if(bValid==true){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/proses_registrasi_akad_pembiayaan",
            dataType: "json",
            data: form2.serialize(),
            success: function(response){
              if(response.success==true){
                App.SuccessAlert(response.message,function(){
                  location.reload();
                });
              }else{
                App.WarningAlert(response.message);
              }
              App.scrollTo(form2, -200);
            },
            error:function(){
                App.WarningAlert('Failed to connect into databases, Please contact your administrator!');
                // success2.hide();
                // error2.show();
                App.scrollTo(form2, -200);
            }
          });
        }else{
          success2.hide();
          error2.show();
          App.scrollTo(form2, -200);          
          $("#span_message","#form_regis").html(message);
        }

      });


      $("#act_reject").click(function(){
        bValid=true;

        var registration_no  = $("#registration_no","#form_regis").val();

        var conf = confirm('Reject Pengajuan Akad ?');
        if(conf){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/act_reject_reg_akad",
            dataType: "json",
            data: {
               registration_no:registration_no
            },
            success: function(response){
              if(response.success==true){
                $("#edit").hide();
                $("#wrapper-table").show();
                dTreload();
                App.scrollTo($("#wrapper-table"),-200);
              }else{
                App.WarningAlert('Failed to connect into databases, Please contact your administrator!');
              }
            },
            error: function(){
                App.WarningAlert('Failed to connect into databases, Please contact your administrator!');
                // success2.hide();
                // error2.show();
                App.scrollTo(form2, -200);
            }
          })
        }   

      });

      $("#act_reject_edit").click(function(){
        bValid=true;

        var account_financing_id  = $("#account_financing_id","#edit_regis").val();
        var account_financing_reg_id  = $("#account_financing_reg_id","#edit_regis").val();

        var conf = confirm('Reject Pengajuan Akad ?');
        if(conf){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/act_reject_reg_akad_edit",
            dataType: "json",
            data: {
               account_financing_id:account_financing_id
               ,account_financing_reg_id:account_financing_reg_id
            },
            success: function(response){
              if(response.success==true){
                $("#edit_regis").hide();
                $("#wrapper-table").show();
                dTreload();
                App.scrollTo($("#wrapper-table"),-200);
              }else{
                App.WarningAlert('Failed to connect into databases, Please contact your administrator!');
              }
            },
            error: function(){
                App.WarningAlert('Failed to connect into databases, Please contact your administrator!');
                // success2.hide();
                // error2.show();
                App.scrollTo(form2, -200);
            }
          })
        }   

      });

       // event button Regis ketika di tekan
      $("a#link-edit").live('click',function(){       
        success1.hide();
        error1.hide(); 
        form1.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit_regis").show();
        $("#biaya_notaris","#form_edit").val('0').prop('0');
        $("#biaya_adm","#form_edit").val('0').prop('0');
        $("#biaya_asuransi","#form_edit").val('0').prop('0');
        $("#total_biaya","#form_edit").val('0').prop('0');

        var account_financing_no = $(this).attr('account_financing_no');
        var product_code = $(this).attr('product_code');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"rekening_nasabah/get_data_for_akad_by_account_financing_no",
          success: function(response)
          {
              
            v_edit_jenis_keuntungan = response.jenis_keuntungan;
            $('#cif_flag','#form_edit').val(response.cif_flag);
            table_termin = $('#table-termin','#form_edit');
            if (response.cif_flag!=1) {
              $.ajax({
                url: site_url+"rekening_nasabah/get_product_financing_by_band",
                type: "POST",
                dataType: "json",
                async:false,
                data: {band:response.band},
                success: function(response)
                {
                  option = '<option value="" maxrate="">PILIH</option>';
                  for (var i = 0; i < response.length; i++) {
                    option +='<option value="'+response[i].product_code+'" maxrate="'+response[i].rate_margin2+'" max_jangka_waktu="'+response[i].max_jangka_waktu+'" jenis_margin="'+response[i].jenis_margin+'">'+response[i].product_name+'</option>';
                  };
                  $("#product_code","#form_edit").html(option);
                }
              });
            } else {
              $.ajax({
                url: site_url+"rekening_nasabah/get_termin_pembiayaan",
                type: "POST",
                dataType: "json",
                async:false,
                data: {account_financing_reg_id:response.account_financing_reg_id},
                success: function(response)
                {
                  var table_body = '';
                  for (i in response) {
                    console.log(response[i].tgl_rencana_pencairan);
                    table_body += '<tr>';
                    table_body += '<td style="text-align:center;vertical-align:middle;">'+response[i].termin+'</td>';
                    table_body += '<td style="text-align:center"><div class="input-prepend input-append"><span class="add-on">Rp</span><input type="text" class="m-wrap mask-money" id="arr_amount" name="arr_amount[]" value="'+number_format(response[i].nominal,0,',','.')+'" style="background:#f5f5f5;" disabled><span class="add-on">.00</span></div></td>';
                    table_body += '<td style="text-align:center"><input type="text" class="m-wrap mask_date" id="arr_rencana_droping" name="arr_rencana_droping[]" placeholder="dd/mm/yyyy" style="text-align:center;background:#f5f5f5;" disabled value="'+App.ToDatePicker(response[i].tgl_rencana_pencairan)+'"></td>';
                    table_body += '</tr>';
                  }
                  table_termin.find('tbody').html(table_body);
                  if (v_edit_jenis_keuntungan=='2') { //bagi hasil
                    $('#nisbah','#form_edit').closest('.control-group').show();
                    $('#amount_proyeksi_keuntungan','#form_edit').closest('.control-group').show();
                    $('#jumlah_margin','#form_edit').closest('.control-group').hide();
                    table_termin.parent().show();
                  } else {
                    $('#nisbah','#form_edit').closest('.control-group').hide();
                    $('#amount_proyeksi_keuntungan','#form_edit').closest('.control-group').hide();
                    $('#jumlah_margin','#form_edit').closest('.control-group').show();
                    table_termin.parent().hide();
                  }
                  if (response.length>1) { // termin
                    table_termin.parent().show();
                  } else {
                    table_termin.parent().hide();
                  }
                }
              })
            }
              
            $("#account_financing_id","#form_edit").val(response.account_financing_id);
            $("#account_financing_reg_id","#form_edit").val(response.account_financing_reg_id);
            $("#nik","#form_edit").val(response.nik);
            $("#gender","#form_edit").val(response.gender);
            $("#nama","#form_edit").val(response.nama_pegawai);
            $("#band","#form_edit").val(response.band);
            $("#jabatan","#form_edit").val(response.posisi);
            $("#lokasi_kerja","#form_edit").val(response.loker);
            $("#alamat_lokasi_kerja","#form_edit").val(response.alamat_lokasi_kerja);
            $("#tempat_lahir","#form_edit").val(response.tempat_lahir);
            $("#tgl_lahir","#form_edit").val(response.tgl_lahir);
            $("#alamat","#form_edit").val(response.alamat);
            $("#no_ktp","#form_edit").val(response.no_ktp);
            $("#no_telpon","#form_edit").val(response.telpon_seluler);
            $("#nama_pasangan","#form_edit").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_edit").val(response.pekerjaan_pasangan);
            // $("#jumlah_tanggungan","#form_edit").val(response.jumlah_tanggungan);
            // $("#status_rumah","#form_edit").val(response.status_rumah);
            $("#nama_bank","#form_edit").val(response.nama_bank);
            $("#no_rekening","#form_edit").val(response.no_rekening);
            $("#bank_cabang","#form_edit").val(response.bank_cabang);
            $("#atasnama_rekening","#form_edit").val(response.atasnama_rekening);
            $("#thp","#form_edit").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_edit").val(number_format(response.thp_40,0,',','.'));

            $("#jumlah_kewajiban","#form_edit").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_edit").val(number_format(response.jumlah_angsuran,0,',','.'));

            if (response.cif_flag==1) {
              $('#nisbah','#form_edit').closest('.control-group').show();
              $('#nisbah','#form_edit').val(response.nisbah);
              $('#amount_proyeksi_keuntungan','#form_edit').val(number_format(response.amount_proyeksi_keuntungan,0,',','.'));
            } else {
              $('#nisbah','#form_edit').closest('.control-group').hide();
              $('#nisbah','#form_edit').val('');
              $('#amount_proyeksi_keuntungan','#form_edit').val('');
            }

            if(response.lunasi_ke_kopegtel=="1"){
              $("#lunasi_ke_kopegtel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',true);
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',true);
              // alert(response.saldo_kewajiban)
              console.log(response.saldo_kewajiban)
              $("#saldo_kewajiban","#form_edit").val(response.saldo_kewajiban);
              $("#saldo_kewajiban","#form_edit").prop(response.saldo_kewajiban);
              $("#div_saldo_kewajiban","#form_edit").show();
              $("#span_txt_lunasi","#form_edit").show();
              $("#uniform-lunasi_ke_kopegtel","#form_edit").show();
              $("#pelunasan_ke_kopeg_mana","#form_edit").val(response.pelunasan_ke_kopeg_mana);
              $("#pelunasan_ke_kopeg_mana","#form_edit").trigger('liszt:updated');
            }else{
              $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban","#form_edit").hide();
              $("#saldo_kewajiban","#form_edit").val('0').prop('0');
              $("#span_txt_lunasi","#form_edit").hide();
              $("#uniform-lunasi_ke_kopegtel","#form_edit").hide();
            }

            // if(response.lunasi_ke_koptel=="1"){
            //   $("#lunasi_ke_koptel","#form_edit").parent().addClass('checked');
            //   $("#lunasi_ke_koptel","#form_edit").attr('checked',true);
            //   $("#lunasi_ke_koptel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#saldo_kewajiban_ke_koptel","#form_edit").prop(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
            //   $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
            //   $("#span_txt_lunasi_ke_koptel","#form_edit").show();
            //   $("#uniform-lunasi_ke_koptel","#form_edit").show();
              
            // }else{
            //   $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_edit").attr('checked',false); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_edit").prop('checked',false); //menghilangkan checklist
            //   $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
              // $("#saldo_kewajiban_ke_koptel","#form_edit").val('0').prop('0');
            //   $("#span_txt_lunasi_ke_koptel","#form_edit").hide();
            //   $("#uniform-lunasi_ke_koptel","#form_edit").hide();
            // }

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_list_saldo_lunas",
               dataType: "json",
               data: {cif_no:response.cif_no},
               success: function(response3){
                  html = '';
                  for(i = 0 ; i < response3.length ; i++){
                    html += ' \
                          <tr>\
                            <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="account_financing_no_arr[]" id="account_financing_no_arr" value="'+response3[i].account_financing_no+'">\
                                <input type="hidden" name="no_pembiayaan" id="no_pembiayaan" value="'+response3[i].account_financing_no+'">\
                    ';
                    if(response3[i].is_checked!='0'){
                      html += ' \
                                  <input type="checkbox" name="check_saldo[]" id="check_saldo" checked="checked" disabled="">\
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="1">\
                      ';
                    }else{
                      html += ' \
                                  <input type="checkbox" name="check_saldo[]" id="check_saldo" disabled="">\
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="0">\
                      ';
                    }
                    html += ' \
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_pokok[]" value="'+response3[i].saldo_pokok+'">'+number_format(response3[i].saldo_pokok,0,',','.')+'\
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_margin[]" value="'+response3[i].saldo_margin+'">'+number_format(response3[i].saldo_margin,0,',','.')+'\
                            </td>\
                          </tr>\
                    ';
                  }
                  $("#list_saldo_pokok tbody","#form_edit").html(html);
               }
            });

            if(response.pengajuan_melalui=="koperasi"){
              $("#radio1","#form_edit").show();
              $("#radio2","#form_edit").show();
              $("#div_kopegtel","#form_edit").show();
              $("#kopegtel","#form_edit").val(response.kopegtel_code).trigger('liszt:updated');              
              $("#melalui2","#form_edit").attr('checked',true);
            }else{
              $("#radio1","#form_edit").show();
              $("#radio2","#form_edit").show();
              $("#melalui1","#form_edit").attr('checked',true);
            }

            $("#product_code,input[name='product_code']","#form_edit").val(response.product_code);
            $("#product_code_post,input[name='product_code_post']","#form_edit").val(response.product_code);
            $("#peruntukan","#form_edit").val(response.peruntukan);
            // console.log(response.peruntukan);
            akad = $("#peruntukan","#form_edit").find('option:selected').attr('akad_value');
            akad_name = $("#peruntukan","#form_edit").find('option:selected').attr('akad_name');

            labeltotalmarginujroh(akad,$('span#label-total-margin','#form_edit'));
            labelpendapatanmarginujroh(akad,$('span#label-pendapatan-margin','#form_edit'));

            if(response.peruntukan==''){
                $("#span_akad","#form_edit").html('');
                $("#val_akad","#form_edit").val('');
            }else{
              if (response.cif_flag==0) { //by pegawai
                $("#span_akad","#form_edit").html(akad_name);
                $("#val_akad","#form_edit").val(akad);
              } else { // by kopegtel
                $("#span_akad","#form_edit").html(response.akad_name);
                $("#val_akad","#form_edit").val(response.akad_code);
              }
            }

            if (response.cif_flag==1) {
              response.amount=response.amount_disetujui;
            } else {
              response.amount=response.amount;
            }
            $("#amount","#form_edit").val(number_format(response.amount,0,',','.'));
            $("#jangka_waktu","#form_edit").val(response.jangka_waktu);

            explode = response.tanggal_pengajuan.split('-');
            var tgl_pengajuan =  explode[2]+'/'+explode[1]+'/'+explode[0];
            $("#mask_date","#form_edit").val(tgl_pengajuan);

            // explode2 = response.tgl_pensiun_normal.split('-');
            // var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
            // $("#show_masa_pensiun","#form_edit").val(show_pensiun);

            if (response.cif_flag==0) { // by pegawai
              explode2 = response.tgl_pensiun_normal.split('-');
              var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
              $("#show_masa_pensiun","#form_edit").val(show_pensiun);
              $("#masa_pensiun","#form_edit").val(response.tgl_pensiun_normal);
            } else { // by kopegtel
              var show_pensiun = '';
              $("#show_masa_pensiun","#form_edit").val(show_pensiun);
              $("#masa_pensiun","#form_edit").val('');
            }

            // $("#masa_pensiun","#form_edit").val(response.tgl_pensiun_normal);
            $("#min_margin","#form_edit").val(response.min_margin);
            $("#max_margin","#form_edit").val(response.max_margin);

            $("#biaya_notaris","#form_edit").val(number_format(response.biaya_notaris,0,',','.')).prop(number_format(response.biaya_notaris,0,',','.'));
            $("#biaya_adm","#form_edit").val(number_format(response.biaya_administrasi,0,',','.')).prop(number_format(response.biaya_administrasi,0,',','.'));
            $("#biaya_asuransi","#form_edit").val(number_format(response.biaya_asuransi_jiwa,0,',','.')).prop(number_format(response.biaya_asuransi_jiwa,0,',','.'));
            hitung_total_biaya_edit();
            $("#jumlah_margin","#form_edit").val(number_format(response.margin,0,',','.')).prop(number_format(response.margin,0,',','.'));
            $("#angsuran_pokok","#form_edit").val(number_format(response.angsuran_pokok,0,',','.')).prop(number_format(response.angsuran_pokok,0,',','.'));
            $("#angsuran_margin","#form_edit").val(number_format(response.angsuran_margin,0,',','.')).prop(number_format(response.angsuran_margin,0,',','.'));
            // hitung_margin_edit();
            $("#angsuran_pokok","#form_edit").trigger('keyup');

            exp1 = response.tanggal_akad.split('-');
            var tgl_akad =  exp1[2]+'/'+exp1[1]+'/'+exp1[0];
            $("#tgl_akad","#form_edit").val(tgl_akad);

            exp2 = response.tanggal_mulai_angsur.split('-');
            var tgl_mulai_angsur =  exp2[2]+'/'+exp2[1]+'/'+exp2[0];
            $("#angsuranke1","#form_edit").val(tgl_mulai_angsur);

            expl3 = response.tanggal_jtempo.split('-');
            var tgl_jtempo =  expl3[2]+'/'+expl3[1]+'/'+expl3[0];
            $("#tgl_jtempo","#form_edit").val(tgl_jtempo);

            $("#product_code","#form_edit").trigger('change');
            generate_angsuran_nonreguler();
            $("#account_financing_no","#form_edit").val(account_financing_no);

            /*
            | PENAMBAHAN DATA PENJUAL UNTUK PRODUK KPR
            | ADDENDUM BY UI
            | 24 JULI 2015
            */
            if(response.product_code==56){
              if(response.tipe_developer==0){
                $("#tipe_developer","#form_edit").val(response.tipe_developer);
                $("#nama_penjual_individu","#form_edit").val(response.nama_penjual_individu);
                $("#nomer_ktp","#form_edit").val(response.nomer_ktp);
                $("#nama_pasangan_developer","#form_edit").val(response.nama_pasangan_developer);
                $("#nama_perusahaan","#form_edit").val('');
                $("#div_tipe_developer","#form_edit").show();
                $("#div_individu","#form_edit").show();
                $("#div_perusahaan","#form_edit").hide();
              }else if(response.tipe_developer==1){
                $("#tipe_developer","#form_edit").val(response.tipe_developer);
                $("#nama_penjual_individu","#form_edit").val('');
                $("#nomer_ktp","#form_edit").val('');
                $("#nama_pasangan_developer","#form_edit").val('');
                $("#nama_perusahaan","#form_edit").val(response.nama_perusahaan);
                $("#div_tipe_developer","#form_edit").show();
                $("#div_individu","#form_edit").hide();
                $("#div_perusahaan","#form_edit").show();
              }
            }else{
                $("#div_tipe_developer","#form_edit").hide();
                $("#div_individu","#form_edit").hide();
                $("#div_perusahaan","#form_edit").hide();
            }
            /*END*/



            /*
            |BEGIN
            |CONDITION OF CIF_FLAG
            |0=by pegawai, 1=by kopegtel
            */
            if (response.cif_flag==0) {
              $('hr[data-cifflag=1]','#form_edit').show();
              $('div[data-cifflag=1]','#form_edit').show();

              $('#thp','#form_edit').closest('.control-group').show();
              $('#thp_40','#form_edit').closest('.control-group').show();
              $('#jumlah_kewajiban','#form_edit').closest('.control-group').show();
              $('#lunasi_ke_kopegtel','#form_edit').closest('.control-group').show();

              $('#schedulle','#form_edit').hide();
              table_termin.parent().hide();
              
              $('#control_tipe_angsuran','#form_regis').hide();

            } else {
              $('#control_tipe_angsuran','#form_regis').show();

              $('hr[data-cifflag=1]','#form_edit').hide();
              $('div[data-cifflag=1]','#form_edit').hide();

              $('#thp','#form_edit').closest('.control-group').hide();
              $('#thp_40','#form_edit').closest('.control-group').hide();
              $('#jumlah_kewajiban','#form_edit').closest('.control-group').hide();
              $('#lunasi_ke_kopegtel','#form_edit').closest('.control-group').hide();

              // table schedulle di munculkan
              $('#schedulle','#form_edit').show();

              html = ' \
              <tr> \
                <td style="text-align:center;"><input type="text" id="tgl_angsur" name="tgl_angsur[]" class="m-wrap medium mask_date date-picker" placeholder="dd/mm/yyyy" style="background:#fff;text-align:center"></td> \
                <td style="text-align:center;"><input type="text" id="angs_pokok" name="angs_pokok[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                <td style="text-align:center;"><input type="text" id="angs_margin" name="angs_margin[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                <td style="text-align:center;"> \
                  <button class="btn green" id="insert"><i class="icon-plus"></i></button> \
                  <button class="btn red" id="remove"><i class="icon-remove"></i></button> \
                </td> \
              </tr> \
              ';
              $('#table-schedulle tbody','#form_edit').html(html);

              // here load schedulle data
            }
            if (response.flag_jadwal_angsuran=='0') {
              $('#tipe_angsuran','#form_edit').val('nonreguler').trigger('change');
            } else {
              $('#tipe_angsuran','#form_edit').val('reguler').trigger('change');
            }
            $("#flag_jadwal_angsuran","#form_edit").val(response.flag_jadwal_angsuran);
            /*END*/

            /*LOAD Schedulle*/
            if (response.cif_flag=='1') {
              $.ajax({
                type:"POST",dataType:"json",data:{
                  account_financing_id:response.account_financing_id
                },
                url:site_url+'rekening_nasabah/get_account_financing_schedulle',
                success: function(response) {
                  html = '';
                  for ( i in response ) {
                    html += ' \
                            <tr> \
                              <td style="text-align:center;"><input type="text" value="'+App.ToDatePicker(response[i].tangga_jtempo)+'" id="tgl_angsur" name="tgl_angsur[]" class="m-wrap medium mask_date date-picker" placeholder="dd/mm/yyyy" style="background:#fff;text-align:center"></td> \
                              <td style="text-align:center;"><input type="text" value="'+number_format(response[i].angsuran_pokok,0,',','.')+'" id="angs_pokok" name="angs_pokok[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                              <td style="text-align:center;"><input type="text" value="'+number_format(response[i].angsuran_margin,0,',','.')+'" id="angs_margin" name="angs_margin[]" class="m-wrap medium mask-money" value="0" style="background:#fff;"></td> \
                              <td style="text-align:center;"> \
                                <button class="btn green" id="insert"><i class="icon-plus"></i></button> \
                                <button class="btn red" id="remove"><i class="icon-remove"></i></button> \
                              </td> \
                            </tr> \
                            ';
                  }
                  $('#table-schedulle tbody','#form_edit').html(html);
                  calculate_total_angsuran_edit();
                },
                error: function() {
                  App.WarningAlert('Internal server error, failed to get schedulle data, id:'+response.account_financing_id);
                }
              })
            }

          }
        });
      });


      // event for schedulle table
      var calculate_total_angsuran_edit = function() {
        total_angsuran_pokok = 0;
        total_angsuran_margin = 0;
        $('#table-schedulle tbody tr','#form_edit').each(function(){
          total_angsuran_pokok += parseFloat(convert_numeric($(this).find('#angs_pokok').val()));
          total_angsuran_margin += parseFloat(convert_numeric($(this).find('#angs_margin').val()));
        })
        $('#table-schedulle #txtTotalAngsuranPokok','#form_edit').val(number_format(total_angsuran_pokok,0,',','.'));
        $('#table-schedulle #txtTotalAngsuranMargin','#form_edit').val(number_format(total_angsuran_margin,0,',','.'));
      }

      $('#table-schedulle button#insert','#form_edit').live('click',function(e){
        e.preventDefault();
        trn = '<tr>';
        trn += '<td style="text-align:center;"><input type="text" id="tgl_angsur" name="tgl_angsur[]" class="m-wrap medium mask_date date-picker" placeholder="dd/mm/yyyy"  style="background:#fff;text-align:center;"></td>';
        trn += '<td style="text-align:center;"><input type="text" id="angs_pokok" name="angs_pokok[]" class="mask-money m-wrap medium" value="0" style="background:#fff;"></td>';
        trn += '<td style="text-align:center;"><input type="text" id="angs_margin" name="angs_margin[]" class="mask-money m-wrap medium" value="0" style="background:#fff;"></td>';
        trn += '<td style="text-align:center;">';
        trn += '<button class="btn green" id="insert"><i class="icon-plus"></i></button> ';
        trn += '<button class="btn red" id="remove"><i class="icon-remove"></i></button>';
        trn += '</td>';
        trn += '</tr>';
        $('#table-schedulle tbody','#form_edit').append(trn);
      })

      $('#table-schedulle button#remove','#form_edit').live('click',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        calculate_total_angsuran_edit();
      })

      $('#table-schedulle input#angs_pokok,#table-schedulle input#angs_margin','#form_edit').livequery('keyup',function(){
        calculate_total_angsuran_edit();
        amount = parseFloat(convert_numeric($('#amount','#form_edit').val()));
        jumlah_margin = parseFloat(convert_numeric($('#jumlah_margin','#form_edit').val()));
        TotalAngsuranPokok = parseFloat(convert_numeric($('#txtTotalAngsuranPokok','#form_edit').val()));
        TotalAngsuranMargin = parseFloat(convert_numeric($('#txtTotalAngsuranMargin','#form_edit').val()));
        bValid=true;
        msg = '';
        if (TotalAngsuranPokok>amount) {
          bValid=false;
          msg += '- Total Angsuran Pokok melebihi Jumlah Pembiayaan.<br>';
        }
        // if (TotalAngsuranMargin>jumlah_margin) {
        //   bValid=false;
        //   akad = $("#val_akad","#form_edit").val();
        //   if (akad=='IJR') {
        //     marginujroh = 'Ujroh';
        //   } else {
        //     marginujroh = 'Margin';
        //   }
        //   msg += '- Total Angsuran '+marginujroh+' melebihi Total '+marginujroh+'.';
        // }
        if (bValid==false) {
          App.WarningAlert(msg);
        }
      })


      $("#cancel","#form_edit").click(function(){
        $("#edit_regis").hide();
        $("#wrapper-table").show();
        dTreload();
        success1.hide();
        error1.hide();
        App.scrollTo($("#wrapper-table"),-200);
      });

      $("#act_update").click(function()
      {
        bValid=true;
        var margin      = eval(convert_numeric($("#jumlah_margin","#form_edit").val()));
        var min_margin  = eval(convert_numeric($("#min_margin","#form_edit").val()));
        var max_margin  = eval(convert_numeric($("#max_margin","#form_edit").val()));
        var cif_flag = $('#cif_flag','#form_edit').val();

        // alert(margin+"|"+min_margin+"|"+max_margin);
        // die;
        message = '';
        if($("#tgl_akad","#form_edit").val()==""){
          $("#tgl_akad","#form_edit").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#tgl_akad","#form_edit").removeClass('pink');
        }
        if($("#angsuranke1","#form_edit").val()==""){
          $("#angsuranke1","#form_edit").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#angsuranke1","#form_edit").removeClass('pink');
        }
        if($("#tgl_jtempo","#form_edit").val()==""){
          $("#tgl_jtempo","#form_edit").addClass('pink');
          bValid=false;
          message = "Tanggal Akad Tidak Boleh Kosong";
        }else{
          $("#tgl_jtempo","#form_edit").removeClass('pink');
        }
        if (cif_flag!='1') {
          if(max_margin-margin<0){
            message = "Batas Maksimal Margin Adalah Rp. "+number_format(max_margin,0,',','.');
            bValid=false;
            $("#jumlah_margin","#form_edit").addClass("pink");
          }else{
            $("#jumlah_margin","#form_edit").removeClass("pink");
          }
          if(margin-min_margin<0){          
            message = "Batas Minimal Margin Adalah Rp. "+number_format(min_margin,0,',','.');
            bValid=false;
            $("#jumlah_margin","#form_edit").addClass("pink");
          }else{
            $("#jumlah_margin","#form_edit").removeClass("pink");
          }
          if(max_margin-margin<0 || margin-min_margin<0){
            $("#jumlah_margin","#form_edit").addClass("pink");
          }
        }
        
        var tgl_jtempo =   $("#tgl_jtempo","#form_edit").val();
        var masa_pensiun =   $("#masa_pensiun","#form_edit").val();
        // $.ajax({
        //   url: site_url+"rekening_nasabah/compare_masa_pensiun",
        //   type: "POST",
        //   async:false,
        //   dataType: "html",
        //   data: {tgl_jtempo:tgl_jtempo,masa_pensiun:masa_pensiun},
        //   success: function(response)
        //   {
        //     if(response=="false"){
        //       bValid = false;
        //       message = "Jatuh Tempo Angsuran Melebihi Masa Pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" )";
        //     }
        //   },
        //   error: function(){
        //     bValid = false;
        //     message = "Error. Please Contact Your Administrator";
        //   }
        // })
  
        calculate_total_angsuran_edit();
        amount = parseFloat(convert_numeric($('#amount','#form_edit').val()));
        jumlah_margin = parseFloat(convert_numeric($('#jumlah_margin','#form_edit').val()));
        TotalAngsuranPokok = parseFloat(convert_numeric($('#txtTotalAngsuranPokok','#form_edit').val()));
        TotalAngsuranMargin = parseFloat(convert_numeric($('#txtTotalAngsuranMargin','#form_edit').val()));
        if (cif_flag=='1') { //banmod
          if (TotalAngsuranPokok>amount) {
            bValid=false;
            App.WarningAlert('Total Angsuran Pokok melebihi Jumlah Pembiayaan!');
            message = 'Total Angsuran Pokok melebihi Jumlah Pembiayaan!';
          } else if (TotalAngsuranPokok<amount) {
            bValid=false;
            App.WarningAlert('Total Angsuran Pokok tidak sama dengan Jumlah Pembiayaan');
            message = 'Total Angsuran Pokok tidak sama dengan Jumlah Pembiayaan';
          }
        }
        // if (TotalAngsuranMargin>jumlah_margin) {
        //   bValid=false;
        //   akad = $("#val_akad","#form_edit").val();
        //   if (akad=='IJR') {
        //     marginujroh = 'Ujroh';
        //   } else {
        //     marginujroh = 'Margin';
        //   }
        //   msg += '- Total Angsuran '+marginujroh+' melebihi Total '+marginujroh+'.';
        // }

        if(bValid==true){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/proses_update_akad_pembiayaan",
            dataType: "json",
            data: form1.serialize(),
            success: function(response){
              if(response.success==true){
                alert('Success');
                location.reload();
              }else{
                success1.hide();
                error1.show();
                message = "Error. Please Contact Your Administrator";
              }
              App.scrollTo(form1, -200);
            },
            error:function(){
                success1.hide();
                error1.show();
                message = "Error. Please Contact Your Administrator";
                App.scrollTo(form1, -200);
            }
          });
        }else{
          success1.hide();
          error1.show();
          App.scrollTo(form1, -200);          
          $("#span_message","#form_edit").html(message);
        }

      });


      // begin first table
      table = $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_registrasi_akad",
          "fnServerParams": function ( aoData ) {
               aoData.push( { "name": "product_code", "value": $("#product_code","#form-filter").val() } );
           },
          "aoColumns": [			      
            // { "bSortable": false },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
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
                  'aTargets': [0]
              }
          ]
      });


      // fungsi untuk mencari CIF_NO
      $(function(){


      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

    $("input[name='melalui']","#form_regis").click(function(){
      if($("#melalui2","#form_regis").is(':checked')==true){
        $("#div_kopegtel","#form_regis").show();
      }else{
        $("#div_kopegtel","#form_regis").hide();
      }
    });

    $("input[name='melalui']","#form_edit").click(function(){
      if($("#melalui2","#form_edit").is(':checked')==true){
        $("#div_kopegtel","#form_edit").show();
      }else{
        $("#div_kopegtel","#form_edit").hide();
      }
    });

    //jenis margin efektif
    $("#product_code","#form_regis").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      if(jenis_margin=='2'){
        $("#div_jumlah_margin","#form_regis").show();
        $("#div_angsuran_pokok","#form_regis").hide();
        $("#div_angsuran_margin","#form_regis").hide();
        $("#div_angsuran_rate_margin","#form_regis").hide();
        $("#div_total_angsuran","#form_regis").hide();
        $("#flag_jadwal_angsuran","#form_regis").val('0');
      }else if(jenis_margin=='3'){
        $("#div_jumlah_margin","#form_regis").show();
        $("#div_angsuran_pokok","#form_regis").hide();
        $("#div_angsuran_margin","#form_regis").hide();
        $("#div_angsuran_rate_margin","#form_regis").hide();
        $("#div_total_angsuran","#form_regis").show();
        $("#flag_jadwal_angsuran","#form_regis").val('0');
      }else{
        $("#div_jumlah_margin","#form_regis").hide();
        $("#div_angsuran_pokok","#form_regis").show();
        $("#div_angsuran_margin","#form_regis").show();
        $("#div_angsuran_rate_margin","#form_regis").show();
        $("#div_total_angsuran","#form_regis").show();
        $("#flag_jadwal_angsuran","#form_regis").val('1');
      }
    })

    $("#product_code","#form_edit").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      if(jenis_margin=='2'){
        $("#div_jumlah_margin","#form_edit").show();
        $("#div_angsuran_pokok","#form_edit").hide();
        $("#div_angsuran_margin","#form_edit").hide();
        $("#div_angsuran_rate_margin","#form_edit").hide();
        $("#div_total_angsuran","#form_edit").hide();
        $("#flag_jadwal_angsuran","#form_edit").val('0');
      }else if(jenis_margin=='3'){
        $("#div_jumlah_margin","#form_edit").show();
        $("#div_angsuran_pokok","#form_edit").hide();
        $("#div_angsuran_margin","#form_edit").hide();
        $("#div_angsuran_rate_margin","#form_edit").hide();
        $("#div_total_angsuran","#form_edit").show();
        $("#flag_jadwal_angsuran","#form_edit").val('0');
      }else{
        $("#div_jumlah_margin","#form_edit").hide();
        $("#div_angsuran_pokok","#form_edit").show();
        $("#div_angsuran_margin","#form_edit").show();
        $("#div_angsuran_rate_margin","#form_edit").show();
        $("#div_total_angsuran","#form_edit").show();
        $("#flag_jadwal_angsuran","#form_edit").val('1');
      }
        // $("#jenis_margin","#form_edit").val(jenis_margin);
    })

    //END jenis margin efektif

    $('#btn-filter').click(function(){
      table.fnReloadAjax();
    })

});

$('input#check_saldo','#form_regis').live('click',function () {
  if($(this).is(":checked")){
    $('#flag_registrasi','#form_regis').val('1');
    $(this).closest('tr').find('input#check_saldo_val',"#form_regis").val('1');
  }else{
    $(this).closest('tr').find('input#check_saldo_val',"#form_regis").val('0');
  }
})

$('input#check_saldo','#form_edit').live('click',function () {
  if($(this).is(":checked")){
    $('#flag_registrasi','#form_edit').val('1');
    $(this).closest('tr').find('input#check_saldo_val',"#form_edit").val('1');
  }else{
    $(this).closest('tr').find('input#check_saldo_val',"#form_edit").val('0');
  }
});



</script>
<!-- END JAVASCRIPTS -->

