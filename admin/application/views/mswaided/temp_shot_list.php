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
            <div class="card-header"><i class="fa fa-file-text"></i> shortlist Status <!--<a  class="anc btn btn-info text-right" href="<?=base_url()?>PgSelfFinance/calculateMark">Calculate Candidates' Total</a>--></div>
            <div class="card-body">
            
            <div class="row">

<?php  $sl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",2)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",1)->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')->get();
$sl_cou = $sl->num_rows();



$wl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",2)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",2)->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')->get();
$wl_cou = $wl->num_rows();


$rl = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",2)->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])->where("reservation_status",3)->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')->get();
$rl_cou = $rl->num_rows();


?>


					 <div class="col-md-4 ">
           <a href = "<?=base_url()?>PgMswAided/viewAllotment/1" >Selection List : <?=$sl_cou?> </a>
           </div>
					 <div class="col-md-4 ">
           <a href = "<?=base_url()?>PgMswAided/viewAllotment/2" >Waiting List : <?=$wl_cou?></a>
					 </div>
					 	 <div class="col-md-4 ">
              <a href = "<?=base_url()?>PgMswAided/viewAllotment/3" >Not Eligible List: <?=$rl_cou?></a>
					 </div>
					 
					</div>	
      </div>
      <div class="row">
      <div class="col-md-6 ">
            <h5 class="text-center">Selection List </h5>
<?php  $sl = $this->db->select("*")->from("resrvation_table")->where("rc_main_id",2)->where("rc_cource_id",$this->session->userdata('user')['user_dep_status'])->get();
$sl_cou = $sl->result();

foreach($sl_cou as $v){

    $snt = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",2)
  
  ->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])
  ->where("selection_list_name",$v->rs_name)
  ->where("reservation_status",1)
	->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
  ->get();
  $snt_r= $snt->num_rows(); ?>


<h6><?=$v->rs_name?> List : <?=$snt_r?></h6>

<?php

}


?>


					
         
           </div>
					 
           <div class="col-md-6 ">
        
           <h5 class="text-center">Waiting List </h5>
<?php  $sl = $this->db->select("*")->from("resrvation_table")->where("rc_main_id",2)->where("rc_cource_id",$this->session->userdata('user')['user_dep_status'])->get();
$sl_cou = $sl->result();

foreach($sl_cou as $v){

    $snt = $this->db->select("*")->from("shotlisted_candidate")->where("sl_main_id",2)
  
  ->where("sl_course_id",$this->session->userdata('user')['user_dep_status'])
  ->where("selection_list_name",$v->rs_name)
  ->where("reservation_status",2)
	->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
  ->get();
  $snt_r= $snt->num_rows(); ?>



<h6><?=$v->rs_name?> List : <?=$snt_r?></h6> 
<?php

}


?>


					
         
           </div>		
           </div>		
      </div>
   
      </div>








   
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><div class="row">
            <div class="col-md-10">
            
            
            <i class="fa fa-file-text"></i> Shortlist criteria
            
           </div>
           <div class="col-md-2">
        
          
           </div>
           </div> </div>
            <div class="card-body">





          
            <div class="row">
          
					 <div class="col-md-2">
           <select class="form-control"  id="Allotment">
    <option value = "" >Selection  Type</option>
    <option value = "1" >Selection List</option>
    <option value = "2" >Waiting List</option>
           </select>
           </div>
					 <div class="col-md-3">
           <select class="form-control" id="sel1">
    <option value = "" >Select Option</option>

 

           <?php 
           foreach ($reservation as $key => $value) { ?>
            <option value="<?=$value->rs_name?>"><?=$value->rs_name?></option>
        <?php   }
           
           
           ?>
           </select>  
           
           
           </div>
					 <div class="col-md-3">
				<input type="number" id="count" name="count" class="form-control">
					 </div>
				

           <div class="col-md-3">
           <select class="form-control" id="special_res">
    <option value = "" >Select Special Reservation</option>
    <option value = "Child of Ex-Service Man" >Child of Ex-Service Man</option>
    <option value = "Sports" >Sports</option>
    <option value = "Disability" >Disability</option>
           </select>
           
           </div>
         
					 <div class="col-md-1">
           <input  type="Submit" id="submit" name="submit" class="btn btn-primary text-right" value="Submit" >
           
           </div>
        
					</div>

   



            </div>
          </div>
        </div>



        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
          
          
            <div class="row">
            <div class="col-md-10">
            
            
            <i class="fa fa-file-text"></i> Shortlisted Candidate 
            
           </div>
           <div class="col-md-2">
            <input type="checkbox" id="checkAll"> Check All
          
           </div>
           </div> 
          
          </div>
            <div class="card-body">
            <form method="post" action="<?=base_url()?>PgMswAided/registerAllocation">
            <div id="allo" class="row">
            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Ug Precentage</th>
      <th scope="col">Entrance Mark</th>
      <th scope="col">Interview Mark</th> 
      <th scope="col">Total Mark</th> 
      <th scope="col">Community</th> 
      <th scope="col">Other Reservation</th> 
    </tr>
  </thead>
  <tbody id="td">
  </tbody>
</table>
		      

					</div>
          <div  class="row">
<div class="col-md-6">
           <input type="hidden" id="reservation" name="reservation" value="">
           <input type="hidden" id="other_res"  name="other_res" value="">
           <input type="hidden" id="allot"  name="Allotment" value="">
        
           
    
           </div>
           <div class="col-md-5"></div>
           <div class="col-md-1">
           
           
      <input type="submit" class="btn btn-primary" name="submit" value = "Save">
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
      url: "<?=base_url()?>PgMswAided/selectAllotmentcount",
      data: {m:m},
      dataType: "text",
      success: function(resultData) { 

        var count = $("#count").val(resultData);
       }
});
saveData.error(function() { alert("Something went wrong"); });



});


  $("#submit").click(function(){

    $("#checkAll").click(function () {
     $('.check_box').not(this).prop('checked', this.checked);
 });



    var res = $("#sel1").val();
    var count = $("#count").val();
    var Allotment = $("#Allotment").val();
    var special_res = $("#special_res").val();
    //var res = $("#Allotment").val();


    var myKeyVals = { res : res, count : count, special_res : special_res    
    }



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgMswAided/selectAllotmentType",
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

    
    