
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
		  <div class="card-header"><i class="fa fa-table"></i>Student Details</div>
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
			<input type="hidden" value="<?=$stream?>" id="stream">
			<input type="hidden" value="<?=$department?>" id="department">
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
				 <div class="col-lg-3" id="sub" >
			  <label>Subject</label>
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('employee_id',$user)->where('sem',$sem1)->where('batch',$batch1)->get('erp_employee_subject')->result();
				  foreach($subject as $subject){ 
			  $sub_name=$this->db->where('id',$subject->subject_id)->get('erp_subjectmaster')->row(); ?>
			  <option value="<?=$subject->subject_id?>" <?php if($subject1==$subject->subject_id){echo 'selected';}?>><?=$sub_name->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
				 <div class="col-lg-3 mt-4">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
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
		  <form action="<?=base_url().'employee/icaReportPDF'?>" method="post">
		  <button type="submit" class="btn btn-sm btn-success" id="pdf">Generate PDF</button>
		  <input type="hidden" name="batch" value="<?=$batch1?>">
		  <input type="hidden" name="sem" value="<?=$sem1?>">
		  <input type="hidden" name="subject" value="<?=$subject1?>">
		  </form>
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>ICA1</th>
                        <th>ICA2</th>
                        <th>Best of IA</th>
                        <th>In Class</th>
                        <th>Take Home</th>
                        <th>Total</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>          
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$subjectt = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();
							$get_sub1=$this->db->where('subCode',$subjectt->subCode)->where('stream',$student->main_id)->where('department',$student->cour_id)->where('batch_year',$batch1)->get('erp_subjectmaster')->row();
		                    $subjectt1=$get_sub1->id;
						$mark_det = $this->db->where('student_id',$student->id)->where('subject_id',$subjectt1)->get('erp_exammark')->row();
						if(isset($mark_det)){
						if($mark_det->ica1Mark!=''&&$mark_det->ica1Mark!=null){$mark1=$mark_det->ica1Mark;}else{$mark1='AA';}
						if($mark_det->ica2Mark!=''&&$mark_det->ica2Mark!=null){$mark2=$mark_det->ica2Mark;}else{$mark2='AA';}
						if($mark_det->inClassMark!=''&&$mark_det->inClassMark!=null){$mark3=$mark_det->inClassMark;}else{$mark3='AA';}
						if($mark_det->takeHomeMark!=''&&$mark_det->takeHomeMark!=null){$mark4=$mark_det->takeHomeMark;}else{$mark4='AA';}
						}
						else{
							$mark1='AA';$mark2='AA';$mark3='AA';$mark4='AA';
							}
							$best_ica = 'AA';
							$best_ica = (is_numeric($mark1) && is_numeric($mark2)) ? max($mark1, $mark2) : (is_numeric($mark1) ? $mark1 : $mark2);
						$total = 0;
                        if(is_numeric($best_ica)){ $total += $best_ica;}						
                        if(is_numeric($mark3)){ $total += $mark3;}						
                        if(is_numeric($mark4)){ $total += $mark4;}
						$result = 'R';
                        if($stream == 5){
                        if($total >= 20){$result= 'P';}	}else{
						if($total >= 25){$result= 'P';}	
						}				
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td><?=$mark1?></td>
						<td><?=$mark2?></td>
						<td><?=$best_ica?></td>
						<td><?=$mark3?></td>
						<td><?=$mark4?></td>
						<td><?=$total?></td>
						<td><?=$result?></td>
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
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();
		
		$('#batch,#sem').change(function(){
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "employee/getSubjec",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
	});
	</script>
