
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
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>New Admission</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i> Admission Information
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form name="admission" action="<?=base_url()?>hosteladminlogin/studentAdmission" onsubmit="return checkForm(this);" accept-charset="utf-8" method="post" enctype="multipart/form-data">


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
                                            <label>Student Id(As Login Id)</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Student Id" class="form-control" name="stdId" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="cellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Email</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-envelope"></i> </span>
                                                <input type="email" placeholder="Email" class="form-control" name="email" required>
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
                                            <label>Photo</label>
                                            <div class="input-group">

                                                <input type="file" class="form-control" name="perPhoto" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Name Of Institute</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-building"></i> </span>
                                                <input type="text" placeholder="Name Of Institute" class="form-control" name="nameOfInst" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Program</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-book"></i> </span>
                                                <input type="text" placeholder="Program" class="form-control" name="program" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Batch No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i> </span>
                                                <input type="text" placeholder="Batch No" class="form-control" name="batchNo" required>
                                            </div>
                                        </div>
                                    </div>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <select class="form-control" name="bloodGroup" required="">

                                                         <option value="A(+)">A(+)</option>
                                                         <option value="A(-)">A(-)</option>
                                                        <option value="A(un)">A(unknown)</option>
                                                        <option value="B(+)">B(+)</option>
                                                <option value="B(-)">B(-)</option>
                                                <option value="B(un)">B(unknown)</option>
                                                <option value="AB(+)">AB(+)</option>
                                                <option value="AB(-)">AB(-)</option>
                                                <option value="AB(un)">AB(unknown)</option>
                                                <option value="O(+)">O(+)</option>
                                                <option value="O(-)">O(-)</option>
                                                <option value="O(un)">O(unknown)</option>
                                                         <option value="un">Unknown</option>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Nationality</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Nationality" class="form-control" name="nationality" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>National ID</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="National Id" class="form-control" name="nationalId" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Passport No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Passport No" class="form-control" name="passportNo">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Father Name</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Father Name" class="form-control" name="fatherName" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Father Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="fatherCellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Mother Name</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Mother Name" class="form-control" name="motherName" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Mother Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="motherCellNo" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Local Guardian</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                <input type="text" placeholder="Guardian Name" class="form-control" name="localGuardian" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Local Guardian Cell No</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                <input type="text" placeholder="Mobile No" class="form-control" name="localGuardianCell" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Present Address</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                <textarea rows="3" placeholder="Address" class="form-control" name="presentAddress" required> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Parmanent Address</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                <textarea rows="3" placeholder="Parmanent Address" class="form-control" name="parmanentAddress" required></textarea>
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