
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
		  <div class="card-header"><i class="fa fa-table"></i>Attendance Sheet</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-3">
			<label>Schedule Date</label>   
			  <input type="date" class="form-control" id="schedule_date" name="schedule_date" value="<?=$schedule_date1?>">
			<span style="color:red;"><?php echo form_error('schedule_date')?></span>
			  </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
				 <div class="col-lg-9 mt-4">
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
			
	  <?php if(isset($room_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:left;">
				 <?php if(isset($exam_sched)){ ?>
				 <!--<a href="<?=base_url().'coe/attendanceSheetPDF/'.$batch1.'/'.$sem1.'/'.$subject1?>">-->
			<button type="button" class="btn btn-sm btn-primary" name="download" id="download">Download Sheet</button>
			<!--</a>-->
				 <?php } else { ?>
				 <h5 style="font-weight:bold;">Exam has not been scheduled yet</h5>
				 <?php } ?>
		         </div>
		         </div>
			  </div>
				 <div align="middle">
				 <?php if($subject1){$subj = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();}?>
			<h5 style="font-weight:bold;text-transform:uppercase">SUBJECT: <?=$subj->subName?></h5>
		         </div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Block</th>
                        <th>Room</th>
                        <th>No. of Students</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($room_list)){
					$sno=1;
					foreach ($room_list as $rooms) {
						$block = $this->db->where('id',$rooms->block_id)->get('erp_blocks')->row();
						$room = $this->db->where('id',$rooms->room_id)->get('erp_rooms')->row();
					?>
                      <tr class="downld" data-sno="<?=$sno?>" data-room_id="<?=$rooms->id?>">
                        <td><?=$sno;?></td>
                        <td><?=$block->block_name?></td>
						<td><?=$room->room_name?></td>
						<td><?=$rooms->no_of_students?></td>
						<td><a href="<?=base_url().'coe/attendanceSheetView/'.$rooms->id.'/'.$subject1?>">
						<button class="btn btn-sm btn-primary">View</button></a>
						</td>
                    </tr>
                    <?php $sno++;}} ?>
                 
               
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
		
		$('#download').click(function(e){
		  $('.downld').each(function(){	
			  var ele = $(this);
			  var sno = $(this).data('sno');
		      var room_id = $(this).data('room_id');	
			  $.ajax({
                url: base_url + "coe/attendanceSheetPDF",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                },
                success: function (data) {
			  var url = '<?php echo base_url()."coe/attendanceSheetPDF/"?>'+room_id+'';
		      ele.find('td:eq(4)').append('<a class="dwnld" href="'+url+'" download><button class="btn btn-sm btn-success dwnl">download</button></a>');
                }
            });
		  });
		  setTimeout(function(){
			  $('.dwnl').each(function(){
				  //alert();
				  $(this).click();
				  $(this).remove();
				  });
		  }, 2000);
		});
		
	});
	</script>