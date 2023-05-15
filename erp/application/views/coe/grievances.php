
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
		  <div class="card-header">
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="grievance-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Grievance</th>
                        <th>Files</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark = $this->db->where('student_id',$student->student_id)->where('batch_year',$batch1)->where('subject_id',$subject1)->order_by('id','desc')->limit('1')->get('erp_exammarkfinal')->row();
						if(isset($mark)){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->grievance?></td>
                        <td>
						<?php if($student->attachment_file !=''){?>
						<a href="<?=base_url().$student->attachment_file?>" download class="btn btn-sm btn-success">Download</a>
						<?php } ?>
						</td>
                        <td><button type="button" class="btn btn-warning btn-sm edit" data-target="#myModal" data-toggle="modal" data-id="<?=$student->id?>" data-solution="<?=$student->grievance_solution?>" data-status="<?=$student->status?>" data-ica="<?=$mark->ica?>" data-internal="<?=$mark->internal?>" data-external="<?=$mark->external?>" data-thirdparty="<?=$mark->thirdparty?>" data-average="<?=$mark->average?>" data-mark_id="<?=$mark->id?>">Update Issue</button></td>
                    </tr>
						<?php }} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } ?>
	  <!-- End Row-->
	  
	  
	  <!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Solution</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<!--<form action="" method="post">-->
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-4">
			<label>ICA</label>
			<input type="text" id="ica" class="form-control">
			</div>
			<div class="col-md-4">
			<label>Internal</label>
			<input type="text" id="internal" class="form-control mark">
			</div>
			<div class="col-md-4">
			<label>External</label>
			<input type="text" id="external" class="form-control mark">
			</div>
			<div class="col-md-4">
			<label>Third Party</label>
			<input type="text" id="thirdparty" class="form-control mark">
			</div>
			<div class="col-md-4">
			<label>Average</label>
			<input type="text" id="average" class="form-control average" readonly>
			<input type="hidden" id="mark_id" class="form-control" readonly>
			</div>
			</div>
			
		  <div class="row">
			<div class="col-md-12">
			<label>Solution</label>
			<textarea class="form-control" id="solution"></textarea>
			<input type="hidden" id="grievance_id">
			</div>
			<div class="col-md-4">
			<label>Status</label>
			<select class="form-control" id="status">
			<option value="open">Open</option>
			<option value="close">Close</option>
			</select>
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success update">Update</button>
          <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
        </div>
      </div>
	  <!--</form>-->
      
    </div>
  </div>
  

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

var myTable = $('#grievance-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Grievance ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Grievance_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2],
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Grievance_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2],
				},
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					doc.content[1].margin = [ 100, 0, 100, 0 ] //left, top, right, bottom
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'left',
                        image: getBase64Image(myGlyph)
                    } );
					doc.content.splice( 1, 1, {
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: '',
						margin: [0, 0, 0, 0],
                    } );
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
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
    $('#department,#sem,#batch').change(function(){
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
		
		$('.edit').click(function(){
		var grievance_id=$(this).data('id');	
		var solution=$(this).data('solution');
		var status=$(this).data('status');
		var ica=$(this).data('ica');
		var internal=$(this).data('internal');
		var external=$(this).data('external');
		var thirdparty=$(this).data('thirdparty');
		var average=$(this).data('average');
		var mark_id=$(this).data('mark_id');
		$('#grievance_id').val(grievance_id);
		$('#solution').val(solution);
		$('#status').val(status);
		$('#ica').val(ica);
		$('#internal').val(internal);
		$('#external').val(external);
		$('#thirdparty').val(thirdparty);
		$('#average').val(average);
		$('#mark_id').val(mark_id);
		});
	
		$('.update').click(function(){
		var grievance_id=$('#grievance_id').val();
		var solution=$('#solution').val();
		var status=$('#status').val();
		var ica=$('#ica').val();
		var internal=$('#internal').val();
		var external=$('#external').val();
		var thirdparty=$('#thirdparty').val();
		var average=$('#average').val();
		var mark_id=$('#mark_id').val();
		var stream=$('#stream').val();
		 if (confirm('Are you sure to update Marks?')) {
            $.ajax({
                url: base_url + "coe/updateGrievance",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    grievance_id: grievance_id,solution: solution,status: status,mark_id: mark_id,ica: ica,internal: internal,external: external,thirdparty: thirdparty,average: average,stream: stream,
                },
                success: function (data) {
					$('#myModal .close').click();
                }
            });
					alert('Solution Updated Successfully!!');
		 }
		});
		
		$('.mark').on('input', function(){
		var mark = 0;
		var average = 0;
		var internal=$('#internal').val();
		var external=$('#external').val();
		var thirdparty=$('#thirdparty').val();
		var average=$('#average').val();
		
		var av_diff = Math.abs(internal - external);
		if(av_diff <= 15){average = (parseInt(internal) + parseInt(external)) / 2;}
		
		if(av_diff > 15 && thirdparty != 0 && thirdparty != ''){

       var arr = [internal, external];
       var goal = thirdparty; 
       var closest = arr.reduce(function(prev, curr) {
         return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
       });

       var average = (parseInt(closest) + parseInt(thirdparty)) / 2;
		}
		
	    $('#average').val(average);
		});
	});
	</script>