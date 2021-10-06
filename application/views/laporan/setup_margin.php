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
      Margin Book Setup <small>Pengaturan Margin Transaksi Buku Tabungan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Margin Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Margin Book Setup</div>
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
         <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="margin_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#margin_table .checkboxes" /></th>
               <th width="25%">Item</th>
               <th width="15%">Top</th>
               <th width="15%">Bottom</th>
               <th width="15%">Left</th>
               <th width="15%">Right</th>
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
         <div class="caption"><i class="icon-reorder"></i>Margin Book Setup</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/add_margin_setup'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Margin Book Setup Has Been Created.
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Item Name<span class="required">*</span></label>
               <div class="controls">
                <select name="item" id="item" class="medium m-wrap">
                  <option value="">Pilih</option>
                  <option value="no">No</option>
                  <option value="trx_date">Tanggal Transaksi</option>
                  <option value="type">Kode Transaksi</option>
                  <option value="debet">Debet</option>
                  <option value="credit">Credit</option>
                  <option value="saldo">Saldo</option>
                  <option value="user">User ID</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Top Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="top" id="top" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Bottom Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bottom" id="bottom" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Left Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="left" id="left" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">Right Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="right" id="right" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>         
                  <input type="hidden" name="posisi" id="posisi" data-required="1" class="small m-wrap"/> 
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
         <div class="caption"><i class="icon-reorder"></i>Edit Desa</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="kecamatan_desa_id" name="kecamatan_desa_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Desa Berhasil Di Edit !
            </div>
          </br> 
            <div class="control-group">
               <label class="control-label">Item Name<span class="required">*</span></label>
               <div class="controls">
                <select name="item" id="item" class="medium m-wrap" disabled>
                  <option value="">Pilih</option>
                  <option value="no">No</option>
                  <option value="trx_date">Tanggal Transaksi</option>
                  <option value="type">Kode Transaksi</option>
                  <option value="debet">Debet</option>
                  <option value="credit">Credit</option>
                  <option value="saldo">Saldo</option>
                  <option value="user">User ID</option>
                </select>
                <input type="hidden" name="setup_id" id="setup_id" data-required="1" class="small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Top Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="top" id="top" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Bottom Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bottom" id="bottom" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Left Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="left" id="left" data-required="1" class="small m-wrap"/> Pixels
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">Right Margin<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="right" id="right" data-required="1" class="small m-wrap"/> Pixels
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

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'margin_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#margin_table .group-checkable').live('change',function () {
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

      $("#margin_table .checkboxes").livequery(function(){
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
              item: {
                  required: true
              },
              top: {
                  required: true
              },
              bottom: {
                required: true
              },
              left: {
                required: true
              },
              right: {
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
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
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
        else
        {
          alert('Please fill the empty field before.');
        }

      });

      $("#item").change(function(){
        item = $("#item").val();  

        if(item=="no"){

          var no = "no";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('no');
            }
          }
          });  

              $("#posisi").val('0');

        }else if(item=="trx_date"){

          var no = "trx_date";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('trx_date');
            }
          }
          });  

          $("#posisi").val('1');

        }else if(item=="type"){

          var no = "type";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('type');
            }
          }
          });  

          $("#posisi").val('2');

        }else if(item=="debet"){

          var no = "debet";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('debet');
            }
          }
          });  

          $("#posisi").val('3');

        }else if(item=="credit"){

          var no = "credit";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('credit');
            }
          }
          });  

          $("#posisi").val('4');

        }else if(item=="saldo"){

          var no = "saldo";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('saldo');
            }
          }
          });  

          $("#posisi").val('5');

        }else{

          var no = "user";

          $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {no:no},
          url: site_url+"administration/check_no_in_setup_margin",
          success: function(response)
          {
            if(response.stat==false){
              alert(response.message);
              $("#item").val('');
            }else{
              form1.trigger('reset');
              $("#item").val('user');
            }
          }
          });  
          $("#posisi").val('6');
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
        var setup_id = $(this).attr('setup_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {setup_id:setup_id},
          url: site_url+"administration/get_margin_setup_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='setup_id']").val(response.setup_id);
            $("#form_edit select[name='item']").val(response.item);
            $("#form_edit input[name='top']").val(response.top_margin);
            $("#form_edit input[name='bottom']").val(response.bottom_margin);
            $("#form_edit input[name='left']").val(response.left_margin);
            $("#form_edit input[name='right']").val(response.right_margin);
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              item: {
                  required: true
              },
              top: {
                  required: true
              },
              bottom: {
                required: true
              },
              left: {
                required: true
              },
              right: {
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
              url: site_url+"administration/edit_margin_setup",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
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

        var setup_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          setup_id[$i] = $(this).val();

          $i++;

        });

        if(setup_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_margin_setup",
              dataType: "json",
              data: {setup_id:setup_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                }else{
                  alert("Deleted !");
                  dTreload();
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
      $('#margin_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_setup_margin",
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

      jQuery('#margin_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#margin_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

