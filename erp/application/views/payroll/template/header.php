<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<title>Attendance - Payroll</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datatables/jquery.dataTables_themeroller.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/dist/css/AdminLTE.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/iCheck/all.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/dist/css/skins/_all-skins.min.css">
	<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/select2/select2.min.css">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		
<header class="main-header">
	<a href="<?php echo base_url(); ?>" class="logo">
		<span class="logo-mini"><b>P</b>M S</span>
		<span class="logo-lg"><b>Payroll</b> MSSW</span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
							<img src="<?php echo base_url(); ?>payrollassets/dist/img/admin-bg.png" class="user-image" alt="User Image">
							<span class="hidden-xs"><?php echo $this->session->userdata('user')['user_name']; ?></span>
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>payrollassets/photos/<?php echo $userData['photo']; ?>" class="user-image" alt="User Image">
							<span class="hidden-xs"><?php echo $userData['first_name']; ?> <?php echo $userData['last_name']; ?></span>
						<?php } ?>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
								<img src="<?php echo base_url(); ?>payrollassets/dist/img/admin-bg.png" class="img-circle" alt="User Image">
							<?php } else { ?>
								<img src="<?php echo base_url(); ?>payrollassets/photos/<?php echo $userData['photo']; ?>" class="img-circle" alt="User Image">
							<?php } ?>
							<p>
								<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
									Administrator
								<?php } else { ?>
									Employee
								<?php } ?>
								<small><?php echo 'MSSW'; ?></small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url(); ?>profile/" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url(); ?>logout/" class="btn btn-default btn-flat">Logout</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>

<?php
$page_name = $this->uri->segment(2);

global $userData;
$attendanceSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "attendance` WHERE `emp_code` = '" . $userData['emp_code'] . "' AND `attendance_date` = '" . date('Y-m-d') . "'");
if ( $attendanceSQL ) {
	$attendanceROW = $attendanceSQL->num_rows();
	if ( $attendanceROW == 0 ) {
		$action_name = 'Punch In';
	} else {
		$attendanceDATA = mysqli_fetch_assoc($attendanceSQL);
		if ( $attendanceDATA['action_name'] == 'punchin' ) {
			$action_name = 'Punch Out';
		} else {
			$action_name = 'Punch In';
		}
	}
} else {
	$attendanceROW = 0;
	$action_name = 'Punch In';
} ?>

<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
					<img src="<?php echo base_url(); ?>payrollassets/dist/img/admin.png" class="img-circle" alt="User Image">
				<?php } else { ?>
					<img src="<?php echo base_url(); ?>payrollassets/photos/<?php echo $userData['photo']; ?>" class="img-circle" alt="User Image">
				<?php } ?>
			</div>
			<div class="pull-left info">
				<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
					<p><?php echo $userData['admin_name']; ?></p>
				<?php } else { ?>
					<p><?php echo $userData['first_name']; ?> <?php echo $userData['last_name']; ?></p>
				<?php } ?>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<?php if ( $this->session->userdata('user')['user_designation'] != 27 ) { ?>
			<?php if ( $attendanceROW < 2 ) { ?>
				<form method="POST" class="employee sidebar-form" role="form" id="attendance-form">
	                <div class="input-group">
	                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Comment (if any)" />
	                    <span class="input-group-btn">
	                    	<button type="submit" id="action_btn" class="btn btn-warning"><?php echo $action_name; ?></button>
	                    </span>
	                </div>
	            </form>
	        <?php } ?>
	    <?php } ?>

		<ul class="sidebar-menu">
			<li class="header">NAVIGATION</li>
			<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
				<li class="<?php echo $page_name == "attendance" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/attendance/">
						<i class="fa fa-calendar"></i> <span>Attendance</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "employees" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/employees/">
						<i class="fa fa-users"></i> <span>Employees Section</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "salaries" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/salaries/">
						<i class="fa fa-money"></i> <span>Salary Slips</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "leaves" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/leaves/">
						<i class="fa fa-sign-out"></i> <span>Leave Management</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "enterLeaves" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/enterLeaves/">
						<i class="fa fa-sign-out"></i> <span>Leaves Taken Entry</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "payheads" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/payheads/">
						<i class="fa fa-gratipay"></i> Pay Heads
					</a>
				</li>
				<li class="<?php echo $page_name == "holidays" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/holidays/">
						<i class="fa fa-calendar-check-o"></i> <span>List Holidays</span>
					</a>
				</li>
			<?php } else { ?>
				<li class="<?php echo $page_name == "salaries" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/salaries/">
						<i class="fa fa-money"></i> <span>Salary Slips</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "leaves" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/leaves/">
						<i class="fa fa-sign-out"></i> <span>Leaves</span>
					</a>
				</li>
				<li class="<?php echo $page_name == "holidays" ? 'active' : ''; ?>">
					<a href="<?php echo base_url(); ?>payrolllogin/holidays/">
						<i class="fa fa-calendar-check-o"></i> <span>Holidays</span>
					</a>
				</li>
			<?php } ?>
		</ul>
	</section>
</aside>
		