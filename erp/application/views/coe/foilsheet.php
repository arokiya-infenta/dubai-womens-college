
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
		  <div class="card-header"><i class="fa fa-table"></i>Foil Sheet</div>
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
			
	  <?php
		
		
		
		
		/* 
		print_r($all_details);
		 */
		
		
		
		if(isset($stu_list) && $stream == 5){

			 $strn= "UG";
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		
		  <!--<button type="button" class="btn btn-sm btn-success" id="average_submit">Save Average</button>-->
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead><tr>
                <th rowspan="2">S.No</th>
                <th rowspan="2">Register Number</th>
                <th rowspan="2">Grand Total</th>
                <th colspan="9">PART - A (5 x 8 = 40) [5 out of 8]	</th>
                <th colspan="6">PART - B (3 x 20 = 60) [3 out of 5]</th>
            </tr>
                    <tr>
                       
                       
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>Total</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>Total</th>
                     
                       
                        <!--<th>Average</th>-->
                       
                       
                    </tr>
                </thead>
                <tbody>
									<?php $i=1; foreach ($stu_list as $key => $value) { ?>
							
							
          <tr>

<td><?=$i?></td>
<td><?=$value->reg_no_?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>


					</tr>
					<?php $i++; 	} ?>        
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php }else{ 
			
			$strn= "PG";
			?>

			
			<div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		
		  <!--<button type="button" class="btn btn-sm btn-success" id="average_submit">Save Average</button>-->
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead><tr>
                <th rowspan="2">S.No</th>
                <th rowspan="2">Register Number</th>
                <th rowspan="2">Grand Total</th>
                <th colspan="13">PART - A (10 x 2 = 20) [10 out of 12]	</th>
                <th colspan="7">PART - B (4 x 10 = 40) [4 out of 6]	</th>
                <th colspan="4">PART - C (2 x 20 = 40) [2 out of 3]</th>
            </tr>
                    <tr>
                       
                       
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                      
                        <th>Total</th>
												<th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>17</th>
                        <th>18</th>
                        <th>Total</th>
												<th>19</th>
                        <th>20</th>
                        <th>21</th>
												<th>Total</th>
                        <!--<th>Average</th>-->
                       
                       
                    </tr>
                </thead>
                <tbody>
									<?php $i=1; foreach ($stu_list as $key => $value) { ?>
							
							
          <tr>

<td><?=$i?></td>
<td><?=$value->reg_no_?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>



					</tr>
					<?php $i++; 	} ?>        
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>







<?php
		} 
		
		
		
	
		
		
		?>
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
                messageTop: '<?=$strn?> - <?=$dep_details[0]->comp_name ?> - <?=$all_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_details[0]->subCode ?> -  <?=$all_details[0]->subName ?> - <?=$exam_details?>.',
               
            },
            {
							extend: 'pdf',
								orientation: 'landscape',
              //  pageSize: 'LEGAL',
                messageTop: '<?=$strn?> - <?=$dep_details[0]->comp_name ?> - <?=$all_details[0]->batch_year ?> - Batch  (100 Marks) - <?=$all_details[0]->subCode ?> -  <?=$all_details[0]->subName ?> - <?=$exam_details?>.',
             
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
