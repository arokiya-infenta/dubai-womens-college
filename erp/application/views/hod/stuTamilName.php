<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
	
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');
$this->session->set_flashdata("message","");
            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Update Tamil Name 
			<hr>
			<form action="" method="post">
			<div class="row">
            <div class="col-lg-3">
			<label>Batch</label>
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-md-6 mt-3">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="submit" class="btn btn-primary text-right" value="Submit" >
           
           </div>
           </div>
			  </div>
			  </form>
			</div>
            <div class="card-body">
<?php if(isset($stu_list)){ ?>
            <table id="tamilname-datatable"  class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Register No.</th>
      <th>Name</th>
      <th>Tamil Name</th>
      <th>Action</th> 
    </tr>
  </thead>
  <tbody>
  <?php $sno=1;
  foreach($stu_list as $student){
	  ?>
  <tr>
  <td><?=$sno++?></td>
  <td><?=$student->reg_no_?></td>
  <td><?=$student->student_name_?></td>
  <td><input type="text" class="form-control name" value="<?=$student->Tamilname?>"></td>
  <td>
  <button type="button" class="btn btn-warning btn-sm tamilname" data-id="<?=$student->id?>" data-reg="<?=$student->reg_no_?>">Update</button>
  </td>
  </tr>
  <?php } ?>
  </tbody>
</table>   
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
    <style>
    .anc {
  position: relative;
  float: right;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myTable = $('#tamilname-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();

        $('#batch').change(function(){
			$('#sem').val('');
		});	

    $('.tamilname').click(function(){
		var name = $(this).parent().parent().find('input').val();
		var id = $(this).data('id');	
		var reg_no = $(this).data('reg');	
		  var ele = $(this).parent();	
		  if(confirm('Are you sure to update the name?')){
            $.ajax({
                url: base_url + "hod/tamilnameUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
					name: name,
					reg_no: reg_no,
                },
                success: function (data) {
					alert('Tamil Name Updated Successfully');
					//location.reload(true);
                }
            });
		  }
	});		
	});
    </script>
	
    <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
    </script>
    