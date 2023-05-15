
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
		  <div class="card-header"><i class="fa fa-table"></i>Create Batch</div>
            <div class="card-body">
			
			<form action="<?=base_url()?>/PgDiploma/addBatch" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php 
			foreach($batch as $batch){?>
			<option value="<?=$batch->year?>" ><?=$batch->year?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('I','II');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" ><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3">
		
		         </div>
				 <div class="col-lg-3">
			
		         </div>
				 <div class="col-lg-12 mt-4">
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
			
	 
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Batch</th>
                        <th>Semester</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>

                <?php $id=1;
                foreach ($createdbatch as $key => $value) {   ?>



<tr>
  <td><?=$id?></td>
  <td><?=$value->batch?></td>
  <td><?=$value->semester?></td>
  <td><a href="<?=base_url()?>/PgDiploma/addstudent/<?=$value->batch?>/<?=$value->semester?>" class="btn btn-primary">add Student</a></td>
</tr>
                 
              <?php $id++; }
                
                
                ?>
        </tbody>
        </table>


                    
              
	  <!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div>
    </div>
    </div>
    </div>
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
	});
	</script>
