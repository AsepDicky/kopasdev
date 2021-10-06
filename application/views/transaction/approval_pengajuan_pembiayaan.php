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
      Pembiayaan <small>Approval Pengajuan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Approval Pengajuan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Approval Pengajuan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:44px;float:left;margin-bottom:0;padding:0 5px 0 10px">Produk</label>
        <div style="padding:5px;float:left;">
          <select id="src_product" name="src_product" class="medium m-wrap" data-required="1" style="margin:0 5px;">
            <option value="">SEMUA PRODUK</option>
            <?php foreach($product as $produk): ?>
              <option value="<?php echo $produk['product_code'];?>"><?php echo $produk['product_name'];?></option>
            <?php endforeach?>
          </select>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th> -->
               <th width="11%">No. Pengajuan</th>
               <th width="10%">CIF No</th>
               <th width="22%">Nama Lengkap</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="12%">Jumlah</th>
               <th width="20%">Peruntukan</th>
               <th width="20%">Produk</th>
               <th width="19%">Melalui</th>
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
         <div class="caption"><i class="icon-reorder"></i>Approval Pembiayaan</div>
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
                       <label class="control-label">Pekerjaan Pasanngan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" readonly="" style="background-color:#eee;" maxlength="30"/>
                       </div>
                    </div>                
                    <div class="control-group hide">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" readonly="" style="background-color:#eee;width:50px;" maxlength="2" value="0" />
                       </div>
                    </div>     
                    <div class="control-group hide">
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
                             <input type="text" class="medium m-wrap" name="nama_bank" id="nama_bank"  readonly="" style="background-color:#eee;">
                           </div>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                             <input type="text" class="medium m-wrap" name="bank_cabang" id="bank_cabang"  readonly="" style="background-color:#eee;">
                           </div>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                             <input type="text" class="medium m-wrap" name="no_rekening" id="no_rekening"  readonly="" style="background-color:#eee;">
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
                    <!-- <div class="control-group">
                       <label class="control-label">Kewajiban Ke Koptel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap" name="jumlah_kewajiban" id="jumlah_kewajiban" readonly="" style="background-color: #eee; width: 120px; text-align: right;">
                            <span class="add-on">,00</span>
                          </div>
                       </div>
                    </div>  -->
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Koptel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_kewajiban_add">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap" readonly="" style="width:120px !important;background-color: #eee;"/>
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" id="lunasi_ke_koptel" name="lunasi_ke_koptel" value="1" readonly="" /><span id="span_txt_lunasi_ke_koptel" style="display:none;"> Lunasi</span>
                       </div>
                    </div> 
                    <div class="control-group" id="div_saldo_kewajiban_ke_koptel" style="display:none;">
                        <label class="control-label">Saldo Kewajiban Ke Koptel<span class="required">*</span></label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;;background-color: #eee;" name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel">
                            <span class="add-on">,00</span>
                          </div>
                        </div>
                    </div>
                    <div class="control-group">
                       <div class="controls" style="margin-top:20px;margin-bottom:20px;">
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
                            </tbody>
                          </table>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Kewajiban Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15"  readonly="" style="background-color:#eee;width:120px;">
                            <span class="add-on">,00</span>
                          </div>
                          <input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1" readonly="" /><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <div id="div_saldo_kewajiban" style="display:none;">
                      <div class="control-group">
                          <label class="control-label">Saldo Kewajiban Ke Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" name="saldo_kewajiban" id="saldo_kewajiban"  readonly="" style="background-color:#eee;width:120px;width:120px;">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div>   
                      <div class="control-group">
                          <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <select class="m-wrap" name="pelunasan_ke_kopeg_mana" id="pelunasan_ke_kopeg_mana2" disabled="" style="background-color:#eee;">
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
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
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
                           <select id="product_code" name="product_code" disabled="" class="m-wrap" style="background-color:#eee;">
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
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" disabled="" style="background-color:#eee;">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad_value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
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
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group" id="div_angsuran_pokok">
                       <label class="control-label">Porsi Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_margin">
                       <label class="control-label"><span id="label-pendapatan-margin">Porsi Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group" id="div_total_angsuran">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap" readonly="" style="background-color:#eee;text-align:right;"/>
                          </div>
                       </div>
                    </div>    

                    <div id="div_tipe_developer" style="display:none;">
                      <div class="control-group">
                         <label style="text-align:left"><h4>Data Developer ::</h4></label>
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
                      <div class="control-group">
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
                    <div id="div_biaya_di_awal" style="display:none;">
                      <div class="control-group" style="display:none;">
                         <label class="control-label">Provisi Pembiayaan</label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="provisi_pembiayaan" id="provisi_pembiayaan" class="small m-wrap mask-money" value="0" />
                            </div>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Premi Asuransi</label>
                         <div class="controls">
                          <span id="span_premi_asuransi"></span>
                         </div>
                      </div> 
                      <div class="control-group" id="premi_asuransi_tambahan">
                         <label class="control-label">Premi Asuransi Tambahan</label>
                         <div class="controls">
                          <span id="span_premi_asuransi_tambahan"></span>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Angsuran Pertama</label>
                         <div class="controls">
                          <span id="span_angsruan_pertama"></span>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Biaya Administrasi</label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="biaya_administrasi" id="biaya_administrasi" class="small m-wrap mask-money" value="0" />
                            </div>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Biaya Notaris </label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="biaya_notaris" id="biaya_notaris" class="small m-wrap mask-money" value="0" />
                            </div>
                         </div>
                      </div> 
                      <div class="control-group" style="display:none;">
                         <label class="control-label">Biaya APHT </label>
                         <div class="controls">
                            <div class="input-prepend">
                              <span class="add-on">Rp</span>
                              <input type="text" name="biaya_apht" id="biaya_apht" class="small m-wrap mask-money" value="0" />
                            </div>
                         </div>
                      </div> 
                    </div>      
            <div class="form-actions">
               <input type="hidden" name="account_saving_no" id="account_saving_no" value="n">
               <button type="button" id="act_approve" class="btn purple">Approve</button>
               <button type="button" id="act_reject" class="btn red">Tolak</button>
               <!-- <button type="button" id="act_cancel" class="btn blue">Cancel</button> -->
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


      function hitung_margin_form_edit()
      {
        var jenis_margin          = $("#product_code","#form_edit").find('option:selected').attr('jenis_margin');
        if (jenis_margin=='2') { //efektif
          get_total_pokok_efektif_form2();
        } else if (jenis_margin=='3') { //anuitas
          get_total_margin_dan_angsuran_anuitas_form2();
        } else { //flat
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
          v_total_angsuran = pembulatan_angsuran(total_angsuran);
          v_angsuran_pokok = v_total_angsuran-angsuran_margin;

          $("#jumlah_margin","#form_edit").val(number_format(total_margin,0,',','.'));
          $("#angsuran_pokok","#form_edit").val(number_format(v_angsuran_pokok,0,',','.'));
          $("#angsuran_margin","#form_edit").val(number_format(angsuran_margin,0,',','.'));
          $("#total_angsuran","#form_edit").val(number_format(v_total_angsuran,0,',','.'));
        }
      }
      function get_total_pokok_efektif_form2(){
        var margin  = $('#product_code option:selected', "#form_edit").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_edit").val();
        var amount  = $('#amount', "#form_edit").val();

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
            $("#jumlah_margin","#form_edit").val(number_format(response,0,',','.'));
            $("#angsuran_pokok","#form_edit").val('0');
            $("#angsuran_margin","#form_edit").val('0');
            $("#total_angsuran","#form_edit").val('0');
            $("#angsuran_pokok","#form_edit").prop('0');
            $("#angsuran_margin","#form_edit").prop('0');
            $("#total_angsuran","#form_edit").prop('0');
            $("#div_angsuran_pokok","#form_edit").hide();
            $("#div_angsuran_margin","#form_edit").hide();
            $("#div_total_angsuran","#form_edit").hide();
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
      }
      function get_total_margin_dan_angsuran_anuitas_form2(){
        var margin  = $('#product_code option:selected', "#form_edit").attr('maxrate');
        var jangka_waktu  = $('#jangka_waktu', "#form_edit").val();
        var amount  = $('#amount', "#form_edit").val();
        var product_code  = $("#product_code","#form_edit").val();

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
            $("#jumlah_margin","#form_edit").val(number_format(response.total_margin,0,',','.'));
            $("#total_angsuran","#form_edit").val(number_format(response.total_angsuran,0,',','.'));
            $("#angsuran_pokok","#form_edit").val('0');
            $("#angsuran_pokok","#form_edit").prop('0');
            $("#angsuran_margin","#form_edit").val('0');
            $("#angsuran_margin","#form_edit").prop('0');
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
      }
      
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
        var product_code = $(this).attr('product_code');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id},
          url: site_url+"rekening_nasabah/get_pengajuan_pembiayaan_by_account_financing_reg_id",
          success: function(response)
          {
              
              $.ajax({
                url: site_url+"rekening_nasabah/get_product_financing_by_band",
                type: "POST",
                dataType: "json",
                async:false,
                data: {band:response.band,default_parent:'1'},
                success: function(response)
                {
                  option = '<option value="" maxrate="">PILIH</option>';
                  for (var i = 0; i < response.length; i++) {
                    option +='<option value="'+response[i].product_code+'" maxrate="'+response[i].rate_margin2+'" max_jangka_waktu="'+response[i].max_jangka_waktu+'" jenis_margin="'+response[i].jenis_margin+'">'+response[i].product_name+'</option>';
                  };
                  $("#product_code","#form_edit").html(option);
                }
              })
              
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
            $("#nama_pasangan","#form_edit").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_edit").val(response.pekerjaan_pasangan);
            $("#jumlah_tanggungan","#form_edit").val(response.jumlah_tanggungan);
            $("#status_rumah","#form_edit").val(response.status_rumah);
            $("#nama_bank","#form_edit").val(response.nama_bank);
            $("#bank_cabang","#form_edit").val(response.bank_cabang);
            $("#no_rekening","#form_edit").val(response.no_rekening);
            $("#atasnama_rekening","#form_edit").val(response.atasnama_rekening);
            $("#thp","#form_edit").val(number_format(response.thp,0,',','.'));
            $("#thp_40","#form_edit").val(number_format(response.thp_40,0,',','.'));
            $("#jumlah_kewajiban","#form_edit").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_edit").val(number_format(response.jumlah_angsuran,0,',','.'));
            
            if(response.jumlah_angsuran=="0.00"){
              $("#uniform-lunasi_ke_kopegtel","#form_edit").hide();
              $("#span_txt_lunasi","#form_edit").hide();
            }else{
              $("#uniform-lunasi_ke_kopegtel","#form_edit").show();
              $("#span_txt_lunasi","#form_edit").show();              
            }
            if(response.jumlah_kewajiban=="0.00"){
              $("#uniform-lunasi_ke_koptel","#form_edit").hide();
              $("#span_txt_lunasi","#form_edit").hide();
            }else{
              $("#uniform-lunasi_ke_koptel","#form_edit").show();
              $("#span_txt_lunasi","#form_edit").show();              
            }

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
            $("#masa_pensiun","#form_edit").val(response.tgl_pensiun_normal);

            $.ajax({
              url: site_url+"rekening_nasabah/get_account_saving_by_cif",
              type: "POST",
              dataType: "html",
              async:false,
              data: {nik:response.nik},
              success: function(response2)
              {
                if (response2=="0") {
                  $("#account_saving_no","#form_edit").val('n');
                } else{
                  $("#account_saving_no","#form_edit").val('y');
                };
              }
            })

            if(response.lunasi_ke_kopegtel=="1"){
              $("#lunasi_ke_kopegtel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',true);
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',true);
              $("#lunasi_ke_kopegtel","#form_edit").attr('disabled',true);
              $("#lunasi_ke_kopegtel","#form_edit").prop('disabled',true);
              $("#saldo_kewajiban","#form_edit").val(number_format(response.saldo_kewajiban,0,',','.'));
              $("#saldo_kewajiban","#form_edit").prop(number_format(response.saldo_kewajiban,0,',','.'));
              $("#pelunasan_ke_kopeg_mana2","#form_edit").val(response.pelunasan_ke_kopeg_mana);
              $("#div_saldo_kewajiban","#form_edit").show();
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
              $("#lunasi_ke_koptel","#form_edit").attr('disabled',true);
              $("#lunasi_ke_koptel","#form_edit").prop('disabled',true);
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#saldo_kewajiban_ke_koptel","#form_edit").prop(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
              $("#span_txt_lunasi_ke_koptel","#form_edit").show();
            }else{
              $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
            }

            $("#peruntukan","#form_edit").trigger('change');
            // cek_max_jangka_waktu_edit($("#product_code","#form_edit").val());
            $("#product_code","#form_edit").trigger('change');
            hitung_margin_form_edit()

            /*
            | PENAMBAHAN DATA DEVELOPER UNTUK PRODUK KPR
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

            /*View list saldo pokok*/
            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_list_saldo_lunas_reg",
               dataType: "json",
               data: {cif_no:response.cif_no},
               success: function(response3){
                  html = '';
                  for(k = 0 ; k < response3.length ; k++){
                    html += ' \
                          <tr>\
                            <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no" value="'+response3[k].account_financing_no+'">\
                                <input type="hidden" name="no_pembiayaan" id="no_pembiayaan" value="'+response3[k].account_financing_no+'">\
                    ';
                    if(response3[k].is_checked=='1'){
                      html += ' \
                                <input type="checkbox" name="check_saldo[]" id="check_saldo" checked disabled="">\
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
                              <input type="hidden" name="check_saldo_pokok[]" value="'+response3[k].saldo_pokok+'">'+number_format(response3[k].saldo_pokok,0,',','.')+'\
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_margin[]" value="'+response3[k].saldo_margin+'">'+number_format(response3[k].saldo_margin,0,',','.')+'\
                            </td>\
                          </tr>\
                    ';
                  }
                  $("#list_saldo_pokok tbody","#form_edit").html(html);
               }
            });
            /*END*/

            /*BIAYA DI AWAL: ADM dan lain lain*/            
            $("#span_premi_asuransi","#form_edit").html(response.premi_asuransi);
            $("#span_premi_asuransi_tambahan","#form_edit").html(response.premi_asuransi_tambahan);
            $("#span_angsruan_pertama","#form_edit").html(response.angsruan_pertama);
            $("#provisi_pembiayaan","#form_edit").val(0).prop(0);
            $("#biaya_administrasi","#form_edit").val(0).prop(0);
            $("#biaya_notaris","#form_edit").val(0).prop(0);
            $("#biaya_apht","#form_edit").val(0).prop(0);
            if(response.code_value!=null){
              $("#div_biaya_di_awal").show();
            }else{
              $("#div_biaya_di_awal").hide();
            }
            if(response.premi_asuransi_tambahan!='' && response.premi_asuransi_tambahan!='0'){
              $("#premi_asuransi_tambahan").show();
            }else{
              $("#premi_asuransi_tambahan").hide();
            }
            /*END BIAYA DI AWAL: ADM dan lain lain*/

          }
        });

      });

    $("#product_code","#form_edit").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      if(jenis_margin=='2'){
        $("#div_angsuran_pokok","#form_edit").hide();
        $("#div_angsuran_margin","#form_edit").hide();
        $("#div_total_angsuran","#form_edit").hide();
      }else if(jenis_margin=='3'){
        $("#div_angsuran_pokok","#form_edit").hide();
        $("#div_angsuran_margin","#form_edit").hide();
        $("#div_total_angsuran","#form_edit").show();
      }else{
        $("#div_angsuran_pokok","#form_edit").show();
        $("#div_angsuran_margin","#form_edit").show();
        $("#div_total_angsuran","#form_edit").show();
      }
        $("#jenis_margin","#form_edit").val(jenis_margin);
    })

      $("#peruntukan","#form_edit").change(function(){
        akad = $("#peruntukan","#form_edit").find('option:selected').attr('akad_value');
        labeltotalmarginujroh(akad,$('#label-total-margin','#form_edit'));
        labelpendapatanmarginujroh(akad,$('#label-pendapatan-margin','#form_edit'));
        if($("#peruntukan","#form_edit")==''){
            $("#span_akad","#form_edit").html('-');
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
                  alert("Success!");
                  dTreload();
                }else{
                  alert("Failed!");
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
                  // alert("Berhasil disetujui!");
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
                  // alert("Berhasil Dibatalkan!");
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
                  // alert("Berhasil Ditolak!");
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
                  // alert("Berhasil Dibatalkan!");
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
          var provisi_pembiayaan = $("#provisi_pembiayaan","#form_edit").val();
          var biaya_administrasi = $("#biaya_administrasi","#form_edit").val();
          var biaya_notaris = $("#biaya_notaris","#form_edit").val();
          var biaya_apht = $("#biaya_apht","#form_edit").val();
          var conf = confirm('Aktivasi Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_approve_pengajuan_pembiayaan",
              dataType: "json",
              data: {
                 account_financing_reg_id:account_financing_reg_id
                ,account_saving_no:account_saving_no
                ,nik:nik
                ,nama_bank:nama_bank
                ,no_rekening:no_rekening
                ,atasnama_rekening:atasnama_rekening
                ,bank_cabang:bank_cabang
                ,provisi_pembiayaan:provisi_pembiayaan
                ,biaya_administrasi:biaya_administrasi
                ,biaya_notaris:biaya_notaris
                ,biaya_apht:biaya_apht
              },
              success: function(response){
                if(response.success==true){
                  // alert("Berhasil Diaktivasi!");
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
      
      $("#src_product").change(function(){
        dTreload();
      })

      // begin first table
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_approval_pengajuan_pembiayaan",
           "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "src_product", "value": $("#src_product").val() } );
            },
          "aoColumns": [			      
            // { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false }
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

