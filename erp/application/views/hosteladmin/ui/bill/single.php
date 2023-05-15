
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Bill Info</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-success">
                    <i class="fa fa-info-circle fa-fw"></i>Bill Info of <label class="text-success">[<?php echo $billId?>]</label>
                    <a class="btn btn-info pull-right" href="<?=base_url()?>hosteladminlogin/listBill"><i class="fa fa-reply">Back To View</i></a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12">
                            <div class="col-lg-6">
                                <p class=" text-info text-left"><strong>Bill To:</strong> <?php echo $billInfo[0]; ?></p>
                                </div>
                            <div class="col-lg-6">
                                <p class=" text-info text-right"><strong>Bill Date:</strong> <?php echo $billInfo[1]; ?></p>
                                </div>


                            </div>
                        </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php  if(sizeof($bill_single) > 0) { ?>
<div class="table-responsive">
 <table id="billList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Bill Type</th>

                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($bill_single as $row ) { $isData="1";
	  ?>
                <tr>
				<td><?=$row->type?></td>
                <td><?=$row->amount?></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Bill Not Found!!!</h1>";
                             }
							 ?>

                            </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-6">
                              <form action="<?=base_url()?>hosteladminlogin/singleBill" method="post" enctype="multipart/form-data">
							      <input type="hidden" value="<?=$billId?>" name="bill_id">
                                  <button class="btn btn-info" type="submit" name="btnPrint"><i class="fa fa-print">Print</i></button>
                              </form>
                                </div>

                            <div class="col-lg-6">


                        <div class="col-lg-6">
                            <p class="text-right"><strong>Total Amount:</strong></p>

                        </div>
                            <div class="col-lg-6">
                                <p class="text-left"><strong><?php echo number_format((float)$billInfo[2], 2, '.', '').'/-';?></strong></p>

                            </div>
                            </div>

                            </div>


                        </div>

            </div>
                </div>

        </div>

    </div>

<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>



