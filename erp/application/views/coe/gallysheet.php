
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
		  <div class="card-header"><i class="fa fa-table"></i>Gally Sheet</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-3"  >
				
			  </div>
				 <div class="col-lg-3 mt-4">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	 
      <div  class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
				
			<input type="button" class="btn btn-block 
btn-primary  btn-xs" value="PRINT" 
onclick="printDiv('printableArea')" />     
			
	
		  </div>
            <div id="printableArea"   class="card-body">



						<div class="row text-center">

<img class="rounded mx-auto d-block" style="height:140px;" src="https://admission.mssw.in//landing/images/mssw_logo.jpg" alt="image">
<div class="col-lg-12">
<h5>END SEMESTER EXAMINATION <?=$exam_details?></h5>
<h5>GALLEY SHEET / CLASS PROVISIONAL REPORT </h5>

</div>
</div>
<br>
<div class="row ">
<div class="col-md-6">
<b>Department Name :  <?=$all_details[0]->comp_name?></b>
			</div>
			<div class="col-md-2">
				<?php 
				
				if($sem1 ==1 || $sem1==2){

					$year="First";
				}else if($sem1 ==3 || $sem1==4){

					$year="Second";
				}else if($sem1 ==5 || $sem1==6){

					$year="Third";
				}else{
					$year="";

				}
				
				?>
		<b>	Year : <?=$year?></b>
			</div><div class="col-md-2">
			<b>	Batch : <?=$batch1?></b>
			</div><div class="col-md-2">
			<b>	Semester : <?=$sem1?></b>
			</div>
			</div>


<br>
              <div   class="table-responsive">
            
						
							<div class="row">
						

							<?php $i=1; foreach ($stu_list as $key => $value) { 





								
								echo "<table class='col-md-12' style='text-align:center;'    width='100%' border='1'>
								<tr>
							
								<th colspan='2'>".$i."</th>
								<th colspan='4'>".$value->student_name_."</th>
						
								
								<th  colspan='4'>".$value->reg_no_."</th>
								
								
								</tr>
								</table>
								
								";
								
								$det = $this->db->select('*')->from('student_gally_report')
								->join('erp_subjectmaster','erp_subjectmaster.id=student_gally_report.subject_id')
								->where('batch',$batch1)->where('semester',$sem1)->where('stream_id',$stream)->where('course_id',$department)->where('stud_admit_id',$value->id)->get()->result();		
		

								$partvcount = $this->db->select("*")->from("erp_subjectmaster")
								->join("erp_partvmark","erp_subjectmaster.id=erp_partvmark.subject_id")
								->where('erp_partvmark.sem',$sem1)
								->where('erp_partvmark.student_id',$value->id)
								->get()->num_rows();	
							
								echo "<table class='column col-md-6' width='45%' style='padding-left:10px;text-align:center;' border='1'>
								
								
								
								<tr>
								<th>Subject</th>
								<th>ICA(50)</th>
								<th>ESE(50)</th>
								<th>Total(100)</th>
								<th>Result</th>
								</tr>
								
											
								
								";
								$rowCount = 1;
								$numRows = count($det) ;
								$maxRows = 4;
							
								
								?>
								
							
									<?php 
									$n=1;
									foreach ($det as $key => $sub) { 
									
											
							//	foreach ($results as $dates) {
								
									echo "<tr><td >";
									echo $sub->subCode;
									echo "</td>";
									echo "<td>";
									echo $sub->ici_mark;
									echo "</td>";
										echo "<td>";
									echo $sub->ese_mark;
									echo "</td>";
										echo "<td>";
									echo $sub->total_mark;
									echo "</td>";	
									echo "<td >";
									echo $sub->result;
									echo "</td>";	
							
									echo "</tr>";







									if($rowCount % $maxRows == 0 && $rowCount != $numRows)  {
										 echo "</table>
										 <table class='column col-md-6'  style='padding-left:10px;text-align:center;' width='45%'  border='1'>
										 <tr>
										 <th>Subject</th>
										 <th>ICA(50)</th>
										 <th>ESE(50)</th>
										 <th>Total(100)</th>
										 <th>Result</th>
										 </tr>";
										
									}
									$rowCount ++;
							}


							$partv = $this->db->select("*")->from("erp_subjectmaster")
							->join("erp_partvmark","erp_subjectmaster.id=erp_partvmark.subject_id")
							->where('erp_partvmark.sem',$sem1)
							->where('erp_partvmark.student_id',$value->id)
							->get()->result();	
							foreach ($partv as $key => $value) {

								if($value->status == 1){
							
							$ma= "P";
							$ca= "C";
							
								}else{
									$ma= "RA";
									$ca= "NC";
							
								}
								echo "<tr><td >";
																echo $value->subCode;
																echo "</td>";
																echo "<td>";
															
																echo "</td>";
																	echo "<td>";
															
																echo "</td>";
																	echo "<td>";
																	echo $ca;
																echo "</td>";	


																echo "<td >";
																echo $ma;
																echo "</td>";	
														
																echo "</tr>";

																$rowCount ++;
							}
							
							echo "</table>";
						
										
										?>
									

								
									

									
								
						
								
								<?php $i++;	} ?>		
              
            </div>
					
						<div class="row padding" style="padding-top:50px">
<div class="col-md-6">
Controller of Examinations         
			</div>
			<div class="col-md-2">
		
			</div><div class="col-md-2">
		
			</div><div class="col-md-2">
			Principal
			</div>
			</div>
			
			<div class="row padding">
<div class="col-md-12">
P - Pass, C - Completed, NC - Not Completed, NA - Not Applicable, RA - Re-Appear, RA(IE) - Re-Appear
in ICA & ESE,<br> RA(I) - Re-Appear in ICA, RA(E) - Re-Appear in ESE, AAA - Absent, EX - Exempted, NR - 
Not Registered,<br>AW - Data Awaited   

<br><br>

* Any grievance must be brought to the notice of the concerned authorities within 10 days from the<br> 
date of publication of results
			</div>
		
			</div>
					
					
					</div>
					
            </div>
          </div>
        </div>
      </div>
	 



	  <!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
		<style>
* {
  box-sizing: border-box;
}


  
.column {
	margin-left:-5px;
  margin-right:-5px;
   float: right;
  width: 50%;
  padding: 5px; 
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: center;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other on screens that are smaller than 600 px */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}
</style>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
	<script>
	


	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){

		//$( 'current_field_selector' ).focusNextInputField();

	
		$(".intval").each(function() {


var val = $(this).val();

if(val == 26){

	
}

});


var myTable = $('#exammarks-datatable').DataTable({
  dom: 'Bfrtip',
	
        buttons: [
					{
                extend: 'excel',
                messageTop: '<?=$strn?> - <?=$all_details[0]->comp_name ?> - <?=$all_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_details[0]->subCode ?> -  <?=$all_details[0]->subName ?> - <?=$exam_details?>.',
               
            },
            {
							extend: 'pdf',
								orientation: 'landscape',
              //  pageSize: 'LEGAL',
                messageTop: '<?=$strn?> - <?=$all_details[0]->comp_name ?> - <?=$all_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_details[0]->subCode ?> -  <?=$all_details[0]->subName ?> - <?=$exam_details?>.',
             
            },
        ],
				"lengthMenu": [[100, "All", 50, 25], [100, "All", 50, 25]],
    //    "order": [[ 8, "desc" ]],

});

		
		$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){




//alert();

			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#department').append(data);
                }
            });
        }else{
			$('#dept').css('display','none');
		}
		});
    $('#department').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $(this).val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "coe/getSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			alert('Select all the fields');
		}
		});	
		
		
$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		/*$(".ica",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});*/
	$(".internal",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".external",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".thirdparty",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	
		$('#ica_submit').click(function(){
		var ica=Array();	
		var ica_not=Array();	
		var icaval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();	
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica]:checked').each(function(){
            ica.push($(this).data('student'));
            icaval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica]:not(:checked)').each(function(){
            ica_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/icaTotalMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica: ica,icaval: icaval,main_id: main_id,course_id: course_id,ica_not: ica_not,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {

									console.log(data);

                }
            });
					alert('ICA Marks Added Successfully!!');
		}
		});
		

	});
	</script>
