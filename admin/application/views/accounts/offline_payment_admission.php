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
            <div class="card-header"><i class="fa fa-file-text"></i> Off Line - Payment</div>
            <div class="card-body">
			<!--<div class="row">
            <div class="col-md-4">
			<label>Application Number EX : (ABCD-22-9) </label>
        </div>
        <div class="col-md-4">
            <input type="text" required class="form-control" id ="student_name" name="student_name">
            </div>
			<div class="col-md-4">
			<button type="submit" id="searchStudent" class="btn btn-primary">search Student</button>
            </div>
            </div>-->
    <form id="myForm" action="<?=base_url().'accounts/payOfflinePayment'?>" method="post">	
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
			<div class="col-md-3" id="app_course" style="display:none;">
			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" required>
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
			<div class="col-md-3" id="batch" style="display:none;">
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
			
			</div>
            <br>
            <br>
            <div id="main" style="display:none;">
			<div class="row">
            <div class="col-md-3">
			<label>Select Category</label>
			<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			
		
		
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
			<label>Application Number EX : (ABCD-22-9) </label>
        </div>
        <div class="col-md-4">
            <input type="text" required class="form-control" id ="student_name" name="student_name">
            </div>
			<div class="col-md-4">
			<button type="submit" id="searchStudent" class="btn btn-primary">search Student</button>
            </div>
            </div>
			<br>
            <br>
			 <div class="row">
            <div class="col-md-2">
			<label>Payment Mode</label>
        </div>
        <div class="col-md-4">
          <!--  <input type="text"  class="form-control" id ="chalon_num" placeholder="Challan Number" name="chalon_num">-->
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
			<div class="col-md-4">
            <input type="text" required class="form-control" id ="chalon_remark" placeholder="Remarks" name="chalon_remark">
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
			<button type="submit" id="pay_fees" class="btn btn-primary">Pay Fees</button>
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








		$("#pay_fees").on("click", function(e){
			e.preventDefault();
			$.ajax({
		url: base_url + "accounts/payOfflinePayment",
		type:"POST",
		cache:false,
		data:$('#myForm').serialize(),
		success:function(data){

		if(data == 0){

			$("#paid-status").empty();
		$("#paid-status").html("<h1 style='color:red'>Already Paid</h1>");

		}else if(data ==1){


			$("#paid-status").empty();
			
			$("#paid-status").html("<h1 style='color:red'>Student Not Found</h1>");


		}else{

			$("#paid-status").empty();
			
		$("#paid-status").html("<h1 style='color:green'>Paid successfully</h1>");
			$("#student_name").val("");
			$("#chalon_num").val("");
			$("#chalon_remark").val("");


		}
		
			console.log(data);
		
		//alert(data);
		
			/* $("#search-result").empty();
		$("#search-result").html(data); */
		 
		}  
		});
			
		});
			
			$("#searchStudent").on("click", function(e){
			e.preventDefault();
		var student_name = $("#student_name").val();

		/* var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
var cat = $("#category").val();
var payment_type =$("#payment").val(); */
var payment_id = $("#payment_id").val();

		if (student_name !=="") {
		$.ajax({
		url: base_url + "accounts/searchStudentShotlisted",
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
		
	
	
	});
		// click one particular search name it's fill in textbox
		$(document).on("click","li", function(){
		$('#search').val($(this).text());
		$('#search-result').fadeOut("fast");
		});






$("#main_course_id").change(function () {
	$('#fee_struc').css('display','none');
	$("#due_date").css('display','none');
	$("#year").css('display','none');
	$("#batch").css('display','none');
	$("#main").css('display','none');
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
			$("#app_course").css('display','none');
			$("#fee_struc").css('display','none');
			$("#due_date").css('display','none');
			$("#year").css('display','none');
			$("#batch").css('display','none');
			$("#main").css('display','none');
		}
    });


$("#category").change(function(){



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
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



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
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



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
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
                }
            });
		}

});



$("#battach").change(function(){



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
//var cat = $(this).val();

if(main_c_id =="" || app_c_id =="" || aayear=="" || battach==""  ){


alert("Select all in above section");

}else{
	$.ajax({
                url: base_url + "accounts/SelectPaidCategory",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach
                },
                success: function (data) {

					//alert(data)
					  //$("#category").css('display','block');
                       $("#category").empty(); 
                       $("#category").html(data); 
                }
            });
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
		$('#fee_struc').css('display','none');
	  $("#due_date").css('display','none');
	  $("#batch").css('display','none');
	});
var cnt1=0;	
  $(".year").on('change', function (e) {
    $("#batch").css('display','block');
    $("#main").css('display','block');
	$("#battach").val("");
   });


   $("#checkbox_div input:radio").click(function() {
    // Do something interesting here



var m = 	$(this).val();

if(m == 1){
	$("#gst_per").val("");
	$("#gst_per").attr("readonly",false);
	$("#gst_per").attr("required",true);


}else{

$("#gst_per").val(0);
$("#gst_amount").val(0);
$("#gst_per").attr("readonly",true);
$("#gst_per").attr("required",false);

var fee = $("#main_fees").val(); 
$("#total_amt").val(fee);

}
});

$("#finestatus input:radio").click(function() {
    // Do something interesting here



var m = 	$(this).val();

if(m == 1){
	$("#fine_amount").val("");
	$("#fine_amount").attr("readonly",false);
	$("#fine_amount").attr("required",true);

}else{

$("#fine_amount").val(0);
$("#fine_amount").attr("readonly",true);
$("#fine_amount").attr("required",false);

}
});

$("#instalmentfee input:radio").click(function() {
    // Do something interesting here



var m = 	$(this).val();

if(m == 1){
	$("#installment_fees").val("");
	$("#installment_fees").attr("readonly",false);
	$("#installment_fees").attr("required",true);

	
var main = $("#main_fees").val(); 
var gst = $("#gst_amount").val(); 
var per = $("#gst_per").val(); 
var installmentamt = $("#installment_fees").val();




if(installmentamt == "" || installmentamt == 0){

installmentamt = 0;
}else{

var installmentamt = $("#installment_fees").val();	
}


sale = calculateSale(main, per);
$("#gst_amount").val(sale);
console.log(sale);


tot = total(main,sale,installmentamt);
$("#total_amt").val(tot);

}else{

$("#installment_fees").val(0);
$("#installment_fees").attr("readonly",true);
$("#installment_fees").attr("required",false);


var main = $("#main_fees").val(); 
var gst = $("#gst_amount").val(); 
var installmentamt = $("#installment_fees").val();
var per = $("#gst_per").val(); 


sale = calculateSale(main, per);
$("#gst_amount").val(sale);
console.log(sale);


tot = total(main,sale,installmentamt);
$("#total_amt").val(tot);

}
});




$("#gst_per").on("input", function() {
var fee = $("#main_fees").val(); 
var installmentamt = $("#installment_fees").val();

if(installmentamt == "" || installmentamt == 0){

	installmentamt = 0;
}else{

	var installmentamt = $("#installment_fees").val();	
}


var per = $(this).val();
if(fee == 0 || fee ==""){

alert("Please Fill Amount");
$(this).val("");
$("#main_fees").focus();

}else{

sale = calculateSale(fee, per);
$("#gst_amount").val(sale);
console.log(sale);


tot = total(fee,sale,installmentamt);
$("#total_amt").val(tot);

}

});


$("#installment_fees").on("input", function() {
var main = $("#main_fees").val(); 
var gst = $("#gst_amount").val(); 
var per = $("#gst_per").val(); 

var installmentamt = $(this).val();



if(installmentamt == "" || installmentamt == 0){

installmentamt = 0;
}else{

var installmentamt = $(this).val();
}




if(main == 0 || main ==""){

alert("Please Fill Amount");
$(this).val("");
$("#main_fees").focus();

}else{
if(installmentamt == 0){


	sale = calculateSale(main, per);
$("#gst_amount").val(sale);
console.log(sale);


tot = total(main,sale,installmentamt);
$("#total_amt").val(tot);


}else{

	sale = calculateSale(main, per);
$("#gst_amount").val(sale);
console.log(sale);


tot = total(main,sale,installmentamt);
$("#total_amt").val(tot);

	


}

console.log(Math.round(tot));

}





});





const calculateSale = (amt, per ) => {
	amt = parseFloat(amt);
	per  = parseFloat(per);
	
  return Math.round(( (per / 100) * amt )); // Sale price
}

const total =(amt,persamt,installment)=>{

	amt = parseFloat(amt);
	persamt  = parseFloat(persamt);
	installment  = parseFloat(installment);

return Math.round(( amt + persamt + installment));
	
}
 </script>
