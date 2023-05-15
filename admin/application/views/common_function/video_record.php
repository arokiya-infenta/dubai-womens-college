
<div class="clearfix"></div>
	
	<div class="content-wrapper">
	  <div class="container-fluid">
  
		  <div class="row">
					   <div class="col-md-2 "></div>
					   <div class="col-md-8 ">
						<?php if(!empty($this->session->flashdata('message'))){
  
  echo $this->session->flashdata('message');
  
			  } ?>
					   </div>
					   <div class="col-md-2 "></div>
					  </div>	
  
		<div class="row">
		  <div class="col-lg-12">
			<div class="card">
			  <div class="card-header"> 
			  <div class="row">
		  
			  <div class="col-lg-4"><i class="fa fa-file-text"></i> Videos</div>
			  <div class="col-lg-2">
				
		  
			</div>
			 
			  <div class="col-lg-2">    
		
  </div>
		  
  <div class="col-lg-2"> </div>            
		   
  
  <div class="col-lg-2">
  
  </div>
  
  
  </div>
			</div>
			  <div class="card-body">
			  <div class="row">
	  
	
<?php 

/* echo"<pre>";
print_r($video);
 */


foreach ($video as $key => $value) {   ?>

	
<!--<div class="embed-responsive embed-responsive-21by9">
  <video class="embed-responsive-item" src="https://admission.mssw.in/onlineExamVideo/<?=$value->video_name?>"></video>
</div>-->
<video width="320" height="240" controls>
  <source src="https://admission.mssw.in/onlineExamVideo/<?=$value->video_name?>" type="video/webm">
 
Your browser does not support the video tag.
</video>
 
<?php } ?>
			  </div>
			  </div>
			  </div>
			</div>
		  </div>
		</div>
	  
	  </div>
	  <!-- End container-fluid-->
	  
	  </div><!--End content-wrapper-->




