
<div id="page-wrapper">
<div class="row">
<?php if($this->session->flashdata('error')!="") {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
</div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Student List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Student List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
      <form name="admission" action="<?=base_url()?>hosteladminlogin/listStudentAdmission" onsubmit="return checkForm(this);" accept-charset="utf-8" method="post" enctype="multipart/form-data">


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-lg-4">
                                        <div class="form-group ">
                                            <div class="input-group">

                                                <button class="btn btn-success" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                   </div>
                                </div>
                          </form>

					<?php if(isset($adm_list)) {?>
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($adm_list) > 0) { ?>
<div class="table-responsive">
 <table id="studentList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                           <th>Name</th>
                                            <th>Mobile No</th>
                                            <th>Institute</th>
                                             <th>Program</th>
                                            <th>L.Guardian</th>
                                           <th>L.G. Mobile</th>
                                           <th>P.Address</th>
                                           <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($adm_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$row->cellNo?></td>
                <td><?=$row->nameOfInst?></td>
                <td><?=$row->program?></td>
                <td><?=$row->localGuardian?></td>
                <td><?=$row->localGuardianCell?></td>
                <td><?=$row->presentAddress?></td>
				<td><a title='View' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/viewStudentAdmission/".$row->userId?>'><i class='fa fa-file-o'></i></a>
				<!--<a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/updateStudentAdmission/".$row->userId?>'><i class='fa fa-pencil'></i></a><a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteStudentAdmission/".$row->userId?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a>--></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Student data Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>
					<?php } ?>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->

<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {



        $('#studentList').dataTable();
    });




</script>