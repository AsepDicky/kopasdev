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
			Cetak Hasil Scoring<small> Cetak Hasil Scoring</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Cetak Hasil Scoring</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Cetak Hasil Scoring</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_scoring_id" name="account_financing_scoring_id">

            <br>
            <div class="control-group">
               <label class="control-label">No. Pengajuan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="registration_no" id="registration_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
                     <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                     <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
                  </div>
            </div>

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
     
            <div class="control-group">
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Jumlah Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input name="amount" id="amount" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <input name="description" id="description" data-required="1" type="text" class="large m-wrap" readonly="readonly" style="width: 650px !important;background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tgl Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_pengajuan" id="tanggal_pengajuan" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Skor<span class="required">*</span></label>
               <div class="controls">
                  <input name="total_skor" id="total_skor" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:50px !important;background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status<span class="required">*</span></label>
               <div class="controls">
                  <input name="status" id="status" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="form-actions">
               <button type="button" class="btn green" id="cetak_pdf">Cetak PDF</button>
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
    
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


    $("#select").click(function(){
        var result = $("#result").val();
	     $("#close","#dialog_rembug").trigger('click');
        $("#registration_no").val(result);
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_reg_id:result},
          url: site_url+"rekening_nasabah/get_cif_by_account_financing_reg_scoring",
          success: function(response){
            // if(response.length==0){
            //    alert("CIF ini belum memiliki Rekening Tabungan!");
            // }else{
                $("#account_financing_scoring_id").val(response.account_financing_scoring_id);
                $("#registration_no").val(response.registration_no);
                $("#nama").val(response.nama);
                $("#amount").val(number_format(response.amount,0,',','.'));
                $("#description").val(response.description);
                $("#tanggal_pengajuan").val(response.tanggal_pengajuan);
                $("#total_skor").val(response.total_skor);
                if (response.status==0) {
                  var Vstatus = "Registrasi";
                } else if (response.status==1){
                  var Vstatus = "Diaktivasi";
                } else if (response.status==2){
                  var Vstatus = "Ditolak";
                } else{                  
                  var Vstatus = "Dibatalkan";
                };
                $("#status").val(Vstatus);
            // }
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
              url: site_url+"rekening_nasabah/search_cif_for_cetak_hasil_scoring",
              data: {keyword:$("#keyword").val(),cif_type:type},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
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
              url: site_url+"rekening_nasabah/search_cif_for_cetak_hasil_scoring",
              data: {keyword:$(this).val(),cif_type:type},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
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
              url: site_url+"rekening_nasabah/search_cif_for_cetak_hasil_scoring",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_reg_id+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
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


      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        window.location.href=site_url;
      });

      
      //export PDF
      $("#cetak_pdf").click(function(e)
      {
        e.preventDefault();
        var account_financing_scoring_id = $("#account_financing_scoring_id").val();
        if(account_financing_scoring_id==''){
         alert("Tidak data untuk ditampilkan!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_pdf/cetak_hasil_scoring/'+account_financing_scoring_id+'/CETAK');
        }
      });


      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#cetak_akad_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
