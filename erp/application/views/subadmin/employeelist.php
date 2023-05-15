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
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Employee List
			<div style="float:right;">
			<a href="<?php echo base_url().'subadmin/addEmployee'?>"><button class="btn btn-sm btn-success">Add Employee</button></a>
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Employee ID </th>
                        <th>Employee Name </th>
                        <th>Designation </th>
                        <th>Working Status</th>
                        <th>Login Status</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($emp_list as $key => $value) { 
					$dept_nm=$this->db->where('id',$value->emp_designation_)->get('erp_role_master')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$value->employee_id_?></td>
                        <td><?=$value->emp_name_?></td>
                        <td><?=$dept_nm->role_name?></td>
                        <td><?=$value->emp_working_status_?></td>
                        
                        <td>
						<?php if($value->emp_working_status_=='Working'){ 
						if($value->login_status_==0){
						$class='class="btn login_status btn-warning"';$class_i='class="fa fa-times"';$class_a='class="setpwd hide"';}else{
						$class='class="btn login_status btn-success"';$class_i='class="fa fa-check"';$class_a='class="setpwd"';	
						}
						?>
						<a href="<?php echo base_url().'subadmin/editEmployee/'.$value->id?>">
						<button class="btn btn-primary">Edit</button></a>
                        <Button data-status="<?=$value->login_status_?>"  value="<?=$value->id?>" <?=$class?> ><i <?=$class_i?> aria-hidden="true"></i></Button>
						<a href="#" data-empid="<?=$value->id?>" data-target="#myModal" data-toggle="modal" <?=$class_a?>>Set Password</a>
						<?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Employee ID </th>
                        <th>Employee Name </th>
                        <th>Designation </th>
                        <th>Working Status</th>
                        <th>Login Status</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  <!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-7">
			<label>New Password</label>
			<input type="text" class="form-control new_pwd" placeholder="Enter New Password" id="new_pwd" name="new_pwd">
			<input type="hidden" class="form-control emp_id1" id="emp_id1" name="emp_id1">
			</div>
			</div>
		  <div class="row">
			<div class="col-md-7">
			<label>Confirm Password</label>
			<input type="text" class="form-control conf_pwd" placeholder="Enter Confirm Password" id="conf_pwd" name="conf_pwd">
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-success set_pwd">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

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
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>