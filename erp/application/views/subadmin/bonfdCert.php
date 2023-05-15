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
</style>
<body>

<div id="wrapper">
			
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  <table cellpadding=0 cellspacing=0>
		  <tr>
			<td><img src="<?php echo base_url().'system/images/logo.png' ?>" style="width:150px;height:150px;"></td>
			<td style="width:630px;line-height:5px;color:#13197d;">
			<p style="font-weight:bold;font-size:30px;" align="center">MADRAS SCHOOL OF SOCIAL WORK</p>
			<p style="font-weight:bold;font-size:14px;" align="center">(An Autonomous Institution Affiliated to the University of Madras)</p>
			<p style="font-weight:bold;font-size:14px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<p style="font-weight:bold;font-size:14px;" align="center">College Off.: 28192824/5126 Principal: 28195125</p>
			<p style="font-weight:bold;font-size:14px;" align="center">Email: principal@mssw.in Website: www.mssw.in</p>
			</td>
			<td></td>
			</tr>
			<tr>
			<td colspan=3><p style="font-weight:bold;font-size:14px;color:#13197d;">Dr. S. RAJA SAMUEL, M.A, Ph.D. <br>Principal</p>
			</td>
			</tr>
			</table>
		  </div>
            <div class="card-body">
			<br/><br/><br/>
			<?php $currDate = date('Y');
			$batch = explode('-',$stu_list->as_app_number);
			$stu_batch = '20' . $batch[1];
			$year = $currDate - $stu_batch;
			if($year == 0){$stu_yr = 'First year';}
			else if($year == 1){$stu_yr = 'Second year';}
			else if($year == 2){$stu_yr = 'Third year';}
			else{$stu_yr = '';}
			?>
			<table cellpadding=0 cellspacing=0>
			
			<tr>
			<td align="center"><p><strong>TO WHOMSOEVER IT MAY CONCERN</strong></p></td>
			</tr>
			
			<tr>
			<td align="right"><p>Date:<?=date('d/M/Y')?></p></td>
			</tr>
			
			<tr>
			<td><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certifiy that <strong><?=$stu_list->as_name?> &nbsp;&nbsp; D/o. &nbsp;&nbsp; <?=$stu_list->pr_father_name?></strong> with Registration No. <strong><?=$stu_list->as_reg_num?></strong>is a <?=$stu_yr?> student of <strong><?=$stu_list->comp_name?></strong> at the Madras School of Social Work, Egmore, Chennai-600008.</p></td>
			</tr>
			
			<tr align="right">
			<td><p><strong>PRINCIPAL</strong></p></td>
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
