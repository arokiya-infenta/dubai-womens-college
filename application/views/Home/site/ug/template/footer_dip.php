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
<script src="<?=base_url()?>/landing/js/jquery.min.js"></script>

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
/* counter js */

$("#instsslc").focus(function (e) { 
    //e.preventDefault();

   // alert();
    
});

(function ($) {
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


    $(".del_exp").click(function(){


        var n = $(this).val();

       // alert(n);

        $.ajax({
    type: "POST",
    url: "<?=base_url()?>Home/deleteExperiance",
    data: {id:n},
    cache: false,
    success: function(result){
        if(result == 1){


            alert("Successfully Deleted ");
          
           $(location).attr("href", "<?=base_url()?>Home/User");
         
        }else{
        alert("Failed to Deleted");
        $(location).attr("href", "<?=base_url()?>Home/User");
        }
        }
    });


    })


    var array = [];
            $('input[name="course_one[]"]:checked').each(function() {
                array.push($(this).val());
            });
        //   alert(array);



if($.inArray("11",array) !== -1){

    $("#hrm").show();


}else{
    $("#hrm").hide();

}

   

    

/*     if($('input:checked[name=course_one]:checked').val() == "11"){

        $("#hrm").show();


    }else{

       

    } */


$("#add_exp").click(function(){


    var m = '<div id="thisapp" class=" row">'+
'<div class="col-md-3"><input type="text" name="company[]"    class="form-control"></div>'+
'<div class="col-md-3"><input type="text" name="role[]"    class="form-control"></div>'+
'<div class="col-md-2"><input type="date"   name="from[]"    class="from_Date form-control"></div>'+
'<div class="col-md-2"><input type="date"   name="to[]"    class="to_Date form-control"></div>'+
'<div class="col-md-1"><input type="text" readonly name="tot[]"    class="total form-control"></div>'+
'<div class="col-md-1"><button type="button"  class="btn-danger delete form-control">-</button></div>'+
'</div>';


$("#append").append(m);

$(".delete").click(function(e){
    $(this).closest("div.row").remove();
    e.preventDefault();

});
$('.to_Date').change(function(e) {
    var date1 = new Date($(this).closest("div.row").find("input[type=date]").val());
    var date2 = new Date($(this).val());



    if(date1 > date2){
        
        alert("you pick wrong ");
    
    }else{



    }


    function diff_months(dt2, dt1) 
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
   diff /= (60 * 60 * 24 * 7 * 4);
  return Math.abs(Math.round(diff));
  
 }

 $(this).closest("div.row").find(".total").val(diff_months(date2, date1));


  e.preventDefault();
   
});



});



$('.to_Date').change(function(e) {
    var date1 = new Date($(this).closest("div.row").find("input[type=date]").val());
    var date2 = new Date($(this).val());



    if(date1 > date2){
        
        alert("you pick wrong ");
    
    }else{



    }

 
    function diff_months(dt2, dt1) 
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
   diff /= (60 * 60 * 24 * 7 * 4);
  return Math.abs(Math.round(diff));
  
 }

 $(this).closest("div.row").find(".total").val(diff_months(date2, date1));


  e.preventDefault();
   
});





$("#word_count").on('keyup', function() {
    var words = 0;

    if ((this.value.match(/\S+/g)) != null) {
      words = this.value.match(/\S+/g).length;
    }

    if (words > 2000) {
      // Split the string on first 200 words and rejoin on spaces
      var trimmed = $(this).val().split(/\s+/, 2000).join(" ");
      // Add a space at the end to make sure more typing creates new words
      $(this).val(trimmed + " ");
    }
    else {
      $('#display_count').text(words);
      $('#word_left').text(2000-words);
    }
  });








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
    day = 500;
    break;
  case 2:
     day = 1000;
    }
$("#appli_price").empty();
$("#appli_price").text(day);

var favorite = [];

$.each($('input[name="course_one[]"]:checked'), function(){
                favorite.push($(this).val());
if($(this).val() == 11){

    $("#hrm").show();  

}else{


    $("#hrm").hide();

}



            });
          //  alert("My favourite sports are: " + favorite.join(", "));
   
       

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






$("#PreviewDip").click(function(e){
    //e.preventDefault();


 $('#formId').attr('action', '<?=base_url();?>Home/previewWindowDip');
    $('#formId').attr('target', '_blank');




});



$("#SaveDip").click(function(){

$('#formId').attr('action', '<?=base_url();?>Home/SaveApplicationDip');
$('#formId').removeAttr('target');


});

$("#appliDip").click(function(e){
  
    var numberOfothermain = $('input[name="course_one[]"]:checked').length;
   

    

var applied = parseInt(numberOfothermain);


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


  $("#formId").attr('action', '<?=base_url()?>Home/SaveApplicationDip/payment');
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

$('#dob').change(function(){
      var valu = $(this).val(); 




      var d=new Date(valu.split("/").reverse().join("-"));
//alert(d);
var dd=d.getDate();
var mm=d.getMonth()+1;
var yy=d.getFullYear();
var nn = yy+", "+mm+" ,"+dd;


     var age = calculate_age(new Date(nn));

    $("#age").val(age);
if(age < 21 ){

    alert("Your Age must be more than 21");

    $("#dob").focus();

} 
//alert(age);

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

















</script>
</body>

</html>