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

		                 
		                    
							
			                    <div class="row foot-dist">
													<div class="col-lg-2 jump-side"></div>
			                    	<div class="col-lg-8 jump-side">
									<form method ="post" action="<?=base_url()?>MyExamination/myexamFees">
			                    	
									<h2 class="ttl text-center"> </h2>
									<table class="table">
  <thead>
  <tr align= "center">
      
      <td colspan="6"> Current Exam</td>
    </tr> 
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
     
      <th scope="col">Code</th>
	  <th scope="col">Semester</th>
      <th scope="col">Nature</th>
      <th scope="col">Exam Fees</th>
    </tr>
  </thead>
  <tbody>
						   <?php 
						   
						 $i= 1;
						 $tot_cur_fee = 0;
						 foreach ($current_paper as $key => $svalue) { 
							
							
							// $tot_cur_fee += (int)$svalue->fees;




							if($svalue->semester == 1){
								$sem = "First Semester";
							}else if($svalue->semester == 2){
								$sem ="Second Semester";
							}else if($svalue->semester == 3){
								$sem ="Third Semester";
							}else if($svalue->semester == 4){
								$sem ="Fourth Semester";
							}else if($svalue->semester == 5){
								$sem ="Fifth Semester";
							}else{
								$sem ="Sixth Semester";

							}
							
							?>


<tr>
      <th scope="row" scope="col"><?=$i?></th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td><?=$sem?></td>
      <td><?=strtoupper($svalue->particular_name)?></td>
      <td ></td>
    </tr>


						<!--	<a style="color: white;" href="<?=base_url()?>Academics/feedBackSubject/<?=$svalue->id?>"># <?= $svalue->subName?></a><br>-->
	


							




	<?php    $i++; } ?>
	
	<tr align= "center"> 	 	
      
      <td colspan="6"> Arrear Exam</td>
    </tr>            
			                    
									
									<?php

						if(sizeof($arr_paper)>0){
								$tot=0;
									foreach ($arr_paper as $key => $svalue) { 

								$tot +=(int)$svalue->fees;
										
										$tot_cur_fee += (int)$svalue->fees;	
										if($svalue->semester == 1){
											$sem = "First Semester";
										}else if($svalue->semester == 2){
											$sem ="Second Semester";
										}else if($svalue->semester == 3){
											$sem ="Third Semester";
										}else if($svalue->semester == 4){
											$sem ="Fourth Semester";
										}else if($svalue->semester == 5){
											$sem ="Fifth Semester";
										}else{
											$sem ="Sixth Semester";
			
										}
										
										?>
	 <tr>
      <th scope="row"><input type="checkbox" checked class="arr_exam" name="arr_exam[]" value="<?= $svalue->subject_id?>">
	  <input type="hidden" class="bs_amt" value="<?=$svalue->fees?>"></th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td><?=$sem?></td>
      <td><?=strtoupper($svalue->subNature)?></td>
      <td ><label class="fees_v"><?=$svalue->fees?></label></td>
    </tr>
	<?php }  ?>
	<tr>
      <td colspan="5">Total Amount</td>
     
      <td ><label id="tot_amt"><?=$tot_cur_fee?></label> <input type="hidden" name="exam_fees" id="f_amt" value="<?=$tot?>"></td>
    </tr>

		<?php } ?>
	</tbody>
</table>
			                    	
									<button type="submit">Submit</button>	
									</form>		
									</div>
														<div class="col-lg-2 jump-side"></div>	
								</div>		
		   			</div>
		        </div>
		

		    </div>
	 </div>            
  </div>
<!-- end section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
$( document ).ready(function() {
    console.log( "ready!" );
});
$(".arr_exam").click(function(){
var mt = "";
var val = $(this).closest("tr");
var total= parseInt($("#tot_amt").text());

var m = parseInt(val.find('.bs_amt').val());
var s = val.find('.fees_v').empty();



let isChecked = $(this).is(':checked');




if( isChecked == true){


	val.find('.fees_v').html(m);
	mt =total+m;

	$("#tot_amt").html(mt);
	$("#f_amt").val(mt);

}else{
//alert(total);
//alert(m);
	val.find('.fees_v').empty();
	mt =total-m;
	$("#tot_amt").html(mt);
	$("#f_amt").val(mt);
}


console.log(isChecked); 

//alert(m);





});



</script>
    

<style>
table thead th ,td { color: white; font-size:10pt; }
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
