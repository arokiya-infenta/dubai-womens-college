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
			  <?php if($subject1!=''){
			  $subname1=$this->db->where('id',$subject1)->get('erp_subjectmaster')->row(); $subname=$subname1->subName;}else{$subname='';} ?>
			  <input type="hidden" id="subname" value="<?=$subname?>">	
			</div>
			<div class="col-lg-3">
			   <label>Month</label>
            <input class="form-control" type="month"  id="month" name="month" value="<?=$month1?>" required/>
			  </div>
			<!--<div class="col-lg-2">
			   <label>Hour</label>
			<select class="form-control" id="period" name="period" required>
			  <option value="">Select Hour</option>
			  <?php $period=array(1,2,3,4,5,6);
			  foreach($period as $period){ 
			  ?>
			  <option value="<?=$period?>" <?php if($period1==$period){echo 'selected';}?>><?=$period?></option>
			  <?php } ?>
			  </select>
			</div>
			<div class="col-lg-2">
			   <label>Sem</label>
			<select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Sem</option>
			  <?php $sem=array(1,2,3,4,5,6,7,8);
			  foreach($sem as $sem){ 
			  ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			</div>-->
				 <div class="col-lg-2 mt-4">
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
			  <div class="row">
			  <div class="col-lg-12">
			  <span style="color:red;"><i>Note:  A- Absent, P- Present, NC- No Class</i></span>
			  </div>
			  </div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="attendance-report1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Reg No.</th>
                        <th>Student Name</th>
						<?php $dateNo = 30; 
						$dv= explode('-',$month1);
						$mnth_arr = array('01','03','05','07','08','10','12');
						if(in_array($dv[1],$mnth_arr)){$dateNo = 31;}
						for($i=1;$i<=$dateNo;$i++){?>
                        <th colspan=12 style="text-align:center!important;"><?=date('d-F',strtotime($month1.'-'.$i))?></th>
						<?php } ?>
                    </tr>
                    
					<tr>
                        <th></th>
                        <th></th>
                        <th></th>
						<?php $dateNo = 30; 
						$dv= explode('-',$month1);
						$mnth_arr = array('01','03','05','07','08','10','12');
						if(in_array($dv[1],$mnth_arr)){$dateNo = 31;}
						for($ii=1;$ii<=$dateNo;$ii++){?>
                        <th colspan=6>Attendance</th>
                        <th colspan=6>OD</th>
						<?php } ?>
                    </tr>
					<tr>
                        <th></th>
                        <th></th>
                        <th></th>
						<?php $dateNo = 30; 
						$dv= explode('-',$month1);
						$mnth_arr = array('01','03','05','07','08','10','12');
						if(in_array($dv[1],$mnth_arr)){$dateNo = 31;}
						for($ii=1;$ii<=$dateNo;$ii++){ for($h=1;$h<=6;$h++){ $hr[$ii][$h] = 'H'.$h; ?>
                        <th><?=$hr[$ii][$h]?></th>
						<?php } for($h_od=1;$h_od<=6;$h_od++){ $hr1[$ii][$h_od] = 'H'.$h_od; ?>
                        <th><?=$hr1[$ii][$h_od]?></th>
						<?php }} ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $sno=1;
					foreach($stu_list as $stulist){					 
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stulist->reg_no_?></td>
                        <td><?=$stulist->student_name_?></td>
						<?php $dateNo = 30; 
						$dv= explode('-',$month1);
						$mnth_arr = array('01','03','05','07','08','10','12');
						if(in_array($dv[1],$mnth_arr)){$dateNo = 31;}
						for($iii=1;$iii<=$dateNo;$iii++){
						for($h1=1;$h1<=6;$h1++){	
							$date1 = $month1.'-'.$iii;
							$get_sub1=$this->db->where('subCode',$subname1->subCode)->where('stream',$stulist->main_id)->where('department',$stulist->cour_id)->where('batch_year',$batch1)->get('erp_subjectmaster')->row();
		                    $subjectt1=$get_sub1->id;
                     $stu_att = $this->db->where('batch_year',$batch1)->where('subject_id',$subjectt1)->where('period',$h1)->where('att_date',$date1)->where('student_id',$stulist->id)->get('erp_stu_attendance')->row();
                     $stu_od = $this->db->where('batch_year',$batch1)->where('subject_id',$subjectt1)->where('period',$h1)->where('att_date',$date1)->where('student_id',$stulist->id)->get('erp_stu_od')->row();
					 $att[$h1] = '<span style="color:blue;">NC</span>';
					 $od[$h1] = '<span style="color:blue;">NC</span>';
                     if(isset($stu_att)){if($stu_att->attndnce_status == 1){
					 $att[$h1] = '<span style="color:green;">P</span>'; }else {
					 $att[$h1] = '<span style="color:red;">A</span>';	 
					 }
					 }	
                     if(isset($stu_od)){if($stu_od->od_status == 1){
					 $od[$h1] = '<span style="color:green;">YES</span>'; }else {
					 $od[$h1] = '<span style="color:red;">No</span>';	 
					 }
					 }
						}					 
							?>
                        <td><?=$att[1]?></td>
                        <td><?=$att[2]?></td>
                        <td><?=$att[3]?></td>
                        <td><?=$att[4]?></td>
                        <td><?=$att[5]?></td>
                        <td><?=$att[6]?></td>
						<td><?=$od[1]?></td>
						<td><?=$od[2]?></td>
						<td><?=$od[3]?></td>
						<td><?=$od[4]?></td>
						<td><?=$od[5]?></td>
						<td><?=$od[6]?></td>
						<?php } ?>
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
	var subname = $('#subname').val();
	var fullDate = new Date();
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	var myTable = $('#attendance-report1').DataTable({
		pageLength : 50,
		dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: subname +'_'+ currentDate,
				text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
				titleAttr: 'Export Excel',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: subname+'_ '+currentDate,
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "left",
				customize: function (xlsx) {
					
			//Apply styles, Center alignment of text and making it bold.
            var sSh = xlsx.xl['styles.xml'];
  

                },
			}]
			});
   } );		
</script>