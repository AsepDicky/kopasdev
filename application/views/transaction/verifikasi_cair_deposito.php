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
         Verifikasi  <small>Verifikasi Pencairan Deposito</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">Verifikasi</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Verifikasi Pencairan Deposito</a></li> 
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Pencairan Deposito</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <!-- <div class="btn-group pull-right">
            <button id="btn_delete" class="btn red">
              Reject <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button id="btn_activate" class="btn green">
              Approve <i class="icon-ok-sign"></i>
            </button>
         </div> -->
         <label>
            Rembug Pusat &nbsp; : &nbsp;
            <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled>
            <input type="hidden" name="cm_code" id="cm_code">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         </label>
         <!-- 
         <div class="btn-group">
            <button id="btn_inactivate" class="btn red">
              Inapprove <i class="icon-lock"></i>
            </button>
         </div> -->
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
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Rembug</h3>
         </div>
         <div class="modal-body">
            <div class="row-fluid">
               <div class="span12">
                  <h4>Masukan Kata Kunci</h4>
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="branch" id="branch" class="span12 m-wrap">
                     <option value="">Pilih Kantor Cabang</option>
                     <option value="">All</option>
                     <?php
                     if($this->session->userdata('flag_all_branch')=='1'){
                     ?>
                     <?php
                     foreach($branch as $dtbranch):
                        if($this->session->userdata('branch_id')==$dtbranch['branch_id']){
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>" selected><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }else{
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>"><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }
                     endforeach; 
                     ?>
                     <?php }else{ ?>
                     <option value="<?php echo $this->session->userdata('branch_id'); ?>"><?php echo $this->session->userdata('branch_name'); ?></option>
                     <?php } ?>
                  </select></p>
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pencairan_deposito_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pencairan_deposito_table .checkboxes" /></th>
               <th width="25%">No. Rekening</th>
               <th width="20%">Nama</th>
               <th width="20%">Nominal</th>
               <th width="15%">Jangka Waktu</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Pencairan Deposito</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_deposit_break_id" name="account_deposit_break_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Successful!
            </div>

            <br>
            <div class="control-group">
                       <label class="control-label">No Rekening Deposito</label>
                       <div class="controls">
                          <input type="text" name="account_deposit_no" id="account_deposit_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_id" name="branch_id">
                        </div>
                    </div>    
                    <h4 class="form-section">Customer</h4>   
                    <div class="control-group">
                       <label class="control-label">No. Customer </label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap </label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung </label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir </label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    </br>         
                    <div class="control-group">
                       <label class="control-label">Produk </label>
                       <div class="controls">
                          <input type="text" name="produk" id="produk" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu</label>
                       <div class="controls">
                            <input name="jangka_waktu" id="jangka_waktu" type="text" class="m-wrap" maxlength="4" readonly="" style="background-color:#eee;width:50px"/> bulan
                        </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Nominal</label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="m-wrap" readonly="" name="nominal" id="nominal" style="background-color:#eee;width:120px;">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo</label>
                       <div class="controls">
                            <input name="jatuh_tempo" id="jatuh_tempo" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px;" /> &nbsp; ARO &nbsp; <input type="checkbox" name="aro" id="aro" readonly="" style="background-color:#eee;">
                        </div>
                    </div>  
                    <h4 class="form-section">Rekening Pencarian</h4> 
                    <div class="control-group">
                       <label class="control-label">Nomor Rekening</label>
                       <div class="controls">
                            <input name="account_saving_no" id="account_saving_no" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px;"/>
                       </div>
                    </div> <div class="control-group">
                       <label class="control-label">Atas Nama</label>
                       <div class="controls">
                            <input name="atas_nama" id="atas_nama" type="text"  class="medium m-wrap" readonly="" style="background-color:#eee;width:50px;"/>
                        </div>
                    </div>
            <div class="form-actions">
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
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

      $("#select").click(function(){
         result = $("#result").val();
         if(result != null)
         {
            $("#add_cm_code").val(result);
            $("#edit_cm_code").val(result);
            $("#cm_code").val(result);
            $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
            $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
            $("#close","#dialog_rembug").trigger('click');

            $('#pencairan_deposito_table').dataTable({
              "bDestroy": true,
              "bProcessing": true,
              "bServerSide": true,
              "sAjaxSource": site_url+"transaction/datatable_pencairan_deposito_setup",
              "fnServerParams": function ( aoData ) {
                  aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
              },
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
          // $(".dataTables_length,.dataTables_filter").parent().hide();


         }
         else
         {
            alert("Please select row first !");
         }

      });
    $("#result option").live('dblclick',function(){
      $("#select").trigger('click');
    });
      $("#branch","#dialog_rembug").change(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         var branch = $("#branch","#dialog_rembug").val();
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword",
            dataType: "json",
            data: {keyword:keyword,branch_id:branch},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
               }
               $("#result").html(html);
            }
         })
      })

      $("#keyword","#dialog_rembug").keypress(function(e){
         keyword = $(this).val();
         if(e.which==13){
            var branch = $("#branch","#dialog_rembug").val();
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               async: false,
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result").html(html);
               }
            });
            return false;
         }
      });

      $("#browse_rembug").click(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         branch = $("#branch","#dialog_rembug").val();
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
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
        var tbl_id = 'pencairan_deposito_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
     

      // fungsi untuk check all
      jQuery('#pencairan_deposito_table .group-checkable').live('change',function () {
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

      $("#pencairan_deposito_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_deposit_break_id = $(this).attr('account_deposit_break_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_deposit_break_id:account_deposit_break_id},
          url: site_url+"transaction/search_cif_by_account_deposit_break_id  ",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
                    $("#account_deposit_break_id").val(response.account_deposit_break_id);
                    $("#account_deposit_no").val(response.account_deposit_no);
                    $("#cif_no").val(response.cif_no);
                    $("#nama").val(response.nama);
                    $("#ibu_kandung").val(response.ibu_kandung);
                    $("#tgl_lahir").val(response.tgl_lahir);
                    $("#form_edit textarea[name='alamat']").val(response.alamat);
                    $("#rt_rw").val(response.rt_rw);
                    $("#desa").val(response.desa);
                    $("#kecamatan").val(response.kecamatan);
                    $("#kabupaten").val(response.kabupaten);
                    $("#produk").val(response.product_name);
                    $("#jangka_waktu").val(response.jangka_waktu);
                    $("#nominal").val(response.nominal); 
                    $("#jatuh_tempo").val(response.tanggal_jtempo_last);
                    var aro = response.automatic_roll_over;
                      if(aro=='1'){
                        $("#aro").attr('checked',true);
                        $("#aro").closest('span').addClass('checked');
                      }
                      else
                      {
                        $("#aro").attr('checked',false);;
                        $("#aro").closest('span').removeClass('checked');
                      }    
                    $("#account_saving_no").val(response.account_saving_no); 
                    var account_saving_no = $("#account_saving_no").val();
                      if(account_saving_no!="")
                      {
                        $.ajax({
                          type:"POST",
                          url: site_url+"transaction/search_name_by_account_saving_no",
                          data:{account_saving_no:account_saving_no},
                          dataType:"json",
                          success: function(response)
                          {
                            $("#atas_nama").val(response.atasnama); 
                          }
                        });
                      }
         
          }
        })

      });

// BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              cif_no: {
                  required: true
              },
          },


          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL //VERIFIKASI DEPOSITO
            $.ajax({
              type: "POST",
              url: site_url+"transaction/verifikasi_pencairan_deposito",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  // success2.show();
                  // error2.hide();
                  form2.children('div').removeClass('success');
                  form2.trigger('reset');                  
                  // $("#edit").hide();
                  // $("#wrapper-table").show();
                  $("#pencairan_deposito_table_filter input").val('');
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




 // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_deposit_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_deposit_id[$i] = $(this).val();

          $i++;

        });

        if(account_deposit_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/reject_ver_pencairan_deposito",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  alert("Reject!");
                  dTreload();
                }else{
                  alert("Reject Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });

      $("#btn_reject").click(function(){

        var account_deposit_break_id = $("#account_deposit_break_id").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/reject_ver_pencairan_deposito",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  alert("Reject!");
                  dTreload();
                }else{
                  alert("Reject Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            });
          
        }

      });






      $("#btn_activate").click(function(){

        var account_deposit_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_deposit_id[$i] = $(this).val();

          $i++;

        });

        if(account_deposit_id.length==0){
          alert("Please select some row to Approve !");
        }else{
          var conf = confirm('Are you sure to Approve this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/verifikasi_rekening_deposito",
              dataType: "json",
              data: {account_deposit_id:account_deposit_id},
              success: function(response){
                if(response.success==true){
                  alert("Approve!");
                  dTreload();
                }else{
                  alert("Approve Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      $("#btn_inactivate").click(function(){

        var account_deposit_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_deposit_id[$i] = $(this).val();

          $i++;

        });

        if(account_deposit_id.length==0){
          alert("Please select some row to Inapprove !");
        }else{
          var conf = confirm('Are you sure to Inapprove this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/in_verifikasi_rekening_deposito",
              dataType: "json",
              data: {account_deposit_id:account_deposit_id},
              success: function(response){
                if(response.success==true){
                  alert("Inapprove!");
                  dTreload();
                }else{
                  alert("Inapprove Failed!");
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
      $('#pencairan_deposito_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          // "sAjaxSource": site_url+"transaction/datatable_rekening_ver_deposito_setup",
          "sAjaxSource": site_url+"transaction/datatable_pencairan_deposito_setup",
          "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
          },
          "aoColumns": [
            null,
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
      // $(".dataTables_length,.dataTables_filter").parent().hide();

      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown


</script>

<!-- END JAVASCRIPTS -->
