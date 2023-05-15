

		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Employees
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Employees</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">All Employee List</h3>
							</div>
							<div class="box-body">
								<div class="table-responsiove">
									<table id="employees" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ID</th>
												<th>IMAGE</th>
												<th>NAME</th>
												<th>EMAIL</th>
												<th>CONTACT</th>
												<!--<th>IDENTITY</th>
												<th>DOB</th>
												<th>JOINING</th>-->
												<th>BLOOD</th>
												<th>DEPT CODE</th>
												<th width="6%">ACTION</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div class="modal fade in" id="SalaryMonthModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Select Month for Salary</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<?php 
							$months = array(); $years = array();
							$before2Month = (int)date('m') - 2;
							for ( $i = $before2Month; $i < $before2Month + 16; $i++ ) {
							    $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
							    $years[$i] = date('Y', mktime(0, 0, 0, $i, 1));
							}
							foreach ( $months as $key => $month ) { ?>
								<div class="col-sm-3 <?php echo ($month == date('F') && $years[$key] == date('Y')) ? 'bg-danger' : ''; ?>">
									<a data-month="<?php echo $month; ?>" data-year="<?php echo $years[$key]; ?>" href="#">
										<?php echo strtoupper($month); ?><br /><?php echo $years[$key]; ?>
									</a>
								</div>
							<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade in" id="ManageModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title text-center">Add Payheads to Employee</h4>
					</div>
					<form method="post" role="form" data-toggle="validator" id="assign-payhead-form">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-4">
									<label for="all_payheads">List of Pay Heads</label>
									<button type="button" id="selectHeads" class="btn btn-success btn-xs pull-right"><i class="fa fa-arrow-circle-right"></i></button>
									<select class="form-control" id="all_payheads" name="all_payheads[]" multiple size="10"></select>
								</div>
								<div class="col-sm-4">
									<label for="selected_payheads">Selected Pay Heads</label>
									<button type="button" id="removeHeads" class="btn btn-danger btn-xs pull-right"><i class="fa fa-arrow-circle-left"></i></button>
									<select class="form-control" id="selected_payheads" name="selected_payheads[]" data-error="Pay Heads is required" multiple size="10" required></select>
								</div>
								<div class="col-sm-4">
									<label for="selected_payamount">Enter Payhead Amount</label>
									<div id="selected_payamount"></div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="empcode" id="empcode" />
							<button type="submit" name="submit" class="btn btn-primary">Add Pay Heads to Employee</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade in" id="EditEmpModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Update Employee Details</h4>
					</div>
					<form method="post" role="form" data-toggle="validator" id="edit-emp-form">
						<div class="modal-body">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="emp_code">Emp. Code</label>
										<div class="form-control" id="emp_code" id="emp_code"></div>
										<input type="hidden" name="emp_id" id="emp_id" />
									</div>
									<div class="col-sm-4">
										<label for="first_name">Employee Name</label>
										<input type="text" class="form-control" name="first_name" id="first_name" required />
									</div>
									<div class="col-sm-4">
										<label for="mobile">Mobile</label>
										<input type="text" class="form-control" name="mobile" id="mobile" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="email">Email</label>
										<input type="email" class="form-control" name="email" id="email" required />
									</div>
									<div class="col-sm-4">
										<label for="dob">Emp. DOB (MM/DD/YYYY)</label>
										<input type="text" class="form-control datepicker" name="dob" id="dob" required />
									</div>
									<div class="col-sm-4">
										<label for="joining_date">DOJ (MM/DD/YYYY)</label>
										<input type="text" class="form-control datepicker" name="joining_date" id="joining_date" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="gender">Gender</label>
										<select class="form-control" name="gender" id="gender" required>
											<option value="">Please make a choice</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
									<div class="col-sm-4">
										<label for="merital_status">Marital Status</label>
										<input type="text" class="form-control" name="merital_status" id="merital_status" required />
									</div>
									<div class="col-sm-4">
										<label for="blood_group">Blood Group</label>
										<input type="text" class="form-control" name="blood_group" id="blood_group" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12">
										<label for="address">Address</label>
										<textarea class="form-control" name="address" id="address" required></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="city">City</label>
										<input type="text" class="form-control" name="city" id="city" required />
									</div>
									<div class="col-sm-4">
										<label for="state">State</label>
										<input type="text" class="form-control" name="state" id="state" required />
									</div>
									<div class="col-sm-4">
										<label for="country">Country</label>
										<input type="text" class="form-control" name="country" id="country" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="nationality">Nationality</label>
										<input type="text" class="form-control" name="nationality" id="nationality" required />
									</div>
									<div class="col-sm-4">
										<label for="bank_name">Bank Name</label>
										<input type="text" class="form-control" name="bank_name" id="bank_name" required />
									</div>
									<div class="col-sm-4">
										<label for="account_no">Bank A/C No.</label>
										<input type="text" class="form-control" name="account_no" id="account_no" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label for="ifsc_code">IFSC Code</label>
										<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" required />
									</div>
									<div class="col-sm-4">
										<label for="pf_account">PF A/C No.</label>
										<input type="text" class="form-control" name="pf_account" id="pf_account" required />
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" name="submit" class="btn btn-primary">Update Employee</button>
						</div>
					</form>
				</div>
			</div>
		</div>