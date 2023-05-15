
<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>Application</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<form method="post" action="<?=base_url()?>Home/SaveApplication">
<div class="section contact_section" style="background:#ffffff">
    <div class="container">
<?php //print_r($this->session->userdata('user')[user_id]);

?>
    <div class="row">
    

<div class="col-md-12">
<!-- Form Name -->
<!-- Select Basic -->
<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">priority Course One</label>
  <div class="col-md-8">
    <select id="course_1" required onChange="getState(this.value);" name="course_one" class="form-control">
    <option value="">select</option>
    <?php
foreach ($cc as $value) {

  ?>
   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>

 <?php
}
    ?>
      <!--<option value="0">select</option>
      <option value="1">B.Com (Gen)</option>
      <option value="2">B.Com (A&amp;F)</option>
      <option value="3">B.Com (BM)</option>
      <option value="4">B.Com (CS)</option>
      <option value="5">B.B.A.</option>
      <option value="6">B.Sc (Visual Communication) </option>
      <option value="7">B.Sc (Computer Science)</option>
      <option value="8">B.C.A</option>-->
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">priority Course two</label>
  <div class="col-md-8">
    <select id="course_2" require name="course_two" disabled class="form-control">
    <option value="0">select</option>
    <?php
foreach ($cc as $value) {

  ?>
   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>

 <?php
}
    ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="row form-group">
  <label class="col-md-4 control-label"  for="selectbasic">priority Course three</label>
  <div class="col-md-8">
    <select id="course_3" require name="course_three" disabled class="form-control">
    <option value="0">select</option>
    <?php
foreach ($cc as $value) {

  ?>
   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>

 <?php
}
    ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Languages Offered</label>
  <div class="col-md-8">
  <label class="radio-inline">
      <input type="radio" name="language_offered" value="Tamil"> Tamil
    </label>
    <label class="radio-inline">
      <input type="radio" name="language_offered"  value="Hindi"> Hindi
    </label>
    <label class="radio-inline">
      <input type="radio" name="language_offered" value="French"> French
    </label>
    <label class="radio-inline">
      <input type="radio" name="language_offered"  value="Others" > Others
    </label>
   <!-- <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Tamil </option>
      <option value="2">Hindi </option>
      <option value="3">French</option>
      <option value="4">Others</option>
    
    </select>-->
  </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-8">

<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Candidate Name</label>
  <div class="col-md-8">
    <input type="text"  name="candidate_name"  class="form-control">
  </div>
</div>

<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Date of birth</label>
  <div class="col-md-4">
    <input type="date" class="form-control" name="dob"  id="dob">
  </div>
  <label class="col-md-2 control-label" for="selectbasic">Age</label>
  <div class="col-md-2">
    <input type="text" id="age" readonly name="age" class="form-control">
  </div>
</div>
<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Gender</label>
  <div class="col-md-4">
  <label class="radio-inline">
      <input type="radio" name="gender" value="Male"> Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="gender" value="Female"> Female
    </label>
    <label class="radio-inline">
      <input type="radio" name="gender"  value="Others"> Others
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
  
  <div class="col-md-2">
    <input type="text" name="Nationality" class="form-control">
  </div>
</div>


<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Religion </label>
  <div class="col-md-4">
  <input type="text"  name="Religion" class="form-control">
  </div>
  
  <label class="col-md-2 control-label" for="selectbasic">Caste</label>
  
  <div class="col-md-2">
    <input type="text"  name="Caste"  class="form-control">
  </div>
</div>



<div class="row form-group">
  <label class="col-md-4 control-label" for="selectbasic">Community </label>
  <div class="col-md-8">


  <label class="radio-inline">
      <input type="radio" name="Community" value="ST" > ST
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="SC(A)" > SC(A)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="DNC"  > DNC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="MBC" > MBC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="Male"  > Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community"  value="OC" > OC
    </label>

  </div>
 
</div>
</div>
<div class="col-md-4">
<label class="">
     Upload Your Passport size Photo
    </label>
<input type="file" id="profile-img" class="form-control">
<br>
<img src="" id="profile-img-tag" width="160px" height="160px" />
</div>

        </div>            
     <b>   Parent's / Guardian's Details</b>
        <div class="row">
       

       <div class="col-md-3">
      
</div>
<label class="col-md-3 control-label" for="selectbasic">Father </label>
<label class="col-md-3 control-label" for="selectbasic">Mother </label>
<label class="col-md-3 control-label" for="selectbasic">guardian </label>

</div>  
        <div class="row">
        <div class="col-md-12">
        <div class="row">
       

        <div class="col-md-3">
        Name
</div>
<div class="col-md-3">
<input type="text" name="father_name" class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="mother_name"  class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="guardion_name"  class="form-control">
</div>

</div>
</div>
</div><br>
<div class="row">
       

       <div class="col-md-3">
       Mobile No
</div>
<div class="col-md-3">
<input type="text" name="father_mob_num" class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="mother_mob_num"   class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="guardion_mob_num" class="form-control">
</div>

</div><br>
<div class="row">
       

       <div class="col-md-3">
       Occupation
</div>
<div class="col-md-3">
<input type="text"  name="father_accupation"  class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="mother_accupation" class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="guardion_accupation" class="form-control">
</div>

</div><br>
<div class="row">
       

       <div class="col-md-3">
       Annual
Income
</div>
<div class="col-md-3">
<input type="text"  name="father_anuval_income"  class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="mother_anuval_income"  class="form-control">
</div>
<div class="col-md-3">
<input type="text"  name="guardion_anuval_income"  class="form-control">
</div>

</div>
<div class="row">
       

       <div class="col-md-6">
<b>Local address</b>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Address </label>
<div class="col-md-6">
<textarea class="form-control" name="local_address" rows="5" id="comment"></textarea>
</div>
</div><br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Area </label>
<div class="col-md-6">
<input type="text" name="local_area" class="form-control">
</div>
</div>


<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">city </label>
<div class="col-md-6">
<input type="text" name="local_city" class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">State </label>
<div class="col-md-6">
<input type="text"  name="local_state"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Country </label>
<div class="col-md-6">
<input type="text"  name="local_country"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Pincode </label>
<div class="col-md-6">
<input type="text"  name="local_pincode"  class="form-control">
</div>
</div>


</div>
<div class="col-md-6">
<b>Permanent  Address</b>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Address </label>
<div class="col-md-6">
<textarea class="form-control" name="pr_address" rows="5" id="comment"></textarea>
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Area </label>
<div class="col-md-6">
<input type="text"  name="pr_area"  class="form-control">
</div>
</div>


<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">city </label>
<div class="col-md-6">
<input type="text" name="pr_city"  class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">State </label>
<div class="col-md-6">
<input type="text"  name="pr_state"   class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Country </label>
<div class="col-md-6">
<input type="text"   name="pr_country"   class="form-control">
</div>
</div>
<br>
<div class="row">
<label class="col-md-6 control-label" for="selectbasic">Pincode </label>
<div class="col-md-6">
<input type="text"   name="pr_pincode"   class="form-control">
</div>
</div>
</div>


</div>
<br>
<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Identification </label>
<div class="col-md-8">
<div class="row">
<div class="col-md-2">1.</div>
<div class="col-md-10">
<input type="text"  name="identification_one"  class="form-control">
</div>
</div>
</br>
<div class="row">
<div class="col-md-2">2.</div>
<div class="col-md-10">
<input type="text"  name="identification_two"  class="form-control">
</div>
</div>
</div>


</div>
<br>
<div class="row">


<label class="col-md-4 control-label" for="selectbasic">Are you differently abled ? </label>
<div id="inline_content" class=" col-md-2">
<label class="radio-inline">
      <input type="radio" name="abled" value="yes" > YES
    </label>
    <label class="radio-inline">
      <input type="radio" name="abled"  value="no"  checked> NO
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">If Yes , Specify </label>
<div class="col-md-4">
<input type="text" id="abledreason" name="abled_reason" class="form-control">
</div>


</div>
<br>
<div class="row">


<label class="col-md-4 control-label" for="selectbasic">HSE/+2 Details Upload certficate copy </label>
<div class="col-md-2">
<label class="radio-inline">
      <input type="file" name="certificatte" class="form-control" > 
    </label>
   
</div>
<label class="col-md-2 control-label" for="selectbasic"> Register No.</label>
<div class="col-md-4">
<input type="text"  name="regnumber"  class="form-control">
</div>


</div>

<br>
<div class="row">


<label class="col-md-3 control-label" for="selectbasic">School / Institution
last attended </label>
<div class="col-md-3">
<label class="radio-inline">
      <input type="radio" name="institute" value="Private" > Private
    </label>
    <label class="radio-inline">
      <input type="radio" name="institute"  value="Govt"  > Govt
    </label>  <label class="radio-inline">
      <input type="radio" name="institute"  value="Aided"   > Aided
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">Institution Name </label>
<div class="col-md-4">
<input type="text" name="institutionname" class="form-control">
</div>
</div>

<br>
<div class="row">

<div class="col-md-6">
<label class="radio-inline">
      <input type="radio" name="study_bord" value="BOARD" > BOARD
    </label>
    <label class="radio-inline">
      <input type="radio" name="study_bord" value="TNHSC"  > TNHSC
    </label>  
    <label class="radio-inline">
      <input type="radio" name="study_bord"  value="Matric. HSS"  > Matric. HSS
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord"  value="CBSE"  > CBSE
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord"  value="ICSE"  > ICSE
    </label> <label class="radio-inline">
      <input type="radio" name="study_bord" value="Others"  > Others
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">Other </label>
<div class="col-md-4">
<input type="text" class="form-control">
</div>


</div>


<br>
<div class="row">


<label class="col-md-3 control-label" for="selectbasic">Medium of Instruction (in+2) </label>
<div class="col-md-3">
<label class="radio-inline">
      <input type="radio"  name="medium"  value="English"  > English
    </label>
    <label class="radio-inline">
      <input type="radio"  name="medium"  value="Tamil"   > Tamil
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">Month and Year of Passing </label>
<div class="col-md-4">
<input type="text"   name="year_of_passing"    class="form-control">
</div>
</div>

<div class="row">


<label class="col-md-3 control-label" for="selectbasic">Break in Studies </label>
<div class="col-md-3">
<label class="radio-inline">
      <input type="radio" name="break_in_study" value="yes"> Yes
    </label>
    <label class="radio-inline">
      <input type="radio" name="break_in_study" value="no"> NO
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">If Yes , Specify </label>
<div class="col-md-4">
<input type="text" name="break_reason" class="form-control">
</div>
</div>


<div class="row">


<label class="col-md-3 control-label" for="selectbasic">Stream </label>
<div class="col-md-3">
<label class="radio-inline">
      <input type="radio" name="stream" value="General" > General
    </label>
    <label class="radio-inline">
      <input type="radio" name="stream" value="Vocational"   > Vocational
    </label>
</div>
<label class="col-md-2 control-label" for="selectbasic">Passed in FIRST attempt </label>
<div class="col-md-4">
<label class="radio-inline">
      <input type="radio" name="pass_in_first_att"  value="Yes"  > Yes
    </label>
    <label class="radio-inline">
      <input type="radio" name="pass_in_first_att"  value="No"  > No
    </label>
</div>
</div>

<div class="row">





<label class="col-md-3 control-label" for="selectbasic">Language Studied in School </label>
<div class="col-md-5">
<label class="radio-inline">
      <input type="radio" name="lang_studied"  value="TAMIL"  > TAMIL
    </label>
    <label class="radio-inline">
      <input type="radio" name="lang_studied"  value="HINDI"  > HINDI
    </label>
    <label class="radio-inline">
      <input type="radio" name="lang_studied"  value="SANSKRIT"  > SANSKRIT
    </label>
    <label class="radio-inline">
      <input type="radio" name="lang_studied"  value="FRENCH"  > FRENCH
    </label>
    <label class="radio-inline">
      <input type="radio" name="lang_studied"  value="OTHERS"  > OTHERS
    </label>
</div>

<div class="col-md-4">
<input type="text"  name="lang_others"  class="form-control">
</div>
</div>

<br>
<div class="row">


<label class="col-md-3 control-label" for="selectbasic">Sports Category : Name of the Game(s)</label>
<div class="col-md-3">
<input type="text" name="sports_name" class="form-control">
</div>
<label class="col-md-2 control-label" for="selectbasic">Position</label>
<div class="col-md-4">
<input type="text" name="sports_psition" class="form-control">
</div>
</div>

<div class="row">


<label class="col-md-3 control-label" for="selectbasic">Extra - Curricular Activities</label>
<div class="col-md-9">
<input type="text"  name="extra_caricular_activities"  class="form-control">
</div>

</div>


<b>Mark Details :</b>
        <div class="row">
       

    
<label class="col-md-3 control-label" for="selectbasic">Subjects Studied </label>
<label class="col-md-3 control-label" for="selectbasic">Max. Marks </label>
<label class="col-md-3 control-label" for="selectbasic">Marks Obtained </label>
<label class="col-md-3 control-label" for="selectbasic">Class / Grade </label>

</div> 

<div class="row">
       

    
<div class="col-md-3">
<input type="text" class="form-control" name="lang_1" placeholder="Language 1">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control" name="lang_1_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control" name="lang_1_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control" name="lang_1_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="lang_1_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control" name="lang_1_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control" name="lang_1_class_grade_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 

<br>

       <div class="row">
       

    
       <div class="col-md-3">
       <input type="text" class="form-control" name="lang_2"  placeholder="Language 2">
       </div>
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-6">
       <input type="text" class="form-control"  name="lang_2_max_mark_plus_1" placeholder="Plus One">
       </div>
       <div class="col-md-6">
       <input type="text" class="form-control"  name="lang_2_max_mark_plus_2"   placeholder="Plus Two">
       </div>
       </div>
       </div>
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-6">
       <input type="text" class="form-control" name="lang_2_mark__obtained_plus_1"   placeholder="Plus One">
       </div>
       <div class="col-md-6">
       <input type="text" class="form-control"   name="lang_2_mark__obtained_plus_2"   placeholder="Plus Two">
       </div>
       </div>
       </div>
       <div class="col-md-3">
       <div class="row">
       <div class="col-md-6">
       <input type="text" class="form-control"  name="lang_2_class_grade_plus_1" placeholder="Plus One">
       </div>
       <div class="col-md-6">
       <input type="text" class="form-control" name="lang_2_class_grade_plus_2" placeholder="Plus Two">
       </div>
       </div>
       </div>
             
              
              </div> 

              <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="subj_1"  placeholder="Main Subject 1">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_1_max_mark_plus_1" placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"   name="subj_1_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_1_mark__obtained_plus_1"   placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"   name="subj_1_mark__obtained_plus_2"   placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control" name="subj_1_class_grade_plus_1" placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control" name="subj_1_class_grade_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 


       <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="subj_2" placeholder="Main Subject 2">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"   name="subj_2_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"   name="subj_2_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_2_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"   name="subj_2_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_2_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_2_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 


       <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="subj_3" placeholder="Main Subject 3">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_3_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 

       <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="subj_4"  placeholder="Main Subject 4">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="subj_4_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 

       <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="g_total" placeholder="Grand Total">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control" name="g_total_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="g_total_max_mark_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="g_total_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"   name="g_total_mark__obtained_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="g_total_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="g_total_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 


       <br>

<div class="row">



<div class="col-md-3">
<input type="text" class="form-control"  name="m_total" placeholder="Main Subjects Total">
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_max_mark_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_max_mark_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_mark__obtained_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_mark__obtained_plus_2" placeholder="Plus Two">
</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_class_grade_plus_1"  placeholder="Plus One">
</div>
<div class="col-md-6">
<input type="text" class="form-control"  name="m_total_class_grade_plus_2"  placeholder="Plus Two">
</div>
</div>
</div>
      
       
       </div> 
<br>
       <div class="row">
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
       <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
<label for="vehicle1"> I undertake to abide by the above conditions along with my parent.</label><br>
</div>
</div>

<div class="row" style="
    padding-bottom: 19px;
">
       <div class="col-md-12">
       <input type="submit" id="Save" name="submit" value="Save">

       <input type="submit" id="Preview" name="submit" value="preview">
       <input type="submit" id="appli" name="submit"  value="Pay for Application">

</div>
</div>
           </div>			  
       </div>
    </form>
<!-- end section -->
<style>
.radio-inline{

  padding-right: 25px;
}
#appli{
  float:right;
}
</style>
