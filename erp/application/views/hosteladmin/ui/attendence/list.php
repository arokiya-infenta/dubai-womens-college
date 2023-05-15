				
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Attendence List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Student Attendence
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="attendence" action="<?=base_url().'hosteladminlogin/updateAttendance'?>"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input id="name" type="text" placeholder="" class="form-control" name="person" disabled>
                                        <input id="stuid" type="hidden" placeholder="" class="form-control" name="edit_id">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group ">
                                        <label>Attend Date</label>
                                        <div class="input-group date" id='dp1'>

                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input id="attendDate" type="text" placeholder="Attend Date" disabled class="form-control datepicker" name="attendDate" required  data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Is Absence</label>
                                        <select id="abs" class="form-control" name="isabs" required="">

                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Is Leave</label>
                                        <select id="leave" class="form-control" name="isLeave" required="">

                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>Remark</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input id="remark" type="text" placeholder="Additional Info" class="form-control" name="remark" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>





                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-success" name="btnUpdate" ><i class="fa fa-2x fa-check"></i>Update</button>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Student Attendence List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($att_list) > 0) { ?>
<div class="table-responsive">
 <table id="attendenceList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Name</th>
                                             <th>Attend Date</th>
                                             <th>Is Absence</th>
                                             <th>Is Leave</th>
                                             <th>Remark</th>
                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($att_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$handyCam->getAppDate($row->date)?></td>
                <td><?=$row->isAbsence?></td>
                <td><?=$row->isLeave?></td>
                <td><?=$row->remark?></td>
                <td><a title='Edit' class='btn btn-success btn-circle editBtn' href='#<?=$row->serial?>' data-id='<?=$row->serial?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteAttendance/".$row->serial?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Attendance Data Not Found!!!</h1>";
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
        $('.datepicker').datepicker();
        $('#attendenceList').dataTable();

        $('.editBtn').on('click', function(){

           var serial=$(this).attr('href').substring(1);
           var name=$(this).closest("tr").find("td").eq('0').text();
           var stuid=$(this).data('id');


            $("#stuid").val(stuid);
            $("#name").val(name);
            $('#attendDate').val($(this).closest("tr").find("td").eq('1').text());
            $('#abs').val($(this).closest("tr").find("td").eq('2').text());
            $('#leave').val($(this).closest("tr").find("td").eq('3').text());
            $('#remark').val($(this).closest("tr").find("td").eq('4').text());

        });
    });




</script>
