


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
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-group"></i>
                        </div>
                        <div class="details">
                           <div class="number"><?php echo $jumlah_pengajuan_pembiayaan+$jumlah_proses_pembiayaan+$jumlah_cair_pembiayaan; ?></div>
                           <div class="desc">Pengajuan</div>
                        </div>
                        <a class="more" style="text-align:right;" data-toggle="modal" href="#dialog_pengajuan1" id="browse_pengajuan1">
                        Jumlah Pengajuan : <?php echo $jumlah_pengajuan_pembiayaan ?> nasabah <br>
                        </a>      
                        <a class="more" style="text-align:right;" data-toggle="modal" href="#dialog_pengajuan2" id="browse_pengajuan2">
                        dalam proses : <?php echo $jumlah_proses_pembiayaan ?> nasabah <br>
                        </a>      
                        <a class="more" style="text-align:right;" data-toggle="modal" href="#dialog_pengajuan3" id="browse_pengajuan3">
                        sudah cair : <?php echo $jumlah_cair_pembiayaan ?> nasabah
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat red">
                        <div class="visual">
                           <i class="icon-warning-sign"></i>
                        </div>
                        <div class="details"> 
                           <div class="number"><?php echo $terlambat;?></div>
                           <div class="desc">Pengajuan > 2 Hari</div>
                        </div>
                        <a class="more" style="text-align:right;" data-toggle="modal" href="#dialog_more_2hari" id="browse_more_2hari">
                           <?php 
                              $jml = count($proses_terlambat);
                              $loop = ($jml>3) ? 2 : $jml ;
                              for ($i=0; $i<$loop; $i++) {

                                 if(strlen($proses_terlambat[$i]['kopegtel_code'])==0){
                                    $nama_kopegtel = 'Koptel';
                                 }else{
                                    $nama_kopegtel = $proses_terlambat[$i]['nama_kopegtel'];
                                 }
                                 echo $nama_kopegtel.' : '.$proses_terlambat[$i]['count'];
                                 if($i!=2) echo '<br>';
                              }
                              if($jml>3) echo 'Dan '.($jml-3).' Kopegtel Lainnya';
                           ?>
                        </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat yellow">
                        <div class="visual">
                           <i class="icon-money"></i>
                        </div>
                        <div class="details">
                           <div class="number" style="font-size:24px;"><?php echo number_format(($outstanding['saldo_pokok']+$outstanding['saldo_margin'])/1000);?></div>
                           <div class="desc">                           
                              Outstanding (Ribuan)
                           </div>
                        </div>
                         <a class="more" style="text-align:right;" href="#">
                           Jumlah Pembiayaan : <?php echo $outstanding['count'];?><br>
                           Pokok : RP. <?php echo number_format($outstanding['saldo_pokok']/1000);?><br>
                           Margin : RP. <?php echo number_format($outstanding['saldo_margin']/1000);?>
                         </a>                 
                     </div>
                  </div>
                  <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-shopping-cart"></i>
                        </div>
                        <div class="details">
                           <div class="number" style="font-size:24px;"><?php echo $rekenig_aktif;?></div>
                           <div class="desc">                           
                              Peruntukan
                           </div>
                        </div>
                         <a class="more" style="text-align:right;" href="#">
                           <?php 
                              $jml = count($peruntukan);
                              $loop = ($jml>3) ? 2 : $jml ;
                              for ($i=0; $i<$loop; $i++) {
                                 echo $peruntukan[$i]['display_text'].' : '.$peruntukan[$i]['count'];
                                 if($i!=2) echo '<br>';
                              }
                              if($jml>3) echo 'Dan '.($jml-3).' Peruntukan Lainnya';
                           ?>
                         </a>                 
                     </div>
                  </div>
               </div>
               <!-- END DASHBOARD STATS -->


            <div class="row-fluid">
               <div class="span6">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <?php if($show_unapproved==true) { ?>
                  <div class="portlet box red" id="wrapper-table">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-user"></i>Un-Approved Pembiayaan</div>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div class="clearfix">
                           <ul class="feeds">
                           <li>
                              <a data-toggle="modal" href="#dialog_pengajuan_unapprove" id="browse_pengajuan_unapprove">
                              <div class="col1">
                                 <div class="cont">
                                    <div class="cont-col1">
                                       <div class="label label-sm label-info">
                                          <i class="icon-check"></i>
                                       </div>
                                    </div>
                                    <div class="cont-col2">
                                       <div class="desc">
                                          Jumlah Pengajuan Belum di Approve
                                          <span class="label label-sm label-warning"><?php echo $pengajuan_unapproved ?><i class="icon-user"></i></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </a>
                           </li>
                           <li>
                              <a data-toggle="modal" href="#dialog_spb_unapprove" id="browse_spb_unapprove">
                              <div class="col1">
                                 <div class="cont">
                                    <div class="cont-col1">
                                       <div class="label label-sm label-success">
                                          <i class="icon-check"></i>
                                       </div>
                                    </div>
                                    <div class="cont-col2">
                                       <div class="desc">
                                          Jumlah SPB Belum di Approve
                                          <span class="label label-sm label-warning "><?php echo $spb_unapproved ?><i class="icon-user"></i></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </a>
                           </li>
                        </ul>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
                  <div class="portlet box green" id="wrapper-table">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-money"></i>Outstanding Pembiayaan</div>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div class="clearfix" style="overflow:hidden;">
                           <div style="margin-top:-40px;">
                              <div id="chart_div_colum"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
               <div class="span6">
                  <div class="portlet box blue" id="wrapper-table">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-money"></i>Outstanding Pembiayaan</div>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div class="clearfix" style="overflow:hidden;">
                           <div style="margin-left:-100px;margin-right:-50px;margin-top:-40px;margin-bottom:-40px;">
                              <!-- <div id="chart_div" style="margin-left:-150px;margin-right:-100px;"></div> -->
                              <div id="chart_div"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
              


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