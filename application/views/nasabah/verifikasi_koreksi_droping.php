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
      Verifikasi Koreksi Droping
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Verifikasi Koreksi Droping</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Tabel Koreksi</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <p>
      <table class="table table-striped table-bordered table-hover" id="data_koreksi_table">
         <thead>
            <tr>
               <th width="20%">No. Pembiayaan</th>
               <th width="25%">Nama Nasabah</th>
               <th width="20%">Tgl Koreksi</th>
               <th width="20%">Koreksi Oleh</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN DATA KOREKSI -->
<div id="add" style="display:none;">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Data Koreksi Droping</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_act" class="form-horizontal">
            <input type="hidden" name="log_id" id="log_id">
            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Produk</label>
               <div class="controls">
                  <input name="product_name" id="product_name" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <hr size="1">
            <table width="60%" cellpadding="10" style="border:solid 1px #CCC;margin-bottom:10px;">
              <tr>
                <td width="50%" valign="top">
                  <fieldset>
                    <legend style="margin-bottom:0 !important;">Data Droping Sebelumnya</legend>
                    <div class="control-group">
                       <label class="control-label">Nominal Pembiayaan</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="pokok" id="pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu</label>
                       <div class="controls">
                          <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:30px;"/>
                          <span id="periode_jangka_waktu" style="line-height:35px;"></span>
                          <p id="test"></p>
                          <input type="hidden" id="pjw">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Droping/Akad</label>
                       <div class="controls">
                          <input name="tanggal_droping" id="tanggal_droping" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Angsuran Ke-1</label>
                       <div class="controls">
                          <input name="tanggal_mulai_angsur" id="tanggal_mulai_angsur" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Jatuh Tempo</label>
                       <div class="controls">
                          <input name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_pokok" id="angsuran_pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_margin" id="angsuran_margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                  </fieldset>
                </td>
                <td width="50%" valign="top">
                  <fieldset>
                    <legend style="margin-bottom:0 !important;">Data Droping yang akan Diubah</legend>
                    <div class="control-group">
                       <label class="control-label">Nominal Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="pokok2" id="pokok2" data-required="1" type="text" class="small m-wrap mask-money"  readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Margin<span class="required">*</span></label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="margin2" id="margin2" data-required="1" type="text" class="small m-wrap mask-money"  readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input name="jangka_waktu2" id="jangka_waktu2" data-required="1" type="text" class="m-wrap mask-money" style="width:30px;background-color:#eee"  readonly="readonly"/>
                          <span id="periode_jangka_waktu2" style="line-height:35px;"></span>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Droping/Akad<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_droping2" id="tanggal_droping2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy"  readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_mulai_angsur2" id="tanggal_mulai_angsur2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy"  readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input name="tanggal_jtempo2" id="tanggal_jtempo2" data-required="1" type="text" class="small m-wrap date-mask" placeholder="dd/mm/yyyy"  readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr size="1">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_pokok2" id="angsuran_pokok2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="angsuran_margin2" id="angsuran_margin2" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                  </fieldset>
                </td>
              </tr>
            </table>
            <div class="form-actions">
               <button type="button" class="btn red" id="btn_reject">Reject</button>
               <button type="button" class="btn purple" id="btn_approve">Approve</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END DATA KOREKSI -->
  

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
     
      $("input#mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'data_koreksi_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#form_act").trigger('reset');
        var log_id = $(this).attr('log_id');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {log_id:log_id},
          url: site_url+"rekening_nasabah/get_koreksi_by_log_id",
          success: function(response)
          {
            $("#log_id").val(response.log_id);
            $("#account_financing_no").val(response.account_financing_no);
            $("#nama").val(response.nama);
            $("#product_name").val(response.product_name);            

            /*convert_tanggal_akad*/
            ta=response.tanggal_droping.split('-');
            tanggal_akad=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*convert_tanggal_mulai_angsur*/
            ta=response.tanggal_mulai_angsur.split('-');
            tanggal_mulai_angsur=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*convert_tanggal_jtempo*/
            ta=response.tanggal_jtempo.split('-');
            tanggal_jtempo=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*get desc periode_jangka_waktu*/     

            /*convert_tanggal_akad*/
            ta=response.tanggal_droping2.split('-');
            tanggal_akad2=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*convert_tanggal_mulai_angsur*/
            ta=response.tanggal_mulai_angsur2.split('-');
            tanggal_mulai_angsur2=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*convert_tanggal_jtempo*/
            ta=response.tanggal_jtempo2.split('-');
            tanggal_jtempo2=ta[2]+'/'+ta[1]+'/'+ta[0];
            /*get desc periode_jangka_waktu*/
            switch(response.periode_jangka_waktu){
              case "0":
              var periode ='Hari';
              break;
              case "1":
              var periode ='Minggu';
              break;
              case "2":
              var periode ='Bulan';
              break;
              case "3":
              var periode ='x Jangka Waktu';
              break;
            }           
            $("#tanggal_droping").val(tanggal_akad);
            $("#tanggal_mulai_angsur").val(tanggal_mulai_angsur);
            $("#tanggal_jtempo").val(tanggal_jtempo);
            $("#pokok").val(number_format(response.pokok,0,',','.'));
            $("#margin").val(number_format(response.margin,0,',','.'));
            $("#jangka_waktu").val(response.jangka_waktu);
            $("#periode_jangka_waktu").html(periode);
            $("#angsuran_pokok").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#angsuran_margin").val(number_format(response.angsuran_margin,0,',','.'));

            $("#tanggal_droping2").val(tanggal_akad2);
            $("#tanggal_mulai_angsur2").val(tanggal_mulai_angsur2);
            $("#tanggal_jtempo2").val(tanggal_jtempo2);
            $("#pokok2").val(number_format(response.pokok2,0,',','.'));
            $("#margin2").val(number_format(response.margin2,0,',','.'));
            $("#jangka_waktu2").val(response.jangka_waktu2);
            $("#periode_jangka_waktu2").html(periode);
            $("#angsuran_pokok2").val(number_format(response.angsuran_pokok2,0,',','.'));
            $("#angsuran_margin2").val(number_format(response.angsuran_margin2,0,',','.'));
          }
        });
        $("#wrapper-table").hide();
        $("#add").show();
      });


      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#add").click(function(){
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });


      $("#btn_approve").click(function(){

        var log_id = $("#log_id").val();
       
          var conf = confirm('Approve Koreksi Droping ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/act_approve_koreksi_droping",
              type: "POST",
              dataType: "json",
              data: {log_id:log_id},
              success: function(response){
                if(response.success==true){
                  alert("Success!");
                  $("#add").hide();
                  $("#wrapper-table").show();
                  dTreload();
                }else{
                  alert("Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          
        }

      });


      $("#btn_reject").click(function(){

        var log_id = $("#log_id").val();
       
          var conf = confirm('Reject Koreksi Droping ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/act_reject_koreksi_droping",
              type: "POST",
              dataType: "json",
              data: {log_id:log_id},
              success: function(response){
                if(response.success==true){
                  alert("Rejected!");
                  $("#add").hide();
                  $("#wrapper-table").show();
                  dTreload();
                }else{
                  alert("Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          
        }

      });


      // begin first table
      $('#data_koreksi_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_koreksi_droping",
          // "fnServerParams": function ( aoData ) {
              // aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
          // },
          "aoColumns": [
            null,
            null,
            { "bSortable": false },
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

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
</script>
<!-- END JAVASCRIPTS -->

