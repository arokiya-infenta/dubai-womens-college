<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_top padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>PG Diploma Application for the Academic Year 2023 - 2024</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<form method="post" id="formId" action="<?=base_url()?>Home/SaveApplicationDip" enctype="multipart/form-data">
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
    <h5>P.G. Diploma Program Details</h5>
<!-- Form Name -->
<!-- Select Basic -->
<div class="row form-group">
<div class="col-md-6">
    <div class="row">
    <div class="col-md-3">
  
</div>
<div class="col-md-9" id="course_appl">

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


echo $num_pri * 500 ;




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

  <select  class="form-control"  name="blood_group" id="sel1">
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
  <input type="text" id="Religion"  name="Religion"  value="<?=$user[0]->pr_religion?>" class="form-control">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Caste</label>
  <div class="col-md-3">
    <input type="text" id="Caste"  name="Caste"  value="<?=$user[0]->pr_caste?>"  class="form-control">
  </div>
</div>
<div class="row form-group">
  <label class="col-md-7 control-label" for="selectbasic">Is your community certificate issued by Govt. of Tamilnadu </label>
  <div class="col-md-4">
  <label class="radio-inline">
      <input type="radio" class="tamilnadu" name="tamilnadustate" required <?php if($user[0]->pr_tamilnadustate=="1"){echo"checked";} ?> value="1" > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" class="tamilnadu" name="tamilnadustate" required <?php if($user[0]->pr_tamilnadustate=="2"){echo"checked";} ?>  value="2" > No
    </label>
  </div>
  
</div>
<div class="row form-group">
  <label class="col-md-3 control-label"  for="selectbasic">Community </label>
  <div class="col-md-9">
  <label class="radio-inline">
      <input type="radio" class="comm-oc" name="Community"  <?php if($user[0]->pr_community=="OC"){echo"checked";} ?> value="OC" > OC
    </label>
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
    </label>
 
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="SC"){echo"checked";} ?> value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
    </label>
 
    <label class="radio-inline">
      <input type="radio"  class="comm-others"  name="Community"  <?php if($user[0]->pr_community=="ST"){echo"checked";} ?> value="ST" > ST
    </label>
    
   
  </div>
  <div class="col-md-12">
  <span class="required"> [Note: If your OBC/BC/MBC/SC/ST certificate is not issued by Govt. of Tamil Nadu, then you will be considered under OC only. Providing incorrect community may result in rejection of your application. ]</span>
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
<input type="text" name="father_name"  value="<?=$user[0]->pr_father_name?>"  class="form-control">
</div>
<div class="col-md-4">
<input type="text"  name="mother_name"   value="<?=$user[0]->pr_mother_name?>"   class="form-control">
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
<input type="email"  name="father_email"   value="<?=$user[0]->pr_father_email?>"   class="form-control">
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
<input type="text"  name="father_mob_num"  value="<?=$user[0]->pr_father_mobnum?>"   class="form-control">
</div>
<div class="col-md-4">
<input type="text"   name="mother_mob_num"  value="<?=$user[0]->pr_mother_mobnum?>"    class="form-control">
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
<input type="text"   name="father_accupation"  value="<?=$user[0]->pr_father_accu?>" class="form-control">
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
<input type="number"  name="father_anuval_income"  value="<?=$user[0]->pr_father_anuval_income?>"  class="form-control">
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
<input type="file" id="abled-cert"  accept="image/jpeg,application/pdf"  <?php  if($user[0]->pr_abled_certificate =="" || $user[0]->pr_abled_certificate ==null){echo"disabled";} ?>   name="abled_certificate"  value="<?=$user[0]->pr_abled_certificate?>" class="form-control" >
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Basic Details --->

<div class="row">
 <div class=" col-md-12 stud-details">
<h5>Mark Details</h5>
       <div class="row">      
<div class="col-md-2 plus-one">
<div class="col-md-12" style="text-align:center;">
<h6> Educational  </h6>
</div>
<br>
<input type="text" readonly class="form-control" name="sslc" value="SSLC" placeholder="Language 1">
 <input type="text" readonly value="Plus One (+ 1)" class="form-control" name="plus_one"  placeholder="Language 2">
<input type="text" readonly value="Plus Two (+ 2)" class="form-control"  name="plus_two"  placeholder="Main Subject 1">
<input type="text" readonly value="UG" class="form-control"  name="ug" placeholder="Main Subject 2">
<input type="text"  value="<?=$Study[0]->others_edu?>" class="form-control"  name="others_edu" placeholder="Others">

</div>
<div class="col-md-2 plus-one">
<div class="col-md-12" style="text-align:center;">
<h6> Institution </h6>
</div>
<br>
<input type="text" id="instsslc"  value="<?=$Study[0]->sslc_institution?>"    class="form-control" name="sslc_ins" placeholder="School Name">
 <input type="text"  value="<?=$Study[0]->plus_one_institution?>" class="form-control" name="plus_one_ins"  placeholder="School Name" >
<input type="text"  value="<?=$Study[0]->plus_two_institution?>" class="form-control"  name="plus_two_ins"  placeholder="School Name" >
<input type="text"  value="<?=$Study[0]->ug_institution?>" class="form-control"  name="ug_ins"  placeholder="Institute Name">
<input type="text"  value="<?=$Study[0]->others_institution?>" class="form-control"  name="others_institution"  placeholder="Institute Name">

</div>
<!-- +1 Mark Details start -->
<div class="col-md-8 plus-one">

<div class="col-md-12" style="text-align:center;">
<h6> Mark Details</h6>
</div>

<div class="row">
<label class="col-md-3 control-label" for="selectbasic">Max. Marks </label>
<label class="col-md-3 control-label" for="selectbasic">Marks Obtained </label>
<label class="col-md-3 control-label" for="selectbasic">Class / Grade </label>
<label class="col-md-3 control-label" for="selectbasic">Percentage </label>


</div>
<div class="row">

<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->sslc_max_mark?>" class="form-control" name="sslc_max_mark"  placeholder="Max Mark">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->sslc_mark_obtain?>" class="form-control" name="sslc_mark_obtain"  placeholder="Marks Obtained">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->sslc_grade?>" class="form-control" name="sslc_grade"  placeholder="Class / Grade">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text" value="<?=$Study[0]->sslc_percentage?>"  class="form-control" name="sslc_percentage"   placeholder="Percentage">
</div>
</div>
</div>
   </div>




   
<div class="row">
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-12">
       <input type="text"  value="<?=$Study[0]->plus_one_max_mark?>"   class="form-control"  name="plus_one_max_mark"  placeholder="Max Mark">
       </div>
       </div>
       </div>
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-12">
       <input type="text"  value="<?=$Study[0]->plus_one_mark_obtain?>" class="form-control" name="plus_one_mark_obtain"  placeholder="Marks Obtained">
       </div>
       </div>
       </div>
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-12">
       <input type="text"  value="<?=$Study[0]->plus_one_grade?>" class="form-control"  name="plus_one_grade" placeholder="Class / Grade">
       </div>
       </div>
       </div>
       <div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->plus_one_percentage?>" class="form-control" name="plus_one_percentage"  placeholder="Percentage">
</div>
</div>
</div>
       </div>


   <div class="row">
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->plus_two_max_mark?>"   class="form-control"  name="plus_two_max_mark"  placeholder="Max Mark">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->plus_two_mark_obtain?>" class="  form-control"  name="plus_two_mark_obtain"    placeholder="Marks Obtained">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->plus_two_grade?>" class="form-control" name="plus_two_grade" placeholder="Class / Grade">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->plus_two_percentage?>" class="form-control" name="plus_two_percentage"  placeholder="Percentage">
</div>
</div>
</div>
</div>
 <div class="row">
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  required value="<?=$Study[0]->UG_max_mark?>"  class="form-control"   name="UG_max_mark"  placeholder="Max Mark">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->UG_mark_obtain?>" class="  form-control"  name="UG_mark_obtain"   placeholder="Marks Obtained">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text" required value="<?=$Study[0]->UG_grade?>" class="form-control"  name="UG_grade"  placeholder="Class / Grade">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  required value="<?=$Study[0]->UG_two_percentage?>" class="form-control" name="UG_two_percentage"

<?php  if($Study[0]->UG_two_percentage == NULL || $Study[0]->UG_two_percentage == ""){ ?>

 data-toggle="modal" data-target="#myModal" data-backdrop="static"  <?php } ?> placeholder="Percentage">
</div>
</div>
</div>
</div> 

<div class="row">
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->other_max_mark?>"   class="form-control"  name="other_max_mark"  placeholder="Max Mark">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->other_mark_obtain?>" class="  form-control"  name="other_mark_obtain"    placeholder="Marks Obtained">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->other_grade?>" class="form-control" name="other_grade" placeholder="Class / Grade">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-12">
<input type="text"  value="<?=$Study[0]->other_percentage?>" class="form-control" name="other_percentage"  placeholder="Percentage">
</div>
</div>
</div>
</div>


</div>
<!-- +1 Mark Details end -->

</div> 
       </div> 
   </div> 
   <div class="row">
 <div class=" col-md-12 stud-details">
<h5>Basic Details</h5>
<div class="instruction">
<span class="required">Upload your certificates in JPEG or PDF format File size within 1 mb</label>
</div>

<div class="row form-group">
<div class="col-md-6">
<div class="row">
<div class="col-md-12">
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">
<label class="dl">Semester - I Mark Sheet </label> 
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_1" value="<?=$user[0]->pr_semester_1?>">
      <input type="file"  accept="image/jpeg,application/pdf"    name="pr_semester_1"  value="<?=$user[0]->pr_semester_1?>" class="form-control" > 
</div>
<div class="col-md-1">
<?php if($user[0]->pr_semester_1 !="" ||$user[0]->pr_semester_1 !=null){ ?>

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
<label class="dl">Semester - II Mark Sheet </label>
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
</div>
<div class="col-md-5">
<input type="hidden" name="stu_pr_semester_3" value="<?=$user[0]->pr_semester_3?>">
<input type="hidden" id="pay" name="pay" value="">
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
<label class="dl">Community Certificate </label>
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


</div>
</div>

</div>
</div>





<!--<div class="row form-group">
<div class="col-md-6">
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
</div>
</div>-->
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
      <input type="radio"  name="other_res"  value="Yes"  <?php if($user[0]->pr_other_res=="Yes"){echo"checked";} ?>  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio"  name="other_res"  value="No"  <?php if($user[0]->pr_other_res=="No"){echo"checked";} ?>  > No
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">If yes ,Specify</label>
<div class="col-md-4">

<select  class="form-control" id="reser_specify"  name="other_special_reservation">
        <option value="" >Select Reservation</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Child of Ex-Service Man'){echo"selected";} ?> value="Child of Ex-Service Man" >Child of Ex-Service Man</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Disability'){echo"selected";} ?> value="Disability" >Disability</option>
        <option <?php if($user[0]->pr_other_special_reservation == 'Sports'){echo"selected";} ?> value="Sports" >Sports</option>
      
  </select>




</div>
</div>
</div>
</div>


<div class="row form-group">
<div class="col-md-12">
<div class="row">
<label class="col-md-4 control-label" for="selectbasic">Do you need Hostel Accommodation</label>
<div class="col-md-2" id="hostel">
<label class="radio-inline">
      <input type="radio"  name="hostel"  value="Yes"  <?php if($user[0]->pr_hostel=="Yes"){echo"checked";} ?>  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio"  name="hostel"  value="No"  <?php if($user[0]->pr_hostel=="No"){echo"checked";} ?>  > No
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
</span>
</div>
</div>
 

<div class="row">
 <div class=" col-md-12 stud-details">
<h5>Statement Of Purpose </h5>


<div class="form-group" style="text-align:center;">


<textarea  name="statement" id="word_count" rows="15" class="form-control"><?=$user[0]->pr_pourpose?></textarea>


 Total word Count : <span id="display_count"><?php echo str_word_count($user[0]->pr_pourpose); ?></span> words.
</div>







</div>
</div>



<div id="hrm" class="row" <?php if(in_array(11, $arrt)){ ?> style="display:block" <?php }  ?>  >
 <div class=" col-md-12 stud-details">
<h5>Professional Experience</h5>
<div class="instruction">
<span class="required">Add your working Experience</label>
</div>

<div class="form-group" style="text-align:center;">



<div class="row">
<div class="col-md-3"><h6>Company</h6></div>
<div class="col-md-3"><h6>Role</h6></div>
<div class="col-md-2"><h6>From</h6></div>
<div class="col-md-2"><h6>To</h6></div>
<div class="col-md-1"><h6>Months</h6></div>
<div class="col-md-1"><h6>Add</h6></div>
</div>


<?php

$q = $this->db->select("*")->from("experiance_pg_dip")->where("user_id",$user[0]->pr_user_id)->order_by("exp_from","DESC")->get();

$m = $q->num_rows();

if($m > 0){
  $ms = $q->result();
  foreach($ms as $mtr){  ?>

<div class="row">
<div class="col-md-3"><input type="text" readonly  value="<?=$mtr->company?>"   class="form-control"></div>
<div class="col-md-3"><input type="text" readonly  value="<?=$mtr->roll?>"  class="form-control"></div>
<div class="col-md-2"><input type="date" readonly class="from_Date form-control" value="<?=$mtr->exp_from?>"  ></div>
<div class="col-md-2"><input type="date" readonly class="to_Date form-control"   value="<?=$mtr->exp_to?>"   ></div>
<div class="col-md-1"><input type="text" id ="tot"  value="<?=$mtr->total_months?>" readonly  class="total form-control"></div>
<div class="col-md-1"><button type="button"  value="<?=$mtr->id?>"   class="btn-danger del_exp form-control">-</button></div>
</div>


<?php  }
} 
 ?>



<div class="row">
<div class="col-md-3"><input type="text" name="company[]"    class="form-control"></div>
<div class="col-md-3"><input type="text" name="role[]"    class="form-control"></div>
<div class="col-md-2"><input type="date" class="from_Date form-control"  name="from[]"  ></div>
<div class="col-md-2"><input type="date" class="to_Date form-control"  name="to[]"   ></div>
<div class="col-md-1"><input type="text" id ="tot" name="tot[]"  readonly  class="total form-control"></div>
<div class="col-md-1"><button type="button"  id="add_exp"  class="btn-success form-control">+</button></div>
</div>






</div>

<div id="append" class="form-group" style="text-align:center;">











</div>






</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
       
      </div>
      <div class="modal-body">
      <b>
    <p>  Calculate the percentage of U.G. Marks upto 5th/7th or ALL semesters (if available). While calculating percentage of marks, include all the courses from Part I to Part IV/V including electives, language and any other paper for which marks (both internal and/or external) have been awarded. 
    
    
  
</p>
Adopt the following norms to calculate the UG percentage:<br><br>
(i) Include all subjects (Part I, II, III & IV) in the % calculation <br>
(ii) If the consolidated mark sheet gives the overall percentage, use it as it is.<br>

(iii) Engineering Colleges give CGPA for a maximum of 10 points. Multiply the given CGPA by 10 to arrive at the %. <br>
(iv) Some Universities give CGPA for a maximum of 4 points. Multiply it by 25 to arrive at the percentage.<br><br>
<span class="required">
It is the sole responsibility of the candidate to provide correct percentage. Providing false percentage will result in rejection of the application and cancellation of admission subsequently.
</span>
</b>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">I Accept</button>
      </div>
    </div>

  </div>
</div>
<!-- Mark Details --->

<div class="row norms">
       <div class="col-md-12">
      <b> Self Declaration</b>
<p>1. I hereby declare that the information given in this application form is true and correct to the best of my knowledge and belief. In case any information given in this application proves to be false or incorrect, I shall be responsible for the consequences.</p>
<p>2. I also declare that if any information provided by me is found false, my candidature may be rejected at any point of time.</p>

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
       <input type="submit" id="SaveDip" name="submit" value="Save">



       <?php if($user[0]->pr_applicant_name !="" || $user[0]->pr_applicant_name !=NULL){ ?>
       <input type="submit" id="PreviewDip" name="Preview" value="Preview">

      
       <input type="submit" id="appliDip" name="appli"  value="Submit your Application">
<?php } ?>

      
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