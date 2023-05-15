<style>
input[type=checkbox] {
	height:25px;width:25px;
}
</style>
    <div id="page-wrapper">
	<div class="row">
<?php if($this->session->flashdata('error')!="") {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
</div>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Student Attendence Report</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Attendence Information
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
               <form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
                 <div class="col-lg-3">
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream1=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream1=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream1=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream1=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream1=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department1)){ $dept = $this->db->where('main_id',$stream1)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department1==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
			<?php if($department1!=''){$deptm = $this->db->where('main_id',$stream1)->where('cour_id',$department1)->get('department_details')->row(); $deptname = $deptm->comp_name;}else{$deptname = '';} ?>
			<input type="hidden" value="<?=$deptname?>" id="dept">
		         </div>
				 <div class="col-lg-3">
			<input type="date" class="form-control" value="<?=$date1?>" name="date" id="date">
		         </div>
				 <div class="col-lg-12">
				 <div class="form-group" style="float:right;margin-top:10px;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
		        </div>
            </form>	
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
		<!-- End Row -->
		
		<?php if(isset($stu_list)){?>
		<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Student Attendence List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <?php  if(sizeof($stu_list) > 0) { ?>
<div class="table-responsive">
 <table id="attendance-report" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Application No.</th>
                        <th>Attendence</th>
                        <th>OutPass</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php $sno=1;
					foreach ($stu_list as $student) {
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->as_name?></td>
                        <td><?=$student->as_app_number?></td>
						<?php if($student->isAbsence==1){$check='P';}else{$check='A';}?>
                        <td><?=$check?></td>
						<?php if($student->isLeave==1){$check1='Yes';}else{$check1='No';}?>
                        <td><?=$check1?></td>
                    </tr>
                    <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Student Data Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
		<?php } ?>

    </div>
    <!-- /#page-wrapper -->


<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
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
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
var batch_a = '<?=$batch1?>';	
var date_a = '<?=$date1?>';	
 var dept_a = $('#dept').val();		
var myTable = $('#attendance-report'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: ''+batch_a+'_'+dept_a+'_ '+currentDate+'',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+batch_a+'_'+date_a+'_ '+currentDate+'',
				orientation:'landscape'
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+batch_a+'_'+date_a+'_ '+currentDate+'',
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
			}]
		} );
var allPages = myTable.rows().nodes().to$();
		
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "hosteladminlogin/getProgram",
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
	});
	</script>
