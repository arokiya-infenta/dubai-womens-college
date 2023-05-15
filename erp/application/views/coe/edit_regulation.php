
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Regulation</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			  <div class="col-lg-3">
          <label>Regulation Name</label>
			  <input type="text" class="form-control" name="name" value="<?=$reg_list->name?>">
			  <input type="hidden" class="form-control" name="edit_id" value="<?=$reg_list->id?>">
			  <span style="color:red;"><?php echo form_error('name'); ?></span>
			  </div>
        <div class="col-lg-9">
          <label>Description</label>
			  <textarea type="text" class="form-control" name="desc"><?=$reg_list->desc?></textarea>
			  </div>
			  </div>
			   <div class="row">
			  <div class="col-lg-3">
          <label>From Year</label>
			  <input type="text" class="form-control" name="fromYr" value="<?=$reg_list->fromYr?>">
			  <span style="color:red;"><?php echo form_error('fromYr'); ?></span>
			  </div>
			  <div class="col-lg-3">
          <label>To Year</label>
			  <input type="text" class="form-control" name="toYr" value="<?=$reg_list->toYr?>">
			  <span style="color:red;"><?php echo form_error('toYr'); ?></span>
			  </div>
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