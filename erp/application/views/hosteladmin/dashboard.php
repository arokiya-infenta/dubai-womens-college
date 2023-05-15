
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Dashboard<i class="fa fa-hand-o-left"></i></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo  $totals[1];?></div>
                                <div>Total Employee</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ui/employee/view.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo  $totals[0];?></div>
                                <div>Current Student</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ui/studentManage/studentlist.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-building fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totals[2];?></div>
                                <div>Total Rooms</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ui/setup/room.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-maxcdn fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totals[3];?></div>
                                <div>Today's Meal</div>
                            </div>
                        </div>
                    </div>
                    <a href="./ui/meal/view.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <i class="fa fa-list-alt fa-fw"></i>Notice Board
                    </div>
                    <div class="panel-body">
                        <div id="accordion" class="panel-group">
                           <?php foreach ($data as $row) {


                           echo  '<div class="panel panel-success">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#'.$row->serial.'" data-parent="#accordion" data-toggle="collapse" aria-expanded="false" class="collapsed">'.$row->title.'&nbsp;['.$row->date.']</a>';
                           echo         '</h4>
                                </div>
                                <div class="panel-collapse collapse" id="'.$row->serial.'" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">';
                                    echo $row->description;
                                 echo    '</div></div></div>';


                            }
                           ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                       <label>Top 4 notice</label>
                           <a href="./ui/notice/create.php" class="pull-right">

                                <span class="pull-left">View All</span>&nbsp;
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                        <div class="custom-calendar-wrap">
                            <div id="custom-inner" class="custom-inner">
                                <div class="custom-header clearfix">
                                    <nav>
                                        <span id="custom-prev" class="custom-prev"></span>
                                        <span id="custom-next" class="custom-next"></span>
                                    </nav>
                                    <h2 id="custom-month" class="custom-month"></h2>
                                    <h2 id="custom-year" class="custom-year"></h2>
                                </div>
                                <div id="calendar" class="fc-calendar-container"></div>

                            </div>
                        </div>


                </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
