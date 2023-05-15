
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
		  <div class="card-header"><i class="fa fa-table"></i>Condonation Paid Status</div>
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
				 <div class="col-lg-12 mt-4">
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
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Register No.</th>
                        <th>Subjects</th>
                        <th>Fees</th>
                        <th>Chellan ID</th>
                        <th>Paid Date</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($stu_list)){
					$sno=1;
					foreach ($stu_list as $student) {
						
						$get_stu=$this->db->where('batch',$batch1)->where('add_student_id',$student->id)->where('semester',$sem1)->get('condanation_fee_transaction')->row();
						$gsub = array();
						$fee_val = '';
						$ch_val = '';
						$dt_val = '';
						if(isset($get_stu)){
						   $gsub = explode(',',$get_stu->subject_id);
						   $fee_val = $get_stu->amount_total;
						   $ch_val = $get_stu->transaction_id;
						   $dt_val = date('Y-m-d',strtotime($get_stu->paid_date));
						}
						
						$sublist = '';
						$subj = $this->db->query('select esm.* from erp_subjectmaster esm join erp_existing_students es on es.id='.$student->id.' left join erp_stu_attendance em on (em.subject_id=esm.id and em.student_id='.$student->id.') left join erp_langallot l on (l.existing_student_id='.$student->id.' and l.batch='.$batch1.' and l.sem='.$sem1.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$student->id.' and e.e_batch='.$batch1.' and e.e_sem='.$sem1.' and e.e_subject=esm.id) where esm.sem='.$sem1.' and esm.batch_year='.$batch1.' and esm.stream='.$student->main_id.' and esm.department='.$student->cour_id.' and esm.subNature!="PRACTICAL" and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) group by esm.id order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
						/*foreach ($subj as $subje) {
						$checked = '';
						$prec = '';
						$get = $this->db->where('student_id',$student->id)->where('subject_id',$subje->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->get('erp_stu_attendance')->result();
						$total = $this->db->where('student_id',$student->id)->where('subject_id',$subje->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->get('erp_stu_attendance')->num_rows();
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subje->id)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						
							if($prec >= 65 && $prec < 75){
								if(in_array($subje->id,$gsub)){
									$checked = 'checked';
								}
								$sublist .= '<input type="checkbox" class="subl '.$student->id.'" data-subject="'.$subje->id.'" data-student="'.$student->id.'" data-code="'.$subje->subCode.'" style="height:20px;width:20px;" '.$checked.'> ' . $subje->subName . ', ';
					     }}*/
						 foreach ($subj as $subje) {
						$checked = '';
								if(in_array($subje->id,$gsub)){
									$checked = 'checked';
								}
								$sublist .= '<input type="checkbox" class="subl '.$student->id.'" data-subject="'.$subje->id.'" data-student="'.$student->id.'" data-code="'.$subje->subCode.'" style="height:20px;width:20px;" '.$checked.'> ' . $subje->subName . ', ';
					     }
						 if($sublist != ''){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
						<td><?=$student->reg_no_?></td>
						<td><?=rtrim($sublist, ", ")?></td>
						<td><input class="form-control" type="text" id="amt_<?=$student->id?>" readonly value="<?=$fee_val?>"></td>
						<td><input class="form-control" type="text" id="chln_<?=$student->id?>"  value="<?=$ch_val?>"></td>
						<td><input class="form-control" type="date" id="date_<?=$student->id?>"  value="<?=$dt_val?>"></td>
						<?php if(isset($get_stu) AND $get_stu->payment_mode==0) { ?>
						<td>Paid Online</td>
						<?php } else { ?>
						<td><button class="btn-success subls" type="text" data-student="<?=$student->id?>">Paid</button>
						<?php if(isset($get_stu) AND $get_stu->payment_mode==1) { ?>
						<button class="btn-danger delete" type="text" data-id="<?=$get_stu->id?>">Delete</button>
						<?php } ?>
						</td>
						<?php } ?>
                    </tr>
						 <?php }}} ?>
                 
               
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
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
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
		
		$('.subl',allPages).click(function(){
		  var fees1 = '<?=$fees?>';
		  var student = $(this).data('student');
		  var fees_cnt = 0;
		  $("#amt_"+student+"").val('');
		  $("."+student+":checked", allPages).each(function(){
           fees_cnt = fees_cnt + 1;
          });
		  var fees = fees_cnt * fees1;
		  $("#amt_"+student+"").val(fees);
		});	
		
		$('.subls',allPages).click(function(){
		  var stream = '<?=$stream?>';	
		  var department = '<?=$department?>';	
		  var batch = '<?=$batch1?>';	
		  var sem = '<?=$sem1?>';	
		  var student = $(this).data('student');
		  var fees = $("#amt_"+student+"").val();
		  var chellan = $("#chln_"+student+"").val();
		  var paid_date = $("#date_"+student+"").val();
		  var subject = Array();
		  var subcode = Array();
		  $("."+student+":checked", allPages).each(function(){
           subject.push($(this).data('subject'));
           subcode.push($(this).data('code'));
          });
			if(confirm('Are you sure to mark the student as paid?')){
			if($.isEmptyObject(subject)) {
				alert('Please select subjects!!');exit;
			}else{
				if(chellan!=''){
            $.ajax({
                url: base_url + "coe/markCondPaid",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                    student: student,
                    subject: subject,
                    fees: fees,
                    chellan: chellan,
                    subcode: subcode,
                    paid_date: paid_date,
                },
                success: function (data) {
					if(data==0){
					alert('Student has already paid for the batch Online!!');
					}else{
					alert('Student fee details updated successfully!!');
					}
					location.reload();
                }
            });
				}else{
					alert('Please give Chellan ID!!');
				}
		}
			}
		});	
		
		$('.delete',allPages).click(function(){
		  var id = $(this).data('id');
			if(confirm('Are you sure to delete the details?')){
            $.ajax({
                url: base_url + "coe/deleteCondPaid",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                },
                success: function (data) {
					
					alert('Student fee details deleted successfully!!');
					
					location.reload();
                }
            });
			}
		});	
	});
	</script>