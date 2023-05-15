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
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example6" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name 
                        <input type="hidden" class="course" data-main="<?=$applied[0]->main_course_id?>" data-app="<?=$applied[0]->applied_course_id?>">		
						</th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applied as $key => $value) { ?>
                        <tr>
                        <td><?=$value->u_name?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->u_date))?></td>
                        <td>
                        
                        <a href="#"><?=date('y',strtotime($value->u_year."-04-01"))?><?=$value->u_id?></a>
                        </td>
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                    
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
<?php if(isset($applied) && $course==2){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example4"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Candidate Name </th>
                       
                        <th>Application Number </th>
                        <th>Mobile</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
						<th>Interview Mark</th>
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
                      <!--  <th>UG Per</th> -->
                      
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
                      $total =  $cal + (float)$value->UG_two_percentage + (float)$per_mark;
                      ?>
                        <tr>
                        <td><?=$s++?> 
						<input type="hidden" class="course" data-main="<?=$value->main_course_id?>" data-app="<?=$value->applied_course_id?>">
						</td>
                        <td><a href="<?=base_url()?>Admin/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                        <td><?=$value->u_mobile?></td>
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
                      <td> <?php if($value->verified_status == 0){


echo"<p style='color: red'> Not Verified </p>";

                        }else{

                          echo"<p style='color: green'>Verified By : ".  $dep[$value->verified_by_user]."</p>";


                        } ?> </td>
                        <td>
                        
                        <a   class="btn btn-sm btn-primary" href="<?=base_url()?>Admin/updateStudent/<?=$value->u_id?>/<?=$value->applied_course_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->u_id?>" name="stu_id">
					<!--	<button type="submit" name="submit_pdf" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></button>-->
						<a href="<?=base_url()?>Admin/updateStuContactInfo/<?=$value->u_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>
						<a href="<?=base_url()?>Admin/studentPdf/<?=$value->u_id?>/<?=$value->applied_course_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>Admin/studentCertificate/<?=$value->u_id?>" class="btn btn-sm btn-info"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a>
          <!--  <a href="<?=base_url()?>Admin/UpdateMarkPercentage/<?=$value->u_id?>"  class="btn btn-sm btn-warning"><i class="fa fa-percent fa-2x" aria-hidden="true"></i></a>-->
            <a href="#" data-toggle="modal" data-target="#exampleMail<?=$value->u_id?>" class="btn btn-sm btn-dark"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
            <a href="#" data-toggle="modal" data-target="#photo<?=$value->u_id?>" class="btn btn-sm btn-warning"><i class="fa fa-file-image-o  fa-2x" aria-hidden="true"></i>
</i></a>
                      
                      
                      
                        </td>
                       
                       
                    </tr>

					
<div class="modal fade" id="photo<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>admin/photoUpdate" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type ="hidden" name="student_id" value="<?=$value->u_id?>">
      <input type ="hidden" name="maincourse_id" value="<?=$this->uri->segment(3)?>">
      <input type ="hidden" name="appcourse_id" value="<?=$this->uri->segment(4)?>">
      <input type ="hidden" name="m_id" value="<?=$value->pr_id?>">
      <input type ="hidden" name="photo_name" value="<?=$value->pr_photo?>">
         
            <label for="recipient-name" class="col-form-label">Photo</label><br>
           
           <div class="row"> <div class="col-md-4"></div>
            <div class="col-md-4">
            <img src="<?=base_url()?>uploads/<?=$value->pr_photo?>" alt=""style="width: 300px;height: 420px;">
            </div>
            <div class="col-md-4">

            </div>
            </div>
          <div class="form-group">
     
  <label class="col-form-label " required for="recipient-name">Upload </label>
  
  <div class="col-md-12">
  <input type ="file" class="form-control" name="student_photo" value="student_photo">
   
  </div>
  <br>
  <br>
  <br>
  <div class="col-md-12">
  <a class="btn btn-danger" href="<?=base_url()?>Admin/downloadPhoto/<?=$value->pr_applicant_name?>/<?=$value->pr_photo?>">Download</a>
   
  </div>
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload Photo</button>
        
      </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="exampleMail<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>admin/personalMailUser">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Personal Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type ="hidden" name="student_id" value="<?=$value->u_id?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email Subject</label>
            <input type="text" class="form-control" name="email_subject" required id="recipient-name">
          </div>
          <div class="form-group">
        <input type ="hidden" name="student_id" value="<?=$value->u_id?>">
  <label class="col-form-label " required for="recipient-name">Email Content </label>
  <div class="col-md-12">
 <textarea  class="form-control" required name="email_content"></textarea>
   
  </div>
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        
      </div>
      </form>
    </div>
  </div>
</div>


                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
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
                      
						<th>Interview Mark</th>
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
   <?php } ?>
   
   <!--Results for PG-Diploma -->
	<?php if(isset($applied) && $course==3){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example6" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name 
						<input type="hidden" class="course" data-main="<?=$applied[0]->main_course_id?>" data-app="<?=$applied[0]->applied_course_id?>">
						</th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { ?>
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
				


    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    