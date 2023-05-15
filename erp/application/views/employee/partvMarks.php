
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
		  <div class="card-header"><i class="fa fa-table"></i>Part V Mark Entry</div>
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
			  <?php if(isset($subject)){ 
				  foreach($subject as $subject){  ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
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
		  <button type="button" class="btn btn-sm btn-success" id="ica1_submit">Save Marks</button>
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Reg No.</th>
                        <th>Completion Status</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$subjectt = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();
							$get_sub1=$this->db->where('subCode',$subjectt->subCode)->where('stream',$student->main_id)->where('department',$student->cour_id)->where('batch_year',$batch1)->get('erp_subjectmaster')->row();
						$mark_det = $this->db->where('student_id',$student->id)->where('subject_id',$get_sub1->id)->get('erp_partvmark')->row();
						$checked1='';
						if(isset($mark_det)){
						if($mark_det->status==1){$checked1='checked';}
						}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->reg_no_?></td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="ica1" style="width:20px;height:20px;" <?=$checked1?>>
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
                url: base_url + "employee/getSubjecPartv",
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
		
		
	
		$('#ica1_submit').click(function(){
		var ica1=Array();	
		var ica1_not=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();		
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('input[class=ica1]:checked').each(function(){
            ica1.push($(this).data('student'));
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('input[class=ica1]:not(:checked)').each(function(){
            ica1_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/partvReport",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica1: ica1,main_id: main_id,course_id: course_id,ica1_not: ica1_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('Part V Marks Added Successfully!!');
		}
		});
		
	});
	</script>