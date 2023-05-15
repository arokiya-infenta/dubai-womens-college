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
            <div class="card-header"><i class="fa fa-file-text"></i> Selection Status </div>
            <div class="card-body">

      <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Selection List</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Waiting List</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Not Eligible List</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <table class="table" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                             <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($selection_list as $sl){  ?> 
                                        <tr>
                                            <td><?=$sl->selection_list_name?></a></td>
                                            <td><?=date("d-m-Y",strtotime($sl->created))?></td>
                                            <td><a href="<?=base_url()?>PgMswAided/ShotlistedCandidates/1/<?=$sl->selection_list_name?>">view</a> | <a  class="text-danger" href="<?=base_url()?>PgMswAided/deleteShotlistedCandidates/1/<?=$sl->selection_list_name?>">Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                      
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table" cellspacing="0">
                                    <thead>
                                    <tr>
                                            <th>Category</th>
                                             <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($Waitinglist_list as $sl){  ?> 
                                        <tr>
                                            <td><?=$sl->selection_list_name?></a></td>
                                            <td><?=date("d-m-Y",strtotime($sl->created))?></td>
                                            <td><a href="<?=base_url()?>PgMswAided/ShotlistedCandidates/2/<?=$sl->selection_list_name?>">view</a> | <a  class="text-danger" href="<?=base_url()?>PgMswAided/deleteShotlistedCandidates/2/<?=$sl->selection_list_name?>">Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <table class="table" cellspacing="0">
                                    <thead>
                                    <tr>
                                            <th>Category</th>
                                             <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rejection_list as $sl){  ?> 
                                        <tr>
                                            <td><?=$sl->selection_list_name?></a></td>
                                            <td><?=date("d-m-Y",strtotime($sl->created))?></td>
                                            <td><a href="<?=base_url()?>PgMswAided/ShotlistedCandidates/3/<?=$sl->selection_list_name?>">view</a>| <a  class="text-danger" href="<?=base_url()?>PgMswAided/deleteShotlistedCandidates/3/<?=$sl->selection_list_name?>">Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
			

    </div>
    </div>
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    </div><!--End content-wrapper-->
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
.project-tab {
    padding: 10%;
    margin-top: -8%;
}
.project-tab #tabs{
    background: #007b5e;
    color: #eee;
}
.project-tab #tabs h6.section-title{
    color: #eee;
}
.project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #0062cc;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
}
.project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
}
.project-tab .nav-link:hover {
    border: none;
}
.project-tab thead{
    background: #f3f3f3;
    color: #333;
}
.project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
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
      url: "<?=base_url()?>PgSelfFinance/selectAllotmentcount",
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
      url: "<?=base_url()?>PgSelfFinance/selectAllotmentType",
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
      url: "<?=base_url()?>PgSelfFinance/selectAllotmentcount",
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
      url: "<?=base_url()?>PgSelfFinance/selectAllotmentType",
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

    
    