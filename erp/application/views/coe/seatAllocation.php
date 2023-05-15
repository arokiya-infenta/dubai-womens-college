
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
		  <div class="card-header"><i class="fa fa-table"></i>Seat Arrangement</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-2">
			<label>Batch</label>   
			<select class="form-control rem" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
				 <div class="col-lg-2">
			<label>Semester</label>   
			  <select class="form-control rem" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('sem')?></span>
			  </div>
				 <div class="col-lg-2">
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
			<select class="form-control rem" name="department" id="department" required>
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
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  </div>
			  <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
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
		  <div class="row">
        <div class="col-lg-12">
			<div class="form-group" style="float:right;">
			<button type="button" class="btn btn-sm btn-warning" id="allocate">Allocate Seat</button>
			</div>
			</div>
			</div>
			</div>
            <div class="card-body">
			<div>
			        <input type="hidden" id="batch11" value="<?=$batch1?>">
					<input type="hidden" id="stream11" value="<?=$stream?>">
					<input type="hidden" id="department11" value="<?=$department?>">
					<input type="hidden" id="sem11" value="<?=$sem1?>">
					<input type="hidden" id="subject11" value="<?=$subject1?>">
			</div>
              <div class="table-responsive">
              <table id="seatallot-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Register No</th>
                        <th>Block</th>
                        <th>Room</th>
                        <th>Section</th>
                        <th>Seat No</th>
                        <th>Rows</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					for($i=0; $i<sizeof($stu_list); $i++){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stu_list[$i]->student_name_?></td>
                        <td><?=$stu_list[$i]->reg_no_?></td>
						<?php 
						if(isset($seat_det[$i])){
						?>
						<td><?=$seat_det[$i]['block_name']?></td>
						<td><?=$seat_det[$i]['room_name']?></td>
						<td><?=$seat_det[$i]['section']?></td>
						<td><?=$seat_det[$i]['seat_no']?></td>
						<td><?= 'Row - ' . $seat_det[$i]['row_list'] . ' Column - ' . $seat_det[$i]['col_list']?>
						<input type="hidden" class="stu" value="<?=$stu_list[$i]->id?>">
						<input type="hidden" class="block_id" value="<?=$seat_det[$i]['block_id']?>">
						<input type="hidden" class="room_id" value="<?=$seat_det[$i]['room_id']?>">
			            <input type="hidden" class="section" value="<?=$seat_det[$i]['section']?>">
			            <input type="hidden" class="rows" value="<?=$seat_det[$i]['row_list']?>">
			            <input type="hidden" class="cols" value="<?=$seat_det[$i]['col_list']?>">
			            <input type="hidden" class="seat_no" value="<?=$seat_det[$i]['seat_no']?>">
						</td>
						<?php } else { ?>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td style="font-weight:bold;font-size:12px;">Room has not been allocated yet for the subject</td>
						<?php } ?>
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
	var fullDate = new Date();
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#seatallot-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Seat Allocation ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Seat Allocation_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4, 5, 6, 7],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
				  if(colidx != 7){
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
               }else{
			   return inner.replace(/<input[^>]*>|<\/input>/gi, ""); ;
			   }
			  }
				 }
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Seat Allocation_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
				  if(colidx != 7){
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
               }else{
			   return inner.replace(/<input[^>]*>|<\/input>/gi, ""); ;
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
    //$('#department').change(function(){
    $('.rem').change(function(){
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
		/*else{
			alert('Select all the fields');
		}*/
		});	
		
		$('#allocate').click(function(){
			if(confirm('Are you sure to allocate the seats?')){
		  var stream = $('#stream11').val();	
		  var department = $('#department11').val();	
		  var batch = $('#batch11').val();	
		  var sem = $('#sem11').val();	
		  var subject = $('#subject11').val();	
		  var section = $('.section').val();	
			var ids_student = Array();	
			var ids_block = Array();	
			var ids_room = Array();	
			var ids_rows = Array();	
			var ids_cols = Array();	
			var ids_seat = Array();	
		$("input[class=stu]",allPages).each(function () {
	ids_student.push($(this).val());
	});	
	$("input[class=block_id]",allPages).each(function () {
	ids_block.push($(this).val());
	});	
	$("input[class=room_id]",allPages).each(function () {
	ids_room.push($(this).val());
	});	
	$("input[class=rows]",allPages).each(function () {
	ids_rows.push($(this).val());
	});	
	$("input[class=cols]",allPages).each(function () {
	ids_cols.push($(this).val());
	});
    $("input[class=seat_no]",allPages).each(function () {
	ids_seat.push($(this).val());
	});	
	
	if (stream!='' && department!='' && batch!='' && sem!='' && subject!='') {
	    $.ajax({
                url: base_url + "coe/allocateSeat",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                    subject: subject,
                    student: ids_student,
                    block: ids_block,
                    room: ids_room,
                    section: section,
                    rows: ids_rows,
                    columns: ids_cols,
                    seat_no: ids_seat,
                },
                success: function (data) {
					alert('Seats Allocated Successfully!!');
					location.reload();
                }
            });
	}else{
		alert('Please select all the fields!!');
	}
			}
	  });
	
	});
	</script>