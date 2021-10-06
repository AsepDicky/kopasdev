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
      Pembiayaan <small>Registrasi Data Jaminan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Data Jaminan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>List Data Jaminan</div>
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
            <?php
            foreach($product as $produk):
              if ($produk['product_code']!='52' && $produk['product_code']!='58') {
            ?>
              <option value="<?php echo $produk['product_code'];?>"><?php echo $produk['product_name'];?></option>
            <?php
              }
            endforeach;
            ?>
          </select>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="jaminan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#jaminan_table .checkboxes" /></th>
               <th width="18%">No Pengajuan</th>
               <th width="18%">Nik</th>
               <th width="18%">Nama</th>
               <th width="15%">Tipe Jaminan</th>
               <th width="18%">No Jaminan</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Data Jaminan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('rekening_nasabah/action_data_jaminand'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
         
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Berhasil Ditambahkan !
            </div>
            <br>
            <div class="row">
              <div class="span6">

                <div class="control-group">
                   <label class="control-label">No Pengajuan<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="registration_no" id="registration_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;" />               

                      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                         <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Cari No Pengajuan</h3>
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
                   <label class="control-label">Nasabah<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="nasabah" id="nasabah" data-required="1" class="large m-wrap" readonly="" style="background-color:#eee;" />
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tipe Jaminan<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap" name="tipe_jaminan" id="tipe_jaminan">
                         <option value="1">Sertifikat</option>
                         <option value="2">BPKB</option>
                      </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Nomor <span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="nomor_jaminan" id="nomor_jaminan" data-required="1" class="medium m-wrap" maxlength="50" />
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Atas Nama<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="atas_nama" id="atas_nama" data-required="1" class="large m-wrap" maxlength="200" />
                      <a id="tambah_an" class="btn blue"><i class="icon-plus"></i></a>
                      <a id="remove_an" style="display:none;" class="btn red"><i class="icon-remove"></i></a>
                   </div>
                </div> 
                <div id="div_atasnama" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Atas Nama 2<span class="required">*</span></label>
                     <div class="controls">
                        <input type="text" name="atas_nama2" id="atas_nama2" data-required="1" class="large m-wrap" maxlength="200" />
                     </div>
                  </div> 
                  <div class="control-group">
                     <label class="control-label">Atas Nama 3<span class="required">*</span></label>
                     <div class="controls">
                        <textarea class="form-control medium m-wrap" name="atas_nama3" id="atas_nama3"></textarea>
                     </div>
                  </div> 
                </div>
                <div class="control-group" id="div_jenis_surat">
                   <label class="control-label">Jenis Surat<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap" name="jenis_surat" id="jenis_surat">
                         <option value="SHM">SHM</option>
                         <option value="HGB">HGB</option>
                      </select>
                   </div>
                </div>
                <div class="control-group" align="left">
                   <label class="control-label" style="text-align:left">Letak ::</label>
                </div>
                <div class="control-group">
                   <label class="control-label">Provinsi<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap chosen" name="provinsi" id="provinsi">
                         <option value="">Select...</option>
                         <?php
                         foreach($province as $tes):
                         ?>
                         <option value="<?php echo $tes['province_code']; ?>"><?php echo $tes['province']; ?></option>
                         <?php
                         endforeach;
                         ?>
                      </select>
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Kota<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap chosen" name="kota" id="kota">
                         <option value="">Select...</option>
                      </select>
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Kecamatan</label>
                   <div class="controls">
                      <input type="text" name="kecamatan" id="kecamatan" data-required="1" class="medium m-wrap" maxlength="30" />
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Kelurahan/Desa</label>
                   <div class="controls">
                      <input type="text" name="kelurahan" id="kelurahan" data-required="1" class="medium m-wrap" maxlength="30" />
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Blok</label>
                   <div class="controls">
                      <input type="text" name="blok" id="blok" data-required="1" class="medium m-wrap" maxlength="200" />
                   </div>
                </div> 
                <div class="control-group" id="div_tanggal_surat_jaminan">
                   <label class="control-label">Tanggal Surat Jaminan</label>
                   <div class="controls">
                      <input type="text" name="tanggal_surat_jaminan" id="tanggal_surat_jaminan" class="mask_date small m-wrap" placeholder="dd/mm/yy"/>
                   </div>
                </div>      
                <div class="control-group">
                   <label class="control-label">Nilai Jual Objek <span class="required">*</span></label>
                   <div class="controls">
                      <div class="input-prepend">
                        <span class="add-on">Rp</span>
                        <input type="text" name="nilai_jual" id="nilai_jual" class="medium m-wrap mask-money" style="width:120px !important;" />
                        <span class="add-on">,00</span>
                      </div>
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Luas Tanah (m2)</label>
                   <div class="controls">
                      <input type="text" name="luas_tanah" id="luas_tanah" data-required="1" class="medium m-wrap" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                   </div>
                </div> 
                <div class="control-group hide">
                   <label class="control-label">Alamat</label>
                   <div class="controls">
                      <input type="text" name="alamat" id="alamat" data-required="1" class="large m-wrap" maxlength="225" />
                   </div>
                </div> 

                <div class="control-group" align="left" id="title-data-developer">
                   <label class="control-label" style="text-align:left">Data Developer ::</label>
                </div>
                <div class="control-group">
                   <label class="control-label">Tipe Penjual</label>
                   <div class="controls">
                      <select class="medium m-wrap" name="tipe_developer" id="tipe_developer">
                         <option value="">Select</option>
                         <option value="0">Individu</option>
                         <option value="1">Perusahaan</option>
                      </select>
                   </div>
                </div> 
                <div id="div_individu" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Nama Penjual</label>
                     <div class="controls">
                        <input type="text" name="nama_penjual_individu" id="nama_penjual_individu" class="medium m-wrap"/>
                     </div>
                  </div> <!-- 
                  <div class="control-group hide">
                     <label class="control-label">Nomer KTP</label>
                     <div class="controls">
                        <input type="text" name="nomer_ktp" id="nomer_ktp" class="medium m-wrap"/>
                     </div>
                  </div>  -->
                  <div class="control-group">
                     <label class="control-label">Nama Pasangan</label>
                     <div class="controls">
                        <input type="text" name="nama_pasangan_developer" id="nama_pasangan_developer" class="medium m-wrap"/>
                     </div>
                  </div> 
                </div>
                <div id="div_perusahaan" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Nama Perusahaan</label>
                     <div class="controls">
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="medium m-wrap"/>
                     </div>
                  </div> 
                </div>
                
              </div>
              <div class="span4_kmg" style="border:1px solid #ccc;padding:10px;width:400px;display:none;">
                <input type="hidden" name="nama_pasangan" id="nama_pasangan">
                <h5 style="margin-top:0;">Kelengkapan Dokumen Yang Sudah Diterima</h5>
                <div> <input type="checkbox" value="Y" name="check_ktp" id="check_ktp"> KTP Suami istri </div>
                <div> <input type="checkbox" value="Y" name="check_kk" id="check_kk"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="check_surat_nikah" id="check_surat_nikah"> Surat Nikah </div>
                <div> <input type="checkbox" value="Y" name="check_cover_buku_tabungan" id="check_cover_buku_tabungan"> Cover Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="check_no_rekening" id="check_no_rekening"> Foto Copy Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="check_slip_gaji" id="check_slip_gaji"> Slip Gaji </div>
                <div> <input type="checkbox" value="Y" name="check_sk" id="check_sk"> SK Terakhir </div>
                <div> <input type="checkbox" value="Y" name="check_sertifikat_tanah" id="check_sertifikat_tanah"> Sertifikat Tanah </div>
                <div> <input type="checkbox" value="Y" name="check_imb" id="check_imb"> IMB </div>
                <div> <input type="checkbox" value="Y" name="check_pbb" id="check_pbb"> PBB </div>
              </div>
              <div class="span4_kpr" style="border:1px solid #ccc;padding:10px;width:400px;display:none;margin-bottom:20px !important;">
                <input type="hidden" name="nama_pasangan_kpr" id="nama_pasangan_kpr">
                <h5 style="margin-top:0;">Kelengkapan Dokumen Yang Sudah Diterima</h5>
                <b>DATA PEMOHON</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_pemohon" id="kpr_check_npwp_pemohon"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pemohon" id="kpr_check_ktp_pemohon"> KTP Pemohon </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pasangan_pemohon" id="kpr_check_ktp_pasangan_pemohon"> KTP Suami/Istri Pemohon </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_kartu_keluarga" id="kpr_check_kartu_keluarga"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_nikah_pemohon" id="kpr_check_surat_nikah_pemohon"> Surat Nikah (apabila telah menikah) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_slip_gaji" id="kpr_check_slip_gaji"> Slip Gaji Terakhir (gaji normal tanpa rapel) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_buku_tabungan" id="kpr_check_buku_tabungan"> Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_perjanjian" id="kpr_check_surat_perjanjian"> Surat Perjanjian Kredit/Pembiayaan atau Persetujuan Kredit/Pembiayaan (apabila Take Over pinjaman dari Bank) </div>
                <br/>
                <b>DATA OBJEK</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_sertifikat_tanah" id="kpr_check_sertifikat_tanah"> Sertifikat Tanah (posisi terakhir) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_imb" id="kpr_check_surat_imb"> Surat Izin Mendirikan Bangunan (IMB) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_pbb" id="kpr_check_pbb"> PBB 10 (sepuluh) tahun terakhir </div>
                <div id="data-individu">
                <br/>
                <b>DATA PENJUAL (APABILA MEMBELI DARI PENJUAL)</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_penjual" id="kpr_check_npwp_penjual"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pasangan" id="kpr_check_ktp_pasangan"> KTP Suami/Istri Penjual </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_kk_penjual" id="kpr_check_kk_penjual"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_nikah" id="kpr_check_surat_nikah"> Surat Nikah (apabila telah menikah) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_cerai" id="kpr_check_surat_cerai"> Surat Cerai (apabila telah bercerai) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_penetapan" id="kpr_check_surat_penetapan"> Surat Penetapan Pengadilan tentang Pembagian Harta </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_kematian" id="kpr_check_surat_kematian"> Surat Kematian (apabila penjual meninggal) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_waris" id="kpr_check_surat_waris"> Surat Waris </div>
                </div>
                <div id="data-developer">
                <br/>
                <b>DATA DEVELOPER</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_developer" id="kpr_check_npwp_developer"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_developer" id="kpr_check_ktp_developer"> KTP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_akta_developer" id="kpr_check_akta_developer"> Akta Pendirian/Perubahannya untuk pembelian dari Developer </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_siup" id="kpr_check_siup"> SIUP, dan perijinan lainnya </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_pencairan" id="kpr_check_surat_pencairan"> Surat Permohonan Pencairan dari Developer </div>
                </div>
              </div>
            </div>

            <!-- INPUT HIDDEN KODE PRODUK UNTUK MENDEFINISIKAN PRODUK KMG / KPR -->
            <input type="hidden" name="kode_produk" id="kode_produk">

            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Data Jaminan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="id_jaminan" name="id_jaminan">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Kota Berhasil Di Edit !
            </div>
          </br>
            <br>
            <div class="row">
              <div class="span6">

                <div class="control-group">
                   <label class="control-label">No Pengajuan<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="registration_no" id="registration_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;" />               
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Nasabah<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="nasabah" id="nasabah" data-required="1" class="large m-wrap" readonly="" style="background-color:#eee;" />
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tipe Jaminan<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap" name="tipe_jaminan" id="tipe_jaminan">
                         <option value="1">Sertifikat</option>
                         <option value="2">BPKB</option>
                      </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Nomor <span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="nomor_jaminan" id="nomor_jaminan" data-required="1" class="medium m-wrap" maxlength="50" />
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Atas Nama<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="atas_nama" id="atas_nama" data-required="1" class="medium m-wrap" maxlength="200" />
                      <a id="tambah_an" class="btn blue"><i class="icon-plus"></i></a>
                      <a id="remove_an" style="display:none;" class="btn red"><i class="icon-remove"></i></a>
                   </div>
                </div> 
                <div id="div_atasnama" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Atas Nama 2<span class="required">*</span></label>
                     <div class="controls">
                        <input type="text" name="atas_nama2" id="atas_nama2" data-required="1" class="large m-wrap" maxlength="200" />
                     </div>
                  </div> 
                  <div class="control-group">
                     <label class="control-label">Atas Nama 3<span class="required">*</span></label>
                     <div class="controls">
                        <textarea class="form-control medium m-wrap" name="atas_nama3" id="atas_nama3"></textarea>
                     </div>
                  </div>
                </div> 
                <div class="control-group" id="div_jenis_surat">
                   <label class="control-label">Jenis Surat<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap" name="jenis_surat" id="jenis_surat">
                         <option value="SHM">SHM</option>
                         <option value="HGB">HGB</option>
                      </select>
                   </div>
                </div>
                <div class="control-group" align="left">
                   <label class="control-label" style="text-align:left">Letak ::</label>
                </div>
                <div class="control-group">
                   <label class="control-label">Provinsi<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap chosen" name="provinsi2" id="provinsi2">
                         <option value="">Select...</option>
                         <?php
                         foreach($province as $tes):
                         ?>
                         <option value="<?php echo $tes['province_code']; ?>"><?php echo $tes['province']; ?></option>
                         <?php
                         endforeach;
                         ?>
                      </select>
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Kota<span class="required">*</span></label>
                   <div class="controls">
                      <select class="medium m-wrap chosen" name="kota2" id="kota2">
                         <option value="">Select...</option>
                      </select>
                   </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Kecamatan</label>
                   <div class="controls">
                      <input type="text" name="kecamatan" id="kecamatan" data-required="1" class="medium m-wrap" maxlength="30" />
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Kelurahan/Desa</label>
                   <div class="controls">
                      <input type="text" name="kelurahan" id="kelurahan" data-required="1" class="medium m-wrap" maxlength="30" />
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Blok</label>
                   <div class="controls">
                      <input type="text" name="blok" id="blok" data-required="1" class="medium m-wrap" maxlength="200" />
                   </div>
                </div> 
                <div class="control-group" id="div_tanggal_surat_jaminan">
                   <label class="control-label">Tanggal Surat Jaminan</label>
                   <div class="controls">
                      <input type="text" name="tanggal_surat_jaminan" id="tanggal_surat_jaminan" class="mask_date small m-wrap" placeholder="dd/mm/yy"/>
                   </div>
                </div>      
                <div class="control-group">
                   <label class="control-label">Nilai Jual Objek <span class="required">*</span></label>
                   <div class="controls">
                      <div class="input-prepend">
                        <span class="add-on">Rp</span>
                        <input type="text" name="nilai_jual" id="nilai_jual" class="medium m-wrap mask-money" style="width:120px !important;" />
                        <span class="add-on">,00</span>
                      </div>
                   </div>
                </div>  
                <div class="control-group">
                   <label class="control-label">Luas Tanah (m2)</label>
                   <div class="controls">
                      <input type="text" name="luas_tanah" id="luas_tanah" data-required="1" class="medium m-wrap" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                   </div>
                </div> 
                <div class="control-group hide">
                   <label class="control-label">Alamat</label>
                   <div class="controls">
                      <input type="text" name="alamat" id="alamat" data-required="1" class="large m-wrap" maxlength="225" />
                   </div>
                </div> 

                <div class="control-group" align="left" id="title-data-developer">
                   <label class="control-label" style="text-align:left">Data Developer ::</label>
                </div>
                <div class="control-group">
                   <label class="control-label">Tipe Penjual</label>
                   <div class="controls">
                      <select class="medium m-wrap" name="tipe_developer" id="tipe_developer">
                         <option value="">Select</option>
                         <option value="0">Individu</option>
                         <option value="1">Perusahaan</option>
                      </select>
                   </div>
                </div> 
                <div id="div_individu" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Nama Penjual</label>
                     <div class="controls">
                        <input type="text" name="nama_penjual_individu" id="nama_penjual_individu" class="medium m-wrap"/>
                     </div>
                  </div> <!-- 
                  <div class="control-group hide">
                     <label class="control-label">Nomer KTP</label>
                     <div class="controls">
                        <input type="text" name="nomer_ktp" id="nomer_ktp" class="medium m-wrap"/>
                     </div>
                  </div>  -->
                  <div class="control-group">
                     <label class="control-label">Nama Pasangan</label>
                     <div class="controls">
                        <input type="text" name="nama_pasangan_developer" id="nama_pasangan_developer" class="medium m-wrap"/>
                     </div>
                  </div> 
                </div>
                <div id="div_perusahaan" style="display:none;">
                  <div class="control-group">
                     <label class="control-label">Nama Perusahaan</label>
                     <div class="controls">
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="medium m-wrap"/>
                     </div>
                  </div> 
                </div>
                
              </div>
              <div class="span4_kmg" style="border:1px solid #ccc;padding:10px;width:400px;display:none;">
                <input type="hidden" name="nama_pasangan" id="nama_pasangan">
                <h5 style="margin-top:0;">Kelengkapan Dokumen Yang Sudah Diterima</h5>
                <div> <input type="checkbox" value="Y" name="check_ktp" id="check_ktp"> KTP Suami istri </div>
                <div> <input type="checkbox" value="Y" name="check_kk" id="check_kk"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="check_surat_nikah" id="check_surat_nikah"> Surat Nikah </div>
                <div> <input type="checkbox" value="Y" name="check_cover_buku_tabungan" id="check_cover_buku_tabungan"> Cover Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="check_no_rekening" id="check_no_rekening"> Foto Copy Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="check_slip_gaji" id="check_slip_gaji"> Slip Gaji </div>
                <div> <input type="checkbox" value="Y" name="check_sk" id="check_sk"> SK Terakhir </div>
                <div> <input type="checkbox" value="Y" name="check_sertifikat_tanah" id="check_sertifikat_tanah"> Sertifikat Tanah </div>
                <div> <input type="checkbox" value="Y" name="check_imb" id="check_imb"> IMB </div>
                <div> <input type="checkbox" value="Y" name="check_pbb" id="check_pbb"> PBB </div>
              </div>
              <div class="span4_kpr" style="border:1px solid #ccc;padding:10px;width:400px;display:none;margin-bottom:20px !important;">
                <input type="hidden" name="nama_pasangan_kpr" id="nama_pasangan_kpr">
                <h5 style="margin-top:0;">Kelengkapan Dokumen Yang Sudah Diterima</h5>
                <b>DATA PEMOHON</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_pemohon" id="kpr_check_npwp_pemohon"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pemohon" id="kpr_check_ktp_pemohon"> KTP Pemohon </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pasangan_pemohon" id="kpr_check_ktp_pasangan_pemohon"> KTP Suami/Istri Pemohon </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_kartu_keluarga" id="kpr_check_kartu_keluarga"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_nikah_pemohon" id="kpr_check_surat_nikah_pemohon"> Surat Nikah (apabila telah menikah) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_slip_gaji" id="kpr_check_slip_gaji"> Slip Gaji Terakhir (gaji normal tanpa rapel) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_buku_tabungan" id="kpr_check_buku_tabungan"> Buku Tabungan </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_perjanjian" id="kpr_check_surat_perjanjian"> Surat Perjanjian Kredit/Pembiayaan atau Persetujuan Kredit/Pembiayaan (apabila Take Over pinjaman dari Bank) </div>
                <br/>
                <b>DATA OBJEK</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_sertifikat_tanah" id="kpr_check_sertifikat_tanah"> Sertifikat Tanah (posisi terakhir) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_imb" id="kpr_check_surat_imb"> Surat Izin Mendirikan Bangunan (IMB) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_pbb" id="kpr_check_pbb"> PBB 10 (sepuluh) tahun terakhir </div>
                <div id="data-individu">
                <br/>
                <b>DATA PENJUAL (APABILA MEMBELI DARI PENJUAL)</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_penjual" id="kpr_check_npwp_penjual"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_pasangan" id="kpr_check_ktp_pasangan"> KTP Suami/Istri Penjual </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_kk_penjual" id="kpr_check_kk_penjual"> Kartu Keluarga </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_nikah" id="kpr_check_surat_nikah"> Surat Nikah (apabila telah menikah) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_cerai" id="kpr_check_surat_cerai"> Surat Cerai (apabila telah bercerai) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_penetapan" id="kpr_check_surat_penetapan"> Surat Penetapan Pengadilan tentang Pembagian Harta </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_kematian" id="kpr_check_surat_kematian"> Surat Kematian (apabila penjual meninggal) </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_waris" id="kpr_check_surat_waris"> Surat Waris </div>
                </div>
                <div id="data-developer">
                <br/>
                <b>DATA DEVELOPER</b>
                <div> <input type="checkbox" value="Y" name="kpr_check_npwp_developer" id="kpr_check_npwp_developer"> NPWP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_ktp_developer" id="kpr_check_ktp_developer"> KTP </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_akta_developer" id="kpr_check_akta_developer"> Akta Pendirian/Perubahannya untuk pembelian dari Developer </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_siup" id="kpr_check_siup"> SIUP, dan perijinan lainnya </div>
                <div> <input type="checkbox" value="Y" name="kpr_check_surat_pencairan" id="kpr_check_surat_pencairan"> Surat Permohonan Pencairan dari Developer </div>
                </div>
              </div>
            </div>    

            <!-- INPUT HIDDEN KODE PRODUK UNTUK MENDEFINISIKAN PRODUK KMG / KPR -->
            <input type="hidden" name="kode_produk" id="kode_produk">

            <div class="form-actions">
               <button type="submit" class="btn green">Update</button>
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
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'jaminan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#jaminan_table .group-checkable').live('change',function () {
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

      $("#jaminan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      $("#keyword").on('keypress',function(e){
        if(e.which==13){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/search_pengajuan_pembiayaan_dokumen_tdk_lengkap",
            data: {keyword:$(this).val()},
            dataType: "json",
            async: false,
            success: function(response){
              var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].registration_no+'" nama="'+response[i].nama+'" nama_pasangan="'+response[i].nama_pasangan+'" product_code="'+response[i].product_code+'">'+response[i].registration_no+' - '+response[i].nama+'</option>';
                }
              // console.log(option);
              $("#result").html(option);
            }
          });
          return false;
        }
      });

      $("#form_add select[name='provinsi']").change(function(){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/search_kota_by_provinsi",
            data: {provinsi_code:$(this).val()},
            dataType: "json",
            async: false,
            success: function(response){
              var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].city_code+'">'+response[i].city+'</option>';
                }
              // console.log(option);
              $("#kota","#add").html(option).trigger('liszt:updated');
            }
          });
      });
      $("#btn_add").click(function(){
        $(".span4_kmg","#form_add").hide();
        $(".span4_kpr","#form_add").hide();
        $("input[type='checkbox']","#form_add").attr('checked',false);
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        $("#tipe_jaminan","#add").trigger('change');
        $('#check_surat_nikah','#form_add').removeAttr('disabled').removeAttr('checked').parent().removeAttr('style');
      });
      
      $("#tipe_jaminan","#add").change(function(){
        tipe = $(this).val();
        if(tipe=='1'){ //sertifikat
          $("#div_jenis_surat","#add").show()
          $("#div_no_imb","#add").show()
          $("#div_tanggal_imb","#add").show()
          $("#div_tanggal_surat_jaminan","#add").hide()
          $("#div_nop","#add").show()
        }else{ //bpkb
          $("#div_jenis_surat","#add").hide()
          $("#div_no_imb","#add").hide()
          $("#div_tanggal_imb","#add").hide()
          $("#div_tanggal_surat_jaminan","#add").show()
          $("#div_nop","#add").hide()
        }
      });

      $("#result option").live('dblclick',function(){
        $("#select").trigger('click');
      });

      $("#select").click(function(){       
        result = $("#result").val();
        nasabah = $("#result option:selected","#form_add").attr('nama');
        $("#close","#dialog_rembug").trigger('click');
        $("#registration_no","#form_add").val(result);
        $("#nasabah","#form_add").val(nasabah);
        
        var product_code = $("#result option:selected","#form_add").attr('product_code');
        if(product_code=='54'){ // KMG
          $('#title-data-developer','#form_add').hide();
          $('#tipe_developer','#form_add').closest('.control-group').hide();
          $('#nama_penjual_individu','#form_add').closest('.control-group').hide();
          $('#nomer_ktp','#form_add').closest('.control-group').hide();
          $('#nama_pasangan_developer','#form_add').closest('.control-group').hide();
          $('#nama_perusahaan','#form_add').closest('.control-group').hide();

          nama_pasangan = $("#result option:selected","#form_add").attr('nama_pasangan');
          if (nama_pasangan!="") {
            status_menikah = '1';
          } else {
            status_menikah = '0';
          }
          $('#nama_pasangan','#form_add').val(nama_pasangan);
          // 0 tidak menikah, 1=menikah
          if (status_menikah=='0') {
            $('#check_surat_nikah','#form_add').attr('disabled',true).removeAttr('checked').parent().css({'background':'#eee'});
          } else {
            $('#check_surat_nikah','#form_add').removeAttr('disabled').removeAttr('checked').parent().removeAttr('style');
          }
          $.uniform.update();
          // alert(result+'|'+nasabah)
          $(".span4_kmg","#form_add").show();
          $(".span4_kpr","#form_add").hide();
          $("input[type='checkbox']","#form_add").attr('checked',false);
          $("#kode_produk","#form_add").val(product_code);
        }else if(product_code=='56'){ // KPR
          $('#title-data-developer','#form_add').show();
          $('#tipe_developer','#form_add').closest('.control-group').show();
          $('#nama_penjual_individu','#form_add').closest('.control-group').show();
          $('#nomer_ktp','#form_add').closest('.control-group').show();
          $('#nama_pasangan_developer','#form_add').closest('.control-group').show();
          $('#nama_perusahaan','#form_add').closest('.control-group').show();

          nama_pasangan = $("#result option:selected","#form_add").attr('nama_pasangan');
          if (nama_pasangan!="") {
            status_menikah = '1';
          } else {
            status_menikah = '0';
          }
          $('#nama_pasangan_kpr','#form_add').val(nama_pasangan);
          // 0 tidak menikah, 1=menikah
          if (status_menikah=='0') {
            $('#kpr_check_surat_nikah_pemohon','#form_add').attr('disabled',true).removeAttr('checked').parent().css({'background':'#eee'});
          } else {
            $('#kpr_check_surat_nikah_pemohon','#form_add').removeAttr('disabled').removeAttr('checked').parent().removeAttr('style');
          }
          $.uniform.update();
          // alert(result+'|'+nasabah)
          $(".span4_kmg","#form_add").hide();
          $(".span4_kpr","#form_add").show();
          $("input[type='checkbox']","#form_add").attr('checked',false);
          $("#kode_produk","#form_add").val(product_code);
        }
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              registration_no: {
                  required: true
              },
              nomor_jaminan: {
                  required: true
              },
              atas_nama: {
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
                  .closest('.control-group').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
              label
                  // .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          bValid = true;
          if(bValid==true)
          {
            form1.ajaxForm({
                type: "POST",
                url: site_url+"rekening_nasabah/action_data_jaminan",
                data: form1.serialize(),
                dataType: "json",
                success: function(response) {
                  if(response.success==true){
                    App.SuccessAlert("Data Jaminan Berhasi Diiput",function(){
                      success1.show();
                      error1.hide();
                      form1.trigger('reset');
                      form1.children('div').removeClass('success');
                      $("#cancel",form_add).trigger('click');
                    })
                  }else{
                    success1.hide();
                    error1.show();
                  }
                },
                error:function(){
                    success1.hide();
                    error1.show();
                }
            });            
          }
        }
        else
        {
          alert('Please fill the empty field before.');
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





      // BEGIN FORM EDIT NEWS VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var id_jaminan = $(this).attr('id_jaminan');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {id_jaminan:id_jaminan},
          url: site_url+"rekening_nasabah/get_jaminan_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='id_jaminan']").val(id_jaminan);
            $("#form_edit input[name='kode_produk']").val(response.product_code);
            $("#form_edit input[name='nasabah']").val(response.nasabah);
            $("#form_edit input[name='registration_no']").val(response.registration_no);
            $("#form_edit select[name='tipe_jaminan']").val(response.tipe_jaminan);
            $("#form_edit select[name='tipe_jaminan']").trigger('change');
            $("#form_edit input[name='nomor_jaminan']").val(response.nomor_jaminan);
            $("#form_edit input[name='atas_nama']").val(response.atas_nama);
            $("#form_edit input[name='atas_nama2']").val(response.atas_nama1);
            $("#form_edit textarea[name='atas_nama3']").val(response.atas_nama2);
            if(response.atas_nama1!=null){
              $("#div_atasnama","#form_edit").show();
              $("#tambah_an","#form_edit").hide();
              $("#remove_an","#form_edit").show();
            }else{
              $("#div_atasnama","#form_edit").hide();
              $("#tambah_an","#form_edit").show();
              $("#remove_an","#form_edit").hide();
            }
            $("#form_edit select[name='jenis_surat']").val(response.jenis_surat);
            $("#form_edit select[name='provinsi2']").val(response.provinsi).trigger('liszt:updated');
            $("#form_edit select[name='provinsi2']").prop(response.provinsi);
            $("#form_edit select[name='provinsi2']").trigger('change');
            $("#form_edit select[name='kota2']").val(response.kota).trigger('liszt:updated');
            $("#form_edit select[name='kota2']").prop(response.kota);
            $("#form_edit input[name='kecamatan']").val(response.kecamatan);
            $("#form_edit input[name='kelurahan']").val(response.kelurahan);
            $("#form_edit input[name='blok']").val(response.blok);
            $("#form_edit input[name='luas_tanah']").val(response.luas_tanah);
            $("#form_edit input[name='alamat']").val(response.alamat);
            // $("#form_edit input[name='no_imb']").val(response.no_imb);
            // $("#form_edit input[name='tanggal_imb']").val(response.tanggal_imb);
            $("#form_edit input[name='tanggal_surat_jaminan']").val(response.tanggal_surat_jaminan);
            // $("#form_edit input[name='nop']").val(response.nop);
            $("#form_edit input[name='nilai_jual']").val(number_format(response.nilai_jual,0,',','.'));

            if(response.tipe_developer==0){
              $("#tipe_developer","#form_edit").val(response.tipe_developer);
              $("#nama_penjual_individu","#form_edit").val(response.nama_penjual_individu);
              $("#nomer_ktp","#form_edit").val(response.nomer_ktp);
              $("#nama_pasangan_developer","#form_edit").val(response.nama_pasangan_developer);
              $("#nama_perusahaan","#form_edit").val('');
              $("#div_individu","#form_edit").show();
              $("#div_perusahaan","#form_edit").hide();
              $('#data-individu','#form_edit').show();
              $('#data-developer','#form_edit').hide();

              /*enable data individu*/
              $('#kpr_check_npwp_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_ktp_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_ktp_pasangan_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_kartu_keluarga','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_surat_nikah_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_slip_gaji','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_buku_tabungan','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_surat_perjanjian','#form_edit').attr('disabled',false).removeAttr('checked').parent();

              /*disable data developer*/
              $('#kpr_check_npwp_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_ktp_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_akta_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_siup','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_surat_pencairan','#form_edit').attr('disabled',true).removeAttr('checked').parent();

              $.uniform.update(); 
            }else if(response.tipe_developer==1){
              $("#tipe_developer","#form_edit").val(response.tipe_developer);
              $("#nama_penjual_individu","#form_edit").val('');
              $("#nomer_ktp","#form_edit").val('');
              $("#nama_pasangan_developer","#form_edit").val('');
              $("#nama_perusahaan","#form_edit").val(response.nama_perusahaan);
              $("#div_individu","#form_edit").hide();
              $("#div_perusahaan","#form_edit").show();
              $('#data-developer','#form_edit').show();
              $('#data-individu','#form_edit').hide();

              /*Disable data individu*/
              $('#kpr_check_npwp_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_ktp_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_ktp_pasangan_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_kartu_keluarga','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_surat_nikah_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_slip_gaji','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_buku_tabungan','#form_edit').attr('disabled',true).removeAttr('checked').parent();
              $('#kpr_check_surat_perjanjian','#form_edit').attr('disabled',true).removeAttr('checked').parent();

              /*Enable data developer*/
              $('#kpr_check_npwp_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_ktp_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_akta_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_siup','#form_edit').attr('disabled',false).removeAttr('checked').parent();
              $('#kpr_check_surat_pencairan','#form_edit').attr('disabled',false).removeAttr('checked').parent();

              $.uniform.update(); 
            }

            /*
            | BEGIN PRODUK KMG
            | ADDENDUM BY UI
            | 24 JULI 2015
            */  
            if(response.product_code=='54'){

              $('#title-data-developer','#edit').hide();
              $('#tipe_developer','#edit').closest('.control-group').hide();
              $('#nama_penjual_individu','#edit').closest('.control-group').hide();
              $('#nomer_ktp','#edit').closest('.control-group').hide();
              $('#nama_pasangan_developer','#edit').closest('.control-group').hide();
              $('#nama_perusahaan','#edit').closest('.control-group').hide();

              $("input[type='checkbox']","#form_edit").attr('checked',false);
              if(response.check_ktp=='Y'){
                $("#check_ktp","#form_edit").parent().addClass('checked');
                $("#check_ktp","#form_edit").attr('checked',true);
              }else{
                $("#check_ktp","#form_edit").attr('checked',false);
              }
              if(response.check_kk=='Y'){
                $("#check_kk","#form_edit").parent().addClass('checked');
                $("#check_kk","#form_edit").attr('checked',true);
              }else{
                $("#check_kk","#form_edit").attr('checked',false);
              }
              
              if(response.check_cover_buku_tabungan=='Y'){
                $("#check_cover_buku_tabungan","#form_edit").parent().addClass('checked');
                $("#check_cover_buku_tabungan","#form_edit").attr('checked',true);
              }else{
                $("#check_cover_buku_tabungan","#form_edit").attr('checked',false);
              }
              if(response.check_no_rekening=='Y'){
                $("#check_no_rekening","#form_edit").parent().addClass('checked');
                $("#check_no_rekening","#form_edit").attr('checked',true);
              }else{
                $("#check_no_rekening","#form_edit").attr('checked',false);
              }
              if(response.check_slip_gaji=='Y'){
                $("#check_slip_gaji","#form_edit").parent().addClass('checked');
                $("#check_slip_gaji","#form_edit").attr('checked',true);
              }else{
                $("#check_slip_gaji","#form_edit").attr('checked',false);
              }
              if(response.check_sk=='Y'){
                $("#check_sk","#form_edit").parent().addClass('checked');
                $("#check_sk","#form_edit").attr('checked',true);
              }else{
                $("#check_sk","#form_edit").attr('checked',false);
              }
              if(response.check_sertifikat_tanah=='Y'){
                $("#check_sertifikat_tanah","#form_edit").parent().addClass('checked');
                $("#check_sertifikat_tanah","#form_edit").attr('checked',true);
              }else{
                $("#check_sertifikat_tanah","#form_edit").attr('checked',false);
              }
              if(response.check_imb=='Y'){
                $("#check_imb","#form_edit").parent().addClass('checked');
                $("#check_imb","#form_edit").attr('checked',true);
              }else{
                $("#check_imb","#form_edit").attr('checked',false);
              }
              if(response.check_pbb=='Y'){
                $("#check_pbb","#form_edit").parent().addClass('checked');
                $("#check_pbb","#form_edit").attr('checked',true);
              }else{
                $("#check_pbb","#form_edit").attr('checked',false);
              }

              nama_pasangan = response.nama_pasangan;
              if (nama_pasangan!="") {
                status_menikah = '1';
              } else {
                status_menikah = '0';
              }
              $('#nama_pasangan','#form_edit').val(nama_pasangan);
              // 0 tidak menikah, 1=menikah
              if (status_menikah=='0') {
                $('#check_surat_nikah','#form_edit').attr('disabled',true).removeAttr('checked').parent().css({'background':'#eee'});
              } else {
                $('#check_surat_nikah','#form_edit').removeAttr('disabled').removeAttr('checked').parent().removeAttr('style');
                if(response.check_surat_nikah=='Y'){
                  $("#check_surat_nikah","#form_edit").parent().addClass('checked');
                  $("#check_surat_nikah","#form_edit").attr('checked',true);
                }else{
                  $("#check_surat_nikah","#form_edit").attr('checked',false);
                }
              }
              $.uniform.update(); 
              $(".span4_kmg","#form_edit").show();
              $(".span4_kpr","#form_edit").hide();
            }
            /*
            | END PRODUK KMG
            | ADDENDUM BY UI
            | 24 JULI 2015
            */ 

            /*
            | BEGIN PRODUK KPR
            | ADDENDUM BY UI
            | 24 JULI 2015
            */ 
            if(response.product_code=='56'){

              $('#title-data-developer','#form_edit').show();
              $('#tipe_developer','#form_edit').closest('.control-group').show();
              $('#nama_penjual_individu','#form_edit').closest('.control-group').show();
              $('#nomer_ktp','#form_edit').closest('.control-group').show();
              $('#nama_pasangan_developer','#form_edit').closest('.control-group').show();
              $('#nama_perusahaan','#form_edit').closest('.control-group').show();

              $("input[type='checkbox']","#form_edit").attr('checked',false);
              if(response.kpr_check_npwp_pemohon=='Y'){
                $("#kpr_check_npwp_pemohon","#form_edit").parent().addClass('checked');
                $("#kpr_check_npwp_pemohon","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_npwp_pemohon","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_ktp_pemohon=='Y'){
                $("#kpr_check_ktp_pemohon","#form_edit").parent().addClass('checked');
                $("#kpr_check_ktp_pemohon","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_ktp_pemohon","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_kartu_keluarga=='Y'){
                $("#kpr_check_kartu_keluarga","#form_edit").parent().addClass('checked');
                $("#kpr_check_kartu_keluarga","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_kartu_keluarga","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_slip_gaji=='Y'){
                $("#kpr_check_slip_gaji","#form_edit").parent().addClass('checked');
                $("#kpr_check_slip_gaji","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_slip_gaji","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_buku_tabungan=='Y'){
                $("#kpr_check_buku_tabungan","#form_edit").parent().addClass('checked');
                $("#kpr_check_buku_tabungan","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_buku_tabungan","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_perjanjian=='Y'){
                $("#kpr_check_surat_perjanjian","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_perjanjian","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_perjanjian","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_sertifikat_tanah=='Y'){
                $("#kpr_check_sertifikat_tanah","#form_edit").parent().addClass('checked');
                $("#kpr_check_sertifikat_tanah","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_sertifikat_tanah","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_imb=='Y'){
                $("#kpr_check_surat_imb","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_imb","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_imb","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_pbb=='Y'){
                $("#kpr_check_pbb","#form_edit").parent().addClass('checked');
                $("#kpr_check_pbb","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_pbb","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_npwp_penjual=='Y'){
                $("#kpr_check_npwp_penjual","#form_edit").parent().addClass('checked');
                $("#kpr_check_npwp_penjual","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_npwp_penjual","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_ktp_pasangan=='Y'){
                $("#kpr_check_ktp_pasangan","#form_edit").parent().addClass('checked');
                $("#kpr_check_ktp_pasangan","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_ktp_pasangan","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_kk_penjual=='Y'){
                $("#kpr_check_kk_penjual","#form_edit").parent().addClass('checked');
                $("#kpr_check_kk_penjual","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_kk_penjual","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_nikah=='Y'){
                $("#kpr_check_surat_nikah","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_nikah","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_nikah","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_cerai=='Y'){
                $("#kpr_check_surat_cerai","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_cerai","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_cerai","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_penetapan=='Y'){
                $("#kpr_check_surat_penetapan","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_penetapan","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_penetapan","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_kematian=='Y'){
                $("#kpr_check_surat_kematian","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_kematian","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_kematian","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_waris=='Y'){
                $("#kpr_check_surat_waris","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_waris","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_waris","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_npwp_developer=='Y'){
                $("#kpr_check_npwp_developer","#form_edit").parent().addClass('checked');
                $("#kpr_check_npwp_developer","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_npwp_developer","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_ktp_developer=='Y'){
                $("#kpr_check_ktp_developer","#form_edit").parent().addClass('checked');
                $("#kpr_check_ktp_developer","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_ktp_developer","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_akta_developer=='Y'){
                $("#kpr_check_akta_developer","#form_edit").parent().addClass('checked');
                $("#kpr_check_akta_developer","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_akta_developer","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_siup=='Y'){
                $("#kpr_check_siup","#form_edit").parent().addClass('checked');
                $("#kpr_check_siup","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_siup","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_surat_pencairan=='Y'){
                $("#kpr_check_surat_pencairan","#form_edit").parent().addClass('checked');
                $("#kpr_check_surat_pencairan","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_surat_pencairan","#form_edit").attr('checked',false);
              }

              if(response.kpr_check_ktp_pasangan_pemohon=='Y'){
                $("#kpr_check_ktp_pasangan_pemohon","#form_edit").parent().addClass('checked');
                $("#kpr_check_ktp_pasangan_pemohon","#form_edit").attr('checked',true);
              }else{
                $("#kpr_check_ktp_pasangan_pemohon","#form_edit").attr('checked',false);
              }

              nama_pasangan_kpr = response.nama_pasangan;
              if (nama_pasangan_kpr!="") {
                status_menikah_kpr = '1';
              } else {
                status_menikah_kpr = '0';
              }
              $('#nama_pasangan_kpr','#form_edit').val(nama_pasangan_kpr);
              // 0 tidak menikah, 1=menikah
              if (status_menikah_kpr=='0') {
                $('#kpr_check_surat_nikah_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent().css({'background':'#eee'});
              } else {
                $('#kpr_check_surat_nikah_pemohon','#form_edit').removeAttr('disabled').removeAttr('checked').parent().removeAttr('style');
                if(response.kpr_check_surat_nikah_pemohon=='Y'){
                  $("#kpr_check_surat_nikah_pemohon","#form_edit").parent().addClass('checked');
                  $("#kpr_check_surat_nikah_pemohon","#form_edit").attr('checked',true);
                }else{
                  $("#kpr_check_surat_nikah_pemohon","#form_edit").attr('checked',false);
                }
              }
              $.uniform.update();
              $(".span4_kmg","#form_edit").hide();
              $(".span4_kpr","#form_edit").show();
            }
            /*
            | END PRODUK KPR
            | ADDENDUM BY UI
            | 24 JULI 2015
            */ 

          }
        })

      });
      
      $("#tipe_jaminan","#edit").change(function(){
        tipe = $(this).val();
        if(tipe=='1'){ //sertifikat
          $("#div_jenis_surat","#edit").show()
          $("#div_no_imb","#edit").show()
          $("#div_tanggal_imb","#edit").show()
          $("#div_tanggal_surat_jaminan","#edit").hide()
          $("#div_nop","#edit").show()
        }else{ //bpkb
          $("#div_jenis_surat","#edit").hide()
          $("#div_no_imb","#edit").hide()
          $("#div_tanggal_imb","#edit").hide()
          $("#div_tanggal_surat_jaminan","#edit").show()
          $("#div_nop","#edit").hide()
        }
      });

      $("#form_edit select[name='provinsi2']").change(function(){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/search_kota_by_provinsi",
            data: {provinsi_code:$(this).val()},
            dataType: "json",
            async: false,
            success: function(response){
              var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].city_code+'">'+response[i].city+'</option>';
                }
              // console.log(option);
              $("#kota2").html(option).trigger('liszt:updated');
            }
          });
      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              province_code: {
                  required: true
              },
              city_code: {
                  required: true
              },
              city_abbr: {
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
                  .closest('.control-group').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
              label
                  // .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error'); // set success class to the control group
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/update_data_jaminan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  App.SuccessAlert('Data Berhasil diedit',function(){
                    success2.show();
                    error2.hide();
                    form2.children('div').removeClass('success');
                    $("#jaminan_table_filter input").val('');
                    dTreload();
                    $("#cancel",form_edit).trigger('click')
                  });
                }else{
                  App.ErrorAlert('Internal Server Error!',function(){
                    success2.hide();
                    error2.show();  
                  })
                }
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });





      $("#btn_delete").click(function(){

        var id_jaminan = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          id_jaminan[$i] = $(this).val();

          $i++;

        });

        if(id_jaminan.length==0){
          alert("Please select some row to delete !");
        }else{
          App.ConfirmAlert('Are you sure to delete this rows ?',function(){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/delete_jaminan",
              dataType: "json",
              data: {id_jaminan:id_jaminan},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Something error. please contact your administrator !");
                  dTreload();
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          });
        }

      });


      // begin first table
      $('#jaminan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_data_jaminan",
          "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "src_product", "value": $("#src_product").val() } );
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

      jQuery('#jaminan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#jaminan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown


      /*
      | ADDENDUM / PENAMBAHAN
      | BEGIN EVENT UNTUK ATAS NAMA
      | 7 JULI 2015
      | UJANG IRAWAN
      */
      $("a#tambah_an","#form_add").click(function(){
        $("#div_atasnama","#form_add").show();
        $("#tambah_an","#form_add").hide();
        $("#remove_an","#form_add").show();
      });

      $("a#remove_an","#form_add").click(function(){
        $("#div_atasnama","#form_add").hide();
        $("#tambah_an","#form_add").show();
        $("#remove_an","#form_add").hide();
        $("#atas_nama2","#form_add").val('');
        $("#atas_nama3","#form_add").val('');
      });

      $("a#tambah_an","#form_edit").click(function(){
        $("#div_atasnama","#form_edit").show();
        $("#tambah_an","#form_edit").hide();
        $("#remove_an","#form_edit").show();
      });

      $("a#remove_an","#form_edit").click(function(){
        $("#div_atasnama","#form_edit").hide();
        $("#tambah_an","#form_edit").show();
        $("#remove_an","#form_edit").hide();
        $("#atas_nama2","#form_edit").val('');
        $("#atas_nama3","#form_edit").val('');
      });
      /*
      | ADDENDUM / PENAMBAHAN
      | END EVENT UNTUK ATAS NAMA
      | 7 JULI 2015
      | UJANG IRAWAN
      */

      /*
      | ADDENDUM / PENAMBAHAN
      | BEGIN EVENT UNTUK TIPE PENJUAL ATAU DEVELOPER
      | 24 JULI 2015
      | UJANG IRAWAN
      */
      $("#tipe_developer","#form_add").change(function(){
        var tipe_developer = $(this).val();
        if(tipe_developer=='0'){
          $("#div_individu","#form_add").show();
          $("#div_perusahaan","#form_add").hide();
          $("#nama_perusahaan","#form_add").val('');
          $('#data-individu','#form_add').show();
          $('#data-developer','#form_add').hide();

          /*Enable data individu*/
          $('#kpr_check_npwp_pemohon','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_pemohon','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_pasangan_pemohon','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_kartu_keluarga','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_nikah_pemohon','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_slip_gaji','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_buku_tabungan','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_perjanjian','#form_add').attr('disabled',false).removeAttr('checked').parent();

          /*Disable data developer*/
          $('#kpr_check_npwp_developer','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_developer','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_akta_developer','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_siup','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_pencairan','#form_add').attr('disabled',true).removeAttr('checked').parent();

          $.uniform.update(); 
        }else if(tipe_developer=='1'){
          $("#div_individu","#form_add").hide();
          $("#div_perusahaan","#form_add").show();
          $("#nama_penjual_individu","#form_add").val('');
          $("#nomer_ktp","#form_add").val('');
          $("#nama_pasangan_developer","#form_add").val('');
          $('#data-individu','#form_add').hide();
          $('#data-developer','#form_add').show();

          /*Disable data individu*/
          $('#kpr_check_npwp_pemohon','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_pemohon','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_pasangan_pemohon','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_kartu_keluarga','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_nikah_pemohon','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_slip_gaji','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_buku_tabungan','#form_add').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_perjanjian','#form_add').attr('disabled',true).removeAttr('checked').parent();

          /*Enable data developer*/
          $('#kpr_check_npwp_developer','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_developer','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_akta_developer','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_siup','#form_add').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_pencairan','#form_add').attr('disabled',false).removeAttr('checked').parent();

          $.uniform.update(); 
        }else{
          $("#div_individu","#form_add").hide();
          $("#div_perusahaan","#form_add").hide();
          $("#nama_perusahaan","#form_add").val('');
          $("#nama_penjual_individu","#form_add").val('');
          $("#nomer_ktp","#form_add").val('');
          $("#nama_pasangan_developer","#form_add").val('');

          $.uniform.update(); 
        }
      });

      $("#tipe_developer","#form_edit").change(function(){
        var tipe_developer = $(this).val();
        if(tipe_developer=='0'){
          $("#div_individu","#form_edit").show();
          $("#div_perusahaan","#form_edit").hide();
          $("#nama_perusahaan","#form_edit").val('');
          $('#data-individu','#form_edit').show();
          $('#data-developer','#form_edit').hide();

          /*Enable data individu*/
          $('#kpr_check_npwp_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_pasangan_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_kartu_keluarga','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_nikah_pemohon','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_slip_gaji','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_buku_tabungan','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_perjanjian','#form_edit').attr('disabled',false).removeAttr('checked').parent();

          /*Disable data developer*/
          $('#kpr_check_npwp_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_akta_developer','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_siup','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_pencairan','#form_edit').attr('disabled',true).removeAttr('checked').parent();

          $.uniform.update(); 
        }else if(tipe_developer=='1'){
          $("#div_individu","#form_edit").hide();
          $("#div_perusahaan","#form_edit").show();
          $("#nama_penjual_individu","#form_edit").val('');
          $("#nomer_ktp","#form_edit").val('');
          $("#nama_pasangan_developer","#form_edit").val('');
          $('#data-individu','#form_edit').hide();
          $('#data-developer','#form_edit').show();

          /*Disable data individu*/
          $('#kpr_check_npwp_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_ktp_pasangan_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_kartu_keluarga','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_nikah_pemohon','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_slip_gaji','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_buku_tabungan','#form_edit').attr('disabled',true).removeAttr('checked').parent();
          $('#kpr_check_surat_perjanjian','#form_edit').attr('disabled',true).removeAttr('checked').parent();

          /*Enable data developer*/
          $('#kpr_check_npwp_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_ktp_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_akta_developer','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_siup','#form_edit').attr('disabled',false).removeAttr('checked').parent();
          $('#kpr_check_surat_pencairan','#form_edit').attr('disabled',false).removeAttr('checked').parent();

          $.uniform.update(); 
        }else{
          $("#div_individu","#form_edit").hide();
          $("#div_perusahaan","#form_edit").hide();
          $("#nama_perusahaan","#form_edit").val('');
          $("#nama_penjual_individu","#form_edit").val('');
          $("#nomer_ktp","#form_edit").val('');
          $("#nama_pasangan_developer","#form_edit").val('');

          $.uniform.update(); 
        }
      });
      /*
      | ADDENDUM / PENAMBAHAN
      | END EVENT UNTUK TIPE PENJUAL ATAU DEVELOPER
      | 24 JULI 2015
      | UJANG IRAWAN
      */

      $("#src_product").change(function(){
        dTreload();
      })
});
</script>
<!-- END JAVASCRIPTS -->

