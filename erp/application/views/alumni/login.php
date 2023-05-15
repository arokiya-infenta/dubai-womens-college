<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TMSL ALumni Login</title>
</head>

<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/login.css" />
  
<body>
<div class="text-center">
            <img id="profile-img" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;" height="150px;"  src="https://admission.mssw.in//landing/images/mssw_logo.jpg" />
</div>
<div class="login_wrapper">
	<div class="login_container">
		<h1>Alumni Login </h1>
		<?php

echo $this->session->flashdata('item');
 $this->session->set_flashdata('item','');

?>
		<form class="login_form" action="<?=base_url().'alumnilogin/alumniLogin'?>" method="post">
        	<!--<select name="login_usertype" >
            <option value="alumni">Alumni</option>
            <option value="administrator"> Administrator</option>
            </select>-->
			<input type="text" placeholder="User Name" name="login_userid">
			<input type="password" placeholder="Password" name="login_password">
			<button type="submit" style="background-color: blue;color:white;" name="login">Login</button>
            <a href="<?=base_url().'alumnilogin/alumniRegister'?>"><button type="button"  style="background-color: blue;color:white;"  name="register">Register</a></button>
           
            <!--<a href="forgot_password.php">Forgot Password?</a>-->
		</form>
	</div>
</div>
</body>
</html>
