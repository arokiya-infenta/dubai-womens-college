
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Deposit</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Meal Money Deposit
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                    <div class="col-lg-12">
                    <form name="deposit" action="<?=base_url()?>hosteladminlogin/listDeposit"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <select class="form-control" name="person" required="">
                                            <?php echo $output;?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Amount</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input type="text" placeholder="Amount" class="form-control" name="amount" required>
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
                                        <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                    <div class="row">
                    <div class="col-lg-12">
                        <form name="apyment" action="<?=base_url()?>hosteladminlogin/listDeposit"  accept-charset="utf-8" method="post" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-info pull-right"  name="btnPrint" ><i class="fa fa-print"></i>Print</button>
                        </form>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($dep_list) > 0) { ?>
<div class="table-responsive">
 <table id="depositList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Deposit Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($dep_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$row->amount?></td>
                <td><?=$row->date?></td>
				<td><a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/updateDeposit/".$row->serial?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteDeposit/".$row->serial?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Meals Not Found!!!</h1>";
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
        $('#depositList').dataTable();


    });



</script>
