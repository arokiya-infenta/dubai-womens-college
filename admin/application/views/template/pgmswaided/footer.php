	
	<!--Start footer-->

	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  
  <script src="<?=base_url()?>white-version/assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/bootstrap.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<!-- simplebar js -->
	<script src="<?=base_url()?>white-version/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?=base_url()?>white-version/assets/js/waves.js"></script>
	<!-- sidebar-menu js -->
	<script src="<?=base_url()?>white-version/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

  <!--Data Tables js-->
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

    <script>
 $(document).ready(function() {

/* 	$('ul.tabs li').click(function(){
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');
			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
		}); */


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




function ajax(status , id){



  $.ajax({
type: "POST",
url: "<?=base_url()?>Admin/userFeesStatus",
data: {status : status, id:id },
cache: false,
success: function(result){
  location.reload(true); 
                alert('Status Changed'); 

}
});




}

/*  $('#gender').click(function(){

  if($(this).is(":checked"))  
                {  
                     var status = 'Paid'; 
                }else{

                  var status = 'Un Paid'; 

                }  
  var id =$("#user_id").val(); 
 

 }); */

$(".remove").click(function(){


var id = $(this).val();


if (confirm('Are you sure you want to move to not intrested ?')) { 



  $.ajax({
type: "POST",
url: "<?=base_url()?>Admin/removeUser",
data: {id : id},
cache: false,
success: function(result){
  window.location.reload();
}
});







} else {

return false;

}

//alert(id);


});


$('#example2').DataTable( {


dom: 'Bfrtip',
buttons: [
        {
            extend: 'pdfHtml5',
            filename: 'MSSW Reports',
            title: ' ',
          //  messageBottom: 'No.130A, Arcot Road, Virugambakkam,Chennai 600 092. Tamilnadu',
            customize: function ( doc ) {
                doc.content.splice( 0, 0, {
                    margin: [ 0, 0, 0, 15 ],
                    alignment: 'center',
                    image: 'data:image/png;base64,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'
                } );
            }
           
        },
        {
          extend: 'excel',
            filename: 'MSSW Reports',
            title: 'MSSW Reports of the Student',
         
        }
    ],

    initComplete: function () {
        this.api().columns(':gt(4)').every( function () {
            var column = this;
            var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    }
} );








    $("#inter-status").on('change', function(e){
   var val = $(this).val();

  if(val == "Approved"){

  
    $("#course-assign").prop('required',true);


  }else{


    $("#course-assign").prop('required',false);


  }


});


$("#inter-status").on('change', function(e){
   var val = $(this).val();

  if(val == "Interview not attended"){

    $('.menu').show();
     $("#intdate").prop('required',true);
    $("#intdate").prop('required',true);



  }else{


    $('.menu').hide();
    $("#intdate").prop('required',false);
    $("#intdate").prop('required',false);
    //$("#rollnumber").val('');


  }


});




$("#adm-status").on('change', function(e){
   var val = $(this).val();

  if(val == "Admitted"){

    $('.roll').show();
     $("#rollnumber").prop('required',true);
    $("#rollnumber").prop('required',true);



  }else{


    $('.roll').hide();
    $("#rollnumber").prop('required',false);
    $("#rollnumber").prop('required',false);
    $("#rollnumber").val('');


  }


});




////////////////////////////////////// back///////////////////////////////////////////////
  $('button#cancel').on('click', function(e){
    e.preventDefault();
    window.history.back();
});

////////////////////////////////////////Date of birth age calculation  ///////////////////////////////


  $('#dob').change(function(){
      var valu = $(this).val(); 
      var d=new Date(valu.split("/").reverse().join("-"));

    var dd=d.getDate();
    var mm=d.getMonth()+1;
    var yy=d.getFullYear();
    var nn = yy+", "+mm+" ,"+dd;


     var age = calculate_age(new Date(nn));

    $("#age").val(age);

    });

    function calculate_age(dob) { 
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 
  
    return Math.abs(age_dt.getUTCFullYear() - 1970);
  }
////////////////////////////////////////Image Select ///////////////////////////////

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
////////////////////////////////////////course Selected ///////////////////////////////
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
//////////////////////////////////////////////////////////////////////////////////////////


//select coursec priority

$("#course_1").change(function(){
        var course_1 = $(this).val();
        if(course_1 == 0){
             $("#course_2").attr('disabled','disabled');
             $("#course_2").val(course_1);
             $("#course_3").attr('disabled','disabled');
             $("#course_3").val(course_1);


        }else{
             $("#course_2").removeAttr('disabled');
             $("#course_2").removeAttr('disabled');
}

}); 


$("#course_2").change(function(){

var course_1 = $(this).val();
    if(course_1 == 0){
    $("#course_3").attr('disabled','disabled');
    $("#course_3").val(course_1);
    }else{
    $("#course_3").removeAttr('disabled');
}
});


var logo_pdf='data:image/png;base64,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';

//////////////////////////////////////////////////////////////////////////////////////////

$('#example_reg').DataTable( {
    lengthChange: false,
		paginate: false,
    "order": [[ 4, "asc" ]],
    dom: 'Bfrtip',
        buttons: [   {
           extend: 'pdf',
           footer: true,
           exportOptions: {
                columns: [1,2,3,4]
            },
                pageSize: 'A4',
            filename: '',
            title: '',
          //  messageBottom: 'No.130A, Arcot Road, Virugambakkam,Chennai 600 092. Tamilnadu',
            customize: function ( doc ) {
                doc.content.splice( 0, 0, {
                    margin: [ 0, 0, 0, 15 ],
                   // alignment: 'center',
                    image: logo_pdf
                } );
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: [1,2,3,4]
            }
          
       }
        ]
      } );




       $('#default-datatable').DataTable();

       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 9, "desc" ]],
        
      } );


      var shotlisted = $('#shortlisted').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 8, "desc" ]],
        "paging":   false,
        
      } ); 
      

      var zoom = $('#examplezoomview').DataTable( {
        lengthChange: false,
		paginate: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 5, "desc" ]],
        
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );

    </script>
  
</body>
</html>
