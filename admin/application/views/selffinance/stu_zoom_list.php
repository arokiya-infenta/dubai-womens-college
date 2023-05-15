<?php 
$start_date=empty($srch['start_date']) ? '' : date('Y-m-d',strtotime($srch['start_date']));
$end_date=empty($srch['end_date']) ? '' : date('Y-m-d',strtotime($srch['end_date']));
?>
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	



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
        <div class="col-lg-3">
		  <div class="form-group">
		  <label>From Date</label>
		  <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
		  <span style="color:red;"><?php echo form_error('start_date'); ?></span>
		  </div>
		  </div>
		<div class="col-lg-3">
		  <div class="form-group">
		  <label>To Date</label>
		  <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
		  <span style="color:red;"><?php echo form_error('end_date'); ?></span>
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
	 

	 <?php if(isset($stu_list)){
     
  
     ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
            <h4>Panel Wise - Interview List</h4>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <!--<table id="default-datatable" class="table table-bordered">-->
			  <table id="example2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Zoom Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total Student</th>
                        <th>Published Status</th>    
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php if(isset($stu_list)){
					$sno=1;
					foreach($stu_list as $stulist)
					{

               
   $mts =   $this->db->select("*")->from("zoom_alloc")->where("link_id",$stulist->link_id)->get();
     
   $nts = $mts->num_rows();
				?>
                    <tr>
                        <td><?php echo $sno;?></td>
                        <td><?php echo $stulist->title; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($stulist->alc_date)); ?></td>
                        <td><?php echo date("H:i",strtotime($stulist->alc_time)); ?></td>
                        <td><?php echo $nts; ?></td>
                        <td><?php if($stulist->confirm_status == 1){

echo"Published";

                        }else{

echo "Not Published";

                        } ?></td>
                        <td>
						<a href="<?php echo base_url().'pgSelfFinance/stu_zoom_list_det/'.$stulist->link_id; ?>">
						<button class="btn  btn-danger" data-id=""><i class="fa fa-eye" aria-hidden="true"></i></button></a>
            
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?=$sno?>">
            <i class="fa fa-envelope" aria-hidden="true"></i>
  </button>
            
						</td>
                    </tr>


                    <div class="modal fade" id="myModal<?=$sno?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Email Panel -: <?php echo $stulist->title; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post" action="<?=base_url()?>PgSelfFinance/panelEmail">
      
      <div class="modal-body">
      <input type ="hidden" name="panel_id" value="<?=$stulist->link_id?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email Subject</label>
            <input type="text" class="form-control" name="email_subject" required id="recipient-name">
          </div>
          <div class="form-group">
      
  <label class="col-form-label " required for="recipient-name">Email Content </label>
  <div class="col-md-12">
 <textarea  class="form-control" required name="email_content"></textarea>
   
  </div>
  </div>

 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Publish Email</button>
        
      </div>
      </form>
        
      </div>
    </div>
  </div>
  
</div>



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