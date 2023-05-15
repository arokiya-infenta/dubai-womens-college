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
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Delete Attendance
		  </div>
		  <div class="card-body">
			
			   <div class="row">
			   <div class="col-lg-2">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>"><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			<div class="col-lg-2">
			   <label>Sem</label>
			<select class="form-control" id="sem" name="sem">
			  <option value="">Select Sem</option>
			  <?php $sem=array(1,2,3,4,5,6,7,8);
			  foreach($sem as $sem){ 
			  ?>
			  <option value="<?=$sem?>"><?=$sem?></option>
			  <?php } ?>
			  </select>
			</div>
			<div class="col-lg-4">
			   <label>Subject</label>
			<select class="form-control" id="subject" name="subject">
			  <option value="">Select Subject</option>
			  </select>
			</div>
			<div class="col-lg-2">
			   <label>Date</label>
           <input class="form-control" type="date"  id="date" name="date"/>
			  </div>
			<div class="col-lg-2">
			   <label>Hour</label>
			<select class="form-control" id="period" name="period">
			  <option value="">Select Hour</option>
			  <?php $period=array(1,2,3,4,5,6);
			  foreach($period as $period){ 
			  ?>
			  <option value="<?=$period?>"><?=$period?></option>
			  <?php } ?>
			  </select>
			</div>
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="button" class="btn btn-sm btn-success" id="del_att" name="submit">Submit</button>
		         </div>
		         </div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#department').change(function(){
			$('#pgrm').css('display','block');
			$('#program').empty();
		  var dept = $(this).val();	
			if (dept!='') {
            $.ajax({
                url: base_url + "hod/getPgrm",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    dept: dept
                },
                success: function (data) {
					$('#program').append(data);
                }
            });
        }
		});
		
		$('#batch,#sem').change(function(){
			$('#subject').empty();
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "hod/getSubjec",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});
	});
	</script>
	<script>
	
$("#del_att").click(function () {

	var batch = $('#batch').val();
	var sem = $('#sem').val();
	var subject = $('#subject').val();
 var period=$('#period').val();
 var date=$('#date').val();
 
 if(subject==''){
	 alert('Please Select a Subject');
	 return false;
 }
 if(period==''){
	 alert('Please Select a Period');
	 return false;
 }
 if(sem==''){
	 alert('Please Select Sem');
	 return false;
 }
 if(batch==''){
	 alert('Please Select Batch');
	 return false;
 }
 if(date==''){
	 alert('Please Select a Date');
	 return false;
 }
	
 
swal({   title: "Are you sure to delete attendance?",
 
type: "warning",
 
showCancelButton: true,
 
confirmButtonColor: "#DD6B55",
 
confirmButtonText: "Yes!",
 
cancelButtonText: "Cancel",
 
closeOnConfirm: false,
 
closeOnCancel: false },
 
function(isConfirm){
 
if (isConfirm)
 
{
	 
	$.ajax({
                url: base_url + "hod/verifyAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    period: period,
                    subject: subject,
                    date: date,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					if(data==0){
swal("Attendance Not Marked!", "Attendance Not Marked for this period!", "success");
				//location.reload();
					}
				    else if(data==1){
swal("Already Marked by another Staff!", "Attendance cannot be deleted for this period!", "success");							
					}
					else {
						
						$.ajax({
                url: base_url + "hod/delAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    period: period,
                    subject: subject,
                    date: date,
                    batch: batch,
                    sem: sem,
                },
                success: function (data2) {
swal("Attendance Deleted!", "Attendance Deleted Successfully!", "success");
				//location.reload();
                }
            });									
					}
                }
            });
 
 
}
 
else {
 
swal("OOps", "Attendance Not Marked!", "error");
 
} });
 
 
    });	
	</script>