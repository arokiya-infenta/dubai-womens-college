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
            <div class="card-header"><i class="fa fa-table"></i> Denied Employee List</div>
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