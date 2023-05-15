<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
	
<?php $role1 = isset($role1) ? $role1 : '';
$subject1 = isset($subject1) ? $subject1 : '';
$department1 = isset($department1) ? $department1 : '';
$stream = isset($stream) ? $stream : '';
?>
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

      <div class="row">



   
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Allocate Subject </div>
            <div class="card-body">





          <form action="<?=base_url().'employee/allocateSubject'?>" method="post">
            <div class="row">
					 <!--<div class="col-lg-3">
			  <select class="form-control" id="role" name="role" required>
			  <option value="">Select Role</option>
			  <?php foreach($role as $rol) { ?>
			  <option value="<?=$rol->id?>" <?php if($role1==$rol->id){echo 'selected';}?>><?=$rol->role_name?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <?php if($employee!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="emp" <?=$style?>>
			  <select class="form-control" id="employee" name="employee" required>
			  <option value="">Select Employee</option>
			  <?php if((sizeof($employee1)>0)&&isset($employee1)){foreach($employee1 as $employee1){ ?>
			  <option value="<?=$employee1->id?>" <?php if($employee==$employee1->id){echo 'selected';}?>><?=$employee1->name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  </div>
                   <div class="row mt-3">
			<div class="col-lg-3">
			  <select class="form-control" id="stream" name="stream" required>
			  <option value="">Select Stream</option>
			  <option value="1" <?php if($stream==1){echo 'selected';}?>>Aided</option>
			  <option value="2" <?php if($stream==2){echo 'selected';}?>>Self Finance</option>
			  </select>
			  </div>
			  <?php if($department1!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="dept" <?=$style?>>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			  <?php if((sizeof($department1)>0)&&isset($department1)){foreach($department as $department){ ?>
			  <option value="<?=$department->id?>" <?php if($department1==$department->id){echo 'selected';}?>><?=$department->dept_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  <?php if($subject1!=''){$style1='style="display:block"';}else{$style1='style="display:none"';}; ?>
			  <div class="col-lg-3" id="sub" <?=$style1?>>
			  <select class="form-control multiple-select" id="subject" name="subject[]" required multiple="multiple">
			  <option value="">Select Subject</option>
			  <?php if((sizeof($subject1)>0)&&isset($subject1)){foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->sub_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>-->
			  <div class="col-lg-3" id="empl">
			  <select class="form-control" id="employee" name="employee" required>
			  <option value="">Select Employee</option>
			  <?php if(sizeof($teacher)>0){foreach($teacher as $teacher){ ?>
			  <option value="<?=$teacher->id?>" <?php if($teacher==$employee){echo 'selected';}?>><?=$teacher->emp_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  <?php  ?>
			  <div class="col-lg-3" id="sub1">
			  <select class="form-control multiple-select" id="subject" name="subject[]" required multiple="multiple">
			  <option value="">Select Subject</option>
			  <?php if(sizeof($subject3)>0){foreach($subject3 as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->sub_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
					 <div class="col-md-3">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="submit" class="btn btn-primary text-right" value="Submit" >
           
           </div>
           </div>
        
					</div>
					</form>

   



            </div>
          </div>
        </div>


<?php if(isset($emp_list)&&sizeof($emp_list)>0){ ?>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Staff List </div>
            <div class="card-body">
            <table id="example"  class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Emp ID</th>
      <th>Name</th>
      <th>Subject</th>
      <th>Stream</th> 
      <th>Department</th> 
      <th>Action</th> 
    </tr>
  </thead>
  <tbody>
  <?php $sno=1;
  foreach($emp_list as $emplist){
	$subje_nm=$this->db->where('id',$emplist->subject_)->get('erp_subject')->row();  
	$dept_nm=$this->db->where('id',$subje_nm->dept_)->get('erp_department')->row();
    if($subje_nm->shift_==1){$strm_nm='Aided';}else{$strm_nm='Self Finance';}	
	  ?>
  <tr>
  <td><?=$sno++?></td>
  <td><?=$emplist->employee_id_?></td>
  <td><?=$emplist->emp_name_?></td>
  <td><?=$subje_nm->sub_name_?></td>
  <td><?=$strm_nm?></td>
  <td><?=$dept_nm->dept_name_?></td>
  <td>
  <button type="button" class="btn btn-success btn-sm edit" data-target="#myModal" data-toggle="modal" data-stream="<?=$subje_nm->shift_?>" data-dept="<?=$emplist->emp_dept_name_?>" data-id="<?=$emplist->id?>"><i class="fa fa-pencil"></i></button>
  <button type="button" class="btn btn-danger btn-sm delete" data-id="<?=$emplist->id?>"><i class="fa fa-trash"></i></button>
  </td>
  </tr>
  <?php } ?>
  </tbody>
</table>     

				
      </div>
      </div>
      </div>
<?php } ?>


      </div>
	
<!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Subject</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form action="<?php echo base_url().'employee/allocateSubjectEdit'?>" method="post">
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-12">
			<label>Subject</label>
			<select class="form-control subject_edit multiple-select" multiple="multiple" name="subject_edit[]">
			</select>
			<input type="hidden" class="edit_id" name="edit_id">
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
	  </form>
      
    </div>
  </div>
  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .anc {
  position: relative;
  float: right;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		
		$('.edit').click(function(){
			$('.subject_edit').empty();
			$('.edit_id').val('');
		  var stream = $(this).data('stream');
		  var dept = $(this).data('dept');	
		  var id = $(this).data('id');	
            $.ajax({
                url: base_url + "employee/updateSubject",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    dept: dept,
                    id: id,
                },
                success: function (data) {
					$('.subject_edit').append(data);
					$('.edit_id').val(id);
                }
            });
		});
	});
    
    
    </script>
    <script>
	$(document).ready(function() {
	$(document).on('click', '.delete', function(event){
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
			url: "<?php echo base_url();?>employee/delete_employee_subject",
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
				window.location.href="<?php echo base_url();?>employee/allocateSubject";
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
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
    </script>
    