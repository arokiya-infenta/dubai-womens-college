   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
      <!-- <img src="<?=base_url()?>white-version/assets/images/th.jpg" class="logo-icon" alt="logo icon">-->
       <h5 class="logo-text">MSSW UG <?=$this->session->userdata('user')['user_name']?> - <?=$this->session->userdata('user')['user_aca_year']?></h5>
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
     
    
    
   <li><a href="<?=site_url()?>UgSelfFinance" class="waves-effect"><i class="icon-home"></i><span>Dashboard</span></a></li>
  <!--<li><a href="<?=site_url()?>PgMswAided/NonAppliedStudent" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Student Not Applied</span></a></li>-->
  <li><a href="<?=site_url()?>UgSelfFinance/studentApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Application Details </span></a></li>


  <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Selection Details</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">



  <li><a href="<?=site_url()?>UgSelfFinance/verifiedApplied" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Verified Applicants </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/SeatAllocation" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Seat Allocation </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/tempShortlist" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Shortlist Candidate </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/SelectionStatus" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Take PDF   </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/principalApproved" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Publish & Admit  </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/admittedStudent" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Assign Register Number </span></a></li>
  <li><a href="<?=site_url()?>UgSelfFinance/admittedErp" class="waves-effect"><i class="fa fa-circle-o text-red"></i><span>Admit Erp </span></a></li>


  		
  		  <!--<li><a href="#"><i class="fa fa-circle-o"></i> Panel wise report</a></li>-->
       
        </ul>
      </li>
			<li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Students Menus <?=$this->session->userdata('user')['user_aca_year']?> </span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>CommonFunction/importExcelUg/<?=$this->session->userdata('user')['user_dep_status']?>"><i class="fa fa-circle-o"></i> Export Application</a></li>
				<li><a href="<?=site_url()?>UgSelfFinance/studentannouncements/"><i class="fa fa-circle-o"></i> Student Announcements</a></li>
  		 
  		  <!--<li><a href="#"><i class="fa fa-circle-o"></i> Panel wise report</a></li>-->
       
        </ul>
      </li>
    </ul>
	 
   </div>
   <!--End sidebar-wrapper-->
