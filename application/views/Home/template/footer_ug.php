<!--<footer class="footer-box">
    <div class="container">
    
       <div class="row">
       
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog">
                <div class="full margin-bottom_30">
                   <img src="<?=base_url()?>/landing/images/footer_logo.png" alt="#" />
                 </div>
                 <div class="full white_fonts">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip </p>
                 </div>
             </div>
          </div>
          
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
               <div class="footer_blog footer_menu white_fonts">
                        <h3>Quick links</h3>
                        <ul> 
                          <li><a href="#">> Join Us</a></li>
                          <li><a href="#">> Maintenance</a></li>
                          <li><a href="#">> Language Packs</a></li>
                          <li><a href="#">> LearnPress</a></li>
                          <li><a href="#">> Release Status</a></li>
                        </ul>
                     </div>
             </div>
             
             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog full white_fonts">
                         <h3>Newsletter</h3>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                         <div class="newsletter_form">
                            <form action="index.html">
                               <input type="email" placeholder="Your Email" name="#" required />
                               <button>Submit</button>
                            </form>
                         </div>
                     </div>
                </div>	 
          
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
             <div class="footer_blog full white_fonts">
                         <h3>Contact us</h3>
                         <ul class="full">
                           <li><img src="<?=base_url()?>/landing/images/i5.png"><span>London 145<br>United Kingdom</span></li>
                           <li><img src="<?=base_url()?>/landing/images/i6.png"><span>demo@gmail.com</span></li>
                           <li><img src="<?=base_url()?>/landing/images/i7.png"><span>+12586954775</span></li>
                         </ul>
                     </div>
                </div>	 
          
       </div>
    
    </div>
</footer>
 End Footer -->

 <div class="footer_bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="crp">© Copyrights <?=date('Y')?> powered by <a href="https://www.istudiotech.in/" class="ist">iStudio Technologies</a></p>
            </div>
        </div>
    </div>
</div>

<a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>
<style>
.errorClass { border:  1px solid red; }
</style>
<!-- ALL JS FILES -->
<!--<script src="<?=base_url()?>/landing/js/jquery.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.8.3/jquery-ui.js"></script>
<!--<script type="text/javascript" src="<?=base_url()?>landing/js/fullscreen/release/jquery.fullscreen-0.3.2.min.js"></script>-->

<script src="<?=base_url()?>/landing/js/popper.min.js"></script>
<script src="<?=base_url()?>/landing/js/bootstrap.min.js"></script>
<!-- ALL PLUGINS -->
<script src="<?=base_url()?>/landing/js/jquery.magnific-popup.min.js"></script>
<script src="<?=base_url()?>/landing/js/jquery.pogo-slider.min.js"></script>
<script src="<?=base_url()?>/landing/js/slider-index.js"></script>
<!--<script src="<?=base_url()?>/landing/js/smoothscroll.js"></script>-->
<script src="<?=base_url()?>/landing/js/form-validator.min.js"></script>
<script src="<?=base_url()?>/landing/js/contact-form-script.js"></script>
<script src="<?=base_url()?>/landing/js/isotope.min.js"></script>
<script src="<?=base_url()?>/landing/js/images-loded.min.js"></script>
<script src="<?=base_url()?>/landing/js/custom.js"></script>



<script>


$(".pr_scolorship").click(function(){
var m =$('input[name="pr_scolorship"]:checked').val();



if(m == "Yes"){


    $('#pr_incom_cer').prop("required", true);
 
    $('#pr_incom_cer').attr("disabled",false);
              

}else{
    $('#pr_incom_cer').prop("required", false);

    $('#pr_incom_cer').attr("disabled",true);
}


});


$("#candidate_name").keyup(function(){

this.value = this.value.toUpperCase();

});

$(".tamilnadu").click(function(){
var m =$('input[name="tamilnadustate"]:checked').val();



if(m == 2){
$('input[name="Community"].comm-oc').prop("checked", true);

$('input[name="Community"].comm-others').attr("disabled",true);
          

}else{
$('input[name="Community"].comm-others').attr("disabled",false);


}


});


    $(document).ready(function () { 
        
     


var numberOfChecked = $('input[name="course_one[]"]:checked').length;

var day = 0; 
// alert(numberOfChecked);


switch (numberOfChecked) {
case 0:
day = 0;
break;
case 1:
day = 400;
break;
case 2:
 day = 800;
}
$("#appli_price").empty();
$("#appli_price").text(day);



        calculateTotalMain();

$(".delete_marc").click(function(){
    calculateTotalPercentage();
    calculateTotalMain();
var m = $(this).val();

//alert(m);

request = $.ajax({
        url: "<?=base_url()?>Home/deleteSubject",
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

    
    });
$("#instsslc").focus(function (e) { 
    //e.preventDefault();

   // alert();
    
});
var currentTab = 0;
(function ($) {

  
     $("#tabs").tabs({
            select: function (e, i) {
                currentTab = i.index;
            }
        }); 

    $("#btnNext").live("click", function () {
        var tabs = $('#tabs').tabs();
        var c = $('#tabs').tabs("length");
        currentTab = currentTab == (c - 1) ? currentTab : (currentTab + 1);
        tabs.tabs('select', currentTab);
        $("#btnPrevious").show();
        if (currentTab == (c - 1)) {
            $("#btnNext").hide();
        } else {
            $("#btnNext").show();
        }
    });
    $("#btnPrevious").live("click", function () {
        var tabs = $('#tabs').tabs();
        var c = $('#tabs').tabs("length");
        currentTab = currentTab == 0 ? currentTab : (currentTab - 1);
        tabs.tabs('select', currentTab);
        if (currentTab == 0) {
            $("#btnNext").show();
            $("#btnPrevious").hide();
        }
        if (currentTab < (c - 1)) {
            $("#btnNext").show();
        } 

    });




//alert();

////////////////////////////////////-------------------PG Jquery--------------------------/////////////////////////////////

/* $("#my_app_fee_others").val();
$("#my_app_fee_aided").val();
$("#my_app_fee_fin").val(); */

//alert();
var numberOfChecked = $('input[name="course_one[]"]:checked').length;

var day = 0; 




 







$("#my_app_fee_others").val(day);

var sum=parseInt($("#my_app_fee_others").val());
$("#appli_price").empty();
$("#appli_price").text(parseInt(sum));

$('[data-toggle="tooltip"]').tooltip();   
$("#msw_aided").hide();
$("#msw_self_finance").hide();











////////////////////////////////////-------------------PG Jquery--------------------------/////////////////////////////////





    if($('input:radio[name=Nationality]:checked').val() == "Indian"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        
       
        $("#country").val('');
        $("#passportnumber").val('');
        $("#pp_exp").val(''); 
        
        
         $("#country").prop('readonly',true);
        $("#passportnumber").prop('readonly',true);
        $("#pp_exp").prop('readonly',true);

    }else{

        $("#country").prop('readonly',false);
        $("#passportnumber").prop('readonly',false);
        $("#pp_exp").prop('readonly',false);


        $("#country").prop('required',true);
        $("#passportnumber").prop('required',true);
        $("#pp_exp").prop('required',true);
       
    }
   
   
    if($('input:radio[name=other_res]:checked').val() == "Yes"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

       // $("#reser_specify").prop("disabled",true);
        $("#reser_specify").prop('required',true);
    
        

    }else{

     
        
        
      //   $("#reser_specify").prop("disabled",true);
         $("#reser_specify").prop('required',false);
       
       
    }

    if($('input:radio[name=study_bord]:checked').val() == "Others"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#other_board").prop('readonly',false);
        $("#other_board").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#other_board").val('');
        $("#other_board").prop('readonly',true);
        $("#other_board").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }


    if($('input:radio[name=lang_studied]:checked').val() == "OTHERS"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#spes_other_lang").prop('readonly',false);
        $("#spes_other_lang").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#spes_other_lang").val('');
        $("#spes_other_lang").prop('readonly',true);
        $("#spes_other_lang").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }


    if($('input:radio[name=abled]:checked').val() == "YES"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#abledreason").prop('readonly',false);
        $("#abled-cert").prop('disabled',false);
       


    }else{

        $("#abledreason").val('');
        $("#abledreason").prop('readonly',true);
        $("#abled-cert").prop('disabled',true);
    }



    if($('input:radio[name=break_in_study]:checked').val() == "yes"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#break_reason").prop('readonly',false);
        $("#break_reason").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#break_reason").val('');
        $("#break_reason").prop('readonly',true);
        $("#break_reason").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }



$("#address_same").click(function(){

var value = $(this).val();


            if($(this).prop("checked") == true){




                console.log("Checkbox is checked.");

                    var address =  $("#localddress").val();
                    var city =  $("#local_city").val();
                    var state =  $("#local_state").val();
                    var contury =  $("#local_country").val();
                    var pincode =  $("#local_pincode").val();


                    console.log(address);
                    console.log(city);
                    console.log(state);
                    console.log(pincode);

                    

                    $("#pr_address").val(address);
                    $("#pr_city").val(city);
                    $("#pr_state").val(state);
                    $("#pr_country").val(contury);
                    $("#pr_pincode").val(pincode);


            }
            else if($(this).prop("checked") == false){


            $("#pr_address").val("");
            $("#pr_city").val("");
            $("#pr_state").val("");
            $("#pr_country").val("");
            $("#pr_pincode").val("");



                console.log("Checkbox is unchecked.");
            }


});





$('.checkbox_class_here').click(function(){


    var numberOfChecked = $('input[name="course_one[]"]:checked').length;

    var day = 0; 
   // alert(numberOfChecked);


    switch (numberOfChecked) {
  case 0:
    day = 0;
    break;
  case 1:
    day = 400;
    break;
  case 2:
     day = 800;
    }
$("#appli_price").empty();
$("#appli_price").text(day);

});





    $("#board input[name='study_bord']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=study_bord]:checked').val() == "Others"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#other_board").prop('readonly',false);
        $("#other_board").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#other_board").val('');
        $("#other_board").prop('readonly',true);
        $("#other_board").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }
});  



 $("#langu_age input[name='lang_studied']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=lang_studied]:checked').val() == "OTHERS"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#spes_other_lang").prop('readonly',false);
        $("#spes_other_lang").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#spes_other_lang").val('');
        $("#spes_other_lang").prop('readonly',true);
        $("#spes_other_lang").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }
}); 




 $("#other_res input[name='other_res']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=other_res]:checked').val() == "Yes"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#reser_specify").prop('readonly',false);
        $("#reser_specify").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#reser_specify").val('');
        $("#reser_specify").prop('readonly',true);
        $("#reser_specify").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }
});  





  $("#break_in_study input[name='break_in_study']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=break_in_study]:checked').val() == "yes"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#break_reason").prop('readonly',false);
        $("#break_reason").prop('required',true);
     //   $("#abled-cert").prop('disabled',false);
       


    }else{
        $("#break_reason").val('');
        $("#break_reason").prop('readonly',true);
        $("#break_reason").prop('required',false);
      //  $("#abled-cert").prop('disabled',true);
    }
});  




 $("#inline_content input[name='abled']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=abled]:checked').val() == "YES"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        $("#abledreason").prop('readonly',false);
        $("#abled-cert").prop('disabled',false);
       


    }else{

        $("#abledreason").val('');
        $("#abledreason").prop('readonly',true);
        $("#abled-cert").prop('disabled',true);
    }
}); 


   $("#nationality input[name='Nationality']").click(function(){
   // alert('You clicked radio!');
    if($('input:radio[name=Nationality]:checked').val() == "Indian"){
        //alert($('input:radio[name=abled]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);

        
       
        $("#country").val('');
        $("#passportnumber").val('');
        $("#pp_exp").val(''); 
        
        
         $("#country").prop('readonly',true);
        $("#passportnumber").prop('readonly',true);
        $("#pp_exp").prop('readonly',true);

    }else{

        $("#country").prop('readonly',false);
        $("#passportnumber").prop('readonly',false);
        $("#pp_exp").prop('readonly',false);
       
    }
})

/* $('.resultscore input[type="radio"]').click(function(){
    	var demovalue = $(this).val();
        alert("Your result is "+demovalue);
    });
 */





/*     var url = $(location).attr('href');
    
    var segments = url.split( '/' );
var action = segments[3];
var id = segments[5]; */

//alert(id);


/* if( id =="pay" ){

    $('#pGId').submit();



} */
//apply //-----------------







calculateMainSum();
    $(".plusonemin").on("keydown keyup", function() {
        calculateMainSum();
});


calculateTotalMain();
$(".obt_mark").on("keydown keyup", function() {
    calculateTotalMain();
    calculateTotalPercentage();
});

    calculateSum();

$(".plusonetot").on("keydown keyup", function() {
    calculateSum();
});


calculateMainAllPhus2()

$(".plus2total").on("keydown keyup", function() {
    calculateMainAllPhus2();
});



calculateMainSumPhus2()
$(".plus2sub").on("keydown keyup", function() {
    calculateMainSumPhus2();
});





/*   $("#appli").click(function(e){
           // e.preventDefault();
    var retVal = confirm("Do you want to Submit ?.If you submit you cannot edit application  ?");
               if( retVal == true ) {

                return true;

                $("#cleared").remove();

 $('#formId').attr('action', 'https://pgi.billdesk.com/pgidsk/PGIMerchantPayment');

    $('#formId').submit();
              //  $("#acknoledgement").prop('required',true); 
                
               } else {
                 
                  return false;
               }

});
  */


//preview //------------------
var c2 = $("#course_2").val();

if(c2 == 0){
             $("#course_2").attr('disabled','disabled');
             $("#course_2").val(course_1);
        }else{
             $("#course_2").removeAttr('disabled');
}


var c3 = $("#course_3").val();

if(c3 == 0){
             $("#course_3").attr('disabled','disabled');
             $("#course_3").val(course_1);
        }else{
             $("#course_3").removeAttr('disabled');
}








/* 

$("#Preview").click(function(e){
    //e.preventDefault();




    var r = confirm("Do You Want to Preview your Application");
if (r == true) {
 // txt = "You pressed OK!";
 $('#formId').attr('action', '<?=base_url();?>Home/previewWindow');
    $('#formId').attr('target', '_blank');

} else {
 // txt = "You pressed Cancel!";
 return false;
} 




   
    //alert("To View the form preview Save the form first");


});





$("#Save").click(function(){

$('#formId').attr('action', '<?=base_url();?>Home/SaveApplication');
$('#formId').removeAttr('target');


});
 */


$("#PreviewUg").click(function(e){
    //e.preventDefault();


 $('#formId').attr('action', '<?=base_url();?>Home/previewWindowUg');
    $('#formId').attr('target', '_blank');




});



$("#SaveUg").click(function(){

$('#formId').attr('action', '<?=base_url();?>Home/SaveApplication');
$('#formId').removeAttr('target');


});

$("#appliUg").click(function(e){
  
    var numberOfothermain = $('input[name="course_one[]"]:checked').length;
   



var applied = parseInt(numberOfothermain) ;


if(applied > 0){

  var isValid = 0;
$('#formId input:required').each(function() {
  if ( $(this).val() === '' ){
 // alert();
      isValid = 1;
    
      $(this).addClass('errorClass');


  }
 
});


//alert(isValid);
if(isValid == 0)
{


  $("#formId").attr('action', '<?=base_url()?>Home/SaveApplication/payment');
  $('#formId').removeAttr('target');
} 

}else{

alert("Select The Course");

return false;
}

}); 
/*     $("#inline_content input[name='abled']").click(function(){

    
    if($('input:radio[name=abled]:checked').val() == "yes"){

        $('#abledreason').removeAttr('readonly');
      
    }else{

        $("#abledreason").attr('readonly','readonly');
    }
}); */


$("#break input[name='break']").click(function(){


if($('input:radio[name=abled]:checked').val() == "yes"){

    $('#breakread').removeAttr('readonly');
  
}else{

    $("#abledreason").attr('readonly','readonly');
}
});

//calculate_age(new Date(1962, 1, 1));
var mys=0;
$('#dob').change(function(){





      var valu = $(this).val(); 


    

      var d=new Date(valu.split("/").reverse().join("-"));

var dd=d.getDate();
var mm=d.getMonth()+1;
var yy=d.getFullYear();
var nn = yy+", "+mm+" ,"+dd;


     var age = calculate_age(new Date(nn));

    $("#age").val(age);


if(age < 21 ){

  

} else{

   
alert("The upper age limit for admission to UG programmes will be 21 (Twenty-One) years as on 1st July 2023. "+

"However, a relaxation of 5 years is permitted for Differently abled as per G.O.Ms.No.239, S.W. dated 3-9-1993. SC/ST/"+
"BC/MBC/DNC candidates and women candidates may be "+
"allowed the age relaxation of 3 years beyond 21 years.");



}


    });





//DATE OF BIRTH CALCULATION


function calculate_age(dob) { 
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 
  
    return Math.abs(age_dt.getUTCFullYear() - 1970);
}





//image Selection profile
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function(){
        readURL(this);
    });

//select coursec priority

 $("#course_1").click(function(){
        var course_1 = $(this).val();
        if(course_1 == 0){
             $("#course_2").attr('disabled','disabled');
             $("#course_2").val(course_1);
             $("#course_3").attr('disabled','disabled');
             $("#course_3").val(course_1);

        }else{
             $("#course_2").attr('required',true);
             $("#course_2").removeAttr('disabled');
}

}); 


$("#course_2").click(function(){

var course_1 = $(this).val();
    if(course_1 == 0){
    $("#course_3").attr('disabled','disabled');
    $("#course_3").val(course_1);
    }else{
    $("#course_3").removeAttr('disabled');
}
});

//login ajax



$("#Login").click(function(){
var name = $("#firstname").val();
var pass = $("#pass").val();

var dataString = 'name1='+ name + '&pass='+ pass  ;
if(name==''||pass=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
    $.ajax({
    type: "POST",
    url: "<?=base_url()?>Home/loginUser",
    data: dataString,
    cache: false,
    success: function(result){
        if(result == 1){
            <?php   ?>
            $(location).attr("href", "<?=base_url()?>Home/dashBoard");
         
        }else{
        alert("Username or password in correct click forgot password to update password");
        $( "#firstname").focus();
        }
        }
    });
}
return false;
});


//rEGISTER USER

$("#pass").keyup(function(){


    var pswd = $(this).val();
    if ( pswd.length < 8  ) {
  
   $( "#passwordcou" ).html("<p style='color:red'; >Password must be more than 8 character</p>");
   $( "#pass" ).focus();
} else {

    $( "#passwordcou" ).html("");


}


});

$("#retypepass").keyup(function(){
    var pswd = $(this).val();

  var  pass = $("#pass").val();


  
    if ( pswd != pass ) {
    $( "#passwordrety" ).html("<p style='color:red'; >Password not match</p>");
   $( "#retypepass" ).focus();
} else {
    $( "#passwordrety" ).html("");
}

});

$("#submit").click(function(e){

   e.preventDefault();
                   
              
var name = $("#firstname").val();
var lastname = $("#lastname").val();
var pass = $("#pass").val();
var repass = $("#retypepass").val();
var email = $("#email").val();
var mobile = $("#mobile").val();
var course = $("#course").val();

var dataString = 'name1='+ name + '&lastname='+ lastname + '&pass='+ pass + '&repass='+ repass +'&email='+ email +'&mobile=' + mobile +'&course=' + course ;
if(name==''||pass==''||repass==''||email==''||mobile=='' ||course=='')
{

alert("Please Fill All Fields");


//return false;



}else if(pass.length < 8 ){

    alert("Your Password must be Atleast 8 Character");
    $( "#pass" ).focus();

}else if(pass!=repass){

    alert("Retype password are not same");
    $( "#retypepass" ).focus();

}else if(isNaN(mobile)){

    alert('Phone number must be numeric.');
            $('#mobile').val('');
            $('#mobile').focus();
}
else if(mobile.length != 10){


            alert('Phone number must be 10 digits.');
            //$('#mobile').val('');
            $('#mobile').focus();

}else{
// AJAX Code To Submit Form.
        $.ajax({
        type: "POST",
        url: "<?=base_url()?>Home/userRegister",
        data: dataString,
        cache: false,
        success: function(result){


//alert(result);

           if(result == 'email exists'){
            alert('Email or Mobilenumber Already exists');
            }else{
                alert('Register Success');
                $(location).attr("href", "<?=base_url()?>Home/login");
            } 
        }
        });
}
//return false;
});









$.fn.countTo = function (options) {
    options = options || {};
    
    return $(this).each(function () {
        // set options for current element
        var settings = $.extend({}, $.fn.countTo.defaults, {
            from:            $(this).data('from'),
            to:              $(this).data('to'),
            speed:           $(this).data('speed'),
            refreshInterval: $(this).data('refresh-interval'),
            decimals:        $(this).data('decimals')
        }, options);
        
        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(settings.speed / settings.refreshInterval),
            increment = (settings.to - settings.from) / loops;
        
        // references & variables that will change with each update
        var self = this,
            $self = $(this),
            loopCount = 0,
            value = settings.from,
            data = $self.data('countTo') || {};
        
        $self.data('countTo', data);
        
        // if an existing interval can be found, clear it first
        if (data.interval) {
            clearInterval(data.interval);
        }
        data.interval = setInterval(updateTimer, settings.refreshInterval);
        
        // initialize the element with the starting value
        render(value);
        
        function updateTimer() {
            value += increment;
            loopCount++;
            
            render(value);
            
            if (typeof(settings.onUpdate) == 'function') {
                settings.onUpdate.call(self, value);
            }
            
            if (loopCount >= loops) {
                // remove the interval
                $self.removeData('countTo');
                clearInterval(data.interval);
                value = settings.to;
                
                if (typeof(settings.onComplete) == 'function') {
                    settings.onComplete.call(self, value);
                }
            }
        }
        
        function render(value) {
            var formattedValue = settings.formatter.call(self, value, settings);
            $self.html(formattedValue);
        }
    });
};

$.fn.countTo.defaults = {
    from: 0,               // the number the element should start at
    to: 0,                 // the number the element should end at
    speed: 1000,           // how long it should take to count between the target numbers
    refreshInterval: 100,  // how often the element should be updated
    decimals: 0,           // the number of decimal places to show
    formatter: formatter,  // handler for formatting the value before rendering
    onUpdate: null,        // callback method for every time the element is updated
    onComplete: null       // callback method for when the element finishes updating
};

function formatter(value, settings) {
    return value.toFixed(settings.decimals);
}
}(jQuery));

jQuery(function ($) {
// custom formatting example
$('.count-number').data('countToOptions', {
formatter: function (value, options) {
  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
}
});

// start all the timers
$('.timer').each(count);  

function count(options) {
var $this = $(this);
options = $.extend({}, options || {}, $this.data('countToOptions') || {});
$this.countTo(options);
}
});



function calculateSum() {
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
 
	$("#gran_total").val(sum);
}




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




function calculateMainSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".plusonemin").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
	$("#main_total").val(sum);

var per = (sum * 100 / 400);

	$("#main_percentage_plus_1").val(per.toFixed(2));
}


function calculateMainAllPhus2() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".plus2total").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
	$("#plus2alltotal").val(sum);
}




function calculateMainSumPhus2() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".plus2sub").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            $(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
	$("#plus2maintot").val(sum);
    var per = (sum * 100 / 400);

	$("#main_percentage_plus_2").val(per.toFixed(2));
}




</script>
<script >
/* 	  function hasUserMedia() { 
   //check if the browser supports the WebRTC 
   return !!(navigator.getUserMedia || navigator.webkitGetUserMedia || 
      navigator.mozGetUserMedia); 
} 

if (hasUserMedia()) { 
   navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia
      || navigator.mozGetUserMedia; 
		
   //enabling video and audio channels 
   navigator.getUserMedia({ video: true, audio: true }, function (stream) { 
      var video = document.querySelector('video'); 
		
      //inserting our stream to the video tag     
      video.src = window.URL.createObjectURL(stream); 
   }, function (err) {}); 
} else { 
   //alert("WebRTC is not supported"); 

console.log("WebRTC is not supported");

} */
	  </script> 
</body>

</html>