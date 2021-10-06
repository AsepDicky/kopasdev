<style type="text/css">
#pPencairanTable_center input {
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
      Rekening Nasabah <small>Verifikasi Pencairan Tabungan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Pencairan Tabungan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

      <div class="clearfix" style="margin-bottom:10px;">
            <a id="browse_account_no" class="btn blue" data-toggle="modal" href="#dialog_account_no">Cari Data</a>
            <button class="btn blue pull-right" id="detail">Proses  <i class="icon-th-list"></i></button>
            <!-- <button class="btn green pull-right" style="margin-right:5px;" id="verifikasi">Verifikasi  <i class="icon-ok-sign"></i></button> -->
      </div>

        <div id="dialog_account_no" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
          <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
             <h3>Pencarian</h3>
          </div>
          <div class="modal-body">    
          <table width="100%">
            <tr valign="top">
              <td style="padding-top:6px;">Cabang</td>
              <td style="padding-top:6px;">:</td>
              <td>
                  <select id="branch_id" name="branch_id" class="m-wrap" style="padding:5px;margin-bottom:10px;">
                     <option>SEMUA</option>
                     <?php foreach ($branch as $key):?>
                      <option value="<?php echo $key['branch_id'];?>"><?php echo $key['branch_name'];?></option>
                     <?php endforeach;?>
                  </select>
               </td>              
            </tr>
            <tr valign="top">
              <td style="padding-top:6px;">Rembug</td>
              <td style="padding-top:6px;">:</td>
              <td>
                  <input type="text" name="cm_name" id="cm_name" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </td>              
            </tr>
            <tr valign="top">
              <td style="padding-top:6px;">Nama</td>
              <td style="padding-top:6px;">:</td>
              <td>
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </td>              
            </tr>
          </table>   
          </div>
          <div class="modal-footer">
             <button type="button" id="close" data-dismiss="modal" class="btn">Batal</button>
             <button type="button" id="filter" class="btn blue">Cari</button>
          </div>
        </div>

        <!--Dialog Detail Tabungan-->
        <div id="dialog_detail" title="Detail">    
           <form id="t_dialog">  
              <table width="350">
                 <tr>
                   <td>Nama</td>
                   <td><div id="div_nama"></div></td>
                 </tr>
                 <tr>
                   <td>No. Rekening</td>
                   <td><div id="div_no_rekening"></div></td>
                 </tr>
                 <tr>
                   <td>Pencairan  Ke</td>
                   <td><div id="div_pencairan_ke">PINBUK</div></td>
                 </tr>
                 <tr>
                   <td>Saldo Memo</td>
                   <td><div id="div_saldo_memo"></div></td>
                 </tr>
                 <tr>
                   <td>Jumlah Penarikan</td>
                   <td><div id="div_jumlah_penarikan"></div></td>
                 </tr>
              </table>
              <input type="hidden" name="hidden_cif_no" id="hidden_cif_no">
              <input type="hidden" name="hidden_cif_type" id="hidden_cif_type">
              <input type="hidden" name="hidden_no_rekening" id="hidden_no_rekening">
              <input type="hidden" name="hidden_nama" id="hidden_nama">
              <input type="hidden" name="hidden_product" id="hidden_product">
              <input type="hidden" name="hidden_saldo_memo" id="hidden_saldo_memo">
              <input type="hidden" name="hidden_jumlah_penarikan" id="hidden_jumlah_penarikan">
              <input type="hidden" name="hidden_trx_account_saving_id" id="hidden_trx_account_saving_id">
           </form>
          <div class="modal-footer">
             <button type="button" id="reject" data-dismiss="modal" class="btn red"><i class="icon-remove"></i> Reject</button>
             <button type="button" id="approve" class="btn green"><i class="icon-ok-sign"></i> Approve</button>
          </div>
        </div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<table id="PencairanTable"></table>
<div id="pPencairanTable"></div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>

   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
   });
   

    $("#filter").click(function(){
          $("#close","#dialog_account_no").trigger('click');
          $("#PencairanTable").trigger('reloadGrid');
    });

    $("#approve").click(function(){
        $.ajax({
          type: "POST",
          async:false,
          url: site_url+"rekening_nasabah/proses_verifikasi_pencairan_tabungan",
          dataType: "json",
          data: {
                   cif_no                 : $("#hidden_cif_no").val()
                  ,cif_type               : $("#hidden_cif_type").val()
                  ,no_rekening            : $("#hidden_no_rekening").val()
                  ,no_rekening_individu   : $("#hidden_nama").val()
                  ,pencairan_ke           : $("#hidden_product").val()
                  ,saldo_memo             : $("#hidden_saldo_memo").val()
                  ,jumlah_penarikan       : $("#hidden_jumlah_penarikan").val()
                  ,trx_account_saving_id  : $("#hidden_trx_account_saving_id").val()
                },
          success: function(response){
            if(response.success==true){
              alert("Verifikasi Berhasil!");
              $("#PencairanTable").trigger('reloadGrid');
            }else{
              alert("Verifikasi Gagal !");
              $("#PencairanTable").trigger('reloadGrid');
            }
          },
          error: function(){
            alert("Failed to Connect into Databases, Please Contact Your Administration!")
            $("#PencairanTable").trigger('reloadGrid');
          }
        });
        $("#dialog_detail").dialog('close');
    });

    $("#reject").click(function(){
        $.ajax({
          type: "POST",
          async:false,
          url: site_url+"rekening_nasabah/reject_pencairan_tabungan",
          dataType: "json",
          data: {
                   cif_no                 : $("#hidden_cif_no").val()
                  ,no_rekening            : $("#hidden_no_rekening").val()
                  ,trx_account_saving_id  : $("#hidden_trx_account_saving_id").val()
                },
          success: function(response){
            if(response.success==true){
              alert("Rejected !");
              $("#PencairanTable").trigger('reloadGrid');
            }else{
              alert("Failed, please try again !");
              $("#PencairanTable").trigger('reloadGrid');
            }
          },
          error: function(){
            alert("Failed to Connect into Databases, Please Contact Your Administration!")
            $("#PencairanTable").trigger('reloadGrid');
          }
        });        
        $("#dialog_detail").dialog('close');
    });


   var t_dialog = $("#t_dialog");
   $("#detail").click(function(){
    var selrow = $("#PencairanTable").jqGrid('getGridParam','selrow');
    var data   = $("#PencairanTable").jqGrid('getRowData',selrow);
    var account_saving_no     = data.account_saving_no;

    if (account_saving_no==null){
      alert("Please Select Row !");
    }else{
      
        $.ajax({
          type:"POST",
          url: site_url+"transaction/ajax_get_value_from_account_saving_status_3",
          data:{account_saving_no:account_saving_no},
          dataType:"json",
          async:false,
          success: function(response)
          {
            $("#hidden_cif_no","#dialog_detail").val(response.cif_no);
            $("#hidden_cif_type","#dialog_detail").val(response.cif_type);
            $("#hidden_no_rekening","#dialog_detail").val(response.account_saving_no);
            $("#hidden_nama","#dialog_detail").val(response.nama);
            $("#hidden_product","#dialog_detail").val(response.product_name);
            $("#hidden_saldo_memo","#dialog_detail").val(number_format(response.saldo_memo,0,',','.'));
            $("#hidden_jumlah_penarikan","#dialog_detail").val(number_format(response.saldo_memo,0,',','.'));
            $("#hidden_trx_account_saving_id","#dialog_detail").val(response.trx_account_saving_id);

            $("#div_nama","#dialog_detail").html(response.nama);
            $("#div_no_rekening","#dialog_detail").html(response.account_saving_no);
            $("#div_saldo_memo","#dialog_detail").html(number_format(response.saldo_memo,0,',','.'));
            $("#div_jumlah_penarikan","#dialog_detail").html(number_format(response.saldo_memo,0,',','.'));
          }
        })
      $("#dialog_detail").dialog('open');
    
    }
   });

   //BEGIN DIALOG DETAIL
    $("#dialog_detail").dialog({
      autoOpen: false,
      modal: true,
      width:400,
      height:300
    });

   //GRID SEMUA DATA TRANSAKSI
   jQuery("#PencairanTable").jqGrid({
     url: site_url+'rekening_nasabah/grid_verifikasi_pencairan_tabungan',
     //data: mydata,
     datatype: 'json',
     height: 'auto',
     postData: {
        branch_id  : function(){return $("#branch_id").val()}
       ,cm_name    : function(){return $("#cm_name").val()}
       ,nama       : function(){return $("#nama").val()}
     },
     rowNum: 30,
     autowidth: true,
     shrinkToFit: false,
     rowList: [30,50,100],
       colNames:['Cabang', 'Rembug', 'No Rekening','Nama','Saldo','trx saving id'],
       colModel:[
         {name:'branch_name',index:'branch_name', width:150, align:'left'},
         {name:'cm_name',index:'cm_name', width:200},
         {name:'account_saving_no',index:'account_saving_no', width:150},    
         {name:'nama',index:'nama', width:200},    
         {name:'saldo_memo',index:'saldo_memo', width:150, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2, prefix: "Rp. "}},
         {name:'trx_account_saving_id',index:'trx_account_saving_id',hidden:true}
       ],
       pager: "#pPencairanTable",
       viewrecords: true,
       sortname: 'branch_name, cm_name',
       grouping:false,
       caption: "Verifikasi Pencairan Tabungan"
   });
   </script>
   <!-- END JAVASCRIPTS -->

