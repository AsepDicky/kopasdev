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
      Rekening Nasabah <small>Create SPB</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Create SPB</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Create SPB</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
            <button id="btn_save" class="btn green">
            Save SPB
            </button>
         </div>
         <table>
           <!-- <tr>
             <td width="30%">
              <div style="margin-top:-5px;">No. SPB <span style="color:red;">*</span></div>
             </td>
             <td>
              <input type="text" name="no_spb" id="no_spb" class="medium m-wrap">
             </td>
           </tr> -->
           <tr>
             <td width="30%">
              <div style="margin-top:-5px;">Tanggal SPB <span style="color:red;">*</span></div>
             </td>
             <td>
              <input type="text" name="tanggal_spb" id="tanggal_spb" class="medium m-wrap date-picker mask-date">
             </td>
           </tr>
           <!-- <tr>
             <td width="30%">
              <div style="margin-top:-5px;">Produk <span style="color:red;">*</span></div>
             </td>
             <td>
              <input type="hidden" id="product_nickname" name="product_nickname">
              <select id="product_code" name="product_code" class="medium m-wrap">
                <option value="">Silahkan Pilih Produk</option>
                <?php foreach($product as $produk): ?>
                <option value="<?php echo $produk['product_code'] ?>" data-nick_name="<?php echo $produk['nick_name'] ?>"><?php echo $produk['product_name'] ?></option>
                <?php endforeach; ?>
              </select>
             </td>
           </tr> -->
          <!--  <tr>
             <td width="30%">
              <div style="margin-top:-5px;">Akun <span style="color:red;">*</span></div>
             </td>
             <td>
              <select class="medium m-wrap chosen" name="account_code" id="account_code">
                <option value="">Pilih</option>
                <?php foreach($akun as $data):?>
                <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                <?php endforeach?>
              </select>
             </td>
           </tr> -->
           <tr>
             <td>&nbsp;</td>
             <td>
               <div class="btn-group pull-left">
                  <button id="btn_view" class="btn blue">
                  View Data <i class="icon-disk"></i>
                  </button>
               </div>
             </td>
           </tr>
         </table>
      </div>
      <hr size="1">
      <table class="table table-striped table-bordered table-hover" id="create_spb">
         <thead>
            <tr>
              <th width="5%" align="center"><input type="checkbox" class="group-checkable" data-set="#create_spb .checkboxes" /></th>
              <th width="13%">No.Pembiayaan</th>
              <th width="15%">Nama</th>
              <th width="12%">Tgl.Akad</th>
              <th width="12%">Tgl.Transfer</th>
              <th width="10%">Pembiayaan</th>
              <th width="10%">Angs. Pertama</th>
              <th width="15%">Biaya Adm</th>
              <th width="15%">Biaya Notaris</th>
              <th width="15%">Kewajiban Koptel</th>
              <th width="15%">Kewajiban Kopegtel</th>
              <th width="15%">Premi Asuransi</th>
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
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/fnReloadAjax.js" type="text/javascript"></script> 
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
      $(".mask-date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<style type="text/css">
 /* #create_spb_filter{
    display: none !important;
  }*/
</style>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
  table = $('#create_spb').dataTable({
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": site_url+"rekening_nasabah/datatable_create_spb",
    "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "status_transfer", "value": '3' } );//status 3 digunakan untuk mengkondisikan agar data pertama tidak di load
        aoData.push( { "name": "product_code", "value": $('#product_code').val() } );
     },
    "aLengthMenu": [
        [15, 20, -1],
        [15, 20, "All"] // change per page values here
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
    "sZeroRecords" : "Data Kosong",
    "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0,3,4,5,6,7,8,9,10]
        }
    ]
  });
  // $(".dataTables_length,.dataTables_filter").parent().hide();

  jQuery('#create_spb_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#create_spb_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

  // fungsi untuk check all
  jQuery('#create_spb .group-checkable').live('change',function () {
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

  $("#create_spb .checkboxes").livequery(function(){
    $(this).uniform();
  });

  $("#btn_view").click(function(){
    var bValid = true;
    // var no_spb = $("#no_spb").val();
    var tanggal_spb = $("#tanggal_spb").val();
    var product_code = $("#product_code").val();
    // if(no_spb==''){
    //  App.WarningAlert("Mohon lengkapi no spb !");
    //   bValid = false;
    // }
    if(tanggal_spb==''){
     App.WarningAlert("Mohon Tentukan Tanggal SPB !");
      bValid = false;
    }
    /*else if(product_code==''){
     App.WarningAlert("Mohon Pilih Produk !");
      bValid = false;
    }*/
    if(bValid==true){
      $('#create_spb').dataTable({
        "bDestroy":true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": site_url+"rekening_nasabah/datatable_create_spb",
        "fnServerParams": function ( aoData ) {
             aoData.push( { "name": "status_transfer", "value": '0' } );
             aoData.push( { "name": "product_code", "value": $('#product_code').val() } );
         },
        "aLengthMenu": [
            [15, 20, -1],
            [15, 20, "All"] // change per page values here
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
        "sZeroRecords" : "Data Kosong",
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0,3,4,5,6,7,8,9,10]
            }
        ]
      });
      // $(".dataTables_length,.dataTables_filter").parent().hide();
    }
  });


  $("#btn_save").click(function(){
    // var no_spb = $("#no_spb").val();
    var tanggal_spb = $("#tanggal_spb").val();
    var product_nickname = $("#product_nickname").val();
    var account_financing_no = [];
    var $i = 0;
    $("input#checkbox:checked").each(function(){
      account_financing_no[$i] = $(this).val();
      $i++;
    });

    console.log(account_financing_no);

    if(account_financing_no.length==0){
     App.WarningAlert("Please select some row to save !");
    }else{
      var conf = confirm('Are you sure to save this rows ?');
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"rekening_nasabah/do_save_spb",
          dataType: "json",
          data: {
             account_financing_no:account_financing_no
            // ,no_spb:no_spb
            ,tanggal_spb:tanggal_spb
            ,product_nickname:product_nickname
          },
          success: function(response){
            if(response.success==true){
              $.alert({
                title:"Success",icon:'icon-check',backgroundDismiss:false,
                content:'SPB berhasil dibuat !<br><strong>No.SPB : '+response.no_spb+'</strong>',
                confirmButtonClass:'btn green',
                confirm:function(){
                  location.reload();
                }
              })
            }else{
             App.WarningAlert("Failed!");
            }
          },
          error: function(){
           App.WarningAlert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
          }
        })
      }
    }

  });


$('#product_code').change(function(){
  product_nickname = $(this).find('option:selected').data('nick_name');
  $('#product_nickname').val(product_nickname);
})
</script>
<!-- END JAVASCRIPTS -->
