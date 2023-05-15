

		<div class="content-wrapper">
			<section class="content-header">
				<h1>Leaves</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Leaves</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
					<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">All Leaves</h3>
								</div>
								<div class="box-body">
									<table id="allleaves" class="table table-bordered table-stripe">
										<thead>
											<tr>
												<th>#</th>
												<th>EMP CODE</th>
												<th>SUBJECT</th>
												
												<th>DATES</th>
												<th>MESSAGE</th>
												<th>TYPE</th>
												<th>STATUS</th>
												<th>ACTIONS</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-lg-4">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Apply for Leave</h3>
								</div>
								<div class="box-body">
									<form method="post" role="form" data-toggle="validator" id="leave-form">
										<div class="form-group">
											<label for="leave_subject">Leave Subject</label>
											<input type="text" class="form-control" name="leave_subject" id="leave_subject" required />
										</div>
										<div class="form-group">
											<label for="leave_dates">Leave Dates (MM/DD/YYYY)</label>
											<input type="text" class="form-control multidatepicker" name="leave_dates" id="leave_dates" required />
											<small class="text-muted">You can select multiple dates separated by comma.</small>
										</div>
										<div class="form-group">
											<label for="leave_message">Leave Message</label>
											<textarea class="form-control" name="leave_message" id="leave_message" rows="10" required></textarea>
										</div>
										<div class="form-group">
											<label for="leave_type">Leave Type</label>
											<select class="form-control" name="leave_type" id="leave_type" required>
												<option value="">Please make a choice</option>
												<option value="Casual Leave">Casual Leave</option>
												<option value="Earned Leave">Privileged / Earned Leave</option>
												<option value="Sick Leave">Medical / Sick Leave</option>
												<option value="Maternity Leave">Maternity Leave</option>
												<option value="Leave Without Pay">Leave Without Pay</option>
											</select>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary">Apply for Leave</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">My Leaves</h3>
								</div>
								<div class="box-body">
									<table id="myleaves" class="table table-bordered table-stripe">
										<thead>
											<tr>
												<th>#</th>
												<th>SUBJECT</th>
												<th>DATES</th>
												<th>MESSAGE</th>
												<th>TYPE</th>
												<th>STATUS</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</section>
		</div>
