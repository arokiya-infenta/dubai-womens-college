
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success','','success'); ?>
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Subject</div>
            <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
			  <div class="col-lg-3">
          <label>Student Name</label>
		  <input type="text" class="form-control" name="pr_applicant_name" value="<?=$stu_list->pr_applicant_name?>">
		  <input type="hidden" class="form-control" name="student_id" value="<?=$stu_list->as_student_id?>">
			  </div>
			  <div class="col-lg-3">
          <label>DOB</label>
			  <input type="text" class="form-control" name="pr_dob" value="<?=$stu_list->pr_dob?>">
			  </div>
			  <div class="col-lg-3">
          <label>AGE</label>
			  <input type="text" class="form-control" name="pr_age" value="<?=$stu_list->pr_age?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother Tongue</label>
			  <input type="text" class="form-control" name="pr_mother_toung" value="<?=$stu_list->pr_mother_toung?>">
			  </div>
			  <div class="col-lg-3">
          <label>Place of Birth</label>
			  <input type="text" class="form-control" name="pr_place_of_birth" value="<?=$stu_list->pr_place_of_birth?>">
			  </div>
			  <div class="col-lg-3">
          <label>Gender</label>
			  <input type="text" class="form-control" name="pr_gender" value="<?=$stu_list->pr_gender?>">
			  </div>
			  <div class="col-lg-3">
          <label>Nationality</label>
			  <input type="text" class="form-control" name="pr_nationality" value="<?=$stu_list->pr_nationality?>">
			  </div>
			  <div class="col-lg-3">
          <label>Blood Group</label>
			  <input type="text" class="form-control" name="pr_blood_group" value="<?=$stu_list->pr_blood_group?>">
			  </div>
			  <div class="col-lg-3">
          <label>Religion</label>
			  <input type="text" class="form-control" name="pr_religion" value="<?=$stu_list->pr_religion?>">
			  </div>
			  <div class="col-lg-3">
          <label>Caste</label>
			  <input type="text" class="form-control" name="pr_caste" value="<?=$stu_list->pr_caste?>">
			  </div>
			  <div class="col-lg-3">
          <label>Community</label>
			  <input type="text" class="form-control" name="pr_community" value="<?=$stu_list->pr_community?>">
			  </div>
			  <div class="col-lg-3">
          <label>Father Name</label>
			  <input type="text" class="form-control" name="pr_father_name" value="<?=$stu_list->pr_father_name?>">
			  </div>
			  <div class="col-lg-3">
          <label>Father Mobile</label>
			  <input type="text" class="form-control" name="pr_father_mobnum" value="<?=$stu_list->pr_father_mobnum?>">
			  </div>
			  <div class="col-lg-3">
          <label>Father Email</label>
			  <input type="text" class="form-control" name="pr_father_email" value="<?=$stu_list->pr_father_email?>">
			  </div>
			  <div class="col-lg-3">
          <label>Father Occupation</label>
			  <input type="text" class="form-control" name="pr_father_accu" value="<?=$stu_list->pr_father_accu?>">
			  </div>
			  <div class="col-lg-3">
          <label>Father Annual Income</label>
			  <input type="text" class="form-control" name="pr_father_anuval_income" value="<?=$stu_list->pr_father_anuval_income?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother name</label>
			  <input type="text" class="form-control" name="pr_mother_name" value="<?=$stu_list->pr_mother_name?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother Mobile</label>
			  <input type="text" class="form-control" name="pr_mother_mobnum" value="<?=$stu_list->pr_mother_mobnum?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother Email</label>
			  <input type="text" class="form-control" name="pr_mother_email" value="<?=$stu_list->pr_mother_email?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother Occupation</label>
			  <input type="text" class="form-control" name="pr_mother_accu" value="<?=$stu_list->pr_mother_accu?>">
			  </div>
			  <div class="col-lg-3">
          <label>Mother Annual Income</label>
			  <input type="text" class="form-control" name="pr_mother_anuval_income" value="<?=$stu_list->pr_mother_anuval_income?>">
			  </div>
			  <div class="col-lg-3">
          <label>Guardian Name</label>
			  <input type="text" class="form-control" name="pr_gaurdion_name" value="<?=$stu_list->pr_gaurdion_name?>">
			  </div>
			  <div class="col-lg-3">
          <label>Guardian Mobile</label>
			  <input type="text" class="form-control" name="pr_gaurdion_mobnum" value="<?=$stu_list->pr_gaurdion_mobnum?>">
			  </div>
			  <div class="col-lg-3">
          <label>Guardian Email</label>
			  <input type="text" class="form-control" name="pr_gaurdion_email" value="<?=$stu_list->pr_gaurdion_email?>">
			  </div>
			  <div class="col-lg-3">
          <label>Guardian Occupation</label>
			  <input type="text" class="form-control" name="pr_gaurdion_accu" value="<?=$stu_list->pr_gaurdion_accu?>">
			  </div>
			  <div class="col-lg-3">
          <label>Guardian Annual Income</label>
			  <input type="text" class="form-control" name="pr_gaurdion_anuval_income" value="<?=$stu_list->pr_gaurdion_anuval_income?>">
			  </div>
			  <div class="col-lg-3">
          <label>Student Profile</label>
			  <input type="file" class="form-control" name="profile">
			  <?php if($stu_list->pr_photo!='' || $stu_list->pr_photo!=null){ ?>
			  <a href="<?='https://admission.mssw.in/admin/uploads/'.$stu_list->pr_photo?>" target="_blank" download><?=$stu_list->pr_photo?></a>
			  <?php } ?>
			  </div>
			  <div class="col-lg-12">
          <label>Local Address</label>
			  <textarea type="text" class="form-control" name="pr_local_address"><?=$stu_list->pr_local_address?></textarea>
			  </div>
			  <div class="col-lg-3">
          <label>Local City</label>
			  <input type="text" class="form-control" name="pr_local_city" value="<?=$stu_list->pr_local_city?>">
			  </div>
			  <div class="col-lg-3">
          <label>Local State</label>
			  <input type="text" class="form-control" name="pr_local_state" value="<?=$stu_list->pr_local_state?>">
			  </div>
			  <div class="col-lg-3">
          <label>Local Country</label>
			  <input type="text" class="form-control" name="pr_local_country" value="<?=$stu_list->pr_local_country?>">
			  </div>
			  <div class="col-lg-3">
          <label>Local Pincode</label>
			  <input type="text" class="form-control" name="pr_local_pincode" value="<?=$stu_list->pr_local_pincode?>">
			  </div>
			  <div class="col-lg-12">
          <label>Permanent Address</label>
			  <textarea type="text" class="form-control" name="pr_permanent_address"><?=$stu_list->pr_permanent_address?></textarea>
			  </div>
			  <div class="col-lg-3">
          <label>Permanent City</label>
			  <input type="text" class="form-control" name="pr_permanent_city" value="<?=$stu_list->pr_permanent_city?>">
			  </div>
			  <div class="col-lg-3">
          <label>Permanent State</label>
			  <input type="text" class="form-control" name="pr_permanent_state" value="<?=$stu_list->pr_permanent_state?>">
			  </div>
			  <div class="col-lg-3">
          <label>Permanent Country</label>
			  <input type="text" class="form-control" name="pr_permanent_country" value="<?=$stu_list->pr_permanent_country?>">
			  </div>
			  <div class="col-lg-3">
          <label>Permanent Pincode</label>
			  <input type="text" class="form-control" name="pr_permanent_pincode" value="<?=$stu_list->pr_permanent_pincode?>">
			  </div>
            </div>


          <div class="row mt-3">  
			  <div class="col-lg-11">
          <div class="form-group" style="float: right;">
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
	});
	</script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>			