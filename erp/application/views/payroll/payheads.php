

		<div class="content-wrapper">
			<section class="content-header">
				<h1>Pay Heads</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Pay Heads</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">List of Pay Heads</h3>
								<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#PayheadsModal">
									<i class="fa fa-plus"></i> Add Pay Head
								</button>
							</div>
							<div class="box-body">
								<div class="table-responsiove">
									<table id="payheads" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th>HEAD NAME</th>
												<th>DESCRIPTION</th>
												<th class="text-center">HEAD TYPE</th>
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

		<div class="modal fade in" id="PayheadsModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Pay Heads</h4>
					</div>
					<form method="POST" role="form" data-toggle="validator" id="payhead-form">
						<div class="modal-body">
							<div class="form-group">
								<label for="payhead_name">Pay Head Name</label>
								<input type="text" class="form-control" id="payhead_name" name="payhead_name" placeholder="Pay Head Name" required />
							</div>
							<div class="form-group">
								<label for="payhead_desc">Pay Head Description</label>
								<textarea class="form-control" id="payhead_desc" name="payhead_desc" placeholder="Pay Head Description" required></textarea>
							</div>
							<div class="form-group">
				                <label for="payhead_type">Pay Head Type:</label>
				                <select class="form-control" id="payhead_type" name="payhead_type" required>
				                	<option value="">---Select Pay Head Type---</option>
				                	<option value="earnings">Earnings</option>
				                	<option value="deductions">Deductions</option>
				                </select>
				            </div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="payhead_id" id="payhead_id" />
							<button type="submit" name="submit" class="btn btn-primary">Save Pay Head</button>
						</div>
					</form>
				</div>
			</div>
		</div>
