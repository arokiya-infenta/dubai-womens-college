
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
		  <div class="card-header"><i class="fa fa-table"></i> ICA Not Initiated</div>
            <div class="card-body">
			
			<form action="" method="post">
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
				 <!--<div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>-->
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
			
	  <?php if($_POST){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="notInitiated" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $subject = $this->db->where('batch_year',$batch1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
					$sno=1;
					foreach ($subject as $subject1) {
			  $coe_stat = $this->db->where('batch',$batch1)->where('subject_id',$subject1->id)->where('main_id',$stream)->where('course_id',$department)->get('erp_ica_to_coe')->row();
			  if((isset($coe_stat) && $coe_stat->status == 0) || (!isset($coe_stat))){ 
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$subject1->subCode?></td>
                        <td><?=$subject1->subName?></td>
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
$("input[type=checkbox]",allPages).each(function () {
	$(this).css('display','none');
	$(this).siblings().attr('readonly', 'readonly');
	});	
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
		
		
/*$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		$(".ica1",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".ica2",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".inclass",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".takehome",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	
		$('#ica1_submit').click(function(){
		var ica1=Array();	
		var ica1_not=Array();	
		var icaval1=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica1]:checked').each(function(){
            ica1.push($(this).data('student'));
            icaval1.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica1]:not(:checked)').each(function(){
            ica1_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA1Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica1: ica1,icaval1: icaval1,main_id: main_id,course_id: course_id,ica1_not: ica1_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('ICA1 Marks Added Successfully!!');
		}
		});
		
		$('#ica2_submit').click(function(){
		var ica2=Array();	
		var ica2_not=Array();	
		var icaval2=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica2]:checked').each(function(){
            ica2.push($(this).data('student'));
            icaval2.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica2]:not(:checked)').each(function(){
            ica2_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA2Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica2: ica2,icaval2: icaval2,main_id: main_id,course_id: course_id,ica2_not: ica2_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('ICA2 Marks Added Successfully!!');
		}
		});
		
		$('#ic_submit').click(function(){
		var inclass=Array();	
		var inclass_not=Array();	
		var icval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=inclass]:checked').each(function(){
            inclass.push($(this).data('student'));
            icval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=inclass]:not(:checked)').each(function(){
            inclass_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/inClassMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    inclass: inclass,icval: icval,main_id: main_id,course_id: course_id,inclass_not: inclass_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('In Class Marks Added Successfully!!');
		}
		});
		
		$('#th_submit').click(function(){
		var takehome=Array();	
		var takehome_not=Array();	
		var thval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=takehome]:checked').each(function(){
            takehome.push($(this).data('student'));
            thval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=takehome]:not(:checked)').each(function(){
            takehome_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/takeHomeMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    takehome: takehome,thval: thval,main_id: main_id,course_id: course_id,takehome_not: takehome_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('Take Home Marks Added Successfully!!');
		}
		});*/
	});
	</script>