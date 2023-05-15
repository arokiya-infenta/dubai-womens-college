
<div id="page-wrapper">
<div class="row">
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
</div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Student Announcements</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-success">
                    <i class="fa fa-info-circle fa-fw"></i>Student Announcements<label class="text-success"></label>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                                <form action="<?=base_url()?>hosteladminlogin/studentannouncements" method="post" enctype="multipart/form-data">	
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
			<div class="row">
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
			<div class="row">
                            <div class="col-lg-12">
                                    <div class="form-group" style="float:right;margin-top:20px;">
                                        <button type="submit" class="btn btn-success" name="submit" ><i class="fa fa-2x fa-check"></i>Save</button>
                                    </div>
                            </div>
                        </div>
		</form>
            </div>

        </div>

    </div>
    </div>
	
	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Announcements List View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($announsment) > 0) { ?>
<div class="table-responsive">
 <table id="annList" class="table table-striped table-bordered table-hover">
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

		$cour=$value->short_name;

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
     
      <td><button type="button" class="delete_post btn-primary" value="<?=$value->ann_id?>">delete</button></td> 
     
		</tr>  


		<?php

		$i++;
}
?>
        </tbody>
    </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Announcements Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>



<!-- jQuery Script-->
 <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

	<script>
	var base_url = "<?php echo base_url(); ?>";
$(".delete_post").click(function(e){
e.preventDefault();
var mnt = $(this).val();
if(confirm('Are you sure to delete?')){

$.ajax({
                url: base_url + "hosteladminlogin/delete_announcement",
                type: 'POST',
                cache: false,
                data: {
                    delete_id: mnt,
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
                url: base_url + "hosteladminlogin/get_app_course_id_fun",
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
                url: base_url + "hosteladminlogin/get_announcement",
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