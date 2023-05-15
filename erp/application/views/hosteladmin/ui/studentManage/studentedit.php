
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Update Student</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i>Update Student Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="student" action="<?=base_url()?>hosteladminlogin/updateStudentAdmission" onsubmit="return checkForm(this);" accept-charset="utf-8" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Full Name</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                    <input type="text" placeholder="Full Name" class="form-control" name="name" value="<?php echo $data[0];?>" required>
													<input type="hidden" name="edit_id" value="<?php echo $data[21];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Student Id(As Login Id)</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Student Id" class="form-control" name="stdId" value="<?php echo $data[1];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Cell No</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                    <input type="text" placeholder="Mobile No" class="form-control" name="cellNo" value="<?php echo $data[2];?>" required>
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
                                                    <input type="email" placeholder="Email" class="form-control" name="email" value="<?php echo $data[3];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Password</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                                    <input type="password" id="password" placeholder="" value="<?php echo $data[22];?>" class="form-control" name="password" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Confirm Password</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-key"></i> </span>
                                                    <input type="password" id="rePassword" placeholder="" value="<?php echo $data[22];?>" class="form-control" name="rePassword" required>
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

                                                    <input type="file" class="form-control" name="perPhoto">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Name Of Institute</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-building"></i> </span>
                                                    <input type="text" placeholder="Name Of Institute" class="form-control" name="nameOfInst" value="<?php echo $data[4];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Program</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-book"></i> </span>
                                                    <input type="text" placeholder="Program" class="form-control" name="program" value="<?php echo $data[5];?>" required>
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
                                                    <input type="text" placeholder="Batch No" class="form-control" name="batchNo" value="<?php echo $data[6];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender" required="">
                                                    <?php
                                                    if($data[7]==="Male")
                                                    {
                                                        echo ' <option value="Male" selected>Male</option>';
                                                       echo '<option value="Female">Female</option>';
                                                    }
                                                    else{
                                                        echo ' <option value="Male" >Male</option>';
                                                        echo '<option value="Female" selected>Female</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Date Of Birth</label>
                                                <div class="input-group date" id='dp1'>

                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                                    <input type="text" placeholder="Date Of Birth" class="form-control datepicker" name="dob" value="<?php echo $data[8];?>" required  data-date-format="dd/mm/yyyy">
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
                                                    <?php
                                                    if($data[9]==="A(+)")
                                                    {
                                                      echo  '<option value="A(+)" selected>A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                    echo  ' <option value="A(un)">A(unknown)</option>';
                                                     echo  '<option value="B(+)">B(+)</option>';
                                                     echo  '<option value="B(-)">B(-)</option>';
                                                    echo  ' <option value="B(un)">B(unknown)</option>';
                                                    echo  ' <option value="AB(+)">AB(+)</option>';
                                                    echo  ' <option value="AB(-)">AB(-)</option>';
                                                    echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                    echo  ' <option value="O(+)">O(+)</option>';
                                                     echo  '<option value="O(-)">O(-)</option>';
                                                     echo  '<option value="O(un)">O(unknown)</option>';
                                                     echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="A(-)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)" selected>A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="A(un)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)" selected>A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="B(+)")
                                                    {
                                                        echo  '<option value="A(+)" >A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)" selected>B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="B(-)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)" selected>B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="B(un)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)" >A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)" selected>B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="AB(+)")
                                                    {
                                                        echo  '<option value="A(+)" >A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)" >B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)" selected>AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="AB(-)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)" >B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)" selected>AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="AB(un)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)" >A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)" >B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)" selected>AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="O(+)")
                                                    {
                                                        echo  '<option value="A(+)" >A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)" >B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)" selected>O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="O(-)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)">A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)" >B(-)</option>';
                                                        echo  ' <option value="B(un)">B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)" selected>O(-)</option>';
                                                        echo  '<option value="O(un)">O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    elseif($data[9]==="O(un)")
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)" >A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)" >B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)" selected>O(unknown)</option>';
                                                        echo  '<option value="un">Unknown</option>';
                                                    }
                                                    else
                                                    {
                                                        echo  '<option value="A(+)">A(+)</option>';
                                                        echo  ' <option value="A(-)">A(-)</option>';
                                                        echo  ' <option value="A(un)" >A(unknown)</option>';
                                                        echo  '<option value="B(+)">B(+)</option>';
                                                        echo  '<option value="B(-)">B(-)</option>';
                                                        echo  ' <option value="B(un)" >B(unknown)</option>';
                                                        echo  ' <option value="AB(+)">AB(+)</option>';
                                                        echo  ' <option value="AB(-)">AB(-)</option>';
                                                        echo  ' <option value="AB(un)">AB(unknown)</option>';
                                                        echo  ' <option value="O(+)">O(+)</option>';
                                                        echo  '<option value="O(-)">O(-)</option>';
                                                        echo  '<option value="O(un)" >O(unknown)</option>';
                                                        echo  '<option value="un" selected>Unknown</option>';
                                                    }

                                                    ?>


                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Nationality</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Nationality" class="form-control" name="nationality" value="<?php echo $data[10];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>National ID</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="National Id" class="form-control" name="nationalId" value="<?php echo $data[11];?>" required>
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
                                                    <input type="text" placeholder="Passport No" class="form-control" name="passportNo" value="<?php echo $data[12];?>" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Father Name</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                    <input type="text" placeholder="Father Name" class="form-control" name="fatherName" value="<?php echo $data[13];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Father Cell No</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                    <input type="text" placeholder="Mobile No" class="form-control" name="fatherCellNo" value="<?php echo $data[14];?>" required>
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
                                                    <input type="text" placeholder="Mother Name" class="form-control" name="motherName" value="<?php echo $data[15];?>" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Mother Cell No</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-mobile-phone"></i> </span>
                                                    <input type="text" placeholder="Mobile No" class="form-control" name="motherCellNo" value="<?php echo $data[16];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Local Guardian</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-leaf"></i> </span>
                                                    <input type="text" placeholder="Guardian Name" class="form-control" name="localGuardian" value="<?php echo $data[17];?>" required>
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
                                                    <input type="text" placeholder="Mobile No" class="form-control" name="localGuardianCell" value="<?php echo $data[18];?>" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Present Address</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                    <textarea rows="3" placeholder="Address" class="form-control" name="presentAddress" required><?php echo $data[19];?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Parmanent Address</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-road"></i> </span>
                                                    <textarea rows="3" placeholder="Parmanent Address" class="form-control" name="parmanentAddress" required><?php echo $data[20];?></textarea>
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






