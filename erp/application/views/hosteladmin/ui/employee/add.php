
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>New Employee</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Employee Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="admission" action="<?=base_url()?>hosteladminlogin/addEmployee" onsubmit="return checkForm(this);" accept-charset="utf-8" method="post" enctype="multipart/form-data">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Full Name</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                            <input type="text" placeholder="Full Name" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Password</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                            <input type="password" id="password" placeholder="" class="form-control" name="password" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Confirm Password</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                            <input type="password" id="rePassword" placeholder="" class="form-control" name="rePassword" required>
                                        </div>
                                    </div>

                                </div>

                                </div>
                            </div>

                        <div class="row">
                            <div class="col-lg-12">

                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Cell No(As Login Id)</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="cellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Employee Type</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input type="text" placeholder="Eg: Care Taker" class="form-control" name="empType" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Designation</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input type="text" placeholder="Eg: Asistant Care" class="form-control" name="designation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" required="">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Date Of Birth</label>
                                        <div class="input-group date" id='dp1'>

                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input type="text" placeholder="Date Of Birth" class="form-control datepicker" name="dob" required  data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Join Date</label>
                                        <div class="input-group date" id='dp1'>

                                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                            <input type="text" placeholder="Join Date" class="form-control datepicker" name="doj" required  data-date-format="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Block No</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-building"></i> </span>
											<select class="form-control" name="blockNo" required="">
                                            <?php echo $output1;?>

                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Salary</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                            <input type="text" placeholder="Salary" class="form-control" name="salary" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Photo</label>
                                        <div class="input-group">

                                            <input type="file" class="form-control" name="perPhoto" required>
                                        </div>
                                    </div>

                                </div>

                                </div>
                            </div>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="col-lg-4">
                                    <div class="form-group ">
                                        <label>Address</label>
                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                            <textarea rows="3" placeholder="Address" class="form-control" name="presentAddress" required> </textarea>
                                        </div>
                                    </div>
                                </div>




                                </div>
                            </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <label id="lblmsg" class="red"></label>
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
        $('.datepicker').datepicker();


    });
    function checkForm(form) {

        var password = document.getElementById("password")
            , confirm_password = document.getElementById("rePassword");
        console.log(password.value);
        console.log(confirm_password.value);
        if(password.value != confirm_password.value) {

            $("#lblmsg").text("**Passwords Don't Match");

            return false;
        } else {

            return true;
        }

    }


</script>