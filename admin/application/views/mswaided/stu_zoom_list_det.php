<?php 
$start_date=empty($srch['start_date']) ? '' : date('Y-m-d',strtotime($srch['start_date']));
$end_date=empty($srch['end_date']) ? '' : date('Y-m-d',strtotime($srch['end_date']));
?>
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->

	 <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
			   <h4>Students List <?php if(!empty($stu_list)){echo '- ' .$stu_list[0]->title;} ?></h4>
               <span class="align-right"> <?php if($stu_list[0]->publishstatus == 0){ ?>
               <button id="publish" value="<?=$stu_list[0]->link_id?>" class="text-right btn btn-success">Publish Panel</button>
               
               
               
               <?php }
               else{ ?>

                <button  class="text-right btn btn-danger">Already Published</button>

            <?php   }?><a class="text-right btn btn-primary" href = "<?=base_url()?>PgMswAided/panelPdf/<?=$this->uri->segment(3);?>"><i class="fa fa-file-text" aria-hidden="true"></i> Download Panel Report</a></span>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>UG</th>
                        <th>Entrance Marks</th>
                        <th>Total Marks</th>
                        <th>Date</th>
                        <th>Community</th>
                        <th>Status</th>
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(isset($stu_list)){
					$sno=1;
					foreach($stu_list as $stulist)
					{
                        
                        $ug = number_format((float)$stulist->ug_perc, 2, '.', '');


                        $ent =  number_format((float)$stulist->total_mark, 2, '.', '');

$total = $ug + $ent;
                   $totn =      number_format((float)$total, 2, '.', '');
				?>
                    <tr>
                        <td><?php echo $sno;?></td>
                        <td><?php echo $stulist->stu_name; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($stulist->stu_dob)); ?></td>
                        <td><?php echo $ug ; ?></td>
                        <td><?php echo $ent  ?></td>
                        <td><?php echo $totn; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($stulist->alc_date)); ?></td>
						<td><?php echo $stulist->stu_comm; ?></td>
						<td>
						<?php if($stulist->per_mark!='') {echo '<span style="color:green">Assigned</span>';}else{echo '<span style="color:red">Not Assigned</span>';} ?>
					    </td>
					
                        <td>
						<button data-id="<?php echo $stulist->id;?>" data-mark="<?php echo $stulist->per_mark;?>" class="btn-success addmark" data-toggle="modal" href="#ultraModal-2">Add Marks</button>
                        <?php if($stu_list[0]->publishstatus == 0){ ?>
                        <button class="btn-danger delete" data-id="<?php echo $stulist->id; ?>" data-stu="<?php echo $stulist->student_id; ?>">Delete</button>
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
	  
	  <!-- view modal start -->
                                    <div class="modal fade" id="ultraModal-2" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
                                        <div class="modal-dialog">
												<form class="form-inline" action="" method="post">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <h4 class="modal-title"> Student Marks </h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body divepopup">
                                                     <span>Marks</span><br>
                                                     <input type="text" class="form-control" id="per_mark" placeholder="Enter Marks" name="per_mark" value="" required>
						                             <input type="hidden" value="<?php echo $zoom_id;?>" name="zoom_id">
						                             <input type="hidden" id="linkid" value="" name="id">
                                                       
												       
                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                  
                                                  
                                                    <button class="btn btn-success" type="submit" name="submit">Add Marks</button>
                                                  
                                                </div>  
                                           
                                        </div>
                                                </form>
                                    </div>
									</div>
                                    <!--view modal end -->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
   <style>
    span { width:100%; display:inline-block; }
span.align-right { text-align:right; }

span a { font-size:16px; }
    
    </style>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
		var stu_id = $(this).attr("data-stu");
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
			url: "<?php echo base_url();?>pgMswAided/delete_stu_zoom",
			method: "POST",
			cache: false,
			data:{
				type: 2,
				id: id1,
				stu_id: stu_id
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
				location.reload();
				//dataTable.ajax.reload();
				//window.location.href="<?php echo base_url();?>pgMswAided/stu_zoom_list_det";
			}
		});
		}else{
			swal("Cancelled", "Your file is safe :)", "error");
		}
	});
	});
});
</script>
<script>
$(document).ready(function() {


    
$("#publish").click(function(){
var panel_id = $(this).val();
    var r = confirm("Are you sure to Publish this Interview Panel List? Once you publish, Notifications will be sent to the candidates.");


if (r == true) {
    $.ajax({
			url: "<?php echo base_url();?>PgMswAided/publishPanel",
			method: "POST",
			cache: false,
			data:{
				panel_id: panel_id,
			
			},
			success: function(dataResult){
				//alert(dataResult);
				swal("Published!", "Panel Published Successfully.", "success");
                location.reload();
				//var dataResult = JSON.parse(dataResult);
				//if(dataResult.statusCode==200){
					//$ele.fadeOut().remove();
				//}
				if(dataResult){
					$ele.fadeOut().remove();
				}
				location.reload();
				//dataTable.ajax.reload();
				//window.location.href="<?php echo base_url();?>pgSelfFinance/stu_zoom_list_det";
			}
		});
} else {
 return false;
}

});



	$(document).on("click", ".addmark", function() { 
	//alert("Success");
		var id1 = $(this).attr("data-id");
		var mark = $(this).attr("data-mark");
	$('#linkid').val(id1);
	$('#per_mark').val(mark);
	});
});
</script>