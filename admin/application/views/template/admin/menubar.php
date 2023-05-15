   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
       <img src="<?=base_url()?>white-version/assets/images/th.jpg" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">
	   <?php $user_id=$this->session->userdata('user')['user_id'];
	   $user_det=$this->db->where('ad_id',$user_id)->get('admin')->row();
	   if($user_det->ad_user_name=='Principal'){echo 'Principal';}else{echo 'Admin';}?>
	   </h5>
     </a>
	 </div>
	 <ul class="sidebar-menu do-nicescrol">
     
    
    
     <li><a href="<?=site_url()?>Admin" class="waves-effect"><i class="icon-home"></i><span>Dashboard</span></a></li>
      <li><a href="<?=site_url()?>Admin/applicationFeesCollected" class="waves-effect"><i class="fa fa-money"></i><span>Application Fees</span></a></li>
      <li><a href="<?=site_url()?>Admin/selectionDashbord" class="waves-effect"><i class="fa fa-file-text-o"></i><span>Selection Dashboard</span></a></li>
      <li><a href="<?=site_url()?>Admin/studentSearch" class="waves-effect"><i class="fa fa-search"></i><span>Student Search</span></a></li>
      <li><a href="<?=site_url()?>Admin/studentannouncements" class="waves-effect"><i class="fa fa-search"></i><span>Student Announcements</span></a></li>
      <li><a href="<?=site_url()?>Admin/studentNotApplied" class="waves-effect"><i class="fa fa-search"></i><span>Student Not Applied</span></a></li>
    
  
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Site Mannagement</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>Admin/UploadImageNot"><i class="fa fa-circle-o"></i> Display Notification</a></li>
  	
  		
       
        </ul>
      </li>
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Admitted Student</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/5"><i class="fa fa-circle-o"></i> MAHRM</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/6"><i class="fa fa-circle-o"></i> MAHROD</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/7"><i class="fa fa-circle-o"></i> MA SE</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/8"><i class="fa fa-circle-o"></i> MA DM</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/9"><i class="fa fa-circle-o"></i> M.Sc. CP</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/15"><i class="fa fa-circle-o"></i> MSW DE</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/1/16"><i class="fa fa-circle-o"></i> M.Sc. FT</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/2/1"><i class="fa fa-circle-o"></i> MSW AIDED CD</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/2/2"><i class="fa fa-circle-o"></i> MSW AIDED MPS</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/2/3"><i class="fa fa-circle-o"></i> MSW AIDED HRM</a></li>		 
         <li><a href="<?=site_url()?>Admin/excelImport/3/1"><i class="fa fa-circle-o"></i> MSW SELFIN CD</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/3/2"><i class="fa fa-circle-o"></i> MSW SELFIN MPS</a></li>
  		  <li><a href="<?=site_url()?>Admin/excelImport/3/3"><i class="fa fa-circle-o"></i> MSW SELFIN HRM</a></li>
  		  <li><a href="<?=site_url()?>Admin/importExcelUg/5/1"><i class="fa fa-circle-o"></i> UG BSW</a></li>
  		  <li><a href="<?=site_url()?>Admin/importExcelUg/5/2"><i class="fa fa-circle-o"></i> UG B.Sc</a></li>
  	
  	
  	
       
        </ul>
      </li>
  
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Setting</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
  		  <li><a href="<?=site_url()?>Admin/acadamicYear"><i class="fa fa-circle-o"></i> Acadamic Year </a></li>
  		  <li><a href="<?=site_url()?>Admin/applicationActive"><i class="fa fa-circle-o"></i> Activate Application</a></li>
  		 <li><a href="<?=site_url()?>Admin/mockExamActive"><i class="fa fa-circle-o"></i> Activate Demo Exam </a></li>
  		  <li><a href="<?=site_url()?>Admin/mainExamActive"><i class="fa fa-circle-o"></i> Activate Main Exam </a></li>
          </ul>
      </li>
      <li><a href="<?=site_url()?>Admin/viewQuesionBank"><i class="fa fa-circle-o"></i>Ques. Bank </a></li>
      <li><a href="<?=site_url()?>Admin/enQuireyForm"><i class="fa fa-circle-o"></i>Enquirey Form </a></li>
      <li><a href="<?=site_url()?>Admin/CertificateRequest"><i class="fa fa-circle-o"></i>Certificate Request</a></li>
      <li><a href="<?=site_url()?>Admin/universityProforma"><i class="fa fa-circle-o"></i>University Proforma</a></li>
    </ul>
   </div>
   <!--End sidebar-wrapper-->
