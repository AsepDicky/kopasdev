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


<!-- BEGIN FORM SKOR -->

<div id="dialog_scoring" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;" data-keyboard="false" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Formulir Penentuan Scoring Pengajuan</h3>
  </div>
  <div class="modal-body">

    <form method="post" id="form_scoring" style="margin-bottom:0;">
    <input type="hidden" name="registration_no" id="registration_no">
    <div class="tabbable tabbable-custom boxless" style="margin-bottom:0;">
       <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" id="ttab_1" data-toggle="tab">I. Administrasi</a></li>
          <li><a class="" href="#tab_2" id="ttab_2" data-toggle="tab">II. Karakter</a></li>
          <li><a class="" href="#tab_3" id="ttab_3" data-toggle="tab">III. Usaha</a></li>
          <li><a class="" href="#tab_4" id="ttab_4" data-toggle="tab">IV. ASET</a></li>
          <li><a class="" href="#tab_5" id="ttab_5" data-toggle="tab">V. Skor</a></li>
       </ul>

      <div class="tab-content">
        
        <div class="tab-pane active tab-scoring" id="tab_1">

          <div class="row-fluid">
             <div class="span12">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">I. ADMINISTRASI KELENGKAPAN DOKUMEN</div>
                <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="5" class="table-scoring">
                  <tr>
                    <td align="center" style="font-weight:600;">&nbsp;</td>
                    <td align="center" style="font-weight:600;">KOMPONEN YANG DINILAI</td>
                  </tr>
                  <?php foreach($scoringadmkeldoc as $admkeldoc): ?>
                  <tr>
                    <td align="center" width="3%"><input type="checkbox" name="scoringadmkeldoc[]" id="scoringadmkeldoc" value="<?php echo $admkeldoc['code_value'] ?>"></td>
                    <td width="97%"><?php echo $admkeldoc['display_text'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </table>
                <div style="padding:5px;font-weight:bold;display:none;">Skor : <span id="skor_administrasi">0</span></div>
             </div>
          </div>

        </div>
        <!-- END TAB 1 -->

        <div class="tab-pane tab-scoring" id="tab_2">

          <div class="row-fluid">
             <div class="span12">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">II. KARAKTER CALON DEBITUR</div>
                <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="5" class="table-scoring">
                  <tr>
                    <td align="center" style="font-weight:600;">NO</td>
                    <td align="center" style="font-weight:600;">KOMPONEN YANG DINILAI</td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">1</td>
                    <td width="50%">Pendidikan</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <?php foreach($scoringpendidikan as $pendidikan): ?>
                      <label><input type="radio" name="scoringpendidikan" id="scoringpendidikan" value="<?php echo $pendidikan['code_value'] ?>"> &nbsp;<?php echo $pendidikan['display_text'] ?></label>
                      <?php endforeach; ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">2</td>
                    <td width="50%">Pemahaman Kewirausahaan & Managerial</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <?php foreach($scoringpemkewman as $pemkewman): ?>
                      <label><input type="radio" name="scoringpemkewman" id="scoringpemkewman" value="<?php echo $pemkewman['code_value'] ?>"> &nbsp;<?php echo $pemkewman['display_text'] ?></label>
                      <?php endforeach; ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">3</td>
                    <td width="50%">Pengalaman Berusaha</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <?php foreach($scoringpnglmnusaha as $pnglmnusaha): ?>
                      <label><input type="radio" name="scoringpnglmnusaha" id="scoringpnglmnusaha" value="<?php echo $pnglmnusaha['code_value'] ?>"> &nbsp;<?php echo $pnglmnusaha['display_text'] ?></label>
                      <?php endforeach; ?>
                    </td>
                  </tr>
                </table>
                <div style="padding:5px;font-weight:bold;display:none;">Skor : <span id="skor_karakter">0</span></div>

             </div>
          </div>

        </div>
        <!-- END TAB 2 -->

        <div class="tab-pane tab-scoring" id="tab_3">

          <div class="row-fluid">
             <div class="span12">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">III. USAHA PRODUKTIF</div>
                <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="5" class="table-scoring">
                  <tr>
                    <td align="center" style="font-weight:600;">NO</td>
                    <td align="left" style="font-weight:600;" colspan="2">KOMPONEN YANG DINILAI</td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">1</td>
                    <td width="30%">Tempat Usaha</td>
                    <td align="left">
                      <select name="scoringtempatusaha" id="scoringtempatusaha" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringtempatusaha as $tempatusaha): ?>
                        <option value="<?php echo $tempatusaha['code_value'] ?>"><?php echo $tempatusaha['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">2</td>
                    <td width="30%">Lokasi Usaha</td>
                    <td align="left">
                      <select name="scoringlokasiusaha" id="scoringlokasiusaha" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringlokasiusaha as $lokasiusaha): ?>
                        <option value="<?php echo $lokasiusaha['code_value'] ?>"><?php echo $lokasiusaha['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">3</td>
                    <td width="30%">Kegiatan Usaha</td>
                    <td align="left">
                      <select name="scoringkegiatanusaha" id="scoringkegiatanusaha" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringkegiatanusaha as $kegiatanusaha): ?>
                        <option value="<?php echo $kegiatanusaha['code_value'] ?>"><?php echo $kegiatanusaha['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">4</td>
                    <td width="30%">Hubungan Usaha</td>
                    <td align="left">
                      <select name="scoringhubunganusaha" id="scoringhubunganusaha" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringhubunganusaha as $hubunganusaha): ?>
                        <option value="<?php echo $hubunganusaha['code_value'] ?>"><?php echo $hubunganusaha['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">5</td>
                    <td width="30%">Lama Berusaha</td>
                    <td align="left">
                      <select name="scoringlamaberusaha" id="scoringlamaberusaha" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringlamaberusaha as $lamaberusaha): ?>
                        <option value="<?php echo $lamaberusaha['code_value'] ?>"><?php echo $lamaberusaha['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                </table>
                <div style="padding:5px;font-weight:bold;display:none;">Skor : <span id="skor_usaha">0</span></div>

             </div>
          </div>

        </div>
        <!-- END TAB 3 -->

        <div class="tab-pane tab-scoring" id="tab_4">

          <div class="row-fluid">
             <div class="span12">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">IV. ASET / KEKAYAAN BERSIH</div>
                <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="5" class="table-scoring">
                  <tr>
                    <td align="center" style="font-weight:600;">NO</td>
                    <td align="center" style="font-weight:600;">KOMPONEN YANG DINILAI</td>
                    <td align="center" style="font-weight:600;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">1</td>
                    <td width="40%">Harta tetap yang dimiliki</td>
                    <td align="left">
                      <select name="scoringhartatetap" id="scoringhartatetap" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringhartatetap as $hartatetap): ?>
                        <option value="<?php echo $hartatetap['code_value'] ?>"><?php echo $hartatetap['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" width="3%">2</td>
                    <td width="40%">Harta Lancar</td>
                    <td align="left">
                      <select name="scoringhartalancar" id="scoringhartalancar" class="m-wrap" style="width:100% !important">
                        <option value="">Pilih</option>
                        <?php foreach($scoringhartalancar as $hartalancar): ?>
                        <option value="<?php echo $hartalancar['code_value'] ?>"><?php echo $hartalancar['display_text'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                  </tr>
                </table>
                <div style="padding:5px;font-weight:bold;display:none;">Skor : <span id="skor_aset">0</span></div>

             </div>
          </div>

        </div>
        <!-- END TAB 4 -->

        <div class="tab-pane tab-scoring" id="tab_5">

          <div class="row-fluid">
             <div class="span12">
                <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">V. Rekomendasi Dari Hasil Scoring</div>
                <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="0" class="table-scoring">
                  <tr>
                    <td width="170">
                      <div align="center" style="font-size:12px;font-weight:bold;">Total Score Sebesar</div>
                      <div align="center" style="color:red;font-weight:bold;font-size:15px;margin-bottom: 10px;margin-top: 3px;" id="txt_total_skor">0</div>
                      <input type="hidden" name="total_skor" id="total_skor" value="0">
                      <div id="ket_score" align="center" style="background: rgb(73, 128, 226);margin: 0 7px;color:white;border: solid 1px #1A4797;border-radius: 5px !important;line-height: 16px;padding: 4px;">NULL</div>
                    </td>
                    <td>
                      <table width="100%">
                        <tr>
                          <td align="center" style="border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;font-weight:bold;">Skoring<br>Terbobot</td>
                          <td align="center" style="border-bottom:solid 1px #CCC;font-weight:bold;">Rekomendasi</td>
                        </tr>
                        <tr>
                          <td align="center" style="border-right:solid 1px #CCC;padding:5px;">
                            > 450 <br>
                            351 s/d 450 <br>
                            301 s/d 350 <br>
                            201 s/d 300 <br>
                            < 200
                          </td>
                          <td style="padding:5px;">
                            Sangat Layak Diberikan Kredit <br>
                            Layak diberikan kredit <br>
                            Dapat diberikan kredit <br>
                            Dapat diberikan dengan tambahan jaminan fsik <br>
                            Tidak dapat diberikan <br>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
             </div>
          </div>

        </div>
        <!-- END TAB 5 -->

      </div>
      
      </form>

    </div> <!-- END TAB -->

  </div>
  <div class="modal-footer">
    <button type="button" id="close"  class="btn" data-dismiss="modal">Close</button>
    <button type="button" id="next_1" class="btn green">Selanjutnya</button>
    <button type="button" id="next_2" class="hide btn green">Selanjutnya</button>
    <button type="button" id="next_3" class="hide btn green">Selanjutnya</button>
    <button type="button" id="next_4" class="hide btn green">Selanjutnya</button>
    <button type="button" id="proses" class="hide btn blue">OK</button>
  </div>
</div>
<a id="browse_scoring" class="btn blue hide" data-toggle="modal" href="#dialog_scoring">...</a>

<!-- END FORM SKOR -->

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
               <th width="18%">No. Pengajuan</th>
               <th width="25%">Nama Lengkap</th>
               <th width="15%">Tgl Pengajuan</th>
               <!-- <th width="17%">Rencana Droping</th> -->
               <th width="18%">Amount</th>
               <th width="15%">Peruntukan</th>
               <th width="5%">Skor</th>
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
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>        
                    <div class="control-group">
                       <label class="control-label">Petugas <span class="required">*</span></label>
                       <div class="controls">
                         <select name="petugas" id="petugas" class="medium m-wrap chosen" data-required="1">    
                            <option value="">PILIH</option>
                            <?php foreach ($petugas as $key):?>
                              <option value="<?php echo $key['fa_code'];?>"><?php echo $key['fa_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Resort <span class="required">*</span></label>
                       <div class="controls">
                         <select name="resort_code" id="resort_code" class="medium m-wrap chosen" data-required="1">    
                            <option value="">PILIH</option>
                            <?php foreach ($resorts as $resort):?>
                              <option value="<?php echo $resort['resort_code'];?>"><?php echo $resort['resort_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                      <input type="hidden" id="cif_type_hidden" name="cif_type_hidden">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <span class="required">*</span><br><small>(Sesuai KTP)</small></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        Tanggal Lahir<span class="required">*</span>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>  
                    <hr>                 
                    
                    <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="pyd" id="pyd" maxlength="3">
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <select id="product_code" name="product_code" class="m-wrap">
                             <option value="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka" id="uang_muka" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
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
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" value="<?php echo $date;?>" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Gabung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_gabung_cif" style="width:120px;" id="tanggal_gabung_cif" readonly="" data-required="1" class="small m-wrap"/>
                       </div>
                    </div> 
                    <div id="plan_droping" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
                         <div class="controls">
                            <input type="text" name="rencana_droping" id="mask_date" value="<?php echo $tanggal_pencairan;?>" class="date-picker small m-wrap"/>
                         </div>
                      </div>  
                    </div>
                    <div class="control-group">
                       <div class="controls">
                          <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
                       </div>
                    </div>                        
            <div class="form-actions">
              <input type="hidden" name="status_financing_reg" id="status_financing_reg">
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
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit PEngajuan PEmbiayaan Berhasil!
            </div>
          </br>         
                    <div class="control-group">
                       <label class="control-label">Petugas <span class="required">*</span></label>
                       <div class="controls">
                         <select name="petugas2" id="petugas2" class="medium m-wrap chosen" data-required="1">  
                            <option value="">PILIH</option>  
                            <?php foreach ($petugas as $key):?>
                              <option value="<?php echo $key['fa_code'];?>"><?php echo $key['fa_code'].' - '.$key['fa_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 

                    <div class="control-group">
                       <label class="control-label">Resort <span class="required">*</span></label>
                       <div class="controls">
                         <select name="resort_code2" id="resort_code2" class="medium m-wrap chosen" data-required="1">    
                            <option value="">PILIH</option>
                            <?php foreach ($resorts as $resort):?>
                              <option value="<?php echo $resort['resort_code'];?>"><?php echo $resort['resort_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div>

                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code" name="branch_code">
                          
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <br><small>(Sesuai KTP)</small><span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>   
                    <hr>            

                     <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="pyd2" id="pyd2" maxlength="3">
                        </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <select id="product_code2" name="product_code2" class="m-wrap">
                             <option value="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka2" id="uang_muka2" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount2" id="amount2" maxlength="15" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>                            
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan2" id="peruntukan2" class="medium m-wrap" data-required="1">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium"></textarea>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan2" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Gabung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_gabung_cif" style="width:120px;" id="tanggal_gabung_cif" readonly="" data-required="1" class="small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group" style="display:none">
                       <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_droping2" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <div class="controls">
                          <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
                       </div>
                    </div>             
            <div class="form-actions">
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
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

/*BEGIN CALCULATE SCORING*/
global_score_administrasi=0;
global_score_karakter=0;
global_score_usaha=0;
global_score_aset=0;
global_score_total=0;

var bobot_administrasi=5;
var bobot_scoringpnglmnusaha=10;
var bobot_scoringpemkewman=10;
var bobot_scoringpendidikan=10;
var bobot_scoringtempatusaha=10;
var bobot_scoringlokasiusaha=10;
var bobot_scoringkegiatanusaha=10;
var bobot_scoringhubunganusaha=10;
var bobot_scoringlamaberusaha=10;
var bobot_scoringhartatetap=10;
var bobot_scoringhartalancar=5;

$("input#scoringadmkeldoc","#tab_1").click(function(e){
  var jumlah_dokumen=$("input#scoringadmkeldoc:checked","#tab_1").length;
  if(jumlah_dokumen>=10){
    global_score_administrasi=5;
  }else if(jumlah_dokumen==8 || jumlah_dokumen==9){
    global_score_administrasi=4;
  }else if(jumlah_dokumen==6 || jumlah_dokumen==7){
    global_score_administrasi=3;
  }else if(jumlah_dokumen==4 || jumlah_dokumen==5){
    global_score_administrasi=2;
  }else{
    global_score_administrasi=1;
  }
  global_score_administrasi=global_score_administrasi*bobot_administrasi;
  $("#skor_administrasi","#tab_1").text(global_score_administrasi);
  calc_score_total();
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})

$("input#scoringpendidikan,input#scoringpemkewman,input#scoringpnglmnusaha","#tab_2").click(function(){
  calc_score_karakter();
  calc_score_total();
  $("#skor_karakter","#tab_2").text(global_score_karakter);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})
$("select#scoringtempatusaha,select#scoringlokasiusaha,select#scoringkegiatanusaha,select#scoringhubunganusaha,select#scoringlamaberusaha","#tab_3").change(function(){
  calc_score_usaha();
  calc_score_total();
  $("#skor_usaha","#tab_3").text(global_score_usaha);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})
$("select#scoringhartatetap,select#scoringhartalancar","#tab_4").change(function(){
  calc_score_aset();
  calc_score_total();
  $("#skor_aset","#tab_4").text(global_score_aset);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})

function calc_score_karakter()
{
  var scoringpnglmnusaha=(isNaN(parseFloat($("input#scoringpnglmnusaha:checked").val()))==true)?0:parseFloat($("input#scoringpnglmnusaha:checked").val());
  scoringpnglmnusaha=scoringpnglmnusaha*bobot_scoringpnglmnusaha;
  var scoringpemkewman=(isNaN(parseFloat($("input#scoringpemkewman:checked").val()))==true)?0:parseFloat($("input#scoringpemkewman:checked").val());
  scoringpemkewman=scoringpemkewman*bobot_scoringpemkewman;
  var scoringpendidikan=(isNaN(parseFloat($("input#scoringpendidikan:checked").val()))==true)?0:parseFloat($("input#scoringpendidikan:checked").val());
  scoringpendidikan=scoringpendidikan*bobot_scoringpendidikan;
  global_score_karakter=scoringpendidikan+scoringpemkewman+scoringpnglmnusaha;
}
function calc_score_usaha()
{
  var scoringtempatusaha=parseFloat(($("select#scoringtempatusaha").val()=="")?0:$("select#scoringtempatusaha").val());
  scoringtempatusaha=scoringtempatusaha*bobot_scoringtempatusaha;
  var scoringlokasiusaha=parseFloat(($("select#scoringlokasiusaha").val()=="")?0:$("select#scoringlokasiusaha").val());
  scoringlokasiusaha=scoringlokasiusaha*bobot_scoringlokasiusaha;
  var scoringkegiatanusaha=parseFloat(($("select#scoringkegiatanusaha").val()=="")?0:$("select#scoringkegiatanusaha").val());
  scoringkegiatanusaha=scoringkegiatanusaha*bobot_scoringkegiatanusaha;
  var scoringhubunganusaha=parseFloat(($("select#scoringhubunganusaha").val()=="")?0:$("select#scoringhubunganusaha").val());
  scoringhubunganusaha=scoringhubunganusaha*bobot_scoringhubunganusaha;
  var scoringlamaberusaha=parseFloat(($("select#scoringlamaberusaha").val()=="")?0:$("select#scoringlamaberusaha").val());
  scoringlamaberusaha=scoringlamaberusaha*bobot_scoringlamaberusaha;
  global_score_usaha=scoringtempatusaha+scoringlokasiusaha+scoringkegiatanusaha+scoringhubunganusaha+scoringlamaberusaha;
}
function calc_score_aset()
{
  var scoringhartatetap=parseFloat(($("select#scoringhartatetap").val()=="")?0:$("select#scoringhartatetap").val());
  scoringhartatetap=scoringhartatetap*bobot_scoringhartatetap;
  var scoringhartalancar=parseFloat(($("select#scoringhartalancar").val()=="")?0:$("select#scoringhartalancar").val());
  scoringhartalancar=scoringhartalancar*bobot_scoringhartalancar;
  global_score_aset=scoringhartatetap+scoringhartalancar
}
function calc_score_total()
{
  global_score_total=global_score_administrasi+global_score_karakter+global_score_usaha+global_score_aset;
  ket_score='NULL';
  if(global_score_total>450){
    ket_score='Sangat Layak Diberikan Kredit';
  }else if(global_score_total>=351 && global_score_total<=450){
    ket_score='Layak Diberikan Kredit';
  }else if(global_score_total>=301 && global_score_total<=350){
    ket_score='Dapat Diberikan Kredit';
  }else if(global_score_total>=201 && global_score_total<=300){
    ket_score='Dapat diberikan dengan tambahan jaminan fsik';
  }else if(global_score_total<=200){
    ket_score='Tidak dapat diberikan';
  }
  $("#ket_score","#tab_5").text(ket_score);
}


/*END CALCULATE SCORING*/

/*BEGIN TAB SCORING*/
$("#next_1").live('click',function(){
  $("#ttab_2").click();
  $(this).hide();
  $("#next_2").show();
  App.scrollTo(0,0);
})
$("#next_2").live('click',function(){
  $("#ttab_3").click();
  $(this).hide();
  $("#next_3").show();
  App.scrollTo(0,0);
})
$("#next_3").live('click',function(){
  $("#ttab_4").click();
  $(this).hide();
  $("#next_4").show();
  App.scrollTo(0,0);
})
$("#next_4").live('click',function(){
  $("#ttab_5").click();
  $(this).hide();
  $("#proses").show();
  App.scrollTo(0,0);
})
$("#ttab_1").click(function(){
  $("#next_1").show();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_2").click(function(){
  $("#next_1").hide();
  $("#next_2").show();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_3").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").show();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_4").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").show();
  $("#proses").hide();
})
$("#ttab_5").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").show();
})
/*END TAB SCORING*/

function reset_form_scoring()
{
  $("input#scoringadmkeldoc","#dialog_scoring").attr('checked',false); $("input#scoringadmkeldoc","#dialog_scoring").parent().removeAttr('class');
  $("input[type='radio']:checked","#dialog_scoring").attr('checked',false);
  $("select","#dialog_scoring").val('');
  $("#txt_total_skor").text('0'); $("#total_skor").val(0); $("#ket_score").text('NULL');

  global_score_administrasi=0;
  global_score_karakter=0;
  global_score_usaha=0;
  global_score_aset=0;
  global_score_total=0;
}

/*BEGIN PROSES SCORING*/

$("#proses","#dialog_scoring").click(function(e){
  $.ajax({
    type: "POST",
    url: site_url+'rekening_nasabah/proses_scoring_pembiayaan',
    dataType: "json",
    data: $("form#form_scoring").serialize(),
    success: function(response){
      if(response.success==true){
        alert('Scoring have been processed');
        reset_form_scoring();
        dTreload();
        $("#close","#dialog_scoring").trigger('click');
        App.scrollTo(form1, -200);
      }else{
        alert("Failed to Connect into Database, Please Contact Your Administrator!");
      }
    },
    error:function(){
      alert("Failed to Connect into Database, Please Contact Your Administrator!");
      App.scrollTo(form1, -200);
    }
  });
})

/*END PROSES SCORING*/


$("a#btnSkor").live('click',function(){
  registration_no=$(this).attr('registration_no');
  reset_form_scoring();
  $("#browse_scoring").trigger('click');
  $("#registration_no","#dialog_scoring").val(registration_no);
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
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          // ignore: "",
          rules: {
              cif_no: {
                  required: true
              },
              uang_muka: {
                  required: true
              },
              amount: {
                  required: true
              },
              peruntukan: {
                  required: true
              },
              rencana_droping: {
                  required: true
              },
              tanggal_pengajuan: {
                  required: true
              },
              pyd: {
                  required: true,number:true
              },
              product_code: {
                  required: true
              },
              keterangan: {
                  required: true
              },
              petugas: {
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
            var cif_no = $("#cif_no","#form_add").val().replace(/\//g,'');
            // $.ajax({
            //   type: "POST",
            //   dataType: "json",
            //   async:false,
            //   data: {cif_no:cif_no},
            //   url: site_url+"transaction/get_status_pengajuan_pembiayaan",
            //   success: function(response1)
            //   {
            //     $("#status_pengajuan","#form_add").val(response1.status);
            //   }                 
            // });
            // $.ajax({
            //   type: "POST",
            //   dataType: "json",
            //   async:false,
            //   data: {cif_no:cif_no},
            //   url: site_url+"transaction/get_status_pembiayaan",
            //   success: function(response2)
            //   {
            //     $("#status_rekening_pembiayaan","#form_add").val(response2.status_rekening);
            //   }                 
            // });
            // $.ajax({
            //   type: "POST",
            //   dataType: "json",
            //   async:false,
            //   data: {cif_no:cif_no},
            //   url: site_url+"transaction/count_data_pengajuan_pembiayaan",
            //   success: function(response3)
            //   {
            //     $("#count_pengajuan","#form_add").val(response3.jumlah);
            //   }                 
            // });
            // var data_pengajuan = $("#count_pengajuan","#form_add").val();
            // var status_pengajuan = $("#status_pengajuan","#form_add").val();
            // var status_rekening_pembiayaan = $("#status_rekening_pembiayaan","#form_add").val();
            // if(data_pengajuan>0){
              // alert("Tidak dapat melakukan pengajuan lebih dari satu");
            // }else{
              var tanggal_gabung_cif = $("#tanggal_gabung_cif","#form_add").val().split('/');
              var tanggal_pembukaan = $("#form_add input[name='tanggal_pengajuan']").val().split('/');
              // tanggal_gabung_cif = tanggal_gabung_cif.split('/');
              day_gabung_cif = tanggal_gabung_cif[0];
              month_gabung_cif = tanggal_gabung_cif[1];
              year_gabung_cif = tanggal_gabung_cif[2];
              tanggal_gabung_cif = new Date(year_gabung_cif,month_gabung_cif-1,day_gabung_cif);
              // tanggal_pembukaan = tanggal_pembukaan.split('/');
              day_buka = tanggal_pembukaan[0];
              month_buka = tanggal_pembukaan[1];
              year_buka = tanggal_pembukaan[2];
              tanggal_pembukaan = new Date(year_buka,month_buka-1,day_buka);
              // alert(tanggal_gabung_cif);
              // alert(tanggal_pembukaan);
              // if(status_pengajuan==0){
              //   alert("Tidak dapat melakukan pengajuan (Masih ada data pengajuan yang belum diapprove)");
              // }else 
              // if(status_rekening_pembiayaan!=2){
              //   alert("Tidak dapat melakukan pengajuan (Masih ada data pembiayaan yang belum dilunasi)");
              // }else 
              // alert(tanggal_pembukaan);
              // alert(tanggal_gabung_cif);
              var bValid = true;
              if(tanggal_pembukaan<tanggal_gabung_cif){
                alert("Tanggal pembukaan tidak boleh kurang dari tanggal gabung");
                $("#form_add input[name='tanggal_pengajuan']").css("background-color","yellow");
                bValid = false;
              }else if($("#amount").val()=='0'){
                alert("Jumlah pengajuan tidak boleh nol ");
                bValid = false;
              }
              if($("#status_financing_reg").val()!='0'){
                alert('Tidak dapat dilanjutkan \r\nAnggota masih memiliki pengajuan pembiayaan yang belum diproses');
                bValid = false;
              }
              if(bValid==true){
                $.ajax({
                  type: "POST",
                  url: site_url+"rekening_nasabah/add_pengajuan_pembiayaan",
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
              }
            // }
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

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){        
        form2.trigger('reset');
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
            $("#form_edit input[name='account_financing_reg_id']").val(response.account_financing_reg_id);
            $("#petugas2").val(response.fa_code).trigger('liszt:updated')
            $("#resort_code2").val(response.resort_code).trigger('liszt:updated')
              $.ajax({
                type: "POST",
                dataType: "json",
                async:false,
                data: {cif_no:response.cif_no},
                url: site_url+"transaction/get_ajax_value_from_cif_no",
                success: function(response)
                {
                  $("#nama2").val(response.nama);
                  $("#panggilan2").val(response.panggilan);
                  $("#ibu_kandung2").val(response.ibu_kandung);
                }                 
              });
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit input[name='pyd2']").val(response.pembiayaan_ke);
            $("#form_edit select[name='product_code2']").val(response.product_code);
            $("#form_edit input[name='uang_muka2']").val(response.uang_muka);
            $("#form_edit input[name='amount2']").val(response.amount);
            $("#form_edit select[name='peruntukan2']").val(response.peruntukan);
            $("#form_edit textarea[name='keterangan2']").val(response.description);            
            // if(response.cif_type==0){ // jika tipe cif = kelompok
            //   $("#form_edit input[name='rencana_droping2']").closest('.controls').show();
            //   tg"l_droping = response.rencana_droping.substring(8,12)+''+response.rencana_droping.substring(5,7)+''+response.rencana_droping.substring(0,4);
            //   $(#form_edit input[name='rencana_droping2']").val(tgl_droping);
            // }else{
            //   $("#form_edit input[name='rencana_droping2']").closest('.control-group').hide();
            // }
            
            tgl_pengajuan = response.tanggal_pengajuan.substring(8,12)+''+response.tanggal_pengajuan.substring(5,7)+''+response.tanggal_pengajuan.substring(0,4);
            $("#form_edit input[name='tanggal_pengajuan2']").val(tgl_pengajuan);
            tanggal_gabung_cif = response.tgl_gabung;
            tanggal_gabung_cif = tanggal_gabung_cif.split('-');
            var tanggal_gabung_cif =  tanggal_gabung_cif[2]+'/'+tanggal_gabung_cif[1]+'/'+tanggal_gabung_cif[0];
            $("#form_edit input[name='tanggal_gabung_cif']").val(tanggal_gabung_cif);
          }
        });

      });
        

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          rules: {
              amount2: {
                  required: true
              },
              uang_muka2: {
                  required: true
              },
              peruntukan2: {
                  required: true
              },
              rencana_droping2: {
                  required: true
              },
              tanggal_pengajuan2: {
                  required: true
              },
              pyd2: {
                  required: true,number:true
              },
              product_code2: {
                  required: true
              },
              keterangan: {
                  required: true
              },
              petugas2: {
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

            var tanggal_gabung_cif = $("#tanggal_gabung_cif","#form_edit").val().split('/');
            var tanggal_pembukaan = $("#form_edit input[name='tanggal_pengajuan2']").val().split('/');
            // tanggal_gabung_cif = tanggal_gabung_cif.split('/');
            day_gabung_cif = tanggal_gabung_cif[0];
            month_gabung_cif = tanggal_gabung_cif[1];
            year_gabung_cif = tanggal_gabung_cif[2];
            tanggal_gabung_cif = new Date(year_gabung_cif,month_gabung_cif-1,day_gabung_cif);
            // tanggal_pembukaan = tanggal_pembukaan.split('/');
            day_buka = tanggal_pembukaan[0];
            month_buka = tanggal_pembukaan[1];
            year_buka = tanggal_pembukaan[2];
            tanggal_pembukaan = new Date(year_buka,month_buka-1,day_buka);
            // alert(tanggal_gabung_cif);
            // alert(tanggal_pembukaan);
            if(tanggal_pembukaan<tanggal_gabung_cif){
              alert("Tanggal pembukaan tidak boleh kurang dari tanggal gabung");
              $("#form_edit input[name='tanggal_pengajuan2']").css("background-color","yellow");
            }else if($("#amount2").val()=='0'){
              alert("Jumlah pengajuan tidak boleh nol ");
            }else{

              // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/edit_pengajuan_pembiayaan",
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    success2.show();
                    error2.hide();
                    form2.children('div').removeClass('success');
                    $("#pengajuan_pembiayaan_table_filter input").val('');
                    dTreload();
                    $("#cancel",form_edit).trigger('click')
                    alert('Successfully Updated Data');
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

      // fungsi untuk BATAL PENGAJUAN
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
      $("a#link_tolak").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var registration_no = $(this).attr('registration_no');
          var conf = confirm('Tolak Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/tolak_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id,registration_no:registration_no},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Ditolak!");
                  dTreload();
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


      // begin first table
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pengajuan_pembiayaan_setup",
          "aoColumns": [			      
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": true },
            // { "bSortable": true },
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
                  'aTargets': [0,1]
              }
          ]
      });


      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
          var customer_no = $("#result").val();
          $("#close","#dialog_rembug").trigger('click');
          //alert(customer_no);
          $("#cif_no").val(customer_no);
          //fungsi untuk mendapatkan value untuk field-field yang diperlukan
          var cif_no = customer_no;
          $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            data: {cif_no:cif_no},
            url: site_url+"transaction/get_ajax_value_from_cif_no",
            success: function(response)
            {
              $("#branch_code","#form_add").val(response.branch_code);
              $("#no_cif","#form_add").val(response.cif_no);
              $("#nama","#form_add").val(response.nama);
              $("#panggilan","#form_add").val(response.panggilan);
              $("#ibu_kandung","#form_add").val(response.ibu_kandung);
              tanggal_gabung_cif = response.tgl_gabung;
              tanggal_gabung_cif = tanggal_gabung_cif.split('-');
              var tanggal_gabung_cif =  tanggal_gabung_cif[2]+'/'+tanggal_gabung_cif[1]+'/'+tanggal_gabung_cif[0];
              $("#form_add input[name='tanggal_gabung_cif']").val(tanggal_gabung_cif);
              $("#tmp_lahir","#form_add").val(response.tmp_lahir);
              var tanggal_lahir = response.tgl_lahir;
              if(tanggal_lahir!=null){
                var tgl_lahir = tanggal_lahir.substr(8,2);
                var bln_lahir = tanggal_lahir.substr(5,2);
                var thn_lahir = tanggal_lahir.substr(0,4);
                var tgl_lahir_ = tgl_lahir+"-"+bln_lahir+"-"+thn_lahir;
              }else{
                tgl_lahir_ = "";
              }
              $("#tgl_lahir","#form_add").val(tgl_lahir_);
              $("#usia","#form_add").val(response.usia);
              $("#cif_type_hidden","#form_add").val(response.cif_type);
              var cif_type = response.cif_type;
              if(cif_type==1){
                 $("#plan_droping","#form_add").hide();
              }else{
                 $("#plan_droping","#form_add").show();
              }
              $.ajax({
                url: site_url+"rekening_nasabah/get_pyd_ke",
                type: "POST",
                dataType: "html",
                data: {cif_no:response.cif_no},
                success: function(response)
                {
                  $("#pyd","#form_add").val(response);
                }
              })
              $.ajax({
                url: site_url+"rekening_nasabah/cek_regis_pembiayaan",
                type: "POST",
                dataType: "html",
                data: {cif_no:response.cif_no},
                success: function(response)
                {
                  if (response==0) {
                    $("#status_financing_reg","#form_add").val('0');
                  } else{
                    $("#status_financing_reg","#form_add").val(response);
                  };
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
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
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
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
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
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
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

        //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
        $("a#browse_history",form_add).live('click',function(){
            var cif_no = $("#no_cif").val();
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/history_outstanding_pembiayaan",
                dataType: "json",
                data: {cif_no:cif_no},
                success: function(response){
                  if(response.account_financing_no==undefined){
                    account_financing_no = "Data Terakhir Tidak Ditemukan";
                  }else{
                    account_financing_no = response.account_financing_no;
                  }

                  if(response.saldo_pokok==null){
                    saldo_pokok = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_pokok = response.saldo_pokok;
                  }

                  if(response.saldo_margin==null){
                    saldo_margin = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_margin = response.saldo_margin;
                  }

                  if(response.saldo_catab==null){
                    saldo_catab = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_catab = response.saldo_catab;
                  }
                  $("#history_no_pembiayaan").html(": "+account_financing_no);
                  $("#history_sisa_pokok").html(": Rp. "+number_format(saldo_pokok,0,',','.'));
                  $("#history_sisa_margin").html(": Rp. "+number_format(saldo_margin,0,',','.'));
                  $("#history_sisa_catab").html(": Rp. "+number_format(saldo_catab,0,',','.'));
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });
          
          //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
          $("a#browse_history",form_edit).live('click',function(){
            var cif_no = $("#cif_no2").val();
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/history_outstanding_pembiayaan",
                dataType: "json",
                data: {cif_no:cif_no},
                success: function(response){
                  if(response.account_financing_no==undefined){
                    account_financing_no = "Data Terakhir Tidak Ditemukan";
                  }else{
                    account_financing_no = response.account_financing_no;
                  }

                  if(response.saldo_pokok==null){
                    saldo_pokok = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_pokok = response.saldo_pokok;
                  }

                  if(response.saldo_margin==null){
                    saldo_margin = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_margin = response.saldo_margin;
                  }

                  if(response.saldo_catab==null){
                    saldo_catab = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_catab = response.saldo_catab;
                  }
                  $("#history_no_pembiayaan").html(": "+account_financing_no);
                  $("#history_sisa_pokok").html(": Rp. "+number_format(saldo_pokok,0,',','.'));
                  $("#history_sisa_margin").html(": Rp. "+number_format(saldo_margin,0,',','.'));
                  $("#history_sisa_catab").html(": Rp. "+number_format(saldo_catab,0,',','.'));
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });

          $("input[name='tanggal_pengajuan']","#form_add").change(function(){
            var tgl_pengajuan = $(this).val();
            explode = tgl_pengajuan.split('/');
            var tanggal_pengajuan =  explode[2]+'-'+explode[1]+'-'+explode[0];
            // alert(tanggal_pengajuan);
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tanggal_pengajuan:tanggal_pengajuan},
              url: site_url+"/transaction/get_plan_pencairan",
              success: function(response){
                $("input[name='rencana_droping']","#form_add").val(response.realisasi_pengajuan);
                // alert(response.realisasi_pengajuan);
              }
            });
          });

          $("input[name='tanggal_pengajuan2']","#form_edit").change(function(){
            var tgl_pengajuan = $(this).val();
            explode = tgl_pengajuan.split('/');
            var tanggal_pengajuan =  explode[2]+'-'+explode[1]+'-'+explode[0];
            // alert(tanggal_pengajuan);
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tanggal_pengajuan:tanggal_pengajuan},
              url: site_url+"/transaction/get_plan_pencairan",
              success: function(response){
                $("input[name='rencana_droping2']","#form_edit").val(response.realisasi_pengajuan);
                // alert(response.realisasi_pengajuan);
              }
            });
          });

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

