<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
	<div class="profile-main">
      <!--Start Dashboard Content-->
      <div class="profile-header"> 
   
     
 <?php 




?>


<div class="row">
<div class="col-md-12 course-details">
<br>
<br>
<br>
<div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	



                    <form  id="formId" method="post" action="<?=base_url()?>UgSelfFinance/updateMarkUser/<?=$this->uri->segment(3)?>">                    
<div class="row">



<div class="col-md-6 ">
<div class="card">
            <div class="card-header"><h5>+2 Professional marksheet </h5></div>
            <div class="card-body">

        
           
           <?php if($student[0]->pr_provisional_mark_sheet !="" || $student[0]->pr_provisional_mark_sheet !=NULL){ ?>
           
           
           <?php
           
           echo "<a target='_blank'  href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($student[0]->pr_provisional_mark_sheet)."'>Download Certificate</a>";
           echo " || <a target='_blank'  href='".base_url()."uploads/".$student[0]->pr_provisional_mark_sheet."'>View Certificate</a>";
           
           
           ?>
           
           <?php
     
     $pr ="uploads/".$student[0]->pr_provisional_mark_sheet;



$type =  mime_content_type($pr);

if($type =="application/pdf"){ ?>


<object data="<?=base_url()."uploads/".$student[0]->pr_provisional_mark_sheet?>" type="application/pdf" width="100%" height="100%">
<p>Alternative text - include a link <a href="<?=base_url()."uploads/".$student[0]->pr_provisional_mark_sheet?>">to the PDF!</a></p>
</object>

<?php
}else{


    ?>
    <img height="900px" class="img-responsive" src="<?=base_url()."uploads/".$student[0]->pr_provisional_mark_sheet?>" alt="professional marksheet">

 <?php   
}


     ?>




           <?php
           
           
           
           }else{
           
           
           echo"Not Uploded";
           
           
           
           } ?> 
      















</div>
</div>
</div>
<div class="col-md-6 ">
<div class="card">
            <div class="card-header"><h5>Community Certificate </h5></div>
            <div class="card-body">
          
           
           <?php if($student[0]->pr_comunity_cert !="" || $student[0]->pr_comunity_cert !=NULL){ ?>
           
           
           <?php
           
           echo "<a target='_blank'  href='".base_url()."UgSelfFinance/UploadFile?file=".urlencode($student[0]->pr_comunity_cert)."'>Download Certificate</a>";
           echo " || <a target='_blank'  href='".base_url()."uploads/".$student[0]->pr_comunity_cert."'>View Certificate</a>";
           
           
           ?>
             <?php
     
     $cm ="uploads/".$student[0]->pr_comunity_cert;



$type =  mime_content_type($cm);

if($type =="application/pdf"){ ?>


<object data="<?=base_url()."uploads/".$student[0]->pr_comunity_cert?>" type="application/pdf" width="100%" height="100%">
<p>Alternative text - include a link <a href="<?=base_url()."uploads/".$student[0]->pr_comunity_cert?>">to the PDF!</a></p>
</object>

<?php
}else{


    ?>
    <img height="900px" class="img-responsive" src="<?=base_url()."uploads/".$student[0]->pr_comunity_cert?>" alt="Community certificate">

 <?php   
}


     ?>
           <?php
           
           
           
           }else{
           
           
           echo"Not Uploded";
           
           
           
           } ?> 
   


  </div>

     
</div>
</div>
</div>

<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<div class="card">
            <div class="card-header"><h5>Update Mark and community</h5></div>
            <div class="card-body">



<br>

<div class="row">
 <div class=" col-md-12 stud-details">
<h5>+2 Language  Mark Details</h5>
       <div class="row">      
<div class="col-md-3 ">
<div class="row">

<label class="col-md-12 control-label" for="selectbasic">Part One & Two </label>
<br>

</div>
<input type="text" required class="form-control" name="part_lang_1" value="<?=$student[0]->lang_1?>" placeholder="Part One Language">  <br>
<select name="part_lang_2" id="part_lang" class="form-control"  >
  <option value="">Select Part Two Language</option>
  <option <?php if($student[0]->lang_2 == "English"){echo"selected";}  ?> value="English">English</optionif>
  <option <?php if($student[0]->lang_2 == "Exempted"){echo"selected";}  ?> value="Exempted">Exempted</option>

</select>
</div>
<!-- +1 Mark Details start -->
<div class="col-md-9 plus-one">

<div class="row">

<label class="col-md-6 control-label" for="selectbasic">Max. Marks </label>
<label class="col-md-6 control-label" for="selectbasic">Marks Obtained </label>


</div>
<div class="row">
<div class="col-md-6">
<div class="row">
<div class="col-md-12">
<select name="max_mark_lang_1" class="form-control"  >
  <option value="">Select Max. Marks</option>
  <option  <?php if($student[0]->lang_1_max_mark == "100"){echo"selected";}  ?> value="100">100</option>
  <option   <?php if($student[0]->lang_1_max_mark == "200"){echo"selected";}  ?>  value="200">200</option>

</select>
</div>
</div>
</div>
<div class="col-md-6">
<div class="row">
<div class="col-md-12">
<input type="number" required value="<?=$student[0]->lang_1_obt_mark?>" class="form-control" name="mark_lang_1"  placeholder="60">
</div>
</div>
</div>


   </div>
   <br>
<div class="row">
       <div class="col-md-6">
       <div class="row">
       <div class="col-md-12">
       <select name="max_mark_lang_2" id="lang_mark" class="form-control"  >
  <option value="">Select Max. Marks</option>
  <option  <?php if($student[0]->lang_2_max_mark == "100"){echo"selected";}  ?> value="100">100</option>
  <option  <?php if($student[0]->lang_2_max_mark == "200"){echo"selected";}  ?> value="200">200</option>

</select> </div>
       </div>
       </div>
       <div class="col-md-6">
       <div class="row">
       <div class="col-md-12">
       <input type="number"  id="parttwomark" value="<?=$student[0]->lang_2_obt_mark?>" class=" form-control" name="mark_lang_2"   placeholder="60">
       </div>
       </div>
       </div>
     
	  
       </div>
  



</div>
<!-- +1 Mark Details end -->
<!-- +2 Mark Details start-->

<!-- +2 Mark Details end -->
</div> 
       </div> 
   </div> 
   <br><br>
<div class="row">
 <div class=" col-md-12 stud-details">
<h5>+2 Main Subject Mark </h5>
<br>
       <div class="row">      

       <?php 


$ind = $this->db->select("*")->from("sub_preview_ug_main_sub")->where("student_id",$this->uri->segment(3))->get();

$res_num = $ind->num_rows();

?>
<div class="col-md-12 plus-one">


<?php if($res_num == 0 ){?>

 <div class="row">

<label class="col-md-4 control-label" for="selectbasic">Select Max Mark </label>
<label class="col-md-4 " for="selectbasic"> <input type="radio" <?php if($student[0]->ug_max_mark == 100){echo"checked";} ?>  name="max_mark" value="100"  /> 100 </label>
<label class="col-md-4 " for="selectbasic"><input type="radio" <?php if($student[0]->ug_max_mark == 200){echo"checked";} ?>  name="max_mark" value="200" /> 200  </label>
</div>

<?php }else{ ?>


  <span class="required">
<b>Note : </b> 
  TO edit your main subject mark you need to delete all your main subject mark listed bellow<br><br>
</span>
  <input type="hidden" value="<?=$student[0]->ug_max_mark?>" name="max_mark"   />

<?php } ?>



<div id="main_div" class="row">




<table class="table">
    <thead>
      <tr>
        <th>Subject</th>
        <th>Max. Marks</th>
        <th>Marks Obtained</th>
        <th>Percentage</th>
        <th>ADD / Delete</th>
      </tr>
    </thead>
    <tbody id="append">







  


    <?php if($res_num > 0 ){
 $percr=0;
 $total_mark=0;
$res_res = $ind->result();

foreach ($res_res as $key => $value) { ?>
      <tr>
        <td><input type="text"  value="<?=$value->ug_subject_name?>" class="form-control"  placeholder="Subject Name"></td>
        <td><input type="number" readonly value="<?=$student[0]->ug_max_mark?>" class="form-control " name=""  placeholder="Max. Marks">
</td>
        <td><input type="number" readonly value="<?=$value->ug_mark_obtained?>" class="obt_mark  form-control"   placeholder="Marks Obtained">
</td>
        <td><input type="number" readonly value="<?=$value->ud_percentage?>" class="form-control "  placeholder="Percentage ">
</td>
        <td><button type="button" value="<?=$value->ug_ms_id?>" class="btn btn-danger delete_marc"  >X</button></td>
      </tr>



<?php

 $total_mark += $value->ug_mark_obtained;
 $percr += $value->ud_percentage ;

}
$mark_tot = $total_mark;
$all_per =  (($percr / $res_num));


    }else{ ?>



<tr>
        <td><input type="text"  value="" class="form-control"  name="subject_name[]" placeholder="Subject Name"></td>
        <td><input type="number" readonly value="100" class="form-control max_mark" name=""  placeholder="Max. Marks">
</td>
        <td><input type="number"  value="" class="plusonetot obt_mark form-control" name="obt_mark[]"  placeholder="Marks Obtained">
</td>
        <td><input type="number" readonly value="" class="form-control percentage" name="percentage[]"  placeholder="Percentage ">
</td>
        <td><button type="button"  class="btn btn-success" id="add_con"  >+</button></td>
      </tr>


  <?php  }
    ?>  
     
    </tbody>
  </table>



  
  <table  class="table">
    <tbody >

        
      <?php   if($res_num > 0 ){   ?>
           <th>Total Mark Obtained</th> 
        <td ><input type="number" readonly value="<?=$mark_tot?>"   class="form-control  tot_mark" name="total_mark"  placeholder="Total Mark Obtained">
   
        </td>
        <th>Over All Percentage</th><td ><input type="number" readonly value="<?=number_format((float)$all_per, 2, '.', '')?>"  class="form-control tot_perc" name="over_all_percentage"  placeholder="Over All Percentage">
</td>
        <?php   }else{ ?></php>
        
          <th>Total Mark Obtained</th>  <td >
    <input type="number" readonly value="<?=$student[0]->total_mark_obt?>"  id="tot_mark" class="form-control  tot_mark" name="total_mark"  placeholder="Total Mark Obtained">
    </td>
    <th>Over All Percentage</th><td ><input type="number" readonly value="" id="tot_perc" class="form-control tot_perc" name="over_all_percentage"  placeholder="Over All Percentage">
</td>
    <?php  } ?>

            



      </tr>
     
    </tbody>
  </table>




   </div>
<div >


</div>



</div>
<!-- +1 Mark Details end -->
<!-- +2 Mark Details start-->

<!-- +2 Mark Details end -->
</div> 
       </div> 
   </div> 


   <label class="col-form-label " required for="recipient-name">Community </label>
  <div class="col-md-12">
  <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "OC"){echo"checked";} ?> value="OC" > OC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "BC"){echo"checked";} ?>  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
    </label> 
    
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "MBC(V)"){echo"checked";} ?> value="MBC(V)" > MBC(V)
    </label>  
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "MBC"){echo"checked";} ?> value="MBC" > MBC
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "SC"){echo"checked";} ?> value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($student[0]->pr_community == "ST"){echo"checked";} ?> value="ST" > ST
    </label>
    
   
  </div>
  <div class="row">
  <div class="col-md-4">
  </div>
  <div class="col-md-4">
    <input type ="submit" class="float-right btn btn-primary" name="submit" value="Update">
  </div>
  <div class="col-md-4">

<?php
  $this->db->select('*');
                
                $this->db->from('verified_ug');
                $this->db->Where('stu_id',$this->uri->segment(3));
                $this->db->Where('main_id',5);
                $this->db->Where('applied_id',$this->session->userdata("user")["user_dep_status"]);
               
              $ver_s=  $this->db->get();

              $ver = $ver_s->num_rows();
              
              if($ver > 0){ ?>
                <input type ="submit" class="float-right btn btn-warning" name="submit" value="Verify Update">


      <?php        }else{ ?>

        <input type ="submit" class="float-right btn btn-success" name="submit" value="Verify">

<?php
              }

?>

  </div>
  </div>
</form>

</div>
</div>
</div>
</div>
</form>
</div>









</div>

</div>
</div>



















    
    </div>
    </div>
    
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .center_div{
    margin: 0 auto;
    width:80% /* value of your choice which suits your alignment */
}
   .ls-view {
    float: right;
    color: black;
}
    </style>
      <script src="<?=base_url()?>white-version/assets/js/jquery.min.js"></script>
    <script>

$(document).ready(function() {
   // calculateTotalMain();
   // calculateTotalPercentage();



    function calculateTotalMain() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".plusonetot").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
	$("#tot_mark").val(sum);
}
 
function calculateTotalPercentage() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".percentage").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
    var rowCount = $("#append tr").length;

//$("#tot_subj").val(rowCount);
var m = sum / rowCount;


	$("#tot_perc").val(m);
}

 
});

$(".obt_mark").on("keydown keyup", function() {
    calculateTotalMain();
    calculateTotalPercentage();
});


$("#add_con").click(function(){
//alert();

var app = ' <tr class="delrw">'+
        '<td><input type="text" required value="" class="form-control"  name="subject_name[]" placeholder="Subject Name"></td>'+
        '<td><input type="number" readonly value="100" class="form-control max_mark" name="lang_1_mark__obtained_plus_1"  placeholder="Max. Marks">'+
'</td>'+
        '<td><input type="number" required value="" class="plusonetot obt_mark form-control" name="obt_mark[]"  placeholder="Marks Obtained">'+
'</td>'+
        '<td><input type="number" readonly value="" class="form-control percentage" name="percentage[]"  placeholder="Percentage ">'+
'</td>'+
        '<td><button type="button"  class="btn btn-danger delete" >X</button></td>'+
      '</tr>';


$("#append").append(app);

$(".delete").click(function(){


    $(this).closest(".delrw").remove(); 
    calculateTotalPercentage();
    calculateTotalMain();
    var rowCount = $("#append tr").length;

$("#tot_subj").val(rowCount);

});


$(".obt_mark").keyup(function(){



var obt = $(this).val();

var main_m = $('input[name=max_mark]:checked', '#formId').val(); 


if(main_m =="" ){
    alert("Select Max Mark");
    return false;
}else{

    var s = ((obt * 100) / main_m);
    
$(this).closest('td').next().find('.percentage').val(s);

} 


calculateTotalMain();
calculateTotalPercentage();





});



var rowCount = $("#append tr").length;

$("#tot_subj").val(rowCount);



});

function calculateTotalMain() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".plusonetot").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
	$("#tot_mark").val(sum);
}
 


function calculateTotalPercentage() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".percentage").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
    var rowCount = $("#append tr").length;

//$("#tot_subj").val(rowCount);
var m = sum / rowCount;


	$("#tot_perc").val(m);
}

$('#formId input').on('change', function() {
   var main_m = $('input[name=max_mark]:checked', '#formId').val(); 

  // alert(main_m);

$(".max_mark").val(main_m);



$('#append .obt_mark').each(function(){



var obt_mrk = $(this).val();

var s = ((obt_mrk * 100) / main_m);


$(this).closest('td').next().find('.percentage').val(s);


    });
    calculateTotalPercentage();
    
});

$(".obt_mark").keyup(function(){



var obt = $(this).val();

var main_m = $('input[name=max_mark]:checked', '#formId').val(); 


if(main_m =="" ){
    alert("Select Max Mark");
    return false;
}else{

    var s = ((obt * 100) / main_m);
    
$(this).closest('td').next().find('.percentage').val(s);

} 


//$(this).next('input').val(s);








});
       
        $("input[type='radio'][name='max_mark']:checked").val();



        $('input[name="max_mark"]:checked').val();





$("#part_lang").change(function() { 

    var m_s = $(this).val();

    if(m_s == "Exempted"){
        $("#lang_mark").prop("disabled",true);
        $("#parttwomark").prop("readonly",true);

    }else{

        $("#lang_mark").prop("disabled",false);
        $("#parttwomark").prop("readonly",false);

    }

   
});





calculateTotalMain();

$(".delete_marc").click(function(){
    calculateTotalPercentage();
    calculateTotalMain();
var m = $(this).val();

//alert(m);

request = $.ajax({
        url: "<?=base_url()?>UgSelfFinance/deleteSubject",
        type: "post",
        data: {id:m}
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        location.reload(true);
        console.log("Hooray, it worked!");
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });



});













    </script>