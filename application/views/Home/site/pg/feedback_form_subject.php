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
		                     <h2 class="ttl">My FeedBack form 
		                 </div>
		                    
							 	<div class="row">
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
			                    <div class="row foot-dist">
			                    	<div class="col-lg-12 ">
						  
<form method="post" action="<?=base_url()?>Academics/submitFeedBack">

<input type="hidden" name="subj_id" value="<?=$this->uri->segment(3)?>">
						   <?php foreach ($feedback as $key => $svalue) { ?>

							<div class="mb-3 row">
    <label style="color:white ;" class="col-sm-8 col-form-label"><?= $svalue->name?></label>
    <div class="col-sm-4">
	<select class="form-select" name="<?=$svalue->id_f?>"aria-label="Default select example">
  <option value="1"><?= $svalue->a?></option>
  <option value="2"><?= $svalue->b?></option>
  <option value="3"><?= $svalue->c?></option>
  <option value="4"><?= $svalue->d?></option>
</select>
    </div>
  </div>






	
	<?php } ?>
	<div class="mb-3 row">
    <label style="color:white ;" class="col-sm-9 col-form-label"></label>
    <div class="col-sm-3">
	<input type="submit" name="submit" value="submit" class="btn btn-primary">
    </div>
  </div>
</form>		                    
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
