<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      <div class="row mt-3">
        <div class="col-12 col-lg-6 col-xl-4">

        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$appt = $this->db->select('*')->from('stu_user')->get();


$ta =$appt->num_rows();// $this->db->where($where);


?>
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$ta?></h4>
                <span>Student Register </span>
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

$intr = $this->db->select('*')->from('Applyed_Master')->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$in?></h4>
                <span>Student Applied</span>
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

$alloc = $this->db->select('*')->from('Applyed_Cources')->get();


$al =$alloc->num_rows();// $this->db->where($where);


?>
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-success"><?=$al?></h4>
                <span>Total Course Applied</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-pie-chart text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
     
      </div><!--End Row-->
		  
		  
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">Applied SF Courses</div>
            <div class="card-body">

            <?php $cou = $this->db->select('*')->from('college_course')->where('mc_id',2)->where('cs_id !=',3)->where('cs_id !=',4)->get(); 
            
            
            $res = $cou->result();

            $mtsf =0;
            foreach($res as $res){
            

             // $where = '(cs_id !="'.$res->applied_course_id.'")';

              $s = $this->db->select('*')->from('Applyed_Cources')->where("applied_course_id",$res->cs_id)->get();

              
              $r =$s->num_rows();// $this->db->where($where);

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
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-info text-white">Applied MSW Aided Courses</div>
            <div class="card-body">
            <?php
            $tot_aid = 0;
                $aid = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",1)->get();
                $mswaid_1 =$aid->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text">Community Development<b class="ls-view"><?=$mswaid_1?></b></p>
              <?php
                $aid2 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",2)->get();
                $mswaid_2 =$aid2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text">Medical & Psychiatric Social Work<b class="ls-view"><?=$mswaid_2?></b></p>

              <?php
                $aid3 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",3)->get();
                $mswaid_3 =$aid3->num_rows();// $this->db->where($where);

                $tot_aid = $mswaid_1 + $mswaid_2 + $mswaid_3;
            ?>
              <p class="card-text">Human Resource Management<b class="ls-view"><?=$mswaid_3?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total MSW Aided  Courses :<b class="ls-view"> <?= $tot_aid?></b></p>
            </div>
          </div>
          </div>
          <div class="col-lg-6">
          
          <div class="card">
            <div class="card-header bg-primary text-white">Applied MSW SF Courses</div>
            <div class="card-body">
            <?php

                $tot_sf = 0;

                $sf = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",1)->get();
                $mswsf_1 =$sf->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text">Community Development<b class="ls-view"><?=$mswsf_1?></b></p>
              <?php
                $sf2 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",2)->get();
                $mswsf_2 =$sf2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text">Medical & Psychiatric Social Work<b class="ls-view"><?=$mswsf_2?></b></p>

              <?php
                $sf3 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",3)->get();
                $mswsf_3 =$sf3->num_rows();// $this->db->where($where);

                $tot_sf = $mswsf_1 + $mswsf_2 +$mswsf_3;
            ?>
              <p class="card-text">Human Resource Management<b class="ls-view"><?=$mswsf_3?></b></p>
          
          
          
            </div>
            <div class="card-footer">
            <p class="card-text"> Total MSW SF  Courses :<b class="ls-view"> <?= $tot_sf?></b></p>
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