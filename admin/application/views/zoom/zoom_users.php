<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>MSSW - Admin</title>
  <!--favicon-->
  <link rel="icon" href="<?=base_url()?>white-version/image/th.ico" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="<?=base_url()?>white-version/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <!-- simplebar CSS-->
  <link href="<?=base_url()?>white-version/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="<?=base_url()?>white-version/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?=base_url()?>white-version/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?=base_url()?>white-version/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="<?=base_url()?>white-version/assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="<?=base_url()?>white-version/assets/css/app-style.css" rel="stylesheet"/>
  <link href="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

</head>

<body>

<!-- Start wrapper-->
<div id="wrapper">
<?php 
$stu_id=$srch['stu_id'];
?>
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<div class="clearfix"></div>
	
  <div class="content-wrapper" style="margin-left:0px!important;">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
	      <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
	    <div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
            <div class="card-header">Filter</div>
            <div class="card-body">
			
			<form action="" method="get">
		  <div class="row">
        <!--<div class="col-lg-3">
		  <div class="form-group">
		  <label>Zoom Title</label>
		  <select name="link_id" class="form-control" required>
		  <option>Select Title</option>
		  <?php $titl=$this->db->get('zoom')->result(); 
		  foreach($titl as $titl1){
		  ?>
		  <option value="<?php echo $titl1->id; ?>" <?php if($titl1->id==$link_id){echo 'selected';}?>><?php echo $titl1->title; ?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('link_id'); ?></span>
		  </div>
		  </div>-->
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>Students</label>
		  <select name="stu_id" class="form-control" required>
		  <option>Select Student</option>
		  <?php $stu=$this->db->get('zoom_alloc')->result(); 
		  foreach($stu as $stu1){
			  $stu_name=$this->db->where('pr_id',$stu1->student_id)->from('new_preview_pg')->get()->row();
		  ?>
		  <option value="<?php echo $stu1->student_id; ?>" <?php if($stu1->student_id==$stu_id){echo 'selected';}?>><?php echo $stu_name->pr_applicant_name; ?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('stu_id'); ?></span>
		  </div>
		</div>
		<div class="col-lg-3 mt-4">
		  <div class="form-group">
		  <button type="submit" name="submit" class="btn btn-sm btn-danger">Search</button>
		  <!--<button type="submit" name="submit_pdf" class="btn btn-sm btn-success">Download PDF</button>-->
		  </div>
		</div>
		  </div>
		  </form><br> 
			  
			</div>
		   </div>
		</div>
		</div>
	 

	 <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			   <h4>Students List</h4>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Zoom Title</th>
                        <th>Action</th>
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
                        <td><?php echo $stulist->title; ?></td>
                        <td>
						<a target="_blank" href="<?php echo $stulist->link; ?>">
						<button class="btn btn-success">Join Link</button></a>
						</td>
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
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
	
	<!--Start footer-->
	<footer class="footer" style="left:0px!important;">
      <div class="container">
        <div class="text-center">
      
        </div>
      </div>
    </footer>
	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  
  <script src="<?=base_url()?>white-version/assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/bootstrap.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<!-- simplebar js -->
	<script src="<?=base_url()?>white-version/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?=base_url()?>white-version/assets/js/waves.js"></script>
	<!-- sidebar-menu js -->
	<script src="<?=base_url()?>white-version/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

  <!--Data Tables js-->
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>
  
  </body>
</html>