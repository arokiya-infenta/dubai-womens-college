
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Payment Approval List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Student Payment Approval List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">





                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($appr_list) > 0) { ?>
<form action="<?=base_url()?>hosteladminlogin/approvePayment" method="post">							
<div class="table-responsive">
 <table id="paymentList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Name</th>
                                             <th>Payment Date</th>
                                             <th>Paid By</th>
                                             <th>Transection/Mobile No</th>
                                             <th>Amount</th>
                                             <th>Remark</th>
                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($appr_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$handyCam->getAppDate($row->transDate)?></td>
                <td><?=$row->paymentBy?></td>
                <td><?=$row->transNo?></td>
                <td><?=$row->amount?></td>
                <td><?=$row->remark?>
				<input type="hidden" value="<?=$row->serial?>" name="edit_id">
				</td>
				<td><button type="submit" name="approve" title='Approve' class='btn btn-info btn-circle' onclick="return confirm('Are you sure to approve?');"><i class='fa fa-check'></i></button></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
							</form>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Payment Data Not Found!!!</h1>";
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

        $('#paymentList').dataTable();


    });




</script>
