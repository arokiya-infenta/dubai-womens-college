
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Payment Add</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Payment  Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="bill" action="<?=base_url()?>hosteladminlogin/addVendorPayment"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                <div class="form-group ">
                                    <label>Payment To</label>
                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-user"></i> </span>
                                        <input type="text" placeholder="Eg: Person Name" class="form-control" name="paymentTo" required>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Amount</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-money"></i> </span>
                                            <input type="text" placeholder="Amount" class="form-control" name="amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Payment By</label>
                                        <select class="form-control" name="paymentBy" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>

                                        </select>
                                    </div>
                                </div>

                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Description</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <textarea rows="2"  placeholder="Description" class="form-control" name="description" required></textarea>
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



    });



</script>