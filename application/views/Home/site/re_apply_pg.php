<?php
?>
<div class="section layout_padding padding_top padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                       <h2><span>Application Form for the Academic Year 2023 - 2024</span></h2>
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>


    <form method="post" id="formId" action="<?=base_url()?>Home/reapplYPayment" enctype="multipart/form-data">
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


<div class=""><input type="hidden" id="pr_ug_psy" value="<?=$user_details[0]->pr_ug_psy?>"  > </div>


<div class="row form-group">
<div class="col-md-12" id="course_appl">


  <?php 

$ma_cr = array();
$aid_cr = array();
$self_cr = array();

$dn = $this->db->select("applied_course_id")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",1)->get();



$num_main_1 = $dn->num_rows();

if($num_main_1 > 0){
    $main_1 = $dn->result_array();
foreach($main_1 as $as){

    array_push($ma_cr ,$as['applied_course_id']);


}




}else{


    $ma_cr = array();


} 










$dn = $this->db->select("applied_course_id")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",2)->get();



$num_aided_cs_2 = $dn->num_rows();

if($num_aided_cs_2 > 0){
    $aided_cs_2 = $dn->result_array();
foreach($aided_cs_2 as $as){

    array_push($aid_cr ,$as['applied_course_id']);


}




}else{


    $aid_cr = array();


} 




$dn = $this->db->select("applied_course_id")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->where("main_course_id",3)->get();



$num_self_cour_3 = $dn->num_rows();

if($num_self_cour_3 > 0){
    $self_cour_3 = $dn->result_array();
foreach($self_cour_3 as $as){

    array_push($self_cr ,$as['applied_course_id']);


}




}else{


    $self_cr = array();


} 







$arrt_2 = [];

//$user[0]->pr_course_2;

$arrt_2 = $aid_cr;


$act_mswaid_course = [];



foreach ($active_mswad as $key => $value) {

  if($value['appliction_active']=="" || $value['appliction_active']==0 ||$value['appliction_active']==NULL){
    array_push($act_mswaid_course, $value['cour_id']);

  }

}




?>
  
  


<h4> M.S.W (AIDED)</h4>

<input type="checkbox"  <?php if(in_array(1, $act_mswaid_course)){ echo "disabled";}  ?>   <?php if(in_array(1, $arrt_2)){ echo "checked "; echo" disabled ";}  ?>  class="checkbox_class_here_pg_aided" name="msw_aided[]" value="1">
<label for=" Community Development"> Community Development</label><br>


<input type="checkbox"  <?php if(in_array(2, $act_mswaid_course)){ echo "disabled";}  ?>  <?php if(in_array(2, $arrt_2)){ echo "checked ";  echo" disabled ";}  ?>   class="checkbox_class_here_pg_aided" name="msw_aided[]" value="2">
<label for="Medical & Psychiatric Social Work"> Medical & Psychiatric Social Work</label><br>


<input type="checkbox"  <?php if(in_array(3, $act_mswaid_course)){ echo "disabled";}  ?>  <?php if(in_array(3, $arrt_2)){ echo "checked "; echo" disabled ";}  ?>  class="checkbox_class_here_pg_aided" name="msw_aided[]" value="3">
<label for="Human Resource Management"> Human Resource Management</label><br>





    <?php
 
 $arrt_3 = [];

 //$user[0]->pr_course_3;
 
 $arrt_3 = $self_cr;


 $act_mswsf_course = [];



foreach ($active_mswsf as $key => $value) {

  if($value['appliction_active']=="" || $value['appliction_active']==0 ||$value['appliction_active']==NULL){
    array_push($act_mswsf_course, $value['cour_id']);

  }

}

 
  ?>

<h4> M.S.W (Self Finance)</h4>

<input type="checkbox" <?php if(in_array(1, $act_mswsf_course)){ echo "disabled";}  ?>  <?php if(in_array(1, $arrt_3)){ echo "checked disabled"; }  ?>  class="checkbox_class_here_pg_self" name="msw_self_finance[]" value="1">
<label for=" Community Development"> Community Development</label><br>


<input type="checkbox" <?php if(in_array(2, $act_mswsf_course)){ echo "disabled";}  ?> <?php if(in_array(2, $arrt_3)){ echo "checked disabled";}  ?>  class="checkbox_class_here_pg_self" name="msw_self_finance[]" value="2">
<label for="Medical & Psychiatric Social Work"> Medical & Psychiatric Social Work</label><br>


<input type="checkbox" <?php if(in_array(3, $act_mswsf_course)){ echo "disabled";}  ?> <?php if(in_array(3, $arrt_3)){ echo "checked disabled";}  ?>  class="checkbox_class_here_pg_self" name="msw_self_finance[]" value="3">
<label for="Human Resource Management"> Human Resource Management</label><br>







	   </div>

</div>

<!-- Select Basic -->

</div>


<div class="col-md-6">

<div class="col-md-12">

<h4> Other Self Finance Programs</h4>
<br>

<?php
$arrt = [];

$user[0]->pr_course_1;

$arrt = $ma_cr;
$read = "";
$act_sf_course = [];



foreach ($active_sf as $key => $value) {

  if($value['appliction_active']=="" || $value['appliction_active']==0 ||$value['appliction_active']==NULL){
    array_push($act_sf_course, $value['cour_id']);

  }

}
foreach ($cc as $value) {  
  
  
  if($value->cs_id != 3 ){
  if($value->cs_id != 4 ){
  /*   if($value->cs_id == 5 ||  $value->cs_id == 6 ||  $value->cs_id == 9){

        $read = "";
       // $read = "disabled";
        }else{
          $read = "";
        } */

        if($value->cs_id == 9 || $value->cs_id ==16){

          $class="psycology";
          
          }else{
            $class="";
          
          }
        

        
  ?>



<input type="checkbox" class="checkbox_class_here_pg <?=$class?>" <?php if(in_array($value->cs_id, $act_sf_course)){ echo "disabled";}  ?>   <?php if(in_array($value->cs_id, $arrt)){ echo "checked disabled";}  ?>  name="course_one[]" value="<?=$value->cs_id?>">
<label for="<?=$value->cs_name?>"> <?=$value->cs_name?></label><br>

<?php
} }} ?>


</div>
</div>
<div class="col-md-3">
<input type="hidden" readonly value="0" id="my_app_fee_others" name="my_app_fee_main" >
<br><input type="hidden" readonly value="0" id="my_app_fee_aided" name="my_app_fee_aided" >
<br><input type="hidden" readonly value="0" id="my_app_fee_fin" name="my_app_fee_fin" >
<br>
<br>
<h2> <b>Total Application Fee : </b> <b  id="appli_price"><?php

if(count($arrt) == 0 ){

$num_pri = 0 ;
}else{

  $num_pri = count($arrt) ;
}


$main_1 = $num_pri * 600 ;


if(count($arrt_2) ==0){

  $num_pri_2 = 0 ;
  $main_2 = 0;

  }else{
  
    $num_pri_2 = count($arrt_2) ;
 if($num_pri_2 == 1){

  $main_2 = 600;

 }else if($num_pri_2 == 2){

  $main_2 = 650;

 }else if($num_pri_2 == 3){

  $main_2 = 700;

 }else{

  $main_2 = 0;

 }


  }
  
  
 

  if(count($arrt_3) == 0){

    $num_pri_3 = 0 ;
    $main_3 = 0;

    }else{
    
      $num_pri_3 = count($arrt_3) ;



      if($num_pri_3 == 1){

        $main_3 = 600;
      
       }else if($num_pri_3 == 2){
      
        $main_3 = 650;
      
       }else if($num_pri_3 == 3){
      
        $main_3 = 700;
      
       }else{
        $main_3 = 0;

       }



    }
    
    
  

    $totaloff = $main_1 + $main_2 + $main_3 ;

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


  var psy =$('#pr_ug_psy').val();

//alert(m);

if(psy == 0){
    $('.psycology').prop("checked", false);
 
    $('.psycology').attr("disabled",true);
              

}else{
    $('.psycology').attr("disabled",false);


}


  
    var numberOfChecked = $('input[name="course_one[]"]:checked').length;

var day = 0; 
// alert(numberOfChecked);

// var my_app_fee =  $("#my_app_fee").val();
switch (numberOfChecked) {
case 0:
day = 0;
break;
case 1:
day = 600;
break;
case 2:
 day = 1200;
 break;
 case 3:
 day = 1800;
 break;
 case 4:
 day = 2400;
 break;
 case 5:
    day = 3000;
    break;
    case 6:
    day = 3600;
     break;
    case 7:
    day = 4200;
}



var numberOfCheckedAided = $('input[name="msw_aided[]"]:checked').length;

var aided = 0; 
// alert(numberOfChecked);

 //var my_app_fee =  $("#my_app_fee").val();
switch (numberOfCheckedAided) {
case 0:
aided = 0;
break;
case 1:
    aided = 600;
break;
case 2:
    aided = 650;
 break;
 case 3:
    aided = 700;

}

var numberOfCheckedSelf = $('input[name="msw_self_finance[]"]:checked').length;

var self = 0; 
// alert(numberOfChecked);

 
switch (numberOfCheckedSelf) {
case 0:
    self = 0;
break;
case 1:
    self = 600;
break;
case 2:
    self = 650;
 break;
 case 3:
    self = 700;

}

 
  
   // window.location.reload(history.back()); 


   //$.session.set(‘some key’, ‘a value’);

   $("#ball_fee").val(0);
   $("#my_app_fee_others").val(day);
$("#my_app_fee_aided").val(aided);
$("#my_app_fee_fin").val(self);
   var total_curr = parseInt($("#my_app_fee_others").val())+parseInt($("#my_app_fee_aided").val())+parseInt($("#my_app_fee_fin").val());
  
  
   $("#appli_price").val(total_curr);
   $("#total_fee").val(total_curr);
    var prev_fee = $("#prev_fee").val();


    var bal  = total_curr - prev_fee;
  //  alert(total_curr);
$("#ball_fee").val(bal);
$("#brg").text(parseInt(bal));

$('input[type="checkbox"]').click(function() {
    var total_curr = parseInt($("#my_app_fee_others").val())+parseInt($("#my_app_fee_aided").val())+parseInt($("#my_app_fee_fin").val());
    var prev_fee = $("#prev_fee").val();

    $("#appli_price").val(total_curr);
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