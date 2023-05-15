<?php require APPPATH . 'libraries/numbertowords.php'; 
$numbertowords = new Numbertowords();
?>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 


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
            <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">

            <div class="row">
					 <div class="col-md-4 ">

           Principal Approved <?=$approved?>
           </div>
					 <div class="col-md-4 ">
           Principal Not Approved <?=$not_approved?>
					 </div>
					 <div class="col-md-4 ">
           
           </div>
					</div>	<br>
					<!--UG-->
        <?php if(isset($student_ug)){?>		
			<div class="table-responsive">
			  <div class="row mb-2 ml-1">
			  <div class="col-lg-12">
			  <div class="form-group" style="float:right;">
			<div><input type="checkbox" id="selectAll" style="width:20px;height:20px;margin-right:5px;"><b>Select All</b>&nbsp;&nbsp;<button id="sel_approve" class="btn btn-sm btn-success">Select Approved</button></div>
			</div>
			</div>
			</div>
              <table id="example_shortlisted"  style="width: 100%;" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
										   <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Mobile Number</th>

                                            <th>Email</th>
                                            <th>Percentage</th>
                                           <th>Reference Number</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student_ug as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><input type="checkbox" class="sel_approve" style="width:20px;height:20px;margin-right:5px;" value="<?=$value->sl_id?>"><?=$i?>
						<input type="hidden" value="Selection List" id="type" data-main="<?=$value->main_course_id?>" data-app="<?=$value->applied_course_id?>">
						</td>
                        <td><?=$value->application_number?></td>
						<td><?=$numbertowords->convert_number($value->selection_list)?></td>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=$value->candidate_mobile?></td>
                
                        <td><?=$value->candidate_email?></td>
                        <td><?=$value->percentage_obtained?></td>
                        <td>21<?=$value->pr_user_id?></td>
                     
                     
                      
                      <?php if($value->principal_published == 0 ){ ?>
                      <td><button type="submit" value="<?=$value->sl_id?>" class="approvr btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></td>
                    
                 
                       <?php }else{  ?>

                        <td><button type="submit" value="<?=$value->sl_id?>" class="notapproved btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                      <?php  } ?>
                     
                    
                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
										   <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Mobile Number</th>

                                            <th>Email</th>
											<th>Percentage</th>
                                           <th>Reference Number</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
		<?php } ?>
  <!--PG-->	
          <?php if(isset($student_pg)){?>	
              <div class="table-responsive">
			  <div class="row mb-2 ml-1">
			  <div class="col-lg-12">
			  <div class="form-group" style="float:right;">
			<div><input type="checkbox" id="selectAll" style="width:20px;height:20px;margin-right:5px;"><b>Select All</b>&nbsp;&nbsp;<button id="sel_approve" class="btn btn-sm btn-success">Select Approved</button></div>
			</div>
			</div>
			</div>
              <table id="example_shortlisted"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>Ug Mark</th>
                                           <th>Entrance Mark</th>
                                           <th>Interview Mark</th>
                                           <th>Total</th>
                                           <th>Community</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student_pg as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><input type="checkbox" class="sel_approve" style="width:20px;height:20px;margin-right:5px;" value="<?=$value->sl_id?>"><?=$i?>
						<input type="hidden" value="Waiting List" id="type" data-main="<?=$value->main_course_id?>" data-app="<?=$value->applied_course_id?>">
						</td>
                        <td><?=$value->application_number?></td>
                        <td><?=$numbertowords->convert_number($value->selection_list)?></td>
                        <td><a href="<?=base_url()?>Admin/viewStudent/<?=$value->pr_user_id?>"><?=$value->pr_applicant_name?> </a></td>
                       
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                
                        <td><?=$value->ug_mark?></td>
                        <td><?=$value->enterence_mark?></td>
                        <td><?=$value->personal_mark?></td>
                        <td><?=sprintf ("%.2f",$value->total_mark)?></td>
                        <td><?=$value->pr_community?></td>
                     
                     
                      
                      <?php if($value->principal_published == 0 ){ ?>
                      <td><button type="submit" value="<?=$value->sl_id?>" class="approvr btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></td>
                    
                 
                       <?php }else{  ?>

                        <td><button type="submit" value="<?=$value->sl_id?>" class="notapproved btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                      <?php  } ?>
                     
                    
                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>Ug Mark</th>
                                           <th>Entrance Mark</th>
                                           <th>Interview Mark</th>
                                           <th>Total</th>
                                           <th>Community</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
		  <?php } ?>
		<!-- PG - Diploma -->	
		<?php if(isset($student_dip)){?>	
			<div class="table-responsive">
			  <div class="row mb-2 ml-1">
			  <div class="col-lg-12">
			  <div class="form-group" style="float:right;">
			<div><input type="checkbox" id="selectAll" style="width:20px;height:20px;margin-right:5px;"><b>Select All</b>&nbsp;&nbsp;<button id="sel_approve" class="btn btn-sm btn-success">Select Approved</button></div>
			</div>
			</div>
			</div>
              <table id="example_shortlisted"  style="width: 100%;" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
										   <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Mobile Number</th>

                                            <th>Email</th>
											<th>Percentage</th>
                                           <th>Reference Number</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student_dip as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><input type="checkbox" class="sel_approve" style="width:20px;height:20px;margin-right:5px;" value="<?=$value->sl_id?>"><?=$i?>
						<input type="hidden" value="Selection List" id="type" data-main="<?=$value->main_course_id?>" data-app="<?=$value->applied_course_id?>">
						</td>
                        <td><?=$value->application_number?></td>
						<td><?=$numbertowords->convert_number($value->selection_list)?></td>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=$value->u_mobile?></td>
                
                        <td><?=$value->u_email_id?></td>
                        <td><?=$value->percentage_obtained?></td>
                        <td>21<?=$value->pr_user_id?></td>
                     
                      
                      <?php if($value->principal_published == 0 ){ ?>
                      <td><button type="submit" value="<?=$value->sl_id?>" class="approvr btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></td>
                    
                 
                       <?php }else{  ?>

                        <td><button type="submit" value="<?=$value->sl_id?>" class="notapproved btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                      <?php  } ?>
                     
                    
                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
										   <th>Listing</th>
                                           <th>Candidate Name</th>
                                           <th>Mobile Number</th>

                                            <th>Email</th>
											<th>Percentage</th>
                                           <th>Reference Number</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
		<?php } ?>
            </div>
          </div>
        </div>
      </div>
	
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 // alert();
$(".approvr").click(function(e){




  var m = $(this).val();

/*   var r = confirm("Candidates marked as 'Not Eligible' will not be listed in selection and waitlist.  Are you sure to mark this candidate as 'Not Eligible'? .");





if (r == true) { */



  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>Admin/approveStudent",
      data: {id:m},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });
//}else{

//return false;

//}
e.preventDefault();
});

$(".notapproved").click(function(e){
e.preventDefault();

//alert();

var m = $(this).val();

  //var r = confirm("This candidate will be moved to the wait list. Are you sure?.");





///if (r == true) {

  

  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>Admin/notApproveStudent",
      data: {id:m},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });
//}else{

//return false;

//} 
});



});
    
    
    </script>