<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Verified Applicants <?=$this->session->userdata('user')['user_name']?></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example3" class="table table-bordered">
                <thead>
                    <tr>
                    <th>Candidate Name </th>
                        <th>Application Number </th>
                      
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                        <th>Reservation  Status</th>
                      
                        <th>Percentage</th>
                                         
                      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($student as $key => $value) { ?>
                        <tr>
            
                       
                        <td><a href="#"><?=strtoupper($value->pr_applicant_name)?> </a></td>
                        <td><?=$value->application_number?></td>
                
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                        <td><?=$value->special_reservation?></td>
                      <td><?=number_format((float)$value->percentage_obtained, 2, '.', '')?></td>
                     
                     
                
                        <td>
                        
                        <a   class="btn btn-sm btn-primary" href="<?=base_url()?>UgSelfFinance/updateStudent/<?=$value->stu_id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
						<input type="hidden" value="<?=$value->stu_id?>" name="ststu_id">
					<!--	<button type="submit" name="submit_pdf" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></button>-->
						<a href="<?=base_url()?>UgSelfFinance/updateStuContactInfo/<?=$value->stu_id?>" class="btn btn-sm btn-success"><i class="fa fa-address-book-o  fa-2x" aria-hidden="true"></i></a>
						<a href="<?=base_url()?>UgSelfFinance/studentPdf/<?=$value->stu_id?>" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o  fa-2x" aria-hidden="true"></i></a>
                 
                      
                      
                        </td>
                       
                       
                    </tr>
             

                
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                       <th>Candidate Name </th>
                        <th>Application Number </th>
                      
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                        <th>Reservation  Status</th>
                      
                        <th>Percentage</th>
                      
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>