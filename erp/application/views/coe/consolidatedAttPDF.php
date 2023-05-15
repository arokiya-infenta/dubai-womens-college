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
			<!--<td style="width:630px;">-->
			<td style="width:100%;">
			<p style="font-weight:bold;font-size:16px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<!--<p style="font-weight:bold;font-size:16px;" align="center">(Affiliated to the University of Madras)</p>-->
			<p style="font-weight:bold;font-size:16px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<?php if($sem1==1 || $sem1==3 || $sem1==5){$month='NOV';}
		    if($sem1==2 || $sem1==4 || $sem1==6){$month='APR';} ?>
			<p style="font-weight:bold;font-size:16px;" align="center">END SEMESTER EXAMINATION - <?=$month?></p>
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
			
			<table style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
		<?php $subj = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row(); 
		?>
			<td style="font-weight:bold;font-size:16px;" align="center">Consolidatd Attendance - <?=$subj->subName?> - <?=$subj->subCode?></td>
			</tr>
			</table>
			
			<table style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td style="font-weight:bold;font-size:16px;" align="left">BATCH: <?=$batch1?></td>
			<td style="font-weight:bold;font-size:16px;" align="right">SEMESTER: <?=ConverToRoman($sem1)?></td>
			</tr>
			</table>
			
			<table style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td style="font-weight:bold;font-size:16px;" align="left">From Date: <?=date('d-m-Y',strtotime($from_date1))?></td>
			<td style="font-weight:bold;font-size:16px;" align="right">To Date: <?=date('d-m-Y',strtotime($to_date1))?></td>
			</tr>
			</table>
			
			<table style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
		<?php $dept = $this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row(); 
		?>
			<td style="font-weight:bold;font-size:16px;" align="left">Department: <?=$dept->comp_name?></td>
			</tr>
			</table>
			
			<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
                <thead>
                    <tr>
                        <th width="5%">S.No </th>
                        <th width="30%">Name</th>
                        <th width="10%">Register No.</th>
                        <th width="8%">Absent</th>
                        <th width="8%">Present</th>
                        <th width="8%">Total</th>
                        <th width="8%">Percentage</th>
                       
                       
                    </tr>
                </thead>
				</table>
				<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
                <tbody>


                    
					<tr>
					<td colspan="7" style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Eligible (Above 75%)</td>
					</tr>
					</table>
					<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
					<tbody>
                    <?php if(isset($stu_list)){
					$sno=1;
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						$present = 0;
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
						
							if($prec >75){
					?>
                      <tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
                    <?php }} ?>
					</tbody>
					</table>
					<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
					<tbody>
					<tr>
					<td colspan=7 style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Condonation (Between 65% - 75%)</td>
					</tr>
					</tbody>
					</table>
					<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
					<tbody>
					<?php
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						$present = 0;
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
					if($prec >= 64 && $prec < 76){ ?>
						<tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
					<?php }} ?>
					</tbody>
					</table>
					<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
					<tbody>
					<tr>
					<td colspan=7 style="font-weight:bold;font-size:16px;background-color:#E1BB49;">Eligible (Between 50% - 65%)</td>
					</tr>
					</tbody>
					</table>
					<table  style="width:100%;" border=1 cellpadding=5 cellspacing=0>
					<tbody>
					<?php
					foreach ($stu_list as $student) {
						$prec = '';
						$get1 = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance');
						$get = $get1->result();
						$total = $get1->num_rows();
						$present = 0;
						if(sizeof($get) > 0){
						$present = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->where('batch_year',$batch1)->where('main_id',$stream)->where('course_id',$department)->where('attndnce_status',1)->where('(att_date BETWEEN "'.$from_date1.'" AND "'.$to_date1.'")')->get('erp_stu_attendance')->num_rows();
						$prec = ($present/$total)*100;
						}else{$prec = 0;}
						$absent = $total-$present;
						$prec = round($prec,0);
					if($prec >= 49 && $prec < 66){ ?>
					<tr>
                        <td width="5%"><?=$sno++?></td>
                        <td width="30%"><?=$student->student_name_?></td>
						<td width="10%"><?=$student->reg_no_?></td>
						<td width="8%"><?=$absent?></td>
						<td width="8%"><?=$present?></td>
						<td width="8%"><?=$total?></td>
						<td width="8%"><?=$prec?></td>
                    </tr>
					<?php }} ?>
					</tbody>
					</table>
					<?php } ?>
                 
               
                </tbody>
            </table>
			
			
			
            </div>
          </div>
        </div>
      </div>


	
	<!--Start footer-->
	<!--<footer class="footer">
      <div class="container">
        <div class="text-right" style="float:right;">
          <p style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Generated by iStudio Technologies</p>
        </div>
      </div>
    </footer>-->
	<!--End footer-->
   
  </div><!--End wrapper-->

</body>
</html>
