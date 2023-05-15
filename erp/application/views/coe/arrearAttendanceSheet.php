
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
		  <div class="card-header"><i class="fa fa-table"></i>Arrear Attendance Sheet</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Block</label>   
			<select class="form-control" name="block_id" id="block">
			<option value="">Select Block</option>
			<?php $block = $this->db->get('erp_blocks')->result();
			foreach($block as $block){?>
			<option value="<?=$block->id?>" <?php if($block1==$block->id){echo 'selected';}?>><?=$block->block_name?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('block_id')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Room</label>   
			<select class="form-control rem" name="room_id" id="room">
			<option value="">Select Room</option>
			<?php if(isset($block1)){ $room = $this->db->where('block_id',$block1)->get('erp_rooms')->result();
			foreach($room as $room){?>
			<option value="<?=$room->id?>" <?php if($room1==$room->id){echo 'selected';}?>><?=$room->room_name?></option>
			<?php }} ?>
			</select>
			<span style="color:red;"><?php echo form_error('room_id')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Schedule Date</label>   
			<input type="date" class="form-control" name="schedule_date" value="<?=$schedule_date1?>">
		         </div>
			  </div>
			  <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($alloted_seat)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
		  <form action="" method="post">
			   <div class="row">
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:left;">
				 <a href="<?=base_url().'coe/arrearAttendanceSheetPDF/'.$room1.'/'.$schedule_date1?>">
			<button type="button" class="btn btn-sm btn-primary" name="submit">Download Sheet</button></a>
		         </div>
		         </div>
			  </div>
            </form>	
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="arrear-seatallot" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Batch </th>
                        <th>Name</th>
                        <th>Register No</th>
                        <th>Room</th>
                        <th>Seat</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
						$stu_det = array();
					foreach($alloted_seat as $seats){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=substr($seats->batch_,0,4)?></td>
                        <td><?=$seats->student_name_?></td>
                        <td><?=$seats->reg_no_?></td>
                        <td><?=$seats->room_name?></td>
                        <td data-student="<?=$seats->stu_id?>" data-room="<?=$seats->id?>"><?=$seats->seat_no?>
						</td>
                    </tr>
						<?php } ?>
                 
               
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
var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#arrear-seatallot').DataTable();
var allPages = myTable.rows().nodes().to$();	

	$('#block').change(function(){
			$('#room').empty();
			$('#remaining_spaces').val('');
		  var block_id = $(this).val();	
			if (block_id!='') {
            $.ajax({
                url: base_url + "coe/getRooms",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    block_id: block_id,
                },
                success: function (data) {
					$('#room').append(data);
                }
            });
        }else{
			alert('Select Block');
		}
		});
	
	});
	</script>