
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<style>
.hide{
   display:none;
}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Add Employee</div>
            <div class="card-body">
			
			<form action="<?=base_url().'subadmin/addEmployee'?>" method="post" enctype="multipart/form-data">
			<div class="row">
              <div class="col-lg-3">
			  <label>Employee ID</label>
			  <input type="text" class="form-control" name="emp_id">
			  </div>
              <div class="col-lg-3">
			  <label>Name</label>
			  <input type="text" class="form-control" name="emp_name">
			  </div>
			  <div class="col-lg-3">
			  <label>Mobile</label>
			  <input type="mobile" class="form-control" minlength="10" maxlength="10" name="mobile">
			  </div>
			  <div class="col-lg-3">
			  <label>Email</label>
			  <input type="email" class="form-control" name="email">
			  </div>
            </div>
			
			<div class="row">
									<div class="col-lg-3">
										<label for="gender">Gender</label>
										<select class="form-control" name="gender" id="gender" required>
											<option value="">Please make a choice</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
									<div class="col-lg-3">
										<label for="merital_status">Marital Status</label>
										<input type="text" class="form-control" name="merital_status" id="merital_status" required />
									</div>
									<div class="col-sm-3">
										<label for="blood_group">Blood Group</label>
										<input type="text" class="form-control" name="blood_group" id="blood_group" required />
									</div>
			  <div class="col-lg-3">
			  <label>Profile Picture</label>
			  <input type="file" name="perPhoto" class="form-control">
			  </div>
			  </div>
			
              <div class="row">
									<div class="col-lg-3">
										<label for="identity_doc">Identity Document</label>
										<select class="form-control" name="identity_doc" id="identity_doc" required>
											<option value="">Please make a choice</option>
											<option value="Voter Id">Voter Id</option>
											<option value="Aadhar Card">Aadhar Card</option>
											<option value="Driving License">Driving License</option>
											<option value="Passport">Passport</option>
										</select>
									</div>
			  <div class="col-lg-3">
			  <label>Document</label>
			  <input type="file" name="document" class="form-control">
			  </div>
              <div class="col-lg-3">
			  <label>DOB</label>
			  <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
    <input class="form-control" type="text" readonly name="dob"/>
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
</div>
			  </div>
			  <div class="col-lg-3">
			  <label>DOJ</label>
			  <div id="datepicker1" class="input-group date" data-date-format="mm-dd-yyyy">
    <input class="form-control" type="text" readonly name="doj"/>
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
</div>
			  </div>
            </div>
			
			<div class="row">
              <div class="col-lg-3">
			  <label>Role</label>
			  <select class="form-control" id="role" name="role" required>
			  <option value="">Select Role</option>
			  <?php foreach($role as $role){ ?>
			  <option value="<?=$role->id?>"><?=$role->role_name?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-3">
			  <label>Type</label>
			  <select class="form-control" id="type" name="type" required>
			  <option value="">Select Type</option>
			  <?php foreach($dept_type as $type){ ?>
			  <option value="<?=$type->id?>"><?=$type->name_?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-3">
			  <label>Stream</label>
			  <select class="form-control" id="stream" name="stream" required>
			  <option value="">Select Stream</option>
			  <option value="5">UG</option>
			  <option value="2">PG - MSW Aided</option>
			  <option value="1">PG - Self Finance</option>
			  <option value="3">PG - MSW Self Finance</option>
			  <option value="4">PG Diploma</option>
			  </select>
			  </div>
			  <div class="col-lg-3" id="dept">
			  <label>Department</label>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			  </select>
			  </div>
            </div>
			  
			  <div class="row">
									<div class="col-sm-3">
										<label for="nationality">Nationality</label>
										<input type="text" class="form-control" name="nationality" id="nationality" required />
									</div>
									<div class="col-sm-3">
										<label for="city">City</label>
										<input type="text" class="form-control" name="city" id="city" required />
									</div>
									<div class="col-sm-3">
										<label for="state">State</label>
										<input type="text" class="form-control" name="state" id="state" required />
									</div>
									<div class="col-sm-3">
										<label for="country">Country</label>
										<input type="text" class="form-control" name="country" id="country" required />
									</div>
			  </div>
			
			<div class="row">
			  <div class="col-lg-12">
			  <label>Address</label>
			  <textarea class="form-control" name="address"></textarea>
			  </div>
            </div>
			
			<div class="row">
									<div class="col-sm-3">
										<label for="bank_name">Bank Name</label>
										<input type="text" class="form-control" name="bank_name" id="bank_name" required />
									</div>
									<div class="col-sm-3">
										<label for="account_no">Bank A/C No.</label>
										<input type="text" class="form-control" name="account_no" id="account_no" required />
									</div>
									<div class="col-sm-3">
										<label for="ifsc_code">IFSC Code</label>
										<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" required />
									</div>
									<div class="col-sm-3">
										<label for="pf_account">PF A/C No.</label>
										<input type="text" class="form-control" name="pf_account" id="pf_account" />
									</div>
            </div>
			
			<div class="row">
			  <div class="col-lg-3">
			  <label>Status</label>
			  <select class="form-control" name="status" required>
			  <option value="Working">Active</option>
			  <option value="Denied">Inactive</option>
			  </select>
			  </div>
            </div>
			
			<div class="row mt-3">
			  <div class="col-lg-12">
			  <div class="form-group" style="float:right;">
			  <button type="submit" name="submit" class="btn btn-sm btn-primary">Add Employee</button>
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
    $(".login_status").click(function () {
		var status = $(this).attr('data-status');
		var btn = $(this);
		var icon = $(this).parent().find('i');
		var anchr = $(this).parent().find('a');
            $.ajax({
                url: base_url + "subadmin/empLoginStatus",
                type: 'POST',
                cache: false,
                data: {
                    emp_id: $(this).val(),
                    status: status,
                },
                success: function (data) {
					var stat = data;
					btn.attr('data-status',stat);
					btn.toggleClass('btn-success btn-warning');
					icon.toggleClass('fa-times fa-check');
					anchr.toggleClass('hide');
					alert('Login Status of the Employee is updated!');
                }
            });
    });
	
	$(".set_pwd").click(function () {
		var emp_id1 = $('.emp_id1').val();
		var new_pwd = $('.new_pwd').val();
		var conf_pwd = $('.conf_pwd').val();
		if(new_pwd=='' || conf_pwd=='' ){
			alert('Please Enter both fields!');
			exit;
		}
		if(new_pwd==conf_pwd && new_pwd!='' && conf_pwd!='' ){
            $.ajax({
                url: base_url + "subadmin/setEmpPassword",
                type: 'POST',
                cache: false,
                data: {
                    emp_id: emp_id1,
                    new_pwd: new_pwd,
                    conf_pwd: conf_pwd,
                },
                success: function (data) {
					$('.close').click();
					alert('Employee Password has been updated!');
                }
            });
		}else{
			alert('Please Enter same Password in both fields!');
		}
    });
	
	$(".setpwd").click(function () {
		var setpwd=$(this).data('empid');
		$('.emp_id1').val(setpwd);
		});
		
		$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "subadmin/getProgram",
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
			//$('#dept').css('display','none');
			$('#department').append('<option value="">Select Program</option>');
		}
		});
		$(document).ready(function(){
//alert();

$("#type").change(function(){

	var tran_id = $(this).val();

if(tran_id == 26){

	$("#stream").attr("required",false);
	$("#department").attr("required",false);

}else{
	$("#stream").attr("required",true);
	$("#department").attr("required",true);
}

	//alert(tran_id);



});




		});
	</script>
