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
        Proses Jurnal Otomatis <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->
<?php
if($this->session->flashdata('status')=='1')
{
?>
<div class="alert alert-success">
  <?php echo $this->session->flashdata('message'); ?>
</div>
<?php
}
else if($this->session->flashdata('status')=='2')
{
?>
<div class="alert alert-error">
  <?php echo $this->session->flashdata('message'); ?>
</div>
<?php
}
?>
<form id="process_transaksi_jurnal" method="post" class="form-horizontal" action="<?php echo site_url('transaction/proses_jurnal_otomatis'); ?>">
  <table cellspacing="5" cellpadding="5">
    <tr>
      <td>From Date</td>
      <td>:</td>
      <td>
        <input type="text" name="from_date" id="from_date" class="date-picker mask_date m-wrap small">
      </td>
    </tr>
    <tr>
      <td>Thru Date</td>
      <td>:</td>
      <td>
        <input type="text" name="thru_date" id="thru_date" class="date-picker mask_date m-wrap small">
      </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>
        <input type="submit" name="submit" id="submit" value="Proses" class="btn red">
      </td>
    </tr>
  </table>
</form>


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<!-- END PAGE LEVEL SCRIPTS -->  

<script type="text/javascript">
jQuery(document).ready(function() {    
  /**
  * INITIALIZATION
  */
  App.init(); // initlayout and core plugins
  $(".mask_date").livequery(function(){
    $(this).inputmask("d/m/y");  //direct mask
  });

  /**
  * RUNNING EVENT
  */

  $("#submit").click(function(e){
    from_date = $("#from_date").val();
    thru_date = $("#thru_date").val();
    bvalid = true;
    if(from_date==""){
      bvalid = false;
    }
    if(thru_date==""){
      bvalid = false;
    }

    if(bvalid){
      $("#process_transaksi_jurnal").trigger('submit');
    }else{
      alert("From Date atau Thru Date tidak boleh kosong!");
      return false;
    }

  })


});
</script>