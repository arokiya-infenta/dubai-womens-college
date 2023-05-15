<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Application Details  <?=$this->session->userdata('user')['user_name']?></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                    <th>Candidate Name </th>
										<th>Ref. No </th>
                        <th>Application Number </th>
                       
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email Id</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                       
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Reservation  Status</th>
                        <th>Board</th>
                    
												<th>Selection Status</th>
                      
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($student as $key => $value) { 
											
											
											
											
											
											
if($value->reservation_status ==1){

	$reslv = "Selection List";
}else if($value->reservation_status ==2){
	$reslv = "Waiting List";

}else if($value->reservation_status ==3){

		$reslv = "Rejection List";
}else{

		$reslv = "Not Selected";
}

											
											
											
											?>
                        <tr>
                  <?php 
                  
                  

                  $this->db->select('*');
                
                  $this->db->from('verified_ug');
                  $this->db->Where('stu_id',$value->u_id);
                  $this->db->Where('main_id',5);
                  $this->db->Where('applied_id',$this->session->userdata("user")["user_dep_status"]);
                 
                $ver_s=  $this->db->get();

                $ver = $ver_s->num_rows();
                
                if($ver >0){
$status = "<p style='color:green'>Verified</p>";


                }else{

                  $status = "<p style='color:red'>Not Verified</p>";


                }
                
                
                $this->db->select_sum('ug_mark_obtained');
                
                  $this->db->from('sub_preview_ug_main_sub');
                  $this->db->Where('student_id',$value->u_id);
                 
                $nt=  $this->db->get();

                  $this->db->select('*');
                
                  $this->db->from('sub_preview_ug_main_sub');
                  $this->db->Where('student_id',$value->u_id);
                 
                $nts=  $this->db->get();


$tot = $nt->result();
 $tot_sub = $nts->num_rows();


if($tot_sub > 0){
//print_r($tot);
number_format((float)$total= (($tot[0]->ug_mark_obtained * $value->ug_max_mark)/($tot_sub * 100)), 2, '.', '');

}else{
  $total=00.0;



}
                      ?>
                       
                       
                        <td><a href="#"><?=strtoupper($value->pr_applicant_name)?> </a></td>
												<td><?=date('y',strtotime($value->u_year."-01-01",)).$value->u_id?></td>
                        <td><?=$value->application_number?></td>
                        <td><?=date("d-m-Y",strtotime($value->date))?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                        <td><?=number_format((float)$value->tot_percent, 2, '.', '')?></td>
                     
                    <!--  <td><?= number_format((float)$total, 2, '.', '')?></td>-->
                      <td><?= $status?></td>
                      <td><?php if($value->pr_other_res =="Yes"){
echo $value->pr_other_special_reservation;

                      }else{
                        echo "No";
                      }?></td>
                 <td><?=$value->pr_board_study?></td>
								 <td><?=$reslv?></td>
                        <td>
                        
                        <a   class="btn btn-sm btn-primary" href="<?=base_url()?>UgSelfFinance/updateStudent/<?=$value->u_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->u_id?>" name="stu_id">
					<!--	<button type="submit" name="submit_pdf" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></button>-->
						<a href="<?=base_url()?>UgSelfFinance/updateStuContactInfo/<?=$value->u_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>
						<a href="<?=base_url()?>UgSelfFinance/studentPdf/<?=$value->u_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>UgSelfFinance/studentCertificate/<?=$value->u_id?>" class="btn btn-sm btn-info"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a>
           
           <!-- data-toggle="modal" data-target="#exampleModal<?=$value->u_id?>" -->
            <a href="<?=base_url()?>UgSelfFinance/viewApplicationMark/<?=$value->u_id?>"  class="btn btn-sm btn-warning"><i class="fa fa-percent fa-2x" aria-hidden="true"></i></a>
            <a href="#" data-toggle="modal" data-target="#exampleMail<?=$value->u_id?>" class="btn btn-sm btn-dark"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
                      
                      
                      
                        </td>
                       
                       
                    </tr>
                    <div class="modal fade" id="exampleModal<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>UgSelfFinance/updatePGPer">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Mark and Community</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
        
          <div class="form-group">
        <input type ="hidden" name="student_id" value="<?=$value->u_id?>">
  <label class="col-form-label " required for="recipient-name">Community </label>
  <div class="col-md-12">
  <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="OC"){echo"checked";} ?> value="OC" > OC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
    </label> 
    
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="MBC(V)"){echo"checked";} ?> value="MBC(V)" > MBC(V)
    </label>  
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="MBC"){echo"checked";} ?> value="MBC" > MBC
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="SC"){echo"checked";} ?> value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($value->pr_community=="ST"){echo"checked";} ?> value="ST" > ST
    </label>
    
   
  </div>
  </div>

            <label for="recipient-name" class="col-form-label">Community Certificate:</label>
           
<?php if($value->pr_comunity_cert !="" || $value->pr_comunity_cert !=NULL){ ?>


<?php

echo "<br><a target='_blank'  href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($value->pr_comunity_cert)."'>Download Certificate</a>";
echo "<br><a target='_blank'  href='".base_url()."uploads/".$value->pr_comunity_cert."'>View Certificate</a>";


?>

<?php }else{


echo"Not Uploded";



} ?>  

<br>
<label class="col-form-label " required for="recipient-name">Mark Details</label>
<label for="recipient-name" class="col-form-label">+2 Certificate:</label>
           
           <?php if($value->pr_provisional_mark_sheet !="" || $value->pr_provisional_mark_sheet !=NULL){ ?>
           
           
           <?php
           
           echo "<br><a target='_blank'  href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($value->pr_provisional_mark_sheet)."'>Download Certificate</a>";
           echo "<br><a target='_blank'  href='".base_url()."uploads/".$value->pr_provisional_mark_sheet
           ."'>View Certificate</a>";
           
           
           ?>
           
           <?php }else{
           
           
           echo"Not Uploded";
           
           
           
           } ?> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleMail<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>UgSelfFinance/personalMailUser">
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
        <button type="submit" class="btn btn-primary">Email User</button>
        
      </div>
      </form>
    </div>
  </div>
</div>

                
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>Candidate Name </th>
								<th>Ref. No </th>
                        <th>Application Number </th>
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email Id</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                      
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Reservation  Status</th>
												<th>Board</th>
												<th>Selection Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
