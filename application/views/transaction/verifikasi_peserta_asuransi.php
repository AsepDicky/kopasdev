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
      Verifikasi <small>Verifikasi Peserta Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Verifikasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Peserta Asuransi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Peserta Asuransi</div>
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
               <th width="15%">Manfaat</th>
               <th width="15%">Premi</th>
               <th width="14%">Jangka Waktu</th>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_insurance_id" name="account_insurance_id">
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
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" /><input type="hidden" id="branch_code" name="branch_code">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap (sesuai KTP)<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir2" id="tmp_lahir2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir2" id="tgl_lahir2" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product_code2" name="product_code2" disabled="" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($product as $data): ?>
                              <option value="<?php echo $data['insurance_type'];?><?php echo $data['rate_type'];?><?php echo $data['product_code'];?><?php echo $data['rate_code'];?>"><?php echo $data['product_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_no2" id="account_no2" data-required="1" class="medium m-wrap" readonly="" />
                       </div>
                    </div> 
                    <hr>  
                  <div id="type_02">  
                    <div class="control-group">
                       <label class="control-label">Masa Kontrak<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak0" id="awal_kontrak0" data-required="1" class="medium m-wrap" readonly="" /> sd <input type="text" name="akhir_kontrak0" id="akhir_kontrak0" data-required="1" class="medium m-wrap" readonly="" />
                         
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Manfaat Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="benefit_value2" id="benefit_value2" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14" readonly="">
                             <span class="add-on"></span>
                           </div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value02" id="premium_value02" disabled="" maxlength="14">
                             <span class="add-on"></span>
                           </div>
                       </div>
                    </div>  
                    <input type="hidden" id="premium_rate02" name="premium_rate02"> 
                  </div>
                  <div id="type_12">      
                    <div class="control-group">
                       <label class="control-label">Plan<span class="required">*</span></label>
                       <div class="controls">
                         <select id="plan_code2" name="plan_code2" disabled="" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($plan as $data): ?>
                              <option value="<?php echo $data['plan_code'];?>"><?php echo $data['plan_code'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>                           
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" name="premium_value12" id="premium_value12" disabled="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="14">
                             <span class="add-on"></span>
                           </div>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="awal_kontrak12" id="awal_kontrak12" data-required="1" class="medium m-wrap" readonly="" /> sd <input type="text" name="akhir_kontrak12" id="akhir_kontrak12" data-required="1" class="medium m-wrap" readonly="" />
                       </div>
                    </div>  
                  </div>  

                   <div class="control-group">
                       <label class="control-label">Rekening Tabungan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" name="pemegang_rekening" id="pemegang_rekening" data-required="1" class="medium m-wrap" readonly="" />
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Nama Pemegang Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" readonly="" name="nama_pemegang_rekening" id="nama_pemegang_rekening" data-required="1" class="medium m-wrap" readonly="" />   
                       </div>
                    </div>   
            <div class="form-actions">
               <input type="hidden" id="premium_value" name="premium_value">
               <input type="hidden" id="insurance_type" name="insurance_type">
               <input type="hidden" id="saldo_memo" name="saldo_memo">
               <input type="hidden" id="update_saldo_memo" name="update_saldo_memo">
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
          type: "POST",
          dataType: "json",
          data: {account_insurance_id:account_insurance_id},
          url: site_url+"transaction/get_account_insurance_by_account_insurance_id_on_verifikasi",
          success: function(response)
          {
            $("#form_edit input[name='account_insurance_id']").val(response.account_insurance_id);
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit input[name='nama2']").val(response.nama);
            $("#form_edit input[name='panggilan2']").val(response.panggilan);
            $("#form_edit input[name='ibu_kandung2']").val(response.ibu_kandung);
            $("#form_edit input[name='tmp_lahir2']").val(response.tmp_lahir);
            $("#form_edit input[name='tgl_lahir2']").val(response.tgl_lahir);
            $("#form_edit textarea[name='alamat2']").val(response.alamat);
            $("#form_edit input[name='rt_rw2']").val(response.rt_rw);
            $("#form_edit input[name='desa2']").val(response.desa);
            $("#form_edit input[name='kecamatan2']").val(response.kecamatan);
            $("#form_edit input[name='kabupaten2']").val(response.kabupaten);
            $("#form_edit input[name='kodepos2']").val(response.kodepos);
            $("#form_edit input[name='telpon_rumah2']").val(response.telpon_rumah);
            $("#form_edit input[name='telpon_seluler2']").val(response.telpon_seluler);
            $("#form_edit input[name='account_no2']").val(response.account_insurance_no);
            $("#form_edit input[name='insurance_type']").val(response.insurance_type);
            $("#form_edit input[name='pemegang_rekening']").val(response.pemegang_rekening);
            $("#form_edit input[name='saldo_memo']").val(response.saldo_memo);
            //fungsi untuk mendapatkan nama pemegang rekening
                    var pemegang_rekening = $("#pemegang_rekening").val();
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {pemegang_rekening:pemegang_rekening},
                      url: site_url+"transaction/mencari_nama_pemegang_rekening",
                      success: function(response)
                      {
                        $("#nama_pemegang_rekening").val(response.nama);
                      }                 
                    });
            //$("#form_edit input[name='nama_pemegang_rekening']").val(response.nama);
            var rate_type_ = response.rate_type;
              if(rate_type_==1)
              {
                var product_code2 = response.insurance_type+''+response.rate_type+''+response.product_code+''+response.rate_code;            
              }
              else
              {
                var product_code2 = response.insurance_type+''+response.rate_type+''+response.product_code; 
              }
            $("#form_edit select[name='product_code2']").val(product_code2);

            //menampilkan fild-fild sesuai insurance_type
            var insurance_type = response.insurance_type;
            if (insurance_type==0) //pembiayaan || pendidikan
            {
                $("#type_02").show();                
                $("#type_12").hide();
                $("#form_edit input[name='benefit_value2']").val(response.benefit_value);
                $("#form_edit input[name='awal_kontrak0']").val(response.awal_kontrak);
                $("#form_edit input[name='premium_value02']").val(response.premium_value);
                $("#form_edit input[name='akhir_kontrak0']").val(response.akhir_kontrak);
                $("#form_edit input[name='premium_value']").val(number_format(response.premium_value,0,'.',''));
            }
            else //kesehatan
            {
                $("#type_12").show();
                $("#type_02").hide();
                $("#form_edit select[name='plan_code2']").val(response.plan_code);
                $("#form_edit input[name='premium_value12']").val(response.premium_value);
                $("#form_edit input[name='awal_kontrak12']").val(response.awal_kontrak);
                $("#form_edit input[name='akhir_kontrak12']").val(response.akhir_kontrak);
                $("#form_edit input[name='premium_value']").val(number_format(response.premium_value,0,'.',''));
                
            }

            var saldo_memo    = $("#saldo_memo").val();
            var premium_value = $("#premium_value").val();
            var update_saldo_memo = saldo_memo-premium_value;
            $("#update_saldo_memo").val(update_saldo_memo);

              

                     
          }
            
        })

      });
    
    // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

        $("#dialog2").dialog({
          width: 270,
          height: 320,
          autoOpen: false,
          buttons: {
            'OK': function(){
              $("#dialog2").dialog('close');
              var customer_no = $("#result2").val();
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
            }
          }
        });
    $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });
   });
   
   //fungsi untuk menggenerate NO REKENING PADA FORM EDIT
    $(function(){
    
      $("#product2").change(function(){
        var product = $("#product2").val();
          product_code = product.substring(1,5);
        var cif_no = $("#cif_no2").val();  
        //mendapatkan jumlah maksimal sesuai product_code yang dipilih
        $.ajax({
          url: site_url+"transaction/count_cif_by_product_code",
          type: "POST",
          dataType: "json",
          data: {product_code:product_code},
          success: function(response)
          {
            var data = response.jumlah;
            if(data==null)
            {
              var total = 0;
            }
            else
            {
              var total = data;
            }
            var jumlah = parseFloat(total); 
            var no_urut = jumlah+1;
            //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
            $("#account_saving_no2").val(cif_no+''+product_code+''+no_urut);
          }
        })         
        
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
              cif_no: {
                  required: true
              },
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL Yang dipake function ini //ade
            $.ajax({
              type: "POST",
              url: site_url+"transaction/verifikasi_rek_asuransi",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  dTreload();
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



 // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_insurance_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_insurance_id[$i] = $(this).val();

          $i++;

        });

        if(account_insurance_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_rekening_asuransi",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
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

        var account_insurance_id = $("#account_insurance_id").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"transaction/delete_rek_asuransi",
              type: "POST",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
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
              url: site_url+"transaction/verifikasi_rekening_asuransi",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
              success: function(response){
                if(response.success==true){
                  alert("Approve!");
                  $("#insurance_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
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

        var account_insurance_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_insurance_id[$i] = $(this).val();

          $i++;

        });

        if(account_insurance_id.length==0){
          alert("Please select some row to Inapprove !");
        }else{
          var conf = confirm('Are you sure to Inapprove this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/in_verifikasi_rekening_asuransi",
              dataType: "json",
              data: {account_insurance_id:account_insurance_id},
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
      $('#insurance_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_verifikasi_insurance_setup",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false },
            null,
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

