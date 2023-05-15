<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
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
            <div class="card-header"><i class="fa fa-file-text"></i> Student Concession</div>
            <div class="card-body">
			
    <form action="<?=base_url()?>accounts/concession" method="post" enctype="multipart/form-data">	
			<div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" name="main_course_id" id="main_course_id" required>
			<option value="">Select Main Course</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" style="display:none;">
			<label>Program</label>
			<select class="form-control" id="app_course_id" name="app_course_id" required>
			</select>
			</div>
			<div class="col-md-3" id="stu" style="display:none;">
			<label>Students</label>
			<select class="form-control select2" id="students" name="students" required>
			</select>
			</div>
			</div>
			
			<div id="con_pen" style="display:none;">
		<!--Concession-->	
		    <div class="row mt-3">
			<div class="col-md-12">
			<h5>Concession</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-3">
			<input type="number" class="form-control concession" placeholder="Enter Concession Fee" name="concession">
			</div>
			<div class="col-md-2">
			<input type="file" name="concession_doc">
			</div>
			<div class="col-md-3">
			<span class="concession_doc1"></span>&nbsp;&nbsp;<a target="_blank" class="concession_doc" style="text-decoration: underline;"></a>
			</div>
			</div>
			
		<!--Penalty-->	
		    <div class="row mt-3">
			<div class="col-md-12">
			<h5>Penalty</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-3">
			<input type="number" class="form-control penalty" placeholder="Enter Penalty Fee" name="penalty">
			</div>
			<div class="col-md-2">
			<input type="file" name="penalty_doc">
			</div>
			<div class="col-md-3">
			<span class="penalty_doc1"></span>&nbsp;&nbsp;<a target="_blank" class="penalty_doc" style="text-decoration: underline;"></a>
			</div>
			</div>
			
		<!--Scholarship-->	
		    <hr><div class="row mt-3">
			<div class="col-md-12">
			<h5>Scholarship</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-3">
			<input type="number" class="form-control scholarship" placeholder="Enter Scholarship Amount" name="scholarship">
			</div>
			<div class="col-md-2">
			<input type="file" name="scholarship_doc">
			</div>
			<div class="col-md-3">
			<span class="scholarship_doc1"></span>&nbsp;&nbsp;<a target="_blank" class="scholarship_doc" style="text-decoration: underline;"></a>
			</div>
			</div>	
			
		<!--Refund-->	
		    <hr><div class="row mt-3">
			<div class="col-md-12">
			<h5>Refund</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-3">
			<input type="number" class="form-control refund" placeholder="Enter Refund Amount" name="refund">
			</div>
			<div class="col-md-2">
			<input type="file" name="refund_doc">
			</div>
			<div class="col-md-3">
			<span class="refund_doc1"></span>&nbsp;&nbsp;<a target="_blank" class="refund_doc" style="text-decoration: underline;"></a>
			</div>
			</div>	
			
		<!--Exemption-->	
		    <hr><div class="row mt-3">
			<div class="col-md-12">
			<h5>Exemption (Check to exempt)</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-5">
			<?php foreach($get_fees_type as $fees_type){ 
			if($fees_type->name=='Tuition'){$name='tuition_fee';}
			if($fees_type->name=='Exam'){$name='exam_fee';}
			if($fees_type->name=='Infrastructure'){$name='infrastructure_fee';}
			?>
			<label class="container"><?=$fees_type->name?>
            <input type="checkbox" name="exemption[]" value="<?=$fees_type->id?>">
            <span class="checkmark"></span>
            </label>
			<?php } ?>
			</div>
			</div>
			
		<!--Announcements-->	
		    <hr><div class="row mt-3">
			<div class="col-md-12">
			<h5>Announcement</h5>
			</div>
			</div>
			<div class="row">
			<div class="col-md-12">
			<textarea class="form-control announcement" placeholder="Enter Message" name="announcement"></textarea>
			</div>
			</div>		
			
			<div class="row mt-3">
			<div class="col-md-12">
			<div class="form-group" style="float:right;">
			<button type="submit" name="submit" class="btn btn-sm btn-success">Submit</button>
			</div>
			</div>
			</div>
			</div>
		</form>
			
            </div>
          </div>
        </div>
      </div>
	  
	
				<!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
$("#main_course_id").change(function () {
	$("#stu").css('display','none');
	$("#con_pen").css('display','none');
        if ($('#main_course_id').val() != "") {
            $.ajax({
                url: base_url + "accounts/get_app_course_id",
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
			$("#stu").css('display','none');
		}
    });
$("#app_course_id").change(function () {
        if ($('#app_course_id').val() != "" && $('#main_course_id').val() != "") {
	$("#con_pen").css('display','none');
	  $(".concession").val('');
	  $(".penalty").val('');
	  $(".scholarship").val('');
	  $(".refund").val('');
	  $(".concession_doc").empty();
	  $(".concession_doc").removeAttr('href');
	  $(".concession_doc1").text('');
	  $(".penalty_doc").empty();
	  $(".penalty_doc").removeAttr('href');
	  $(".penalty_doc1").text('');
	  $(".scholarship_doc").empty();
	  $(".scholarship_doc").removeAttr('href');
	  $(".scholarship_doc1").text('');
	  $(".refund_doc").empty();
	  $(".refund_doc").removeAttr('href');
	  $(".refund_doc1").text('');
	  $(".announcement").val('');
	  $("input[type=checkbox]").removeAttr('checked');
            $.ajax({
                url: base_url + "accounts/get_students",
                type: 'POST',
                cache: false,
                data: {
                    app_course_id: $('#app_course_id').val(), 
					main_course_id: $('#main_course_id').val()
                },
                success: function (data) {
					$("#stu").css('display','block');
                       $("#students").html(data);
                }
            });
        }else{
			$("#stu").css('display','none');
		}
    });
   $('#students').select2();
	</script>
	<script>	
  $('#students').select2({}).on("change", function (e) {
  if($('#app_course_id').val() != "" && $('#main_course_id').val() != "" && $('#students').val() != "")	{
	  $('#con_pen').css('display','block');
	  $(".concession").val('');
	  $(".penalty").val('');
	  $(".scholarship").val('');
	  $(".refund").val('');
	  $(".concession_doc").empty();
	  $(".concession_doc").removeAttr('href');
	  $(".concession_doc1").text('');
	  $(".penalty_doc").empty();
	  $(".penalty_doc").removeAttr('href');
	  $(".penalty_doc1").text('');
	  $(".scholarship_doc").empty();
	  $(".scholarship_doc").removeAttr('href');
	  $(".scholarship_doc1").text('');
	  $(".refund_doc").empty();
	  $(".refund_doc").removeAttr('href');
	  $(".refund_doc1").text('');
	  $(".announcement").val('');
	  $("input[type=checkbox]").removeAttr('checked');
	  $.ajax({
                url: base_url + "accounts/get_concession",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: $('#main_course_id').val(),
                    app_course_id: $('#app_course_id').val(),
                    stu_id: $(this).val()
                },
                success: function (dataResult) {
					var dataResult = JSON.parse(dataResult);
				 var len = dataResult.length;
	   
                     if(len > 0){
					 var concession = dataResult[0].concession;
					 var concession_doc = dataResult[0].concession_doc;
					 var penalty = dataResult[0].penalty;
					 var penalty_doc = dataResult[0].penalty_doc;
					 var scholarship = dataResult[0].scholarship;
					 var scholarship_doc = dataResult[0].scholarship_doc;
					 var refund = dataResult[0].refund;
					 var refund_doc = dataResult[0].refund_doc;
					 var exemption = dataResult[0].exemption;
					 var announcement = dataResult[0].announcement;
                       $(".concession").val(concession);
                       $(".penalty").val(penalty);
                       $(".scholarship").val(scholarship);
                       $(".refund").val(refund);
					  if(concession_doc!='') {
						  var conc_doc = concession_doc.split(/-(.+)/)[1];
						  $(".concession_doc1").text(conc_doc);
						  $(".concession_doc").append('<span>Click to View</span>');
						  $(".concession_doc").attr('href',base_url+concession_doc);
					  }
					  if(penalty_doc!='') {
						  var pen_doc = penalty_doc.split(/-(.+)/)[1];
						  $(".penalty_doc1").text(pen_doc);
						  $(".penalty_doc").append('<span>Click to View</span>');
						  $(".penalty_doc").attr('href',base_url+penalty_doc);
					  }
					  if(scholarship_doc!='') {
						  var schol_doc = scholarship_doc.split(/-(.+)/)[1];
						  $(".scholarship_doc1").text(schol_doc);
						  $(".scholarship_doc").append('<span>Click to View</span>');
						  $(".scholarship_doc").attr('href',base_url+scholarship_doc);
					  }
					  if(refund_doc!='') {
						  var ref_doc = refund_doc.split(/-(.+)/)[1];
						  $(".refund_doc1").text(ref_doc);
						  $(".refund_doc").append('<span>Click to View</span>');
						  $(".refund_doc").attr('href',base_url+refund_doc);
					  }
					  if(exemption!='') {
						  var exempt = exemption.split(',');
						  $.each(exempt,function(key, value){
						  $("input[type=checkbox][value="+value+"]").prop('checked', true);
						  });
					  }
					  if(announcement!='') {
						  $(".announcement").val(announcement);
					  }
	                  }
                }
            });
  }  
   });
	</script>