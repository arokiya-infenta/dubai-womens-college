<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	<div class="profile-main">
      <!--Start Dashboard Content-->
      <div class="profile-header"> 
   
     
 <?php 
 $thisi = $this->uri->segment(3);
 $ud = $this->db->select("u_email_id,u_mobile")->from("stu_user")->where("u_id", $thisi)->get();
    $res = $ud->result();




?>


<div class="row">
<div class="col-md-12 course-details">
<br>
<br>
<br>
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
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="card">
            <div class="card-header"><h5>Update Student Email Address & Mobile Number</h5></div>
            <div class="card-body">
<form  method="post" action="<?=base_url()?>UgSelfFinance/updateStuPerInfo/">

<br>
<br>
<br>
<br>

<!-- Form Name -->



<input type="hidden" name="student_id" value="<?=$thisi?>"?>
<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Email Address</label>
  <div class="col-md-9">
  <input id="textinput" name="email" required type="email" value="<?=$res[0]->u_email_id?>" class="form-control input-md">
  </div>
</div>
<div class="row form-group">
  <label class="col-md-3 control-label" for="selectbasic">Mobile Number</label>
  <div class="col-md-9">
  <input id="textinput" name="mobile" required type="text" value="<?=$res[0]->u_mobile?>" class="form-control input-md">
  </div>
</div>
<div class="form-group">
 
  <div class="col-md-4">
    <button id="singlebutton" type="submit" name="singlebutton" class="btn btn-primary">Update</button>
  </div>
</div>

<div class="col-md-2"></div>
</div>




<!-- Button -->



</form>

</div>
</div>
</div>
</div>



















    </div>
    </div>
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .center_div{
    margin: 0 auto;
    width:80% /* value of your choice which suits your alignment */
}
   .ls-view {
    float: right;
    color: black;
}
    </style>