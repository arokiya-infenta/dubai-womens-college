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
            <div class="card-header"><i class="fa fa-file-text"></i>Condonation Reports <button class="btn btn-primary"  data-toggle="modal" 
						data-target="#condfeeModal" style="
    
    text-align: right;
    float: right;
">Update Fees</button>

<div class="modal fade" id="condfeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Condonation Fees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form id="myForm" action="<?=base_url().'accounts/updateCondonationFees'?>" method="post">	
			<div class="row">
			
			<div class="col-md-5">
			<?php


$val  = $this->db->select("*")->from("exam_condanation_fees")->get()->result();
            $date = date('Y'); 
         
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<label>Year</label>
			<select class="form-control" require name="a_year" id="a_year" >
			<option value="">Select Year</option>
		
			<option <?php if($val[0]->year ==$olddate){ echo"selected";} ?> value="<?php  echo $olddate;?>"><?php echo $olddate;?></option>
			<option  <?php if($val[0]->year ==$date){ echo"selected";} ?> value="<?php echo $date;?>"><?php echo $date;?></option>
			<option  <?php if($val[0]->year ==$newdate){ echo"selected";} ?> value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>	<div class="col-md-5">
			<label>Condonation Fee per Paper </label>
		<input type="number" class="form-control" name="a_amount" value="<?=$val[0]->fine_amt?>">
			</div><div class="col-md-2">
			<label >Action</label>	<br>
		<input type="submit" class="btn btn-primary" name="submit" value="Update">
			</div>
			
			</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>



</div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/condonationPaidReports'?>" method="post">	
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
          
			<div class="col-md-5">
			<label>Date From</label>
           
			<input type="date" class="form-control" name="datef" required >
            </div><div class="col-md-5">
			<label>Date To</label>
            
			<input type="date" class="form-control" name="datet" required >
            </div>
			<div class="col-md-2">
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



		<div class="container-fluid">


    



<!-- Start Row-->
	 <div class="row">
			<div class="col-md-2 "></div>
			<div class="col-md-8 ">
	
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
<td><button class="btn-primary"  data-toggle="modal" data-target=".bd-example-modal-lg<?=$i?>">view</button></td>
</tr>


<div class="modal fade bd-example-modal-lg<?=$i?>"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Condonation Paid Subjects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form id="myForm" action="<?=base_url().'accounts/updateCondonationFees'?>" method="post">	
			<div class="row">
			
			<div class="col-md-12">
			<?php
 
$array =[];

$array = explode(',',$value->subject_id);


 $this->db->select("*");
 $this->db->from("erp_subjectmaster");
$this->db->where_in("id",$array);
$m =$this->db->get();
 $datacondanation = $m->result();  ?>


<div class="container">
<div class="row">
    <div class="col">
		<b>#</b>
    </div>
    <div class="col">
		<b>Subject Code</b>
    </div>
    <div class="col">
		<b>Subject Name</b>
    </div>
  </div>
<?php
//print_r($datacondanation);
$i=1;
foreach ($datacondanation as $key => $value) { ?>

  
  <div class="row">
    <div class="col">
    <?=$i?>
    </div>
    <div class="col">
    <?=$value->subCode?>
    </div>
    <div class="col">
    <?=$value->subName?>
    </div>
  </div>


<?php
$i++;

}

			?>
	</div>	
			</div>	
			
			</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>

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
