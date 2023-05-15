
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Update Salary</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Update Employee Salary[<?php echo $data[0];?>]
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="payment" action="<?=base_url()?>hosteladminlogin/updateSalary"  accept-charset="utf-8" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                     <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Salary Month</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                                    <input type="text" placeholder="Salary Month" class="form-control datepicker" name="monthyear" value="<?php echo $data[1];?>" required>
													<input type="hidden" name="edit_id" value="<?php echo $data[3];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Amount</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Amount" class="form-control" name="amount" value="<?php echo $data[2]; ?>" required>
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
                    </div>


                </div>
            </div>

        </div>

    </div>

<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.datepicker').datepicker({
            format: "MM-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });


    });

</script>






