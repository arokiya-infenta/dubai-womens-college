<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>Madras School of Social Work</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="#" type="image/x-icon" />
    <link rel="apple-touch-icon" href="#" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/landing/css/bootstrap.min.css" />
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/landing/css/pogo-slider.min.css" />
    <!-- Site CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/landing/css/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/landing/css/responsive.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/landing/css/custom.css" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">
      <!-- LOADER -->
      <div id="preloader">
        <div class="loader">
            <img src="<?=base_url()?>/landing/images/loader.gif" alt="#" />
        </div>
    </div>
    <!-- end loader -->
    <!-- END LOADER -->
    <header class="top-header">



        <nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="<?=base_url()?>/landing/images/mssw_logo.jpg" alt="image"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent" >

<div class="d-flex flex-column ml-auto">
<div class="r_num" >

<?php if(isset($this->session->userdata('user')['user_id']) ){?>

  
<p class ="m-0 text-end ">Ref No : <?=substr( $this->session->userdata('user')['user_year'], -2)?><?=sprintf("%'04d", $this->session->userdata('user')['user_id'])?></p>
<?php } ?>
<!--<p class ="m-0 text-end ">Referance NO : 21212122</p>-->
</div>


    <ul class="navbar-nav ml-auto navbar-right m-0"  >
     <!-- <li class="nav-item active">
        <a class="nav-link" href="#">DashBor <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>-->

      
      <?php if(!isset($this->session->userdata('user')['user_id']) ){?>
						<li><a style="float:right;" class="nav-link" href="<?=base_url()?>/Home/login">login</a></li>
                       <!-- <li><a class="nav-link" href="<?=base_url()?>/Home/Register">Register</a></li>-->
                        <?php }else{ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Menus
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="float:right;">
          <a class="dropdown-item" href="<?=base_url()?>/Home/dashBoard">Dashboard</a>
          <a class="dropdown-item" href="<?=base_url()?>/Admissions">Admission</a>

<?php 
$qm = $this->db->select("*")->from("shotlisted_candidate")->where("sl_student_id",$this->session->userdata('user')['user_id'])->where('reservation_status',1)->where('principal_published',1)->get();

$rest = $qm->num_rows();

if($rest > 0){
$q = $this->db->select("*")->from("admitted_student")->where("as_student_id",$this->session->userdata('user')['user_id'])->get();

$res = $q->num_rows();


if($res > 0){


  ?>
          <a class="dropdown-item" href="#">Academic</a>
          <a class="dropdown-item" href="#">Examination</a>

          
          <!---<a class="dropdown-item" href="#">Pay Fees</a>-->
          <a class="dropdown-item" href="#">Others</a>


<?php } ?>
<a class="dropdown-item" href="<?=base_url()?>/PayFees">Pay Fees</a>
<?php } ?>
<a class="dropdown-item" href="#">Others</a>
          <!--<div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>-->
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSetting" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownSetting" style="float:right;">
          <a class="dropdown-item" href="<?=base_url()?>/Studentsetting">Update Photo</a>
          <a class="dropdown-item" href="#">View My Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=base_url()?>/Home/logOut">Logout</a>
        </div>
      </li>
      <?php } ?>
     <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>-->
    </ul>
    </div>
  </div>



                <!--<div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                   
						
                        <?php if(!isset($this->session->userdata('user')['user_id']) ){?>
						<li><a class="nav-link" href="<?=base_url()?>/Home/login">login</a></li>
                      <li><a class="nav-link" href="<?=base_url()?>/Home/Register">Register</a></li>
                        <?php }else{ ?>
                            <li><a class="nav-link" href="<?=base_url()?>/Home/dashBoard">Dashboard</a></li>
                      
                            <li><a class="nav-link " href="<?=base_url()?>/Home/logOut">log out</a></li>
                            <li>
                              
                            <div class="dropdown" style="float:right;">
  <button class="dropbtn">Menu</button>
  <div class="dropdown-content">
  <a href="<?=base_url()?>/Studentsetting">Update Photo</a>
  <a href="<?=base_url()?>/PayFees">Pay Fees</a>
  <a href="#">Setting</a>

  </div></li>

                        <?php } ?>
				
                    </ul>
                </div>
      
            
            </div>-->
        </nav>  
    </header>
    <style>
.dropbtn {
 /*  background-color: #4CAF50;
  color: white; */
  padding: 6px;
  /*font-size: 16px;*/
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: #12385b;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
    color: white;
  background-color: #12385b;
}
.r_num p{
color:#12385b;


}.r_num{
  text-align: right;
}
</style>
    