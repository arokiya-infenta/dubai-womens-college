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
            <div class="card-header"><i class="fa fa-file-text"></i>Student Admission Report</div>
            <div class="card-body">
			
    <form action="<?=base_url()?>admin/profomaOne" method="post" enctype="multipart/form-data">	
	        <div class="row">
			
				
			
			<?php
            $date = date('Y'); 
              
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
				
			
		
			<div class="col-md-2">
			<!--<label>Stream</label>
			<select class="form-control "  id="stream" require name="stream">
			<option value="">Select Stream</option>
			<option value="1">UG</option>
			<option value="2">PG </option>
			</select>-->
			</div>
			
			<div class="col-md-6">
			<label>Category</label>

			<select class="form-control"  id="category" require name="category">
			<option value="">Select Category</option>
			<option value="1">Profoma - I (A)</option>
			<option value="2">Profoma - I (B)</option>
			<option value="3">Profoma - II </option>
			</select>
			</div>
			
			
			<div class="col-md-2">
			<!--<label>Stream</label>
			<select class="form-control "  id="stream" require name="stream">
			<option value="">Select Stream</option>
			<option value="1">UG</option>
			<option value="2">PG </option>
			</select>-->
			</div>

		
			<div class="col-md-2">
			<label>Action</label><br>
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
                url: base_url + "admin/delete_announcement",
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

$("#main_course_id").change(function () {
	$("#stu").css('display','none');
	  $(".title").val('');
	  $(".upload_doc").empty();
	  $(".upload_doc").removeAttr('href');
	  $(".remark").val('');
        if ($('#main_course_id').val() != "") {
            $.ajax({
                url: base_url + "admin/get_app_course_id_fun",
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
  $('#app_course_id').on("change", function (e) {
  if($('#app_course_id').val() != "" && $('#main_course_id').val() != "")	{
	  $(".title").val('');
	  $(".upload_doc").empty();
	  $(".upload_doc").removeAttr('href');
	  $(".upload_doc1").text('');
	  $(".remark").val('');
	  $.ajax({
                url: base_url + "admin/get_announcement",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: $('#main_course_id').val(),
                    app_course_id: $('#app_course_id').val()
                },
                success: function (dataResult) {
					var dataResult = JSON.parse(dataResult);
				 var len = dataResult.length;
	   
                     if(len > 0){
					 var title = dataResult[0].title;
					 var upload_doc = dataResult[0].upload_doc;
					 var remark = dataResult[0].remark;
                       $(".title").val(title);
					  if(upload_doc!='') {
						  var upl_doc = upload_doc.split(/-(.+)/)[1];
						  $(".upload_doc").append('<span>'+upl_doc+'</span>');
						  $(".upload_doc").attr('href',base_url+upload_doc);
					  }
					  if(remark!='') {
						  $(".remark").val(remark);
					  }
	                  }
                }
            });
  }  
   });
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
