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
      Desa Setup <small>Pengaturan Desa</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Desa Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Desa</div>
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
      <table class="table table-striped table-bordered table-hover" id="desa_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#desa_table .checkboxes" /></th>
               <th width="20%">ID</th>
               <th width="70%">Desa</th>
               <th width="70%">Kecamatan</th>
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
         <div class="caption"><i class="icon-reorder"></i>Desa</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('cif/add_desa'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Nama Desa Berhasil Ditambahkan !
            </div>
            <br>
                    <div class="control-group">
                       <label class="control-label">Nama Kecamatan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="hidden" id="kecamatan_code" name="kecamatan_code">
                          <input type="text" name="kecamatan_name" id="kecamatan_name" data-required="1" class="medium m-wrap"/>          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari Kecamatan</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                                      <select name="city" id="city" class="span12 m-wrap chosen" style="width:530px">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="">All</option>
                                        <?php foreach($city as $dtcity): ?>
                                        <option value="<?php echo $dtcity['city_code']; ?>"><?php echo $dtcity['city']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      <br><br>
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
               <label class="control-label">ID Desa<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="desa_code" id="desa_code" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="desa" data-required="1" class="medium m-wrap"/>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Desa</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
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
          </br> <div class="control-group">
                       <label class="control-label">Nama Kecamatan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="hidden" id="kecamatan_code2" name="kecamatan_code2">
                          <input type="text" name="kecamatan" id="kecamatan" data-required="1" class="medium m-wrap"/>
                          <div id="dialog_rembug2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari Kecamatan</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p>
                                      <select name="city" class="span12 m-wrap chosen" style="width:530px;">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option value="">All</option>
                                        <?php foreach($city as $dtcity): ?>
                                        <option value="<?php echo $dtcity['city_code']; ?>"><?php echo $dtcity['city']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      <br>
                                      <br>
                                      <p><select name="result" id="result2" size="7" class="span12 m-wrap"></select></p>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close2" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select2" class="btn blue">Select</button>
                             </div>
                          </div>

                        <a id="browse_rembug2" class="btn blue" data-toggle="modal" href="#dialog_rembug2">...</a>
                       </div>
                    </div>
            <div class="control-group">
               <label class="control-label">Id Desa<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="desa_code" id="desa_code2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="desa" data-required="1" class="medium m-wrap"/>
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
        var tbl_id = 'desa_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#desa_table .group-checkable').live('change',function () {
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

      $("#desa_table .checkboxes").livequery(function(){
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
              city_code: {
                  required: true
              },
              desa_code: {
                  required: true
              },
              desa_abbr: {
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





      // BEGIN FORM EDIT NEWS VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var kecamatan_desa_id = $(this).attr('kecamatan_desa_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {kecamatan_desa_id:kecamatan_desa_id},
          url: site_url+"cif/get_desa_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='kecamatan_desa_id']").val(response.kecamatan_desa_id);
            $("#form_edit input[name='desa_code']").val(response.desa_code);
            $("#form_edit input[name='desa']").val(response.desa);
            $("#form_edit input[name='kecamatan_code2']").val(response.kecamatan_code);
            $("#form_edit input[name='kecamatan']").val(response.kecamatan);
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              title: {
                  minlength: 4,
                  required: true
              },
              detail: {
                  minlength: 3,
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
              url: site_url+"cif/edit_desa",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#desa_table_filter input").val('');
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

        var desa_code = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          desa_code[$i] = $(this).val();

          $i++;

        });

        if(desa_code.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_desa",
              dataType: "json",
              data: {desa_code:desa_code},
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
      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
              var kecamatan_code = $("#result").val();
              var kecamatan_name = $("#result option:selected").attr('kecamatan');
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#kecamatan_name").val(kecamatan_name);
              $("#kecamatan_code").val(kecamatan_code);

                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var code = kecamatan_code;
                    $.ajax({
                          url: site_url+"cif/get_ajax_kecamatan_code",
                          type: "POST",
                          dataType: "html",
                          data: {code:code},
                          success: function(response)
                          {
                            $("#desa_code").val(response);
                          }
                    });
            
        });

       $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
        });

     });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("select[name='city']","#form_add").change(function(){
          city = $("select[name='city']","#form_add").val();
          $.ajax({
            type: "POST",
            url: site_url+"cif/search_kecamatan_code",
            data: {keyword:$("#keyword").val(),city_code:city},
            dataType: "json",
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
              }
              // console.log(option);
              $("#result").html(option);
            }
          });
        })

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            city = $("select[name='city']","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_kecamatan_code",
              data: {keyword:$(this).val(),city_code:city},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });
      

      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select2").click(function(){
              var kecamatan_code = $("#result2").val();
              var kecamatan      = $("#result2 option:selected").attr('kecamatan');
              $("#close2","#dialog_rembug2").trigger('click');
              //alert(customer_no);
              $("#kecamatan").val(kecamatan);
              $("#kecamatan_code2").val(kecamatan_code);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var code = kecamatan_code;
                    $.ajax({
                          url: site_url+"cif/get_ajax_kecamatan_code",
                          type: "POST",
                          dataType: "html",
                          data: {code:code},
                          success: function(response)
                          {
                            $("#desa_code2").val(response);
                          }
                    });
            
        });

       $("#result2 option").live('dblclick',function(){
           $("#select2").trigger('click');
        });

     });

        $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });

        $("select[name='city']","#form_edit").change(function(){
          city = $("select[name='city']","#form_edit").val();
          $.ajax({
            type: "POST",
            url: site_url+"cif/search_kecamatan_code",
            data: {keyword:$("#keyword2").val(),city_code:city},
            dataType: "json",
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
              }
              // console.log(option);
              $("#result2").html(option);
            }
          });
        })
        
        $("#keyword2").keypress(function(e){

          if(e.which==13){

            city = $("select[name='city']","#form_edit").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_kecamatan_code",
              data: {keyword:$(this).val(),city_code:city},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            });
          }
        });
      



      // begin first table
      $('#desa_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_desa",
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

      jQuery('#desa_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#desa_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

