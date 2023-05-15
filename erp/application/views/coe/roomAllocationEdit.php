<style>
.select2-results__options[aria-multiselectable="true"] li {
    padding-left: 30px;
    position: relative
}

.select2-results__options[aria-multiselectable="true"] li:before {
    position: absolute;
    left: 8px;
    opacity: .6;
    top: 6px;
    font-family: "FontAwesome";
    content: "\f0c8";
}

.select2-results__options[aria-multiselectable="true"] li[aria-selected="true"]:before {
    content: "\f14a";
}
</style>

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
	  
	   <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
		<div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
          <div class="card">
		  <div class="card-header"><i class="fa fa-table"></i>Exam Schedule</div>
            <div class="card-body">
			
			<form id="myForm" action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control rem" name="batch" id="batch" readonly>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" readonly>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
			<span style="color:red;"><?=form_error('stream')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" readonly>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
			<span style="color:red;"><?php echo form_error('department')?></span>
		         </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" readonly>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			<span style="color:red;"><?php echo form_error('subject')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control rem" id="sem" name="sem" readonly>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('sem')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Schedule Date</label>   
			  <input type="date" class="form-control" id="schedule_date" name="schedule_date" value="<?=$schedule_date1?>">
			<span style="color:red;"><?php echo form_error('schedule_date')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Section</label>   
			  <select class="form-control rem" id="section" name="section" readonly>
			  <option value="">Select Section</option>
			  <?php $section = array('Forenoon','Afternoon');
			  foreach($section as $section){ ?>
			  <option value="<?=$section?>" <?php if($section1==$section){echo 'selected';}?>><?=$section?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('section')?></span>
			  </div>
				 <div class="col-lg-3">
			<label>Block</label>   
			<select class="form-control" name="block_id" id="block" readonly>
			<option value="">Select Block</option>
			<?php $block = $this->db->get('erp_blocks')->result();
			foreach($block as $block){?>
			<option value="<?=$block->id?>" <?php if($block1==$block->id){echo 'selected';}?>><?=$block->block_name?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('block_id')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Room</label>   
			<select class="form-control rem" name="room_id" id="room" readonly>
			<option value="">Select Room</option>
			<?php if(isset($room1)){ $room = $this->db->where('block_id',$block1)->get('erp_rooms')->result();
			foreach($room as $room){?>
			<option value="<?=$room->id?>" <?php if($room1==$room->id){echo 'selected';}?>><?=$room->room_name?></option>
			<?php }} ?>
			</select>
			<span style="color:red;"><?php echo form_error('room_id')?></span>
		         </div>
				 <?php 
		$tot_stu = $this->db->select('sum(no_of_students) as total_students')->where('main_id',$stream)->where('course_id',$department)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('sem',$sem1)->where('room_id',$room1)->where('section',$section1)->from('erp_room_allocation')->get()->row(); ?>
			  <div class="col-lg-3">
			<label>No. Of Students</label>   
			  <input type="number" class="form-control" id="no_of_students" name="no_of_students" value="<?=$tot_stu->total_students?>">
			  <input type="hidden" class="form-control" id="no_of_students1" name="no_of_students1" value="<?=$tot_stu->total_students?>" readonly>
			<span style="color:red;"><?=form_error('no_of_students')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Remaining Spaces</label>   
			  <input type="number" class="form-control" id="remaining_spaces" name="remaining_spaces" value="<?=$remaining_spaces?>" readonly>
			<span style="color:red;"><?=form_error('remaining_spaces')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Remaining Students For the Subject</label>   
			  <input type="number" class="form-control" id="remaining_students" name="remaining_students" value="<?=$remaining_students?>" readonly>
			  </div>
			  	  <?php $row_det = $this->db->where('id',$room1)->get('erp_rooms')->row(); ?>
			  <div class="col-lg-3">
			<label>Seater</label>   
			  <input type="text" class="form-control" name="seater" id="seater" value="<?=$row_det->seater?>" readonly required>
			  <input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?=$edit_id?>" readonly required>
			  <input type="hidden" class="form-control" name="val[]" value="">
			  </div>
			  <?php $year=date('Y');
			  $arrear_stu = $this->db->where('applied_year',$year)->where('sem',$sem1)->where('room_id',$room1)->where('section',$section1)->get('erp_rows_cols_arrear')->num_rows();
			  ?>
			  <div class="col-lg-3">
			<label>Arrear Students</label>   
			  <input type="number" class="form-control" id="remaining_spaces" name="remaining_spaces" value="<?=$arrear_stu?>" readonly>
			  </div>
			  </div>
			  <div class="row" id="attach">
		<?php
    $rows_no = $row_det->rows;	
    $cols_no = $row_det->columns;	
	
	for($i=0; $i < $rows_no; $i++){ ?>
	          <div class="col-lg-12 rows">
		      <label>Row <?=$i+1?> </label>
		      <input type="hidden" name="rows[]" value="<?=$i+1?>">   
		      <select class="form-control row_col multiple-select" name="cols_<?=$i?>[]" multiple="multiple">
		<?php 
		$row_col = $this->db->where('main_id',$stream)->where('course_id',$department)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('sem',$sem1)->where('section',$section1)->where('block_id',$block1)->where('room_id',$room1)->where('rows',($i+1))->get('erp_rows_cols')->row();
		
		for($ii=0; $ii < $cols_no; $ii++){ 
		?>
		<option value="<?=$ii + 1?>" <?php if(isset($row_col)){
		$cols = $row_col->columns;
		if(!empty($cols)){
		$cols1 = explode(',',$cols);
		foreach($cols1 as $cols1){
		if(($ii +1 ) == $cols1){echo 'selected';}}}}?>> <?=$ii + 1?> </option>
		<?php } ?>
		</select>
		</div>
	<?php } ?>
			  </div>
			     <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
				 <a href="<?=base_url().'coe/roomAllocationView/'.$room1.'/'.$section1.'/'.$batch1.'/'.$sem1.''?>">
			<button type="button" class="btn btn-sm btn-secondary">Back</button></a>
			<button type="submit" class="btn btn-sm btn-success add" name="submit">Submit</button>
		         </div>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
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
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();	
	
		
		

       $('.add').click(function(e){
		   //e.preventDefault();
		  var remaining_spaces = $('#remaining_spaces').val();	
		  var no_of_students = $('#no_of_students').val();
		  var no_of_students1 = $('#no_of_students1').val();
          if(remaining_spaces > 0){	
           var rem_space = parseInt(no_of_students) - parseInt(remaining_spaces);	  
           var rem_space1 = parseInt(no_of_students1) + parseInt(remaining_spaces);	
			if (parseInt(rem_space) > parseInt(rem_space1)) {
			e.preventDefault();
			alert('Only '+rem_space1+' Remaining Spaces!!');
        }
		else{	   
            $('#myForm').submit();
		}
		  }else{
			  e.preventDefault();
			  alert('There is no Remaining Space in this Room!!');
		  }
		});	
		
		
	});
	</script>