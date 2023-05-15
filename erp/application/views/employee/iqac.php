<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
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
            <div class="card-header"><i class="fa fa-table"></i> IQAC List
				 <div class="form-group" style="float:right;">
				 <a href="<?=base_url().'employee/iqacForm'?>">
			<button class="btn btn-sm btn-success" name="submit">Add IQAC</button></a>
		         </div>
		  </div>
		  <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			   <label>From Date</label>
			   <input type="date" class="form-control" value="<?=$from_date1?>" name="from_date">
		         </div>
				 <div class="col-lg-3">
			   <label>From Date</label>
			   <input type="date" class="form-control" value="<?=$to_date1?>" name="to_date">
		         </div>
				 <div class="col-lg-2 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
		        </div>
            </form>				
		
			</div>
         </div>
        </div>
      </div>

	  <?php if(isset($iqac_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="iqac-report" class="table table-bordered">
                <thead>
					<tr>
                        <th>S.No</th>
                        <th>Event Name</th>
                        <th>Event Nature</th>
                        <th>Event Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($iqac_list as $iqaclist){	
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$iqaclist->event_name?></td>
                        <td><?=$iqaclist->event_nature?></td>
                        <td><?=$iqaclist->event_date?></td>
						<td><a href="<?=base_url().'employee/iqacFormEdit/'.$iqaclist->id?>">
						<button class="btn btn-sm btn-warning">Edit</button></a>
						<button class="btn btn-sm btn-danger" id="delete" value="<?=$iqaclist->id?>">Delete</button>
						</td>
                    </tr>
                    <?php } ?>
               
                </tbody>
            </table>
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
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		var myTable = $('#iqac-report').DataTable({});
		var allPages = myTable.rows().nodes().to$();
		$('#delete',allPages).click(function(){
		var id=$(this).val();
		var ele=$(this).parent().parent();	
		if (confirm('Are you sure to Delete?')) {
            $.ajax({
                url: base_url + "employee/iqacDelete",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id:id,
                },
                success: function (data) {
					alert('IQAC Deleted Successfully!!');
					ele.remove();
                }
            });
		}
		});
	});
	</script>