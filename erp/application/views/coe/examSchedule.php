
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
		  <div class="card-header"><i class="fa fa-table"></i>Exam Schedule</div>
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
			<span style="color:red;"><?=form_error('batch')?></span>
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
			<span style="color:red;"><?=form_error('stream')?></span>
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
			<span style="color:red;"><?=form_error('department')?></span>
		         </div>
				 <!--<div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			<span style="color:red;"><?=form_error('subject')?></span>
			  </div>-->
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('sem')?></span>
			  </div>
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
			
	  
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
			   <div class="col-lg-12">
			   <div class="form-group text-right">
			   <a href="<?=base_url().'coe/examScheduleAdd'?>">
			   <button class="btn btn-sm btn-warning">Add Date</button>
			   </a>
			   </div>
			   </div>
			  </div> 
			</div>
            <div class="card-body">
			<div class="row">
			<div class="col-lg-12">
			<div class="form-group">
			<form action="<?=base_url()?>coe/examSchedulePDF" method="post">
			<button class="btn btn-sm btn-success">Generate PDF</button>
			<input type="hidden" name="stream" value="<?=$stream?>">
			<input type="hidden" name="department" value="<?=$department?>">
			<input type="hidden" name="sem" value="<?=$sem1?>">
			<input type="hidden" name="batch" value="<?=$batch1?>">
			</form>
			</div>
			</div>
			</div>
              <div class="table-responsive">
              <table id="examsched-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
						<th>Subject Code</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Section</th>
						<th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($date_list)){
						$sno=1;
					foreach ($date_list as $date) {
						$subj = $this->db->where('id',$date->subject_id)->get('erp_subjectmaster')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$subj->subCode?></td>
                        <td><?=$subj->subName?></td>
						<td><?=date('d-m-Y',strtotime($date->schedule_date))?></td>
						<td><?=$date->section?></td>
						<td>
						<button class="btn btn-sm btn-warning update" data-id="<?=$date->id?>" data-toggle="modal" data-target="#largesizemodal">Edit</button>
						<a href="<?=base_url(). 'coe/examScheduleDelete/'.$date->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>
						</td>
                    </tr>
                    <?php }} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <!-- End Row-->
	  
	  
	  
	  <!-- Modal -->
             <form action="" method="post">
                <div class="modal fade" id="largesizemodal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Exam Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
					  	
              <div class="row">
                         <div class="col-sm-4">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Closing Date</label>
                    <input type="date" class="form-control" id="date_edit" name="schedule_date" required>
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                    <input type="hidden" class="form-control" id="batch_edit" name="batch" value="<?=$batch1?>">
                    <input type="hidden" class="form-control" id="sem_edit" name="sem" value="<?=$sem1?>">
                    <input type="hidden" class="form-control" id="stream_edit" name="stream" value="<?=$stream?>">
                    <input type="hidden" class="form-control" id="department_edit" name="department" value="<?=$department?>">
                  </div>
                </div>
				<div class="col-sm-4">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Section</label>
                    <select class="form-control" id="section_edit" name="section" required>
			  <option value="">Select Section</option>
			  <?php $section = array('Forenoon','Afternoon');
			  foreach($section as $section){ ?>
			  <option value="<?=$section?>"><?=$section?></option>
			  <?php } ?>
			  </select>
                  </div>
                </div>
						</div> 
						
						
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_edit"><i class="fa fa-check-square-o"></i> Edit Date</button>
                      </div>
                    </div>
                  </div>
                </div>
				</form>
				<!-- Modal Ends -->
				

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
	
var myTable = $('#examsched-datatable').DataTable();

/*var myTable = $('#examsched-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Exam Schedule ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Exam Schedule_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4],
				 format: {
				header: function ( data, columnIdx ) {
                                return data.toUpperCase();
                            },
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
				filename: 'Exam Schedule_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
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
		});*/
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
		
		$('.update').click(function(){
		  var id = $(this).data('id');		
            $.ajax({
                url: base_url + "coe/examScheduleUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id
                },
                success: function (data) {
					dataParse = JSON.parse(data);
					var schedule_date = dataParse.schedule_date;
					var section_edit = dataParse.section;
					var edit_id = dataParse.id;
					$('#date_edit').val(schedule_date);
					$('#edit_id').val(edit_id);
					$('#section_edit').val(section_edit);
                }
            });
		});
	});
	</script>