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
      Pembiayaan <small>Approval Pengajuan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Approval Pengajuan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Approval Pengajuan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th> -->
               <th width="13%">No. Pengajuan</th>
               <th width="18%">Nama Lengkap</th>
               <th width="15%">Tgl Pengajuan</th>
               <th width="17%">Rencana Droping</th>
               <th width="12%">Amount</th>
               <th width="15%">Peruntukan</th>
               <th width="5%">Skor</th>
               <th>&nbsp;</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog_history" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:150px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>History Outstanding Pembiayaan</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <table>
               <tr>
                 <td width="150">No. Pembiayaan</td>
                 <td><div id="history_no_pembiayaan"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Pokok</td>
                 <td><div id="history_sisa_pokok"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Margin</td>
                 <td><div id="history_sisa_margin"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Catab</td>
                 <td><div id="history_sisa_catab"></div></td>
               </tr>
            </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>



<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
          <input type="hidden" id="registration_no" name="registration_no">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit PEngajuan PEmbiayaan Berhasil!
            </div>
          </br>      

                    <div class="control-group">
                       <label class="control-label">Petugas<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="petugas2" id="petugas2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Resort<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="resort_code2" id="resort_code2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code" name="branch_code">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <br><small>(Sesuai KTP)</small><span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>   
                    <hr>            
                     <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="pyd2" id="pyd2" maxlength="3" disabled="disabled">
                        </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                           <select id="product_code2" name="product_code2" class="m-wrap">
                             <option value="">PILIH</option>
                              <?php foreach($product as $produk){ ?>
                             <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka2" id="uang_muka2" maxlength="12" disabled="disabled">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount2" id="amount2" maxlength="12" disabled="disabled">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>                            
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan2" id="peruntukan2" class="medium m-wrap" data-required="1">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium" disabled="disabled"></textarea>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan2" readonly="" class="small m-wrap" disabled="disabled"/>
                       </div>
                    </div> 
                    <div class="control-group hide">
                       <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_droping2" readonly="" class="small m-wrap" disabled="disabled"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <div class="controls">
                          <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
                       </div>
                    </div> 
                    <div class="control-group">
                       <div class="controls">
                          <a id="btn-view-scoring" class="btn purple" data-toggle="modal" href="#dialog_viewscoring">Lihat Scoring</a>
                       </div>
                    </div>             
            <div class="form-actions">
               <button type="button" id="act_approve" class="btn purple">Approve</button>
               <button type="button" id="act_reject" class="btn red">Reject</button>
               <button type="button" id="act_cancel" class="btn blue">Cancel</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT  -->


<div id="dialog_viewscoring" class="modal hide fade" style="position:fixed;top:15%">
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Score</h3>
 </div>
 <div class="modal-body">
    <div class="row-fluid">
       <div class="span12">
          <div style="font-weight:600;font-size:14px;margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:5px">Hasil Scoring</div>
          <table width="100%" style="border-collapse:inherit;border:solid 1px #CCC;background:#CCC;border-spacing:1px;" cellpadding="0" class="table-scoring">
            <tr>
              <td width="170">
                <div align="center" style="font-size:12px;font-weight:bold;">Total Score Sebesar</div>
                <div align="center" style="color:red;font-weight:bold;font-size:15px;margin-bottom: 10px;margin-top: 3px;" id="txt_total_skor">0</div>
                <div id="ket_score" align="center" style="background: rgb(73, 128, 226);margin: 0 7px;color:white;border: solid 1px #1A4797;border-radius: 5px !important;line-height: 16px;padding: 4px;">NULL</div>
              </td>
              <td>
                <table width="100%">
                  <tr>
                    <td align="center" style="border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;font-weight:bold;">Skoring<br>Terbobot</td>
                    <td align="center" style="border-bottom:solid 1px #CCC;font-weight:bold;">Rekomendasi</td>
                  </tr>
                  <tr>
                    <td align="center" style="border-right:solid 1px #CCC;padding:5px;">
                      > 450 <br>
                      351 s/d 450 <br>
                      301 s/d 350 <br>
                      201 s/d 300 <br>
                      < 200
                    </td>
                    <td style="padding:5px;">
                      Sangat Layak Diberikan Kredit <br>
                      Layak diberikan kredit <br>
                      Dapat diberikan kredit <br>
                      Dapat diberikan dengan tambahan jaminan fsik <br>
                      Tidak dapat diberikan <br>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
       </div>
    </div>
 </div>
 <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
 </div>
</div>


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

$("#btn-view-scoring").click(function(){

  $.ajax({
    type:"POST",
    dataType:"json",
    url:site_url+"transaction/get_scoring_pembiayaan",
    data:{registration_no:$("#registration_no").val()},
    success:function(response){

      global_score_total=response.total_score;
      ket_score='NULL';
      if(global_score_total>450){
        ket_score='Sangat Layak Diberikan Kredit';
      }else if(global_score_total>=351 && global_score_total<=450){
        ket_score='Layak Diberikan Kredit';
      }else if(global_score_total>=301 && global_score_total<=350){
        ket_score='Dapat Diberikan Kredit';
      }else if(global_score_total>=201 && global_score_total<=300){
        ket_score='Dapat diberikan dengan tambahan jaminan fsik';
      }else if(global_score_total<=200){
        ket_score='Tidak dapat diberikan';
      }
      $("#ket_score","#dialog_viewscoring").text(ket_score);
      $("#txt_total_skor","#dialog_viewscoring").text(global_score_total);
    }
  })

})

/*BEGIN CALCULATE SCORING*/
global_score_administrasi=0;
global_score_karakter=0;
global_score_usaha=0;
global_score_aset=0;
global_score_total=0;

var bobot_administrasi=5;
var bobot_scoringpnglmnusaha=10;
var bobot_scoringpemkewman=10;
var bobot_scoringpendidikan=10;
var bobot_scoringtempatusaha=10;
var bobot_scoringlokasiusaha=10;
var bobot_scoringkegiatanusaha=10;
var bobot_scoringhubunganusaha=10;
var bobot_scoringlamaberusaha=10;
var bobot_scoringhartatetap=10;
var bobot_scoringhartalancar=5;

$("input#scoringadmkeldoc","#tab_1").click(function(e){
  var jumlah_dokumen=$("input#scoringadmkeldoc:checked","#tab_1").length;
  if(jumlah_dokumen>=10){
    global_score_administrasi=5;
  }else if(jumlah_dokumen==8 || jumlah_dokumen==9){
    global_score_administrasi=4;
  }else if(jumlah_dokumen==6 || jumlah_dokumen==7){
    global_score_administrasi=3;
  }else if(jumlah_dokumen==4 || jumlah_dokumen==5){
    global_score_administrasi=2;
  }else{
    global_score_administrasi=1;
  }
  global_score_administrasi=global_score_administrasi*bobot_administrasi;
  $("#skor_administrasi","#tab_1").text(global_score_administrasi);
  calc_score_total();
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})

$("input#scoringpendidikan,input#scoringpemkewman,input#scoringpnglmnusaha","#tab_2").click(function(){
  calc_score_karakter();
  calc_score_total();
  $("#skor_karakter","#tab_2").text(global_score_karakter);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})
$("select#scoringtempatusaha,select#scoringlokasiusaha,select#scoringkegiatanusaha,select#scoringhubunganusaha,select#scoringlamaberusaha","#tab_3").change(function(){
  calc_score_usaha();
  calc_score_total();
  $("#skor_usaha","#tab_3").text(global_score_usaha);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})
$("select#scoringhartatetap,select#scoringhartalancar","#tab_4").change(function(){
  calc_score_aset();
  calc_score_total();
  $("#skor_aset","#tab_4").text(global_score_aset);
  $("#txt_total_skor","#tab_5").text(global_score_total);
  $("#total_skor","#tab_5").val(global_score_total);
})

function calc_score_karakter()
{
  var scoringpnglmnusaha=(isNaN(parseFloat($("input#scoringpnglmnusaha:checked").val()))==true)?0:parseFloat($("input#scoringpnglmnusaha:checked").val());
  scoringpnglmnusaha=scoringpnglmnusaha*bobot_scoringpnglmnusaha;
  var scoringpemkewman=(isNaN(parseFloat($("input#scoringpemkewman:checked").val()))==true)?0:parseFloat($("input#scoringpemkewman:checked").val());
  scoringpemkewman=scoringpemkewman*bobot_scoringpemkewman;
  var scoringpendidikan=(isNaN(parseFloat($("input#scoringpendidikan:checked").val()))==true)?0:parseFloat($("input#scoringpendidikan:checked").val());
  scoringpendidikan=scoringpendidikan*bobot_scoringpendidikan;
  global_score_karakter=scoringpendidikan+scoringpemkewman+scoringpnglmnusaha;
}
function calc_score_usaha()
{
  var scoringtempatusaha=parseFloat(($("select#scoringtempatusaha").val()=="")?0:$("select#scoringtempatusaha").val());
  scoringtempatusaha=scoringtempatusaha*bobot_scoringtempatusaha;
  var scoringlokasiusaha=parseFloat(($("select#scoringlokasiusaha").val()=="")?0:$("select#scoringlokasiusaha").val());
  scoringlokasiusaha=scoringlokasiusaha*bobot_scoringlokasiusaha;
  var scoringkegiatanusaha=parseFloat(($("select#scoringkegiatanusaha").val()=="")?0:$("select#scoringkegiatanusaha").val());
  scoringkegiatanusaha=scoringkegiatanusaha*bobot_scoringkegiatanusaha;
  var scoringhubunganusaha=parseFloat(($("select#scoringhubunganusaha").val()=="")?0:$("select#scoringhubunganusaha").val());
  scoringhubunganusaha=scoringhubunganusaha*bobot_scoringhubunganusaha;
  var scoringlamaberusaha=parseFloat(($("select#scoringlamaberusaha").val()=="")?0:$("select#scoringlamaberusaha").val());
  scoringlamaberusaha=scoringlamaberusaha*bobot_scoringlamaberusaha;
  global_score_usaha=scoringtempatusaha+scoringlokasiusaha+scoringkegiatanusaha+scoringhubunganusaha+scoringlamaberusaha;
}
function calc_score_aset()
{
  var scoringhartatetap=parseFloat(($("select#scoringhartatetap").val()=="")?0:$("select#scoringhartatetap").val());
  scoringhartatetap=scoringhartatetap*bobot_scoringhartatetap;
  var scoringhartalancar=parseFloat(($("select#scoringhartalancar").val()=="")?0:$("select#scoringhartalancar").val());
  scoringhartalancar=scoringhartalancar*bobot_scoringhartalancar;
  global_score_aset=scoringhartatetap+scoringhartalancar
}
function calc_score_total()
{
  global_score_total=global_score_administrasi+global_score_karakter+global_score_usaha+global_score_aset;
  ket_score='NULL';
  if(global_score_total>450){
    ket_score='Sangat Layak Diberikan Kredit';
  }else if(global_score_total>=351 && global_score_total<=450){
    ket_score='Layak Diberikan Kredit';
  }else if(global_score_total>=301 && global_score_total<=350){
    ket_score='Dapat Diberikan Kredit';
  }else if(global_score_total>=201 && global_score_total<=300){
    ket_score='Dapat diberikan dengan tambahan jaminan fsik';
  }else if(global_score_total<=200){
    ket_score='Tidak dapat diberikan';
  }
  $("#ket_score","#tab_5").text(ket_score);
}


/*END CALCULATE SCORING*/

/*BEGIN TAB SCORING*/
$("#next_1").live('click',function(){
  $("#ttab_2").click();
  $(this).hide();
  $("#next_2").show();
  App.scrollTo(0,0);
})
$("#next_2").live('click',function(){
  $("#ttab_3").click();
  $(this).hide();
  $("#next_3").show();
  App.scrollTo(0,0);
})
$("#next_3").live('click',function(){
  $("#ttab_4").click();
  $(this).hide();
  $("#next_4").show();
  App.scrollTo(0,0);
})
$("#next_4").live('click',function(){
  $("#ttab_5").click();
  $(this).hide();
  $("#proses").show();
  App.scrollTo(0,0);
})
$("#ttab_1").click(function(){
  $("#next_1").show();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_2").click(function(){
  $("#next_1").hide();
  $("#next_2").show();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_3").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").show();
  $("#next_4").hide();
  $("#proses").hide();
})
$("#ttab_4").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").show();
  $("#proses").hide();
})
$("#ttab_5").click(function(){
  $("#next_1").hide();
  $("#next_2").hide();
  $("#next_3").hide();
  $("#next_4").hide();
  $("#proses").show();
})
/*END TAB SCORING*/

function reset_form_scoring()
{
  $("input#scoringadmkeldoc","#dialog_scoring").attr('checked',false); $("input#scoringadmkeldoc","#dialog_scoring").parent().removeAttr('class');
  $("input[type='radio']:checked","#dialog_scoring").attr('checked',false);
  $("select","#dialog_scoring").val('');
  $("#txt_total_skor").text('0'); $("#total_skor").val(0); $("#ket_score").text('NULL');

  global_score_administrasi=0;
  global_score_karakter=0;
  global_score_usaha=0;
  global_score_aset=0;
  global_score_total=0;
}

/*BEGIN PROSES SCORING*/

$("#proses","#dialog_scoring").click(function(e){
  $.ajax({
    type: "POST",
    url: site_url+'rekening_nasabah/proses_scoring_pembiayaan',
    dataType: "json",
    data: $("form#form_scoring").serialize(),
    success: function(response){
      if(response.success==true){
        alert('Scoring have been processed');
        reset_form_scoring();
        dTreload();
        $("#close","#dialog_scoring").trigger('click');
        App.scrollTo(form1, -200);
      }else{
        alert("Failed to Connect into Database, Please Contact Your Administrator!");
      }
    },
    error:function(){
      alert("Failed to Connect into Database, Please Contact Your Administrator!");
      App.scrollTo(form1, -200);
    }
  });
})

/*END PROSES SCORING*/


$("a#btnSkor").live('click',function(){
  registration_no=$(this).attr('registration_no');
  $("#browse_scoring").trigger('click');
  $("#registration_no","#dialog_scoring").val(registration_no);
})
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'pengajuan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  

      // fungsi untuk check all
      jQuery('#pengajuan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pengajuan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){        
        form2.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
        var registration_no = $(this).attr('registration_no');
        var flag_scoring = $(this).attr('flag_scoring');
        if(flag_scoring==0){
          $("#btn-view-scoring").closest('.control-group').hide();
        }else{
          $("#btn-view-scoring").closest('.control-group').show();
        }
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id},
          url: site_url+"rekening_nasabah/get_pengajuan_pembiayaan_by_account_financing_reg_id",
          success: function(response)
          {
            $("#form_edit input[name='registration_no']").val(response.registration_no);
            $("#form_edit input[name='account_financing_reg_id']").val(account_financing_reg_id);
              $.ajax({
                type: "POST",
                dataType: "json",
                async:false,
                data: {cif_no:response.cif_no},
                url: site_url+"transaction/get_ajax_value_from_cif_no",
                success: function(response)
                {
                  $("#nama2").val(response.nama);
                  $("#panggilan2").val(response.panggilan);
                  $("#ibu_kandung2").val(response.ibu_kandung);
                }                 
              });
            $("#form_edit input[name='petugas2']").val(response.fa_name);
            $("#form_edit input[name='resort_code2']").val(response.resort_name);
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit input[name='pyd2']").val(response.pembiayaan_ke);
            $("#form_edit input[name='pyd2']").attr("readonly",true);
            $("#form_edit select[name='product_code2']").val(response.product_code);
            $("#form_edit input[name='uang_muka2']").val(response.uang_muka);
            $("#form_edit input[name='uang_muka2']").attr("readonly",true);
            $("#form_edit input[name='amount2']").val(number_format(response.amount,0,',','.'));
            $("#form_edit input[name='amount2']").attr("readonly",true);
            $("#form_edit select[name='peruntukan2']").val(response.peruntukan);
            $("#form_edit textarea[name='keterangan2']").val(response.description);            
            $("#form_edit textarea[name='keterangan2']").attr("readonly",true);
            // tgl_droping = response.rencana_droping.substring(8,12)+'/'+response.rencana_droping.substring(5,7)+'/'+response.rencana_droping.substring(0,4);
            // $("#form_edit input[name='rencana_droping2']").val(tgl_droping);
            // $("#form_edit select[name='rencana_droping2']").attr("readonly",true);
            
            tgl_pengajuan = response.tanggal_pengajuan.substring(8,12)+'/'+response.tanggal_pengajuan.substring(5,7)+'/'+response.tanggal_pengajuan.substring(0,4);
            $("#form_edit input[name='tanggal_pengajuan2']").val(tgl_pengajuan);
            $("#form_edit select[name='tanggal_pengajuan2']").attr("readonly",true);


            $("#form_edit select[name='peruntukan2']").attr("readonly",true);
            $("#form_edit select[name='product_code2']").attr("readonly",true);
            document.getElementById('peruntukan2').disabled = true;
            document.getElementById('product_code2').disabled = true;
          }
        });

      });
        


      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
        App.scrollTo($("#wrapper-table"),-200);
      });

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_financing_reg_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_reg_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_reg_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/delete_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });

      // fungsi untuk BATAL PENGAJUAN
      $("a#link_setuju").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var registration_no = $(this).attr('registration_no');
          var conf = confirm('Setujui Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/setuju_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id,registration_no:registration_no},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil disetujui!");
                  dTreload();
                }else{
                  alert("Gagal disetujui!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });

      // fungsi untuk BATAL PENGAJUAN
      $("a#link_batal").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var registration_no = $(this).attr('registration_no');
          var conf = confirm('Batalkan Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/batal_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id,registration_no:registration_no},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Dibatalkan!");
                  dTreload();
                }else{
                  alert("Gagal Dibatalkan!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });

      // fungsi untuk TOLAK PENGAJUAN
      $("#act_reject").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id").val();
          var conf = confirm('Tolak Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_tolak_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Ditolak!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Ditolak!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });
      $("#act_cancel").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id").val();
          var conf = confirm('Batalkan Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_batal_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Dibatalkan!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Dibatalkan!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });
      $("#act_approve").live('click',function()
      {
          var account_financing_reg_id = $("#account_financing_reg_id").val();
          var conf = confirm('Aktivasi Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/act_approve_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Diaktivasi!");
                  $("#edit").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($("#wrapper-table"),-200);
                }else{
                  alert("Gagal Diaktivasi!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }    
      });


      // begin first table
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pengajuan_pembiayaan_verifikasi",
          "aoColumns": [			      
            // { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
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


      // fungsi untuk mencari CIF_NO
      $(function(){

          
          //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
          $("a#browse_history",form_edit).live('click',function(){
            var cif_no = $("#cif_no2").val();
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/history_outstanding_pembiayaan",
                dataType: "json",
                data: {cif_no:cif_no},
                success: function(response){
                  if(response.account_financing_no==undefined){
                    account_financing_no = "Data Terakhir Tidak Ditemukan";
                  }else{
                    account_financing_no = response.account_financing_no;
                  }

                  if(response.saldo_pokok==null){
                    saldo_pokok = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_pokok = response.saldo_pokok;
                  }

                  if(response.saldo_margin==null){
                    saldo_margin = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_margin = response.saldo_margin;
                  }

                  if(response.saldo_catab==null){
                    saldo_catab = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_catab = response.saldo_catab;
                  }
                  $("#history_no_pembiayaan").html(": "+account_financing_no);
                  $("#history_sisa_pokok").html(": Rp. "+number_format(saldo_pokok,0,',','.'));
                  $("#history_sisa_margin").html(": Rp. "+number_format(saldo_margin,0,',','.'));
                  $("#history_sisa_catab").html(": Rp. "+number_format(saldo_catab,0,',','.'));
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });


      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

