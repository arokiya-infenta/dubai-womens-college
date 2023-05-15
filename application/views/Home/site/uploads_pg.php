<div class="section layout_padding padding_top padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>Update Your Certificates</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>

    <?php  $cert = $this->db->select("*")->from("Certificate_comments")->where("student_id",$this->session->userdata('user')['user_id'])->where("status",1)->get();
    
    
    $certcomm = $cert->num_rows();
    if( $certcomm > 0){


        $cert_comm = $cert->result();


if($cert_comm[0]->pr_semester_1 !="" || $cert_comm[0]->pr_semester_1 !=NULL){
    $sem_1 =$cert_comm[0]->pr_semester_1;
}else{
    $sem_1 ="";
} 
if($cert_comm[0]->pr_semester_2 !="" || $cert_comm[0]->pr_semester_2 !=NULL){
    $sem_2 =$cert_comm[0]->pr_semester_2;
}else{
    $sem_2 ="";
} 
if($cert_comm[0]->pr_semester_3 !="" || $cert_comm[0]->pr_semester_3 !=NULL){
    $sem_3 =$cert_comm[0]->pr_semester_3;
}else{
    $sem_3 ="";
}
if($cert_comm[0]->pr_semester_4 !="" || $cert_comm[0]->pr_semester_4 !=NULL){
    $sem_4 =$cert_comm[0]->pr_semester_4;
}else{
    $sem_4 ="";
}
if($cert_comm[0]->pr_semester_5 !="" || $cert_comm[0]->pr_semester_5 !=NULL){
    $sem_5 =$cert_comm[0]->pr_semester_5;
}else{
    $sem_5 ="";
}
if($cert_comm[0]->pr_semester_6 !="" || $cert_comm[0]->pr_semester_6 !=NULL){
    $sem_6 =$cert_comm[0]->pr_semester_6;
}else{
    $sem_6 ="";
}
if($cert_comm[0]->pr_semester_7 !="" || $cert_comm[0]->pr_semester_7 !=NULL){
    $sem_7 =$cert_comm[0]->pr_semester_7;
}else{
    $sem_7 ="";
} 
if($cert_comm[0]->pr_semester_8 !="" || $cert_comm[0]->pr_semester_8 !=NULL){
    $sem_8 =$cert_comm[0]->pr_semester_8;
}else{
    $sem_8 ="";
}
if($cert_comm[0]->pr_provisional_pg_cer !="" || $cert_comm[0]->pr_provisional_pg_cer !=NULL){
    $prv_cer =$cert_comm[0]->pr_provisional_pg_cer;
}else{
    $prv_cer ="";
}
if($cert_comm[0]->pr_ug_cer !="" || $cert_comm[0]->pr_ug_cer !=NULL){
    $ug_cer =$cert_comm[0]->pr_ug_cer;
}else{
    $ug_cer ="";
}
if($cert_comm[0]->pr_cummulative_cer !="" || $cert_comm[0]->pr_cummulative_cer !=NULL){
    $ug_cer_cum =$cert_comm[0]->pr_cummulative_cer;
}else{
    $ug_cer_cum ="";
} 
if($cert_comm[0]->pr_community_cer !="" || $cert_comm[0]->pr_community_cer !=NULL){
    $ug_cumm_cer =$cert_comm[0]->pr_community_cer;
}else{
    $ug_cumm_cer ="";
}    
if($cert_comm[0]->pr_conduct_cer !="" || $cert_comm[0]->pr_conduct_cer !=NULL){
    $ug_cond_cer =$cert_comm[0]->pr_conduct_cer;
}else{
    $ug_cond_cer ="";
}
if($cert_comm[0]->pr_transfer_cer !="" || $cert_comm[0]->pr_transfer_cer !=NULL){
    $ug_trans_cer =$cert_comm[0]->pr_transfer_cer;
}else{
    $ug_trans_cer ="";
}
if($cert_comm[0]->sslc_certificate !="" || $cert_comm[0]->sslc_certificate !=NULL){
    $sslc_cer =$cert_comm[0]->sslc_certificate;
}else{
    $sslc_cer ="";
}
if($cert_comm[0]->plus_one_cer !="" || $cert_comm[0]->plus_one_cer !=NULL){
    $plus_one =$cert_comm[0]->plus_one_cer;
}else{
    $plus_one ="";
} 
if($cert_comm[0]->plus_two_cer !="" || $cert_comm[0]->plus_two_cer !=NULL){
    $plus_two =$cert_comm[0]->plus_two_cer;
}else{
    $plus_two ="";
}
if($cert_comm[0]->abled_cert !="" || $cert_comm[0]->abled_cert !=NULL){
    $able_cer =$cert_comm[0]->abled_cert;
}else{
    $able_cer ="";
}   



//print_r($cert_comm);



    }else{

        $sem_1 =""; $sem_2 =""; $sem_3 =""; $sem_4 =""; $sem_5 ="";$sem_6 =""; $sem_7 =""; $sem_8 =""; $prv_cer ="";
        $ug_cer =""; $ug_cer_cum =""; $ug_cumm_cer =""; $ug_cond_cer ="";$ug_trans_cer ="";$sslc_cer ="";$plus_one ="";
        $plus_two ="";$able_cer ="";

    }
    
    ?>
    
    <form method="post"  action="<?=base_url()?>UploadCertificates/UpdateMyCertificatesPg" enctype="multipart/form-data">
<div id="cleared" class="section contact_section" style="background:#ffffff">
    <div class="container">
<div class="row">

<a class="btn btn-primary float-right" href="<?=base_url()?>admin/StudentDetails/downloadBulkPg/<?=$user[0]->pr_user_id?>">Bulk Download Certificates</a>
<!-- Basic Details --->
<div class="row">
 <div class=" col-md-12 stud-details">
<h5>Upload Certificates</h5> 
<div class="instruction">
<span class="required">Upload your certificates in JPEG or PDF format File size with in 1 mb (or) 1024Kb</span>
</div>

<div class="row form-group">
<div class="col-md-6">
<div class="row">
<div class="col-md-12">
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">SSLC Certificate </label><br>
<span class="required"><?= $sslc_cer ; ?></span>
</div>
<div class="col-md-5">

<input type="hidden" name="stu_pr_sslc" value="<?=$user[0]->pr_sslc?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_sslc"  value="<?=$user[0]->pr_sslc?>" class="form-control" > 
      
</div>
<div class="col-md-1">
<?php if($user[0]->pr_sslc !="" ||$user[0]->pr_sslc !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" data-toggle="Upload Failed" width ="20px" >

<a target='_blank' href='"<?=base_url()?>"Home/UploadFile?file="<?=urlencode($user[0]->pr_sslc)?>"'>Download</a>
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png"  data-toggle="Upload Success" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>
    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Hr.Sec (+1) Certificate</label> 
<br><span class="required"><?= $plus_one ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_plus_one" value="<?=$user[0]->pr_plus_one?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_plus_one"  value="<?=$user[0]->pr_plus_one?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_plus_one !="" ||$user[0]->pr_plus_one !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" data-toggle="Upload Failed" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png"  data-toggle="Upload Success" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>
    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Hr.Sec (+2) Certificate</label> 
<br><span class="required"><?= $plus_two ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_plus_two" value="<?=$user[0]->pr_plus_two?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_plus_two"  value="<?=$user[0]->pr_plus_two?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_plus_two !="" ||$user[0]->pr_plus_two !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" data-toggle="Upload Failed" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png"  data-toggle="Upload Success" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>


 
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - I Mark Sheet </label> 
<br><span class="required"><?= $sem_1 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_1" value="<?=$user[0]->pr_semester_1?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_semester_1"  value="<?=$user[0]->pr_semester_1?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_1 !="" ||$user[0]->pr_semester_1 !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" data-toggle="Upload Failed" width ="20px" >
<!--<a  href="<?=base_url()?>Home/UploadFile?file=<?=urlencode($user[0]->pr_semester_1)?>">Download</a>-->
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png"  data-toggle="Upload Success" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - II Mark Sheet </label>
<br><span class="required"><?= $sem_2 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_2" value="<?=$user[0]->pr_semester_2?>">
      <input type="file"   accept="image/jpeg,application/pdf"   
       name="pr_semester_2"  value="<?=$user[0]->pr_semester_2?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_2 !="" ||$user[0]->pr_semester_2 !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{ ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}   ?>
</div>
</div>
    </label>
	<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - III Mark Sheet </label>
<br><span class="required"><?= $sem_3 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_3" value="<?=$user[0]->pr_semester_3?>">

      <input type="file"  accept="image/jpeg,application/pdf"   name="pr_semester_3"  value="<?=$user[0]->pr_semester_3?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_3 !="" ||$user[0]->pr_semester_3 !=null){ ?>
  <img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}  else{ ?>
 <img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php 
} ?>
</div>
</div>
    </label>

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - IV Mark Sheet  </label> 
<br><span class="required"><?= $sem_4 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_4" value="<?=$user[0]->pr_semester_4?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_semester_4"  value="<?=$user[0]->pr_semester_4?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_4 !="" ||$user[0]->pr_semester_4 !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - V Mark Sheet </label>
<br><span class="required"><?= $sem_5 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_pr_semester_5" value="<?=$user[0]->pr_semester_5?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="pr_semester_5"  class="form-control"  value="<?=$user[0]->pr_semester_5?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_5 !="" ||$user[0]->pr_semester_5 !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>

		<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - VI Mark Sheet </label>
<br><span class="required"><?= $sem_6 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_pr_semester_6" value="<?=$user[0]->pr_semester_6?>">
      <input type="file"  accept="image/jpeg,application/pdf"  name="pr_semester_6"  class="form-control"  value="<?=$user[0]->pr_semester_6?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_6 !="" ||$user[0]->pr_semester_6 !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>


    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - VII Mark Sheet</label> 
<br><span class="required"><?= $sem_7 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_pr_semester_7" value="<?=$user[0]->pr_semester_7?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_semester_7"  value="<?=$user[0]->pr_semester_7?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_7 !="" ||$user[0]->pr_semester_7 !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>
 
   </div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<div class="col-md-12">





<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - VIII Mark Sheet </label> 
<br><span class="required"><?= $sem_8 ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_pr_semester_8" value="<?=$user[0]->pr_semester_8?>">
      <input type="file"  accept="image/jpeg,application/pdf"      name="pr_semester_8"  value="<?=$user[0]->pr_semester_8?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_8 !="" ||$user[0]->pr_semester_8 !=null){ ?>
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_sslc_mark?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span> Uploded File
</a><span class="glyphicon glyphicon-ok-sign"></span>-->
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>
    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Provisional UG Degree Certificate </label>
<br><span class="required"><?= $prv_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_pr_provisional_pg_cer" value="<?=$user[0]->pr_provisional_pg_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="pr_provisional_pg_cer"  class="form-control"  value="<?=$user[0]->pr_provisional_pg_cer?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_provisional_pg_cer !="" ||$user[0]->pr_provisional_pg_cer !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">UG Degree Certificate</label> 
<br><span class="required"><?= $ug_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_pr_ug_cer" value="<?=$user[0]->pr_ug_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_ug_cer"  value="<?=$user[0]->pr_ug_cer?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_ug_cer !="" ||$user[0]->pr_ug_cer !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Community Certificate <span class="required">* (Mandatory if you claim community reservation)</span></label>
<br><span class="required"><?= $ug_cumm_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_pr_community_cer" value="<?=$user[0]->pr_community_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="pr_community_cer"  class="form-control"  value="<?=$user[0]->pr_community_cer?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_community_cer !="" ||$user[0]->pr_community_cer !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>
   <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Cumulative Mark Sheet </label>
<br><span class="required"><?= $ug_cer_cum ; ?></span> 
</div>
<div class="col-md-5">
<input type="hidden" name="stud_pr_cummulative_cer" value="<?=$user[0]->pr_cummulative_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_cummulative_cer"  value="<?=$user[0]->pr_cummulative_cer?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_cummulative_cer !="" ||$user[0]->pr_cummulative_cer !=null){ ?>

<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<?php
} else{   ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
<?php
}  ?>
</div>
</div>
    </label>

 

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Transfer Certificate</label>
<br><span class="required"><?= $ug_trans_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_pr_transfer_cer" value="<?=$user[0]->pr_transfer_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="pr_transfer_cer"  class="form-control"  value="<?=$user[0]->pr_transfer_cer?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_transfer_cer !="" ||$user[0]->pr_transfer_cer !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >

<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>


    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Conduct Certificate</label>
<br><span class="required"><?= $ug_cond_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_pr_conduct_cer" value="<?=$user[0]->pr_conduct_cer?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="pr_conduct_cer"  class="form-control"  value="<?=$user[0]->pr_conduct_cer?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_conduct_cer !="" ||$user[0]->pr_conduct_cer !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_comunity_cert?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span>Uploded File
</a>-->
<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>

    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">
Differently abled  Certificate</label>
<br><span class="required"><?= $able_cer ; ?></span>
</div>
<div class="col-md-5">
<input type="hidden"  name="abled_cert_name" value="<?=$user[0]->pr_abled_certificate?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="abled_certificate"  class="form-control"  value="<?=$user[0]->pr_abled_certificate?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_abled_certificate !="" ||$user[0]->pr_abled_certificate !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_comunity_cert?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span>Uploded File
</a>-->
<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>





</div>
</div>

<input type="submit" class="btn btn-primary"  name="submit" value="Update">

</div>
</div>







</div>
</div>





</div>
</div>
</div>
</form>
<style>
.required
{
    color: red;
}
</style>