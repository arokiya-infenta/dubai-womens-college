<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
	
<?php 
$subject1 = isset($subject1) ? $subject1 : '';
?>
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('mesg'))){

echo $this->session->flashdata('mesg');

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





          <form action="" method="post">
            <div class="row">
					 <!--<div class="col-lg-3">
			  <select class="form-control" id="role" name="role" required>
			  <option value="">Select Role</option>
			  <?php foreach($role as $rol) { ?>
			  <option value="<?=$rol->id?>" <?php if($role1==$rol->id){echo 'selected';}?>><?=$rol->role_name?></option>
			  <?php } ?>
			  </select>
			  </div>-->
			  <?php //if($employee!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="emp">
			  <select class="form-control single-select" id="employee" name="employee" required>
			  <option value="">Select Employee</option>
			  <?php if(isset($employee2)){if(sizeof($employee2)>0){foreach($employee2 as $employee2){ ?>
			  <option value="<?=$employee2->id?>" <?php if($employee==$employee2->id){echo 'selected';}?>><?=$employee2->emp_name_?></option>
			  <?php }}} ?>
			  </select>
			  </div>
			<div class="col-lg-3">
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>"><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>"><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-3" id="sub">
			  <select class="form-control multiple-select" id="subject" name="subject[]" required multiple="multiple">
			  </select>
			  </div>
			  </div>
			    <div class="row mt-3">
					 <div class="col-md-12">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="submit" class="btn btn-primary text-right" value="Submit" >
           
           </div>
           </div>
        
					</div>
					</form>

   



            </div>
          </div>
        </div>


        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
            <div class="col-lg-3">
			<i class="fa fa-file-text"></i>Staff List
			</div>
			</div>
			<hr>
			<form action="" method="post">
            <div class="row">
            <div class="col-lg-3">
			<label>Batch</label>
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch_b = $this->db->get('erp_batchmaster')->result();
			foreach($batch_b as $batch_b){?>
			<option value="<?=$batch_b->batch_from?>" <?php if($batch1==$batch_b->batch_from){echo 'selected';}?>><?=$batch_b->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Sem</label>
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem_b = array('1','2','3','4','5','6');
			  foreach($sem_b as $sem_b){ ?>
			  <option value="<?=$sem_b?>" <?php if($sem1==$sem_b){echo 'selected';}?>><?=$sem_b?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-md-6 mt-3">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="list_staff" class="btn btn-primary text-right" value="Submit" >
           
           </div>
           </div>
			</div>
			</form>
			</div>
            <div class="card-body">
<?php if(isset($emp_list)&&sizeof($emp_list)>0){ ?>
            <table id="allocate-datatable"  class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Emp ID</th>
      <th>Name</th>
      <th>Subject</th>
      <th>Action</th> 
    </tr>
  </thead>
  <tbody>
  <?php $sno=1;
  foreach($emp_list as $emplist){
	  $emp_subj = explode(',',$emplist->subjects);
	  $subj = '';
	  foreach($emp_subj as $emp_subj){
	$subje_nm=$this->db->where('id',$emp_subj)->get('erp_subjectmaster')->row();  
	    $subj .= $subje_nm->subName . ', ';
	  }
	  ?>
  <tr>
  <td><?=$sno++?></td>
  <td><?=$emplist->employee_id_?></td>
  <td><?=$emplist->emp_name_?></td>
  <td><?=substr($subj,0,-2)?></td>
  <td>
  <button type="button" class="btn btn-success btn-sm edit" data-target="#myModal" data-toggle="modal" data-stream="<?=$stream?>" data-dept="<?=$department?>" data-batch="<?=$batch1?>" data-sem="<?=$sem1?>" data-id="<?=$emplist->id?>"><i class="fa fa-pencil"></i></button>
  <!--<button type="button" class="btn btn-danger btn-sm delete" data-id="<?=$emplist->id?>"><i class="fa fa-trash"></i></button>-->
  </td>
  </tr>
  <?php } ?>
  </tbody>
</table>     
<?php } ?>

				
      </div>
      </div>
      </div>


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
		<form action="" method="post">
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-12">
			<label>Subject</label>
			<select class="form-control subject_edit multiple-select" multiple="multiple" name="subject_edit[]">
			</select>
			<input type="hidden" class="edit_id" name="edit_id">
			<input type="hidden" class="batch" name="batch">
			<input type="hidden" class="sem" name="sem">
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
	var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#allocate-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Allocate Subject ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Allocate Subject_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1,2,3],
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Allocate Subject_'+currentDate+'',
				exportOptions: {
					columns: [0, 1,2,3],
				},
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					doc.content[1].margin = [ 100, 0, 100, 0 ] //left, top, right, bottom
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'left',
                        image: getBase64Image(myGlyph)
                    } );
					doc.content.splice( 1, 1, {
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: '',
						margin: [0, 0, 0, 0],
                    } );
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });
                }
			}]
		});
var allPages = myTable.rows().nodes().to$();
	
		$('#batch,#sem').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "hod/getSubjectBatchAndSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    sem: sem,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			$('#sub').css('display','none');
		}
		});
		
		$('.batch,.sem').change(function(){
			$('.subject_edit').empty();
		  var batch = $('.batch').val();	
		  var sem = $('.sem').val();
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "hod/getSubjectBatchAndSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    sem: sem,
                    batch: batch
                },
                success: function (data) {
					$('.subject_edit').append(data);
                }
            });
        }else{
			$('.subject_edit').empty();
		}
		});
		
		$('.edit',allPages).click(function(){
			$('.subject_edit').empty();
			$('.edit_id').val('');
		  var stream = $(this).data('stream');
		  var dept = $(this).data('dept');	
		  var id = $(this).data('id');	
		  var batch = $(this).data('batch');	
		  var sem = $(this).data('sem');	
            $.ajax({
                url: base_url + "hod/updateSubject",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    dept: dept,
                    id: id,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('.subject_edit').append(data);
					$('.edit_id').val(id);
					$('.batch').val(batch);
					$('.sem').val(sem);
                }
            });
		});
	});
    
    
    </script>
    <script>
	$(document).ready(function() {
	$(document).on('click', '.delete', allPages, function(event){
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
			url: "<?php echo base_url();?>hod/delete_employee_subject",
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
				window.location.href="<?php echo base_url();?>hod/allocateSubject";
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
    