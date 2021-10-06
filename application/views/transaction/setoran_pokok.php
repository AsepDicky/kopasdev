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
      Transaction <small>Setoran Pokok</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Setoran Pokok</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Setoran Pokok</div>
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
      </div>
      <table class="table table-striped table-bordered table-hover" id="rekening_trx_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_trx_table .checkboxes" /></th>
               <th width="23%">No. CIF</th>
               <th width="30%">Nama</th>
               <th width="23%">Setor Tunai</th>
               <th width="30%">Tanggal Transaksi</th>
               <!-- <th>Edit</th> -->
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
         <div class="caption"><i class="icon-reorder"></i>Setoran Pokok</div>
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
               New Transaction Saving has been Created !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code" name="branch_code">
                          
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
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Setor Tunai<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="setor_tunai" style="width:120px;" id="setor_tunai" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Setor Tabungan Wajib<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="setor_tabungan_wajib" style="width:120px;" id="setor_tabungan_wajib" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Setor Tabungan Kelompok<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="setor_tabungan_kelompok" style="width:120px;" id="setor_tabungan_kelompok" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Setor Tabungan Sukarela<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="setor_tabungan_sukarela" style="width:120px;" id="setor_tabungan_sukarela" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Total Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="total_setoran" style="width:120px;" id="total_setoran" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
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
<!-- END ADD USER -->

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
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'rekening_trx_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  

      // fungsi untuk check all
      jQuery('#rekening_trx_table .group-checkable').live('change',function () {
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

      $("#rekening_trx_table .checkboxes").livequery(function(){
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
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              cif_no: {
                  required: true
              },
              setor_tunai: {
                  required: true
              },
              setor_tabungan_wajib: {
                  required: true
              },
              setor_tabungan_kelompok: {
                  required: true
              },
              setor_tabungan_sukarela: {
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

          submitHandler: function (form) {  

            var total     = parseFloat(convert_numeric($("#total_setoran").val()));
            var cif_no    = $("#cif_no",form_add).val();

            if(total!=100000){
              alert("Total Setoran Harus Rp.100.000,- Sesuai Nominal Yang Dianjurkan !");
            }else{
                $.ajax({
                  type: "POST",
                  url: site_url+"/transaction/check_valid_cif_no",
                  async: false,
                  dataType: "json",
                  data: {cif_no:cif_no},
                  success: function(response){
                    if(response.stat==true){
                        $.ajax({
                          type: "POST",
                          url: site_url+"transaction/add_transaksi_setoran_pokok",
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
                            App.scrollTo(error1, -200);
                          },
                          error:function(){
                              success1.hide();
                              error1.show();
                              App.scrollTo(error1, -200);
                          }
                        });
                    }else{
                      alert("Data Sudah Ada. Transaksi Setoran Pokok Hanya Boleh Dilakukan Satu Kali !");
                    }
                  },
                  error:function(){
                    alert("Failed to Connect into Databases, Please Contact Your Administration!");
                  }
                }); 
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

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var trx_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          trx_id[$i] = $(this).val();

          $i++;

        });

        if(trx_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_trx_setoran_pokok",
              dataType: "json",
              data: {trx_id:trx_id},
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
      $('#rekening_trx_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_trx_setoran_pokok_setup",
          "aoColumns": [
			      null,
            null,
            null,
            null,
            null
            // { "bSortable": false, "bSearchable": false }
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
            $("#cif_no").val(customer_no);
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
                $("#result").html(option);
              }
            });

        });

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
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });

      //FUNGSI UNTUK MENJUMLAHKAN TOTAL
      $("#total_setoran").attr("readonly",true);
      $("#total_setoran").addClass('bg-readonly');
      $("#setor_tunai,#setor_tabungan_wajib,#setor_tabungan_kelompok,#setor_tabungan_sukarela",form_add).live('keyup',function(){

        var setor_tunai             = 0;
        var setor_tabungan_wajib    = 0;
        var setor_tabungan_kelompok = 0;
        var setor_tabungan_sukarela = 0;

          $("#setor_tunai",form_add).each(function(){
            var setor_tunai = parseFloat(convert_numeric($("#setor_tunai").val()));
            if(isNaN(setor_tunai)===true){
              setor_tunai = 0;
            }
            var setor_tabungan_wajib = parseFloat(convert_numeric($("#setor_tabungan_wajib").val())); 
            if(isNaN(setor_tabungan_wajib)===true){
              setor_tabungan_wajib = 0;
            }
            var setor_tabungan_kelompok = parseFloat(convert_numeric($("#setor_tabungan_kelompok").val())); 
            if(isNaN(setor_tabungan_kelompok)===true){
              setor_tabungan_kelompok = 0;
            }
            var setor_tabungan_sukarela = parseFloat(convert_numeric($("#setor_tabungan_sukarela").val())); 
            if(isNaN(setor_tabungan_sukarela)===true){
              setor_tabungan_sukarela = 0;
            }
            var total = setor_tunai+setor_tabungan_wajib+setor_tabungan_kelompok+setor_tabungan_sukarela;
            if(isNaN(total)===true){
              total = 0;
            }
            $("#total_setoran",form_add).val(number_format(total,0,',','.'));
        });
      });
      

      jQuery('#rekening_trx_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_trx_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

