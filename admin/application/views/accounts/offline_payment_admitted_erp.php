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
            <div class="card-header"><i class="fa fa-file-text"></i> Off Line - Payment - After Second Semaster</div>
            <div class="card-body">
			<div class="row">
            <div class="col-md-4">
			<label>Reference Number</label>
        </div>
        <div class="col-md-4">
            <input type="text" required class="form-control" id ="student_ref_number" name="student_ref_number">
            </div>
			<div class="col-md-4">
			<button type="submit" id="searchrefStud" class="btn btn-primary">search Student</button>
            </div>
            </div>
			<br>
			<div  id="student_information" style="display:none" style="color:blue;">
            <div class="row" >
            <div class="col-md-3">
						
							
			<label>Name :</label>
			<label id="sname"></label>
        </div>
        <div class="col-md-4">
		<label>Dept :</label>
		<label id="sdept"></label>
            </div>
			<div class="col-md-2">
			<label>Batch :</label>
			<label id="sbatch"></label>
            </div><div class="col-md-3">
			<label>App.No :</label>
			<label id="sappno"></label>
            </div>
            </div>
			<br>
            </div>
    <form id="myForm" action="<?=base_url().'accounts/payOfflinePayment'?>" method="post">	
	       
            <br>
            <br>
            <div id="main" >
			<div class="row">
			<input type ="hidden"  name="ssmain" id="ssmain" value="0" />
							<input type ="hidden"  name="sscour" id="sscour" value="0" />
							<input type ="hidden"  name="ssyear" id="ssyear"  value="0"/>
							<input type ="hidden"  name="ssbatch" id="ssbatch" value="0"/>
			<?php
$cat = $this->db->select("*")->from("accounts_category")->get()->result();


?>
            <div class="col-md-3">
			<label>Select Category</label>
			<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			<?php    
			
			foreach ($cat as $key => $value) { ?>
				<option value="<?=$value->ac_id?>"><?=$value->ac_name?></option>
		<?php	}
			
			
			?>
			
		
		
			</select>

        </div>
        <div class="col-md-3">
		<label>Select Payment Type</label>
		<select class="form-control batch" id="payment" require name="payment">
			<option value="">Select Payment type</option>
			
		
			</select>
            </div>

			<div class="col-md-3">
		<label>Payment Name</label>
		<select class="form-control batch" id="payment_name" require name="payment_name">
			<option value="">Select Payment Name</option>
			
		
			</select>
            </div>
            </div>
			<br>
            <br>


            <div id="catedory_div" class="row">

			</div>
			
			

			<br>
            <br>
            <div class="row">
            <div class="col-md-4">
			<label>Reference Number </label>
        </div>
        <div class="col-md-4">
            <input type="text" required readonly class="form-control" id ="student_name" name="student_name">
            </div>
			<div class="col-md-4">
		
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-2">
			<label>Challan Number</label>
        </div>
        <div class="col-md-2">
		<select  class="form-control" required aria-label="Default select example" id ="chalon_num" placeholder="Challan Number" name="chalon_num">
  <option  value="">Select Payment Mode</option>
  <option value="NEFT">NEFT</option>
  <option value="CASH">CASH</option>
  <option value="CHEQUE">CHEQUE</option>
  <option value="SCHOLARSHIP">SCHOLARSHIP</option>
  
</select>
            </div>
			<div class="col-md-2">
			<label>Remarks</label>
        </div>
			<div class="col-md-2">
            <input type="text" required class="form-control" id ="chalon_remark" placeholder="Remarks" name="chalon_remark">
            </div><div class="col-md-2">
			<label>Paid Date</label>
        </div>
			<div class="col-md-2">
            <input type="date" required class="form-control" id ="date_paid" name="date_paid">
            </div>
            </div>
			<br>
            <br>
			<div id="search-result" >

			</div>
			<div id="paid-status" >

			</div>
          
			<div class="row">
            <div class="col-md-11">
			</div>
			<div class="col-md-1">
			<button type="submit" id="pay_fees" disable class="btn btn-primary">Pay Fees</button>
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
	<script>


var base_url = "<?php echo base_url(); ?>";
$("#searchrefStud").on("click", function(e){
			e.preventDefault();
		var student_name = $("#student_ref_number").val();
		if (student_name !=="") {
		$.ajax({
		url: base_url + "accounts/searchStudentShotlistedNumberAdmitted",
		type:"POST",
		cache:false,
		data:{student_name:student_name},
		success:function(data){



			const obj = JSON.parse(data);

			console.log(obj);

			var smain_id = obj[0].sl_main_id;
			var scourse_id = obj[0].sl_course_id;
			var sbatch = obj[0].year;
			var sacadamic_year = new Date(obj[0].year,3,1);
			var scurrentDate = new Date(<?=date('Y')?>, <?=date('m')-1?>, <?=date('d')?>);
			console.log(sacadamic_year);
			console.log(scurrentDate);
		var mon =	monthDiff(new Date(obj[0].year,03),new Date(<?=(int)date('Y')?>,<?=(int)date('m')-1?>));
		console.log(monthDiff(new Date(1999, 02), new Date(2000, 02)));
if(mon <= 12){
		var y = 1;
		}else if(mon > 12 && mon <= 24){
			var y = 2;
		}else{
			var y = 3;
		} 

		function monthDiff(dateFrom, dateTo) {
 return dateTo.getMonth() - dateFrom.getMonth() + 
   (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
}


	
			console.log(smain_id);
			console.log(scourse_id);
			console.log(sbatch);
			console.log(sacadamic_year);
			console.log(scurrentDate);

		$("#ssmain").val("");
		$("#ssmain").val(smain_id);
		$("#sscour").val("");
		$("#sscour").val(scourse_id);
		$("#ssbatch").val("");
		$("#ssbatch").val(sbatch);
		$("#ssyear").val("");
		$("#ssyear").val(y);


$("#student_information").css("display","block");
//$("#main_course_id").(obj[0].as_name);
$("#sname").empty();
$("#sname").html(obj[0].as_name);
$("#sdept").empty();
$("#sdept").html(obj[0].course_name);
$("#sbatch").empty();
$("#sbatch").html(obj[0].year);
$("#sappno").empty();
$("#sappno").html(obj[0].application_number);
$("#student_name").val("");
$("#student_name").val(obj[0].as_reg_num);

		//$("#search-result").empty();
		//$("#search-result").html(data);
		 
		}  
		});
		}else{
		//$("#search-result").html("");  
		//$("#search-result").fadeOut();
		}
		
	
	
	});	
	$("#category").change(function(){



var main_c_id = $("#ssmain").val();
var app_c_id = $("#sscour").val();
var aayear = $("#ssyear").val();
var battach = $("#ssbatch").val();
var cat = $(this).val();

if(main_c_id =="" || app_c_id =="" || aayear=="" || battach=="" || cat =="" ){


alert("Select all in above section");

}else{
	$.ajax({
                url: base_url + "accounts/SamePaymentMethod",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,cat:cat
                },
                success: function (data) {

				//	alert(data)
					 $("#payment").empty();
                       $("#payment").html(data); 
                }
            });
		}

});
$("#payment").change(function(){


	var main_c_id = $("#ssmain").val();
var app_c_id = $("#sscour").val();
var aayear = $("#ssyear").val();
var battach = $("#ssbatch").val();
var cat = $("#category").val();
var payment_type = $(this).val();

if(main_c_id =="" || app_c_id =="" || aayear=="" || battach=="" || cat =="" ||payment_type =="" ){


alert("Select all in above section");


}else{

	$.ajax({
                url: base_url + "accounts/SamePaymentName",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,cat:cat,payment_type:payment_type
                },
                success: function (data) {
					$("#payment_name").empty();
                    $("#payment_name").html(data); 
				
                }
            });
		}

});

$("#payment_name").change(function(){



	var main_c_id = $("#ssmain").val();
var app_c_id = $("#sscour").val();
var aayear = $("#ssyear").val();
var battach = $("#ssbatch").val();
var cat = $("#category").val();
var payment_type =$("#payment").val();
var payment_name = $(this).val();

if(main_c_id =="" || app_c_id =="" || aayear=="" || battach=="" || cat =="" || payment_type =="" || payment_name =="" ){


alert("Select all in above section");


}else{

	$.ajax({
                url: base_url + "accounts/selectCompleteDetails",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,cat:cat,payment_type:payment_type,payment_name:payment_name
                },
                success: function (data) {
					//alert(data);
					   $("#catedory_div").empty();
                       $("#catedory_div").html(data); 

											 feeStatus($("#student_name").val(),$("#payment_id").val());
                }
            });
		}

		function feeStatus(stud,payment){
//$("#searchStudent").on("click", function(e){
		//	e.preventDefault();
		var student_name = stud;

	
var payment_id = payment;

//alert(student_name);
//alert(payment_id);

		if (student_name !=="") {
		$.ajax({
		url: base_url + "accounts/searchStudentShotlistedAdmitted",
		type:"POST",
		cache:false,
		data:{student_name:student_name,payment_id:payment_id},
		success:function(data){

			//console.log(data);


		$("#search-result").empty();
		$("#search-result").html(data);
		 
		}  
		});
		}else{
		$("#search-result").html("");  
		$("#search-result").fadeOut();
		}
		
	
	
//	});
}	

});


 </script>
