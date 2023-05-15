<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
	
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');
$this->session->set_flashdata("message","");
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





          <form action="<?=base_url().'pgSelfFinance/ICATimetable'?>" method="post">
                   <div class="row mt-3">
				   <div class="col-lg-2">
          <label>ICA</label>
		  <select class="form-control" name="ica" id="ica">
		  <option value="">Select ICA</option>
		  <?php $ica = array('1'=>'ICA 1','2'=>'ICA 2');foreach($ica as $ica=>$value){
			  ?>
			  <option value="<?=$ica?>" <?php if($ica1==$ica){echo 'selected';}?>><?=$value?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('ica');?></span>
			  </div>
			 <div class="col-lg-2">
          <label>Batch</label>
		  <select class="form-control" name="batch" id="batch">
		  <option value="">Select Batch</option>
		  <?php $batch = $this->db->get('erp_batchmaster')->result();foreach($batch as $batch){?>
			  <option value="<?=$batch->id?>" <?php if($batch1==$batch->id){echo 'selected';}?>><?=$batch->batch_from?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('batch');?></span>
			  </div> 
			<div class="col-lg-2">
          <label>Semester</label>
		  <select class="form-control" name="sem" id="sem">
		  <option value="">Select Sem</option>
		  <?php $semst = array('1','2','3','4','5','6');foreach($semst as $semst){?>
			  <option value="<?=$semst?>" <?php if($sem1==$semst){echo 'selected';}?>><?=$semst?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem');?></span>
		  <input type="hidden" value="<?=$main_id?>" id="stream" name="stream">
		  <input type="hidden" value="<?=$course_id?>" id="department" name="department">
			  </div>
			  <?php //if($subject1!=''){$style1='style="display:block"';}else{$style1='style="display:none"';}; ?>
			  <div class="col-lg-3" id="sub" >
			  <label>Subject</label>
			  <select class="form-control" id="subject" name="subject">
			  <option value="">Select Subject</option>
			  <?php if($subject1!=''){
				  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  <span style="color:red;"><?php echo form_error('subject');?></span>
			  </div>
			  <div class="col-lg-3" id="date">
			  <label>Date</label>
			  <input type="date" class="form-control" name="date" value="<?=$date1?>">
			  <span style="color:red;"><?php echo form_error('date');?></span>
			  </div>
					 <div class="col-md-2 mt-3">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="submit" class="btn btn-sm btn-primary text-right" value="Submit" >
           
           </div>
           </div>
			  </div>
					</form>

   



            </div>
          </div>
        </div>


<?php if(isset($timetable)){ ?>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> ICA Time Table </div>
            <div class="card-body">
            <table id="icatimetable-datatable"  class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>S.No</th>
      <th>ICA</th>
      <th>Subject</th>
      <th>Date</th>
      <th>Action</th> 
    </tr>
  </thead>
  <tbody>
  <?php $sno=1;
  foreach($timetable as $timetable){
	$subje_nm=$this->db->where('id',$timetable->subject_id)->get('erp_subjectmaster')->row();  
	  ?>
  <tr>
  <td><?=$sno++?></td>
  <td>ICA <?=$timetable->ICA?></td>
  <td><?=$subje_nm->subName?></td>
  <td class="date_<?=$timetable->id?>"><?=date('d-m-Y',strtotime($timetable->date))?></td>
  <td>
  <button type="button" class="btn btn-success btn-sm edit" data-target="#myModal" data-toggle="modal" data-id="<?=$timetable->id?>"><i class="fa fa-pencil"></i></button>
  <button type="button" class="btn btn-danger btn-sm delete" data-id="<?=$timetable->id?>"><i class="fa fa-trash"></i></button>
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
          <h4 class="modal-title">Edit Timetable</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<!--<form action="<?php echo base_url().'pgSelfFinance/allocateSubjectEdit'?>" method="post">-->
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-12">
			<label>Date</label>
			<input type="date" class="form-control" id="edit_date">
			<input type="hidden" id="edit_id">
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success update">Update</button>
          <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
        </div>
      </div>
	  <!--</form>-->
      
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
var myTable = $('#icatimetable-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();

        $('#batch').change(function(){
			$('#sem').val('');
		});			
		
		$('#sem').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var dept = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $(this).val();	
			if (sem!='' && batch!='') {
            $.ajax({
                url: base_url + "PgSelfFinance/getSubjectSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    batch: batch,
                    dept: dept,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			$('#sub').css('display','none');
		}
		});
		
		$('.edit',allPages).click(function(){
			$('#edit_id').empty();
			$('#edit_date').empty();
		  var id = $(this).data('id');
            $.ajax({
                url: base_url + "PgSelfFinance/getICATimetable",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                },
                success: function (data) {
					var data1 = JSON.parse(data);
					var edit_id = data1.id;
					var edit_date = data1.date;
					$('#edit_id').val(edit_id);
					$('#edit_date').val(edit_date);
                }
            });
		});
		
		$('.update').click(function(){
		  var id = $('#edit_id').val();	
		  var date = $('#edit_date').val();	
		  if(confirm('Are you sure to update?')){
            $.ajax({
                url: base_url + "PgSelfFinance/updateICATimetable",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                    date: date,
                },
                success: function (data) {
					alert('Updated Successfully');
                    var dateAr = date.split('-');
                    var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
					$('#myModal .close').click();
					$('.date_'+id+'').text(newDate);
                }
            });
		  }
		});
		
	$(document).on('click', '.delete', allPages, function(event){
	var id1 = $(this).attr("data-id");
	var $ele = $(this).parent().parent();
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
			url: "<?php echo base_url();?>PgSelfFinance/delete_ica_timetable",
			method: "POST",
			cache: false,
			data:{
				type: 2,
				id: id1
			},
			success: function(dataResult){
				$ele.fadeOut().remove();
				swal("Deleted!", "Your file has been deleted.", "success");
				
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
    