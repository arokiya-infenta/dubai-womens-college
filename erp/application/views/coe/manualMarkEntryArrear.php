
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
			<label>Applied Batch</label>   
			<select class="form-control" name="written_year" id="written_year" required>
			<option value="">Select Year</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch2){?>
			<option value="<?=$batch2->batch_from?>" <?php if($year1==$batch2->batch_from){echo 'selected';}?>><?=$batch2->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3" id="appliedsem">
			<label>Applied Sem</label>   
			  <select class="form-control" id="applied_sem" name="applied_sem">
			  <option value="">Select Semester</option>
			  <?php $applied_sem = array('1','2','3','4','5','6');
			  foreach($applied_sem as $applied_sem){ ?>
			  <option value="<?=$applied_sem?>" <?php if($applied_sem1==$applied_sem){echo 'selected';}?>><?=$applied_sem?></option>
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
			  <div class="row">
			  <div class="col-lg-6 mb-4">
			  <div class="form-group" style="float:left;">
			  <p style="color:red"><b>Note:</b></p>
			  <p style="color:red">Results(In Caps): <b>P</b>-Pass, <b>R(I)</b>-Internal, <b>R(E)</b>-External, <b>R(I + E)</b>-Internal and External</p>
			  </div>
			  </div>
			  </div>
			  <div class="row">
			  <div class="col-lg-6 mb-4">
			  <div class="form-group" style="float:left;">
			  <button class="btn btn-sm btn-warning" id="publish_result" >Save Result</button>
			  </div>
			  </div>
				 </div>
				
<table id="aftermod-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No.</th>
                        <th>Name</th>
                        <th>Arrear Status</th>
                        <th>ICA Mark(50)</th>
                        <th>ESE Mark(50)</th>
                        <th>Total(100)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->where('arrear_status',1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->ica!=''&&$mark_det->ica!=null){$checked1='checked';$readonly1='';$mark1=$mark_det->ica;}else{$checked1='';$readonly1='readonly';$mark1=0;}
						if($mark_det->average!=''&&$mark_det->average!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->average;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->result!=''&&$mark_det->result!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->result;}else{$checked4='';$readonly4='readonly';$mark4='';}
						}
						else{
							$checked1='';$readonly1='readonly';$mark1=0;
							$checked3='';$readonly3='readonly';$mark3=0;
							$checked4='';$readonly4='readonly';$mark4='';
							}
						$det1 = $this->db->where('batch',$batch1)->where('semester',$sem1)->where('stud_admit_id',$student->id)->where('subject_id',$subject1)->get('student_gally_report')->row();
						if(isset($det1)){
						if($det1->ese_mark!=''&&$det1->ese_mark!=null){$checked2='checked';$readonly2='';$mark2=$det1->ese_mark;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						}
						else{
							$checked2='';$readonly2='readonly';$mark2=0;
							}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
						<td><input type="checkbox" style="width:20px;height:20px;" data-student="<?=$student->id?>" <?=$checked1?>></td>
						<td><input type="number" class="form-control ica"  data-student="<?=$student->id?>" value="<?=$mark1?>"></td>
						<td><input type="number" class="form-control ese" data-student="<?=$student->id?>" value="<?=$mark2?>"></td>
						<td><input type="number" class="form-control total" data-student="<?=$student->id?>" value="<?=$mark3?>"></td>
						<td><input type="text" class="form-control result" data-student="<?=$student->id?>" value="<?=$mark4?>"></td>
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
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#aftermod-datatable').DataTable({ 
		"bSortCellsTop": true,
		"lengthMenu": [[100, "All", 50, 25], [100, "All", 50, 25]],
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				bold: true,
                        fontSize: 12,
				title: 'Passing Board Report - ' +currentDate+'',
				messageTop: 'Batch - ' +currentDate+'',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'after_moderation_report - ',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4],
				 
                }
			},
			{ 
				extend: 'pdfHtml5',
				 
				filename: 'after_moderation_report - ' +currentDate+'',
			
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
					alignment: 'right',
				
				},
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					
					doc.content[1].margin = [ 120, 20, 120, 0 ],
				      
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					doc.content.splice( 1, 1, {
                        alignment: 'center',
                        bold: true,
                        fontSize: 12,
                        text: 'Passing Board  Report ',
						margin: [0, 0, 0, 0],
                    } );
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'External Examiner',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: 'Chairman'
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
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
                    sem: sem
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
		
$('#publish_result').click(function(){
		var student=Array();
		var ica=Array();	
		var ese=Array();	
		var total=Array();	
		var result=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
		var written_year=$('#written_year').val();	
		var applied_sem=$('#applied_sem').val();	
		if(applied_sem == false){ applied_sem='';}	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[type=checkbox]:checked').each(function(){
            student.push($(this).data('student'));
			ica.push($(this).closest('tr').find('td:eq(4) .ica').val());
			ese.push($(this).closest('tr').find('td:eq(5) .ese').val());
			total.push($(this).closest('tr').find('td:eq(6) .total').val());
			result.push($(this).closest('tr').find('td:eq(7) .result').val());
            });
		});
		if (confirm('Are you sure to save the result?')) {
            $.ajax({
                url: base_url + "coe/saveManualMarkArr",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    student: student,ica: ica,ese: ese, total: total, result: result, main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,written_year: written_year,applied_sem: applied_sem,
                },
                success: function (data) {
                }
            });
					alert('Marks Saved Successfully!!');
		}
		});
		
		
	var inputs_i = $(".ica",allPages);
$(inputs_i).keypress(function(e){
	  if (e.keyCode == 13){
		  inputs_i[inputs_i.index(this)+1].focus();
	  }
});
var inputs_e = $(".ese",allPages);
$(inputs_e).keypress(function(e){
	  if (e.keyCode == 13){
		  inputs_e[inputs_e.index(this)+1].focus();
	  }
});
var inputs_t = $(".total",allPages);
$(inputs_t).keypress(function(e){
	  if (e.keyCode == 13){
		  inputs_t[inputs_t.index(this)+1].focus();
	  }
});
var inputs_r = $(".result",allPages);
$(inputs_r).keypress(function(e){
	  if (e.keyCode == 13){
		  inputs_r[inputs_r.index(this)+1].focus();
	  }
});
		
		
	});
	</script>
	<script>
/*if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }*/
</script>
