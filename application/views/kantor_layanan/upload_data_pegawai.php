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
        <h3 class="page-title">Upload Data Pegawai <small>Upload Data Pegawai</small></h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
                <i class="icon-angle-right"></i>
            </li>
            <li><a href="#">Kantor Layanan</a><i class="icon-angle-right"></i></li>  
            <li><a href="#">Upload Data Pegawai</a></li> 
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN FORM ADD -->
<div id="add">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption"><i class="icon-upload"></i>Upload Data Pegawai</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="clearfix">
                <div class="btn-group pull-right">
                    <a href="<?= base_url() ?>assets/template_excel/DATA_TEMPLETE_PEGAWAI.xlsx" download class="btn blue" style="padding:7px 10px;margin-right:5px">
                        Download Template Pegawai <i class="icon-cloud-download"></i>
                    </a>
                    <?php if($pegawai_temp > 0): ?>
                    <a id="sync_pegawai" class="btn yellow" style="padding:7px 10px;">
                        Sync Data Pegawai <i class="icon-refresh"></i>
                    </a>
                    <?php endif;?>
                </div>
              </div>

            <!-- BEGIN FORM-->
            <form action="<?php echo site_url('kantor_layanan/do_upload_data_pegawai'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
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
                    <label class="control-label"></label>
                    <div class="controls">
                        <button type="submit" id="upload" class="btn green"><i class="icon-upload"></i> <span>Upload</span></button>
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
        percent = $('.percent');
        // status = $('#status');

    /*BEGIN EDIT*/
    FormAdd.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-inline', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(a,b){},
        // ignore: "",
        rules: {
            userfile:{required:true}
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
            dontBlock = true
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
                    if (response.success=='true') {
                        $.alert({
                            title:'Upload Success',icon:'icon-check',backgroundDismiss:false,
                            content:'Upload Data Pegawai SUKSES. silahkan lakukan sync data pegawai',
                            confirmButtonClass:'btn green',
                            confirm:function(){
                                $('#userfile').val('');
                                location.reload();
                            }
                        })
                    } else {
                        App.WarningAlert(response.error);
                        $('#userfile').val('');
                        //location.reload();
                    }

                },
                error: function(){
                    App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                    
                    $('#userfile').val('');
                    //location.reload();
                    $('#upload').html('<i class="icon-upload"></i> Upload');
                    $('#upload').attr('disabled',false);
                }
            });
        }
    });

    $('#sync_pegawai').click(function() {
        $('#sync_pegawai').attr('disabled','disabled');
        $.blockUI({ message: '<div style="padding:5px 0;">Proses Singkronisasi.. Harap menunggu dengan sabar!</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} });

        $.ajax({
            type:"POST",
            dataType:"json",
            async: false,
            url:site_url+'kantor_layanan/execute_pegawai_temp',
            success:function(response){
                setTimeout(function(){
                    $.unblockUI
                    $.alert({
                        title:'Sync Success',icon:'icon-check',backgroundDismiss:false,
                        content:'Singkronisasi data pegawai dengan sistem SUKSES.',
                        confirmButtonClass:'btn blue',
                        confirm:function(){
                            location.reload();
                        }
                    })
                }, 500);
            },
            error: function(){
                $.unblockUI
                App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                $('#sync_pegawai').removeAttr('disabled');
            }
        })
    });
});
</script>
