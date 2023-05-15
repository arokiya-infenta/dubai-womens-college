
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
			<i class="fa fa-table"></i> File Upload
			</div>
            <div class="card-body">
			<form action="" method="POST" enctype="multipart/form-data">
              <div class="row mt-3">  
			  <?php if(isset($inspection)){ 
			  $file1 =  $inspection->file;
			  if($file1 != ''){$file2 = explode('/',$inspection->file); $file = $file2[3];}else{
			  $syllabus = '';}
			  $edit_id =  $inspection->id;
			  }else{
			  $file1 = '';
			  $file = '';
			  $style = 'display:none;'; 
              $edit_id = '';  			  
			  } ?>
			  <div class="col-lg-4">
			  <label>Instruction File(PDF)</label>
		  <input type="file" class="form-control" name="inspection" id="inspection" accept="application/pdf" required>
		  <input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?php echo $edit_id ?>">
			<a href="<?=base_url().$file1;?>" target="_blank"><p><?=$file?></p></a>
			  </div>
			  <div class="col-lg-4">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="upload">Upload</button>
        </div>
			  </div>
			  </div>
			  </form>
            </div>
          </div>
        </div>
      </div>
	 
	  <!-- End Row-->
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
	
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>