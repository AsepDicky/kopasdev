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
      Rekening Nasabah <small>Cetak SPB</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Cetak SPB</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN SEARCH -->
<div id="search">
  <div class="portlet box grey">
    <div class="portlet-title">
       <div class="caption"><i class="icon-reorder"></i>Cetak SPB</div>
       <div class="tools">
          <a href="javascript:;" class="collapse"></a>
       </div>
    </div>
    <div class="portlet-body form">
      <!-- BEGIN FORM-->
      <form id="form" class="form-horizontal">
      <!-- <form id="form" method="post" action="<?php echo site_url('rekening_nasabah/do_cetak_spb'); ?>" class="form-horizontal"> -->
        <div class="alert alert-error hide">
           <button class="close" data-dismiss="alert"></button>
           You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
           <button class="close" data-dismiss="alert"></button>
           Cetak SPB Pencairan Berhasil Di Proses !
        </div>
        <div class="form-body" style="padding-top:20px;padding-bottom:20px;">
          <div class="control-group">
            <label class="control-label">Tanggal SPB</label>
            <div class="controls">
              <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $date1; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;height:25px;text-align:center;">
                s/d
              <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $date2; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;height:25px;text-align:center;">
              <button id="btn-search" type="button" class="btn small blue"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
          <table align="center" width="100%" class="table table-striped table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th width="25%">NO SPB</th>
                <th width="15%">TANGGAL SPB</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody id="result">
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
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
      $("#tanggal").inputmask("d/m/y");  //direct mask       
      $("#tanggal2").inputmask("d/m/y");  //direct mask   
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$("#btn-search").click(function(){
  var tanggal = datepicker_replace($("#tanggal").val());
  var tanggal2 = datepicker_replace($("#tanggal2").val());
    $.ajax({
      url: site_url+"rekening_nasabah/get_spb_by_rage",
      type: "POST",
      dataType: "json",
      data: {tanggal:tanggal,tanggal2:tanggal2},
      success: function(response)
      {
          html = '';
          for ( i = 0 ; i < response.length ; i++ )
          {
             html += '<tr>';
             html +=    '<td>'+response[i].no_spb+'</td>';
             html +=    '<td style="text-align: center;vertical-align: middle;">'+response[i].tanggal_spb+'</td>';
             html +=    '<td style="text-align: center;vertical-align: middle;">';
             html +=      '&nbsp;&nbsp;<a href="javascript:;" class="btn green" data-id_spb="'+response[i].id_spb+'" id="previewPDF">Print SPB PDF</a>';
             html +=      '&nbsp;&nbsp;<a href="javascript:;" class="btn green" data-id_spb="'+response[i].id_spb+'" id="previewXLS">Print SPB XLS</a>';
             // html +=      '&nbsp;&nbsp;<a href="javascript:;" class="btn green" data-no_spb="'+response[i].no_spb+'" id="lampiranPDF">Print Lampiran PDF</a>';
             html +=      '&nbsp;&nbsp;<a href="javascript:;" class="btn green" data-no_spb="'+response[i].no_spb+'" id="lampiranXLS">Print Lampiran</a>';
             html +=    '</td>';
             html += '</tr>';
          }
          $("#result",".table").html(html);
      }
    })     
});

$(function(){
  
      $("a#previewPDF").live('click',function(){  
        var id_spb = $(this).data('id_spb');
        window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_spb_pdf/'+id_spb+'/preview');
      });
  
      $("a#previewXLS").live('click',function(){ 
        var id_spb = $(this).data('id_spb');
        window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_spb_xls/'+id_spb+'/preview');
      });
  
      $("a#lampiranPDF").live('click',function(){  
        var no_spb = $(this).data('no_spb');
        window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_transfer_pencairan/'+no_spb+'/previewPDF');
        // alert(id_spb)
      });

      $("a#lampiranXLS").live('click',function(){  
        var no_spb = $(this).data('no_spb');
        window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_transfer_pencairan/'+no_spb+'/previewXLS');
        // alert(id_spb)
      });

$("#previewPDF").click(function(e)
{
  e.preventDefault();
  var no_spb = $("#no_spb").val();
  var tanggal_spb = datepicker_replace($("#tanggal_spb").val());
  if(no_spb==""){
    alert("No SPB belum dipilih");
  }else if(tanggal_spb==""){
    alert("Tanggal SPB belum dipilih");
  }else{
    window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_spb_pdf/'+no_spb+'/'+tanggal_spb);
  }

});

$("#previewXLS").click(function(e)
{
  e.preventDefault();
  var no_spb = $("#no_spb").val();
  var tanggal_spb = datepicker_replace($("#tanggal_spb").val());
  if(no_spb==""){
    alert("No SPB belum dipilih");
  }else if(tanggal_spb==""){
    alert("Tanggal SPB belum dipilih");
  }else{
    window.open('<?php echo site_url();?>rekening_nasabah/do_cetak_spb_xls/'+no_spb+'/'+tanggal_spb);
  }

});
//  END FORM EDIT VALIDATION
});

</script>
<!-- END JAVASCRIPTS -->
