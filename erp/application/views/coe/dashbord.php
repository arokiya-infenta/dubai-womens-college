<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
	  <div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>	
      <div class="row mt-3">
        <div class="col-12 col-lg-12 col-xl-12">

        <form action="" method="post">
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info">Update Password</h4>
				<div class="col-4">
                <p><label>Old Password</label><input type="password" name="old" class="form-control" placeholder="Old Password" required></p>
                <p><label>New Password (Min character should be 6)</label><input type="password" name="new" class="form-control" placeholder="New Password" required minlength="6"></p>
                <p><label>Confirm Password</label><input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required></p>
                <p><button type="submit" name="submit" class="btn btn-sm btn-success">Update</button></p>
				</div>
              </div>
            </div>
            </div>
          </div>
		  </form>
        </div>
     
      </div>
     
       <!--End Dashboard Content-->

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
    <style>
    
   .ls-view {
    float: right;
    color: black;
}
    </style>