
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
			<label>Written Batch</label>   
			<select class="form-control" name="written_year" id="written_year" required>
			<option value="">Select Year</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch2){?>
			<option value="<?=$batch2->batch_from?>" <?php if($year1==$batch2->batch_from){echo 'selected';}?>><?=$batch2->batch_from?></option>
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
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
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
            <div class="card-body">
              <div class="table-responsive">
			  <div class="row">
			  <div class="col-lg-6 mb-4">
			  <div class="form-group" style="float:left;">
			  <button class="btn btn-sm btn-warning" id="publish_result" onClick="return(Confirm('Are you sure to save the result?'))">Save Result</button>
			  </div>
			  </div>
			  <div class="col-lg-6 mb-4">
				 <div class="form-group" style="float:right;">
				 <?php 
				 $stat = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('main_id',$stream)->where('course_id',$department)->where('subject_id',$subject1)->get('erp_publish_mark')->row();
	
	               if(!isset($stat)){ $style = 'style="display:block"'; $style1 = 'style="display:none"';} 
	               else{ $style1 = 'style="display:block"'; $style = 'style="display:none"';} 
	             ?>
				 <form action="" method="post">
				 <div class="publish" <?=$style?>>
				 <input type="hidden" name="batch" value="<?=$batch1?>">
				 <input type="hidden" name="sem" value="<?=$sem1?>">
				 <input type="hidden" name="subject" value="<?=$subject1?>">
				 <input type="hidden" name="stream" value="<?=$stream?>">
				 <input type="hidden" name="department" value="<?=$department?>">
			  <!--<button class="btn btn-sm btn-success" id="publish" name="publish" onClick="return confirm('Are you sure to publish?');">Publish</button>
		-->    </div>
				 </form>
				 <div class="published" <?=$style1?>>
			  <p style="font-weight:bold;font-size:15px;">Marks published for the department!!</p>
		         </div>
		         </div>
		         </div>
				 </div>

<?php

$subject = $this->db->select("*")->from('erp_subjectmaster')->where('id',$subject1)->get()->result();

//print_r($subject);
				
				if($subject[0]->subNature=="PRACTICAL" && $subject[0]->msw_m_25==1 ){
				


?>


				
<table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No.</th>
                        <th>Name</th>
                        <th>ICA Mark(25)</th>
                        <th>ESE Mark(25)</th>
                        <th>Total(50)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$mark=0;
							}
					$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
				//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}







				if(is_numeric($ica_mark->ica1Mark)){


					$iccamm1 = $ica_mark->ica1Mark;
										}else{
					
					
											$iccamm1 = 00.0;
					
										}	if(is_numeric($ica_mark->ica2Mark)){
					
					
					$iccamm2 = $ica_mark->ica2Mark;
										}else{
					
					
											$iccamm2 = 00.0;
					
										}
										
									
										
										
										if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
					
											$great =$iccamm1;
										}else{
											$great =$iccamm2;
					
										}
									 $great=	number_format($great,1);
			
									 $icaMark =$great;

									 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}

					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					
					
				
				}else{
					$icamrk = 00.0;	
					}
					



					$fimdMax=[];
					$arre=[];
					
					$fimdMax=array($mark2,$mark3,$mark4);
					
					$arre = sort($fimdMax);
					(float)$maxtotal = (float)$fimdMax[1];
					$ese_m = (float)$maxtotal;







					//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
				//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
					//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
					if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
					
					$total = (float)$ica_fin + (float)$ese_m;
					$result = 0;
					
					if($stream == 5){
						if($icamrk >= 12.5 && $ese_m >= 12.5){$result = ' P ';}
						else{
							if($icamrk >= 12.5 && $ese_m < 12.5){$result = ' R(E) ';}
							elseif($icamrk < 12.5 && $ese_m >= 12.5){$result = ' R(I) ';}
							else{$result = 'R(I + E)';}
								}
					}else{
						if($icamrk >= 12.5 && $ese_m >= 12.5){$result = ' P ';}
						else{
							if($icamrk >= 12.5 && $ese_m < 12.5){$result = ' R(E) ';}
							elseif($icamrk < 12.5 && $ese_m >= 12.5){$result = ' R(I)';}
							else{$result = ' R(I + E) ';}
								}
					}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td align="center"><?php if($ica_fin==0){echo"A";}else{echo$ica_fin;}?></td>
						<td align="center"><?php if($ese_m==0){echo"A";}else{echo$ese_m;}?></td>
						<td align="center"><?=ceil($total)?></td>
						<td align="center"><?=$result?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>



<?php  }else if($subject[0]->subNature=="PRACTICAL" && $subject[0]->msw_m_25==0){ ?>

	<table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No.</th>
                        <th>Name</th>
                        <th>ICA Mark(50)</th>
                        <th>ESE Mark(50)</th>
                        <th>Total(100)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$mark=0;
							}
					$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
				//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}







				if(is_numeric($ica_mark->ica1Mark)){


					$iccamm1 = $ica_mark->ica1Mark;
										}else{
					
					
											$iccamm1 = 00.0;
					
										}	if(is_numeric($ica_mark->ica2Mark)){
					
					
					$iccamm2 = $ica_mark->ica2Mark;
										}else{
					
					
											$iccamm2 = 00.0;
					
										}
										
									
										
										
										if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
					
											$great =$iccamm1;
										}else{
											$great =$iccamm2;
					
										}
									 $great=	number_format($great,1);
			
									 $icaMark =$great;

									 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}

					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					
					
				
				}else{
					$icamrk = 00.0;	
					}
					



					$fimdMax=[];
					$arre=[];
					
					$fimdMax=array($mark2,$mark3,$mark4);
					
					$arre = sort($fimdMax);
					(float)$maxtotal = (float)$fimdMax[1]+(float)$fimdMax[2];
					 $ese_m = (float)$maxtotal / 2  ;







					//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
				//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
					//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
					if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
					
					$total = (float)$ica_fin + (float)$ese_m;
					$result = 0;
					
					if($stream == 5){
						if($icamrk >= 20 && $ese_m >= 20){$result = ' P ';}
						else{
							if($icamrk >= 20 && $ese_m < 20){$result = ' R(E) ';}
							elseif($icamrk < 20 && $ese_m >= 20){$result = ' R(I) ';}
							else{$result = 'R(I + E)';}
								}
					}else{
						if($icamrk >= 25 && $ese_m >= 25){$result = ' P ';}
						else{
							if($icamrk >= 25 && $ese_m < 25){$result = ' R(E) ';}
							elseif($icamrk < 25 && $ese_m >= 25){$result = ' R(I)';}
							else{$result = ' R(I + E) ';}
								}
					}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td align="center"><?php if($ica_fin==0){echo"A";}else{echo$ica_fin;}?></td>
						<td align="center"><?php if($ese_m==0){echo"A";}else{echo$ese_m;}?></td>
						<td align="center"><?=ceil($total)?></td>
						<td align="center"><?=$result?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>









<?php  }else{ ?>


              <table id="aftermod-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No.</th>
                        <th>Name</th>
                        <th>ICA Mark(50)</th>
                        <th>ESE Mark(50)</th>
                        <th>Total(100)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


								<?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$mark=0;
							}
					$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
				//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}







				if(is_numeric($ica_mark->ica1Mark)){


					$iccamm1 = $ica_mark->ica1Mark;
										}else{
					
					
											$iccamm1 = 00.0;
					
										}	if(is_numeric($ica_mark->ica2Mark)){
					
					
					$iccamm2 = $ica_mark->ica2Mark;
										}else{
					
					
											$iccamm2 = 00.0;
					
										}
										
									
										
										
										if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
					
											$great =$iccamm1;
										}else{
											$great =$iccamm2;
					
										}
									 $great=	number_format($great,1);
			
									 $icaMark =$great;

									 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}

					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					
					
				
				}else{
					$icamrk = 00.0;	
					}
					



					$fimdMax=[];
					$arre=[];
					
					$fimdMax=array($mark2,$mark3,$mark4);
					
					$arre = sort($fimdMax);
					(float)$maxtotal = (float)$fimdMax[1]+(float)$fimdMax[2];


					if($mark_det->moderate_status ==0){
					$ese_m = round($maxtotal/4);
					}else{
						$ese_m = (float)$mark_det->moderated_mark/2;

					}






					//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
				//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
					//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
					if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
					
					$total = ceil((float)$ica_fin + (float)$ese_m);
					$result = 0;
					
					if($stream == 5){
						if($icamrk >= 20 && $ese_m >= 20){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 20 && $ese_m < 20){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 20 && $ese_m >= 20){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}else{
						if($icamrk >= 25 && $ese_m >= 25){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 25 && $ese_m < 25){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 25 && $ese_m >= 25){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td align="center"><?php if($ica_fin==0){echo"A";}else{echo$ica_fin;}?></td>
						<td align="center"><?php 
						
						
						if($ese_m==0){echo"A";}else{echo $ese_m;}
						
						
						?></td>
						<td align="center"><?=$total?></td>
						<td align="center"><?=$result?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>



<?php } ?>






















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
var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#aftermod-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				bold: true,
                        fontSize: 12,
				title: 'Passing Board Report - <?=$all_dep_details[0]->comp_name ?> ',
				messageTop: '<?=$all_dep_details[0]->stream ?> - <?=$all_dep_details[0]->comp_name ?> - <?=$all_sub_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_sub_details[0]->subCode ?> -  <?=$all_sub_details[0]->subName ?> - <?=$exam_details?>',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'after_moderation_report - <?=$all_dep_details[0]->comp_name ?> ' +currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4, 5, 6],
				 
                }
			},
			{ 
				extend: 'pdfHtml5',
				 
				filename: 'after_moderation_report - <?=$all_dep_details[0]->comp_name ?> ' +currentDate+'',
			
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6],
					alignment: 'right',
				
				},
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					
					doc.content[1].margin = [ 120, 20, 120, 0 ],
				      
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					doc.content.splice( 1, 1, {
                        alignment: 'center',
                        bold: true,
                        fontSize: 12,
                        text: 'Passing Board  Report : <?=$all_dep_details[0]->stream ?> - <?=$all_dep_details[0]->comp_name ?> - <?=$all_sub_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_sub_details[0]->subCode ?> -  <?=$all_sub_details[0]->subName ?> - <?=$exam_details?>.',
						margin: [0, 0, 0, 0],
                    } );
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'External Examiner',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: 'Chairman'
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });
                }
			}]
		});
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
		
		$('#publish').click(function(){
			$('.published').css('display','block');
			$('.publish').css('display','none');
		});		
		
		$('#publish_result').click(function(){
		var result=Array();
		var rsval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
		var written_year=$('#written_year').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(6) span').each(function(){
            result.push($(this).data('student'));
            rsval.push($(this).text());
            });
		});
		if (confirm('Are you sure to save the result?')) {
            $.ajax({
                url: base_url + "coe/publishResult",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    result: result,rsval: rsval,main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,written_year: written_year,
                },
                success: function (data) {
                }
            });
					alert('Marks Saved Successfully!!');
		}
		});
		
		
	});
	</script>
	<script>
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
