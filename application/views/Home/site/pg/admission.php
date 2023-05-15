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
		                     <h2 class="ttl">Admission </h2>
<!-- 
		                      <h2 class="ttl">Mock Exam Dashboard <span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2> -->
                    
		                 </div>
		                    
							 	<div class="row">
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-12 ">
						
			                    		<div class="row">
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
						      						<a target="_blank" href="<?=base_url()?>/Home/previewWindowPg">  
					
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
 }else { 
	 
	 
	 if($this->session->userdata('user')['user_year'] == date("Y")){
	 
	 
	 
	 ?>

	<a href="<?=base_url()?>/Home/User">
<!---	<a href="#">-->

<?php


	 }else{ ?>
 

 <a href="#">


<?php
	 }
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
	 
	 
	 if($a > 0 ){ 
	 	
	 $result = $qta->result();
	 if($result[0]->main_course_priority == "PG" && $this->session->userdata('user')['user_year'] == date("Y") ){
	  
	  
	  ?>		
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
				        								<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourse/<?=$this->session->userdata('user')['user_id']?>">Apply for New Programs</a></b>
				        							
				        								</h5>
				        								
				        							</div>
				        							
				    							</div>
			                    			</div>
	<?php  
 
	 }else if($result[0]->main_course_priority == "DIP"){ ?>										
											
			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
				        								<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourseDip/<?=$this->session->userdata('user')['user_id']?>">Apply for New Programs</a></b>
				        							
				        								</h5>
				        								
				        							</div>
				        							
				    							</div>
			                    			</div>									
											
		 
 <?php	}else if($result[0]->main_course_priority == "UG"){ ?>		




<!--<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				        							<div class="stats-box border-1 pad-20">
													<h5 class="all-head"><b><a href="<?=base_url()?>Home/reApplyCourseUg/<?=$this->session->userdata('user')['user_id']?>">Apply for New Programs</a></b>
				        							
													</h5>
				        								
				        							</div>
				        							
				    							</div>
 </div>-->




<?php }




 }?> 
				


			<?php  
	if($a > 0 ){ 
	 	
	 $result = $qta->result();
	 if($result[0]->main_course_priority == "PG"){
	  
	  
	  ?> 				
			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceipt/<?=$this->session->userdata('user')['user_id']?>" target="_blank">Application Fee Receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>	
																
																
																<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/updateApplication/" target="_blank">Edit Application</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>

																
											
											
			<?php  
 
	 }else if($result[0]->main_course_priority == "DIP"){ ?>



			                    			<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceiptDip/<?=$this->session->userdata('user')['user_id']?>" target="_blank">Application Fee Receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>



<?php }else{ ?>											
							

	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20">
							   							<h5 class="all-head"><b><a href="<?=base_url()?>Home/downloadReceiptUg/<?=$this->session->userdata('user')['user_id']?>"  target="_blank">Application Fee Receipt</a></b>
							   							</h5>
							   						</div>
						   						</div>
			                    			</div>



<?php } 




}?>					


		<?php  
	




	if($a > 0 ){ 
	 $result_de = $qta->result();
	 if($result_de[0]->main_course_priority == "PG"){
	  
		 $time = date("G");
		if($time >= 22){ ?>


<div class="col-sm-4 cen text-center">
			<div class="card-box">
			   
				   <div class="stats-box border-1 pad-20">
					   <h5 class="all-head"><b><a id="mock_exam" href="#" >You can't write Mock exam after 10 PM</a> </b> </h5>

				   </div>
			   </div> 
		</div>
		<?php

		}else{

	
		//$where_in = array('7,8,15');
	//	$where_in = array('3');

$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where_in("main_course_id",array(1,2,3))->get();
	  
	  
			  
$demo_lst =$last_demo->result();
	 

foreach ($demo_lst as $key => $value) {
  
	 
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
					
					
				$mt = 	$this->db->select("*")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->where("year",2022)->where("completed_status",1)->get();
					
					$mts =$mt->num_rows();

					if($mts > 0 ){ ?>


<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						
							   					
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a href="<?=base_url()?>/OnlineExamMssw/myResults">Entrance Test Results </a></b> <br></h5>
							   						</div>
							   
						   						</div>
			                    			</div>



				<?php	}




	
$stu = $this->db->select("*")->from("zoom_alloc")->where("student_id",$this->session->userdata('user')['user_id'])->where("publish_link",1)->get();
						
$user =$stu->num_rows();
if($user > 0){		
					?>						
									
					
								<!--	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
				       						 			<a href="#">
				       								 		<div class="stats-box border-1 pad-20">
<a href="<?=base_url()?>MyInterview"><h5 class="all-head"><img src="https://icon-library.com/images/new-icon-gif/new-icon-gif-3.jpg" width="50px;" height="30px;" > Interview Schedule</h5></a>
					
</div>
				        								</a>
				    							</div>
			                    			</div>-->
				


<?php } ?>
											
			                    		</div>
			                    		<div class="row">
										
										
		<?php  
	
	 	
	 $result_on = $qta->result();
	 if($result_on[0]->main_course_priority == "PG"){
	  
	  
$demo_exam = $this->db->select("*")->from("demo_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->get();
			
		$exam_count = $demo_exam->num_rows();

		if($exam_count > 0){   ?>







<?php

			$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where_in("main_course_id",array(1,2,3))->get();
					  
					  
				$demo_lst =$last_demo->result();
	 

				foreach ($demo_lst as $key => $value) {
				

	  ?> 
									
										
			           <!-- 	<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a id="online_exam" href="<?=base_url()?>Home/instructionOnlineExam" >Main Exam</a></b> <br></h5>
							   						</div>
							   
						   						</div>	
			                    			</div> -->
											
											
											
											<?php  break; 
										 	
										} } 
										
									}else{ ?>

									<!--	<div class="col-sm-4 cen text-center">
										<div class="card-box">
											   <div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a  href="#" >Write Mock Exam to write Main Exam</a></b> <br></h5>
											   </div>
					   
										   </div>	
									</div> -->



								<?php	}
										
										
										?>
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
<?php } 


	}?>









			                    			<div class="col-sm-4 cen text-center">

										
										<div class="card-box">
											   <div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a  href="<?=base_url()?>Home/myApplication/<?=$this->session->userdata('user')['user_id']?>" >Download your Application</a></b> <br></h5>
											   </div>
					   
										   </div>	
									

											</div>


											<?php 

$shortlisted = 	$this->db->select("*")->from("shotlisted_candidate")->where("principal_published",1)->where("sl_student_id",$this->session->userdata('user')['user_id'])->where_in("reservation_status",array(1,2,3))->get();
					  
					  
$shortlisted_num =$shortlisted->num_rows();

if($shortlisted_num > 0){

?>
				  
				<div class="col-sm-4 cen text-center">
			                    				<div class="card-box">
							   						<div class="stats-box border-1 pad-20"><h5 class="all-head"><b><a id="online_exam" href="<?=base_url()?>OnlineExamMssw/Shortlisted" >Selection Details</a></b> <br></h5>
							   						</div>
							   
						   						</div>	
			                    			</div>
		   		



				<?php
}

?>






			                    		</div>	
			                    	</div>
			                    			
								</div>		
		   			</div>

					 

		        </div>

	

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
