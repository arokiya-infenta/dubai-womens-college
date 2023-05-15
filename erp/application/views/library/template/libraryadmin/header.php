<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Admin Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="<?=base_url()?>libraryassets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="<?=base_url()?>libraryassets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?=base_url()?>libraryassets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<!-- Custom Style-->
    <link href="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">

                    <img src="<?=base_url()?>libraryassets/img/logo.png" />
                </a>

            </div>

            <div class="right-div">
                <a href="<?=base_url().'librarylogin/logOut'?>" class="btn btn-danger pull-right">LOG ME OUT</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url().'librarylogin/admin_dashboard';?>" class="menu-top-active">DASHBOARD</a></li>
                           
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Categories <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/addCategory';?>">Add Category</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/manageCategory';?>">Manage Categories</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Authors <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/addAuthor';?>">Add Author</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/manageAuthor';?>">Manage Authors</a></li>
                                </ul>
                            </li>
 <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/addBook';?>">Add Book</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/manageBook';?>">Manage Books</a></li>
                                </ul>
                            </li>

                           <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Issue Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/issueBooks';?>">Issue New Book</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/manageIssuedBooks';?>">Manage Issued Books</a></li>
                                </ul>
                            </li>

							<li><a href="<?php echo base_url().'librarylogin/updateSettings';?>" class="">SETTINGS</a></li>
							<li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> BLOCK <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url().'librarylogin/blockHallTicket';?>">Block HallTicket</a></li>
                                </ul>
                            </li>
                             <!--<li><a href="reg-students.php">Reg Students</a></li>-->
                    
  <li><a href="<?php echo base_url().'librarylogin/changePassword';?>">Change Password</a></li>
  <li><a href="<?php echo base_url().'librarylogin/studentannouncements';?>">Student Announcements</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>