
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<div class="content-wrapper">
			<section class="content-header">
				<h1>Enter Leaves</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Leaves Taken</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">List of Leaves Entered</h3>
								<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#LeavesModal">
									<i class="fa fa-plus"></i> Add Leave
								</button>
							</div>
							<div class="box-body">
								<div class="table-responsiove">
									<table id="leaveno" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>EMPLOYEE NAME</th>
												<th>LEAVE TYPE</th>
												<th class="text-center">NO OF LEAVES</th>
												<th class="text-center">ACTIONS</th>
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

		<div class="modal fade in" id="LeavesModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">No. of Leaves Takes</h4>
					</div>
					<form method="POST" role="form" data-toggle="validator" id="leaveno-form">
						<div class="modal-body">
							<div class="form-group">
								<label for="emp_code">Employee Code</label><br/>
								<select class="form-control" id="employee_code" name="employee_code" style="width:570px!important;" required>
				                	<option value="">---Select Employee---</option>
									<?php foreach($employee as $employee){ ?>
				                	<option value="<?=$employee->id?>"><?=$employee->employee_id_?></option>
									<?php } ?>
				                </select>
							</div>
							<div class="form-group">
								<label for="leave_type">Leave Type</label>
								<select class="form-control" id="leave_type" name="leave_type" required>
				                	<option value="">---Select Leave Type---</option>
				                	<option value="Casual Leave">Casual</option>
				                	<option value="Earned Leave">Earned</option>
				                	<option value="Maternity Leave">Maternity</option>
				                	<option value="Sick Leave">Medical</option>
				                </select>
							</div>
							<div class="form-group">
				                <label for="no_of_leaves">No. of Leaves</label>
				                <input type="number" class="form-control" id="leave_no" name="leave_no" required>
				            </div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="leave_id" id="leave_id" />
							<button type="submit" name="submit" class="btn btn-primary">Save Leaves</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	