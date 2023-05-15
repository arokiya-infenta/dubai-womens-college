<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

<?php
    $string = base_url();  
    $search = 'admin';  
    $replace = 'uploads';  
      
    $newstr = str_replace($search, $replace, $string );  
    $newstr;
?>
      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Edit Applicant 
            <button id="cancel" style="float:right; margin-right: 10px;" data-direction="reverse" type="submit" class="btn btn-primary">Back</button>
            </div>
            <div class="card-body">


 
            <form method="post" id="formId" action="<?=base_url()?>Admin/SaveApplication" enctype="multipart/form-data">


<input type= "hidden" name="user_id" value="<?=$user[0]->pr_user_id ?>" >
<div id="cleared" class="section contact_section" style="background:#ffffff">

    <div class="container">

<?php //print_r($this->session->userdata('user')[user_id]);



?>





<div class="row">

					 <div class="col-md-2 "></div>

					 <div class="col-md-8 ">

					  <?=$this->session->flashdata('message');?>

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

  <label class="control-label" for="selectbasic">Priority Course One</label>

</div>

<div class="col-md-8">

    <select id="course_1" required onChange="getState(this.value);" name="course_one" class="form-control">

    <option value="">select</option>

    <?php

foreach ($cc as $value) {

if($user[0]->pr_course_1 == NULL ||$user[0]->pr_course_1 == "" ){

  ?>

   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>



 <?php

}else{ ?>





<option  <?php if($value->cs_id == $user[0]->pr_course_1){echo"selected";} ?> value="<?=$value->cs_id?>"><?=$value->cs_name?></option>





<?php

}

}

    ?>

     </select>

	   </div>

  </div>

</div>



<!-- Select Basic -->



<div class="col-md-6">

    <div class="row">

    <div class="col-md-4">

  <label class="control-label" for="selectbasic">Priority Course Two</label>

  </div>

<div class="col-md-8">

    <select id="course_2" require name="course_two" disabled class="form-control">

    <option value="">select</option>

    <?php

foreach ($cc as $value) {

if($user[0]->pr_course_2 == NULL ||$user[0]->pr_course_2 == "" ){

  ?>

   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>



 <?php

}else{ ?>





<option  <?php if($value->cs_id == $user[0]->pr_course_2){echo"selected";} ?> value="<?=$value->cs_id?>"><?=$value->cs_name?></option>





<?php

}

}

    ?>

    </select>

  </div>

</div>

  </div>

  </div>



<!-- Select Basic -->

<div class="row form-group">



<div class="col-md-6">

  <div class="row">

	<div class="col-md-4">

  <label class="control-label"  for="selectbasic">Priority Course Three</label>

  </div>

  <div class="col-md-8">

    <select id="course_3" require name="course_three" disabled class="form-control">

    <option value="">select</option>

    <?php

foreach ($cc as $value) {

if($user[0]->pr_course_3 == NULL ||$user[0]->pr_course_3 == "" ){

  ?>

   <option value="<?=$value->cs_id?>"><?=$value->cs_name?></option>



 <?php

}else{ ?>





<option  <?php if($value->cs_id == $user[0]->pr_course_3){echo"selected";} ?> value="<?=$value->cs_id?>"><?=$value->cs_name?></option>





<?php

}

}

    ?>

    </select>

  </div>

 </div>

  </div>





<!-- Select Basic -->



<div class="col-md-6">

    <div class="row">

	<div class="col-md-4">

  <label class="control-label" for="selectbasic">Languages Offered</label>

  </div>

  <div class="col-md-8">

  <label class="radio-inline">

      <input type="radio" <?php if($user[0]->pr_language=="Tamil"){echo"checked";} ?> name="language_offered" value="Tamil"> Tamil

    </label>

    <label class="radio-inline">

      <input type="radio"  <?php if($user[0]->pr_language=="Hindi"){echo"checked";} ?> name="language_offered"  value="Hindi"> Hindi

    </label>

    <label class="radio-inline">

      <input type="radio"  <?php if($user[0]->pr_language=="French"){echo"checked";} ?> name="language_offered" value="French"> French

    </label>

    <label class="radio-inline">

      <input type="radio"  <?php if($user[0]->pr_language=="Others"){echo"checked";} ?> name="language_offered"  value="Others" > Others

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

    <input type="text" value="<?=$user[0]->pr_applicant_name?>"  name="candidate_name"  class="form-control">

  </div>

</div>



<div class="row form-group">

  <label class="col-md-3 control-label" for="selectbasic">Date of birth</label>

  <div class="col-md-4">

    <input type="date"  <?php if($user[0]->pr_dob==NULL || $user[0]->pr_dob==""){





$value_dob = date('Y-m-d');





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

  <label class="col-md-3 control-label" for="selectbasic">Gender</label>

  <div class="col-md-4">

  <label class="radio-inline">

      <input type="radio" name="gender"  <?php if($user[0]->pr_gender=="Male"){echo"checked";} ?> value="Male"> Male

    </label>

    <label class="radio-inline">

      <input type="radio" name="gender"  <?php if($user[0]->pr_gender=="Female"){echo"checked";} ?> value="Female"> Female

    </label>

    <label class="radio-inline">

      <input type="radio" name="gender"   <?php if($user[0]->pr_gender=="Others"){echo"checked";} ?> value="Others"> Others

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

    <input type="text" name="Nationality" value="<?=$user[0]->pr_nationality?>"  class="form-control">

  </div>

</div>





<div class="row form-group">

  <label class="col-md-3 control-label" for="selectbasic">Religion </label>

  <div class="col-md-4">

  <input type="text"  name="Religion" value="<?=$user[0]->pr_religion?>" class="form-control">

  </div>

  

  <label class="col-md-2 control-label" for="selectbasic">Caste</label>

  

  <div class="col-md-3">

    <input type="text"  name="Caste" value="<?=$user[0]->pr_caste?>"  class="form-control">

  </div>

</div>







<div class="row form-group">

  <label class="col-md-3 control-label" for="selectbasic">Community </label>

  <div class="col-md-9">





  <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="ST"){echo"checked";} ?> value="ST" > ST

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="SC"){echo"checked";} ?> value="SC" > SC

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="DNC"){echo"checked";} ?> value="DNC"  > DNC

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="MBC"){echo"checked";} ?> value="MBC" > MBC

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC

    </label>

    

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)

    </label>

    <label class="radio-inline">

      <input type="radio" name="Community" <?php if($user[0]->pr_community=="OC"){echo"checked";} ?> value="OC" > OC

    </label>



  </div>

 

</div>

</div>

<div class="col-md-4">

<label class="">

     Upload Your Passport size Photo

    </label>

    <input type="hidden" name="ppimage" value="<?=$user[0]->pr_photo?>">

<input type="file" id="profile-img" name="profile-img" class="form-control">

<br>



<?php if($user[0]->pr_photo==""||$user[0]->pr_photo==NULL){



echo'<img src="" id="profile-img-tag" width="160px" height="160px" />';



}else{ ?>





<img src="<?=base_url()?>/uploads/<?=$user[0]->pr_photo?>" id="profile-img-tag" width="160px" height="160px" />





<?php

} ?>



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

<label class="col-md-4 control-label" for="selectbasic">guardian </label>

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

<input type="text"  name="mother_name"  value="<?=$user[0]->pr_mother_name?>"   class="form-control">

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

       Mobile No

</div>

<div class="col-md-10">

<div class="row">

<div class="col-md-4">

<input type="text" name="father_mob_num"  value="<?=$user[0]->pr_father_mobnum?>"   class="form-control">

</div>

<div class="col-md-4">

<input type="text"  name="mother_mob_num"  value="<?=$user[0]->pr_mother_mobnum?>"    class="form-control">

</div>

<div class="col-md-4">

<input type="text"  name="guardion_mob_num"  value="<?=$user[0]->pr_gaurdion_mobnum?>"   class="form-control">

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

<input type="text"  name="father_accupation"  value="<?=$user[0]->pr_father_accu?>" class="form-control">

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

Income

</div>

<div class="col-md-10">

<div class="row">

<div class="col-md-4">

<input type="text"  name="father_anuval_income"  value="<?=$user[0]->pr_father_anuval_income?>"  class="form-control">

</div>

<div class="col-md-4">

<input type="text"  name="mother_anuval_income"  value="<?=$user[0]->pr_mother_anuval_income?>"  class="form-control">

</div>

<div class="col-md-4">

<input type="text"  name="guardion_anuval_income"  value="<?=$user[0]->pr_gaurdion_anuval_income?>"  class="form-control">

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

<b class="bld">Local address :</b>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Address </label>

<div class="col-md-8">

<textarea class="form-control" name="local_address" rows="5" id="comment"><?=$user[0]->pr_local_address?></textarea>

</div>

</div><br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Area </label>

<div class="col-md-8">

<input type="text" name="local_area" value="<?=$user[0]->pr_local_area?>" class="form-control">

</div>

</div>





<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">City </label>

<div class="col-md-8">

<input type="text" name="local_city" value="<?=$user[0]->pr_local_city?>" class="form-control">

</div>

</div>

<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">State </label>

<div class="col-md-8">

<input type="text"  name="local_state" value="<?=$user[0]->pr_local_state?>"  class="form-control">

</div>

</div>

<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Country </label>

<div class="col-md-8">

<input type="text"  name="local_country" value="<?=$user[0]->pr_local_country?>"  class="form-control">

</div>

</div>

<br>

<div class="row form-group">

<label class="col-md-4 control-label" for="selectbasic">Pincode </label>

<div class="col-md-8">

<input type="text"  name="local_pincode" value="<?=$user[0]->pr_local_pincode?>"  class="form-control">

</div>

</div>





</div>

<div class="col-md-6">

<b class="bld">Permanent  Address :</b>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Address </label>

<div class="col-md-8">

<textarea class="form-control" name="pr_address" rows="5" id="comment"><?=$user[0]->pr_permanent_address?></textarea>

</div>

</div>

<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Area </label>

<div class="col-md-8">

<input type="text"  name="pr_area" value="<?=$user[0]->pr_permanent_area?>" class="form-control">

</div>

</div>





<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">City </label>

<div class="col-md-8">

<input type="text" name="pr_city" value="<?=$user[0]->pr_permanent_city?>" class="form-control">

</div>

</div>

<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">State </label>

<div class="col-md-8">

<input type="text"  name="pr_state" value="<?=$user[0]->pr_permanent_state?>"  class="form-control">

</div>

</div>

<br>

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Country </label>

<div class="col-md-8">

<input type="text"   name="pr_country" value="<?=$user[0]->pr_permanent_country?>"  class="form-control">

</div>

</div>

<br>

<div class="row form-group">

<label class="col-md-4 control-label" for="selectbasic">Pincode </label>

<div class="col-md-8">

<input type="text"   name="pr_pincode" value="<?=$user[0]->pr_permanent_pincode?>"  class="form-control">

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

<input type="text"  name="identification_one"  value="<?=$user[0]->pr_identification_one?>" class="form-control">

</div>

</div>

</br>

<div class="row form-group">

<div class="col-md-1">2.</div>

<div class="col-md-11">

<input type="text"  name="identification_two"  value="<?=$user[0]->pr_identification_two?>" class="form-control">

</div>

</div>

</div>

</div>



<div class="row form-group">





<label class="col-md-2 control-label" for="selectbasic">Are you differently abled ? </label>

<div class="col-md-10">

<div class="row">

<div id="inline_content" class=" col-md-3">

<label class="radio-inline">

      <input type="radio" name="abled" value="YES" <?php if($user[0]->pr_differently_abled=="YES"){echo"checked";} ?> > YES

    </label>

    <label class="radio-inline">

      <input type="radio" name="abled"  value="NO"  <?php if($user[0]->pr_differently_abled=="NO"){echo"checked";} ?>> NO

    </label>

</div>

<label class="col-md-2 control-label" for="selectbasic">If Yes , Specify </label>

<div class="col-md-7">

<input type="text" id="abledreason" name="abled_reason"  value="<?=$user[0]->pr_differently_abled_reson?>"  class="form-control">

</div>

</div>

</div>

</div>

</div>

</div>

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



<label class="dl">SSLC Mark Sheet <span class="required">*</span></label> 



</div>



<div class="col-md-5">



<input type="hidden" name="stu_sslccert" value="<?=$user[0]->pr_sslc_mark?>">







      <input type="file" name="sslccert" class="form-control" > 



</div>

<div class="col-md-1">

<?php if($user[0]->pr_sslc_mark !="" ||$user[0]->pr_sslc_mark !=null){ ?>







<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_sslc_mark?>" class="btn btn-primary btn-sm">

<span class="glyphicon glyphicon-download-alt"></span> Uploded File

</a><span class="glyphicon glyphicon-ok-sign"></span>-->

<img src="<?=base_url ()?>white-version/image/uploaded.png" width ="20px" >



<?php



} else{   ?>


<img src="<?=base_url ()?>white-version/image/x.png" width ="20px" >

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







      <input type="file" name="hs_fir_certi" class="form-control" > 



</div>

<div class="col-md-1">

<?php if($user[0]->pr_hse_certificate !="" ||$user[0]->pr_hse_certificate !=null){

 ?>


<img src="<?=base_url ()?>white-version/image/uploaded.png" width ="20px" >


<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_hse_certificate?>" class="btn btn-primary btn-sm">

<span class="glyphicon glyphicon-download-alt"></span>Uploded File

</a>-->



<?php



}else{ ?>


<img src="<?=base_url ()?>white-version/image/x.png" width ="20px" >

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







      <input type="file" name="hs_sec_certi" class="form-control" > 



</div>

<div class="col-md-1">

<?php if($user[0]->pr_hse2_certificate !="" ||$user[0]->pr_hse2_certificate !=null){ ?>



  <img src="<?=base_url ()?>white-version/image/uploaded.png" width ="20px" >



<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_hse2_certificate?>" class="btn btn-primary btn-sm">

<span class="glyphicon glyphicon-download-alt"></span>Uploded File

</a>-->



<?php



}  else{ ?>


 <img src="<?=base_url ()?>white-version/image/x.png" width ="20px" >

<?php 

} ?>

</div>



</div>



    </label>







		<label class="radio-inline docum">



<div class="row">



<div class="col-md-6">



<label class="dl">Community Certificate </label>



</div>



<div class="col-md-5">



<input type="hidden" name="stud_commcert" value="<?=$user[0]->pr_comunity_cert?>">







      <input type="file" name="commcert" class="form-control" > 



</div>

<div class="col-md-1">

<?php if($user[0]->pr_comunity_cert !="" ||$user[0]->pr_comunity_cert !=null){

 ?>



<img src="<?=base_url ()?>white-version/image/uploaded.png" width ="20px" >

<!--<a href="<?=base_url ()?>Home/downloadFile/<?=$user[0]->pr_comunity_cert?>" class="btn btn-primary btn-sm">

<span class="glyphicon glyphicon-download-alt"></span>Uploded File

</a>-->



<?php



}else{  ?>

<img src="<?=base_url ()?>white-version/image/x.png" width ="20px" >

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

<label class="col-md-4 control-label" for="selectbasic"> Register No.</label>

<div class="col-md-8">

<input type="text"  name="regnumber"   value="<?=$user[0]->pr_certificate_regist_numb?>"  class="form-control">

</div>

</div>



</div>

</div>

<div class="row form-group">



<div class="col-md-6">



<div class="row">





<label class="col-md-4 control-label" for="selectbasic">School / Institution

last attended </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio" name="institute"  <?php if($user[0]->pr_institute_last_attanded=="Private"){echo"checked";} ?> value="Private" > Private

    </label>

    <label class="radio-inline">

      <input type="radio" name="institute"  <?php if($user[0]->pr_institute_last_attanded=="Govt"){echo"checked";} ?>  value="Govt"  > Govt

    </label>  <label class="radio-inline">

      <input type="radio" name="institute"  value="Aided"  <?php if($user[0]->pr_institute_last_attanded=="YES"){echo"Aided";} ?>  > Aided

    </label>

</div>

</div>

</div>

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Institution Name </label>

<div class="col-md-8">

<input type="text" name="institutionname"   value="<?=$user[0]->pr_insti_name?>"  class="form-control">

</div>

</div>

</div>

</div>

<div class="row form-group">

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">BOARD

</label>

<div class="col-md-8">

<!--<label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="BOARD"){echo"checked";} ?>  value="BOARD" > BOARD

    </label> -->

    <label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="TNHSC"){echo"checked";} ?>  value="TNHSC"  > TNHSC

    </label>  

    <label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="Matric. HSS"){echo"checked";} ?>  value="Matric. HSS"  > Matric. HSS

    </label> <label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="CBSE"){echo"checked";} ?>  value="CBSE"  > CBSE

    </label> <label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="ICSE"){echo"checked";} ?>  value="ICSE"  > ICSE

    </label> <label class="radio-inline">

      <input type="radio" name="study_bord"  <?php if($user[0]->pr_board_study=="Others"){echo"checked";} ?>  value="Others"  > Others

    </label>

	

</div>

</div>

</div>

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">If Others, Specify  </label>

<div class="col-md-8">

<input type="text" class="form-control" Placeholder="Others type here" name="other_bord"  value="<?=$user[0]->pr_bord_other?>" >

</div>

</div>

</div>

</div>



<div class="row form-group">

<div class="col-md-6">

<div class="row">





<label class="col-md-4 control-label" for="selectbasic">Medium of Instruction (in+2) </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio"  name="medium"  value="English"  <?php if($user[0]->pr_medium_of_instruct=="English"){echo"checked";} ?>  > English

    </label>

    <label class="radio-inline">

      <input type="radio"  name="medium"  value="Tamil"  <?php if($user[0]->pr_medium_of_instruct=="Tamil"){echo"checked";} ?>  > Tamil

    </label>

</div>

</div>

</div>







<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Month and Year of Passing </label>

<div class="col-md-8">

<input type="month"    name="year_of_passing"  value="<?=$user[0]->pr_month_year_pass?>"    class="form-control">

</div>

</div>

</div>

</div>



<div class="row form-group">

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Break in Studies </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio" name="break_in_study" value="yes" <?php if($user[0]->pr_break_in_syudy=="yes"){echo"checked";} ?> > Yes

    </label>

    <label class="radio-inline">

      <input type="radio" name="break_in_study" value="no" <?php if($user[0]->pr_break_in_syudy=="no"){echo"checked";} ?> > NO

    </label>

</div>

</div>

</div>

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">If Yes , Specify </label>

<div class="col-md-8">

<input type="text" name="break_reason"  value="<?=$user[0]->pr_break_reason?>"   class="form-control">

</div>

</div>

</div>

</div>



<div class="row form-group">

<div class="col-md-6">

<div class="row">





<label class="col-md-4 control-label" for="selectbasic">Stream </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio" name="stream" value="General"  <?php if($user[0]->pr_Stream=="General"){echo"checked";} ?> > General

    </label>

    <label class="radio-inline">

      <input type="radio" name="stream" value="Vocational"   <?php if($user[0]->pr_Stream=="Vocational"){echo"checked";} ?>  > Vocational

    </label>

</div>

</div>

</div>

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Passed in FIRST attempt </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio" name="pass_in_first_att"  value="Yes"  <?php if($user[0]->pr_passed_in_first_attemt=="Yes"){echo"checked";} ?>  > Yes

    </label>

    <label class="radio-inline">

      <input type="radio" name="pass_in_first_att"  value="No"  <?php if($user[0]->pr_passed_in_first_attemt=="No"){echo"checked";} ?>  > No

    </label>

</div>

</div>

</div>

</div>





<div class="row form-group">

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">Language Studied in School </label>

<div class="col-md-8">

<label class="radio-inline">

      <input type="radio" name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="TAMIL"){echo"checked";} ?> value="TAMIL"  > TAMIL

    </label>

    <label class="radio-inline">

      <input type="radio" name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="HINDI"){echo"checked";} ?> value="HINDI"  > HINDI

    </label>

    <label class="radio-inline">

      <input type="radio" name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="SANSKRIT"){echo"checked";} ?> value="SANSKRIT"  > SANSKRIT

    </label>

    <label class="radio-inline">

      <input type="radio" name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="FRENCH"){echo"checked";} ?> value="FRENCH"  > FRENCH

    </label>

    <label class="radio-inline">

      <input type="radio" name="lang_studied"  <?php if($user[0]->pr_languvage_studied=="OTHERS"){echo"checked";} ?> value="OTHERS"  > OTHERS

    </label>

</div>

</div>

</div>

<div class="col-md-6">

<div class="row">

<label class="col-md-4 control-label" for="selectbasic">If Other Languages, Specify </label>

<div class="col-md-8">

<input type="text"  name="lang_others" value="<?=$user[0]->pr_others_lang?>" class="form-control">

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

</div>

</div>

<!-- Mark Details --->



<div class="row">

 <div class=" col-md-12 stud-details">



<h5>Mark Details</h5>



<div class="row">      



<div class="col-md-2 subj">



<label class="control-label" for="selectbasic">Subjects Studied </label>

<input type="text" class="form-control" name="lang_1" value="<?=$Study[0]->lang_1?>" placeholder="Language 1">

 <input type="text" value="<?=$Study[0]->lang_2?>" class="form-control" name="lang_2"  placeholder="Language 2">

<input type="text" value="<?=$Study[0]->subj_1?>" class="form-control"  name="subj_1"  placeholder="Main Subject 1">

<input type="text" value="<?=$Study[0]->subj_2?>" class="form-control"  name="subj_2" placeholder="Main Subject 2">

<input type="text" value="<?=$Study[0]->subj_3?>" class="form-control"  name="subj_3" placeholder="Main Subject 3">

<input type="text" value="<?=$Study[0]->subj_4?>" class="form-control"  name="subj_4"  placeholder="Main Subject 4">

<input type="text" value="<?=$Study[0]->g_total?>" class="form-control" readonly  name="g_total" placeholder="Grand Total">

<input type="text" value="<?=$Study[0]->m_total?>" readonly class="form-control"  name="m_total" placeholder="Main Subjects Total">



</div>

<!-- +1 Mark Details start -->

<div class="col-md-5 plus-one">



<div class="row">



<div class="col-md-12" style="text-align:center;">



<h6>+1 Mark Details</h6>



</div>



</div>



<div class="row">

<label class="col-md-3 control-label" for="selectbasic">Max. Marks </label>

<label class="col-md-3 control-label" for="selectbasic">Marks Obtained </label>

<label class="col-md-3 control-label" for="selectbasic">Class / Grade </label>

  <label class="col-md-3 control-label" for="selectbasic">Pass/Fail</label>

</div>



<div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->lang_1_max_mark_plus_1?>" class="form-control" name="lang_1_max_mark_plus_1"   placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->lang_1_mark__obtained_plus_1?>" class="form-control" name="lang_1_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->lang_1_class_grade_plus_1?>" class="form-control" name="lang_1_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>



<div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_lang_one" id="result">



    <option  <?php if($Study[0]->lang_1_status=="Pass") { echo"selected";} ?> value="Pass">Pass</option>



    <option <?php if($Study[0]->lang_1_status=="Fail") { echo"selected";} ?> value="Fail">Fail</option>



  </select>

</div>

</div>

</div>



   </div>

<div class="row">



       <div class="col-md-3">

       <div class="row">

       <div class="col-md-12">

       <input type="text" value="<?=$Study[0]->lang_2_max_mark_plus_1?>" class="form-control"  name="lang_2_max_mark_plus_1" placeholder="Plus One">

       </div>

       </div>

       </div>

       <div class="col-md-3">

       <div class="row">

       <div class="col-md-12">

       <input type="text" value="<?=$Study[0]->lang_2_mark__obtained_plus_1?>" class="form-control" name="lang_2_mark__obtained_plus_1"   placeholder="Plus One">

       </div>

       </div>

       </div>



       <div class="col-md-3">

       <div class="row">

       <div class="col-md-12">

       <input type="text" value="<?=$Study[0]->lang_2_class_grade_plus_1?>" class="form-control"  name="lang_2_class_grade_plus_1" placeholder="Plus One">

       </div>

       </div>

       </div>

	   <div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_lang_two" id="result">



    <option <?php if($Study[0]->lang_2_status=="Pass") { echo"selected";} ?>  value="Pass">Pass</option>



    <option <?php if($Study[0]->lang_2_status=="Fail") { echo"selected";} ?> value="Fail">Fail</option>



  </select>

</div>

</div>

</div>



	   

	   

       </div>

	   

	   	   

   <div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_max_mark_plus_1?>" class="form-control"  name="subj_1_max_mark_plus_1" placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_mark__obtained_plus_1?>" class="form-control"  name="subj_1_mark__obtained_plus_1"   placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_class_grade_plus_1?>" class="form-control" name="subj_1_class_grade_plus_1" placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_sub_1"  id="result">



    <option  <?php if($Study[0]->subj_1_status=="Pass") { echo"selected";} ?>  value="Pass">Pass</option>



    <option  <?php if($Study[0]->subj_1_status=="Fail") { echo"selected";} ?>  value="Fail">Fail</option>



  </select>

</div>

</div>

</div>





</div>

	   

 <div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_max_mark_plus_1?>" class="form-control"   name="subj_2_max_mark_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_mark__obtained_plus_1?>" class="form-control"  name="subj_2_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_class_grade_plus_1?>" class="form-control"  name="subj_2_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>



<div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_sub_2" id="result">



    <option <?php if($Study[0]->subj_2_status=="Pass") { echo"selected";} ?> value="Pass">Pass</option>



    <option  <?php if($Study[0]->subj_2_status=="Fail") { echo"selected";} ?> value="Fail">Fail</option>



  </select>

</div>

</div>

</div>





</div>  



<div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_max_mark_plus_1?>" class="form-control"  name="subj_3_max_mark_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_mark__obtained_plus_1?>" class="form-control"  name="subj_3_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_class_grade_plus_1?>" class="form-control"  name="subj_3_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_sub_3" id="result">



    <option  <?php if($Study[0]->subj_3_status=="Pass") { echo"selected";} ?>  value="Pass">Pass</option>



    <option  <?php if($Study[0]->subj_3_status=="Fail") { echo"selected";} ?>  value="Fail">Fail</option>



  </select>

</div>

</div>

</div>





</div>



<div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_max_mark_plus_1?>" class="form-control"  name="subj_4_max_mark_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">



<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_mark__obtained_plus_1?>" class="form-control"  name="subj_4_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_class_grade_plus_1?>" class="form-control"  name="subj_4_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

 <select name="result_sub_4" id="result">



    <option  <?php if($Study[0]->subj_4_status=="Pass") { echo"selected";} ?>  value="Pass">Pass</option>



    <option  <?php if($Study[0]->subj_4_status=="Fail") { echo"selected";} ?>  value="Fail">Fail</option>



  </select>

</div>

</div>

</div>



</div>





<div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_max_mark_plus_1?>" class="form-control" name="g_total_max_mark_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_mark__obtained_plus_1?>" class="form-control"  name="g_total_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_class_grade_plus_1?>" class="form-control"  name="g_total_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">



</div>

</div>

</div>





 </div>



<div class="row">

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_max_mark_plus_1?>" class="form-control"  name="m_total_max_mark_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_mark__obtained_plus_1?>" class="form-control"  name="m_total_mark__obtained_plus_1"  placeholder="Plus One">

</div>

</div>

</div>

<div class="col-md-3">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_class_grade_plus_1?>" class="form-control"  name="m_total_class_grade_plus_1"  placeholder="Plus One">

</div>

</div>

</div>



<div class="col-md-3">

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

<input type="text" value="<?=$Study[0]->lang_1_max_mark_plus_2?>" class="form-control" name="lang_1_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->lang_1_mark__obtained_plus_2?>" class="form-control"  name="lang_1_mark__obtained_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->lang_1_class_grade_plus_2?>" class="form-control" name="lang_1_class_grade_plus_2" placeholder="Plus Two">

</div>

</div>

</div>

   </div>

   

   

   <div class="row">



       <div class="col-md-4">



       <div class="row">



       <div class="col-md-12">



       <input type="text" value="<?=$Study[0]->lang_2_max_mark_plus_2?>" class="form-control"  name="lang_2_max_mark_plus_2"   placeholder="Plus Two">

       </div>

       </div>

       </div>

       <div class="col-md-4">

       <div class="row">

       <div class="col-md-12">

       <input type="text" value="<?=$Study[0]->lang_2_mark__obtained_plus_2?>" class="form-control"   name="lang_2_mark__obtained_plus_2"   placeholder="Plus Two">

       </div>

       </div>

       </div>

       <div class="col-md-4">

       <div class="row">

       <div class="col-md-12">

       <input type="text" value="<?=$Study[0]->lang_2_class_grade_plus_2?>" class="form-control" name="lang_2_class_grade_plus_2" placeholder="Plus Two">

       </div>

       </div>

       </div>

       </div>



   <div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_max_mark_plus_2?>" class="form-control"   name="subj_1_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_mark__obtained_plus_2?>" class="form-control"   name="subj_1_mark__obtained_plus_2"   placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_1_class_grade_plus_2?>" class="form-control" name="subj_1_class_grade_plus_2" placeholder="Plus Two">

</div>

</div>

</div>

</div>

 



<div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_max_mark_plus_2?>" class="form-control"   name="subj_2_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_mark__obtained_plus_2?>" class="form-control"   name="subj_2_mark__obtained_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_2_class_grade_plus_2?>" class="form-control"  name="subj_2_class_grade_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

</div>



<div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_max_mark_plus_2?>" class="form-control"  name="subj_3_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_mark__obtained_plus_2?>" class="form-control"  name="subj_3_mark__obtained_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_3_class_grade_plus_2?>" class="form-control"  name="subj_3_class_grade_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

</div> 

 

 <div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_max_mark_plus_2?>" class="form-control"  name="subj_4_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_mark__obtained_plus_2?>" class="form-control"  name="subj_4_mark__obtained_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->subj_4_class_grade_plus_2?>" class="form-control"  name="subj_4_class_grade_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

</div>







<div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_max_mark_plus_2?>" class="form-control"  name="g_total_max_mark_plus_2" placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_mark__obtained_plus_2?>" class="form-control"   name="g_total_mark__obtained_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->g_total_class_grade_plus_2?>" class="form-control"  name="g_total_class_grade_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

 </div>





<div class="row">

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_max_mark_plus_2?>" class="form-control"  name="m_total_max_mark_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_mark__obtained_plus_2?>" class="form-control"  name="m_total_mark__obtained_plus_2" placeholder="Plus Two">

</div>

</div>

</div>

<div class="col-md-4">

<div class="row">

<div class="col-md-12">

<input type="text" value="<?=$Study[0]->m_total_class_grade_plus_2?>" class="form-control"  name="m_total_class_grade_plus_2"  placeholder="Plus Two">

</div>

</div>

</div>

</div>



   

</div>

<!-- +2 Mark Details end -->



</div> 
 

       </div> 

   </div> 


<div class="row" style="

    padding-bottom: 25px;

">

       <div class="col-md-12">

       <input type="submit" id="Save" class="btn btn-primary" name="submit" value="Update">





</div>

</div>

           </div>			  

       </div>

    </form>










           </div>


          
<?php


//print_r($applied[0]);


?>





            </div>
          </div>
        </div>
      </div><!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>


    <style>







.radio-inline{















  padding-right: 25px;







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

</style>
