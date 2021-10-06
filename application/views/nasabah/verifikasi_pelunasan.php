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
			Verifikasi Pelunasan Pembiayaan<small> Verifikasi Pelunasan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Verifikasi Pelunasan Pembiayaan</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Pelunasan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
           <button id="btn_verification" class="btn red">
             Verifikasi <i class="icon-checklist"></i>
           </button>
        </div>
         <!-- <label>
            Rembug Pusat &nbsp; : &nbsp;
            <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled>
            <input type="hidden" name="cm_code" id="cm_code">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <input type="submit" id="filter" value="Filter" class="btn blue">
         </label> -->
      </div>

      <!--
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
      -->
      <p>
      <table class="table table-striped table-bordered table-hover" id="pelunasan_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pelunasan_pembiayaan_table .checkboxes" /></th>
               <th width="25%">No. Rekening</th>
               <th width="20%">Nama</th>
               <th width="20%">Akad</th>
               <th width="15%">Jangka Waktu</th>
               <!-- <th width="25%">Pembiayaan</th>
               <th width="25%">Pembayaran</th> -->
               <th>Verifikasi</th>
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
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Data Pelunasan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_financing_lunas_id" name="account_financing_lunas_id">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
            <input type="hidden" id="cif_no" name="cif_no">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Pelunasan Pembiayaan Berhasil Di Proses !
            </div>

            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_panggilan" id="panggilan" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_ibu" id="ibu_kandung" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tempat_lahir" id="tmp_lahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" readonly="" class="medium m-wrap" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" readonly="" maxlength="3" style="background-color:#eee;width:30px;" /> Tahun
                  <span class="help-inline"></span>&nbsp;
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="produk" id="produk" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Akad<span class="required">*</span></label>
               <div class="controls">
                  <input name="akad" id="akad" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="pokok_pembiayaan" id="pokok_pembiayaan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div>   
                  Nisbah Bagi Hasil
                  &nbsp;
                  <span class="help-inline"></span>
                   <input name="nisbah_bagihasil" id="nisbah_bagihasil" data-required="1" style="background-color:#eee;width:50px;" type="text" class="m-wrap" readonly="readonly"/> %
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" id="jangka_waktu" name="jangka_waktu" style="background-color:#eee;width:30px;"  maxlength="3" /> Bulan/Minggu/Hari
                  <span class="help-inline"></span>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_jtempo" id="input-mask" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_pokok" id="saldo_pokok" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div>  
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                     <input name="saldo_margin" id="saldo_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Saldo Tabungan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_tabungan" id="saldo_tabungan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Potongan Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
               <span class="add-on">Rp</span>
                  <input name="potongan_margin" id="potongan_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Pembayaran<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
               <span class="add-on">Rp</span>
                  <input name="total_pembayaran" id="total_pembayaran" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
               <span class="add-on">,00</span>
               </div> 
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Debet Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input name="debet_rekening" id="debet_rekening" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group hide">
               <label class="control-label">Saldo Rekening<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">Rp</span>
                  <input name="saldo_rekening" id="saldo_rekening" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kas/Bank<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium" id="account_cash_code" name="account_cash_code" disabled="" style="background-color:#eee;">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas): ?>
                    <option value="<?php echo $kas['account_code'] ?>"><?php echo $kas['account_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <input placeholder="dd/mm/yyyy" readonly="" name="trx_date" id="trx_date" data-required="1" type="text" class="small m-wrap" style="background-color:#eee;"/>
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

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelunasan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pelunasan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_lunas_id = $(this).attr('account_financing_lunas_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_lunas_id:account_financing_lunas_id},
          url: site_url+"rekening_nasabah/get_financing_by_id",
          success: function(response){
            // console.log(response);
            form2.trigger('reset');
               $("#form_edit input[name='account_financing_lunas_id']").val(response.account_financing_lunas_id);
               $("#form_edit input[name='account_financing_id']").val(response.account_financing_id);
               $("#form_edit input[name='cif_no']").val(response.cif_no);
               $("#form_edit input[name='no_pembiayaan']").val(response.account_financing_no);
               $("#form_edit input[name='nama_lengkap']").val(response.nama);
               $("#form_edit input[name='nama_panggilan']").val(response.panggilan);
               $("#form_edit input[name='nama_ibu']").val(response.ibu_kandung);
               $("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
               $("#form_edit input[name='tanggal_lahir']").val(response.tgl_lahir);
               $("#form_edit input[name='usia']").val(response.usia);
               $("#form_edit input[name='produk']").val(response.product_name);
               $("#form_edit input[name='akad']").val(response.akad_name);
               $("#form_edit input[name='pokok_pembiayaan']").val(number_format(response.pokok,0,',','.'));
               $("#form_edit input[name='margin_pembiayaan']").val(number_format(response.margin,0,',','.'));
               $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
               $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
               $("#form_edit input[name='tanggal_jtempo']").val(App.ToDatePicker(response.tanggal_jtempo));
               $("#form_edit input[name='saldo_pokok']").val(number_format(response.saldo_pokok,0,',','.'));
               $("#form_edit input[name='saldo_margin']").val(number_format(response.saldo_margin,0,',','.'));
               $("#form_edit input[name='saldo_tabungan']").val(number_format(response.saldo_catab,0,',','.'));
               $("#form_edit input[name='debet_rekening']").val(response.account_saving_no);
               $("#form_edit input[name='potongan_margin']").val(number_format(response.potongan_margin,0,',','.'));
               $("#form_edit #trx_date").val(App.ToDatePicker(response.trx_date));
               $("#form_edit #account_cash_code").val(response.account_cash_code).trigger('liszt:updated');

               saldo_pokok      = parseFloat(response.saldo_pokok);
               saldo_margin     = parseFloat(response.saldo_margin);
               potongan_margin  = parseFloat(response.potongan_margin);
               total_pembayaran = saldo_pokok+saldo_margin-potongan_margin;
               $("#total_pembayaran","#form_edit").val(number_format(total_pembayaran,0,',','.'));
               $("#saldo_rekening","#form_edit").val(number_format(response.saldo_memo+total_pembayaran,0,',','.'));
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              potongan_margin: {
                  required: true
              }
          },
         submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/proses_verifikasi_pelunasan_pembayaran",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#pelunasan_pembiayaan_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo($('body'), 0);
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo($('body'), 0);
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

      $("#btn_reject").click(function(){

        var account_financing_lunas_id = $("#account_financing_lunas_id").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/reject_data_pelunasan_pembiayaan",
              type: "POST",
              dataType: "json",
              data: {account_financing_lunas_id:account_financing_lunas_id},
              success: function(response){
                if(response.success==true){
                  $("#pelunasan_pembiayaan_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert("Reject!");
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


      // begin first table
      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pelunasan_pembiayaan",
          // "fnServerParams": function ( aoData ) {
              // aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
          // },
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

            // begin first table
            $('#pelunasan_pembiayaan_table').dataTable({
               "bDestroy":true,
               "bProcessing": true,
               "bServerSide": true,
               "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pelunasan_pembiayaan",
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
               "sZeroRecords" : "Data Pada Rembug ini Kosong",
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

      $("#result option:selected").live('dblclick',function(){
        $("#select").trigger('click');
      });

      $("#result option").live('dblclick',function(){
         $("#select").trigger('click');
      });
   
      $("select[name='branch']","#dialog_rembug").change(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         var branch = $("select[name='branch']","#dialog_rembug").val();
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
            var branch = $("select[name='branch']","#dialog_rembug").val();
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
         }
      });

      $("#browse_rembug").click(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         branch = $("select[name='branch']","#dialog_rembug").val();
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


      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

      $("#btn_verification").click(function(){

        var financing_lunas_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          financing_lunas_id[$i] = $(this).val();

          $i++;

        });

        if(financing_lunas_id.length==0){

          alert("Please select some row to verification !");

        }else{

          var conf = confirm('Apakah benar akan melakukan verifikasi ?');

          if(conf){
            for (var key in financing_lunas_id) {
                if (financing_lunas_id.hasOwnProperty(key)) {
                    // console.log(key + " -> " + financing_lunas_id[key]);

                     $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {account_financing_lunas_id:financing_lunas_id[key]},
                        url: site_url+"rekening_nasabah/get_financing_by_id",
                        success: function(response){
                           // console.log(response);

                           saldo_pokok      = parseFloat(response.saldo_pokok);
                           saldo_margin     = parseFloat(response.saldo_margin);
                           potongan_margin  = parseFloat(response.potongan_margin);
                           total_pembayaran = saldo_pokok+saldo_margin-potongan_margin;
                           $("#total_pembayaran","#form_edit").val(number_format(total_pembayaran,0,',','.'));
                           $("#saldo_rekening","#form_edit").val(number_format(response.saldo_memo+total_pembayaran,0,',','.'));
                           
                           var data_form = {
                              "account_financing_lunas_id" : response.account_financing_lunas_id,
                              "account_financing_id" : response.account_financing_id,
                              "cif_no" : response.cif_no,
                              "no_pembiayaan" : response.account_financing_no,
                              "nama_lengkap" : response.nama,
                              "nama_panggilan" : response.panggilan,
                              "nama_ibu" : response.ibu_kandung,
                              "tempat_lahir" : response.tmp_lahir,
                              "tanggal_lahir" : response.tgl_lahir,
                              "usia" : response.usia,
                              "produk" : response.product_name,
                              "akad" : response.akad_name,
                              "pokok_pembiayaan" : number_format(response.pokok,0,',','.'),
                              "margin_pembiayaan" : number_format(response.margin,0,',','.'),
                              "jangka_waktu" : response.jangka_waktu,
                              "nisbah_bagihasil" : response.nisbah_bagihasil,
                              "tanggal_jtempo" : App.ToDatePicker(response.tanggal_jtempo),
                              "saldo_pokok" : number_format(response.saldo_pokok,0,',','.'),
                              "saldo_margin" : number_format(response.saldo_margin,0,',','.'),
                              "saldo_tabungan" : number_format(response.saldo_catab,0,',','.'),
                              "debet_rekening" : response.account_saving_no,
                              "potongan_margin" : number_format(response.potongan_margin,0,',','.'),
                              "total_pembayaran" : number_format(total_pembayaran,0,',','.')
                           }

                           // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
                           $.ajax({
                             type: "POST",
                             url: site_url+"rekening_nasabah/proses_verifikasi_pelunasan_pembayaran",
                             dataType: "json",
                             data: data_form,
                             success: function(response){
                               if(response.success==true){
                                 var tbl_id = 'pelunasan_pembiayaan_table';
                                 $("select[name='"+tbl_id+"_length']").trigger('change');
                                 $(".paging_bootstrap li:first a").trigger('click');
                                 $("#"+tbl_id+"_filter input").trigger('keyup');
                               }else{
                                 App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                               }
                               App.scrollTo($('body'), 0);
                             },
                             error:function(){
                                 App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                             }
                           });
                        }
                     })
                }
            }
          }
        }
      });

</script>

<!-- END JAVASCRIPTS -->
