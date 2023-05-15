<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

<form method="post" id="formId" action="<?=base_url()?>PgSelfFinance/SaveApplicationPg/<?=$user[0]->pr_user_id?>" enctype="multipart/form-data">
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
 <!-- Form Name -->
<!-- Select Basic -->
<?php

//print_r($cdetails);

//echo"<br><br><br><h5>Application Number : ".$cdetails[0]->application_number."</h5><br><br><br>";

?>

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

  <label class="col-md-3 control-label" for="selectbasic">Passport Expairy </label>
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
<input type="hidden" name="Community"  value="<?=$user[0]->pr_community?>" >
 
 
</div>
</div>
<div class="col-md-4">
<label class="">
     Passport size Photo
    </label>
    <input type="hidden" name="ppimage" value="<?=$user[0]->pr_photo?>">
    <?php 
?>

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
   
" src="<?=base_url()?>uploads/<?=$user[0]->pr_photo?>" id="profile-img-tag" width="160px" height="160px" />
<?php
} ?>
<br>
<br>
<br>

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
<input type="text" required name="father_email"   value="<?=$user[0]->pr_father_email?>"   class="form-control">
</div>
<div class="col-md-4">
<input type="text"   name="mother_email"  value="<?=$user[0]->pr_mother_email?>"    class="form-control">
</div>
<div class="col-md-4">
<input type="text"   name="guardion_email"  value="<?=$user[0]->pr_gaurdion_email?>"   class="form-control">
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
    <h5>Residence</h5>
<div class="row">
       <div class="col-md-6">
       <br>
<b class="bld">Local address :</b>
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
<label for="vehicle1"> Click if same as Local address</label><br>
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
<label class="col-md-3 control-label" for="selectbasic">Are you differently abled ? </label>
<div class="col-md-9">
<div class="row">
<div id="inline_content" class=" col-md-3">
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
<div class="col-md-4">
<input type="hidden" name="abled_cert_name" value="<?=$user[0]->pr_abled_certificate?>">
<input type="file" id="abled-cert"    name="abled_certificate"  value="<?=$user[0]->pr_abled_certificate?>" class="form-control" >
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Basic Details --->


<!-- Basic Details --->
<div class="row">
 <div class=" col-md-12 stud-details">
<h5>Basic Details</h5>


<div class="row form-group">
<div class="col-md-6">
<div class="row">
<div class="col-md-12">
<label class="radio-inline docum">
<div class="row">
<div class="col-md-6">

   </div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<div class="col-md-12">









</div>
</div>

</div>
</div>
</div>
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
</div>
</div>



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

</div>
<div class="col-md-2 plus-one">
<div class="col-md-12" style="text-align:center;">
<h6> Institution </h6>
</div>
<br>
<input type="text" id="instsslc" required value="<?=$Study[0]->sslc_institution?>"    class="form-control" name="sslc_ins" placeholder="School Name">
 <input type="text"  value="<?=$Study[0]->plus_one_institution?>" class="form-control" name="plus_one_ins"  placeholder="School Name" >
<input type="text"  value="<?=$Study[0]->plus_two_institution?>" class="form-control"  name="plus_two_ins"  placeholder="School Name" >
<input type="text"  value="<?=$Study[0]->ug_institution?>" class="form-control"  name="ug_ins"  placeholder="Institute Name">

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
<input type="text" readonly  value="<?=$Study[0]->UG_two_percentage?>" class="form-control" name="UG_two_percentage"

<?php  if($Study[0]->UG_two_percentage == NULL || $Study[0]->UG_two_percentage == ""){ ?>

 data-toggle="modal" data-target="#myModal" data-backdrop="static"  <?php } ?> placeholder="Percentage">
</div>
</div>
</div>
</div> 




</div>
<!-- +1 Mark Details end -->

</div> 
       </div> 
   </div> 

<div class="row" style="
    padding-bottom: 25px;
">
       <div class="col-md-12">
       <!--<input type="hidden" id="usertr" name="msg" value="<?=$usertr?>">-->
       <input type="submit" id="SavePg" name="submit" value="Update">




       <!--<button type="submit" disabled id="appli" name="appli"  value="Submit your Application">Submit your Application</button>-->
</div>
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
  <div class="container">
<div class="row">
<div class="col-md-12">
 <!--<form method="post" id="pGId" action="https://pgi.billdesk.com/pgidsk/PGIMerchantPayment" >
<input type="hidden" id="usertr" name="msg" value="<?=$usertr?>">
<input type="submit" id="appli" name="appli"  value="Submit your Application">
</form>-->






<!-- <form method="post" id="pGId" action="<?=base_url()?>/Home/getcheck" >-->
<!--<input type="hidden" id="usertr" name="msg" value="<?=$usertr?>">-->

<!--</form>-->
</div>
</div>
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