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
        REKAP TRANSAKSI <small></small>
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
   <form class="form-horizontal">
      <input type="hidden" name="branch" id="branch">
      <input type="hidden" name="branch_code" id="branch_code">
      <input type="hidden" name="branch_id" id="branch_id">
      <table id="filter-form">
         <tr>
            <td width="100">Cabang</td>
            <td>
               <input type="text" name="branch" class="m-wrap mfi-textfield"> 
               <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
            </td>
         </tr>
         <tr>
            <td>Tanggal</td>
            <td valign="middle">
               <input type="text" class="mfi-textfield mask_date m-wrap" id="from_date" name="from_date" style="width:100px"> 
               <span style="line-height:45px;">&nbsp;s/d &nbsp;</span>
               <input type="text" class="mfi-textfield mask_date m-wrap" id="thru_date" name="thru_date" style="width:100px">
            </td>
         </tr>
         <tr>
            <td></td>
            <td>
               <button class="green btn" id="filter">Filter</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
   <hr size="1">
   <table width="100%" border="1" bordercolor="#CCC" cellpadding="5" id="general_ledger">
      <thead>
         <tr>
            <th style="background:#EEE;" width="5%">No.</th>
            <th style="background:#EEE;">Account</th>
            <th style="background:#EEE;" width="15%">Saldo Awal</th>
            <th style="background:#EEE;" width="15%">Debet</th>
            <th style="background:#EEE;" width="15%">Credit</th>
            <th style="background:#EEE;" width="15%">Saldo Akhir</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td colspan="6" align="center" style="padding:10px 5px;">
              Please Fill The Filter Option to Show Form
            </td>
         </tr>
      </tbody>
      <tfoot>
         <tr>
            <td></td>
            <td></td>
            <td align="right">Total</td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_debit"></span></td>
            <td align="right" style="font-size:14px; background:#F5F5F5;"><span id="total_credit"></span></td>
            <td></td>
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

   /* END DIALOG ACTION BRANCH */

   $("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_gl_rekap_transaksi",
         data: {
            branch_code : $("#branch_code").val(),
            from_date : $("#from_date").val(),
            thru_date : $("#thru_date").val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td>'+response['data'][i].account+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_awal,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].debit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].credit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_akhir,2,',','.')+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });

/* END SCRIPT */
})
</script>