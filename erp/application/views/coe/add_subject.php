
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<?php $bat = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();?>
			<i class="fa fa-table"></i>Subject - Batch <?=$bat->batch_from?> 
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			  <div class="col-lg-4">
          <label>Regulation</label>
		  <select class="form-control" name="regulation">
		  <option value="">Select Regulation</option>
		  <?php $reg = $this->db->get('erp_regulation')->result();
		  foreach($reg as $reg){?>
			  <option value="<?=$reg->id?>"><?=$reg->name?></option>
		  <?php } ?>
		  </select>
		  <input type="hidden" value="<?=$batch_id?>" name="batch_id">
			  <span style="color:red;"><?php echo form_error('regulation'); ?></span>
			  </div>
        <div class="col-lg-4">
          <label>Subject Nature</label>
			  <!--<input type="text" class="form-control" name="subNature">-->
			  <select class="form-control" name="subNature">
			  <option value="">Select Nature</option>
		  <?php $nature = array('THEORY','PRACTICAL');
		  foreach($nature as $nature){?>
			  <option value="<?=$nature?>"><?=$nature?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-4">
          <label>Semester</label>
			  <select class="form-control" name="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>"><?=$sem?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Policy</label>
			  <select class="form-control" name="policy">
			  <option value="">Select Policy</option>
		  <?php $pol = $this->db->get('erp_subpolicy')->result();
		  foreach($pol as $pol){?>
			  <option value="<?=$pol->id?>"><?=$pol->name?></option>
		  <?php } ?>
		  </select>
			  <span style="color:red;"><?php echo form_error('policy'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Code</label>
			  <input type="text" class="form-control" name="subCode">
			  <span style="color:red;"><?php echo form_error('subCode'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Credit Point</label>
			  <input type="text" class="form-control" name="creditPnt">
			  </div>
			  <div class="col-lg-4">
          <label>Subject Name</label>
			  <input type="text" class="form-control" name="subName">
			  <span style="color:red;"><?php echo form_error('subName'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Category</label>
			  <select class="form-control" name="subCatg">
			  <option value="">Select Category</option>
		  <?php $catg = array('Allied','Elective','Interdisciplinary','Core','Record','NME','Foundation');
		  foreach($catg as $catg){?>
			  <option value="<?=$catg?>"><?=$catg?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-2">
          <label>Part Type</label>
			  <select class="form-control" name="part">
			  <option value="">Select Part</option>
		  <?php $part = array('1','2','3','4','5');
		  foreach($part as $part){?>
			  <option value="<?=$part?>"><?=$part?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-2">
          <label>Batchwise Lab SplitUp</label>
			  <input type="radio" name="labSplitup" value="yes">Yes
			  <input type="radio" name="labSplitup" value="no">No
			  </div>
			<div class="col-lg-4">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream" required>
			  <option value="">Select Stream</option>
			  <option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-4" id="dept" style="display:none;">
          <label>Department</label>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>
            </div>


          <div class="row mt-3">  
			  <div class="col-lg-11">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
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
	});
	</script>