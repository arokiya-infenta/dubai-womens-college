<style>
label.gst_la, label.inst {
            float: left;
        }	
          
 span.gst, span.insta {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px 20px;
			margin-top: -11px;
        }
 span.instd {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px -1px;
			margin-top: -11px;
        }
		label {
    font-size: larger;
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
            <div class="card-header"><i class="fa fa-file-text"></i>Generate Reports </div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/consolidatedPaidReports'?>" method="post">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" >
			<option value="">Select Stream</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" >
			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" >
			<option value="">Select Program</option>
			</select>
			</div>
			<div class="col-md-3" id="year" >
			
			<label>Year</label>
			<select class="form-control year" id="aayear" require name="year">
			<option value="">Select Year</option>
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
			<select class="form-control batch"  id="battach"  name="batch">
			<option value="">Select Batch</option>
			<option value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			
			</div>
            <br>
            <br>
            <div id="main" >
			<div class="row">
            <div class="col-md-3">
			<label>Select Category</label>
        
		<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			<?php foreach ($category as $key => $value) { ?>
				<option value="<?=$value->ac_id?>"><?=$value->ac_name?></option>
		<?php	} ?>
		
		
			</select>

            </div>
			<div class="col-md-3">
			<label>Date From</label>
           
			<input type="date" class="form-control" name="datef" required >
            </div><div class="col-md-3">
			<label>Date To</label>
            
			<input type="date" class="form-control" name="datet" required >
            </div>
			<div class="col-md-3">
			<label>Action</label><br>
			<button type="submit" class="btn btn-primary">Find Report </button>
			</div>
            </div>

			
			
		</form>
			<?php


//print_r($get_fees_type);
/* foreach ($get_fees_type as $key => $value) {
   
} */



?>
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
	<script>
	var base_url = "<?php echo base_url(); ?>";
$("#main_course_id").change(function () {
	/* $('#fee_struc').css('display','none');
	$("#due_date").css('display','none');
	$("#year").css('display','none');
	$("#batch").css('display','none');
	$("#main").css('display','none'); */
	$('.year').empty(); 
	//$("#stu").css('display','none');
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
		/* 	$("#app_course").css('display','none');
			$("#fee_struc").css('display','none');
			$("#due_date").css('display','none');
			$("#year").css('display','none');
			$("#batch").css('display','none');
			$("#main").css('display','none'); */
		}
    });





	</script>
	<script>
	$("#app_course_id").on('change', function (e) {
	//	$('.year').empty(); 
		var html = '<option  value="">Select Year</option>';
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
	/* 	$('#fee_struc').css('display','none');
	  $("#due_date").css('display','none');
	  $("#batch").css('display','none'); */
	});
var cnt1=0;	
  $(".year").on('change', function (e) {
    $("#batch").css('display','block');
    $("#main").css('display','block');
   });












 </script>
