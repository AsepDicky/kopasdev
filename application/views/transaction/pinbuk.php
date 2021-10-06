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
      <h3 class="page-title">
        Pemindah Bukuan <small>Melakukan pemindah bukuan ke No.Rekening lain</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Penarikan Tunai Tabungan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <?php if($_is_exist_user_cash==false){ ?>
      <div class="alert alert-warning">
        WARNING : USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!
      </div>
      <?php } ?>
      <div class="clearfix" style="position:absolute">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pinbuk_table">
         <thead>
            <tr>
               <th width="35%">Rekening Sumber</th>
               <th width="35%">Rekening Tujuan</th>
               <th width="15%">Jumlah Pinbuk</th>
               <th width="15%">Tanggal Transaksi</th>
               <th>Delete</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>

<div id="dialog_no_rekening_tujuan" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Nomor Rekening Tujuan</h3>
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
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog_no_rekening_sumber" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Nomor Rekening Sumber</h3>
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

<!-- BEGIN PROSES PINBUK -->
<div id="add" class="hide">
   
   <div class="portlet box blue">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Form Pemindah Bukuan</div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form id="form_process" class="form-horizontal">
          <?php if($_is_exist_user_cash==false){ ?>
          <div class="alert alert-warning">
            WARNING : USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!
          </div>
          <?php } ?>
          <div class="alert alert-error hide">
             You have some form errors. Please check below.
          </div>
          <div class="alert alert-success hide">
             Pemindah Bukuan Sukses !
          </div>
            <h3 class="form-section">Rekening Sumber</h3>
            
            <div class="control-group">
               <label class="control-label">No. Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_rekening_sumber" id="no_rekening_sumber" class="medium m-wrap" />
                  <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_no_rekening_sumber">...</a>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_sumber" data-required="1" class="medium m-wrap" readonly/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="produk_sumber" data-required="1" class="medium m-wrap" readonly/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Efektif<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                      <input type="text" name="saldo_efektif_sumber" data-required="1" class="small m-wrap mask-money" readonly style="background:#F5F5F5"/>
                     <span class="add-on" style="width:1px">00</span>
                  </div>
               </div>
            </div>

            <h3 class="form-section">Rekening Tujuan</h3>

            <div class="control-group">
               <label class="control-label">No. Rekening<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_rekening_tujuan" id="no_rekening_tujuan" data-required="1" class="medium m-wrap" />
                  <a id="browse_rembug2" class="btn blue" data-toggle="modal" href="#dialog_no_rekening_tujuan">...</a>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_tujuan" data-required="1" class="medium m-wrap" readonly/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="produk_tujuan" data-required="1" class="medium m-wrap" readonly/>
               </div>
            </div>

            <h3 class="form-section">Transaksi</h3>
            <div class="control-group">
               <label class="control-label">Tanggal Efektif<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_efektif_transaksi" placeholder="dd/mm/yyyy" id="mask_date" data-required="1" value="<?php echo $current_date; ?>" class="date-picker medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jumlah Pemindah Bukuan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                        <input type="text" name="jumlah_pinbuk_transaksi" maxlength="10" data-required="1" class="small m-wrap mask-money"/>
                     <span class="add-on">00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Referensi</label>
               <div class="controls">
                  <input type="text" name="no_referensi_transaksi" data-required="1" maxlength="20" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea class="m-wrap" name="keterangan_transaksi" maxlength="255"></textarea>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" class="btn green" id="save">Save</button>
               <button class="btn blue" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END PROSES PINBUK -->


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
   $(function() {    
      App.init(); // initlayout and core plugins
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){

// fungsi untuk reload data table
// di dalam fungsi ini ada variable tbl_id
// gantilah value dari tbl_id ini sesuai dengan element nya
var dTreload = function()
{
  var tbl_id = 'pinbuk_table';
  $("select[name='"+tbl_id+"_length']").trigger('change');
  $(".paging_bootstrap li:first a").trigger('click');
  $("#"+tbl_id+"_filter input").val('').trigger('keyup');
}

/**
* DELETE PINBUK
* element : link-delete
* @author : sayyid
* date : 25 agustus 2014
*/

$("a#link-delete").live('click',function(e){
  e.preventDefault();
  var trx_detail_id=$(this).attr('trx_detail_id');
  var no_rek_tabungan_sumber=$(this).attr('no_rek_tabungan_sumber');
  var nama_tabungan_sumber=$(this).attr('nama_tabungan_sumber');
  var conf=confirm("Akan melakukan Delete Transaksi PINBUK "+no_rek_tabungan_sumber+" ("+nama_tabungan_sumber+"), Apakah anda Yakin?");
  if(conf){
    $.ajax({
      type:"POST",
      dataType:"json",
      url:site_url+"transaction/delete_pinbuk",
      async:false,
      data:{trx_detail_id:trx_detail_id},
      success:function(response){
        if(response.success==true){
          alert("Delete Transaksi Penarikan Tunai, Sukses!");
        }else{
          alert("Internal Server Error");
        }
        dTreload();
      },
      error: function(){
        alert("Failed to Connect into Databases, Please Contact Your Administrator");
      }
    })
  }
})

  $("#keyword","#dialog_no_rekening_sumber").keypress(function(e){
    // e.preventDefault();
    keyword = $(this).val();
    no_rekening_tujuan=$("#no_rekening_tujuan").val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"transaction/get_no_rekening_pinbuk_sumber",
         dataType: "json",
         async:false,
         data: {keyword:keyword,no_rekening_tujuan:no_rekening_tujuan},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'" status_rekening="'+response[i].status_rekening+'" produk="'+response[i].product_name+'" saldo_efektif="'+response[i].saldo_efektif+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
            }
            $("#result","#dialog_no_rekening_sumber").html(html);
            $("#result","#dialog_no_rekening_tujuan").html('');
         }
      })
    }
  });

  $("#result option","#dialog_no_rekening_sumber").live('dblclick',function(){
           $("#select","#dialog_no_rekening_sumber").trigger('click');
        });

  $("#select","#dialog_no_rekening_sumber").click(function(){
    result = $("#result","#dialog_no_rekening_sumber").val();
    if(result!=null)
    {
      status_rekening = $("#result option:selected","#dialog_no_rekening_sumber").attr('status_rekening');
      if(status_rekening!=1){
        alert("Maaf, Akun ini tidak dapat melakukan Pemindah Bukuan !");
      }else{
        $("input[name='no_rekening_sumber']").val(result);
        $("input[name='nama_sumber']").val($("#result option:selected","#dialog_no_rekening_sumber").attr('nama'));
        $("input[name='produk_sumber']").val($("#result option:selected","#dialog_no_rekening_sumber").attr('produk'));
        $("input[name='saldo_efektif_sumber']").val(number_format($("#result option:selected","#dialog_no_rekening_sumber").attr('saldo_efektif'),0,',','.'));
        $("#close","#dialog_no_rekening_sumber").trigger('click');
      }
    }
  });

  $("#keyword","#dialog_no_rekening_tujuan").keypress(function(e){
    // e.preventDefault();
    keyword = $(this).val();
    no_rekening_sumber=$("#no_rekening_sumber").val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"transaction/get_no_rekening_pinbuk_tujuan",
         dataType: "json",
         async:false,
         data: {keyword:keyword,no_rekening_sumber:no_rekening_sumber},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'" status_rekening="'+response[i].status_rekening+'" produk="'+response[i].product_name+'">'+response[i].account_saving_no+' - '+response[i].nama+'</option>';
            }
            $("#result","#dialog_no_rekening_tujuan").html(html);
            $("#result","#dialog_no_rekening_sumber").html('');
         }
      })
    }
  });

  $("#select","#dialog_no_rekening_tujuan").click(function(){
    result = $("#result","#dialog_no_rekening_tujuan").val();
    if(result!=null)
    {
      status_rekening = $("#result option:selected","#dialog_no_rekening_tujuan").attr('status_rekening');
      if(status_rekening==2){
        alert("Maaf, Akun ini tidak dapat melakukan Pemindah Bukuan !");
      }else{
        $("input[name='no_rekening_tujuan']").val(result);
        $("input[name='nama_tujuan']").val($("#result option:selected","#dialog_no_rekening_tujuan").attr('nama'));
        $("input[name='produk_tujuan']").val($("#result option:selected","#dialog_no_rekening_tujuan").attr('produk'));
        $("#close","#dialog_no_rekening_tujuan").trigger('click');
      }
    }
  });

  $("#result option","#dialog_no_rekening_tujuan").live('dblclick',function(){
           $("#select","#dialog_no_rekening_tujuan").trigger('click');
        });
  var form1 = $('#form_process');
  var error1 = $('.alert-error',form1);
  var warning1 = $('.alert-warning',form1);
  var success1 = $('.alert-success',form1);
  
  $("#btn_add").click(function(){
    error1.hide();
    success1.hide();
    $("#wrapper-table").hide();
    $("#add").show();
    form1.trigger('reset');
    $("select#result").html('');
    $('#no_rekening_sumber', '#form_process').focus()
  });

  $("#cancel").click(function(e){
    e.preventDefault();
    error1.hide();
    success1.hide();
    $("#wrapper-table").show();
    $("#add").hide();
    form1.trigger('reset');
    dTreload();
  })


  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error,element){},
    rules: {
        no_rekening_sumber: {
            required: true
        },
        nama_sumber: {
            required: true
        },
        produk_sumber: {
            required: true
        },
        saldo_efektif_sumber: {
            required: true
        },
        no_rekening_tujuan: {
            required: true
        },
        nama_tujuan: {
            required: true
        },
        produk_tujuan: {
            required: true
        },
        tanggal_efektif_transaksi: {
            required: true,
            cek_trx_kontrol_periode : true
        },
        jumlah_pinbuk_transaksi: {
            required: true
        },/*
        no_referensi_transaksi: {
            required: true
        },*/
        keterangan_transaksi: {
            required: true
        }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },

    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.help-inline').removeClass('ok'); // display OK icon
        $(element)
            .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },

    unhighlight: function (element) { // revert the change dony by hightlight
        $(element)
            .closest('.control-group').removeClass('error'); // set error class to the control group
    },

    success: function (label) {
      // if(label.closest('.input-append').length==0)
      // {
      //   label
      //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
      //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
      // }
      // else
      // {
      //    label.closest('.control-group').removeClass('error').addClass('success')
      //    label.remove();
      // }
    },

    submitHandler: false
  
  });

  $("#save").click(function(e){
    e.preventDefault();
    if(form1.valid()===true)
    {
      var jumlah_pinbuk_transaksi = parseFloat($("input[name='jumlah_pinbuk_transaksi']").val());
      var saldo_efektif_sumber    = parseFloat($("input[name='saldo_efektif_sumber']").val());
      var _is_exist_user_cash = "<?php echo $_is_exist_user_cash; ?>";
      console.log(_is_exist_user_cash);
      if(_is_exist_user_cash==0)
      {
        App.scrollTo(warning1, -200);
        alert("WARING: USER INI BELUM MELAKUKAN SETUP KAS TELLER, SILAHKAN SETUP KAS TELLER TERLEBIH DAHULU!")
      }
      else
      {
        if(jumlah_pinbuk_transaksi>saldo_efektif_sumber)
        {
          alert("Jumlah Pemindahan Buku Tidak Boleh Melebihi Saldo Efektif !");
        }
        else
        {
          $.ajax({
            type: "POST",
            dataType: "json",
            url: site_url+"transaction/process_pinbuk",
            async:false,
            data: $("#form_process").serialize(),
            success: function(response){
              if(response.success==true){
                alert("Pemindahan Buku Sukses !");
                $("#cancel").trigger('click');
                success1.show();
                error1.hide();
                form1.find('.control-group').removeClass('success');
                App.scrollTo(error1, -900);
                $("#no_rekening_sumber").focus();
              }else{
                alert("Failed to Connection into Databases. Please Contact Your Administrator !");
                success1.hide();
                error1.show();
              }
            },
            error: function(){
              alert("Failed to Connection into Databases. Please Contact Your Administrator !");
            }
          });
        }
      }
    }
  });

  // begin first table
  $('#pinbuk_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_pinbuk_tabungan",
      "aoColumns": [
        null,
        null,
        null,
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
  // jQuery('#pinbuk_table_filter').closest('.row-fluid').hide();
  // jQuery('#pinbuk_table_length').closest('.row-fluid').hide();
  jQuery('#pinbuk_table_length').hide();

});
</script>

<script type="text/javascript">
  $(function(){
    $('#no_rekening_sumber', '#form_process').keydown(function (e) {
      if (e.which == 123) {
        $('#browse_rembug').trigger('click');
        e.preventDefault();
      }else{
        e.preventDefault();
      }
    });
    $('#browse_rembug').click(function(e){
      setTimeout(function () {
        $('#keyword', '#dialog_no_rekening_sumber').focus();
      }, 1000);
      e.preventDefault();
    })
    $('#result', '#dialog_no_rekening_sumber').keyup(function (e) {
      if (e.which == 13) {
        $('#select', '#dialog_no_rekening_sumber').trigger('click');
      }
    });
    $('#result', '#dialog_no_rekening_sumber').keydown(function (e) {
      if (e.which == 123) {
        $('#keyword', '#dialog_no_rekening_sumber').focus();
        $(this).val('');
        e.preventDefault();
      }
    });
    $('#keyword', '#dialog_no_rekening_sumber').keyup(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });
    $('#keyword', '#dialog_no_rekening_sumber').keyup(function (e) {
      if (e.which == 13) {
        $('#result', '#dialog_no_rekening_sumber').focus();
        $('#result option:first-child', '#dialog_no_rekening_sumber').attr('selected', true);
      }
    });
    $('#close', '#dialog_no_rekening_sumber').click(function (e) {
      $('#no_rekening_sumber', '#form_process').focus();
      $("#result","#dialog_no_rekening_sumber").val('');
    });
    $('#select', '#dialog_no_rekening_sumber').click(function (e) {
      $("#result","#dialog_no_rekening_sumber").val('');
      $('#no_rekening_tujuan',"#form_process").focus();
    });
    $(window).keydown(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });

    //REKENING TUJUAN
    $('#no_rekening_tujuan', '#form_process').keydown(function (e) {
      if (e.which == 123) {
        $('#browse_rembug2').trigger('click');
        e.preventDefault();
      }else{
        e.preventDefault();
      }
    });
    $('#browse_rembug2').click(function(e){
      setTimeout(function () {
        $('#keyword', '#dialog_no_rekening_tujuan').focus();
      }, 1000);
      e.preventDefault();
    })
    $('#result', '#dialog_no_rekening_tujuan').keyup(function (e) {
      if (e.which == 13) {
        $('#select', '#dialog_no_rekening_tujuan').trigger('click');
      }
    });
    $('#result', '#dialog_no_rekening_tujuan').keydown(function (e) {
      if (e.which == 123) {
        $('#keyword', '#dialog_no_rekening_tujuan').focus();
        $(this).val('');
        e.preventDefault();
      }
    });
    $('#keyword', '#dialog_no_rekening_tujuan').keyup(function (e) {
      if (e.which == 13) {
        $('#result', '#dialog_no_rekening_tujuan').focus();
        $('#result option:first-child', '#dialog_no_rekening_tujuan').attr('selected', true);
      }
    });
    $('#keyword', '#dialog_no_rekening_tujuan').keydown(function (e) {
      if (e.which == 123) {
        e.preventDefault();
      }
    });
    $('#close', '#dialog_no_rekening_tujuan').click(function (e) {
      $('#no_rekening_tujuan', '#form_process').focus();
      $("#result","#dialog_no_rekening_tujuan").val('');
    });
    $('#select', '#dialog_no_rekening_tujuan').click(function (e) {
      $("#result","#dialog_no_rekening_tujuan").val('');
      $('input[name="tanggal_efektif_transaksi"]',"#form_process").focus().select();
      App.scrollTo($('input[name="tanggal_efektif_transaksi"]',"#form_process"),-200);
    });


    /*
    |-------------------------------------------------------------------------------
    | BEGIN : ENTER EVENT FOR ADD
    |-------------------------------------------------------------------------------
    */
    $("input,select,textarea","#form_process").live('keypress',function(e){
        if(e.keyCode==13) {
         e.preventDefault();
          if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT' || $(this).next().prop('tagName')=='TEXTAREA') {
            $(this).next().focus();
          }else{
            if($(this).closest('.control-group').next('.form-actions').length==1){
              $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
            }else{
              if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select,textarea').attr('readonly'))!='undefined'){
                $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select,textarea').focus();
              }else{
                $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select,textarea').focus();
              }
            }
          }
        }
    });

    /*
    |-------------------------------------------------------------------------------
    | END : ENTER EVENT FOR ADD
    |-------------------------------------------------------------------------------
    */

  })
</script>