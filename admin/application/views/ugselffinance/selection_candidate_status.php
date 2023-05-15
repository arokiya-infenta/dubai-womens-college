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
            <div class="card-header"><i class="fa fa-table"></i> <?php if($status == 1){
                echo" Selection List " . $reservation_type;
            }else if($status == 2){
                echo" Waiting List " . $reservation_type;
            }else{

                echo" Rejection List ". $reservation_type;
            } ?> 
            
            <?php $nst = $this->db->select("*")->from("shotlisted_candidate")
            ->where("sl_main_id",1)->where("sl_course_id",$this->session->userdata("user")["user_dep_status"])->where("selection_list_name",$reservation_type)
            ->where("published",1)
            ->where("reservation_status",$status)
            ->get();
            

              $run = $nst->num_rows();

              if($run > 0){ ?>
               <button  class="anc  btn btn-warning " >Already Published</button> 


 
            <?php  }else{ ?>

              <!--<form method="post" action ="<?=base_url()?>UgSelfFinance/publishSelectionCandidateList">
<input type="hidden" name="status" value="<?=$status?>" >
<input type="hidden" name="reservation" value="<?=$reservation_type?>" >


              <button type="submit"  class="anc  btn btn-success" >Publish List</button> 
              </form>-->
          <?php  }   ?>
            
            <button class="anc  btn btn-danger text-right"  data-toggle="modal" data-target="#myModal" >Generate PDF </button> </div>
          
          
            <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title"><?php if($status == 1){
                echo"Selection List " . $reservation_type;
            }else if($status == 2){
                echo"Waiting List " . $reservation_type;
            }else{

                echo"Rejection List ". $reservation_type;
            } ?> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" action="<?=base_url()?>UgSelfFinance/ShotlistPdf">
      <div class="modal-body">


      <label>List Name</label>
<input type= "text" class="form-control" required name="title" ><br>
<label>Admission Date</label>

<input type= "date" class="form-control" required name="Date" ><br>
<label>Admission Time</label>
<input type= "time" class="form-control" required name="time" ><br>


<label>Admission Venue</label>

<input type= "text" class="form-control"  name="venue" >


<input type= "hidden" name="reservation_type" value="<?=$reservation_type?>" >
<input type= "hidden" name="status" value="<?=$status?>">

<label>Select Sortlist</label>
    
<select required name="csl" class="form-control" >
  <option value="">Selection List</option>
  <option value="1">First</option>
  <option value="2">Second</option>
  <option value="3">Third</option>
  <option value="4">Fourth</option>
  <option value="5">Fifth</option>
  <option value="6">Sixth</option>
  <option value="7">Seventh</option>
  <option value="8">Eighth</option>
  <option value="9">Ninth</option>
  <option value="10">Tenth</option>
</select>




      </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-default" >Create Pdf</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>  
    </div>

  </div>
</div>
          
          
            <div class="card-body">
              <div class="table-responsive">
              <table id="examplezoomview" class="table table-bordered">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>+2 Percentage</th>
                                          
                                           <th>Community</th>
                                           <th>Selection List</th>
                                           <th>Published Status</th>
                                          
                                           
                                        </tr>
                </thead>
                <tbody>


                <?php 
                
                $i=1;  foreach($candidate_list as $sl){ 
                  
                  
                  
                  if($sl->published == 1){

                    $pub = "Published";
                  }else{

                    $pub = "Not Published";
                  }
                  
                  ?> 
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td><?=$sl->application_number?></td>
                                            <td><?=$sl->pr_applicant_name?></td>
                                            <td><?=$sl->pr_dob?></td>
                                           
                                            <td><?=sprintf ("%.2f",$sl->percentage_obtained)?></td>
                                            <td><?=$sl->community?></td>

<?php if($sl->selection_list == 1){ ?>
  <td>First  List</td>

<?php }else if($sl->selection_list == 2){

echo" <td>Second  List</td>";


}else if($sl->selection_list == 3){


  echo" <td>Third  List</td>";

}else if($sl->selection_list == 4){


  echo" <td>Fourth  List</td>";

}else if($sl->selection_list == 5){


  echo" <td>Fifth  List</td>";

}else if($sl->selection_list == 6){


  echo" <td>Sixth  List</td>";

}else if($sl->selection_list == 7){


  echo" <td>Seventh  List</td>";

}else if($sl->selection_list == 8){


  echo" <td>Eighth  List</td>";

}else if($sl->selection_list == 9){


  echo" <td>Ninth  List</td>";

}else if($sl->selection_list == 10){


  echo" <td>Tenth  List</td>";

} ?>

                                            <td><?=$pub?></td>
                                           
                                          
                                        </tr>
                                        <?php  $i++;
                                      } ?>
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>

                                            <th>+2 Percentage</th>
                                          
                                           <th>Community</th>
                                           <th>Selection List</th>
                                           <th>Published Status</th>
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    </div><!--End content-wrapper-->
   
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .anc {
  position: relative;
  float: right;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 // alert();
$("#Allotment").click(function(){
var m = $(this).val();


if(m == 1){

  $("#count").attr('readonly', true);


}else{

  $("#count").val("0");

  $("#count").attr('readonly', false);


}



});




$("#sel1").click(function(){
var m = $(this).val();


var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>UgSelfFinance/selectAllotmentcount",
      data: {m:m},
      dataType: "text",
      success: function(resultData) { 

        var count = $("#count").val(resultData);
       }
});
saveData.error(function() { alert("Something went wrong"); });



});


  $("#submit").click(function(){

    var res = $("#sel1").val();
    var count = $("#count").val();
    var Allotment = $("#Allotment").val();
    var special_res = $("#special_res").val();
    //var res = $("#Allotment").val();


    var myKeyVals = { res : res, count : count, special_res : special_res    
    }



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>UgSelfFinance/selectAllotmentType",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 

        $("#td").html(resultData);

        $("#reservation").val(res);
        $("#other_res").val(special_res);
        $("#allot").val(Allotment);

        var rowCount = $("#td tr").length;
      
        //alert(resultData);
        console.log(rowCount);
       }
});
saveData.error(function() { alert("Something went wrong"); });






  //  $("p").hide();
  });
});
    
    
    </script>

    
    

      </div>
			

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .anc {
  position: relative;
  float: right;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 // alert();
$("#Allotment").click(function(){
var m = $(this).val();


if(m == 1){

  $("#count").attr('readonly', true);


}else{

  $("#count").val("0");

  $("#count").attr('readonly', false);


}



});




$("#sel1").click(function(){
var m = $(this).val();


var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>UgSelfFinance/selectAllotmentcount",
      data: {m:m},
      dataType: "text",
      success: function(resultData) { 

        var count = $("#count").val(resultData);
       }
});
saveData.error(function() { alert("Something went wrong"); });



});


  $("#submit").click(function(){

    var res = $("#sel1").val();
    var count = $("#count").val();
    var Allotment = $("#Allotment").val();
    var special_res = $("#special_res").val();
    //var res = $("#Allotment").val();


    var myKeyVals = { res : res, count : count, special_res : special_res    
    }



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>UgSelfFinance/selectAllotmentType",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 

        $("#td").html(resultData);

        $("#reservation").val(res);
        $("#other_res").val(special_res);
        $("#allot").val(Allotment);

        var rowCount = $("#td tr").length;
      
        //alert(resultData);
        console.log(rowCount);
       }
});
saveData.error(function() { alert("Something went wrong"); });






  //  $("p").hide();
  });
});
    
    
    </script>

    
    