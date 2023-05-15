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
            <div class="card-header"><i class="fa fa-file-text"></i> Fees Structure</div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/updateAcadamicFees'?>" method="post">	

	        <div class="row">
			<div class="col-md-3">
                <input type="hidden" name="fees_id" id="fees_id" value="<?=$fees[0]->f_id?>" >
                <input type="hidden" name="cour_id" id="cour_id" value="<?=$fees[0]->cour_id ?>" >
                <input type="hidden" name="ayear" id="ayear" value="<?=$fees[0]->year?>" >
                <input type="hidden" name="abatch" id="abatch" value="<?=$fees[0]->batch?>" >
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" required>
			<option value="">Select Stream</option>
			<option <?php if($fees[0]->main_id == 5){echo "selected";} ?> value="5">UG</option>
			<option <?php if($fees[0]->main_id == 2){echo "selected";} ?>  value="2">PG - MSW Aided</option>
			<option <?php if($fees[0]->main_id == 1){echo "selected";} ?>  value="1">PG - Self Finance</option>
			<option <?php if($fees[0]->main_id == 3){echo "selected";} ?>  value="3">PG - MSW Self Finance</option>
			<option <?php if($fees[0]->main_id == 4){echo "selected";} ?>  value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" style="display:none;">
			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" required>
			</select>
			</div>
			<div class="col-md-3" id="year" style="display:none;">
			<label>Year</label>
			<select class="form-control year" require name="year">
			<!--<option value="">Select Year</option>
			<option value="1">1 Year</option>
			<option value="2">2 Year</option>
			<option value="3">3 Year</option>-->
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
			<select class="form-control batch" require name="batch">
			<option <?php if($fees[0]->batch == $olddate2){echo"selected";}  ?> value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option <?php if($fees[0]->batch == $olddate1){echo"selected";}  ?> value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option <?php if($fees[0]->batch == $olddate){echo"selected";}  ?>  value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option <?php if($fees[0]->batch == $date){echo"selected";}  ?>  value="<?php echo $date;?>"><?php echo $date;?></option>
			<option  <?php if($fees[0]->batch == $newdate){echo"selected";}  ?>  value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			
			</div>
            <br>
            <br>
            <div id="main" style="display:none;">

            <div class="row">
            <div class="col-md-3">
			<label>Select Category</label>
        </div>
        <div class="col-md-9">
		<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			<?php foreach ($category as $key => $value) { ?>
				<option <?php if($fees[0]->f_category == $value->ac_id){echo "selected";} ?> value="<?=$value->ac_id?>"><?=$value->ac_name?></option>
		<?php	} ?>
		
		
			</select>

            </div>
            </div>
			<br>
            <br>
            <div class="row">
            <div class="col-md-3">
			<label>Fees Name</label>
        </div>
        <div class="col-md-9">
            <input type="text" required class="form-control" name="fees_name" value="<?=$fees[0]->f_name?>">
            </div>
            </div>

            <br>
            <br>
            <div class="row">
            <div class="col-md-3">
			<label>Discription</label>
        </div>
        <div class="col-md-9">
            <textarea required class="form-control"  rows="7"  name="fees_discription"><?=$fees[0]->f_discription?></textarea>
            </div>
            </div>


			<br>
            <br>
            <div class="row">
            <div class="col-md-3">
			<label>Payment Type</label>
        </div>
        <div id="payment" class="col-md-9">
	
		<label class="radio-inline col-md-4"> <input <?php if($fees[0]->payment_type == 1  ){echo "checked";} ?> type="radio" name="payment_type" required id="fpayment" value="1" > Full Payment</label>
	
			<label class="radio-inline col-md-4"> <input <?php if($fees[0]->payment_type == 2  ){echo "checked";} ?> type="radio" name="payment_type" required id="ipayment" value="2"> Installment Payment</label>
	
            
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Amount</label>
        </div>
        <div class="col-md-9">
            <input  type="number" id="main_fees" required class="form-control" name="fees_amount" value="<?=$fees[0]->f_amount?>">
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>GST</label>
        </div>
        <div id="checkbox_div" class="col-md-9">
	
		<label class="radio-inline col-md-4"> <input <?php if($fees[0]->f_gst == 1  ){echo "checked";} ?> type="radio" name="gst"  required id="withgst" value="1" > WITH GST </label>
	
			<label class="radio-inline  col-md-4"> <input <?php if($fees[0]->f_gst == 0  ){echo "checked";} ?> type="radio" name="gst" required id="withoutgst" value="0"> WITH OUT GST </label>
	
            
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>GST Percentage</label>
        </div>
        <div class="col-md-9">
            <input  type="number" value="<?=$fees[0]->f_perc?>"  id="gst_per" class="form-control" name="gst_per">
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>GST Amount</label>
        </div>
        <div class="col-md-9">
            <input  type="number" value="<?=$fees[0]->f_gst_amt?>"  id="gst_amount" readonly class="form-control" name="gst_amount">
            </div>
            </div>


            <br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Installment Status</label>
        </div>
        <div id="instalmentfee" class="col-md-9">
	
			<label class="radio-inline col-md-4"> <input type="radio" <?php if($fees[0]->f_instalment == 1  ){echo "checked";} ?> name="instalment_status" required id="yinstalmentfee" value="1" > Yes</label>
			<label class="radio-inline col-md-4"> <input type="radio" <?php if($fees[0]->f_instalment == 0  ){echo "checked";} ?> name="instalment_status" required id="ninstalmentfee" value="0"> No</label>

            </div>
            </div>

			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Installment Fees</label>
        </div>
        <div class="col-md-9">
            <input  type="number"   value="<?=$fees[0]->f_instalment_fees?>" id="installment_fees"  class="form-control" name="installment_fees">
            </div>
            </div>



			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Start Date</label>
        </div>
        <div class="col-md-9">
            <input  type="date" value="<?=$fees[0]->f_s_date?>" required class="form-control" name="start_date">
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>End Date </label>
        </div>
        <div class="col-md-9">
            <input  type="date" value="<?=$fees[0]->f_e_date?>" required class="form-control" name="end_Date">
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Fine</label>
        </div>
        <div id="finestatus" class="col-md-9">
	
		<label class="radio-inline col-md-4"> <input <?php if($fees[0]->f_fine_status == 1  ){echo "checked";} ?> type="radio" name="fine_s" required id="wfine" value="1" > WITH Fine </label>
	
			<label class="radio-inline col-md-4"> <input <?php if($fees[0]->f_fine_status == 0  ){echo "checked";} ?> type="radio" name="fine_s" required id="wofine" value="0"> WITH OUT Fine </label>
	
            
            </div>
            </div>
			<br>
            <br>
			<div class="row">
            <div class="col-md-3">
			<label>Fine Amount Per Day </label>
        </div>
        <div class="col-md-9">
            <input  type="number" id="fine_amount" value="<?=$fees[0]->f_fine_amount?>" class="form-control" name="fine_amount">
            </div>
            </div>
			<br>
			<br>
			<div class="row">
            <div class="col-md-3">
			<label>Total </label>
        </div>
        <div class="col-md-9">
            <input  type="number" id="total_amt" class="form-control" value="<?=$fees[0]->f_total?>" readonly name="total">
            </div>
            </div>

			<br>
			<br><div class="row">
            <div class="col-md-3">
			<label>Status </label>
        </div>
        <div class="col-md-9">
           
		<label class="radio-inline col-md-4"> <input <?php if($fees[0]->f_status == 1  ){echo "checked";} ?> type="radio" name="active_s" required id="active_s" value="1" > ACTIVE </label>
	
	<label class="radio-inline col-md-4"> <input <?php if($fees[0]->f_status == 0  ){echo "checked";} ?> type="radio" name="active_s" required id="active_n" value="0"> In ACTIVE </label>

            </div>
            </div><br>
			<br>
			<div class="row">
            <div class="col-md-9">
			</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary">Update Fees</button>
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


$( document ).ready(function() {
  var amt =   $("#main_course_id").val();
  var crsid =   $("#cour_id").val();
  var ayear =   $("#ayear").val();
  var abatch =   $("#abatch").val();

   // console.log( "ready!" );
   if(amt != ""){


    $.ajax({
                url: base_url + "accounts/get_selected_app_course_id",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: amt,crsid:crsid
                },
                success: function (data) {
					$("#app_course").css('display','block');
                       $("#app_course_id").html(data);
                }
            });
   }


   if(ayear !=""){

	var html = '<option>Select Year</option>';
    if(ayear == 1){
        html += '<option value="1" selected >1 Year</option>';
    }else{
        html += '<option value="1">1 Year</option>';
    }
    if(ayear == 2){	   
		    html += '<option value="2" selected >2 Year</option>';

    }else{
        html += '<option value="2">2 Year</option>';
    }

		  if($("#main_course_id").val()==5){

            if(ayear == 2){	      
			  html += '<option value="3" selected>3 Year</option>';
            }else{
                html += '<option value="3">3 Year</option>';  
            }
			 $('.year').append(html); 
		  }	else{
			 $('.year').append(html);  
		  }
		$("#year").css('display','block');
		$('select.year>option[value=""]').prop('selected', true);
		$('#fee_struc').css('display','none');
	  $("#due_date").css('display','none');
	  $("#batch").css('display','none');


   }

   if(abatch !=""){
    $("#batch").css('display','block');
    $("#main").css('display','block');
   }else{
    $("#batch").css('display','none');
    $("#main").css('display','none');
   }
});



	var base_url = "<?php echo base_url(); ?>";
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
	</script>
	<script>
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
