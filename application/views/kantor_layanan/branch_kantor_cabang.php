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
      Branch Setup <small>Pengaturan Cabang</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Branch Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Kantor Cabang</div>
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
      <table class="table table-striped table-bordered table-hover" id="kantor_cabang_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#kantor_cabang_table .checkboxes" /></th>
               <th width="20%">Kode Cabang</th>
               <th width="20%">Nama Cabang</th>
               <th width="20%">Jenis Cabang</th>
               <th width="20%">Kepala Cabang</th>
               <th width="20%">Jabatan</th>
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
         <div class="caption"><i class="icon-reorder"></i>Kantor Cabang</div>
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
               Kantor Cabang Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Nama Kantor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_name" data-required="1" class="medium m-wrap" maxlength="30" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Kepala Cabang<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_officer_name" id="branch_officer_name" data-required="1" class="medium m-wrap" maxlength="40" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <select name="branch_officer_title" id="branch_officer_title" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                    <?php foreach($jabatan as $data): ?>
                      <option value="<?php echo $data['code_value'];?>"><?php echo $data['code_value'];?> - <?php echo $data['display_text'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jenis Cabang<span class="required">*</span></label>
               <div class="controls">
                  <select name="branch_class" id="branch_class" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php  if($branch_class_login<1){ ?><option value="1">WILAYAH</option><?php }?>
                     <?php  if($branch_class_login<2){ ?><option value="2">CABANG</option><?php }?>
                     <?php  if($branch_class_login<3){ ?><option value="3">CAPEM</option><?php }?>
                  </select>
               </div>
            </div>
            <div class="control-group" id="r_branch_induk">
               <label class="control-label">Cabang Induk<span class="required">*</span></label>
               <div class="controls">
                  <select id="branch_induk" name="branch_induk" class="medium m-wrap" data-required="1">                     
                    <option value="">PILIH</option>
                    <?php foreach($cabang as $data): ?>
                      <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?> - <?php echo $data['branch_code'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">ID Kantor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_code" id="branch_code" maxlength="5" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="form-actions">
               <input type="hidden" id="wilayah" name="wilayah">
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
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="branch_id" name="branch_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Kantor Cabang Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Nama Kantor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_name" data-required="1" class="medium m-wrap" maxlength="30" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Kepala Cabang<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_officer_name" id="branch_officer_name" data-required="1" class="medium m-wrap" maxlength="40" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <select name="branch_officer_title" id="branch_officer_title" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                    <?php foreach($jabatan as $data): ?>
                      <option value="<?php echo $data['code_value'];?>"><?php echo $data['code_value'];?> - <?php echo $data['display_text'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jenis Cabang<span class="required">*</span></label>
               <div class="controls">
                  <select name="branch_class"  id="branch_class2"  class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>                     
                     <option value="1">WILAYAH</option>
                     <option value="2">CABANG</option>
                     <option value="3">CAPEM</option>
                  </select>
               </div>
            </div>
            <div class="control-group"  id="r_branch_induk2">
               <label class="control-label">Cabang Induk<span class="required">*</span></label>
               <div class="controls">
                  <select id="branch_induk2" name="branch_induk" class="medium m-wrap" data-required="1">                     
                    <option value="">PILIH</option>
                    <?php foreach($cabang as $data): ?>
                      <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?> - <?php echo $data['branch_code']; ?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">ID Kantor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="branch_code" id="branch_code2" readonly="" maxlength="5" data-required="1" class="medium m-wrap" style="background-color:#eee;" />
               </div>
            </div>
            <div class="form-actions">
               <input type="hidden" id="wilayah" name="wilayah">
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
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  $("#btn_add").click(function(){
    $.ajax({
      url: site_url+"cif/get_all_branch",
      dataType: "json",
      success: function(response){
        html = '<option value="">PILIH</option>';
        for(i = 0 ; i < response.length ; i++)
        {
          html += '<option value="'+response[i].branch_code+'">'+response[i].branch_name+' - '+response[i].branch_code+'</option>';
        }
        $("#branch_induk","#add").html(html);
      }
    });
  });

  $("#dialog").dialog({
    width: 900,
    height: 500,
    autoOpen: false,
    buttons: {
      'OK': function(){
        $("#dialog").dialog('close');
        var customer_no = $("#result").val();
        alert(customer_no);
        // $("#curst_no").val(customer_no)
      }
    }
  });
  $("#button-dialog").click(function(){
    $("#dialog").dialog('open');
  });

  $("#keyword").keypress(function(e){

    if(e.which==13){

      $.ajax({
        type: "POST",
        url: site_url+"cif/search_cif_no",
        data: {keyword:$(this).val()},
        dataType: "json",
        success: function(response){
          var option = '';
          for(i = 0 ; i < response.length ; i++){
            option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
          }
          // console.log(option);
          $("#result").html(option);
        }
      })
    }
  })
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'kantor_cabang_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#kantor_cabang_table .group-checkable').live('change',function () {
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

      $("#kantor_cabang_table .checkboxes").livequery(function(){
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
              branch_name: {
                  required: true
              },
              branch_officer_title: {
                  required: true
              },
              branch_officer_name: {
                  required: true
              },
              branch_code: {
                  required: true,
        				  minlength: 5,
        				  maxlength: 5
              },
              branch_class: {
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"cif/add_kantor_cabang",
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
      $("#cancel","#form_add").click(function(){
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
        var branch_id = $(this).attr('branch_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {branch_id:branch_id},
          url: site_url+"cif/get_branch_by_branch_id",
          success: function(response)
          {
          
              //fungsi untuk menampilkan input select bila jenis cabang != "WILAYAH" pada form EDIT
              if(response.branch_class=='2')
              {
                $.ajax({
                  url: site_url+"cif/get_all_branch_wilayah",
                  dataType: "json",
                  async: false,
                  success: function(response){
                    // html = '<option value="">PILIH</option>';
                    html = '';
                    for(i = 0 ; i < response.length ; i++)
                    {
                      html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                    }
                    $("#branch_induk2","#edit").html(html);
                  }
                });
                $("#r_branch_induk2").show();
              }
              else if(response.branch_class=='3')
              {
                $.ajax({
                  url: site_url+"cif/get_all_branch_cabang",
                  dataType: "json",
                  async: false,
                  success: function(response){
                    // html = '<option value="">PILIH</option>';
                    html = '';
                    for(i = 0 ; i < response.length ; i++)
                    {
                      html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                    }
                    $("#branch_induk2","#edit").html(html);
                  }
                });
                $("#r_branch_induk2").show();
              }
              else if(response.branch_class=='')
              {
                $("#r_branch_induk2").hide();
              }
              else
              {
                $("#r_branch_induk2").hide();
              }  
            $("#form_edit input[name='branch_id']").val(response.branch_id);
            $("#form_edit input[name='branch_name']").val(response.branch_name);
            $("#form_edit input[name='branch_code']").val(response.branch_code);
            $("#form_edit input[name='branch_officer_name']").val(response.branch_officer_name);
            $("#form_edit select[name='branch_induk']").val(response.branch_induk);            
            $("#form_edit select[name='branch_class']").val(response.branch_class);
            $("#form_edit select[name='branch_officer_title']").val(response.code_value); 
            // alert(response.wilayah)
            $("#wilayah","#edit").val(response.wilayah);         
          }
        })

        $("#branch_class2","#edit").attr('readonly',true);
        $("#branch_class2","#edit").attr('disabled','disabled');
        $("#branch_induk2","#edit").attr('readonly',true);
        $("#branch_induk2","#edit").attr('disabled','disabled');
        $("#wilayah","#edit").attr('readonly',true);
        $("#wilayah","#edit").attr('disabled','disabled');

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
              branch_name: {
                  required: true
              },
              branch_office_title: {
                  required: true
              },
              branch_officer_name: {
                  required: true
              },
              branch_code: {
                  required: true,
        				  minlength: 5,
        				  maxlength: 5
              },
              branch_status: {
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
              url: site_url+"cif/edit_kantor_cabang",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#kantor_cabang_table_filter input").val('');
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
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var branch_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          branch_id[$i] = $(this).val();

          $i++;

        });

        if(branch_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_kantor_cabang",
              dataType: "json",
              data: {branch_id:branch_id},
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
      $('#kantor_cabang_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_kantor_cabang_setup",
          "aoColumns": [
            {"bSearchable": false},
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
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

      //fungsi untuk menampilkan input select bila jenis cabang == "KANTOR KAS"
      $(function(){
  
          $("#r_branch_induk").hide();
          
          $("#branch_class").change(function(){
            branch_class = $(this).val();          
            if(branch_class=='2')
            {
              $.ajax({
                url: site_url+"cif/get_all_branch_wilayah",
                dataType: "json",
                async: false,
                success: function(response){
                  html = '<option value="">PILIH</option>';
                  // html = '';
                  for(i = 0 ; i < response.length ; i++)
                  {
                    html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#branch_induk","#add").html(html);
                }
              });
              $("#r_branch_induk").show();
            }
            else if(branch_class=='3')
            {
              $.ajax({
                url: site_url+"cif/get_all_branch_cabang",
                dataType: "json",
                async: false,
                success: function(response){
                  html = '<option value="">PILIH</option>';
                  // html = '';
                  for(i = 0 ; i < response.length ; i++)
                  {
                    html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#branch_induk","#add").html(html);
                }
              });
              $("#r_branch_induk").show();
            }
            else if(branch_class=='')
            {
              $("#r_branch_induk").hide();
            }
            else
            {
              $("#r_branch_induk").hide();
            }
            
          });     
          
      });


      //fungsi untuk mengambil 3 karakter pertama dari brancg terpilih
      $("#branch_induk").change(function(){
          var branch_class = $("#branch_class").val();
          var branch_code = $("#branch_induk").val();
          var prefix_branch_code = '';
          if(branch_class=='2'){ // jika branch class = wilayah, maka substring 1 digit
            if(branch_code=="")
             {prefix_branch_code=''}
            else if(branch_code=="0")
             {prefix_branch_code=''}
            else
             {prefix_branch_code = branch_code.substring(0,1)};
          }else if(branch_class=='3'){ // jika branch class = cabang, maka substring sampai 4
            if(branch_code=="")
             {prefix_branch_code=''}
            else if(branch_code=="0")
             {prefix_branch_code=''}
            else
             {prefix_branch_code = branch_code.substring(0,3)};
          }
          $("#branch_code").val(prefix_branch_code);
      });


      //fungsi untuk menampilkan input select bila jenis cabang == "KANTOR KAS" pada form EDIT
      // $(function(){
  
      //     $("#r_branch_induk2").hide();
          
      //     $("#branch_class2").change(function(){
      //       branch_class = $(this).val();          
      //       if(branch_class=='1' || branch_class=='2')
      //       {
      //         $("#r_branch_induk2").show();
      //       }
      //       else if(branch_class=='')
      //       {
      //         $("#r_branch_induk2").hide();
      //       }
      //       else
      //       {
      //         $("#r_branch_induk2").hide();
      //       }
            
      //     });     
          
      // });

          
          $("#branch_class2").change(function(){
            branch_class2 = $(this).val();          
            if(branch_class2=='2')
            {
              $.ajax({
                url: site_url+"cif/get_all_branch_wilayah",
                dataType: "json",
                async: false,
                success: function(response){
                  html = '<option value="">PILIH</option>';
                  // html = '';
                  for(i = 0 ; i < response.length ; i++)
                  {
                    html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#branch_induk2","#edit").html(html);
                }
              });
              $("#r_branch_induk2").show();
            }
            else if(branch_class2=='3')
            {
              $.ajax({
                url: site_url+"cif/get_all_branch_cabang",
                dataType: "json",
                async: false,
                success: function(response){
                  html = '<option value="">PILIH</option>';
                  // html = '';
                  for(i = 0 ; i < response.length ; i++)
                  {
                    html += '<option value="'+response[i].branch_code+'" attrwilayah="'+response[i].wilayah+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#branch_induk2","#edit").html(html);
                }
              });
              $("#r_branch_induk2").show();
            }
            else if(branch_class2=='')
            {
              $("#r_branch_induk2").hide();
            }
            else
            {
              $("#r_branch_induk2").hide();
            }
            
          }); 

      //fungsi untuk mengambil 3 karakter pertama dari brancg terpilih pada form
      $("#branch_induk").change(function(){
          
          var branch_class = $("#branch_class").val();
          var branch_code = $("#branch_induk").val();
          var prefix_branch_code = '';
          if(branch_class=='2'){ // jika branch class = wilayah, maka substring 1 digit
            if(branch_code=="")
             {prefix_branch_code=''}
            else if(branch_code=="0")
             {prefix_branch_code=''}
            else
             {prefix_branch_code = branch_code.substring(0,1)};
          }else if(branch_class=='3'){ // jika branch class = cabang, maka substring sampai 4
            if(branch_code=="")
             {prefix_branch_code=''}
            else if(branch_code=="0")
             {prefix_branch_code=''}
            else
             {prefix_branch_code = branch_code.substring(0,3)};
          }

          $("#branch_code").val(prefix_branch_code);

          if ($("#branch_class").val()=='2'){
            $("#wilayah","#add").val(branch_code);
          } 
          else if ($("#branch_class").val()=='3'){
            var wilayah = $('option:selected', "#branch_induk").attr('attrwilayah');
            $("#wilayah","#add").val(wilayah);
          };
      });
      //EDIT
      $("#branch_induk2").change(function(){
          var branch_code = $("#branch_induk2").val();
          if(branch_code=="")
           {prefix_branch_code=''}
          else if(branch_code=="0")
           {prefix_branch_code=''}
          else
           {prefix_branch_code = branch_code.substring(0,4)};
          $("#branch_code2").val(prefix_branch_code);

          if ($("#branch_class2").val()=='2'){
            $("#wilayah","#edit").val(branch_code);
          } 
          else if ($("#branch_class2").val()=='3'){
            var wilayah = $('option:selected', "#branch_induk2").attr('attrwilayah');
            $("#wilayah","#edit").val(wilayah);
          };
      });
      




      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

