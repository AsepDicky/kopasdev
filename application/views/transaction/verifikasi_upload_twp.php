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
        <h3 class="page-title">Setoran TWP <small>Upload setoran tabungan TWP</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Upload setoran tabungan TWP</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-upload"></i>Data Upload Setoran TWP</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="twp_table">
         <thead>
            <tr>
               <th width="25%">Deskripsi</th>
               <th width="15%">Total</th>
               <th width="15%">Tgl Upload</th>
               <th width="15%">Upload By</th>
               <th width="25%"></th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Verifikasi Upload TWP</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
      <input type="hidden" id="trx_id">
      <div class="form-body">
        <div class="control-group">
          <label class="control-label">Akun Bank/Kas</label>
          <div class="controls">
            <select class="m-wrap medium chosen" id="account_cash_code">
              <option value="">PILIH Bank/Kas</option>
              <?php foreach($cashs as $cash): ?>
                <option value="<?php echo $cash['account_code']?>"><?php echo $cash['account_name']?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="control-group" style="display: none">
          <label class="control-label">No. Referensi</label>
          <div class="controls">
            <input type="text" class="medium m-wrap" id="no_referensi" name="no_referensi">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Deskripsi</label>
          <div class="controls">
            <input type="text" class="large m-wrap" id="deskripsi" name="deskripsi">
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
    <button type="button" class="btn blue" id="save">Process</button>
  </div>
</div>


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
<script src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js" type="text/javascript"></script>     
<!-- END PAGE LEVEL SCRIPTS -->  

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

    App.init(); // initlayout and core plugins
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'twp_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      $("a#link-approve").live('click',function(){
        var trx_id = $(this).attr('trx_id');
        var deskripsi = $(this).attr('deskripsi');
        $('#dialog').modal('show');
        $('#trx_id','#dialog').val(trx_id);
        $('#account_cash_code','#dialog').val('').trigger('liszt:updated');
        $('#no_referensi','#dialog').val('');
        $('#deskripsi','#dialog').val(deskripsi);
      });

      $('#save','#dialog').click(function(){
        var trx_id = $('#trx_id','#dialog').val();
        var account_cash_code = $('#account_cash_code','#dialog').val();
        var no_referensi = $('#no_referensi','#dialog').val();
        var deskripsi = $('#deskripsi','#dialog').val();

        var conf = confirm('Verifikasi transaksi ?');
        if(conf){
          $('#dialog').modal('hide')
          $.ajax({
            type: "POST",
            url: site_url+"transaction/do_verifikasi_twp",
            dataType: "json",
            data: {
                    trx_id:trx_id
                    ,account_cash_code:account_cash_code
                    ,no_referensi:no_referensi
                    ,deskripsi:deskripsi
                  },
            success: function(response){
              if (response.success==true) {
                  $.alert({
                      title:'Verifikasi Success',icon:'icon-check',backgroundDismiss:false,
                      content:'Verifikasi Setoran TWP SUKSES.',
                      confirmButtonClass:'btn green',
                      confirm:function(){
                          dTreload();
                      }
                  })
              } else {
                  App.WarningAlert(response.error);
              }
            },
            error: function(){
              App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
            }
          })
        }
      })

      $("a#link-delete").live('click',function(){
        var trx_id = $(this).attr('trx_id');
          var conf = confirm('Delete transaksi ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/do_delete_verifikasi_twp",
              dataType: "json",
              data: {trx_id:trx_id},
              success: function(response){
                if (response.success==true) {
                    // $.alert({
                    //     title:'Verifikasi Success',icon:'icon-check',backgroundDismiss:false,
                    //     content:'Verifikasi Setoran TWP SUKSES.',
                    //     confirmButtonClass:'btn green',
                    //     confirm:function(){
                    //     }
                    // })
                            dTreload();
                } else {
                    App.WarningAlert(response.error);
                }
              },
              error: function(){
                App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
              }
            })
          }
      });
  
      // begin first table
      $('#twp_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_upload_twp",
          "aoColumns": [
            { "bSortable": true }
            ,{ "bSortable": true }
            ,{ "bSortable": true }
            ,{ "bSortable": true }
            ,{ "bSortable": false }
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

     $("a#link-view").live('click',function(){
        var trx_id = $(this).attr('trx_id');
          // window.open('<?php echo site_url();?>laporan_to_pdf/preview_penarikan_twp/'+trx_id+'/preview');
          window.open('<?php echo site_url();?>laporan_to_excel/preview_setoran_twp/'+trx_id+'/preview');
     });

      jQuery('#twp_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#twp_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->