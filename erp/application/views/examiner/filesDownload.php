
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
			<i class="fa fa-table"></i> File Download (Click to Download)
			</div>
            <div class="card-body">
			<form action="" method="POST" enctype="multipart/form-data">
              <div class="row mt-3">  
			  <?php if(isset($syll_templ)){ 
			  $s = '';
			  $t = '';
			  $syllabus1 =  $syll_templ->syllabus;
			  $template1 =  $syll_templ->template;
			  //if($template != ''){$style = 'display:block;';}else{
			  //$style = 'display:none;';}
			  if($syllabus1 != ''){$syllabus2 = explode('/',$syll_templ->syllabus); $syllabus = $syllabus2[3];}else{
			  $syllabus = '';$s='Not Yet Uploaded!';}
			  if($template1 != ''){$template2 = explode('/',$syll_templ->template); $template = $template2[3];}else{
			  $template = '';$t='Not Yet Uploaded!';}
			  }else{
			  $syllabus1 = '';
			  $template1 = '';
			  $syllabus = '';
			  $template = '';
			  $style = 'display:none;';  
			  $s='Not Yet Uploaded!';
			  $t='Not Yet Uploaded!';
			  } ?>
			  <div class="col-lg-4">
			  <label>Syllabus</label>
		  <a href="<?=base_url().$syllabus1;?>" download><p><?=$syllabus?></p></a>
		  <span style="font-weight:bold;color:red;"><?=$s?></span>
			  </div>
			  <div class="col-lg-4">
			  <label>Template</label>
			<a href="<?=base_url().$template1;?>" download><p><?=$template?></p></a>
			<span style="font-weight:bold;color:red;"><?=$t?></span>
			  </div>
			  <?php if(isset($inspection)){ 
			  $i='';
			  $file1 =  $inspection->file;
			  if($file1 != ''){$file2 = explode('/',$inspection->file); $file = $file2[3];}else{
			  $file = '';$i='Not Yet Uploaded!';}
			  }else{
			  $file1 = '';
			  $file = '';
			  $i='Not Yet Uploaded!';
			  } ?>
			  <div class="col-lg-4">
			  <label>Instruction</label>
			<a href="<?=base_url().$file1;?>" download><p><?=$file?></p></a>
			<span style="font-weight:bold;color:red;"><?=$i?></span>
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