
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
		  <div class="card-header"><i class="fa fa-table"></i>Certificate Course Report</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-2">
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
			  <?php if(isset($subject)){ 
				  foreach($subject as $subject){  ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  <?php $subj=$this->db->where('id',$subject1)->get('erp_certificate_course')->row();
			  $dept=$this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row();
			  if(isset($subj)){ ?>
			  <input type="hidden" id="subject_name" value="<?=$subj->subName?>">
			  <input type="hidden" id="subject_code" value="<?=$subj->subCode?>">
			  <?php } if(isset($dept)){ ?>
			  <input type="hidden" id="dept" value="<?=$dept->comp_name?>">
			  <?php } ?>
			  </div>
				 <div class="col-lg-1 mt-4">
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
              <table id="certificateCourse-report" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Reg No.</th>
                        <th>Completion Status</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_cert_coursemark')->row();
						$checked1='Not Completed';
						if(isset($mark_det)){
						if($mark_det->status==1){$checked1='Completed';}
						}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->reg_no_?></td>
						<td> <?=$checked1?>
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
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
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
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
	var date = $('#date').val();
	
 var subject_name_a = $('#subject_name').val();	
 var subject_code_a = $('#subject_code').val();	
 var batch_a = $('#batch').val();	
 var dept_a = $('#dept').val();	
		var myTable = $('#certificateCourse-report'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: ''+subject_name_a+'_ ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+subject_name_a+'_ '+currentDate+'',
				orientation:'landscape'
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+subject_name_a+'_ '+date+'',
				//exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5, 6]
                //  }
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
				   
				   doc.styles.tableHeader.fontSize = 8;    
				   doc.defaultStyle.alignment = 'center';
				   doc.styles.tableHeader.alignment = 'center';
				   var rowCount = doc.content[1].table.body.length;
                     for (i = 1; i < rowCount; i++) {
                       doc.content[1].table.body[i][1].alignment = 'left';
                       doc.content[1].table.body[i][2].alignment = 'left';
				       doc.content[1].table.body[i][2].uppercase = true;
                     };
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 12; };
                        objLayout['paddingRight'] = function(i) { return 12; };
                        objLayout['paddingTop'] = function(i) { return 12; };
                        objLayout['paddingBottom'] = function(i) { return 12; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					
					doc.content.splice(1, 1, {
                        margin: [ 0, 10, 0, 0 ],
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [  {text: 'DEPARTMENT: \t'+dept_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n BATCH:  \t\t\t\t'+batch_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n SUBJECT CODE:  '+subject_code_a+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n SUBJECT NAME: '+subject_name_a+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
					
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
		

                },
			}],
			  'columnDefs': [ {
                'targets': [0,1,2,3], // column index (start from 0)
            }]
		} );
		
var allPages = myTable.rows().nodes().to$();
	});
	</script>