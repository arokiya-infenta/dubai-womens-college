<?php $alusername = $this->session->userdata('user')['alname']; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Alumni Student</title>

</head>



<link rel="stylesheet" href="<?php echo base_url(). 'alumniassets/css/header_navigationbar.css';?>" />

  <!--favicon-->

  <link rel="icon" href="<?=base_url()?>white-version/image/th.ico" type="image/x-icon">

  <!-- Vector CSS -->

  <link href="<?=base_url()?>white-version/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

  <!-- simplebar CSS-->

  <link href="<?=base_url()?>white-version/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>

  <!-- Bootstrap core CSS-->

  <link href="<?=base_url()?>white-version/assets/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- animate CSS-->

  <link href="<?=base_url()?>white-version/assets/css/animate.css" rel="stylesheet" type="text/css"/>

  <!-- Icons CSS-->

  <link href="<?=base_url()?>white-version/assets/css/icons.css" rel="stylesheet" type="text/css"/>

  <!-- Sidebar CSS-->

  <link href="<?=base_url()?>white-version/assets/css/sidebar-menu.css" rel="stylesheet"/>

  <!-- Custom Style-->

  <link href="<?=base_url()?>white-version/assets/css/app-style.css" rel="stylesheet"/>

  <link href="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

  <link href="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">



<body bgcolor="white">

<div>

<!--<img src="<?php echo base_url(). 'alumniassets/image/home_header.jpg';?>" width="100%" height="250px" />-->

</div>

<table class="table">

<tr>

<td>

<ul class="ul1" style="background-color: black;">

	<div class="dropdown">

	<li class="li_image"><img src="<?php echo base_url()?>alumniassets/image/s_logo.png" width="150px" height="80px"  style="padding-left:15px;padding-right:15px" /></li>

    </div>

    <div class="dropdown">

    <li class="li1 active"><a href="<?=base_url()?>alumnilogin/alumniHome"><span class="span1">My Profile</span></a></li>

    <div class="dropdown-content">

    		<a href="<?=base_url().'alumnilogin/updateMemberProfile'?>">Update Profile</a>

   		</div>

    </div>

    <div class="dropdown">

  	<li class="li1"><a href="<?=base_url().'alumnilogin/listForum'?>"><span class="span1">Forum</span></a></li>

    	<div class="dropdown-content">

	    

					<a href="<?=base_url().'alumnilogin/addForum'?>">Add New Forum Post</a>

           

   		</div>

    </div>


		<div class="dropdown">

<li class="li1"><a href="<?=base_url().'alumnilogin/announcementMember'?>"><span class="span1">Announcement Board</span></a></li>

</div>
<div class="dropdown">

  	<li class="li1"><a href="<?=base_url().'alumnilogin/eventsMember'?>"><span class="span1">Events</a></span></li>

    </div>



    <div class="dropdown">

  	<li class="li1"><a href="<?=base_url().'alumnilogin/searchAlumni'?>"><span class="span1">Search Alumni</span></a></li>

    </div>

    <!--<div class="dropdown">

    <li class="li1"><a href="<?=base_url().'alumnilogin/alumniFinancial'?>"><span class="span1">Financial Record</span></a></li>

    </div>-->

    <li class="li2"><span class="span2"><?php

	echo "Welcome "." ".$alusername;

	?></span>

    <a href="<?=base_url()?>/alumnilogin/memberlogOut"><span class="span1">Logout</span></a></li>

</ul>

</td>

</tr>

</table>

