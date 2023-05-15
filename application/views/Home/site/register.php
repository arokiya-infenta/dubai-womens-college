
<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                      
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b; padding: 40px 0px;">
    <div class="container">
           <div class="">


<form class="well form-horizontal" action="" method="post"  id="contact_form">
<fieldset>
 <h2 style="text-align:center;"><span>Register</span></h2>
<!-- Form Name -->

<!-- Text input-->

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

<select name="course" id="course"  class="form-control" >
  <option value="">Select Course</option>
  <?php foreach($college_course as $value){  ?>



  <option value="<?=$value->mc_id?>"><?=$value->mc_name?></option>

  <?php }  ?>

</select>
</div>
</div>
</div>

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<label id ="fname_val"></label>
<input  name="first_name" id="firstname" placeholder="First Name" class="form-control"  type="text">
</div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
<label class="control-label" ></label> 
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<label id ="lname_val"></label>
<input name="last_name" id="lastname" placeholder="Last Name" class="form-control"  type="text">
</div>
</div>
</div>



<!-- Text input-->

<!--<div class="form-group">
<label class="col-md-4 control-label"></label>  
<div class="col-md-4 inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="user_name" placeholder="Username" class="form-control"  type="text">
</div>
</div>
</div>-->

<!-- Text input-->

<div class="form-group">
<label class="control-label" ></label> 
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<label id ="passwordcou"></label>
<input name="user_password" id="pass" placeholder="Password" class="form-control"  type="password">
</div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
<label class="control-label" ></label> 
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<label id ="passwordrety"></label>
<input name="confirm_password" id="retypepass" placeholder="Confirm Password" class="form-control"  type="password">
</div>
</div>
</div>

<!-- Text input-->
   <div class="form-group">
<label class=" control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
    <label id ="email_val"></label>
<input name="email" id="email" placeholder="E-Mail Address" class="form-control"  type="text">
</div>
</div>
</div>


<!-- Text input-->
   
<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    <label id ="mobile_val"></label>
<input name="contact_no" id="mobile" placeholder="Mobile" class="form-control" type="text">
</div>
</div>
</div>

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    <input  type="checkbox" required name="ack"  id="defaultCheck1">
I have read and understood the instructions furnished.
</div>
</div>
</div>

<!-- Select Basic -->

<!-- Success message -->
<!--<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Success!.</div>
-->
<!-- Button -->
<div class="form-group">
<label class="control-label"></label>
<div class="">
<button type="submit" id="submit" class="btn btn-warning" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspRegister <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
</div>
</div>

</fieldset>
</form>

</div><!-- /.container -->
        
        
        </div>            

           </div>			  
       </div>
    </div>
<!-- end section -->
<style>

</style>
