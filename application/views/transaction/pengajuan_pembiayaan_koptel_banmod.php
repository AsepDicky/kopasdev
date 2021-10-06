<style type="text/css">
   .readonly{background-color:#eee}
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
      Pembiayaan <small>Pengajuan Pembiayaan Komersial</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pengajuan Pembiayaan Komersial</a></li> 
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

<div id="dialog_upload" class="modal hide fade" tabindex="-1" data-width="800" style="margin-top:-250px;" data-keyboard="false" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3><i class="icon-upload"></i> Upload Dokumen</h3>
  </div>
  <div class="modal-body">
    <form action="<?php echo site_url('rekening_nasabah/upload_pengajuan_banmod') ?>" method="post" enctype="multipart/form-data" id="form_upload" class="form-horizontal">
      <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
      <input type="hidden" id="kopegtel_code" name="kopegtel_code">
      <div class="alert alert-error hide">
         <span id="span_message">
           You have some form error, please check below!
         </span>
      </div>
      <div class="alert alert-success hide">
         <button class="close" data-dismiss="alert"></button>
         Upload Success!
      </div>
      <div class="control-group">
         <label class="control-label">Proposal Pembiayaan <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile1" id="userfile1" class="m-wrap large">
            <div id="download1" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">SPK/Kontrak <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile2" id="userfile2" class="m-wrap large">
            <div id="download2" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Neraca dan Laba/Rigo <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile3" id="userfile3" class="m-wrap large">
            <div id="download3" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Rekening Koran <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile4" id="userfile4" class="m-wrap large">
            <div id="download4" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Analisa Kelayakan Investasi <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile5" id="userfile5" class="m-wrap large">
            <div id="download5" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Proyeksi Cash Flow <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile6" id="userfile6" class="m-wrap large">
            <div id="download6" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Jaminan <span class="required">*</span></label>
         <div class="controls">
            <input type="file" name="userfile7" id="userfile7" class="m-wrap large">
            <div id="download7" style="display:none;padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" id="close" class="btn" data-dismiss="modal">Cancel</button>
    <button type="button" id="upload" class="btn green"><i class="icon-upload"></i> Upload</button>
  </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pengajuan Pembiayaan Komersial</div>
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
               <th width="30%">Nama Kopegtel</th>
               <th width="15%">Tgl Pengajuan</th>
               <th width="20%">Tgl Dibuat</th>
               <th width="20%">Jumlah</th>
               <th width="15%">Status Dok.</th>
               <th>&nbsp;</th>
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
   
   <div class="portlet box red">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Pembiayaan Komersial</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal"> 
            <input type="hidden" id="kopegtel_name" name="kopegtel_name">
            <div class="alert alert-error hide">
               <!-- <button class="close" data-dismiss="alert"></button> -->
               <span id="span_message">
                 You have some form error, please check below!
               </span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            <div class="control-group">
               <label class="control-label">Kopegtel<span class="required">*</span></label>
               <div class="controls">
                <select id="kopegtel" name="kopegtel" class="chosen large m-wrap">
                  <option value="">PILIH</option>
                  <?php foreach($kopegtel as $key){ ?>
                  <option value="<?php echo $key['kopegtel_code'] ?>"
                    data-nama_kopegtel="<?php echo $key['nama_kopegtel'] ?>"
                    data-wilayah="<?php echo $key['wilayah'] ?>"
                    data-alamat="<?php echo $key['alamat'] ?>"
                    data-ketua_pengurus="<?php echo $key['ketua_pengurus'] ?>"
                    data-jabatan="<?php echo $key['jabatan'] ?>"
                    data-nik="<?php echo $key['nik'] ?>"
                    data-deskripsi_ketua_pengurus="<?php echo $key['deskripsi_ketua_pengurus'] ?>"
                    data-email="<?php echo $key['email'] ?>"
                    data-no_telpon="<?php echo $key['no_telpon'] ?>"
                    data-nama_bank="<?php echo $key['nama_bank'] ?>"
                    data-bank_cabang="<?php echo $key['bank_cabang'] ?>"
                    data-nomor_rekening="<?php echo $key['nomor_rekening'] ?>"
                    data-atasnama_rekening="<?php echo $key['atasnama_rekening'] ?>"
                    data-status_chaneling="<?php echo $key['status_chaneling'] ?>"><?php echo $key['kopegtel_code'].' - '.$key['nama_kopegtel'] ?></option>
                  <?php } ?>
                </select>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Wilayah <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="wilayah" id="wilayah" class="large m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="alamat" id="alamat" class="large m-wrap"/>
                  </textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pejabat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="ketua_pengurus" id="ketua_pengurus" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="jabatan" id="jabatan" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="deskripsi_ketua_pengurus" id="deskripsi_ketua_pengurus" class="large m-wrap"/>
                  </textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Email <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="email" id="email" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telpon <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kerjasama Channeling <span class="required">*</span></label>
               <div class="controls">
                  <select id="status_chaneling" name="status_chaneling" class="small m-wrap">
                     <option value="">PILIH</option>
                     <option value="Y">YA</option>
                     <option value="T">TIDAK</option>
                   </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_bank" id="nama_bank" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Cabang Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bank_cabang" id="bank_cabang" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nomor_rekening" id="nomor_rekening" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Atas Nama <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="atasnama_rekening" id="atasnama_rekening" class="medium m-wrap"/>
               </div>
            </div>
            
            <hr>

            <div class="control-group hide">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <select id="product_code" name="product_code" class="m-wrap">
                    <?php foreach($product as $produk){ ?>
                    <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>                        
            <div class="control-group">
               <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                 <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                    <?php foreach ($peruntukan as $data):?>
                      <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                    <?php endforeach?>  
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Peruntukan</label>
               <div class="controls">
                  <textarea class="large m-wrap" name="keterangan_peruntukan" id="keterangan_peruntukan" onchange="this.value=this.value.toUpperCase()"></textarea>
               </div>
            </div>               
            <div class="control-group">
               <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="13" value="0">
                     <span class="add-on">,00</span>
                   </div>
                 </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                   <input type="text" class="m-wrap" style="width:50px;" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> *bulan
                    <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                </div>
            </div>     
            <div class="control-group">
               <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_pengajuan" id="tanggal_pengajuan" value="<?php echo date('d/m/Y');?>" class="maskdate date-picker small m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Tanggal Rencana Pencairan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_droping" id="rencana_droping" value="<?php echo date('d/m/Y');?>" class="maskdate date-picker small m-wrap"/>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" id="save" name="save" class="btn green">Save</button>
               <button type="button" id="cancel" class="btn">Back</button>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Pengajuan Pembiayaan Komersial</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <input type="hidden" id="kopegtel_name" name="kopegtel_name">
            <div class="alert alert-error hide">
               <!-- <button class="close" data-dismiss="alert"></button> -->
               <span id="span_message">
                 You have some form error, please check below!
               </span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Account Financing has been Updated !
            </div>
            <div class="control-group">
               <label class="control-label">Kopegtel<span class="required">*</span></label>
               <div class="controls">
                <select id="kopegtel2" name="kopegtel" class="chosen large m-wrap">
                  <option value="">PILIH</option>
                  <?php foreach($kopegtel as $key){ ?>
                  <option value="<?php echo $key['kopegtel_code'] ?>"
                    data-nama_kopegtel="<?php echo $key['nama_kopegtel'] ?>"
                    data-wilayah="<?php echo $key['wilayah'] ?>"
                    data-alamat="<?php echo $key['alamat'] ?>"
                    data-ketua_pengurus="<?php echo $key['ketua_pengurus'] ?>"
                    data-jabatan="<?php echo $key['jabatan'] ?>"
                    data-nik="<?php echo $key['nik'] ?>"
                    data-deskripsi_ketua_pengurus="<?php echo $key['deskripsi_ketua_pengurus'] ?>"
                    data-email="<?php echo $key['email'] ?>"
                    data-no_telpon="<?php echo $key['no_telpon'] ?>"
                    data-nama_bank="<?php echo $key['nama_bank'] ?>"
                    data-bank_cabang="<?php echo $key['bank_cabang'] ?>"
                    data-nomor_rekening="<?php echo $key['nomor_rekening'] ?>"
                    data-atasnama_rekening="<?php echo $key['atasnama_rekening'] ?>"
                    data-status_chaneling="<?php echo $key['status_chaneling'] ?>"><?php echo $key['nama_kopegtel'] ?></option>
                  <?php } ?>
                </select>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Wilayah <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="wilayah" id="wilayah" class="large m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="alamat" id="alamat" class="large m-wrap"/>
                  </textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pejabat <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="ketua_pengurus" id="ketua_pengurus" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="jabatan" id="jabatan" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="deskripsi_ketua_pengurus" id="deskripsi_ketua_pengurus" class="large m-wrap"/>
                  </textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Email <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="email" id="email" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telpon <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Channeling <span class="required">*</span></label>
               <div class="controls">
                  <select id="status_chaneling" name="status_chaneling" class="small m-wrap">
                     <option value="">PILIH</option>
                     <option value="Y">YA</option>
                     <option value="T">TIDAK</option>
                   </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_bank" id="nama_bank" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Cabang Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bank_cabang" id="bank_cabang" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nomor_rekening" id="nomor_rekening" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Atas Nama <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="atasnama_rekening" id="atasnama_rekening" class="medium m-wrap"/>
               </div>
            </div>
            
            <hr>

            <div class="control-group hide">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <select id="product_code" name="product_code" class="m-wrap">
                    <?php foreach($product as $produk){ ?>
                    <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>                        
            <div class="control-group">
               <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                 <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                    <?php foreach ($peruntukan as $data):?>
                      <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                    <?php endforeach?>  
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Peruntukan</label>
               <div class="controls">
                  <textarea class="large m-wrap" name="keterangan_peruntukan" id="keterangan_peruntukan" onchange="this.value=this.value.toUpperCase()"></textarea>
               </div>
            </div>               
            <div class="control-group">
               <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="13" value="0">
                     <span class="add-on">,00</span>
                   </div>
                 </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                   <input type="text" class="m-wrap" style="width:50px;" name="jangka_waktu" id="jangka_waktu" maxlength="3"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> *bulan
                    <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                </div>
            </div>     
            <div class="control-group">
               <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_pengajuan" id="tanggal_pengajuan" value="<?php echo date('d/m/Y');?>" class="maskdate date-picker small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Rencana Pencairan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_droping" id="rencana_droping" class="maskdate date-picker small m-wrap"/>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" id="update" name="update" class="btn purple">Update</button>
               <button type="button" id="cancel" class="btn">Back</button>
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
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.1.10.4.min.js" type="text/javascript"></script>
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
    
      $(".maskdate").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
  
      // begin first table
      table = $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pengajuan_banmod",
          "aoColumns": [            
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

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        $("#amount",form1).val('0').prop('value','0');
        $("#jumlah_angsuran",form1).val('0').prop('value','0');
        $('#kopegtel',form1).trigger('liszt:updated');
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel",form1).click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        // dTreload();
      });

      $('#kopegtel',form1).change(function(){
        var kopegtel = $(this).find('option:selected');

        $('#kopegtel_name',form1).val(kopegtel.data('nama_kopegtel'));  
        $('#wilayah',form1).val(kopegtel.data('wilayah'));
        $('#alamat',form1).val(kopegtel.data('alamat'));
        $('#ketua_pengurus',form1).val(kopegtel.data('ketua_pengurus'));
        $('#jabatan',form1).val(kopegtel.data('jabatan'));
        $('#nik',form1).val(kopegtel.data('nik'));
        $('#deskripsi_ketua_pengurus',form1).val(kopegtel.data('deskripsi_ketua_pengurus'));
        $('#email',form1).val(kopegtel.data('email'));
        $('#no_telpon',form1).val(kopegtel.data('no_telpon'));
        $('#status_chaneling',form1).val(kopegtel.data('status_chaneling'));
        $('#nama_bank',form1).val(kopegtel.data('nama_bank'));
        $('#bank_cabang',form1).val(kopegtel.data('bank_cabang'));
        $('#nomor_rekening',form1).val(kopegtel.data('nomor_rekening'));
        $('#atasnama_rekening',form1).val(kopegtel.data('atasnama_rekening'));
      })

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          // ignore: "",
          rules: {
              kopegtel:{'required':true}
              ,wilayah:{'required':true}
              ,alamat:{'required':true}
              ,ketua_pengurus:{'required':true}
              ,jabatan:{'required':true}
              ,nik:{'required':true}
              ,deskripsi_ketua_pengurus:{'required':true}
              ,email:{'required':true}
              ,no_telpon:{'required':true}
              ,status_chaneling:{'required':true}
              ,nama_bank:{'required':true}
              ,bank_cabang:{'required':true}
              ,nomor_rekening:{'required':true}
              ,atasnama_rekening:{'required':true}
              ,product_code:{'required':true}
              ,peruntukan:{'required':true}
              ,keterangan_peruntukan:{'required':true}
              ,amount:{'required':true}
              ,jangka_waktu:{'required':true}
              ,tanggal_pengajuan:{'required':true}
              ,rencana_droping:{'required':true}
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
              $(element).closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            // empty
          },

          submitHandler: function (form) {
            var bValid = true, message='';

            if(bValid==true){
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/add_pengajuan_banmod",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                  if(response.success==true){
                    $.alert({
                      title:"Success",icon:'icon-check',backgroundDismiss:false,
                      content:'Pengajuan Pembiayaan Komersial Baru BERHASIL diinput!',
                      confirmButtonClass:'btn green',
                      confirm:function(){
                        $('#cancel',form1).trigger('click');
                        table.fnReloadAjax();
                      }
                    })
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


      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);


      $('#kopegtel2',form2).change(function(){
        var kopegtel = $(this).find('option:selected');

        $('#kopegtel_name',form2).val(kopegtel.data('nama_kopegtel'));  
        $('#wilayah',form2).val(kopegtel.data('wilayah'));
        $('#alamat',form2).val(kopegtel.data('alamat'));
        $('#ketua_pengurus',form2).val(kopegtel.data('ketua_pengurus'));
        $('#jabatan',form2).val(kopegtel.data('jabatan'));
        $('#nik',form2).val(kopegtel.data('nik'));
        $('#deskripsi_ketua_pengurus',form2).val(kopegtel.data('deskripsi_ketua_pengurus'));
        $('#email',form2).val(kopegtel.data('email'));
        $('#no_telpon',form2).val(kopegtel.data('no_telpon'));
        $('#status_chaneling',form2).val(kopegtel.data('status_chaneling'));
        $('#nama_bank',form2).val(kopegtel.data('nama_bank'));
        $('#bank_cabang',form2).val(kopegtel.data('bank_cabang'));
        $('#nomor_rekening',form2).val(kopegtel.data('nomor_rekening'));
        $('#atasnama_rekening',form2).val(kopegtel.data('atasnama_rekening'));
      })
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
          url: site_url+"rekening_nasabah/get_pengajuan_banmod_by_account_financing_reg_id",
          success: function(response)
          {
            $('#account_financing_reg_id',form2).val(account_financing_reg_id);
            $('#kopegtel_name',form2).val(response.kopegtel_name);
            $('#kopegtel2',form2).val(response.kopegtel).trigger('liszt:updated');
            $('#wilayah',form2).val(response.wilayah);
            $('#alamat',form2).val(response.alamat);
            $('#ketua_pengurus',form2).val(response.ketua_pengurus);
            $('#jabatan',form2).val(response.jabatan);
            $('#nik',form2).val(response.nik);
            $('#deskripsi_ketua_pengurus',form2).val(response.deskripsi_ketua_pengurus);
            $('#email',form2).val(response.email);
            $('#no_telpon',form2).val(response.no_telpon);
            $('#status_chaneling',form2).val(response.status_chaneling);
            $('#nama_bank',form2).val(response.nama_bank);
            $('#bank_cabang',form2).val(response.bank_cabang);
            $('#nomor_rekening',form2).val(response.nomor_rekening);
            $('#atasnama_rekening',form2).val(response.atasnama_rekening);
            $('#product_code',form2).val(response.product_code);
            $('#peruntukan',form2).val(response.peruntukan);
            $('#keterangan_peruntukan',form2).val(response.keterangan_peruntukan);
            $('#amount',form2).val(response.amount);
            $('#jangka_waktu',form2).val(response.jangka_waktu);
            $('#tanggal_pengajuan',form2).val(App.ToDatePicker(response.tanggal_pengajuan));
            if (response.rencana_droping!=null) {
              $('#rencana_droping',form2).val(App.ToDatePicker(response.rencana_droping));
            }
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
            kopegtel:{'required':true}
            ,wilayah:{'required':true}
            ,alamat:{'required':true}
            ,ketua_pengurus:{'required':true}
            ,jabatan:{'required':true}
            ,nik:{'required':true}
            ,deskripsi_ketua_pengurus:{'required':true}
            ,email:{'required':true}
            ,no_telpon:{'required':true}
            ,status_chaneling:{'required':true}
            ,nama_bank:{'required':true}
            ,bank_cabang:{'required':true}
            ,nomor_rekening:{'required':true}
            ,atasnama_rekening:{'required':true}
            ,product_code:{'required':true}
            ,peruntukan:{'required':true}
            ,keterangan_peruntukan:{'required':true}
            ,amount:{'required':true}
            ,jangka_waktu:{'required':true}
            ,tanggal_pengajuan:{'required':true}
            ,rencana_droping:{'required':true}
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
          },

          submitHandler: function (form) {
            var bValid = true, message='';

            if(bValid==true){
              // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/edit_pengajuan_banmod",
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    $.alert({
                      title:"Success",icon:'icon-check',backgroundDismiss:false,
                      content:'Pengajuan Pembiayaan Komersial Baru BERHASIL diupdate!',
                      confirmButtonClass:'btn green',
                      confirm:function(){
                        $('#cancel',form2).trigger('click');
                        table.fnReloadAjax();
                      }
                    })
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
        $('#kopegtel',form2).trigger('liszt:updated');
        success2.hide();
        error2.hide();
      });




      // BEGIN FORM EDIT VALIDATION
      var form3 = $('#form_upload');
      var error3 = $('.alert-error', form3);
      var success3 = $('.alert-success', form3);

      form3.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          rules: {
            // userfile1:{'required':true}
            // ,userfile2:{'required':true}
            // ,userfile3:{'required':true}
            // ,userfile4:{'required':true}
            // ,userfile5:{'required':true}
            // ,userfile6:{'required':true}
            // ,userfile7:{'required':true}
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

          },
          submitHandler: function (form) {
            $('#upload').attr('disabled',true);
            dontBlock = true
            form3.ajaxSubmit({
                dataType: 'json', 
                beforeSend: function() {
                    $('#upload').html('<i class="icon-spinner icon-spin"></i> <span>0%</span>');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    if (percentComplete>99) {
                        percentComplete=99;
                    }
                    $('#upload span').html(''+percentComplete+'%');
                },
                cache:false,
                success: function(response) {
                    $('#upload').html('<i class="icon-upload"></i> Upload');
                    $('#upload').attr('disabled',false);
                    if (response.success==true) {

                        $('#userfile').val('');

                        if (response.filename1!=null) {
                          $('#download1',form3).show();
                          $('#userfile1',form3).val('').hide();
                          $('#download1 span').text(response.filename1);
                          $('#download1 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename1+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename2!=null) {
                          $('#download2',form3).show();
                          $('#userfile2',form3).val('').hide();
                          $('#download2 span').text(response.filename2);
                          $('#download2 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename2+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename3!=null) {
                          $('#download3',form3).show();
                          $('#userfile3',form3).val('').hide();
                          $('#download3 span').text(response.filename3);
                          $('#download3 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename3+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename4!=null) {
                          $('#download4',form3).show();
                          $('#userfile4',form3).val('').hide();
                          $('#download4 span').text(response.filename4);
                          $('#download4 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename4+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename5!=null) {
                          $('#download5',form3).show();
                          $('#userfile5',form3).val('').hide();
                          $('#download5 span').text(response.filename5);
                          $('#download5 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename5+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename6!=null) {
                          $('#download6',form3).show();
                          $('#userfile6',form3).val('').hide();
                          $('#download6 span').text(response.filename6);
                          $('#download6 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename6+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }
                        if (response.filename7!=null) {
                          $('#download7',form3).show();
                          $('#userfile7',form3).val('').hide();
                          $('#download7 span').text(response.filename7);
                          $('#download7 div').html(' \
                            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+response.filename7+'"><i class="icon-download"></i> Download</a> \
                            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
                        }

                        $.alert({
                            title:'Upload Success',icon:'icon-check',backgroundDismiss:false,
                            content:'Upload Dokumen SUKSES!',
                            confirmButtonClass:'btn green',
                            confirm:function(){
                              table.fnReloadAjax();
                              $('#close','#dialog_upload').trigger('click')
                            }
                        })
                    } else {
                        App.WarningAlert(response.message);
                    }

                },
                error: function(){
                    App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                    // var percentVal = '100%';
                    // percent.html(percentVal);
                    $('#upload').html('<i class="icon-upload"></i> Upload');
                    $('#upload').attr('disabled',false);
                }
            });
          }
      });
      //  END FORM UPLOAD VALIDATION

      /*begin re upload*/
      $('#download1 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download1',form3).hide();
        $('#userfile1',form3).val('').show();
      });
      $('#download2 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download2',form3).hide();
        $('#userfile2',form3).val('').show();
      });
      $('#download3 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download3',form3).hide();
        $('#userfile3',form3).val('').show();
      });
      $('#download4 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download4',form3).hide();
        $('#userfile4',form3).val('').show();
      });
      $('#download5 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download5',form3).hide();
        $('#userfile5',form3).val('').show();
      });
      $('#download6 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download6',form3).hide();
        $('#userfile6',form3).val('').show();
      });
      $('#download7 #re-upload','#dialog_upload').livequery('click',function(){
        $('#download7',form3).hide();
        $('#userfile7',form3).val('').show();
      });
      /*end re upload*/

      // event button Upload ketika di tekan
      $("a#link-upload").live('click',function(){
        form3.trigger('reset');
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
        var kopegtel_code = $(this).attr('kopegtel_code');
        var f_proposal = $(this).attr('f_proposal');
        var f_kontrak = $(this).attr('f_kontrak');
        var f_keuangan = $(this).attr('f_keuangan');
        var f_rek_koran = $(this).attr('f_rek_koran');
        var f_aki = $(this).attr('f_aki');
        var f_proyeksi = $(this).attr('f_proyeksi');
        var f_jaminan = $(this).attr('f_jaminan');
        $('#account_financing_reg_id',form3).val(account_financing_reg_id);
        $('#kopegtel_code',form3).val(kopegtel_code);
        
        if (f_proposal!="") {
          $('#download1').show();
          $('#userfile1').hide();
          $('#download1 span',form3).text(f_proposal);
          $('#download1 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_proposal+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download1').hide();
          $('#userfile1').show();
        }

        if (f_kontrak!="") {
          $('#download2').show();
          $('#userfile2').hide();
          $('#download2 span',form3).text(f_kontrak);
          $('#download2 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_kontrak+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download2').hide();
          $('#userfile2').show();
        }

        if (f_keuangan!="") {
          $('#download3').show();
          $('#userfile3').hide();
          $('#download3 span',form3).text(f_keuangan);
          $('#download3 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_keuangan+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download3').hide();
          $('#userfile3').show();
        }

        if (f_rek_koran!="") {
          $('#download4').show();
          $('#userfile4').hide();
          $('#download4 span',form3).text(f_rek_koran);
          $('#download4 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_rek_koran+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download4').hide();
          $('#userfile4').show();
        }

        if (f_aki!="") {
          $('#download5').show();
          $('#userfile5').hide();
          $('#download5 span',form3).text(f_aki);
          $('#download5 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_aki+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download5').hide();
          $('#userfile5').show();
        }

        if (f_proyeksi!="") {
          $('#download6').show();
          $('#userfile6').hide();
          $('#download6 span',form3).text(f_proyeksi);
          $('#download6 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_proyeksi+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download6').hide();
          $('#userfile6').show();
        }

        if (f_jaminan!="") {
          $('#download7').show();
          $('#userfile7').hide();
          $('#download7 span',form3).text(f_jaminan);
          $('#download7 div').html(' \
            <a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_jaminan+'"><i class="icon-download"></i> Download</a> \
            | <a href="javascript:void(0);" id="re-upload">Re Upload</a>');
        } else {
          $('#download7').hide();
          $('#userfile7').show();
        }

        $('#upload').html('<i class="icon-upload"></i> Upload');
        $('#upload').attr('disabled',false);
      });

      $('button#upload','#dialog_upload').click(function(){
        form3.submit();
      })


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
              url: site_url+"rekening_nasabah/delete_pengajuan_pembiayaan_banmod",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Pengajuan Berhasil di Hapus!");
                  table.fnReloadAjax();
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

});
</script>
<!-- END JAVASCRIPTS -->

