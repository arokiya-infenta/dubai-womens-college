
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
		  <div class="card-header"><i class="fa fa-table"></i>Arrear Fees Paid Status</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Applied Year</label>   
			<select class="form-control" name="applied_year" id="applied_year" required>
			<option value="">Select Batch</option>
			<?php $applied_year = $this->db->get('erp_batchmaster')->result();
			foreach($applied_year as $applied_year){?>
			<option value="<?=$applied_year->batch_from?>" <?php if($applied_year1==$applied_year->batch_from){echo 'selected';}?>><?=$applied_year->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Applied Semester</label>   
			  <select class="form-control" id="applied_sem" name="applied_sem" required>
			  <option value="">Select Semester</option>
			  <?php $applied_sem = array('1','2','3','4','5','6');
			  foreach($applied_sem as $applied_sem){ ?>
			  <option value="<?=$applied_sem?>" <?php if($applied_sem1==$applied_sem){echo 'selected';}?>><?=$applied_sem?></option>
			  <?php } ?>
			  </select>
			  </div>
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
                        <th>No. of subjects</th>
                        <!--<th>Fees</th>-->
                        <th>Chellan ID</th>
                        <th>Paid Date</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($stu_list)){
					$sno=1;
					foreach ($stu_list as $student) {
						$stu_ad = $this->db->where('as_student_id',$student->student_id)->get('admitted_student')->row();
						$get_stu=$this->db->where('ef_batch',$batch1)->where('ef_stu_ad_id',$stu_ad->as_id)->get('erp_exam_fees_master')->row();
						//$get_stu=$this->db->where('ef_batch',$batch1)->where('ef_stu_id',$student->id)->get('erp_exam_fees_master')->row();
						
						$get_stu1=$this->db->where('student_batch',$batch1)->where('applied_year',$applied_year1)->where('applied_sem',$applied_sem1)->where('student_id',$student->id)->where('sem',$sem1)->group_by('subject_id')->get('erp_arrear_detail')->result_array();
						$fee_val = sizeof($get_stu1);
						 $result = array_map(function($x)
                            {
                             return $x['subject_id'];
                            }, $get_stu1);
						//$gsub = array();
						//$fee_val = '';
						$ch_val = '';
						$dt_val = '';
						if(isset($get_stu)){
						   //$gsub = explode(',',$get_stu->subject_id);
						   //$fee_val = $get_stu->amount_total;
						   $ch_val = $get_stu->ef_paid_response;
						   $dt_val = date('Y-m-d',strtotime($get_stu->ef_paid_date));
						}
						
						$sublist = '';
						
						//$subj = $studet = $this->db->query('select esm.* from erp_subjectmaster esm left join erp_langallot l on (l.existing_student_id='.$student->id.' and l.batch='.$batch1.' and l.sem='.$sem1.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$student->id.' and e.e_batch='.$batch1.' and e.e_sem='.$sem1.' and e.e_subject=esm.id) where esm.sem='.$sem1.' and esm.batch_year='.$batch1.' and esm.stream='.$student->main_id.' and esm.department='.$student->cour_id.'  and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
						$subj = $studet = $this->db->query('select esm.* from erp_subjectmaster esm where esm.sem='.$sem1.' and esm.batch_year='.$batch1.' and esm.stream='.$student->main_id.' and esm.department='.$student->cour_id.' order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
						foreach ($subj as $subje) {
						$checked = '';
						 if(in_array($subje->id,$result)){
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
						<td><input class="form-control" type="text" id="cnt_<?=$student->id?>" readonly value="<?=$fee_val?>"></td>
					    <!--<td><input class="form-control" type="text" id="amt_<?=$student->id?>" readonly value="<?=$fee_val?>"></td>-->
						<td><input class="form-control" type="text" id="chln_<?=$student->id?>"  value="<?=$ch_val?>"></td>
						<td><input class="form-control" type="date" id="date_<?=$student->id?>"  value="<?=$dt_val?>"></td>
						<?php if(isset($get_stu) AND $get_stu->paid_through==1) { ?>
						<td>Paid Online</td>
						<?php } else { ?>
						<td><button class="btn-success subls" type="text" data-student="<?=$student->id?>">Paid</button>
						<?php if($fee_val > 0) { ?>
						<button class="btn-danger delete" type="text" data-id="<?=$student->id?>" data-year="<?=$applied_year1?>" data-sem="<?=$applied_sem1?>">Delete</button>
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
		  var student = $(this).data('student');
		  var fees_cnt = 0;
		  $("."+student+":checked", allPages).each(function(){
           fees_cnt = fees_cnt + 1;
          });
		  $("#cnt_"+student+"").val(fees_cnt);
		  /*var fees1 = '<?=$fees?>';
		  var fees_cnt = 0;
		  $("#amt_"+student+"").val('');
		  $("."+student+":checked", allPages).each(function(){
           fees_cnt = fees_cnt + 1;
          });
		  var fees = fees_cnt * fees1;
		  $("#amt_"+student+"").val(fees);*/
		});	
		
		$('.subls',allPages).click(function(){
		  var stream = '<?=$stream?>';	
		  var department = '<?=$department?>';	
		  var batch = '<?=$batch1?>';	
		  var sem = '<?=$sem1?>';	
		  var applied_year = '<?=$applied_year1?>';	
		  var applied_sem = '<?=$applied_sem1?>';	
		  var student = $(this).data('student');
		  var fees_cnt = $("#cnt_"+student+"").val();
		  //var fees = $("#amt_"+student+"").val();
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
				//if(chellan!=''){
            $.ajax({
                url: base_url + "coe/markArrPaid",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                    applied_year: applied_year,
                    applied_sem: applied_sem,
                    student: student,
                    subject: subject,
                    fees_cnt: fees_cnt,
                    //fees: fees,
                    chellan: chellan,
                    subcode: subcode,
                    paid_date: paid_date,
                },
                success: function (data) {
					alert('Student fee details updated successfully!!');
					location.reload();
                }
            });
				/*}else{
					alert('Please give Chellan ID!!');
				}*/
		}
			}
		});	
		
		$('.delete',allPages).click(function(){
		  var id = $(this).data('id');
		  var year = $(this).data('year');
		  var sem = $(this).data('sem');
			if(confirm('Are you sure to delete the details?')){
            $.ajax({
                url: base_url + "coe/deleteArrPaid",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    student_id: id,applied_year: year,applied_sem: sem,
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