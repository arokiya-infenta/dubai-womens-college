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
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
								<div class="a" style="
    text-align: center;
">
								<h2 class="ttl text-center"> Internal Marks </h2>
</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-12 jump-side">
	<table class="table table-hover">
									<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
	  <th scope="col">Subject Code</th>
      <th scope="col">ICA 1 </th>
      <th scope="col">ICA 2 </th>
      <th scope="col">Best of ICA </th>
      <th scope="col">IN CLASS</th>
      <th scope="col">TAKE HOME</th>
      <th scope="col">Total</th>
      <th scope="col">Result</th>
      
    </tr>
  </thead>
  <tbody>
						   <?php $i=1;   
				$best =0;	
				$total =0;	
				
				foreach ($internal as $key => $svalue) { 



if($svalue->ica1Mark == "A" || $svalue->ica1Mark =="" ){

$ica1=0;

}else{
	$ica1=(float)$svalue->ica1Mark;
}
if($svalue->ica2Mark == "A" || $svalue->ica2Mark =="" ){

$ica2=0;

}else{
	$ica2=(float)$svalue->ica2Mark;
}


if($ica1 > $ica2 ){

	$best=$ica1;
}else{
	$best=$ica2;

}
						
		$total = $best +		(float)$svalue->inClassMark +	(float)$svalue->takeHomeMark;	
		
		
		if($stream == 5){


if($total >= 20){

	$result ="P";
}else{

	$result ="F";

}


		}else{

			if($total >= 25){

				$result ="P";
			}else{
			
				$result ="F";
			
			}



		}
							
				//echo $stream;			
							?>
							<!-- <tr>$svalue->subCode -->
      <th scope="row"> <?=$i?> </th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td><?=$svalue->ica1Mark?></td>
      <td><?=$svalue->ica2Mark?></td>
      <td><?=$best?></td>
      <td><?=$svalue->inClassMark?></td>
      <td><?=$svalue->takeHomeMark?></td>
      <td><?=$total?></td>
      <td><?=$result?></td>
 
   
    </tr>					

	
	<?php $i++; } ?>
	
	</tbody>
	</table>


			                    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script>
	window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});
$(document).ready(function(){
	


$(".arr_exam").click(function(){


var mt = "";
var val = $(this).closest("tr");
var total= parseInt($("#tot_amt").text());

var m = parseInt(val.find('.bs_amt').val());
var s = val.find('.fees_v').val(0);



var isChecked = $(this).is(':checked');




if( isChecked == true){


	val.find('.bs_amt').html(parseInt(m));
	mt =total+m;

	$("#tot_amt").html(parseInt(mt));
	$("#f_amt").val(parseInt(mt));

}else{
//alert(total);
//alert(m);
	val.find('.bs_amt').empty();
	mt =total-m;
	$("#tot_amt").html(parseInt(mt));
	$("#f_amt").val(parseInt(mt));
}


console.log(isChecked); 

//alert(m);





});
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
div{
	color: white;
}
</style>
