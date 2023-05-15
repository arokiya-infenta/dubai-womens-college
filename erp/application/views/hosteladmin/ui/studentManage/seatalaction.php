
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Update Seat</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Update Student Seat Alocation[<?php echo $data[3];?>]
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="seat" action="<?=base_url()?>hosteladminlogin/updateSeatAllocation"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Block No</label>
                                                <select class="form-control" name="blockNo" required="">

                                                    <?php echo $output1;?>

                                                </select>
												<input type="hidden" name="edit_id" value="<?php echo $data[3];?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Room No</label>
                                                <select class="form-control" name="roomNo" required="">
                                                    <?php echo $output2;?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Monthly Rent</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Monthly Rent" class="form-control" name="mrent" value="<?php echo $data[2];?>" required>
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









