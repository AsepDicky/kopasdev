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
        LAPORAN <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari Kantor Cabang</h3>
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

<!-- DIALOG REMBUG -->
<div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Cari Rembug</h3>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>List Outstanding Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form>
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
            <input type="hidden" name="flag_all_branch" id="flag_all_branch" value="<?php echo $this->session->userdata('flag_all_branch') ?>">
            <table id="filter-form">
               <tr style="display:none;">
                  <td style="padding-bottom:10px;" width="100">Cabang</td>
                  <td>
                     <input type="text" name="branch" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                     <?php if($this->session->userdata('flag_all_branch')){ ?>
                     <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
                     <?php } ?>
                  </td>
               </tr>
               <tr>
                  <td width="150" valign="top">Akad</td>
                  <td valign="top">
                    <select name="akad" id="akad" style="width:190px;" class="">
                      <option value="-">Semua</option>
                      <?php foreach($akad as $data):?>
                      <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_code'].' - '.$data['akad_name'];?></option>
                      <?php endforeach?>
                    </select>
                  </td>
               </tr>
               <tr>
                <td valign="top" width="100">Produk</td>
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
                      <option value="semua">SEMUA</option>
                      <option value="52">FLAT</option>
                      <?php foreach($product_smile as $key){ ?>
                      <option value="<?php echo $key['product_code'] ?>"><?php echo $key['product_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </td>
              </tr>
             <tr>
                <td width="150" valign="top">Kopegtel</td>
                <td valign="top">
                  <select name="pengajuan_melalui" id="pengajuan_melalui" style="width:190px;" class="chosen">
                    <option value="-">Semua</option>
                    <option value="koptel">KOPTEL LANGSUNG</option>
                    <?php foreach($kopegtel as $data):?>
                    <option value="<?php echo $data['kopegtel_code'];?>"><?php echo $data['nama_kopegtel'];?></option>
                    <?php endforeach?>
                  </select>
                </td>
             </tr>
             <tr>
                <td width="150" valign="top">Peruntukan</td>
                <td valign="top">
                  <select name="peruntukan" id="peruntukan" style="width:190px;" class="chosen">
                    <option value="-">Semua</option>
                    <?php foreach($peruntukan as $data):?>
                    <option value="<?php echo $data['code_value'];?>"><?php echo $data['peruntukan'];?></option>
                    <?php endforeach?>
                  </select>
                </td>
             </tr>
               <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="showgrid">Show Grid</button>
                     <button class="green btn" id="previewxls">Preview Excel</button>
                     <!-- <button class="green btn" id="previewpdf">Preview</button>
                     <button class="green btn" id="previewcsv">Preview CSV</button> -->
                  </td>
               </tr>
            </table>
         </form>
          <p><hr></p>

          <table id="list485"></table>
          <div id="plist485"></div>
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

      $('#produk_pembiayaan').on('change', function() {
        if(this.value=='52'){
          $('.group-smile').show();
          $('#product_code_smile').val(null).trigger('change');
        }else{
          $('.group-smile').hide();
          $('#product_code_smile').val(null).trigger('change');
        }
      });

   });
</script>


<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

$("#showgrid").click(function(e){
	e.preventDefault(); 
    var akad = $("#akad").val();
    // var produk = $("#produk_pembiayaan").val();
    var pengajuan_melalui = $("#pengajuan_melalui").val();
    var peruntukan = $("#peruntukan").val();
    
    var produk_pembiayaan = $("#produk_pembiayaan").val();
    var product_code_smile = $("#product_code_smile").val();
    if(produk_pembiayaan == '52'){
      var produk = product_code_smile;
    }else{
      var produk = produk_pembiayaan;
    }

    $("#list485").trigger('reloadGrid')
})

//GRID SEMUA DATA ANGGOTA
jQuery("#list485").jqGrid({
  url: site_url+'laporan/jqgrid_list_outstanding_pembiayaan',
  datatype: 'json',
  height: 'auto',
  autowidth: true,
  shrinkToFit: false,
  postData: {
      akad : function(){return $("#akad").val()}
      ,produk_pembiayaan : function(){
          var produk_pembiayaan = $("#produk_pembiayaan").val();
          var product_code_smile = $("#product_code_smile").val();
          if(produk_pembiayaan == '52'){
            return product_code_smile;
          }else{
            return produk_pembiayaan
          }
        }
      ,pengajuan_melalui : function(){return $("#pengajuan_melalui").val()}
      ,peruntukan : function(){return $("#peruntukan").val()}
  },
  rowNum: 30,
  rowList: [50,100,150,200,250,300,350,400],
    colNames:['No. Rekening','Nama','Tgl. Droping','Pokok','Margin','Freq. Bayar','Saldo Pokok','Saldo Margin','Tertunggak Freq.','Tertunggak Pokok','Tertunggak Margin', 'Saldo Outstanding'],
    colModel:[
      {name:'account_financing_no',index:'account_financing_no',width: 80 },
      {name:'nama', index:'nama', width: 150 },
      {name:'droping_date',index:'droping_date',width: 85,align:'center' },
      {name:'pokok',index:'pokok', sortable: false, width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} },
      {name:'margin',index:'margin', sortable: false, width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } },
      {name:'freq_bayar_pokok',index:'freq_bayar_pokok',width: 85,align:'center'},
      {name:'saldo_pokok',index:'saldo_pokok', sortable: false, width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} },
      {name:'saldo_margin',index:'saldo_margin', sortable: false, width: 90, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} },
      {name:'freq_tunggakan',index:'freq_tunggakan',width: 95,align:'center'},
      {name:'tunggakan_pokok',index:'tunggakan_pokok', sortable: false, width: 100, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} },
      {name:'tunggakan_margin',index:'tunggakan_margin', sortable: false, width: 100, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} },
      {name:'saldo_outstanding',index:'saldo_outstanding', sortable: false, width: 95, align:'right', formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0'} }
    ],
    pager: "#plist485",
    viewrecords: true,
    sortname: 'account_financing_no',
    grouping:false,
    // caption: "List Data Anggota"
});


/* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
      result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      result_code = $("#result","#dialog_branch").val();
      if(result!=null)
      {
          $("input[name='branch']").val(result_name);
          $("input[name='branch_code']").val(result_code);
          $("input[name='branch_id']").val(branch_id);
          produk = $("#produk").val();
          if(produk=='1'){
            $("#field_rembug").hide();
          }else if(produk=='0'){
            $("#field_rembug").show();
          }else{
            $("#field_rembug").hide();
          }
          $("#close","#dialog_branch").trigger('click');
      }
      // reload_resort(result_code)
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   });

   /* END DIALOG ACTION BRANCH */


   /* RESORT */  
    if ($("#flag_all_branch").val()=='1') {
      var branch_code = '00000'
    } else{
      var branch_code = $("#branch_code").val()
    };
    // reload_resort(branch_code)

    function reload_resort(branch_code) {
      $.ajax({
         type: "POST",
         url: site_url+"laporan/get_all_resort_by_branch_code",
         dataType: "json",
         data: {branch_code:branch_code},
         success: function(response){
            html = '<option value="00000">Semua</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].resort_code+'">'+response[i].resort_name+'</option>';
            }
            $("#resort").html(html);
            $("#resort").trigger('liszt:updated')
         }
      })
    }
   /* END RESORT */

    $(function(){
      branch_code = $("#branch_code").val();
      if(branch_code=='')
      {
        $("#field_rembug").hide();
      }
      else
      {
        $("#field_rembug").show();
      }
    });


   /* BEGIN DIALOG ACTION REMBUG */
  
   $("#browse_rembug").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_rembug").val(),branch_id:$("#branch_id").val()},
         success: function(response){
            html = '<option value="" cm_id="" cm_name="Semua Rembug">Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   })

   $("#keyword","#dialog_rembug").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword",
            dataType: "json",
            data: {keyword:keyword,branch_id:$("#branch_id").val()},
            success: function(response){
              html = '<option value="" cm_id="" cm_name="Semua Rembug">Semua Rembug</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
              }
              $("#result","#dialog_rembug").html(html);
            }
         })
      }
   });

   $("#select","#dialog_rembug").click(function(){
      cm_id = $("#result option:selected","#dialog_rembug").attr('cm_id');
      cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
      cm_code = $("#result","#dialog_rembug").val();
      if(result!=null)
      {
         $("input[name='rembug']").val(cm_name);
         $("input[name='cm_code']").val(cm_code);
         $("#close","#dialog_rembug").trigger('click');
      }
   });

   $("#result option:selected","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
   })

   /* END DIALOG ACTION REMBUG */

      //export CSV
      $("#previewcsv").click(function(e)
      {
        e.preventDefault();
        var akad = $("#akad").val();

        var product = $("#produk_pembiayaan").val();
        var product_code_smile = $("#product_code_smile").val();
        if(product == '52'){
          var produk_pembiayaan = product_code_smile;
        }else{
          var produk_pembiayaan = product;
        }
        
        // var produk_pembiayaan = $("#produk_pembiayaan").val();
        var pengajuan_melalui = $("#pengajuan_melalui").val();
        var peruntukan = $("#peruntukan").val();
        window.open('<?php echo site_url();?>laporan_to_csv/export_lap_list_outstanding_pembiayaan_individu/'+akad+'/'+produk_pembiayaan+'/'+pengajuan_melalui+'/'+peruntukan);
      });
      
      //export XLS
      $("#previewxls").click(function(e)
      {
        e.preventDefault();
        var akad = $("#akad").val();
        // var produk_pembiayaan = $("#produk_pembiayaan").val();

        var product = $("#produk_pembiayaan").val();
        var product_code_smile = $("#product_code_smile").val();
        if(product == '52'){
          var produk_pembiayaan = product_code_smile;
        }else{
          var produk_pembiayaan = product;
        }

        var pengajuan_melalui = $("#pengajuan_melalui").val();
        var peruntukan = $("#peruntukan").val();
        window.open('<?php echo site_url();?>laporan_to_excel/export_lap_list_outstanding_pembiayaan_individu/'+akad+'/'+produk_pembiayaan+'/'+pengajuan_melalui+'/'+peruntukan);
      });

      //export XLS
      $("#previewpdf").click(function(e)
      {
        e.preventDefault();
        var akad = $("#akad").val();
        // var produk_pembiayaan = $("#produk_pembiayaan").val();

        var product = $("#produk_pembiayaan").val();
        var product_code_smile = $("#product_code_smile").val();
        if(product == '52'){
          var produk_pembiayaan = product_code_smile;
        }else{
          var produk_pembiayaan = product;
        }

        var pengajuan_melalui = $("#pengajuan_melalui").val();
        var peruntukan = $("#peruntukan").val();
        window.open('<?php echo site_url();?>laporan_to_pdf/export_lap_list_outstanding_pembiayaan_individu/'+akad+'/'+produk_pembiayaan+'/'+pengajuan_melalui+'/'+peruntukan);
      });

      $("#field_rembug").hide();
      $("#produk").change(function(){
        produk = $(this).val();
        if(produk=='1'){
          $("#field_rembug").hide();
        }else if(produk=='0'){
          $("#field_rembug").show();
        }else{
          $("#field_rembug").hide();
        }
      })

      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
   
});
</script>
<!-- END JAVASCRIPTS -->
