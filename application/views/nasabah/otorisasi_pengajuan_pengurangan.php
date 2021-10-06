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
      Pembiayaan <small>Otorisasi Pengajuan Pengurangan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Otorisasi Pengajuan Pengurangan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Otorisasi Pengajuan Pengurangan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="otorisasi_pengajuan_pengurangan_table">
         <thead>
            <tr>
               <th width="15%">No. Pengajuan</th>
               <th width="25%">Nama Lengkap</th>
               <th width="15%">Produk</th>
               <th width="15%">Nilai Pembiayaan</th>
               <th width="20%">Pengajuan Pengurangan</th>
               <th>&nbsp;</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Otorisasi Pengajuan Pengurangan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="part_id" name="part_id">
          <input type="hidden" id="tanggal_jtempo" name="tanggal_jtempo">
          <input type="hidden" id="counter_angsuran" name="counter_angsuran">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
            </div>
            </br>      
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>             
            <div class="control-group">
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_lengkap" id="nama_lengkap" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>             
            <div class="control-group">
               <label class="control-label">No Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>               
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="produk" id="produk" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="nilai_pembiayaan" id="nilai_pembiayaan" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="saldo_pokok" id="saldo_pokok" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>          
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="saldo_margin" id="saldo_margin" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">Angsuran Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">Angsuran Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="angsuran_margin" id="angsuran_margin" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>        
            <div class="control-group">
               <label class="control-label">Bayar Pokok<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="bayar_pokok" id="bayar_pokok" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>          
            <div class="control-group">
               <label class="control-label">Bayar Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="bayar_margin" id="bayar_margin" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>             
            <div class="control-group">
               <label class="control-label">Potongan Margin<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="potongan_margin" id="potongan_margin" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>              
            <div class="control-group">
               <label class="control-label">Pengajuan Pengurangan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">Rp</span>
                  <input type="text" name="pengajuan_pengurangan" id="pengajuan_pengurangan" class="medium m-wrap mask-money" readonly="" style="background-color:#eee;width:120px !important;"/>
                    <span class="add-on">,00</span>
                  </div>
               </div>
            </div>            
            <div class="form-actions">
               <button type="button" id="act_approve" class="btn purple">Verifikasi</button>
               <button type="button" id="act_reject" class="btn red">Reject</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT  -->


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

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'otorisasi_pengajuan_pengurangan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	   
      // fungsi untuk check all
      jQuery('#otorisasi_pengajuan_pengurangan_table .group-checkable').live('change',function () {
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

      $("#otorisasi_pengajuan_pengurangan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       // event button Edit ketika di tekan
      $("a#link-verif").live('click',function(){        
        form2.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit").show();
        var part_id = $(this).attr('part_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {id:part_id},
          url: site_url+"rekening_nasabah/get_otorisasi_pengajuan",
          success: function(response)
          {
            $("#part_id","#form_edit").val(part_id);
            $("#nik","#form_edit").val(response.cif_no);
            $("#nama_lengkap","#form_edit").val(response.nama);
            $("#no_pembiayaan","#form_edit").val(response.account_financing_no);
            $("#produk","#form_edit").val(response.product_name);
            $("#tanggal_jtempo","#form_edit").val(response.tanggal_jtempo);
            $("#counter_angsuran","#form_edit").val(response.counter_angsuran);
            $("#nilai_pembiayaan","#form_edit").val(number_format(response.pokok,0,',','.'));
            $("#saldo_pokok","#form_edit").val(number_format(response.saldo_pokok,0,',','.'));
            $("#saldo_margin","#form_edit").val(number_format(response.saldo_margin,0,',','.'));
            $("#angsuran_pokok","#form_edit").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#angsuran_margin","#form_edit").val(number_format(response.angsuran_margin,0,',','.'));
            $("#bayar_pokok","#form_edit").val(number_format(response.bayar_pokok,0,',','.'));
            $("#bayar_margin","#form_edit").val(number_format(response.bayar_margin,0,',','.'));
            $("#potongan_margin","#form_edit").val(number_format(response.potongan_margin,0,',','.'));
            $("#pengajuan_pengurangan","#form_edit").val(number_format(response.pengajuan_pengurangan,0,',','.'));
          }
        });
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
        App.scrollTo($("#wrapper-table"),-200);
      });

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_financing_reg_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_reg_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_reg_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/delete_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
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

      // fungsi untuk TOLAK PENGAJUAN
      $("#act_reject").live('click',function()
      {
          var part_id = $("#part_id").val();
          var conf = confirm('Reject Otorisasi Pengajuan Hutang ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/do_del_otorisasi_pengajuan_pengurangan",
              dataType: "json",
              data: {part_id:part_id},
              success: function(response){
                if(response.success==true){
                  alert("Reject otorisasi pengajuan hutang berhasil diproses");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Reject otorisasi pengajuan hutang gagal diproses");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });

      $("#act_approve").live('click',function()
      {
          var part_id = $("#part_id","#form_edit").val();
          var nik = $("#nik","#form_edit").val();
          var no_pembiayaan = $("#no_pembiayaan","#form_edit").val();
          var nilai_pembiayaan = $("#nilai_pembiayaan","#form_edit").val();
          var saldo_pokok = $("#saldo_pokok","#form_edit").val();
          var saldo_margin = $("#saldo_margin","#form_edit").val();
          var angsuran_pokok = $("#angsuran_pokok","#form_edit").val();
          var angsuran_margin = $("#angsuran_margin","#form_edit").val();
          var bayar_pokok = $("#bayar_pokok","#form_edit").val();
          var bayar_margin = $("#bayar_margin","#form_edit").val();
          var potongan_margin = $("#potongan_margin","#form_edit").val();
          var pengajuan_pengurangan = $("#pengajuan_pengurangan","#form_edit").val();
          var tanggal_jtempo = $("#tanggal_jtempo","#form_edit").val();
          var conf = confirm('Otorisasi Pengajuan Pengurangan Hutang ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/do_act_otorisasi_pengajuan_pengurangan",
              dataType: "json",
              data: {
                 part_id:part_id
                ,nik:nik
                ,no_pembiayaan:no_pembiayaan
                ,nilai_pembiayaan:nilai_pembiayaan
                ,saldo_pokok:saldo_pokok
                ,saldo_margin:saldo_margin
                ,angsuran_pokok:angsuran_pokok
                ,angsuran_margin:angsuran_margin
                ,bayar_pokok:bayar_pokok
                ,bayar_margin:bayar_margin
                ,potongan_margin:potongan_margin
                ,pengajuan_pengurangan:pengajuan_pengurangan
                ,tanggal_jtempo:tanggal_jtempo
              },
              success: function(response){
                if(response.success==true){
                  alert("Otorisasi berhasil diproses");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Otorisasi gagal diproses");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });


      // begin first table
      $('#otorisasi_pengajuan_pengurangan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_otorisasi_pengajuan_pengurangan",
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
                  'aTargets': [5]
              }
          ]
      });


});
</script>
<!-- END JAVASCRIPTS -->

