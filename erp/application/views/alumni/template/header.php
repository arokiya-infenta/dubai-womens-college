<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Admin Nav</title>

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

<table class="table" class="table" style="background: black;">

<tr>

<td>

<ul class="ul1">

	<div class="dropdown">

	<li class="li_image"><img src="<?php echo base_url(). 'alumniassets/image/s_logo.png';?>" width="150px" height="80px" style="padding-left:15px;padding-right:15px" /></li>

    </div>

    <div class="dropdown">

    <li class="li1 active"><a href="<?=base_url().'alumnilogin'?>"><span class="span1">Home</span></a></li>

    </div>

    <div class="dropdown">

  	<li class="li1"><a href="#"><span class="span1">News</span></a></li>

    	<div class="dropdown-content">

    		<a href="<?=base_url().'alumnilogin/announcement'?>">Announcement Board</a>

    		<a href="<?=base_url().'alumnilogin/events'?>">Events</a>

   		</div>

    </div>

    <div class="dropdown">

  	<li class="li1"><a href="<?=base_url().'alumnilogin/listForum'?>"><span class="span1">E-Forum</span></a></li>

    <div class="dropdown-content">

    		<a href="<?=base_url().'alumnilogin/addForum'?>">Add New Forum Post</a>

            <a href="<?=base_url().'alumnilogin/deleteForum'?>">Delete Forum Post</a>

   		</div>

    </div>

	<div class="dropdown">

  	<li class="li1"><a href="<?=base_url().'alumnilogin/searchAlumni'?>"><span class="span1">Search Alumni</span></a></li>

    </div>

   <!-- <div class="dropdown">

    <li class="li1"><a href="<?=base_url().'alumnilogin/financialRecord'?>"><span class="span1">Financial</span></a></li>

		<div class="dropdown-content">

    		<a href="<?=base_url().'alumnilogin/newPayment'?>">New Payment</a>

   		</div>

    </div>-->

	<div class="dropdown">

	<li class="li1"><a href="<?=base_url().'alumnilogin/manageAlumni'?>"><span class="span1">Alumni</span></a></li>

	</div><li class="li2">

	<span class="span2"><?php

	$userid=$this->session->userdata('user')['user_id']; 

	$username1 = $this->db->where('id',$userid)->get('erp_employee_master')->row();

	echo "Welcome ".$username1->emp_name_;

	?></span>

    <a href="<?=base_url().'alumnilogin/logout'?>"><span class="span1">Logout</span></a></li>

</ul>

</td>

</tr>

</table>

