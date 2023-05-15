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
		  <?php $this->session->set_flashdata('success',''); ?>
	    <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
            <div class="card-header"> Create Panel</div>
            <div class="card-body">
			
			<form action="" method="post">
		  <div class="row">
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Title</label>
		  <input type="text" class="form-control" name="title" id="title" value="<?=set_value('title')?>">
		  <span style="color:red;"><?php echo form_error('title'); ?></span>
		  <input type="hidden" id="edit_id" name="edit_id">
		  </div>
		</div>
        <div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Date</label>
		  <input type="date" class="form-control" name="start_date" id="date" value="<?=set_value('start_date')?>">
		  <span style="color:red;"><?php echo form_error('start_date'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Time</label>
		  <input type="time" class="form-control" name="start_time" id="time" value="<?=set_value('start_time')?>">
		  <span style="color:red;"><?php echo form_error('start_time'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Count</label>
		  <input type="number" class="form-control" name="count" id="count" value="">
		  <span style="color:red;"><?php echo form_error('count'); ?></span>
		  </div>
		</div>
		  </div>
		  
		  <div class="row">
		<div class="col-lg-9">
		  <div class="form-group">
		  <label>Venue</label>
		  <textarea type="number" class="form-control" name="venue" id="venue" value="<?=set_value('venue')?>"></textarea>
		  <span style="color:red;"><?php echo form_error('venue'); ?></span>
		  </div>
		</div>
		<div class="col-lg-2 mt-5">
		  <div class="form-group" style="float:right;">
		  <input type="submit" class="btn btn-sm btn-primary" name="submit">
		  </div>
		</div>
		 </div>
		  </form><br> 
			  
			</div>
		   </div>
		</div>
	  </div>	
	 

	 <?php if(isset($panel)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			   <h4>Panels List</h4>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="wopanel" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(isset($panel)){
					$sno=1;
					foreach($panel as $panel)
					{
						if($panel->count=='' || $panel->count==0){$count='-';}else{$count=$panel->count;}
				?>
                    <tr>
                        <td><?php echo $sno;?></td>
                        <td><?php echo $panel->title; ?></td>
                        <td><?php echo date("h:i A",strtotime($panel->start_time)); ?></td>
                        <td><?php echo date("d-m-Y",strtotime($panel->start_date)); ?></td>
                        <td><?php echo $count; ?></td>
                        <td>
						<button class="btn-success edit" data-id="<?php echo $panel->id; ?>">Edit</button>
						<?php if($panel->confirm_status == 0){ ?>
						<button class="btn-danger delete" data-id="<?php echo $panel->id; ?>">Delete</button>
						<?php } ?>
						</td>
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
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myTable = $('#wopanel').DataTable();
var allPages = myTable.rows().nodes().to$();
		
		$('.edit',allPages).click(function(){
		var id=$(this).data("id");
            $.ajax({
                url: base_url + "pgMswAided/updatePanel",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                },
                success: function (data) {
					var dataResult = JSON.parse(data);
					var edit_id = dataResult.id;
					var title = dataResult.title;
					var date = dataResult.start_date;
					var time = dataResult.time1;
					var venue = dataResult.venue;
					var count = dataResult.count;
					
					$('#edit_id').val(edit_id);
					$('#title').val(title);
					$('#date').val(date);
					$('#time').val(time);
					$('#venue').val(venue);
					$('#count').val(count);
                }
            });
		});

		
		
	$(document).on("click", ".delete", allPages, function() { 
	//alert("Success");
		var id1 = $(this).attr("data-id");
		var $ele = myTable.row($(this).parent().parent());
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
		$.ajax({
			url: "<?php echo base_url();?>pgMswAided/deletePanel",
			method: "POST",
			cache: false,
			data:{
				type: 2,
				id: id1
			},
			success: function(dataResult){
				swal("Deleted!", "Your file has been deleted.", "success");
				if(dataResult){
					$ele.remove().draw();
				}
			}
		});
		}else{
			swal("Cancelled", "Your file is safe :)", "error");
		}
	});
	});
	
	});
	</script>