
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Salary Add</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Employee Salary Payment
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="bill" action="<?=base_url()?>hosteladminlogin/addSalary"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Employee Name</label>
                                        <select class="form-control" name="empId" required="">
                                            <?php echo $output1;?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Month</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input type="text" placeholder="Salary Month" class="form-control datepicker" name="monthyear" required>
                                        </div>
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
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                    </div>

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
        $('.datepicker').datepicker({
            format: "MM-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });


    });

</script>