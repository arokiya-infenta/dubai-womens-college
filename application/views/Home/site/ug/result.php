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
		                   
		                 </div>
		                    
							 	<div class="row">
									<?php

/* echo"<pre>";
print_r($result); */



?>
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "><a class="printPage btn btn-primary" style="color:white;" href="#"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</a></div>
								</div>
								<br>
								<br>
								<div class="a" style="
    text-align: center;
">
								<h2 class="ttl text-center"> Result </h2>
</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-12 jump-side">
									

<?php if(sizeof($result) > 0){ ?>



									<table class="table table-hover">
									<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
      <th scope="col">Code</th>
      <th scope="col">Semester</th>
      <th scope="col">Nature</th>
			<th scope="col">ICA Marks</th>
			<th scope="col">ESE Marks</th>
    
      <th scope="col">Total</th>
      
      <th scope="col">Result</th>
    </tr>
  </thead>
  <tbody>
						   <?php $i=1; 
							 
							 

							 
							 
							 
							 foreach ($result as $key => $svalue) { 



								
								if($svalue->subNature=="PRACTICAL" && $svalue->msw_m_25==1  && $svalue->subNature!=""){

						
									$mark_det = $this->db->where('batch_year',$svalue->batch_year)->where('sem',$svalue->sem)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammarkfinal')->row();
							if(isset($mark_det)){
									if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
									if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
									if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
									if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
									}
									else{
										$mark=0;
										}
							
										$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$svalue->batch_year)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammark')->row();	
							

										$icaMark = 0;
								$inClassMark = 0;
								$takeHomeMark = 0;
								if(isset($ica_mark)){
							//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}
			
			
			
			
			
			
			
							if(is_numeric($ica_mark->ica1Mark)){
			
			
								$iccamm1 = $ica_mark->ica1Mark;
													}else{
								
								
														$iccamm1 = 00.0;
								
													}	if(is_numeric($ica_mark->ica2Mark)){
								
								
								$iccamm2 = $ica_mark->ica2Mark;
													}else{
								
								
														$iccamm2 = 00.0;
								
													}
													
												
													
													
													if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
								
														$great =$iccamm1;
													}else{
														$great =$iccamm2;
								
													}
												 $great=	number_format($great,1);
						
												 $icaMark =$great;
			
												 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}
			
								if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
								if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
								$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
								
								
							
							}else{
								$icamrk = 00.0;	
								}
								
			
			
			
								$fimdMax=[];
								$arre=[];
								
								$fimdMax=array($mark2,$mark3,$mark4);
								
								$arre = sort($fimdMax);
								(float)$maxtotal = (float)$fimdMax[1];
								$ese_m = (float)$maxtotal;
			
			
			
			
			
			
			
								//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
							//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
								//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
								if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
								
								$total = ceil((float)$ica_fin + (float)$ese_m);
								$result = 0;
								
								if($svalue->main_id == 5){
									if($icamrk >= 12.5 && $ese_m >= 12.5){$result = ' <span style="color:green;font-weight:bold;">P</span> ';}
									else{
										if($icamrk >= 12.5 && $ese_m < 12.5){$result = ' R(E) ';}
										elseif($icamrk < 12.5 && $ese_m >= 12.5){$result = ' R(I) ';}
										else{$result = 'R(I + E)';}
											}
								}else{
									if($icamrk >= 12.5 && $ese_m >= 12.5){$result = '<span style="color:green;font-weight:bold;">P</span>';}
									else{
										if($icamrk >= 12.5 && $ese_m < 12.5){$result = ' R(E) ';}
										elseif($icamrk < 12.5 && $ese_m >= 12.5){$result = ' R(I)';}
										else{$result = ' R(I + E) ';}
											}
								}


							}else if($svalue->subNature=="PRACTICAL" && $svalue->msw_m_25==0 && $svalue->subNature!=""){



								$mark_det = $this->db->where('batch_year',$svalue->batch_year)->where('sem',$svalue->sem)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammarkfinal')->row();
							if(isset($mark_det)){
								if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
								if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
								if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
								if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
								}
								else{
									$mark=0;
									}
						
									$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$svalue->batch_year)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammark')->row();	
							

									$icaMark = 0;
							$inClassMark = 0;
							$takeHomeMark = 0;
							if(isset($ica_mark)){
						//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}
		
		
		
		
		
		
		
						if(is_numeric($ica_mark->ica1Mark)){
		
		
							$iccamm1 = $ica_mark->ica1Mark;
												}else{
							
							
													$iccamm1 = 00.0;
							
												}	if(is_numeric($ica_mark->ica2Mark)){
							
							
							$iccamm2 = $ica_mark->ica2Mark;
												}else{
							
							
													$iccamm2 = 00.0;
							
												}
												
											
												
												
												if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
							
													$great =$iccamm1;
												}else{
													$great =$iccamm2;
							
												}
											 $great=	number_format($great,1);
					
											 $icaMark =$great;
		
											 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}
		
							if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
							if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
							 $icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
							
							
						
						}else{
							$icamrk = 00.0;	
							}
							
		
		
		
							$fimdMax=[];
							$arre=[];
							
							$fimdMax=array($mark2,$mark3,$mark4);
							
							$arre = sort($fimdMax);
							(float)$maxtotal = (float)$fimdMax[1]+(float)$fimdMax[2];
							 $ese_m = (float)$maxtotal / 2  ;
		
		
		
		
		
		
		
							//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
						//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
							//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
							if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
							
							$total = ceil((float)$ica_fin + (float)$ese_m);
							$result = 0;
							
							if($svalue->main_id == 5){
								if($icamrk >= 20 && $ese_m >= 20){$result = '<span style="color:green;font-weight:bold;">P</span> ';}
								else{
									if($icamrk >= 20 && $ese_m < 20){$result = ' R(E) ';}
									elseif($icamrk < 20 && $ese_m >= 20){$result = ' R(I) ';}
									else{$result = 'R(I + E)';}
										}
							}else{
								if($icamrk >= 25 && $ese_m >= 25){$result = '<span style="color:green;font-weight:bold;">P</span> ';}
								else{
									if($icamrk >= 25 && $ese_m < 25){$result = ' R(E) ';}
									elseif($icamrk < 25 && $ese_m >= 25){$result = ' R(I)';}
									else{$result = ' R(I + E) ';}
										}
							}




							}else{


if($svalue->subNature!=""){

								$mark_det = $this->db->where('batch_year',$svalue->batch_year)->where('sem',$svalue->sem)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammarkfinal')->row();
								if(isset($mark_det)){
								if($mark_det->average!='' && $mark_det->average!=null){$mark=$mark_det->average;}else{$mark=0;}
								if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
								if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
								if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
								}


								$ica_mark = $this->db->select('ica1Mark, ica2Mark,inClassMark,takeHomeMark')->where('batch',$svalue->batch_year)->where('student_id',$svalue->student_id)->where('subject_id',$svalue->subject_id)->get('erp_exammark')->row();	
							



								$icaMark = 0;
								$inClassMark = 0;
								$takeHomeMark = 0;
								if(isset($ica_mark)){
							//	if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}
			
			
			
			
			
			
			
							if(is_numeric($ica_mark->ica1Mark)){
			
			
								$iccamm1 = $ica_mark->ica1Mark;
													}else{
								
								
														$iccamm1 = 00.0;
								
													}	if(is_numeric($ica_mark->ica2Mark)){
								
								
								$iccamm2 = $ica_mark->ica2Mark;
													}else{
								
								
														$iccamm2 = 00.0;
								
													}
													
												
													
													
													if(number_format($iccamm1,1) > number_format($iccamm2,1) ){
								
														$great =$iccamm1;
													}else{
														$great =$iccamm2;
								
													}
												 $great=	number_format($great,1);
						
												 $icaMark =$great;
			
												 if($great != '' || $$great != null){$icamrk = $great;}else{$icamrk = 00.0;}
			
								if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
								if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
								$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
								
								
							
							}else{
								$icamrk = 00.0;	
								}













								$fimdMax=[];
								$arre=[];
								
								$fimdMax=array($mark2,$mark3,$mark4);
								
								$arre = sort($fimdMax);
								(float)$maxtotal = (float)$fimdMax[1]+(float)$fimdMax[2];
			
		
								if($mark_det->moderate_status ==0){
								$ese_m = round($maxtotal/4);
								}else{
									$ese_m = (float)$mark_det->moderated_mark/2;
			
								}
			
					
			
			
			
			
								//if($mark != 0){$ese_fin = $mark/2;}else{$ese_fin = 0;}
							//	if($mark != 0){$ese_fin = $mark;}else{$ese_fin = 0;}
								//if($icamrk != 0){$ica_fin = $icamrk/2;}else{$ica_fin = 0;}
								if($icamrk != 0){$ica_fin = $icamrk;}else{$ica_fin = 0;}
								
								$total = ceil((float)$ica_fin + (float)$ese_m);
								$result = 0;
								
								if($svalue->main_id == 5){
									if($icamrk >= 20 && $ese_m >= 20){$result = '<span style="color:green;font-weight:bold;">P</span>';}
									else{
										if($icamrk >= 20 && $ese_m < 20){$result = '<span style="color:red">R(E)</span>';}
										elseif($icamrk < 20 && $ese_m >= 20){$result = '<span style="color:red">R(I)</span>';}
										else{$result = '<span style="color:red">R(I + E)</span>';}
											}
								}else{
									if($icamrk >= 25 && $ese_m >= 25){$result = '<span style="color:green;font-weight:bold;">P</span>';}
									else{
										if($icamrk >= 25 && $ese_m < 25){$result = '<span style="color:red">R(E)</span>';}
										elseif($icamrk < 25 && $ese_m >= 25){$result = '<span style="color:red">R(I)</span>';}
										else{$result = '<span style="color:red">R(I + E)</span>';}
											}
								}



							}





							}

					


							if($svalue->sem == 1){
								$sem = "First Semester";
							}else if($svalue->sem == 2){
								$sem ="Second Semester";
							}else if($svalue->sem == 3){
								$sem ="Third Semester";
							}else if($svalue->sem == 4){
								$sem ="Fourth Semester";
							}else if($svalue->sem == 5){
								$sem ="Fifth Semester";
							}else{
								$sem ="Sixth Semester";

							}
			/* 				if($svalue->internal  >= 25 && $svalue->external >= 25){$result = '<span style="color:green;font-weight:bold;">P</span>';}
						else{
							if($svalue->internal >= 25 && $svalue->external < 25){$result = '<span style="color:red">R(E)</span>';}
							elseif($svalue->internal < 25 && $svalue->external >= 25){$result = '<span style="color:red">R(I)</span>';}
							else{$result = '<span style="color:red">R(I + E)</span>';}}
							
							 */
							?>
							<!-- <tr>$svalue->subCode -->
      <th scope="row"><?=$i?></th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td><?=$sem?></td>
      <td><?=$svalue->subNature?></td>
			<td><?php if($ica_fin==0){echo"A";}else{echo$ica_fin;}?></td>
      <td><?php 
						
						
						if($ese_m==0){echo"A";}else{echo $ese_m;}
						
						
						?></td>
     
      <td><?=$total?></td>
      <td><?=$result?></td>
    
    </tr>					

	
	<?php $i++; } ?>
	</tbody>
	</table>
			                    
	<?php } ?>		                    	</div>
			                    			
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
$('a.printPage').click(function(){


           window.print();
           return false;
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
div {
 
 color: white;
}
</style>
