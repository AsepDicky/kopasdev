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
         Kopegtel Setup <small>Pengaturan Kopegtel</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">Kantor Layanan</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Data Kopegtel</a></li> 
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->





<!-- BEGIN EXAMPLE TABLE PORTLET -->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Data Kopegtel</div>
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
              Delete Role <i class="icon-remove"></i>
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

      <!-- TABLE DISINI -->
      <table class="table table-striped table-bordered table-hover" id="kopegtel_table"> 
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#kopegtel_table .checkboxes" /></th>
               <th width="25%">Nama Kopegtel</th>
               <th width="25%" class="hidden-480">Pejabat</th>
               <th width="20%" style="text-align:center;">Kode Kopegtel</th>
               <th width="15%" style="text-align:center;">Kontak</th>
               <th width="15%" style="text-align:center;">Chaneling</th>
               <th style="text-align:center;">Edit</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>

   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET -->




<!-- BEGIN ADD -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Add New Role</div>
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
               New Role has been Created !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_kopegtel" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Wilayah<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="wilayah" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="alamat" data-required="1" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pejabat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="ketua_pengurus" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="jabatan" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <textarea class="large m-wrap" name="deskripsi_ketua_pengurus" rows="5"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kopegtel Code<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="kopegtel_code" data-required="1" class="medium m-wrap" maxlength="10" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Email<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="email" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telphone<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_telp" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Chaneling<span class="required">*</span></label>
               <div class="controls">
                <select class="medium m-wrap" name="chaneling">
                  <option value="">Pilih</option>
                  <option value="Y">Ya</option>
                  <option value="T">Tidak</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_bank" id="nama_bank" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Cabang Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bank_cabang" id="bank_cabang" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nomor_rekening" id="nomor_rekening" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Atas Nama <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="atasnama_rekening" id="atasnama_rekening" class="medium m-wrap"/>
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
<!-- END ADD -->





<!-- BEGIN EDIT -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Role</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="kopegtel_id" name="kopegtel_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Role Successful!
            </div>

            <div class="control-group">
               <label class="control-label">Nama Kopegtel<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_kopegtel" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Wilayah<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="wilayah" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="alamat" data-required="1" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pejabat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="ketua_pengurus" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="jabatan" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <textarea class="large m-wrap" name="deskripsi_ketua_pengurus" rows="5"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kopegtel Code<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="kopegtel_code" data-required="1" readonly="" style="background:#ddd;" class="medium m-wrap" maxlength="10" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Email<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="email" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telphone<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_telp" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Chaneling<span class="required">*</span></label>
               <div class="controls">
                <select class="medium m-wrap" name="chaneling">
                  <option value="">Pilih</option>
                  <option value="Y">Ya</option>
                  <option value="T">Tidak</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_bank" id="nama_bank" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Cabang Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bank_cabang" id="bank_cabang" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nomor_rekening" id="nomor_rekening" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Atas Nama <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="atasnama_rekening" id="atasnama_rekening" class="medium m-wrap"/>
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
<!-- END EDIT -->





<!-- BEGIN EDIT ROLE PRIVILEDGE -->
<div id="edit_role_priviledge" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Role Priviledge</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit_role_priviledge" class="form-horizontal">
            <input type="hidden" id="role_id" name="role_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               Something wrong, please contact your administrator for this problem.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Role Priviledge Successful!
            </div>

            <input type="checkbox" id="select_all"> Select All
            <hr size="1">
            <div id="menu-role"></div>

            <div class="form-actions" style="padding-left:20px">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT ROLE PRIVILEDGE -->







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
        var tbl_id = 'kopegtel_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#kopegtel_table .group-checkable').live('change',function () {
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

      $("#kopegtel_table .checkboxes").livequery(function(){
        $(this).uniform();
      });


      $('#kopegtel_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kantor_layanan/datatable_kopegtel",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
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
              },
              {
                  'bSortable': false,
                  'aTargets': [3]
              }
          ]
      });

      jQuery('#kopegtel_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kopegtel_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

      // end dataTable script

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var kopegtel_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          kopegtel_id[$i] = $(this).val();

          $i++;

        });

        if(kopegtel_id.length==0){

          alert("Please select some row to delete !");

        }else{

          var conf = confirm('Are you sure to delete this rows ?');

          if(conf){

            $.ajax({
              type: "POST",
              url: site_url+"kantor_layanan/delete_kopegtel",
              dataType: "json",
              data: {kopegtel_id:kopegtel_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload(); // memanggil fungsi reload
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            });

          }

        }

      });

      // event button Add New ketika di tekan
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
      });

      // BEGIN FORM ADD VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              nama_kopegtel: {
                  required: true
              },
              wilayah: {
                  required: true
              },
              alamat: {
                  required: true
              },
              ketua_pengurus: {
                  required: true
              },
              jabatan: {
                  required: true
              },
              nik: {
                  required: true
              },
              deskripsi_ketua_pengurus: {
                  required: true
              },
              kopegtel_code: {
                  required: true
              },
              email: {
                  required: true
              },
              no_telp: {
                  required: true
              },
              chaneling: {
                  required: true
              },
              nama_bank: {
                  required: true
              },
              bank_cabang: {
                  required: true
              },
              nomor_rekening: {
                  required: true
              },
              atasnama_rekening: {
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
              url: site_url+"kantor_layanan/add_kopegtel",
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
        var kopegtel_id = $(this).attr('kopegtel_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {kopegtel_id:kopegtel_id},
          url: site_url+"kantor_layanan/get_kopegtel_by_kopegtel_id",
          success: function(response){
            $("#form_edit input[name='kopegtel_id']").val(response.kopegtel_id);
            $("#form_edit input[name='nama_kopegtel']").val(response.nama_kopegtel);
            $("#form_edit input[name='wilayah']").val(response.wilayah);
            $("#form_edit textarea[name='alamat']").val(response.alamat);
            $("#form_edit input[name='ketua_pengurus']").val(response.ketua_pengurus);
            $("#form_edit input[name='jabatan']").val(response.jabatan);
            $("#form_edit input[name='nik']").val(response.nik);
            $("#form_edit textarea[name='deskripsi_ketua_pengurus']").val(response.deskripsi_ketua_pengurus);
            $("#form_edit input[name='kopegtel_code']").val(response.kopegtel_code);
            $("#form_edit input[name='email']").val(response.email);
            $("#form_edit input[name='no_telp']").val(response.no_telpon);
            $("#form_edit select[name='chaneling']").val(response.status_chaneling);
            $("#form_edit input[name='nama_bank']").val(response.nama_bank);
            $("#form_edit input[name='bank_cabang']").val(response.bank_cabang);
            $("#form_edit input[name='nomor_rekening']").val(response.nomor_rekening);
            $("#form_edit input[name='atasnama_rekening']").val(response.atasnama_rekening);
          }
        })

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
              nama_kopegtel: {
                  required: true
              },
              wilayah: {
                  required: true
              },
              alamat: {
                  required: true
              },
              ketua_pengurus: {
                  required: true
              },
              jabatan: {
                  required: true
              },
              nik: {
                  required: true
              },
              deskripsi_ketua_pengurus: {
                  required: true
              },
              kopegtel_code: {
                  required: true
              },
              email: {
                  required: true
              },
              no_telp: {
                  required: true
              },
              chaneling: {
                  required: true
              },
              nama_bank: {
                  required: true
              },
              bank_cabang: {
                  required: true
              },
              nomor_rekening: {
                  required: true
              },
              atasnama_rekening: {
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
              url: site_url+"kantor_layanan/edit_kopegtel",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#menu_table_filter input").val('');
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

});
</script>

<!-- END JAVASCRIPTS -->
