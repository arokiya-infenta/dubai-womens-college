
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
		  $closing_date = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->get('erp_ica_marks_closing')->row();
		  if(isset($closing_date)){
	  if(date('Y-m-d') < $closing_date->closing_date){ $avail = 1; } else { $avail = 2; }
		  } else { $avail = 3; }
		  if($avail == 1 || $avail == 3){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  <p style="font-style: italic;color:red;">
		  <?php if(isset($ica_closing)){ echo '* ICA Closing Date is on '.date('d-m-Y',strtotime($ica_closing->closing_date)).''; } else { echo '*Closing Date is not fixed yet!'; } ?>
		  </p><br/>
		  <?php /*$today = date('Y-m-d');
		  $ica1_det = $this->db->where('subject_id',$subject1)->where('ICA',1)->get('ica_timetable')->row();
		  if(isset($ica1_det) && ($today > $ica1_det->date)){*/
		  ?>
		  <button type="button" class="btn btn-sm btn-success" id="ica1_submit">Save ICA1</button><?php //} ?>
		  <?php /*$ica2_det = $this->db->where('subject_id',$subject1)->where('ICA',2)->get('ica_timetable')->row();
		  if(isset($ica2_det) && ($today > $ica2_det->date)){*/
		  ?>
		  <button type="button" class="btn btn-sm btn-success" id="ica2_submit">Save ICA2</button><?php //} ?>
		  <button type="button" class="btn btn-sm btn-success" id="ic_submit">Save In Class</button>
		  <button type="button" class="btn btn-sm btn-success" id="th_submit">Save Take Home</button>
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
						<?php /*$today = date('Y-m-d');
		  $ica1_det = $this->db->where('subject_id',$subject1)->where('ICA',1)->get('ica_timetable')->row();
		  if(isset($ica1_det) && ($today > $ica1_det->date)){*/
		  ?>
                        <th>ICA1</th><?php //} ?>
						<?php /*$ica2_det = $this->db->where('subject_id',$subject1)->where('ICA',2)->get('ica_timetable')->row();
		  if(isset($ica2_det) && ($today > $ica2_det->date)){*/
		  ?>
                        <th>ICA2</th><?php //} ?>
                        <th>In Class</th>
                        <th>Take Home</th>
                       
                       
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
						if($mark_det->ica1Mark!=''&&$mark_det->ica1Mark!=null){$checked1='checked';$readonly1='';$mark1=$mark_det->ica1Mark;}else{$checked1='';$readonly1='readonly';$mark1='';}
						if($mark_det->ica2Mark!=''&&$mark_det->ica2Mark!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->ica2Mark;}else{$checked2='';$readonly2='readonly';$mark2='';}
						if($mark_det->inClassMark!=''&&$mark_det->inClassMark!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->inClassMark;}else{$checked3='';$readonly3='readonly';$mark3='';}
						if($mark_det->takeHomeMark!=''&&$mark_det->takeHomeMark!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->takeHomeMark;}else{$checked4='';$readonly4='readonly';$mark4='';}
						}
						else{
							$checked1='';$readonly1='readonly';$mark1='';
							$checked2='';$readonly2='readonly';$mark2='';
							$checked3='';$readonly3='readonly';$mark3='';
							$checked4='';$readonly4='readonly';$mark4='';
							}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
						<?php //if($student->exempted_status==1){$check='checked';}else{$check='';}?>
						<?php /*$today = date('Y-m-d');
		  $ica1_det = $this->db->where('subject_id',$subject1)->where('ICA',1)->get('ica_timetable')->row();
		  if(isset($ica1_det) && ($today > $ica1_det->date)){*/
		  ?>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="ica1" style="width:20px;height:20px;" <?=$checked1?>>
						<input type="text" class="form-control icaval1" value="<?=$mark1?>" <?=$readonly1?>>
						</td><?php //} ?>
						<?php /*$ica2_det = $this->db->where('subject_id',$subject1)->where('ICA',2)->get('ica_timetable')->row();
		  if(isset($ica2_det) && ($today > $ica2_det->date)){*/
		  ?>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="ica2" style="width:20px;height:20px;" <?=$checked2?>>
						<input type="text" class="form-control icaval2" value="<?=$mark2?>" <?=$readonly2?>>
						</td><?php //} ?>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="inclass" style="width:20px;height:20px;" <?=$checked3?>>
						<input type="text" class="form-control icval" value="<?=$mark3?>" <?=$readonly3?>>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="takehome" style="width:20px;height:20px;" <?=$checked4?>>
						<input type="text" class="form-control thval" value="<?=$mark4?>" <?=$readonly4?>>
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
	  <?php } else{ ?>
		  
		  <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-body">
		  
		  <div class="row">
        <div class="col-lg-12">
		<div class="form-group" align="center">
		<p>ICA Marks has been closed for the Batch.</p>
		</div>
		</div>
		   </div>
		   
		  </div>
		 </div>
        </div>
       </div>		
		  
	  <?php }} ?>
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
		
		
$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		$(".ica1",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".ica2",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".inclass",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".takehome",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	
		$('#ica1_submit').click(function(){
		var ica1=Array();	
		var ica1_not=Array();	
		var icaval1=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();		
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('input[class=ica1]:checked').each(function(){
            ica1.push($(this).data('student'));
            icaval1.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('input[class=ica1]:not(:checked)').each(function(){
            ica1_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA1Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica1: ica1,icaval1: icaval1,main_id: main_id,course_id: course_id,ica1_not: ica1_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('ICA1 Marks Added Successfully!!');
		}
		});
		
		$('#ica2_submit').click(function(){
		var ica2=Array();	
		var ica2_not=Array();	
		var icaval2=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
		var sem=$('#sem').val();		
			allPages.each(function(){
			$(this).closest('tr').find('input[class=ica2]:checked').each(function(){
            ica2.push($(this).data('student'));
            icaval2.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('input[class=ica2]:not(:checked)').each(function(){
            ica2_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA2Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica2: ica2,icaval2: icaval2,main_id: main_id,course_id: course_id,ica2_not: ica2_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
					//alert(data);
                }
            });
					alert('ICA2 Marks Added Successfully!!');
		}
		});
		
		$('#ic_submit').click(function(){
		var inclass=Array();	
		var inclass_not=Array();	
		var icval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
		var sem=$('#sem').val();		
			allPages.each(function(){
			$(this).closest('tr').find('input[class=inclass]:checked').each(function(){
            inclass.push($(this).data('student'));
            icval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('input[class=inclass]:not(:checked)').each(function(){
            inclass_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/inClassMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    inclass: inclass,icval: icval,main_id: main_id,course_id: course_id,inclass_not: inclass_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
					//alert(data);
                }
            });
					alert('In Class Marks Added Successfully!!');
		}
		});
		
		$('#th_submit').click(function(){
		var takehome=Array();	
		var takehome_not=Array();	
		var thval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();		
			allPages.each(function(){
			$(this).closest('tr').find('input[class=takehome]:checked').each(function(){
            takehome.push($(this).data('student'));
            thval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('input[class=takehome]:not(:checked)').each(function(){
            takehome_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/takeHomeMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    takehome: takehome,thval: thval,main_id: main_id,course_id: course_id,takehome_not: takehome_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
					//alert(data);
                }
            });
					alert('Take Home Marks Added Successfully!!');
		}
		});
	});
	</script>