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
					  
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	
			
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Student Mail</div>
            <div class="card-body">
			
    <form action="<?=base_url()?>subadmin/studentMail" method="post" enctype="multipart/form-data">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control main_course_id" name="main_course_id" id="main_course_id" required>
			<option value="">Select Main Course</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			<option value="6">All</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" style="display:none;">
			<label>Program</label>
			<select class="form-control app_course_id" id="app_course_id" name="app_course_id" required>
			</select>
			</div>
			<div class="col-md-3" id="year" style="display:none;">
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
			
			
			</div>
			<div class="row mt-3">
			<div class="col-md-3">
			<label>Subject</label>
			<input type="text" class="form-control title" placeholder="Enter Subject" name="subject" required>
			</div>
			<div class="col-md-9">
			<label>Message</label>
			<textarea type="text"  class="form-control content" placeholder="Enter Mail Message" required name="message"></textarea>
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
            <div class="card-header"><i class="fa fa-file-text"></i>Student Mails</div>
            <div class="card-body">
				
            <table id="example_fees" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Department</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

<?php

/* echo"<pre>";
print_r($announsment); */

$i=1;

foreach ($student_mail as $mail) {
	?>
	



		<tr>
	<td><?=$i?></td> 
      <td><?=$mail->short_name?></td> 
      
      <td><?=$mail->year?></td> 
      <td><?=$mail->batch?></td>  
      <td><?=$mail->subject?></td> 
      <td><?=$mail->message?></td> 
      <td><?=date("d-M-Y",strtotime($mail->created_at))?></td> 
     
      <td><button type="button" class="delete_post btn-primary" value="<?=$mail->id?>">delete</button></td> 
     
		</tr>  


		<?php

		$i++;
}
?>
        </tbody>
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
var id = $(this).val();
if(confirm('Are you sure to delete?')){

$.ajax({
                url: base_url + "subadmin/delete_mail",
                type: 'POST',
                cache: false,
                data: {
                    delete_id: id,
                },
                success: function (dataResult) {
					location.reload();
                }
            });
}
});

$("#main_course_id").change(function () {
	$("#stu").css('display','none');
	  $(".title").val('');
	  $(".upload_doc").empty();
	  $(".upload_doc").removeAttr('href');
	  $(".remark").val('');
        if ($('#main_course_id').val() != "") {
            $.ajax({
                url: base_url + "subadmin/get_app_course_id_fun",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: $('#main_course_id').val()
                },
                success: function (data) {
					$("#app_course").css('display','block');
                       $("#app_course_id").html(data);
                }
            });
        }else{
			$("#app_course").css('display','none');
			$("#fee_struc").css('display','none');
		}
    });
	</script>
	<script>	
   $("#app_course_id").on('change', function (e) {
		$('.year').empty(); 
		var html = '<option>Select Year</option>';
		    html += '<option value="1">1 Year</option>';
		    html += '<option value="2">2 Year</option>';
		  if($("#main_course_id").val()==5){
			  html += '<option value="3">3 Year</option>';
			 $('.year').append(html); 
		  }	else{
			 $('.year').append(html);  
		  }
		$("#year").css('display','block');
		$('select.year>option[value=""]').prop('selected', true);
	
	});

	
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>