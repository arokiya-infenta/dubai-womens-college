<!DOCTYPE HTML>
<html>
<head>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
</head>
<body>	
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	 <?php if(isset($stu_list)){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
			<span style="float:left;padding-right:250px;">
			<img src="./system/images/logo.png" style="height:100px;width:100px;"></span>
			<span>
			<p>MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)</p>
			<p>32, Casa Major Road, Egmore, Chennai-600008</p>
		    <p>Interview Schedule For <?php echo $this->session->userdata('user')['user_name'];?> Department</p>
			</span><br><br>
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>UG</th>
                        <th>Marks</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Community</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(isset($stu_list)){
					$sno=1;
					foreach($stu_list as $stulist)
					{
				?>
                    <tr>
                        <td><?php echo $sno;?></td>
                        <td><?php echo $stulist->stu_name; ?></td>
                        <td><?php echo $stulist->stu_dob; ?></td>
						<td><?php echo $stulist->ug_perc; ?></td>
						<td><?php echo $stulist->total_mark; ?></td>
                        <td><?php echo $stulist->title; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($stulist->alc_date)); ?></td>
						<td><?php echo $stulist->stu_comm; ?></td>
                    </tr>
					<?php $sno++;}}?>
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	 <?php } ?>
	  <!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	
<style>

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
th, td {
	border: 1px solid #dddddd;
  text-align: left;
padding: 12px 25px;
}
tr:nth-child(even) {
background-color: #f2f2f2;
}

</style>
</body>
</html>