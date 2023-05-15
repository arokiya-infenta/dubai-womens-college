<?php
$userid = $this->session->userdata('user')['user_id'];
$user = $this->db->where('id',$userid)->get('erp_employee_master')->row();
$name=$user->emp_name_;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>hostelassets/dist/css/datepicker.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>hostelassets/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/dataTable.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/timepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/calendar.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/custom_2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>hostelassets/dist/css/app.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
	.footer-section {
   position:absolute;
   bottom:0;
   width:100%;
   height:60px;   /* Height of the footer */
}
</style>
</head>

<body>

<div id="wrapper">

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms">Bill Print</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-success">
                    <i class="fa fa-info-circle fa-fw"></i>Bill Info of <label class="text-success">[<?php echo $billId?>]</label>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12">
                            <div class="col-lg-6">
                                <p class=" text-info text-left"><strong>Bill To:</strong> <?php echo $billInfo[0]; ?></p>
                                </div>
                            <div class="col-lg-6">
                                <p class=" text-info text-right"><strong>Bill Date:</strong> <?php echo $billInfo[1]; ?></p>
                                </div>


                            </div>
                        </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php  if(sizeof($bill_single) > 0) { ?>
<div class="table-responsive">
 <table id="billList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Bill Type</th>

                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($bill_single as $row ) { $isData="1";
	  ?>
                <tr>
				<td><?=$row->type?></td>
                <td><?=$row->amount?></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Bill Not Found!!!</h1>";
                             }
							 ?>

                            </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="col-lg-12">


                            <div class="col-lg-6">
                                <p class="text-right"><strong>Total Amount: </strong><strong><?php echo number_format((float)$billInfo[2], 2, '.', '').'/-';?></strong></p>

                            </div>
                            </div>

                            </div>


                        </div>

            </div>
                </div>

        </div>

    </div>

</div>
<!-- /#page-wrapper -->


<section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   &copy;Hostel Management System |<a href="https://iStudiotech.com/" target="_blank"  > Designed by : iStudiotech</a> 
                </div>

            </div>
        </div>
    </section>

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/bootstrap-datepicker.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>hostelassets/dist/js/sb-admin-2.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/dataTable.js"></script>
<script src="<?php echo base_url();?>hostelassets/dist/js/timepicker.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {

        $('#billList').dataTable();
    });

</script>
