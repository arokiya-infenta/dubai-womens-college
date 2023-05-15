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
            <div class="card-header"><i class="fa fa-table"></i>Subject</div>
			<div class="card-body">
              <form action="" method="POST">
            <div class="row">
			  <div class="col-lg-3">
          <label>Batch</label>
		  <select class="form-control" name="batch">
		  <option value="">Select Batch</option>
		  <?php foreach($batch_list as $batch){?>
			  <option value="<?=$batch->id?>" <?php if($batch1==$batch->id){echo 'selected';}?>><?=$batch->batch_from?></option>
		  <?php } ?>
		  </select>
			  </div>
          <div class="col-lg-3">
          <label>Semester</label>
		  <select class="form-control" name="sem">
		  <option value="">Select Sem</option>
		  <?php $semst = array('1','2','3','4','5','6');foreach($semst as $semst){?>
			  <option value="<?=$semst?>" <?php if($sem1==$semst){echo 'selected';}?>><?=$semst?></option>
		  <?php } ?>
		  </select>
			  </div>			  
			  <div class="col-lg-9">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="batch_submit">Submit</button>
        </div>
			  </div>
            </div>
	
              </form>
			</div>  
			</div>
		  </div>
      </div>
	  
	  <!--Start Row-->
			
	  <?php if($_POST){if(sizeof($sub_list)>0){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><i class="fa fa-table"></i>Subject</div>
            <div class="card-body">
			<div class="row mb-3">
			<div class="col-lg-3">
			<a href="<?=base_url().'coe/addSubject/'.$batch_id?>">
			<button class="btn btn-sm btn-success edit_subject">Add Subject</button></a>
			</div>
			</div>
              <div class="table-responsive">
              <table id="subject-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Regulation</th>
                        <th>Policy</th>
                        <th>Semester</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($sub_list as $subject) {
						if($subject->sem==$sem){
						$reg = $this->db->where('id',$subject->regulation)->get('erp_regulation')->row();
						$pol = $this->db->where('id',$subject->policy)->get('erp_subpolicy')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$subject->subName?></td>
                        <td><?=$subject->subCode?></td>
                        <td><?=$reg->name?></td>
                        <td><?=$pol->name?></td>
                        <td>Sem <?=$subject->sem?></td>
                        <td><a href="<?=base_url().'coe/editSubject/'.$subject->id?>">
						<button class="btn btn-sm btn-warning">Edit</button></a>
						<!--<a href="<?=base_url().'coe/deleteSubject/'.$subject->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>-->
						</td>
                    </tr>
                    <?php }} ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Regulation</th>
                        <th>Policy</th>
                        <th>Semester</th>
                        <th>Action</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } else {?>
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><div class="row mb-3">
			<div class="col-lg-2">
			<form action="<?=base_url().'coe/createSubject'?>" method="post">
			<button type="submit" class="btn btn-sm btn-success" onClick="return(confirm('Are you sure to Add the Subjects?'))">Create Subject</button>
			<input type="hidden" value="<?=$batch_id?>" name="batch_edit">
			</form>
			</div>
			<div class="col-lg-3">
			<a href="<?=base_url().'coe/addSubject/'.$batch_id?>">
			<button class="btn btn-sm btn-success" style="margin-left:-50px;">Add Subject</button></a>
			</div>
			</div></div>
		  </div>
		</div>
       </div> 		
	  <?php }} ?>
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