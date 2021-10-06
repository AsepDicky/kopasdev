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
      Transaksi <small>Registrasi Akad</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Akad</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekening Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <!-- <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div> -->
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
      </div>
      <table class="table table-striped table-bordered table-hover" id="rekening_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_pembiayaan_table .checkboxes" /></th> -->
              <th width="13%">No. Pengajuan</th>
               <th width="20%">Nama Lengkap</th>
               <th width="15%">Tgl Pengajuan</th>
               <th width="12%">Amount</th>
               <th width="13%">Peruntukan</th>
               <th width="15%">Petugas</th>
               <!-- <th width="5%">Skor</th> -->
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN ADD  -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Rekening Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal"><!-- 
          <input type="hidden" id="manfaat_asuransi" name="manfaat_asuransi">
          <input type="hidden" id="product_asuransi" name="product_asuransi"> -->
            <input type="hidden" id="pembiayaan_is_exist">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                         <select name="fa_code" id="fa_code" class="medium m-wrap">
                            <option value="">PILIH</option>
                            <?php foreach ($petugas as $key):?>
                              <option value="<?php echo $key['fa_code'];?>"><?php echo $key['fa_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Resort</label>
                       <div class="controls">
                         <select id="resort_code" name="resort_code" class="medium m-wrap">
                          <option value="">PILIH</option>
                           <?php foreach($resorts as $resort){ ?>
                           <option value="<?php echo $resort['resort_code']; ?>"><?php echo $resort['resort_name']; ?></option>
                           <?php } ?>
                         </select>
                         <!-- <input type="text" class="m-wrap medium" id="resort_name" name="resort_name" readonly="readonly" style="background:#eee;"> -->
                         <!-- <input type="hidden" id="resort_code" name="resort_code"> -->
                       </div>
                    </div>
                    <div class="control-group">
                      <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
                      <input type="hidden" id="cif_type_hidden" name="cif_type_hidden">
                       <label class="control-label">No Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <?php foreach ($grace as $data):?>
                          <input type="hidden" id="grace_kelompok" name="grace_kelompok" value="<?php echo $data['grace_period_kelompok'];?>">
                          <?php endforeach?>
                          <input type="text" name="registration_no" id="registration_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <!-- <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                      <option value="">Pilih Tipe CIF</option>
                                      <option value="">All</option>
                                      <option value="1">Individu</option>
                                      <option value="0">Kelompok</option>
                                      </select></p>  
                                      <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->

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
                                <button type="button" id="select" class="btn blue">Select</button>
                             </div>
                          </div>

                        <!-- <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a> -->
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">CIF No</label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code" name="branch_code">
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                        <label style="width:90px;padding-top:6px;text-align:right;display:inline-block;padding-right: 10px;">Tanggal Lahir</label>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>  
                    <hr>             
                    <div id="saving" style="display:none;"> 
                    <div class="control-group">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving" name="account_saving" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                          </select>
                       </div>
                    </div>                   
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product" name="product" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                          </select>
                          <!-- <input type="text" name="product" id="product" class="medium m-wrap" readonly="" style="background-color:#eee;"/> -->
                          <!-- <input type="hidden" name="kode_product" id="kode_product"/> -->
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <div id="error_account"></div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Akad<span class="required">*</span></label>
                       <div class="controls">
                        <select id="akad" name="akad" class="medium m-wrap" readonly>
                            <option value="">PILIH</option>
                             <?php foreach($akad as $data):?>
                          <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                        <?php endforeach?>
                          </select>   
                       </div>
                    </div>          

                    <!-- <div class="control-group">
                       <label class="control-label">Periode Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="periode_angsuran" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Harian</option>                    
                            <option value="1">Mingguan</option>                    
                            <option value="2">Bulanan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>          -->
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" value="0"  class=" m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="3" style="width:30px;"/>
                        <select id="periode_angsuran" name="periode_angsuran" class="small m-wrap" data-required="1">                     
                          <option value="">PILIH</option>                    
                          <option value="0">Harian</option>                    
                          <option value="1">Mingguan</option>                    
                          <option value="2">Bulanan</option>                    
                          <option value="3">Jatuh Tempo</option>
                        </select>
                        <span class="help-inline"></span></div>
                    </div>      

                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka" id="uang_muka" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="nilai_pembiayaan" id="nilai_pembiayaan" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Titipan Notaris<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="titipan_notaris" id="titipan_notaris" value="0">
                             <input type="hidden" id="titipan_notaris_val" value="<?php echo number_format($biaya_notaris,0,',','.'); ?>">
                             <span class="add-on">,00</span>
                             <span style="line-height:30px;margin-left:10px;"><input type="checkbox" id="titipan_notaris_check"></span>
                           </div>
                         </div>
                    </div>    
                  <div id="margin_p">     
                    <div class="control-group">
                       <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>    
                    </div>    
                  <div id="nisbah">     
                    <div class="control-group">
                       <label class="control-label">Nisbah Bagi Hasil<span class="required">*</span></label>
                       <div class="controls">
                             <input type="text" class="m-wrap" style="width:30px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5"> %
                         </div>
                    </div>  
                  </div>
                    <div class="control-group hide">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_pengajuan" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                       <div class="controls">
                          <!-- <input type="text" name="tgl_akad" id="mask_date" value="" class="small m-wrap"/> -->
                          <input type="text" name="tgl_akad" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy" />
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="angsuranke1" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_jtempo" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>
                    <hr>  
                    <div class="control-group">
                       <label class="control-label">Jadwal Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="jadwal_angsuran" name="jadwal_angsuran" class="medium m-wrap" readonly>                     
                            <option value="">PILIH</option>                    
                            <option value="1">Reguler</option>                    
                            <option value="0">Non Reguler</option> 
                          </select>
                       </div> 
                    </div>
                    <div id="reg" style="display:none;">
                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="20%" style="text-align:center;">Tanggal (dd/mm/yyyy)</th>
                               <th width="20%" style="text-align:center;">Angsuran Pokok</th>
                               <th width="20%" style="text-align:center;">Angsuran Margin</th>
                               <th width="20%" style="text-align:center;">Angsuran Tabungan</th>
                               <th width="10%" style="text-align:center;">Simpan</th>
                               <th width="10%" style="text-align:center;">Hapus</th>
                            </tr>
                         </thead>
                         <tbody>
                          <tr></tr>
                         </tbody>
                         <tfoot>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" class="m-wrap mask_date mask-money" id="Vangs_tanggal">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_pokok">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_margin">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_tabungan">
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_add"><img src="<?php echo base_url('assets/img/yes.png'); ?>"></a>
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="Vangs_delete"><img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26"></a>
                              </td>
                            </tr>
                         </tfoot>
                      </table>



                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="27%" style="vertical-align:middle;text-align:center;">Total Angsuran</th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_pokok" name="total_angs_pokok[]" value="0">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_margin" name="total_angs_margin[]" value="0">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_tabungan" name="total_angs_tabungan[]" value="0">
                               </th>
                               <th width="20%" style="text-align:center;"></th>
                            </tr>
                         </thead>
                      </table>

                    </div>
                    <div id="non_reg">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;" name="angsuran_pokok" id="angsuran_pokok" maxlength="12">
                             <span class="add-on">,00</span>
                             </div>
                           </div>
                         </div>    
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;" name="angsuran_margin" id="angsuran_margin" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="angsuran_tabungan" id="angsuran_tabungan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>        
                    <div class="control-group" id="div_tabungan_wajib">
                       <label class="control-label">Tabungan Wajib</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_wajib" id="tabungan_wajib" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>        
                    <div class="control-group" id="div_tabungan_kelompok">
                       <label class="control-label">Tabungan Kelompok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_kelompok" id="tabungan_kelompok" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>      
                      <div class="control-group">
                         <label class="control-label">Total Angsuran</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  name="total_angsuran" id="total_angsuran" maxlength="12" readonly="" value="0">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                    </div>  
                    <hr>     
                    <div class="control-group">
                       <label class="control-label">Simpanan Wajib Pinjam</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="simpanan_wajib_pinjam" id="simpanan_wajib_pinjam" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hide">
                       <label class="control-label">Cadangan Resiko</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="cadangan_resiko" id="cadangan_resiko" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hide">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="hidden" name="dana_kebajikan" id="dana_kebajikan" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_administrasi" id="biaya_administrasi" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Jasa Layanan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_jasa_layanan" id="biaya_jasa_layanan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Biaya ADM</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;background-color:#EEE;" name="total_biaya" id="total_biaya" maxlength="12" readonly="readonly" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_notaris" id="biaya_notaris" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jiwa" id="p_asuransi_jiwa" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jaminan" id="p_asuransi_jaminan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div id="id_jaminan" style="display:none;"> 
                      <hr> 
                      <h5>:: Jaminan Primer</h5>   
                      <div class="control-group">
                         <label class="control-label">Jaminan <span class="required">*</span></label>
                         <div class="controls">
                            <select id="jaminan" name="jaminan" class="medium m-wrap">                     
                              <option value="">PILIH</option>
                              <?php foreach ($jaminan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>
                            </select>
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Keterangan Jaminan <span class="required">*</span></label>
                         <div class="controls">
                            <textarea class="medium m-wrap" name="keterangan_jaminan" id="keterangan_jaminan"></textarea>
                         </div>
                      </div>   
                      <div class="control-group">
                         <label class="control-label">Jumlah Jaminan<span class="required">*</span></label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="jumlah_jaminan" id="jumlah_jaminan" maxlength="2">
                          </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Taksasi <span class="required">*</span></label>
                         <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominal_taksasi" id="nominal_taksasi" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                      </div>
                      <div class="control-group">
                         <label class="control-label">Presentase Jaminan<span class="required">*</span></label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="presentase_jaminan" id="presentase_jaminan" maxlength="6">%
                          </div>
                      </div> 
                      <h5>:: Jaminan Sekunder</h5>
                      <div class="control-group">
                         <label class="control-label">Jaminan </label>
                         <div class="controls">
                            <select id="jaminan_sekunder" name="jaminan_sekunder" class="medium m-wrap">                     
                              <option value="">PILIH</option>
                              <?php foreach ($jaminan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>
                            </select>
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Keterangan Jaminan </label>
                         <div class="controls">
                            <textarea class="medium m-wrap" name="keterangan_jaminan_sekunder" id="keterangan_jaminan_sekunder"></textarea>
                         </div>
                      </div>   
                      <div class="control-group">
                         <label class="control-label">Jumlah Jaminan</label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="jumlah_jaminan_sekunder" id="jumlah_jaminan_sekunder" maxlength="3">
                          </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Taksasi </label>
                         <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominal_taksasi_sekunder" id="nominal_taksasi_sekunder" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                      </div>
                      <div class="control-group">
                         <label class="control-label">Presentase Jaminan</label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="presentase_jaminan_sekunder" id="presentase_jaminan_sekunder" maxlength="6">%
                          </div>
                      </div>  
                    </div> 
                    <!-- <hr>      -->
                    <div class="control-group hide">
                       <label class="control-label">Sumber Dana Pembiayaan <span class="required">*</span></label>
                       <div class="controls">
                          <select id="sumber_dana_pembiayaan" name="sumber_dana_pembiayaan" class="medium m-wrap">                     
                            <!-- <option value="">PILIH</option> -->
                            <option value="0">Sendiri</option>
                            <!-- <option value="1">Kreditur</option> -->
                            <!-- <option value="2">Campuran</option> -->
                          </select>
                       </div>
                    </div>    
                    <div id="sendiri" class="hide"> <!-- begin dana sendiri -->
                      <div class="control-group">
                         <label class="control-label">Dana Sendiri</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" readonly="" style="background-color:#eee;width:120px;" style="width:120px;" name="dana_sendiri" id="dana_sendiri" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                    </div>  <!-- end dana sendiri -->
                    <div id="sendiri_campuran" class="hide"> <!-- begin dana sendiri & campuran -->
                      <div class="control-group">
                         <label class="control-label">Dana Sendiri</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri" id="dana_sendiri_campuran" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                    </div> <!-- end dana sendiri & campuran -->
                    <div id="kreditur" class="hide"> <!-- begin dana kreditur -->
                      <div class="control-group">
                         <label class="control-label">Dana Kreditur</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Kreditur</label>
                         <div class="controls">
                               <select id="kreditur_code1" name="kreditur_code1">
                                <option value="">PILIH</option>
                                <?php foreach($kreditur as $lembaga): ?>
                                 <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                                <?php endforeach; ?>
                               </select>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Ujroh Kreditur</label>
                         <div class="controls">
                          <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> % Keuntungan
                          &nbsp;
                          <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> / Angsuran
                          <span class="help-inline"></span></div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Pembayaran Kreditur</label>
                         <div class="controls">
                            <select id="pembayaran_kreditur" name="pembayaran_kreditur" class="medium m-wrap">                     
                              <option value="">PILIH</option>                     
                              <option value="0">Sesuai Angsuran</option>                     
                              <option value="1">Sekaligus</option>
                            </select>
                         </div>
                      </div>    
                    </div> <!-- end dana kreditur -->
                    <div id="kreditur_campuran" class="hide"> <!-- begin dana kreditur & campuran -->
                      <div class="control-group">
                         <label class="control-label">Dana Kreditur</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Kreditur</label>
                         <div class="controls">
                               <select id="kreditur_code2" name="kreditur_code2">
                                <option value="">PILIH</option>
                                <?php foreach($kreditur as $lembaga): ?>
                                 <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                                <?php endforeach; ?>
                               </select>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Ujroh Kreditur</label>
                         <div class="controls">
                          <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> % Keuntungan
                          &nbsp;
                          <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> / Angsuran
                          <span class="help-inline"></span></div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Pembayaran Kreditur</label>
                         <div class="controls">
                            <select id="pembayaran_kreditur2" name="pembayaran_kreditur2" class="medium m-wrap">                     
                              <option value="">PILIH</option>                     
                              <option value="0">Sesuai Angsuran</option>                     
                              <option value="1">Sekaligus</option>
                            </select>
                         </div>
                      </div>    
                    </div> <!-- end dana kreditur & campuran -->
                    <hr>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Program  Khusus <span class="required">*</span></label>
                       <div class="controls">
                          <select id="program_khusus" name="program_khusus" class="medium m-wrap">                     
                            <option value="1">Tidak</option>
                            <option value="0">Ya</option>                    
                          </select>
                       </div>
                    </div> 
                    <div id="program">  
                    <div class="control-group">
                       <label class="control-label">Jenis Program</label>
                       <div class="controls">
                          <select id="jenis_program" name="jenis_program" class="medium m-wrap">                     
                            <option value="">PILIH</option> 
                            <?php foreach($jenis_program as $data): ?>
                              <option value="<?php echo $data['program_code'];?>"><?php echo $data['program_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektor_ekonomi" name="sektor_ekonomi" class="medium m-wrap">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan</label>
                       <div class="controls">
                        <select id="peruntukan_pembiayaan" name="peruntukan_pembiayaan" class="medium m-wrap">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah ?</label>
                       <div class="controls">
                        <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap">                     
                          <!-- <option value="">Pilih</option> -->
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                        <!-- <input type="text" class="small m-wrap" readonly="" style="background-color:#eee;" value="Ya" /> -->
                       </div>
                    </div> 
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD  -->




<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Data Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id2" name="account_financing_reg_id2">
          <input type="hidden" id="cif_type_hidden2" name="cif_type_hidden2">
          <input type="hidden" id="account_financing_id" name="account_financing_id">
          <input type="hidden" id="manfaat_asuransi" name="manfaat_asuransi">
          <input type="hidden" id="product_asuransi" name="product_asuransi">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Account Financing Successful!
            </div>
            </br>
                    <?php foreach ($grace as $data):?>
                    <input type="hidden" id="grace_kelompok" name="grace_kelompok" value="<?php echo $data['grace_period_kelompok'];?>">
                    <?php endforeach?>
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                         <select name="fa_code" id="fa_code" class="medium m-wrap">
                            <option value="">PILIH</option>
                            <?php foreach ($petugas as $key):?>
                              <option value="<?php echo $key['fa_code'];?>"><?php echo $key['fa_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Resort</label>
                       <div class="controls">
                         <select id="resort_code2" name="resort_code2" class="m-wrap medium">
                         <option value="">PILIH</option>
                           <?php foreach($resorts as $resort){ ?>
                           <option value="<?php echo $resort['resort_code']; ?>"><?php echo $resort['resort_name']; ?></option>
                           <?php } ?>
                         </select>
                         <!-- <input type="text" class="m-wrap medium" id="resort_name2" name="resort_name2" readonly="readonly" style="background:#eee;"> -->
                         <!-- <input type="hidden" id="resort_code2" name="resort_code2"> -->
                       </div>
                    </div>
                   <div class="control-group">
                       <label class="control-label">No Pengajuan</label>
                       <div class="controls">
                          <input type="text" name="registration_no2" id="registration_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">No Customer</label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no2" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code2" name="branch_code2">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                        <label style="width:90px;padding-top:6px;text-align:right;display:inline-block;padding-right: 10px;">Tanggal Lahir</label>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>   
                    <hr>                
                    <div id="saving2" style="display:none;"> 
                    <div class="control-group">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving2" name="account_saving" class="medium m-wrap">                     
                          </select>
                       </div>
                    </div>                   
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product2" name="product" class="medium m-wrap">       
                          </select>
                          <!-- <input type="text" name="product" id="product2" class="medium m-wrap" readonly="" style="background-color:#eee;"/> -->
                          <!-- <input type="hidden" name="kode_product" id="kode_product2"/> -->
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Akad<span class="required">*</span></label>
                       <div class="controls">
                          <select id="akad2" name="akad" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <?php foreach($akad as $data): ?>
                              <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>          
                    <!-- <div class="control-group">
                       <label class="control-label">Periode Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="periode_angsuran2" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Harian</option>                    
                            <option value="1">Mingguan</option>                    
                            <option value="2">Bulanan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div> -->         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" value="0" class=" m-wrap" name="jangka_waktu" id="jangka_waktu2" maxlength="3" style="width:30px;"/>
                        <select id="periode_angsuran2" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                          <option value="">PILIH</option>                    
                          <option value="0">Harian</option>                    
                          <option value="1">Mingguan</option>                    
                          <option value="2">Bulanan</option>                    
                          <option value="3">Jatuh Tempo</option>
                        </select>
                        <span class="help-inline"></span></div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka" id="uang_muka2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="nilai_pembiayaan" id="nilai_pembiayaan2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Titipan Notaris<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="titipan_notaris" id="titipan_notaris2" value="0">
                             <input type="hidden" id="titipan_notaris_val2" value="<?php echo number_format($biaya_notaris,0,',','.'); ?>">
                             <span class="add-on">,00</span>
                             <span style="line-height:30px;margin-left:10px;"><input type="checkbox" id="titipan_notaris_check2"></span>
                           </div>
                         </div>
                    </div>  
                  <div id="margin_p2">      
                    <div class="control-group">
                       <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan2" maxlength="15">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>    
                    </div>    
                  <div id="nisbah2">     
                    <div class="control-group">
                       <label class="control-label">Nisbah Bagi Hasil<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" style="width:60px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>  
                    </div>
                    <div class="control-group hide">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi_edit" id="mask_date" class="small m-wrap" placeholder="dd/mm/yyyy"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_pengajuan_edit" id="mask_date" class="small m-wrap" placeholder="dd/mm/yyyy"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_akad_edit" id="mask_date" class="small m-wrap" placeholder="dd/mm/yyyy"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="angsuranke1_edit" id="mask_date" class="small m-wrap" placeholder="dd/mm/yyyy"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_jtempo_edit" id="mask_date" class="small m-wrap" placeholder="dd/mm/yyyy"/>
                       </div>
                    </div>
                    <hr>  
                    <div class="control-group">
                       <label class="control-label">Jadwal Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="jadwal_angsuran2" name="jadwal_angsuran" class="medium m-wrap" readonly>                     
                            <option value="">PILIH</option>                    
                            <option value="1">Reguler</option>                    
                            <option value="0">Non Reguler</option> 
                          </select>
                       </div> 
                    </div>
                    <div id="reg2" style="display:none;">
                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="20%" style="text-align:center;">Tanggal (dd/mm/yyyy)</th>
                               <th width="20%" style="text-align:center;">Angsuran Pokok</th>
                               <th width="20%" style="text-align:center;">Angsuran Margin</th>
                               <th width="20%" style="text-align:center;">Angsuran Tabungan</th>
                               <th width="10%" style="text-align:center;">Simpan</th>
                               <th width="10%" style="text-align:center;">Hapus</th>
                            </tr>
                         </thead>
                         <tbody>
                          <tr></tr>
                         </tbody>
                         <tfoot>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" class="m-wrap mask_date mask-money" id="Vangs_tanggal">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_pokok">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_margin">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_tabungan">
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_add"><img src="<?php echo base_url('assets/img/yes.png'); ?>"></a>
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="Vangs_delete"><img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26"></a>
                              </td>
                            </tr>
                         </tfoot>
                      </table>



                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="27%" style="vertical-align:middle;text-align:center;">Total Angsuran</th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_pokok" name="total_angs_pokok[]" value="0">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_margin" name="total_angs_margin[]" value="0">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text"  style="background-color:#eee;width:190px;" maxlength="12" class="m-wrap mask-money" id="total_angs_tabungan" name="total_angs_tabungan[]" value="0">
                               </th>
                               <th width="20%" style="text-align:center;"></th>
                            </tr>
                         </thead>
                      </table>

                    </div>
                    <div id="non_reg2">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="angsuran_pokok" id="angsuran_pokok2" maxlength="12" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="angsuran_margin" id="angsuran_margin2" maxlength="12" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="angsuran_tabungan" id="angsuran_tabungan2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>            
                    <div class="control-group" id="div_tabungan_wajib2">
                       <label class="control-label">Tabungan Wajib</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_wajib" id="tabungan_wajib2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>        
                    <div class="control-group" id="div_tabungan_kelompok2">
                       <label class="control-label">Tabungan Kelompok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_kelompok" id="tabungan_kelompok2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="total_angsuran" readonly="" id="total_angsuran2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    </div>
                    <hr>     
                    <div class="control-group">
                       <label class="control-label">Simpanan Wajib Pinjam</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="simpanan_wajib_pinjam" id="simpanan_wajib_pinjam2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hide">
                       <label class="control-label">Cadangan Resiko</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="cadangan_resiko" id="cadangan_resiko" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hide">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="hidden" name="dana_kebajikan" id="dana_kebajikan">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_administrasi" id="biaya_administrasi" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Biaya Jasa Layanan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_jasa_layanan" id="biaya_jasa_layanan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Biaya ADM</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;background-color:#EEE;" name="total_biaya" id="total_biaya" maxlength="12" readonly="readonly" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_notaris" id="biaya_notaris" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jiwa" id="p_asuransi_jiwa" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jaminan" id="p_asuransi_jaminan" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div id="id_jaminan"> 
                      <hr>
                      <h5>:: Jaminan Primer</h5>
                      <div class="control-group">
                         <label class="control-label">Jaminan <span class="required">*</span></label>
                         <div class="controls">
                            <select id="jaminan2" name="jaminan" class="medium m-wrap">                     
                              <option value="">PILIH</option>
                              <?php foreach ($jaminan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>
                            </select>
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Keterangan Jaminan <span class="required">*</span></label>
                         <div class="controls">
                            <textarea class="medium m-wrap" name="keterangan_jaminan" id="keterangan_jaminan2"></textarea>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Jumlah Jaminan<span class="required">*</span></label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="jumlah_jaminan" id="jumlah_jaminan" maxlength="2">
                          </div>
                      </div>   
                      <div class="control-group">
                         <label class="control-label">Taksasi <span class="required">*</span></label>
                         <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominal_taksasi" id="nominal_taksasi2" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Presentase Jaminan<span class="required">*</span></label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="presentase_jaminan" id="presentase_jaminan" maxlength="6">%
                          </div>
                      </div> 
                      <h5>:: Jaminan Sekunder</h5>
                      <div class="control-group">
                         <label class="control-label">Jaminan </label>
                         <div class="controls">
                            <select id="jaminan_sekunder2" name="jaminan_sekunder" class="medium m-wrap">                     
                              <option value="">PILIH</option>
                              <?php foreach ($jaminan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>
                            </select>
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Keterangan Jaminan </label>
                         <div class="controls">
                            <textarea class="medium m-wrap" name="keterangan_jaminan_sekunder" id="keterangan_jaminan_sekunder2"></textarea>
                         </div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Jumlah Jaminan</label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="jumlah_jaminan_sekunder" id="jumlah_jaminan_sekunder" maxlength="2">
                          </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Taksasi </label>
                         <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominal_taksasi_sekunder" id="nominal_taksasi_sekunder2" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                      </div>
                      <div class="control-group">
                         <label class="control-label">Presentase Jaminan</label>
                         <div class="controls">
                             <input type="text" class="m-wrap" style="width:50px;" name="presentase_jaminan_sekunder" id="presentase_jaminan_sekunder" maxlength="6">%
                          </div>
                      </div> 
                    </div> 
                    <!-- <hr>      -->
                    <div class="control-group hide">
                       <label class="control-label">Sumber Dana Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                          <select id="sumber_dana_pembiayaan2" name="sumber_dana_pembiayaan" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <option value="0">Sendiri</option>
                            <option value="1">Kreditur</option>
                            <option value="2">Campuran</option>
                          </select>
                       </div>
                    </div>    
                    <div id="sendiri2" class="hide"> <!-- begin dana sendiri -->
                      <div class="control-group">
                         <label class="control-label">Dana Sendiri</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" readonly=""  style="background-color:#eee;width:120px;" style="width:120px;" name="dana_sendiri" id="dana_sendiri" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div>  
                    </div> <!-- end dana sendiri -->
                    <div id="sendiri_campuran2" class="hide"> <!-- begin dana sendiri & campuran -->
                      <div class="control-group">
                         <label class="control-label">Dana Sendiri</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri" id="dana_sendiri_campuran" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div>  
                    </div> <!-- end dana sendiri & campuran -->
                    <div id="kreditur2" class="hide"> <!-- begin dana kreditur -->
                      <div class="control-group">
                         <label class="control-label">Dana Kreditur</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Kreditur</label>
                         <div class="controls">
                               <select id="kreditur_code21" name="kreditur_code21">
                                <option value="">PILIH</option>
                                <?php foreach($kreditur as $lembaga): ?>
                                 <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                                <?php endforeach; ?>
                               </select>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Ujroh Kreditur</label>
                         <div class="controls">
                          <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> % Keuntungan
                          &nbsp;
                          <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> / Angsuran
                          <span class="help-inline"></span></div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Pembayaran Kreditur</label>
                         <div class="controls">
                            <select id="pembayaran_kreditur" name="pembayaran_kreditur" class="medium m-wrap">                     
                              <option value="">PILIH</option>                     
                              <option value="0">Sesuai Angsuran</option>                     
                              <option value="1">Sekaligus</option>
                            </select>
                         </div>
                      </div>    
                    </div>
                    <div id="kreditur2_campuran">
                      <div class="control-group">
                         <label class="control-label">Dana Kreditur</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Kreditur</label>
                         <div class="controls">
                               <select id="kreditur_code22" name="kreditur_code22">
                                <option value="">PILIH</option>
                                <?php foreach($kreditur as $lembaga): ?>
                                 <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                                <?php endforeach; ?>
                               </select>
                           </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Ujroh Kreditur</label>
                         <div class="controls">
                          <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> % Keuntungan
                          &nbsp;
                          <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> / Angsuran
                          <span class="help-inline"></span></div>
                      </div>    
                      <div class="control-group">
                         <label class="control-label">Pembayaran Kreditur</label>
                         <div class="controls">
                            <select id="pembayaran_kreditur2" name="pembayaran_kreditur2" class="medium m-wrap">                     
                              <option value="">PILIH</option>                     
                              <option value="0">Sesuai Angsuran</option>                     
                              <option value="1">Sekaligus</option>
                            </select>
                         </div>
                      </div>    
                    </div> <!-- end dana kreditur -->
                    <hr>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Program  Khusus<span class="required">*</span></label>
                       <div class="controls">
                          <select id="program_khusus2" name="program_khusus" class="medium m-wrap">                     
                            <option value="1">Tidak</option>
                            <!-- <option value="">PILIH</option>                     -->
                            <!-- <option value="0">Ya</option>                     -->
                          </select>
                       </div>
                    </div> 
                    <div id="program2">  
                    <div class="control-group">
                       <label class="control-label">Jenis Program</label>
                       <div class="controls">
                          <select id="jenis_program" name="jenis_program" class="medium m-wrap">                     
                            <option value="">PILIH</option> 
                            <?php foreach($jenis_program as $data): ?>
                              <option value="<?php echo $data['program_code'];?>"><?php echo $data['program_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektor_ekonomi" name="sektor_ekonomi" class="medium m-wrap">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan</label>
                       <div class="controls">
                        <select id="peruntukan_pembiayaan" name="peruntukan_pembiayaan" class="medium m-wrap">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah ?</label>
                       <div class="controls">
                        <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap">                     
                          <!-- <option value="">Pilih</option> -->
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>                        
                        <!-- <input type="text" class="small m-wrap" readonly="" style="background-color:#eee;" value="Ya" /> -->
                       </div>
                    </div> 
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
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

/*************************************/
/* BEGIN SAYYID SCRIPT */
/*************************************/
$(function(){
  $("#simpanan_wajib_pinjam,#biaya_administrasi,#biaya_jasa_layanan","#form_add").keyup(function(){
    calc_total_biaya_adm_add();
  })
  $("#simpanan_wajib_pinjam2,#biaya_administrasi,#biaya_jasa_layanan","#form_edit").keyup(function(){
    calc_total_biaya_adm_edit();
  })
})

function calc_total_biaya_adm_add()
{
  simpanan_wajib_pinjam = parseFloat(convert_numeric($("#simpanan_wajib_pinjam","#form_add").val()));
  biaya_administrasi = parseFloat(convert_numeric($("#biaya_administrasi","#form_add").val()));
  biaya_jasa_layanan = parseFloat(convert_numeric($("#biaya_jasa_layanan","#form_add").val()));
  total_biaya=simpanan_wajib_pinjam+biaya_administrasi+biaya_jasa_layanan;
  $("#total_biaya","#form_add").val(number_format(total_biaya,0,',','.'));
}
function calc_total_biaya_adm_edit()
{
  simpanan_wajib_pinjam = parseFloat(convert_numeric($("#simpanan_wajib_pinjam2","#form_edit").val()));
  biaya_administrasi = parseFloat(convert_numeric($("#biaya_administrasi","#form_edit").val()));
  biaya_jasa_layanan = parseFloat(convert_numeric($("#biaya_jasa_layanan","#form_edit").val()));
  total_biaya=simpanan_wajib_pinjam+biaya_administrasi+biaya_jasa_layanan;
  $("#total_biaya","#form_edit").val(number_format(total_biaya,0,',','.'));
}


var global_rate_simpanan_wajib_pinjam = 0;
function calc_simpanan_wajib_pinjam(form)
{
  var plafon = (isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan",form).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan",form).val()));
  var simpanan_wajib_pinjam = plafon*global_rate_simpanan_wajib_pinjam/100;
  $("#simpanan_wajib_pinjam",form).val(number_format(simpanan_wajib_pinjam,0,',','.'));
  console.log(simpanan_wajib_pinjam);
  console.log(form);
  calc_total_biaya_adm_add();
}
$("input#titipan_notaris").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
})
$("input#titipan_notaris_check").click(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
})
$("input[name='tgl_registrasi']").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
})
$("input[name='tgl_jtempo']").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
})

var global_rate_simpanan_wajib_pinjam_edit = 0;
function calc_simpanan_wajib_pinjam_edit(form)
{
  var plafon = (isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan2",form).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan2",form).val()));
  var simpanan_wajib_pinjam = plafon*global_rate_simpanan_wajib_pinjam_edit/100;
  $("#simpanan_wajib_pinjam2",form).val(number_format(simpanan_wajib_pinjam,0,',','.'));
  console.log(simpanan_wajib_pinjam);
  console.log(form);
  calc_total_biaya_adm_edit();
}
$("input#titipan_notaris2").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
})
$("input#titipan_notaris_check2").click(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
})
$("input[name='tgl_registrasi_edit']").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
})
$("input[name='tgl_jtempo_edit']").keyup(function(){
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
})

var set_tanggal_jatuh_tempo_edit = function(periode_angsuran,jangka_waktu,angsuranpertama){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranpertama:angsuranpertama},
    url: site_url+"cif/ajax_get_tanggal_jatuh_tempo2",
    success: function(response){
      $("input[name='tgl_jtempo_edit']","#form_edit").val(response.jatuh_tempo);
    }
  });
}

var set_biaya_administrasi_edit = function(tgl_jtempo,tgl_akad,product,nilai_pembiayaan)
{
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_administrasi",
    type: "POST",
    dataType: "json",
    async: false,
    data: {tgl_jtempo:tgl_jtempo,tgl_akad:tgl_akad,product:product,nilai_pembiayaan:nilai_pembiayaan},
    success: function(response)
    {
        $("input[name='biaya_administrasi']","#form_edit").val(number_format(response.biaya_administrasi,0,'',''));
        calc_total_biaya_adm_edit();
    }
  })
}

var set_biaya_jasa_layanan_edit = function(nilai_pembiayaan,product)
{
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_jasa_layanan",
    type: "POST",
    async: false,
    dataType: "json",
    data: {nilai_pembiayaan:nilai_pembiayaan,product:product},
    success: function(response)
    {
      if(response.biaya_jasa_layanan==0){
        biaya_jasa_layanan='0';
      }else{
        biaya_jasa_layanan=number_format(response.biaya_jasa_layanan,0,',','.');
      }
      $("input[name='biaya_jasa_layanan']","#form_edit").val(biaya_jasa_layanan);
      calc_total_biaya_adm_edit();
    }
  })
}

var set_biaya_premi_asuransi_jiwa_edit = function(product,manfaat_asuransi,tgl_lahir,tgl_akad,tgl_jtempo,usia){
  console.log('e')
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      product:product
      ,manfaat_asuransi:manfaat_asuransi
      ,tgl_lahir:tgl_lahir
      ,tgl_akad:tgl_akad
      ,tgl_jtempo:tgl_jtempo
      ,usia:usia
    },
    success: function(response)
    {
        $("input[name='p_asuransi_jiwa']","#form_edit").val(number_format(response.p_asuransi_jiwa,0,'',''));
    }
  })
}

var set_tanggal_angsuran_ke1_edit = function(periode_angsuran,tgl_akad){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    // data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,tgl_akad:tgl_akad,grace_kelompok:grace_kelompok},
    // data: {periode_angsuran:periode_angsuran,tgl_akad:tgl_akad,grace_kelompok_hari:grace_kelompok_hari,grace_kelompok_minggu:grace_kelompok_minggu,grace_kelompok_bulan:grace_kelompok_bulan},
    data: {periode_angsuran:periode_angsuran,tgl_akad:tgl_akad},
    url: site_url+"cif/ajax_get_tanggal_angsur_pertama",
    success: function(response){
      $("input[name='angsuranke1_edit']","#form_edit").val(response.angsuranke1);
    }
  });
}

var set_tanggal_akad_edit = function(tgl_pengajuan,periode_angsuran){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    data: {tgl_pengajuan:tgl_pengajuan,periode_angsuran:periode_angsuran},
    url: site_url+"transaction/ajax_get_tanggal_akad2",
    success: function(response){
      $("input[name='tgl_akad_edit']","#form_edit").val(response.tgl_akad);
    }
  });
}
/*************************************/
/* END SAYYID SCRIPT */
/*************************************/

//Untuk Add
var global_min_nominal_margin = 0;
var global_max_nominal_margin = 0;

var global_rate_margin_min=0;
var global_rate_margin_max=0;

//Untuk Edit
var global_min_nominal_margin_edit = 0;
var global_max_nominal_margin_edit = 0;

var global_rate_margin_min_edit=0;
var global_rate_margin_max_edit=0;

/* ADD */
$("#titipan_notaris_check").click(function(){
  if($(this).is(':checked')==true){
    titipan_notaris_val=$("#titipan_notaris_val").val();
    $("#titipan_notaris","#form_add").val(titipan_notaris_val);
  }else{
    $("#titipan_notaris","#form_add").val(0);
  }
  $("#titipan_notaris","#form_add").focus();
});

$("#titipan_notaris_check2").click(function(){
  if($(this).is(':checked')==true){
    titipan_notaris_val=$("#titipan_notaris_val2").val();
    $("#titipan_notaris2","#form_edit").val(titipan_notaris_val);
  }else{
    $("#titipan_notaris2","#form_edit").val(0);
  }
  $("#titipan_notaris2","#form_edit").focus();
});

$("#kreditur_code1,#kreditur_code2","#form_add").change(function(){
  if($(this).val()!=""){
    $.ajax({
      url: site_url+"rekening_nasabah/get_program_khusus",
      type: "POST",
      dataType:"json",
      data: {
        program_owner_code:$(this).val()
      },
      success: function(response){
        html ='<option value="">PILIH</option>';
        for(i in response){
          html += '<option value="'+response[i].program_code+'">'+response[i].program_name+'</option>';
        }
        $("#jenis_program","#form_add").html(html);
      }
    })
  }
});
$("#kreditur_code21,#kreditur_code22","#form_edit").change(function(){
  if($(this).val()!=""){
    $.ajax({
      url: site_url+"rekening_nasabah/get_program_khusus",
      type: "POST",
      dataType:"json",
      data: {
        program_owner_code:$(this).val()
      },
      success: function(response){
        html ='<option value="">PILIH</option>';
        for(i in response){
          html += '<option value="'+response[i].program_code+'">'+response[i].program_name+'</option>';
        }
        $("#jenis_program","#form_edit").html(html);
      }
    })
  }
});

// EDIT EVENT
// $("input#Vangs_pokok","#form_edit").live('keyup',function(){
//   var angs_pokok = parseFloat(convert_numeric($("#total_angs_pokok","#form_edit").val()))
//   $("input#Vangs_pokok","#form_edit").each(function(){
//     angs_pokok += parseFloat(convert_numeric($(this).val()))
//   });
//   if(isNaN(angs_pokok)==true){
//     angs_pokok = 0;
//   }
//   $("#total_angs_pokok","#form_edit").val(number_format(angs_pokok,0,',','.'))
// });

// $("input#Vangs_margin","#form_edit").live('keyup',function(){
//   var angs_margin = parseFloat(convert_numeric($("#total_angs_margin","#form_edit").val()))
//   $("input#Vangs_margin","#form_edit").each(function(){
//     angs_margin += parseFloat(convert_numeric($(this).val()))
//   });
//   if(isNaN(angs_margin)==true){
//     angs_margin = 0;
//   }
//   $("#total_angs_margin","#form_edit").val(number_format(angs_margin,0,',','.'))
// });

// $("input#Vangs_tabungan","#form_edit").live('keyup',function(){
//   var angs_tabungan = parseFloat(convert_numeric($("#total_angs_tabungan","#form_edit").val()))
//   $("input#Vangs_tabungan","#form_edit").each(function(){
//     angs_tabungan += parseFloat(convert_numeric($(this).val()))
//   });
//   if(isNaN(angs_tabungan)==true){
//     angs_tabungan = 0;
//   }
//   $("#total_angs_tabungan","#form_edit").val(number_format(angs_tabungan,0,',','.'))
// });

/* event of tanggal angsuran ke-1 (on edit form) */
$("input[name='angsuranke1_edit'],input[name='tgl_akad_edit']","#form_edit").change(function(){
  // declare
  var periode_angsuran = $("#periode_angsuran2","#form_edit").val();
  var jangka_waktu = $("#jangka_waktu2","#form_edit").val();
  
  var tgl_akad = $("input[name='tgl_akad_edit']","#form_edit").val();  
  var product = $("#product2","#form_edit").val();
  var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
  var product_asuransi = $("#product2 option:selected","#form_edit").attr('insuranceproductcode');  
  var flag_manfaat_asuransi = $("#product2 option:selected","#form_edit").attr('flagmanfaatasuransi');
  var tgl_lahir = $("#tgl_lahir","#form_edit").val();
  var usia = $("input[name='usia']","#form_edit").val();
  var pokok = parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
  var margin = parseFloat(convert_numeric($("#margin_pembiayaan2","#form_edit").val()));

  // modifikasi tanggal akad ke tanggal lang-en
  var day_tgl_akad = tgl_akad.replace(/\//g,'').substr(0,2);
  var month_tgl_akad = tgl_akad.replace(/\//g,'').substr(2,2);
  var year_tgl_akad = tgl_akad.replace(/\//g,'').substr(4,4);
  tgl_akad_en = year_tgl_akad+'-'+month_tgl_akad+'-'+day_tgl_akad;
  var periode_angsuran = $("#periode_angsuran2","#form_edit").val();

  if(angsuranke1!="" && periode_angsuran!="" && jangka_waktu!="")
  {
    switch(periode_angsuran){
      case "0":
      case "1":
      case "2":
      if($(this).attr('name')!='angsuranke1_edit'){
        set_tanggal_angsuran_ke1_edit(periode_angsuran,tgl_akad_en);
      }
      var angsuranke1 = $("input[name='angsuranke1_edit']","#form_edit").val().replace(/\//g,'');
      // modifikasi tanggal angsuran ke-1 ke tanggal lang-en
      var day_angsuranke1 = angsuranke1.substr(0,2);
      var month_angsuranke1 = angsuranke1.substr(2,2);
      var year_angsuranke1 = angsuranke1.substr(4,4);
      var angsuranpertama = year_angsuranke1+'-'+month_angsuranke1+'-'+day_angsuranke1;
      set_tanggal_jatuh_tempo_edit(periode_angsuran,jangka_waktu,angsuranpertama);
      break;
    }
    /* set biaya adm */
    var tgl_jtempo = $("input[name='tgl_jtempo_edit']","#form_edit").val();
    set_biaya_administrasi_edit(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
    set_biaya_jasa_layanan_edit(nilai_pembiayaan,product)
    /* set premi asuransi jiwa */
    var manfaat_asuransi = pokok;
    if(flag_manfaat_asuransi==0){
      manfaat_asuransi = pokok+margin;
    }
    set_biaya_premi_asuransi_jiwa_edit(product_asuransi,manfaat_asuransi,tgl_lahir,tgl_akad,tgl_jtempo,usia);
  }

  //Untuk memanggil  function simpanan wajib pinjam
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
  
});

/* event of jangka_waktu (on edit form) */
$("#jangka_waktu2","#form_edit").change(function(){
  var periode_angsuran = $("#periode_angsuran2","#form_edit").val();
  var jangka_waktu = parseFloat($("#jangka_waktu2","#form_edit").val());
  var angsuranke1 = $("input[name='angsuranke1_edit']","#form_edit").val().replace(/\//g,'');
  var pokok = parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
  // modifikasi tanggal angsuran ke-1 ke tanggal lang-en
  var day_angsuranke1 = angsuranke1.substr(0,2);
  var month_angsuranke1 = angsuranke1.substr(2,2);
  var year_angsuranke1 = angsuranke1.substr(4,4);
  var angsuranpertama = year_angsuranke1+'-'+month_angsuranke1+'-'+day_angsuranke1;
  if(jangka_waktu!="" && periode_angsuran!="" && angsuranke1!="")
  {
    set_tanggal_jatuh_tempo_edit(periode_angsuran,jangka_waktu,angsuranpertama);
  }

  /* set max margin pembiayaan (on edit form) */
  switch(periode_angsuran){
    case "0": //harian
      global_min_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_min_edit/3000);
      global_max_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_max_edit/3000);
      // global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/3000);
      // global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/3000);
    break;
    case "1": // mingguan
      global_min_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_min_edit/400);
      global_max_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_max_edit/400);
      // global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/400);
      // global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/400);
    break;
    case "2": //bulanan
      global_min_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_min_edit/100);
      global_max_nominal_margin_edit=(pokok*jangka_waktu)*(global_rate_margin_max_edit/100);
      // global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/100);
      // global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/100);
    break;
    case "3": //jatuh tempo
      global_min_nominal_margin_edit=0;
      global_max_nominal_margin_edit=999999999999999;
    break;
  }

  console.log('pokok_edit:'+pokok);
  console.log('jangka_waktu_edit:'+jangka_waktu);
  console.log('global_rate_margin_min_edit:'+global_rate_margin_min_edit);
  console.log('global_rate_margin_max_edit:'+parseFloat(global_rate_margin_max_edit));
  if(parseFloat(global_rate_margin_max_edit)<100 && parseFloat(global_rate_margin_max_edit)!=0){
    console.log('global_max_nominal_margin_edit:'+global_max_nominal_margin)
    if(periode_angsuran==3){ // jatuh tempo
      $("#margin_pembiayaan2","#form_edit").val(0);
    }else{
      $("#margin_pembiayaan2","#form_edit").val(number_format(global_max_nominal_margin_edit,0,',','.'));
    }
  }

});

$("#periode_angsuran2","#form_edit").change(function(){
  $("#jangka_waktu2","#form_edit").trigger('change');
});


$("input[name='tgl_pengajuan_edit']","#form_edit").change(function(){ 
  var periode_angsuran = $("#periode_angsuran2","#form_edit").val();
  var tgl_pengajuan = $("input[name='tgl_pengajuan_edit']","#form_edit").val();
  var day1 = tgl_pengajuan.substr(0,2);
  var month1 = tgl_pengajuan.substr(3,2);
  var year1 = tgl_pengajuan.substr(6,4);
  tgl_pengajuan = year1+'-'+month1+'-'+day1;

  set_tanggal_akad_edit(tgl_pengajuan,periode_angsuran);

  $("input[name='tgl_akad_edit']").trigger('change');
  //Untuk memanggil  function simpanan wajib pinjam
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam_edit(form_id)
});

/************************************************************************************/

var set_tanggal_jatuh_tempo_add = function(periode_angsuran,jangka_waktu,angsuranpertama){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranpertama:angsuranpertama},
    url: site_url+"cif/ajax_get_tanggal_jatuh_tempo2",
    success: function(response){
      $("input[name='tgl_jtempo']","#form_add").val(response.jatuh_tempo);
    }
  });
}

var set_biaya_administrasi_add = function(tgl_jtempo,tgl_akad,product,nilai_pembiayaan)
{
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_administrasi",
    type: "POST",
    async: false,
    dataType: "json",
    data: {tgl_jtempo:tgl_jtempo,tgl_akad:tgl_akad,product:product,nilai_pembiayaan:nilai_pembiayaan},
    success: function(response)
    {
      $("input[name='biaya_administrasi']","#form_add").val(number_format(response.biaya_administrasi,0,'',''));
      calc_total_biaya_adm_add();
    }
  })
}

var set_biaya_jasa_layanan_add = function(nilai_pembiayaan,product)
{
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_jasa_layanan",
    type: "POST",
    async: false,
    dataType: "json",
    data: {nilai_pembiayaan:nilai_pembiayaan,product:product},
    success: function(response)
    {
      $("input[name='biaya_jasa_layanan']","#form_add").val(number_format(response.biaya_jasa_layanan,0,'',''));
      calc_total_biaya_adm_add();
    }
  })
}

var set_biaya_premi_asuransi_jiwa_add = function(product,manfaat_asuransi,tgl_lahir,tgl_akad,tgl_jtempo,usia){
  $.ajax({
    url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      product:product
      ,manfaat_asuransi:manfaat_asuransi
      ,tgl_lahir:tgl_lahir
      ,tgl_akad:tgl_akad
      ,tgl_jtempo:tgl_jtempo
      ,usia:usia
    },
    success: function(response)
    {
        $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
    }
  })
}

var set_tanggal_angsuran_ke1_add = function(periode_angsuran,tgl_akad){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    // data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,tgl_akad:tgl_akad,grace_kelompok:grace_kelompok},
    // data: {periode_angsuran:periode_angsuran,tgl_akad:tgl_akad,grace_kelompok_hari:grace_kelompok_hari,grace_kelompok_minggu:grace_kelompok_minggu,grace_kelompok_bulan:grace_kelompok_bulan},
    data: {periode_angsuran:periode_angsuran,tgl_akad:tgl_akad},
    url: site_url+"cif/ajax_get_tanggal_angsur_pertama",
    success: function(response){
      $("input[name='angsuranke1']","#form_add").val(response.angsuranke1);
    }
  });
}

var set_tanggal_akad_add = function(tgl_pengajuan,periode_angsuran){
  $.ajax({
    type: "POST",
    dataType: "json",
    async:false,
    data: {tgl_pengajuan:tgl_pengajuan,periode_angsuran:periode_angsuran},
    url: site_url+"transaction/ajax_get_tanggal_akad2",
    success: function(response){
      $("input[name='tgl_akad']","#form_add").val(response.tgl_akad);
    }
  });
}

// ADD EVENT
$("input#angs_pokok","#form_add").live('keyup',function(){
  var angs_pokok = 0;
  $("input#angs_pokok","#form_add").each(function(){
    angs_pokok += parseFloat(convert_numeric($(this).val()))
  });
  if(isNaN(angs_pokok)==true){
    angs_pokok = 0;
  }
  $("#total_angs_pokok","#form_add").val(number_format(angs_pokok,0,',','.'))
});

$("input#angs_margin","#form_add").live('keyup',function(){
  var angs_margin = 0;
  $("input#angs_margin","#form_add").each(function(){
    angs_margin += parseFloat(convert_numeric($(this).val()))
  });
  if(isNaN(angs_margin)==true){
    angs_margin = 0;
  }
  $("#total_angs_margin","#form_add").val(number_format(angs_margin,0,',','.'))
});

$("input#angs_tabungan","#form_add").live('keyup',function(){
  var angs_tabungan = 0;
  $("input#angs_tabungan","#form_add").each(function(){
    angs_tabungan += parseFloat(convert_numeric($(this).val()))
  });
  if(isNaN(angs_tabungan)==true){
    angs_tabungan = 0;
  }
  $("#total_angs_tabungan","#form_add").val(number_format(angs_tabungan,0,',','.'))
});



// $("input[name='tgl_akad']","#form_add").change(function(){
//   var tgl_akad = $(this).val().replace(/\//g,'');
//   var day = tgl_akad.substr(0,2);
//   var month = tgl_akad.substr(2,2);
//   var year = tgl_akad.substr(4,4);
//   tgl_akad = year+'-'+month+'-'+day;

//   // grace_kelompok = $("#grace_kelompok","#form_add").val();
//   // grace_kelompok_hari = grace_kelompok.substring(0,1);
//   // grace_kelompok_minggu = grace_kelompok.substring(2,1);
//   // grace_kelompok_bulan = grace_kelompok.substring(3,2);
//   var periode_angsuran = $("#periode_angsuran","#form_add").val();
//   var jangka_waktu = $("#jangka_waktu","#form_add").val();
//   if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
//   {
//     switch(periode_angsuran){
//       case "0":
//       case "1":
//       case "2":
//       set_tanggal_angsuran_ke1_add(periode_angsuran,tgl_akad);
//       break;
//     }
//   }

//   //Untuk memanggil  function simpanan wajib pinjam
//   form_id=$(this).closest('form').attr('id');
//   form_id=$("#"+form_id);
//   calc_simpanan_wajib_pinjam(form_id)
// });

$("input[name='angsuranke1'],input[name='tgl_akad']","#form_add").change(function(){
  var periode_angsuran = $("#periode_angsuran","#form_add").val();
  var jangka_waktu = $("#jangka_waktu","#form_add").val();
  var tgl_akad = $("input[name='tgl_akad']","#form_add").val();  
  var product = $("#product","#form_add").val();  
  var nilai_pembiayaan = convert_numeric($("#nilai_pembiayaan","#form_add").val());
  var angsuranke1name=$(this).attr('name');
  console.log('periode_angsuran:'+periode_angsuran);
  console.log('jangka_waktu:'+jangka_waktu);
  if(periode_angsuran!="" && jangka_waktu!="")
  {
    switch(periode_angsuran){
      case "0":
      case "1":
      case "2":
      console.log(angsuranke1name);
      if(angsuranke1name!='angsuranke1')
      {
        var tgl_akad_en = tgl_akad.replace(/\//g,'');
        var day_en = tgl_akad_en.substr(0,2);
        var month_en = tgl_akad_en.substr(2,2);
        var year_en = tgl_akad_en.substr(4,4);
        tgl_akad_en = year_en+'-'+month_en+'-'+day_en;
        set_tanggal_angsuran_ke1_add(periode_angsuran,tgl_akad_en);
      }
      var angsuranke1 = $("input[name='angsuranke1']","#form_add").val().replace(/\//g,'');
      var day_angsuranke1 = angsuranke1.substr(0,2);
      var month_angsuranke1 = angsuranke1.substr(2,2);
      var year_angsuranke1 = angsuranke1.substr(4,4);
      var angsuranpertama = year_angsuranke1+'-'+month_angsuranke1+'-'+day_angsuranke1;
      set_tanggal_jatuh_tempo_add(periode_angsuran,jangka_waktu,angsuranpertama);
      break;
    }
    var tgl_jtempo = $("input[name='tgl_jtempo']","#form_add").val();
    set_biaya_administrasi_add(tgl_jtempo,tgl_akad,product,nilai_pembiayaan)
    set_biaya_jasa_layanan_add(nilai_pembiayaan,product)
  }
  
  //Untuk memanggil  function simpanan wajib pinjam
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
});

$("#periode_angsuran","#form_add").change(function(){
  $("#jangka_waktu","#form_add").trigger('change');
})

$("#jangka_waktu","#form_add").change(function(){ 
  var jangka_waktu = $("#jangka_waktu","#form_add").val();
  var angsuranpertama = $("input[name='angsuranke1']","#form_add").val().replace(/\//g,'');
  var day1 = angsuranpertama.substr(0,2);
  var month1 = angsuranpertama.substr(2,2);
  var year1 = angsuranpertama.substr(4,4);
  angsuranpertama = year1+'-'+month1+'-'+day1;
  var periode_angsuran=$("#periode_angsuran","#form_add").val();
  set_tanggal_jatuh_tempo_add(periode_angsuran,jangka_waktu,angsuranpertama);

  /* set max margin pembiayaan (on add form) */
  jkwaktu=parseFloat($("#jangka_waktu","#form_add").val());
  pokok = parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
  switch(periode_angsuran){
    case "0": //harian
      global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/3000);
      global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/3000);
    break;
    case "1": // mingguan
      global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/400);
      global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/400);
    break;
    case "2": //bulanan
      global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/100);
      global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/100);
    break;
    case "3": //jatuh tempo
      global_min_nominal_margin=0;
      global_max_nominal_margin=999999999999999;
    break;
  }
  console.log('pokok:'+pokok);
  console.log('jangka_waktu:'+jangka_waktu);
  console.log('global_rate_margin_min:'+global_rate_margin_min);
  console.log('global_rate_margin_max:'+parseFloat(global_rate_margin_max));
  if(parseFloat(global_rate_margin_max)<100 && parseFloat(global_rate_margin_max)!=0){
    console.log('global_max_nominal_margin:'+global_max_nominal_margin)
    if(periode_angsuran==3){ // jatuh tempo
      $("#margin_pembiayaan","#form_add").val(0);
    }else{
      $("#margin_pembiayaan","#form_add").val(number_format(global_max_nominal_margin,0,',','.'));
    }
  }

  $("#jadwal_angsuran","#form_add").val('1').trigger('change');

});

$("input[name='tgl_pengajuan']","#form_add").change(function(){ 
  var periode_angsuran=$("#periode_angsuran","#form_add").val();
  var tgl_pengajuan = $("input[name='tgl_pengajuan']","#form_add").val();
  var day1 = tgl_pengajuan.substr(0,2);
  var month1 = tgl_pengajuan.substr(3,2);
  var year1 = tgl_pengajuan.substr(6,4);
  tgl_pengajuan = year1+'-'+month1+'-'+day1;
  set_tanggal_akad_add(tgl_pengajuan,periode_angsuran);
  $("input[name='tgl_akad']","#form_add").trigger('change');

  //Untuk memanggil  function simpanan wajib pinjam
  form_id=$(this).closest('form').attr('id');
  form_id=$("#"+form_id);
  calc_simpanan_wajib_pinjam(form_id)
});

      $("a#angs_add","#form_add").live('click',function(){

        if ($("#Vangs_tanggal","#form_add").val()=='' ||
            $("#Vangs_pokok","#form_add").val()=='' ||
            $("#Vangs_margin","#form_add").val()=='' ||
            $("#Vangs_tabungan","#form_add").val()==''
           ) 
        {
          alert("Harap isi field yang kosong");
        } 
        else
        {
          Vangs_tanggal = $("#Vangs_tanggal","#form_add").val();
          Vangs_pokok = $("#Vangs_pokok","#form_add").val();
          Vangs_margin  = $("#Vangs_margin","#form_add").val();
          Vangs_tabungan  = $("#Vangs_tabungan","#form_add").val();

          html = ' \
            <tr style="background-color:#eee !important;"> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:center;" class="m-wrap" id="angs_tanggal" name="angs_tanggal[]" value="'+Vangs_tanggal+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_pokok" name="angs_pokok[]" value="'+Vangs_pokok+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_margin" name="angs_margin[]" value="'+Vangs_margin+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_tabungan" name="angs_tabungan[]" value="'+Vangs_tabungan+'" readonly=""> \
              </td> \
              <td style="vertical-align:middle;text-align:center;"> \
                <!--<a href="javascript:void(0);" id="angs_add">Tambah</a>--> \
              </td> \
              <td style="vertical-align:middle;text-align:center;"> \
                <a href="javascript:void(0);" id="angs_delete"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"></a> \
              </td> \
            </tr> \
          ';

          var tgl_sama = 0;
          $("input#angs_tanggal","#form_add").each(function(){
            if(Vangs_tanggal==$(this).val())
            {
              alert("Tidak Boleh Ada Tanggal Yang Sama!")
              tgl_sama++;
            }     
          });

          if (tgl_sama==0) 
          {
            $(this).closest('tr').before(html);
            $("#Vangs_tanggal","#form_add").val('');
            $("#Vangs_pokok","#form_add").val('');
            $("#Vangs_margin","#form_add").val('');
            $("#Vangs_tabungan","#form_add").val('');
            // $(".add_additional_schedule tbody").append(html);  
            total_angs_pokok=0;
            $("input#angs_pokok","#form_add").each(function(){
              total_angs_pokok+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_pokok","#form_add").val(total_angs_pokok);

            total_angs_margin=0;
            $("input#angs_margin","#form_add").each(function(){
              total_angs_margin+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_margin","#form_add").val(total_angs_margin);

            total_angs_tabungan=0;
            $("input#angs_tabungan","#form_add").each(function(){
              total_angs_tabungan+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_tabungan","#form_add").val(total_angs_tabungan);     
          }
        }
      });

      $("a#angs_delete","#form_add").live('click',function(){
        if($("#additional_schedule tbody tr").length==1){
          alert("baris ini tidak boleh di hapus");
        }else{

          $(this).closest('tr').remove();
          
          total_angs_pokok=0;
          $("input#angs_pokok","#form_add").each(function(){
            total_angs_pokok+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_pokok","#form_add").val(total_angs_pokok);

          total_angs_margin=0;
          $("input#angs_margin","#form_add").each(function(){
            total_angs_margin+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_margin","#form_add").val(total_angs_margin);

          total_angs_tabungan=0;
          $("input#angs_tabungan","#form_add").each(function(){
            total_angs_tabungan+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_tabungan","#form_add").val(total_angs_tabungan);
          
        }
      });

      $("a#Vangs_delete","#form_add").live('click',function(){
        $("#Vangs_tanggal","#form_add").val('');
        $("#Vangs_pokok","#form_add").val('');
        $("#Vangs_margin","#form_add").val('');
        $("#Vangs_tabungan","#form_add").val('');
      });


      $("a#angs_add","#form_edit").live('click',function(){

        if ($("#Vangs_tanggal","#form_edit").val()=='' ||
            $("#Vangs_pokok","#form_edit").val()=='' ||
            $("#Vangs_margin","#form_edit").val()=='' ||
            $("#Vangs_tabungan","#form_edit").val()==''
           ) 
        {
          alert("Harap isi field yang kosong");
        } 
        else
        {
          Vangs_tanggal = $("#Vangs_tanggal","#form_edit").val();
          Vangs_pokok = $("#Vangs_pokok","#form_edit").val();
          Vangs_margin  = $("#Vangs_margin","#form_edit").val();
          Vangs_tabungan  = $("#Vangs_tabungan","#form_edit").val();

          html = ' \
            <tr style="background-color:#eee !important;"> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:center;" class="m-wrap" id="angs_tanggal" name="angs_tanggal[]" value="'+Vangs_tanggal+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_pokok" name="angs_pokok[]" value="'+Vangs_pokok+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_margin" name="angs_margin[]" value="'+Vangs_margin+'" readonly=""> \
              </td> \
              <td style="text-align:center;"> \
                <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap" id="angs_tabungan" name="angs_tabungan[]" value="'+Vangs_tabungan+'" readonly=""> \
              </td> \
              <td style="vertical-align:middle;text-align:center;"> \
                <!--<a href="javascript:void(0);" id="angs_add">Tambah</a>--> \
              </td> \
              <td style="vertical-align:middle;text-align:center;"> \
                <a href="javascript:void(0);" id="angs_delete"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"></a> \
              </td> \
            </tr> \
          ';

          var tgl_sama = 0;
          $("input#angs_tanggal","#form_edit").each(function(){
            if(Vangs_tanggal==$(this).val())
            {
              alert("Tidak Boleh Ada Tanggal Yang Sama!")
              tgl_sama++;
            }     
          });

          if (tgl_sama==0) 
          {
            $(this).closest('tr').before(html);
            $("#Vangs_tanggal","#form_edit").val('');
            $("#Vangs_pokok","#form_edit").val('');
            $("#Vangs_margin","#form_edit").val('');
            $("#Vangs_tabungan","#form_edit").val('');
            // $(".add_additional_schedule tbody").append(html);  
            total_angs_pokok=0;
            $("input#angs_pokok","#form_edit").each(function(){
              total_angs_pokok+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_pokok","#form_edit").val(total_angs_pokok);

            total_angs_margin=0;
            $("input#angs_margin","#form_edit").each(function(){
              total_angs_margin+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_margin","#form_edit").val(total_angs_margin);

            total_angs_tabungan=0;
            $("input#angs_tabungan","#form_edit").each(function(){
              total_angs_tabungan+=parseFloat(convert_numeric($(this).val()));
            });
            $("#total_angs_tabungan","#form_edit").val(total_angs_tabungan);     
          }
        }
      });

      $("a#angs_delete","#form_edit").live('click',function(){
        if($("#additional_schedule tbody tr").length==1){
          alert("baris ini tidak boleh di hapus");
        }else{

          $(this).closest('tr').remove();
          
          total_angs_pokok=0;
          $("input#angs_pokok","#form_edit").each(function(){
            total_angs_pokok+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_pokok","#form_edit").val(total_angs_pokok);

          total_angs_margin=0;
          $("input#angs_margin","#form_edit").each(function(){
            total_angs_margin+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_margin","#form_edit").val(total_angs_margin);

          total_angs_tabungan=0;
          $("input#angs_tabungan","#form_edit").each(function(){
            total_angs_tabungan+=parseFloat(convert_numeric($(this).val()));
          });
          $("#total_angs_tabungan","#form_edit").val(total_angs_tabungan);
          
        }
      });

      $("a#Vangs_delete","#form_edit").live('click',function(){
        $("#Vangs_tanggal","#form_edit").val('');
        $("#Vangs_pokok","#form_edit").val('');
        $("#Vangs_margin","#form_edit").val('');
        $("#Vangs_tabungan","#form_edit").val('');
      });

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'rekening_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

    jQuery.validator.addMethod("minratemargin", function(value, element) {
        
        if(parseFloat(convert_numeric(value))<parseFloat(global_min_nominal_margin)){
          return false;
        }else{
          return true;
        }
    }, "Nominal margin kurang dari batas minimal");

    jQuery.validator.addMethod("maxratemargin", function(value, element) {
        
        if(parseFloat(convert_numeric(value))>parseFloat(global_max_nominal_margin)){
          return false;
        }else{
          return true;
        }
    }, "Nominal margin melebihi batas maksimum");

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){
            error.appendTo( element.closest(".controls") );
          },
          // ignore: "",
          rules: {
              registration_no: {
                  required: true
              },
              product: {
                  required: true
              },
              // account_saving_no: {
                  // required: true
              // },
              akad: {
                  required: true
              },
              /*,
              nilai_pembiayaan: {
                  required: true
              },
              margin_pembiayaan: {
                  required: true
              },*/
              margin_pembiayaan: {
                  minratemargin: true,
                  maxratemargin: true
              },
              periode_angsuran: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              tgl_pengajuan: {
                  required: true
              },
              tgl_registrasi: {
                  required: true
              },
              tgl_akad: {
                  required: true
              },
              angsuranke1: {
                  required: true
              },
              tgl_jtempo: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              sumber_dana_pembiayaan: {
                  required: true
              },
              kreditur_code1: {
                  required: true
              },
              kreditur_code2: {
                  required: true
              },
              program_khusus: {
                  required: true
              },
              jadwal_angsuran: {
                  required: true
              },
              flag_wakalah: {
                  required: true
              },
              biaya_jasa_layanan: {
                  required: true
              }
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
            // if(label.closest('.input-append').length==0)
            // {
            //   label
            //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
            //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            // }
            // else
            // {
            //    label.closest('.control-group').removeClass('error').addClass('success')
            //    label.remove();
            // }
          },

          submitHandler: function (form) {

            var cif_type = $("#cif_type_hidden").val();
            var jaminan = $("#jaminan").val();
            var keterangan_jaminan = $("#keterangan_jaminan").val();
            var account_saving = $("#account_saving").val();
            var cif_no = $("#cif_no",form1).val();
            var tgl_akad = $("input[name='tgl_akad']",form1).val();

            $.ajax({
              type:"POST",dataType:"json",
              data:{cif_no:cif_no,tgl_akad:tgl_akad},
              url:site_url+'transaction/ajax_pembiayaan_same_is_exists',
              async: false,
              success:function(response){
                $("#pembiayaan_is_exist",form1).val(response.result);
              }
            });
            pembiayaan_is_exist = $("#pembiayaan_is_exist",form1).val();

            if(pembiayaan_is_exist==1)
            {
              alert("Warning : Double Pembiayaan. Tidak bisa mendaftarkan pembiayaan dengan Tanggal akad yang sama");
            }
            else if($("#jadwal_angsuran","#form_add").val()==0)
            {
              angsuran_pokok=0;
              $("input#angs_pokok","#form_add").each(function(){
                angsuran_pokok+=parseFloat(convert_numeric($(this).val()));
              });

              angsuran_margin=0;
              $("input#angs_margin","#form_add").each(function(){
                angsuran_margin+=parseFloat(convert_numeric($(this).val()));
              });

              var nilai_pembiayaan = convert_numeric($("#nilai_pembiayaan","#form_add").val());
              var margin_pembiayaan = convert_numeric($("#margin_pembiayaan","#form_add").val());
              // alert(angsuran_pokok+'||'+angsuran_margin+'||'+nilai_pembiayaan+'||'+margin_pembiayaan)

              if (nilai_pembiayaan!=angsuran_pokok) 
              {
                alert("Total angsuran pokok tidak sama dengan nilai pembiayaan!")
              } 
              else
              {
                if (margin_pembiayaan!=angsuran_margin) 
                {
                  alert("Total angsuran margin tidak sama dengan jumlah margin!")
                } 
                else
                {
                  if(cif_type==1){
                    if(account_saving==""){
                      alert("Rekening Tabungan diperlukan!")
                    }else if(jaminan==""){
                      alert("Jaminan diperlukan !")
                    }else if(keterangan_jaminan==""){
                      alert("Mohon isi Keterangan Jaminan !")
                    }else{
                        $.ajax({
                          type: "POST",
                          url: site_url+"transaction/add_pembiayaan",
                          dataType: "json",
                          data: form1.serialize(),
                          success: function(response){
                            if(response.success==true){
                              success1.show();
                              error1.hide();
                              form1.trigger('reset');
                              form1.find('.control-group').removeClass('success');
                              $("#cancel",form_add).trigger('click')
                              alert('Successfully Saved Data');
                              location.reload(false);
                            }else{
                              success1.hide();
                              error1.show();
                            }
                            App.scrollTo(form1, -200);
                          },
                          error:function(){
                              success1.hide();
                              error1.show();
                              App.scrollTo(form1, -200);
                          }
                      });
                    }
                  }else{
                    $.ajax({
                      type: "POST",
                      url: site_url+"transaction/add_pembiayaan",
                      dataType: "json",
                      data: form1.serialize(),
                      success: function(response){
                        if(response.success==true){
                          success1.show();
                          error1.hide();
                          form1.trigger('reset');
                          form1.find('.control-group').removeClass('success');
                          $("#cancel",form_add).trigger('click')
                          alert('Successfully Saved Data');
                          location.reload(false);
                        }else{
                          success1.hide();
                          error1.show();
                        }
                        App.scrollTo(form1, -200);
                      },
                      error:function(){
                          success1.hide();
                          error1.show();
                          App.scrollTo(form1, -200);
                      }
                    });
                  }
                }
              }
            }
            else
            {
              if(cif_type==1){
                if(account_saving==""){
                  alert("Rekening Tabungan diperlukan!")
                }else if(jaminan==""){
                  alert("Jaminan diperlukan !")
                }else if(keterangan_jaminan==""){
                  alert("Mohon isi Keterangan Jaminan !")
                }else{
                    $.ajax({
                      type: "POST",
                      url: site_url+"transaction/add_pembiayaan",
                      dataType: "json",
                      data: form1.serialize(),
                      success: function(response){
                        if(response.success==true){
                          success1.show();
                          error1.hide();
                          form1.trigger('reset');
                          form1.find('.control-group').removeClass('success');
                          $("#cancel",form_add).trigger('click')
                          alert('Successfully Saved Data');
                          location.reload(false);
                        }else{
                          success1.hide();
                          error1.show();
                        }
                        App.scrollTo(form1, -200);
                      },
                      error:function(){
                          success1.hide();
                          error1.show();
                          App.scrollTo(form1, -200);
                      }
                  });
                }
              }else{
                $.ajax({
                  type: "POST",
                  url: site_url+"transaction/add_pembiayaan",
                  dataType: "json",
                  data: form1.serialize(),
                  success: function(response){
                    if(response.success==true){
                      success1.show();
                      error1.hide();
                      form1.trigger('reset');
                      form1.find('.control-group').removeClass('success');
                      $("#cancel",form_add).trigger('click')
                      alert('Successfully Saved Data');
                      location.reload(false);
                    }else{
                      success1.hide();
                      error1.show();
                    }
                    App.scrollTo(form1, -200);
                  },
                  error:function(){
                      success1.hide();
                      error1.show();
                      App.scrollTo(form1, -200);
                  }
                });
              }              
            }

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        html = ' \
        <tr> \
          <td style="text-align:center;"> \
            <input type="text" style="width:190px;" class="m-wrap mask_date" id="Vangs_tanggal"> \
          </td> \
          <td style="text-align:center;"> \
            <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_pokok"> \
          </td> \
          <td style="text-align:center;"> \
            <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_margin"> \
          </td> \
          <td style="text-align:center;"> \
            <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_tabungan"> \
          </td> \
          <td style="vertical-align:middle;text-align:center;"> \
            <a href="javascript:void(0);" id="angs_add"><img src="<?php echo base_url("assets/img/yes.png"); ?>"></a> \
          </td> \
          <td style="vertical-align:middle;text-align:center;"> \
            <a href="javascript:void(0);" id="Vangs_delete"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"></a> \
          </td> \
        </tr> \
      ';
        $("#additional_schedule","#form_edit").find('tfoot').html(html);
        $("#total_angs_pokok","#form_edit").val(number_format(0,0,',','.'));
        $("#total_angs_margin","#form_edit").val(number_format(0,0,',','.'));
        $("#total_angs_tabungan","#form_edit").val(number_format(0,0,',','.'));

        var account_financing_no = $(this).attr('account_financing_no');
        var fa_code = $(this).attr('fa_code');
        
        $("#fa_code","#form_edit").val(fa_code).trigger('liszt:updated');
        $.ajax({
         type: "POST",
         url: site_url+"transaction/get_status_rekening_from_account_financing",
         dataType: "json",
         async:false,
         data: {account_financing_no:account_financing_no},
         success: function(response)
         {
            if (response.status_rekening!=0)
            {
              alert('Status Rekening Sudah Aktif');
            }
            else
            {

        $("#wrapper-table").hide();
        $("#edit").show();
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"transaction/get_account_financing_by_account_financing_id",
          success: function(response)
          {
            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_ajax_produk_by_cif_type_link_edit",
               dataType: "json",
               async:false,
               data: {cif_type:response.cif_type},
               success: function(response){
                  html = '<option value="">PILIH</option>';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     // html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
                     html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
                  }
                  $("#product2","#form_edit").html(html);
               }
            });  

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_account_saving",
               dataType: "json",
               async:false,
               data: {cif_no:response.cif_no},
               success: function(response){
                  html = '<option value="">PILIH</option>';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].account_saving_no+'" selected="selected">'+response[i].account_saving_no+'</option>';
                  }
                  $("#account_saving2","#form_edit").html(html);
               }
            });

            // $("#resort_name2,#form_edit").val(response.resort_name);
            $("#resort_code2,#form_edit").val(response.resort_code);
            $("#jumlah_jaminan,#form_edit").val(response.jumlah_jaminan);
            $("#presentase_jaminan,#form_edit").val(response.presentase_jaminan);
            $("#jumlah_jaminan_sekunder,#form_edit").val(response.jumlah_jaminan_sekunder);
            $("#presentase_jaminan_sekunder,#form_edit").val(response.presentase_jaminan_sekunder);
            $("#form_edit select[name='product']").val(response.product_code);
            $("#form_edit input[name='kode_product']").val(response.product_code);
            $("#form_edit input[name='account_financing_reg_id2']").val(response.account_financing_reg_id);
            $("#form_edit input[name='registration_no2']").val(response.registration_no);
            $("#form_edit input[name='cif_type_hidden2']").val(response.cif_type);
            $("#form_edit input[name='account_financing_id']").val(response.account_financing_id);
            $("#form_edit input[name='branch_code']").val(response.branch_code);
      			$("#form_edit input[name='cif_no']").val(response.cif_no);
      			$("#form_edit input[name='nama']").val(response.nama);
      			$("#form_edit input[name='panggilan']").val(response.panggilan);
      			$("#form_edit input[name='ibu_kandung']").val(response.ibu_kandung);
      			$("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
      			$("#form_edit input[name='tgl_lahir']").val(response.tgl_lahir);
            $("#form_edit input[name='usia']").val(response.usia);
      			$("#form_edit input[name='account_financing_no']").val(response.account_financing_no);
            $("#form_edit input[name='uang_muka']").val(response.uang_muka);
            $("#form_edit input[name='nilai_pembiayaan']").val(response.pokok);
            $("#form_edit input[name='margin_pembiayaan']").val(response.margin);
            $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
            $("#form_edit select[name='periode_angsuran']").val(response.periode_jangka_waktu);
            $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
            $("#form_edit input[name='angsuran_pokok']").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#form_edit input[name='angsuran_margin']").val(number_format(response.angsuran_margin,0,',','.'));
            $("#form_edit input[name='angsuran_tabungan']").val(response.angsuran_catab);
            if(response.titipan_notaris>0){
              $("#form_edit input[name='titipan_notaris']").val(number_format(response.titipan_notaris,0,',','.'));
              $("#titipan_notaris_check2","#form_edit").attr('checked',true);
              $("#uniform-titipan_notaris_check2 span","#form_edit").attr('class','checked');
            }else{
              $("#form_edit input[name='titipan_notaris']").val(0);
              $("#titipan_notaris_check2","#form_edit").attr('checked',false);
              $("#uniform-titipan_notaris_check2 span","#form_edit").attr('class','');
            }
            $("#form_edit input[name='simpanan_wajib_pinjam']").val(number_format(response.simpanan_wajib_pinjam,0,',','.'));
            
            $("#form_edit select[name='flag_wakalah']").val(response.flag_wakalah);
            var cif_type = response.cif_type
            if(cif_type=='1'){
              $("#id_jaminan","#form_edit").show();
              $("#div_tabungan_wajib2").hide();
              $("#div_tabungan_kelompok2").hide();
              $("#form_edit input[name='tabungan_wajib']").val(0);
              $("#form_edit input[name='tabungan_kelompok']").val(0);
              $("#form_edit select[name='jaminan']").val(response.jenis_jaminan);
              $("#form_edit textarea[name='keterangan_jaminan']").val(response.keterangan_jaminan);
              $("#form_edit input[name='nominal_taksasi']").val(number_format(response.nominal_taksasi,0,',','.'));
              if(response.jenis_jaminan_sekunder!=null) $("#form_edit select[name='jaminan_sekunder']").val(response.jenis_jaminan_sekunder); else $("#form_edit select[name='jaminan_sekunder']").val('');
              if(response.keterangan_jaminan_sekunder!=null) $("#form_edit textarea[name='keterangan_jaminan_sekunder']").val(response.keterangan_jaminan_sekunder); else $("#form_edit textarea[name='keterangan_jaminan_sekunder']").val('');
              if(response.nominal_taksasi_sekunder!=null) $("#form_edit input[name='nominal_taksasi_sekunder']").val(number_format(response.nominal_taksasi_sekunder,0,',','.')); else $("#form_edit input[name='nominal_taksasi_sekunder']").val('');
            }else{
              $("#id_jaminan","#form_edit").hide();
              $("#div_tabungan_wajib2").show();
              $("#div_tabungan_kelompok2").show();
              $("#form_edit input[name='tabungan_wajib']").val(number_format(response.angsuran_tab_wajib,0,',','.'));
              $("#form_edit input[name='tabungan_kelompok']").val(number_format(response.angsuran_tab_kelompok,0,',','.'));
              $("#form_edit select[name='jaminan']").val('');
              $("#form_edit textarea[name='keterangan_jaminan']").val('');
              $("#form_edit input[name='nominal_taksasi']").val('');
              $("#form_edit select[name='jaminan_sekunder']").val('');
              $("#form_edit textarea[name='keterangan_jaminan_sekunder']").val('');
              $("#form_edit input[name='nominal_taksasi_sekunder']").val('');
            }

            a_1 = parseFloat(response.angsuran_pokok);
            a_2 = parseFloat(response.angsuran_margin);
            a_3 = parseFloat(response.angsuran_catab);
            a_4 = parseFloat(response.angsuran_tab_wajib);
            a_5 = parseFloat(response.angsuran_tab_kelompok);
            total_angsuran  = a_1+a_2+a_3+a_4+a_5;

            $("#form_edit input[name='total_angsuran']").val(number_format(total_angsuran,0,',','.'));
            $("#form_edit input[name='cadangan_resiko']").val(response.cadangan_resiko);
            $("#form_edit input[name='dana_kebajikan']").val(response.dana_kebajikan);
            $("#form_edit input[name='biaya_administrasi']").val(number_format(response.biaya_administrasi,0,',','.'));
            $("#form_edit input[name='biaya_jasa_layanan']").val(number_format(response.biaya_jasa_layanan,0,',','.'));
            total_biaya=parseFloat(response.simpanan_wajib_pinjam);
            total_biaya+=parseFloat(response.biaya_administrasi);
            total_biaya+=parseFloat(response.biaya_jasa_layanan);
            $("#form_edit input[name='total_biaya']").val(number_format(total_biaya,0,',','.'));
            $("#form_edit input[name='biaya_notaris']").val(response.biaya_notaris);
            $("#form_edit input[name='p_asuransi_jiwa']").val(response.biaya_asuransi_jiwa);
            $("#form_edit input[name='p_asuransi_jaminan']").val(response.biaya_asuransi_jaminan);
            $("#form_edit select[name='sumber_dana_pembiayaan']").val(response.sumber_dana);
            $("#form_edit input[name='dana_sendiri']").val(number_format(response.dana_sendiri,0,',','.'));
            $("#form_edit input[name='dana_kreditur']").val(response.dana_kreditur);
            if(response.sumber_dana=='1'){
            $("#form_edit","#kreditur_code21").val(response.kreditur_code);
            }else if(response.sumber_dana=='2'){
              $("#form_edit","#kreditur_code22").val(response.kreditur_code);
            }
            $("#form_edit input[name='keuntungan']").val(response.ujroh_kreditur_persen);
            $("#form_edit input[name='angsuran']").val(response.ujroh_kreditur);
            $("#form_edit select[name='pembayaran_kreditur2']").val(response.ujroh_kreditur_carabayar);
            $("#form_edit select[name='product']").val(response.product_code);
            var account_saving = response.account_saving_no
            if(account_saving==""){
                $("#saving2").hide();
            }else{
                $("#form_edit select[name='account_saving']").val(account_saving);
                $("#saving2").show();
            }
           
            var producttt = response.program_code;
            $("#form_edit select[name='jenis_program']").val(producttt);
            var akadddd = response.akad_code;
            $("#form_edit select[name='akad']").val(akadddd);
            $("#akad2","#form_edit").trigger('change');
            $("#form_edit select[name='sektor_ekonomi']").val(response.sektor_ekonomi);
            $("#form_edit select[name='peruntukan_pembiayaan']").val(response.peruntukan);

            $("#form_edit select[name='jadwal_angsuran']").val(response.flag_jadwal_angsuran);

            /* begin callback #jangka_waktu2 function */
            rate_margin_min_edit=response.rate_margin1;
            rate_margin_max_edit=response.rate_margin2;
            global_rate_margin_min_edit=rate_margin_min_edit;
            global_rate_margin_max_edit=rate_margin_max_edit;
            global_rate_simpanan_wajib_pinjam_edit=response.rate_simpanan_wajib_pinjam;

            switch(response.periode_jangka_waktu){
                case "0": //harian
                  global_min_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_min_edit/3000);
                  global_max_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_max_edit/3000);
                  // global_min_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_min/3000);
                  // global_max_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_max/3000);
                break;
                case "1": // mingguan
                  global_min_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_min_edit/400);
                  global_max_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_max_edit/400);
                  // global_min_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_min/400);
                  // global_max_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_max/400);
                break;
                case "2": //bulanan
                  global_min_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_min_edit/100);
                  global_max_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_max_edit/100);
                  // global_min_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_min/100);
                  // global_max_nominal_margin=(response.pokok*jkwaktu)*(global_rate_margin_max/100);
                break;
                case "3": //jatuh tempo
                  global_min_nominal_margin_edit=0;
                  global_max_nominal_margin_edit=999999999999999;
                break;
              }

            // global_min_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_min_edit/100);
            // global_max_nominal_margin_edit=(response.pokok*response.jangka_waktu)*(global_rate_margin_max_edit/100);
            // console.log('pokok_edit:'+response.pokok);
            // console.log('jangka_waktu_edit:'+response.jangka_waktu);
            // console.log('global_rate_margin_min_edit:'+global_rate_margin_min_edit);
            // console.log('global_rate_margin_max_edit:'+parseFloat(global_rate_margin_max_edit));
            // if(parseFloat(global_rate_margin_max_edit)<100 && parseFloat(global_rate_margin_max_edit)!=0){
              console.log('jangka_waktuxx:'+response.jangka_waktu)
              console.log('pokokxx:'+response.pokok)
              console.log('rate_margin_max_editxx:'+rate_margin_max_edit)
              console.log('global_rate_margin_max_editxx:'+global_rate_margin_max_edit)
              console.log('global_max_nominal_margin_editxx:'+global_max_nominal_margin_edit)
            //   $("#margin_pembiayaan2","#form_edit").val(number_format(global_max_nominal_margin_edit,0,',','.'));
            // }

            // $("#jangka_waktu2","#form_edit").trigger('change');
            /* end callback #jangka_waktu2 function */
            


            var tanggal_pengajuan = response.tanggal_pengajuan;
            if(tanggal_pengajuan==undefined)
            {
              tanggal_pengajuan='';
            }
            var tgl_pengajuan = tanggal_pengajuan.substring(8,10);
            var bln_pengajuan = tanggal_pengajuan.substring(5,7);
            var thn_pengajuan = tanggal_pengajuan.substring(0,4);
            var tgl_akhir_pengajuan = tgl_pengajuan+""+bln_pengajuan+""+thn_pengajuan;  
            $("#form_edit input[name='tgl_pengajuan_edit']").val(tgl_akhir_pengajuan);

            var tanggal_registrasi = response.tanggal_registrasi;
            if(tanggal_registrasi==undefined)
            {
              tanggal_registrasi='';
            }
            var tgl_registrasi = tanggal_registrasi.substring(8,10);
            var bln_registrasi = tanggal_registrasi.substring(5,7);
            var thn_registrasi = tanggal_registrasi.substring(0,4);
            var tgl_akhir_registrasi = tgl_registrasi+""+bln_registrasi+""+thn_registrasi;  
            $("#form_edit input[name='tgl_registrasi_edit']").val(tgl_akhir_registrasi);

            var tanggal_mulai_angsur = response.tanggal_mulai_angsur;
            if(tanggal_mulai_angsur==undefined)
            {
              tanggal_mulai_angsur='';
            }
            var tgl_mulai_angsur = tanggal_mulai_angsur.substring(8,10);
            var bln_mulai_angsur = tanggal_mulai_angsur.substring(5,7);
            var thn_mulai_angsur = tanggal_mulai_angsur.substring(0,4);
            var tgl_akhir_angsur = tgl_mulai_angsur+"/"+bln_mulai_angsur+"/"+thn_mulai_angsur;
            $("#form_edit input[name='angsuranke1_edit']").val(tgl_akhir_angsur);

            var tanggal_akad = response.tanggal_akad;
            if(tanggal_akad==undefined)
            {
              tanggal_akad='';
            }
            var tgl_akad = tanggal_akad.substring(8,10);
            var bln_akad = tanggal_akad.substring(5,7);
            var thn_akad = tanggal_akad.substring(0,4);
            var tgl_akhir_akad = tgl_akad+""+bln_akad+""+thn_akad;
            $("#form_edit input[name='tgl_akad_edit']").val(tgl_akhir_akad);

            var tanggal_jtempo = response.tanggal_jtempo;
            if(tanggal_jtempo==undefined)
            {
              tanggal_jtempo='';
            }
            var tgl_jtempo = tanggal_jtempo.substring(8,10);
            var bln_jtempo = tanggal_jtempo.substring(5,7);
            var thn_jtempo = tanggal_jtempo.substring(0,4);
            var tgl_akhir_jtempo = tgl_jtempo+"/"+bln_jtempo+"/"+thn_jtempo;
            $("#form_edit input[name='tgl_jtempo_edit']").val(tgl_akhir_jtempo);

    			  //fungsi untuk menyembunyikan input jadwal angsuran jika value=0
            var jadwal_angsuran = response.flag_jadwal_angsuran;   
            if(jadwal_angsuran=='0')
            {
                $("#non_reg2").hide();
                $("#reg2").show();
            }
            else
            {
                $("#non_reg2").show();
                $("#reg2").hide();
            }

            //fungsi untuk menyembunyikan input sumber dana pembiayaan jika value=1
            var sumber_dana_pembiayaan = response.sumber_dana;  
            if(sumber_dana_pembiayaan=='0')
            {
              $("#dana_sendiri","#form_edit").val(number_format(response.pokok,0,',','.'));
              // $("#sendiri2","#form_edit").show();
              $("#sendiri_campuran2","#form_edit").hide();
              $("#kreditur2","#form_edit").hide();
              $("#kreditur2_campuran","#form_edit").hide();
            }
            else if (sumber_dana_pembiayaan=='1') 
            {
              // $("#kreditur2","#form_edit").show();
              $("#kreditur2_campuran","#form_edit").hide();
              $("#sendiri2","#form_edit").hide();
              $("#sendiri_campuran2","#form_edit").hide();
            }
            else if (sumber_dana_pembiayaan=='2') 
            {
              $("#dana_sendiri_campuran","#form_edit").val(number_format(response.pokok,0,',','.'));
              $("#sendiri2","#form_edit").hide();
              $("#kreditur2","#form_edit").hide();
              // $("#kreditur2_campuran","#form_edit").show();
            }
            else
            {
              $("#sendiri2","#form_edit").hide();
              $("#sendiri_campuran2","#form_edit").hide();
              $("#kreditur2","#form_edit").hide();
              $("#kreditur2_campuran","#form_edit").hide();
            }

            //fungsi untuk menyembunyikan input nisbah bagi hasil
            var nisbah = response.nisbah_bagihasil;   
            if(nisbah==null)
            {
              $("#nisbah2","#form_edit").hide();
            }
            else
            {
              $("#nisbah2","#form_edit").show();
            }

            //fungsi untuk menyembunyikan input Jenis Program
            var jenis_program = response.program_code;   
            if(jenis_program=="")
            {
              $("#program2","#form_edit").hide();
              $("#program_khusus2","#form_edit").val('1');
            }
            else
            {
              $("#program2","#form_edit").show();
              $("#program_khusus2","#form_edit").val('0');
            }

            $.ajax({
              type: "POST",
              dataType: "json",
              data: {account_financing_no:response.account_financing_no},
              url: site_url+"transaction/get_account_financing_schedulle_by_no_account",
              success: function(response)
              {
                html = '';
                total_angsuran_pokok=0;
                total_angsuran_margin=0;
                total_angsuran_tabungan=0;
                for(i = 0 ; i < response.length ; i++)
                {
                    var tangga_jtempo = response[i].tangga_jtempo;
                    if(tangga_jtempo==undefined)
                    {
                      tangga_jtempo='';
                    }
                    var tg_jtempo = tangga_jtempo.substring(8,10);
                    var bl_jtempo = tangga_jtempo.substring(5,7);
                    var th_jtempo = tangga_jtempo.substring(0,4);
                    
                    var tg_akhir_jtempo = tg_jtempo+"/"+bl_jtempo+"/"+th_jtempo;
                    // console.log(tg_akhir_jtempo);
                    total_angsuran_pokok += parseFloat(response[i].angsuran_pokok);
                    total_angsuran_margin += parseFloat(response[i].angsuran_margin);
                    total_angsuran_tabungan += parseFloat(response[i].angsuran_tabungan);
                    html += ' \
                    <tr style="background-color:#eee !important"> \
                      <td style="text-align:center;"> \
                        <input type="hidden" id="account_financing_schedulle_id" name="account_financing_schedulle_id[]" value="'+response[i].account_financing_schedulle_id+'"> \
                        <input type="text" style="width:190px;text-align:center;" class="m-wrap mask_date" id="angs_tanggal" value="'+tg_akhir_jtempo+'" name="angs_tanggal[]" readonly=""> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap mask-money" id="angs_pokok" value="'+number_format(response[i].angsuran_pokok,0,',','.')+'" name="angs_pokok[]" readonly=""> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap mask-money" id="angs_margin" value="'+number_format(response[i].angsuran_margin,0,',','.')+'" name="angs_margin[]" readonly=""> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;text-align:right;" maxlength="12" class="m-wrap mask-money" id="angs_tabungan" value="'+number_format(response[i].angsuran_tabungan,0,',','.')+'" name="angs_tabungan[]" readonly=""> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <!--<a href="javascript:void(0);" id="angs_add">Tambah</a>--> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <a href="javascript:void(0);" id="angs_delete"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
                      </td> \
                    </tr> \
                  ';
                }
                if(jadwal_angsuran==0)
                {
                    html += ' \
                    <tr> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;" class="m-wrap mask_date" id="Vangs_tanggal"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_pokok"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_margin"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" style="width:190px;" maxlength="12" class="m-wrap mask-money" id="Vangs_tabungan"> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <a href="javascript:void(0);" id="angs_add"><img src="<?php echo base_url("assets/img/yes.png"); ?>"></a> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <a href="javascript:void(0);" id="Vangs_delete"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"></a> \
                      </td> \
                    </tr> \
                  ';
                    $("#additional_schedule","#form_edit").find('tfoot').html(html);
                    $("#total_angs_pokok","#form_edit").val(number_format(total_angsuran_pokok,0,',','.'));
                    $("#total_angs_margin","#form_edit").val(number_format(total_angsuran_margin,0,',','.'));
                    $("#total_angs_tabungan","#form_edit").val(number_format(total_angsuran_tabungan,0,',','.'));
                }
              }
            })
        }
        
        });
        }
        }
      });
      });
        
	  
	  // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

        $("#dialog2").dialog({
          width: 270,
          height: 320,
          autoOpen: false,
          buttons: {
            'OK': function(){
              $("#dialog2").dialog('close');
              var customer_no = $("#result2").val();
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
            }
          }
        });
		$("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });
	 });
	 
 //fungsi untuk menggenerate NO REKENING
    $(function(){
    
      $("#product2").change(function(){
        var product_code = $("#product2").val();
        var cif_no = $("#cif_no2").val();  
        //mendapatkan jumlah maksimal sesuai product_code yang dipilih
        $.ajax({
          // url: site_url+"transaction/count_cif_by_product_code_financing",
          url: site_url+"transaction/get_seq_account_financing_no",
          type: "POST",
          dataType: "json",
          data: {product_code:product_code,cif_no:cif_no},
          success: function(response)
          {
            var no_urut = response.newseq;
            // var data = response.jumlah;
            // if(data==null)
            // {
            //   var total = 0;
            // }
            // else
            // {
            //   var total = data;
            // }
            // var jumlah = total; 
            // var no_urut = parseFloat(jumlah)+1;
            // if(no_urut<10){
            //   no_urut = '0'+no_urut;
            // }
            //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
            $("#account_financing_no2").val(cif_no+''+product_code+''+no_urut);
          }
        });

        var akad = $("#akad2").val();
        $.ajax({
          url: site_url+"transaction/get_ajax_jenis_keuntungan",
          type: "POST",
          dataType: "json",
          data: {akad:akad},
          success: function(response)
          {
            var data = response.jenis_keuntungan;
            if(data>2)
            {
              $("#nisbah2").show();
            }
            else
            {
              $("#nisbah2").hide();
            }
          }
        });

        $.ajax({
          type:"POST",
          dataType:"json",
          data:{
            product_code:product_code
          },
          url:site_url+"transaction/get_product_financing_data_by_code",
          success:function(response){
            var data=response;
            $("#periode_angsuran2","#form_add").val(data.periode_angsuran);
            rate_margin_min_edit=data.rate_margin1;
            rate_margin_max_edit=data.rate_margin2;

            global_rate_margin_min_edit=rate_margin_min_edit;
            global_rate_margin_max_edit=rate_margin_max_edit;

            global_rate_simpanan_wajib_pinjam_edit=data.rate_simpanan_wajib_pinjam;
            $("#akad2").val(data.akad_code).trigger('change');
            
          }

        });


      });


    
    });

//fungsi untuk menggenerate Nama Akad
    $(function(){

      $("#akad2").change(function(){
        var akad = $("#akad2").val();
        $.ajax({
          url: site_url+"transaction/get_ajax_jenis_keuntungan",
          type: "POST",
          dataType: "json",
          data: {akad:akad},
          success: function(response)
          {
            var data = response.jenis_keuntungan;
            if(data>=2)
            {
              $("#nisbah2").show();
              $("#margin_p2").hide();
              // $("select#akad2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan2","#form_edit").select();
              //     if(typeof($("#nilai_pembiayaan2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nisbah_bagihasil","#form_edit").select();
              //     if(typeof($("#nisbah_bagihasil","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#nisbah_bagihasil","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if(data==1)
            {
              $("#nisbah2").hide();
              $("#margin_p2").show();
              // $("select#akad2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan2","#form_edit").select();
              //     if(typeof($("#nilai_pembiayaan2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#margin_pembiayaan2","#form_edit").select();
              //     if(typeof($("#margin_pembiayaan2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#margin_pembiayaan2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#nisbah2").hide();
              $("#margin_p2").hide();
              // $("select#akad2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan2","#form_edit").select();
              //     if(typeof($("#nilai_pembiayaan2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#periode_angsuran2","#form_edit").focus();
              //     if(typeof($("#periode_angsuran2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#periode_angsuran2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
          }
        })         
        
          });

    });

      jQuery.validator.addMethod("minratemargin_edit", function(value, element) {
            
            if(parseFloat(convert_numeric(value))<parseFloat(global_min_nominal_margin_edit)){
              return false;
            }else{
              return true;
            }
        }, "Nominal margin kurang dari batas minimal");

      jQuery.validator.addMethod("maxratemargin_edit", function(value, element) {
          
          if(parseFloat(convert_numeric(value))>parseFloat(global_max_nominal_margin_edit)){
            return false;
          }else{
            return true;
          }
      }, "Nominal margin melebihi batas maksimum");

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement:function(error,element){
            error.appendTo( element.closest(".controls") );
          },
          // ignore: "",
          rules: {
              product: {
                  required: true
              },
              // account_saving_no: {
                  // required: true
              // },
              akad: {
                  required: true
              },
              /*,
              nilai_pembiayaan: {
                  required: true
              },
              margin_pembiayaan: {
                  required: true
              },*/
              margin_pembiayaan: {
                  minratemargin_edit: true,
                  maxratemargin_edit: true
              },
              periode_angsuran: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              tgl_pengajuan_edit: {
                  required: true
              },
              tgl_registrasi_edit: {
                  required: true
              },
              tgl_akad_edit: {
                  required: true
              },
              angsuranke1_edit: {
                  required: true
              },
              tgl_jtempo_edit: {
                  required: true
              },
              /*
              cadangan_resiko: {
                  required: true
              },
              dana_kebajikan: {
                  required: true
              },
              biaya_administrasi: {
                  required: true
              },
              biaya_notaris: {
                  required: true
              },
              p_asuransi_jiwa: {
                  required: true
              },
              p_asuransi_jaminan: {
                  required: true
              },*/
              sumber_dana_pembiayaan: {
                  required: true
              },
              /*account_financing_no: {
                  required: true
              },*/
              kreditur_code1: {
                  required: true
              },
              kreditur_code2: {
                  required: true
              },
              program_khusus: {
                  required: true
              },
              jadwal_angsuran: {
                  required: true
              },
              biaya_jasa_layanan: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
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
            // if(label.closest('.input-append').length==0)
            // {
            //   label
            //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
            //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            // }
            // else
            // {
            //    label.closest('.control-group').removeClass('error').addClass('success')
            //    label.remove();
            // }
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            if($("#jadwal_angsuran2").val()==0)
            {              
              angsuran_pokok=0;
              $("input#angs_pokok","#form_edit").each(function(){
                angsuran_pokok+=parseFloat(convert_numeric($(this).val()));
              });

              angsuran_margin=0;
              $("input#angs_margin","#form_edit").each(function(){
                angsuran_margin+=parseFloat(convert_numeric($(this).val()));
              });

              var nilai_pembiayaan = convert_numeric($("#nilai_pembiayaan2","#form_edit").val());
              var margin_pembiayaan = convert_numeric($("#margin_pembiayaan2","#form_edit").val());
              // alert(angsuran_pokok+'||'+angsuran_margin+'||'+nilai_pembiayaan+'||'+margin_pembiayaan)

              if (nilai_pembiayaan!=angsuran_pokok) 
              {
                alert("Total angsuran pokok tidak sama dengan nilai pembiayaan!")
              } 
              else
              {
                if (margin_pembiayaan!=angsuran_margin) 
                {
                  alert("Total angsuran margin tidak sama dengan jumlah margin!")
                } 
                else
                {
                  $.ajax({
                    type: "POST",
                    url: site_url+"transaction/edit_rekening_pembiayaan",
                    dataType: "json",
                    data: form2.serialize(),
                    success: function(response){
                      if(response.success==true){
                        success2.show();
                        error2.hide();
                        form2.children('div').removeClass('success');
                        $("#rekening_pembiayaan_table_filter input").val('');
                        dTreload();
                        $("#cancel",form_edit).trigger('click')
                        alert('Successfully Updated Data');
                      }else{
                        success2.hide();
                        error2.show();
                      }
                      App.scrollTo($("#wrapper-table"), -200);
                    },
                    error:function(){
                        success2.hide();
                        error2.show();
                        App.scrollTo($("#wrapper-table"), -200);
                    }
                  });                
                }
              }
            }
            else
            {
              $.ajax({
                type: "POST",
                url: site_url+"transaction/edit_rekening_pembiayaan",
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    success2.show();
                    error2.hide();
                    form2.children('div').removeClass('success');
                    $("#rekening_pembiayaan_table_filter input").val('');
                    dTreload();
                    $("#cancel",form_edit).trigger('click')
                    alert('Successfully Updated Data');
                  }else{
                    success2.hide();
                    error2.show();
                  }
                  App.scrollTo($("#wrapper-table"), -200);
                },
                error:function(){
                    success2.hide();
                    error2.show();
                    App.scrollTo($("#wrapper-table"), -200);
                }
              });   
            }

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_financing_no = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){
          account_financing_no[$i] = $(this).val();
          $i++;
        });

        $("input#checkbox:checked").each(function(){
          no_rek_pembiayaan = $(this).val();
        });

        if(account_financing_no.length==0){
          alert("Please select some row to delete !");
        }else{
          $.ajax({
            type: "POST",
            url: site_url+"transaction/get_status_rekening_from_account_financing",
            dataType: "json",
            async: false,
            data: {account_financing_no:no_rek_pembiayaan},
            success: function(response){
              if(response.status_rekening!=0){
                alert("Status Rekening Sudah Aktif !");
                dTreload();
              }else{
                var conf = confirm('Are you sure to delete this rows ?');
                if(conf){
                  $.ajax({
                    type: "POST",
                    url: site_url+"transaction/delete_rekening_pembiayaan",
                    dataType: "json",
                    data: {account_financing_no:account_financing_no},
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
            },
            error: function(){
              alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
          }) 
        }
      });

      // begin first table
      $('#rekening_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_rekening_pembiayaan_setup",
          "aoColumns": [
			      // null,
            null,
            null,
            null,
            null,
            null,
            null,
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

       $("#select").click(function(){
         result = $("#result").val();
              var no_registration = $("#result").val();
              registration_no = no_registration.substring(0,13);
              var no_cif = $("#result").val();
              cif_no = no_cif.substring(13);
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#registration_no").val(registration_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var no_reg = registration_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      async:false,
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/get_ajax_value_from_no_reg",
                      success: function(response)
                      {
                        $("#branch_code").val(response.branch_code);
                        $("#cif_no").val(response.cif_no);
                        $("#nama").val(response.nama);
                        $("#panggilan").val(response.panggilan);
                        $("#ibu_kandung").val(response.ibu_kandung);
                        $("#tmp_lahir").val(response.tmp_lahir);
                        $("#tgl_lahir").val(response.tgl_lahir);
                        $("#usia").val(response.usia);
                        $("#cif_type_hidden").val(response.cif_type);
                        if(response.cif_type==1){
                          $("#div_tabungan_wajib").hide();
                          $("#div_tabungan_kelompok").hide();
                        }else{
                          $("#div_tabungan_wajib").show();
                          $("#div_tabungan_kelompok").show();
                        }
                        var type = response.cif_type;
                        if(type==1){
                            $.ajax({
                               type: "POST",
                               url: site_url+"transaction/get_account_saving",
                               dataType: "json",
                               data: {cif_no:response.cif_no},
                               success: function(response){
                                  html = '<option value="">PILIH</option>';
                                  for ( i = 0 ; i < response.length ; i++ )
                                  {
                                     html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                                  }
                                  $("#account_saving","#form_add").html(html);
                               }
                            });   
                            $("#saving").show();
                            $("#id_jaminan","#form_add").show();
                        }
                        else{
                            $("#saving").hide();
                            $("#id_jaminan","#form_add").hide();
                        }
                        $("#uang_muka").val(response.uang_muka);
                        $("#nilai_pembiayaan").val(response.amount);
                        $("#account_financing_reg_id").val(response.account_financing_reg_id);
                        $("#form_add select[name='peruntukan_pembiayaan']").val(response.peruntukan);
                        var tanggal_pengajuan = response.tanggal_pengajuan;
                        if(tanggal_pengajuan==undefined)
                        {
                          tanggal_pengajuan='';
                        }
                        // $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
                        var tgl_pengajuan = tanggal_pengajuan.substr(8,2);
                        var bln_pengajuan = tanggal_pengajuan.substr(5,2);
                        var thn_pengajuan = tanggal_pengajuan.substr(0,4);
                        var tgl_akhir_pengajuan = tgl_pengajuan+"/"+bln_pengajuan+"/"+thn_pengajuan;
                        // document.getElementsByName('tgl_pengajuan').value=tgl_akhir_pengajuan;
                        $("#form_add input[name='tgl_pengajuan']").val(tgl_akhir_pengajuan);
                        // $('.date-picker').datepicker();
                        // var date = new Date();
                        // var day = date.getDate();
                        // var month = date.getMonth();
                        // var yyyy = date.getYear();
                        // var tgl_registrasi = day+"/"+month+"/"+yyyy;
                        var tgl_registrasi = "<?php echo date('d-m-Y')?>";
                        $("#form_add input[name='tgl_registrasi']").val(tgl_registrasi);
                        $.ajax({
                              type: "POST",
                              dataType: "json",
                              // async:false,
                              data: {tgl_akhir_pengajuan:tgl_akhir_pengajuan},
                              // data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranpertama:angsuranpertama},
                              url: site_url+"transaction/ajax_get_tanggal_akad",
                              success: function(response){
                                $("input[name='tgl_akad']","#form_add").val(response.tgl_akad);
                                $("input[name='angsuranke1']","#form_add").val(response.angsuranke1);
                                $("input[name='tgl_jtempo']","#form_add").val(response.tgl_jtempo);
                              }
                            });

                        $.ajax({
                               type: "POST",
                               url: site_url+"transaction/get_ajax_produk_by_cif_type",
                               dataType: "json",
                               data: {cif_type:response.cif_type},
                               success: function(response){
                                  html = '<option value="">PILIH</option>';
                                  for ( i = 0 ; i < response.length ; i++ )
                                  {
                                     // html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
                                     html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
                                  }
                                  $("#product","#form_add").html(html);
                               }
                            });   

                      }                 
                    });

            
        });

        $("#result option").live('dblclick',function(){
          $("#select").trigger('click');
        });

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
              url: site_url+"transaction/search_no_reg",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
        })

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
              url: site_url+"transaction/search_no_reg",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });
        
        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"transaction/search_no_reg",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                     option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].registration_no+''+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          if(cm_code=="")
          {
            $("#result").html('');
          }
        });

          $("#non_reg").hide();
          
          $("#jadwal_angsuran").change(function(){
          //Untuk memanggil  function simpanan wajib pinjam
          form_id=$(this).closest('form').attr('id');
          form_id=$("#"+form_id);
          calc_simpanan_wajib_pinjam(form_id)

            var jadwal_angsuran = $("#jadwal_angsuran").val();    
            if(jadwal_angsuran=='1')
            {
              $("#non_reg").show();
              $("#reg").hide();
              // $("#jadwal_angsuran","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran_tabungan").select();
              //     if(typeof($("#angsuran_tabungan").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran_tabungan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran_tabungan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#tabungan_wajib").select();
              //     if(typeof($("#tabungan_wajib").offset())!='undefined') {
              //       $(window).scrollTop($("#tabungan_wajib").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#tabungan_wajib","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#tabungan_kelompok").select();
              //     if(typeof($("#tabungan_kelompok").offset())!='undefined') {
              //       $(window).scrollTop($("#tabungan_kelompok").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#tabungan_kelompok","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#cadangan_resiko").select();
              //     if(typeof($("#cadangan_resiko").offset())!='undefined') {
              //       $(window).scrollTop($("#cadangan_resiko").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if(jadwal_angsuran=="0")
            {
              $("#non_reg").hide();
              $("#reg").show();
              // $("#jadwal_angsuran","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angs_tanggal").select();
              //     if(typeof($("#angs_tanggal").offset())!='undefined') {
              //       $(window).scrollTop($("#angs_tanggal").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angs_tanggal","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angs_pokok").select();
              //     if(typeof($("#angs_pokok").offset())!='undefined') {
              //       $(window).scrollTop($("#angs_pokok").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angs_pokok","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angs_margin").select();
              //     if(typeof($("#angs_margin").offset())!='undefined') {
              //       $(window).scrollTop($("#angs_margin").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angs_margin","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angs_tabungan").select();
              //     if(typeof($("#angs_tabungan").offset())!='undefined') {
              //       $(window).scrollTop($("#angs_tabungan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#non_reg").hide();
              $("#reg").hide();
            }

            var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));  
            if(isNaN(nilai_pembiayaan)===true){
              nilai_pembiayaan = 0;
            }
            // console.log(nilai_pembiayaan);
            var jangka_waktu = $("#jangka_waktu").val(); 
            if(isNaN(jangka_waktu)===true){
              jangka_waktu = 0;
            }
            // console.log(jangka_waktu); 
            var total_angsuran_pokok = nilai_pembiayaan/jangka_waktu;
            if(isNaN(total_angsuran_pokok)===true){
              total_angsuran_pokok = 0;
            }
            $("#angsuran_pokok").attr("readonly", true);
            $("#angsuran_pokok").val(number_format(total_angsuran_pokok,0,',','.'));


            var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val()));  
            if(isNaN(margin_pembiayaan)===true){
              margin_pembiayaan = 0;
            }
            // console.log(margin_pembiayaan);
            // var jangka_waktu = parseFloat($("#jangka_waktu").val());  
            // console.log(jangka_waktu);
            var total_angsuran_margin = margin_pembiayaan/jangka_waktu;
            if(isNaN(total_angsuran_margin)===true){
              total_angsuran_margin = 0;
            }
            $("#angsuran_margin").attr("readonly", true);
            $("#angsuran_margin").val(number_format(total_angsuran_margin,0,',','.'));
           
          });

          /*$("input#nilai_pembiayaan,input#jangka_waktu,input#margin_pembiayaan,input#angsuran_tabungan","#form_add").change(function(){
            var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val())); 
            var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));
            var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu").val()));  
            var angsuran_margin = margin_pembiayaan/jangka_waktu;
            var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));  
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));  
            console.log('margin_pembiayaan:'+margin_pembiayaan);
            console.log('nilai_pembiayaan:'+nilai_pembiayaan);
            console.log('jangka_waktu:'+jangka_waktu);
            console.log('angsuran_margin:'+angsuran_margin);
            console.log('angsuran_pokok:'+angsuran_pokok);
            console.log('angsuran_tabungan:'+angsuran_tabungan);
            console.log('tabungan_wajib:'+tabungan_wajib);
            console.log('tabungan_kelompok:'+tabungan_kelompok);
            var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            console.log('total:'+total);
            var addnominalangsuranpokok=pembulatan_total_angsuran(total);
            console.log('addnominalangsuranpokok:'+addnominalangsuranpokok);
            $("#angsuran_pokok").attr("readonly", true);
            $("#angsuran_pokok").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
            $("#angsuran_margin").attr("readonly", true);
            $("#angsuran_margin").val(number_format(angsuran_margin,0,',','.'));
            $("#total_angsuran").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          });*/


          // $("#jangka_waktu").change(function(){
          //   var jangka_waktu = $(this).val();  
          //   // console.log(margin_pembiayaan);
          //   var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val()));  
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));  
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));  
          //   // console.log(jangka_waktu);
          //   var total_angsuran1 = nilai_pembiayaan/jangka_waktu;
          //   // alert(number_format(total_angsuran1,0,'.',''))
          //   var total = total_angsuran1+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   var addnominalangsuranpokok=pembulatan_total_angsuran(total);
          //   $("#total_angsuran").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          //   $("#angsuran_pokok").val(number_format(total_angsuran1+addnominalangsuranpokok,0,',','.'));
          //   $("#angsuran_pokok").attr("readonly", true);

          // });

          // $("#jangka_waktu").change(function(){
          //   var jangka_waktu = $(this).val();  
          //   // console.log(margin_pembiayaan);
          //   var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val()));  
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));  
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));  
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));  
          //   // console.log(jangka_waktu);
          //   var total_angsuran1 = margin_pembiayaan/jangka_waktu;
          //   $("#angsuran_margin").attr("readonly", true);
          //   $("#angsuran_margin").val(number_format(total_angsuran1,0,',','.'));
          //   var total = total_angsuran1+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   $("#total_angsuran").val(number_format(total,0,',','.'));

          // });

          // $("#margin_pembiayaan").change(function(){
          //   var margin_pembiayaan = parseFloat(convert_numeric($(this).val()));  
          //   // console.log(margin_pembiayaan);
          //   var jangka_waktu = $("#jangka_waktu").val();  
          //   var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));  
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));  
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));  
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));  
          //   // console.log(jangka_waktu);
          //   var total_angsuran2 = margin_pembiayaan/jangka_waktu;
          //   $("#angsuran_margin").attr("readonly", true);
          //   $("#angsuran_margin").val(number_format(total_angsuran2,0,',','.'));
          //   var total = total_angsuran2+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   $("#total_angsuran").val(number_format(total,0,',','.'));
          //   // $("#angsuran_margin").attr("readonly", true);
          //   form_id=$(this).closest('form').attr('id');
          //   form_id=$("#"+form_id);
          //   calc_simpanan_wajib_pinjam(form_id)
          // });
  
          // // $("#angsuran_tabungan").change(function(){
          // $("input#angsuran_tabungan","#form_add").live('keyup',function(){
          //   var angsuran_pokok      = 0;
          //   var angsuran_margin     = 0;
          //   var angsuran_tabungan   = 0;
          //   var tabungan_wajib      = 0;
          //   var tabungan_kelompok   = 0;
          //   $("input#angsuran_tabungan","#form_add").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val())); 
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
          //   // console.log(angsuran_tabungan);
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));
          //   // console.log(tabungan_wajib);
          //   if(isNaN(tabungan_wajib)===true){
          //     tabungan_wajib = 0;
          //   }
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));
          //   // console.log(tabungan_kelompok);
          //   if(isNaN(tabungan_kelompok)===true){
          //     tabungan_kelompok = 0;
          //   }
          //   var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   $("#total_angsuran").val(number_format(total_angsuran3,0,',','.'));

          // });
          // });

          // $("input#tabungan_wajib","#form_add").live('keyup',function(){
          //   var angsuran_pokok      = 0;
          //   var angsuran_margin     = 0;
          //   var angsuran_tabungan   = 0;
          //   var tabungan_wajib      = 0;
          //   var tabungan_kelompok   = 0;
          //   $("input#tabungan_wajib","#form_add").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val())); 
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
          //   // console.log(angsuran_tabungan);
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));
          //   // console.log(tabungan_wajib);
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));
          //   // console.log(tabungan_kelompok);
          //   if(isNaN(tabungan_kelompok)===true){
          //     tabungan_kelompok = 0;
          //   }
          //   var total_angsuran4 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   $("#total_angsuran").val(number_format(total_angsuran4,0,',','.'));

          //   //Untuk memanggil  function simpanan wajib pinjam
          //   form_id=$(this).closest('form').attr('id');
          //   form_id=$("#"+form_id);
          //   calc_simpanan_wajib_pinjam(form_id)

          // });
          // });

          // $("input#tabungan_kelompok","#form_add").live('keyup',function(){
          //   var angsuran_pokok      = 0;
          //   var angsuran_margin     = 0;
          //   var angsuran_tabungan   = 0;
          //   var tabungan_wajib      = 0;
          //   var tabungan_kelompok   = 0;
          //   $("input#tabungan_kelompok","#form_add").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val()));  
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
          //   // console.log(angsuran_tabungan);
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));
          //   // console.log(tabungan_wajib);
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));
          //   // console.log(tabungan_kelompok);
          //   var total_angsuran5 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   $("#total_angsuran").val(number_format(total_angsuran5,0,',','.'));

          //   //Untuk memanggil  function simpanan wajib pinjam
          //   form_id=$(this).closest('form').attr('id');
          //   form_id=$("#"+form_id);
          //   calc_simpanan_wajib_pinjam(form_id)
          // });
          // });

          // $("input#nilai_pembiayaan","#form_add").live('keyup',function(){
          //   var angsuran_pokok      = 0;
          //   var angsuran_margin     = 0;
          //   var angsuran_tabungan   = 0;
          //   $("input#nilai_pembiayaan","#form_add").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val()));  
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
          //   // console.log(angsuran_tabungan);
          //   var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan;
          //   if(isNaN(total_angsuran3)===true){
          //     total_angsuran3 = 0;
          //   }
          //   $("#total_angsuran").val(number_format(total_angsuran3,0,',','.'));

          // });
          // });
  
          // $("input#margin_pembiayaan","#form_add").live('keyup',function(){
          //   var angsuran_pokok      = 0;
          //   var angsuran_margin     = 0;
          //   var angsuran_tabungan   = 0;
          //   $("input#margin_pembiayaan","#form_add").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin").val()));  
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
          //   // console.log(angsuran_tabungan);
          //   var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan;
          //   if(isNaN(total_angsuran3)===true){
          //     total_angsuran3 = 0;
          //   }
          //   $("#total_angsuran").val(number_format(total_angsuran3,0,',','.'));

          // });
          // });


          //Ajax Untuk sumber dan Pembiayaan
          $("#sendiri").hide();
          $("#kreditur").hide();
          $("#kreditur_campuran").hide();
          $("#sendiri_campuran").hide();
          
          $("#sumber_dana_pembiayaan").change(function(){
            var sumber_dana_pembiayaan = convert_numeric($("#sumber_dana_pembiayaan").val());
            var pokok = convert_numeric($("#nilai_pembiayaan").val());
            if(sumber_dana_pembiayaan=='0')
            {
              $("#dana_sendiri").val(number_format(pokok,0,',','.'));
              $("#sendiri").show();
              $("#sendiri_campuran").hide();
              $("#kreditur_campuran").hide();
              $("#kreditur").hide();
              // $("#sumber_dana_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus").focus();
              //     if(typeof($("#program_khusus").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if (sumber_dana_pembiayaan=='1') 
            {
              $("#kreditur").show();
              $("#kreditur_campuran").hide();
              $("#sendiri").hide();
              $("#sendiri_campuran").hide();
              // $("#sumber_dana_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_kreditur").select();
              //     if(typeof($("#dana_kreditur").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_kreditur").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_kreditur","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#keuntungan").select();
              //     if(typeof($("#keuntungan").offset())!='undefined') {
              //       $(window).scrollTop($("#keuntungan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#keuntungan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran").select();
              //     if(typeof($("#angsuran").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#pembayaran_kreditur").focus();
              //     if(typeof($("#pembayaran_kreditur").offset())!='undefined') {
              //       $(window).scrollTop($("#pembayaran_kreditur").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#pembayaran_kreditur","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus").focus();
              //     if(typeof($("#program_khusus").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if (sumber_dana_pembiayaan=='2') 
            {
              $("#dana_sendiri_campuran").val(number_format(pokok,0,',','.'));
              $("#kreditur").hide();
              $("#kreditur_campuran").show();
              $("#sendiri_campuran").show();
              $("#sendiri").hide();
              // $("#sumber_dana_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_sendiri_campuran").select();
              //     if(typeof($("#dana_sendiri_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_sendiri_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_sendiri_campuran","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_kreditur","#kreditur_campuran").select();
              //     if(typeof($("#dana_kreditur","#kreditur_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_kreditur","#kreditur_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_kreditur","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#keuntungan","#kreditur_campuran").select();
              //     if(typeof($("#keuntungan","#kreditur_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#keuntungan","#kreditur_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#keuntungan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran","#kreditur_campuran").select();
              //     if(typeof($("#angsuran","#kreditur_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran","#kreditur_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#pembayaran_kreditur","#kreditur_campuran").focus();
              //     if(typeof($("#pembayaran_kreditur","#kreditur_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#pembayaran_kreditur","#kreditur_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#pembayaran_kreditur","#kreditur_campuran").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus").focus();
              //     if(typeof($("#program_khusus").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#sendiri").hide();
              $("#kreditur").hide();
              $("#kreditur_campuran").hide();
              $("#sendiri_campuran").hide();
            }
          });

          //Ajax Untuk Program khusus dan jenis program
          $("#program").hide();
          
          $("#program_khusus").change(function(){
            var program_khusus = convert_numeric($("#program_khusus").val());    
            if(program_khusus=='0')
            {
              $("#program").show();
              // $("#program_khusus","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#jenis_program").focus();
              //     if(typeof($("#jenis_program").offset())!='undefined') {
              //       $(window).scrollTop($("#jenis_program").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#program").hide();
              // $("#program_khusus","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#sektor_ekonomi").focus();
              //     if(typeof($("#sektor_ekonomi").offset())!='undefined') {
              //       $(window).scrollTop($("#sektor_ekonomi").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
          });

      $("input[name='tgl_jtempo']","#form_add").change(function(){
        $("#product","#form_add").trigger('change');
      })

	  //fungsi untuk menggenerate NO REKENING
	  $(function(){
		
			$("#product").change(function(){
				var product_code = $("#product").val();
				var cif_no = $("#cif_no").val();  
        $("#jadwal_angsuran","#form_add").val('1').trigger('change');
				//mendapatkan jumlah maksimal sesuai product_code yang dipilih
				$.ajax({
          // url: site_url+"transaction/count_cif_by_product_code_financing",
          // url: site_url+"transaction/count_cif_by_cif_no_financing",
				  url: site_url+"transaction/get_seq_account_financing_no",
				  type: "POST",
				  dataType: "json",
          // data: {product_code:product_code},
				  data: {cif_no:cif_no,product_code:product_code},
				  success: function(response)
				  {
            var no_urut = response.newseq;
            // var data = response.jumlah;
					  // if(data==null)
					  // {
						 //  var total = 0;
					  // }
					  // else
					  // {
						 //  var total = data;
					  // }
					  // var jumlah = total; 
					  // var no_urut = parseFloat(jumlah)+1;
       //      if(no_urut<10){
       //        no_urut = '0'+no_urut;
       //      }
					  //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
           /* console.log(product_code);
            console.log(no_urut);*/
					  $("#account_financing_no").val(cif_no+''+product_code+''+no_urut);
				  }
				})
        console.log('bbbbbbbb')
        $.ajax({
          type:"POST",
          dataType:"json",
          data:{
            product_code:product_code
          },
          url:site_url+"transaction/get_product_financing_data_by_code",
          success:function(response){
            var data=response;
            $("#periode_angsuran","#form_add").val(data.periode_angsuran);
            rate_margin_min=data.rate_margin1;
            rate_margin_max=data.rate_margin2;

            global_rate_margin_min=rate_margin_min;
            global_rate_margin_max=rate_margin_max;

            global_rate_simpanan_wajib_pinjam=data.rate_simpanan_wajib_pinjam;
            $("#akad").val(data.akad_code).trigger('change');

          }
        });


        var tgl_jtempo = $("input[name='tgl_jtempo']","#form_add").val();
        var tgl_akad = $("input[name='tgl_akad']","#form_add").val();  
        var product = $("#product","#form_add").val();  
        var nilai_pembiayaan = convert_numeric($("#nilai_pembiayaan","#form_add").val());
        set_biaya_administrasi_add(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
        set_biaya_jasa_layanan_add(nilai_pembiayaan,product)

        var usia = $("input[name='usia']","#form_add").val();  
        var product_asuransi = $("#product option:selected","#form_add").attr('insuranceproductcode');  
        var manfaat = $("#product option:selected","#form_add").attr('flagmanfaatasuransi');
        var tgl_lahir = $("#tgl_lahir","#form_add").val();
        var pokok = parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
        var margin = parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val()));

        if(manfaat==0){
          manfaat_asuransi = pokok+margin;
        }else{
          manfaat_asuransi = pokok;
        }
        console.log('f')
        set_biaya_premi_asuransi_jiwa_add(product_asuransi,manfaat_asuransi,tgl_lahir,tgl_akad,tgl_jtempo,usia);
				
      });

    //   $("#product").change(function(){
        
    //     // $.ajax({
    //     //   url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
    //     //   type: "POST",
    //     //   dataType: "json",
    //     //   data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
    //     //   success: function(response)
    //     //   {
    //     //       $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
    //     //   }
    //     // })       
		
    // });
		});


//fungsi untuk menggenerate Nama Akad
    $(function(){

    $("#nisbah").hide();
    $("#margin_p").hide();
      $("#akad").change(function(){
        var akad = $("#akad").val();
        $.ajax({
          url: site_url+"transaction/get_ajax_jenis_keuntungan",
          type: "POST",
          dataType: "json",
          data: {akad:akad},
          success: function(response)
          {
            var data = response.jenis_keuntungan;
            if(data>=2)
            {
              $("#nisbah").show();
              $("#margin_p").hide();
              // $("select#akad","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan").select();
              //     if(typeof($("#nilai_pembiayaan").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nisbah_bagihasil").select();
              //     if(typeof($("#nisbah_bagihasil").offset())!='undefined') {
              //       $(window).scrollTop($("#nisbah_bagihasil").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if(data==1)
            {
              $("#nisbah").hide();
              $("#margin_p").show();
              // $("select#akad","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan").select();
              //     if(typeof($("#nilai_pembiayaan").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#margin_pembiayaan").select();
              //     if(typeof($("#margin_pembiayaan").offset())!='undefined') {
              //       $(window).scrollTop($("#margin_pembiayaan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#nisbah").hide();
              $("#margin_p").hide();
              // $("select#akad","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#nilai_pembiayaan").select();
              //     if(typeof($("#nilai_pembiayaan").offset())!='undefined') {
              //       $(window).scrollTop($("#nilai_pembiayaan").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("input#nilai_pembiayaan","#form_add").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#periode_angsuran").focus();
              //     if(typeof($("#periode_angsuran").offset())!='undefined') {
              //       $(window).scrollTop($("#periode_angsuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
          }
        })         
        
          });

    });



//fungsi untuk menampilkan jadwal angsuran
    $(function(){
 

          $("#jadwal_angsuran2").change(function(){
            $("#total_angs_pokok",form2).val(0)
            $("#total_angs_margin",form2).val(0)
            $("#total_angs_tabungan",form2).val(0)
            $("#total_angs_pokok",form1).val(0)
            $("#total_angs_margin",form1).val(0)
            $("#total_angs_tabungan",form1).val(0)
            //Untuk memanggil  function simpanan wajib pinjam
            form_id=$(this).closest('form').attr('id');
            form_id=$("#"+form_id);
            calc_simpanan_wajib_pinjam_edit(form_id)
            var jadwal_angsuran = $("#jadwal_angsuran2").val();    
            if(jadwal_angsuran=='1')
            {
              $("#non_reg2").show();
              $("#reg2").hide();
              // $("#jadwal_angsuran2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran_tabungan2").select();
              //     if(typeof($("#angsuran_tabungan2").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran_tabungan2").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran_tabungan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#tabungan_wajib2","#form_edit").select();
              //     if(typeof($("#tabungan_wajib2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#tabungan_wajib2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#tabungan_wajib2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#tabungan_kelompok2","#form_edit").select();
              //     if(typeof($("#tabungan_kelompok2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#tabungan_kelompok2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#tabungan_kelompok2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#cadangan_resiko","#form_edit").select();
              //     if(typeof($("#cadangan_resiko","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#cadangan_resiko","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#non_reg2").hide();
              $("#reg2").show();
            //   $("#jadwal_angsuran2","#form_edit").live('keydown',function(e){
            //     if(e.keyCode==13){
            //       $("#angs_tanggal","#form_edit").select();
            //       if(typeof($("#angs_tanggal","#form_edit").offset())!='undefined') {
            //         $(window).scrollTop($("#angs_tanggal","#form_edit").offset().top - 200);
            //       }
            //       return false;
            //     }
            //   });
            //   $("#angs_tanggal","#form_edit").live('keydown',function(e){
            //     if(e.keyCode==13){
            //       $("#angs_pokok","#form_edit").select();
            //       if(typeof($("#angs_pokok","#form_edit").offset())!='undefined') {
            //         $(window).scrollTop($("#angs_pokok","#form_edit").offset().top - 200);
            //       }
            //       return false;
            //     }
            //   });
            //   $("#angs_pokok","#form_edit").live('keydown',function(e){
            //     if(e.keyCode==13){
            //       $("#angs_margin","#form_edit").select();
            //       if(typeof($("#angs_margin","#form_edit").offset())!='undefined') {
            //         $(window).scrollTop($("#angs_margin","#form_edit").offset().top - 200);
            //       }
            //       return false;
            //     }
            //   });
            //   $("#angs_margin","#form_edit").live('keydown',function(e){
            //     if(e.keyCode==13){
            //       $("#angs_tabungan","#form_edit").select();
            //       if(typeof($("#angs_tabungan","#form_edit").offset())!='undefined') {
            //         $(window).scrollTop($("#angs_tabungan","#form_edit").offset().top - 200);
            //       }
            //       return false;
            //     }
            //   });
            }

           /* var nilai_pembiayaan = parseFloat($("#nilai_pembiayaan2").val());  
            if(isNaN(nilai_pembiayaan)===true){
              nilai_pembiayaan = 0;
            }
            // console.log(nilai_pembiayaan);
            var jangka_waktu = parseFloat($("#jangka_waktu2").val()); 
            if(isNaN(jangka_waktu)===true){
              jangka_waktu = 0;
            }
            // console.log(jangka_waktu); 
            var total_angsuran_pokok = nilai_pembiayaan/jangka_waktu;
            $("#angsuran_pokok2").val(total_angsuran_pokok);


            var margin_pembiayaan = parseFloat($("#margin_pembiayaan2").val());  
            // if(.isNaN()===true){
            if(isNaN(jangka_waktu)===true){
              margin_pembiayaan = 0;
            }
            // console.log(margin_pembiayaan);
            // var jangka_waktu = parseFloat($("#jangka_waktu").val());  
            // console.log(jangka_waktu);
            var total_angsuran_margin = margin_pembiayaan/jangka_waktu;
            $("#angsuran_margin2").val(total_angsuran_margin);*/

           
          });

          $("#nilai_pembiayaan2,#jangka_waktu2,#margin_pembiayaan2,input#angsuran_tabungan2","#form_edit").change(function(){
            var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan2").val())); 
            var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan2").val()));
            var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu2").val()));  
            var angsuran_margin = margin_pembiayaan/jangka_waktu;
            var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));  
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));  
            var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            var addnominalangsuranpokok=pembulatan_total_angsuran(total);
            $("#angsuran_pokok2").attr("readonly", true);
            $("#angsuran_pokok2").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
            $("#angsuran_margin2").attr("readonly", true);
            $("#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
            $("#total_angsuran2").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          });

          // $("","#form_edit").change(function(){ 
          //   var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan2").val())); 
          //   var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan2").val()));
          //   var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu2").val()));  
          //   var angsuran_margin = margin_pembiayaan/jangka_waktu;
          //   var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));  
          //   var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   var addnominalangsuranpokok=pembulatan_total_angsuran(total);
          //   $("#angsuran_pokok2").attr("readonly", true);
          //   $("#angsuran_pokok2").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
          //   $("#angsuran_margin2").attr("readonly", true);
          //   $("#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
          //   $("#total_angsuran2").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          // });

          // $("").change(function(){
          //   var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan2").val())); 
          //   var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan2").val()));
          //   var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu2").val()));  
          //   var angsuran_margin = margin_pembiayaan/jangka_waktu;
          //   var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));  
          //   var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   var addnominalangsuranpokok=pembulatan_total_angsuran(total);
          //   $("#angsuran_pokok2").attr("readonly", true);
          //   $("#angsuran_pokok2").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
          //   $("#angsuran_margin2").attr("readonly", true);
          //   $("#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
          //   $("#total_angsuran2").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          // });
  
          // $("","#form_edit").live('keyup',function(){
          //   var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan2").val())); 
          //   var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan2").val()));
          //   var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu2").val()));  
          //   var angsuran_margin = margin_pembiayaan/jangka_waktu;
          //   var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
          //   var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));  
          //   var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));  
          //   var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
          //   var addnominalangsuranpokok=pembulatan_total_angsuran(total);
          //   $("#angsuran_pokok2").attr("readonly", true);
          //   $("#angsuran_pokok2").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
          //   $("#angsuran_margin2").attr("readonly", true);
          //   $("#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
          //   $("#total_angsuran2").val(number_format(total+addnominalangsuranpokok,0,',','.'));
          // });
  
          // $("input#nilai_pembiayaan2","#form_edit").live('keyup',function(){
          //   var angsuran_pokok    = 0;
          //   var angsuran_margin   = 0;
          //   var angsuran_tabungan = 0;
          //   $("input#nilai_pembiayaan2","#form_edit").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok2").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin2").val()));  
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
          //   // console.log(angsuran_tabungan);
          //   var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan;
          //   if(isNaN(total_angsuran3)===true){
          //     total_angsuran3 = 0;
          //   }
          //   $("#total_angsuran2").val(number_format(total_angsuran3,0,',','.'));

          // });
          // });
  
          //  $("input#margin_pembiayaan2","#form_edit").live('keyup',function(){
          //   var angsuran_pokok    = 0;
          //   var angsuran_margin   = 0;
          //   var angsuran_tabungan = 0;
          //   $("input#margin_pembiayaan2","#form_edit").each(function(){
          //   var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok2").val()));
          //   // console.log(angsuran_pokok);  
          //   var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin2").val()));  
          //   // console.log(angsuran_margin);
          //   var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
          //   // console.log(angsuran_tabungan);
          //   var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan;
          //   if(isNaN(total_angsuran3)===true){
          //     total_angsuran3 = 0;
          //   }
          //   $("#total_angsuran2").val(number_format(total_angsuran3,0,',','.'));

          // });  
          // });  

    });

//fungsi untuk menampilkan sumber dana
    $(function(){
          
          $("#sumber_dana_pembiayaan2").change(function(){
          var sumber_dana2 = $("#sumber_dana_pembiayaan2").val(); 
            if(sumber_dana2=='0')
            {
              $("#sendiri2").show();
              $("#sendiri_campuran2").hide();
              $("#kreditur2").hide();
              $("#kreditur2_campuran").hide();
              // $("#sumber_dana_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus2","#form_edit").focus();
              //     if(typeof($("#program_khusus2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if(sumber_dana2=='1')
            {
              $("#kreditur2").show();
              $("#kreditur2_campuran").hide();
              $("#sendiri2").hide();
              $("#sendiri_campuran2").hide();
              // $("#sumber_dana_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_kreditur","#form_edit").select();
              //     if(typeof($("#dana_kreditur","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_kreditur","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_kreditur","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#keuntungan","#form_edit").select();
              //     if(typeof($("#keuntungan","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#keuntungan","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#keuntungan","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran","#form_edit").select();
              //     if(typeof($("#angsuran","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#pembayaran_kreditur","#form_edit").focus();
              //     if(typeof($("#pembayaran_kreditur","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#pembayaran_kreditur","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#pembayaran_kreditur","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus2","#form_edit").focus();
              //     if(typeof($("#program_khusus2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else if (sumber_dana2=='2') 
            {
              $("#sendiri_campuran2").show();
              $("#kreditur2").hide();
              $("#kreditur2_campuran").show();
              $("#sendiri2").hide();
              // $("#sumber_dana_pembiayaan2","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_sendiri_campuran","#form_edit").select();
              //     if(typeof($("#dana_sendiri_campuran","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_sendiri_campuran","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_sendiri_campuran","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#dana_kreditur","#kreditur2_campuran").select();
              //     if(typeof($("#dana_kreditur","#kreditur2_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#dana_kreditur","#kreditur2_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#dana_kreditur","#form_edit").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#keuntungan","#kreditur2_campuran").select();
              //     if(typeof($("#keuntungan","#kreditur2_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#keuntungan","#kreditur2_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#keuntungan","#kreditur2_campuran").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#angsuran","#kreditur2_campuran").select();
              //     if(typeof($("#angsuran","#kreditur2_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#angsuran","#kreditur2_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#angsuran","#kreditur2_campuran").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#pembayaran_kreditur2","#kreditur_campuran").focus();
              //     if(typeof($("#pembayaran_kreditur2","#kreditur_campuran").offset())!='undefined') {
              //       $(window).scrollTop($("#pembayaran_kreditur2","#kreditur_campuran").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
              // $("#pembayaran_kreditur2","#kreditur2_campuran").live('keydown',function(e){
              //   if(e.keyCode==13){
              //     $("#program_khusus2","#form_edit").focus();
              //     if(typeof($("#program_khusus2","#form_edit").offset())!='undefined') {
              //       $(window).scrollTop($("#program_khusus2","#form_edit").offset().top - 200);
              //     }
              //     return false;
              //   }
              // });
            }
            else
            {
              $("#kreditur2").hide();
              $("#sendiri2").hide();
              $("#sendiri_campuran2").hide();
            }

          });

          $("#nilai_pembiayaan2").change(function(){
            var nilai_pembiayaan2 = convert_numeric($(this).val());  
            $("#dana_sendiri","#form_edit").val(nilai_pembiayaan2);

          });
    });



//fungsi untuk mencari usia dalam tahun dan bulan
    $(function(){

      $("input[name='angsuranke1']","#form_add").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo']","#form_add").val();
        var tgl_akad            = $("input[name='tgl_akad']","#form_add").val();  
        var usia                = $("input[name='usia']","#form_add").val();
        //var product             = $("#product_asuransi","#form_add").val();  
        //var manfaat             = $("#manfaat_asuransi","#form_add").val();
        var product             = $("#product option:selected","#form_add").attr('insuranceproductcode');  
        var manfaat             = $("#product option:selected","#form_add").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_add").val();
        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val()));
        // console.log(margin);  

            if(manfaat==0)
            {
              total = pokok+margin;
            }
            else
            {
              total = pokok;
            }
            console.log('g')
        $.ajax({
          url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
          type: "POST",
          async: false,
          dataType: "json",
          data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
          success: function(response)
          {
              $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
          }
        })         
        
      });

    });


//fungsi untuk menampilkan sumber dana
    $(function(){

          $("#program_khusus2").change(function(){
            var program_khusus = $("#program_khusus2").val();    
            if(program_khusus=='0')
            {
              $("#program2").show();
              $("#program_khusus2","#form_edit").live('keydown',function(e){
                if(e.keyCode==13){
                  $("#jenis_program","#form_edit").focus();
                  if(typeof($("#jenis_program","#form_edit").offset())!='undefined') {
                    $(window).scrollTop($("#jenis_program","#form_edit").offset().top - 200);
                  }
                  return false;
                }
              });
            }
            else
            {
              $("#jenis_program","#form_edit").val('');
              $("#program2").hide();
              $("#program_khusus2","#form_edit").live('keydown',function(e){
                if(e.keyCode==13){
                  $("#sektor_ekonomi","#form_edit").focus();
                  if(typeof($("#sektor_ekonomi","#form_edit").offset())!='undefined') {
                    $(window).scrollTop($("#sektor_ekonomi","#form_edit").offset().top - 200);
                  }
                  return false;
                }
              });
            }
          });

          $("input[name='tgl_akad']","#form_add").change(function(){
          tgl_jtempo              = $("input[name='tgl_jtempo']","#form_add").val();
          tgl_akad                = $("input[name='tgl_akad']","#form_add").val();  
          product                 = $("#product","#form_add").val();  
          //var product             = produk.substring(1,4);
          nilai_pembiayaan      = convert_numeric($("#nilai_pembiayaan","#form_add").val());
          set_biaya_administrasi_add(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
          set_biaya_jasa_layanan_add(nilai_pembiayaan,product)
          });

          $("input[name='nilai_pembiayaan']","#form_add").change(function(){
          tgl_jtempo              = $("input[name='tgl_jtempo']","#form_add").val();
          tgl_akad                = $("input[name='tgl_akad']","#form_add").val();  
          product                 = $("#product","#form_add").val();  
          //var product             = produk.substring(1,4);
          var produkpremi         = $("#product option:selected","#form_add").attr('insuranceproductcode');  
          var manfaat             = $("#product option:selected","#form_add").attr('flagmanfaatasuransi');
          var nilai_pembiayaan      = convert_numeric($("#nilai_pembiayaan","#form_add").val());
          var manfaat             = product.substring(7);
          var tgl_lahir           = $("#tgl_lahir","#form_add").val();

          var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
          // console.log(pokok);  
          var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val()));
          // console.log(margin);  
          var usia                = $("input[name='usia']","#form_add").val();
          var periode_angsuran    = $("#periode_angsuran","#form_add").val();
          // if(periode_angsuran==2){
            jkwaktu=parseFloat($("#jangka_waktu","#form_add").val());
            global_min_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_min/100);
            global_max_nominal_margin=(pokok*jkwaktu)*(global_rate_margin_max/100);

            console.log(pokok);
            console.log(jkwaktu);
            console.log(global_min_nominal_margin);
            console.log(global_max_nominal_margin);
            if(parseFloat(global_rate_margin_max)<100 && parseFloat(global_rate_margin_min)!=0)
            {
              $("#margin_pembiayaan","#form_add").val(number_format(global_max_nominal_margin,0,',','.'));
            }

          // }

            if(manfaat==1)
            {
              total = pokok+margin;
            }
            else
            {
              total = pokok;
            }

            set_biaya_administrasi_add(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
            set_biaya_jasa_layanan_add(nilai_pembiayaan,product)

            $.ajax({
              type: "POST",
              url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
              dataType: "json",
              async:false,
              data: {
                product:product,
                total:total,
                tgl_lahir:tgl_lahir,
                tgl_akad:tgl_akad,
                tgl_jtempo:tgl_jtempo,
                usia:usia
              },
              success: function(response)
              {
                $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
              }
            });

            var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val())); 
            var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
            var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu","#form_add").val()));  
            var angsuran_margin = margin_pembiayaan/jangka_waktu;
            var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan","#form_add").val()));
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib","#form_add").val()));  
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok","#form_add").val()));  
            var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            var addnominalangsuranpokok=pembulatan_total_angsuran(total);
            $("#angsuran_pokok").attr("readonly", true);
            $("#angsuran_pokok").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
            $("#angsuran_margin").attr("readonly", true);
            $("#angsuran_margin").val(number_format(angsuran_margin,0,',','.'));
            $("#total_angsuran").val(number_format(total+addnominalangsuranpokok,0,',','.'));

          });



        $("input[name='tgl_akad']","#form_add").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo']","#form_add").val();
        var tgl_akad            = $("input[name='tgl_akad']","#form_add").val();  
        var product             = $("#product option:selected","#form_add").attr('insuranceproductcode');  
        var manfaat             = $("#product option:selected","#form_add").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_add").val();
        var usia                = $("input[name='usia']","#form_add").val();

        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val()));
        // console.log(margin);  

            if(manfaat==0)
            {
              total = pokok+margin;
            }
            else
            {
              total = pokok;
            }
            console.log('i')
        $.ajax({
          url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
          type: "POST",
          async: false,
          dataType: "json",
          data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
          success: function(response)
          {
              $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
          }
        })         
        
      });

        $("input[name='margin_pembiayaan']","#form_add").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo']","#form_add").val();
        var tgl_akad            = $("input[name='tgl_akad']","#form_add").val();  
        var product             = $("#product option:selected","#form_add").attr('insuranceproductcode');  
        var manfaat             = $("#product option:selected","#form_add").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_add").val();
        var usia                = $("input[name='usia']","#form_add").val(); 

        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan","#form_add").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan","#form_add").val()));
        // console.log(margin);  

        var bValid=true;

        // if(margin>=global_min_nominal_margin && margin<=max_nominal_margin){
        //   bValid=true;
        // }else{
        //   bValid=false;
        //   alert("Nominal Margin melebihi Batas Maksimum")
        // }
        if(parseFloat(global_rate_margin_max)<100 && parseFloat(global_rate_margin_max)!=0)
        {
          if(margin<global_min_nominal_margin){
            bValid=false;
            // alert("Nominal margin kurang dari batas minimal");
            $("#margin_pembiayaan").select();
          }else if(margin>global_max_nominal_margin){
            bValid=false;
            // alert("Nominal margin melebihi batas maksimal");
            $("#margin_pembiayaan").select();
          }else{
            bValid=true;
          }
        }

        if(bValid==true)
        {
          if(manfaat==0)
          {
            total = pokok+margin;
          }
          else
          {
            total = pokok;
          }
          console.log('j')
          $.ajax({
            url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
            type: "POST",
            async: false,
            dataType: "json",
            data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
            success: function(response)
            {
                $("input[name='p_asuransi_jiwa']","#form_add").val(number_format(response.p_asuransi_jiwa,0,'',''));
            }
          })

        }
      });

    });

//Event ketike angsuran pada form edit diubah
    $(function(){
          $("#angsuran_tabungan2").change(function(){
            var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok2").val()));
            // console.log(angsuran_pokok);  
            var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin2").val())) 
            // console.log(angsuran_margin);
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
            // console.log(angsuran_tabungan);
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));
            // console.log(tabungan_wajib);
            if(isNaN(tabungan_wajib)===true){
              tabungan_wajib = 0;
            }
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));
            // console.log(tabungan_kelompok);
            if(isNaN(tabungan_kelompok)===true){
              tabungan_kelompok = 0;
            }
            var total_angsuran3 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            $("#total_angsuran2").val(number_format(total_angsuran3,0,'.',''));

            //Untuk memanggil  function simpanan wajib pinjam
            form_id=$(this).closest('form').attr('id');
            form_id=$("#"+form_id);
            calc_simpanan_wajib_pinjam_edit(form_id)

          });

          $("#tabungan_wajib2").change(function(){
            var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok2").val()));
            // console.log(angsuran_pokok);  
            var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin2").val())) 
            // console.log(angsuran_margin);
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
            // console.log(angsuran_tabungan);
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));
            // console.log(tabungan_wajib);
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));
            // console.log(tabungan_kelompok);
            if(isNaN(tabungan_kelompok)===true){
              tabungan_kelompok = 0;
            }
            var total_angsuran4 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            $("#total_angsuran2").val(number_format(total_angsuran4,0,'.',''));

            //Untuk memanggil  function simpanan wajib pinjam
            form_id=$(this).closest('form').attr('id');
            form_id=$("#"+form_id);
            calc_simpanan_wajib_pinjam_edit(form_id)

          });

          $("#tabungan_kelompok2").change(function(){
            var angsuran_pokok = parseFloat(convert_numeric($("#angsuran_pokok2").val()));
            // console.log(angsuran_pokok);  
            var angsuran_margin = parseFloat(convert_numeric($("#angsuran_margin2").val())) 
            // console.log(angsuran_margin);
            var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
            // console.log(angsuran_tabungan);
            var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib2").val()));
            // console.log(tabungan_wajib);
            var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok2").val()));
            // console.log(tabungan_kelompok);
            var total_angsuran5 = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
            $("#total_angsuran2").val(number_format(total_angsuran5,0,'.',''));
            
            //Untuk memanggil  function simpanan wajib pinjam
            form_id=$(this).closest('form').attr('id');
            form_id=$("#"+form_id);
            calc_simpanan_wajib_pinjam_edit(form_id)

          });

          $("input[name='tgl_akad_edit']","#form_edit").change(function(){
          tgl_jtempo              = $("input[name='tgl_jtempo_edit']","#form_edit").val();
          tgl_akad                = $("input[name='tgl_akad_edit']","#form_edit").val();  
          product                 = $("#product2","#form_edit").val();  
          //var product             = produk.substring(1,4);
          nilai_pembiayaan      = convert_numeric($("#nilai_pembiayaan2","#form_edit").val());
          set_biaya_administrasi_edit(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
          set_biaya_jasa_layanan_edit(nilai_pembiayaan,product)
          });

          $("input[name='nilai_pembiayaan']","#form_edit").change(function(){
            var tgl_jtempo              = $("input[name='tgl_jtempo_edit']","#form_edit").val();
            var tgl_akad                = $("input[name='tgl_akad_edit']","#form_edit").val();  
            var product                 = $("#product2","#form_edit").val();  
            var nilai_pembiayaan        = convert_numeric($("#nilai_pembiayaan2","#form_edit").val());
            set_biaya_administrasi_edit(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
            set_biaya_jasa_layanan_edit(nilai_pembiayaan,product)
            $("#jangka_waktu2","#form_edit").trigger('change');
          });

        $("select[name='product']","#form_edit").change(function(){
          tgl_jtempo              = $("input[name='tgl_jtempo_edit']","#form_edit").val();
          tgl_akad                = $("input[name='tgl_akad_edit']","#form_edit").val();  
          product                 = $("#product2","#form_edit").val();  
          nilai_pembiayaan        = convert_numeric($("#nilai_pembiayaan2","#form_edit").val());
          set_biaya_administrasi_edit(tgl_jtempo,tgl_akad,product,nilai_pembiayaan);
          set_biaya_jasa_layanan_edit(nilai_pembiayaan,product)
        });

        $("select[name='product']","#form_edit").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo_edit']","#form_edit").val();
        var tgl_akad            = $("input[name='tgl_akad_edit']","#form_edit").val();  
        var product             = $("#product2 option:selected","#form_edit").attr('insuranceproductcode');  
        var manfaat             = $("#product2 option:selected","#form_edit").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_edit").val();
        var usia                = $("input[name='usia']","#form_edit").val();

        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan2","#form_edit").val()));
        // console.log(margin);  

            if(manfaat==0)
            {
              total = pokok+margin;
            }
            else
            {
              total = pokok;
            }
            console.log('b')
        $.ajax({
          url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
          type: "POST",
          async: false,
          dataType: "json",
          data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
          success: function(response)
          {
              $("input[name='p_asuransi_jiwa']","#form_edit").val(number_format(response.p_asuransi_jiwa,0,'',''));
          }
        })         
        
      });

        $("input[name='nilai_pembiayaan']","#form_edit").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo_edit']","#form_edit").val();
        var tgl_akad            = $("input[name='tgl_akad_edit']","#form_edit").val();  
        var product             = $("#product2 option:selected","#form_edit").attr('insuranceproductcode');  
        var manfaat             = $("#product2 option:selected","#form_edit").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_edit").val();
        var usia                = $("input[name='usia']","#form_edit").val();

        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan2","#form_edit").val()));
        // console.log(margin);  

        var periode_angsuran    = $("#periode_angsuran2","#form_edit").val();
        if(periode_angsuran==2){
          jkwaktu=parseFloat($("#jangka_waktu2","#form_edit").val());
          global_min_nominal_margin_edit=(pokok*jkwaktu)*(global_rate_margin_min_edit/100);
          global_max_nominal_margin_edit=(pokok*jkwaktu)*(global_rate_margin_max_edit/100);

          console.log(global_min_nominal_margin_edit);
          console.log(global_max_nominal_margin_edit);

          $("#margin_pembiayaan2","#form_edit").val(number_format(global_max_nominal_margin_edit,0,',','.'));

        }

        if(manfaat==0){
          total = pokok+margin;
        }else{
          total = pokok;
        }
        console.log('c')
        $.ajax({
          url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
          type: "POST",
          async: false,
          dataType: "json",
          data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
          success: function(response)
          {
              $("input[name='p_asuransi_jiwa']","#form_edit").val(number_format(response.p_asuransi_jiwa,0,'',''));
          }
        })         
        
      });

      $("input[name='margin_pembiayaan']","#form_edit").change(function(){
        var tgl_jtempo          = $("input[name='tgl_jtempo_edit']","#form_edit").val();
        var tgl_akad            = $("input[name='tgl_akad_edit']","#form_edit").val();  
        var product             = $("#product2 option:selected","#form_edit").attr('insuranceproductcode');  
        var manfaat             = $("#product2 option:selected","#form_edit").attr('flagmanfaatasuransi');
        var tgl_lahir           = $("#tgl_lahir","#form_edit").val();
        var usia                = $("input[name='usia']","#form_edit").val();

        var pokok               =  parseFloat(convert_numeric($("#nilai_pembiayaan2","#form_edit").val()));
        // console.log(pokok);  
        var margin              =  parseFloat(convert_numeric($("#margin_pembiayaan2","#form_edit").val()));
        // console.log(margin);  

        var bValid=true;

        // if(margin>=global_min_nominal_margin && margin<=max_nominal_margin){
        //   bValid=true;
        // }else{
        //   bValid=false;
        //   alert("Nominal Margin melebihi Batas Maksimum")
        // }

        if(margin<global_min_nominal_margin_edit){
          bValid=false;
          // alert("Nominal margin kurang dari batas minimal");
          $("#margin_pembiayaan2").select();
        }else if(margin>global_max_nominal_margin_edit){
          bValid=false;
          // alert("Nominal margin melebihi batas maksimal");
          $("#margin_pembiayaan2").select();
        }else{
          bValid=true;
        }

        if(manfaat==0){
          total = pokok+margin;
        }else{
          total = pokok;
        }
        console.log('d')
        $.ajax({
          url: site_url+"transaction/get_ajax_biaya_premi_asuransi_jiwa",
          type: "POST",
          async: false,
          dataType: "json",
          data: {product:product,total:total,tgl_lahir:tgl_lahir,tgl_akad:tgl_akad,tgl_jtempo:tgl_jtempo,usia:usia},
          success: function(response)
          {
              $("input[name='p_asuransi_jiwa']","#form_edit").val(number_format(response.p_asuransi_jiwa,0,'',''));
          }
        })         
        
      });

    });

    $("input[name='tgl_jtempo_edit']","#form_edit").change(function(){
      $("select[name='product']","#form_edit").trigger('change');
    })

    /*$("#form_add").submit(function(event){
    
      var account_financing_no = $("#account_financing_no").val();
      $.ajax({
        type: "POST",
        url: site_url+"transaction/check_account_financing_no",
        async: false,
        dataType: "json",
        data: {account_financing_no:account_financing_no},
        success: function(response){
          if(response.stat==false){
            $("#error_account").html('<span style="color:red;font-weight:bold;">'+response.message+'</span>');
            event.preventDefault();
          }
        }
      });
      
    });*/

      // /*UP UNTUK FUNGSI ADD ENTER*/
      // $("select#product","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#akad").focus();
      //     if(typeof($("#akad").offset())!='undefined') {
      //       $(window).scrollTop($("#akad").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#nisbah_bagihasil","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#periode_angsuran").focus();
      //     if(typeof($("#periode_angsuran").offset())!='undefined') {
      //       $(window).scrollTop($("#periode_angsuran").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#margin_pembiayaan","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#periode_angsuran").focus();
      //     if(typeof($("#periode_angsuran").offset())!='undefined') {
      //       $(window).scrollTop($("#periode_angsuran").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("select#periode_angsuran","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='jangka_waktu']").select();
      //     if(typeof($("input[name='jangka_waktu']").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='jangka_waktu']").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#jangka_waktu","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_pengajuan']").select();
      //     if(typeof($("input[name='tgl_pengajuan']").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_pengajuan']").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_pengajuan']","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_akad']").select();
      //     if(typeof($("input[name='tgl_akad']").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_akad']").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_akad']","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='angsuranke1']").select();
      //     if(typeof($("input[name='angsuranke1']").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='angsuranke1']").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='angsuranke1']","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_jtempo']").select();
      //     if(typeof($("input[name='tgl_jtempo']").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_jtempo']").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_jtempo']","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#jadwal_angsuran").focus();
      //     if(typeof($("#jadwal_angsuran").offset())!='undefined') {
      //       $(window).scrollTop($("#jadwal_angsuran").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#cadangan_resiko","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#dana_kebajikan").focus();
      //     if(typeof($("#dana_kebajikan").offset())!='undefined') {
      //       $(window).scrollTop($("#dana_kebajikan").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#dana_kebajikan","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#biaya_administrasi").focus();
      //     if(typeof($("#biaya_administrasi").offset())!='undefined') {
      //       $(window).scrollTop($("#biaya_administrasi").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#biaya_administrasi","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#biaya_notaris").focus();
      //     if(typeof($("#biaya_notaris").offset())!='undefined') {
      //       $(window).scrollTop($("#biaya_notaris").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#biaya_notaris","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#p_asuransi_jiwa").focus();
      //     if(typeof($("#p_asuransi_jiwa").offset())!='undefined') {
      //       $(window).scrollTop($("#p_asuransi_jiwa").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#p_asuransi_jiwa","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#p_asuransi_jaminan").focus();
      //     if(typeof($("#p_asuransi_jaminan").offset())!='undefined') {
      //       $(window).scrollTop($("#p_asuransi_jaminan").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#p_asuransi_jaminan","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#sumber_dana_pembiayaan").focus();
      //     if(typeof($("#sumber_dana_pembiayaan").offset())!='undefined') {
      //       $(window).scrollTop($("#sumber_dana_pembiayaan").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#sektor_ekonomi","#form_add").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#peruntukan_pembiayaan").focus();
      //     if(typeof($("#peruntukan_pembiayaan").offset())!='undefined') {
      //       $(window).scrollTop($("#peruntukan_pembiayaan").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // /*UP UNTUK FUNGSI ADD ENTER*/


      // /*UP UNTUK FUNGSI EDIT ENTER*/
      // $("select#product2","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#akad2","#form_edit").focus();
      //     if(typeof($("#akad2","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#akad2","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#nisbah_bagihasil","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#periode_angsuran2","#form_edit").focus();
      //     if(typeof($("#periode_angsuran2","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#periode_angsuran2","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#margin_pembiayaan2","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#periode_angsuran2","#form_edit").focus();
      //     if(typeof($("#periode_angsuran2","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#periode_angsuran2","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("select#periode_angsuran2","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='jangka_waktu']","#form_edit").select();
      //     if(typeof($("input[name='jangka_waktu']","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='jangka_waktu']","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input#jangka_waktu2","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_pengajuan_edit']","#form_edit").select();
      //     if(typeof($("input[name='tgl_pengajuan_edit']","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_pengajuan_edit']","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_pengajuan_edit']","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_akad_edit']","#form_edit").select();
      //     if(typeof($("input[name='tgl_akad_edit']","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_akad_edit']","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_akad_edit']","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='angsuranke1_edit']","#form_edit").select();
      //     if(typeof($("input[name='angsuranke1_edit']","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='angsuranke1_edit']","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='angsuranke1_edit']","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("input[name='tgl_jtempo_edit']","#form_edit").select();
      //     if(typeof($("input[name='tgl_jtempo_edit']","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("input[name='tgl_jtempo_edit']","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("input[name='tgl_jtempo_edit']","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#jadwal_angsuran2","#form_edit").focus();
      //     if(typeof($("#jadwal_angsuran2","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#jadwal_angsuran2","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#cadangan_resiko","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#dana_kebajikan","#form_edit").focus();
      //     if(typeof($("#dana_kebajikan","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#dana_kebajikan","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#dana_kebajikan","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#biaya_administrasi","#form_edit").focus();
      //     if(typeof($("#biaya_administrasi","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#biaya_administrasi","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#biaya_administrasi","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#biaya_notaris","#form_edit").focus();
      //     if(typeof($("#biaya_notaris","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#biaya_notaris","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#biaya_notaris","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#p_asuransi_jiwa","#form_edit").focus();
      //     if(typeof($("#p_asuransi_jiwa","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#p_asuransi_jiwa","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#p_asuransi_jiwa","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#p_asuransi_jaminan","#form_edit").focus();
      //     if(typeof($("#p_asuransi_jaminan","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#p_asuransi_jaminan","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#p_asuransi_jaminan","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#sumber_dana_pembiayaan2","#form_edit").focus();
      //     if(typeof($("#sumber_dana_pembiayaan2","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#sumber_dana_pembiayaan2","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // $("#sektor_ekonomi","#form_edit").live('keydown',function(e){
      //   if(e.keyCode==13){
      //     $("#peruntukan_pembiayaan","#form_edit").focus();
      //     if(typeof($("#peruntukan_pembiayaan","#form_edit").offset())!='undefined') {
      //       $(window).scrollTop($("#peruntukan_pembiayaan","#form_edit").offset().top - 200);
      //     }
      //     return false;
      //   }
      // });
      // /*UP UNTUK FUNGSI EDIT ENTER*/

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown


    $("a#link-regis").live('click',function(){
      form1.trigger('reset');
      $("#wrapper-table").hide();
      $("#add").show();
      var registration_no = $(this).attr('registration_no');
      var cif_no = $(this).attr('cif_no');
      var fa_code = $(this).attr('fa_code');
      $("#fa_code","#form_add").val(fa_code);
      $("#registration_no").val(registration_no);
      //fungsi untuk mendapatkan value untuk field-field yang diperlukan
      var no_reg = registration_no;
      $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        data: {registration_no:registration_no},
        url: site_url+"transaction/ajax_get_data_pengajuan_by_registration_no",
        success: function(response)
        {
          $("#branch_code").val(response.branch_code);
          $("#cif_no").val(response.cif_no);
          // $("#resort_name").val(response.resort_name);
          $("#resort_code").val(response.resort_code);
          $("#nama").val(response.nama);
          $("#panggilan").val(response.panggilan);
          $("#ibu_kandung").val(response.ibu_kandung);
          $("#tmp_lahir").val(response.tmp_lahir);
          $("#tgl_lahir").val(response.tgl_lahir);
          $("#usia").val(response.usia);
          $("#cif_type_hidden").val(response.cif_type);
          if(response.cif_type==1){
            $("#div_tabungan_wajib").hide();
            $("#div_tabungan_kelompok").hide();
          }else{
            $("#div_tabungan_wajib").show();
            $("#div_tabungan_kelompok").show();
          }
          var type = response.cif_type;
          if(type==1){
              $.ajax({
                 type: "POST",
                 url: site_url+"transaction/get_account_saving",
                 dataType: "json",
                 async: false,
                 data: {cif_no:response.cif_no},
                 success: function(response){
                    html = '<option value="">PILIH</option>';
                    for ( i = 0 ; i < response.length ; i++ )
                    {
                       html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                    }
                    $("#account_saving","#form_add").html(html);
                 }
              });   
              $("#saving").show();
              $("#id_jaminan","#form_add").show();
          }
          else{
              $("#saving").hide();
              $("#id_jaminan","#form_add").hide();
          }
          $("#uang_muka").val(response.uang_muka);
          $("#nilai_pembiayaan").val(response.amount);
          $("#account_financing_reg_id").val(response.account_financing_reg_id);
          $("#form_add select[name='peruntukan_pembiayaan']").val(response.peruntukan);
          var tanggal_pengajuan = response.tanggal_pengajuan;
          if(tanggal_pengajuan==undefined)
          {
            tanggal_pengajuan='';
          }
          // $data['current_date'] = $this->format_date_detail($this->current_date(),'id',false,'/');
          var tgl_pengajuan = tanggal_pengajuan.substr(8,2);
          var bln_pengajuan = tanggal_pengajuan.substr(5,2);
          var thn_pengajuan = tanggal_pengajuan.substr(0,4);
          var tgl_akhir_pengajuan = tgl_pengajuan+"/"+bln_pengajuan+"/"+thn_pengajuan;
          // document.getElementsByName('tgl_pengajuan').value=tgl_akhir_pengajuan;
          $("#form_add input[name='tgl_pengajuan']").val(tgl_akhir_pengajuan);

          var tgl_registrasi = "<?php echo date('d-m-Y')?>";
          $("#form_add input[name='tgl_registrasi']").val(tgl_registrasi);

          $.ajax({
           type: "POST",
           url: site_url+"transaction/get_ajax_produk_by_cif_type",
           dataType: "json",
           data: {cif_type:response.cif_type},
           async: false,
           success: function(response){
              html = '<option value="">PILIH</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 // html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
                 html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
              }
              $("#product","#form_add").html(html);
           }
          });   
          $("#form_add select[name='product']").val(response.product_code);
          if(response.product_code!=null){
            $("#product","#form_add").trigger('change');
          }
          $("#form_add input[name='tgl_pengajuan']").trigger('change');

        }                 
      });
    });

});

$(function(){

  /*
  |-------------------------------------------------------------------------------
  | BEGIN : ENTER EVENT FOR ADD & EDIT
  |-------------------------------------------------------------------------------
  */

  $("input,select","#form_add").live('keypress',function(e){
    if(e.keyCode==13) {
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT') {
        $(this).next().focus();
      }else{
        if($(this).closest('.control-group').next('.form-actions').length==1){
          $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
        }else{
          if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
            $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
          }else{
            $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
          }
        }
      }
    }
  });

  $("input,select","#form_edit").live('keypress',function(e){
    if(e.keyCode==13){
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT'){
        $(this).next().focus();
      }else{
        if($(this).closest('.control-group').next('.form-actions').length==1){
          $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
        }else{
          if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
            $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
          }else{
            $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
          }
        }
      }
    }
  });

  /*
  |-------------------------------------------------------------------------------
  | END : ENTER EVENT FOR ADD & EDIT
  |-------------------------------------------------------------------------------
  */
})

$(document).ready(function(){
  $("input#jangka_waktu,input#margin_pembiayaan,input#angsuran_tabungan","#form_add").change(function(){
    var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val())); 
    var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));
    var jangka_waktu = parseFloat(convert_numeric($("#jangka_waktu").val()));  
    var angsuran_margin = margin_pembiayaan/jangka_waktu;
    var angsuran_pokok = nilai_pembiayaan/jangka_waktu;
    var angsuran_tabungan = parseFloat(convert_numeric($("#angsuran_tabungan").val()));
    var tabungan_wajib = parseFloat(convert_numeric($("#tabungan_wajib").val()));  
    var tabungan_kelompok = parseFloat(convert_numeric($("#tabungan_kelompok").val()));  
    var total = angsuran_margin+angsuran_pokok+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
    var addnominalangsuranpokok=pembulatan_total_angsuran(total);
    $("#angsuran_pokok").attr("readonly", true);
    $("#angsuran_pokok").val(number_format(angsuran_pokok+addnominalangsuranpokok,0,',','.'));
    $("#angsuran_margin").attr("readonly", true);
    $("#angsuran_margin").val(number_format(angsuran_margin,0,',','.'));
    $("#total_angsuran").val(number_format(total+addnominalangsuranpokok,0,',','.'));
  });
})
</script>
<!-- END JAVASCRIPTS -->

