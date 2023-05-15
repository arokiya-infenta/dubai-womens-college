
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Payment View</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Student Payment View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="apyment" action="<?=base_url()?>hosteladminlogin/listStudentPayment"  accept-charset="utf-8" method="post" enctype="multipart/form-data">
                        <div class="row" id="divview" style="display:<?php echo $display;?>">
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
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-success" name="btnUpdate" ><i class="fa fa-check-circle-o"></i>View</button>
                                            <button type="submit" class="btn btn-info" name="btnPrint" ><i class="fa fa-print"></i>Print</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <div id="editpayment" class="" style="display:none">
                        <form name="apyment" action="<?=base_url()?>hosteladminlogin/listStudentPayment"  accept-charset="utf-8" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-lg-12">
                                 <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Payment Date</label>
                                        <div class="input-group date" id='dp1'>

                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input id="paydate" type="text" placeholder="Payment Date" class="form-control datepicker" name="paydate" required  data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Paid By</label>
                                        <select id="payby" class="form-control" name="paidby" required="">

                                            <option value="Bank">Bank</option>
                                            <option value="DBBL">DBBL</option>
                                            <option value="Bkash">BKash</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Transection/Mobile No</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i> </span>
                                            <input id="transno" type="text" placeholder="Transecton or Mobile no" class="form-control" name="transno" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">


                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Amount</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-money"></i> </span>
                                            <input id="amount" type="text" placeholder="Amount" class="form-control" name="amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Remark</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input id="remark" type="text" placeholder="Additional Info" class="form-control" name="remark" required>
                                            <input id="edit_id" type="hidden" class="form-control" name="edit_id" required>
                                            <input id="stu_id" type="hidden" class="form-control" name="stu_id" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>&nbsp;</label>
                                        <div class="input-group">

                                            <button type="submit" class="btn btn-success pull-right" name="btnUpdatePay" ><i class="fa fa-2x fa-check"></i>Update</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                         </form>
                        </div>
<?php if(isset($pay_list)) { if(sizeof($pay_list) > 0) {?>
                        <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($pay_list) > 0) { ?>
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
      <?php    foreach($pay_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->name?></td>
                <td><?=$handyCam->getAppDate($row->transDate)?></td>
                <td><?=$row->paymentBy?></td>
                <td><?=$row->transNo?></td>
                <td><?=$row->amount?></td>
                <td><?=$row->remark?></td>
				<td><a title='Edit' data-stu='<?=$row->userId?>' class='btn btn-success btn-circle editBtn' href='#<?=$row->serial?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteStudentPayment/".$row->serial?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Payment Data Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>
<?php }} ?>


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
		var base_url='<?php echo base_url();?>';

        $('#paymentList').dataTable();
        $('.editBtn').on('click', function(){

            $('#divview').hide();
            $('#editpayment').show();

            var serial=$(this).attr('href').substring(1);
            var stu_id=$(this).data('stu');

            $('#paydate').val($(this).closest("tr").find("td").eq('1').text());
            $('#payby').val($(this).closest("tr").find("td").eq('2').text());
            $('#transno').val($(this).closest("tr").find("td").eq('3').text());
            $('#amount').val($(this).closest("tr").find("td").eq('4').text());
            $('#remark').val($(this).closest("tr").find("td").eq('5').text());
            $('#edit_id').val(serial);
            $('#stu_id').val(stu_id);

        });

        $("select option").filter(function() {

            return $(this).val() =='<?php echo $uid=$loginGrp;?>';
        }).prop('selected', true);

    });




</script>
