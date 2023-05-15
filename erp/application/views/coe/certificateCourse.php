<?php 
$batch1 = isset($batch_id) ? $batch_id : ''; 
$sem1 = isset($sem) ? $sem : ''; 
?>
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
            <div class="card-header"><i class="fa fa-table"></i>Certificate Courses</div>
			<div class="card-body">
			<div class="row mb-3">
			<div class="col-lg-3">
			<a href="<?=base_url().'coe/addCertificateCourse'?>">
			<button class="btn btn-sm btn-success edit_subject">Add Course</button></a>
			</div>
			</div>
             <?php if(sizeof($sub_list)>0){?>
              <div class="table-responsive">
              <table id="subject-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Part</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($sub_list as $subject) {
						$reg = $this->db->where('id',$subject->regulation)->get('erp_regulation')->row();
						$pol = $this->db->where('id',$subject->policy)->get('erp_subpolicy')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$subject->subName?></td>
                        <td><?=$subject->subCode?></td>
                        <td><?=$subject->subCatg?></td>
                        <td><?=$subject->part?></td>
                        <td><a href="<?=base_url().'coe/editCertificateCourse/'.$subject->id?>">
						<button class="btn btn-sm btn-warning">Edit</button></a>
						<a href="<?=base_url().'coe/deleteCertificateCourse/'.$subject->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>
						</td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Part</th>
                        <th>Action</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
			<?php }?>
			</div>  
			</div>
		  </div>
      </div>
	  
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
</script>