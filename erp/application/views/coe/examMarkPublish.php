
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
			<i class="fa fa-table"></i> Publish Mark
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
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
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>
			<div class="col-lg-3">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream">
			  <option value="">Select Stream</option>
			  <option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-3" id="dept">
          <label>Department</label>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			  </select>
			  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
				 <div class="publish" style="display:none">
			  <button class="btn btn-sm btn-success" name="submit">Publish</button>
		         </div>
				 <div class="published" style="display:none">
			  <p style="font-weight:bold;font-size:15px;">Marks already published for the department!!</p>
		         </div>
		         </div>
		         </div>
            </div>

	
              </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  

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
		
		$('#batch,#sem,#stream,#department').change(function(){
			$('.publish').css('display','none');
			$('.published').css('display','none');
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var sem = $('#sem').val();	
		  var batch = $('#batch').val();	
			if (batch!='' && sem!='' && stream!='' && department!='' && department!=null) {
            $.ajax({
                url: base_url + "coe/getPublishStatus",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch: batch,
                    sem: sem,
                    stream: stream,
                    department: department,
                },
                success: function (data) {
					 if(data == 1){
						 $('.published').css('display','block');
						 $('.publish').css('display','none');
					 }else{
						 $('.publish').css('display','block');
						 $('.published').css('display','none');
					 }
                }
            });
        }
		});
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>