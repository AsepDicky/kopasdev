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
      Pembiayaan <small>Pengajuan Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pengajuan Rekening Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<style type="text/css">
  .radio input[type="radio"], .checkbox input[type="checkbox"] {
    float: left;
    margin-left: 0 !important;
}
</style>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pengajuan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix" style="border-bottom:solid 1px #DDD;margin-bottom:10px;">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Tambah Pengajuan Baru <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th>
               <th width="13%">No. Pengajuan</th>
               <th width="35%">Nama Lengkap</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="15%">Tgl Dibuat</th>
               <th width="18%">Jumlah</th>
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


<!-- BEGIN ADD  -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal"> 
          <input type="hidden" id="no_cif" name="no_cif">
          <input type="hidden" id="status_pengajuan" name="status_pengajuan">
          <input type="hidden" id="status_rekening_pembiayaan" name="status_rekening_pembiayaan">
          <input type="hidden" id="count_pengajuan" name="count_pengajuan">
            <div class="alert alert-error hide">
               <!-- <button class="close" data-dismiss="alert"></button> -->
               <span id="span_message"></span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>        
                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pegawai ::</h4></label>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">NIK<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>

                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari Pegawai</h3>
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="large m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                         
                    <div class="control-group">
                       <label class="control-label">Band Posisi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="band" id="band" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
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
                          <textarea name="alamat" id="alamat" class="large m-wrap"/>
                          </textarea>
                       </div>
                    </div>                     
                    <div class="control-group">
                       <label class="control-label">No KTP<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" maxlength="20"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                       </div>
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">No Handphone<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" maxlength="15"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tlp Kantor<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="telpon_rumah" id="telpon_rumah" class="medium m-wrap" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" maxlength="30" placeholder="Suami/Istri" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" maxlength="30" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" maxlength="2" value="0" style="width:50px;"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Status Rumah<span class="required">*</span></label>
                       <div class="controls">
                           <select id="status_rumah" name="status_rumah" class="m-wrap">
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
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" readonly="" style="background-color:#eee;">
                           </div>
                        </div>
                    </div>    
                    <hr>    

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Penghasilan Perbulan ::</h4></label>
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
                       <label class="control-label">Kewajiban Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          <input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1" /><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <!-- <div class="control-group">
                       <label class="control-label">Lunasi Ke Kopegtel</label>
                       <div class="controls" style="padding-top:0px">
                         <label class="radio">
                           <input type="radio" name="lunasi_kopegtel" id="lunasi_kopegtel1" value="1" style="margin-top:3px" checked />
                           &nbsp;Ya
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio">
                           <input type="radio" name="lunasi_kopegtel" id="lunasi_kopegtel2" value="0" style="margin-top:3px" />
                            &nbsp;Tidak
                         </label> 
                       </div>
                    </div>  -->           
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pengajuan ::</h4></label>
                    </div>  
                    <div class="control-group">
                      <label class="control-label">Pengajuan Melalui <span class="required">*</span></label>
                      <div class="controls">
                         <label class="radio" id="radio1">
                           <input type="radio" name="melalui" id="melalui1" value="koptel" style="margin-top:3px" checked />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" style="margin-top:3px" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="large m-wrap">
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
                           <select id="product_code" name="product_code" class="m-wrap">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" max_jangka_waktu="<?php echo $produk['max_jangka_waktu'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                            <option value="">PILIH</option>
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?> - <?php echo $data['code_value'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Keterangan Peruntukan</label>
                       <div class="controls">
                          <input type="text" name="keterangan_peruntukan" id="keterangan_peruntukan" class="large m-wrap" maxlength="100" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>               
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> *bulan
                        </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" value="<?php echo $date;?>" class="date-picker small m-wrap"/>
                       </div>
                    </div>    
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Margin dan Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Total Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>                   
            <div class="form-actions">
               <input type="hidden" name="gender" id="gender">
               <input type="hidden" name="cif_id" id="cif_id">
               <input type="hidden" name="status_financing_reg" id="status_financing_reg">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_thp100" id="flag_thp100">
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
         <div class="caption"><i class="icon-reorder"></i>Edit Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <div class="alert alert-error hide">
               <!-- <button class="close" data-dismiss="alert"></button> -->
               <span id="span_message"></span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Pengajuan Pembiayaan Berhasil!
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
                       <label class="control-label">Band Posisi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="band" id="band" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
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
                          <textarea name="alamat" id="alamat" class="large m-wrap"/>
                          </textarea>
                       </div>
                    </div>                     
                    <div class="control-group">
                       <label class="control-label">No KTP<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" maxlength="20"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                       </div>
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">No Handphone<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Tlp Kantor<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="telpon_rumah" id="telpon_rumah" class="medium m-wrap" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" maxlength="30" placeholder="Suami/Istri" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Pekerjaan Pasangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" maxlength="30" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" maxlength="2" value="0" style="width:50px;" />
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Status Rumah<span class="required">*</span></label>
                       <div class="controls">
                           <select id="status_rumah" name="status_rumah" class="m-wrap">
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
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening"  readonly="" style="background-color:#eee;">
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
                       <label class="control-label">Kewajiban Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          <input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1" /><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <!-- <div class="control-group">
                       <label class="control-label">Lunasi Ke Kopegtel</label>
                       <div class="controls" style="padding-top:0px">
                         <label class="radio">
                           <input type="radio" name="lunasi_kopegtel" id="lunasi_kopegtel1" value="1" style="margin-top:3px" />
                           &nbsp;Ya
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio">
                           <input type="radio" name="lunasi_kopegtel" id="lunasi_kopegtel2" value="0" style="margin-top:3px" />
                            &nbsp;Tidak
                         </label> 
                       </div>
                    </div>  -->           
                    <hr>  

                    <div class="control-group">
                       <label style="text-align:left"><h4>Data Pengajuan ::</h4></label>
                    </div>  
                    <div class="control-group">
                      <label class="control-label">Pengajuan Melalui <span class="required">*</span></label>
                      <div class="controls">
                         <label class="radio" id="radio1">
                           <input type="radio" name="melalui" id="melalui1" value="koptel" style="margin-top:3px" />
                           &nbsp;KOPTEL (Langsung)
                         </label> &nbsp;&nbsp;&nbsp;
                         <label class="radio" id="radio2">
                           <input type="radio" name="melalui" id="melalui2" value="koperasi" style="margin-top:3px" />
                            &nbsp;Mitra Koperasi
                         </label> 
                         <span style="display:none;" id="div_kopegtel">
                           <select id="kopegtel" name="kopegtel" class="m-wrap">
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
                           <select id="product_code" name="product_code" class="m-wrap">
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?> - <?php echo $data['code_value'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>                      
                    <div class="control-group">
                       <label class="control-label">Keterangan Peruntukan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="keterangan_peruntukan" id="keterangan_peruntukan" class="large m-wrap" maxlength="100" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> *bulan
                        </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
                    </div>    
                    <hr>   

                    <div class="control-group">
                       <label style="text-align:left"><h4>Margin dan Angsuran ::</h4></label>
                    </div> 
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Total Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="angsuran_margin" id="angsuran_margin" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="total_angsuran" id="total_angsuran" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>        
            <div class="form-actions">
               <input type="hidden" name="gender" id="gender">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_thp100" id="flag_thp100">
               <button type="submit" class="btn purple">Update</button>
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

      $("#amount","#form_add").val(0).prop(0);
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

      function hitung_margin_form_add()
      {
        var rate          = $("#product_code","#form_add").find('option:selected').attr('maxrate');
        var amount        = convert_numeric($("#amount","#form_add").val());
        var jangka_waktu  = parseFloat($("#jangka_waktu","#form_add").val());

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

        $("#jumlah_margin","#form_add").val(number_format(total_margin,0,',','.'));
        $("#angsuran_pokok","#form_add").val(number_format(angsuran_pokok,0,',','.'));
        $("#angsuran_margin","#form_add").val(number_format(angsuran_margin,0,',','.'));
        $("#total_angsuran","#form_add").val(number_format(total_angsuran,0,',','.'));
      }

      $("#product_code","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#amount","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#jangka_waktu","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#amount","#form_add").keyup(function(){
        hitung_margin_form_add();
      })
      $("#jangka_waktu","#form_add").keyup(function(){
        hitung_margin_form_add();
      })

      $("#nama_bank","#form_add").keyup(function(){
        if($("#nama_bank","#form_add").val()==''){
          $("#atasnama_rekening","#form_add").val('');
        }else{
          $("#atasnama_rekening","#form_add").val($("#nama","#form_add").val());
        }
      })
      $("#nama_bank","#form_add").change(function(){
        if($("#nama_bank","#form_add").val()==''){
          $("#atasnama_rekening","#form_add").val('');
        }else{
          $("#atasnama_rekening","#form_add").val($("#nama","#form_add").val());
        }
      })
      $("#nama_bank","#form_edit").keyup(function(){
        if($("#nama_bank","#form_edit").val()==''){
          $("#atasnama_rekening","#form_edit").val('');
        }else{
          $("#atasnama_rekening","#form_edit").val($("#nama","#form_edit").val());
        }
      })
      $("#nama_bank","#form_edit").change(function(){
        if($("#nama_bank","#form_edit").val()==''){
          $("#atasnama_rekening","#form_edit").val('');
        }else{
          $("#atasnama_rekening","#form_edit").val($("#nama","#form_edit").val());
        }
      })
      $("#jumlah_angsuran","#form_add").keyup(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_add").val())>0){
          $(".checker","#form_add").show();
          $("#span_txt_lunasi","#form_add").show();
          $("#lunasi_ke_kopegtel","#form_add").show();
        }else{
          $(".checker","#form_add").hide();
          $("#span_txt_lunasi","#form_add").hide();
          $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
        }
      })
      $("#jumlah_angsuran","#form_add").change(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_add").val())>0){
          $(".checker","#form_add").show();
          $("#span_txt_lunasi","#form_add").show();
          $("#lunasi_ke_kopegtel","#form_add").show();
        }else{
          $(".checker","#form_add").hide();
          $("#span_txt_lunasi","#form_add").hide();
          $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
        }
      })
      $("#jumlah_angsuran","#form_edit").keyup(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_edit").val())>0){
          $(".checker","#form_edit").show();
          $("#span_txt_lunasi","#form_edit").show();
          $("#lunasi_ke_kopegtel","#form_edit").show();
        }else{
          $(".checker","#form_edit").hide();
          $("#span_txt_lunasi","#form_edit").hide();
          $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false);
        }
      })
      $("#jumlah_angsuran","#form_edit").change(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_edit").val())>0){
          $(".checker","#form_edit").show();
          $("#span_txt_lunasi","#form_edit").show();
          $("#lunasi_ke_kopegtel","#form_edit").show();
        }else{
          $(".checker","#form_edit").hide();
          $("#span_txt_lunasi","#form_edit").hide();
          $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false);
        }
      })

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

      $("#product_code","#form_edit").change(function(){
        hitung_margin_form_edit();
      })
      $("#amount","#form_edit").change(function(){
        hitung_margin_form_edit();
      })
      $("#jangka_waktu","#form_edit").change(function(){
        hitung_margin_form_edit();
      })
      $("#amount","#form_edit").keyup(function(){
        hitung_margin_form_edit();
      })
      $("#jangka_waktu","#form_edit").keyup(function(){
        hitung_margin_form_edit();
      })

 
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

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        $("#amount","#form_add").val(0).prop(0);
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          // ignore: "",
          rules: {
              // ,pyd: {
              //     required: true,number:true
              // }
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
            var bValid = true;

            var nik = $("#nik","#form_add").val().replace(/\//g,'');

            if($("#jumlah_kewajiban","#form_add").val()==''){$("#jumlah_kewajiban","#form_add").val(0).prop(0)}
            if($("#jumlah_angsuran","#form_add").val()==''){$("#jumlah_angsuran","#form_add").val(0).prop(0)}
            var masa_pensiun      = $("#masa_pensiun","#form_add").val();
            var thp               = convert_numeric($("#thp","#form_add").val());
            var thp_40            = convert_numeric($("#thp_40","#form_add").val());
            var jumlah_kewajiban  = convert_numeric($("#jumlah_kewajiban","#form_add").val());
            var jumlah_angsuran   = convert_numeric($("#jumlah_angsuran","#form_add").val());
            var total_angsuran    = convert_numeric($("#total_angsuran","#form_add").val());
            var jangka_waktu      = $("#jangka_waktu","#form_add").val();
            var jangka_waktu_produk  = $("#product_code option:selected","#form_add").attr('max_jangka_waktu');
            r_thp                 = eval(thp);
            r_thp_40              = eval(thp_40);
            r_jumlah_kewajiban    = eval(jumlah_kewajiban);
            r_jumlah_angsuran     = eval(jumlah_angsuran);
            r_jangka_waktu        = eval(jangka_waktu);
            r_jangka_waktu_produk = eval(jangka_waktu_produk);
            total_angsuran        = eval(total_angsuran);

            if($("#flag_thp100","#form_add").val()=="1"){
              v_thp=r_thp;
            }else{
              v_thp=r_thp_40;
            }

            if($("#lunasi_ke_kopegtel","#form_add").is(':checked')==true){
              n_thp=eval(v_thp);
            }else{
              n_thp=eval(v_thp-r_jumlah_angsuran);
            }

            jum = parseFloat(n_thp)-parseFloat(total_angsuran);
            
            // alert(n_thp+'|'+total_angsuran+'|'+jum);
            // alert(r_jangka_waktu+"|"+r_jangka_waktu_produk)

              if(jum<0){
                bValid = false;
                message="Jumlah angsuran melebihi 40% THP";
              }
              if($("#status_financing_reg","#form_add").val()!='0'){
                message = 'Tidak dapat dilanjutkan \r\nPegawai masih memiliki pengajuan pembiayaan yang belum diproses';
                bValid = false;
              }
              if($("#melalui2","#form_add").is(':checked')==true && $("#kopegtel","#form_add").val()==''){
                message = "Harap pilih mitra koperasi ";
                bValid = false;
              }
              // if($("#keterangan_peruntukan","#form_add").val()==''){
              //   message = "Keterangan Peruntukan Tidak Boleh Kosong ";
              //   bValid = false;
              // }
              if($("#jangka_waktu","#form_add").val()==''){
                message = "Jangka waktu angsuran tidak boleh nol ";
                bValid = false;
              }
              if($("#amount","#form_add").val()==''){
                message = "Jumlah pengajuan tidak boleh nol ";
                bValid = false;
              }
              if($("#product_code","#form_add").val()==''){
                message = "Harap pilih produk ";
                bValid = false;
              }
              if($("#atasnama_rekening","#form_add").val()==''){
                message = "Atas nama rekening tidak boleh kosong";
                bValid = false;
              }
              if($("#bank_cabang","#form_add").val()==''){
                message = "Cabang Bank tidak boleh kosong";
                bValid = false;
              }
              if($("#no_rekening","#form_add").val()==''){
                message = "Nomor rekening tidak boleh kosong ";
                bValid = false;
              }
              if($("#nama_bank","#form_add").val()==''){
                message = "Nama Bank tidak boleh kosong ";
                bValid = false;
              }
              if($("#no_ktp","#form_add").val()==''){
                message = "No KTP tidak boleh kosong ";
                bValid = false;
              }
              if($("#no_telpon","#form_add").val()==''){
                message = "No Handphone tidak boleh kosong ";
                bValid = false;
              }
              if($("#telpon_rumah","#form_add").val()==''){
                message = "No Telpon Kantor Tidak boleh kosong ";
                bValid = false;
              }
              if($("#amount","#form_add").val()=='0'){
                message = "Jumlah pembiayaan tidak boleh nol ";
                bValid = false;
              }
              $.ajax({
                url: site_url+"rekening_nasabah/cek_masa_pensiun",
                type: "POST",
                async:false,
                dataType: "html",
                data: {jangka_waktu:jangka_waktu,masa_pensiun:masa_pensiun},
                success: function(response)
                {
                  explode = response.split("|");
                  if(explode[0]=="false"){
                    bValid = false;
                    message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_add").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
                  }
                  if(eval(explode[1])<r_jangka_waktu){
                    bValid = false;
                    message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_add").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
                  }
                  if(eval(explode[1])<0){
                    bValid = false;
                    message = "Pegawai akan pensiun dalam 3 bulan kedepan ( "+$("#show_masa_pensiun","#form_add").val()+" )";
                  }
                },
                error: function(){
                  bValid = false;
                  message = "Error. Please Contact Your Administrator";
                }
              })

              if(r_jangka_waktu>r_jangka_waktu_produk){
                bValid = false;
                message="Jangka waktu angsuran tidak boleh lebih dari "+r_jangka_waktu_produk+" bulan1";
              }

              if($("#nik","#form_add").val()==''){
                message = "Harap Pilih Pegawai ";
                bValid = false;
              }

              if(bValid==true){
                $.ajax({
                  type: "POST",
                  url: site_url+"rekening_nasabah/add_pengajuan_pembiayaan_koptel",
                  dataType: "json",
                  data: form1.serialize(),
                  success: function(response){
                    if(response.success==true){
                      alert('Success');
                      location.reload();
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
              }else{
                success1.hide();
                error1.show();
                App.scrollTo(form1, -200);
                $("#span_message","#form_add").html(message);
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


      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);


      $("input[name='melalui']","#form_edit").click(function(){
        if($("#melalui2","#form_edit").is(':checked')==true){
          $("#div_kopegtel","#form_edit").show();
        }else{
          $("#div_kopegtel","#form_edit").hide();
        }
      });

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){        
        form2.trigger('reset');
        $("#amount","#form_edit").val(0).prop(0);

        $("#wrapper-table").hide();
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
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

            if(response.pengajuan_melalui=="koptel"){
              $("#melalui1","#form_edit").attr('checked',true);
              $("#div_kopegtel","#form_edit").hide();
              $("#radio1","#form_edit").show();
              $("#radio2","#form_edit").hide();
            }else{
              $("#melalui2","#form_edit").attr('checked',true);
              $("#div_kopegtel","#form_edit").show();
              $("#kopegtel","#form_edit").val(response.kopegtel_code);              
              $("#radio1","#form_edit").hide();
              $("#radio2","#form_edit").show();

              $.ajax({
                url: site_url+"rekening_nasabah/get_kopegtel_list_by_nik",
                type: "POST",
                dataType: "json",
                async:false,
                data: {nik:response.nik},
                success: function(response2)
                {
                  var option = '';
                    for(i = 0 ; i < response2.length ; i++){
                      option += '<option value="'+response2[i].kopegtel_code+'" >'+response2[i].nama_kopegtel+'</option>';
                    }
                  $("#kopegtel","#form_edit").html(option);
                },
                error:function(){
                  alert("Something Error, Please Contact Your IT Support");
                }
              }); 
              $("#kopegtel","#form_edit").val(response.kopegtel_code);
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
            }else{
              $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false); //menghilangkan checklist
            }

            hitung_margin_form_edit()

          }
        });

        $("#edit").show();

      });
        

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          rules: {
              // amount2: {
                  // required: true
              // }
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
            var bValid = true;

            var nik = $("#nik","#form_edit").val().replace(/\//g,'');

            if($("#jumlah_kewajiban","#form_edit").val()==''){$("#jumlah_kewajiban","#form_edit").val(0).prop(0)}
            if($("#jumlah_angsuran","#form_edit").val()==''){$("#jumlah_angsuran","#form_edit").val(0).prop(0)}
            var masa_pensiun      = $("#masa_pensiun","#form_edit").val();
            var thp               = convert_numeric($("#thp","#form_edit").val());
            var thp_40            = convert_numeric($("#thp_40","#form_edit").val());
            var jumlah_kewajiban  = convert_numeric($("#jumlah_kewajiban","#form_edit").val());
            var jumlah_angsuran   = convert_numeric($("#jumlah_angsuran","#form_edit").val());
            var total_angsuran    = convert_numeric($("#total_angsuran","#form_edit").val());
            var jangka_waktu      = $("#jangka_waktu","#form_edit").val();
            var jangka_waktu_produk  = $("#product_code option:selected","#form_edit").attr('max_jangka_waktu');
            r_thp                 = eval(thp);
            r_thp_40              = eval(thp_40);
            r_jumlah_kewajiban    = eval(jumlah_kewajiban);
            r_jumlah_angsuran     = eval(jumlah_angsuran);
            r_jangka_waktu        = eval(jangka_waktu);
            r_jangka_waktu_produk = eval(jangka_waktu_produk);
            total_angsuran        = eval(total_angsuran);

            if($("#flag_thp100","#form_edit").val()=="1"){
              v_thp=r_thp;
            }else{
              v_thp=r_thp_40;
            }

            if($("#lunasi_ke_kopegtel","#form_edit").is(':checked')==true){
              n_thp=eval(v_thp);
            }else{
              n_thp=eval(v_thp-r_jumlah_angsuran);
            }

            jum = parseFloat(n_thp)-parseFloat(total_angsuran);
            
            // alert(n_thp+'|'+total_angsuran+'|'+jum);
            // alert(r_jangka_waktu+"|"+r_jangka_waktu_produk)

              if(jum<0){
                bValid = false;
                message="Jumlah angsuran melebihi 40% THP";
              }
              
              if($("#melalui2","#form_edit").is(':checked')==true && $("#kopegtel","#form_edit").val()==''){
                message = "Harap pilih mitra koperasi ";
                bValid = false;
              }
              // if($("#keterangan_peruntukan","#form_edit").val()==''){
              //   message = "Keterangan Peruntukan Tidak Boleh Kosong ";
              //   bValid = false;
              // }
              if($("#jangka_waktu","#form_edit").val()==''){
                message = "Jangka waktu angsuran tidak boleh nol ";
                bValid = false;
              }
              if($("#amount","#form_edit").val()==''){
                message = "Jumlah pengajuan tidak boleh nol ";
                bValid = false;
              }
              if($("#product_code","#form_edit").val()==''){
                message = "Harap pilih produk ";
                bValid = false;
              }
              if($("#atasnama_rekening","#form_edit").val()==''){
                message = "Atas nama rekening tidak boleh kosong";
                bValid = false;
              }
              if($("#bank_cabang","#form_edit").val()==''){
                message = "Cabang Bank tidak boleh kosong";
                bValid = false;
              }
              if($("#no_rekening","#form_edit").val()==''){
                message = "Nomor rekening tidak boleh kosong ";
                bValid = false;
              }
              if($("#nama_bank","#form_edit").val()==''){
                message = "Nama Bank tidak boleh kosong ";
                bValid = false;
              }
              if($("#no_ktp","#form_edit").val()==''){
                message = "No KTP tidak boleh kosong ";
                bValid = false;
              }
              if($("#no_telpon","#form_edit").val()==''){
                message = "No Handphone tidak boleh kosong ";
                bValid = false;
              }
              if($("#telpon_rumah","#form_edit").val()==''){
                message = "No Telpon Kantor Tidak boleh kosong ";
                bValid = false;
              }
              if($("#amount","#form_edit").val()=='0'){
                message = "Jumlah pembiayaan tidak boleh nol ";
                bValid = false;
              }
              $.ajax({
                url: site_url+"rekening_nasabah/cek_masa_pensiun",
                type: "POST",
                async:false,
                dataType: "html",
                data: {jangka_waktu:jangka_waktu,masa_pensiun:masa_pensiun},
                success: function(response)
                {
                  explode = response.split("|");
                  if(explode[0]=="false"){
                    bValid = false;
                    message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
                  }
                  if(eval(explode[1])<r_jangka_waktu){
                    bValid = false;
                    message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
                  }
                  if(eval(explode[1])<0){
                    bValid = false;
                    message = "Pegawai akan pensiun dalam 3 bulan kedepan ( "+$("#show_masa_pensiun","#form_edit").val()+" )";
                  }
                },
                error: function(){
                  bValid = false;
                  message = "Error. Please Contact Your Administrator";
                }
              })

              if(r_jangka_waktu>r_jangka_waktu_produk){
                bValid = false;
                message="Jangka waktu angsuran tidak boleh lebih dari "+r_jangka_waktu_produk+" bulan1";
              }


              if(bValid==true){
                // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
                $.ajax({
                  type: "POST",
                  url: site_url+"rekening_nasabah/edit_pengajuan_pembiayaan_koptel",
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
                      form2.show();
                      App.scrollTo(error2, -200);
                  }
                });
              }else{
                success2.hide();
                error2.show();
                App.scrollTo(form2, -200);
                $("#span_message","#form_edit").html(message);
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
                  alert("Pengajuan Berhasil di Hapus!");
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



      // begin first table
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pengajuan_pembiayaan_koptel",
          "aoColumns": [			      
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": true },
            // { "bSortable": true },
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
                  'aTargets': [0,1]
              }
          ]
      });


      // fungsi untuk mencari CIF_NO
      $(function(){

      $("input[name='melalui']","#form_add").click(function(){
        if($("#melalui2","#form_add").is(':checked')==true){
          $("#div_kopegtel","#form_add").show();
        }else{
          $("#div_kopegtel","#form_add").hide();
        }
      });

       $("#browse_rembug").click(function(){
          $("#form_add").trigger('reset');
          $("#amount","#form_add").val(0).prop(0);
          $("#jumlah_angsuran","#form_add").val(0).prop(0);
          $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
          $("#span_txt_lunasi","#form_add").hide();
          $(".checker","#form_add").hide();
          $("#span_txt_lunasi","#form_add").hide();
       });
       $("#select").click(function(){
         
         result = $("#result").val();
          var customer_no = $("#result").val();
          $("#close","#dialog_rembug").trigger('click');
          //alert(customer_no);
          $("#nik").val(customer_no);
          //fungsi untuk mendapatkan value untuk field-field yang diperlukan
          var nik = customer_no;
          $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            data: {nik:nik},
            url: site_url+"transaction/get_ajax_value_from_nik",
            success: function(response)
            {

              $("#gender","#form_add").val(response.gender);
              $("#nik","#form_add").val(response.nik);
              $("#nama","#form_add").val(response.nama_pegawai);
              $("#band","#form_add").val(response.band);
              $("#jabatan","#form_add").val(response.posisi);
              $("#lokasi_kerja","#form_add").val(response.posisi);
              $("#alamat","#form_add").val(response.alamat);
              $("#no_telpon","#form_add").val(response.telpon_seluler);
              $("#telpon_rumah","#form_add").val(response.telpon_rumah);
              $("#tmp_lahir","#form_add").val(response.tempat_lahir);
              $("#tgl_lahir","#form_add").val(response.tgl_lahir);

              $("#thp","#form_add").val(number_format(response.thp,0,',','.'));
              $("#thp_40","#form_add").val(number_format(response.thp_40,0,',','.'));
              $("#jumlah_kewajiban","#form_add").val(number_format(response.jumlah_kewajiban,0,',','.'));
              $("#jumlah_angsuran","#form_add").val(0);

              $("#masa_pensiun","#form_add").val(response.tgl_pensiun_normal);

              explode2 = response.tgl_pensiun_normal.split('-');
              var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
              $("#show_masa_pensiun","#form_add").val(show_pensiun);

              $("#no_ktp","#form_add").val(response.no_ktp);
              $("#no_telpon","#form_add").val(response.telpon_seluler);
              $("#nama_pasangan","#form_add").val(response.nama_pasangan);
              $("#pekerjaan_pasangan","#form_add").val(response.pekerjaan_pasangan);
              $("#jumlah_tanggungan","#form_add").val(response.jumlah_tanggungan);
              $("#status_rumah","#form_add").val(response.status_rumah);
              $("#nama_bank","#form_add").val(response.nama_bank);
              $("#bank_cabang","#form_add").val(response.bank_cabang);
              $("#no_rekening","#form_add").val(response.no_rekening);
              $("#atasnama_rekening","#form_add").val(response.atasnama_rekening);
              
              $.ajax({
                url: site_url+"rekening_nasabah/cek_regis_pembiayaan_koptel",
                type: "POST",
                dataType: "html",
                async:false,
                data: {nik:response.nik},
                success: function(response)
                {
                  if (response=="0") {
                    $("#status_financing_reg","#form_add").val('0');
                  } else{
                    $("#status_financing_reg","#form_add").val(response);
                  };
                }
              })

              $.ajax({
                url: site_url+"rekening_nasabah/cek_nik_from_mfi_cif",
                type: "POST",
                dataType: "html",
                async:false,
                data: {nik:response.nik},
                success: function(response)
                {
                  if (response=="0") {
                    $("#cif_id","#form_add").val('0');
                  } else{
                    $("#cif_id","#form_add").val(response);
                  };
                }
              })

              response_nik = response.nik;

              $.ajax({
                url: site_url+"rekening_nasabah/cek_flag_thp100",
                type: "POST",
                dataType: "html",
                async:false,
                data: {nik:response_nik},
                success: function(response)
                {
                  var explode = response.split("|");
                  if (explode[0]=="0") {
                    $("#flag_thp100","#form_add").val('0');
                  }else{
                    $("#flag_thp100","#form_add").val('1');
                  };
                  if (explode[1]=="0") {
                    $("#melalui","#form_add").attr('checked',true);
                    $("#div_kopegtel","#form_add").hide();                    
                    $("#radio1","#form_add").show();                    
                    $("#radio2","#form_add").hide();                    
                  }else{
                    $("#melalui2","#form_add").attr('checked',true); //melalui mitra koperasi
                    $("#div_kopegtel","#form_add").show();                    
                    $("#radio1","#form_add").hide();                    
                    $("#radio2","#form_add").show();

                    $.ajax({
                      url: site_url+"rekening_nasabah/get_kopegtel_list_by_nik",
                      type: "POST",
                      dataType: "json",
                      async:false,
                      data: {nik:response_nik},
                      success: function(response)
                      {
                        var option = '';
                          for(i = 0 ; i < response.length ; i++){
                            option += '<option value="'+response[i].kopegtel_code+'" >'+response[i].nama_kopegtel+'</option>';
                          }
                        $("#kopegtel","#form_add").html(option);
                      },
                      error:function(){
                        alert("Something Error, Please Contact Your IT Support");
                      }
                    });                          

                  }

                },
                error:function(){
                  alert("Something Error, Please Contact Your IT Support");
                }
              })

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
              url: site_url+"cif/search_cif_no_koptel",
              data: {keyword:$("#keyword").val()},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
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
              url: site_url+"cif/search_cif_no_koptel",
              data: {keyword:$(this).val()},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
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
              url: site_url+"cif/search_cif_no_koptel",
              data: {keyword:$("#keyword").val()},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].nik+'" nama="'+response[i].nama_pegawai+'">'+response[i].nik+' - '+response[i].nama_pegawai+'</option>';
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


      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

