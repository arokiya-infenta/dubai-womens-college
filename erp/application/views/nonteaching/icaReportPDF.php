<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>MSSW - COE</title>

</head>

<style>
table {
                border-collapse: collapse;
            }	
.table {
  text-align: center;
  font-weight:bold;
  font-size:13px;
}		
</style>
<body>

<div id="wrapper">
			
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  
		  <table cellpadding=0 cellspacing=0>
			<td><img src="<?php echo base_url().'system/images/logo.png' ?>" style="width:150px;height:150px;"></td>
			<td style="width:630px;">
			<p style="font-weight:bold;font-size:16px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<!--<p style="font-weight:bold;font-size:16px;" align="center">(Affiliated to the University of Madras)</p>-->
			<p style="font-weight:bold;font-size:16px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			
			<p style="font-weight:bold;font-size:16px;" align="center">END SEMESTER EXAMINATION - </p>
			</td>
			<td></td>
			</table>
			<hr>
		  </div>
            <div class="card-body">
			
			<br/>
			<?php 
function ConverToRoman($num){ 
    $n = intval($num); 
    $res = ''; 

    //array of roman numbers
    $romanNumber_Array = array( 
        'M'  => 1000, 
        'CM' => 900, 
        'D'  => 500, 
        'CD' => 400, 
        'C'  => 100, 
        'XC' => 90, 
        'L'  => 50, 
        'XL' => 40, 
        'X'  => 10, 
        'IX' => 9, 
        'V'  => 5, 
        'IV' => 4, 
        'I'  => 1); 

    foreach ($romanNumber_Array as $roman => $number){ 
        //divide to get  matches
        $matches = intval($n / $number); 

        //assign the roman char * $matches
        $res .= str_repeat($roman, $matches); 

        //substract from the number
        $n = $n % $number; 
    } 

    // return the result
    return $res; 
}
?>
			
			<table style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr>
		<?php $subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row(); 
		$dept = $this->db->where('main_id',$subj->stream)->where('cour_id',$subj->department)->get('department_details')->row(); 
		?>
			<td style="font-weight:bold;font-size:15px;" align="center">BATCH: <?=$batch?></td>
			<td style="font-weight:bold;font-size:15px;" align="center">DEPARTMENT: <?=$dept->comp_name?></td>
			<td style="font-weight:bold;font-size:15px;" align="center">SEMESTER: <?=ConverToRoman($sem)?></td>
			</tr>
			</table>
			
			<table style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr>
		<?php 
		?>
			<td style="font-weight:bold;font-size:15px;" align="center"><?=$subj->subName?>(<?=$subj->subCode?>) Consolidated ICA Mark as on <?=date('d-m-Y').', '.date('h:i:sa')?></td>
			</tr>
			</table>
			
			<table class="table" style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr class="table">
			<th class="table">SNO</th>
			<th class="table">REG NO</th>
			<th class="table">STUDENT NAME</th>
			<th class="table">IA1</th>
			<th class="table">IA2</th>
			<th class="table">BEST OF IA</th>
			<th class="table">IN-CLASS TEST</th>
			<th class="table">TAKE-HOME ASSIGNMENTS</th>
			<th class="table">TOTAL ICA MARKS</th>
			<th class="table">RESULT</th>
			<th class="table">STUDENT SIGNATURE</th>
			</tr>
			<?php if(isset($stu_list)){
					$sno=1;
					foreach ($stu_list as $student) {
						$subjectt = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
							$get_sub1=$this->db->where('subCode',$subjectt->subCode)->where('stream',$student->main_id)->where('department',$student->cour_id)->where('batch_year',$batch)->get('erp_subjectmaster')->row();
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
			<tr class="table">
			<td class="table"><?=$sno++?></td>
			<td class="table" style="text-align:left!important;"><?=$student->reg_no_?></td>
			<td class="table" style="text-align:left!important;"><?=$student->student_name_?></td>
			<td class="table"><?=$mark1?></td>
			<td class="table"><?=$mark2?></td>
			<td class="table"><?=$best_ica?></td>
			<td class="table"><?=$mark3?></td>
			<td class="table"><?=$mark4?></td>
			<td class="table"><?=$total?></td>
			<td class="table"><?=$result?></td>
			<td class="table"></td>
			</tr>
			<?php }} ?>
			</table>
			
			<br/>
			<table style="width:100%" cellpadding=0 cellspacing=0>
			<tr>
			<td>
			<p class="s1" style="font-size:15px;font-weight:bold;">SIGNATURE OF THE FACULTY</p>
			</td>
			<td>
			<p class="s1" style="font-size:15px;font-weight:bold;float:right;">SIGNATURE OF THE HOD <br/>
			<span style="font-size:12px;font-weight:normal;">GENERATED BY iStudioTechnologies </span></p>
			</td>
			</tr>
			</table>
			
			
			
            </div>
          </div>
        </div>
      </div>


	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
      
        </div>
      </div>
    </footer>
	<!--End footer-->
   
  </div><!--End wrapper-->

</body>
</html>
