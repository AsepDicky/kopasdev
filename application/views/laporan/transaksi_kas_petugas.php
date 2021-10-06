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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Laporan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Transaksi Kas Petugas</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="javascript:;" id="export_pdf">Save as PDF</a></li>
               <li><a href="javascript:;" id="export_excel">Export to Excel</a></li>
            </ul>
         </div> -->
            <!-- BEGIN FILTER-->
              <table id="sorting_saldo">
                <tr>
                  <td width="120">Kode Kas</td>
                  <td>
                      <input type="text" name="account_cash_name" id="account_cash_name" data-required="1" class="large m-wrap" readonly="" style="background:#EEE;" /><input type="hidden" id="branch_id" name="branch_id">
                        <input type="hidden" id="account_cash_code" name="account_cash_code">
                          <div id="dialog_code_cash" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari Kode Kas Petugas</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                                      <input type="hidden" id="account_type" name="account_type" value="0">
                                      <!-- <p><select name="account_type" id="account_type" class="span12 m-wrap">
                                      <option value="">Pilih Tipe Account</option>
                                      <option value="">All</option>
                                      <option value="0">Kas Petugas</option>
                                      <option value="1">Kas Teller</option>
                                      </select></p>    -->                 
                                      <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select_dialog" class="btn blue">Select</button>
                             </div>
                          </div>
                        <a id="browse_code_cash" class="btn blue" data-toggle="modal" href="#dialog_code_cash">...</a>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td width="100" valign="top">Pemegang Kas</td>
                  <td valign="top"><input type="text" name="pemegeng_kas" id="pemegeng_kas" tabindex="2" readonly="" style="width:200px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td width="100" valign="top">Tanggal</td>
                  <td valign="top">
                    <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $current_date; ?>" class="mask_date date-picker" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> sd 
                    <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $current_date; ?>" class="mask_date date-picker" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td valign="bottom" style="padding-bottom:5px;">
                    <button type="button" id="select" tabindex="5" class="btn green search">FILTER</button>
                    <button type="button" id="export_pdf" tabindex="5" class="btn green search">Preview</button>
                    <button type="button" id="export_excel" tabindex="5" class="btn green search">Preview Excel</button>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            <p><hr></p>
          <!-- END FILTER-->
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <th style="text-align:center" width="4%">No</th>
               <th style="text-align:center" width="12%">Tanggal</th>
               <th style="text-align:center" width="37%">Keterangan</th>
               <th style="text-align:center" width="15%">Debet</th>
               <th style="text-align:center" width="15%">Kredit</th>
               <th style="text-align:center" width="16%">Saldo</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


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
    
      $("#tanggal").inputmask("d/m/y", {autoUnmask: true});  //direct mask   
      $("#tanggal2").inputmask("d/m/y", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'transaksi_kas_petugas';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
    

      // fungsi untuk check all
      jQuery('#transaksi_kas_petugas .group-checkable').live('change',function () {
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

      $("#transaksi_kas_petugas .checkboxes").livequery(function(){
        $(this).uniform();
      });




      $("#select").click(function(){

         account_cash_code = $("#account_cash_code").val();
         tanggal = $("#tanggal").val();
         tanggal2 = $("#tanggal2").val();
         
         var bValid = true;
         
         if(account_cash_code==""){
          bValid = false;
         }

         if(tanggal==""){
          bValid = false;
         }

         if(tanggal2==""){
          bValid = false;
         }

         if(bValid == true)
         {
              $('#transaksi_kas_petugas').dataTable({
                   "bDestroy":true,
                   "bProcessing": true,
                   "bServerSide": true,
                   "sAjaxSource": site_url+"laporan/datatable_transaksi_kas_petugas",
                   "fnServerParams": function ( aoData ) {
                        aoData.push( { "name": "tanggal", "value": $("#tanggal").val() } );
                        aoData.push( { "name": "tanggal2", "value": $("#tanggal2").val() } );
                        aoData.push( { "name": "account_cash_code", "value": $("#account_cash_code").val() } );
                    },
                   "aoColumns": [
                     null,
                     { "bSortable": false, "bSearchable": false },
                     { "bSortable": false, "bSearchable": false },
                     { "bSortable": false, "bSearchable": false },
                     { "bSortable": false, "bSearchable": false },
                     { "bSortable": false, "bSearchable": false }
                   ],
                   "aLengthMenu": [
                       [999999999999999],
                       ["All"] // change per page values here
                   ],
                   // set the initial value
                   "iDisplayLength": 999999999999999,
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
                $(".dataTables_filter").parent().hide();
         }
         else
         {
            alert("Parameter Belum Lengkap !");
         }

      });

  $("#result option:selected").live('dblclick',function(){
    $("#select_dialog").trigger('click');
  });

      // fungsi untuk mencari Kas PEtugas
      $(function(){

        $("#account_type").change(function(){
          type = $("#account_type").val();
          $.ajax({
            type: "POST",
            url: site_url+"laporan/search_code_cash_by_keyword",
            data: {keyword:$("#keyword").val(),account_type:type},
            dataType: "json",
            success: function(response){
              var option = '';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].account_cash_code+'" account_cash_name="'+response[i].account_cash_name+'" fa_code="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].account_cash_code+' - '+response[i].account_cash_name+'</option>';
              }
              // console.log(option);
              $("#result").html(option);
            }
          });
        })

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#account_type").val();
            $.ajax({
              type: "POST",
              url: site_url+"laporan/search_code_cash_by_keyword",
              data: {keyword:$("#keyword").val(),account_type:type},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].account_cash_code+'" account_cash_name="'+response[i].account_cash_name+'" fa_code="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].account_cash_code+' - '+response[i].account_cash_name+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });

       $("#select_dialog").click(function(){

         result = $("#result").val();
              var account_cash_code = $("#result").val();
              var account_cash_name = account_cash_code+" - "+$("#result option:selected").attr('account_cash_name');
              var fa_name = $("#result option:selected").attr('fa_name');
              $("#close","#dialog_code_cash").trigger('click');
              $("#account_cash_name").val(account_cash_name);
              $("#account_cash_code").val(account_cash_code);
              $("#pemegeng_kas").val(fa_name);            
        });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

      });

   
      //export PDF
      $("#export_pdf").live('click',function()
      {
        var account_cash_name = $("#account_cash_name").val();
        var pemegeng_kas = $("#pemegeng_kas").val();
        var tanggal = $("#tanggal").val();
        var tanggal2 = $("#tanggal2").val();
        var account_cash_code = $("#account_cash_code").val();
        window.open('<?php echo base_url();?>laporan_to_pdf/export_transaksi_kas_petugas/'+account_cash_name+'/'+pemegeng_kas+'/'+tanggal+'/'+tanggal2+'/'+account_cash_code);
      });
   
      //export EXCEL
      $("#export_excel").live('click',function()
      {
        var account_cash_name = $("#account_cash_name").val();
        var pemegeng_kas = $("#pemegeng_kas").val();
        var tanggal = $("#tanggal").val();
        var tanggal2 = $("#tanggal2").val();
        var account_cash_code = $("#account_cash_code").val();
        window.open('<?php echo base_url();?>laporan_to_excel/export_transaksi_kas_petugas/'+account_cash_name+'/'+pemegeng_kas+'/'+tanggal+'/'+tanggal2+'/'+account_cash_code);
      });


      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->

