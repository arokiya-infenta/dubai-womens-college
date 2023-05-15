
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
			<i class="fa fa-table"></i> File Upload
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
            <div class="card-body">
			<form action="" method="POST" enctype="multipart/form-data">
              <div class="row mt-3">  
			  <?php if(isset($syll_templ)){ 
			  $syllabus1 =  $syll_templ->syllabus;
			  $template1 =  $syll_templ->template;
			  $edit_id =  $syll_templ->id;
			  //if($template != ''){$style = 'display:block;';}else{
			  //$style = 'display:none;';}
			  if($syllabus1 != ''){$syllabus2 = explode('/',$syll_templ->syllabus); $syllabus = $syllabus2[3];}else{
			  $syllabus = '';}
			  if($template1 != ''){$template2 = explode('/',$syll_templ->template); $template = $template2[3];}else{
			  $template = '';}
			  }else{
			  $syllabus1 = '';
			  $template1 = '';
			  $syllabus = '';
			  $template = '';
			  $edit_id = '';  
			  $style = 'display:none;';  
			  } ?>
			  <div class="col-lg-4">
			  <label>Syllabus</label>
			  <input type="file" class="form-control" name="syllabus" id="syllabus" accept="application/pdf">
			  <input type="hidden" class="form-control" name="stream" value="<?php echo $stream ?>">
			  <input type="hidden" class="form-control" name="department" value="<?php echo $department ?>">
			  <input type="hidden" class="form-control" name="sem" value="<?php echo $sem1 ?>">
			  <input type="hidden" class="form-control" name="batch" value="<?php echo $batch1 ?>">
			  <input type="hidden" class="form-control" name="subject" value="<?php echo $subject1 ?>">
			  <input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?php echo $edit_id ?>">
		  <a href="<?=base_url().$syllabus1;?>" target="_blank"><p><?=$syllabus?></p></a>
			  </div>
			  <div class="col-lg-4">
			  <label>Template</label>
		  <input type="file" class="form-control" name="template" id="template" accept="application/pdf">
			<!--<img id="imgPreview" src="<?=base_url().$template;?>" alt="pic" style="width:150px;height:150px;<?=$style?>"/>-->
			<a href="<?=base_url().$template1;?>" target="_blank"><p><?=$template?></p></a>
			  </div>
			  <div class="col-lg-4">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="upload">Upload</button>
        </div>
			  </div>
			  </div>
			  </form>
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
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>	
$(document).ready(()=>{
      $('#template').change(function(){
        const file = this.files[0];
        console.log(file);
        if (file){
			$('#imgPreview').css('display','block');
          let reader = new FileReader();
          reader.onload = function(event){
            console.log(event.target.result);
            $('#imgPreview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
        }else{
			$('#imgPreview').css('display','none');
		}
      });
    });			
</script>