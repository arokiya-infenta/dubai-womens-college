
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Salaries</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Salaries</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Salary Slips</h3>
							</div>
							<div class="box-body">
								<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
									<table id="admin-salary" class="table table-bordered table-stripe">
										<thead>
											<tr>
												<th>EMP CODE</th>
												<th>NAME</th>
												<th>SALARY MONTH</th>
												<th>EARNINGS</th>
												<th>DEDUCTIONS</th>
												<th>NET SALARY</th>
												<th>ACTIONS</th>
											</tr>
										</thead>
									</table>
								<?php } else { ?>
									<table id="emp-salary" class="table table-bordered table-stripe">
										<thead>
											<tr>
												<th>SALARY MONTH</th>
												<th>EARNINGS</th>
												<th>DEDUCTIONS</th>
												<th>NET SALARY</th>
												<th>ACTIONS</th>
											</tr>
										</thead>
									</table>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>