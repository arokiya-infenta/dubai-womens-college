<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      <div class="row mt-3">
        <div class="col-12 col-lg-6 col-xl-4">

        <?php 

$working = $this->db->where('emp_working_status_','Working')->get('erp_employee_master')->num_rows();
$denied = $this->db->where('emp_working_status_','Denied')->get('erp_employee_master')->num_rows();


?>
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$working?></h4>
                <span>Working Employees</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-4">
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$denied?></h4>
                <span>Denied Employees</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-wallet text-white"></i></div>
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