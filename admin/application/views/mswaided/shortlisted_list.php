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
          <div class="card-header"> 
            <div class="row">
        
            <div class="col-lg-3"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="col-lg-2">
              
            <form id="target" action="">
            <a href="#" id="allsele_pdf" class="btn btn-danger" >PDF</a>
          
            </form>
          </div>
					<div class="col-lg-5">
						Choose the Upcoming Selection List & then Mark the Candidate as Not Eligible 
						</div>

			<?php			       
						$user = $this->db
        ->select("selection_list")
        ->from("shotlisted_candidate")
       
        ->where("shotlisted_candidate.sl_main_id",2)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
				->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      ->order_by("selection_list", "DESC")
        ->get();


				$sel = $user->result();   
           
        ?>   
           
      
            <div class="col-lg-2">    <select id="csl" required name="csl" class="form-control" >
  <option  value="0">Selection List</option>
  <option <?php if($sel[0]->selection_list == 1 ){echo"selected";} ?>  value="1">First</option>
  <option  <?php if($sel[0]->selection_list == 2 ){echo"selected";} ?>   value="2">Second</option>
  <option   <?php if($sel[0]->selection_list == 3 ){echo"selected";} ?>  value="3">Third</option>
  <option  <?php if($sel[0]->selection_list == 4 ){echo"selected";} ?>   value="4">Fourth</option>
  <option  <?php if($sel[0]->selection_list == 5 ){echo"selected";} ?>   value="5">Fifth</option>
  <option  <?php if($sel[0]->selection_list == 6 ){echo"selected";} ?>   value="6">Sixth</option>
  <option  <?php if($sel[0]->selection_list == 7 ){echo"selected";} ?>   value="7">Seventh</option>
  <option   <?php if($sel[0]->selection_list == 8 ){echo"selected";} ?>  value="8">Eighth</option>
  <option  <?php if($sel[0]->selection_list == 9 ){echo"selected";} ?>   value="9">Ninth</option>
  <option  <?php if($sel[0]->selection_list == 10 ){echo"selected";} ?>  value="10">Tenth</option>
</select>


<?php 
$uri_seg_wait = $this->uri->segment(3);

if($uri_seg_wait == 2 ){


echo'<a href="#" id="convert_wait" class="btn btn-warning" >Convert Waitinglist</a>';



}?>



</div>
        
           
          </div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="shortlisted"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
								<th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>Ug Mark</th>
                                           <th>Entrance Mark</th>
                                           <th>Interview Mark</th>
                                           <th>Total</th>
                                           <th>Community</th>
                                           <th>Quota</th>
                                           <th>List</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><?=$i?></td>
                        <td><?=$value->application_number?></td>
                        <td><a href="#"><?=$value->pr_applicant_name?> </a></td>
                       
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                
                        <td><?=$value->ug_mark?></td>
                        <td><?=$value->enterence_mark?></td>
                        <td><?=$value->personal_mark?></td>
                        <td><?=sprintf ("%.2f",$value->total_mark)?></td>
                        <td><?=$value->pr_community?></td>
												<td><?=$value->selection_list_name?></td>
												<?php if($value->selection_list == 1 ){ ?>
													<td>First</td>
													<?php }else if($value->selection_list == 2){  ?>
														<td>Second</td>
													<?php }else if($value->selection_list == 3){  ?>
														<td>Third</td>
													<?php }else if($value->selection_list == 4){  ?>
														<td>Forth</td>
													<?php }else if($value->selection_list == 5){  ?>
														<td>Fifth</td>
													<?php }else if($value->selection_list == 6){  ?>
														<td>Six</td>	
														<?php }else if($value->selection_list == 7){  ?>
														<td>Seven</td>
															<?php }else if($value->selection_list == 8){  ?>
														<td>Eight</td>
															<?php }else if($value->selection_list == 9){  ?>
														<td>Nine</td>
														<?php  }else{ ?>
															<td>Ten</td>
															<?php }  ?>
                     
                      
                      <?php if($value->reservation_status == 1 ){ ?>
                      <td><button type="submit" value="<?=$value->sl_id?>" class="reject btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button>
										
										  <button type="submit" value="<?=$value->sl_id?>" class="custom_reject btn btn-danger">Reject Manually</button>
										</td>
                    
                 
                       <?php }else if($value->reservation_status == 2){  ?>

                        <td><button type="submit" value="<?=$value->sl_id?>" class="btn btn-warning"><i class="fa fa-pause" aria-hidden="true"></i></button></td>
                      <?php  }else{ ?>
                        <td><button type="submit" value="<?=$value->sl_id?>" class="select btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></td>

                      <?php }  ?>
                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
								<th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>Ug Mark</th>
                                           <th>Entrance Mark</th>
                                           <th>Interview Mark</th>
                                           <th>Total</th>
                                           <th>Community</th>
                                           <th>Quota</th>
                                           <th>List</th>
                                           <th>Action</th>
                                           
                                        </tr>
                </tfoot>
            </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){


	$(".custom_reject").click(function(e){


var r = confirm("Please Reject the candidate if No candidate in Waitinglist ");

if (r == true) {
var csl = $("#csl").val();



if(csl == 0){

alert("Select Selection List");
return false;

}else{





 var m = $(this).val();

var r = confirm("Candidates marked as 'Not Eligible' will not be listed in selection and waitlist.  Are you sure to mark this candidate as 'Not Eligible'? .");





if (r == true) {



var saveData = $.ajax({
		type: 'POST',
		url: "<?=base_url()?>PgMswAided/ManualSelectWaitingList",
		data: {id:m,sel:csl},
		dataType: "text",
		success: function(resultData) { 
//alert(resultData);
		 console.log(resultData);

		 location.reload()
		 }
});
saveData.error(function() { alert("Something went wrong"); });
}else{

return false;

}

}
}else{

	return false;
}

});


	$("#convert_wait").click(function(e){


var csl = $("#csl").val();



if(csl == 0){

alert("Select Selection List");
return false;

}else{





  

  var r = confirm("You want to move all student in waiting list .");





if (r == true) {



  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgMswAided/convertWaitingList",
      data: {sel:csl},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });
}else{

return false;

}

}
e.preventDefault(); 
});









  $("#allsele_pdf").click(function(e){



var csl = $("#csl").val();

if(csl == 0){

alert("Select Selection List");
return false;

}else{

  $("#allsele_pdf").attr("href", "<?= base_url() ?>PgMswAided/SelectionlistPdf/<?=$this->uri->segment(3); ?>/"+csl);
 // return true;
 $("#allsele_pdf").click();
}
//e.preventDefault();

});



 // alert();
$(".reject").click(function(e){


  var csl = $("#csl").val();
  if(csl == 0){

alert("Select Selection List");
return false;

}else{
  var m = $(this).val();

  var r = confirm("Candidates marked as 'Not Eligible' will not be listed in selection and waitlist.  Are you sure to mark this candidate as 'Not Eligible'? .");

if (r == true) {
  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgMswAided/SelectWaitingList",
      data: {id:m,sel:csl},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });
}else{

return false;

}
}
e.preventDefault();
});

$(".select").click(function(e){
e.preventDefault();

alert();

var m = $(this).val();

  var r = confirm("This candidate will be moved to the wait list. Are you sure?.");





if (r == true) {

  

  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgMswAided/rejectSelectionList",
      data: {id:m},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });
}else{

return false;

} 
});



});
    
    
    </script>
