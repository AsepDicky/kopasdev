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
			Rembug Setup <small>Pengaturan Rembug</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
			<li><a href="#">Rembug Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rembug Pusat</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
            <button id="btn_delete" class="btn red">
              Delete Rembug <i class="icon-remove"></i>
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

      <table class="table table-striped table-bordered table-hover" id="rembug_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rembug_table .checkboxes" /></th>
               <th width="40%">Nama</th>
               <th width="40%">Desa</th>
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
         <div class="caption"><i class="icon-reorder"></i>Add New Rembug</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('cif/add_rembug'); ?>" method="post" id="form_add" class="form-horizontal">
            <input type="hidden" name="add_branch_code" id="add_branch_code">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Rembug Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">ID Rembug<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="id_rembug" id="id_rembug" data-required="1" class="medium m-wrap" readonly="readonly" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Rembug<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_rembug" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa<span class="required">*</span></label>
               <div class="controls">
                 <label>
                    <input type="text" name="desa" id="desa" class="medium m-wrap" disabled>
                    <input type="hidden" name="desa_code" id="desa_code">
                    <a id="browse2" class="btn blue" data-toggle="modal" href="#dialog_desa">...</a>
                    <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
                 </label>
                 <div id="dialog_desa" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                   <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h3>Cari Desa</h3>
                   </div>
                   <div class="modal-body">
                      <div class="row-fluid">
                         <div class="span12">
                            <h4>Masukan Kata Kunci</h4>
                            <p><input type="text" name="keyword2" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p>
                            <p><select name="kecamatan" class="span12 m-wrap chosen" style="width:530px;">
                               <option value="">Pilih Kecamatan</option>
                               <option value="">All</option>
                               <?php foreach($kecamatan as $dtkecamatan): ?>
                               <option value="<?php echo $dtkecamatan['kecamatan_code']; ?>"><?php echo $dtkecamatan['kecamatan']; ?></option>
                               <?php endforeach; ?>
                            </select></p><br><br>
                            <p><select name="result2" id="result2" size="7" class="span12 m-wrap"></select></p>
                         </div>
                      </div>
                   </div>
                   <div class="modal-footer">
                      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                      <button type="button" id="select2" class="btn blue">Select</button>
                   </div>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Petugas Lapangan<span class="required">*</span></label>
               <div class="controls">
                 <select name="petugas_lapangan" id="petugas_lapangan" class="medium m-wrap"></select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pembentukan<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_pembentukan" id="mask_date" type="text" value="<?php echo $current_date; ?>" class="date-picker medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Hari Transaksi<span class="required">*</span></label>
               <div class="controls">
                <select class="medium m-wrap" name="hari_transaksi">
                     <option value="">Select...</option>
                     <?php 
                        $days= $this->session->userdata('day_transaction');
                        $namedays = array( "Minggu", "Senin", "Selasa", 'Rabu', "Kamis", "Jum'at", "Sabtu" );
                        $idx = 0;
                        for ($i=1; $i <=strlen($days) ; $i++) 
                        { 
                          $status = substr($days, $i-1,1);
                         
                          if ($status=='1') 
                          {
                            echo '<option value="'.$idx.'">'.$namedays[$idx].'</option>';
                          }
                          $idx++;                          
                        }
                     ?>
                </select>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Rembug</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" name="edit_branch_code" id="edit_branch_code">
            <input type="hidden" id="cm_id" name="cm_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Rembug Berhasil Di Edit !
            </div>

            <div class="control-group">
               <label class="control-label">Nama Rembug<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_rembug" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa<span class="required">*</span></label>
               <div class="controls">
                 <label>
                    <input type="text" name="desa" id="desa" class="medium m-wrap" disabled>
                    <input type="hidden" name="desa_code" id="desa_code">
                    <a id="browse2" class="btn blue" data-toggle="modal" href="#dialog_desa2">...</a>
                    <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
                 </label>
                 <div id="dialog_desa2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                   <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h3>Cari Desa</h3>
                   </div>
                   <div class="modal-body">
                      <div class="row-fluid">
                         <div class="span12">
                            <h4>Masukan Kata Kunci</h4>
                            <p><input type="text" name="keyword3" id="keyword3" placeholder="Search..." class="span12 m-wrap"></p>
                            <p><select name="kecamatan" class="span12 m-wrap chosen" style="width:530px">
                               <option value="">Pilih Kecamatan</option>
                               <option value="">All</option>
                               <?php foreach($kecamatan as $dtkecamatan): ?>
                               <option value="<?php echo $dtkecamatan['kecamatan_code']; ?>"><?php echo $dtkecamatan['kecamatan']; ?></option>
                               <?php endforeach; ?>
                            </select></p><br><br>
                            <p><select name="result3" id="result3" size="7" class="span12 m-wrap"></select></p>
                         </div>
                      </div>
                   </div>
                   <div class="modal-footer">
                      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                      <button type="button" id="select3" class="btn blue">Select</button>
                   </div>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Petugas Lapangan<span class="required">*</span></label>
               <div class="controls">               
                 <select name="petugas_lapangan" id="petugas_lapangan" class="medium m-wrap"></select>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Hari Transaksi<span class="required">*</span></label>
               <div class="controls">
                <select class="medium m-wrap" name="hari_transaksi">
                     <option value="">Select...</option>
                     <?php 
                        $days= $this->session->userdata('day_transaction');
                        $namedays = array( "Minggu", "Senin", "Selasa", 'Rabu', "Kamis", "Jum'at", "Sabtu" );
                        $idx = 0;
                        for ($i=1; $i <=strlen($days) ; $i++) 
                        { 
                          $status = substr($days, $i-1,1);
                         
                          if ($status=='1') 
                          {
                            echo '<option value="'.$idx.'">'.$namedays[$idx].'</option>';
                          }
                          $idx++;                          
                        }
                     ?>
                </select>
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
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){
      // cari desa form edit

      $("#select3","#form_edit").click(function(){
         result = $("#result3").val();
         if(result != null)
         {
            $("#desa_code","#form_edit").val(result);
            $("#desa","#form_edit").val($("#result3 option:selected").attr('desa'));
            $("#close","#form_edit").trigger('click');
         }
         else
         {
            alert("Please select row first !");
         }
      });

      $("#result3 option").live('dblclick',function(){
           $("#select3").trigger('click');
        });

      $("select[name='kecamatan']","#form_edit").change(function(e){
         keyword = $("#keyword3").val();
         kecamatan = $(this).val()
          $.ajax({
             type: "POST",
             url: site_url+"cif/get_desa_by_keyword",
             dataType: "json",
             data: {keyword:keyword,kecamatan:kecamatan},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                $("#result3","#form_edit").html(html);
             }
          })
      });

      $("#keyword3","#form_edit").keypress(function(e){
         keyword = $(this).val();
         kecamatan = $("select[name='kecamatan']","#form_edit").val()
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result3","#form_edit").html(html);
               }
            })
         }
      });

      $("#browse2").click(function(){
         keyword = $("#keyword3","#dialog_desa2").val();
         kecamatan = $("select[name='kecamatan']","#form_edit").val()
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result3","#form_edit").html(html);
               }
            })
      });

      // cari desa form add
      $("#select2","#form_add").click(function(){
         result = $("#result2").val();
         if(result != null)
         {
            $("#desa_code","#form_add").val(result);
            $("#desa","#form_add").val($("#result2 option:selected").attr('desa'));
            $("#close","#form_add").trigger('click');
         }
         else
         {
            alert("Please select row first !");
         }

      });

      $("#result2 option").live('dblclick',function(){
           $("#select2").trigger('click');
        });

      $("select[name='kecamatan']","#form_add").change(function(e){
         keyword = $("#keyword2").val();
         kecamatan = $(this).val()
          $.ajax({
             type: "POST",
             url: site_url+"cif/get_desa_by_keyword",
             dataType: "json",
             data: {keyword:keyword,kecamatan:kecamatan},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                $("#result2","#form_add").html(html);
             }
          })
      });

      $("#keyword2","#form_add").keypress(function(e){
         keyword = $(this).val();
         kecamatan = $("select[name='kecamatan']","#form_add").val()
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result2","#form_add").html(html);
               }
            })
         }
      });

      $("#browse2").click(function(){
         keyword = $("#keyword2","#dialog_desa").val();
         kecamatan = $("select[name='kecamatan']","#form_add").val()
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result2","#form_add").html(html);
               }
            })
      });


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

            $('#rembug_table').dataTable({
                "bDestroy":true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": site_url+"cif/datatable_rembug_setup",
                "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
                },
                "aoColumns": [
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
        var tbl_id = 'rembug_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#rembug_table .group-checkable').live('change',function () {
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

      $("#rembug_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        branch_code = $("#branch_code").val();
        if(branch_code=="")
        {
          alert("Mohon pilih Kantor Cabang terlebih dahulu!");
        }
        else
        {

          $("#wrapper-table").hide();
          $("#add").show();
          form1.trigger('reset');
          var branch_code = $("#branch_code").val();
          //mendapatkan jumlah maksimal
          $.ajax({
            url: site_url+"cif/get_ajax_branch_code_",
            type: "POST",
            dataType: "html",
            data: {branch_code:branch_code},
            success: function(response)
            {
              $("#id_rembug").val(response);
            }
          })

          $.ajax({
            type: "POST",
            url: site_url+"cif/search_fa_name",
            data: {branch_code:branch_code},
            dataType: "json",
            success: function(response){
              var option = '<option value="">PILIH</option>';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].fa_code+'">'+response[i].fa_name+'</option>';
              }
              // console.log(option);
              $("#petugas_lapangan").html(option);
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
              id_rembug: {
                  minlength: 4,
                  required: true
              },
              nama_rembug: {
                  required: true
              },
              petugas_lapangan: {
                  required: true
              },
              tanggal_pembentukan: {
                  required: true
              },
              hari_transaksi: {
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
        var cm_id = $(this).attr('cm_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {cm_id:cm_id},
          url: site_url+"cif/get_user_by_cm_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');

            //Ajax untuk menangkap nama petugas sesuai branch code di form edit 
              var code = response.cm_code;
              var branch_code = $("#branch_code").val()
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_fa_name",
              data: {branch_code:branch_code},
              async : false,
              dataType: "json",
              success: function(responsed){
                var option = '<option value="">PILIH</option>';
                for(i = 0 ; i < responsed.length ; i++){
                  option += '<option value="'+responsed[i].fa_code+'">'+responsed[i].fa_name+'</option>';
                }
                // console.log(option);
                $("#form_edit select[name='petugas_lapangan']").html(option);

              }
            });

            $("#form_edit input[name='cm_id']").val(response.cm_id);
            $("#form_edit input[name='nama_rembug']").val(response.cm_name);
            $("#form_edit input[name='desa_code']").val(response.desa_code);
            $("#form_edit input[name='desa']").val(response.desa);
            $("#form_edit select[name='hari_transaksi']").val(response.hari_transaksi);
            fa_code = response.fa_code;
            $("#form_edit select[name='petugas_lapangan']").val(fa_code);


          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              cm_name: {
                  minlength: 4,
                  required: true
              },
              fa_code: {
                  minlength: 4,
                  required: true
              },
              hari_transaksi: {
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
              url: site_url+"cif/edit_rembug",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#rembug_table_filter input").val('');
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
      $('#rembug_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_rembug_setup",
          "aoColumns": [
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
