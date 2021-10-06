<style type="text/css">
   .readonly{background-color:#eee}
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
      Pembiayaan <small>Approval Pengajuan Pembiayaan Komersial</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Approval Pengajuan Pembiayaan Komersial</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<style type="text/css">
  .radio input[type="radio"], .checkbox input[type="checkbox"] {
    float: left;
    margin-left: 0 !important;
}
</style>

<div id="dialog_upload" class="modal hide fade" tabindex="-1" data-width="800" style="margin-top:-250px;" data-keyboard="false" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3><i class="icon-upload"></i> Dokumen</h3>
  </div>
  <div class="modal-body">
    <form action="#" id="form_upload" class="form-horizontal">
      <div class="control-group">
         <label class="control-label">Proposal Pembiayaan <span class="required">*</span></label>
         <div class="controls">
            <div id="download1" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">SPK/Kontrak <span class="required">*</span></label>
         <div class="controls">
            <div id="download2" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Neraca dan Laba/Rigo <span class="required">*</span></label>
         <div class="controls">
            <div id="download3" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Rekening Koran <span class="required">*</span></label>
         <div class="controls">
            <div id="download4" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Analisa Kelayakan Investasi <span class="required">*</span></label>
         <div class="controls">
            <div id="download5" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Proyeksi Cash Flow <span class="required">*</span></label>
         <div class="controls">
            <div id="download6" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label">Jaminan <span class="required">*</span></label>
         <div class="controls">
            <div id="download7" style="padding-top:7px;">
              <span style="font-size:11px;"></span>
              <div></div>
            </div>
         </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" id="close" class="btn" data-dismiss="modal">Close</button>
  </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box red" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Approval Pengajuan Pembiayaan Komersial</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th>
               <th>No. Pengajuan</th>
               <th>Nama Kopegtel</th>
               <th>Tgl Pengajuan</th>
               <th>Tgl Dibuat</th>
               <th>Jumlah</th>
               <th>Status Dok.</th>
               <th width="10%">&nbsp;</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box red">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Approval Pengajuan Pembiayaan Komersial</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <input type="hidden" id="kopegtel_name" name="kopegtel_name">
            <input type="hidden" id="jenis_keuntungan" name="jenis_keuntungan">
            <div class="alert alert-error hide">
               <!-- <button class="close" data-dismiss="alert"></button> -->
               <span id="span_message">
                 You have some form error, please check below!
               </span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Account Financing has been Updated !
            </div>
            <div class="control-group">
               <label class="control-label">Kopegtel<span class="required">*</span></label>
               <div class="controls">
                <select id="kopegtel2" name="kopegtel" class="large m-wrap" disabled="disabled" style="background-color:#f5f5f5;">
                  <option value="">PILIH</option>
                  <?php foreach($kopegtel as $key){ ?>
                  <option value="<?php echo $key['kopegtel_code'] ?>"
                    data-nama_kopegtel="<?php echo $key['nama_kopegtel'] ?>"
                    data-wilayah="<?php echo $key['wilayah'] ?>"
                    data-alamat="<?php echo $key['alamat'] ?>"
                    data-ketua_pengurus="<?php echo $key['ketua_pengurus'] ?>"
                    data-jabatan="<?php echo $key['jabatan'] ?>"
                    data-nik="<?php echo $key['nik'] ?>"
                    data-deskripsi_ketua_pengurus="<?php echo $key['deskripsi_ketua_pengurus'] ?>"
                    data-email="<?php echo $key['email'] ?>"
                    data-no_telpon="<?php echo $key['no_telpon'] ?>"
                    data-nama_bank="<?php echo $key['nama_bank'] ?>"
                    data-bank_cabang="<?php echo $key['bank_cabang'] ?>"
                    data-nomor_rekening="<?php echo $key['nomor_rekening'] ?>"
                    data-atasnama_rekening="<?php echo $key['atasnama_rekening'] ?>"
                    data-status_chaneling="<?php echo $key['status_chaneling'] ?>"><?php echo $key['nama_kopegtel'] ?></option>
                  <?php } ?>
                </select>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Wilayah <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="wilayah" id="wilayah" class="large m-wrap" readonly="" style="background-color:#f5f5f5;" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="alamat" id="alamat" class="large m-wrap" readonly="" style="background-color:#f5f5f5;"/></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pejabat <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="ketua_pengurus" id="ketua_pengurus" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jabatan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="jabatan" id="jabatan" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">NIK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nik" id="nik" data-required="1" class="medium m-wrap" readonly="" style="background:#f5f5f5"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Deskripsi<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="deskripsi_ketua_pengurus" id="deskripsi_ketua_pengurus" rows="5" class="large m-wrap" readonly="" style="background-color:#f5f5f5;"/></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Email <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="email" id="email" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telpon <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_telpon" id="no_telpon" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Channeling <span class="required">*</span></label>
               <div class="controls">
                  <select id="status_chaneling" name="status_chaneling" class="small m-wrap" disabled="" style="background-color:#f5f5f5;">
                     <option value="">PILIH</option>
                     <option value="Y">YA</option>
                     <option value="T">TIDAK</option>
                   </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_bank" id="nama_bank" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Cabang Bank <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="bank_cabang" id="bank_cabang" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nomor_rekening" id="nomor_rekening" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Atas Nama <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="atasnama_rekening" id="atasnama_rekening" class="medium m-wrap" readonly="" style="background-color:#f5f5f5;"/>
               </div>
            </div>
            
            <hr>
            <div class="row">
              <div class="span5">
                <div class="control-group hide">
                   <label class="control-label">Produk<span class="required">*</span></label>
                   <div class="controls">
                      <select id="product_code" name="product_code" class="m-wrap" disabled="" style="background-color:#f5f5f5;">
                        <?php foreach($product as $produk){ ?>
                        <option value="<?php echo $produk['product_code'] ?>"
                          data-minrate="<?php echo $produk['rate_margin1'] ?>"
                          data-maxrate="<?php echo $produk['rate_margin2'] ?>"><?php echo $produk['product_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>                        
                <div class="control-group">
                   <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                   <div class="controls">
                    <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" disabled="" style="background-color:#f5f5f5;">
                      <?php foreach ($peruntukan as $data):?>
                        <option value="<?php echo $data['code_value'];?>" data-akad_code="<?php echo $data['akad_code'] ?>"><?php echo $data['display_text'];?></option>
                      <?php endforeach?>  
                    </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Akad : </label>
                   <div class="controls" style="padding-top:7px">
                    <select name="akad_code" id="akad_code" class="medium m-wrap" data-required="1">
                      <?php foreach ($akads as $akad): ?>
                        <option value="<?php echo $akad['akad_code'];?>" data-jenis_keuntungan="<?php echo $akad['jenis_keuntungan'] ?>"><?php echo $akad['akad_name'];?></option>
                      <?php endforeach ?>
                    </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Keterangan Peruntukan</label>
                   <div class="controls">
                      <input type="text" name="keterangan_peruntukan" id="keterangan_peruntukan" class="medium m-wrap" maxlength="100" readonly="" style="background-color:#f5f5f5;"/>
                   </div>
                </div>               
                <div class="control-group">
                   <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                   <div class="controls">
                       <div class="input-prepend input-append">
                         <span class="add-on">Rp</span>
                         <input type="text" class="m-wrap mask-money" name="amount" id="amount" value="0" readonly="" style="width:120px;background-color:#f5f5f5;">
                         <span class="add-on">,00</span>
                       </div>
                     </div>
                </div> 
                <div class="control-group">
                   <label class="control-label">Jumlah Pemb. Disetujui<span class="required">*</span></label>
                   <div class="controls">
                       <div class="input-prepend input-append">
                         <span class="add-on">Rp</span>
                         <input type="text" class="m-wrap mask-money" name="amount_disetujui" id="amount_disetujui" value="0" style="width:120px;">
                         <span class="add-on">,00</span>
                       </div>
                     </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Termin Percairan<span class="required">*</span></label>
                   <div class="controls">
                     <select name="termin" id="termin" class="medium m-wrap" data-required="1">
                      <option value="1" selected="">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" class="m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="3" style="width:40px;"> *bulan
                      <span id="notif_jk_waktu" style="color:red;font-size:10px;"></span>
                    </div>
                </div>
                <div class="control-group" style="display:none;">
                   <label class="control-label"><span id="label-total-margin">Total Margin</span><span class="required">*</span></label>
                   <div class="controls">
                       <div class="input-prepend input-append">
                         <span class="add-on">Rp</span>
                         <input type="text" class="m-wrap mask-money" name="total_margin" id="total_margin" value="0" style="width:120px;">
                         <span class="add-on">,00</span>
                       </div>
                     </div>
                </div>
                <div class="control-group" style="display:none;">
                 <label class="control-label">Total Proyeksi Keuntungan<span class="required">*</span></label>
                 <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" name="amount_proyeksi_keuntungan" id="amount_proyeksi_keuntungan" value="0" style="width:120px;">
                     <span class="add-on">,00</span>
                   </div>
                 </div>
                </div>
                <div class="control-group" style="display:none;">
                   <label class="control-label">Nisbah Nasabah<span class="required">*</span></label>
                   <div class="controls">
                     <div class="input-append">
                       <input type="text" class="m-wrap" name="nisbah" id="nisbah" value="0" style="width:50px;" maxlength="6">
                       <span class="add-on">%</span>
                     </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="tanggal_pengajuan" id="tanggal_pengajuan" class="maskdate small m-wrap" readonly="" style="background-color:#f5f5f5;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Rencana Pencairan<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="rencana_droping" id="rencana_droping" class="maskdate small m-wrap" readonly="" style="background-color:#f5f5f5;"/>
                   </div>
                </div>
              </div>
              <div class="span5">
                <table class="table table-striped table-bordered" id="table-termin">
                  <thead>
                    <tr>
                      <th>Termin</th>
                      <th>Nominal</th>
                      <th>Tgl. Rencana Pencairan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- body of termin goes here -->
                  </tbody>
                </table>
              </div>
            </div>

            <div class="form-actions">
               <button type="submit" id="approve" name="approve" class="btn purple">Approve</button>
               <button type="submit" id="reject" name="reject" class="btn red">Reject</button>
               <button type="button" id="cancel" class="btn">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT  -->

  

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.1.10.4.min.js" type="text/javascript"></script>
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
<script src="<?php echo base_url(); ?>assets/plugins/ba-throttle-debounce.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $(".maskdate").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
  
  // begin first table
  table = $('#pengajuan_pembiayaan_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"rekening_nasabah/datatable_approval_pengajuan_banmod",
      "aoColumns": [            
        { "bSortable": false },
        { "bSortable": false },
        { "bSortable": false },
        { "bSortable": false },
        { "bSortable": true },
        // { "bSortable": true },
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
              'aTargets': [0,1]
          }
      ]
  });

  jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

  // BEGIN FORM EDIT VALIDATION
  var form2 = $('#form_edit');
  var error2 = $('.alert-error', form2);
  var success2 = $('.alert-success', form2);

  // event button Edit ketika di tekan
  $("a#link-edit").live('click',function(){        
    form2.trigger('reset');
    $("#amount","#form_edit").val(0).prop(0);
    $("#wrapper-table").hide();
    var account_financing_reg_id = $(this).attr('account_financing_reg_id');
    termin_action();
    $.ajax({
      type: "POST",
      async: false,
      dataType: "json",
      data: {account_financing_reg_id:account_financing_reg_id},
      url: site_url+"rekening_nasabah/get_pengajuan_banmod_by_account_financing_reg_id",
      success: function(response)
      {
        $('#account_financing_reg_id',form2).val(account_financing_reg_id);
        $('#kopegtel_name',form2).val(response.kopegtel_name);
        $('#kopegtel2',form2).val(response.kopegtel).trigger('liszt:updated');
        $('#wilayah',form2).val(response.wilayah);
        $('#alamat',form2).val(response.alamat);
        $('#ketua_pengurus',form2).val(response.ketua_pengurus);
        $('#jabatan',form2).val(response.jabatan);
        $('#nik',form2).val(response.nik);
        $('#deskripsi_ketua_pengurus',form2).val(response.deskripsi_ketua_pengurus);
        $('#email',form2).val(response.email);
        $('#no_telpon',form2).val(response.no_telpon);
        $('#status_chaneling',form2).val(response.status_chaneling);
        $('#nama_bank',form2).val(response.nama_bank);
        $('#bank_cabang',form2).val(response.bank_cabang);
        $('#nomor_rekening',form2).val(response.nomor_rekening);
        $('#atasnama_rekening',form2).val(response.atasnama_rekening);
        $('#product_code',form2).val(response.product_code);
        $('#peruntukan',form2).val(response.peruntukan);
        $('#keterangan_peruntukan',form2).val(response.keterangan_peruntukan);
        $('#amount',form2).val(number_format(response.amount,0,',','.'));
        $('#amount_disetujui',form2).val(number_format(response.amount,0,',','.'));
        $('#jangka_waktu',form2).val(response.jangka_waktu);
        $('#tanggal_pengajuan',form2).val(App.ToDatePicker(response.tanggal_pengajuan));
        if (response.rencana_droping!=null) {
          $('#rencana_droping',form2).val(App.ToDatePicker(response.rencana_droping));
        }
        eveAkad();
      }
    });

    $("#edit").show();

  });

  form2.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      errorPlacement: function(error,element){},
      rules: {
        kopegtel:{'required':true}
        ,wilayah:{'required':true}
        ,alamat:{'required':true}
        ,ketua_pengurus:{'required':true}
        ,jabatan:{'required':true}
        ,nik:{'required':true}
        ,email:{'required':true}
        ,no_telpon:{'required':true}
        ,status_chaneling:{'required':true}
        ,nama_bank:{'required':true}
        ,nomor_rekening:{'required':true}
        ,product_code:{'required':true}
        ,peruntukan:{'required':true}
        ,keterangan_peruntukan:{'required':true}
        ,amount:{'required':true}
        ,amount_disetujui:{'required':true}
        ,termin:{'required':true}
        ,amount_proyeksi_keuntungan:{'required':true}
        ,nisbah:{'required':true}
        ,jangka_waktu:{'required':true}
        ,total_margin:{'required':true}
        ,tanggal_pengajuan:{'required':true}
        ,rencana_pencairan:{'required':true}
      },

      invalidHandler: function (event, validator) { //display error alert on form submit              
          success2.hide();
          error2.show();
          App.scrollTo(error2, -200);
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
      },

      submitHandler: function (form) {
        var bValid = true, message='', bValidJmlDisetujui = true, JmlTtlTermin = 0, amount_disetujui=convert_numeric($("#amount_disetujui",'#form_edit').val());
        var termin = $('#termin','#form_edit').val();

        if (termin>1) {
          $('input#arr_amount','#form_edit').each(function(){
            JmlTtlTermin += parseFloat(convert_numeric($(this).val()));
            
            if ($(this).val()=="0" || $(this).val()=="") {
              bValid=false;
              $(this).addClass('error');
            } else {
              $(this).removeClass('error');
            }
            if ($(this).parent().parent().parent().find('input#arr_rencana_droping').val()=="") {
              bValid=false;
              $(this).parent().parent().parent().find('input#arr_rencana_droping').addClass('error');
            } else {
              $(this).parent().parent().parent().find('input#arr_rencana_droping').removeClass('error');
            }
          })

          if (JmlTtlTermin<amount_disetujui) {
            bValid=false;
            bValidJmlDisetujui=false;
          }

          if (JmlTtlTermin>amount_disetujui) {
            bValid=false;
            bValidJmlDisetujui=false;
          }
        }

        if (bValidJmlDisetujui==false && bValid==false) {
          App.WarningAlert('Total Nominal Pembiayaan Termin harus sama dengan Jumlah Pemb. Disetujui!');
        } else if (bValid==false) {
          App.WarningAlert('Mohon isi Termin dengan lengkap dan benar!');
        }

        if(bValid==true){
          // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/do_approve_pengajuan_banmod",
            dataType: "json",
            data: form2.serialize(),
            success: function(response){
              if(response.success==true){
                $.alert({
                  title:"Success",icon:'icon-check',backgroundDismiss:false,
                  content:response.message,
                  confirmButtonClass:'btn green',
                  confirm:function(){
                    $('#cancel',form2).trigger('click');
                    table.fnReloadAjax();
                  }
                })
              }else{
                success2.hide();
                error2.show();
              }
              App.scrollTo(form2, -200);
            },
            error:function(){
                success2.hide();
                form2.show();
                App.scrollTo(error2, -200);
            }
          });
        }

      }
  });
  //  END FORM EDIT VALIDATION

  // event untuk kembali ke tampilan data table (EDIT FORM)
  $("#cancel","#form_edit").click(function(){
    $("#edit").hide();
    $("#wrapper-table").show();
    $('#kopegtel',form2).trigger('liszt:updated');
    success2.hide();
    error2.hide();
  });

  var form3 = $('#form_upload');
  var error3 = $('.alert-error', form3);
  var success2 = $('.alert-success', form3);

  // event button Upload ketika di tekan
  $("a#link-upload").live('click',function(){
    form3.trigger('reset');
    var account_financing_reg_id = $(this).attr('account_financing_reg_id');
    var kopegtel_code = $(this).attr('kopegtel_code');
    var f_proposal = $(this).attr('f_proposal');
    var f_kontrak = $(this).attr('f_kontrak');
    var f_keuangan = $(this).attr('f_keuangan');
    var f_rek_koran = $(this).attr('f_rek_koran');
    var f_aki = $(this).attr('f_aki');
    var f_proyeksi = $(this).attr('f_proyeksi');
    var f_jaminan = $(this).attr('f_jaminan');
    $('#account_financing_reg_id',form3).val(account_financing_reg_id);
    $('#kopegtel_code',form3).val(kopegtel_code);
    if (f_proposal!="") {
      $('#download1 span',form3).text(f_proposal);
      $('#download1 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_proposal+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download1 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_kontrak!="") {
      $('#download2 span',form3).text(f_kontrak);
      $('#download2 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_kontrak+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download2 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_keuangan!="") {
      $('#download3 span',form3).text(f_keuangan);
      $('#download3 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_keuangan+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download3 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_rek_koran!="") {
      $('#download4 span',form3).text(f_rek_koran);
      $('#download4 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_rek_koran+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download4 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_aki!="") {
      $('#download5 span',form3).text(f_aki);
      $('#download5 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_aki+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download5 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_proyeksi!="") {
      $('#download6 span',form3).text(f_proyeksi);
      $('#download6 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_proyeksi+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download6 span',form3).html('<em>(file belum di upload)</em>');
    }
    if (f_jaminan!="") {
      $('#download7 span',form3).text(f_jaminan);
      $('#download7 div').html('<a target="_blank" href="'+base_url+'/assets/data_pengajuan_banmod/'+f_jaminan+'"><i class="icon-download"></i> Download</a>');
    } else {
      $('#download7 span',form3).html('<em>(file belum di upload)</em>');
    }
  });

  var termin_action = function() {
    table_termin = $("#table-termin");
    termin = $('#termin','#form_edit').val();
    rencana_droping = $('#rencana_droping','#form_edit');
    if (termin>1) {
      var table_body = '';
      for (i=1;i<=termin;i++) {
        table_body += '<tr>';
        table_body += '<td style="text-align:center;vertical-align:middle;">'+i+'</td>';
        table_body += '<td style="text-align:center"><div class="input-prepend input-append"><span class="add-on">Rp</span><input type="text" class="m-wrap mask-money" id="arr_amount" name="arr_amount[]" value="0" style="background:#ffffff;"><span class="add-on">.00</span></div></td>';
        table_body += '<td style="text-align:center"><input type="text" class="m-wrap maskdate" id="arr_rencana_droping" name="arr_rencana_droping[]" placeholder="dd/mm/yyyy" style="text-align:center"></td>';
        table_body += '</tr>';
      }
      rencana_droping.closest('.control-group').hide();
      table_termin.parent().show();
      table_termin.find('tbody').html(table_body);
    } else {
      table_termin.parent().hide();
      rencana_droping.closest('.control-group').show();
      table_termin.find('tbody').html('');
    }
  }

  $('#termin','#form_edit').change(function(){
    termin_action();
  })

  $('#peruntukan','#form_edit').change(function(){
    var akad_code = $(this).find('option:selected').attr('akad_code');
    $('#akad_code','#form_edit').val(akad_code);
  })

  var getTotalMargin = function() {
    rate = $('#product_code option:selected','#form_edit').data('maxrate');
    amount = parseFloat(convert_numeric($('#amount_disetujui','#form_edit').val()));
    jangka_waktu = parseFloat(convert_numeric($('#jangka_waktu','#form_edit').val()));
    total_margin = (rate*amount*jangka_waktu/1200);
    return total_margin;
  }

  var eveAkad = function() {
    table_termin = $("#table-termin");
    rencana_droping = $('#rencana_droping','#form_edit');
    jenis_keuntungan = $('#akad_code option:selected','#form_edit').data('jenis_keuntungan');
    akad_code = $('#akad_code','#form_edit').val();
    switch(jenis_keuntungan) {
      case 2: //bagi hasil
      $('#termin','#form_edit').val('1').attr('disabled',false).css('backgroundColor','#ffffff');
      $('#nisbah','#form_edit').val(0).closest('.control-group').show();
      $('#amount_proyeksi_keuntungan','#form_edit').closest('.control-group').show();
      $('#amount_proyeksi_keuntungan','#form_edit').val('0').prop('0');
      $('#amount_proyeksi_keuntungan','#form_edit').attr('value','0');
      $('#total_margin','#form_edit').val(0).closest('.control-group').hide();
      break;
      default: //margin/rate dll
      var total_margin = getTotalMargin();
      $('#termin','#form_edit').val('1').attr('disabled',true).css('backgroundColor','#f5f5f5');
      $('#nisbah','#form_edit').val(0).closest('.control-group').hide();
      $('#total_margin','#form_edit').val(number_format(total_margin,0,',','.')).closest('.control-group').show();
      $('#amount_proyeksi_keuntungan','#form_edit').val(number_format(total_margin,0,',','.')).closest('.control-group').hide();
      table_termin.parent().hide();
      rencana_droping.closest('.control-group').show();
      // kalo akadnya ijaroh label marginnya diganti jadi Total Ujroh, bukan Total Margin
      labeltotalmarginujroh(akad_code,$('#label-total-margin','#form_edit'));

      break;
    }
    $('#jenis_keuntungan','#form_edit').val(jenis_keuntungan);
  }

  $('#jangka_waktu','#form_edit').change(function(){
    var total_margin = getTotalMargin();
    $('#total_margin','#form_edit').val(number_format(total_margin,0,',','.'))
    $('#amount_proyeksi_keuntungan','#form_edit').val(number_format(total_margin,0,',','.'))
  })

  $('#akad_code','#form_edit').change(function(){
    eveAkad();
  })

});
</script>
<!-- END JAVASCRIPTS -->

