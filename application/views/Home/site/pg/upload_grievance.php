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
			                    <div class="row foot-dist">
								<h2 class="ttl text-center">My Grievance </h2>
			                    	<div class="col-lg-12 jump-side">


								

									<button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal">
 Create Grievance
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Grievance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <?php echo form_open_multipart('Others/saveGrievance');?>
	
	<div class="mb-3">

  <label for="formFile" class="ttl form-label">Grievance </label>
  <textarea class="form-control"  type="text" required name="Grievance" ></textarea>

  <label for="formFile" class="ttl form-label">Upload file</label>
  <input class="form-control" accept="application/pdf,application/msword,
  application/vnd.openxmlformats-officedocument.wordprocessingml.document" type="file" name="ppimage" >
</div>

<button type="submit" class="btn btn-primary">Save</button>

</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>

									<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Grievance</th>
      <th scope="col">Created</th>
      <th scope="col">Grievance Solution</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php 

$i=1;

foreach ($grievance as $key => $value) { 
	
	
	
	if($value->attachment_file == "" ){

		$download="File Not Uploaded";
	}else{

		$download="<a href='".base_url()."admin/resume_uploads/".$value->attachment_file."'>Download</a>";

	}
	
	
	?>


	<tr>
      <th scope="row"><?=$i?></th>
      <td><?=$value->grievance?></td>
      <td><?=date("d-M-y",strtotime($value->created_at))?></td>
      <td><?=$value->grievance_solution?></td>
      <td><?=$value->status?></td>
      <td><?=$download?></td>
    </tr>




	
<?php } ?>

</tbody>
</table>
<!--<form  method="post" action="<?=base_url()?>Others/saveResume">
									<div class="mb-3">
  <label for="formFile" class="ttl form-label">Upload Resume</label>
  <input class="form-control" accept="application/pdf,application/msword,
  application/vnd.openxmlformats-officedocument.wordprocessingml.document" type="file" name="ppimage" id="formFile">
</div>

<button type="submit" class="btn btn-secondary">Save</button>

</form>-->

		
									

					

			                    
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
