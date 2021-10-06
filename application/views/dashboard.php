
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
         				Dashboard
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
            <div id="dashboard">
               <!-- BEGIN DASHBOARD STATS -->
               <div class="row-fluid">
                  <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-user"></i>
                        </div>
                        <div class="details">
                           <?php foreach ($petugas as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
                           <div class="desc">                           
                              Petugas
                           </div>
                        </div>
                        <a class="more" href="<?php echo site_url('kantor_layanan/petugas_lapangan');?>">
                        Detail Petugas <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-user"></i>
                        </div>
                        <div class="details">
                           <?php foreach ($anggota as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
                           <div class="desc">Anggota</div>
                        </div>
                        <a class="more" href="<?php echo site_url('anggota/list_anggota');?>">
                        Detail Anggota <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <?php
                  if($this->session->userdata('cif_type')=="2" || $this->session->userdata('cif_type')=="0")
                  {
                  ?>
                  <div class="span3 responsive" data-tablet="span6 fix-offset" data-desktop="span3">
                     <div class="dashboard-stat purple">
                        <div class="visual">
                           <i class="icon-user"></i>
                        </div>
                        <div class="details">
                           <?php foreach ($rembug as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
                           <div class="desc">Rembug Pusat</div>
                        </div>
                        <a class="more" href="<?php echo site_url('kantor_layanan/rembug_setup');?>">
                        Detail Rembug <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- END DASHBOARD STATS -->
              


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

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