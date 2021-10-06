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
      Verifikasi <small>Verifikasi Klaim Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Verifikasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Klaim Asuransi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Klaim Asuransi</div>
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
      <table class="table table-striped table-bordered table-hover" id="insurance_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#insurance_table .checkboxes" /></th>
               <th width="20%">Nomor Rekening</th>
               <th width="18%">Nama</th>
               <th width="17%">Produk</th>
               <th width="15%">Jenis Klaim</th>
               <th width="15%">Jumlah Klaim</th>
               <th width="10%">Action</th>
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
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Klaim Asuransi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="insurance_claim_id" name="insurance_claim_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Successful!
            </div>
          </br>
                    <div class="control-group">
                       <label class="control-label">No Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" name="no_rekening" id="no_rekening" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Nama <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tempat_lahir" id="tempat_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" readonly="" style="background-color:#eee;width:100px;"/>
                       </div>
                    </div> 
                    <hr>
                    <div class="control-group">
                       <label class="control-label">Produk <span class="required">*</span></label>
                       <div class="controls">
                          <input type="hidden" id="insurance_type" name="insurance_type">
                          <input type="text" name="produk" id="produk" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <hr>  
                  <div id="ins_tipe0">
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak" id="awal_kontrak" data-required="1" readonly="" style="background-color:#eee;width:100px"/> sd <input type="text" readonly="" style="background-color:#eee;width:100px;" name="akhir_kontrak" id="akhir_kontrak" data-required="1"/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Manfaat Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;" maxlength="10" name="benefit_value" id="benefit_value" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" style="background-color:#eee;" name="premium_value" id="premium_value" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>  
                    <hr>  
                  </div>
                 <div id="ins_tipe1">    
                    <div class="control-group">
                       <label class="control-label">Plan<span class="required">*</span></label>
                       <div class="controls">
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;" name="plan" id="plan">
                       </div>
                    </div>                           
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value1" id="premium_value1" style="background-color:#eee;" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak1" id="awal_kontrak1" data-required="1" style="background-color:#eee;width:100px" readonly=""/> sd <input type="text" readonly=""  style="background-color:#eee;width:100px" name="akhir_kontrak1" id="akhir_kontrak1" data-required="1"/>
                       </div>
                    </div>  
                    <hr>
                  </div>
                    <div class="control-group">
                       <label class="control-label">Rekening Tabungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" style="background-color:#eee;" name="rekening_tabungan" id="rekening_tabungan" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Nama Pemegang Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" style="background-color:#eee;" name="nama_pemegang_rek" id="nama_pemegang_rek" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>  
                    <hr>
                    <div class="control-group">
                       <label class="control-label">Jenis Klaim<span class="required">*</span></label>
                       <div class="controls">
                         <select id="jenis_klaim" readonly="" style="background-color:#eee;" name="jenis_klaim" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="0">Meninggal Dunia</option>
                              <option value="2">Nilai Tunai</option>
                              <option value="3">Rawat Jalan</option>
                              <option value="4">Rawat Inap</option>
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Klaim (Kejadian)<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_klaim" readonly="" style="background-color:#eee;" id="mask_date" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>    
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
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
    
      $("#awal_kontrak06").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#awal_kontrak16").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#akhir_kontrak06").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#akhir_kontrak16").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'insurance_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
    

      // fungsi untuk check all
      jQuery('#insurance_table .group-checkable').live('change',function () {
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

      $("#rekening_tabungan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

       // saat klik verifikasi Yang dipake function ini //ade
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_insurance_id = $(this).attr('account_insurance_id');
              $.ajax({
                type:"POST",
                async: false,
                dataType: "json",
                url: site_url+"rekening_nasabah/search_cif_by_account_insurance_id",
                data:{account_insurance_id:account_insurance_id},
                success: function(response)
                {
                    $("#insurance_claim_id").val(response.insurance_claim_id);
                    $("#no_rekening").val(response.account_insurance_no);
                    $("#nama").val(response.nama);
                    $("#tempat_lahir").val(response.tmp_lahir);
                    $("#tgl_lahir").val(response.tgl_lahir);
                    $("#form_add textarea[name='alamat']").val(response.alamat);
                    $("#rt_rw").val(response.rt_rw);
                    $("#desa").val(response.desa);
                    $("#kecamatan").val(response.kecamatan);
                    $("#kabupaten").val(response.kabupaten);
                    $("#kode_pos").val(response.kode_pos);
                    $("#telpon_rumah").val(response.telpon_rumah);
                    $("#produk").val(response.product_name); 
                    $("#jatuh_tempo").val(response.tanggal_jtempo_last); 
                    $("#awal_kontrak").val(response.awal_kontrak); 
                    $("#akhir_kontrak").val(response.akhir_kontrak); 
                    $("#benefit_value").val(response.benefit_value); 
                    $("#awal_kontrak1").val(response.awal_kontrak); 
                    $("#akhir_kontrak1").val(response.akhir_kontrak); 
                    $("#premium_value1").val(number_format(response.premium_value,0,'.','')); 
                    $("#plan").val(response.plan_code); 
                    $("#rekening_tabungan").val(response.account_saving_no); 
                    $("#jenis_klaim").val(response.type_claim); 
                    var tanggal_pengajuan = response.date_claim;
                    var tgl_pengajuan = tanggal_pengajuan.substring(8,10);
                    var bln_pengajuan = tanggal_pengajuan.substring(5,7);
                    var thn_pengajuan = tanggal_pengajuan.substring(0,4);
                    var tgl_akhir_pengajuan = tgl_pengajuan+"/"+bln_pengajuan+"/"+thn_pengajuan;  
                    $("#form_edit input[name='tgl_klaim']").val(tgl_akhir_pengajuan);
                    //fungsi untuk menyembunyikan input jadwal angsuran jika value=0
                    var insurance_type =  response.insurance_type;
                    if(insurance_type=='1')
                    {
                        $("#ins_tipe1").show();
                        $("#ins_tipe0").hide();
                    }
                    else
                    {
                        $("#ins_tipe1").hide();
                        $("#ins_tipe0").show();
                    }
                    
                    var account_saving_no = response.account_saving_no;
                      if(account_saving_no!="")
                      {
                        $.ajax({
                          type:"POST",
                          url: site_url+"transaction/search_name_by_account_saving_no_klaim",
                          data:{account_saving_no:account_saving_no},
                          dataType:"json",
                          success: function(response)
                          {
                            $("#nama_pemegang_rek").val(response.nama); 
                          }
                        });
                      }
                }
              });
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
              no_rekening: {
                  required: true
              },
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL Yang dipake function ini //ade
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/proses_verifikasi_klaim_asuransi",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#insurance_table_filter input").val('');
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

      $("#btn_reject").click(function(){

        var insurance_claim_id = $("#insurance_claim_id").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/reject_data_klaim_asuransi",
              type: "POST",
              dataType: "json",
              data: {insurance_claim_id:insurance_claim_id},
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

      });



      $("#btn_activate").click(function(){

        var account_insurance_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_insurance_id[$i] = $(this).val();

          $i++;

        });

        if(account_insurance_id.length==0){
          alert("Please select some row to Approve !");
        }else{
          var conf = confirm('Are you sure to Approve this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/proses_verifikasi_klaim_asuransi",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
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


      // begin first table
      $('#insurance_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_insurance_klaim",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false },
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


      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
              var customer_no = $("#result").val();
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#cif_no").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no",
                      success: function(response)
                      {
                        $("#branch_code").val(response.branch_code);
                        $("#nama").val(response.nama);
                        $("#panggilan").val(response.panggilan);
                        $("#ibu_kandung").val(response.ibu_kandung);
                        $("#tmp_lahir").val(response.tmp_lahir);
                        $("#tgl_lahir").val(response.tgl_lahir);
                        $("#alamat").val(response.alamat);
                        $("#rt_rw").val(response.rt_rw);
                        $("#desa").val(response.desa);
                        $("#kecamatan").val(response.kecamatan);
                        $("#kabupaten").val(response.kabupaten);
                        $("#kodepos").val(response.kodepos);
                        $("#telpon_rumah").val(response.telpon_rumah);
                        $("#telpon_seluler").val(response.telpon_seluler);
                        $("#rekening_tabungan").val(response.account_saving_no);
                        $("#nama_pemegang_rek").val(response.nama);
                      }                 
                    });
            
        });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          $.ajax({
            type: "POST",
            url: site_url+"cif/search_cif_no",
            data: {keyword:$("#keyword").val(),cif_type:type},
            dataType: "json",
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
              }
              // console.log(option);
              $("#result").html(option);
            }
          });
        })

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });
	});


// fungsi untuk mencari Nama Pemegang Rekening
      $(function(){

       $("#select_bawah").click(function(){
         result = $("#result_bawah").val();
              var customer_no = $("#result_bawah").val();
              $("#close_bawah","#dialog_rembug_bawah").trigger('click');
              //alert(customer_no);
              $("#cif_no").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no2",
                      success: function(response)
                      {
                        $("#rekening_tabungan").val(response.account_saving_no);
                        $("#nama_pemegang_rek").val(response.nama);
                      }                 
                    });
            
        });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          $.ajax({
            type: "POST",
            url: site_url+"cif/search_cif_no",
            data: {keyword:$("#keyword_bawah").val(),cif_type:type},
            dataType: "json",
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
              }
              // console.log(option);
              $("#result_bawah").html(option);
            }
          });
        })

        $("#keyword_bawah").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result_bawah").html(option);
              }
            });
          }
        });
      


  });


      //fungsi untuk menampilkan input SESUAI PRODUK YANG DIPILIH
      $(function(){
  
          $("#product_code").change(function(){
                   var dob = $("#tgl_lahir").val();
                            var year=Number(dob.substr(0,4));
                            var month=Number(dob.substr(5,2))-1;
                            var day=Number(dob.substr(7,2));
                            var today=new Date();
                            var age=today.getFullYear()-year;
                            if(today.getMonth()<month || (today.getMonth()==month && today.getDate()<day)){age--;}                            
                    var usia = age;
                    $("#usia").val(usia);
                    // var o = $("#product_code").val();
                    // alert(o);
           $("#akhir_kontrak0").change(function(){
              var awal = $("#awal_kontrak0").val();
                var akhir = $("#akhir_kontrak0").val();
                var tanggal = awal+'-'+akhir;
                $.ajax({
                   url: site_url+"transaction/menghitung_tahun",
                   type: "POST",
                   dataType: "html",
                   data: {tanggal:tanggal},
                   success: function(response)
                   {
                    $("#jumlah_tahun0").val(response);
                   }
                })
           });
            var cif_no = $("#cif_no").val();
            var product = $("#product_code").val();
            var insurance_type = product.substring(0,1);             
            var rate_type = product.substring(1,2);
            var product_code = product.substring(2,5); 
            var rate_code = product.substring(5,8); 
            $("#rate_type").val(rate_type);
              if(insurance_type=='0')
              {
                $("#type_0").show();
                $("#type_1").hide();
              }
              else if(insurance_type=='1')
              {
                $("#type_1").show();
                $("#type_0").hide();
              }
              else
              {
                $("#type_1").hide();
                $("#type_0").hide();
              }
            $.ajax({
              url: site_url+"transaction/count_account_no_by_product_code",
              type: "POST",
              dataType: "html",
              data: {product_code:product_code},
              success: function(response)
              {
                $("#account_no").val(cif_no+''+response);
              }
            })

            if(rate_type==0)
             { 
               $("#benefit_value").change(function(){
                   var benefit_value = $("#benefit_value").val();
                   var awal = $("#awal_kontrak0").val();
                    var akhir = $("#akhir_kontrak0").val();
                    var tanggal = awal+'-'+akhir;
                    $.ajax({
                       url: site_url+"transaction/menghitung_tahun",
                       type: "POST",
                       dataType: "html",
                       data: {tanggal:tanggal},
                       success: function(response)
                       {
                        $("#jumlah_tahun0").val(response);
                       }
                    })
                    $.ajax({
                       url: site_url+"transaction/count_premi_rate_0",
                       type: "POST",
                       dataType: "html",
                       data: {benefit_value:benefit_value},
                       success: function(response)
                       {
                         $("#premium_value0").val(response);
                         $("#premium_rate0").val(response/benefit_value);
                       }
                    })
               }); 
             }
             else if(rate_type==1)
             { 
               $("#benefit_value").change(function(){
                    var benefit_value = $("#benefit_value").val();                    
                    var jumlah_tahun=  $("#jumlah_tahun0").val();
                    var benefit_value = $("#benefit_value").val();
                    var param = rate_code+'-'+usia+'-'+jumlah_tahun+'-'+benefit_value;
                    $.ajax({
                       url: site_url+"transaction/count_premi_rate_1",
                       type: "POST",
                       dataType: "html",
                       data: {param:param},
                       success: function(response)
                       {
                         $("#premium_value0").val(response);
                         $("#premium_rate0").val(response/benefit_value);
                       }
                    })
               }); 
             }
             else if(rate_type==2)
             {
               $("#plan_code").change(function(){               
                   var plan_code = $("#plan_code").val();
                       premium_value1 = plan_code.substring(8,20);
                       $("#premium_value1").val(premium_value1);
                
               }); 
             }
            
          });     
          
      });
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

