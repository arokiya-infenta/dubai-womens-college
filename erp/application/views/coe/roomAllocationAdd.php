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
			<select class="form-control rem" name="batch" id="batch">
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
			<select class="form-control" name="stream" id="stream">
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
			<select class="form-control" name="department" id="department">
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
			<span style="color:red;"><?php echo form_error('department')?></span>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control rem" id="sem" name="sem">
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('sem')?></span>
			  </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject">
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			<span style="color:red;"><?php echo form_error('subject')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Schedule Date</label>   
			  <input type="date" class="form-control rem" id="schedule_date" name="schedule_date" value="<?=$schedule_date1?>">
			<span style="color:red;"><?php echo form_error('schedule_date')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Section</label>   
			  <select class="form-control rem" id="section" name="section">
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
			<select class="form-control" name="block_id" id="block">
			<option value="">Select Block</option>
			<?php $block = $this->db->get('erp_blocks')->result();
			foreach($block as $block){?>
			<option value="<?=$block->id?>" <?php if($block1==$block->block_name){echo 'selected';}?>><?=$block->block_name?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('block_id')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Room</label>   
			<select class="form-control rem" name="room_id" id="room">
			<option value="">Select Room</option>
			<?php if(isset($room_id1)){ $room = $this->db->where('block_id',$block1)->get('erp_rooms')->result();
			foreach($room as $room){?>
			<option value="<?=$room->id?>" <?php if($room1==$room->room_name){echo 'selected';}?>><?=$room->room_name?></option>
			<?php }} ?>
			</select>
			<span style="color:red;"><?php echo form_error('room_id')?></span>
		         </div>
			  <div class="col-lg-3">
			<label>No. Of Students</label>   
			  <input type="number" class="form-control" id="no_of_students" name="no_of_students">
			<span style="color:red;"><?=form_error('no_of_students')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Remaining Spaces</label>   
			  <input type="number" class="form-control" id="remaining_spaces" name="remaining_spaces" style="color:red;" readonly>
			<span style="color:red;"><?=form_error('remaining_spaces')?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Remaining Students For the Subject</label>   
			  <input type="number" class="form-control" id="remaining_students" name="remaining_students" style="color:red;" readonly>
			  </div>
			  <div class="col-lg-3">
			<label>Seater</label>   
			  <input type="text" class="form-control" name="seater" id="seater" readonly required>
			  </div>
			  <div class="col-lg-3">
			<label>Exam Type</label>   
			<select class="form-control" name="exam_type" id="exam_type">
			<option value="0" <?php if($exam_type1==0){echo 'selected';}?>>Regular</option>
			<option value="1" <?php if($exam_type1==1){echo 'selected';}?>>Arrear</option>
			</select>
		         </div>
			  </div>
			  <div class="row" id="note" style="display:none;">
			  <div class="col-lg-12 note">
			  </div>
			  </div>
			  <div class="row" id="attach">
			  </div>
			     <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
				 <a href="<?=base_url().'coe/roomAllocation'?>">
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
	$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#department').append(data);
                }
            });
        }else{
			$('#dept').css('display','none');
		}
		});
    $('#department,#stream,#sem,#batch').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (stream!='' && department!='' && batch!='' && sem!='') {
            $.ajax({
                url: base_url + "coe/getSubjSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
		
		$('#block').change(function(){
			$('#room').empty();
			$('#remaining_spaces').val('');
		  var block_id = $(this).val();	
			if (block_id!='') {
            $.ajax({
                url: base_url + "coe/getRooms",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                },
                success: function (data) {
					$('#room').append(data);
                }
            });
        }else{
			alert('Select Block');
		}
		});

       $('.rem').change(function(){
			$('#remaining_spaces').val('');
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = $('#batch').val();	
		  var sem = $('#sem').val();	
		  var section = $('#section').val();	
		  var schedule_date = $('#schedule_date').val();	
			if (room_id!='' && batch_id!='' && sem!='' && section!='' && schedule_date!='') {
            $.ajax({
                url: base_url + "coe/getRemainingSpaces",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                    room_id: room_id,
                    batch_id: batch_id,
                    sem: sem,
                    section: section,
                    schedule_date: schedule_date,
                },
                success: function (data) {
					$('#remaining_spaces').val(data);
                }
            });
        }
		});

       $('#department,#stream,#sem,#batch,#subject').change(function(){
			$('#remaining_students').val('');
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = $('#batch').val();	
		  var sem = $('#sem').val();	
		  var section = $('#section').val();	
		  var schedule_date = $('#schedule_date').val();	
		  var subject = $('#subject').val();
		  var stream = $('#stream').val();
		  var department = $('#department').val();
			if (batch_id!='' && sem!='' && subject!='' && subject!=null) {
            $.ajax({
                url: base_url + "coe/getRemainingStudentsSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch_id: batch_id,
                    sem: sem,
                    subject: subject,
                    stream: stream,
                    department: department,
                },
                success: function (data) {
					$('#remaining_students').val(data);
                }
            });
        }
		});
	
		
		
		$('#room').change(function(){
           $('div.rows').remove();	
           $('#note').css('display','none');
           $('.note').empty();		   
		  var room_id = $(this).val();	
			if (room_id!='') {
            $.ajax({
                url: base_url + "coe/getRows",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    room_id: room_id,
                },
                success: function (data) {
					var dataRead = JSON.parse(data);
					var rows = dataRead.rows;
					var seater = dataRead.seater;
					$('#attach').append(rows);
					$('#seater').val(seater);
					$('select.row_col').select2({
					closeOnSelect: false,
                    tags: true,
                    });
                }
            });
        }
		});
		
		$('#room,#schedule_date,#section').change(function(){
           $('#note').css('display','none');
           $('.note').empty();		   
		  var room_id = $('#room').val();	
		  var schedule_date = $('#schedule_date').val();	
		  var session = $('#section').val();
			if (room_id!='' && schedule_date!='' && session!='') {
            $.ajax({
                url: base_url + "coe/getAllotedSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    room_id: room_id,
                    schedule_date: schedule_date,
                    session: session,
                },
                success: function (data) {
					$('.note').append(data); 
                    $('#note').css('display','block');
                }
            });
        }
		});
		
		

       $('.add').click(function(e){
		   //e.preventDefault();
		  var remaining_spaces = $('#remaining_spaces').val();	
		  var no_of_students = $('#no_of_students').val();
          if(remaining_spaces > 0){		  
			if (parseInt(no_of_students) > parseInt(remaining_spaces)) {
			e.preventDefault();
			alert('Please Select No. of Students less than or equal to Remaining Spaces!!');
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