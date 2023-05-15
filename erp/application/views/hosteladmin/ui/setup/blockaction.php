
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Update Block</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Hostel Block Information
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form name="fees" action="<?=base_url()?>hosteladminlogin/updateBlock"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Block No</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i> </span>
                                                        <input type="text" placeholder="Block No" class="form-control" name="blockNo" value="<?php echo $data[0];?>" required>
														<input type="hidden" name="edit_id" value="<?php echo $data[3];?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Block Name</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                        <input type="text" placeholder="Block Name" class="form-control" name="blockName" value="<?php echo $data[1];?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Description</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                        <textarea rows="1" placeholder="Description" class="form-control" name="description" required><?php echo $data[2];?></textarea>
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

