<?php
$page_name = $this->uri->segment(2);

$userData=$this->session->userdata('user')['user_id'];
$attendanceSQL = $this->db->query("SELECT * FROM `wy_attendance` WHERE `emp_code` = '" . $userData . "' AND `attendance_date` = '" . date('Y-m-d') . "'");
if ( $attendanceSQL ) {
	$attendanceROW = $attendanceSQL->num_rows();
	if ( $attendanceROW == 0 ) {
		$action_name = 'Punch In';
	} else {
		$attendanceDATA = $attendanceSQL->row();
		if ( $attendanceDATA->action_name == 'punchin' ) {
			$action_name = 'Punch Out';
		} else {
			$action_name = 'Punch In';
		}
	}
} else {
	$attendanceROW = 0;
	$action_name = 'Punch In';
} ?>  
  <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="#">
       <img src="https://admission.mssw.in/admin/white-version/assets/images/th.jpg" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">
	   ERP
	   </h5>
     </a>
	 </div>
	 <?php if ( $this->session->userdata('user')['user_designation'] != 27 ) { ?>
			<?php if ( $attendanceROW < 2 ) { ?>
				<form method="POST" class="employee sidebar-form" role="form" id="attendance-form">
	                <div class="input-group">
	                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Comment (if any)" />
	                    <span class="input-group-btn">
	                    	<button type="submit" id="action_btn" class="btn btn-warning" style="height:38px;"><?php echo $action_name; ?></button>
	                    </span>
	                </div>
	            </form>
	        <?php } ?>
	    <?php } ?>
	 <ul class="sidebar-menu do-nicescrol">
     
    
    
      <li><a href="<?=site_url()?>Employee" class="waves-effect"><i class="icon-home"></i><span>Dashboard</span></a></li>
      <li><a href="<?=site_url()?>Employee/updatePassword" class="waves-effect"><i class="icon-home"></i><span>Update Password</span></a></li>
	  <?php $user_id=$this->session->userdata('user')['user_id']; 
	  $user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
	  if($user->emp_designation_==12){?>
      <li><a href="<?=site_url()?>Employee/allocateSubject" class="waves-effect"><i class="icon-home"></i><span>Allocate Subject</span></a></li>
	  <?php } ?>
	  
	  <li>
        <a href="#" class="waves-effect">
          <i class="fa fa-file-o"></i> <span class="font" style="font-size:14px!important;">Student Attendance</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?=site_url()?>Employee/stuAttendance"><i class="fa fa-circle-o"></i>Mark Attendance</a></li>
          <li><a href="<?=site_url()?>Employee/deleteAttendance"><i class="fa fa-circle-o"></i>Delete Attendance</a></li>
        </ul>
      </li>
	  
	  <li>
        <a href="#" class="waves-effect">
          <i class="fa fa-file-o"></i> <span class="font" style="font-size:14px!important;">Attendance Report</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?=site_url()?>Employee/attendanceReport"><i class="fa fa-circle-o"></i>Daily Report</a></li>
          <li><a href="<?=site_url()?>Employee/attendanceReportMonthwise"><i class="fa fa-circle-o"></i>Monthly Report</a></li>
          <li><a href="<?=site_url()?>Employee/consolidatedReport"><i class="fa fa-circle-o"></i>Consolidated Report</a></li>
        </ul>
      </li>
	  
	   <li>
        <a href="#" class="waves-effect">
          <i class="fa fa-file-o"></i> <span class="font" style="font-size:14px!important;">ICA</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?=site_url()?>Employee/studentExamMarks"><i class="fa fa-circle-o"></i>ICA Marks Update</a></li>
          <li><a href="<?=site_url()?>Employee/icaReport"><i class="fa fa-circle-o"></i>ICA Report</a></li>
        </ul>
      </li>
	  
	  <li>
        <a href="#" class="waves-effect">
          <i class="fa fa-file-o"></i> <span class="font" style="font-size:14px!important;">Part V</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?=site_url()?>Employee/partvMarks"><i class="fa fa-circle-o"></i>Marks Update</a></li>
          <li><a href="<?=site_url()?>Employee/partvMarksReport"><i class="fa fa-circle-o"></i>Part V Report</a></li>
        </ul>
      </li>
	  
      <li><a href="<?=site_url()?>Employee/leaves" class="waves-effect"><i class="icon-home"></i><span>Leaves</span></a></li>
      <li><a href="<?=site_url()?>Employee/holidays" class="waves-effect"><i class="icon-home"></i><span>Holidays</span></a></li>
      <li><a href="<?=site_url()?>Employee/salaries" class="waves-effect"><i class="icon-home"></i><span>Salaries</span></a></li>
      <li><a href="<?=site_url()?>Employee/iqac" class="waves-effect"><i class="icon-home"></i><span>IQAC</span></a></li>
    </ul>
	 
   </div>
   <!--End sidebar-wrapper-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>  
$(document).ready(function() { 
var baseurl = '<?php echo base_url();?>';
/* Attendance Form Submit Script Start */
if ( $('#attendance-form').length > 0 ) {
    $(document).on('submit', '#attendance-form', function(e) {
        e.preventDefault();
        
        var form = $(this);
        $.ajax({
            type     : "POST",
            dataType : "json",
            async    : true,
            cache    : false,
            url      : baseurl + "payrolllogin/ajax/AttendanceProcessHandler",
            data     : form.serialize(),
            success  : function(result) {
                if ( result.code == 0 ) {
					alert('Attendance Marked Successfully!');
                    form[0].reset();
                    $('#action_btn').text(result.next);
                    if ( result.complete == 2 ) {
                        form.remove();
                    }
                    $.notify({
                        icon: 'glyphicon glyphicon-ok-circle',
                        message: result.result,
                    },{
                        allow_dismiss: false,
                        type: "success",
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        z_index: 9999,
                    });
                } else {
                    $.notify({
                        icon: 'glyphicon glyphicon-remove-circle',
                        message: result.result,
                    },{
                        allow_dismiss: false,
                        type: "danger",
                        placement: {
                            from: "bottom",
                            align: "right"
                        },
                        z_index: 9999,
                    });
                }
            }
        });
    });
}
});
/* End of Script */
</script>
