<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      <div class="row mt-3">
        <div class="col-12 col-lg-6 col-xl-4">

        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

//print_r($_SESSION);
$appt = $this->db->select('*')->from('stu_user')->where("u_course",1)->get();


$ta =$appt->num_rows();// $this->db->where($where);


?>
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$ta?></h4>
                <span>Total Registered student </span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-4">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('Applyed_Master')->where("main_course_priority","UG")->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$in?></h4>
                <span>Unique Student Applied</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-wallet text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-4">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$alloc = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",5)->where("applied_course_id",$this->session->userdata('user')['user_dep_status'])->get();


$al =$alloc->num_rows();// $this->db->where($where);


?>
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-success"><?=$al?></h4>
                <span>Total Courses Applied</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-pie-chart text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
     
      </div><!--End Row-->
		  
		  
      <!--<div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">Applied SF Courses</div>
            <div class="card-body">

            <?php $cou = $this->db->select('*')->from('college_course')->where('mc_id',1)->get(); 
            
            
            $res = $cou->result();

            $mtsf =0;
            foreach($res as $res){
     


              $s = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",5)->where("applied_course_id",$res->cs_id)->get();

              
              $r =$s->num_rows();

              $mtsf += $r;
            ?>
              <p class="card-text"><?=$res->cs_name?> <b class="ls-view"><?=$r?></b></p>



             <?php 
            }
             ?>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total Applied SF Courses :<b class="ls-view"> <?= $mtsf?></b></p>
      </div>
          </div>
        </div>
      
      
      </div>-->



     
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