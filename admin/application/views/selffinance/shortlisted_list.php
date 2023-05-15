<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

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
            
            <?php 
           
           
           
           $user = $this->db
        ->select("selection_list")
        ->from("shotlisted_candidate")
       
        ->where("shotlisted_candidate.sl_main_id",1)
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
            <div class="col-lg-3"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="col-lg-2">
              
            <form id="target" action="">
            <a href="#" id="allsele_pdf" class="btn btn-danger" >PDF</a>
          
            </form>
          </div>
            <div class="col-lg-5">
						Choose the Upcoming Selection List & then Mark the Candidate as Not Eligible 
						</div>
            <div class="col-lg-2"> 
							   <select id="csl" required name="csl" class="form-control" >
  <option value="0">Selection List</option>
  <option <?php if($sel[0]->selection_list == 1 ){echo"selected";} ?>  value="1">First</option>
    <option  <?php if($sel[0]->selection_list == 2 ){echo"selected";} ?>   value="2">Second</option>
  <option <?php if($sel[0]->selection_list == 3 ){echo"selected";} ?>  value="3">Third</option>
  <option <?php if($sel[0]->selection_list == 4 ){echo"selected";} ?>  value="4">Fourth</option>
  <option <?php if($sel[0]->selection_list == 5 ){echo"selected";} ?>  value="5">Fifth</option>
  <option <?php if($sel[0]->selection_list == 6 ){echo"selected";} ?>  value="6">Sixth</option>
  <option <?php if($sel[0]->selection_list == 7 ){echo"selected";} ?>  value="7">Seventh</option>
  <option <?php if($sel[0]->selection_list == 8 ){echo"selected";} ?>  value="8">Eighth</option>
  <option  <?php if($sel[0]->selection_list == 9 ){echo"selected";} ?> value="9">Ninth</option>
  <option <?php if($sel[0]->selection_list == 10 ){echo"selected";} ?>  value="10">Tenth</option>
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
              <table id="shortlisted"  class="table-striped table-bordered text-center display compact" style="width:100%">
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
                        <td><a href="<?=base_url()?>PgMswSelfFin/viewStudent/"><?=$value->pr_applicant_name?> </a></td>
                       
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
                      <button type="submit" value="<?=$value->sl_id?>" class="custom_reject btn btn-danger">Reject Manually</button></td>
                    
                 
                       <?php }else if($value->reservation_status == 2){  ?>

                        <td><button type="submit"  data-toggle="modal" data-target="#exampleModal<?=$value->sl_id?>" value="<?=$value->sl_id?>" class="btn btn-warning"><i class="fa fa-pause" aria-hidden="true"></i></button></td>
                    
										
										
												<div class="modal fade" id="exampleModal<?=$value->sl_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Move to Selection List </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method = "post" action="<?=base_url()?>PgSelfFinance/costumSelection">

			 <div class="form-group">

			 <input type="hidden" name="sl_id" value="<?=$value->sl_id?>">
    <label for="exampleInputPassword1">Select Selection List</label>
		<select  required name="selet" class="form-control" >
  <option value="0">Selection List</option>
  <option <?php if($sel[0]->selection_list == 1 ){echo"selected";} ?>  value="1">First</option>
    <option  <?php if($sel[0]->selection_list == 2 ){echo"selected";} ?>   value="2">Second</option>
  <option <?php if($sel[0]->selection_list == 3 ){echo"selected";} ?>  value="3">Third</option>
  <option <?php if($sel[0]->selection_list == 4 ){echo"selected";} ?>  value="4">Fourth</option>
  <option <?php if($sel[0]->selection_list == 5 ){echo"selected";} ?>  value="5">Fifth</option>
  <option <?php if($sel[0]->selection_list == 6 ){echo"selected";} ?>  value="6">Sixth</option>
  <option <?php if($sel[0]->selection_list == 7 ){echo"selected";} ?>  value="7">Seventh</option>
  <option <?php if($sel[0]->selection_list == 8 ){echo"selected";} ?>  value="8">Eighth</option>
  <option  <?php if($sel[0]->selection_list == 9 ){echo"selected";} ?> value="9">Ninth</option>
  <option <?php if($sel[0]->selection_list == 10 ){echo"selected";} ?>  value="10">Tenth</option>
</select>
  </div>
<?php  $val = $this->db->select("*")->from("shotlisted_candidate")
 ->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'right' )->where("sl_main_id",$value->sl_main_id)->where("sl_course_id",$value->sl_course_id)->where("selection_list_name",$value->selection_list_name)->where("reservation_status",2)->where("created >=",date("Y")."-01-01")->where("created <=",date("Y")."-12-31")->order_by("total_mark","DESC")->limit(1)->get()->result();

/* echo"<pre>";
print_r($val); */
if($val[0]->sl_id == $value->sl_id){ ?>

<input type="submit" class="btn btn-primary" name="submit" value="submit">
<?php } ?>

			 </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
										
										
										
										
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
 // alert();



$("#allsele_pdf").click(function(e){


	//e.preventDefault();
var csl = $("#csl").val();

if(csl == 0){

alert("Select Selection List");
return false;

}else{

  $("#allsele_pdf").attr("href", "<?= base_url() ?>PgSelfFinance/SelectionlistPdf/<?=$this->uri->segment(3); ?>/"+csl);
 // return true;
 //$("#allsele_pdf").click();
}
//e.preventDefault();

});








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
      url: "<?=base_url()?>PgSelfFinance/ManualSelectWaitingList",
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
      url: "<?=base_url()?>PgSelfFinance/SelectWaitingList",
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
      url: "<?=base_url()?>PgSelfFinance/convertWaitingList",
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
















$(".select").click(function(e){
e.preventDefault();

alert();

var m = $(this).val();

  var r = confirm("This candidate will be moved to the wait list. Are you sure?.");





if (r == true) {

  

  var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgSelfFinance/rejectSelectionList",
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
