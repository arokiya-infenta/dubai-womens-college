
<!-- end section -->
<!-- section -->
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
					 </div>
					 <div class="col-md-2 "></div>
					

					</div>

		                    <div class="headings">
		                     <h2 class="ttl">My Dashboard <span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>
<!-- 
		                      <h2 class="ttl">Mock Exam Dashboard <span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2> -->
                    
		                 </div>
		                    
							 	<div class="row">
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-9 ">
						
			                    		<div class="row">
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
						      						<a target="_blank" href="http://test.mssw.in//Home/previewWindowPg">  
					
					        							<div class="stats-box border-1 pad-20">
					       
						   
						   	<?php 
		
		$qta =	$this->db->select("*")->from("Applyed_Master")->where("user_id",$this->session->userdata('user')['user_id'])->get();
	
		$a = $qta->num_rows();

if($a > 0 ){

$result = $qta->result();
if($result[0]->main_course_priority == "PG"){


		?>
	      <a target="_blank" href="<?=base_url()?>/Home/previewWindowPg">  
		
<?php
}else if($result[0]->main_course_priority == "DIP"){ ?>


<a target="_blank" href="<?=base_url()?>/Home/previewWindowDip">  


	<?php
}
 }else {  ?>

	<a href="<?=base_url()?>/Home/User">
<!---	<a href="#">-->

<?php
} ?>
						   
						   
						   
						   
					        								<h5 class="all-head"><b>My Application</b></h5>
					        							</div>
				        							</a>
				    							</div>
			                    			</div>
			                    		
				        <?php   
						
						$stu = $this->db->select("*")->from("zoom_alloc")->where("student_id",$this->session->userdata('user')['user_id'])->where("publish_link",1)->get();
						
						$user =$stu->num_rows();

						if($user > 0){ ?>
	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				       						 			<a href="#">
				       								 		<div class="stats-box border-1 pad-20">
<a href="<?=base_url()?>MyInterview"><h5 class="all-head"><img src="https://icon-library.com/images/new-icon-gif/new-icon-gif-3.jpg" width="50px;" height="30px;" > Interview Schedule</h5></a>
					
</div>
				        								</a>
				    							</div>
			                    			</div>
			<?php }else{ ?>

			<!--	<h5 class="all-head"><b>Interview Details</b> <br>(Interview Not Scheduled)</h5>-->
					<?php	}

						?>
				        									



						<?php  ?>					
											
											
											
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        						
<?php if($a > 0 ){ 
	?>
	 <?php  
	 
	 
	 
	 	
	$result = $qta->result();
	if($result[0]->main_course_priority == "PG"){
	 
	$com = $this->db->select("*")->from("Certificate_comments")->where("student_id",$this->session->userdata('user')['user_id'])->where("status",1)->get();
$c_com = $com->num_rows();

if($c_com > 0){

	$img = '<img src="https://icon-library.com/images/new-icon-gif/new-icon-gif-3.jpg" width="50px;" height="30px;" >';
}else{

	$img="";
}



	 ?>  




		<h5 class="all-head"><b><a href="<?=base_url()?>Home/updateCertificatesPg/<?=$this->session->userdata('user')['user_id']?>"><?=$img?>Update Certificate</a></b>	</h5>






	<?php  

	}else if($result[0]->main_course_priority == "DIP"){
		
		?>			        								



	

<?php }else{ ?>


	<h5 class="all-head"><b><a  href="<?=base_url()?>Home/updateCertificatesUg/<?=$this->session->userdata('user')['user_id']?>">Update Your Certificate</a></b>	</h5>

<?php 
}







}else{ ?>


<h5 class="all-head"><b><a onclick="return false"  disabled="" href="#">Update Your Certificate</a></b>	</h5>



<?php
} ?>
													</div>
													
				    							</div>      
			          
			                    			</div>
											
											
											
											
			                    		</div>
			                    		<div class="row">
										
								<?php  
	 
	 
	 
	 	
	 $result = $qta->result();
	 if($result[0]->main_course_priority == "PG"){
	  
	  
	  ?>		
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
				        								<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourse/<?=$this->session->userdata('user')['user_id']?>">Apply for New Courses</a></b>
				        							
				        								</h5>
				        								
				        							</div>
				        							
				    							</div>
			                    			</div>
	<?php  
 
	 }else if($result[0]->main_course_priority == "DIP"){ ?>										
											
			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
				        								<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourseDip/<?=$this->session->userdata('user')['user_id']?>">Apply for New Courses</a></b>
				        							
				        								</h5>
				        								
				        							</div>
				        							
				    							</div>
			                    			</div>									
											
		 
 <?php	}else if($result[0]->main_course_priority == "UG"){ ?>		




<!--<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
													<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourseUg/<?=$this->session->userdata('user')['user_id']?>">Apply for New Courses</a></b>
				        							
													</h5>
				        								
				        							</div>
				        							
				    							</div>
 </div>-->




<?php } ?> 
				


			<?php  
	
	 	
	 $result = $qta->result();
	 if($result[0]->main_course_priority == "PG"){
	  
	  
	  ?> 				
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceipt/<?=$this->session->userdata('user')['user_id']?>" target="_blank">Download Your receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>
											
											
			<?php  
 
	 }else if($result[0]->main_course_priority == "DIP"){ ?>



			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceiptDip/<?=$this->session->userdata('user')['user_id']?>" target="_blank">Download Your receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>



<?php }else{ ?>											
							

	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceiptUg/<?=$this->session->userdata('user')['user_id']?>"  target="_blank">Download Your receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>



<?php } ?>					


		<?php  
	
	 	
	 $result_de = $qta->result();
	 if($result_de[0]->main_course_priority == "PG"){
	  



		$where_in = array('7,8,15');
	//	$where_in = array('3');

$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",1)->get();
	  
	  
			  
$demo_lst =$last_demo->result();
	 

foreach ($demo_lst as $key => $value) {
   if($value->applied_course_id ==7 || $value->applied_course_id ==8 ||$value->applied_course_id ==15){
	 
	 ?> 


			              	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   					
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a id="mock_exam" href="<?=base_url()?>Home/instructionMockUp" >Mock Exam</a> </b> </h5>
							     
							   						</div>
						   						</div> 
			                    			</div>
											
											
											
											
					<?php

break;
   }
 				
	 }
				} 
					
					
				$mt = 	$this->db->select("*")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->where("status",1)->get();
					
					$mts =$mt->num_rows();

					if($mts > 0 ){ ?>


<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						
							   					
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a href="<?=base_url()?>/OnlineExamMssw/myResults">Entrance Test Results </a></b> <br></h5>
							   						</div>
							   
						   						</div>
			                    			</div> 	



				<?php	}
					
					?>						
									
					

				



											
			                    		</div>
			                    		<div class="row">
										
										
		<?php  
	
	 	
	 $result_on = $qta->result();
	 if($result_on[0]->main_course_priority == "PG"){
	  
	  

				$where_in = array('7,8,15');
			//	$where_in = array('3');

				$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",1)->get();
					  
					  
				$demo_lst =$last_demo->result();
	 

				foreach ($demo_lst as $key => $value) {
				   if($value->applied_course_id ==7 || $value->applied_course_id ==8 ||$value->applied_course_id ==15){

	  ?> 
									
										
			              	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a id="online_exam" href="<?=base_url()?>Home/instructionOnlineExam" >Main Exam</a></b> <br></h5>
							   						</div>
							   
						   						</div>	
			                    			</div>
											
											
											
											<?php  break; } 
										 	
										} } ?>
											<?php  
	
	 	
	$result_ge = $qta->result();
	if($result_ge[0]->main_course_priority == "PG"){
	 
	 
	 ?> 						
											
											
			                    			<!--<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						
							   					
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a href="<?=base_url()?>/OnlineExamMssw/myResults">Entrance Test Results </a></b> <br></h5>
							   						</div>
							   
						   						</div>
			                    			</div> -->
<?php } ?>


			                    			<div class="col-sm-4 cen text-center"></div>
			                    		</div>	
			                    	</div>
			                    	<div class="col-lg-3 jump-side">
			                    		<div class="box-shadow">
			                    			<h4 class=" annonce">Announcements</h4>
			                    			<!--<p class="wps" >Entrance Test link will be available from 7th June 2021 to 11th June 2021. You can take the test anytime during this period from your own location using a laptop.</p>
			                    			<hr class="use-color">
			                    			<p class="wps">SMS will be delayed. Kindly check your e-mail</p>-->
			                    			<hr class="use-color">
											<?php if($this->session->userdata('user')['user_m_course'] ==1){ ?>
											
												<p class="wps">	Check the U.G. Admissions page on the website <a style="color:white" target="_blank"  href="https://mssw.in">(www.mssw.in)</a> for Provisional Selection and Wait lists</p>
			                    	<?php }

$where_in = array('7,8,15');

$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",1)->get();
	  
	  
	 $demo_lst =$last_demo->result();
	 

	 foreach ($demo_lst as $key => $value) {
		if($value->applied_course_id ==7 || $value->applied_course_id ==8 ||$value->applied_course_id ==15){ ?>

<hr class="use-color"> 
			                    			<p class="wps">Exam Test Helpline : <br>9444909420,<br>7305144297</p>

	<?php	 break;	}
	
	 }
	 
	 
	
	 
	 ?>
									
								
			                    			
										
											<hr class="use-color"> 	<p class="wps">The College does not accept donations/capitation fee for admissions. Admissions are made purely based on merit and the prescribed criteria for each programme. We follow a transparent admission process. Candidates are advised against paying money to anyone within or outside the College to secure admission for any programme at MSSW. It is not possible to gain admission to any program at MSSW by paying money. Candidates/Parents/Guardians are requested to bring to the notice of the Principal if they come across any information regarding violations of this. The information can be emailed to principal@mssw.in. Confidentiality will be maintained and the identity of the reporting person will be protected. </p>
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

<script>
/* document.getElementById("mock_exam").addEventListener("click", function(event){
  event.preventDefault();
  $('#myModal').modal({
	backdrop: 'static',
    keyboard: false},
	'show');
});


document.getElementById("online_exam").addEventListener("click", function(event){
  event.preventDefault();
  $('#myModal1').modal({
	  
	backdrop: 'static',
    keyboard: false},
	'show');
}); */

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
