<style>
span.dash{
	font-size: 16px;
	font-weight: bold;
}
p.leav{
	font-size: 16px;
	font-weight: bold;
}
span.leav{
	font-size: 16px;
	font-weight: bold;
}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      <div class="row mt-3">
        <div class="col-12 col-lg-12 col-xl-12">

        <?php 

$subjects = $this->db->where('employee_id',$user_id)->get('erp_employee_subject')->result();


?>
         
        </div>
        <div class="col-12 col-lg-12 col-xl-12">
        <?php 

$leaves = $this->db->where('emp_code',$user_id)->where('DATE_FORMAT(apply_date,"%m") >= '.date("m", strtotime("-1 months")).'')->get('wy_leaves')->result();

?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger">Leave Notifications</h4>
                <?php foreach($leaves as $leave){
                 $lea_date = explode(',',$leave->leave_dates);
				 $count = 0;
				 foreach($lea_date as $lea_date){
				 if(date('Y-m-d',strtotime($lea_date)) >= date('Y-m-d')){
				 $count = $count + 1;}}
				 if($count > 0){
					 if($leave->leave_status=='approve'){$stat='<span style="color:green;">Approved</span>';}
					 elseif($leave->leave_status=='reject'){$stat='<span style="color:red;">Rejected</span>';}
					 else{$stat='<span style="color:blue;">Pending</span>';}
					?>
                  <p class="leav"><?=$leave->leave_type?>: </p>
				  <p><?=$leave->leave_message?></p>
				  <p><span class="leav">Approve Status: <?=$stat?></span></p><br>
				<?php }} ?>
              </div>
            </div>
            </div>
          </div>
        </div>
     
      </div>
     
       <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    
   .ls-view {
    float: right;
    color: black;
}
    </style>
