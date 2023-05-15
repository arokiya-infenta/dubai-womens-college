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

$leaves = $this->db->where('leave_status','pending')->where('DATE_FORMAT(apply_date,"%m") >= '.date("m", strtotime("-1 months")).'')->where('emp_designation !=','30')->get('wy_leaves')->result();

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
				$emp_name = $this->db->where('id',$leave->emp_code)->get('erp_employee_master')->row();	 
					?>
				<p><span class="leav">Staff Name: </span><?=$emp_name->emp_name_?></p>
                  <p><span class="leav">Leave Type: </span><?=$leave->leave_type?></p><hr><br>
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
