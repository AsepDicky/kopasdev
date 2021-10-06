
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
        Laporan <small>Data Lengkap Pembiayaan</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Data Lengkap Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
            <!-- BEGIN FILTER-->
              <table id="sorting_saldo">
                 <tr>
                    <td style="padding-bottom:10px;" width="100">No. Rekening</td>
                    <td>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                          <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
                          <!-- <input type="hidden" id="account_type" name="account_type"> -->
                          <!-- <input type="hidden" id="jenis_tabungan" name="jenis_tabungan"> -->
                          
                          <div id="dialog_search_pembiayaan" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari Pembiayaan</h3>
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_search_pembiayaan">...</a>
                       </div>
                    </td>
                 </tr>
                <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="previewpdf">Preview PDF</button>&nbsp;
                     <button class="green btn" id="previewxls">Preview Excel</button>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            <p><hr></p>
          <!-- END FILTER-->
      </div>
   </div>
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

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

// fungsi untuk mencari CIF_NO
$(function(){

    $("#select").click(function(){
      result = $("#result").val();
      var account_financing_no = $("#result").val();
      $("#close","#dialog_search_pembiayaan").trigger('click');
      $("#account_financing_no").val(account_financing_no);
    });

    $("#result option").live('dblclick',function(){
       $("#select").trigger('click');
    });

    $("#button-dialog").click(function(){
      $("#dialog").dialog('open');
    });

    $("#keyword").on('keypress',function(e){
      if(e.which==13){
        $.ajax({
          type: "POST",
          url: site_url+"search/account_financing_no",
          data: {keyword:$(this).val(),status_rekening:1},
          dataType: "json",
          async: false,
          success: function(response){
            var option = '';
            for(i = 0 ; i < response.length ; i++){
            	option += '<option value="'+response[i].account_financing_no+'">'+response[i].account_financing_no+' - '+response[i].nama+'</option>';
            }
            // console.log(option);
            $("#result").html(option);
          }
        });
        return false;
      }
      
    });

	//export PDF
	$("#previewpdf").click(function(e){

		e.preventDefault();
		var account_financing_no = $("#account_financing_no").val();
		if(account_financing_no==""){
			alert("No.Rekening belum dipilih !");
		}else{
			window.open('<?php echo site_url();?>laporan_to_pdf/data_lengkap_pembiayaan/'+account_financing_no);
		}

	});

	//export XLS
	$("#previewxls").click(function(e){

		e.preventDefault();
		var account_financing_no = $("#account_financing_no").val();
		if(account_financing_no==""){
			alert("No.Rekening belum dipilih !");
		}else{
			window.open('<?php echo site_url();?>laporan_to_excel/data_lengkap_pembiayaan/'+account_financing_no);
		}

	});

});

</script>
<!-- END JAVASCRIPTS -->

