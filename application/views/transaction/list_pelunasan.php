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
        Pelunasan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box purple" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>List Pelunasan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form>
            <table id="filter-form">
               <tr>
                  <td width="150" valign="middle">Akad</td>
                  <td valign="top">
                    <select name="akad" id="akad" style="width:190px;" class="chosen">
                      <option value="-">Semua</option>
                      <?php foreach($akad as $data):?>
                      <option value="<?php echo $data['akad_code'];?>" ><?php echo $data['akad_code'].' - '.$data['akad_name'];?></option>
                      <?php endforeach?>
                    </select>
                  </td>
               </tr>
               <tr>
                <td valign="middle" width="100">Produk</td>
                <td>
                  <div class="controls">
                     <select id="produk_pembiayaan" name="produk_pembiayaan" class="chosen" style="width:190px;">
                       <option value="0000">Semua</option>
                        <?php foreach($produk as $produk){ ?>
                       <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                       <?php } ?>
                     </select>
                  </div>
                </td>
              </tr>
              <tr class="group-smile" style="display: none;">
                <td valign="middle" width="100">SMILE product list</td>
                <td>
                  <div class="controls">
                    <select class="m-wrap chosen" name="product_code_smile" id="product_code_smile">
                      <option value="" maxrate="">PILIH</option>
                      <option value="52">default</option>
                      <?php foreach($product_smile as $key){ ?>
                      <option value="<?php echo $key['product_code'] ?>"><?php echo $key['product_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </td>
              </tr>
             <tr>
                <td width="150" valign="middle">Jatuh Tempo Angsuran</td>
                <td valign="top">
                  <div class="controls">
                    <!-- <input type="text" class="date-picker maskdate small m-wrap mask_date" name="tanggal_jtempo" id="tanggal_jtempo" value="<?php echo '25/'.date('m/Y',strtotime($v_periode_awal)) ?>"> -->
                    <input type="text" name="from_date" id="from_date" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" maxlength="10" value="<?php echo '01/'.date('m/Y',strtotime($v_periode_awal)) ?>" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                    sd
                    <input type="text" name="thru_date" id="thru_date" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" maxlength="10" value="<?php echo '25/'.date('m/Y',strtotime($v_periode_awal)) ?>" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                  </td>
                 </div>
                </td>
             </tr>
               <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="showgrid">Lihat Pelunasan</button>
                     <!-- <button class="green btn" id="previewpdf">Preview</button> -->
                     <button class="blue btn" id="downloadxls">Download Pelunasan</button>
                     <!-- <button class="green btn" id="previewcsv">Preview CSV</button> -->
                  </td>
               </tr>
            </table>
         </form>
          <p><hr></p>

          <table id="list_pelunasan"></table>
          <div id="plist_pelunasan"></div>
          <!-- END FILTER-->
      </div>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
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
  $(function(){
  /* BEGIN SCRIPT */

  $('#produk_pembiayaan').on('change', function() {
      if(this.value=='52'){
        $('.group-smile').show();
        $('#product_code_smile').val(null).trigger('change');
      }else{
        $('.group-smile').hide();
        $('#product_code_smile').val(null).trigger('change');
      }
    });

  $("#showgrid").click(function(e){
    e.preventDefault();

    if($('#from_date').val() == '' || $('#thru_date').val() == ''){
      App.WarningAlert("Jatuh Tempo Angsuran tidak boleh kosong !");
    }else{
      $("#list_pelunasan").trigger('reloadGrid')
      view_grid_pelunasan();
    }
  });

  $("#downloadxls").click(function(e)
  {
    e.preventDefault();
    var from_date = datepicker_replace($('#from_date').val());
    var thru_date = datepicker_replace($('#thru_date').val());
    var akad = $('#akad').val();
    var produk_pembiayaan = $("#produk_pembiayaan").val();
    var product_code_smile = $("#product_code_smile").val();
    if(produk_pembiayaan == '52'){
      produk_pembiayaan =  product_code_smile;
    }else{
      produk_pembiayaan = produk_pembiayaan
    }

    window.open('<?php echo site_url();?>laporan_to_excel/export_list_pelunasan/'+from_date+'/'+thru_date+'/'+akad+'/'+produk_pembiayaan);
  });

  function view_grid_pelunasan()
  {
    jQuery("#list_pelunasan").jqGrid({
      url: site_url+"transaction/jqgrid_list_pelunasan",
      datatype: 'json',
      height: 'auto',
      autowidth: true,
      postData: {
         from_date : function(){return $('#from_date').val()}
        ,thru_date : function(){return $('#thru_date').val()}
        ,akad : function(){return $("#akad").val()}
        ,produk_pembiayaan : function(){
          var produk_pembiayaan = $("#produk_pembiayaan").val();
          var product_code_smile = $("#product_code_smile").val();
          if(produk_pembiayaan == '52'){
            return product_code_smile;
          }else{
            return produk_pembiayaan
          }
        }
      },
      rowNum: 15,
      rowList: [50,100,150,200,250,300,350,400],
        colModel: [
          { label: 'No. Pembiayaan', name: 'account_financing_no', key: true, width: 80 },
          { label: 'NIK', name: 'cif_no', width: 50 },
          { label: 'Nama', name: 'nama', width: 170 },
          { label: 'Produk', name: 'product_name', width: 100 },
          { label: 'Kode Produk', name: 'product_code', width: 55, align:'center', hidden:true },
          { label: 'Flag Angsuran', name: 'flag_jadwal_angsuran', width: 100, hidden:true },
          { label: 'Saldo Pokok', name: 'flag_jadwal_angsuran', width: 100, hidden:true },
          { label: 'account_financing_id', name: 'account_financing_id', width: 100, hidden:true },
          { label: 'branch_id', name: 'branch_id', width: 100, hidden:true },
          { label: 'Pokok Pembiayaan', name: 'pokok_pembiayaan', width: 100, hidden:true},
          { label: 'Margin Pembiayaan', name: 'margin_pembiayaan', width: 100, hidden:true },
          { label: 'Jangka Waktu', name: 'jangka_waktu', width: 55, align:'center'},
          { label: 'counter_angsuran', name: 'counter_angsuran', width: 100, hidden:true },
          { label: 'Angsuran Pokok', name: 'angsuran_pokok', width: 100, hidden:true},
          { label: 'Angsuran Margin', name: 'angsuran_margin', width: 100, hidden:true},
          { label: 'Total Angsuran', name: 'total_angsuran', width: 80, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
          { label: 'Angksuran Ke-', name: 'counter_angsuran', width: 65, align:'center'},
          { label: 'Tgl Berakhir Angsuran', name: 'tanggal_jtempo', width: 100, align: 'center' },
          { label: 'Keterangan', name: 'keterangan', width: 100, hidden:true },

        ],
        autowidth: true,
        shrinkToFit: true,
        pager: "#plist_pelunasan",
        viewrecords: true,
        sortname: 'account_financing_no',
        grouping:false,
        rowNum: 999999999,
        rownumbers: true,
        footerrow: true,
        gridComplete: function() {
          var $grid = $('#list_pelunasan');
          var colSum = $grid.jqGrid('getCol', 'total_angsuran', false, 'sum');
          $grid.jqGrid('footerData', 'set', { 'total_angsuran': colSum });
        }

    });
  }

});
</script>
<!-- END JAVASCRIPTS -->