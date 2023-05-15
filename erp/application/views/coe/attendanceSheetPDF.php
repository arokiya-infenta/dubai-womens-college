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
  font-size:12px;
}
.table1 {
  text-align: center;
  font-size:12px;
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
			<?php if($sem==1 || $sem==3 || $sem==5){$month='NOVEMBER';}
			      if($sem==2 || $sem==4 || $sem==6){$month='APRIL';} ?>
			<!--<p style="font-weight:bold;font-size:16px;" align="center">END SEMESTER EXAMINATION - <?=$month .' '. $batch?></p>-->
			<p style="font-weight:bold;font-size:16px;" align="center">END SEMESTER EXAMINATION - <?=$month .' '. date('Y')?></p>
			</td>
			<td></td>
			</table>
			<hr>
			<table style="width:100%;" cellpadding=0 cellspacing=0>
			<tr>
			<td style="float:middle;">
		<?php $dept = $this->db->where('main_id',$exam_sched->main_id)->where('cour_id',$exam_sched->course_id)->get('department_details')->row(); ?>
			<p style="font-weight:bold;font-size:15px;" align="center"><?=$dept->comp_name?></p>
			<p style="font-weight:bold;font-size:15px;" align="center">ATTENDANCE SHEET</p>
			</td>
			</tr>
			</table>
			
		  </div>
            <div class="card-body">
			
			<br/>
			<table style="width:100%;margin-top:-20px;" cellpadding=5 cellspacing=0>
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
			<tr>
			<td style="font-weight:bold;font-size:13px;float:left;">SUBJECT: <?=$subject_name?></td>
			<td style="font-weight:bold;font-size:13px;float:left;">DATE OF EXAMINATION: <?=date('d-m-Y',strtotime($exam_sched->schedule_date))?></td>
			</tr>
			<tr>
			<td style="font-weight:bold;font-size:13px;float:left;">SUBJECT CODE: <?=$subject_code?></td>
			<td style="font-weight:bold;font-size:13px;float:left;">SESSION: <?=$session?></td>
			</tr>
			<tr>
			<td style="font-weight:bold;font-size:13px;float:left;">ROOM NAME/BLOCK: <?=$room_name .'/' .$block_name?></td>
			<td></td>
			</tr>
			</table>
			
			<br/>
			<table style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr class="table">
			<th class="table">SNO</th>
			<th class="table">REGISTER NUMBER</th>
			<th class="table">NAME OF THE STUDENT</th>
			<th class="table">SEAT NUMBER</th>
			<th class="table">ANSWER BOOK NO.</th>
			<th class="table">SIGNATURE OF THE CANDIDATE</th>
			</tr>
			<?php if(isset($seat_list)){
					$sno=1;
					foreach ($seat_list as $seats) {
				$stu_list = $this->db->where('id',$seats->student_id)->get('erp_existing_students')->row();		
			$prec = '';
			$alloted_seat = '-';
			$get = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject_id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->get('erp_stu_attendance')->result();
			
			$total = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject_id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->get('erp_stu_attendance')->num_rows();
			
			if(sizeof($get) > 0){
			$present = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject_id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->where('attndnce_status',1)->get('erp_stu_attendance')->num_rows();
			$prec = ($present/$total)*100;
			}else{$prec = 0;}
			
			$seat = $this->db->where('student_id',$stu_list->id)->where('batch_year',$batch)->where('sem',$sem)->where('subject_id',$subject_id)->get('erp_seat_allocation')->row();
			if(!(isset($seat))){
			$seat = $this->db->select('a.*')->join('erp_subjectmaster s','s.id=a.subject_id')->where('a.student_id',$stu_list->id)->where('a.batch_year',$batch)->where('a.sem',$sem)->order_by('a.id','asc')->limit('1')->get('erp_seat_allocation a')->row();
			}
			
			if(isset($seat)){
			if($prec >= 75){
			$alloted_seat = $seat->seat_no;	
			}
			if($prec >= 65 && $prec <= 74){$alloted_seat = $seat->seat_no;}
			if($prec >= 51 && $prec <= 64){
			  $not_elig = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('subject_id',$subject_id)->where('student_id',$stu_list->id)->get('erp_not_eligible')->row();	
				if(isset($not_elig) && $not_elig->status == 1){
				$alloted_seat = $seat->seat_no;	
				}else{
				$alloted_seat = 'NOT ELIGIBLE';		
				}
			}
			if($prec <= 50){
				$alloted_seat = 'REDO or NOT ELIGIBLE';
			}
			}
			?>
			<tr class="table1">
			<td class="table1"><?=$sno++?></td>
			<td class="table1"><?=$stu_list->reg_no_?></td>
			<td class="table1" style="text-align:left!important;width:200px;"><?=$stu_list->student_name_?></td>
			<td class="table1"><?=$alloted_seat?></td>
			<td class="table"></td>
			<td class="table"></td>
			</tr>
			<?php }} ?>
			</table><br/><br/>
			
			<table style="width:100%" cellpadding=0 cellspacing=0>
			<tr>
			<td>
			<p class="s1" style="font-size:16px;">No. of Candidates : <?=sizeof($seat_list)?></p>
			</td>
			<td>
			<p class="s1" style="font-size:16px;">No. Present : </p>
			</td>
			<td>
			<p class="s1" style="font-size:16px;">No. Absent : </p>
			</td>
			</tr>
			</table><br/>
			
			<table style="width:100%" cellpadding=0 cellspacing=0>
			<tr>
			<td>
			<p class="s1" style="font-size:10px;font-weight:bold;">SIGNATURE OF THE INVIGILATOR </p>
			</td>
			<td>
			<p class="s1" style="font-size:10px;text-align:right;font-weight:bold;">SIGNATURE OF THE COE / ADDITIONAL COE </p>
			</td>
			<td>
			<p class="s1" style="font-size:10px;float:right;font-weight:bold;">SIGNATURE OF THE CHIEF SUPERINTENDENT </p>
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
