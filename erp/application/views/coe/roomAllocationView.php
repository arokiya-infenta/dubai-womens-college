
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
		  <div class="card-header"><i class="fa fa-table"></i>Room Allocation Update
		  <div class="row">
		  <?php 	$room = $this->db->where('id',$room1)->get('erp_rooms')->row();
					$block = $this->db->where('id',$room->block_id)->get('erp_blocks')->row();
						?>
		  <div class="col-sm-3">
		  <label>Batch</label>
		  <input type="text" class="form-control" value="<?=$batch1?>" id="batch" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Semester</label>
		  <input type="text" class="form-control" value="<?=$sem1?>" id="sem" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Section</label>
		  <input type="text" class="form-control" value="<?=$section1?>" id="section" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Block</label>
		  <input type="text" class="form-control" value="<?=$block->block_name?>" id="block2" readonly>
		  <input type="hidden" class="form-control" value="<?=$room->block_id?>" id="block" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Room</label>
		  <input type="text" class="form-control" value="<?=$room->room_name?>" id="room2" readonly>
		  <input type="hidden" class="form-control" value="<?=$room1?>" id="room" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Remaining Spaces</label>
		  <input type="text" class="form-control" id="remaining_spaces" readonly>
		  <input type="hidden" class="form-control" id="schedule_date" value="<?=$schedule_date1?>" readonly>
		  </div>
		  <div class="col-sm-3">
		  <label>Remaining Students</label>
		  <input type="text" class="form-control" id="remaining_students" readonly>
		  <input type="hidden" class="form-control" id="subject" value="<?=$subject1?>" readonly>
		  </div>
		  <div class="col-sm-3 mt-4">
		  <div class="form-group" style="float:right;">
				 <a href="<?=base_url().'coe/roomAllocation'?>">
			<button type="button" class="btn btn-sm btn-secondary">Back</button></a>
		         </div>
		  </div>
		  </div>
		  </div>
            <div class="card-body">
			
			<?php $arrear_stu = $this->db->where('applied_year',$batch1)->where('sem',$sem1)->where('room_id',$room1)->where('section',$section1)->get('erp_rows_cols_arrear')->num_rows();
			?>
			<div class="row">
			<div class="col-lg-3">
			<p style="font-weight:bold;font-size:15px;">Arrear Students: <?=$arrear_stu?></p>
			</div>
			</div>
			<br/>
			<div class="table-responsive">
			<form id="myForm" action="<?=base_url().'coe/roomAllocationEdit'?>" method="post">
              <table id="roomview-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Department</th>
                        <th>No of Students</th>
                        <!--<th>Add Students</th>-->
                        <th>Subject</th>
						<td>Action</td>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($room_list)){
						$sno=1;
					foreach ($room_list as $roomlist) {
						$dept = $this->db->where('main_id',$roomlist->main_id)->where('cour_id',$roomlist->course_id)->get('department_details')->row();
						$subj = $this->db->where('id',$roomlist->subject_id)->get('erp_subjectmaster')->row();
					?>
                      <tr>
                        <td><?=$sno?></td>
                        <td><?=$dept->short_name?></td>
						<td><?=$roomlist->total_students?>
						<input type="hidden" class="form-control" name="main_id_<?=$sno?>" value="<?=$roomlist->main_id?>">
						<input type="hidden" class="form-control" name="course_id_<?=$sno?>" value="<?=$roomlist->course_id?>">
						<input type="hidden" class="form-control" name="sem_<?=$sno?>" value="<?=$roomlist->sem?>">
						<input type="hidden" class="form-control" name="batch_<?=$sno?>" value="<?=$roomlist->batch_year?>">
						<input type="hidden" class="form-control" name="section_<?=$sno?>" value="<?=$roomlist->section?>">
						<input type="hidden" class="form-control" name="block_id_<?=$sno?>" value="<?=$roomlist->block_id?>">
						<input type="hidden" class="form-control" name="room_id_<?=$sno?>" value="<?=$roomlist->room_id?>">
						<input type="hidden" class="form-control" name="subject_<?=$sno?>" value="<?=$roomlist->subject_id?>">
						<input type="hidden" class="form-control" name="schedule_date_<?=$sno?>" value="<?=$roomlist->schedule_date?>">
						<input type="hidden" class="form-control remaining_spaces" name="remaining_spaces_<?=$sno?>">
						<input type="hidden" class="form-control remaining_students" name="remaining_students_<?=$sno?>">
						<input type="hidden" class="form-control" name="edit_id_<?=$sno?>" value="<?=$roomlist->id?>">
						<input type="hidden" class="form-control val" name="val[]">
						</td>
						<!--<td>
						<input type="text" class="form-control" id="no_of_students_<?=$sno?>" name="no_of_students" required>
						</td>-->
						<td><?=$subj->subName?></td>
						<td>
						<button type="button" data-sno="<?=$sno?>" data-main_id="<?=$roomlist->main_id?>" data-course_id="<?=$roomlist->course_id?>" data-sem="<?=$roomlist->sem?>" data-batch_year="<?=$roomlist->batch_year?>" data-section="<?=$roomlist->section?>" data-block_id="<?=$roomlist->block_id?>" data-subject="<?=$roomlist->subject_id?>" data-room_id="<?=$roomlist->room_id?>" class="btn btn-sm btn-warning edit">Edit</button>
						<a href="<?=base_url(). 'coe/roomAllocationDelete/'.$roomlist->main_id.'/'.$roomlist->course_id.'/'.$roomlist->sem.'/'.$roomlist->batch_year.'/'.$roomlist->section.'/'.$roomlist->room_id.'/'.$roomlist->subject_id.'/'.$roomlist->schedule_date?>">
						<button type="button" class="btn btn-sm btn-danger" onClick="return confirm('Are you sure to Delete for the subject?')">Delete</button></a>
						</td>
                    </tr>
                    <?php $sno++;}} ?>
                 
               
                </tbody>
            </table>
			</form>
            </div>			
		
			</div>
		   </div>
         </div>
        </div>		 
			
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

var myTable = $('#roomview-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Room Allocation ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Room Allocation_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
              }
				 }
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Room Allocation_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
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


        $(document).ready(function(){
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = $('#batch').val();	
		  var sem = $('#sem').val();	
		  var section = $('#section').val();	
		  var schedule_date = $('#schedule_date').val();	
			if (room_id!='' && batch_id!='' && sem!='' && section!='' && schedule_date!='') {
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
                    schedule_date: schedule_date,
                },
                success: function (data) {
					$('#remaining_spaces').val(data);
					$('.remaining_spaces').val(data);
                }
            });
        }
		
		  var room_id = $('#room').val();	
		  var block_id = $('#block').val();	
		  var batch_id = $('#batch').val();	
		  var sem = $('#sem').val();		
		  var subject = $('#subject').val();
		  var stream = $('#stream').val();
		  var department = $('#department').val();
			if (batch_id!='' && sem!='' && subject!='' && subject!=null) {
            $.ajax({
                url: base_url + "coe/getRemainingStudentsSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch_id: batch_id,
                    sem: sem,
                    subject: subject,
                    stream: stream,
                    department: department,
                },
                success: function (data) {
					$('#remaining_students').val(data);
					$('.remaining_students').val(data);
                }
            });
        }
		});
		

      /* $('.edit').click(function(e){
		   //e.preventDefault();
		  var sno = $(this).data('sno');
		  var remaining_spaces = $('#remaining_spaces').val();	
		  var no_of_students = $('#no_of_students_'+sno+'').val();
		  
		  var main_id = $(this).data('main_id');
		  var course_id = $(this).data('course_id');
		  var batch_year = $(this).data('batch_year');
		  var section = $(this).data('section');
		  var block_id = $(this).data('block_id');
		  var room_id = $(this).data('room_id');
		  var sem = $(this).data('sem');
		  var subject = $(this).data('subject');
						
          if(remaining_spaces > 0){		  
			if (no_of_students > remaining_spaces) {
			e.preventDefault();
			alert('Please Select No. of Students less than or equal to Remaining Spaces!!');
        }
		else{
			if (no_of_students=='' || no_of_students == 0) {
			e.preventDefault();
			alert('Please Select Suitable Sudents to Add!!');
			}else{
            $.ajax({
                url: base_url + "coe/roomAllocationEdit1",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                    room_id: room_id,
                    batch: batch_year,
                    sem: sem,
                    section: section,
                    stream: main_id,
                    department: course_id,
                    subject: subject,
                    no_of_students: no_of_students,
                },
                success: function (data) {
					alert('Edited Successfully!!');
					location.reload();
                }
            });
			}
		}
		  }else{
			  e.preventDefault();
			  alert('There is no Remaining Space in this Room!!');
		  }
		});	*/	
		
		$('.edit').click(function(e){
			var value = $(this).data('sno');
			$(this).closest('tr').find('.val').val(value);
			$('#myForm').submit();
			});
			
	});
	</script>