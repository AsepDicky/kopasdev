<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
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
   <link href="<?php echo base_url(); ?>assets/css/themes/<?php echo ($this->session->userdata('themes')==false) ? "brown" : $this->session->userdata('themes'); ?>.css" rel="stylesheet" type="text/css" id="style_color"/>
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

    <!--Load the Ajax API-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/google_chart/jsapi.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/google_chart/uds_api_contents.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/google_chart/jquery.min.js"></script>
    <script type="text/javascript">
 
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
 
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
 
    function drawChart() {
 
      // Create our data table out of JSON data loaded from server.
      // var data = new google.visualization.DataTable(
      //                                               {"cols":[{"label":"people","type":"string"},{"label":"total","type":"number"}]
      //                                               ,"rows":[
      //                                                  {"c":[{"v":"Industri"},{"v":510}]}
      //                                                 ,{"c":[{"v":"Jasa"},{"v":1021}]}
      //                                                 ,{"c":[{"v":"Perdagangan"},{"v":1042}]}
      //                                                 ,{"c":[{"v":"Pertanian"},{"v":1063}]}
      //                                               ]}
      //                                               );
      var data = new google.visualization.DataTable(<?php echo $jsonPie; ?>);
      var options = {
           title: '',
          is3D: 'true',
          autowidth: true,
          height: 280,
          // autoheight:true,
          vAxis: {title: 'Jumlah', titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Kelompok', titleTextStyle: {color: 'red'}}
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chartPie = new google.visualization.PieChart(document.getElementById('chart_div'));
      // chartColumn.draw(data, options);
      chartPie.draw(data, options);
    }
 
    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
 
      // Create our data table out of JSON data loaded from server.
      // var data = new google.visualization.DataTable(
      //                                               {"cols":[{"label":"people","type":"string"},{"label":"total","type":"number"}]
      //                                               ,"rows":[
      //                                                  {"c":[{"v":"Industri"},{"v":510}]}
      //                                                 ,{"c":[{"v":"Jasa"},{"v":1021}]}
      //                                                 ,{"c":[{"v":"Perdagangan"},{"v":1042}]}
      //                                                 ,{"c":[{"v":"Pertanian"},{"v":1063}]}
      //                                               ]}
      //                                               );
      var data = new google.visualization.DataTable(<?php echo $jsonColoum; ?>);
      var options = {
           title: '',
          is3D: 'true',
          autowidth: true,
          // width: 580,
          height: 400,
          vAxis: {title: 'Jumlah', titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Produk', titleTextStyle: {color: 'red'}}
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chartColumn = new google.visualization.ColumnChart(document.getElementById('chart_div_colum'));
      chartColumn.draw(data, options);
      // chartPie.draw(data, options);
    }
    </script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <?php $this->load->view('_header'); ?>
   <!-- END HEADER -->

   <!-- BEGIN CONTAINER -->
   <div class="page-container">
      <!-- BEGIN SIDEBAR -->
      <?php $this->load->view('_side_bar'); ?>
      <!-- END SIDEBAR -->

      <!-- BEGIN PAGE -->
      <div class="page-content">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>Widget Settings</h3>
            </div>
            <div class="modal-body">
               Widget settings form goes here
            </div>
         </div>
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <?php $this->load->view($container); ?>
         </div>
         <!-- END PAGE CONTAINER--> 

      </div>
      <!-- END PAGE -->

   </div>
   <!-- END CONTAINER -->

   <!-- BEGIN FOOTER -->
   <div class="footer">
   2013 &copy; Microfinance.
   <div class="span pull-right">
      <span class="go-top"><i class="icon-angle-up"></i></span>
   </div>
</div>
   <!-- END FOOTER -->
</body>
<!-- END BODY -->
</html>

