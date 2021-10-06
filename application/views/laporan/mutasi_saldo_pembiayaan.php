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
        MUTASI SALDO PEMBIAYAAN <small></small>
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

<!-- BEGIN FORM-->
<div class="portlet-body form">
   <!-- BEGIN FILTER FORM -->
   <form>
      <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
      <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
      <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
      <table id="filter-form">
         <tr>
            <td style="padding-bottom:10px;" width="100">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap mfi-textfield" readonly style="background:#EEE" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
               <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
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
            <td style="padding-bottom:10px;">Periode</td>
            <td>
               <select id="periode_bulan" name="periode_bulan" class="m-wrap" style="width:110px">
                <option value="">Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
               </select>
               <select id="periode_tahun" name="periode_tahun" class="m-wrap" style="width:80px;">
                <option value="">Tahun</option>
                <?php
                for ( $i = date('Y')-5 ; $i <= date('Y') ; $i++ )
                {
                ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
                }
                ?>
               </select>
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="filter">Filter</button>
               <button class="green btn" id="previewpdf">Preview</button>
               <button class="green btn hidden" id="previewxls">Preview Excel</button>
               <button class="green btn" id="previewcsv">Preview CSV</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
   <table width="100%" border="1" bordercolor="#CCC" cellpadding="5" id="general_ledger">
      <thead>
         <tr>
            <th width="10%" rowspan="2" style="background:#EEE; font-size:11px;">No. Rek.</th>
            <th width="7%" rowspan="2" style="background:#EEE; font-size:11px;">Nama</th>
            <th width="9%" rowspan="2" style="background:#EEE; font-size:11px;">Produk</th>
            <th width="17%" rowspan="2" style="background:#EEE; font-size:11px;">Tanggal Droping</th>
            <th width="8%" rowspan="2" style="background:#EEE; font-size:11px;">Plafon</th>
            <th colspan="2" style="background:#EEE; font-size:11px;">Saldo Awal</th>
            <th colspan="2" style="background:#EEE; font-size:11px;">Angsuran</th>
            <th colspan="2" style="background:#EEE; font-size:11px;">Saldo Akhir</th>
         </tr>
         <tr>
           <th width="5%" style="background:#EEE; font-size:11px;">Pokok</th>
           <th width="5%" style="background:#EEE; font-size:11px;">Margin</th>
           <th width="5%" style="background:#EEE; font-size:11px;">Pokok</th>
           <th width="5%" style="background:#EEE; font-size:11px;">Margin</th>
           <th width="5%" style="background:#EEE; font-size:11px;">Pokok</th>
           <th width="5%" style="background:#EEE; font-size:11px;">Margin</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td colspan="11" align="center" style="padding:10px 5px;">
              Please Fill The Filter Option to Show Form
            </td>
         </tr>
      </tbody>
      <tfoot>
         <tr>
            <td style="background:#EEE; font-size:11px;" colspan="5" align="center">Total</td>
            <td style="background:#EEE; font-size:11px;"><span id="total_awal_saldo"></span></td>
            <td style="background:#EEE; font-size:11px;"><span id="total_awal_margin"></span></td>
            <td style="background:#EEE; font-size:11px;"><span id="total_angsuran_pokok"></span></td>
            <td style="background:#EEE; font-size:11px;"><span id="total_angsuran_margin"></span></td>
            <td style="background:#EEE; font-size:11px;"><span id="total_akhir_pokok"></span></td>
            <td style="background:#EEE; font-size:11px;"><span id="total_akhir_margin"></span></td>
         </tr>
      </tfoot>
   </table>
</div>

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
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
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
         $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('reloadGrid');
   });

   /* END DIALOG ACTION BRANCH */

   $("#filter").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode_bulan = $("#periode_bulan").val();
      var periode_tahun = $("#periode_tahun").val();
	     // var product = $("#product").val();
      
      var produk_pembiayaan = $("#produk_pembiayaan").val();
      var product_code_smile = $("#product_code_smile").val();
      if(produk_pembiayaan == '52'){
        var product = product_code_smile;
      }else{
        var product = produk_pembiayaan;
      }

      if(periode_bulan==""){
        alert("Silahkan pilih Periode Bulan!")
      }else if(periode_tahun==""){
        alert("Silahkan pilih Periode Tahun!")
      }else if(product==""){
        alert("Silahkan pilih Produk!")
      }else{
		  $.ajax({
			 type: "POST",
			 dataType: "json",
			 url: site_url+"laporan/get_mutasi_saldo",
			 data: {
				branch_code : $("#branch_code").val(),
				periode_bulan : $("#periode_bulan").val(),
				periode_tahun : $("#periode_tahun").val(),
				product: $("#product").val()
			 },
			 success: function(response){
				html = '';
        if (response['data'].length>0) {
  				for(i = 0 ; i < response['data'].length ; i++)
  				{
  				   html += '<tr> \
  					  <td align="center" style="font-size:10px;">'+response['data'][i].account_financing_no+'</td> \
  					  <td align="center" style="font-size:10px;">'+response['data'][i].nama+'</td> \
  					  <td align="center" style="font-size:10px;">'+response['data'][i].product_name+'</td> \
  					  <td align="center" style="font-size:10px;">'+response['data'][i].tanggal_akad+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].pokok=='')?'':number_format(response['data'][i].pokok,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].saldo_pokok=='')?'':number_format(response['data'][i].saldo_pokok,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].saldo_margin=='')?'':number_format(response['data'][i].saldo_margin,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].angsuran_pokok=='')?'':number_format(response['data'][i].angsuran_pokok,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].angsuran_margin=='')?'':number_format(response['data'][i].angsuran_margin,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].akhir_pokok=='')?'':number_format(response['data'][i].akhir_pokok,2,',','.'))+'</td> \
  					  <td align="right" style="font-size:10px;">'+((response['data'][i].akhir_margin=='')?'':number_format(response['data'][i].akhir_margin,2,',','.'))+'</td> \
  				   </tr>';
  				}
        } else {
          html += '<tr> \
            <td align="center" colspan="11" style="padding:10px 5px;">--Empty--</td> \
          </tr>';
          App.WarningAlert('Data Outstanding pada bulan ini Tidak ada.');
        }
				$("#total_awal_saldo").html(number_format(response['total_awal_pokok'],2,',','.'));
				$("#total_awal_margin").html(number_format(response['total_awal_margin'],2,',','.'));
				$("#total_angsuran_pokok").html(number_format(response['total_angsuran_pokok'],2,',','.'));
				$("#total_angsuran_margin").html(number_format(response['total_angsuran_margin'],2,',','.'));
				$("#total_akhir_pokok").html(number_format(response['total_akhir_pokok'],2,',','.'));
				$("#total_akhir_margin").html(number_format(response['total_akhir_margin'],2,',','.'));
				$("tbody","table#general_ledger ").html(html);
			 }
		  });
	  }
   });
   $("#previewpdf").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode_bulan = $("#periode_bulan").val();
      var periode_tahun = $("#periode_tahun").val();
	    // var product = $("#product").val();
      
      var produk_pembiayaan = $("#produk_pembiayaan").val();
      var product_code_smile = $("#product_code_smile").val();
      if(produk_pembiayaan == '52'){
        var product = product_code_smile;
      }else{
        var product = produk_pembiayaan;
      }

      if(periode_bulan==""){
        alert("Silahkan pilih Periode Bulan!")
      }else if(periode_tahun==""){
        alert("Silahkan pilih Periode Tahun!")
      }else if(product==""){
        alert("Silahkan pilih Produk!")
      }else{
        window.open(site_url+"laporan_to_pdf/get_mutasi_saldo/"+branch_code+"/"+periode_bulan+"/"+periode_tahun+"/"+product);
      }
   });
   $("#previewxls").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode_bulan = $("#periode_bulan").val();
      var periode_tahun = $("#periode_tahun").val();
	    // var product = $("#product").val();
      
      var produk_pembiayaan = $("#produk_pembiayaan").val();
      var product_code_smile = $("#product_code_smile").val();
      if(produk_pembiayaan == '52'){
        var product = product_code_smile;
      }else{
        var product = produk_pembiayaan;
      }

      if(periode_bulan==""){
        alert("Silahkan pilih Periode Bulan!")
      }else if(periode_tahun==""){
        alert("Silahkan pilih Periode Tahun!")
      }else if(product==""){
        alert("Silahkan pilih Produk!")
      }else{
        window.open(site_url+"laporan_to_excel/get_mutasi_saldo/"+branch_code+"/"+periode_bulan+"/"+periode_tahun);
      }
   });

   $("#previewcsv").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var periode_bulan = $("#periode_bulan").val();
      var periode_tahun = $("#periode_tahun").val();
	    // var product = $("#product").val();
      
      var produk_pembiayaan = $("#produk_pembiayaan").val();
      var product_code_smile = $("#product_code_smile").val();
      if(produk_pembiayaan == '52'){
        var product = product_code_smile;
      }else{
        var product = produk_pembiayaan;
      }

      if(periode_bulan==""){
        alert("Silahkan pilih Periode Bulan!")
      }else if(periode_tahun==""){
        alert("Silahkan pilih Periode Tahun!")
      }else if(product==""){
        alert("Silahkan pilih Produk!")
      }else{
        window.open(site_url+"laporan_to_csv/get_mutasi_saldo/"+branch_code+"/"+periode_bulan+"/"+periode_tahun+"/"+product);
      }
   });

/* END SCRIPT */
})
</script>