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
      Laporan <small>Cetak Transaksi Buku Tabungan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Cetak Transaksi Buku Tabungan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->
         <!-- <div class="btn-group pull-right">
            <button id="previewpdf" class="btn red">
              Cetak Transaksi <i class="icon-print"></i>
            </button>
         </div> -->

      <div class="clearfix">
      
            <input type="hidden" name="cm_code">
            <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
            <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
            Nama <span style="color:red">*</span> &nbsp; : &nbsp;
            <input type="text" name="nama" id="nama" readonly="" style="background-color:#eee;margin-top:3px;" data-required="1" class="medium m-wrap"/>
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <input type="hidden" name="no_rek" id="no_rek"/>
            
           <!--  &nbsp;&nbsp;
            No Rekening <span style="color:red">*</span> &nbsp; : &nbsp;
            <select name="no_rek" id="no_rek" style="width:170px;padding:5px;" class="span12 m-wrap">
                <option value="">Pilih</option>
            </select> -->

            &nbsp;&nbsp;
            Tanggal <span style="color:red">*</span> &nbsp; : &nbsp;
            <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              sd
             <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
            <button class="btn blue" id="filter" type="button">Filter</button>
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
      <div class="btn-group pull-right">
        <table>
          <tr>
            <td><input type="text" name="mulai_no" id="mulai_no" tabindex="2"  placeholder="Mulai Nomor" maxlength="7" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;float:right"></td>
            <td><input type="text" name="mulai_kolom" id="mulai_kolom" tabindex="2"  placeholder="Mulai Baris" maxlength="7" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;float:right"></td>
            <td><button id="previewpdf" class="btn red">Cetak Transaksi <i class="icon-print"></i></button></td>
          </tr>
        </table>
      </div>
      <table class="table table-striped table-bordered table-hover" id="rekening_tabungan_table">
               <input type="hidden" name="no_rekening" id="no_rekening"/>
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_tabungan_table .checkboxes" /></th>
               <th width="15%">Tanggal</th>
               <th width="10%">Flag</th>
               <th width="25%">Debet</th>
               <th width="25%">Kredit</th>
               <th width="30%">Saldo</th>
               <th>User</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
    </form>
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

        //export PDF
        $("#previewpdf").click(function()
        {
          var mulai_no   = $("#mulai_no").val();
          var mulai_kolom   = $("#mulai_kolom").val();
          if(mulai_no=="")$("#mulai_no").val('1')
          if(mulai_kolom=="")$("#mulai_kolom").val('1')
          var no_rek   = $("#no_rek").val();
          // alert(no_rek);
          var trx_account_saving_id = [];
          var $i = 0;
          $("input#checkbox:checked").each(function(){

            trx_account_saving_id[$i] = $(this).val();

            $i++;

          });

           // if(trx_account_saving_id.length==0){
           // alert("Please select some row to print !");
           // }else{
            $("#form_export").submit();
            // window.open('<?php echo site_url();?>laporan/export_cetak_trans_buku/'+trx_account_saving_id);
            // window.open('<?php echo site_url();?>laporan_to_pdf/cetak_trans_buku/'+produk);
          // }
        });

        
        $("#filter").click(function(){
         $("#mulai_no").val('');
         $("#mulai_kolom").val('');
         nama     = $("#nama").val();
         no_rek   = $("#no_rekening").val();
         tanggal  = $("#tanggal").val().replace(/\//g,'');
         tanggal2 = $("#tanggal2").val().replace(/\//g,'');
         if(nama==""){
            alert("Mohon isi Nama terlebih dahulu");
         }else if(no_rek==""){
            alert("Mohon isi No Rekening terlebih dahulu");
         }else if(tanggal=="" && tanggal2==""){
            alert("Mohon isi Tanggal Transaksi terlebih dahulu");
         }else{

            // begin first table
            $('#rekening_tabungan_table').dataTable({
               "bDestroy":true,
               "bProcessing": true,
               "bServerSide": true,
               "sAjaxSource": site_url+"laporan/datatable_rekening_buku_tabungan_setup",
               "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "no_rek", "value": $("#no_rek").val() } );
                    aoData.push( { "name": "tanggal", "value": $("#tanggal").val() } );
                    aoData.push( { "name": "tanggal2", "value": $("#tanggal2").val() } );
                },
               "aoColumns": [
                  null,
                  null,
                  null,
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


         }
         /*else
         {
            alert("Please select row first !");
         }*/

        })


      // // begin first table
      // $('#rekening_tabungan_table').dataTable({
      //     "bProcessing": true,
      //     "bServerSide": true,
      //     "sAjaxSource": site_url+"laporan/datatable_rekening_buku_tabungan_setup",
      //     "aoColumns": [
      //       null,
      //       null,
      //       null,
      //       null,
      //       null,
      //       null,
      //       { "bSortable": false }
      //     ],
      //     "aLengthMenu": [
      //         [5, 15, 20, -1],
      //         [5, 15, 20, "All"] // change per page values here
      //     ],
      //     // set the initial value
      //     "iDisplayLength": 5,
      //     "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      //     "sPaginationType": "bootstrap",
      //     "oLanguage": {
      //         "sLengthMenu": "_MENU_ records per page",
      //         "oPaginate": {
      //             "sPrevious": "Prev",
      //             "sNext": "Next"
      //         }
      //     },
      //     "aoColumnDefs": [{
      //             'bSortable': false,
      //             'aTargets': [0]
      //         }
      //     ]
      // });
      
      $(".dataTables_length,.dataTables_filter").parent().hide();

    
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->
