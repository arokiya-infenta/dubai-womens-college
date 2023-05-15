
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
            <div class="card-header">
			<i class="fa fa-table"></i>Exam Fees Closing Date 
			</div>
            <div class="card-body">
			<div class="row mb-3">
			<div class="col-lg-3">
			<a href="<?=base_url().'coe/examFeesClosingDateAdd'?>">
			<button class="btn btn-sm btn-success edit_subject">Add Closing Date</button></a>
			</div>
			</div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  
	  <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->id?>" <?php if($batch->id==$batch1) {echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Semester</label>
			  <select class="form-control" name="sem" id="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>" <?php if($sem==$sem1) {echo 'selected';}?>><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>
			  <div class="col-lg-1 mt-4">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
        </div>
			  </div>	
              </form>
            </div>
			<div class="card-body">
			<?php if(isset($date_list)){?>
			<div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Batch</th>
                        <th>Department</th>
                        <th>Semester</th>
                        <th>Date</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($date_list as $date) {
						$dept_det = $this->db->where('main_id',$date->main_id)->where('cour_id',$date->course_id)->get('department_details')->row();
						$department = $dept_det->short_name;
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$date->batch_year?></td>
                        <td><?=$department?></td>
                        <td>Sem <?=$date->sem?></td>
                        <td><?php echo date('d-m-Y',strtotime($date->closing_date))?></td>
                        <td>
						<button class="btn btn-sm btn-warning update" data-id="<?=$date->id?>" data-toggle="modal" data-target="#largesizemodal">Edit</button>
						<a href="<?=base_url(). 'coe/examFeesClosingDateDelete/'.$date->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>
						</td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>
            </div>
			<?php } ?>
			</div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  
	  
	  <!-- Modal -->
             <form action="" method="post">
                <div class="modal fade" id="largesizemodal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Exam Fees</h5>
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
                    <input type="date" class="form-control" id="date_edit" name="closing_date_edit" required>
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                    <input type="hidden" class="form-control" id="batch_edit" name="batch">
                    <input type="hidden" class="form-control" id="sem_edit" name="sem">
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
		
		
		
		$('.update').click(function(){
		  var id = $(this).data('id');	
		  var batch_edit = $('#batch').val();	
		  var sem_edit = $('#sem').val();	
            $.ajax({
                url: base_url + "coe/examFeesClosingDateUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id
                },
                success: function (data) {
					dataParse = JSON.parse(data);
					var closing_date = dataParse.closing_date;
					var edit_id = dataParse.id;
					$('#date_edit').val(closing_date);
					$('#edit_id').val(edit_id);
					$('#batch_edit').val(batch_edit);
					$('#sem_edit').val(sem_edit);
                }
            });
		});
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>