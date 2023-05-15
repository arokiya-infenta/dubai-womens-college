
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datepicker/datepicker3.css">
	
		<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	
						<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<i class="fa fa-table"></i> Holidays
								</div>
								<div class="card-body">
								<div class="table-responsive">
									<table id="empholidays" class="table table-bordered table-stripe">
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
    if ( $('#empholidays').length > 0 ) {
        var empholidays = $('#empholidays').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "employee/LoadingHolidays",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */
	});
	</script>