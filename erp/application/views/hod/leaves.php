
	<link rel="stylesheet" href="<?php echo base_url(); ?>payrollassets/plugins/datepicker/datepicker3.css">
	
		<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	
				<div class="row">
						<div class="col-lg-12">
							<div class="card">
                                <div class="card-header"><i class="fa fa-table"></i> Leaves
								</div>
								<div class="card-body">
									<form method="post" role="form" data-toggle="validator" id="leave-form">
									<div class="row">
						              <div class="col-lg-4">
										<div class="form-group">
											<label for="leave_subject">Leave Subject</label>
											<input type="text" class="form-control" name="leave_subject" id="leave_subject" required />
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
											<label for="leave_dates">Leave Dates (MM/DD/YYYY)</label>
											<input type="text" class="form-control multidatepicker" name="leave_dates" id="leave_dates" required />
											<small class="text-muted">You can select multiple dates separated by comma.</small>
										</div>
										</div>
										<div class="col-lg-4">
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
										</div>
										<div class="col-lg-12">
										<div class="form-group">
											<label for="leave_message">Leave Message</label>
											<textarea class="form-control" name="leave_message" id="leave_message" rows="3" required></textarea>
										</div>
										</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary">Apply for Leave</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<i class="fa fa-table"></i> My Leaves
								</div>
								<div class="card-body">
								<div class="table-responsive">
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
    if ( $('#myleaves').length > 0 ) {
        var myleave = $('#myleaves').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": baseurl + "hod/LoadingMyLeaves",
            "columnDefs": [{
                "targets": 0,
                "className": "dt-center"
            }]
        });
    }
    /* End of Script */

    /* Leave Apply Form Submit Script Start */
    if ( $('#leave-form').length > 0 ) {
        $('#leave-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type     : "POST",
                dataType : "json",
                async    : true,
                cache    : false,
                url      : baseurl + "hod/ApplyLeaveToAdminApproval",
                data     : form.serialize(),
                success  : function(result) {
                    if ( result.code == 0 ) {
                        /*form[0].reset();
                        $.notify({
                            icon: 'glyphicon glyphicon-ok-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "success",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });*/
						alert('Leave Request Send Successfully!!');
                        myleave.ajax.reload(null, false);
                    } else {
                        $.notify({
                            icon: 'glyphicon glyphicon-remove-circle',
                            message: result.result,
                        },{
                            allow_dismiss: false,
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                        });
                    }
                }
            });
        });
    }
    /* End of Script */
	});
	</script>