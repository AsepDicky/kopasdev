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
      Verifikasi Transaksi <small>Verifikasi Transaksi Individu</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Transaksi Individu</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

      <div class="clearfix">
            Jenis Transaksi &nbsp; : &nbsp;
            <select id="jenis_transaksi" name="jenis_transaksi" class="m-wrap medium">
              <option value="all">Semua</option>
              <option value="1">TABUNGAN</option>
              <option value="2">PEMBIAYAAN</option>
            </select>
            No. Rekening &nbsp; : &nbsp;
            <input type="text" tabindex="1" name="account_no" id="account_no" class="small m-wrap">
            <a id="browse_account_no" class="btn blue" data-toggle="modal" href="#dialog_account_no">...</a>
            <button class="btn blue" id="filter">Filter</button>
            <?php
              $query = "(SELECT seq FROM mfi_trx_account_saving WHERE seq='0' AND created_date > '2019-01-01 00:00:01')
               UNION ALL
               (SELECT seq FROM mfi_trx_account_financing WHERE seq='0' AND created_date > '2019-01-01 00:00:01' AND verify_by IS NULL)";
              $sql = $this->db->query($query);
              if($sql->num_rows() > 0){
                echo '<button class="btn yellow" id="sequance">Create Ref.</button>';
              }

              $query2 = "SELECT a.* FROM mfi_trx_gl a JOIN mfi_account_financing b ON a.voucher_ref=b.account_financing_no";
              $sql2 = $this->db->query($query2);
              if($sql2->num_rows() > 0){
                echo '<button class="btn purple" id="sequance2">Push Ref.</button>';
              }
            ?>
            <button class="btn blue pull-right" id="detail">Detail  <i class="icon-th-list"></i></button>
            <button class="btn green pull-right" style="margin-right:5px;" id="verifikasi">Verifikasi  <i class="icon-ok-sign"></i></button>
            <button class="btn red pull-right" style="margin-right:5px;" id="reject">Reject  <i class="icon-remove"></i></button>
      </div>

        <div id="dialog_account_no" class="modal hide fade" tabindex="-1" data-width="600" style="margin-top:-200px;">
          <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
             <h3>Cari No Rekening</h3>
          </div>
          <div class="modal-body">
             <div class="row-fluid">
                <div class="span12">
                   <h4>Masukan Kata Kunci</h4>
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

        <!--Dialog Detail Tabungan-->
         <div id="dialog_detail_saving" title="Detail Transaksi Tabungan" style="display:none;">    
         <form id="t_dialog">  
            <table width="490">
               <tr>
                 <td style="width:140px;">Cabang</td>
                 <td><div id="t_branch_name"></div></td>
               </tr>
               <tr>
                 <td>Nama</td>
                 <td><div id="t_nama"></div></td>
               </tr>
               <tr>
                 <td>No. Rekening</td>
                 <td><div id="t_account_no"></div></td>
               </tr>
               <tr>
                 <td>Jenis Transaksi</td>
                 <td><div id="t_tipe_transaksi"></div></td>
               </tr>
               <tr>
                 <td>Tanggal Transaksi</td>
                 <td><div id="t_trx_date"></div></td>
               </tr>
               <tr>
                 <td>Jumlah Transaksi</td>
                 <td><div id="t_amount"></div></td>
               </tr>
               <tr>
                 <td>No. Referensi</td>
                 <td><div id="t_reference_no"></div></td>
               </tr>
               <tr>
                 <td>Keterangan</td>
                 <td><div id="t_keterangan"></div></td>
               </tr>
            </table>
         </form>
         </div>

        <!--Dialog Detail Pembiayaan-->
         <div id="dialog_detail_pembiayaan" title="Detail Transaksi Pembiayaan" style="display:none;">     
         <form id="p_dialog">  
            <table width="490">
               <tr>
                 <td style="width:140px;">Cabang</td>
                 <td><div id="p_branch_name"></div></td>
               </tr>
               <tr>
                 <td>Nama</td>
                 <td><div id="p_nama"></div></td>
               </tr>
               <tr>
                 <td>No. Rekening</td>
                 <td><div id="p_account_no"></div></td>
               </tr>
               <tr>
                 <td>Jenis Transaksi</td>
                 <td><div id="p_tipe_transaksi"></div></td>
               </tr>
               <tr>
                 <td>Tanggal Transaksi</td>
                 <td><div id="p_trx_date"></div></td>
               </tr>
               <tr>
                 <td>Tanggal Jatuh Tempo</td>
                 <td><div id="p_jto_date"></div></td>
               </tr>
               <tr>
                 <td>Pokok</td>
                 <td><div id="p_pokok"></div></td>
               </tr>
               <tr>
                 <td>Margin</td>
                 <td><div id="p_margin"></div></td>
               </tr>
               <tr>
                 <td>Cadangan Tabungan</td>
                 <td><div id="p_catab"></div></td>
               </tr>
               <tr>
                 <td>No. Referensi</td>
                 <td><div id="p_reference_no"></div></td>
               </tr>
               <tr>
                 <td>Frequensi</td>
                 <td><div id="p_freq"></div></td>
               </tr>
               <tr>
                 <td>Keterangan</td>
                 <td><div id="p_keterangan"></div></td>
               </tr>
            </table>
         </form>
         </div>

        <!--Dialog Detail SMK-->
         <div id="dialog_detail_smk" title="Detail Transaksi SMK" style="display:none;">     
         <form id="s_dialog">  
            <table width="490">
               <tr>
                 <td style="width:140px;">No Anggota</td>
                 <td><div id="s_cif_no"></div></td>
               </tr>
               <tr>
                 <td>No Sertifikat</td>
                 <td><div id="s_sertifikat_no"></div></td>
               </tr>
               <tr>
                 <td>Nama</td>
                 <td><div id="s_nama"></div></td>
               </tr>
               <tr>
                 <td>nominal</td>
                 <td><div id="s_nominal"></div></td>
               </tr>
               <tr>
                 <td>Tanggal Dikeluarkan</td>
                 <td><div id="s_date_issued"></div></td>
               </tr>
               <tr>
                 <td>Tipe Pembayaran</td>
                 <td><div id="s_trx_type"></div></td>
               </tr>
               <tr>
                 <td>Kode Kas Petugas</td>
                 <td><div id="s_account_cash_code"></div></td>
               </tr>
               <tr>
                 <td>Setor Tunai</td>
                 <td><div id="s_setor_tunai"></div></td>
               </tr>
               <tr>
                 <td>Tabungan Wajib</td>
                 <td><div id="s_tabungan_wajib"></div></td>
               </tr>
               <tr>
                 <td>Tabungan Kelompok</td>
                 <td><div id="s_tabungan_kelompok"></div></td>
               </tr>
               <tr>
                 <td>Total</td>
                 <td><div id="s_total"></div></td>
               </tr>
               <tr>
                 <td>Tanggal Transaksi</td>
                 <td><div id="s_trx_date"></div></td>
               </tr>
            </table>
         </form>
         </div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<table id="list485"></table>
<div id="plist485"></div>
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
   
      /* BEGIN DIALOG ACTION ACCOUNT NO */
     // $("#browse_account_no").click(function(){
     //    $.ajax({
     //       type: "POST",
     //       url: site_url+"transaction/get_no_rekening",
     //       dataType: "json",
     //       data: {keyword:$("#keyword","#dialog_account_no").val()},
     //       success: function(response){
     //          html = '';
     //          for ( i = 0 ; i < response.length ; i++ )
     //          {
     //              html += '<option value="'+response[i].no_rekening+'" nama="'+response[i].nama_cif+'">'+response[i].no_rekening+' - '+response[i].nama_cif+'</option>';
     //          }
     //          $("#result","#dialog_account_no").html(html);
     //       }
     //    })
     // })

     $("#keyword","#dialog_account_no").keyup(function(e){
        e.preventDefault();
        keyword = $(this).val();
        if(e.which==13)
        {
           $.ajax({
              type: "POST",
              url: site_url+"transaction/get_no_rekening",
              dataType: "json",
              data: {keyword:keyword},
              success: function(response){
                 html = '';
                 for ( i = 0 ; i < response.length ; i++ )
                 {
                     html += '<option value="'+response[i].no_rekening+'" nama="'+response[i].nama_cif+'">'+response[i].no_rekening+' - '+response[i].nama_cif+' ('+response[i].jenis_transaksi+')</option>';
                 }
                 $("#result","#dialog_account_no").html(html);
              }
           })
        }
     });

     $("#select","#dialog_account_no").click(function(){
        var no_rekening = $("#result").val();
        if(result!=null)
        {
           $("input[name='account_no']").val(no_rekening);
           $("#close","#dialog_account_no").trigger('click');
        }
     });

     $("#result option:selected","#dialog_account_no").live('dblclick',function(){
      $("#select","#dialog_account_no").trigger('click');
     });

     /* END DIALOG ACTION ACCOUNT NO */

    $("#filter").click(function(){
          $("#close","#dialog_account_no").trigger('click');
          $("#list485").trigger('reloadGrid');
    });

    $("#sequance").click(function(){
      var conf = confirm('Are you sure to Create Reference Number ?');
      if(conf){
        $.ajax({
           type: "POST",
           url: site_url+"transaction/create_no_reference",
           dataType: "json",
           data: {},
           success: function(response){
              if(response.status){
                alert("Create No Reff. Success !");
                $("#list485").trigger('reloadGrid');
              }
           }
        })
      }
    });

    $("#sequance2").click(function(){
      var conf = confirm('Are you sure to Create Reference Number ?');
      if(conf){
        $.ajax({
           type: "POST",
           url: site_url+"transaction/create_no_reference2",
           dataType: "json",
           data: {},
           success: function(response){
              if(response.status){
                location.reload();
              }
           }
        })
      }
    });

    $("#verifikasi").click(function(){
      var selrow = $("#list485").jqGrid('getGridParam','selrow');
      var data   = $("#list485").jqGrid('getRowData',selrow);
      var id     = data.id_transaksi;
      var jenis  = data.jenis_transaksi;
      var account_no = data.no_rekening;
      if (id==null) 
      {
          alert("Please Select Row !");
      } 
      else
      {
          var conf = confirm('Are you sure to Verification this Transaction ?');
            if(conf){
              $.ajax({
                type: "POST",
                url: site_url+"transaction/aktivasi_transaksi",
                dataType: "json",
                data: {id:id,jenis:jenis,account_no:account_no},
                success: function(response){
                  if(response.success==true){
                    alert("Verifikasi Success !");
                    $("#list485").trigger('reloadGrid');
                  }else if(response.msg!=''){
                    alert(response.msg);
                  }else{
                    alert("Verifikasi Gagal !");
                  }
                },
                error: function(){
                  alert("Failed to Connect into Databases, Please Contact Your Administration!")
                }
              });
            }
      };
    });

    $("#reject").click(function(){
      var selrow = $("#list485").jqGrid('getGridParam','selrow');
      var data   = $("#list485").jqGrid('getRowData',selrow);
      var id     = data.id_transaksi;
      var jenis  = data.jenis_transaksi;
      var account_no = data.no_rekening;
      if (id==null) 
      {
          alert("Please Select Row !");
      } 
      else
      {
          var conf = confirm('Are you sure to Reject this Transaction ?');
            if(conf){
              $.ajax({
                type: "POST",
                url: site_url+"transaction/reject_transaksi",
                dataType: "json",
                data: {id:id,jenis:jenis,account_no:account_no},
                success: function(response){
                  if(response.success==true){
                    alert("Reject Success !");
                    $("#list485").trigger('reloadGrid');
                  }else{
                    alert("Reject Gagal !");
                  }
                },
                error: function(){
                  alert("Failed to Connect into Databases, Please Contact Your Administration!")
                }
              });
            }
      };
    });


   var t_dialog = $("#t_dialog");
   var p_dialog = $("#p_dialog");
   var s_dialog = $("#s_dialog");
   $("#detail").click(function(){
    var selrow = $("#list485").jqGrid('getGridParam','selrow');
    var data   = $("#list485").jqGrid('getRowData',selrow);
    var id     = data.id_transaksi;
    var jenis  = data.jenis_transaksi;

    if (id==null){
      alert("Please Select Row !");
    }else{
    if(jenis=="Tabungan"){
       $.ajax({
        type: "POST",
        url: site_url+"transaction/detail_transaksi_tabungan",
        dataType: "json",
        data: {id:id},
        success: function(response){
            $("#t_branch_name",t_dialog).html(": "+response.nama_cabang);
            $("#t_nama",t_dialog).html(": "+response.nama_cif);
            $("#t_account_no",t_dialog).html(": "+response.no_rekening);
            var tipe_t = response.tipe_transaksi;
            if(tipe_t==1){
               tipe = "Setoran Tunai";
            }else if(tipe_t==2){
               tipe = "Penarikan Tunai";
            }else if(tipe_t==3){
               tipe = "Pemindah Bukuan Keluar";
            }else{
               tipe = "Pemindah Bukuan Masuk";
            }
            $("#t_tipe_transaksi",t_dialog).html(": "+tipe);
            $("#t_trx_date",t_dialog).html(": "+response.tgl_transaksi);
            $("#t_amount",t_dialog).html(": Rp. "+number_format(response.jumlah,0,',','.'));

            var no_ref = response.no_referensi;
            if(no_ref==null){
               ref = "-";
            }else{
               ref = response.no_referensi;
            }

            $("#t_reference_no",t_dialog).html(": "+ref);

            var ket = response.keterangan;
            if(ket==null){
               kete = "-";
            }else{
               kete = response.keterangan;
            }

            $("#t_keterangan",t_dialog).html(": "+kete);
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administration!")
        }
      });
      $("#dialog_detail_saving").dialog('open');
    }else if(jenis=="Pembiayaan"){
       $.ajax({
        type: "POST",
        url: site_url+"transaction/detail_transaksi_pembiayaan",
        dataType: "json",
        data: {id:id},
        success: function(response){
            $("#p_branch_name",p_dialog).html(": "+response.branch_name);
            $("#p_nama",p_dialog).html(": "+response.nama);
            $("#p_account_no",p_dialog).html(": "+response.account_financing_no);

            var tipe_t = response.trx_financing_type;
            if(tipe_t==0){
               tipe = "Droping";
            }else if(tipe_t==1){
               tipe = "Angsuran";
            }else{
               tipe = "Pelunasan";
            }

            $("#p_tipe_transaksi",p_dialog).html(": "+tipe);
            $("#p_trx_date",p_dialog).html(": "+response.trx_date);
            $("#p_jto_date",p_dialog).html(": "+response.jto_date);
            $("#p_pokok",p_dialog).html(": Rp. "+number_format(response.pokok,0,',','.'));
            $("#p_margin",p_dialog).html(": Rp. "+number_format(response.margin,0,',','.'));
            $("#p_catab",p_dialog).html(": Rp. "+number_format(response.catab,0,',','.'));

            var no_referensi = response.reference_no;
            if(no_referensi==null){
              no_ref = "-";
            }else{
              no_ref = response.reference_no;
            }

            $("#p_reference_no",p_dialog).html(": "+no_ref);
            // $("#p_tab_wajib",p_dialog).html(": Rp. "+number_format(response.tab_wajib,0,',','.'));
            // $("#p_tab_sukarela",p_dialog).html(": Rp. "+number_format(response.tab_sukarela,0,',','.'));

            var freq = response.freq;
            if(freq==null){
              freq = "-";
            }else{
              freq = response.freq;
            }

            $("#p_freq",p_dialog).html(": "+freq);

            var keterangan = response.description;
            if(keterangan==null){
              ket = "-";
            }else{
              ket = response.description;
            }

            $("#p_keterangan",p_dialog).html(": "+ket);
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administration!")
        }
      });
      $("#dialog_detail_pembiayaan").dialog('open');
    }else{
       $.ajax({
        type: "POST",
        url: site_url+"transaction/detail_transaksi_smk",
        dataType: "json",
        data: {id:id},
        success: function(response){
            $("#s_cif_no",s_dialog).html(": "+response.cif_no);
            $("#s_sertifikat_no",s_dialog).html(": "+response.sertifikat_no);
            $("#s_nama",s_dialog).html(": "+response.nama);
            $("#s_nominal",s_dialog).html(": Rp. "+number_format(response.nominal,0,',','.'));
            $("#s_date_issued",s_dialog).html(": "+response.date_issued);
            
            var tipe_t = response.trx_type;
            if(tipe_t==0){
               tipe = "Pinbuk";
            }else{
               tipe = "Tunai";
            }

            $("#s_trx_type",s_dialog).html(": "+tipe);

            var kode_kas = response.account_cash_code;
            if(kode_kas==""){
               kode = "-";
            }else{
               kode = response.account_cash_code;
            }

            $("#s_account_cash_code",s_dialog).html(": "+kode);
            $("#s_setor_tunai",s_dialog).html(": Rp. "+number_format(response.setor_tunai,0,',','.'));
            $("#s_tabungan_wajib",s_dialog).html(": Rp. "+number_format(response.tabungan_wajib,0,',','.'));
            $("#s_tabungan_kelompok",s_dialog).html(": Rp. "+number_format(response.tabungan_kelompok,0,',','.'));
            $("#s_total",s_dialog).html(": Rp. "+number_format(response.total,0,',','.'));
            $("#s_trx_date",s_dialog).html(": "+response.trx_date);
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administration!")
        }
      });
      $("#dialog_detail_smk").dialog('open');
    }
    }
   });

   //BEGIN DIALOG DETAIL
    $("#dialog_detail_saving").dialog({
      autoOpen: false,
      modal: true,
      width:500,
      height:400,
      buttons:{
      "Close" : function(){
          $(this).dialog('close');
          // $("#list485").trigger('reloadGrid');
       }
      }
    });

    $("#dialog_detail_pembiayaan").dialog({
      autoOpen: false,
      modal: true,
      width:500,
      height:400,
      buttons:{
      "Close" : function(){
          $(this).dialog('close');
          // $("#list485").trigger('reloadGrid');
       }
      }
    });

    $("#dialog_detail_smk").dialog({
      autoOpen: false,
      modal: true,
      width:500,
      height:400,
      buttons:{
      "Close" : function(){
          $(this).dialog('close');
          // $("#list485").trigger('reloadGrid');
       }
      }
    });

   //GRID SEMUA DATA TRANSAKSI
   jQuery("#list485").jqGrid({
     url: site_url+'transaction/grid_verifikasi_transaksi',
     //data: mydata,
     datatype: 'json',
     height: 'auto',
     postData: {
       account_no : function(){return $("#account_no").val()},
       jenis_transaksi: function(){return $("#jenis_transaksi").val()}
     },
     rowNum: 999999999,
     autowidth: true,
     shrinkToFit: false,
     rowList: [999999999],
       colNames:['ID', 'Jenis Transaksi', 'Tgl Transaksi', 'No. Rekening', 'Nama', 'Jumlah','Keterangan','Pic','Produk','No Referensi'],
       colModel:[
         {name:'id_transaksi',index:'id_transaksi', width:150, hidden:true},
         {name:'jenis_transaksi',index:'jenis_transaksi', width:100},
         {name:'tgl_transaksi',index:'tgl_transaksi', width:80, align:'center',formatter: "date", formatoptions: { newformat: "d-m-Y"}},
         {name:'no_rekening',index:'no_rekening', width:130},
         {name:'nama_cif',index:'nama_cif', width:150},    
         {name:'jumlah',index:'jumlah', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0}},
         {name:'keterangan',index:'keterangan', align:'left',width:150,formatter:function(cellvalue){
          return '<b>'+cellvalue+'</b>';
         }},
         {name:'account_name',index:'account_name', width:130},
         {name:'product_name',index:'product_name', width:100},
         {name:'no_referensi',index:'no_referensi', width:140, align:'center'}
       ],
       pager: "#plist485",
       viewrecords: true,
       sortname: 'tgl_transaksi, nama_cif',
       grouping:true,
       groupingView : {
         groupField : ['jenis_transaksi'],
         groupColumnShow : [true],
         groupText : ['<b style="font-size:14px;">{0} - {1} Data Transaksi </b>'],
         groupCollapse : false,
         groupDataSorted : true,
       groupOrder: ['desc']      
       },
       caption: "Verifikasi Transaksi Individu",
       ondblClickRow:function(rowid){
          // var data = jQuery(this).jqGrid('list485', rowid);
          $("#verifikasi").trigger('click');
       }
   });
   </script>
   <!-- END JAVASCRIPTS -->

