<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    <!--<?=var_dump($student);?>-->



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

					<!--Results for UG -->
					<?php if(isset($applied) && $course==1){ ?>

					<?php } ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Application Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exampleexport"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Requested Certificate</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Batch</th>
                <th>Title</th>
                <th>Request Date</th>
               
               
              
                <th>Action</th>
                        
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
          

                    $s=1;

                    foreach ($requested_certificate as $key => $value) { 
                      
       
                      ?>
                        <tr>
                        <td><?=$s++?> 
									</td>
                      
									<td><?=$value->sc_name?></td>
									<td><?=$value->u_name?></td>
									<td><?=$value->sr_department?></td>
									<td><?=$value->sr_batch?></td>
                <td><?=$value->sr_title?></td>
                <td><?=date("d-M-y",strtotime($value->sr_req_date))?></td>
             
               
                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CertificateRequest<?=$value->s_r_id?>" >Upload</button>
							
							  <?php if($value->sr_upload !=""){ ?>
                    


							<a href="<?=base_url()?>student_document_upload/<?=$value->sr_upload?>" target="_blank" class="btn btn-primary">Download</a>
							
							<?php } ?>
							
							</td>
               
                       
                       
                    </tr>
										<div class="modal fade" id="CertificateRequest<?=$value->s_r_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Document - <?=$value->u_name?> (<?=$value->sc_name?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form method="post" action="<?=base_url()?>Admin/uploadRequestedCertificate" enctype="multipart/form-data">
  
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-3 col-form-label">Purpose</label>
    <div class="col-sm-9">
      <input type="file" class="form-control" id="inputPassword3" name="upload_certificate" placeholder="Upload">
      <input type="hidden" class="form-control" id="inputPassword3" name="request_id" value="<?=$value->s_r_id?>">
    </div>
  </div>
 
    <div class="form-group row">
	<label class="col-sm-3 col-form-label" for="inlineFormCustomSelect">Certificate</label>
      <div class="col-sm-9">
	 <textarea class="form-control" name="comments"></textarea>
      </div>
    </div>

   <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Request</button>
    </div>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>
	                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
         
								<th>S.No</th>
                        <th>Requested Certificate</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Batch</th>
                <th>Title</th>
                <th>Request Date</th>
               
               
             
                <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
 
   
 		
			

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->

    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    