<?php
$desig=$this->db->where('id',$empDATA->emp_designation_)->get('erp_department')->row();	
	 if($empDATA->emp_profile_==null){$url = base_url().'system/images/user.png';}
     else{$url = base_url().'system/images/employee/'.$empDATA->emp_profile_;
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>Employee Information - Payroll</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/dist/css/AdminLTE.css">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="hold-transition register-page">
	<div class="container">
		<div class="register-box">
		  	<div class="register-logo">
		    	<a href="<?php echo base_url(); ?>reports/<?php echo $empData->employee_id_; ?>/"><b>Payroll</b> Management</a>
		    	<small>Employee Code: <?php echo $empDATA->employee_id_; ?></small>
		  	</div>
		</div>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Employee Information</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<label class="col-sm-3">Full Name</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_name_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">DOB</label>
					<div class="col-sm-9">
						<p><?php echo $empDATA->emp_dob_; ?></p>
					</div>
				</div>
		        <div class="row">
			        <label class="col-sm-3">Gender</label>
			        <div class="col-sm-9">
			            <p><?php echo ucwords($empDATA->emp_gender_); ?></p>
			        </div>
			    </div>
				<div class="row">
					<label class="col-sm-3">Marital status</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_maritalstatus_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Nationality</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_nationality_); ?></p>
					</div>
				</div>
				<hr />
				<div class="row">
					<label class="col-sm-3">Address</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_address_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">City</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_city_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">State</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_state_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Country</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_country_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Email Id</label>
					<div class="col-sm-9">
						<p><?php echo $empDATA->emp_mail_; ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Mobile No</label>
					<div class="col-sm-9">
						<p><?php echo $empDATA->emp_mobile_; ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Identification</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($empDATA->emp_document_); ?></p>
					</div>
				</div>
				<hr />
				<div class="row">
					<label class="col-sm-3">Emp. Type</label>
					<div class="col-sm-9">
						<p><?php echo ucwords($desig->dept_name_); ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Joining Date</label>
					<div class="col-sm-9">
						<p><?php echo $empDATA->emp_doj_; ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Blood Group</label>
					<div class="col-sm-9">
						<p><?php echo $empDATA->emp_bgroup_; ?></p>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-3">Photograph</label>
					<div class="col-sm-9">
						<p><img width="100" height="100" class="img-responsive" src="<?php echo $url; ?>" alt="<?php echo $empDATA->emp_name_; ?>" /></p>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>payrollassets/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
