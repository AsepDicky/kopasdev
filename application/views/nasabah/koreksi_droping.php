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
			Koreksi Droping
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			   <li><a href="#">Koreksi Droping</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_src_account_financing_no" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari CIF</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p style="display:none"><select name="cif_type" id="cif_type" class="span12 m-wrap">
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

<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Koreksi Droping</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_act" class="form-horizontal">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Droping telah dikoreksi!
            </div>
            <br>
            <input type="hidden" id="jml_angsuran" name="jml_angsuran">
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <a id="browse_account_financing_no" class="btn blue" data-toggle="modal" href="#dialog_src_account_financing_no">...</a>
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Produk</label>
               <div class="controls">
                  <input name="product_name" id="product_name" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <hr size="1">
            <table width="100%" cellpadding="10" style="border:solid 1px #CCC;margin-bottom:10px;">
              <tr>
                <td width="50%" valign="top">
                  <fieldset>
                    <legend style="margin-bottom:0 !important;">Data Droping Sebelumnya</legend>
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                        <input type="hidden" id="fa_code_o" name="fa_code_o">
                        <select id="facodeo" class="m-warp large" disabled="disabled" style="background:#EEE;">
                          <option value="">Silahkan Pilih</option>
                          <?php foreach($petugas as $fa): ?>
                          <option value="<?php echo $fa['fa_code'] ?>"><?php echo $fa['fa_name']; ?></option>
                          <?php endforeach; ?>
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Resort</label>
                       <div class="controls">
                        <input type="hidden" id="resort_code_o" name="resort_code_o">
                        <select id="resortcodeo" class="m-warp large" disabled="disabled" style="background:#EEE;">
                          <option value="">Silahkan Pilih</option>
                          <?php foreach($resorts as $resort): ?>
                          <option value="<?php echo $resort['resort_code'] ?>"><?php echo $resort['resort_name']; ?></option>
                          <?php endforeach; ?>
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Uang Muka</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="uangmuka" id="uangmuka" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nominal Pembiayaan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="pokok" id="pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Titipan Notaris</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="titipannotaris" id="titipannotaris" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu</label>
                       <div class="controls">
                          <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:30px;"/>
                          <select id="periode_jangka_waktu" name="periode_jangka_waktu" class="m-wrap small" readonly="readonly" style="background-color:#eee;">
                            <option value="">PILIH</option>
                            <option value="0">Harian</option>
                            <option value="1">Mingguan</option>
                            <option value="2">Bulanan</option>
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Droping/Akad</label>
                       <div class="controls">
                          <input name="tanggal_droping" id="tanggal_droping" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Angsuran Ke-1</label>
                       <div class="controls">
                          <input name="tanggal_mulai_angsur" id="tanggal_mulai_angsur" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Jatuh Tempo</label>
                       <div class="controls">
                          <input name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_pokok" id="angsuran_pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_margin" id="angsuran_margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsurancatab" id="angsurancatab" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="totalangsuran" id="totalangsuran" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Simpanan Wajib Pinjam</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="simpananwajibpinjam" id="simpananwajibpinjam" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayaadministrasi" id="biayaadministrasi" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Jasa Layanan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayajasalayanan" id="biayajasalayanan" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Biaya ADM</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="totalbiayaadm" id="totalbiayaadm" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayanotaris" id="biayanotaris" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="premiasuransijiwa" id="premiasuransijiwa" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="premiasuransijaminan" id="premiasuransijaminan" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <hr size="1">
                    <h5>:: Jaminan Primer</h5>   
                    <div class="control-group">
                       <label class="control-label">Jaminan <span class="required">*</span></label>
                       <div class="controls">
                          <select id="jaminanprimer" name="jaminanprimer" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">
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
                          <textarea class="medium m-wrap" name="ketjaminanprimer" id="ketjaminanprimer" readonly="readonly" style="background-color:#eee;"></textarea>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Jumlah Jaminan<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="jmljaminanprimer" id="jmljaminanprimer" maxlength="2" readonly="readonly" style="width:50px;background-color:#eee;">
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Taksasi <span class="required">*</span></label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" name="nominaljaminanprimer" id="nominaljaminanprimer" value="0" readonly="readonly" style="width:120px;background-color:#eee;">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Presentase Jaminan<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="presentasejaminanprimer" id="presentasejaminanprimer" maxlength="3" readonly="readonly" style="width:50px;background-color:#eee;">%
                        </div>
                    </div> 
                    <h5>:: Jaminan Sekunder</h5>
                    <div class="control-group">
                       <label class="control-label">Jaminan </label>
                       <div class="controls">
                          <select id="jaminansekunder" name="jaminansekunder" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">                     
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
                          <textarea class="medium m-wrap" name="ketjaminansekunder" id="ketjaminansekunder" readonly="readonly" style="background-color:#eee;"></textarea>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Jumlah Jaminan</label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="jmljaminansekunder" id="jmljaminansekunder" maxlength="3" readonly="readonly" style="width:50px;background-color:#eee;">
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Taksasi </label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" name="nominaljaminansekunder" id="nominaljaminansekunder" value="0" readonly="readonly" style="width:120px;background-color:#eee;">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Presentase Jaminan</label>
                       <div class="controls">
                           <input type="text" class="m-wrap" name="presentasejaminansekunder" id="presentasejaminansekunder" maxlength="3" readonly="readonly" style="width:50px;background-color:#eee;">%
                        </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektorekonomi" name="sektorekonomi" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan</label>
                       <div class="controls">
                        <select id="peruntukanpembiayaan" name="peruntukanpembiayaan" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label"></label>
                       <div class="controls">
                          <input name="desc_peruntukan" id="desc_peruntukan" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah ?</label>
                       <div class="controls">
                        <select id="flagwakalah" name="flagwakalah" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">                     
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                       </div>
                    </div> 
                  </fieldset>
                </td>
                <td width="50%" valign="top"> <!--  EDIT  -->
                  <fieldset>
                    <legend style="margin-bottom:0 !important;">Data Droping yang akan Diubah</legend>
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                        <select name="fa_code_n" id="fa_code_n" class="m-warp large chosen">
                          <option value="">Silahkan Pilih</option>
                          <?php foreach($petugas as $fa): ?>
                          <option value="<?php echo $fa['fa_code'] ?>"><?php echo $fa['fa_name']; ?></option>
                          <?php endforeach; ?>
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Resort</label>
                       <div class="controls">
                        <select name="resort_code_n" id="resort_code_n" class="m-warp large chosen">
                          <option value="">Silahkan Pilih</option>
                          <?php foreach($resorts as $resort): ?>
                          <option value="<?php echo $resort['resort_code'] ?>"><?php echo $resort['resort_name']; ?></option>
                          <?php endforeach; ?>
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Uang Muka</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="uangmuka2" id="uangmuka2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nominal Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="pokok2" id="pokok2" data-required="1" type="text" class="small m-wrap mask-money" />
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Titipan Notaris</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="titipannotaris2" id="titipannotaris2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Margin<span class="required">*</span></label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="margin2" id="margin2" data-required="1" type="text" class="small m-wrap mask-money" />
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input name="jangka_waktu2" id="jangka_waktu2" data-required="1" type="text" class="m-wrap mask-money" style="width:30px;" />
                          <select id="periode_jangka_waktu2" name="periode_jangka_waktu2" class="m-wrap small">
                            <option value="">PILIH</option>
                            <option value="0">Harian</option>
                            <option value="1">Mingguan</option>
                            <option value="2">Bulanan</option>
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Droping/Akad<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_droping2" id="tanggal_droping2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy" />
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_mulai_angsur2" id="tanggal_mulai_angsur2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy" />
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_jtempo2" id="tanggal_jtempo2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy" />
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_pokok2" id="angsuran_pokok2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_margin2" id="angsuran_margin2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsurancatab2" id="angsurancatab2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="totalangsuran2" id="totalangsuran2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Simpanan Wajib Pinjam</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="simpananwajibpinjam2" id="simpananwajibpinjam2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayaadministrasi2" id="biayaadministrasi2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Jasa Layanan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayajasalayanan2" id="biayajasalayanan2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Total Biaya ADM</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="totalbiayaadm2" id="totalbiayaadm2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="biayanotaris2" id="biayanotaris2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="premiasuransijiwa2" id="premiasuransijiwa2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="premiasuransijaminan2" id="premiasuransijaminan2" data-required="1" type="text" class="small m-wrap mask-money"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <hr size="1">
                    <h5>:: Jaminan Primer</h5>   
                    <div class="control-group">
                       <label class="control-label">Jaminan <span class="required">*</span></label>
                       <div class="controls">
                          <select id="jaminanprimer2" name="jaminanprimer2" class="medium m-wrap">                     
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
                          <textarea class="medium m-wrap" name="ketjaminanprimer2" id="ketjaminanprimer2"></textarea>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Jumlah Jaminan<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="jmljaminanprimer2" id="jmljaminanprimer2" maxlength="2">
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Taksasi <span class="required">*</span></label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominaljaminanprimer2" id="nominaljaminanprimer2" value="0">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Presentase Jaminan<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="presentasejaminanprimer2" id="presentasejaminanprimer2" maxlength="3">%
                        </div>
                    </div> 
                    <h5>:: Jaminan Sekunder</h5>
                    <div class="control-group">
                       <label class="control-label">Jaminan </label>
                       <div class="controls">
                          <select id="jaminansekunder2" name="jaminansekunder2" class="medium m-wrap">                     
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
                          <textarea class="medium m-wrap" name="ketjaminansekunder2" id="ketjaminansekunder2"></textarea>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Jumlah Jaminan</label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="jmljaminansekunder2" id="jmljaminansekunder2" maxlength="3">
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Taksasi </label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominaljaminansekunder2" id="nominaljaminansekunder2" value="0">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Presentase Jaminan</label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="presentasejaminansekunder2" id="presentasejaminansekunder2" maxlength="3">%
                        </div>
                    </div>
                    <hr size="1"> 
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektorekonomi2" name="sektorekonomi2" class="medium m-wrap">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan</label>
                       <div class="controls">
                        <select id="peruntukanpembiayaan2" name="peruntukanpembiayaan2" class="medium m-wrap">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label"></label>
                       <div class="controls">
                          <input type="hidden" name="registration_no" id="registration_no">
                          <input name="desc_peruntukan2" id="desc_peruntukan2" data-required="1" type="text" class="medium m-wrap" maxlength="100" />
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah ?</label>
                       <div class="controls">
                        <select id="flagwakalah2" name="flagwakalah2" class="medium m-wrap">                     
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                       </div>
                    </div> 
                  </fieldset>
                </td>
              </tr>
            </table>
            <div class="form-actions">
               <button type="button" class="btn green" id="koreksi" style="float:right;">Proses Koreksi Droping</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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
    
      $(".date-mask").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
  
  $("#browse_account_financing_no").click(function(e){
    e.preventDefault();
    setTimeout(function(){
      $("#keyword","#dialog_src_account_financing_no").focus();
    },600)
  });

  $("#keyword","#dialog_src_account_financing_no").keypress(function(e){
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
        type:"POST",
        dataType:"json",
        data:{keyword:$(this).val(),status_rekening:1},
        url:site_url+"/rekening_nasabah/search_account_financing_no",
        success:function(response){
          var opt = '';
          for(i=0;i<response.length;i++){
            opt += '<option value="'+response[i].account_financing_no+'" is_avaible_to_correct="'+response[i].is_avaible_to_correct+'" nama="'+response[i].nama+'" tanggal_akad="'+response[i].tanggal_akad+'" tanggal_mulai_angsur="'+response[i].tanggal_mulai_angsur+'" tanggal_jtempo="'+response[i].tanggal_jtempo+'" pokok="'+response[i].pokok+'" margin="'+response[i].margin+'" jangka_waktu="'+response[i].jangka_waktu+'" periode_jangka_waktu="'+response[i].periode_jangka_waktu+'" angsuran_pokok="'+response[i].angsuran_pokok+'" angsuran_margin="'+response[i].angsuran_margin+'" uang_muka="'+response[i].uang_muka+'" titipan_notaris="'+response[i].titipan_notaris+'" angsuran_catab="'+response[i].angsuran_catab+'" simpanan_wajib_pinjam="'+response[i].simpanan_wajib_pinjam+'" biaya_administrasi="'+response[i].biaya_administrasi+'" biaya_jasa_layanan="'+response[i].biaya_jasa_layanan+'" biaya_notaris="'+response[i].biaya_notaris+'" biaya_asuransi_jiwa="'+response[i].biaya_asuransi_jiwa+'" biaya_asuransi_jaminan="'+response[i].biaya_asuransi_jaminan+'" jenis_jaminan="'+response[i].jenis_jaminan+'" keterangan_jaminan="'+response[i].keterangan_jaminan+'" jumlah_jaminan="'+response[i].jumlah_jaminan+'" nominal_taksasi="'+response[i].nominal_taksasi+'" presentase_jaminan="'+response[i].presentase_jaminan+'" jenis_jaminan_sekunder="'+response[i].jenis_jaminan_sekunder+'" keterangan_jaminan_sekunder="'+response[i].keterangan_jaminan_sekunder+'" jumlah_jaminan_sekunder="'+response[i].jumlah_jaminan_sekunder+'" nominal_taksasi_sekunder="'+response[i].nominal_taksasi_sekunder+'" presentase_jaminan_sekunder="'+response[i].presentase_jaminan_sekunder+'" sektor_ekonomi="'+response[i].sektor_ekonomi+'" peruntukan="'+response[i].peruntukan+'" flag_wakalah="'+response[i].flag_wakalah+'" product_name="'+response[i].product_name+'" fa_code="'+response[i].fa_code+'" resort_code="'+response[i].resort_code+'" registration_no="'+response[i].registration_no+'" desc_peruntukan="'+response[i].description+'">'+response[i].account_financing_no+' - '+response[i].nama+'</option>';
          }
          $("#result","#dialog_src_account_financing_no").html(opt);
        },
        error:function(){
          alert("Something wrong when searching account. Please contact administrator!");
        }
      });
    }
  });

  $("#result","#dialog_src_account_financing_no").dblclick(function(e){
    if($(this).val()!=""){
      $("#select","#dialog_src_account_financing_no").trigger('click');
    }
  })

  $("#select","#dialog_src_account_financing_no").click(function(e){
    e.preventDefault();
    $("#close","#dialog_src_account_financing_no").trigger('click');
    res = $("#result","#dialog_src_account_financing_no");
    opt_res = res.find('option:selected');
    account_financing_no=res.val();
    nama=opt_res.attr('nama');
    tanggal_akad=opt_res.attr('tanggal_akad');
    tanggal_mulai_angsur=opt_res.attr('tanggal_mulai_angsur');
    tanggal_jtempo=opt_res.attr('tanggal_jtempo');
    pokok=opt_res.attr('pokok');
    margin=opt_res.attr('margin');
    jangka_waktu=opt_res.attr('jangka_waktu');
    periode_jangka_waktu=opt_res.attr('periode_jangka_waktu');
    angsuran_pokok=opt_res.attr('angsuran_pokok');
    angsuran_margin=opt_res.attr('angsuran_margin');
    product_name=opt_res.attr('product_name');
    //------------------------------- new
    uang_muka=opt_res.attr('uang_muka');
    titipan_notaris=opt_res.attr('titipan_notaris');
    angsuran_catab=opt_res.attr('angsuran_catab');
    simpanan_wajib_pinjam=opt_res.attr('simpanan_wajib_pinjam');
    biaya_administrasi=opt_res.attr('biaya_administrasi');
    biaya_jasa_layanan=opt_res.attr('biaya_jasa_layanan');
    biaya_notaris=opt_res.attr('biaya_notaris');
    biaya_asuransi_jiwa=opt_res.attr('biaya_asuransi_jiwa');
    biaya_asuransi_jaminan=opt_res.attr('biaya_asuransi_jaminan');
    jenis_jaminan=opt_res.attr('jenis_jaminan');
    keterangan_jaminan=opt_res.attr('keterangan_jaminan');
    jumlah_jaminan=opt_res.attr('jumlah_jaminan');
    nominal_taksasi=opt_res.attr('nominal_taksasi');
    presentase_jaminan=opt_res.attr('presentase_jaminan');
    jenis_jaminan_sekunder=opt_res.attr('jenis_jaminan_sekunder');
    keterangan_jaminan_sekunder=opt_res.attr('keterangan_jaminan_sekunder');
    jumlah_jaminan_sekunder=opt_res.attr('jumlah_jaminan_sekunder');
    nominal_taksasi_sekunder=opt_res.attr('nominal_taksasi_sekunder');
    presentase_jaminan_sekunder=opt_res.attr('presentase_jaminan_sekunder');
    sektor_ekonomi=opt_res.attr('sektor_ekonomi');
    peruntukan=opt_res.attr('peruntukan');
    flag_wakalah=opt_res.attr('flag_wakalah');
    fa_code=opt_res.attr('fa_code');
    resort_code=opt_res.attr('resort_code');
    registration_no=opt_res.attr('registration_no');
    desc_peruntukan=opt_res.attr('desc_peruntukan');

    /*convert_tanggal_akad*/
    ta=tanggal_akad.split('-');
    tanggal_akad=ta[2]+'/'+ta[1]+'/'+ta[0];
    /*convert_tanggal_mulai_angsur*/
    ta=tanggal_mulai_angsur.split('-');
    tanggal_mulai_angsur=ta[2]+'/'+ta[1]+'/'+ta[0];
    /*convert_tanggal_jtempo*/
    ta=tanggal_jtempo.split('-');
    tanggal_jtempo=ta[2]+'/'+ta[1]+'/'+ta[0];

    $("#account_financing_no").val(account_financing_no);
    $("#nama").val(nama);
    $("#tanggal_droping,#tanggal_droping2").val(tanggal_akad);
    $("#tanggal_mulai_angsur,#tanggal_mulai_angsur2").val(tanggal_mulai_angsur);
    $("#tanggal_jtempo,#tanggal_jtempo2").val(tanggal_jtempo);
    $("#pokok,#pokok2").val(number_format(pokok,0,',','.'));
    $("#margin,#margin2").val(number_format(margin,0,',','.'));
    $("#jangka_waktu,#jangka_waktu2").val(jangka_waktu);
    $("#periode_jangka_waktu,#periode_jangka_waktu2").val(periode_jangka_waktu);
    $("#angsuran_pokok,#angsuran_pokok2").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin,#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
    $("#product_name").val(product_name);
    //------------------------------- new
    $("#uangmuka,#uangmuka2").val(number_format(uang_muka,0,',','.'));
    $("#titipannotaris,#titipannotaris2").val(number_format(titipan_notaris,0,',','.'));
    $("#angsurancatab,#angsurancatab2").val(number_format(angsuran_catab,0,',','.'));
    $("#simpananwajibpinjam,#simpananwajibpinjam2").val(number_format(simpanan_wajib_pinjam,0,',','.'));
    $("#biayaadministrasi,#biayaadministrasi2").val(number_format(biaya_administrasi,0,',','.'));
    $("#biayajasalayanan,#biayajasalayanan2").val(number_format(biaya_jasa_layanan,0,',','.'));
    $("#biayanotaris,#biayanotaris2").val(number_format(biaya_notaris,0,',','.'));
    $("#premiasuransijiwa,#premiasuransijiwa2").val(number_format(biaya_asuransi_jiwa,0,',','.'));
    $("#premiasuransijaminan,#premiasuransijaminan2").val(number_format(biaya_asuransi_jaminan,0,',','.'));
    $("#jaminanprimer,#jaminanprimer2").val(jenis_jaminan);
    $("#ketjaminanprimer,#ketjaminanprimer2").val((keterangan_jaminan=="null")?'':keterangan_jaminan);
    $("#jmljaminanprimer,#jmljaminanprimer2").val((jumlah_jaminan=="null")?'':jumlah_jaminan);
    $("#nominaljaminanprimer,#nominaljaminanprimer2").val(number_format(nominal_taksasi,0,',','.'));
    $("#presentasejaminanprimer,#presentasejaminanprimer2").val((presentase_jaminan=="null")?'':presentase_jaminan);
    $("#jaminansekunder,#jaminansekunder2").val(jenis_jaminan_sekunder);
    $("#ketjaminansekunder,#ketjaminansekunder2").val((keterangan_jaminan_sekunder=="null")?'':keterangan_jaminan_sekunder);
    $("#jmljaminansekunder,#jmljaminansekunder2").val((jumlah_jaminan_sekunder=="null")?'':jumlah_jaminan_sekunder);
    $("#nominaljaminansekunder,#nominaljaminansekunder2").val(number_format(nominal_taksasi_sekunder,0,',','.'));
    $("#presentasejaminansekunder,#presentasejaminansekunder2").val((presentase_jaminan_sekunder=="null")?'':presentase_jaminan_sekunder);
    $("#sektorekonomi,#sektorekonomi2").val(sektor_ekonomi);
    $("#peruntukanpembiayaan,#peruntukanpembiayaan2").val(peruntukan);
    $("#flagwakalah,#flagwakalah2").val(flag_wakalah);
    $("#fa_code_o,#facodeo,#fa_code_n").val(fa_code).trigger('liszt:updated');
    $("#resort_code_o,#resortcodeo,#resort_code_n").val(resort_code).trigger('liszt:updated');
    $("#registration_no").val(registration_no);
    $("#desc_peruntukan,#desc_peruntukan2").val(desc_peruntukan);

    /*calculate total angsuran*/
    totalangsuran=parseFloat(angsuran_pokok)+parseFloat(angsuran_margin)+parseFloat(angsuran_catab);
    $("#totalangsuran,#totalangsuran2").val(number_format(totalangsuran,0,',','.'));
    /*calculate total biaya adm*/
    totalbiayaadm=parseFloat(simpanan_wajib_pinjam)+parseFloat(biaya_jasa_layanan)+parseFloat(biaya_administrasi);
    $("#totalbiayaadm,#totalbiayaadm2").val(number_format(totalbiayaadm,0,',','.'));
    
  });

  $("#angsurancatab2").keyup(function(){
    var angsuranpokok=(isNaN(parseFloat(convert_numeric($("#angsuran_pokok2").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_pokok2").val()));
    var angsuranmargin=(isNaN(parseFloat(convert_numeric($("#angsuran_margin2").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_margin2").val()));
    var angsurancatab=(isNaN(parseFloat(convert_numeric($("#angsurancatab2").val())))==true)?0:parseFloat(convert_numeric($("#angsurancatab2").val()));
    totalangsuran=angsuranpokok+angsuranmargin+angsurancatab;
    $("#totalangsuran2").val(number_format(totalangsuran,0,',','.'));
  })
  $("#simpananwajibpinjam2,#biayaadministrasi2,#biayajasalayanan2").keyup(function(){
    var simpananwajibpinjam=(isNaN(parseFloat(convert_numeric($("#simpananwajibpinjam2").val())))==true)?0:parseFloat(convert_numeric($("#simpananwajibpinjam2").val()));
    var biayaadministrasi=(isNaN(parseFloat(convert_numeric($("#biayaadministrasi2").val())))==true)?0:parseFloat(convert_numeric($("#biayaadministrasi2").val()));
    var biayajasalayanan=(isNaN(parseFloat(convert_numeric($("#biayajasalayanan2").val())))==true)?0:parseFloat(convert_numeric($("#biayajasalayanan2").val()));
    totalbiayaadm=simpananwajibpinjam+biayaadministrasi+biayajasalayanan;
    $("#totalbiayaadm2").val(number_format(totalbiayaadm,0,',','.'));
  })

  $("#pokok2,#margin2").change(function(){
    $("#jangka_waktu2").trigger('change');
  })

  $("#periode_jangka_waktu2").change(function(){
    $("#jangka_waktu2").trigger('change');
  })

  $("#jangka_waktu2").change(function(){
    $("#tanggal_droping2").trigger('change');
    jangka_waktu=$(this).val();
    pokok=convert_numeric($("#pokok2").val());
    margin=convert_numeric($("#margin2").val());
    angsuran_pokok=parseFloat(pokok)/parseFloat(jangka_waktu);
    angsuran_margin=parseFloat(margin)/parseFloat(jangka_waktu);
    $("#angsuran_pokok2").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
    /*calculate total angsuran*/
    var e = $.Event('keyup');
    $('#angsurancatab2').trigger(e);
  });
  
  $("#tanggal_droping2").change(function(e){
    tanggal_droping=$(this).val().replace(/\_/g,'');
    periode_jangka_waktu=$("#periode_jangka_waktu2").val();
    if(tanggal_droping.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tanggal_droping:tanggal_droping,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_mulai_angsur",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0]; 
          }
          $("#tanggal_mulai_angsur2").val(response.tanggal_mulai_angsur);
          $("#tanggal_mulai_angsur2").trigger('change');
        }
      })
    }
  });
  
  $("#tanggal_mulai_angsur2").change(function(e){
    tanggal_droping=$("#tanggal_droping2").val().replace(/\_/g,'');
    jangka_waktu=$("#jangka_waktu2").val();
    periode_jangka_waktu=$("#periode_jangka_waktu2").val();
    if(tanggal_droping.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tanggal_droping:tanggal_droping,
          jangka_waktu:jangka_waktu,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_jatuh_tempo",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("#tanggal_jtempo2").val(response.tanggal_jtempo);
        }
      })
    }
  });

  /*UP UNTUK FUNGSI ADD ENTER*/
  $("input,select").live('keypress',function(e){

    if(e.keyCode==13)
    {
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT')
      {
        $(this).next().focus();
      }
      else
      {

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

  /* FORM ACTION */
  form=$("#form_act");
  $("#koreksi").click(function(e){
    e.preventDefault();
    account_financing_no = $("#account_financing_no");
    old_pokok = $("#pokok");
    old_margin = $("#margin");
    old_jangka_waktu = $("#jangka_waktu");
    old_tanggal_droping = $("#tanggal_droping");
    old_tanggal_mulai_angsur = $("#tanggal_mulai_angsur");
    old_tanggal_jtempo = $("#tanggal_jtempo");
    old_angsuran_pokok = $("#angsuran_pokok");
    old_angsuran_margin = $("#angsuran_margin");
    // ---------------------------- new
    old_uang_muka = $("#uangmuka");
    old_titipan_notaris = $("#titipannotaris");
    old_periode_jangka_waktu = $("#periode_jangka_waktu");
    old_angsuran_catab = $("#angsurancatab");
    old_simpanan_wajib_pinjam = $("#simpananwajibpinjam");
    old_biaya_administrasi = $("#biayaadministrasi");
    old_biaya_jasa_layanan = $("#biayajasalayanan");
    old_biaya_notaris = $("#biayanotaris");
    old_biaya_asuransi_jiwa = $("#premiasuransijiwa");
    old_biaya_asuransi_jaminan = $("#premiasuransijaminan");
    old_jenis_jaminan = $("#jaminanprimer");
    old_keterangan_jaminan = $("#ketjaminanprimer");
    old_jumlah_jaminan = $("#jmljaminanprimer");
    old_nominal_taksasi = $("#nominaljaminanprimer");
    old_presentasi_jaminan = $("#presentasejaminanprimer");
    old_jenis_jaminan_sekunder = $("#jaminansekunder");
    old_keterangan_jaminan_sekunder = $("#ketjaminansekunder");
    old_jumlah_jaminan_sekunder = $("#jmljaminansekunder");
    old_nominal_taksasi_sekunder = $("#nominaljaminansekunder");
    old_presentasi_jaminan_sekunder = $("#presentasejaminansekunder");
    old_sektor_ekonomi = $("#sektorekonomi");
    old_peruntukan = $("#peruntukanpembiayaan");
    old_flag_wakalah = $("#flagwakalah");
    old_fa_code = $("#fa_code_o");
    old_resort_code = $("#resort_code_o");
    old_desc_peruntukan = $("#desc_peruntukan");


    pokok = $("#pokok2");
    margin = $("#margin2");
    jangka_waktu = $("#jangka_waktu2");
    tanggal_droping = $("#tanggal_droping2");
    tanggal_mulai_angsur = $("#tanggal_mulai_angsur2");
    tanggal_jtempo = $("#tanggal_jtempo2");
    angsuran_pokok = $("#angsuran_pokok2");
    angsuran_margin = $("#angsuran_margin2");
    // ---------------------------- new
    uang_muka = $("#uangmuka2");
    titipan_notaris = $("#titipannotaris2");
    periode_jangka_waktu = $("#periode_jangka_waktu2");
    angsuran_catab = $("#angsurancatab2");
    simpanan_wajib_pinjam = $("#simpananwajibpinjam2");
    biaya_administrasi = $("#biayaadministrasi2");
    biaya_jasa_layanan = $("#biayajasalayanan2");
    biaya_notaris = $("#biayanotaris2");
    biaya_asuransi_jiwa = $("#premiasuransijiwa2");
    biaya_asuransi_jaminan = $("#premiasuransijaminan2");
    jenis_jaminan = $("#jaminanprimer2");
    keterangan_jaminan = $("#ketjaminanprimer2");
    jumlah_jaminan = $("#jmljaminanprimer2");
    nominal_taksasi = $("#nominaljaminanprimer2");
    presentasi_jaminan = $("#presentasejaminanprimer2");
    jenis_jaminan_sekunder = $("#jaminansekunder2");
    keterangan_jaminan_sekunder = $("#ketjaminansekunder2");
    jumlah_jaminan_sekunder = $("#jmljaminansekunder2");
    nominal_taksasi_sekunder = $("#nominaljaminansekunder2");
    presentasi_jaminan_sekunder = $("#presentasejaminansekunder2");
    sektor_ekonomi = $("#sektorekonomi2");
    peruntukan = $("#peruntukanpembiayaan2");
    flag_wakalah = $("#flagwakalah2");
    fa_code = $("#fa_code_n");
    resort_code = $("#resort_code_n");
    registration_no = $("#registration_no");
    desc_peruntukan = $("#desc_peruntukan");

    bValid=true;

    if(account_financing_no.val()==""){
      alert("Mohon pilih No.Pembiayaan terlebih dahulu!")
      bValid=false;
    }else{

      if(fa_code.val()=="") { fa_code.addClass('error'); bValid=false; } else { fa_code.removeClass('error'); }
      // if(resort_code.val()=="") { resort_code.addClass('error'); bValid=false; } else { resort_code.removeClass('error'); }
      if(pokok.val()=="") { pokok.addClass('error'); bValid=false; } else { pokok.removeClass('error'); }
      if(margin.val()=="") { margin.addClass('error'); bValid=false; } else { margin.removeClass('error'); }
      if(jangka_waktu.val()=="") { jangka_waktu.addClass('error'); bValid=false; } else { jangka_waktu.removeClass('error'); }
      if(tanggal_droping.val().replace(/\_/g,'')=="") { tanggal_droping.addClass('error'); bValid=false; } else { tanggal_droping.removeClass('error'); }
      if(tanggal_mulai_angsur.val().replace(/\_/g,'')=="") { tanggal_mulai_angsur.addClass('error'); bValid=false; } else { tanggal_mulai_angsur.removeClass('error'); }
      if(tanggal_jtempo.val().replace(/\_/g,'')=="") { tanggal_jtempo.addClass('error'); bValid=false; } else { tanggal_jtempo.removeClass('error'); }
      if(angsuran_pokok.val()=="") { angsuran_pokok.addClass('error'); bValid=false; } else { angsuran_pokok.removeClass('error'); }
      if(angsuran_margin.val()=="") { angsuran_margin.addClass('error'); bValid=false; } else { angsuran_margin.removeClass('error'); }
      if(uang_muka.val()=="") { uang_muka.addClass('error'); bValid=false; } else { uang_muka.removeClass('error'); }
      if(titipan_notaris.val()=="") { titipan_notaris.addClass('error'); bValid=false; } else { titipan_notaris.removeClass('error'); }
      if(periode_jangka_waktu.val()=="") { periode_jangka_waktu.addClass('error'); bValid=false; } else { periode_jangka_waktu.removeClass('error'); }
      if(angsuran_catab.val()=="") { angsuran_catab.addClass('error'); bValid=false; } else { angsuran_catab.removeClass('error'); }
      if(simpanan_wajib_pinjam.val()=="") { simpanan_wajib_pinjam.addClass('error'); bValid=false; } else { simpanan_wajib_pinjam.removeClass('error'); }
      if(biaya_administrasi.val()=="") { biaya_administrasi.addClass('error'); bValid=false; } else { biaya_administrasi.removeClass('error'); }
      if(biaya_jasa_layanan.val()=="") { biaya_jasa_layanan.addClass('error'); bValid=false; } else { biaya_jasa_layanan.removeClass('error'); }
      if(biaya_notaris.val()=="") { biaya_notaris.addClass('error'); bValid=false; } else { biaya_notaris.removeClass('error'); }
      if(biaya_asuransi_jiwa.val()=="") { biaya_asuransi_jiwa.addClass('error'); bValid=false; } else { biaya_asuransi_jiwa.removeClass('error'); }
      if(biaya_asuransi_jaminan.val()=="") { biaya_asuransi_jaminan.addClass('error'); bValid=false; } else { biaya_asuransi_jaminan.removeClass('error'); }
      if(sektor_ekonomi.val()=="") { sektor_ekonomi.addClass('error'); bValid=false; } else { sektor_ekonomi.removeClass('error'); }
      if(peruntukan.val()=="") { peruntukan.addClass('error'); bValid=false; } else { peruntukan.removeClass('error'); }
      if(flag_wakalah.val()=="") { flag_wakalah.addClass('error'); bValid=false; } else { flag_wakalah.removeClass('error'); }
      if(desc_peruntukan.val()=="") { desc_peruntukan.addClass('error'); bValid=false; } else { desc_peruntukan.removeClass('error'); }

      if(bValid==false){
        alert("Please entry an empty field!");
      }

    }

    if(bValid==true){

      $.ajax({
        type:"POST",dataType:"json",data:{account_financing_no:account_financing_no.val()},
          url: site_url+"/rekening_nasabah/cek_angsuran",
          async:false,
          success:function(response){
            $("#jml_angsuran").val(response.result);
          }
      })
      var jml_angsuran = $("#jml_angsuran").val();

      // if(jml_angsuran>0){ //dikomen new 14-02-2015
      //   alert("Warning: Pembiayaan ini tidak bisa melakukan Koreksi Droping karena telah melakukan Angsuran.");
      // }else{

        var conf = confirm("Memproses Koreksi Droping. Apakah Anda yakin?");

        if(conf)
        {

          if( fa_code.val() == old_fa_code.val() && pokok.val() == old_pokok.val() && margin.val() == old_margin.val() && 
              jangka_waktu.val() == old_jangka_waktu.val() && tanggal_droping.val() == old_tanggal_droping.val() &&
              tanggal_mulai_angsur.val() == old_tanggal_mulai_angsur.val() && tanggal_jtempo.val() == old_tanggal_jtempo.val() &&
              angsuran_pokok.val() == old_angsuran_pokok.val() && angsuran_margin.val() == old_angsuran_margin.val() &&
              uang_muka.val() == old_uang_muka.val() && titipan_notaris.val() == old_titipan_notaris.val() && periode_jangka_waktu.val() == old_periode_jangka_waktu.val() &&
              angsuran_catab.val() == old_angsuran_catab.val() && simpanan_wajib_pinjam.val() == old_simpanan_wajib_pinjam.val() &&
              biaya_administrasi.val() == old_biaya_administrasi.val() && biaya_jasa_layanan.val() == old_biaya_jasa_layanan.val() &&
              biaya_notaris.val() == old_biaya_notaris.val() && biaya_asuransi_jiwa.val() == old_biaya_asuransi_jiwa.val() &&
              biaya_asuransi_jaminan.val() == old_biaya_asuransi_jaminan.val() && sektor_ekonomi.val() == old_sektor_ekonomi.val() &&
              peruntukan.val() == old_peruntukan.val() && flag_wakalah.val() == old_flag_wakalah.val() &&
              jenis_jaminan.val() == old_jenis_jaminan.val() && keterangan_jaminan.val() == old_keterangan_jaminan.val() &&
              jumlah_jaminan.val() == old_jumlah_jaminan.val() && nominal_taksasi.val() == old_nominal_taksasi.val() &&
              presentasi_jaminan.val() == old_presentasi_jaminan.val() && jenis_jaminan_sekunder.val() == old_jenis_jaminan_sekunder.val() &&
              keterangan_jaminan_sekunder.val() == old_keterangan_jaminan_sekunder.val() && jumlah_jaminan_sekunder.val() == old_jumlah_jaminan_sekunder.val() &&
              nominal_taksasi_sekunder.val() == old_nominal_taksasi_sekunder.val() && presentasi_jaminan_sekunder.val() == old_presentasi_jaminan_sekunder.val() && 
              desc_peruntukan.val() == old_desc_peruntukan.val()
              ) {

            alert("Tidak ada data yang Diubah. Proses dibatalkan!");

          } else {

            $.ajax({
              type:"POST",
              dataType:"json",
              data:form.serialize(),
              url:site_url+"/rekening_nasabah/proses_koreksi_droping",
              async: false,
              success: function(response){
                if(response.success===true){
                  alert("Koreksi Droping SUKSES!");
                }else{
                  alert("Something wrong when processing. Please contact your Adminstrator!");
                }
                window.location.reload(true);
              },
              error: function(){
                alert("Something wrong when processing. Please contact your Adminstrator!");
              }
            });
            
          }

        }
        
      // } //end new 14-02-2015

    }

  })

});
</script>
<!-- END JAVASCRIPTS -->
