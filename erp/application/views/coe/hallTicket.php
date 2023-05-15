
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
		  <div class="card-header"><i class="fa fa-table"></i>Hall Ticket Details</div>
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
				 <!--<div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>-->
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
			  </div>
			  <div class="row">
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
			
	  <?php if(isset($stu_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Register No.</th>
						<?php /*$subj = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
                        foreach ($subj as $subj) {*/
					?>
						<!--<td style="width:100px;"><?=$subj->subName?></td>-->
					<?php //} ?>
                        <th>Download</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->reg_no_?></td>
						<?php /*$subject_all = $this->db->select('id')->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
						$subject = $this->db->query('select esm.* from erp_stu_attendance em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$student->id.' and l.batch='.$batch1.' and l.sem='.$sem1.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$student->id.' and e.e_batch='.$batch1.' and e.e_sem='.$sem1.' and e.e_subject=esm.id) where em.student_id='.$student->id.' and em.sem='.$sem1.' and em.batch_year='.$batch1.' and (((esm.part=1 OR esm.part=4 OR esm.part=2) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND esm.part!=2 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) group by em.subject_id order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
						$sub_tot = sizeof($subject);
						$perc_tot = 0;
						$stu_subj_na = array();
					foreach ($subject as $subject) {
						array_push($stu_subj_na,$subject->id); 
						$prec = '';
						$get = $this->db->where('student_id',$student->id)->where('subject_id',$subject->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->get('erp_stu_attendance')->result();
						$total = $this->db->where('student_id',$student->id)->where('subject_id',$subject->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->get('erp_stu_attendance')->num_rows();
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						if($prec > 75){$perc_tot += 1;}*/
					?>
						<!--<td style="width:100px;"><?=round($prec,1)?>%</td>
						<?php /*} foreach ($subject_all as $subjectall) { 
						if (in_array($subject_all->id, $stu_subj_na, FALSE)){*/
						?>
						<td style="width:100px;">Subject Not Allocated</td>	-->
						<?php //}} ?>
						<td>
						<?php $block_stu = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('status',1)->get('erp_block_halltickets')->result();
						if(sizeof($block_stu) == 0){
						$issue_date = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->get('erp_examwise_other_closing_dates')->row();
						if(isset($issue_date)){
						$issuedate = $issue_date->hallticket_issue;
						if(date('Y-m-d') >= $issuedate){ ?>
						<a href="<?=base_url().'coe/hallTicketPDF/'.$student->id.'/'.$sem1.'/'.$batch1?>">
						<img src="<?=base_url().'system/images/pdf_img.png'?>" style="width:40px;height:40px;"></a>
						<?php } else { ?> Issue Date is <?=$issuedate?> <?php }} else { ?> Issue Date has not been fixed yet
						<?php }} else { 
						$types = '';
						if(sizeof($block_stu) > 0){
							$types .= 'Blocked by ';	
							foreach($block_stu as $block_stu){
								$types .= $block_stu->type . ', ';
						}} ?>
						<span style="font-weight:bold;"><?=substr($types,0,-2)?></span>
						<?php } ?>
						</td>
                    </tr>
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
var myTable = $('#exammarks-datatable').DataTable({
				"lengthMenu": [[100, "All", 50, 25], [100, "All", 50, 25]]});
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
    $('#department').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $(this).val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "coe/getSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			alert('Select all the fields');
		}
		});	
	});
	</script>