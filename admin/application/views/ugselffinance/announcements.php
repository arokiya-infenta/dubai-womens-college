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
            <div class="card-header"><i class="fa fa-file-text"></i>Student Announcements</div>
            <div class="card-body">
			
    <form action="<?=base_url()?>UgSelfFinance/studentannouncements" method="post" enctype="multipart/form-data">	
	        <div class="row">
			
			<div class="col-md-3" id="year">
			<label>Year</label>
			<select class="form-control year" id="aayear" require name="year">
	
			</select>
			</div>
			<?php
            $date = date('Y'); 
              $olddate2 = date("Y",strtotime ( '-3 year' , strtotime ( $date ) )) ;
              $olddate1 = date("Y",strtotime ( '-2 year' , strtotime ( $date ) )) ;
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<div class="col-md-3" id="batch" >
			<label>Batch</label>
			<select class="form-control batch"  id="batch" require name="batch">
			<option value="">Select Batch</option>
			<option value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			<div class="col-md-3">
			<label>Title</label>
			<input type="text" class="form-control title" placeholder="Enter Title" name="title" required>
			</div>
			<div class="col-md-3">
			<label>POST expiry Date</label>
			<input type="date"  class="form-control" placeholder="date_till" required name="date_till">
			</div>
			
			</div>
			<div class="row">
			
			</div>
			<div class="row">
			
			<div class="col-md-12 mt-3">
			<label>Remark</label>
			<textarea type="text"  class="form-control content" placeholder="Enter Remarks" required name="remark"></textarea>
			</div>
			</div>
<div class="row">
			<div class="col-md-12">

			<label>Upload File</label>
			<input type="file" class="form-control" name="upload_doc">
			<a target="_blank" class="upload_doc" style="text-decoration: underline;"></a>
			</div>
			</div>
			<div class="row mt-3">
			<div class="col-md-12">
			<div class="form-group" style="float:right;">
			<button type="submit" name="submit" class="btn btn-sm btn-success">Submit</button>
			</div>
			</div>
			</div>
		</form>
			
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
                <th>Department</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Title</th>
                <th>Published till </th>
                <th>Download</th>
               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php

/* echo"<pre>";
print_r($announsment); */

$i=1;

foreach ($announsment as $key => $value) {
	
	
	if($value->ann_year == 1){

		$year ="First Year";
	}else if($value->ann_year == 2){

		$year ="Second Year";



	}else{

		$year ="Third Year";	
	}

	if($value->ann_main  == 6){

$cour="All";

	}else{

		$cour=$value->department;

	}
	
if($value->ann_upload == "" || $value->ann_upload == NULL ){

$mtdon = "No Document Uploaded";
	
}else{

	$mtdon ="<a href='".base_url().$value->ann_upload."'>Download<a>";
}
	
	?>
	



		<tr>
	<td><?=$i?></td> 
      <td><?=$cour?></td> 
      
      <td><?=$year?></td> 
      <td><?=$value->ann_batch?></td> 
      <td><?=$value->ann_name?></td> 
      <td><?=date("d-M-Y",strtotime($value->ann_date_till))?></td> 
	  <td><?=$mtdon?></td> 
     
      <td><button class="delete_post btn-primary" value="<?=$value->ann_id?>">delete</button></td> 
     
		</tr>  


		<?php

		$i++;
}
?>
        </tbody>
        <tfoot>
        <tr>
		<th>Sno</th>
                <th>Department</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Title</th>
                <th>Published till </th>
				<th>Download</th>
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
		years();
		function  years(){

var m = 5;
	$('.year').empty(); 
	var html = '<option>Select Year</option>';
		html += '<option value="1">1 Year</option>';
		html += '<option value="2">2 Year</option>';
	  if(m==5){
		  html += '<option value="3">3 Year</option>';
		 $('.year').append(html); 
	  }	else{
		 $('.year').append(html);  
	  }
	//$("#year").css('display','block');
	//$('select.year>option[value=""]').prop('selected', true);

}
	var base_url = "<?php echo base_url(); ?>";
$(".delete_post").click(function(e){
e.preventDefault();
var mnt = $(this).val();


$.ajax({
                url: base_url + "UgSelfFinance/delete_announcement",
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
	<script>	
 
</script>
