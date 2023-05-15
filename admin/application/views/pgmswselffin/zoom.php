<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
	      <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
	    <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
            <div class="card-header">Students List</div>
            <div class="card-body">
			
			<form action="" method="post">
		  <div class="row">
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Title</label>
		  <input type="text" class="form-control" name="title">
		  <span style="color:red;"><?php echo form_error('title'); ?></span>
		  </div>
		</div>
        <div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Date</label>
		  <input type="date" class="form-control" name="start_date">
		  <span style="color:red;"><?php echo form_error('start_date'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Time</label>
		  <input type="time" class="form-control" name="start_time">
		  <span style="color:red;"><?php echo form_error('start_time'); ?></span>
		  </div>
		</div>
		  </div>
		  
		  <div class="row">
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Duration(in min)</label>
		  <input type="number" class="form-control" name="duration">
		  <span style="color:red;"><?php echo form_error('duration'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Password</label>
		  <input type="text" class="form-control" name="password" maxlength="10" title="Max characters 10">
		  <span style="color:red;"><?php echo form_error('password'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3 mt-4">
		  <div class="form-group">
		  <input type="submit" class="btn btn-sm btn-primary" name="submit">
		  </div>
		</div>
		 </div>
		  </form><br> 
			  
			</div>
		   </div>
		</div>
	  </div>	
	 

	 <?php if(isset($get_links)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			   <h4>Meetings List</h4>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Action</th>
                        <th>Meeting ID</th>
                        <th>Start Date</th>
                        <th>Time</th>
                        <th>Password</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(isset($get_links)){
					$sno=1;
					foreach($get_links as $links)
					{
				?>
                    <tr>
                        <td><?php echo $sno;?></td>
                        <td><?php echo $links->title; ?></td>
                        <td>
						<a href="<?php echo $links->link; ?>" target="_blank">
						<button class="btn-primary">Start</button></a>
						<a href="<?php echo base_url('zoom/zoom_edit/').$links->id; ?>">
						<button class="btn-success">Edit</button></a>
						<?php if($links->confirm_status == 0){ ?>
						<button class="btn-danger delete" data-id="<?php echo $links->id; ?>">Delete</button>
<?php } ?>

						</td>
                        <td><?php echo $links->meeting_id; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($links->start_date)); ?></td>
                        <td><?php echo date("H:i",strtotime($links->start_time)); ?></td>
                        <td><?php echo $links->password; ?></td>
                        <td><?php echo $links->link; ?></td>
                    </tr>
					<?php $sno++;}}?>
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
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<!--Data Tables js-->

    <script>
     $(document).ready(function() {
      //Default data table
       $('#default-datatable').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );

    </script>  
<!-- Other Scripts-->  
<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
$(document).ready(function() {
	$(document).on("click", ".delete", function() { 
	//alert("Success");
		var id1 = $(this).attr("data-id");
	swal({
        title: "Are you sure?",
        text: "You will not be able to recover this file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn-sm",
        cancelButtonClass: "btn-secondary btn-sm",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
	  function(isConfirm) {
	    if(isConfirm){
		var $ele = $(this).parent().parent();
		$.ajax({
			url: "<?php echo base_url();?>zoom/delete_zoom",
			method: "POST",
			cache: false,
			data:{
				type: 2,
				id: id1
			},
			success: function(dataResult){
				//alert(dataResult);
				swal("Deleted!", "Your file has been deleted.", "success");
				//var dataResult = JSON.parse(dataResult);
				//if(dataResult.statusCode==200){
					//$ele.fadeOut().remove();
				//}
				if(dataResult){
					$ele.fadeOut().remove();
				}
				//dataTable.ajax.reload();
				window.location.href="<?php echo base_url();?>zoom/index";
			}
		});
		}else{
			swal("Cancelled", "Your file is safe :)", "error");
		}
	});
	});
});
</script>