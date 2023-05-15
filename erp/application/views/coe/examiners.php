
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
			<i class="fa fa-table"></i> Examiners Details
			</div>
            <div class="card-body">
			<div class="row mb-3">
			<div class="col-lg-3">
			<a href="<?=base_url().'coe/examinersAdd'?>">
			<button class="btn btn-sm btn-success edit_subject">Add Examiners</button></a>
			</div>
			</div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  
	  <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
			<div class="card-body">
			<?php if(isset($examiner_list)){?>
			<div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>First Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>College</th>
                        <th>Mobile</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($examiner_list as $examiner) {
						if($examiner->department_id!=0){
						$dept_det = $this->db->where('id',$examiner->department_id)->get('erp_dept_type')->row();
						$dept_name = $dept_det->name_;
						}else{
						$dept_name = '-';	
						}
						if($examiner->designation == 'external_academician'){$design = 'External Academecian';}
						else{$design = 'Field Practitioner';}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$examiner->first_name?></td>
                        <td><?=$design?></td>
                        <td><?=$dept_name?></td>
                        <td><?php echo $examiner->college?></td>
                        <td><?php echo $examiner->mobile?></td>
                        <td>
						<a href="<?=base_url(). 'coe/examinersEdit/'.$examiner->id?>">
						<button class="btn btn-sm btn-warning update" data-id="<?=$examiner->id?>" type="button">Edit</button></a>
						<a href="<?=base_url(). 'coe/examinersDelete/'.$examiner->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>
						</td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
            </table>
            </div>
			<?php } ?>
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
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>