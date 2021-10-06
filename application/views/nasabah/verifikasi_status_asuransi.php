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
      Pembiayaan <small>Verifikasi Status Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Status Asuransi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Status Asuransi</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="verifikasi_status_asuransi_table">
         <thead>
            <tr>
               <th width="12%">No. Pengajuan</th>
               <th width="15%">Nama Lengkap</th>
               <th width="12%">Tgl Pengajuan</th>
               <th width="12%">Jumlah</th>
               <th width="18%">Peruntukan</th>
               <th width="15%">Melalui</th>
               <th width="11%">Status Medis</th>
               <th>&nbsp;</th>
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



<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Status Asuransi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
          <input type="hidden" id="registration_no" name="registration_no">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>

            </div>
          </br>      
                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pegawai ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">NIK<span class="required">*</span></label>
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
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tempat_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        Tanggal Lahir 
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>
                      </div>
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">Alamat Rumah<span class="required">*</span></label>
                       <div class="controls">
                          <textarea name="alamat" id="alamat" class="large m-wrap" readonly="" style="background-color:#eee;" />
                          </textarea>
                       </div>
                    </div>                     
                    <div class="control-group">
                       <label class="control-label">No KTP<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" maxlength="20" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                       </div>
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">No Handphone<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" maxlength="15" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tlp Kantor</label>
                       <div class="controls">
                          <input type="text" name="telpon_rumah" id="telpon_rumah" class="medium m-wrap" maxlength="15" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30" placeholder="Suami/Istri"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Pekerjaan Pasanngan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30"/>
                       </div>
                    </div>                
                    <div class="control-group">
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
                    </div>            
                    <div class="control-group">
                        <label class="control-label">Rekening<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Bank</span>
                             <input type="text" class="medium m-wrap" name="nama_bank" id="nama_bank" maxlength="30" readonly="" style="background:#eee">
                           </div>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                             <input type="text" class="medium m-wrap" name="bank_cabang" id="bank_cabang" maxlength="100" onkeyup="this.value=this.value.toUpperCase()" readonly="" style="background:#eee">
                           </div>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                             <input type="text" class="medium m-wrap" name="no_rekening" id="no_rekening" maxlength="20" readonly="" style="background:#eee">
                           </div>
                        </div>
                    </div>   
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Atas Nama</span>
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" readonly="" style="background-color:#eee;">
                           </div>
                        </div>
                    </div>    
                    <hr>    

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Penghasilan Perbulan::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">THP <span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="thp" id="thp" class="medium m-wrap mask-money" readonly="" style="width:120px !important;background:#eee;" />
                            <!-- <input type="text" name="thp" id="thp" class="medium m-wrap" readonly="" style="background-color:#eee;"/> -->
                            <span class="add-on">,00</span>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">40% THP<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                          <!-- <input type="text" name="thp_40" id="thp_40" class="medium m-wrap"/> -->
                          <input type="text" name="thp_40" id="thp_40" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                            <span class="add-on">,00</span>
                          </div>
                       </div>
                    </div>            
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Kewajiban dan angsuran ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Koptel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_kewajiban_edit">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap mask-money" readonly="" style="width:120px !important;background:#eee;"/>
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" id="lunasi_ke_koptel" name="lunasi_ke_koptel" value="1"/><span id="span_txt_lunasi_ke_koptel" style="display:none;"> Lunasi</span>
                       </div>
                    </div> 
                    <div class="control-group" id="div_saldo_kewajiban_ke_koptel" style="display:none;">
                        <label class="control-label">Saldo Kewajiban Ke Koptel<span class="required">*</span></label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" readonly="" style="width:120px;background:#eee;" name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel" value="0">
                            <span class="add-on">,00</span>
                          </div>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_angsuran_edit">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;background:#eee;" readonly="" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="10" value="0">
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
                              <input type="text" class="m-wrap mask-money" readonly="" style="width:120px;background:#eee;" name="saldo_kewajiban" id="saldo_kewajiban" maxlength="10" value="0">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div>
                      <div class="control-group">
                          <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <select class="m-wrap chosen" name="pelunasan_ke_kopeg_mana" id="pelunasan_ke_kopeg_mana2" disabled="" style="background:#eee;">
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
                    <div class="control-group">
                      <label class="control-label">Pengajuan Melalui <span class="required">*</span></label>
                      <div class="controls">
                         <label class="radio" id="radio1">
                           <input type="radio" name="melalui" id="melalui1" value="koptel" disabled="" style="margin-top:3px;margin-left:0;background:#eee;" />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" style="margin-top:3px;background:#eee;" disabled="" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="m-wrap" disabled="" style="background:#eee;">
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
                           <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background:#eee;">
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" jenis_margin="<?php echo $produk['jenis_margin'] ?>"  max_jangka_waktu="<?php echo $produk['max_jangka_waktu'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group hide">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" disabled="" style="background:#eee;">
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>" akad_value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?> </option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>                         
                    <div class="control-group">
                       <label class="control-label">Akad : </label>
                       <div class="controls" style="padding-top:7px">
                            <span id="span_akad">-</span>
                       </div>
                    </div>                     
                    <div class="control-group">
                       <label class="control-label">Keterangan Peruntukan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="keterangan_peruntukan" id="keterangan_peruntukan" class="large m-wrap" maxlength="100" style="background:#eee;" readonly="" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" disabled="" style="width:120px;background:#eee;" name="amount" id="amount" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;background:#eee;" readonly="" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> *bulan
                         <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                         <input type="hidden" id="calculate_max_jangka_waktu" name="calculate_max_jangka_waktu">
                        </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap" readonly="" style="background:#eee;" />
                       </div>
                    </div>    
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Margin dan Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group" id="div_jumlah_margin">
                       <label class="control-label">Total Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" id="div_angsuran_pokok">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" style="background:#eee;" readonly="" />
                            <!-- <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/> -->
                          </div>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_margin">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" id="div_total_angsuran">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>             

                    <div class="control-group">
                       <label style="text-align:left"><h4>Premi Asuransi ::</h4></label>
                    </div> 

                    <div class="control-group">
                       <label class="control-label">Premi Asuransi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="premi_asuransi" id="premi_asuransi" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Premi Tambahan</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="premi_asuransi_tambahan" id="premi_asuransi_tambahan" class="small m-wrap mask-money" maxlength="10" value="0" />
                          </div>
                       </div>
                    </div>        
            <div class="form-actions">
               <input type="hidden" name="gender" id="gender">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_thp100" id="flag_thp100">
               <input type="hidden" name="account_saving_no" id="account_saving_no" value="n">
               <button type="button" id="act_approve" class="btn purple">Verifikasi</button>
               <button type="button" id="act_reject" class="btn red">Reject</button>
               <button type="button" id="act_cancel" class="hide btn blue">Cancel</button>
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
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });

      $("#biaya_notaris","#form_edit").val(0).prop(0);
      $("#biaya_adm","#form_edit").val(0).prop(0);
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      function monthDiff(d1, d2) {
          /*event untuk menentukan jangka waktu angsuran*/
          var months;
          months = (d2.getFullYear() - d1.getFullYear()) * 12;
          months -= d1.getMonth() + 1;
          months += d2.getMonth();
          return months <= 0 ? 0 : months;
      }

      function cek_max_jangka_waktu_edit(produk_code){
          /*
          | Untuk mengecek jangka waktu maksimal yang ada di tabel product_financing
          */
          var pensiun = $("#masa_pensiun","#form_edit").val();
          var thn_pensiun = pensiun.substring(0,4);
          var bln_pensiun = pensiun.substring(7,5);
          var tgl_pensiun = pensiun.substring(10,8);
          var monthInterval = monthDiff(new Date(),new Date(thn_pensiun, bln_pensiun, tgl_pensiun));
          var max_jangka_waktu  = $("#product_code option:selected","#form_add").attr('max_jangka_waktu');
          if(monthInterval>60){
              $("#notif_jk_waktu","#form_edit").html("Jangka waktu maksimal "+(max_jangka_waktu)+" bulan");
              $("#calculate_max_jangka_waktu","#form_edit").val(max_jangka_waktu);
          }else{
              $("#notif_jk_waktu","#form_edit").html("Jangka waktu maksimal "+(monthInterval-1)+" bulan");
              $("#calculate_max_jangka_waktu","#form_edit").val((monthInterval-1));
          }
          /*
          | end
          */
      }

      function status_dokumen_lengkap_func_edit(product_code) {
        $.ajax({
          type:"POST",dataType:"json",data:{product_code:product_code},
          url:site_url+'rekening_nasabah/get_status_dokumen_lengkap',
          success: function(response) {
            status_dokumen_lengkap = response.status_dokumen_lengkap;
            if (status_dokumen_lengkap==0) {
              $('#angsuran_pokok','#form_edit').closest('.control-group').hide();
              $('#angsuran_margin','#form_edit').closest('.control-group').hide();
            } else {
              $('#angsuran_pokok','#form_edit').closest('.control-group').show();
              $('#angsuran_margin','#form_edit').closest('.control-group').show();
            }
          },error:function(){
            App.WarningAlert('Internal Server Error! Please Contact Your Administrator.');
          }
        })
      }

      function hitung_margin_form_edit()
      {
        var rate          = $("#product_code","#form_edit").find('option:selected').attr('maxrate');
        var amount        = convert_numeric($("#amount","#form_edit").val());
        var jangka_waktu  = $("#jangka_waktu","#form_edit").val();

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

        total_margin = (rate*amount*jangka_waktu/100);

        angsuran_pokok = (amount/jangka_waktu);

        angsuran_margin = (eval(total_margin)/jangka_waktu);

        total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

        $("#jumlah_margin","#form_edit").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_edit").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_edit").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_edit").val(number_format(total_angsuran,0,',','.'));
      }

      function hitung_margin()
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
        hitung_margin();
      })
      $("#jumlah_margin","#form_edit").change(function(){
        hitung_margin();
      })
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'verifikasi_status_asuransi_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	   

      $("#jumlah_kewajiban","#form_edit").keyup(function(){
        if(convert_numeric($("#jumlah_kewajiban","#form_edit").val())>0){
          $(".checker","#checker_jumlah_kewajiban_edit").show();
          $("#span_txt_lunasi_ke_koptel","#form_edit").show();
          $("#lunasi_ke_koptel","#form_edit").show();
          $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
        }else{
          $(".checker","#checker_jumlah_kewajiban_edit").hide();
          $("#span_txt_lunasi_ke_koptel","#form_edit").hide();
          $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked');
          $("#lunasi_ke_koptel","#form_edit").attr('checked',false);
          $("#lunasi_ke_koptel","#form_edit").prop('checked',false);
          $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
          $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
        }
      });

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
        }
      })
      $("#jumlah_angsuran","#form_edit").change(function(){
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
        }
      })

      $("#peruntukan","#form_edit").change(function(){
        akad = $("#peruntukan","#form_edit").find('option:selected').attr('akad_value');
        if($(this).val()==''){
            $("#span_akad","#form_edit").html('');
        }else{
          if(akad=='MBA'){
            $("#span_akad","#form_edit").html('MUROBAHAH');
          }else if(akad=='IJR'){
            $("#span_akad","#form_edit").html('IJAROH');
          }else{
            $("#span_akad","#form_edit").html('');
          }

        }
      })

      // fungsi untuk check all
      jQuery('#verifikasi_status_asuransi_table .group-checkable').live('change',function () {
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

      $("#verifikasi_status_asuransi_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){        
        form2.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
        var registration_no = $(this).attr('registration_no');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id},
          url: site_url+"rekening_nasabah/get_pengajuan_pembiayaan_by_account_financing_reg_id",
          success: function(response)
          {
            $("#account_financing_reg_id","#form_edit").val(account_financing_reg_id);
            $("#nik","#form_edit").val(response.nik);
            $("#gender","#form_edit").val(response.gender);
            $("#nama","#form_edit").val(response.nama_pegawai);
            $("#band","#form_edit").val(response.band);
            $("#jabatan","#form_edit").val(response.posisi);
            $("#lokasi_kerja","#form_edit").val(response.loker);
            $("#tempat_lahir","#form_edit").val(response.tempat_lahir);
            $("#tgl_lahir","#form_edit").val(response.tgl_lahir);
            $("#alamat","#form_edit").val(response.alamat);
            $("#no_ktp","#form_edit").val(response.no_ktp);
            $("#no_telpon","#form_edit").val(response.telpon_seluler);
            $("#telpon_rumah","#form_edit").val(response.telpon_rumah);
            $("#nama_pasangan","#form_edit").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_edit").val(response.pekerjaan_pasangan);
            $("#jumlah_tanggungan","#form_edit").val(response.jumlah_tanggungan);
            $("#status_rumah","#form_edit").val(response.status_rumah);
            $("#nama_bank","#form_edit").val(response.nama_bank);
            $("#no_rekening","#form_edit").val(response.no_rekening);
            $("#atasnama_rekening","#form_edit").val(response.atasnama_rekening);
            $("#thp","#form_edit").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_edit").val(number_format(response.thp_40,0,',','.'));
            $("#jumlah_kewajiban","#form_edit").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_edit").val(number_format(response.jumlah_angsuran,0,',','.'));
            $("#kopegtel","#form_edit").val(response.kopegtel_code);
            $("#premi_asuransi","#form_edit").val(number_format(response.premi_asuransi,0,',','.'));

            $("#jumlah_kewajiban","#form_edit").trigger('keyup');
            $("#jumlah_angsuran","#form_edit").trigger('keyup');
              // if(response.thp>"0"){
              //   $("#thp","#form_edit").attr('readonly', true);
              //   $("#thp","#form_edit").prop('readonly', true);
              //   $("#thp","#form_edit").addClass('readonly');
              // }else{
              //   $("#thp","#form_edit").attr('readonly', false);
              //   $("#thp","#form_edit").prop('readonly', false);
              //   $("#thp","#form_edit").removeClass('readonly');                
              // }

            if(response.pengajuan_melalui=="koptel"){
              $("#melalui1","#form_edit").attr('checked',true);
              // $("#div_kopegtel","#form_edit").hide();
              // $("#radio1","#form_edit").show();
              // $("#radio2","#form_edit").hide();
            }else{
              $("#melalui2","#form_edit").attr('checked',true);
              $("#div_kopegtel","#form_edit").show();
              $("#kopegtel","#form_edit").val(response.kopegtel_code);              
              // $("#radio1","#form_edit").hide();
              // $("#radio2","#form_edit").show();

              // $.ajax({
              //   url: site_url+"rekening_nasabah/get_kopegtel_list_by_nik",
              //   type: "POST",
              //   dataType: "json",
              //   async:false,
              //   data: {nik:response.nik},
              //   success: function(response2)
              //   {
              //     var option = '';
              //       for(i = 0 ; i < response2.length ; i++){
              //         option += '<option value="'+response2[i].kopegtel_code+'" >'+response2[i].nama_kopegtel+'</option>';
              //       }
              //     $("#kopegtel","#form_edit").html(option);
              //   },
              //   error:function(){
              //     alert("Something Error, Please Contact Your IT Support");
              //   }
              // }); 
              // $("#kopegtel","#form_edit").val(response.kopegtel_code);
            }

            $("#product_code","#form_edit").val(response.product_code);
            $("#peruntukan","#form_edit").val(response.peruntukan);
            $("#amount","#form_edit").val(number_format(response.amount,0,',','.'));
            $("#jangka_waktu","#form_edit").val(response.jangka_waktu);

            explode = response.tanggal_pengajuan.split('-');
            var tgl_pengajuan =  explode[2]+'/'+explode[1]+'/'+explode[0];
            $("#mask_date","#form_edit").val(tgl_pengajuan);

            explode2 = response.tgl_pensiun_normal.split('-');
            var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
            $("#show_masa_pensiun","#form_edit").val(show_pensiun);

            $("#masa_pensiun","#form_edit").val(response.tgl_pensiun_normal);

            $("#flag_thp100","#form_edit").val(response.flag_thp);
            $("#bank_cabang","#form_edit").val(response.bank_cabang);
            $("#keterangan_peruntukan","#form_edit").val(response.description);

            if(response.lunasi_ke_kopegtel=="1"){
              $("#lunasi_ke_kopegtel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',true);
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban","#form_edit").val(response.saldo_kewajiban);
              $("#saldo_kewajiban","#form_edit").prop(response.saldo_kewajiban);
              $("#div_saldo_kewajiban","#form_edit").show();
              $("#pelunasan_ke_kopeg_mana2","#form_edit").val(response.pelunasan_ke_kopeg_mana);
              $("#pelunasan_ke_kopeg_mana2","#form_edit").trigger('liszt:updated');
            }else{
              $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban","#form_edit").hide();
              $("#saldo_kewajiban","#form_edit").val(0).prop(0);
            }
            if(response.lunasi_ke_koptel=="1"){
              $("#lunasi_ke_koptel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_koptel","#form_edit").attr('checked',true);
              $("#lunasi_ke_koptel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(response.saldo_kewajiban_ke_koptel);
              $("#saldo_kewajiban_ke_koptel","#form_edit").prop(response.saldo_kewajiban_ke_koptel);
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
              
            }else{
              $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
            }

            $("#peruntukan","#form_edit").trigger('change');
            $("#product_code","#form_edit").trigger('change');
            $("#jumlah_margin","#form_edit").val(number_format(response.total_margin,0,',','.'));

            // hitung_margin_form_edit()
            /*
            | Editan Ujang Irawan
            | 16 April 2015
            */
            var rate          = $("#product_code","#form_edit").find('option:selected').attr('maxrate');
            var amount        = convert_numeric($("#amount","#form_edit").val());
            var jangka_waktu  = $("#jangka_waktu","#form_edit").val();

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

            // total_margin = (rate*amount*jangka_waktu/100);
            total_margin = ((rate/1200)*amount*jangka_waktu);

            // angsuran_pokok = (amount/jangka_waktu);

            // angsuran_margin = (eval(total_margin)/jangka_waktu);

            // total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

            $("#jumlah_margin","#form_edit").val(number_format(total_margin,0,',','.'));
            $("#angsuran_pokok","#form_edit").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#angsuran_margin","#form_edit").val(number_format(response.angsuran_margin,0,',','.'));
            var total_angsuran = parseFloat(response.angsuran_pokok)+parseFloat(response.angsuran_margin);
            $("#total_angsuran","#form_edit").val(number_format(total_angsuran,0,',','.'));

            cek_max_jangka_waktu_edit(response.product_code);
            status_dokumen_lengkap_func_edit(response.product_code);

          }
        });

      });


    $("#product_code","#form_edit").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      if(jenis_margin=='2'){
        $("#div_jumlah_margin","#form_edit").show();
        $("#div_angsuran_pokok","#form_edit").hide();
        $("#div_angsuran_margin","#form_edit").hide();
        $("#div_total_angsuran","#form_edit").hide();
      }else{
        $("#div_jumlah_margin","#form_edit").hide();
        $("#div_angsuran_pokok","#form_edit").show();
        $("#div_angsuran_margin","#form_edit").show();
        $("#div_total_angsuran","#form_edit").show();
      }
        $("#jenis_margin","#form_edit").val(jenis_margin);
    })
        


      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
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

      // fungsi untuk  PENGAJUAN
      $("a#link_setuju").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var registration_no = $(this).attr('registration_no');
          var conf = confirm('Setujui Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/setuju_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id,registration_no:registration_no},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil disetujui!");
                  dTreload();
                }else{
                  alert("Gagal disetujui!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });

      // fungsi untuk BATAL PENGAJUAN
      $("a#link_batal").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var registration_no = $(this).attr('registration_no');
          var conf = confirm('Batalkan Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/batal_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id,registration_no:registration_no},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Dibatalkan!");
                  dTreload();
                }else{
                  alert("Gagal Dibatalkan!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });

      // fungsi untuk TOLAK PENGAJUAN
      $("#act_reject").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id").val();
          var conf = confirm('Tolak Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_tolak_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Ditolak!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Ditolak!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });
      $("#act_cancel").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id").val();
          var conf = confirm('Batalkan Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_batal_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Dibatalkan!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Dibatalkan!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });

      $("#act_approve").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id","#form_edit").val();
          var account_saving_no = $("#account_saving_no","#form_edit").val();
          var nik = $("#nik","#form_edit").val();
          var nama_bank = $("#nama_bank","#form_edit").val();
          var no_rekening = $("#no_rekening","#form_edit").val();
          var atasnama_rekening = $("#atasnama_rekening","#form_edit").val();
          var bank_cabang = $("#bank_cabang","#form_edit").val();
          var premi_asuransi_tambahan = $("#premi_asuransi_tambahan","#form_edit").val();
          var conf = confirm('Verifikasi Status Asuransi ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_verifikasi_status_asuransi",
              dataType: "json",
              data: {
                 account_financing_reg_id:account_financing_reg_id
                ,account_saving_no:account_saving_no
                ,nik:nik
                ,nama_bank:nama_bank
                ,no_rekening:no_rekening
                ,atasnama_rekening:atasnama_rekening
                ,premi_asuransi_tambahan:premi_asuransi_tambahan
                ,bank_cabang:bank_cabang
              },
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Diaktivasi!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Diaktivasi!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });


      // begin first table
      $('#verifikasi_status_asuransi_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_status_asuransi",
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
                  'aTargets': [7]
              }
          ]
      });


});
</script>
<!-- END JAVASCRIPTS -->

