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
	border: 1px solid black;
	border-width: thin;
	border-bottom: none;
	text-align: center;
	font-size:12px;
            }	
#table2 td{
	border: 1px solid black;
	border-width: thin;
	border-collapse: collapse;
	text-align: center;
	font-size:12px;
            }
#table3 td{
	border-collapse: collapse;
	text-align: center;
	font-size:12px;
            }
#table4 span{
	font-weight:bold;
    font-size:11px;
            }			
			
.table1 {
  font-weight:bold;
  font-size:12px;
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
			<td style="width:630px;">
			<p>DRAFT MARK SHEET</p>
			<p>M.A POST GRADUATE DEGREE EXAMINATION</p>
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
<?php if(sizeof($stu_list)>0){ ?>
<?php
    $CI =& get_instance();
?>
			<table id="table1" style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td class="table1" style="text-align:left;">NAME OF THE CANDIDATE</td>
			<td class="table1">REGISTER NO.</td>
			<td class="table1">SEX</td>
			<td class="table1">DATE OF BIRTH</td>
			<td class="table1">SEMESTER</td>
			</tr>
			<tr>
			<td style="text-transform:uppercase;text-align:left;"><?=$stu_list[0]->student_name_?></td>
			<td><?=$stu_list[0]->reg_no_?></td>
			<td><?=$stu_list[0]->gender_?></td>
			<td><?=date('d-m-Y',strtotime($stu_list[0]->dob_))?></td>
			<td><?=$CI->ConverToRoman($sem)?></td>
			</tr>
			<?php
		if($stu_list[0]->admitted_by==1){	
			if($stu_list[0]->main_id==5){
		$stu_det = $this->db->where('pr_user_id',$stu_list[0]->student_id)->get('new_preview')->row();
		}elseif($stu_list[0]->main_id==4){
		$stu_det = $this->db->where('pr_user_id',$stu_list[0]->student_id)->get('new_preview_dip')->row();	
		}else{	
		$stu_det = $this->db->where('pr_user_id',$stu_list[0]->student_id)->get('new_preview_pg')->row();
		}
		if($stu_det->pr_father_name != null){$parent_name=$stu_det->pr_father_name;}else{$parent_name=$stu_det->pr_gaurdion_name;}
		}else{
		$parent_name=$stu_list[0]->father_name_;
		}
		//$dept=$this->db->where('dept_code_',$stu_list[0]->short_name)->get('erp_department')->row();
		$dept=$this->db->where('main_id',$stu_list[0]->main_id)->where('cour_id',$stu_list[0]->course_id)->get('department_details')->row();
		if($sem==1 || $sem==3 || $sem==5){$month='NOV';}
		if($sem==2 || $sem==4 || $sem==6){$month='APR';}
		?>
			<tr>
			<td class="table1" style="text-align:left;">PARENT/GUARDIAN'S NAME</td>
			<td class="table1" colspan=3>BRANCH/SPECIALIZATION NAME</td>
			<td class="table1">MONTH/YEAR</td>
			</tr>
			<tr>
			<td style="text-transform:uppercase;text-align:left;"><?=$parent_name?></td>
			<td colspan=3><?=$dept->specialization?></td>
			<td><?=$month.'-'.date('Y')?></td>
			</tr>
			</table>
<?php } ?>
			
			<table id="table2" style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td style="text-transform:uppercase;">Sem</td>
			<td style="text-transform:uppercase;">Course Code</td>
			<td style="text-transform:uppercase;">Course Title</td>
			<td style="text-transform:uppercase;">Part</td>
			<td style="text-transform:uppercase;">Credit</td>
			<td style="text-transform:uppercase;">ICA Max50</td>
			<td style="text-transform:uppercase;">ESE Max50</td>
			<td style="text-transform:uppercase;">Total Max100</td>
			<td style="text-transform:uppercase;">L.G.</td>
			<td style="text-transform:uppercase;">G.P.</td>
			<td style="text-transform:uppercase;">Result</td>
			</tr>
			<?php 
			$ax1 = 0; $part1 = 0; $all_credits1 = 0; $prt_cnt1 = 0;
			$ax2 = 0; $part2 = 0; $all_credits2 = 0; $prt_cnt2 = 0;
			$ax3 = 0; $part3 = 0; $all_credits3 = 0; $prt_cnt3 = 0;
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
			if(($ica=='A' || $ica=='') && $ese!=''){
			$total=$ese;}
			//$gp=substr_replace($total, '.', -1, 0);
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
			if($subj->part == 1){
			$ax1 += ($subj->creditPnt)*$gp;
			$all_credits1 += ($subj->creditPnt);
			$prt_cnt1 += 1;
			}
			if($subj->part == 2){
			$ax2 += ($subj->creditPnt)*$gp;
			$all_credits2 += ($subj->creditPnt);
			$prt_cnt2 += 1;
			}
			if($subj->part == 3){
			$ax3 += ($subj->creditPnt)*$gp;
			$all_credits3 += ($subj->creditPnt);
			$prt_cnt3 += 1;
			}
			if($all_credits1 != 0){$part1 = $ax1/$all_credits1;}
			if($all_credits2 != 0){$part2 = $ax2/$all_credits2;}
			if($all_credits3 != 0){$part3 = $ax3/$all_credits3;}
			$result = $stulist->result;
			if($result=='P'){$result='PASS';}
			elseif($result=='R(I)'){$result='RA-I';}
			elseif($result=='R(E)'){$result='RA-E';}
			elseif($result=='R(I + E)'){$result='RA-I&E';}
			?>
			<tr>
			<td><?=$subj->sem?></td>
			<td><?=$subj->subCode?></td>
			<td style="text-align:left;"><?=$subj->subName?></td>
			<td><?=$CI->ConverToRoman($subj->part)?></td>
			<td><?=$subj->creditPnt?></td>
			<td><?=$ica?></td>
			<td><?=$ese?></td>
			<td><?=$total?></td>
			<td><?=$lg?></td>
			<td><?=$gp?></td>
			<td><?=$result?></td>
			</tr>
			<?php } ?>
			<?php 
			//$elective = $this->db->select('s.*')->join('erp_subjectmaster s','s.id=l.subject_id')->where('l.batch',$stu_list[0]->batch_year)->where('l.sem',$subj->sem)->where('l.status',1)->where('l.existing_student_id',$student_id)->get('erp_langallot l')->result();
			//foreach($elective as $elect){
			?>
			<!--<tr>
			<td><?=$CI->ConverToRoman($subj->sem)?></td>
			<td><?=$elect->subCode?></td>
			<td><?=$elect->subName?></td>
			<td><?=$elect->part?></td>
			<td><?=$elect->creditPnt?></td>
			<td colspan=6>COMPLETED</td>
			</tr>-->
			<?php //} ?>
			<?php 
			$partv = $this->db->select('s.*')->join('erp_subjectmaster s','s.id=p.subject_id')->where('p.batch',$stu_list[0]->batch_year)->where('p.sem',$subj->sem)->where('p.status',1)->where('p.student_id',$student_id)->order_by('(SUBSTRING_INDEX(s.subCode, "/",-1)) asc')->get('erp_partvmark p')->result();
			foreach($partv as $prtv){
			?>
			<tr>
			<td><?=$subj->sem?></td>
			<td><?=$prtv->subCode?></td>
			<td style="text-align:left;"><?=$prtv->subName?></td>
			<td><?=$CI->ConverToRoman($prtv->part)?></td>
			<td><?=$prtv->creditPnt?></td>
			<td>-</td>
			<td>NA</td>
			<td colspan=3>COMPLETED</td>
			<td>PASS</td>
			</tr>
			<?php } ?>
			<?php 
		
		$arrear = $this->db->where('student_id',$student_id)->where('student_batch',$batch)->where('sem',$sem)->where('applied_year',date('Y'))->where('result_status','fail')->get('erp_arrear_detail')->result();
		foreach($arrear as $arear){
		 $stulist1 = $this->db->where('student_id',$student_id)->where('batch_year',$batch)->where('sem',$sem)->where('arrear_status',1)->where('subject_id',$arear->subject_id)->get('erp_exammarkfinal')->row(); 	
			$subj1=$this->db->where('id',$stulist1->subject_id)->get('erp_subjectmaster')->row();
			$total1=0;
			$lg1='AAA';
			$gp1=0.0;
			if($stulist1->moderate_status==1){$ese1=$stulist1->moderated_mark;}else{$ese1=$stulist1->average;}
			if($ese1!=''){$ese1=round($ese1,0);}
			$ica1=$stulist1->ica;
			if($ica1!='A' && $ica1!=''){$ica1=round($ica1,0);}
			if($ica1!='A' && $ica1!='' && $ese1!=''){
			$total1=(int)$ica1 + (int)$ese1;}
			$gp=substr_replace($total1, '.', -1, 0);
			if($total1 >= 90 && $total1 <= 100){$lg1='O';}
			if($total1 >= 80 && $total1 <= 89){$lg1='D+';}
			if($total1 >= 75 && $total1 <= 79){$lg1='D';}
			if($total1 >= 70 && $total1 <= 74){$lg1='A+';}
			if($total1 >= 60 && $total1 <= 69){$lg1='A';}
			if($total1 >= 50 && $total1 <= 59){$lg1='B';}
			if($stulist1->main_id==5){
			if($total1 >= 40 && $total1 <= 49){$lg1='C';}
			if($total1 >= 00 && $total1 <= 39){$lg1='U';}
			}else{
			if($total1 >= 00 && $total1 <= 49){$lg1='U';}	
			}
			$result1 = $stulist1->result;
			if($result1=='P'){$result1='PASS';}
			elseif($result1=='R(I)'){$result1='RA-I';}
			elseif($result1=='R(E)'){$result1='RA-E';}
			elseif($result1=='R(I + E)'){$result1='RA-I&E';}
		?>
		<tr>
			<td><?=$subj1->sem?></td>
			<td><?=$subj1->subCode?></td>
			<td><?=$subj1->subName?></td>
			<td><?=$CI->ConverToRoman($subj1->part)?></td>
			<td><?=$subj1->creditPnt?></td>
			<td><?=$ica1?></td>
			<td><?=$ese1?></td>
			<td><?=$total1?></td>
			<td><?=$lg1?></td>
			<td><?=$gp1?></td>
			<td><?=$result1?></td>
			</tr>
		<?php } ?>
			<tr>
			<td colspan="11">**End of Statement**</td>
			</tr>
			</table>
			
			<br/>
			<?php if(sizeof($stu_list)>0){ ?>
			<table id="table3" style="width:100%;" cellpadding=5 cellspacing=0>
			<tr>
			<td>SEMESTER WISE RESULT</td>
			<td>PART-I</td>
			<td>PART-II</td>
			<td>PART-III</td>
			<td>PART-IV</td>
			<td>PART-V</td>
			</tr>
			<?php $arrear_history = $this->db->where('student_id',$student_id)->where('result="R(I + E)" OR result="R(I)" OR result="R(E)"')->get('erp_exammarkfinal')->row(); 
			$grade1='';$final_res1='NA';
			$grade2='';$final_res2='NA';
			$grade3='';$final_res3='NA';
			if($prt_cnt1 != 0){
			if($part1 >= 9.5 && $part1 < 10.0){$grade1='O+';$final_res1='First Class - Exempiary*';}
			if($part1 >= 9.0 && $part1 < 9.5){$grade1='O';$final_res1='First Class - Exempiary*';}
			if($part1 >= 8.5 && $part1 < 9.0){$grade1='D++';$final_res1='First Class - Exempiary*';}
			if(isset($arrear_history)){
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
			}
			
			if($prt_cnt2 != 0){
			if($part2 >= 9.5 && $part2 < 10.0){$grade2='O+';$final_res2='First Class - Exempiary*';}
			if($part2 >= 9.0 && $part2 < 9.5){$grade2='O';$final_res2='First Class - Exempiary*';}
			if($part2 >= 8.5 && $part2 < 9.0){$grade2='D++';$final_res2='First Class - Exempiary*';}
			if(isset($arrear_history)){
			if($part2 >= 8.0 && $part2 < 8.5){$grade2='D+';$final_res2='First Class with Distinction*';}
			if($part2 >= 7.5 && $part2 < 8.0){$grade2='D';$final_res2='First Class with Distinction*';}
			}else{
			if($part2 >= 8.0 && $part2 < 8.5){$grade2='D+';$final_res2='First Class';}
			if($part2 >= 7.5 && $part2 < 8.0){$grade2='D';$final_res2='First Class';}	
			}
			if($part2 >= 7.0 && $part2 < 7.5){$grade2='A++';$final_res2='First Class';}
			if($part2 >= 6.5 && $part2 < 7.0){$grade2='A+';$final_res2='First Class';}
			if($part2 >= 6.0 && $part2 < 6.5){$grade2='A';$final_res2='First Class';}
			if($part2 >= 5.5 && $part2 < 6.0){$grade2='B+';$final_res2='Second Class';}
			if($part2 >= 5.0 && $part2 < 5.5){$grade2='B';$final_res2='Second Class';}
			if($stu_list[0]->main_id==5){
				if($part2 >= 4.0 && $part2 < 5.0){$grade2='C';$final_res2='Third Class';}
				if($part2 >= 0.0 && $part2 < 4.0){$grade2='U';$final_res2='Re-appear';}
			}else{
				if($part2 >= 0.0 && $part2 < 5.0){$grade2='U';$final_res2='Re-appear';}
			}
			}
			
			if($prt_cnt3 != 0){
			if($part3 >= 9.5 && $part3 < 10.0){$grade3='O+';$final_res3='First Class - Exempiary*';}
			if($part3 >= 9.0 && $part3 < 9.5){$grade3='O';$final_res3='First Class - Exempiary*';}
			if($part3 >= 8.5 && $part3 < 9.0){$grade3='D++';$final_res3='First Class - Exempiary*';}
			if(isset($arrear_history)){
			if($part3 >= 8.0 && $part3 < 8.5){$grade3='D+';$final_res3='First Class with Distinction*';}
			if($part3 >= 7.5 && $part3 < 8.0){$grade3='D';$final_res3='First Class with Distinction*';}
			}else{
			if($part3 >= 8.0 && $part3 < 8.5){$grade3='D+';$final_res3='First Class';}
			if($part3 >= 7.5 && $part3 < 8.0){$grade3='D';$final_res3='First Class';}	
			}
			if($part3 >= 7.0 && $part3 < 7.5){$grade3='A++';$final_res3='First Class';}
			if($part3 >= 6.5 && $part3 < 7.0){$grade3='A+';$final_res3='First Class';}
			if($part3 >= 6.0 && $part3 < 6.5){$grade3='A';$final_res3='First Class';}
			if($part3 >= 5.5 && $part3 < 6.0){$grade3='B+';$final_res3='Second Class';}
			if($part3 >= 5.0 && $part3 < 5.5){$grade3='B';$final_res3='Second Class';}
			if($stu_list[0]->main_id==5){
				if($part3 >= 4.0 && $part3 < 5.0){$grade3='C';$final_res3='Third Class';}
				if($part3 >= 0.0 && $part3 < 4.0){$grade3='U';$final_res3='Re-appear';}
			}else{
				if($part3 >= 0.0 && $part3 < 5.0){$grade3='U';$final_res3='Re-appear';}
			}
			}
			?>
			<tr>
			<td><?=$CI->ConverToRoman($sem)?></td>
			<td><?=$final_res1?><br\><?php if($part1!=0){echo round($part1,1);}?></td>
			<td><?=$final_res2?><br\><?php if($part2!=0){echo round($part2,1);}?></td>
			<td><?=$final_res3?><br\><?php if($part3!=0){echo round($part3,1);}?></td>
			<td>NA</td>
			<td>NA</td>
			</tr>
			</table>
			<?php } ?>
			
			<table id="table4" style="width:100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td>
			<p>
			<span>Note: AB - Absent | NE - Not Eligible | NR - Not Registered | NA - Not Applicable | EX - Exempted</span><br/>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: RA-I - Re-appear in ICA | RA-E - Re-appear in ESE | RA-I&E - Re-appear in ICA & ESE</span><br/>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: From 2015 Batch, passing minimum in each component of the ICA is 40%(UG) and 50%(PG)</span><br/>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Kindly verify your personal details, Marks (ICA & ESE), G.P & G.P.A and sign below, in case of any discrepancies circle it.</span>
			</p>
			</td>
			</tr>
			<tr>
			<td>
			<p>
			<span>Date: <?=date('d/F/Y');?></span>
			</p>
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
