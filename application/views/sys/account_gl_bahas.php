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
      GL Setup Bahas <small>GL Bagi Hasil</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
      <li><a href="#">Setup GL Account Bagi Hasil</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>GL Account Setup</div>
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
      <hr style="margin:0;">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:44px;float:left;margin-bottom:0;padding:0 5px 0 10px">Account Type</label>
        <div style="padding:5px;float:left;">
          <select id="code_group" name="code_group" class="medium m-wrap" data-required="1" style="margin:0 5px;">
            <option value="">PILIH</option>
            <option value="bahas_pembiayaan">Pembiayaan yang diberikan</option>
            <option value="bahas_dp3">Dana Pihak ke-3</option>
            <option value="bahas_pendapatan">Pendapatan Operasional</option>
          </select>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <table class="table table-striped table-bordered table-hover" id="gl_account_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#gl_account_table .checkboxes" /></th>
               <th width="20%">Account Group</th>
               <th width="20%">Account Value</th>
               <th width="40%">Account Name</th>
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
<div id="add" style="display:none;">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Setup GL Account</div>
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
               Setup GL Account Berhasil Diproses !
            </div>        
                    <div class="control-group">
                       <label class="control-label">Account Group<span class="required">*</span></label>
                       <div class="controls">
                         <select id="code_group1" name="code_group1" class="medium m-wrap" data-required="1">     
                            <option value="">PILIH</option>
                            <option value="bahas_pembiayaan">Pembiayaan yang diberikan</option>
                            <option value="bahas_dp3">Dana Pihak ke-3</option>
                            <option value="bahas_pendapatan">Pendapatan Operasional</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Account Value<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="code_value1" id="code_value1" data-required="1" class="medium m-wrap" maxlength="7" />
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Account Name<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="display_text1" id="display_text1" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>
                    <div class="form-actions">
                   <button type="submit" class="btn green">Save</button>
                   <button type="button" class="btn" id="cancel">Back</button>
                </div>
               </div> 
              </div>
         </form>
         <!-- END FORM-->
            </div>
        <!--  </div>
      </div> -->
<!-- END ADD USER -->

      <!-- BEGIN EDIT USER -->
      <div id="edit" class="hide">
         
         <div class="portlet box purple">
            <div class="portlet-title">
               <div class="caption"><i class="icon-reorder"></i>Edit GL Bahas Account</div>
               <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
               </div>
            </div>
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="#" id="form_edit" class="form-horizontal">
                  <input type="hidden" id="list_code_detail_id" name="list_code_detail_id">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  <div class="alert alert-success hide">
                     <button class="close" data-dismiss="alert"></button>
                     Edit GL Account Successful!
                  </div>

                  <br> 
                    <div class="control-group">
                       <label class="control-label">Account Group<span class="required">*</span></label>
                       <div class="controls">
                         <select id="code_group2" name="code_group2" class="medium m-wrap" data-required="1">     
                            <option value="">PILIH</option>
                            <option value="bahas_pembiayaan">Pembiayaan yang diberikan</option>
                            <option value="bahas_dp3">Dana Pihak ke-3</option>
                            <option value="bahas_pendapatan">Pendapatan Operasional</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Account Value<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="code_value2" id="code_value2" data-required="1" class="medium m-wrap" maxlength="7" />
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Account Name<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="display_text2" id="display_text2" data-required="1" class="medium m-wrap"/>
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
    
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

    $("#code_group").change(function(){
      dTreload();
    })


      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'gl_account_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        // $(".paging_bootstrap li:first a").trigger('click');
        // $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#gl_account_table .group-checkable').live('change',function () {
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

      $("#gl_account_table .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
      var form1     = $('#form_add');
      var error1    = $('.alert-error', form1);
      var success1  = $('.alert-success', form1);

      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        form1.trigger('reset');
        $("#code_group1").val($("#code_group").val());
        $("#add").show();
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              code_group1: {
                  required: true
              },
              code_value1: {
                  required: true
              },
              display_text1: {
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

            $.ajax({
              type: "POST",
              url: site_url+"sys/proses_input_setup_gl_bahas",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Updated Data');
                }else if(response.success==false){
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

      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var list_code_detail_id = $(this).attr('list_code_detail_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {list_code_detail_id:list_code_detail_id},
          url: site_url+"sys/get_gl_account_bahas_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='list_code_detail_id']").val(response.list_code_detail_id);
            $("#form_edit select[name='code_group2']").val(response.code_group);
            $("#form_edit input[name='code_value2']").val(response.code_value);
            $("#form_edit input[name='display_text2']").val(response.display_text);
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              code_group2: {
                  required: true
              },
              code_value2: {
                  required: true
              },
              display_text2: {
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
              url: site_url+"sys/proses_edit_setup_gl_bahas",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo(success1, -200);
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo(success1, -200);
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

        var list_code_detail_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          list_code_detail_id[$i] = $(this).val();

          $i++;

        });

        if(list_code_detail_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"sys/delete_sys_account_bahas",
              dataType: "json",
              data: {list_code_detail_id:list_code_detail_id},
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
      $('#gl_account_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"sys/datatable_sys_account_setup",
          "fnServerParams": function ( aoData ) {
               aoData.push( { "name": "code_group", "value": $("#code_group","#form-filter").val() } );
           },
          "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [20, 45, -1],
              [20, 45, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 20,
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
      $(".dataTables_length,.dataTables_filter").parent().hide();

      jQuery('#gl_account_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#gl_account_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
