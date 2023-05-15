
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
			<i class="fa fa-table"></i> Moderation Range
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<!--<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>"><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Semester</label>
			  <select class="form-control" name="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>"><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>-->
			<div class="col-lg-3">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream">
			  <option value="">Select Stream</option>
			  <option value="UG" <?php if($stream=='UG'){echo 'selected';}?>>UG</option>
			<option value="PG" <?php if($stream=='PG'){echo 'selected';}?>>PG</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Range From</label>   
			<input type="text" class="form-control" name="range_from" id="range_from" value="<?=set_value('range_from')?>">
			<span style="color:red;"><?=form_error('range_from')?></span>
		         </div>
			  <div class="col-lg-3">
			<label>Range To</label>   
			<input type="text" class="form-control" name="range_to" id="range_to" value="<?=set_value('range_to')?>">
			<input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?=set_value('edit_id')?>">
			<span style="color:red;"><?=form_error('range_to')?></span>
		         </div> 
			  <div class="col-lg-3 mt-3">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Update</button>
        </div>
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
		
		$('#department,#stream').change(function(){
			$('#range_from').val('');
			$('#range_to').val('');
			$('#edit_id').val('');
		  var stream = $('#stream').val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getModerationRange",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                },
                success: function (data) {
					 var data1 = jQuery.parseJSON(data);
					$('#range_from').val(data1.from);
					$('#range_to').val(data1.to);
					$('#edit_id').val(data1.id);
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
