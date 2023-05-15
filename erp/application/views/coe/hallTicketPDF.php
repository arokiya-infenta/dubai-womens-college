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
  font-weight:normal;
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
			<td><img src="<?php echo base_url().'system/images/logo.png' ?>" style="width:100px;height:100px;"></td>
			<td style="width:500px;">
			<p style="font-weight:bold;font-size:15px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<p style="font-weight:bold;font-size:15px;" align="center">(Affiliated to the University of Madras)</p>
			<p style="font-weight:bold;font-size:15px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<?php if($sem==1 || $sem==3 || $sem==5){$month='NOVEMBER';}
			      if($sem==2 || $sem==4 || $sem==6){$month='APRIL';} ?>
			<p style="font-weight:bold;font-size:15px;" align="center">END SEMESTER EXAMINATION - <?=$month .' '. date('Y')?></p>
			<p style="font-weight:bold;font-size:15px;" align="center">HALL TICKET</p>
			</td>
			<td>
			<?php $file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->student_image .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/user.png';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->student_image;
} 
//$url = base_url().'system/images/user.png'; ?>
			<img src="<?php echo $url; ?>" style="width:100px;height:100px;">
			</td>
			</table>
			
		  </div>
            <div class="card-body">
			
			<br/>
			<table style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td style="font-size:13px;">Name:</td>
			<td style="font-weight:bold;font-size:13px;float:left;"><?=$stu_list->student_name_?></td>
			<td style="font-size:13px;">Reg.No:</td>
			<td style="font-weight:bold;font-size:13px;float:left;"><?=$stu_list->reg_no_?></td>
			<td style="font-size:13px;">Semester:</td>
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
			<td style="font-weight:bold;font-size:13px;float:left;"><?=ConverToRoman($sem)?></td>
			</tr>
			<?php $dept = $this->db->where('main_id',$stu_list->main_id)->where('cour_id',$stu_list->cour_id)->get('department_details')->row(); ?>
			<tr>
			<td style="font-size:13px;">Degree:</td>
			<!--<td style="font-weight:bold;font-size:16px;float:left;"><?=$dept->short_name?></td>-->
			<?php $degree=$dept->short_name;
			$degr = $this->db->where('dept_code_',$dept->short_name)->get('erp_department')->row();
			if(isset($degr)){$degree = $degr->tc_dept_name_;} ?>
			<td style="font-weight:bold;font-size:13px;float:left;"><?=$degree?></td>
			</tr>
			<tr>
			<td style="font-size:13px;">Department:</td>
			<td style="font-weight:bold;font-size:13px;float:left;"><?=$dept->comp_name?></td>
			</tr>
			</table>
			
			<br/>
			<table class="table" style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr class="table">
			<th class="table">SUBJECT CODE</th>
			<th class="table">SUBJECT NAME</th>
			<th class="table">DATE</th>
			<th class="table">SESSION</th>
			<th class="table">ROOM NAME</th>
			<th class="table">SEAT NO</th>
			</tr>
			<?php /*$subject = $this->db->where('batch_year',$batch)->where('stream',$stu_list->main_id)->where('department',$stu_list->cour_id)->get('erp_subjectmaster')->result();*/
			//$subject = $this->db->query('select esm.* from erp_stu_attendance em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$stu_list->id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$stu_list->id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$stu_list->id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and (((esm.part=1 OR esm.part=4 OR esm.part=2) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND esm.part!=2 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) group by em.subject_id order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
			$subject = $this->db->query('select esm.* from erp_subjectmaster esm join erp_existing_students es on es.id='.$stu_list->id.' left join erp_stu_attendance em on (em.subject_id=esm.id and em.student_id='.$stu_list->id.') left join erp_langallot l on (l.existing_student_id='.$stu_list->id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$stu_list->id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where esm.sem='.$sem.' and esm.batch_year='.$batch.' and esm.stream='.$stu_list->main_id.' and esm.department='.$stu_list->cour_id.' and esm.subNature!="PRACTICAL" and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) group by esm.id order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
			
			$year = date('Y');
			if($stu_list->main_id == 5){$curr_batch = $batch + 3; }
			else{$curr_batch = $batch + 2; }
			if($year <= $curr_batch){
				
			foreach($subject as $subject) { 
			$prec = '';
			$alloted_seat = '-';	
			$section = '-';
			$scheduled_date = '-';
			$roomname = '-';
			$get = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject->id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->get('erp_stu_attendance')->result();
			
			$total = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject->id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->get('erp_stu_attendance')->num_rows();
			
			if(sizeof($get) > 0){
			$present = $this->db->where('student_id',$stu_list->id)->where('subject_id',$subject->id)->where('sem',$sem)->where('batch_year',$batch)->where('main_id',$stu_list->main_id)->where('course_id',$stu_list->cour_id)->where('attndnce_status',1)->get('erp_stu_attendance')->num_rows();
			$prec = ($present/$total)*100;
			}else{$prec = 0;}
			
			$seat = $this->db->where('student_id',$stu_list->id)->where('batch_year',$batch)->where('sem',$sem)->where('subject_id',$subject->id)->get('erp_seat_allocation')->row();
			if(!(isset($seat))){
			$seat = $this->db->select('a.*')->join('erp_subjectmaster s','s.id=a.subject_id')->where('a.student_id',$stu_list->id)->where('a.batch_year',$batch)->where('a.sem',$sem)->order_by('a.id','asc')->limit('1')->get('erp_seat_allocation a')->row();
			}
			
			$sched = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('subject_id',$subject->id)->get('erp_exam_schedule')->row();
			if(isset($sched)){
				$scheduled_date = date('d-m-Y', strtotime($sched->schedule_date));
				$section = $sched->section;
			}
			
			if(isset($seat)){
			if($prec >= 75){
			$alloted_seat = $seat->seat_no;	
			$room = $this->db->where('id',$seat->room_id)->get('erp_rooms')->row();
			$roomname = $room->room_name;
			}
			if($prec >= 65 && $prec < 75){
			$cond_elig = $this->db->where('batch',$batch)->where('semester',$sem)->where('(find_in_set("'.$subject->id.'", subject_id) <> 0)')->where('add_student_id',$stu_list->id)->limit('1')->get('condanation_fee_transaction')->row();
				if(isset($cond_elig) && $cond_elig->paid_status == 1){
				$alloted_seat = $seat->seat_no;	
			    $room = $this->db->where('id',$seat->room_id)->get('erp_rooms')->row();
			    $roomname = $room->room_name;	
				}
			}
			//if($prec >= 51 && $prec < 64){
			if($prec < 65){
			  $not_elig = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('subject_id',$subject->id)->where('student_id',$stu_list->id)->get('erp_not_eligible')->row();
				if(isset($not_elig) && $not_elig->status == 1){
				$alloted_seat = $seat->seat_no;	
			    $room = $this->db->where('id',$seat->room_id)->get('erp_rooms')->row();
			    $roomname = $room->room_name;	
				}
			}
			}
			
			?>
			<tr class="table1">
			<td class="table1"><?=$prec?></td>
			<td class="table1" style="text-align:left!important;"><?=$subject->subName?></td>
			<td class="table1" style="width:65px!important;"><?=$scheduled_date?></td>
			<td class="table1"><?=$section?></td>
			<td class="table1"><?=$roomname?></td>
			<td class="table1"><?=$alloted_seat?></td>
			</tr>
			<?php }} ?>
			<?php $arrear_paid = $this->db->where('applied_year',$year)->where('applied_sem',$sem)->where('student_id',$stu_list->id)->where('result_status','fail')->get('erp_arrear_detail')->result();
			foreach($arrear_paid as $arrear_subjects){
			$subject1 = $this->db->where('batch_year',$arrear_subjects->student_batch)->where('subCode',$arrear_subjects->subject_code)->where('stream',$stu_list->main_id)->where('department',$stu_list->cour_id)->get('erp_subjectmaster')->row();
			$arrear_sched = $this->db->select('es.*')->join('erp_exam_schedule es', 'es.subject_id=sm.id')->where('sm.batch_year',$batch)->where('sm.subCode',$arrear_subjects->subject_code)->get('erp_subjectmaster sm')->row();
			$scheduled_date_arrear='';
			$section_arrear='';
			$roomname_arrear='';
			$alloted_seat_arrear='';
			
			if(isset($arrear_sched)){
			$scheduled_date_arrear = date('d-m-Y', strtotime($arrear_sched->schedule_date));
			$section_arrear = $arrear_sched->section;
			}
			
			$arrear_seat = $this->db->where('applied_year',$year)->where('student_id',$stu_list->id)->where('subject_id',$arrear_subjects->subject_id)->get('erp_rows_cols_arrear')->row();
			
			if(isset($arrear_seat)){
				$room1 = $this->db->where('id',$arrear_seat->room_id)->get('erp_rooms')->row();
			$roomname_arrear = $room1->room_name;
			$alloted_seat_arrear = $arrear_seat->seat_no;
			}
			
				?>
			<tr class="table1">
			<td class="table1"><?=$subject1->subCode?></td>
			<td class="table1" style="text-align:left!important;"><?=$subject1->subName?></td>
			<td class="table1"><?=$scheduled_date_arrear?></td>
			<td class="table1"><?=$section_arrear?></td>
			<td class="table1"><?=$roomname_arrear?></td>
			<td class="table1"><?=$alloted_seat_arrear?></td>
			</tr>
			<?php } ?>
			</table>
			
			<table style="width:100%" cellpadding=0 cellspacing=0>
			<tr>
			<td>
			<p class="s1" style="font-size:13px;float:left;">Forenoon Session : <b>10.00 AM To 1.10 PM</b></p>
			</td>
			<td>
			<p class="s1" style="font-size:13px;float:left;">Afternoon Session : <b>2.00 PM To 5.10 PM</b></p>
			</td>
			</tr>
			</table>
			
			<br/><br/><br/>
			<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<p style="font-size:13px;">Signature of the Candidate<br/>
			(at the time of receiving the Hall Ticket)</p>
			<p>
			<span style="font-size:15px;font-weight:bold;">Note: Kindly Check the Exam Date with the Time Table</span></p>
			</td>
			<td><p>      
			<span><img src="<?=base_url().'system/images/coe-sign.jpg'?>" style="width:170px;height:50px;margin-top:-25px;"></span></p>
			<p>     
			<span class="h2" style="font-size:15px;font-weight:bold;">Controller of Examinations</span></p>
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
