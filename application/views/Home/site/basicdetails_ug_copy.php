<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_top padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>Application Form for the Academic Year 2021 - 2022</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<form method="post" id="formId" action="<?=base_url()?>Home/SaveApplication" enctype="multipart/form-data">
<div id="cleared" class="section contact_section" style="background:#ffffff">
    <div class="container">
<?php //print_r($this->session->userdata('user')[user_id]);
?>
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
<div class="col-md-12 course-details">
    <h5>Course Details</h5>
<!-- Form Name -->
<!-- Select Basic -->
<div class="row form-group">
<div class="col-md-6">
    <div class="row">
    <div class="col-md-4">
  <label class="control-label" for="selectbasic">Priority Course </label>
</div>
<div class="col-md-8" id="course_appl">

<?php
$arrt = array();

$user[0]->pr_course_1;

$arrt = explode(",",$user[0]->pr_course_1);
foreach ($cc as $value) { ?>

<input type="checkbox" class="checkbox_class_here"  <?php if(in_array($value->cs_id, $arrt)){ echo "checked";}  ?>  name="course_one[]" value="<?=$value->cs_id?>">
<label for="<?=$value->cs_name?>"> <?=$value->cs_name?></label><br>

<?php
} ?>


	   </div>


   
  </div>
</div>
<div class="col-md-6" id="app_price">
<h2> <b>Application Fees : </b> <b id="appli_price"><?php

if($user[0]->pr_course_1 == null || $user[0]->pr_course_1 ==""){

$num_pri = 0 ;
}else{

  $num_pri = count($arrt) ;
}


echo $num_pri * 350 ;




?></b> <b> ₹ </b><h2>
</div>
  </div>
<!-- Select Basic -->

</div>
</div>
<!-- Student Details -->
<div class="row">
    <div class=" col-md-12 stud-details">
    <h5>Student Details</h5>
	<div class="row">
<div class="col-md-8">
<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Candidate Name</label>
  <div class="col-md-9">
    <input type="text" required value="<?=$user[0]->pr_applicant_name?>"  id="candidate_name" name="candidate_name"  class="form-control">
  </div>
</div>
<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Date of birth</label>
  <div class="col-md-4">
    <input type="date"  required <?php if($user[0]->pr_dob==NULL || $user[0]->pr_dob==""){
$value_dob = "";
    }else{
      $value_dob = date('Y-m-d',strtotime($user[0]->pr_dob));
    }?> class="form-control" name="dob" value="<?=$value_dob?>"  id="dob">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Age</label>
  <div class="col-md-3">
    <input type="text" id="age" readonly name="age" value="<?=$user[0]->pr_age?>" class="form-control">
  </div>
</div>


<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Mother Tongue</label>
  <div class="col-md-4">
    <input type="text"  required  class="form-control" name="m_tounge" value="<?=$user[0]->pr_mother_toung?>"  >
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Place of Birth</label>
  <div class="col-md-3">
    <input type="text" id="place_of_birth"   name="place_of_birth" value="<?=$user[0]->pr_place_of_birth?>" class="form-control">
  </div>
</div>

<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Gender</label>
  <div class="col-md-4">
  <label class="radio-inline">
      <input type="radio" name="gender" required <?php if($user[0]->pr_gender=="Male"){echo"checked";} ?> value="Male"> Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="gender" required <?php if($user[0]->pr_gender=="Female"){echo"checked";} ?> value="Female"> Female
    </label>
    <label class="radio-inline">
      <input type="radio" name="gender"  required <?php if($user[0]->pr_gender=="Others"){echo"checked";} ?> value="Others"> Transgender
    </label>
  <!--<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-secondary active">
    <input type="radio" name="options" id="option1" autocomplete="off" checked> Male
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option2" autocomplete="off"> Female
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option3" autocomplete="off"> Others
  </label>
</div>-->
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Nationality</label>
  <div class="col-md-3">

<div id="nationality"> 

  <label class="radio-inline">
      <input type="radio" name="Nationality" required <?php if($user[0]->pr_nationality=="Indian"){echo"checked";} ?> value="Indian"> Indian
    </label>
    <label class="radio-inline">
      <input type="radio" name="Nationality" required <?php if($user[0]->pr_nationality=="Foreign "){echo"checked";} ?> value="Foreign "> Foreign 
    </label>

</div>

    <!--<input type="text" id="Nationality" require name="Nationality" required value="<?=$user[0]->pr_nationality?>"  class="form-control">-->
  </div>
</div>
In case of Foreign Citizen<br><br>
<div class="row form-group">

  <label class="col-md-3 control-label" for="selectbasic">Name of the Country </label>
  <div class="col-md-4">
  <input type="text" id="country"  name="country"  value="<?=$user[0]->pr_country?>" class="form-control">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Passport No</label>
  <div class="col-md-3">
    <input type="text" id="passportnumber"  name="passportnumber"  value="<?=$user[0]->pr_passportnumber?>"  class="form-control">
  </div>
</div>
<div class="row form-group">

  <label class="col-md-3 control-label" for="selectbasic">Passport Expiry Date </label>
  <div class="col-md-4">
  <input type="date" id="pp_exp"  name="pp_exp"  value="<?=$user[0]->pr_pp_exp?>" class="form-control">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Blood Group</label>
  <div class="col-md-3">

  <select required class="form-control"  name="blood_group" id="sel1">
        <option value="" >Select Blood Group</option>
        <option <?php if($user[0]->pr_blood_group == 'A+'){echo"selected";} ?> value="A+" >A+</option>
        <option <?php if($user[0]->pr_blood_group == 'A-'){echo"selected";} ?> value="A-" >A-</option>
        <option <?php if($user[0]->pr_blood_group == 'B+'){echo"selected";} ?> value="B+" >B+</option>
        <option <?php if($user[0]->pr_blood_group == 'B-'){echo"selected";} ?> value="B-" >B-</option>
        <option <?php if($user[0]->pr_blood_group == 'O+'){echo"selected";} ?> value="O+" >O+</option>
        <option <?php if($user[0]->pr_blood_group == 'O-'){echo"selected";} ?> value="O-" >O-</option>
        <option <?php if($user[0]->pr_blood_group == 'AB+'){echo"selected";} ?> value="AB+" >AB+</option>
        <option <?php if($user[0]->pr_blood_group == 'AB-'){echo"selected";} ?> value="AB-" >AB-</option>
  </select>


 <!-- <input type="text"    class="form-control" name="blood_group" value="<?=$user[0]->pr_blood_group?>"  id="blood_group">-->
  </div>
</div>


<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Religion </label>
  <div class="col-md-4">
  <input type="text" id="Religion"  name="Religion" required value="<?=$user[0]->pr_religion?>" class="form-control">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Caste</label>
  <div class="col-md-3">
    <input type="text" id="Caste"  name="Caste" required value="<?=$user[0]->pr_caste?>"  class="form-control">
  </div>
</div>
<div class="row form-group">
  <label class="col-md-3 control-label" required for="selectbasic">Community </label>
  <div class="col-md-9">
  <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="OC"){echo"checked";} ?> value="OC" > OC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="SC"){echo"checked";} ?> value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($user[0]->pr_community=="ST"){echo"checked";} ?> value="ST" > ST
    </label>
    
   
  </div>
  <div class="col-md-12">
  <span class="required"> [Note: If your BC/OBC certificate is not issued within Tamil Nadu, select OC.]</span>
  </div>
</div>
</div>
<div class="col-md-4">
<label class="">
     Upload Your Passport size Photo
    </label>
    <input type="hidden" name="ppimage" value="<?=$user[0]->pr_photo?>">
    <?php 
?>
<input type="file" id="profile-img" <?php  if($user[0]->pr_photo == "" || $user[0]->pr_photo == null  ){echo "required";} ?>  name="profile-img" value="<?=$user[0]->pr_photo?>" class="form-control">
<br>
<?php if($user[0]->pr_photo==""||$user[0]->pr_photo==NULL){
echo'<img src="#" id="profile-img-tag" width="160px" height="160px" style="
display: block;
margin-left: auto;
margin-right: auto;
width: 50%;

" />';
}else{ ?>
<img style="
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
   
" src="<?=base_url()?>admin/uploads/<?=$user[0]->pr_photo?>" id="profile-img-tag" width="160px" height="160px" />
<?php
} ?>
<br>
<br>
<br>
<span class="required">Your Passport size photo must have White background and of the size of 2 inch x 2 inch or 51 mm x 51 mm</span>


</div>
</div>
</div>
</div>
<!-- Parent Details --->
<div class="row">
 <div class=" col-md-12 stud-details">
    <h5>Parent's / Guardian's Details</h5>
        <div class="row form-group">
       <div class="col-md-2">      
</div>
<div class="col-md-10">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Father </label>
<label class="col-md-4 control-label" for="selectbasic">Mother </label>
<label class="col-md-4 control-label" for="selectbasic">Guardian </label>
</div> 
</div> 
</div> 
        <div class="row">
        <div class="col-md-12">
        <div class="row form-group">
        <div class="col-md-2">
        Name
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4">
<input type="text" name="father_name" required value="<?=$user[0]->pr_father_name?>"  class="form-control">
</div>
<div class="col-md-4">
<input type="text"  name="mother_name" required  value="<?=$user[0]->pr_mother_name?>"   class="form-control">
</div>
<div class="col-md-4">
<input type="text"  name="guardion_name"  value="<?=$user[0]->pr_gaurdion_name?>"  class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row form-group">
       <div class="col-md-2">
       Email Id
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4">
<input type="email" required name="father_email"   value="<?=$user[0]->pr_father_email?>"   class="form-control">
</div>
<div class="col-md-4">
<input type="email"   name="mother_email"  value="<?=$user[0]->pr_mother_email?>"    class="form-control">
</div>
<div class="col-md-4">
<input type="email"   name="guardion_email"  value="<?=$user[0]->pr_gaurdion_email?>"   class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
       <div class="col-md-2">
       Mobile No
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4">
<input type="text" required name="father_mob_num"  value="<?=$user[0]->pr_father_mobnum?>"   class="form-control">
</div>
<div class="col-md-4">
<input type="text"  required name="mother_mob_num"  value="<?=$user[0]->pr_mother_mobnum?>"    class="form-control">
</div>
<div class="col-md-4">
<input type="text"   name="guardion_mob_num"  value="<?=$user[0]->pr_gaurdion_mobnum?>"   class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
       <div class="col-md-2">
       Occupation
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4">
<input type="text" required  name="father_accupation"  value="<?=$user[0]->pr_father_accu?>" class="form-control">
</div>
<div class="col-md-4">
<input type="text"  name="mother_accupation"  value="<?=$user[0]->pr_mother_accu?>" class="form-control">
</div>
<div class="col-md-4">
<input type="text"  name="guardion_accupation"  value="<?=$user[0]->pr_gaurdion_accu?>" class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
       <div class="col-md-2">
       Annual
Income In Rs
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-4">
<input type="number" required name="father_anuval_income"  value="<?=$user[0]->pr_father_anuval_income?>"  class="form-control">
</div>
<div class="col-md-4">
<input type="number"  name="mother_anuval_income"  value="<?=$user[0]->pr_mother_anuval_income?>"  class="form-control">
</div>
<div class="col-md-4">
<input type="number"  name="guardion_anuval_income"  value="<?=$user[0]->pr_gaurdion_anuval_income?>"  class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Parent Details --->
<div class="row">
 <div class=" col-md-12 stud-details">
    <h5>Residence </h5>
<div class="row">
       <div class="col-md-6">
       <br>
<b class="bld">Local Address :</b>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Address </label>
<div class="col-md-8">
<textarea class="form-control" required name="local_address" rows="5" id="localddress"><?=$user[0]->pr_local_address?></textarea>
</div>
</div><br>

<div class="row">
<label class="col-md-4 control-label" for="selectbasic">City </label>
<div class="col-md-8">
<input type="text" id="local_city" name="local_city" required value="<?=$user[0]->pr_local_city?>" class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">State </label>
<div class="col-md-8">
<input type="text"  id="local_state"   name="local_state" required value="<?=$user[0]->pr_local_state?>"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Country </label>
<div class="col-md-8">
<input type="text" required id="local_country" name="local_country" value="<?=$user[0]->pr_local_country?>"  class="form-control">
</div>
</div>
<br>
<div class="row form-group">
<label class="col-md-4 control-label" for="selectbasic">Pincode </label>
<div class="col-md-8">
<input type="text" required id="local_pincode" name="local_pincode" value="<?=$user[0]->pr_local_pincode?>"  class="form-control">
</div>
</div>
</div>
<div class="col-md-6">
<input type="checkbox" id="address_same" name="address_same" value="">
<label for="vehicle1"> Click if same as Local address </label><br>
<b class="bld">Permanent  Address :</b>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Address </label>
<div class="col-md-8">
<textarea class="form-control"  id="pr_address"  name="pr_address" rows="5" ><?=$user[0]->pr_permanent_address?></textarea>
</div>
</div>
<br>

<div class="row">
<label class="col-md-4 control-label" for="selectbasic">City </label>
<div class="col-md-8">
<input type="text"  id="pr_city"  name="pr_city" value="<?=$user[0]->pr_permanent_city?>" class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">State </label>
<div class="col-md-8">
<input type="text" id="pr_state" name="pr_state" value="<?=$user[0]->pr_permanent_state?>"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Country </label>
<div class="col-md-8">
<input type="text" id="pr_country"  name="pr_country" value="<?=$user[0]->pr_permanent_country?>"  class="form-control">
</div>
</div>
<br>
<div class="row form-group">
<label class="col-md-4 control-label" for="selectbasic">Pincode </label>
<div class="col-md-8">
<input type="text"  id="pr_pincode"  name="pr_pincode" value="<?=$user[0]->pr_permanent_pincode?>"  class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Physical Identification --->
<div class="row form-group">
 <div class=" col-md-12 stud-details">
    <h5>Physical Identity</h5>
<div class="row">
<label class="col-md-2 control-label" for="selectbasic">Identification </label>
<div class="col-md-10">
<div class="row">
<div class="col-md-1">1.</div>
<div class="col-md-11">
<input type="text" required name="identification_one"  value="<?=$user[0]->pr_identification_one?>" class="form-control">
</div>
</div>
</br>
<div class="row form-group">
<div class="col-md-1">2.</div>
<div class="col-md-11">
<input type="text" required name="identification_two"  value="<?=$user[0]->pr_identification_two?>" class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
<label class="col-md-2 control-label" for="selectbasic">Are you differently abled ? </label>
<div class="col-md-10">
<div class="row">
<div id="inline_content" class=" col-md-2">
<label class="radio-inline">
      <input type="radio" name="abled" required value="YES" <?php if($user[0]->pr_differently_abled=="YES"){echo"checked";} ?> > YES
    </label>
    <label class="radio-inline">
      <input type="radio" name="abled" required value="NO"  <?php if($user[0]->pr_differently_abled=="NO"){echo"checked";} ?>> NO
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">If Yes , Specify </label>
<div class="col-md-3">
<input type="text" id="abledreason"  name="abled_reason"  value="<?=$user[0]->pr_differently_abled_reson?>"  class="form-control">
</div>
<label class="col-md-2 control-label" for="selectbasic">Upload File </label>
<div class="col-md-3">
<input type="hidden" name="abled_cert_name" value="<?=$user[0]->pr_abled_certificate?>">
<input type="file" id="abled-cert"  accept="image/jpeg,application/pdf"  <?php  if($user[0]->pr_abled_certificate =="" || $user[0]->pr_abled_certificate ==null){echo"disabled";} ?>   name="abled_certificate"  value="<?=$user[0]->pr_hse_certificate?>" class="form-control" >
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Basic Details --->
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
<label class="dl">Higher Secondary First Year Mark Sheet <span class="required">*</span></label>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_hs_fir_certi" value="<?=$user[0]->pr_hse_certificate?>">
      <input type="file"   accept="image/jpeg,application/pdf"   <?php  if($user[0]->pr_hse_certificate == "" || $user[0]->pr_hse_certificate == null  ){echo "required";} ?> 
       name="hs_fir_certi"  value="<?=$user[0]->pr_hse_certificate?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_hse_certificate !="" ||$user[0]->pr_hse_certificate !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_hse_certificate?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span>Uploded File
</a>-->
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
<label class="dl">Higher Secondary Second Year Mark Sheet <span class="required">*</span></label>
</div>
<div class="col-md-5">
<input type="hidden" name="stu_hs_sec_certi" value="<?=$user[0]->pr_hse2_certificate?>">
<input type="hidden" id="pay" name="pay" value="">
      <input type="file"  accept="image/jpeg,application/pdf"  <?php  if($user[0]->pr_hse2_certificate == "" || $user[0]->pr_hse2_certificate == null  ){echo "required";} ?> name="hs_sec_certi"  value="<?=$user[0]->pr_hse2_certificate?>" class="form-control" > 
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
	<!--	<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Transfer Certificate <span class="required">*</span></label>
</div>
<div class="col-md-5">
<input type="hidden" name="stud_transfer" value="<?=$user[0]->pr_transfer_cert?>">
      <input type="file"  accept="image/jpeg,application/pdf"  name="transfercert"  class="form-control"  value="<?=$user[0]->pr_transfer_cert?>"> 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_transfer_cert !="" ||$user[0]->pr_transfer_cert !=null){
 ?>
<img src="<?=base_url ()?>landing/images/uploaded.png" width ="20px" >-->
<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_transfer_cert?>" class="btn btn-primary btn-sm">
<span class="glyphicon glyphicon-download-alt"></span>Uploded File
</a>--><!--
<?php
}else{  ?>
<img src="<?=base_url ()?>landing/images/x.png" width ="20px" >
  <?php
}   ?>
</div>
</div>
    </label>-->
    <label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Community Certificate <span class="required">* (Mandatory if you claim community reservation)</span></label>
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
<label class="dl">Transfer Certificate <span class="required">*</span></label>
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
<!--<div class="row">
<label class="col-md-4 control-label" for="selectbasic"> + 2 Register No.</label>
<div class="col-md-8">
<input type="text"  name="regnumber"  required value="<?=$user[0]->pr_certificate_regist_numb?>"  class="form-control">
</div>
</div>-->
</div>
</div>
<div class="row form-group">
<div class="col-md-6">

</div>
<div class="col-md-6">

</div>
</div>
<div class="row form-group">
<div class="col-md-6">

</div>
<div class="col-md-6">

</div>
</div>
<div class="row form-group">
  <!--
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Medium of Instruction (in+2) </label>
<div class="col-md-8">
<label class="radio-inline">
      <input type="radio" required  name="medium"  value="English"  <?php if($user[0]->pr_medium_of_instruct=="English"){echo"checked";} ?>  > English
    </label>
    <label class="radio-inline">
      <input type="radio" required  name="medium"  value="Tamil"  <?php if($user[0]->pr_medium_of_instruct=="Tamil"){echo"checked";} ?>  > Tamil
    </label>
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Month and Year of Passing </label>
<div class="col-md-8">
<input type="month" required   name="year_of_passing"  value="<?=$user[0]->pr_month_year_pass?>"    class="form-control">
</div>
</div>
</div>-->
</div>
<div class="row form-group">
<!--<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Break in Studies </label>
<div class="col-md-8" id="break_in_study">
<label class="radio-inline">
      <input type="radio" required name="break_in_study" value="yes" <?php if($user[0]->pr_break_in_syudy=="yes"){echo"checked";} ?> > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" required name="break_in_study" value="no" <?php if($user[0]->pr_break_in_syudy=="no"){echo"checked";} ?> > NO
    </label>
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">If Yes , Specify </label>
<div class="col-md-8">
<input type="text" id="break_reason" name="break_reason"  value="<?=$user[0]->pr_break_reason?>"   class="form-control">
</div>
</div>
</div>-->
</div>
<div class="row form-group">
<!--<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Stream </label>
<div class="col-md-8">
<label class="radio-inline">
      <input type="radio" required name="stream" value="General"  <?php if($user[0]->pr_Stream=="General"){echo"checked";} ?> > General
    </label>
    <label class="radio-inline">
      <input type="radio" required name="stream" value="Vocational"   <?php if($user[0]->pr_Stream=="Vocational"){echo"checked";} ?>  > Vocational
    </label>
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Passed in FIRST Attempt </label>
<div class="col-md-8">
<label class="radio-inline">
      <input type="radio" required name="pass_in_first_att"  value="Yes"  <?php if($user[0]->pr_passed_in_first_attemt=="Yes"){echo"checked";} ?>  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" required name="pass_in_first_att"  value="No"  <?php if($user[0]->pr_passed_in_first_attemt=="No"){echo"checked";} ?>  > No
    </label>
</div>
</div>
</div>-->
</div>
<div class="row form-group">
<!--<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic"> Language under Part 1</label>
<div class="col-md-8" id="langu_age">
<label class="radio-inline">
      <input type="radio" required name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="TAMIL"){echo"checked";} ?> value="TAMIL"  > TAMIL
    </label>
    <label class="radio-inline">
      <input type="radio" required name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="HINDI"){echo"checked";} ?> value="HINDI"  > HINDI
    </label>
    <label class="radio-inline">
      <input type="radio" required name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="SANSKRIT"){echo"checked";} ?> value="SANSKRIT"  > SANSKRIT
    </label>
    <label class="radio-inline">
      <input type="radio" required name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="FRENCH"){echo"checked";} ?> value="FRENCH"  > FRENCH
    </label>
    <label class="radio-inline">
      <input type="radio" required name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="OTHERS"){echo"checked";} ?> value="OTHERS"  > OTHERS
    </label>
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">If Other Languages, Specify </label>
<div class="col-md-8">
<input type="text"  id="spes_other_lang" name="lang_others" value="<?=$user[0]->pr_others_lang?>" class="form-control">
</div>
</div>
</div>-->
</div>
<div class="row form-group">
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Sports Category - Name of the Game(s)</label>
<div class="col-md-8">
<input type="text" name="sports_name"  value="<?=$user[0]->pr_name_of_game?>"  class="form-control">
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Position</label>
<div class="col-md-8">
<input type="text" name="sports_psition"  value="<?=$user[0]->pr_game_position?>"  class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
<div class="col-md-6">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Extra - Curricular Activities</label>
<div class="col-md-8">
<input type="text"  name="extra_caricular_activities"  value="<?=$user[0]->pr_extra_caricular_act?>"  class="form-control">
</div>
</div>
</div>
</div>
<div class="row form-group">
<div class="col-md-12">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Do you come under any other Special Reservation</label>
<div class="col-md-2" id="other_res">
<label class="radio-inline">
      <input type="radio" required name="other_res"  value="Yes"  <?php if($user[0]->pr_other_res=="Yes"){echo"checked";} ?>  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" required name="other_res"  value="No"  <?php if($user[0]->pr_other_res=="No"){echo"checked";} ?>  > No
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">If yes ,Specify</label>
<div class="col-md-4">
<select required class="form-control" id="reser_specify"  name="other_special_reservation">
        <option value="" >Select Reservation</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Ex-Service Man'){echo"selected";} ?> value="Ex-Service Man" >Ex-Service Man</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Disability'){echo"selected";} ?> value="Disability" >Disability</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Sports'){echo"selected";} ?> value="Sports" >Sports</option>
      
  </select></div>
</div>
</div>
</div>


<div class="row form-group">
<div class="col-md-12">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Do you need Hostel Accommodation</label>
<div class="col-md-2" id="hostel">
<label class="radio-inline">
      <input type="radio" required name="hostel"  value="Yes"  <?php if($user[0]->pr_hostel=="Yes"){echo"checked";} ?>  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" required name="hostel"  value="No"  <?php if($user[0]->pr_hostel=="No"){echo"checked";} ?>  > No
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic"></label>
<div class="col-md-4">
</div>
</div>
</div>
</div>
<span class="required">
<b>Note</b><br>
 1 ) Preference in Hostel admission will be given to students from OUTSIDE TamilNadu.<br> 2 ) As rooms are very limited, there is no guarantee that all Hostel
applicants will be given accommodation.<br> 3 ) Admission to any course at MSSW does not automatically guarantee admission to the Hostel <br>
<br>
</span>
</div>
</div>




<div class="row form-group">
 <div class=" col-md-12 stud-details">
    <h5>SSLC Details</h5>

    <div class="row">
       <div class="col-md-6">




<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Name of the School </label>
<div class="col-md-8">
<input type="text"  id="local_state"   name="local_state" required value="<?=$user[0]->pr_local_state?>"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Medium of Instruction </label>
<div class="col-md-8">
<input type="text" required id="local_country" name="local_country" value="<?=$user[0]->pr_local_country?>"  class="form-control">
</div>
</div>
<br>

</div>
<div class="col-md-6">



<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Year of Passing </label>
<div class="col-md-8">
<input type="text" id="pr_country"  name="pr_country" value="<?=$user[0]->pr_permanent_country?>"  class="form-control">
</div>
</div>
<br>
<div class="row form-group">
<label class="col-md-4 control-label" for="selectbasic">Language under Part II </label>
<div class="col-md-8">
<input type="text"  id="pr_pincode"  name="pr_pincode" value="<?=$user[0]->pr_permanent_pincode?>"  class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row form-group">
 <div class=" col-md-12 stud-details">
    <h5>Higher Secondary Details</h5>

    <div class="row">
       <div class="col-md-6">

       <div class="row">
<label class="col-md-4 control-label" for="selectbasic">School / Institution
last attended </label>
<div class="col-md-8">
<label class="radio-inline">
      <input type="radio" name="institute" required  <?php if($user[0]->pr_institute_last_attanded=="Private"){echo"checked";} ?> value="Private" > Private
    </label>
    <label class="radio-inline">
      <input type="radio" name="institute"  required <?php if($user[0]->pr_institute_last_attanded=="Govt"){echo"checked";} ?>  value="Govt"  > Govt
    </label>  <label class="radio-inline">
      <input type="radio" name="institute" required  value="Aided"  <?php if($user[0]->pr_institute_last_attanded=="YES"){echo"Aided";} ?>  > Aided
    </label>
</div>
</div>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">BOARD
</label>
<div class="col-md-8" id="board">
<!--<label class="radio-inline">
      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="BOARD"){echo"checked";} ?>  value="BOARD" > BOARD
    </label> -->
    <label class="radio-inline">
      <input type="radio"  name="study_bord" required <?php if($user[0]->pr_board_study=="TNHSC"){echo"checked";} ?>  value="TNHSC"  > TN HSC
    </label>  
    <label class="radio-inline">
      <input type="radio" name="study_bord" required <?php if($user[0]->pr_board_study=="Matric. HSS"){echo"checked";} ?>  value="Matric. HSS"  > Matric. HSS
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord" required <?php if($user[0]->pr_board_study=="CBSE"){echo"checked";} ?>  value="CBSE"  > CBSE
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord" required <?php if($user[0]->pr_board_study=="ICSE"){echo"checked";} ?>  value="ICSE"  > ICSE
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord" required <?php if($user[0]->pr_board_study=="Others"){echo"checked";} ?>  value="Others"  > Others
    </label>
</div>
</div>

<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Name of the School </label>
<div class="col-md-8">
<input type="text"  id="local_state"   name="local_state" required value="<?=$user[0]->pr_local_state?>"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Medium of Instruction </label>
<div class="col-md-8">
<input type="text" required id="local_country" name="local_country" value="<?=$user[0]->pr_local_country?>"  class="form-control">
</div>
</div>
<br>

</div>
<div class="col-md-6">

<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Institution Name </label>
<div class="col-md-8">
<input type="text" name="institutionname" required  value="<?=$user[0]->pr_insti_name?>"  class="form-control">
</div>
</div>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">If Others, Specify  </label>
<div class="col-md-8">
<input type="text" class="form-control" id="other_board"  Placeholder="Others type here" name="other_bord"  value="<?=$user[0]->pr_bord_other?>" >
</div>
</div><br>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Year of Passing </label>
<div class="col-md-8">
<input type="text" id="pr_country"  name="pr_country" value="<?=$user[0]->pr_permanent_country?>"  class="form-control">
</div>
</div>
<br>
<div class="row form-group">
<label class="col-md-4 control-label" for="selectbasic">Language under Part II </label>
<div class="col-md-8">
<input type="text"  id="pr_pincode"  name="pr_pincode" value="<?=$user[0]->pr_permanent_pincode?>"  class="form-control">
</div>
</div>
</div>
</div>
</div>
</div>

























<!-- Mark Details --->
<div class="row">
 <div class=" col-md-12 stud-details">
<h5>Mark Details</h5>
       <div class="row">      
<div class="col-md-2 subj">
<label class="control-label" for="selectbasic">Subjects Studied </label>
<input type="text" required class="form-control" name="lang_1" value="<?=$Study[0]->lang_1?>" placeholder="Language 1">
 <input type="text" required value="<?=$Study[0]->lang_2?>" class="form-control" name="lang_2"  placeholder="Language 2">
<input type="text" required value="<?=$Study[0]->subj_1?>" class="form-control"  name="subj_1"  placeholder="Main Subject 1">
<input type="text" required value="<?=$Study[0]->subj_2?>" class="form-control"  name="subj_2" placeholder="Main Subject 2">
<input type="text" required value="<?=$Study[0]->subj_3?>" class="form-control"  name="subj_3" placeholder="Main Subject 3">
<input type="text" required value="<?=$Study[0]->subj_4?>" class="form-control"  name="subj_4"  placeholder="Main Subject 4">
<input type="text" required value="<?=$Study[0]->g_total?>" class="form-control" readonly  name="g_total" placeholder="Grand Total">
<input type="text" required value="<?=$Study[0]->m_total?>" readonly class="form-control"  name="m_total" placeholder="Main Subjects Total">
<input type="text" required value="Main Percentage" readonly class="form-control"  name="percentage" placeholder="">
</div>
<!-- +1 Mark Details start -->
<div class="col-md-5 plus-one">
<div class="row">
<div class="col-md-12" style="text-align:center;">
<h6>+1 Mark Details</h6>
</div>
</div>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Max. Marks </label>
<label class="col-md-4 control-label" for="selectbasic">Marks Obtained </label>
<label class="col-md-4 control-label" for="selectbasic">Class / Grade </label>

</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" value="100" readonly class="form-control" name="lang_1_max_mark_plus_1"   placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->lang_1_mark__obtained_plus_1?>" class="plusonetot form-control" name="lang_1_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->lang_1_class_grade_plus_1?>" class="form-control" name="lang_1_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

   </div>
<div class="row">
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text"  value="100" readonly  class="form-control"  name="lang_2_max_mark_plus_1" placeholder="Plus One">
       </div>
       </div>
       </div>
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text" required value="<?=$Study[0]->lang_2_mark__obtained_plus_1?>" class="plusonetot form-control" name="lang_2_mark__obtained_plus_1"   placeholder="Plus One">
       </div>
       </div>
       </div>
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text" required value="<?=$Study[0]->lang_2_class_grade_plus_1?>" class="form-control"  name="lang_2_class_grade_plus_1" placeholder="Plus One">
       </div>
       </div>
       </div>
	  
       </div>
   <div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"  name="subj_1_max_mark_plus_1" placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_1_mark__obtained_plus_1?>" class="plusonemin plusonetot form-control"  name="subj_1_mark__obtained_plus_1"   placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_1_class_grade_plus_1?>" class="form-control" name="subj_1_class_grade_plus_1" placeholder="Plus One">
</div>
</div>
</div>

</div>
 <div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly class="form-control"   name="subj_2_max_mark_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_2_mark__obtained_plus_1?>" class="plusonemin plusonetot form-control"  name="subj_2_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_2_class_grade_plus_1?>" class="form-control"  name="subj_2_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

</div>  
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"  name="subj_3_max_mark_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_3_mark__obtained_plus_1?>" class="plusonemin plusonetot form-control"  name="subj_3_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_3_class_grade_plus_1?>" class="form-control"  name="subj_3_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"  name="subj_4_max_mark_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_4_mark__obtained_plus_1?>" class="plusonemin plusonetot form-control"  name="subj_4_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_4_class_grade_plus_1?>" class="form-control"  name="subj_4_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="600" readonly  class="form-control" name="g_total_max_mark_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  readonly id="gran_total" value="<?=$Study[0]->g_total_mark__obtained_plus_1?>" class="form-control"  name="g_total_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->g_total_class_grade_plus_1?>" class="form-control"  name="g_total_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

 </div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" value="400" readonly class="form-control"  name="m_total_max_mark_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  readonly id="main_total" value="<?=$Study[0]->m_total_mark__obtained_plus_1?>" class="form-control"  name="m_total_mark__obtained_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->m_total_class_grade_plus_1?>" class="form-control"  name="m_total_class_grade_plus_1"  placeholder="Plus One">
</div>
</div>
</div>

</div>


<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" value="400" readonly class="form-control"  name="percentage_max_plus_one"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  readonly id="main_percentage_plus_1" value="<?=$Study[0]->m_total_mark__obtained_plus_1?>" class="form-control"  name="main_percentage_plus_1"  placeholder="Plus One">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">

</div>
</div>
</div>

</div>
</div>
<!-- +1 Mark Details end -->
<!-- +2 Mark Details start-->
<div class="col-md-5 plus-two">
<div class="row">
<div class="col-md-12" style="text-align:center;">
<h6>+2 Mark Details</h6>
</div>
</div>
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Max. Marks </label>
<label class="col-md-4 control-label" for="selectbasic">Marks Obtained </label>
<label class="col-md-4 control-label" for="selectbasic">Class / Grade </label>
</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" value="100" readonly class="form-control" name="lang_1_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->lang_1_mark__obtained_plus_2?>" class="plus2total form-control"  name="lang_1_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->lang_1_class_grade_plus_2?>" class="form-control" name="lang_1_class_grade_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
   </div>
   <div class="row">
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text"  value="100" readonly  class="form-control"  name="lang_2_max_mark_plus_2"   placeholder="Plus Two">
       </div>
       </div>
       </div>
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text" required value="<?=$Study[0]->lang_2_mark__obtained_plus_2?>" class="plus2total form-control"   name="lang_2_mark__obtained_plus_2"   placeholder="Plus Two">
       </div>
       </div>
       </div>
       <div class="col-md-4">
       <div class="row">
       <div class="col-md-12">
       <input type="text" required value="<?=$Study[0]->lang_2_class_grade_plus_2?>" class="form-control" name="lang_2_class_grade_plus_2" placeholder="Plus Two">
       </div>
       </div>
       </div>
       </div>
   <div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"   name="subj_1_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_1_mark__obtained_plus_2?>" class=" plus2total plus2sub form-control"   name="subj_1_mark__obtained_plus_2"   placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_1_class_grade_plus_2?>" class="form-control" name="subj_1_class_grade_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"   name="subj_2_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_2_mark__obtained_plus_2?>" class="plus2total plus2sub  form-control"   name="subj_2_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"required value="<?=$Study[0]->subj_2_class_grade_plus_2?>" class=" form-control"  name="subj_2_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" value="100" readonly  class="form-control"  name="subj_3_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_3_mark__obtained_plus_2?>" class="plus2total plus2sub form-control"  name="subj_3_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_3_class_grade_plus_2?>" class="form-control"  name="subj_3_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
</div> 
 <div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="100" readonly  class="form-control"  name="subj_4_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_4_mark__obtained_plus_2?>" class="plus2total plus2sub form-control"  name="subj_4_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->subj_4_class_grade_plus_2?>" class="form-control"  name="subj_4_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="600" readonly  class="form-control"  name="g_total_max_mark_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  readonly id="plus2alltotal" value="<?=$Study[0]->g_total_mark__obtained_plus_2?>" class="form-control"   name="g_total_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->g_total_class_grade_plus_2?>" class="form-control"  name="g_total_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
 </div>
<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="400" readonly  value="<?=$Study[0]->m_total_max_mark_plus_2?>" class="form-control"  name="m_total_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" readonly id="plus2maintot" value="<?=$Study[0]->m_total_mark__obtained_plus_2?>" class="form-control"  name="m_total_mark__obtained_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->m_total_class_grade_plus_2?>" class="form-control"  name="m_total_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text"  value="400" readonly   class="form-control"  name="percentage_max_plus_two"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">
<input type="text" readonly id="main_percentage_plus_2" value="<?=$Study[0]->m_total_mark__obtained_plus_2?>" class="form-control"  name="main_percentage_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-4">
<div class="row">
<div class="col-md-12">

</div>
</div>
</div>
</div>


</div>
<!-- +2 Mark Details end -->
</div> 
       </div> 
   </div> 
       <div class="row norms">
       <div class="col-md-12">
      <b> Undertaking by the Parent / Guardian</b>
<p>1. The above furnished details are accurate, correct and not suppressed with any information.</p>
<p>2. My ward shall continue the study for the full duration of the course and will abide by the rules and regulations of the college.</p>
<p>3. I will accept the decision of the Principal as final in all matters.<p>
<p>4. I am aware that the admission of my ward is subject to the fulfilment of eligibility norms of the University of Madras.</p>

</div>
</div>
<div class="row">
       <div class="col-md-12">
       <input type="checkbox"<?php if($user[0]->pr_acknoledge == 1){echo"checked";} ?>  required id="acknoledgement" name="acknoledgement" value="1">
<label for="vehicle1"> I undertake to abide by the above conditions along with my parent.</label><br>
</div>
</div>
<div class="row" style="
    padding-bottom: 25px;
">
       <div class="col-md-12">
       <!--<input type="hidden" id="usertr" name="msg" value="<?=$usertr?>">-->
       <input type="submit" id="Save" name="submit" value="Save">
       <input type="submit" id="Preview" name="Preview" value="preview">
       <!--<button type="submit" disabled id="appli" name="appli"  value="Submit your Application">Submit your Application</button>-->
</div>
</div>
           </div>			  
       </div>
    </form>
  <div class="container">
<div class="row">
<div class="col-md-12">
 <!-- <form method="post" id="pGId" action="https://pgi.billdesk.com/pgidsk/PGIMerchantPayment" >
<input type="hidden" id="usertr" name="msg" value="<?=$usertr?>">
<input type="submit" id="appli" name="appli"  value="Submit your Application">
</form>-->
</div>
</div>
</div>
<!-- end section -->
<style>

.radio-inline{
  padding-right: 25px;
}
input#appli {
    top: -60px;
	position:relative;
}
#appli{
  float:right;
}
.stud-details .docum {
    padding-right: 0px;
    display: block;
}
.dl {
    padding-right: 15px;
}
.stud-details h6
{
    font-size: 18px;
    font-weight: 500;
}
select#result {
    width: 100%;
    border-radius: .25rem;
    border: 1px solid #c4c4c4;
    padding: .375rem .75rem;
    color: #8d8d8d;
    font-size: 14px;
}
label.col-md-3.control-label {
    padding: 0px 6px 0px 17px;
}
.instruction {
    font-size: 14px;
    margin-bottom: 45px;
}
.stud-details .form-control { 
    margin-bottom: 15px;
}
.col-md-5.plus-one {
    border-left: 1px solid #cccccc;
    margin-bottom: 20px;
  padding:15px 10px 0px 10px !important;
}
.required
{
    color: red;
}
.col-md-5.plus-two {
 border-left: 1px solid #cccccc;
    margin-bottom: 20px;
    padding:15px 10px 0px 10px !important;
}
.plus-one label {
    font-size: 11px;
    font-weight: 700;
    color: #2f2483;
}
.plus-two label {
    font-size: 11px;
    font-weight: 700;
    color: #2f2483;
}
.col-md-2.subj
{
padding: 39px 10px 0px 10px !important;
}
#Preview
{
cursor:pointer;
}
#appli
{
cursor:pointer;
}
#Save
{
cursor:pointer;
}
</style>