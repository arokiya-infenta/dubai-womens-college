<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TMSL Alumni Member Register</title>
</head>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/register.css" />

<body>
<div class="text-center">
            <img id="profile-img" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;" height="150px;"  src="https://admission.mssw.in//landing/images/mssw_logo.jpg" />
</div>
<div class="register_wrapper">
	<div class="register_container">
	
		<h1>Alumni Registration</h1>
		<div id="msg"></div>
		<form class="register_form" id="idForm">
			<input type="text" placeholder="Full Name" name="pi_name" required>
			<select id="select" name="pi_gender" required>
				<option value="">Gender</option>
				<option value="Male">Male</option>							
				<option value="Female">Female</option>
				<option value="Others">Others</option>
			</select>
			<input type="text" placeholder="Registration Number" name="pi_register" required>
			<select id="select" name="pi_department" required>
				<option  value="">Department</option>	
				<?php 


				$select = $this->db->select("*")->from("department_details")->get()->result();
				foreach ($select as $key => $value) { ?>
					<option value="<?=$value->short_name?>"><?=$value->comp_name?></option>	
				<?php }
				
				?>						
			
			</select>
			<select id="select" name="pi_batch" required>
				<option>Batch</option>							
				
				<?php 

 $year_from = "2014";
 $year_till = date("Y");
for ($i = $year_from; $i<=$year_till-1; $i++) { ?>
	<option value="<?=$i?>"><?=$i?></option>	
<?php }

?>	


			</select>
			<input type="email" placeholder="Email" name="pi_email" required>
			<input type="text" placeholder="Current Designation" name="pi_designation" required>
			<input type="text" placeholder="Mobile Number" name="pi_mobile" id="mobile" maxlength="10" pattern="[0-9]{10}" required>
			<input type="password" placeholder="Password" name="pi_password" required>
            <button type="submit"  name="register" value="register" >Register</button>
            
		</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
	/* function check(){
	var phoneno=/^\d{10}$/;
	var my=document.getElementById('mobile')
	if(my.value.match(phoneno))
	{
		return true;
	}
	else
	{
		alert ("ENTER VALID MOBILE NUMBER");
		return false;
	}
	} */
	$(document).ready(function(){
	$("#idForm").submit(function(e) {

e.preventDefault(); // avoid to execute the actual submit of the form.

var form = $(this);
var actionUrl = form.attr('action');

$.ajax({
		type: "POST",
		url: "<?=base_url().'alumnilogin/alumniRegister'?>",
		data: form.serialize(), // serializes the form's elements.
		success: function(data)
		{

			if(data==1){

				window.location.href = "<?=base_url().'alumnilogin/alumniLogin'?>";

			}else{


$("#msg").html(data);
			}
			
		}
});

});
});
</script>
</html>
