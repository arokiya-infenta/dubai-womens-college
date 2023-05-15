
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Subject</div>
            <div class="card-body">
              <form action="" method="POST">
			  <div class="row">
			  <div class="col-lg-4">
			  <label>Batch</label>
			  <input type="text" class="form-control" value="<?=$sub_list->batch_year?>" readonly>
			  </div>
			  </div>
            <div class="row">
			  <div class="col-lg-4">
          <label>Regulation</label>
		  <select class="form-control" name="regulation">
		  <option value="">Select Regulation</option>
		  <?php $reg = $this->db->get('erp_regulation')->result();
		  foreach($reg as $reg){?>
			  <option value="<?=$reg->id?>" <?php if($reg->id==$sub_list->regulation){echo 'selected';}?>><?=$reg->name?></option>
		  <?php } ?>
		  </select>
			  <span style="color:red;"><?php echo form_error('regulation'); ?></span>
			  </div>
        <div class="col-lg-4">
          <label>Subject Nature</label>
			  <!--<input type="text" class="form-control" name="subNature" value="<?=$sub_list->subNature?>">-->
			  <select class="form-control" name="subNature">
			  <option value="">Select Nature</option>
		  <?php $nature = array('THEORY','PRACTICAL');
		  foreach($nature as $nature){?>
			  <option value="<?=$nature?>" <?php if($nature==$sub_list->subNature){echo 'selected';}?>><?=$nature?></option>
		  <?php } ?>
		  </select>
			  <input type="hidden" class="form-control" name="edit_id" value="<?=$sub_list->id?>">
			  </div>
			  <div class="col-lg-4">
          <label>Semester</label>
			  <select class="form-control" name="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>" <?php if($sem==$sub_list->sem){echo 'selected';}?>><?=$sem?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Policy</label>
			  <select class="form-control" name="policy">
			  <option value="">Select Policy</option>
		  <?php $pol = $this->db->get('erp_subpolicy')->result();
		  foreach($pol as $pol){?>
			  <option value="<?=$pol->id?>" <?php if($pol->id==$sub_list->policy){echo 'selected';}?>><?=$pol->name?></option>
		  <?php } ?>
		  </select>
			  <span style="color:red;"><?php echo form_error('policy'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Code</label>
			  <input type="text" class="form-control" name="subCode" value="<?=$sub_list->subCode?>">
			  <span style="color:red;"><?php echo form_error('subCode'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Credit Point</label>
			  <input type="text" class="form-control" name="creditPnt" value="<?=$sub_list->creditPnt?>">
			  </div>
			  <div class="col-lg-4">
          <label>Subject Name</label>
			  <input type="text" class="form-control" name="subName" value="<?=$sub_list->subName?>">
			  <span style="color:red;"><?php echo form_error('subName'); ?></span>
			  </div>
			  <div class="col-lg-4">
          <label>Subject Category</label>
		  <select class="form-control" name="subCatg">
			  <option value="">Select Category</option>
		  <?php $catg = array('Allied','Elective','Interdisciplinary','Core','Record','NME','Foundation');
		  foreach($catg as $catg){?>
			  <option value="<?=$catg?>" <?php if($catg==$sub_list->subCatg){echo 'selected';}?>><?=$catg?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-2">
          <label>Part Type</label>
			  <select class="form-control" name="part">
			  <option value="">Select Part</option>
		  <?php $part = array('1','2','3','4','5');
		  foreach($part as $part){?>
			  <option value="<?=$part?>" <?php if($part==$sub_list->part){echo 'selected';}?>><?=$part?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-lg-2">
          <label>Batchwise Lab SplitUp</label>
			  <input type="radio" name="labSplitup" <?php if($sub_list->labSplitup=='yes'){echo 'checked';}?> value="yes">Yes
			  <input type="radio" name="labSplitup" <?php if($sub_list->labSplitup=='no'){echo 'checked';}?> value="no">No
			  </div>
			<div class="col-lg-4">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream" required>
			  <option value="">Select Stream</option>
			  <option value="5" <?php if($sub_list->stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($sub_list->stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($sub_list->stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($sub_list->stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($sub_list->stream=='4'){echo 'selected';}?>>PG Diploma</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-4" id="dept">
          <label>Department</label>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			  <?php $dept = $this->db->where('main_id',$sub_list->stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($sub_list->department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php } ?>
			  </select>
			  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>
				<div class="col-lg-4" id="25_mark">
          <label>Project Mark 25</label>
			  <select class="form-control" id="tot_mark25" name="tot_mark25" required>
			  <option value="">Select Mark</option>
			  
			<option value="1" <?php if($sub_list->msw_m_25==1){echo 'selected';}?>>yes</option>
			<option value="0" <?php if($sub_list->msw_m_25==0){echo 'selected';}?>>no</option>
		
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
