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
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>


                        <th>Community</th>

                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>
                        <th>Total Mark</th>
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
                      '16'=>"MSCCF",
                    );



                                   //   print_r($dep);




                    foreach ($student as $key => $value) {



											$de_Pt = "";



if($this->session->userdata('user')['user_id'] == 15){
      
	$de_Pt="MSW";

}

else if($this->session->userdata('user')['user_id'] == 5){

	$de_Pt="MAHRM";

}else if($this->session->userdata('user')['user_id'] == 6){

	$de_Pt="MAHRM";

} 

else if($this->session->userdata('user')['user_id'] == 7){

	$de_Pt="MASE";

}else if($this->session->userdata('user')['user_id'] == 8){

	$de_Pt="MADM";

}

else if($this->session->userdata('user')['user_id'] == 9){

	$de_Pt="MSCCF";

}   else if($this->session->userdata('user')['user_id'] == 16){

	$de_Pt="MSCCF";

} 



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
                        <td><a href="<?=base_url()?>PgSelfFinance/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                        <td><?=date("d-m-Y",strtotime($value->date))?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>

                      <td><?=$value->UG_two_percentage?></td>



                      <td><?=$ma_emt?></td>

                      <td><?= number_format((float)$total, 2, '.', '')?></td>
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

                        <a   class="btn btn-sm btn-primary" href="<?=base_url()?>PgSelfFinance/updateStudent/<?=$value->u_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->u_id?>" name="stu_id">
					<!--	<button type="submit" name="submit_pdf" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></button>-->
						<a href="<?=base_url()?>PgSelfFinance/updateStuContactInfo/<?=$value->u_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>
						<a href="<?=base_url()?>PgSelfFinance/studentPdf/<?=$value->u_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
            <a href="<?=base_url()?>PgSelfFinance/studentCertificate/<?=$value->u_id?>" class="btn btn-sm btn-info"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a>
            <a href="#" data-toggle="modal" data-target="#exampleModal<?=$value->u_id?>" class="btn btn-sm btn-warning"><i class="fa fa-percent fa-2x" aria-hidden="true"></i></a>
            <a href="#" data-toggle="modal" data-target="#exampleMail<?=$value->u_id?>" class="btn btn-sm btn-dark"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
						
						
						<?php 


$m = $this->db->select("*")->from("online_exam_video_tracker")->where("student_id",$value->u_id)->order_by("o_v_id","ASC")->get()->num_rows();



if($m > 0){
?>
						
						<a href="<?=base_url()?>CommonFunction/videoTracking/1/<?=$value->u_id?>" style="background-color: darkmagenta;" class="btn btn-sm"><i class="fa fa-file-video-o fa-2x" aria-hidden="true" style="color: azure;"></i></i></a>
<?php } ?>

                        </td>


                    </tr>




                    <div class="modal fade" id="exampleModal<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>PgSelfFinance/updatePGPer">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Mark and Community</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">UG Percentage:</label>
            <input type="text" class="form-control" name="ug_percentage" required id="recipient-name" value="<?=$value->UG_two_percentage?>">
          </div>
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

<?php if($value->pr_community_cer !="" || $value->pr_community_cer !=NULL){ ?>


<?php

echo "<br><a target='_blank'  href='".base_url()."PgSelfFinance/UploadFile?file=".urlencode($value->pr_community_cer)."'>Download Certificate</a>";
echo "<br><a target='_blank'  href='".base_url()."uploads/".$value->pr_community_cer."'>View Certificate</a>";


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
    <form method="post" action="<?=base_url()?>PgSelfFinance/personalMailUser">
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
                        <th>Candidate Name </th>
                        <th>Application Number </th>
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>


                        <th>Community</th>

                        <th>UG Percentage</th>
                        <th>Entrance Mark</th>

                        <th>Total Mark</th>
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
