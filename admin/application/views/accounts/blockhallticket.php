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
            <div class="card-header"><i class="fa fa-file-text"></i> Block Hall Ticket</div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/addBlockHallTicket'?>" method="post">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" required>
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
			<select class="form-control" require id="app_course_id" name="app_course_id" required>
			</select>
			</div>
			<div class="col-md-2" id="year" style="display:none;">
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
			<div class="col-md-2" id="batch" >
			<label>Batch</label>
			<select class="form-control batch"  id="battach" require name="batch">
			<option value="">Select Batch</option>
			<option value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			<div class="col-md-2" >
			<label>Semester</label>
			<select class="form-control semester"   id="semester" require name="semester">
			<option value="">Select semester</option>
		
		
			</select>
			</div>
			</div>
            <br>
            <br>

						<div id="append_tr" style="display:none;">


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
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";


/* 	$('#stuidall').click(function() {

		if($(this).prop('checked')) {
    
			alert("S");
		} else {
			alert("F");
		}
});
 */

//$(document).ready(function() {



	$('#stuidall').click(function() {
    if($(this).is(":checked")) {
       alert();
    }
   
});
//});





$("#main_course_id").change(function () {
	
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
        }
    });


	</script>
	<script>
	$("#app_course_id").on('change', function (e) {
		$('.year').empty(); 
		$('.semester').empty(); 
var sem ="<option value=''>Select Semester</option>";
			sem +="<option value='1'>First Semester</option>";
			sem +="<option value='2'>Second Semester</option>";
			sem +="<option value='3'>Third Semester</option>";
			sem +="<option value='4'>Fourth Semester</option>";
		var html = '<option>Select Year</option>';
		    html += '<option value="1">1 Year</option>';
		    html += '<option value="2">2 Year</option>';
		  if($("#main_course_id").val()==5){
			  html += '<option value="3">3 Year</option>';

				sem +="<option value='5'>Fifth Semester</option>";
				sem +="<option value='6'>Sixth Semester</option>";

			 $('.semester').append(sem); 
			 $('.year').append(html); 
		  }	else{
			 $('.semester').append(sem);  
			 $('.year').append(html);  
		  }
		$("#year").css('display','block');
		$('select.year>option[value=""]').prop('selected', true);
		
	});
var cnt1=0;	
  $(".year").on('change', function (e) {
    $("#batch").css('display','block');
    $("#main").css('display','block');
   });


	 $("#semester").change(function(){

	var main = $("#main_course_id").val();
	var app = $("#app_course_id").val();
	var batch = $("#battach").val();

	var year = $("#aayear").val();
	var sem = $(this).val();


	if (main != "" && app != "" && batch !="" && year !="" && sem !="") {
            $.ajax({
                url: base_url + "accounts/getStudentlist",
                type: 'POST',
                cache: false,
                data: {
                    main: main,app: app,batch: batch,year: year,sem: sem,
                },
                success: function (data) {

									//alert(data);


									$("#append_tr").css('display','block');
									$("#append_tr").empty();
									$("#append_tr").html(data);
					
                }
            });
        }








	 });

 </script>
