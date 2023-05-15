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
            <div class="card-header"><i class="fa fa-table"></i> Seat Allocation</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category </th>
                        <th>No of Seats</th>
                        <th>Action</th>
                   
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($reservation as $key => $value) { ?>
                    <tr>
                        <th><?=$value->rs_name?> </th>
                        <th><input type="number" id="count_<?=$value->rs_id?>" class="count form-control" name="count" value="<?=$value->rc_count?>"> </th>
                        <th><button type="submit" class="update btn btn-primary" value="<?=$value->rs_id?>">Update</button></th>
                       
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>Category </th>
                        <th>No of Seats</th>
                        <th>Action</th>
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 // alert();
  $(".update").click(function(){


    var u_id = $(this).val();

var count  = $("#count_"+u_id).val();




    var myKeyVals = { u_id : u_id, count : count }



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>PgSelfFinance/updateSeatAllocation",
      data: myKeyVals,
      dataType: "text",
      success: function(resultData) { 

    
        location.reload(true);
    
       }
});
saveData.error(function() { alert("Something went wrong"); });





  //  $("p").hide();
  });
});
    
    
    </script>