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
		  <div class="card-header"><i class="fa fa-table"></i>OFFICE COPY</div>
            <div class="card-body">
			
			<h4 style="color:#2f6fbf;" align="center">Government of Tamilnadu</h4>
			<h4 style="color:#2f6fbf;" align="center">Department of Collegiate Education</h4>
			<h4 style="color:red;" align="center">Transfer and Conduct Certificate</h4>
			
			<table cellpadding=0 cellspacing=0>
			
			<tr>
			<td colspan=2><p>Serial No: <?=$stu_list->as_app_number?></p></td>
			<td colspan=3 align="right">
			<p>Reg No: <?=$stu_list->as_reg_num?></p>
			</td>
			</tr>
			
			
			<tr>
			<td></td>
			<td>
			<p>1. Name of the College</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>Madras School of Social Work<br />
			(Autonomous - Affiliated to University of Madras)<br />
			No: 32, Casa Major Road, Egmore,<br />
			Chennai: 600 008</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>2. Name of the Student</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->as_name?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>3. Name of the Parent/Guardian</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->pr_father_name?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>4. Sex</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->pr_gender?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>5. Date of Birth</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=date('d-m-Y',strtotime($stu_list->pr_dob))?><br/>
			(TEN JUNE NINETEEN NINETY-NINE)</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>6. Nationality and Religion</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->pr_nationality?>, <?=$stu_list->pr_religion?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>7. Community</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->pr_community?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>8. Date of Admission</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>25-June-2019</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>9. Course in which the student was studying at the time of leaving</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->comp_name?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>10. Academic Year</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>2019-2021</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>11. Medium of Instruction</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=$stu_list->pr_medium_of_instruct?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>12. Date on which the student actually left</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>30-April-2021</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>13. Conduct and Character</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>Good</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>14. Date on which application Transfer Certificate</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>22-July-2022</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>15. Date of issue of Transfer Certificate</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p><?=date('d-M-Y')?></p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>16. Whether qualified for promotion of higher class</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>Refer Marksheet</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<p>17. Course of Study</p>
			</td>
			<td>
			<p>:</p>
			</td>
			<td>
			<p>Completed</p>
			</td>
			<td></td>
			</tr>
			
			<tr>
			<td></td>
			<td>
			<h5><b>College Seal:</b></h5>
			</td>
			<td colspan=2></td>
			<td>
			<h5><b>Signature of the Principal</b></h5>
			</td>
			</tr>
			
			<tr>
			<td></td>
			<td colspan=4>
			<h5><b>Note: 1. Erasures and unauthenticated or fradulent alterations in the certificate will lead to its cancellation.<br/>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Should be signed in ink by the Head of the Institution who will be held responsible for the correctness of the entries.</b></h5>
			</td>
			</tr>
			
			<tr style="padding-top:120px;">
			<td colspan=5  align="center">
			<h5><b>Declaration</b></h5>
			</td>
			</tr>
			
			<tr>
			<td></td>
			<td colspan=4>
			<h5><b>I hereby declare that the participation recorded in the Certificate are correct and that no change will be designed by me in future.</b></h5>
			</td>
			</tr>
			
			<tr>
			<td></td>
			<td colspan=4 align="left">
			<h5><b>Signature of the Student</b></h5>
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
