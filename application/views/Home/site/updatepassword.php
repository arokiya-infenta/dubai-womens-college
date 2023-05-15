
<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                  
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b; padding: 150px 0px;">
    <div class="container">
           <div class="">
<?php
$vaidate ="";
           $u_id = $this->uri->segment(3);
		$email_valid = $this->uri->segment(4);

		$qs = $this->db->select("*")->from("stu_user")->where("u_id",$u_id)->where("email_code",$email_valid)->get();

		$res = $qs->num_rows();

	


?>
<form class="well form-horizontal" action="<?=base_url()?>Home/updateCurrentPassword" method="post"  id="contact_form">

<?php
	if($res > 0){

        echo "<h3 style='text-align:center;'>Update Your Passowd</h3>";
        $vaidate ="";
                }else{
        
                    echo "<h3 style='text-align:center;'>timed out please try again</h3>";
                    $vaidate ="readonly";  
        
                }

?>

<input  name="pass_id" id="passe"   value="<?=$u_id?>" class="form-control"  type="hidden">
<input  name="rond" id="rond"  value="<?=$email_valid?>" class="form-control"  type="hidden">

<?=$this->session->flashdata('message');?>
   <h2 style="text-align:center;"><span>Forgot Password</span></h2>
<!-- Form Name -->

<!-- Text input-->

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="pass" id="pass" <?=$vaidate?> required placeholder="Password" class="form-control"  type="password">
</div>
</div>
</div>

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="repass" id="repass" <?=$vaidate?> required placeholder="Retype password " class="form-control"  type="password">
</div>
</div>
</div>

<div class="form-group">
<label class="control-label"></label>
<div class=""><br>

<button type="submit" id="forgotpassword" class="btn btn-warning" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSubmit <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
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
