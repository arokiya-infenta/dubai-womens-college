
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
		  <div class="card-header"><i class="fa fa-table"></i>Student Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Applied Year</label>   
			<select class="form-control" name="applied_year" id="applied_year" required>
			<option value="">Select Year</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch2){?>
			<option value="<?=$batch2->batch_from?>" <?php if($applied_year1==$batch2->batch_from){echo 'selected';}?>><?=$batch2->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
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
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
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
			
	  <?php if(isset($stu_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
			  <!--<form action="<?php echo base_url().'coe/beforeModerationArrearPDF'?>" method="post">
			  <input type="hidden" name="stream" value="<?=$stream?>">
			  <input type="hidden" name="department" value="<?=$department?>">
			  <input type="hidden" name="subject" value="<?=$subject1?>">
			  <input type="hidden" name="sem" value="<?=$sem1?>">
			  <input type="hidden" name="batch" value="<?=$batch1?>">
			  <input type="hidden" name="applied_year" value="<?=$applied_year1?>">
			  <button class="btn btn-sm btn-success">Download PDF</button>
			  </form>
			  <br>-->
              <table id="exammarks-datatable" class="table table-bordered">
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
						if($mark_det->average!=''&&$mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
						}
						else{
							$mark=0;
							}
					$ica_mark = $this->db->select('GREATEST(ica1Mark, ica2Mark) as icaMark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
					if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}
					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					}else{
					$icamrk = 0;	
					}
					
					//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
					if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
					//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
					if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
					
					$total = (int)$ica_fin + (int)$ese_fin;
					$result = 0;
					
					$subject_det = $this->db->select("*")->from('erp_subjectmaster')->where('id',$subject1)->get()->row();
				if($subject_det->subNature=="PRACTICAL" && $subject_det->msw_m_25==1 ){
					if($stream == 5){
						if($icamrk >= 12.5 && $mark >= 12.5){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 12.5 && $mark < 12.5){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 12.5 && $mark >= 12.5){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}else{
						if($icamrk >= 12.5 && $mark >= 12.5){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 12.5 && $mark < 12.5){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 12.5 && $mark >= 12.5){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}
				}else{
					if($stream == 5){
						if($icamrk >= 20 && $mark >= 20){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 20 && $mark < 20){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 20 && $mark >= 20){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}else{
						if($icamrk >= 25 && $mark >= 25){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($icamrk >= 25 && $mark < 25){$result = '<span style="color:red">R(E)</span>';}
							elseif($icamrk < 25 && $mark >= 25){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}
								}
					}
				}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td align="center"><?=$ica_fin?></td>
						<td align="center"><?=$ese_fin?></td>
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
var fullDate = new Date()
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
		var myTable = $('#exammarks-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				bold: true,
                        fontSize: 12,
				title: 'Passing Board Report - <?=$all_dep_details[0]->comp_name ?> ',
				messageTop: '<?=$all_dep_details[0]->stream ?> - <?=$all_dep_details[0]->comp_name ?> - <?=$all_sub_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_sub_details[0]->subCode ?> -  <?=$all_sub_details[0]->subName ?> - <?=$exam_details?>',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
            //    "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'before_moderation_report - <?=$all_dep_details[0]->comp_name ?> ' + currentDate,
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4, 5, 6],
				 
                }
			},
			{ 
				extend: 'pdfHtml5',
				 
				filename: 'before_moderation_report - <?=$all_dep_details[0]->comp_name ?> ' + currentDate,
			
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6],
					//alignment: 'right',
				
				},
			//	orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					
					doc.content[1].margin = [ 15, 20, 15, 0 ],
				      
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph),
											//	text: 'Before Moderation Report',
                    } );
					doc.content.splice( 1, 1, {
                     //   alignment: 'center',
                        bold: true,
                        fontSize: 12,
                       
                        text: 'Passing Board Report :\n \n<?=$all_dep_details[0]->stream ?> - <?=$all_dep_details[0]->comp_name ?> - <?=$all_sub_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_sub_details[0]->subCode ?> -  <?=$all_sub_details[0]->subName ?> - <?=$exam_details?>.',
					//	margin: [0, 0, 0, 0],
                    } );
			
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'External Examiner',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: 'Chairman   '
                    }
                ],
				alignment: 'left',
                margin: [20, 0, 20, 0]
            }
        });
                }
			}]
		});
var allPages = myTable.rows().nodes().to$();
		
		$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
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
    $('#department,#stream,#sem,#batch').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (stream!='' && department!='' && batch!='' && sem!='') {
            $.ajax({
                url: base_url + "coe/getSubjSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
		
		
	});
	</script>