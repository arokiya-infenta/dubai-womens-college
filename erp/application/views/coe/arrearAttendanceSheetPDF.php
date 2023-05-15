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
  font-size:11px;
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
			<td><img src="<?php echo base_url().'system/images/logo.png' ?>" style="width:150px;height:150px;"></td>
			<!--<td style="width:630px;">-->
			<td style="width:100%;">
			<p style="font-weight:bold;font-size:16px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<p style="font-weight:bold;font-size:16px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<p style="font-weight:bold;font-size:16px;" align="center">ARREAR EXAMINATION - <?=date('Y')?></p>
			</td>
			<td></td>
			</table>
			<hr>
			<table style="width:100%;" cellpadding=0 cellspacing=0>
			<tr>
			<td style="float:middle;">
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
			<td style="font-weight:bold;font-size:13px;float:left;">DATE OF EXAMINATION: <?=date('d-m-Y',strtotime($schedule_date))?></td>
			</tr>
			<tr>
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
			<th class="table">SUBJECT</th>
			<th class="table">SEAT NUMBER</th>
			<th class="table">ANSWER BOOK NO.</th>
			<th class="table">SIGNATURE OF THE CANDIDATE</th>
			</tr>
			<?php if(isset($seat_list)){
					$sno=1;
					foreach ($seat_list as $seats) {
			?>
			<tr class="table1">
			<td class="table1"><?=$sno++?></td>
			<td class="table1"><?=$seats->reg_no_?></td>
			<td class="table1" style="text-align:left!important;width:160px;"><?=$seats->student_name_?></td>
			<td class="table1" style="text-align:left!important;width:200px;"><?php echo $seats->subName.' ('.$seats->subCode.')'?></td>
			<td class="table1" style="width:40px;"><?=$seats->seat_no?></td>
			<td class="table" style="width:40px;"></td>
			<td class="table" style="width:80px;"></td>
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
