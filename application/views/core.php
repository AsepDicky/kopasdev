<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php $this->load->view('_head'); ?>
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

