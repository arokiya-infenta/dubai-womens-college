<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Interview Scheduled User</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Interview Date Time</th>
                        <th>User</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { ?>
                      <tr>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_date))?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_interview_date))?> <?=date('h:i A',strtotime($value->sa_interview_time))?></td>
                        <?php  if($value->sa_interview_attended_status == null){ ?>

                          <td>New User</td>

                          <?php }else{ ?>
                          <td>Reschedule User</td>

                          <?php } ?>
                        
                        <td>
                        <a href="<?=site_url()?>/Admin/viewProfile/<?=$value->sa_st_id?>" class="btn btn-primary">View Profile</a>
                       
                        </td>

                        
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Interview Date Time</th><th>User</th>
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