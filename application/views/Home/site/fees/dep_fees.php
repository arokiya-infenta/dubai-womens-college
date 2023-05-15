<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                 
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
 
<div id="online_exm">
    <div class="container">
        <div class="row">
             
                <div class="col-md-12 ">

                <legend class="head-one"> <h2 class="ttl">Select Fees to Pay </h2></legend> 
                    
                    <div class="headings">
                    <!-- <h2 class="ttl"> <span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>-->
                     </div>
                    <div class= "content-box well">
                    <!-- <legend class="head-one">My Dashboard </legend>-->
<?php
/* print_r($year);
print_r($batch); */    

?><form action="#">

                    <input type="hidden" name="main_c_id" id="main_c_id" value="<?=$this->uri->segment(3)?>">                    
                    <input type="hidden" name="apply_c_id" id="apply_c_id" value="<?=$this->uri->segment(4)?>">
                    
                    <div class="row">
  <label class="col-md-6 mb-3" >Batch :</label>
  <div class="col-md-6 mb-9">
 
     <select class="form-control " id="batch" name="batch" required>

     <option value="">Select... </option>
    <?php  foreach ($batch as $key => $value) { 
		
		
		if($this->session->userdata('user')['user_year'] <= $value->batch ){
		
		
		?>

        <option value="<?=$value->batch?>"><?=$value->batch?></option>
       
  <?php  } } ?>
   

     </select>
    
  </div>
</div>



                    <div class="row">
                    <label class="col-md-6 mb-3">Academic Year:</label>
  <div class="col-md-6 mb-6">
  
      <select class="form-control" name="year_category" id="year_category" required>
        <option value="">Select... </option>
        <?php 

foreach ($year as $key => $value) {
    
    
    if($value['year'] == 1 ){
$year = "First Year";

    }else if($value['year'] == 2){

        $year = "Second Year";

    }else{
        $year = "Third Year";

    }
    
    ?>
  
  <option value="<?=$value['year']?>"><?=$year?></option>
<?php
}
?>     
      </select>
	
  </div>
  </div>
 

<div class="row">
  <label class="col-md-6 mb-3"  >Category :</label>
  <div class="col-md-6 mb-9">
 
     <select class="form-control " id="category" name="fees" required>



     </select>
    
  </div>
</div>

<div class="row">
  <label class="col-md-6 mb-3"  >Payment Type:</label>
  <div class="col-md-6 mb-9">
 
     <select class="form-control " id="payment" name="fees" required>



     </select>
    
  </div>
</div>
<div class="row">
  <label class="col-md-6 mb-3"  >Fees Name :</label>
  <div class="col-md-6 mb-9">
 
     <select class="form-control " id="fees" name="fees" required>



     </select>
    
  </div>
</div>

<div id="append">


</div>
</form>
<div class="container mb-5 mt-5">
    <div class="pricing card-deck flex-column flex-md-row mb-3">
  
 
</div>

 </div>
    </div>
        </div>
     
    </div>

    
                       
         




 </div>            

           </div>			  
       </div>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";

    var main_c_id = $("#main_c_id").val();
    var apply_c_id =$("#apply_c_id").val();





$("#year_category").change(function () {


    var mt = $(this).val();
    var batch = $("#batch").val();


if(mt !=""){


    $.ajax({
                url: base_url + "PayFees/SelectCategory",
                type: 'POST',
                cache: false,
                data: {
                    batch:batch, year: mt,main_c_id:main_c_id,apply_c_id:apply_c_id,
                },
                success: function (data) {
					$("#category").html(data);
                }
            });


}else{

alert("Select Year ");

}
});

    $("#batch").change(function () {


var mt = $(this).val();

    if ($('#batch').val() != "" && $('#batch').val() != ""  ) {

     //  alert(mt);
       $.ajax({
            url: base_url + "PayFees/SelectYear",
            type: 'POST',
            cache: false,
            data: {
                 batch : mt,main_c_id:main_c_id,apply_c_id:apply_c_id,
            },
            success: function (data) {
               // alert(data);

                $("#year_category").html(data);
            }
        });
    }else{
        
alert("Select Year And Batch");
$("batch").val("");
return false;


    }
});


$("#category").change(function () {


var mt = $(this).val();

    if ($('#category').val() != "") {

      // alert(mt);
       $.ajax({
            url: base_url + "PayFees/SelectPayment",
            type: 'POST',
            cache: false,
            data: {
                year: $('#year_category').val(),batch:$('#batch').val(),main_c_id:main_c_id,apply_c_id:apply_c_id,category:mt,
            },
            success: function (data) {
              //  alert(data);

                $("#payment").html(data);
            }
        });
    }else{
        
alert("Select Year And Batch");
$("batch").val("");
return false;


    }
});

$("#payment").change(function () {


var mt = $(this).val();

    if ($('#payment').val() != "") {

      // alert(mt);
       $.ajax({
            url: base_url + "PayFees/SelectPaymentfees",
            type: 'POST',
            cache: false,
            data: {
                year: $('#year_category').val(),batch:$('#batch').val(),main_c_id:main_c_id,apply_c_id:apply_c_id,category:$('#category').val(),payment:mt,
            },
            success: function (data) {
                //alert(data);

                $("#fees").html(data);
            }
        });
    }else{
        
alert("Select Year And Batch");
$("batch").val("");
return false;


    }
});




    
    $("#fees").change(function () {


	
        if ($('#year_category').val() != "" && $('#batch').val() != "" && $(this).val()!="" ) {
          //    alert(main_c_id);
           $.ajax({
                    url: base_url + "PayFees/SelectFeesToPaid",
                    type: 'POST',
                    cache: false,
                    data: {
                        year: $('#year_category').val(),batch:$('#batch').val(),main_c_id:main_c_id,apply_c_id:apply_c_id,fees:$(this).val(),
                    },
                    success: function (data) {
                       $("#append").html(data);
                    }
            });
        }else{
            alert("Please Select the fields properly");
            return false;
		}
    });
	</script>
<style>
  
.shadow-sm{
margin-top: 28px;

}
  ul, li {

    list-style: initial;
    margin: 10px;
    
}
.card-pricing.popular {
    z-index: 1;
    border: 3px solid #007bff;
}
.card-pricing .list-unstyled li {
    padding: .5rem 0;
    color: #6c757d;
    text-align: left;
}
label{

    font-size: large;
    color: #fff;
}.text_s{

    font-size: large;
    color: #fff;
}
</style>
