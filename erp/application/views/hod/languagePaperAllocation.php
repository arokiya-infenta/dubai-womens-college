
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
		  <div class="card-header"><i class="fa fa-table"></i>Student Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-3" id="sub">
			  <select class="form-control" id="subject" name="subject" required>
			   <?php if(isset($subject1)){ 
			   if($stream==2 OR $stream==3){$this->db->where('department=1 OR department=2 OR department=3');}
	           else{$this->db->where('department',$department);}
			   $sub_list = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('sem',$sem1)->where('(part=1 OR part=4)')->get('erp_subjectmaster')->result();
			   foreach($sub_list as $sublist){ 
			  ?>
			  <option value="<?=$sublist->id?>" <?php if($subject1==$sublist->id){echo 'selected';}?>><?=$sublist->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
				 <div class="col-lg-3 mt-1">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			   <div class="row">
                 <div style="float:right">
				 <button type="button" class="btn btn-sm btn-warning" id="submit">Allocate Subject</button>
				 </div>
			   </div>	   
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="studentleft-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Reg No.</th>
                        <th>Allot</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
                        <td><?=$student->reg_no_?></td>
						<?php if($student->status==1){$check='checked';}else{$check='';}?>
                        <td><input type="checkbox" data-student="<?=$student->id?>" class="allot" <?=$check?>></td>
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
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
var myTable = $('#studentleft-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();

		$('#batch,#sem').change(function(){
			$('#subject').empty();
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "hod/getSubjectLanguagewise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    sem: sem,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			$('#subject').empty();
		}
		});
		
		$('#submit').click(function(){
			if(confirm('Are you sure to allocate the subjects?')){
		var ids_alloted=Array();	
		var ids_not_alloted=Array();	
		var subject="<?php echo $subject1;?>";	
		var batch="<?php echo $batch1;?>";	
		var sem="<?php echo $sem1;?>";	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=allot]:checked').each(function(){
            ids_alloted.push($(this).data('student'));
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=allot]:not(:checked)').each(function(){
            ids_not_alloted.push($(this).data('student'));
            });
		});
            $.ajax({
                url: base_url + "hod/langAllot",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ids_alloted: ids_alloted,
                    ids_not_alloted: ids_not_alloted,
                    subject: subject,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					alert('Subject Allocated Successfully!!');
                }
            });
			}
		});
	});
	</script>