
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
					  <?php unset($_SESSION['message']); ?>
					 </div>
					 <div class="col-md-2 "></div>
					

					</div>

		                    <div class="headings">
		                     <!--<h2 class="ttl">My Dashboard <span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>-->
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
																		<?php 
								
								
								if($this->session->userdata('user')['user_year'] == date('Y')){    ?>

									<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b>

								<?php 
								
								
								if($this->session->userdata('user')['user_year'] == date('Y')){    ?>

							
									<a href="<?=base_url()?>Admissions" >	Admission</a>
									<?php	}else{   ?>

										<a href="#" >	Register This year to apply this Course</a>

										<?php	}
								?>	
									
									
								</b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	


<?php }?>





											<?php											$qm = $this->db->select("*")->from("shotlisted_candidate")->where("sl_student_id",$this->session->userdata('user')['user_id'])->where('reservation_status',1)->where('principal_published',1)->get();

$rest = $qm->num_rows();

if($rest > 0){				  ?>	


<?php if($this->session->userdata('user')['user_year']!=2020){ ?>		
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>/PayFees"  >Pay Fees</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	

									



							
									<?php } ?>		
									<?php } ?>		
										
									
									<?php   



$qm = $this->db->select("*")->from("shotlisted_candidate")->where("sl_student_id",$this->session->userdata('user')['user_id'])->where('reservation_status',1)->where('principal_published',1)->get();

$rest = $qm->num_rows();

if($rest > 0){


$q = $this->db->select("*")->from("admitted_student")->where("as_student_id",$this->session->userdata('user')['user_id'])->get();

$res = $q->num_rows();

if($res > 0){


?>
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Academics"  >Academic</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>MyExamination" >Examination</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>

									<?php } ?>	


							
							
											<div class="col-sm-3 cen text-center">
			                    				<div class="card-box">
				        				
				        							<div class="stats-box border-1 pad-20">
				        		<h5 class="all-head"><b><a href="<?=base_url()?>Others">Others</a></b></h5>

												</div>
													
				    							</div>      
			          
			                    			</div>	
										

											<?php } ?>		
									
									
								
											<?php if($this->session->userdata('user')['user_year']==2019){ ?>





<!--<div class="col-sm-3 cen text-center">
															<div class="card-box">
										
													<div class="stats-box border-1 pad-20">
								<h5 class="all-head"><b><a href="<?=base_url()?>Academics"  >Academic</a></b></h5>

										</div>
											
											</div>      
						
														</div>	
									<div class="col-sm-3 cen text-center">
															<div class="card-box">
										
													<div class="stats-box border-1 pad-20">
								<h5 class="all-head"><b><a href="<?=base_url()?>MyExamination" >Examination</a></b></h5>

										</div>
											
											</div>      
						
														</div>	-->	








<?php
} ?>		

</div>
                                


			                    	</div>
														<?php  





//echo $this->user_register_number;

//exit;



if($u_reg_num == ""){ ?>
















			                    	<div class="col-lg-3 jump-side">
			                    		<div class="box-shadow">
			                    			<h4 class=" annonce">Announcements </h4>
															<!--	<p class="wps">Internal Marks will be available on your Portal from 210/12/2020 onwards </p>
											<a style="color:white" href="/landing/PG_Admission.pdf" download><p class="wps">PG Admission schedule 2022 - Revised on 9th June (click hear) </p> </a>
			                    			<p class="wps" >Entrance Test link will be available from 7th June 2021 to 11th June 2021. You can take the test anytime during this period from your own location using a laptop.</p>
			                    			<hr class="use-color">
			                    			<p class="wps">SMS will be delayed. Kindly check your e-mail</p>-->
			                    			<hr class="use-color">
											<?php if($this->session->userdata('user')['user_m_course'] ==1){ ?>
											
											
												<!--<p class="wps">	Check the U.G. Admissions page on the website <a style="color:white" target="_blank"  href="https://mssw.in">(www.mssw.in)</a> for Provisional Selection and Wait lists</p>-->
			                    	<?php }



$last_demo = 	$this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where('applied_date >=','2022-04-1 19:20:07')->get();
	  
	  
	 $demo_lst =$last_demo->num_rows(); 
	 

	 if($demo_lst > 0) {

		$mt = 	$this->db->select("*")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->where("year",2022)->where("completed_status",1)->get();
					
					$mts =$mt->num_rows();

					if($mts > 0 ){
	 ?>
<img src="https://icon-library.com/images/new-icon-gif/new-icon-gif-3.jpg" width="50px;" height="30px;" > <a style="color:white" href="<?=base_url()?>/OnlineExamMssw/myResults" ><p class="wps">Entrance Test Result - 2022 (click hear) </p> </a>
<?php } ?>
<!--<a style="color:white" href="/landing/Guidelines_for_Entrance_Test_2022.pdf" download><p class="wps">Guidelines for Entrance Test -2022 </p> </a>-->
<!--<a style="color:white" href="/landing/Guidelines_for_Entrance_Test_2022.pdf" download><p class="wps">Guidelines for Entrance Test -2022 </p> </a>
			                    			
										
											<hr class="use-color"> 	
											<p class="wps">Internal Marks will be available on your Portal from ___ onwards </p>
											<p class="wps">8667790079</p>
											<p class="wps">7904708575</p>-->
									<!--	<p class="wps">8148574296</p>-->
											<hr class="use-color"> 	<p class="wps">The College does not accept donations/capitation fee for admissions. Admissions are made purely based on merit and the prescribed criteria for each programme. We follow a transparent admission process. Candidates are advised against paying money to anyone within or outside the College to secure admission for any programme at MSSW. It is not possible to gain admission to any program at MSSW by paying money. Candidates/Parents/Guardians are requested to bring to the notice of the Principal if they come across any information regarding violations of this. The information can be emailed to principal@mssw.in. Confidentiality will be maintained and the identity of the reporting person will be protected. </p>
			                    		<!--	<p class="wps">Exam Test Helpline : <br>9444909420,<br>7305144297</p>-->

	<?php	 	}
	
	
	 
	 
	
	 
	 ?>
									
									
			                    		</div>
			                    	</div>	
									
									








									<?php } else{ 
										
										$var = date("Y-m-d");
									/* 	echo  $var = date("Y-m-d");
										echo  $u_batch;
										echo  $u_cur_year; */


										$array_main = array(6);
										$array_app_course = array(0);
										$array_cur_year = array(0);
										$uu_batch = array(0000);




										array_push($array_main,$u_main_stream);
										array_push($array_app_course,$u_app_course);
										array_push($array_cur_year,$u_cur_year);
										array_push($uu_batch,$u_batch);
										
//print_r($array_main);



										$notificatn = $this->db->select("*")
										->from('announcement')
										 ->join(
											"department_details",
											"announcement.ann_main = department_details.main_id AND announcement.ann_course = department_details.cour_id","left"
										) 
									->where('ann_date_till >=', $var)
										
										->where_in('ann_batch ',$uu_batch )



										->where_in('ann_main ',$array_main )
										->where_in('ann_course ',$array_app_course )
										->where_in('ann_year ',$array_cur_year )
										
										->get()->result();	
										
										
										
										
										
										
								/* 	print_r($array_main);
									print_r($array_app_course);
									print_r($array_cur_year);
									print_r($notificatn);
									 */
									//exit;
										
										
										?>


										<div class="col-lg-3 jump-side">
			                    		<div class="box-shadow">
			                    			<h4 class=" annonce">Announcements</h4>


<?php  foreach ($notificatn as $key => $value) { 
	
	if($value->ann_upload==""){

$dn = "";

	}else{
		$link = $value->ann_upload;
	$dn =	'<br><a style="color:black" href="'.base_url().'admin/'.$link.'" >Download  </a>';

	}
	?>




	<a style="color:white" href="#" data-toggle="modal" data-target="#myModal<?=$value->ann_id?>"><p class="wps"><?=$value->ann_name?> </p> </a>



	<hr class="use-color">





	<div id="myModal<?=$value->ann_id?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title"><?=$value->ann_name?></h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p><?=$value->ann_desc?></p>
		<?=$dn?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
  </div>


	




<?php } ?>




										
			                    			<!--<p class="wps" >Entrance Test link will be available from 7th June 2021 to 11th June 2021. You can take the test anytime during this period from your own location using a laptop.</p>
			                    			<hr class="use-color">
			                    			<p class="wps">SMS will be delayed. Kindly check your e-mail</p>-->
			                    		
				
									
									
			                    		</div>
			                    	</div>	





								<?php	} ?>			
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



	<?php if($this->session->userdata('user')['user_year']==2019){














	} ?>
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
