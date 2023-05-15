<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
      
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

$alloc = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",1)->where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get();


$al =$alloc->num_rows();// $this->db->where($where);


?><div class="row mt-3">
<!--<div class="col-12 col-lg-6 col-xl-6  col-md-6">
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-success"><?=$al?></h4>
                <span>Total  Applications</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-pie-chart text-white"></i></div>
            </div>
            </div>
          </div>
        </div>-->
      <!--  <div class="col-12 col-lg-6 col-xl-6 col-md-6">
				<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$als?></h4>
                <span>Total  student Wrote Exam </span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
        </div>-->
        <?php 

//$where = '(pr_course_1="'.$res->cs_id.'" or pr_course_2 = "'.$res->cs_id.'" or pr_course_3="'.$res->cs_id.'")';

//print_r($_SESSION);
$appt = $this->db->select('*')->from('Applyed_Cources')->where("main_course_id",1)->get();


$applied_stu = $appt->result_array();

$arr = array_column($applied_stu, "user_id");
if( sizeof($arr) == 0 ){
$arr = array('0');}

$this->db->select('stu_user.*,Applyed_Cources.*,online_exam_pannel.*');
$this->db->from('stu_user');
$this->db->join('Applyed_Cources', 'stu_user.u_id=Applyed_Cources.user_id');
$this->db->join('online_exam_pannel', 'stu_user.u_id=online_exam_pannel.student_id');
$this->db->where('Applyed_Cources.main_course_id',1);
$this->db->where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status']);
$this->db->where('online_exam_pannel.exam_category',$this->Subject);
$this->db->where('Applyed_Cources.applied_date >=',$this->asyear);
$this->db->where('Applyed_Cources.applied_date <',$this->aeyear);
$this->db->where_in("u_id",$arr);
$stm =	$this->db->get();

$als = $stm->num_rows();

?>
         
				<?php 






$data["tot_stu"] = $tot_stu = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id","left")->Where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->Where("Applyed_Cources.main_course_id",1)->Where("online_exam_pannel.exam_category",$this->Subject)->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get()->num_rows();
				
 $data["eligible"] = $eligible = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id")->Where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->Where("Applyed_Cources.main_course_id",1)->Where("online_exam_pannel.exam_category",$this->Subject)->Where("online_exam_pannel.total_mark != 0")->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get()->num_rows();
 
 $data["not_eligible"] = $tot_stu - $eligible;
 
 
  $data["alloted"] = $this->db
             ->query(
                 'select student_id from zoom_alloc where alc_by="' .
                     $this->session->userdata('user')['user_id'] .
                     '" and main_course_id="1" and app_course_id="' .
                     $this->session->userdata('user')['user_dep_status'] .
                     '" and link_id=0 and type="panel" and created_at > "'.$this->asyear.'"and created_at <  "'.$this->aeyear.'"' 
             )
             ->num_rows(); 
 


						 $tot_sl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",31)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("created >",$this->asyear)->where("created <",$this->aeyear)->get();
						 $data["sl_tot"] = $tot_sl->num_rows();
						 
						 
						 
						 $sl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",1)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",1)->where("created >",$this->asyear)->where("created <",$this->aeyear)->get();
						 $data["sl_cou"] = $sl->num_rows();
						 
						 
						 
						 $wl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",1)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",2)->where("created >",$this->asyear)->where("created <",$this->aeyear)->get();
						 $data["wl_cou"] = $wl->num_rows();
						 
						 
						 $rl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",1)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",3)->where("created >",$this->asyear)->where("created <",$this->aeyear)->get();
						 $data["rl_cou"] = $rl->num_rows();
	
	
						 if($this->session->userdata("user")["user_dep_status"] == 5){


							$dep ="MAHRM";
					}else if($this->session->userdata("user")["user_dep_status"] == 6){
			
							$dep ="MAHROD";
					}else if($this->session->userdata("user")["user_dep_status"] == 8){
			
						$dep ="MADM";
				}else if($this->session->userdata("user")["user_dep_status"] == 7){
			
					$dep ="MASE";
			}else if($this->session->userdata("user")["user_dep_status"] == 9){
			
				$dep ="MSC";
		}else if($this->session->userdata("user")["user_dep_status"] == 15){
	
					$dep="MSWDE";
	
		}else if($this->session->userdata("user")["user_dep_status"] == 16){
	
					$dep="MSCCFT";
	
		}
			
			
			$admitted = $this->db->select("*")->from("admitted_student")->where("as_dep",	$dep)->where("year",date('Y',strtotime($this->asyear)))->get();
			
			
			
			$data["ad_stu"]= $admitted->num_rows();
	
					


            // print_r($data);



//exit;



?>
        <!--<div class="col-12 col-lg-6 col-xl-4">
        <?php 




/* 

$data["tot_stu"] = $tot_stu = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id","left")->Where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->Where("Applyed_Cources.main_course_id",2)->Where("online_exam_pannel.exam_category",$this->Subject)->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get()->num_rows();
				
 $data["eligible"] = $eligible = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id")->Where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->Where("Applyed_Cources.main_course_id",2)->Where("online_exam_pannel.exam_category",$this->Subject)->Where("online_exam_pannel.total_mark != 0")->where('Applyed_Cources.applied_date >=',$this->asyear)->where('Applyed_Cources.applied_date <',$this->aeyear)->get()->num_rows();
 
 $data["not_eligible"] = $tot_stu - $eligible;
 
 
   $data["alloted"] = $this->db
             ->query(
                 'select student_id from zoom_alloc where alc_by="' .
                     $this->session->userdata('user')['user_id'] .
                     '" and main_course_id="1" and app_course_id="' .
                     $this->session->userdata('user')['user_dep_status'] .
                     '" and link_id=0 and type="panel" and ' 
             )
             ->num_rows(); 
 

             print_r($data);
echo 


exit;
 */


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
        </div>-->

     
      </div><!--End Row-->
		  
		  
			<div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-6  col-md-6">

			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$al?></h4>
                <span>Total No. Of Applications Received</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">
			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$als?></h4>
                <span>Total No. Of Candidates appeared for Entrance Test</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			</div>


			<div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-6  col-md-6">

			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$data["eligible"]?></h4>
                <span>Total No. Of Candidates Eligible for Interview</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">
			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?=$data["not_eligible"]?></h4>
                <span>Total No. Of Candidates Not Eligible for Interview</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			</div>


			<div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-6  col-md-6">

			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?= $data["alloted"]?></h4>
                <span>Total No. Of Candidates Shortlisted for Interview</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">
			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?= $data["sl_cou"]?></h4>
                <span>Total No. Of Candidates Selected</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			</div>


			<div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-6  col-md-6">

			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?= $data["wl_cou"]?></h4>
                <span>Total No. Of Candidates Waitlisted</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">

			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?= $data["rl_cou"]?></h4>
                <span>Total No. Of Candidates Not Eligible</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div>

			</div>	<div class="row mt-3">
      
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">
			<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?= $data["ad_stu"]?></h4>
                <span>Total No. Of Candidates Admitted</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
			</div
			<div class="col-12 col-lg-6 col-xl-6  col-md-6">
		<!--	<div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info">56</h4>
                <span></span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>-->
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
