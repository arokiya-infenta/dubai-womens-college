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
#table p{
	text-align: center;
	font-weight:bold;
	font-size:16px;
            }	
#table1 td{
	border: 1px solid #D6D2CC;
	border-width: thin;
	border-bottom: none;
	text-align: center;
	font-size:12px;
            }
#table2 td{
	border: 1px solid #D6D2CC;
	border-width: thin;
	border-collapse: collapse;
	text-align: center;
	font-size:12px;
            }
#table3 td{
	border: 1px solid;
	text-align: center;
	font-size:12px;
	font-weight:bold;
            }
#table4 td{
	border: 1px solid;
	font-weight:bold;
    font-size:12px;
	text-align:left;
            }			
			
.table1 {
  font-weight:bold;
  font-size:12px;
}		
.table2 {
  font-weight:bold;
  font-size:9px!important;
  text-transform:uppercase;
}	
</style>
<body>

<div id="wrapper">
			
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  
		  <table id="table" style="width:100%;" border=0 cellpadding=0 cellspacing=0>
			<td style="width:1px;"></td>
			<td style="width:630px;"><br/>
			<?php $main = $stu_list[0]->main_id; $course = $stu_list[0]->course_id;
			if($main==1 && ($course==5||$course==6||$course==7||$course==8)){$deg = 'M.A POST GRADUATE';}
			if(($main==1 && $course==15) || $main==2 || $main==3){$deg = 'M.S.W POST GRADUATE';}
			if($main==1 && ($course==9 || $course==16)){$deg = 'M.SC POST GRADUATE';}
			if($main==5 && $course==1){$deg = 'B.S.W UNDERGRADUATE';}
			if($main==5 && $course==2){$deg = 'B.SC UNDERGRADUATE';}
			?>
			<p><?=$deg?> DEGREE EXAMINATION</p>
			</td>
			<td>
			<?php 
$file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list[0]->student_image .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/user.png';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list[0]->student_image;
}  //$url = base_url().'system/images/user.png';?>
			<img src="<?php echo $url; ?>" style="width:80px;height:80px;float:right;">
			</td>
			</table>
			
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
<?php if(sizeof($stu_list) > 0){ ?>
			<table id="table1" style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td class="table1" style="text-align:left;">NAME OF THE CANDIDATE</td>
			<td class="table1">REGISTER NO.</td>
			<td class="table1">SEX</td>
			<td class="table1">DATE OF BIRTH</td>
			</tr>
			<tr>
			<td style="text-transform:uppercase;text-align:left;"><?=$stu_list[0]->student_name_?></td>
			<td><?=$stu_list[0]->reg_no_?></td>
			<td><?=$stu_list[0]->gender_?></td>
			<td><?=date('d-m-Y',strtotime($stu_list[0]->dob_))?></td>
			</tr>
			<?php
		if($stu_list[0]->admitted_by==1){	
			if($stu_list[0]->main_id==5){
		$stu_det = $this->db->where('pr_user_id',$student_id)->get('new_preview')->row();
		}elseif($stu_list[0]->main_id==4){
		$stu_det = $this->db->where('pr_user_id',$student_id)->get('new_preview_dip')->row();	
		}else{	
		$stu_det = $this->db->where('pr_user_id',$student_id)->get('new_preview_pg')->row();
		}
		if($stu_det->pr_father_name != null){$parent_name=$stu_det->pr_father_name;}else{$parent_name=$stu_det->pr_gaurdion_name;}
		}else{
		$parent_name=$stu_list[0]->father_name_;
		}
		//$dept=$this->db->where('dept_code_',$stu_list[0]->short_name)->get('erp_department')->row();
		$dept=$this->db->where('main_id',$stu_list[0]->main_id)->where('cour_id',$stu_list[0]->course_id)->get('department_details')->row();
		if(($stu_list[0]->batch_year<=2021) && (($main==1 && $course==15) || $main==2 || $main==3)){$specialization = 'MSW';}
		else{$specialization = $dept->specialization;}
		if($sem==1 || $sem==3 || $sem==5){$month='NOV';}
		if($sem==2 || $sem==4 || $sem==6){$month='APR';}
		?>
			<tr>
			<td class="table1" style="text-align:left;">PARENT/GUARDIAN'S NAME</td>
			<td class="table1" colspan=2>BRANCH/SPECIALIZATION NAME</td>
			<td class="table1">MONTH/YEAR</td>
			</tr>
			<tr>
			<td style="text-transform:uppercase;text-align:left;"><?=$parent_name?></td>
			<td style="text-transform:uppercase;" colspan=2><?=$specialization?></td>
			<td><?=$month.'-'.date('Y')?></td>
			</tr>
			</table>
<?php } ?>
			
			<table id="table2" style="width:100%;" cellspacing=0>
			<tr style="font-weight:bold;">
			<td class="table2">Sem</td>
			<td class="table2">Course Code</td>
			<td class="table2">Course Title</td>
			<td class="table2">Credit</td>
			<td class="table2">ICA</td>
			<td class="table2">ESE</td>
			<td class="table2">Total</td>
			<td class="table2">L.G.</td>
			<td class="table2">G.P.</td>
			<td class="table2">Passed In</td>
			</tr>
			<?php 
			$ax1 = 0; $part1 = 0; $all_credits1 = 0;
			foreach($stu_list as $stulist){ 
			$subj=$this->db->where('id',$stulist->subject_id)->get('erp_subjectmaster')->row();
			$total=0;
			$lg='AAA';
			$gp=0.0;
			if($stulist->moderate_status==1){$ese=$stulist->moderated_mark;}else{$ese=$stulist->average;}
			if($ese!=''){$ese=round($ese,0);}
			$ica=$stulist->ica;
			if($ica!='A' && $ica!=''){$ica=round($ica,0);}
			if($ica!='A' && $ica!='' && $ese!=''){
			$total=(int)$ica + (int)$ese;}
			//$gp=substr_replace($total, '.', -1, 0);
			if(($subj->subCode=='MDE/21C/306' || $subj->subCode=='MS/20C/306') && (($main==1 && $course==15) || $main==2 || $main==3)){$total=$total*2;}
			$gp=$total*0.1;
			if($total >= 90 && $total <= 100){$lg='O';}
			if($total >= 80 && $total <= 89){$lg='D+';}
			if($total >= 75 && $total <= 79){$lg='D';}
			if($total >= 70 && $total <= 74){$lg='A+';}
			if($total >= 60 && $total <= 69){$lg='A';}
			if($total >= 50 && $total <= 59){$lg='B';}
			if($stulist->main_id==5){
			if($total >= 40 && $total <= 49){$lg='C';}
			if($total >= 00 && $total <= 39){$lg='U';}
			}else{
			if($total >= 00 && $total <= 49){$lg='U';}	
			}
			$ax1 += ($subj->creditPnt)*$gp;
			$all_credits1 += ($subj->creditPnt);
			if($all_credits1 != 0){$part1 = $ax1/$all_credits1;}
			
			if($stulist->arrear_status == 1){
			$sem_p = $stulist->arrear_applied_sem;
			if($sem_p==1 || $sem_p==3 || $sem_p==5){$month_p='APR';}
		    if($sem_p==2 || $sem_p==4 || $sem_p==6){$month_p='NOV';}
			$passed_in = $month_p .'-'. $stulist->arrear_applied_year;
			}else{
			$sem_p = $stulist->sem;
			if($sem_p==1 || $sem_p==3 || $sem_p==5){$month_p='APR';}
		    if($sem_p==2 || $sem_p==4 || $sem_p==6){$month_p='NOV';}	
			$passed_in = $month_p .'-'. date('Y', strtotime($stulist->created_at));
			}
			$sem_e = 1;
			if(($subj->subCode=='MDE/21C/306' || $subj->subCode=='MS/20C/306') && (($main==1 && $course==15) || $main==2 || $main==3)){$ica=$ica.'/25';$ese=$ese.'/25';$total=($total/2).'/50';}
			
			if($stulist->arrear_status==1){$written_sem=$stulist->arrear_applied_sem;}else{$written_sem=$subj->sem;}
			?>
			<tr>
			<td><?=$written_sem?></td>
			<td><?=$subj->subCode?></td>
			<td style="text-align:left;"><?=$subj->subName?></td>
			<td><?=$subj->creditPnt?></td>
			<td><?=$ica?></td>
			<td><?=$ese?></td>
			<td><?=$total?></td>
			<td><?=$lg?></td>
			<td><?=$gp?></td>
			<td><?=$passed_in?></td>
			</tr>
			<?php 
			if($sem_e != $subj->sem){ 
			//$elective = $this->db->select('s.*')->join('admitted_student as','as.as_id=l.existing_student_id')->join('erp_existing_students es','es.student_id=as.as_student_id')->join('erp_subjectmaster s','s.id=l.subject_id')->where('l.batch',$stu_list[0]->batch_year)->where('l.sem',$sem_e)->where('l.status',1)->where('es.id',$student_id)->get('erp_langallot l')->result();
			$elective = $this->db->select('s.*')->join('erp_subjectmaster s','s.id=p.subject_id')->where('p.batch',$stu_list[0]->batch_year)->where('p.sem',$sem_e)->where('p.status',1)->where('p.student_id',$student_id)->order_by('(SUBSTRING_INDEX(s.subCode, "/",-1)) asc')->get('erp_partvmark p')->result();
			foreach($elective as $elect){
			?>
			<tr>
			<td><?=$elect->sem?></td>
			<td><?=$elect->subCode?></td>
			<td style="text-align:left;"><?=$elect->subName?></td>
			<td><?=$elect->creditPnt?></td>
			<td>-</td>
			<td>NA</td>
			<td colspan=3>COMPLETED</td>
			<td>PASS</td>
			</tr>
			<?php }$sem_e += 1;} ?>
			<?php 
			$cert_course = $this->db->select('s.*')->join('erp_subjectmaster s','s.id=c.subject_id')->where('c.status',1)->where('c.student_id',$student_id)->order_by('(SUBSTRING_INDEX(s.subCode, "/",-1)) asc')->get('erp_cert_coursemark c')->result();
			foreach($cert_course as $cert){
			?>
			<tr>
			<td>-</td>
			<td><?=$cert->subCode?></td>
			<td style="text-align:left;"><?=$cert->subName?></td>
			<td>-</td>
			<td>-</td>
			<td>NA</td>
			<td colspan=3>COMPLETED</td>
			<td>PASS</td>
			</tr>
			<?php } ?>
			<?php } ?>
			</table>
			
			<br/>
			<?php if(sizeof($stu_list) > 0){ ?>
			<table id="table3" style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td>OWPM</td>
			<td>CGPA</td>
			<td>OVERALL RESULT</td>
			<td>CLASS</td>
			<td>MIN.CREDITS**</td>
			<td>TOTAL CREDITS</td>
			</tr>
			<?php $arrear_history = $this->db->where('student_id',$stu_list[0]->student_id)->where('(result="R(I + E)" OR result="R(I)" OR result="R(E)")')->get('erp_exammarkfinal')->row(); 
			$grade1='';$final_res1='NA';
			if($part1 >= 9.5 && $part1 < 10.0){$grade1='O+';$final_res1='First Class - Exempiary*';}
			if($part1 >= 9.0 && $part1 < 9.5){$grade1='O';$final_res1='First Class - Exempiary*';}
			if($part1 >= 8.5 && $part1 < 9.0){$grade1='D++';$final_res1='First Class - Exempiary*';}
			if(!isset($arrear_history)){
			if($part1 >= 8.0 && $part1 < 8.5){$grade1='D+';$final_res1='First Class with Distinction*';}
			if($part1 >= 7.5 && $part1 < 8.0){$grade1='D';$final_res1='First Class with Distinction*';}
			}else{
			if($part1 >= 8.0 && $part1 < 8.5){$grade1='D+';$final_res1='First Class';}
			if($part1 >= 7.5 && $part1 < 8.0){$grade1='D';$final_res1='First Class';}	
			}
			if($part1 >= 7.0 && $part1 < 7.5){$grade1='A++';$final_res1='First Class';}
			if($part1 >= 6.5 && $part1 < 7.0){$grade1='A+';$final_res1='First Class';}
			if($part1 >= 6.0 && $part1 < 6.5){$grade1='A';$final_res1='First Class';}
			if($part1 >= 5.5 && $part1 < 6.0){$grade1='B+';$final_res1='Second Class';}
			if($part1 >= 5.0 && $part1 < 5.5){$grade1='B';$final_res1='Second Class';}
			if($stu_list[0]->main_id==5){
				if($part1 >= 4.0 && $part1 < 5.0){$grade1='C';$final_res1='Third Class';}
				if($part1 >= 0.0 && $part1 < 4.0){$grade1='U';$final_res1='Re-appear';}
			}else{
				if($part1 >= 0.0 && $part1 < 5.0){$grade1='U';$final_res1='Re-appear';}
			}
			?>
			<tr>
			<td><?=(float)$part1*10?></td>
			<td><?=$part1?></td>
			<td>PASS</td>
			<td><?=$final_res1?></td>
			<td>90</td>
			<td><?=$all_credits1?></td>
			</tr>
			</table>
			<?php } ?>
			
			<table id="table4" style="width:100%" cellspacing=0 cellpadding=5>
			<tr>
			<td>NOTE: MIN.CREDITS** - Minimum Credits Required | NA - Not Applicable | OWPM - Overall Weighted Percentage Marks</td>
			</tr>
			<tr>
			<td>Date: <?=date('d/F/Y');?></td>
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
