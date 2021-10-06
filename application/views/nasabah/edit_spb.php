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
      Rekening Nasabah <small>Edit SPB</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Edit SPB</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Edit SPB</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <input type="hidden" name="approve1" id="approve1" readonly="">
      <input type="hidden" name="approve2" id="approve2" readonly="">
      <input type="hidden" name="approve3" id="approve3" readonly="">
      <div class="clearfix">
         <table>
           <tr>
             <td width="30%">
              <div style="margin-top:-5px;">Tanggal SPB <span style="color:red;">*</span></div>
             </td>
             <td>
              <?php
              $month = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
              ?>
              <select class="medium m-wrap chosen" name="tanggal_spb" id="tanggal_spb">
                <option value="">Pilih</option>
                <?php foreach($tgl_spb as $data):?>
                <option value="<?php echo $data['tanggal_spb'];?>">
                <?php
                $tgl = $data['tanggal_spb'];
                $hari = date('d',strtotime($tgl));
                $bulan = $month[(int)date('m',strtotime($tgl))];
                $tahun = date('Y',strtotime($tgl));
                echo $hari.' '.$bulan.' '.$tahun;
                ?>
                </option>
                <?php endforeach?>
              </select>
              <!-- <input type="text" name="tanggal_spb" id="tanggal_spb" class="medium m-wrap" readonly="" style="background:#eee;"> -->
             </td>
           </tr>
           <tr>
             <td width="30%">
              <div style="margin-top:-5px;">No. SPB <span style="color:red;">*</span></div>
             </td>
             <td>
              <select class="medium m-wrap chosen" name="no_spb" id="no_spb">
              </select>
             </td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td>
               <div class="btn-group pull-left">
                  <button id="btn_view" class="btn blue">
                  View Data <i class="icon-disk"></i>
                  </button>
                  <button style="margin-left:10px;" id="btn_edit_tanggal" class="btn blue">
                  Edit Tanggal <i class="icon-disk"></i>
                  </button>
               </div>
             </td>
           </tr>
         </table>
      </div>
      <hr size="1">
      <div style="color:red;font-size:11px;margin-left:10px;">*) Lakukan double klik untuk memilih data</div>
       <div class="portlet-body">
        <h4>Data Yang Belum Terpilih</h4>
        <table id="grid_spb_satu"></table>
        <div id="pgrid_spb_satu"></div>
       </div>
       <div class="portlet-body">
        <h4>Data Yang Sudah Terpilih</h4>
        <table id="grid_spb_dua"></table>
        <div id="pgrid_spb_dua"></div>
       </div>
     
   </div>
</div>

<!-- DIALOG EDIT TANGGAL SPB DUA -->
<div id="dialog_edit_tanggal" title="Edit Record">   
  <input name="tanggal_spb" id="mask_date" class="date-picker small m-wrap" style="width:335px !important;padding:8px;" placeholder="DD/MM/YYYY">
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
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">
  // $("#no_spb").change(function(){
  //   var no_spb = $(this).val();
  //   if(no_spb!=''){
  //       $.ajax({
  //         url: site_url+"rekening_nasabah/get_tanggal_spb_by_no_spb",
  //         type: "POST",
  //         dataType: "json",
  //         data: {no_spb:no_spb},
  //         success: function(response)
  //         {
  //           var explode = response.tanggal_spb.split('-');
  //           var tanggal_spb =  explode[2]+'/'+explode[1]+'/'+explode[0];
  //           $("#tanggal_spb").val(tanggal_spb);
  //           $("#approve1").val(response.approve_1);
  //           $("#approve2").val(response.approve_2);
  //           $("#approve3").val(response.approve_3);
  //         }
  //       })     
  //   }else{
  //       $("#tanggal_spb").val('');
  //   }          
  // });
  
  $('#tanggal_spb').change(function(){
    tanggal_spb=$(this).val();
    $.ajax({
      type:"POST",dataType:"json",data:{
        tanggal_spb:tanggal_spb
      },url:site_url+'rekening_nasabah/get_no_spb_by_tanggal_spb',
      success:function(response){
        opt = '<option value="">PILIH</option>';
        for ( i in response ) {
          opt += '<option value="'+response[i].no_spb+'">'+response[i].no_spb+'</option>';
        }
        $('#no_spb').html(opt).trigger('liszt:updated')
      }

    })
  })

  /*JQGRID SPB*/
  $("#grid_spb_satu").jqGrid({
      url: site_url+'rekening_nasabah/jqgrid_data_spb_status_transfer_nol',
      mtype: "GET",
      datatype: "json",
      colModel: [
          { label: 'ID', name: 'no_spb', hidden:true, width: 100 },
          { label: 'No. Pembiayaan', name: 'account_financing_no', width: 100, align:"center" },
          { label: 'Nama', name: 'nama', width: 200, align:"left" },
          { label: 'Tgl Akad', name: 'droping_date', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
          { label: 'Tgl Transfer', name: 'tanggal_transfer', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
          { label: 'Pembiayaan', name: 'pokok', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Angs. Pertama', name: 'angsuranke1', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Adm', name: 'biaya_administrasi', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Notaris', name: 'biaya_notaris', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Asuransi', name: 'biaya_asuransi_jiwa', hidden:true, width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          // { label: 'Biaya Notaris', name: 'biaya_notaris', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Kewajiban Koptel', name: 'kewajiban_koptel', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Kewajiban Kopegtel', name: 'kewajiban_kopegtel', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Premi Asuransi', name: 'premi_asuransi', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}}
      ],
      viewrecords: true,
      autowidth: true,
      height: 200,
      rowNum: 99999999,
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [false, "top"],
      sortname: "b.tanggal_transfer",
      sortorder: "asc",
      multiselect: false,
      ondblClickRow: function(){
          selrow=$("#grid_spb_satu").jqGrid('getGridParam','selrow');
          data=$("#grid_spb_satu").jqGrid('getRowData',selrow);
          var no_spb = $("#no_spb").val();
          var tanggal_spb = $("#tanggal_spb").val();
          var account_financing_no = data.account_financing_no;
          // alert(account_financing_no)
          if(account_financing_no!=''){
              /* INSERT DATA INTO GL REPORT ITEM MEMBER */
              $.ajax({
                  type:"POST",
                  dataType: "json",
                  data: {account_financing_no:account_financing_no,no_spb:no_spb,tanggal_spb:tanggal_spb},
                  url: site_url+'rekening_nasabah/save_tambahan_spb',
                  async: false,
                  error: function(){
                    alert("Failed to Conenct into Databases !")
                  },
                  success: function(response){
                      if(response.success==true){
                        alert("Data berhasil ditambahkan ke SPB !");
                        $("#grid_spb_dua").trigger('reloadGrid');
                        $("#grid_spb_satu").trigger('reloadGrid');
                      }else{
                        alert("Data gagal ditambahkan ke SPB !");
                      }
                  },
                  error: function(){
                    alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                  }
              });
          }
      }
  });
  // $("#t_grid_spb_satu").append('<div style="padding:4px;"><button class="btn green" id="btn_edit_satu"><span class="icon-edit"></span> Edit Record</button></div>');

  $("#btn_view").livequery('click',function(){
      var no_spb = $("#no_spb").val();
      if(no_spb==''){
        App.WarningAlert("Mohon pilih spb !");
      }else{
        jQuery("#grid_spb_satu").setGridParam({ 
          postData: { 
            no_spb : '0'
          }
        }).trigger("reloadGrid");
        jQuery("#grid_spb_dua").setGridParam({ 
          postData: { 
            no_spb : no_spb
          }
        }).trigger("reloadGrid");
      }
  });

  /*JQGRID SPB DETAIL*/
  $("#grid_spb_dua").jqGrid({
      url: site_url+'rekening_nasabah/jqgrid_data_spb_status_transfer_tidak_nol',
      mtype: "GET",
      datatype: "json",
      colModel: [
          { label: 'ID', name: 'no_spb', hidden:true, width: 100 },
          { label: 'No. Pembiayaan', name: 'account_financing_no', width: 100, align:"center" },
          { label: 'Nama', name: 'nama', width: 200, align:"left" },
          { label: 'Tgl Akad', name: 'droping_date', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
          { label: 'Tgl Transfer', name: 'tanggal_transfer', width: 100, align:"center", formatter: "date", formatoptions: { newformat: "d-m-Y"}},
          { label: 'Pembiayaan', name: 'pokok', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Angs. Pertama', name: 'angsuranke1', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Adm', name: 'biaya_administrasi', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Notaris', name: 'biaya_notaris', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Biaya Asuransi', name: 'biaya_asuransi_jiwa', hidden:true, width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          // { label: 'Biaya Notaris', name: 'biaya_notaris', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Kewajiban Koptel', name: 'kewajiban_koptel', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Kewajiban Kopegtel', name: 'kewajiban_kopegtel', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}},
          { label: 'Premi Asuransi', name: 'premi_asuransi', width: 120, align:"right", formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0, prefix: ""}}
      ],
      viewrecords: true,
      autowidth: true,
      height: 200,
      rowNum: 999999999,
      rownumbers: true,
      shrinkToFit: false,
      toolbar: [false, "top"],
      sortname: "b.tanggal_transfer",
      sortorder: "asc",
      multiselect: false,
      ondblClickRow: function(){
          selrow=$("#grid_spb_dua").jqGrid('getGridParam','selrow');
          data=$("#grid_spb_dua").jqGrid('getRowData',selrow);
          var no_spb = $("#no_spb").val();
          var account_financing_no = data.account_financing_no;
          if(account_financing_no!=''){
              /* INSERT DATA INTO GL REPORT ITEM MEMBER */
              $.ajax({
                  type:"POST",
                  dataType: "json",
                  data: {account_financing_no:account_financing_no,no_spb:no_spb},
                  url: site_url+'rekening_nasabah/delete_tambahan_spb',
                  async: false,
                  error: function(){
                    alert("Failed to Conenct into Databases !")
                  },
                  success: function(response){
                      if(response.success==true){
                        alert("Data berhasil dihapus dari SPB !");
                        $("#grid_spb_dua").trigger('reloadGrid');
                        $("#grid_spb_satu").trigger('reloadGrid');
                      }else{
                        alert("Data gagal dihapus dari SPB !");
                      }
                  },
                  error: function(){
                    alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                  }
              });
          }
      }
  });

  $("#btn_edit_tanggal").click(function(){     
    var tanggal_spb = $("#tanggal_spb","#wrapper-table").val();        
    var approve1 = $("#approve1","#wrapper-table").val();        
    var approve2 = $("#approve2","#wrapper-table").val();        
    var approve3 = $("#approve3","#wrapper-table").val();        
    // var explode = tanggal_spb.split('-');
    // var tgl_spb =  explode[0]+'/'+explode[1]+'/'+explode[2];
    $("input[name='tanggal_spb']","#dialog_edit_tanggal").datepicker('update',App.ToDatePicker(tanggal_spb));
    var no_spb =  $("#no_spb option:selected","#wrapper-table").val();
    if(approve1!='1' && approve2!='1' && approve3!='1'){
      if (no_spb!="" && tanggal_spb!=""){
        $("#dialog_edit_tanggal").dialog('open');
      } else {
        alert("Mohon Pilih Tanggal SPB & Nomor SPB");
      }
    }else{
      alert("Tanggal SPB tidak bisa diubah. Status approval !")
    }
  });     

  $("#dialog_edit_tanggal").dialog({
      autoOpen: false,
      modal: true,
      width:380,
      height:170,
      buttons:{
          "Save" : function(){
            var tanggal_spb = $("input[name='tanggal_spb']","#dialog_edit_tanggal").val();
            var explode = tanggal_spb.split('/');
            var tgl_spb =  explode[2]+'-'+explode[1]+'-'+explode[0];
            var no_spb =  $("#no_spb option:selected","#wrapper-table").val();
            if (tanggal_spb=="" || no_spb=="") {
                alert("Mohon Pilih Tanggal SPB & Nomor SPB");
            } else {
              do_save_edit_spb_dua(tgl_spb,no_spb);
            }
          }
      }
  });

  function do_save_edit_spb_dua(tgl_spb,no_spb)
  {
    
      $.ajax({
        type: "POST",
        url: site_url+"rekening_nasabah/do_save_edit_spb",
        dataType: "json",
        data: {tgl_spb:tgl_spb,no_spb:no_spb},
        success: function(response){
          if(response.success==true){
            $("#dialog_edit_tanggal").dialog('close');
            $("#tanggal_spb","#wrapper-table").val(tanggal_spb);
            alert("data berhasil disimpan");
            $("#grid_spb_dua").trigger('reloadGrid');

          }else{
            alert("data gagal disimpan");
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administration!")
        }
      });
  }

  function reload_tanggal_spb()
  {
    $.ajax({
      type:"POST",dataType:"json",url:site_url+'rekening_nasabah/reload_get_tanggal_spb',
      success:function(response){
        opt = '<option value="">PILIH</option>';
        month = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        for ( i in response ) {
          tgl = response[i].tanggal_spb
          if (tgl!=null) {
            tgl = tgl.split('-');
            hari = tgl[2];
            bulan = month[parseInt(tgl[1])];
            tahun = tgl[0];
            tanggal = hari+' '+bulan+' '+tahun;
          } else {
            tanggal = '';
          }
          opt += '<option value="'+response[i].tanggal_spb+'">'+tanggal+'</option>';
        }
        $('#tanggal_spb','#wrapper-table').html(opt).trigger('liszt:updated');
      }

    })
  }

</script>