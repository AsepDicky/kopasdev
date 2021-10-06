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
      Resort Setup <small>Pengaturan Resort</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Resort Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Resort Setup</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
            <button id="btn_delete" class="btn red">
              Delete Resort <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>

         <label>
            Kantor Cabang &nbsp; : &nbsp;
            <input type="text" name="branch_name" id="branch_name" class="medium m-wrap" disabled>
            <input type="hidden" name="branch_code" id="branch_code">
            <a id="browse" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         </label>
      </div>

      <div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Kantor Cabang</h3>
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

      <table class="table table-striped table-bordered table-hover" id="resort_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#resort_table .checkboxes" /></th>
               <th width="20%">Kode Resort</th>
               <th width="30%">Nama Resort</th>
               <th width="30%">Tanggal Pembentukan</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD REMBUG -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Add New Resort</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('kantor_layanan/add_resort_setup'); ?>" method="post" id="form_add" class="form-horizontal">
            <input type="hidden" name="add_branch_code" id="add_branch_code">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Resort Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Resort<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="resort_code" id="resort_code" data-required="1" class="small m-wrap" readonly="readonly" style="background:#eee"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Resort<span class="required">*</span></label>
               <div class="controls">
                  <input name="resort_name" id="resort_name" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pembentukan<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_pembentukan" id="mask_date" type="text" value="<?php echo $current_date; ?>" class="date-picker small m-wrap" placeholder="dd/mm/yyyy"/>
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




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Resort</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" name="edit_branch_code" id="edit_branch_code">
            <input type="hidden" name="resortid" id="resortid">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Resort Berhasil Di Edit !
            </div>

            <div class="control-group">
               <label class="control-label">Kode Resort<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="resort_code" id="resort_code" data-required="1" class="small m-wrap" readonly="readonly" style="background:#eee" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Resort<span class="required">*</span></label>
               <div class="controls">               
                  <input name="resort_name" id="resort_name" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pembentukan<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_pembentukan" id="mask_date" type="text" value="<?php echo $current_date; ?>" class="date-picker small m-wrap" placeholder="dd/mm/yyyy" />
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT REMBUG -->






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
      Index.init();
      $("#mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $(".date-picker").datepicker("update","<?php echo $current_date; ?>");
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){
      // cari desa form edit

      // cari kantor cabang
      $("#select").click(function(){
         result = $("#result").val();
         if(result != null)
         {
            $("#branch_code").val(result);
            $("#add_branch_code").val(result);
            $("#edit_branch_code").val(result);
            $("#branch_name").val($("#result option:selected").attr('branch_name'));
            $("#close","#dialog_kantor_cabang").trigger('click');

            $('#resort_table').dataTable({
                "bDestroy":true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": site_url+"kantor_layanan/datatable_resort_setup",
                "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
                },
                "aoColumns": [
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

            $(".dataTables_filter").parent().hide();


         }
         else
         {
            alert("Please select row first !");
         }

      });

        $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
        });

      $("#keyword","#dialog_kantor_cabang").keypress(function(e){
         keyword = $(this).val();
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_branch_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
         }
      });

      $("#browse").click(function(){
         keyword = $("#keyword","#dialog_kantor_cabang").val();
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_branch_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
      });

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'resort_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#resort_table .group-checkable').live('change',function () {
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

      $("#resort_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        branch_code = $("#branch_code").val();
        $(".date-picker").datepicker("update","<?php echo $current_date; ?>");
        if(branch_code==""){
          alert("Mohon pilih Kantor Cabang terlebih dahulu!");
        }else{
          $("#add_branch_code").val(branch_code);
          $("#wrapper-table").hide();
          $("#add").show();
          form1.trigger('reset');
          //get resort code
          $.ajax({
            url: site_url+"kantor_layanan/get_resort_code_by_branch",
            type: "POST",
            dataType: "json",
            data: {branch_code:branch_code},
            success: function(response){
              $("#resort_code",form1).val(response.resort_code);
            }
          })
        }
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              resort_code: {
                  required: true
              },
              resort_name: {
                  required: true
              },
              tanggal_pembentukan: {
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

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              dataType: "json",
              success: function(response) {
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


      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var resortid = $(this).data('resortid');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {resortid:resortid},
          url: site_url+"kantor_layanan/get_resort_by_id",
          success: function(response){
            
            form2.trigger('reset');
            //Ajax untuk menangkap nama petugas sesuai branch code di form edit 

            $("#form_edit input[name='resortid']").val(response.resort_id);
            $("#form_edit input[name='edit_branch_code']").val(response.branch_code);
            $("#form_edit input[name='resort_code']").val(response.resort_code);
            $("#form_edit input[name='resort_name']").val(response.resort_name);
            $("#form_edit input[name='tanggal_pembentukan']").val(convert_date_en_to_id(response.tgl_pembentukan));
            $("#form_edit input[name='tanggal_pembentukan']").datepicker("update",convert_date_en_to_id(response.tgl_pembentukan));

          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              resort_name: {
                  required: true
              },
              tanggal_pembentukan: {
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

            $.ajax({
              type: "POST",
              url: site_url+"kantor_layanan/edit_resort_setup",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#resort_table_filter input").val('');
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

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });





      $("#btn_delete").click(function(){

        var cm_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          cm_id[$i] = $(this).val();

          $i++;

        });

        if(cm_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_rembug",
              dataType: "json",
              data: {cm_id:cm_id},
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
      $('#resort_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kantor_layanan/datatable_resort_setup",
          "aoColumns": [
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
          "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
          },
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
      $(".dataTables_filter").parent().hide();

      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
