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
		                     <h2 class="ttl">My Academic - <?php if($this->session->userdata("user")["user_semester"] == 0){
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
											
											
											
											
											
											?></h2>
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
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Academics/feedBack/<?=$this->session->userdata("user")["user_semester"]?>" >Feedback</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	



					
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Academics/calanderAttendence/">Attendence</a></b></h5>
												</div>
													
				    							</div>      
			          
			                    			</div>	<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Academics/certificate"  >Certificate</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	
			                    			
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Academics/electiveSubject" >Elective Subjects</a></b></h5>

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
											
											<a  style="color:white" href="#"  data-toggle="modal" data-target=".bd-example-modal-lg"> Select Semester </a>



											<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">



	<div class="modal-header">
        <h5 class="modal-title">Semester</h5>
				<?php 
		
		
	//	echo $this->session->userdata('user')['user_m_course']."<br>"; ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group row">
	<label for="staticEmail" class="col-sm-5 col-form-label">Select Semester</label>
  <div class="col-sm-7">
    <select class="form-control" id="Semester">
      <option <?php if($this->session->userdata("user")["user_semester"] ==0){echo"selected";} ?> value="0">Select Semester</option>
      <option <?php if($this->session->userdata("user")["user_semester"] ==1){echo"selected";} ?> value="1">First Semester</option>
      <option <?php if($this->session->userdata("user")["user_semester"] ==2){echo"selected";} ?> value="2">Second Semester</option>
      <option <?php if($this->session->userdata("user")["user_semester"] ==3){echo"selected";} ?> value="3">Third Semester</option>
      <option <?php if($this->session->userdata("user")["user_semester"] ==4){echo"selected";} ?> value="4">Fourth Semester</option>

	  <?php 
		
		
	//	echo $this->session->userdata('user')['user_m_course']."<br>";
		
		
		if($this->session->userdata('user')['user_m_course'] == 1){ ?>
      <option <?php if($this->session->userdata("user")["user_semester"] ==5){echo"selected";} ?> value="5">Fifth Semester</option>
      <option <?php if($this->session->userdata("user")["user_semester"] ==6){echo"selected";} ?> value="6">Sixth Semester</option>
     <?php } ?>
    </select>
	</div>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="Change_semester" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>



	
    </div>
  </div>
</div>


			                    	
							
			                    		</div>
			                    	</div>				
								</div>		
		   			</div>
		        </div>
				<!-- <div class="row">     
					<div class="col-md-12 cen text-center">
						 	<div class="stats-box border-1 pad-20">
						 		<h2> Your Reference Number : 210001</h2>
						 		<h2 style="color:red"> SMS will be delayed. Kindly check your e-mail</h2>
						 	</div>
		    		</div>
		   		</div> -->

		    </div>
	 </div>            
  </div>
<!-- end section -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

$( document ).ready(function() {
   var semester = <?=$this->session->userdata("user")["user_semester"]?>

if(semester == 0){

	$('.bd-example-modal-lg').modal('show'); 
	$('.bd-example-modal-lg').modal({backdrop: 'static', keyboard: false})  

}



});

	$("#Change_semester").click(function(e){
e.preventDefault();


var sem = $("#Semester").val();

if(sem ==0){

	alert("Please select the Semester");
}else{

	$.ajax({
type: 'post',
url: '<?=base_url()?>Academics/selectSemester',
data: {semester:sem},
success: function (data) {


	location.reload();
//alert('form was submitted');
}
}); 




}

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
