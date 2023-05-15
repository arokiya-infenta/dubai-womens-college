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
            <div class="card-header"><i class="fa fa-file-text"></i>Condonation Reports <button class="btn btn-primary">Update Feees</button></div>
            <div class="card-body">
			<input type="hidden" value="<?=$app_course_id?>" id="s_prog_id">
			<input type="hidden" value="<?=$semester?>" id="s_semester">
			<input type="hidden" value="<?=$batch?>" id="s_batch">
		
    <form id="myForm" action="<?=base_url().'accounts/condonationPaidReports'?>" method="post">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" >
			<option value="">Select Stream</option>
			<option <?php if($main_course_id == 5){ echo"selected";} ?> value="5">UG</option>
			<option <?php if($main_course_id == 2){ echo"selected";} ?> value="2">PG - MSW Aided</option>
			<option <?php if($main_course_id == 1){ echo"selected";} ?> value="1">PG - Self Finance</option>
			<option <?php if($main_course_id == 3){ echo"selected";} ?> value="3">PG - MSW Self Finance</option>
			<option <?php if($main_course_id == 4){ echo"selected";} ?> value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" >
			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" >
			<option value="">Select Program</option>
			</select>
			</div>
			<div class="col-md-3" id="year" >
			
			<!--<label>Year</label>
			<select class="form-control year" id="aayear" require name="year">
			<option value="">Select Year</option>
			</select>	-->
			
			<label>Semester</label>
			<select class="form-control year" id="semester" require name="semester">
			<option value="">Select semester</option>
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
			<option <?php if($batch == $olddate2){ echo"selected";} ?> value="<?php  echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option <?php if($batch == $olddate1){ echo"selected";} ?> value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option <?php if($batch == $olddate){ echo"selected";} ?> value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option <?php if($batch == $date){ echo"selected";} ?> value="<?php echo $date;?>"><?php echo $date;?></option>
			<option <?php if($batch == $newdate){ echo"selected";} ?> value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			
			</div>
            <br>
            <br>
            <div id="main" >
			<div class="row">
          
			<div class="col-md-4">
			<label>Date From</label>
           
			<input type="date" class="form-control" name="datef"  value="<?=$datef?>" required >
            </div><div class="col-md-4">
			<label>Date To</label>
            
			<input type="date" class="form-control" name="datet" value="<?=$datet?>" required >
            </div>
			<div class="col-md-4">
			<label>Action</label><br>
			<button type="submit" class="btn btn-primary">Find Report </button>
			<a href="<?=base_url()?>Accounts/condonationReport" class="btn btn-primary">Find all </a>
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
	 <div class="col-lg-12 " style="overflow:scroll;">
		 <div class="card">
			 <div class="card-header"><i class="fa fa-file-text"></i> Paid User
	 
	 
		 
	
	
	 </div>
			 <div class="card-body">
 <?php //print_r($data); ?>
			 <table id="example_paid" class="table-striped table-bordered text-center display compact" style="width:100%">
	 <thead>
			 <tr>
					 <th>Sno</th>
					 <th>Name</th>
					 <th>Register Number</th>
					 <th>Department</th>
					 <th>Batch</th>
					 <th>Semester</th>
					 <th>Amount Paid.</th>
					 <th>Transaction id</th>
					 <th>No of Subjects</th>
					 <th>Paid Date</th>
					 <th>Payment Mode</th>
				
					 <th>View</th>
					
			 </tr>
	 </thead>
	 <tbody>
			 <?php 
			 
/* echo"<pre>";

print_r($condonation); */


			 $i=1;
			 foreach ($condonation as $key => $value) {
					 
					 
					 if($value->semester == 1){

							 $sem = "First Semester";
							
							 $year="First Year";

						 }else if($value->semester == 2){

							 $sem = "Second Semester";
							 $year="First Year";
						 
						 }else if($value->semester == 3){

							 $sem = "Third Semester";
							 $year="Second Year";
						 
						 }else if($value->semester == 4){

							 $sem = "Forth Semester";
							 $year="Second Year";
						 
						 }else if($value->semester ==5){

							 $sem = "fifth Semester";
							 $year="Third Year";
						 
						 }else {

							 $sem = "sixth Semester";
							 $year="Third Year";
						 }
						 
						 if($value->payment_mode == 0){
						 
							 $payment_mode = "ERP";
						 
						 }else{
						 
						 $payment_mode = "OFF-Line";
						 
						 }
					 
				 
					 
					 ?>
			<tr>
 <th scope="row"><?=$i?></th>
<td><?=$value->student_name?></td>
<td><?=$value->register_id?></td>
<td><?=$value->short_name?></td>
<td><?=$value->batch?></td>
<td><?=$sem?></td>
<td><?=$value->paid_amount?></td>
<td><?=$value->transaction_id?></td>
<td><?=sizeof(explode(",",$value->subject_id))?></td>
<td><?=date("d-M-Y",strtotime($value->paid_date))?></td>
<td><?=$payment_mode?></td>
<td>view subjects</td>
</tr>

 
	 

	 <?php     $i++;
			 } ?>    
	 </tbody>
	 <tfoot>
	 <tr>
	 <th>Sno</th>
					 <th>Name</th>
					 <th>Register Number</th>
					 <th>Department</th>
					 <th>Batch</th>
					 <th>Semester</th>
					 <th>Amount Paid.</th>
					 <th>Transaction id</th>
					 <th>No of Subjects</th>
					 <th>Paid Date</th>
					 <th>Payment Mode</th>
				
					 <th>View</th>
					
			 </tr>
	 </tfoot>
</table>

			 </div>
		 
		 </div>
	 </div>
 </div>


</div>
    </div><!--End content-wrapper-->

	
 
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
			$(document).ready(function(){

	var pr_id = $("#s_prog_id").val();
	var s_semester = $("#s_semester").val();
if(pr_id!= ""){


	$.ajax({
                url: base_url + "accounts/get_selected_app_course_id",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: $('#main_course_id').val(),crsid:pr_id
                },
                success: function (data) {
					$("#app_course").css('display','block');
                       $("#app_course_id").html(data);
                }
            });
}


var html = '<option  value="">Select Semester</option>';
		    html += '<option value="1">First Semester</option>';
		    html += '<option value="2">Second Semester</option>';
		    html += '<option value="3">Third Semester</option>';
		    html += '<option value="4">Fourth Semester</option>';
		  if($("#main_course_id").val()==5){
			  html += '<option value="5">Fifth Semester</option>';
			  html += '<option value="6">Sixth Semester</option>';
			 $('#semester').append(html); 
			 $("#semester").val(s_semester);
		  }	else{
			 $('#semester').append(html);  
			 $("#semester").val(s_semester);
		  }


});

	var base_url = "<?php echo base_url(); ?>";
$("#main_course_id").change(function () {
	/* $('#fee_struc').css('display','none');
	$("#due_date").css('display','none');
	$("#year").css('display','none');
	$("#batch").css('display','none');
	$("#main").css('display','none'); */
	$('#semester').empty(); 
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
		var html = '<option  value="">Select Semester</option>';
		    html += '<option value="1">First Semester</option>';
		    html += '<option value="2">Second Semester</option>';
		    html += '<option value="3">Third Semester</option>';
		    html += '<option value="4">Fourth Semester</option>';
		  if($("#main_course_id").val()==5){
			  html += '<option value="5">Fifth Semester</option>';
			  html += '<option value="6">Sixth Semester</option>';
			 $('#semester').append(html); 
		  }	else{
			 $('#semester').append(html);  
		  }
		$("#semester").css('display','block');
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
