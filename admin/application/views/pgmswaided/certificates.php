<div class="clearfix"></div>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	
  <div class="content-wrapper">
    <div class="container-fluid">
	<div class="profile-main">
		<div class="profile-header">
			<div class="user-detail">
						<div class="user-data">
				
         <!-- <a style="float:right;" target="_blank" href="<?=base_url()?>Home/downloadPdF" >Download PDF</a>-->
				</div>
			</div>		
     
     
     
     
        <h4><i class="fa fa-certificate" aria-hidden="true"></i> Certificates Details</h4>
      <!--  <label class="switch">
  <input type="checkbox">
  <span class="slider round"></span>
</label>-->
        <a class="btn btn-primary float-right" href="<?=base_url()?>StudentDetails/downloadBulkPg/<?=$user_certificate[0]->student_id?>">Bulk Download Certificates</a>
        <br>
        <h4><?=$user[0]->pr_applicant_name?></h4>
             <div style="overflow-x:auto;">
             <form method = "post" action="<?=base_url()?>PgMswAided/certificateComments">
             <input type="hidden" name="user_id" value="<?=$user_certificate[0]->student_id?>">
                     <table class="table edu-tbl" width = "100%">
                     <?php  if($user[0]->pr_sslc =="" || $user[0]->pr_sslc ==Null){
echo"<tr><th>SSLC Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_sslc' class='form-control' >".$user_certificate[0]->sslc_certificate."</textarea></td></tr>";
                         }else{
     echo"<tr><th>SSLC Mark Sheet Mark Sheet</th><td><a target='_blank' href='".base_url()."PgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_sslc)."'>Download</a></td><td><textarea name='pr_sslc' class='form-control' >".$user_certificate[0]->sslc_certificate."</textarea></td></tr>";
                         }  ?>


                          <?php  if($user[0]->pr_plus_one =="" || $user[0]->pr_plus_one ==Null){
echo"<tr><th>Plus One Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_plus_one' class='form-control' >".$user_certificate[0]->plus_one_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Plus One Mark Sheet</th><td><a target='_blank' href='".base_url()."PgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_plus_one)."'>Download</a></td><td><textarea name='pr_plus_one' class='form-control' >".$user_certificate[0]->plus_one_cer."</textarea></td></tr>";
                         }  ?>
                          <?php  if($user[0]->pr_plus_two =="" || $user[0]->pr_plus_two ==Null){
echo"<tr><th>Plus Two Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_plus_two' class='form-control' >".$user_certificate[0]->plus_two_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Plus Two Mark Sheet</th><td><a target='_blank' href='".base_url()."PgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_plus_two)."'>Download</a></td><td><textarea name='pr_plus_two' class='form-control' >".$user_certificate[0]->plus_two_cer."</textarea></td></tr>";
                         }  ?>

                     
                         <?php  if($user[0]->pr_semester_1 =="" || $user[0]->pr_semester_1 ==Null){
echo"<tr><th>Semester - I Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_1' class='form-control' >".$user_certificate[0]->pr_semester_1."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - I Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_1)."'>Download</a></td><td><textarea name='pr_semester_1' class='form-control' >".$user_certificate[0]->pr_semester_1."</textarea></td></tr>";
                         }  ?>

<?php  if($user[0]->pr_semester_2 =="" || $user[0]->pr_semester_2 ==Null){
echo"<tr><th>Semester - II Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_2' class='form-control' >".$user_certificate[0]->pr_semester_2."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - II Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_2)."'>Download</a></td><td><textarea name='pr_semester_2' class='form-control' >".$user_certificate[0]->pr_semester_2."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_3 =="" || $user[0]->pr_semester_3 ==Null){
echo"<tr><th>Semester - III Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_3' class='form-control' >".$user_certificate[0]->pr_semester_3."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - III Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_3)."'>Download</a></td><td><textarea name='pr_semester_3' class='form-control' >".$user_certificate[0]->pr_semester_3."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_4 =="" || $user[0]->pr_semester_4 ==Null){
echo"<tr><th>Semester - IV Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_4' class='form-control' >".$user_certificate[0]->pr_semester_4."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - IV Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_4)."'>Download</a></td><td><textarea name='pr_semester_4' class='form-control' >".$user_certificate[0]->pr_semester_4."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_5 =="" || $user[0]->pr_semester_5 ==Null){
echo"<tr><th>Semester - V Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_5' class='form-control' >".$user_certificate[0]->pr_semester_5."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - V Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_5)."'>Download</a></td><td><textarea name='pr_semester_5' class='form-control' >".$user_certificate[0]->pr_semester_5."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_6 =="" || $user[0]->pr_semester_6 ==Null){
echo"<tr><th>Semester - VI Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_6' class='form-control' >".$user_certificate[0]->pr_semester_6."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - VI Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_6)."'>Download</a></td><td><textarea name='pr_semester_6' class='form-control' >".$user_certificate[0]->pr_semester_6."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_7 =="" || $user[0]->pr_semester_7 ==Null){
echo"<tr><th>Semester - VIIMark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_7' class='form-control' >".$user_certificate[0]->pr_semester_7."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - VII Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_7)."'>Download</a></td><td><textarea name='pr_semester_7' class='form-control' >".$user_certificate[0]->pr_semester_7."</textarea></td></tr>";
                         }  ?>
                            <?php  if($user[0]->pr_semester_8 =="" || $user[0]->pr_semester_8 ==Null){
echo"<tr><th>Semester - VIII Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_semester_8' class='form-control' >".$user_certificate[0]->pr_semester_8."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Semester - VIII Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_semester_8)."'>Download</a></td><td><textarea name='pr_semester_8' class='form-control' >".$user_certificate[0]->pr_semester_8."</textarea></td></tr>";
                         }  ?>

<?php  if($user[0]->pr_provisional_pg_cer =="" || $user[0]->pr_provisional_pg_cer ==Null){
echo"<tr><th>Provisional UG Degree Certificate</th><td>Not Uploaded</td><td><textarea name='pr_provisional_pg_cer' class='form-control' >".$user_certificate[0]->pr_provisional_pg_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Provisional UG Degree Certificate</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_provisional_pg_cer)."'>Download</a></td><td><textarea name='pr_provisional_pg_cer' class='form-control' >".$user_certificate[0]->pr_provisional_pg_cer."</textarea></td></tr>";
                         }  ?>
  <?php  if($user[0]->pr_ug_cer =="" || $user[0]->pr_ug_cer ==Null){
echo"<tr><th>UG Degree Certificate</th><td>Not Uploaded</td><td><textarea name='pr_ug_cer' class='form-control' >".$user_certificate[0]->pr_ug_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>UG Degree Certificate</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_ug_cer)."'>Download</a></td><td><textarea name='pr_ug_cer' class='form-control' >".$user_certificate[0]->pr_ug_cer."</textarea></td></tr>";
                         }  ?>
  <?php  if($user[0]->pr_cummulative_cer =="" || $user[0]->pr_cummulative_cer ==Null){
echo"<tr><th>Cumulative Mark Sheet</th><td>Not Uploaded</td><td><textarea name='pr_cummulative_cer' class='form-control' >".$user_certificate[0]->pr_cummulative_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Cumulative Mark Sheet</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_cummulative_cer)."'>Download</a></td><td><textarea name='pr_cummulative_cer' class='form-control' >".$user_certificate[0]->pr_cummulative_cer."</textarea></td></tr>";
                         }  ?>
  <?php  if($user[0]->pr_community_cer =="" || $user[0]->pr_community_cer ==Null){
echo"<tr><th>Community Certificate</th><td>Not Uploaded</td><td><textarea name='pr_community_cer' class='form-control' >".$user_certificate[0]->pr_community_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Community Certificate</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_community_cer)."'>Download</a></td><td><textarea name='pr_community_cer' class='form-control' >".$user_certificate[0]->pr_community_cer."</textarea></td></tr>";
                         }  ?>
  <?php  if($user[0]->pr_conduct_cer =="" || $user[0]->pr_conduct_cer ==Null){
echo"<tr><th>Conduct Certificate</th><td>Not Uploaded</td><td><textarea name='pr_conduct_cer' class='form-control' >".$user_certificate[0]->pr_conduct_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Conduct Certificate</th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_conduct_cer)."'>Download</a></td><td><textarea name='pr_conduct_cer' class='form-control' >".$user_certificate[0]->pr_conduct_cer."</textarea></td></tr>";
                         }  ?>
  <?php  if($user[0]->pr_transfer_cer =="" || $user[0]->pr_transfer_cer ==Null){
echo"<tr><th>Transfer Certificate</th><td>Not Uploaded</td><td><textarea name='pr_transfer_cer' class='form-control' >".$user_certificate[0]->pr_transfer_cer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Transfer Certificate </th><td><a target='_blank' href='".base_url()."PgMswAided/UploadFile?file=".urlencode($user[0]->pr_transfer_cer)."'>Download</a></td><td><textarea name='pr_transfer_cer' class='form-control' >".$user_certificate[0]->pr_transfer_cer."</textarea></td></tr>";
                         }  ?>


<?php  if($user[0]->pr_abled_certificate =="" || $user[0]->pr_abled_certificate ==Null){
echo"<tr><th>Differently Abled</th><td>Not Uploaded</td><td><textarea name='pr_abled_certificate' class='form-control' >".$user_certificate[0]->abled_cert."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Differently Abled</th><td><a target='_blank' href='".base_url()."PgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_abled_certificate)."'>Download</a></td><td><textarea name='pr_abled_certificate' class='form-control' >".$user_certificate[0]->abled_cert."</textarea></td></tr>";
                         }  ?>




                  </table>

<button type="submit">Comment </button>

</form>

     </div>
     </div>
     </div>
     </div>
     </div>
 
     <style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #3bf80c;
}

input:focus + .slider {
  box-shadow: 0 0 1px #3bf80c;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>