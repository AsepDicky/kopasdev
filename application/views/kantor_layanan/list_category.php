
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
      Product Setup <small>Category</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">List Category Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Category</div>
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
      <table class="table table-striped table-bordered table-hover" id="produk_tabungan">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#produk_tabungan .checkboxes" /></th>
               <th width="50%">List Deskripsi</th>
               <th width="50%">List Code</th>
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
         <div class="caption"><i class="icon-reorder"></i>Tambah Category</div>
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
               List Category Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_description" id="code_description" data-required="1" class="medium m-wrap"  maxlength="25" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Group<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_group" id="code_group" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(' ','')" maxlength="25" />
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



<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Category</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="list_code_id" name="list_code_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk Tabungan Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Kode Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_description" id="code_description" data-required="1" class="medium m-wrap"  maxlength="25" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Group<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_group" id="code_group" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(' ','')" maxlength="25" />
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>    
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){


$(document).on('loadlistsadd',function(){
  $.ajax({
    type:"POST",dataType:"json",url:site_url+'kantor_layanan/get_lists_code',
    success:function(response){
      data=response;
      lists='<option value="">PILIH</option>';
      for (i in data) {
        lists+='<option value="'+data[i].code_group+'">'+data[i].code_description+'</option>'
      }
      $('#code_group','#form_add2').html(lists).trigger('liszt:updated');
    }
  })
})

$(document).on('loadlistsedit',function(){
  $.ajax({
    type:"POST",dataType:"json",url:site_url+'kantor_layanan/get_lists_code',
    success:function(response){
      data=response;
      lists='<option value="">PILIH</option>';
      for (i in data) {
        lists+='<option value="'+data[i].code_group+'">'+data[i].code_description+'</option>'
      }
      $('#code_group','#form_edit2').html(lists).trigger('liszt:updated');
    }
  })
})


      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'produk_tabungan';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#produk_tabungan .group-checkable').live('change',function () {
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

      $("#produk_tabungan .checkboxes").livequery(function(){
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
        $("#rencana").hide();
      });


      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              code_description: {
                  required: true
              },
              code_group: {
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
              url: site_url+"kantor_layanan/add_list_category",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  // alert('Successfully Saved Data');
                  $.alert({
                    title:"Success",icon:'icon-check',backgroundDismiss:false,
                    content:'List Category Has been ADDED.',
                    confirmButtonClass:'btn green',
                    confirm:function(){
                      success1.show();
                      error1.hide();
                      form1.trigger('reset');
                      form1.children('div').removeClass('success');
                      $("#cancel",form_add).trigger('click')
                      $(document).trigger('loadlistsadd');
                      $(document).trigger('loadlistsedit');  
                    }
                  })
                }else{
                  success1.show();
                  error1.hide();
                  App.WarningAlert("Failed to connect into databases, please contact your administrator");
                }
              },
              error:function(){
                  success1.show();
                  error1.hide();
                  App.WarningAlert("Failed to connect into databases, please contact your administrator");
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
        var list_code_id = $(this).attr('list_code_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {list_code_id:list_code_id},
          url: site_url+"kantor_layanan/get_list_category_by_list_code_id",
          success: function(response)
          {
            $("#list_code_id, #form_edit").val(response.list_code_id);  
            $("#code_description, #form_edit").val(response.code_description);  
            $("#code_group, #form_edit").val(response.code_group);  
          }
        });

      });


      $("#jenis_tabungan2").change(function()
      {
        var jenis = $("#jenis_tabungan2").val();
          if (jenis=='1') 
          {
            $("#rencana2").show()
          }
          else
          {            
            $("#rencana2").hide();
          }
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
              code_description: {
                  required: true
              },
              code_group: {
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

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"kantor_layanan/edit_list_category",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  $.alert({
                     title:"Success",icon:'icon-check',backgroundDismiss:false,
                     content:'Text Here',
                     confirmButtonClass:'btn green',
                     confirm:function(){
                      success2.show();
                      error2.hide();
                      form2.children('div').removeClass('success');
                      $("#produk_tabungan_filter input").val('');
                      dTreload();
                      $("#cancel",form_edit).trigger('click')
                      $(document).trigger('loadlistsadd');
                      $(document).trigger('loadlistsedit');
                     }
                  });

                  // alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                  App.WarningAlert("Failed to connect into databases, please contact your administrator");
                }
              },
              error:function(){
                  App.WarningAlert("Failed to connect into databases, please contact your administrator");
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

        var list_code_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          list_code_id[$i] = $(this).val();

          $i++;

        });

        if(list_code_id.length==0){
          App.WarningAlert("Please select some row to delete !");
        }else{

          $.confirm({
               title:'Delete',icon:'icon-trash',backgroundDismiss:false,
               content:'Deleting Category. Are You Sure?',
               confirmButtonClass:'btn yellow', cancelButtonClass:'btn red',
               confirm: function(){

                      $.ajax({
                        type: "POST",
                        url: site_url+"kantor_layanan/delete_list_category",
                        dataType: "json",
                        data: {list_code_id:list_code_id},
                        success: function(response){
                          if(response.success==true){
                            // alert("Deleted!");
                            $.alert({
                                 title:"Success",icon:'icon-check',backgroundDismiss:false,
                                 content:'Category Has been DELETED.',
                                 confirmButtonClass:'btn green',
                                 confirm:function(){
                                  dTreload();
                                 }
                            });

                          }else{
                            App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                          }
                        },
                        error: function(){
                          App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                        }
                      })

               }
          });
        }

      });


      // begin first table
      $('#produk_tabungan').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kantor_layanan/datatable_list_category",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false }
            ,null
            ,null
            ,{ "bSortable": false, "bSearchable": false }
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

      


      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

<?php $this->load->view('kantor_layanan/detail_list_category')?>