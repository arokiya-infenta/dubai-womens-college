
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
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>New Admission</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Admission Information
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
		         </div>
				 <div class="col-lg-3 mt-1">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
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
					<div class="row">
                 <div style="float:right">
				 <button type="button" class="btn btn-sm btn-warning" id="submit">Add Hostel Students</button>
				 </div>
			   </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($stu_list) > 0) { ?>
<div class="table-responsive">
 <table id="admissionList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Application No.</th>
                        <th>Hostel</th>

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
						<?php if($student->hostel_status==1){$check='checked';}else{$check='';}?>
                        <td><input type="checkbox" data-student="<?=$student->as_id?>" class="hostel" <?=$check?>></td>
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
var myTable = $('#admissionList').DataTable();
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
		
		$('#submit').click(function(){
		var stream = $('#stream').val();	
		var department = $('#department').val();	
		var batch = $('#batch').val();	
		var ids_hostel=Array();	
		var ids_not_hostel=Array();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=hostel]:checked').each(function(){
            ids_hostel.push($(this).data('student'));
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=hostel]:not(:checked)').each(function(){
            ids_not_hostel.push($(this).data('student'));
            });
		});
            $.ajax({
                url: base_url + "hosteladminlogin/markHostel",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ids_hostel: ids_hostel,
                    ids_not_hostel: ids_not_hostel,
                    stream: stream,
                    department: department,
                    batch: batch,
                },
                success: function (data) {
                }
            });
					alert('Details Marked Successfully!!');
		});
	});
	</script>
