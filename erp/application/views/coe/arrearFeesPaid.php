
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
		  <div class="card-header"><i class="fa fa-table"></i> Arrear Fees Paid Details</div>
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
			  <?php if($subject1!=''){ $subdet = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();?>
			  <input type="hidden" value="<?=$subdet->subCode?>" id="subcode">
			  <input type="hidden" value="<?=$subdet->subName?>" id="subname">
			  <?php } ?>
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
              <table id="exammarksavgarr-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Register No.</th>
                        <th>Subjects</th>
                        <th>status</th>
                       
                       
                    </tr>
                </thead>
                <tbody> 
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						//$subjects = explode(',',$student->ef_arr_exam);
						$get_subject = $this->db->join('erp_arrear_detail a','a.subject_id=s.id')->where('a.student_id',$student->stuid)->where('a.applied_year',$applied_year1)->where('s.id',$subject1)->get('erp_subjectmaster s')->row();
						$subj = array();
						$get_sub = '';
						/*if(sizeof($get_subject)>0){
						foreach ($get_subject as $sub) {
							array_push($subj,$sub->subName);
						}
						$get_sub = implode(',',$subj);
							}*/
						if(isset($get_subject)){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->reg_no_?></td>
                        <td><?=$get_subject->subName?></td>
                        <td style="color: green">Paid</td>
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
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#exammarksavgarr-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Arrear Fees Paid - ' + $('#subname').val() + ' - ' + $('#subcode').val() + ' - ' + $('#applied_year').val() + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Arrear Fees Paid_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4],
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
				filename: 'Arrear Fees Paid_'+currentDate+'',
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
                        text: 'Arrear Fees paid - ' + $('#subname').val() + ' - ' + $('#subcode').val() + ' - ' + $('#applied_year').val() + '',
						margin: [-100, 0, 100, 0],
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
		
	});
	</script>