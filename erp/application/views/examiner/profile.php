
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
			<i class="fa fa-table"></i> Edit Profile - <?=$examiner->username?>
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Designation</label>
			<select class="form-control" name="designation" id="designation" disabled>
			<option value="external_academician" <?php if($examiner->designation=='external_academician'){echo 'selected';}?>>External Academician</option>
			<option value="field_practitioner" <?php if($examiner->designation=='field_practitioner'){echo 'selected';}?>>Field Practitioner</option>
			</select>
			<span style="color:red;"><?php echo form_error('designation'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Examiner Department</label>
			  <?php if($examiner->designation=='external_academician'){$disabled=''; $dep_val=$examiner->department_id;}
			  else{$disabled='disabled'; $dep_val=0;}?>
			  <select class="form-control" name="department" id="department" value="<?=$dep_val?>" <?=$disabled?> disabled>
			  <?php if($dep_val==0){ ?>
			  <option value="0" selected>Select Department</option><?php } ?>
			<?php $examiner_dept = $this->db->order_by('name_','asc')->get('erp_dept_type')->result();
			foreach($examiner_dept as $dept){?>
			<option value="<?=$dept->id?>" <?php if($dep_val==$dept->id){echo 'selected';}?>><?=$dept->name_?></option>
			<?php } ?>
			</select>
		  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>First Name</label>   
			<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $examiner->first_name; ?>">
			<input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?php echo $user_id; ?>">
			<input type="hidden" class="form-control" name="dept" id="dept" value="<?php echo $examiner->department_id; ?>">
			<span style="color:red;"><?=form_error('first_name')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Last Name</label>   
			<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $examiner->last_name; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Date of Birth</label>   
			<input type="date" class="form-control" name="dob" id="dob" value="<?php echo $examiner->dob; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Mobile(+91)</label>   
			<input type="text" class="form-control" name="mobile" id="mobile" pattern="[789][0-9]{9}" value="<?php echo $examiner->mobile; ?>">
			<span style="color:red;"><?=form_error('mobile')?></span>
		         </div>
			<div class="col-lg-3">
          <label>Email</label>
			  <input type="email" class="form-control" id="email" name="email" value="<?php echo $examiner->email; ?>">
			  <span style="color:red;"><?php echo form_error('email'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>College Name</label>   
			<input type="text" class="form-control" name="college" id="college" value="<?php echo $examiner->college; ?>" readonly>
			<span style="color:red;"><?=form_error('college')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Company Name</label>   
			<input type="text" class="form-control" name="company" id="company" value="<?php echo $examiner->company; ?>">
			<span style="color:red;"><?=form_error('company')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Account No.</label>   
			<input type="number" class="form-control" name="acc_no" id="acc_no" value="<?php echo $examiner->acc_no; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Bank Name</label>   
			<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $examiner->bank_name; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Bank Branch</label>   
			<input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?php echo $examiner->bank_branch; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>IFSC Code</label>   
			<input type="text" class="form-control" name="ifsc" id="ifsc" value="<?php echo $examiner->ifsc; ?>">
		         </div>
				 <div class="col-lg-3">
			<label>Years of Experience</label>   
			<input type="text" class="form-control" name="experience" id="experience" value="<?php echo $examiner->experience; ?>">
		         </div>
				  <div class="col-lg-3">
			<label>Password</label>   
			<input type="text" class="form-control" name="password" id="password" value="<?php echo $examiner->password; ?>">
		         </div>
				 <div class="col-lg-3">
          <label>Access Status</label>
			  <select class="form-control" name="status" id="status" value="<?php echo $examiner->status; ?>">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
			</select>
			  </div>
            </div>


          <div class="row mt-3">  
			  <div class="col-lg-11">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Update</button>
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
			var dept = $('#dept').val();
		  var designation = $(this).val();	
			if (designation!='external_academician') {
			$('#department').prepend('<option value="0">Select Department</option>');
            $('#department').attr('disabled',true);
        }else{
			$('#department option[value="0"]').remove();
			$('#department').attr('disabled',false);
			if(dept!=0){
			$('#department').val(dept);}
		}
		});
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>