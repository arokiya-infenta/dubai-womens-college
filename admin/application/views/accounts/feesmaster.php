
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
		  <div class="card-header">
		  <button class="btn btn-sm btn-success" style="float:right;" data-target="#myModal" data-toggle="modal">Add</button>
		  </div>
		  </div>
		 </div>
       </div>		 
		  
	<!--Results for UG -->
					<?php if(isset($feesdetails)){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="example_fees_master" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($feesdetails as $key => $value) { ?>
                        <tr>
                        <th style="width:150px;"><?=$sno++?> </th>
                        <th><?=$value->name?></th>
                        <th>
						<!--<button id="edit" class="btn btn-sm btn-success edit" data-name="<?=$value->name?>" data-id="<?=$value->id?>" data-target="#editModal" data-toggle="modal">Edit</button>-->
						<?php if($value->status==1){$style='background-color:green';$stat='Enabled';}
						else{$style='background-color:red';$stat='Disabled';}?>
						<button id="status" class="btn btn-sm btn-success status" style="<?=$style?>" data-value="<?=$value->status?>" data-id="<?=$value->id?>"><?=$stat?></button>
                        </th>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Action</th>
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
					<?php } ?>
			
<!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="<?=base_url()?>accounts/feesMaster" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Fees Type</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-7">
			<input type="text" class="form-control" placeholder="Enter Fees Type" name="name">
			</div>
			</div>
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Modal Edit-->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
	  <form action="<?=base_url()?>accounts/feesMaster" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Fees Type</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-7">
			<input type="text" id="edit_name" class="form-control edit_name" placeholder="Enter Fees Type" name="edit_name">
			<input type="hidden" id="edit_id" class="form-control edit_id" name="edit_id">
			</div>
			</div>
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
			
				<!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
$("#main_course_id").change(function () {
	$("#stu").css('display','none');
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
			$("#stu").css('display','none');
		}
    });
$("#app_course_id").change(function () {
        if ($('#app_course_id').val() != "" && $('#main_course_id').val() != "") {
            $.ajax({
                url: base_url + "accounts/get_students",
                type: 'POST',
                cache: false,
                data: {
                    app_course_id: $('#app_course_id').val(), 
					main_course_id: $('#main_course_id').val()
                },
                success: function (data) {
					$("#stu").css('display','block');
                       $("#students").html(data);
                }
            });
        }else{
			$("#stu").css('display','none');
		}
    });
   $('#students').select2();
	</script>
	<script>	
  $('#students').select2({}).on("change", function (e) {
  if($('#app_course_id').val() != "" && $('#main_course_id').val() != "" && $('#students').val() != "")	{
	  $('#con_pen').css('display','block');
  }  
   });
	</script>
	<script>	
  $('.edit').on("click", function (e) {
	  var edit_id=$(this).data('id');
	  var edit_name=$(this).data('name');
  $('.edit_id').val(edit_id); 
  $('.edit_name').val(edit_name); 
   });
	</script>
	<script>
$(".status").click(function () {
	$(this).text('');
	var status = $(this).data('value');
	var stat_id = $(this).data('id');
	var btn = $(this);
            $.ajax({
                url: base_url + "accounts/feesMasterStatus",
                type: 'POST',
                cache: false,
                data: {
                    status: status,
                    id: stat_id
                },
                success: function (data) {
					if(data==1){
                       btn.data('value',data);
                       btn.text('Enabled');
					   btn.css('background-color','green');
					}else{
					   btn.data('value',data);
					   btn.text('Disabled');
					   btn.css('background-color','red');
					} 
                }
            });
    });
	</script>
    