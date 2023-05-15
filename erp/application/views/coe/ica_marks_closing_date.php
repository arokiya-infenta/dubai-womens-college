
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
            <div class="card-header">
			<i class="fa fa-table"></i>ICA Marks Closing Date 
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->id?>" <?php if($batch->id==$batch1) {echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Semester</label>
			  <select class="form-control" name="sem" id="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>" <?php if($sem==$sem1) {echo 'selected';}?>><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>
                         <div class="col-sm-3">
                  <div class="form-group">
                    <label>Closing Date</label>
                    <input type="date" class="form-control" id="date_edit" name="closing_date" required value="<?=$date1?>">
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                  </div>
                </div>
			  <div class="col-sm-3 mt-3">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
        </div>
			  </div>	
              </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
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
		
		
		
		$('#batch,#sem').click(function(){
			$('#date_edit').val('');
			$('#edit_id').val('');
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
		  if(batch!='' && sem!=''){
            $.ajax({
                url: base_url + "coe/icaMarksClosingDateUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					dataParse = JSON.parse(data);
					var closing_date = dataParse.closing_date;
					var edit_id = dataParse.id;
					$('#date_edit').val(closing_date);
					$('#edit_id').val(edit_id);
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