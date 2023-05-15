<style>
input[type=checkbox]{
	height: 23px!important;
	width: 23px!important;
}
</style>
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
		  <div class="card-header"><i class="fa fa-table"></i>Student Elective</div>
            <div class="card-body">
			
			<form action="" method="POST">
			<div class="row mb-3">
			<div class="col-lg-3">
			<select class="form-control" name="course" id="course">
			<option <?php if($course1=='UG'){echo 'selected';}?>>UG</option>
			<option <?php if($course1=='PG'){echo 'selected';}?>>PG</option>
			<option <?php if($course1=='Diploma'){echo 'selected';}?>>Diploma</option>
			</select>
			</div>
			<div class="col-lg-3">
			<select class="form-control" name="subject" id="subject">
			<?php $sub = $this->db->where('subCatg','Elective')->get('erp_subjectmaster')->result();
			foreach($sub as $sub){ ?>
			<option value="<?=$sub->id?>" <?php if($subject1==$sub->id){echo 'selected';}?>><?=$sub->subName?></option>
			<?php } ?>
			</select>
			</div>
			<div class="col-lg-3">
			<button type="submit" class="btn btn-sm btn-success submit" name="submit">Submit</button>
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
		<div>
		</div>
		<div style="float:right">
		<button class="btn btn-md btn-info stu_elective" id="stu_elective">Add Students for Elective</button>
		</div>
		<div style="float:right">
		<input type="checkbox" id="select_all" style="margin-top:12px;">&nbsp;&nbsp;
		</div>
		</div>
		<div class="card-body">
              <div class="table-responsive">
              <table id="elective-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Student Name</th>
                        <th>Action</th>
                        <th>Delete</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $stu_list) {
						if($stu_list->pr_applicant_name!=''){
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stu_list->pr_applicant_name?></td>
						<?php if($stu_list->pr_elective==$subject1) {$checked='checked';} else {$checked='';} ?>
                        <td><input data-student="<?=$stu_list->pr_id?>" <?=$checked?> type="checkbox"></td>
						<td>
						<?php if($stu_list->pr_elective==$subject1){ $style='style="color:red;font-size:23px;cursor:pointer;display:block;"'; } else {$style='style="color:red;font-size:23px;cursor:pointer;display:none;"';} ?><i data-student="<?=$stu_list->pr_id?>" class="fa fa-trash delete" <?=$style?>></i>
						</td>
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
$(document).ready(function() {
var myTable = $('#elective-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();	

$('body').on('click', '#select_all', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
    });
	
	$(document).on("click", ".stu_elective", function() { 
	
	var subject = $('#subject').val();
	var course = $('#course').val();
	var ids=Array();
 
	$("input[type=checkbox]:checked", allPages).each(function(){
    ids.push($(this).data('student'));
      });
	  
		if(ids.length>0){
		$.ajax({
			url: "<?php echo base_url();?>coe/update_elective",
			method: "POST",
			cache: false,
			data:{
				//type: 2,
				id: ids,
				subject: subject,
				course: course,
			},
			//dataType: 'html',
			success: function(dataResult){
				alert('Electives Added to Students!!');
				$("input[type=checkbox]:checked", allPages).each(function(){
                 $(this).parent().parent().find('i').css('display','block');
               });
				//location.reload();
			}
		});
		}
		else{
			alert('Please Select Students!!');
		}
	});
	
	$(document).on("click", ".delete", function() { 
	
	if(confirm('Are You Sure to Delete?')){
	var subject = $('#subject').val();
	var course = $('#course').val();
	var id1=$(this,allPages).data('student');
	var $ele = $(this,allPages);
	$ele.parent().parent().find('input[type=checkbox]').attr('checked', false);
	$ele.remove();
	  
		$.ajax({
			url: "<?php echo base_url();?>coe/delete_elective",
			method: "POST",
			cache: false,
			data:{
				//type: 2,
				id: id1,
				subject: subject,
				course: course,
			},
			//dataType: 'html',
			success: function(dataResult){
				alert('Electives Deleted Successfully!!');
			}
		});
	}
	});
});
</script>