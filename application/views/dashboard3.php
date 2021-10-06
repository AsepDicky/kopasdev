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
                  <li class="color-darkblue" data-style="darkblue"></li>
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
				Dashboard <small>statistics and more</small>
			</h3>
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Dashboard</a></li>	
				
			</ul>
         <!-- END PAGE TITLE & BREADCRUMB-->
      </div>
   </div>
   <!-- END PAGE HEADER-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
   });
</script>

<!-- END JAVASCRIPT -->