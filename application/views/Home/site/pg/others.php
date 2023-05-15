<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                 
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
	<div class="">
		    <div class="container">
		        <div class="row"> 
		            <div class="col-md-12 ">
		                    			<div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?=$this->session->flashdata('message');?>
					  <?php unset($_SESSION['message']); ?>
					 </div>
					 <div class="col-md-2 "></div>
					

					</div>

		                    <div class="headings">
		                     <h2 class="ttl">Others </h2>
		                 </div>
		                    
							 	<div class="row">
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-9 ">
						



                                    <div class="row">
	


									<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Others/resumeUpload/" > Upload resume </a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	


											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Others/grievance/" >Grievance </a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	
										

									
                                


			                    	</div>
			                    	</div>
			                    	<div class="col-lg-3 jump-side">
			                    		<div class="box-shadow">
			                    			<h4 class=" annonce">Academic Details</h4>
											<a style="color:white" ><p class="wps">My Batch :  <?=$this->session->userdata("user")["user_year"]?> </p> </a>
											<a style="color:white" ><p class="wps">My Semester :  <?php if($this->session->userdata("user")["user_semester"] == 0){
echo"Please Select the semester";

											}else if($this->session->userdata("user")["user_semester"] == 1){
												echo"First Semester";
											}else if($this->session->userdata("user")["user_semester"] == 2){
												echo"Second Semester";
											}else if($this->session->userdata("user")["user_semester"] == 3){
												echo"Third Semester";
											}else if($this->session->userdata("user")["user_semester"] == 4){
												echo"Fourth Semester";
											}else if($this->session->userdata("user")["user_semester"] == 5){
												echo"Fifth Semester";
											}else{
												echo"Sixth Semester";

											}
											
											
											
											
											
											?> </p> </a>
											
											<hr class="use-color">
											
										
			                    		</div>
			                    	</div>				
								</div>		
		   			</div>
		        </div>
	

		    </div>
	 </div>            
  </div>
<!-- end section -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

$( document ).ready(function() {
 



});


</script>

<style>

a[disabled] {
   pointer-events: none;
   cursor: default;
}


	.annonce{
	color: #fff;
    font-weight: 600;
	}
	
	.jump-side{
box-shadow: #f8f9fa26 0px 1px 4px, #f8f9fade 0px 1px 4px;
	}
	.all-head{
		color: #fff;
		font-size: 18px;
	}
	.all-head a{
		color: #fff;
	}
	.use-color{
	color: #fff;
    border: .1px solid #ffffff5e;
	}
	.foot-dist{
		padding-bottom: 46px;
	}
	.wps{
    color: #fff;
    font-size: 14px;
    line-height: 20px;
	}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.cen{padding: 8px 8px;
}
.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}

@media (min-width: 1200px){
.container {
    max-width: 1400px;
}}.stats-box {
    min-height: 115px;
    background: #ff8100e0;
    border-radius: 13px;
}
.top-head{
	text-align: inherit !important;
	font-weight: 600;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
</style>
