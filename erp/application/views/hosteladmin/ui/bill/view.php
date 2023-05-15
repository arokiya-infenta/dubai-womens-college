
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Billing View</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Bill List View

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($bill_list) > 0) { ?>
<div class="table-responsive">
 <table id="billList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Bill Id</th>
                                             <th>Name</th>
                                            <th>Amount</th>

                                             <th>Bill Date</th>
											 <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($bill_list as $row ) { $isData="1";?>
                <tr>
				<td><?=$row->billId?></td>
                <td><?=$row->name?></td>
                <td><?=$row->amount?></td>
                <td><?=$row->date?></td>
				<td><a class='bill_id' href='<?=base_url()."hosteladminlogin/singleBill/".$row->billId?>' title='View Details'><button type="button" class="btn btn-success btn-circle"><i class='fa fa-eye'></i></button></a>
				<a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/actionBill/".$row->billId?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteBill/".$row->billId?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
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

                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header alert alert-info">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 id="myModalLabel" class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-6">
                                           <div class=""><label>Bill No: </label> <span id="billId"></span></div>
                                            </div> <div class="col-lg-6">
                                           <div class=""><label>Bill Date: </label> <span id="billDate"></span></div>
                                            </div>
                                            </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                        <table id="mbilllist" class="table table-responsive table-hover text-center">
                                            <thead >
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            </table>
                                            <div class="text-info"><label>Total: </label> <span id="total"></span></div>
                                        </div>

                                    </div>
                                <p></p>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-primary" type="button">Close</button>

                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->



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

        $('#billList').dataTable();
        $('.showModal').on('click', function(e) {
			$("#myModal").modal('hide');

            e.preventDefault();

           var table =document.getElementById('billList');
            var r =  $(this).parent().parent().index();
           var BillTo =table.rows[r+1].cells[1].innerHTML;
            var billId=table.rows[r+1].cells[0].childNodes[0].text;
            var date = table.rows[r+1].cells[3].innerHTML;
            var t = table.rows[r+1].cells[2].innerHTML;
            $('#myModalLabel').text("Billing Info of ["+BillTo+"]");
            $('#billId').text(billId);
            $('#billDate').text(date);
            $('#total').text(t);


            value = new Array();
            $.ajax({
                type: "GET",
                url: base_url + 'hosteladminlogin/getBill',
                dataType: 'json',
                success: function (result) {
                    alert(result);
                }

            });
          //  $("#myModal").modal('show');


        });
    });




</script>