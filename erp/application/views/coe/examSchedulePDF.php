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
table2 {
                border-collapse: collapse;
            }	
.table {
  text-align: center;
  font-weight:bold;
  font-size:11px;
  text-transform: uppercase;
}	
.table1 {
  text-align: center;
  font-size:11px;
  text-transform: uppercase;
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
			<!--<td style="width:630px;">-->
			<td style="width:100%;">
			<p style="font-weight:bold;font-size:16px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<!--<p style="font-weight:bold;font-size:16px;" align="center">(Affiliated to the University of Madras)</p>-->
			<p style="font-weight:bold;font-size:16px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<?php if($sem==1 || $sem==3 || $sem==5){$month='NOVEMBER';}
			      if($sem==2 || $sem==4 || $sem==6){$month='APRIL';} ?>
			<p style="font-weight:bold;font-size:16px;" align="center">END SEMESTER EXAMINATION - <?=$month .' - '. date('Y')?> - TIME TABLE</p>
			</td>
			<td></td>
			</table>
			<hr>
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
			<?php $dept = $this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row();
			$specialization = $dept->comp_name;
			if($stream==3){$specialization = 'MSW SF - '.$dept->specialization;}
			  if($stream == 5){ $batch_to = $batch + 3; } else { $batch_to = $batch + 2;}
			  $batc = $batch .'-'. $batch_to;
			  ?>
			<table style="width:100%;" cellpadding=0 cellspacing=0>
			<tr>
			<td style="float:left;">
			<p style="font-weight:bold;font-size:16px;" align="left">DEPT: <?=$specialization?></p>
			<p style="font-weight:bold;font-size:16px;" align="left">BATCH: <?=$batc?></p>
			</td>
			<td style="float:right;">
			<p style="font-weight:bold;font-size:16px;" align="right">SEMESTER: <?=ConverToRoman($sem)?></p>
			</td>
			</tr>
			</table>
			
		  </div>
            <div class="card-body">
			
			<br/>
			<table class="table2" style="width:100%;" border=1 cellpadding=5 cellspacing=0>
			<tr class="table">
			<th class="table">SNO</th>
			<th class="table">SUBJECT CODE</th>
			<th class="table">SUBJECT NAME</th>
			<th class="table">EXAM DATE</th>
			<th class="table">SESSION</th>
			</tr>
			<?php if(isset($regular_list)){
					$sno=1;
					foreach ($regular_list as $regular) {
				if($regular->section=='Afternoon'){$session='2.00 PM To 5.10 PM';}		
				else{$session='10.00 AM To 1.10 PM';}		
			?>
			<tr class="table1">
			<td class="table1"><?=$sno++?></td>
			<td class="table1"><?=$regular->subCode?></td>
			<td class="table1" style="text-align:left!important;"><?=$regular->subName?></td>
			<td class="table1"><?=date('d-m-Y',strtotime($regular->schedule_date))?></td>
			<td class="table1"><?=$session?></td>
			</tr>
			<?php }} ?>
			<?php if(sizeof($arrear_list)>0){ ?>
			<tr>
			<td colspan="5" align="center" style="font-size:14px;font-weight:bold;">ARREAR SUBJECTS</td>
			</tr>
			<?php //$sno1=(sizeof($regular_list)+1);
					foreach ($arrear_list as $arrear) {
				if($arrear->section=='Afternoon'){$session='2.00 PM To 5.10 PM';}		
				else{$session='10.00 AM To 1.10 PM';}		
			?>
			<tr class="table1">
			<td class="table1"><?=$sno++?></td>
			<td class="table1"><?=$arrear->subCode?></td>
			<td class="table1" style="text-align:left!important;"><?=$arrear->subName?></td>
			<td class="table1"><?=date('d-m-Y',strtotime($arrear->schedule_date))?></td>
			<td class="table1"><?=$session?></td>
			</tr>
			<?php }} ?>
			</table>
			<br/>
			<br/>
			<table style="width:100%" cellpadding=0 cellspacing=0>
			<tr>
			<td>
			<p class="s1" style="font-size:16px;">Controller of Examinations</p>
			</td>
			<td>
			<p class="s1" style="font-size:16px;">Principal</p>
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
