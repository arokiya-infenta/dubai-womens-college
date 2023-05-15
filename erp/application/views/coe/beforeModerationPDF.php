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
	  
	  <!--Start Row-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<table cellpadding=0 cellspacing=0 style="padding-top: -45px;">
			<td><img src="<?php echo base_url().'system/images/logo.png' ?>" style="width:150px;height:150px;"></td>
			<td style="width:630px;">
			<p style="font-weight:bold;font-size:16px;padding-top: 15px;" align="center">MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<!--<p style="font-weight:bold;font-size:16px;" align="center">(Affiliated to the University of Madras)</p>-->
			<p style="font-weight:bold;font-size:16px;" align="center">32, Casa Major Road, Egmore, Chennai-600008</p>
			<p style="font-weight:bold;font-size:16px;" align="center">BEFORE MODERATION</p>
			</td>
			<td></td>
			</table>
			
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table  style="width:100%;" cellpadding=5 cellspacing=0 border=1>
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No.</th>
                        <th>Name</th>
                        <th>ICA Mark(50)</th>
                        <th>ESE Mark(50)</th>
                        <th>Total(100)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
								<?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$mark=0;
							}
					$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
				//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}







				if(is_numeric($ica_mark->ica1Mark)){


					$iccamm1 = $ica_mark->ica1Mark;
										}else{
					
					
											$iccamm1 = 00.0;
					
										}	if(is_numeric($ica_mark->ica2Mark)){
					
					
					$iccamm2 = $ica_mark->ica2Mark;
										}else{
					
					
											$iccamm2 = 00.0;
					
										}
										
									
										
										
										if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
					
											$great =$iccamm1;
										}else{
											$great =$iccamm2;
					
										}
									 $great=	number_format($great,1);
			
									 $icaMark =$great;

									 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}

					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					
					
				
				}else{
					$icamrk = 00.0;	
					}
					



					$fimdMax=[];
					$arre=[];
					
					$fimdMax=array($mark2,$mark3,$mark4);
					
					$arre = sort($fimdMax);
					(int)$maxtotal = (int)$fimdMax[1]+(int)$fimdMax[2];
					$ese_m = round($maxtotal/4);







					//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
				//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
					//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
					if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
					
					$total = (int)$ica_fin + (int)$ese_m;
					$result = 0;
					
					if($stream == 5){
						if($icamrk >= 20 && $ese_m >= 20){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 20 && $ese_m < 20){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 20 && $ese_m >= 20){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}else{
						if($icamrk >= 25 && $ese_m >= 25){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 25 && $ese_m < 25){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 25 && $ese_m >= 25){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td align="center"><?=$ica_fin?></td>
						<td align="center"><?=$ese_m?></td>
						<td align="center"><?=$total?></td>
						<td align="center"><?=$result?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <!-- End Row-->
	  
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
