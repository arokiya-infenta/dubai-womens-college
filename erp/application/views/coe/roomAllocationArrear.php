
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
			<select class="form-control" name="applied_batch" id="applied_batch" required readonly>
			<?php $year = date('Y');
			$applied_batch = $this->db->where('batch_from',$year)->get('erp_batchmaster')->result();
			foreach($applied_batch as $applied_batch){?>
			<option value="<?=$applied_batch->batch_from?>" <?php if($applied_batch1==$applied_batch->batch_from){echo 'selected';}?>><?=$applied_batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			   <div class="col-lg-3">
			<label>Student Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php //$year = date('Y');
			//$batch = $this->db->where('batch_from',$year)->get('erp_batchmaster')->result();
			$batch = $this->db->get('erp_batchmaster')->result();
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
			  <option value="<?=$subject->subCode?>" <?php if($subject1==$subject->subCode){echo 'selected';}?>><?=$subject->subName?></option>
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
              <table id="arrearallot-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
						<th>Batch</th>
                        <th>Name</th>
                        <th>Reg No.</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>

                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$student_det = $this->db->where('id',$student->student_id)->get('erp_existing_students')->row();
						$block = $this->db->get('erp_blocks')->result();

						$sub_sched = $this->db->select('a.*,b.subCode')->join('erp_subjectmaster b','a.subject_id=b.id')->where('a.batch_year',$batch1)->where('a.sem',$sem1)->where('b.subCode',$subject1)->get('erp_exam_schedule a')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
						<td><?=$student->student_batch?></td>
                        <td><?=$student_det->student_name_?></td>
                        <td><?=$student_det->reg_no_?></td>
						<td>
							<?php if(isset($sub_sched)){ ?>
							<?php $seat = $this->db->where('applied_year',$year)->where('student_id',$student->student_id)->get('erp_rows_cols_arrear')->row();
							if(!isset($seat)){ ?>
							<button data-subject="<?=$student->subject_id?>" data-student="<?=$student->student_id?>" class="btn btn-sm btn-success" data-target="#myModal" data-toggle="modal" id="allct">Allocate</button>
							<?php } else { 
							$block = $this->db->where('id',$seat->block_id)->get('erp_blocks')->row();
							$room = $this->db->where('id',$seat->room_id)->get('erp_rooms')->row();
							?>
							<p style="font-weight:bold;"><?=$block->block_name?> / <?=$room->room_name?> (<?=$seat->rows .'-'. $seat->columns?>)</p>
							<?php }} else { ?>
							<p style="font-weight:bold;">Exam not scheduled!</p>
							<?php } ?>	
						</td>
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

	  <!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Allocate Room</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-3">
			<label>Session</label>
			<select class="form-control rem" id="section">
			    <option value="">Select Session</option>
			    <option value="Forenoon">Forenoon</option>
				<option value="Afternoon">Afternoon</option>
			</select>
			</div>
			<div class="col-md-3">
			<label>Block</label>
			<select class="form-control block" id="block">
			    <option value="">Select Block</option>
				<?php foreach($block as $block){ ?>
				<option value="<?=$block->id?>"><?=$block->block_name?></option>
				<?php } ?>
			</select>
			<input type="hidden" id="student_id">
			<input type="hidden" id="subject_id">
			</div>
			<div class="col-md-3">
			<label>Room</label>
			<select class="form-control room rem" id="room">
			    <option value="">Select Room</option>
			</select>
			</div>
			<div class="col-md-3">
			<label>Row</label>
			<select class="form-control" id="row">
			    <option value="">Select Row</option>
			</select>
			</div>
			<div class="col-md-3">
			<label>Column</label>
			<select class="form-control" id="column">
			    <option value="">Select Column</option>
			</select>
			</div>
			<div class="col-md-3">
			<label>Remaining Space</label>
			<input class="form-control" type="text" id="remaining_spaces" readonly>
			</div>
			<div class="col-md-3">
			<label>Seater</label>
			<input class="form-control" type="text" id="seater" readonly>
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success" id="allocate_room">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal Ends-->

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

var myTable = $('#arrearallot-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Arrear Allocation ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Arrear Allocation_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
				  if(colidx != 4){
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
               }else{
				   if ($(node).children("p").length > 0) {
                  return $(node).children("p").first().text();
                } 
			   }
			  }
				 }
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Arrear Allocation_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
				  if(colidx != 4){
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
               }else{
				   if ($(node).children("p").length > 0) {
                  return $(node).children("p").first().text();
                } 
			   }
              }
				 }
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
    $('#department,#sem,#batch,#stream').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();
		  var sem = $('#sem').val();	
			if (stream!='' && department!='' && batch!='' && sem!='') {
            $.ajax({
                url: base_url + "coe/getSubjCodeSemwise",
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
		$('.block').change(function(){
			var block_id = $(this).val();
			$('#room').empty();
			var ele = $(this);	
			ele.closest('tr').find('.room').empty();
			if (block_id!='') {
            $.ajax({
                url: base_url + "coe/getRooms",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id
                },
                success: function (data) {
					$('#room').append(data);
                }
            });
        }
		});

		$('#room').change(function(){
			$('#row').empty();	
			$('#column').empty();					
		  var room_id = $(this).val();	
			if (room_id!='') {
            $.ajax({
                url: base_url + "coe/getRowsCols",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    room_id: room_id,
                },
                success: function (data) {
					var dataRead = JSON.parse(data);
					var rows = dataRead.rows;
					var cols = dataRead.cols;
					var seater = dataRead.seater;
					$('#row').append(rows);
					$('#seater').val(seater);
					$('#column').append(cols);
                }
            });
        }
		});

		$('#allocate_room').click(function(){
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = '<?=$batch1?>';	
		  var sem = '<?=$sem1?>';	
		  var subject = $('#subject_id').val();
		  var stream = '<?=$stream?>';	
		  var department = '<?=$department?>';	
		  var section = $('#section').val();
		  var row = $('#row').val();
		  var column = $('#column').val();	
		  var rem_space = $('#remaining_spaces').val();
		  var student_id = $('#student_id').val();
		  var applied_batch = $('#applied_batch').val();
			if (room_id!='' && batch_id!='' && section!='' && row!='' && column!='' && applied_batch!='') {
				if(rem_space > 0){
            $.ajax({
                url: base_url + "coe/arrearRoomAllocate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                    room_id: room_id,
                    batch: batch_id,
                    sem: sem,
                    section: section,
					row: row,
					column: column,
					stream: stream,
					department: department,
					subject: subject,
					student_id: student_id,
					applied_batch: applied_batch,
                },
                success: function (data) {
					alert('Room Allocated Successfully!!');
					$('#myModal').modal('hide');
                }
            });
		}else{
			alert('No enough space in the room!!');
		}
        }else{
			alert('Please select all the fields!!');
		}
		});

		$('.rem').change(function(){
			$('#remaining_spaces').val('');
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = '<?=$batch1?>';	
		  var sem = '<?=$sem1?>';	
		  var section = $('#section').val();	
			if (room_id!='' && batch_id!='' && sem!='' && section!='') {
            $.ajax({
                url: base_url + "coe/getRemainingSpaces",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                    room_id: room_id,
                    batch_id: batch_id,
                    sem: sem,
                    section: section,
                },
                success: function (data) {
					$('#remaining_spaces').val(data);
                }
            });
        }
		});

		$('#allct').click(function(){
			var stu_id = $(this).data('student');
			var sub_id = $(this).data('subject');
			$('#student_id').val(stu_id);
			$('#subject_id').val(sub_id);
		});
		
		

	});
	</script>