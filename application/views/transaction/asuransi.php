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
      Insurance <small>Registrasi Peserta Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Isurance</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Peserta Asuransi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Peserta Asuransi</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
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
      <table class="table table-striped table-bordered table-hover" id="insurance_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#insurance_table .checkboxes" /></th>
               <th width="30%">Nomor Rekening</th>
               <th width="30%">Nama</th>
               <th width="25%">Product</th>
               <th width="15%">Status</th>
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
         <div class="caption"><i class="icon-reorder"></i>Registrasi Peserta Asuransi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Insurance has been Created !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" /><input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF NO</h3>
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

                                      <!-- <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                      <option value="">Pilih Tipe CIF</option>
                                      <option value="">All</option>
                                      <option value="1">Individu</option>
                                      <option value="0">Kelompok</option>
                                      </select></p> 
                                      <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->
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
                       <label class="control-label">Nama Lengkap (sesuai KTP)<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product_code" name="product_code" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($product as $data): ?>
                              <option value="<?php echo $data['insurance_type'];?><?php echo $data['rate_type'];?><?php echo $data['product_code'];?><?php echo $data['rate_code'];?>"><?php echo $data['product_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_no" id="account_no" data-required="1" class="medium m-wrap" readonly="" />
                       </div>
                    </div> 
                    <hr>  
                  <div id="type_0" class="hide">  
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak0" id="awal_kontrak0" data-required="1" class="date-picker medium m-wrap"/> sd <input type="text" name="akhir_kontrak0" id="akhir_kontrak0" data-required="1" class="date-picker medium m-wrap"/>
                          &nbsp;&nbsp;<input type="text" id="jumlah_tahun0" name="jumlah_tahun0" data-required="1" style="width:30px;" readonly=""> tahun
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Manfaat Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="small m-wrap mask-money" maxlength="10" name="benefit_value" id="benefit_value">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="small m-wrap mask-money" name="premium_value0" id="premium_value0" readonly="" maxlength="10">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>  
                    <input type="hidden" id="premium_rate0" name="premium_rate0"> 
                  </div>
                  <div id="type_1" class="hide">      
                    <div class="control-group">
                       <label class="control-label">Plan<span class="required">*</span></label>
                       <div class="controls">
                         <select id="plan_code" name="plan_code" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($plan as $data): ?>
                              <option value="<?php echo $data['plan_code'];?><?php echo $data['premium_value'];?>"><?php echo $data['plan_code'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>                           
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value1" id="premium_value1" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak1" id="awal_kontrak1" data-required="1" class="medium m-wrap"/> sd <input type="text" name="akhir_kontrak1" id="akhir_kontrak1" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                  </div>
                    <div class="control-group">
                       <label class="control-label">Rekening Tabungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" name="rekening_tabungan" id="rekening_tabungan" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Nama Pemegang Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" name="nama_pemegang_rek" id="nama_pemegang_rek" data-required="1" class="medium m-wrap"/>
                    <div id="dialog_rembug_bawah" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF NO</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword_bawah" id="keyword_bawah" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="cif_type_bawah" id="cif_type_bawah" class="span12 m-wrap">
                                      <option value="">Pilih Tipe CIF</option>
                                      <option value="">All</option>
                                      <option value="1">Individu</option>
                                      <option value="0">Kelompok</option>
                                      </select></p> 
                                      <p><select name="result_bawah" id="result_bawah" size="7" class="span12 m-wrap"></select></p>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close_bawah" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select_bawah" class="btn blue">Select</button>
                             </div>
                          </div>

                        <a id="browse_rembug_bawah" class="btn blue" data-toggle="modal" href="#dialog_rembug_bawah">...</a>
                       </div>
                    </div>   
                    </div>
                    </div>     
            <div class="form-actions">
               <input type="hidden" id="usia" name="usia">
               <input type="hidden" id="rate_type" name="rate_type">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel1">Back</button>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_insurance_id" name="account_insurance_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Account Successful!
            </div>
          </br>      
                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" /><input type="hidden" id="branch_code" name="branch_code">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap (sesuai KTP)<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir2" id="tmp_lahir2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir2" id="tgl_lahir2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>               
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product_code2" name="product_code2" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($product as $data): ?>
                              <option value="<?php echo $data['insurance_type'];?><?php echo $data['rate_type'];?><?php echo $data['product_code'];?><?php echo $data['rate_code'];?>"><?php echo $data['product_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_no2" id="account_no2" data-required="1" class="medium m-wrap" readonly="" />
                       </div>
                    </div> 
                    <hr>  
                  <div id="type_02" class="hide">  
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak02" id="awal_kontrak02" data-required="1" class="date-picker medium m-wrap"/> sd <input type="text" name="akhir_kontrak0" id="akhir_kontrak0" data-required="1" class="date-picker medium m-wrap"/>
                          &nbsp;&nbsp;<input type="text" id="jumlah_tahun02" name="jumlah_tahun02" data-required="1" style="width:30px;" readonly=""> tahun
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Manfaat Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="small m-wrap mask-money" name="benefit_value2" id="benefit_value2" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="small m-wrap mask-money" name="premium_value02" id="premium_value02" readonly="" maxlength="14">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>  
                    <input type="hidden" id="premium_rate02" name="premium_rate02"> 
                  </div>
                  <div id="type_12" class="hide">      
                    <div class="control-group">
                       <label class="control-label">Plan<span class="required">*</span></label>
                       <div class="controls">
                         <select id="plan_code2" name="plan_code2" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($plan as $data): ?>
                              <option value="<?php echo $data['plan_code'];?><?php echo $data['premium_value'];?>"><?php echo $data['plan_code'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>                           
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value12" id="premium_value12" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak12" id="awal_kontrak12" data-required="1" class="medium m-wrap"/> sd <input type="text" name="akhir_kontrak12" id="akhir_kontrak12" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                  </div>   
            <div class="form-actions">
               <input type="hidden" id="usia2" name="usia2">
               <input type="hidden" id="rate_type2" name="rate_type2">
               <button type="submit" class="btn purple">Save</button>
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
    
      $("#awal_kontrak0").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#awal_kontrak1").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#akhir_kontrak0").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#akhir_kontrak1").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'insurance_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
    

      // fungsi untuk check all
      jQuery('#insurance_table .group-checkable').live('change',function () {
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

      $("#rekening_tabungan_table .checkboxes").livequery(function(){
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
          // ignore: "",
          rules: {
              cif_no: {
                  required: true
              },
              product_code: {
                  required: true
              }/*,
              panggilan: {
                  required: true
              },
              ibu_kandung: {
                  required: true
              },
              tmp_lahir: {
                  required: true
              },
              tgl_lahir: {
                  required: true
              },
              alamat: {
                  required: true
              },
              rt_rw: {
                  required: true
              },
              desa: {
                  required: true
              },
              kecamatan: {
                  required: true
              },
              kabupaten: {
                  required: true
              },
              kodepos: {
                  required: true
              },
              telpon_rumah: {
                  required: true
              },*/
              /*product: {
                  required: true
              },
              account_saving_no: {
                  required: true
              },
              rencana_setoran: {
                  required: true
              },
              rencana_periode_setoran: {
                  required: true
              },
              rencana_setoran_last: {
                  required: true
              }*/
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
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"transaction/add_insurance",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
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
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel1").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });





       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_insurance_id = $(this).attr('account_insurance_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_insurance_id:account_insurance_id},
          url: site_url+"transaction/get_account_insurance_by_account_insurance_id",
          success: function(response)
          {
            $("#form_edit input[name='account_insurance_id']").val(response.account_insurance_id);
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit input[name='nama2']").val(response.nama);
            $("#form_edit input[name='panggilan2']").val(response.panggilan);
            $("#form_edit input[name='ibu_kandung2']").val(response.ibu_kandung);
            $("#form_edit input[name='tmp_lahir2']").val(response.tmp_lahir);
            $("#form_edit input[name='tgl_lahir2']").val(response.tgl_lahir);
            $("#form_edit textarea[name='alamat2']").val(response.alamat);
            $("#form_edit input[name='rt_rw2']").val(response.rt_rw);
            $("#form_edit input[name='desa2']").val(response.desa);
            $("#form_edit input[name='kecamatan2']").val(response.kecamatan);
            $("#form_edit input[name='kabupaten2']").val(response.kabupaten);
            $("#form_edit input[name='kodepos2']").val(response.kodepos);
            $("#form_edit input[name='telpon_rumah2']").val(response.telpon_rumah);
            $("#form_edit input[name='telpon_seluler2']").val(response.telpon_seluler);
            $("#form_edit input[name='account_no2']").val(response.account_insurance_no);
            var rate_type_ = response.rate_type;
              if(rate_type_==1)
              {
                var product_code2 = response.insurance_type+''+response.rate_type+''+response.product_code+''+response.rate_code;            
              }
              else
              {
                var product_code2 = response.insurance_type+''+response.rate_type+''+response.product_code; 
              }
            $("#form_edit select[name='product_code2']").val(product_code2)
              

                     
          }
        })

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
   
   //fungsi untuk menggenerate NO REKENING PADA FORM EDIT
    $(function(){
    
      $("#product2").change(function(){
        var product = $("#product2").val();
          product_code = product.substring(1,5);
        var cif_no = $("#cif_no2").val();  
        //mendapatkan jumlah maksimal sesuai product_code yang dipilih
        $.ajax({
          url: site_url+"transaction/count_cif_by_product_code",
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
            $("#account_saving_no2").val(cif_no+''+product_code+''+no_urut);
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
              /*nama: {
                  required: true
              },
              panggilan: {
                  required: true
              },
              ibu_kandung: {
                  required: true
              },
              tmp_lahir: {
                  required: true
              },
              tgl_lahir: {
                  required: true
              },
              alamat: {
                  required: true
              },
              rt_rw: {
                  required: true
              },
              desa: {
                  required: true
              },
              kecamatan: {
                  required: true
              },
              kabupaten: {
                  required: true
              },
              kodepos: {
                  required: true
              },
              telpon_rumah: {
                  required: true
              },*/
              product: {
                  required: true
              },
              account_saving_no: {
                  required: true
              },
              /*rencana_setoran: {
                  required: true
              },
              rencana_periode_setoran: {
                  required: true
              },
              rencana_setoran_last: {
                  required: true
              }*/
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"transaction/edit_rekening_tabungan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#menu_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      // $("#cancel","#form_edit").click(function(){
      //   $("#edit").hide();
      //   $("#wrapper-table").show();
      //   dTreload();
      //   success2.hide();
      //   error2.hide();
      // });





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_insurance_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_insurance_id[$i] = $(this).val();

          $i++;

        });

        if(account_insurance_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_insurance",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
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


      // begin first table
      $('#insurance_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_insurance_setup",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false },
            null,
            null,
            null,
            null
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
              var customer_no = $("#result").val();
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#cif_no").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no",
                      success: function(response)
                      {
                        $("#branch_code").val(response.branch_code);
                        $("#nama").val(response.nama);
                        $("#panggilan").val(response.panggilan);
                        $("#ibu_kandung").val(response.ibu_kandung);
                        $("#tmp_lahir").val(response.tmp_lahir);
                        $("#tgl_lahir").val(response.tgl_lahir);
                        $("#alamat").val(response.alamat);
                        $("#rt_rw").val(response.rt_rw);
                        $("#desa").val(response.desa);
                        $("#kecamatan").val(response.kecamatan);
                        $("#kabupaten").val(response.kabupaten);
                        $("#kodepos").val(response.kodepos);
                        $("#telpon_rumah").val(response.telpon_rumah);
                        $("#telpon_seluler").val(response.telpon_seluler);
                          $.ajax({
                            type: "POST",
                            dataType: "json",
                            data: {cif_no:cif_no},
                            url: site_url+"cif/search_pemegang_rekening_bycif_no",
                            success: function(response)
                            {
                              $("#rekening_tabungan").val(response.account_saving_no);
                              $("#nama_pemegang_rek").val(response.nama);
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
              async: false,
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
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
	});


// fungsi untuk mencari Nama Pemegang Rekening
      $(function(){

       $("#select_bawah").click(function(){
         result = $("#result_bawah").val();
              var customer_no = $("#result_bawah").val();
              $("#close_bawah","#dialog_rembug_bawah").trigger('click');
              //alert(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var account_saving_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {account_saving_no:account_saving_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no2",
                      success: function(response)
                      {
                        $("#rekening_tabungan").val(response.account_saving_no);
                        $("#nama_pemegang_rek").val(response.nama);
                      }                 
                    });
            
        });
       $("#result_bawah option").live('dblclick',function(){
        $("#select_bawah").trigger('click');
      });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type_bawah").change(function(){
          type = $("#cif_type_bawah").val();
          $.ajax({
            type: "POST",
            url: site_url+"cif/search_cif_no2",
            data: {keyword:$("#keyword_bawah").val(),cif_type:type},
            dataType: "json",
            success: function(response){
              var option = '';
              if(type=="0"){
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+' - '+response[i].cm_name+'</option>';
                }
              }else if(type=="1"){
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+'</option>';
                }
              }else{
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].cm_name!=null){
                    cm_name = " - "+response[i].cm_name;   
                  }else{
                    cm_name = "";
                  }
                  option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+''+cm_name+'</option>';
                }
              }
              // console.log(option);
              $("#result_bawah").html(option);
            }
          });
        })

        $("#keyword_bawah").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type_bawah").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no2",
              async: false,
              data: {keyword:$(this).val(),cif_type:type},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result_bawah").html(option);
              }
            });
            return false;
          }
        });
      


      });


      //fungsi untuk menampilkan input SESUAI PRODUK YANG DIPILIH
      $(function(){
  
          $("#product_code").change(function(){
                   var dob = $("#tgl_lahir").val();
                            var year=Number(dob.substr(0,4));
                            var month=Number(dob.substr(5,2))-1;
                            var day=Number(dob.substr(7,2));
                            var today=new Date();
                            var age=today.getFullYear()-year;
                            if(today.getMonth()<month || (today.getMonth()==month && today.getDate()<day)){age--;}                            
                    var usia = age;
                    $("#usia").val(usia);
                    // var o = $("#product_code").val();
                    // alert(o);
           $("#akhir_kontrak0").change(function(){
              var awal = $("#awal_kontrak0").val();
                var akhir = $("#akhir_kontrak0").val();
                var tanggal = awal+'-'+akhir;
                $.ajax({
                   url: site_url+"transaction/menghitung_tahun",
                   type: "POST",
                   dataType: "html",
                   data: {tanggal:tanggal},
                   success: function(response)
                   {
                    $("#jumlah_tahun0").val(response);
                   }
                })
           });
            var cif_no = $("#cif_no").val();
            var product = $("#product_code").val();
            var insurance_type = product.substring(0,1);             
            var rate_type = product.substring(1,2);
            var product_code = product.substring(2,5); 
            var rate_code = product.substring(5,8); 
            $("#rate_type").val(rate_type);
              if(insurance_type=='0')
              {
                $("#type_0").show();
                $("#type_1").hide();
              }
              else if(insurance_type=='1')
              {
                $("#type_1").show();
                $("#type_0").hide();
              }
              else
              {
                $("#type_1").hide();
                $("#type_0").hide();
              }
            $.ajax({
              url: site_url+"transaction/count_account_no_by_product_code",
              type: "POST",
              dataType: "html",
              data: {product_code:product_code},
              success: function(response)
              {
                $("#account_no").val(cif_no+''+response);
              }
            })

            if(rate_type==0)
             { 
               $("#benefit_value").change(function(){
                   var benefit_value = $("#benefit_value").val();
                   var awal = $("#awal_kontrak0").val();
                    var akhir = $("#akhir_kontrak0").val();
                    var tanggal = awal+'-'+akhir;
                    $.ajax({
                       url: site_url+"transaction/menghitung_tahun",
                       type: "POST",
                       dataType: "html",
                       data: {tanggal:tanggal},
                       success: function(response)
                       {
                        $("#jumlah_tahun0").val(response);
                       }
                    })
                    $.ajax({
                       url: site_url+"transaction/count_premi_rate_0",
                       type: "POST",
                       dataType: "html",
                       data: {benefit_value:benefit_value},
                       success: function(response)
                       {
                         $("#premium_value0").val(response);
                         $("#premium_rate0").val(response/benefit_value);
                       }
                    })
               }); 
             }
             else if(rate_type==1)
             { 
               $("#benefit_value").change(function(){
                    var benefit_value = $("#benefit_value").val();                    
                    var jumlah_tahun=  $("#jumlah_tahun0").val();
                    var benefit_value = $("#benefit_value").val();
                    var param = rate_code+'-'+usia+'-'+jumlah_tahun+'-'+benefit_value;
                    $.ajax({
                       url: site_url+"transaction/count_premi_rate_1",
                       type: "POST",
                       dataType: "html",
                       data: {param:param},
                       success: function(response)
                       {
                         $("#premium_value0").val(response);
                         $("#premium_rate0").val(response/benefit_value);
                       }
                    })
               }); 
             }
             else if(rate_type==2)
             {
               $("#plan_code").change(function(){               
                   var plan_code = $("#plan_code").val();
                       premium_value1 = plan_code.substring(8,20);
                       $("#premium_value1").val(premium_value1);
                
               }); 
             }
            
          });     
          
      });
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

