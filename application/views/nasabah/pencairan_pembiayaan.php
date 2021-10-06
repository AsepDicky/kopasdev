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
      Rekening Nasabah <small>Pencairan Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pencairan Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pencairan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <!-- <div class="clearfix"> -->
         <!-- <div class="btn-group pull-right">
            <button id="btn_delete" class="btn red">
              Reject <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button id="btn_activate" class="btn green">
              Approve <i class="icon-ok-sign"></i>
            </button>
         </div> 
         <label>
            Rembug Pusat &nbsp; : &nbsp;
            <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled>
            <input type="hidden" name="cm_code" id="cm_code">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <input type="submit" id="filter" value="Filter" class="btn blue">
         </label>
         <div class="btn-group">
            <button id="btn_inactivate" class="btn red">
              Inapprove <i class="icon-lock"></i>
            </button>
         </div>
        <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
         
      <!-- </div> -->

         <!-- <label> -->
            <!-- Rembug Pusat &nbsp; : &nbsp; -->
            <!-- <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled> -->
            <!-- <input type="hidden" name="cm_code" id="cm_code"> -->
            <!-- <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a> -->
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         <!-- </label> -->
      <!--      
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Rembug</h3>
         </div>
         <div class="modal-body">
            <div class="row-fluid">
               <div class="span12">
                  <h4>Masukan Kata Kunci</h4>
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="branch" id="branch" class="span12 m-wrap">
                     <option value="">Pilih Kantor Cabang</option>
                     <option value="">All</option>
                     <?php
                     if($this->session->userdata('flag_all_branch')=='1'){
                     ?>
                     <?php
                     foreach($branch as $dtbranch):
                        if($this->session->userdata('branch_id')==$dtbranch['branch_id']){
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>" selected><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }else{
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>"><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }
                     endforeach; 
                     ?>
                     <?php }else{ ?>
                     <option value="<?php echo $this->session->userdata('branch_id'); ?>"><?php echo $this->session->userdata('branch_name'); ?></option>
                     <?php } ?>
                  </select></p>
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      -->
	  
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
      <p>
      <table class="table table-striped table-bordered table-hover" id="rekening_pembiayaan_table">
         <thead>
            <tr>
               <th width="11%">No. Rekening</th>
               <th width="10%">NIK</th>
               <th width="20%">Nama</th>
               <th width="8%">Akad</th>
               <th width="11%">Pembiayaan</th>
               <th width="15%">Kewajiban Koptel</th>
               <th width="15%">Kewajiban Kopegtel</th>
               <th width="8%">Waktu</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pencairan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_id" name="account_financing_id">
          <input type="hidden" id="saldo_memo_tabungan" name="saldo_memo_tabungan">
          <input type="hidden" id="pembiayaan_active_is_exists" name="pembiayaan_active_is_exists">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Pencairan Pembiayaan Berhasil Di Proses !
            </div>
          </br>      
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
                        <label class="control-label">Rekening<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Bank</span>
                             <input type="text" class="medium m-wrap" name="nama_bank" id="nama_bank" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Cabang</span>
                             <input type="text" class="medium m-wrap" name="bank_cabang" id="bank_cabang" readonly="" style="background-color:#eee;"  onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>  
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">No Rekening</span>
                             <input type="text" class="medium m-wrap" name="no_rekening" id="no_rekening" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div>   
                    <div class="control-group">
                        <label class="control-label">&nbsp;<span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend">
                             <span class="add-on" style="width:90px;text-align:left;font-size:13px;">Atas Nama</span>
                             <input type="text" class="medium m-wrap" name="atasnama_rekening" id="atasnama_rekening" readonly="" style="background-color:#eee;" onkeyup="this.value=this.value.toUpperCase()">
                           </div>
                        </div>
                    </div> 
                    <hr> 

                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Koptel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_kewajiban_edit">
                          <div class="input-prepend">
                            <span class="add-on">Rp</span>
                            <input type="text" name="jumlah_kewajiban" id="jumlah_kewajiban" class="medium m-wrap mask-money"  style="width:120px !important;background-color:#eee;" disabled="" />
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" disabled="" id="lunasi_ke_koptel" name="lunasi_ke_koptel" value="1"/><span id="span_txt_lunasi_ke_koptel" style="display:none;"> Lunasi</span>
                       </div>
                    </div> 
                    <div class="control-group" id="div_saldo_kewajiban_ke_koptel" style="display:none;">
                        <label class="control-label">Saldo Kewajiban Ke Koptel<span class="required">*</span></label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;background-color:#eee;" disabled=""  name="saldo_kewajiban_ke_koptel" id="saldo_kewajiban_ke_koptel" value="0">
                            <span class="add-on">,00</span>
                          </div>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Ke Kopegtel<span class="required">*</span></label>
                       <div class="controls" id="checker_jumlah_angsuran_edit">
                          <div class="input-prepend input-append">
                            <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;background-color:#eee;" disabled=""  name="jumlah_angsuran" id="jumlah_angsuran" value="0">
                            <span class="add-on">,00</span>
                          </div>
                          &nbsp;&nbsp;<input type="checkbox" disabled="" id="lunasi_ke_kopegtel" name="lunasi_ke_kopegtel" value="1"/><span id="span_txt_lunasi"> Lunasi</span>
                       </div>
                    </div> 
                    <div id="div_saldo_kewajiban" style="display:none;">
                      <div class="control-group">
                          <label class="control-label">Saldo Kewajiban Ke Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="m-wrap mask-money" style="width:120px;background-color:#eee;" disabled=""  name="saldo_kewajiban" id="saldo_kewajiban" maxlength="10" value="0">
                              <span class="add-on">,00</span>
                            </div>
                          </div>
                      </div> 
                      <div class="control-group">
                          <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
                          <div class="controls">
                            <select class="large  m-wrap" name="pelunasan_ke_kopeg_mana" id="pelunasan_ke_kopeg_mana" disabled="" style="background-color:#eee;">
                              <?php foreach($kopegtel as $data):?>
                              <option value="<?php echo $data['kopegtel_code'];?>"><?php echo $data['nama_kopegtel'];?></option>
                              <?php endforeach?>
                            </select>
                          </div>
                      </div>                      
                    </div>                      
                    <hr>                    
                    <div id="saving2" style="display:none;"> 
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving2" name="account_saving" class="medium m-wrap" disabled style="background-color:#eee;">                     
                          </select>
                          <input type="hidden" name="account_saving_hide" id="account_saving_hide">
                       </div>
                    </div>                   
                    </div>          
                     
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan</label>
                       <div class="controls">
                          <input type="text" name="tgl_pengajuan" readonly=""  style="background-color:#eee;" id="mask_date" class="small m-wrap"/>
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
                           <select id="kopegtel" name="kopegtel" class="large m-wrap" disabled="" style="background-color:#eee;">
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
                          <select id="modal" name="modal" class="medium m-wrap" >  
						<option value="">Pilih</option>
                        <option value="1">Anggota</option>
						<option value="2">BRI SYARIAH</option>
						<option value="3">BNI SYARIAH</option>
						<option value="4">MUAMALAT</option>
						<option value="5">DANAMON SYARIAH</option>
                       						  
                          </select>
                       </div>
                    </div>     					
                    <div class="control-group">
                       <label class="control-label">Produk</label>
                       <div class="controls">
                           <select id="product2" name="product" class="medium m-wrap" disabled style="background-color:#eee;">     
                          </select>
                       </div>
                    </div>      
                    <div class="control-group" style="display:none;">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no2" class="medium m-wrap" readonly="" style="background-color:#eee;" />
                       </div>
                    </div>      
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Akad</label>
                       <div class="controls">
                          <select id="akad2" name="akad" class="medium m-wrap" disabled style="background-color:#eee;">                     
                            <option value="">PILIH</option>
                            <?php foreach($akad as $data): ?>
                              <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>       
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="nilai_pembiayaan" id="nilai_pembiayaan2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran</label>
                       <div class="controls">
                        <input type="text" value="0"  class=" m-wrap" readonly="" name="jangka_waktu" id="jangka_waktu2" style="background-color:#eee;width:30px;"/>
                        <select id="periode_angsuran" disabled style="background-color:#eee;" name="periode_angsuran" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Hari</option>                    
                            <option value="1">Minggu</option>                    
                            <option value="2">Bulan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                        <span class="help-inline"></span></div>
                    </div>        
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Titipan Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="titipan_notaris" id="titipan_notaris2">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Margin Pembiayaan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="margin_pembiayaan" id="margin_pembiayaan2" maxlength="12">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>     

                  <div id="nisbah2">     
                    <div class="control-group">
                       <label class="control-label">Total Proyeksi Keuntungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="amount_proyeksi_keuntungan" id="amount_proyeksi_keuntungan" maxlength="12">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Nisbah Bagi Hasil</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;width:60px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>  
                    </div>      
                    <div class="control-group hide">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi" id="mask_date" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <hr>  
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Jadwal Angsuran</label>
                       <div class="controls">
                          <select id="jadwal_angsuran2" disabled style="background-color:#eee;" name="jadwal_angsuran" class="medium m-wrap">                     
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
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask_date mask-money" id="angs_tanggal" name="angs_tanggal[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_pokok" name="angs_pokok[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_margin" name="angs_margin[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_tabungan" name="angs_tabungan[]">
                              </td>
                            </tr>
                         </tbody>
                      </table>



                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="20%" style="vertical-align:middle;text-align:center;">Total Angsuran</th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_pokok" name="total_angs_pokok[]">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_margin" name="total_angs_margin[]">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_tabungan" name="total_angs_tabungan[]">
                               </th>
                               <th width="14%" style="text-align:center;">
                               </th>
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
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_pokok" id="angsuran_pokok2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_margin" id="angsuran_margin2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_tabungan" id="angsuran_tabungan2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>               
                    <div class="control-group" id="div_tabungan_wajib">
                       <label class="control-label">Tabungan Wajib</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" name="tabungan_wajib" id="tabungan_wajib2">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>        
                    <div class="control-group" id="div_tabungan_kelompok">
                       <label class="control-label">Tabungan Kelompok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" name="tabungan_kelompok" id="tabungan_kelompok2">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  name="total_angsuran" readonly="" id="total_angsuran2">
                             <span class="add-on">,00</span>
                           </div>
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
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Simpanan Wajib Pinjam</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="simpanan_wajib_pinjam" id="simpanan_wajib_pinjam">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group hide">
                       <label class="control-label">Cadangan Resiko</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="cadangan_resiko" id="cadangan_resiko">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>     
                    <!-- <div class="control-group">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="dana_kebajikan" id="dana_kebajikan">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>    -->   
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="biaya_administrasi" id="biaya_administrasi">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group" style="display:none;">
                       <label class="control-label">Biaya Jasa Layanan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="biaya_jasa_layanan" id="biaya_jasa_layanan">
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
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="biaya_notaris" id="biaya_notaris">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      

                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="p_asuransi_jiwa" id="p_asuransi_jiwa">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <hr size="1">

                    <div class="row">
                      <div class="span4">     
                        <div class="control-group">
                           <label class="control-label">Tanggal Akad</label>
                           <div class="controls">
                              <input type="text" name="tgl_akad" id="tgl_akad" class="mask_date small m-wrap"/>
                           </div>
                        </div>           
                        <div class="control-group">
                           <label class="control-label">Tanggal Angsuran Ke-1</label>
                           <div class="controls">
                              <input type="text" name="angsuranke1" id="angsuranke1" class="mask_date small m-wrap"/>
                           </div>
                        </div>   
                        <div class="control-group">
                           <label class="control-label">Tanggal Jatuh Tempo</label>
                           <div class="controls">
                              <input type="text" name="tgl_jtempo" id="tgl_jtempo" readonly="" style="background-color:#eee;" class="mask_date small m-wrap"/>
                           </div>
                        </div>     
                        <div class="control-group">
                           <label class="control-label">Tanggal Transfer</label>
                           <div class="controls">
                              <input type="text" name="tanggal_transfer" id="tanggal_transfer" class="mask_date small m-wrap" value="<?php echo date('d/m/Y') ?>"/>
                           </div>
                        </div>   
                        <div class="control-group" style="display:none;">
                           <label class="control-label">Premi Asuransi Jaminan</label>
                           <div class="controls">
                               <div class="input-prepend input-append">
                                 <span class="add-on">Rp</span>
                                 <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="p_asuransi_jaminan" id="p_asuransi_jaminan">
                                 <span class="add-on">,00</span>
                               </div>
                             </div>
                        </div>
                      </div> 
                      <div class="span6" id="span_angsuran_nonreguler"> </div>
                    </div>  
                    <hr>  
                    <div id="div_fild_bawah" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Program  Khusus</label>
                         <div class="controls">
                            <select id="program_khusus2" disabled style="background-color:#eee;" name="program_khusus" class="medium m-wrap">                     
                              <option value="">PILIH</option>                    
                              <option value="0">Ya</option>                    
                              <option value="1">Tidak</option>
                            </select>
                         </div>
                      </div> 
                      <div id="program2">  
                      <div class="control-group">
                         <label class="control-label">Jenis Program</label>
                         <div class="controls">
                            <select id="jenis_program" disabled style="background-color:#eee;" name="jenis_program" class="medium m-wrap">                     
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
                          <select id="sektor_ekonomi" style="background-color:#eee;" disabled name="sektor_ekonomi" class="medium m-wrap">                     
                                <?php foreach ($sektor as $data):?>
                                <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>  
                          </select>
                         </div>
                      </div>   
                      <div class="control-group">
                         <label class="control-label">Peruntukan Pembiayaan</label>
                         <div class="controls">
                          <select id="peruntukan_pembiayaan" style="background-color:#eee;" disabled name="peruntukan_pembiayaan" class="medium m-wrap">                     
                                <?php foreach ($peruntukan as $data):?>
                                <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                              <?php endforeach?>  
                          </select>
                         </div>
                      </div> 
                      <div class="control-group">
                         <label class="control-label">Menggunakan Wakalah ?</label>
                         <div class="controls">
                          <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap" style="background-color:#eee;" disabled="">                     
                            <option value="">Pilih</option>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                          </select>
                         </div>
                      </div> 
                    </div>
            <div class="form-actions">
               <input type="hidden" name="account_financing_reg_id" id="account_financing_reg_id">
               <input type="hidden" name="is_banmod" id="is_banmod">
               <input type="hidden" name="account_financing_reg_no" id="account_financing_reg_no">
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->

  

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
     
      $("input#mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("input.mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

      $("input[name='angsuranke1']","#form_edit").change(function(){
        angsuranke1 = $(this).val();
        day = angsuranke1.substr(0,2);
        month = angsuranke1.substr(2,2);
        year = angsuranke1.substr(4,4);
        angsuranke1 = year+'-'+month+'-'+day;
        periode_angsuran = $("#periode_angsuran","#form_edit").val();
        jangka_waktu = $("#jangka_waktu2","#form_edit").val();
        if($(this).val()!="" && periode_angsuran!="" && jangka_waktu!="")
        {
          switch(periode_angsuran){
            case "0":
            case "1":
            case "2":
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {periode_angsuran:periode_angsuran,jangka_waktu:jangka_waktu,angsuranke1:angsuranke1},
              url: site_url+"/cif/ajax_get_tanggal_jatuh_tempo",
              success: function(response){
                $("input[name='tgl_jtempo']","#form_edit").val(response.jatuh_tempo);
              }
            });
            break;
          }
        }
        
      });

      $("#select").click(function(){
         result = $("#result").val();
         if(result != null)
         {
            $("#add_cm_code").val(result);
            $("#edit_cm_code").val(result);
            $("#cm_code").val(result);
            $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
            $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
            $("#close","#dialog_rembug").trigger('click');

            $('#rekening_pembiayaan_table').dataTable({
              "bDestroy": true,
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": site_url+"rekening_nasabah/datatable_pencairan_pembiayaan",
              "fnServerParams": function ( aoData ) {
                  aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
              },
              "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                null,
                { "bSortable": false }
              ],

              "aLengthMenu": [
                  [5, 15, 20, -1],
                  [5, 15, 20, "All"] // change per page values here
              ],
              // set the initial value
              "iDisplayLength": 5,
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
          // $(".dataTables_length,.dataTables_filter").parent().hide();

         }
         else
         {
            alert("Please select row first !");
         }

      });
      
      $("#result option:selected").live('dblclick',function(){
        $("#select").trigger('click');        
      })
   
      $("#branch","#dialog_rembug").change(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         var branch = $("#branch","#dialog_rembug").val();
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword",
            dataType: "json",
            data: {keyword:keyword,branch_id:branch},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
               }
               $("#result").html(html);
            }
         })
      })

      $("#keyword","#dialog_rembug").keypress(function(e){
         keyword = $(this).val();
         if(e.which==13){
            var branch = $("#branch","#dialog_rembug").val();
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
         }
      });

      $("#browse_rembug").click(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         branch = $("#branch","#dialog_rembug").val();
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
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


      $("#src_product").change(function(){
        dTreload();
      })
    

      // fungsi untuk check all
      jQuery('#rekening_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#rekening_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });
   
      // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_id = $(this).attr('account_financing_id');
        var is_banmod = $(this).attr('is_banmod');
        var product_code = $(this).attr('product_code');
        $('#is_banmod','#form_edit').val(is_banmod);
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_id:account_financing_id,is_banmod:is_banmod},
          url: site_url+"transaction/get_account_financing_by_financing_id",
          success: function(response)
          {

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

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_ajax_produk_by_cif_type_link_edit",
               dataType: "json",
               async:false,
               data: {cif_type:response.cif_type},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
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
                     html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                  }
                  $("#account_saving2","#form_edit").html(html);
               }
            });  

            $("#form_edit input[name='account_financing_reg_id']").val(response.account_financing_reg_id);
            $("#form_edit input[name='registration_no2']").val(response.registration_no);
            $("#form_edit input[name='account_financing_id']").val(response.account_financing_id);
            $("#form_edit input[name='branch_code']").val(response.branch_code);
            $("#form_edit input[name='cif_no']").val(response.cif_no);
            $("#form_edit input[name='nama']").val(response.nama);
            $("#form_edit input[name='account_financing_no']").val(response.account_financing_no);
            $("#form_edit input[name='nilai_pembiayaan']").val(number_format(response.pokok,0,',','.'));
            $("#form_edit input[name='margin_pembiayaan']").val(number_format(response.margin,0,',','.'));
            $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
            $("#form_edit select[name='periode_angsuran']").val(response.periode_jangka_waktu);
            $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
            $("#form_edit input[name='angsuran_pokok']").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#form_edit input[name='angsuran_margin']").val(number_format(response.angsuran_margin,0,',','.'));
            $("#form_edit input[name='angsuran_tabungan']").val(number_format(response.angsuran_catab,0,',','.'));
            $("#form_edit input[name='simpanan_wajib_pinjam']").val(number_format(response.simpanan_wajib_pinjam,0,',','.'));
            $("#form_edit input[name='nominal_taksasi']").val(number_format(response.nominal_taksasi,0,',','.'));
            $("#form_edit input[name='titipan_notaris']").val(number_format(response.titipan_notaris,0,',','.'));
            $("#form_edit select[name='product']").val(response.product_code);

            $("#form_edit input[name='jabatan']").val(response.posisi);
            $("#form_edit input[name='lokasi_kerja']").val(response.loker);
            $("#form_edit input[name='nama_bank']").val(response.nama_bank);
            $("#form_edit input[name='no_rekening']").val(response.no_rekening);
            $("#form_edit input[name='atasnama_rekening']").val(response.atasnama_rekening);
            $("#form_edit input[name='bank_cabang']").val(response.bank_cabang);

            var cif_type = response.cif_type
            if(cif_type=='1'){
              $("#id_jaminan","#form_edit").show();
              $("#div_tabungan_wajib").hide();
              $("#div_tabungan_kelompok").hide();
              $("#form_edit input[name='tabungan_wajib']").val(0);
              $("#form_edit input[name='tabungan_kelompok']").val(0);
              $("#form_edit select[name='jaminan']").val(response.jenis_jaminan);
              $("#form_edit textarea[name='keterangan_jaminan']").val(response.keterangan_jaminan);
              if(response.jenis_jaminan_sekunder!=null) $("#form_edit select[name='jaminan_sekunder']").val(response.jenis_jaminan_sekunder); else $("#form_edit select[name='jaminan_sekunder']").val('');
              if(response.keterangan_jaminan_sekunder!=null) $("#form_edit textarea[name='keterangan_jaminan_sekunder']").val(response.keterangan_jaminan_sekunder); else $("#form_edit textarea[name='keterangan_jaminan_sekunder']").val('');
              if(response.nominal_taksasi_sekunder!=null) $("#form_edit input[name='nominal_taksasi_sekunder']").val(number_format(response.nominal_taksasi_sekunder,0,',','.')); else $("#form_edit input[name='nominal_taksasi_sekunder']").val('');
            }else{
              $("#id_jaminan","#form_edit").hide();
              $("#div_tabungan_wajib").show();
              $("#div_tabungan_kelompok").show();
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

            $("#form_edit input[name='total_angsuran']").val(number_format(total_angsuran),0,',','.');
            $("#form_edit input[name='cadangan_resiko']").val(number_format(response.cadangan_resiko,0,',','.'));
            // $("#form_edit input[name='dana_kebajikan']").val(number_format(response.dana_kebajikan),0,',','.');
            $("#form_edit input[name='biaya_administrasi']").val(number_format(response.biaya_administrasi,0,',','.'));
            $("#form_edit input[name='biaya_jasa_layanan']").val(number_format(response.biaya_jasa_layanan,0,',','.'));
            total_biaya=parseFloat(response.simpanan_wajib_pinjam);
            total_biaya+=parseFloat(response.biaya_administrasi);
            total_biaya+=parseFloat(response.biaya_jasa_layanan);
            $("#form_edit input[name='total_biaya']").val(number_format(total_biaya,0,',','.'));

            $("#form_edit input[name='biaya_notaris']").val(number_format(response.biaya_notaris,0,',','.'));
            $("#form_edit input[name='p_asuransi_jiwa']").val(number_format(response.biaya_asuransi_jiwa,0,',','.'));
            $("#form_edit input[name='p_asuransi_jaminan']").val(number_format(response.biaya_asuransi_jaminan,0,',','.'));

            $("#form_edit select[name='sumber_dana_pembiayaan']").val(response.sumber_dana);
            $("#form_edit input[name='dana_sendiri']").val(number_format(response.dana_sendiri,0,',','.'));
            $("#form_edit input[name='dana_kreditur']").val(number_format(response.dana_kreditur,0,',','.'));
            $("#form_edit input[name='keuntungan']").val(response.ujroh_kreditur_persen);
            $("#form_edit input[name='angsuran']").val(response.ujroh_kreditur);
            $("#form_edit select[name='pembayaran_kreditur']").val(response.ujroh_kreditur_carabayar);
            var producttt = response.program_code;
            $("#form_edit select[name='jenis_program']").val(producttt);
            var akadddd = response.akad_code;
            $("#form_edit select[name='akad']").val(akadddd);
            $("#form_edit select[name='jadwal_angsuran']").val(response.flag_jadwal_angsuran);
            $("#form_edit select[name='sektor_ekonomi']").val(response.sektor_ekonomi);
            $("#form_edit select[name='peruntukan_pembiayaan']").val(response.peruntukan);
            // $("#form_edit select[name='product']").val(response.product_code);
            $("#form_edit select[name='flag_wakalah']").val(response.flag_wakalah);

            var account_saving = response.account_saving_no
            if(account_saving==""){
                $("#saving2").hide();
            }else{
                $("#form_edit select[name='account_saving']").val(account_saving);
                $("#form_edit input[name='account_saving_hide']").val(account_saving);
                $("#saving2").show();
            }

            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_saldo_memo_tabungan",
               dataType: "json",
               async:false,
               data: {account_saving:$("#account_saving2","#form_edit").html()},
               success: function(response){
                  $("#saldo_memo_tabungan","#form_edit").val(response.saldo_memo);
               }
            });  
            
            var producttt = response.program_code;
            $("#form_edit select[name='jenis_program']").val(producttt);
            if(producttt !="")
            {
                $("#form_edit select[name='program_khusus']").val(0);
            }
            else
            {
                $("#form_edit select[name='program_khusus']").val(1);
            }

            var tanggal_pengajuan = response.tanggal_pengajuan;
            var tgl_pengajuan = tanggal_pengajuan.substring(8,10);
            var bln_pengajuan = tanggal_pengajuan.substring(5,7);
            var thn_pengajuan = tanggal_pengajuan.substring(0,4);
            var tgl_akhir_pengajuan = tgl_pengajuan+"/"+bln_pengajuan+"/"+thn_pengajuan;  
            $("#form_edit input[name='tgl_pengajuan']").val(tgl_akhir_pengajuan);
            // $("#form_edit input[name='tgl_pengajuan']").prop(tgl_akhir_pengajuan);
            
            var tanggal_registrasi = response.tanggal_registrasi;
            if(tanggal_registrasi==undefined)
            {
              tanggal_registrasi='';
            }
            var tgl_registrasi = tanggal_registrasi.substring(8,10);
            var bln_registrasi = tanggal_registrasi.substring(5,7);
            var thn_registrasi = tanggal_registrasi.substring(0,4);
            var tgl_akhir_registrasi = tgl_registrasi+"/"+bln_registrasi+"/"+thn_registrasi;  
            $("#form_edit input[name='tgl_registrasi']").val(tgl_akhir_registrasi);
            // $("#form_edit input[name='tgl_registrasi']").prop(tgl_akhir_registrasi);

            var tanggal_mulai_angsur = response.tanggal_mulai_angsur;
            var tgl_mulai_angsur = tanggal_mulai_angsur.substring(8,10);
            var bln_mulai_angsur = tanggal_mulai_angsur.substring(5,7);
            var thn_mulai_angsur = tanggal_mulai_angsur.substring(0,4);
            var tgl_akhir_angsur = tgl_mulai_angsur+"/"+bln_mulai_angsur+"/"+thn_mulai_angsur;
            $("#form_edit input[name='angsuranke1']").val(tgl_akhir_angsur);
            // $("#form_edit input[name='angsuranke1']").prop(tgl_akhir_angsur);

            var tanggal_akad = response.tanggal_akad;
            var tgl_akad = tanggal_akad.substring(8,10);
            var bln_akad = tanggal_akad.substring(5,7);
            var thn_akad = tanggal_akad.substring(0,4);
            var tgl_akhir_akad = tgl_akad+"/"+bln_akad+"/"+thn_akad;
            $("#form_edit input[name='tgl_akad']").val(tgl_akhir_akad);
            // $("#form_edit input[name='tgl_akad']").prop(tgl_akhir_akad);

            var tanggal_jtempo = response.tanggal_jtempo;
            var tgl_jtempo = tanggal_jtempo.substring(8,10);
            var bln_jtempo = tanggal_jtempo.substring(5,7);
            var thn_jtempo = tanggal_jtempo.substring(0,4);
            var tgl_akhir_jtempo = tgl_jtempo+"/"+bln_jtempo+"/"+thn_jtempo;
            $("#form_edit input[name='tgl_jtempo']").val(tgl_akhir_jtempo);
            // $("#form_edit input[name='tgl_jtempo']").prop(tgl_akhir_jtempo);


            //angsuran dan kewajiban koptel dan kopegtel
            $("#jumlah_kewajiban","#form_edit").val(number_format(response.jumlah_kewajiban,0,',','.'));
            $("#jumlah_angsuran","#form_edit").val(number_format(response.jumlah_angsuran,0,',','.'));

            if(response.lunasi_ke_kopegtel=="1"){
              $("#lunasi_ke_kopegtel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',true);
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban","#form_edit").val(number_format(response.saldo_kewajiban,0,',','.'));
              $("#saldo_kewajiban","#form_edit").prop(number_format(response.saldo_kewajiban,0,',','.'));
              $("#div_saldo_kewajiban","#form_edit").show();
              $("#span_txt_lunasi","#form_edit").show();
              $("#uniform-lunasi_ke_kopegtel","#form_edit").show();
              $("#pelunasan_ke_kopeg_mana","#form_edit").val(response.pelunasan_ke_kopeg_mana);
            }else{
              $("#lunasi_ke_kopegtel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_kopegtel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban","#form_edit").hide();
              $("#saldo_kewajiban","#form_edit").val('0').prop('0');
              $("#span_txt_lunasi","#form_edit").hide();
              $("#uniform-lunasi_ke_kopegtel","#form_edit").hide();
            }

            if(response.lunasi_ke_koptel=="1"){
              $("#lunasi_ke_koptel","#form_edit").parent().addClass('checked');
              $("#lunasi_ke_koptel","#form_edit").attr('checked',true);
              $("#lunasi_ke_koptel","#form_edit").prop('checked',true);
              $("#saldo_kewajiban_ke_koptel","#form_edit").val(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#saldo_kewajiban_ke_koptel","#form_edit").prop(number_format(response.saldo_kewajiban_ke_koptel,0,',','.'));
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").show();
              $("#span_txt_lunasi_ke_koptel","#form_edit").show();
              $("#uniform-lunasi_ke_koptel","#form_edit").show();
              
            }else{
              $("#lunasi_ke_koptel","#form_edit").parent().removeClass('checked'); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").attr('checked',false); //menghilangkan checklist
              $("#lunasi_ke_koptel","#form_edit").prop('checked',false); //menghilangkan checklist
              $("#div_saldo_kewajiban_ke_koptel","#form_edit").hide();
              $("#saldo_kewajiban_ke_koptel","#form_edit").val('0').prop('0');
              $("#span_txt_lunasi_ke_koptel","#form_edit").hide();
              $("#uniform-lunasi_ke_koptel","#form_edit").hide();
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
            //angsuran dan kewajiban koptel dan kopegtel

            
      /*var jenis_and_code_product = response.jenis_pembiayaan+''+response.product_code+''+response.insurance_product_code+''+response.flag_manfaat_asuransi;
      $("#form_edit select[name='product']").val(jenis_and_code_product);*/
      
       //fungsi untuk menyembunyikan input jadwal angsuran jika value=0
        var jadwal_angsuran = response.flag_jadwal_angsuran;   
        if(jadwal_angsuran=='0')
        {
            $("#non_reg2").hide();
            $("#reg2").hide();

            var account_financing_id  = $('#account_financing_id', "#form_edit").val();
              $.ajax({
                url: site_url+"rekening_nasabah/generate_angsuran_nonreguler",
                type: "POST",
                async:false,
                dataType: "html",
                data: {account_financing_id:account_financing_id},
                success: function(response)
                {
                  $("#span_angsuran_nonreguler","#form_edit").html(response);
                  // $("#flag_jadwal_angsuran","#form_edit").val('0');
                  // $("#jumlah_margin","#form_regis").val(response.jumlah_margin);
                },
                error: function(){
                  alert("terjadi kesalahan, harap hubungi IT Support");
                }
              })
        }
        else
        {
            $("#non_reg2").show();
            $("#reg2").hide();
        }

         //fungsi untuk menyembunyikan input nisbah bagi hasil
        var nisbah = response.nisbah_bagihasil;   
        if(nisbah==null)
        {
          $("#nisbah2").hide();
        }
        else
        {
          $("#nisbah2").show();
        }

        // cif flag = 1 //banmod
        cif_flag = response.cif_flag;
        if (cif_flag=='1') {
          jenis_keuntungan = response.jenis_keuntungan;
          if (jenis_keuntungan=='2') {
            $('#amount_proyeksi_keuntungan').val(number_format(response.amount_proyeksi_keuntungan,0,',','.'))
            $('#amount_proyeksi_keuntungan').closest('.control-group').show();
            $("#nisbah2").show();
            $('#margin_pembiayaan2').closest('.control-group').hide();
          } else {
            $('#amount_proyeksi_keuntungan').val(0);
            $('#amount_proyeksi_keuntungan').closest('.control-group').hide();
            $("#nisbah2").hide();
            $('#margin_pembiayaan2').closest('.control-group').show();

          }
        }

        //fungsi untuk menyembunyikan input Jenis Program
        var jenis_program = response.program_code;   


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
        var product = $("#product2").val();
          product_code = product.substring(1,5);
        var cif_no = $("#cif_no2").val();  
        //mendapatkan jumlah maksimal sesuai product_code yang dipilih
        $.ajax({
          url: site_url+"transaction/count_cif_by_product_code_financing",
          type: "POST",
          dataType: "json",
          data: {product_code:product_code},
          success: function(response)
          {
            var data = response.jumlah;
            if(data==null)
            {
              var total = 0;
            }
            else
            {
              var total = data;
            }
            var jumlah = parseFloat(total); 
            var no_urut = jumlah+1;
            //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
            $("#account_financing_no2").val(cif_no+''+product_code+''+no_urut);
          }
        })         
        
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
            if(data>2)
            {
              $("#nisbah2").show();
            }
            else
            {
              $("#nisbah2").hide();
            }
          }
        })         
        
          });

    });
    


      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

          form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              cif_no: {
                  required: true
              },
          },


          submitHandler: function (form) {

            var flag_wakalah = $("#flag_wakalah").val();
            var biaya_administrasi = $("#biaya_administrasi").val();
            var saldo_memo_tabungan = $("#saldo_memo_tabungan").val();
            var cif_no = $("input[name='cif_no']",form2).val()

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              dataType: "json",
              async:false,
              data: {cif_no:cif_no},
              url: site_url+"transaction/ajax_pembiayaan_active_is_exists",
              success: function(response)
              {
                $("#pembiayaan_active_is_exists","#form_edit").val(response.result);
              }                 
            });

            var pembiayaan_active_is_exists = $("#pembiayaan_active_is_exists",form2).val();
            // if(pembiayaan_active_is_exists=='1'){
              // alert("Tidak dapat melakukan pencairan (Terdapat pembiayaan aktif yang belum dilunasi)");
            // }else if(flag_wakalah==0){
            if(flag_wakalah==0){
              if(biaya_administrasi<saldo_memo_tabungan){
                alert("Saldo memo tidak mencukupi");
              }else{
                $.ajax({
                  type: "POST",
                  url: site_url+"rekening_nasabah/proses_pencairan_rekening_pembiayaan",
                  dataType: "json",
                  data: form2.serialize(),
                  success: function(response){
                    if(response.success==true){
                      success2.show();
                      error2.hide();
                      form2.trigger('reset');
                      form2.find('.control-group').removeClass('success');
                      $("#cancel",form_edit).trigger('click')
                      alert('Success');
                    }else{
                      success2.hide();
                      error2.show();
                    }
                    App.scrollTo(form2, -200);
                  },
                  error:function(){
                      success2.hide();
                      error2.show();
                  }
                });
              }
            }else{
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/proses_pencairan_rekening_pembiayaan",
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    success2.show();
                    error2.hide();
                    form2.trigger('reset');
                    form2.find('.control-group').removeClass('success');
                    $("#cancel",form_edit).trigger('click')
                    alert('Success');
                  }else{
                    success2.hide();
                    error2.show();
                  }
                  App.scrollTo(form2, -200);
                },
                error:function(){
                    success2.hide();
                    error2.show();
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


      $("#btn_reject").click(function(){

        var account_financing_id = $("#account_financing_id").val();
        var account_financing_no = $("#account_financing_no2").val();
        var registration_no2 = $("#registration_no2").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/reject_pencairan_pembiayaan",
              type: "POST",
              dataType: "json",
              data: {registration_no2:registration_no2,account_financing_id:account_financing_id,account_financing_no:account_financing_no},
              success: function(response){
                if(response.success==true){
                  alert("Reject!");
                  dTreload();
                  $("#edit").hide();
                  $("#wrapper-table").show();
                }else{
                  alert("Reject Failed!");
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
         "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "src_product", "value": $("#src_product").val() } );
          },
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pencairan_pembiayaan",
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
      // $(".dataTables_length,.dataTables_filter").parent().hide();

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown



      function get_date_form_edit_by_akad()
      {
        var tgl_akad = $("#tgl_akad","#form_edit").val();
        var jangka_waktu = $("#jangka_waktu2","#form_edit").val();
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
        var jangka_waktu = $("#jangka_waktu2","#form_edit").val();
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

      // kelengkapan dokumen
      $("#link-flag-dokumen").live('click',function()
      {
          var account_financing_id = $(this).attr('account_financing_id');
          var conf = confirm('Dokumen Sudah Diterima ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_dokumen_diterima", //update flag_dokumen=1
              dataType: "json",
              data: {account_financing_id:account_financing_id},
              success: function(response){
                if(response.success==true){
                  // alert("Berhasil Ditolak!");
                  dTreload();
                  // App.scrollTo($("#wrapper-table"),-100);
                }else{
                  alert("Gagal Eksekusi!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });

</script>
<!-- END JAVASCRIPTS -->

