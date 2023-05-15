<?php $program = isset($program) ? $program : '';
$department = isset($department) ? $department : '';
?> 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 <!-- Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student Attendance</div>
            <div class="card-body">
			<form action="<?=base_url().'employee/stuAttendance1'?>" method="post">
              <div class="row">
			  <div class="col-lg-3">
			  <select class="form-control" id="department" name="department">
			  <option value="">Select Stream</option>
			  <option value="1" <?php if($department==1){echo 'selected';}?>>Aided</option>
			  <option value="2" <?php if($department==2){echo 'selected';}?>>Self Finance</option>
			  </select>
			  </div>
			  <?php if($program!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="pgrm" <?=$style?>>
			  <select class="form-control" id="program" name="program">
			  <option value="">Select Department</option>
			  <?php if((sizeof($programm)>0)&&isset($programm)){foreach($programm as $programm){ ?>
			  <option value="<?=$programm->id?>" <?php if($program==$programm->id){echo 'selected';}?>><?=$programm->dept_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  <div class="col-lg-6">
			  <div class="form-group" style="float:right;">
			  <button type="submit" class="btn btn-primary btn-sm" name="submit">Submit</button>
			  </div>
			  </div>
			  </div>
			  </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>1st Period</th>
                        <th>2nd Period</th>
                        <th>3rd Period</th>
                        <th>4th Period</th>
                        <th>5th Period</th>
                        <th>6th Period</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($stu_list as $stulist){
					$date=date('Y-m-d');	
$getAtt1=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('1_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();
$getAtt2=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('2_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();
$getAtt3=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('3_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();
$getAtt4=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('4_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();
$getAtt5=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('5_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();
$getAtt6=$this->db->where('student_id',$stulist->id)->where('dept',$stulist->dept_)->where('6_period','1')->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$date)->get('erp_studentattendance')->row();	
if(isset($getAtt1))	{$checked1='checked';$readonly1='disabled';}else{$checked1='';$readonly1='';}			
if(isset($getAtt2))	{$checked2='checked';$readonly2='disabled';}else{$checked2='';$readonly2='';}			
if(isset($getAtt3))	{$checked3='checked';$readonly3='disabled';}else{$checked3='';$readonly3='';}			
if(isset($getAtt4))	{$checked4='checked';$readonly4='disabled';}else{$checked4='';$readonly4='';}			
if(isset($getAtt5))	{$checked5='checked';$readonly5='disabled';}else{$checked5='';$readonly5='';}			
if(isset($getAtt6))	{$checked6='checked';$readonly6='disabled';}else{$checked6='';$readonly6='';}			
					 ?>
                      <tr>
                        <td><?=$stulist->student_name_?></td>
                        <td><input type="checkbox" value="1" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked1.' '.$readonly1?> ></td>
                        <td><input type="checkbox" value="2" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked2.' '.$readonly2?>></td>
                        <td><input type="checkbox" value="3" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked3.' '.$readonly3?>></td>
                        <td><input type="checkbox" value="4" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked4.' '.$readonly4?>></td>
                        <td><input type="checkbox" value="5" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked5.' '.$readonly5?>></td>
                        <td><input type="checkbox" value="6" data-student="<?=$stulist->id?>" data-dept="<?=$stulist->dept_?>" <?=$checked6.' '.$readonly6?>></td>
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
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#department').change(function(){
			$('#pgrm').css('display','block');
			$('#program').empty();
		  var dept = $(this).val();	
			if (dept!='') {
            $.ajax({
                url: base_url + "employee/getPgrm",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    dept: dept
                },
                success: function (data) {
					$('#program').append(data);
                }
            });
        }else{
			$('#pgrm').css('display','none');
		}
		});
	});
	</script>
	<script>
$("input[type=checkbox]").click(function () {
 var period=$(this).val();	
 var student=$(this).data('student');
 var dept=$(this).data('dept');
 var checkbox=$(this);
        if (student!='') {
            $.ajax({
                url: base_url + "employee/markAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    period: period, student: student, dept: dept
                },
                success: function (data) {
					if(data){
					checkbox.prop("disabled", true);
					checkbox.prop('checked', true);
					}
                }
            });
        }
    });				
</script>		