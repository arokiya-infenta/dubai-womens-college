
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
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Time Set</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Hostel Time Set <span id="lblmsg"> (Click On Clock Icon)</span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form name="mealrate" action="<?=base_url()?>hosteladminlogin/addTimeset"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                    <div class="row">
                                        <div class="col-lg-12">



                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>In Time</label>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input type="text" id="timepicker2" name="start_time" data-default-time="false" placeholder="h:mm AM"  class="form-control"  value="<?php echo $data[0];?>" required>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Out Time</label>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input type="text" id="timepicker1" name="end_time" data-default-time="false" placeholder="h:mm AM"  class="form-control"  value="<?php echo $data[1];?>" required>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
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
        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();


    });
</script>
