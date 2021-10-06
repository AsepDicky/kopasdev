<style type="text/css">
#plist485_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}
select {
    margin: 0;
    padding: 0;
    width: 40px;
    font-size:13px;
}
</style>

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
      Laporan <small>Cetak Cover Buku</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Cetak Cover Buku</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div class="clearfix">
  <input type="hidden" name="cm_code">
  <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
  <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
  No. Rek Tabungan &nbsp; : &nbsp;
  <input type="text" name="account_saving_no" id="account_saving_no" data-required="1" class="medium m-wrap"/>
  <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug" style="display:none;">...</a>
  &nbsp;&nbsp;
  <button class="btn blue" id="filter" type="button">Filter</button>
  <div class="hide pull-right"><button id="previewpdf" class="btn red">Cetak Cover Buku <i class="icon-print"></i></button></div>  
</div>

<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Search Account Saving</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <?php
            if($this->session->userdata('cif_type')==0){
            ?>
              <input type="hidden" id="cif_type" name="cif_type" value="0">
              <p id="pcm" style="height:32px">
              <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
              <option value="">Pilih Rembug</option>
              <?php foreach($rembugs as $rembug): ?>
              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
              <?php endforeach; ?>;
              </select></p>
            <?php
            }else if($this->session->userdata('cif_type')==1){
              echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
            }else{
            ?>
              <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
              <option value="">Pilih Tipe CIF</option>
              <option value="">All</option>
              <option value="1">Individu</option>
              <option value="0">Kelompok</option>
              </select></p>
              <p class="hide" id="pcm" style="height:32px">
              <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
              <option value="">Pilih Rembug</option>
              <?php foreach($rembugs as $rembug): ?>
              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
              <?php endforeach; ?>;
              </select></p>
            <?php
            }
            ?>
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
             
<!-- BEGIN EXAMPLE TABLE PORTLET-->

<!-- BEGIN FORM-->
<form action="<?php echo site_url('laporan/export_cetak_trans_buku'); ?>" method="post" enctype="multipart/form-data" id="form_export" class="form-horizontal" target="_blank">
  <table class="table table-striped table-bordered table-hover" id="rekening_tabungan_table">
     <thead>
        <tr>
           <th width="14%"></th>
           <th width="20%">No. Rekening</th>
           <th width="20%">ID Anggota</th>
           <th>Nama Anggota</th>
        </tr>
     </thead>
     <tbody>
        
     </tbody>
  </table>
</form>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="print_area" style="font-size:9px;display:none;">
  <table>
    <tr>
      <td width="110" style="white-space:nowrap;"><span style="font-size:12px;">No. Rekening</span></td>
      <td width="20"><span style="font-size:12px;">:</span></td>
      <td width="520"><span style="font-size:12px;" id="pa_account_saving_no"></span></td>
    </tr>
    <tr>
      <td><span style="font-size:12px;">Nama</span></td>
      <td><span style="font-size:12px;">:</span></td>
      <td><span style="font-size:12px;" id="pa_nama"></span></td>
    </tr>
    <tr>
      <td valign="top"><span style="font-size:12px;">Alamat</span></td>
      <td valign="top"><span style="font-size:12px;">:</span></td>
      <td valign="top"><span style="font-size:12px;" id="pa_alamat"></span></td>
    </tr>
  </table>
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("#tgl_lahir").inputmask("y/m/d", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

  // fungsi untuk check all
  jQuery('#rekening_tabungan_table .group-checkable').live('change',function () {
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

// fungsi untuk mencari CIF_NO
$(function(){
  $("#select","#dialog_rembug").click(function(){
   $("#mulai_no").val('');
   $("#mulai_kolom").val('');
    var result = $("#result").val();
    var account_saving_no = result;
        $("#close","#dialog_rembug").trigger('click');
        $.ajax({
          type:"POST",
          url: site_url+"transaction/get_value_lap_rek_tab_for_cetak",
          data:{account_saving_no:account_saving_no},
          dataType:"json",
          success: function(response)
                {
               
                  $("#nama").val(response.nama);
                  $("#no_rek").val(response.account_saving_no);
                  $("#no_rekening").val(response.account_saving_no);

                   /*$.ajax({
                         type: "POST",
                         url: site_url+"transaction/get_account_saving",
                         dataType: "json",
                         data: {cif_no:response.cif_no},
                         success: function(response){
                            html = '<option value="">PILIH</option>';
                            for ( i = 0 ; i < response.length ; i++ )
                            {
                               html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                            }
                            $("#no_rek").html(html);
                         }
                    });   */
                }
        })
    });
  });


  $("#button-dialog").click(function(){
    $("#dialog").dialog('open');
  });

  
  $("#cif_type").change(function(){
    type = $("#cif_type").val();
    cm_code = $("select#cm").val();
    if(type=="0"){
      $("p#pcm").show();
    }else{
      $("p#pcm").hide().val('');
    }

      $.ajax({
        type: "POST",
        url: site_url+"transaction/search_account_saving_no",
        data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
        dataType: "json",
        success: function(response){
          var option = '';
          for(i = 0 ; i < response.length ; i++){
             option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
          }
          // console.log(option);
          $("#result").html(option);
        }
      });

  });

  $("#keyword").on('keypress',function(e){
    if(e.which==13){
     // type = $("#cif_type").val();
      type = $("#cif_type").val();
      cm_code = $("select#cm").val();
      if(type=="0"){
        $("p#pcm").show();
      }else{
        $("p#pcm").hide().val('');
      }
      $.ajax({
        type: "POST",
        url: site_url+"transaction/search_account_saving_no",
        data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
        dataType: "json",
        async: false,
        success: function(response){
          var option = '';
          for(i = 0 ; i < response.length ; i++){
             option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
          }
          // console.log(option);
          $("#result").html(option);
        }
      });
      return false;
    }
  });

  $("select#cm").on('change',function(e){
    type = $("#cif_type").val();
    cm_code = $(this).val();

      $.ajax({
        type: "POST",
        url: site_url+"transaction/search_account_saving_no",
        data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
        dataType: "json",
        success: function(response){
          var option = '';
          for(i = 0 ; i < response.length ; i++){
             option += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
          }
          $("#result").html(option);
        }
      });

    if(cm_code=="")
    {
      $("#result").html('');
    }
  });

  $("#result option").live('dblclick',function(){
     $("#select").trigger('click');
  });

        
  $("#filter").click(function(){

    // begin first table
    $('#rekening_tabungan_table').dataTable({
       "bDestroy":true,
       "bProcessing": true,
       "bServerSide": true,
       "sAjaxSource": site_url+"laporan/datatable_cetak_cover_buku_tabungan",
       "fnServerParams": function ( aoData ) {
            aoData.push( { "name": "account_saving_no", "value": $("#account_saving_no").val() } );
        },
       "aoColumns": [
          null,
          null,
          null,
         { "bSortable": false }
       ],
       "aLengthMenu": [
           [5, 15, 20, -1],
           [5, 15, 20, "All"] // change per page values here
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

    $(".dataTables_length,.dataTables_filter").parent().hide();

  });
  
  $(".dataTables_length,.dataTables_filter").parent().hide();


  jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

  $(function(){
    $("a#printpdfcoverbuku").live('click',function(){
      account_saving_no=$(this).attr('account_saving_no');
      $.ajax({
        type:"POST",dataType:"json",data:{account_saving_no:account_saving_no},
        url:site_url+"laporan/get_data_cetak_cover_buku",
        success:function(response){
          print_area=$("#print_area");
          $("#pa_account_saving_no",print_area).text(response.account_saving_no);
          $("#pa_nama",print_area).text(response.nama);
          alamat=response.alamat;
          if(response.rt_rw!='/') alamat+=', RT/RW : '+response.rt_rw;
          if(response.desa!='') alamat+=', Kelurahan : '+response.desa;
          if(response.kecamatan!='') alamat+=', Kecamatan : '+response.kecamatan;
          if(response.kabupaten!='') alamat+=', Kota : '+response.kabupaten;
          if(response.kodepos!='') alamat+=', Kode Pos : '+response.kodepos;
          $("#pa_alamat",print_area).text(alamat);
          print_area.printElement();
        }
      })
    })
  })

</script>
<!-- END JAVASCRIPTS -->
