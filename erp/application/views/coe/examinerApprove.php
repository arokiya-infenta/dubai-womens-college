
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
		  <div class="card-header"><i class="fa fa-table"></i> Approve Examiner</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
				 <div class="col-lg-9 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
			  </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($examiner_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:left;">
			<button type="button" class="btn btn-sm btn-primary" id="approve_stat">Approve</button>
		         </div>
		         </div>
			  </div>
				 <div align="middle">
				 <?php if($subject1){$subj = $this->db->where('id',$subject1)->get('erp_subjectmaster')->row();}?>
			<h5 style="font-weight:bold;text-transform:uppercase">SUBJECT: <?=$subj->subName?></h5>
		         </div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>College</th>
                        <th>Mobile</th>
                        <th>Approve</th>
                        <th>Login</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($examiner_list)){
					$sno=1;
					foreach ($examiner_list as $examiner) {
						if($examiner->designation == 'external_academician'){$design = 'External Academecian';}
						else{$design = 'Field Practitioner';}
						if($examiner->approve_status == 1){$appr = ' <span style="color:green;">Approved</span>';
						
						if($examiner->login_status == 1){$login_stat = '<button data-id="'.$examiner->id.'" class="btn btn-sm btn-success login_stat" value="0">Active</button>';
						$pwd = '<span style="color:green;cursor:pointer;" data-username="'.$examiner->username.'" data-pwd="'.$examiner->password.'" data-id="'.$examiner->id.'" data-toggle="modal" data-target="#largesizemodal" class="set_pwd">Set Password</span>';
						}
						else{$login_stat = '<button data-id="'.$examiner->id.'" class="btn btn-sm btn-danger login_stat" value="1">Inactive</button>';
						$pwd = '';
						}
						
						}
						else{$appr = ' <span style="color:red;">Unapproved</span>';$login_stat = '';$pwd = '';}
					?>
                      <tr>
                        <td><?=$sno;?></td>
                        <td><?=$examiner->first_name?></td>
                        <td><?=$design?></td>
                        <td><?php echo $examiner->college?></td>
                        <td><?php echo $examiner->mobile?></td>
						<td><?php if($examiner->approve_status == 1){$stat = 'checked';}else{$stat = '';} ?>
						<input type="radio" data-id="<?=$examiner->id?>" name="approve" class="approve" style="width:20px;height:20px;" <?=$stat?>>
						<?=$appr?>
						</td>
						<td><?=$login_stat . $pwd;?></td>
                    </tr>
                    <?php $sno++;}} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
			  <?php } ?>
	  <!-- End Row-->
	  
	  <!-- Modal -->
                <div class="modal fade" id="largesizemodal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Set Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
					  	
              <div class="row">
			  <div class="col-sm-4">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username_edit" name="username_edit" required>
                  </div>
                </div>
                         <div class="col-sm-4">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" id="pwd_edit" name="pwd_edit" required>
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                  </div>
                </div>
						</div> 
						
						
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_edit" id="update_pwd"><i class="fa fa-check-square-o"></i> Update</button>
                      </div>
                    </div>
                  </div>
                </div>
				<!-- Modal Ends -->
				

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
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();	
	$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
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
    $('#department').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $(this).val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "coe/getSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			alert('Select all the fields');
		}
		});	
		
		$('#approve_stat').click(function(e){
			if(confirm('Are you sure to approve the status?')){
		  var approve_id = $('.approve:checked',allPages).data('id');	
		  var stream = '<?=$stream?>';
		  var department = '<?=$department?>';	
		  var batch = '<?=$batch1?>';	
		  var sem = '<?=$sem1?>';	
		  var subject = '<?=$subject1?>';
		  if(approve_id !== undefined && approve_id != ''){
			  $.ajax({
                url: base_url + "coe/updateExaminerStatus",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
					approve_id : approve_id,
					batch : batch,
					department : department,
					stream : stream,
					subject : subject,
					sem : sem,
                },
                success: function (data) {
			  alert('Examiner has been alloted!!');
			  location.reload();
                }
            });
			}else{
				alert('Please check an examiner');
			}
			}
		  });
		  
		  $('.login_stat',allPages).click(function(e){
			if(confirm('Are you sure to give access to login?')){
		  var id = $(this).data('id');	
		  var status = $(this).val();	
			  $.ajax({
                url: base_url + "coe/updateExaminerLogin",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
					id : id,
					status : status,
                },
                success: function (data) {
			  alert('Login status has been updated!!');
			  location.reload();
                }
            });
			}
		  });
		  
		  $('.set_pwd',allPages).click(function(e){
			  
			  //var randomstring = Math.random().toString(36).slice(-8);
			  var generatePassword = (
                length = 20,
                wishlist = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$'
                ) =>
                 Array.from(crypto.getRandomValues(new Uint32Array(length)))
                 .map((x) => wishlist[x % wishlist.length])
                 .join('');
			  var randompwd = generatePassword();
    
		  var edit_id = $(this).data('id');	
		  var pwd = $(this).data('pwd');
		  var username = $(this).data('username');
		  
		  if(pwd != ''){
            $('#pwd_edit').val(pwd);
		  }else{
			$('#pwd_edit').val(randompwd);  
		  }	

			  
			  var randomuser = 'EXM-' + edit_id;
		  if(username != ''){
            $('#username_edit').val(username);
		  }else{
			$('#username_edit').val(randomuser);  
		  }	
		  
            $('#edit_id').val(edit_id);	
		  });
		  
		  $('#update_pwd').click(function(e){
		  var id = $('#edit_id').val();	
		  var pwd = $('#pwd_edit').val(); 
		  var username = $('#username_edit').val(); 
			  $.ajax({
                url: base_url + "coe/updateExaminerPwd",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
					id : id,
					pwd : pwd,
					username : username,
                },
                success: function (data) {
			  alert('Password has been updated!!');
			  location.reload();
                }
            });
		  });
		
	});
	</script>