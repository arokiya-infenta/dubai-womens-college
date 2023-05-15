
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
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			   <div class="row">
                 <div style="float:right">
				 <button type="button" class="btn btn-sm btn-warning" id="submit">Add Left Status</button>
				 </div>
			   </div>	   
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="studentleft-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Application No.</th>
                        <th>Left Status</th>
                        <th>Long Absent</th>
                       
                       
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
						<?php if($student->left_status==1){$check='checked';}else{$check='';}?>
                        <td><input type="checkbox" data-student="<?=$student->as_id?>" class="left" <?=$check?>></td>
						<?php if($student->long_absent==1){$check1='checked';}else{$check1='';}?>
                        <td><input type="checkbox" data-student="<?=$student->as_id?>" class="lngabsent" <?=$check1?>></td>
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
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
var myTable = $('#studentleft-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();			
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
		
		$('#submit').click(function(){
		var ids_left=Array();	
		var ids_absent=Array();	
		var ids_not_left=Array();	
		var ids_not_absent=Array();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=left]:checked').each(function(){
            ids_left.push($(this).data('student'));
            });
			$(this).closest('tr').find('td:eq(4) input[class=lngabsent]:checked').each(function(){
            ids_absent.push($(this).data('student'));
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=left]:not(:checked)').each(function(){
            ids_not_left.push($(this).data('student'));
            });
			$(this).closest('tr').find('td:eq(4) input[class=lngabsent]:not(:checked)').each(function(){
            ids_not_absent.push($(this).data('student'));
            });
		});
            $.ajax({
                url: base_url + "coe/markLeft",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ids_left: ids_left,
                    ids_absent: ids_absent,
                    ids_not_left: ids_not_left,
                    ids_not_absent: ids_not_absent,
                },
                success: function (data) {
                }
            });
					alert('Details Marked Successfully!!');
		});
	});
	</script>