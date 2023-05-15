<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

					<!--Results for UG -->
					<?php if(isset($applied) && $course==1){ ?>

					<?php } ?>
					
<!--Results for PG -->
<?php if(isset($applied) && $course==2){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exampleexport"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Candidate Name </th>
                       <th>Application Number </th>
											 <th>Mother tongue </th>
                       <th>Place Of Birth </th>
                     
                       <th>Nationality </th>
											
                       <th>Blood Group </th>
                       <th>Religion </th>
                       <th>Cast </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        <th>Community</th>
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
						            <th>Interview Mark</th>
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Address</th>
                        <th>Father Name</th>
                        <th>Father Designation </th>
                        <th>Father Salary</th>
                        <th>Father mail id</th>
                        <th>Father Contact number</th>
                        <th>Mother Name</th>
                        <th>Mother Designation </th>
                        <th>Mother Salary</th>
                        <th>Mother mail id</th>
                        <th>Mother Contact number</th>
                        <th>Photo</th>
                        <th>Download</th>
                       
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
                 $dep =array(
                   '4'=>"MSW-AIDED",
                   '5'=>"MSW-SF",
                   '6'=>"MAHRM",
                   '7'=>"MAHROD",
                   '10'=>"MSCCF",
                   '8'=>"MADM",
                   '9'=>"MASE",
                   '11'=>"MSW DE",
                   '12'=>"MSW-AIDED",
                   '13'=>"MSW-AIDED",
                   '14'=>"MSW-SF",
                   '15'=>"MSW-SF",
                 );



                                   //   print_r($dep); 


                    $s=1;

                    foreach ($applied as $key => $value) { 
                      
                      
                      
                      
                    $ent =  $this->db->select("*")->from("online_exam_pannel")->Where("student_id",$value->u_id)->Where("exam_category",$subject)->get();
                      
                      $m = $ent->num_rows();
                      if($m > 0 ){

                          $mark  = $ent->result();
                          $ma_emt = $mark[0]->total_mark;
                          $cal = $mark[0]->total_mark;

                      }else{


                        $ma_emt = "A";
                        $cal = 0;
                      }
					  if($value->personal_mark=='A'){$per_mark=0;}else{$per_mark=$value->personal_mark;}
                      $total =  $cal + (float)$value->UG_two_percentage + $per_mark;
                      ?>
                        <tr>
                        <td><?=$s++?> 
						<input type="hidden" class="course" data-main="<?=$value->main_course_id?>" data-app="<?=$value->applied_course_id?>">
						</td>
                      
                        <td><a href="<?=base_url()?>Admin/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                      <td><?=$value->application_number?></td>
											<td><?=$value->pr_mother_toung?></td>
                      <td><?=$value->pr_place_of_birth?></td>
                      <td><?=$value->pr_nationality?></td>
                     
                      <td><?=$value->pr_blood_group?></td>
                      <td><?=$value->pr_religion?></td>
                      <td><?=$value->pr_caste?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                     
                      <td><?=$value->UG_two_percentage?></td>
                      
                      
                      <td><?=$ma_emt?></td>
                    
					  <td><?= $per_mark?></td>
                      <td><?= number_format((float)$total, 2, '.', '')?></td>
                      <td><?=$value->course_name?></td>
                      <td><?php if($value->pr_other_res =="Yes"){
echo $value->pr_other_special_reservation;

                      }else{
                        echo "No";
                      }?></td>
                      <td> <?=$value->pr_permanent_address?></td>
                      <td> <?=$value->pr_father_name?></td>
                      <td> <?=$value->pr_father_accu?></td>
                      <td> <?=$value->pr_father_anuval_income?></td>
                      <td> <?=$value->pr_father_mobnum?></td>
                      <td> <?=$value->pr_father_email?></td>
                      <td> <?=$value->pr_mother_name?></td>
                      <td> <?=$value->pr_mother_accu?></td>
                      <td> <?=$value->pr_mother_anuval_income?></td>
                      <td> <?=$value->pr_mother_mobnum?></td>
                      <td> <?=$value->pr_mother_email?></td>
                      <td>  <img src="<?=base_url()?>uploads/<?=$value->pr_photo?>" alt="Student Photo" width="100" height="120"> </td>
                      <td>  <a href="<?=base_url()?>Admin/downloadPhoto/<?=$value->pr_applicant_name?>/<?=$value->pr_photo?>">Download</a> </td>
                    
                       
                       
                    </tr>

	                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                        <th>Candidate Name </th>
                       <th>Application Number </th>
											 <th>Mother tongue </th>
                       <th>Place Of Birth </th>
                     
                       <th>Nationality </th>
											
                       <th>Blood Group </th>
                       <th>Religion </th>
                       <th>Cast </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        <th>Community</th>
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
						            <th>Interview Mark</th>
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>

                        <th>Address</th>
                        <th>Father Name</th>
                        <th>Father Designation </th>
                        <th>Father Salary</th>
                        <th>Father mail id</th>
                        <th>Father Contact number</th>
                        <th>Mother Name</th>
                        <th>Mother Designation </th>
                        <th>Mother Salary</th>
                        <th>Mother mail id</th>
                        <th>Mother Contact number</th>
                        <th>Photo</th>
                        <th>Download</th>
                       
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
   <?php } ?>
   
 		
			

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    