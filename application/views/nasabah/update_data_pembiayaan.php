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
			Pelunasan Pembiayaan<small> Pengaturan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Pembiayaan Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Update Data Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="update_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_pembiayaan_table .checkboxes" /></th> -->
              <th width="15%">No. Customer</th>
               <th width="15%">No. Pembiayaan</th>
               <th width="25%">Nama</th>
               <th width="20%">Petugas</th>
               <th width="20%">Resort</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN ADD DEPOSITO -->
<div id="edit" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Update Data Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <br>
         <form action="#" method="post" enctype="multipart/form-data" id="form_edit" class="form-horizontal">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="control-group">
               <label class="control-label">Petugas</label>
               <div class="controls">
                  <select id="fa_code" name="fa_code" class="medium m-wrap chosen">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($petugass as $petugas) : ?>
                     <option value="<?php echo $petugas['fa_code'] ?>"><?php echo $petugas['fa_name'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Resort</label>
               <div class="controls">
                  <select id="resort_code" name="resort_code" class="medium m-wrap chosen">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($resorts as $resort) : ?>
                     <option value="<?php echo $resort['resort_code'] ?>"><?php echo $resort['resort_name'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No Customer</label>
               <div class="controls">
                  <input type="text" id="cif_no" class="m-wrap medium" readonly="readonly" style="background:#f5f5f5">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input type="text" id="nama" class="m-wrap medium" readonly="readonly" style="background:#f5f5f5">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan</label>
               <div class="controls">
                  <input type="text" id="panggilan" class="m-wrap medium" readonly="readonly" style="background:#f5f5f5">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input type="text" id="nama_ibu_kandung" class="m-wrap medium" readonly="readonly" style="background:#f5f5f5">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input type="text" id="tempat_lahir" class="m-wrap medium" readonly="readonly" style="background:#f5f5f5">
                  <label style="width:90px;padding-top:6px;text-align:right;display:inline-block;padding-right: 10px;">Tanggal Lahir</label>
                  <input type="text" id="tanggal_lahir" class="m-wrap" readonly="readonly" style="background:#f5f5f5;width:100px;">
                  <label style="width:50px;padding-top:6px;text-align:right;display:inline-block;padding-right: 10px;">Usia</label>
                  <input type="text" id="usia" class="m-wrap" readonly="readonly" style="background:#f5f5f5;width:60px;">
               </div>
            </div>

            <div class="control-group">
               <hr size="1">
            </div>

            <div class="control-group">
               <label class="control-label">Account Saving No</label>
               <div class="controls">
                  <select id="account_saving_no" name="account_saving_no" class="m-wrap medium">
                     <!-- ... -->
                  </select>
               </div>
            </div>

            <div class="control-group">
               <h4>:: Jaminan Primer</h4>
            </div>
            <div class="control-group">
               <label class="control-label">Jaminan</label>
               <div class="controls">
                  <select id="primer_jaminan" name="primer_jaminan" class="m-wrap medium">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($jaminans as $jaminan) : ?>
                     <option value="<?php echo $jaminan['code_value'] ?>"><?php echo $jaminan['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Jaminan</label>
               <div class="controls">
                  <input type="text" id="primer_keterangan" name="primer_keterangan" class="m-wrap medium">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Jaminan</label>
               <div class="controls">
                  <input type="text" id="primer_jumlah" name="primer_jumlah" class="m-wrap" style="width:100px;">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Taksasi</label>
               <div class="controls">
                  <div class="input-append input-preppend">
                     <span class="add-on">Rp</span>
                     <input type="text" id="primer_taksasi" name="primer_taksasi" class="mask-money m-wrap small">
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Presentase Jaminan</label>
               <div class="controls">
                  <div class="input-append">
                     <input type="text" id="primer_presentase" name="primer_presentase" class="m-wrap" style="width:100px;">
                     <span class="add-on">%</span>
                  </div>
               </div>
            </div>

            <div class="control-group">
               <h4>:: Jaminan Sekunder</h4>
            </div>
            <div class="control-group">
               <label class="control-label">Jaminan</label>
               <div class="controls">
                  <select id="sekunder_jaminan" name="sekunder_jaminan" class="m-wrap medium">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($jaminans as $jaminan) : ?>
                     <option value="<?php echo $jaminan['code_value'] ?>"><?php echo $jaminan['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Jaminan</label>
               <div class="controls">
                  <input type="text" id="sekunder_keterangan" name="sekunder_keterangan" class="m-wrap medium">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Jaminan</label>
               <div class="controls">
                  <input type="text" id="sekunder_jumlah" name="sekunder_jumlah" class="m-wrap" style="width:100px;">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Taksasi</label>
               <div class="controls">
                  <div class="input-append input-preppend">
                     <span class="add-on">Rp</span>
                     <input type="text" id="sekunder_taksasi" name="sekunder_taksasi" class="mask-money m-wrap small">
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Presentase Jaminan</label>
               <div class="controls">
                  <div class="input-append">
                     <input type="text" id="sekunder_presentase" name="sekunder_presentase" class="m-wrap" style="width:100px;">
                     <span class="add-on">%</span>
                  </div>
               </div>
            </div>

            <div class="control-group">
               <hr size="1">
            </div>

            <div class="control-group">
               <label class="control-label">Sektor Ekonomi</label>
               <div class="controls">
                  <select id="sektor_ekonomi" name="sektor_ekonomi" class="medium m-wrap">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($sektors as $sektor) : ?>
                     <option value="<?php echo $sektor['code_value'] ?>"><?php echo $sektor['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Peruntukan Pembiayaan</label>
               <div class="controls">
                  <select id="peruntukan" name="peruntukan" class="medium m-wrap">
                     <option value="">SILAHKAN PILIH</option>
                     <?php foreach ($peruntukans as $peruntukan) : ?>
                     <option value="<?php echo $peruntukan['code_value'] ?>"><?php echo $peruntukan['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Menggunakan Wakalah ?</label>
               <div class="controls">
                  <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap">
                     <option value="">SILAHKAN PILIH</option>
                     <option value="1">Ya</option>
                     <option value="0">Tidak</option>
                  </select>
               </div>
            </div>

            <div class="form-actions">
               <input type="hidden" name="account_financing_id" id="account_financing_id">
               <button type="submit" class="btn green" id="submit">Update</button>
               <button type="button" class="btn" id="cancel">Back</button>
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
      $(".maskdate").inputmask("d/m/y", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){

   $('#update_table').dataTable({
       "bProcessing": true,
       "bServerSide": true,
       "sAjaxSource": site_url+"rekening_nasabah/datatable_update_data_pembiayaan",
       "aoColumns": [ null, null, null, null, null, { "bSortable": false } ],
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
       }
   });

   $("a#update").live('click',function(e){
      e.preventDefault();
      accountfinancingid=$(this).data('accountfinancingid');
      // alert(accountfinancingid)
      var form_edit = $("#form_edit");
      $("#wrapper-table").hide();
      $("#edit").show();
      $(form_edit).trigger('reset');
      $.ajax({
         type:"post",
         dataType:"json",
         async:false,
         data:{accountfinancingid:accountfinancingid},
         url:site_url+"rekening_nasabah/get_akun_saving_for_update_data_pembiayaan",
         success:function(response)
         {
            var option = '';
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
            };
            $("#account_saving_no",form_edit).html(option);
         },
         error:function(){
             alert('Something error, please contact your administrator');
         }
      })
      $.ajax({
         type:"post",
         dataType:"json",
         async:false,
         data:{accountfinancingid:accountfinancingid},
         url:site_url+"rekening_nasabah/get_data_for_update_data_pembiayaan",
         success:function(response)
         {
            $("#cif_no",form_edit).val(response.cif_no);
            $("#nama",form_edit).val(response.nama);
            $("#panggilan",form_edit).val(response.panggilan);
            $("#nama_ibu_kandung",form_edit).val(response.ibu_kandung);
            $("#tempat_lahir",form_edit).val(response.tmp_lahir);
            $("#tanggal_lahir",form_edit).val(response.tgl_lahir);
            $("#usia",form_edit).val(response.usia);
            
            $("#account_financing_id",form_edit).val(accountfinancingid);
            $("#fa_code",form_edit).val(response.fa_code).trigger('liszt:updated');
            $("#resort_code",form_edit).val(response.resort_code).trigger('liszt:updated');
            $("#account_saving_no",form_edit).val(response.account_saving_no).trigger('liszt:updated');
            $("#primer_jaminan",form_edit).val(response.jenis_jaminan);
            $("#primer_keterangan",form_edit).val(response.keterangan_jaminan);
            $("#primer_jumlah",form_edit).val(response.jumlah_jaminan);
            $("#primer_taksasi",form_edit).val(response.nominal_taksasi);
            $("#primer_presentase",form_edit).val(response.presentase_jaminan);
            $("#sekunder_jaminan",form_edit).val(response.jenis_jaminan_sekunder);
            $("#sekunder_keterangan",form_edit).val(response.keterangan_jaminan_sekunder);
            $("#sekunder_jumlah",form_edit).val(response.jumlah_jaminan_sekunder);
            $("#sekunder_taksasi",form_edit).val(response.nominal_taksasi_sekunder);
            $("#sekunder_presentase",form_edit).val(response.presentase_jaminan_sekunder);
            $("#sektor_ekonomi",form_edit).val(response.sektor_ekonomi);
            $("#peruntukan",form_edit).val(response.peruntukan);
            $("#flag_wakalah",form_edit).val(response.flag_wakalah);
         },
         error:function(){
             alert('Something error, please contact your administrator');
         }
      })
   })

   $("#cancel").click(function(){
      $("#wrapper-table").show();
      $("#edit").hide();
      $("#form_edit").trigger('reset');
   })

   $("#submit").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"rekening_nasabah/action_update_data_pembiayaan",
         dataType: "json",
         data: {
             account_financing_id : $("#account_financing_id",form_edit).val()
            ,fa_code : $("#fa_code",form_edit).val()
            ,resort_code : $("#resort_code",form_edit).val()
            ,account_saving_no : $("#account_saving_no",form_edit).val()
            ,primer_jaminan : $("#primer_jaminan",form_edit).val()
            ,primer_keterangan : $("#primer_keterangan",form_edit).val()
            ,primer_jumlah : $("#primer_jumlah",form_edit).val()
            ,primer_taksasi : $("#primer_taksasi",form_edit).val()
            ,primer_presentase : $("#primer_presentase",form_edit).val()
            ,sekunder_jaminan : $("#sekunder_jaminan",form_edit).val()
            ,sekunder_keterangan : $("#sekunder_keterangan",form_edit).val()
            ,sekunder_jumlah : $("#sekunder_jumlah",form_edit).val()
            ,sekunder_taksasi : $("#sekunder_taksasi",form_edit).val()
            ,sekunder_presentase : $("#sekunder_presentase",form_edit).val()
            ,sektor_ekonomi : $("#sektor_ekonomi",form_edit).val()
            ,peruntukan : $("#peruntukan",form_edit).val()
            ,flag_wakalah : $("#flag_wakalah",form_edit).val()
         },
         success: function(response){
           if(response.success==true){
             alert('Success');
             $("#cancel",form_edit).trigger('click')
             location.reload(false);
           }else{
             alert('Something error, please contact your administrator');
           }
         },
         error:function(){
             alert('Something error, please contact your administrator');
         }
      });
   });

})
</script>

<!-- END JAVASCRIPTS -->
