
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
		  <div class="card-header">
		  <button type="button" class="btn btn-sm btn-success" id="ica_submit">Save ICA</button>
		  <button type="button" class="btn btn-sm btn-success" id="internal_submit">Save Internal</button>
		  <button type="button" class="btn btn-sm btn-success" id="external_submit">Save External</button>
		  <button type="button" class="btn btn-sm btn-success" id="thirdparty_submit">Save ThirdParty</button>
		  <!--<button type="button" class="btn btn-sm btn-success" id="average_submit">Save Average</button>-->
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
												<th>Register Number</th>
                        <th>Name</th>
                       
                        <th>ICA Valuation</th>
                        <th>Internal Valuation</th>
                        <th>External Valuation</th>
                        <th>Third Party Valuation</th>
                        <!--<th>Average</th>-->
                       
                       
                    </tr>
                </thead>
                <tbody>
               <?php 
						
						
// PHP program to find element closest 
// to given target. 
  
// Returns element closest to target in arr[] 
function findClosest($arr, $n, $target) 
{ 
    // Corner cases 
    if ($target <= $arr[0]) 
        return $arr[0]; 
    if ($target >= $arr[$n - 1]) 
        return $arr[$n - 1]; 
  
    // Doing binary search 
    $i = 0;
    $j = $n;
    $mid = 0; 
    while ($i < $j) 
    { 
        $mid = ($i + $j) / 2; 
  
        if ($arr[$mid] == $target) 
            return $arr[$mid]; 
  
        /* If target is less than array element, 
            then search in left */
        if ($target < $arr[$mid]) 
        { 
  
            // If target is greater than previous 
            // to mid, return closest of two 
            if ($mid > 0 && $target > $arr[$mid - 1]) 
                return getClosest($arr[$mid - 1], 
                                  $arr[$mid], $target); 
  
            /* Repeat for left half */
            $j = $mid; 
        } 
  
        // If target is greater than mid 
        else
        { 
            if ($mid < $n - 1 && 
                $target < $arr[$mid + 1]) 
                return getClosest($arr[$mid], 
                                  $arr[$mid + 1], $target); 
            // update i 
            $i = $mid + 1; 
        } 
    } 
  
    // Only single element left after search 
    return $arr[$mid]; 
} 
  
// Method to compare which one is the more close. 
// We find the closest by taking the difference 
// between the target and both values. It assumes 
// that val2 is greater than val1 and target lies 
// between these two. 
function getClosest($val1, $val2, $target) 
{ 
    if ($target - $val1 >= $val2 - $target) 
        return $val2; 
    else
        return $val1; 
} 
  
// Driver code 
/*$arr = array( 1, 2, 4, 5, 6, 6, 8, 9 ); 
$n = sizeof($arr); 
$target = 11; 
echo (findClosest($arr, $n, $target)); */
function abs_diff($v1, $v2) {
	(int)$diff = (int)$v1 - (int)$v2;
	return (int)$diff < 0 ? (-1) * (int)$diff : (int)$diff;
}
?>

                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->ica!=''&&$mark_det->ica!=null){$checked1='checked';$readonly1='';$mark1=$mark_det->ica;}else{$checked1='';$readonly1='readonly';$mark1=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$checked1='';$readonly1='readonly';$mark1=0;
							$checked2='';$readonly2='readonly';$mark2=0;
							$checked3='';$readonly3='readonly';$mark3=0;
							$checked4='';$readonly4='readonly';$mark4=0;
							}
					//$ica_mark = $this->db->select('GREATEST(ica1Mark, ica2Mark) as icaMark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
	/* 		echo"<pre>";	
					
print_r($ica_mark); */


				//	echo $ica_mark->ica1Mark ."-". $ica_mark->ica2Mark."<br>";

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
					
					
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
					if($great != '' || $$great != null){$icaMark = $great;}else{$icaMark = 0;}
					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					}else{
					$icamrk = 'A';	
					}
					
					$average = 0;
					$av_diff = abs((int)$mark2 - (int)$mark3);
					if($av_diff <= 15){$average = ((int)$mark2 + (int)$mark3) / 2;}
					if($av_diff > 15 && $mark4 != ''){

$arr = array($mark2, $mark3);
$n = 2;
$target = $mark4; 
$closest = findClosest($arr, $n, $target);

$average = ((int)$closest + (int)$mark4) / 2;
  
  
					}




					if((int)$mark2 <= 40 || (int)$mark3 <= 40 ){

						 $class='red';
				
				
					}else{
				
							$class='black';
				
					}

				
				
				$tdiff = abs_diff($mark2, $mark3);
				if($tdiff > 15.5){

					$class ="#6600ff";

				}


					?>
                      <tr  style="color: <?=$class?>;" >
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td>
						<!--<input type="checkbox" data-student="<?=$student->id?>" class="ica" style="width:20px;height:20px;" <?=$checked1?>>
						<input type="text" class="form-control icaval" value="<?=$mark1?>" <?=$readonly1?>>-->
						<input type="checkbox" data-student="<?=$student->id?>" class="ica" style="width:20px;height:20px;" checked disabled>
						<input type="text" class="form-control icaval " value="<?=$icamrk?>" readonly>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="internal" style="width:20px;height:20px;" <?=$checked2?>>
						<input type="text" class="form-control intval current_field_selector" value="<?=$mark2?>" <?=$readonly2?>>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="external" style="width:20px;height:20px;" <?=$checked3?>>
						<input type="text" class="form-control extval current_field_selector" value="<?=$mark3?>" <?=$readonly3?>>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="thirdparty" style="width:20px;height:20px;" <?=$checked4?>>
						<input type="text" class="form-control tpval current_field_selector" value="<?=$mark4?>" <?=$readonly4?>>
						</td>
						<!--<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="average" style="width:20px;height:20px;" checked disabled>
						<input type="text" class="form-control avval" value="<?=$average?>" readonly>
						</td>-->
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

		//$( 'current_field_selector' ).focusNextInputField();

	
		$(".intval").each(function() {


var val = $(this).val();

if(val == 26){

	
}

});


var myTable = $('#exammarks-datatable').DataTable({
 // lengthChange: false,
        buttons: [  'excel', 'pdf' ],
				"lengthMenu": [[100, "All", 50, 25], [100, "All", 50, 25]]
    //    "order": [[ 8, "desc" ]],

});
var allPages = myTable.rows().nodes().to$();
		
		$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){




//alert();

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
		
		
$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		/*$(".ica",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});*/
	$(".internal",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".external",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".thirdparty",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	
		$('#ica_submit').click(function(){
		var ica=Array();	
		var ica_not=Array();	
		var icaval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();	
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica]:checked').each(function(){
            ica.push($(this).data('student'));
            icaval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica]:not(:checked)').each(function(){
            ica_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/icaTotalMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica: ica,icaval: icaval,main_id: main_id,course_id: course_id,ica_not: ica_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {

									console.log(data);

                }
            });
					alert('ICA Marks Added Successfully!!');
		}
		});
		
		$('#internal_submit').click(function(){
		var internal=Array();	
		var internal_not=Array();	
		var intval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();		
		var sem=$('#sem').val();		
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=internal]:checked').each(function(){
            internal.push($(this).data('student'));
            intval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=internal]:not(:checked)').each(function(){
            internal_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/internalMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    internal: internal,intval: intval,main_id: main_id,course_id: course_id,internal_not: internal_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {

									console.log(data);
                }
            });
					alert('Internal Marks Added Successfully!!');
		}
		});
		
		$('#external_submit').click(function(){
		var external=Array();	
		var external_not=Array();	
		var extval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=external]:checked').each(function(){
            external.push($(this).data('student'));
            extval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=external]:not(:checked)').each(function(){
            external_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/externalMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    external: external,extval: extval,main_id: main_id,course_id: course_id,external_not: external_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('In Class Marks Added Successfully!!');
		}
		});
		
		$('#thirdparty_submit').click(function(){
		var thirdparty=Array();	
		var thirdparty_not=Array();	
		var tpval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(6) input[class=thirdparty]:checked').each(function(){
            thirdparty.push($(this).data('student'));
            tpval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(6) input[class=thirdparty]:not(:checked)').each(function(){
            thirdparty_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/thirdPartyMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    thirdparty: thirdparty,tpval: tpval,main_id: main_id,course_id: course_id,thirdparty_not: thirdparty_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('Third Party Marks Added Successfully!!');
		}
		});
		
		$('#average_submit').click(function(){
		var average=Array();	
		var average_not=Array();	
		var avval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(7) input[class=average]:checked').each(function(){
            average.push($(this).data('student'));
            avval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(7) input[class=average]:not(:checked)').each(function(){
            average_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/averageMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    average: average,avval: avval,main_id: main_id,course_id: course_id,average_not: average_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('Average Marks Added Successfully!!');
		}
		});
	});
	</script>
