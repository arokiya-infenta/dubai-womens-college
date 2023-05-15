

		<div class="content-wrapper">
			<section class="content-header">
				<h1>Holidays</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Holidays</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">List of Holidays</h3>
								<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
									<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#HolidayModal">
										<i class="fa fa-plus"></i> Add Holiday
									</button>
								<?php } ?>
							</div>
							<div class="box-body">
								<div class="table-responsiove">
									<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
										<table id="holidays" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th class="text-center">SNO #</th>
													<th>HOLIDAY TITLE</th>
													<th>HOLIDAY DESCRIPTION</th>
													<th class="text-center">HOLIDAY DATE</th>
													<th class="text-center">HOLIDAY TYPE</th>
													<th class="text-center">ACTION</th>
												</tr>
											</thead>
										</table>
									<?php } else { ?>
										<table id="empholidays" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th class="text-center">HOLIDAY #</th>
													<th>HOLIDAY TITLE</th>
													<th>HOLIDAY DESCRIPTION</th>
													<th class="text-center">HOLIDAY DATE</th>
													<th class="text-center">HOLIDAY TYPE</th>
												</tr>
											</thead>
										</table>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<?php if ( $this->session->userdata('user')['user_designation'] == 27 ) { ?>
			<div class="modal fade in" id="HolidayModal" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Holidays</h4>
						</div>
						<form method="post" role="form" data-toggle="validator" id="holiday-form">
							<div class="modal-body">
								<div class="form-group">
									<label for="holiday_title">Holiday Title</label>
									<input type="text" class="form-control" id="holiday_title" name="holiday_title" placeholder="Holiday Title" required />
								</div>
								<div class="form-group">
									<label for="holiday_desc">Description</label>
									<textarea class="form-control" id="holiday_desc" name="holiday_desc" placeholder="Holiday Description" required></textarea>
								</div>
								<div class="form-group">
					                <label for="holiday_date">Holiday Date (MM/DD/YYYY)</label>
					                <div class="input-group date">
					                  	<div class="input-group-addon">
					                    	<i class="fa fa-calendar"></i>
					                  	</div>
					                  	<input type="text" class="form-control datepicker pull-right" id="holiday_date" name="holiday_date" required />
					                </div>
					            </div>
					            <div class="row">
					            	<div class="col-sm-6">
							            <div class="form-group">
											<label for="compulsory_holiday">
												<input type="radio" value="compulsory" id="compulsory_holiday" name="holiday_type" class="minimal" checked /> Compulsory Holiday
											</label>
										</div>
									</div>
									<div class="col-sm-6">
							            <div class="form-group">
											<label for="restricted_holiday">
												<input type="radio" value="restricted" id="restricted_holiday" name="holiday_type" class="minimal" /> Restricted Holiday
											</label>
										</div>
									</div>
					            </div>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="holiday_id" id="holiday_id" />
								<button type="submit" name="submit" class="btn btn-primary">Save Holiday</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>