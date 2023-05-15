<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	
			
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Student Search</div>
            <div class="card-body">
			
    <form action="<?=base_url().'admin/studentSearch'?>" method="post">	
			<div class="row">
			<div class="col-md-3">
			<select class="form-control" name="course">
			<option value="1" <?php if($course==1){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($course==2){echo 'selected';}?>>PG</option>
			<option value="3" <?php if($course==3){echo 'selected';}?>>PG Diploma</option>
			</select>
			</div>
			<div class="col-md-4">
			<input class="form-control" type="text" name="searchres" value="<?php echo $searchres;?>" placeholder="Student Name/Application No/Ref ID" required>
			</div>
			<div class="col-md-3">
			<button type="submit" name="submit" class="btn btn-sm btn-success">Submit</button>
			</div>
			</div>
		</form>
			
            </div>
          </div>
        </div>
      </div>
	  
	<!--Results for UG -->
					<?php if(isset($studentsearch) && $course==1){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($studentsearch as $key => $value) { ?>
                        <tr>
                        <th><?=$value->u_name?> </th>
                        <th><?=$value->u_mobile?></th>
                        <th><?=$value->u_email_id?></th>
                        <th><?=date("d-m-Y",strtotime($value->u_date))?></th>
                        <th>
                        
                        <a href="#">21<?=$value->u_id?></a>
                        </th>
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>View Info</th>
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
					<?php } ?>
					
<!--Results for PG -->
					<?php if(isset($studentsearch) && $course==2 && $searchres!=''){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="example3"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Candidate Name </th>
                       
                        <th>Application Number </th>
                        <th>Mobile</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
                        <th>Total Mark</th>
						<th>Interview Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
                        <th>Action</th>
                       
                       
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

                    foreach ($studentsearch as $key => $value) { 
                     if($value->main_course_id==2||$value->main_course_id==3){ 
                      switch ($value->applied_course_id) {
		
					case "1":
				$subject='MSW';
				$department='MSW Community Development';
					break;
					case "2":
						$subject='MSW';
						$department='MSW Medical & Psychiatric Social Work';
					break;
					case "3":
						$subject='MSW';
						$department='MSW Human Resource Management';
					break;
				
		
				  default:
				  $subject='MSW';
				  $department='';
				}
					 }
					 
					 if($value->main_course_id==1){ 
                      switch ($value->applied_course_id) {
		
					case "5":
		$subject='MAHRM';
		$department='M.A. Human Resource Management (SF)';
			break;
		    case "6":
				$subject='MAHRM';
				$department='M.A. Human Resource And Organization Development (SF)';
			break;
		    case "7":
				$subject='MASE';
				$department='M.A. Social Entrepreneurship (SF)';
			break;
			case "8":
				$subject='MADM';
				$department='M.A. Development Management (SF)';
			break;
			case "9":
				$subject='MSCCF';
				$department='M.Sc. Counselling Psychology (SF)';
			break;
			case "15":
				$subject='MSW';
				$department='M.S.W. Disability and Empowerment (SF)';
			break;

		  default:
		  $subject='MSW';
		  $department='';
				}
					 }
                      
                      
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
                      $total =  $cal + (float)$value->UG_two_percentage;
                      ?>
                        <tr>
                        <td><?=$s++?></td>
                        <td><a href="<?=base_url()?>Admin/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                     
                      <td><?=$value->UG_two_percentage?></td>
                      
                      
                      <td><?=$ma_emt?></td>
                    
                      <td><?= number_format((float)$total, 2, '.', '')?></td>
					  <td><?= $value->personal_mark?></td>
                      <td><?=$value->course_name?></td>
                      <td><?php if($value->pr_other_res =="Yes"){
echo $value->pr_other_special_reservation;

                      }else{
                        echo "No";
                      }?></td>
                      <td> <?php if($value->verified_status == 0){


echo"<p style='color: red'> Not Verified </p>";

                        }else{

                          echo"<p style='color: green'>Verified By : ".  $dep[$value->verified_by_user]."</p>";


                        } ?> </td>
                        <td>
                        
                        <!--<a   class="btn btn-sm btn-primary" href="<?=base_url()?>Admin/updateStudent/<?=$value->u_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->u_id?>" name="stu_id">
						<a href="<?=base_url()?>Admin/updateStuContactInfo/<?=$value->u_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>-->
						<a href="<?=base_url()?>Admin/studentSearchPdf/<?=$value->u_id?>/<?=$value->applied_course_id?>/<?=$value->main_course_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
            <!--<a href="<?=base_url()?>Admin/studentCertificate/<?=$value->u_id?>" class="btn btn-sm btn-info"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>Admin/SendPersenalEmail/<?=$value->u_id?>"  class="btn btn-sm btn-dark"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>-->
                      
                      
                      
                        </td>
                       
                       
                    </tr>









                    <?php } ?>
                 
               
                </tbody>
                <!--<tfoot>
                <tr>
                        <th>Candidate Name </th>
                        <th>Application Number </th>
                        <th>Mobile</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
                      
                        <th>Total Mark</th>
						<th>Interview Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
                    </tr>
                </tfoot>-->
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
					<?php } ?>
					
	<!--Results for PG-Diploma -->
					<?php if(isset($studentsearch) && $course==3){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($student as $key => $value) { ?>
                        <tr>
                        <th><?=$value->u_name?> </th>
                        <th><?=$value->u_mobile?></th>
                        <th><?=$value->u_email_id?></th>
                        <th><?=date("d-m-Y",strtotime($value->u_date))?></th>
                        <th>
                        
                        <a href="#">21<?=$value->u_id?></a>
                        </th>
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>View Info</th>
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
					<?php } ?>				
				<!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    