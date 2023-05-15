<?php
$userid = $this->session->userdata('user')['user_id'];
$user = $this->db->where('id',$userid)->get('erp_employee_master')->row();
$name=$user->emp_name_;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>hostelassets/dist/css/datepicker.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/dataTable.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/timepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/calendar.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/custom_2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/app.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img alt="HMS" class="pull-left" src="<?php echo base_url().'hostelassets/site/images/logonav.png'?>"><a class="navbar-brand titlehms" href="<?php echo base_url().'hosteladminlogin'?>">Hostel Management System</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <li>
                <h5 class="titlehms"><?php echo $name?></h5>
            </li>

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">

                    <!--<li><a href="<?php echo base_url();?>ui/setting/adduser.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>-->
                    <li><a href="<?php echo base_url();?>hosteladminlogin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?php echo base_url().'hosteladminlogin';?>"><i class="fa fa-2x fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-text fa-fw"></i>Attendence<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentAttendance'?>">Add Attendence</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentAttendanceReport'?>">Attendence Report</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-maxcdn fa-fw"></i>Meal Manage<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addMealRate'?>">Meal Rate</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentMealReport'?>">Meal Report</a>
                            </li>


                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i>Students Manage<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <!--<li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentAdmission'?>">Admission</a>
                            </li>-->
							<li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentHostel'?>">Admission</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listStudentAdmission'?>">Student List</a>
                            </li>
							<li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentReport'?>">Student Report</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listSeatAllocation'?>">Seat Alocation</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-money fa-fw"></i>Students Payment<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentPayments'?>">Add Payments</a>
                            </li>

                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/studentPaymentsReport'?>">Payments Report</a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
					<li>
                        <a href="#"><i class="fa  fa-file-text fa-fw"></i>Inventories<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listInventory'?>">List Inventory</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/inventoryInRooms'?>">Inventory in Rooms</a>
                            </li>


                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i>Employee Manage<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addEmployee'?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listEmployee'?>">List view</a>
                            </li>

                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addSalary'?>">Salary Add</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listSalary'?>">Salary View</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-dollar fa-fw"></i>Vendor Payment<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addVendorPayment'?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listVendorPayment'?>">List View</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa  fa-file-text fa-fw"></i>Bill Manage<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addBill'?>">Add New</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listBill'?>">List View</a>
                            </li>


                        </ul>
                    </li>
                    <li>

                        <a href="#"><i class="fa fa-gears fa-fw"></i>Setup<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <!--<li>
                                <a href="<?php echo base_url().'hosteladminlogin/listFees'?>">Fees</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addMealRate'?>">Meal Rate</a>
                            </li>-->
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/addTimeset'?>">Time Set</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listBlock'?>">Blocks</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url().'hosteladminlogin/listRoom'?>">Rooms</a>
                            </li>

                        </ul>
                    </li>
					<li>
                        <a href="<?php echo base_url().'hosteladminlogin/studentannouncements';?>"><i class="fa fa-list-alt fa-fw"></i> Student Announcements</a>
                    </li>


                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
