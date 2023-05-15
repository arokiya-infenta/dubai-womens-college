
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
		  <div class="card-header"><i class="fa fa-table"></i>Feedback Subject Report</div>
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
			<?php if($department != ''){$dept1 = $this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row();  ?>
			<input type="hidden" value="<?=$dept1->comp_name?>" id="dept">
			<input type="hidden" value="<?=$dept1->short_name?>" id="dept_sh">
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
			
	  <?php if(isset($feedbacks)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="feedback-subject-all" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Components</th>
						<?php 
						foreach($subject as $subject1){
						$employee = $this->db->select('em.emp_name_ as name')->join('erp_employee_master em','em.id=es.employee_id')->where('subject_id',$subject1->id)->get('erp_employee_subject es')->row();
				        $emp_name = '';
						if(isset($employee)){
				        $emp_name = $employee->name;}
						$sub1 = $this->db->where('id',$subject1->id)->get('erp_subjectmaster')->row();
                        $subName = $sub1->subName;						 
                        $subCode = $sub1->subCode;						 
							?>
                        <th><?=$subName?><br><?=$subCode?><br><?=$emp_name?></th>
						<?php } ?>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach ($feedbacks as $feedbacks) {
					?>
                      <tr>
                        <td><?=$sno?></td>
                        <td><?=$feedbacks->name?></td>
						<?php  
						foreach($subject as $subject2){
						
						$fbsum = 0;
						$fbtot = 0;
						$avg = 0;
						$fb_sum = $this->db->select('SUM(fr_'.$sno.') as sum')->where('fr_subject_id',$subject2->id)->get('feedback_course_report')->row();
						$fbtot = $this->db->where('fr_subject_id',$subject2->id)->get('feedback_course_report')->num_rows();
						$fbsum = $fb_sum->sum;
						if($fbtot!=0){
						$avg = $fbsum / $fbtot;}
							?>
                        <td><?=$avg?></td>
						<?php } ?>
                    </tr>
						<?php $sno++;} ?>
                 
               
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
var myTable = $('#exammarks-datatable').DataTable();
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
                url: base_url + "principal/getProgram",
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
                url: base_url + "principal/getSubjSemwise",
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
	
 var sem_f = $('#sem').val();
 var batch_f = $('#batch').val();	
 var dept_f = $('#dept').val();	
 var dept_short = $('#dept_sh').val();	
		$('#feedback-subject-all'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+dept_short+'_ '+currentDate+'',
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
				   //doc.content[1].table.widths = [ '5%', '30%'];
				   var rowCount = doc.content[1].table.body.length;
                     for (i = 1; i < rowCount; i++) {
                       doc.content[1].table.body[i][1].alignment = 'left';
                     };
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .19; };
                        objLayout['vLineWidth'] = function(i) { return .19; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .17; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					
					doc.content.splice( 1, 1, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: 'Feedback Course Report',
						margin: [0, 0, 0, 0],
                    } );
					
                    doc.content.splice(2, 0, {
                        margin: [ 0, 10, 0, 0 ],
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: [ {text: 'Department: '+dept_f+'', bold: true, fontSize: 10, margin: 30} ],
                    });
					
					 doc.content.splice(3, 0, {
                        margin: [ 0, 10, 0, 0 ],//left, top, right, bottom
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [ {text: 'Batch: '+batch_f+' Batch', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t Semester: '+sem_f+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
					
					doc.content.splice(4, 0, {

                        table: {
                            widths: ['*'],
                            body: [
                                [
                                    {text: '1 - Excellent 2 - Good 3 - Satisfactory 4 - Poor', background: '#fff'}]
                            ]
                        },

                        margin: [0, 0, 0, 0],
                        alignment: 'center'
                    });
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Copyright '+fullDate.getFullYear()+', iStudio Technologies Pvt Ltd.',
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
				exportOptions: {
                 
				 stripHtml: false,
				 stripNewlines: false,
                 format: {
                   header: function ( data, columnIdx ) {
					   data = data.replace(/<.*?>/g, "\n");
                   return data.toUpperCase();
                   },
				   body: function ( data, row, column, node ) {
				   data = data.replace(/<.*?>/g, "");
                   return data;
                   }
                 },

                 modifier: {
                   pageMargins: [0, 0, 0, 0], // try #3 setting margins
                   margin: [0, 0, 0, 0], // try #4 setting margins
                   alignment: 'center'
                   },
                }
			}]
		} );
	});
	</script>