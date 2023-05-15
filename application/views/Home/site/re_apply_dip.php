<?php
?>
<div class="section layout_padding padding_top padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>PG Diploma Application for the Academic Year 2023 - 2024</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>


    <form method="post" id="formId" action="<?=base_url()?>Home/reapplYPaymentDip" enctype="multipart/form-data">
<div id="cleared" class="section contact_section" style="background:#ffffff">
    <div class="container">
<?php //print_r($this->session->userdata('user')[user_id]);
?>
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
<div class="col-md-12 course-details">
    <h5>Program Details</h5>
<!-- Form Name -->
<!-- Select Basic -->

<div class="row">
<div class="col-md-3">




<div class="row form-group">
<div class="col-md-12" id="course_appl">


  <?php 

$ma_cr = array();
$aid_cr = array();
$self_cr = array();

$dn = $this->db->select("applied_course_id")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",4)->get();



$num_main_1 = $dn->num_rows();

if($num_main_1 > 0){
    $main_1 = $dn->result_array();
foreach($main_1 as $as){

    array_push($ma_cr ,$as['applied_course_id']);


}




}else{


    $ma_cr = array();


} 










?>
  
  




	   </div>

</div>

<!-- Select Basic -->

</div>


<div class="col-md-6">

<div class="col-md-12">


<?php
$arrt = [];

$arrt = $ma_cr;
foreach ($cc as $value) {  
  
  
  if($value->cs_id != 3 ){
  if($value->cs_id != 4 ){
  
  ?>



<input type="checkbox" class="checkbox_class_here_pg"  <?php if(in_array($value->cs_id, $arrt)){ echo "checked disabled";}  ?>  name="course_one[]" value="<?=$value->cs_id?>">
<label for="<?=$value->cs_name?>"> <?=$value->cs_name?></label><br>

<?php
} }} ?>


</div>
</div>
<div class="col-md-3">
<input type="hidden" readonly value="0" id="my_app_fee_others" name="my_app_fee_main" >


<h2> <b>Total Application Fee : </b> <b  id="appli_price"><?php

if(count($arrt) == 0 ){

$num_pri = 0 ;
}else{

  $num_pri = count($arrt) ;
}


$main_1 = $num_pri * 500 ;



  
  
 


    
  

    $totaloff = $main_1 ;

?></b> <b> ₹ </b><h2>



<input type="hidden" readonly value="<?=$totaloff?>" id="prev_fee" name="prev_fee" >
<h2>Fee Paid Already   <b> <?=$totaloff?> ₹ </b></h2>



<input type="hidden" readonly value="" id="total_fee" name="total_fee" >
<input type="hidden" readonly value="" id="ball_fee" name="ball_fee" >


<h2> Balance Fees  : <b id="brg">0</b><b> ₹</b>  </h2>



</div>
</div>
</div>
</div>
<br>
<br>
<input type="submit" class="button" name="payfees" value ="Save and Pay">
<br>
<br>
</form>

<style>
.button {
  background-color: #10127a;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>


<script src="<?=base_url()?>landing/js/jquery.min.js"></script>
<script>







$( document ).ready(function() {
  
    var numberOfChecked = $('input[name="course_one[]"]:checked').length;

var day = 0; 
// alert(numberOfChecked);

// var my_app_fee =  $("#my_app_fee").val();
switch (numberOfChecked) {
case 0:
day = 0;
break;
case 1:
day = 500;
break;
case 2:
 day = 1000;

}




 
  
   // window.location.reload(history.back()); 


   //$.session.set(‘some key’, ‘a value’);

   $("#ball_fee").val(0);
   $("#my_app_fee_others").val(day);

   var total_curr = parseInt($("#my_app_fee_others").val());
  
 // alert(total_curr);
   $("#appli_price").text(total_curr);
   $("#total_fee").val(total_curr);
    var prev_fee = $("#prev_fee").val();


    var bal  = total_curr - prev_fee;
  //  alert(total_curr);
$("#ball_fee").val(bal);
$("#brg").text(parseInt(bal));

$('input[type="checkbox"]').click(function() {
    var total_curr = parseInt($("#my_app_fee_others").val());
    var prev_fee = $("#prev_fee").val();

    $("#appli_price").text(total_curr);
    $("#total_fee").val(total_curr);
    var bal  = total_curr - prev_fee;
   // alert(bal);
$("#ball_fee").val(bal);
$("#brg").text(parseInt(bal));


});
});
/* if(window.history.back()){


alert("riderect");

} */

</script>