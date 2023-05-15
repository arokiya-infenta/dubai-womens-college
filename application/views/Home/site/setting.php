
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
						





			                    	</div>
			                    	<div class="col-lg-3 jump-side">
			                    		<div class="box-shadow">
			                    			<h4 class=" annonce">Profile</h4>
			                    			<!--<p class="wps" >Entrance Test link will be available from 7th June 2021 to 11th June 2021. You can take the test anytime during this period from your own location using a laptop.</p>
			                    			<hr class="use-color">
			                    			<p class="wps">SMS will be delayed. Kindly check your e-mail</p>-->
			                    			<hr class="use-color">
                                            </div>
									
                                            <?php 




if($this->session->userdata('user')['user_m_course'] == 1){
		
		$qta =	$this->db->select("pr_photo")->from("new_preview")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	$ph = $qta->result();
    
}else if($this->session->userdata('user')['user_m_course']==2){

	$qta =	$this->db->select("pr_photo")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	$ph = $qta->result();
    

}else if($this->session->userdata('user')['user_m_course']==3){

	$qta =	$this->db->select("pr_photo")->from("new_preview_dip")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	$ph = $qta->result();
    
}else{

    exit;
}

if($ph[0]->pr_photo ==""||$ph[0]->pr_photo==null){


  
    $dd ='<img src="https://www.kindpng.com/picc/m/33-338711_circle-user-icon-blue-hd-png-download.png" name="aboutme" width="140" height="140" class="img-circle">';

}else{

    $dd ='<img src="'.base_url().'admin/uploads/'.$ph[0]->pr_photo.'" name="aboutme" width="140" height="140" class="img-circle">';

    



}

    ?>
											
                                                <div class="span3 well">
                                                    <br>
        <center>
        <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><?=$dd?></a>
        <br>
        <br>
        <h3><?= $this->session->userdata('user')['user_name']  ?></h3>
        <em>Click My Photo to Update</em>
		</center>
    </div>	
			
    <div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 >Update Photo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                   
                    </div>
                <div class="modal-body">
                <form method="post" id="formId" action="<?=base_url()?>Studentsetting/UploadPhoto" enctype="multipart/form-data">   
                

                <center>
                    <input type="hidden" name="main_course" value="<?=$this->session->userdata('user')['user_m_course']?>" >
               

                  <input type="hidden" name="ppimage" value="<?=$ph[0]->pr_photo?>">
      <input type="file"  accept="image/jpeg"  required  name="profile-img"  value="<?=$ph[0]->pr_photo?>" class="form-control" > 

                </center>
                    <hr>
                    <center>
                   
                    </center>
                    <button type="submit" class="btn btn-default" >Update Photo</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <center>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
						
			                    			
										
											<hr class="use-color"> 	<p class="wps"> </p>
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
