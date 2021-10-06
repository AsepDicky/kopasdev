<style type="text/css">
   .readonly{background-color:#eee}
   #uniform-check_saldo{
    display: block !important;
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
<div class="portlet box red" id="wrapper-table">
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
         <div style="float:right;">
           <select id="src_product" name="src_product" class="m-wrap">
             <option value="" maxrate="">Sorting Berdasarkan Produk</option>
              <?php foreach($product as $produk){ ?>
             <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
             <?php } ?>
           </select>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th>
               <th width="13%">No. Pengajuan</th>
               <th width="10%">NIK</th>
               <th width="25%">Nama Lengkap</th>
               <th width="25%">Produk</th>
               <th width="15%">Tgl Pengajuan</th>
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
   
   <div class="portlet box red">
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
                          <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap"  maxlength="15" />

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
                    <div class="control-group hide">
                       <label class="control-label">Alamat Lokasi Kerja</label>
                       <div class="controls">
                          <textarea name="alamat_lokasi_kerja" id="alamat_lokasi_kerja" class="large m-wrap"/>
                          </textarea>
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
                       <label class="control-label">Tlp Kantor</label>
                       <div class="controls">
                          <input type="text" name="telpon_rumah" id="telpon_rumah" class="medium m-wrap" maxlength="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan</label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" maxlength="30" placeholder="Suami/Istri" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                 
                    <div class="control-group hide">
                       <label class="control-label">Pekerjaan Pasangan</label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" maxlength="30" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                
                    <!-- <div class="control-group">
                       <label class="control-label">Jumlah Tanggungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="m-wrap" maxlength="2" value="0" style="width:50px;"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Status Rumah<span class="required">*</span></label>
                       <div class="controls">
                           <select id="status_rumah" name="status_rumah" class="m-wrap">
                             <option value="1">Milik Sendiri</option>
                             <option value="2">Sewa/Kontrak</option>
                             <option value="3">Milik Orang Tua</option>
                           </select>
                        </div>
                    </div>          -->   
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
                             <input type="text" class="large m-wrap" name="atasnama_rekening" id="atasnama_rekening" maxlength="50">
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
                            <input type="text" name="thp" id="thp" class="medium m-wrap mask-money" style="width:120px !important;" />
                            <span class="add-on">,00</span>
                          </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">40% THP<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                          <!-- <input type="text" name="thp_40" id="thp_40" class="medium m-wrap mask-money"/> -->
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
                       <div class="controls" id="checker_jumlah_kewajiban_add">
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
                            <input type="text" class="m-wrap mask-money" readonly="" style="width:120px;background-color:#eee;" name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel" value="0">
                            <span class="add-on">,00</span>
                          </div>
                        </div>
                        <div class="controls" style="margin-top:20px;margin-bottom:20px;">
                          <table width="35%" id="list_saldo_pokok">
                            <thead>
                              <tr>
                                <td style="height:30px;width:8%;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">&nbsp;
                                  
                                </td>
                                <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                  Saldo Pokok
                                </td>
                                <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                  Saldo Margin
                                </td>
                                <td style="height:30px;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">
                                  Produk
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
                       <div class="controls" id="checker_jumlah_angsuran_add">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1"/><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <div id="div_saldo_kewajiban">
                      <div class="control-group">
                          <label class="control-label">Saldo Kewajiban Ke Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" name="saldo_kewajiban" id="saldo_kewajiban" maxlength="15" value="0">
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
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" value="<?php echo date('d/m/Y');?>" class="date-picker small m-wrap"/>
                       </div>
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
                       <label class="control-label">Sumber Dana</label>
                       <div class="controls">
                           <select id="sumber_dana" name="sumber_dana" class="m-wrap">
                              <option value="">PILIH</option>
                             <?php foreach($sumber_dana as $key){ ?>
                             <option value="<?php echo $key['id'] ?>" ><?php echo $key['name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Akad<span class="required">*</span></label>
                       <div class="controls">
                           <select id="akad_code" name="akad_code" class="m-wrap">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($akad as $akad){ ?>
                             <option value="<?php echo $akad['akad_code'] ?>" akadcode="<?php echo $akad['akad_code'] ?>" akadname="<?php echo $akad['akad_name'] ?>"><?php echo $akad['akad_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <select id="product_code" name="product_code" class="m-wrap">
                             <option value="" maxrate="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" max_jangka_waktu="<?php echo $produk['max_jangka_waktu'] ?>" jenis_margin="<?php echo $produk['jenis_margin'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="control-group group-smile" style="display: none">
                        <label class="control-label">SMILE product list<span class="required">*</span></label>
                        <div class="controls">
                          <select class="m-wrap chosen" name="product_code_smile" id="product_code_smile">
                            <option value="" maxrate="">PILIH</option>
                            <option value="52" maxrate="10.0000000000" max_jangka_waktu="120" jenis_margin="1">FLAT</option>
                            <?php foreach($product_smile as $key){ ?>
                            <option value="<?php echo $key['product_code'] ?>" maxrate="<?php echo $key['rate_margin2'] ?>" max_jangka_waktu="<?php echo $key['max_jangka_waktu'] ?>" jenis_margin="<?php echo $key['jenis_margin'] ?>"><?php echo $key['product_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                            <option value="">PILIH</option>
                            <!-- <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['display_sort'];?>" akad="<?php echo $data['code_value'];?>" akad_value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>   -->
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
                            <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                            <input type="hidden" id="calculate_max_jangka_waktu" name="calculate_max_jangka_waktu">
                        </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label"><span id="label-total-margin">Total Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/>
                          </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Asuransi</label>
                       <div class="controls">
                           <select id="show_asuransi" name="show_asuransi" class="m-wrap">
                              <option value="" maxrate="">PILIH</option>
                              <option value="1">ASKRINDO</option>
                              <option value="2">BUMI PUTERA</option>
                           </select>
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
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money"/>
                            <!-- <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/> -->
                          </div>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_margin">
                       <label class="control-label"><span id="label-pendapatan-margin">Porsi Margin</span></label>
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
                       <label class="control-label">Premi Asuransi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="premi_asuransi" id="premi_asuransi" class="small m-wrap mask-money"/>
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
               <input type="hidden" name="jenis_margin" id="jenis_margin">
               <button type="button" id="act_submit" class="btn green">Save</button>
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
   
   <div class="portlet box red">
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
          <input type="hidden" id="registration_no" name="registration_no">
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
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tempat_lahir" type="text" class="medium m-wrap" />
                        &nbsp;
                        Tanggal Lahir 
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>
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
                    <div class="control-group hide">
                       <label class="control-label">Alamat Lokasi Kerja</label>
                       <div class="controls">
                          <textarea name="alamat_lokasi_kerja" id="alamat_lokasi_kerja" class="large m-wrap"/>
                          </textarea>
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
                       <label class="control-label">Tlp Kantor</label>
                       <div class="controls">
                          <input type="text" name="telpon_rumah" id="telpon_rumah" class="medium m-wrap" maxlength="15" value="0" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Pasangan</label>
                       <div class="controls">
                          <input type="text" name="nama_pasangan" id="nama_pasangan" class="medium m-wrap" maxlength="30" placeholder="Suami/Istri" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                 
                    <div class="control-group hide">
                       <label class="control-label">Pekerjaan Pasangan</label>
                       <div class="controls">
                          <input type="text" name="pekerjaan_pasangan" id="pekerjaan_pasangan" class="medium m-wrap" maxlength="30" onkeyup="this.value=this.value.toUpperCase()"/>
                       </div>
                    </div>                
                    <!-- <div class="control-group">
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
                    </div>         -->    
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
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" maxlength="50">
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
                            <input type="text" name="thp" id="thp" class="medium m-wrap mask-money" style="width:120px !important;" />
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
                        <div class="controls" style="margin-top:20px;margin-bottom:20px;">
                          <table width="35%" id="list_saldo_pokok">
                            <thead>
                              <tr>
                                <td style="height:30px;width:8%;text-align:center;background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">&nbsp;
                                  
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
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="jumlah_angsuran" id="jumlah_angsuran" maxlength="15" value="0">
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
                              <input type="text" class="m-wrap mask-money" style="width:120px;" name="saldo_kewajiban" id="saldo_kewajiban" maxlength="15" value="0">
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
                    <!-- <div class="control-group">
                       <label class="control-label">Lunasi Ke Kopegtel</label>
                       <div class="controls" style="padding-top:0px">
                         <label class="radio">
                           <input type="radio" name="lunasi_kopegtel" id="lunasi_kopegtel1" value="1" style="margin-top:3px" />
                           &nbsp;Ya
                         </label> &nbsp;&nbsp;&nbsp;
                             <span class="add-on">,00</span>
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
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
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
                             <option value="<?php echo $produk['product_code'] ?>" maxrate="<?php echo $produk['rate_margin2'] ?>" max_jangka_waktu="<?php echo $produk['max_jangka_waktu'] ?>" jenis_margin="<?php echo $produk['jenis_margin'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>                        
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
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
                         <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                         <input type="hidden" id="calculate_max_jangka_waktu" name="calculate_max_jangka_waktu">
                        </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label"><span id="label-total-margin">Total Margin</span></label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_margin" id="jumlah_margin" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/>
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
                            <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" />
                            <!-- <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="small m-wrap mask-money" readonly="" style="background-color:#eee;"/> -->
                          </div>
                       </div>
                    </div> 
                    <div class="control-group" id="div_angsuran_margin">
                       <label class="control-label"><span id="label-pendapatan-margin">Porsi Margin</span></label>
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
                       <label class="control-label">Premi Asuransi</label>
                       <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="premi_asuransi" id="premi_asuransi" class="small m-wrap mask-money"/>
                          </div>
                       </div>
                    </div>        
            <div class="form-actions">
               <input type="hidden" name="gender" id="gender">
               <input type="hidden" name="masa_pensiun" id="masa_pensiun">
               <input type="hidden" name="show_masa_pensiun" id="show_masa_pensiun">
               <input type="hidden" name="flag_thp100" id="flag_thp100">
               <input type="hidden" name="jenis_margin" id="jenis_margin">
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
<script src="<?php echo base_url(); ?>assets/plugins/ba-throttle-debounce.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });

      $("#amount","#form_add").val(0).prop(0);
      $("#amount","#form_edit").val(0).prop(0);
      $("#jumlah_angsuran","#form_add").val(0).prop(0);
      $("#saldo_kewajiban","#form_add").val(0).prop(0);
      $("#jumlah_angsuran","#form_edit").val(0).prop(0);
      $("#saldo_kewajiban","#form_edit").val(0).prop(0);

      $("#product_code").prop('disabled', true);
      $("#peruntukan").prop('disabled', true);

      $('#akad_code').on('change', function() {
        if(this.value){
          $("#product_code").prop('disabled', false);
          $("#peruntukan").prop('disabled', false);
        }else{
          $("#product_code").prop('disabled', true);
          $("#peruntukan").prop('disabled', true);
        }
      });

      $('#product_code').on('change', function() {
        if(this.value=='52'){
          $('.group-smile').show();
          $('#product_code_smile').val(null).trigger('change');
        }else{
          $('.group-smile').hide();
          $('#product_code_smile').val(null).trigger('change');
        }
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

// $(function(){
    
// })
v_usia = 0;

function get_usia_asuransi(form,tgl_lahir,tgl_pengajuan)
{
  // alert(tgl_pengajuan)
  $.ajax({
    type:"POST",dataType:"json",data:{
      tgl_lahir:tgl_lahir
      ,tgl_pengajuan:tgl_pengajuan
    }, url:site_url+'rekening_nasabah/get_usia_asuransi',
    async:false,
    success:function(response) {
      v_usia = response.usia;
    }
  })
}


function calc_premi_asuransi(form,jangkawaktu,usia,manfaat,show_asuransi)
{
  $.ajax({
    type:"POST",dataType:"json",data:{
      jangkawaktu:jangkawaktu,usia:usia,manfaat:manfaat,show_asuransi:show_asuransi
    }, url:site_url+'rekening_nasabah/get_premi_asuransi_ajax',
    success:function(response) {
      $('#premi_asuransi',form).val(response.premi);
    }
  })
}

$(function(){
  form_add = $('#form_add');
  $('#show_asuransi,#jangka_waktu,#amount',form_add).change(function(){
    show_asuransi = $('#show_asuransi',form_add).val();
    jangka_waktu = $('#jangka_waktu',form_add).val();
    amount = $('#amount',form_add).val();
    if (jangka_waktu!="" && amount!="" && show_asuransi !="") {
      tgl_lahir = $('#tgl_lahir',form_add).val();
      tgl_pengajuan = $("input[name='tanggal_pengajuan']","#form_add").val();
      get_usia_asuransi(form_add,tgl_lahir,tgl_pengajuan);
      usia = v_usia;
      calc_premi_asuransi(form_add,jangka_waktu,usia,amount,show_asuransi);
    }
  })

  /*form_edit = $('#form_edit');
  $('#jangka_waktu,#amount',form_edit).change(function(){
    jangka_waktu = $('#jangka_waktu',form_edit).val();
    amount = $('#amount',form_edit).val();
    if (jangka_waktu!="" && amount!="") {
      tgl_lahir = $('#tgl_lahir',form_edit).val();
      tgl_pengajuan = $("input[name='tanggal_pengajuan']","#form_edit").val();
      get_usia_asuransi(form_edit,tgl_lahir,tgl_pengajuan);
      usia = v_usia;
      calc_premi_asuransi(form_edit,jangka_waktu,usia,amount,show_asuransi);
    }
  })*/
})

    function get_data_cif_by_nik(customer_no){

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
                  $("#product_code","#form_add").html(option);
                }
              })

              $("#gender","#form_add").val(response.gender);
              $("#nik","#form_add").val(response.nik);
              $("#nama","#form_add").val(response.nama_pegawai);
              $("#band","#form_add").val(response.band);
              $("#jabatan","#form_add").val(response.posisi);
              $("#lokasi_kerja","#form_add").val(response.loker);
              $("#alamat_lokasi_kerja","#form_add").val(response.alamat_lokasi_kerja);
              $("#alamat","#form_add").val(response.alamat);
              $("#no_telpon","#form_add").val(response.telpon_seluler);
              $("#telpon_rumah","#form_add").val(response.telpon_rumah);
              $("#tempat_lahir","#form_add").val(response.tempat_lahir);
              $("#tgl_lahir","#form_add").val(response.tgl_lahir);

              $("#thp","#form_add").val(number_format(response.thp,0,',','.'));
              $("#thp_40","#form_add").val(number_format(response.thp_40,0,',','.'));
              $("#jumlah_kewajiban","#form_add").val(number_format(response.jumlah_kewajiban,0,',','.'));
              $("#saldo_kewajiban_ke_koptel","#form_add").val(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#jumlah_angsuran","#form_add").val(0);


              $.ajax({
                 type: "POST",
                 url: site_url+"transaction/get_list_saldo",
                 dataType: "json",
                 data: {nik:nik},
                 success: function(response3){
                    html = '';
                    // alert(response3.length)
                    for(k = 0 ; k < response3.length ; k++){
                      html += ' \
                            <tr>\
                              <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                  <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="0">\
                                  <input type="hidden" name="account_financing_no[]" id="account_financing_no" value="'+response3[k].account_financing_no+'">\
                                  <input type="hidden" name="no_pembiayaan" id="no_pembiayaan" value="'+response3[k].account_financing_no+'">\
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">\
                              </td>\
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="check_saldo_pokok[]" value="'+number_format(response3[k].saldo_pokok,0,',','.')+'">'+number_format(response3[k].saldo_pokok,0,',','.')+'\
                              </td>\
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="check_saldo_margin[]" value="'+number_format(response3[k].saldo_margin,0,',','.')+'">'+number_format(response3[k].saldo_margin,0,',','.')+'\
                              </td>\
                              <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="check_product_name[]" value="'+response3[k].product_name+'">'+response3[k].product_name+'\
                              </td>\
                            </tr>\
                      ';
                    }
                    $("#list_saldo_pokok tbody","#form_add").html(html);
                 }
              });

              // $("#jumlah_kewajiban","#form_add").trigger('keyup');

              // if(response.thp>"0"){
              //   $("#thp","#form_add").attr('readonly', true);
              //   $("#thp","#form_add").prop('readonly', true);
              //   $("#thp","#form_add").addClass('readonly');
              // }else{
              //   $("#thp","#form_add").attr('readonly', false);
              //   $("#thp","#form_add").prop('readonly', false);
              //   $("#thp","#form_add").removeClass('readonly');                
              // }

              if(response.tgl_pensiun_normal) {
                $("#masa_pensiun","#form_add").val(response.tgl_pensiun_normal);

                explode2 = response.tgl_pensiun_normal.split('-');
                var show_pensiun =  explode2[2]+'-'+explode2[1]+'-'+explode2[0];
                $("#show_masa_pensiun","#form_add").val(show_pensiun);
              }
              
              $("#no_ktp","#form_add").val(response.no_ktp);
              $("#no_telpon","#form_add").val(response.telpon_seluler);
              $("#nama_pasangan","#form_add").val(response.nama_pasangan);
              $("#pekerjaan_pasangan","#form_add").val(response.pekerjaan_pasangan);
              // $("#jumlah_tanggungan","#form_add").val(response.jumlah_tanggungan);
              // $("#status_rumah","#form_add").val(response.status_rumah);
              $("#nama_bank","#form_add").val(response.nama_bank);
              $("#bank_cabang","#form_add").val(response.bank_cabang);
              $("#no_rekening","#form_add").val(response.no_rekening);
              $("#atasnama_rekening","#form_add").val(response.atasnama_rekening);
              $("#kopegtel","#form_add").val(response.kopegtel_code);                    
              
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
                    // $("#div_kopegtel","#form_add").hide();                    
                    // $("#radio1","#form_add").show();                    
                    // $("#radio2","#form_add").hide();                    
                  }else{
                    $("#melalui2","#form_add").attr('checked',true); //melalui mitra koperasi
                    $("#div_kopegtel","#form_add").show();                    
                    // $("#radio1","#form_add").hide();                    
                    // $("#radio2","#form_add").show();

                    // $.ajax({
                    //   url: site_url+"rekening_nasabah/get_kopegtel_list_by_nik",
                    //   type: "POST",
                    //   dataType: "json",
                    //   async:false,
                    //   data: {nik:response_nik},
                    //   success: function(response)
                    //   {
                    //     var option = '';
                    //       for(i = 0 ; i < response.length ; i++){
                    //         option += '<option value="'+response[i].kopegtel_code+'" >'+response[i].nama_kopegtel+'</option>';
                    //       }
                    //     $("#kopegtel","#form_add").html(option);
                    //   },
                    //   error:function(){
                    //     alert("Something Error, Please Contact Your IT Support");
                    //   }
                    // });                          

                  }

                },
                error:function(){
                  alert("Something Error, Please Contact Your IT Support");
                }
              })

            }                 
          }); 
    }

    function monthDiff(d1, d2) {
        /*event untuk menentukan jangka waktu angsuran*/
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth() + 1;
        months += d2.getMonth();
        return months <= 0 ? 0 : months;
    }

    function cek_max_jangka_waktu_add(produk_code){
        /*
        | Untuk mengecek jangka waktu maksimal yang ada di tabel product_financing
        */

        var thn=12;
        if(produk_code=='61'){
          $("#jangka_waktu","#form_add").val(thn*1).prop(0);
        }else if(produk_code=='62'){
          $("#jangka_waktu","#form_add").val(thn*2).prop(0);
        }else if(produk_code=='63'){
          $("#jangka_waktu","#form_add").val(thn*3).prop(0);
        }else if(produk_code=='64'){
          $("#jangka_waktu","#form_add").val(thn*4).prop(0);
        }else if(produk_code=='65'){
          $("#jangka_waktu","#form_add").val(thn*5).prop(0);
        }else if(produk_code=='66'){
          $("#jangka_waktu","#form_add").val(thn*6).prop(0);
        }else if(produk_code=='67'){
          $("#jangka_waktu","#form_add").val(thn*7).prop(0);
        }else if(produk_code=='68'){
          $("#jangka_waktu","#form_add").val(thn*8).prop(0);
        }else if(produk_code=='69'){
          $("#jangka_waktu","#form_add").val(thn*9).prop(0);
        }else if(produk_code=='70'){
          $("#jangka_waktu","#form_add").val(thn*10).prop(0);
        }else{
          $("#jangka_waktu","#form_add").val("").prop(0);
        }
        
        var pensiun = $("#masa_pensiun","#form_add").val();
        var thn_pensiun = pensiun.substring(0,4);
        var bln_pensiun = pensiun.substring(7,5);
        var tgl_pensiun = pensiun.substring(10,8);
        var monthInterval = monthDiff(new Date(),new Date(thn_pensiun, bln_pensiun, tgl_pensiun));
        var max_jangka_waktu  = $("#product_code option:selected","#form_add").attr('max_jangka_waktu');
        if(monthInterval>60){
            $("#notif_jk_waktu","#form_add").html("Jangka waktu maksimal "+(max_jangka_waktu)+" bulan");
            $("#calculate_max_jangka_waktu","#form_add").val(max_jangka_waktu);
        }else{
            $("#notif_jk_waktu","#form_add").html("Jangka waktu maksimal "+(monthInterval-1)+" bulan");
            $("#calculate_max_jangka_waktu","#form_add").val((monthInterval-1));
        }
        /*
        | end
        */
    }

    function status_dokumen_lengkap_func_add(product_code) {
      $.ajax({
        type:"POST",dataType:"json",data:{product_code:product_code},
        url:site_url+'rekening_nasabah/get_status_dokumen_lengkap',
        success: function(response) {
          status_dokumen_lengkap = response.status_dokumen_lengkap;
          if (status_dokumen_lengkap==0) {
            $('#angsuran_pokok','#form_add').closest('.control-group').hide();
            $('#angsuran_margin','#form_add').closest('.control-group').hide();
            $('#total_angsuran','#form_add').closest('.control-group').hide();
          } else {
            $('#angsuran_pokok','#form_add').closest('.control-group').show();
            $('#angsuran_margin','#form_add').closest('.control-group').show();
            $('#total_angsuran','#form_add').closest('.control-group').show();
          }
        },error:function(){
          App.WarningAlert('Internal Server Error! Please Contact Your Administrator.');
        }
      })
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

    /* BEGIN EFEKTIF */
    function get_total_pokok_efektif_form1(){
      var margin  = $('#product_code option:selected', "#form_add").attr('maxrate');
      var margin2  = $('#product_code_smile option:selected', "#form_add").attr('maxrate');
      var jangka_waktu  = $('#jangka_waktu', "#form_add").val();
      var amount  = $('#amount', "#form_add").val();

        if(margin2){
          margin = margin2;
        }

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
            $("#jumlah_margin","#form_add").val(number_format(response,0,',','.'));
            $("#angsuran_pokok","#form_add").val('0');
            $("#angsuran_margin","#form_add").val('0');
            $("#total_angsuran","#form_add").val('0');
            $("#angsuran_pokok","#form_add").prop('0');
            $("#angsuran_margin","#form_add").prop('0');
            $("#total_angsuran","#form_add").prop('0');
            $("#div_angsuran_pokok","#form_add").hide();
            $("#div_angsuran_margin","#form_add").hide();
            $("#div_total_angsuran","#form_add").hide();
          },
          error: function(){
            alert("terjadi kesalahan, harap hubungi IT Support");
          }
        })
      
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
    /* END EFEKTIF */

    /* BEGIN ANUITAS */
    function get_total_margin_dan_angsuran_anuitas_form1(){
      var margin  = $('#product_code option:selected', "#form_add").attr('maxrate');
      var margin2  = $('#product_code_smile option:selected', "#form_add").attr('maxrate');
      var jangka_waktu  = $('#jangka_waktu', "#form_add").val();
      var amount  = $('#amount', "#form_add").val();
      var product_code  = $("#product_code","#form_add").val();

        if(margin2){
          margin = margin2;
        }

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
            $("#jumlah_margin","#form_add").val(number_format(response.total_margin,0,',','.'));
            $("#total_angsuran","#form_add").val(number_format(response.total_angsuran,0,',','.'));
            $("#angsuran_pokok","#form_add").val('0');
            $("#angsuran_pokok","#form_add").prop('0');
            $("#angsuran_margin","#form_add").val('0');
            $("#angsuran_margin","#form_add").prop('0');
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
    /* END ANUITAS */

    //***** PRODUCT ADD FORM *****// 
    $("#product_code","#form_add").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      product_exchange_form_add($(this).val(), jenis_margin);
    })

    $("#product_code_smile","#form_add").change(function(){
      var jenis_margin  = $('option:selected', this).attr('jenis_margin');
      if(jenis_margin){
        product_exchange_form_add($(this).val(), jenis_margin);
      }
    })
    //***** END *****//

    $("#product_code","#form_edit").change(function(){
      cek_max_jangka_waktu_edit($(this).val());
      // status_dokumen_lengkap_func_edit($(this).val());
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

    $("#angsuran_pokok","#form_add").keyup(function(){
      hitung_margin_by_angsuran_pokok_form_add();
    })

    function product_exchange_form_add(value, jenis_margin) {
      cek_max_jangka_waktu_add(value);
      if(jenis_margin=='2'){
        $("#div_angsuran_pokok","#form_add").hide();
        $("#div_angsuran_margin","#form_add").hide();
        $("#div_total_angsuran","#form_add").hide();
      } else if(jenis_margin=='3') {
        $("#div_angsuran_pokok","#form_add").hide();
        $("#div_angsuran_margin","#form_add").hide();
        $("#div_total_angsuran","#form_add").show();
      } else {
        $("#div_angsuran_pokok","#form_add").show();
        $("#div_angsuran_margin","#form_add").show();
        $("#div_total_angsuran","#form_add").show();
      }
        $("#jenis_margin","#form_add").val(jenis_margin);
    }

    function hitung_margin_by_angsuran_pokok_form_add()
    {
      var angsuran_pokok    = convert_numeric($("#angsuran_pokok","#form_add").val());
      var angsuran_margin   = convert_numeric($("#angsuran_margin","#form_add").val());

      total_angsuran = (eval(angsuran_pokok)+eval(angsuran_margin))

      $("#total_angsuran","#form_add").val(number_format(total_angsuran,0,',','.'));
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

      function hitung_margin_form_add()
      {
        var jenis_margin = $("#product_code","#form_add").find('option:selected').attr('jenis_margin');
        var jenis_margin2 = $("#product_code_smile","#form_add").find('option:selected').attr('jenis_margin');
        var jangkawaktu = $("#jangka_waktu",'#add').val();
        var pokok = $('#amount','#add').val();
          
        if(jenis_margin2){
          jenis_margin = jenis_margin2;
        }

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
            get_total_margin_dan_angsuran_anuitas_form1();
          }
        } else{ //flat          
          var rate          = $("#product_code","#form_add").find('option:selected').attr('maxrate');
          var rate2         = $("#product_code_smile","#form_add").find('option:selected').attr('maxrate');
          var amount        = convert_numeric($("#amount","#form_add").val());
          var jangka_waktu  = parseFloat($("#jangka_waktu","#form_add").val());
          var v_total_angsuran = 0;
          var v_angsuran_pokok = 0;

          if(rate2){
            rate = rate2;
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

          $("#jumlah_margin","#form_add").val(number_format(total_margin,0,',','.'));
          $("#angsuran_pokok","#form_add").val(number_format(v_angsuran_pokok,0,',','.'));
          $("#angsuran_margin","#form_add").val(number_format(angsuran_margin,0,',','.'));
          $("#total_angsuran","#form_add").val(number_format(v_total_angsuran,0,',','.'));
        }
      }

      /*$("#peruntukan","#form_add").change(function(){
        akad = $("#peruntukan","#form_add").find('option:selected').attr('akad_value');
        labeltotalmarginujroh(akad,$('#label-total-margin','#form_add'));
        labelpendapatanmarginujroh(akad,$('#label-pendapatan-margin','#form_add'));
        if($(this).val()==''){
            $("#span_akad","#form_add").html('');
        }else{
          if(akad=='MBA'){
            $("#span_akad","#form_add").html('MUROBAHAH');
          }else if(akad=='IJR'){
            $("#span_akad","#form_add").html('IJAROH');
          }else{
            $("#span_akad","#form_add").html('');
          }

        }
      })*/

      $("#akad_code","#form_add").change(function(){
        akad = $("#akad_code","#form_add").find('option:selected').attr('akadcode');
        labeltotalmarginujroh(akad,$('#label-total-margin','#form_add'));
        labelpendapatanmarginujroh(akad,$('#label-pendapatan-margin','#form_add'));
        
        $("#peruntukan","#form_add").val('');

        $.ajax({
          url: site_url+"rekening_nasabah/get_peruntukan",
          type: "POST",
          dataType: "json",
          async:false,
          data: {akad:akad},
          success: function(response)
          {
            var option = '<option value="">PILIH</option>';
            for (var i = 0; i < response.length; i++) {
              option +='<option value="'+response[i].display_sort+'" akad="'+response[i].code_value+'" akad_value="'+response[i].code_value+'">'+response[i].display_text+'</option>';
            };
            $("#peruntukan","#form_add").html(option);
          }
        })
      })

      function hitung_thp_form_add()
      {
        var thp        = convert_numeric($("#thp","#form_add").val());
        var total_thp  = parseFloat(thp);

        if(total_thp==''){
          total_thp = eval(0);
        }else{
          total_thp = eval(total_thp);
        }

        thp_40 = (total_thp*40/100);

        $("#thp_40","#form_add").val(number_format(thp_40,0,',','.'));
      }

      $("#thp","#form_add").keyup(function(){
        hitung_thp_form_add();
      })

      function hitung_thp_form_edit()
      {
        var thp        = convert_numeric($("#thp","#form_edit").val());
        var total_thp  = parseFloat(thp);

        if(total_thp==''){
          total_thp = eval(0);
        }else{
          total_thp = eval(total_thp);
        }

        thp_40 = (total_thp*40/100);

        $("#thp_40","#form_edit").val(number_format(thp_40,0,',','.'));
      }

      $("#thp","#form_edit").keyup(function(){
        hitung_thp_form_edit();
      })

      $("#peruntukan","#form_edit").change(function(){
        akad = $("#peruntukan","#form_edit").find('option:selected').attr('akad_value');
        labeltotalmarginujroh(akad,$('#label-total-margin','#form_edit'));
        labelpendapatanmarginujroh(akad,$('#label-pendapatan-margin','#form_edit'));
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

      $("#product_code","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#product_code_smile","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#amount","#form_add").change(function(){
        hitung_margin_form_add();
      })
      $("#jangka_waktu","#form_add").change(function(){
        hitung_margin_form_add();
      })
      // var ajaxReq = null; 
      // $("#amount","#form_add").keyup($.debounce(400, function(){
      //   if (ajaxReq != null) ajaxReq.abort();
      //   var ajaxReq = hitung_margin_form_add();
      // }))
      // $("#jangka_waktu","#form_add").keyup($.debounce(400, function(){
      //   if (ajaxReq != null) ajaxReq.abort();
      //   var ajaxReq = hitung_margin_form_add();
      // }))

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
          $(".checker","#checker_jumlah_angsuran_add").show();
          $("#span_txt_lunasi","#form_add").show();
          $("#lunasi_ke_kopegtel","#form_add").show();
          $("#saldo_kewajiban","#form_add").val(0).prop(0);
        }else{
          $(".checker","#checker_jumlah_angsuran_add").hide();
          $("#span_txt_lunasi","#form_add").hide();
          $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
          $("#div_saldo_kewajiban","#form_add").hide();
          $("#saldo_kewajiban","#form_add").val(0).prop(0);
        }
      })
      $("#jumlah_angsuran","#form_add").change(function(){
        if(convert_numeric($("#jumlah_angsuran","#form_add").val())>0){
          $(".checker","#checker_jumlah_angsuran_add").show();
          $("#span_txt_lunasi","#form_add").show();
          $("#lunasi_ke_kopegtel","#form_add").show();
          $("#saldo_kewajiban","#form_add").val(0).prop(0);
        }else{
          $(".checker","#checker_jumlah_angsuran_add").hide();
          $("#span_txt_lunasi","#form_add").hide();
          $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
          $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
          $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
          $("#div_saldo_kewajiban","#form_add").hide();
          $("#saldo_kewajiban","#form_add").val(0).prop(0);
        }
      })
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

      $("#lunasi_ke_kopegtel","#form_add").change(function() {
          if(this.checked) {
            $("#saldo_kewajiban","#form_add").val(0).prop(0);
            $("#div_saldo_kewajiban","#form_add").show();
          }else{
            $("#div_saldo_kewajiban","#form_add").hide();
          }
      });

      $("#lunasi_ke_kopegtel","#form_edit").change(function() {
          if(this.checked) {
            // $("#saldo_kewajiban","#form_edit").val(0).prop(0);
            $("#div_saldo_kewajiban","#form_edit").show();
          }else{
            $("#div_saldo_kewajiban","#form_edit").hide();
          }
      });

      function hitung_margin_form_edit()
      {
        var jenis_margin          = $("#product_code","#form_edit").find('option:selected').attr('jenis_margin');
        if(jenis_margin=='2'){//efektif
          get_total_pokok_efektif_form2();
        }else if(jenis_margin=='3'){ //anuitas
          get_total_margin_dan_angsuran_anuitas_form2();
        }else{ //flat    
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

          // total_margin = (rate*amount*jangka_waktu/1200);
          total_margin = ((rate/1200)*amount*jangka_waktu);

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
      // var ajaxReq = null; 
      // $("#amount","#form_edit").keyup($.debounce(400, function(){
      //   if (ajaxReq != null) ajaxReq.abort();
      //   var ajaxReq = hitung_margin_form_edit();
      // }))
      // $("#jangka_waktu","#form_edit").keyup($.debounce(400, function(){
      //   if (ajaxReq != null) ajaxReq.abort();
      //   var ajaxReq = hitung_margin_form_edit();
      // }))

 
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

      
      $("#act_submit").click(function(){
        $('#form_add').trigger('submit');
      });
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        $("#amount","#form_add").val('0').prop('value','0');
        $("#jumlah_angsuran","#form_add").val('0').prop('value','0');
        $("#saldo_kewajiban","#form_add").val('0').prop('value','0');
        $(".checker","#form_add").hide();
        $("#span_txt_lunasi","#form_add").hide();
        $("#lunasi_ke_kopegtel","#form_add").parent().removeClass('checked');
        $("#lunasi_ke_kopegtel","#form_add").attr('checked',false);
        $("#lunasi_ke_kopegtel","#form_add").prop('checked',false);
        $("#div_saldo_kewajiban","#form_add").hide();
        $.uniform.update()
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
            var calculate_max_jangka_waktu      = $("#calculate_max_jangka_waktu","#form_add").val();
            calculate_max_jangka_waktu        = eval(calculate_max_jangka_waktu);

            if($("#flag_thp100","#form_add").val()=="1"){
              v_thp=r_thp;
            }else{
              v_thp=r_thp_40;
            }

            //if($("#lunasi_ke_kopegtel","#form_add").is(':checked')==true){
			     if($("#check_saldo","#form_add").is(':checked')==true){
              w_thp=eval(v_thp);
            }else{
              w_thp=eval(v_thp - r_jumlah_kewajiban);
            }

            if($("#lunasi_ke_kopegtel","#form_add").is(':checked')==true){
              n_thp=eval(w_thp);
            }else{
              n_thp=eval(w_thp-r_jumlah_angsuran);
            }

            jum = parseFloat(n_thp)-parseFloat(total_angsuran);
			
            // alert(n_thp+'|'+total_angsuran+'|'+jum);
            // alert(r_jangka_waktu+"|"+r_jangka_waktu_produk)

              if(jum<0){
                bValid = false;
                message="Jumlah angsuran melebihi 40% THP";
              }
              // if($("#status_financing_reg","#form_add").val()!='0'){ //dihilangkan dulu permintaan pak amin 17-05-2016
              //   message = 'Tidak dapat dilanjutkan \r\nPegawai masih memiliki pengajuan pembiayaan yang belum diproses';
              //   bValid = false;
              // }
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
              // if($("#telpon_rumah","#form_add").val()==''){
              //   message = "No Telpon Kantor Tidak boleh kosong ";
              //   bValid = false;
              // }
              if($("#amount","#form_add").val()=='0'){
                message = "Jumlah pembiayaan tidak boleh nol ";
                bValid = false;
              }

              // $.ajax({
              //   url: site_url+"rekening_nasabah/cek_masa_pensiun",
              //   type: "POST",
              //   async:false,
              //   dataType: "html",
              //   data: {jangka_waktu:jangka_waktu,masa_pensiun:masa_pensiun},
              //   success: function(response)
              //   {
              //     explode = response.split("|");
              //     if(explode[0]=="false"){
              //       bValid = false;
              //       message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_add").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
              //     }
              //     if(eval(explode[1])<r_jangka_waktu){
              //       bValid = false;
              //       message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_add").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
              //     }
              //     if(eval(explode[1])<0){
              //       bValid = false;
              //       message = "Pegawai akan pensiun dalam 3 bulan kedepan ( "+$("#show_masa_pensiun","#form_add").val()+" )";
              //     }
              //   },
              //   error: function(){
              //     bValid = false;
              //     message = "Error. Please Contact Your Administrator";
              //   }
              // })

              // if(r_jangka_waktu>calculate_max_jangka_waktu){
              //   bValid = false;
              //   message="Jangka waktu angsuran tidak boleh lebih dari "+calculate_max_jangka_waktu+" bulan";
              // } // sementara dihilangkan dulu

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
				          async:false,
                  success: function(response){
                    
                    if(response.success==true){
                      var warning = '', no=1;
                      if (response.uw_policy!='NM') {
                        warning += no+'. Pengajuan ini harus melampirkan laporan pemeriksaan badan dan hasil pengecekan GCU hasil.';
                        no++;
                      }
                      if (response.status_dokumen_lengkap=='0') {
                        if (no>1) {
                          warning+='<br><br>';
                        }
                        if(response.product_code==54){
                          warning += ''+no+'. Mohon Lengkapi Dokumen berikut :<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; KTP Suami istri<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; KK<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Surat Nikah<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Cover Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Fotocopy No rek. Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Slip Gaji<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; SK terakhir<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Sertifikat Tanah<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; IMB<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; PBB \
                          ';
                        }else if(response.product_code==56){
                           warning += ''+no+'. Mohon Lengkapi Dokumen berikut :<br> \
                            &nbsp; &nbsp; &nbsp;a. &nbsp; Data Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Suami/Istri Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Kartu Keluarga<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Nikah (apabila telah menikah)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Slip Gaji Terakhir (gaji normal tanpa rapel)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Surat Perjanjian Kredit/Pembiayaan atau Persetujuan Kredit/Pembiayaan (apabila Take Over pinjaman dari Bank)<br> \
                            &nbsp; &nbsp; &nbsp;b. &nbsp; Data Tanah<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Sertifikat Tanah (posisi terakhir)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Ijin Mendirikan Bangunan (IMB)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy PBB 10 (sepuluh) tahun terakhir<br> \
                            &nbsp; &nbsp; &nbsp;c. &nbsp; Data Penjual (apabila membeli dari penjual)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Penjual<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Suami/Istri Penjual<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Kartu Keluarga<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Nikah (apabila telah menikah)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Cerai (apabila telah bercerai)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Penetapan Pengadilan tentang Pembagian Harta<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Kematian (apabila penjual meninggal)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Waris<br> \
                            &nbsp; &nbsp; &nbsp;d. &nbsp; Data Developer<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Akta Pendirian/Perubahannya untuk pembelian dari Developer<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy SIUP, dan perijinan lainnya<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Surat Permohonan Pencairan dari Developer<br> \
                          ';
                        }
                      }

                      if (warning!='') {
                        $.alert({
                          title:"Warning!",icon:'icon-warning-sign',backgroundDismiss:false,
                          content:warning,
                          confirmButtonClass:'btn yellow',
                          confirm:function(){
                            $.alert({
                              title:"Success",icon:'icon-check',backgroundDismiss:false,
                              content:'Pengajuan Pembiayaan Baru BERHASIL diinput!',
                              confirmButtonClass:'btn green',
                              confirm:function(){
                                location.reload();
                              }
                            })
                          }
                        })
                      }else{
                        $.alert({
                          title:"Success",icon:'icon-check',backgroundDismiss:false,
                          content:'Pengajuan Pembiayaan Baru BERHASIL diinput!',
                          confirmButtonClass:'btn green',
                          confirm:function(){
                            location.reload();
                          }
                        })
                      }
                    }else{
                      success1.hide();
                      error1.show();
                      $("#span_message","#form_add").html("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
                    }
                    App.scrollTo(form1, -200);
                  },
                  error:function(){
                      success1.hide();
                      error1.show();
                      $("#span_message","#form_add").html("Failed to Connect into Database, Please Check ur Connection or Try Again Latter");
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
        $("#edit").show();
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
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
                data: {band:response.band},
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
            $("#registration_no","#form_edit").val(response.registration_no);
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
            $("#telpon_rumah","#form_edit").val(response.telpon_rumah);
            $("#nama_pasangan","#form_edit").val(response.nama_pasangan);
            $("#pekerjaan_pasangan","#form_edit").val(response.pekerjaan_pasangan);
            // $("#jumlah_tanggungan","#form_edit").val(response.jumlah_tanggungan);
            // $("#status_rumah","#form_edit").val(response.status_rumah);
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
            // if(response.lunasi_ke_koptel=="1"){
            //   $("#lunasi_ke_koptel","#form_edit").parent().addClass('checked');
            //   $("#lunasi_ke_koptel","#form_edit").attr('checked',true);
            //   $("#lunasi_ke_koptel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(response.saldo_kewajiban_ke_koptel);
              $("#saldo_kewajiban_ke_koptel","#form_edit").prop(response.saldo_kewajiban_ke_koptel);
            //   $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
              
            // }else{
            //   $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_edit").attr('checked',false); //menghilangkan checklist
            //   $("#lunasi_ke_koptel","#form_edit").prop('checked',false); //menghilangkan checklist
            //   $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
              // $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
            // }

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_list_saldo_lunas_reg",
               dataType: "json",
               data: {cif_no:response.cif_no},
               success: function(response){
                  html = '';
                  for(k = 0 ; k < response.length ; k++){
                    html += ' \
                          <tr>\
                            <td align="center" style="height:30px;width:5%;text-align:center;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                                <input type="hidden" name="account_financing_no[]" id="account_financing_no" value="'+response[k].account_financing_no+'">\
                                <input type="hidden" name="no_pembiayaan" id="no_pembiayaan" value="'+response[k].account_financing_no+'">\
                    ';
                    if(response[k].is_checked=='1'){
                      html += ' \
                                <input type="checkbox" name="check_saldo[]" id="check_saldo" checked>\
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="1">\
                      ';
                    }else{
                      html += ' \
                                <input type="checkbox" name="check_saldo[]" id="check_saldo">\
                                <input type="hidden" name="check_saldo_val[]" id="check_saldo_val" value="0">\
                      ';
                    }
                    html += ' \
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_pokok[]" value="'+response[k].saldo_pokok+'">'+number_format(response[k].saldo_pokok,0,',','.')+'\
                            </td>\
                            <td align="right" style="height:30px;padding-right:10px;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">\
                              <input type="hidden" name="check_saldo_margin[]" value="'+response[k].saldo_margin+'">'+number_format(response[k].saldo_margin,0,',','.')+'\
                            </td>\
                          </tr>\
                    ';
                  }
                  $("#list_saldo_pokok tbody","#form_edit").html(html);
               }
            });

            $("#peruntukan","#form_edit").trigger('change');
            cek_max_jangka_waktu_edit($("#product_code","#form_edit").val());
            $("#product_code","#form_edit").trigger('change');
            hitung_margin_form_edit()

          }
        });

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
            var calculate_max_jangka_waktu      = $("#calculate_max_jangka_waktu","#form_edit").val();
            calculate_max_jangka_waktu        = eval(calculate_max_jangka_waktu);

            if($("#flag_thp100","#form_edit").val()=="1"){
              v_thp=r_thp;
            }else{
              v_thp=r_thp_40;
            }
			/*
            if($("#lunasi_ke_kopegtel","#form_edit").is(':checked')==true){
              w_thp=eval(v_thp);
            }else{
              w_thp=eval(v_thp-r_jumlah_angsuran);
            }

            if($("#lunasi_ke_koptel","#form_edit").is(':checked')==true){
              n_thp=eval(w_thp);
            }else{
              n_thp=eval(w_thp-r_jumlah_kewajiban);
            }
			*/
            //if($("#lunasi_ke_kopegtel","#form_add").is(':checked')==true){
			if($("#check_saldo","#form_edit").is(':checked')==true){
              w_thp=eval(v_thp);
            }else{
              w_thp=eval(v_thp - r_jumlah_kewajiban);
            }

            if($("#lunasi_ke_kopegtel","#form_edit").is(':checked')==true){
              n_thp=eval(w_thp);
            }else{
              n_thp=eval(w_thp-r_jumlah_angsuran);
            }

            jum = parseFloat(n_thp)-parseFloat(total_angsuran);
            
            // alert(n_thp+'|'+total_angsuran+'|'+jum);
            console.log(n_thp)
            console.log(total_angsuran)
            console.log(jum)
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
              // if($("#telpon_rumah","#form_edit").val()==''){
              //   message = "No Telpon Kantor Tidak boleh kosong ";
              //   bValid = false;
              // }
              if($("#amount","#form_edit").val()=='0'){
                message = "Jumlah pembiayaan tidak boleh nol ";
                bValid = false;
              }
              // $.ajax({
              //   url: site_url+"rekening_nasabah/cek_masa_pensiun",
              //   type: "POST",
              //   async:false,
              //   dataType: "html",
              //   data: {jangka_waktu:jangka_waktu,masa_pensiun:masa_pensiun},
              //   success: function(response)
              //   {
              //     explode = response.split("|");
              //     if(explode[0]=="false"){
              //       bValid = false;
              //       message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
              //     }
              //     if(eval(explode[1])<r_jangka_waktu){
              //       bValid = false;
              //       message = "Jangka waktu melebihi masa pensiun ( "+$("#show_masa_pensiun","#form_edit").val()+" ) maksimal jangka waktu adalah "+explode[1]+" bulan";
              //     }
              //     if(eval(explode[1])<0){
              //       bValid = false;
              //       message = "Pegawai akan pensiun dalam 3 bulan kedepan ( "+$("#show_masa_pensiun","#form_edit").val()+" )";
              //     }
              //   },
              //   error: function(){
              //     bValid = false;
              //     message = "Error. Please Contact Your Administrator";
              //   }
              // })

              // if(r_jangka_waktu>calculate_max_jangka_waktu){
              //   bValid = false;
              //   message="Jangka waktu angsuran tidak boleh lebih dari "+calculate_max_jangka_waktu+" bulan";
              // } //untuk sementara diloloskan


              if(bValid==true){
                // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
                $.ajax({
                  type: "POST",
                  url: site_url+"rekening_nasabah/edit_pengajuan_pembiayaan_koptel",
                  dataType: "json",
				  async:false,
                  data: form2.serialize(),
                  success: function(response){
                    if(response.success==true){
                      var warning = '', no=1;
                      if (response.uw_policy!='NM') {
                        warning += no+'. Pengajuan ini harus melampirkan laporan pemeriksaan badan dan hasil pengecekan GCU hasil.';
                        no++;
                      }
                      if (response.status_dokumen_lengkap=='0') {
                        if (no>1) {
                          warning+='<br><br>';
                        }
                        if(response.product_code==54){
                          warning += ''+no+'. Mohon Lengkapi Dokumen berikut :<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; KTP Suami istri<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; KK<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Surat Nikah<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Cover Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Fotocopy No rek. Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Slip Gaji<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; SK terakhir<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; Sertifikat Tanah<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; IMB<br> \
                            &nbsp; &nbsp; &nbsp;-&nbsp; PBB \
                          ';
                        }else if(response.product_code==56){
                           warning += ''+no+'. Mohon Lengkapi Dokumen berikut :<br> \
                            &nbsp; &nbsp; &nbsp;a. &nbsp; Data Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Suami/Istri Pemohon<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Kartu Keluarga<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Nikah (apabila telah menikah)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Slip Gaji Terakhir (gaji normal tanpa rapel)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Buku Tabungan<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Surat Perjanjian Kredit/Pembiayaan atau Persetujuan Kredit/Pembiayaan (apabila Take Over pinjaman dari Bank)<br> \
                            &nbsp; &nbsp; &nbsp;b. &nbsp; Data Tanah<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Sertifikat Tanah (posisi terakhir)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Ijin Mendirikan Bangunan (IMB)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy PBB 10 (sepuluh) tahun terakhir<br> \
                            &nbsp; &nbsp; &nbsp;c. &nbsp; Data Penjual (apabila membeli dari penjual)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Penjual<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP Suami/Istri Penjual<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Kartu Keluarga<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Nikah (apabila telah menikah)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Cerai (apabila telah bercerai)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Penetapan Pengadilan tentang Pembagian Harta<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Kematian (apabila penjual meninggal)<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Surat Waris<br> \
                            &nbsp; &nbsp; &nbsp;d. &nbsp; Data Developer<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy NPWP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy KTP<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy Akta Pendirian/Perubahannya untuk pembelian dari Developer<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Fotocopy SIUP, dan perijinan lainnya<br> \
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- &nbsp; Surat Permohonan Pencairan dari Developer<br> \
                          ';
                        }
                      }

                      if (warning!='') {
                        $.alert({
                          title:"Warning!",icon:'icon-warning-sign',backgroundDismiss:false,
                          content:warning,
                          confirmButtonClass:'btn yellow',
                          confirm:function(){
                            $.alert({
                              title:"Success",icon:'icon-check',backgroundDismiss:false,
                              content:'Pengajuan Pembiayaan Baru BERHASIL diupdate!',
                              confirmButtonClass:'btn green',
                              confirm:function(){
                                location.reload();
                              }
                            })
                          }
                        })
                      }else{
                        $.alert({
                          title:"Success",icon:'icon-check',backgroundDismiss:false,
                          content:'Pengajuan Pembiayaan Baru BERHASIL diupdate!',
                          confirmButtonClass:'btn green',
                          confirm:function(){
                            location.reload();
                          }
                        })
                      }
                    }else{
                      success1.hide();
                      error1.show();
                    }
                    App.scrollTo(form1, -200);
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
           "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "src_product", "value": $("#src_product").val() } );
            },
          "aoColumns": [            
            { "bSortable": false },
            { "bSortable": false },
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

        $("#src_product").change(function(){
          dTreload();
        });

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
          $("#jumlah_angsuran","#form_add").trigger('change');
       });
       $("#select").click(function(){
         
         result = $("#result").val();
          var customer_no = $("#result").val();
          $("#close","#dialog_rembug").trigger('click');
         get_data_cif_by_nik(customer_no) 

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

        $("#nik","#form_add").on('keypress',function(e){
            if(e.which==13){
                // alert("Enter was pressed was presses");
                get_data_cif_by_nik($("#nik","#form_add").val());
            }
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


      //angsuran ke koptel 15-04-2015 13:00
      // $("#jumlah_kewajiban","#form_add").keyup(function(){
      //   if(convert_numeric($("#jumlah_kewajiban","#form_add").val())>0){
      //     $(".checker","#checker_jumlah_kewajiban_add").show();
      //     $("#span_txt_lunasi_ke_koptel","#form_add").show();
      //     $("#lunasi_ke_koptel","#form_add").show();
      //     $("#saldo_kewajiban_ke_koptel","#form_add").val(0).prop(0);
      //   }else{
      //     $(".checker","#checker_jumlah_kewajiban_add").hide();
      //     $("#span_txt_lunasi_ke_koptel","#form_add").hide();
      //     $("#lunasi_ke_koptel","#form_add").parent().removeClass('checked');
      //     $("#lunasi_ke_koptel","#form_add").attr('checked',false);
      //     $("#lunasi_ke_koptel","#form_add").prop('checked',false);
      //     $("#div_saldo_kewajiban_ke_koptel","#form_add").hide();
      //     $("#saldo_kewajiban_ke_koptel","#form_add").val(0).prop(0);
      //   }
      // })

      // $("#lunasi_ke_koptel","#form_add").change(function() {
      //     if(this.checked) {
      //       $("#saldo_kewajiban_ke_koptel","#form_add").val(0).prop(0);
      //       $("#div_saldo_kewajiban_ke_koptel","#form_add").show();
      //     }else{
      //       $("#saldo_kewajiban_ke_koptel","#form_add").val(0).prop(0);
      //       $("#div_saldo_kewajiban_ke_koptel","#form_add").hide();
      //     }
      // });

      // $("#jumlah_kewajiban","#form_edit").keyup(function(){
      //   if(convert_numeric($("#jumlah_kewajiban","#form_edit").val())>0){
      //     $(".checker","#checker_jumlah_kewajiban_edit").show();
      //     $("#span_txt_lunasi_ke_koptel","#form_edit").show();
      //     $("#lunasi_ke_koptel","#form_edit").show();
      //     $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
      //   }else{
      //     $(".checker","#checker_jumlah_kewajiban_edit").hide();
      //     $("#span_txt_lunasi_ke_koptel","#form_edit").hide();
      //     $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked');
      //     $("#lunasi_ke_koptel","#form_edit").attr('checked',false);
      //     $("#lunasi_ke_koptel","#form_edit").prop('checked',false);
      //     $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
      //     $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
      //   }
      // })

      // $("#lunasi_ke_koptel","#form_edit").change(function() {
      //     if(this.checked) {
      //       // $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
      //       $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
      //     }else{
      //       // $("#saldo_kewajiban_ke_koptel","#form_edit").val(0).prop(0);
      //       $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
      //     }
      // });
      //end angsuran ke koptel 15-04-2015 13:00


      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});

$('input#check_saldo','#form_add').live('click',function () {
  if($(this).is(":checked")){
    $(this).closest('tr').find('input#check_saldo_val',"#form_add").val('1');
  }else{
    $(this).closest('tr').find('input#check_saldo_val',"#form_add").val('0');
  }
})

$('input#check_saldo','#form_edit').live('click',function () {
  if($(this).is(":checked")){
    $(this).closest('tr').find('input#check_saldo_val',"#form_edit").val('1');
  }else{
    $(this).closest('tr').find('input#check_saldo_val',"#form_edit").val('0');
  }
})
</script>
<!-- END JAVASCRIPTS -->

