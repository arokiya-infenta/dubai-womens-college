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
			
	 <div class="row ">
       
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Miscellaneous Transaction 
        
        
        </div>
            <div class="card-body">
            <div class="scroll_cl">
			
            <table id="example_th" class="table ">
        <thead>
            <tr>
                <th>S.no</th>
                <th>Student Name</th>
                <th>Category</th>
                <th>Fees Name</th>
                <th>Date</th>
                <th>Roll Numb / Register Number</th>
                <th>Fee amount</th>
                <th>View</th>
               
            </tr>
        </thead>
        <tbody>
            <?php 
            
            $i=1;
            foreach ($transaction as $key => $value) {
            ?>
           <tr>
      <td scope="row"><?=$i?></td>
      <td><?=strtoupper($value->studentname)?></td>
      <td><?=$value->name?></td>
      <td><?=$value->fees_name?></td>
      <td><?=date("d-M-Y",strtotime($value->paid_date_time))?></td>
      <td><?=$value->roll_no?></td>
      <td><?=$value->samounts?></td>
      <td>
      <button id="myBtn" class="btn btn-primary tnt" value="<?=$value->tran_id?>" data-toggle="modal" data-target="#myModal">update</button></td>
    </tr>

      
        

        <?php     $i++;
            } ?>    
        </tbody>
        
    </table>

            </div>
            </div>
          
          </div>
       
      </div>
	  

    </div>
    <!-- End container-fluid-->
    <!-- Modal -->


    </div><!--End content-wrapper-->



    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               

            </div>
            <div class="modal-body" id="app_model">
            
                   <form class="well form-horizontal" action="<?=base_url()?>Accounts/messiAdd" method="post">
                      <fieldset>
                      <div class="container">
          
                        <div class="row">
                           <label class="col-md-4 control-label">Student Name</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="stu_name" name="stu_name" readonly class="form-control" required="true" type="text">
                         
                           </div>
                         </div> 
<br>                     

                            <div class="row">
                           <label class="col-md-4 control-label">Register Number</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="regnum" name="regnumber"  class="form-control" required="true" type="text">
                          <input  type="hidden"  id="missi_id" name="missi_id"  > 
                          <input  type="hidden"  id="m_response" name="m_response"  > 
                           </div>
                         </div> 
<br>
                         <div class="row">
                           <label class="col-md-4 control-label">Mobile</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="mobile" name="mobile" readonly class="form-control" required="true"  type="text">
                           </div>
                         </div> 
                         <br>
                         <div class="row">
                           <label class="col-md-4 control-label">Email</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="email" name="email" readonly class="form-control" required="true"  type="text">
                           </div>
                         </div> 
                         <br>
                         <div class="row">
                           <label class="col-md-4 control-label">Category</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="mcate" name="m_fcate" readonly class="form-control" required="true"  type="text">
                           </div>
                         </div> 
                         <br>
                         <div class="row">
                           <label class="col-md-4 control-label">Fees Name</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="mname" name="mf_name" readonly class="form-control" required="true"  type="text">
                           </div>
                         </div> 
                         <br>
                         <div class="row">
                           <label class="col-md-4 control-label">Amount</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="amount" name="amount" readonly class="form-control" required="true"  type="number">
                           </div>
                         </div> 
                         <br>   
                         <div class="row">
                           <label class="col-md-4 control-label">Transaction Date</label>
                            <div class="col-md-8 inputGroupContainer">
                            <input id="date" name="date" readonly class="form-control" required="true"  type="text">
                           </div>
                         </div> 
                         <br>               
                      
                       <br>
                       <hr>

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
              $olddate3 = date("Y",strtotime ( '-3 year' , strtotime ( $date ) )) ;
              $olddate2 = date("Y",strtotime ( '-2 year' , strtotime ( $date ) )) ;
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<div class="col-md-3" id="batch" style="display:none;">
			<label>Batch</label>
			<select class="form-control batch" id="battach" require name="batch">
			<option value="<?php echo $olddate3;?>"><?php echo $olddate3;?></option>
			<option value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			
			</div>
               <br>
                    
               
               
               
               <div id="main" style="display:none;">
			<div class="row">
            <div class="col-md-3">
			<label>Select Category</label>
        </div>
        <div class="col-md-9">
		<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			
		
			</select>

            </div>
            </div>
			<br>
              
               
               
               
               <div id="catedory_div" class="row">

</div>

   <br>
   <div class="row">
   <div class="col-md-3">
<label>Payment Type</label>
</div>
<div class="col-md-9">
<select class="form-control batch" id="payment" require name="category">
			<option value="">Select Payment Type</option>
			</select>
   </div>
   </div>
   <br>
<div class="row">
   <div class="col-md-3">
<label>Select Fees Name</label>
</div>
<div id="payment" class="col-md-9">
<select class="form-control batch" id="feename" require name="feename">
			<option value="">Select Fee Name</option>
	</select>
   </div>
   </div>
<br>
   <br>
   </div>   
 <div class="row">
                           <label class="col-md-9 control-label"></label>
                            <div class="col-md-3 inputGroupContainer">
                            <button type="submit" class="btn btn-primary">Save</button>
                           </div>
                         </div> 
                         <br>
                                     
   
    </div>
                      </fieldset>
                      
                   </form>
  


            </div>
            <div class="modal-footer">
               
             
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
    
   $(document).ready(function () {
    var base_url = "<?php echo base_url(); ?>";  
      $(".tnt").click(function(){
       alert( $(this).val())
       
           $.ajax({
                url: base_url + "accounts/transactionid",
                type: 'POST',
                cache: false,
                data: {
                    id: $(this).val(),
                },
                success: function (data) {
                  const obj = JSON.parse([data]);
				//	console.log(data);
				//	console.log(obj);
					console.log(obj[0].tran_id);


var trans_id = obj[0].tran_id;
var cat_name = obj[0].name;
var fee_name = obj[0].fees_name;
var amount = obj[0].samounts;
var roll_num = obj[0].roll_no;
var email = obj[0].email;
var mobile = obj[0].mobile;
var response = obj[0].response;
var missi_id = obj[0].id;
var stu_name = obj[0].studentname.toUpperCase();
//var m_response = obj[0].response;
var date_paid = new Date(obj[0].paid_date_time);

$("#regnum").val(roll_num);
$("#mobile").val(mobile);
$("#email").val(email);
$("#mcate").val(cat_name);
$("#mname").val(fee_name);
$("#amount").val(amount);
$("#date").val(date_paid);
$("#missi_id").val(missi_id);
$("#m_response").val(response);
$("#stu_name").val(stu_name);

          $('#myModal').modal('show');
           $('#myModalLabel').html($(this).val());

				/* 	 $("#catedory_div").css('display','block');
                       $("#catedory_div").html(data);  */
                }
            });


      });
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

    $("#battach").change(function(){



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();


if(main_c_id =="" || app_c_id =="" || aayear=="" || battach==""  ){


alert("Select all in above section");

}else{
	$.ajax({
                url: base_url + "accounts/SelectCategory",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach
                },
                success: function (data) {

				//	alert(data)
					 $("#category").css('display','block');
                       $("#category").html(data); 
                }
            });
		}

});   $("#category").change(function(){



var main_c_id = $("#main_course_id").val();
var app_c_id = $("#app_course_id").val();
var aayear = $("#aayear").val();
var battach = $("#battach").val();
var category = $("#category").val();


if(main_c_id =="" || app_c_id =="" || aayear=="" || battach=="" || category==""  ){


alert("Select all in above section");

}else{
	$.ajax({
                url: base_url + "accounts/SelectPayment",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,category:category
                },
                success: function (data) {

				//	alert(data)
					 $("#payment").css('display','block');
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
var category = $("#category").val();
var payment = $("#payment").val();


if(main_c_id =="" || app_c_id =="" || aayear=="" || battach=="" || category=="" || payment=="" ){


alert("Select all in above section");

}else{
	$.ajax({
                url: base_url + "accounts/SelectPaymentfees",
                type: 'POST',
                cache: false,
                data: {
                    main_c_id: main_c_id,app_c_id:app_c_id,aayear:aayear,battach:battach,category:category,payment:payment
                },
                success: function (data) {

				//	alert(data)
					 $("#feename").css('display','block');
                       $("#feename").html(data); 
                }
            });
		}

});




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