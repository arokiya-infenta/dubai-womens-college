
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
			<i class="fa fa-table"></i> Add Examiner
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Designation</label>
			<select class="form-control" name="designation" id="designation" value="<?=set_value('designation')?>">
			<option value="external_academician">External Academician</option>
			<option value="field_practitioner">Field Practitioner</option>
			</select>
			<span style="color:red;"><?php echo form_error('designation'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Examiner Department</label>
			  <select class="form-control" name="department" id="department" value="<?=set_value('department')?>">
			<?php $examiner_dept = $this->db->order_by('name_','asc')->get('erp_dept_type')->result();
			foreach($examiner_dept as $dept){?>
			<option value="<?=$dept->id?>"><?=$dept->name_?></option>
			<?php } ?>
			</select>
		  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>First Name</label>   
			<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name') ?>">
			<span style="color:red;"><?=form_error('first_name')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Last Name</label>   
			<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Date of Birth</label>   
			<input type="date" class="form-control" name="dob" id="dob" value="<?php echo set_value('dob') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Mobile(+91)</label>   
			<input type="text" class="form-control" name="mobile" id="mobile" pattern="[789][0-9]{9}" value="<?php echo set_value('mobile') ?>">
			<span style="color:red;"><?=form_error('mobile')?></span>
		         </div>
			<div class="col-lg-3">
          <label>Email</label>
			  <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email') ?>">
			  <span style="color:red;"><?php echo form_error('email'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>College Name</label>   
			<input type="text" class="form-control" name="college" id="college" value="<?php echo set_value('college') ?>">
			<span style="color:red;"><?=form_error('college')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Company Name</label>   
			<input type="text" class="form-control" name="company" id="company" value="<?php echo set_value('company') ?>">
			<span style="color:red;"><?=form_error('company')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Account No.</label>   
			<input type="number" class="form-control" name="acc_no" id="acc_no" value="<?php echo set_value('acc_no') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Bank Name</label>   
			<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo set_value('bank_name') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Bank Branch</label>   
			<input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?php echo set_value('bank_branch') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>IFSC Code</label>   
			<input type="text" class="form-control" name="ifsc" id="ifsc" value="<?php echo set_value('ifsc') ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Years of Experience</label>   
			<input type="text" class="form-control" name="experience" id="experience" value="<?php echo set_value('experience') ?>">
		         </div>
				 <div class="col-lg-3">
          <label>Access Status</label>
			  <select class="form-control" name="status" id="status" value="<?php echo set_value('status') ?>">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
			</select>
			  </div>
            </div>


          <div class="row mt-3">  
			  <div class="col-lg-11">
          <div class="form-group" style="float: right;">
		  <a href="<?=base_url().'coe/examiners';?>">
			  <button type="button" class="btn btn-sm btn-secondary">Back</button></a>
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
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
	$('#designation').change(function(){
			$('#department').val('');
		  var designation = $(this).val();	
			if (designation!='external_academician') {
			$('#department').prepend('<option value="0">Select Department</option>');
            $('#department').attr('disabled',true);
        }else{
			$('#department option[value="0"]').remove();
			$('#department').attr('disabled',false);
		}
		});
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>