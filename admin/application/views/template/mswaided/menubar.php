   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
      <!-- <img src="<?=base_url()?>white-version/assets/images/th.jpg" class="logo-icon" alt="logo icon">-->
       <h5 class="logo-text">MSW AID - <?=$this->session->userdata('user')['user_aca_year']?></h5>
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
     
    
    
   <li><a href="<?=site_url()?>MswAided" class="waves-effect"><i class="icon-home"></i><span>Dashboard</span></a></li>
  <!--<li><a href="<?=site_url()?>MswAided/NonAppliedStudent" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Student Not Applied</span></a></li>-->
  <li><a href="<?=site_url()?>MswAided/studentApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Application Details </span></a></li>
  <!--<li><a href="<?=site_url()?>MswAided/ExamStudent" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Student Applied </span></a></li>-->
  
  
  
  <!--<li><a href="<?=site_url()?>/Admin/userApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>New Applications</span></a></li>
      <li><a href="<?=site_url()?>/Admin/appliedApproved" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Interview Scheduled</span></a></li>
      <li><a href="<?=site_url()?>/Admin/courseApproved" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Course Approved</span></a></li>
      <li><a href="<?=site_url()?>/Admin/userPaidStatus" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Application Fee List</span></a></li>
      <li><a href="<?=site_url()?>/Admin/ReportsUser" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Reports</span></a></li>-->
	  
	  <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Interview Details</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		 <!-- <li><a href="<?=site_url()?>Zoom/index"><i class="fa fa-circle-o"></i> Generate Zoom Link</a></li>
  		  <li><a href="<?=site_url()?>MswAided/stuCmnty"><i class="fa fa-circle-o"></i> Allot Zoom Link</a></li>
  		  <li><a href="<?=site_url()?>MswAided/stu_zoom_list"><i class="fa fa-circle-o"></i> Shortlisted Candidates</a></li>-->
  		  <li><a href="<?=site_url()?>MswAided/createPanel"><i class="fa fa-circle-o"></i> Create Panel</a></li>
  		  <li><a href="<?=site_url()?>MswAided/allotPanel"><i class="fa fa-circle-o"></i> Panel Allocation</a></li>
  		  <li><a href="<?=site_url()?>MswAided/stuWOZoom"><i class="fa fa-circle-o"></i> Shortlisted Candidates</a></li>
  		         
        </ul>
      </li>

      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Selection Details</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>MswAided/interviewAttendedStudent"><i class="fa fa-circle-o"></i> Dept. Verification</a></li>
        <li><a href="<?=site_url()?>MswAided/SeatAllocation"><i class="fa fa-circle-o"></i> Seat Allocation</a></li>
  		  <li><a href="<?=site_url()?>MswAided/tempShortlist"><i class="fa fa-circle-o"></i> Shortlist Candidates</a></li>
  		  <li><a href="<?=site_url()?>MswAided/SelectionStatus"><i class="fa fa-circle-o"></i> Take PDF </a></li>
  		  <li><a href="<?=site_url()?>MswAided/principalApproved"><i class="fa fa-circle-o"></i> Publish & Admit</a></li>
  		  <li><a href="<?=site_url()?>MswAided/admittedStudent"><i class="fa fa-circle-o"></i> Assign Register Number</a></li>
  		  <!--<li><a href="#"><i class="fa fa-circle-o"></i> Panel wise report</a></li>-->
       
        </ul>
      </li>

			<li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Students Menus <?=$this->session->userdata('user')['user_aca_year']?> </span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>CommonFunction/excelImport/2/<?=$this->session->userdata('user')['user_dep_status']?>"><i class="fa fa-circle-o"></i> Export Application</a></li>
				<li><a href="<?=site_url()?>MswAided/studentannouncements/"><i class="fa fa-circle-o"></i> Student Announcements</a></li>
  		 
  		  <!--<li><a href="#"><i class="fa fa-circle-o"></i> Panel wise report</a></li>-->
       
        </ul>
      </li>
      <!--<li><a href="javaScript:void();" class="waves-effect"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="javaScript:void();" class="waves-effect"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
	 
   </div>
   <!--End sidebar-wrapper-->
