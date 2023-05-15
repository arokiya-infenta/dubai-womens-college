
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
		  <div class="card-header"><i class="fa fa-table"></i>Attendance Percentage Details</div>
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
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->where('sem',$sem1)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  <div class="col-lg-3">
			<label>From Date</label>   
			  <input type="date" class="form-control" name="from_date" value="<?=$from_date1?>" required>
			  </div>
			  <div class="col-lg-3">
			<label>To Date</label>   
			  <input type="date" class="form-control" name="to_date" value="<?=$to_date1?>" required>
			  </div>
				 <div class="col-lg-3 mt-4">
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
			
	  <?php if(isset($stu_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<form action="<?=base_url().'coe/consolidatedAttPDF'?>" method="POST">
				 <div align="left">
				 <button type="submit" class="btn btn-sm btn-success">Generate PDF</button>
				 <input type="hidden" name="batch" value="<?=$batch1?>">
				 <input type="hidden" name="sem" value="<?=$sem1?>">
				 <input type="hidden" name="stream" value="<?=$stream?>">
				 <input type="hidden" name="department" value="<?=$department?>">
				 <input type="hidden" name="subject" value="<?=$subject1?>">
				 <input type="hidden" name="from_date" value="<?=$from_date1?>">
				 <input type="hidden" name="to_date" value="<?=$to_date1?>">
		         </div>
		    </form>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="table1" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">S.No </th>
                        <th width="30%">Name</th>
                        <th width="10%">Register No.</th>
                        <th width="8%">Absent</th>
                        <th width="8%">Present</th>
                        <th width="8%">Total</th>
                        <th width="8%">Percentage</th>
                       
                       
                    </tr>
                </thead>
				</table>
				<table id="" class="table table-bordered">
                <tbody>


                    
					<tr>
					<td colspan="7" style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Eligible (Above 75%)</td>
					</tr>
					</table>
					<table id="" class="table table-bordered">
					<tbody>
                    <?php if(isset($stu_list)){
					$sno=1;
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						$present = 0;
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
						
							if($prec >=75){
					?>
                      <tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
                    <?php }} ?>
					</tbody>
					</table>
					<table id="" class="table table-bordered">
					<tbody>
					<tr>
					<td colspan=7 style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Condonation (Between 65% - 74%)</td>
					</tr>
					</tbody>
					</table>
					<table id="" class="table table-bordered">
					<tbody>
					<?php
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
					if($prec >= 65 && $prec < 75){ ?>
						<tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
					<?php }} ?>
					</tbody>
					</table>
					<table id="" class="table table-bordered">
					<tbody>
					<tr>
					<td colspan=7 style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Not Eligible (Between 50% - 64%)</td>
					</tr>
					</tbody>
					</table>
					<table id="" class="table table-bordered">
					<tbody>
					<?php
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
					if($prec >= 50 && $prec < 65){ ?>
					<tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
					<?php }} ?>
					</tbody>
					</table>
					<?php } ?>
                 
               
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
	});
	</script>