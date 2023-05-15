<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

				<form action="" method="GET">
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
            <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Candidate Name </th>
                       
                        <th>Application Number </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
                        <th>Selection Status</th>
                      
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




                    foreach ($student as $key => $value) { 
                      
											if($value->reservation_status ==1){

												$reslv = "Selection List";
											}else if($value->reservation_status ==2){
												$reslv = "Waiting List";
											
											}else if($value->reservation_status ==3){
											
													$reslv = "Rejection List";
											}else{
											
													$reslv = "Not Selected";
											}
													
                      
                      
                    $ent =  $this->db->select("*")->from("online_exam_pannel")->Where("student_id",$value->u_id)->Where("exam_category",$this->Subject)->get();
                      
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
                        <td><a href="<?=base_url()?>PgMswAided/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                     
                      <td><?=$value->UG_two_percentage?></td>
                      
                      
                      <td><?=$ma_emt?></td>
                    
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
													<td><?=$reslv?></td>
                        <td>
                        
                        <a   class="btn btn-sm btn-primary" href="<?=base_url()?>PgMswAided/updateStudent/<?=$value->u_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->u_id?>" name="stu_id">
					<!--	<button type="submit" name="submit_pdf" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></button>-->
						<a href="<?=base_url()?>PgMswAided/updateStuContactInfo/<?=$value->u_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>
						<a href="<?=base_url()?>PgMswAided/studentPdf/<?=$value->u_id?>/<?=$value->applied_course_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>PgMswAided/studentCertificate/<?=$value->u_id?>" class="btn btn-sm btn-info"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>PgMswAided/UpdateMarkPercentage/<?=$value->u_id?>"  class="btn btn-sm btn-warning"><i class="fa fa-percent fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>PgMswAided/SendPersenalEmail/<?=$value->u_id?>"  class="btn btn-sm btn-dark"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
                      
                      
                      
                        </td>
                       
                       
                    </tr>









                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>Candidate Name </th>
                        <th>Application Number </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
                      
                        <th>Total Mark</th>
                        <th>Dept. & Specialization </th>
                        <th>Reservation  Status</th>
                        <th>Verified Status</th>
												<th>Selection Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
				</form><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    