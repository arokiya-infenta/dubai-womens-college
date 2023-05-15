
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
	  
	   <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
		<div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
          <div class="card">
		  <div class="card-header"><i class="fa fa-table"></i>Attendance Sheet</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:left;">
				 <?php if(isset($exam_sched)){ ?>
				 <a href="<?=base_url().'coe/attendanceSheetPDF/'.$room_id.'/'.$subject_id?>">
			<button type="button" class="btn btn-sm btn-primary" name="submit">Download Sheet</button></a>
				 <?php } else { ?>
				 <span style="font-weight:bold;">Exam has not been scheduled yet</span>
				 <?php } ?>
		         </div>
		         </div>
			  </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($seat_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
				 <div class="row">
				 <div class="col-lg-1 mt-4">
			<h6 style="font-weight:bold;text-transform:uppercase;float:left;">Subject : </h6></div>
			<div class="col-lg-5 mt-4"><div class="form-group" style="float:left;">
			<span><?=$subject_name?></span></div></div>
		         </div>
				 <div class="row">
				 <div class="col-lg-1">
			<h6 style="font-weight:bold;text-transform:uppercase;float:left;">Block : </h6></div>
			<div class="col-lg-5"><div class="form-group" style="float:left;">
			<span><?=$block_name?></span></div></div>
		         </div>
				 <div class="row">
				 <div class="col-lg-1">
			<h6 style="font-weight:bold;text-transform:uppercase;float:left;">Room : </h6></div>
			<div class="col-lg-5"><div class="form-group" style="float:left;">
			<span><?=$room_name?></span></div></div>
		         </div>
				 <div class="row">
				 <div class="col-lg-1">
			<h6 style="font-weight:bold;text-transform:uppercase;float:left;">Date : </h6></div>
			<div class="col-lg-5"><div class="form-group" style="float:left;">
				 <?php if(isset($exam_sched)){ ?>
				 <span><?=date('d-m-Y',strtotime($exam_sched->schedule_date))?></span><?php } else { ?>
				 <span>Exam has not been scheduled yet<?php } ?>
			</div></div>
		         </div>
				 <div class="row">
				 <div class="col-lg-1">
			<h6 style="font-weight:bold;text-transform:uppercase;float:left;">Session : </h6></div>
			<div class="col-lg-5"><div class="form-group" style="float:left;">
			<span><?=$session?></span></div></div>
		         </div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Register No</th>
                        <th>Student</th>
                        <th>Seat</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($seat_list)){
					$sno=1;
					foreach ($seat_list as $seats) {
						$stu_name = $this->db->where('id',$seats->student_id)->get('erp_existing_students')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stu_name->reg_no_?></td>
                        <td><?=$stu_name->student_name_?></td>
						<td><?=$seats->seat_no?></td>
                    </tr>
                    <?php }} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
			  <?php } ?>
	  <!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();	
	$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#department').append(data);
                }
            });
        }else{
			$('#dept').css('display','none');
		}
		});
    $('#department').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $(this).val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "coe/getSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			alert('Select all the fields');
		}
		});	
		
	});
	</script>