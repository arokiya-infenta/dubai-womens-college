<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	  
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List
		  </div>
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
			<div class="col-lg-4">
			   <label>Subject</label>
			<select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(sizeof($sub_list)>0){foreach($sub_list as $sublist){ 
			  $sub_name=$this->db->where('id',$sublist->subject_id)->get('erp_subjectmaster')->row();
			  ?>
			  <option value="<?=$sublist->subject_id?>" <?php if($subject1==$sublist->subject_id){echo 'selected';}?>><?=$sub_name->subName?></option>
			  <?php }} ?>
			  </select>
			  <?php if($subject1!=''){$subjectt = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();
			  $dept = $this->db->where('main_id',$subjectt->stream)->where('cour_id',$subjectt->department)->get('department_details')->row();
			  ?>
			  <input type="hidden" id="subject_code" value="<?=$subjectt->subCode?>">
			  <input type="hidden" id="subject_name" value="<?=$subjectt->subName?>">
			  <input type="hidden" id="department" value="<?=$dept->short_name?>">
			  <?php } ?>
			</div>
			<div class="col-lg-2">
			   <label>From Date</label>
            <input class="form-control" type="date"  id="from_date" name="from_date" value="<?=$from_date1?>" required/>
            <input class="form-control" type="hidden"  id="from_date1" value="<?=date('d-m-Y',strtotime($from_date1))?>" required/>
			  </div>
			<div class="col-lg-2">
			   <label>To Date</label>
			<input class="form-control" type="date"  id="to_date" name="to_date" value="<?=$to_date1?>" required/>
			<input class="form-control" type="hidden"  id="to_date1" value="<?=date('d-m-Y',strtotime($to_date1))?>" required/>
			</div>
				 <div class="col-lg-1 mt-4">
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
    </div>	  

	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row mt-3">
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="attendance-consolidated" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <!--<th>Roll No.</th>-->
                        <th>Reg No.</th>
                        <th>Student Name</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Total</th>
                        <th>Percentage</th>
                        <th>Eligible Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sno=1;
					foreach($stu_list as $stulist){	
                    $roll_no = explode(' ',$stulist->batch_);	
                    $rollno = explode('/',$stulist->batch_);	
                     $total = 0;	 
					 $percentage = 0;					
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <!--<td><?=$rollno[1]?></td>-->
                        <td><?=$stulist->reg_no_?></td>
                        <td><?=$stulist->student_name_?></td>
						<?php 
							$from_date = date('Y-m-d',strtotime($from_date1));
							$to_date = date('Y-m-d',strtotime($to_date1));
							$get_sub1=$this->db->where('subCode',$subjectt->subCode)->where('stream',$stulist->main_id)->where('department',$stulist->cour_id)->where('batch_year',$batch1)->get('erp_subjectmaster')->row();
		                    $subjectt1=$get_sub1->id;
                     $present = $this->db->where('batch_year',$batch1)->where('subject_id',$subjectt1)->where('attndnce_status',1)->where('student_id',$stulist->id)->where('att_date between "'.$from_date.'" and "'.$to_date.'"')->get('erp_stu_attendance')->num_rows();
					 
					 $absent = $this->db->where('batch_year',$batch1)->where('subject_id',$subjectt1)->where('attndnce_status',0)->where('student_id',$stulist->id)->where('att_date between "'.$from_date.'" and "'.$to_date.'"')->get('erp_stu_attendance')->num_rows();		
					 $total = 	$present + 	$absent;	
                     if($total!=0){					 
					 $percentage = ($present/$total) * 100;}
					  $status='';
					 if($percentage >=75){$status='Eligible';}
					 elseif($percentage >= 65 && $percentage < 75){$status='Condonation';}
					 elseif($percentage >= 50 && $percentage < 65){$status='Not Eligible';}
					 else{$status='Redo';}
							?>
                        <td><?=$present?></td>
                        <td><?=$absent?></td>
                        <td><?=$total?></td>
                        <td><?=round($percentage,1)?>%</td>
                        <td><?=$status?></td>
                    </tr>
                    <?php } ?>
               
                </tbody>
            </table>
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
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#batch').change(function(){
			$('#subject').empty();
		  var batch = $(this).val();	
			if (batch!='') {
            $.ajax({
                url: base_url + "employee/getEmpSubject",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			$('#pgrm').css('display','none');
		}
		});
	});
	</script>
	<script>
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function(){
	var myTable = $('#attendance-report1').DataTable({});
		
   } );		
</script>