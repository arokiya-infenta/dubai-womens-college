
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Employee List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Employee List View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($emp_list) > 0) { ?>
<div class="table-responsive">
 <table id="empList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                             <th>Employee Type</th>
                                            <th>Designation</th>
                                            <th>Join Date</th>
                                             <th>Salary</th>
                                             <th>Block No</th>
                                             <th>Address</th>

                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($emp_list as $row ) { $isData="1";?>
                <tr>
                <td><img class='perPhoto' src='<?php echo base_url().$row->perPhoto?>'></td>
                <td><?=$row->name?></td>
                <td><?=$row->gender?></td>
                <td><?=$row->empType?></td>
                <td><?=$row->designation?></td>
                <td><?=$handyCam->getAppDate($row->doj)?></td>
                <td><?=$row->salary?></td>
                <td><?=$row->blockNo?></td>
                <td><?=$row->address?></td>
				<td><a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/updateEmployee/".$row->empId?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteEmployee/".$row->empId?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Employee Data Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>


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



        $('#empList').dataTable();
    });




</script>