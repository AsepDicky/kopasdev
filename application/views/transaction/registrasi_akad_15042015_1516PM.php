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
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th> -->
               <th width="11%">No Pengajuan</th>
               <th width="30%">Nama Lengkap</th>
               <th width="13%">Jumlah</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="13%">Tgl Approval</th>
               <th width="13%">Peruntukan</th>
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
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message"></span>
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
                    <div class="control-group">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
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
                    <hr>    

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Penghasilan Perbulam::</h4></label>
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
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Kewajiban dan angsuran ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Kewajiban Ke Koptel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Kewajiban ke Kopegtel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15"  readonly="" style="background-color:#eee;width:120px;">
                            <span class="add-on">,00</span>
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
                           <input type="radio" name="melalui" id="melalui1" value="koptel" style="display:none;" />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" style="display:none;" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="m-wrap" disabled="" style="background-color:#eee;">
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
                           <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" disabled="" style="background-color:#eee;">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
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
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Margin dan Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Total Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
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
            <div class="form-actions">
               <input type="hidden" name="min_margin" id="min_margin" value="0">
               <input type="hidden" name="max_margin" id="max_margin" value="0">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <button type="button" id="act_update" class="btn purple">Update</button>
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
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message"></span>
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
                    <div class="control-group">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
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
                    <hr>    

                    <div class="control-group">
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
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Kewajiban dan angsuran ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Kewajiban Ke Koptel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Lain-lain<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15"  readonly="" style="background-color:#eee;width:120px;">
                            <span class="add-on">,00</span>
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
                           <input type="radio" name="melalui" id="melalui1" value="koptel" style="display:none;" />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" style="display:none;" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="m-wrap" disabled="" style="background-color:#eee;">
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
                           <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background-color:#eee;">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" disabled="" style="background-color:#eee;">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
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
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Margin dan Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Total Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
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
            <div class="form-actions">
               <input type="hidden" name="account_saving_no" id="account_saving_no" value="n">
               <input type="hidden" name="min_margin" id="min_margin" value="0">
               <input type="hidden" name="max_margin" id="max_margin" value="0">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <button type="button" id="act_regis" class="btn green">Registrasi</button>
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

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">


      function hitung_margin_form_regis()
      {
        var rate          = $("#product_code","#form_regis").find('option:selected').attr('maxrate');
        var amount        = convert_numeric($("#amount","#form_regis").val());
        var jangka_waktu  = $("#jangka_waktu","#form_regis").val();

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

        $("#jumlah_margin","#form_regis").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_regis").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_regis").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_regis").val(number_format(total_angsuran,0,',','.'));
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

        $("#jumlah_margin","#form_edit").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_edit").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_edit").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_edit").val(number_format(total_angsuran,0,',','.'));
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
        })
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
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id},
          url: site_url+"rekening_nasabah/get_data_for_akad_by_account_financing_reg_id",
          success: function(response)
          {
            $("#account_financing_reg_id","#form_regis").val(account_financing_reg_id);
            $("#nik","#form_regis").val(response.nik);
            $("#gender","#form_regis").val(response.gender);
            $("#nama","#form_regis").val(response.nama_pegawai);
            $("#band","#form_regis").val(response.band);
            $("#jabatan","#form_regis").val(response.posisi);
            $("#lokasi_kerja","#form_regis").val(response.loker);
            $("#tempat_lahir","#form_regis").val(response.tempat_lahir);
            $("#tgl_lahir","#form_regis").val(response.tgl_lahir);
            $("#alamat","#form_regis").val(response.alamat);
            $("#no_ktp","#form_regis").val(response.no_ktp);
            $("#no_telpon","#form_regis").val(response.telpon_seluler);
            $("#nama_pasangan","#form_regis").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_regis").val(response.pekerjaan_pasangan);
            $("#jumlah_tanggungan","#form_regis").val(response.jumlah_tanggungan);
            $("#status_rumah","#form_regis").val(response.status_rumah);
            $("#nama_bank","#form_regis").val(response.nama_bank);
            $("#no_rekening","#form_regis").val(response.no_rekening);
            $("#bank_cabang","#form_regis").val(response.bank_cabang);
            $("#atasnama_rekening","#form_regis").val(response.atasnama_rekening);
            $("#thp","#form_regis").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_regis").val(number_format(response.thp_40,0,',','.'));
            $("#jumlah_kewajiban","#form_regis").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_regis").val(number_format(response.jumlah_angsuran,0,',','.'));

            $('#biaya_asuransi','#form_regis').val(number_format(response.biaya_asuransi,0,',','.'))
            $('#total_biaya','#form_regis').val(number_format(response.biaya_asuransi,0,',','.'))

            if(response.pengajuan_melalui=="koperasi"){
              $("#radio1","#form_regis").hide();
              $("#radio2","#form_regis").show();
              $("#div_kopegtel","#form_regis").show();
              $("#kopegtel","#form_regis").val(response.kopegtel_code);              
            }else{
              $("#radio1","#form_regis").show();
              $("#radio2","#form_regis").hide();
            }

            $("#product_code","#form_regis").val(response.product_code);
            $("#peruntukan","#form_regis").val(response.peruntukan);
            $("#amount","#form_regis").val(number_format(response.amount,0,',','.'));
            $("#jangka_waktu","#form_regis").val(response.jangka_waktu);

            explode = response.tanggal_pengajuan.split('-');
            var tgl_pengajuan =  explode[2]+'/'+explode[1]+'/'+explode[0];
            $("#mask_date","#form_regis").val(tgl_pengajuan);

            explode2 = response.tgl_pensiun_normal.split('-');
            var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
            $("#show_masa_pensiun","#form_regis").val(show_pensiun);

            $("#masa_pensiun","#form_regis").val(response.tgl_pensiun_normal);
            $("#min_margin","#form_regis").val(response.min_margin);
            $("#max_margin","#form_regis").val(response.max_margin);

            hitung_margin_form_regis();
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

          }
        });

      });
        


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

        if(max_margin-margin<0){
          message = "Batas Maksimal Margin Adalah Rp. "+number_format(max_margin,0,',','.');
          bValid=false;
          $("#jumlah_margin","#form_regis").addClass("pink");
        }else{
          $("#jumlah_margin","#form_regis").removeClass("pink");
        }
        if(margin-min_margin<0){          
          message = "Batas Minimal Margin Adalah Rp. "+number_format(min_margin,0,',','.');
          bValid=false;
          $("#jumlah_margin","#form_regis").addClass("pink");
        }else{
          $("#jumlah_margin","#form_regis").removeClass("pink");
        }
        if(max_margin-margin<0 || margin-min_margin<0){
          $("#jumlah_margin","#form_regis").addClass("pink");
        }
        
        var tgl_jtempo =   $("#tgl_jtempo","#form_regis").val();
        var masa_pensiun =   $("#masa_pensiun","#form_regis").val();
        $.ajax({
          url: site_url+"rekening_nasabah/compare_masa_pensiun",
          type: "POST",
          async:false,
          dataType: "html",
          data: {tgl_jtempo:tgl_jtempo,masa_pensiun:masa_pensiun},
          success: function(response)
          {
            if(response=="false"){
              bValid = false;
              message = "Jatuh Tempo Angsuran Melebihi Masa Pensiun ( "+$("#show_masa_pensiun","#form_regis").val()+" )";
            }
          },
          error: function(){
            bValid = false;
            message = "Error. Please Contact Your Administrator";
          }
        })

        if(bValid==true){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/proses_registrasi_akad_pembiayaan",
            dataType: "json",
            data: form2.serialize(),
            success: function(response){
              if(response.success==true){
                alert('Success');
                location.reload();
              }else{
                success2.hide();
                error2.show();
              }
              App.scrollTo(form2, -200);
            },
            error:function(){
                success2.hide();
                error2.show();
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
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"rekening_nasabah/get_data_for_akad_by_account_financing_no",
          success: function(response)
          {
            $("#account_financing_id","#form_edit").val(response.account_financing_id);
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
            $("#nama_pasangan","#form_edit").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_edit").val(response.pekerjaan_pasangan);
            $("#jumlah_tanggungan","#form_edit").val(response.jumlah_tanggungan);
            $("#status_rumah","#form_edit").val(response.status_rumah);
            $("#nama_bank","#form_edit").val(response.nama_bank);
            $("#no_rekening","#form_edit").val(response.no_rekening);
            $("#bank_cabang","#form_edit").val(response.bank_cabang);
            $("#atasnama_rekening","#form_edit").val(response.atasnama_rekening);
            $("#thp","#form_edit").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_edit").val(number_format(response.thp_40,0,',','.'));
            $("#jumlah_kewajiban","#form_edit").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_edit").val(number_format(response.jumlah_angsuran,0,',','.'));

            if(response.pengajuan_melalui=="koperasi"){
              $("#radio1","#form_edit").hide();
              $("#radio2","#form_edit").show();
              $("#div_kopegtel","#form_edit").show();
              $("#kopegtel","#form_edit").val(response.kopegtel_code);              
            }else{
              $("#radio1","#form_edit").show();
              $("#radio2","#form_edit").hide();
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
            $("#min_margin","#form_edit").val(response.min_margin);
            $("#max_margin","#form_edit").val(response.max_margin);

            $("#biaya_notaris","#form_edit").val(number_format(response.biaya_notaris,0,',','.')).prop(number_format(response.biaya_notaris,0,',','.'));
            $("#biaya_adm","#form_edit").val(number_format(response.biaya_administrasi,0,',','.')).prop(number_format(response.biaya_administrasi,0,',','.'));
            $("#biaya_asuransi","#form_edit").val(number_format(response.biaya_asuransi_jiwa,0,',','.')).prop(number_format(response.biaya_asuransi_jiwa,0,',','.'));
            hitung_total_biaya_edit();
            $("#jumlah_margin","#form_edit").val(number_format(response.margin,0,',','.')).prop(number_format(response.margin,0,',','.'));
            $("#angsuran_pokok","#form_edit").val(number_format(response.angsuran_pokok,0,',','.')).prop(number_format(response.angsuran_pokok,0,',','.'));
            $("#angsuran_margin","#form_edit").val(number_format(response.angsuran_margin,0,',','.')).prop(number_format(response.angsuran_margin,0,',','.'));
            hitung_margin_edit();

            exp1 = response.tanggal_akad.split('-');
            var tgl_akad =  exp1[2]+'/'+exp1[1]+'/'+exp1[0];
            $("#tgl_akad","#form_edit").val(tgl_akad);

            exp2 = response.tanggal_mulai_angsur.split('-');
            var tgl_mulai_angsur =  exp2[2]+'/'+exp2[1]+'/'+exp2[0];
            $("#angsuranke1","#form_edit").val(tgl_mulai_angsur);

            expl3 = response.tanggal_jtempo.split('-');
            var tgl_jtempo =  expl3[2]+'/'+expl3[1]+'/'+expl3[0];
            $("#tgl_jtempo","#form_edit").val(tgl_jtempo);

          }
        });
      });
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

        // alert(margin+"|"+min_margin+"|"+max_margin);
        // die;

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
        
        var tgl_jtempo =   $("#tgl_jtempo","#form_edit").val();
        var masa_pensiun =   $("#masa_pensiun","#form_edit").val();
        $.ajax({
          url: site_url+"rekening_nasabah/compare_masa_pensiun",
          type: "POST",
          async:false,
          dataType: "html",
          data: {tgl_jtempo:tgl_jtempo,masa_pensiun:masa_pensiun},
          success: function(response)
          {
            if(response=="false"){
              bValid = false;
              message = "Jatuh Tempo Angsuran Melebihi Masa Pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" )";
            }
          },
          error: function(){
            bValid = false;
            message = "Error. Please Contact Your Administrator";
          }
        })

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
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_registrasi_akad",
          "aoColumns": [			      
            // { "bSortable": false },
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

});
</script>
<!-- END JAVASCRIPTS -->

