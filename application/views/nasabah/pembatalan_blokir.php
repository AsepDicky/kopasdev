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
			Buka Blokir Rekening Tabungan<small> Buka Blokir Rekening Tabungan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Buka Blokir Rekening Tabungan</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Buka Blokir Rekening Tabungan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('rekening_nasabah/proses_buka_blokir_rek_tabungan'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_saving_blokir_id" name="account_saving_blokir_id">
            <input type="hidden" id="account_saving_id" name="account_saving_id">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Buka Blokir Rekening Tabungan Berhasil Diproses !
            </div>
           </br>
           <div class="control-group">
              <label class="control-label">No Rekening<span class="required">*</span></label>
              <div class="controls">
                 <input type="text" name="account_saving_no" readonly="" id="account_saving_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                 <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
                 
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
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama_lengkap" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk</label>
               <div class="controls">
                  <input name="product" id="product" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <!-- <div class="control-group">
               <label class="control-label">Nama</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly"/>
               </div>
            </div> -->
            <div class="control-group">
               <label class="control-label">Saldo Rekening</label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="saldo_rekening" id="saldo_rekening" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Saldo Minimal</label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="saldo_minimal" data-required="1" id="saldo_minimal" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status Blokir</label>
               <div class="controls">
                  <select id="status_blokir" name="status_blokir" class="m-wrap" style="background-color:#EEEEEE">
                    <option></option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Ditahan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_ditahan" id="saldo_ditahan" data-required="1" type="text" class="m-wrap mask-money" style="width:120px;background-color:#EEEEEE"/>
                  <input type="hidden" id="saldo_hold" name="saldo_hold">
                  <span class="add-on">,00</span>
                  </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Saldo Efektif</label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                    <input name="saldo_efektif" id="saldo_efektif" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div>
               </div>
            </div>              
           <div class="control-group ">
              <label class="control-label">Alasan<span class="required">*</span></label>
              <div class="controls">
                 <textarea name="alasan" id="alasan" class="medium m-wrap" style="background-color:#EEEEEE"/></textarea>
              </div>
           </div>  
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
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
        var no_rekening = $("#result").val();
	$("#close","#dialog_rembug").trigger('click');
        $("#account_saving_no").val(no_rekening);
        var account_saving_no = no_rekening;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_saving_no:account_saving_no},
          url: site_url+"rekening_nasabah/get_cif_by_account_saving_no_for_buka",
          success: function(response){
            // if(response.length==0){
            //    alert("CIF ini belum memiliki Rekening Tabungan!");
            // }else{
              var saldo_ditahan = response.amount;
              var saldo_hold = response.saldo_hold;
              var status_rekening = response.status_rekening;
              var saldo_rekening = response.saldo_memo;
              var saldo_minimal = response.saldo_minimal;
              // var saldo_efektif = saldo_rekening-saldo_ditahan-saldo_minimal;
              var saldo_efektif = saldo_rekening-saldo_ditahan;
              if(status_rekening==3){
                // $("#status_blokir").val(1);
                $("#saldo_ditahan").val(0).attr('readonly',true).css("backgroundColor","#EEEEEE");
                $("#status_blokir").html('<option value="1">Rekening</option>');
              }else if(status_rekening==1 && saldo_ditahan>0){
                // $("#status_blokir").val(2);
                $("#saldo_ditahan").val(number_format(saldo_ditahan,0,',','.')).attr('readonly',true).css("backgroundColor","#EEEEEE");
                $("#status_blokir").html('<option value="2">Saldo</option>');
              }else{
                // $("#status_blokir").val('');
                $("#saldo_ditahan").val(0).attr('readonly',true).css("backgroundColor","#EEEEEE");
                $("#status_blokir").html('<option></option>');
              }

              $("#form_add input[name='account_saving_blokir_id']").val(response.account_saving_blokir_id);
              $("#form_add input[name='account_saving_id']").val(response.account_saving_id);
              $("#nama_lengkap").val(response.nama);
              $("#product").val(response.product_name);
              $("#alasan").val(response.description);
              $("#saldo_rekening").val(number_format(saldo_rekening,0,',','.'));
              $("#saldo_minimal").val(number_format(saldo_minimal,0,',','.'));
              $("#saldo_hold").val(saldo_hold);
              $("#saldo_efektif").val(number_format(saldo_efektif,0,',','.'));
              //$("#saldo_efektif").val(response.saldo_efektif);
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
              url: site_url+"cif/search_cif_for_buka_tabungan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
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
              url: site_url+"cif/search_cif_for_buka_tabungan",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
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
              url: site_url+"cif/search_cif_for_buka_tabungan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
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
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelunasan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pelunasan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
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
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              account_saving_no: {
                  required: true
              },
              saldo_ditahan: {
                  required: true
              },
              alasan: {
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

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div.control-group').removeClass('success');
                }else{
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(success1, -200);
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo(success1, -200);
              }
          });
        }
        else
        {
          alert('Please fill the empty field before.');
        }

      });



   //Event untuk menghitung saldo efektif
   $(function(){
      $("#saldo_ditahan").change(function(){
            var saldo_rekening = parseFloat(convert_numeric($("#saldo_rekening").val()));
            console.log(saldo_rekening);  
            var saldo_minimal = parseFloat(convert_numeric($("#saldo_minimal").val()));  
            console.log(saldo_minimal);
            var saldo_ditahan = parseFloat(convert_numeric($("#saldo_ditahan").val()));
            console.log(saldo_ditahan);
            var saldo_efektif = saldo_rekening-saldo_ditahan-saldo_minimal;
            $("#saldo_efektif").val(number_format(saldo_efektif,0,',','.'));

          });
    });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });


      // begin first table
      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pelunasan_pembiayaan_setup",
          "aoColumns": [
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

      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
