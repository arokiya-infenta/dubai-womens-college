<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      <div class="row mt-3">
        <div class="col-12 col-lg-6 col-xl-3">

        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';


/* echo $this->asyear;
echo $this->aeyear; */


$appt = $this->db->select('*')->from('stu_user')->where("u_year ",date('Y',strtotime($this->asyear)))->get();


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
        <div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';


$intr = $this->db->select('*')->from('Applyed_Master')->where(
  "Applyed_Master.date >=",$this->asyear
 
)->where(
  "Applyed_Master.date <",$this->aeyear
 
)->get();


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
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';
$stu_not_appl = $ta - $in;


?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$stu_not_appl?></h4>
                <span>Student Not Applied</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-wallet text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';
//$this->db->where('Applyed_Cources.applied_date >=',$this->asyear);
//$this->db->where('Applyed_Cources.applied_date <',$this->aeyear);
$alloc = $this->db->select('*')->from('Applyed_Cources')->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get();


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
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

$intr = $this->db->select('*')->from('online_exam_pannel')->where(
  "online_exam_pannel.created_date >=",$this->asyear
 
)->where(
  "online_exam_pannel.created_date <",$this->aeyear
 
)->where('online_exam_pannel.completed_status',1)->get();


$in =$intr->num_rows();


?>
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-info"><?=$in?></h4>
                <span>Entrance Exam</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-user text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('student_complete_mark')->where('personal_mark !=','A or 0')->where('student_complete_mark.date >=',$this->asyear)->where('student_complete_mark.date  >=',$this->aeyear)->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$in?></h4>
                <span>Interview Total</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-user text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('shotlisted_candidate')->where('reservation_status','1')->where('created >=',$this->asyear)->where('created >=',$this->aeyear)->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-success"><?=$in?></h4>
                <span>Student Selected</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-user text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('shotlisted_candidate')->where('reservation_status','2')->where('created >=',$this->asyear)->where('created >=',$this->aeyear)->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-info"><?=$in?></h4>
                <span>Student Waiting List</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-user text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('shotlisted_candidate')->where('reservation_status','3')->where('created >=',$this->asyear)->where('created >=',$this->aeyear)->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?=$in?></h4>
                <span>Student Not Eligible</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-user text-white"></i></div>
            </div>
            </div>
          </div>
        </div>
		<div class="col-12 col-lg-6 col-xl-3">
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$intr = $this->db->select('*')->from('shotlisted_candidate')->where('principal_published','1')->where('created >=',$this->asyear)->where('created >=',$this->aeyear)->get();


$in =$intr->num_rows();// $this->db->where($where);


?>
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-success"><?=$in?></h4>
                <span>Principal Approved</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-user text-white"></i></div>
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

              $s = $this->db->select('*')->from('Applyed_Cources')->where("applied_course_id",$res->cs_id)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();

              
              $r =$s->num_rows();// $this->db->where($where);

              $mtsf += $r;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedCources/1/<?=$res->cs_id?>" ><?=$res->cs_name?></a> <b class="ls-view"><?=$r?></b></p>



             <?php 
            }
             ?>
			 <!-- Applied MSW SF Courses -->
			 <hr>
			 <p><b>Applied MSW SF Courses</b></p>
			 <?php

                $tot_sf = 0;

                $sf = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",1)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswsf_1 =$sf->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswSelfFinanceCources/3/1" >Community Development</a><b class="ls-view"><?=$mswsf_1?></b></p>
              <?php
                $sf2 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",2)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswsf_2 =$sf2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswSelfFinanceCources/3/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswsf_2?></b></p>

              <?php
                $sf3 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",3)->where("applied_course_id",3)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswsf_3 =$sf3->num_rows();// $this->db->where($where);

                $mtsf = $mtsf + $mswsf_1 + $mswsf_2 +$mswsf_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswSelfFinanceCources/3/3" >Human Resource Management</a><b class="ls-view"><?=$mswsf_3?></b></p>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total Applied SF Courses :<b class="ls-view"> <?= $mtsf?></b></p>
      </div>
          </div>
        </div>
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">Applied MSW Aided Courses</div>
            <div class="card-body">
            <?php
            $tot_aid = 0;
                $aid = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",1)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswaid_1 =$aid->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswAidedCources/2/1" >Community Development</a><b class="ls-view"><?=$mswaid_1?></b></p>
              <?php
                $aid2 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",2)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswaid_2 =$aid2->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswAidedCources/2/2" >Medical & Psychiatric Social Work</a><b class="ls-view"><?=$mswaid_2?></b></p>

              <?php
                $aid3 = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",2)->where("applied_course_id",3)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $mswaid_3 =$aid3->num_rows();// $this->db->where($where);

                $tot_aid = $mswaid_1 + $mswaid_2 + $mswaid_3;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedMswAidedCources/2/3" >Human Resource Management</a><b class="ls-view"><?=$mswaid_3?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total MSW Aided  Courses :<b class="ls-view"> <?= $tot_aid?></b></p>
            </div>
          </div>
          </div>
		  
          </div>
        </div>
      
      </div>
	  
	  
	  <!-- UG Courses -->
	  <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-warning text-white">UG Courses</div>
            <div class="card-body">
			 <?php

                $tot_ug = 0;

                $bsw = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",5)->where("applied_course_id",1)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $bsw_1 =$bsw->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedUgCources/5/1" >B.S.W (SF)</a><b class="ls-view"><?=$bsw_1?></b></p>
              <?php
                $bsc = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",5)->where("applied_course_id",2)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $bsc_1 =$bsc->num_rows();// $this->db->where($where);

                 $tot_ug = $bsw_1 + $bsc_1;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedUgCources/5/2" >B.Sc Psychology (SF)</a><b class="ls-view"><?=$bsc_1?></b></p>
            
            </div>
      <div class="card-footer">
      
      <p class="card-text"> Total UG Courses :<b class="ls-view"> <?= $tot_ug?></b></p>
      </div>
          </div>
        </div>
        <div class="col-lg-6">
        <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">PG-Diploma Courses</div>
            <div class="card-body">
            <?php
            $tot_ir = 0;
                $pgir = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",4)->where("applied_course_id",10)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $pgir_1 =$pgir->num_rows();// $this->db->where($where);


            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedPgDiplomaCources/4/10" >Personnel Management & Industrial Relations (SF)</a><b class="ls-view"><?=$pgir_1?></b></p>
              <?php
                $pghr = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",4)->where("applied_course_id",11)->where("applied_date > ",$this->asyear)->where("applied_date < ",$this->aeyear)->get();
                $pghr_1 =$pghr->num_rows();// $this->db->where($where);

                 $tot_pg_dip = $pgir_1 + $pghr_1;
            ?>
              <p class="card-text"><a href="<?=base_url()?>Admin/StudentAppliedPgDiplomaCources/4/11" >Human Resource Management (SF)</a><b class="ls-view"><?=$pghr_1?></b></p>
            </div>
            <div class="card-footer">
            <p class="card-text"> Total PG-Diploma  Courses :<b class="ls-view"> <?= $tot_pg_dip?></b></p>
            </div>
          </div>
          </div>
		  
          </div>
        </div>
      
      </div>
	  <!-- UG Courses Ends -->



     
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