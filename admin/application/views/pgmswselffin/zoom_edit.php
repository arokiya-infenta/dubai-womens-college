<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
	      <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
            <div class="card-header">Students List</div>
            <div class="card-body">
			
			<form action="" method="post">
		  <div class="row">
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Title</label>
		  <input type="text" class="form-control" name="title" value="<?php echo $single_link->title; ?>">
		  <span style="color:red;"><?php echo form_error('title'); ?></span>
		  </div>
		</div>
        <div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Date</label>
		  <input type="date" class="form-control" name="start_date" value="<?php echo $single_link->start_date; ?>">
		  <span style="color:red;"><?php echo form_error('start_date'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Select Time</label>
		  <input type="time" class="form-control" name="start_time" value="<?php echo date('H:i:s',strtotime($single_link->start_time)); ?>">
		  <span style="color:red;"><?php echo form_error('start_time'); ?></span>
		  </div>
		</div>
		  </div>
		  
		  <div class="row">
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Duration(in min)</label>
		  <input type="number" class="form-control" name="duration" value="<?php echo $single_link->duration; ?>">
		  <span style="color:red;"><?php echo form_error('duration'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Password</label>
		  <input type="text" class="form-control" name="password" maxlength="10" title="Max characters 10" value="<?php echo $single_link->password; ?>">
		  <span style="color:red;"><?php echo form_error('password'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3 mt-4">
		  <div class="form-group">
		  <input type="submit" class="btn btn-sm btn-primary" name="submit" value="Update">
		  </div>
		</div>
		 </div>
		  </form>
			  
			</div>
		   </div>
		</div>
	  </div>






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>