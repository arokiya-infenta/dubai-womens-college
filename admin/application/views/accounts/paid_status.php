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
            <div class="card-header"><i class="fa fa-file-text"></i> Fees Paid</div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/selectPaidUser'?>" method="post">	
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
       
            </div>
            </div>
			<br>
            <br>


            <div id="catedory_div" class="row">

			</div>
			<br>
            <br>
                       
			<div class="row">
            <div class="col-md-9">
			</div>
			<div class="col-md-3">
			<button type="submit" id="submit_form" disabled class="btn btn-primary">Submit</button>
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



	<!--<div class="content-wrapper">
    <div class="container-fluid">


    



  
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Fees Paid</div>
            <div class="card-body">
			
		
            </div>
          
          </div>
        </div>
      </div>
	  

    </div>
   
    </div>-->




   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
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


$("#category").change(function(){



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
var cat = $(this).val();

if(main_c_id =="" || app_c_id =="" || aayear=="" || battach==""  ){


alert("Select all in above section");

}else{


if(cat == ""){

alert("Please Select the Category");

}else{



 	$.ajax({
                url: base_url + "accounts/selectPaidUsers",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,cat:cat
                },
                success: function (data) {

if(data ==0){

	$("#catedory_div").html("No DATA Found.."); 
}else{
	$("#submit_form").prop("disabled",false);

}

					
				//	alert(data)
					// $("#catedory_div").css('display','block');
                     
                }
            }); 
		}
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
   });


 </script>
