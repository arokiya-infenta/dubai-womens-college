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
       <!-- <a class="btn btn-primary  float-right" href="<?=base_url()?>StudentDetails/downloadBulkPg/<?=$user_certificate[0]->student_id?>">Bulk Download Certificates</a>-->
        <br>
        <h4><?=$user[0]->pr_applicant_name?></h4>
             <div style="overflow-x:auto;">
             <form method = "post" action="<?=base_url()?>UgSelfFinance/certificateComments">
             <input type="hidden" name="user_id" value="<?=$user_certificate[0]->student_id?>">
                     <table class="table edu-tbl" width = "100%">

                     <?php  if($user[0]->pr_sslc_mark =="" || $user[0]->pr_sslc_mark ==Null){
echo"<tr><th>SSLC Mark Sheet</th><td>Not Uploaded</td><td><textarea name='stu_sslccert' class='form-control' >".$user_certificate[0]->stu_sslccert."</textarea></td></tr>";
                         }else{
     echo"<tr><th>SSLC Mark Sheet </th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_sslc_mark)."'>Download</a></td><td><textarea name='stu_sslccert' class='form-control' >".$user_certificate[0]->stu_sslccert."</textarea></td></tr>";
                         }  ?>


                          <?php  if($user[0]->pr_hse2_certificate =="" || $user[0]->pr_hse2_certificate ==Null){
echo"<tr><th>+2 Mark Sheet</th><td>Not Uploaded</td><td><textarea name='stu_hs_sec_certi' class='form-control' >".$user_certificate[0]->stu_hs_sec_certi."</textarea></td></tr>";
                         }else{
     echo"<tr><th>+2 Mark Sheet</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_hse2_certificate)."'>Download</a></td><td><textarea name='stu_hs_sec_certi' class='form-control' >".$user_certificate[0]->stu_hs_sec_certi."</textarea></td></tr>";
                         }  ?>
                          <?php  if($user[0]->pr_provisional_mark_sheet =="" || $user[0]->pr_provisional_mark_sheet ==Null){
echo"<tr><th>+2 Professional Mark Sheet</th><td>Not Uploaded</td><td><textarea name='stu_prof_cert_name' class='form-control' >".$user_certificate[0]->stu_prof_cert_name."</textarea></td></tr>";
                         }else{
     echo"<tr><th>+2 Professional Mark Sheet</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_provisional_mark_sheet)."'>Download</a></td><td><textarea name='stu_prof_cert_name' class='form-control' >".$user_certificate[0]->stu_prof_cert_name."</textarea></td></tr>";
                         }  ?>

                            <?php  if($user[0]->pr_comunity_cert =="" || $user[0]->pr_comunity_cert ==Null){
echo"<tr><th>Community Certificate</th><td>Not Uploaded</td><td><textarea name='stud_commcert' class='form-control' >".$user_certificate[0]->stud_commcert."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Community Certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_comunity_cert)."'>Download</a></td><td><textarea name='stud_commcert' class='form-control' >".$user_certificate[0]->stud_commcert."</textarea></td></tr>";
                         }  ?>

<?php  if($user[0]->pr_transfer_cert =="" || $user[0]->pr_transfer_cert ==Null){
echo"<tr><th>Transfer Certificate</th><td>Not Uploaded</td><td><textarea name='stud_transfer' class='form-control' >".$user_certificate[0]->stud_transfer."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Transfer Certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_transfer_cert)."'>Download</a></td><td><textarea name='stud_transfer' class='form-control' >".$user_certificate[0]->stud_transfer."</textarea></td></tr>";
                         }  ?>

<?php  if($user[0]->pr_conduct_certificate =="" || $user[0]->pr_conduct_certificate ==Null){
echo"<tr><th>Conduct Certificate</th><td>Not Uploaded</td><td><textarea name='stu_conduct_cert_name' class='form-control' >".$user_certificate[0]->stu_conduct_cert_name."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Conduct Certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_conduct_certificate)."'>Download</a></td><td><textarea name='stu_conduct_cert_name' class='form-control' >".$user_certificate[0]->stu_conduct_cert_name."</textarea></td></tr>";
                         }  ?>
                         
                         
                         <?php  if($user[0]->pr_eligibility_certificate =="" || $user[0]->pr_eligibility_certificate ==Null){
echo"<tr><th>Eligibility Certificate</th><td>Not Uploaded</td><td><textarea name='stu_elig_certi_name' class='form-control' >".$user_certificate[0]->stu_elig_certi_name."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Eligibility Certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_eligibility_certificate)."'>Download</a></td><td><textarea name='stu_elig_certi_name' class='form-control' >".$user_certificate[0]->stu_elig_certi_name."</textarea></td></tr>";
                         }  ?>
                         
                         <?php  if($user[0]->pr_migration_certificate =="" || $user[0]->pr_migration_certificate ==Null){
echo"<tr><th>Migration certificate</th><td>Not Uploaded</td><td><textarea name='stu_migrate_cert_name' class='form-control' >".$user_certificate[0]->stu_migrate_cert_name."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Migration certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_migration_certificate)."'>Download</a></td><td><textarea name='stu_migrate_cert_name' class='form-control' >".$user_certificate[0]->stu_migrate_cert_name."</textarea></td></tr>";
                         }  ?>

<?php /* if($user[0]->pr_migration_certificate =="" || $user[0]->pr_migration_certificate ==Null){
echo"<tr><th>Migration certificate</th><td>Not Uploaded</td><td><textarea name='pr_plus_two' class='form-control' >".$user_certificate[0]->stu_migrate_cert_name."</textarea></td></tr>";
                         }else{
     echo"<tr><th>Migration certificate</th><td><a target='_blank' href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($user[0]->pr_migration_certificate)."'>Download</a></td><td><textarea name='pr_plus_two' class='form-control' >".$user_certificate[0]->stu_migrate_cert_name."</textarea></td></tr>";
                         } */ ?>         


                  
                  </table>

<button type="submit">Comment </button>

</form>

     </div>
     </div>
     </div>
     </div>
     </div>
 
		