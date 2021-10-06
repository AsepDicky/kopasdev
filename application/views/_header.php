   <div class="header navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
         <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="#">
               <img src="<?php echo base_url('assets/img/logo-koptel-2.png'); ?>" style="height:35px;">
               <?php //echo $this->session->userdata('institution_name'); ?>
            <!-- <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="logo" /> -->
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
            <img src="<?php echo base_url(); ?>assets/img/menu-toggler.png" alt="" />
            </a>          
            <!-- END RESPONSIVE MENU TOGGLER -->   
            <!-- BEGIN TOP NAVIGATION MENU -->              
            <ul class="nav pull-right">
               <!-- BEGIN USER LOGIN DROPDOWN -->
               <li class="dropdown user">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img alt="" src="<?php echo base_url(); ?>assets/img/profile/thumb/<?php echo ( $this->session->userdata('photo') == "" ) ? 'default.jpg' : $this->session->userdata('photo'); ?>" style="height:29px;" />
                  <span class="username"><?php echo $this->session->userdata('fullname'); ?></span>
                  <i class="icon-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu">
                     <li><a href="<?php echo site_url('administration/profile_setup') ?>/<?php echo $this->session->userdata('user_id') ?>"><i class="icon-user"></i> My Profile</a></li>
                     <li><a href="<?php echo site_url('logout') ?>"><i class="icon-key"></i> Log Out</a></li>
                  </ul>
               </li>
               <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <div class="pull-right" style="color:#FFFFFF;line-height:40px;font-size:13px;">Periode : <?php echo $periode_awal.' s.d '.$periode_akhir; ?></div>         
            <!-- END TOP NAVIGATION MENU --> 
         </div>
      </div>
      <!-- END TOP NAVIGATION BAR -->
   </div>
