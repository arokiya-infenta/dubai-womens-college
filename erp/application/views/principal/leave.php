
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
			
	  <?php if(isset($leave_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="leave-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Leave Type</th>
                        <th>Subject</th>
                        <th>Dates</th>
                        <th>Hod Approval</th>
                        <th>Principal Approval</th>
                        <th>AO Approval</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach ($leave_list as $leave) {
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$leave->emp_name_?></td>
                        <td><?=$leave->leave_type?></td>
                        <td><?=$leave->leave_subject?></td>
                        <td><?=$leave->leave_dates?></td>
												<td><?=$leave->leave_status_hod?></td>
                        <td><?=$leave->leave_status_principal?></td>
                        <td><?=$leave->leave_status?></td>
                        <td><?php if($leave->leave_status_principal == 'pending'){ ?>
						<button type="button" class="btn btn-success btn-sm approve" data-status="approve" data-id="<?=$leave->leave_id?>"><i class="fa fa-check"></i></button>
						<button type="button" class="btn btn-danger btn-sm approve" data-status="reject" data-id="<?=$leave->leave_id?>"><i class="fa fa-close"></i></button>
						<?php } else { ?>
						<span><?=$leave->leave_status_principal?></span>
						<?php } ?>
						</td>
                    </tr>
						<?php } ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } ?>
	  <!-- End Row-->
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myTable = $('#leave-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();
	
		$('.approve').click(function(){
		var leave_id=$(this).data('id');
		var status=$(this).data('status');
		 if (confirm('Are you sure to update Leave?')) {
            $.ajax({
                url: base_url + "principal/leaveApprove",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    leave_id: leave_id,status: status,
                },
                success: function (data) {
					alert('Leave Status Updated Successfully!!');
					location.reload(true)
                }
            });
		 }
		});
	});
	</script>
