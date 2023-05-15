
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
		  <div class="card-header"><i class="fa fa-table"></i>NAAC Report</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Year</label>   
			<select class="form-control" name="year" id="year" required>
			<option value="">Select Year</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($year1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Month</label>   
			<select class="form-control" name="month" id="month" required>
			<option value="">Select Month</option>
			<option value="2" <?php if($month1=='2'){echo 'selected';}?>>April</option>
			<option value="1" <?php if($month1=='1'){echo 'selected';}?>>November</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="1" <?php if($stream1=='1'){echo 'selected';}?>>Aided</option>
			<option value="2" <?php if($stream1=='2'){echo 'selected';}?>>Self Finance</option>
			</select>
			<?php $mnt='';$strm='';
			if($month1==1){$mnt='November';} if($month1==2){$mnt='April';}
			if($stream1==1){$strm='Aided';} if($stream1==2){$strm='Self Finance';}
			?>
			<input type="hidden" id="mn_yr" value="<?=$mnt .' '. $year1 .' - '. $strm?>">
		         </div>
				 <div class="col-lg-3 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
			  </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	<?php if($_POST){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
			<table id="naac-report" class="table table-bordered">
			<thead>
			<?php if($month1 == 1){$sem1 = array('1','3','5');}
		 else{$sem1 = array('2','4','6');} ?>
			<tr style="font-weight:bold;">
			<th rowspan=3>Department</th>
			<th colspan=9>Sem-<?=$sem1[0]?></th>
			<th colspan=9>Sem-<?=$sem1[1]?></th>
			<th colspan=9>Sem-<?=$sem1[2]?></th>
			<th colspan=9>OVERALL</th>
			</tr>
			<tr>
			<th colspan=2>APPEARED</th>
			<th rowspan=2>PASSED</th>
			<th rowspan=2>PASS %</th>
			<th rowspan=2>EXEMPLARY</th>
			<th rowspan=2>DISTINCTION</th>
			<th rowspan=2>FIRST CLASS</th>
			<th rowspan=2>SECOND CLASS</th>
			<th rowspan=2>THIRD CLASS</th>
			<th colspan=2>APPEARED</th>
			<th rowspan=2>PASSED</th>
			<th rowspan=2>PASS %</th>
			<th rowspan=2>EXEMPLARY</th>
			<th rowspan=2>DISTINCTION</th>
			<th rowspan=2>FIRST CLASS</th>
			<th rowspan=2>SECOND CLASS</th>
			<th rowspan=2>THIRD CLASS</th>
			<th colspan=2>APPEARED</th>
			<th rowspan=2>PASSED</th>
			<th rowspan=2>PASS %</th>
			<th rowspan=2>EXEMPLARY</th>
			<th rowspan=2>DISTINCTION</th>
			<th rowspan=2>FIRST CLASS</th>
			<th rowspan=2>SECOND CLASS</th>
			<th rowspan=2>THIRD CLASS</th>
			<th colspan=2>APPEARED</th>
			<th rowspan=2>PASSED</th>
			<th rowspan=2>PASS %</th>
			<th rowspan=2>EXEMPLARY</th>
			<th rowspan=2>DISTINCTION</th>
			<th rowspan=2>FIRST CLASS</th>
			<th rowspan=2>SECOND CLASS</th>
			<th rowspan=2>THIRD CLASS</th>
			</tr>
			<tr>
			<th>M</th>
			<th>F</th>
			<th>M</th>
			<th>F</th>
			<th>M</th>
			<th>F</th>
			<th>M</th>
			<th>F</th>
			</tr>
			</thead>
			<tbody>
			<?php
			
function passfail($pf){
	if($pf != 0){
		unset($pf);
	}else{ return $pf;}
}

				if($stream1==1){$this->db->where('d.main_id',2);}else{
			    $this->db->where('d.main_id = 1 OR d.main_id = 3 OR d.main_id = 5');
		        }
			$get_dept = $this->db->order_by('d.main_id','asc')->get('department_details d')->result();
          $sem1_m=0;$sem1_f=0;$sem1_ps=0;$sem1_pp=0;$sem1_ex=0;$sem1_di=0;$sem1_fi=0;$sem1_se=0;$sem1_th=0;
          $sem2_m=0;$sem2_f=0;$sem2_ps=0;$sem2_pp=0;$sem2_ex=0;$sem2_di=0;$sem2_fi=0;$sem2_se=0;$sem2_th=0;
          $sem3_m=0;$sem3_f=0;$sem3_ps=0;$sem3_pp=0;$sem3_ex=0;$sem3_di=0;$sem3_fi=0;$sem3_se=0;$sem3_th=0;
          $oa_m=0;$oa_f=0;$oa_ps=0;$oa_pp=0;$oa_ex=0;$oa_di=0;$oa_fi=0;$oa_se=0;$oa_th=0;
           foreach($get_dept as $dept){	
			?>
			<tr>
			<td><?=$dept->comp_name?></td>
			<?php if($month1 == 1){$sem = array('1','3','5');}
		 else{$sem = array('2','4','6');}
		 $ml=0;$fe=0;$exe=0;$dis=0;$fir=0;$sec=0;$thi=0;$passt=0;$passp=0;
		 $sc=0;
		 foreach($sem as $sem){
			 $studet = $this->db->select('em.*,es.gender_')
		->join('erp_existing_students es','em.student_id=es.id') 
		->where('em.sem',$sem)
		->where('em.main_id',$dept->main_id)
		->where('em.course_id',$dept->cour_id)
		->where('(em.written_year='.$year1.' OR (em.arrear_status=1 AND em.arrear_applied_year='.$year1.'))')
		->group_by('em.student_id')
        ->get('erp_exammarkfinal em') ->result();
		$male = 0;$female=0;
		foreach($studet as $stu){
			if($stu->gender_ == 'Male' OR $stu->gender_ == 'MALE' OR $stu->gender_ == 'M'){$male += 1;}
			if($stu->gender_ == 'Female' OR $stu->gender_ == 'FEMALE' OR $stu->gender_ == 'F'){$female += 1;}
		}
		$studet_pf = $this->db->select('em.*,es.gender_')
		->join('erp_existing_students es','em.student_id=es.id') 
		->where('em.sem',$sem)
		->where('em.main_id',$dept->main_id)
		->where('em.course_id',$dept->cour_id)
		->where('(em.written_year='.$year1.' OR (em.arrear_status=1 AND em.arrear_applied_year='.$year1.'))')
        ->get('erp_exammarkfinal em') ->result_array();
		//print_r($this->db->last_query());exit;
		/*$studet_pf = $this->db->select('gr.*,es.gender_')
		->join('erp_existing_students es','gr.stud_admit_id=es.id') 
		->join('erp_exammarkfinal em','em.student_id=es.id and em.sem='.$sem.' and em.main_id='.$dept->main_id.' and em.course_id='.$dept->cour_id.'') 
		->where('gr.semester',$sem)
		->where('gr.stream_id',$dept->main_id)
		->where('gr.course_id',$dept->cour_id)
		->where('gr.batch='.$year1.'')
		->where('(em.written_year='.$year1.' OR (em.arrear_status=1 AND em.arrear_applied_year='.$year1.'))')
		->group_by('gr.batch,gr.subject_id,gr.stud_admit_id')
        ->get('student_gally_report gr') ->result_array();*/
		
$key = 'student_id';
//$key = 'stud_admit_id';
$return = array();
foreach($studet_pf as $v) {
 $return[$v[$key]][] = $v;
}
$r=0;
$st = array();
foreach($return as $key => $return1) {
 $st[$key] = 0;	
	foreach($return1 as $return2) {
		if($return2['result'] != 'P'){
		$st[$key] += 1;
		}
}
$studet_prtv = $this->db->select('ep.*')
		->where('ep.sem',$sem)
		->where('ep.main_id',$dept->main_id)
		->where('ep.course_id',$dept->cour_id)
		->where('ep.batch',$year1)
		->where('ep.student_id',$key)
        ->get('erp_partvmark ep') ->result();
	foreach($studet_prtv as $prtv) {
		if($prtv->status == 0){
		$st[$key] += 1;
		}
}	
}
$total = sizeof($st);

	//$getpf1 = array_map('passfail',$st); 
	$getpf = $st; 
	foreach($getpf as $gp => $val) { 
    if($val!=0)
        unset($getpf[$gp]);
		 }
	$pass_t = sizeof($getpf);
	$pass_p1 = 0;
	if($total!=0){
	$pass_p1 = ($pass_t/$total)*100;}
	$pass_p = round($pass_p1,1);
	
	
	$ex=0;$di=0;$fi=0;$se=0;$th=0;
	//foreach($st as $ke => $stu_det){
	foreach($getpf as $ke => $stu_det){
		$studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id where em.student_id='.$ke.' and em.written_year='.$year1.' and em.result="P" and em.sem="'.$sem.'" order by em.sem asc ')->result();
			//print_r($this->db->last_query());exit;
		$ax1 = 0; $part1 = 0; $all_credits1 = 0;
			foreach($studet as $studetl){
				$subj=$this->db->where('id',$studetl->subject_id)->get('erp_subjectmaster')->row();
				$total1=0;
			    $lg='AAA';
			    $gp1=0.0;
			if($studetl->moderate_status==1){$ese=$studetl->moderated_mark;}else{$ese=$studetl->average;}
			$ica=$studetl->ica;
			if($ica!='A' && $ica!='' && $ese!=''){
			$total1=(float)$ica + (float)$ese;}
			//$gp1=substr_replace($total1, '.', -1, 0);
			$gp1=$total1*0.1;
				$ax1 += ($subj->creditPnt)*$gp1;
			    $all_credits1 += ($subj->creditPnt);
			    if($all_credits1 != 0){$part1 = $ax1/$all_credits1;}
			}
				$arrear_history = $this->db->where('student_id',$ke)->where('sem',$sem)->where('written_year',$year1)->where('(result="R(I + E)" OR result="R(I)" OR result="R(E)")')->get('erp_exammarkfinal')->row(); 
			$final_res1='NA';
			if($part1 > 8.5 && $part1 < 10.0){$final_res1='Exemplary';}
			if($part1 > 7.5 && $part1 < 8.5){$final_res1='Distinction';}
			if($part1 > 6.0 && $part1 < 7.5){$final_res1='First Class';}
			if($part1 > 5.0 && $part1 < 6.0){$final_res1='Second Class';}
			if($dept->main_id==5){
				if($part1 > 4.0 && $part1 < 5.0){$final_res1='Third Class';}
			}
			//if(!isset($arrear_history)){
			if($final_res1=='Exemplary'){$ex += 1;}
			if($final_res1=='Distinction'){$di += 1;}
			if($final_res1=='First Class'){$fi += 1;}
			if($final_res1=='Second Class'){$se += 1;}
			if($final_res1=='Third Class'){$th += 1;}
			//}
	}
	$ml=$ml+$male;$fe=$fe+$female;$exe=$exe+$ex;$dis=$dis+$di;$fir=$fir+$fi;$sec=$sec+$se;$thi=$thi+$th;$passt=$passt+$pass_t;
	if($sc==0){$sem1_m=$sem1_m+$male;$sem1_f=$sem1_f+$female;$sem1_ps=$sem1_ps+$pass_t;$sem1_ex=$sem1_ex+$ex;$sem1_di=$sem1_di+$di;$sem1_fi=$sem1_fi+$fi;$sem1_se=$sem1_se+$se;$sem1_th=$sem1_th+$th;
	}
	if($sc==1){$sem2_m=$sem2_m+$male;$sem2_f=$sem2_f+$female;$sem2_ps=$sem2_ps+$pass_t;$sem2_ex=$sem2_ex+$ex;$sem2_di=$sem2_di+$di;$sem2_fi=$sem2_fi+$fi;$sem2_se=$sem2_se+$se;$sem2_th=$sem2_th+$th;
	}
	if($sc==2){$sem3_m=$sem3_m+$male;$sem3_f=$sem3_f+$female;$sem3_ps=$sem3_ps+$pass_t;$sem3_ex=$sem3_ex+$ex;$sem3_di=$sem3_di+$di;$sem3_fi=$sem3_fi+$fi;$sem3_se=$sem3_se+$se;$sem3_th=$sem3_th+$th;
	}
			 ?>
			<td><?=$male?></td>
			<td><?=$female?></td>
			<td><?=$pass_t?></td>
			<td><?=$pass_p?></td>
			<td><?=$ex?></td>
			<td><?=$di?></td>
			<td><?=$fi?></td>
			<td><?=$se?></td>
			<td><?=$th?></td>
		   <?php $sc++;} 
	        $mf=$ml+$fe;
			if($mf!=0){
	        $passp=round((($passt/$mf)*100),1); }?>
			<td><?=$ml?></td>
			<td><?=$fe?></td>
			<td><?=$passt?></td>
			<td><?=$passp?></td>
			<td><?=$exe?></td>
			<td><?=$dis?></td>
			<td><?=$fir?></td>
			<td><?=$sec?></td>
			<td><?=$thi?></td>
			</tr>
			<?php $oa_m=$oa_m+$ml;$oa_f=$oa_f+$fe;$oa_ps=$oa_ps+$passt;$oa_ex=$oa_ex+$exe;$oa_di=$oa_di+$dis;$oa_fi=$oa_fi+$fir;$oa_se=$oa_se+$sec;$oa_th=$oa_th+$thi;
			} 
			$sem1_pt=$sem1_m+$sem1_f;
			if($sem1_pt !=0 ){
			$sem1_pp=round((($sem1_ps/$sem1_pt)*100),1);}
			$sem2_pt=$sem2_m+$sem2_f;
			if($sem2_pt !=0 ){
			$sem2_pp=round((($sem2_ps/$sem2_pt)*100),1);}
			$sem3_pt=$sem3_m+$sem3_f;
			if($sem3_pt !=0 ){
			$sem3_pp=round((($sem3_ps/$sem3_pt)*100),1);}
			$oa_pt=$oa_m+$oa_f;
			if($oa_pt !=0 ){
			$oa_pp=round((($oa_ps/$oa_pt)*100),1);}
			?>
			
			<tr>
			<td>TOTAL</td>
			<td><?=$sem1_m?></td>
			<td><?=$sem1_f?></td>
			<td><?=$sem1_ps?></td>
			<td><?=$sem1_pp?></td>
			<td><?=$sem1_ex?></td>
			<td><?=$sem1_di?></td>
			<td><?=$sem1_fi?></td>
			<td><?=$sem1_se?></td>
			<td><?=$sem1_th?></td>
			<td><?=$sem2_m?></td>
			<td><?=$sem2_f?></td>
			<td><?=$sem2_ps?></td>
			<td><?=$sem2_pp?></td>
			<td><?=$sem2_ex?></td>
			<td><?=$sem2_di?></td>
			<td><?=$sem2_fi?></td>
			<td><?=$sem2_se?></td>
			<td><?=$sem2_th?></td>
			<td><?=$sem3_m?></td>
			<td><?=$sem3_f?></td>
			<td><?=$sem3_ps?></td>
			<td><?=$sem3_pp?></td>
			<td><?=$sem3_ex?></td>
			<td><?=$sem3_di?></td>
			<td><?=$sem3_fi?></td>
			<td><?=$sem3_se?></td>
			<td><?=$sem3_th?></td>
			<td><?=$oa_m?></td>
			<td><?=$oa_f?></td>
			<td><?=$oa_ps?></td>
			<td><?=$oa_pp?></td>
			<td><?=$oa_ex?></td>
			<td><?=$oa_di?></td>
			<td><?=$oa_fi?></td>
			<td><?=$oa_se?></td>
			<td><?=$oa_th?></td>
			</tr>
			
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
	var mn_yr = $('#mn_yr').val();
	var subname = $('#subname').val();
	var fullDate = new Date();
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	var myTable = $('#naac-report').DataTable({
		"ordering": false,
		dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				//title: 'Shortlisted Candidates ' + currentDate + '',
				title: 'Report For the Examination '+mn_yr+'',
				text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
				titleAttr: 'Export Excel',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'NAAC Report_ '+currentDate+'',
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "left",
				customize: function (xlsx) {
					
			//Apply styles, Center alignment of text and making it bold.
            var sSh = xlsx.xl['styles.xml'];
  

                },
			}]
			});
var allPages = myTable.rows().nodes().to$();
	});
	</script>