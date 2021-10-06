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
        <h3 class="page-title">Penarikan TWP <small>Upload Penarikan tabungan TWP</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Upload Penarikan tabungan TWP</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>Upload Data Penarikan</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="<?php echo site_url('transaction/do_upload_penarikan_twp'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
                <div class="alert alert-error hide">
                    <button class="close" data-dismiss="alert"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="control-group">
                    <label class="control-label">File <span class="required">*</span></label>
                    <div class="controls">
                        <input type="file" id="userfile" name="userfile"/>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Deskripsi <span class="required">*</span></label>
                    <div class="controls">
                        <textarea id="deskripsi" name="deskripsi" class="m-wrap medium"></textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tanggal Transaksi <span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="m-wrap date-picker mask-date" id="trx_date" name="trx_date" placeholder="dd/mm/yyyy">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <button type="submit" id="upload" class="btn purple"><i class="icon-upload"></i> <span>Upload</span></button>
                    </div>
                </div>
            </form>
            <!-- END FORM-->            
        </div>
    </div>
</div>
<!-- END FORM ADD -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js" type="text/javascript"></script>     
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
$(function(){
App.init(); // initlayout and core plugins
/*
| ------------------------------------------------------------------------
*/
var FormAdd = $("#FormAdd"), alert_error = $('.alert-error')
    progress = $('.progress'), 
    bar = $('.bar'), 
    percent = $('.percent')
    month_of_this_period = <?php echo $month_periode_awal ?>,
    trx_periode1 = new Date(<?php echo $year_periode_awal ?>, <?php echo $month_periode_awal ?>-1,<?php echo $day_periode_awal ?>),
    trx_periode2 = new Date(<?php echo $year_periode_akhir ?>, <?php echo $month_periode_akhir ?>-1,<?php echo $day_periode_akhir ?>),
    months = ['-','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
var desc_month_of_this_period = months[parseFloat(month_of_this_period)];

var trxdate = "<?php echo date('d') ?>/<?php echo $month_periode_awal ?>/<?php echo $year_periode_awal ?>";
$('#trx_date').val(trxdate).datepicker('update');

$('#userfile').change(function(){
    val = $(this).val();
    $('#deskripsi').val(val);
})

/*BEGIN EDIT*/
FormAdd.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
        userfile:{required:true},
        deskripsi:{required:true},
        trx_date:{required:true}
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        alert_error.show();
        App.scrollTo(alert_error, -200);
    },
    highlight: function (element) { // hightlight error inputs
        $(element).closest('.form-group').removeClass('success').addClass('error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).closest('.form-group').removeClass('error'); // set error class to the control group
    },
    submitHandler: false,
    submitHandler: function (form) {
        $('#upload').attr('disabled',true);
        
        var dontBlock = true;
        var bValid = true;
        var v_message = '';

        var trx_date = $("#trx_date").val();
        var s = trx_date.split('/');
        var day=s[0],month=s[1],year=s[2];
        
        trx_date = new Date(year,month-1,day);
        if (trx_periode1 > trx_date || trx_date > trx_periode2) {
            v_message = 'Tanggal Transaksi harus berada dalam Bulan '+desc_month_of_this_period+'.';
            bValid=false;
        }

        if (bValid) {

            FormAdd.ajaxSubmit({
                dataType: 'json', 
                beforeSend: function() {
                    $('#upload').html('<i class="icon-spinner icon-spin"></i> <span>0%</span>');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    console.log(percentComplete);
                    if (percentComplete>99) {
                        percentComplete=99;
                    }
                    $('#upload span').html(''+percentComplete+'%');
                },
                cache:false,
                success: function(response) {
                    $('#upload').html('<i class="icon-upload"></i> Upload');
                    $('#upload').attr('disabled',false);
                    if (response.success==true) {
                        $.alert({
                            title:'Upload Success',icon:'icon-check',backgroundDismiss:false,
                            content:'Upload Penarikan TWP SUKSES.',
                            confirmButtonClass:'btn green',
                            confirm:function(){
                                $('#userfile').val('');
                                $('#deskripsi').val('');
                                alert_error.hide();
                                App.scrollTo($('body'), 0);
                            }
                        })
                    } else {
                        App.WarningAlert(response.error);
                    }

                },
                error: function(){
                    App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                    // var percentVal = '100%';
                    // percent.html(percentVal);
                    $('#upload').html('<i class="icon-upload"></i> Upload');
                    $('#upload').attr('disabled',false);
                }
            });

        } else {
            App.WarningAlert(v_message);
            $('#upload').html('<i class="icon-upload"></i> Upload');
            $('#upload').attr('disabled',false);
        }
    }
});
// $('#upload').unbind('click');
// $('#upload').click(function(){

//     var iframe = $('<iframe name="postiframe" id="postiframe" style="display: none"></iframe>');

//     $("body").append(iframe);

//     var form = $('#FormAdd');
//     form.attr("method", "post");
//     form.attr("encoding", "multipart/form-data");
//     form.attr("enctype", "multipart/form-data");
//     form.attr("target", "postiframe");
//     form.submit();
//     $('#upload').html('<i class="icon-spinner icon-spin"></i> Processing...');
//     $('#upload').attr('disabled',true);
//     $('#postiframe').unbind('load');
//     $("#postiframe").load(function () {
//         iframeContents = this.contentWindow.document.body.innerHTML;
//         // console.log(iframeContents);
//         if (iframeContents=='1') {
//             $.alert({
//                 title:'Upload Success',icon:'icon-check',backgroundDismiss:false,
//                 content:'Upgrade Data Pegawai SUKSES.',
//                 confirmButtonClass:'btn green',
//                 confirm:function(){
//                     $('#userfile').val('');
//                     $('#upload').html('<i class="icon-upload"></i> Upload');
//                     $('#upload').attr('disabled',false);
//                 }
//             })
//         } else {
//             App.WarningAlert(iframeContents);
//             $('#upload').html('<i class="icon-upload"></i> Upload');
//             $('#upload').attr('disabled',false);
//         }
//     });

//     return false;

// })

});
</script>
