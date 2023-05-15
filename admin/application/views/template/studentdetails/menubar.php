   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
       <img src="<?=base_url()?>white-version/assets/images/th.jpg" class="logo-icon" alt="logo icon">
       <h5 class="logo-text"><?=$this->session->userdata('user')['user_name']?></h5>
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
     
    
    
      <li><a href="<?=site_url()?>PgSelfFinance" class="waves-effect"><i class="icon-home"></i><span>Dashboard</span></a></li>
     <li><a href="<?=site_url()?>PgSelfFinance/studentApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Applied Student</span></a></li>
  
  
  
  <!--<li><a href="<?=site_url()?>/Admin/userApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>New Applications</span></a></li>
      <li><a href="<?=site_url()?>/Admin/appliedApproved" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Interview Scheduled</span></a></li>
      <li><a href="<?=site_url()?>/Admin/courseApproved" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Course Approved</span></a></li>
      <li><a href="<?=site_url()?>/Admin/userPaidStatus" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Application Fee List</span></a></li>
      <li><a href="<?=site_url()?>/Admin/ReportsUser" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Reports</span></a></li>-->




      <!--<li><a href="javaScript:void();" class="waves-effect"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="javaScript:void();" class="waves-effect"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
	 
   </div>
   <!--End sidebar-wrapper-->
