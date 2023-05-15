
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Seat Alocation</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Student's Seat Alocation
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="deposit" action="<?=base_url()?>hosteladminlogin/listSeatAllocation"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                <div class="row">
                                    <div class="col-lg-12">
									<div class="col-lg-4">
              <label>Batch</label>
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>"><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
                 <div class="col-lg-4">
                <label>Stream</label>
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-4">
                 <label>Department</label>
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			</select>
		         </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Student Name</label>
                                                <select class="form-control" name="person" required="" id="person">
                                                    <?php //echo $output;?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Block No</label>
                                                <select class="form-control" name="blockNo" required="">
                                                    <?php echo $output1;?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Room No</label>
                                                <select class="form-control" name="roomNo" required="">
                                                    <?php echo $output2;?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Monthly Rent</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Monthly Rent" class="form-control" name="mrent" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                            </div>

                                        </div>
                                        <div class="col-lg-5">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                            <hr />
							<form name="deposit" action="<?=base_url()?>hosteladminlogin/listSeatAllocation"  accept-charset="utf-8" method="post" enctype="multipart/form-data">
							<div class="row">
							<div class="col-lg-12">
						<div class="col-lg-3">
			<select class="form-control" name="batch" id="batch1" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
                 <div class="col-lg-3">
			<select class="form-control" name="stream" id="stream1" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream1=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream1=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream1=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream1=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream1=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
			<?php if($department1!=''){$deptm = $this->db->where('main_id',$stream1)->where('cour_id',$department1)->get('department_details')->row(); $deptname = $deptm->comp_name;}else{$deptname = '';} ?>
			<input type="hidden" value="<?=$deptname?>" id="dept">
		         </div>
				 <div class="col-lg-3">
			<select class="form-control" name="department" id="department1" required>
			<option value="">Select Department</option>
			<?php if(isset($department1)){ $dept = $this->db->where('main_id',$stream1)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department1==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-2">
                  <div class="form-group ">
                    <button type="submit" class="btn btn-success" name="btnList" ><i class="fa fa-2x fa-check"></i>Submit</button>
                   </div>
                   </div>
						</div>
						</div>
						</form>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php  if(isset($seat_list)) {if(sizeof($seat_list) > 0) { ?>
<div class="table-responsive">
 <table id="seatList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Name</th>
                                            <th>Block No</th>
                                            <th>Room No</th>
                                            <th>Monthly Rent</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($seat_list as $row ) { $isData="1";
	  $room = $this->db->where('roomID',$row->roomNo)->get('rooms')->row();
	  $block = $this->db->where('blockID',$row->blockNo)->get('blocks')->row();
	  ?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$block->blockNo?></td>
                <td><?=$room->roomNo?></td>
                <td><?=$row->monthlyRent?></td>
				<td><a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/updateSeatAllocation/".$row->userId?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteSeatAllocation/".$row->userId?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Seats Not Found!!!</h1>";
                             }
							 ?>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->


<?php include('./../../footer.php'); ?>
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function() {
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
 var dept_a = $('#dept').val();		
var myTable = $('#seatList'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: ''+batch_a+'_'+dept_a+'_ '+currentDate+'',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+batch_a+'_'+dept_a+'_ '+currentDate+'',
				orientation:'landscape'
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+batch_a+'_'+dept_a+'_ '+currentDate+'',
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
			$('#person').empty();
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
		
		$('#stream1').change(function(){
			$('#department1').empty();
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
					$('#department1').append(data);
                }
            });
        }
		});
		
					
	$('#stream,#department,#batch').change(function(){
			$('#person').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "hosteladminlogin/getStudents",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                },
                success: function (data) {
					$('#person').append(data);
                }
            });
        }
		});

    });



</script>