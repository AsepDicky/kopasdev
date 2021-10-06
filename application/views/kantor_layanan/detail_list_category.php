
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table2">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Detail List Category</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add2" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete2" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="detail_list_category">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#detail_list_category .checkboxes" /></th>
               <th width="32%">List Code</th>
               <th width="32%">Code Value</th>
               <th width="32%">Display Text</th>
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
<div id="add2" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Tambah Detail List Category</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add2" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Akad Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">List Code<span class="required">*</span></label>
               <div class="controls">
                  <select name="code_group" id="code_group" class="medium m-wrap chosen" data-required="1">
                     <option value="">PILIH</option>
                     <?php foreach ($list_category as $data) : ?>
                     <option value="<?php echo $data['code_group'];?>"><?php echo $data['code_description'];?></option>
                   <?php endforeach;?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Code Value<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_value" id="code_value" data-required="1" class="small m-wrap" maxlength="20" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Display Text<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="display_text" name="display_text" data-required="1" class="medium m-wrap"></textarea>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel2">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->



<!-- BEGIN EDIT USER -->
<div id="edit2" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Detail List Category</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit2" class="form-horizontal">
          <input type="hidden" id="list_code_detail_id" name="list_code_detail_id">
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
               <label class="control-label">List Code<span class="required">*</span></label>
               <div class="controls">
                  <select name="code_group" id="code_group2" class="medium m-wrap chosen" data-required="1">
                     <option value="">PILIH</option>
                     <?php foreach ($list_category as $data) : ?>
                     <option value="<?php echo $data['code_group'];?>"><?php echo $data['code_description'];?></option>
                   <?php endforeach;?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Code Value<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="code_value" id="code_value" data-required="1" class="small m-wrap" maxlength="20" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Display Text<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="display_text" name="display_text" data-required="1" class="medium m-wrap"></textarea>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel2">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id_s
      // gantilah value dari tbl_id_s ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id_s = 'detail_list_category';
        $("select[name='"+tbl_id_s+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id_s+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#detail_list_category .group-checkable').live('change',function () {
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

      $("#detail_list_category .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
      var form3 = $('#form_add2');
      var error3 = $('.alert-error', form3);
      var success3 = $('.alert-success', form3);

      
      $("#btn_add2").click(function(){
        $("#wrapper-table2").hide();
        $("#add2").show();
        form3.trigger('reset');
        $("#rencana").hide();
      });


      form3.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              akad_code: {
                  required: true
              },
              akad_name: {
                  required: true
              },
              type_product: {
                  required: true
              },
              jenis_keuntungan: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success3.hide();
              error3.show();
              App.scrollTo(error3, -200);
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
              url: site_url+"kantor_layanan/add_detail_list_category",
              dataType: "json",
              data: form3.serialize(),
              success: function(response){
                if(response.success==true){
                  success3.show();
                  error3.hide();
                  form3.trigger('reset');
                  form3.children('div').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
                  $("#code_group",form3).focus();
                }else{
                  success3.hide();
                  error3.show();
                }
              },
              error:function(){
                  success3.hide();
                  error3.show();
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel2","#form_add2").click(function(){
        success3.hide();
        error3.hide();
        $("#add2").hide();
        $("#wrapper-table2").show();
        dTreload();
      });


       // event button Edit ketika di tekan
      $("a#link-edit2").live('click',function(){
        $("#wrapper-table2").hide();
        $("#edit2").show();
        var list_code_detail_id = $(this).attr('list_code_detail_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {list_code_detail_id:list_code_detail_id},
          url: site_url+"kantor_layanan/get_detail_list_category_by_list_code_id",
          success: function(response)
          {
            $("#list_code_detail_id, #form_edit2").val(response.list_code_detail_id); 
            $("#code_group2, #form_edit2").val(response.code_group).trigger('liszt:updated'); 
            $("#code_value, #form_edit2").val(response.code_value); 
            $("#display_text, #form_edit2").val(response.display_text); 
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
      var form4 = $('#form_edit2');
      var error4 = $('.alert-error', form4);
      var success4 = $('.alert-success', form4);

      form4.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              akad_code: {
                  required: true
              },
              akad_name: {
                  required: true
              },
              type_product: {
                  required: true
              },
              jenis_keuntungan: {
                  required: true
              }
          },

          
          invalidHandler: function (event, validator) { //display error alert on form submit              
              success3.hide();
              error3.show();
              App.scrollTo(error3, -200);
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
              url: site_url+"kantor_layanan/edit_detail_list_category",
              dataType: "json",
              data: form4.serialize(),
              success: function(response){
                if(response.success==true){
                  success4.show();
                  error4.hide();
                  form4.children('div').removeClass('success');
                  $("#menu_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success4.hide();
                  error4.show();
                }
              },
              error:function(){
                  success4.hide();
                  error4.show();
              }
            });

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel2","#form_edit2").click(function(){
        $("#edit2").hide();
        $("#wrapper-table2").show();
        dTreload();
        success4.hide();
        error4.hide();
      });





      // fungsi untuk delete records
      $("#btn_delete2").click(function(){

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
              url: site_url+"kantor_layanan/delete_detail_list_category",
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
      $('#detail_list_category').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kantor_layanan/datatable_detail_list_category",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false }
            ,null
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

