<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?=base_url()?>white-version/assets/plugins/summernote/dist/summernote-bs4.css"/>
<style>
.select2-selection{
 height: 37px!important;
 padding-top: 4px;
}
.select2-selection__arrow {
	top: 4px!important;
}
.select2-container{
	width: inherit!important;
}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	
			
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Enquiry</div>
            <div class="card-body">
	
			
            </div>
          </div>
        </div>
      </div>
	  
	
				<!-- End Row-->
				<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Student Announcements</div>
            <div class="card-body">
				
            <table id="example_fees" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Name</th>
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Mobile </th>
                <th>Email</th>
               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php

/* echo"<pre>";
print_r($announsment); */

$i=1;

foreach ($enquirey as $key => $value) {
	
	if($value->eq_status_comp == 0 ){

		$status = "<button class='btn-danger'>Open</button>";

	}else if($value->eq_status_comp == 1){
		$status = "<button class='btn-warning'>Pending</button>";

	}else{
		$status = "<button class='btn-success'>Closed</button>";

	}
	
	?>
	



		<tr>
		<td><?=$i?></td> 
     
      <td><?=$value->eq_name?></td> 
      <td><?=$value->eq_title?></td> 
      <td><?=date("d-M-Y",strtotime($value->eq_recived))?></td> 
      <td><?=$status?></td> 
      <td><?=$value->eq_mobile?></td> 
      <td><?=$value->eq_email?></td> 
           
      <td><a class="btn btn-primary" href="<?=base_url()?>Admin/viewEnquiry/<?=$value->eq_id?>">view</a>
	  <!--<button class="delete_enquiry btn-primary" value="<?=$value->eq_id?>">delete</button>-->
	</td> 
     
		</tr>  


		<?php

		$i++;
}
?>
        </tbody>
        <tfoot>
        <tr>
		<th>Sno</th>
                <th>Name</th>
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Mobile </th>
                <th>Email</th>
               
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

  
			
            </div>
          </div>
        </div>
      </div>
	  
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

	<script>
	var base_url = "<?php echo base_url(); ?>";
$(".delete_post").click(function(e){
e.preventDefault();
var mnt = $(this).val();


$.ajax({
                url: base_url + "admin/delete_enquiry",
                type: 'POST',
                cache: false,
                data: {
                    delete_id: mnt,
                },
                success: function (dataResult) {
					location.reload();
                }
            });
});


	</script>
