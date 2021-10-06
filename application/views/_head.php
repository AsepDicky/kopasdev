<head>
   <meta charset="utf-8" />
   <title><?php echo strtoupper($title); ?> | <?php echo strtoupper($this->session->userdata('institution_name')) ;?></title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/css/themes/<?php echo ($this->session->userdata('themes')==false) ? "darkblue" : $this->session->userdata('themes'); ?>.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL STYLES --> 
   <link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>
   <link href="<?php echo base_url(); ?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/select2_metro.css" />
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" />
   <!-- END PAGE LEVEL STYLES -->
   
   <!-- BEGIN JQUERY UI PLUGINS -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/jquery-nestable/jquery.nestable.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.css" />
   <!-- END JQUERY UI PLUGINS -->

   <!-- JQGRID -->
   <link href="<?php echo base_url(); ?>assets/css/ui.jqgrid.css" type="text/css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

   <link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo base_url(); ?>assets/plugins/confirm/jquery-confirm.css" rel="stylesheet" type="text/css"/>
   <link rel="shortcut icon" href="<?php echo base_url('assets/img/logo-koptel-3.png') ?>" />
   <style type="text/css">
   .bg-readonly{
      background-color: #eee !important;
   }
   .loading {
      position: fixed;
      top: 0;
      background: #F4DF94;
      padding: 5px 10px;
      border-bottom-left-radius: 5px !important;
      border-bottom-right-radius: 5px !important;
      color: black;
      font-weight: bold;
      left: 40%;
      z-index: +9999999;
   }
   </style>
</head>