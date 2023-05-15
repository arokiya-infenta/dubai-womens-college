
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
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->id){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
                 <div class="col-lg-3">
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream1=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream1=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream1=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream1=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream1=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department1)){ $dept = $this->db->where('main_id',$stream1)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department1==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
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
		  <button type="button" class="btn btn-sm btn-success" id="ica1_submit">Save ICA1</button>
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>ICA1</th>
                        <th>ICA2</th>
                        <th>Take Home</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('student_id',$student->id)->get('erp_exammark')->row();
						if(isset($mark_det)){
						if($mark_det->ica1Mark!=''&&$mark_det->ica1Mark!=null){$checked1='checked';$readonly1='';}else{$checked1='';$readonly1='readonly';}
						}
						else{
							$checked1='';$readonly1='readonly';
							}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
						<?php //if($student->exempted_status==1){$check='checked';}else{$check='';}?>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="ica1" style="width:20px;height:20px;" <?=$checked1?>>
						<input type="text" class="form-control icaval1" <?=$readonly1?>>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="ica2" style="width:20px;height:20px;" <?=$checked1?>>
						<input type="text" class="form-control icaval2" <?=$readonly1?>>
						</td>
						<td>
						<input type="checkbox" data-student="<?=$student->id?>" class="takehome" style="width:20px;height:20px;" <?=$checked1?>>
						<input type="text" class="form-control thval" <?=$readonly1?>>
						</td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Name</th>
						<th>ICA1</th>
						<th>ICA2</th>
						<th>Take Home</th>
                        
                    
                    </tr>
                </tfoot>
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
		
		$(".ica1",allPages).change(function () {
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
                url: base_url + "coe/ICA1Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica1: ica1,icaval1: icaval1,main_id: main_id,course_id: course_id,ica1_not: ica1_not,
                },
                success: function (data) {
                }
            });
					alert('ICA1 Marks Added Successfully!!');
		}
		});
	});
	</script>