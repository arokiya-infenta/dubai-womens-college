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

    <?php  $cert = $this->db->select("*")->from("Certificate_comments_ug")->where("student_id",$this->session->userdata('user')['user_id'])->where("status",1)->get();
    
    
    $certcomm = $cert->num_rows();
    if( $certcomm > 0){


        $cert_comm = $cert->result();

        if($cert_comm[0]->stu_sslccert !="" || $cert_comm[0]->stu_sslccert !=NULL){
            $sslc_cer =$cert_comm[0]->stu_sslccert;
        }else{
            $sslc_cer ="";
        }
        if($cert_comm[0]->stu_hs_sec_certi !="" || $cert_comm[0]->stu_hs_sec_certi !=NULL){
            $plus_two_cer =$cert_comm[0]->stu_hs_sec_certi;
        }else{
            $plus_two_cer ="";
        }

        if($cert_comm[0]->stu_prof_cert_name !="" || $cert_comm[0]->stu_prof_cert_name !=NULL){
            $plus_two_pro =$cert_comm[0]->stu_prof_cert_name;
        }else{
            $plus_two_pro ="";
        } 
        if($cert_comm[0]->stud_commcert !="" || $cert_comm[0]->stud_commcert !=NULL){
            $comm_cer =$cert_comm[0]->stud_commcert;
        }else{
            $comm_cer ="";
        }

        if($cert_comm[0]->stud_transfer !="" || $cert_comm[0]->stud_transfer !=NULL){
            $trans_cer =$cert_comm[0]->stud_transfer;
        }else{
            $trans_cer ="";
        }

        if($cert_comm[0]->stu_conduct_cert_name !="" || $cert_comm[0]->stu_conduct_cert_name !=NULL){
            $cond_cer =$cert_comm[0]->stu_conduct_cert_name;
        }else{
            $cond_cer ="";
        }

        if($cert_comm[0]->stu_elig_certi_name !="" || $cert_comm[0]->stu_elig_certi_name !=NULL){
            $elig_cer =$cert_comm[0]->stu_elig_certi_name;
        }else{
            $elig_cer ="";
        }
        if($cert_comm[0]->stu_migrate_cert_name !="" || $cert_comm[0]->stu_migrate_cert_name !=NULL){
            $migr_cer =$cert_comm[0]->stu_migrate_cert_name;
        }else{
            $migr_cer ="";
        }
//print_r($cert_comm);



    }else{

        $sslc_cer =""; $plus_two_cer =""; $plus_two_pro =""; $comm_cer =""; 
        $trans_cer =""; $cond_cer =""; $elig_cer =""; $migr_cer =""; 
    }
    
    ?>
    
    <form method="post"  action="<?=base_url()?>UploadCertificates/UpdateMyCertificatesUg" enctype="multipart/form-data">
<div id="cleared" class="section contact_section" style="background:#ffffff">
    <div class="container">



    <div class="row">
 <div class=" col-md-12 stud-details">
<h5>Upload Certificates</h5>
<div class="instruction">
<span class="required">Upload your certificates in JPEG or PDF format File size within 1 MB or 1024 KB </label>
</div>

<div class="row form-group">
<div class="col-md-6">
<div class="row">

<div class="col-md-12">
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">SSLC Mark Sheet <span class="required">*</span></label>
<br><span class="required"><?= $sslc_cer ; ?></span> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_sslccert" value="<?=$user[0]->pr_sslc_mark?>">
      <input type="file"  accept="image/jpeg,application/pdf"   <?php  if($user[0]->pr_sslc_mark == "" || $user[0]->pr_sslc_mark == null  ){echo "required";} ?>  name="sslccert"  value="<?=$user[0]->pr_sslc_mark?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_sslc_mark !="" ||$user[0]->pr_sslc_mark !=null){ ?>
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
<label class="dl">+2 Mark Sheet </label>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_hs_sec_certi" value="<?=$user[0]->pr_hse2_certificate?>">
<input type="hidden" id="pay" name="pay" value="">
      <input type="file"  accept="image/jpeg,application/pdf"   name="hs_sec_certi"  value="<?=$user[0]->pr_hse2_certificate?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_hse2_certificate !="" ||$user[0]->pr_hse2_certificate !=null){ ?>
  <img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_hse2_certificate?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span>Uploded File
</a>-->
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
<label class="dl">+2 Provisional Mark Sheet <span class="required">*</span> </label> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_prof_cert_name" value="<?=$user[0]->pr_provisional_mark_sheet?>">
      <input type="file"  accept="image/jpeg,application/pdf"    <?php  if($user[0]->pr_provisional_mark_sheet == "" || $user[0]->pr_provisional_mark_sheet == null  ){echo "required";} ?>  name="stu_prof_cert"  value="<?=$user[0]->pr_provisional_mark_sheet?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_provisional_mark_sheet !="" ||$user[0]->pr_provisional_mark_sheet !=null){ ?>
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_provisional_mark_sheet?>" class="btn btn-primary btn-sm">
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
<label class="dl">Community Certificate <span class="required"> (Mandatory if you claim community reservation)</span></label>
</div>
<div class="col-md-5">
<input type="hidden"  name="stud_commcert" value="<?=$user[0]->pr_comunity_cert?>">
      <input type="file"  accept="image/jpeg,application/pdf"  id="cm_certi" name="commcert"  class="form-control"  value="<?=$user[0]->pr_comunity_cert?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_comunity_cert !="" ||$user[0]->pr_comunity_cert !=null){
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
</div>
<div class="col-md-6">
<div class="row">
<div class="col-md-12">

		<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Transfer Certificate </label>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_transfer" value="<?=$user[0]->pr_transfer_cert?>">
      <input type="file"  accept="image/jpeg,application/pdf"  name="transfercert"  class="form-control"  value="<?=$user[0]->pr_transfer_cert?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_transfer_cert !="" ||$user[0]->pr_transfer_cert !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_transfer_cert?>" class="btn btn-primary btn-sm">
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
<label class="dl">Conduct Certificate</label> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_conduct_cert_name" value="<?=$user[0]->pr_conduct_certificate?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="stu_conduct_cert"  value="<?=$user[0]->pr_conduct_certificate?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_conduct_certificate !="" ||$user[0]->pr_conduct_certificate !=null){ ?>
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
<label class="dl">Eligibility Certificate </label> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_elig_certi_name" value="<?=$user[0]->pr_eligibility_certificate?>">
      <input type="file"  accept="image/jpeg,application/pdf"      name="stu_elig_certi"  value="<?=$user[0]->pr_eligibility_certificate?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_eligibility_certificate !="" ||$user[0]->pr_eligibility_certificate !=null){ ?>
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
<label class="dl">Migration certificate </label> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_migrate_cert_name" value="<?=$user[0]->pr_migration_certificate?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="stu_migrate_cert"  value="<?=$user[0]->pr_migration_certificate?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_migration_certificate !="" ||$user[0]->pr_migration_certificate !=null){ ?>
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

</div>
</div>

</div>
</div>







</div>
</div>






<br>
<br>
<br>


<input type="submit" id="SaveUg" name="submit" value="Update">


<br>
<br>
<br><br>
<br>
<br>






 
</div>
</div>
</form>
<style>
.required
{
    color: red;
}
</style>