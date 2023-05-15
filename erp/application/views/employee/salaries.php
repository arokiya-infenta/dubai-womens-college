
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datepicker/datepicker3.css">
	
		<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	
						<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<i class="fa fa-table"></i> Salaries
								</div>
								<div class="card-body">
								<div class="table-responsive">
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
								</div>
								</div>
							</div>
						</div>
				</div>
		</div>
		</div>

	<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	$(document).ready(function() {
		var baseurl = '<?php echo base_url();?>';
	/* Leave Table Script Start */
    if ( $('#emp-salary').length > 0 ) {
        var emp_salary = $('#emp-salary').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "employee/LoadingSalaries",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */
	});
	</script>