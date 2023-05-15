
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
			<i class="fa fa-table"></i> File Download
			</div>
            <div class="card-body">
              <form action="" method="POST">
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
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
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
	  
	  
	  <!--Start Row-->
	  <?php if($_POST){ ?>
	  
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
			<i class="fa fa-table"></i> File Download (Click to Download)
			</div>
            <div class="card-body">
              <div class="row mt-3">  
			  <?php if(isset($qpaper)){ 
			  $file1 =  $qpaper->file;
			  if($file1 != ''){$file2 = explode('/',$qpaper->file); $file = $file2[3];}else{
			  $file = '';$q = 'Not Yet Uploaded!';}
			  $q = '';
			  }else{
			  $file1 = '';
			  $file = '';
			  $q = 'Not Yet Uploaded!';
			  } ?>
			  <div class="col-lg-4">
			  <label>Question Paper</label>
			<a href="<?=base_url().$file1;?>" download><p><?=$file?></p></a>
			<span style="font-weight:bold;color:red;"><?=$q?></span>
			  </div>
			  </div>
			  
			  <hr>
			  <div class="row mt-3">  
			  <?php $chec_y = '';$chec_n = '';
			  if($qpaper->finalize == 0){$chec_n = 'checked';}
			  else{$chec_y = 'checked';} ?>
			  <div class="col-lg-2">
			  <label>Finalize Paper</label><br>
			  <span>
			<input type="radio" data-id="<?=$qpaper->id?>" name="finalize" value="1" style="width:19px;height:19px;" id="fin_y" <?=$chec_y?>>
			<span style="font-weight:bold; font-size:19px;">Yes</span>
			<input type="radio" data-id="<?=$qpaper->id?>" name="finalize" value="0" style="width:19px;height:19px;" id="fin_n" <?=$chec_n?>>
			<span style="font-weight:bold; font-size:19px;">No</span>
			</span>
			  </div>
			  <div class="col-lg-2 mt-4">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" id="finalize">Update</button>
        </div>
			  </div>
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
        }
		});	
		
		$('#finalize').click(function(){
		  var status = $('input[name=finalize]:checked').val();		
		  var id = $('input[name=finalize]:checked').data('id');
             var ele = $(this);		  
			if (status!='') {
            $.ajax({
                url: base_url + "coe/finalize_qp",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    status: status,
                    id: id,
                },
                success: function (data) {
					alert('Status Updated');
					ele.attr('checked','checked');
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